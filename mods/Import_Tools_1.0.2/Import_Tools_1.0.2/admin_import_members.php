<?php
/***************************************************************************
 * Filename:          admin_import_members.php
 * Description:       
 * Author:            Graham Eames (phpbb@grahameames.co.uk)
 * Last Modified:     28-Feb-2004
 * File Version:      1.1
 *
 * Acknowlegments:    A few pieces of code in this come from usercp_register.php
 *                    Much of the rest is adapted from my convertors
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
	$module['Import_Tools']['Members'] = $filename;

	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_mod_user.' . $phpEx);

if (file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_import.' . $phpEx))
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_import.' . $phpEx);
}
elseif (file_exists($phpbb_root_path . 'language/lang_english/lang_import.' . $phpEx))
{
	include($phpbb_root_path . 'language/lang_english/lang_import.' . $phpEx);
}
else
{
	message_die(GENERAL_ERROR, 'Could not load the import tools language file.', 'File missing');
}

if (isset($HTTP_POST_VARS['start']) || isset($HTTP_GET_VARS['start']) )
{
	$template->set_filenames(array(
		'body' => 'admin/import_message_body.tpl')
	);

	$start = (isset($HTTP_POST_VARS['start'])) ? (int) $HTTP_POST_VARS['start'] : (int) $HTTP_GET_VARS['start'];
	$import_rate = (isset($HTTP_POST_VARS['import_rate'])) ? (int) $HTTP_POST_VARS['import_rate'] : ( (isset($HTTP_GET_VARS['import_rate'])) ? (int) $HTTP_GET_VARS['import_rate'] : 250);

	$password_format = (isset($HTTP_POST_VARS['password_format'])) ? $HTTP_POST_VARS['password_format'] : ( (isset($HTTP_GET_VARS['password_format'])) ? $HTTP_GET_VARS['password_format'] : 'plain');

	if (!($file_handle = @fopen('import/members.csv', 'r')))
	{
		message_die(GENERAL_ERROR, sprintf($lang['import_file_missing_details'], 'members.csv'), $lang['import_file_missing']);
	}

	// Loop through and read the whole file into an array using fgetcsv
	while (!feof($file_handle))
	{
		$members_file[] = fgetcsv($file_handle, 1000, ',');
	}
	fclose($file_handle);

	// Now get the slice of the array we want based on the start and import_rate values
	$members_file_slice = array_slice($members_file, $start, $import_rate);

	for($i=0; $i<count($members_file_slice); $i++)
	{
		$member_data = $members_file_slice[$i];

		if ($member_data != '')
		{
			$username = $member_data[0];
			$email = $member_data[1];
			$user_password = $member_data[2];
			if ($password_format == 'plain')
			{
				$user_password = md5($user_password);
			}
			$user = new user($username, $user_password, $email);

			$user_check = $user->validate_user();

			if ($user_check)
			{
				$user->insert_user();
			}
		}
	}

	// Work out whether this is the end or we need another pass
	$next_start = $start + $import_rate;
	$members_file = array_slice($members_file, $next_start, $import_rate);
	$user_count = count($members_file);

	if ($user_count > 0)
	{
		$template->assign_vars(array(
			'S_FORM_ACTION' => append_sid('admin_import_members.'.$phpEx),
			'MESSAGE_TITLE' => $lang['import_in_progress'],
			'MESSAGE_TEXT' => $lang['import_in_progress_members'])
		);
		$template->assign_block_vars('switch_continue', array(
			'CONTINUE_CAPTION' => $lang['import_continue'],
			'S_HIDDEN_FIELDS' => '<input type="hidden" name="start" value="' . $next_start . '" /><input type="hidden" name="import_rate" value="' . $import_rate . '" />')
		);
	}
	else
	{
		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['import_complete'],
			'MESSAGE_TEXT' => $lang['import_complete_members'])
		);
	}
}
else
{
	// Display the introduction screen and get some basic information
	$template->set_filenames(array(
		'body' => 'admin/import_members_settings.tpl')
	);
	$template->assign_vars(array(
		'L_IMPORT_TITLE' => $lang['Import_Tools'] . ' :: ' . $lang['Members'],
		'L_IMPORT_EXPLAIN' => $lang['import_explain_members'],
		'L_USERNAME' => $lang['Username'],
		'L_EMAIL' => $lang['Email'],
		'L_PASSWORD' => $lang['Password'],
		'L_IMPORT_SETTINGS' => $lang['import_settings'],
		'L_PASSWORD_FORMAT' => $lang['import_password_format'],
		'L_PASSWORD_FORMAT_EXPLAIN' => $lang['import_password_format_explain'],
		'L_PLAIN' => $lang['import_password_format_plain'],
		'L_MD5' => $lang['import_password_format_md5'],
		'L_IMPORT_RATE' => $lang['import_rate'],
		'L_IMPORT_RATE_EXPLAIN' => $lang['import_rate_explain'],
		'L_START_IMPORT' => $lang['import_start'],

		'IMPORT_RATE_SELECT' => '<select name="import_rate"><option>2</option><option>100</option><option selected="selected">250</option><option>500</option><option>1000</option></select>',
			
		'S_FORM_ACTION' => append_sid('admin_import_members.'.$phpEx),
		'S_HIDDEN_FIELDS' => '<input type="hidden" name="start" value="0" />')
	);
}

include('./page_header_admin.'.$phpEx);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
