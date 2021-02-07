############################################################## 
## MOD Title: Link Poster's Name To Profile
## MOD Author: Raccoon < agvulpine@ameritech.net > (Eric Stargardt) http://forum.americastinks.org/
## MOD Description: Links the poster's name to their profile.
## MOD Version: 1.0.0
## FOR phpBB: 2.0.6
## 
## Installation Level: easy
## Installation Time: 5 Minutes
## Files To Edit: (1) viewtopic.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## MOD History:
##
##     2004-07-15  - Version 1.0.0
##          - Original release
##
############################################################## 
## Author Notes: 
##  
##      This is my first mod.  Let me know if I've done anything incorrectly.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : '<a href="' . $temp_url . '">' . $postrow[$i]['username'] . '</a>';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 