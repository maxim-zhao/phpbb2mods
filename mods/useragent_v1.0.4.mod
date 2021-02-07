################################################################# 
## MOD Title: View User Agent  
## MOD Author: Tomythius < tom@whaletattoo.com > (Tom Wright) http://www.tom.whaletattoo.com
## MOD Description: Displays the user agent of a session on the admin page
## 
## MOD Version: 1.0.4
## 
## Installation Level: Intermediate
## Installation Time: ~10 Minutes 
## Files To Edit: includes/sessions.php
##		  language/lang_english/lang_main.php
##		  admin/index.php
##		  templates/subSilver/admin/index_body.tpl 
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################  
## 
##  Author Notes: Tested with phpBB v2.0.14.
##	Use of $userdata['session_agent'] to reference the DB
##	value elsewhere in the code is also enabled by this
##	mod.
##  
##  This mod will work correctly *only* after a relogin.
##  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
##
##  TODO
##  ~~~~
##	o Limit response on page to 1 line.
##	o Record hits-by-agent, maybe stats?
## 
############################################################## 
## 
## MOD History: 
##   2005-05-28 - Version 1.0.0 By Tomythius 
##	Original Mod
##   2005-05-28 - Version 1.0.3 By Tomythius 
##	EasyMod Compliant & Corrections
##   2005-05-28 - Version 1.0.3 By markus_petrux
##	Security patch
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ SQL ]------------------------------------------ 
#
ALTER TABLE `phpbb_sessions` ADD `session_agent` TEXT NOT NULL 
#
#-----[ OPEN ]------------------------------------------
#
includes/sessions.php
#
#-----[ FIND ]------------------------------------------
#
   global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID;
#
#-----[ AFTER, ADD ]------------------------------------------
#
   global $HTTP_SERVER_VARS;
#
#-----[ FIND ]------------------------------------------
#
   $cookiesecure = $board_config['cookie_secure'];
#
#-----[ AFTER, ADD ]------------------------------------------
#   
   $agent = '\'' . str_replace("\'","''",$HTTP_SERVER_VARS['HTTP_USER_AGENT']) . '\'';
#
#-----[ FIND ]------------------------------------------
#
   $sql = "UPDATE " . SESSIONS_TABLE . "
      SET session_user_id

#
#-----[ IN-LINE FIND ]------------------------------------------
#
   $page_id,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
   session_agent = $agent
#
#-----[ FIND ]------------------------------------------
#
      $sql = "INSERT INTO " . SESSIONS_TABLE . "
         (session_id
         VALUES (
#
#-----[ IN-LINE FIND ]------------------------------------------
#
   session_page,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
   session_agent,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
   $page_id,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
   $agent,
#
#-----[ FIND ]------------------------------------------
#
   $userdata['session_time'] = $current_time;
#
#-----[ AFTER, ADD ]------------------------------------------
#
   $userdata['session_agent'] = $agent;
#
#-----[ FIND ]------------------------------------------
#
   global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID;
#
#-----[ AFTER, ADD ]------------------------------------------
#
   global $HTTP_SERVER_VARS;
#
#-----[ FIND ]------------------------------------------
#
   $cookiesecure = $board_config['cookie_secure'];
#
#-----[ AFTER, ADD ]------------------------------------------
#   
   $agent = '\'' . str_replace("\'","''",$HTTP_SERVER_VARS['HTTP_USER_AGENT']) . '\'';
#
#-----[ FIND ]------------------------------------------
#
               $sql = "UPDATE " . SESSIONS_TABLE . "
                  SET session_time
#
#-----[ IN-LINE FIND ]------------------------------------------
#
   $thispage_id
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, session_agent = $agent

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
$lang['IP_Address'] = 'IP Address';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['User_Agent'] = 'User Agent';
# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/index.php
# 
#-----[ FIND ]------------------------------------------ 
#
	"L_IP_ADDRESS" => $lang['IP_Address'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	"L_USER_AGENT" => $lang['User_Agent'],
#
#-----[ FIND ]------------------------------------------ 
#
	$sql = "SELECT u.user_id, u.username, u.user_session_time, u.user_session_page, s.session_logged_in, s.session_ip, s.session_start
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
	s.session_start
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
	, s.session_agent
#
#-----[ FIND ]------------------------------------------ 
#
	$sql = "SELECT session_page, session_logged_in, session_time, session_ip, session_start
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
	session_start
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
	, session_agent
# 
#-----[ FIND ]------------------------------------------ 
#
	$reg_ip = decode_ip($onlinerow_reg[$i]['session_ip']);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	$reg_agent = $onlinerow_reg[$i]['session_agent'];
# 
#-----[ FIND ]------------------------------------------ 
#
	"IP_ADDRESS" => $reg_ip,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	"USER_AGENT" => htmlspecialchars($reg_agent),
# 
#-----[ FIND ]------------------------------------------ 
#
	$guest_ip = decode_ip($onlinerow_guest[$i]['session_ip']);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	$guest_agent = $onlinerow_guest[$i]['session_agent'];
# 
#-----[ FIND ]------------------------------------------ 
#
	"IP_ADDRESS" => $guest_ip,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	"USER_AGENT" => htmlspecialchars($guest_agent),
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/index_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
	<th width="20%" class="thCornerR">&nbsp;{L_FORUM_LOCATION}&nbsp;</th>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<th width="20%" class="thCornerR">&nbsp;{L_USER_AGENT}&nbsp;</th>
# 
#-----[ FIND ]------------------------------------------ 
#
	<td width="20%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_FORUM_LOCATION}" class="gen">{reg_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<td width="20%" class="{reg_user_row.ROW_CLASS}"><span class="gen">{reg_user_row.USER_AGENT}</span>&nbsp;</td># 
#
#-----[ FIND ]------------------------------------------ 
#
	<td width="20%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{guest_user_row.U_FORUM_LOCATION}" class="gen">{guest_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<td width="20%" class="{guest_user_row.ROW_CLASS}"><span class="gen">{guest_user_row.USER_AGENT}</span></td>
#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM