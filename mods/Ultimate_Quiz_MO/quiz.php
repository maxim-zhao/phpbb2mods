<?php
/***************************************************************************
 *                               quiz.php
 *                            -------------------
 *   begin                : Sat, May 21, 2005
 *   copyright          : (C) 2005 Battye @ CricketMX.com
 *   email                : cricketmx@hotmail.com
 *
 *   $Id: quiz.php, v2 (May 2005) battye Exp $
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

$userdata = session_pagestart($user_ip, PAGE_QUIZ);
init_userprefs($userdata);

// Just to help users know what version of UQM they are using, I will add it here, it will be changed in every version mind you (it is commented out purposely)
// $quiz_version = '1.2.0';

	// Define mode and type
	$mode = htmlspecialchars($HTTP_GET_VARS['mode']);
	$type = htmlspecialchars($HTTP_POST_VARS['type']);
	
		if($type == "multiple_choice")
		{
			$quiz_type = "multiple_choice"; // Default for 1.0.x
		}
		
		if($type == "true_false")
		{
			$quiz_type = "true_false"; // New in 1.1.x
		}
		
		if($type == "input_answer")
		{
			$quiz_type = "input_answer"; // Default for Pre 0.0.x, reapplied in 1.1.x
		}

	if( isset($HTTP_GET_VARS[POST_CAT_URL]) ) // Let's list the quizzes in a certain category, and all that jazz
	{
		$category_id = intval($HTTP_GET_VARS[POST_CAT_URL]);
	
		$password_sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE . " WHERE category_id = $category_id";
		
			if(!$password_result = $db->sql_query($password_sql))
			{
			message_die(GENERAL_ERROR, 'Could not obtain category password', '', __LINE__, __FILE__, $password_sql);
			}
			
			$password_row = $db->sql_fetchrow($password_result);
			
			if( !$userdata['session_logged_in'] )
			{
				if( $password_row['category_permissions'] == ON || $password_row['category_permissions'] == OFF )
				{
				message_die(GENERAL_ERROR, $lang['Quiz_registered_category_permissions_no_access']);
				}
			}
		
		if($password_row['category_password'] !== 'd41d8cd98f00b204e9800998ecf8427e' && quiz_check_category_password($category_id) != ON)
		{
			if( isset($HTTP_POST_VARS['password']) )
			{
				if( md5($HTTP_POST_VARS['password']) != quiz_category_password($category_id) )
				{
					message_die(GENERAL_ERROR, $lang['Quiz_category_password_wrong']);
				}
				
				else
				{
				$password_data = $userdata['session_quiz_categories'] . $category_id . ',';
				$update_pw_data = "UPDATE " . SESSIONS_TABLE . " SET session_quiz_categories = '" . $password_data . "' WHERE session_id = '" . $userdata['session_id'] . "'";
				
					if(!$db->sql_query($update_pw_data))
					{
						message_die(GENERAL_ERROR, '', 'Could not update password list', __LINE__, __FILE__, $update_pw_data);
					}
					
				redirect( append_sid("quiz.$phpEx?" . POST_CAT_URL . "=$category_id", true) );
				}
			}
			
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("quiz_pw" => 'quiz_category_password_body.tpl'));
		
			$template->assign_vars( array(
			"F_FORM" => append_sid("quiz.$phpEx?" . POST_CAT_URL . "=$category_id"),
			
			"L_SUBMIT" => $lang['Submit'],
			"L_ENTER_PASSWORD" => $lang['Quiz_password_protect_information'],
			"L_PASSWORD" => $lang['Quiz_password_protect']));
			
		$template->pparse("quiz_pw");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	
	$page_title = $lang['Quiz_quizzes'] . ' :: ' . switch_to_category_name($category_id);
	include($phpbb_root_path . "includes/page_header.$phpEx");
	$template->set_filenames(array("quiz_cat" => 'quiz_category_body.tpl'));	
	
	if( isset($HTTP_POST_VARS['view_method']) )
	{
	$method = intval($HTTP_POST_VARS['view_method']);
		
		if($method == 1)
		{
			$sql_addon = "ORDER BY quiz_name ASC";
		}

		if($method == 2)
		{
			$sql_addon = "ORDER BY quiz_id ASC";
		}
		
		if($method == 3)
		{
			$sql_addon = "ORDER BY quiz_type ASC";
		}
		
		if($method == 4)
		{
			$sql_addon = "ORDER BY quiz_author ASC";
		}
	}
	
	else
	{
		$sql_addon = 'ORDER BY quiz_name ASC';
	}
		
		$sql = "SELECT * FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_category = '" . $category_id . "' " . $sql_addon;
			
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, '', 'Could not obtain quiz name data', __LINE__, __FILE__);
		}
		
		if( $db->sql_numrows($result) == 0)
		{
			$template->assign_block_vars("nothing_row", array(
			"L_NO_RESULTS" => sprintf($lang['Quiz_no_quizzes'], append_sid("quiz.$phpEx?mode=add"))
			));
		}
		
		while($row = $db->sql_fetchrow($result))
		{		
			$quiz_name = str_replace("\'", "''", $row['quiz_name']);
			$quiz_id = intval($row['quiz_id']);
			$quiz_author = ( $row['quiz_author'] == ANONYMOUS ) ? $lang['Guest'] : "<a href=" . append_sid("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . intval($row['quiz_author']) . "") . ">" . convert_id($row['quiz_author']) . "</a>";
			$quiz_type = str_replace("\'", "''", $row['quiz_type']);
		
			if( intval($row['quiz_plays']) != 1 )
			{
				$quiz_plays = sprintf($lang['Quiz_number_of_plays'], $row['quiz_plays']);
			}
			
			else if( intval($row['quiz_plays']) == 1 )
			{
				$quiz_plays = $lang['Quiz_number_of_play'];
			}

		// We need to let the users know which type of quiz it is surely.
		if($quiz_type == MULTIPLE_CHOICE)
		{
			$ultimate_quiz_type = $lang['Quiz_type_multiple_choice'];
		}	
		
		if($quiz_type == TRUE_FALSE)
		{
			$ultimate_quiz_type = $lang['Quiz_type_true_false'];
		}		
		
		if($quiz_type == INPUT_ANSWER)
		{
			$ultimate_quiz_type = $lang['Quiz_type_input_answer'];
		}
		
			 $template->assign_block_vars("play_row", array(
			 "U_QUIZ_LINK" => "<a href='" . append_sid("quiz.$phpEx?mode=play&" . POST_QUIZ_URL . "=" . $quiz_id . "") . "'>$quiz_name</a>",
			 "U_AUTHOR" => $quiz_author,
			 "U_TYPE" => $ultimate_quiz_type,
			 "U_PLAYS" => $quiz_plays));
			 
		}
		
	$template->assign_vars( array(
	"U_QUIZZES" => switch_to_category_name($category_id),
	"U_SUBMIT_QUIZ" => "<a href='" . append_sid("quiz.$phpEx?mode=add") . "'>" . $lang['Submit_quiz'] . "</a>",
	"U_STATISTICS_LINK" => "<a href='" . append_sid("quiz_stats.$phpEx") . "'>" . $lang['Quiz_stats'] . "</a>",
	
	"F_FORM" => append_sid("quiz.$phpEx?" . POST_CAT_URL . "=$category_id"),
	
	"L_SUBMIT" => $lang['Submit'],
	"L_VIEW_ALPHABETICAL" => $lang['Quiz_view_alphabetical'],
	"L_VIEW_TYPE" => $lang['Quiz_view_type'],
	"L_VIEW_AUTHOR" => $lang['Quiz_view_author'],
	"L_VIEW_CHRONILOGICAL" => $lang['Quiz_view_chronilogical']));
		
	$template->pparse("quiz_cat");
	include($phpbb_root_path . "includes/page_tail.$phpEx");
	}
		
	if( $mode == 'play' || isset($HTTP_GET_VARS[POST_QUIZ_URL]) )
	{
	quiz_permissions();
	
	// September 10, 2005. Newest addition. In all probability not much will be done on this tonight. I made a function though :)
	// Actually, I might CVS it.
	$quiz_id = intval($HTTP_GET_VARS[POST_QUIZ_URL]); // Intval it now. Saves doing it every time it is called up for selection (cricket-ism).
	$quiz_type = quiz_type($quiz_id);
	
	// Let's check the stats, if the admin wants users to be able to play each quiz, once only.
	if( quiz_check_moderative_status($userdata['user_id'], $quiz_id) != ON && $userdata['user_level'] != ADMIN )
	{
		if( $board_config['Quiz_Play_Once'] == ON )
		{
			$statistics_check = "SELECT * FROM " . QUIZ_STATISTICS_TABLE . " WHERE quiz_id = $quiz_id AND user_id = " . $userdata['user_id'];
		
			if( !$statistics_check_result = $db->sql_query($statistics_check) )
			{
				message_die(GENERAL_ERROR, 'Could not get statistics data to check Quiz_Play_Once setting', '', __LINE__, __FILE__, $statistics_check);
			}
			
			if( $db->sql_numrows($statistics_check_result) == 1 || $db->sql_numrows($statistics_check_result) > 1 )
			{
				message_die(GENERAL_MESSAGE, $lang['Quiz_only_play_it_once']);
			}
		}
	}
	
	// Basically, there will be three sections (no prizes for guessing). This is the first. Hopefully they are not too large.
	$sql = "SELECT * FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_id = " . $quiz_id;
		
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, '', 'Could not obtain basic quiz data', __LINE__, __FILE__);
		}
			
	$general_quiz_data = $db->sql_fetchrow($result);
		
	// Author information
	$quiz_author_id = $general_quiz_data['quiz_author'];
	$quiz_author_name = convert_id($general_quiz_data['quiz_author']);
	$quiz_author_link = "<a href='" . append_sid("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=$quiz_author_id") . "'>$quiz_author_name</a>";
		
	// Miscellaneous
	$quiz_name = str_replace("\'", "''", $general_quiz_data['quiz_name']);
	$quiz_category = intval($general_quiz_data['quiz_category']);
	$quiz_enabled = $general_quiz_data['quiz_enabled'];
	
	$password_sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE . " WHERE category_id = $quiz_category";
		
		if(!$password_result = $db->sql_query($password_sql))
		{
			message_die(GENERAL_ERROR, '', 'Could not obtain category password', __LINE__, __FILE__, $password_sql);
		}
		
		$password_row = $db->sql_fetchrow($password_result);
		
		if( !$userdata['session_logged_in'] )
		{
			if( $password_row['category_permissions'] == ON || $password_row['category_permissions'] == OFF )
			{
				message_die(GENERAL_ERROR, $lang['Quiz_registered_category_permissions_no_access']);
			}		
		}
		
		if( quiz_check_category_password($quiz_category) != 1 && $password_row['category_password'] !== 'd41d8cd98f00b204e9800998ecf8427e' )
		{
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("quiz_pw" => 'quiz_category_password_body.tpl'));
		
			$template->assign_vars( array(
			"F_FORM" => append_sid("quiz.$phpEx?mode=play&" . POST_QUIZ_URL . "=$quiz_id"),
			
			"L_SUBMIT" => $lang['Submit'],
			"L_ENTER_PASSWORD" => $lang['Quiz_password_protect_information'],
			"L_PASSWORD" => $lang['Quiz_password_protect']));
			
		$template->pparse("quiz_pw");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}

		if($board_config['Quiz_Author_Play'] == OFF && $quiz_author_id == $userdata['user_id'])
		{
			message_die(GENERAL_MESSAGE, $lang['Quiz_author_cannot_play']);
		}
	
		if($quiz_type == MULTIPLE_CHOICE)
		{
		$page_title = $quiz_name;
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("play_multiple_choice" => 'quiz_play_multiple_choice_body.tpl'));	
		
			if( quiz_check_moderative_status($userdata['user_id'], $quiz_id) == ON )
			{
				$mod_langs = '<br />' . $lang['Quiz_cp_play_quiz_mod'] . '<br />' . sprintf( $lang['Quiz_cp_play_quiz_mod_do'], '<a href="' . append_sid("quiz_cp.$phpEx?mode=edit&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>', '<a href="' . append_sid("quiz_cp.$phpEx?mode=delete&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>', '<a href="' . append_sid("quiz_cp.$phpEx?mode=move&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>');
			}
			
			else
			{
				$mod_langs = '';
			}

		$select_quiz_data = "SELECT * FROM " . QUIZ_MULTIPLE_CHOICE_TABLE . " WHERE quiz_id = $quiz_id";

			if(!$result_quiz_data = $db->sql_query($select_quiz_data))
			{
				message_die(GENERAL_ERROR, '', 'Could not obtain advanced quiz data', __LINE__, __FILE__);
			}
			
				while($quiz_data = $db->sql_fetchrow($result_quiz_data))
				{
				$quiz_question = smilies_pass(bbencode_second_pass($quiz_data['quiz_question'], ''));
				$quiz_question_id = $quiz_data['question_id'];
				
				$quiz_multiple_choice = array();
				$quiz_multiple_choice = explode("!*-.@.-*!", $quiz_data['quiz_alternates']);
				
				$template->assign_vars( array(
				 "U_QUIZ_NAME" => $quiz_name,
				 "U_STATISTICS" => "<a href='" . append_sid("quiz_stats.$phpEx?" . POST_QUIZ_URL . "=$quiz_id") . "'>" . $lang['Quiz_stats'] . "</a>",
				 
				 "F_FORM" => append_sid("quiz.$phpEx?mode=results"),
				 "F_ID" => $quiz_id,
				 "F_TYPE" => $quiz_type,
				
				 "L_MOD_LANGS" => $mod_langs,
				 "L_MULTIPLE_INFORMATION" => $lang['Quiz_multiple_information'], 
				 "L_SUBMIT" => $lang['Submit_quiz']));
				
				 $template->assign_block_vars("quiz_row", array(
				 "U_QUESTION_ID" => $quiz_question_id,
				 "U_QUESTION" => $quiz_question,
				 
				 "Q_ALTERNATE_ONE" => $quiz_multiple_choice[0],
				 "Q_ALTERNATE_TWO" => $quiz_multiple_choice[1],
				 "Q_ALTERNATE_THREE" => $quiz_multiple_choice[2],
				 "Q_ALTERNATE_FOUR" => $quiz_multiple_choice[3]));			
				}
				
		$template->pparse("play_multiple_choice");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	
		if($quiz_type == INPUT_ANSWER)
		{
		$page_title = $quiz_name;
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("play_input_answer" => 'quiz_play_input_answer_body.tpl'));	

			if( quiz_check_moderative_status($userdata['user_id'], $quiz_id) == ON )
			{
			$mod_langs = '<br />' . $lang['Quiz_cp_play_quiz_mod'] . '<br />' . sprintf( $lang['Quiz_cp_play_quiz_mod_do'], '<a href="' . append_sid("quiz_cp.$phpEx?mode=edit&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>', '<a href="' . append_sid("quiz_cp.$phpEx?mode=delete&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>', '<a href="' . append_sid("quiz_cp.$phpEx?mode=move&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>');
			}
			
			else
			{
				$mod_langs = '';
			}		
		
		$select_quiz_data = "SELECT * FROM " . QUIZ_INPUT_TABLE . " WHERE quiz_id = $quiz_id";

			if(!$result_quiz_data = $db->sql_query($select_quiz_data))
			{
				message_die(GENERAL_ERROR, '', 'Could not obtain advanced quiz data', __LINE__, __FILE__);
			}
			
				while($quiz_data = $db->sql_fetchrow($result_quiz_data))
				{
				$quiz_question = smilies_pass(bbencode_second_pass($quiz_data['quiz_question'], ''));
				$quiz_question_id = $quiz_data['question_id'];
				
				// I've decided not to encode the answer, it is easier to compare it to an id, such as the game_id / quiz_id partnership in 1.0.6
		
				$template->assign_vars( array(
				 "U_QUIZ_NAME" => $quiz_name,
				 "U_STATISTICS" => "<a href='" . append_sid("quiz_stats.$phpEx?" . POST_QUIZ_URL . "=$quiz_id") . "'>" . $lang['Quiz_stats'] . "</a>",
				 
				 "F_FORM" => append_sid("quiz.$phpEx?mode=results"),
				 "F_ID" => $quiz_id,
				 "F_TYPE" => $quiz_type,
	
				 "L_MOD_LANGS" => $mod_langs,	
				 "L_INPUT_INFORMATION" => $lang['Quiz_input_information'], 
				 "L_SUBMIT" => $lang['Submit_quiz']));
				
				 $template->assign_block_vars("quiz_row", array(
				 "U_QUESTION_ID" => $quiz_question_id,
				 "U_QUESTION" => $quiz_question));
				 
				}
			
		$template->pparse("play_input_answer");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	
		if($quiz_type == TRUE_FALSE)
		{
		$page_title = $quiz_name;
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("play_true_false" => 'quiz_play_true_false_body.tpl'));
		
			if( quiz_check_moderative_status($userdata['user_id'], $quiz_id) == ON )
			{
				$mod_langs = '<br />' . $lang['Quiz_cp_play_quiz_mod'] . '<br />' . sprintf( $lang['Quiz_cp_play_quiz_mod_do'], '<a href="' . append_sid("quiz_cp.$phpEx?mode=edit&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>', '<a href="' . append_sid("quiz_cp.$phpEx?mode=delete&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>', '<a href="' . append_sid("quiz_cp.$phpEx?mode=move&" . POST_QUIZ_URL . "=$quiz_id") . '">', '</a>');
			}
			
			else
			{
				$mod_langs = '';
			}
		
		$select_quiz_data = "SELECT * FROM " . QUIZ_TRUE_FALSE_TABLE . " WHERE quiz_id = $quiz_id";

			if(!$result_quiz_data = $db->sql_query($select_quiz_data))
			{
				message_die(GENERAL_ERROR, '', 'Could not obtain advanced quiz data', __LINE__, __FILE__);
			}
			
				while($quiz_data = $db->sql_fetchrow($result_quiz_data))
				{
				$quiz_question = smilies_pass(bbencode_second_pass($quiz_data['quiz_question'], ''));
				$quiz_question_id = $quiz_data['question_id'];
				$quiz_answer = $quiz_data['quiz_answer']; // May be turned into a hidden variable to compare questions and answers.
				
				// This section is nowhere near a working order. Therefore don't use it. Sorry
				
				 $template->assign_vars( array(
				 "U_QUIZ_NAME" => $quiz_name,		
				 "U_STATISTICS" => "<a href='" . append_sid("quiz_stats.$phpEx?" . POST_QUIZ_URL . "=$quiz_id") . "'>" . $lang['Quiz_stats'] . "</a>",
				 
				 "F_FORM" => append_sid("quiz.$phpEx?mode=results"),
				 "F_ID" => $quiz_id,
				 "F_TYPE" => $quiz_type,
	
				 "L_MOD_LANGS" => $mod_langs,	
				 "L_TRUE_FALSE_INFORMATION" => $lang['Quiz_true_false_information'], 
				 "L_TRUE" => $lang['Quiz_answer_true'], 
				 "L_FALSE" => $lang['Quiz_answer_false'],
				 "L_SUBMIT" => $lang['Submit_quiz']));
				
				 $template->assign_block_vars("quiz_row", array(
				 "U_QUESTION_ID" => $quiz_question_id,
				 "U_QUESTION" => $quiz_question,
				 "U_ANSWER" => md5($quiz_answer)));
				 
				}
			
		$template->pparse("play_true_false");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	}
		
	if($mode == 'add')
	{
	quiz_permissions();
	$quiz_questions_explode = explode(',', $board_config['Quiz_Min_Max_Questions']);
	
	if( $board_config['Quiz_Mod_Submit'] == ON && quiz_check_moderative_status($userdata['user_id'], '') != ON )
	{
		message_die(GENERAL_MESSAGE, $lang['Quiz_only_mod_can_submit']);
	}
	
		if(!$HTTP_POST_VARS['Questions_number'] && isset($quiz_type))
		{
			message_die(GENERAL_MESSAGE, $lang['Quiz_no_number_chosen']);
		}
		
		if(!isset($HTTP_POST_VARS['type']))
		{
		$page_title = $lang['Submit_quiz'];
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("add_initial" => 'quiz_add_initial_body.tpl'));
		
			if( $quiz_questions_explode[0] == $quiz_questions_explode[1] )
			{
			$quiz_min_max_questions_set = sprintf($lang['Quiz_min_max_set'], $quiz_questions_explode[0]);
			$quiz_default_number = '&nbsp;<b>' . intval($quiz_questions_explode[0]) . '</b><input type="hidden" name="Questions_number" value="' . intval($quiz_questions_explode[0]) . '" />';
			}
		
			else
			{
			$quiz_min_max_questions_set = sprintf($lang['Quiz_min_max'], $quiz_questions_explode[0], $quiz_questions_explode[1]);
			$quiz_default_number = '&nbsp;<input type="text" class="post" name="Questions_number" size="5" maxlength="4" value="" />';
			}
			
		$template->assign_vars(array( 
			"U_DEFAULT" => $quiz_default_number,
		
			"F_FORM" => append_sid("quiz.$phpEx?mode=add"),
		
			"L_MIN_MAX" => $quiz_min_max_questions_set,
			"L_SETUP_OPTIONS" => $lang['Quiz_set_up_options'],
			"L_SELECT_NUMBER" => $lang['Quiz_select_number'],
			"L_TRUE_FALSE" => $lang['Submit_true_false_quiz'],
			"L_MULTIPLE_CHOICE" => $lang['Submit_multiple_choice_quiz'],
			"L_INPUT" => $lang['Submit_input_quiz'],
			"L_SUBMIT" => $lang['Submit_quiz']));
			
		$template->pparse("add_initial");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	
		if($quiz_type == 'multiple_choice')
		{
		$page_title = $lang['Submit_multiple_choice_quiz'];
		include($phpbb_root_path . "includes/page_header.$phpEx");
		
		quiz_check_question_limitations();
		
		$template->set_filenames(array("multiple_choice" => "quiz_add_multiple_choice_body.tpl"));
	
			for ( $i = 0; $i < intval($HTTP_POST_VARS['Questions_number']); $i++ )
			{
			$template->assign_block_vars('question_number', array(
			 'U_UNIQUE' => $i));
			}
			
			// To make the box..
			$category_drop_down_box = '<select name="category">';
			$category_sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE . " ORDER BY category_id ASC";
			
			if(!$category_result = $db->sql_query($category_sql))
			{
			message_die(GENERAL_ERROR, '', 'Could not fetch category names!');
			}
			
			while($category_row = $db->sql_fetchrow($category_result))
			{
			$category_drop_down_box .= populate_quiz_drop_down_box($category_row['category_id'], $category_row['category_name']);
			}
			
			$category_drop_down_box .= '</select>';
		
		$template->assign_vars(array( 
			"F_FORM" => append_sid("quiz.$phpEx?mode=sql"),
			
			"U_TOTAL" => intval($HTTP_POST_VARS['Questions_number']),
			"U_CATEGORY" => $category_drop_down_box,
		
			"L_INSERT_NAME" => $lang['Quiz_insert_name'],
			"L_QUESTION" => $lang['Quiz_question'],
			"L_ALTERNATE_ANSWER" => $lang['Quiz_alternate'],
			"L_SUBMIT" => $lang['Submit_quiz']));
		
		$template->pparse("multiple_choice");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	
		if($quiz_type == 'input_answer')
		{
		$page_title = $lang['Submit_input_quiz'];
		include($phpbb_root_path . "includes/page_header.$phpEx");
		
		$template->set_filenames(array("input" => "quiz_add_input_body.tpl"));
		
		quiz_check_question_limitations();
	
			for ( $i = 0; $i < intval($HTTP_POST_VARS['Questions_number']); $i++ )
			{
				 $template->assign_block_vars('question_number', array(
				 'U_UNIQUE' => $i));
			}
			
			// To make the box..
			$category_drop_down_box = '<select name="category">';
			$category_sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE . " ORDER BY category_id ASC";
			
			if(!$category_result = $db->sql_query($category_sql))
			{
				message_die(GENERAL_ERROR, '', 'Could not fetch category names!');
			}
			
			while($category_row = $db->sql_fetchrow($category_result))
			{
				$category_drop_down_box .= populate_quiz_drop_down_box($category_row['category_id'], $category_row['category_name']);
			}
			
			$category_drop_down_box .= '</select>';
		
		$template->assign_vars(array( 
			"F_FORM" => append_sid("quiz.$phpEx?mode=sql"),
			
			"U_TOTAL" => intval($HTTP_POST_VARS['Questions_number']),
			"U_CATEGORY" => $category_drop_down_box,
		
			"L_INSERT_NAME" => $lang['Quiz_insert_name'],
			"L_CORRECT_ANSWER" => $lang['Quiz_answer_correct'],
			"L_QUESTION" => $lang['Quiz_question'],
			"L_SUBMIT" => $lang['Submit_quiz']));
		
		$template->pparse("input");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
		
		if($quiz_type == 'true_false')
		{
		$page_title = $lang['Submit_true_false_quiz'];
		include($phpbb_root_path . "includes/page_header.$phpEx");
		
		$template->set_filenames(array("true_false" => "quiz_add_true_false_body.tpl"));
	
		quiz_check_question_limitations();
	
			for ( $i = 0; $i < intval($HTTP_POST_VARS['Questions_number']); $i++ )
			{
				 $template->assign_block_vars('question_number', array(
				 'U_UNIQUE' => $i));
			}
		
			// To make the box..
			$category_drop_down_box = '<select name="category">';
			$category_sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE . " ORDER BY category_id ASC";
			
			if(!$category_result = $db->sql_query($category_sql))
			{
				message_die(GENERAL_ERROR, '', 'Could not fetch category names!');
			}
			
			while($category_row = $db->sql_fetchrow($category_result))
			{
				$category_drop_down_box .= populate_quiz_drop_down_box($category_row['category_id'], $category_row['category_name']);
			}
			
			$category_drop_down_box .= '</select>';		
		
			$template->assign_vars(array( 
				"F_FORM" => append_sid("quiz.$phpEx?mode=sql"),
			
				"U_TOTAL" => intval($HTTP_POST_VARS['Questions_number']),
				"U_CATEGORY" => $category_drop_down_box,
			
				"L_INSERT_NAME" => $lang['Quiz_insert_name'],
				"L_TRUE" => $lang['Quiz_answer_true'],
				"L_FALSE" => $lang['Quiz_answer_false'],
				"L_QUESTION" => $lang['Quiz_question'],
				"L_SUBMIT" => $lang['Submit_quiz']));
		
		$template->pparse("true_false");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	}
	
	if($mode == "sql")
	{
	// Similar to that of v1.0.x but not the same
	// This is better :-)

		if($HTTP_POST_VARS['Quiz_Type'] == "Input" || $HTTP_POST_VARS['Quiz_Type'] == "True_False")
		{
			if($HTTP_POST_VARS['Quiz_Type'] == "Input")
			{
				$table_name = QUIZ_INPUT_TABLE; // x_quiz_input_data
			}
			
			else
			{
				$table_name = QUIZ_TRUE_FALSE_TABLE; // x_quiz_true_false_data
			}

			for ( $i = 0; $i < intval($HTTP_POST_VARS['Quiz_Question']); $i++ )
			{	
				$question_sql = "INSERT INTO " . $table_name . " (quiz_id, question_id, quiz_question, quiz_answer) 	
				VALUES ( " . next_quiz_id() . ", " . ($i + 1) . ", '" . str_replace("\'", "''", bbencode_first_pass(htmlspecialchars($HTTP_POST_VARS["Question_$i"]), '')) . "', 
				'" . str_replace("\'", "''", bbencode_first_pass(htmlspecialchars($HTTP_POST_VARS["Correct_Answer_$i"]), '')) . "')";
					
				if( !$question_result = $db->sql_query($question_sql))
				{
					message_die(GENERAL_ERROR, 'Could not insert question / answer data', '', __LINE__, __FILE__, $question_sql);
				}
			}
		}
		
		if($HTTP_POST_VARS['Quiz_Type'] == "Multiple")
		{
			for ( $i = 0; $i < intval($HTTP_POST_VARS['Quiz_Question']); $i++ )
			{	
				// The answer isn't going to be Alternate_x_x now is it :roll:
				// Well not often anyway ;-)
				// Update: A few months later, I don't even know what the hell I was talking about. Better read the code to find out what exactly this section does eh?
				
				$answer = array();
				
				if($HTTP_POST_VARS["Correct_Answer_$i"] == "Alternate1_$i")
				{
					$answer[$i] = bbencode_first_pass(str_replace("\'", "''", $HTTP_POST_VARS["Alternate1_$i"]), '');
				}
				
				else if($HTTP_POST_VARS["Correct_Answer_$i"] == "Alternate2_$i")
				{
					$answer[$i] = bbencode_first_pass(str_replace("\'", "''", $HTTP_POST_VARS["Alternate2_$i"]), '');
				}
				
				else if($HTTP_POST_VARS["Correct_Answer_$i"] == "Alternate3_$i")
				{
					$answer[$i] = bbencode_first_pass(str_replace("\'", "''", $HTTP_POST_VARS["Alternate3_$i"]), '');
				}
				
				else if($HTTP_POST_VARS["Correct_Answer_$i"] == "Alternate4_$i")
				{
					$answer[$i] = bbencode_first_pass(str_replace("\'", "''", $HTTP_POST_VARS["Alternate4_$i"]), '');
				}
				
				// As much as I hate the following few lines, because it is awfully messy, I must say, it works beautifully
				// Basically this is the most effective way of doing it. You can use the | but that means that anyone that uses that screws up the quiz.
				// Sure the same thing can happen with !*-.@.-*! but what are the odds?
				
				$question_sql = "INSERT INTO " . QUIZ_MULTIPLE_CHOICE_TABLE . " 
				(quiz_id, question_id, quiz_question, quiz_alternates, quiz_answer) 	
				VALUES ( " . next_quiz_id() . ", " . ($i + 1) . ", '" . str_replace("\'", "''", bbencode_first_pass(htmlspecialchars($HTTP_POST_VARS["Question_$i"]), '')) . "',
				'" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["Alternate1_$i"])) . "!*-.@.-*!" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["Alternate2_$i"])) . "!*-.@.-*!" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["Alternate3_$i"])) . "!*-.@.-*!" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["Alternate4_$i"])) . "', 
				'" . htmlspecialchars($answer[$i]) . "')";
					
				if( !$question_result = $db->sql_query($question_sql))
				{
					message_die(GENERAL_ERROR, 'Could not insert question / answer data', '', __LINE__, __FILE__, $question_sql);
				}
			}			
		}
		
				if($HTTP_POST_VARS['Quiz_Type'] == "True_False")
				{
					$ultimate_quiz_type = TRUE_FALSE;
				}
				
				else if($HTTP_POST_VARS['Quiz_Type'] == "Multiple")
				{
					$ultimate_quiz_type = MULTIPLE_CHOICE;
				}

				else if($HTTP_POST_VARS['Quiz_Type'] == "Input")
				{
					$ultimate_quiz_type = INPUT_ANSWER;
				}
				
	$sql =  "INSERT INTO " . QUIZ_GENERAL_TABLE . " (quiz_id, quiz_name, quiz_author, quiz_category, quiz_type) VALUES (
			  " . next_quiz_id() . ",
			  '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['Quiz_Name'])) . "',
			  '" . $userdata['user_id'] . "', 
			  '" . intval($HTTP_POST_VARS['category']) . "',
			  '" . $ultimate_quiz_type . "')";

			if( !$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not insert basic quiz details', '', __LINE__, __FILE__, $sql);
			}
			
			else
			{
				message_die(GENERAL_MESSAGE, $lang['Quiz_added_successfully']);
			}
	}
	
	if($mode == "results")
	{
	$page_title = $lang['Quiz_score'];
	include($phpbb_root_path . "includes/page_header.$phpEx");
	
	$template->set_filenames(array("quiz_result" => 'quiz_result_body.tpl'));
	
	$type = htmlspecialchars($HTTP_POST_VARS['type']);
	$id = intval($HTTP_POST_VARS['id']);
	
	if( quiz_check_moderative_status($userdata['user_id'], $id) != ON && $userdata['user_level'] != ADMIN )
	{
		if( $board_config['Quiz_Play_Once'] == ON )
		{
			$statistics_check = "SELECT * FROM " . QUIZ_STATISTICS_TABLE . " WHERE quiz_id = '$id' AND user_id = '" . $userdata['user_id'] . "'";
		
			if( !$statistics_check_result = $db->sql_query($statistics_check) )
			{
				message_die(GENERAL_ERROR, 'Could not get statistics data to check Quiz_Play_Once setting', '', __LINE__, __FILE__, $statistics_check);
			}
			
			if( $db->sql_numrows($statistics_check_result) == 1 || $db->sql_numrows($statistics_check_result) > 1 )
			{
				message_die(GENERAL_MESSAGE, $lang['Quiz_only_play_it_once']);
			}
		}
	}
	
		if($type == "input_answer")
		{
			$table = QUIZ_INPUT_TABLE;
		}
	
		else if($type == "true_false")
		{
			$table = QUIZ_TRUE_FALSE_TABLE;
		}
		
		else if($type == "multiple_choice")
		{
			$table = QUIZ_MULTIPLE_CHOICE_TABLE;
		}		
		
	$number_of_questions = number_of_questions($id, $table);
	
		for ( $i = 0; $i < $number_of_questions; $i++ )
		{	
			$sql = "SELECT quiz_question FROM " . $table . " WHERE question_id = " . ($i + 1) . " AND quiz_id = " . $id;
			
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, '', 'Could not get question', __LINE__, __FILE__);
			}

			$row = $db->sql_fetchrow($result);
			
		$question = smilies_pass(bbencode_second_pass($row['quiz_question'], ''));
		$user_answer = str_replace("\'", "''", $HTTP_POST_VARS[($i + 1)]);
		$actual_answer = quiz_answer(($i + 1), $id, $table);
		
			if($user_answer == $actual_answer)
			{
				$correct[$i] = 1;
				$incorrect[$i] = 0;
				
				// The message consists of Question: Your Answer: Actual Answer
				$status = sprintf($lang['Quiz_answer_status'], $user_answer, $actual_answer);
			}
			
			else if($user_answer != $actual_answer)
			{
				$correct[$i] = 0;
				$incorrect[$i] = 1;
				$status = sprintf($lang['Quiz_answer_status'], $user_answer, $actual_answer);
			}
			
			if($board_config['Quiz_show_answers'] == ON)
			{
				$template->assign_block_vars("answer_row", array(
				"U_STATUS" => $status,
				"U_QUESTION" => $question));
			}
		}
		
		// Get percentage
		if ( @array_sum($correct) != 0 && @array_sum($incorrect) != 0 )
		{			
			if( @array_sum($incorrect) == @array_sum($correct) )
			{
				$percentage = '50';
			}
			
			else
			{
				$percentage = ( @array_sum($correct) / ( @array_sum($correct) + @array_sum($incorrect) ) ) * 100;
			}
		}
		
		else
		{
			if( @array_sum($incorrect) == '0' )
			{
				$percentage = '100';
			}
			
			else if( @array_sum($correct) == '0' )
			{
				$percentage = '0';
			}
		}
		
		$update_play = "UPDATE " . QUIZ_GENERAL_TABLE . " SET quiz_plays = quiz_plays + 1 WHERE quiz_id = $id";
		
		if( !$db->sql_query($update_play) )
		{
			message_die(GENERAL_ERROR, 'Could not update play counter', '', __LINE__, __FILE__, $update_play);
		}
		
		$percentage = number_format($percentage, 0);
	
		$template->assign_vars(array( 
		"U_CORRECT_SCORE" => sprintf($lang['Quiz_show_correct_score'], @array_sum($correct)),
		"U_INCORRECT_SCORE" => sprintf($lang['Quiz_show_incorrect_score'], @array_sum($incorrect)),
		"U_PERCENTAGE" => $percentage . '%',
		
		"L_RETURN_INDEX" => sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>'),
		"L_RETURN_QUIZ" => sprintf($lang['Quiz_click_return_quiz'], '<a href="' . append_sid("quiz.$phpEx") . '">', '</a>'),
		"L_ANSWERS" => $lang['Quiz_score']));
			
			$statistics_sql = "INSERT INTO " . QUIZ_STATISTICS_TABLE . " (stats_id, quiz_id, user_id, stats_correct, stats_incorrect, stats_percentage) VALUES ('" . quiz_new_stats_id() . "', '$id', '" . $userdata['user_id'] . "', '" . @array_sum($correct) . "', '" . @array_sum($incorrect) . "', '$percentage')";
			
			if(!$db->sql_query($statistics_sql))
			{
				message_die(GENERAL_ERROR, '', 'Could not insert statistical values', __LINE__, __FILE__, $statistics_sql);
			}
			
			// Let's do the cash
			if( $board_config['Quiz_CashMOD_On'] == ON )
			{
			include($phpbb_root_path . 'includes/functions_cash.'.$phpEx);
			
				// Lets get the currency.. err... name?
				$get_cash_name = "SELECT cash_name FROM " . CASH_TABLE . " WHERE cash_dbfield = '" . $board_config['Quiz_Cash_Currency'] . "'";
				
					if( !$get_cash_result = $db->sql_query($get_cash_name) )
					{
						message_die(GENERAL_ERROR, 'Unable to execute cash name query', '', __LINE__, __FILE__, $get_cash_name);
					}
			
			$actual_cash_name = $db->sql_fetchrow($get_cash_result);
			
			$cash_per_correct = $board_config['Quiz_Cash_Correct'];
			$cash_per_incorrect = $board_config['Quiz_Cash_Incorrect'];
			$cash_tax = $board_config['Quiz_Cash_Tax'];
			
			$total_cash = ( ( @array_sum($correct) * $cash_per_correct ) - ( @array_sum($incorrect) * $cash_per_incorrect ) - ( $cash_tax ) );
			
			if( $total_cash > 0 || $total_cash == 0 )
			{
			$cash_language_variable = sprintf($lang['Quiz_cash_total_result_gain'], $total_cash, $actual_cash_name['cash_name']);
			
				$cash_sql = "UPDATE " . USERS_TABLE . " SET " . $board_config['Quiz_Cash_Currency'] . " = " . $board_config['Quiz_Cash_Currency'] . " + " . intval($total_cash) . " WHERE user_id = " . $userdata['user_id'];
			}
			
			else if( $total_cash < 0 )
			{
			$total_cash = str_replace('-', '', $total_cash);
			$cash_language_variable = sprintf($lang['Quiz_cash_total_result_loss'], $total_cash, $actual_cash_name['cash_name']);
			
				$cash_sql = "UPDATE " . USERS_TABLE . " SET " . $board_config['Quiz_Cash_Currency'] . " = " . $board_config['Quiz_Cash_Currency'] . " - " . intval($total_cash) . " WHERE user_id = " . $userdata['user_id'];
			}
			
				if( !$db->sql_query($cash_sql) )
				{
					message_die(GENERAL_ERROR, 'Unable to execute cash update', '', __LINE__, __FILE__, $cash_sql);
				}
			
			$template->assign_block_vars('cash_row', array());
			$template->assign_vars(array("U_CASH" => $cash_language_variable));
			}
			
		$template->pparse("quiz_result");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
	}

	
	$page_title = $lang['Quiz_quizzes'];
	include($phpbb_root_path . "includes/page_header.$phpEx");
	$template->set_filenames(array("quiz_index" => "quiz_index_body.tpl"));
	
		if( !$userdata['session_logged_in'] )
		{
			$sql_suffix = "WHERE category_permissions = 0 OR category_permissions = 1";
		}
		
		else
		{
			$sql_suffix = '';
		}
	
	$sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE . " $sql_suffix";
		
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain quiz category data', __LINE__, __FILE__);
	}
	
	while($row = $db->sql_fetchrow($result))
	{
	$category_id = intval($row['category_id']);
	$category_name = str_replace("\'", "''", $row['category_name']);
	$category_description = str_replace("\'", "''", $row['category_description']);
	$category_quizzes = category_quizzes($category_id);
	
	$template->assign_block_vars("quiz_row", array(
	"U_NAME" => "<a href='" .  append_sid("quiz.$phpEx?" . POST_CAT_URL . "=$category_id") . "'>$category_name</a>",
	"U_DESCRIPTION" => $category_description,
	"U_QUIZZES" => $category_quizzes . ' ' . $lang['Quiz_quizzes']));
	}

	$template->assign_vars(array( 
	"U_SUBMIT_QUIZ" => "<a href='" . append_sid("quiz.$phpEx?mode=add") . "'>" . $lang['Submit_quiz'] . "</a>",
	"U_STATISTICS_LINK" => "<a href='" . append_sid("quiz_stats.$phpEx") . "'>" . $lang['Quiz_stats'] . "</a>",
	
	"L_QUIZZES" => $lang['Quiz_quizzes'],
	"L_ANSWERS" => $lang['Quiz_score']));
	
	if( $board_config['Quiz_CashMOD_On'] == ON )
	{
	// Just noticed that there are 971 line so far, can we make 1000? Yep
	$template->assign_block_vars('cash_row', array());
	$quiz_cash_correct = intval($board_config['Quiz_Cash_Correct']);
	$quiz_cash_incorrect = intval($board_config['Quiz_Cash_Incorrect']);
	$quiz_cash_tax = intval($board_config['Quiz_Cash_Tax']);
	
	$template->assign_vars( array(
	"CASH_INFORMATION" => sprintf($lang['Quiz_cash_information'], $quiz_cash_correct, $quiz_cash_incorrect, $quiz_cash_tax)));
	// I'm now depressed, that was the first time this series I haven't labelled it L_, U_, or F_. Pfft
	}
	
	$template->pparse("quiz_index");
	include($phpbb_root_path . "includes/page_tail.$phpEx");
?>