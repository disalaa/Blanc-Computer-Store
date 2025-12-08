<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="icon" type="image/png" href="blanc.png" />
    <title>BLANC | Computer Store</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <link rel="stylesheet" href="style.css" />

    <style>
    .paragraph {
        line-height: 1.5;
    }
    </style>


</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" alt="" width="205" height="100" class="logo" /></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a class="active" href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>

                <?php

                if ($_SESSION['aid'] < 0) {
                    echo "   <li><a href='login.php'>login</a></li>
            <li><a href='signup.php'>SignUp</a></li>
            ";
                } else {
                    echo "   <li><a href='profile.php'>profile</a></li>
          ";
                }
                ?>
                <li><a href="admin.php">Admin</a></li>
                <li id="lg-bag">
                    <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
                </li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="page-header" class="about-header">

    </section>

    <section id="about-head" class="section-p1">
        <img src="img/about/x2.PNG" alt="" />
        <div>
            <h2>About Us?</h2>
            <p class="paragraph">
                Welcome to Blanc, where innovation meets expertise in the realm of computing. At Blanc, we are more than just a computer store; we are creators, builders, and enthusiasts dedicated to crafting exceptional computing experiences tailored to your needs. Founded with a passion for innovation and a commitment to excellence, Blanc emerged as a haven for tech aficionados seeking top-tier hardware, expert guidance, and personalized solutions. Our journey began with a simple belief: every individual deserves a computing experience that transcends expectations. At Blanc, our mission is clear: to empower you with cutting-edge technology and unparalleled service. Whether you're a seasoned gamer, a creative professional, or a tech enthusiast, we are here to elevate your computing journey through our curated selection of premium products and bespoke solutions. 
            </p>
            <br /><br />
            <marquee bgcolor="#850a85" loop="-1" scrollamount="5">.</marquee>
        </div>
    </section>

    


     <footer class="section-p1">
        <div class="col">
            <!-- <a href="index.php"><img src="img/logo.png" alt="" width="205" height="100" class="logo" /></a> -->
			<h4>Contact</h4>
            <p>
                <strong>Address: </strong> 69/9, BLANC Int, Vauxhall St, Colombo 00700

            </p>
            <p>
                <strong>Phone: </strong> +94 718 628 865
            </p>
            <p>
                <strong>Hours: </strong> 9am-5pm
            </p>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="cart.php">View Cart</a>
            <a href="wishlist.php">My Wishlist</a>
        </div>
        <div class="col install">
            <p>Secured Payment Gateways</p>
            <img src="img/pay/pay.png" />
        </div>
        <div class="copyright">
            Developed by <a href="index.html">Disala Salgado</a>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>

<script>
window.addEventListener("unload", function() {
  // Call a PHP script to log out the user
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>