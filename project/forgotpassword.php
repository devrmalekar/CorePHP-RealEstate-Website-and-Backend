<?php 
	include'header.php';
	/*include'includes/db_connect.php';
	include'includes/functions.php';*/
	//error_reporting(0);
        if(isset($_SESSION["uname"]) && !empty($_SESSION["uname"])){
           if($_SESSION['userrole'] == "user")
			{
				header("location:index.php");
			} else if ($_SESSION['userrole'] == "superadmin") {
				header("location:admin/dashboard.php");
}
        }   
	$error = "";
	if (isset($_POST['Submit']) && !empty($_POST['Submit'])){
		$uname = $_POST['uname'];
		$pwd = $_POST['password'];
		
		$sql="SELECT * from userprofile where `UserName`='$uname' && `Password`='$pwd'";
        $result = getSingleRow($sql);
        
        if($result)
        {
            $_SESSION['uname']=$uname;
			$_SESSION['userrole']=$result['User Role'];
			if($_SESSION['userrole'] == "user")
			{
				header("location:index.php");
			} else if ($_SESSION['userrole'] == "superadmin") {
				header("location:admin/dashboard.php");
			}
        }
        else
        {
            $error="Invalid Credintial. Please Try Again.";
        }
	}


?>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / Login Us</span>
    <h2>Forgot Password</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="spacer">
<div class="row contact">
  <div class="col-lg-6 col-sm-6 ">
  	<?php if ($error != "") echo '<label>'.$error.'</label>'; ?>
	<form action="#" method="post">
		<fieldset>
            <input type="text" name="email"class="form-control" placeholder="Your email address">
            <input type="password" name="password" class="form-control" placeholder="Password Address">
      		<button type="submit" value="Submit" class="btn btn-success" name="Submit">Log In</button>
         </fieldset>
	</form>

                
        </div>
 <!-- <div class="col-lg-6 col-sm-6 ">
  <div class="well"><iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Pulchowk,+Patan,+Central+Region,+Nepal&amp;aq=0&amp;oq=pulch&amp;sll=37.0625,-95.677068&amp;sspn=39.371738,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=Pulchowk,+Patan+Dhoka,+Patan,+Bagmati,+Central+Region,+Nepal&amp;ll=27.678236,85.316853&amp;spn=0.001347,0.002642&amp;t=m&amp;z=14&amp;output=embed"></iframe></div>
  </div> -->
</div>
</div>
</div>

<?php include'footer.php';?>