<?php
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_board_menu.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management
//

if ( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.".$phpEx."?redirect=board_menu_manager.".$phpEx, true));
}

// Set variables
$params = array(
	'submit' => '',
	'move' => 'move',
	'move_default' => 'move_default',
	'set_links' => 'set_links',
	'sort_links' => 'sort_links',
	'manage_links' => 'manage_links',
	'link_info' => 'link_info',
	'config_links' => 'config_links',
	'cancel' => 'cancel',
	'reset' => 'reset',
	'default_sort' => 'default_sort',
	'bmm_link' => 'bmm_link'
);

$join_link = '';

while( list($var, $param) = @each($params) )
{
	if ( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )
	{
		$$var = ( !empty($HTTP_POST_VARS[$param]) ) ? htmlspecialchars($HTTP_POST_VARS[$param]) : htmlspecialchars($HTTP_GET_VARS[$param]);
	}
	else
	{
		$$var = '';
	}
}

if ( $bmm_link )
{
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: bmm_link.'.$phpEx);
	exit;
}

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_board_menu.' . $phpEx );

if ( $cancel )
{
	$cancel = '';
	$submit = '';
	$HTTP_POST_VARS = array();
}
if ( $reset )
{
	$cancel = '';
	$submit = '';
	$HTTP_POST_VARS = array();
	$reset = '';
	$set_links = TRUE;
	$update_set_links = '';
}

// Set default sorting
if ( $HTTP_POST_VARS['sort_default'] )
{
	$sql = "SELECT ub.board_link, bl.bl_dsort FROM " . USER_BOARD_LINKS_TABLE . " ub, " . BOARD_LINKS_TABLE . " bl
		WHERE ub.board_link = bl.bl_id
		AND ub.user_id = " . $userdata['user_id'];
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not get default sorting for users board menu', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$board_link = $row['board_link'];
		$board_sort = $row['bl_dsort'];

		$sql_updates = "UPDATE " . USER_BOARD_LINKS_TABLE . "
				SET board_sort = $board_sort
				WHERE board_link = $board_link
				AND user_id = " . $userdata['user_id'];
		if ( !$result_updates = $db->sql_query($sql_updates) )
		{
			message_die(GENERAL_ERROR, 'Could not set default sorting for users board menu', '', __LINE__, __FILE__, $sql_updates);
		}
	}
	$db->sql_freeresult($result);
	
	$sort_links = TRUE;
}

// The moves. Yeah! Lets moving around...
if ( $move )
{
	$bl_id = ( isset($HTTP_POST_VARS['bl_id']) ) ? intval($HTTP_POST_VARS['bl_id']) : intval($HTTP_GET_VARS['bl_id']);

	if ( $bl_id )
	{
		if ( $move == 1 || $move == -1 )
		{
			$bl_move = ( $move == -1 ) ? -15 : 15;

			$sql = "UPDATE " . USER_BOARD_LINKS_TABLE . " SET board_sort = board_sort + $bl_move
				WHERE user_id = " . $userdata['user_id'] . "
				AND board_link = $bl_id";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not save board menu sorting', '', __LINE__, __FILE__, $sql);
			}

			reorder_menu_links('board');
		}
		else if ( $move == 9 || $move == -9 )
		{
			$sql = "SELECT max(board_sort) as max_sort FROM " . USER_BOARD_LINKS_TABLE . "
				WHERE user_id = " . $userdata['user_id'];
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not get board menu sorting', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$max_sort = $row['max_sort'];
			}
			$db->sql_freeresult($result);

			$bl_move = ( $move == -9 ) ? 0 : $max_sort + 10;

			$sql = "UPDATE " . USER_BOARD_LINKS_TABLE . " SET board_sort = $bl_move
				WHERE user_id = " . $userdata['user_id'] . "
				AND board_link = $bl_id";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not save board menu sorting', '', __LINE__, __FILE__, $sql);
			}

			reorder_menu_links('board');
		}
	}

	$sort_links = TRUE;
}

if ( $move_default )
{
	$bl_id = ( isset($HTTP_POST_VARS['bl_id']) ) ? intval($HTTP_POST_VARS['bl_id']) : intval($HTTP_GET_VARS['bl_id']);

	if ( $bl_id )
	{
		if ( $move_default == 15 || $move_default == -15 )
		{
			$bl_move = $move_default;
		}
		else if ( $move_default == -9 )
		{
			$sql = "SELECT bl_dsort FROM " . BOARD_LINKS_TABLE . "
				WHERE bl_id = $bl_id";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not get board menu default sorting', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$bl_move = 0 - $row['bl_dsort'];
			}
			$db->sql_freeresult($result);
		}
		else
		{
			$sql = "SELECT max(bl_dsort) as last_sort FROM " . BOARD_LINKS_TABLE;
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not get board menu default sorting', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$bl_move = $row['last_sort'] + 10;
			}
			$db->sql_freeresult($result);
		}

		$sql = "UPDATE " . BOARD_LINKS_TABLE . " SET bl_dsort = bl_dsort + $bl_move
			WHERE bl_id = $bl_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save board menu default sorting', '', __LINE__, __FILE__, $sql);
		}

		$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
			ORDER BY bl_dsort ASC";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save board menu default sorting', '', __LINE__, __FILE__, $sql);
		}

		$i = 10;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql2 = "UPDATE " . BOARD_LINKS_TABLE . " SET bl_dsort = $i
				 WHERE bl_id = " . $row['bl_id'];
			if ( !$result2 = $db->sql_query($sql2) )
			{
				message_die(GENERAL_ERROR, 'Could not save board menu default sorting', '', __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
		$db->sql_freeresult($result);
	}

	$default_sort = TRUE;
}
else if ( $link_info && $userdata['user_level'] == ADMIN )
{
	$bl_id = intval($HTTP_GET_VARS['bl_id']);

	if ( $bl_id != '' )
	{
		$sql = "SELECT u.username, u.user_id FROM " . USER_BOARD_LINKS_TABLE . " bl, " . USERS_TABLE . " u
			WHERE bl.user_id = u.user_id
				AND bl.board_link = $bl_id
			ORDER BY u.username ASC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not fetch user menu', '', __LINE__, __FILE__, $sql);
		}

		$board_user_links = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$user_link = '<a href="'.append_sid("profile.$phpEx?mode=viewprofile&amp;".POST_USER_URL."=".$row['user_id']).'">'.$row['username'].'</a>';

			$board_user_links .= (($board_user_links != '') ? ', ' : '') . $user_link;
		}
		$db->sql_freeresult($result);
	}

	$manage_links = TRUE;
}

// The submits
if ( $HTTP_POST_VARS['config'] == 1 )
{
	$bl_seperator = intval($HTTP_POST_VARS['bl_seperator']);
	$bl_seperator_content = htmlspecialchars($HTTP_POST_VARS['bl_seperator_content']);
	$bl_break = intval($HTTP_POST_VARS['bl_break']);

	$bl_seperator = ( $bl_seperator == '' ) ? 0 : $bl_seperator;
	$bl_seperator_content = ( $bl_seperator_content == '' ) ? 'SPACE' : $bl_seperator_content;
	$bl_break = ( $bl_break == '' ) ? 5 : $bl_break;

	$bl_seperator = ( $bl_seperator_content == 'SPACE' ) ? 0 : $bl_seperator;

	$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = '".str_replace("\'", "''", $bl_seperator)."'
		WHERE config_name = 'bl_seperator'";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not save board menu configuration', '', __LINE__, __FILE__, $sql);
	}
		
	$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = '" . str_replace("\'", "''", $bl_seperator_content) ."'
		WHERE config_name = 'bl_seperator_content'";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not save board menu configuration', '', __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = '$bl_break'
		WHERE config_name = 'bl_break'";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not save board menu configuration', '', __LINE__, __FILE__, $sql);
	}

	$board_config['bl_seperator'] = $bl_seperator;
	$board_config['bl_seperator_content'] = str_replace('SPACE', '&nbsp;&nbsp;&nbsp;', $bl_seperator_content);
	$board_config['bl_break'] = $bl_break;
}
else if ( $HTTP_POST_VARS['update_set_links'] == 1 )
{
	$user = $userdata['user_id'];

	$sort_links = FALSE;

	// Update choosed board menu links
	$bl_id = $HTTP_POST_VARS['bl_id'];

	$sql = "DELETE FROM " . USER_BOARD_LINKS_TABLE . " WHERE user_id = $user";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update board menu link', '', __LINE__, __FILE__, $sql);
	}
		
	if ( $bl_id )
	{
		for ($i = 0; $i < count($bl_id); $i++)
		{
			$j = $i*10;
			$board_link = $bl_id[$i];
			$board_link = intval($board_link);

			if ( $board_link != '' )
			{
				$sql = "INSERT INTO " . USER_BOARD_LINKS_TABLE . "
					(user_id, board_link, board_sort)
					VALUES ($user, $board_link, $j)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not save board menu link', '', __LINE__, __FILE__, $sql);
				}
			}
		}
	
		reorder_menu_links('board', $user);

		$sort_links = 0;
	}
}
else if ( $HTTP_POST_VARS['update_links'] == 1 && $userdata['user_level'] == ADMIN )
{
	// Get link settings and old auth
	$bl_id = intval($HTTP_POST_VARS['bl_id']);
	$bl_img = htmlspecialchars($HTTP_POST_VARS['bl_img']);
	$bl_name = htmlspecialchars($HTTP_POST_VARS['bl_name']);
	$bl_parameter = htmlspecialchars($HTTP_POST_VARS['bl_parameter']);
	$bl_link = htmlspecialchars($HTTP_POST_VARS['bl_link']);
	$bl_level = intval($HTTP_POST_VARS['bl_level']);

	$bl_img = ( $bl_img == '---' ) ? '' : $bl_img;

	$sql = "SELECT bl_level FROM " . BOARD_LINKS_TABLE . "
		WHERE bl_id = $bl_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get menu link data', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$bl_level_check = $row['bl_level'];
	}
	$db->sql_freeresult($result);

	// Check auth changes
	$sql_user_level = '';

	if ( defined('LESS_ADMIN') )
	{
		if ( ( $bl_level_check == USER || $bl_level_check == ANONYMOUS ) && $bl_level == MOD )
		{
			$sql_user_level = 'WHERE user_level = ' . USER;
		}
		else if ( ( $bl_level_check == USER || $bl_level_check == ANONYMOUS || $bl_level_check == MOD ) && $bl_level == LESS_ADMIN )
		{
			$sql_user_level = 'WHERE user_level IN (' . USER . ', ' . MOD . ')';
		}
		else if ( ( $bl_level_check == USER || $bl_level_check == ANONYMOUS || $bl_level_check == LESS_ADMIN ) && $bl_level == ADMIN )
		{
			$sql_user_level = 'WHERE user_level IN (' . USER . ', ' . MOD . ', ' . LESS_ADMIN . ')';
		}
		else if ( ( $bl_level_check == MOD || $bl_level_check == LESS_ADMIN ) && $bl_level == ADMIN )
		{
			$sql_user_level = 'WHERE user_level IN (' . MOD . ', ' . LESS_ADMIN . ')';
		}
	}
	else
	{
		if ( ( $bl_level_check == USER || $bl_level_check == ANONYMOUS ) && $bl_level == MOD )
		{
			$sql_user_level = 'WHERE user_level = ' . USER;
		}
		else if ( ( $bl_level_check == USER || $bl_level_check == ANONYMOUS || $bl_level_check == MOD ) && $bl_level == ADMIN )
		{
			$sql_user_level = 'WHERE user_level IN (' . USER . ', ' . MOD . ')';
		}
	}

	if ( $sql_user_level != '' )
	{
		// Read userdata for needed updates
		$sql = "SELECT user_id FROM " . USERS_TABLE . "
			$sql_user_level
			ORDER BY user_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not get user data for deleting none accessable links', '', __LINE__, __FILE__, $sql);
		}

		// Delete not needed menu links
		while ( $row = $db->sql_fetchrow($result) )
		{
			$user = $row['user_id'];

			$sql2 = "DELETE FROM " . USER_BOARD_LINKS_TABLE . "
				 WHERE user_id = $user
				 AND board_link = $bl_id";
			if ( !($result2 = $db->sql_query($sql2)) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user board menu link', '', __LINE__, __FILE__, $sql2);
			}

			reorder_menu_links('board', $user);
		}
		$db->sql_freeresult($result);
	}

	$sql = "UPDATE " . BOARD_LINKS_TABLE . "
		SET bl_img = '" . str_replace("\'", "''", $bl_img) ."', bl_name = '" . str_replace("\'", "''", $bl_name) ."', bl_parameter = '" . str_replace("\'", "''", $bl_parameter) ."', bl_link = '" . str_replace("\'", "''", $bl_link) ."', bl_level = $bl_level
		WHERE bl_id = $bl_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update board menu link', '', __LINE__, __FILE__, $sql);
	}

	$manage_links = TRUE;
}
else if ( $HTTP_POST_VARS['save_links'] == 1 && $userdata['user_level'] == ADMIN )
{
	// Save new link
	$bl_img = htmlspecialchars($HTTP_POST_VARS['bl_img']);
	$bl_name = htmlspecialchars($HTTP_POST_VARS['bl_name']);
	$bl_parameter = htmlspecialchars($HTTP_POST_VARS['bl_parameter']);
	$bl_link = htmlspecialchars($HTTP_POST_VARS['bl_link']);
	$bl_level = intval($HTTP_POST_VARS['bl_level']);

	$bl_img = ( $bl_img == '---' ) ? '' : $bl_img;

	$sql = "INSERT INTO " . BOARD_LINKS_TABLE . " (bl_img , bl_name , bl_parameter , bl_link , bl_level)
		VALUES ('" . str_replace("\'", "''", $bl_img) ."', '" . str_replace("\'", "''", $bl_name) ."', '" . str_replace("\'", "''", $bl_parameter) ."', '" . str_replace("\'", "''", $bl_link) ."', $bl_level)";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not save new board menu link', '', __LINE__, __FILE__, $sql);
	}

	$manage_links = TRUE;
}
else if ( isset($HTTP_POST_VARS['delete_link']) || isset($HTTP_GET_VARS['delete_link']) && $userdata['user_level'] == ADMIN )
{
	// Delete board menu link
	$bl_id = intval($HTTP_GET_VARS['bl_id']);

	$sql = "SELECT user_id FROM " . USER_BOARD_LINKS_TABLE . "
		WHERE board_link = $bl_id
		ORDER BY user_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not get link from user board menu', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$user = $row['user_id'];

		$sql_deletes = "DELETE FROM " . USER_BOARD_LINKS_TABLE . "
				WHERE board_link = $bl_id
				AND user_id = $user";
		if ( !$result_deletes = $db->sql_query($sql_deletes) )
		{
			message_die(GENERAL_ERROR, 'Could not delete link from user board menu', '', __LINE__, __FILE__, $sql_deletes);
		}

		reorder_menu_links('board', $user);
	}
	$db->sql_freeresult($result);

	$sql = "DELETE FROM " . BOARD_LINKS_TABLE . "
		WHERE bl_id = $bl_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not delete board menu link', '', __LINE__, __FILE__, $sql);
	}

	$manage_links = TRUE;
}
else if ( isset($HTTP_POST_VARS['edit_link']) || isset($HTTP_GET_VARS['edit_link']) && $userdata['user_level'] == ADMIN )
{
	$bl_id = intval($HTTP_GET_VARS['bl_id']);

	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
		WHERE bl_id = $bl_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu link', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$blimg = $row['bl_img'];
		$blname = $row['bl_name'];
		$bl_parameter = $row['bl_parameter'];
		$bl_link = $row['bl_link'];
		$bllevel = $row['bl_level'];
	}
	$db->sql_freeresult($result);

	$bl_names = get_menu_language_names();
	$bl_names = str_replace('value="'.$blname.'">', 'value="'.$blname.'" selected="selected">', $bl_names);

	$bl_images = get_menu_images();
	$bl_images = str_replace('value="'.$blimg.'">', 'value="'.$blimg.'" selected="selected">', $bl_images);

	$bl_level = get_bl_access();
	$bl_level = str_replace('value="'.$bllevel.'">', 'value="'.$bllevel.'" selected="selected">', $bl_level);

	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_links_edit.tpl')
	);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_manage_links'],

		'L_BL_IMG' => $lang['Bl_img'],
		'L_BL_NAME' => $lang['Bl_name'],
		'L_BL_PARAMETER' => $lang['Bl_parameter'],
		'L_BL_PARAMETER_EXPLAIN' => $lang['Bl_parameter_explain'],
		'L_BL_LINK' => $lang['Bl_link'],
		'L_BL_LINK_EXPLAIN' => $lang['Bl_link_explain'],
		'L_BL_LEVEL' => $lang['Bl_level'],
		'L_SUBMIT' => $lang['Submit'],
		'L_PREVIOUS' => $lang['Previous'],

		'BLID' => $bl_id,
		'BLIMG' => $bl_images,
		'BLNAME' => $bl_names,
		'BLPARAMETER' => $bl_parameter,
		'BLLINK' => $bl_link,
		'BLLEVEL' => $bl_level,

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

$submit = '';

// Various Modes
if ( $set_links )
{
	// Prepare page
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$bl_links = array();
	$pl_links = array();

	$template->set_filenames(array(
		'body' => 'board_menu_links_set.tpl')
	);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_set_links'],
		'L_BOARD_MENU_MANAGER' => $lang['Board_menu_manager'],

		'L_BL_LINK' => $lang['Bl_link'],
		'L_PL_LINK' => $lang['Bl_plink'],
		'L_BL_SET' => $lang['Bl_set'],

		'L_MARK_ALL' => $lang['Mark_all'], 
		'L_UNMARK_ALL' => $lang['Unmark_all'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	// Prepare board menu links
	$sql = "SELECT bl.* FROM " . USER_BOARD_LINKS_TABLE . " ub, " . BOARD_LINKS_TABLE . " bl
		WHERE ub.user_id = " . $userdata['user_id'] . "
		AND ub.board_link = bl.bl_id
		ORDER BY ub.board_sort";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu for user', '', __LINE__, __FILE__, $sql);
	}
	$user_links_count = $db->sql_numrows($result);

	$bl_links = array();
	$board_menu_links_user = array();
	$board_menu_links_check = array();

	while( $row = $db->sql_fetchrow($result) )
	{
		$bl_links[] = $row['bl_id'];

		if (substr($row['bl_link'],0,10) != 'javascript')
		{
			$phpext = '.'.$phpEx;
			$sidext = ( $row['bl_parameter'] != '' ) ? '&amp;sid='.$userdata['session_id'] : '?sid='.$userdata['session_id'];
		}
		else
		{
			$phpext = '';
			$sidext = '';
		}

		$board_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$board_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$board_menu_links .= '" class="mainmenu" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

		$saved_link = $row['bl_id'];

		$board_menu_links_user[] = $board_menu_links;
		$board_menu_links_check[] = '<input type="checkbox" name="bl_id[]" value="'.$saved_link.'" checked="checked" />';
	}
	$db->sql_freeresult($result);

	$sql_access = get_bllink_access();

	$sql_where = '';
	if ( $user_links_count != 0 )
	{
		$sql_where = ( $sql_access != '' ) ? ' AND bl_id NOT IN ('.implode(',', $bl_links).')' : 'WHERE bl_id NOT IN ('.implode(',', $bl_links).')';
	}

	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
		$sql_access
		$sql_where
		ORDER BY bl_dsort";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu for user', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		if (substr($row['bl_link'],0,10) != 'javascript')
		{
			$phpext = '.'.$phpEx;
			$sidext = ( $row['bl_parameter'] != '' ) ? '&amp;sid='.$userdata['session_id'] : '?sid='.$userdata['session_id'];
		}
		else
		{
			$phpext = '';
			$sidext = '';
		}

		$board_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$board_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$board_menu_links .= '" class="mainmenu" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

		$saved_link = $row['bl_id'];

		$template->assign_block_vars('board_links_row', array(
			'BL_MENU_LINKS' => $board_menu_links,
			'BL_CHECK' => '<input type="checkbox" name="bl_id[]" value="'.$saved_link.'" />')
		);
	}
	$db->sql_freeresult($result);

	for ( $i = 0; $i < count($board_menu_links_user); $i++ )
	{
		$template->assign_block_vars('board_links_row', array(
			'BL_MENU_LINKS' => $board_menu_links_user[$i],
			'BL_CHECK' => $board_menu_links_check[$i])
		);
	}

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $sort_links )
{
	// Prepare page
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$bl_links = array();
	$pl_links = array();

	$template->set_filenames(array(
		'body' => 'board_menu_links_sort.tpl')
	);

	$template->assign_block_vars('sort_menu', array());
	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_sort_links'],

		'L_BL_LINK' => $lang['Bl_link'],
		'L_PL_LINK' => $lang['Bl_plink'],

		'L_CLOSE_WINDOW' => $lang['Board_menu_manager'],
		'L_SORT_DEFAULT' => $lang['Board_manager_default_sort_links'],

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	// Prepare board menu links
	$sql = "SELECT bl.* FROM " . USER_BOARD_LINKS_TABLE . " ug, " . BOARD_LINKS_TABLE . " bl
		WHERE ug.user_id = " . $userdata['user_id'] . "
		AND ug.board_link = bl.bl_id
		ORDER BY ug.board_sort";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu for user', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		if (substr($row['bl_link'],0,10) != 'javascript')
		{
			$phpext = '.'.$phpEx;
			$sidext = ( $row['bl_parameter'] != '' ) ? '&amp;sid='.$userdata['session_id'] : '?sid='.$userdata['session_id'];
		}
		else
		{
			$phpext = '';
			$sidext = '';
		}

		$board_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$board_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$board_menu_links .= '" class="mainmenu" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

		$bl_id = $row['bl_id'];
		$template->assign_block_vars('sort_links_row', array(
			'L_BL_UP' => $lang['Bl_moveup'],
			'L_BL_DOWN' => $lang['Bl_movedown'],
			'L_BL_FIRST' => $lang['Bl_movefirst'],
			'L_BL_LAST' => $lang['Bl_movelast'],

			'BL_LINK' => $board_menu_links,

			'U_BL_UP' => append_sid("board_menu_manager.$phpEx?move=-1&amp;bl_id=$bl_id"),
			'U_BL_DOWN' => append_sid("board_menu_manager.$phpEx?move=1&amp;bl_id=$bl_id"),
			'U_BL_FIRST' => append_sid("board_menu_manager.$phpEx?move=-9&amp;bl_id=$bl_id"),
			'U_BL_LAST' => append_sid("board_menu_manager.$phpEx?move=9&amp;bl_id=$bl_id"))
		);
	}
	$db->sql_freeresult($result);

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $default_sort && $userdata['user_level'] == ADMIN )
{
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_links_sort.tpl')
	);

	// Set default sorting for board menu links
	$sql = "SELECT bl_dsort FROM " . BOARD_LINKS_TABLE . "
		ORDER BY bl_dsort DESC
		LIMIT 1";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu for default sorting', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$sort_check = $row['bl_dsort'];
	}
	$db->sql_freeresult($result);

	if ( $sort_check == '' )
	{
		$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
			ORDER BY bl_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save board menu default sorting', '', __LINE__, __FILE__, $sql);
		}

		$i = 10;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql2 = "UPDATE " . BOARD_LINKS_TABLE . " SET bl_dsort = $i
				 WHERE bl_id = " . $row['bl_id'];
			if ( !$result2 = $db->sql_query($sql2) )
			{
				message_die(GENERAL_ERROR, 'Could not save board menu default sorting', '', __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
		$db->sql_freeresult($result);
	}

	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
		ORDER BY bl_dsort";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu for default sorting', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		if (substr($row['bl_link'],0,10) != 'javascript')
		{
			$phpext = '.'.$phpEx;
			$sidext = ( $row['bl_parameter'] != '' ) ? '&amp;sid='.$userdata['session_id'] : '?sid='.$userdata['session_id'];
		}
		else
		{
			$phpext = '';
			$sidext = '';
		}

		$board_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$board_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$board_menu_links .= '" class="mainmenu" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

		$bl_id = $row['bl_id'];
		$template->assign_block_vars('sort_links_row', array(
			'L_BL_UP' => $lang['Bl_moveup'],
			'L_BL_DOWN' => $lang['Bl_movedown'],
			'L_BL_FIRST' => $lang['Bl_movefirst'],
			'L_BL_LAST' => $lang['Bl_movelast'],

			'BL_LINK' => $board_menu_links,

			'U_BL_UP' => append_sid("board_menu_manager.$phpEx?move_default=-15&amp;bl_id=$bl_id"),
			'U_BL_DOWN' => append_sid("board_menu_manager.$phpEx?move_default=15&amp;bl_id=$bl_id"),
			'U_BL_FIRST' => append_sid("board_menu_manager.$phpEx?move_default=-9&amp;bl_id=$bl_id"),
			'U_BL_LAST' => append_sid("board_menu_manager.$phpEx?move_default=9&amp;bl_id=$bl_id"))
		);
	}
	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_default_sort_links'],

		'L_BL_LINK' => $lang['Bl_link'],
		'L_PL_LINK' => $lang['Bl_plink'],

		'L_CLOSE_WINDOW' => $lang['Board_menu_manager'],

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $manage_links && $userdata['user_level'] == ADMIN )
{
	// Load Page Header
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_links_admin.tpl'));

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_manage_links'],

		'L_BL_IMG' => $lang['Bl_img'],
		'L_BL_NAME' => $lang['Bl_name'],
		'L_BL_PARAMETER' => $lang['Bl_parameter'],
		'L_BL_PARAMETER_EXPLAIN' => $lang['Bl_parameter_explain'],
		'L_BL_LINK' => $lang['Bl_link'],
		'L_BL_LINK_EXPLAIN' => $lang['Bl_link_explain'],
		'L_BL_LEVEL' => $lang['Bl_level'],
		'L_SUBMIT' => $lang['Submit'],
		'L_BOARD_MANAGER' => $lang['Board_menu_manager'],

		'BLIMG' => get_menu_images(),
		'BLNAME' => get_menu_language_names(),
		'BLLEVEL' => get_bl_access(),

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	// Count board menu links
	$sql = "SELECT board_link, count(user_id) as total FROM " . USER_BOARD_LINKS_TABLE . "
		GROUP BY board_link";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not count used board links', '', __LINE__, __FILE__, $sql);
	}

	$used_board_links = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$used_board_links[$row['board_link']] = $row['total'];
	}
	$db->sql_freeresult($result);

	// Get saved Board Menu Links
	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
		ORDER BY bl_dsort, bl_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read saves board menu links', '', __LINE__, __FILE__, $sql);
	}

	$i = 0;
	while ( $row = $db->sql_fetchrow($result) )
	{
		$bl_id = $row['bl_id'];

		if (substr($row['bl_link'],0,10) != 'javascript')
		{
			$phpext = '.'.$phpEx;
			$sidext = ( $row['bl_parameter'] != '' ) ? '&amp;sid='.$userdata['session_id'] : '?sid='.$userdata['session_id'];
		}
		else
		{
			$phpext = '';
			$sidext = '';
		}

		$board_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$board_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$board_menu_links .= '" class="mainmenu" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

		$board_link_use_count = sprintf($lang['Bl_board_link_used'], intval($used_board_links[$bl_id]));

		switch ($row['bl_level'])
		{
			case ANONYMOUS:
				$bl_access_level = $lang['Bl_guest'];
				break;
			case USER:
				$bl_access_level = $lang['Bl_user'];
				break;
			case MOD:
				$bl_access_level = $lang['Bl_mod'];
				break;
			case LESS_ADMIN:
				$bl_access_level = $lang['Bl_super_mod'];
				break;
			case ADMIN:
				$bl_access_level = $lang['Bl_admin'];
				break;
		}

		$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
		
		$template->assign_block_vars('menulinkrow', array(
			'L_BL_INFO' => $lang['Bl_link_info'],
			'L_BL_EDIT' => $lang['Update'],
			'L_BL_DELETE' => $lang['Delete'],

			'ROW_CLASS' => $row_class,
			'BL_MENU_LINK' => $board_menu_links,
			'BL_BOARD_LINK_USED' => $board_link_use_count,
			'BL_LEVEL' => $bl_access_level,

			'U_BL_INFO' => append_sid("board_menu_manager.$phpEx?link_info=1&amp;bl_id=$bl_id"),
			'U_BL_EDIT' => append_sid("board_menu_manager.$phpEx?edit_link=1&amp;bl_id=$bl_id"),
			'U_BL_DELETE' => append_sid("board_menu_manager.$phpEx?delete_link=1&amp;bl_id=$bl_id"))
		);

		$i++;
	}
	$db->sql_freeresult($result);

	if ($board_user_links != '')
	{
		$template->assign_block_vars('board_link_used', array(
			'L_BOARD_LINK_USED' => $lang['Bl_board_link_used_user'],
			'BOARD_LINK_USER' => $board_user_links)
		);
	}
	
	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $config_links && $userdata['user_level'] == ADMIN )
{
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_config.tpl'));

	$sql = "SELECT * FROM " . CONFIG_TABLE . "
		WHERE config_name IN ('bl_seperator', 'bl_seperator_content', 'bl_break')";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not get board menu configuration', '', __LINE__, __FILE__, $sql);
	}

	$bl = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$bl[$row['config_name']] = $row['config_value'];
	}
	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_config_links'],

		'L_BL_SEPERATOR' => $lang['Bl_seperator'],
		'L_BL_SEPERATOR_CONTENT' => $lang['Bl_seperator_content'],
		'L_BL_BREAK' => $lang['Bl_break'],
		'L_SUBMIT' => $lang['Bl_config_save'],
		'L_BOARD_MENU_MANAGER' => $lang['Board_menu_manager'],

		'BL_SEPERATOR' => ( $bl['bl_seperator'] == 1 ) ? 'checked="checked"' : '',
		'BL_SEPERATOR_CONTENT' => $bl['bl_seperator_content'],
		'BL_BREAK' => $bl['bl_break'],

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

//
// Welcome Screen and Board Manager Menu
//
if ( !$submit )
{
	// Load Board Header with current user board menu
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_welcome.tpl'));

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_explain'],

		'L_SET_BOARD_LINKS' => $lang['Board_manager_set_links'],
		'L_SORT_BOARD_LINKS' => $lang['Board_manager_sort_links'],
		'L_CLOSE_WINDOW' => $lang['Board_manager_close'],

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	if ( $userdata['user_level'] == ADMIN )
	{
		$template->assign_block_vars('admin_options', array(
			'L_MANAGE_BOARD_LINKS' => $lang['Board_manager_manage_links'],
			'L_DEFAULT_SORT_LINKS' => $lang['Board_manager_default_sort_links'],
			'L_CONFIG_BOARD_LINKS' => $lang['Board_manager_config_links'])
		);

		if (@file_exists($phpbb_root_path.'bmm_link.'.$phpEx))
		{
			$template->assign_block_vars('click_counter_on', array(
				'L_CLICK_COUNTER' => $lang['Board_manager_counter'])
			);
		}
	}

	$sql = "SELECT * FROM " . USER_BOARD_LINKS_TABLE . "
		WHERE user_id = " . $userdata['user_id'];
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not check for existing board menu links', '', __LINE__, __FILE__, $sql);
	}
	$count_board_menu_links = $db->sql_numrows($result);
	
	if ( $count_board_menu_links != 0 )
	{
		$template->assign_block_vars('switch_sorting_on', array());
	}
	$db->sql_freeresult($result);

	$template->pparse('body');
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>