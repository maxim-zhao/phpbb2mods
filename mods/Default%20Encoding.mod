############################################################## 
## MOD Title: Default Encoding
## MOD Author: billytcf <billytcf@hotmail.com> (N/A) N/A
## MOD Description: This mode changes the default encoding of phpBB2 to utf-8
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: 2 Minutes 
## Files To Edit:  
##		language/lang_english/lang_main.php 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: The default encoding of phpBB2 is iso-8859-1, this causes problem when displaying chinese characters, this mode changes the default behaviour.
## 
############################################################## 
## MOD History: 
## 
##   2004-12-11 - Version 1.0.0
##      -  The initial release, support phpBB 2.0.11, not tested on others
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['ENCODING'] = 'iso-8859-1';

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
$lang['ENCODING'] = 'utf-8';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 