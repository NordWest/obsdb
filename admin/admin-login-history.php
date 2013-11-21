<?php
require "admin-head.php";
require "admin-func-userlist.php";
?>

<div class="c4">
LOGIN HISTORY
</div>

<table border=1 cellspacing=0 cellpadding=5 align='center'>
<tr>
<td bgcolor='#ffccff' align='center'>Login name</td>
<td bgcolor='#ffccff' align='center'>Login time</td>
<td bgcolor='#ffccff' align='center'>IP address</td>
<td bgcolor='#ffccff' align='center'>Host</td>
<td bgcolor='#ffccff' align='center'>User agent</td>
</tr>

<?
$a = get_login_history();

foreach ($a as $i => $row)
   {
   echo "<tr>\n";
   echo "<td align='center'><nobr>".$row['user_login']."</nobr></td>\n";
   echo "<td align='center'><nobr>".$row['login_time']."</nobr></td>\n";
   echo "<td align='center'><nobr>".$row['remote_addr']."</nobr></td>\n";
   echo "<td align='center'><nobr>".$row['remote_host']."</nobr></td>\n";
   echo "<td align='center'><nobr>".$row['http_user_agent']."</nobr></td>\n";
   echo "</tr>\n";
   }
?>

</table>

<?php
require "admin-tail.php";
?>
