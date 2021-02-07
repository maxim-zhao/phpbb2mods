<?php
/***************************************************************************
 *                          admin_version_manage.php
 *                            -------------------
 *   begin                : April 15, 2005
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
    $module['AVC_AVersioncheck']['AVC_Enable'] = $file;
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
	"body" => "admin/version_manage.tpl")
);

//
// Get current MOD Statuses from Version Check table
//
$sql = "SELECT mod_id, mod_name, mod_status FROM " . VERSION_CHECK_TABLE . " ORDER BY mod_id";
if ( !$result = $db->sql_query($sql) )
{
    message_die(GENERAL_ERROR, $lang['No_MOD_Status'], '', __LINE__, __FILE__, $sql);
}

//
// Loop through each MOD
//
$i = 0;
while ( $row = $db->sql_fetchrow($result) )
{
    $mod_id = $row['mod_id'];
    // We might need to rewrite our MOD name if this is CH
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
    // This determines our MOD status -- if the form was submitted, it's our post var; otherwise, it's what we just selected -- Note that the post var is named via the name of the MOD
    // We can also take an opportunity in here to make sure that the post var is an integer, although since they're radio buttons, they're either 1 or 0 ;)
    $mod_status = ( isset($HTTP_POST_VARS[$mod_id]) ) ? intval($HTTP_POST_VARS[$mod_id]) : $row['mod_status'];
    
    //
    // If a form was submitted, then update the database
    //
    if ( isset($HTTP_POST_VARS['submit']) )
    {
        $sql = "UPDATE " . VERSION_CHECK_TABLE . " SET
                mod_status = $mod_status
                WHERE mod_name = '$mod_name'";
        if ( !$db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, sprintf($lang['No_MOD_Status_update'], $mod_name), '', __LINE__, __FILE__, $sql);
        }
        // Add it to the update log
        if ( $HTTP_POST_VARS[$mod_id] != $row['mod_status'] ) // If the submitted status is different from the current, then the status was changed
        {
            if ( $mod_status ) // MOD was enabled
            {
                avc_log_add($mod_name, $lang['Log_MOD_enabled']);
            }
            else // MOD was disabled
            {
                avc_log_add($mod_name, $lang['Log_MOD_disabled']);
            }
        }
    }
    // Only assign vars if form was not submitted -- added in 3.0.5
    else
    {
    	//
    	// Are we checked or not?
    	//
    	$mod_enabled = ( $mod_status ) ? "checked=\"checked\"" : "";
    	$mod_disabled = ( !$mod_status ) ? "checked=\"checked\"" : "";

    	//
    	// Now let's assign the vars that correspond to this MOD
    	//
    	$template->assign_block_vars('version_manage_loop', array(
        	'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
        	'S_MOD_ID' => $mod_id,
        	'L_MOD_NAME' => $mod_name,
        	'S_MOD_ENABLED' => $mod_enabled,
        	'S_MOD_DISABLED' => $mod_disabled)
    	);
    	$i = $i + 1;
	}
}
$db->sql_freeresult($result);

// Now if a form was submitted, die a success screen -- added in 3.0.5
if ( isset($HTTP_POST_VARS['submit']) )
{
	$message = $lang['Checker_status_updated'] . '<br /><br />' . sprintf($lang['Click_return_enable_disable'], '<a href="' . append_sid("{$phpbb_root_path}admin/admin_version_manage.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("{$phpbb_root_path}admin/index.$phpEx?pane=right") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

//
// Assign the rest of our vars
//
$template->assign_vars(array(
    'L_VERSION_MANAGER' => $lang['Version_Manager'],
    'L_VERSION_MANAGER_EXPLAIN' => $lang['Version_Manager_explain'],
    'S_VERSION_ACTION' => append_sid("admin_version_manage.$phpEx"),
    'L_ENABLE' => $lang['Enabled'],
    'L_DISABLE' => $lang['Disabled'],
    'L_SUBMIT' => $lang['Submit'])
);

//
// Now let's just close the document properly.
//
$template->pparse('body');
include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>