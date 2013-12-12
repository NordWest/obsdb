<?php
require 'common.php';
require 'head.php';

$observerName= urldecode($_GET['observerName']);
//$observerName=addslashes($_GET['observerName']);
$date0=$_GET['date0'];
$date1=$_GET['date1'];

$daysNum = 0;
$obsNum = 0;
$obsNum1=0;
$durTot=0;
$longDaysNum=0;
$expTot=0;


 
/* Таблица MySQL, в которой хранятся данные */
$table = "fitsheader";
$tableObs = "observers";
 
/* Создаем соединение */
$lnk = mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 
/* Выбираем базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($dbName) or die (mysql_error());

//mysql_query('set names utf8');
mysql_set_charset('utf8');

$query1 = "SELECT * FROM $tableObs WHERE realName=$observerName";

//echo($query1);
$res = mysql_query($query1) or die(mysql_error());
$rNum = mysql_num_rows($res);
//echo("<br>$rNum<br>");



//$query = "SELECT DISTINCT obsDate, observer FROM $table WHERE ";
//echo($query);

while ($row = mysql_fetch_array($res)) {
    
    $observer = $row['observer'];
        $names[] = "observer='".$observer."'";
    
//	obsList[] = $row['observer'];	
	
	}
        $wrarr = implode(" OR ", $names);
        $wrarr1[] = "($wrarr)";
        $wrarr1[] = "obsDate<$date1";
        $wrarr1[] = "obsDate>$date0";
        $wrstr = implode(" AND ", $wrarr1);
$query = "SELECT DISTINCT obsDate, observer FROM $table WHERE $wrstr order by obsDate"; 	
//$query = "SELECT DISTINCT obsDate, observer FROM fitsheader WHERE `observer`='Berezhnoy' and obsDate<'2012-05-09' and obsDate<'2012-05-09'";
//echo($query);

$res = mysql_query($query) or die(mysql_error());

echo("<h3>Наблюдения $observerName за период $date0 - $date1</h3>");

echo("

<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
 <tr style=\"border: solid 1px #000\">
  <td align=\"center\"><b>Дата наблюдения</b></td>
  <td align=\"center\"><b>Кол-во кадров</b></td>
  <td align=\"center\"><b>Длительность</b></td>
  
 </tr>
");
 
/* Цикл вывода данных из базы конкретных полей */
while ($row = mysql_fetch_array($res)) {

$obsDate1 = $row['obsDate'];
$observer = "'".$row['observer']."'";
	$query1 = "SELECT obsDate, DATETIMEOBS, observer, mjdEpoch, exptime FROM $table WHERE ($wrarr) and obsDate='$obsDate1' order by DATETIMEOBS";
//echo $query1."<br>";
	$res1 = mysql_query($query1) or die(mysql_error());
	$obsNum1=0;
	$dur1=0;
	while ($row1 = mysql_fetch_array($res1)) {
            if ($obsNum1 == 0) {
            $time0 = $row1['mjdEpoch'] - ($row1['exptime'] / 60.0 / 60.0 / 24.0 / 2.0);
            $time1 = $time0 + ($row1['exptime'] / 60.0 / 60.0 / 24.0 / 2.0);
        } else {
            $time1 = $row1['mjdEpoch'] + ($row1['exptime'] / 60.0 / 60.0 / 24.0 / 2.0);
        }
        $obsNum1 += 1;
			$expTot += ($row1['exptime'])/60.0/60.0;
		}
		
		$daysNum++;
	$obsNum += $obsNum1;
	$dur1 = ((float)$time1 - (float)$time0)*24.0;
	if ($dur1 > 8) {
        $longDaysNum++;
    }

    $durTot += $dur1;
    echo "<tr>\n";
    echo "<td><a href=\"daily.php?obsDate='".$row['obsDate']."'\">".$row['obsDate']."</td>\n";
    echo "<td>".$obsNum1."</td>\n";
echo "<td>".$dur1."</td>\n";
    echo "</tr>\n";
}

echo "<tr style=\"border: solid 1px #000 \" bgcolor=\"#7de890\">";
echo "<td colspan=3>Итого:<br></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=2>Наблюдательных ночей</td><td>".$daysNum."</td></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=2>Из них длительных (>8 часов)</td><td>".$longDaysNum."</td></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=2>Общая длительность наблюдений (часов)</td><td>".$durTot."</td></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=2>Получено кадров</td><td>".$obsNum."</td></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=2>Общая длительность экспозиций (часов)</td><td>".$expTot."</td></tr>";
echo "<tr style=\"border: solid 1px #000 \">";
echo "<td colspan=2>Общая длительность экспозиций/наблюдений</td><td>".($expTot/$durTot)."</td></tr>";

/*
echo "<tr style=\"border: solid 1px #000 \" bgcolor=\"#7de890\">";
echo "<td>".$daysNum."</td>\n";
echo "<td>".$obsNum."</td>\n";
echo "<td>".$durTot."</td>\n";
echo "</tr>\n";
 */
echo ("</table>\n");
 
/* Закрываем соединение */
mysql_close();
 
/* Выводим ссылку возврата */
require 'tail.php';
//echo ("<div style=\"text-align: center; margin-top: 10px;\"><a href=\"index.php\">На главную</a></div>");
 

?>