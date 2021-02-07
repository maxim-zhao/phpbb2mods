<?php
/***************************************************************************
 *                            admin_version.php
 *                            -------------------
 *   begin                : April 8, 2005
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
define('IN_AVC', 1);

if( !empty($setmodules) ) 
{ 
    $file = basename(__FILE__); 
    $module['AVC_AVersioncheck']['AVC_AVersioncheck'] = $file;
    return; 
}

//
// Load the default header 
//
$phpbb_root_path = './../'; 
require($phpbb_root_path . 'extension.inc'); 
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include_once($phpbb_root_path . 'includes/constants_avc.' . $phpEx);

// Determine our mode and run an htmlspecialchars on it
if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = '';
}

// Same thing with our vid
if ( isset($HTTP_POST_VARS['vid']) || isset($HTTP_GET_VARS['vid']) )
{
	$vid = ( isset($HTTP_POST_VARS['vid']) ) ? $HTTP_POST_VARS['vid'] : $HTTP_GET_VARS['vid'];
	$vid = intval($vid);
}
else
{
	$vid = '';
}

	
$template->set_filenames(array(
	"body" => "admin/version_body.tpl")
);

//
// User pressed a Recheck button
//
switch($mode)
{
	case $lang['Run_all_checks']: // User pressed "Run All Checks"
    avc_version_check(0);
	break;
	case $lang['Run_check']; // User pressed "Run Check" for a certain MOD
    avc_one_version_check($vid);
	break;
}

//
// Display the page
//
// Some basic template variables
$template->assign_vars(array(
    'L_VERSION_CHECK' => $lang['Version_check'],
    'L_VERSION_CHECK_EXPLAIN' => $lang['Version_check_explain'],
    'L_DOWNLOAD_MOD_HEADER' => $lang['lbl_Download_Mod'],
    'L_RECHECK_MOD_HEADER' => $lang['Re-check'],
    'L_MOD_NAME_HEADER' => $lang['MOD_Name'],
    'L_LATEST_VERSION_HEADER' => $lang['Latest_version'],
    'L_CURRENT_VERSION_HEADER' => $lang['Current_version'],
    'L_MOD_STATUS_HEADER' => $lang['MOD_Status'],
    'L_RECHECK_V_ALL' => $lang['Run_all_checks'])
);

// Get our info from the database
$sql = "SELECT mod_id, mod_name, mod_current_version, mod_new_version, mod_secondary_version, mod_file_loc, mod_topic_loc, mod_download_loc, mod_dev_status, mod_error, mod_time_stamp
        FROM " . VERSION_CHECK_TABLE . " WHERE mod_status = 1
        ORDER BY mod_id";
if( !$q_mod = $db->sql_query($sql) )
{
    message_die(GENERAL_ERROR, $lang['No_Version_Data'], "", __LINE__, __FILE__, $sql);
}
$total_mods = $db->sql_numrows($q_mod);
$mod_rows = $db->sql_fetchrowset($q_mod);
$db->sql_freeresult($q_mod);
	
// Loop through each MOD
for($i=0;$i < $total_mods;$i++)
{
    //
    // Set some variables before assigning them to template vars
    //
    // If this is phpBB, it's download link is our Download phpBB page
    if($mod_rows[$i]['mod_id'] == 1)
    {	
        $mod_rows[$i]['mod_download_loc'] = append_sid("admin_download_phpbb.$phpEx");
    }
    $s_hidden_vid = '<input type="hidden" name="vid" value="'. $mod_rows[$i]['mod_id'] .'" />'; // Hidden fields for the "Run Check" button
    // If there is an error logged in the database, set the color to black and mention that there was an error
    if ( $mod_rows[$i]['mod_error'] != '' )
    {
        $fcolor = 'color:black';
        $version_check_result = $lang['Error_occured'];
    }
    // If the new version is greater than the current version, a new version is available; set the color to red
    elseif ($mod_rows[$i]['mod_new_version'] > $mod_rows[$i]['mod_current_version'] )
    {
        $fcolor = 'color:red';
        $version_check_result = $lang['Result_new_vers_available'];
    }
    // There's no new version, set the color to green
    else
    {
        $fcolor = 'color:green';
        $version_check_result = $lang['Result_have_latest'];
    }
    // Set the name for Categories Hierarchy
    if($mod_rows[$i]['mod_name'] == "mod_cat_hierarchy")
    {
        $mod_rows[$i]['mod_name'] = 'Categories Hierarchy';
    }
    // Set the name for Topic Calendar
    elseif($mod_rows[$i]['mod_name'] == "mod_topic_calendar_CH")
    {
        $mod_rows[$i]['mod_name'] = 'Topic Calendar';
    }
    // Set the name for Extended Template
    elseif($mod_rows[$i]['mod_name'] == "mod_extended_tpl_CH")
    {
        $mod_rows[$i]['mod_name'] = 'Extended Template';
    }
    // Set type of secondary version; this is the opposite of our current status
    $secondary_version_status = ( $mod_rows[$i]['mod_dev_status'] == 'stable' ) ? $lang['development'] : $lang['stable'];

    //
    // Assign our template vars
    //
    $template->assign_block_vars('switch_version_check_loop', array(
        'L_MOD_NAME' => $mod_rows[$i]['mod_name'],
        'U_TOPIC_LOC' => $mod_rows[$i]['mod_topic_loc'],
        'L_LAST_UPDATED' => $lang['Last_Updated'],
        'L_LAST_UPDATED_TIME' => create_date($board_config['default_dateformat'], $mod_rows[$i]['mod_time_stamp'], $board_config['board_timezone']),
        'L_DOWNLOAD_MOD' => $lang['Download'],
        'U_DOWNLOAD_MOD' => $mod_rows[$i]['mod_download_loc'],
        'L_LATEST_VERSION' => $mod_rows[$i]['mod_new_version'],
        'L_CURRENT_VERSION' => $mod_rows[$i]['mod_current_version'],
        'L_MOD_STATUS' => ($mod_rows[$i]['mod_dev_status'] == '' ) ? $lang['Not_specified'] : ucfirst($mod_rows[$i]['mod_dev_status']),
        'F_COLOR' => $fcolor,
        'L_VERSION_CHECK_RESULT' => $version_check_result,
        'L_MOD_ERROR' => ($mod_rows[$i]['mod_error'] != '') ? '<strong>' . $lang['Error_occured'] . '</strong> '. $mod_rows[$i]['mod_error'] . '<br /><br />' : '',
        'L_SECONDARY_VERSION' => ($mod_rows[$i]['mod_secondary_version'] != '') ? sprintf($lang['Secondary_version_msg'], (( $mod_rows[$i]['mod_dev_status'] == 'stable' ) ? $lang['development'] : $lang['stable']), $mod_rows[$i]['mod_secondary_version']) . '<br /><br />' : '',
        'L_MORE_INFO' => $lang['More_info'],
        'L_RECHECK_V' => $lang['Run_check'],
        'S_HIDDEN_VID' => $s_hidden_vid,
        'L_LOOP_NUMBER' => $i,
        'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'])
    );
}
$template->pparse("body");

//
// Now let's just close the document properly.
//
include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>