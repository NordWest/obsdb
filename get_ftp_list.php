<?php
require 'common.php';
//require 'mathcap.php';
//require 'head.php';

$obsDate=$_GET['obsDate'];
$target = addslashes($_GET['target']);

$table = "fitsheader";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());

$seas = getSeasonsFTP($lnk);

/*$query = "SELECT value FROM settings WHERE name='servAddr'";
$res = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($res);*/
$servName = $_SERVER['SERVER_ADDR'];

$query = "SELECT * FROM $table WHERE obsDate=$obsDate and target LIKE '%$target%' order by DATETIMEOBS";
 
$res = mysql_query($query) or die(mysql_error());
$myfilename = tempnam("/tmp", str_replace("'", '', $obsDate)."_").".txt";
$myfile = fopen($myfilename, "a+");

while ($row = mysql_fetch_array($res)) {
    $fileName = "ftp://$servName".$seas[$row['season']].$row['relFileName'];
    fwrite($myfile, $fileName);
    fwrite($myfile, "\n");
}
fseek($myfile, 0);

file_force_download($myfilename);
fclose($myfile);
unlink($myfilename);