<?php 
	include'header.php';
	/*include'includes/db_connect.php';
	include'includes/functions.php';*/
	//error_reporting(0);
	////var_dump(isset($_SESSION["userrole"])); exit;
	if ($_SESSION["userrole"] 	!= "superadmin")
		{
			
			header("Location:../index.php");
		}
	$error = "";
	if (isset($_POST['Submit']) && !empty($_POST['Submit'])){
		$uname = $_POST['uname'];
		$pwd = $_POST['password'];
		
		$sql="SELECT * from userprofile where `UserName`='$uname' && `Password`='$pwd' && `User Role`='superadmin'";
        $result = getSingleRow($sql);
        
        if($result)
        {
            $_SESSION['uname']=$uname;
			$_SESSION['userrole'] = "superadmin";
			header("location:dashboard.php");
        }
        else
        {
            $error="Invalid Credintial. Please Try Again.";
        }
	}


?>
<script>
   $(document).ready(function(e) {
    	$('#dashboardli').addClass("active"); 
	});
</script>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right">Welcome to Dashboard</span>
    <h2>Dashboard</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="spacer">
<div class="row contact" style="margin-bottom: 5%;">
 <a href="agents.php"> <span class="col-lg-6 col-sm-6 " style="  width: 15%; border: 2px solid; height: 170px; border-color: #72B70F; margin-right: 50px;">
  	<div class="innerdiv" style="margin:25% 17%; padding:24%  10%">
    All Agents
    </div>
  </span></a>
<a href="addAgent.php">  <span class="col-lg-6 col-sm-6 " style="  width: 15%; border: 2px solid; height: 170px; border-color: #72B70F; margin-right: 50px;">
  	<div class="innerdiv" style="margin:25% 15%; padding:24%  10%">
    	Add Agents
    </div>
  </span></a>
  <a href="userlist.php"><span class="col-lg-6 col-sm-6 " style="  width: 15%; border: 2px solid; height: 170px; border-color: #72B70F;margin-right: 50px;">
  	<div class="innerdiv" style="margin:25% 20%; padding:24%  10%">
    	List User
    </div>
  </span></a>
 
 <!-- <div class="col-lg-6 col-sm-6 ">
  <div class="well"><iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Pulchowk,+Patan,+Central+Region,+Nepal&amp;aq=0&amp;oq=pulch&amp;sll=37.0625,-95.677068&amp;sspn=39.371738,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=Pulchowk,+Patan+Dhoka,+Patan,+Bagmati,+Central+Region,+Nepal&amp;ll=27.678236,85.316853&amp;spn=0.001347,0.002642&amp;t=m&amp;z=14&amp;output=embed"></iframe></div>
  </div> -->
</div>
<div class="row contact" style="margin-bottom: 5%;">

<a href="about.php"> <span class="col-lg-6 col-sm-6 " style="  width: 15%; border: 2px solid; height: 170px; border-color: #72B70F; margin-right: 50px;">
  	<div class="innerdiv" style="margin:25% 20%; padding:24%  10%">
    	About
    </div>
  </span></a>
  <a href="contact.php"><span class="col-lg-6 col-sm-6 " style="  width: 15%; border: 2px solid; height: 170px; border-color: #72B70F; margin-right: 50px;">
  	<div class="innerdiv" style="margin:25% 20%; padding:24%  10%">
    	Contact
    </div>
  </span></a></div> 
</div>
</div>

<?php include'footer.php';?>