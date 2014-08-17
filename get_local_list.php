<?php
require 'common.php';
//require 'head.php';

$obsDate=$_GET['obsDate'];
$target = addslashes($_GET['target']);

$obsDate1=$_GET['obsDate1'];
$expmin = $_GET['expmin'];
$expmax = $_GET['expmax'];

$table = "fitsheader";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());
$seas = getSeasonsLocal($lnk);
 
/* Составляем запрос для извлечения данных*/
$whrStr = getWhere("", $obsDate, $obsDate1, $target, $expmin, $expmax);
/*$query = "SELECT * FROM $table WHERE obsDate>='$obsDate'";
if ($obsDate1 != '') {
    echo("if\n");
    $query = $query." and obsDate<='$obsDate1'";
}
if ($target != '')$query = $query." and target LIKE '%$target%'";
$query = $query." order by DATETIMEOBS";
*/
$query = "SELECT * FROM $table WHERE $whrStr order by DATETIMEOBS";
//echo($query);
//echo("\n");

/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());
$myfilename = tempnam("/tmp", str_replace("'", '', $obsDate)."_").".txt";
$myfile = fopen($myfilename, "a+");

while ($row = mysql_fetch_array($res)) {
    $fileName = $seas[$row['season']].$row['relFileName'];
    fwrite($myfile, $fileName);
    fwrite($myfile, "\n");
}

fseek($myfile, 0);
file_force_download($myfilename);

fclose($myfile);
unlink($myfilename);