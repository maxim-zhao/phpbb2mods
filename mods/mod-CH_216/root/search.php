<?php
//
//	file: search.php
//	author: ptirhiik
//	begin: 10/12/2005
//	version: 1.6.3 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'search';
include($phpbb_root_path . 'common.'.$phpEx);

//
// This handles the simple windowed user search functions called from various other scripts
//
$mode = _read('mode', TYPE_NO_HTML, '', array_flip(array('results', 'searchuser')));
if ( $mode == 'searchuser' )
{
	$requester = 'search_username';
	include($config->url('includes/functions_search'));
	$userdata = session_pagestart($user_ip, PAGE_SEARCH);
	$user->set($requester, array('search_username'));
	if ( $user->data['session_is_bot'] )
	{
		message_die(GENERAL_MESSAGE, 'Not_Authorised');
	}
	username_search(isset($HTTP_POST_VARS['search_username']) ? $HTTP_POST_VARS['search_username'] : '');
	exit;
}

//
// let's go with the real work now :)
//
include($config->url('includes/bbcode'));
include($config->url('includes/functions_post'));
include($config->url('includes/class_forums'));
include($config->url('includes/class_topics'));
include($config->url('includes/class_posts'));
include($config->url('includes/class_message'));
include($config->url('includes/class_search'));

// read forums
$forums = new forums();
$forums->read();

// Search ID Limiter, decrease this value if you experience further timeout problems with searching forums
$limiter = 1000;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_SEARCH);
$user->set($requester, array('search', 'class_forum', 'class_topics', 'class_posts', 'viewprofile', 'class_fields'));
//
// End session management
//

// no access for bots
if ( $user->data['session_is_bot'] )
{
	message_return('Not_Authorised');
}

// flood control
if ( intval($config->data['search_flood_interval']) && _read('search_keywords') )
{
	$sql = 'SELECT search_id
				FROM ' . SEARCH_TABLE . '
				WHERE session_id = \'' . $db->sql_escape_string($user->data['session_id']) . '\'
					AND search_time >= ' . (time() - intval($config->data['search_flood_interval'])) . '
				LIMIT 1';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$flood = $db->sql_numrows($result);
	$db->sql_freeresult($result);
	if ( !$flood && ($max_concur = intval($config->data['search_max_concur'])) && ($time_concur = intval($config->data['search_time_concur'])) )
	{
		$sql = 'SELECT COUNT(search_id) as count_search_id
					FROM ' . SEARCH_TABLE . '
					WHERE search_time >= ' . (time() - $time_concur);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$flood = ($row = $db->sql_fetchrow($result)) ? intval($row['count_search_id']) > $max_concur : false;
		$db->sql_freeresult($result);
	}
	if ( $flood )
	{
		message_return('Search_Flood_Error');
	}
}

// get caches
$user->get_cache(array(POST_FORUM_URL, POST_FORUM_URL . 'jbox'));

// instantiate the search
if ( $config->data['fulltext_search'] )
{
	$search = new search_fulltext($requester);
}
else
{
	$search = new search_phpBB($requester);
}

// process
$search->read_parms();
switch ( $search->mode )
{
	case 'newposts':
	case 'egosearch':
	case 'unanswered':
		$user->read_cookies();
		$search->display_topics();
		break;

	case 'authors':
		$user->read_cookies();
		$search->display_authors();
		break;

	case 'keywords':
		$user->read_cookies();
		$search->display_keywords();
		break;

	default:
		$search->display_form();
		break;
}

// store parms
$total_match_count = $search->total_items;
$parms = array(
	'search_id' => isset($search->nav_parms['search_id']) ? $search->nav_parms['search_id'] : 0,
	'search_author' => isset($search->nav_parms['search_author']) ? $search->nav_parms['search_author'] : '',
	'ppage' => $search->ppage == $search->dft_ppage ? 0 : $search->ppage,
);

// kill search
unset($search);

// display
if ( $total_match_count )
{
	$template->assign_vars(array(
		'L_SEARCH_MATCHES' => sprintf($user->lang($total_match_count == 1 ? 'Found_search_match' : 'Found_search_matches'), $total_match_count),
	));
}

// navigation
$navigation = new navigation();
$navigation->add('Search', '', $requester, $parms);
$navigation->display();
unset($navigation);

$page_title = $user->lang('Search');
include($config->url('includes/page_header'));
$template->pparse('body');
include($config->url('includes/page_tail'));

?>