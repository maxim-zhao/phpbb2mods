<?php
/***************************************************************************
 *							class_topics.php
 *							----------------
 *	begin		: 28/08/2004
 *	copyright	: Ptirhiik
 *	email		: ptirhiik@clanmckeen.com
 *
 *	Version		: 0.0.15 - 31/10/2005
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

class topics
{
	var $data;
	var $data_ext;
	var $forum_id;
	var $total_topics;
	var $total_announces;

	var $sort_fields;
	var $parms;

	var $requester;
	var $requester_topics;
	var $extra_parms;
	var $with_select;

	var $front_title;

	var $user_ids;
	var $topic_ids;

	var $user_fields;

	function topics($requester='', $parms='', $requester_topics='', $with_select=false)
	{
		$this->data = array();
		$this->data_ext = array();
		$this->parms = empty($parms) ? array() : $parms;

		$this->requester = empty($requester) ? 'index' : $requester;
		$this->requester_topics = empty($requester_topics) ? 'viewtopic' : $requester_topics;
		$this->extra_parms = array();
		$this->with_select = $with_select;

		$this->sort_fields = array(
			'lastpost' => array('txt' => 'Last_Post', 'field' => 't.topic_last_post_id'),
			'firstpost' => array('txt' => 'First_Post', 'field' => 't.topic_first_post_id'),
			'title' => array('txt' => 'Sort_Topic_Title', 'field' => 't.topic_title'),
			'replies' => array('txt' => 'Replies', 'field' => 't.topic_replies'),
			'views' => array('txt' => 'Views', 'field' => 't.topic_views'),
			'author' => array('txt' => 'Sort_Author', 'field' => 'u.username'),
		);

		$this->total_topics = 0;
		$this->total_announces = 0;
		$this->user_fields = array();
	}

	function read($forum_id=0, $only_own_global=false)
	{
		global $db, $config, $forums, $user;

		// store the forum_id
		$this->forum_id = intval($forum_id);

		// get board announces setup
		$board_box = $config->data['board_box'];
		if ( !$config->data['board_box_over'] )
		{
			switch ( $user->data['user_board_box'] )
			{
				case DENY:
					$board_box = 0;
					break;
				case TRUE:
					$board_box = empty($board_box) ? BOARD_GLOBAL_ANNOUNCES : $board_box;
					break;
			}
		}
		if ( !empty($this->forum_id) && !empty($forums->data[$this->forum_id]['forum_board_box']) )
		{
			$board_box = $forums->data[$this->forum_id]['forum_board_box'];
		}

		$board_announces = true;
		switch ( $board_box )
		{
			case BOARD_GLOBAL_ANNOUNCES:
				$parent_announces = $child_announces = false;
				break;
			case BOARD_PARENT_ANNOUNCES:
				$parent_announces = true;
				$child_announces = false;
				break;
			case BOARD_CHILD_ANNOUNCES:
				$parent_announces = false;
				$child_announces = true;
				break;
			case BOARD_BRANCH_ANNOUNCES:
				$parent_announces = true;
				$child_announces = true;
				break;
			default:
				$board_announces = $parent_announces = $child_announces = false;
				$only_own_global |= ($forums->data[$this->forum_id]['forum_type'] != POST_FORUM_URL);
				break;
		}
		if ( !$board_announces && ($forums->data[$this->forum_id]['forum_type'] != POST_FORUM_URL) )
		{
			return;
		}

		// read parms
		$this->parms = array_merge($this->parms, array(
			'start' => _read('start', TYPE_INT),
			'ppage' => _read('ppage', TYPE_INT),
			'topicdays' => _read('topicdays', TYPE_INT),
			'sort' => _read('sort', TYPE_NO_HTML, '', array('' => '') + $this->sort_fields),
			'order' => strtoupper(_read('order', TYPE_NO_HTML, '', array_flip(array('', 'asc', 'ASC', 'desc', 'DESC')))),
		));

		// default values for parms
		$default_values = array(
			'ppage' => array($forums->data[$this->forum_id]['forum_topics_ppage'], isset($user->data['user_topics_ppage']) ? $user->data['user_topics_ppage'] : $config->data['topics_per_page'], $config->data['topics_per_page'], 50),
			'sort' => array(),
		);

		$default_values['sort'][] = array('sort' => $forums->data[$this->forum_id]['forum_topics_sort'], 'order' => $forums->data[$this->forum_id]['forum_topics_order']);
		if ( !$config->data['topics_sort_over'] )
		{
			$default_values['sort'][] = array('sort' => $user->data['user_topics_sort'], 'order' => $user->data['user_topics_order']);
		}
		$default_values['sort'][] = array('sort' => $config->data['topics_sort'], 'order' => $config->data['topics_order']);
		$default_values['sort'][] = array('sort' => 'lastpost', 'order' => 'DESC');

		foreach ( $default_values as $key => $values )
		{
			foreach ( $values as $value )
			{
				if ( !empty($this->parms[$key]) )
				{
					break;
				}
				$this->parms = is_array($value) ? array_merge($this->parms, $value) : array_merge($this->parms, array($key => $value));
			}
		}

		// force order
		if ( $this->parms['order'] != 'DESC' )
		{
			$this->parms['order'] = 'ASC';
		}

		// get cookie data
		$user->read_cookies();

		// init user & own topics to read
		$this->pre_process();

		// read external topics
		$this->data_ext = array();
		if ( !$only_own_global )
		{
			// get parent forum list
			$forum_ids = array();
			if ( $parent_announces )
			{
				$cur_id = $this->forum_id;
				while ( $cur_id > 0 )
				{
					$cur_id = intval($forums->data[$cur_id]['forum_main']);
					if ( ($forums->data[$cur_id]['forum_type'] == POST_FORUM_URL) && $user->auth(POST_FORUM_URL, 'auth_read', $cur_id) )
					{
						$forum_ids[] = $cur_id;
					}
				}
			}

			// get child forums branch
			$fork_ids = array();
			if ( $child_announces && !empty($forums->data[$this->forum_id]['subs']) )
			{
				$min_id = $forums->data[$this->forum_id]['subs'][0];
				$max_id = $forums->data[$this->forum_id]['last_child_id'];
				if ( $min_id == $max_id )
				{
					$forum_ids[] = $min_id;
				}
				else
				{
					$fork_ids = array(intval($forums->data[$min_id]['forum_order']), intval($forums->data[$max_id]['forum_order']));
				}
			}

			// global announces
			$sql_where = '(t.topic_type = ' . POST_GLOBAL_ANNOUNCE;

			// normal announce
			$sub_where = array();
			if ( !empty($forum_ids) )
			{
				$sub_where[] = count($forum_ids) > 1 ? 't.forum_id IN(' . implode(', ', $forum_ids) . ')' : 't.forum_id = ' . intval($forum_ids[0]);
			}
			$sql_join = '';
			if ( !empty($fork_ids) )
			{
				$sub_where[] = 'f.forum_order BETWEEN ' . implode(' AND ', $fork_ids);
				$sql_join = ', ' . FORUMS_TABLE . ' f';
				$sql_where = 'f.forum_id = t.forum_id AND ' . $sql_where;
			}
			if ( $count_sub_where = count($sub_where) )
			{
				$sql_where .= ' OR (t.topic_type = ' . POST_ANNOUNCE . ' AND ' . ($count_sub_where > 1 ? '(' : '') . implode(' OR ', $sub_where) . ($count_sub_where > 1 ? ')' : '') . ')';
			}
			$sql_where .= ') AND (t.topic_duration = 0 OR t.topic_duration  > ' . time() . ') AND (t.forum_id <> ' . intval($this->forum_id) . ')';

			// process
			$sql = 'SELECT t.*
						FROM ' . TOPICS_TABLE . ' t' . $sql_join . '
						WHERE ' . $sql_where . '
						ORDER BY t.topic_type DESC, t.topic_last_time DESC';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				if ( empty($fork_ids) || $user->auth(POST_FORUM_URL, 'auth_read', $row['forum_id']) )
				{
					$this->row_process($row);
					$this->data_ext[ $row['topic_id'] ] = $row;
				}
			}
			$db->sql_freeresult($result);
		}

		// read this forum topics
		$this->data = array();
		$this->total_topics = 0;
		$this->total_announces = 0;
		if ( ($forums->data[$this->forum_id]['forum_type'] == POST_FORUM_URL) && $user->auth(POST_FORUM_URL, 'auth_read', $this->forum_id) )
		{
			$sql_fields = '';
			$sql_join = '';

			// author sort
			if ( $this->parms['sort'] == 'author' )
			{
				$this->user_fields = $user->get_pool_fields();
				$sql_fields .= ', u.' . implode(', u.', $this->user_fields);
				$sql_join .= ' LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t.topic_poster';
			}

			// build the request
			$sql = 'SELECT t.*' . $sql_fields . '
						FROM ' . TOPICS_TABLE . ' t' . $sql_join . '
						WHERE t.forum_id = ' . intval($this->forum_id) . '
							ORDER BY t.topic_type DESC, ' . $this->sort_fields[ $this->parms['sort'] ]['field'] . (($this->parms['order'] == 'ASC') ? '' : ' ' . $this->parms['order']);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$this->total_topics = $db->sql_numrows($result);
			$repos = false;
			$nb_rows = 0;
			while ( ($row = $db->sql_fetchrow($result)) && ($nb_rows < $this->parms['ppage']) )
			{
				// announces are welcome
				if ( $ok = in_array($row['topic_type'], array(POST_ANNOUNCE, POST_GLOBAL_ANNOUNCE)) )
				{
					$this->total_announces++;
				}
				// repos to first of the page
				else if ( !$ok = ($repos || empty($this->parms['start'])) )
				{
					$db->sql_rowseek($this->total_announces + $this->parms['start'], $result);
					$repos = true;
				}
				if ( $ok )
				{
					$this->row_process($row);
					$this->data[ $row['topic_id'] ] = $row;
					if ( !in_array($row['topic_type'], array(POST_ANNOUNCE, POST_GLOBAL_ANNOUNCE)) )
					{
						$nb_rows++;
					}
				}
			}
			$db->sql_freeresult($result);
		}

		// end the read
		$this->post_process();
	}

	function pre_process()
	{
		$this->user_ids = array();
		$this->topic_ids = array();
	}

	function row_process(&$row)
	{
		global $user;

		// unread status
		$row['topic_unread'] = empty($row['topic_moved_id']) && !empty($user->cookies['unreads']) && !empty($user->cookies['unreads'][ $row['topic_id'] ]);

		// own topic switch
		if ( $user->data['session_logged_in'] && !($row['topic_own'] = (($row['topic_poster'] == $user->data['user_id']) || ($row['topic_last_poster'] == $user->data['user_id']))) )
		{
			$this->topic_ids[] = intval($row['topic_id']);
		}

		// user ids
		$row['topic_poster'] = intval($row['topic_poster']);
		$row['topic_last_poster'] = intval($row['topic_last_poster']);
		if ( !in_array($row['topic_poster'], array(0, ANONYMOUS)) && !isset($user->pool[ $row['topic_poster'] ]) )
		{
			if ( !empty($this->user_fields) )
			{
				$user->pool[ $row['topic_poster'] ] = array();
				$count_user_fields = count($this->user_fields);
				for ( $i = 0; $i < $count_user_fields; $i++ )
				{
					$user->pool[ $row['topic_poster'] ][ $this->user_fields[$i] ] = $row[ $this->user_fields[$i] ];
				}
			}
			else
			{
				$this->user_ids[ $row['topic_poster'] ] = true;
			}
		}
		if ( !in_array($row['topic_last_poster'], array(0, ANONYMOUS)) && !isset($user->pool[ $row['topic_last_poster'] ]) )
		{
			$this->user_ids[ $row['topic_last_poster'] ] = true;
		}
	}

	function post_process()
	{
		global $user;

		// read the user data
		$user->read_pool($this->user_ids);

		// search topics the viewer has posted in
		$this->read_own_topics($this->topic_ids);
	}

	// search topics the viewer has posted in
	function read_own_topics(&$topic_ids)
	{
		global $db, $user;

		if ( !empty($topic_ids) && $user->data['session_logged_in'] )
		{
			$sql = 'SELECT topic_id
						FROM ' . POSTS_TABLE . '
						WHERE poster_id = ' . intval($user->data['user_id']) . '
							AND topic_id IN(' . implode(', ', $topic_ids) . ')
						GROUP BY topic_id';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				// moved topics are selected, so don't add them to the main selection
				if ( isset($this->data[ $row['topic_id'] ]) )
				{
					$this->data[ $row['topic_id'] ]['topic_own'] = true;
				}
				if ( isset($this->data_ext[ $row['topic_id'] ]) )
				{
					$this->data_ext[ $row['topic_id'] ]['topic_own'] = true;
				}
			}
			$db->sql_freeresult($result);
		}
		$this->topic_ids = array();
	}

	function get_display($upper_box=false, $display_empty=false, $forced_title='')
	{
		global $template, $forums;

		// prepare result
		$res = '';

		// check if we display something
		if ( $display_empty || ($upper_box && !empty($this->data_ext)) || (!$upper_box && !empty($this->data)) )
		{
			// save and reset template
			$save_tpl = array();
			$template->save($save_tpl);

			// choose tpl
			$template->set_filenames(array('topics_box' => 'topics_box.tpl'));

			// send display
			$this->display($upper_box, $display_empty, $forced_title);

			// get result
			$res = $template->get_pparse('topics_box');

			// restore template
			$template->restore($save_tpl);
		}
		return $res;
	}

	function display($upper_box=false, $display_empty=false, $forced_title='')
	{
		global $template, $config, $user, $forums;

		// prepare title enhancement
		$this->front_title = new front_title();

		// split level
		if ( $upper_box )
		{
			$split_global = $split_announces = $split_stickies = $title_global = $title_stickies = false;
		}
		else
		{
			$title_global = ($config->data['topics_split_global'] == TITLE_ONLY);
			$split_global = ($config->data['topics_split_global'] == SPLIT_IN_BOX);
			$split_announces = ($config->data['topics_split_announces'] == SPLIT_IN_BOX);
			$title_stickies = ($config->data['topics_split_stickies'] == TITLE_ONLY);
			$split_stickies = ($config->data['topics_split_stickies'] == SPLIT_IN_BOX);
		}

		// choose data
		if ( $upper_box )
		{
			$data = &$this->data_ext;
		}
		else
		{
			$data = &$this->data;
		}

		// let's go
		$no_topics_msg = ($forums->data[$this->forum_id]['forum_status'] == FORUM_LOCKED) ? 'Forum_locked' : (!$user->auth(POST_FORUM_URL, 'auth_read', $this->forum_id) ? ($user->data['session_logged_in'] ? 'Auth_read_required' : 'Registration_required') : ($user->auth(POST_FORUM_URL, 'auth_post', $this->forum_id) ? 'No_topics_post_one' : 'No_topics'));
		$new_topic_msg = ($forums->data[$this->forum_id]['forum_status'] == FORUM_LOCKED) ? 'Forum_locked' : 'Post_new_topic';
		$new_topic_img = ($forums->data[$this->forum_id]['forum_status'] == FORUM_LOCKED) ? 'post_locked' : 'post_new';
		$display_empty |= ($forums->data[$this->forum_id]['forum_type'] == POST_FORUM_URL) && !$upper_box;
		if ( !empty($data) || $display_empty )
		{
			// send legend
			$template->assign_vars(array(
				'L_TOPICS' => empty($forced_title) ? $user->lang('Topics') : $user->lang($forced_title),
				'L_REPLIES' => $user->lang('Replies'),
				'L_AUTHOR' => $user->lang('Author'),
				'L_VIEWS' => $user->lang('Views'),
				'L_LASTPOST' => $user->lang('Last_Post'),
				'L_VIEW_PROFILE' => $user->lang('Read_profile'),

				'I_LAST_POST' => $user->img('icon_latest_reply'),
				'L_LAST_POST' => $user->lang('View_latest_post'),

				'L_NO_TOPICS' => empty($this->extra_parms) ? $user->lang($no_topics_msg) : $user->lang('No_topics'),

				'U_POST_NEW_TOPIC' => $config->url('posting', array('mode' => 'newtopic', POST_FORUM_URL => $this->forum_id), true),
				'L_POST_NEW_TOPIC' => $user->lang($new_topic_msg),
				'I_POST_NEW_TOPIC' => $user->img($new_topic_img),

				'I_SPACER' => $user->img('spacer'),

				'S_ACTION' => $config->url('index', array(POST_FORUM_URL => $this->forum_id), true),
			));

			// display forum's commands and pagination
			if ( !$upper_box || $display_empty )
			{
				$template->assign_block_vars('forum_header', array(
					'U_VIEW_FORUM' => $config->url('index', array(POST_FORUM_URL => $this->forum_id) + $this->parms, true),
					'FORUM_NAME' => $user->lang($forums->data[$this->forum_id]['forum_name']),
					'FORUM_DESC' => _clean_html($user->lang($forums->data[$this->forum_id]['forum_desc'])),
					'U_MARK_READ' => $config->url('index', array(POST_FORUM_URL => $this->forum_id, 'mark' => 'topics'), true),
					'L_MARK_READ' => $user->lang('Mark_all_topics'),
					'I_MARK_READ' => $user->img('topic_mark_read'),
				));
				$template->set_switch('forum_header.mark', $user->data['session_logged_in']);

				// pagination
				$parms = $this->parms;
				unset($parms['start']);
				$pagination = new pagination($this->requester, array(POST_FORUM_URL => $this->forum_id) + $parms, 'start');
				$pagination->display('forum_header.pagination', $this->total_topics - $this->total_announces, $this->parms['ppage'], $this->parms['start'], true, 'Topics_count', $this->total_topics);

				// moderators
				$forums->moderators->display('forum_header.moderators', $this->forum_id);
			}

			// dump topic rows
			$previous_group = POST_NORMAL;
			$previous_type = POST_NORMAL;
			$block_header_sent = false;
			$linefeed = false;
			if ( !empty($data) )
			{
				foreach ( $data as $topic_id => $row )
				{
					// global and standard announces are considered the same
					$topic_type = $row['topic_type'];
					if ( ($topic_type == POST_GLOBAL_ANNOUNCE) && !$split_global && !$title_global )
					{
						$topic_type = POST_ANNOUNCE;
					}
					if ( ($topic_type == POST_STICKY) && !$split_stickies && !$title_stickies )
					{
						$topic_type = POST_NORMAL;
					}

					// search group topic type the topic belongs to
					if ( $upper_box )
					{
						$group_type = POST_NORMAL;
					}
					else if ( ($topic_type >= POST_GLOBAL_ANNOUNCE) && $split_global )
					{
						$group_type = POST_GLOBAL_ANNOUNCE;
					}
					else if ( ($topic_type >= POST_ANNOUNCE) && $split_announces )
					{
						$group_type = POST_ANNOUNCE;
					}
					else if ( ($topic_type >= POST_STICKY) && $split_stickies )
					{
						$group_type = POST_STICKY;
					}
					else
					{
						$group_type = POST_NORMAL;
					}

					// do we need a new block ?
					$new_block = !$block_header_sent || ($group_type != $previous_group);

					// close the previous block
					if ( $block_header_sent && $new_block )
					{
						$template->set_switch('topicrow');
						$template->set_switch('topicrow.endblock');
						$template->set_switch('topicrow.endblock.select', $this->with_select);
						$block_header_sent = false;
						$linefeed = true;
					}

					// new block start
					if ( $new_block )
					{
						// get the box title
						if ( !empty($forced_title) )
						{
							$box_title = $forced_title;
						}
						else if ( $upper_box && $display_empty )
						{
							$box_title = 'Topics';
						}
						else
						{
							switch ( $group_type )
							{
								case POST_GLOBAL_ANNOUNCE:
									$box_title = ($topic_type == POST_GLOBAL_ANNOUNCE) ? 'Global_Announces' : 'Topics';
									break;
								case POST_ANNOUNCE:
									$box_title = ($topic_type == POST_ANNOUNCE) ? 'Announces' : 'Topics';
									break;
								case POST_STICKY:
									$box_title = ($topic_type == POST_STICKY) ? 'Stickies' : 'Important_topics';
									break;
								case POST_NORMAL:
									$box_title = $upper_box ? 'Board_announces' : 'Topics';
									break;
							}
						}

						// send box header
						$template->assign_block_vars('topicrow', array(
							'L_BOX_TITLE' => $user->lang($box_title),
						));
						$template->set_switch('topicrow.spacing', $linefeed);
						$template->set_switch('topicrow.startblock');
						$template->set_switch('topicrow.startblock.select', $this->with_select);
						$template->set_switch('topicrow.startblock.no_topics', false);
						$template->set_switch('topicrow.startblock.no_topics_ELSE.select', $this->with_select);
						$block_header_sent = true;
						$linefeed = false;
					}

					// do we need a topic type header ?
					$new_header = !$upper_box && ($topic_type != $previous_type) && (!$new_block || ($topic_type > $group_type));
					$header_title = $new_header ? $this->get_header_title($topic_type) : '';

					// display topic
					$add_nav = ($row['forum_id'] != $this->forum_id);
					$this->display_a_topic($row, $header_title, $add_nav);

					// save types
					$previous_group = $group_type;
					$previous_type = $topic_type;
				}
			}
			else
			{
				// send box header
				$template->assign_block_vars('topicrow', array(
					'L_BOX_TITLE' => empty($forced_title) ? $user->lang('Topics') : $user->lang($forced_title),
				));
				$template->set_switch('topicrow.spacing', $linefeed);
				$template->set_switch('topicrow.startblock');
				$template->set_switch('topicrow.startblock.select', $this->with_select);
				$template->set_switch('topicrow.no_topics');
				$template->set_switch('topicrow.no_topics.select', $this->with_select);
				$template->set_switch('topicrow.startblock.no_topics');
				$template->set_switch('topicrow.startblock.no_topics.select', $this->with_select);
				$block_header_sent = true;
			}

			// close the previous block
			if ( $block_header_sent )
			{
				if ( !$upper_box || $display_empty )
				{
					$this->bottom_line(empty($data));
				}
				$template->set_switch('topicrow');
				$template->set_switch('topicrow.endblock');
				$template->set_switch('topicrow.endblock.select', $this->with_select);
				$block_header_sent = false;
			}
		}
	}

	function bottom_line($empty=false)
	{
		global $template, $user;

		$template->set_switch('topicrow');
		$template->set_switch('topicrow.bottom');
		$template->set_switch('topicrow.bottom.select', $this->with_select);
		$template->set_switch('topicrow.bottom.no_topics', $empty);
		if ( $empty )
		{
			$template->set_switch('topicrow.bottom.no_topics.select', $this->with_select);
		}
		else
		{
			$template->set_switch('topicrow.bottom.no_topics_ELSE.select', $this->with_select);
		}
		$template->assign_vars(array(
			'L_PREVIOUS_DAYS' => $user->lang('Display_topics'),
			'L_SORT_BY' => $user->lang('Sort_by'),
			'L_GO' => $user->lang('Go'),
			'I_GO' => $user->img('cmd_mini_submit'),
		));

		$lists = array(
			'topicdays' => array(0 => 'All_Topics', 1 => '1_Day', 7 => '7_Days', 14 => '2_Weeks', 30 => '1_Month', 90 => '3_Months', 180 => '6_Months', 364 =>'1_Year'),
			'sort' => &$this->sort_fields,
			'order' => array('ASC' => 'Sort_Ascending', 'DESC' => 'Sort_Descending'),
		);
		foreach ( $lists as $parm => $list )
		{
			$options[ strtoupper($parm) ] = '';
			foreach ( $list as $value => $desc )
			{
				$selected = ($this->parms[$parm] == $value) ? ' selected="selected"' : '';
				$options[ strtoupper($parm) ] .= '<option value="' . $value . '"' . $selected . '>' . (is_array($desc) ? $user->lang($desc['txt']) : $user->lang($desc)) . '</option>';
			}
		}
		$template->assign_vars($options);
		$template->set_filenames(array('bottom_row' => 'topics_bottom_forum.tpl'));
		$template->assign_var_from_handle('BOTTOM_ROW', 'bottom_row');
	}

	function get_header_title($header_type)
	{
		$header_types = array(
			POST_GLOBAL_ANNOUNCE => 'Global_Announces',
			POST_ANNOUNCE => 'Announces',
			POST_STICKY => 'Stickies',
			POST_NORMAL => 'Topics',
		);
		foreach ( $header_types as $type => $txt )
		{
			if ( $header_type <= $type )
			{
				$res = $txt;
			}
			else
			{
				break;
			}
		}
		return $res;
	}

	//
	// display the topic row
	//
	function display_a_topic($row, $header_title='', $with_nav=false)
	{
		global $template, $config, $user, $forums, $icons, $topics_attr;
		global $images;
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		global $colors;
//-- fin mod : Advanced Group Color Management ---------------------------------


		// retreive topic type attributs
		$attr = $topics_attr->get_attr($row);
		$count_attr = count($attr);

		// folder image
		$s_folder_img = $user->img($attr[0]['img']);
		$s_folder_txt = '';
		$count_txt = count($attr[0]['txt']);
		for ( $i = 0; $i < $count_txt; $i++ )
		{
			$s_folder_txt .= (empty($s_folder_txt) ? '&nbsp;' : "&nbsp;\n&nbsp;") . _clean_html($user->lang($attr[0]['txt'][$i]));
		}

		// usernames
		if ( ($row['topic_poster'] != ANONYMOUS) && isset($user->pool[ $row['topic_poster'] ]) )
		{
			$row['topic_first_username'] = $user->pool[ $row['topic_poster'] ]['username'];
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$row['topic_first_user_group_id'] = $user->pool[ $row['topic_poster'] ]['user_group_id'];
			$row['topic_first_user_session_time'] = $user->pool[ $row['topic_poster'] ]['user_session_time'];
//-- fin mod : Advanced Group Color Management ---------------------------------

		}
		if ( ($row['topic_last_poster'] != ANONYMOUS) && isset($user->pool[ $row['topic_last_poster'] ]) )
		{
			$row['topic_last_username'] = $user->pool[ $row['topic_last_poster'] ]['username'];
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$row['topic_last_user_group_id'] = $user->pool[ $row['topic_last_poster'] ]['user_group_id'];
			$row['topic_last_user_session_time'] = $user->pool[ $row['topic_last_poster'] ]['user_session_time'];
//-- fin mod : Advanced Group Color Management ---------------------------------

		}

//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		if ( $row['topic_poster'] == ANONYMOUS )
		{
			$row['topic_first_user_group_id'] = '0';
			$row['topic_first_user_session_time'] = '0';
		}

		if ( $row['topic_last_poster'] == ANONYMOUS )
		{
			$row['topic_last_user_group_id'] = '0';
			$row['topic_last_user_session_time'] = '0';
		}
//-- fin mod : Advanced Group Color Management ---------------------------------

		// send to template
		$template->assign_block_vars('topicrow', array(
			'L_HEADER_TITLE' => $user->lang($header_title),

			'I_TOPIC_FOLDER' => $s_folder_img,
			'L_TOPIC_FOLDER' => $s_folder_txt,

			'U_NEWEST_POST' => $config->url($this->requester_topics, array(POST_TOPIC_URL => $row['topic_id'], 'view' => 'newest'), true),
			'L_NEWEST_POST' => $user->lang('View_newest_post'),
			'I_NEWEST_POST' => $user->img('icon_newest_reply'),

			'U_VIEW_TOPIC' => $config->url($this->requester_topics, $this->extra_parms + array(POST_TOPIC_URL => ((!empty($row['topic_moved_id']) && empty($this->extra_parms)) ? $row['topic_moved_id'] : $row['topic_id'])), true),
			'TOPIC_TITLE' => _censor($row['topic_title']),
			'TOPIC_SUB_TITLE' => _censor($row['topic_sub_title']),
			'TOPIC_ID' => $row['topic_id'],

			'U_TOPIC_AUTHOR' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['topic_poster']), true),
//-- mod : Advanced Group Color Management -------------------------------------
//-- here we replaced
//	$user->lang('Guest') : $row['topic_first_username'],
//-- with
//	$colors->get_user_color($row['topic_first_user_group_id'], '0', $user->lang('Guest')) : $colors->get_user_color($row['topic_first_user_group_id'], $row['topic_first_user_session_time'], $row['topic_first_username']),
//-- modify

			'TOPIC_AUTHOR' => (empty($row['topic_first_username']) || ($row['topic_first_username'] == ANONYMOUS)) ? $colors->get_user_color($row['topic_first_user_group_id'], '0', $user->lang('Guest')) : $colors->get_user_color($row['topic_first_user_group_id'], $row['topic_first_user_session_time'], $row['topic_first_username']),
//-- fin mod : Advanced Group Color Management ---------------------------------

			'VIEWS' => $row['topic_moved_id'] ? '' : $row['topic_views'],
			'REPLIES' => $row['topic_moved_id'] ? '' : $row['topic_replies'],

			'LAST_POST_TIME' => $row['topic_moved_id'] ? '' : $user->date($row['topic_last_time']),
			'U_LAST_POST_AUTHOR' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['topic_last_poster']), true),
//-- mod : Advanced Group Color Management -------------------------------------
//-- here we replaced
//	$user->lang('Guest') : $row['topic_last_username']),
//-- with
//	$colors->get_user_color($row['topic_last_user_group_id'], '0', $user->lang('Guest')) : $colors->get_user_color($row['topic_last_user_group_id'], $row['topic_last_user_session_time'], $row['topic_last_username'])),
//-- modify

			'LAST_POST_AUTHOR' => $row['topic_moved_id'] ? '' : ((empty($row['topic_last_username']) || ($row['topic_last_username'] == ANONYMOUS)) ? $colors->get_user_color($row['topic_last_user_group_id'], '0', $user->lang('Guest')) : $colors->get_user_color($row['topic_last_user_group_id'], $row['topic_last_user_session_time'], $row['topic_last_username'])),
//-- fin mod : Advanced Group Color Management ---------------------------------

			'U_LAST_POST' => $config->url($this->requester_topics, array(POST_POST_URL => $row['topic_last_post_id']), true, $row['topic_last_post_id']),
		));
		$template->set_switch('topicrow.topic');
		$template->set_switch('topicrow.topic.select', $this->with_select);
		$template->set_switch('topicrow.topic.moved', !empty($row['topic_moved_id']));
		$template->set_switch('topicrow.topic.last_post_link', empty($row['topic_moved_id']) && !$this->with_select);
		$template->set_switch('topicrow.topic.newest_post', !empty($row['topic_unread']));
		$template->set_switch('topicrow.topic.header', !empty($header_title));
		if ( !empty($header_title) )
		{
			$template->set_switch('topicrow.topic.header.select', $this->with_select);
		}
		else
		{
			$template->set_switch('topicrow.topic.header_ELSE.select', $this->with_select);
		}
		$template->set_switch('topicrow.topic.author_userlink', ($row['topic_poster'] != ANONYMOUS) && !empty($row['topic_poster']));
		$template->set_switch('topicrow.topic.last_post_userlink', ($row['topic_last_poster'] != ANONYMOUS) && !empty($row['topic_last_poster']));

		// enhance the topic title
		$row['post_icon'] = $row['topic_icon'];
		$this->front_title->set('topicrow.topic', $row);

		// pagination/navigation
		if ( empty($row['topic_moved_id']) && (($row['topic_replies'] + 1) > $config->data['posts_per_page']) )
		{
			$pagination = new pagination($this->requester_topics, array(POST_TOPIC_URL => $row['topic_id']) + $this->extra_parms, 'start');
			$pagination->display('topicrow.topic.pagination', $row['topic_replies'] + 1, $config->data['posts_per_page'], 0, false);
		}
		if ( $with_nav )
		{
			$template->set_switch('topicrow.topic.navigation');
			$forums->display_nav($row['forum_id'], 'topicrow.topic.navigation.nav', true);
		}
		$template->set_switch('topicrow.topic.pagination_OR_nav', isset($pagination) || $with_nav);

		// sub topic type (moved, poll, etc.)
		for ( $i = 1; $i < $count_attr; $i++ )
		{
			if ( !empty($attr[$i]['txt']) || !empty($attr[$i]['img']) )
			{
				$img = !empty($attr[$i]['img']) && isset($images[ $attr[$i]['img'] ]);
				$template->assign_block_vars('topicrow.topic.type', array(
					'L_TOPIC_TYPE' => $img ? _clean_html($user->lang($attr[$i]['txt'])) : $user->lang($attr[$i]['txt']),
					'I_TOPIC_TYPE' => $img ? $user->img($attr[$i]['img']) : '',
				));
				$template->set_switch('topicrow.topic.type.txt', !empty($attr[$i]['txt']) && !$img);
				$template->set_switch('topicrow.topic.type.img', $img);
			}
		}
	}
}

?>