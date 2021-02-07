############################################################## 
## MOD Title: Folder Link
## MOD Author: Xore < xore@azuriah.com > Xore http://forums.azuriah.com
## MOD Description: Folder Link for latest posts
## MOD Version: 1.0.2
## 
## Installation Level: Easy
## Installation Time: 1 Minutes 
## Files To Edit: viewforum.php, 
##                templates/subSilver/viewforum_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: For a function i use 97% of the time i view a topic, i hate clicking
##               on probably the tiniest image link on the entire board.
############################################################## 
## MOD History: 
## v1.0.2 "Inline" fix for replace with 
## v1.0.1 "Inline" fix
## v1.0.0 First version release. no bugs, i hope :P
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
# 
#-----[ OPEN ]------------------------------------------ 
#
viewforum.php

# 
#-----[ FIND ]------------------------------------------ 
# 
		$last_post_url = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $topic_rowset[$i]['topic_last_post_id']) . '#' . $topic_rowset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		$last_post_folder_url = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $topic_rowset[$i]['topic_last_post_id']) . '#' . $topic_rowset[$i]['topic_last_post_id'] . '"><img src="' . $folder_image . '" alt="' . $folder_alt . '" title="' . $folder_alt . '" border="0" /></a>';

# 
#-----[ FIND ]------------------------------------------ 
# 
			'TOPIC_FOLDER_IMG' => $folder_image, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
			'FOLDER_LAST_IMG' => $last_post_folder_url,

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/viewforum_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	  <td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
<img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" />

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
{topicrow.FOLDER_LAST_IMG}

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 