<?php 
	include'header.php';
	
	//$totalRecord = 0;
	//include 'AjaxValidation.php';
	function sqlQueryValue()
	{
		$value = "";
		if(isset($_GET['purpose']) && !empty($_GET['purpose'])){
			$value=" WHERE `Purpose`='".mysql_real_escape_string($_GET['purpose'])."' ";////var_dump($value); 
		}
		if(isset($_GET['proptype']) && !empty($_GET['proptype'])){
			////var_dump(strpos($value, "WHERE")); 
			if(strpos($value, "WHERE") !== false){
				$value = $value." AND `HomeType`='".mysql_real_escape_string($_GET['proptype'])."'";
			} else {
				$value = " WHERE `HomeType`='".mysql_real_escape_string($_GET['proptype'])."'";
			}
		}
		if(isset($_GET['pricefrom']) && !empty($_GET['pricefrom'])){
			if(strpos($value, "WHERE") !== false){
				$value = $value." AND `Price`>'".mysql_real_escape_string($_GET['pricefrom'])."'";
			} else {
				$value = " WHERE `Price`>'".mysql_real_escape_string($_GET['pricefrom'])."'";
			}
		}
		if(isset($_GET['priceto']) && !empty($_GET['priceto'])){
			if(strpos($value, "WHERE") !== false){
				$value = $value. " AND `Price`<'".mysql_real_escape_string($_GET['priceto'])."'";
			} else {
				$value = " WHERE `Price`<'".mysql_real_escape_string($_GET['priceto'])."'";
			}
		}
		
		if (isset($_GET['sortby']) && !empty($_GET['sortby'])){
			if ($value != ""){
				switch ($_GET['sortby']){
				  case "PriceAsc":
					  $value = $value." ORDER BY Price  ";
					  break;
				  case "PriceDsc":
					  $value = $value." ORDER BY Price DESC ";
					  break;
				  case "RecentPost":
					  $value = $value." ORDER BY EntryDate ";
					  break;
				}
			}
			else {
				switch ($_GET['sortby']){
				  case "PriceAsc":
					  $value = " ORDER BY Price  ";
					  break;
				  case "PriceDsc":
					  $value = " ORDER BY Price DESC ";
					  break;
				  case "RecentPost":
					  $value = " ORDER BY EntryDate ";
					  break;
				}
			}
		}
		return $value;
	}
	
	function totalRecord($value){
		$sql = "SELECT * FROM `home property` ";
		if ($value != "")
			$sql = $sql.$value;
		
		$resultRC = getMultipleRow($sql);
		return count($resultRC); 
	}
	function homerentsale($value){
		$totalRecord = totalRecord($value);
		////var_dump($totalRecord); 
		$recordLimit = 10;
		if( isset($_GET{'page'} ) )
		{
		   $page = $_GET{'page'} + 1;
		   $offset = $rec_limit * $page ;
		}
		else
		{
		   $page = 0;
		   $offset = 0;
		}
		$leftRecord = $totalRecord - ($page * $recordLimit);

	 	$sql = "SELECT HomeName, Username ,HomeNum, Purpose,Status, Floor, Room, Living, Dinning, Bathroom, Price FROM `home property`";
		
		if ($value != "" ){
			$sql = $sql.$value." LIMIT $offset, $recordLimit";
			}
		return mysql_query($sql);
	}
?>

<script>
	$(document).ready(function(e) {
        $('#purpose').change(function(e) {
			var selectedVal = $('#purpose').val();
			  if ($('#sortby').val().length == 0 && selectedVal != 'view')
				  window.location.href = "homebuyrent.php?purpose="+selectedVal;
			  else if ($('#sortby').val() != 'sort')
				  window.location.href = "homebuyrent.php?purpose="+selectedVal+"&sortby="+$('#sortby').val();
        });
		
		$('#sortby').change(function(e) {
            var selectedVal = $('#sortby').val();
			window.location.href = "homebuyrent.php?sortby="+selectedVal;
			 if ($('#purpose').val().length == 0 && selectedVal != 'sort')
				  window.location.href = "homebuyrent.php?sortby="+selectedVal;
			  else if ($('#purpose').val() != 'view')
				  window.location.href = "homebuyrent.php?sortby="+selectedVal+"&purpose="+$('#purpose').val();
        });
    });
</script>
    <!-- banner -->
    <div class="inside-banner">
      <div class="container"> 
        <span class="pull-right"><a href="index.php">Home</a> / Buy</span>
        <h2>Buy, Sale & Rent</h2>
    </div>
    </div>
	<!-- banner -->
    <div class="container">
    <div class="properties-listing spacer">
    
        <div class="row">
    <?php include 'leftcontainer.php'; ?>
        <div class="col-lg-9 col-sm-8">
            <div class="sortby clearfix">
                <div class="pull-left result"><?php 
                $totalRecord = totalRecord(sqlQueryValue());
                if(isset($_GET['page'])){
                echo "Showing ".($_GET['page']) * 10 . " of " .$totalRecord ."Records" ;
                } else {
                        echo ($totalRecord > 1)? "Showing ".$totalRecord ." Records" :  "Showing ".$totalRecord ." Record" ;
                } //}?>
            	</div>
      
                <div class="pull-right" style="float:left;">
                  <select class="form-control" id="purpose" >
                      <option value="view">View</option>
                      <option value="Rent" <?php if ($_GET['purpose'] == 'Rent') { ?> selected="selected" <?php } ?> >Home for Rent</option>
                      <option value="Sale" <?php if ($_GET['purpose'] == 'Sale') { ?> selected="selected" <?php } ?> >Home for Sale</option>
                  </select>
                </div>
                <div class="pull-right">
                    <select class="form-control" id="sortby">
                      <option value="sort">Sort by</option>
                      <option value="PriceAsc" <?php if ($_GET['sortby'] == 'PriceAsc') { ?> selected="selected" <?php } ?> >Price: Low to High</option>
                      <option value="PriceDsc" <?php if ($_GET['sortby'] == 'PriceDsc')  { ?> selected="selected" <?php } ?> >Price: High to Low</option>
                      <option value="RecentPost" <?php if ($_GET['sortby'] == 'RecentPost') { ?> selected="selected" <?php } ?> >Recent Post</option>
                    </select>
                </div>
        	</div>
        <div class="row" id="contentrow">
         <!-- properties -->
             <div id="changeablerow">
             <?php 
             $value = sqlQueryValue();
             $resultHP = "";
            
            $resultHP = homerentsale($value);
               while ($row = mysql_fetch_array($resultHP))
                {
                    $href = "property-detail.php?HomeName=".str_replace(" ","%20",$row['HomeName']);
        			$sql = "SELECT `PhotoURL` FROM `photo gallery` WHERE `Username`='".$row["Username"]."' and `Propname`='".$row["HomeName"]."' and `Propnum`='".$row["HomeNum"]."' ORDER BY RAND() LIMIT 1";
					$imgsrc = getSingleRow($sql);
					if($imgsrc["PhotoURL"] == ""){
						$imgsrc["PhotoURL"]="images/NoHome.jpg";
					}
					////var_dump($sql);//var_dump($imgsrc); exit;
                    echo '<div class="col-lg-4 col-sm-6">
                            <div class="properties">
                                <div class="image-holder">
                                    <img src="'.$imgsrc["PhotoURL"].'" class="img-responsive" alt="properties">
                                        <div class="status sold">'.$row["Status"].' | '.$row['Purpose'].'</div>
                                </div>
                                <h4><a href='.$href.'>'.$row["HomeName"].'</a></h4>
                                <p class="price">Price: Rs.'. $row["Price"].'</p>
                                <div class="listing-detail">
                                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Floor">'.$row["Floor"].'</span> 
                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room">'. $row["Room"].'</span>
                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room">'. $row["Living"].'</span> 
                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bath Room">'. $row["Bathroom"].'</span>         
                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Dining Room">'. $row["Dinning"].'</span> 
                                    <a class="btn btn-primary" href="property-detail.php?HomeName="'.$row["HomeName"].'">View Details</a>
                            </div>
                    </div></div>';
                }
                if ($totalRecord > 11){
                    echo '<div class="center"> <ul class="pagination">';
                    if( $page > 0 )
                    {
                       $last = $page - 2;
                       echo "<li><a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a> |</li>";
                       echo "<li><a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a></li>";
                    }
                    else if( $page == 0 )
                    {
                       echo "<li><a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a></li>";
                    }
                    else if( $left_rec < $rec_limit )
                    {
                       $last = $page - 2;
                       echo "<li><a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a></li>";
                    }
                    echo '</ul> </div>';
                }
             ?>
             </div>
            </div>
    
        </div>
    </div>
    </div>
</div>
</div>

<?php include'footer.php';?>