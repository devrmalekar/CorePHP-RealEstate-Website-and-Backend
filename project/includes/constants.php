<?php
if($_SERVER['HTTP_HOST'] == "localhost" or $_SERVER['HTTP_HOST'] == "localhost:8080" or $_SERVER['HTTP_HOST'] == "127.0.0.1" )
{
	define("HOST","localhost");
	define("USER","root");
	define("PASS","");
	define("DBNAME","it3rd");
}
?>