<?php
require "admin-head.php";
require "admin-func-userlist.php";
?>

<div class="c4">
ADD NEW USER
</div>

<table cellspacing="10" cellpadding="10" border="0" align="center">
  <tr>
  <td align="left" class="c1">
     <form action='admin-user-add2.php' method='post'>
     <pre>
          Login: <input type='text' size=30 name='login' value=''>
      Full name: <input type='text' size=30 name='fio' value=''>
 E-mail address: <input type='text' size=30 name='email' value=''>
       Password: <input type='password' size=30 name='newpw1'>
Retype password: <input type='password' size=30 name='newpw2'>

  Your password: <input type='password' size=30 name='passwd'>
                <input type='submit' value=' ADD USER '>
     </pre>
     </form >
  </td>
  </tr>
</table>

<?php
require "admin-tail.php";
?>
