<?php
/***************************************************************************
 *                              delete_user.php
 *                            -------------------
 *	By			: Mac (Y.C. LIN)
 *	Email		: ycl6@users.sourceforge.net (http://macphpbbmod.sourceforge.net/)
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
 
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Obtain initial var settings
//
if ( isset($HTTP_GET_VARS[POST_USERS_URL]) || isset($HTTP_POST_VARS[POST_USERS_URL]) )
{
	$user_id = (isset($HTTP_POST_VARS[POST_USERS_URL])) ? intval($HTTP_POST_VARS[POST_USERS_URL]) : intval($HTTP_GET_VARS[POST_USERS_URL]);
}
else
{
	message_die(GENERAL_ERROR, 'No_such_user');
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]) || isset($HTTP_POST_VARS[POST_POST_URL]) )
{
	$post_id = (isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]);
}
else
{
	$post_id = '';
}

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

// session id check
if ($sid == '' || $sid != $userdata['session_id'])
{
	message_die(GENERAL_ERROR, 'Invalid_session');
}

//
// Start auth check
//
$is_auth = auth(AUTH_ALL, $forum_id, $userdata);

if ( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'Not_Authorised');
}
//
// End Auth Check
//

if ( isset($HTTP_POST_VARS['file']) || isset($HTTP_GET_VARS['file']) )
{
	$filename = ( isset($HTTP_POST_VARS['file']) ) ? $HTTP_POST_VARS['file'] : $HTTP_GET_VARS['file'];
	$filename = htmlspecialchars($filename);
}
else
{
	$filename = '';
}

$filename = ( in_array($filename, array('viewtopic', 'memberlist', 'profile')) ) ? $filename : 'index';

if ($filename == 'viewtopic' && empty($post_id))
{
	message_die(GENERAL_ERROR, 'No_post_id');
}

$confirm = ( isset($HTTP_POST_VARS['confirm']) ) ? TRUE : 0;
$cancel = ( isset($HTTP_POST_VARS['cancel']) ) ? TRUE : 0;

//
// Cancel 
//
if ( $cancel )
{
	switch( $filename )
	{
		case "viewtopic":
			redirect(append_sid("$filename.$phpEx?" . POST_POST_URL . "=$post_id", true));
			break;
		case "index":
		case "memberlist":
			redirect(append_sid("$filename.$phpEx", true));
			break;
		case "profile":
			redirect(append_sid("$filename.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=$user_id", true));
			break;
	}
}

//
// Start Delete (code borrowed from admin_users.php)
//
if( $userdata['user_id'] != $user_id )
{
	if (!($this_userdata = get_userdata($user_id)))
	{
		message_die(GENERAL_MESSAGE, 'No_user_id_specified');
	}

	if( $confirm )
	{
		$sql = "SELECT g.group_id 
			FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g  
			WHERE ug.user_id = $user_id 
				AND g.group_id = ug.group_id 
				AND g.group_single_user = 1";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain group information for this user', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);

		$sql = "UPDATE " . POSTS_TABLE . "
			SET poster_id = " . DELETED . ", post_username = '" . str_replace("\\'", "''", addslashes($this_userdata['username'])) . "' 
			WHERE poster_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update posts for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . TOPICS_TABLE . "
			SET topic_poster = " . DELETED . " 
			WHERE topic_poster = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . VOTE_USERS_TABLE . "
			SET vote_user_id = " . DELETED . "
			WHERE vote_user_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update votes for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "SELECT group_id
			FROM " . GROUPS_TABLE . "
			WHERE group_moderator = $user_id";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select groups where user was moderator', '', __LINE__, __FILE__, $sql);
		}

		while ( $row_group = $db->sql_fetchrow($result) )
		{
			$group_moderator[] = $row_group['group_id'];
		}

		if ( count($group_moderator) )
		{
			$update_moderator_id = implode(', ', $group_moderator);

			$sql = "UPDATE " . GROUPS_TABLE . "
				SET group_moderator = " . $userdata['user_id'] . "
				WHERE group_moderator IN ($update_moderator_id)";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update group moderators', '', __LINE__, __FILE__, $sql);
			}
		}

		$sql = "DELETE FROM " . USERS_TABLE . "
			WHERE user_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . USER_GROUP_TABLE . "
			WHERE user_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user from user_group table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . GROUPS_TABLE . "
			WHERE group_id = " . $row['group_id'];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
			WHERE group_id = " . $row['group_id'];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
			WHERE user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user from topic watch table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . BANLIST_TABLE . "
			WHERE ban_userid = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user from banlist table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . SESSIONS_TABLE . "
			WHERE session_user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete sessions for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . SESSIONS_KEYS_TABLE . "
			WHERE user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete auto-login keys for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "SELECT privmsgs_id
			FROM " . PRIVMSGS_TABLE . "
			WHERE privmsgs_from_userid = $user_id 
				OR privmsgs_to_userid = $user_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select all users private messages', '', __LINE__, __FILE__, $sql);
		}

		// This little bit of code directly from the private messaging section.
		while ( $row_privmsgs = $db->sql_fetchrow($result) )
		{
			$mark_list[] = $row_privmsgs['privmsgs_id'];
		}

		if ( count($mark_list) )
		{
			$delete_sql_id = implode(', ', $mark_list);

			$delete_text_sql = "DELETE FROM " . PRIVMSGS_TEXT_TABLE . "
				WHERE privmsgs_text_id IN ($delete_sql_id)";
			$delete_sql = "DELETE FROM " . PRIVMSGS_TABLE . "
				WHERE privmsgs_id IN ($delete_sql_id)";

			if ( !$db->sql_query($delete_sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete private message info', '', __LINE__, __FILE__, $delete_sql);
			}

			if ( !$db->sql_query($delete_text_sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete private message text', '', __LINE__, __FILE__, $delete_text_sql);
			}
		}

		$message = $lang['User_deleted'];

		switch( $filename )
		{
			case "viewtopic":
				$message .= '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("$filename.$phpEx?" . POST_POST_URL . "=$post_id") . '">', '</a>');
				break;
			case "memberlist":
				$message .= '<br /><br />' . sprintf($lang['Click_return_memberlist'], '<a href="' . append_sid("$filename.$phpEx") . '">', '</a>');
				break;
		}

		$message .= '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}
	elseif( !$confirm )
	{
		// Present the confirmation screen to the user
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);
		$template->set_filenames(array(
			'confirm_body' => 'confirm_body.tpl')
		);

		$hidden_fields = '<input type="hidden" name="' . POST_USERS_URL . '" value="' . $user_id . '" /><input type="hidden" name="' . POST_POST_URL . '" value="' . $post_id . '" /><input type="hidden" name="file" value="' . $filename . '" /><input type="hidden" name="sid" value="' . $sid . '" />';

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Confirm'],
			'MESSAGE_TEXT' => sprintf($lang['Confirm_delete_user'], $this_userdata['username']),

			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],

			'S_CONFIRM_ACTION' => append_sid("delete_user.$phpEx"),
			'S_HIDDEN_FIELDS' => $hidden_fields)
		);

		$template->pparse('confirm_body');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}
else
{
	message_die(GENERAL_ERROR, 'Cannot_delete_self');
}

?>