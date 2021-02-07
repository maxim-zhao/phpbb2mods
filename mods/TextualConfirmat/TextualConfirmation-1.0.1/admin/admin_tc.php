<?php
/***************************************************************************
 *                            admin_tc.php
 *                            -------------------
 *   begin                : Saturday, Oct 14, 2006
 *   copyright            : (C) 2006 bbAntiSpam
 *   email                : support@bbantispam.com
 *
 *   $Id: admin_tc.php 1369 2006-11-18 05:34:11Z olpa $
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
// A bit non-standard beginning of the admin file,
// to include language resources when !empty($setmodules)
//
$phpbb_root_path = "./../";
define('IN_PHPBB', 1);
require_once($phpbb_root_path . 'extension.inc');
require_once($phpbb_root_path . 'includes/functions_tc.' . $phpEx);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Textual_Confirmation'] = $file;
	tc_load_lang();
	return;
}

require('./pagestart.' . $phpEx);

//
// Get the data from user, sanify the data
//
$data = isset($HTTP_POST_VARS['data']) ? $HTTP_POST_VARS['data'] : '';
$data = stripslashes($data); // slashed in common.php
$action = isset($HTTP_POST_VARS['action']) ? $HTTP_POST_VARS['action'] : '';
assert(('update' == $action) or ('' == $action));
$messages = '';

//
// Load messages, get the data from database
//
tc_load_lang();
$db_data = tc_load_raw_data($db);

//
// Parse the user input to question=>answers pairs
//
function tc_parse_user_input($data) {
	global $messages, $lang;
	$parsed_data = array();
	$qas = preg_split("/\n\r?\n/", $data, -1, PREG_SPLIT_NO_EMPTY);
	foreach ($qas as $qa) {
		$qa = trim($qa);
		if (! empty($qa)) {
			$pair = preg_split("/\n/", $qa, 2, PREG_SPLIT_NO_EMPTY);
			if (2 == count($pair)) {
				$q = trim($pair[0]);
				if (array_key_exists($q, $parsed_data)) {
					$messages .= sprintf($lang['tc_admin_dup_question'], htmlspecialchars($q));
				}
				$parsed_data[$q] = trim($pair[1]);
			} else {
				$messages .= sprintf($lang['tc_admin_cant_parse'], htmlspecialchars($qa));
			}
		}
	}
	return $parsed_data;
}
if ('update' == $action) {
	$parsed_data = tc_parse_user_input($data);
}

//
// Update the database
//
function tc_streq($s1, $s2) { // Helper function
	$s1 = str_replace("\r", '', $s1);
	$s2 = str_replace("\r", '', $s2);
	return $s1 == $s2;
}
function tc_update_db($db, $parsed_data, $db_data) {
	global $messages, $lang;
	//
	// First, drop unchanged pairs
	//
	foreach ($parsed_data as $q=>$a) {
		if (array_key_exists($q, $db_data)) {
			if (tc_streq($parsed_data[$q], $db_data[$q]['a'])) {
				unset($parsed_data[$q]);
				unset($db_data[$q]);
			}
		}
	}
	//
	// Now, insert new data
	//
	foreach ($parsed_data as $q=>$a) {
		$sql = sprintf("INSERT INTO %s(question,answers) VALUES('%s','%s')",
			TEXTUAL_CONFIRMATION_TABLE, addslashes($q), addslashes($a));
		$sql = str_replace("\'", "''", $sql);
		if (! ($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, "Could not insert question/answer pair!", "", __LINE__, __FILE__, $sql);
		}
		$messages .= sprintf($lang['tc_admin_question_saved'], htmlspecialchars($q));
	}
	//
	// Finally, delete old data
	//
	if (count($db_data)) {
		$sql = '';
		$s   = '';
		foreach ($db_data as $q => $pair) {
			$sql .= (empty($sql) ? '' : ',') . $pair['id'];
			$s   .= "<br />\n" . htmlspecialchars($q);
		}
		$sql = sprintf("DELETE FROM %s WHERE id in (%s)",
			TEXTUAL_CONFIRMATION_TABLE, $sql);
		if (! ($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, "Could not delete questions!", "", __LINE__, __FILE__, $sql);
		}
		$messages .= sprintf($lang['tc_admin_question_deleted'], $s);
	}
	//
	// Updated
	//
	if (count($parsed_data) + count($db_data)) {
		$messages .= $lang['tc_admin_database_updated'];
	}
}	
if ('update' == $action) {
	tc_update_db($db, $parsed_data, $db_data);
}

//
// Make fake user input for the html form
//
function tc_fake_input($db_data) {
	$data = '';
	foreach ($db_data as $q => $a_pair) {
		$a = $a_pair['a'];
		if (! empty($data)) {
			$data = $data . "\n\n";
		}
		$data = $data . htmlspecialchars($q) . "\n" . htmlspecialchars($a);
	}
	return $data;
}
if ('update' != $action) {
	$data = tc_fake_input($db_data);
}
$messages .= $lang['tc_admin_explanation'];

//
// Display the page
//
$template->set_filenames(array(
	'tc' => 'admin/textual_confirmation.tpl')
);
$template->assign_vars(array(
	'S_TC_ACTION' => append_sid("admin_tc.$phpEx"),
	'DATA'        => $data,
	'MESSAGES'    => $messages,
	'L_TC_TITLE'  => $lang['Textual_Confirmation'],
	'L_RESET'     => $lang['Reset'],
	'L_SUBMIT'    => $lang['Submit']
	));
$template->pparse("tc");

include('./page_footer_admin.'.$phpEx);
  
?>
