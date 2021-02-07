##############################################################
## MOD Title: Group Icons
## MOD Author: TacoV < taco@vdwaals.nl > (Taco) http://www.vdwaals.nl
## MOD Description: Adds a symbol to the user in the topic, the memberlist
##	and the profile view for each group the user's a member of.
##	You can turn this on and off for the topic and the profile
##	on a user-by-user basis in your profile settings.
## MOD Version: 1.0.5
##
## Installation Level: Intermediate
## Installation Time: 20 Minutes
## Files To Edit: viewtopic.php,
##	memberlist.php
##      admin/admin_groups.php,
##	includes/usercp_register.php,
##	includes/usercp_avatar.php,
##	includes/usercp_viewprofile.php,
##      templates/SubSilver/viewtopic_body.tpl,
##      templates/SubSilver/memberlist_body.tpl,
##      templates/SubSilver/admin/group_edit_body.tpl,
##	templates/subSilver/profile_add_body.tpl,
##	templates/subSilver/profile_view_body.tpl,
##	language/lang_english/lang_admin.php,
##	language/lang_english/lang_main.php
## Included Files: N/A
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
## - This MOD was formerly known as 'Group Bars'
## 
##############################################################
## MOD History:
##
##   2005-12-19 - Version 0.5.0
##      - First development release
##   2005-12-19 - Version 0.6.0
##      - Images are now relatively defined and a bug with the avatar gallery should
##		be solved
##   2005-12-19 - Version 0.7.0
##      - Fixed some more bugs in the ACP and made the SQL EasyMOD-compatible
##   2005-12-20 - Version 1.0.0
##      - First submit
##   2005-12-28 - Version 1.0.1
##      - First re-submit. Made a typo by copying a line from a chat screen.
##   2005-12-28 - Version 1.0.2
##      - Second re-submit. Better way of processing the sql. Changed <br/> into <br />
##		and <img> into <img />. Changed the FIND commands pointing to comments.
##   2006-02-13 - Version 1.0.3
##	- Moved the bar to the left, after the post count, instead of after the signature
##	- Added a href to the group pictures, linking to the group page
##	- Added bars on the user profile page, thanks to Liljeberg
##   2006-03-15 - Version 1.0.4
##	- Corrected some apparent typo's for the resubmit
##	- Added icons on the memberlist
##	- Renamed MOD from 'Group Bars' to 'Group Icons'
##   2006-03-31 - Version 1.0.5
##	- Now using INCREMENT instead of REPLACE commmand
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_groups` ADD `group_icon` VARCHAR( 255 ) DEFAULT NULL;
ALTER TABLE `phpbb_users` ADD `user_showgroupicons` TINYINT( 1 ) DEFAULT '1';

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
$resync = FALSE; 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//

$sql = "SELECT ug.user_id, g.group_icon, g.group_name, g.group_id
	FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
	WHERE ug.group_id = g.group_id 
		AND g.group_icon <> \"\"";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain usergroup icon information.", '', __LINE__, __FILE__, $sql);
}

$group_icons = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);
$total_group_icons = count($group_icons);

//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];

#
#-----[ AFTER, ADD ]------------------------------------------
# 
//
// Group Icons MOD - Start
//

$images_group_icons = '';
if ($userdata['user_showgroupicons']) 
{
	for($group_icon = 0; $group_icon < $total_group_icons; $group_icon++)
	{
		if ( $group_icons[$group_icon]['user_id'] == $postrow[$i]['user_id'] )
		{
			$images_group_icons .= '<a href="groupcp.'.$phpEx.'?' . POST_GROUPS_URL . '=' . $group_icons[$group_icon]['group_id'] . '" title="' . $group_icons[$group_icon]['group_name'] . '"><img src="' . $group_icons[$group_icon]['group_icon'] . '" border="0" /></a>';
		}
	}
}

//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
'SIGNATURE' => $user_sig,

#
#-----[ AFTER, ADD ]------------------------------------------
# 
//
// Group Icons MOD - Start
//
'GROUP_ICONS' => $images_group_icons,
//
// Group Icons MOD - End
//

#
#-----[ OPEN ]------------------------------------------
#
memberlist.php

#
#-----[ FIND ]------------------------------------------
#
'L_PM' => $lang['Private_Message'], 

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
'L_CURRENT_MEMBERSHIPS' => $lang['Current_memberships'],
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
switch( $mode )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//

$sql = "SELECT ug.user_id, g.group_icon, g.group_name, g.group_id
	FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
	WHERE ug.group_id = g.group_id 
		AND g.group_icon <> \"\"";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain usergroup icon information.", '', __LINE__, __FILE__, $sql);
}

$group_icons = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);
$total_group_icons = count($group_icons);

//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
$search = '<a href="' . $temp_url . '">' . $lang['Search_user_posts'] . '</a>';

#
#-----[ AFTER, ADD ]------------------------------------------
#

//
// Group Icons MOD - Start
//
$images_group_icons = '';
for($group_icon = 0; $group_icon < $total_group_icons; $group_icon++)
{
	if ( $group_icons[$group_icon]['user_id'] == $row['user_id'] )
	{
		$images_group_icons .= '<a href="groupcp.'.$phpEx.'?' . POST_GROUPS_URL . '=' . $group_icons[$group_icon]['group_id'] . '" title="' . $group_icons[$group_icon]['group_name'] . '"><img src="' . $group_icons[$group_icon]['group_icon'] . '" border="0" /></a>';
	}
}
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
'YIM' => $yim,

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
'GROUP_ICONS' => $images_group_icons,
//
// Group Icons MOD - End
//

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_groups.php

#
#-----[ FIND ]------------------------------------------
#
'group_type' => GROUP_OPEN);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
'group_image' => '',
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
'GROUP_MODERATOR' => $group_moderator, 

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
'IMAGE' => ( $group_info['group_icon'] != "" ) ? $group_info['group_icon'] : "",
'IMAGE_DISPLAY' => ( $group_info['group_icon'] != "" ) ? '<img src="../' . $group_info['group_icon'] . '" />' : "",
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
	'U_SEARCH_USER' => append_sid("../search.$phpEx?mode=searchuser"),

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
'L_GROUP_ICON' => $lang['Group_icon'],
'L_GROUP_ICON_EXPLAIN' => $lang['Group_icon_explain'],
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
$delete_old_moderator = isset($HTTP_POST_VARS['delete_old_moderator']) ? true : false;

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
$group_image = ( (isset($HTTP_POST_VARS['group_image'])) ) ? trim($HTTP_POST_VARS['group_image']) : '';
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
$this_userdata = get_userdata($group_moderator, true);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
//
// The image has to be a jpg, gif or png
//
if($group_image != "")
{
	if ( !preg_match("/(\.gif|\.png|\.jpg)$/is", $group_image))
	{
		$group_image = "";
	}
}
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "', group_description = '" . str_replace("\'", "''", $group_description) . "', group_moderator = $group_moderator 

#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_moderator = $group_moderator

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, group_icon = '" . str_replace("\'", "''", $group_image) . "'

#
#-----[ FIND ]------------------------------------------
#
$sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name, group_description, group_moderator, group_single_user) 

#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_single_user

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, group_icon

#
#-----[ FIND ]------------------------------------------
#
VALUES ($group_type, '" . str_replace("\'", "''", $group_name) . "', '" . str_replace("\'", "''", $group_description)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
'0'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, '" . str_replace("\'", "''", $group_image) . "'

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $board_config['allow_smilies'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
$showgroupicons = ( isset($HTTP_POST_VARS['showgroupicons']) ) ? ( ($HTTP_POST_VARS['showgroupicons']) ? TRUE : 0 ) : TRUE;
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $userdata['user_allowsmile'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
$showgroupicons = ( isset($HTTP_POST_VARS['showgroupicons']) ) ? ( ($HTTP_POST_VARS['showgroupicons']) ? TRUE : 0 ) : $userdata['user_showgroupicons'];
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."',

#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_allowhtml = $allowhtml

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
user_showgroupicons = $showgroupicons, 

#
#-----[ FIND ]------------------------------------------
#
$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password

#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_allowhtml

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
user_showgroupicons, 

#
#-----[ FIND ]------------------------------------------
#
VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$allowhtml

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
$showgroupicons, 

#
#-----[ FIND ]------------------------------------------
#
$allowsmilies = $userdata['user_allowsmile'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
$showgroupicons = $userdata['user_showgroupicons'];
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
display_avatar_gallery($mode, $avatar_category, $user_id, $email,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$allowviewonline

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
$showgroupicons, 

#
#-----[ FIND ]------------------------------------------
#
'ALLOW_AVATAR' => $board_config['allow_avatar_upload'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
'SHOW_GROUP_ICONS_YES' => ( $showgroupicons ) ? 'checked="checked"' : '',
'SHOW_GROUP_ICONS_NO' => ( !$showgroupicons ) ? 'checked="checked"' : '',
//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
'L_SHOW_GROUP_ICONS' => $lang['Show_group_icons'],
//
// Group Icons MOD - End
//

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php

#
#-----[ FIND ]------------------------------------------
#
function display_avatar_gallery($mode, &$category, &$user_id, &$email, &$current_email

#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$hideonline,

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
&$showgroupicons, 

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#
$db->sql_freeresult($result);

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//

$sql = "SELECT g.group_icon, g.group_name, g.group_id
   FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
   WHERE ug.group_id = g.group_id
      AND ug.user_id = " . $profiledata['user_id'] . "
      AND g.group_icon <> \"\"";
if ( !($result = $db->sql_query($sql)) )
{
   message_die(GENERAL_ERROR, "Could not obtain usergroup icon information.", '', __LINE__, __FILE__, $sql);
}

$group_icons = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);
$total_group_icons = count($group_icons);

//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//

$images_group_icons = '';
for($group_icon = 0; $group_icon < $total_group_icons; $group_icon++)
{
	$images_group_icons .= '<a href="groupcp.'.$phpEx.'?' . POST_GROUPS_URL . '=' . $group_icons[$group_icon]['group_id'] . '" title="' . $group_icons[$group_icon]['group_name'] . '"><img src="' . $group_icons[$group_icon]['group_icon'] . '" border="0" /></a>';
}

//
// Group Icons MOD - End
//

#
#-----[ FIND ]------------------------------------------
#
$template->pparse('body');

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Group Icons MOD - Start
//
if ($userdata['user_showgroupicons']) 
{ 
	$template->assign_vars(array(
		'L_CURRENT_MEMBERSHIPS' => $lang['Current_memberships'],
		'GROUP_ICONS' => $images_group_icons )
	);
	$template->assign_block_vars('switch_showgroupicons', array() ); 
}
//
// Group Icons MOD - End
//


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}">

#
#-----[ IN-LINE FIND ]------------------------------------------
# 
{postrow.POSTER_FROM}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
<br />{postrow.GROUP_ICONS}

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/memberlist_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<th class="thTop" nowrap="nowrap">{L_USERNAME}</th>

#
#-----[ AFTER, ADD ]------------------------------------------
#
<th class="thTop" nowrap="nowrap">{L_CURRENT_MEMBERSHIPS}</th>

#
#-----[ FIND ]------------------------------------------
#
<td class="{memberrow.ROW_CLASS}" align="center"><span class="gen"><a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a></span></td>

#
#-----[ AFTER, ADD ]------------------------------------------
#
<td class="{memberrow.ROW_CLASS}" align="center"><span class="gen">{memberrow.GROUP_ICONS}</span></td>

#
#-----[ FIND ]------------------------------------------
#
<td class="catBottom" colspan="{%:1}" height="28">&nbsp;</td>

#
#-----[ INCREMENT ]-------------------------------------
#
%:1

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/group_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN group_edit -->

#
#-----[ BEFORE, ADD ]------------------------------------------
#
<tr>
	<td class="row1" width="38%"><span class="gen">{L_GROUP_ICON}:</span><br />
	<span class="gensmall">{L_GROUP_ICON_EXPLAIN}</span></td>
	<td class="row2"><input class="post" type="text" name="group_image" size="40" maxlength="255" value="{IMAGE}" /><br />{IMAGE_DISPLAY}</td>
</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<tr>
  <td class="row1"><span class="gen">{L_BOARD_LANGUAGE}:</span></td>
  <td class="row2"><span class="gensmall">{LANGUAGE_SELECT}</span></td>
</tr>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
<tr>
	<td class="row1"><span class="gen">{L_SHOW_GROUP_ICONS}:</span></td>
	<td class="row2">
		<input type="radio" name="showgroupicons" value="1" {SHOW_GROUP_ICONS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="showgroupicons" value="0" {SHOW_GROUP_ICONS_NO} />
		<span class="gen">{L_NO}</span>
	</td>
</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<tr>
	<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
	<td> <b><span class="gen">{INTERESTS}</span></b></td>
</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<!-- BEGIN switch_showgroupicons -->
<tr>
	<td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_CURRENT_MEMBERSHIPS}</span></td>
	<td> <b><span class="gen">{GROUP_ICONS}</span></b></td>
</tr>
<!-- END switch_showgroupicons -->

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Login_reset_time_explain']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Group_icon'] = 'Group icon';
$lang['Group_icon_explain'] = 'The URL of the Group icon Image  (relative to phpBB2 root path, example "images/icons/vip.gif")';

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Please_remove_install_contrib']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Show_group_icons'] = 'Show Group icons';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM