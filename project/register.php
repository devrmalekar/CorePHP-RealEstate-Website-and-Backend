<?php 
	include'header.php';
	include 'generateSC.php'; 
	if ( $_SESSION["userrole"] 	== "superadmin")
		{
			header("Location:admin/");
		}
	session_start();
	error_reporting(0);
	
	if( !empty($_SESSION["uname"])){
		$sql = "SELECT * FROM `userprofile` WHERE `UserName`= '".$_SESSION["uname"]."'";
		$resultUser = getSingleRow($sql); 
		$fname=$resultUser["First Name"];
	   $lname=$resultUser["Last Name"];
	   /*$street = $resultUser["First Name"];];
	   $city = $resultUser["First Name"];;
	   $country = $resultUser["First Name"];;*/
	   $contact = $resultUser["Contact"];////var_dump($contact); exit;
	   $email = $resultUser["Email"];
	   //$uname = $resultUser["UserName"];
	   //$pass=$resultUser["First Name"];
	   $gaddress = $resultUser["gaddress"]; ////var_dump[$_POST['pacinput']];
	   $glat = $resultUser["glat"];
	   $glng = $resultUser["glng"];////var_dump($glng); exit;
	}
	
	if(isset($_POST['Submit']))
	{
		 $fname=mysql_real_escape_string($_POST['fname']);
		 $lname=mysql_real_escape_string($_POST['lname']);
		 /*$street = mysql_real_escape_string($_POST['street']);
		 $city = mysql_real_escape_string($_POST['city']);
		 $country = mysql_real_escape_string($_POST['Country']);*/
		 $contact = mysql_real_escape_string($_POST['contact']);
		 $email = mysql_real_escape_string($_POST['email']);
		 $uname = mysql_real_escape_string($_POST['username']);
		 $pass=md5(mysql_real_escape_string($_POST['password']));
		 $gaddress = mysql_real_escape_string($_POST['pacinput']); ////var_dump($_POST['pacinput']);
		 $glat = mysql_real_escape_string($_POST['lat']);
		 $glng = mysql_real_escape_string($_POST['lng']);
			
			//var_dump($_POST["emailErrMsg"]); 
			$sql="INSERT INTO userprofile (`First Name`, `Last Name`, `gaddress`, `glat`, `glng`,`Contact`, `Email`, `UserName`, `Password`, `User Role`) VALUES ('$fname', '$lname', '$gaddress', '$glat', '$glng', '$contact', '$email', '$uname', '$pass', 'user')";
			execute($sql);
			$_SESSION['uname']=$uname;
			$_SESSION['userrole']=$result['User Role'];
			header('Location:index.php');
		
	}
	
	if(isset($_POST['Edit']))
	{
		 $fname=mysql_real_escape_string($_POST['fname']);
		 $lname=mysql_real_escape_string($_POST['lname']);
		 /*$street = mysql_real_escape_string($_POST['street']);
		 $city = mysql_real_escape_string($_POST['city']);
		 $country = mysql_real_escape_string($_POST['Country']);*/
		 $contact = mysql_real_escape_string($_POST['contact']);
		 $email = mysql_real_escape_string($_POST['email']);
		 $gaddress = mysql_real_escape_string($_POST['pacinput']); ////var_dump($_POST['pacinput']);
		 $glat = mysql_real_escape_string($_POST['lat']);
		 $glng = mysql_real_escape_string($_POST['lng']);
			
			//var_dump($_POST["emailErrMsg"]); 
			$sql="UPDATE `userprofile` SET `First Name`='".$fname."',`Last Name`='".$lname."',`Contact`='".$contact."',`gaddress`='".$gaddress."',`glat`='".$glat."',`glng`='".$glng."',`Email`='".$email."' WHERE `UserName`='".$_SESSION["uname"]."'";			
			execute($sql);
			$message ="Successfully saved";
		
	}

?>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / Register</span>
    <h2>Register</h2>
    <script src="js/securitycaptcha.js"></script>
    <script>
	$(document).ready(function(e) {
          $('#register').addClass("active");
        $('#contact').blur(function(e) {
            if ($('#contact').val() != ""){
				 var contact = !isNaN($('#contact').val());
				 if (contact){
					  $.ajax({
						type: "POST",
						url: "AjaxValidation.php",
						data: { value: encodeURIComponent($("#contact").val()), tablename: "`userprofile`", fieldname: "Contact", function: "CheckPropAvailablity"},                   
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
                    data: { value: encodeURIComponent($("#email").val()), tablename: "`userprofile`", fieldname: "Email", function: "CheckPropAvailablity"},                   
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
		
		$('#username').blur(function(e) {
            if ($('#username').val() != ""){
				//alert($('#username').val());
				 $.ajax({
                    type: "POST",
                    url: "AjaxValidation.php",
                    data: { value: encodeURIComponent($("#username").val()), tablename: "`userprofile`", fieldname: "UserName", function: "CheckPropAvailablity"},                   
					success: function (response) {
						var result = $.parseJSON(response);
						//alert(response.IsNameExist);
						$('#username').css('float','left');
					    if(result.IsNameExist == "0"){
							$('#usernameErrImg').css('display','block');
							$('#usernameErrImg').attr('src','images/right.png');
							$('#usernameErrMsg').css('display','none');
							$('#usernameErrMsg').attr('value', '');
						} else {
							$('#usernameErrImg').css('display','block');
							$('#usernameErrImg').css('float','left');
							$('#usernameErrImg').attr('src','images/wrong.png');
							$('#usernameErrMsg').css('display','block');
							$('#usernameErrMsg').attr('value', 'Already Exists.');
						}
                    },
                 failure: function () {
                     window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
                    }
             	});		
			}
        });
		
		/*$('#password').blur(function(e) {
            var pwdRegex = '^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$';
			var isMatched = pwdRegex.test($('#password').val());
			//alert("ug"+isMatched);
			if (!isMatched){
				$('#passwordErrMsg').attr('src','images/wrong.png');
				$('#passwordErrMsg').css('display','block');
				$('#passwordErrMsg').css('color', '#F00');
				$('#passwordErrMsg').val("Must meet criteria");
			}
        });*/
		
		$('#submitform').submit(function(e) {
			//alert($('#security_code').val());
			if($('#usernameErrMsg').val() != " " || $('#emailErrMsg').val() !=" " || $('#contactErrMsg').val() != " "  || $('#captchaErrMsg').val() != "OK You are not Robot"){
				//e.preventDefault();
			}
        });
		
		$('#security_code').blur(function(e) {
            if ($('#security_code').val() != ""){
				 checkCaptcha($('#security_code').val());
				}
        });
    });
		</script>
        
</div>
</div>
<!-- banner -->


<div class="container">
<div class="spacer">
<div class="row register">
  <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">
  	<form method="post" id="submitform">
    <div id="success" style="margin:3%;"><?php if($message != ""){ echo $message;  ?></div><?php } else { ?>
      <fieldset>
      <table style="width:100%; background-image:url(images/bgmain.png)">
      	  <tr><td><input type="text" class="form-control" placeholder="First Name" name="fname" required style="width:50%" value="<?php echo $fname; ?>"></td></tr>
         <tr><td> <input type="text" class="form-control" placeholder="Last Name" name="lname" required style="width:50%" value="<?php echo $lname; ?>"></td></tr>
         <!-- <tr><td><input type="text" class="form-control" placeholder="Country" name="Country" value="Nepal" readonly="readonly" style="width:50%" value="<?php echo $fname; ?>"></td></tr>
          <tr><td><input type="text" class="form-control" placeholder="District" name="city" required="required"style="width:50%" value="<?php echo $city; ?>"></td></tr>
         <tr><td> <input type="text" class="form-control" placeholder="Street Address" name="street" style="width:50%" value="<?php echo $fname; ?>"></td></tr>-->
         
         <tr><td><?php include 'regeocoding.php'; ?></td></tr>
         
         <tr><td> <input type="text" id="contact" class="form-control" placeholder="Contact" name="contact" required style=" width:50%" value="<?php echo $contact; ?>">
           <img id="contactErrImg" src="images/right.png" style="width:40px; display:none;  margin-top: 5px;
  margin-left: 13px;"><input id="contactErrMsg" name="contactErrMsg" style="color:#F00; font-size:16px; width: 25%; display:none" readonly value=" "></td></tr>
         <tr><td> <input type="email" id="email" class="form-control" placeholder="Enter Email" style="width:50%" name="email" required value="<?php echo $email; ?>">
           <img id="emailErrImg" src="images/right.png" style="width:40px; display:none;  margin-top: 5px;
  margin-left: 13px;"><input id="emailErrMsg" name="emailErrMsg" style="color:#F00; font-size:16px; width: 25%; display:none" readonly value=" " ></td></tr>
          <?php if( empty($_SESSION["uname"])){ ?><tr><td> <input type="text" id="username" class="form-control" style=" width:50%" placeholder="username" name="username" required>
           <img id="usernameErrImg" src="images/right.png" style="width:40px; display:none; margin-top: 5px;
  margin-left: 13px;"><input id="usernameErrMsg" name="usernameErrMsg" style="color:#F00; font-size:16px; width: 25%; display:none" readonly ""></td></tr>
        <tr><td> <input type="password" id="password" class="form-control" placeholder="Password" name="password" required style="width:50%; float:left"> <input id="passwordErrMsg" name="passwordErrMsg" style="font-size:16px; width: 30%; margin-left:3%; height: 20%; display:none" readonly></td></tr>
         <!--<tr><td>Password must have one special case letter, two digits, three lowercase letters, must of 8 character</td></tr>--> <?php } ?>
         <tr><td>Prove you are not ROBOT<label id="captcha" style="background-image:url(images/banner.jpg); width: 20%; margin-left:2%; text-align:center; color:#FFF"><?php echo $security_code; ?></label></td></tr>
          <tr><td> <input type="text" id="security_code" class="form-control" placeholder="Enter Above Text" name="security_code" style="width:50%; float:left" required > <input id="captchaErrMsg" name="captchaErrMsg" style="font-size:16px; width: 20%; margin-left:3%; height: 20%; display:none" readonly></td></tr>
       <tr><td> <?php if( empty($_SESSION["uname"])){ ?>  <button type="submit" id="submit" class="btn btn-success" name="Submit" style="width:50%">Register</button> <?php } else { ?>  <button type="submit" id="submit" class="btn btn-success" name="Edit" style="width:50%">Save</button> <?php } ?></td></tr></table>
      </fieldset>
      <?php } ?>
	</form>       
        </div>
  
</div>
</div>
</div>

<?php include'footer.php';?>