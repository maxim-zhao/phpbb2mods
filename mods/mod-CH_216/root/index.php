<?php
//
//	file: index.php
//	author: ptirhiik
//	begin: 25/08/2004
//	version: 1.6.3 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'index';
include($phpbb_root_path . 'common.'.$phpEx);

include($config->url('includes/class_forums'));
include($config->url('includes/class_topics'));
include($config->url('includes/class_stats'));

// read parms
$forum_id = _read(POST_FORUM_URL, TYPE_INT);
$mark_allowed = array('forums' => POST_FORUM_URL, 'topics' => POST_TOPIC_URL);
$mark = _read('mark', TYPE_NO_HTML, '', array('' => '') + $mark_allowed);

// read forums
$forums = new forums();
$forums->read();
//
// Start session management
//
$userdata = session_pagestart($user_ip, empty($forum_id) ? PAGE_INDEX : $forum_id);
$user->set($requester, array('index', 'class_forums', 'class_topics', 'class_stats'));
//
// End session management
//

// init objects
$user->get_cache(array(POST_FORUM_URL, POST_FORUM_URL . 'jbox'));

// check user access
if ( $forum_id && !$user->auth(POST_FORUM_URL, 'auth_view', $forum_id) )
{
	if ( !$user->data['session_logged_in'] )
	{
		redirect($config->url('login', '', true), $config->url($requester, array(POST_FORUM_URL => $forum_id), true));
	}
	message_return('Forum_not_exist');
}

// link forum type
if ( $forums->data[$forum_id]['forum_type'] == POST_LINK_URL )
{
	if ( empty($forums->data[$forum_id]['forum_link']) )
	{
		message_return('Not_Authorised');
	}
	if ( $forums->data[$forum_id]['forum_link_hit_count'] )
	{
		$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET forum_link_hit = forum_link_hit + 1
					WHERE forum_id = ' . $forum_id;
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}
	redirect($forums->data[$forum_id]['forum_link']);
}

// process mark actions
if ( $mark )
{
	$user->read_cookies($mark_allowed[$mark], $forum_id);
	$user->write_cookies();
	$msg = ($mark_allowed[$mark] == POST_FORUM_URL) ? 'Forums_marked_read' : 'Topics_marked_read';
	if ( $forum_id )
	{
		message_return($msg, 'Click_return_forum', $config->url($requester, array(POST_FORUM_URL => $forum_id), true));
	}
	else
	{
		message_return($msg);
	}
}

// actualize data (required for pruning action)
$forums->refresh($forum_id);

// forum prune
if ( $user->auth(POST_FORUM_URL, 'auth_mod', $forum_id) && $config->data['prune_enable'] )
{
	if ( ($forums->data[$forum_id]['prune_next'] < time()) && $forums->data[$forum_id]['prune_enable'] )
	{
		include($config->url('includes/class_resync'));
		$prune = new prune();
		$prune->forums_auto($forum_id);
		unset($prune);
	}
}

// Mozilla navigation bar
if ( !empty($forum_id) )
{
	$nav_links['top'] = array(
		'url' => $config->url($requester, '', true),
		'title' => $forums->data[$forum_id]['forum_name'],
	);
	$nav_links['up'] = array(
		'url' => $config->url($requester, array(POST_FORUM_URL => intval($forums->data[$forum_id]['forum_main'])), true),
		'title' => $forums->data[ intval($forums->data[$forum_id]['forum_main']) ]['forum_name'],
	);
}
//
// Start output of page
//
$page_title = empty($forum_id) ? $user->lang('Index') . ' - ' . $config->data['sitename'] : $user->lang('View_forum') . ' - ' . $user->lang($forums->data[$forum_id]['forum_name']);

// stats
$stats = new stats();
$stats->display($forum_id);
unset($stats);

// get topics for this forum (and section announces if asked)
$topics = new topics($requester);
$topics->read($forum_id);

// board announces
$board_topics = $topics->get_display(true, false);

// forum topics
$forum_topics = $topics->get_display(false, ($forums->data[$forum_id]['forum_type'] == POST_FORUM_URL));

// kill topics
unset($topics);

// display forums
$forums->display($forum_id);

// if nothing to display, send message
if ( empty($forum_topics) && !$forums->displayed )
{
	if ( empty($forum_id) && empty($board_topics) )
	{
		if ( !$user->data['session_logged_in'] )
		{
			redirect($config->url('login', '', true), $config->url($requester, '', true));
		}
		message_die(GENERAL_MESSAGE, $user->lang('No_forums'));
	}
	if ( !empty($forum_id) )
	{
		$parent = intval($forums->data[$forum_id]['forum_main']);
		$l_link = empty($parent) ? '' : 'Click_return_parent';
		$u_link = empty($parent) ? '' : $config->url($requester, array(POST_FORUM_URL => $parent), true);
		message_return('Cat_no_subs', $l_link, $u_link);
	}
}

// send to template
$template->assign_vars(array(
	'BOARD_TOPICS' => $board_topics,
	'FORUM_TOPICS' => $forum_topics,
	'U_MARK_READ' => $config->url($requester, array(POST_FORUM_URL => $forum_id, 'mark' => 'forums'), true),
	'L_MARK_READ' => $user->lang('Mark_all_forums'),
	'I_MARK_READ' => $user->img('forum_mark_read'),

	'FORUM_IMG' => $user->img('forum'),
	'FORUM_NEW_IMG' => $user->img('forum_new'),
	'FORUM_LOCKED_IMG' => $user->img('forum_locked'),
	'FORUM_LINK_IMG' => $user->img('link'),

	'FOLDER_IMG' => $user->img('folder'),
	'FOLDER_NEW_IMG' => $user->img('folder_new'),
	'FOLDER_HOT_IMG' => $user->img('folder_hot'),
	'FOLDER_LOCKED_IMG' => $user->img('folder_locked'),
	'FOLDER_OWN_IMG' => $user->img('folder_own'),
	'FOLDER_STICKY_IMG' => $user->img('folder_sticky'),
	'FOLDER_ANNOUNCE_IMG' => $user->img('folder_announce'),
	'FOLDER_CALENDAR_IMG' => $user->img('folder_calendar'),
	'FOLDER_MOVED_IMG' => $user->img('folder_moved'),

	'L_NO_NEW_POSTS' => $user->lang('No_new_posts'),
	'L_NEW_POSTS' => $user->lang('New_posts'),
	'L_FORUM_LOCKED' => $user->lang('Forum_is_locked'),
	'L_FORUM_LINK' => $user->lang('Link'),

	'L_TOPIC_MOVED' => $user->lang('Topic_Moved'),
	'L_TOPIC_HOT' => $user->lang('Hot_topic'),
	'L_TOPIC_LOCKED' => $user->lang('Topic_Locked'),
	'L_TOPIC_OWN' => $user->lang('Own_topic'),
	'L_STICKY' => $user->lang('Post_Sticky'),
	'L_ANNOUNCEMENT' => $user->lang('Post_Announcement'),
	'L_TOPIC_CALENDAR' => $user->lang('Topic_calendar'),

	'S_ACTION' => $config->url($requester, array(POST_FORUM_URL => $forum_id), true),
));
$template->set_switch('mark', $forums->displayed && $user->data['session_logged_in']);
$template->set_switch('forum_legend', $forums->data[$forum_id]['forum_type'] != POST_FORUM_URL);
$template->set_switch('board_topics_spacing', !empty($board_topics));
$template->set_switch('forums_spacing', $forums->displayed && !empty($forum_topics));
$template->set_switch('forum_topics_spacing', !empty($forum_topics));

// forum rules
$forums->display_rules($forum_id);

// display nav
$forums->display_nav($forum_id);

// jumpbox
make_jumpbox($requester, $forum_id, true);

// Generate the page
include($config->url('includes/page_header'));
$template->set_filenames(array('body' => 'index_body.tpl'));
$template->pparse('body');
include($config->url('includes/page_tail'));

?>