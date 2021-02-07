<?php
/***************************************************************************
*                        				   lang_quiz.php
***************************************************************************/
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

// Ultimate Quiz MOD v1.2.0

// Lang variables concerning the installation / updating of the MOD

$lang['Quiz_install'] = 'Ultimate Quiz MOD Installation';
$lang['Quiz_install_mod'] = 'Ultimate Quiz MOD <b>v1.2 Series</b>';
$lang['Quiz_install_description'] = 'The script is now going to alter your forum database so the Ultimate Quiz MOD can function!<br />Any queries which are shown in green were executed successfully, those in red however, encountered a problem. It is absolutely vital that you have made all code changes already, and uploaded all quiz files to their respective locations.';
$lang['Quiz_install_success'] = 'Installation is complete, and no errors were encountered. You may now begin using the Ultimate Quiz MOD! Now delete this file.';
$lang['Quiz_install_failure'] = 'Installation is complete, however, some errors were encountered. It is suggested that you rectify these problems before attempting to use the Ultimate Quiz MOD!';
$lang['Quiz_install_no_permissions'] = 'You do not have permission to access this file';
$lang['Quiz_install_or_update'] = 'Do you wish to do a fresh install, or update from v1.0.6?<br />Be aware, that if you are updating, you must first follow the instructions in the UQM_Readme.mod.txt file.<br /><a href="%s">Install</a> - <a href="%s">Update</a>';
$lang['Quiz_install_continue'] = 'To continue with the update, click <a href="%s">here</a>!<br />It is advised you backup before continuing!<br /><br />It is vitally important that you now run quiz_updater.php.';

$lang['Quiz_update_introduction'] = 'Ultimate Quiz MOD 1.2.0 FINAL<br />By battye<br /><br />This is the updater from v1.0.6 to v1. v1.2.x.<br />This may take a few minutes, depending on your database size! Categories, quizzes and quiz data will be transferred. Statistics, because of their nature, will not be saved.';
$lang['Quiz_update_category'] = 'Currently updating category: <b>%s</b><br />';
$lang['Quiz_update_quiz'] = 'Currently updating general quiz data: <b>%s</b><br />';
$lang['Quiz_update_questions'] = 'Currently updating quiz question data: <b>%s</b><br />';
$lang['Quiz_update_dropped_renamed'] = 'Dropped and renamed tables';
$lang['Quiz_update_complete_update'] = '<br /><br />Updating is complete, if you have any errors or questions, please contact battye @ <a href=http://forums.cricketmx.com>http://forums.cricketmx.com</a>';
$lang['Quiz_update_statistics_file'] = 'Statistics file was created';
$lang['Quiz_update_spacer'] = '<br /><br />';

// Cash

$lang['Quiz_cash_total_result_gain'] = 'You have won a total of <b>%d %s</b>';
$lang['Quiz_cash_total_result_loss'] = 'You have lost a total of <b>%d %s</b>';
$lang['Quiz_cash_information'] = 'Profit per correct answer: <b>%d</b> &middot; Loss per incorrect answer: <b>%d</b> &middot; Tax to play: <b>%d</b>';

// Statistics

$lang['Quiz'] = 'Quiz';
$lang['Quiz_stats'] = 'Quiz Statistics';
$lang['Quiz_stats_none'] = 'No statistics for this quiz!';

$lang['Quiz_stats_author'] = 'Quiz Author';
$lang['Quiz_stats_correct'] = 'Correct';
$lang['Quiz_stats_incorrect'] = 'Incorrect';
$lang['Quiz_stats_percentage'] = 'Percentage';
$lang['Quiz_stats_all_time_highest'] = 'All Time Highest Scores';

$lang['Quiz_stats_most_plays'] = 'Most Played Quizzes';
$lang['Quiz_stats_plays'] = 'Plays';

$lang['Quiz_stats_individual_high'] = 'High Scorers for <i>%s</i>';

// Variables concerning quiz moderators:
	
$lang['Quiz_cp_not_moderator'] = 'You are not a quiz moderator!';
$lang['Quiz_cp_delete_sure'] = 'Are you sure you want to delete this quiz? It cannot be restored!';
$lang['Quiz_cp'] = 'Quiz Moderator Control Panel';
$lang['Quiz_cp_delete'] = 'Delete Quiz';
$lang['Quiz_cp_deleted'] = 'The quiz has been deleted successfully!';
$lang['Quiz_cp_edit'] = 'Edit Quiz';
$lang['Quiz_cp_edited'] = 'Quiz edited successfully!';
$lang['Quiz_cp_edit_explaination'] = 'You can edit the name, questions, and answers of a quiz here:';
$lang['Quiz_cp_place_check'] = 'Check the box next to the correct answer';
$lang['Quiz_cp_move_explain'] = 'Move this quiz to another category:';
$lang['Quiz_cp_move'] = 'Move Quiz';
$lang['Quiz_cp_move_sucess'] = 'The quiz has been moved successfully!';
$lang['Quiz_cp_play_quiz_mod'] = '<b>You have the appropriate permissions to edit this quiz:</b>';
$lang['Quiz_cp_play_quiz_mod_do'] = '%sEdit Quiz%s, %sDelete Quiz%s, %sMove Quiz%s';

// All the variables concerning the end user:

$lang['Quiz_click_return_quiz'] = 'Click %sHere%s to return to the Quiz Page';
$lang['Quiz_number_of_plays'] = '%s Plays';
$lang['Quiz_number_of_play'] = '1 Play';
$lang['Quiz_must_be_registered'] = 'It is a requirement that you are registered and logged in to participate in, or submit quizzes';
$lang['Quiz_post_requirement_not_met'] = 'You have have %s posts to participate in, or submit quizzes';
$lang['Quiz_insufficient_questions'] = 'You have either chosen a number above the number specified, or below the number specified, for questions allowed in a quiz. Please choose another number';
$lang['Submit_multiple_choice_quiz'] = 'Submit Multiple Choice Quiz';
$lang['Submit_true_false_quiz'] = 'Submit True / False Quiz';
$lang['Submit_input_quiz'] = 'Submit An Input Answer Quiz';
$lang['Submit_quiz'] = 'Submit Quiz';
$lang['Quiz_only_mod_can_submit'] = 'Only quiz moderators can submit quizzes!';
$lang['Quiz_alternate'] = 'Alternate Answer';
$lang['Quiz_question'] = 'Question';
$lang['Quiz_insert_name'] = 'Insert Quiz Name';
$lang['Quiz_set_up_options'] = 'Set Up Options';
$lang['Quiz_select_number'] = 'Select the number of questions you wish to have in your quiz:';
$lang['Quiz_only_admin_submit'] = 'Only administrators are permitted to submit quizzes'; 
$lang['Quiz_only_registered_submit'] = 'You must be registered and logged in to submit quizzes';
$lang['Quiz_no_multiple_choice'] = 'Multiple Choice quizzes are not permitted'; 
$lang['Quiz_no_true_false'] = 'True & False quizzes are not permitted'; 
$lang['Quiz_no_input_answer'] = 'Input quizzes are not permitted'; 
$lang['Quiz_no_number_chosen'] = 'You must select the number of questions you wish to have in the quiz!'; 
$lang['Quiz_answer_true'] = 'True'; 
$lang['Quiz_answer_false'] = 'False'; 
$lang['Quiz_answer_correct'] = 'Correct Answer'; 
$lang['Quiz_added_successfully'] = 'Your quiz has been added to the database successfully!'; 
$lang['Quiz_input_information'] = 'After reading the question, type the answer into the field beside!';
$lang['Quiz_multiple_information'] = 'After reading the question, select the correct answer beside it!';
$lang['Quiz_true_false_information'] = 'After reading the question, select whether it is true or false in the field beside it!';
$lang['Quiz_answer_status'] = 'Your answer was <b>%s</b>, the correct answer was <b>%s</b>';
$lang['Quiz_show_correct_score'] = 'Correct Answers: <b>%s</b>';
$lang['Quiz_show_incorrect_score'] = 'Incorrect Answers: <b>%s</b>';
$lang['Quiz_score'] = 'Quiz Results';
$lang['Quiz_quizzes'] = 'Quizzes';
$lang['Quiz_type_true_false'] = 'True / False Quiz';
$lang['Quiz_type_multiple_choice'] = 'Multiple Choice Quiz';
$lang['Quiz_type_input_answer'] = 'Input Answer Quiz';
$lang['Quiz_view_alphabetical'] = 'View by Alphabetical';
$lang['Quiz_view_chronilogical'] = 'View by Date';
$lang['Quiz_view_type'] = 'View by Quiz Type';
$lang['Quiz_view_author'] = 'View by Author';
$lang['Quiz_author_cannot_play'] = 'You cannot play quizzes which you have submitted!';
$lang['Quiz_no_quizzes'] = 'No quizzes have been submitted in this category yet!<br />Click <a href="%s">here</a> to begin adding quizzes!';
$lang['Quiz_password_protect'] = 'Category Password';
$lang['Quiz_password_protect_information'] = 'This category is password protected:';
$lang['Quiz_category_password_wrong'] = 'The password you entered was incorrect, please go back and try again!';
$lang['Quiz_min_max'] = 'The administration has set a minimum number of <b>%d</b> questions and a maximum of <b>%d</b> questions!';
$lang['Quiz_min_max_set'] = 'The administration has set a fixed number of <b>%d</b> questions!';
$lang['Quiz_min_max_exceed'] = 'You have either entered a number which exceeds the maximum, or is lower than the minimum.<br />Please click Back in your browser and try again!';
$lang['Quiz_registered_category_permissions_no_access'] = 'You do not have the required permissions to access this category. It is restricted to registered members only.';
$lang['Quiz_only_play_it_once'] = 'You are only permitted to play each quiz once.';

// Lang variables concerning the admin:

$lang['Quiz_admin_latest_version'] = 'The latest version of the Ultimate Quiz MOD: <b>%s</b><br />If you experience any problems with the Ultimate Quiz MOD, please visit either (or both) of the following websites for assistance:<br /><a href="http://www.phpbb.com/phpBB/">phpBB.com</a>, <a href="http://www.cmxmods.net/demo_board/">Cmxmods.net</a>.';
$lang['Quiz_admin_cash_currency'] = 'Which cash currency would you like to use for quizzes?<br />Please list the database field name (<b>user_</b>*), not the currency name!';
$lang['Quiz_admin_cash_settings'] = 'Quiz Cash Settings';
$lang['Quiz_admin_cash_enable'] = 'Should cash be enabled? (Only to be used if the Cash MOD is installed!)';
$lang['Quiz_admin_cash_correct'] = 'How much should the user earn per correct answer?';
$lang['Quiz_admin_cash_incorrect'] = 'How much should the user lose per incorrect answer?';
$lang['Quiz_admin_cash_taxation'] = 'How much should the user be taxed for playing a quiz?';
$lang['Quiz_admin_mod_only_submit'] = 'Only quiz moderators can submit quizzes?';
$lang['Quiz_admin_stats_display'] = 'How many statistics will be displayed for each module?';
$lang['Quiz_admin_category_permissions_choose'] = 'What permissions should this category have?';
$lang['Quiz_admin_category_guest'] = 'Guest';
$lang['Quiz_admin_category_registered'] = 'Registered';
$lang['Quiz_admin_category_registered_hidden'] = 'Registered [ Hidden ]';
$lang['Quiz_admin_show_answers'] = 'Do you wish for answers to be shown after the quiz is played?';
$lang['Quiz_admin_register_to_play'] = 'Do users have to be registered to participate in / or submit quizzes?';
$lang['Quiz_admin_post_count'] = 'Do you want users to reach a certain post count before they can participate in / or submit quizzes?';
$lang['Quiz_admin_quiz_numbers'] = 'What is the minimum and maximum number of questions a user can have in quiz?<br />Separate with commas, and put the same number twice (<i>x,x</i>) to make a set number for everybody.';
$lang['Quiz_admin_posts'] = 'Enter the minimum number of posts here:';
$lang['Quiz_admin_play_once'] = 'Should users only be able to play each quiz once?';
$lang['Quiz_admin_author_play'] = 'Should the quiz author be able to play their own quizzes?';
$lang['Quiz_admin_moderators'] = 'Enter all users which you wish to have quiz moderator status (move, edit, delete quizzes).<br />Separate user id\'s with commas!';
$lang['Quiz_admin_banned'] = 'Enter all users which you wish to banned from participating in quizzes.<br />Separate user id\'s with commas!';
$lang['Quiz_admin_configuration'] = 'Quiz Configuration';
$lang['Quiz_admin_permissions'] = 'Quiz Permissions';
$lang['Quiz_admin_categories'] = 'Quiz Categories';
$lang['Quiz_admin_yes'] = 'Yes';
$lang['Quiz_admin_no'] = 'No';
$lang['Quiz_admin_cat_edit'] = 'Edit';
$lang['Quiz_admin_cat_delete'] = 'Delete';
$lang['Quiz_admin_cat_add'] = 'Add New Category';
$lang['Quiz_admin_cat_move'] = 'Move Quizzes';
$lang['Quiz_admin_cat_move_to_category'] = 'This function can be used to transfer all quizzes in one category, to another category.<br />This could be useful if you intend to delete a category, but want to retain the quizzes.<br /><br />Select from the list, which category you want to move the quizzes into:';
$lang['Quiz_admin_delete_category'] = 'Are you sure you want to delete this category, and all the quizzes within it?<br />Click <a href="%s">here</a> to continue.';
$lang['Quiz_admin_configuration_updated'] = 'Quiz settings updated successfully<br />Click %shere%s to return to the Quiz settings panel!';
$lang['Quiz_admin_move_category_successful'] = 'All quizzes were moved to the new category successfully!';
$lang['Quiz_admin_number_quizzes'] = '(%d Quizzes)';
$lang['Quiz_admin_description'] = 'Category Description:';
$lang['Quiz_admin_name'] = 'Category Name:';
$lang['Quiz_admin_edit_explanation'] = 'Edit your category information below: (Category passwords are optional)';
$lang['Quiz_admin_editing'] = 'Edit Category';
$lang['Quiz_admin_category_update_successful'] = 'The category was updated sucessfully!';
$lang['Quiz_admin_add_explanation'] = 'Here, you can add a new category for your quizzes. Enter the information below! (Category passwords are optional)';
$lang['Quiz_admin_add'] = 'Make A New Category';
$lang['Quiz_admin_new_category_successful'] = 'The new category was made successfully!';
$lang['Quiz_admin_password_protect'] = 'Category Password:';
$lang['Quiz_admin_author_mod'] = 'Can quiz authors have moderative status over their <b>own</b> quizzes?';
?>