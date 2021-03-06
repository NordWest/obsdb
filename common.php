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

function file_force_download($file) {
  if (file_exists($file)) {
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
    exit;
  }
  else
  {
      echo 'file not exist';
  }
}

function getObserverList($lnk, $realName)
{
    $tableObs = 'observers';
    //mysql_select_db($tableObs, $lnk) or die ('Can\'t use foo : ' . mysql_error());
    mysql_set_charset('utf8', $lnk);
    $query1 = "SELECT * FROM $tableObs WHERE realName=$realName";
    
    $res = mysql_query($query1, $lnk) or die(mysql_error());
    
    while ($row = mysql_fetch_array($res)) {
    
    $names[] = $row['observer'];
        	
	}
    return $names;
}

function getRealName($lnk, $obsName)
{
    $tableObs = 'observers';
    //mysql_select_db($tableObs, $lnk) or die ('Can\'t use foo : ' . mysql_error());
    mysql_set_charset('utf8', $lnk);
    $query = "SELECT realName FROM observers WHERE observer='$obsName'";
    
    //echo "<td> $query";
    $res = mysql_query($query, $lnk) or die(mysql_error());
    
    while ($row = mysql_fetch_array($res)) {
    
    return $row['realName'];
        	
	}
//    return $names;
}

function getRealNames($lnk, $obsName)
{
    $tableObs = 'observers';
    //mysql_select_db($tableObs, $lnk) or die ('Can\'t use foo : ' . mysql_error());
    mysql_set_charset('utf8', $lnk);
    
    $arrNames = explode(",", $obsName);
    
    foreach ($arrNames as &$value) {
        $value = trim($value);
        $realNames[] = getRealName($lnk, $value);
    }
    
    return $realNames;
}

function getSeasonsFTP($lnk)
{
    $tableObs = 'seasons';
    $query = "SELECT name, ftpPath FROM $tableObs";
    
    $res = mysql_query($query, $lnk) or die(mysql_error());
    
    while ($row = mysql_fetch_array($res)) {
        $seasonFTP[$row['name']] = $row['ftpPath'];
    }
    return $seasonFTP;
}

function getSeasonsLocal($lnk)
{
    $tableObs = 'seasons';
    $query = "SELECT name, localPath FROM $tableObs";
    
    $res = mysql_query($query, $lnk) or die(mysql_error());
    
    while ($row = mysql_fetch_array($res)) {
        $seasonLoc[$row['name']] = $row['localPath'];
    }
    return $seasonLoc;
}

function getWhere($obsDate, $date0, $date1, $target, $expmin, $expmax)
{
    if($obsDate!='') $resArr[] = "obsDate=$obsDate";
    if($date0!='') $resArr[] = "obsDate>='$date0'";
    if($date1!='') $resArr[] = "obsDate<='$date1'";
    if($target!='') $resArr[] = "target LIKE '%$target%'";
    if($expmin!='') $resArr[] = "exptime>=$expmin";
    if($expmax!='') $resArr[] = "exptime<=$expmax";
    return implode(" and ", $resArr);
}

function getLink($obsDate, $target, $expmin, $expmax)
{
    if($obsDate!='') $resArr[] = "obsDate='$obsDate'";
    if($target!='') $resArr[] = "target='".urlencode($target)."'";
    if($expmin!='') $resArr[] = "expmin=$expmin";
    if($expmax!='') $resArr[] = "expmax=$expmax";
    return implode("&", $resArr);
}