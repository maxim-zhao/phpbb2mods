<?php
/***************************************************************************
 *                           admin_version_log.php
 *                            -------------------
 *   begin                : December 31, 2005
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
    $module['AVC_AVersioncheck']['AVC_Log'] = $file;
    return; 
}

//
// Load the default header 
//
$phpbb_root_path = './../'; 
require($phpbb_root_path . 'extension.inc'); 
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include_once($phpbb_root_path . 'includes/constants_avc.' . $phpEx);

//
// Figure out which tpl we're using
//
$template->set_filenames(array(
	"body" => "admin/version_log.tpl")
);

//
// Select everything from the logs table
//
$sql = "SELECT * FROM " . VERSION_LOG_TABLE . " ORDER BY log_id DESC";
if ( !$result = $db->sql_query($sql) )
{
    message_die(GENERAL_ERROR, $lang['No_Version_Log'], '', __LINE__, __FILE__, $sql);
}

//
// Loop through each MOD
//
$i = 0;
while ( $row = $db->sql_fetchrow($result) )
{
    $log_id = $row['log_id'];
    // Was a form submitted? If so, we need to see which entries we need to remove
    if ( isset($HTTP_POST_VARS['submit']) )
    {
        // Was the delete checkbox for this MOD pressed?
        if ( $HTTP_POST_VARS['delete_' . $log_id] )
        {
            // Delete this log action from the database
            $sql = "DELETE FROM " . VERSION_LOG_TABLE . " WHERE log_id = $log_id";
            if ( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, sprintf($lang['No_Delete_Log'], $log_id), '', __LINE__, __FILE__, $sql);
            }
        }
    }
    // Only display this log entry if the user didn't want it deleted and if the form wasn't submitted
    elseif ( !isset($HTTP_POST_VARS['submit']) || !$HTTP_POST_VARS['delete_' . $log_id] )
    {
        $log_timestamp = create_date($board_config['default_dateformat'], $row['log_timestamp'], $board_config['board_timezone']);
        if ( $row['mod_name'] == 'mod_cat_hierarchy' )
        {
            $mod_name = 'Categories Hierarchy';
        }
        elseif ( $row['mod_name'] == 'mod_topic_calendar_CH' )
        {
            $mod_name = 'Topic Calendar';
        }
        else
        {
            $mod_name = $row['mod_name'];
        }
        // Assign our vars for this loop
        $template->assign_block_vars('version_log_loop', array(
            'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
            'LOG_ID' => $log_id,
            'LOG_TIMESTAMP' => $log_timestamp,
            'L_MOD_NAME' => $mod_name,
            'L_LOG_MSG' => $row['log_action'])
        );
        $i = $i + 1;
    }
}
$db->sql_freeresult($result);

// Now if a form was submitted, die a success screen -- added in 3.0.5
if ( isset($HTTP_POST_VARS['submit']) )
{
	$message = $lang['Entries_deleted'] . '<br /><br />' . sprintf($lang['Click_return_version_log'], '<a href="' . append_sid("{$phpbb_root_path}admin/admin_version_log.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("{$phpbb_root_path}admin/index.$phpEx?pane=right") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//
// Assign the rest of our vars
//
$template->assign_vars(array(
    'L_VERSION_LOG' => $lang['Update_log'],
    'L_VERSION_LOG_EXPLAIN' => $lang['Update_log_explain'],
    'S_VERSION_ACTION' => append_sid("admin_version_log.$phpEx"),
    'L_TIME' => $lang['Time'],
    'L_MOD_NAME' => $lang['MOD_Name'],
    'L_LOG_MESSAGE' => $lang['Log_message'],
    'L_DELETE_ENTRIES' => $lang['Delete_entries'],
    'L_MARK_ALL' => $lang['Mark_all'],
    'L_UNMARK_ALL' => $lang['Unmark_all'])
);

//
// Now let's just close the document properly.
//
$template->pparse('body');
include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>