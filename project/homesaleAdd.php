<?php 
	include'header.php';
	include 'generateSC.php';
	if ( $_SESSION["userrole"] 	== "superadmin")
		{
			header("Location:admin/");
		}
	error_reporting(0);
	
	if (!(isset($_SESSION['uname']) && $_SESSION['uname'] != '')) {
		header ("Location: login.php");
	}else if (isset($_SESSION["userrole"]) && $_SESSION["userrole"] == "superadmin") 
	{
		session_destroy();
		header ("Location: login.php");
	}
	$imagefile = "";
	$errorimg= "";
	$caninsert="false";
//echo isset($_SESSION['uname']); exit;
	if (!(isset($_SESSION['uname']) && $_SESSION['uname'] != '')) {
		header ("Location: login.php");

	}
	
	if(isset($_POST['Submit']) && isset($_POST['Submit']) != '' ){
		$propname =mysql_real_escape_string($_POST['propname']);
		$propnum = mysql_real_escape_string($_POST['propnum']);
		$proptype = mysql_real_escape_string($_POST['proptype']);
		$propprice =mysql_real_escape_string($_POST['propprice']);
		$purpose = mysql_real_escape_string($_POST['purpose']);
		$propstatus = mysql_real_escape_string($_POST['propstatus']);
		/*$streetAddr = mysql_real_escape_string($_POST['streetAddr']);
		$district = mysql_real_escape_string($_POST['district']);
		$zone = mysql_real_escape_string($_POST['zone']);
		$country = mysql_real_escape_string($_POST['country']);*/
		$description = mysql_real_escape_string($_POST['description']);
		$landarea =mysql_real_escape_string($_POST['landarea']);
		$housearea = mysql_real_escape_string($_POST['housearea']);
		$parkingarea = mysql_real_escape_string($_POST['parkingarea']);
		$floor = mysql_real_escape_string($_POST['floor']);
		$bedroom =mysql_real_escape_string($_POST['bedroom']);
		$bathroom = mysql_real_escape_string($_POST['bathroom']);
		$livingroom = mysql_real_escape_string($_POST['livingroom']);
		$roaddist = mysql_real_escape_string($_POST['roaddist']);
		$facetoward = mysql_real_escape_string($_POST['facetoward']);
		$dining = mysql_real_escape_string($_POST['diningroom']);
		$agent = mysql_real_escape_string($_POST['agent']);
		 $gaddress = mysql_real_escape_string($_POST['pacinput']); ////var_dump($_POST['pacinput']);
		 $glat = mysql_real_escape_string($_POST['lat']);
		 $glng = mysql_real_escape_string($_POST['lng']);
		
		$caninsert = "false";
		
		// Variable for indexing uploaded image.
		$j = 0;   
		// Declaring Path for uploaded images.  
		$target_path = "images/uploaded/".$_SESSION["uname"]."/";      
		if (!file_exists($target_path)){
				mkdir($target_path, 0777, true);
			}
			
			
		for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
			// Loop to get individual element from the array
			// Extensions which are allowed.
			$validextensions = array("jpeg", "jpg", "png");  
			// Explode file name from dot(.)    
			$ext = explode('.', basename($_FILES['file']['name'][$i]));
			// Store extensions in the variable.   
			$file_extension = end($ext); 
			// Set the target path with a new name of image.
			$target_path = $target_path .$ext[0] .md5(uniqid()) . "." . $ext[count($ext) - 1];   
			// Increment the number of uploaded images according to the files in array.
			$j = $j + 1; 
			// Approx. 100kb files can be uploaded.     
			if (($_FILES["file"]["size"][$i] < 100000) && in_array($file_extension, $validextensions)) {
				if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
					// If file moved to uploads folder.
					//echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
					$imagefile[$i] = $target_path;
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
		}
		
		if($caninsert == "true" && $_POST['propnumErrMsg'] == "" &&  $_POST['propnameErrMsg'] == ""){
		  $sql = "INSERT INTO `home property`(`HomeName`, `HomeType`, `gaddress`, `glat`, `glng`, `Floor`, `Room`, `Bathroom`, `HomeNum`, `Dinning`, `Living`, `LandArea`, `HouseArea`, `ParkingArea`, `MainRoadDistance`, `FaceToward`, `Status`, `EntryDate`, `SalesDate`, `Description`, `Username`, `Price`, `Purpose`, `agent`) VALUES ('".$propname."', '".$proptype."', '".$gaddress."', '".$glat."', '".$glng."', '".$floor."', '".$bedroom."', '".$bathroom."', '".$propnum."', '".$dining."', '".$livingroom."', '".$landarea."', '".$housearea."', '".$parkingarea."', '".$roaddist."', '".$facetoward."', '".$propstatus."', '".date("Y-m-d h:s:ia")."',  '"."', '".$description."', '".$_SESSION["uname"]."', '".$propprice."', '".$purpose."', '".$agent."')";
		//echo "======<br>" ; //var_dump($sql); 
		execute($sql);  //exit;
		
		$sql = "SELECT `Email` FROM `agentdetail` WHERE `id`='".$agent."'";
		$resultAgentEmail = getSingleRow($sql);
		$agentEmail = $resultAgentEmail["Email"];
		
		$sql = "SELECT `First Name`,`Email`,`Contact` FROM `userprofile` WHERE `UserName`='".$_SESSION["uname"]."'";
		$resultOwnerInfo = getSingleRow($sql);

		$msg = sendMail($agentEmail,"New Contract", "Dear Sir/Madam,<br/> You have been choosen as an agent for ".$propname.", ".$propnum."<br/>Please note down the contact information of the client.<br/>Name: ".$resultOwnerInfo["First Name"]."<br/>Contact Number: ".$resultOwnerInfo["Contact"]."<br/>Email: ".$resultOwnerInfo["Email"],$headers, "");
		
		for($i=0; $i<count($imagefile);$i++){
			$sql = "INSERT INTO `photo gallery`(`PhotoURL`, `Username`, `Propname`, `Propnum`) VALUES ('".$imagefile[$i]."','".$_SESSION["uname"]."','".$propname."','".$propnum."')";
			execute($sql); 
		}
		header("location:property-detail.php?HomeName=".$propname);
	  }

	}
?>
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/securitycaptcha.js"></script>
<script>
var abc = 0; 
	$(document).ready(function(e) { 
        $('#category').change(function(e) {
            if($('#category').val() == "home"){
				window.location.href="homesaleAdd.php"
			} else if ($('#category').val() == "land"){
				window.location.href="landsaleAdd.php";
			}
        });		
			
		$('#propnum').blur(function(e) {
            if ($('#propnum').val() != ""){
				//alert($('#propnum').val());
				 $.ajax({
                    type: "POST",
                    url: "AjaxValidation.php",
                    data: { value: encodeURIComponent($("#propnum").val()), tablename: "`home property`", fieldname: "HomeNum",function: "CheckPropAvailablity"},                   
					success: function (response) {
						var result = $.parseJSON(response);
						//alert(response.IsNameExist);
					    if(result.IsNameExist == "0"){
							$('#propnumErrImg').css('display','block');
							$('#propnumErrImg').attr('src','images/right.png');
							$('#propnumErrMsg').css('display','none');
							$('#propnumErrMsg').attr('value', '');
						} else {
							$('#propnumErrImg').css('display','block');
							$('#propnumErrImg').attr('src','images/wrong.png');
							$('#propnumErrMsg').css('display','block');
							$('#propnumErrMsg').attr('value', 'Prooperty Number already Exists.');
						}
                    },
                 failure: function () {
                     window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
                    }
             	});
				
			}
        });
		
		$('#propname').blur(function(e) {
            if ($('#propname').val() != ""){
				//alert($('#propname').val());
				 $.ajax({
                    type: "POST",
                    url: "AjaxValidation.php",
                    data: { value: encodeURIComponent($("#propname").val()), tablename: "`home property`",fieldname: "HomeName",function: "CheckPropAvailablity"},                   
					success: function (response) {
						var result = $.parseJSON(response);
						//alert(response.IsNameExist);
					    if(result.IsNameExist == "0"){
							$('#propnameErrImg').css('display','block');
							$('#propnameErrImg').attr('src','images/right.png');
							$('#propnameErrMsg').css('display','none');
							$('#propnameErrMsg').attr('value', '');
						} else {
							$('#propnameErrImg').css('display','block');
							$('#propnameErrImg').attr('src','images/wrong.png');
							$('#propnameErrMsg').css('display','block');
							$('#propnameErrMsg').attr('value', 'Property Name already Exists.');
						}
                    },
                 failure: function () {
                     window.location("Gallery.aspx?micid=" + "<%=this.micid%>");
                    }
             	});
				
			}
        });
		
		//  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
	$('#add_more').click(function() {
		$(this).before($("<div/>", {
		id: 'filediv',
		style: 'float:left'
		}).fadeIn('slow').append($("<input/>", {
		name: 'file[]',
		type: 'file',
		id: 'file'
		}), $("<br/>")));
	});
	// Following function will executes on change event of file input to select different file.
	$('body').on('change', '#file', function() {
		if (this.files && this.files[0]) {
		abc += 1; // Incrementing global variable by 1.
		var z = abc - 1;
		var x = $(this).parent().find('#previewimg' + z).remove();
		$(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
		var reader = new FileReader();
		reader.onload = imageIsLoaded;
		reader.readAsDataURL(this.files[0]);
		$(this).hide();
		$("#abcd" + abc).append($("<img/>", {
		id: 'img',
		src: 'x.png',
		alt: 'delete'
		}).click(function() {
		$(this).parent().parent().remove();
		}));
		}
	});
	// To Preview Image
	function imageIsLoaded(e) {
		$('#previewimg' + abc).attr('src', e.target.result);
		};
		$('#upload').click(function(e) {
		var name = $(":file").val();
		if (!name) {
		//alert("First Image Must Be Selected");
		e.preventDefault();
	}
});

	$('#submitform').submit(function(e) {
			if($('#propnameErrMsg').val() != "" || $('#propnumErrMsg').val() !="" || $('#captchaErrMsg').val() != "OK You are not Robot"){
				e.preventDefault();
			}
        });
		
		$('#security_code').blur(function(e) {
            if ($('#security_code').val() != ""){
				 checkCaptcha($('#security_code').val());
				}
        });
		
		
});
</script>

<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="index.php">Home</a> / Add Property</span>
    <h2>Buy, Sale & Rent</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="properties-listing spacer">
<div class="row" style="margin-left:16px">
<?php include 'leftcontainer.php' ?>


      <div class="col-lg-6 col-sm-6 " style="width: 75%">
	<form enctype="multipart/form-data"  method="post" id="submitform">
		<fieldset>
        <table style="background:url('images/bgmain.png') repeat scroll 0% 0% #EEE">
        	<tr>
               <td> <label style="margin-top: -10px; float: left;">Category</label></td>
                <td><select id="category" name="category" class="form-control" style="width:45%">
                    	<option value="home">Home</option>
                	    <option value="land">Land</option>
                	</select></td>  
            </tr>
            <tr>
                <td><label style="margin-top: -10px; float: left;">Property Name<sup>*</sup></label></td>
                <td><input name="propname" type="text"  class="form-control" id="propname" style="width:45%; float:left"  placeholder="Property Name" value="<?php echo $propname; ?>" required="required">
                <img id="propnameErrImg" src="images/right.png" style="width:40px; display:none; float:left; margin-top: 5px;
  margin-left: 13px;"><input id="propnameErrMsg" name="propnameErrMsg" style="color:#F00; font-size:16px; width: 40%; display:none" readonly="readonly" required="required"></input>
                
                </td>
                <td ></td>
            </tr>
             <tr>
                <td><label style="margin-top: -10px; float: left;">Property Number<sup>*</sup></label></td>
                <td><input name="propnum" style="width:45%; float:left" type="text" class="form-control" id="propnum"  placeholder="Property Number" value="<?php echo $propnum; ?>" required="required">
                <img id="propnameErrImg" src="images/right.png" style="width:40px; display:none; float:left; margin-top: 5px;
  margin-left: 13px;"><input id="propnumErrMsg" name="propnumErrMsg"  readonly="readonly" style="color:#F00; font-size:16px; width:40%; display:none"></input>
                
                </td>
                <td ></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Property Type<sup>*</sup></label></td>
                    <td><select  name="proptype" id="proptype" style="width:45%" class="form-control"  placeholder="Property Type" value="<?php echo $proptype; ?>" required="required">
                    	<option value="Apartment">Apartment</option>
                	    <option value="Bunglaow">Bunglaw</option>
            	        <option value="CommercialBuilding">Commercial Building</option>
        	            <option value="House">Home</option>
    	                <option value="hotelResort">Hotel & Resort</option>
	                    <option value="OfficeSpace">Office Space</option>
                	</select></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Price<sup>*</sup></label></td>
  				<td><input type="text" id="propprice" style="width:45%" name="propprice" class="form-control"  placeholder="Property Price" value="<?php echo $propprice; ?>" required="required"></td>
            </tr>
            <tr>
               <td> <label style="margin-top: -10px; float: left;">Purpose<sup>*</sup></label></td>
                <td><select id="purpose" style="width:45%" name="purpose" class="form-control" value="<?php echo $purpose; ?>" required="required">
                    	<option value="rent">Rent</option>
                	    <option value="sale">Sale</option>
                	</select></td>
                
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;" required="required">Status<sup>*</sup></label></td>
                 <td><select id="propstatus" name="propstatus" style="width:45%" class="form-control"  placeholder="Property Status" value="<?php echo $propstatus; ?>">
                    	<option value="new">New</option>
                	    <option value="booked">Booked</option>
            	        <option value="sold">Sold</option>
                	</select></td>
            </tr>
            <tr>
            <?php $sql = "SELECT id, CONCAT(`FirstName`, ' ', `LastName`) AS Name FROM `agentdetail`"; $agentList = getMultipleRow($sql); ?>
            	<td><label style="margin-top: -10px; float: left;">Choose Agent<sup>*</sup></label></td>
                 <td><select id="agent" name="agent" style="width:45%" class="form-control"  value="<?php echo $agent; ?>" required="required">
                 			<option value="">Select Agent</option>
                    	<?php for($i=0; $i < count($agentList); $i++) { $row = $agentList[$i]; 
                        echo '<option value="'.$row["id"].'">'.$row["Name"].'</option>'; }?>
                	</select></td>
            </tr>
           <?php /*?> <tr>
            	<td><label style="margin-top: -10px; float: left;" >Street Address<sup>*</sup></label></td>
                <td><input type="text" id="streetAddr"  style="width:45%" name="streetAddr" class="form-control"  placeholder="Street Address" value="<?php echo $streetAddr; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">District<sup>*</sup></label></td>
                <td><input type="text" id="district" style="width:45%" name="district" class="form-control"  placeholder="District" value="<?php echo $district; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Zone</label></td>
                <td><input type="text" id="zone" style="width:45%" name="zone" class="form-control"  placeholder="zone" value="<?php echo $zone; ?>"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;" required="required">Country<sup>*</sup></label></td>
                <td><input type="text" style="width:45%" id="country" name="country" class="form-control"  placeholder="Country" value="<?php echo $country; ?>"></td>
            </tr><?php */?>
            
            <tr><td></td><td><?php include 'regeocoding.php'; ?></td></tr>
            
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Description<sup>*</sup></label></td>
                <td><input type="textarea"  style="width:45%"id="description" name="description" class="form-control"  placeholder="Description" value="<?php echo $description; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Property Image<sup>*</sup></label></td>
                <td>First Field is Compulsory. Only JPEG,PNG,JPG Type Image Uploaded. Image Size Should Be Less Than 100KB. <br>
                 <div  id="filediv" style="float:left;">
                    <input name="file[]"  type="file" id="file"  required="required">
                    <div id="errormsg"><?php echo $errorimg; ?></div></div>
              <?php /*?><?php if(count($imagefile) == 0) { ?>
				    <div  id="filediv" style="float:left; width:40%">
                    <input name="file[]" type="file" id="file" >
                    <div id="errormsg"><?php echo $errorimg; ?></div></div>
               <?php } else { for ($i=0;$i < count($imagefile); $i++) { ?>
                	<div  id="filediv" style="float:left; width:40%">
				   <div id="abcd1" class="abcd"><img id="previewimg1" src="<?php echo $imagefile[$i]; ?>">
                   <img id="img" src="x.png" alt="delete"></div></div>
			   <?php } }?><?php */?>
                  <input type="button"   id="add_more" class="upload" value="Add More Files"/></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Land Area<sup>*</sup></label></td>
                <td><input type="number" style="width:45%; float:left" id="landarea" name="landarea" class="form-control"  placeholder="Land Area" style="float:left;" value="<?php echo $landarea; ?>" required="required">
                <label style="margin: 6px; float: left;">in Sq. Meter</label></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">House Area<sup>*</sup></label></td>
                <td><input type="number" style="width:45%; float:left" id="housearea" name="housearea" class="form-control"  placeholder="House Area" style="float:left;" value="<?php echo $housearea; ?>" required="required">
                <label style="margin: 6px; float: left;">in Sq. Meter</label></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Parking Area<sup>*</sup></label></td>
                <td><input type="number" style="width:45%; float:left" id="parkingarea" name="parkingarea" class="form-control"  placeholder="Parking Area" style="float:left;" value="<?php echo $parkingarea; ?>" required="required">
                <label style="margin: 6px; float: left;">in Sq. Meter</label></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Number of Floor<sup>*</sup></label></td>
                <td><input type="number" style="width:45%" id="floor" name="floor" class="form-control"  placeholder="Total No. of Floor" value="<?php echo $floor; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Number of Bed Rooms<sup>*</sup></label></td>
                <td><input type="number" style="width:45%" id="bedroom" name="bedroom" class="form-control"  placeholder="Total No. of Bed Room" value="<?php echo $bedroom; ?>" required="required"></td>
            </tr>
            <tr>   
            	<td><label style="margin-top: -10px; float: left;">Number of Bath Room<sup>*</sup></label></td>
                <td><input type="number" style="width:45%" id="bathroom" name="bathroom" class="form-control"  placeholder="Total No. of Bath Room" value="<?php echo $bathroom; ?>" required="required"></td>
            </tr>
            <tr>
            
            	<td><label style="margin-top: -10px; float: left;">Number of Living Room<sup>*</sup></label></td>
                <td><input type="number" style="width:45%" id="livingroom" name="livingroom" class="form-control"  placeholder="Total No. of Living Room" value="<?php echo $livingroom; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Number of Dining Room<sup>*</sup></label></td>
                <td><input type="number" style="width:45%" name="diningroom" id="diningroom" class="form-control"  placeholder="Total No. of Dining Room" value="<?php echo $dining; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Main Road Distance</label></td>
                <td><input type="number" style="width:45%;float:left" name="roaddist" id="road dist" class="form-control"  placeholder="Main Road Distance" style="float:left;" value="<?php echo $roaddist; ?>">
               <label style="margin-top: 6px; float: left;">in meter</label></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Face Towards<sup>*</sup></label></td>
                <td><select  name="facetoward" style="width:45%" id="facetoward" class="form-control"  placeholder="Face Toward" value="<?php echo $facetoward; ?>" required="required">
                    	<option value="east">East</option>
                	    <option value="west">West</option>
            	        <option value="north">North</option>
        	            <option value="south">South</option>
                	</select></td>
            </tr>
             <tr><td>Prove you are not ROBOT</td><td><label id="captcha" style="background-image:url(images/banner.jpg); width: 20%; margin-left:2%; text-align:center; color:#FFF"><?php echo $security_code; ?></label></td></tr>
          <tr><td> </td><td><input type="text" id="security_code" class="form-control" placeholder="Enter Above Text" name="security_code" style="width:25%; float:left" required="required" > <input id="captchaErrMsg" name="captchaErrMsg" style="font-size:16px; width: 20%; margin-left:3%; height: 20%; display:none" readonly="readonly"></td></tr>
            <tr> <td></td>
      			<td><button type="submit" style="width:45%" id="login" value="Submit" class="btn btn-success" name="Submit">Save</button></td>
            </tr>
            </table>
         </fieldset>
	</form>
                
        </div>
</div>

</div>
</div>
</div>
</div>
</div>

<?php include'footer.php';?>