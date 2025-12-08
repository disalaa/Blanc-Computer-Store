from flask import Flask, request, jsonify
from flask_cors import CORS
from dotenv import load_dotenv
from groq import Groq
import os
import pymysql
from datetime import datetime
import uuid

# Load environment variables
load_dotenv()

app = Flask(__name__)
CORS(app, resources={r"/*": {"origins": "*"}})

# ========== CONFIG ==========
AI_PROVIDER = os.getenv("AI_PROVIDER", "groq").lower()
GROQ_API_KEY = os.getenv("GROQ_API_KEY")
DB_HOST = "localhost"
DB_USER = "root"
DB_PASS = ""
DB_NAME = "blanc"

if AI_PROVIDER != "groq" or not GROQ_API_KEY:
    raise ValueError("Set AI_PROVIDER=groq and GROQ_API_KEY in your .env file")

# Initialize Groq client
client = Groq(api_key=GROQ_API_KEY)

# In-memory conversation storage (use database for production)
conversations = {}

# ========== CONNECT TO DATABASE ==========
def get_connection():
    return pymysql.connect(
        host=DB_HOST,
        user=DB_USER,
        password=DB_PASS,
        database=DB_NAME,
        cursorclass=pymysql.cursors.DictCursor
    )

# ========== NEW SESSION ENDPOINT ==========
@app.route('/new-session', methods=['POST'])
def new_session():
    """Create a new chat session"""
    session_id = str(uuid.uuid4())
    conversations[session_id] = {
        'messages': [],
        'created_at': datetime.now()
    }
    return jsonify({"session_id": session_id})

# ========== AI CHAT ENDPOINT ==========
@app.route('/chat', methods=['POST'])
def chat():
    data = request.get_json()
    user_message = data.get("message", "")
    session_id = data.get("session_id")

    if not user_message:
        return jsonify({"error": "Message is empty"}), 400
    
    # Create new session if none provided
    if not session_id or session_id not in conversations:
        session_id = str(uuid.uuid4())
        conversations[session_id] = {
            'messages': [],
            'created_at': datetime.now()
        }

    try:
        print(f"Session: {session_id} | Message: {user_message}")
        
        # Get conversation history for this session
        conversation_history = conversations[session_id]['messages']
        
        # 🔍 Enhanced product category detection
        category_keywords = {
            "cpu": ["cpu", "processor", "ryzen", "intel", "core i", "amd", "i3", "i5", "i7", "i9"],
            "gpu": ["gpu", "graphics card", "rtx", "radeon", "video card", "3060", "4060", "4070", "4090", "rx"],
            "ram": ["ram", "memory", "ddr4", "ddr5", "16gb", "32gb", "8gb"],
            "motherboard": ["motherboard", "mobo", "mainboard", "b550", "b650", "z690"],
            "mouse": ["mouse", "mice", "gaming mouse"],
            "keyboard": ["keyboard", "mechanical keyboard", "gaming keyboard"],
            "storage": ["ssd", "hdd", "nvme", "storage", "hard drive", "m.2", "1tb", "2tb", "512gb"],
            "psu": ["psu", "power supply", "watt", "650w", "750w", "850w"],
            "case": ["case", "casing", "chassis", "tower", "pc case"],
            "cooler": ["cooling", "cooler", "fan", "cpu cooler", "aio", "liquid cooling", "air cooler", "thermal", "noctua", "corsair cooler"],
            "headset": ["headset", "headphones", "earphones", "earbuds", "gaming headset"],
            "speaker": ["speaker", "speakers", "sound system", "audio", "woofer"],
            "monitor": ["monitor", "display", "screen", "144hz", "1080p", "1440p", "4k"]
        }
        
        # Check for ANY component mention
        found_categories = []
        for category, keywords in category_keywords.items():
            for keyword in keywords:
                if keyword.lower() in user_message.lower():
                    if category not in found_categories:
                        found_categories.append(category)
                    break

        display_products = []  # Products to show in frontend
        all_products = []  # All products for AI context
        product_context = ""
        
        # 🚨 ONLY fetch products if user is asking about specific components or builds
        needs_products = any([
            any(keyword in user_message.lower() for keyword in ["recommend", "suggest", "need", "want", "looking for", "build", "pc", "computer"]),
            len(found_categories) > 0,  # Specific component mentioned
            any(word in user_message.lower() for word in ["price", "cost", "how much", "budget", "cheap", "expensive", "show", "list"])
        ])

        if needs_products:
            connection = get_connection()
            with connection.cursor() as cursor:
                # Always get ALL products for AI context
                sql_all = "SELECT pid, pname, price, img, category FROM products"
                cursor.execute(sql_all)
                all_products = cursor.fetchall()
                
                if found_categories:
                    # 🎯 For frontend: ONLY show products from mentioned categories
                    placeholders = ','.join(['%s'] * len(found_categories))
                    sql = f"SELECT pid, pname, price, img, category FROM products WHERE category IN ({placeholders})"
                    cursor.execute(sql, found_categories)
                    display_products = cursor.fetchall()
                else:
                    # If asking about general PC build, show nothing (let AI guide them)
                    display_products = []
                    
            connection.close()
            
            # 🚨 Build comprehensive product context for AI (includes ALL products)
            product_context = "\n\n=== AVAILABLE PRODUCTS IN OUR STORE ===\n"
            
            # Group by category for better readability
            categories = {}
            for p in all_products:
                cat = p.get('category', 'Other')
                if cat not in categories:
                    categories[cat] = []
                categories[cat].append(p)
            
            for cat, items in sorted(categories.items()):
                product_context += f"\n[{cat.upper()}]\n"
                for p in items[:15]:  # Limit to 15 per category to save tokens
                    product_context += f"• {p['pname']} - ${p['price']}\n"
                if len(items) > 15:
                    product_context += f"... and {len(items) - 15} more {cat} items\n"
            
            product_context += "\n⚠️ THESE ARE THE ONLY PRODUCTS AVAILABLE. DO NOT RECOMMEND ANYTHING ELSE!\n"
        else:
            # For greetings/general chat, don't load products yet
            product_context = "\n\nNote: Product inventory will be loaded when user asks about specific components or builds."

        # Build conversation messages
        messages = [
            {"role": "system", "content": f"""You are a professional PC build advisor chatbot for a computer store named Blanc. Your job is to help users build their perfect PC by asking questions ONE AT A TIME.

IMPORTANT CONVERSATION RULES:
1. Ask ONE question at a time - keep it conversational and friendly
2. Start by greeting NEW users and asking about their primary use case (gaming, work, content creation, etc.)
3. Then ask follow-up questions based on their answers:
   - What's their budget?
   - What games/software will they use?
   - What resolution/refresh rate do they want?
   - Do they need peripherals (monitor, keyboard, mouse)?
   - Any brand preferences (AMD/Intel, NVIDIA/AMD)?
4. Only provide a full PC build recommendation after you have enough information
5. Keep responses short and conversational (2-4 sentences max unless giving final recommendations)
6. Be enthusiastic and helpful!
7. When you have enough info, recommend specific parts from our inventory
8. IMPORTANT: Remember what the user has already told you. Don't ask questions they've already answered!

🚨 CRITICAL PRODUCT RECOMMENDATION RULES:
- YOU MUST ONLY recommend products from the list below
- NEVER make up product names, prices, or specifications
- ALWAYS use the EXACT product names and prices from the list
- If a user asks for something not in the list, say: "We don't currently have that in stock, but here are similar options..." and suggest alternatives from our inventory
- If NO products match what they need, be honest: "I don't see that specific item in our current inventory."
- NEVER invent products not explicitly listed below
- When mentioning prices, use the EXACT prices from the product list
- DO NOT recommend products unless they are explicitly listed in the available products section below
- When recommending products, mention 2-3 specific options from the list, don't just list everything

{product_context}

Remember: You can ONLY recommend what's in the list above. Be helpful but HONEST about availability."""}
        ]
        
        # Add conversation history (last 10 messages to save tokens)
        messages.extend(conversation_history[-10:])
        
        # Add current user message
        messages.append({"role": "user", "content": user_message})

        # Generate AI response
        completion = client.chat.completions.create(
            model="llama-3.3-70b-versatile",
            messages=messages,
            temperature=0.5,
            max_tokens=1024
        )

        ai_reply = completion.choices[0].message.content
        print(f"AI Reply: {ai_reply}")
        
        # Save messages to conversation history
        conversations[session_id]['messages'].append({"role": "user", "content": user_message})
        conversations[session_id]['messages'].append({"role": "assistant", "content": ai_reply})

        return jsonify({
            "reply": ai_reply,
            "products": display_products,  # 🎯 Only returns relevant products to frontend
            "session_id": session_id
        })

    except Exception as e:
        print(f"Error: {e}")
        return jsonify({"error": str(e)}), 500

# ========== GET CONVERSATION HISTORY ==========
@app.route('/history/<session_id>', methods=['GET'])
def get_history(session_id):
    """Get conversation history for a session"""
    if session_id in conversations:
        return jsonify({
            "messages": conversations[session_id]['messages'],
            "created_at": conversations[session_id]['created_at'].isoformat()
        })
    return jsonify({"error": "Session not found"}), 404

# ========== CLEAR SESSION ==========
@app.route('/clear/<session_id>', methods=['DELETE'])
def clear_session(session_id):
    """Clear a conversation session"""
    if session_id in conversations:
        del conversations[session_id]
        return jsonify({"message": "Session cleared"})
    return jsonify({"error": "Session not found"}), 404


if __name__ == "__main__":
    app.run(port=5000, debug=True)