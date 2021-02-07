<?php
//-- mod : categories hierarchy ------------------------------------------------
/***************************************************************************
 *                              topic_review.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: topic_review.php,v 1.5.2.4 2005/05/06 20:50:12 acydburn Exp $
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
 *
 ***************************************************************************/

function topic_review($topic_id, $is_inline_review)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $userdata, $user_ip;
	global $orig_word, $replacement_word;
	global $starttime;
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
	global $colors;
//-- fin mod : Advanced Group Color Management ---------------------------------

//-- mod : categories hierarchy ------------------------------------------------
//-- add
	global $config, $user, $censored_words, $icons, $navigation, $themes, $smilies, $topics_attr;
	global $forums, $forum_id;
//-- fin mod : categories hierarchy --------------------------------------------

	if ( !$is_inline_review )
	{
		if ( !isset($topic_id) || !$topic_id)
		{
			message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
		}

		//
		// Get topic info ...
		//
		$sql = "SELECT t.topic_title, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments 
			FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f 
			WHERE t.topic_id = $topic_id
				AND f.forum_id = t.forum_id";
//-- mod : categories hierarchy ------------------------------------------------
//-- add
		// let's enhance this request
		$added_fields = 't.topic_replies, t.topic_type, t.topic_sub_type, t.topic_first_post_id, t.topic_time, t.topic_duration, t.topic_sub_title, ';
		if ( $config->data['mod_topic_calendar_CH'] )
		{
			$added_fields .= 't.topic_calendar_time, t.topic_calendar_duration, ';
		}
		$sql = str_replace('SELECT ', 'SELECT ' . $added_fields, $sql);
//-- fin mod : categories hierarchy --------------------------------------------
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
		}

		if ( !($forum_row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
		}
		$db->sql_freeresult($result);

//-- mod : categories hierarchy ------------------------------------------------
//-- add
		if ( empty($forums) )
		{
			// read forums to get the specific style, used by user set
			include_once($config->url('includes/class_forums'));
			$forums = new forums();
			$forums->read();
		}

		// prepare title enhancement
		$front_title = new front_title();
//-- fin mod : categories hierarchy --------------------------------------------

		$forum_id = $forum_row['forum_id'];
		$topic_title = $forum_row['topic_title'];
		
		//
		// Start session management
		//
		$userdata = session_pagestart($user_ip, $forum_id);
		init_userprefs($userdata);
		//
		// End session management
		//

		$is_auth = array();
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
		$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_row);
*/
//-- add
		$user->get_cache(POST_FORUM_URL);
		$is_auth = array(
			'auth_view' => $user->auth(POST_FORUM_URL, 'auth_view', $forum_id),
			'auth_download' => $user->auth(POST_FORUM_URL, 'auth_download', $forum_id),
			'auth_read' => $user->auth(POST_FORUM_URL, 'auth_read', $forum_id),
			'auth_read_type' => $user->lang('Auth_Users_granted_access'),
		);
//-- fin mod : categories hierarchy --------------------------------------------

		if ( !$is_auth['auth_read'] )
		{
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']));
		}
	}

	//
	// Define censored word matches
	//
	if ( empty($orig_word) && empty($replacement_word) )
	{
		$orig_word = array();
		$replacement_word = array();

		obtain_word_list($orig_word, $replacement_word);
	}

	//
	// Dump out the page header and load viewtopic body template
	//
	if ( !$is_inline_review )
	{
		$gen_simple_header = TRUE;

		$page_title = $lang['Topic_review'] . ' - ' . $topic_title;
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->set_filenames(array(
			'reviewbody' => 'posting_topic_review.tpl')
		);
	}

	//
	// Go ahead and pull all data for this topic
	//
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
	$sql = "SELECT u.username, u.user_id, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid
		FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt
		WHERE p.topic_id = $topic_id
			AND p.poster_id = u.user_id
			AND p.post_id = pt.post_id
		ORDER BY p.post_time DESC
		LIMIT " . $board_config['posts_per_page'];
*/
//-- add
	// generate pagination
	$ppage = _read('ppage', TYPE_INT);
	if ( $ppage < 5 )
	{
		$ppage = $config->data['posts_per_page'];
	}
	$start = _read('start', TYPE_INT);
	if ( $start < 0 )
	{
		$start = 0;
	}
	$total_posts = $forum_row['topic_replies'] + 1;
	$parms = array(
		'mode' => 'topicreview',
		POST_TOPIC_URL => $topic_id,
	);
	if ( $ppage != $config->data['posts_per_page'] )
	{
		$parms += array(
			'ppage' => $ppage,
		);
	}
	$pagination = new pagination('posting', $parms);
	$pagination->display('pagination', $total_posts, $config->data['posts_per_page'], $start, true, 'Posts_count');

	// read posts
	$sql = 'SELECT p.*, pt.post_text, pt.post_subject, pt.bbcode_uid, pt.post_sub_title, u.user_id, u.username
				FROM ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt, ' . USERS_TABLE . ' u
				WHERE p.topic_id = ' . intval($topic_id) . '
					AND p.poster_id = u.user_id
					AND pt.post_id = p.post_id
				ORDER BY p.post_time DESC
				LIMIT ' . $start . ', ' . $ppage;
//-- fin mod : categories hierarchy --------------------------------------------
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT u.user_group_id, u.user_session_time, ', $sql);
//-- fin mod : Advanced Group Color Management ---------------------------------

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain post/user information', '', __LINE__, __FILE__, $sql);
	}

	//
	// Okay, let's do the loop, yeah come on baby let's do the loop
	// and it goes like this ...
	//
	if ( $row = $db->sql_fetchrow($result) )
	{
		$mini_post_img = $images['icon_minipost'];
		$mini_post_alt = $lang['Post'];

		$i = 0;
		do
		{
			$poster_id = $row['user_id'];
			$poster = $row['username'];

			$post_date = create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone']);

			//
			// Handle anon users posting with usernames
			//
			if( $poster_id == ANONYMOUS && $row['post_username'] != '' )
			{
				$poster = $row['post_username'];
				$poster_rank = $lang['Guest'];
			}
			elseif ( $poster_id == ANONYMOUS )
			{
				$poster = $lang['Guest'];
				$poster_rank = '';
			}

			$post_subject = ( $row['post_subject'] != '' ) ? $row['post_subject'] : '';

			$message = $row['post_text'];
			$bbcode_uid = $row['bbcode_uid'];

			//
			// If the board has HTML off but the post has HTML
			// on then we process it, else leave it alone
			//
			if ( !$board_config['allow_html'] && $row['enable_html'] )
			{
				$message = preg_replace('#(<)([\/]?.*?)(>)#is', '&lt;\2&gt;', $message);
			}

			if ( $bbcode_uid != "" )
			{
				$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
			}

			$message = make_clickable($message);

			if ( count($orig_word) )
			{
				$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
				$message = preg_replace($orig_word, $replacement_word, $message);
			}

			if ( $board_config['allow_smilies'] && $row['enable_smilies'] )
			{
				$message = smilies_pass($message);
			}

			$message = str_replace("\n", '<br />', $message);

			//
			// Again this will be handled by the templating
			// code at some point
			//
			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars('postrow', array(
				'ROW_COLOR' => '#' . $row_color, 
				'ROW_CLASS' => $row_class, 

				'MINI_POST_IMG' => $mini_post_img, 
//-- mod : Advanced Group Color Management --------------------------------------
//-- delete
//	'POSTER_NAME' => $poster,
//-- add
				'POSTER_NAME' => $colors->get_user_color($row['user_group_id'], $row['user_session_time'], $poster),
//-- fin mod : Avanced Group Color Management ----------------------------------

				'POST_DATE' => $post_date, 
				'POST_SUBJECT' => $post_subject, 
				'MESSAGE' => $message,
					
				'L_MINI_POST_ALT' => $mini_post_alt)
			);

//-- mod : categories hierarchy ------------------------------------------------
//-- add
			// enhance the topic title
			if ( !$is_inline_review )
			{
				$front_title->set('postrow', array_merge($forum_row, $row), $forum_row['topic_first_post_id'] == $row['post_id']);
			}
			$template->set_switch('postrow.light', !($i % 2));
//-- fin mod : categories hierarchy --------------------------------------------

			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
	else
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist', '', __LINE__, __FILE__, $sql);
	}
	$db->sql_freeresult($result);

	$template->assign_vars(array(
		'L_AUTHOR' => $lang['Author'],
		'L_MESSAGE' => $lang['Message'],
		'L_POSTED' => $lang['Posted'],
		'L_POST_SUBJECT' => $lang['Post_subject'], 
		'L_TOPIC_REVIEW' => $lang['Topic_review'])
	);

	if ( !$is_inline_review )
	{
		$template->pparse('reviewbody');
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
}

?>