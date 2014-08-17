<?php
require 'common.php';
require 'head.php';
 
/* Соединяемся с базой данных */
/*$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "fitsreader"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "fitsreader"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "ccdobs_nap"; // название базы данных*/
$date0 = $_GET['date0'];
$date1 = $_GET['date1'];
$target = str_replace("'", "", $_GET['target']);
$expmin = $_GET['expmin'];
$expmax = $_GET['expmax'];

echo("<h3>Период: $date0 - $date1<h3>");
if($target!='') echo("<h3>Объект: $target<h3>");

 
/* Таблица MySQL, в которой хранятся данные */
$table = "fitsheader";
$tableObs = "observers";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());

mysql_query('set names utf8');
 
/* Составляем запрос для извлечения данных из полей "name", "email", "theme",
"message", "data" таблицы "test_table" */
//$target1 = str_replace("'", "", $target);
//echo "$target<br>";
$whrStr = getWhere($obsDate, $date0, $date1, $target, $expmin, $expmax);
$query = "SELECT DISTINCT obsDate FROM $table WHERE $whrStr order by obsDate desc";
//echo $query;
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());

echo "<a href=\"get_local_list.php?obsDate=$date0&obsDate1=$date1&target=".urlencode($target)."\">get__local_list</a>";
 
/* Выводим данные из таблицы */
echo ("
<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
 <tr class=\"head\" style=\"border: solid 1px #000\">
  <td align=\"center\"><b>Дата наблюдения</b></td>
  <td align=\"center\"><b>Наблюдатель </b></td>
 </tr>
");
 
/* Цикл вывода данных из базы конкретных полей */
while ($row = mysql_fetch_array($res)) {
    echo "<tr class=\"body\">\n";
    $lnStr = getLink($row['obsDate'], $target, $expmin, $expmax);
    echo "<td><a href=\"daily.php?$lnStr\">".$row['obsDate']."</td>\n";
    //echo "<td><a href=\"daily.php?obsDate=".$row['obsDate']."&target='".urlencode($target)."'\">".$row['obsDate']."</td>\n";
    $obsDate = $row['obsDate'];
    $query = "SELECT DISTINCT observer FROM $table WHERE obsDate='$obsDate'";
  //  echo $query;

    $res1 = mysql_query($query) or die(mysql_error());
    echo "<td>";
    while ($row1 = mysql_fetch_array($res1)) {
    	$observer = $row1['observer'];
    	$realNames = getRealNames($lnk, $observer);
        $realName = implode(", ", $realNames);
    	/*$query = "SELECT observer, realName FROM $tableObs WHERE observer='$observer'";
    	$res2 = mysql_query($query) or die(mysql_error());
    	if($row2 = mysql_fetch_array($res2)) $realName = $row2['realName'];
    	else $realName = $observer;*/
    	$uncStr = urlencode($realName);
    		echo ("<a href=\"observer.php?observerName='".$uncStr."'&date0='".$date0."'&date1='".$date1."'&target='".urlencode($target)."'\">".$realName."</a>\n");
    		//echo urlencode($realName);
    		
    	}
        
    echo "</td>\n";
    echo "</tr>\n";
}
 
echo ("</table>\n");
 
/* Закрываем соединение */
mysql_close();
 require 'tail.php';

?>






</BODY>
</HTML>
