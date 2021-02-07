##############################################################
## MOD Title: Database Admin Section Part 3
## MOD Author: Spent Casing < spentcasing@clan-noquarter.net > (Spent Casing) http://www.clan-noquarter.net
## MOD Description: If you have Optimize Database mod by
##                  Sko22 < sko22@quellicheilpc.com > installed
##                  this will move it to the new Database Admin
##                  section
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 2 minutes
## Files To Edit: admin/admin_db_utilities.php
## Included Files: 
## Generator: MOD Studio 3.0 Alpha 1 [mod functions 0.2.1677.25348]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
##############################################################
## MOD History:
## 
##   2004-09-05 - Version 1.0.0
## 
## 
##      - First Stable release.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

admin/admin_db_utilities.php
#
#-----[ FIND ]------------------------------------------
#
$module['General']['Optimize_DB'] = $filename . "?perform=optimize";

#
#-----[ REPLACE WITH ]------------------------------------------
#
$module['Database_admin']['Optimize_DB'] = $filename . "?perform=optimize";
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

