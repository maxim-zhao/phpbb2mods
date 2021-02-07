############################################################## 
## MOD Title: Moderators seeing all mailadresses of all the users 
## MOD Author: Raimon < Raimon@phpBBservice.nl > (Raimon) http://www.phpBBservice.nl
## MOD Description: With this mod can moderators viewing all the emailadresses on the memberlist, profile and viewtopic of all the users.
## MOD Version: 1.0.0
## 
## Installation Level: (Easy) 
## Installation Time: 1 Minute 
## Files To Edit:
##	 memberlist.php
##          includes/usercp_viewprofile.php
## Included Files: n/a
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## 
############################################################## 
## MOD History: 
## 
##   2006-09-12 - Version 0.0.1
##      - first release [beta]
##  2006-10-28 Version 1.0.0
##       - Version chanche end litlle problems fixes whit mod template
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
# 
#-----[ OPEN ]------------------------------------------ 
# 
memberlist.php
#
#-----[ FIND ]------------------------------------------
#
if ( !empty($row['user_viewemail']) || $userdata['user_level'] == ADMIN )
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
 ADMIN
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 || $userdata['user_level'] == MOD 
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------
#
if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
 ADMIN
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
|| $userdata['user_level'] == MOD
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 


