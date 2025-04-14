<?php 
	session_start();
	include'includes/db_connect.php';
	include'includes/functions.php';
	error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Nepal Real Estate</title>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

 	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/style.css"/>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/script.js"></script>

<!-- Owl stylesheet -->
<link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
<script src="assets/owl-carousel/owl.carousel.js"></script>
<!-- Owl stylesheet -->


<!-- slitslider -->
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css" />
    <script type="text/javascript" src="assets/slitslider/js/modernizr.custom.79639.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.ba-cond.min.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.slitslider.js"></script>
<!-- slitslider -->
	<script>
		$(document).ready(function(e) {
            $('#username').hover(
				function (){
					$('#submenu').css("display", "block");
					 /*$('#submenu').css("background-color", "#999");
					 $('#submenu').css("color", "#000");*/
					 $('#submenu').css("z-index", "1");
				},
				function () {
					$('#submenu').css("display", "none");
				}
			);
			
			
        });
    </script>
</head>

<body>


<!-- Header Starts -->
<div class="navbar-wrapper">

        <div class="navbar-inverse" role="navigation">
          <div class="container">
            <nav class="navbar navbar-default" role="navigation">
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" 
         data-target="#example-navbar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>
     
   </div>
   <div class="collapse navbar-collapse" id="example-navbar-collapse">
      <ul class="nav navbar-nav">
         <li id="homeli"><a href="index.php">Home</a></li>
         <li id="agentli" ><a href="agents.php">Agents</a></li>
         <li id="contactli"><a href="contact.php">Contact Us</a></li>
         <li id="aboutusli"><a href="about.php">About Us</a></li>
         <?php if (!empty($_SESSION['uname'])) { ?>
         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php echo $_SESSION['uname']; ?><b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="register.php">Edit Profile</a></li>
               <li><a href="changepassword.php">Change Password</a></li>
               <li><a href="logout.php">Log Out</a></li>
            </ul>
         </li>
         <?php } else { ?>
         	<li id="loginli"><a href="login.php">Log in</a></li>
         	<li id="register"><a href="register.php">Register</a></li>
         <?php } ?>
      </ul>
   </div>
</nav>

          </div>
        </div>

    </div>
<!-- #Header Starts -->





<div class="container">

<!-- Header Starts -->
<div class="header">
<a href="index.php"><img src="images/logo.png" alt="Realestate"></a>
	 <ul class="pull-right" style="margin-top:10px;   margin-right: 32px;">
		<?php if (!empty($_SESSION['uname'])) { ?>
			<li class="dropdown"><a href="homebuyrent.php" class="dropdown-toggle" data-toggle="dropdown">Home</a><b class="caret"></b>
				<ul class="dropdown-menu" style="margin-top:0px;">
                	<li><a href="homebuyrent.php">View Home</a></li>
				    <li><a href="homesaleAdd.php">Add Property</a></li>
					<li><a href="selectpropertyHome.php">Edit Property</a></li>
				</ul> 
			</li>
			<li class="dropdown"><a href="landbuyrent.php" class="dropdown-toggle" data-toggle="dropdown">Land</a><b class="caret"></b>
				<ul class="dropdown-menu" style="margin-top:0px;">
                	<li><a href="landbuyrent.php">View Land</a></li>
				   <li><a href="landsaleAdd.php">Add Property</a></li>
						<li><a href="selectpropertyLand.php">Edit Property</a></li>
				</ul>
			</li>
		<?php } else { ?>
			<li><a href="homebuyrent.php">Home</a></li>
			<li><a href="landbuyrent.php">Land</a></li>
		<?php } ?>
      </ul>
             	
             <!-- <div id ="salesBranch" style="display:none">
                        	<div> <a href="saleAdd.php">Add Property</a> </div> <div> <a href="saleEdit.php">Edit Property</a> </div> -->
                        </div>
</div>
<!-- #Header Starts -->
</div>