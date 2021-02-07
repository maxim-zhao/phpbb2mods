<?php
/***************************************************************************
	Original author: Dave Rathbun (copyright www.phpBBDoctor.com)
 
 	This is the admin page for the Memberlist Controls MOD.
	This is an add-on for the popular bb software from phpBB.
 
	VERSION: 1.0.0
	AUTHOR NOTES:
	This MOD gives you an easy way to control which users will
	be visible on your memberlist. THere are other MODs that
	allow you to show only active members, that is just one of
	the controls offered by this MOD. At this time it also
	allows you to set restrictions for user post count and last
	visit date as well.
	
	The phpbb_config table is used to store the values, but the
	code will default the values if they have not been set yet,
	so you do not have to run any SQL insert statements prior to
	installing this MOD.
	
	If set the "active user" control is also applied to the
	newest member as well as the total user count for your
	board. That will keep inactive users from showing up as the
	newest member, and your total user count for your board will
	match the total active user count.

 	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

****************************************************************************/

define('IN_PHPBB', TRUE);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['phpBBDoctor']['Memberlist_Control'] = "$file";
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$memberlist_controls = array();
$memberlist_controls['phpbbdoctor_memberlist_active_required'] = 1;
$memberlist_controls['phpbbdoctor_memberlist_min_posts_required'] = 0;
$memberlist_controls['phpbbdoctor_memberlist_days_since_last_visit_required'] = 0;

$thisPage = 'admin_memberlist_controls.'.$phpEx;
$thisPageName = $lang['Memberlist_controls_title'];
$thisPageExplain = $lang['Memberlist_controls_explain'];
$thisFunction = $lang['Memberlist_controls_setting'];	// data element managed by this form
$thisTPLHeader = 'memberlist_controls_';		// used to contruct template file names

$click_return_list = '<br /><br />' . sprintf($lang['Click_return_list'], '<a href="' . append_sid("$thisPage") . '">', '</a>', $thisFunction);
$click_return_admin = '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

/*
// Set up cache structure
$cache_file = $phpbb_root_path . 'cache/cache_config.'.$phpEx;
$cache_key = '';
$array_name = '$board_config';
$row_structure = array(
		'config_name' => 'config_value'
	);
// END Define cache variables
*/

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else 
{
	//
	// These could be entered via a form button
	//
	if( isset($HTTP_POST_VARS['save']) )
	{
		$mode = 'save';
	}
	else
	{
		$mode = '';
	}
}

if( $mode != '' )
{
	if( $mode == 'save' )
	{

		$sql = 'SELECT	*
			FROM	' . CONFIG_TABLE . '
			WHERE	config_name like "phpbbdoctor_memberlist%"';

		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'DEBUG: Unable to query config table', '', __LINE__, __FILE__, $sql);
		}

		$data_rows = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$data_rows[$row['config_name']] = $row['config_name'];
		}
		$db->sql_freeresult($result);

		$result = TRUE;
		foreach($memberlist_controls as $key => $value)
		{

			if (isset($HTTP_POST_VARS[$key]))
			{
				$control_value = intval($HTTP_POST_VARS[$key]);
			}
			else
			{
				$control_value = $memberlist_controls[$key];
			}

			// Build update query here
			if ($data_rows[$key] <> '')
			{
				$sql = 'UPDATE	' . CONFIG_TABLE . '
					SET	config_value = "' . $control_value . '"
					WHERE	config_name = "' . $key .'"';
			}
			else // Build insert query here
			{
				$sql = 'INSERT INTO ' . CONFIG_TABLE . ' (
						config_name
					,	config_value
					) VALUES (
						"' . $key . '"
					,	"' . $control_value . '"
					)';
			}

			$result = $result && $db->sql_query($sql);
		}

		if ($result === FALSE)
		{
			message_die(GENERAL_ERROR, 'DEBUG: Error storing config values');
		}

		//write_cache_file($cache_file, 'phpbb_config', $array_name, $row_structure, $cache_key);
		$message = $lang['Memberlist_controls_updated'];
		$message .= $click_return_list;
		$message .= $click_return_admin;

		message_die(GENERAL_MESSAGE, $message);
	}
}
else
{
	$template->set_filenames(array(
		'body' => 'admin/memberlist_controls_body.tpl')
	);

	$sql = 'SELECT	* 
		FROM 	' . CONFIG_TABLE . ' 
		WHERE	config_name like "phpbbdoctor_memberlist%"';
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'DEBUG: Could not query ' . $thisFunction . ' information', $lang['Error'], __LINE__, __FILE__, $sql);
	}

	// Query the database for proper keys
	$found_keys = array();
	while ($data_row = $db->sql_fetchrow($result))
	{
		$template->assign_vars(array(
			strtoupper($data_row['config_name']) => $data_row['config_value']
			));

		$found_keys[$data_row['config_name']] = TRUE;
	}
	$db->sql_freeresult($result);

	// Find out if any keys are missing and provide default values
	$missing_keys = array();
	$missing_keys = array_diff(array_keys($memberlist_controls), array_keys($found_keys));

	// Populate missing values, this allows me to 
	// write into values with out defaulting the
	// initial rows into the phpbb_config table.
	foreach ($missing_keys as $key => $value)
	{
		$template->assign_vars(array(
			strtoupper($value) => $memberlist_controls[$value]
			));
	}

	$template->assign_vars(array(
		'L_ACTIVE_REQUIRED' => $lang['Memberlist_active_required'],
		'L_ACTIVE_REQUIRED_EXPLAIN' => $lang['Memberlist_active_required_explain'],
		'L_MIN_POSTS_REQUIRED' => $lang['Memberlist_min_posts_required'],
		'L_MIN_POSTS_REQUIRED_EXPLAIN' => $lang['Memberlist_min_posts_required_explain'],
		'L_DAYS_SINCE_LAST_VISIT_REQUIRED' => $lang['Memberlist_days_since_last_visit_required'],
		'L_DAYS_SINCE_LAST_VISIT_REQUIRED_EXPLAIN' => $lang['Memberlist_days_since_last_visit_required_explain'],

		'L_SUBMIT' => $lang['Submit'],

		'THIS_PAGE_NAME' => $thisPageName,
		'THIS_PAGE_EXPLAIN' => $thisPageExplain,

		'S_ACTION' => append_sid("$thisPage"),
		'S_HIDDEN_FIELDS' => '')
	);
}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
