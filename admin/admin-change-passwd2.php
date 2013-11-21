<?php
require "admin-head.php";
require "admin-func-userlist.php";
?>

<div class="c4">
PASSWORD CHANGE
</div>

<table align='center' class='query_result'><tr><td>
<?php $el = change_passwd(session('login')); ?>
</td></tr></table>

<?php
require "admin-tail.php";
?>
