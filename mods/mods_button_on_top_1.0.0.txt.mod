############################################################## 
## MOD Title:          Mods button on top
## MOD Author:         Murkrow < murkrow@volja.net > (n/a) http://f00rum.0wnz-y00.net/viewtopic.php?p=505 
## MOD Description:    This MOD adds Moderator buttons on top of topic (under Topic Title).
## MOD Version:        1.0.0
## MOD Compatibility:  2.0.6
## 
## Installation Level: Easy
## Installation Time:  1 Minute
## Files To Edit:      1
##      templates/subSilver/viewtopic_body.tpl
##
## Included Files: n/a
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## This is my first mod and there is NO bugs (good start, huh :D). Well, I hope :)
## 
############################################################## 
## MOD History: 
##
##   2004-03-19 - Version 1.0.0
##      - Mod created
##
##
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------------ 
# 
templates/subSilver/viewtopic_body.tpl

# 
#-----[ FIND ]------------------------------------------------ 
# 

	<td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a><br />

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

	{S_TOPIC_ADMIN}

# 
#-----[ SAVE/CLOSE ALL FILES ]-------------------------------- 
# 
# EoM