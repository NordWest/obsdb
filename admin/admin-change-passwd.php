<?php
require "admin-head.php";
?>

<div class="c4">
PASSWORD CHANGE
</div>

<hr>
<table cellspacing="10" cellpadding="10" border="0" align="center">
  <tr>
  <td align="left" class="c1">
     <form action='admin-change-passwd2.php' method='post'>
     <pre>
            Old password: <input type='password' size='20' name='passwd'>   

            New password: <input type='password' size='20' name='newpw1'>   
     Retype new password: <input type='password' size='20' name='newpw2'>   
                          <input type='submit' value=' CHANGE '>
     </pre>
     </form >
  </td>
  </tr>
</table>

<?php
require "admin-tail.php";
?>
