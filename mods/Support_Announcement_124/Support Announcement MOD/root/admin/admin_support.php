<?php
/***************************************************************************
 *                              admin_support.php
 *                            -------------------
 *	By		: Mac (Y.C. LIN)
 *	Email		: ycl6@users.sourceforge.net (http://macphpbbmod.sourceforge.net/)
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
	$file = basename(__FILE__);
	$module['General']['Support'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// Load Support config data
$sql = "SELECT *
	FROM " . CONFIG_TABLE . "
	WHERE config_name LIKE 'support_%'";
	
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_support", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

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
		$message = $lang['Support_config_updated'] . "<br /><br />" . sprintf($lang['Click_return_support_config'], "<a href=\"" . append_sid("admin_support.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

$support_display_on = ( $new['support_display'] ) ? "checked=\"checked\"" : "";
$support_display_off = ( !$new['support_display'] ) ? "checked=\"checked\"" : "";
$support_status_on = ( $new['support_status'] ) ? "checked=\"checked\"" : "";
$support_status_off = ( !$new['support_status'] ) ? "checked=\"checked\"" : "";

$template->set_filenames(array(
	"body" => "admin/admin_support.tpl")
);

$template->assign_vars(array(
	"S_SUPPORT_CONFIG_ACTION" => append_sid("admin_support.$phpEx"),

	"L_ON" => $lang['On'],
	"L_OFF" => $lang['Off'],
	"L_SUPPORT_CONFIGURATION_TITLE" => $lang['Support_config'],
	"L_SUPPORT_CONFIGURATION_EXPLAIN" => $lang['Support_config_explain'],
	"L_SUPPORT_SETTINGS" => $lang['Support_settings'],
	"L_SUPPORT_DISPLAY" => $lang['Support_display'],
	"L_SUPPORT_DISPLAY_EXPLAIN" => $lang['Support_display_explain'],
	"L_SUPPORT_STATUS" => $lang['Support_status'],
	"L_SUPPORT_STATUS_EXPLAIN" => $lang['Support_status_explain'],
	"L_SUPPORT_ONLINE_ADMIN" => $lang['Support_online_admin'], 
	"L_SUPPORT_ONLINE_ADMIN_EXPLAIN" => $lang['Support_online_admin_explain'], 
	"L_SUPPORT_OFFLINE_ADMIN" => $lang['Support_offline_admin'], 
	"L_SUPPORT_OFFLINE_ADMIN_EXPLAIN" => $lang['Support_offline_admin_explain'], 
	"L_SUPPORT_ONLINE_DETAIL" => $lang['Support_online_detail'], 
	"L_SUPPORT_OFFLINE_DETAIL" => $lang['Support_offline_detail'], 
	"L_SUPPORT_DEATIL_EXPLAIN" => $lang['Support_deatil_explain'], 
	"L_SUPPORT_N_TEXT" => $lang['Support_onlinetext'], 
	"L_SUPPORT_N_TEXT_EXPLAIN" => $lang['Support_onlinetext_explain'], 
	"L_SUPPORT_N_CONTACT" => $lang['Support_onlinecontact'], 
	"L_SUPPORT_N_CONTACT_EXPLAIN" => $lang['Support_onlinecontact_explain'], 
	"L_SUPPORT_F_TEXT" => $lang['Support_offlinetext'], 
	"L_SUPPORT_F_TEXT_EXPLAIN" => $lang['Support_offlinetext_explain'], 
	"L_SUPPORT_F_CONTACT" => $lang['Support_offlinecontact'], 
	"L_SUPPORT_F_CONTACT_EXPLAIN" => $lang['Support_offlinecontact_explain'], 
	"L_SUPPORT_IMAGE" => $lang['Support_image'],
	"L_SUPPORT_IMAGE_IMAGE" => $lang['Support_image_explain'],
	"L_SUPPORT_VERSION" => $lang['Support_version'],
	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'], 
	
	"SUPPORT_ONLINE_ADMIN" => $new['support_online_admin'], 
	"SUPPORT_OFFLINE_ADMIN" => $new['support_offline_admin'], 
	"SUPPORT_N_TEXT" => $new['support_onlinetext'], 
	"SUPPORT_N_CONTACT" => $new['support_onlinecontact'], 
	"SUPPORT_F_TEXT" => $new['support_offlinetext'], 
	"SUPPORT_F_CONTACT" => $new['support_offlinecontact'], 
	"SUPPORT_IMAGE" => $new['support_image'],
	"SITE_DESCRIPTION" => $new['site_desc'], 
	"S_SUPPORT_DISPLAY_ON" => $support_display_on,
	"S_SUPPORT_DISPLAY_OFF" => $support_display_off,
	"S_SUPPORT_STATUS_ON" => $support_status_on,
	"S_SUPPORT_STATUS_OFF" => $support_status_off)
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
