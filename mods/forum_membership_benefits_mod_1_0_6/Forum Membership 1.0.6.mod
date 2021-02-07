############################################################## 
## MOD Title: Forum Membership Benefits by User Group 
## MOD Author: insanity74 < insani.t@gmail.com > http://www.lusermanagement.com/phpbbmod/
## MOD Description: This mod allows for members of admin-specified groups 
## to have the ability to send/recive PMs, have an avatar, and have a signature.  A member
## also have the words "Site Member" below their user name on each post.
## MOD Version: 1.0.6
## 
## Installation Level: Intermediate 
## Installation Time: 30 Minutes 
## Files To Edit: 	privmsg.php
##					viewtopic.php
##					admin/admin_groups.php
##					includes/functions.php
##					includes/page_header.php
##					includes/usercp_register.php	
##					language/lang_english/lang_admin.php
##					language/lang_english/lang_main.php
##					templates/subSilver/overall_header.tpl
##					templates/subSilver/profile_add_body.tpl
##					templates/subSilver/subSilver.cfg
##					templates/subSilver/viewtopic_body.tpl
##					templates/subSilver/admin/group_edit_body.tpl
##
## Included Files:	blankavatar.gif 
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
## This mod installs a checkbox in the ACP Group Management.  Checking the box
## gives all members of the group the ability to add signatures and avatars to
## their profile, and also allows the use of private messaging.  If a user was
## once a member, and they are taken out of the group, their avatar and signature
## will no longer be displayed in any posts they have ever made.  
## This mod allows for great flexibility to the intermediate and advanced modder,
## as almost anything in a template can be switched on or off by placing
## <!-- BEGIN switch_user_extras_yes --> or <!-- BEGIN switch_user_extras_no -->
## around the code that the admin wants displayed/not displayed.
## Also, it should be noted that the signature language can be added/modified to
## display something like "Become a member!", and it will display in place of
## an ex-member's signature.
##
############################################################## 
## MOD History: 
## 
##   2005-12-06 - Version 1.0.0 
##      - Released
##
##	 2005-12-09 - Version 1.0.1
##		- Re-wrote the main function to be more efficient, fixed security
##			holes, and improved mod instructions
##
##	 2005-12-12 - Version 1.0.2
##   	- Small bug fixes in mod instructions
##
##	 2005-12-20 - Version 1.0.3
##   	- Fixed SQL Injection Vulnerability in admin_groups.php
##		- Changed avatar location an added code for it in .cfg 
##
##	 2006-01-03 - Version 1.0.4
##   	- Minor MOD instruction fixes
##		- Cleaned up the SQL statement for name matching in privmsg.php
##		- Removed array_push for compatiility with PHP versions previous to 4
##		- Cleaned up syntax in group_edit_body.php
##
##	2006-01-04 - Version 1.0.6
##		- Optimized main function SQL statment to remove "array_unique" from
##			the function.
##		- Added "Site Member" status to user's posts
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ COPY ]------------------------------------------
#
copy blankavatar.gif to templates/subSilver/images/blankavatar.gif
# 
#-----[ SQL ]------------------------------------------ 
# 
ALTER TABLE phpbb_groups ADD group_extras TINYINT(1) NOT NULL DEFAULT 0;
# 
#-----[ OPEN ]------------------------------------------ 
# 
privmsg.php
# 
#-----[ FIND ]------------------------------------------ 
# 
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//begin mod group_extras
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PRIVMSGS);
init_userprefs($userdata);
//
// End session management
//

$pm_users_ok = compare_for_extras();
	$pm_yes = (in_array($userdata['user_id'], $pm_users_ok)) ? TRUE : FALSE;
	if ( $pm_yes == FALSE )
	{
		message_die(GENERAL_MESSAGE, 'PM_disabled_user');
	}
//end mod group_extras
# 
#-----[ FIND ]------------------------------------------ 
# 
$userdata = session_pagestart($user_ip, PAGE_PRIVMSGS);
init_userprefs($userdata);
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
//following lines commented out for mod group_extras
//$userdata = session_pagestart($user_ip, PAGE_PRIVMSGS);
//init_userprefs($userdata);
# 
#-----[ FIND ]------------------------------------------ 
# 
	if ( $submit )
	{
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//begin mod group_extras
	$extras_username = ( isset($HTTP_POST_VARS['username']) ) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';
	$sql = "SELECT user_id
				FROM " . USERS_TABLE . "
				WHERE username = '" . str_replace("\'", "''", $extras_username) . "'";
	$result_id = $db->sql_query($sql);
	if (!($result_id)) 
	{
		message_die(GENERAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
	}
	list($pm_username_extras) = $db->sql_fetchrow($result_id);
	$members_id = compare_for_extras();
	if (!in_array($pm_username_extras, $members_id))
	{
		$error = TRUE;
		$error_msg = $lang['user_disabled_pm'];
	}
//end mod group_extras
# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php
# 
#-----[ FIND ]------------------------------------------ 
# 
if ($row = $db->sql_fetchrow($result))
{
	do
	{
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//begin mod group_extras
	$user_post_extras = compare_for_extras();
	if (!in_array($row['user_id'] , $user_post_extras))
	{
		$row['user_avatar'] = $images['nonmember_avatar'];
		$row['user_sig'] = $lang['no_sig_topic'];
		$row['member_title'] = $lang['NonMember_Title'];
	}
	else
	{
		$row['member_title'] = $lang['Member_Title'];
	}
//end mod group_extras
# 
#-----[ FIND ]------------------------------------------ 
# 
for($i = 0; $i < $total_posts; $i++)
{
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//begin mod group_extras
	$poster_member_title = $postrow[$i]['member_title'];
//end mod group_extras
# 
#-----[ FIND ]------------------------------------------ 
# 
		'POSTER_NAME' => $poster,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//begin mod group_extras
		'POSTER_MEMBER_TITLE' => $poster_member_title,
//end mod group_extras
# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_groups.php
# 
#-----[ FIND ]------------------------------------------ 
# 
	$group_hidden = ( $group_info['group_type'] == GROUP_HIDDEN ) ? ' checked="checked"' : '';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 	
//begin mod group_extras
	$extra_checked = ($group_info['group_extras'] == 1) ? ' checked="checked"' : '';
//end mod group_extras
# 
#-----[ FIND ]------------------------------------------ 
# 
		'L_GROUP_DELETE_CHECK' => $lang['group_delete_check'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//begin mod group_extras
		'L_GROUP_EXTRAS' => $lang['group_extras'],
		'L_GROUP_EXTRAS_CHECK' => $lang['group_extras_check'],
//end mod group_extras	
# 
#-----[ FIND ]------------------------------------------ 
# 
		'S_GROUP_ACTION' => append_sid("admin_groups.$phpEx"),
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
//begin mod group_extras
		'S_EXTRA_CHECKED' => $extra_checked,
//end mod group_extras	

# 
#-----[ FIND ]------------------------------------------ 
# 
		$delete_old_moderator = isset($HTTP_POST_VARS['delete_old_moderator']) ? true : false;
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//begin mod group_extras
		$group_extras = isset($HTTP_POST_VARS['group_extras']) ? true : false;
		$group_extras_int = intval($group_extras);
//end mod group_extras
# 
#-----[ FIND ]------------------------------------------ 
# 
			$sql = "UPDATE " . GROUPS_TABLE . "
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
//mod group_extras
#
#-----[ FIND ]------------------------------------------ 
# 
SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "', group_description = '" . str_replace("\'", "''", $group_description) . "', group_moderator = $group_moderator
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, group_moderator = $group_moderator
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, group_extras = $group_extras_int
# 
#-----[ OPEN ]------------------------------------------ 
#
includes/functions.php
# 
#-----[ FIND ]------------------------------------------ 
#
?>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//begin mod group_extras
function compare_for_extras()
{
	global $db;
	$grabbed_users = array();
	
	$sql = "SELECT DISTINCT g.group_id, ug.user_id
		FROM " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug
		WHERE g.group_extras = 1
		AND ug.group_id = g.group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain post/user information.", '', __LINE__, __FILE__, $sql);
	}

	while ($userrow = $db->sql_fetchrow($result))
	{
		array_push($grabbed_users, $userrow['user_id']);
	}
	
	return $grabbed_users;
}
//end mod group_extras
# 
#-----[ OPEN ]------------------------------------------ 
#
includes/page_header.php
# 
#-----[ FIND ]------------------------------------------ 
#
	'NAV_LINKS' => $nav_links_html)
);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
//begin mod group_extras
//
// Extra Content?
//
if ( $userdata['session_logged_in'] )
{
	$extras_switches = compare_for_extras();
		if (in_array($userdata['user_id'], $extras_switches))
		{
			$template->assign_block_vars('switch_user_extras_yes', array());
			$extras_yes = 1;
		}
		else
		{
			$template->assign_block_vars('switch_user_extras_no', array());
			$extras_yes = 0;
		}
}
//end mod group_extras
# 
#-----[ FIND ]------------------------------------------ 
#
	if ( !empty($userdata['user_popup_pm']) )
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//mod group_extras
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
($userdata['user_popup_pm'])
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 && ($extras_yes == 1)
# 
#-----[ OPEN ]------------------------------------------ 
#
includes/usercp_register.php	
# 
#-----[ FIND ]------------------------------------------ 
#
		'L_CONFIRM_CODE_EXPLAIN'	=> $lang['Confirm_code_explain'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
//begin mod user_extras			
		'L_NO_SIGNATURE' 			=> $lang['No_Sig'],
		'L_NO_SIGNATURE_EXP' 		=> $lang['No_Sig_Exp'],
//end mod user_extras
# 
#-----[ FIND ]------------------------------------------ 
#
	if ( $mode != 'register' )
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//mod user_extras
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
( $mode != 'register' )
# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
#
(
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 && ($extras_yes == 1 ))
#
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php
# 
#-----[ FIND ]------------------------------------------ 
#
$lang['group_delete_check'] = 'Delete this group';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
//begin mod group_extras
$lang['group_extras'] = 'Forum Membership';
$lang['group_extras_check'] = 'Give Avatar, Private Message, and Signature permissions';
//end mod group_extras
# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
//
// That's all, Folks!
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//begin mod user_extras
$lang['No_Sig'] = 'Signature';
$lang['No_Sig_Exp'] = 'The Administrator does not allow signatures for your user group.';
$lang['PM_disabled_user'] = 'Private Messaging is disabled for your user group.';
$lang['user_disabled_pm'] = 'The user you are trying to send a message to cannot recieve private messages';
//change '' to 'text' to display signature text for ex-members in the next line
$lang['no_sig_topic'] = '';
$lang['Member_Title'] = 'Site Member';
$lang['NonMember_Title'] = '';
//end mod user_extras
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/overall_header.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
					<tr>
						<td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; &nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td>
					</tr>
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
					<tr>
						<td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;
						<!-- BEGIN switch_user_extras_yes -->
						<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>
						<!-- END switch_user_extras_yes -->
						&nbsp; &nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td>
					</tr>
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/profile_add_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
	<tr> 
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#	  
	<!-- BEGIN switch_user_extras_yes -->
# 
#-----[ FIND ]------------------------------------------ 
#
		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<!-- END switch_user_extras_yes -->
	<!-- BEGIN switch_user_extras_no -->
	<tr> 
	  <td class="row1"><span class="gen">{L_NO_SIGNATURE}:</span></td>
	  <td class="row2"><span class="gen">{L_NO_SIGNATURE_EXP}:</span></td>
	</tr>
	<!-- END switch_user_extras_no -->
# 
#-----[ FIND ]------------------------------------------ 
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ADD_SIGNATURE}:</span></td>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#	  
	<!-- BEGIN switch_user_extras_yes -->
# 
#-----[ FIND ]------------------------------------------ 
#
		<span class="gen">{L_NO}</span></td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<!-- END switch_user_extras_yes -->
#
#-----[ OPEN ]------------------------------------------
#	
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------
#
$images['voting_graphic'][4] = "$current_template_images/voting_bar.gif";
#
#-----[ AFTER, ADD ]------------------------------------------
#
//begin mod group_extras
$images['nonmember_avatar'] = "../../$current_template_images/blankavatar.gif";
//end mod group_extras
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/viewtopic_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
		<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name">
#
#-----[ IN-LINE FIND ]------------------------------------------
#
</a><b>{postrow.POSTER_NAME}
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
<br />{postrow.POSTER_MEMBER_TITLE}
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/group_edit_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
		{L_GROUP_DELETE_CHECK}</td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_EXTRAS}:</span></td>
	  <td class="row2" width="62%"> 
		<input type="checkbox" name="group_extras" value="1"{S_EXTRA_CHECKED} />
		{L_GROUP_EXTRAS_CHECK}</td>
	</tr>
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM