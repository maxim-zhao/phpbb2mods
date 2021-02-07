############################################################## 
## MOD Title: Forum Permissions List integration with Attachment MOD
## MOD Author: Graham < phpbb@grahameames.co.uk > (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: This MOD integrates support for the attachment MOD
## into the Forum Permissions List to enable you to manage permissions
## for attachments on the same screen as the other permissions
##
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## Files To Edit:
##    admin/admin_forumauth_list.php
## Included Files: 
##    None
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
## These instructions assume that you already have both MODs
## installed on your forum.
##
## These instructions adapted from those for the Attachment MOD
## giving changes to admin_forumauth.php
############################################################## 
## MOD History:
## Oct 17, 2003 - Version 1.0.0
##  - Initial release of these instructions
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_forumauth_list.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$forum_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN);

# 
#-----[ AFTER, ADD ]---------------------------------------
# 
attach_setup_forum_auth($simple_auth_ary, $forum_auth_fields, $field_names);

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 