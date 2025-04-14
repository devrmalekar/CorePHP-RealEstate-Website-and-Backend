<?php
	include 'includes/db_connect.php';
	include 'includes/functions.php'; 
	session_start();
	//$_POST("propname");
	$function = filter_input(INPUT_POST, "function");//$_POST("function");
	
	if ($function == "CheckPropAvailablity"){
		CheckPropAvailablity();
	} else if ($function == "buysalerent"){
		homerentsale();
	} else if ($function == "DelUploadedImg"){
		DelUploadedImg();
	}
	else if ($function == "CheckSecurityCode"){
		CheckSecurityCode();
	}
	
	function CheckPropAvailablity(){
		$value= urldecode(filter_input(INPUT_POST, "value"));
		$filed = urldecode(filter_input(INPUT_POST, "fieldname"));
		$tablename = urldecode(filter_input(INPUT_POST, "tablename"));
		$sql = "SELECT COUNT(*) AS IsNameExist  FROM ".$tablename." WHERE `".$filed."` = '".trim($value)."'";
		$result = getSingleRow($sql);
		$arr = array ($sql, $result);
		echo json_encode($result);
	}
	
	function CheckSecurityCode(){
		$value= urldecode(filter_input(INPUT_POST, "value"));
		$result =  array("IsNameExist" => 1);
		if($_SESSION["security_code"] == $value){
			$result["IsNameExist"] = 0;
		}
		echo json_encode($result);
	}
	function homerentsale(){
		$sql = "SELECT COUNT(*) FROM `home property`";
		$resultRC = getSingleRow($sql); 
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
		
	 	$sql = "SELECT HomeName, Status, Floor, Room, Living, Dinning, Bathroom, Price FROM `home property` LIMIT $offset, $recordLimit";
		$resultHP = mysql_query($sql);
		
	}
	
	function DelUploadedImg(){
		$imgurl = filter_input(INPUT_POST, "imgurl");
		$propname = urldecode(filter_input(INPUT_POST, "propname"));
		$propnum = urldecode(filter_input(INPUT_POST, "propnum"));
		$isExists = file_exists($imgurl);
		if ($isExists){
			//unlink($imgurl);
			$sql = "DELETE FROM `photo gallery` WHERE `Username`='".$_SESSION["uname"]."' and  `Propname` ='".$propname."' and `Propnum`='".$propnum."'";
			//echo json_encode($imgurl);
			$data = $sql."<br>".$propname."<br>".$imgurl."<br>".$propnum;
			$arr = array($imgurl, $propname, $propnum, $isExists, $sql);
			execute($sql);	
		}
	}
?>