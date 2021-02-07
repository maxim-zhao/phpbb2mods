<?php
/***************************************************************************
 *                              invite.php
 *                            -------------------
 *   begin            : Saturday, July 17th, 2005
 *   version          : 1.0.4 $Date: 2006/07/09 17:57:15 $; $Revision: 1.3 $
 *   copyright        : (C) 2005, Kellanved; based on admin_invites by Kellanved
 *    
 *
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


define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_invite.' . $phpEx);;
// Start session management
if ($board_config['invite_u2u'] == 2)
{
	$userdata = session_pagestart($user_ip, PAGE_INVITE);  
}
else
{
	$userdata = session_pagestart($user_ip, PAGE_INDEX);  
}
init_userprefs($userdata);
// End session management
 
// We don't want no guests
if (!$userdata['session_logged_in']) 
{
	redirect(append_sid("login.$phpEx?redirect=invite.$phpEx", true));
} 

if (!$board_config['invite_u2u']) 
{
	$msg = '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx",true) . '">', '</a>');

	message_die(GENERAL_ERROR, $lang['Function_disabled_by_admin'] . $msg);
} 

/*Basically there are five  cases
a) Someone without Invites -> Hasta la Vista
b) Someone who is not a Group-Moderator, but who has invites -> show the normal Invite page
c) Someone who is a Group Moderator -> Show a page where (s)he can choose his function.
d) Someone who is a Group Moderator but already saw the selection page -> show the normal Invite page
e) submit
*/
$mode = '';
$invite_group = 0;
$inviting_group = 0;

if (isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode'])) {
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars(trim($mode));
} 
// If the Group Parameter is set, then make sure that the user was allowed to set it.
if (isset($HTTP_GET_VARS[POST_GROUPS_URL]) || isset($HTTP_POST_VARS[POST_GROUPS_URL])) {
	$invite_group_id = ($HTTP_GET_VARS[POST_GROUPS_URL]) ? $HTTP_GET_VARS[POST_GROUPS_URL] : $HTTP_POST_VARS[POST_GROUPS_URL];
	$invite_group_id = intval($invite_group_id);
	if (!empty($invite_group_id)) {
        // we are gullible, but not THAT gullible.
		$sql = 'SELECT * FROM ' . GROUPS_TABLE . '
			WHERE (group_single_user = 0)
			AND (group_moderator = ' . $userdata['user_id'] . ')
			AND (group_id = ' . $invite_group_id . ')
			AND (group_invites <> 0)';
		if (!($result = $db->sql_query($sql))) 
		{
			message_die(GENERAL_ERROR, 'Could not obtain group data', '', __LINE__, __FILE__, $sql);
		} 
		$invite_group = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if (empty($invite_group))
		{
			message_die(GENERAL_ERROR, $lang['Group_invalid']);
		} 
	} 
} 
// Find out if there any groups in which the User would be allowed to do anything. This looks like the thing above, yet it has to be done.
$group_count = 0;

$sql = 'SELECT * FROM ' . GROUPS_TABLE . '
	WHERE (group_single_user = 0)
	AND (group_moderator = ' . $userdata['user_id'] . ')
	AND (group_invites <> 0)
	ORDER BY group_name';
if (!($result = $db->sql_query($sql))) {
	message_die(GENERAL_ERROR, 'Could not obtain group data', '', __LINE__, __FILE__, $sql);
} 

$groups = $db->sql_fetchrowset($result);
$group_count = count($groups);
$db->sql_freeresult($result);

if (($userdata['user_invites'] == 0) && ($group_count == 0)) 
{ // hasta la vista
	$msg = '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx",true) . '">', '</a>');

	message_die(GENERAL_MESSAGE, $lang['No_invites_left'] . $msg);
} 
// initial state. Find out which page to show next
if (empty($mode)) 
{
	// (s)he has no option -> show the e-mail dialog
	if ($userdata['user_invites'] > 0 && $group_count == 0) 
	{
		$page_title = $lang['Send_invite'];
		include($phpbb_root_path . 'includes/page_header.' . $phpEx);
		show_invite_page();
	} 
	else if ($group_count > 0) 
	{ // we'll have to ask the user on what to do next
		$page_title = $lang['Send_invite'];
		include($phpbb_root_path . 'includes/page_header.' . $phpEx);
		show_role_selection($groups);
	} 
} 
else if ($mode === 'group') 
{ // ok, we want to write an invite on behalf of a group
	if (!empty($invite_group)) 
	{
		$page_title = $lang['Send_invite'];
		include($phpbb_root_path . 'includes/page_header.' . $phpEx);
		show_invite_page($invite_group['group_id']);
	} 
	else
	{// strictly this does mean that the user tried to play around with designed URLs. Let him.
		if (empty($userdata['user_invites'])) 
		{
			message_die(GENERAL_MESSAGE, $lang['No_invites_left']);
		} 
		else 
		{
			$page_title = $lang['Send_invite'];
			include($phpbb_root_path . 'includes/page_header.' . $phpEx);
			show_invite_page();
		} 
	} 
} 
else if ($mode === 'save') 
{
	include($phpbb_root_path . 'includes/functions_validate.' . $phpEx);
	$error = false;
	$error_msg = '';
	if (isset($HTTP_POST_VARS['email_to'])) 
	{
		$email_to = $HTTP_POST_VARS['email_to'];
		$email_to = trim(htmlspecialchars($email_to));
		$email_validation = validate_email($email_to);
		if ($email_validation['error']) {
			$error_msg .= $email_validation['error_msg'] . '<br />';
			$error = true;
		} 
	} 
	if (isset($HTTP_POST_VARS['email_subject'])) 
	{
		$email_subject = trim(stripslashes($HTTP_POST_VARS['email_subject']));
	} 
	if (isset($HTTP_POST_VARS['message'])) 
	{
		$message = trim(stripslashes($HTTP_POST_VARS['message'])); //Warning: this variable is not sanitized
	} 

	if (empty($message)) 
	{
		$error_msg .= $lang['Have_to_enter_a_message'] . '<br />';
		$error = true;
	} 
	if (empty($email_subject)) 
	{
		$error_msg .= $lang['Have_to_enter_a_subject'] . '<br />';
		$error = true;
	} 
	if (empty($email_to)) 
	{
		$error_msg .= $lang['Have_to_enter_a_address'] . '<br />';
		$error = true;
	} 
	if (!$error) 
	{
		if (!empty($invite_group['group_id'])) 
		{
			$auto_activate = $HTTP_POST_VARS['auto_activate'];
			$auto_activate = intval($auto_activate);
			$description = $lang['Group_moderator_invite'] . ' ' . create_date($board_config['default_dateformat'], time(), $board_config['board_timezone']);
			$invitation_code = insert_invite($email_to,  addslashes($description), $invite_group['group_id'], $auto_activate);
			send_invite_mail($email_to, $invitation_code, $email_subject, $message);
		} 
		else 
		{
			if (empty($userdata['user_invites'])) 
			{
				message_die(GENERAL_ERROR, $lang['no_invites_left']);
			} 
			$description = $lang['Single_user_invite'] . ' ' . create_date($board_config['default_dateformat'], time(), $board_config['board_timezone']) ;
			$invitation_code = insert_invite($email_to, addslashes($description));
			send_invite_mail($email_to, $invitation_code, $email_subject, $message);
		} 
		$msg = '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx",true) . '">', '</a>');

		message_die(GENERAL_MESSAGE, $lang['Invite_sent'] . $msg);
	} 
	else 
	{
		$page_title = $lang['Send_invite'];
		include($phpbb_root_path . 'includes/page_header.' . $phpEx);
		show_invite_page($invite_group['group_id'], true, $error_msg, $email_subject, $message, $email_to);
	} 
} 

/*A simple function to show a "Role" Selection Dialog.*/
function show_role_selection($groups)
{
	global $userdata, $template, $phpEx, $lang; 
	// make the options for the selection Box:
	$box_html = '';

	$box_html .= (!empty($userdata['user_invites'])) ? '<option value="0"\>' . $lang['Private'] . ' [' . $userdata['user_invites'] . ' ' . $lang['Invites_left'] . ']</option>' : '' ;

	foreach ($groups as $group) 
	{
		$box_html .= '<option value="' . $group['group_id'] . '">' . $lang['Moderator'] . ': ' . $group['group_name'] . ' [' . $group['group_invites'] . ' ' . $lang['Invites_left'] . ']</option>';
	} 
	$template->set_filenames(array('body' => 'select_invite_role.tpl'));

	$template->assign_vars(array('L_ROLE' => $lang['Invite_role'],
			'L_ROLE_EXPLAIN' => $lang['Invite_role_explain'],
			'L_SUBMIT' => $lang['Submit'],
			'S_ROLES' => $box_html,
			'S_GROUP' => POST_GROUPS_URL,
			'S_ACTION' => append_sid("invite.$phpEx?mode=group",true),
			));
	$template->pparse('body');
} 

/*This will show a page to actually send the invite. if the group argument is set, then the invite will be on behalf of that group.*/
function show_invite_page($group = 0, $error = 0, $error_msg = '', $subject = '', $message = '', $email_to = '')
{
	global $userdata, $lang, $board_config, $template, $phpEx;

	$s_hidden_fields = '';
	$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';

	if (!empty($group)) 
	{
		$s_hidden_fields .= '<input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group . '" />';
		$template->assign_block_vars('switch_group_invite', array());
	} else {
		$s_hidden_fields .= '<input type="hidden" name="join_group" value="0" />';
	} 
	$template->set_filenames(array('body' => 'user_invite_add_body.tpl'));
	if ($error) 
	{
		$template->set_filenames(array('reg_header' => 'error_body.tpl'));
		$template->assign_vars(array('ERROR_MESSAGE' => $error_msg));
		$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
	} 
	$template->assign_vars(array('L_INVITES_TITLE' => $lang['Invite_a_friend'],
			'L_INVITES_TEXT' => $lang['Add_new_invite_text'],

		 	'L_SUBMIT' => $lang['Submit'],
			'L_RESET' => $lang['Reset'],

			'L_SUBJECT' => $lang['Subject'],
			'L_RECIPIENT' => $lang['Recipient'],
			'SUBJECT' => ($error)? $subject : '', // no default for users - we don't want to help them Spamming
			'MESSAGE' => ($error)? $message : '',
			'MAIL' => ($error)? $email_to : '',
			'L_EMAIL_MSG' => $lang['Message'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'L_AUTO_ACTIVATE_GROUP' => $lang['Auto_activate_group'],
			'S_INVITE_ACTION' => append_sid("./invite.$phpEx",true),
			'RECIPIENT' => ($error)? $email_to :'', 
			// 'S_GROUP_SELECT_BOX' => $group_select_box,
			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);
	$template->pparse('body');
} 

include($phpbb_root_path . 'includes/page_tail.' . $phpEx);

?>