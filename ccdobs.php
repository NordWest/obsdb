<?php
require 'head.php';
require 'common.php';
?>

<?php
 
/* Соединяемся с базой данных */

$date0 = $_GET['date0'];
$date1 = $_GET['date1'];
$target = $_GET['target'];

 
/* Таблица MySQL, в которой хранятся данные */
$table = "fitsheader";
$tableObs = "observers";

/* Создаем соединение */
mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());

mysql_query('set names utf8');
 
/* Составляем запрос для извлечения данных из полей "name", "email", "theme",
"message", "data" таблицы "test_table" */
$query = "SELECT DISTINCT obsDate FROM $table WHERE obsDate > '$date0' and obsDate < '$date1' and target LIKE '%$target%' order by obsDate desc";
//echo $query;
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());

$rNum = mysql_num_rows($res);


echo '<h3>Найдено $rNum записей</h3>';



/* Выводим данные из таблицы */

echo ("
 

 
<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
 <tr style=\"border: solid 1px #000\">
  <td align=\"center\"><b>Дата наблюдения</b></td>
  <td align=\"center\"><b>Наблюдетель </b></td>
  <td align=\"center\"><b>Серий </b></td>
  <td align=\"center\"><b>Кадров </b></td>
 </tr>
");
 
/* Цикл вывода данных из базы конкретных полей */
while ($row = mysql_fetch_array($res)) {
    
    $query = "SELECT observer, realName FROM $tableObs WHERE observer='$observer'";
    
    echo "<tr>\n";
    echo "<td>".$row['DATETIMEOBS']."</td>\n";
    echo "<td>".$row['observer']."</td>\n";
    echo "<td>".deg_to_hms($row['ra'])."</td>\n";
    echo "<td>".deg_to_gms($row['de'])."</td>\n";
    echo "<td>".$row['observer']."</td>\n";
    echo "<td>".$row['originName']."</td>\n";
    
}
 
echo ("</table>\n");



/*
 $myfile = tmpfile();
//echo $myfile;

while ($row = mysql_fetch_array($res)) {
    $tline = '<br />'.$row['originName']."\n";
    //echo $tline;
    fwrite($myfile, $tline);
}
//fclose($myfile);
fseek($myfile, 0);
//echo '<br />строк '.fseek($myfile, 0);
//if (file_exists($myfile)) echo '<br />file exist ';
file_force_download($myfile);
//readfile($myfile);
*/
/* Закрываем соединение */
mysql_close();
 

?>






</BODY>
</HTML>
