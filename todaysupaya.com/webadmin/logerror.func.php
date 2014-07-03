<?php

function createFile($filepath, $header)
{	if( !file_exists($filepath))
	{	touch($filepath);
		if( $fp = fopen($filepath, "w"))	// change to append once sure it works right, justy to be safe
		{	fwrite($fp, $header);
			fclose($fp);
		}
	}
}

function logError( $errType, $error, $file, $errLine)
{	$tab = "\t";
	$today = date("Y_m_d");
	//$timeNow = date("H:i:s");
	
	$line = $today.$tab;	// date
	$header = "DATE".$tab;
	$line .= date("H:i:s").$tab;	// time
	$header .= "TIME".$tab;
	
	$line .= $errType.$tab;	// error type
	$header .= "ERROR TYPE".$tab;
	$line .= $error.$tab;	// error info
	$header .= "ERROR INFO".$tab;
	
	$line .= $file.$tab;	// file
	$header .= "FILE".$tab;
	$line .= $errLine.$tab;	// line
	$header .= "LINE".$tab;
	
	if(getenv('HTTP_CLIENT_IT'))
		$line .= $_SERVER['HTTP_CLIENT_IP'];	// client IP
	$line .= $tab;
	$header .= "IP - CLIENT".$tab;
	if( getenv('REMOTE_ADDR'))
		$line .= $_SERVER['REMOTE_ADDR'];	// connecting party IP
	$line .= $tab;
	$header .= "IP - CONNECTING".$tab;
	if( getenv('HTTP_X_FORWARDED_FOR'))
		$line .= $_SERVER['HTTP_X_FORWARDED_FOR'];	// forwarded IP
	$line .= $tab;
	$header .= "IP - FORWARDED".$tab;
	
	$line .= "\n";
	$header .= "\n";
	
	$filePath = $_SERVER['DOCUMENT_ROOT'].'/errorLog/'.$today.'.csv';
	createFile($filePath, $header);
	if( $fp = fopen( $filePath, 'a'))
	{	fwrite($fp, $line);
		fclose($fp);
	}
}
?>