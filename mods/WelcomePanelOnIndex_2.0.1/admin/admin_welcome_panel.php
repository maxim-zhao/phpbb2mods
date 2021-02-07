<?php
/***************************************************************************
 *                              admin_welcome_panel.php
 *                            -------------------
 *   begin                : Monday, Jan 07, 2005
 *   copyright            : (C) 2005 Aiencran
 *   email                : cranportal@katamail.com
 *
 *   $Id: admin_board.php,v 1.0.0.0 2005/01/07 12:49:00 Aiencran Exp $
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if ( !defined('IN_PHPBB') )
{
   die("Hacking attempt");
}

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Welcome_Panel'] = "$file";
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
if (!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset( $HTTP_POST_VARS['submit'] ) ? str_replace("'", "\'", $config_value) : $config_value;
		
		if ( $config_name == 'suggest_announcements' && isset($HTTP_POST_VARS['submit']) ) 
		{
			$new[$config_name] = ( !isset($HTTP_POST_VARS[$config_name]) ) ? 0 : 1;
		}
		else 
		{
			$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];
		}
			

		if ($config_name == 'cookie_name')
		{
			$cookie_name = str_replace('.', '_', $new['cookie_name']);
		}

		if ( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if ( $new['suggestion_type'] != SUGGEST_TOPIC_FROM )
	{
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = 0  
			WHERE config_name = 'suggest_announcements'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = 0  
			WHERE config_name = 'suggestion_source'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
		}
	}
	if ( $new['suggestion_type'] != SUGGEST_SPECIFIC ) 
	{
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = ''  
			WHERE config_name = 'suggested_topic_id'";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
	}

	if ( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_config'], '<a href="' . append_sid("admin_welcome_panel.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}
$db->sql_freeresult($result);

$do_not_suggest = ( $new['suggestion_type'] == DO_NOT_SUGGEST ) ? "checked=\"checked\"" : "";
$suggest_faq = ( $new['suggestion_type'] == SUGGEST_FAQ ) ? "checked=\"checked\"" : "";
$suggest_topic_from = ( $new['suggestion_type'] == SUGGEST_TOPIC_FROM ) ? "checked=\"checked\"" : "";
$suggest_specific = ( $new['suggestion_type'] == SUGGEST_SPECIFIC ) ? "checked=\"checked\"" : "";

$suggest_announcements = ( $new['suggest_announcements'] == 1 ) ? "checked=\"checked\"" : "";

$sql = "SELECT forum_id, forum_name
	FROM " . FORUMS_TABLE . "
	ORDER BY forum_order";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Couldn't get forum list", "", __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$select_list = '<select name="suggestion_source">';

	$item_selected = ( $new['suggestion_source'] == 0 ) ? "selected" : "";
	$select_list .= '<option value="0" ' . $item_selected . '>' . $lang['All_Forums'] . '</option>';
	do
	{
		$item_selected = ( $new['suggestion_source'] == $row['forum_id'] ) ? "selected" : "";
		$select_list .= '<option value="' . $row['forum_id'] . '" ' .  $item_selected . '>' . $row['forum_name'] . '</option>';
	}
	while ( $row = $db->sql_fetchrow($result) );
	$select_list .= '</select>';
}
$db->sql_freeresult($result);

$template->set_filenames(array(
	"body" => "admin/admin_welcome_panel.tpl")
);

$template->assign_vars(array(
	"S_WELCOME_PANEL_ACTION" => append_sid("admin_welcome_panel.$phpEx"),

	"L_WELCOME_PANEL_TITLE" => $lang['Welcome_Panel'],
	"L_WELCOME_PANEL_EXPLAIN" => $lang['Welcome_Panel_explain'],
	"L_SUGGESTED_TOPICS" => $lang['Suggested_Topics'],
	"L_SUGGESTED_TOPICS_EXPLAIN" => $lang['Suggested_Topics_explain'], 
	"L_DO_NOT_SUGGEST" => $lang['Do_not_suggest'], 
	"L_SUGGEST_FAQ" => $lang['Suggest_faq'], 
	"L_SUGGEST_TOPIC_FROM" => $lang['Suggest_topic_from'], 
	"L_SUGGEST_SPECIFIC" => $lang['Suggest_specific'],
	"L_SUGGEST_ANNOUNCEMENTS" => $lang['Suggest_announcements'],
	"L_WARNING" => $lang['Suggestion_Warning'], 
	
	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'],

	"DO_NOT_SUGGEST" => DO_NOT_SUGGEST,
	"SUGGEST_FAQ" => SUGGEST_FAQ,
	"SUGGEST_TOPIC_FROM" => SUGGEST_TOPIC_FROM,
	"SUGGEST_SPECIFIC" => SUGGEST_SPECIFIC,
	"DO_NOT_SUGGEST_CHECKED" => $do_not_suggest,
	"SUGGEST_FAQ_CHECKED" => $suggest_faq,
	"SUGGEST_TOPIC_FROM_CHECKED" => $suggest_topic_from,
	"SUGGEST_SPECIFIC_CHECKED" => $suggest_specific,
	
	"SUGGEST_ANNOUNCEMENTS_CHECKED" => $suggest_announcements,
	"SUGGESTED_TOPIC_ID" => $new['suggested_topic_id'],
	
	"S_FORUM_SELECT" => $select_list)
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
