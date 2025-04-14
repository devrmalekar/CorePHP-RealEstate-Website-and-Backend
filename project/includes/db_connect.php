<?php
// Create connection
$con = mysqli_connect("localhost", "root", "p@ssw0rd")
 or die("Unable to connect to MySQL");


//select a database to work with
mysqli_select_db($con, "realestate")
  or die("Could not select database");


?>


