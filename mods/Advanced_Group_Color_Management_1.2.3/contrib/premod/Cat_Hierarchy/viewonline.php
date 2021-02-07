<?php
//-- mod : categories hierarchy ------------------------------------------------
/***************************************************************************
 *                              viewonline.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: viewonline.php,v 1.54.2.4 2005/05/06 20:50:10 acydburn Exp $
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
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWONLINE);
init_userprefs($userdata);
//
// End session management
//

//-- mod : categories hierarchy ------------------------------------------------
//-- add
$navigation = new navigation();
$navigation->add('Who_is_Online', '', 'viewonline', '', '');
$navigation->display();

// get classes
include($config->url('includes/class_forums'));
include($config->url('includes/class_stats'));

// read forums
$forums = new forums();
$forums->read();
foreach ( $forums->data as $id => $data )
{
	$forum_data[$id] = $user->lang($data['forum_name']);
}

// prepare stats
$stats = new stats();
$user_levels = $stats->get_user_levels();

// get user auths
$user->get_cache(array(POST_FORUM_URL, POST_FORUM_URL . 'jbox'));
//-- fin mod : categories hierarchy --------------------------------------------

//
// Output page header and load viewonline template
//
$page_title = $lang['Who_is_Online'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'viewonline_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_WHOSONLINE' => $lang['Who_is_Online'],
	'L_ONLINE_EXPLAIN' => $lang['Online_explain'],
	'L_USERNAME' => $lang['Username'],
	'L_FORUM_LOCATION' => $lang['Forum_Location'],
	'L_LAST_UPDATE' => $lang['Last_updated'])
);

//
// Forum info
//
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
$sql = "SELECT forum_name, forum_id
	FROM " . FORUMS_TABLE;
if ( $result = $db->sql_query($sql) )
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_data[$row['forum_id']] = $row['forum_name'];
	}
}
else
{
	message_die(GENERAL_ERROR, 'Could not obtain user/online forums information', '', __LINE__, __FILE__, $sql);
}

//
// Get auth data
//
$is_auth_ary = array();
$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);
*/
//-- fin mod : categories hierarchy --------------------------------------------

//
// Get user list
//
$sql = "SELECT u.user_id, u.username, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_time, s.session_page, s.session_ip
	FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
	WHERE u.user_id = s.session_user_id
		AND s.session_time >= ".( time() - 300 ) . "
	ORDER BY u.username ASC, s.session_ip ASC";
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
$sql = str_replace('SELECT ', 'SELECT u.user_group_id, u.user_session_time, ', $sql);
//-- fin mod : Advanced Group Color Management ---------------------------------

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain regd user/online information', '', __LINE__, __FILE__, $sql);
}

$guest_users = 0;
$registered_users = 0;
$hidden_users = 0;

$reg_counter = 0;
$guest_counter = 0;
$prev_user = 0;
$prev_ip = '';

while ( $row = $db->sql_fetchrow($result) )
{
	$view_online = false;

	if ( $row['session_logged_in'] ) 
	{
		$user_id = $row['user_id'];

		if ( $user_id != $prev_user )
		{
			$username = $row['username'];

//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
			$style_color = '';
			if ( $row['user_level'] == ADMIN )
			{
				$username = '<b style="color:#' . $theme['fontcolor3'] . '">' . $username . '</b>';
			}
			else if ( $row['user_level'] == MOD )
			{
				$username = '<b style="color:#' . $theme['fontcolor2'] . '">' . $username . '</b>';
			}

			if ( !$row['user_allow_viewonline'] )
			{
				$view_online = ( $userdata['user_level'] == ADMIN ) ? true : false;
				$hidden_users++;

				$username = '<i>' . $username . '</i>';
			}
			else
			{
				$view_online = true;
				$registered_users++;
			}
*/
//-- add
			if ( $row['user_allow_viewonline'] )
			{
				$registered_users++;
			}
			else
			{
				$hidden_users++;
			}
			if ( $row['user_allow_viewonline'] || ($row['user_id'] == $user->data['user_id']) || ($user->data['user_level'] == ADMIN) || ($user->auth(POST_FORUM_URL, 'auth_mod', intval($row['session_page'])) && ($row['user_level'] != ADMIN)) )
			{
				$view_online = true;
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	$style = isset($user_levels[ $row['user_level'] ]) ? $user_levels[ $row['user_level'] ]['style'] : $user_levels[USER]['style'];
//	$username = sprintf(($row['user_allow_viewonline'] ? (empty($style) ? '%s' : '<span' . $style . '>%s</span>') : '<i' . $style . '>%s</i>'), $row['username']);
//-- add
				$style = ' style="color : #' . $colors->get_user_color($row['user_group_id'], $row['user_session_time']) . ';"';
				$username = sprintf(($row['user_allow_viewonline'] ? (empty($style) ? '%s' : '<span' . $style . ' class="username_color">%s</span>') : '<i' . $style . ' class="username_color">%s</i>'), $username);
//-- fin mod : Advanced Group Color Management ---------------------------------

			}
			else
			{
				$view_online = false;
			}
//-- fin mod : categories hierarchy --------------------------------------------

			$which_counter = 'reg_counter';
			$which_row = 'reg_user_row';
			$prev_user = $user_id;
		}
	}
	else
	{
		if ( $row['session_ip'] != $prev_ip )
		{
			$username = $lang['Guest'];
			$view_online = true;
			$guest_users++;
	
			$which_counter = 'guest_counter';
			$which_row = 'guest_user_row';
		}
	}

	$prev_ip = $row['session_ip'];

	if ( $view_online )
	{
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
		if ( $row['session_page'] < 1 || !$is_auth_ary[$row['session_page']]['auth_view'] )
*/
//-- add
		if ( ($row['session_page'] < 1) || !$user->auth(POST_FORUM_URL, 'auth_view', intval($row['session_page'])) )
//-- fin mod : categories hierarchy --------------------------------------------
		{
			switch( $row['session_page'] )
			{
				case PAGE_INDEX:
					$location = $lang['Forum_index'];
					$location_url = "index.$phpEx";
					break;
				case PAGE_POSTING:
					$location = $lang['Posting_message'];
					$location_url = "index.$phpEx";
					break;
				case PAGE_LOGIN:
					$location = $lang['Logging_on'];
					$location_url = "index.$phpEx";
					break;
				case PAGE_SEARCH:
					$location = $lang['Searching_forums'];
					$location_url = "search.$phpEx";
					break;
				case PAGE_PROFILE:
					$location = $lang['Viewing_profile'];
					$location_url = "index.$phpEx";
					break;
				case PAGE_VIEWONLINE:
					$location = $lang['Viewing_online'];
					$location_url = "viewonline.$phpEx";
					break;
				case PAGE_VIEWMEMBERS:
					$location = $lang['Viewing_member_list'];
					$location_url = "memberlist.$phpEx";
					break;
				case PAGE_PRIVMSGS:
					$location = $lang['Viewing_priv_msgs'];
					$location_url = "privmsg.$phpEx";
					break;
				case PAGE_FAQ:
					$location = $lang['Viewing_FAQ'];
					$location_url = "faq.$phpEx";
					break;
				default:
					$location = $lang['Forum_index'];
					$location_url = "index.$phpEx";
			}
		}
		else
		{
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
			$location_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . '=' . $row['session_page']);
*/
//-- add
			$location_url = $config->url('index', array(POST_FORUM_URL => $row['session_page']), true);
//-- fin mod : categories hierarchy --------------------------------------------
			$location = $forum_data[$row['session_page']];
		}

		$row_color = ( $$which_counter % 2 ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( $$which_counter % 2 ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("$which_row", array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'USERNAME' => $username,
			'LASTUPDATE' => create_date($board_config['default_dateformat'], $row['session_time'], $board_config['board_timezone']),
			'FORUM_LOCATION' => $location,

			'U_USER_PROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $user_id),
			'U_FORUM_LOCATION' => append_sid($location_url))
		);
//-- mod : categories hierarchy ------------------------------------------------
//-- add
		$template->set_switch($which_row . '.light', !($$which_counter % 2));
//-- fin mod : categories hierarchy --------------------------------------------

		$$which_counter++;
	}
}

if( $registered_users == 0 )
{
	$l_r_user_s = $lang['Reg_users_zero_online'];
}
else if( $registered_users == 1 )
{
	$l_r_user_s = $lang['Reg_user_online'];
}
else
{
	$l_r_user_s = $lang['Reg_users_online'];
}

if( $hidden_users == 0 )
{
	$l_h_user_s = $lang['Hidden_users_zero_online'];
}
else if( $hidden_users == 1 )
{
	$l_h_user_s = $lang['Hidden_user_online'];
}
else
{
	$l_h_user_s = $lang['Hidden_users_online'];
}

if( $guest_users == 0 )
{
	$l_g_user_s = $lang['Guest_users_zero_online'];
}
else if( $guest_users == 1 )
{
	$l_g_user_s = $lang['Guest_user_online'];
}
else
{
	$l_g_user_s = $lang['Guest_users_online'];
}

$template->assign_vars(array(
	'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($l_r_user_s, $registered_users) . sprintf($l_h_user_s, $hidden_users), 
	'TOTAL_GUEST_USERS_ONLINE' => sprintf($l_g_user_s, $guest_users))
);

if ( $registered_users + $hidden_users == 0 )
{
	$template->assign_vars(array(
		'L_NO_REGISTERED_USERS_BROWSING' => $lang['No_users_browsing'])
	);
}

if ( $guest_users == 0 )
{
	$template->assign_vars(array(
		'L_NO_GUESTS_BROWSING' => $lang['No_users_browsing'])
	);
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>