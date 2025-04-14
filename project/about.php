<?php 
	if ( $_SESSION["userrole"] 	== "superadmin")
		{
			header("Location:admin/");
		}
	include'header.php';
	
	$sql = "SELECT `BusinessBackground`, `Name`, `CompanyProfile`, `Contact No`, `fb`, `linkledn`, `gplus`, `twitter`, `Email` FROM `about` WHERE id = 1";
	$result = getSingleRow($sql);
?>
<script>
$(document).ready(function(e) {
    $('#aboutusli').addClass("active");
});
</script>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / About Us</span>
    <h2>About Us</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="spacer">
<div class="row">
  <div class="col-lg-8  col-lg-offset-2">
      <h3>Name of Company</h3>
      <p id="Name"><?php echo $result["Name"]; ?></p>
      <img src="images/about.jpg" class="img-responsive thumbnail"  alt="realestate">
    
      <h3>Business Background</h3>
      <p id="BBSec" ><?php echo $result["BusinessBackground"]; ?></p>
      
      <h3>Company Profile</h3>
      <p id="CPSec"><?php echo $result["CompanyProfile"]; ?></p>
  </div>
 
</div>
</div>
</div>

<?php include'footer.php';?>