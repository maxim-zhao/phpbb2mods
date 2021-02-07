<?php 
/*************************************************************************** 
*                          admin_firstpost_ad.php 
*                            ------------------- 
*   begin                : (Saturday, Oct 16, 2004) 
*   copyright            : (C) (2004) (geocator) 
*   email                : (geocator@gmail.com) 
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

if( !empty($setmodules) )
{
   $filename = basename(__FILE__);
   $module['ad_managment']['inline_ad_config'] = $filename;

   return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ( isset($HTTP_POST_VARS['submit']))
{
	//str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['cookie_domain']))
	
	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = " . intval($HTTP_POST_VARS['ad_after_post']) . "
		WHERE config_name = 'ad_after_post'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update first post ad settings", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = " . intval($HTTP_POST_VARS['ad_every_post']) . "
		WHERE config_name = 'ad_every_post'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update first post ad settings", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = " . intval($HTTP_POST_VARS['ad_who']) . "
		WHERE config_name = 'ad_who'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update first post ad settings", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = '" . str_replace("\'", "''", $HTTP_POST_VARS['ad_forums']) . "'
		WHERE config_name = 'ad_no_forums'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update first post ad settings", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = '" . str_replace("\'", "''", $HTTP_POST_VARS['ad_no_groups']) . "'
		WHERE config_name = 'ad_no_groups'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update first post ad settings", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = '" . str_replace("\'", "''", $HTTP_POST_VARS['ad_post_threshold']) . "'
		WHERE config_name = 'ad_post_threshold'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update first post ad settings", "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . CONFIG_TABLE . " SET
		config_value = " . intval($HTTP_POST_VARS['ad_style']) . "
		WHERE config_name = 'ad_old_style'";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to update first post ad settings", "", __LINE__, __FILE__, $sql);
	}
	$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_firstpost'], "<a href=\"" . append_sid("admin_inline_ad.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
}
else
{
	
	$who_all = '';
	$who_reg = '';
	$who_guest = '';
	if ($board_config['ad_who'] == ALL){
		$who_all = 'checked="checked"';
	}elseif ($board_config['ad_who'] == USER){
		$who_reg = 'checked="checked"';
	}else{
		$who_guest = 'checked="checked"';
	}
	$ad_new_style = '';
	$ad_old_style = '';
	if ($board_config['ad_old_style']){
		$ad_old_style = 'checked="checked"';
	}else{
		$ad_new_style = 'checked="checked"';
	}
	$template->set_filenames(array(
	"body" => "admin/inline_ad_config_body.tpl")
	);
	$template->assign_vars(array(
	"AD_AFTER_POST" => $board_config['ad_after_post'],
	"AD_EVERY_POST" => $board_config['ad_every_post'],
	"AD_FORUMS" => $board_config['ad_no_forums'],
	"AD_NO_GROUPS" => $board_config['ad_no_groups'],
	"AD_POST_THRESHOLD" => $board_config['ad_post_threshold'],
	"AD_ALL" => $who_all,
	"AD_REG" => $who_reg,
	"AD_GUEST" => $who_guest,
	"AD_OLD_STYLE" => $ad_old_style,
	"AD_NEW_STYLE" => $ad_new_style,
	"L_CONFIGURATION_TITLE" => $lang['inline_ad_config'],
	"L_AD_AFTER_POST" => $lang['ad_after_post'],
	"L_AD_EVERY_POST" => $lang['ad_every_post'],
	"L_AD_DISPLAY" => $lang['ad_display'],
	"L_AD_ALL" => $lang['ad_all'],
	"L_AD_REG" => $lang['ad_reg'],
	"L_AD_GUEST" => $lang['ad_guest'],
	"L_AD_EXCLUDE" => $lang['ad_exclude'],
	"L_AD_FORUMS" => $lang['ad_forums'],
	"S_CONFIG_ACTION" => append_sid("admin_inline_ad.$phpEx"),
	"L_SUBMIT" => $lang['Submit'],
	"L_AD_STYLE" => $lang['ad_style'],
	"L_AD_NEW_STYLE" => $lang['ad_new_style'],
	"L_AD_OLD_STYLE" => $lang['ad_old_style'],
	"L_AD_POST_THRESHOLD" => $lang['ad_post_threshold'], 
	"L_RESET" => $lang['Reset'])
	);
	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
}
?>