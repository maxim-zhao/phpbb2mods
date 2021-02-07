<?php
/***************************************************************************
 *                          functions_last_users.php
 *                            -------------------
 *   copyright            : (C) Anthony Chu
 *   email                : noobarmy@phpbbmodders.com
 *
 *   $Id: index.php,v 1.99.2.7 2006/01/28 11:13:39 acydburn Exp $
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

function get_latest_users ()
{
	global $board_config, $db, $template, $lang;

/* Amount of Users being shown */
	$users_per_row = ( $board_config['show_latest_users_per_row'] > 0 ) ? $board_config['show_latest_users_per_row'] : 1; 
	$rows = ( $board_config['show_latest_users_rows'] > 0 ) ? $board_config['show_latest_users_rows'] : 1;
	$show_users = $users_per_row * $rows;

	$template->set_filenames(array(
					'latest_users' => 'latest_users.tpl'
				));

	$template->assign_var('LOOP_WIDTH', intval( 100 / $users_per_row ) ); /* Width of the Columns */
	$template->assign_var('L_LATEST_USERS_ONLINE', $lang['latest_users_online'] );

	$template->assign_var('MAX_WIDTH', $board_config['avatar_max_width']);
	$template->assign_var('MAX_HEIGHT', $board_config['avatar_max_height']);

	$sql = 'SELECT user_id, username, user_from, user_avatar, user_avatar_type, user_allowavatar
		FROM ' . USERS_TABLE . '
		WHERE user_id <> ' . ANONYMOUS . "
		AND user_active = 1
		ORDER BY user_lastvisit DESC
		LIMIT $show_users";


	if ( !($result = $db->sql_query($sql)) )
	{
		return false;
	}

	$count = 0;

	while ( $row = $db->sql_fetchrow($result) )
	{
		$info[] = $row;
		++$count;
	}

$row_count = 0;

	for ( $i = 0; $i < $count; ++$i )
	{

		$row = $info[$i];


		if ( ($i % $users_per_row) == 0 )
		{

			$template->assign_block_vars('row_loop', array());

			$col_span = array();

			if ( (($row_count+1) * $users_per_row) < $count )
			{
				/**
				* This isn't the last row. which is the only row which needs the extra column so we can do nowt.
				*/
			}
			else
			{
				/** 
				* This therefore is the last row. So we need to calculate how many it falls short
				*/
				$span = $count % $users_per_row;
				$col_span['COLUMN_SPAN'] = $span;
				$template->assign_block_vars('row_loop.extra_col', $col_span);
			}

															
			$row_count++;
		}

		if ( $row['user_avatar_type'] && $row['user_allowavatar'] )
		{
			switch( $row['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$avatar = ( $board_config['allow_avatar_upload'] ) ? $board_config['avatar_path'] . '/' . $row['user_avatar'] : '';
					break;
				case USER_AVATAR_REMOTE:
					$avatar = ( $board_config['allow_avatar_remote'] ) ? $row['user_avatar'] : '';
					break;
				case USER_AVATAR_GALLERY:
					$avatar = ( $board_config['allow_avatar_local'] ) ? $board_config['avatar_gallery_path'] . '/' . $row['user_avatar']  : '';
					break;
			}
		}

		$template->assign_block_vars('row_loop.users_loop', array(
								'LINK' => append_sid('profile. ' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $row['user_id'], 1),
								'AVATAR' => ( $avatar != '' ) ? $avatar : $board_config['default_avatar'], /* If you wanna add a default image for when a user doesn't have an avatar put it in the '' :) */
								'USERNAME' => $row['username'],
								'LOCATION' => ( $row['user_from'] != '' ) ? '(' . $row['user_from'] . ')' : '')
								);

		$avatar = '';
	}

	$cols = ( ($count % $users_per_row) == 0 ) ? $count : ($count % $users_per_row) + $count;
	$template->assign_var('COLS', intval( $cols ) ); /* Amount of Columns */

	$template->assign_var_from_handle('LATEST_USERS', 'latest_users'); /* Just put it into the root template */

	return true; /* Finito */

}

?>