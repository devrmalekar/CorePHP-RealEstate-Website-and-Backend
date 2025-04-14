<?php 
	include'header.php';
	include '../generateSC.php';
	error_reporting(0);
	$imagefile="";
	
	
	$gaddress = "";
	$glng = "";
	$glat = "";
	if ($_SESSION["userrole"] != "superadmin")
	{
		header("Location:../index.php");
	}
	
	if(isset($_POST['editAgent'])){
		$_SESSION["editContact"] = mysql_real_escape_string($_POST['contact']);
		$sql = "SELECT * FROM `agentdetail` WHERE `Contact`='".$_SESSION["editContact"]."'";
		////var_dump($sql);
		$resultAgent = getSingleRow($sql);
		$gaddress = $resultAgent["gaddress"];
		$glat =  $resultAgent["glat"];
		$glng =  $resultAgent["glng"];
		////var_dump($gaddress); 
	}
	
	if(isset($_POST['Submit']))
	{
		////var_dump("this is that ");
		 $fname=mysql_real_escape_string($_POST['fname']);
		 $lname=mysql_real_escape_string($_POST['lname']);
		/* $street = mysql_real_escape_string($_POST['street']);
		/* $city = mysql_real_escape_string($_POST['city']);
		 $country = mysql_real_escape_string($_POST['Country']);*/
		 $contact = mysql_real_escape_string($_POST['contact']);
		 $email = mysql_real_escape_string($_POST['email']);
		 $Description = mysql_real_escape_string($_POST['Description']);
		 $status = mysql_real_escape_string($_POST['status']);
		 $gaddress = mysql_real_escape_string($_POST['pacinput']); ////var_dump($_POST['pacinput']);
		 $glat = mysql_real_escape_string($_POST['lat']);
		 $glng = mysql_real_escape_string($_POST['lng']);
		 $caninsert = "false";
		 $errorimg="";
		// Variable for indexing uploaded image.
		//$j = 0;   
		// Declaring Path for uploaded images.  
		$target_path = "../images/agents/";     
		if (!file_exists($target_path)){
				mkdir($target_path, 0777, true);
			}
		 // Loop to get individual element from the array
		// Extensions which are allowed.
		$validextensions = array("jpeg", "jpg", "png");  
		// Explode file name from dot(.)    
		$ext = explode('.', basename($_FILES['file']['name'][0]));
		// Store extensions in the variable.   
		$file_extension = end($ext); 
		// Set the target path with a new name of image.
		$target_path = $target_path .$ext[0] .md5(uniqid()) . "." . $ext[count($ext) - 1];   
		// Increment the number of uploaded images according to the files in array.
		//$j = $j + 1; 
		// Approx. 100kb files can be uploaded.   
		////var_dump($file_extension) ;
		////var_dump(in_array($file_extension, $validextensions))  ; exit;
		if (($_FILES["file"]["size"][0] < 200000) && in_array($file_extension, $validextensions)) {
			if (move_uploaded_file($_FILES['file']['tmp_name'][0], $target_path)) {
				// If file moved to uploads folder.
				//echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
				$imagefile= $target_path;
				////var_dump($imagefile[$i]); exit;
				$caninsert = "true";
				$errorimg = 'Image uploaded successfully!.';
			} else {     //  If File Was Not Moved.
				//echo $j. ').<span id="error">please try again!.</span><br/><br/>'; exit;
				$errorimg = 'Error while uploading '.$filename.'<br>Please try again!.';
				$caninsert = "false";
			} 
		} else {     //   If File Size And File Type Was Incorrect.
			  $errorimg = 'Error while uploading. ***Invalid file Size or Type***<br>';
			  $caninsert = "false"; 
			  /*//var_dump($_FILES['file']['tmp_name'][$i]);
			  //var_dump($target_dir); exit;*/
		}
		if($caninsert == "true"){
			$sql="INSERT INTO `agentdetail` (`FirstName`, `LastName`, `gaddress`, `glat`, `glng`,`Contact`, `Email`, `Description`, `imgURL`, `Status`) VALUES ('$fname', '$lname', '$gaddress', '$glat', '$glng', '$contact', '$email', '$Description', '$imagefile', '$status')";
			////var_dump($sql); exit;
			execute($sql);
			$message = "Agent successfully added.";
		}
	}
	else if (isset($_POST['Edit'])){
		 $fname=mysql_real_escape_string($_POST['fname']);
		 $lname=mysql_real_escape_string($_POST['lname']);
		/* $street = mysql_real_escape_string($_POST['street']);
		/* $city = mysql_real_escape_string($_POST['city']);
		 $country = mysql_real_escape_string($_POST['Country']);*/
		 $contact = mysql_real_escape_string($_POST['contact']);
		 $email = mysql_real_escape_string($_POST['email']);
		 $Description = mysql_real_escape_string($_POST['Description']);
		 $status = mysql_real_escape_string($_POST['status']);
		 $gaddress = mysql_real_escape_string($_POST['pacinput']); ////var_dump($_POST['pacinput']);
		 $glat = mysql_real_escape_string($_POST['lat']);
		 $glng = mysql_real_escape_string($_POST['lng']);
		 $caninsert = "false";
		 $errorimg="";
			$sql = "UPDATE `agentdetail` SET `FirstName`='".$fname."',`LastName`='".$lname."',`Contact`='".$contact."',`gaddress`='".$gaddress."',`glat`='".$glat."',`glng`='".$glng."',`Email`='".$email."',`Description`='".$Description."',`Status`='".$status."' WHERE `Contact`='".$_SESSION["editContact"]."'"; //var_dump($sql);
			$_SESSION["editContact"] = "";
			execute($sql);
			$message="Successfully Updated!!!";
	}
	
?>
<div class="row register">
<script src="..js/securitycaptcha.js"></script>
 <script>
	$(document).ready(function(e) {
	
          $('#addagentli').addClass("active");

        $('#contact').blur(function(e) {
            if ($('#contact').val() != ""){
				 var contact = !isNaN($('#contact').val());
				 if (contact){
					  $.ajax({
						type: "POST",
						url: "AjaxValidation.php",
						data: { value: encodeURIComponent($("#contact").val()), tablename: "`agentdetail`", fieldname: "Contact", function: "CheckPropAvailablity"},                   
						success: function (response) {
							var result = $.parseJSON(response);
							$('#contact').css('float','left');
							if(result.IsNameExist == "0"){
								$('#contactErrImg').css('display','block');
								$('#contactErrImg').attr('src','images/right.png');
								$('#contactErrMsg').css('display','none');
								$('#contactErrMsg').attr('value', '');
							} else {
								$('#contactErrImg').css('float','left');
								$('#contactErrImg').css('display','block');
								$('#contactErrImg').attr('src','images/wrong.png');
								$('#contactErrMsg').css('display','block');
								$('#contactErrMsg').attr('value', 'Already Exists.');
							}
						},
					 failure: function () {
						 window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
						}
             		});
				 } else {
					 $('#contact').css('float','left');
					 $('#contactErrImg').css('float','left');
					 $('#contactErrImg').css('display','block');
					$('#contactErrImg').attr('src','images/wrong.png');
					$('#contactErrMsg').css('display','block');
					$('#contactErrMsg').css('width','40%');
					$('#contactErrMsg').attr('value', 'Input only number.');
				 }
			}
        });
		
		$('#email').blur(function(e) {
            if ($('#email').val() != ""){
				//alert($('#email').val());
				 $.ajax({
                    type: "POST",
                    url: "AjaxValidation.php",
                    data: { value: encodeURIComponent($("#email").val()), tablename: "`agentdetail`", fieldname: "Email", function: "CheckPropAvailablity"},                   
					success: function (response) {
						var result = $.parseJSON(response);
						//alert(response.IsNameExist);
						$('#email').css('float','left');
					    if(result.IsNameExist == "0"){
							$('#emailErrImg').css('display','block');
							$('#emailErrImg').attr('src','images/right.png');
							$('#emailErrMsg').css('display','none');
							$('#emailErrMsg').attr('value', '');
						} else {
							$('#emailErrImg').css('float','left');
							$('#emailErrImg').css('display','block');
							$('#emailErrImg').attr('src','images/wrong.png');
							$('#emailErrMsg').css('display','block');
							$('#emailErrMsg').attr('value', 'Already Exists.');
						}
                    },
                 failure: function () {
                     window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
                    }
             	});		
			}
        });
		
		$('#submitform').submit(function(e) {
			if( $('#emailErrMsg').val() !="" || $('#contactErrMsg').val() != ""){
				//alert($('#emailErrMsg').val()+"\n"+$('#contactErrMsg').val());
				e.preventDefault();
			}
        });
		
		/*$('#security_code').blur(function(e) {
			
            if ($('#security_code').val() != ""){
				 checkCaptcha($('#security_code').val());
				}
        });
		*/
    });
	 
 </script>
 <!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / Agents</span>
    <h2>Agents | <a href="addAgent.php">Add New Agent</a></h2>
</div>
</div>
<!-- banner -->

<div class="container">
<div class="spacer agents">

<div class="row">
  <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">
  	<form action="#" method="post" enctype="multipart/form-data" id="submitform">
	<div id="success" style="margin:3%;"><?php if($message != ""){ echo $message;  ?></div><?php } else { ?>
      <fieldset>
      <table style="width:100%; background-image:url(../images/bgmain.png)">
      	  <tr><td><input type="text" class="form-control" placeholder="First Name" name="fname" value="<?php echo $resultAgent["FirstName"]; ?>" required style=" width:45%"></td></tr>
          <tr><td><input type="text" class="form-control" placeholder="Last Name" name="lname" value="<?php echo $resultAgent["LastName"]; ?>" required style=" width:45%"></td></tr>
          <tr><td><select  name="status" id="status" style="width:45%" class="form-control"  value="<?php echo $resultAgent["Status"]; ?>" required="required" >
                    	<option value="available">Available</option>
                	    <option value="Bunglaow">Not Available</option></select></td></tr>
                        
          <?php /*?><tr><td><input type="text" class="form-control" placeholder="Country" name="Country" required="required" value="<?php echo $resultAgent["Country"]; ?>" style=" width:45%"></td></tr>
          <tr><td><input type="text" class="form-control" placeholder="District" name="city" required="required" value="<?php echo $resultAgent["District"]; ?>" style=" width:45%"></td></tr>
          <tr><td><input type="text" class="form-control" placeholder="Street Address" name="street" required="required" value="<?php echo $resultAgent["StreetAddr"]; ?>" style=" width:45%"></td></tr><?php */?>
          
          <tr><td><?php include '../regeocoding.php'; ?></td></tr>
          
          <tr><td><input type="text" id="contact" class="form-control" placeholder="Contact" name="contact" required style=" width:45%" value="<?php echo $resultAgent["Contact"]; ?>">
           <img id="contactErrImg" src="images/right.png" style="width:40px; display:none;  margin-top: 5px;
  margin-left: 13px;"><input id="contactErrMsg" name="contactErrMsg" style="color:#F00; font-size:16px; width: 25%; display:none" readonly></td></tr>
          <tr><td><input type="email" id="email" class="form-control" placeholder="Enter Email" style="width:45%" name="email" required value="<?php echo $resultAgent["Email"]; ?>">
           <img id="emailErrImg" src="images/right.png" style="width:40px; display:none;  margin-top: 5px;
  margin-left: 13px;"><input id="emailErrMsg" name="emailErrMsg" style="color:#F00; font-size:16px; width: 25%; display:none" readonly></td></tr>
          <tr><td><input type="text"  class="form-control" placeholder="Description" value="<?php echo $resultAgent["Description"]; ?>" name="Description" required style=" width:45%"></td></tr>
         <?php if(!isset($_POST['editAgent'])){ ?> <tr><td><input name="file[]" type="file" id="file" required  >
          <div id="errormsg"><?php echo $errorimg; ?></div></td></tr><?php } ?>
          <!--<tr><td>Prove you are not ROBOT<label id="captcha" style="background-image:url(../images/banner.jpg); width: 20%; margin-left:2%; text-align:center; color:#FFF"><?php echo $security_code; ?></label></td></tr>
          <tr><td><input type="text" id="security_code" class="form-control" placeholder="Enter Above Text" name="security_code" style="width:25%; float:left" required="required" > <input id="captchaErrMsg" name="captchaErrMsg" style="font-size:16px; width: 20%; margin-left:3%; height: 20%; display:none" readonly="readonly"></td></tr>-->
            
          <tr><td><?php if(isset($_POST['editAgent'])){ ?><button type="submit" style=" width:45%" class="btn btn-success" name="Edit">Edit Agent</button><?php } else { ?>
          <button type="submit" style=" width:45%" class="btn btn-success" name="Submit">Add Agent<?php } ?></button></td></tr>
      </table>
      </fieldset> <?php } ?>
	</form>
                
        </div>
</div>
</div>
</div>
</div>
</div>

<?php include'footer.php';?>