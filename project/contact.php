<?php 
if (isset($_SESSION["userrole"]) && $_SESSION["userrole"] 	== "superadmin")
		{
			header("Location:admin/");
		}
	include'header.php';

	if(isset($_POST["SubmitMsg"])){
		$sql = "SELECT `Email` FROM `about`";
		$orgEmail = getSingleRow($sql);
		$to = $orgEmail["Email"];
		$subject = $_POST["subject"];
		$headers = "From: ". $_POST["email"]."\r\n";
		$message = $_POST["name"]."<br/>".$_POST["msg"];
		/*$send_contact = mail($to,$subject,$message,$headers);
		if ($send_contact)
		{
			mail($_POST["email"],"Your message has been sent","Thank You for your message. Your message is so important to us and we will respond as soon as possible.<br/>*** This is an automatically generated email, please do not reply ***","From: ".$orgEmail["Email"]);
			$message= "Successfully Sent. \nYou will be replied as soon as possible.";
			////var_dump($message); exit;
		}
		else{
			$message = "OOPS!!! Sorry, Message sending Failed!. Try Again Later.";
		}*/
		$message = sendMail($to,$subject,$message,$headers, $_POST["email"]);
	}
?>
<script>
   $(document).ready(function (e){
       $('#contactli').addClass("active");
   })

</script>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / Contact Us</span>
    <h2>Contact Us</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="spacer">
<div class="row contact">
  <div class="col-lg-6 col-sm-6 ">
  <?php if($message != "") { echo '<label>'.$message.'</label>';} else { ?>
		<form action="#" method="post">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required="required">
                <input type="text" name="email" class="form-control" placeholder="Email Address" required="required">
                <input type="text" name="contact" class="form-control" placeholder="Contact Number" required="required">
                <input type="text" name="subject" class="form-control" placeholder="Subject"rrequired="required">
                <textarea rows="6" name="msg" class="form-control" placeholder="Message" required="required"></textarea>
      			<button type="submit" class="btn btn-success" name="SubmitMsg">Send Message</button>
          </form>

   <?php } ?>
                
        </div>
  <div class="col-lg-6 col-sm-6 ">
  <div class="well"><iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Pulchowk,+Patan,+Central+Region,+Nepal&amp;aq=0&amp;oq=pulch&amp;sll=37.0625,-95.677068&amp;sspn=39.371738,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=Pulchowk,+Patan+Dhoka,+Patan,+Bagmati,+Central+Region,+Nepal&amp;ll=27.678236,85.316853&amp;spn=0.001347,0.002642&amp;t=m&amp;z=14&amp;output=embed"></iframe></div>
  </div>
</div>
</div>
</div>

<?php include'footer.php';?>