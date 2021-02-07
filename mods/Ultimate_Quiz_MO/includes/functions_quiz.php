<?php
/***************************************************************************
 *                               functions_quiz.php
 *                            -------------------
 *   begin                : Mon, June 6, 2005
 *   copyright          : (C) 2005 Battye @ CricketMX.com
 *   email                : cricketmx@hotmail.com
 *
 *   $Id: functions_quiz.php, v1 (June 2005) battye Exp $
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

function quiz_new_stats_id()
{
global $db;

	$sql = "SELECT stats_id FROM " . QUIZ_STATISTICS_TABLE . " ORDER BY stats_id DESC LIMIT 1";
	
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain the user id', __LINE__, __FILE__, $sql);
	}
	
	$row = $db->sql_fetchrow($result);
	
return ($row['stats_id'] + 1);
}
	
 
function quiz_check_moderative_status($user_id, $quiz_id)
{
global $db, $board_config, $userdata;	
	
$users = explode(',', $board_config['Quiz_Moderators']);

	for( $o = 0; $o < count($users); $o++ )
	{
		if( intval($user_id) == intval($users[$o]) )
		{
			$quiz_moderator = ON;
		}
	}
	
	if( $userdata['user_level'] == ADMIN )
	{
		$quiz_moderator = ON;
	}

	if( $board_config['Quiz_Author_Mod'] == ON )
	{
		$sql = "SELECT quiz_author FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_id = '$quiz_id'";
		
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, '', 'Could not obtain the user id', __LINE__, __FILE__, $sql);
		}
		
		$row = $db->sql_fetchrow($result);

		if( $row['user_id'] == intval($user_id) )
		{
			$quiz_moderator = ON;
		}
	}
	
	if( $quiz_moderator != ON )
	{
		$quiz_moderator = OFF;
	}
	
return $quiz_moderator;	
}

function quiz_check_question_limitations()
{
global $quiz_questions_explode, $lang, $HTTP_POST_VARS;

	if( $HTTP_POST_VARS['Questions_number'] > $quiz_questions_explode[1] || $HTTP_POST_VARS['Questions_number'] < $quiz_questions_explode[0] )
	{
		message_die(GENERAL_ERROR, $lang['Quiz_min_max_exceed']);		
	}
}

function quiz_category_password($id)
{
global $db;

$sql = "SELECT category_password FROM " . QUIZ_CATEGORY_TABLE . " WHERE category_id = " . intval($id);
		
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain quiz category password', __LINE__, __FILE__, $sql);
	}
	
	$row = $db->sql_fetchrow($result);
	
return $row['category_password'];
}

function quiz_check_category_password($id)
{
global $userdata;

$session_quiz_categories = explode(",", $userdata['session_quiz_categories']);

	for ( $z = 0; $z < count($session_quiz_categories); $z++ )
	{
		if( $session_quiz_categories[$z] == intval($id) )
		{
			$access_accepted = ON;
		}
	}
	
return $access_accepted;
}
 
function switch_to_category_name($id)
{
global $db;

$sql = "SELECT category_name FROM " . QUIZ_CATEGORY_TABLE . " WHERE category_id = " . intval($id);
		
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain quiz category data', __LINE__, __FILE__);
	}
	
	$row = $db->sql_fetchrow($result);
	
return $row['category_name'];
}
 
function category_quizzes($id)
{
global $db;

$sql = "SELECT * FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_category = " . intval($id);
		
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain quiz category data', __LINE__, __FILE__);
	}
	
return $db->sql_numrows($result);
}

function number_of_questions($id, $table)
{
global $db;
 
$sql = "SELECT quiz_id FROM " . $table . " WHERE quiz_id = " . intval($id);
	
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not count rows', __LINE__, __FILE__);
	}

return $db->sql_numrows($result);
}

function quiz_answer($question_id, $quiz_id, $table)
{
global $db;
 
$sql = "SELECT quiz_answer FROM " . $table . " WHERE question_id = " . intval($question_id) . " AND quiz_id = " . $quiz_id;
	
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not get answer', __LINE__, __FILE__);
	}
	
$row = $db->sql_fetchrow($result);
return $row['quiz_answer'];
}

function convert_id($user_id)
{
global $db;

$sql = "SELECT username FROM " . USERS_TABLE . " WHERE user_id = " . intval($user_id) . " LIMIT 1";
	
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not find user id', __LINE__, __FILE__);
	}
	
	$row = $db->sql_fetchrow($result);
	
return $row['username'];
}

function quiz_type($quiz_id)
{
global $lang, $db;

	$sql = "SELECT quiz_type FROM " . QUIZ_GENERAL_TABLE . " WHERE quiz_id = " . intval($quiz_id);

	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', 'Could not obtain quiz type from QUIZ_GENERAL_TABLE', __LINE__, __FILE__);
	}
	
	$row = $db->sql_fetchrow($result);
	
	return $row['quiz_type'];
}
 
function quiz_permissions()
{
global $board_config, $lang, $userdata;
				
	if($board_config['Quiz_Register_Play'] == ON) // If this is OFF, basically it means Guests can play quizzes.
	{
		if(!$userdata['session_logged_in'])
		{
			return message_die(GENERAL_MESSAGE, $lang['Quiz_must_be_registered']);
		}
	}
		
	if($board_config['Quiz_Post_Count_Play'] == ON)
	{
		if($userdata['user_posts'] < $board_config['Quiz_Post_Requirement'])
		{
			return message_die(GENERAL_MESSAGE, sprintf($lang['Quiz_post_requirement_not_met'], intval($board_config['Quiz_Post_Requirement'])));
		}
	}
}
 
function next_quiz_id()
{
global $db;

$sql = "SELECT quiz_id FROM " . QUIZ_GENERAL_TABLE . " ORDER BY quiz_id DESC LIMIT 1";
			
	if( !$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not find last quiz_id', '', __LINE__, __FILE__, $sql);
	}
	
	while($row = $db->sql_fetchrow($result))
	{
		$id = $row['quiz_id'] + 1;
	}
	
	if(!$id)
	{
		$id = 1;
	}
	
return intval($id);
}

function populate_quiz_drop_down_box($category_id, $category_name)
{
global $lang;

$dropdown_box = '<option value=' . $category_id . '">' . $lang['Category'] . ': ' . $category_name . '</option>';
return $dropdown_box;
}
?>