<?php
//
//	file: includes/class_search.php
//	author: ptirhiik
//	begin: 12/12/2005
//	version: 1.6.10 - 08/05/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack_attempt');
}

define('WORD_MIN_LENGTH', 3);

// topics class
class topics_search extends topics
{
	var $total_items;

	function authed_forums($forum_id=0, $no_subs=false)
	{
		global $user, $forums;

		// get authorised forums
		$tkeys = array_flip($forums->keys);
		$min_idx = $tkeys[$forum_id];
		$max_idx = $tkeys[ ($no_subs ? $forum_id : $forums->data[$forum_id]['last_child_id']) ];
		unset($tkeys);

		$forum_ids = array();
		for ( $i = $min_idx; $i <= $max_idx; $i++ )
		{
			if ( $user->auth(POST_FORUM_URL, 'auth_read', $forums->keys[$i]) )
			{
				$forum_ids[] = $forums->keys[$i];
			}
		}
		if ( empty($forum_ids) )
		{
			message_return($user->lang('No_searchable_forums'));
		}
		return $forum_ids;
	}

	function do_read(&$result, $ppage=0)
	{
		global $db;

		$this->pre_process();
		$i = 0;
		while ( ($row = $db->sql_fetchrow($result)) && (empty($ppage) || ($i < $ppage)) )
		{
			$this->row_process($row);
			$this->data_ext[ $row['topic_id'] ] = $row;
			$i++;
		}

		// get complementary data
		$this->post_process();
	}

	function display()
	{
		parent::display(true, true);
	}

	function bottom_line($empty=false)
	{
		global $template, $user;

		$template->set_switch('topicrow');
		$template->set_switch('topicrow.bottom');
		$template->set_switch('topicrow.bottom.no_topics', $empty);
		$template->assign_vars(array('BOTTOM_ROW' => $template->include_file('topics_bottom_search.tpl')));
	}

	function get_order()
	{
		// order by
		$sqlorder = array();
		$sort_by = isset($this->parms['sort_by']) ? $this->parms['sort_by'] : '';
		switch ( $sort_by )
		{
			case 1: // Sort_Post_Subject
			case 2: // Sort_Topic_Title
				$sqlorder = array(
					'order' => 't.topic_title' . (isset($this->parms['sort_dir']) && (strtoupper($this->parms['sort_dir']) == 'DESC') ? ' DESC' : ''),
				);
				break;
			case 3: // Sort_Author
				$sqlorder = array(
					'order' => 'u.username' . (isset($this->parms['sort_dir']) && (strtoupper($this->parms['sort_dir']) == 'DESC') ? ' DESC' : ''),
					'from' => ', ' . USERS_TABLE . ' u',
					'where' => 'u.user_id = t.topic_poster',
				);
				break;
			case 4: // Sort_Forum
				$sqlorder = array(
					'order' => 'f.forum_order' . (isset($this->parms['sort_dir']) && (strtoupper($this->parms['sort_dir']) == 'DESC') ? ' DESC' : ''),
					'from' => ', ' . FORUMS_TABLE . ' f',
					'where' => 'f.forum_id = t.forum_id',
				);
				break;
			default: // Sort_Time
				$sqlorder = array(
					'order' => 't.topic_last_post_id' . (isset($this->parms['sort_dir']) && (strtoupper($this->parms['sort_dir']) == 'DESC') ? ' DESC' : ''),
				);
				break;
		}
		return $sqlorder;
	}

	function read(&$search_ids)
	{
		global $db, $user;

		$this->forum_id = 0;
		$this->total_topics = count($search_ids);

		if ( $this->total_topics )
		{
			// order by
			$sqlorder = $this->get_order();

			// read topics
			$sql = 'SELECT t.*
						FROM ' . TOPICS_TABLE . ' t' . (isset($sqlorder['from']) ? $sqlorder['from'] : '') . '
						WHERE t.topic_id IN(' . implode(', ', $search_ids) . ')
							AND t.topic_moved_id = 0' . (!isset($sqlorder['where']) || empty($sqlorder['where']) ? '' : '
							AND ' . $sqlorder['where']) . '
							AND t.forum_id IN(' . implode(', ', $this->authed_forums()) . ')
						ORDER BY ' . $sqlorder['order'] . '
						LIMIT ' . (isset($this->parms['start']) ? intval($this->parms['start']) : 0) . ', ' . (isset($this->parms['ppage']) ? intval($this->parms['ppage']) : 0);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$this->do_read($result);
			$db->sql_freeresult($result);
		}
		$this->total_items = $this->total_topics;
	}
}

class topics_search_newposts extends topics_search
{
	function read()
	{
		global $db, $user;

		$this->forum_id = 0;
		$this->total_topics = 0;
		$this->total_items = 0;
		$this->data_ext = array();

		if ( !empty($user->cookies['unreads']) )
		{
			$sql = 'SELECT t.*
						FROM ' . TOPICS_TABLE . ' t
						WHERE t.topic_id IN(' . implode(', ', array_keys($user->cookies['unreads'])) . ')
							AND t.forum_id IN(' . implode(', ', $this->authed_forums()) . ')
							AND t.topic_moved_id = 0
						ORDER BY t.topic_last_post_id DESC';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( ($this->total_topics = $db->sql_numrows($result)) && (!isset($this->parms['start']) || ($this->total_topics > intval($this->parms['start']))) )
			{
				if ( isset($this->parms['start']) && intval($this->parms['start']) )
				{
					$db->sql_rowseek(intval($this->parms['start']), $result);
				}
				$this->do_read($result, isset($this->parms['ppage']) ? intval($this->parms['ppage']) : 0);
			}
			$db->sql_freeresult($result);
		}
		$this->total_items = $this->total_topics;
	}
}

class topics_search_unanswered extends topics_search
{
	function read()
	{
		global $db, $user;

		$this->forum_id = 0;
		$this->total_topics = 0;
		$this->data_ext = array();

		// get topics without replies
		$sql = 'SELECT t.*
					FROM ' . TOPICS_TABLE . ' t
					WHERE t.topic_replies = 0
						AND t.forum_id IN(' . implode(', ', $this->authed_forums()) . ')
						AND t.topic_moved_id = 0
					ORDER BY t.topic_last_post_id DESC';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);

		// read results
		if ( ($this->total_topics = $db->sql_numrows($result)) && (!isset($this->parms['start']) || ($this->total_topics > intval($this->parms['start']))) )
		{
			if ( isset($this->parms['start']) && intval($this->parms['start']) )
			{
				$db->sql_rowseek(intval($this->parms['start']), $result);
			}
			$this->do_read($result, isset($this->parms['ppage']) ? intval($this->parms['ppage']) : 0);
		}
		$db->sql_freeresult($result);
		$this->total_items = $this->total_topics;
	}
}

class topics_search_egosearch extends topics_search
{
	function read()
	{
		global $db, $user;

		$this->forum_id = 0;
		$this->total_topics = 0;
		$this->data_ext = array();

		// get topics without replies
		$sql = 'SELECT t.*
					FROM ' . TOPICS_TABLE . ' t
					WHERE t.topic_moved_id = 0
						AND t.topic_id IN(' . $db->sql_subquery('topic_id', '
							SELECT DISTINCT topic_id
								FROM ' . POSTS_TABLE . '
								WHERE forum_id IN(' . implode(', ', $this->authed_forums(isset($this->parms['search_forum']) ? intval($this->parms['search_forum']) : 0, isset($this->parms['no_subs']) ? intval($this->parms['no_subs']) : 0)) . ')
									AND poster_id = ' . intval($user->data['user_id']) . '
						', __LINE__, __FILE__) . ')
					ORDER BY t.topic_last_post_id DESC';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);

		// read results
		if ( ($this->total_topics = $db->sql_numrows($result)) && (!isset($this->parms['start']) || ($this->total_topics > intval($this->parms['start']))) )
		{
			if ( isset($this->parms['start']) && intval($this->parms['start']) )
			{
				$db->sql_rowseek(intval($this->parms['start']), $result);
			}
			$this->do_read($result, isset($this->parms['ppage']) ? intval($this->parms['ppage']) : 0);
		}
		$db->sql_freeresult($result);
		$this->total_items = $this->total_topics;
	}
}

class topics_search_authors extends topics_search
{
	function read(&$user_ids)
	{
		global $db, $user;

		$this->forum_id = 0;
		$this->total_topics = 0;
		$this->data_ext = array();

		// order by
		$sqlorder = $this->get_order();

		// get topics with a posts by authors
		$sql = 'SELECT *
					FROM ' . TOPICS_TABLE . ' t' . $sqlorder['from'] . '
					WHERE t.topic_moved_id = 0' . (empty($sqlorder['where']) ? '' : '
						AND ' . $sqlorder['where']) . '
						AND t.topic_id IN(' . $db->sql_subquery('topic_id', '
							SELECT DISTINCT topic_id
								FROM ' . POSTS_TABLE . '
								WHERE forum_id IN(' . implode(', ', $this->authed_forums(isset($this->parms['search_forum']) ? intval($this->parms['search_forum']) : 0, isset($this->parms['no_subs']) ? intval($this->parms['no_subs']) : 0)) . ')
									AND poster_id IN(' . implode(', ', $user_ids) . ')' .  (!isset($this->parms['search_time']) || empty($this->parms['search_time']) ? '' : '
									AND post_time >= ' . (time() - (intval($this->parms['search_time']) * 86400))) . '
						', __LINE__, __FILE__) . ')
					ORDER BY ' . $sqlorder['order'];
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);

		// read results
		if ( ($this->total_topics = $db->sql_numrows($result)) && (!isset($this->parms['start']) || ($this->total_topics > intval($this->parms['start']))) )
		{
			if ( isset($this->parms['start']) && intval($this->parms['start']) )
			{
				$db->sql_rowseek(intval($this->parms['start']), $result);
			}
			$this->do_read($result, isset($this->parms['ppage']) ? intval($this->parms['ppage']) : 0);
		}
		$db->sql_freeresult($result);
		$this->total_items = $this->total_topics;
	}
}


class posts_search extends posts
{
	function posts_search($requester, $parms='')
	{
		global $config, $user;

		parent::posts($requester, $parms);
		$this->topic_fields = array_merge($this->topic_fields, array(
			'topic_views',
			'topic_moved_id',
			'topic_poster',
			'topic_first_username',
			'topic_last_poster',
			'topic_last_username',
		));
		$this->get_parms();
		$this->sort = isset($this->parms['sort_by']) ? $this->parms['sort_by'] : '';
		$this->order = isset($this->parms['sort_dir']) && (strtoupper($this->parms['sort_dir']) == 'DESC') ? 'DESC' : 'ASC';
		$this->shorten = isset($this->parms['return_chars']) && (intval($this->parms['return_chars']) < 0);
	}

	function row_process(&$row)
	{
		global $user, $config;

		// topic data
		$this->topic = $row;
		$this->post_id = intval($row['post_id']);
		$this->topic_id = intval($row['topic_id']);
		$this->forum_id = intval($row['forum_id']);

		// last read time
		$this->topic_last_read = isset($user->cookies['unreads'][ $row['topic_id'] ]) ? intval($user->cookies['unreads'][ $row['topic_id'] ]) : 0;

		// process
		parent::row_process($row);
	}

	function display()
	{
		global $config, $db, $user, $template, $forums;

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

		$template->assign_vars(array(
			'I_TOPIC' => $user->img('folder'),
			'L_AUTHOR' => $user->lang('Author'),
			'L_MESSAGE' => $user->lang('Message'),
			'L_TOPIC' => $user->lang('Topic'),
			'L_REPLIES' => $user->lang('Replies'),
			'L_VIEWS' => $user->lang('Views'),
			'L_FORUM' => $user->lang('Forum'),
			'L_POSTED' => $user->lang('Posted'),
			'L_SUBJECT' => $user->lang('Subject'),
		));

		// pagination
		$parms = array(
			'search_id' => isset($this->parms['search_id']) ? $this->parms['search_id'] : 0,
			'search_author' => isset($this->parms['search_author']) ? $this->parms['search_author'] : '',
			'ppage' => isset($this->parms['ppage']) ? $this->parms['ppage'] : 0,
		);
		$pagination = new pagination($this->requester, $parms, 'start');
		$pagination->display('pagination', $this->total_items, $this->ppage, isset($this->parms['start']) ? $this->parms['start'] : 0, true, 'Posts_count');
		unset($pagination);
	}

	function display_a_post(&$row, $color)
	{
		global $config, $user, $forums, $template;

		$this->topic = $row;
		parent::display_a_post($row, $color, 'searchresults');

		$template->assign_lastblock_vars('searchresults', array(
			'TOPIC_REPLIES' => intval($row['topic_replies']),
			'TOPIC_VIEWS' => intval($row['topic_views']),

			'U_TOPIC' => $config->url('viewtopic', array(POST_TOPIC_URL => $row['topic_id'], 'search_id' => isset($this->parms['search_id']) ? intval($this->parms['search_id']) : 0), true),
			'TOPIC_TITLE' => _censor($row['topic_title']),
		));

		// navigation
		$forums->display_nav(intval($row['forum_id']), 'searchresults.nav', true);
	}

	function get_buttons(&$row)
	{
		global $config, $user;

		$buttons['post'] = array(
			'u' => $config->url('viewtopic', array(POST_POST_URL => $row['post_id'], 'search_id' => isset($this->parms['search_id']) ? intval($this->parms['search_id']) : 0), true, $row['post_id']),
			'i' => $row['post_unread'] ? $user->img('icon_newest_reply') : $user->img('icon_latest_reply'),
			'l' => $row['post_unread'] ? $user->lang('New_post') : $user->lang('Post'),
		);

		return $buttons;
	}

	function parse_message(&$row)
	{
		global $config, $user;

		if ( isset($this->parms['return_chars']) && intval($this->parms['return_chars']) == 0)
		{
			$row['post_text'] = '...';
		}

		// parse the text
		parent::parse_message($row, isset($this->parms['return_chars']) ? intval($this->parms['return_chars']) : 0);
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
				$buttons['profile'] = array(
					'u' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $poster_id), true),
				);

				$buttons['search'] = array(
					'u' => $config->url('search', array('search_author' => $user->pool[$poster_id]['username'], 'showresults' => 'posts'), true),
					'l' => sprintf($user->lang('Search_user_posts'), $user->pool[$poster_id]['username']),
				);

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

	function get_order()
	{
		global $user;

		// order by
		$sqlorder = array();
		switch ( $this->sort )
		{
			case 1: // Sort_Post_Subject
				$sqlorder = array(
					'order' => 'pt.post_subject' . ($this->order == 'DESC' ? ' DESC' : '') . ', p.post_id' . ($this->order == 'DESC' ? ' DESC' : ''),
				);
				break;
			case 2: // Sort_Topic_Title
				$sqlorder = array(
					'order' => 't.topic_title' . ($this->order == 'DESC' ? ' DESC' : '') . ', p.post_id' . ($this->order == 'DESC' ? ' DESC' : ''),
				);
				break;
			case 3: // Sort_Author
				$sqlorder = array(
					'order' => 'u.username' . ($this->order == 'DESC' ? ' DESC' : '') . ', p.post_id' . ($this->order == 'DESC' ? ' DESC' : ''),
					'from' => ', ' . USERS_TABLE . ' u',
					'where' => 'u.user_id = p.poster_id',
				);
				break;
			case 4: // Sort_Forum
				$sqlorder = array(
					'order' => 'f.forum_order' . ($this->order == 'DESC' ? ' DESC' : '') . ', p.post_id' . ($this->order == 'DESC' ? ' DESC' : ''),
					'from' => ', ' . FORUMS_TABLE . ' f',
					'where' => 'f.forum_id = p.forum_id',
				);
				break;
			default: // Sort_Time
				$sqlorder = array(
					'order' => 'p.post_time' . ($this->order == 'DESC' ? ' DESC' : '') . ', p.post_id' . ($this->order == 'DESC' ? ' DESC' : ''),
				);
				break;
		}
		return $sqlorder;
	}

	function read(&$search_ids)
	{
		global $db, $user;

		$this->total_items = count($search_ids);
		if ( empty($this->total_items) )
		{
			return;
		}

		// forums authorised
		$topics = new topics_search($this->requester);
		$forum_ids = $topics->authed_forums(isset($this->parms['search_forum']) ? intval($this->parms['search_forum']) : 0, isset($this->parms['no_subs']) ? intval($this->parms['no_subs']) : 0);
		unset($topics);

		// order by
		$sqlorder = $this->get_order();

		// do read
		$sql = 'SELECT p.*, pt.bbcode_uid, pt.post_subject, pt.post_sub_title, pt.post_text' . (empty($this->topic_fields) ? '' : ', t.' . implode(', t.', $this->topic_fields)) . '
					FROM ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt, ' . TOPICS_TABLE . ' t' . (isset($sqlorder['from']) ? $sqlorder['from'] : '') . '
					WHERE pt.post_id = p.post_id
						AND t.topic_id = p.topic_id
						AND p.forum_id IN(' . implode(', ', $forum_ids) . ')' . (!isset($sqlorder['where']) || empty($sqlorder['where']) ? '' : '
						AND ' . $sqlorder['where']) . '
						AND p.post_id IN(' . implode(', ', $search_ids) . ')
					ORDER BY ' . $sqlorder['order'] . '
					LIMIT ' . (isset($this->parms['start']) ? intval($this->parms['start']) : 0) . ', ' . intval($this->ppage);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->do_read($result);
		$db->sql_freeresult($result);
	}
}

class posts_search_authors extends posts_search
{
	function read(&$user_ids)
	{
		global $db, $user;

		$this->total_items = 0;
		if ( empty($user_ids) )
		{
			return;
		}

		// forums authorised
		$topics = new topics_search($this->requester);
		$forum_ids = $topics->authed_forums(isset($this->parms['search_forum']) ? intval($this->parms['search_forum']) : 0, isset($this->parms['no_subs']) ? intval($this->parms['no_subs']) : 0);
		unset($topics);

		$this->total_items = 0;
		$this->data = array();

		// order by
		$sqlorder = $this->get_order();

		// get post number
		$sql = 'SELECT COUNT(post_id) AS count_post_id
					FROM ' . POSTS_TABLE . '
					WHERE poster_id IN(' . implode(', ', $user_ids) . ')
						AND forum_id IN(' . implode(', ', $forum_ids) . ')' . (!isset($this->parms['search_time']) || empty($this->parms['search_time']) ? '' : '
						AND post_time >= ' . (time() - (intval($this->parms['search_time']) * 86400)));
		$result= $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->total_items = ($row = $db->sql_fetchrow($result)) ? intval($row['count_post_id']) : 0;
		$db->sql_freeresult($result);

		// get posts by authors
		if ( $this->total_items )
		{
			$sql = 'SELECT p.*, pt.bbcode_uid, pt.post_subject, pt.post_sub_title, pt.post_text' . (empty($this->topic_fields) ? '' : ', t.' . implode(', t.', $this->topic_fields)) . '
						FROM ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt, ' . TOPICS_TABLE . ' t' . $sqlorder['from'] . '
						WHERE pt.post_id = p.post_id
							AND t.topic_id = p.topic_id' . (empty($sqlorder['where']) ? '' : '
							AND ' . $sqlorder['where']) . '
							AND p.poster_id IN(' . implode(', ', $user_ids) . ')
							AND p.forum_id IN(' . implode(', ', $forum_ids) . ')' . (!isset($this->parms['search_time']) || empty($this->parms['search_time']) ? '' : '
							AND p.post_time >= ' . (time() - (intval($this->parms['search_time']) * 86400))) . '
						ORDER BY ' . $sqlorder['order'] . '
						LIMIT ' . (isset($this->parms['start']) ? intval($this->parms['start']) : 0) . ', ' . intval($this->ppage);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$this->do_read($result);
			$db->sql_freeresult($result);
		}
	}
}

class search
{
	var $requester;
	var $mode;
	var $search_id;
	var $search_ids;
	var $total_items;
	var $from_results;

	var $parms;
	var $highlight;
	var $start;
	var $ppage;
	var $dft_ppage;
	var $nav_parms;

	var $sort_by_available;

	var $keywords;
	var $user_ids;
	var $forum_ids;

	function search($requester)
	{
		$this->requester = $requester;
		$this->mode = '';
		$this->search_id = 0;
		$this->search_ids = array();
		$this->total_items = 0;
		$this->from_results = false;

		$this->parms = array();
		$this->highlight = '';
		$this->start = 0;
		$this->ppage = 0;
		$this->dft_ppage = 0;
		$this->nav_parms = array();

		$this->sort_by_available = array('Sort_Time', 'Sort_Post_Subject', 'Sort_Topic_Title', 'Sort_Author', 'Sort_Forum');

		$this->keywords = array();
		$this->user_ids = array();
		$this->forum_ids = array();
	}

	function read_parms()
	{
		global $user, $config, $forums;

		$this->mode = _read('search_id', TYPE_NO_HTML, '', array_flip(array('', 'newposts', 'egosearch', 'unanswered')));
		$this->search_id = _read('search_id', TYPE_INT);

		// a mode has been given
		if ( !empty($this->mode) )
		{
			$this->search_id = 0;
		}

		// a search_id has been paste : read results so
		if ( !empty($this->search_id) )
		{
			$this->read_results();
			if ( empty($this->search_id) )
			{
				$this->mode = '';
				$this->from_results = false;
			}
			else
			{
				$this->mode = 'keywords';
				$this->from_results = true;
			}
		}

		// no mode nor search_id (or the search_id paste wasn't a valid one) : get the form
		if ( empty($this->mode) )
		{
			$search_fields_available = array('all' => 1, 'msgonly' => 0, 'titleonly' => 2);
			$this->parms = array(
				'search_keywords' => _read('search_keywords', TYPE_NO_HTML),
				'search_author' => trim(stripslashes(phpbb_clean_username(addslashes(_read('search_author', TYPE_HTML))))),
				'show_results' => _read('show_results', TYPE_NO_HTML, '', array_flip(array('posts', 'topics'))),
				'search_terms' => _read('search_terms', TYPE_NO_HTML) == 'all' ? 1 : 0,
				'search_fields' => $search_fields_available[ _read('search_fields', TYPE_NO_HTML, '', $search_fields_available) ],
				'return_chars' => max(-1, _read('return_chars', TYPE_INT, 200)),
				'search_forum' => _read('search_forum', TYPE_INT, 0, $forums->data),
				'search_no_subs' => _button('no_subs'),
				'search_sort_by' => _read('sort_by', TYPE_INT, 0, $this->sort_by_available),
				'search_sort_dir' => strtoupper(_read('sort_dir', TYPE_NO_HTML, 'DESC', array_flip(array('desc', 'DESC', 'asc', 'ASC')))),
				'topic_days' => _read('search_time', TYPE_INT),
			);

			// try to get a mode
			if ( empty($this->parms['search_keywords']) )
			{
				if ( !empty($this->parms['search_author']) )
				{
					$this->mode = 'authors';
				}
			}
			else
			{
				$this->mode = 'keywords';
				$this->from_results = false;
			}
		}

		// pagination
		if ( !empty($this->mode) )
		{
			$this->start = max(0, _read('start', TYPE_INT));
			$this->ppage = max(0, _read('ppage', TYPE_INT));
			if ( isset($this->parms['show_results']) && ($this->parms['show_results'] == 'posts') )
			{
				$this->dft_ppage = isset($user->data['user_posts_ppage']) && intval($user->data['user_posts_ppage']) && (!isset($config->data['posts_per_page_over']) || !intval($config->data['posts_per_page_over'])) ? intval($user->data['user_posts_ppage']) : (intval($config->data['posts_per_page']) ? intval($config->data['posts_per_page']) : 15);
			}
			else
			{
				$this->dft_ppage = isset($user->data['user_topics_ppage']) && intval($user->data['user_topics_ppage']) && (!isset($config->data['topics_per_page_over']) || !intval($config->data['topics_per_page_over'])) ? intval($user->data['user_topics_ppage']) : (intval($config->data['topics_per_page']) ? intval($config->data['topics_per_page']) : 50);
			}
			$this->ppage = ($this->ppage > 0) ? $this->ppage : $this->dft_ppage;
		}
	}

	function display_form()
	{
		global $user, $config, $template, $forums;

		// get the forums list selection
		$front_pic = $forums->get_front_pic();
		$s_forums = '';
		if ( !empty($front_pic) )
		{
			foreach ( $front_pic as $cur_id => $front )
			{
				$s_forums .= '<option value="' . (($cur_id >= 0) ? $cur_id : -1) . '">';
				$count_front = strlen($front);
				for ( $i = 0; $i < $count_front; $i++ )
				{
					$s_forums .= $user->lang('tree_pic_' . $front[$i]);
				}
				if ( $cur_id >= 0 )
				{
					$s_forums .= $user->lang($forums->data[$cur_id]['forum_name']);
				}
				$s_forums .= '</option>';
			}
		}
		else
		{
			message_return('No_searchable_forums');
		}

		// get the number of chars returned list
		$s_characters = '<option value="-1">' . $user->lang('All_available') . '</option>';
		$s_characters .= '<option value="0">0</option>';
		$s_characters .= '<option value="25">25</option>';
		$s_characters .= '<option value="50">50</option>';
		for($i = 100; $i < 1100 ; $i += 100)
		{
			$selected = ( $i == 200 ) ? ' selected="selected"' : '';
			$s_characters .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
		}

		// get the Sorting By list
		$s_sort_by = '';
		$count_sort_by_available = count($this->sort_by_available);
		for ( $i = 0; $i < $count_sort_by_available; $i++ )
		{
			$s_sort_by .= '<option value="' . $i . '">' . $user->lang($this->sort_by_available[$i]) . '</option>';
		}

		// get the Search time list
		$previous_days = array(0 => 'All_Posts', 1 => '1_Day', 7 => '7_Days', 14 => '2_Weeks', 30 => '1_Month', 90 => '3_Months', 180 => '6_Months', 364 => '1_Year');
		$s_time = '';
		foreach ( $previous_days as $key => $legend )
		{
			$s_time .= '<option value="' . $key . '">' . $user->lang($legend) . '</option>';
		}

		// parms for display
		$this->nav_parms = array();

		// Output the basic page
		$template->assign_vars(array(
			'S_FORUM_OPTIONS' => $s_forums,
			'S_NO_SUBS' => '',
			'S_CHARACTER_OPTIONS' => $s_characters,
			'S_SORT_OPTIONS' => $s_sort_by,
			'S_TIME_OPTIONS' => $s_time, 

			'L_SEARCH_KEYWORDS' => $user->lang('Search_keywords'),
			'L_SEARCH_KEYWORDS_EXPLAIN' => $user->lang('Search_keywords_explain'),
			'L_SEARCH_ANY_TERMS' => $user->lang('Search_for_any'),
			'L_SEARCH_ALL_TERMS' => $user->lang('Search_for_all'),
			'L_SEARCH_AUTHOR' => $user->lang('Search_author'),
			'L_SEARCH_AUTHOR_EXPLAIN' => $user->lang('Search_author_explain'),
			'L_SEARCH_FORUM' => $user->lang('Search_in_forum'),
			'L_NO_SUBS' => $user->lang('Search_no_subs'),
			'L_SEARCH_MESSAGE_ONLY' => $user->lang('Search_msg_only'),
			'L_SEARCH_MESSAGE_TITLE' => $user->lang('Search_title_msg'),
			'L_SEARCH_TITLE_ONLY' => $user->lang('Search_title_only'),
			'L_RETURN_FIRST' => $user->lang('Return_first'),
			'L_CHARACTERS' => $user->lang('characters_posts'),
			'L_SORT_BY' => $user->lang('Sort_by'),
			'L_SORT_ASCENDING' => $user->lang('Sort_Ascending'),
			'L_SORT_DESCENDING' => $user->lang('Sort_Descending'),
			'L_SEARCH_PREVIOUS' => $user->lang('Search_previous'),
			'L_DISPLAY_RESULTS' => $user->lang('Display_results'),
			'L_FORUM' => $user->lang('Forum'),
			'L_TOPICS' => $user->lang('Topics'),
			'L_POSTS' => $user->lang('Posts'),
			'I_SEARCH_BUTTON' => $user->img('cmd_search'),
			'S_SEARCH_BUTTON' => $user->lang('cmd_search'),

			'L_SEARCH_QUERY' => $user->lang('Search_query'),
			'L_SEARCH_OPTIONS' => $user->lang('Search_options'),
			'S_SEARCH_ACTION' => $config->url($this->requester, '', true),
			'S_HIDDEN_FIELDS' => '',
		));
		$template->set_switch('accesskey', ($user->lang('cmd_search') != '') && ($user->lang('cmd_search') != 'cmd_search'));
		$template->set_filenames(array('body' => 'search_body.tpl'));
	}

	function display_topics()
	{
		global $user, $config, $template;

		if ( ($this->mode == 'egosearch') && !$user->data['session_logged_in'] )
		{
			redirect($config->url('login', '', true), $config->url($this->requester, array('search_id' => $this->mode), true));
		}

		// parms for display
		$this->nav_parms = array(
			'start' => $this->start,
			'ppage' => $this->ppage,
			'search_id' => $this->mode,
		);
		switch ( $this->mode )
		{
			case 'newposts':
				$topics = new topics_search_newposts($this->requester, $this->nav_parms);
				break;
			case 'unanswered':
				$topics = new topics_search_unanswered($this->requester, $this->nav_parms);
				break;
			case 'egosearch':
				$topics = new topics_search_egosearch($this->requester, $this->nav_parms);
				break;
		}
		$topics->read();
		if ( !$this->total_items = $topics->total_items )
		{
			message_return('No_search_match');
		}

		// display
		$topics->display();
		$template->set_filenames(array('body' => 'search_results_topics.tpl'));
	}

	function display_authors()
	{
		global $user, $config, $template;

		// get user ids
		$this->read_authors();
		if ( empty($this->user_ids) )
		{
			message_return('No_search_match');
		}

		// parms for display
		$this->nav_parms = array(
			'start' => $this->start,
			'ppage' => $this->ppage,
			'search_author' => isset($this->parms['search_author']) ? $this->parms['search_author'] : '',
			'show_results' => isset($this->parms['show_results']) ? $this->parms['show_results'] : '',
			'search_forum' => isset($this->parms['search_forum']) ? $this->parms['search_forum'] : 0,
			'no_subs' => isset($this->parms['search_no_subs']) ? $this->parms['search_no_subs'] : 0,
			'sort_by' => isset($this->parms['search_sort_by']) ? $this->parms['search_sort_by'] : '',
			'sort_dir' => isset($this->parms['search_sort_dir']) && ($this->parms['search_sort_dir'] == 'DESC') ? 'desc' : '',
			'search_time' => isset($this->parms['topic_days']) ? $this->parms['topic_days'] : 0,
		);

		// show as posts
		if ( $this->parms['show_results'] == 'posts' )
		{
			$tpl = 'search_results_posts.tpl';
			$this->nav_parms += array(
				'return_chars' => $this->parms['return_chars'],
			);
			$results = new posts_search_authors($this->requester, $this->nav_parms);
		}
		// show as topics
		else
		{
			$tpl = 'search_results_topics.tpl';
			$results = new topics_search_authors($this->requester, $this->nav_parms);
		}
		$results->init();
		$results->read($this->user_ids);
		if ( !$this->total_items = $results->total_items )
		{
			message_return('No_search_match');
		}
		$results->display();

		// prepare the display
		$template->set_filenames(array('body' => $tpl));
	}

	function display_keywords()
	{
		global $user, $config, $template;

		// get results if not available
		if ( !$this->from_results )
		{
			$this->get_results();
			$this->store_results();
		}
		if ( !($this->total_items = count($this->search_ids)) )
		{
			message_return('No_search_match');
		}

		// parms for display
		$this->nav_parms = array(
			'start' => $this->start,
			'ppage' => $this->ppage,
			'search_id' => $this->search_id,
			'sort_by' => isset($this->parms['start']) ? $this->parms['search_sort_by'] : '',
			'sort_dir' => isset($this->parms['search_sort_dir']) && ($this->parms['search_sort_dir'] == 'DESC') ? 'desc' : '',
			'search_time' => isset($this->parms['topic_days']) ? $this->parms['topic_days'] : 0,
		);

		// show as posts
		if ( isset($this->parms['show_results']) && ($this->parms['show_results'] == 'posts') )
		{
			$tpl = 'search_results_posts.tpl';
			$this->nav_parms += array(
				'return_chars' => isset($this->parms['return_chars']) ? $this->parms['return_chars'] : 0,
			);
			$results = new posts_search($this->requester, $this->nav_parms);
			$results->init();
		}
		else
		{
			$tpl = 'search_results_topics.tpl';
			$results = new topics_search($this->requester, $this->nav_parms);
			$results->set_view_link('', array('search_id' => $this->search_id));
		}
		$results->read($this->search_ids, $this->total_items);
		unset($this->search_ids);
		$results->set_highlight($this->highlight);
		$results->display();
		$template->set_filenames(array('body' => $tpl));
	}

	function read_results($search_id = 0)
	{
		global $db, $user;

		$this->highlight = '';
		$this->search_ids = array();
		$this->parms = array();

		// read with search_id
		$sql = 'SELECT search_array 
					FROM ' . SEARCH_TABLE . '
					WHERE search_id = ' . intval($this->search_id) . '
						AND session_id = \'' . $user->data['session_id'] . '\'';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		if ( !($row = $db->sql_fetchrow($result)) )
		{
			$this->search_id = 0;
		}
		else
		{
			$search_data = unserialize($row['search_array']);
			unset($row);
			$this->highlight = $search_data['hl'];
			$this->parms = array(
				'search_sort_by' => $search_data['by'],
				'search_sort_dir' => $search_data['dir'],
				'show_results' => $search_data['show'],
				'return_chars' => $search_data['chars'],
			);
			$this->search_ids = empty($search_data['ids']) ? array() : explode(',', $search_data['ids']);
			unset($search_data);
		}
		$db->sql_freeresult($result);
	}

	function store_results()
	{
		global $db, $user;

		// clear previous search
		$sql = 'DELETE FROM ' . SEARCH_TABLE . '
					WHERE session_id NOT IN (' . $db->sql_subquery('session_id', '
						SELECT session_id
							FROM ' . SESSIONS_TABLE . '
						', __LINE__, __FILE__, false, TYPE_NO_HTML) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		if ( empty($this->search_ids) )
		{
			return;
		}

		// Store new result data
		$search_results = empty($this->search_ids) ? '' : implode(',', $this->search_ids);

		//
		// Combine both results and search data (apart from original query)
		// so we can serialize it and place it in the DB
		$store_search_data = array();

		//
		// Limit the character length (and with this the results displayed at all following pages) to prevent
		// truncated result arrays. Normally, search results above 12000 are affected.
		// - to include or not to include
		/*
		$max_result_length = 60000;
		if (strlen($search_results) > $max_result_length)
		{
			$search_results = substr($search_results, 0, $max_result_length);
			$search_results = substr($search_results, 0, strrpos($search_results, ','));
			$total_match_count = count(explode(', ', $search_results));
		}
		*/

		$this->search_id = mt_rand();
		$fields = array(
			'search_id' => intval($this->search_id),
			'search_time' => time(),
			'search_array' => serialize(array(
				'hl' => $this->highlight,
				'by' => isset($this->parms['start']) ? $this->parms['search_sort_by'] : '',
				'dir' => isset($this->parms['search_sort_dir']) ? $this->parms['search_sort_dir'] : '',
				'show' => isset($this->parms['show_results']) ? $this->parms['show_results'] : '',
				'chars' => isset($this->parms['return_chars']) ? $this->parms['return_chars'] : 0,
				'ids' => &$search_results,
			)),
		);
		$sql = 'UPDATE ' . SEARCH_TABLE . '
					SET ' . $db->sql_fields('update', $fields) . '
					WHERE session_id = \'' . $user->data['session_id'] . '\'';
		if ( !$db->sql_query($sql, false, __LINE__, __FILE__) || !$db->sql_affectedrows() )
		{
			$fields += array(
				'session_id' => $user->data['session_id'],
			);
			$sql = 'INSERT INTO ' . SEARCH_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	function get_results()
	{
		$this->split_keywords();
		$this->prepare_keywords();
		if ( empty($this->keywords) )
		{
			return;
		}
		$this->read_authors();
		if ( isset($this->parms['search_author']) && !empty($this->parms['search_author']) && empty($this->user_ids) )
		{
			return;
		}
		$this->read_forums();
		$this->read_search_ids();
	}

	function split_keywords()
	{
		global $config, $user;

		if ( empty($this->parms['search_keywords']) )
		{
			return;
		}

		// place of the stopwords & synonyms files
		$lang_path = $config->root . 'language/lang_' . $user->lang_used . '/';

		// operators mask
		$operators = '[\+\|-]';

		// replace logical operators with their fulltext index equivalence
		$match = array('#\sand\s#i', '#\sor\s#i', '#\snot\s#i', '#\s(' . $operators . ')#');
		$replace = array(' + ', ' | ', ' - ', ' \1 ');
		$keywords = preg_replace($match, $replace, ' ' . _htmldecode(' ' . strtolower(trim($this->parms['search_keywords']))) . ' ');

		// remove undesired chars
		$drop_chars = $this->get_drop_chars();
		$keywords = str_replace($drop_chars[0], $drop_chars[1], $keywords);
		unset($drop_chars);

		// remove stop words
		$stopwords = '';
		if ( ($filename = phpbb_realpath($lang_path . 'search_stopwords.txt')) && file_exists($filename) && ($filesize = filesize($filename)) )
		{
			if ( ($fp = @fopen($filename, 'rb')) )
			{
				$keywords = preg_replace('#\b(' . preg_replace('#[\n\r\s\t]+#', '|', preg_quote(strtolower(trim(fread($fp, $filesize))), '#')) . ')\b#', '', $keywords);
			}
			@fclose($fp);
		}

		// replace synonyms
		$match_synonym = $replace_synonym = array();
		if ( ($filename = phpbb_realpath($lang_path . 'search_synonyms.txt')) && file_exists($filename) && ($filesize = filesize($lang_path . 'search_synonyms.txt')) )
		{
			if ( ($fp = @fopen($filename, 'rb')) )
			{
				preg_match_all('#^(.*?) (.*?)$#ms', strtolower(trim(fread($fp, $filesize))), $match);
				if ( isset($match[2]) && ($count_match = count($match[2])) )
				{
					for ( $i = 0; $i < $count_match; $i++ )
					{
						$match[1][$i] = ' ' . trim($match[1][$i]) . ' ';
						$match[2][$i] = ' ' . trim($match[2][$i]) . ' ';
					}
					$keywords = str_replace($match[2], $match[1], $keywords);
				}
				unset($match);
			}
			@fclose($fp);
		}

		// remove spaces around operators
		$keywords = preg_replace('#(\s+)?(' . $operators . ')\s+#', ' \2', $keywords);

		// remove lost operators
		$keywords = preg_replace('#' . $operators . '\s+#', '', $keywords . ' ');

		// and now split the keywords to a word array
		$this->keywords = preg_split('#\s+#', _htmlencode(trim($keywords)));
		if ( $this->keywords )
		{
			$this->keywords = array_flip(array_flip($this->keywords));
		}
		unset($keywords);
	}

	function read_authors()
	{
		global $db, $limiter;

		if ( !isset($this->parms['search_author']) || empty($this->parms['search_author']) )
		{
			return;
		}

		// get authors ids
		$this->user_ids = array();
		if ( !preg_match('#^[\*%]+$#', $this->parms['search_author']) && !preg_match('#^[^\*]{1,2}$#', str_replace(array('*', '%'), '', $this->parms['search_author'])) )
		{
			$authors = str_replace('*', '%', $this->parms['search_author']);
			$sql = 'SELECT user_id
						FROM ' . USERS_TABLE . '
						WHERE LOWER(username) LIKE \'' . $db->sql_escape_string($authors) . '\'
							AND user_id <> ' . ANONYMOUS . '
						ORDER BY username
						LIMIT ' . ($limiter + 1);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->user_ids[] = intval($row['user_id']);
			}
			$db->sql_freeresult($result);
			if ( count($this->user_ids) > $limiter )
			{
//				message_return('Search_too_many_users');
			}
		}
	}

	function read_forums()
	{
		// get authed forums
		$topic = new topics_search($this->requester);
		$this->forum_ids = $topic->authed_forums(intval($this->parms['search_forum']), intval($this->parms['search_no_subs']));
		unset($topic);
	}
}

class search_phpBB extends search
{
	function get_drop_chars()
	{
		$drop_char_match = array('^', '$', ';', '#', '&', '(', ')', '<', '>', '"', ',', '@', '_', '?', '%', '~', '.', '[', ']', '{', '}', ':', '/', '=', '!');
		$drop_char_replace = array_pad(array(), count($drop_char_match), ' ');

		// remove silent chars
		$drop_char_match = array_merge($drop_char_match, array('`', '\'', '\\'));
		$drop_char_replace = array_merge($drop_char_replace, array('', '', ''));

		return array($drop_char_match, $drop_char_replace);
	}

	function prepare_keywords()
	{
		global $db, $user;

		// encoding match for workaround
		$multibyte_charset = 'utf-8, big5, shift_jis, euc-kr, gb2312';

		$this->highlight = '';
		$search_words = array();

		// deal with first char
		$dft_operator = $this->parms['search_terms'] ? '+' : '|';
		$last_operator = $dft_operator;
		for ( $i = count($this->keywords) - 1; $i >= 0; $i-- )
		{
			$operator = substr($this->keywords[$i], 0, 1);
			$word = substr($this->keywords[$i], 1);
			if ( !in_array($operator, array('+', '-', '|')) )
			{
				$word = $operator . $word;
				$operator = ($i == 0) ? $last_operator : $dft_operator;
				$this->keywords[$i] = $operator . $word;
			}
			if ( strlen($word) >= WORD_MIN_LENGTH )
			{
				if ( $operator != '-' )
				{
					$this->highlight .= ' ' . $word;
				}
				$last_operator = ($operator == '|') ? '|' : '+';
				if ( !strpos(' ' . $word, '*') )
				{
					$search_words[$operator]['full'][] = $db->sql_escape_string($word);
				}
				else
				{
					$search_words[$operator]['like'][] = $db->sql_escape_string((strstr($multibyte_charset, $user->lang('ENCODING')) ? '%' . str_replace('*', '', $word) . '%' : str_replace('*', '%', $word)));
				}
			}
		}
		$this->keywords = $search_words;
		$this->highlight = trim(phpbb_rtrim($this->highlight, '\\'));

		if ( empty($this->keywords) )
		{
			return;
		}

		// do some work to get word_ids
		$word_ids = array();
		$found_words = array();
		foreach ( $this->keywords as $type => $dummy )
		{
			$word_ids[$type] = array();
			$count_full = count($this->keywords[$type]['full']);
			$count_like = count($this->keywords[$type]['like']);
			if ( $count_full || $count_like )
			{
				$sql = 'SELECT word_id, word_text
							FROM ' . SEARCH_WORD_TABLE . '
							WHERE word_common <> 1
								AND ' . ($count_like ? '(' : '') . ($count_full ? 'word_text IN(\'' . implode('\', \'', $this->keywords[$type]['full']) . '\')' : '') . ($count_full && $count_like ? '
									OR ' : '') . ($count_like ? 'word_text LIKE \'' . implode('\' OR word_text LIKE \'', $this->keywords[$type]['like']) . '\'' : '') . ($count_like ? ')' : '');
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$word_ids[$type][ intval($row['word_id']) ] = true;
					if ( $type == '+' )
					{
						// full words
						for ( $i = 0; $i < $count_full; $i++ )
						{
							if ( strtolower($row['word_text']) == $this->keywords[$type]['full'][$i] )
							{
								$found_words[$type]['full'][$i] = true;
							}
						}
						// like words
						for ( $i = 0; $i < $count_like; $i++ )
						{
							$mask = str_replace('%', '\w*', preg_quote($this->keywords[$type]['like'][$i], '#'));
							if ( preg_match('#\b(' . $mask . ')\b#i', $row['word_text']) )
							{
								$found_words[$type]['like'][$i] = true;
							}
						}
					}
				}
				$db->sql_freeresult($result);
			}
		}
		if ( (count($found_words['+']['full']) != count($this->keywords['+']['full'])) || (count($found_words['+']['like']) != count($this->keywords['+']['like'])) )
		{
			$word_ids = array();
		}
		$this->keywords = $word_ids;
		unset($word_ids);
		unset($found_words);

		// remove "not" words from "and" & "or" : if a "not" word is also a "and" word, drop the "and"
		if ( !empty($this->keywords['-']) )
		{
			foreach ( $this->keywords['-'] as $word_id => $dummy )
			{
				if ( isset($this->keywords['|'][$word_id]) )
				{
					unset($this->keywords['|'][$word_id]);
				}
				if ( isset($this->keywords['+'][$word_id]) )
				{
					unset($this->keywords['+']);
				}
			}
		}

		// remove "or" words from "and"
		if ( !empty($this->keywords['|']) )
		{
			foreach ( $this->keywords['|'] as $word_id => $dummy )
			{
				if ( isset($this->keywords['+'][$word_id]) )
				{
					unset($this->keywords['+'][$word_id]);
				}
			}
		}

		if ( empty($this->keywords['+']) && empty($this->keywords['|']) )
		{
			$this->keywords = array();
		}
	}

	function get_order()
	{
		// deal with order by
		$sqlorder = array();
		$sort_by = isset($this->parms['search_sort_by']) ? $this->parms['search_sort_by'] : '';
		switch ( $sort_by )
		{
			case 1: // Sort_Post_Subject
				if ( $this->parms['show_results'] == 'posts' )
				{
					$sqlorder = array(
						'order' => 'pt.post_subject' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
						'from' => ', ' . POSTS_TEXT_TABLE . ' pt',
						'where' => 'pt.post_id = p.post_id',
					);
					break;
				}
				else
				{
					$this->parms['search_sort_by'] = 2;
				}
			case 2: // Sort_Topic_Title
				$sqlorder = array(
					'order' => 't.topic_title' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
					'from' => ', ' . TOPICS_TABLE . ' t',
					'where' => 't.topic_id = p.topic_id',
				);
				break;
			case 3: // Sort_Author
				if ( $this->parms['show_results'] == 'posts' )
				{
					$sqlorder = array(
						'order' => 'u.username' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
						'from' => ', ' . USERS_TABLE . ' u',
						'where' => 'u.user_id = p.poster_id',
					);
				}
				else
				{
					$sqlorder = array(
						'order' => 't.topic_poster' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
						'from' => ', ' . TOPICS_TABLE . ' t',
						'where' => 't.topic_id = p.topic_id',
					);
				}
				break;
			case 4: // Sort_Forum
				$sqlorder = array(
					'order' => 'f.forum_order' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
					'from' => ', ' . FORUMS_TABLE . ' f',
					'where' => 'f.forum_id = p.forum_id',
				);
				break;
			default: // Sort_Time
				if ( $this->parms['show_results'] == 'posts' )
				{
					$sqlorder = array(
						'order' => 'p.post_time' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
					);
				}
				else
				{
					$sqlorder = array(
						'order' => 't.topic_last_post_id' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
						'from' => ', ' . TOPICS_TABLE . ' t',
						'where' => 't.topic_id = p.topic_id',
					);
				}
				break;
		}
		return $sqlorder;
	}

	function read_search_ids()
	{
		global $db, $limiter;

		$this->search_ids = array();

		// where to search
		$sql_match_fields = '';
		switch ( $this->parms['search_fields'] )
		{
			case 2: // title only
				$sql_match_fields = '
					AND m.title_match = 1';
				break;
			case 0: // message text only
				$sql_match_fields = '
					AND m.title_match = 0';
				break;
			default: // title + message text
				$sql_match_fields = '';
				break;
		}

		// order by
		$sqlorder = $this->get_order();

		// get "and"
		if ( !empty($this->keywords['+']) )
		{
			foreach ( $this->keywords['+'] as $word_id => $dummy )
			{
				$sql = 'SELECT m.post_id
							FROM ' . SEARCH_MATCH_TABLE . ' m, ' . POSTS_TABLE . ' p' . $sqlorder['from'] . '
							WHERE p.post_id = m.post_id' . (empty($sqlorder['where']) ? '' : '
								AND ' . $sqlorder['where']) . $sql_match_fields . (!empty($this->search_ids) ? '' : '
								AND p.forum_id IN(' . implode(', ', $this->forum_ids) . ')') . (!empty($this->search_ids) || empty($this->user_ids) ? '' : '
								AND p.poster_id IN(' . implode(', ', $this->user_ids) . ')') . (!empty($this->search_ids) || empty($this->parms['topic_days']) ? '' : '
								AND p.post_time >= ' . (time() - ($this->parms['topic_days'] * 86400))) . (empty($this->search_ids) ? '' : '
								AND m.post_id IN(' . implode(', ', array_keys($this->search_ids)) . ')') . '
								AND m.word_id = ' . intval($word_id) . '
							ORDER BY ' . $sqlorder['order'] . '
							LIMIT ' . intval($limiter);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				$this->search_ids = array();
				while ( $row = $db->sql_fetchrow($result) )
				{
					$this->search_ids[ intval($row['post_id']) ] = true;
				}
				$db->sql_freeresult($result);
			}
		}

		// get "or"
		if ( !empty($this->keywords['|']) )
		{
			$sql = 'SELECT m.post_id
						FROM ' . SEARCH_MATCH_TABLE . ' m, ' . POSTS_TABLE . ' p' . $sqlorder['from'] . '
						WHERE p.post_id = m.post_id' . (empty($sqlorder['where']) ? '' : '
							AND ' . $sqlorder['where']) . $sql_match_fields . '
							AND p.forum_id IN(' . implode(', ', $this->forum_ids) . ')' . (empty($this->user_ids) ? '' : '
							AND p.poster_id IN(' . implode(', ', $this->user_ids) . ')') . (empty($this->parms['topic_days']) ? '' : '
							AND p.post_time >= ' . (time() - ($this->parms['topic_days'] * 86400))) . '
							AND m.word_id IN(' . implode(', ', array_keys($this->keywords['|'])) . ')
						ORDER BY ' . $sqlorder['order'] . '
						LIMIT ' . intval($limiter);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->search_ids[ intval($row['post_id']) ] = true;
			}
			$db->sql_freeresult($result);
		}

		// get "not"
		if ( !empty($this->keywords['-']) && !empty($this->search_ids) )
		{
			$sql = 'SELECT m.post_id
						FROM ' . SEARCH_MATCH_TABLE . ' m, ' . POSTS_TABLE . ' p' . $sqlorder['from'] . '
						WHERE p.post_id = m.post_id' . (empty($sqlorder['where']) ? '' : '
							AND ' . $sqlorder['where']) . $sql_match_fields . '
							AND m.word_id IN(' . implode(', ', array_keys($this->keywords['-'])) . ')
							AND m.post_id IN(' . implode(', ', array_keys($this->search_ids)) . ')
						ORDER BY ' . $sqlorder['order'] . '
						LIMIT ' . intval($limiter);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
			while ( $row = $db->sql_fetchrow($result) )
			{
				if ( isset($this->search_ids[ intval($row['post_id']) ]) )
				{
					unset($this->search_ids[ intval($row['post_id']) ]);
				}
			}
			$db->sql_freeresult($result);
		}

		// format search ids
		if ( !empty($this->search_ids) )
		{
			if ( $this->parms['show_results'] == 'posts' )
			{
				$this->search_ids = array_keys($this->search_ids);
			}
			else
			{
				$sql = 'SELECT DISTINCT topic_id
							FROM ' . POSTS_TABLE . '
							WHERE post_id IN(' . implode(', ', array_keys($this->search_ids)) . ')';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				$this->search_ids = array();
				while ( $row = $db->sql_fetchrow($result) )
				{
					$this->search_ids[] = intval($row['topic_id']);
				}
				$db->sql_freeresult($result);
			}
		}
	}
}

class search_fulltext extends search
{
	function get_drop_chars()
	{
		$drop_char_match = array('^', '$', ';', '#', '&', '(', ')', '<', '>', '"', ',', '@', '?', '%', '~', '.', '[', ']', '{', '}', ':', '/', '=', '!');
		$drop_char_replace = array_pad(array(), count($drop_char_match), ' ');

		// remove silent chars
		$drop_char_match = array_merge($drop_char_match, array('`', '\'', '\\'));
		$drop_char_replace = array_merge($drop_char_replace, array('', '', ''));

		return array($drop_char_match, $drop_char_replace);
	}

	function prepare_keywords()
	{
		$this->highlight = '';

		// deal with first char
		$dft_operator = $this->parms['search_terms'] ? '+' : '|';
		$last_operator = $dft_operator;
		for ( $i = count($this->keywords) - 1; $i >= 0; $i-- )
		{
			$operator = substr($this->keywords[$i], 0, 1);
			$word = substr($this->keywords[$i], 1);
			if ( !in_array($operator, array('+', '-', '|')) )
			{
				$word = $operator . $word;
				$operator = ($i == 0) ? $last_operator : $dft_operator;
				$this->keywords[$i] = $operator . $word;
			}
			if ( strlen($word) >= WORD_MIN_LENGTH )
			{
				if ( $operator != '-' )
				{
					$this->highlight .= ' ' . $word;
				}
				$last_operator = ($operator == '|') ? '|' : '+';
				if ( strpos(' ' . $word, '*') )
				{
					$word = trim(str_replace('*', '', $word)) . '*';
					$this->keywords[$i] = $operator . $word;
				}
			}
			else
			{
				unset($this->keywords[$i]);
			}
		}
		$this->keywords = empty($this->keywords) ? array() : array_keys(array_flip($this->keywords));
		$this->highlight = phpbb_rtrim(trim($this->highlight), '\\');
	}

	function get_order()
	{
		// deal with order by
		$sqlorder = array();
		$sort_by = isset($this->parms['search_sort_by']) ? $this->parms['search_sort_by'] : '';
		switch ( $sort_by )
		{
			case 1: // Sort_Post_Subject
				if ( $this->parms['show_results'] == 'posts' )
				{
					$sqlorder = array(
						'order' => 'pt.post_subject' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
					);
					break;
				}
				else
				{
					$this->parms['search_sort_by'] = 2;
				}
			case 2: // Sort_Topic_Title
				$sqlorder = array(
					'order' => 't.topic_title' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
					'from' => ', ' . TOPICS_TABLE . ' t',
					'where' => 't.topic_id = p.topic_id',
				);
				break;
			case 3: // Sort_Author
				if ( $this->parms['show_results'] == 'posts' )
				{
					$sqlorder = array(
						'order' => 'u.username' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
						'from' => ', ' . USERS_TABLE . ' u',
						'where' => 'u.user_id = p.poster_id',
					);
				}
				else
				{
					$sqlorder = array(
						'order' => 't.topic_poster' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
						'from' => ', ' . TOPICS_TABLE . ' t',
						'where' => 't.topic_id = p.topic_id',
					);
				}
				break;
			case 4: // Sort_Forum
				$sqlorder = array(
					'order' => 'f.forum_order' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
					'from' => ', ' . FORUMS_TABLE . ' f',
					'where' => 'f.forum_id = p.forum_id',
				);
				break;
			default: // Sort_Time
				if ( $this->parms['show_results'] == 'posts' )
				{
					$sqlorder = array(
						'order' => 'p.post_time' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
					);
				}
				else
				{
					$sqlorder = array(
						'order' => 't.topic_last_post_id' . ($this->parms['search_sort_dir'] == 'DESC' ? ' DESC' : ''),
						'from' => ', ' . TOPICS_TABLE . ' t',
						'where' => 't.topic_id = p.topic_id',
					);
				}
				break;
		}
		return $sqlorder;
	}

	function read_search_ids()
	{
		global $db, $limiter;

		$this->search_ids = array();

		// fields to check according to the search type asked
		$sql_match = $this->parms['search_fields'] == 0 ? 'pt.post_text' : ($this->parms['search_fields'] == 2 ? 'pt.post_subject, pt.post_sub_title' : '');

		// order by
		$sqlorder = $this->get_order();

		// field id
		$sql_field_id = ($this->parms['show_results'] == 'posts') ? 'pt.post_id' : 'DISTINCT p.topic_id';
		$field_id = ($this->parms['show_results'] == 'posts') ? 'post_id' : 'topic_id';

		// build the request
		$sql = 'SELECT ' . $sql_field_id . '
					FROM ' . POSTS_TEXT_TABLE . ' pt, ' . POSTS_TABLE . ' p' . (isset($sqlorder['from']) ? $sqlorder['from'] : '') . '
					WHERE p.post_id = pt.post_id' . (!isset($sqlorder['where']) || empty($sqlorder['where']) ? '' : '
						AND ' . $sqlorder['where']) . '
						AND p.forum_id IN(' . implode(', ', $this->forum_ids) . ')' . (empty($this->user_ids) ? '' : '
						AND p.poster_id IN(' . implode(', ', $this->user_ids) . ')') . (!isset($this->parms['topic_days']) || empty($this->parms['topic_days']) ? '' : '
						AND p.post_time >= ' . (time() - ($this->parms['topic_days'] * 86400))) . (empty($this->keywords) ? '' : '
						AND MATCH(pt.post_subject, pt.post_sub_title, pt.post_text) AGAINST(' . $db->sql_type_cast(str_replace('|', '', implode(' ', $this->keywords))) . ' IN BOOLEAN MODE)') . (empty($sql_match) ? '' : '
						AND MATCH(' . $sql_match . ') AGAINST(' . $db->sql_type_cast(str_replace('|', '', implode(' ', $this->keywords))) . ' IN BOOLEAN MODE)') . '
					ORDER BY ' . $sqlorder['order'] . '
					LIMIT ' . intval($limiter);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->search_ids[] = intval($row[$field_id]);
		}
		$db->sql_freeresult($result);
	}
}

?>