##############################################################
## MOD Title: Usergroup Auto Join
## MOD Author: LifeIsPain <brian@orvp.net> (Brian Evans)
## MOD Description: Creates a usergroup category that allows a user to join without needing
##       the approval of the group moderator. This is good if you have a forum that not
##       everyone wants on their index page, but an Auto Join group is given permission to
##       view.
## MOD Version: 1.0.0
##
## Installation Level: easy
## Installation Time: 10 Minutes
##
## Files To Edit:      6
##                 - includes/constants.php
##                 - groupcp.php
##                 - admin/admin_groups.php
##                 - templates/subSilver/groupcp_info_body.tpl
##                 - templates/subSilver/admin/group_edit_body.tpl
##                 - language/lang_english/lang_main.php
##
## Included Files: n/a
##############################################################
## MOD History:
## 
## v1.0.0 - 06/17/2003
##    + Submitted to MODs Database
## 
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: When installing this mod, know that users may leave and join groups at will
##       without the group moderator intervening if the group is set to auto. No emails will
##       be sent.
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php

#
#-----[ FIND ]------------------------------------------
#
define('GROUP_HIDDEN', 2);

#
#-----[ AFTER, ADD ]------------------------------------------
#
define('GROUP_AUTO', 3);


#
#-----[ OPEN ]------------------------------------------
#
groupcp.php

#
#-----[ FIND ]------------------------------------------
#
		if ( $row['group_type'] == GROUP_OPEN )

#
#-----[ REPLACE WITH ]------------------------------------------
#
		$grouptype = $row['group_type'];
		if ( $row['group_type'] == GROUP_OPEN || $grouptype == GROUP_AUTO )

#
#-----[ FIND ]------------------------------------------
#
	$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending) 
		VALUES ($group_id, " . $userdata['user_id'] . ", 1)";

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	if ( $grouptype == GROUP_AUTO )
	{
		$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending) 
			VALUES ($group_id, " . $userdata['user_id'] . ", 0)";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Error inserting user group subscription", "", __LINE__, __FILE__, $sql);
		}

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
		);

		$message = $lang['Group_approved'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}


#
#-----[ FIND ]------------------------------------------
#
		else if ( $group_info['group_type'] == GROUP_HIDDEN )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		else if ( $group_info['group_type'] == GROUP_AUTO )
		{
			$template->assign_block_vars('switch_subscribe_group_input', array());

			$group_details =  $lang['This_auto_group'];
			$s_hidden_fields = '<input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />';
		}

#
#-----[ FIND ]------------------------------------------
#
		'S_GROUP_OPEN_TYPE' => GROUP_OPEN,

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		'S_GROUP_AUTO_TYPE' => GROUP_AUTO,
		'S_GROUP_AUTO_CHECKED' => ( $group_info['group_type'] == GROUP_AUTO ) ? ' checked="checked"' : '',
		'L_GROUP_AUTO' => $lang['Group_auto'],


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
	$group_auto = ( $group_info['group_type'] == GROUP_AUTO ) ? ' checked="checked"' : '';

#
#-----[ FIND ]------------------------------------------
#
		'S_GROUP_OPEN_TYPE' => GROUP_OPEN,

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		'L_GROUP_AUTO' => $lang['group_auto'],
		'S_GROUP_AUTO_TYPE' => GROUP_AUTO,
		'S_GROUP_AUTO_CHECKED' => $group_auto,


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/groupcp_info_body.tpl

#
#-----[ FIND ]------------------------------------------
# 
#   NOTE: the full line to look for is:
#		<td class="row2"><span class="gen"><span class="gen"><input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}" {S_GROUP_OPEN_CHECKED} /> {L_GROUP_OPEN} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_CLOSED_TYPE}" {S_GROUP_CLOSED_CHECKED} />	{L_GROUP_CLOSED} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_HIDDEN_TYPE}" {S_GROUP_HIDDEN_CHECKED} />	{L_GROUP_HIDDEN} &nbsp;&nbsp; <input class="mainoption" type="submit" name="groupstatus" value="{L_UPDATE}" /></span></td>
#
<input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}"

#
#-----[ IN-LINE FIND ]------------------------------------------
#
{L_GROUP_HIDDEN} &nbsp;&nbsp;

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 <input type="radio" name="group_type" value="{S_GROUP_AUTO_TYPE}" {S_GROUP_AUTO_CHECKED} /> {L_GROUP_AUTO} &nbsp;&nbsp;


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/group_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
# 
#   NOTE: the full line to look for is:
#		<input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}" {S_GROUP_OPEN_CHECKED} /> {L_GROUP_OPEN} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_CLOSED_TYPE}" {S_GROUP_CLOSED_CHECKED} />	{L_GROUP_CLOSED} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_HIDDEN_TYPE}" {S_GROUP_HIDDEN_CHECKED} />	{L_GROUP_HIDDEN}</td> 
#
<input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}"

#
#-----[ IN-LINE FIND ]------------------------------------------
#
{L_GROUP_HIDDEN}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_AUTO_TYPE}" {S_GROUP_AUTO_CHECKED} />	{L_GROUP_AUTO}


#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Group_hidden']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Group_auto'] = 'Auto join group';

#
#-----[ FIND ]------------------------------------------
#
$lang['This_hidden_group']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['This_auto_group'] = 'This is an automatically approved group: click to request membership';


#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['group_hidden']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['group_auto'] = 'Auto join group';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM