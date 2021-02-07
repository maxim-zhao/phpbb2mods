############################################################## 
## MOD Title: Fix to eliminate "This page cannot be displayed" error when doing a search
## MOD Author: P Fuller < pfuller@gmail.com > (N/A) N/A
## MOD Description: Some browsers will display the above error when going back and forth
##                  between the search results and the found forum post
## MOD Version: 1.0.1 
## 
## Installation Level: easy 
## Installation Time: 1 Minute
## Files To Edit: search.php 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## 
## This MOD has been tested on phpBB 2.0.13
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

search.php

# 
#-----[ FIND ]------------------------------------------ 
# 

		$sql = "UPDATE " . SEARCH_TABLE . " 
			SET search_id = $search_id, search_array = '" . str_replace("\'", "''", $result_array) . "'
			WHERE session_id = '" . $userdata['session_id'] . "'";
		if ( !($result = $db->sql_query($sql)) || !$db->sql_affectedrows() )
		{
			$sql = "INSERT INTO " . SEARCH_TABLE . " (search_id, session_id, search_array) 
				VALUES($search_id, '" . $userdata['session_id'] . "', '" . str_replace("\'", "''", $result_array) . "')";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert search results', '', __LINE__, __FILE__, $sql);
			}
		}


# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

	    redirect(append_sid("search.$phpEx?search_id=$search_id", true)); 


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 