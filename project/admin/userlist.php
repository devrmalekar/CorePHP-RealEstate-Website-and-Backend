<?php 
	include'header.php';
	if ($_SESSION["userrole"] 	!= "superadmin")
		{
			header("Location:../index.php");
		}
function sqlQueryValue()
	{
		$value="";
		if(isset($_GET["name"]) && !empty($_GET["name"])){
			$value = " AND `First Name` LIKE '".$_GET["name"]."%' OR `Last Name` LIKE '".$_GET["name"]."%'";
		}
		// code here to change where clause
		return $value;
	}
	
	function totalRecord($value){
		$sql = "SELECT * FROM `userprofile` WHERE `User Role`='user'";
		if ($value != "")
			$sql = $sql.$value;
		////var_dump($sql);
		$resultRC = getMultipleRow($sql);
		return count($resultRC); 
	}
	function homerentsale($value){
		$totalRecord = totalRecord($value);
		
		////var_dump($totalRecord); 
		$recordLimit = 10;
		if( isset($_POST{'page'} ) )
		{
		   $page = $_POST{'page'} + 1;
		   $offset = $rec_limit * $page ;
		}
		else
		{
		   $page = 0;
		   $offset = 0;
		}
		$leftRecord = $totalRecord - ($page * $recordLimit);
		
	 	$sql = "SELECT CONCAT(`First Name`,' ',`Last Name`) AS Name, Email, CONCAT(`Street`,', ',`City`) AS Addr, Country, Date FROM `userprofile` WHERE `User Role`='user'";
		
		if ($value != "" )
			$sql = $sql.$value;
		$sql = $sql." LIMIT $offset, $recordLimit";
	  /// //var_dump($sql); //exit;
		return getMultipleRow($sql);
	}	
?>
<html>
<head>
<title></title>
<script>
	$(document).ready(function(e) {
            $('#userlistli').addClass("active");
        $('#findnow').click(function (){
			
			window.location.replace("userlist.php?name="+$('#name').val());
		});
    });
</script>
</head>
<body>
<div class="container">
<div class="properties-listing spacer">
<div class="row">
 <div class="search-form" style="width:70%; float:left"><h4 style="float:left; margin: 5px;"><span class="glyphicon glyphicon-search"></span> Search By </h4>
    	<input type="text" id="name" class="form-control" placeholder="First Name or Last Name" style="width:22%; float:left; margin-right:2%">
        <button id="findnow" class="btn btn-primary" style="width:15%; float:left; margin-right:10%">Find Now</button>
    </div>

    <?php include 'leftcontainer.php'; ?>
          <div class="pull-left result" style="margin: 5px;"><label style="padding-right:15px;"><?php 
				$totalRecord = totalRecord(sqlQueryValue());
				if(isset($_GET['page'])){
				echo "Showing ".($_GET['page']) * 10 . " of " .$totalRecord ."Records" ;
				} else {
					echo ($totalRecord > 1)? "Showing ".$totalRecord ." Records" :  "Showing ".$totalRecord ." Record" ;
				} //} ?></label>
         <label style="margin: 5px; padding-left:15px;">Total Users : <?php echo $totalRecord; ?> </label>
               
	</div>
   </div>
   <div class="row">
<div id="searchcriteria">
	<table style="background-image:url(../images/bgmain.png);">
    	<tr>
        	<th>S.No.</th>
        	<th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Country</th>
            <th>Registered Date</th>
        </tr>
        <?php 
			$value = sqlQueryValue();
			$result = "";
            
            $result = homerentsale($value);
			
			//$result = getMultipleRow($sql);
			for($i = 0; $i < count($result); $i++){
				$row = $result[$i];
				echo'<tr>
					<td style="width:50px;">'.$i.'</td>
					<td style="width:200px">'.$row["Name"].'</td>
					<td style="width:300px">'.$row["Email"].'</td>
					<td style="width:300px">'.$row["Addr"].'</td>
					<td style="width:200px">'.$row["Country"].'</td>
					<td style="width:200px">'.$row["Date"].'</td>
				</tr>';
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
    </table>
</div>
</div>
</div>
</div>
</body>
</html>
<?php
	include'footer.php';
?>