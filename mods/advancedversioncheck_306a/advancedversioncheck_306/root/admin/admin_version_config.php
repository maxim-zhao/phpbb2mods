<?php
/***************************************************************************
 *                          admin_version_config.php
 *                            -------------------
 *   begin                : April 24, 2005
 *   author               : Fountain of Apples < webmacster87@gmail.com >
 *   copyright            : (C) 2005-2006 Douglas Bell
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

//
// Let the ACP know this file exists
//
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
    $module['AVC_AVersioncheck']['Configuration'] = $file;
	return;
}

//
// Load the default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.'.$phpEx);
include_once($phpbb_root_path . 'includes/constants_avc.'.$phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . VERSION_CONFIG_TABLE;
if (!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, $lang['No_Version_Config'], "", __LINE__, __FILE__, $sql);
}
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
    
    //
    // If CH is installed, a category or link type forum isn't good enough
    //
    if ( isset($config->data['mod_cat_hierarchy']) && $config_name == 'post_forum' && isset($HTTP_POST_VARS['submit']) )
    {
        if ( $forums->data[$new['post_forum']]['forum_type'] != POST_FORUM_URL )
        {
            $forum_type_error = TRUE;
            $template->set_filenames(array(
                'reg_header' => 'error_body.tpl')
            );
            $template->assign_vars(array(
                'ERROR_MESSAGE' => $lang['CH_bad_post_forum'])
            );
            $template->assign_var_from_handle('ERROR_BOX', 'reg_header');
        }
    }

    //
    // If the form was submitted, update the database
    //
    if( isset($HTTP_POST_VARS['submit']) && !$forum_type_error )
    {
        $sql = "UPDATE " . VERSION_CONFIG_TABLE . " SET
                config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
                WHERE config_name = '$config_name'";
        if( !$db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, sprintf($lang['Cant_update_config'], $config_name), "", __LINE__, __FILE__, $sql);
        }
    }
}
$db->sql_freeresult($result);

if( isset($HTTP_POST_VARS['submit']) && !$forum_type_error )
{
    $message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_version_config.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

    message_die(GENERAL_MESSAGE, $message);
}

//
// Set up each of the variables for our form
//
$check_time_select = avc_select($new['check_time'], 'check_time');

$background_check_yes = ( $new['background_check'] ) ? "checked=\"checked\"" : "";
$background_check_no = ( !$new['background_check'] ) ? "checked=\"checked\"" : "";

$show_admin_index_yes = ( $new['show_admin_index'] ) ? "checked=\"checked\"" : "";
$show_admin_index_no = ( !$new['show_admin_index'] ) ? "checked=\"checked\"" : "";

$update_email_no = ( $new['update_email'] == UPDATE_EMAIL_NO ) ? "checked=\"checked\"" : "";
$update_email_one = ( $new['update_email'] == UPDATE_EMAIL_ONE ) ? "checked=\"checked\"" : "";
$update_email_all = ( $new['update_email'] == UPDATE_EMAIL_ALL ) ? "checked=\"checked\"" : "";

$update_pm_no = ( $new['update_pm'] == UPDATE_PM_NO ) ? "checked=\"checked\"" : "";
$update_pm_one = ( $new['update_pm'] == UPDATE_PM_ONE ) ? "checked=\"checked\"" : "";
$update_pm_all = ( $new['update_pm'] == UPDATE_PM_ALL ) ? "checked=\"checked\"" : "";

$update_post_yes = ( $new['update_post'] ) ? "checked=\"checked\"" : "";
$update_post_no = ( !$new['update_post'] ) ? "checked=\"checked\"" : "";

$post_forum = make_forum_select('post_forum', false, $new['post_forum']);

$template->set_filenames(array(
	"body" => "admin/version_config.tpl")
);

//
// Assign our template vars
//
$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_version_config.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_ONE_ADDRESS" => $lang['One_Address'],
	"L_ONE_USER" => $lang['One_User'],
	"L_ALL_ADMINS" => $lang['All_Admins'],
	
	"L_VERSION_CONFIG" => $lang['Version_check_config'],
	"L_VERSION_CONFIG_EXPLAIN" => $lang['Version_Config_explain'],
	"L_VERSION_CHECK_TIME" => $lang['Version_check_interval'],
	"L_VERSION_CHECK_TIME_EXPLAIN" => $lang['Version_Check_Time_explain'],
	"L_BACKGROUND_CHECK" => $lang['Background_check'],
	"L_BACKGROUND_CHECK_EXPLAIN" => $lang['Background_check_explain'],
	"L_ALLOW_INDEX" => $lang['Admin_index_summary'],
	"L_ALLOW_INDEX_EXPLAIN" => $lang['Allow_Index_explain'],
    "L_EMAIL_ON_UPDATE" => $lang['Email_on_update'],
    "L_EMAIL_ON_UPDATE_EXPLAIN" => $lang['Email_on_update_explain'],
    "L_SEND_EMAIL_ADDRESS" => $lang['Send_email_address'],
    "L_SEND_EMAIL_ADDRESS_EXPLAIN" => $lang['Send_email_address_explain'],
    "L_PM_ON_UPDATE" => $lang['PM_on_update'],
    "L_PM_ON_UPDATE_EXPLAIN" => $lang['PM_on_update_explain'],
    "L_SEND_PM_USER" => $lang['Send_PM_user'],
    "L_SEND_PM_USER_EXPLAIN" => $lang['Send_PM_user_explain'],
    "L_POST_ON_UPDATE" => $lang['Post_on_update'],
    "L_POST_ON_UPDATE_EXPLAIN" => $lang['Post_on_update_explain'],
    "L_UPDATE_POST_FORUM" => $lang['Update_post_forum'],
    "L_UPDATE_POST_FORUM_EXPLAIN" => $lang['Update_post_forum_explain'],
    "L_UPDATE_POST_CONTENTS" => $lang['Update_post_contents'],
    "L_UPDATE_POST_CONTENTS_EXPLAIN" => $lang['Update_post_contents_explain'],

	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'], 
	
	"CHECK_TIME_SELECT" => $check_time_select,
	"BACKGROUND_CHECK_YES" => $background_check_yes,
	"BACKGROUND_CHECK_NO" => $background_check_no,
	"SHOW_ADMIN_INDEX_YES" => $show_admin_index_yes,
	"SHOW_ADMIN_INDEX_NO" => $show_admin_index_no,
	"UPDATE_EMAIL_NO" => UPDATE_EMAIL_NO,
	"UPDATE_EMAIL_NO_CHECKED" => $update_email_no,
	"UPDATE_EMAIL_ONE" => UPDATE_EMAIL_ONE,
	"UPDATE_EMAIL_ONE_CHECKED" => $update_email_one,
	"UPDATE_EMAIL_ALL" => UPDATE_EMAIL_ALL,
	"UPDATE_EMAIL_ALL_CHECKED" => $update_email_all,
	"SEND_EMAIL_ADDRESS" => $new['email_address'],
	"UPDATE_PM_NO" => UPDATE_PM_NO,
	"UPDATE_PM_NO_CHECKED" => $update_pm_no,
	"UPDATE_PM_ONE" => UPDATE_PM_ONE,
	"UPDATE_PM_ONE_CHECKED" => $update_pm_one,
	"UPDATE_PM_ALL" => UPDATE_PM_ALL,
	"UPDATE_PM_ALL_CHECKED" => $update_pm_all,
	"SEND_PM_USER" => $new['pm_id'],
    "L_FIND_USERNAME" => $lang['Find_username'],
    "U_SEARCH_USER" => append_sid($phpbb_root_path . "search.$phpEx?mode=searchuser"),
	"UPDATE_POST_YES" => $update_post_yes,
	"UPDATE_POST_NO" => $update_post_no,
	"POST_FORUM_SELECT" => $post_forum,
	"POST_CONTENTS" => ( $new['post_contents'] == '' ) ? $lang['Update_post_contents_default'] : $new['post_contents'])
);

//
// Now let's just close the document properly.
//
$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>