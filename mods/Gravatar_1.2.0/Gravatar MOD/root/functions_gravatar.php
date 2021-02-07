<?php
/***************************************************************************
 *                           functions_gravatar.php
 *                            -------------------
 * Begin		: January 17, 2005
 * Email		: ycl6@users.sourceforge.net (http://macphpbbmod.sourceforge.net/)
 * Ver.			: 1.0.0
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

function gravatar_output($user_avatar)
{
	global $board_config, $images;

	$script_path = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	$server_name = trim($board_config['server_name']);
	$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
	$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
	$server_url = $server_protocol . $server_name . $server_port . $script_path;
	$size = ( $board_config['avatar_max_width'] > $board_config['avatar_max_height'] ) ? $board_config['avatar_max_height'] : $board_config['avatar_max_width'];
	switch( $board_config['allow_gravatar_rating'] )
	{
		case GRAVATAR_G:
			$rating = 'G';
			break;
		case GRAVATAR_PG:
			$rating = 'PG';
			break;
		case GRAVATAR_R:
			$rating = 'R';
			break;
		case GRAVATAR_X:
			$rating = 'X';
			break;
		default:
			$rating = 'G';
			break;
	}
	$avatar = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($user_avatar);
	$avatar .= "&rating=" . $rating . "&size=" . $size . "&default=" . $server_url . "/". $images['icon_gravatar_default'];
	$avatar = '<img src="' . $avatar . '" alt="" class="gravatar" />';

	return $avatar;
}

function user_gravatar($mode, &$error, &$error_msg, $user_gravatar_email)
{
	global $db, $lang;

	if ($user_gravatar_email != '')
	{
		if (preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $user_gravatar_email))
		{
			$sql = "SELECT ban_email
				FROM " . BANLIST_TABLE;
			if ($result = $db->sql_query($sql))
			{
				if ($row = $db->sql_fetchrow($result))
				{
					do
					{
						$match_email = str_replace('*', '.*?', $row['ban_email']);
						if (preg_match('/^' . $match_email . '$/is', $user_gravatar_email))
						{
							$db->sql_freeresult($result);

							$error = true;
							$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Email_banned'] : $lang['Email_banned'];
							return;
						}
					}
					while($row = $db->sql_fetchrow($result));
				}
			}
			$db->sql_freeresult($result);

			return ( $mode == 'editprofile' ) ? ", user_avatar = '" . str_replace("\'", "''", $user_gravatar_email) . "', user_avatar_type = " . USER_GRAVATAR : '';
		}
	}

	$error = true;
	$error_msg = ( !empty($error_msg) ) ? $error_msg . '<br />' . $lang['Email_invalid'] : $lang['Email_invalid'];
	return;
}
?>