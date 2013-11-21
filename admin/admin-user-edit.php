<?php
require "admin-head.php";
require "admin-func-userlist.php";
?>

<div class="c4">
EDIT USER INFORMATION
</div>

<?
$a = get_user_info();
?>

<table cellspacing="10" cellpadding="10" border="0" align="center">
  <tr>
  <td align="left" class="c1">
     <form action='admin-user-edit2.php' method='post'>
     <pre>
         Login: <? echo $a['login']; ?>  
     Full name: <input type='text' size=30 name='fio' 
                       value='<? echo $a['full_name']; ?>'
                       >
E-mail address: <input type='text' size=30 name='email' 
                       value='<? echo $a['email']; ?>'
                       >

<fieldset><legend>Access rights</legend>
Administration: <input type='checkbox' name='cb_admin' 
                       <? echo ($a['grant_gao_admin'])?'checked':''; ?> 
                       >
  Solar system: <input type='checkbox' name='cb_solar' 
                       <? echo ($a['grant_gao_solar'])?'checked':''; ?> 
                       >
  Double stars: <input type='checkbox' name='cb_ds' 
                       <? echo ($a['grant_gao_ds'])?'checked':''; ?> 
                       >
Plate database: <input type='checkbox' name='cb_plates' 
                       <? echo ($a['grant_gao_plates'])?'checked':''; ?> 
                       >
</fieldset>

 Your password: <input type='password' size=30 name='passwd'>
                <input type='hidden' name='id' value='<? echo $a['id']; ?>'>
                <input type='submit' value=' SAVE CHANGES '>
     </pre>
     </form >

<!--
<a href='admin-change-other-passwd.php?id=<? echo $a['id']; ?>&show=<? echo htmlentities($a['login'].' ('.$a['full_name'].')'); ?>'>
Change password of this user
</a>
-->  
  
  </td>
  </tr>
</table>

<?php
require "admin-tail.php";
?>
