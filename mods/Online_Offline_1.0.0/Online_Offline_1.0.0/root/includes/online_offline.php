<?php
/***************************************************************************
 *                            online_offline.php
 *                            -------------------
 *   begin                : Sunday, January 7, 2007
 *   copyright            : (C) 2006 EXreaction, Lithium Studios
 *   email                : exreaction@lithiumstudios.org
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

/*
* Get all the users that are online and return an array with the users' id's
*/
function get_online_users()
{
	global $userdata, $db;

	$online_array = array();

	if ($userdata['user_level'] != ADMIN)
	{
		$sql = 'SELECT s.session_user_id  FROM ' . USERS_TABLE. ' u, ' . SESSIONS_TABLE . ' s
			WHERE s.session_user_id = u.user_id
				AND s.session_logged_in = 1
				AND u.user_allow_viewonline = 1
				AND s.session_time > ' . (time() - 300);
		$result = $db->sql_query($sql);

		while($row = $db->sql_fetchrow($result))
		{
			$online_array[] = $row['session_user_id'];
		}
	}
	else
	{
		$sql = 'SELECT session_user_id  FROM ' . SESSIONS_TABLE . '
			WHERE session_logged_in = 1
				AND session_time > ' . (time() - 300);
		$result = $db->sql_query($sql);

		while($row = $db->sql_fetchrow($result))
		{
			$online_array[] = $row['session_user_id'];
		}
	}

	return $online_array;
}

/*
* To display the actual image.
*    In comes the user_id, online_array
*    Returns the image location.
*/
function display_online_offline($user_id, &$online_array)
{
	global $userdata, $phpbb_root_path, $theme, $board_config;

	if ($userdata['user_id'] == ANONYMOUS)
	{
		$style_path = $phpbb_root_path . 'templates/' . $theme['template_name'] . '/images/lang_' . $board_config['default_lang'] . '/';
	}
	else
	{
		$style_path = $phpbb_root_path . 'templates/' . $theme['template_name'] . '/images/lang_' . $userdata['user_lang'] . '/';
	}

	if (in_array($user_id, $online_array))
	{
		return '<img src="' . $style_path . 'icon_online.gif"> ';
	}
	else
	{
		return '<img src="' . $style_path . 'icon_offline.gif"> ';
	}
}

/*
* Debugging/testing function to check and make sure all users are being gotten from the database properly
*/
function echo_online_users(&$online_array)
{
	foreach($online_array as $i)
	{
		echo $i . '<br/>';
	}
}
?>