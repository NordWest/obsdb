<?
echo "<pre>";



$str = "abc ? qwert ? asdfgh ? zxcvbnm";
$param = array(10, 20, 30);
echo "$str \n";
foreach ($param as $p)
   {
   $str = preg_replace ('/\?/', " '$p' ", $str, 1);
   echo "$str \n";
   }


echo "magic quotes = ".get_magic_quotes_gpc()."<br>\n";
echo "register globals = ".ini_get('register_globals')."<br>\n";
echo "</pre><br>";

phpinfo();

?>