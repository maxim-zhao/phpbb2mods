<?php
//
//	file: includes/class_posts.php
//	author: ptirhiik
//	begin: 23/12/2005
//	version: 1.6.6 - 01/07/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class posts
{
	var $requester;
	var $parms;
	var $now;
	var $highlight;
	var $ppage;
	var $sort;
	var $order;

	var $topic_fields;
	var $sort_fields;

	var $forum_id;
	var $topic_id;
	var $post_id;
	var $total_items;

	var $data;
	var $topic;
	var $previous_fields;

	var $topic_last_read;
	var $user_ids;

	var $ranks_done;
	var $ranks_special;
	var $ranks_regular;
	var $front_title;

	var $poster_block_vars;
	var $cookies_setup;

	var $review;
	var $shorten;
	var $plug_ins;

	function posts($requester='', $parms='')
	{
		global $config;

		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;

		$this->now = time();

		$this->highlight = '';
		$this->ppage = 0;
		$this->sort = '';
		$this->order = '';

		$this->forum_id = 0;
		$this->topic_id = 0;
		$this->post_id = 0;
		$this->topic_last_read = 0;

		$this->data = array();
		$this->topic = array();
		$this->previous_fields = array();

		$this->user_ids = array();

		$this->ranks_done = false;
		$this->ranks_special = array();
		$this->ranks_regular = array();

		$this->front_title = new front_title();

		$this->poster_block_vars = array();
		$this->cookies_setup = array();

		// topic fields
		$this->topic_fields = array(
			'topic_id',
			'forum_id',
			'topic_title',
			'topic_sub_title',
			'topic_icon',
			'topic_status',
			'topic_vote',
			'topic_type',
			'topic_sub_type',
			'topic_duration',
			'topic_time',
			'topic_first_post_id',
			'topic_last_post_id',
			'topic_last_time',
			'topic_replies',
		);

		$this->sort_fields = array(
			'lastpost' => 'Sort_Time',
			'title' => 'Sort_Post_Subject',
			'author' => 'Sort_Author',
		);
		$this->review = false;
		$this->shorten = false;

		// get plug ins
		$plug_ins = new plug_ins();
		$plug_ins->load('class_posts');
		unset($plug_ins);
		$this->plug_ins = &$config->plug_ins['class_posts'];
	}

	function init()
	{
		// plugs
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'set_posts') )
				{
					$this->plug_ins[$plug]->set_posts($this);
				}
				if ( method_exists($this->plug_ins[$plug], 'topic_fields') )
				{
					$this->plug_ins[$plug]->topic_fields($this->topic_fields);
				}
			}
		}
	}

	function get_order()
	{
		global $user;

		$sql_order = array();

		switch ( $this->sort )
		{
			case 'lastpost':
				$sql_order = array(
					'order' => 'p.post_time' . ($this->order != 'DESC' ? '' : ' DESC') . ', p.post_id' . ($this->order != 'DESC' ? '' : ' DESC'),
				);
				break;
			case 'title':
				$sql_order = array(
					'order' => 'pt.post_subject' . ($this->order != 'DESC' ? '' : ' DESC') . ', p.post_id' . ($this->order != 'DESC' ? '' : ' DESC'),
				);
				break;
			case 'author':
				$sql_order = array(
					'fields' => ', u.' . implode(', u.', $user->pool_fields),
					'order' => 'u.username' . ($this->order != 'DESC' ? '' : ' DESC')  . ', p.post_id' . ($this->order != 'DESC' ? '' : ' DESC'),
					'from' => ', ' . USERS_TABLE . ' u',
					'where' => 'u.user_id = p.poster_id',
				);
				break;
		}
		return $sql_order;
	}

	function get_previous_order($for_topic=false)
	{
		// we want to read the topic with the necessary informations to get previous posts
		if ( $for_topic )
		{
			return array(
				'fields' => ', p.post_time, pt.post_subject, u.username',
				'from' => ', ' . POSTS_TEXT_TABLE . ' pt, ' . USERS_TABLE . ' u',
				'where' => 'pt.post_id = p.post_id AND u.user_id = p.poster_id',
				'previous_fields' => array('p.post_time', 'p.post_subject', 'u.username'),
			);
		}

		// we want to get the posts previous the criterias
		$sql_order = $this->get_order();
		switch ( $this->sort )
		{
			case 'lastpost':
				$sql_order = array_merge($sql_order, array(
					'fields' => ', p.post_time',
					'type' => TYPE_INT,
					'comp' => $this->order != 'DESC' ? '<' : '>',
				));
				break;
			case 'title':
				$sql_order = array_merge($sql_order, array(
					'fields' => ', pt.post_subject',
					'type' => TYPE_NO_HTML,
					'comp' => $this->order != 'DESC' ? '<' : '>',
					'from' => ', ' . POSTS_TEXT_TABLE . ' pt',
					'where' => 'pt.post_id = p.post_id',
				));
				break;
			case 'author':
				$sql_order = array_merge($sql_order, array(
					'fields' => ', u.username',
					'type' => TYPE_NO_HTML,
					'comp' => $this->order != 'DESC' ? '<' : '>',
				));
				break;
		}
		return $sql_order;
	}

	function read_topic($topic_id, $post_id=0)
	{
		global $db;

		// topic header already readed
		if ( empty($this->topic) )
		{
			if ( !empty($topic_id) )
			{
				$sql = 'SELECT ' . implode(', ', $this->topic_fields) . '
							FROM ' . TOPICS_TABLE . '
							WHERE topic_id = ' . intval($topic_id);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				if ( $row = $db->sql_fetchrow($result) )
				{
					foreach ( $this->topic_fields as $field )
					{
						$this->topic[$field] = $row[$field];
					}
				}
				$db->sql_freeresult($result);
			}
			else if ( !empty($post_id) )
			{
				$sql_order = $this->get_previous_order(true);

				// get the topic data
				$sql = 'SELECT t.' . implode(', t.', $this->topic_fields) . $sql_order['fields'] . '
							FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p' . $sql_order['from'] . '
							WHERE p.post_id = ' . intval($post_id) . '
								AND t.topic_id = p.topic_id' . (empty($sql_order['where']) ? '' : '
								AND ' . $sql_order['where']) . '
							LIMIT 1';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				if ( $row = $db->sql_fetchrow($result) )
				{
					foreach ( $this->topic_fields as $field )
					{
						$this->topic[$field] = $row[$field];
					}
					if ( !empty($sql_order['previous_fields']) )
					{
						foreach ( $sql_order['previous_fields'] as $field )
						{
							$row_field = substr(strrchr($field, '.'), 1);
							$this->previous_fields[$field] = $row[$row_field];
						}
					}
				}
				$db->sql_freeresult($result);
			}
		}

		// get ids
		$this->forum_id = intval($this->topic['forum_id']);
		$this->topic_id = intval($this->topic['topic_id']);
		$this->post_id = intval($post_id);
		$this->topic_last_read = isset($this->topic['topic_last_time']) ? intval($this->topic['topic_last_time']) : 0;
	}

	function get_parms()
	{
		global $db, $config, $user;

		// ensure config is ok
		if ( empty($config->data['posts_per_page']) )
		{
			$config->data['posts_per_page'] = 25;
		}
		if ( empty($config->data['posts_sort']) )
		{
			$config->data['posts_sort'] = 'lastpost';
		}
		if ( empty($config->data['posts_order']) )
		{
			$config->data['posts_order'] = 'ASC';
		}

		// get user pref
		$dft_ppage = !isset($user->data['user_posts_ppage']) || !intval($user->data['user_posts_ppage']) || (isset($config->data['posts_per_page_over']) && intval($config->data['posts_per_page_over'])) ? intval($config->data['posts_per_page']) : intval($user->data['user_posts_ppage']);
		$dft_sort = !isset($user->data['user_posts_sort']) || empty($user->data['user_posts_sort']) || (isset($config->data['posts_sort_over']) && intval($config->data['posts_sort_over'])) ? $config->data['posts_sort'] : $user->data['user_posts_sort'];
		$dft_order = !isset($user->data['user_posts_order']) || empty($user->data['user_posts_order']) || (isset($config->data['posts_sort_over']) && intval($config->data['posts_sort_over'])) ? $config->data['posts_order'] : $user->data['user_posts_order'];

		// delete parms if equal to default or forced in config
		if ( isset($this->parms['ppage']) && (intval($this->parms['ppage']) == $dft_ppage) )
		{
			unset($this->parms['ppage']);
		}
		if ( isset($this->parms['sort']) && ($this->parms['sort'] == $dft_sort) )
		{
			unset($this->parms['sort']);
		}
		if ( isset($this->parms['postorder']) && ($this->parms['postorder'] == $dft_order) )
		{
			unset($this->parms['postorder']);
		}

		// remove empty parms
		if ( !empty($this->parms) )
		{
			foreach ( $this->parms as $key => $value )
			{
				if ( empty($value) )
				{
					unset($this->parms[$key]);
				}
			}
		}
		$this->ppage = !isset($this->parms['ppage']) || !intval($this->parms['ppage']) ? $dft_ppage : intval($this->parms['ppage']);
		$this->sort = !isset($this->parms['sort']) || empty($this->parms['sort']) ? $dft_sort : $this->parms['sort'];
		$this->order = !isset($this->parms['postorder']) || empty($this->parms['postorder']) ? $dft_order : $this->parms['postorder'];

		// now search for previous posts to get the start parm
		if ( empty($this->post_id) || empty($this->topic_id) || empty($this->previous_fields) )
		{
			return;
		}

		$this->parms['start'] = 0;
		$sql_order = $this->get_previous_order(false);

		$comp = $sql_order['comp'];
		$field = substr($sql_order['fields'], 2);
		$value = $sql_order['type'] == TYPE_INT ? intval($this->previous_fields[$field]) : '\'' . $db->sql_escape_string($this->previous_fields[$field]) . '\'';
		$only_post = ($field == 'p.post_time');
		$only_equal = empty($this->previous_fields[$field]) && ($comp == '<');

		$postdays = intval($this->parms['postdays']) && (($this->now - (intval($this->parms['postdays']) * 86400)) > $this->topic['topic_time']) ? $this->now - (intval($this->parms['postdays']) * 86400) : 0;
		$sql = 'SELECT p.post_id
					FROM ' . POSTS_TABLE . ' p' . $sql_order['from'] . '
					WHERE p.topic_id = ' . intval($this->topic_id) . (empty($postdays) ? '' : '
						AND p.post_time >= ' . $postdays) . (empty($sql_order['where']) ? '' : '
						AND ' . $sql_order['where']) . ($only_post ? '
						AND p.post_id ' . $comp . '= ' . intval($this->post_id) : ($only_equal ? '
						AND (' . $field . ' = ' . $value . ' AND p.post_id ' . $comp . '= ' . intval($this->post_id) . ')' : '
						AND (' . $field . ' ' . $comp . ' ' . $value . ' OR (' . $field . ' = ' . $value . ' AND p.post_id ' . $comp . '= ' . intval($this->post_id) . '))'));
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		if ( $previous_posts = $db->sql_numrows($result) )
		{
			$this->parms['start'] = $this->ppage * intval(($previous_posts - 1) / $this->ppage);
		}
		$db->sql_freeresult($result);
	}

	function set_highlight($highlight)
	{
		$this->highlight = _format_highlight($highlight);
	}

	function read()
	{
		global $db;

		$this->data = array();
		$this->user_ids = array();

		$sql_order = $this->get_order();

		// get number of posts
		$this->total_items = isset($this->topic['topic_replies']) ? intval($this->topic['topic_replies']) + 1 : 1;
		$postdays = isset($this->parms['postdays']) && intval($this->parms['postdays']) && (($this->now - (intval($this->parms['postdays']) * 86400)) > $this->topic['topic_time']) ? $this->now - (intval($this->parms['postdays']) * 86400) : 0;
		if ( $postdays )
		{
			$sql = 'SELECT COUNT(post_id) AS count_post_id
						FROM ' . POSTS_TABLE . '
						WHERE topic_id = ' . intval($this->topic_id) . '
							AND post_time >= ' . $postdays;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$this->total_items = ($row = $db->sql_fetchrow($result)) ? intval($row['count_post_id']) : 0;
			$db->sql_freeresult($result);
		}

		$post_ids = array();
		if ( $this->total_items )
		{
			// get posts
			$sql = 'SELECT p.*, pt.post_subject, pt.post_sub_title, pt.post_text, pt.bbcode_uid' . (isset($sql_order['fields']) ? $sql_order['fields'] : '') . '
						FROM ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt' . (isset($sql_order['from']) ? $sql_order['from'] : '') . '
						WHERE p.topic_id = ' . intval($this->topic_id) . '
							AND pt.post_id = p.post_id' . (empty($sql_order['where']) ? '' : '
							AND ' . $sql_order['where']) . (empty($postdays) ? '' : '
							AND p.post_time >= ' . $postdays) . '
						ORDER BY ' . $sql_order['order'] . '
						LIMIT ' . (isset($this->parms['start']) ? intval($this->parms['start']) : 0) . ', ' . intval($this->ppage);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$this->do_read($result);
			$db->sql_freeresult($result);
		}
	}

	function do_read(&$result, $ppage=0)
	{
		global $db;

		$this->data = array();
		$this->pre_process();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->row_process($row);
			$this->data[ intval($row['post_id']) ] = $row;
		}
		$this->post_process();
	}

	function pre_process()
	{
		global $user;

		// init users to read
		$this->user_ids = array();

		// read cookies setup
		$this->cookies_setup = $user->get_cookies_setup();
	}

	function row_process(&$row)
	{
		global $user;

		// clear un-necessary field_ids
		foreach ( $row as $key => $value )
		{
			if ( !is_string($key) )
			{
				unset($row[$key]);
			}
		}

		// unread status
		$row['post_unread'] = !empty($this->topic_last_read) && ($row['post_time'] > $this->topic_last_read);

		// user ids
		$row['poster_id'] = intval($row['poster_id']) ? intval($row['poster_id']) : ANONYMOUS;
		if ( ($row['poster_id'] != ANONYMOUS) && !isset($user->pool[ $row['poster_id'] ]) && !isset($this->user_ids[ $row['poster_id'] ]) )
		{
			// we have the author fields
			if ( $this->sort == 'author' )
			{
				foreach ( $user->pool_fields as $field )
				{
					$user->pool[ $row['poster_id'] ][$field] = $row[$field];
				}
			}
			// we don't have the author fields
			else
			{
				$this->user_ids[ $row['poster_id'] ] = true;
			}
		}
	}

	function post_process()
	{
		global $user;

		$user->read_pool($this->user_ids);
		$this->user_ids = array();

		// plugs
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'read') )
				{
					$this->plug_ins[$plug]->read();
				}
			}
		}
	}

	function display()
	{
		global $config, $user, $template;

		if ( !empty($this->data) )
		{
			$color = false;
			foreach ( $this->data as $post_id => $row )
			{
				$color = !$color;
				$this->display_a_post($row, $color);
			}

			// plugs
			if ( $this->plug_ins )
			{
				foreach ( $this->plug_ins as $plug => $dummy )
				{
					if ( method_exists($this->plug_ins[$plug], 'update_views') )
					{
						$this->plug_ins[$plug]->update_views();
					}
				}
			}
		}
		else
		{
			$template->assign_vars(array(
				'L_EMPTY' => $user->lang('No_posts_match'),
			));
			$template->set_switch('empty');
		}

		// various constants
		$template->assign_vars(array(
			// author panel
			'L_POSTER_POSTS' => $user->lang('Posts'),
			'L_POSTER_FROM' => $user->lang('Location'),
			'L_POSTER_JOINED' => $user->lang('Joined'),

			// message panel
			'L_POSTED' => $user->lang('Posted'),
			'L_POST_SUBJECT' => $user->lang('Post_subject'),

			// post buttons
			'I_POST_QUOTE' => $user->img('icon_quote'),
			'L_POST_QUOTE' => $user->lang('Reply_with_quote'),
			'I_POST_EDIT' => $user->img('icon_edit'),
			'L_POST_EDIT' => $user->lang('Edit_delete_post'),
			'I_POST_IP' => $user->img('icon_ip'),
			'L_POST_IP' => $user->lang('View_IP'),
			'I_POST_DELETE' => $user->img('icon_delpost'),
			'L_POST_DELETE' => $user->lang('Delete_post'),
			'I_POST_UNREAD' => $user->img('icon_unmark_read'),
			'L_POST_UNREAD' => $user->lang('Post_unmark_read'),
			'I_BACK_TO_TOP' => $user->img('icon_go_top'),
			'L_BACK_TO_TOP' => $user->lang('Back_to_top'),

			// users buttons
			'I_POSTER_PROFILE' => $user->img('icon_profile'),
			'L_POSTER_PROFILE' => $user->lang('Read_profile'),
			'I_POSTER_SEARCH' => $user->img('icon_search'),
			'I_POSTER_PM' => $user->img('icon_pm'),
			'L_POSTER_PM' => $user->lang('Send_private_message'),
			'I_POSTER_EMAIL' => $user->img('icon_email'),
			'L_POSTER_EMAIL' => $user->lang('Send_email'),
			'I_POSTER_WWW' => $user->img('icon_www'),
			'L_POSTER_WWW' => $user->lang('Visit_website'),
			'I_POSTER_ICQ' => $user->img('icon_icq'),
			'L_POSTER_ICQ' => $user->lang('ICQ'),
			'I_POSTER_AIM' => $user->img('icon_aim'),
			'L_POSTER_AIM' => $user->lang('AIM'),
			'I_POSTER_MSN' => $user->img('icon_msnm'),
			'L_POSTER_MSN' => $user->lang('MSNM'),
			'I_POSTER_YIM' => $user->img('icon_yim'),
			'L_POSTER_YIM' => $user->lang('YIM'),
		));
	}

	function display_a_post(&$row, $color, $tpl_switch='')
	{
		global $config, $user, $forums, $template, $theme;

		// fix tpl level
		$tpl_switch = empty($tpl_switch) ? 'postrow' : $tpl_switch;

		// get poster id
		$poster_id = isset($user->pool[ $row['poster_id'] ]) ? $row['poster_id'] : ANONYMOUS;

		// get user tpl vars
		$user_blocks = $this->poster_block_vars($poster_id);
		$switches = empty($user_blocks['switches']) ? array() : $user_blocks['switches'];
		$user_block_vars = empty($user_blocks['data']) ? array() : $user_blocks['data'];
		unset($user_blocks);

		// Handle anon users posting with usernames
		if ( $poster_id == ANONYMOUS )
		{
			$user_block_vars['POSTER_NAME'] = empty($row['post_username']) ? $user->lang('Guest') : $row['post_username'];
		}
		$poster = $user_block_vars['POSTER_NAME'];

		// fix sig not asked
		if ( !$row['enable_sig'] )
		{
			$user_block_vars['SIGNATURE'] = '';
			if ( isset($switches['signature']) )
			{
				unset($switches['signature']);
			}
		}

		// buttons
		$buttons = $this->get_buttons($row);

		// parse message
		$this->parse_message($row);

		// build final tpl_vars
		$tpl_vars = array_merge($user_block_vars, array(
			'ROW_COLOR' => $color ? '#' . $theme['td_color1'] : '#' . $theme['td_color2'],
			'ROW_CLASS' => $color ? $theme['td_class1'] : $theme['td_class2'],

			'POST_DATE' => $user->date($row['post_time']),
			'POST_SUBJECT' => _highlight(_censor($row['post_subject']), $this->highlight),
			'MESSAGE' => $row['post_text'],
			'EDITED_MESSAGE' => $row['post_edit_count'] ? sprintf($user->lang(($row['post_edit_count'] == 1) ? 'Edited_time_total' : 'Edited_times_total'), $poster, $user->date($row['post_edit_time']), $row['post_edit_count']) : '',

			'U_POST_ID' => $row['post_id'],
			'U_UNREAD_POST' => $config->url('viewtopic', array(POST_POST_URL => $row['post_id'], 'unmark' => 'post'), true),
		));
		unset($user_block_vars);

		// get remaining switches
		if ( !empty($buttons) )
		{
			foreach ( $buttons as $button => $data )
			{
				foreach ( $data as $key => $value )
				{
					$tpl_vars[strtoupper($key . '_' . $button)] = $value;
					$switches[$button] = true;
				}
			}
		}
		unset($buttons);

		// send to template
		$template->assign_block_vars($tpl_switch, $tpl_vars);
		$template->set_switch($tpl_switch . '.light', $color);

		// post switches
		$template->set_switch($tpl_switch . '.edited', $row['post_edit_count']);
		$template->set_switch($tpl_switch . '.unmark_read', $this->cookies_setup['keep_unreads']);

		// user & buttons switches
		if ( !empty($switches) )
		{
			foreach ( $switches as $key => $value )
			{
				$template->set_switch($tpl_switch . '.' . $key, $value);
			}
		}

		// enhance the topic title
		$this->front_title->set($tpl_switch, array_merge($forums->data[$this->forum_id], $this->topic, $row), $this->topic['topic_first_post_id'] == $row['post_id'], $this->highlight);

		// plugs
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( $this->plug_ins[$plug] )
				{
					if ( method_exists($this->plug_ins[$plug], 'display') )
					{
						$this->plug_ins[$plug]->display(intval($row['post_id']), $tpl_switch);
					}
				}
			}
		}
	}

	function get_buttons(&$row)
	{
		global $config, $user;

		$buttons = array();

		$parms = $this->parms;
		if ( isset($parms['start']) )
		{
			unset($parms['start']);
		}
		$buttons['post'] = array(
			'u' => $config->url('viewtopic', array(POST_POST_URL => $row['post_id']) + $parms, true, $row['post_id']),
			'i' => $row['post_unread'] ? $user->img('icon_minipost_new') : $user->img('icon_minipost'),
			'l' => $row['post_unread'] ? $user->lang('New_post') : $user->lang('Post'),
		);
		unset($parms);

		if ( $user->auth(POST_FORUM_URL, 'auth_reply', $this->forum_id) || $user->auth(POST_FORUM_URL, 'auth_mod', $this->forum_id) )
		{
			$buttons['quote'] = array(
				'u' => $config->url(POSTING, array('mode' => 'quote', POST_POST_URL => $row['post_id']), true),
			);
		}

		if ( (($user->data['user_id'] == intval($row['poster_id'])) && ($user->data['session_logged_in'] || (!$user->data['session_logged_in'] && ($user->data['session_ip'] == $row['poster_ip']))) && $user->auth(POST_FORUM_URL, 'auth_edit', $this->forum_id)) || $user->auth(POST_FORUM_URL, 'auth_mod', $this->forum_id) )
		{
			$buttons['edit'] = array(
				'u' => $config->url(POSTING, array('mode' => 'editpost', POST_POST_URL => $row['post_id']), true),
			);
		}

		if ( $user->auth(POST_FORUM_URL, 'auth_mod', $this->forum_id) )
		{
			$buttons['ip'] = array(
				'u' => $config->url('modcp', array('mode' => 'ip', POST_POST_URL => $row['post_id'], POST_TOPIC_URL => $this->topic_id, 'sid' => $user->data['session_id']), true),
			);
		}

		if ( (($this->topic['topic_last_post_id'] == $row['post_id']) && ($user->data['user_id'] == intval($row['poster_id'])) && ($user->data['session_logged_in'] || (!$user->data['session_logged_in'] && ($user->data['session_ip'] == $row['poster_ip']))) && $user->auth(POST_FORUM_URL, 'auth_delete', $this->forum_id)) || $user->auth(POST_FORUM_URL, 'auth_mod', $this->forum_id) )
		{
			$buttons['delete'] = array(
				'u' => $config->url(POSTING, array('mode' => 'delete', POST_POST_URL => $row['post_id'], 'sid' => $user->data['session_id']), true),
			);
		}
		return $buttons;
	}

	function parse_message(&$row, $max_chars=0)
	{
		global $config;

		if ( !class_exists('message') )
		{
			include($config->url('includes/class_message'));
		}
		$message = new message();
		$switches = array(
			'html' => $row['enable_html'],
			'bbcode' => !empty($row['bbcode_uid']),
			'smilies' => $row['enable_smilies'],
			'magic_url' => isset($row['magic_url']) ? $row['magic_url'] : true,
			'censor' => isset($row['censor']) ? $row['censor'] : true,
		);
		$message->parse($row['post_text'], $row['bbcode_uid'], $switches, $this->highlight, $max_chars);
		unset($message);
	}

	function poster_block_vars($poster_id)
	{
		global $user, $config;

		if ( !isset($this->poster_block_vars[$poster_id]) )
		{
			// avatar
			$avatar = $this->get_avatar($poster_id);

			// rank
			$rank = $this->get_rank($poster_id);

			// signature
			$user_sig = ($poster_id == ANONYMOUS) || empty($user->pool[$poster_id]['user_sig']) || !$config->data['allow_sig'] ? '' : trim($user->pool[$poster_id]['user_sig']);
			if ( !empty($user_sig) )
			{
				if ( !class_exists('message') )
				{
					include($config->url('includes/class_message'));
				}
				$signature = new message();
				$signature->parse($user_sig, $user->pool[$poster_id]['user_sig_bbcode_uid']);
				unset($signature);
			}

			// messangers/profile buttons
			$buttons = array();
			if ( $poster_id != ANONYMOUS )
			{
				$buttons['profile'] = array(
					'u' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $poster_id), true),
				);

				$buttons['search'] = array(
					'u' => $config->url('search', array('search_author' => rawurlencode($user->pool[$poster_id]['username']), 'showresults' => 'posts'), true),
					'l' => sprintf($user->lang('Search_user_posts'), $user->pool[$poster_id]['username']),
				);

				$online = !$user->pool[$poster_id]['user_session_logged'] || ($user->pool[$poster_id]['user_session_time'] < (time() - TIME_ONLINE_RANGE)) ? 0 : ($user->pool[$poster_id]['user_allow_viewonline'] ? 1 : (($poster_id == $user->data['user_id']) || $user->auth(POST_FORUM_URL, 'auth_mod', $this->forum_id) ? 2 : 0));
				$buttons['online'] = array(
					'u' => $config->url('viewonline', '', true),
					'i' => $online == 0 ? $user->img('icon_offline') : ($online == 1 ? $user->img('icon_online') : $user->img('icon_hidden')),
					'l' => $online == 0 ? $user->lang('Offline') : ($online == 1 ? $user->lang('Online') : $user->lang('Hidden')),
				);

				$buttons['pm'] = array(
					'u' => $config->url('privmsg', array('mode' => 'post', POST_USERS_URL => $poster_id), true),
				);

				if ( (!empty($user->pool[$poster_id]['user_viewemail']) && empty($config->data['email_disable'])) || $user->auth(POST_FORUM_URL, 'auth_mod', $this->forum_id) )
				{
					$buttons['email'] = array(
						'u' => $config->data['board_email_form'] ? $config->url('profile', array('mode' => 'email', POST_USERS_URL => $poster_id), true) : 'mailto:' . $user->pool[$poster_id]['user_email'],
					);
				}

				if ( !empty($user->pool[$poster_id]['user_website']) )
				{
					$buttons['www'] = array(
						'u' => $user->pool[$poster_id]['user_website'],
					);
				}

				if ( !empty($user->pool[$poster_id]['user_icq']) )
				{
					$buttons['icq_status'] = array(
						'u' => 'http://wwp.icq.com/' . $user->pool[$poster_id]['user_icq'] . '#pager',
						'i' => 'http://web.icq.com/whitepages/online?icq=' . $user->pool[$poster_id]['user_icq'] . '&amp;img=5',
					);

					$buttons['icq'] = array(
						'u' => 'http://wwp.icq.com/scripts/search.dll?to=' . $user->pool[$poster_id]['user_icq'],
					);
				}

				if ( !empty($user->pool[$poster_id]['user_aim']) )
				{
					$buttons['aim'] = array(
						'u' => 'aim:goim?screenname=' . $user->pool[$poster_id]['user_aim'] . '&amp;message=Hello+Are+you+there?',
					);
				}

				if ( !empty($user->pool[$poster_id]['user_msnm']) )
				{
					$buttons['msn'] = array(
						'u' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $poster_id), true),
					);
				}

				if ( !empty($user->pool[$poster_id]['user_yim']) )
				{
					$buttons['yim'] = array(
						'u' => 'http://edit.yahoo.com/config/send_webmesg?.target=' . $user->pool[$poster_id]['user_yim'] . '&amp;.src=pg',
					);
				}
			}

			// store the results
			$this->poster_block_vars[$poster_id]['data'] = array(
				'POSTER_NAME' => ($poster_id == ANONYMOUS) ? $user->lang('Guest') : $user->pool[$poster_id]['username'],
				'POSTER_AVATAR' => $avatar,
				'L_POSTER_RANK' => empty($rank) ? '' : $rank['txt'],
				'I_POSTER_RANK' => empty($rank) ? '' : $user->img_styled($rank['img']),
				'POSTER_JOINED' => ($poster_id == ANONYMOUS) ? '' : $user->date($user->pool[$poster_id]['user_regdate'], $user->lang('DATE_FORMAT')),
				'POSTER_POSTS' => ($poster_id == ANONYMOUS) ? '' : $user->pool[$poster_id]['user_posts'],
				'POSTER_FROM' => ($poster_id == ANONYMOUS) || empty($user->pool[$poster_id]['user_from']) ? '' : $user->pool[$poster_id]['user_from'],
				'POSTER_OCC' => ($poster_id == ANONYMOUS) || empty($user->pool[$poster_id]['user_occ']) ? '' : $user->pool[$poster_id]['user_occ'],
				'POSTER_INTERESTS' => ($poster_id == ANONYMOUS) || empty($user->pool[$poster_id]['user_interests']) ? '' : $user->pool[$poster_id]['user_interests'],

				'SIGNATURE' => $user_sig,
			);
			$this->poster_block_vars[$poster_id]['switches'] = array(
				'avatar' => !empty($this->poster_block_vars[$poster_id]['data']['POSTER_AVATAR']),
				'poster_joined' => !empty($this->poster_block_vars[$poster_id]['data']['POSTER_JOINED']),
				'poster_posts' => $poster_id != ANONYMOUS,
				'poster_from' => !empty($this->poster_block_vars[$poster_id]['data']['POSTER_FROM']),
				'poster_occ' => !empty($this->poster_block_vars[$poster_id]['data']['POSTER_OCC']),
				'poster_interests' => !empty($this->poster_block_vars[$poster_id]['data']['POSTER_INTERESTS']),
				'signature' => !empty($user_sig),
				'rank' => !empty($rank),
			);
			if ( !empty($rank) )
			{
				$this->poster_block_vars[$poster_id]['switches'] += array(
					'rank.img' => !empty($rank['img']),
				);
			}

			if ( !empty($buttons) )
			{
				foreach ( $buttons as $button => $data )
				{
					foreach ( $data as $key => $value )
					{
						$this->poster_block_vars[$poster_id]['data'][strtoupper($key . '_' . $button)] = $value;
						$this->poster_block_vars[$poster_id]['switches'][$button] = true;
					}
				}
			}
			unset($buttons);
		}
		return $this->poster_block_vars[$poster_id];
	}

	function get_rank($poster_id)
	{
		global $config, $user;

		if ( !$this->ranks_done )
		{
			$this->ranks_done = true;
			$this->ranks_special = array();
			$this->ranks_regular = array();
			if ( !class_exists('ranks') )
			{
				include($config->url('includes/class_message'));
			}
			$ranks = new ranks();
			$ranksrow = $ranks->read();
			$count_ranksrow = count($ranksrow);
			for ( $i = 0; $i < $count_ranksrow; $i++ )
			{
				if ( $ranksrow[$i]['rank_special'] )
				{
					$this->ranks_special[ $ranksrow[$i]['rank_id'] ] = array('txt' => $ranksrow[$i]['rank_title'], 'img' => $ranksrow[$i]['rank_image']);
				}
				else
				{
					$this->ranks_regular[ $ranksrow[$i]['rank_min'] ] = array('txt' => $ranksrow[$i]['rank_title'], 'img' => $ranksrow[$i]['rank_image']);
				}
			}
			// sort regular ranks on descending rank_min
			if ( !empty($this->ranks_regular) )
			{
				krsort($this->ranks_regular);
			}
		}

		// find the rank
		if ( $poster_id == ANONYMOUS )
		{
			return array('txt' => $user->lang('Guest'), 'img' => '');
		}

		if ( $user->pool[$poster_id]['user_rank'] && isset($this->ranks_special[ $user->pool[$poster_id]['user_rank'] ]) )
		{
			return $this->ranks_special[ $user->pool[$poster_id]['user_rank'] ];
		}

		if ( !empty($this->ranks_regular) )
		{
			foreach ( $this->ranks_regular as $rank_min => $dummy )
			{
				if ( $user->pool[$poster_id]['user_posts'] >= $rank_min )
				{
					return $this->ranks_regular[$rank_min];
				}
			}
		}

		return array();
	}

	function get_avatar($poster_id)
	{
		global $user, $config;

		$avatar = '';
		if ( ($poster_id != ANONYMOUS) && $user->pool[$poster_id]['user_allowavatar'] )
		{
			if ( !empty($user->pool[$poster_id]['user_avatar']) )
			{
				switch( $user->pool[$poster_id]['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$avatar = $config->data['allow_avatar_upload'] ? $config->data['avatar_path'] . '/' . $user->pool[$poster_id]['user_avatar'] : '';
						break;
					case USER_AVATAR_REMOTE:
						$avatar = $config->data['allow_avatar_remote'] ? $user->pool[$poster_id]['user_avatar'] : '';
						break;
					case USER_AVATAR_GALLERY:
						$avatar = $config->data['allow_avatar_local'] ? $config->data['avatar_gallery_path'] . '/' . $user->pool[$poster_id]['user_avatar'] : '';
						break;
				}
			}
			else if ( !empty($config->data['default_avatar']) )
			{
				$avatar = $user->img($config->data['default_avatar']);
			}
		}
		return $avatar;
	}
}

class posts_review extends posts
{
	function posts_review($requester='', $parms='')
	{
		parent::posts($requester, $parms);
		$this->review = true;
	}

	function poster_block_vars($poster_id)
	{
		global $user, $config;

		if ( !isset($this->poster_block_vars[$poster_id]) )
		{
			$this->poster_block_vars[$poster_id]['data'] = array(
				'POSTER_NAME' => ($poster_id == ANONYMOUS) ? $user->lang('Guest') : $user->pool[$poster_id]['username'],
			);
			$this->poster_block_vars[$poster_id]['switches'] = array();

			// messangers/profile buttons
			$buttons = array();
			if ( $poster_id != ANONYMOUS )
			{
				$online = !$user->pool[$poster_id]['user_session_logged'] || ($user->pool[$poster_id]['user_session_time'] < (time() - TIME_ONLINE_RANGE)) ? 0 : ($user->pool[$poster_id]['user_allow_viewonline'] ? 1 : (($poster_id == $user->data['user_id']) || $user->auth(POST_FORUM_URL, 'auth_mod', $this->forum_id) ? 2 : 0));
				$buttons['online'] = array(
					'u' => $config->url('viewonline', '', true),
					'i' => $online == 0 ? $user->img('icon_offline') : ($online == 1 ? $user->img('icon_online') : $user->img('icon_hidden')),
					'l' => $online == 0 ? $user->lang('Offline') : ($online == 1 ? $user->lang('Online') : $user->lang('Hidden')),
				);
			}

			if ( !empty($buttons) )
			{
				foreach ( $buttons as $button => $data )
				{
					foreach ( $data as $key => $value )
					{
						$this->poster_block_vars[$poster_id]['data'][strtoupper($key . '_' . $button)] = $value;
						$this->poster_block_vars[$poster_id]['switches'][$button] = true;
					}
				}
			}
			unset($buttons);
		}
		return $this->poster_block_vars[$poster_id];
	}

	function get_buttons(&$row)
	{
		global $config;

		$buttons = parent::get_buttons($row);

		$parms = $this->parms;
		if ( isset($parms['start']) )
		{
			unset($parms['start']);
		}
		if ( isset($buttons['post']['u']) )
		{
			$buttons['post']['u'] = $config->url($this->requester, array(POST_POST_URL => $row['post_id']) + $parms, true, $row['post_id']);
		}
		unset($parms);
		return $buttons;
	}
}

?>