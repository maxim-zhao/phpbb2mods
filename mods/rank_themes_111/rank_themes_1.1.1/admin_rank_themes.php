<?php
/***************************************************************************
 *                           admin_rank_themes.php
 *                            -------------------
 *   begin                : Sunday Mar 30, 2005
 *   email                : digitalTsai@gmail.com
 *
 *   $Id: admin_rank_themes.php,v 0.1.00 2005/03/30 00:00:00 digiTsai Exp $
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

// entries to be displayed in the ACP index
if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['Users']['Rank_Themes'] = $file;
	return;
}


//
// Let's set the root dir for phpBB
//
$script_path = 'admin' ;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

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


if( $mode != "" )
{
	if( $mode == "edit" || $mode == "add" )
	{
		//
		// They want to add a new rank, show the form.
		//
		$rtheme_id = ( isset($HTTP_GET_VARS['id']) ) ? intval($HTTP_GET_VARS['id']) : 0;
		
		$s_hidden_fields = "";
		
		if( $mode == "edit" )
		{
			if( empty($rtheme_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['Must_select_rtheme']);
			}

			$sql = "SELECT * FROM " . RANK_THEMES_TABLE . "
				WHERE rtheme_id = $rtheme_id";
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't obtain rank theme data", "", __LINE__, __FILE__, $sql);
			}
			
			$rtheme_info = $db->sql_fetchrow($result);
			$s_hidden_fields .= '<input type="hidden" name="id" value="' . $rtheme_id . '" />';

		}
		else
		{
			$rtheme_info['rtheme_public'] = 1;
		}

		$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';

		$rtheme_is_public = ( $rtheme_info['rtheme_public'] ) ? "checked=\"checked\"" : "";
		$rtheme_is_not_public = ( !$rtheme_info['rtheme_public'] ) ? "checked=\"checked\"" : "";
		
		$template->set_filenames(array(
			"body" => "admin/rank_themes_edit_body.tpl")
		);

		$template->assign_vars(array(
			"RTHEME" => $rtheme_info['rtheme_title'],
			"PUBLIC_RTHEME" => $rtheme_is_public,
			"NOT_PUBLIC_RTHEME" => $rtheme_is_not_public,
			
			"L_RTHEMES_TITLE" => $lang['Rthemes_title'],
			"L_RTHEME_TEXT" => $lang['Rthemes_explain'],
			"L_RTHEME_TITLE" => $lang['Rtheme_title'],
			"L_RTHEME_PUBLIC" => $lang['Rtheme_public'],

			"L_SUBMIT" => $lang['Submit'],
			"L_RESET" => $lang['Reset'],
			"L_YES" => $lang['Yes'],
			"L_NO" => $lang['No'],
			
			"S_RTHEME_ACTION" => append_sid("admin_rank_themes.$phpEx"),
			"S_HIDDEN_FIELDS" => $s_hidden_fields)
		);
		
	}
	else if( $mode == "save" )
	{
		//
		// Ok, they sent us our info, let's update it.
		//
		
		$rtheme_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : 0;
		$rtheme_title = ( isset($HTTP_POST_VARS['title']) ) ? trim($HTTP_POST_VARS['title']) : "";
		$public_rtheme = ( $HTTP_POST_VARS['public_rtheme'] == 1 ) ? TRUE : 0;

		if( $rtheme_title == "" )
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_rtheme']);
		}


		if ($rtheme_id)
		{
			if (!$public_rtheme)
			{
				$sql = "UPDATE " . USERS_TABLE . " 
					SET user_rank = 0, user_rank_theme = 1 
					WHERE user_rank_theme = $rtheme_id";

				if( !$result = $db->sql_query($sql) ) 
				{
					message_die(GENERAL_ERROR, $lang['No_update_rthemes'], "", __LINE__, __FILE__, $sql);
				}
			}
			$sql = "UPDATE " . RANK_THEMES_TABLE . "
				SET rtheme_title = '" . str_replace("\'", "''", $rtheme_title) . "', rtheme_public = '" . str_replace("\'", "''", $public_rtheme) . "'
				WHERE rtheme_id = $rtheme_id";

			$message = $lang['Rtheme_updated'];
		}
		else
		{
			$sql = "INSERT INTO " . RANK_THEMES_TABLE . " (rtheme_title, rtheme_public)
				VALUES ('" . str_replace("\'", "''", $rtheme_title) . "', $public_rtheme)";

			$message = $lang['Rtheme_added'];
		}
		
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update/insert into rank themes table", "", __LINE__, __FILE__, $sql);
		}

		$message .= "<br /><br />" . sprintf($lang['Click_return_rankthemeadmin'], "<a href=\"" . append_sid("admin_rank_themes.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);

	}
	else if( $mode == "delete" )
	{
		//
		// Ok, they want to delete their rank
		//
		
		if( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
		{
			$rtheme_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);
		}
		else
		{
			$rtheme_id = 0;
		}
		
		if( $rtheme_id )
		{
			$sql = "DELETE FROM " . RANK_THEMES_TABLE . "
				WHERE rtheme_id = $rtheme_id";
			
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete rank theme data", "", __LINE__, __FILE__, $sql);
			}
			
			$sql = "UPDATE " . USERS_TABLE . " 
				SET user_rank = 0, user_rank_theme = 1 
				WHERE user_rank_theme = $rtheme_id";

			if( !($result = $db->sql_query($sql)) ) 
			{
				message_die(GENERAL_ERROR, $lang['No_update_rthemes'], "", __LINE__, __FILE__, $sql);
			}

			$sql = "UPDATE " . RANKS_TABLE . " 
				SET rank_theme = 1 
				WHERE rank_theme = $rtheme_id";

			if( !($result = $db->sql_query($sql)) ) 
			{
				message_die(GENERAL_ERROR, $lang['No_update_rthemes'], "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rtheme_removed'] . "<br /><br />" . sprintf($lang['Click_return_rankadmin'], "<a href=\"" . append_sid("admin_rank_themes.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_rtheme']);
		}
	}
	else
	{
		//
		// They didn't feel like giving us any information. Oh, too bad, we'll just display the
		// list then...
		//
		$template->set_filenames(array(
			"body" => "admin/rank_themes_list_body.tpl")
		);
		
		$sql = "SELECT * FROM " . RANK_THEMES_TABLE . "
			WHERE rtheme_id > 1
			ORDER BY rtheme_public,rtheme_title";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain rank themes data", "", __LINE__, __FILE__, $sql);
		}
		
		$rtheme_rows = $db->sql_fetchrowset($result);
		$rtheme_count = count($rtheme_rows);
		
		$template->assign_vars(array(
			"L_RTHEMES_TITLE" => $lang['Rthemes_title'],
			"L_RTHEMES_TEXT" => $lang['Rthemes_explain'],
			"L_RTHEME" => $lang['Rtheme_title'],
			"L_PUBLIC_RTHEME" => $lang['Rtheme_public'],
			"L_EDIT" => $lang['Edit'],
			"L_DELETE" => $lang['Delete'],
			"L_ADD_RTHEME" => $lang['Add_new_rtheme'],
			"L_ACTION" => $lang['Action'],
			
			"S_RTHEME_ACTION" => append_sid("admin_rank_themes.$phpEx"))
		);
		
		for( $i = 0; $i < $rtheme_count; $i++)
		{
			$rtheme = $rtheme_rows[$i]['rtheme_title'];
			$public_rtheme = $rtheme_rows[$i]['rtheme_special'];
			$rtheme_id = $rtheme_rows[$i]['rtheme_id'];
			
			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	
			$template->assign_block_vars("rthemes", array(
				"ROW_COLOR" => "#" . $row_color,
				"ROW_CLASS" => $row_class,
				"RANK" => $rank,

				"PUBLIC_RTHEME" => ( $public_rtheme == 1 ) ? $lang['Yes'] : $lang['No'],

				"U_RTHEME_EDIT" => append_sid("admin_rank_themes.$phpEx?mode=edit&amp;id=$rtheme_id"),
				"U_RTHEME_DELETE" => append_sid("admin_rank_themes.$phpEx?mode=delete&amp;id=$rtheme_id"))
			);
		}
	}
}
else
{
	//
	// Show the default page
	//
	$template->set_filenames(array(
		"body" => "admin/rank_themes_list_body.tpl")
	);
	
	$sql = "SELECT * FROM " . RANK_THEMES_TABLE . "
		WHERE rtheme_id > 1
		ORDER BY rtheme_public, rtheme_title";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain rank themes data", "", __LINE__, __FILE__, $sql);
	}
	$rtheme_count = $db->sql_numrows($result);

	$rtheme_rows = $db->sql_fetchrowset($result);
	
	$template->assign_vars(array(
			"L_RTHEMES_TITLE" => $lang['Rthemes_title'],
			"L_RTHEMES_TEXT" => $lang['Rthemes_explain'],
			"L_RTHEME" => $lang['Rtheme_title'],
			"L_PUBLIC_RTHEME" => $lang['Rtheme_public'],
			"L_EDIT" => $lang['Edit'],
			"L_DELETE" => $lang['Delete'],
			"L_ADD_RTHEME" => $lang['Add_new_rtheme'],
			"L_ACTION" => $lang['Action'],
			
			"S_RTHEME_ACTION" => append_sid("admin_rank_themes.$phpEx"))
	);
	
	for($i = 0; $i < $rtheme_count; $i++)
	{
		$rtheme = $rtheme_rows[$i]['rtheme_title'];
		$public_rtheme = $rtheme_rows[$i]['rtheme_public'];
		$rtheme_id = $rtheme_rows[$i]['rtheme_id'];
		
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$rtheme_is_public = ( $public_rtheme ) ? $lang['Yes'] : $lang['No'];

		$template->assign_block_vars("rthemes", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"RTHEME" => $rtheme,
			"PUBLIC_RTHEME" => ( $public_rtheme == 1 ) ? $lang['Yes'] : $lang['No'],

			"U_RTHEME_EDIT" => append_sid("admin_rank_themes.$phpEx?mode=edit&amp;id=$rtheme_id"),
			"U_RTHEME_DELETE" => append_sid("admin_rank_themes.$phpEx?mode=delete&amp;id=$rtheme_id"))
		);
	}
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
