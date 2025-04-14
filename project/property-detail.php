<?php 
	include'header.php';
	$ipAddress = get_ip();
	$message = "";
	
	
	if(isset($_GET["HomeName"])){
		$sql = "SELECT * FROM `home property` WHERE `HomeName` = '".mysql_real_escape_string($_GET['HomeName'])."'";
		$resultHP = getSingleRow($sql);
		$lat = $resultHP["glat"];
		$lng = $resultHP["glng"];
		$_SESSION["subject"] = "Home Name - ". $resultHP["HomeName"]." & Home Number - ".$resultHP["HomeNum"] ;
		$isIpExsists = isIPExists($resultHP["HomeNum"]);
		if(!$isIpExsists){
			$sql = "INSERT INTO `ipaddrlog`(`ipAddr`, `Name`) VALUES ('".$ipAddress."', '".$resultHP["HomeNum"]."')";
			execute($sql);
			$counter = $resultHP["counter"] + 1;
			$sql = "UPDATE `home property` SET `counter`='".$counter."' WHERE `HomeName` = '".$resultHP["HomeName"]."'";
			execute($sql);
			
		}
		$sql = "SELECT * FROM `agentdetail` WHERE `id` = '".$resultHP['agent']."'";
		$resultUP = getSingleRow($sql);
		$sql = "SELECT `PhotoURL` FROM `photo gallery` WHERE `Username`='".$resultHP["Username"]."' and `Propname`='".$resultHP["HomeName"]."' and `Propnum`='".$resultHP["HomeNum"]."'";
		$imgURLs = getMultipleRow($sql);
		////var_dump($sql)."<br>".//var_dump($imgURLs[0]["PhotoURL"]); exit;
	} else if (isset($_GET["LandName"])){
		$sql = "SELECT * FROM `land property` WHERE `LandName` = '".mysql_real_escape_string($_GET['LandName'])."'";
		$resultHP = getSingleRow($sql);
		$_SESSION["subject"] = "Land Name - ". $resultHP["LandName"]." & Land Number - ".$resultHP["LandNumber"] ;
		$isIpExsists = isIPExists($resultHP["LandNumber"]);
		if(!$isIpExsists){
			$sql = "INSERT INTO `ipaddrlog`(`ipAddr`, `Name`) VALUES ('".$ipAddress."', '".$resultHP["LandNumber"]."')";
			execute($sql);
			$counter = $resultHP["counter"] + 1;
			$sql = "UPDATE `land property` SET `counter`='".$counter."' WHERE `LandName` = '".$resultHP["LandName"]."'";
			execute($sql);
		}
		$sql = "SELECT * FROM `agentdetail` WHERE `id` = '".$resultHP['agent']."'";
		$resultUP = getSingleRow($sql);
		$lat = $resultHP["glat"];
		$lng = $resultHP["glng"];
		$sql = "SELECT `PhotoURL` FROM `photo gallery` WHERE `Username`='".$resultHP["Username"]."' and `Propname`='".$resultHP["LandName"]."' and `Propnum`='".$resultHP["LandNumber"]."'";
		$imgURLs = getMultipleRow($sql);
	
	}
	else {
		header('location: index.php');
	}
	if(isset($_POST["SubmitMsg"])){
		$to = $resultUP["Email"];
		$subject = "Enquiry from ".$_POST["name"].$_SESSION["subject"];
		$headers = "From: ". $_POST["email"]."\r\n";
		$message = sendMail($to,$subject,$_POST["msg"],$headers, $_POST["email"]);
	}
?>

<!-- banner -->
<div class="inside-banner">
  	<div class="container"> 
        <span class="pull-right"><a href="#">Home</a> / Buy</span>
        <h2>Buy</h2>
	</div>
</div>
<!-- banner -->
<div class="container">
    <div class="properties-listing spacer">
   		<div class="row">
			<?php include 'leftcontainer.php'; ?>
            <div class="col-lg-9 col-sm-8 ">
            <?php if($message != "") { echo '<label>'.$message.'</label>';} else { ?>
            <h2><?php echo $resultHP['HomeName']; ?></h2>
            <div class="row">
              <div class="col-lg-8">
              <div class="property-images">
                <!-- Slider Starts -->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators hidden-xs">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                     <?php for($i=1; $i < count($imgURLs); $i++){ ?> 
                        <li data-target="#myCarousel" data-slide-to="<?php echo "$i;"?>" class=""></li>
                    <?php }?>
                  </ol>
                  <div class="carousel-inner">
                     <div class="item active">
                     <?php if($imgURLs[0]["PhotoURL"] == "") $imgURLs[0]["PhotoURL"] = "images/NoHome.jpg"; ?>
                      <img src="<?php echo $imgURLs[0]["PhotoURL"];?>" class="properties" alt="properties" />
                    </div>
                    
                    <?php for($i=1; $i < count($imgURLs); $i++){ ?>  
                        <div class="item ">
                            <img src="<?php echo $imgURLs[$i]["PhotoURL"]; ?>" class="properties" alt="properties" />
                        </div>
                    <?php }?>
                  </div>
                  <?php if(count($imgURLs[0]["PhotoURL"]) > 1) { ?>
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                  <?php } ?>
                </div>
            <!-- #Slider Ends -->
            
              </div>
              
            
            
            
              <div class="spacer"><h4><span class="glyphicon glyphicon-th-list"></span> Properties Detail</h4>
              <p><?php echo $resultHP['Description']; if (isset($_GET['HomeName'])){ ?><table style="background-image: url(images/bgmain.png)">
                <tr>
                    <td><?php echo "House Type"; ?></td>
                    <td><?php echo ": ".$resultHP['HomeType']; ?></td>
                </tr>
                
                <tr>
                    <td><?php  echo "House Number"; ?></td>
                    <td><?php echo ": ".$resultHP['HomeNum'] ; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Land Area"; ?></td>
                    <td><?php echo ": ".$resultHP['LandArea'] ; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "House Area"; ?></td>
                    <td><?php echo ": ".$resultHP['HouseArea']; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Parking Area"; ?></td>
                    <td><?php echo ": ".$resultHP['ParkingArea']; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Faced Toward"; ?></td>
                    <td><?php echo ": ".$resultHP['FaceToward']; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Distance From Main Road"; ?></td>
                    <td><?php echo ": ".$resultHP['MainRoadDistance']; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Purpose"; ?></td>
                    <td><?php echo ": ".$resultHP['Purpose']; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Status"; ?></td>
                    <td><?php echo ": ".$resultHP['Status']; ?></td>
                </tr>
              </table><?php } else if (isset($_GET['LandName'])){ ?><table style="background-image: url(images/bgmain.png)">
                <tr>
                    <td><?php echo "Land Name"; ?></td>
                    <td><?php echo ": ".$resultHP['LandName']; ?></td>
                </tr>
                
                <tr>
                    <td><?php  echo "Land Number"; ?></td>
                    <td><?php echo ": ".$resultHP['LandNumber'] ; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Land Area"; ?></td>
                    <td><?php echo ": ".$resultHP['Area'] ; ?></td>
                </tr>
               
                <tr>
                    <td><?php echo "Distance from Main Road"; ?></td>
                    <td><?php echo ": ".$resultHP['MainRoadDistance']; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Purpose"; ?></td>
                    <td><?php echo ": ".$resultHP['Purpose']; ?></td>
                </tr>
                
                <tr>
                    <td><?php echo "Status"; ?></td>
                    <td><?php echo ": ".$resultHP['Status']; ?></td>
                </tr>
              </table><?php } ?></p>
              </div>
              <div><h4><span class="glyphicon glyphicon-map-marker"></span> Location</h4> 
              
                <?php include 'gplaces.php'; ?>
            
              <?php /*?><?php $Addr = $resultHP['StreetAddr'].",+".$resultHP['District'].",+".$resultHP['Country']; ?>
            <div class="well"><iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $Addr; ?>&amp;aq=0&amp;oq=pulch&amp;sll=37.0625,-95.677068&amp;sspn=39.371738,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=Pulchowk,+Patan+Dhoka,+Patan,+Bagmati,+Central+Region,+Nepal&amp;ll=27.678236,85.316853&amp;spn=0.001347,0.002642&amp;t=m&amp;z=14&amp;output=embed"></iframe></div><?php */?>
              </div>
            
              </div>
              <div class="col-lg-4">
              <div class="col-lg-12  col-sm-6">
            <div class="property-info">
            <p class="price">Rs. <?php echo $resultHP['Price']; ?></p>
              <p class="area"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $resultHP['StreetAddr'].", ".$resultHP['District'].", ".$resultHP['Country']?></p>
              
              <div class="profile">
              <span class="glyphicon glyphicon-user"></span> User / Agent Details
              <p><?php echo $resultUP["FirstName"]." ".$resultUP["LastName"]."<br>".$resultUP["Contact"]."<br>".$resultUP["Email"] ?></p>
              </div>
            </div>
            
                <h6><span class="glyphicon glyphicon-home"></span> Availabilty</h6>
                <div class="listing-detail">
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Floor"><?php echo $resultHP['Floor']; ?></span> 
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room"><?php echo $resultHP['Room']; ?></span>
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room"><?php echo $resultHP['Living']; ?></span> 
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bath Room"><?php echo $resultHP['Bathroom']; ?></span>         
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Dining Room"><?php echo $resultHP['Dinning']; ?></span> 
                </div>
            
            </div>
            <div class="col-lg-12 col-sm-6 ">
            <div class="enquiry">
              <h6><span class="glyphicon glyphicon-envelope"></span> Post Enquiry</h6>
              <form method="POST" action="#">
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required/>
                            <input type="email" name="email" class="form-control" placeholder="you@yourdomain.com" required/>
                            <input type="number" name="contact" class="form-control" placeholder="your number" required/>
                            <textarea rows="6" class="form-control" name="msg" placeholder="Your Message Please" required></textarea>
                  <button type="submit" class="btn btn-primary" name="SubmitMsg">Send Message</button>
                  </form>
             </div>         
            </div>
              </div>
            </div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include'footer.php';?>