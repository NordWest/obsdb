<?php
require 'common.php';
require 'freeOld.php';
require 'head.php';

$obsDate=$_GET['obsDate'];
$target = addslashes($_GET['target']);

$table = "fitsheader";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());
$seas = getSeasonsLocal($lnk);

$servName = $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'];
 
/* Составляем запрос для извлечения данных*/
$query = "SELECT * FROM $table WHERE obsDate=$obsDate and target LIKE '%$target%' order by DATETIMEOBS";
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());
$myfilename = tempnam("/mnt/ccdobs/ccdobsDB/tmp/", str_replace("'", '', $obsDate)."_").".zip";

$zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
$zip->open($myfilename, ZIPARCHIVE::CREATE); //Открываем (создаём) архив archive.zip
while ($row = mysql_fetch_array($res)) {
    $fileName = $seas[$row['season']].$row['relFileName'];
    $zip->addFile($fileName);
}
$zip->close(); //Завершаем работу с архивом
$myfilename = str_replace("/mnt/ccdobs", "ftp://".$servName, $myfilename);
echo("<a href=\"$myfilename\">Скачать архив</a>");
//file_force_download($myfilename);

/*$myfile = fopen($myfilename, "a+");

while ($row = mysql_fetch_array($res)) {
    $fileName = $seas[$row['season']].$row['relFileName'];
    fwrite($myfile, $fileName);
    fwrite($myfile, "\n");
}

fseek($myfile, 0);*/
//file_force_download($myfilename);

fclose($myfile);
//unlink($myfilename);