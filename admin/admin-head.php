<?php
error_reporting(E_ALL);
// error_reporting(E_ALL & ~E_WARNINGS);

session_start();
require "admin-func.php";
if (!isset($_SESSION['page_cnt'])) $_SESSION['page_cnt'] = 0;
$_SESSION['page_cnt'] ++;

?><html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
   <link rel="stylesheet" href="style.css" type="text/css" media="all">
   <title>Pulkovo Astrometrical Databases</title>
</head>

<!--//********** body ************************************************-->
<body background="/img/gray.jpg" text="#000000" bgcolor="#ffffff">

<div align="center">
<img src="/img/logo.jpg" hspace="10" vspace="10" border="1"> 
</div>
                                                                             
<div class="c4">
АСТРОМЕТРИЧЕСКИЕ БАЗЫ ДАННЫХ ПУЛКОВСКОЙ ОБСЕРВАТОРИИ
</div>

<?php
################## AUTHENTICATION ##############################
if (get('logout')) logout();
if (!auth())
   {
   require "admin-login.php";
   exit();
   }
################################################################
?>

<hr width="90%">
<div align="center">
<a href='index.php'>На главную страницу</a>
 | Page <? echo session('page_cnt') ?>
 | User: <? echo session('login') ?> (<? echo session('full_name') ?>)
 | <a href='index.php?logout=1'>Выход</a>
</div>
<hr width="90%">
