<?php
//
//	file: includes/topic_review.php
//	author: ptirhiik
//	begin: 23/12/2005
//	version: 1.6.4 - 21/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

function topic_review($topic_id, $post_id, $is_inline_review, $tpl_var='', $local_parms='', $local_title='')
{
	// regular phpBB
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $userdata, $user_ip;
	global $orig_word, $replacement_word;
	global $starttime;

	// CH
	global $config, $user, $censored_words, $icons, $navigation, $themes, $smilies, $topics_attr, $requester;
	global $forums, $forum_id, $post_info;

	if ( empty($local_parms) )
	{
		$local_parms = array('mode' => 'topicreview');
	}

	// available sorts
	$posts = new posts_review($requester);
	$posts->init();
	$available_sorts = $posts->sort_fields;

	$dft_sort = $dft_order = '';
	if ( isset($local_parms['sort']) )
	{
		$dft_sort = $local_parms['sort'];
		unset($local_parms['sort']);
	}
	if ( isset($local_parms['postorder']) )
	{
		$dft_order = $local_parms['postorder'];
		unset($local_parms['postorder']);
	}

	// sort
	$sort = _read('sort', TYPE_NO_HTML, $dft_sort, array('' => '') + $available_sorts);
	$order = strtoupper(_read('postorder', TYPE_NO_HTML, $dft_order, array_flip(array('', 'asc', 'ASC', 'desc', 'DESC'))));
	$postdays = max(0, _read('postdays', TYPE_INT));

	// pagination
	$start = max(0, _read('start', TYPE_INT));
	$ppage = max(0, _read('ppage', TYPE_INT));

	// fix default sort
	if ( empty($sort) )
	{
		$sort = 'lastpost';
		$order = 'DESC';
	}

	// prepare parms
	$parms = $local_parms + array(
		'ppage' => $ppage,
		'start' => empty($post_id) ? $start : 0,
		'sort' => $sort,
		'postorder' => $order,
		'postdays' => $postdays,
	);

	// prepare for topic data reading
	$posts->parms = $parms;
	unset($parms);

	if ( $is_inline_review && empty($post_id) )
	{
		$posts->topic = array('topic_id' => $topic_id);
		foreach ( $posts->topic_fields as $field )
		{
			if ( isset($post_info[$field]) && !isset($posts->topic[$field]) )
			{
				$posts->topic[$field] = $post_info[$field];
			}
		}
	}

	// get topic data
	$posts->read_topic($topic_id, $post_id);
	$forum_id = $posts->forum_id;
	$topic_id = $posts->topic_id;
	$post_id = $posts->post_id;

	//
	// Start session management
	//
	if ( !$is_inline_review )
	{
		$user->use_lang(array('posting', 'viewtopic', 'class_forum', 'class_topics', 'class_posts', 'viewprofile', 'class_fields', 'bbcodes', 'usercp', 'editprofile'));
		$userdata = session_pagestart($user_ip, empty($forum_id) ? PAGE_INDEX : $forum_id);
		init_userprefs($userdata);

		// get cache
		$user->get_cache(POST_FORUM_URL);
	}
	//
	// End session management
	//

	// an error occured ?
	if ( empty($posts->topic) || !isset($forums->data[$forum_id]) )
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
	}

	// is the topic authorised ?
	if ( !$user->auth(POST_FORUM_URL, 'auth_read', $forum_id) )
	{
		message_die(GENERAL_MESSAGE, $user->auth(POST_FORUM_URL, 'auth_view', $forum_id) ? sprintf($user->lang('Sorry_auth_read'), $user->lang('Auth_Users_granted_access')) : 'Topic_post_not_exist');
	}

	// mark the topic readed (we don't want to send outdated readed flag)
	$posts->topic_last_read = 0;

	// now we can read and display the posts
	$posts->get_parms();
	$posts->read();
	$posts->display();

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
		'L_TOPIC_REVIEW' => empty($local_title) ? $user->lang('Topic_review') : $user->lang($local_title),

		'S_POST_DAYS_ACTION' => $config->url($requester, $local_parms + array(POST_TOPIC_URL => $topic_id, 'start' => $start), true),
	));

	// display pagination
	$pagination = new pagination($requester, array(POST_TOPIC_URL => $topic_id) + $posts->parms);
	$pagination->display('pagination', $posts->total_items, $posts->ppage, isset($posts->parms['start']) ? $posts->parms['start'] : 0, true, 'Posts_count');
	unset($pagination);

	// kill posts
	unset($posts);

	// display
	if ( !$is_inline_review )
	{
		$gen_simple_header = true;
		$page_title = empty($local_title) ? $user->lang('Topic_review') : $user->lang($local_title);
		$template->set_filenames(array('body' => 'posting_topic_review.tpl'));
		include($config->url('includes/page_header'));
		$template->pparse('body');
		include($config->url('includes/page_tail'));
	}
	else
	{
		$template->set_switch('switch_inline_mode');
		$template->assign_vars(array($tpl_var => $template->include_file('posting_topic_review.tpl')));
	}
}

?>