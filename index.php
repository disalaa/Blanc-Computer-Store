<?php
session_start();

if (empty($_SESSION['aid']))
    $_SESSION['aid'] = -1;
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	
		<!-- GOOGLE FONTS -->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&family=Work+Sans:wght@200;300;400;500;600;700&display=swap"
			rel="stylesheet"
		/>
		<!-- Custom font -->
		<script
			src="https://kit.fontawesome.com/0d3faf735c.js"
			crossorigin="anonymous"
		></script>

    <link rel="stylesheet" href="style.css" />


</head>

<body>
    <section id="header">
        <a href="index.php"><img src="img/logo.png" alt="" width="205" height="100" class="logo" /></a>

        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
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
                    <a href="cart.php"><i class="fa fa-shopping-bag"></i></a>
                </li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="hero">
		<div class="row">
					<div class="col-2">
						<h1 class="title-1">POWERFULLY PREBUILT</h1>
						<h1 class="title-2">Ready. Set. Game.</h1>
						<p style="color: black;">Take your gaming to the next level with B L A N C | Pre-Builts.</p>
						<a href="shop.php"><button>Shop Now</button>
					</div>
				</div>
    </section>
		
					<!-- Slideshow -->
		<div class="slideshow-container">
		  <div class="mySlides fade">
			<img src="img/wecurate.png" style="width:100%">
		  </div>

		  <div class="mySlides fade">
			<img src="img/webuild.png" style="width:100%">
		  </div>

		  <div class="mySlides fade">
			<img src="img/youplay.png" style="width:100%">
		  </div>
		</div>
	

    <br><br>
    <section id="banner" class="section-m1">
        <a href="shop.php">
            <button class="normal">Explore More</button>
        </a>
    </section>
		

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>Offers</h4>
            <h2>NZXT H Series Casings</h2>
            <span>The best classic is on sale at B L A N C</span>
            <a href="shop.php">
                <button class="white">Learn More</button>
            </a>
        </div>
        <div class="banner-box banner-box2">
            <h4>Coming This Week</h4>
            <h2>Streamer Essentials</h2>
            <span>The best classic coming on sale at B L A N C</span>
            <a href="shop.php">
                <button class="white">Collection</button>
            </a>
        </div>
    </section>
	<br><br>	

    <section id="banner3">
        <div class="banner-box">

        </div>
        <div class="banner-box banner-box2">

        </div>
        <div class="banner-box banner-box3">

        </div>
    </section>
		
		<!-- BRANDS -->
		<div class="brands">
			<div class="small-container">
				<div class="row">
					<div class="col-5">
						<img src="img/nzxt.png" alt="" />
					</div>
					<div id="asus">
						<img src="img/asus.png" alt="" />
					</div>
					<div class="col-5">
						<img src="img/giga.png" alt="" />
					</div>
					<div class="col-5">
						<img src="img/glo.png" alt="" />
					</div>
					<div id="msi">
						<img src="img/msi.png" alt="" />
					</div>
				</div>
			</div>
		</div>

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
	   <script>
			var slideIndex = 1;
			showSlides();

			function plusSlides(n) {
			  showSlides(slideIndex += n);
			}

			function currentSlide(n) {
			  showSlides(slideIndex = n);
			}

			function showSlides(n) {
			  var i;
			  var slides = document.getElementsByClassName("mySlides");
			  if (n > slides.length) {slideIndex = 1}    
			  if (n < 1) {slideIndex = slides.length}
			  for (i = 0; i < slides.length; i++) {
				  slides[i].style.display = "none";  
			  }
			  slides[slideIndex-1].style.display = "block";  
			}

			// Automatic slideshow functionality
			var slideInterval = setInterval(function() {
			  plusSlides(1); // Advance to the next slide every 3 seconds
			}, 2500);
		   
			</script>
        <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/Your_Tawk.to_Widget_Code';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
    })();
  </script>
		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/660263c11ec1082f04db2d90/1hpslbb8e';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
		<!--End of Tawk.to Script-->
		<script type="text/javascript">
			var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
			(function(){
			  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			  s1.async=true;
			  s1.src='https://embed.tawk.to/660263c11ec1082f04db2d90/default';
			  s1.charset='UTF-8';
			  s1.setAttribute('crossorigin','*');
			  s0.parentNode.insertBefore(s1,s0);
			})();
		  </script>	
</body>

</html>

<script>
window.addEventListener("onunload", function() {
  // Call a PHP script to log out the user
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>