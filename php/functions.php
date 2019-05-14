<?php

require_once "consts.php";

/*
* GetTime()
* Returns current time
*/
function GetTime()
{
	date_default_timezone_set('Asia/Jerusalem');
	return date(DATE_FORMAT, time());
}

/*
* GetTimeInterval
* Check interval in seconds between current time and given time
*/
function GetTimeInterval($time)
{
	$update_time= DateTime::createFromFormat(DATE_FORMAT, $time);
	$update_time_ts = $update_time->getTimestamp();
  	$now = strtotime("now");    	
    return ($now - $update_time_ts);
}

/*
* GenerateRandomString
* Create salt
*/
function GenerateRandomString($length = 10) 
{
	Debug(" Start GenerateRandomString");
    return substr(str_shuffle(str_repeat($x=SHUFFLE_KEY, ceil($length/strlen($x)) )),1,$length);
}

/*
* Debug
* Create log file with given content
*/
function Debug($content)
{
	if (PRINT_TO_LOG)
	{
		$file = "../" . LOG_FILE;
		$content = GetTime() . " " . $content . "\r\n";
		file_put_contents($file, $content,FILE_APPEND);
	}
}
?>