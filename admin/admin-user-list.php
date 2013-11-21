<?php
require "admin-head.php";
require "admin-func-userlist.php";
?>

<div class="c4">
—œ»—Œ  œŒÀ‹«Œ¬¿“≈À≈…
</div>

<table border=1 cellspacing=0 cellpadding=5 align='center'>
<tr>
<td bgcolor='#ffccff' align='center'>Login</td>
<td bgcolor='#ffccff' align='center'>Full name</td>
<td bgcolor='#ffccff' align='center'>Rights</td>
<td bgcolor='#ffccff' align='center'>E-mail</td>
<td bgcolor='#ffccff' align='center'>Last login time</td>
<td bgcolor='#ffccff' align='center'>Last password change</td>
</tr>

<?
$a = get_user_list();

foreach ($a as $i => $row)
   {
   $gs = '';
   $gs .= ($row['grant_gao_admin']) ? 'A' : '-';
   $gs .= ($row['grant_gao_solar']) ? 'S' : '-';
   $gs .= ($row['grant_gao_ds'])    ? 'D' : '-';
   $gs .= ($row['grant_gao_plates'])? 'P' : '-';

   $cpw_href = "admin-change-other-passwd.php?whom=".$row['login'].
               "&show=".
               htmlentities($row['login'].' ('.$row['full_name'].')');

   echo "<tr>\n";
   echo "<td align='center'><nobr>
         <a href='admin-user-edit.php?id=".$row['id']."'>".$row['login']."</a>
         </nobr></td>\n";
   echo "<td align='center'><nobr>".$row['full_name']."</nobr></td>\n";
   echo "<td align='center'><nobr>".$gs."</nobr></td>\n";
   echo "<td align='center'><nobr>".$row['email']."</nobr></td>\n";
   echo "<td align='center'><nobr>".$row['login_date']."</nobr></td>\n";
   echo "<td align='center'><nobr>
         <a href='$cpw_href'>".$row['passwd_date']."</a>
         </nobr></td>\n";
   echo "</tr>\n";
   }
?>
</table>

<hr>
<p>
   Access rights:<br>
   A = Administrator<br>
   S = Solar system observations<br>
   D = Double star observations<br>
   P = Plate database<br>
</p>

<p>
   For administrators only:<br>
   Click user's login name to edit this user's profile.<br>
   Click user's password change date to change password of this user.<br>
</p>

<?php
require "admin-tail.php";
?>
