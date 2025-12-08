<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blanc AI PC Build Assistant</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
body{
  background:#000;
  color:#fff;
  height:100vh;
  display:flex;
  flex-direction:column;
  overflow:hidden;
}

/* ========== MAIN LAYOUT ========== */
.main-layout{
  display:flex;
  flex:1;
  height:100vh;
  overflow:hidden;
  position:relative;
}
.main-layout::before{
  content:'';
  position:absolute;
  inset:0;
  border:1px solid rgba(255,255,255,0.05);
  animation:glowShift 8s linear infinite;
}
@keyframes glowShift{
  0%{box-shadow:0 0 15px rgba(255,255,255,0.05);}
  50%{box-shadow:0 0 40px rgba(255,255,255,0.1);}
  100%{box-shadow:0 0 15px rgba(255,255,255,0.05);}
}

/* ========== SIDEBAR ========== */
.sidebar{
  width:320px;
  flex-shrink:0;
  background:#0a0a0a;
  border-right:1px solid #1a1a1a;
  display:flex;
  flex-direction:column;
  justify-content:space-between;
  backdrop-filter:blur(8px);
  position:relative;
  z-index:5;
}
.sidebar::after{
  content:'';
  position:absolute;
  top:0;bottom:0;right:0;
  width:1px;
  background:linear-gradient(180deg,transparent,rgba(255,255,255,0.3),transparent);
  animation:slideVertical 3s linear infinite;
}
@keyframes slideVertical{
  0%{transform:translateY(-100%);}
  100%{transform:translateY(100%);}
}

/* ========== BRAND ========== */
.brand{
  padding:40px 30px;
  border-bottom:1px solid #222;
}
.brand-title{
  font-size:1.8em;
  font-weight:600;
  letter-spacing:-0.5px;
  background:linear-gradient(90deg,#fff,#999,#fff);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
  background-size:200%;
  animation:shine 5s linear infinite;
}
@keyframes shine{
  0%{background-position:-200px;}
  100%{background-position:200px;}
}
.brand-subtitle{
  font-size:0.85em;
  color:#888;
  font-weight:300;
}

/* ========== SIDEBAR CONTENT ========== */
.session-info{
  padding:30px;
  flex:1;
  overflow-y:auto;
}
.info-section{margin-bottom:30px;}
.info-label{
  font-size:0.75em;
  text-transform:uppercase;
  letter-spacing:1.5px;
  color:#666;
  margin-bottom:10px;
}
.info-value{
  font-size:0.95em;
  color:#fff;
  line-height:1.6;
}

/* ========== BUTTONS ========== */
.session-actions{
  padding:30px;
  border-top:1px solid #222;
}
.action-btn{
  width:100%;
  padding:14px;
  background:transparent;
  border:1px solid #333;
  color:#fff;
  font-size:0.9em;
  cursor:pointer;
  transition:all 0.3s ease;
  margin-bottom:12px;
  position:relative;
  overflow:hidden;
}
.action-btn:hover{
  background:#fff;
  color:#000;
}
.action-btn.danger{
  color:#888;
}
.action-btn.danger:hover{
  background:#fff;
  color:#000;
}

/* ========== CHAT AREA ========== */
.chat-area{
  flex:1;
  display:flex;
  flex-direction:column;
  background:radial-gradient(circle at top,#0a0a0a 0%,#000 100%);
  position:relative;
}
.chat-header{
  padding:30px 60px;
  border-bottom:1px solid #111;
  background:#0a0a0a;
  position:sticky;
  top:0;
  z-index:10;
}
.chat-title{
  font-size:1.1em;
  font-weight:500;
  color:#fff;
}

/* ========== CHAT MESSAGES (scrollable) ========== */
.chat-messages{
  flex:1;
  overflow-y:auto;
  padding:50px 60px;
  display:flex;
  flex-direction:column;
  gap:40px;
  scroll-behavior:smooth;
}
.message{
  display:flex;
  flex-direction:column;
  animation:fadeInUp 0.4s ease;
}
@keyframes fadeInUp{
  from{opacity:0;transform:translateY(20px);}
  to{opacity:1;transform:translateY(0);}
}
.message-label{
  font-size:0.7em;
  text-transform:uppercase;
  letter-spacing:2px;
  color:#777;
  margin-bottom:10px;
}
.message-content{
  font-size:1em;
  line-height:1.8;
  color:#fff;
  font-weight:300;
  max-width:900px;
  transition:opacity 0.3s ease;
}
.message-content:hover{opacity:0.85;}

/* ========== PRODUCT CARDS ========== */
.products{
  margin-top:30px;
  display:grid;
  gap:16px;
  max-width:900px;
}
.product-card{
  display:flex;
  justify-content:space-between;
  align-items:center;
  border:1px solid #1a1a1a;
  background:#0a0a0a;
  padding:20px 24px;
  border-radius:8px;
  transition:all 0.3s ease;
}
.product-card:hover{
  border-color:#333;
  background:#111;
  box-shadow:0 0 12px rgba(255,255,255,0.08);
}
.product-details{
  display:flex;
  flex-direction:column;
  gap:6px;
}
.product-name{font-weight:500;color:#fff;}
.product-price{font-weight:300;color:#888;}
.product-link{
  padding:10px 20px;
  border:1px solid #333;
  color:#fff;
  text-decoration:none;
  font-size:0.85em;
  transition:all 0.3s ease;
}
.product-link:hover{
  background:#fff;
  color:#000;
}

/* ========== INPUT AREA ========== */
.chat-input-area{
  padding:30px 60px;
  border-top:1px solid #111;
  background:#0a0a0a;
  position:sticky;
  bottom:0;
  z-index:10;
}
.input-wrapper{
  display:grid;
  grid-template-columns:1fr auto;
  gap:16px;
  max-width:1000px;
}
.chat-input{
  padding:16px 24px;
  background:#000;
  border:1px solid #222;
  color:#fff;
  outline:none;
  font-size:0.95em;
  transition:0.3s;
}
.chat-input:focus{
  border-color:#555;
  box-shadow:0 0 10px rgba(255,255,255,0.05);
}
.input-btn{
  padding:16px 32px;
  background:transparent;
  border:1px solid #333;
  color:#fff;
  font-weight:500;
  cursor:pointer;
  transition:all 0.3s ease;
}
.input-btn:hover{
  background:#fff;
  color:#000;
}

/* ========== TYPING INDICATOR ========== */
.typing-indicator{
  display:flex;
  align-items:center;
  gap:12px;
  animation:fadeInUp 0.4s ease;
}
.typing-dots{
  display:flex;
  gap:6px;
}
.typing-dot{
  width:5px;height:5px;background:#666;border-radius:50%;
  animation:pulse 1.4s infinite;
}
.typing-dot:nth-child(2){animation-delay:0.2s;}
.typing-dot:nth-child(3){animation-delay:0.4s;}
@keyframes pulse{0%,80%,100%{opacity:0.3;}40%{opacity:1;}}

@media(max-width:1024px){
  .main-layout{flex-direction:column;}
  .sidebar{display:none;}
  .chat-messages{padding:30px;}
}
</style>
</head>
<body>
<div class="main-layout">
  <!-- SIDEBAR -->
  <div class="sidebar">
    <div>
      <div class="brand">
        <div class="brand-title">BLANC</div>
        <div class="brand-subtitle">PC BUILD ASSISTANT</div>
      </div>
      <div class="session-info">
        <div class="info-section"><div class="info-label">System Status</div><div class="info-value">Active</div></div>
        <div class="info-section"><div class="info-label">Session ID</div><div class="info-value" id="sessionDisplay">Not connected</div></div>
        <div class="info-section"><div class="info-label">Capabilities</div><div class="info-value">Component Selection<br>Budget Analysis<br>Compatibility Check<br>Performance Optimization</div></div>
      </div>
    </div>
    <div class="session-actions">
      <button class="action-btn" onclick="exportChat()">Export Conversation</button>
      <button class="action-btn danger" onclick="closeChat()">End Session</button>
    </div>
  </div>

  <!-- CHAT -->
  <div class="chat-area">
    <div class="chat-header"><div class="chat-title">Build Consultation</div></div>
    <div class="chat-messages" id="chatMessages">
      <div class="message bot">
        <div class="message-label">System</div>
        <div class="message-content">
          Welcome to Blanc. Let's begin building your ideal PC. What will you primarily use it for—gaming, productivity, or content creation?
        </div>
      </div>
    </div>
    <div class="chat-input-area">
      <div class="input-wrapper">
        <input type="text" class="chat-input" id="messageInput" placeholder="Type your message..." onkeypress="if(event.key==='Enter'){event.preventDefault();sendMessage();}">
        <button class="input-btn" id="sendBtn" onclick="sendMessage()">Send</button>
      </div>
    </div>
  </div>
</div>

<script>
let sessionId = localStorage.getItem('chatSessionId');
const API_URL = 'http://127.0.0.1:5000/chat';
const BASE_URL = 'http://127.0.0.1:5000';
const chatMessages = document.getElementById('chatMessages');
const messageInput = document.getElementById('messageInput');
const sendBtn = document.getElementById('sendBtn');
const sessionDisplay = document.getElementById('sessionDisplay');

updateSessionDisplay();
if(sessionId) loadHistory();

function updateSessionDisplay(){
  sessionDisplay.textContent = sessionId ? sessionId.substring(0,16)+'...' : 'Not connected';
}

async function loadHistory(){
  try{
    const res=await fetch(`${BASE_URL}/history/${sessionId}`);
    if(res.ok){
      const data=await res.json();
      chatMessages.innerHTML='';
      data.messages.forEach(m=>addMessage(m.content,m.role==='user'?'user':'bot',[]));
    }
  }catch(e){console.error('History error:',e);}
}

async function sendMessage(){
  const msg=messageInput.value.trim();
  if(!msg)return;
  messageInput.disabled=true;sendBtn.disabled=true;
  addMessage(msg,'user');
  messageInput.value='';
  showTyping();
  try{
    const res=await fetch(API_URL,{
      method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({message:msg,session_id:sessionId})
    });
    const data=await res.json();
    if(data.session_id){
      sessionId=data.session_id;
      localStorage.setItem('chatSessionId',sessionId);
      updateSessionDisplay();
    }
    hideTyping();
    if(data.error)addMessage('An error occurred: '+data.error,'bot');
    else addMessage(data.reply,'bot',data.products||[]);
  }catch(e){
    hideTyping();
    addMessage('Connection issue. Ensure the AI server is running.','bot');
  }
  messageInput.disabled=false;sendBtn.disabled=false;messageInput.focus();
}

function addMessage(text,sender,products=[]){
  const msg=document.createElement('div');
  msg.className=`message ${sender}`;
  const label=document.createElement('div');
  label.className='message-label';
  label.textContent=sender==='user'?'You':'System';
  const content=document.createElement('div');
  content.className='message-content';
  content.textContent=text;
  msg.appendChild(label);
  msg.appendChild(content);
  if(products?.length){
    const list=document.createElement('div');
    list.className='products';
    products.forEach(p=>{
      const url=`http://localhost/blanc/sproduct.php?pid=${p.pid}`;
      const card=document.createElement('div');
      card.className='product-card';
      card.innerHTML=`
        <div class="product-details">
          <div class="product-name">${p.pname}</div>
          <div class="product-price">$${p.price}</div>
        </div>
        <a href="${url}" target="_blank" class="product-link">View Product</a>
      `;
      list.appendChild(card);
    });
    content.appendChild(list);
  }
  chatMessages.appendChild(msg);
  chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
}

function showTyping(){
  const t=document.createElement('div');
  t.className='message bot typing-indicator';
  t.id='typingIndicator';
  t.innerHTML=`
    <div class="message-label">System</div>
    <div class="typing-dots">
      <div class="typing-dot"></div>
      <div class="typing-dot"></div>
      <div class="typing-dot"></div>
    </div>
  `;
  chatMessages.appendChild(t);
  chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
}
function hideTyping(){
  const t=document.getElementById('typingIndicator');
  if(t)t.remove();
}
async function closeChat(){
  if(!sessionId)return;
  if(!confirm('End this session?'))return;
  await fetch(`${BASE_URL}/clear/${sessionId}`,{method:'DELETE'});
  localStorage.removeItem('chatSessionId');
  sessionId=null;
  updateSessionDisplay();
  chatMessages.innerHTML='<div class="message bot"><div class="message-content">Session ended. Thank you for using Blanc.</div></div>';
}
function exportChat(){
  const messages=Array.from(chatMessages.querySelectorAll('.message')).map(m=>{
    const label=m.querySelector('.message-label')?.textContent||'';
    const content=m.querySelector('.message-content')?.textContent||'';
    return `${label}: ${content}`;
  }).join('\n\n');
  const blob=new Blob([messages],{type:'text/plain'});
  const url=URL.createObjectURL(blob);
  const a=document.createElement('a');
  a.href=url;a.download=`blanc-session-${new Date().toISOString().slice(0,10)}.txt`;
  a.click();
  URL.revokeObjectURL(url);
}
messageInput.focus();
</script>
</body>
</html>