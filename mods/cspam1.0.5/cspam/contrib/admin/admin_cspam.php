<?php
/***************************************************************************
 *                            admin_user_ban.php
 *                            -------------------
 *   begin                : Tuesday, Jul 31, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_user_ban.php,v 1.21.2.5 2004/03/25 15:57:20 acydburn Exp $
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

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['cspam_name'] = $filename;

	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Start program
//
if ( isset($HTTP_POST_VARS['submit']) )
{
	if ( isset($HTTP_POST_VARS['cspam_general']) && $board_config['cspam_general'] != $HTTP_POST_VARS['cspam_general'] )
	{
		$HTTP_POST_VARS['cspam_general'] = ($HTTP_POST_VARS['cspam_general'] == 1) ? 1 : 0;
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = " . $HTTP_POST_VARS['cspam_general'] . " WHERE config_name = 'cspam_general'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update cspam_general in database", "", __LINE__, __FILE__, $sql);
		}
	}

	$except_sql = '';

	$except_list = array();
	if ( isset($HTTP_POST_VARS['cspam_except']) )
	{
		$except_list_temp = explode(',', $HTTP_POST_VARS['cspam_except']);

		for($i = 0; $i < count($except_list_temp); $i++)
		{
			$except_list[] = trim($except_list_temp[$i]);
		}
	}

	$sql = "SELECT *
		FROM " . CSPAM_EXCEPT_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain current exception list", "", __LINE__, __FILE__, $sql);
	}

	$current_exceptlist = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	for($i = 0; $i < count($except_list); $i++)
	{
		$in_exceptlist = false;
		if ($except_list[$i] == '')
		{
			$in_exceptlist = true;
		}

		for($j = 0; $j < count($current_exceptlist) && !$in_exceptlist; $j++)
		{
			if ( $except_list[$i] == $current_exceptlist[$j]['except'] )
			{
				$in_exceptlist = true;
			}
		}

		if ( !$in_exceptlist )
		{
			$sql = 'INSERT INTO ' . CSPAM_EXCEPT_TABLE . " (except)
				VALUES ('" . str_replace("\'", "''", trim($except_list[$i])) . "')";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert cspam_except info into database", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	$where_sql = '';

	if ( isset($HTTP_POST_VARS['remove_except']) )
	{
		$except_list = $HTTP_POST_VARS['remove_except'];

		for($i = 0; $i < count($except_list); $i++)
		{
			if ( $user_list[$i] != -1 )
			{
				$where_sql .= ( ( $where_sql != '' ) ? ', ' : '' ) . "'" . str_replace("\'", "''", trim($except_list[$i])) . "'";
			}
		}
	}

	if ( $where_sql != '' )
	{
		$sql = "DELETE FROM " . CSPAM_EXCEPT_TABLE . "
			WHERE except IN ($where_sql)";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't delete exception info from database", "", __LINE__, __FILE__, $sql);
		}
	}
	$message = $lang['cspam_update_success'] . '<br /><br />' . sprintf($lang['cspam_return'], '<a href="' . append_sid("admin_cspam.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

	message_die(GENERAL_MESSAGE, $message);

}
else
{
	$cspam_all = ( !$board_config['cspam_general'] ) ? "checked=\"checked\"" : "";
	$cspam_none = ( $board_config['cspam_general'] ) ? "checked=\"checked\"" : "";

	$sql = "SELECT except FROM " . CSPAM_EXCEPT_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain current exception list', '', __LINE__, __FILE__, $sql);
	}
	$exception_list = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$select_exceptlist = '';
	for($i = 0; $i < count($exception_list); $i++)
	{
		$select_exceptlist .= '<option value="' . $exception_list[$i]['except'] . '">' . $exception_list[$i]['except'] . '</option>';
		$exception_count++;
	}

	if( $select_exceptlist == '' )
	{
		$select_exceptlist = '<option value="-">' . $lang['cspam_no_excepts'] . '</option>';
	}

	$select_exceptlist = '<select name="remove_except[]" multiple="multiple" size="5">' . $select_exceptlist . '</select>';

	$template->set_filenames(array(
		'body' => 'admin/cspam_manage_body.tpl')
	);

	$template->assign_vars(array(
		'L_CSPAM_TITLE' => $lang['cspam'],
		'L_CSPAM_DESC' => $lang['cspam_desc'],
		'L_CSPAM_MANAGE' => $lang['cspam_manage'],
		'L_CSPAM_GENERAL' => $lang['cspam_gen'],
		'L_CSPAM_GENERAL_DESC' => $lang['cspam_gen_desc'],
		'L_CSPAM_ALL' => $lang['cspam_gen_all'],
		'L_CSPAM_NONE' => $lang['cspam_gen_none'],
		'L_CSPAM_EXCEPT' => $lang['cspam_except'],
		'L_CSPAM_EXCEPT_DESC' => $lang['cspam_except_desc'],
		'L_CSPAM_ADD' => $lang['cspam_add'],
		'L_CSPAM_ADD_DESC' => $lang['cspam_add_desc'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],

		'CSPAM_ALL' => $cspam_all,
		'CSPAM_NONE' => $cspam_none,
		'S_CSPAM_EXPECT_SELECT' => $select_exceptlist,
		'S_CSPAM_ACTION' => append_sid("admin_cspam.$phpEx"))
	);

}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);