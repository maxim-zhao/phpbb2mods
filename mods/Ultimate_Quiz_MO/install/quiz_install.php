<?php
/***************************************************************************
 *                               quiz_install.php
 *                            -------------------
 *   begin                : Sat, October 22, 2005
 *   copyright          : (C) 2005 Battye @ CricketMX.com
 *   email                : cricketmx@hotmail.com
 *
 *   $Id: quiz_install.php, v1 (Oct 2005) battye Exp $
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

$userdata = session_pagestart($user_ip, PAGE_QUIZ);
init_userprefs($userdata);

	$language = $board_config['default_lang'];
	
	if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_quiz.' . $phpEx))
	{
	$language = 'english';
	}
	
	include($phpbb_root_path . 'language/lang_' . $language . '/lang_quiz.' . $phpEx);

$number = 0;

$page_title = $lang['Quiz_install'];
include($phpbb_root_path . "includes/page_header.$phpEx");
$template->set_filenames(array("install" => 'quiz_installation_body.tpl'));

	if(!isset($HTTP_GET_VARS['mode']))
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['Quiz_install_or_update'], "quiz_install.$phpEx?mode=install", "quiz_install.$phpEx?mode=update"));
	}

	if($userdata['session_logged_in'] && $userdata['user_level'] == ADMIN && isset($HTTP_GET_VARS['mode']))
	{
	$sql = array();
	
		if( $HTTP_GET_VARS['mode'] == "install" )
		{
		$sql[] = "CREATE TABLE " . QUIZ_GENERAL_TABLE . " (
		  `quiz_id` int(10) NOT NULL default '0',
		  `quiz_name` varchar(200) NOT NULL default '',
		  `quiz_author` int(10) NOT NULL default '0',
		  `quiz_enabled` int(1) NOT NULL default '0',
		  `quiz_category` int(5) NOT NULL default '0',
		  `quiz_type` varchar(20) NOT NULL default '0',
		  `quiz_plays` int(5) NOT NULL default '0');";
		
		$sql[] = "CREATE TABLE " . QUIZ_CATEGORY_TABLE . " (
		  `category_id` int(5) NOT NULL default '0',
		  `category_password` VARCHAR( 100 ) NOT NULL default '',
		  `category_name` varchar(140) NOT NULL default '',
		  `category_permissions` int(1) NOT NULL default '0',
		  `category_description` varchar(255) NOT NULL default '');";	
		}

	$sql[] = "CREATE TABLE " . QUIZ_STATISTICS_TABLE . " (
		  `stats_id` int(5) NOT NULL default '',
		  `quiz_id` int(10) NOT NULL default '',
		  `user_id` int(10) NOT NULL default '',
		  `stats_correct` INT(5) NOT NULL default '0',
		  `stats_incorrect` INT(5) NOT NULL default '0',
		  `stats_percentage` INT(3) NOT NULL default '0');";			

  $sql[] = "CREATE TABLE " . QUIZ_MULTIPLE_CHOICE_TABLE . " (
  `quiz_id` int(10) NOT NULL default '0',
  `question_id` int(10) NOT NULL default '0',
  `quiz_question` text NOT NULL,
  `quiz_alternates` text NOT NULL,
  `quiz_answer` text NOT NULL);";

	$sql[] = "CREATE TABLE " . QUIZ_TRUE_FALSE_TABLE . " (
  `quiz_id` int(10) NOT NULL default '0',
  `question_id` int(10) NOT NULL default '0',
  `quiz_question` text NOT NULL,
  `quiz_answer` text NOT NULL);";

	$sql[] = "CREATE TABLE " . QUIZ_INPUT_TABLE . " (
  `quiz_id` int(10) NOT NULL default '0',
  `question_id` int(10) NOT NULL default '0',
  `quiz_question` text NOT NULL,
  `quiz_answer` text NOT NULL)";
 
	$sql[] = "ALTER TABLE " . SESSIONS_TABLE . " ADD `session_quiz_categories` VARCHAR( 255 ) NOT NULL;";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_show_answers', '" . ON . "')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Register_Play', '" . ON . "')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Post_Count_Play', '" . ON . "')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Post_Requirement', '1')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Play_Once', '" . ON . "')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Author_Play', '" . ON . "')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Min_Max_Questions', '5,10')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Author_Mod', '" . ON . "')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Banned', '')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Moderators', '')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Stats_Display', '10')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Mod_Submit', '" . ON . "')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Cash_Currency', 'user_points')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Cash_Incorrect', '1')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Cash_Correct', '1')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_Cash_Tax', '2')";
	$sql[] = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('Quiz_CashMOD_On', '" . ON . "')";
		
		for ($i = 0; $i < count($sql); $i++) 
		{
			if(!$result = $db->sql_query($sql[$i]))
			{
				$sql_result = '<font color="red">' . $sql[$i] . '</font><br />';
				$number .= $number + 1;
			}
			
			else
			{
				$sql_result = '<font color="green">' . $sql[$i] . '</font><br />';
			}
			
		$template->assign_block_vars("install_row", array("U_SQL" => $sql_result));
		}
		
		if($HTTP_GET_VARS['mode'] == "update")
		{
			$end_update = '<br /><br />' . sprintf($lang['Quiz_install_continue'], "quiz_updater.$phpEx");
		}
		
		else if($HTTP_GET_VARS['mode'] == "install")
		{
			$end_update = '';
		}
		
			if($number > 0)
			{
				$end = $lang['Quiz_install_failure'];
			}
			
			else
			{
				$end = $lang['Quiz_install_success'] . $end_update;
			}
		
		$template->assign_vars( array(
		"L_INSTALL" => $lang['Quiz_install'],
		"L_INSTALL_MOD" => $lang['Quiz_install_mod'],
		"L_INSTALL_DESCRIPTION" => $lang['Quiz_install_description'],
		"L_INSTALL_END" => $end));
		
		$template->pparse("install");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
	}
	
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Quiz_install_no_permissions']);
	}
?>