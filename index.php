<?php
include './head.php';
?>

<?php
 
/* Соединяемся с базой данных */
$hostname = "localhost"; // название/путь сервера, с MySQL
$username = "fitsreader"; // имя пользователя (в Denwer`е по умолчанию "root")
$password = "fitsreader"; // пароль пользователя (в Denwer`е по умолчанию пароль отсутствует, этот параметр можно оставить пустым)
$dbName = "ccdobsDB_nap"; // название базы данных
 
/* Таблица MySQL, в которой хранятся данные */
$table = "fitsheader";
 
/* Создаем соединение */
mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());
 
/* Составляем запрос для извлечения данных из полей "name", "email", "theme",
"message", "data" таблицы "test_table" */
$query = "SELECT DISTINCT obsDate FROM $table order by obsDate desc";
 
/* Выполняем запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());
 
/* Выводим данные из таблицы */


/*
echo ("
 
<h3>Имеющиеся наблюдения в базе: </h3>
 
<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
 <tr style=\"border: solid 1px #000\">
  <td align=\"center\"><b>Дата наблюдения</b></td>
  <td align=\"center\"><b>Наблюдетель </b></td>
 </tr>
");
 */
 
 $dayNum=0;
/* Цикл вывода данных из базы конкретных полей */
while ($row = mysql_fetch_array($res)) {
	
	if($dayNum==0) $date1=$row['obsDate'];
	else if($row['obsDate']>0) $date0=$row['obsDate'];
	$dayNum++;
	
    //echo "<tr>\n";
    //echo "<td><a href=\"ccdobs.php?obsDate='".$row['obsDate']."'\">".$row['obsDate']."</td>\n";
    $obsDate = $row['obsDate'];
    $query = "SELECT DISTINCT observer FROM $table WHERE obsDate='$obsDate'";
  //  echo $query;

    $res1 = mysql_query($query) or die(mysql_error());
    //echo "<td>";
    while ($row1 = mysql_fetch_array($res1)) {
    	$observer = $row1['observer'];
    	/*$query = "SELECT realName FROM observers WHERE observer='$observer'";
    	//echo $query;
    	//echo "</td>\n";
    	$res2 = mysql_query($query) or die(mysql_error());
    	//echo $res2;
    	//echo "</td>\n";
 /*   	if($res2!='') 
    		{
    			$row2 = mysql_fetch_array($res2);
    			$observer = $row2['realName'];
    		}*/
    		//echo "<a href=\"observer.php?observer='".$observer."'\">".$observer."\n";
    		//echo $observer." ";
    		
    	}
    //echo "</td>\n";
}


 
//echo ("</table>\n");

echo ("
 
<h3>Запрос наблюдений: </h3>
<form action=\"dairy.php\">
  date0<input id=\"date0\" name=\"date0\" value=\"".$date0."\" type=\"text\"/><br>
  date1<input id=\"date1\" name=\"date1\" value=\"".$date1."\" type=\"text\"/><br>
  <input type=\"submit\" text=\"Запрос\"/>
</form>
 

");

echo ("
 
<h3>Запрос наблюдений объекта: </h3>
<form action=\"ccdobs.php\">
  Начало<input id=\"date0\" name=\"date0\" value=\"".$date0."\" type=\"text\"/><br>
  Конец <input id=\"date1\" name=\"date1\" value=\"".$date1."\" type=\"text\"/><br>
  Объект<input id=\"target\" name=\"target\" value=\"".$target."\" type=\"text\"/><br>
  <input type=\"submit\" text=\"Запрос\"/>
</form>
 

");


 
/* Закрываем соединение */
mysql_close();
 

?>






</BODY>
</HTML>
