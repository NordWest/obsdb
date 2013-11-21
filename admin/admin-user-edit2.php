<?php
require "admin-head.php";
require "admin-func-userlist.php";
?>

<div class="c4">
EDIT USER INFORMATION
</div>

<table align='center' cellpadding=5><tr><td bgcolor='#ffffcc'>
<?php $el = user_edit(); ?>
</td></tr></table>

<?php
require "admin-tail.php";
?>
