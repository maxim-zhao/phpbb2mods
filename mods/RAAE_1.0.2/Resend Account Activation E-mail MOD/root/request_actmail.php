<?php
/***************************************************************************
 *								request_actmail.php
 *                            -------------------
 *   begin                : Saturday, Jun 24, 2006
 *   copyright            : ycl6
 *   email                : ycl6@users.sourceforge.net (http://macphpbbmod.sourceforge.net/)
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

/* Activation Email Interval */
$send_activation_interval = 3600;	// 3600 seconds

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Set page ID for session management
//
$userdata = session_pagestart($user_ip, PAGE_LOGIN);
init_userprefs($userdata);
//
// End session management
//

if (intval($board_config['require_activation']) == USER_ACTIVATION_ADMIN && $userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_ERROR, 'Invalid_activation');
}

if( isset($HTTP_POST_VARS['sendmail']) || isset($HTTP_GET_VARS['sendmail']) )
{
		$username = isset($HTTP_POST_VARS['username']) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';
		$email = trim(htmlspecialchars($HTTP_POST_VARS['email']));

		$sql = "SELECT *
			FROM " . USERS_TABLE . "
			WHERE username = '" . $username . "'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		}

		if ( !($row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_ERROR, 'Invalid_uaername');		// No such name
		}

		if ( $row['user_email'] != $email )
		{
			message_die(GENERAL_ERROR, 'Invalid_email');		// Wrong Email provided
		}

		if ( !empty($row['user_active']) )
		{
			message_die(GENERAL_ERROR, 'Already_activated');	// Already activated
		}

		if ( empty($row['user_actkey']) )
		{
			message_die(GENERAL_ERROR, 'No_actkey');			// No activation key
		}

		$current_time = time();

		if (intval($row['user_actmail_last_checked']) > 0 && ($current_time - intval($row['user_actmail_last_checked'])) < $send_activation_interval)
		{
			message_die(GENERAL_ERROR, 'Send_actmail_flood_error');		// Request flood
		}

		// Start the email process
		$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
		$unhtml_specialchars_replace = array('>', '<', '"', '&');

		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
		$script_name = ( $script_name != '' ) ? $script_name . '/profile.'.$phpEx : 'profile.'.$phpEx;
		$server_name = trim($board_config['server_name']);
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
 
		$server_url = $server_protocol . $server_name . $server_port . $script_name;

		$ip = decode_ip($user_ip);
		$hostname = gethostbyaddr($ip);

		include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);

		$emailer = new emailer($board_config['smtp_delivery']);
		$emailer->from($board_config['board_email']);
		$emailer->replyto($board_config['board_email']);
					
		$emailer->email_address(trim($row['user_email']));
		$emailer->use_template("resend_activation_email", $row['user_lang']);
		$emailer->set_subject($lang['Resend_activation_email']);

		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'],
			'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
			'IP' => $ip . ' (' . $hostname . ')',
			'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

			'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $row['user_id'] . '&act_key=' . $row['user_actkey'])
		);
		$emailer->send();
		$emailer->reset();

		// Update last activation sent time
		$sql = "UPDATE " . USERS_TABLE . " 
			SET user_actmail_last_checked = $current_time
			WHERE username = '" . $username . "'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update userdata', '', __LINE__, __FILE__, $sql);
		}

		message_die(GENERAL_MESSAGE, 'Resend_activation_email_done');
}
else
{
	$page_title = $lang['Resend_activation_email'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'request_actmail.tpl')
	);

	$template->assign_vars(array(
		'L_RESEND_ACTIVATION_EMAIL' => $lang['Resend_activation_email'],
		'L_USERNAME' => $lang['Username'],
		'L_EMAIL' => $lang['Email'],
		'L_SUBMIT' => $lang['Submit'],

		'S_RESEND_ACTIVATION_ACTION' => append_sid('request_actmail.'.$phpEx))
	);

	$template->pparse('body');
	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

?>