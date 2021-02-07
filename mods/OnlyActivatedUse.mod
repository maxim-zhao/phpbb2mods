############################################################## 
## MOD Title:   Only Activated Users In Who Is Online MOD 
## MOD Author:  Martin Truckenbrodt < webmaster@martin-truckenbrodt.com > (Martin Truckenbrodt) http://martin-truckenbrodt.com 
## MOD Description: 
##   Only activated users are counted for Who Is Online Board Statistics on Forum Index
##   
## 
## MOD Version: 1.0.1 
## 
## Installation Level: Easy 
## Installation Time: 1 Minute 
## Files To Edit: 
##   includes/functions.php 
## 
## Included Files: 
##   N/A
## 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
############################################################## 
## MOD History: 
## 
##   2007-01-03 - Version 1.0.0
##      - first release 
## 
##   2007-02-07 - Version 1.0.1
##      - changed to REPLACE WITH insteat of IN LINE REPLACE 
## 
############################################################## 
## Author Notes: 
##   N/A
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS;
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS
				 . " AND user_active = 1";
# 
#-----[ FIND ]------------------------------------------ 
# 
			$sql = "SELECT user_id, username
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS . "
				ORDER BY user_id DESC
				LIMIT 1";
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
			$sql = "SELECT user_id, username
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS . "
				AND user_active = 1
				ORDER BY user_id DESC
				LIMIT 1";
# 
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM