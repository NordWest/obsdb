<?php
require 'head.php';
require 'common.php';

 
/* Соединяемся с базой данных */
$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "fitsreader"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "fitsreader"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "ccdobsDB_nap"; // название базы данных
 
/* Таблица MySQL, в которой хранятся данные */
$table = "fitsheader";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
mysql_set_charset('utf8');
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());
 
/* Составляем запрос для извлечения данных из полей "name", "email", "theme",
"message", "data" таблицы "test_table" */
$query = "SELECT DISTINCT obsDate FROM $table order by obsDate desc";
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());
 
/* Выводим данные из таблицы */



echo ("
 
<h3>Последние наблюдения: </h3>
 
<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
 <tr style=\"border: solid 1px #000\">
  <td align=\"center\"><b>Дата наблюдения</b></td>
  <td align=\"center\"><b>Наблюдетель </b></td>
 </tr>
");
 
 
 $dayNum=0;
 $dayLast=5;
 $row = mysql_fetch_array($res);
 $date1 = $row['obsDate'];
 $pos = mysql_num_rows($res) - 1;
 mysql_data_seek($res, $pos);
 $row = mysql_fetch_array($res);
 $date0 = $row['obsDate'];
 mysql_data_seek($res, 0);
 
/* Цикл вывода данных из базы конкретных полей */
 //$rPos=0;
while ($row = mysql_fetch_array($res)) {

    $dayNum++;
    if ($dayNum > $dayLast) {
        break;
    }
    $obsDate = $row['obsDate'];
//    echo "<tr>\n";
//    echo "<td><a href=\"ccdobs.php?obsDate='".$row['obsDate']."'\">".$row['obsDate']."</td>\n";

    $query = "SELECT DISTINCT observer FROM $table WHERE obsDate='$obsDate'";
    //echo $query;

    $res1 = mysql_query($query) or die(mysql_error());
    //echo "<td>";
    $row1 = mysql_fetch_array($res1);
    $observer = $row1['observer'];
    //echo "<td>".$observer;
    $realName = getRealName($lnk, $observer);
    //echo "<td>".$realName;
    
    echo "<tr>";
    echo "<td><a href=\"daily.php?obsDate='".$obsDate."'\">".$obsDate."</td>\n";
    echo "<td>";
    echo ("<a href=\"observer.php?observerName='".$realName."'&date0='".$date0."'&date1='".$date1."'\">".$realName."</a>\n");
    echo "</td>";
    echo "</tr>";
}
echo ("</table>\n");

 
//echo ("</table>\n");
$target = '';

echo ("
 
<h3>Запрос наблюдений: </h3>
  Начало<input id=\"date0\" name=\"date0\" value=\"".$date0."\" type=\"text\"/><br>
  Конец<input id=\"date1\" name=\"date1\" value=\"".$date1."\" type=\"text\"/><br>
  Объект<input id=\"target\" name=\"target\" value=\"".$target."\" type=\"text\"/><br>
  <input type=\"submit\" text=\"Запрос\" value=\"Выбрать\"/>
</form>
 

");
/*
$target = '';

echo ("
 
<h3>Запрос наблюдений объекта: </h3>
<form action=\"ccdobs.php\">
  Начало<input id=\"date0\" name=\"date0\" value=\"".$date0."\" type=\"text\"/><br>
  Конец <input id=\"date1\" name=\"date1\" value=\"".$date1."\" type=\"text\"/><br>
  Объект<input id=\"target\" name=\"target\" value=\"".$target."\" type=\"text\"/><br>
  <input type=\"submit\" text=\"Запрос\"/>
</form>
 

");
*/

 
/* Закрываем соединение */
mysql_close();
 

?>



