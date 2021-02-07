##############################################################
## MOD Title: Management and Permissions Links on ACP Index
## MOD Author: afterlife_69 < afterlife_69@hotmail.com > (Dean Newman) http://www.gamerzvault.com
## MOD Description: This will change the online-users row so when you click a users name it will go to there profile, and 2 links will be added user there name to Management and Permissions
## MOD Version: 1.1.0
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: admin/index.php
##                templates/subSilver/admin/index_body.tpl
## Included Files: 
## Generator: MOD Studio 3.0 Alpha 1 [mod functions 0.2.1677.25348]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: Saves the extra clicks :D
##############################################################
## MOD History:
## 
##   2005-06-10 - Version 1.0.0
##      - First Stable release.
##   2005-07-17 - Version 1.1.0
##      - Removed extra language entrys, 
##		- Changed template find to {reg_user_row.USERNAME} to make it work with easymod on all templates
##		- Fixed the permissions link
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
admin/index.php

#
#-----[ FIND ]------------------------------------------
#
		"L_STARTED" => $lang['Login'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
		"L_MANAGE" => $lang['Manage'],
		"L_PERMISSIONS" => $lang['Permissions'],

#
#-----[ FIND ]------------------------------------------
#
						"U_USER_PROFILE" => append_sid("admin_users.$phpEx?mode=edit&amp;" . POST_USERS_URL . "=" . $onlinerow_reg[$i]['user_id']),

#
#-----[ REPLACE WITH ]------------------------------------------
#
					"U_USER_PROFILE" => append_sid("../profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $onlinerow_reg[$i]['user_id']),
					"U_USER_PERMISSIONS" => append_sid("admin_ug_auth.$phpEx?" . "&amp;" . POST_USERS_URL . "=" . $onlinerow_reg[$i]['user_id'] . "&amp;mode=user"),
					"U_USER_EDIT" => append_sid("admin_users.$phpEx?mode=edit&amp;" . POST_USERS_URL . "=" . $onlinerow_reg[$i]['user_id']),

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
{reg_user_row.USERNAME}

#
#-----[ IN-LINE FIND ]------------------------------------------
#
</td>

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
<br /><span class="gensmall">&nbsp;<a href="{reg_user_row.U_USER_EDIT}" class="gensmall">{L_MANAGE}</a>&nbsp;|&nbsp;<a href="{reg_user_row.U_USER_PERMISSIONS}" class="gensmall">{L_PERMISSIONS}</a>&nbsp;</span>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

