<?php
/***************************************************************************
 *                             Name in Profile
 *                            -------------------
 *   begin                : Monday, March 27, 2005
 *   copyright            : (C) 2005 The Defpom
 *   email                :  
 *   web site             :  http://www.radiomods.co.nz
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
	$file = basename(__FILE__);
	$module['User Profile']['Name in Profile'] = "$file";
	return;
}
//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');

require('./pagestart.' . $phpEx);
//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_user_name", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ($config_name == 'cookie_name')
		{
			$cookie_name = str_replace('.', '_', $new['cookie_name']);
		}

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_name_config'], "<a href=\"" . append_sid("admin_name_in_profile.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}




$name_first_required_yes = ( $new['name_first_required'] ) ? "checked=\"checked\"" : "";
$name_first_required_no = ( !$new['name_first_required'] ) ? "checked=\"checked\"" : "";
$name_last_required_yes = ( $new['name_last_required'] ) ? "checked=\"checked\"" : "";
$name_last_required_no = ( !$new['name_last_required'] ) ? "checked=\"checked\"" : "";


$name_first_display_yes = ( $new['name_first_display'] ) ? "checked=\"checked\"" : "";
$name_first_display_no = ( !$new['name_first_display'] ) ? "checked=\"checked\"" : "";
$name_last_display_yes = ( $new['name_last_display'] ) ? "checked=\"checked\"" : "";
$name_last_display_no = ( !$new['name_last_display'] ) ? "checked=\"checked\"" : "";



$template->set_filenames(array(
	"body" => "admin/name_in_profile_body.tpl")
);


$temp = '';


$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_name_in_profile.$phpEx"),
	
	"L_NAME_TITLE" => $lang['name_title'],
	"L_NAME_EXPLAIN" => $lang['name_explain'],
	
	"L_NAME_REQUIRED" => $lang['name_required'],
	"L_NAME_DISPLAY" => $lang['name_display'],
	
	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],

	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'],	
	
	"L_NAME_FIRST_REQUIRED" => $lang['name_first_required'],
	"L_NAME_LAST_REQUIRED" => $lang['name_last_required'],
	"L_NAME_FIRST_DISPLAY" => $lang['name_first_display'],
	"L_NAME_LAST_DISPLAY" => $lang['name_last_display'],
	
	"L_NAME_FIRST_DISPLAY_WARNING" => $lang['name_first_display_warning'],
	"L_NAME_LAST_DISPLAY_WARNING" => $lang['name_last_display_warning'],
	"L_NAME_DISPLAY_WARNING" => $lang['name_display_warning'],
	
		
	"NAME_FIRST_REQUIRED_YES" => $name_first_required_yes,
	"NAME_FIRST_REQUIRED_NO" => $name_first_required_no,
	"NAME_LAST_REQUIRED_YES" => $name_last_required_yes,
	"NAME_LAST_REQUIRED_NO" => $name_last_required_no,
	
	"NAME_FIRST_DISPLAY_YES" => $name_first_display_yes,
	"NAME_FIRST_DISPLAY_NO" => $name_first_display_no,
	"NAME_LAST_DISPLAY_YES" => $name_last_display_yes,
	"NAME_LAST_DISPLAY_NO" => $name_last_display_no,
	
	)
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);
?>

