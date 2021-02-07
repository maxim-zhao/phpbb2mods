<?php
/***************************************************************************
 *                              admin_invites.php
 *                            -------------------
 *   begin                : Monday, Jul 25, 2005
 *   version              : 1.0.4 $Date: 2006/07/09 16:50:33 $; $Revision: 1.2 $
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
	$module['Invitations']['Invites_explore'] = "$file";
	return;
} 

// Let's set the root dir for phpBB

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');

require('./pagestart.' . $phpEx); 
require($phpbb_root_path . 'includes/functions_invite.' . $phpEx);
// possible modes: show invite_details, show user_details, show group details
$uid = $iid = $gid = 0;
if (isset($HTTP_POST_VARS[POST_USERS_URL]) || isset($HTTP_GET_VARS[POST_USERS_URL])) 
{
	$uid = (isset($HTTP_POST_VARS[POST_USERS_URL])) ? $HTTP_POST_VARS[POST_USERS_URL] : $HTTP_GET_VARS[POST_USERS_URL];
	$uid = intval($uid);
} 
else if (isset($HTTP_POST_VARS[POST_INVITES_URL]) || isset($HTTP_GET_VARS[POST_INVITES_URL])) 
{
	$iid = (isset($HTTP_POST_VARS[POST_INVITES_URL])) ? $HTTP_POST_VARS[POST_INVITES_URL] : $HTTP_GET_VARS[POST_INVITES_URL];
	$iid = intval($iid);
} 
else if (isset($HTTP_POST_VARS[POST_GROUPS_URL]) || isset($HTTP_GET_VARS[POST_GROUPS_URL]))
{
	$gid = (isset($HTTP_POST_VARS[POST_GROUPS_URL])) ? $HTTP_POST_VARS[POST_GROUPS_URL] : $HTTP_GET_VARS[POST_GROUPS_URL];
	$gid = intval($gid);
} 
else if (isset($HTTP_POST_VARS['username']) || isset($HTTP_GET_VARS['username'])) 
{
	$username = (isset($HTTP_POST_VARS['username'])) ? $HTTP_POST_VARS['username'] : $HTTP_GET_VARS['username'];
	$username = trim(strip_tags(htmlspecialchars($username)));
	$this_userdata = get_userdata($username, true);
	if (!$this_userdata) 
	{
		message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
	} 

	$uid = $this_userdata['user_id'] ;
} 
else if (isset($HTTP_POST_VARS['code']) || isset($HTTP_GET_VARS['code'])) 
{
	$code = (isset($HTTP_POST_VARS['code'])) ? $HTTP_POST_VARS['code'] : $HTTP_GET_VARS['code'];

	$invite = get_invitation($code); //get_invitation is able to deal with unclean vars
	if (!empty($invite)) 
	{
		$iid = $invite['invitation_id'];
		unset($invite);
	} 
	else 
	{
		message_die(GENERAL_MESSAGE, $lang['No_invite_id_specified']);
	} 
} 
else 
{ // this part is taken from the admin_user module. (not much left, though)
	$template->set_filenames(array('body' => 'admin/invites_select_body.tpl')); 
	// and this from admin_groups
	$sql = "SELECT group_id, group_name
		FROM " . GROUPS_TABLE . "
		WHERE group_single_user <> " . true . "
		ORDER BY group_name";
	if (!($result = $db->sql_query($sql))) 
	{
		message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
	} 

	$select_list = '';
	$select_list .= '<select name="' . POST_GROUPS_URL . '">';
	if ($row = $db->sql_fetchrow($result)) 
	{
		do 
		{
			$select_list .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
		} 	while ($row = $db->sql_fetchrow($result));
	} 
	$select_list .= '</select>';

	$template->assign_vars(array('L_INVITES_TITLE' => $lang['Look_up_invitation_data'],
			'L_INVITES_EXPLAIN' => $lang['Look_up_invitation_data_explain'],
			'L_USER_SELECT' => $lang['Select_a_User'],
			'L_LOOK_UP' => $lang['Look_up_user'],
			'L_FIND_USERNAME' => $lang['Find_username'],

			'U_SEARCH_USER' => append_sid("$phpbb_root_pathsearch.$phpEx?mode=searchuser",true),

			'S_USER_ACTION' => append_sid("admin_invites.$phpEx",true),
			'S_USER_SELECT' => $select_list,

			'L_GROUP_SELECT' => $lang['Select_group'],

			'L_LOOK_UP_GROUP' => $lang['Look_up_group'],

			'S_GROUP_ACTION' => append_sid("admin_invites.$phpEx",true),
			'S_GROUP_SELECT' => $select_list,
			'S_CODE_ACTION' => append_sid("admin_invites.$phpEx",true),
			'L_INVITE_CODE' => $lang['Invitation_code'],
			'L_FIND_CODE' => $lang['look_up_invite']

			)
		);

	$template->pparse('body');
} 

if (!empty($uid)) 
{ // todo: use proper constant
		// several Queries are used, but that shouldn't be a performance problem
		$sql = 'SELECT ut.username   AS name, 
			ut.user_id   AS id, 
			ut.user_invites   AS invites_left,
			iut.invitation_id   AS invite            
			FROM ' . USERS_TABLE . ' ut
			LEFT JOIN ' . INVITATION_USER_TABLE . ' iut
			ON ut.user_id = iut.user_id 
			WHERE  
		   (ut.user_id = '. $uid .' )';

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain user data', '', __LINE__, __FILE__, $sql);
	} 
	$user = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	if (empty($user)) 
	{
		message_die(GENERAL_ERROR, $lang['No_user_id_specified']);
	} 

	if (!empty($user['invite'])) 
	{
		$sql = 'SELECT it.invitation_sender   AS id, 
			it.invitation_id   AS invite, 
			ut.username   AS sender_name,
			ut.user_id   AS sender_id           
			FROM ' . INVITATION_TABLE . ' it
			LEFT JOIN ' . USERS_TABLE . ' ut
			ON ut.user_id = it.invitation_sender 
			WHERE  
			(it.invitation_id = ' . intval($user['invite']) . ')';
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain user data', '', __LINE__, __FILE__, $sql);
		} 
		$invite = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	} 

	$sql = 'SELECT gt.group_name   AS name, 
			gt.group_invites   AS invites, 
			gt.group_id   AS id                    
		FROM ' . GROUPS_TABLE . ' gt          
			WHERE  
		(gt.group_moderator = '.$uid .')';

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain group data', '', __LINE__, __FILE__, $sql);
	} 
	$groups = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);
	$invites = get_invites($uid, 0);
	$invited_members = get_invited_users($uid, 0 , 0);

	$table_names = array($lang['Username'], $lang['Invites_left'] , $lang['Invited_count'], $lang['Invites_sent']); 
	// This is pushing the envelope for acceptable HTML.
	$table_values = array($user['name'] . '&nbsp;&nbsp;<input type="hidden" name="mode" value="edit" /><input type="hidden" name="' . POST_USERS_URL . '" value="' . $uid . '"/><input type="submit" value="' . $lang['Look_up_user'] . '"/>',
		$user['invites_left'],
		count($invited_members),
		count($invites));

	if (!empty($invite)) 
	{
		$table_names[] = $lang['Invited_by'];
		$table_values[] = '<a href="' . append_sid('admin_invites.' . $phpEx . '?mode=explore&amp;' . POST_USERS_URL . '=' . $invite['sender_id'],true) . '">' . $invite['sender_name'] . '</a>';
		$table_names[] = $lang['Invited_with'];
		$table_values[] = '<a href="' . append_sid('admin_invites.' . $phpEx . '?mode=explore&amp;' . POST_INVITES_URL . '=' . $invite['invite'],true) . '">' . $invite['invite'] . '</a>';
	} 
	for ($i = 0; $i < count($groups); $i++) 
	{
		$table_names[] = $lang['Moderates_group'] . ': <a href="' . append_sid('admin_invites.' . $phpEx . '?mode=explore&amp;' . POST_GROUPS_URL . '=' . $groups[$i]['id'],true) . '">' . $groups[$i]['name'] . '</a>';
		$table_values[] = $groups[$i]['invites'] . ' ' . $lang['Invites_left'];
	} 
	// This part would be easier for the eyes (and possibly the template engine) if it would use template inserts (assign_var_from_handle) - next time.
	prepare_table2($table_names, $table_values, 'tab1', append_sid('admin_users.' . $phpEx,true), $lang['Explore_invite_user'], $lang['Explore_user_explain']) ;
	prepare_users_table($invited_members, 'tabuser', $lang['Explore_invited_users'], $lang['Explore_invited_users_explain_member']);
	prepare_invitation_table($invites, 'tab2', '', '', $lang['Explore_user_sent_invites'], $lang['Explore_user_sent_invites_explain']);
	$template->pparse('tab1');
	$template->pparse('tabuser');

	$template->pparse('tab2');
} 
if (!empty($iid)) 
{
	$sql = 'SELECT it.*,
		ut.user_id AS user_id,       
		ut.username AS username,    
		gt.group_id AS group_id,       
		gt.group_name AS group_name    
		FROM ' . INVITATION_TABLE . ' it
		LEFT JOIN ' . USERS_TABLE . ' ut
		ON  it.invitation_sender  = ut.user_id 
		LEFT JOIN ' . GROUPS_TABLE . ' gt
		ON  it.invitation_group  = gt.group_id 
		WHERE
		(it.invitation_id = '. $iid .')';

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain invite data', '', __LINE__, __FILE__, $sql);
	} 
	$invite = $db->sql_fetchrow($result);
	if (empty($invite)) 
	{
		message_die(GENERAL_ERROR, $lang['No_invite_id_specified']);
	} 

	$invited_members = get_invited_users(0, 0, $iid);

	$table_names = array($lang['Edit_invite'], $lang['Invitation_code'], $lang['Invitation_description'], $lang['Invitation_email_sent'], $lang['Invitation_uses'], $lang['Invitation_users'], $lang['Invitation_sender'], $lang['Invitation_group']);
	$table_values = array('<input type="hidden" name="mode" value="edit" /><input type="hidden" name="' . POST_INVITES_URL . '" value="' . $iid . '"/><input type="submit" value="' . $lang['Edit_invite'] . '"/>',
		$invite['invitation_code'],
		$invite['invitation_description'],
		$invite['invitation_email'],
		($invite['invitation_uses'] != -1) ? $invite['invitation_uses'] : $lang['Infinite'],
		count($invited_members),
		'<a href="' . append_sid('admin_invites.' . $phpEx . '?mode=explore&amp;' . POST_USERS_URL . '=' . $invite['user_id'],true) . '">' . $invite['username'] . '</a>',
		(empty($invite['group_id'])) ? $lang['None'] : '<a href="' . append_sid('admin_invites.' . $phpEx . '?mode=explore&amp;' . POST_GROUPS_URL . '=' . $invite['group_id'],true) . '">' . $invite['group_name'] . '</a>',
		);

	prepare_table2($table_names, $table_values, 'tab_data', append_sid('admin_invites_edit.' . $phpEx,true), $lang['Explore_invite_invite'], $lang['Explore_invite_invite_explain']) ;
	prepare_users_table($invited_members, 'tabusers', $lang['Explore_invited_users'], $lang['Explore_invited_users_explain_invite']);
	$template->pparse('tab_data');
	$template->pparse('tabusers');
} 
if (!empty($gid)) 
{
	$sql = 'SELECT gt.group_name   AS name, 
			gt.group_id   AS id, 
			gt.group_moderator  AS moderator, 
			gt.group_invites  AS invites,
			ut.username AS mod_name
			FROM ' . GROUPS_TABLE . ' gt, 
				 ' . USERS_TABLE . ' ut
			WHERE  
			(gt.group_moderator =  ut.user_id) AND
			(gt.group_id = ' . $gid . ')
			AND (gt.group_single_user = 0)';

	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain group data', '', __LINE__, __FILE__, $sql);
	} 
	$group = $db->sql_fetchrow($result);
	if (empty($group)) 
	{
		message_die(GENERAL_ERROR, $lang['No_group_id_specified']);
	} 
	$invites = get_invites(0, $gid, 0);
	$invited_members = get_invited_users(0, $gid, 0);
	$table_names = array($lang['Group_name'], $lang['group_moderator'], $lang['Invites_left'], $lang['Invites_sent'], $lang['Invited_count']); 
	// OK, this is neither pretty, nor good. But the only alternatives would be javascript or an additional code change.   I might move it to a new template.
	$table_values = array($group['name'] . '&nbsp;&nbsp;<input type="hidden" name="edit"/><input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group['id'] . '"/><input type="submit" value="' . $lang['Edit_group'] . '"/>',
		'<a href="' . append_sid('admin_invites.' . $phpEx . '?mode=explore&amp;' . POST_USERS_URL . '=' . $group['moderator'],true) . '">' . $group['mod_name'] . '</a>',
		$group['invites'],
		count($invites),
		count($invited_members)
		);
	prepare_table2($table_names, $table_values, 'tab_data', append_sid('admin_groups.' . $phpEx,true), $lang['Explore_invite_group'], $lang['Explore_invite_group_explain']) ;

	prepare_users_table($invited_members, 'tabusers', $lang['Explore_invited_group_user'], $lang['Explore_invited_group_explain']);
	prepare_invitation_table($invites, 'tabinvs', '', '', $lang['Explore_group_sent_invites'], $lang['Explore_group_sent_invites_explain']);
	$template->pparse('tab_data');
	$template->pparse('tabusers');
	$template->pparse('tabinvs');
} 

include($phpbb_root_path . 'admin/page_footer_admin.' . $phpEx);

?>