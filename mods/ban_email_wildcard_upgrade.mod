############################################################## 
## MOD Title: Ban Entire Groups of Email Domains with wildcard
## MOD Author: jsmotta < phpbb@rusticweb.com > (Jonathan Motta) http://www.rusticweb.com/
## MOD Description: Allows another * wildcard to be placed in
## the domain of banned emails, so that entire groups of
## similar free email domains can be banned at once.
## So now "*@yahoo*" matches jerky@yahoo.com, jerky@yahoo.nu,
##    jerky@yahoo.de, etc, etc, etc. 
##
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~3 Minutes 
## Files To Edit: admin/admin_user_ban.php 
## Included Files: N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## MOD History:
## 
## Dec 24, 2003 (Merry Christmas!) - Version 1.0.0
##  - Initial Release
############################################################## 
## Author Notes: 
## My very first phpBB MOD... is it really this easy?
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_user_ban.php

# 
#-----[ FIND ]------------------------------------------ 
# 
if (preg_match('#^(([a-z0-9&.-_+])|(\*))+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$#is', trim($email_list_temp[$i]))) 

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
if (preg_match('#^(([a-z0-9&.-_+])|(\*))+@[a-z0-9\-\.]+((\.([a-z0-9\-]+\.)*?[a-z]+)|(\*))$#is', trim($email_list_temp[$i])))

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 