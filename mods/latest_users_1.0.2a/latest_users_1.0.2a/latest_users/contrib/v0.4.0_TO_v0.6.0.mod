############################################################## 
## MOD Title: Latest Users Online
## MOD Author: Noobarmy < noobarmy@phpbbmodders.com > (Anthony Chu) http://phpbbmodders.com
## MOD Description: Displays the latest users online on the index page.
## MOD Version: 0.2.4
## 
## Installation Level: Easy
## Installation Time: 2 Minutes 
## Files To Edit: 1
##		language/lang_english/lang_main.php
## Included Files: 1
##		functions_last_users.php
##		latest_users.tpl
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
## Author Notes: 
## 	This is an upgrade from 0.2.4 to 0.4.0
##	If you don't have 0.4.0a installed use the 0.6.0 install file
##
############################################################## 
## MOD History: 
## 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
#
copy root/includes/functions_last_users.php to includes/functions_last_users.php
copy root/templates/subSilver/latest_users.tpl to root/templates/subSilver/latest_users.tpl

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
$lang['latest_users_online'] = 'Latest Users Online';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM