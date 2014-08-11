<?php
	require_once("conf.php"); 

	function getHost(){
		$httpURL = "http"; 
		if($_SERVER['SERVER_PORT']=="443")
			$httpURL .= "s"; 
		$httpURL .= "://"; 
		$httpURL .= $_SERVER['SERVER_NAME']; 
		if($_SERVER['SERVER_PORT']!=80)
			$httpURL .= $_SERVER['SERVER_PORT']; 
		$httpURL .= $GLOBALS['folder']; 
		if(substr($httpURL, strlen($httpURL)-1))
			$httpURL .= "/"; 

		return $httpURL; 
	}

	function getIP(){
		// You should log all IP istead of log single IP
		// and beware of injection form IP
		// All source can be faked easily except "REMOTE_ADDR"
		$source = array(
			"HTTP_CLIENT_IP",
			"HTTP_X_FORWARDED_FOR",
			"HTTP_X_FORWARDED",
			"HTTP_X_CLUSTER_CLIENT_IP",
			"HTTP_FORWARDED_FOR",
			"HTTP_FORWARDED",
			"REMOTE_ADDR"
		);
		$ip = array();

		foreach ($source as $src) {
			$val = @$_SERVER[$src];
			if (filter_var($val, FILTER_VALIDATE_IP) ||
				filter_var($val, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
					$ip[] = $val;
				} else {
					$ip[] = "";
				}
		}

		return implode(";", $ip);
	}

$link = mysql_connect($DBHost, $DBUser, $DBPass)
		or die("DataBase connect failed: " . mysql_error());
	mysql_select_db($DBName, $link)
		or die("DataBase select failed: " . mysql_error()); 

?>
