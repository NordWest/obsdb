<?php
require 'common.php';
//require 'head.php';

$obsDate=$_GET['obsDate'];
$target = addslashes($_GET['target']);

$table = "fitsheader";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());

$seas = getSeasonsFTP($lnk);

/*
 
/* Составляем запрос для извлечения данных из полей "name", "email", "theme",
"message", "data" таблицы "test_table" /
//$query = "SELECT obsDate, DATETIMEOBS, Target, ra, de, observer FROM $table WHERE obsDate=$obsDate order by DATETIMEOBS";
//$query = "SELECT * FROM $table WHERE obsDate=$obsDate  and target LIKE '%$target%' order by DATETIMEOBS";
$query = "SELECT * FROM $table WHERE obsDate=$obsDate and target LIKE '%$target%' order by DATETIMEOBS";
//$query = "SELECT DISTINCT obsDate FROM $table WHERE obsDate > '$date0' and obsDate < '$date1' and target LIKE '%$target%' order by obsDate desc";
 //echo($query);
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. /
$res = mysql_query($query) or die(mysql_error());
$mfilename = "./$obsDate.txt";
$mfilename = str_replace("'", '', $mfilename);
$myfile = fopen($mfilename, "a+");

//$myfile = tmpfile($mfilename);

//$num_rows = mysql_num_rows($res);

//echo("<br>num_rows: $num_rows<br>");

while ($row = mysql_fetch_array($res)) {
    
    fwrite($myfile, $row['originName']);
    fwrite($myfile, "\n");
}

//echo '<br />строк '.fseek($myfile, 0);
//fclose($myfile);
if (file_exists($mfilename)) {
if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($mfilename));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($mfilename));
    // читаем файл и отправляем его пользователю
    readfile($mfilename);
}

fclose($myfile);
unlink($mfilename);*/