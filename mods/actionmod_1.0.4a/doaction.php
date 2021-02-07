<?php
/***************************************************************************
 *                               doaction.php
 *                            -------------------
 *   begin                : Monday, April 10, 2006
 *   copyright            : (C) 2006 Daniel Vandersluis
 *   email                : daniel@codexed.com
 *	 version			  : 1.0.3
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

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

//
// Multiple empty function: returns true if any of the arguments is empty(), otherwise false
//
function m_empty()
{
	$args = func_get_args();
	foreach ($args as $a)
	{
		if (empty($a))
		{
			return true;
		}
	}
	return false;
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_POSTING);
init_userprefs($userdata);
//
// End session management
//

$action_id = intval($HTTP_GET_VARS[POST_ACTION_URL]);
$post_id = intval($HTTP_GET_VARS[POST_POST_URL]);
$user_id = $userdata['user_id'];

if ($user_id == -1) // Disallow guest actions
{
	redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id"));
	die();
}
$sql = "SELECT u.user_id, p.post_id, a.action_id
	FROM " . USERS_TABLE . " AS u, " . POSTS_TABLE . " AS p, " . ACTIONS_TABLE . " AS a
	WHERE u.user_id = $user_id
		AND p.post_id = $post_id
		AND a.action_id = $action_id";

if (!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not get database data!", "", __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
if (!m_empty($row['user_id'], $row['post_id'], $row['action_id']))
{
	$sql = "SELECT *
		FROM " . ACTIONS_PERFORMED_TABLE . "
		WHERE action_id = $action_id
			AND post_id = $post_id
			AND performer_id = $user_id";
	
	if (!$result = $db->sql_query($sql))
	{
		message_die(CRITICAL_ERROR, "Could not get performed actions data!", "", __LINE__, __FILE__, $sql);
	}
	elseif ($db->sql_numrows($result) == 0) 
	{
		// Since there is a UNIQUE key contraint on action_id/post_id/performer_id, we only continue if a record
		// with these three items does not already exist.

		$current_time = time();

		$sql = "INSERT INTO " . ACTIONS_PERFORMED_TABLE . " (action_id, performer_id, post_id, action_time) 
			VALUES ($action_id, $user_id, $post_id, $current_time)";

		if (!$result = $db->sql_query($sql))
		{
			message_die(CRITICAL_ERROR, "Could not insert into performed actions table!", "", __LINE__, __FILE__, $sql);
		}
	}
}
redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id"));
?>
