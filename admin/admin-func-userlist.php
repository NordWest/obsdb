<?

//========================================================================

function is_admin()
   {
   return (int)sql1('select count(*) from gao_user_list 
                     where login=? and grant_gao_admin=1', 
                     array(session('login'))) === 1 ? 1 : 0; 
   }

//========================================================================

function set_new_passwd($login, $passwd)
   {
   // PASSWD AND ACCESS RIGHTS MUST BE CHECKED PREVIOUSLY !!!

   $md5 = md5($passwd);
   sql('update gao_user_list set passwd_md5=?, passwd_date=now()
        where login=?',
        array($md5, $login)
      );
   }

//========================================================================

function el_passwd_estimate($new1, $new2)
   {
   $el = '';
   if ($new1 !== $new2)
      $el .= "<li>New password does not match retyped password\n";
   if (strlen($new1) < 8) 
      $el .= "<li>New password is too short\n";
   if (!ereg('[0-9]', $new1))
      $el .= "<li>New password must contain at least one digit (0-9)\n";
   if (!ereg('[A-Z]', $new1))
      $el .= "<li>New password must contain at least one capital letter (A-Z)\n";
   if (!ereg('[a-z]', $new1))
      $el .= "<li>New password must contain at least one small letter (a-z)\n";

   $cnt = 0; 
   $histo = count_chars($new1, 0);
   foreach ($histo as $k => $v) if ($v>0) $cnt++;
   echo "\n<!-- Number of different chars = $cnt -->\n";
   if ($cnt < 5)
      $el .= "<li>New password contains too few different characters \n";
   
   return $el;
   }

//========================================================================

function user_add()
   {
   $login= trim(post("login"));
   $new1 = trim(post("newpw1"));
   $new2 = trim(post("newpw2"));

   $el = "";
   if (!is_admin())
      $el .= "<li>You have no right to add new users\n";
   if (!check_passwd(session('login'), post('passwd'))) 
      $el .= "<li>Wrong password\n";
   if (sql1('select count(*) from gao_user_list where login=?', array($login))) 
      $el .= "<li>User with this login already exists\n";
   if (strlen($login) < 1)
      $el .= "<li>Login is too short\n";

   $el .= el_passwd_estimate($new1, $new2);

   if (strlen($el) == 0) // ok
      {
      $param   = array();
      $param[] = $login;
      $param[] = trim(post("fio"));
      $param[] = trim(post("email"));

      sql('insert into gao_user_list (login, full_name, email) 
           values (?, ?, ?)', $param);
      set_new_passwd($login, $new1);
      echo 'New user was added successfully';
      }   
   else
      {
      echo "NEW USER CANNOT BE ADDED:\n";
      echo "<ul class='errorlist'>\n$el\n</ul>\n";
      echo "<a href='javascript:history.back()'>Try again</a>\n";
      }
   return $el;
   }

//========================================================================

function user_edit()
   {
   $el = "";
   if (!check_passwd(session('login'), post('passwd'))) 
      $el .= "<li>Wrong password\n";
   if (!is_admin())
      $el .= "<li>You have no right to change this information\n";
   if (sql1('select count(*) from gao_user_list 
             where login=? and id=? 
             and grant_gao_admin=1', 
             array(session('login'), post('id'))) and !post('cb_admin')) 
      $el .= "<li>You cannot disable your own administrative rights\n";

   if (strlen($el) == 0) // ok
      {
      $param   = array();
      $param[] = trim(post("fio"));
      $param[] = trim(post("email"));
      $param[] = (trim(post('cb_admin')))  ? 1 : 0;
      $param[] = (trim(post('cb_solar')))  ? 1 : 0;
      $param[] = (trim(post('cb_ds')))     ? 1 : 0;
      $param[] = (trim(post('cb_plates'))) ? 1 : 0;
      $param[] = (int)trim(post('id'));

      sql("update gao_user_list set full_name=?, email=?,  
           grant_gao_admin=?,
           grant_gao_solar=?,
           grant_gao_ds=?,
           grant_gao_plates=? where id=? ", $param);
      echo 'Information was updated successfully';
      }   
   else
      {
      echo "USER INFO CANNOT BE CHANGED:\n";
      echo "<ul class='errorlist'>\n$el\n</ul>\n";
      echo "<a href='javascript:history.back()'>Try again</a>\n";
      }
   return $el;
   }

//========================================================================

function change_passwd($whom)
   {
   $el = "";
   $new1 = trim(post("newpw1"));
   $new2 = trim(post("newpw2"));

   if (!is_admin() and session('login') !== $whom)
      $el .= "<li>You do not have right to change passwords of other users\n";
   if (!check_passwd(session('login'), post('passwd'))) 
      $el .= "<li>Wrong old password\n";
   $el .= el_passwd_estimate($new1, $new2);

   if (strlen($el) == 0) // ok
      {
      set_new_passwd($whom, $new1);
      echo 'Password was changed successfully';
      }
   else
      {
      echo "PASSWORD CANNOT BE CHANGED:\n";
      echo "<ul class='errorlist'>\n$el\n</ul>\n";
      echo "<a href='javascript:history.back()'>Try again</a>\n";
      }
   return $el;
   }

//==========================================================================

function get_login_history()
   {
   $res = sql("select * from gao_login_history order by login_time limit 100", 
               array());
   $a = array();
   while ($row = mysql_fetch_assoc($res)) 
      {
      foreach ($row as $k => $v) $row[$k] = htmlentities($v, ENT_QUOTES);
      $a[] = $row;
      }
   return $a;
   }

//==========================================================================

function get_user_list()
   {
   $res = sql("select * from gao_user_list order by (login <> 'orion'), login", array());
   $a = array();
   while ($row = mysql_fetch_assoc($res)) 
      {
      foreach ($row as $k => $v) $row[$k] = htmlentities($v, ENT_QUOTES);
      $a[] = $row;
      }
   return $a;
   }
//==========================================================================

function get_user_info()
   {
   $res = sql("select * from gao_user_list where id = ?", array((int)get('id')));
   $row = mysql_fetch_assoc($res);
   foreach ($row as $k => $v) $row[$k] = htmlentities($v, ENT_QUOTES);
   return $row;
   }

//==========================================================================

?>