<?php
/***************************************************************************
 *					bin.php
 *					-------
 *	begin				: Friday, Jun 11, 2004
 *	copyright			: (C) 2004 Kooky
 *	email				: kooky@altern.org
 *
 *   $Id: bin.php,v 1.01 2004/09/08 02:39:04 kooky Exp $
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
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

//
// Obtain initial var settings
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = (isset($HTTP_POST_VARS[POST_FORUM_URL])) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]);
}
else
{
	$forum_id = '';
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]) || isset($HTTP_POST_VARS[POST_POST_URL]) )
{
	$post_id = (isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]);
}
else
{
	$post_id = '';
}

if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) || isset($HTTP_POST_VARS[POST_TOPIC_URL]) )
{
	$topic_id = (isset($HTTP_POST_VARS[POST_TOPIC_URL])) ? intval($HTTP_POST_VARS[POST_TOPIC_URL]) : intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else
{
	$topic_id = '';
}

$confirm = TRUE;

//
// Continue var definitions
//
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

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
// Obtain relevant data
//
if ( !empty($topic_id) )
{
	$sql = "SELECT f.forum_id, f.forum_name, f.forum_topics
		FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f
		WHERE t.topic_id = " . $topic_id . "
			AND f.forum_id = t.forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
	}
	$topic_row = $db->sql_fetchrow($result);

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_id = $topic_row['forum_id'];
	$forum_name = $topic_row['forum_name'];
}
else if ( !empty($forum_id) )
{
	$sql = "SELECT forum_name, forum_topics
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = " . $forum_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Forum_not_exist');
	}
	$topic_row = $db->sql_fetchrow($result);

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_name = $topic_row['forum_name'];
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
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

if ( !$is_auth['auth_mod'] )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
}
//
// End Auth Check
//

$page_title = $lang['Mod_CP'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

if ( $confirm )
{
	if ( ( $board_config['bin_forum'] == 0 ) || ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) ) )
	{
		$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
		$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		$message = $message . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Bin_disabled'] . '<br /><br />' . $message);
	}
	else
	{
		// Define bin forum
		$new_forum_id = intval($board_config['bin_forum']);
		$old_forum_id = $forum_id;

		if ( $new_forum_id != $old_forum_id )
		{
			$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

			$topic_list = '';
			for($i = 0; $i < count($topics); $i++)
			{
				$topic_list .= ( ( $topic_list != '' ) ? ', ' : '' ) . intval($topics[$i]);
			}

			$sql = "SELECT * 
				FROM " . TOPICS_TABLE . " 
				WHERE topic_id IN ($topic_list)
					AND forum_id = $old_forum_id
					AND topic_status <> " . TOPIC_MOVED;
			if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from topic table', '', __LINE__, __FILE__, $sql);
			}

			$row = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);

			for($i = 0; $i < count($row); $i++)
			{
				$topic_id = $row[$i]['topic_id'];

				if ( isset($HTTP_POST_VARS['move_leave_shadow']) )
				{
					// Insert topic in the old forum that indicates that the forum has moved.
					$sql = "INSERT INTO " . TOPICS_TABLE . " (forum_id, topic_title, topic_poster, topic_time, topic_status, topic_type, topic_vote, topic_views, topic_replies, topic_first_post_id, topic_last_post_id, topic_moved_id)
						VALUES ($old_forum_id, '" . addslashes(str_replace("\'", "''", $row[$i]['topic_title'])) . "', '" . str_replace("\'", "''", $row[$i]['topic_poster']) . "', " . $row[$i]['topic_time'] . ", " . TOPIC_MOVED . ", " . POST_NORMAL . ", " . $row[$i]['topic_vote'] . ", " . $row[$i]['topic_views'] . ", " . $row[$i]['topic_replies'] . ", " . $row[$i]['topic_first_post_id'] . ", " . $row[$i]['topic_last_post_id'] . ", $topic_id)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
					}
				}

				$sql = "UPDATE " . TOPICS_TABLE . " 
					SET forum_id = $new_forum_id  
					WHERE topic_id = $topic_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update old topic', '', __LINE__, __FILE__, $sql);
				}

				$sql = "UPDATE " . POSTS_TABLE . " 
					SET forum_id = $new_forum_id 
					WHERE topic_id = $topic_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
				}
			}

			// Sync the forum indexes
			sync('forum', $new_forum_id);
			sync('forum', $old_forum_id);

			$message = $lang['Topics_Moved_bin'];
		}
		else
		{
			$message = $lang['No_Topics_Moved'];
		}

		$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
		$message .= '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');

		$message = $message . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$old_forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $message);
	}
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>