<?php

/***************************************************************************
 *                           admin_mod_version_checker.php
 *                           -----------------------------
 *     begin                : Mon May 9 2005
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: admin_mod_version_checker.php,v 1.2.0.0 2006/07/22 18:38:17 chatasos Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define ('IN_PHPBB', true);

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Modifications']['MOD_Version_Checker'] = $filename;
	return;
}

//
// Let's set the root dir for phpBB
//
$no_page_header = true;
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Language File
//
include($phpbb_root_path.'language/lang_'.$board_config['default_lang'].'/lang_admin_mod_vc.'.$phpEx);


// table
define('MODS_VERSION_TABLE', $table_prefix.'mods_version');

// constants
define('MOD_VERSION_CHECKER_VERSION', '1.2.0');

define('MOD_STATUS_NULL', 0);

define('MOD_STATUS_CHECK', 1);
define('MOD_STATUS_FOUND', 3);

define('MOD_STATUS_NOTFOUND', 8);
define('MOD_STATUS_ERROR', 9);


// You can change the colors if you want through the ccs part in the tpl file
// The key defines the status of your mod in comparison to the moddb one
// The value defines the css class
$status_colors = array(
								'older'	=> 'mvc_older',
								'equal'	=> 'mvc_equal',
								'newer'	=> 'mvc_newer',
								'other'	=> 'mvc_other',
								'null'	=> 'mvc_null'
								);

// find the mode we are in
if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode'])  )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
}
elseif ( isset($HTTP_POST_VARS['add_mod']) )
{
	$mode = 'add';
}
elseif ( isset($HTTP_POST_VARS['add_easymod_mod']) )
{
	$mode = 'easymod';
}
else
{
	$mode = '';
}

// get the category mode
if ( isset($HTTP_GET_VARS['cat_mode']) || isset($HTTP_POST_VARS['cat_mode'])  )
{
	$cat_mode = ( isset($HTTP_POST_VARS['cat_mode']) ) ? htmlspecialchars($HTTP_POST_VARS['cat_mode']) : htmlspecialchars($HTTP_GET_VARS['cat_mode']);
}
else
{
	$cat_mode = '';
}

// get the category id
if ( isset($HTTP_GET_VARS['cat_id']) || isset($HTTP_POST_VARS['cat_id'])  )
{
	$cat_id = ( isset($HTTP_POST_VARS['cat_id']) ) ? intval($HTTP_POST_VARS['cat_id']) : intval($HTTP_GET_VARS['cat_id']);
}
else
{
	$cat_id = '';
}

// get the error counter
$error_counter = ( isset($HTTP_GET_VARS['error']) ) ? intval($HTTP_GET_VARS['error']) : 0;


$check_updates = ( isset($HTTP_POST_VARS['check_updates']) || $mode == 'check_updates' ) ? true : false;
$reset_updates = ( isset($HTTP_POST_VARS['reset_updates']) || $mode == 'reset_updates' ) ? true : false;

$confirm = isset($HTTP_POST_VARS['confirm']) ? true : false;

// check if the user cancelled an action
if ( isset($HTTP_POST_VARS['cancel_mod']) || isset($HTTP_POST_VARS['cancel']) )
{
	redirect('admin/' . append_sid("admin_mod_version_checker.$phpEx", true));
}

// check if neither mods nor categories were selected
if ( ( $check_updates || $reset_updates ) && ( !isset($HTTP_POST_VARS['mods_check']) && !isset($HTTP_GET_VARS['cat_id']) ) )
{
	$message = $lang['No_mods_selected'] . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

// Since these don't change too often, there is no need to store them in the db
// Also $lang vars are not needed too
$mod_categories = array(
						'0'  => 'Unknown',
						'25' => 'MOD Development Tools',
						'26' => 'MOD Installation Tools',
						'48' => 'phpBB Installation & Upgrade Tools',
						'49' => 'phpBB Utilities',
						'51' => 'Add-On\'s',
						'52' => 'Admin Tools',
						'53' => 'BBCode',
						'54' => 'Communication',
						'55' => 'Cosmetic/Styles',
						'56' => 'Syndication',
						'57' => 'Security',
						'58' => 'Profile'
						);

//
// Main code
//

if ( $reset_updates && isset($HTTP_POST_VARS['mods_check']) && !empty($HTTP_POST_VARS['mods_check']) )
{
	$mod_ids = array();
	foreach ($HTTP_POST_VARS['mods_check'] as $row)
	{
		$mod_ids[] = intval($row);
	}

	if ( !$confirm )
	{
		$s_hidden_fields ='';
		foreach ( $mod_ids as $mod_id)
		{
			$s_hidden_fields .= '<input type="hidden" name="mods_check[]" value="' . $mod_id . '" />';
		}

		$s_hidden_fields .= '<input type="hidden" name="mode" value="reset_updates" />';

		//
		// Output confirmation page
		//
		include('./page_header_admin.'.$phpEx);

		$template->set_filenames(array(
			'confirm_body' => 'admin/confirm_body.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE'	=> $lang['Mod_version_checker'] . ' - ' . $lang['Information'],
			'MESSAGE_TEXT'		=> $lang['Confirm_reset'],

			'L_YES'	=> $lang['Yes'],
			'L_NO'	=> $lang['No'],

			'S_HIDDEN_FIELDS'		=> $s_hidden_fields,
			'S_CONFIRM_ACTION'	=> append_sid("admin_mod_version_checker.$phpEx")
			)
		);

		$template->pparse('confirm_body');

		include('./page_footer_admin.'.$phpEx);
		exit;
	}

	// reset the check status of the selected mods
	$sql = "UPDATE " . MODS_VERSION_TABLE . "
		SET
			mod_topic_id = '',
			mod_latest_version = '',
			mod_latest_check = '',
			mod_dnld_link = '',
			mod_check_status = " . MOD_STATUS_NULL . "
		WHERE mod_id IN (" . implode(',', $mod_ids) . ")";

	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not reset mod updates', '', __LINE__, __FILE__, $sql);
	}

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_mod_version_checker.$phpEx") . '" />')
	);

	$message =  $lang['Mod_updates_reseted'] . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);

}
elseif ( $check_updates && isset($HTTP_POST_VARS['mods_check']) && !empty($HTTP_POST_VARS['mods_check']) )
{
	$mod_ids = array();
	foreach ($HTTP_POST_VARS['mods_check'] as $row)
	{
		$mod_ids[] = intval($row);
	}

	// reset the check status of all mods
	$sql = "UPDATE " . MODS_VERSION_TABLE . "
		SET
			mod_check_status = " . MOD_STATUS_NULL;

	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update mod status', '', __LINE__, __FILE__, $sql);
	}

	// set the check status of the selected mods
	$sql = "UPDATE " . MODS_VERSION_TABLE . "
		SET
			mod_check_status = " . MOD_STATUS_CHECK . "
		WHERE mod_id IN (" . implode(',', $mod_ids) . ")";

	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update mod status', '', __LINE__, __FILE__, $sql);
	}

	// get the next category to be searched by looking at the mods table
	$sql = "SELECT DISTINCT cat_id FROM " . MODS_VERSION_TABLE . "
		WHERE mod_check_status = " . MOD_STATUS_CHECK . "
		ORDER BY cat_id ASC
		LIMIT 1";

	if ( !($result = $db->sql_query($sql))  )
	{
		message_die(GENERAL_ERROR, 'Could not obtain cat_id information', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['cat_id'] == 0 )
		{
			$cat_mode = '&amp;cat_mode=all';
			$next_cat_id = get_next_category($row['cat_id']);
		}
		else
		{
			$cat_mode = '';
			$next_cat_id = $row['cat_id'];
		}
	}
	else
	{	// this should never happen
		message_die(GENERAL_ERROR, $lang['Internal_error']);
	}

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="1;url=' . append_sid("admin_mod_version_checker.$phpEx?" . "mode=check_updates&amp;cat_id=$next_cat_id" . $cat_mode) . '" />')
	);

	message_die(GENERAL_MESSAGE, sprintf($lang['Checking_updates'], $mod_categories[$next_cat_id]));

}
// check after each page refresh
elseif ( $check_updates && $cat_id != '' )
{
	//
	// Increase maximum execution time in case of a lot of mods, but don't complain about it if it isn't
	// allowed.
	//
	@set_time_limit(1200);

	$mods_info = '';
	$error_info = '';

	list($mods_info, $error_info) = get_mods_info($cat_id);

	if ( !empty($mods_info) )
	{
		$mods_info = explode("\n", $mods_info);

		// As it seems the phpBB MODDB html pages are not fully based on templates, so we must not be very strict on regexp

		// mod category ids are like this : '<td><A href="catdb.php?cat=51&mode=add" class="siteText">Add Link</A></td>'
		// but we use our own string
		$search_cat = '<!-- cat_id = (\d+) -->';

		// mod titles are like this : '<span style="font-weight: bold">MOD Name</span>: Log Actions MOD'
		$search_name = '#^<span style="font-weight: bold">MOD Name<\/span>:(.+)$#';
	
		// mod versions are like this : '<span style="font-weight: bold">MOD Version</span>: 1.1.6 <span style="font-style: italic">(Updated: 10/30/03)</span>'
		$search_version = '#^<span style="font-weight: bold">MOD Version<\/span>: ([\w.]+)#';

		// mod downloads are like this : '<span style="font-weight: bold">Download File</span>: <a href="http://www.phpbb.com/phpBB/catdb.php?mode=download&amp;id=436728" target="_blank" class="postlink">attach_mod_2314.zip</a>'
		$search_download = '#^<span style="font-weight: bold">Download File<\/span>: <a href="(.+?)" target="_blank" class="postlink">(.+?)<\/a>#';

		// mod topic id links are like this : '<a href="viewtopic.php?t=114916">Discuss/Rate/Review</a>'
		// but they may become like this : '<a href="viewtopic.php?t=135876&amp;sid=281a558c6bf48f2202df396aeaaf93cd">Discuss/Rate/Review</a>'
		$search_topic_id = '#.*<a href="viewtopic\.php\?t=(\d+).*">Discuss\/Rate\/Review<\/a>.*#'; 

		$moddb_mods = array();

		$category = '';
		
		$i = -1;
		//$mod_name_index = -1;
		$current_field = 0;

		foreach ($mods_info as $line)
		{
			// check for mod category first so we can fill the unknown ones
			if ( preg_match($search_cat, $line, $match) )
			{
				$category = intval($match[1]);
			}
			else
			// check for matches on each line
			if ( preg_match($search_name, $line, $match) && !empty($category) )
			{
				$i++;
				// we use this index in order to synchronize all fields of a mod
				//$mod_name_index = $i;

				$moddb_mods[$i]['name'] = trim(htmlspecialchars($match[1]));
				//echo "*".$moddb_mods[$i]['name']."<br>";
	
				// store the category too
				$moddb_mods[$i]['cat_id'] = $category;
				
				$current_field = 1;
			}
			elseif ( preg_match($search_version, $line, $match) & $current_field == 1 )
			{
				$moddb_mods[$i]['version'] = trim(htmlspecialchars($match[1]));
				
				$current_field = 2;
				//echo "*".$moddb_mods[$i]['version']."<br>";
			}
			elseif ( preg_match($search_download, $line, $match) & $current_field == 2 )
			{
				$moddb_mods[$i]['link'] = trim(htmlspecialchars($match[1]));
				$moddb_mods[$i]['file'] = trim(htmlspecialchars($match[2]));
				
				$current_field = 3;
				//echo "*".$moddb_mods[$i]['file']."<br>";
			}
			elseif ( preg_match($search_topic_id, $line, $match) & $current_field == 3 )
			{
				$moddb_mods[$i]['topic_id'] = intval($match[1]);
				
				$current_field = 4;
				//echo "*".$moddb_mods[$i]['topic_id']."<br><br>";

				//$i++;
			}

		}	// foreach ($mods_info as $line)
	}	// if ( !empty($mods_info) )

	$where_sql = ( $cat_mode == 'all' ) ? "( cat_id = $cat_id OR cat_id = 0 )" : "cat_id = $cat_id";

	//get the mods of this category from the db
	$sql = "SELECT mod_id, mod_name, cat_id FROM " . MODS_VERSION_TABLE . "
		WHERE mod_check_status = " . MOD_STATUS_CHECK . "
			AND $where_sql";

	if ( !($result = $db->sql_query($sql))  )
	{
		message_die(GENERAL_ERROR, 'Could not obtain mod information', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$stored_mod = strtoupper(htmlspecialchars($row['mod_name']));

		// initialize some variables
		$new_cat_id = $row['cat_id'];
		$new_checkdate = time();
		$new_version = '';
		$dnld_link = '';
		$download_link = '';
		$mod_topic_id = '';
		
		$search_status = 2;	// 2 = error, 1 = not found, 0 = found

		// compare each mod with the retrieved data
		for ($i = 0; $i < count($moddb_mods); $i++)
		{
			// create both strings
			$checked_mod = strtoupper($moddb_mods[$i]['name']);
			$checked_mod_html = strtoupper(htmlspecialchars($moddb_mods[$i]['name']));

			$search_status = 1;

			if ( $stored_mod == $checked_mod || $stored_mod == $checked_mod_html )
			{
				$new_version = $moddb_mods[$i]['version'];
				$new_cat_id = $moddb_mods[$i]['cat_id'];

				$download_link = str_replace('&amp;', '&', $moddb_mods[$i]['link']);
				$download_file = str_replace('&amp;', '&', $moddb_mods[$i]['file']);
				$dnld_link = '<a href="'.$download_link.'" target="_blank" class="postlink">'.$download_file.'</a>';

				$mod_topic_id = $moddb_mods[$i]['topic_id'];
				
				$search_status = 0;

				// exit the for loop if mod is found
				break;
			}
		}

		// update the mod details according to search_status
		if ( $search_status == 0 )
		{
			update_mod_details($row['mod_id'], $new_cat_id, $new_version, $new_checkdate, $mod_topic_id, $dnld_link, MOD_STATUS_FOUND);
		}
		elseif ( $search_status == 1 && ( $row['cat_id'] != 0 || ( $row['cat_id'] == 0 && get_next_category($cat_id) == '' ) ) )
		{
			update_mod_details($row['mod_id'], $new_cat_id, $new_version, $new_checkdate, $mod_topic_id, $dnld_link, MOD_STATUS_NOTFOUND);
		}
		elseif ( $search_status == 2 && ( $row['cat_id'] != 0 || ( $row['cat_id'] == 0 && get_next_category($cat_id) == '' ) ) )
		{
			update_mod_details($row['mod_id'], $new_cat_id, $new_version, $new_checkdate, $mod_topic_id, $dnld_link, MOD_STATUS_ERROR);
		}
	}	// while ( $row = $db->sql_fetchrow($result) )


	// get the next category to be searched by looking at the mods table
	$sql = "SELECT DISTINCT cat_id FROM " . MODS_VERSION_TABLE . "
		WHERE mod_check_status = " . MOD_STATUS_CHECK . "
		ORDER BY cat_id ASC
		LIMIT 1";

	if ( !($result = $db->sql_query($sql))  )
	{
		message_die(GENERAL_ERROR, 'Could not obtain cat_id information', '', __LINE__, __FILE__, $sql);
	}

	$finished = false;

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['cat_id'] == 0 )
		{
			$cat_mode = '&amp;cat_mode=all';
			$next_cat_id = get_next_category($cat_id);

			if ( $next_cat_id == '' )
			{
				$finished = true;
			}
		}
		else
		{
			$cat_mode = '';
			$next_cat_id = $row['cat_id'];
		}
	}
	else
	{
		$finished = true;
	}

	// check if we met any errors
	if ( $error_info != '' )
	{
		$error_counter++;
		$error_mode = "&amp;error=$error_counter";
	}
	elseif ( $error_counter > 0 )
	{
		$error_mode = "&amp;error=$error_counter";
	}
	else
	{
		$error_mode = '';
	}

	// if we haven't finished, proceed to the next category
	if ( !$finished )
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="1;url=' . append_sid("admin_mod_version_checker.$phpEx?" . "mode=check_updates&amp;cat_id=$next_cat_id" . $cat_mode. $error_mode) . '" />')
		);

		$message = ( !empty($error_info) ) ? '<span class="mvc_error">' . $lang['Error'] . '</span>: <i>' . $error_info . '</i><br /><br />' : '';
		$message .= sprintf($lang['Checking_updates'], $mod_categories[$next_cat_id]);
		message_die(GENERAL_MESSAGE, $message);
	}

}
// add or edit a mod
elseif ( $mode == 'add' || $mode == 'edit')
{
	$mod_id = ( !empty($HTTP_POST_VARS['mod_id']) ) ? $HTTP_POST_VARS['mod_id'] : $HTTP_GET_VARS['mod_id'];
	$mod_id = intval($mod_id);

	if ( isset($HTTP_POST_VARS['submit_mod']) && !empty($HTTP_POST_VARS['mod_name']) )
	{
		$mod_name = trim(htmlspecialchars($HTTP_POST_VARS['mod_name']));
		$mod_author = trim(htmlspecialchars($HTTP_POST_VARS['mod_author']));
		$mod_version = trim(htmlspecialchars($HTTP_POST_VARS['mod_version']));

		$where_sql = ( $mode == 'edit')  ? "AND mod_id != $mod_id" : '';

		// check if a mod with the same name already exists
		$sql = "SELECT mod_id FROM " . MODS_VERSION_TABLE . "
		WHERE mod_name = '" . str_replace("\'", "''", $mod_name) . "'
			$where_sql";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain mod information', '', __LINE__, __FILE__, $sql);
		}

		if  ( $db->sql_numrows($result) > 0 )
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_mod_version_checker.$phpEx?mode=$mode&amp;mod_id=$mod_id") . '" />')
			);

			$message = $lang['Mod_already_exists'] . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx?mode=$mode&amp;mod_id=$mod_id") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}

		// insert or update the mod
		$sql = ( $mode == 'add') ? "INSERT INTO " : "UPDATE ";
		$where_sql = ( $mode == 'edit' ) ? "WHERE mod_id = $mod_id" : '';

		$sql = $sql . MODS_VERSION_TABLE . "
		SET
			mod_name = '" . str_replace("\'", "''", $mod_name) . "',
			mod_author = '" . str_replace("\'", "''", $mod_author) . "',
			mod_version = '" . str_replace("\'", "''", $mod_version) . "',
			cat_id = "  . intval($HTTP_POST_VARS['cat_id']) . ",
			mod_date = " . time() . "
		$where_sql";

		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not insert/update mod', '', __LINE__, __FILE__, $sql);
		}

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_mod_version_checker.$phpEx") . '" />')
		);

		$message = (( $mode == 'add' ) ? $lang['Mod_added'] : $lang['Mod_updated'] ) . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{
		// initialize mod vars
		$mod_name = '';
		$mod_author = '';
		$mod_version = '';
		$s_hidden_fields = '';

		$page_title = $lang['Page_title'];
		include('./page_header_admin.'.$phpEx);

		$template->set_filenames(array(
		    "body" => "admin/mod_version_checker.tpl")
		);

		if ( $mode == 'edit' )
		{
			$mod_details = array();
			$mod_details = get_mod_details($mod_id);

			$mod_name = $mod_details['mod_name'];
			$mod_author = $mod_details['mod_author'];
			$mod_version = $mod_details['mod_version'];

			$s_hidden_fields = '<input type="hidden" name="mod_id" value="' . $mod_details['mod_id'] . '">';
		}

		// check if the user pressed the parse button
		if ( isset($HTTP_POST_VARS['upload_mod']) && isset($HTTP_POST_FILES['mod_filename']) && !empty($HTTP_POST_FILES['mod_filename']['tmp_name']) )
		{
			$mod_filename = $HTTP_POST_FILES['mod_filename']['tmp_name'];
			$mod_real_filemame = $HTTP_POST_FILES['mod_filename']['name'];

			// maybe we could use fgets() or even file() here
			$fp = fopen($mod_filename, "r+b");
			if ( $fp && filesize($mod_filename) > 0 )
			{
				$buffer = fread($fp, filesize($mod_filename));
   			fclose($fp);

   			$mod_lines = preg_split("/\r?\n|\r/", $buffer);
			}
			else
			{
				$message = $lang['Problem_file'] . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx?mode=$mode&amp;mod_id=$mod_id") . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}

			// check for xml file
			if ( strpos($mod_lines[0], '<?xml') !== false || strpos($mod_real_filemame, '.xml') == strlen($mod_real_filemame) - 4 )
			{
				// '<title lang="en-gb">MOD Version Checker</title>'
   			$search_name = '#<title.*>(.+?)</title>#';

   			/* <author>
						<realname>Tassos Chatzithomaoglou</realname>
						<email>chatasos@psclub.gr</email>
						<username>chatasos</username>
						<homepage>http://www.psclub.gr</homepage>
						<contributions />
					</author>
				*/
   			$search_author = '#<author>.*?<username>(.+?)</username>.*?</author>#s';

   			/* <mod-version>
						<major>1</major>
						<minor>0</minor>
						<revision>2</revision>
					</mod-version>
				*/
   			$search_version = '#<mod-version>.*?<major>(.+?)</major>.*?<minor>(.+?)</minor>.*?<revision>(.+?)</revision>.*?</mod-version>#s';
   			
				// check the whole xml file at once		
   			if ( preg_match($search_name, $buffer, $match) )
				{
					$mod_name = trim(htmlspecialchars($match[1]));
				}
				// get only the 1st author
				if ( preg_match($search_author, $buffer, $match) && $mod_author == '' )
				{
					$mod_author = trim(htmlspecialchars($match[1]));
				}
				if ( preg_match($search_version, $buffer, $match) )
				{
					$mod_version_major = trim(htmlspecialchars($match[1]));
					$mod_version_minor = trim(htmlspecialchars($match[2]));
					$mod_version_revision = trim(htmlspecialchars($match[3]));
		
					$mod_version = "$mod_version_major.$mod_version_minor.$mod_version_revision";
				}
			}
			else	// text file
			{
   			// '## MOD Title: MOD Version Checker'
   			$search_name = '/^## MOD Title:(.+?)$/';

   			// '## MOD Author: chatasos < chatasos@psclub.gr > (Tassos Chatzithomaoglou) http://www.psclub.gr'
   			$search_author = '/^## MOD Author:(.+?) </';

   			// '## MOD Version: 0.9.1'
   			$search_version = '/^## MOD Version:(.+?)$/';
	
				// find the keywords we are searching
   			foreach ( $mod_lines as $line )
   			{
   				if ( preg_match($search_name, $line, $match) )
					{
						$mod_name = trim(htmlspecialchars($match[1]));
					}
					// get only the 1st author
					else if ( preg_match($search_author, $line, $match) && $mod_author == '' )
					{
						$mod_author = trim(htmlspecialchars($match[1]));
					}
					elseif ( preg_match($search_version, $line, $match) )
					{
						$mod_version = trim(htmlspecialchars($match[1]));
						break;
					}
   			}
   		}
		}

		// create the category select list
		$cat_select = '<select name="cat_id">';
		foreach ( $mod_categories as $key => $value)
		{
			$cat_select .= '<option value="' . $key . '"' . ( ($mode == 'edit' && $key == $mod_details['cat_id'] ) ? ' selected="selected"' : '') . '>' . $value . '</option>';
		}
		$cat_select .= '</select>';

		$template->assign_block_vars("edit_mod", array(
			'NAME'		=> $mod_name,
			'AUTHOR'		=> $mod_author,
			'VERSION'	=> $mod_version,
			'CAT'			=> $cat_select
			)
		);

		$template->assign_vars(array(
			'L_MOD_VERSION_CHECKER'	=> $lang['Mod_version_checker'],

			'L_EDIT_MOD'			=> ( $mode == 'add' ) ? $lang['Add_new_mod_info'] : $lang['Edit_mod_info'],

			'L_MOD_NAME'			=> $lang['Mod_name'],
			'L_MOD_AUTHOR'			=> $lang['Mod_author'],
			'L_MOD_VERSION'		=> $lang['Mod_version'],
			'L_PARSE_MOD_FILE'	=> $lang['Parse_mod_file'],
			'L_PARSE'				=> $lang['Parse'],
			'L_MOD_CATEGORY'		=> $lang['Mod_category'],

			'L_SUBMIT'				=> $lang['Submit'],
			'L_CANCEL'				=> $lang['Cancel'],

			'MOD_VERSION_CHECKER_VERSION'	=> MOD_VERSION_CHECKER_VERSION,

			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			'S_MOD_ACTION'		=> append_sid("admin_mod_version_checker.$phpEx?mode=$mode")
			)
		);

		$template->pparse('body');

		include('./page_footer_admin.'.$phpEx);
		exit;
	}
}
// delete a mod
elseif ( $mode == 'delete' )
{
	$mod_id = ( !empty($HTTP_POST_VARS['mod_id']) ) ? $HTTP_POST_VARS['mod_id'] : $HTTP_GET_VARS['mod_id'];
	$mod_id = intval($mod_id);

	if ( !$confirm )
	{
		$s_hidden_fields = '<input type="hidden" name="mod_id" value="' . $mod_id . '" />';
		$s_hidden_fields .= '<input type="hidden" name="mode" value="delete" />';

		//
		// Output confirmation page
		//
		include('./page_header_admin.'.$phpEx);

		$template->set_filenames(array(
			'confirm_body' => 'admin/confirm_body.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE'	=> $lang['Mod_version_checker'] . ' - ' . $lang['Information'],
			'MESSAGE_TEXT'		=> $lang['Confirm_delete_mod'],

			'L_YES'	=> $lang['Yes'],
			'L_NO'	=> $lang['No'],

			'S_HIDDEN_FIELDS'		=> $s_hidden_fields,
			'S_CONFIRM_ACTION'	=> append_sid("admin_mod_version_checker.$phpEx")
			)
		);

		$template->pparse('confirm_body');

		include('./page_footer_admin.'.$phpEx);
		exit;
	}

	$sql = "DELETE FROM " . MODS_VERSION_TABLE . "
		WHERE mod_id = $mod_id";

	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not delete mod', '', __LINE__, __FILE__, $sql);
	}

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_mod_version_checker.$phpEx") . '" />')
	);

	$message = $lang['Mod_deleted'] . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);

}
// update a mod
elseif ( $mode == 'update' )
{
	$mod_id = ( !empty($HTTP_POST_VARS['mod_id']) ) ? $HTTP_POST_VARS['mod_id'] : $HTTP_GET_VARS['mod_id'];
	$mod_id = intval($mod_id);

	$sql = "UPDATE " . MODS_VERSION_TABLE . "
		SET
			mod_version = mod_latest_version,
			mod_date = " . time() . "
		WHERE mod_id = $mod_id";

	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update mod', '', __LINE__, __FILE__, $sql);
	}

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_mod_version_checker.$phpEx") . '" />')
	);

	$message = $lang['Mod_updated'] . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx") . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}
// get easymod mods
elseif ( $mode == 'easymod' && easymod_exists() )
{
	if ( isset($HTTP_POST_VARS['easymods_submit']) )
	{
		// check if nothing was selected
		if ( !isset($HTTP_POST_VARS['easymods_insert']) && !isset($HTTP_POST_VARS['easymods_update']) )
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_mod_version_checker.$phpEx?mode=$mode") . '" />')
			);

			$message = $lang['No_mods_selected'] . '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx?mode=$mode") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}

		// insert mods
		if ( isset($HTTP_POST_VARS['easymods_insert']) && !empty($HTTP_POST_VARS['easymods_insert']) )
		{
			$easymod_ids = array();
			foreach ( $HTTP_POST_VARS['easymods_insert'] as $row )
			{
				$easymod_ids[] = intval($row);
			}

			$easymods_inserted = count($easymod_ids);

			// get the mods from the easymod table
			$sql = "SELECT mod_title, mod_author_handle, mod_version
				FROM " . EASYMOD_TABLE . "
				WHERE mod_id IN (" . implode(',', $easymod_ids) . ")";

			if ( !($result = $db->sql_query($sql))  )
			{
				message_die(GENERAL_ERROR, 'Could not obtain EasyMOD mods information', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				// insert them to our own table
				$sql2 = "INSERT INTO " . MODS_VERSION_TABLE . "
				SET
					mod_name = '" . str_replace("\'", "''", addslashes($row['mod_title'])) . "',
					mod_author = '" . str_replace("\'", "''", addslashes($row['mod_author_handle'])) . "',
					mod_version = '" . str_replace("'", "''", $row['mod_version']) . "',
					cat_id = 0,
					mod_date = " . time();

				if ( !$db->sql_query($sql2) )
				{
					message_die(GENERAL_ERROR, 'Could not insert EasyMOD mods', '', __LINE__, __FILE__, $sql2);
				}
			}
		}

		// update mods
		if ( isset($HTTP_POST_VARS['easymods_update']) && !empty($HTTP_POST_VARS['easymods_update'])  )
		{
			$easymod_ids = array();
			foreach ( $HTTP_POST_VARS['easymods_update'] as $row )
			{
				$easymod_ids[] = intval($row);
			}

			$easymods_updated = count($easymod_ids);

			// get the mods from the easymod table
			$sql = "SELECT mod_title, mod_version
				FROM " . EASYMOD_TABLE . "
				WHERE mod_id IN (" . implode(',', $easymod_ids) . ")";

			if ( !($result = $db->sql_query($sql))  )
			{
				message_die(GENERAL_ERROR, 'Could not obtain EasyMOD mods information', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				// update our own table
				$sql2 = "UPDATE " . MODS_VERSION_TABLE . "
				SET
					mod_version = '" . str_replace("'", "''", $row['mod_version']) . "',
					mod_date = " . time() . "
				WHERE mod_name = '" . str_replace("'", "''", $row['mod_title']) .  "'";

				if ( !$db->sql_query($sql2) )
				{
					message_die(GENERAL_ERROR, 'Could not update EasyMOD mods ', '', __LINE__, __FILE__, $sql2);
				}
			}
		}

		// at least one of them is set, if we get here
		if ( empty($easymods_inserted) )
		{
			$message = sprintf($lang['Easymods_updated'], $easymods_updated);
		}
		elseif ( empty($easymods_updated) )
		{
			$message = sprintf($lang['Easymods_added'], $easymods_inserted);
		}
		else
		{
			$message = sprintf($lang['Easymods_added'], $easymods_inserted) . '<br />' . sprintf($lang['Easymods_updated'], $easymods_updated);
		}

		$message .=  '<br /><br />' . sprintf($lang['Click_return_version_checker'], '<a href="' . append_sid("admin_mod_version_checker.$phpEx") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{

		$page_title = $lang['Page_title'];
		include('./page_header_admin.'.$phpEx);

		$template->set_filenames(array(
	   	 "body" => "admin/mod_version_checker.tpl")
		);

		$template->assign_block_vars("easymods", array(
			)
		);

		// get the mods from the easymod table
		$sql = "SELECT mod_id, mod_title, mod_author_handle, mod_version, mod_process_date
			FROM " . EASYMOD_TABLE;

		if ( !($result = $db->sql_query($sql))  )
		{
			message_die(GENERAL_ERROR, 'Could not obtain EasyMOD mods information', '', __LINE__, __FILE__, $sql);
		}

		$easymods = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$easymod_found = false;

			// check if we already have the same mod into the table, but with an older version
			for ( $i = 0; $i < count($easymods); $i++ )
			{
				if ( $row['mod_title'] == $easymods[$i]['mod_title'] )
				{
					$easymod_found = true;

					$old_array = array();
					$new_array = array();
					list($old_array, $new_array) = version_strings_to_arrays($easymods[$i]['mod_version'], $row['mod_version']);

					// if a newer version is found, update its old record in the array
					if ( compare_arrays($old_array, $new_array) == -1 )
					{
						$easymods[$i] = $row;
						break;
					}
				}
			}

			// if the mod is not found, add it to the array
			if ( !$easymod_found )
			{
				$easymods[] = $row;
			}
		}


		$new_easymod_found = false;
		// show the easymod mods that were found
		for ( $i = 0; $i < count($easymods); $i++ )
		{
			// check if we already have a mod with the same name
			$sql = "SELECT mod_id, mod_version, mod_date
					FROM " . MODS_VERSION_TABLE . "
					WHERE mod_name = '" . str_replace("\'", "''", addslashes($easymods[$i]['mod_title'])) .  "'";

			if ( !($result = $db->sql_query($sql))  )
			{
				message_die(GENERAL_ERROR, 'Could not obtain mods information', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$easymods[$i]['version'] = $row['mod_version'];
				$easymods[$i]['date'] = $row['mod_date'];

				// check if we have the same version
				if ( $row['mod_version'] == $easymods[$i]['mod_version'] )
				{
					$l_action = '';
					$action = '';
				}
				else
				{
					$l_action = $lang['Update'];
					$action = 'update';
					$new_easymod_found = true;
				}
			}
			else
			{
				$easymods[$i]['version'] = '-';
				$easymods[$i]['date'] = '';
				$l_action = $lang['Insert'];
				$action = 'insert';
				$new_easymod_found = true;
			}

			$template->assign_block_vars("easymods.details", array(
				'ROW_CLASS'		=> ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],

				'AA'				=> $i + 1,

				'EASY_NAME'		=> $easymods[$i]['mod_title'],
				'EASY_AUTHOR'	=> $easymods[$i]['mod_author_handle'],
				'EASY_VERSION'	=> $easymods[$i]['mod_version'],
				'EASY_DATE'		=> create_date($board_config['default_dateformat'], $easymods[$i]['mod_process_date'], $board_config['board_timezone']),

				'VERSION'	=> $easymods[$i]['version'],
				'DATE'		=> ( $easymods[$i]['date'] != '') ? create_date($board_config['default_dateformat'], $easymods[$i]['date'], $board_config['board_timezone']) : ''
				)
			);

			// create the action cell
			if ( !empty($action) )
			{
				$template->assign_block_vars("easymods.details.action", array(
					'EASY_ID'	=> $easymods[$i]['mod_id'],
					'L_ACTION'	=> $l_action,
					'ACTION'		=> $action,
					'CHECKED'	=> ( $action == 'insert' ) ? 'checked="checked"' : ''
					)
				);
			}

		}

		if ( $new_easymod_found )
		{
			$template->assign_block_vars("easymods.global_check", array(
				)
			);
		}

		$template->assign_vars(array(
			'L_MOD_VERSION_CHECKER'	=> $lang['Mod_version_checker'],
			'L_MOD_EXPLAIN'			=> $lang['Mod_explain_easymod'],

			'L_MODS'					=> $lang['Easymod_mods'],
			'L_MODIFICATION'		=> $lang['Modification'],
			'L_EASYMOD_VERSION'	=> $lang['Easymod_version'],
			'L_CURRENT_VERSION'	=> $lang['Current_version'],
			'L_CHECK'				=> $lang['Check'],

	'L_SELECT_ALL'			=> $lang['Select_all'],
	
			'L_MOD_NAME'			=> $lang['Mod_name'],
			'L_MOD_AUTHOR'			=> $lang['Mod_author'],
			'L_MOD_VERSION'		=> $lang['Mod_version'],

			'L_SUBMIT'				=> $lang['Submit'],
			'L_CANCEL'				=> $lang['Cancel'],

			'MOD_VERSION_CHECKER_VERSION'	=> MOD_VERSION_CHECKER_VERSION,

			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			'S_MOD_ACTION'		=> append_sid("admin_mod_version_checker.$phpEx?mode=$mode")
			)
		);

		$template->pparse('body');

		include('./page_footer_admin.'.$phpEx);
		exit;
	}
}


//
// default output
//

// create the page
$page_title = $lang['Page_title'];
include('./page_header_admin.'.$phpEx);

$template->set_filenames(array(
    "body" => "admin/mod_version_checker.tpl")
);

$template->assign_block_vars("mod", array(
	)
);


$stored_mods = array();
if ( $check_updates )
{
	$stored_mods = get_mod_details('', MOD_STATUS_NULL);
}
else
{
	$stored_mods = get_mod_details();
}

$unknown_categories = 0;
$mods_not_checked = 0;

for ($i = 0; $i < count($stored_mods); $i++)
{
	// reset the sign of each mod
	$mod_sign = '';

	// check if we have mods with unknown categories
	if ( $stored_mods[$i]['cat_id'] == 0 )
	{
		$unknown_categories++;
		$mod_sign = '*';
	}

	// check if we have mods that have never been checked before
	if ( empty($stored_mods[$i]['mod_latest_check']) )
	{
		$mods_not_checked++;
		$mod_sign .= '+';
	}

	// uncheck mods belonging to unknown categories before checking for updates
	if ( !$check_updates && $stored_mods[$i]['cat_id'] != 0 )
	{
		$mod_checked = 'checked="checked"';
	}
	else
	{
		$mod_checked = '';
	}

	// create the version & check date
	if ( $check_updates )
	{
		$mod_latest_version = ( $stored_mods[$i]['mod_check_status'] != MOD_STATUS_ERROR ) ? compare_versions($stored_mods[$i]['mod_version'], $stored_mods[$i]['mod_latest_version']) : '-'.$lang['Error'].'-';
		$mod_latest_check = create_date($board_config['default_dateformat'], $stored_mods[$i]['mod_latest_check'], $board_config['board_timezone']);
	}
	else
	{
		$mod_latest_version = compare_versions($stored_mods[$i]['mod_version'], $stored_mods[$i]['mod_latest_version']);
		$mod_latest_check = ( !empty($stored_mods[$i]['mod_latest_check']) ) ? create_date($board_config['default_dateformat'], $stored_mods[$i]['mod_latest_check'], $board_config['board_timezone']) : '';
	}

	// create the download link
	if ( $check_updates && $stored_mods[$i]['mod_check_status'] == MOD_STATUS_ERROR )
	{
		$mod_download_link = '-'.$lang['Error'].'-';
	}
	else
	{
		$mod_download_link = ( !empty($stored_mods[$i]['mod_dnld_link']) ) ? $stored_mods[$i]['mod_dnld_link'] : '-';
	}

	// create the mod name & topic id link
	if ( $check_updates && $stored_mods[$i]['mod_check_status'] == MOD_STATUS_ERROR )
	{
		$mod_name = $stored_mods[$i]['mod_name'];
	}
	else
	{
		$phpbb_viewtopic = '<a href=http://www.phpbb.com/phpBB/viewtopic.php?t=';
		$mod_name = $phpbb_viewtopic.$stored_mods[$i]['mod_topic_id'].' target="_blank">'.$stored_mods[$i]['mod_name'].'</a>';
		$mod_name = ( !empty($stored_mods[$i]['mod_topic_id']) ) ? $mod_name : $stored_mods[$i]['mod_name'];
	}
	
	$template->assign_block_vars("mod.details", array(
		'ROW_CLASS'		=> ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],

		'AA'		=> ($i + 1) . (( $mod_sign == '' ) ? '' : ' <span class="mvc_error">'.$mod_sign.'</span>'),
		'ID'		=> $stored_mods[$i]['mod_id'],
		'NAME'	=> $mod_name,
		'AUTHOR'	=> $stored_mods[$i]['mod_author'],
		'VERSION'=> ( $stored_mods[$i]['mod_version'] != '' ) ? $stored_mods[$i]['mod_version'] : '-',
		'DATE'	=> ( !empty($stored_mods[$i]['mod_date']) ) ? create_date($board_config['default_dateformat'], $stored_mods[$i]['mod_date'], $board_config['board_timezone']) : '',

		'LATEST_VERSION'	=> $mod_latest_version,
		'LATEST_CHECK'		=> $mod_latest_check,
		'DOWNLOAD_LINK'	=> $mod_download_link,

		'CHECKED'			=> ( !$check_updates ) ? $mod_checked : 'disabled="disabled"',
		)
	);

	if ( !$check_updates )
	{
		$template->assign_block_vars("mod.details.before_check", array(
			'U_EDIT'		=> append_sid("admin_mod_version_checker.$phpEx?mode=edit&amp;mod_id=" . $stored_mods[$i]['mod_id']),
			'U_DELETE'	=> append_sid("admin_mod_version_checker.$phpEx?mode=delete&amp;mod_id=" . $stored_mods[$i]['mod_id']),
			'U_UPDATE'	=> ( $stored_mods[$i]['mod_latest_version'] != '' ) ? append_sid("admin_mod_version_checker.$phpEx?mode=update&amp;mod_id=" . $stored_mods[$i]['mod_id']) : '',
			'L_UPDATE'	=> ( $stored_mods[$i]['mod_latest_version'] != '' ) ? $lang['Update'] : ''
			)
		);
	}
}

// display the "check" or "return" button
if ( !$check_updates )
{
	$template->assign_block_vars("mod.before_check", array(
		'S_CHECKED'		=> ( count($stored_mods) != 0 ) ? 'checked="checked"' : '',
		'S_DISABLED'	=> ( count($stored_mods) == 0 ) ? 'disabled="disabled"' : ''
		)
	);

	// display the "easymod" button
	if ( easymod_exists() )
	{
		$template->assign_block_vars("mod.before_check.easymod", array(
			)
		);
	}
}
else
{
	$template->assign_block_vars("mod.after_check", array(
		)
	);

}

// create the error message
$message = ( $error_counter != 0 ) ? sprintf($lang['Error_messages'], $error_counter) : '';
$message .= (( !empty($message) ) ? '<br />' : '' ) . (( !empty($error_info) ) ? sprintf($lang['Last_error_message'], $error_info) : '');

// print some info when not checking for updates
if ( !$check_updates )
{
	$message_info = '';
	
	// show message for unknown categories
	if ( $unknown_categories > 0 )
	{
		$message_info = sprintf($lang['Mods_unknown_categories'], $unknown_categories);
	}

	// show message for not checked mods
	if ( $mods_not_checked > 0 )
	{
		$message_info .= (( !empty($message_info) ) ? '<br />' : '' ) . sprintf($lang['Mods_not_checked'], $mods_not_checked);
	}
	
	// show message for safe mode timeout
	if ( ini_get('safe_mode') )
	{
		$max_execution_time = ini_get('max_execution_time');
		$message_info .= (( !empty($message_info) ) ? '<br />' : '' ) .  sprintf($lang['Explain_safe'], $max_execution_time);
	}
	
	$message .= (( !empty($message) ) ? '<br /><br />' : '' ) . $message_info;
}

// display the legend
foreach ( $status_colors as $status => $class )
{
	$template->assign_block_vars("mod.legend", array(
		'CLASS'	=> $class,
		'TEXT'	=> $lang['Status_'.$status]
		)
	);
}


$template->assign_vars(array(
	'L_MOD_VERSION_CHECKER'	=> $lang['Mod_version_checker'],
	'L_MOD_EXPLAIN'			=> ( !$check_updates ) ? $lang['Mod_explain_before'] : $lang['Mod_explain_after'],

	'L_MODS'					=> ( !$check_updates ) ? $lang['Installed_mods'] : $lang['Checked_mods'],
	'L_MESSAGE'				=> $message,

	'L_SELECT_ALL'			=> $lang['Select_all'],

	'L_MODIFICATION'		=> $lang['Modification'],
	'L_CURRENT_VERSION'	=> $lang['Current_version'],
	'L_ACTION'				=> ( !$check_updates ) ? $lang['Action'] : '',
	'L_MODDB_VERSION'		=> $lang['Moddb_version'],
	'L_MOD_DOWNLOAD_LINK'=> $lang['Mod_Download_link'],
	'L_CHECK'				=> $lang['Check'],

	'L_MOD_NAME'			=> $lang['Mod_name'],
	'L_MOD_AUTHOR'			=> $lang['Mod_author'],
	'L_MOD_VERSION'		=> $lang['Mod_version'],
	'L_MOD_CATEGORY'		=> $lang['Mod_category'],

	'L_EDIT'					=> $lang['Edit'],
	'L_DELETE'				=> $lang['Delete'],

	'L_RETURN'				=> $lang['Return'],
	'L_CHECK_UPDATES'		=> $lang['Check_updates'],
	'L_RESET_UPDATES'		=> $lang['Reset_updates'],
	'L_ADD_MOD'				=> $lang['Add_mod'],
	'L_ADD_EASYMOD'		=> $lang['Add_easymod'],

	'MOD_VERSION_CHECKER_VERSION'	=> MOD_VERSION_CHECKER_VERSION,

	'S_MOD_ACTION'		=> append_sid("admin_mod_version_checker.$phpEx")
	)
);

$template->pparse('body');

//
// Page Footer
//
include('./page_footer_admin.'.$phpEx);


// ------------------
// Begin function block
//


// Get the next category id of the $mod_categories array
//
// input:
// cat_id = the current category id
//
// output:
// the next cat_id
// null when there is no next cat_id
function get_next_category($cat_id)
{
	global $mod_categories;

	$cat_found = false;
	$i = 0;

	foreach ( $mod_categories as $cat_key => $cat_value )
	{
		if ( $cat_found )
		{
			$next_cat_id = $cat_key;
			break;
		}

		if ( $cat_id == $cat_key )
		{
			if ( $i < count($mod_categories) - 1 )
			{
				$cat_found = true;
			}
			else
			{
				$next_cat_id = '';
				break;
			}
		}

		$i++;
	}

	return $next_cat_id;
}


// get the details of all or some of the mods
//
// input:
// $mods = array or var containing the mod ids
// $status = status of mods NOT to get
//
// output:
// array containing all the details
function get_mod_details($mods = '', $status = -1)
{
	global $db;

	if ( $mods == '' )
	{
		$where_sql = '';
	}
	elseif ( is_array($mods) )
	{
		$where_sql =  ' WHERE mod_id in (' . implode(',', $mods) . ') ';
	}
	else
	{
		$where_sql = " WHERE mod_id = $mods";
	}

	if ( $status != -1 )
	{
		$status_sql = ( ( $where_sql != '' ) ? 'AND' : 'WHERE' ) . " mod_check_status != $status";
	}
	else
	{
		$status_sql = '';
	}

	$sql = "SELECT * FROM " . MODS_VERSION_TABLE . "
		$where_sql
		$status_sql
		ORDER BY mod_id ASC";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query mods information', '', __LINE__, __FILE__, $sql);
	}

	$mod_details = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$mod_details[] = $row;
	}

	return ( !is_array($mods) && $mods != '' ) ? $mod_details[0] : $mod_details;
}

// update the details of a mod
function update_mod_details($mod_id, $cat_id, $version, $checkdate, $topic_id, $link, $check_status)
{
	global $db;

	switch ( $check_status )
	{
		case MOD_STATUS_FOUND :
			$update_topic_id = " mod_topic_id = '" . str_replace("'", "''", $topic_id) . "',";
			$update_version = " mod_latest_version = '" . str_replace("'", "''", $version) . "',";
			$update_link = " mod_dnld_link = '" . str_replace("'", "''", $link) . "',";
			break;

		case MOD_STATUS_NOTFOUND :
			$update_topic_id = " mod_topic_id = '',";
			$update_version = " mod_latest_version = '',";
			$update_link =  " mod_dnld_link = '',";
			break;

		case MOD_STATUS_ERROR :
			$update_topic_id = '';
			$update_version = '';
			$update_link = '';
			break;
	}

	$sql = "UPDATE " . MODS_VERSION_TABLE . "
		SET
			cat_id = $cat_id,
			$update_topic_id
			$update_version
			$update_link
			mod_latest_check = $checkdate,
			mod_check_status = $check_status
		WHERE mod_id = $mod_id";

	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update mod details', '', __LINE__, __FILE__, $sql);
	}

	return;
}

// convert version strings to arrays with their parts
//
// input :
// 2 strings

// valid versions are the following
// 1.2.3
// 1.2.3c
// 1.2.3 (beta)
// 1.2.3 beta
// 1.2.3c beta
// 1.2.3beta
// where beta can be 'dev', 'alpha', 'beta', 'rc'

// output :
// an array containing 2 arrays with the values of strings seperated in dots
function version_strings_to_arrays($version1, $version2)
{
	$version_strings = array($version1, $version2);

	// insert dots where needed
	$versions_ary = array();
	foreach ( $version_strings as $version)
	{
		// put a . between numbers and letters
 		$version = preg_replace('#([0-9])([a-zA-Z])#','$1.$2', $version);
 		// put a . between letters and numbers
 		$version = preg_replace('#([a-zA-Z])([0-9])#','$1.$2', $version);
 		// put a space in the place of ( or )
 		$version = preg_replace('#[\(\)]#', ' ', $version);
 		// put a . in the place of one or more spaces
 		$version = preg_replace('#[\s]+#', '.', $version);

	 	$versions_ary[] = explode('.', $version);
 	}

 	$length = max(count($versions_ary[0]), count($versions_ary[1]));

	// make both arrays equal in length
	// maybe use array_fill()?
 	$final_versions_ary = array();
 	foreach ( $versions_ary as $version_ary)
 	{
 		while ( count($version_ary) < $length )
 		{
 			$version_ary[] = 0;
 		}
 		$final_versions_ary[] = $version_ary;
 	}

	return $final_versions_ary;
}

// compare array values one by one
//
// input: 2 arrays
//
// output:
// -1 => $array1 < $array2
//  0 => $array1 = $array2
// +1 => $array1 > $array2
// +2 => cannot compare
function compare_arrays($array1, $array2)
{
	// these are some special values
	$special = array('dev', 'alpha', 'beta', 'rc');

	// start checking each field of the 2 arrays
	for ( $i = 0; $i < count($array1); $i++ )
	{
		// we know that both arrays have the same length
		$var1 = strtolower($array1[$i]);
		$var2 = strtolower($array2[$i]);

		if ( $var1 == $var2 )
		{
			$result = 0;
			continue;
		}
		// compare integers or single characters
		elseif ( ( is_int($var1) && is_int($avar2) ) || ( strlen($var1) == 1 && strlen($var2) == 1 ) )
		{
			if ( $var1 < $var2 )
			{
				$result = -1;
				break;
			}
			else
			{
				$result = 1;
				break;
			}
		}
		// compare special values
		elseif ( in_array($var1, $special) && in_array($var2, $special) )
		{
			$var1 = array_keys($special, $var1);
			$var2 = array_keys($special, $var2);

			if ( $var1 < $var2 )
			{
				$result = -1;
				break;
			}
			else
			{
				$result = 1;
				break;
			}
		}
		// compare special value with something else
		elseif ( in_array($var1, $special) && !in_array($var2, $special) )
		{
			$result = -1;
			break;
		}
		// compare something else with special value
		elseif ( !in_array($var1, $special) && in_array($var2, $special) )
		{
			$result = 1;
			break;
		}
		else
		{
			$result = 2;
			break;
		}
	}	// for ( $i = 0; $i < count($array1); $i++ )

	return $result;
}

// compare the old & new versions of a mod
//
// input:
// 2 version strings to be compared
//
// output:
// a string containing the new version colorized
function compare_versions($old, $new)
{
	global $status_colors;

	// if the new version is null, make it "-" 
	if ( $new == '' )
	{
		return '-';
	}

	// check if the installed version is null
	if ( $old == '' )
	{
		$new = '<span class="'.$status_colors['null'].'">'.$new.'</span>';
		return $new;
	}
	
	$old_array = array();
	$new_array = array();
	list($old_array, $new_array) = version_strings_to_arrays($old, $new);

	$result = compare_arrays($old_array, $new_array);

	if ( $result == 0 )	// $old = $new
	{
		$new = '<span class="'.$status_colors['equal'].'">'.$new.'</span>';
	}
	elseif ( $result == 1 )	//  $old > $new
	{
		$new = '<span class="'.$status_colors['newer'].'">'.$new.'</span>';
	}
	elseif ( $result == -1 )	// $old < $new
	{
		$new = '<span class="'.$status_colors['older'].'">'.$new.'</span>';
	}
	else
	{
		$new = '<span class="'.$status_colors['other'].'">'.$new.'</span>';
	}

	return $new;
}

// get all the mods for a specific category
//
// input:
// $cat_id = mod category id
//
// output:
// $mods_info = var containing all mod details
// $errors_info = var containing all the error messages
function get_mods_info($cat_id)
{
	global $mod_categories, $lang;

	$mods_info = '';
	$error_info = '';

	$errno = 0;
	$errstr = '';

	// add our own cat_id
	$mods_info .= "<!-- cat_id = $cat_id -->";

	// get the MODDB page
	if ( $fsock = @fsockopen('www.phpbb.com', 80, $errno, $errstr) )
	{
		@fputs($fsock, "GET /phpBB/catdb.php?cat=$cat_id HTTP/1.1\r\n");
		@fputs($fsock, "HOST: www.phpbb.com\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$mods_info .= @fread($fsock, 1024);
			}
			else
			{
				if (@fgets($fsock, 1024) == "\r\n")
				{
					$get_info = true;
				}
			}
		}
		@fclose($fsock);
	}
	else
	{
		if ( !$errno )
		{
			$error_info .= $lang['Socket_functions_noinit'];
		}

		if ( $errstr )
		{
			$error_info .= $lang['Connect_socket_error'];
		}
		else
		{
			$error_info .= $lang['Socket_functions_nouse'];
		}
	}

	return array($mods_info, $error_info);
}

// check if easymod is installed
function easymod_exists()
{
	global $db, $table_prefix, $phpbb_root_path, $phpEx;

	if ( file_exists($phpbb_root_path . 'admin/em_includes/em_functions.'.$phpEx) )
	{
		include($phpbb_root_path . 'admin/em_includes/em_functions.'.$phpEx);

		$sql = "SELECT mod_title
			FROM " . EASYMOD_TABLE;

		if ( !($result = $db->sql_query($sql)) )
		{
			return false;
		}
		return true;
	}
	else
	{
		return false;
	}
}

//
// End function block
// ------------------

?>
