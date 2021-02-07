############################################################## 
## MOD Title: Username in modcp
## MOD Author: Cherokee Red < cherokeered@blueyonder.co.uk > (Kenny Cameron) 
http://cherokeered.mrikasu.com/forums/
## MOD Description: Displays the username of the topic creator in the modcp. Helps to remember who created what topic when you're locking/moving/etc . . . and saves you having to open up the topic to get this info :P
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~5 Minutes
## Files To Edit: modcp.php
## 		  templates/subSilver/modcp_body.tpl
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
## 
## Made from a request in this topic at phpBB.com - http://www.phpbb.com/phpBB/viewtopic.php?t=239893
## 
############################################################## 
## MOD History: 
## 
##   2004-11-30 - Version 1.0.0 
##      - mod created
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------ 
#
modcp.php
#
#-----[ FIND ]------------------------------------------ 
#
			$topic_title = $row['topic_title'];
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
			$username = $row['username'];


# 
#-----[ FIND ]------------------------------------------ 
# 
				'TOPIC_TYPE' => $topic_type, 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				'USERNAME' => $username,
#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/modcp_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
	  <td class="catHead" colspan="5" align="center" height="28"><span class="cattitle">{L_MOD_CP}</span> 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
colspan="5"
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
colspan="6"
# 
#-----[ FIND ]------------------------------------------ 
# 
	  <td class="spaceRow" colspan="5" align="center"><span class="gensmall">{L_MOD_CP_EXPLAIN}</span></td>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
colspan="5"
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
colspan="6"
# 
#-----[ FIND ]------------------------------------------ 
# 
	  <th width="4%" class="thLeft" nowrap="nowrap">&nbsp;</th>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	  <th nowrap="nowrap">&nbsp;{L_USERNAME}&nbsp;</th>
# 
#-----[ FIND ]------------------------------------------ 
# 
	  <td class="row1" align="center" valign="middle"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	  <td class="row1" align="center" valign="middle"><span class="postdetails">{topicrow.USERNAME}</span></td>
# 
#-----[ FIND ]------------------------------------------ 
# 
	  <td class="catBottom" colspan="5" height="29">
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
colspan="5"
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
colspan="6"
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM