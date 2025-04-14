<?php 
	include'header.php';
	if ( $_SESSION["userrole"] 	== "superadmin")
		{
			header("Location:admin/");
		}
	$imgsrc = "";
	if (!(isset($_SESSION['uname']) && $_SESSION['uname'] != '')) {
		header ("Location: login.php");
	}
	else if (isset($_SESSION["userrole"]) && $_SESSION["userrole"] == "superadmin") 
	{
		session_destroy();
		header ("Location: login.php");
	}
	//$totalRecord = 0;
	//include 'AjaxValidation.php';
	function totalRecord(){
		$sql = "SELECT * FROM `home property` WHERE `Username`='".$_SESSION['uname']."'";
		if ($value == "Rent" || $value == "Sale")
			$sql = $sql." WHERE `Purpose`='".$value."' ";
		$resultRC = getMultipleRow($sql);
		return count($resultRC); 
	}
	function homerentsale($value){
		$totalRecord = totalRecord();
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
		
	 	$sql = "SELECT HomeName, HomeNum,Status, Floor, Room, Living, Dinning, Bathroom, Price FROM `home property` WHERE `Username`='".$_SESSION['uname']."'";
		
		if ($value == "Rent" || $value == "Sale")
			$sql = $sql." and `Purpose`='".$value."' LIMIT $offset, $recordLimit";
		else if ($value == "PriceAsc")
			$sql = $sql." ORDER BY Price LIMIT $offset, $recordLimit";
		else if ($value == "PriceDsc")
			$sql = $sql." ORDER BY Price DESC LIMIT $offset, $recordLimit";
		else if ($value == "RecentPost")
			$sql = $sql." ORDER BY EntryDate LIMIT $offset, $recordLimit";
		else 
			$sql = $sql." LIMIT $offset, $recordLimit";
		
		return mysql_query($sql);
	}
?>

<script>
	$(document).ready(function(e) {
        $('#purpose').change(function(e) {
			var selectedVal = $('#purpose option:selected').val();
			if (selectedVal == "HomeRent"){
				window.location.href = "homerentsale.php?purpose=Rent";
			}
			else if (selectedVal == "HomeSale")
				window.location.href ="homerentsale.php?purpose=Sale";
        });
		
		$('#sortby').change(function(e) {
            var selectedVal = $('#sortby').val();
			window.location.href = "homerentsale.php?sortby="+selectedVal;
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
                $totalRecord = totalRecord();
                if(isset($_GET['page'])){
                echo "Showing ".($_GET['page']) * 10 . " of " .$totalRecord ."Records" ;
                } else {
                        echo ($totalRecord > 1)? "Showing ".$totalRecord ." Records" :  "Showing ".$totalRecord ." Record" ;
                } //}?>
            	</div>
      
                <div class="pull-right" id="purpose" style="float:left;">
                  <select class="form-control">
                      <option>View</option>
                      <option value="HomeRent">Home for Rent</option>
                      <option value="HomeSale">Home for Sale</option>
                  </select>
                </div>
                <div class="pull-right">
                    <select class="form-control" id="sortby">
                      <option>Sort by</option>
                      <option value="PriceAsc">Price: Low to High</option>
                      <option value="PriceDsc">Price: High to Low</option>
                      <option value="RecentPost">Recent Post</option>
                    </select>
                </div>
        	</div>
        <div class="row" id="contentrow">
         <!-- properties -->
             <div id="changeablerow">
             <?php 
                 $value = "";
             $resultHP = "";
            if(isset($_GET['purpose']) && !empty($_GET['purpose'])){
                $value=$_GET['purpose'];
            }
            else if (isset($_GET['sortby']) && !empty($_GET['sortby'])){
                    $value = $_GET['sortby'];
            }
            $resultHP = homerentsale($value);
               while ($row = mysql_fetch_array($resultHP))
                {
                    $href = "homesaleedit.php?HomeName=".(urlencode($row['HomeName']));
        			$sql = "SELECT `PhotoURL` FROM `photo gallery` WHERE `Username`='".$_SESSION["uname"]."' and `Propname`='".$row["HomeName"]."' and `Propnum`='".$row["HomeNum"]."' ORDER BY RAND() LIMIT 1";
					$imgsrc = getSingleRow($sql);
                    echo '<div class="col-lg-4 col-sm-6">
                            <div class="properties">
                                <div class="image-holder">
                                    <img src="'.$imgsrc["PhotoURL"].'" class="img-responsive" alt="properties">
                                        <div class="status sold">'.$row["Status"].'</div>
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