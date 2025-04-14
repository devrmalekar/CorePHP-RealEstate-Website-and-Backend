<?php 
	include'header.php';
	if(isset($_POST['Submit'])){
		$md5_hash = md5(mt_rand(0,999)); 
		//We don't need a 32 character long string so we trim it down to 5 
		$start = mt_rand(0,20);
		$temp_password = substr($md5_hash, $start,10); 
		$sql = "UPDATE `userprofile` SET `temp_password` ='".$temp_password."' WHERE `Email`='".$_POST["email"]."'";
		execute($sql);
		$message = sendMail($_POST['email'],"Request for Password Change","Currenty you have requested for password change. Your new temporary password is ".$temp_password,"From: autoreply@rs.np", "");
	}
?>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / Login Us</span>
    <h2>Contact Us</h2>
</div>
</div>
<!-- banner -->
<script>
	$(document).ready(function(e) {
        $('#search').click(function(e) {
             $.ajax({
                    type: "POST",
                    url: "AjaxValidation.php",
                    data: { value: encodeURIComponent($("#email").val()), tablename: "`userprofile`", fieldname: "Email", function: "CheckPropAvailablity"},                   
					success: function (response) {
						var result = $.parseJSON(response);
						
					    if(result.IsNameExist != "0"){
							$('#submit').css("display", "block");
							$('#search').css("display", "none");
							$('#errormsg').css("display", "none");
						} else {
							$('#errormsg').css("display", "block");
							$('#submit').css("display", "none");
							$('#search').css("display", "block");
						}
                    },
                 failure: function () {
                     window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
                    }
             	});		
        });
    });
</script>


<div class="container">
<div class="spacer">
<div class="row contact">
  <div class="col-lg-6 col-sm-6 ">
  <?php if ($message != "") { echo $message; } else { ?>
  	<label id="errormsg" style="display:none">Sorry Email address does not exist</label>
	<form action="#" method="post">
		<fieldset>
            <input id="email" type="email" name="email" class="form-control" placeholder="Search for email">
            <button id="submit" type="button" value="Submit" class="btn btn-success" name="Submit" style="display:none">Reset</button>
      		<button id="search" type="button" value="Submit" class="btn btn-success" name="Search">Search</button>
         </fieldset>
	</form>
   <?php } ?>
                
        </div>

</div>
</div>
</div>

<?php include'footer.php';?>