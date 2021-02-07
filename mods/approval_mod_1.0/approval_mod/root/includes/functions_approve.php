<?php
/***************************************************************************
 *                           functions_approve.php
 *                           ---------------------
 *   begin                : Wednesday, Aug 30, 2006
 *   copyright            : (C) 2006-2007 uncle.f
 *   email                : soft@purple-yonder.com
 *
 *   $Id: functions_approve.php, v2.0.1 2007/01/26 15:23:00 uncle_f Exp $
 *
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

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}


/**
 * Checks whether current post needs approval based on multiple factors:
 * User level (admin/mod/user), user/group permissions and forum default settings
 */
function approval_needed(&$mode, &$userdata, &$is_auth, &$post_info)
{
	global $db;

	// check forum setting: "approval for new topics only"
	// if it is ON and reply is being made no approval is needed
	if ( $mode != 'newtopic' && ($post_info['forum_approve'] & APPROVAL_TOPIC_ONLY) == APPROVAL_TOPIC_ONLY)
	{
		return 0;
	}

	// perform the following checks only if the user is logged in
	if ( $userdata['session_logged_in'] )
	{
		// only check user rank if the "Use ranks" option is on for the current forum
		if ( ($post_info['forum_approve'] & APPROVAL_USE_RANKS) == APPROVAL_USE_RANKS )
		{
			// get all ranks that do not need approval
			$sql = "SELECT rank_id, rank_min, rank_special
				FROM " . RANKS_TABLE . "
				WHERE rank_approve = 1
				ORDER BY rank_min DESC";
			if ( !($sql_result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
			}
			$ranks = array();
			while ( $row = $db->sql_fetchrow($sql_result) )
			{
				$ranks[$row['rank_id']] = $row;
			}
			$db->sql_freeresult($sql_result);

			// check if user has special rank which does not require approval
			if ( $userdata['user_rank'] && isset($ranks[$userdata['user_rank']]) )
			{
				return 0;
			}

			// loop through all the ranks and check if the user has enough posts
			// to allow posting without approval
			foreach ($ranks as $rank)
			{
				if ( !$rank['rank_special'] && $userdata['user_posts'] >= $rank['rank_min'] )
				{
					return 0;
				}
			}
		}

		// check user/group permission if it allows posting without approval
		if ( $is_auth['auth_approve'] == APPROVAL_MOD_NO_NEED )
		{
			return 0;
		}

		// check if user/group permission says the user DOES need approval
		if ( $is_auth['auth_approve'] == APPROVAL_MOD_NEEDED )
		{
			// group permission: needs approval
			return 1;
		}
	}

	// if nothing matched so far check if the forum default approval setting is ON
	if ( ($post_info['forum_approve'] & APPROVAL_ON) == APPROVAL_ON )
	{
		return 1;
	}

	// if the forum default setting is OFF no approval is needed
	return 0;
}


/**
 * Approve post. Updates all necessary SQL tables to match new post status
 */
function approve_post(&$post_info)
{
	global $db;

	// make post approved in the posts table
	$sql = "UPDATE " . POSTS_TABLE . " SET post_approve = 0 WHERE post_id = {$post_info['post_id']}";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error while approving post', '', __LINE__, __FILE__, $sql);
	}

	// decrease unapproved-posts-in-the-forum counter
	$forum_sql = "forum_posts_unapproved = forum_posts_unapproved - 1";

	// update last-approved-post-in-the-forum pointer
	if ($post_info['forum_last_post_id'] == $post_info['post_id'])
	{
		$forum_sql .= ", forum_last_post_approved = {$post_info['post_id']}";
	}
	else
	{
		$sql = "SELECT MAX(post_id) AS last_post_approved
			FROM " . POSTS_TABLE . "
			WHERE forum_id = {$post_info['forum_id']}
			AND post_approve = 0";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Error while updating forum approval info', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$forum_sql .= ", forum_last_post_approved = " . ( !empty($row['last_post_approved']) ? $row['last_post_approved'] : "0" );
	}

	// update last-approved-post-in-the-topic pointer
	if ($post_info['topic_last_post_id'] == $post_info['post_id'])
	{
		$topic_sql = "topic_last_post_approved = {$post_info['post_id']}";
	}
	else
	{
		$sql = "SELECT MAX(post_id) AS last_post_approved
			FROM " . POSTS_TABLE . "
			WHERE topic_id = {$post_info['topic_id']}
			AND post_approve = 0";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Error while updating topic approval info', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$topic_sql = "topic_last_post_approved = " . ( !empty($row['last_post_approved']) ? $row['last_post_approved'] : "0" );
	}

	// make topic approved (if that was the first post in the topic) and update unapproved topics counter
	if ($post_info['topic_first_post_id'] == $post_info['post_id'])
	{
		if ($post_info['topic_approve'])
		{
			$topic_sql .= ", topic_approve = 0";
			$forum_sql .= ", forum_topics_unapproved = forum_topics_unapproved - 1";
		}
	}
	// or decrease unapproved replies counter
	else
	{
		$topic_sql .= ", topic_replies_unapproved = topic_replies_unapproved - 1";
	}

	// execute actual SQL queries
	$sql  = "UPDATE " . FORUMS_TABLE . " SET $forum_sql WHERE forum_id = {$post_info['forum_id']}";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error while updating forum approval info', '', __LINE__, __FILE__, $sql);
	}

	$sql  = "UPDATE " . TOPICS_TABLE . " SET $topic_sql WHERE topic_id = {$post_info['topic_id']}";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error while updating topic approval info', '', __LINE__, __FILE__, $sql);
	}

	// increase user's posts counter
	$sql = "UPDATE " . USERS_TABLE . "
		SET user_posts = user_posts + 1
		WHERE user_id = " . $post_info['poster_id'];
	if (!$db->sql_query($sql, END_TRANSACTION))
	{
		message_die(GENERAL_ERROR, "Error while updating user's post counter", '', __LINE__, __FILE__, $sql);
	}
}


function mod_notification(&$post_data, &$post_info, &$post_id, &$subject, &$message, &$userdata, &$username)
{
	global $board_config, $phpbb_root_path, $phpEx, $lang, $db;

	// get the moderators and allowed-to-approve users list
	$sql = "SELECT DISTINCT u.user_id, u.username, u.user_email, user_notify_pm, u.user_lang
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . USERS_TABLE . " u
		WHERE aa.forum_id = {$post_info['forum_id']}
			AND ( aa.auth_mod = 1 OR aa.auth_approve = " . APPROVAL_MOD_CAN_DO . " )
			AND aa.group_id = ug.group_id
			AND ug.user_id = u.user_id
			AND u.user_active <> 0
		ORDER BY u.user_lang";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	$moderators = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$moderators[$row['user_id']] = $row;
	}
	$db->sql_freeresult($result);

	// if the mods list is empty no messaging will be done
	if (empty($moderators))
	{
		return;
	}

	// adjust PHP script timeout setting
	@set_time_limit(60);

	// generate post viewing and post approval URLs
	$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	$script_name_post = ($script_name != '') ? $script_name . '/viewtopic.'.$phpEx : 'viewtopic.'.$phpEx;
	$script_name_approve = ($script_name != '') ? $script_name . '/posting.'.$phpEx : 'posting.'.$phpEx;
	$script_name_msg = ( $script_name != '' ) ? $script_name . '/privmsg.'.$phpEx : 'privmsg.'.$phpEx;
	$server_name = trim($board_config['server_name']);
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_port = ($board_config['server_port'] != 80) ? ':' . trim($board_config['server_port']) . '/' : '/';
	$msg_tpl = ($post_data['needs_approval'] ? 'approve' : 'post') . '_notify';

	// initialize e-mail class
	include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
	$emailer = new emailer($board_config['smtp_delivery']);
	$emailer->from($board_config['board_email']);
	$emailer->replyto($board_config['board_email']);
	$prev_lang = 'undefined';

	// assign common template variables
	$emailer->assign_vars(array(
		'EMAIL_SIG' => $board_config['board_email_sig'] ? strip_tags(str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig'])) : '',
		'SITENAME' => $board_config['sitename'],
		'FORUM_NAME' => $post_info['forum_name'],
		'TOPIC_TITLE' => stripslashes(trim($post_info['topic_title'] ? $post_info['topic_title'] : $subject)),
		'USERNAME' => $userdata['session_logged_in'] ? $userdata['username'] : stripslashes(trim($username)),
		'POST_SUBJECT' => stripslashes(trim($subject)),
		'POST_TEXT' => stripslashes(trim($message)),
		'U_POST' => $server_protocol . $server_name . $server_port . $script_name_post . '?' . POST_POST_URL . "=$post_id#$post_id",
		'U_APPROVE' => $server_protocol . $server_name . $server_port . $script_name_approve . "?mode=approve&" . POST_POST_URL . "=$post_id")
	);

	// loop through each mod's attributes and e-mail them in their language (if their e-mail is not empty)
	foreach ($moderators as $mod)
	{
		if ($mod['user_email'] != '')
		{
			if ($prev_lang != $mod['user_lang'])
			{
				$emailer->use_template($msg_tpl, $mod['user_lang']);
				$prev_lang = $mod['user_lang'];
			}
			$emailer->email_address($mod['user_email']);
			$emailer->send();
		}
	}

	// done with e-maling for now
	$emailer->reset();
}

?>
