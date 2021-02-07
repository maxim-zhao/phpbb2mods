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
	'manage_categories' => 'manage_categories',
	'merge' => 'merge',
	'sort_cat' => 'sort_cat',
	'cat_name' => 'cat_name',
	'move_cat' => 'move_cat',
	'remove_link' => 'remove_link',
	'join_link' => 'join_link',
	'movep' => 'movep',
	'move_pdefault' => 'move_pdefault',
	'fix_links' => 'fix_links',
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

if ( $HTTP_POST_VARS['sort_pdefault'] )
{
	$sql = "SELECT up.portal_link, bl.bl_psort FROM " . USER_PORTAL_LINKS_TABLE . " up, " . BOARD_LINKS_TABLE . " bl
		WHERE up.portal_link = bl.bl_id
		AND up.user_id = " . $userdata['user_id'];
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not get default sorting for users portal menu', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$portal_link = $row['portal_link'];
		$portal_sort = $row['bl_psort'];

		$sql_updates = "UPDATE " . USER_PORTAL_LINKS_TABLE . "
				SET portal_sort = $portal_sort
				WHERE portal_link = $portal_link
				AND user_id = " . $userdata['user_id'];
		if ( !$result_updates = $db->sql_query($sql_updates) )
		{
			message_die(GENERAL_ERROR, 'Could not set default sorting for users portal menu', '', __LINE__, __FILE__, $sql_updates);
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

if ( $movep )
{
	$pl_id = ( $HTTP_POST_VARS['pl_id'] ) ? intval($HTTP_POST_VARS['pl_id']) : intval($HTTP_GET_VARS['pl_id']);

	if ( $pl_id )
	{
		if ( $movep == 1 || $movep == -1 )
		{
			$pl_move = ( $movep == -1 ) ? -15 : 15;

			$sql = "UPDATE " . USER_PORTAL_LINKS_TABLE . " SET portal_sort = portal_sort + $pl_move
				WHERE user_id = " . $userdata['user_id'] . "
				AND portal_link = $pl_id";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not save portal menu sorting', '', __LINE__, __FILE__, $sql);
			}
		}

		reorder_menu_links('portal');
	}

	$sort_links = TRUE;
}

if ( $move_cat )
{
	$cat_id = ( isset($HTTP_POST_VARS['cat_id']) ) ? intval($HTTP_POST_VARS['cat_id']) : intval($HTTP_GET_VARS['cat_id']);

	if ( $cat_id )
	{
		$move = ( $move_cat == -1 ) ? -15 : 15;
		$sql = "UPDATE " . BOARD_MENU_CAT_TABLE . " SET cat_sort = cat_sort + $move
			WHERE cat_id  = $cat_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save category sorting', '', __LINE__, __FILE__, $sql);
		}

		$sql = "SELECT * FROM " . BOARD_MENU_CAT_TABLE . "
			ORDER BY cat_sort ASC";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save category sorting', '', __LINE__, __FILE__, $sql);
		}

		$i = 10;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql2 = "UPDATE " . BOARD_MENU_CAT_TABLE . " SET cat_sort = $i
				 WHERE cat_id = " . $row['cat_id'];
			if ( !$result2 = $db->sql_query($sql2) )
			{
				message_die(GENERAL_ERROR, 'Could not save category default sorting', '', __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
		$db->sql_freeresult($result);

	}

	$sort_cat = TRUE;
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

if ( $move_pdefault )
{
	$pl_id = ( isset($HTTP_POST_VARS['pl_id']) ) ? intval($HTTP_POST_VARS['pl_id']) : intval($HTTP_GET_VARS['pl_id']);

	if ( $pl_id )
	{
		$sql = "UPDATE " . BOARD_LINKS_TABLE . " SET bl_psort = bl_psort + $move_pdefault
			WHERE bl_id = $pl_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save portal menu default sorting', '', __LINE__, __FILE__, $sql);
		}

		$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
			ORDER BY bl_psort ASC";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save portal menu default sorting', '', __LINE__, __FILE__, $sql);
		}

		$i = 10;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql2 = "UPDATE " . BOARD_LINKS_TABLE . " SET bl_psort = $i
				 WHERE bl_id = " . $row['bl_id'];
			if ( !$result2 = $db->sql_query($sql2) )
			{
				message_die(GENERAL_ERROR, 'Could not save portal menu default sorting', '', __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
		$db->sql_freeresult($result);
	}

	$default_sort = TRUE;
}

// The submits
if ( $HTTP_POST_VARS['config'] == 1 )
{
	$bl_seperator = intval($HTTP_POST_VARS['bl_seperator']);
	$bl_seperator_content = htmlspecialchars($HTTP_POST_VARS['bl_seperator_content']);
	$bl_break = intval($HTTP_POST_VARS['bl_break']);
	$bl_fix_sort = intval($HTTP_POST_VARS['bl_fix_sort']);

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

	$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = '$bl_fix_sort'
		WHERE config_name = 'bl_fix_sort'";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not save board menu configuration', '', __LINE__, __FILE__, $sql);
	}

	$board_config['bl_seperator'] = $bl_seperator;
	$board_config['bl_seperator_content'] = str_replace('SPACE', '&nbsp;&nbsp;&nbsp;', $bl_seperator_content);
	$board_config['bl_break'] = $bl_break;
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

		$sql = "SELECT u.username, u.user_id FROM " . USER_PORTAL_LINKS_TABLE . " pl, " . USERS_TABLE . " u
			WHERE pl.user_id = u.user_id
				AND pl.portal_link = $bl_id
			ORDER BY u.username ASC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not fetch user menu', '', __LINE__, __FILE__, $sql);
		}

		$portal_user_links = '';
		while ($row = $db->sql_fetchrow($result))
		{
			$user_link = '<a href="'.append_sid("profile.$phpEx?mode=viewprofile&amp;".POST_USER_URL."=".$row['user_id']).'">'.$row['username'].'</a>';

			$portal_user_links .= (($portal_user_links != '') ? ', ' : '') . $user_link;
		}
		$db->sql_freeresult($result);
	}

	$manage_links = TRUE;
}
else if ( $fix_links && $userdata['user_level'] == ADMIN )
{
	$bl_id = intval($HTTP_GET_VARS['bl_id']);
	$cat_id = intval($HTTP_GET_VARS['cat_id']);

	if ( $bl_id != '' )
	{
		$sql = "UPDATE " . BOARD_LINKS_TABLE . " SET bl_fix = " . ( ( $fix_links == -1 ) ? 0 : 1 ) . "
			WHERE bl_id = $bl_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not set link status', '', __LINE__, __FILE__, $sql);
		}
	}

	$merge = TRUE;
}
else if ( $remove_link == 1 && $userdata['user_level'] == ADMIN )
{
	$bl_id = intval($HTTP_GET_VARS['bl_id']);
	$cat_id = intval($HTTP_GET_VARS['cat_id']);

	if ( $bl_id != '' )
	{
		$sql = "DELETE FROM " . BOARD_MENU_MERGE_TABLE . "
			WHERE link_id = $bl_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete joined link', '', __LINE__, __FILE__, $sql);
		}
	}

	$merge = TRUE;
}
else if ( $join_link == 1 && $userdata['user_level'] == ADMIN )
{
	$bl_id = intval($HTTP_POST_VARS['bl_id']);
	$cat_id = intval($HTTP_POST_VARS['cat_id']);

	if ( $bl_id != '' && $cat_id != '' && !$manage_categories )
	{
		$sql = "INSERT " . BOARD_MENU_MERGE_TABLE . " (cat_id, link_id) VALUES ($cat_id, $bl_id)";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not save joined link', '', __LINE__, __FILE__, $sql);
		}
	}

	if ( $manage_categories )
	{
		$manage_categories = TRUE;
	}
	else
	{
		$merge = TRUE;
	}
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

	if ( count($bl_id) != 0 )
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

		$sort_links = TRUE;
	}

	// Update choosed portal menu links
	$pl_id = $HTTP_POST_VARS['pl_id'];

	$sql = "DELETE FROM " . USER_PORTAL_LINKS_TABLE . " WHERE user_id = $user";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update portal menu link', '', __LINE__, __FILE__, $sql);
	}

	if ( count($pl_id) != 0 )
	{
		for ($i = 0; $i < count($pl_id); $i++)
		{
			$j = $i*10;
			$portal_link = $pl_id[$i];
			$portal_link = intval($portal_link);

			if ( $portal_link != '' )
			{
				$sql = "INSERT INTO " . USER_PORTAL_LINKS_TABLE . "
					(user_id, portal_link, portal_sort)
					VALUES ($user, $portal_link, $j)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not save portal menu link', '', __LINE__, __FILE__, $sql);
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

			$sql2 = "DELETE FROM " . USER_PORTAL_LINKS_TABLE . "
				 WHERE user_id = $user
				 AND portal_link = $bl_id";
			if ( !($result2 = $db->sql_query($sql2)) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user portal menu link', '', __LINE__, __FILE__, $sql2);
			}

			reorder_menu_links('board', $user);

			reorder_menu_links('portal', $user);
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
else if ( $HTTP_POST_VARS['update_cat'] == 1 && $userdata['user_level'] == ADMIN )
{
	// Update link
	$cat_id = intval($HTTP_POST_VARS['cat_id']);
	$show_catname = ( $HTTP_POST_VARS['show_catname'] ) ? TRUE : 0;
	$show_seperator = ( $HTTP_POST_VARS['show_seperator'] ) ? TRUE : 0;

	$sql = "UPDATE " . BOARD_MENU_CAT_TABLE . "
		SET cat_name = '" . str_replace("\'", "''", $cat_name) ."', show_cat_name = $show_catname, show_seperator = $show_seperator
		WHERE cat_id = $cat_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update board menu category', '', __LINE__, __FILE__, $sql);
	}

	$manage_categories = TRUE;
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
else if ( $HTTP_POST_VARS['save_cat'] == 1 && $userdata['user_level'] == ADMIN )
{
	$show_catname = ( $HTTP_POST_VARS['show_catname'] ) ? TRUE : 0;
	$show_seperator = ( $HTTP_POST_VARS['show_seperator'] ) ? TRUE : 0;

	// Save new link
	$sql = "INSERT INTO " . BOARD_MENU_CAT_TABLE . " (cat_name, show_cat_name, show_seperator)
		VALUES ('" . str_replace("\'", "''", $cat_name) ."', $show_catname, $show_seperator)";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not save new board menu category', '', __LINE__, __FILE__, $sql);
	}

	$manage_categories = TRUE;
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

	$sql = "SELECT user_id FROM " . USER_PORTAL_LINKS_TABLE . "
		WHERE portal_link = $bl_id
		ORDER BY user_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not get link from user portal menu', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$user = $row['user_id'];

		$sql_deletes = "DELETE FROM " . USER_PORTAL_LINKS_TABLE . "
				WHERE portal_link = $bl_id
				AND user_id = $user";
		if ( !$result_deletes = $db->sql_query($sql_deletes) )
		{
			message_die(GENERAL_ERROR, 'Could not delete link from user portal menu', '', __LINE__, __FILE__, $sql_deletes);
		}

		reorder_menu_links('portal', $user);
	}

	$db->sql_freeresult($result);

	$sql = "DELETE FROM " . BOARD_LINKS_TABLE . "
		WHERE bl_id = $bl_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not delete board menu link', '', __LINE__, __FILE__, $sql);
	}

	$sql = "DELETE FROM " . BOARD_MENU_MERGE_TABLE . "
		WHERE link_id = $bl_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not delete portal menu link merge', '', __LINE__, __FILE__, $sql);
	}

	$manage_links = TRUE;
}
else if ( isset($HTTP_POST_VARS['delete_cat']) || isset($HTTP_GET_VARS['delete_cat']) && $userdata['user_level'] == ADMIN )
{
	$cat_id = intval($HTTP_GET_VARS['cat_id']);

	$sql_cat = "SELECT link_id FROM " . BOARD_MENU_MERGE_TABLE . "
		    WHERE cat_id = $cat_id";
	if ( !$result_cat = $db->sql_query($sql_cat) )
	{
		message_die(GENERAL_ERROR, 'Could not delete menu category from users table', '', __LINE__, __FILE__, $sql);
	}

	$links_count = $db->sql_numrows($result_cat);
	if ( $links_count != 0 )
	{
		while ( $row_cat = $db->sql_fetchrow($result_cat) )
		{
			$link_id = $row_cat['link_id'];

			$sql = "SELECT user_id FROM " . USER_PORTAL_LINKS_TABLE . "
				WHERE portal_link = $link_id
				ORDER BY user_id";
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not get link from user portal menu', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$user = $row['user_id'];

				$sql_deletes = "DELETE FROM " . USER_PORTAL_LINKS_TABLE . "
						WHERE portal_link = $link_id
						AND user_id = $user";
				if ( !$result_deletes = $db->sql_query($sql_deletes) )
				{
					message_die(GENERAL_ERROR, 'Could not delete link from user portal menu', '', __LINE__, __FILE__, $sql_deletes);
				}

				reorder_menu_links('portal', $user);
			}

			$db->sql_freeresult($result);
		}
	}
	$db->sql_freeresult($result_cat);

	$sql = "DELETE FROM " . BOARD_MENU_MERGE_TABLE . "
		WHERE cat_id = $cat_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not delete portal menu link merge', '', __LINE__, __FILE__, $sql);
	}

	$sql = "DELETE FROM " . BOARD_MENU_CAT_TABLE . "
		WHERE cat_id = $cat_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not delete portal menu category', '', __LINE__, __FILE__, $sql);
	}

	$manage_categories = TRUE;
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
else if ( isset($HTTP_POST_VARS['edit_cat']) || isset($HTTP_GET_VARS['edit_cat']) && $userdata['user_level'] == ADMIN )
{
	$cat_id = intval($HTTP_GET_VARS['cat_id']);

	$sql = "SELECT * FROM " . BOARD_MENU_CAT_TABLE . "
		WHERE cat_id = $cat_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu category', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$catname = $row['cat_name'];
		$show_catname = $row['show_cat_name'];
		$show_seperator = $row['show_seperator'];
	}
	$db->sql_freeresult($result);

	$cat_names = get_menu_cat_names();
	$cat_names = str_replace('value="'.$catname.'">', 'value="'.$catname.'" selected="selected">', $cat_names);

	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_categories_edit.tpl')
	);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_manage_categories'],

		'L_CAT_NAME' => $lang['Cat_name'],
		'L_SHOW_CAT_NAME' => $lang['Cat_name'],
		'L_SHOW_SEPERATOR' => $lang['Cat_name'],
		'L_SUBMIT' => $lang['Submit'],
		'L_PREVIOUS' => $lang['Previous'],

		'CATNAME' => $cat_names,
		'L_SHOW_CATNAME' => $lang['Bl_show_catname'],
		'L_SHOW_SEPERATOR' => $lang['Bl_show_seperator'],
		'S_SHOW_CATNAME' => ( $show_catname == TRUE ) ? 'checked="checked"' : '',
		'S_SHOW_SEPERATOR' => ( $show_seperator == TRUE ) ? 'checked="checked"' : '',

		'CAT_ID' => $cat_id,

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
		$board_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

		$saved_link = $row['bl_id'];

		$board_menu_links_user[] = $board_menu_links;
		$board_menu_links_check[] = '<input type="checkbox" name="bl_id[]" value="'.$saved_link.'" checked="checked" />';
	}
	$db->sql_freeresult($result);

	$sql_access = get_bllink_access();

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
		$board_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

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

	// Prepare portal menu links
	$sql = "SELECT portal_link FROM " . USER_PORTAL_LINKS_TABLE . "
		WHERE user_id = " . $userdata['user_id'] . "
		ORDER BY portal_sort DESC";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read portal menu for user', '', __LINE__, __FILE__, $sql);
	}
	$user_links_count = $db->sql_numrows($result);

	while( $row = $db->sql_fetchrow($result) )
	{
		$pl_links[] = $row['portal_link'];
	}
	$db->sql_freeresult($result);

	$sql_where = '';
	$sql_order = '';
	$sql_order_blid = '';

	if ( $user_links_count == 0 )
	{
		$sql_order_blid = 'ORDER BY c.cat_sort, l.bl_psort';
	}
	else
	{
		$sql_order = 'ORDER BY c.cat_sort';

		for ( $i = 0; $i < count($pl_links); $i++ )
		{
			$sql_order .= ', l.bl_id = '.$pl_links[$i];
		}

		$sql_order .= ', bl_psort';
	}

	$sql_access = get_bllink_access();

	$sql_extra = ( $sql_access == '' ) ? ' WHERE' : ' AND';

	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . " l, " . BOARD_MENU_MERGE_TABLE . " m, " . BOARD_MENU_CAT_TABLE . " c
		$sql_access
		$sql_extra m.link_id = l.bl_id
		AND m.cat_id = c.cat_id
		$sql_order $sql_order_blid";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read portal menu for user', '', __LINE__, __FILE__, $sql);
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

		$portal_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$portal_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$portal_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';
		$portal_menu_links .= ' <span class="gensmall">('.$lang[$row['cat_name']].')</span>';

		$saved_plink = $row['bl_id'];
		$user_plink = ( in_array($saved_plink, $pl_links) ) ? 'checked="checked"' : '';

		$template->assign_block_vars('portal_links_row', array(
			'BL_MENU_LINKS' => $portal_menu_links,
			'BL_CHECK' => ( $row['bl_fix'] == 0 ) ? '<input type="checkbox" name="pl_id[]" value="'.$saved_plink.'" '.$user_plink.' />' : '<input type="hidden" name="pl_id[]" value="'.$saved_plink.'" checked="checked" />'.$lang['Bl_fix'])
		);
	}
	$db->sql_freeresult($result);

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
		$board_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

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

	// Prepare board menu links
	$sql = "SELECT l.*, c.*, m.* FROM " . USER_PORTAL_LINKS_TABLE . " ug, " . BOARD_LINKS_TABLE . " l, " . BOARD_MENU_CAT_TABLE . " c, " . BOARD_MENU_MERGE_TABLE . " m
		WHERE ug.user_id = " . $userdata['user_id'] . "
		AND ug.portal_link = l.bl_id
		AND m.link_id = l.bl_id
		AND m.cat_id = c.cat_id
		ORDER BY c.cat_sort, ug.portal_sort";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read portal menu for user', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		if (substr($row['pl_link'],0,10) != 'javascript')
		{
			$phpext = '.'.$phpEx;
			$sidext = ( $row['bl_parameter'] != '' ) ? '&amp;sid='.$userdata['session_id'] : '?sid='.$userdata['session_id'];
		}
		else
		{
			$phpext = '';
			$sidext = '';
		}

		$portal_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$portal_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$portal_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';
		$portal_menu_links .= ' <span class="gensmall">('.$lang[$row['cat_name']].')</span>';

		$pl_id = $row['bl_id'];
		$template->assign_block_vars('sort_portal_row', array(
			'L_BL_UP' => $lang['Bl_moveup'],
			'L_BL_DOWN' => $lang['Bl_movedown'],

			'BL_LINK' => $portal_menu_links,

			'U_BL_UP' => append_sid("board_menu_manager.$phpEx?movep=-1&amp;pl_id=$pl_id"),
			'U_BL_DOWN' => append_sid("board_menu_manager.$phpEx?movep=1&amp;pl_id=$pl_id"))
		);
	}
	$db->sql_freeresult($result);

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $sort_cat && $userdata['user_level'] == ADMIN )
{
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_categories_sort.tpl')
	);

	$sql = "SELECT * FROM " . BOARD_MENU_CAT_TABLE . "
		ORDER BY cat_sort, cat_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu categories', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];
		$template->assign_block_vars('sort_cat_row', array(
			'L_CAT_UP' => $lang['Bl_moveup'],
			'L_CAT_DOWN' => $lang['Bl_movedown'],

			'CAT_NAME' => $lang[$cat_name],

			'U_CAT_UP' => append_sid("board_menu_manager.$phpEx?move_cat=-1&amp;cat_id=$cat_id"),
			'U_CAT_DOWN' => append_sid("board_menu_manager.$phpEx?move_cat=1&amp;cat_id=$cat_id"))
		);
	}
	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_sort_cat'],
		'L_BOARD_MENU_MANAGER' => $lang['Board_menu_manager'],

		'L_CAT_NAME' => $lang['Cat_name'],


		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

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
		$board_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

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

	// Set default sorting for portal menu links
	$sql = "SELECT bl_psort FROM " . BOARD_LINKS_TABLE . "
		ORDER BY bl_psort DESC
		LIMIT 1";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu for default sorting', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$sort_pcheck = $row['bl_psort'];
	}
	$db->sql_freeresult($result);

	if ( $sort_pcheck == '' )
	{
		$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
			ORDER BY bl_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not save portal menu default sorting', '', __LINE__, __FILE__, $sql);
		}

		$i = 10;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql2 = "UPDATE " . BOARD_LINKS_TABLE . " SET bl_psort = $i
				 WHERE bl_id = " . $row['bl_id'];
			if ( !$result2 = $db->sql_query($sql2) )
			{
				message_die(GENERAL_ERROR, 'Could not save portal menu default sorting', '', __LINE__, __FILE__, $sql);
			}
			$i += 10;
		}
		$db->sql_freeresult($result);
	}

	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . " l, " . BOARD_MENU_MERGE_TABLE . " m, " . BOARD_MENU_CAT_TABLE . " c
		WHERE m.link_id = l.bl_id
		AND c.cat_id = m.cat_id
		ORDER BY c.cat_sort, l.bl_psort";
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

		$portal_menu_links = ( $row['bl_img'] != '' ) ? '<img src="'.get_bl_theme().$row['bl_img'].'" border="0" />&nbsp;' : '';
		$portal_menu_links .= '<a href="'.$row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
		$portal_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';
		$portal_menu_links .= ' <span class="gensmall">('.$lang[$row['cat_name']].')</span>';

		$pl_id = $row['bl_id'];
		$template->assign_block_vars('sort_portal_row', array(
			'L_BL_UP' => $lang['Bl_moveup'],
			'L_BL_DOWN' => $lang['Bl_movedown'],

			'BL_LINK' => $portal_menu_links,

			'U_BL_UP' => append_sid("board_menu_manager.$phpEx?move_pdefault=-15&amp;pl_id=$pl_id"),
			'U_BL_DOWN' => append_sid("board_menu_manager.$phpEx?move_pdefault=15&amp;pl_id=$pl_id"))
		);
	}
	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_default_sort_links'],
		'L_BOARD_MENU_MANAGER' => $lang['Board_menu_manager'],

		'L_BL_LINK' => $lang['Bl_link'],
		'L_PL_LINK' => $lang['Bl_plink'],


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

	// Count portal menu links
	$sql = "SELECT portal_link, count(user_id) as total FROM " . USER_PORTAL_LINKS_TABLE . "
		GROUP BY portal_link";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not count used board links', '', __LINE__, __FILE__, $sql);
	}

	$used_portal_links = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$used_portal_links[$row['portal_link']] = $row['total'];
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
		$board_menu_links .= '" title="'.$lang[$row['bl_name']].'">'.$lang[$row['bl_name']].'</a>';

		$board_link_use_count = sprintf($lang['Bl_board_link_used'], intval($used_board_links[$bl_id]));
		$portal_link_use_count = sprintf($lang['Bl_portal_link_used'], intval($used_portal_links[$bl_id]));

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
			'BL_PORTAL_LINK_USED' => $portal_link_use_count,
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

	if ($portal_user_links != '')
	{
		$template->assign_block_vars('portal_link_used', array(
			'L_PORTAL_LINK_USED' => $lang['Bl_portal_link_used_user'],
			'PORTAL_LINK_USER' => $portal_user_links)
		);
	}
	
	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $merge && $userdata['user_level'] == ADMIN )
{
	if ( $cat_id == '' )
	{
		$cat_id = ( isset($HTTP_POST_VARS['cat_id']) ) ? intval($HTTP_POST_VARS['cat_id']) : intval($HTTP_GET_VARS['cat_id']);
	}

	$sql = "SELECT * FROM " . BOARD_MENU_CAT_TABLE . "
		WHERE cat_id = $cat_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read category data', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$catname = $lang[$row['cat_name']];
	}
	$db->sql_freeresult($result);

	// Load Page Header
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_merge.tpl')
	);

	$sql = "SELECT l.bl_id, l.bl_name, l.bl_fix FROM " . BOARD_MENU_MERGE_TABLE . " m, " . BOARD_LINKS_TABLE . " l
		WHERE m.cat_id = $cat_id
		AND m.link_id = l.bl_id
		ORDER BY l.bl_psort";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read joined links', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$bl_id = $row['bl_id'];
		$bl_name = $lang[$row['bl_name']];

		$template->assign_block_vars('linkrow', array(
			'L_BL_FIX' => ( $row['bl_fix'] == 1 ) ? $lang['Bl_fix_no'] : $lang['Bl_fix_yes'],
			'L_BL_REMOVE' => $lang['Bl_remove'],

			'BL_LINK' => $bl_name . (( $row['bl_fix'] == 1 ) ? '&nbsp;&nbsp;&nbsp;<span class="gensmall">('.$lang['Bl_fix'].')</span>' : ''),

			'U_BL_FIX' => ( $row['bl_fix'] == 1 ) ? append_sid("board_menu_manager.$phpEx?fix_links=-1&amp;bl_id=$bl_id&amp;cat_id=$cat_id") : append_sid("board_menu_manager.$phpEx?fix_links=1&amp;bl_id=$bl_id&amp;cat_id=$cat_id"),
			'U_BL_REMOVE' => append_sid("board_menu_manager.$phpEx?remove_link=1&amp;bl_id=$bl_id&amp;cat_id=$cat_id"))
		);
	}
	$db->sql_freeresult($result);

	$sql = "SELECT * FROM " . BOARD_MENU_MERGE_TABLE;
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read joined links', '', __LINE__, __FILE__, $sql);
	}

	$joined = '';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$joined .= ( $joined == '' ) ? $row['link_id'] : ', '.$row['link_id'];
	}
	$db->sql_freeresult($result);

	$joined_links = ( $joined != '' ) ? ' WHERE bl_id NOT IN ('.$joined.')' : '';

	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
		$joined_links
		ORDER BY bl_psort";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read joined links', '', __LINE__, __FILE__, $sql);
	}

	$bl_names = '<select name="bl_id">';
	while ( $row = $db->sql_fetchrow($result) )
	{
		$bl_names .= '<option value="'.($row['bl_id']).'">'.($lang[$row['bl_name']]).'</option>';
	}
	$bl_names .= '</select>';

	if ( $count = $db->sql_numrows($result) )
	{
		$template->assign_block_vars('bl_names_on', array());

		$template->assign_vars(array(
			'L_BL_NAME' => $lang['Bl_set'],
			'BL_NAME' => $bl_names)
		);
	}

	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $catname.' - '.$lang['Links'],
		'L_SUBMIT' => $lang['Submit'],
		'L_PREVIOUS' => $lang['Previous'],

		'CAT_ID' => $cat_id,
		
		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $manage_categories && $userdata['user_level'] == ADMIN )
{
	// Load Page Header
	$page_title = $lang['Board_menu_manager'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'board_menu_categories_admin.tpl'));

	$template->assign_vars(array(
		'L_PAGE_TITLE' => $page_title,
		'L_WELCOME' => $lang['Board_manager_welcome'],
		'L_MANAGER_EXPLAIN' => $lang['Board_manager_manage_categories'],
		'L_BOARD_MENU_MANAGER' => $lang['Board_menu_manager'],

		'L_CAT_NAME' => $lang['Cat_name'],
		'L_SHOW_CATNAME' => $lang['Bl_show_catname'],
		'L_SHOW_SEPERATOR' => $lang['Bl_show_seperator'],

		'L_SUBMIT' => $lang['Submit'],

		'CATNAME' => get_menu_cat_names(),

		'S_ACTION' => append_sid("board_menu_manager.$phpEx"))
	);

	// Get saved Board Menu Categories
	$sql = "SELECT * FROM " . BOARD_MENU_CAT_TABLE . "
		ORDER BY cat_sort, cat_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read board menu categories', '', __LINE__, __FILE__, $sql);
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$cat_id = $row['cat_id'];
		$cat_name = $row['cat_name'];

		$template->assign_block_vars('menucatrow', array(
			'L_BL_MERGE' => $lang['Board_manager_merge_cat_links'],
			'L_BL_EDIT' => $lang['Update'],
			'L_BL_DELETE' => $lang['Delete'],

			'BL_CAT' => $lang[$cat_name],

			'U_BL_MERGE' => append_sid("board_menu_manager.$phpEx?merge=1&amp;cat_id=$cat_id"),
			'U_BL_EDIT' => append_sid("board_menu_manager.$phpEx?edit_cat=1&amp;cat_id=$cat_id"),
			'U_BL_DELETE' => append_sid("board_menu_manager.$phpEx?delete_cat=1&amp;cat_id=$cat_id"))
		);
	}
	$db->sql_freeresult($result);
	
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
		WHERE config_name IN ('bl_seperator', 'bl_seperator_content', 'bl_break', 'bl_fix_sort')";
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
		'L_BL_FIX_LINKS' => $lang['Bl_fix_links'],
		'L_BL_FIX_SORT' => $lang['Bl_fix_sort'],
		'L_SUBMIT' => $lang['Submit'],
		'L_BOARD_MANAGER' => $lang['Board_menu_manager'],

		'BL_SEPERATOR' => ( $bl['bl_seperator'] == 1 ) ? 'checked="checked"' : '',
		'BL_SEPERATOR_CONTENT' => $bl['bl_seperator_content'],
		'BL_BREAK' => $bl['bl_break'],
		'BL_FIX_SORT' => ( $bl['bl_fix_sort'] == TRUE ) ? 'checked="checked"' : '',

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
			'L_MANAGE_CATEGORIES' => $lang['Board_manager_manage_categories'],
			'L_SORT_CAT' => $lang['Board_manager_sort_cat'],
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
	$db->sql_freeresult($result);
	
	$sql = "SELECT * FROM " . USER_PORTAL_LINKS_TABLE . "
		WHERE user_id = " . $userdata['user_id'];
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not check for existing portal menu links', '', __LINE__, __FILE__, $sql);
	}
	$count_portal_menu_links = $db->sql_numrows($result);
	$db->sql_freeresult($result);

	if ( $count_board_menu_links != 0 || $count_portal_menu_links != 0 )
	{
		$template->assign_block_vars('switch_sorting_on', array());
	}

	$template->pparse('body');
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>