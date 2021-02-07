<?php
/***************************************************************************
 *                            constants_avc.php
 *                            -------------------
 *   begin                : May 14, 2005
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

/* This file will run all the necessary instructions needed to run before AVC can operate. */

//
// Page has to be accessed through phpBB. If not, complain.
//
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//--------------
// AVC Constants
//

// Configuration
define('UPDATE_EMAIL_NO', 0);
define('UPDATE_EMAIL_ONE', 1);
define('UPDATE_EMAIL_ALL', 2);

define('UPDATE_PM_NO', 0);
define('UPDATE_PM_ONE', 1);
define('UPDATE_PM_ALL', 2);

// Identification
define('PHPBB_MOD_ID', 1);
define('BOARD_MAIN_ADMIN_ID', 2);

// Tables
define('VERSION_CHECK_TABLE', $table_prefix.'version_check');
define('VERSION_CONFIG_TABLE', $table_prefix.'version_config');
define('VERSION_LOG_TABLE', $table_prefix.'version_log');

//
// End AVC Constants
//--------------

// Some AVC specific things to do right off the bat
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_avc.'.$phpEx);
include($phpbb_root_path . 'includes/functions_avc.'.$phpEx);

//
// Update the phpBB Version
//
$current_version = '2' . $board_config['version'];
$sql = 'SELECT mod_current_version FROM ' . VERSION_CHECK_TABLE . ' WHERE mod_id = 1';
if (!$result = $db->sql_query($sql))
{
    message_die(GENERAL_ERROR, $lang['No_add_phpBB_version'], '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
if ($row['mod_current_version'] != $current_version)
{
    $sql = "UPDATE " . VERSION_CHECK_TABLE . "
        SET  mod_current_version = '$current_version' 
        WHERE mod_id = 1";
    if ( !$db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, $lang['No_add_phpBB_version'], '', __LINE__, __FILE__, $sql);
    }
}

//
// Initialize our arrays
//
$avc_array = array();
$ch_check = array();

//
// Add CH to the database
//
// First, define our important stuff for CH -- the array is for convenience
$ch_check['ch_name'][0] = 'Categories Hierarchy';
$ch_check['ch_name'][1] = 'Topic Calendar';
$ch_check['ch_explode_token'][0] = 'mod_cat_hierarchy';
$ch_check['ch_explode_token'][1] = 'mod_topic_calendar_CH';
$ch_check['domain_loc'] = 'ptifo.clanmckeen.com';
$ch_check['file_loc'] = 'download';
$ch_check['topic_loc'] = 'http://www.phpbb.com/phpBB/viewtopic.php?t=265040';
$ch_check['file_name'] = "versions.dta";
$ch_check['download_loc'] = 'http://ptifo.clanmckeen.com/download.php';
// Start a loop for our goodies
for($i = 0; $i < 2; $i++)
{
	$ch_name = $ch_check['ch_explode_token'][$i];
	$h = $i+2;
	// Try to select it from the database -- may work, or may not
    $sql = "SELECT mod_id, mod_name, mod_current_version, mod_new_version, mod_file_loc, mod_topic_loc, mod_download_loc, mod_dev_status, mod_time_stamp
            FROM " . VERSION_CHECK_TABLE . "
            WHERE mod_name = '" . $ch_name . "'";
    if( !$q_mod = $db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, $lang['No_new_MOD'], '', __LINE__, __FILE__, $sql);
    }
    $mod_rows = $db->sql_fetchrow($q_mod);
    $db->sql_freeresult($q_mod);

    // The goodie exists
	if(isset($config->data[$ch_name]))
	{
        // The goodie hasn't been inserted into the table yet
        if ( empty($mod_rows) )
        {
            // Insert it into the table
            $sql = "INSERT INTO " . VERSION_CHECK_TABLE . " (mod_name, mod_file_loc, mod_topic_loc, mod_file_name, mod_domain_loc, mod_download_loc)
                    VALUES ('" . $ch_check['ch_explode_token'][$i] . "','" . $ch_check['file_loc'] . "','" . $ch_check['topic_loc'] . "','" . $ch_check['file_name'] . "','" . $ch_check['domain_loc'] . "','" . $ch_check['download_loc'] . "')";
            if( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_new_MOD'], '', __LINE__, __FILE__, $sql);
            }
            avc_log_add($ch_check['ch_name'][$i], $lang['Log_MOD_inserted']);
        }
        // The goodie has been inserted into the table, so only update it with the current version if we need to
		elseif ( $mod_rows['mod_current_version'] != $config->data[$ch_name] )
		{
            $current_version = $config->data[$ch_name];
            $sql = "UPDATE " . VERSION_CHECK_TABLE . "
                    SET  mod_current_version = '$current_version' 
                    WHERE mod_name = '$ch_name'";
            if( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_update_MOD'], '', __LINE__, __FILE__, $sql);
            }
            avc_log_add($ch_check['ch_name'][$i], sprintf($lang['Log_MOD_current'], $current_version));
        }
    }
    // This goodie doesn't exist
    else
    {
        // The goodie may not exist, but it's home in our table does -- let's evict it ;)
        if ( !empty($mod_rows) )
        {
            $sql = "DELETE FROM " . VERSION_CHECK_TABLE . " WHERE mod_name = '$ch_name'";
            if ( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_delete_MOD'] , '', __LINE__, __FILE__, $sql);
            }
            avc_log_add($ch_check['ch_name'][$i], $lang['log_mod_deleted']);
        }
    }
}

//
// Investigate admin/avc_mods/ for any version check files
//
$dir = @opendir($phpbb_root_path . "admin/avc_mods/");
$avc_modules = 1;
$i = 0;
$avc_array[$i] = array();

//
// Loop through each file
//
while( $file = @readdir($dir) )
{		
	if( preg_match("/^avc_.*?\." . $phpEx . "$/", $file) )
	{
        //
        // Unload all this info into an array 
        //
        include($phpbb_root_path . "admin/avc_mods/" . $file);
		$avc_array[$i]['mod_name'] = $mod_name;
		$avc_array[$i]['mod_current_version'] = $mod_current_version;
		$avc_array[$i]['mod_domain_loc'] = $mod_domain_loc;
		$avc_array[$i]['mod_file_name'] = $mod_file_name;
		$avc_array[$i]['mod_file_loc'] = $mod_file_loc;
		$avc_array[$i]['mod_topic_loc'] = ($mod_topic_loc != '') ? $mod_topic_loc : ''; // Only if using an AVC 2 checker
		$avc_array[$i]['mod_download_loc'] = ($mod_download_loc != '') ? $mod_download_loc : ''; // Only if using an AVC 2 checker
		$avc_array[$i]['mod_dev_status'] = $mod_dev_status;
		// Split the important parts of the current version
		$current_version_file = explode(".",$avc_array[$i]['mod_current_version']);
		$current_version_file[0] = (int) $current_version_file[0];
		$current_version_file[1] = (int) $current_version_file[1];
		$current_version_file[2] = (int) $current_version_file[2];
		
		//
		// We're going to try to select this MOD from the database--it
		// may exist or it may not
		//
		$sql = "SELECT mod_id, mod_name, mod_current_version, mod_new_version, mod_file_loc, mod_topic_loc, mod_download_loc, mod_dev_status, mod_time_stamp
			FROM " . VERSION_CHECK_TABLE . "
			WHERE mod_name = '" . $avc_array[$i]['mod_name'] . "'";
		if( !$q_mod = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, $lang['No_new_MOD'], '', __LINE__, __FILE__, $sql);
		}
		$mod_rows = $db->sql_fetchrow($q_mod);
		$db->sql_freeresult($q_mod);

        //
        // If there are no rows, then this MOD doesn't exist so let's go
        // ahead and insert it
        //
		if(empty($mod_rows))
		{
			$sql = "INSERT INTO " . VERSION_CHECK_TABLE . " (mod_name, mod_file_loc, mod_topic_loc, mod_file_name, mod_domain_loc, mod_download_loc, mod_current_version, mod_dev_status)
				VALUES ('" . $avc_array[$i]['mod_name'] . "','" . $avc_array[$i]['mod_file_loc'] . "','" . $avc_array[$i]['mod_topic_loc'] . "','" . $avc_array[$i]['mod_file_name'] . "','" . $avc_array[$i]['mod_domain_loc'] . "','" . $avc_array[$i]['mod_download_loc'] . "','" . $avc_array[$i]['mod_current_version'] . "', '" . $avc_array[$i]['mod_dev_status'] . "')";
            if ( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_new_MOD'], '', __LINE__, __FILE__, $sql);
            }
            avc_log_add($avc_array[$i]['mod_name'], $lang['Log_MOD_inserted']);
		}
		//
		// This MOD does exist, so we want to update what's there instead
		//
		else
		{
            // For these, we check to see if the $avc_array for it is empty (which would be the case if the MOD is smart and is using our AVC 3 checker)--if it is, we're going to update it with the value that was already in our Version Check table -- we only put this in an array for convenience
            $update_sql['mod_topic_loc'] = ($avc_array[$i]['mod_topic_loc'] != '') ? $avc_array[$i]['mod_topic_loc'] : $mod_rows['mod_topic_loc'];
            $update_sql['mod_download_loc'] = ($avc_array[$i]['mod_download_loc'] != '') ? $avc_array[$i]['mod_download_loc'] : $mod_rows['mod_download_loc'];
			$sql = "UPDATE " . VERSION_CHECK_TABLE . "
					SET mod_name = '" . $avc_array[$i]['mod_name'] . "', mod_current_version = '" . $avc_array[$i]['mod_current_version'] . "', mod_domain_loc = '" .$avc_array[$i]['mod_domain_loc'] . "', mod_file_name = '" . $avc_array[$i]['mod_file_name'] . "', mod_file_loc = '" . $avc_array[$i]['mod_file_loc'] . "', mod_topic_loc = '" . $update_sql['mod_topic_loc'] . "', mod_download_loc = '" . $update_sql['mod_download_loc'] . "', mod_dev_status = '" . $avc_array[$i]['mod_dev_status'] . "'
					WHERE mod_name = '" . $mod_rows['mod_name'] . "'";
					
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, $lang['No_update_MOD'], '', __LINE__, __FILE__, $sql);
			}
			// Only update the log if there is a difference in current versions
			if ( $avc_array[$i]['mod_current_version'] != $mod_rows['mod_current_version'] )
			{
                avc_log_add($avc_array[$i]['mod_name'], sprintf($lang['Log_MOD_current'], $avc_array[$i]['mod_current_version']));
            }
		}
		$i = $i + 1;
	}
}
@closedir($dir);

//
// Delete any non-existing MODs from the database
//
unset($avc_modules);
// Start out our query, and note not to erase phpBB
// Note that within here we trail a space so we don't smooshwordstogether
$sql = "SELECT mod_name FROM " . VERSION_CHECK_TABLE . "
        WHERE mod_name <> 'phpBB' ";
// From above, $i contains the total number of MODs that exist; we're going to loop through our array again and make sure that none of those MODs are selected
for ( $j = 0; $j <= $i; $j++ )
{
    $sql .= "AND mod_name <> '" . $avc_array[$j]['mod_name'] . "' ";
}
// Don't erase CH or Topic Calendar; they should have been taken care of already
$sql .= "AND mod_name <> 'mod_cat_hierarchy' ";
$sql .= "AND mod_name <> 'mod_topic_calendar_CH'";
// Execute the query
if ( !$result = $db->sql_query($sql) )
{
    message_die(GENERAL_ERROR, $lang['No_delete_MOD'], '', __LINE__, __FILE__, $sql);
}
// Loop through each of the results (assuming there are any)
while ( $row = $db->sql_fetchrow($result) )
{
    $delete_mod_name = $row['mod_name'];
    // Delete this row from the table
    $sql = "DELETE FROM " . VERSION_CHECK_TABLE . " WHERE mod_name = '$delete_mod_name'";
    // Execute the query
    if ( !$db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, $lang['No_delete_MOD'], '', __LINE__, __FILE__, $sql);
    }
}

// Initialize the $mod_rows array
$mod_rows = array();	
?>