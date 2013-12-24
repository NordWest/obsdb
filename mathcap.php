<?php
if (!isset($_SESSION)) session_start(); 
if ( !isset($_POST['answ'])||(!isset($_SESSION['ans'])) )
{
	$one=rand(0,20);
	$two=rand(0,20);
	
	if (rand(0,1)>0)
	{
		$_SESSION['ans']=$one+$two;
		echo "$one+$two=";
	}
	else
	{
		$_SESSION['ans']=$one-$two;
		echo "$one-$two=";
	}
}
else
{
	if (is_numeric($_POST['answ']))
	{
		if ((intval($_POST['answ']))===(intval($_SESSION['ans']))) 
		{
			echo 'ок';
			unset($_SESSION['ans']);
		}
		else 
		{
			echo 'неверно ответ '.$_SESSION['ans'];
			unset($_SESSION['ans']);
			unset($_POST['answ']);

		}
	}
	else
	{
		echo 'неверно ответ '.$_SESSION['ans'];
	}
}
echo("
 <form method=\"POST\" action=get_ftp_list.php?obsDate=$obsDate&target=$target>
 <input type=\"text\" name=\"answ\"><br />
 <input type=\"submit\" class=\"form-submit\" value=\"Get FTP list\" />
 </form>");