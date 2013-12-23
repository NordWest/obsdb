<?php
require 'common.php';
require 'head.php';

 
/* Соединяемся с базой данных */
/*$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "fitsreader"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "fitsreader"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "ccdobs_nap"; // название базы данных
 */
$obsDate=$_GET['obsDate'];
//$target = $_GET['target'];
$target = str_replace("'", "", $_GET['target']);
 
/* Таблица MySQL, в которой хранятся данные */
$table = "fitsheader";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());
 
/* Составляем запрос для извлечения данных из полей "name", "email", "theme",
"message", "data" таблицы "test_table" */
//$query = "SELECT obsDate, DATETIMEOBS, Target, ra, de, observer FROM $table WHERE obsDate=$obsDate order by DATETIMEOBS";
$query = "SELECT * FROM $table WHERE obsDate=$obsDate  and target LIKE '%$target%' order by DATETIMEOBS";

/* echo($query);*/
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());
 
/* Выводим данные из таблицы */
echo ("
<h3>Наблюдения за $obsDate</h3>");

echo "<a href=\"get_local_list.php?obsDate=$obsDate&target=$target\">get__local_list</a>";

echo(" 
 
<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
 <tr style=\"border: solid 1px #000\">
  <td align=\"center\"><b>№ п/п</b></td>
  <td align=\"center\"><b>Дата наблюдения</b></td>
  <td align=\"center\"><b>Объект </b></td>
  <td align=\"center\"><b>RA </b></td>
  <td align=\"center\"><b>DEC </b></td>
  <td align=\"center\"><b>Экспозиция</b></td>
  <td align=\"center\"><b>Наблюдатель </b></td>
 </tr>
");
 
/* Цикл вывода данных из базы конкретных полей */
$obsNum = 0;
$tbeg = 0;
$tend = 0;
$i=0;
$serieNum=1;

while ($row = mysql_fetch_array($res)) {

	if($obsNum==0)
    {
    	$time1 = $row['mjdEpoch'];
    	$expTime = $row['exptime']/60.0/60.0/24.0;
    	$dt1 = $expTime/2.0;
    	$obsNum++;
    	
    	$tbeg = $time1 - $expTime/2.0;
    }
    else
    {
    	$expTime = $row['exptime']/60.0/60.0/24.0;
    	$time0 = $time1;
    	$dt0 = $dt1;
    	$time1 = $row['mjdEpoch'];
    	$dt1 = $time1 - $time0;
    	
    	$tend = $time1 + $expTime/2.0;
    	
    	if($dt1>=(2.1*$expTime))
    	{
    		echo "<tr style=\"border: solid 1px #000 \" bgcolor=\"#7de890\"><td colspan=\"7\"></td></tr>\n";
    		$serieNum++;
    		}
    }
    
    $realNames = getRealNames($lnk, $row['observer']);
    $realName = implode(", ", $realNames);
    	
	
    echo "<tr>\n";
    echo "<td>".(++$i)."</td>\n";
    echo "<td>".$row['DATETIMEOBS']."</td>\n";
    echo "<td>".$row['Target']."</td>\n";
    echo "<td>".deg_to_hms($row['ra'])."</td>\n";
    echo "<td>".deg_to_gms($row['de'])."</td>\n";
    echo "<td>".$row['exptime']."</td>\n";
    echo "<td>".$realName."</td>\n";
    echo "</tr>";
    
    $originList[] = $row['originName'];
    
}



echo "<tr style=\"border: solid 1px #000 \" bgcolor=\"#7de890\">";
echo "<td colspan=7>Итого:<br></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=6>Общая длительность наблюдений (часов)</td><td>".sprintf('%5.2f',(($tend-$tbeg)*24.0))."</td></tr>";

$objNum = 0;
$query = "SELECT DISTINCT Target FROM $table WHERE obsDate=$obsDate";
$res = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_array($res)) {
	$objNum++;
		
	
}

echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=6>Кол-во серий</td><td>".$serieNum."</td></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=6>Кол-во объектов</td><td>".$objNum."</td></tr>";

echo ("</table>\n");
 
/* Закрываем соединение */
mysql_close();



 
/* Выводим ссылку возврата */
//echo ("<div style=\"text-align: center; margin-top: 10px;\"><a href=\"index.php\">На главную</a></div>");
 require 'tail.php';
?>
