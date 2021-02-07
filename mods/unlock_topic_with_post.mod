############################################################## 
## MOD Title: Unlock Topic with Post
## MOD Author: GaretJax < st.jonathan@gmail.com > (Jonathan Stoppani) http://garetjax.info 
## MOD Description: Unlock a Topic when you write "-unlock-" in the posting-text while having admin-rights
## MOD Version: 1.0.0
## 
## Installation Level: easy
## Installation Time: 1 Minutes 
## Files To Edit: (1) functions_post.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##    This mod is based on th "Close Topic with Post" mod created from fishgod
## 
############################################################## 
## MOD History:
##
## 2005-03-28 - Version 1.0.0
##						- Initial Release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_post.php


# 
#-----[ FIND ]------------------------------------------ 
# 
	//
	// Add poll
	// 

# 
#-----[ BEFORE, ADD ]----------------------------------- 
# 
	// START unlock_topic_with_text_mod
	if($userdata['user_level'] == ADMIN)
		{
		if(strstr($post_message, "-unlock-"))
			{
				$sql = "UPDATE " . TOPICS_TABLE . " 
					SET topic_status = " . TOPIC_UNLOCKED . " 
					WHERE topic_id = $topic_id 
						AND forum_id = $forum_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
				}
			};
		};
	// END unlock_topic_with_text_mod


#
#-----[ SAVE/CLOSE ALL FILES ]-------------------------- 
# 
# EoM 