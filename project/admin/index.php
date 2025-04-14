<?php 
	include'header.php';
	if ( $_SESSION["userrole"] 	!= "superadmin")
		{
			header("Location:../index.php");
		}
	else {
		header("Location:dashboard.php");
	}
?>