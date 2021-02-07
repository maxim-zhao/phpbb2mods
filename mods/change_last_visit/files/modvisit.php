<?php
/***************************************************************************
 *                               modvisit.php
 *                            -------------------
 *   begin                : September 1, 2004
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   author               : Nux
 *   email                : egil at NO SPAM-PLEASE;) wp.pl
 *                                                                         
 *             
 *   $Id: modvisit.php,v 0.1.3 2006/01/17 $
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

//
// Continue var definitions
//

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);
//
// End session management
//

//
// Check the user
//
if ( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=modvisit.$phpEx", true));
}

//
// Header
//
$gen_simple_header = TRUE;
$page_title = $lang['Edit_profile'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

//
// Set template files
//
$template->set_filenames(array(
	'body' => 'profile_modvisit.tpl')
);

//
// The form was submited
//
if ( isset($HTTP_POST_VARS['visit_modified']) )
{
	// general goal is to check it at submiting in javascript.
	if (!checkdate ($HTTP_POST_VARS['miesiac'], $HTTP_POST_VARS['dzien'], $HTTP_POST_VARS['rok']))
	{
			$message = $lang['modvisit_date_invalid'];
//			$message .= '<br /><br />' . sprintf($lang['Click_return_try_again'], '<a href="' . append_sid('modvisit.'.$phpEx) . '">', '</a>');
//			$message .= '<br /><br />' . sprintf($lang['Click_return_try_again'], '<span onClick="history.back();return false;" onMouseOver="this.style.textDecoration = \'underline\';return true;" onMouseOut="this.style.textDecoration = \'none\';return true;">', '</span>');
			$message .= '<br /><br />' . sprintf($lang['Click_return_try_again'], '<a href="javascript:void(history.back())">', '</a>');
			message_die(GENERAL_MESSAGE, $message); 
	}

	//
	// generate new timestamp
	//
	$chg_lastvisit = 
		gmmktime ($HTTP_POST_VARS['hours'], $HTTP_POST_VARS['minutes'], $HTTP_POST_VARS['seconds'], 
			$HTTP_POST_VARS['miesiac'], $HTTP_POST_VARS['dzien'], $HTTP_POST_VARS['rok']);
	$chg_lastvisit -= 3600 * $board_config['board_timezone'];

	$userdata['user_lastvisit'] = $chg_lastvisit;
	$sql_update = 'UPDATE '. USERS_TABLE .' SET user_lastvisit = '. $chg_lastvisit .' WHERE user_id = '. $userdata['user_id'];
	if ( !($result = $db->sql_query($sql_update)) )
	{
		message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql_update);
	}
	
	// $s_last_visit = create_wzg_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']);
	$s_last_visit = create_date($board_config['default_dateformat'], $userdata['user_lastvisit'], $board_config['board_timezone']);
	$template->assign_vars(array(
		'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit)
	));
}

//
// get the currently set user's lastvisit time to set in boxes on non-js
//
$user_time_tmp = $userdata['user_lastvisit'] + (3600 * $board_config['board_timezone']); // just to lower the amount of work for proccesor
$cur_godz = @gmdate('H', $user_time_tmp);
$cur_min = @gmdate('i', $user_time_tmp);
$cur_sek = @gmdate('s', $user_time_tmp);
$cur_day = @gmdate('d', $user_time_tmp);
$cur_month = @gmdate('m', $user_time_tmp);
$cur_year = @gmdate('Y', $user_time_tmp);

//
// Template prepare.
//
$template->assign_vars(array(
	'S_MODVISIT_ACTION' => 'modvisit.php',

	//
	// curently set last visit time (the one to set as default)
	//
	'CUR_GODZ' => $cur_godz,
	'CUR_MIN' => $cur_min,
	'CUR_SEK' => $cur_sek,
	'CUR_DAY' => $cur_day,
	'CUR_MONTH' => $cur_month,
	'CUR_YEAR' => $cur_year,

	//
	// langs
	//
	'L_MODVISIT' => $lang['modvisit_title'],
	'L_DATE_TITLE' => $lang['modvisit_date_title'],
	'L_EXPLAIN' => $lang['modvisit_explain'],
	'L_SUBMIT' => $lang['Change'],
	'L_CLOSE_WINDOW' => $lang['Close_window'], 

	'L_TIME_INVALID' => $lang['modvisit_time_invalid'],

	// weekdays
	'L_MON' => $lang['datetime']['Mon'],
	'L_TUE' => $lang['datetime']['Tue'],
	'L_WED' => $lang['datetime']['Wed'],
	'L_THU' => $lang['datetime']['Thu'],
	'L_FRI' => $lang['datetime']['Fri'],
	'L_SAT' => $lang['datetime']['Sat'],
	'L_SUN' => $lang['datetime']['Sun'],

	// months
	'L_MON' => $lang['datetime']['Mon'],
	'L_JAN' => $lang['datetime']['Jan'],
	'L_FEB' => $lang['datetime']['Feb'],
	'L_MAR' => $lang['datetime']['Mar'],
	'L_APR' => $lang['datetime']['Apr'],
	'L_MAY' => $lang['datetime']['May'],
	'L_JUN' => $lang['datetime']['Jun'],
	'L_JUL' => $lang['datetime']['Jul'],
	'L_AUG' => $lang['datetime']['Aug'],
	'L_SEP' => $lang['datetime']['Sep'],
	'L_OCT' => $lang['datetime']['Oct'],
	'L_NOV' => $lang['datetime']['Nov'],
	'L_DEC' => $lang['datetime']['Dec'],
));

//
// Wrap this up :).
//
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>