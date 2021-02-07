############################################################## 
## MOD Title: Active Members Only
## MOD Author: defender-uk < defenders_realm@yahoo.com > (Andy Smith) http://www.mp3locator.co.uk
## MOD Description: Only display active members.
## MOD Version: 1.1.1
##
## Installation Level: (Easy) 
## Installation Time: 1 Minutes 
## Files To Edit: 
##			memberlist.php
##			includes/functions.php
##
## Included Files: (N/A)
##
############################################################## 
##
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##
############################################################## 
##
## Author Notes: 
## 
## This mod was made due to people using my phpBB forum as a link for google to index.
##
## v1.0.0 Was to keep them out of the memberslist.
##
## v1.1.0 Also stops them from being displayes as the 'newest member' on the main page.
##
## v1.1.1 Pagination Fix by CJ Greiner
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------ 
# 
memberlist.php

#
#-----[ FIND ]------------------------------------------ 
# 
	WHERE user_id <> " . ANONYMOUS . "
#
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	AND user_active = 1

#
#-----[ FIND ]------------------------------------------ 
#
WHERE user_id <> " . ANONYMOUS;
#
#-----[ REPLACE WITH ]------------------------------------------ 
#
WHERE user_id <> " . ANONYMOUS . " AND user_active = 1";
#
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions.php

#
#-----[ FIND ]------------------------------------------ 
# 
	WHERE user_id <> " . ANONYMOUS . "
#
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	AND user_active = 1

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 

# EoM 