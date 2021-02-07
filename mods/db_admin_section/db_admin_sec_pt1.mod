##############################################################
## MOD Title: Database Admin Section in ACP
## MOD Author: Spent Casing < spentcasing@clan-noquarter.net > (Spent Casing) http://www.clan-noquarter.net
## MOD Description: Adds a Database Admin Section in ACP for better organization
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 4 minutes
## Files To Edit: language/lang_english/lang_admin.php
##                admin/admin_db_utilities.php
## Included Files: 
## Generator: MOD Studio 3.0 Alpha 1 [mod functions 0.2.1677.25348]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
## If you have Database cleaning mod by Florian_DVP
##  < florian@developpez.biz > installed also do Part 2
## 
## If you have Optimize Database mod by 
## Sko22 < sko22@quellicheilpc.com > installed also do Part 3
##############################################################
## MOD History:
## 
##   2004-09-05 - Version 1.0.0
## 
##      - First Stable release.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['General'] = 'General Admin';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Database_admin'] = 'Database Admin';
#
#-----[ OPEN ]------------------------------------------
#

admin/admin_db_utilities.php
#
#-----[ FIND ]------------------------------------------
#
$module['General']['Backup_DB'] = $filename . "?perform=backup";
#
#-----[ REPLACE WITH ]------------------------------------------
#
$module['Database_admin']['Backup_DB'] = $filename . "?perform=backup";


#
#-----[ FIND ]------------------------------------------
#
$module['General']['Restore_DB'] = $filename . "?perform=restore";
#
#-----[ REPLACE WITH ]------------------------------------------
#
$module['Database_admin']['Restore_DB'] = $filename . "?perform=restore";

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

