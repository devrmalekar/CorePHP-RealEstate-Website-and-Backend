<?php 
//Let's generate a totally random string using md5 
	$md5_hash = md5(rand(0,999)); 
    //We don't need a 32 character long string so we trim it down to 5 
    $security_code = substr($md5_hash, 15, 5); 
	
    //Set the session to store the security code
    $_SESSION["security_code"] = $security_code;

?>