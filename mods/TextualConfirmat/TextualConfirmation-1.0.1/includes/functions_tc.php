<?php
/***************************************************************************
 *                            functions_tc.php
 *                            -------------------
 *   begin                : Monday, Oct 16, 2006
 *   copyright            : (C) 2006 bbAntiSpam
 *   email                : support@bbantispam.com
 *
 *   $Id: functions_tc.php 1367 2006-11-18 05:28:14Z olpa $
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
  
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}

//
// Load language resources
//
function tc_load_lang() {
	global $lang, $board_config, $phpbb_root_path, $phpEx;
	$path_pre  = $phpbb_root_path . 'language/lang_';
	$path_post = '/lang_tc.' . $phpEx;
	$bb_lang   = $board_config['default_lang'];
	$lang_file = $path_pre . $bb_lang . $path_post;
	if (! file_exists (@phpbb_realpath ($lang_file))) {
		$lang_file = $path_pre . 'english' . $path_post;
	}
	include_once ($lang_file);
}

//
// Get the data from database. Format:
// question => array(id of the question, "\n"-separated answers)
//
function tc_load_raw_data($db) {
	$db_data = array();
	$sql = 'SELECT * FROM ' . TEXTUAL_CONFIRMATION_TABLE;
	if (! ($result = $db->sql_query($sql)) ) {
		// Most likely, the error is due to the missed table:
		// The MOD files are installed, but the database isn't updated.
		// Therefore, don't raise an error. Instead, deactivate the MOD.
		// message_die(GENERAL_ERROR, "Could not get questions!", "", __LINE__, __FILE__, $sql);
		return array();
	}
	$rowset = $db->sql_fetchrowset();
	if (! $rowset) {
		return array();
	}
	foreach ($rowset as $row) {
		$db_data[$row['question']] = array('id'=>$row['id'], 'a'=>$row['answers']);
	}
	return $db_data;
}

//
// Validate the asnwer
//
function tc_hook_register() {
	global $db, $mode, $HTTP_POST_VARS;
	//
	// Any action only when registering
	//
	if ('register' != $mode) {
		return;
	}
	//
	// Load the questions from the database.
	// If none, the MOD is disabled
	//
	$db_data = tc_load_raw_data($db);
	if (! count($db_data)) {
		return;
	}
	//
	// Check if an answer is given
	//
	if (! array_key_exists('tc_question_id', ($HTTP_POST_VARS))) {
		return tc_bad_answer();
	}
	if (! array_key_exists('tc_answer', ($HTTP_POST_VARS))) {
		return tc_bad_answer();
	}
	$question_id = intval($HTTP_POST_VARS['tc_question_id']);
	$answer      = trim(stripslashes($HTTP_POST_VARS['tc_answer']));
	//
	// Find the question/answers pair.
	// If the pair isn't found, it's the error.
	// If the question has no answers, then any answer is ok.
	//
	foreach ($db_data as $q=>$a) {
		if ($a['id'] == $question_id) {
			$answers = $a['a'];
			break;
		}
	}
	if (! isset($answers)) {
		return tc_bad_answer();
	}
	$answers = trim($answers);
	if (empty($answers)) {
		return;
	}
	//
	// Check if the answer is correct
	//
	$as = preg_split("/\n/", $answers, -1, PREG_SPLIT_NO_EMPTY);
	foreach ($as as $a) {
		$a = trim($a);
		if (strtolower($a) == strtolower($answer)) {
			return;
		}
	}
	tc_bad_answer();
}

//
// The answer is incorrect
//
function tc_bad_answer() {
	global $error, $error_msg, $lang, $phpbb_root_path, $phpEx, $board_config;
	global $lang, $username, $email, $website, $signature;
	global $HTTP_SERVER_VARS;
	//
	// Set the error flag and the error message
	//
	tc_load_lang();
	$error = TRUE;
	$s = $lang['tc_bad_answer'];
	if (isset($error_msg) && (!empty($error_msg))) {
		$error_msg = $error_msg . '<br />' . $s;
	} else {
		$error_msg = $s;
	}
	//
	// Send an email to update the public database of spammers,
	// unless the user has a license
	//
	$lic_file = $phpbb_root_path . 'includes/bbantispam.key';
	$lic_key  = 'x';
	$key      = '';
	if (file_exists (@phpbb_realpath ($lic_file))) {
		include($lic_file);
		$s1 = strtr($board_config['server_name'], array(' ' => '', '.' => '', 'w' => ''));
		$s2 = strtr($lic_server, array(' ' => '', '.' => '', 'w' => ''));
		if ($s1 == $s2) {
			$key = md5($s1);
			if ($key == $lic_key) {
				if (! (isset($tc_notify) and $tc_notify)) {
					return;
				}
			}
		}
	}
	//
	// Collect: user name, e-mail domain name, website, signature, HTTP data
	//
	$signature   = stripslashes($signature);
	$trans_table = array_flip(get_html_translation_table(HTML_ENTITIES));
	$signature   = strtr($signature, $trans_table);
	$domain      = strstr($email, '@');
	if (! $domain) {
		$domain = $email;
	}
	$server = '';
	foreach (array('REMOTE_ADDR','HTTP_USER_AGENT','HTTP_VIA','HTTP_X_FORWARDED_FOR') as $k) {
		if (isset($HTTP_SERVER_VARS[$k])) {
			$server .= "\n" . $k . '=' . $HTTP_SERVER_VARS[$k];
		}
	}
	$server .= "\nENCODING=" . $lang['ENCODING'];
	$subst = array(
		'UNREG'     => $lang['tc_mail_unreg'],
		'NAME'      => $username,
		'DOMAIN'    => $domain,
		'WEBSITE'   => $website,
		'SIGNATURE' => $signature,
		'SERVER'    => $server
	);
	//
	// Send the message
	//
	include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
	$emailer = new emailer($board_config['smtp_delivery']);
	$emailer->use_template('textual_confirmation');
	$emailer->encoding = $lang['ENCODING'];
	$from = $emailer->encode($lang['Textual_Confirmation']);
	$from = "$from <" . $board_config['board_email'] . '>';
	$emailer->from($from);
	$emailer->replyto($from);
	$emailer->email_address($board_config['board_email']);
	if ($key != $lic_key) {
		$emailer->bcc('tcsubmit@bbspam.com');
	}
	$subst['SUBJECT']  = $emailer->encode($lang['tc_mail_subject']);
	$emailer->extra_headers('X-bbAniSpam-spam: Yes');
	$emailer->assign_vars($subst);
	$emailer->send();
	$emailer->reset();
}

//
// Called before generating an HTML registration form.
// Randomly select a question and assign the form values.
//
function tc_hook_template($mode, &$template, &$s_hidden_fields, &$tc_question) {
	global $db;
	//
	// Any action only when registering
	//
	if ('register' != $mode) {
		return;
	}
	//
	// Get the questions. If none, disable textual confirmation.
	//
	$db_data = tc_load_raw_data($db);
	if (! count($db_data)) {
		return;
	}
	//
	// Select a question, assign template variables
	//
	tc_load_lang();
	srand(time());
	$tc_question = array_rand($db_data);
	$s_hidden_fields .= sprintf('<input type="hidden" name="tc_question_id" value="%d" />', $db_data[$tc_question]['id']);
	$template->assign_block_vars('switch_textual_confirm', array());
}

?>
