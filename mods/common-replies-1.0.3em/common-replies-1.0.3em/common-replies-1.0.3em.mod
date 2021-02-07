##############################################################
## MOD Title: Common Replies (Canned Messages) MOD
## MOD Author: Sune Trudslev < sune.trudslev@tanis.dk > (Sune Trudslev) http://www.tanis.dk
## MOD Description: Adds predefined messages to groups.
## MOD Version: 1.0.3
## 
## Installation Level: Intermediate
## Installation Time: 30 minutes
## Files To Edit: viewtopic.php
##                posting.php
##                admin/admin_groups.php
##                includes/constants.php
##                includes/functions_post.php
##                includes/usercp_register.php
##                language/lang_english/lang_admin.php
##                language/lang_english/lang_main.php
##                templates/subSilver/admin/group_edit_body.tpl
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/posting_body.tpl
##                templates/subSilver/viewtopic_body.tpl
## Included Files: 
##                admin/admin_canned.php
##                includes/functions_canned.php
##                templates/subSilver/admin/canned_edit.tpl
##                templates/subSilver/admin/canned_group_select_body.tpl
##                templates/subSilver/admin/canned_list_body.tpl
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
## This MOD adds the ability to add canned (predefined) messages to groups and also the ability 
## for members of a group to define their own custom canned (predefined) messages. 
## These can then be be used to post a really fast reply.
##############################################################
## MOD History:
## 
##   2004-10-13 - Version 1.0.0
## 
##      - First Stable release
## 
##   2004-10-28 - Version 1.0.1
## 
##      - Fixed problems with generic php extensions
##      - Fixed a problem if custom canned count was empty
##
##   2004-10-31 - Version 1.0.2
## 
##      - Happy Halloween
##	- Removed foreach() for php3 compatibility
##
##   2004-11-09 - Version 1.0.3
##
##      - Fixed an infinite loop bug
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy admin_canned.php to admin/admin_canned.php
copy functions_canned.php to includes/functions_canned.php
copy canned_edit.tpl to templates/subSilver/admin/canned_edit.tpl
copy canned_group_select_body.tpl to templates/subSilver/admin/canned_group_select_body.tpl
copy canned_list_body.tpl to templates/subSilver/admin/canned_list_body.tpl

#
#-----[ SQL ]------------------------------------------
#
# Remember to change the prefix if you use something
# different than phpbb_
# 
CREATE TABLE phpbb_canned (
  canned_id mediumint(8) unsigned NOT NULL auto_increment,
  group_id mediumint(8) unsigned NOT NULL default '0',
  canned_title varchar(100) NOT NULL default '',
  canned_message text NOT NULL,
  canned_enable_bbcode tinyint(1) NOT NULL default '0',
  canned_move_after_post tinyint(1) NOT NULL default '0',
  canned_lock_after_post tinyint(1) NOT NULL default '0',
  sortorder smallint(4) NOT NULL default '0',
  PRIMARY KEY  (canned_id),
  KEY group_id (group_id)
) TYPE=MyISAM;

CREATE TABLE phpbb_custom_canned (
  custom_canned_id mediumint(8) unsigned NOT NULL auto_increment,
  group_id mediumint(8) NOT NULL default '0',
  user_id mediumint(8) NOT NULL default '0',
  custom_canned_title varchar(100) NOT NULL default '',
  custom_canned_message text NOT NULL,
  sortorder smallint(4) NOT NULL default '0',
  PRIMARY KEY  (custom_canned_id),
  KEY user_id (user_id),
  KEY group_id (group_id)
) TYPE=MyISAM;

ALTER TABLE phpbb_groups ADD canned_footer_plain TEXT NOT NULL ,
ADD canned_footer_bbcode TEXT NOT NULL ,
ADD canned_custom_count mediumint(8) unsigned NOT NULL default '0';

#
#-----[ OPEN ]------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Canned MOD Begin
include($phpbb_root_path . 'includes/functions_canned.'.$phpEx);
// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
//
// Send vars to template
//
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Canned MOD Begin
$canned_menu = getCannedMenu();

if(count($canned_menu) > 0)
{
	$s_canned_select = "<select name=\"canned\" onchange=\"if(this[this.selectedIndex].value != 0) this.form.submit(); else this.selectedIndex = 0;\">";
	$s_canned_select .= "<option value=\"0\">" . $lang['Choose_Canned'] . "</option>";
	$s_canned_select .= "<option value=\"0\"></option>";
	for($i=0;$i<count($canned_menu);$i++)
	{
		$s_canned_select .= "<option value=\"" . $canned_menu[$i]['id'] . "\">" . $canned_menu[$i]['name'] . "</option>";
	}
	$s_canned_select .= "</select>";
}
// Canned MOD End

#
#-----[ FIND ]------------------------------------------
#
	'S_WATCH_TOPIC_IMG' => $s_watching_topic_img,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Canned MOD Begin
	'S_CANNED_SELECT' => $s_canned_select,
	'U_CANNED_POSTING' => append_sid("posting.$phpEx"),
	'FORUM_ID' => $forum_id,
	'TOPIC_ID' => $topic_id,
	// Canned MOD End
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_groups.php
#
#-----[ FIND ]------------------------------------------
#
		'GROUP_MODERATOR' => $group_moderator, 
#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Canned MOD Begin
		'CANNED_FOOTER_PLAIN' => $group_info['canned_footer_plain'],
		'CANNED_FOOTER_BBCODE' => $group_info['canned_footer_bbcode'],
		'CANNED_CUSTOM_COUNT' => $group_info['canned_custom_count'],
		// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
		'L_GROUP_HIDDEN' => $lang['group_hidden'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Canned MOD Begin
		'L_CANNED_FOOTER_PLAIN' => $lang['Canned_Footer_Plain'],
		'L_CANNED_FOOTER_PLAIN_EXPLAIN' => $lang['Canned_Footer_Plain_Explain'],
		'L_CANNED_FOOTER_BBCODE' => $lang['Canned_Footer_BBCode'],
		'L_CANNED_FOOTER_BBCODE_EXPLAIN' => $lang['Canned_Footer_BBCode_Explain'],
		'L_CANNED_CUSTOM_COUNT' => $lang['Canned_Custom_Count'],
		// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
		$delete_old_moderator = isset($HTTP_POST_VARS['delete_old_moderator']) ? true : false;
#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Canned MOD Begin
		$canned_footer_plain = isset($HTTP_POST_VARS['canned_footer_plain']) ? trim($HTTP_POST_VARS['canned_footer_plain']) : '';
		$canned_footer_bbcode = isset($HTTP_POST_VARS['canned_footer_bbcode']) ? trim($HTTP_POST_VARS['canned_footer_bbcode']) : '';
		$canned_custom_count = isset($HTTP_POST_VARS['canned_custom_count']) ? intval($HTTP_POST_VARS['canned_custom_count']) : 0;
		// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
			$sql = "UPDATE " . GROUPS_TABLE . "
				SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "',
#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_moderator = $group_moderator
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, canned_footer_plain = '" . str_replace("\'", "''", $canned_footer_plain) . "', canned_footer_bbcode = '" . str_replace("\'", "''", $canned_footer_bbcode) . "', canned_custom_count = " . $canned_custom_count . "

#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_single_user
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,canned_footer_plain,canned_footer_bbcode,canned_custom_count
#
#-----[ FIND ]------------------------------------------
#
VALUES ($group_type, '" . str_replace("\'", "''", $group_name) . "'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$group_moderator,	'0'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, '" . str_replace("\'", "''", $canned_footer_plain) . "', '" . str_replace("\'", "''", $canned_footer_bbcode) . "'," . $canned_custom_count . "
#
#-----[ OPEN ]------------------------------------------
#

posting.php
#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Canned MOD Begin
include($phpbb_root_path . 'includes/functions_canned.'.$phpEx);
// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
$refresh = $preview || $poll_add || $poll_edit || $poll_delete;
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Canned MOD Begin
$canned = isset($HTTP_POST_VARS['canned']) ? intval($HTTP_POST_VARS['canned']) : 0;
// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
			$poll_length = ( isset($HTTP_POST_VARS['poll_length']) && $is_auth['auth_pollcreate'] ) ? $HTTP_POST_VARS['poll_length'] : '';
			$bbcode_uid = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
			// Canned MOD Begin
			$move_after_post = isset($HTTP_POST_VARS['move_after_post']) ? intval($HTTP_POST_VARS['move_after_post']) : 0;
			$lock_after_post = isset($HTTP_POST_VARS['lock_after_post']) ? intval($HTTP_POST_VARS['lock_after_post']) : 0;
			// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
	else if ( $mode == 'reply' )
	{
		$user_sig = ( $userdata['user_sig'] != '' ) ? $userdata['user_sig'] : '';

		$username = ( $userdata['session_logged_in'] ) ? $userdata['username'] : '';
		$subject = '';
		$message = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Canned MOD Begin
		if($canned != 0)
		{
			if($canned < 0)
			{
				$sql = "SELECT custom_canned_message AS message,0 AS move_after_post,0 AS lock_after_post,group_id 
					FROM " . CUSTOM_CANNED_TABLE . "
					WHERE custom_canned_id = " . (-$canned);
			}
			else
			{
				$sql = "SELECT canned_message AS message,canned_move_after_post AS move_after_post,canned_lock_after_post AS lock_after_post,group_id,canned_enable_bbcode 
					FROM " . CANNED_TABLE . "
					WHERE canned_id = " . $canned;
			}
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select canned message', '', __LINE__, __FILE__, $sql);
			}

			$row = $db->sql_fetchrow($result);
			$message = $row['message'];
			$move_after_post = $row['move_after_post'];
			$lock_after_post = $row['lock_after_post'];
			$enable_bbcode = $row['canned_enable_bbcode'];
			$db->sql_freeresult($result);

			if($canned > 0)
			{
				$sql = "SELECT canned_footer_plain,canned_footer_bbcode
					FROM " . GROUPS_TABLE . "
					WHERE group_id = " . $row['group_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not select canned message', '', __LINE__, __FILE__, $sql);
				}

				$row = $db->sql_fetchrow($result);
				if($message[strlen($message)-1] != "\n")
					$message .= "\n";
				$message .= "\n";
				if($enable_bbcode == 1)
				{
					$message .= $row['canned_footer_bbcode'];
				}
				else
				{
					$message .= $row['canned_footer_plain'];
				}
				$db->sql_freeresult($result);
			}
		}
		// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
	case 'reply':
		$page_title = $lang['Post_a_reply'];
		$hidden_form_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Canned MOD Begin
		$hidden_form_fields .= '<input type="hidden" name="move_after_post" value="' . $move_after_post . '" />';
		$hidden_form_fields .= '<input type="hidden" name="lock_after_post" value="' . $lock_after_post . '" />';
		// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
$template->assign_block_vars('switch_not_privmsg', array());
#
#-----[ AFTER, ADD ]------------------------------------------
#

// Canned MOD Begin
$canned_menu = getCannedMenu();

if(count($canned_menu) > 0)
{
	$s_canned_select .= "<select name=\"canned\" onchange=\"if(this[this.selectedIndex].value != 0) { var s = true; if(this.form.message.value != '' || this.form.subject.value != '') s = confirm('" . $lang['Already_Typed_Message'] . "'); if(s) this.form.submit(); else this.selectedIndex = 0; } else this.selectedIndex = 0;\">";
	$s_canned_select .= "<option value=\"0\">" . $lang['Choose_Canned'] . "</option>";
	$s_canned_select .= "<option value=\"0\"></option>";
	for($i=0;$i<count($canned_menu);$i++)
	{
		$s_canned_select .= "<option value=\"" . $canned_menu[$i]['id'] . "\">" . $canned_menu[$i]['name'] . "</option>";
	}
	$s_canned_select .= "</select>";
}
// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
	'S_HTML_CHECKED' => ( !$html_on ) ? 'checked="checked"' : '', 
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Canned MOD Begin
	'S_CANNED_SELECT' => $s_canned_select,
	// Canned MOD End
#
#-----[ OPEN ]------------------------------------------
#

includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Canned MOD Begin
define('CANNED_TABLE', $table_prefix.'canned');
define('CUSTOM_CANNED_TABLE', $table_prefix.'custom_canned');
// Canned MOD End
#
#-----[ OPEN ]------------------------------------------
#

includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
#
	global $userdata, $user_ip;
#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Canned MOD Begin
	global $move_after_post,$lock_after_post, $SID;
	// Canned MOD End
#
#-----[ FIND ]------------------------------------------
#
	$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">';
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Canned MOD Begin
	if($move_after_post == 1)
	{
		$OldSID = $SID;
		$SID = "sid=" . $userdata['session_id'];
		$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid('modcp.' . $phpEx . '?mode=move&amp;' . POST_TOPIC_URL . '=' . $topic_id ) . '">';
		$message = $lang['Stored'] . '<br /><br />' . sprintf($lang['Click_move_message'], '<a href="' . append_sid('modcp.' . $phpEx . '?mode=move&amp;' . POST_TOPIC_URL . '=' . $topic_id ) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');
		$SID = $OldSID;

		return false;
	}
	else if($lock_after_post == 1)
	{
		$OldSID = $SID;
		$SID = "sid=" . $userdata['session_id'];
		$meta = '<meta http-equiv="refresh" content="3;url=' . append_sid('modcp.' . $phpEx . '?mode=lock&amp;' . POST_TOPIC_URL . '=' . $topic_id ) . '">';
		$message = $lang['Stored'] . '<br /><br />' . sprintf($lang['Click_lock_message'], '<a href="' . append_sid('modcp.' . $phpEx . '?mode=lock&amp;' . POST_TOPIC_URL . '=' . $topic_id ) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');
		$SID = $OldSID;

		return false;
	}
	// Canned MOD End

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------
#
//
// Let's make sure the user isn't logged in while registering,
// and ensure that they were trying to register a second time
// (Prevents double registrations)
//
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Canned MOD Begin
$sql = "SELECT  g.group_id,g.group_name,g.canned_custom_count
	FROM  " . USER_GROUP_TABLE . " ug," . GROUPS_TABLE . " g
	WHERE ug.user_id = " . $userdata['user_id'] . " AND g.group_id = ug.group_id AND g.group_single_user = 0";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not select canned_custom_count', '', __LINE__, __FILE__, $sql);
}

$groups = array();
while ($row = $db->sql_fetchrow($result))
{
	$groups[] = $row;
}
$db->sql_freeresult($result);
// Canned MOD End

#
#-----[ FIND ]------------------------------------------
#
		if ( $avatar_sql == '' )
		{
			$avatar_sql = ( $mode == 'editprofile' ) ? '' : "'', " . USER_AVATAR_NONE;
		}
#
#-----[ BEFORE, ADD ]------------------------------------------
#
		// Canned MOD Begin
		$canned_id = isset($HTTP_POST_VARS['canned_id']) ? $HTTP_POST_VARS['canned_id'] : 0;
		$canned_title = isset($HTTP_POST_VARS['canned_title']) ? $HTTP_POST_VARS['canned_title'] : "";
		$canned_message = isset($HTTP_POST_VARS['canned_message']) ? $HTTP_POST_VARS['canned_message'] : "";
		$group = isset($HTTP_POST_VARS['group']) ? $HTTP_POST_VARS['group'] : 0;

		for($i=0;$i<count($canned_id);$i++)
		{
			for($j=0;$j<count($canned_id[$i]);$j++)
			{
				if($canned_id[$i][$j] == 0)
				{
					$sql = "INSERT INTO " . CUSTOM_CANNED_TABLE . "
						(group_id,user_id,custom_canned_title,custom_canned_message,sortorder)
						VALUES(" . $group[$i][$j] . "," . $userdata['user_id'] . ",'" . str_replace("\'", "''", $canned_title[$i][$j]) . "','" . str_replace("\'", "''", $canned_message[$i][$j]) . "'," . ($j+1) . ")";
				}
				else
				{
					$sql = "UPDATE " . CUSTOM_CANNED_TABLE . "
						SET custom_canned_title = '" . str_replace("\'", "''", $canned_title[$i][$j]) . "', custom_canned_message = '" . str_replace("\'", "''", $canned_message[$i][$j]) . "'
						WHERE custom_canned_id = " . $canned_id[$i][$j];
				}
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update/insert custom canned message', '', __LINE__, __FILE__, $sql);
				}
			}
		}
		// Canned MOD End
		
#
#-----[ FIND ]------------------------------------------
#
	//
	// Let's do an overall check for settings/versions which would prevent
	// us from doing file uploads....
	//
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Canned MOD Begin
	if(count($groups) > 0)
	{
		$template->assign_block_vars('switch_canned', array());
		$j = 0;
		for($i=0;$i<count($groups);$i++)
		{
			$template->assign_block_vars('switch_canned.canned_group', array(
				'HEADER' => $lang['Custom_Canned_Group'].$groups[$i]['group_name']));

			$canneds = array();
			for($j=0;$j<$groups[$i]['canned_custom_count'];$j++)
			{
				$canneds[] = false;
			}

			$sql = "SELECT custom_canned_id,custom_canned_title,custom_canned_message
				FROM " . CUSTOM_CANNED_TABLE . "
				WHERE group_id = " . $groups[$i]['group_id'] . " AND user_id = " . $user_id . "
				ORDER BY sortorder
				LIMIT 0," . $groups[$i]['canned_custom_count'];
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select canned_custom_count', '', __LINE__, __FILE__, $sql);
			}

			$j = 0;
			while ($row = $db->sql_fetchrow($result))
			{
				$canneds[$j++] = $row;
			}
			$db->sql_freeresult($result);

			$k = 0;
			for($j=0;$j<count($canneds);$j++)
			{
				if($canneds[$j] != false)
				{
					$canned_title = $canneds[$j]['custom_canned_title'];
					$canned_message = $canneds[$j]['custom_canned_message'];
					$s_hidden_fields .= "<input type=\"hidden\" name=\"canned_id[$j][]\" value=\"" . $canneds[$j]['custom_canned_id'] . "\" />";
				}
				else
				{
					$canned_title = "";
					$canned_message = "";
					$s_hidden_fields .= "<input type=\"hidden\" name=\"canned_id[$j][]\" value=\"0\" />";
				}
				$s_hidden_fields .= "<input type=\"hidden\" name=\"group[$j][]\" value=\"" . $groups[$i]['group_id'] . "\" />";
				$template->assign_block_vars('switch_canned.canned_group.canned', array(
					'DESCRIPTION' => $lang['Canned_Message'] . " " . ( $k+1 ),
					'INDEX' => $j,
					'CANNED_TITLE' => $canned_title,
					'CANNED_MESSAGE' => $canned_message));
				$k++;
			}
			$j++;
		}
	}
	// Canned MOD End

#
#-----[ FIND ]------------------------------------------
#
		'L_EMAIL_ADDRESS' => $lang['Email_address'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Canned MOD Begin
		'L_CANNED_MESSAGES' => $lang['Canned_Messages'],
		// Canned MOD End
#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Canned MOD Begin
$lang['Canned_Message'] = 'Canned Message';
$lang['Canned_Messages'] = 'Canned Messages';
$lang['Canned_Footer_Plain'] = "Canned Message Footer (Plain Text)";
$lang['Canned_Footer_Plain_Explain'] = "This text is appended to all canned messages that are set up to not use BBCode.";
$lang['Canned_Footer_BBCode'] = "Canned Message Footer (BBCode)";
$lang['Canned_Footer_BBCode_Explain'] = "This text is appended to all canned messages that are set up to use BBCode.";
$lang['Canned_Custom_Count'] = "Number of custom canned messages available to group";
$lang['Canned_Messages_Administration'] = 'Canned Messages Administration';
$lang['Canned_Messages_Administration_For'] = 'Canned Messages Administration for';
$lang['Canned_Messages_Administration_Explain'] = 'From this panel you can administer all the canned messages for the different existing groups.';
$lang['BBCode'] = 'BBCode';
$lang['Plain'] = 'Plain';
$lang['Title'] = 'Title';
$lang['Up'] = "Up";
$lang['Down'] = "Down";
$lang['Disable_BBCode'] = "Disable BBCode";
$lang['None_After_Post'] = "No action after posting";
$lang['Move_After_Post'] = "Move message after posting";
$lang['Lock_After_Post'] = "Lock message after posting";
$lang['Create_New_Canned_Message'] = "Create New Canned Message";
// Canned MOD End

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Canned MOD Begin
$lang['Canned_Message'] = 'Canned Message';
$lang['Canned_Messages'] = 'Canned Messages';
$lang['Custom_Canned_Group'] = 'Custom Canned Messages for the group: ';
$lang['Choose_Canned'] = 'Choose Canned Message';
$lang['Click_move_message'] = 'Click %sHere%s to move the message';
$lang['Click_lock_message'] = 'Click %sHere%s to lock the message';
$lang['Already_Typed_Message'] = 'You have already typed a message. Are you sure you want to use a canned message?';
// Canned MOD End

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/group_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}" {S_GROUP_OPEN_CHECKED} /> {L_GROUP_OPEN} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_CLOSED_TYPE}" {S_GROUP_CLOSED_CHECKED} />	{L_GROUP_CLOSED} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_HIDDEN_TYPE}" {S_GROUP_HIDDEN_CHECKED} />	{L_GROUP_HIDDEN}</td> 
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#

	<!-- Canned MOD Begin -->
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_CANNED_FOOTER_PLAIN}:</span>
	  <br />
	  <span class="gensmall">{L_CANNED_FOOTER_PLAIN_EXPLAIN}</span></td>
	  <td class="row2" width="62%"> 
		<textarea class="post" name="canned_footer_plain" rows="5" cols="51">{CANNED_FOOTER_PLAIN}</textarea></td> 
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_CANNED_FOOTER_BBCODE}:</span>
	  <br />
	  <span class="gensmall">{L_CANNED_FOOTER_BBCODE_EXPLAIN}</span></td>
	  <td class="row2" width="62%"> 
		<textarea class="post" name="canned_footer_bbcode" rows="5" cols="51">{CANNED_FOOTER_BBCODE}</textarea></td> 
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_CANNED_CUSTOM_COUNT}:</span></td>
	  <td class="row2" width="62%"> 
		<input class="post" type="text" name="canned_custom_count" size="35" maxlength="40" value="{CANNED_CUSTOM_COUNT}" />
	  </td>
	</tr>
	<!-- Canned MOD End -->

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<textarea name="signature"style="width: 300px"  rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<!-- Canned MOD Begin -->
	<!-- BEGIN switch_canned -->
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">{L_CANNED_MESSAGES}</th>
	</tr>
	<!-- BEGIN canned_group -->
	<tr>
	  <td class="row2" colspan="2"><span class="gensmall">{switch_canned.canned_group.HEADER}</span></td>
	</tr>
	<!-- BEGIN canned -->
	<tr>
	  <td class="row1" valign="top"><span class="gen">{switch_canned.canned_group.canned.DESCRIPTION}:</span></td>
	  <td class="row2"><input type="text" name="canned_title[{switch_canned.canned_group.canned.INDEX}][]" value="{switch_canned.canned_group.canned.CANNED_TITLE}"/><br />
			<textarea name="canned_message[{switch_canned.canned_group.canned.INDEX}][]" style="width: 300px" rows="6" cols="30" class="post">{switch_canned.canned_group.canned.CANNED_MESSAGE}</textarea></td>
	</tr>
	<!-- END canned -->
	<!-- END canned_group -->
	<!-- END switch_canned -->
	<!-- Canned MOD End -->
#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
#
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
			  </span></td>
		  </tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
		  <!-- Canned MOD Begin -->
		  <tr>
			<td colspan="9">{S_CANNED_SELECT}</td>
		  </tr>
		  <!-- Canned MOD End -->
#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	  {S_TOPIC_ADMIN}</td>
	<td align="right" valign="top" nowrap="nowrap">{JUMPBOX}<span class="gensmall">{S_AUTH_LIST}</span></td>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	  <!-- Canned MOD Begin -->
	  <form style="margin-top: 0px; margin-bottom: 0px;" action="{U_CANNED_POSTING}" method="post">
	  <input type="hidden" name="mode" value="reply" />
	  <input type="hidden" name="f" value="{FORUM_ID}" />
	  <input type="hidden" name="t" value="{TOPIC_ID}" />
	  {S_CANNED_SELECT}</form>
	  <!-- Canned MOD End -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

