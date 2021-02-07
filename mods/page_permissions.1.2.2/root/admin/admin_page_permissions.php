<?php
/***************************************************************************
 *	Page Permissions version 1.2.2
 *	Original author: Dave Rathbun (copyright www.phpBBDoctor.com)
 *
 *	This is the admin control module for the Page Permissions MOD
 *	This module allows you to view, edit, insert, or delete pages
 * 	that will be managed via the page permissions MOD code. You do
 *	NOT have to list every single page; pages that are left out will
 *	be set to "guest" view enabled, which mimics the standard phpBB
 * 	permission logic.
 *
 * 	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *
 ***************************************************************************/

function secure_string($str)
{
	return str_replace("\'", "''", htmlentities(trim($str)));
}

define('IN_PHPBB', TRUE);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['phpBBDoctor']['Page_permissions'] = "$file";
	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// This is not standard phpBB code; I got tired of doing
// so many edits for each new admin page that I set up
// these variables at the top of each admin page. This
// makes setting up a new ACP page a fairly trivial process.
$thisPage = 'admin_page_permissions.'.$phpEx;
$thisPageName = $lang['Page_permissions_admin_title'];
$thisPageExplain = $lang['Page_permissions_explain'];
$thisTPLHeader = 'page_permissions_';
$thisFunction = $lang['Page_permissions_element'];
$thisTable = PAGES_TABLE;

// Set up standard "return" messages
$click_return_list = '<br /><br />' . sprintf($lang['Click_return_page_admin'], '<a href="' . append_sid("$thisPage") . '">', '</a>');
$click_return_admin = '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

// Set up cache structure
$cache_file = $phpbb_root_path . 'cache/cache_page_permissions.'. $phpEx;
$cache_key = 'page_key';
$array_name = '$page_permissions';
$row_structure = array(
		'page_id' => 'page_id'
	,	'page_name' => 'page_name'
	,	'disable_page' => 'disable_page'
	,	'page_parm_name' => 'page_parm_name'
	,	'page_parm_value' => 'page_parm_value'
	,	'auth_level' => 'auth_level'
	,	'min_post_count' => 'min_post_count'
	,	'max_post_count' => 'max_post_count'
	,	'group_list' => 'group_list'
	,	'disabled_message' => 'disabled_message'
	);
// END Define cache variables

// Set up array of auth level language entries
$page_auth_levels = array();
$page_auth_levels[PAGE_AUTH_GUEST] = $lang['Permission_public'];
$page_auth_levels[PAGE_AUTH_REG] = $lang['Permission_registered'];
$page_auth_levels[PAGE_AUTH_PRIVATE] = $lang['Permission_private'];
$page_auth_levels[PAGE_AUTH_MOD] = $lang['Permission_moderator'];
$page_auth_levels[PAGE_AUTH_ADMIN] = $lang['Permission_administrator'];

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
}
else 
{
	if( isset($HTTP_POST_VARS['add']) )
	{
		$mode = 'add';
	}
	else if( isset($HTTP_POST_VARS['save']) )
	{
		$mode = 'save';
	}
	else if( isset($HTTP_POST_VARS['cache']) )
	{
		$mode = 'cache';
	}
	else if( isset($HTTP_POST_VARS['disable']) )
	{
		$mode = 'disable';
	}
	else if( isset($HTTP_POST_VARS['switch']) )
	{
		$mode = 'switch';
	}
	else
	{
		$mode = '';
	}
}

$mode = htmlspecialchars($mode);

if( $mode != '' )
{
	if( $mode == 'edit' || $mode == 'add' )
	{
		$page_id = ( isset($HTTP_GET_VARS['id']) ) ? intval($HTTP_GET_VARS['id']) : 0;

		$template->set_filenames(array(
			'body' => 'admin/'.$thisTPLHeader.'edit_body.tpl')
		);

		$s_hidden_fields = '';

		if( $mode == 'edit' )
		{
			if( $page_id )
			{
				$sql = 'SELECT 	* 
					FROM ' . $thisTable . " 
					WHERE page_id = $page_id";
				if(!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'DEBUG: Could not query '.$thisFunction.' table', 'Error', __LINE__, __FILE__, $sql);
				}

				$data_row = $db->sql_fetchrow($result);
				$guest_views = $data_row['guest_views'];
				$member_views = $data_row['member_views'];
				$disable_page = $data_row['disable_page'];
				$auth_level = $data_row['auth_level'];
				$group_list = $data_row['group_list'];
				$disabled_message = $data_row['disabled_message'];
				$min_post_count = $data_row['min_post_count'];
				$max_post_count = $data_row['max_post_count'];

				$s_hidden_fields .= '<input type="hidden" name="id" value="' . $page_id . '" />';
			}
			else
			{
				message_die(GENERAL_MESSAGE, $lang['No_page_selected']);
			}
		}
		else
		{
			// Set some default values
			$disable_page = FALSE;
			$auth_level = 0;
			$guest_views = 0;
			$member_views = 0;
			$group_list = '';
			$disabled_message = '';
			$min_post_count = 0;
			$max_post_count = 0;
		}

		$auth_level_selector = '<select name="auth_level">';
		for ($i=0;$i<count($page_auth_levels);$i++)
		{
			$selected = ($auth_level == $i ? ' selected="selected" ' : '');
			$auth_level_selector .= '<option ' . $selected . ' value="' . $i . '">' . $page_auth_levels[$i] . '</option>';
		}
		$auth_level_selector .= '</select>';

		$page_groups = array();
		$page_groups = explode(',', $group_list);


		$sql = 'SELECT	group_name
			,	group_id
			,	group_type
			FROM	' . GROUPS_TABLE . '
			WHERE	group_single_user = 0
			ORDER BY group_name';
		if (!($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'DEBUG: Unable to query groups table', '', __LINE__, __FILE__, $sql);
		}

		$page_group_selector = '<option value="0">' . $lang['No_page_group'] . '</option>';
		$group_counter = 1; // start at "one" to allow for "None"
		while ($group_row = $db->sql_fetchrow($result))
		{
			$group_counter++;
			$selected = in_array($group_row['group_id'], $page_groups) ? ' selected="selected" ' : '';
			switch ($group_row['group_type'])
			{
				case GROUP_OPEN:
					$group_type = $lang['Group_open'];
					break;
				case GROUP_CLOSED:
					$group_type = $lang['Group_closed'];
					break;
				case GROUP_HIDDEN:
					$group_type = $lang['Group_hidden'];
					break;
				default:
					$group_type = $lang['Unknown_group_type'];
			}
			$page_group_selector .= '<option ' . $selected . ' value="' . $group_row['group_id'] . '">' . $group_row['group_name'] . ' (' . $group_type . ')</option>';
		}

		if ($group_counter)
		{
			$group_counter = $group_counter > 25 ? 25 : $group_counter;
			$page_group_selector = '<select multiple size="' . $group_counter . '" name="page_groups[]">' . $page_group_selector ;
			$page_group_selector .= '</select>';
			$template->assign_block_vars('switch_group_selector',array());
		}

		$template->assign_vars(array(
			'PAGE_ID' => $data_row['page_id'],

			'PAGE_NAME' => $data_row['page_name'],
			'GUEST_VIEWS' => $guest_views,
			'MEMBER_VIEWS' => $member_views,
			'PAGE_PARM_NAME' => $data_row['page_parm_name'],
			'PAGE_PARM_VALUE' => $data_row['page_parm_value'],
			'CB_DISABLE_PAGE' => '<input type="checkbox" name="cb_disable_page" ' . ($disable_page == 1 ? ' checked="checked" ' : ''. ' />'),
			'DISABLED_MESSAGE' => $data_row['disabled_message'],
			'MIN_POST_COUNT' => $min_post_count,
			'MAX_POST_COUNT' => $max_post_count,
			'S_AUTH_LEVEL_SELECTOR' => $auth_level_selector,
			'S_PAGE_GROUP_SELECTOR' => $page_group_selector,

			'L_PAGE_ID' => $lang['Page_ID'],
			'L_PAGE_NAME' => $lang['Page_name'],
			'L_PAGE_PARM_NAME' => $lang['Page_parm_name'],
			'L_PAGE_PARM_NAME_EXPLAIN' => $lang['Page_parm_name_explain'],
			'L_PAGE_PARM_VALUE' => $lang['Page_parm_value'],
			'L_PAGE_PARM_VALUE_EXPLAIN' => $lang['Page_parm_value_explain'],
			'L_GUEST_VIEWS' => $lang['Guest_views'],
			'L_GUEST_VIEWS_EXPLAIN' => $lang['Guest_views_explain'],
			'L_MEMBER_VIEWS' => $lang['Member_views'],
			'L_MEMBER_VIEWS_EXPLAIN' => $lang['Member_views_explain'],
			'L_DISABLE_PAGE' => $lang['Disable_page'],
			'L_DISABLE_PAGE_EXPLAIN' => $lang['Disable_page_explain'],
			'L_PAGE_DISABLED_MESSAGE' => $lang['Page_disabled_message'],
			'L_PAGE_DISABLED_MESSAGE_EXPLAIN' => $lang['Page_disabled_message_explain'],
			'L_AUTH_LEVEL' => $lang['Auth_level'],
			'L_MIN_POST_COUNT' => $lang['Min_post_count'],
			'L_MIN_POST_COUNT_EXPLAIN' => $lang['Min_post_count_explain'],
			'L_MAX_POST_COUNT' => $lang['Max_post_count'],
			'L_MAX_POST_COUNT_EXPLAIN' => $lang['Max_post_count_explain'],
			'L_PAGE_GROUP' => $lang['Page_group'],
			'L_PAGE_GROUP_EXPLAIN' => $lang['Page_group_explain'],

			'L_EDIT' => $lang['Edit'],

			'L_SUBMIT' => $lang['Submit'],

			'S_ACTION' => append_sid("$thisPage"),
			'S_HIDDEN_FIELDS' => $s_hidden_fields
		));

		$template->pparse('body');

		include('./page_footer_admin.'.$phpEx);
	}
	else if( $mode == 'save' )
	{
		$page_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : 0;


		$page_name = ( isset($HTTP_POST_VARS['page_name']) ) ? trim($HTTP_POST_VARS['page_name']) : '';
		$page_parm_name = ( isset($HTTP_POST_VARS['page_parm_name']) ) ? trim($HTTP_POST_VARS['page_parm_name']) : '';
		$page_parm_value = ( isset($HTTP_POST_VARS['page_parm_value']) ) ? trim($HTTP_POST_VARS['page_parm_value']) : '';
		$page_key = $page_name . ($page_parm_name == '' ? '' : '?' . $page_parm_name . '=' . $page_parm_value);
		$guest_views = ( isset($HTTP_POST_VARS['guest_views']) ) ? intval($HTTP_POST_VARS['guest_views']) : 0;
		$member_views = ( isset($HTTP_POST_VARS['member_views']) ) ? intval($HTTP_POST_VARS['member_views']) : 0;
		$disable_page = ( isset($HTTP_POST_VARS['cb_disable_page']) ) ? ($HTTP_POST_VARS['cb_disable_page'] == 'on' ? 1 : 0) : 0;
		$disabled_message = ( isset($HTTP_POST_VARS['disabled_message']) ) ? trim($HTTP_POST_VARS['disabled_message']) : '';
		$auth_level = ( isset($HTTP_POST_VARS['auth_level']) ) ? intval($HTTP_POST_VARS['auth_level']) : 0;
		$min_post_count = ( isset($HTTP_POST_VARS['min_post_count']) ) ? intval($HTTP_POST_VARS['min_post_count']) : 0;
		$max_post_count = ( isset($HTTP_POST_VARS['max_post_count']) ) ? intval($HTTP_POST_VARS['max_post_count']) : 0;
		// Added extra step for security validation here, need
		// to read in the group and intval() each member of the
		// array prior to using it. Also need to verify that
		// it's actually an array to process...
		$group_list = '';
		if (isset($HTTP_POST_VARS['page_groups']))
		{
			if (!is_array($HTTP_POST_VARS['page_groups']))
			{
				$group_list = intval($HTTP_POST_VARS['page_groups']);
			}
			else
			{
				$group_list = implode(',', array_map('intval', $HTTP_POST_VARS['page_groups']));
			}
		}

		if( $page_id )
		{
			$sql = 'UPDATE ' . $thisTable . ' 
				SET 
					page_name = ' . "'" . secure_string($page_name) . "'" . '
				,	page_parm_name = "' . secure_string($page_parm_name) . '"
				,	page_parm_value = "' . secure_string($page_parm_value) . '"
				,	page_key = "' . secure_string($page_key) . '"
				, 	guest_views = ' . $guest_views . '
				, 	member_views = ' . $member_views . '
				, 	disable_page = ' . $disable_page . '
				, 	auth_level = ' . $auth_level . '
				, 	min_post_count = ' . $min_post_count . '
				, 	max_post_count = ' . $max_post_count . '
				,	group_list = "' . secure_string($group_list) . '"
				,	disabled_message = ' . "'" . secure_string($disabled_message) . "'" . '
				WHERE page_id = ' . $page_id;
			$message = $thisFunction . $lang['Updated'];;
		}
		else
		{
			$sql = 'INSERT INTO ' . $thisTable . ' (
					page_name
				,	page_parm_name
				,	page_parm_value
				,	page_key
				,	guest_views
				,	member_views
				,	disable_page
				,	auth_level
				,	min_post_count
				,	max_post_count
				,	group_list
				,	disabled_message
				) 
				VALUES (
					' . "'" . secure_string($page_name) . "'" . '
				,	' . "'" . secure_string($page_parm_name) . "'" . '
				,	' . "'" . secure_string($page_parm_value) . "'" . '
				,	' . "'" . secure_string($page_key) . "'" . '
				,	' . $guest_views . '
				,	' . $member_views . '
				,	' . $disable_page . '
				,	' . $auth_level . '
				,	' . $min_post_count . '
				,	' . $max_post_count . '
				,	' . "'" . secure_string($group_list) . "'" . '
				,	' . "'" . secure_string($disabled_message) . "'" . '
					)' ;
			$message = $thisFunction . $lang['Inserted'];
		}

		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'DEBUG: Could not insert or update ' . $thisFunction, $lang['Error'], __LINE__, __FILE__, $sql);
		}

		write_cache_file($cache_file, $thisTable, $array_name, $row_structure, $cache_key);

		$message .= $click_return_list;
		$message .= $click_return_admin;

		message_die(GENERAL_MESSAGE, $message);
	}
	else if( $mode == 'delete' )
	{
		if( isset($HTTP_POST_VARS['id']) ||  isset($HTTP_GET_VARS['id']) )
		{
			$page_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);
		}
		else
		{
			$page_id = 0;
		}

		if( $page_id )
		{
			$sql = 'DELETE FROM ' . $thisTable . " 
				WHERE page_id = $page_id";

			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'DEBUG: Could not remove '.$thisFunction, $lang['Error'], __LINE__, __FILE__, $sql);
			}

			write_cache_file($cache_file, $thisTable, $array_name, $row_structure, $cache_key);

			$message = $thisFunction. $lang['Deleted'];
			$message .= $click_return_list;
			$message .= $click_return_admin;

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_page_selected']);
		}
	}
	else if( $mode == 'cache' )
	{
		write_cache_file($cache_file, $thisTable, $array_name, $row_structure, $cache_key);

		$message = $thisFunction . $lang['Cache_updated'];
		$message .= $click_return_list;
		$message .= $click_return_admin;

		message_die(GENERAL_MESSAGE, $message);
	}
	else if ( $mode == 'disable' )
	{
		// Get a list of pages that are marked to disable
		// Note that this list may not have changed, so 
		// we'll check that in a bit
		$marked_to_disable = array();
		if (is_array($HTTP_POST_VARS['pages_to_disable']))
		{
			$marked_to_disable = $HTTP_POST_VARS['pages_to_disable'];
		}
		else
		{
			$marked_to_disable = array($HTTP_POST_VARS['pages_to_disable']);
		}

		// Get current pages that are disabled, to check to see
		// if any changes have been made, the intval() function
		// will be applied to each element of the array as it
		// is used further down in the code...
		$disabled_pages = array();
		if (is_array($HTTP_POST_VARS['disable_page']))
		{
			$disabled_pages = $HTTP_POST_VARS['disable_page'];
		}

		// Build an array of pages to set disabled ON or OFF.
		// There is an additional check to make sure that we
		// are not running unnecessary queries. For example,
		// we don't disable any pages that are already currently
		// disabled, and vice versa. To do this we pass two
		// arrays via the form, one is an array of checkboxes
		// which will only have a value for those where the
		// checkbox is checked. The other is a hidden array
		// of values that contains the current state of the
		// disabled flag. In this segment of code we look through
		// the hidden array (which has values of 0 or 1 for
		// every page) and compare to the values set to ON
		// via the checkbox array. Values that are OFF now
		// that were ON before are to be enabled. Values that
		// are now ON that were formerly OFF are changed to
		// disabled. Two arrays are built, and two queries run.
		$turn_page_off = array();
		$turn_page_on = array();
		foreach ($disabled_pages as $page_id => $disabled_flag)
		{
			if (isset($marked_to_disable[$page_id]))
			{
				if (intval($disabled_pages[$page_id]) == 0)
				{
					$turn_page_off[] = intval($page_id);
				}
			}
			else
			{
				if (intval($disabled_pages[$page_id]) == 1)
				{
					$turn_page_on[] = intval($page_id);
				}
			}
		}

		if (count($turn_page_off))
		{
			$sql = 'UPDATE ' . PAGES_TABLE . '
				SET	disable_page = 1
				WHERE	page_id in ' . '(' . implode(', ', $turn_page_off) . ')
				AND	disable_page = 0';

			if (!($result = $db->sql_query($sql)))
			{
				message_die (GENERAL_ERROR, 'DEBUG: Unable to disable marked pages', '', __LINE__, __FILE__, $sql);
			}
		}

		if (count($turn_page_off) == 1)
		{
			$message = $lang['1_page_disabled'];
		}
		else
		{
			$message = sprintf($lang['X_pages_disabled'], count($turn_page_off));
		}

		if (count($turn_page_on))
		{
			$sql = 'UPDATE ' . PAGES_TABLE . '
				SET	disable_page = 0
				WHERE	page_id in ' . '(' . implode(', ', $turn_page_on) . ')
				AND	disable_page = 1';

			if (!($result = $db->sql_query($sql)))
			{
				message_die (GENERAL_ERROR, 'DEBUG: Unable to enable marked pages', '', __LINE__, __FILE__, $sql);
			}
		}

		if (count($turn_page_on) == 1)
		{
			$message .= '<br /><br />' . $lang['1_page_enabled'];
		}
		else
		{
			$message .= '<br /><br />' . sprintf($lang['X_pages_enabled'], count($turn_page_on));
		}

		write_cache_file($cache_file, $thisTable, $array_name, $row_structure, $cache_key);

		$message .=  $click_return_list;
		$message .=  $click_return_admin;
		message_die(GENERAL_MESSAGE, $message);
	}
	else if ( $mode == 'switch' )
	{
		$count_views = ( isset($HTTP_POST_VARS['cb_count_views']) ) ? ($HTTP_POST_VARS['cb_count_views'] == 'on' ? 1 : 0) : 0;

		if (isset($board_config['phpbbdoctor_count_views']))
		{
			$sql = 'UPDATE ' . CONFIG_TABLE . '
				SET	config_value = "' . $count_views . '"
				WHERE	config_name = "phpbbdoctor_count_views"';
		}
		else
		{
			$sql = 'INSERT INTO ' . CONFIG_TABLE . '
				( 
					config_name
				,	config_value
				) VALUES (
					"phpbbdoctor_count_views"
				,	"' . $count_views . '"
				)';
		}

		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'DEBUG: Unable to alter count view setting', '', __LINE__, __FILE__, $sql);
		}

		$message = $lang['Page_view_count_is'] . ($count_views ? $lang['ON'] : $lang['OFF']);
		$message .= $click_return_list;
		$message .= $click_return_admin;
		message_die(GENERAL_MESSAGE, $message);
	}

}
else
{
	$template->set_filenames(array(
		'body' => 'admin/'.$thisTPLHeader.'list_body.tpl')
	);

	$sql = 'SELECT	* 
		FROM 	' . $thisTable . ' 
		ORDER BY page_name, page_parm_name';
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'DEBUG: Could not query ' . $thisFunction . ' information', $lang['Error'], __LINE__, __FILE__, $sql);
	}

	$total_guest_views = 0;
	$total_member_views = 0;
	$total_page_views = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		$data_rows[] = $row;
		$total_guest_views = $total_guest_views + $row['guest_views'];
		$total_member_views = $total_member_views + $row['member_views'];
	}
	$total_page_views = $total_guest_views + $total_member_views;
	$row_count = count($data_rows);

	$template->assign_vars(array(
		'L_PAGE_ID' => $lang['Page_ID'],
		'L_PAGE_NAME' => $lang['Page_name'],
		'L_GUEST_VIEWS' => $lang['Guest_views'],
		'L_GUEST_VIEWS_PCT' => $lang['Guest_views_pct'],
		'L_MEMBER_VIEWS' => $lang['Member_views'],
		'L_MEMBER_VIEWS_PCT' => $lang['Member_views_pct'],
		'L_PAGE_VIEWS' => $lang['Page_views'],
		'L_PAGE_VIEWS_PCT' => $lang['Page_views_pct'],
		'L_DISABLE_PAGE' => $lang['Disable_page'],
		'L_AUTH_LEVEL' => $lang['Auth_level'],
		'L_MIN_POST_COUNT' => $lang['Min_post_count'],
		'L_MAX_POST_COUNT' => $lang['Max_post_count'],

		'L_EDIT' => $lang['Edit'],
		'L_DELETE' => $lang['Delete'],

		'L_ADD' => $lang['Add_new_page'],
		'L_UPDATE_SELECTED_PAGES' => $lang['Update_selected_pages'],
		'L_ACTION' => $lang['Action'],

		'THIS_PAGE_NAME' => $thisPageName,
		'THIS_PAGE_EXPLAIN' => $thisPageExplain,

		'S_ACTION' => append_sid("$thisPage"),
		'S_HIDDEN_FIELDS' => '')
	);

	for($i = 0; $i < $row_count; $i++)
	{
		$row_class = ( !($i % 2) ) ? 'row1' : 'row2';

		$page_id = $data_rows[$i]['page_id'];

		$page_views = $data_rows[$i]['guest_views'] + $data_rows[$i]['member_views'];
		$page_name = $data_rows[$i]['page_name'] . ($data_rows[$i]['page_parm_name'] == '' ? '' : '?' . $data_rows[$i]['page_parm_name'] . '=' . $data_rows[$i]['page_parm_value']);

		$template->assign_block_vars('rowdata', array(
			'ROW_CLASS' => $row_class,

			'PAGE_ID' => $data_rows[$i]['page_id'],
			'PAGE_NAME' => $page_name,

			'GUEST_VIEWS' => number_format($data_rows[$i]['guest_views'],0),
			'GUEST_VIEWS_PCT' => @number_format($data_rows[$i]['guest_views']/$total_guest_views*100,0),

			'MEMBER_VIEWS' => number_format($data_rows[$i]['member_views'],0),
			// @ sign ignores divide by zero errors
			'MEMBER_VIEWS_PCT' => @number_format($data_rows[$i]['member_views']/$total_member_views*100,0),

			'PAGE_VIEWS' => number_format($page_views,0),
			// @ sign ignores divide by zero errors
			'PAGE_VIEWS_PCT' => @number_format($page_views/$total_page_views*100,0),

			'DISABLE_PAGE' => '<input type="hidden" name="disable_page[' . $data_rows[$i]['page_id'] . ']" value="' . $data_rows[$i]['disable_page'] . '" />',
			'CB_DISABLE_PAGE' => '<input type="checkbox" name="pages_to_disable[' . $data_rows[$i]['page_id'] . ']" ' . ($data_rows[$i]['disable_page'] == 1 ? ' checked="checked" ' : '') . ' />',
			'AUTH_LEVEL' => $page_auth_levels[$data_rows[$i]['auth_level']],
			'MIN_POST_COUNT' => $data_rows[$i]['min_post_count'],
			'MAX_POST_COUNT' => $data_rows[$i]['max_post_count'],

			'U_EDIT' => append_sid("$thisPage?mode=edit&amp;id=$page_id"),
			'U_DELETE' => append_sid("$thisPage?mode=delete&amp;id=$page_id"))
		);
	}

	if (isset($board_config['phpbbdoctor_count_views']))
	{
		$count_views = intval($board_config['phpbbdoctor_count_views']);
	}
	else
	{
		$count_views = 1;
	}

	$template->assign_vars(array(
		'L_REBUILD_CACHE' => $lang['Rebuild_cache'],
		'L_COUNT_VIEWS' => $lang['Count_views'],
		'L_SAVE_COUNT_VIEWS' => $lang['Save_count_views'],
		'CB_COUNT_VIEWS' => '<input type="checkbox" name="cb_count_views" ' . ($count_views == 1 ? ' checked="checked" ' : ''. ' />'),

		'TOTAL_PAGE_VIEWS' => number_format($total_page_views,0),
		'TOTAL_GUEST_VIEWS' => number_format($total_guest_views,0),
		'TOTAL_MEMBER_VIEWS' => number_format($total_member_views,0),
		'TOTAL_GUEST_PCT' => @number_format($total_guest_views / $total_page_views * 100, 0),
		'TOTAL_MEMBER_PCT' => @number_format($total_member_views / $total_page_views * 100, 0),
		'L_TOTAL_PAGE_VIEWS' => $lang['Total_page_views']
		));
}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
