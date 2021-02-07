<?php
//
//	file: includes/CH_functions_post.php
//	author: ptirhiik
//	begin: 10/02/2006
//	version: 1.6.4 - 17/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

//
// submit_post is called with mode in editpost, newtopic, reply
//
function submit_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id, &$input_data)
{
	global $db, $config, $user;
	global $user_ip;
	global $requester;

	$awaited_input_data = array(
		'topic_type' => 0,
		'bbcode_on' => 0,
		'html_on' => 0,
		'smilies_on' => 0,
		'attach_sig' => 0,
		'bbcode_uid' => '',
		'post_username' => '',
		'post_subject' => '',
		'post_message' => '',
		'poll_title' => '',
		'poll_options' => array(),
		'poll_length' => 0,
		'post_icon' => 0,
		'topic_duration' => 0,
		'calendar_time' => 0,
		'calendar_duration' => 0,
		'sub_title' => '',
		'topic_sub_type' => 0,
		'poster_id' => $user->data['user_id'],
		'no_flood_control' => 0,
	);
	foreach ( $awaited_input_data as $var => $dft )
	{
		$$var = isset($input_data[$var]) ? $input_data[$var] : $dft;
	}

	// reclaim some memory
	$input_data = array();
	unset($awaited_input_data);

	// init
	$current_time = time();

	$new_topic = ($mode == 'newtopic');
	$new_post = $new_topic || ($mode == 'reply');
	$first_post = $new_topic || (!$new_post && $post_data['first_post']);
	$last_post = $new_post || (!$new_post && $post_data['last_post']);
	$with_poll = ($new_topic || (!$new_post && $post_data['edit_poll'])) && !empty($poll_title) && (count($poll_options) >= 2);

	// flood control
	if ( !$no_flood_control )
	{
		$sql = 'SELECT MAX(post_time) AS last_post_time
					FROM ' . POSTS_TABLE . '
					WHERE ' . ($user->data['user_id'] == ANONYMOUS ? 'poster_ip = \'' . $db->sql_escape_string($user_ip) . '\'' : 'poster_id = ' . intval($user->data['user_id']));
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		if ( $row = $db->sql_fetchrow($result) && (intval($row['last_post_time']) > 0) && (($current_time - intval($row['last_post_time'])) < intval($config->data['flood_interval'])) )
		{
			message_die(GENERAL_MESSAGE, $user->lang('Flood_Error'));
		}
		$db->sql_freeresult($result);
	}

	// plugs
	$plug_fields = false;
	if ( $requester )
	{
		if ( $config->plug_ins[$requester] )
		{
			foreach ( $config->plug_ins[$requester] as $plug => $dummy )
			{
				if ( method_exists($config->plug_ins[$requester][$plug], 'submit') )
				{
					$config->plug_ins[$requester][$plug]->submit($new_topic, $first_post, $last_post, $plug_fields);
				}
			}
		}
	}

	// get topic fields
	$fields = $fields_inc = array();
	if ( $new_topic )
	{
		$fields += array(
			'forum_id' => intval($forum_id),
			'topic_poster' => intval($poster_id),
			'topic_time' => intval($current_time),
			'topic_status' => TOPIC_UNLOCKED,
			'topic_replies' => 0,
			'topic_views' => 0,
		);
	}
	if ( $first_post )
	{
		$fields += array(
			'topic_title' => $post_subject,
			'topic_sub_title' => $sub_title,
			'topic_type' => intval($topic_type),
			'topic_sub_type' => intval($topic_sub_type),
			'topic_icon' => intval($post_icon),
			'topic_duration' => intval($topic_duration),
			'topic_first_username' => $post_username,
			'topic_vote' => !empty($poll_title) && (count($poll_options) >= 2) ? 1 : 0,
		);
	}
	if ( $plug_fields )
	{
		if ( $plug_fields['topic'] )
		{
			$fields += $plug_fields['topic'];
		}
		if ( $plug_fields['topic_inc'] )
		{
			$fields += $plug_fields['topic_inc'];
		}
	}

	// something to update
	if ( !empty($fields) )
	{
		$db->sql_statement($fields, $fields_inc);
		if ( $new_topic )
		{
			$sql = 'INSERT INTO ' . TOPICS_TABLE . '
						(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$topic_id = $db->sql_nextid();
		}
		else
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET ' . $db->sql_update . '
						WHERE topic_id = ' . intval($topic_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	// update post
	$fields = array(
		'post_icon' => intval($post_icon),
		'post_username' => $post_username,
		'enable_bbcode' => intval($bbcode_on),
		'enable_html' => intval($html_on),
		'enable_smilies' => intval($smilies_on),
		'enable_sig' => intval($attach_sig),
	);
	$fields_inc = array();
	if ( $new_post )
	{
		$fields += array(
			'topic_id' => intval($topic_id),
			'forum_id' => intval($forum_id),
			'poster_id' => intval($poster_id),
			'poster_ip' => $user_ip,
			'post_time' => intval($current_time),
		);
	}
	else if ( !$last_post && $post_data['poster_post'] )
	{
		$fields += array(
			'post_edit_time' => intval($current_time),
		);
		$fields_inc += array(
			'post_edit_count' => + 1,
		);
	}
	if ( $plug_fields )
	{
		if ( $plug_fields['post'] )
		{
			$fields += $plug_fields['post'];
		}
		if ( $plug_fields['post_inc'] )
		{
			$fields += $plug_fields['post_inc'];
		}
	}
	$db->sql_statement($fields, $fields_inc);
	if ( $new_post )
	{
		$sql = 'INSERT INTO ' . POSTS_TABLE . '
					(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
		$db->sql_query($sql, BEGIN_TRANSACTION, __LINE__, __FILE__);
		$post_id = $db->sql_nextid();
	}
	else
	{
		$sql = 'UPDATE ' . POSTS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE post_id = ' . intval($post_id);
		$db->sql_query($sql, BEGIN_TRANSACTION, __LINE__, __FILE__);
	}

	// update post text
	$fields = array(
		'post_subject' => $post_subject,
		'post_sub_title' => $sub_title,
		'bbcode_uid' => $bbcode_uid,
		'post_text' => $post_message,
	);
	$fields_inc = array();
	if ( $new_post )
	{
		$fields += array(
			'post_id' => intval($post_id),
		);
	}
	if ( $plug_fields )
	{
		if ( $plug_fields['text'] )
		{
			$fields += $plug_fields['text'];
		}
		if ( $plug_fields['text_inc'] )
		{
			$fields += $plug_fields['text_inc'];
		}
	}
	$db->sql_statement($fields, $fields_inc);
	if ( $new_post )
	{
		$sql = 'INSERT INTO ' . POSTS_TEXT_TABLE . '
					(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
	}
	else
	{
		$sql = 'UPDATE ' . POSTS_TEXT_TABLE . '
					SET ' . $db->sql_update . '
					WHERE post_id = ' . intval($post_id);
	}
	$db->sql_query($sql, false, __LINE__, __FILE__);

	//
	// poll
	//
	if ( $with_poll )
	{
		$vote_desc_fields = array(
			'vote_text' => $poll_title,
			'vote_length' => $poll_length * 86400,
		);
		if ( !$post_data['has_poll'] )
		{
			$vote_desc_fields += array(
				'topic_id' => intval($topic_id),
				'vote_start' => intval($current_time),
			);
		}
		$db->sql_statement($vote_desc_fields);
		if ( !$post_data['has_poll'] )
		{
			$sql = 'INSERT INTO ' . VOTE_DESC_TABLE . '
						(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$poll_id = $db->sql_nextid();
		}
		else
		{
			$sql = 'UPDATE ' . VOTE_DESC_TABLE . '
						SET ' . $db->sql_update . '
						WHERE topic_id = ' . intval($topic_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// get current votes
		$poll_results = array();
		if ( $post_data['has_poll'] )
		{
			$sql = 'SELECT vote_option_id, vote_result
						FROM ' . VOTE_RESULTS_TABLE . '
						WHERE vote_id = ' . intval($poll_id) . '
						ORDER BY vote_option_id';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$poll_results[ intval($row['vote_option_id']) ] = intval($row['vote_result']);
			}
			$db->sql_freeresult($result);

			// raz all votes
			$sql = 'DELETE FROM ' . VOTE_RESULTS_TABLE . '
						WHERE vote_id = ' . intval($poll_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// recreate results
		if ( !empty($poll_options) )
		{
			$db->sql_stack_reset();
			$poll_option_id = 1;
			foreach ( $poll_options as $vote_option_id => $vote_option_text )
			{
				$fields = array(
					'vote_id' => intval($poll_id),
					'vote_option_id' => isset($poll_results[$vote_option_id]) ? intval($vote_option_id) : $poll_option_id,
					'vote_option_text' => htmlspecialchars(trim(stripslashes($vote_option_text))),
					'vote_result' => isset($poll_results[$vote_option_id]) ? intval($poll_results[$vote_option_id]) : 0,
				);
				$db->sql_stack_statement($fields);
				$poll_option_id++;
			}
			$db->sql_stack_insert(VOTE_RESULTS_TABLE, false, __LINE__, __FILE__);
		}
	}

	// sync forum if edit first post (title & username)
	if ( !$new_post && $post_data['first_post'] )
	{
		// get last post data of the forum
		$sql = 'SELECT t.topic_last_post_id, t.topic_title, t.topic_last_poster, t.topic_last_username, t.topic_last_time, u.username
					FROM ' . TOPICS_TABLE . ' t
						LEFT JOIN ' . USERS_TABLE . ' u
							ON u.user_id = t.topic_last_poster
					WHERE forum_id = ' . intval($forum_id) . '
						AND topic_moved_id = 0
					ORDER BY topic_last_post_id DESC
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$fields = array(
			'forum_last_post_id' => intval($row['topic_last_post_id']),
			'forum_last_title' => $row['topic_title'],
			'forum_last_poster' => intval($row['topic_last_poster']),
			'forum_last_username' => (($row['topic_last_poster'] != ANONYMOUS) && !empty($row['username'])) ? $row['username'] : $row['topic_last_username'],
			'forum_last_time' => intval($row['topic_last_time']),
		);

		// update forum
		$db->sql_statement($fields);
		$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE forum_id = ' . intval($forum_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	// process search
	if ( !$config->data['fulltext_search'] )
	{
		if ( !$new_post )
		{
			$prune = new prune();
			$prune->words_posts($post_id, true);
			unset($prune);
		}
		add_search_words('single', $post_id, trim($post_message . ' ' . $post_subject));
	}

	// prepare achievement message
	$u_link = $config->url('viewtopic', array(POST_POST_URL => intval($post_id)), true, intval($post_id));
	$f_link = $config->url(INDEX, array(POST_FORUM_URL => intval($forum_id)), true);
	$meta = '<meta http-equiv="refresh" content="3;url=' . $u_link . '">';
	$message = $user->lang('Stored') . '<br /><br />' . sprintf($user->lang('Click_view_message'), '<a href="' . $u_link . '">', '</a>') . '<br /><br />' . sprintf($user->lang('Click_return_forum'), '<a href="' . $f_link . '">', '</a>');

	return false;
}

//
// delete_post() is called with mode in delete, poll_delete
//
function delete_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id)
{
	global $db, $config, $user;

	$delete_post = ($mode == 'delete');
	$delete_topic = $delete_post && $post_data['first_post'] && $post_data['last_post'];
	$delete_poll = $post_data['has_poll'] && ($delete_topic || (($mode == 'poll_delete') && $post_data['edit_poll']));

	// delete the post
	if ( $delete_post )
	{
		$sql = 'DELETE FROM ' . POSTS_TEXT_TABLE . '
					WHERE post_id = ' . intval($post_id);
		$db->sql_query($sql, BEGIN_TRANSACTION, __LINE__, __FILE__);

		$sql = 'DELETE FROM ' . POSTS_TABLE . '
					WHERE post_id = ' . intval($post_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		if ( !$post_data['first_post'] || !$post_data['last_post'] )
		{
			// check if there is remaining posts
			$sql = 'SELECT post_id
						FROM ' . POSTS_TABLE . '
						WHERE topic_id = ' . intval($topic_id) . '
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( !$row = $db->sql_fetchrow($result) )
			{
				$post_data['first_post'] = $post_data['last_post'] = true;
			}
			$db->sql_freeresult($result);
		}
	}

	// delete topic
	if ( $delete_topic )
	{
		$sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . '
					WHERE topic_id = ' . intval($topic_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		$sql = 'DELETE FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . intval($topic_id) . '
						OR topic_moved_id = ' . intval($topic_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	// poll
	if ( $delete_poll )
	{
		$sql = 'DELETE FROM ' . VOTE_USERS_TABLE . '
					WHERE vote_id = ' . intval($poll_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		$sql = 'DELETE FROM ' . VOTE_RESULTS_TABLE . '
					WHERE vote_id = ' . intval($poll_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		$sql = 'DELETE FROM ' . VOTE_DESC_TABLE . '
					WHERE topic_id = ' . intval($topic_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	// process search
	if ( !$config->data['fulltext_search'] && $delete_post )
	{
		$prune = new prune();
		$prune->words_posts($post_id, true);
		unset($prune);
	}

	$f_link = $config->url(INDEX, array(POST_FORUM_URL => $forum_id), true);
	$u_link = $config->url('viewtopic', array(POST_TOPIC_URL => $topic_id), true);
	$meta = '<meta http-equiv="refresh" content="3;url=' . ($delete_topic ? $f_link : $u_link) . '">';
	$message = $delete_topic ? $user->lang('Deleted') : $user->lang($mode == 'poll_delete' ? 'Poll_delete' : 'Deleted') . '<br /><br />' . sprintf($user->lang('Click_return_topic'), '<a href="' . $u_link . '">', '</a>');
	$message .=  '<br /><br />' . sprintf($user->lang('Click_return_forum'), '<a href="' . $f_link . '">', '</a>');

	return;
}

//
// update_post_stats() is called with $mode in newtopic, reply, delete, poll_delete
//
function update_post_stats(&$mode, &$post_data, &$forum_id, &$topic_id, &$post_id, &$user_id)
{
	global $db, $config;

	// delete a poll : just that to do
	if ( $mode == 'poll_delete' )
	{
		$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET topic_vote = 0
					WHERE topic_id = ' . intval($topic_id);
		return $db->sql_query($sql, false, __LINE__, __FILE__);
	}

	// ok, now go with the serious job
	$new_topic = ($mode == 'newtopic');
	$new_post = $new_topic || ($mode == 'reply');
	$delete_post = ($mode == 'delete');
	$delete_topic = $delete_post && $post_data['first_post'] && $post_data['last_post'];

	// update users (and free the transaction)
	$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_posts = user_posts ' . ($new_post ? '+' : '-') . ' 1
				WHERE user_id = ' . intval($user_id);
	$db->sql_query($sql, END_TRANSACTION, __LINE__, __FILE__);

	// resync the topic
	if ( !$delete_topic )
	{
		$fields = array();
		$fields_inc = array();
		if ( !$new_topic )
		{
			$sql = 'SELECT COUNT(post_id) AS count_post_id
						FROM ' . POSTS_TABLE . '
						WHERE topic_id = ' . intval($topic_id);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$topic_replies = ($row = $db->sql_fetchrow($result)) ? max(0, intval($row['count_post_id']) - 1) : 0;
			$db->sql_freeresult($result);
			$fields += array(
				'topic_replies' => $topic_replies,
			);
		}

		// get new first post data of the topic : we only change the topic first id
		if ( $new_topic || ($delete_post && $post_data['first_post']) )
		{
			$sql = 'SELECT post_id
						FROM ' . POSTS_TABLE . '
						WHERE topic_id = ' . intval($topic_id) . '
						ORDER BY post_id
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( $row = $db->sql_fetchrow($result) )
			{
				$fields += array(
					'topic_first_post_id' => intval($row['post_id']),
				);
			}
			$db->sql_freeresult($result);
		}

		// get new last post data of the topic
		if ( $new_post || ($delete_post && $post_data['last_post']) )
		{
			$sql = 'SELECT post_id, poster_id, post_username, post_time
						FROM ' . POSTS_TABLE . '
						WHERE topic_id = ' . intval($topic_id) . '
						ORDER BY post_id DESC
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( $row = $db->sql_fetchrow($result) )
			{
				$fields += array(
					'topic_last_post_id' => intval($row['post_id']),
					'topic_last_poster' => intval($row['poster_id']),
					'topic_last_username' => $row['post_username'],
					'topic_last_time' => intval($row['post_time']),
				);
			}
			$db->sql_freeresult($result);
		}

		if ( !empty($fields) || !empty($fields_inc) )
		{
			$db->sql_statement($fields, $fields_inc);
			$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET ' . $db->sql_update . '
						WHERE topic_id = ' . intval($topic_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	// get last post data of the forum
	$sql = 'SELECT t.topic_last_post_id, t.topic_title, t.topic_last_poster, t.topic_last_username, t.topic_last_time, u.username
				FROM ' . TOPICS_TABLE . ' t
					LEFT JOIN ' . USERS_TABLE . ' u
						ON u.user_id = t.topic_last_poster
				WHERE forum_id = ' . intval($forum_id) . '
					AND topic_moved_id = 0
				ORDER BY topic_last_post_id DESC
				LIMIT 1';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	$fields = array(
		'forum_last_post_id' => intval($row['topic_last_post_id']),
		'forum_last_title' => $row['topic_title'],
		'forum_last_poster' => intval($row['topic_last_poster']),
		'forum_last_username' => (($row['topic_last_poster'] != ANONYMOUS) && !empty($row['username'])) ? $row['username'] : $row['topic_last_username'],
		'forum_last_time' => intval($row['topic_last_time']),
	);

	$fields_inc = array(
		'forum_posts' => $new_post ? +1 : -1,
	);
	if ( $new_topic || $delete_topic )
	{
		$fields_inc += array(
			'forum_topics' => $new_topic ? +1 : -1,
		);
	}

	// update forum
	$db->sql_statement($fields, $fields_inc);
	$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET ' . $db->sql_update . '
				WHERE forum_id = ' . intval($forum_id);
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// global stats
	$config->set('stat_total_posts', $config->data['stat_total_posts'] + ($new_post ? +1 : -1));
	if ( $new_topic || $delete_topic )
	{
		$config->set('stat_total_topics', $config->data['stat_total_topics'] + ($new_post ? +1 : -1));
	}
	return;
}

function generate_smilies($mode, $page_id)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $user_ip, $session_length, $starttime;
	global $userdata;

	global $config, $user, $censored_words, $icons, $navigation, $themes, $smilies, $requester;
	global $forums, $forum_id;

	// get forum id
	if ( !($forum_id = intval($forum_id)) )
	{
		$forum_id = _read(POST_FORUM_URL, TYPE_INT);
	}
	if ( $mode == 'window' )
	{
		$userdata = session_pagestart($user_ip, $page_id);
		$user->set('smilies_window', array('posting', 'viewtopic', 'class_forum', 'class_topics', 'class_posts', 'viewprofile', 'class_fields', 'bbcodes'));
	}

	$inline_columns = 4;
	$inline_rows = 5;
	$window_columns = 8;

	if ( $smilies === false )
	{
		if ( !class_exists('smilies') )
		{
			include($config->url('includes/class_message'));
		}
		$smilies = new smilies();
	}
	$smiles = $smilies->read();
	if ( $count_smiles = count($smiles) )
	{
		$max_inline = $inline_columns * $inline_rows;
		$cells = $mode == 'window' ? $window_columns : $inline_columns;
		$offset = 0;
		$nb_displayed = 0;
		$urls = array();
		for ( $i = 0; $i < $count_smiles; $i++ )
		{
			$offset = $offset % $cells;
			if ( !isset($urls[ $smiles[$i]['smile_url'] ]) )
			{
				$template->set_switch('smilies_row', !$offset);
				$template->assign_block_vars('smilies_row.smilies_col', array(
					'SMILEY_CODE' => str_replace("'", "\\'", str_replace('\\', '\\\\', $smiles[$i]['code'])),
					'SMILEY_IMG' => $template->img_styled($config->data['smilies_path'] . '/' . $smiles[$i]['smile_url']),
					'SMILEY_DESC' => $smiles[$i]['emoticon'],
				));
				$offset++;
				$urls[ $smiles[$i]['smile_url'] ] = true;
				$nb_displayed++;
				if ( ($mode != 'window') && ($nb_displayed >= $max_inline) )
				{
					break;
				}
			}
		}
		// check if other emoticons
		if ( $mode != 'window' )
		{
			$found = false;
			while ( !$found && ($i < $count_smiles) )
			{
				$found = !isset($urls[ $smiles[$i]['smile_url'] ]);
				$i++;
			}
			$template->set_switch('switch_smilies_extra', $found);
			if ( $found )
			{
				$template->assign_vars(array(
					'L_MORE_SMILIES' => $user->lang('More_emoticons'),
					'U_MORE_SMILIES' => $config->url(POSTING, array(POST_FORUM_URL => $forum_id, 'mode' => 'smilies'), true),
				));
			}
		}
	}
	$template->assign_vars(array(
		'L_EMOTICONS' => $user->lang('Emoticons'),
		'L_CLOSE_WINDOW' => $user->lang('Close_window'),
		'S_SMILIES_COLSPAN' => min($count_smiles, $cells) + 1,
	));

	// popup
	if ( $mode == 'window' )
	{
		$gen_simple_header = true;
		$page_title = $user->lang('Emoticons');
		$template->set_filenames(array('smiliesbody' => 'posting_smilies.tpl'));
		include($config->url('includes/page_header'));
		$template->pparse('smiliesbody');
		include($config->url('includes/page_tail'));
	}
}

?>