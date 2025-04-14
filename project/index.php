<?php include'header.php';
		if ( $_SESSION["userrole"] 	== "superadmin")
		{
			header("Location:admin/");
		}

	$sql = "SELECT hp . * , pg.`PhotoURL` 
			FROM  `home property` hp
			JOIN  `photo gallery` pg ON ( hp.`HomeName` = pg.`Propname` ) 
			JOIN (
				SELECT MIN(id) id, propname
				FROM  `photo gallery` 
				GROUP BY propname
			)pg1 ON ( pg.id = pg1.id
			AND pg.`Propname` = pg1.`Propname` )  ORDER BY RAND() LIMIT 4 ";
	$result = getMultipleRow($sql);
	$sql = "SELECT `BusinessBackground` FROM `about`";
	$about = getSingleRow($sql);
	
	$sql = "SELECT Area, Description, gaddress,Price, PhotoURL FROM `home property`, `photo gallery` WHERE `Status` != 'Sold' and `photo gallery`.`Propname` = `home property`.`HomeName` ORDER BY RAND() LIMIT 4 ";
	
	$sql ="SELECT lp . * , pg.`PhotoURL` 
			FROM  `land property` lp
			JOIN  `photo gallery` pg ON (lp.`LandName` = pg.`Propname`) 
			JOIN (
				SELECT MIN(id) id, propname
				FROM  `photo gallery` 
				GROUP BY propname
			)pg1 ON (pg.id = pg1.id
			AND pg.`Propname` = pg1.`Propname`)  ORDER BY RAND() LIMIT 4";
	$resultlp = getMultipleRow($sql);
//	//var_dump($sql); //var_dump($result); exit;
?>
<script>
   $(document).ready(function (e){
       $('#homeli').addClass("active");
   })

</script>

<div class="">
            <div id="slider" class="sl-slider-wrapper">

        <div class="sl-slider">
   <?php  for ($i =0; $i < count($result); $i++){ ?>

          <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="2">
            <div class="sl-slide-inner">
              <div class="<?php echo "bg-img bg-img-".$i; ?>"><img src="<?php echo $result[$i]["PhotoURL"];?>"  style="width:inherit; height:inherit""/></div>
              <h2><a href="#"><?php  echo $result[$i]["Room"]."Bed Rooms and ".$result[$i]["Dinning"]." Dinning Room ".$result[$i]["HomeType"]." on ".$result[$i]["Purpose"]; ?></a></h2>
              <blockquote>              
              <p class="location"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $result[$i]["gaddress"]; ?></p>
              <p><?php echo $result[$i]["Description"];?></p>
              <cite><?php echo "Rs.".$result[$i]["Price"]; ?></cite>
              </blockquote>
            </div>
          </div>
          <?php } for ($i =0; $i < count($resultlp); $i++){ ////var_dump($resultlp[$i]["Purpose"]); exit;?>
           <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-25" data-slice1-scale="1.5" data-slice2-scale="1.5">
            <div class="sl-slide-inner">
               <div class="<?php echo "bg-img bg-img-".$i; ?>"><img src="<?php echo $resultlp[$i]["PhotoURL"];?>"  style="width:inherit; height:inherit""/></div>
              <h2><a href="#"><?php  echo $resultlp[$i]["Area"]." sq. km. Land on ".$result[$i]["Purpose"]; ?></a></h2>
              <blockquote>              
              <p class="location"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $result[$i]["gaddress"]; ?></p>
              <p><?php echo $resultlp[$i]["Description"];?></p>
              <cite><?php echo "Rs.".$resultlp[$i]["Price"]; ?></cite>
              </blockquote>
            </div>
          </div>
  <?php  } ?>
         
 -->       </div><!-- /sl-slider -->



        <nav id="nav-dots" class="nav-dots">
          <span class="nav-dot-current"></span>
          <?php $total = count($result) + count($resultlp);  for ($i =1; $i < ($total); $i++){ ?>
         	 <span></span>
          <?php } ?>
        </nav>

      </div><!-- /slider-wrapper -->
</div>



<div class="banner-search">
  <div class="container"> 
    <!-- banner -->
    <h3>Buy, Sale & Rent</h3>
    <div class="searchbar">
      <div class="row">
        <div class="col-lg-4 col-sm-6">
        <div class="col-lg-3 col-sm-3 " style="width:100%;" >
           <select class="form-control" id="proptype" style="width:50%; float:left">
                <option value="">Select Property</option>
                <option value="Home">Home</option>
                <option value="Land">Land</option>
              </select>
              
              <select class="form-control" id="purpose" style="width:50%">
                <option value="">Select Purpose</option>
                <option value="Rent">Rent</option>
                <option value="Sale">Sale</option>
              </select>
            </div>
          
           
            <div class="col-lg-3 col-sm-4" style="width:80%; float left;">
            
              <input type="number" id="From" placeholder="From" class="form-control" style="width: 33%; float: left;"/>
               <input type="number" id="To" placeholder="To" class="form-control" style="width: 33%; float: left;"/>
           <!-- </div>-->
           <!-- <div class="col-lg-3 col-sm-4">
            <select class="form-control">
                <option>Property</option>
                <option>Apartment</option>
                <option>Building</option>
                <option>Office Space</option>
              </select>
              </div>
              <div class="col-lg-3 col-sm-4"> -->
              <button class="btn btn-success"  id="findnow" style="width: 34%;">Find Now</button>
               <script>
		  	$(document).ready(function(e) {
                $('#findnow').click(function(e) {
					if($('#proptype').val() == "Home"){
                    	window.location.replace("homebuyrent.php?purpose="+$('#purpose').val()+"&proptype="+$('#proptype').val()+"&pricefrom="+$('#From').text()+"&priceto="+$('#To').text());
					} else if ($('#proptype').val() == "Land"){
						window.location.replace("landbuyrent.php?purpose="+$('#purpose').val()+"&pricefrom="+$('#From').text()+"&priceto="+$('#To').text());
					}
                });
            });
          </script>

              
          </div>
          
          
        </div>
        <div class="col-lg-5 col-lg-offset-1 col-sm-6 ">
          <p>Join now and get updated with all the properties deals.</p>
          <button class="btn btn-info"   data-toggle="modal" data-target="#loginpop">Login</button>        </div>
      </div>
    </div>
  </div>
</div>
<!-- banner -->
<div class="container">
	<?php 
		$sql ="SELECT hp . * , pg.`PhotoURL` 
		FROM  `home property` hp
		JOIN  `photo gallery` pg ON ( hp.`HomeName` = pg.`Propname` ) 
		JOIN (
			SELECT MIN( id ) id, propname
			FROM  `photo gallery` 
			GROUP BY propname
		)pg1 ON ( pg.id = pg1.id
			AND pg.`Propname` = pg1.`Propname` )  ORDER BY RAND() LIMIT 4 ";
		$result = getMultipleRow($sql);
		if (count($result)>0){ ?>
  <div class="properties-listing spacer"> <a href="homebuyrent.php" class="pull-right viewall">View All Listing</a>
    <h2>Featured Property</h2>
    <div id="owl-example" class="owl-carousel">
    <?php
	for($i=0; $i < count($result); $i++){
?>
      <div class="properties">
        <div class="image-holder">
        	<img src="<?php echo $result[$i]["PhotoURL"]; ?>" class="img-responsive" alt="properties"/>
          	<div class="status sold"><?php echo $result[$i]["Status"]; ?></div>
        </div>
        <h4><a href="property-detail.php?HomeName=<?php echo $result[$i]["HomeName"];?>"><?php echo $result[$i]["HomeName"]; ?></a></h4>
        <p class="price">Price: <?php echo "Rs.".$result[$i]["Price"]; ?></p>
        <div class="listing-detail">
        	<span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room"><?php echo $result[$i]["Room"]; ?></span> 
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room"><?php echo $result[$i]["Living"]; ?></span> 
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Parking"><?php echo $result[$i]["ParkingArea"]; ?></span> 
            <span data-toggle="tooltip" data-placement="bottom" data-original-title="Dinning"><?php echo "2"; ?></span> 
        </div>
       	<a class="btn btn-primary" href="property-detail.php?HomeName=<?php echo $result[$i]["HomeName"];?>">View Details</a>
      </div>
     <?php } ?> 
     <?php
	  $sql = "SELECT lp.*, pg.PhotoURL FROM `land property` lp JOIN `photo gallery` pg
	       ON (lp.`LandName` = pg.`Propname`)
		   JOIN (SELECT MIN(id) id, propname FROM `photo gallery` GROUP BY propname) pg1 ON
		   (pg.id = pg1.id AND pg.`Propname` = pg1.`Propname` )  ORDER BY RAND() LIMIT 4 ";
	$resultland = getMultipleRow($sql);
	for($i=0; $i < count($resultland); $i++){ ////var_dump($resultland); exit;
?>
      <div class="properties">
        <div class="image-holder">
        	<img src="<?php echo $resultlp[$i]["PhotoURL"]; ?>" class="img-responsive" alt="properties"/>
          	<div class="status sold"><?php echo $resultland[$i]["Status"]; ?></div>
        </div>
        <h4><a href="property-detail.php?LandName=<?php echo $resultland[$i]["LandName"];?>"><?php echo $resultland[$i]["LandName"]; ?></a></h4>
        <p class="price">Price: <?php echo "Rs.".$resultlp[$i]["Price"]; ?></p>
        <div class="listing-detail">
        	<span data-toggle="tooltip" data-placement="bottom" data-original-title="Area in sq ft"><?php  echo $resultland[$i]["Area"]; ?></span>
                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Distance from main road"><?php echo $resultland[$i]["MainRoadDistance"]; ?></span> 
        </div>
<!--       	<a class="btn btn-primary" href="property-detail.php?LandName=<?php echo $resultland[$i]["LandName"];?>">View Details</a>-->
      </div>
     <?php } ?>
     </div></div> <?php } 
	 // SELECT LandName, Username ,LandNumber, Status, Area, Price, MainRoadDistance, Purpose FROM `land property`
	 
	
	//if (count($resultland) > 0) { 	
	 ?>
     <!--<div class="properties-listing spacer"> <a href="landbuyrent.php" class="pull-right viewall">View All Listing</a>
	  <h2>Featured Land</h2>
     <div id="owl-example" class="owl-carousel">
    	 </div>
    </div>-->
  <div class="spacer">
    <div class="row">
      <div class="col-lg-6 col-sm-9 recent-view">
        <h3>About Us</h3>
        <p><?php echo $about["BusinessBackground"]; ?><br><a href="about.php">Learn More</a></p>
      
      </div>
      
      <?php /*?><div class="col-lg-5 col-lg-offset-1 col-sm-3 recommended">
        <h3>Recommended Properties</h3>
        <div id="myCarousel" class="carousel slide">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1" class=""></li>
            <li data-target="#myCarousel" data-slide-to="2" class=""></li>
            <li data-target="#myCarousel" data-slide-to="3" class=""></li>
          </ol>
           <div class="carousel-inner">
          <?php 
	$sql="SELECT `HomeName`, `Price`, `PhotoURL` FROM `home property`, `photo gallery` WHERE `home property`.`HomeName` = `photo gallery`.`Propname` AND `Status` <> 'Sold' ORDER BY `counter` LIMIT 2";
	$resulthome = getMultipleRow($sql);
	
?>
		
               <?php 
	$sql="SELECT `LandName`, `Price`, `PhotoURL` FROM `land property`, `photo gallery` WHERE `land property`.`LandName` = `photo gallery`.`Propname` AND `Status` <> 'Sold' ORDER BY `counter` LIMIT 2";
	$resultland = getMultipleRow($sql);
?>
            
          <!-- Carousel items 
          <div class="carousel-inner">
            <div class="item active">
              <div class="row">
                <div class="col-lg-4"><img src="<?php echo $result[] ?>" class="img-responsive" alt="properties"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p>
                  <a href="property-detail.php" class="more">More Detail</a> </div>
              </div>
            </div>
            <div class="item">
              <div class="row">
                <div class="col-lg-4"><img src="images/properties/2.jpg" class="img-responsive" alt="properties"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p>
                  <a href="property-detail.php" class="more">More Detail</a> </div>
              </div>
            </div>
            <div class="item">
              <div class="row">
                <div class="col-lg-4"><img src="images/properties/3.jpg" class="img-responsive" alt="properties"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p>
                  <a href="property-detail.php" class="more">More Detail</a> </div>
              </div>
            </div>
            <div class="item">
              <div class="row">
                <div class="col-lg-4"><img src="images/properties/4.jpg" class="img-responsive" alt="properties"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p>
                  <a href="property-detail.php" class="more">More Detail</a> </div>
              </div>
            </div>-->
          </div>
        </div>
      </div><?php */?>
    </div>
  </div>
</div>
<?php include'footer.php';?>