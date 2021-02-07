<?php
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management
//

// Set variables
$bl_id = ( isset($HTTP_GET_VARS['bl_id']) ) ? intval($HTTP_GET_VARS['bl_id']) : 0;
$reset_bl = ( isset($HTTP_GET_VARS['reset_bl']) ) ? intval($HTTP_GET_VARS['reset_bl']) : 0;
$reset_all = ( isset($HTTP_GET_VARS['reset_all']) ) ? htmlspecialchars($HTTP_GET_VARS['reset_all']) : '';

// Count the click on a named link
if ( $bl_id )
{
	if ( $userdata['user_level'] != ADMIN && $userdata['user_id'] != ANONYMOUS)
	{
		$sql = "UPDATE " . BOARD_LINKS_TABLE . "
			SET bl_click_counter = bl_click_counter + 1
			WHERE bl_id = $bl_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not count this click', '', __LINE__, __FILE__, $sql);
		}
	}

	$sql = "SELECT * FROM " . BOARD_LINKS_TABLE . "
		WHERE bl_id = $bl_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not get link data', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$row['bl_parameter'] = str_replace('&amp;', '&', $row['bl_parameter']);
		$phpext = '.'.$phpEx;
		$sidext = ( $row['bl_parameter'] != '' ) ? '&amp;sid='.$userdata['session_id'] : '?sid='.$userdata['session_id'];
		$board_menu_link = "http://".$HTTP_SERVER_VARS['HTTP_HOST'].dirname($HTTP_SERVER_VARS['PHP_SELF']).(($board_config['script_path'] == '/') ? '' : '/');
		$board_menu_link .= $row['bl_link'].$phpext.(( $row['bl_parameter'] != '') ? '?'.$row['bl_parameter'] : '').$sidext;
	}
	$db->sql_freeresult($result);

	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".$board_menu_link);
	exit;
}

// Reset one counter
if ( $reset_bl )
{
	$sql = "UPDATE " . BOARD_LINKS_TABLE . "
		SET bl_click_counter = 0
		WHERE bl_id = $reset_bl";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not count this click', '', __LINE__, __FILE__, $sql);
	}
}

// Reset all counter
if ( $reset_all )
{
	$sql = "UPDATE " . BOARD_LINKS_TABLE . "
		SET bl_click_counter = 0";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not count this click', '', __LINE__, __FILE__, $sql);
	}
}

$userlang = ( $userdata['user_lang'] ) ? $userdata['user_lang'] : $board_config['default_lang'];
include($phpbb_root_path . 'language/lang_' . $userlang . '/lang_board_menu.' . $phpEx );

$page_title = $lang['Board_manager_counter'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

$sql = "SELECT bl_id, bl_link, bl_name, bl_click_counter FROM " . BOARD_LINKS_TABLE . "
	ORDER BY bl_dsort";
if ( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Could not read board link count data', '', __LINE__, __FILE__, $sql);
}

$template->set_filenames(array(
	'body' => 'bmm_link_body.tpl')
);

$template->assign_vars(array(
	'L_BOARD_LINK_COUNTER' => $page_title,
	'L_BOARD_LINK' => $lang['Bl_name'],
	'L_CLICKS' => $lang['Bl_clicks'],
	'L_RESET' => $lang['Reset'],

	'U_RESET_ALL' => append_sid("bmm_link.$phpEx?reset_all=1"))
);

while ( $row = $db->sql_fetchrow($result) )
{
	if (substr($row['bl_link'],0,10) != 'javascript')
	{
		$template->assign_block_vars('board_links_countrow', array(
			'BOARD_LINK_NAME' => $lang[$row['bl_name']],
			'BOARD_LINK_CLICKS' => intval($row['bl_click_counter']),

			'U_RESET' => append_sid("bmm_link.$phpEx?reset_bl=".$row['bl_id']))
		);
	}
}
$db->sql_freeresult($result);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>