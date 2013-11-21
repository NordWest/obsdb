<?php

define ('DEBUG', '1');

#########################################################

// function redirect($s)
//   {
//   header("Location: http://dbase.puldb.ru/admin/$s");   
//   }

#########################################################

function server($s)
   {
   if (!isset($_SERVER[$s])) return '';
   return mysql_escape_string($_SERVER[$s]);
   }

#########################################################

function session($s)
   {
   if (!isset($_SESSION[$s])) return '';
   return $_SESSION[$s];
   }

#########################################################

function post($s)
   {
   if (!isset($_POST[$s])) return '';
   return (get_magic_quotes_gpc()) ? $_POST[$s] 
                                   : mysql_escape_string($_POST[$s]);
   }

#########################################################

function get($s)
   {
   if (!isset($_GET[$s])) return '';
   return (get_magic_quotes_gpc()) ? $_GET[$s] 
                                   : mysql_escape_string($_GET[$s]);
   }

#########################################################

function connect()
   {
   $link = mysql_connect('localhost', 'puldbru_dbase', 'pul123');
   mysql_select_db('puldbru_dbase');
   return $link;
   }

#########################################################

function sql($query, $param)
   {
   global $sql_error, $sql_aff_rows;
   if (DEBUG) echo "\n<!--\nRaw query: $query \n";
   
   $parts = explode('?', $query);
   if (count($parts) < count($param))   die("error in sql query \n");
   if (count($parts) > count($param)+1) die("error in sql query \n");

   $query = '';
   for ($i=0; $i<count($parts); $i++)
      {
      // $p = (get_magic_quotes_gpc()) ? $p : mysql_escape_string($p);
      if (isset($parts[$i])) $query .=    $parts[$i]   ;
      if (isset($param[$i])) $query .= " '$param[$i]' ";
      }
   if (DEBUG) echo "Prepared query: $query \n";
   
   $link = connect();
   $res = mysql_query($query);
   $sql_aff_rows = mysql_affected_rows();
   $sql_error = mysql_error();
   mysql_close();
   if (DEBUG) echo "Affected rows = $sql_aff_rows \n";
   if (DEBUG) echo "SQL error = $sql_error \n-->\n ";
   return $res;
   }

#########################################################

function sql1($query, $param)
   {
   return mysql_result(sql($query, $param), 0, 0);
   }

#########################################################

function check_passwd($login, $passwd)
   {
   $md5 = md5($passwd);
   $res = sql("select * from gao_user_list 
               where login = ? and passwd_md5 = ?",
               array($login, $md5));
   $n = mysql_num_rows($res);
   return (int)$n;
   }

#########################################################

function auth()
   {
   if (session('auth_ok') === 1) return 1;
   sleep(1);
   if (check_passwd(post('login'), post('passwd')) !== 1) return 0;
   $_SESSION['auth_ok'] = 1;

   // RETRIEVING USER DATA
   $res = sql('select id, login, full_name
               from gao_user_list where login = ?', 
               array(post('login'))
             );
   if (mysql_num_rows($res) !== 1) return 0;
   $row = mysql_fetch_assoc($res);
   foreach ($row as $k => $v) $_SESSION[$k] = $v;

   // UPDATING LOGS
   sql('insert into gao_login_history
        (user_login, remote_addr, remote_host, http_user_agent)
        values (?,?,?,?)',
        array(session('login'), 
              server('REMOTE_ADDR'), 
              server('REMOTE_HOST'), 
              server('HTTP_USER_AGENT')
             )
      );
   sql('update gao_user_list set login_date = now() where login = ?', 
               array(session('login'))
      );
   
   return 1;
   }

#################################################################
function logout()
   {
   $_SESSION['auth_ok'] = 0;
   unset ($_SESSION['auth_ok']);
   $_SESSION = array();
   session_destroy();
   }
#################################################################

?>