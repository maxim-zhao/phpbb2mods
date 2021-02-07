<?php
/***************************************************************************
 *                               admin_quiz.php
 *                            -------------------
 *   begin                : Wednesday, Aug 25, 2004
 *   copyright          : (C) 2004 Battye @ CricketMX.com
 *   email                : cricketmx@hotmail.com
 *
 *   $Id: admin_quiz.php, v1.000.0.00 2004/08/24 22:53:47 battye Exp $
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

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Quiz'] = $filename;

	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . "includes/functions_quiz.$phpEx");
require('./pagestart.' . $phpEx);

	$language = $board_config['default_lang'];
	
	if (!file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_quiz.' . $phpEx))
	{
		$language = 'english';
	}
	
	include($phpbb_root_path . 'language/lang_' . $language . '/lang_quiz.' . $phpEx);

// Define the mode we are in

	if($HTTP_GET_VARS['mode'] == "submit" && isset($HTTP_POST_VARS))
	{
	// While this is long, it is the most efficient way to do it at this point in time. It is also the same way the phpBB dev's run a lot of queries, in update_to_latest.php :-D
	$sql = array();

		if($HTTP_POST_VARS['Quiz_Register_Play'] == ON )
		{
			$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_Post_Count_Play']) . " WHERE config_name = 'Quiz_Post_Count_Play'";
			$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_Post_Requirement']) . " WHERE config_name = 'Quiz_Post_Requirement'";
		}
	
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_Author_Play']) . " WHERE config_name = 'Quiz_Author_Play'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_show_answers']) . " WHERE config_name = 'Quiz_show_answers'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_Register_Play']) . " WHERE config_name = 'Quiz_Register_Play'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_Play_Once']) . " WHERE config_name = 'Quiz_Play_Once'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['Quiz_Min_Max_Questions'])) . "' WHERE config_name = 'Quiz_Min_Max_Questions'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['Quiz_Moderators'])) . "' WHERE config_name = 'Quiz_Moderators'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['Quiz_Banned'])) . "' WHERE config_name = 'Quiz_Banned'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['Quiz_Author_Mod'])) . "' WHERE config_name = 'Quiz_Author_Mod'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_Stats_Display']) . " WHERE config_name = 'Quiz_Stats_Display'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_Mod_Submit']) . " WHERE config_name = 'Quiz_Mod_Submit'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_CashMOD_On']) . " WHERE config_name = 'Quiz_CashMOD_On'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_CashMOD_On']) . " WHERE config_name = 'Quiz_CashMOD_On'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_admin_cash_correct']) . " WHERE config_name = 'Quiz_Cash_Correct'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_admin_cash_incorrect']) . " WHERE config_name = 'Quiz_Cash_Incorrect'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['Quiz_admin_cash_tax']) . " WHERE config_name = 'Quiz_Cash_Tax'";
	$sql[] = "UPDATE " . CONFIG_TABLE . " SET config_value = " . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['Quiz_admin_cash_currency'])) . " WHERE config_name = 'Quiz_Cash_Currency'";
				
		for ($i = 0; $i < count($sql); $i++) 
		{
			if(!$result = $db->sql_query($sql[$i]))
			{
				message_die(GENERAL_ERROR, "Query $i did not execute correctly", "", __LINE__, __FILE__, $sql[$i]);
			}
		}
		
	message_die(GENERAL_MESSAGE, sprintf($lang['Quiz_admin_configuration_updated'], '<a href="' . append_sid("admin_quiz.$phpEx") . '">', '</a>'));
	}
	
	if( $HTTP_GET_VARS['mode'] == "category" )
	{
	$category_id = intval($HTTP_GET_VARS['id']);

		if($HTTP_GET_VARS['action'] == "add")
		{
			if($HTTP_GET_VARS['ask'] == "true")
			{
			$sql = "SELECT category_id FROM " . QUIZ_CATEGORY_TABLE . " ORDER BY category_id DESC LIMIT 1";

				if(!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not find category id", "", __LINE__, __FILE__, $sql);
				}
			
			$row = $db->sql_fetchrow($result);
			$category_password = ( isset($HTTP_POST_VARS['password']) ) ? md5($HTTP_POST_VARS['password']) : '';
			$new_id = ($row['category_id'] + 1);
			
			$new_category = "INSERT INTO " . QUIZ_CATEGORY_TABLE . " (category_id, category_name, category_description, category_password, category_permissions) VALUES ($new_id, '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['name'])) . "', '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['description'])) . "', '" . $category_password . "', " . intval($HTTP_POST_VARS['permissions']) . ")";
						
				if( !$db->sql_query($new_category) )
				{
					message_die(GENERAL_ERROR, "Could not find make new category", "", __LINE__, __FILE__, $new_category);
				}
				
				else
				{
					message_die(GENERAL_MESSAGE, $lang['Quiz_admin_new_category_successful']);
				}
			}
			
			$template->set_filenames(array("quiz_add" => "admin/quiz_add_category_body.tpl"));
		
			$template->assign_vars( array(
			"F_FORM" => append_sid("admin_quiz.$phpEx?mode=category&action=add&ask=true"),
			
			"L_CHOOSE_PER" => $lang['Quiz_admin_category_permissions_choose'],
			"L_GUEST" => $lang['Quiz_admin_category_guest'],
			"L_REG" => $lang['Quiz_admin_category_registered'],
			"L_REG_HIDDEN" => $lang['Quiz_admin_category_registered_hidden'],
			
			"L_ADD" => $lang['Quiz_admin_cat_add'],
			"L_SUBMIT" => $lang['Submit'],
			"L_PASSWORD" => $lang['Quiz_admin_password_protect'],
			"L_DESCRIPTION" => $lang['Quiz_admin_description'],
			"L_NAME" => $lang['Quiz_admin_name'],
			"L_EXPLAINATION" => $lang['Quiz_admin_add_explanation'],
			"L_EDITING" => $lang['Quiz_admin_add']));
			
			$template->pparse("quiz_add");
			include("page_footer_admin.$phpEx");		
		}
	
		if($HTTP_GET_VARS['action'] == "edit")
		{
		$category_password = ( isset($HTTP_POST_VARS['password']) ) ? md5($HTTP_POST_VARS['password']) : '';
		
			if($HTTP_GET_VARS['ask'] == "true")
			{
			$sql = "UPDATE " . QUIZ_CATEGORY_TABLE . " SET category_name = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['name'])) . "', category_description = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['description'])) . "', category_password =  '" . $category_password . "', category_permissions = " . intval($HTTP_POST_VARS['permissions']) . " WHERE category_id = $category_id";

				if(!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not update category", "", __LINE__, __FILE__, $sql);
				}
				
				else
				{
					message_die(GENERAL_MESSAGE, $lang['Quiz_admin_category_update_successful']);
				}
			}
			
		$template->set_filenames(array("quiz_edit" => "admin/quiz_edit_category_body.tpl"));
		
		$sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE . " WHERE category_id = $category_id";
				
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not find category", "", __LINE__, __FILE__, $sql);
			}
			
			$row = $db->sql_fetchrow($result);
			
			$category_name = str_replace("\''", "''", $row['category_name']);
			$category_description = str_replace("\'", "''", $row['category_description']);
			
			$template->assign_vars( array(
			"U_NAME" => $category_name,
			"U_DESCRIPTION" => $category_description,
			
			"F_FORM" => append_sid("admin_quiz.$phpEx?mode=category&action=edit&ask=true&id=$category_id"),
			
			"L_CHOOSE_PER" => $lang['Quiz_admin_category_permissions_choose'],
			"L_GUEST" => $lang['Quiz_admin_category_guest'],
			"L_REG" => $lang['Quiz_admin_category_registered'],
			"L_REG_HIDDEN" => $lang['Quiz_admin_category_registered_hidden'],			
			
			"L_PASSWORD" => $lang['Quiz_admin_password_protect'],
			"L_SUBMIT" => $lang['Submit'],
			"L_DESCRIPTION" => $lang['Quiz_admin_description'],
			"L_NAME" => $lang['Quiz_admin_name'],
			"L_EXPLAINATION" => $lang['Quiz_admin_edit_explanation'],
			"L_EDITING" => $lang['Quiz_admin_editing']));
			
			$template->pparse("quiz_edit");
			include("page_footer_admin.$phpEx");		
		}
		
		if($HTTP_GET_VARS['action'] == "move")
		{
			if($HTTP_GET_VARS['ask'] == "true")
			{
			$sql = "UPDATE " . QUIZ_GENERAL_TABLE . " SET quiz_category = " . intval($HTTP_POST_VARS['category']) . "
			WHERE quiz_category = $category_id";
			
				if(!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not delete category", "", __LINE__, __FILE__, $sql);
				}
				
				else
				{
					message_die(GENERAL_MESSAGE, $lang['Quiz_admin_move_category_successful']);
				}
			}
			
		$template->set_filenames(array("quiz_cat_move" => "admin/quiz_move_category_body.tpl"));
		$sql = "SELECT * FROM " . QUIZ_CATEGORY_TABLE;
		$dropdown = "<select name='category'>";
		
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not find category data", "", __LINE__, __FILE__, $sql);
			}
			
			while($row = $db->sql_fetchrow($result))
			{
				$dropdown .= populate_quiz_drop_down_box($row['category_id'], $row['category_name']);
			}
		
		$dropdown .= '</select>';
		
		$template->assign_vars( array(
			"U_DROPDOWN" => $dropdown,
			
			"F_FORM" => append_sid("admin_quiz.$phpEx?mode=category&action=move&ask=true&id=$category_id"),
			
			"L_SUBMIT" => $lang['Submit'],
			"L_MOVE" => $lang['Quiz_admin_cat_move'],
			"L_MOVE_TO_WHERE" => $lang['Quiz_admin_cat_move_to_category']));
			
		$template->pparse("quiz_cat_move");
		include("page_footer_admin.$phpEx");
		}
		
		if($HTTP_GET_VARS['action'] == "delete")
		{
			if($HTTP_GET_VARS['ask'] == "true")
			{
			$sql = "DELETE FROM " . QUIZ_CATEGORY_TABLE . " WHERE category_id = $category_id";
			
				if(!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not delete category", "", __LINE__, __FILE__, $sql);
				}
			}
			
			else
			{
				message_die(GENERAL_MESSAGE, sprintf($lang['Quiz_admin_delete_category'], append_sid("admin_quiz.$phpEx?mode=category&action=delete&ask=true&id=$category_id")));
			}
		}
	}
		
$template->set_filenames(array("quiz_admin" => "admin/quiz_settings_body.tpl"));

// Permissions
$quiz_register_to_play_on = ( $board_config['Quiz_Register_Play'] == ON ) ? "checked=\"checked\"" : "";
$quiz_register_to_play_off = ( $board_config['Quiz_Register_Play'] == OFF ) ? "checked=\"checked\"" : ""; // No guests basically

$quiz_post_count_on = ( $board_config['Quiz_Post_Count_Play'] == ON ) ? "checked=\"checked\"" : "";
$quiz_post_count_off = ( $board_config['Quiz_Post_Count_Play'] == OFF ) ? "checked=\"checked\"" : "";

$quiz_author_mod_on = ( $board_config['Quiz_Author_Mod'] == ON ) ? "checked=\"checked\"" : "";
$quiz_author_mod_off = ( $board_config['Quiz_Author_Mod'] == OFF ) ? "checked=\"checked\"" : "";

$quiz_mod_submitters_on = ( $board_config['Quiz_Mod_Submit'] == ON ) ? "checked=\"checked\"" : "";
$quiz_mod_submitters_off = ( $board_config['Quiz_Mod_Submit'] == OFF ) ? "checked=\"checked\"" : "";

$quiz_moderators = str_replace("\'", "''", $board_config['Quiz_Moderators']);
$quiz_banned = str_replace("\'", "''", $board_config['Quiz_Banned']);

$quiz_minimum_post_requirement = $board_config['Quiz_Post_Requirement'];
$quiz_stats_display = intval($board_config['Quiz_Stats_Display']);
	
// General Settings
$quiz_show_answers_on = ( $board_config['Quiz_show_answers'] == ON ) ? "checked=\"checked\"" : "";
$quiz_show_answers_off = ( $board_config['Quiz_show_answers'] == OFF ) ? "checked=\"checked\"" : ""; // Show answers after playing?

$quiz_play_once_on = ( $board_config['Quiz_Play_Once'] == ON ) ? "checked=\"checked\"" : "";
$quiz_play_once_off = ( $board_config['Quiz_Play_Once'] == OFF ) ? "checked=\"checked\"" : ""; // Users can only play each quiz once?

$quiz_author_play_on = ( $board_config['Quiz_Author_Play'] == ON ) ? "checked=\"checked\"" : ""; 
$quiz_author_play_off = ( $board_config['Quiz_Author_Play'] == OFF ) ? "checked=\"checked\"" : ""; // Can the author play? OFF = NO.

$quiz_cash_on = ( $board_config['Quiz_CashMOD_On'] == ON ) ? "checked=\"checked\"" : ""; 
$quiz_cash_off = ( $board_config['Quiz_CashMOD_On'] == OFF ) ? "checked=\"checked\"" : ""; // Cash enabled? OFF = NO.

$quiz_min_max_questions = str_replace("\'", "''", $board_config['Quiz_Min_Max_Questions']);

// Advanced Cash

	if( $board_config['Quiz_CashMOD_On'] == ON )
	{
		$template->assign_block_vars('cash_row', array()); // Initialize the whole cash thing.. sigh. Bloody boring this is lol
		$quiz_cash_correct = intval($board_config['Quiz_Cash_Correct']);
		$quiz_cash_incorrect = intval($board_config['Quiz_Cash_Incorrect']);
		$quiz_cash_tax = intval($board_config['Quiz_Cash_Tax']);
		$quiz_cash_currency = str_replace("\'", "''", $board_config['Quiz_Cash_Currency']);
		
		$template->assign_vars( array(
		"U_C_CORRECT" => $quiz_cash_correct,
		"U_C_INCORRECT" => $quiz_cash_incorrect,
		"U_C_TAX" => $quiz_cash_tax,	
		"U_C_CURRENCY" => $quiz_cash_currency,
		
		"L_C_CORRECT" => $lang['Quiz_admin_cash_correct'],
		"L_C_INCORRECT" => $lang['Quiz_admin_cash_incorrect'],
		"L_C_TAX" => $lang['Quiz_admin_cash_taxation'],
		"L_C_CURRENCY" => $lang['Quiz_admin_cash_currency'])); // I'm still bored
		
		// Don't believe me? I'll type out the lyrics to the song I'm listening to. The beginning is coming up.. very soon.. 10 seconds max.. here we go
		// When I look back upon my life it's always with a sense of shame ... give up ... no matter when or where or who, theres only ... give up ... It's a sin, It's a sin, everything
		// i've ever done, everything I ever do, It's a, It's a, It's a sin ... give up ... no matter when or where or who ... give up ... it's a sin, it's a sin, it's a sin ... 
		
		// I never realised it was this repetitive around the chorus.. lol
		// Guess what the song is.. AND DON'T GOOGLE IT!!
		// Answer can be found somewhere below.. somewhere ;-)
		// I just made this script 8 lines longer. Go me.
	}

// Categories
$categories = "SELECT * FROM " . QUIZ_CATEGORY_TABLE;

	if(!$cat_result = $db->sql_query($categories))
	{
		message_die(GENERAL_ERROR, "Could not get category data", "", __LINE__, __FILE__, $categories);
	}
	
	while($cat_row = $db->sql_fetchrow($cat_result))
	{
		$category_id = intval($cat_row['category_id']);
		$category_name = str_replace("\'", "''", $cat_row['category_name']) . ' ' . sprintf($lang['Quiz_admin_number_quizzes'], category_quizzes($category_id));
		$category_description = str_replace("\'", "''", $cat_row['category_description']);
		
			$template->assign_block_vars('category_row', array(
			"U_ID" => $category_id,
			"U_NAME" => $category_name,
			"U_DESCRIPTION" => $category_description,
			"U_EDIT_CATEGORY" => "<a href='" . append_sid("admin_quiz.$phpEx?mode=category&action=edit&id=$category_id") . "'>" . $lang['Quiz_admin_cat_edit'] . "</a>",
			"U_DELETE_CATEGORY" => "<a href='" . append_sid("admin_quiz.$phpEx?mode=category&action=delete&id=$category_id") . "'>" . $lang['Quiz_admin_cat_delete'] . "</a>",
			"U_MOVE_CATEGORY" => "<a href='" . append_sid("admin_quiz.$phpEx?mode=category&action=move&id=$category_id") . "'>" . $lang['Quiz_admin_cat_move'] . "</a>",
			));
	}
	
	// Just to tell the user the latest version. What a pain, file_get_contents() isn't compatible with anything below 4.3.. oh well, file() it is then.
	$update_file = array();
	$update_file = file("http://www.cmxmods.net/quiz_latest.txt");

	$template->assign_vars( array(
	"U_ON" => ON,
	"U_OFF" => OFF,
	
	"U_ADD_CATEGORY" => "<a href='" . append_sid("admin_quiz.$phpEx?mode=category&action=add") . "'>" . $lang['Quiz_admin_cat_add'] . "</a>",
	
	"U_SHOW_ANSWERS_ON" => $quiz_show_answers_on,
	"U_SHOW_ANSWERS_OFF" => $quiz_show_answers_off,
	
	"U_MOD_SUBMIT_ON" => $quiz_mod_submitters_on,
	"U_MOD_SUBMIT_OFF" => $quiz_mod_submitters_off,
	
	"U_MIN_MAX_QUESTIONS" => $quiz_min_max_questions,
	
	"U_AUTHOR_MOD_ON" => $quiz_author_mod_on,
	"U_AUTHOR_MOD_OFF" => $quiz_author_mod_off,
	
	"U_CASH_ON" => $quiz_cash_on,
	"U_CASH_OFF" => $quiz_cash_off,
	
	"U_REGISTER_TO_PLAY_ON" => $quiz_register_to_play_on,
	"U_REGISTER_TO_PLAY_OFF" => $quiz_register_to_play_off,
	
	"U_MODERATORS" => $quiz_moderators,
	"U_BANNED" => $quiz_banned,
	
	"U_POST_COUNT_ON" => $quiz_post_count_on,
	"U_POST_COUNT_OFF" => $quiz_post_count_off,
	
	"U_MINIMUM_POST_REQUIRED" => $quiz_minimum_post_requirement,
	
	"U_QUIZ_STATS_DISPLAY" => $quiz_stats_display,
	
	"U_PLAY_ONCE_ON" => $quiz_play_once_on,
	"U_PLAY_ONCE_OFF" => $quiz_play_once_off,
	
	"U_AUTHOR_PLAY_ON" => $quiz_author_play_on,
	"U_AUTHOR_PLAY_OFF" => $quiz_author_play_off,	

	"F_FORM" => append_sid("admin_quiz.$phpEx?mode=submit"),
	
	"Q_LATEST" => sprintf($lang['Quiz_admin_latest_version'], htmlspecialchars($update_file[0])),
	
	"L_SUBMIT" => $lang['Submit'],
	
	"L_YES" => $lang['Quiz_admin_yes'],
	"L_NO" => $lang['Quiz_admin_no'],
	
	"L_CONFIGURATION" => $lang['Quiz_admin_configuration'],
	"L_PERMISSIONS" => $lang['Quiz_admin_permissions'],
	"L_CATEGORIES" => $lang['Quiz_admin_categories'],
	"L_CASH_SETTINGS" => $lang['Quiz_admin_cash_settings'],
	
	"L_CASH_ON" => $lang['Quiz_admin_cash_enable'],
	"L_MOD_SUBMIT" => $lang['Quiz_admin_mod_only_submit'],
	"L_AUTHOR_MOD" => $lang['Quiz_admin_author_mod'],
	"L_SHOW_ANSWERS" => $lang['Quiz_admin_show_answers'],
	"L_MIN_MAX_QUESTIONS" => $lang['Quiz_admin_quiz_numbers'],
	"L_REGISTER_TO_PLAY" => $lang['Quiz_admin_register_to_play'],
	"L_MODERATORS" => $lang['Quiz_admin_moderators'],
	"L_BANNED" => $lang['Quiz_admin_banned'],
	"L_POST_COUNT" => $lang['Quiz_admin_post_count'] ,
	"L_POST_REQUIREMENT" => $lang['Quiz_admin_posts'],
	"L_STATS_DISPLAY" => $lang['Quiz_admin_stats_display'],
	"L_PLAY_ONCE" => $lang['Quiz_admin_play_once'],
	"L_AUTHOR_PLAY" => $lang['Quiz_admin_author_play']
	));

	if($board_config['Quiz_Register_Play'] == ON)
	{
		$template->assign_block_vars('register_row', array());
	}
//
// Generate the page, It's A Sin - Pet Shop Boys
//
$template->pparse("quiz_admin");
include("page_footer_admin.$phpEx");
?>