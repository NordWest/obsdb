<?php

/********************* CONSTANTS *********************************/
$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "fitsreader"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "fitsreader"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "ccdobsDB_nap"; // название базы данных


function deg_to_hms($deg)
{
	settype($h, "integer");
	settype($m, "integer");
	settype($s, "double");
	settype($str, "string");
	$deg = $deg/15;
	$h = floor($deg);
 	$deg = ($deg-$h)*60;
 	$m = floor($deg);
 	$deg = ($deg-$m)*60;
 	$s = $deg;
 	$str = "";
 	$str = sprintf("%02d:%02d:%05.3f", $h, $m, $s);
 	return $str;
}

function deg_to_gms($deg)
{
	settype($h, "integer");
	settype($m, "integer");
	settype($s, "double");
	settype($str, "string");
	$h = floor($deg);
 	$deg = abs(($deg-$h)*60);
 	$m = floor($deg);
 	$deg = ($deg-$m)*60;
 	$s = $deg;
 	$str = "";
 	$str = sprintf("%02d:%02d:%05.3f", $h, $m, $s);
 	return $str;
}
?>