############################################################## 
## MOD Title: Disable maximum signature length for admin 
## MOD Author: RedRaven < stian@nettenter.no > (Stian Seland) http://phpbb.no/ 
## MOD Description: Let admin have a longer signature than the maximum length decided in ACP
## MOD Version: 1.0.0 
## 
## Installation Level: Easy
## Installation Time: 1 Minutes 
## Files To Edit: usercp_register.php 
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: This is probably one of the simplest mods ever made. I`ve originally made this mod
## 		 for my own use but I decided to release so everyone can use it.
## 
############################################################## 
## MOD History: 
## 
##   2004-05-05 - Version 1.0.0 
##      - Initial release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_register.php

# 
#-----[ FIND ]------------------------------------------ 
# 
		if ( strlen($signature) > $board_config['max_sig_chars'] )

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
		if ( strlen($signature) > $board_config['max_sig_chars'] && $userdata['user_level'] != ADMIN)

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM