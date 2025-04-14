<?php 
	include'header.php';
	if ( $_SESSION["userrole"] 	!= "superadmin")
		{
			header("Location:../index.php");
		}
function sqlQueryValue()
	{
		$value="";
		// code here to change where clause
		return $value;
	}
	
	function totalRecord($value){
		$sql = "SELECT * FROM `agentdetail` ";
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
		
	 	$sql = "SELECT CONCAT(FirstName, ' ', LastName) AS Name ,Description, Contact,Email, Status, imgURL FROM `agentdetail`";
		
		if ($value != "" )
			$sql = $sql.$value;
		$sql = $sql." LIMIT $offset, $recordLimit";
	   ////var_dump($sql); //exit;
		return mysql_query($sql);
	}
?>
<script>
   $(document).ready(function (e)){
      $('#agentli').addClass("active");
   }
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
  <div class="col-lg-8  col-lg-offset-2 col-sm-12">
      <!-- agents -->
      <?php 
             $value = sqlQueryValue();
             $resultHP = "";
            
            $resultHP = homerentsale($value);
			
               while ($row = mysql_fetch_array($resultHP))
               {
				   echo '  <div class="row">
        <div class="col-lg-2 col-sm-2 "><img src="'.$row["imgURL"].'" class="img-responsive"  alt="agent name" style="height: 100px;"></div>
        <div class="col-lg-7 col-sm-7 "><h4>'.$row["Name"].'</h4><p>'.$row["Description"].'</p><p>'.$row["Status"].'</p></div>
        <div class="col-lg-3 col-sm-3 "><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:'.$row["Email"].'">'.$row["Email"].'</a><br>
        <span class="glyphicon glyphicon-earphone"></span>'.$row["Contact"].'<br/>
		<form method="post" action="addAgent.php"><input name="contact" hidden="true" value="'.$row["Contact"].'" /><button class="form-control" id="editAgent" name="editAgent">Edit</button></form></div>
      </div>';
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
    
      <!-- agents -->
      
      
     
  </div>
</div>


</div>
</div>

<?php include'footer.php';?>