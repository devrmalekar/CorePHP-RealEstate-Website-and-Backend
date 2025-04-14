<div class="col-lg-3 col-sm-4 ">
  <div class="search-form"><h4><span class="glyphicon glyphicon-search"></span> Search for</h4>
    <div class="row">
        <div class="col-lg-12">
              <select class="form-control" id="proptype">
                <option value="">Select Property</option>
                <option value="Home">Home</option>
                <option value="Land">Land</option>
              </select>
            </div>
    </div>
    <div class="row">
            <div class="col-lg-12">
              <select class="form-control" id="purpose">
                <option value="">Select Purpose</option>
                <option value="Rent">Rent</option>
                <option value="Sale">Sale</option>
              </select>
            </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <label class="form-control" style="text-align:center">Price</label>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-6">
        <input type="text" id="From" placeholder="From" class="form-control"/>
      </div>
      <div class="col-lg-6">
        <input type="text" id="To" placeholder="To" class="form-control"/>
      </div>
    </div>

         <!--  <div class="row">
         <div class="col-lg-12">
              <select class="form-control">
                <option>Property Type</option>
                <option>Apartment</option>
                <option>Building</option>
                <option>Office Space</option>
              </select>
              </div>
          </div>-->
          <button class="btn btn-primary" id="findnow">Find Now</button>
          <script>
		  	$(document).ready(function(e) {
                $('#findnow').click(function(e) {
					if($('#proptype').val() == "Home"){
                    	window.location.replace("homebuyrent.php?purpose="+$('#purpose').val()+"&pricefrom="+$('#From').val()+"&priceto="+$('#To').val());
					} else if ($('#proptype').val() == "Land"){
						window.location.replace("landbuyrent.php?purpose="+$('#purpose').val()+"&pricefrom="+$('#From').val()+"&priceto="+$('#To').text());
					}
                });
            });
          </script>
  </div>



<div class="hot-properties hidden-xs">
<h4>Hot Properties</h4>
<!-- home hot prop-->
<?php 
	$sql="SELECT hp . * , pg.`PhotoURL` 
			FROM  `home property` hp
			JOIN  `photo gallery` pg ON ( hp.`HomeName` = pg.`Propname` ) 
			JOIN (
				SELECT MIN(id) id, propname
				FROM  `photo gallery` 
				GROUP BY propname
			)pg1 ON ( pg.id = pg1.id
			AND pg.`Propname` = pg1.`Propname` ) WHERE `Status` <> 'Sold' ORDER BY RAND() LIMIT 2";
	$resutl = getMultipleRow($sql);
	for ($i=0; $i < count($resutl); $i++){
?>
<div class="row">
        <div class="col-lg-4 col-sm-5"><img src="<?php echo $resutl[$i]["PhotoURL"]; ?>" class="img-responsive img-circle" alt="properties"></div>
            <div class="col-lg-8 col-sm-7">
            <h5><a href="property-detail.php"><?php echo $resutl[$i]["HomeName"]; ?></a></h5>
            <p class="price"><?php echo $resutl[$i]["Price"]; ?></p> </div>
</div>
<?php } ?>
<!-- land hot prop-->

<?php 
	$sql="SELECT lp.*, pg.PhotoURL FROM `land property` lp JOIN `photo gallery` pg
	       ON (lp.`LandName` = pg.`Propname`)
		   JOIN (SELECT MIN(id) id, propname FROM `photo gallery` GROUP BY propname) pg1 ON
		   (pg.id = pg1.id AND pg.`Propname` = pg1.`Propname` ) WHERE `Status` <> 'Sold'  ORDER BY RAND() LIMIT 2";
	$resutl = getMultipleRow($sql);
	for ($i=0; $i < count($resutl); $i++){
?>
<div class="row">
        <div class="col-lg-4 col-sm-5"><img src="<?php echo $resutl[$i]["PhotoURL"]; ?>" class="img-responsive img-circle" alt="properties"></div>
            <div class="col-lg-8 col-sm-7">
            <h5><a href="property-detail.php"><?php echo $resutl[$i]["LandName"]; ?></a></h5>
            <p class="price"><?php echo $resutl[$i]["Price"]; ?></p> </div>
</div>
<?php } ?>


</div>
</div>
