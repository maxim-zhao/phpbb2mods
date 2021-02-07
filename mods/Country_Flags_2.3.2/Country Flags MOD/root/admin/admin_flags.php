<?php
/***************************************************************************
 *                              admin_flags.php
 *                            -------------------
 *   begin                : Thursday, February 6, 2003
 *   written by Nuttzy
 *   updated by ycl6
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

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Users']['Flags'] = $file;
	return;
}

define('IN_PHPBB', 1);

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = (isset($HTTP_GET_VARS['mode'])) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else 
{
	//
	// These could be entered via a form button
	//
	if( isset($HTTP_POST_VARS['add']) )
	{
		$mode = "add";
	}
	else if( isset($HTTP_POST_VARS['save']) )
	{
		$mode = "save";
	}
	else
	{
		$mode = "";
	}
}

// Restrict mode input to valid options
$mode = ( in_array($mode, array('add', 'edit', 'save', 'delete')) ) ? $mode : '';

if( $mode != "" )
{
	if( $mode == "edit" || $mode == "add" )
	{
		//
		// They want to add a new flag, show the form.
		//
		$flag_id = ( isset($HTTP_GET_VARS['id']) ) ? intval($HTTP_GET_VARS['id']) : 0;
		
		$s_hidden_fields = "";
		
		if( $mode == "edit" )
		{
			if( $flag_id )
			{
				$sql = "SELECT * 
					FROM " . FLAG_TABLE . "
					WHERE flag_id = $flag_id";
				if(!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Couldn't obtain flag data", $lang['Error'], __LINE__, __FILE__, $sql);
				}
			
				$flag_info = $db->sql_fetchrow($result);
				$s_hidden_fields .= '<input type="hidden" name="id" value="' . $flag_id . '" />';
			}
			else
			{
				message_die(GENERAL_MESSAGE, $lang['Must_select_flag']);
			}

		}

		$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';

		$template->set_filenames(array(
			"body" => "admin/flags_edit_body.tpl")
		);

		$template->assign_vars(array(
			"FLAG" => $flag_info['flag_name'],
			"IMAGE" => ( $flag_info['flag_image'] != "" ) ? $flag_info['flag_image'] : "",
			"IMAGE_DISPLAY" => ( $flag_info['flag_image'] != "" ) ? '<img src="../images/flags/' . $flag_info['flag_image'] . '" />' : '',
			
			"L_FLAGS_TITLE" => $lang['Flags_title'],
			"L_FLAGS_TEXT" => $lang['Flags_explain'],
			"L_FLAG_NAME" => $lang['Flag_name'],
			"L_FLAG_IMAGE" => $lang['Flag_image'],
			"L_FLAG_IMAGE_EXPLAIN" => $lang['Flag_image_explain'],
			"L_SUBMIT" => $lang['Submit'],
			"L_RESET" => $lang['Reset'],
			
			"S_FLAG_ACTION" => append_sid("admin_flags.$phpEx"),
			"S_HIDDEN_FIELDS" => $s_hidden_fields)
		);

		$template->pparse("body");

		include('./page_footer_admin.'.$phpEx);
	}
	else if( $mode == "save" )
	{
		$flag_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : 0;
		$flag_name = ( isset($HTTP_POST_VARS['title']) ) ? trim($HTTP_POST_VARS['title']) : "";
		$flag_image = ( (isset($HTTP_POST_VARS['flag_image'])) ) ? trim($HTTP_POST_VARS['flag_image']) : "";

		if( $flag_name == "" )
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_flag']);
		}

		//
		// The flag image has to be a jpg, jpeg, gif or png
		//
		if( $flag_image != "" )
		{
			if(!preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $flag_image))
			{
				$flag_image = "";
			}
		}

		if ( $flag_id )
		{
			$sql = "UPDATE " . FLAG_TABLE . "
				SET flag_name = '" . str_replace("\'", "''", $flag_name) . "', flag_image = '" . str_replace("\'", "''", $flag_image) . "'
				WHERE flag_id = $flag_id";
			$message = $lang['Flag_updated'];
		}
		else
		{
			$sql = "INSERT INTO " . FLAG_TABLE . " (flag_name, flag_image)
				VALUES ('" . str_replace("\'", "''", $flag_name) . "', '" . str_replace("\'", "''", $flag_image) . "')";
			$message = $lang['Flag_added'];
		}
		
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update/insert into flags table", $lang['Error'], __LINE__, __FILE__, $sql);
		}

		$message .= "<br /><br />" . sprintf($lang['Click_return_flagadmin'], "<a href=\"" . append_sid("admin_flags.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
	else if( $mode == "delete" )
	{
		if( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
		{
			$flag_id = ( isset($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];
			$flag_id = intval($flag_id);
		}
		else
		{
			$flag_id = 0;
		}

		$confirm = isset($HTTP_POST_VARS['confirm']);

		if( $flag_id && $confirm )
		{
			$sql = "DELETE FROM " . FLAG_TABLE . " 
				WHERE flag_id = $flag_id";

			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't delete flag data", $lang['Error'], __LINE__, __FILE__, $sql);
			}

			$message = $lang['Flag_removed'] . "<br /><br />" . sprintf($lang['Click_return_flagadmin'], "<a href=\"" . append_sid("admin_flags.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
		}
		elseif( $flag_id && !$confirm)
		{
			// Present the confirmation screen to the user
			$template->set_filenames(array(
				'body' => 'admin/confirm_body.tpl')
			);

			$hidden_fields = '<input type="hidden" name="mode" value="delete" /><input type="hidden" name="id" value="' . $flag_id . '" />';

			$template->assign_vars(array(
				'MESSAGE_TITLE' => $lang['Flag_confirm'],
				'MESSAGE_TEXT' => $lang['Confirm_delete_flag'],

				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],

				'S_CONFIRM_ACTION' => append_sid("admin_flags.$phpEx"),
				'S_HIDDEN_FIELDS' => $hidden_fields)
			);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_flag']);
		}
	}
}
else
{
	$template->set_filenames(array(
		"body" => "admin/flags_list_body.tpl")
	);
	
	$sql = "SELECT * 
		FROM " . FLAG_TABLE . "
		ORDER BY flag_name";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain flags data", $lang['Error'], __LINE__, __FILE__, $sql);
	}

	$flag_rows = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);
	$flag_count = count($flag_rows);
	
	$template->assign_vars(array(
		"L_FLAGS_TITLE" => $lang['Flags_title'],
		"L_FLAGS_TEXT" => $lang['Flags_explain'],
		"L_FLAG" => $lang['Flag_name'],
		"L_FLAG_PIC" => $lang['Flag_pic'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ADD_FLAG" => $lang['Add_new_flag'],
		"L_ACTION" => $lang['Action'],
		
		"S_FLAGS_ACTION" => append_sid("admin_flags.$phpEx"))
	);
	
	for($i = 0; $i < $flag_count; $i++)
	{
		$flag = $flag_rows[$i]['flag_name'];
		$flag_id = $flag_rows[$i]['flag_id'];
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("flags", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"FLAG" => $flag,
			"IMAGE_DISPLAY" => ( $flag_rows[$i]['flag_image'] != "" ) ? '<img src="../images/flags/' . $flag_rows[$i]['flag_image'] . '" border="0" />' : '',

			"U_FLAG_EDIT" => append_sid("admin_flags.$phpEx?mode=edit&amp;id=$flag_id"),
			"U_FLAG_DELETE" => append_sid("admin_flags.$phpEx?mode=delete&amp;id=$flag_id"))
		);
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
