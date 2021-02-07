<?php
/***************************************************************************
                               admin_actions.php 
                             -------------------
    begin			: Sat April 08 2006
    copyright		: Daniel Vandersluis
    email			: daniel@codexed.com
    version			: 1.0.0

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
	$module['General']['Actions'] = $filename;

	return;
}

//
// Load default header
//
$no_page_header = FALSE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx); 

//
// Handle the different modes:
//
if (isset($HTTP_POST_VARS['mode']) || (isset($HTTP_GET_VARS['mode'])))
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = strtolower(htmlspecialchars($mode));
}

if ($mode == "add" || $mode == "edit")
{
	if ($mode == "edit")
	{
		$s_hidden_fields = "";
		$action_id = isset($HTTP_GET_VARS['id']) ? intval($HTTP_GET_VARS['id']) : 0;

		if( empty($action_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_action']);
		}
		
		$sql = "SELECT *
			FROM " . ACTIONS_TABLE . "
			WHERE action_id = $action_id";

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Couldn't obtain action data", "", __LINE__, __FILE__, $sql);
		}
		$action_info = $db->sql_fetchrow($result);
		
		$s_hidden_fields .= '<input type="hidden" name="action_id" value="' . $action_id . '" />';
	}

	$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';
	$action_active = (!isset($action_info) || $action_info['action_status'] == ACTION_ACTIVE) ? 'selected="selected"' : "";
	$action_inactive = (isset($action_info) && $action_info['action_status'] == ACTION_INACTIVE) ? 'selected="selected"' : "";

	$template->set_filenames(array(
		"body" => "admin/actions_edit_body.tpl")
	);

	$template->assign_vars(array(
		"ACTION_NAME" => $action_info['action_name'],
		"ACTION_TEXT" => $action_info['action_text'],
		"ACTION_STATUS" => $action_info['action_status'],
		"ACTION_STATUS_ACTIVE" => $action_active,
		"ACTION_STATUS_INACTIVE" => $action_inactive,
		
		"L_ACTIONS_TITLE" => $lang['Actions_title'],
		"L_ACTIONS_EXPLAIN" => $lang['Actions_explain'],
		"L_ACTIONS_NAME" => $lang['Actions_name'],
		"L_ACTIONS_TEXT" => $lang['Actions_text'],
		"L_ACTIONS_STATUS" => $lang['Actions_status'],
		"L_SUBMIT" => $lang['Submit'],
		"L_RESET" => $lang['Reset'],
		"L_ACTIVE" => $lang['Actions_status_active'],
		"L_INACTIVE" => $lang['Actions_status_inactive'],
		
		"S_ACTIVE" => ACTION_ACTIVE,
		"S_INACTIVE" => ACTION_INACTIVE,
		"S_ACTIONS_ACTION" => append_sid("admin_actions.$phpEx"),
		"S_HIDDEN_FIELDS" => $s_hidden_fields)
	);
}
elseif ($mode == "save")
{
	//
	// Ok, they sent us our info, let's update it.
	//
		
	$action_id = (isset($HTTP_POST_VARS['action_id'])) ? intval($HTTP_POST_VARS['action_id']) : 0;
	$action_name = (isset($HTTP_POST_VARS['action_name'])) ? str_replace("\'", "''", trim($HTTP_POST_VARS['action_name'])) : "";
	$action_text = (isset($HTTP_POST_VARS['action_text'])) ? str_replace("\'", "''", trim($HTTP_POST_VARS['action_text'])) : "";
	$action_status = intval($HTTP_POST_VARS['action_status']);
			
	if ( $action_name == "" )
	{
		message_die(GENERAL_MESSAGE, $lang['Must_select_action']);
	}
	if ( $action_text == "" )
	{
		message_die(GENERAL_MESSAGE, $lang['Must_enter_action_text']);
	}
	
	if ($action_id != 0)
	{
		$sql = "UPDATE " . ACTIONS_TABLE . "
			SET action_name = '$action_name',
				action_text = '$action_text',
				action_status = $action_status
			WHERE action_id = $action_id";

		$message = $lang['Action_updated'];
	}
	else
	{
		$sql = "INSERT INTO " . ACTIONS_TABLE . " (action_name, action_text, action_status)
			VALUES ('$action_name', '$action_text', $action_status)";			

		$message = $lang['Action_added'];
	}

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't update/insert into actions table", "", __LINE__, __FILE__, $sql);
	}

	$message .= "<br /><br />" . sprintf($lang['Click_return_actionsadmin'], "<a href=\""
			 . append_sid("admin_actions.$phpEx") . "\">", "</a>") . "<br /><br />"
			 . sprintf($lang['Click_return_admin_index'], "<a href=\""
			 . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}
elseif ($mode == "delete")
{
	//
	// Ok, they want to delete their action 
	//
	
	$action_id = isset($HTTP_POST_VARS['id']) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);
	if (empty($action_id))
	{
		message_die(GENERAL_MESSAGE, $lang['Must_select_action']); 
	}
	
	$sql = "DELETE FROM " . ACTIONS_TABLE . "
		WHERE action_id = $action_id";

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't delete action data", "", __LINE__, __FILE__, $sql);
	}	

	$sql = "DELETE FROM " . ACTIONS_PERFORMED_TABLE . "
		WHERE action_id = $action_id";

	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't delete action data", "", __LINE__, __FILE__, $sql);
	}
	
	$message = $lang['Action_removed'] . "<br /><br />"
			 . sprintf($lang['Click_return_actionsadmin'], "<a href=\"" . append_sid("admin_actions.$phpEx")
			 . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\""
			 . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}
else
{
	$template->set_filenames(array(
		"body" => "admin/actions_list_body.tpl")
	);
	
	$template->assign_vars(array(
		"L_ACTIONS_TITLE" => $lang['Actions_title'],
		"L_ACTIONS_EXPLAIN" => $lang['Actions_explain'],
		"L_ACTIONS_NAME" => $lang['Actions_name'],
		"L_ACTIONS_TEXT" => $lang['Actions_text'],
		"L_ACTIONS_STATUS" => $lang['Actions_status'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ADD_ACTION" => $lang['Add_new_action'],
		"L_ACTION" => $lang['Action'],
		"L_NO_ACTIONS" => $lang['Actions_no_actions'],
		
		"S_ACTIONS_ACTION" => append_sid("admin_actions.$phpEx"))
	);
	
	//
	// Get Action data from DB
	//
	$sql = "SELECT *
		FROM " . ACTIONS_TABLE;
		
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain actions data", "", __LINE__, __FILE__, $sql);
	}
	$action_count = $db->sql_numrows($result);
	$action_rows = $db->sql_fetchrowset($result);
	
	if ($action_count == 0)
	{
		$template->assign_block_vars("noactions", array());
		$template->assign_vars(array(
			"T_ROW_COLOR" => $theme['td_color1'],
			"T_ROW_CLASS" => $theme['td_class1'])
		);
	}
	else
	{
		for($i = 0; $i < $action_count; $i++)
		{
			$action = $action_rows[$i]['action_name'];
			$action_text = $action_rows[$i]['action_text'];
			$action_id = $action_rows[$i]['action_id'];
			$action_status = $action_rows[$i]['action_status'] == ACTION_ACTIVE ? $lang['Actions_status_active']
				: $lang['Actions_status_inactive'];
			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars("actions", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				"ACTION" => $action,
				"ACTION_TEXT" => $action_text,
				"ACTION_STATUS" => $action_status,

				"U_ACTION_EDIT" => append_sid("admin_actions.$phpEx?mode=edit&amp;id=$action_id"),
				"U_ACTION_DELETE" => append_sid("admin_actions.$phpEx?mode=delete&amp;id=$action_id"))
			);
		}
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);
?>
