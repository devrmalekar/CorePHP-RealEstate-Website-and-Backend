<?php
function getSingleRow($sql)
{
        $qry_result=mysql_query($sql) or die("Query ERROR.<br>".mysql_error());
        $result=mysql_fetch_assoc($qry_result);
		if ($result)
		{
        	return $result;
		}
		else
		{
			return NULL;
		}
}

function getMultipleRow($sql)
{
    $i=0;
    $data=array();
     $query_result=mysql_query($sql) or die("QUERY ERROR1=>".mysql_error());
     while ($row=mysql_fetch_assoc($query_result)) {
            $data[$i] = $row;
            $i++;
    }
    return $data;
}

function execute($sql)
{
    mysql_query($sql) or die("Query ERROR".mysql_error());
}

function getextension($file)
{
    $explode=explode(".", $file);
    $extension=$explode[sizeof($explode)-1];
    return $extension;
}

// Define a 32-byte (64 character) hexadecimal encryption key
// Note: The same encryption key used to encrypt the data must be used to decrypt the data
define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');

// Encrypt Function
function mc_encrypt($encrypt, $key){
    $encrypt = serialize($encrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $key = pack('H*', $key);
    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    return $encoded;
}

// Decrypt Function
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
	echo "decrypted 2 ".$decrypted.'<br>';
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}

function get_ip() {

		//Just get the headers if we can or else use the SERVER global
		if ( function_exists( 'apache_request_headers' ) ) {

			$headers = apache_request_headers();

		} else {

			$headers = $_SERVER;

		}

		//Get the forwarded IP if it exists
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

			$the_ip = $headers['X-Forwarded-For'];

		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {

			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];

		} else {
			
			//$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
			$the_ip = $_SERVER['REMOTE_ADDR'];
		}
		return $the_ip;

	}
	
	//check if the ip exist in database;
	function isIPExists($Name){
		$ipAddress = strval(get_ip());
		$sql = "SELECT ipAddr FROM `IpAddrLog` WHERE ipAddr = '".$ipAddress."' AND Name='".$Name."'";
		////var_dump($sql);  exit;
		$isExist = execute($sql);
		if($isExist["ipAddr"] != ""){
			return true;
		} else {
			return false;
		}
	}
	
	function sendMail($to,$subject,$message,$headers, $replyTo){
		$send_contact = mail($to,$subject,$message,$headers);
		if ($send_contact)
		{
			if($replyTo != ""){
				mail($replyTo,"Your message has been sent","Thank You for your message. Your message is so important to us and we will respond as soon as possible.<br/>*** This is an automatically generated email, please do not reply ***","From: ".$to);
			}
			$message= "Successfully Sent. \nYou will be replied as soon as possible.";
			////var_dump($message); exit;
		}
		else{
			$message = "OOPS!!! Sorry, Message sending Failed!. Try Again Later.";
		}
		return $message;
	}

?>
