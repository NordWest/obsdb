<?php
require "admin-head.php";
require "admin-func-userlist.php";
?>

<div class="c4">
ADD NEW USER
</div>

<table align='center' cellpadding=5><tr><td bgcolor='#ffffcc'>
<?php
$el = user_add();
?>
</td></tr></table>

<?php
require "admin-tail.php";
?>
