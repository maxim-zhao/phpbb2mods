<?php
/***************************************************************************
 *                                banlist.php
 *                            -------------------
 *   begin                : Friday, Jan 16, 2004
 *   copyright            : © 2004 VCU
 *   
 *   $Id: banlist.php,v 1.0.0 2004/01/16 14:37:40 VCU Exp $
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
//
// End session management
//

if ( $userdata['user_level'] != ADMIN )
{
	redirect(append_sid("login.$phpEx?redirect=banlist.$phpEx", true));
}

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

// Generate Page
//
$page_title = $lang['Banlist'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'banlist_body.tpl')
);

// The goods
//
	$order_by = "b.ban_id DESC LIMIT $start, " . $board_config['topics_per_page'];
	$sql = "SELECT b.ban_id, b.ban_reason, u.user_id, u.username
		FROM " . BANLIST_TABLE . " b, " . USERS_TABLE . " u
		WHERE u.user_id = b.ban_userid
			AND b.ban_userid <> 0		
		ORDER BY $order_by";
		
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select current user_id ban list', '', __LINE__, __FILE__, $sql);
	}
	
	$user_list = $db->sql_fetchrowset($result);

	if( count($user_list) == 0 )
	{
		message_die(GENERAL_ERROR, $lang['No_bans_exist'], '', '', '');
	}

	for($i = 0; $i < count($user_list); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		
		$template->assign_block_vars('banrow',array(
		'ROW_CLASS' => $row_class, 
		'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $user_list[$i]['user_id']),
		'USERNAME' => $user_list[$i]['username'], 
		'BAN_REASON' => $user_list[$i]['ban_reason'])
		);
	}	

//
// Pagination
//
if ( $mode != 'topten' || $board_config['topics_per_page'] < 10 )
{
	$sql = "SELECT count(*) AS total
		FROM " . BANLIST_TABLE . "
		WHERE ban_userid <> 0";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_members = $total['total'];

		$pagination = generate_pagination("banlist.$phpEx?mode=$mode&amp;order=$sort_order", $total_members, $board_config['topics_per_page'], $start). '&nbsp;';
	}
}
else
{
	$pagination = '&nbsp;';
	$total_members = 10;
}

$template->assign_vars(array(
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_members / $board_config['topics_per_page'] )), 

	'L_GOTO_PAGE' => $lang['Goto_page'],
	'L_BAN_INTRO' => $lang['Ban_into'],
	'L_BAN_REASON' => $lang['Ban_reason'])	
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
