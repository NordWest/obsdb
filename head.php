<?php
echo("<!DOCTYPE html>
<HTML>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<style type=\"text/css\">
      @import url(\"mycss.css\");
      </style>
<HEAD>
<TITLE>Запрос информации</TITLE>
<script language=\"JavaScript\" 
	type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js\"></script>
<script language=\"javascript\" type=\"text/javascript\" src=\"http://rche.ru/examples/cal.js\"></script>
<script type=\"text/javascript\">
$(document).ready(function(){
$('#calendar').simpleDatepicker();  // Привязать вызов календаря к полю с CSS идентификатором #calendar
});
</script>
<BODY>

<a href=\"index.php\" ><img src=\"img/logo.jpg\" width=\"400\" height=\"250\" alt=\"\" /></a>
<h1>Дневник наблюдений</h1><br />
");
