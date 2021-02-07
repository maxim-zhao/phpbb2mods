############################################################## 
## MOD Title: User Stars Viewonline add-on
## MOD Author: cherokee red < mods@cherokeered.co.uk> (Kenny Cameron) http://www.cherokeered.co.uk/f/
## MOD Description: Add-on for the 'Users Stars' MOD - adds User's Star in the Viewonline page
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~3 Minute
## Files To Edit: viewonline.php,
##                templates/subSilver/viewonline_body.tpl 
##      
## Included Files: n/a
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
## 
##
## This is *NOT* a reputation MOD and never will be.
## This MOD does *NOT* giver users extra permissions if they have a star.
## It's just a simple way of pointing out donators/helpers without mucking up ranks and custom titles 
##
############################################################## 
## MOD History: 
## 
##   2006-12-25 - Version 1.0.0
##      - First release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
viewonline.php
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
//
// Get user list
//
$sql = "SELECT u.user_id
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
 u.user_id
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, u.user_give_star
# 
#-----[ FIND ]------------------------------------------ 
#
			$location = $forum_data[$row['session_page']];
		}
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
		// User Stars  ::  cherokee red
		$user_star_img = ( $row['user_give_star'] ) ? $row['user_give_star'] : '&nbsp;';
		if ( $row['user_give_star'] == '1' )
		{
			$user_star_img = '<img src="' . $images['icon_user_star'] . '" alt="' . sprintf($lang['user_give_star'], $row['username']) . '" title="' . sprintf($lang['user_give_star'], $row['username']) . '" border="0" />';
		}
		else
		{
			$user_star_img = '';
		}
# 
#-----[ FIND ]------------------------------------------ 
#
			'FORUM_LOCATION' => $location,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
			// User Stars  ::  cherokee red
			'USERSTAR_IMG' => $user_star_img,
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/viewonline_body.tpl 
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
<a href="{reg_user_row.U_USER_PROFILE}" class="gen">{reg_user_row.USERNAME}</a>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
</a>
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {reg_user_row.USERSTAR_IMG}
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
