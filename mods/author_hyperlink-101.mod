############################################################## 
## MOD Title: Author Hyperlink
## MOD Author: tosspot <tosspot@markf.mailshell.com> Mark Fyvie http://www.fyvie.net
## MOD Description: By default the author name in a message is not a hyperlink. This mod makes 
## it a URL to the poster's profile. This might be more intuitive for some users compared to the profile button.
## MOD Version: 1.0.1 
## 
## Installation Level: easy 
## Installation Time: 1 Minute 
## Files To Edit: viewtopic.php 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## The default colour for the author before applying this mod is black. After applying the mod it will be blue, since it
## is following the "genmed" class. Feel free to modify this part to another class, or to add an additional class if you don't
## like the colour. You will find a discussion on this here:
## http://www.phpbb.com/phpBB/viewtopic.php?t=102833
############################################################## 
## MOD History: 
#
## 2003-05-19 - Version 1.0.0
## - Initial version
## 2003.09.13 - Version 1.0.1
## - Tested for phpBB v2.06
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php
# 
#-----[ FIND ]------------------------------------------ 
# 
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	$poster = ( $poster_id != ANONYMOUS ) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $poster_id) . '" class="genmed">' : '';
	$poster .= ( $poster_id != ANONYMOUS ) ? $postrow[$i]['username'] : ( ( $postrow[$i]['post_username'] != '' ) ? $postrow[$i]['post_username'] : $lang['Guest'] );
	$poster .= ( $poster_id != ANONYMOUS ) ? '</a>' : '';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 