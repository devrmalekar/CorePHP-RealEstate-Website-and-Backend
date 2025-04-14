<?php 
	include '../includes/db_connect.php';
	include '../includes/functions.php';
	
	if (!isset($_SESSION["userrole"]) && $_SESSION["userrole"] != "superadmin")
	{
		header("Location:../index.php");
	} 
	session_start();
	error_reporting(0);
	
	$BusinessBackground = urldecode(filter_input(INPUT_POST, "BusinessBackground"));
	$CompanyProfile = urldecode(filter_input(INPUT_POST, "CompanyProfile"));
	$ContactNo = urldecode(filter_input(INPUT_POST, "ContactNo"));
	$fb = urldecode(filter_input(INPUT_POST, "fb"));
	$linkledn = urldecode(filter_input(INPUT_POST, "linkledn"));
	$gplus = urldecode(filter_input(INPUT_POST, "gplus"));
	$twitter = urldecode(filter_input(INPUT_POST, "twitter"));
	$email = urldecode(filter_input(INPUT_POST, "email"));
	$name = urldecode(filter_input(INPUT_POST, "name"));
	$updName = urldecode(filter_input(INPUT_POST, "updName"));
	
	if($updName == ""){
		$sql = "UPDATE `about` SET  `BusinessBackground`='".$BusinessBackground."', `CompanyProfile`='".$CompanyProfile."', `Contact No`='".$ContactNo."',`fb`='".$fb."',`linkledn`='".$linkledn."',`gplus`='".$gplus."', `twitter`='".$twitter."', `email`='".$email."'"; 
	} else if ($updName == "updName") {
		$sql = "UPDATE `about` SET `Name`='".$name."'"; 
	}
	
	////var_dump($sql);
	execute($sql);
	header("Location: about.php");
?>