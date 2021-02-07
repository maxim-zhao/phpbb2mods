############################################################## 
## MOD Title: Remove Duplicate Sessions
## MOD Author: nurhendra < N/A > (Nur Hendra) N/A 
## MOD Description: To remove duplicate/old sessions from the same user. 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: ~1 Minutes 
## Files To Edit: includes/sessions.php
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: This MOD will remove duplicate/old sessions when a 
##               user is logging in to increase security (i.e. last
##               session info when logged from Browser/PC #1 will be 
##               removed when user is logging in from Browser/PC #2).
## 
############################################################## 
## MOD History: 
## 
##   2005-03-27 - Version 1.0.0 
##      - Initial release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/sessions.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	//
	// Create or update the session
	//

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	// MOD: Remove Duplicate Sessions ...
	$sql = "DELETE FROM " . SESSIONS_TABLE .
		" WHERE session_user_id = " . $user_id .
		" AND session_id <> '" . $session_id ."'";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error in removing duplicate sessions', '', __LINE__, __FILE__, $sql);
	}
	// ... MOD: Remove Duplicate Sessions


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM