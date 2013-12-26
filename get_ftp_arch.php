<?php
require 'common.php';
//require 'freeOld.php';
require 'head.php';

$obsDate=$_GET['obsDate'];
$target = addslashes($_GET['target']);

$table = "fitsheader";



/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());
$seas = getSeasonsLocal($lnk);

$servName = $_SERVER['SERVER_ADDR'];
 
/* Составляем запрос для извлечения данных*/
$query = "SELECT * FROM $table WHERE obsDate=$obsDate and target LIKE '%$target%' order by DATETIMEOBS";
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());
$myfilename = tempnam("/tmp/", str_replace("'", '', $obsDate)."_").".zip";
$myfilename1 = tempnam("/mnt/ccdobs/ccdobsDB/tmp/", str_replace("'", '', $obsDate)."_").".zip";
$myftpname = str_replace("/mnt/ccdobs", "ftp://".$servName, $myfilename);

set_time_limit(8000);
$zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
$zip->open($myfilename, ZIPARCHIVE::CREATE); //Открываем (создаём) архив archive.zip
while ($row = mysql_fetch_array($res)) {
    $fileName = $seas[$row['season']].$row['relFileName'];
    $zip->addFile($fileName, $row['relFileName']);
}
$zip->close(); //Завершаем работу с архивом
copy($myfilename, $myfilename1);
unlink($myfilename);
echo("<a href=\"$myftpname\">Скачать архив</a>");

//file_force_download($myfilename);

/*$myfile = fopen($myfilename, "a+");

while ($row = mysql_fetch_array($res)) {
    $fileName = $seas[$row['season']].$row['relFileName'];
    fwrite($myfile, $fileName);
    fwrite($myfile, "\n");
}

fseek($myfile, 0);*/
//file_force_download($myfilename);

//fclose($myfile);
//unlink($myfilename);