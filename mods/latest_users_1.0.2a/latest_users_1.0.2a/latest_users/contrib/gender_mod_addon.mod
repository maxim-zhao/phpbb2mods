############################################################## 
## MOD Title: Addon for Evil>3's Gender Mod 
## MOD Author: Noobarmy < noobarmy@phpbbmodders.org > (Anthony Chu) http://phpbbmodders.org
## MOD Description: 
## MOD Version: 0.1.0
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit: 2
##		functions_last_users.php
##		templates/subSilver/latest_users.tpl
##
## Included Files: 0
##	
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
##	This is an addon for using evil<3's birthday mod add-on. Don't install this if it's not installed, Bound to get errors. 
##
############################################################## 
## MOD History: 
## 
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
	$sql = 'SELECT user_id, username, user_from, user_avatar, user_avatar_type, user_allowavatar

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
user_from,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 user_gender,

# 
#-----[ FIND ]------------------------------------------ 
# 		
		$template->assign_block_vars('users_loop', array(

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
		global $images, $lang;

		   switch ( $row['user_gender'] )
		    {
		        case GENDER_M:
		            $gender_img =    $images['gender_m'];
		            $l_poster_gender =      $lang['gender_m'];
		        break;
		
		        case GENDER_F:
		            $gender_img =    $images['gender_f'];
		            $l_poster_gender =      $lang['gender_f'];
		        break;
		
		        default:
		            $gender_img =    $images['gender_x'];
		            $l_poster_gender =      $lang['gender_x'];
		    }
		
		    switch ( $board_config['gender_display'] )
		    {
		        case GENDER_IMG:
		            $gender = '<img src="' . $gender_img . '" border="0" alt="' . $l_poster_gender . '" title="' . $l_poster_gender . '" />';
		        break;
		        
		        case GENDER_TEXT:
		            $gender = $l_poster_gender;
		        break;
		        
		        default:
		            $gender = '';
		    }

# 
#-----[ FIND ]------------------------------------------ 
# 
								'USERNAME' => $row['username'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
								'GENDER' => $gender,

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/latest_users.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
{users_loop.USERNAME}</span>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
{users_loop.GENDER}

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM