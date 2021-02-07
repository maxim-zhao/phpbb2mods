############################################################## 
## MOD Title: User Stars
## MOD Author: cherokee red < mods@cherokeered.co.uk> (Kenny Cameron) http://www.cherokeered.co.uk/f/
## MOD Description: Admins can give any user a 'star'. 
The star is an image that will show next to their username in viewtopic and profiles.
This star can be used as a reward system - good users get a star. Or for marking donators to your site.
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~10 Minutes 
## Files To Edit: admin/admin_users.php
##                memberlist.php, 
##                viewtopic.php, 
##                includes/usercp_viewprofile.php, 
##                language/lang_english/lang_admin.php,
##                language/lang_english/lang_main.php,
##                templates/subSilver/admin/user_Edit_body.tpl
##                templates/subSilver/memberlist_body.tpl
##                templates/subSilver/profile_view_body.tpl
##                templates/subSilver/subSilver.cfg
##                templates/subSilver/viewtopic_body.tpl
##      
## Included Files: templates/subSilver/images/user_star.gif
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
## The idea behind this MOD was originally from a torrent site called oink.me.uk
## where users were given a star if the became a power+ user or donated
##
############################################################## 
## MOD History: 
## 
##   2006-12-19 - Version 0.0.1
##      - First release 
##  
##   2006-12-19 - Version 0.0.2
##      - Fixed incorrect $lang, templates & sql
##  
##   2006-12-20 - Version 0.0.3
##      - Fixed typo in subSilver.cfg code edit
##      - Fixed typo in admin/user_edit_body.tpl code edit
##      - Fixed typos in viewtopic.php code edit
##      - Fixed alt & title text in includes/usercp_viewprofile.php & viewtopic.php
##      - Removed &nbsp; - so that it doesn't output whitespace if the user doesn't have a star.
##  
##   2006-12-20 - Version 0.0.4
##      - Added memberlist support \o/
##      - Reduced code in FIND Statements
##
##   2006-12-20 - Version 0.0.5 
##      - Fixed sql FIND statement in memberlist.php - caused EasyMOD to fail
##      - Fixed sql statement in memberlist.php - caused sql error  
##      - Fixed typo in language/lang_english/lang_admin.php code edit
##      - Fixed typo in admin/admin_users.php code edit
##
##   2006-12-26 - Version 0.0.6
##      - Removed redundent var
##      - Added comments
##
##   2007-02-15 - Version 1.0.0
##      - Submitted to phpBB MODs Database
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ SQL ]------------------------------------------ 
#
ALTER TABLE phpbb_users ADD user_give_star tinyint(1) DEFAULT '0' NOT NULL
# 
#-----[ COPY ]------------------------------------------ 
#
copy templates/subSilver/images/user_star.gif to templates/subSilver/images/user_star.gif
# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_users.php
# 
#-----[ FIND ]------------------------------------------ 
#
		$user_allowpm = ( !empty($HTTP_POST_VARS['user_allowpm']) ) ? intval( $HTTP_POST_VARS['user_allowpm'] ) : 0;
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
		// User Stars  ::  cherokee red
		$user_give_star = ( !empty($HTTP_POST_VARS['user_give_star']) ) ? intval( $HTTP_POST_VARS['user_give_star'] ) : 0;

# 
#-----[ FIND ]------------------------------------------ 
# Note that the full line may be longer
#
			$sql = "UPDATE " . USERS_TABLE . "
				SET
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, user_allow_pm = $user_allowpm
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, user_give_star = $user_give_star
# 
#-----[ FIND ]------------------------------------------ 
# 
		$user_allowpm = $this_userdata['user_allow_pm'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
		// User Stars  ::  cherokee red
		$user_give_star = $this_userdata['user_give_star'];

# 
#-----[ FIND ]------------------------------------------ 
#
			$s_hidden_fields .= '<input type="hidden" name="user_allowpm" value="' . $user_allowpm . '" />';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
			// User Stars  ::  cherokee red
			$s_hidden_fields .= '<input type="hidden" name="user_give_star" value="' . $user_give_star . '" />';

# 
#-----[ FIND ]------------------------------------------ 
# 
			'ALLOW_PM_YES' => ($user_allowpm) ? 'checked="checked"' : '',
			'ALLOW_PM_NO' => (!$user_allowpm) ? 'checked="checked"' : '',
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
			// User Stars  ::  cherokee red
 			'GIVE_USER_STAR_YES' => ($user_give_star) ? 'checked="checked"' : '',
			'GIVE_USER_STAR_NO' => (!$user_give_star) ? 'checked="checked"' : '',

# 
#-----[ FIND ]------------------------------------------ 
# 
			'L_ALLOW_PM' => $lang['User_allowpm'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
			// User Stars  ::  cherokee red
			'L_GIVE_USER_STAR' => $lang['user_give_star'],
# 
#-----[ OPEN ]------------------------------------------ 
# 
memberlist.php
#
#-----[ FIND ]------------------------------------------ 
# Note that the full line may be longer
#
$sql = "SELECT username,
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
 username, 
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 user_give_star,
# 
#-----[ FIND ]------------------------------------------ 
# Note that the full line may be longer
#
		$search = '<a href="' . $temp_url . '">
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
			'USERNAME' => $username,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
			// User Stars  ::  cherokee red
			'USERSTAR_IMG' => $user_star_img,
# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php
#
#-----[ FIND ]------------------------------------------ 
# Note that the full line may be longer
#
// Go ahead and pull all data for this topic
//
$sql = "SELECT u.username,
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
u.username,
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 u.user_give_star,
#
#-----[ FIND ]------------------------------------------ 
# Note that the full line may be longer
#
	$template->assign_block_vars('postrow', array(
		'ROW_COLOR' =>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	// User Stars  ::  cherokee red
	$user_star_img = ( $postrow[$i]['user_give_star'] ) ? $postrow[$i]['user_give_star'] : '&nbsp;';

	if ( $postrow[$i]['user_give_star'] == '1' )
	{
		$user_star_img = '<img src="' . $images['icon_user_star'] . '" alt="' . sprintf($lang['user_give_star'], $postrow[$i]['username']) . '" title="' . sprintf($lang['user_give_star'], $postrow[$i]['username']) . '" border="0" />';
	}
	else
	{
		$user_star_img = '';
	}

#
#-----[ FIND ]------------------------------------------ 
# 
		'PM_IMG' => $pm_img,
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
		// User Stars  ::  cherokee red
		'USERSTAR_IMG' => $user_star_img,
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------ 
# 
//
// Generate page
//
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	// User Stars  ::  cherokee red
	$user_star_img = ( $profiledata['user_give_star'] ) ? $profiledata['user_give_star'] : '&nbsp;';

	if ( $profiledata['user_give_star'] == '1' )
	{
		$user_star_img = '<img src="' . $images['icon_user_star'] . '" alt="' . sprintf($lang['user_give_star'], $profiledata['username']) . '" title="' . sprintf($lang['user_give_star'], $profiledata['username']) . '" border="0" />';
	}
	else
	{
		$user_star_img = '';
	}

#
#-----[ FIND ]------------------------------------------ 
# 
	'PM_IMG' => $pm_img,
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	// User Stars  ::  cherokee red
	'USERSTAR_IMG' => $user_star_img,
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['User_allowpm'] = 'Can send Private Messages';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// User Stars  ::  cherokee red
$lang['user_give_star'] = 'Give user a star?';
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Send_private_message'] = 'Send private message';
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// User Stars  ::  cherokee red
$lang['user_give_star'] = '%s has been starred';
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/user_edit_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
		<input type="radio" name="user_allowpm" value="0" {ALLOW_PM_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	<!-- User Stars  ::  cherokee red -->
	<tr> 
	  <td class="row1"><span class="gen">{L_GIVE_USER_STAR}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_give_star" value="1" {GIVE_USER_STAR_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_give_star" value="0" {GIVE_USER_STAR_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<!-- User Stars  ::  cherokee red -->
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/memberlist_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
<a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
{memberrow.USERNAME}</a>
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {memberrow.USERSTAR_IMG}
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_view_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
	<td class="catRight" width="60%"><b><span class="gen">{L_ABOUT_USER}</span></b></td>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
{L_ABOUT_USER}
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {USERSTAR_IMG}
# 
#-----[ FIND ]------------------------------------------ 
# 
	<td class="catLeft" align="center" height="28"><b><span class="gen">{L_CONTACT} {USERNAME} </span></b></td>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
{L_CONTACT} {USERNAME}
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {USERSTAR_IMG}
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/subSilver.cfg
# 
#-----[ FIND ]------------------------------------------ 
# 
$images['icon_pm'] = "$current_template_images/{LANG}/icon_pm.gif";
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// User Stars  ::  cherokee red
$images['icon_user_star'] = "$current_template_images/user_star.gif";
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/viewtopic_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# Note that the full line may be longer
#
	<!-- BEGIN postrow -->
	<tr> 
		<td 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
{postrow.POSTER_NAME}
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 {postrow.USERSTAR_IMG}
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
