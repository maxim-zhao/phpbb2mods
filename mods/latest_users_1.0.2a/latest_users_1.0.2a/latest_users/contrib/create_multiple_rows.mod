############################################################## 
## MOD Title: Create Multiple Rows
## MOD Author: Noobarmy < noobarmy@phpbbmodders.net > (Anthony Chu) http://phpbbmodders.net
## MOD Description: Puts the latest users onto multiple rows
## MOD Version: 0.2.0
## 
## Installation Level: Easy
## Installation Time: 2 Minutes 
## Files To Edit: 
##			includes/functions_last_users.php
##
## Included Files:
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
## 			This puts latest users onto multiple rows, you need to instlal latest users before running this
############################################################## 
## MOD History: 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_last_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$show_users = ( $board_config['show_latest_users_no'] > 0 ) ? $board_config['show_latest_users_no'] : '1'; /* Amount of Users being shown */

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# Replace 1 with the amount of rows
$rows = 1;

# 
#-----[ FIND ]------------------------------------------ 
# 
		LIMIT $show_users";

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
		LIMIT " . ($show_users * $rows);

# 
#-----[ FIND ]------------------------------------------ 
# 
		if ( $row['user_avatar_type'] && $row['user_allowavatar'] )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
		if  ( ($count % $show_users) == 0 )
		{
			$template->assign_block_vars('row_loop', array());
		}

# 
#-----[ FIND ]------------------------------------------ 
# 
users_loop

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
row_loop.users_loop
	
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM