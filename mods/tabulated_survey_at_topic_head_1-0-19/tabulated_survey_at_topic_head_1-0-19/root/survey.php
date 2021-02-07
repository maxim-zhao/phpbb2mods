<?php
/***************************************************************************
 *                                survey.php
 *                            -------------------
 *   begin                : Sunday, Feb 06, 2005
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

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_POSTING);
init_userprefs($userdata);
//
// End session management
//

//
// define functions for the page

// the function below (copied from the php manual) reverses htmlspecialchars.  We need this
// so we can temporarily reverse htmlspecialchars in order to avoid having the script mistakenly
// think that semicolons at the end of htmlspecialchars like &amp;
// signal the start of a new selection in a checkbox, radio button or drop down menu question (but
// of course we restore htmlspecialchars when we reinsert the answer into the db)
function htmlspecialchars_uncode($str, $quote_style = ENT_COMPAT)
{
	return strtr($str, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
}

//
// the function below checks to see if there are any response caps for the survey (i.e. checks to see if there is anything in $questions_sums
// after stripping out all occurances of "|"); if so, the function explodes $question_sums (the method of totalling) and $response_caps and then
// figure out which questions have hit the cap; finally, the function returns an array that shows for each question whether that question
// can still be answered (for each question $i, if the 'ith' element of the returned array is TRUE the question can still be answered)
function what_questions_can_be_answered( $survey_info, $survey_id, $number_of_questions, $old_answers )
{
	global $db;
	// the first if clause checks to see if there are any response caps in the survey
	if( str_replace('|', '', $survey_info['question_response_caps']) )
	{
		// if we get here there are response caps in the survey, so we explode $question_sums and $response_caps so we can
		// figure out which questions have hit the cap
		$question_sums = explode("|", $survey_info['question_sums']);
		$question_selected_text = explode("|", $survey_info['question_selected_text']);
		$question_response_caps = explode("|", $survey_info['question_response_caps']);
		$group_ids = $survey_info['group_ids'];

		// get answers for this survey from all users
		// now do the query for the actual responses...
		$sql = "SELECT DISTINCT u.user_id, sa.answers
				FROM " . USERS_TABLE . " u
				INNER JOIN " . USER_GROUP_TABLE . " ug ON ug.user_id = u.user_id
				INNER JOIN " . SURVEY_ANSWERS_TABLE . " sa ON sa.user_id = ug.user_id
				WHERE ( (ug.group_id IN ($group_ids) AND ug.user_pending = 0) OR " . SURVEY_ALL_REGISTERED_USERS . " IN ($group_ids) )
				AND sa.survey_id = $survey_id";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain answer data for the survey in this topic", '', __LINE__, __FILE__, $sql);
		}

		// fetch all the answer info
		$answer_info = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		// count the number of responders
		$number_of_responders = count($answer_info);

		// cycle through the questions 1 by 1 in order to see if we've hit the cap for each question that has a cap
		for ( $i = 0; $i < $number_of_questions; $i++ )
		{
			if( $question_response_caps[$i] > 0 )
			{
				// if we get here, this question has a cap so loop through the responding users, get their answers and check against the relevant response cap
				for ( $j = 0; $j < $number_of_responders; $j++ )
				{
					// explode all the answers of this user into an answer array
					$answers = explode("|", $answer_info[$j]['answers']);

					// here, increment the total if the question is answered and supposed to be totalled at the bottom
					switch( $question_sums[$i] )
					{
						case "":
						case SURVEY_NO_TOTAL:
						case SURVEY_TOTAL_BY_AVERAGE_OF_NUMBERS_IN_REPSONSES:
							break;

						case SURVEY_TOTAL_BY_RESPONSES:
							if( $answers[$i] )
							{
								$total[$i]++;
							}
							break;

						case SURVEY_TOTAL_BY_NUMBERS_IN_RESPONSES:
							if( $answers[$i] )
							{
								$total[$i] = $total[$i] + $answers[$i];
							}
							break;

						case SURVEY_TOTAL_BY_MATCHING_TEXT:
							// note that I used strtolower to make this case insensitive
							if( strtolower($answers[$i]) == strtolower($question_selected_text[$i]) )
							{
								$total[$i]++;
							}
							break;
					}
				}
			}
		}
	}
	// now set a flag to indicate for each question whether it can still be answered (i.e. whether we've hit the response cap)
	for ( $i = 0; $i < $number_of_questions; $i++ )
	{
		$questions_can_be_answered[$i] = ( $question_response_caps[$i] == 0 || $total[$i] < $question_response_caps[$i] || $old_answers[$i] ) ? TRUE : FALSE;
	}
	return $questions_can_be_answered;
}

//
// Check and set various parameters
//
if( empty($HTTP_POST_VARS['topic_id']) && empty($HTTP_GET_VARS['topic_id']) ) message_die(GENERAL_MESSAGE, $lang['No_survey_topic_id_specified']);
else $topic_id = ( !empty($HTTP_POST_VARS['topic_id']) ) ? intval($HTTP_POST_VARS['topic_id']) : intval($HTTP_GET_VARS['topic_id']);
if( empty($HTTP_POST_VARS['survey_id']) && empty($HTTP_GET_VARS['survey_id']) ) message_die(GENERAL_MESSAGE, $lang['No_survey_id_specified']);
else $survey_id = ( !empty($HTTP_POST_VARS['survey_id']) ) ? intval($HTTP_POST_VARS['survey_id']) : intval($HTTP_GET_VARS['survey_id']);
$number_of_questions = intval($HTTP_POST_VARS['number_of_questions']);
$retrieve_answers_for_other_user = ( !empty($HTTP_POST_VARS['retrieve_answers_for_other_user']) ) ? TRUE : FALSE;
$fill_out_for_other_user = ( !empty($HTTP_POST_VARS['fill_out_for_other_user']) ) ? TRUE : FALSE;
$complete_for_self = ( $HTTP_POST_VARS['mode'] == 'complete_for_self' ) ? TRUE : FALSE;
$complete_for_other_user = ( $HTTP_POST_VARS['mode'] == 'complete_for_other_user' ) ? TRUE : FALSE;
// if we are net getting here to retrieve for other user or fill out for other user or complete for self
// or other user, must be to fill out for self so set that flag...
$fill_out_for_self = ( !$retrieve_answers_for_other_user && !$fill_out_for_other_user && !$complete_for_self &&!$complete_for_other_user ) ? TRUE : FALSE;
$user_id = $userdata['user_id'];

// if filling out or retrieving for other user, get rid of any completion flag (since the retrieve button has the hidden fields that include the 'complete' mode) and reset $user_id
if( $fill_out_for_other_user || $retrieve_answers_for_other_user )
{
	$complete_for_self = FALSE;
	$complete_for_other_user = FALSE;
	$user_id = '';
}
// or, if we are completing for other user, reset $user_id
else if ( $complete_for_other_user ) $user_id = '';

// now get question data
$sql = "SELECT survey_caption, group_ids, questions, question_types, question_selections, question_sums, question_selected_text, question_response_caps FROM " . SURVEY_TABLE . "
		WHERE survey_id = $survey_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain survey data for this topic", '', __LINE__, __FILE__, $sql);
}
$survey_info = $db->sql_fetchrow($result);
$db->sql_freeresult($result);

// if this is an admin, check to see if he is answering for another user and if so, set $user_id to that user's id and $username to that user's username
if ( $userdata['user_level'] == ADMIN && ( $retrieve_answers_for_other_user || $complete_for_other_user ) )
{
	// note that we limit the search of allowable users to those in groups designated to answer this survey
	$username = phpbb_clean_username($HTTP_POST_VARS['username']);
	$username = str_replace("\'", "''", $username);
	$group_ids = $survey_info['group_ids'];
	$sql = "SELECT u.user_id, u.username
			FROM " . USERS_TABLE . " u
			INNER JOIN " . USER_GROUP_TABLE . " ug ON ug.user_id = u.user_id
			WHERE ( (ug.group_id IN ($group_ids) AND ug.user_pending = 0) OR " . SURVEY_ALL_REGISTERED_USERS . " IN ($group_ids) )
			AND u.username = '$username'
			AND u.user_id <> " . ANONYMOUS . "
			LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not look up user name from users table", '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	$user_id = $row['user_id'];
	$username = $row['username'];
	if ( $username == '' ) message_die(GENERAL_MESSAGE, $lang['No_such_user_authorized_for_survey']);
}


// check to see if this is a user that has already answered the survey
// and if so, retrieve the old answers and set $user_already_answered to TRUE; if not, set $user_already_answered to FALSE;
// but don't check when a user is filling out for other and hasn't yet hit retrieve answers for other since in that case there will be no $user_id)
$old_answers = '';
$sql = "SELECT answers FROM " . SURVEY_ANSWERS_TABLE . "
		WHERE survey_id = $survey_id
		AND user_id = $user_id
		LIMIT 1";
$result = $db->sql_query($sql);
$old_answers = $db->sql_fetchrow($result);
if ( $old_answers != '' )
{
	$old_answers = explode("|", $old_answers['answers']);
	$user_already_answered = TRUE;
}
else $user_already_answered = FALSE;
$db->sql_freeresult($result);

//
// check to see if user has submitted the answers (i.e. if the user has clicked submit to submit his answers); if so, insert the answers in the SURVEY_ANSWER_TABLE
//
if( $complete_for_self || $complete_for_other_user )
{
	// run function to check to see if there are any response caps for this survey and, if so,
	// figure out which questions can still be answered versus which ones have hit the cap and cannot be answered
	$questions_can_be_answered = what_questions_can_be_answered( $survey_info, $survey_id, $number_of_questions, $old_answers );

	// now fetch the question types and selections so that we can treat multiple chocie selections specially
	$question_types = explode("|", $survey_info['question_types']);

	// collect the answers the user has specified
	for( $i=0; $i<$number_of_questions; $i++)
	{
		// when we are looking at answers to muliple choice checkboxes we need to loop through to compile the full answer so we'll treat that specially...
		if( $question_types[$i] == SURVEY_MULTIPLE_CHOICE_CHECKBOXES )
		{
			$answer[$i] = '';
			$answer_array = ( !empty($HTTP_POST_VARS['answer' . $i]) ) ? $HTTP_POST_VARS['answer' . $i] : '';
			for ($j = 0; $j < count($answer_array); $j++ )
			{
				$temp = ( isset($answer_array[$j]) ) ? htmlspecialchars($answer_array[$j]) : '';
				$temp = str_replace("\'", "''", $temp);
				// separate each selection in the answer to a given question by '&&'
				$answer[$i] .= ($answer[$i]) ? '&&' . $temp : $temp;
			}
		}
		else
		{
			$answer[$i] = ( isset($HTTP_POST_VARS['answer'][$i]) ) ? htmlspecialchars($HTTP_POST_VARS['answer'][$i]) : '';
			$answer[$i] = str_replace("\'", "''", $answer[$i]);
			// since questions get separated in the db by '|', we change '|' to '/' in the answer so that 
			// if the user inserts a '|' in the text the code won't mistakenly think what follows is the answer to another question 
			$answer[$i] = str_replace("|", "/", $answer[$i]);
		}

		// test to see if any question is being answered for which the answer cap has already been hit
		if( $answer[$i] && !$questions_can_be_answered[$i] )
		{
			$msg = $lang['Sorry_question_cap_hit'] . '<br /><br />' . sprintf($lang['Click_return_topic_survey'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a> ') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $msg);
		}
	}
	$answers = implode('|', $answer);

	// now insert the answers into the database
	// but first figure out the last response order so this user will show up as having a response order that is 1 higher
	$sql = "SELECT response_order
			FROM " . SURVEY_ANSWERS_TABLE . "
			WHERE survey_id = $survey_id
			ORDER BY response_order
			DESC
			LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not get last response order number from the survey answers table", '', __LINE__, __FILE__, $sql);
	}
	$response_order = $db->sql_fetchrow($result);
	$current_response_order = $response_order['response_order'] + 1;
	$db->sql_freeresult($result);

	// now insert the new entry or update the old one into the answer table
	if( !$user_already_answered )
	{
		$sql = "INSERT INTO " . SURVEY_ANSWERS_TABLE . " (survey_id, user_id, response_order, first_answer, answers)
				VALUES ($survey_id, $user_id, $current_response_order, '$answer[0]', '$answers')";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not insert new answers into the survey answers table", '', __LINE__, __FILE__, $sql);
		}
	}
	else
	{
		$sql = "UPDATE " . SURVEY_ANSWERS_TABLE . "
				SET first_answer = '$answer[0]', answers = '$answers'
				WHERE survey_id = $survey_id AND user_id = $user_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not update answer info in the survey answers table", '', __LINE__, __FILE__, $sql);
		}
	}
	redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
}


// if we get here, that's because the user has not submitted the answers yet; but note that this may be an initial
// answer of the survey or it may be an edit of a prior round of anwswers (if it is an edit then $user_already_answered will be TRUE)

// place questions into arrays and set the number of questions variable
$questions = explode("|", $survey_info['questions']);
$question_types = explode("|", $survey_info['question_types']);
$question_selections = explode("|", $survey_info['question_selections']);
$number_of_questions = count($questions);

// run function to check to see if there are any response caps for this survey and, if so,
// figure out which questions can still be answered versus which ones have hit the cap and should be hidden
$questions_can_be_answered = what_questions_can_be_answered( $survey_info, $survey_id, $number_of_questions, $old_answers );

//
// Lets build a page ...
//
$page_title = $lang['Survey'];
make_jumpbox('viewforum.'.$phpEx);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// now specify the template the questions and answers will be shown on
$template->set_filenames(array(
'body' => 'survey_answer.tpl')
);

// next, send the questions and answer blanks to the template (but only if show_question is TRUE which indicates we haven't hit a response cap)
for ( $i = 0; $i < $number_of_questions; $i++ )
{
	if ( $questions_can_be_answered[$i] )
	{
		$answer='';
		switch( $question_types[$i] )
		{
			case SURVEY_SMALL_TEXT_BLANK:
				$answer = '<input class="post" type="text" maxlength="50" size="20" name="answer[' . $i . ']" value="' . $old_answers[$i] . '" />';
				break;

			case SURVEY_LARGE_TEXT_BLANK:
				$answer = '<input class="post" type="text" maxlength="255" size="100" name="answer[' . $i . ']" value="' . $old_answers[$i] . '" />';
				break;

			case SURVEY_TEXT_BOX:
				$answer = '<textarea name="answer[' . $i . ']" rows="3" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post">' . $old_answers[$i] . '</textarea>';
				break;

			case SURVEY_CHECKBOX_OR_RADIO_BUTTONS:
				// since htmlspecial chars like & get saved in db with a semicolon at the end (e.g. &amp;) and the semicolon
				// is used in this mod to mark where a selection ends and a new one begins, we need to unconvert htmlspecial chars in order to avoid confusing the script 
				$selection_string = htmlspecialchars_uncode($question_selections[$i]);
				$selections = explode(";", $selection_string);
				for ($j = 0; $j < count($selections); $j++ )
				{
				$checked = ( $old_answers[$i] == htmlspecialchars($selections[$j]) ) ? 'checked="checked"' : '';
				$answer = ( count($selections) == 1 ) ? $answer . '<input class="post" type="checkbox" name="answer[' . $i . ']" value="' . htmlspecialchars($selections[$j]) . '" ' . $checked . ' />' . $selections[$j] . '<br />' : $answer . '<input class="post" type="radio" name="answer[' . $i . ']" value="' . htmlspecialchars($selections[$j]) . '" ' . $checked . ' />' . $selections[$j] . '<br />';
				}
				break;

			case SURVEY_MULTIPLE_CHOICE_CHECKBOXES:
				// since htmlspecial chars like & get saved in db with a semicolon at the end (e.g. &amp;) and the semicolon
				// is used in this mod to mark where a selection ends and a new one begins, we need to unconvert htmlspecial chars in order to avoid confusing the script 
				$selection_string = htmlspecialchars_uncode($question_selections[$i]);
				$selections = explode(";", $selection_string);
				// stick '&&' at beginning and end of the old answer string for this question so that we can test whether a particular selection surrounded by '&&' matches
				// answer selection surrounded by '&&' (otherwise the first and last selections in the question will not be treated properly) 
				$old_answers_in_amps = '&&' . $old_answers[$i] . '&&';
				for ($j = 0; $j < count($selections); $j++ )
				{
				$checked = ( strpos( $old_answers_in_amps, '&&' . htmlspecialchars($selections[$j]) . '&&' ) !== false ) ? 'checked="checked"' : '';
				$answer = $answer . '<input class="post" type="checkbox" name="answer' . $i . '[]" value="' . htmlspecialchars($selections[$j]) . '" ' . $checked . ' />' . $selections[$j] . '<br />';
				}
				break;

			case SURVEY_DROP_DOWN_MENU:
				// since htmlspecial chars like & get saved in db with a semicolon at the end (e.g. &amp;) and the semicolon
				// is used in this mod to mark where a selection ends and a new one begins, we need to unconvert htmlspecial chars in order to avoid confusing the script 
				$selection_string = htmlspecialchars_uncode($question_selections[$i]);
				$selections = explode(";", $selection_string);
				$answer = '<select name="answer[' . $i . ']" size="1" class="gensmall">';
				for ($j = 0; $j < count($selections); $j++ )
				{
				$selected = ( $old_answers[$i] == htmlspecialchars($selections[$j]) ) ? 'selected="selected"' : '';
				$answer = $answer . '<option value="' . htmlspecialchars($selections[$j]) . '" ' . $selected . ' />&nbsp;' . $selections[$j] . '&nbsp;</option>';
				}
				$answer = $answer . '</select>';
				break;
		}
	}
	else
	{
		$answer = $lang['Sorry_enough_responses'];
	}

	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

	$template->assign_block_vars("question_rows", array(
		'ROW_COLOR' => '#' . $row_color,
		'ROW_CLASS' => $row_class,
		'QUESTION' => $questions[$i],
		'ANSWER' => $answer
		)
	);
}

// now, send other info to the template (name of survey, total responses, etc)
$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '" /><input type="hidden" name="survey_id" value="' . $survey_id . '" /><input type="hidden" name="number_of_questions" value="' . $number_of_questions . '" />';
$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= ( $fill_out_for_self ) ? '<input type="hidden" name="mode" value="complete_for_self" />' : '<input type="hidden" name="mode" value="complete_for_other_user" />';

// test to see if the user is an admin who got here by clicking the fill out for another user button...if so, display a user selection box
if( $userdata['user_level'] == ADMIN && ( $fill_out_for_other_user || $retrieve_answers_for_other_user ) )
{
	$template->assign_block_vars('switch_username_select', array());
}

// if the user clicked to retrieve answers for another user, let him know whether that other user has already answered the survey...
if ( $retrieve_answers_for_other_user )
{
	$other_user_answered_or_not = ( $user_already_answered ) ? $username . $lang['other_user_answers_below'] : $username . '&nbsp;' . $lang['other_user_not_answered'];
}

$template->assign_vars(array(
	'SURVEY_CAPTION' => $survey_info['survey_caption'],

	'L_SUBMIT' => $lang['Submit'],
	'L_SENDING' => $lang['Sending'],
	'L_USERNAME_TAKING_SURVEY' => $lang['Username_taking_survey'],
	'L_FIND_USERNAME' => $lang['Find_username'],
	'L_RETRIEVE_ANSWERS_FOR_OTHER_USER' => $lang['Retrieve_answers_for_other_user'],

	'OTHER_USER' => $username,
	'OTHER_USER_ANSWERED_OR_NOT' => $other_user_answered_or_not,

	'U_SEARCH_USER' => append_sid("search.$phpEx?mode=searchuser"),

	'S_HIDDEN_FIELDS' => $s_hidden_fields,
	'S_ANSWER_ACTION' => append_sid("survey.$phpEx")
	)
);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>