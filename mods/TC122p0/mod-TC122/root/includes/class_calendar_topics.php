<?php
/***************************************************************************
 *                            class_calendar_topics.php
 *                            -------------------------
 *	begin			: 02/08/2003
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 1.0.0 - 14/04/2006
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

include($config->url('includes/class_calendar_topics_parse'));

// tree drawing
define('POST_TREE_URL', 't');

class calendar_event_topics extends calendar_event
{
	var $from;
	var $to;
	var $first_posts;
	var $overview;
	var $front_calendar;
	var $forums;

	function calendar_event_topics($requester='', $parms='', &$handler, $module_id)
	{
		global $calendar_api;

		parent::calendar_event($requester, $parms, $handler, $module_id);
		$this->from = 0;
		$this->to = 0;
		$this->first_posts = array();
		$this->overview = array();
		$this->front_calendar = new front_calendar();
		$this->forums = new calendar_forums();

		// add our filter
		$this->handler->register_selection(array(
			'forum' => array('legend' => 'Select_forum', 'module_id' => $this->module_id, 'api' => 'select_forums'),
		));
		$calendar_api->set();
	}

	// xfrom & xto are user date, array('y' =>, 'm' =>, 'd' =>, 'h' =>, 'i' =>)
	function read($xfrom, $xto)
	{
		global $db, $user;
		global $calendar_api;

		if ( !$calendar_api->is_unix($xfrom) || !$calendar_api->is_unix($xto) )
		{
			return false;
		}
		$this->from = $calendar_api->user_to_sys($xfrom);
		$this->to = $calendar_api->user_to_sys($xto);

		$this->data = array();
		$this->first_posts = array();

		// verify the parm
		if ( !($forum_ids = $this->forums->retrieve_ids($this->handler->parms[POST_TREE_URL])) )
		{
			return false;
		}

		// get topics
		$sql = 'SELECT t.*
					FROM ' . TOPICS_TABLE . ' t
					WHERE t.topic_moved_id = 0
						AND t.topic_calendar_time > 0
						AND t.topic_calendar_time < ' . intval($this->to) . '
						AND (t.topic_calendar_time + t.topic_calendar_duration) >= ' . intval($this->from) . '
						AND t.forum_id IN(' . implode(', ', $forum_ids) . ')
					ORDER BY t.topic_calendar_time, t.topic_calendar_duration DESC';
		unset($forum_ids);

		if ( !($result = $db->sql_query($sql, false, __LINE__, __FILE__, false)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain topics informations', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->data[ intval($row['topic_id']) ] = $row;
			if ( $this->handler->settings['overview'] )
			{
				$this->first_posts[] = intval($row['topic_first_post_id']);
			}
		}
		$db->sql_freeresult($result);
	}

	function get_occurrences($topic_id)
	{
		global $calendar_api;

		if ( !isset($this->data[$topic_id]) || !$this->from || !$this->to )
		{
			return array();
		}
		$xstart = $calendar_api->sys_to_user(intval($this->data[$topic_id]['topic_calendar_time']));
		$xend = intval($this->data[$topic_id]['topic_calendar_duration']) ? $calendar_api->sys_to_user(intval($this->data[$topic_id]['topic_calendar_time']) + intval($this->data[$topic_id]['topic_calendar_duration'])) : array();
		return array(array($xstart, $xend));
	}

	function display_overview($topic_ids=false)
	{
		global $db, $template, $config, $user;
		global $calendar_api;

		if ( !$this->handler->settings['overview'] || empty($this->first_posts) )
		{
			return false;
		}

		// do we focus on one particular day ?
		$first_posts = $topic_ids ? array() : $this->first_posts;
		if ( $topic_ids )
		{
			$topic_ids = array_keys($topic_ids);
			$count_topics = count($topic_ids);
			for ( $i = 0; $i < $count_topics; $i++ )
			{
				$first_posts[] = intval($this->data[ intval($topic_ids[$i]) ]['topic_first_post_id']);
			}
			$topic_ids = false;
		}
		if ( empty($first_posts) )
		{
			return false;
		}

		// let's go and display the overview
		$sql = 'SELECT p.*, pt.bbcode_uid, pt.post_text, u.user_id, u.username
					FROM ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt, ' . USERS_TABLE . ' u
					WHERE pt.post_id = p.post_id
						AND u.user_id = p.poster_id
						AND p.post_id IN(' . implode(', ', $first_posts) . ')';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain first posts informations', '', __LINE__, __FILE__, $sql);
		}
		$message_parser = new calendar_message();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$topic_id = intval($row['topic_id']);
			$poster_id = !intval($row['poster_id']) || (intval($row['user_id']) == ANONYMOUS) ? ANONYMOUS : intval($row['user_id']);
			$template->assign_block_vars('event_topic', array(
				'ID' => $this->get_id($this->module_id, $topic_id),

				'L_CALENDAR_EVENT' => $user->lang('Calendar_event'),
				'L_CALENDAR_AUTHOR' => $user->lang('Author'),
				'L_CALENDAR_TIME' => $user->lang('Posted'),
				'L_CALENDAR_FORUM' => $user->lang('Forum'),
				'L_CALENDAR_REPLIES' => $user->lang('Replies'),
				'L_CALENDAR_VIEWS' => $user->lang('Views'),

				'S_CALENDAR_DATES' => $this->front_calendar->title($this->data[$topic_id]['topic_calendar_time'], $this->data[$topic_id]['topic_calendar_duration']),
				'TOPIC_TITLE' => _censor($this->data[$topic_id]['topic_title']),
				'U_TOPIC_TITLE' => $config->url('viewtopic', array(POST_TOPIC_URL => $topic_id), true),
				'TOPIC_AUTHOR' => $poster_id == ANONYMOUS ? $user->lang('Guest') : $row['username'],
				'TOPIC_TIME' => $user->date($this->data[$topic_id]['topic_time']),
				'TOPIC_REPLIES' => $this->data[$topic_id]['topic_replies'],
				'TOPIC_VIEWS' => $this->data[$topic_id]['topic_views'],
				'TOPIC_MESSAGE' => $message_parser->parse($row, $this->handler->settings['text_length'], $this->handler->settings['javascript']),
			));
			$this->forums->display_nav($row, 'event_topic.nav');
			if ( !$this->handler->settings['javascript'] )
			{
				$this->overview[$topic_id] = $template->include_escaped_file('calendar_overview_topic_txt.tpl', 'event_topic');
			}
		}
		unset($message_parser);
		$db->sql_freeresult($result);
		return $this->handler->settings['javascript'] ? $template->include_file('calendar_overview_topic_js.tpl', 'event_topic') : '';
	}

	function retrieve_item($event_id)
	{
		global $config, $user;
		global $calendar_api;

		return !$event_id || !isset($this->data[ intval($event_id['item_id']) ]) ? false : $this->format_item(array(
			'vars' => array(
				'ID' => $this->get_id($event_id),
				'I_TITLE' => $user->img('icon_tiny_topic'),
				'L_TITLE' => $user->lang('Topic'),
				'U_TITLE' => $config->url('viewtopic', array(POST_TOPIC_URL => intval($event_id['item_id'])), true),
				'TITLE' => _censor($this->data[ intval($event_id['item_id']) ]['topic_title']),
				'S_DATES' => $this->front_calendar->title($this->data[ intval($event_id['item_id']) ]['topic_calendar_time'], $this->data[ intval($event_id['item_id']) ]['topic_calendar_duration']),
				'S_OVERVIEW' => isset($this->overview[ intval($event_id['item_id']) ]) && !$this->handler->settings['javascript'] ? $this->overview[ intval($event_id['item_id']) ] : '',
			),
			'switches' => array(
				'dates' => true,
				'overview' => isset($this->overview[ intval($event_id['item_id']) ]) && !$this->handler->settings['javascript'],
			),
		));
	}

	function select_forums()
	{
		$options = array();
		$value = intval($this->handler->parms[POST_TREE_URL]);
		if ( !$this->forums->build_select(POST_TREE_URL, $options, $value) )
		{
			return array();
		}

		// define the field
		$form_fields = array(
			POST_TREE_URL => array('type' => 'list', 'legend' => 'Select_forum', 'value' => $value, 'options' => $options),
		);

		// activate the parm
		if ( !empty($value) )
		{
			$this->handler->parms[POST_TREE_URL] = $value;
		}
		else if ( isset($this->handler->parms[POST_TREE_URL]) )
		{
			unset($this->handler->parms[POST_TREE_URL]);
		}
		return $form_fields;
	}
}

?>