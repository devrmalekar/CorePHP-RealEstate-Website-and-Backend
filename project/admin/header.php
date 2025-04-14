<?php 
	session_start();
	include'../includes/db_connect.php';
	include'../includes/functions.php';
	error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Nepal Real Estate</title>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

 	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="../assets/style.css"/>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="../assets/bootstrap/js/bootstrap.js"></script>
  <script src="..assets/script.js"></script>
	<script src="../js/jquery-editable.js"></script>

<!-- Owl stylesheet -->
<link rel="stylesheet" href="../assets/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="../assets/owl-carousel/owl.theme.css">
<script src="../assets/owl-carousel/owl.carousel.js"></script>
<!-- Owl stylesheet -->


<!-- slitslider -->
    <link rel="stylesheet" type="text/css" href="../assets/slitslider/css/style.css" />
    <link rel="stylesheet" type="text/css" href="../assets/slitslider/css/custom.css" />
    <script type="text/javascript" src="../assets/slitslider/js/modernizr.custom.79639.js"></script>
    <script type="text/javascript" src="../assets/slitslider/js/jquery.ba-cond.min.js"></script>
    <script type="text/javascript" src="../assets/slitslider/js/jquery.slitslider.js"></script>
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
			)
        });
    </script>
</head>

<body>


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
        <li id="dashboardli"><a href="dashboard.php">Dashboard</a></li>
                <?php if (!empty($_SESSION['uname'])) { ?>
                	<li id="username"><a href=""><?php echo $_SESSION['uname']; ?></a>
                        <ul id="submenu" style="display:none;">
                        	 <li><a href="changepassword.php">Change Password</a></li>
                            <li><a href="../logout.php">Logout</a></li>
                        </ul></li> 
				<?php } else { ?>
                	<li><a href="Login.php">Sign In</a></li> <li> | </li>
                    <li><a href="register.php">Sign Up</a></li> 
				<?php } ?>
              </ul>
   </div>
</nav>

          </div>
        </div>

    </div>
<!-- #Header Starts -->










<?php /*?><div class="container">

<!-- Header Starts -->
<div class="header">
<a href="index.php"><img src="images/logo.png" alt="Realestate"></a>

              <ul class="pull-right" style="margin-top:10px;">
                <li><a href="homebuyrent.php">Home</a></li>
                <?php if (!empty($_SESSION['uname'])) { ?>
               		<li><a href="homesaleAdd.php">Add Property</a></li>
                	<li><a href="selectproperty.php">Edit Property</a></li>
                <?php } ?>        
                <li><a href="landbuyrent.php">Land</a></li>
              </ul>         	
             <!-- <div id ="salesBranch" style="display:none">
                        	<div> <a href="saleAdd.php">Add Property</a> </div> <div> <a href="saleEdit.php">Edit Property</a> </div> -->
                        </div>
</div><?php */?>
<!-- #Header Starts -->
</div>