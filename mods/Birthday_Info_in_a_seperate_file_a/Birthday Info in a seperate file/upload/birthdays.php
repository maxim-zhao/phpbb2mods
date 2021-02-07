<?php
/***************************************************************************
 *                                birthdays.php
 *                            -------------------
 *   begin                : Monday 1 May 2006
 *   copyright            : (C) 2006 MarkTheDaemon
 *   email                : webmaster@markthedaemon.co.uk
 *   website		: http://www.markthedaemon.co.uk
 *
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

/***************************************************************************
 *
 *   This code in this file is based on the original code added to the phpBB2 index.php
 *   
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//
	//start pulling the data for the birthday MOD	
	$sql = "SELECT user_id, username, user_birthday, user_level 
		FROM " . USERS_TABLE . " 
		WHERE user_birthday >= " . gmdate('md0000',time() + (3600 * $board_config['board_timezone'])) . " 
			AND user_birthday <= " . gmdate('md9999',time() + (3600 * $board_config['board_timezone']));
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query members birthday information', '', __LINE__, __FILE__, $sql);
	}

	$user_birthdays = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$bday_year = $row['user_birthday'] % 10000;
		$age = ( $bday_year ) ? ' ('.(gmdate('Y')-$bday_year).')' : '';
		$color = '';
		if ( $row['user_level'] == ADMIN )
		{
			$color = ' style="color:#' . $theme['fontcolor3'] . '"';
		}
		else if ( $row['user_level'] == MOD )
		{
			$color = ' style="color:#' . $theme['fontcolor2'] . '"';
		}
		$user_birthdays[] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $color . '>' . $row['username'] . '</a>' . $age;
	}
	$db->sql_freeresult($result);

	$birthdays = (!empty($user_birthdays)) ?
		sprintf($lang['Congratulations'],implode(', ',$user_birthdays)) :
		$lang['No_birthdays'];

	if ( $board_config['bday_lookahead'] != -1 )
	{
		$start = gmdate('md9999',strtotime('+'.$board_config['bday_lookahead'].' day') + (3600 * $board_config['board_timezone']));
		$end = gmdate('md0000',strtotime('+1 day') + (3600 * $board_config['board_timezone']));
		$operator = ($start > $end) ? 'AND' : 'OR';
		$sql = "SELECT user_id, username, user_birthday, user_level 
			FROM " . USERS_TABLE . " 
			WHERE (user_birthday <= $start 
				$operator user_birthday >= $end)
				AND user_birthday <> 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query upcoming birthday information', '', __LINE__, __FILE__, $sql);
		}
		$upcoming_birthdays = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$bday_year = $row['user_birthday'] % 10000;
			$age = ( $bday_year ) ? ' ('.(gmdate('Y')-$bday_year).')' : '';
			$color = '';
			if ( $row['user_level'] == ADMIN )
			{
				$color = ' style="color:#' . $theme['fontcolor3'] . '"';
			}
			else if ( $row['user_level'] == MOD )
			{
				$color = ' style="color:#' . $theme['fontcolor2'] . '"';
			}
			$upcoming_birthdays[] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $color . '>' . $row['username'] . '</a>' . $age;
		}

		$upcoming = (!empty($upcoming_birthdays)) ?
			sprintf($lang['Upcoming_birthdays'],$board_config['bday_lookahead'],implode(', ',$upcoming_birthdays)) :
			sprintf($lang['No_upcoming'],$board_config['bday_lookahead']);
	}

	if ( !empty($user_birthdays) || !empty($upcoming_birthdays) || $board_config['bday_show'] )
	{
		$template->assign_block_vars('birthdays',array());
		if ( !empty($upcoming_birthdays) || $board_config['bday_show'] )
		{
			$template->assign_block_vars('birthdays.upcoming',array());
		}
	}
	

	//
	// Start output of page
	//
	define('SHOW_ONLINE', true);
	$page_title = $lang['Birthdays'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'birthday_body.tpl')
	);

	$template->assign_vars(array(
		'BIRTHDAYS' => $birthdays,
		'UPCOMING' => $upcoming,
		
		'L_TODAYS_BIRTHDAYS' => $lang['Todays_Birthdays'],
		'L_VIEW_BIRTHDAYS' => $lang['View_Birthdays'])

	);

	
	



//
// Generate the page
//
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>