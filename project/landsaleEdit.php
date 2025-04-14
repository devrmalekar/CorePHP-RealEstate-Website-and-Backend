<?php 
	include'header.php';
	include 'generateSC.php';
	if ( $_SESSION["userrole"] 	== "superadmin")
		{
			header("Location:admin/");
		}
//echo isset($_SESSION['uname']); exit;
	if (!(isset($_SESSION['uname']) && $_SESSION['uname'] != '')) {
		header ("Location: login.php");
	}
	else if (isset($_SESSION["userrole"]) && $_SESSION["userrole"] == "superadmin") 
	{
		session_destroy();
		header ("Location: login.php");
	}
	
	if(!isset($_GET["LandName"]) && empty($_GET["LandName"])){
		header ("Location: selectpropertyLand.php");
	}
	
	$newimagefile = "";
	$errorimg= "";
	$caninsert=false;
	
	$sql = "SELECT `LandName`, `LandNumber`, `StreetAddr`, `District`, `Zone`, `Country`, `WardNo`, `Area`, `MainRoadDistance`, `Status`, `Description`, `Username`, `Price`, `EntryDate`, `SalesDate`, `agent`, `gaddress`, `glat`, `glng` FROM `land property` WHERE `LandName` = '".urldecode($_GET["LandName"])."' and `Username`='".$_SESSION['uname']."'";
	
	$result = getSingleRow($sql);
	$propname =$result['LandName'];
	$propnum = $result['LandNumber'];
	$propprice =$result['Price'];
	$purpose = $result['Purpose'];
	$propstatus = $result['Status'];
	$wardno = $result['WardNo'];
	$streetAddr = $result['StreetAddr'];
	$district = $result['District'];
	$zone = $result['Zone'];
	$country = $result['Country'];
	$description = $result['Description'];
	$landarea =$result['Area'];
	$roaddist = $result['MainRoadDistance'];
	$entrydate = $result['EntryDate'];
	$salesdate = $result['SalesDate'];
	$agent = $result['agent'];
	$gaddress = $result['gaddress'];
	$glat = $result['glat'];
	$glng = $result['glng'];
	
	
	$ex_agent = $agent;
	
	$sql = "SELECT `PhotoURL` FROM `photo gallery` WHERE `Username`='".$_SESSION["uname"]."' and  `Propname` ='".$propname."' and `Propnum`='".$propnum."'";
	
	$imagefile=getMultipleRow($sql);	// //var_dump($imagefile); exit;
	
	if(isset($_POST['Submit']) && isset($_POST['Submit']) != '' ){
		$propname =mysql_real_escape_string($_POST['propname']);
		$propnum = mysql_real_escape_string($_POST['propnum']);
		$propprice =mysql_real_escape_string($_POST['propprice']);
		$purpose = mysql_real_escape_string($_POST['purpose']);
		$propstatus = mysql_real_escape_string($_POST['propstatus']);
		/*$wardno = mysql_real_escape_string($_POST['wardnum']);
		$streetAddr = mysql_real_escape_string($_POST['streetAddr']);
		$district = mysql_real_escape_string($_POST['district']);
		$zone = mysql_real_escape_string($_POST['zone']);
		$country = mysql_real_escape_string($_POST['country']);*/
		$description = mysql_real_escape_string($_POST['description']);
		$landarea =mysql_real_escape_string($_POST['landarea']);
		$roaddist = mysql_real_escape_string($_POST['roaddist']);
		$newagent = mysql_real_escape_string($_POST['agent']);
		$gaddress = mysql_real_escape_string($_POST['pacinput']); ////var_dump($_POST['pacinput']);
		 $glat = mysql_real_escape_string($_POST['lat']);
		 $glng = mysql_real_escape_string($_POST['lng']);
		 
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
					$newimagefile[$i] = $target_path;
					////var_dump($imagefile[$i]); exit;
					$caninsert = true;
					$errorimg = 'Image uploaded successfully!.';
				} else {     //  If File Was Not Moved.
					//echo $j. ').<span id="error">please try again!.</span><br/><br/>'; exit;
					$errorimg = 'Error while uploading '.$filename.'<br>Please try again!.';
					$caninsert = false;
				} 
			} else {     //   If File Size And File Type Was Incorrect.
				  $errorimg = 'Error while uploading. ***Invalid file Size or Type***<br>';
				  $caninsert = false; 
				  /*//var_dump($_FILES['file']['tmp_name'][$i]);
				  //var_dump($target_dir); exit;*/
			}
		}
		if($caninsert){
			$sql = "UPDATE `land property` SET  `gaddress` = '".$gaddress."', `glat`='".$glat."', `glng`= '".$glng."',  `Area`='".$landarea."', `MainRoadDistance`='".$roaddist."', `Status`='".$propstatus."', `EntryDate`='".$entrydate."', `SalesDate` = '".$salesdate."', `Description`='".$description."', `Username`='".$_SESSION["uname"]."', `Price`='".$propprice."', `agent`='".$newagent."' WHERE `HomeName` = '".urldecode($_GET["HomeName"])."' and `Username`='".$_SESSION['uname']."'";
			//echo "======<br>" ; //var_dump($sql); exit;
			execute($sql); 
			
			$sql = "SELECT `Email` FROM `agentdetail` WHERE `id`='".$agent."'";
		$resultAgentEmail = getSingleRow($sql);
		$agentEmail = $resultAgentEmail["Email"];
		
		$sql = "SELECT `First Name`,`Email`,`Contact` FROM `userprofile` WHERE `UserName`='".$_SESSION["uname"]."'";
		$resultOwnerInfo = getSingleRow($sql);
		
		
		$msg = sendMail($agentEmail,"New Contract", "Dear Sir/Madam,<br/> You have been choosen as an agent for ".$propname.", ".$propnum."<br/>Please note down the contact information of the client.<br/>Name: ".$resultOwnerInfo["First Name"]."<br/>Contact Number: ".$resultOwnerInfo["Contact"]."<br/>Email: ".$resultOwnerInfo["Email"],$headers, "");
		
		$sql = "SELECT `Email` FROM `agentdetail` WHERE `id`='".$ex_agent."'";
		$resultAgentEmail = getSingleRow($sql);
		$agentEmail = $resultAgentEmail["Email"];
		
		$msg = sendMail($agentEmail,"Sorry For the information", "Dear Sir/Madam,<br/> You have been disselect as an agent for ".$propname.", ".$propnum,$headers, "");
		
			for($i=0; $i<count($newimagefile);$i++){
				if(!file_exists($newimagefile))
				$sql = "INSERT INTO `photo gallery`(`PhotoURL`, `Username`, `Propname`, `Propnum`) VALUES ('".$newimagefile[$i]."','".$_SESSION["uname"]."','".$propname."','".$propnum."')";
				execute($sql); 
			}
			header("Location: selectproperty.php");
				//echo $sql . "<br>" . "inserted succesfully"; exit;
		}
	}
?>
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/securitycaptcha.js"></script>
<script>
	var abc = 0; 
	$(document).ready(function(e) { 
		//  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
		$('#add_more').click(function() {
			$(this).before($("<div/>", {
			id: 'filediv'
			}).fadeIn('slow').append($("<input/>", {
			name: 'file[]',
			type: 'file',
			id: 'file'
			}), $("<br/><br/>")));
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
		
		$('.uploadedimg').click(function(e) {
            $(this).parent().parent().remove();
			//alert($(this).attr('id'));
			var id = $(this).attr('id');
			var imgid = "previewimguploaded"+id.split("-")[1];
			//alert(imgid);
			var imgurl = $(this).parent().find('img[id='+imgid+']').attr('src');
			$.ajax({
				type: 'POST',
				url:'AjaxValidation.php',
				data:{imgurl: imgurl, function:'DelUploadedImg', propname: encodeURIComponent($('#propname').val()), propnum:encodeURIComponent($('#propnum').val()) },	
				success: function (response){
				
				}
			});
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

<div class="row">
<?php include 'leftcontainer.php' ?>
      <div class="col-lg-6 col-sm-6 " style="width: 90%">
	<form enctype="multipart/form-data"  method="post" id="submitform">
		<fieldset>
         <table style="background:url('images/bgmain.png') repeat scroll 0% 0% #EEE">
         	<tr>
               <td> <label style="margin-top: -10px; float: left;">Category</label></td>
                <td><select id="category" name="category" style="width: 45%" class="form-control">
                    	<option value="home">Home</option>
                	    <option value="land" selected="selected">Land</option>
                	</select></td>  
            </tr>
            <tr>
                <td><label style="margin-top: -10px; float: left;">Land Name<sup>*</sup></label></td>
                <td><input name="propname" type="text" style="width: 45%; float:left"  class="form-control" id="propname"  placeholder="Property Name" value="<?php echo $propname; ?>" required="required">
               <img id="propnameErrImg" src="images/right.png" style="width:40px; display:none; float:left; margin-top: -18px;
  margin-left: 13px;"><input id="propnameErrMsg" name="propnameErrMsg" style="color:#F00; font-size:16px; width: 40%; display:none"></input></td>
            </tr>
             <tr>
                <td><label style="margin-top: -10px; float: left;">Land Number<sup>*</sup></label></td>
                <td><input name="propnum" style="width: 45%; float:left" type="text" class="form-control" id="propnum"  placeholder="Property Number" value="<?php echo $propnum; ?>" required="required">
                <img id="propnameErrImg" src="images/right.png" style="width:40px; display:none; float:left; margin-top: -18px;
  margin-left: 13px;"><input id="propnumErrMsg" name="propnumErrMsg" style="color:#F00; font-size:16px; width: 40%; display:none"></input></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Price<sup>*</sup></label></td>
  				<td><input type="text" style="width: 45%; float:left" id="propprice" name="propprice" class="form-control"  placeholder="Property Price" value="<?php echo $propprice; ?>" required="required"></td>
            </tr>
            <tr>
               <td> <label style="margin-top: -10px; float: left;">Purpose<sup>*</sup></label></td>
                <td><select id="purpose" style="width: 45%; float:left" name="purpose" class="form-control" value="<?php echo $purpose; ?>" required="required">
                    	<option value="rent">Rent</option>
                	    <option value="sale">Sale</option>
                	</select></td>  
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Status<sup>*</sup></label></td>
                 <td><select id="propstatus" style="width: 45%; float:left" name="propstatus" class="form-control"  placeholder="Property Status" value="<?php echo $propstatus; ?>" required="required">
                    	<option value="New">New</option>
                	    <option value="Sold">Sold</option>
            	        <option value="Booked">Booked</option>
                        <option value="On Rent">Rented</option>
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
            	<td><label style="margin-top: -10px; float: left;">Ward Number<sup>*</sup></label></td>
                <td><input type="number" style="width: 45%; float:left" id="wardnum" name="wardnum" class="form-control"  placeholder="Ward Number" value="<?php echo $streetAddr; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Street Address<sup>*</sup></label></td>
                <td><input type="text" style="width: 45%; float:left" id="streetAddr" name="streetAddr" class="form-control"  placeholder="Street Address" value="<?php echo $streetAddr; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">District<sup>*</sup></label></td>
                <td><input type="text" style="width: 45%; float:left" id="district" name="district" class="form-control"  placeholder="District" value="<?php echo $district; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Zone</label></td>
                <td><input type="text" style="width: 45%; float:left" id="zone" name="zone" class="form-control"  placeholder="zone" value="<?php echo $zone; ?>"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Country<sup>*</sup></label></td>
                <td><input type="text" style="width: 45%; float:left" id="country" name="country" class="form-control"  placeholder="Country" value="<?php echo $country; ?>" required="required"></td>
            </tr><?php */?>
            
             <tr><td></td>z<td><?php include 'regeocoding.php'; ?></td></tr>
            
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Description<sup>*</sup></label></td>
                <td><input type="textarea" style="width: 45%; float:left" id="description" name="description" class="form-control"  placeholder="Description" value="<?php echo $description; ?>" required="required"></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Property Image<sup>*</sup></label></td>
               <td>First Field is Compulsory. Only JPEG,PNG,JPG Type Image Uploaded. Image Size Should Be Less Than 100KB. <br>
              <?php if(count($imagefile) == 0) { ?>
				    <div  id="filediv" style="float:left; width:40%">
                    <input name="file[]" type="file" id="file" required="required">
                    <div id="errormsg"><?php echo $errorimg; ?></div></div>
               <?php } else { for ($i=0;$i < count($imagefile); $i++) { ?>
                	<div  id="filediv" style="float:left; width:40%">
				   <div id="abcd1" class="abcd" style="position: relative; left: 0; top: 0;"><img id="<?php echo 'previewimguploaded'.($i+1) ?>" src="<?php echo $imagefile[$i]["PhotoURL"]; ?>" style="position: relative; top: 0; left: 0;">
                   <img class="uploadedimg" id="<?php echo "uploadedimg-".($i+1)?>"src="x.png" alt="delete" style="position: absolute;  top: 0px; left: 67%; width: 25px; height: 25px;"></div></div>
			   <?php } }?>  <input type="button" id="add_more" class="upload" value="Add More Files"/></td>
            </tr>
           <tr>
            	<td><label style="margin-top: -10px; float: left;">Land Area<sup>*</sup></label></td>
                <td><input type="number" style="width: 45%; float:left" id="landarea" name="landarea" class="form-control"  placeholder="Land Area" style="float:left;" value="<?php echo $landarea; ?>" required="required">
                <label style="margin: 6px; float: left;">in Sq. Meter</label></td>
            </tr>
            <tr>
            	<td><label style="margin-top: -10px; float: left;">Main Road Distance</label></td>
                <td><input type="number" style="width: 45%; float:left" name="roaddist" id="road dist" class="form-control"  placeholder="Main Road Distance" style="float:left;" value="<?php echo $roaddist; ?>">
                <label style="margin: 6px; float: left;">in km</label></td>
            </tr>
            <tr><td>Prove you are not ROBOT</td><td><label id="captcha" style="background-image:url(images/banner.jpg); width: 20%; margin-left:2%; text-align:center; color:#FFF"><?php echo $security_code; ?></label></td></tr>
          <tr><td> </td><td><input type="text" id="security_code" class="form-control" placeholder="Enter Above Text" name="security_code" style="width:25%; float:left" required="required" > <input id="captchaErrMsg" name="captchaErrMsg" style="font-size:16px; width: 20%; margin-left:3%; height: 20%; display:none" readonly="readonly"></td></tr>
            <tr> <td></td>
            <tr>
      			<td><button type="submit" style="width: 45%; float:left" id="login" value="Submit" class="btn btn-success" name="Submit">Log In</button></td>
            </tr>
            </table>

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