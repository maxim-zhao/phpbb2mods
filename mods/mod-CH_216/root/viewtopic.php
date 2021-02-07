<?php
//
//	file: viewtopic.php
//	author: ptirhiik
//	begin: 23/12/2005
//	version: 1.6.7 - 21/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'viewtopic';
include($phpbb_root_path . 'common.'.$phpEx);

include($config->url('includes/bbcode'));
include($config->url('includes/class_forums'));
include($config->url('includes/class_topics'));
include($config->url('includes/class_posts'));
include($config->url('includes/class_message'));

// plugs
if ( $config->plug_ins[$requester] )
{
	foreach ( $config->plug_ins[$requester] as $plug => $dummy )
	{
		if ( method_exists($config->plug_ins[$requester][$plug], 'start') )
		{
			$config->plug_ins[$requester][$plug]->start();
		}
	}
}

// available sorts
$posts = new posts($requester);
$posts->init();
$available_sorts = $posts->sort_fields;

// read forums
$forums = new forums();
$forums->read();

// get ids
$forum_id = 0;
$topic_id = _read(POST_TOPIC_URL, TYPE_INT);
$post_id = _read(POST_POST_URL, TYPE_INT);

// sort
$sort = _read('sort', TYPE_NO_HTML, '', $available_sorts);
$order = strtoupper(_read('postorder', TYPE_NO_HTML, '', array_flip(array('', 'asc', 'ASC', 'desc', 'DESC'))));
$postdays = max(0, _read('postdays', TYPE_INT));

// pagination
$start = max(0, _read('start', TYPE_INT));
$ppage = max(0, _read('ppage', TYPE_INT));

// actions
$view = $topic_id || $post_id ? _read('view', TYPE_NO_HTML, '', array_flip(array('', 'first', 'latest', 'newest', 'next', 'previous'))) : '';
$watch = _read('watch', TYPE_NO_HTML, '', array_flip(array('', 'topic')));
$unwatch = _read('unwatch', TYPE_NO_HTML, '', array_flip(array('', 'topic')));
$unmark = _read('unmark', TYPE_NO_HTML, '', array_flip(array('', 'topic', 'post')));

// fix actions
if ( empty($topic_id) )
{
	$watch = $unwatch = '';
}
if ( (($unmark == 'post') && empty($post_id)) || (($unmark == 'topic') && empty($topic_id)) )
{
	$unmark = '';
}

// prepare parms
$parms = array(
	'ppage' => $ppage,
	'start' => empty($post_id) ? $start : 0,
	'sort' => $sort,
	'postorder' => $order,
	'postdays' => $postdays,
);

// prepare for topic data reading
$posts->parms = $parms;
unset($parms);

// deal with actions : first try to grab the topic
$error_msg = '';
$session_started = false;

// get topic data
$posts->read_topic($topic_id, $post_id);
$forum_id = $posts->forum_id;
$topic_id = $posts->topic_id;

switch ( $view )
{
	case '':
		break;

	case 'first':
		if ( $topic_id && $post_id )
		{
			$SID = ($sid = _read_url('sid', TYPE_NO_HTML)) && preg_match('/^[A-Za-z0-9]*$/', $sid) ? 'sid=' . $sid : '';
			redirect($config->url($requester, array(POST_TOPIC_URL => intval($topic_id)), true));
		}
		break;

	case 'latest':
	case 'newest':
		if ( $topic_id )
		{
			// read session to get lang and cookies
			$userdata = session_pagestart($user_ip, empty($forum_id) ? PAGE_INDEX : $forum_id);
			$user->set($requester, array('viewtopic', 'viewprofile', 'class_forums', 'class_topics', 'class_posts', 'class_fields'));
			$session_started = true;
			$user->read_cookies();

			// move post id to the first unreaded or to the last of the topic
			$new_post_id = intval($posts->topic['topic_last_post_id']);
			if ( intval($user->cookies['unreads'][$topic_id]) )
			{
				$sql = 'SELECT post_id
							FROM ' . POSTS_TABLE . '
							WHERE topic_id = ' . intval($topic_id) . '
								AND post_time > ' . intval($user->cookies['unreads'][$topic_id]) . '
							ORDER BY post_time
							LIMIT 1';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				if ( $row = $db->sql_fetchrow($result) )
				{
					$new_post_id = intval($row['post_id']);
				}
				$db->sql_freeresult($result);
			}
			else if ( $view == 'newest' )
			{
				$l_link = $topic_id  ? 'Click_return_topic' : '';
				$u_link = $topic_id ? $config->url($requester, array(POST_TOPIC_URL => $topic_id), true) : '';
				message_return('No_new_posts_last_visit', $l_link, $u_link);
			}
			if ( !$post_id || ($new_post_id != $post_id) )
			{
				redirect($config->url($requester, array(POST_POST_URL => intval($new_post_id)), true, intval($new_post_id)));
			}
		}
		break;

	case 'next':
	case 'previous':
		if ( $topic_id )
		{
			$sql = 'SELECT topic_id
						FROM ' . TOPICS_TABLE . '
						WHERE forum_id = ' . intval($forum_id) . '
							AND topic_moved_id = 0
							AND topic_last_post_id ' . ($view == 'next' ? '> ' : '< ') . intval($posts->topic['topic_last_post_id']) . '
						ORDER BY topic_last_post_id' . ($view == 'next' ? '' : ' DESC') . '
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$new_topic_id = ($row = $db->sql_fetchrow($result)) ? intval($row['topic_id']) : 0;
			$db->sql_freeresult($result);
			if ( $new_topic_id )
			{
				$SID = ($sid = _read_url('sid', TYPE_NO_HTML)) && preg_match('/^[A-Za-z0-9]*$/', $sid) ? 'sid=' . $sid : '';
				redirect($config->url($requester, array(POST_TOPIC_URL => $new_topic_id), true));
			}
			else
			{
				// read session to get lang
				$userdata = session_pagestart($user_ip, empty($forum_id) ? PAGE_INDEX : $forum_id);
				$user->set($requester, array('viewtopic', 'viewprofile', 'class_forums', 'class_topics', 'class_posts', 'class_fields'));
				$session_started = true;

				$l_link = $topic_id  ? 'Click_return_topic' : '';
				$u_link = $topic_id ? $config->url($requester, array(POST_TOPIC_URL => $topic_id), true) : '';
				message_return($view == 'next' ? 'No_newer_topics' : 'No_older_topics', $l_link, $u_link);
			}
		}
		break;
}

// get post
$post_id = $posts->post_id;

//
// Start session management
//
if ( !$session_started )
{
	$userdata = session_pagestart($user_ip, empty($forum_id) ? PAGE_INDEX : $forum_id);
	$user->set($requester, array('viewtopic', 'viewprofile', 'class_forums', 'class_topics', 'class_posts', 'class_fields'));
}
//
// End session management
//

// highlight
$highlight = '';
if ( ($search_id = _read('search_id', TYPE_INT)) )
{
	$sql = 'SELECT search_array
				FROM ' . SEARCH_TABLE . '
				WHERE search_id = ' . intval($search_id) . '
					AND session_id = \'' . $user->data['session_id'] . '\'';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	if ( ($row = $db->sql_fetchrow($result)) )
	{
		$search_data = unserialize($row['search_array']);
		unset($row);
		if ( isset($search_data['hl']) && $search_data['hl'] )
		{
			$posts->set_highlight($search_data['hl']);
			$posts->parms['search_id'] = intval($search_id);
		}
		unset($search_data);
	}
	$db->sql_freeresult($result);
}

// an error occured ?
if ( empty($posts->topic) || !isset($forums->data[$forum_id]) || !empty($error_msg) )
{
	message_die(GENERAL_MESSAGE, empty($error_msg) ? 'Topic_post_not_exist' : $error_msg);
}

// deal with guests
if ( !$user->data['session_logged_in'] || $user->data['session_is_bot'] )
{
	$watch = $unwatch = '';
	if ( !$config->data['keep_unreads_guests'] || $user->data['session_is_bot'] )
	{
		$unmark = '';
	}
}

// get cache
$user->get_cache(array(POST_FORUM_URL, POST_FORUM_URL . 'jbox'));

// fix parms
$posts->get_parms();

// is the topic authorised ?
if ( !$user->auth(POST_FORUM_URL, 'auth_read', $forum_id) )
{
	if ( !$user->data['session_logged_in'] )
	{
		redirect($config->url('login', '', true), $config->url($requester, (empty($post_id) ? array(POST_TOPIC_URL => $topic_id) : array(POST_POST_URL => $post_id)) + $posts->parms + array('watch' => $watch, 'unwatch' => $unwatch, 'unmark' => $unmark), true));
	}
	message_return($user->auth(POST_FORUM_URL, 'auth_view', $forum_id) ? sprintf($user->lang('Sorry_auth_read'), $user->lang('Auth_Users_granted_access')) : 'Topic_post_not_exist');
}

// check/update watch status
$is_watching = false;
if ( $can_watch = ($user->data['session_logged_in'] && !$user->data['session_is_bot']) )
{
	$sql = 'SELECT notify_status
				FROM ' . TOPICS_WATCH_TABLE . '
				WHERE topic_id = ' . intval($topic_id) . '
					AND user_id = ' . intval($user->data['user_id']);
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$is_watching = ($row = $db->sql_fetchrow($result));
	$db->sql_freeresult($result);
	if ( $is_watching )
	{
		if ( $unwatch == 'topic' )
		{
			$sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . '
						WHERE user_id = ' . intval($user->data['user_id']) . '
							AND topic_id = ' . intval($topic_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$l_link = 'Click_return_topic';
			$u_link = $config->url($requester, (empty($post_id) ? array(POST_TOPIC_URL => $topic_id) : array(POST_POST_URL => $post_id)) + $posts->parms, true, $post_id);
			message_return('No_longer_watching', $l_link, $u_link);
		}

		// remove watch flag for this user & this topic
		else if ( intval($row['notify_status']) )
		{
			$sql = 'UPDATE ' . TOPICS_WATCH_TABLE . '
						SET notify_status = 0
						WHERE topic_id = ' . intval($topic_id) . '
							AND user_id = ' . intval($user->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	// not watching yet
	else if ( $watch == 'topic' )
	{
		$fields = array(
			'user_id' => $user->data['user_id'],
			'topic_id' => intval($topic_id),
			'notify_status' => 0,
		);
		$sql = 'INSERT INTO ' . TOPICS_WATCH_TABLE . '
					(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);

		$l_link = 'Click_return_topic';
		$u_link = $config->url($requester, (empty($post_id) ? array(POST_TOPIC_URL => $topic_id) : array(POST_POST_URL => $post_id)) + $posts->parms, true, $post_id);
		message_return('You_are_watching', $l_link, $u_link);
	}
}

// get cookies and cookies setup
$cookies_setup = $user->get_cookies_setup();

// unmark asked
if ( $unmark && $cookies_setup['keep_unreads'] )
{
	// get the last time read for the topic or the post
	$last_time_read = intval($posts->topic['topic_time']);

	// unmark from a post
	if ( ($unmark == 'post') && !empty($post_id) )
	{
		$sql = 'SELECT post_time
					FROM ' . POSTS_TABLE . '
					WHERE post_id = ' . intval($post_id);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		if ( !($row = $db->sql_fetchrow($result)) )
		{
			message_return('No_such_post', 'Click_return_forum', $config->url(INDEX, array(POST_FORUM_URL => $forum_id), true));
		}
		$db->sql_freeresult($result);
		$last_time_read = intval($row['post_time']);
	}

	$user->read_cookies();
	$user->cookies['unreads'][$topic_id] = $last_time_read - 1;
	$user->write_cookies();

	// return to the forum
	message_return('Topic_unmarked_read', 'Click_return_forum', $config->url(INDEX, array(POST_FORUM_URL => $forum_id), true));
}

// mark the topic readed
$posts->topic_last_read = $user->read_cookies(POST_POST_URL, $topic_id);
$user->write_cookies();

// increment the number of view
$sql = 'UPDATE ' . TOPICS_TABLE . '
			SET topic_views = topic_views + 1
			WHERE topic_id = ' . intval($topic_id);
$db->sql_query($sql, false, __LINE__, __FILE__);

// add all required user fields to pool
$user->pool_fields = array_merge($user->pool_fields, array(
	'user_posts',
	'user_from',
	'user_interests',
	'user_website',
	'user_email',
	'user_icq',
	'user_aim',
	'user_yim',
	'user_regdate',
	'user_msnm',
	'user_viewemail',
	'user_rank',
	'user_sig',
	'user_sig_bbcode_uid',
	'user_avatar',
	'user_avatar_type',
	'user_allowavatar',
	'user_allowsmile',
));

// now we can read and display the posts
$posts->read();
$posts->display();

// lock status
$forum_locked = ($forums->data[$forum_id]['forum_status'] == FORUM_LOCKED);
$topic_locked = ($posts->topic['topic_status'] == TOPIC_LOCKED) || $forum_locked;

// display poll
if ( !empty($posts->topic['topic_vote']) )
{
	$sql = 'SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vr.vote_option_id, vr.vote_option_text, vr.vote_result
				FROM ' . VOTE_DESC_TABLE . ' vd, ' . VOTE_RESULTS_TABLE . ' vr
				WHERE vd.topic_id = ' . intval($topic_id) . '
					AND vr.vote_id = vd.vote_id
					ORDER BY vr.vote_option_id';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$vote_info = array();
	$vote_results_sum = 0;
	while ( $row = $db->sql_fetchrow($result) )
	{
		$vote_results_sum += intval($row['vote_result']);
		$vote_info[] = $row;
	}
	$db->sql_freeresult($result);

	if ( $count_vote_info = count($vote_info) )
	{
		$vote_id = $vote_info[0]['vote_id'];
		$vote_title = $vote_info[0]['vote_text'];

		$sql = 'SELECT vote_id
					FROM ' . VOTE_USERS_TABLE . '
					WHERE vote_id = ' . intval($vote_id) . '
						AND vote_user_id = ' . intval($user->data['user_id']) . '
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$user_voted = ($row = $db->sql_fetchrow($result)) ? true : false;
		$db->sql_freeresult($result);

		$view_result = (_read('vote', TYPE_NO_HTML) == 'viewresult');
		$poll_expired = intval($vote_info[0]['vote_length']) ? (intval($vote_info[0]['vote_start']) + intval($vote_info[0]['vote_length'])) < time() : false;

		// view results
		if ( $topic_locked || $user_voted || $view_result || $poll_expired || !$user->auth(POST_FORUM_URL, 'auth_vote', $forum_id) )
		{
			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);
			for ( $i = 0; $i < $count_vote_info; $i++ )
			{
				$vote_percent = intval($vote_info[$i]['vote_result']) / max($vote_results_sum, 1);
				$vote_graphic_length = round($vote_percent * $config->data['vote_graphic_length']);

				$vote_graphic = ($i % $vote_graphic_max);
				$vote_graphic_img_left = $images['voting_left'][$vote_graphic];
				$vote_graphic_img = $images['voting_graphic'][$vote_graphic];
				$vote_graphic_img_right = $images['voting_right'][$vote_graphic];

				$template->assign_block_vars('poll_option', array(
					'POLL_OPTION_CAPTION' => _censor($vote_info[$i]['vote_option_text']),
					'POLL_OPTION_RESULT' => intval($vote_info[$i]['vote_result']),
					'POLL_OPTION_PERCENT' => sprintf('%.1d%%', ($vote_percent * 100)),

					'POLL_OPTION_IMG' => $vote_graphic_img,
					'POLL_OPTION_IMG_LEFT' => $vote_graphic_img_left,
					'POLL_OPTION_IMG_RIGHT' => $vote_graphic_img_right,
					'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length,
				));
			}
			$template->assign_vars(array(
				'L_TOTAL_VOTES' => $user->lang('Total_votes'),
				'TOTAL_VOTES' => $vote_results_sum,

				'POLL_DISPLAY' => $template->include_file('viewtopic_poll_result.tpl'),
			));
		}

		// accept vote
		else
		{
			for ( $i = 0; $i < $count_vote_info; $i++ )
			{
				$template->assign_block_vars("poll_option", array(
					'POLL_OPTION_ID' => $vote_info[$i]['vote_option_id'],
					'POLL_OPTION_CAPTION' => _censor($vote_info[$i]['vote_option_text']),
				));
			}
			$template->assign_vars(array(
				'L_SUBMIT_VOTE' => $user->lang('Submit_vote'),
				'I_SUBMIT' => $user->img('cmd_submit'),
				'S_SUBMIT' => $user->lang('cmd_submit'),
				'U_VIEW_RESULTS' => $config->url('viewtopic', array(POST_TOPIC_URL => $topic_id, 'vote' => 'viewresult') + $posts->parms, true),
				'L_VIEW_RESULTS' => $user->lang('View_results'),
				'I_VIEW_RESULTS' => $user->img('cmd_view'),
				'S_POLL_ACTION' => $config->url(POSTING, array('mode' => 'vote', POST_TOPIC_URL => $topic_id), true),

				'POLL_DISPLAY' => $template->include_file('viewtopic_poll_ballot.tpl'),
			));
			display_buttons(array(
				'submit' => array('txt' => 'Submit_vote', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
			));
			_hide(POST_TOPIC_URL, $topic_id);
			_hide('mode', 'vote');
			_hide('sid', $user->data['session_id']);
			_hide_set();
		}

		// display the poll
		$template->assign_vars(array(
			'POLL' => $user->lang('Poll'),
			'POLL_QUESTION' => _censor($vote_info[0]['vote_text']),
		));
	}
}

// moderator actions
if ( $user->auth(POST_FORUM_URL, 'auth_mod', $forum_id) )
{
	// moderator actions details display
	$moderator_actions = array(
		'delete' => array('txt' => 'Delete_topic', 'img' => 'topic_mod_delete'),
		'move' => array('txt' => 'Move_topic', 'img' => 'topic_mod_move'),
		'lock' => array('txt' => 'Lock_topic', 'img' => 'topic_mod_lock', 'cond' => $posts->topic['topic_status'] != TOPIC_LOCKED),
		'unlock' => array('txt' => 'Unlock_topic', 'img' => 'topic_mod_unlock', 'cond' => $posts->topic['topic_status'] == TOPIC_LOCKED),
		'split' => array('txt' => 'Split_topic', 'img' => 'topic_mod_split'),
	);
	foreach ( $moderator_actions as $mode => $data )
	{
		if ( !isset($data['cond']) || $data['cond'] )
		{
			$template->assign_block_vars('modcp', array(
				'U_ACTION' => $config->url('modcp', array('mode' => $mode, POST_TOPIC_URL => $topic_id, 'sid' => $user->data['session_id']), true),
				'L_ACTION' => $user->lang($data['txt']),
				'I_ACTION' => $user->img($data['img']),
			));
		}
	}
}

// bottom select
$template->assign_vars(array(
	'L_DISPLAY_POSTS' => $user->lang('Display_posts'),
	'L_SORT_BY' => $user->lang('Sort_by'),
	'L_GO' => $user->lang('Go'),
	'I_GO' => $user->img('cmd_mini_submit'),
));
$lists = array(
	'postdays' => array(0 => 'All_Posts', 1 => '1_Day', 7 => '7_Days', 14 => '2_Weeks', 30 => '1_Month', 90 => '3_Months', 180 => '6_Months', 364 =>'1_Year'),
	'sort' => &$available_sorts,
	'postorder' => array('ASC' => 'Sort_Ascending', 'DESC' => 'Sort_Descending'),
);
$parms = $posts->parms;
$parms['sort'] = $posts->sort;
$parms['postorder'] = $posts->order;
foreach ( $lists as $parm => $list )
{
	$options[ strtoupper($parm) ] = '';
	foreach ( $list as $value => $desc )
	{
		$selected = isset($parms[$parm]) && ($parms[$parm] == $value) ? ' selected="selected"' : '';
		$options[ strtoupper($parm) ] .= '<option value="' . $value . '"' . $selected . '>' . $user->lang($desc) . '</option>';
	}
}
unset($parms);
$template->assign_vars($options);

// display topic header
$template->assign_vars(array(
	'L_AUTHOR' => $user->lang('Author'),
	'L_MESSAGE' => $user->lang('Message'),

	'TOPIC_TITLE' => _censor($posts->topic['topic_title']),
	'U_VIEW_TOPIC' => $config->url($requester, array(POST_TOPIC_URL => $topic_id) + $posts->parms, true),

	'U_NEW_TOPIC' => $config->url(POSTING, array('mode' => 'newtopic', POST_FORUM_URL => $forum_id), true),
	'L_NEW_TOPIC' => $forum_locked ? $user->lang('Forum_locked') : $user->lang('Post_new_topic'),
	'I_NEW_TOPIC' => $forum_locked ? $user->img('post_locked') : $user->img('post_new'),

	'U_REPLY_TOPIC' => $config->url(POSTING, array('mode' => 'reply', POST_TOPIC_URL => $topic_id), true),
	'L_REPLY_TOPIC' => $topic_locked ? $user->lang('Topic_locked') : $user->lang('Reply_to_topic'),
	'I_REPLY_TOPIC' => $topic_locked ? $user->img('reply_locked') : $user->img('reply_new'),

	'U_VIEW_PREVIOUS_TOPIC' => $config->url($requester, array(POST_TOPIC_URL => $topic_id, 'view' => 'previous'), true),
	'L_VIEW_PREVIOUS_TOPIC' => $user->lang('View_previous_topic'),
	'I_VIEW_PREVIOUS_TOPIC' => $user->img('topic_previous'),

	'U_VIEW_NEXT_TOPIC' => $config->url($requester, array(POST_TOPIC_URL => $topic_id, 'view' => 'next'), true),
	'L_VIEW_NEXT_TOPIC' => $user->lang('View_next_topic'),
	'I_VIEW_NEXT_TOPIC' => $user->img('topic_next'),

	'U_WATCH_TOPIC' => $config->url($requester, array(POST_TOPIC_URL => $topic_id, ($is_watching ? 'unwatch' : 'watch') => 'topic') + $posts->parms, true),
	'L_WATCH_TOPIC' => $user->lang($is_watching ? 'Stop_watching_topic' : 'Start_watching_topic'),
	'I_WATCH_TOPIC' => $user->img($is_watching ? 'topic_un_watch' : 'topic_watch'),

	'U_UNREAD_TOPIC' => $config->url($requester, array(POST_TOPIC_URL => $topic_id, 'unmark' => 'topic'), true),
	'L_UNREAD_TOPIC' => $user->lang('Topic_unmark_read'),
	'I_UNREAD_TOPIC' => $user->img('topic_unmark_read'),

	'S_POST_DAYS_ACTION' => $config->url($requester, array(POST_TOPIC_URL => $topic_id, 'start' => $start), true),
));
$template->set_switch('watch', $can_watch);
$template->set_switch('unread_topic', $cookies_setup['keep_unreads']);

// page title
$page_title = $user->lang('View_topic') . ' - ' . _censor($posts->topic['topic_title']);

// display nav
$forums->display_nav($forum_id);

// display pagination
$pagination = new pagination($requester, array(POST_TOPIC_URL => $topic_id) + $posts->parms);
$pagination->display('pagination', $posts->total_items, $posts->ppage, isset($posts->parms['start']) ? $posts->parms['start'] : 0, true, 'Posts_count');
unset($pagination);

// kill posts
unset($posts);

// display moderators
$moderators = new moderators();
$moderators->read();
$moderators->display('moderators', $forum_id);
unset($moderators);

// forum rules
$forums->display_rules($forum_id);

// jumpbox
make_jumpbox(INDEX, $forum_id);

// Mozilla navigation bar
$nav_links['prev'] = array(
	'url' => $config->url($requester, array(POST_TOPIC_URL => $topic_id, 'view' => 'previous'), true),
	'title' => $user->lang('View_previous_topic'),
);
$nav_links['next'] = array(
	'url' => $config->url($requester, array(POST_TOPIC_URL => $topic_id, 'view' => 'next'), true),
	'title' => $user->lang('View_next_topic'),
);
$nav_links['up'] = array(
	'url' => $config->url(INDEX, array(POST_FORUM_URL => $forum_id), true),
	'title' => $user->lang($forums->data[$forum_id]['forum_name']),
);

// and finaly send the tpl
$template->set_filenames(array('body' => 'viewtopic_body.tpl'));
include($config->url('includes/page_header'));
$template->pparse('body');
include($config->url('includes/page_tail'));

?>