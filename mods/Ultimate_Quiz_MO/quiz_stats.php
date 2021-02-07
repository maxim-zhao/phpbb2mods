<?php
/***************************************************************************
 *                               quiz_stats.php
 *                            -------------------
 *   begin                : Fri, Nov 18, 2005
 *   copyright          : (C) 2005 Battye @ CricketMX.com
 *   email                : cricketmx@hotmail.com
 *
 *   $Id: quiz_stats.php, v1 (Nov 2005) battye Exp $
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
include($phpbb_root_path . 'includes/functions_quiz.'.$phpEx);

	$language = $board_config['default_lang'];
	
	if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_quiz.' . $phpEx))
	{
		$language = 'english';
	}
	
	include($phpbb_root_path . 'language/lang_' . $language . '/lang_quiz.' . $phpEx);
	
	// Statistical functions
	function qs_convert_quiz($quiz_id)
	{
	global $db;
	
	$sql = "SELECT quiz_name FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_id = " . intval($quiz_id);
		
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, '', 'Could not obtain quiz name', __LINE__, __FILE__, $sql);
		}
	
		$row = $db->sql_fetchrow($result);
		
	return $row['quiz_name'];	
	}

	function qs_convert_userid($user_id)
	{
	global $db, $board_config;
	
	$sql = "SELECT username FROM " . USERS_TABLE . " WHERE user_id = " . intval($user_id);
		
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, '', 'Could not obtain username', __LINE__, __FILE__, $sql);
		}
	
		$row = $db->sql_fetchrow($result);
		
	return $row['username'];	
	}
	
$userdata = session_pagestart($user_ip, PAGE_QUIZ);
init_userprefs($userdata);

$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : '';

	if( $mode == '' || isset($HTTP_GET_VARS[POST_QUIZ_URL]) )
	{
	$page_title = $lang['Quiz_stats'];
	include($phpbb_root_path . "includes/page_header.$phpEx");
	$template->set_filenames(array("quiz_stats" => 'quiz_statistics_body.tpl'));

		$template->assign_vars( array(
		"L_MP_QUIZ" => $lang['Quiz_stats_most_plays'],
		"L_MP_PLAYS" => $lang['Quiz_stats_plays'],
		
		"L_QUIZ" => $lang['Quiz'],
		"L_CORRECT" => $lang['Quiz_stats_correct'],
		"L_INCORRECT" => $lang['Quiz_stats_incorrect'],
		"L_PERCENTAGE" => $lang['Quiz_stats_percentage'],
		"L_AUTHOR" => $lang['Quiz_stats_author'],
		"L_ALL_TIME_HI" => $lang['Quiz_stats_all_time_highest'],
		"L_STATS" => $lang['Quiz_stats']));

		if( isset($HTTP_GET_VARS[POST_QUIZ_URL]) )
		{
		$template->set_filenames(array("quiz_i_stats" => 'quiz_statistics_particular_body.tpl'));
		$quiz_statistics_name = qs_convert_quiz(  $HTTP_GET_VARS[POST_QUIZ_URL]  );
		
		$template->assign_vars( array(
		"U_I_QUIZ" => sprintf($lang['Quiz_stats_individual_high'], qs_convert_quiz($HTTP_GET_VARS[POST_QUIZ_URL]))));
		
			$hi_sql = "SELECT * FROM " . QUIZ_STATISTICS_TABLE . " WHERE quiz_id = " . intval($HTTP_GET_VARS[POST_QUIZ_URL]) . " ORDER BY stats_correct DESC LIMIT " .  $board_config['Quiz_Stats_Display'];
		
			if(!$hi_result = $db->sql_query($hi_sql))
			{
				message_die(GENERAL_ERROR, '', 'Could not obtain highest scores', __LINE__, __FILE__, $hi_sql);
			}
			
			if( $db->sql_numrows($hi_result) == 0 )
			{
				$template->assign_block_vars("qs_no_stats_row", array(
				"L_NOSTATS" => $lang['Quiz_stats_none']));
			}
			
			while( $hi_row = $db->sql_fetchrow($hi_result) )
			{
				$template->assign_block_vars("qs_i_highestscores_row", array(
				"U_USER" => "<a href='" . append_sid("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $hi_row['user_id'] . "") . "'>" . qs_convert_userid($hi_row['user_id']) . "</a>",
				"U_CORRECT" => intval($hi_row['stats_correct']),
				"U_INCORRECT" => intval($hi_row['stats_incorrect']),
				"U_PERCENTAGE" => intval($hi_row['stats_percentage']) . '%'));
			}
		
		$template->pparse("quiz_i_stats");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
		
	$template->set_filenames(array("quiz_stats" => 'quiz_statistics_body.tpl'));
		
   $hi_sql = "SELECT * FROM " . QUIZ_STATISTICS_TABLE . " ORDER BY stats_correct DESC LIMIT " .  $board_config['Quiz_Stats_Display'];
	
	if(!$hi_result = $db->sql_query($hi_sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain highest scores', __LINE__, __FILE__, $hi_sql);
	}
		
		while( $hi_row = $db->sql_fetchrow($hi_result) )
		{
			$template->assign_block_vars("qshighestscores_row", array(
			"U_QUIZ" => "<a href='" . append_sid("quiz.$phpEx?" . POST_QUIZ_URL . "=" . $hi_row['quiz_id'] . "") . "'>" . qs_convert_quiz($hi_row['quiz_id']) . "</a>",
			"U_USER" => "<a href='" . append_sid("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $hi_row['user_id'] . "") . "'>" . qs_convert_userid($hi_row['user_id']) . "</a>",
			"U_CORRECT" => intval($hi_row['stats_correct']),
			"U_INCORRECT" => intval($hi_row['stats_incorrect']),
			"U_PERCENTAGE" => intval($hi_row['stats_percentage']) . '%'));
		}
		
	$plays_sql = "SELECT * FROM " . QUIZ_GENERAL_TABLE . " ORDER BY quiz_plays DESC LIMIT " .  $board_config['Quiz_Stats_Display'];
		
	if(!$plays_result = $db->sql_query($plays_sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain most played quizzes', __LINE__, __FILE__, $plays_sql);
	}
		
		while( $plays_row = $db->sql_fetchrow($plays_result) )
		{
			$template->assign_block_vars("qsmostplays_row", array(
			"U_QUIZ" => "<a href='" . append_sid("quiz.$phpEx?" . POST_QUIZ_URL . "=" . $plays_row['quiz_id'] . "") . "'>" . qs_convert_quiz($plays_row['quiz_id']) . "</a>",
			"U_PLAYS" => intval($plays_row['quiz_plays'])));
		}
	
			
	$template->pparse("quiz_stats");
	include($phpbb_root_path . "includes/page_tail.$phpEx");
	}
?>