<?php
/***************************************************************************
 *                              admin_invites_config.php
 *                            -------------------
 *   begin                : Monday, Jul 25, 2005
 *   version              : 1.0.4 $Date: 2006/07/09 16:46:07 $; $Revision: 1.1 $
 *   copyright            : (C) 2005 Kellanved 
 *   email                : kellanved@gmail.com
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
 
define('IN_PHPBB', 1);

if (!empty($setmodules)) 
{
	$file = basename(__FILE__);
	$module['Invitations']['Invitations_Config'] = "$file";
	return;
} 

// Let's set the root dir for phpBB

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_invite.' . $phpEx);
$int_keys = array('action',  'rules', 'amount', 'who', 'who1', 'set_mode', 'set_u2u', 'set_accept_pm', 'set_confirm_pm','set_confirm_mail');
foreach ($int_keys as $var) 
{
   $$var = 0;
   if (isset($HTTP_POST_VARS[$var]) || isset($HTTP_GET_VARS[$var]))
	{
		$$var = abs((isset($HTTP_GET_VARS[$var])) ? intval($HTTP_GET_VARS[$var]) : intval($HTTP_POST_VARS[$var]));
	}
}

if (isset($HTTP_POST_VARS['set_mode']) || isset($HTTP_GET_VARS['set_mode']))
{
	$set_mode = abs((isset($HTTP_GET_VARS['set_mode'])) ? intval($HTTP_GET_VARS['set_mode']) : intval($HTTP_POST_VARS['set_mode']));
}

$mode = $action = $rules = 0;
if (isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode'])) 
{
	$mode = htmlspecialchars(trim(stripslashes((isset($HTTP_GET_VARS['mode'])) ? ($HTTP_GET_VARS['mode']) : ($HTTP_POST_VARS['mode']))));
} 
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action'])) 
{
	$action = htmlspecialchars(trim(stripslashes((isset($HTTP_GET_VARS['action'])) ? ($HTTP_GET_VARS['action']) : ($HTTP_POST_VARS['action']))));
} 
if (isset($HTTP_POST_VARS['rules']) || isset($HTTP_GET_VARS['rules'])) 
{
	$rules = substr(trim((isset($HTTP_GET_VARS['rules'])) ? ($HTTP_GET_VARS['rules']) : ($HTTP_POST_VARS['rules'])), 0, 255);
} 
 
if ($mode === 'config')  //TODO: Do this in a loop
{
	$sql = 'UPDATE ' . CONFIG_TABLE . "  
		SET config_value  =  $set_mode  
		WHERE (config_name = 'invitation_only')";

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update board configuration', '', __LINE__, __FILE__, $sql);
	} 
	$sql = 'UPDATE ' . CONFIG_TABLE . "  
		SET config_value  =   $set_u2u  
		WHERE (config_name =  'invite_u2u')";

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update board configuration', '', __LINE__, __FILE__, $sql);
	} 
	$sql = 'UPDATE ' . CONFIG_TABLE . " 
		SET config_value  = '" . str_replace("\'", "''", $rules) . "'
		WHERE (config_name =  'additional_rules ')";

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update board configuration', '', __LINE__, __FILE__, $sql);
	} 	 
	$sql = 'UPDATE ' . CONFIG_TABLE . " 
		SET config_value  =  $set_accept_pm  
		WHERE (config_name = 'send_invit_accept_pm')";

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update board configuration', '', __LINE__, __FILE__, $sql);
	} 
	$sql = 'UPDATE ' . CONFIG_TABLE . "  
		SET config_value  =   $set_confirm_mail  
		WHERE (config_name =  'send_invit_confirm_mail')";

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update board configuration', '', __LINE__, __FILE__, $sql);
	} 
	$sql = 'UPDATE ' . CONFIG_TABLE . "  
		SET config_value  =   $set_confirm_pm  
		WHERE (config_name =  'send_invit_confirm_pm')";

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update board configuration', '', __LINE__, __FILE__, $sql);
	}  
	$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_invite_config'], "<a href=\"" . append_sid("admin_invites_config.$phpEx",true) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
} 
elseif ($mode === 'all_users') 
{
	if ($action == 'add') 
	{
		$sql = 'UPDATE ' . USERS_TABLE . '  
		SET user_invites  = user_invites + ' . $amount  ;
	} 
	else 
	{
		$sql = 'UPDATE ' . USERS_TABLE . '  
		SET user_invites  = ' . $amount ;
	} 
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update user data', '', __LINE__, __FILE__, $sql);
	} 
	$message = $lang['Invites_updated'] . "<br /><br />" . sprintf($lang['Click_return_invite_config'], "<a href=\"" . append_sid("admin_invites_config.$phpEx",true) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
} 
elseif ($mode === 'all_groups') 
{
	if ($action == 'add') 
	{
		$sql = 'UPDATE ' . GROUPS_TABLE . '  
		SET group_invites =   group_invites +  ' . $amount .'
		WHERE (group_single_user = 0)';
	} 
	else 
	{
		$sql = 'UPDATE ' . GROUPS_TABLE . '  
		SET group_invites  = ' . $amount . '
		WHERE (group_single_user = 0)';
	} 
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update group data', '', __LINE__, __FILE__, $sql);
	} 
	$message = $lang['Invites_updated'] . "<br /><br />" . sprintf($lang['Click_return_invite_config'], "<a href=\"" . append_sid("admin_invites_config.$phpEx",true) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
} 
// give all groups
// give groupmembers
// this monster is taken from admin_groups; I'd have used a simple multi-table update, but that's mysql 4 only.
elseif ($mode === 'group_members') 
{
	$sql = "SELECT user_id FROM " . USER_GROUP_TABLE . "
		WHERE (group_id =  $who)";
	if (!($result = $db->sql_query($sql))) 
	{
		message_die(GENERAL_ERROR, 'Could not select user_group', '', __LINE__, __FILE__, $sql);
	} 

	$rows = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);
	if ($action === 'add') 
	{
		$update_sql = 'UPDATE ' . USERS_TABLE . '  
			SET user_invites  = user_invites + ' . $amount . '
			WHERE (user_id = ' ;
	} 
	else 
	{
		$update_sql = 'UPDATE ' . USERS_TABLE . '  
			SET user_invites  = ' . $amount . '
			WHERE (user_id = ' ;
	} 
	for ($i = 0; $i < count($rows); $i++) 
	{
		$update_sql_assembled = $update_sql . intval($rows[$i]['user_id']) . ')';

		if (!$db->sql_query($update_sql_assembled)) 
		{
			message_die(GENERAL_ERROR, 'Could not update users', '', __LINE__, __FILE__, $update_sql);
		} 
	} 
	$message = $lang['Invites_updated'] . "<br /><br />" . sprintf($lang['Click_return_invite_config'], "<a href=\"" . append_sid("admin_invites_config.$phpEx",true) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
} 
elseif ($mode === 'give_rank') 
{
	$sql = "SELECT * FROM " . RANKS_TABLE . "
		WHERE (rank_id =   $who )";
	if (!($result = $db->sql_query($sql))) 
	{
		message_die(GENERAL_ERROR, 'Could not select user_group', '', __LINE__, __FILE__, $sql);
	} 

	$rank = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	if ($rank['rank_special']) 
	{
		if ($action == 'add') 
		{
			$sql = 'UPDATE ' . USERS_TABLE . '  
				SET user_invites  = user_invites + ' . $amount . '
				WHERE (user_rank = ' . $who . ')';
		} 
		else 
		{
			$sql = 'UPDATE ' . USERS_TABLE . '  
				SET user_invites  = ' . $amount . '
				WHERE (user_rank = ' . $who . ')';
		} 
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Couldn\'t update user data', '', __LINE__, __FILE__, $sql);
		} 
	} 
	else 
	{ // eeek
			$sql = "SELECT MIN( rank_min ) as next_rank FROM " . RANKS_TABLE . "
				WHERE (rank_min > " . $rank['rank_min'] . ')';
		if (!($result = $db->sql_query($sql))) {
			message_die(GENERAL_ERROR, 'Could not select rank', '', __LINE__, __FILE__, $sql);
		} 
		$max_posts = $db->sql_fetchrow($result);
		$max_sql = (empty($max_posts['next_rank'])) ? '' : 'AND (user_posts < ' . $max_posts['next_rank'] . ')';
		$db->sql_freeresult($result);
		if ($action == 'add') 
		{
			$sql = 'UPDATE ' . USERS_TABLE . '  
				SET user_invites  = user_invites + ' . $amount . '
				WHERE (user_posts >= ' . $rank['rank_min'] . ')' . $max_sql;
		} 
		else 
		{
			$sql = 'UPDATE ' . USERS_TABLE . '  
				SET user_invites  = ' . $amount . '
				WHERE (user_posts >= ' . $rank['rank_min'] . ')' . $max_sql;
		} 
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Couldn\'t update user data', '', __LINE__, __FILE__, $sql);
		} 
	} 
	$message = $lang['Invites_updated'] . "<br /><br />" . sprintf($lang['Click_return_invite_config'], "<a href=\"" . append_sid("admin_invites_config.$phpEx",true) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
} 
elseif ($mode === 'joined_between') 
{
	$date1 = (empty($who)) ? 0 : time() - $who * 86400;
	$date2 = time() - $who1 * 86400;
	if ($action == 'add') {
		$sql = 'UPDATE ' . USERS_TABLE . '  
			SET user_invites  = user_invites + ' . $amount . '
			WHERE (user_regdate > ' . $date1 . ')
			AND (user_regdate < ' . $date2 . ')';
	} 
	else 
	{
		$sql = 'UPDATE ' . USERS_TABLE . '  
			SET user_invites  = ' . $amount . '
			WHERE (user_regdate > ' . $date1 . ')
			AND (user_regdate < ' . $date2 . ')';
	} 
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t update user data', '', __LINE__, __FILE__, $sql);
	} 
	$message = $lang['Invites_updated'] . "<br /><br />" . sprintf($lang['Click_return_invite_config'], "<a href=\"" . append_sid("admin_invites_config.$phpEx",true) . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
} 
else 
{
	$sql = "SELECT group_id, group_name FROM " . GROUPS_TABLE . "
		WHERE (group_single_user = 0)";
	if (!($result = $db->sql_query($sql))) 
	{
		message_die(GENERAL_ERROR, 'Could not select groups', '', __LINE__, __FILE__, $sql);
	} 
	$groups = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);
	$group_box = '<select name="who">';

	$group_box .= '<option value="0">' . $lang['Select'] . '</option>';
	if (count($groups)) 
	{
		foreach ($groups as $group) 
		{
			$group_box .= '<option value="' . $group['group_id'] . '">' . $group['group_name'] . '</option>';
		} 
	} 
	$group_box .= '</select>';
	$template->set_filenames(array("body" => "admin/invites_config_body.tpl"));

	$sql = "SELECT rank_id, rank_title  FROM " . RANKS_TABLE . "
		ORDER BY rank_special DESC ";
	if (!($result = $db->sql_query($sql))) 
	{
		message_die(GENERAL_ERROR, 'Could not select groups', '', __LINE__, __FILE__, $sql);
	} 
	$ranks = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);
	$rank_box = '<select name="who">';

	foreach ($ranks as $rank) 
	{
		$rank_box .= '<option value="' . $rank['rank_id'] . '">' . $rank['rank_title'] . '</option>';
	} 
	$rank_box .= '</select>';
	$template->set_filenames(array("body" => "admin/invites_config_body.tpl"));
	$template->assign_vars(array('L_INVITE_CONFIG_TITLE' => $lang['Invitations_config'],
			'L_INVITE_CONFIG_EXPLAIN' => $lang['Invite_config_explain'],
			'L_INVITE_CONFIG' => $lang['Invite_general_settings'],
			'L_INVITATION_SETTING' => $lang['Invitation_mode_setting'],
			'L_INVITATION_SETTING_EXPLAIN' => $lang['Invitation_mode_setting_explain'],
			'L_INVITATION_U2U_SETTING' => $lang['Invitation_u2u_setting'],
			'L_INVITATION_U2U_SETTING_EXPLAIN' => $lang['Invitation_u2u_setting_explain'],
			'L_INVITATION_CONFIRM_PM' => $lang['Invitation_confirm_pm_setting'],
			'L_INVITATION_CONFIRM_PM_EXPLAIN' => $lang['Invitation_confirm_pm_setting_explain'],
			'L_INVITATION_CONFIRM_MAIL' => $lang['Invitation_confirm_mail_setting'],
			'L_INVITATION_CONFIRM_MAIL_EXPLAIN' => $lang['Invitation_confirm_mail_setting_explain'],
			'L_INVITATION_ACCEPT_PM' => $lang['Invitation_ac_pm_setting'],
			'L_INVITATION_ACCEPT_PM_EXPLAIN' => $lang['Invitation_ac_pm_setting_explain'],
			'L_DISABLED' => $lang['Disable'],
			'L_OPTIONAL' => $lang['Optional'],
			'L_INVITATION_ONLY' => $lang['Invitation_only'],

			 

			'L_U2U_HIDE' => $lang['Invite_u2u_hide'],
			'L_ADDITIONAL_RULES' => $lang['Invitation_additional_rules'],
			'L_ADDITIONAL_RULES_EXPLAIN' => $lang['Invitation_additional_rules_explain'],

			'L_GIVE_ALL_GROUPS' => $lang['Give_invites_all_grops'],
			'L_GIVE_ALL_GROUPS_EXPLAIN' => $lang['Give_invites_all_groups_explain'],
			'L_GIVE_GROUPMEMBERS' => $lang['Give_invites_groupmembers'],
			'L_GIVE_GROUPMEMBERS_EXPLAIN' => $lang['Give_invites_groupmembers_explain'],
			'L_GIVE_INVITES_RANK' => $lang['Give_invites_rank'],
			'L_GIVE_RANK_EXPLAIN' => $lang['Give_invites_rank_explain'],
			'L_SUBMIT' => $lang['Submit'],
			'L_GIVE_INVITES_TITLE' => $lang['Give_invites_title'],
			'L_GIVE_INVITES_EXPLAIN' => $lang['Give_invites_title_explain'],
			'L_GIVE_TIME' => $lang['Give_invites_time'],
			'L_GIVE_TIME_EXPLAIN' => $lang['Give_invites_time_explain'],
			'L_GIVE_ALL' => $lang['Give_invites_all'],
			'L_GIVE_ALL_EXPLAIN' => $lang['Give_invites_all_explain'],
			'L_GIVE_INVITES_ADD' => $lang['Add_invites'],
			'L_ADD' => $lang['Add_invites'],
			'L_SET' => $lang['Set_invites'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'L_MODE' => $lang['Add_set'],
			'L_AMOUNT' => $lang['Amount'],
			'L_RANK' => $lang['Rank'],
			'L_SELECT_GROUP' => $lang['Group'],
			'L_LONGER_THAN_DAYS' => $lang['Member_longer_than'],
			'L_SHORTER_THAN_DAYS' => $lang['Member_shorter_than'],

			'INVITES_DISABLED' => (!$board_config['invitation_only']) ? 'checked="checked"': '',
			'INVITES_OPTIONAL' => ($board_config['invitation_only'] == 1) ? 'checked="checked"': '',
			'INVITATION_ONLY' => ($board_config['invitation_only'] == 2) ? 'checked="checked"': '',
			'CONFIRM_PM_DISABLED' => (!$board_config['send_invit_confirm_pm']) ? 'checked="checked"': '',
			'CONFIRM_PM_ENABLED' => ($board_config['send_invit_confirm_pm'] == 1) ? 'checked="checked"': '',
			'CONFIRM_MAIL_DISABLED' => (!$board_config['send_invit_confirm_mail']) ? 'checked="checked"': '',
			'CONFIRM_MAIL_ENABLED' => ($board_config['send_invit_confirm_mail'] == 1) ? 'checked="checked"': '',
			'REG_PM_DISABLED' => (!$board_config['send_invit_accept_pm']) ? 'checked="checked"': '',
			'REG_PM_ENABLED' => ($board_config['send_invit_accept_pm'] == 1) ? 'checked="checked"': '',
			
			
			'U2U_YES' => ($board_config['invite_u2u'] == 2) ? 'checked="checked"' :'',
			'U2U_NO' => ($board_config['invite_u2u'] == 0) ? 'checked="checked"' :'',
			'U2U_HIDE' => ($board_config['invite_u2u'] == 1) ? 'checked="checked"' :'',
			'RULES' => ($board_config['additional_rules']),
			'S_GROUP_BOX' => $group_box,
			'S_RANK_BOX' => $rank_box,
			'S_CONFIG_ACTION' => append_sid("admin_invites_config.$phpEx",true),
			'S_GIVE_INVITES_ACTION' => append_sid("admin_invites_config.$phpEx",true)
			));
	$template->pparse('body');
	include($phpbb_root_path . 'admin/page_footer_admin.' . $phpEx);
} 
// give posters who joined in a certain time period
// send invite
// todo: check for valid vars

?>