############################################################## 
## MOD Title: User Stars GroupCP add-on
## MOD Author: cherokee red < mods@cherokeered.co.uk> (Kenny Cameron) http://www.cherokeered.co.uk/f/
## MOD Description: Add-on for the 'Users Stars' MOD - adds User's Star in the GroupCP page
## MOD Version: 1.0.1
## 
## Installation Level: Easy 
## Installation Time: ~3 Minute
## Files To Edit: groupcp.php,
##                templates/subSilver/groupcp_info_body.tpl 
##                templates/subSilver/groupcp_pending_info.tpl
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
##   2006-12-21 - Version 1.0.0
##      - First release 
## 
##   2006-12-25 - Version 1.0.1
##      - Fixed bug in install - when installing with easymod, it would do an incorrect in-line after, add with the ', &$yim' lines
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
groupcp.php
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
function generate_user_info(
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, &$yim_img
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, &$user_star_img
# 
#-----[ FIND ]------------------------------------------ 
#
	$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $row['username']) . '</a>';
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
# Note that this line is longer
#
	//
	// Get moderator details for this group
	//
	$sql = "SELECT username
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
 username
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, user_give_star
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
	//
	// Get user information for this group
	//
	$sql = "SELECT u.username, 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
 u.username
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, u.user_give_star
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
	$sql = "SELECT u.username 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
 u.username
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, u.user_give_star
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer & there are 3 of them to find ;)
#
	generate_user_info(
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, $yim_img
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, $user_star_img
# 
#-----[ FIND ]------------------------------------------ 
#
		'MOD_YIM' => $yim,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
		// User Stars  ::  cherokee red
		'MOD_USERSTAR_IMG' => $user_star_img,
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer & there are 3 of them to find ;)
#
		generate_user_info(
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, $yim_img
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, $user_star_img
# 
#-----[ FIND ]------------------------------------------ 
#
				'YIM' => $yim,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				// User Stars  ::  cherokee red
				'USERSTAR_IMG' => $user_star_img,
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer & there are 3 of them to find ;)
#
				generate_user_info(
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, $yim_img
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, $user_star_img
# 
#-----[ FIND ]------------------------------------------ 
#
					'YIM' => $yim,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
					// User Stars  ::  cherokee red
					'USERSTAR_IMG' => $user_star_img,
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/groupcp_info_body.tpl 
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
<span class="gen"><a href="{U_MOD_VIEWPROFILE}" class="gen">{MOD_USERNAME}</a></span>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
</span>
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {MOD_USERSTAR_IMG}
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
<span class="gen"><a href="{member_row.U_VIEWPROFILE}" class="gen">{member_row.USERNAME}</a></span>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
</span>
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {member_row.USERSTAR_IMG}
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/groupcp_pending_info.tpl
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
<span class="gen"><a href="{pending_members_row.U_VIEWPROFILE}" class="gen">{pending_members_row.USERNAME}</a></span>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
</span>
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {pending_members_row.USERSTAR_IMG}
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
