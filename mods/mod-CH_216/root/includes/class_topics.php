<?php
//
//	file: includes/class_topics.php
//	author: ptirhiik
//	begin: 28/08/2004
//	version: 1.6.3 - 08/05/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class icons_cache extends cache
{
	var $types;

	function pre_process(&$rows)
	{
		$this->types = array();
	}

	function row_process(&$rows, &$row_id)
	{
		if ( ($rows[$row_id]['icon_types'] === '0') || !empty($rows[$row_id]['icon_types']) )
		{
			$rows[$row_id]['icon_types'] = explode(', ', $rows[$row_id]['icon_types']);
			$count_types = count($rows[$row_id]['icon_types']);
			for ($i = 0; $i < $count_types; $i++ )
			{
				$this->types[ $rows[$row_id]['icon_types'][$i] ] = $row_id;
			}
		}
		else
		{
			$rows[$row_id]['icon_types'] = array();
		}
	}

	function post_process(&$rows)
	{
		$rows['types'] = serialize($this->types);
	}
}

class icons
{
	var $data;
	var $types;
	var $data_time;
	var $from_cache;
	var $data_flag;
	var $allowed;
	var $allowed_flag;

	function read($force=false)
	{
		global $config;

		if ( !$force && $this->data_flag )
		{
			return $this->data;
		}
		$db_cached = new icons_cache('dta_icons', $config->data['cache_path'], $config->data['cache_disabled_icons']);
		$sql = 'SELECT * 
					FROM ' . ICONS_TABLE . '
					ORDER BY icon_order';
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force, 'icon_id');
		$this->types = unserialize($this->data['types']);
		unset($this->data['types']);
		$this->data_flag = true;
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;
		$this->allowed_flag = false;
	}

	function get_allowed($forum_id)
	{
		global $user;

		if ( $this->allowed_flag )
		{
			return;
		}

		$this->allowed = array();
		if ( !empty($this->data) )
		{
			foreach ( $this->data as $icon_id => $icon )
			{
				if ( empty($icon['icon_auth']) || $user->auth(POST_FORUM_URL, $icon['icon_auth'], $forum_id) )
				{
					$this->allowed[] = $icon_id;
				}
			}
		}
		$this->allowed_flag = true;
	}

	function display($box='ICON_BOX', $icon_id=0)
	{
		global $template, $user;

		if ( empty($this->allowed) )
		{
			return false;
		}

		// number per row
		$number_per_row = 10;

		// get icon box
		$template->assign_vars(array(
			'L_ICONS' => $user->lang('Message_icon'),
		));
		$template->set_switch('icons', !empty($this->allowed));

		// display the template
		$count_allowed = count($this->allowed);
		for ( $i = 0; $i < $count_allowed; $i++ )
		{
			if ( ($i % $number_per_row) == 0 )
			{
				$template->set_switch('icons.row');
			}
			$template->assign_block_vars('icons.row.cell', array(
				'ICON_ID' => $this->allowed[$i],
				'I_ICON' => defined('IN_ADMIN') ? $user->img($this->data[ $this->allowed[$i] ]['icon_url']) : $user->img_styled($this->data[ $this->allowed[$i] ]['icon_url']),
				'L_ICON' => $user->lang($this->data[ $this->allowed[$i] ]['icon_name']),
			));
			$template->set_switch('icons.row.cell.selected', ($this->allowed[$i] == $icon_id));
			$template->set_switch('icons.row.cell.img');
		}

		// add icon "none"
		if ( ($i % $number_per_row) == 0 )
		{
			$template->set_switch('icons.row');
		}
		$template->assign_block_vars('icons.row.cell', array(
			'ICON_ID' => 0,
			'I_ICON' => '',
			'L_ICON' => $user->lang('No_icon'),
			'S_SPAN' => ($count_allowed > 1) && (10-($i % 10) > 1) ? ' colspan="' . min(10-($i % 10), $count_allowed+1) . '"' : '',
		));
		$template->set_switch('icons.row.cell.selected', ($icon_id == 0));
		$template->set_switch('icons.row.cell.img', false);
		$template->assign_vars(array($box => $template->include_file('posting_icon_box.tpl', array('icons'))));
	}

	function topic_title($tpl_level, $icon_id, $topic_type, $first_post=true)
	{
		global $user, $template;

		if ( !$this->data_flag )
		{
			$this->read();
		}
		$topic_type = intval($topic_type);

		$template->assign_vars(array(
			'L_ICON' => $user->lang('Message_icon'),
		));

		if ( empty($icon_id) && $first_post)
		{
			$icon_id = empty($this->types[$topic_type]) ? 0 : $this->types[$topic_type];
		}
		$res = false;
		if ( !empty($this->data[$icon_id]['icon_url']) )
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'msg_icon', array(
				'L_ICON' => $user->lang($this->data[$icon_id]['icon_name']),
				'I_ICON' => $user->img_styled($this->data[$icon_id]['icon_url']),
			));
			$res = true;
		}
		else
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'msg_icon_ELSE', array());
			$res = false;
		}

		return $res;
	}
}

class topics_attr
{
	var $data;
	var $data_time;
	var $from_cache;
	var $allowed;
	var $allowed_flag;
	var $plug_ins;
	var $plug_ins_done;

	function topics_attr()
	{
		$this->data = false;
		$this->data_time = false;
		$this->from_cache = false;
		$this->allowed = false;
		$this->allowed_flag = false;
		$this->plug_ins = false;
		$this->plug_ins_done = false;
	}

	function read($force=false)
	{
		global $config;

		if ( !$force && !empty($this->data) )
		{
			return;
		}

		$db_cached = new cache('dta_topics_attr', $config->data['cache_path'], $config->data['cache_disabled_topics_attr']);
		$sql = 'SELECT * 
					FROM ' . TOPICS_ATTR_TABLE . '
					ORDER BY attr_order DESC';
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force, 'attr_id');
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;
		$this->allowed_flag = false;

		$this->data[] = array(
			'attr_added' => true,
			'attr_id' => 0,
			'attr_name' => 'Topic',
			'attr_fimg' => 'folder',
			'attr_order' => 0,
			'attr_field' => 'topic_type',
		);
	}

	function get_attr($row)
	{
		global $config, $user, $images;

		if ( empty($this->data) )
		{
			$this->read();
		}
		$forum_id = intval($row['forum_id']);

		// search attributes
		$types_attr = array();

		// get plug ins if any
		if ( !$this->plug_ins_done && ($this->plug_ins_done = true) )
		{
			$plug_ins = new plug_ins();
			$plug_ins->load('class_topics_attr');
			unset($plug_ins);
			$this->plug_ins = &$config->plug_ins['class_topics_attr'];
		}

		// browse the attributes and get the relevant ones
		foreach ( $this->data as $attr_id => $data )
		{
			if ( !($res = empty($data['attr_field'])) )
			{
				$attr_cond = isset($data['attr_cond']) ? $data['attr_cond'] : '';
				switch( $attr_cond )
				{
					case 'LT':
						$res = $row[ $data['attr_field'] ] < $data['attr_value'];
						break;
					case 'LE':
						$res = $row[ $data['attr_field'] ] <= $data['attr_value'];
						break;
					case 'EQ':
						$res = $row[ $data['attr_field'] ] == $data['attr_value'];
						break;
					case 'GE':
						$res = $row[ $data['attr_field'] ] >= $data['attr_value'];
						break;
					case 'GT':
						$res = $row[ $data['attr_field'] ] > $data['attr_value'];
						break;
					case 'NE':
						$res = $row[ $data['attr_field'] ] != $data['attr_value'];
						break;
					default:
						$res = ($data['attr_field'] != 'topic_sub_type') || (($data['attr_field'] == 'topic_sub_type') && ($row['topic_sub_type'] == $attr_id));
						break;
				}

				// plugs
				if ( $res && $this->plug_ins )
				{
					foreach ( $this->plug_ins as $plug => $dummy )
					{
						if ( method_exists($this->plug_ins[$plug], 'attr') )
						{
							$this->plug_ins[$plug]->attr($forum_id, $attr_id, $this->data, $res);
						}
					}
				}

				// moved specificities
				if ( $res && ($data['attr_field'] == 'topic_status') && ($row['topic_moved_id'] > 0) )
				{
					$res = false;
				}
			}
			if ( $res )
			{
				$types_attr[] = $attr_id;
			}
		}

		// ok, now let's get folder entry (we always have the added "standard topic" entry) retaining the first having a valid folder image
		$count_types_attr = count($types_attr);
		$folder_id = $types_attr[ ($count_types_attr - 1) ];
		for ( $i = 0; $i < $count_types_attr; $i++ )
		{
			if ( isset($images[ $this->data[ $types_attr[$i] ]['attr_fimg'] ]) )
			{
				$folder_id = $types_attr[$i];
				$i = $count_types_attr;
				break;
			}
		}

		// let's deal with own and hot for the folder img
		$res = array(0 => array('txt' => empty($this->data[$folder_id]['attr_fname']) ? array() : array($this->data[$folder_id]['attr_fname']), 'img' => $this->data[$folder_id]['attr_fimg']));

		// topic popular
		$hot = ($row['topic_replies'] >= $config->data['hot_threshold']);
		if ( $hot && isset($images[$res[0]['img'] . '_hot']) )
		{
			$res[0]['img'] .= '_hot';
		}

		// topic with new posts
		if ( $row['topic_unread'] )
		{
			if ( isset($images[$res[0]['img'] . '_new']) )
			{
				$res[0]['img'] .= '_new';
			}
			$res[0]['txt'][] = $hot ? 'New_posts_hot' : 'New_posts';
		}
		else
		{
			$res[0]['txt'][] = $hot ? 'No_new_posts_hot' : 'No_new_posts';
		}

		// topic the user has replied to
		if ( $row['topic_own'] )
		{
			if ( isset($images[$res[0]['img'] . '_own']) )
			{
				$res[0]['img'] .= '_own';
			}
			$res[0]['txt'][] = 'Own_topic';
		}

		// add other attributes
		$count_types_attr = count($types_attr);
		for ( $i = 0; $i < $count_types_attr; $i++ )
		{
			if ( $types_attr[$i] != $folder_id )
			{
				$res[] = array(
					'txt' => isset($this->data[ $types_attr[$i] ]['attr_tname']) ? $this->data[ $types_attr[$i] ]['attr_tname'] : '',
					'img' => isset($this->data[ $types_attr[$i] ]['attr_timg']) && !empty($this->data[ $types_attr[$i] ]['attr_timg']) ? $this->data[ $types_attr[$i] ]['attr_timg'] : '',
				);
			}
		}
		return $res;
	}

	function get_allowed($attr_field, $forum_id=0)
	{
		global $user;

		if ( empty($this->data) )
		{
			$this->read();
		}
		if ( $this->allowed_flag )
		{
			return;
		}
		$this->allowed = array(0 => 'None');
		foreach ( $this->data as $attr_id => $data )
		{
			if ( ($data['attr_field'] == $attr_field) && (empty($data['attr_auth']) || $user->auth(POST_FORUM_URL, $data['attr_auth'], $forum_id)) )
			{
				$this->allowed[$attr_id] = $data['attr_name'];
			}
		}
		$this->allowed_flag = true;
	}

	function topic_title($tpl_level, $topic_sub_type, $force_txt=false)
	{
		global $template, $user, $images;

		if ( !empty($topic_sub_type) )
		{
			if ( empty($this->data) )
			{
				$this->read();
			}
		}

		$res = false;
		if ( !empty($topic_sub_type) && isset($this->data[$topic_sub_type]) && (!empty($this->data[$topic_sub_type]['attr_tname']) || !empty($this->data[$topic_sub_type]['attr_timg'])) )
		{
			$img = !empty($this->data[$topic_sub_type]['attr_timg']) && isset($images[ $this->data[$topic_sub_type]['attr_timg'] ]);
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'sub_type', array(
				'L_SUB_TYPE' => empty($this->data[$topic_sub_type]['attr_tname']) ? '' : ($img || $force_txt ? _clean_html($user->lang($this->data[$topic_sub_type]['attr_tname'])) : $user->lang($this->data[$topic_sub_type]['attr_tname'])),
				'I_SUB_TYPE' => $img ? $user->img($this->data[$topic_sub_type]['attr_timg']) : '',
			));
			$template->set_switch((empty($tpl_level) ? '' : $tpl_level . '.') . 'sub_type.txt', !empty($this->data[$topic_sub_type]['attr_tname']) && (!$img || $force_txt));
			$template->set_switch((empty($tpl_level) ? '' : $tpl_level . '.') . 'sub_type.img', $img && !$force_txt);
			$res = true;
		}
		else
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'sub_type_ELSE', array());
			$res = false;
		}

		return $res;
	}
}

class front_sub_title
{
	function topic_title($tpl_level, $sub_title='', $display=true, $highlight_match='')
	{
		global $template, $user, $theme;

		$template->assign_vars(array(
			'L_SUB_TITLE' => $user->lang('Sub_title'),
		));

		$res = false;
		if ( $display && !empty($sub_title) )
		{
			$sub_title = _highlight(_censor($sub_title), $highlight_match);
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'sub_title', array(
				'SUB_TITLE' => $sub_title,
			));
			$res = true;
		}
		else
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'sub_title_ELSE', array());
			$res = false;
		}

		return $res;
	}
}

class front_announce
{
	function topic_title($tpl_level, $from, $to, $display=true)
	{
		global $template, $user;

		$res = false;
		if ( ($to > max($from, time())) && $display )
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'announce', array(
				'S_ANNOUNCE' => sprintf($user->lang('Announce_ends'), $user->date($to)),
			));
			$res = true;
		}
		else
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'announce_ELSE', array());
			$res = false;
		}
	}
}

class front_title
{
	var $front_sub_title;
	var $front_announce;
	var $plug_ins;

	function front_title()
	{
		global $config;

		$this->front_sub_title = new front_sub_title();
		$this->front_announce = new front_announce();

		// plugs
		$plug_ins = new plug_ins();
		$plug_ins->load('front_title');
		unset($plug_ins);
		$this->plug_ins = &$config->plug_ins['front_title'];
	}

	function set($tpl_level, $row, $first_post=true, $highlight_match='')
	{
		global $config, $template;
		global $icons, $topics_attr;

		// fields :
		// topic_type, topic_sub_type, topic_time, topic_duration, topic_calendar_time, topic_calendar_duration
		// post_icon, post_subject, post_sub_title

		$res = $first_post || !empty($row['post_subject']);

		// message icon
		$type = $first_post ? (($row['topic_type'] > POST_NORMAL) ? $row['topic_type'] : ($row['topic_calendar_time'] ? POST_CALENDAR : POST_NORMAL)) : POST_NORMAL;
		$res |= $icons->topic_title($tpl_level, $row['post_icon'], $type, $first_post);

		// sub title
		if ( $first_post && !empty($row['topic_sub_title']) )
		{
			$row['post_sub_title'] = $row['topic_sub_title'];
		}
		$res |= $this->front_sub_title->topic_title($tpl_level, isset($row['post_sub_title']) ? $row['post_sub_title'] : '', intval($config->data['sub_title_length']), $highlight_match);

		if ( $first_post )
		{
			// topic sub type
			$res |= $topics_attr->topic_title($tpl_level, $row['topic_sub_type']);

			// announce
			$res |= $this->front_announce->topic_title($tpl_level, $row['topic_time'], $row['topic_duration']);
		}

		// plugs
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'front_title') )
				{
					$res |= $this->plug_ins[$plug]->front_title($tpl_level, $row, $first_post);
				}
			}
		}
		$template->set_switch((empty($tpl_level) ? '' : $tpl_level . '.') . 'title', $res);
	}
}

class topics
{
	var $requester;
	var $parms;
	var $with_select;

	var $view_requester;
	var $view_parms;

	var $data;
	var $data_ext;
	var $forum_id;
	var $total_topics;
	var $total_announces;

	var $sort_fields;
	var $highlight;

	var $front_title;

	var $user_ids;
	var $topic_ids;

	var $with_user;

	function topics($requester='', $parms='')
	{
		$this->requester = empty($requester) ? INDEX : $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->set_view_link();
		$this->set_select(false);
		$this->set_highlight();

		$this->sort_fields = array(
			'lastpost' => array('txt' => 'Last_Post', 'field' => 't.topic_last_post_id'),
			'firstpost' => array('txt' => 'First_Post', 'field' => 't.topic_first_post_id'),
			'title' => array('txt' => 'Sort_Topic_Title', 'field' => 't.topic_title'),
			'type' => array('txt' => 'Sort_topic_status', 'field' => array('t.topic_sub_type', 't.topic_status', 't.topic_vote')),
			'replies' => array('txt' => 'Replies', 'field' => 't.topic_replies'),
			'views' => array('txt' => 'Views', 'field' => 't.topic_views'),
			'author' => array('txt' => 'Sort_Author', 'field' => 'u.username'),
		);

		$this->data = array();
		$this->data_ext = array();

		$this->total_topics = 0;
		$this->total_announces = 0;
		$this->with_user = false;
	}

	function set_view_link($view_requester='', $view_parms='')
	{
		$this->view_requester = empty($view_requester) ? 'viewtopic' : $view_requester;
		$this->view_parms = empty($view_parms) ? array() : $view_parms;
	}

	function set_select($with_select=true)
	{
		$this->with_select = $with_select;
	}

	function set_highlight($highlight='')
	{
		$this->highlight = _format_highlight($highlight);
	}

	function init()
	{
		return true;
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
		if ( $only_own_global )
		{
			$board_box = 0;
		}
		switch ( $board_box )
		{
			case BOARD_GLOBAL_ANNOUNCES:
				$board_announces = true;
				$parent_announces = $child_announces = false;
				break;
			case BOARD_PARENT_ANNOUNCES:
				$board_announces = $parent_announces = true;
				$child_announces = false;
				break;
			case BOARD_CHILD_ANNOUNCES:
				$board_announces = $child_announces = true;
				$parent_announces = false;
				break;
			case BOARD_BRANCH_ANNOUNCES:
				$board_announces = $parent_announces = $child_announces = true;
				break;
			default:
				$board_announces = $parent_announces = $child_announces = false;
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
		if ( $board_box )
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
			$sql_where .= ') AND (t.topic_duration = 0 OR t.topic_duration  > ' . time() . ')' . ($this->forum_id ? ' AND (t.forum_id <> ' . intval($this->forum_id) . ')' : '');

			// process
			$sql = 'SELECT t.*
						FROM ' . TOPICS_TABLE . ' t' . $sql_join . '
						WHERE ' . $sql_where . '
						ORDER BY t.topic_type DESC, t.topic_last_time DESC';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$forums_denied = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				if ( !isset($forums_denied[ $row['forum_id'] ]) && $user->auth(POST_FORUM_URL, 'auth_read', $row['forum_id']) )
				{
					$this->row_process($row);
					$this->data_ext[ $row['topic_id'] ] = $row;
				}
				else
				{
					$forums_denied[ $row['forum_id'] ] = true;
				}
			}
			$db->sql_freeresult($result);
			unset($forums_denied);
		}

		// read this forum topics
		$this->data = array();
		$this->total_announces = 0;
		$nb_topics = 0;
		$now = time();
		if ( ($forums->data[$this->forum_id]['forum_type'] == POST_FORUM_URL) && $user->auth(POST_FORUM_URL, 'auth_read', $this->forum_id) )
		{
			// get announces
			$sql = 'SELECT *
						FROM ' . TOPICS_TABLE . '
						WHERE forum_id = ' . intval($this->forum_id) . '
							AND topic_type IN(' . POST_ANNOUNCE . ', ' . POST_GLOBAL_ANNOUNCE . ')
						ORDER BY topic_type DESC, topic_last_time DESC';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$this->total_announces = $db->sql_numrows($result);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->row_process($row);
				$this->data[ $row['topic_id'] ] = $row;
			}
			$db->sql_freeresult($result);

			// get number of regular topics
			$nb_topics = $forums->data[$this->forum_id]['forum_topics'] - $this->total_announces;
			if ( $nb_topics )
			{
				if ( intval($this->parms['topicdays']) )
				{
					$sql = 'SELECT COUNT(topic_id) AS count_topic_id
								FROM ' . TOPICS_TABLE . '
								WHERE forum_id = ' . intval($this->forum_id) . '
									AND topic_last_time >= ' . ($now - ($this->parms['topicdays'] * 86400)) . '
									AND topic_type NOT IN(' . POST_ANNOUNCE . ', ' . POST_GLOBAL_ANNOUNCE . ')';
					$result = $db->sql_query($sql, false, __LINE__, __FILE__);
					$nb_topics = ($row = $db->sql_fetchrow($result)) ? intval($row['count_topic_id']) : 0;
					$db->sql_freeresult($result);
				}
			}

			// request
			if ( $nb_topics )
			{
				if ( !is_array($this->sort_fields[ $this->parms['sort'] ]['field']) )
				{
					$this->sort_fields[ $this->parms['sort'] ]['field'] = array($this->sort_fields[ $this->parms['sort'] ]['field']);
				}
				if ( !in_array('t.topic_last_post_id', $this->sort_fields[ $this->parms['sort'] ]['field']) )
				{
					$this->sort_fields[ $this->parms['sort'] ]['field'][] = 't.topic_last_post_id';
				}
				$sql = 'SELECT t.*' . (($this->parms['sort'] != 'author') ? '' : ', u.' . implode(', u.', $user->pool_fields)) . '
							FROM ' . TOPICS_TABLE . ' t' . (($this->parms['sort'] != 'author') ? '' : '
								LEFT JOIN ' . USERS_TABLE . ' u
									ON u.user_id = t.topic_poster') . '
							WHERE t.forum_id = ' . intval($this->forum_id) . (!intval($this->parms['topicdays']) ? '' : '
								AND t.topic_last_time >= ' . ($now - ($this->parms['topicdays'] * 86400))) . '
								AND t.topic_type NOT IN(' . POST_ANNOUNCE . ', ' . POST_GLOBAL_ANNOUNCE . ')
							ORDER BY t.topic_type DESC, ' . implode((($this->parms['order'] == 'ASC') ? '' : ' ' . $this->parms['order']) . ', ', $this->sort_fields[ $this->parms['sort'] ]['field']) . (($this->parms['order'] == 'ASC') ? '' : ' ' . $this->parms['order']) . '
							LIMIT ' . intval($this->parms['start']) . ', ' . intval($this->parms['ppage']);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$this->with_user = ($this->parms['sort'] == 'author');
				while ( $row = $db->sql_fetchrow($result) )
				{
					$this->row_process($row);
					$this->data[ $row['topic_id'] ] = $row;
				}
				$db->sql_freeresult($result);
			}
		}

		// end the read
		$this->total_topics = $this->total_announces + $nb_topics;
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
			if ( $this->with_user )
			{
				$user->pool[ $row['topic_poster'] ] = array();
				$count_pool_fields = count($user->pool_fields);
				for ( $i = 0; $i < $count_pool_fields; $i++ )
				{
					$user->pool[ $row['topic_poster'] ][ $user->pool_fields[$i] ] = $row[ $user->pool_fields[$i] ];
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
			$sql = 'SELECT DISTINCT topic_id
						FROM ' . POSTS_TABLE . '
						WHERE poster_id = ' . intval($user->data['user_id']) . '
							AND topic_id IN(' . implode(', ', $topic_ids) . ')';
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
		global $template;

		if ( $upper_box )
		{
			$data = &$this->data_ext;
			$tpl_name = 'topics_row_box.tpl';
			$tpl_blocks = array('topicrow');
		}
		else
		{
			$data = &$this->data;
			$tpl_name = 'topics_box.tpl';
			$tpl_blocks = array('topicrow', 'pagination', 'forum_header');
		}
		if ( $res = ($display_empty || !empty($data)) )
		{
			$this->display($upper_box, $display_empty, $forced_title);
			$res = $template->include_file($tpl_name, $tpl_blocks);
		}
		return $res ? $res : '';
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

				'L_NO_TOPICS' => empty($this->view_parms) ? $user->lang($no_topics_msg) : $user->lang('No_topics'),

				'U_POST_NEW_TOPIC' => $config->url(POSTING, array('mode' => 'newtopic', POST_FORUM_URL => $this->forum_id), true),
				'L_POST_NEW_TOPIC' => $user->lang($new_topic_msg),
				'I_POST_NEW_TOPIC' => $user->img($new_topic_img),

				'I_SPACER' => $user->img('spacer'),

				'S_ACTION' => $config->url(INDEX, array(POST_FORUM_URL => $this->forum_id), true),
			));

			// display forum's commands and pagination
			if ( !$upper_box || $display_empty )
			{
				$template->assign_block_vars('forum_header', array(
					'U_VIEW_FORUM' => $config->url(INDEX, array(POST_FORUM_URL => $this->forum_id) + $this->parms, true),
					'FORUM_NAME' => $user->lang($forums->data[$this->forum_id]['forum_name']),
					'FORUM_DESC' => _clean_html($user->lang($forums->data[$this->forum_id]['forum_desc'])),
					'U_MARK_READ' => $config->url(INDEX, array(POST_FORUM_URL => $this->forum_id, 'mark' => 'topics'), true),
					'L_MARK_READ' => $user->lang('Mark_all_topics'),
					'I_MARK_READ' => $user->img('topic_mark_read'),
				));
				$template->set_switch('forum_header.mark', $user->data['session_logged_in']);

				// pagination
				$parms = $this->parms;
				unset($parms['start']);
				$pagination = new pagination($this->requester, array(POST_FORUM_URL => $this->forum_id) + $parms, 'start');
				$pagination->display('pagination', $this->total_topics - $this->total_announces, $this->parms['ppage'], $this->parms['start'], true, 'Topics_count', $this->total_topics);

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
		$template->assign_vars(array(
			'BOTTOM_ROW' => $template->include_file('topics_bottom_forum.tpl'),
		));
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
		}
		if ( ($row['topic_last_poster'] != ANONYMOUS) && isset($user->pool[ $row['topic_last_poster'] ]) )
		{
			$row['topic_last_username'] = $user->pool[ $row['topic_last_poster'] ]['username'];
		}

		// send to template
		$template->assign_block_vars('topicrow', array(
			'L_HEADER_TITLE' => $user->lang($header_title),

			'I_TOPIC_FOLDER' => $s_folder_img,
			'L_TOPIC_FOLDER' => $s_folder_txt,

			'U_NEWEST_POST' => $config->url($this->view_requester, array_merge($this->view_parms, array(POST_TOPIC_URL => intval($row['topic_id']), 'view' => 'newest')), true),
			'L_NEWEST_POST' => $user->lang('View_newest_post'),
			'I_NEWEST_POST' => $user->img('icon_newest_reply'),

			'U_VIEW_TOPIC' => $config->url($this->view_requester, array_merge($this->view_parms, array(POST_TOPIC_URL => intval($row['topic_moved_id']) ? intval($row['topic_moved_id']) : intval($row['topic_id']))), true),
			'TOPIC_TIME' => $row['topic_moved_id'] ? '' : $user->date($row['topic_time']),
			'TOPIC_TITLE' => _highlight(_censor($row['topic_title']), $this->highlight),
			'TOPIC_ID' => $row['topic_id'],

			'U_TOPIC_AUTHOR' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['topic_poster']), true),
			'TOPIC_AUTHOR' => (empty($row['topic_first_username']) || ($row['topic_first_username'] == ANONYMOUS)) ? $user->lang('Guest') : $row['topic_first_username'],
			'VIEWS' => $row['topic_moved_id'] ? '' : $row['topic_views'],
			'REPLIES' => $row['topic_moved_id'] ? '' : $row['topic_replies'],

			'LAST_POST_TIME' => $row['topic_moved_id'] ? '' : $user->date($row['topic_last_time']),
			'U_LAST_POST_AUTHOR' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['topic_last_poster']), true),
			'LAST_POST_AUTHOR' => $row['topic_moved_id'] ? '' : ((empty($row['topic_last_username']) || ($row['topic_last_username'] == ANONYMOUS)) ? $user->lang('Guest') : $row['topic_last_username']),
			'U_LAST_POST' => $config->url($this->view_requester, array_merge($this->view_parms, array(POST_POST_URL => intval($row['topic_last_post_id']))), true, intval($row['topic_last_post_id'])),
		));
		$template->set_switch('topicrow.topic');
		$template->set_switch('topicrow.topic.select', $this->with_select);
		$template->set_switch('topicrow.topic.moved', !empty($row['topic_moved_id']));
		$template->set_switch('topicrow.topic.last_post_link', empty($row['topic_moved_id']));
		$template->set_switch('topicrow.topic.topic_time', empty($row['topic_moved_id']));
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
		$this->front_title->set('topicrow.topic', $row, true, $this->highlight);

		// pagination/navigation
		$pagination_added = false;
		if ( empty($row['topic_moved_id']) && (($row['topic_replies'] + 1) > $config->data['posts_per_page']) )
		{
			$pagination = new pagination($this->view_requester, array_merge($this->view_parms, array(POST_TOPIC_URL => intval($row['topic_id']))), 'start');
			$pagination->display('topicrow.topic.pagination', $row['topic_replies'] + 1, $config->data['posts_per_page'], 0, false);
			$pagination_added = true;
		}
		if ( $with_nav )
		{
			$template->set_switch('topicrow.topic.navigation');
			$forums->display_nav($row['forum_id'], 'topicrow.topic.navigation.nav', true);
		}
		$template->set_switch('topicrow.topic.pagination_OR_nav', $pagination_added || $with_nav);

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

// init
$icons = new icons();
$topics_attr = new topics_attr();

?>