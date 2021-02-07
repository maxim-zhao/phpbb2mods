<?php
/***************************************************************************
 *                               quiz_cp.php
 *                            -------------------
 *   begin                : Sun, Nov 6, 2005
 *   copyright          : (C) 2005 Battye @ CricketMX.com
 *   email                : cricketmx@hotmail.com
 *
 *   $Id: quiz_cp.php, v1 (Nov 2005) battye Exp $
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

$quiz_id = intval($HTTP_GET_VARS[POST_QUIZ_URL]);

$users = explode(',', $board_config['Quiz_Moderators']);

	for( $o = 0; $o < count($users); $o++ )
	{
		if( $userdata['user_id'] == intval($users[$o]) )
		{
			$quiz_moderator = ON;
		}
	}

	if( $quiz_moderator != ON && $userdata['user_level'] != ADMIN )
	{
		message_die(GENERAL_ERROR, $lang['Quiz_cp_not_moderator']);
	}

	if( isset($HTTP_GET_VARS['mode']) )
	{
		if( $HTTP_GET_VARS['mode'] == 'edit' )
		{	
			if( quiz_type($quiz_id) == 'multiple_choice' )
			{
				$quiz_data_table = QUIZ_MULTIPLE_CHOICE_TABLE;
				$tpl_file = 'quiz_cp_multiple_choice_edit_body.tpl';
			}
				
			if( quiz_type($quiz_id) == 'input_answer' )
			{
				$quiz_data_table = QUIZ_INPUT_TABLE;
				$tpl_file = 'quiz_cp_input_answer_edit_body.tpl';			
			}
								
			if( quiz_type($quiz_id) == 'true_false' )
			{
				$quiz_data_table = QUIZ_TRUE_FALSE_TABLE;
				$tpl_file = 'quiz_cp_true_false_edit_body.tpl';
			}
			
			if( $HTTP_GET_VARS['type'] == 'sql' )
			{
			$while_sql = "SELECT * FROM $quiz_data_table WHERE quiz_id = '$quiz_id'";
			
			if( !$while_result = $db->sql_query($while_sql) )
			{
			message_die(GENERAL_ERROR, 'Could not get id data', '', __LINE__, __FILE__, $while_sql);
			}
			
				if( quiz_type($quiz_id) == 'multiple_choice' )
				{
					while( $while_row = $db->sql_fetchrow($while_result) )
					{
					$add_number = $while_row['question_id'];
					
						if($HTTP_POST_VARS["C_$add_number"] == "A1_$add_number")
						{
							$answer[$add_number] = bbencode_first_pass(str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A1_$add_number"])), '');
						}
						
						else if($HTTP_POST_VARS["C_$add_number"] == "A2_$add_number")
						{
							$answer[$add_number] = bbencode_first_pass(str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A2_$add_number"])), '');
						}
						
						else if($HTTP_POST_VARS["C_$add_number"] == "A3_$add_number")
						{
							$answer[$add_number] = bbencode_first_pass(str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A3_$add_number"])), '');
						}
						
						else if($HTTP_POST_VARS["C_$add_number"] == "A4_$add_number")
						{
							$answer[$add_number] = bbencode_first_pass(str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A4_$add_number"])), '');
						}
						
					$data_updater = "UPDATE $quiz_data_table SET quiz_alternates = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A1_$add_number"])) . "!*-.@.-*!" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A2_$add_number"])) . "!*-.@.-*!" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A3_$add_number"])) . "!*-.@.-*!" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS["A4_$add_number"])) . "', quiz_question = '" . str_replace("\'", "''", bbencode_first_pass(htmlspecialchars($HTTP_POST_VARS["Q_$add_number"]), '')) . "', quiz_answer = '" . $answer[$add_number] . "' WHERE quiz_id = $quiz_id AND question_id = $add_number";
					$general_updater = "UPDATE " . QUIZ_GENERAL_TABLE . " SET quiz_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['name']) . "' WHERE quiz_id = '$quiz_id'";
					
						if( !$db->sql_query($data_updater) || !$db->sql_query($general_updater) )
						{
							message_die(GENERAL_ERROR, 'Could not update quiz data', '', __LINE__, __FILE__, $general_updater . ', ' . $data_updater);
						}
					}
				}
				
				if( quiz_type($quiz_id) == 'true_false' )
				{
					while( $while_row = $db->sql_fetchrow($while_result) )
					{
					$add_number = intval($while_row['question_id']);
					$answer[$add_number] = ( $HTTP_POST_VARS["A_$add_number"] == $lang['Quiz_answer_true'] ) ? $lang['Quiz_answer_true'] : $lang['Quiz_answer_false'];
					
					$data_updater = "UPDATE $quiz_data_table SET quiz_question = '" . str_replace("\'", "''", bbencode_first_pass(htmlspecialchars($HTTP_POST_VARS["Q_$add_number"]), '')) . "', quiz_answer = '" . str_replace("\'", "''", htmlspecialchars($answer[$add_number])) . "' WHERE quiz_id = $quiz_id AND question_id = $add_number";
					$general_updater = "UPDATE " . QUIZ_GENERAL_TABLE . " SET quiz_name = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['name'])) . "' WHERE quiz_id = '$quiz_id'";
					
						if( !$db->sql_query($data_updater) || !$db->sql_query($general_updater) )
						{
							message_die(GENERAL_ERROR, 'Could not update quiz', '', __LINE__, __FILE__, $general_updater . ', ' . $data_updater);
						}
					}
				}
				
				if( quiz_type($quiz_id) == 'input_answer' )
				{
					while( $while_row = $db->sql_fetchrow($while_result) )
					{
					$add_number = intval($while_row['question_id']);
					$answer[$add_number] = bbencode_first_pass(str_replace("\'", "''", $HTTP_POST_VARS["A_$add_number"]), '');
					
					$data_updater = "UPDATE $quiz_data_table SET quiz_question = '" . str_replace("\'", "''", bbencode_first_pass(htmlspecialchars($HTTP_POST_VARS["Q_$add_number"]), '')) . "', quiz_answer = '" . str_replace("\'", "''", htmlspecialchars($answer[$add_number])) . "' WHERE quiz_id = $quiz_id AND question_id = $add_number";
					$general_updater = "UPDATE " . QUIZ_GENERAL_TABLE . " SET quiz_name = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['name'])) . "' WHERE quiz_id = $quiz_id";
					
						if( !$db->sql_query($data_updater) || !$db->sql_query($general_updater) )
						{
							message_die(GENERAL_ERROR, 'Could not update quiz', '', __LINE__, __FILE__, $general_updater . ', ' . $data_updater);
						}
					}
				}
				
			message_die(GENERAL_MESSAGE, $lang['Quiz_cp_edited']);		
			}
			
			$page_title = $lang['Quiz_cp_edit'];
			include($phpbb_root_path . "includes/page_header.$phpEx");
			$template->set_filenames(array("quiz_edit" => $tpl_file));
			
		$general = "SELECT * FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_id = '$quiz_id'";
		
			if( !$general_data = $db->sql_query($general) )
			{
				message_die(GENERAL_ERROR, "Could not get general quiz data for editing", "", __LINE__, __FILE__, $general);
			}
			
			$general_row = $db->sql_fetchrow($general_data);
			
		$quiz_data = "SELECT * FROM $quiz_data_table WHERE quiz_id = $quiz_id";
		
			if( !$data_result = $db->sql_query($quiz_data) )
			{
				message_die(GENERAL_ERROR, "Could not get actual quiz data for editing", "", __LINE__, __FILE__, $quiz_data);
			}
			
			$template->assign_vars( array(
			 "F_FORM" => append_sid("quiz_cp.$phpEx?mode=edit&type=sql&" . POST_QUIZ_URL . "=$quiz_id"),
			 "U_NAME" => $general_row['quiz_name'],
			
			 "L_TRUE" => $lang['Quiz_answer_true'],
			 "L_FALSE" => $lang['Quiz_answer_false'],
			 "L_QUESTION" => $lang['Quiz_question'],
			 "L_EDIT" => $lang['Quiz_cp_edit'],
			 "L_NAME" => $lang['Quiz_insert_name'],
			 "L_EXPLAIN" => $lang['Quiz_cp_edit_explaination'],
			 "L_CHECK" => $lang['Quiz_cp_place_check'],
			 "L_SUBMIT" => $lang['Submit']));
			
			while( $quiz_data_row = $db->sql_fetchrow($data_result) )
			{
				if( quiz_type($quiz_id) == 'multiple_choice' )
				{
				// The explode part is pretty much direct from quiz.php.. I mean, why not?
				$quiz_multiple_choice = explode("!*-.@.-*!", $quiz_data_row['quiz_alternates']);
				
				$alternate_one = str_replace("\'", "''", $quiz_multiple_choice[0]);
				$alternate_two = str_replace("\'", "''", $quiz_multiple_choice[1]);
				$alternate_three = str_replace("\'", "''", $quiz_multiple_choice[2]);
				$alternate_four = str_replace("\'", "''", $quiz_multiple_choice[3]);
				
				$template->assign_vars( array(
				 "U_QUIZZES" => $db->sql_numrows($data_result)));
				
				$template->assign_block_vars("edit_row", array(				 
				 "U_QUESTION_ID" => $quiz_data_row['question_id'],
				 "U_QUESTION" => $quiz_data_row['quiz_question'],
				 "U_ANSWER" => $quiz_data_row['quiz_answer'],
				 
				 "U_A1" => $alternate_one,
				 "U_A2" => $alternate_two,
				 "U_A3" => $alternate_three,
				 "U_A4" => $alternate_four));
				}
				
				else
				{
				$template->assign_vars( array(
				 "U_QUIZZES" => $db->sql_numrows($data_result)));
				
				$template->assign_block_vars("edit_row", array(
				 "U_QUESTION_ID" => intval($quiz_data_row['question_id']),
				 "U_QUESTION" => str_replace("\'", "''", $quiz_data_row['quiz_question']),
				 "U_ANSWER" => str_replace("\'", "''", $quiz_data_row['quiz_answer'])));
				}
			}
			
		$template->pparse("quiz_edit");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
		
		if( $HTTP_GET_VARS['mode'] == 'delete' )
		{
			if( isset($HTTP_POST_VARS['delete']) )
			{
				if( quiz_type($quiz_id) == 'multiple_choice' )
				{
					$quiz_data_table = QUIZ_MULTIPLE_CHOICE_TABLE;
				}
				
				if( quiz_type($quiz_id) == 'input_answer' )
				{
					$quiz_data_table = QUIZ_INPUT_TABLE;
				}
			
				if( quiz_type($quiz_id) == 'true_false' )
				{
					$quiz_data_table = QUIZ_TRUE_FALSE_TABLE;
				}
				
				$delete_quiz = array();
				$delete_quiz[] = "DELETE FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_id = $quiz_id";
				$delete_quiz[] = "DELETE FROM " . QUIZ_STATISTICS_TABLE . " WHERE quiz_id = $quiz_id";
				$delete_quiz[] = "DELETE FROM $quiz_data_table WHERE quiz_id = $quiz_id";
			
				for ($d = 0; $d < count($delete_quiz); $d++) 
				{
					if(!$result = $db->sql_query($delete_quiz[$d]))
					{
						message_die(GENERAL_ERROR, 'Unable to delete quiz data', '', __LINE__, __FILE__, $delete_quiz[$d]);
					}
				}
				
			message_die(GENERAL_MESSAGE, $lang['Quiz_cp_deleted']);
			}
			
		$page_title = $lang['Quiz_cp_delete'];
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("quiz_del" => 'quiz_cp_delete_body.tpl'));
		
			$template->assign_vars( array(
			"F_FORM" => append_sid("quiz_cp.$phpEx?mode=delete&action=sql&" . POST_QUIZ_URL . "=$quiz_id"),
			
			"L_YES" => $lang['Quiz_admin_yes'],
			"L_SURE" => $lang['Quiz_cp_delete_sure'],
			"L_MCP" => $lang['Quiz_cp_delete']));
			
		$template->pparse("quiz_del");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
		
		if( $HTTP_GET_VARS['mode'] == 'move' )
		{
			if( $HTTP_GET_VARS['action'] == 'sql' )
			{
			$sql = "UPDATE " . QUIZ_GENERAL_TABLE . " SET quiz_category = " . intval($HTTP_POST_VARS['category']) . " WHERE quiz_id = $quiz_id";
					
				if(!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not update quiz category", "", __LINE__, __FILE__, $sql);
				}
			
				else
				{
					message_die(GENERAL_MESSAGE, $lang['Quiz_cp_move_sucess']);
				}
			}
			
		$page_title = $lang['Quiz_cp_move'];
		include($phpbb_root_path . "includes/page_header.$phpEx");
		$template->set_filenames(array("quiz_move" => 'quiz_cp_move_body.tpl'));
		
		// Taken directly from admin_quiz.php, line 251
		$sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE;
		$dropdown = "<select name='category'>";
		
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not find category data", __LINE__, __FILE__, $sql);
			}
			
			while($row = $db->sql_fetchrow($result))
			{
				$dropdown .= populate_quiz_drop_down_box($row['category_id'], $row['category_name']);
			}
		
		$dropdown .= '</select>';		
		
			$template->assign_vars( array(
			"F_FORM" => append_sid("quiz_cp.$phpEx?mode=move&action=sql&" . POST_QUIZ_URL . "=$quiz_id"),
			
			"U_DROPDOWN" => $dropdown,
			
			"L_MOVE" => $lang['Quiz_cp_move'],
			"L_MOVE_EXPLAIN" => $lang['Quiz_cp_move_explain'],
			"L_SUBMIT" => $lang['Submit']));
			
		$template->pparse("quiz_move");
		include($phpbb_root_path . "includes/page_tail.$phpEx");
		}
	}
?>