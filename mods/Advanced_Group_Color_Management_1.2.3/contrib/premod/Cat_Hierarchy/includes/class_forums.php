<?php
/***************************************************************************
 *							class_forums.php
 *							----------------
 *	begin		: 08/10/2004
 *	copyright	: Ptirhiik
 *	email		: ptirhiik@clanmckeen.com
 *
 *	Version		: 0.0.13 - 31/10/2005
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

/*----------------------------------------------
To handle new fields in forums table :
after having added the fields to the forums table

- these fields are stable ones (modified only through ACP)
add them to $this->cached_fields, and regen the forum cache (see admin/admin_forums to add them to the ACP forum management)

- these fields work like counters (modified on the flow by the user)
add them to $this->dynamic_fields

- these fields refers to the last post/topic of the forum
add them to $this->last_fields

That's all :)
------------------------------------------------*/

class cache_forums extends cache
{
	var $dynamic_fields;
	var $last_fields;
	var $count_dynamic_fields;
	var $count_last_fields;

	function cache_forums($cache_file='', $cache_path='', $cache_disabled='')
	{
		parent::cache($cache_file, $cache_path, $cache_disabled);

		// static fieds
		$this->cached_fields = array(
			'forum_id',
			'forum_name',
			'forum_desc',
			'forum_type',
			'forum_main',
			'forum_order',
			'forum_status',
			'prune_enable',
			'forum_nav_icon',
			'forum_icon',
			'forum_link',
			'forum_link_hit_count',
			'forum_link_start',
			'forum_topics_ppage',
			'forum_topics_sort',
			'forum_topics_order',
			'forum_style',
			'forum_index_pack',
			'forum_index_split',
			'forum_board_box',
			'forum_subs_hidden',
		);

		// dynamic fields (counter)
		$this->dynamic_fields = array(
			'prune_next',
			'forum_topics',
			'forum_posts',
			'forum_link_hit',
		);

		// last topic fields
		$this->last_fields = array(
			'forum_last_post_id',
			'forum_last_title',
			'forum_last_poster',
			'forum_last_username',
			'forum_last_time',
		);
		$this->count_dynamic_fields = count($this->dynamic_fields);
		$this->count_last_fields = count($this->last_fields);
	}

	function pre_process(&$rows)
	{
		$rows[0] = array();
	}

	function row_process(&$rows, $row_id)
	{
		$rows[$row_id]['last_child_id'] = $row_id;
		$rows[$row_id]['subs'] = array();
		if ( !empty($row_id) )
		{
			$rows[ intval($rows[$row_id]['forum_main']) ]['subs'][] = $row_id;
		}
		if ( $this->cache_disabled )
		{
			$this->row_process_no_cache($rows, $row_id);
		}
	}

	function row_process_no_cache(&$rows, $row_id)
	{
		// last fields
		if ( !empty($rows[$row_id]['forum_last_post_id']) )
		{
			$rows[$row_id]['last'] = array();
			for ( $i = 0; $i < $this->count_last_fields; $i++ )
			{
				$rows[$row_id]['last'][ $this->last_fields[$i] ] = $rows[$row_id][ $this->last_fields[$i] ];
				if ( isset($rows[$row_id][ $this->last_fields[$i] ]) )
				{
					unset($rows[$row_id][ $this->last_fields[$i] ]);
				}
			}

			// username
			if ( ($rows[$row_id]['last']['forum_last_poster'] != ANONYMOUS ) && !empty($rows[$row_id]['last']['forum_last_poster']) && !empty($rows[$row_id]['username']) )
			{
				$rows[$row_id]['last']['forum_last_username'] = $rows[$row_id]['username'];
				if ( isset($rows[$row_id]['username']) )
				{
					unset($rows[$row_id]['username']);
				}
			}
		}
	}

	function post_process(&$rows)
	{
		global $config;

		// overwrite forum root def.
		$rows[0] = array_merge($rows[0], array(
			'forum_id' => 0,
			'forum_order' => 0,
			'forum_name' => 'Forum_index',
			'forum_desc' => $config->data['sitename'],
			'forum_type' => POST_CAT_URL,
			'forum_status' => FORUM_UNLOCKED,
			'forum_nav_icon' => $config->data['index_fav_icon'],
			'forum_topics_ppage' => $config->data['topics_per_page'],
			'forum_topics_sort' => $config->data['topics_sort'],
			'forum_topics_order' => $config->data['topics_order'],
			'forum_style' => $config->data['default_style'],
			'forum_index_split' => $config->data['index_split'],
			'forum_index_pack' => $config->data['index_pack'],
		));

		// get keys and last branch forum id
		$keys = array_keys($rows);
		$count_keys = count($keys);
		for ( $i = $count_keys-1; $i > 0; $i-- )
		{
			$cur_id = $keys[$i];
			$main_id = intval($rows[$cur_id]['forum_main']);
			if ( $rows[ $rows[$cur_id]['last_child_id'] ]['forum_order'] > $rows[ $rows[$main_id]['last_child_id'] ]['forum_order'] )
			{
				$rows[$main_id]['last_child_id'] = $rows[$cur_id]['last_child_id'];
			}
		}
	}
}

class forums
{
	var $data;
	var $data_time;
	var $keys;
	var $data_flag;
	var $from_cache;
	var $displayed;
	var $moderators;
	var $last_fields;
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
	var $user_ids;
//-- fin mod : Advanced Group Color Management ---------------------------------


	var $requester;

	function forums()
	{
		$this->data = array();
		$this->keys = array();
		$this->data_flag = false;
		$this->moderators = new moderators();
		$this->tracking_all = 0;
		$this->tracking_forums = array();
		$this->tracking_topics = array();

		$this->requester = 'index';
	}

	function read($force=false)
	{
		global $config;

		// already readen
		if ( $this->data_flag && !$force )
		{
			return;
		}

		// read data
		$config->data['cache_disabled_' . POST_FORUM_URL] |= empty($config->data['cache_key']);
		$db_cached = new cache_forums('dta_forums', $config->data['cache_path'], $config->data['cache_disabled_' . POST_FORUM_URL]);
		if ( $config->data['cache_disabled_' . POST_FORUM_URL] )
		{
			$sql = 'SELECT ' . implode(', ', array_merge($db_cached->cached_fields, $db_cached->dynamic_fields, $db_cached->last_fields)) . '
						FROM ' . FORUMS_TABLE . '
						ORDER BY forum_order';
		}
		else
		{
			$sql = 'SELECT ' . implode(', ', $db_cached->cached_fields) . '
						FROM ' . FORUMS_TABLE . '
						ORDER BY forum_order';
		}
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force, 'forum_id');
		$this->data_flag = true;
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;
		$this->keys = array_keys($this->data);

		// recache moderators if forum data come from table and forum cache isn't disabled
		if ( !$this->from_cache && !$config->data['cache_disabled_' . POST_FORUM_URL] )
		{
			// recache moderators
			$moderators = new moderators();
			$moderators->read(true);

			// recache jumpbox
			$config->set('cache_time_' . POST_FORUM_URL . 'jbox', $this->data_time);
		}
	}

	// this one can only be called if the $user object has been created
	function refresh($forum_id=0)
	{
		global $db, $config, $user;

		// no forums : stop there
		if ( empty($this->data) )
		{
			return;
		}

		// $forum_id unknown, stop there
		if ( !isset($this->data[$forum_id]) )
		{
			return;
		}

		// get min and max index
		$tkeys = array_flip($this->keys);
		$max = $tkeys[ $this->data[$forum_id]['last_child_id'] ];
		$min = $tkeys[$forum_id];
		unset($tkeys);

		// refresh last posts per forum when table is cached
		if ( !$config->data['cache_disabled_' . POST_FORUM_URL] )
		{
			// create cache object to get the lists of fields
			$db_cached = new cache_forums();

			// get subs last posts
			$sql = 'SELECT forum_id, ' . implode(', ', array_merge($db_cached->dynamic_fields, $db_cached->last_fields)) . '
						FROM ' . FORUMS_TABLE . '
						WHERE forum_order BETWEEN ' . intval($this->data[$forum_id]['forum_order']) . ' AND ' . intval( $this->data[ $this->data[$forum_id]['last_child_id'] ]['forum_order']);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				// dynamic fields (not cached)
				for ( $i = 0; $i < $db_cached->count_dynamic_fields; $i++ )
				{
					$this->data[ $row['forum_id'] ][ $db_cached->dynamic_fields[$i] ] = $row[ $db_cached->dynamic_fields[$i] ];
				}

				// last fields
				if ( !empty($row['forum_last_post_id']) )
				{
					$this->data[ $row['forum_id'] ]['last'] = array();
					for ( $i = 0; $i < $db_cached->count_last_fields; $i++ )
					{
						$this->data[ $row['forum_id'] ]['last'][ $db_cached->last_fields[$i] ] = $row[ $db_cached->last_fields[$i] ];
					}
				}
			}
			$db->sql_freeresult($result);
		}

		// get unreaded topics list
		$user->read_cookies();

		// we can now dump last topics data from lower level to root (eg the asked forum), according to user auths
		for ( $i = $max; $i > $min; $i-- )
		{
			// get ids
			$cur_id = $this->keys[$i];
			$main_id = intval($this->data[$cur_id]['forum_main']);

			// init level
			if ( !isset($this->data[$cur_id]['forum_last_time']) )
			{
				$this->data[$cur_id]['forum_last_time'] = 0;
			}
			if ( !isset($this->data[$cur_id]['last']) )
			{
				$this->data[$cur_id]['last'] = array('forum_last_time' => $this->data[$cur_id]['forum_last_time']);
			}
			// init parent
			if ( !isset($this->data[$main_id]['forum_last_time']) )
			{
				$this->data[$main_id]['forum_last_time'] = 0;
			}
			if ( !isset($this->data[$main_id]['last']) )
			{
				$this->data[$main_id]['last'] = array('forum_last_time' => $this->data[$main_id]['forum_last_time']);
			}

			// init sum level (no subs)
			if ( empty($this->data[$cur_id]['sum_last_post_forum_id']) )
			{
				$this->data[$cur_id]['sum_forum_posts'] = $this->data[$cur_id]['sum_forum_topics'] = $this->data[$cur_id]['sum_last_post_forum_id'] = 0;
				$this->data[$cur_id]['sum_flag_unread'] = false;
			}
			// init parent
			if ( empty($this->data[$main_id]['sum_last_post_forum_id']) )
			{
				$this->data[$main_id]['sum_forum_posts'] = $this->data[$main_id]['sum_forum_topics'] = $this->data[$main_id]['sum_last_post_forum_id'] = 0;
				$this->data[$main_id]['sum_flag_unread'] = false;
			}

			// report the level to sub-level sum
			if ( $user->auth(POST_FORUM_URL, 'auth_read', $cur_id) )
			{
				if ( !isset($this->data[$cur_id]['flag_unread']) )
				{
					$this->data[$cur_id]['flag_unread'] = false;
				}
				if ( !empty($user->cookies['f_unreads']) && !empty($user->cookies['f_unreads'][$cur_id]) )
				{
					$this->data[$cur_id]['flag_unread'] = true;
				}

				$this->data[$cur_id]['sum_forum_posts'] += $this->data[$cur_id]['forum_posts'];
				$this->data[$cur_id]['sum_forum_topics'] += $this->data[$cur_id]['forum_topics'];
				$this->data[$cur_id]['sum_flag_unread'] |= $this->data[$cur_id]['flag_unread'];
				if ( empty($this->data[$cur_id]['sum_last_post_forum_id']) || ($this->data[$cur_id]['last']['forum_last_time'] >= $this->data[ $this->data[$cur_id]['sum_last_post_forum_id'] ]['last']['forum_last_time']) )
				{
					$this->data[$cur_id]['sum_last_post_forum_id'] = $cur_id;
				}
			}
			// add the sum to the parent level
			$this->data[$main_id]['sum_forum_posts'] += $this->data[$cur_id]['sum_forum_posts'];
			$this->data[$main_id]['sum_forum_topics'] += $this->data[$cur_id]['sum_forum_topics'];
			$this->data[$main_id]['sum_flag_unread'] |= $this->data[$cur_id]['sum_flag_unread'];
			if ( empty($this->data[$main_id]['sum_last_post_forum_id']) || ( !empty($this->data[$cur_id]['sum_last_post_forum_id']) && ($this->data[ $this->data[$cur_id]['sum_last_post_forum_id'] ]['last']['forum_last_time'] >= $this->data[ $this->data[$main_id]['sum_last_post_forum_id'] ]['last']['forum_last_time'])) )
			{
				$this->data[$main_id]['sum_last_post_forum_id'] = $this->data[$cur_id]['sum_last_post_forum_id'];
			}
		}
	}

//-- mod : Advanced Group Color Management -------------------------------------
//-- add
	function display_color($forum_id=0)
	{
		global $user;

		$count_subs = count($this->data[$forum_id]['subs']);
		$this->user_ids = array();

		for ( $i = 0; $i < $count_subs; $i++ )
		{
			$cur_id = $this->data[$forum_id]['subs'][$i];

			$layer_type = $this->data[$cur_id]['forum_type'];

			switch ( $layer_type )
			{
				case POST_CAT_URL:
					$this->display_color_a_cat($cur_id);
					break;
				case POST_FORUM_URL:
					$this->display_color_a_forum($cur_id);
					break;
			}
		}
	}

	function display_color_a_cat($forum_id)
	{
		global $user;

		$count_subs = count($this->data[$forum_id]['subs']);

		for ( $i = 0; $i < $count_subs; $i++ )
		{
			$cur_id = $this->data[$forum_id]['subs'][$i];

			$layer_type = $this->data[$cur_id]['forum_type'];

			switch ( $layer_type )
			{
				case POST_CAT_URL:
				case POST_FORUM_URL:
					$this->display_color_a_forum($cur_id);
					break;
			}
		}
	}

	function display_color_a_forum($forum_id)
	{
		global $user;

		$last_post_data = $this->data[ $this->data[$forum_id]['sum_last_post_forum_id'] ]['last'];

		if ( !in_array($last_post_data['forum_last_poster'], array(0, ANONYMOUS)) && !isset($user->pool[ $last_post_data['forum_last_poster'] ]) )
		{
			$this->user_ids[ $last_post_data['forum_last_poster'] ] = true;
		}
	}
//-- fin mod : Advanced Group Color Management ---------------------------------

	function display($forum_id=0)
	{
		global $db, $template, $config, $user;

		$this->displayed = false;

		// pack level
		$pack_index = $config->data['index_pack'];
		if ( !$config->data['index_pack_over'] )
		{
			switch ( intval($user->data['user_index_pack']) )
			{
				case DENY:
					$pack_index = false;
					break;
				case TRUE:
					$pack_index = true;
					break;
			}
		}
		if ( !empty($forum_id) )
		{
			switch ( intval($this->data[$forum_id]['forum_index_pack']) )
			{
				case DENY:
					$pack_index = false;
					break;
				case TRUE:
					$pack_index = true;
					break;
			}
		}

		// split cats
		$split_index = $config->data['index_split'];
		if ( !$config->data['index_split_over'] )
		{
			switch ( intval($user->data['user_index_split']) )
			{
				case DENY:
					$split_index = false;
					break;
				case TRUE:
					$split_index = true;
					break;
			}
		}
		if ( !empty($forum_id) )
		{
			switch ( intval($this->data[$forum_id]['forum_index_split']) )
			{
				case DENY:
					$split_index = false;
					break;
				case TRUE:
					$split_index = true;
					break;
			}
		}
		if ( $pack_index && $split_index )
		{
			$split_index = false;
		}

		// send legends
		$template->assign_vars(array(
			'L_EMPTY' => $user->lang('None'),
			'L_FORUM' => $user->lang('Forum'),
			'L_TOPICS' => $user->lang('Topics'),
			'L_POSTS' => $user->lang('Posts'),
			'L_LASTPOST' => $user->lang('Last_Post'),
			'L_SUBFORUMS' => $user->lang('Subforums'),

			'L_LAST_TOPIC' => $user->lang('View_topic'),
			'L_LAST_POSTER' => $user->lang('Read_profile'),
			'I_LAST_POST' => $user->img('icon_latest_reply'),
			'L_LAST_POST' => $user->lang('View_latest_post'),
			'L_NO_POSTS' => $user->lang('No_Posts'),
			'L_AUTH_REQ' => $user->data['session_logged_in'] ? $user->lang('Auth_read_required') : $user->lang('Registration_required'),
		));

		// read all sub-levels
		$count_subs = count($this->data[$forum_id]['subs']);
		$page_header_sent = false;
		$block_header_sent = false;
		$block_header_type = '';
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		$this->display_color($forum_id);
		$user->read_pool($this->user_ids);
//-- fin mod : Advanced Group Color Management ---------------------------------

		for ( $i = 0; $i < $count_subs; $i++ )
		{
			$cur_id = $this->data[$forum_id]['subs'][$i];
			if ( $user->auth(POST_FORUM_URL, 'auth_view', $cur_id) || defined('IN_ADMIN') )
			{
				// get the layer type
				$layer_type = (($this->data[$cur_id]['forum_type'] == POST_CAT_URL) && $pack_index) ? POST_FORUM_URL : $this->data[$cur_id]['forum_type'];

				// simplify header types (forums and links layers are considered the same and so not splitted)
				$prev_header_type = (!$page_header_sent || ($block_header_type == POST_CAT_URL)) ? POST_CAT_URL : POST_FORUM_URL;
				$cur_header_type = ($layer_type == POST_CAT_URL) ? POST_CAT_URL : POST_FORUM_URL;

				// verify if we need a split and/or a new block
				$new_split = !$page_header_sent || ($split_index && (($cur_header_type == POST_CAT_URL) || ($prev_header_type != $cur_header_type)));
				$new_block = $new_split || !$block_header_sent || ($prev_header_type != $cur_header_type) || ($cur_header_type == POST_CAT_URL);


				// close the previous block
				if ( $block_header_sent && $new_block )
				{
					// send block footer
					$footer_only = true;
					switch ( $block_header_type )
					{
						case POST_CAT_URL:
							$this->display_a_cat($cur_id, $new_block, $moderators, $footer_only);
							break;
						case POST_FORUM_URL:
							$this->display_a_forum($cur_id, $new_block, $moderators, $footer_only);
							break;
						case POST_LINK_URL:
							$this->display_a_link($cur_id, $new_block, $moderators, $footer_only);
							break;
					}
					$block_header_sent = false;
				}

				// close the previous split
				if ( $page_header_sent && $new_split )
				{
					$template->set_switch('indexrow');
					$template->set_switch('indexrow.footer');
					$template->set_switch('indexrow.spacing');
					$page_header_sent = false;
				}

				// new block start
				if ( $new_split )
				{
					$template->assign_block_vars('indexrow', array());
					$template->assign_block_vars('indexrow.header', array());
					$page_header_sent = true;
					$block_header_sent = false;
				}

				// send the line
				switch ( $layer_type )
				{
					case POST_CAT_URL:
						$this->display_a_cat($cur_id, $new_block, $moderators);
						break;
					case POST_FORUM_URL:
						$this->display_a_forum($cur_id, $new_block, $moderators);
						break;
					case POST_LINK_URL:
						$this->display_a_link($cur_id, $new_block, $moderators);
						break;
				}
				if ( $new_block )
				{
					$block_header_sent = true;
					$block_header_type = $layer_type;
				}
			}
		}
		if ( $block_header_sent )
		{
			$this->displayed = true;
			switch ( $block_header_type )
			{
				case POST_CAT_URL:
					$this->display_a_cat($cur_id, $new_block, $moderators, true);
					break;
				case POST_FORUM_URL:
					$this->display_a_forum($cur_id, $new_block, $moderators, true);
					break;
				case POST_LINK_URL:
					$this->display_a_link($cur_id, $new_block, $moderators, true);
					break;
			}
			$block_header_sent = false;

			// if one block has been sent, split header has been too
			$template->set_switch('indexrow');
			$template->set_switch('indexrow.footer');
			$template->set_switch('indexrow.footer.command');
			$template->set_switch('indexrow.footer.command.delete', !empty($forum_id));
			$page_header_sent = false;
		}
		else
		{
			$this->display_empty($forum_id);
		}
	}

	function display_empty($forum_id=0)
	{
	}

	function display_a_cat($forum_id, $with_header, &$moderators, $footer_only=false)
	{
		global $template, $config, $user;

		$tpl_fields = array();
		if ( !$footer_only )
		{
			$tpl_fields = array(
				'U_VIEWCAT' => $config->url($this->requester, array(POST_FORUM_URL => $forum_id), true),
				'CAT_DESC' => $user->lang($this->data[$forum_id]['forum_name']),
			);
		}

		// send line
		$template->assign_block_vars('indexrow', array());
		$template->assign_block_vars('indexrow.cat', $tpl_fields);

		// send block footer if required
		$template->set_switch('indexrow.cat.footer', $footer_only);
		if ( $footer_only )
		{
			return;
		}

		// send data
		$template->set_switch('indexrow.cat.row');

		// send block header if required
		$template->set_switch('indexrow.cat.header', $with_header);

		// display subforums
		$count_subs = count($this->data[$forum_id]['subs']);
		for ( $i = 0; $i < $count_subs; $i++ )
		{
			$cur_id = $this->data[$forum_id]['subs'][$i];
			if ( $user->auth(POST_FORUM_URL, 'auth_view', $cur_id) )
			{
				switch ( $this->data[$cur_id]['forum_type'] )
				{
					case POST_CAT_URL:
					case POST_FORUM_URL:
						$this->display_a_forum($cur_id, false, $moderators);
						break;
					case POST_LINK_URL:
						$this->display_a_link($cur_id, false, $moderators);
						break;
				}
			}
		}
	}

	function display_a_forum($forum_id, $with_header, &$moderators, $footer_only=false)
	{
		global $template, $config, $user;
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		global $colors;
//-- fin mod : Advanced Group Color Management ---------------------------------


		// send line
		$tpl_fields = array();
		if ( !$footer_only )
		{
			$folder_img = $this->get_folder_img($forum_id);
			$tpl_fields = array(
				'I_FORUM_FOLDER' => $user->img($folder_img['img']),
				'L_FORUM_FOLDER' => $user->lang($folder_img['txt']),
				'U_VIEWFORUM' => $config->url($this->requester, array(POST_FORUM_URL => $forum_id), true),
				'FORUM_NAME' => $user->lang($this->data[$forum_id]['forum_name']),
				'FORUM_DESC' => $user->lang($this->data[$forum_id]['forum_desc']),
				'FORUM_ICON' => empty($this->data[$forum_id]['forum_icon']) ? '' : $user->img($this->data[$forum_id]['forum_icon']),
				'TOPICS' => $this->data[$forum_id]['sum_forum_topics'],
				'POSTS' => $this->data[$forum_id]['sum_forum_posts'],
			);
			// last post
			$last_post_data = empty($this->data[$forum_id]['sum_last_post_forum_id']) ? array() : $this->data[ $this->data[$forum_id]['sum_last_post_forum_id'] ]['last'];
			$last_post = !empty($last_post_data) && !empty($last_post_data['forum_last_time']);
			if ( $last_post )
			{
				if ( empty($last_post_data['forum_last_username']) )
				{
					$last_post_data['forum_last_poster'] = ANONYMOUS;
					$last_post_data['forum_last_username'] = $user->lang('Guest');
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	}
//-- add
					$user->pool[ ANONYMOUS ]['username'] = $user->lang('Guest');
				}
				else
				{
					$user->pool[ ANONYMOUS ]['username'] = $last_post_data['forum_last_username'];
				}

				$user->pool[ ANONYMOUS ]['user_group_id'] = '0';
				$user->pool[ ANONYMOUS ]['user_session_time'] = '0';
//-- fin mod : Advanced Group Color Management ---------------------------------

				$last_topic_title_alt = !empty($last_post_data['forum_last_title']) ? _censor($last_post_data['forum_last_title']) : '';
				$last_topic_title = _un_htmlspecialchars($last_topic_title_alt);
				if ( (intval($config->data['last_topic_title_length']) > 3) && (strlen($last_topic_title_alt) > $config->data['last_topic_title_length']) )
				{
					$last_topic_title = substr($last_topic_title, 0, intval($config->data['last_topic_title_length'])-3) . '...';
				}
				$last_topic_title = htmlspecialchars($last_topic_title);
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
				$usercolor = $colors->get_user_color($user->pool[ $last_post_data['forum_last_poster'] ]['user_group_id'], $user->pool[ $last_post_data['forum_last_poster'] ]['user_session_time'], $user->pool[ $last_post_data['forum_last_poster'] ]['username']);
//-- fin mod : Advanced Group Color Management ---------------------------------

				$tpl_fields += array(
					'U_LAST_TOPIC' => empty($last_post_data['forum_last_post_id']) ? '' : $config->url('viewtopic', array(POST_POST_URL => $last_post_data['forum_last_post_id']), true, $last_post_data['forum_last_post_id']),
					'LAST_TOPIC_TITLE' => $last_topic_title,
					'LAST_TOPIC_TITLE_ALT' => $last_topic_title_alt,
					'U_LAST_POSTER' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $last_post_data['forum_last_poster']), true),
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	'LAST_POSTER' => $last_post_data['forum_last_username'],
//-- add
					'LAST_POSTER' => $usercolor,
//-- fin mod : Advanced Group Color Management ---------------------------------

					'U_LAST_POST' => empty($last_post_data['forum_last_post_id']) ? '' : $config->url('viewtopic', array(POST_POST_URL => $last_post_data['forum_last_post_id']), true, $last_post_data['forum_last_post_id']),
					'LAST_POST_TIME' => $user->date($last_post_data['forum_last_time']),
				);
			}
		}

		// send all to template
		$template->set_switch('indexrow');
		$template->assign_block_vars('indexrow.forum', $tpl_fields);

		// send block footer if required
		$template->set_switch('indexrow.forum.footer', $footer_only);
		if ( $footer_only )
		{
			return;
		}

		// send data
		$template->set_switch('indexrow.forum.row');

		// send forum icon
		$template->set_switch('indexrow.forum.row.forum_icon', !empty($this->data[$forum_id]['forum_icon']));

		// send last post
		$auth_read = $user->auth(POST_FORUM_URL, 'auth_read', $forum_id);
		$template->set_switch('indexrow.forum.row.auth_read', $auth_read);
		if ( $auth_read )
		{
			$template->set_switch('indexrow.forum.row.auth_read.last_post', $last_post);
			if ( $last_post )
			{
				$template->set_switch('indexrow.forum.row.auth_read.last_post.userlink', $last_post_data['forum_last_poster'] != ANONYMOUS);
			}
		}

		// send moderators
		$this->moderators->display('indexrow.forum.row.moderators', $forum_id);

		// send subforums
		$this->display_subs_list('indexrow.forum.row', $forum_id);

		// send block header if required
		$template->set_switch('indexrow.forum.header', $with_header);
	}

	function display_a_link($forum_id, $with_header, &$moderators, $footer_only=false)
	{
		global $template, $config, $user;

		$tpl_fields = array();
		if ( !$footer_only )
		{
			$folder_img = $this->get_folder_img($forum_id);
			$tpl_fields = array(
				'I_FORUM_FOLDER' => $user->img($folder_img['img']),
				'L_FORUM_FOLDER' => $user->lang($folder_img['txt']),
				'U_VIEWFORUM' => $config->url($this->requester, array(POST_FORUM_URL => $forum_id), true),
				'FORUM_NAME' => $user->lang($this->data[$forum_id]['forum_name']),
				'FORUM_DESC' => $user->lang($this->data[$forum_id]['forum_desc']),
				'FORUM_ICON' => empty($this->data[$forum_id]['forum_icon']) ? '' : $user->img($this->data[$forum_id]['forum_icon']),
				'HITS' => $this->data[$forum_id]['forum_link_hit_count'] ? sprintf($user->lang('Forum_link_visited'), $this->data[$forum_id]['forum_link_hit'], $user->date($this->data[$forum_id]['forum_link_start'])) : '',
			);
		}
		$template->set_switch('indexrow');
		$template->assign_block_vars('indexrow.link', $tpl_fields);
		$template->set_switch('indexrow.link.external', !empty($this->data[$forum_id]['forum_link']) && preg_match('#^(mailto\:|(news|(ht|f)tp(s?))\:\/\/)#i', $this->data[$forum_id]['forum_link']));

		// send block footer if required
		$template->set_switch('indexrow.link.footer', $footer_only);
		if ( $footer_only )
		{
			return;
		}

		// send data
		$template->set_switch('indexrow.link.row');

		// send forum icon
		$template->set_switch('indexrow.link.row.forum_icon', !empty($this->data[$forum_id]['forum_icon']));

		// send subforums
		$this->display_subs_list('indexrow.link.row', $forum_id);

		// send block header if required
		$template->set_switch('indexrow.link.header', $with_header);
	}

	// display subforums
	function display_subs_list($switch, $forum_id, $force=false)
	{
		global $template, $config, $user;

		if ( $this->data[$forum_id]['forum_subs_hidden'] && !$force )
		{
			return;
		}

		$subs = array();
		$count_subs = count($this->data[$forum_id]['subs']);
		for ( $i = 0; $i < $count_subs; $i++ )
		{
			if ( $user->auth(POST_FORUM_URL, 'auth_view', $this->data[$forum_id]['subs'][$i]) )
			{
				$subs[] = $this->data[$forum_id]['subs'][$i];
			}
		}
		$count_subs = count($subs);
		$template->set_switch($switch . '.subforums', !empty($count_subs));
		if ( !empty($count_subs) )
		{
			for ( $i = 0; $i < $count_subs; $i++ )
			{
				// folder img
				$folder_img = $this->get_folder_img($subs[$i], true);

				$template->assign_block_vars($switch . '.subforums.sub', array(
					'U_SUB' => $config->url($this->requester, array(POST_FORUM_URL => $subs[$i]), true),
					'L_SUB' => $user->lang($this->data[ $subs[$i] ]['forum_name']),
					'L_SUB_DESC' => _clean_html($user->lang($this->data[ $subs[$i] ]['forum_desc'])),
					'I_SUB' => $user->img($folder_img['img']),
					'L_SUB_ALT' => $user->lang($folder_img['txt']),
					'L_SEP' => $i == ($count_subs - 1) ? '' : ', ',
				));
				$template->set_switch($switch . '.subforums.sub.sep', $i < ($count_subs - 1));
				$template->set_switch($switch . '.subforums.sub.external', !empty($this->data[ $subs[$i] ]['forum_link']) && preg_match('#^(mailto\:|(news|(ht|f)tp(s?))\:\/\/)#i', $this->data[ $subs[$i] ]['forum_link']));
			}
		}
	}

	function get_folder_img($forum_id, $tiny=false)
	{
		switch ( $this->data[$forum_id]['forum_type'] )
		{
			case POST_CAT_URL:
				$dft = array('txt' => 'No_new_posts', 'img' => $tiny ? 'icon_minicat' : 'category');
				$new = array('txt' => 'New_posts', 'img' => $tiny ? 'icon_minicat_new' : 'category_new');
				$lock = array('txt' => 'Forum_is_locked', 'img' => $tiny ? 'icon_minicat_locked' : 'category_locked');
				break;
			case POST_FORUM_URL:
				$dft = array('txt' => 'No_new_posts', 'img' => $tiny ? 'forum_tiny' : 'forum');
				$new = array('txt' => 'New_posts', 'img' => $tiny ? 'forum_new_tiny' : 'forum_new');
				$lock = array('txt' => 'Forum_is_locked', 'img' => $tiny ? 'forum_locked_tiny' : 'forum_locked');
				break;
			case POST_LINK_URL:
				$dft = array('txt' => 'Link', 'img' => $tiny ? 'icon_minilink' : 'link');
				$new = $dft;
				$lock = $dft;
				break;
		}
		$res = ($this->data[$forum_id]['forum_status'] == FORUM_LOCKED) ? $lock : ($this->data[$forum_id]['sum_flag_unread'] ? $new : $dft);
		return $res;
	}

	function display_nav($forum_id=0, $tpl_switch='nav', $no_root=false, $extra_parms=array())
	{
		global $template, $config, $user, $navigation;

		$stack = array();
		while ( !empty($forum_id) )
		{
			if ( !isset($this->data[$forum_id]) )
			{
				$forum_id = 0;
			}
			else
			{
				$stack[] = $forum_id;
				$forum_id = intval($this->data[$forum_id]['forum_main']);
			}
		}

		// reverse read (LIFO) and display
		$navigation = new navigation($this->requester);
		$count_stack = count($stack);
		for ( $i = $count_stack-1; $i >= 0; $i-- )
		{
			$navigation->add($this->data[ $stack[$i] ]['forum_name'], $this->data[ $stack[$i] ]['forum_desc'], $this->requester, array(POST_FORUM_URL => $stack[$i]) + $extra_parms, $this->data[ $stack[$i] ]['forum_nav_icon']);
		}
		$navigation->display($tpl_switch, !$no_root);
	}

	function mark($type, $id)
	{
		global $config, $user;

		$time = time();
		$msg = '';

		switch ( $type )
		{
			// mark sub forums
			case POST_FORUM_URL:
				if ( $id == 0 )
				{
					$user->read_cookies();
					$user->cookies['f_all'] = $time;
					if ( isset($user->cookies['forums']) )
					{
						unset($user->cookies['forums']);
					}
					if ( isset($user->cookies['topics']) )
					{
						unset($user->cookies['topics']);
					}
					if ( isset($user->cookies['unreads']) )
					{
						unset($user->cookies['unreads']);
					}
					$user->write_cookies(array('f_all', 'forums', 'topics', 'unreads'));
					$msg = 'Forums_marked_read';
				}
				else
				{
					$user->read_cookies(true);
					if ( !empty($this->data[$id]['subs']) )
					{
						// get min and max index
						$tkeys = array_flip($this->keys);
						$max = $tkeys[ $this->data[$id]['last_child_id'] ];
						$min = $tkeys[ $this->data[$id]['subs'][0] ];
						unset($tkeys);

						// update
						for ( $i = $min; $i <= $max; $i++ )
						{
							$user->cookies['forums'][ $this->keys[$i] ] = $time;
							$count_topics = (!empty($user->cookies['unreads_per_forums']) && !empty($user->cookies['unreads_per_forums'][ $this->keys[$i] ])) ? count($user->cookies['unreads_per_forums'][ $this->keys[$i] ]) : 0;
							for ( $j = 0; $j < $count_topics; $j++ )
							{
								$topic_id = $user->cookies['unreads_per_forums'][ $this->keys[$i] ][$j];
								if ( isset($user->cookies['topics'][$topic_id]) )
								{
									unset($user->cookies['topics'][$topic_id]);
								}
								if ( isset($user->cookies['unreads'][$topic_id]) )
								{
									unset($user->cookies['unreads'][$topic_id]);
								}
							}
						}

						// write cookies
						$user->write_cookies(array('forums', 'topics', 'unreads'));
					}
					$msg = 'Forums_marked_read';
				}
				break;

			// mark the viewed forum
			case POST_TOPIC_URL:
				$user->read_cookies(true);
				$user->cookies['forums'][$id] = $time;
				$count_topics = (!empty($user->cookies['unreads_per_forums']) && !empty($user->cookies['unreads_per_forums'][$id])) ? count($user->cookies['unreads_per_forums'][$id]) : 0;
				for ( $i = 0; $i < $count_topics; $i++ )
				{
					$topic_id = $user->cookies['unreads_per_forums'][$id][$i];
					if ( isset($user->cookies['topics'][$topic_id]) )
					{
						unset($user->cookies['topics'][$topic_id]);
					}
					if ( isset($user->cookies['unreads'][$topic_id]) )
					{
						unset($user->cookies['unreads'][$topic_id]);
					}
				}

				// write cookies
				$user->write_cookies(array('forums', 'topics', 'unreads'));

				$msg = 'Topics_marked_read';
				break;

			// mark the viewed topic
			case POST_POST_URL:
				$user->read_cookies();
				$user->cookies['topics'][$id] = $time;
				$topic_last_read = empty($user->cookies['unreads']) ? 0 : intval($user->cookies['unreads'][$id]);
				if ( !empty($user->cookies['unreads']) && isset($user->cookies['unreads'][$id]) )
				{
					unset($user->cookies['unreads'][$id]);
				}
				$user->write_cookies(array('topics', 'unreads'));
				return $topic_last_read;
				break;
		}
		if ( !empty($msg) )
		{
			message_return($msg, $id ? 'Click_return_forum' : '', $config->url($this->requester, array(POST_FORUM_URL => $id), true));
		}
	}

	function get_front_pic($mode='', $forum_id=0, $except_child_id=0)
	{
		global $user;

		// admin context : except the branch the forum_id is root
		switch ( $mode )
		{
			case 'except':
				// get forum asked branch idx
				$tkeys = array_flip($this->keys);
				$min = $tkeys[$forum_id];
				$max = $tkeys[ $this->data[$forum_id]['last_child_id'] ];
				unset($tkeys);

				// extract the omitted branch
				$keys = $this->keys;
				array_splice($keys, $min, ($max - $min + 1));
				$keys = empty($keys) ? array() : array_keys(array_flip($keys));
				break;

			case 'only':
				// add forum
				$keys = array($forum_id);

				// add it's child
				$count_subs = count($this->data[$forum_id]['subs']);
				for ( $i = 0; $i < $count_subs; $i++ )
				{
					if ( $this->data[$forum_id]['subs'][$i] != $except_child_id )
					{
						$keys[] = $this->data[$forum_id]['subs'][$i];
					}
				}
				break;

			default:
				$keys = &$this->keys;
				break;
		}

		// retain only viewable forums (last ids per branch & level)
		$last_id = array();
		$level = array();
		$count_keys = count($keys);
		for ( $i = 0; $i < $count_keys; $i++ )
		{
			$cur_id = $keys[$i];
			if ( !empty($mode) || $user->auth(POST_FORUM_URL, 'auth_view', $cur_id) || (defined('IN_ADMIN') && $user->auth(POST_FORUM_URL, 'auth_manage', $cur_id)) )
			{
				$last_id[$cur_id] = $cur_id;
				$level[$cur_id] = 0;
				if ( $i > 0 )
				{
					$last_id[ intval($this->data[$cur_id]['forum_main']) ] = $cur_id;
					$level[$cur_id] = $level[ intval($this->data[$cur_id]['forum_main']) ] + 1;
				}
			}
		}

		// prepare return
		$front_pic = array();

		$close = array();
		$previous_level = 0;
		if ( !empty($last_id) )
		{
			foreach ( $last_id as $forum_id => $last_child_id )
			{
				$close[ $level[$forum_id] ] = empty($forum_id) || ($last_id[ intval($this->data[$forum_id]['forum_main']) ] == $forum_id);

				$linefeed = '';
				$option = '';
				for ( $i = 1; $i <= $level[$forum_id]; $i++ )
				{
					if ( $i == $level[$forum_id] )
					{
						$linefeed .= TREE_VSPACE;
						$option .= $close[$i] ? TREE_CLOSE : TREE_CROSS;
					}
					else
					{
						$linefeed .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
						$option .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
					}
				}
				if ( $previous_level > $level[$forum_id] )
				{
					$front_pic[ (0-count($front_pic)-100) ] = $linefeed;
				}
				$front_pic[$forum_id] = $option;
				$previous_level = $level[$forum_id];
			}
		}
		return $front_pic;
	}

	function get_jumpbox($with_select=false, $forum_id=0)
	{
		global $config, $user;

		if ( empty($user->cache_time[POST_FORUM_URL . 'jbox']) || ($user->cache_time[POST_FORUM_URL . 'jbox'] < $config->data['cache_time_' . POST_FORUM_URL . 'jbox']) )
		{
			$user->get_cache(POST_FORUM_URL . 'jbox');
		}
		if ( empty($user->cache_time[POST_FORUM_URL . 'jbox']) )
		{
			$now = time();
			$front_pic = $this->get_front_pic();
			$user->cache(POST_FORUM_URL . 'jbox', $front_pic, $now);
		}
		else
		{
			$front_pic = $user->cache[POST_FORUM_URL . 'jbox'];
		}

		// get the forums name
		if ( !empty($front_pic) )
		{
			$options = '';
			foreach ( $front_pic as $cur_id => $front )
			{
				$selected = $with_select && ($cur_id == $forum_id) ? ' selected="selected"' : '';
				$options .= '<option value="' . (($cur_id >= 0) ? $cur_id : -1) . '"' . $selected . '>';
				$count_front = strlen($front);
				for ( $i = 0; $i < $count_front; $i++ )
				{
					$options .= $user->lang('tree_pic_' . $front[$i]);
				}
				if ( $cur_id >= 0 )
				{
					$options .= $user->lang($this->data[$cur_id]['forum_name']);
				}
				$options .= '</option>';
			}
		}
		else
		{
			$options = '<option value="-1">' . $user->lang('None') . '</option>';
		}

		return $options;
	}
}

class cache_moderators extends cache
{
	function post_process(&$rows)
	{
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		global $colors;
//-- fin mod : Advanced Group Color Management ---------------------------------

		$count_rows = count($rows);
		$res = array();
		for ( $i = 0; $i < $count_rows; $i++ )
		{
			if ( !isset($res[ $rows[$i]['obj_id'] ]) )
			{
				$res[ $rows[$i]['obj_id'] ] = array();
			}
			if ( !empty($rows[$i]['user_id']) )
			{
				$row = array('mod_type' => POST_USERS_URL, 'mod_id' => $rows[$i]['user_id'], 'mod_name' => $rows[$i]['username'], 'mod_system' => false);
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
				$row = $row + array('mod_user_group_id' => $rows[$i]['user_group_id'], 'mod_user_session_time' => $rows[$i]['user_session_time']);
//-- fin mod : Advanced Group Color Management ---------------------------------

			}
			else
			{
				$row = array('mod_type' => POST_GROUPS_URL, 'mod_id' => $rows[$i]['group_id'], 'mod_name' => $rows[$i]['group_name'], 'mod_system' => ($rows[$i]['group_status'] > GROUP_STANDARD));
			}
			$res[ $rows[$i]['obj_id'] ]['mod_list'][] = $row;
			unset($rows[$i]);
		}
		$rows = $res;
	}
}

class moderators
{
	var $data;
	var $data_time;
	var $data_flag;

	function moderators()
	{
		$this->data = array();
		$this->data_flag = false;
	}

	function read($force=false)
	{
		global $config;

		if ( !$force && $this->data_flag )
		{
			return;
		}

		$db_cached = new cache_moderators('dta_moderators', $config->data['cache_path'], $config->data['cache_disabled_mods']);
		$sql = 'SELECT a.obj_id, a.group_id, g.group_name, g.group_status, u.user_id, u.username, MAX(auth_value) AS auth_solved
					FROM ' . AUTHS_TABLE . ' a, ' . GROUPS_TABLE . ' g
						LEFT JOIN ' . USERS_TABLE . ' u ON g.group_single_user = ' . true . ' AND u.user_id = g.group_user_id
					WHERE a.obj_type = \'' . POST_FORUM_URL . '\'
						AND a.auth_name = \'auth_mod_display\'
						AND g.group_id = a.group_id
						AND g.group_type <> ' . GROUP_HIDDEN . '
					GROUP BY a.obj_id, a.group_id, g.group_name, g.group_status, u.user_id, u.username
					ORDER BY a.obj_id, u.username, g.group_name';
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		$sql = str_replace('SELECT ', 'SELECT u.user_group_id, u.user_session_time, ', $sql);
//-- fin mod : Advanced Group Color Management ---------------------------------

		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force);
		$this->data_flag = true;
		$this->data_time = $db_cached->data_time;
	}

	function set_users_status()
	{
		global $db, $config;

		// note : this one could be lighter, but fixes also remaining unjustified user status (phpBB bug)
		// we don't consider as moderators the system groups (registered & anonymous)

		// remove mod and admin level from users table
		$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_level = ' . USER . '
					WHERE user_level <> ' . USER;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// search for all admins and founder and set admin status
		$sql = 'SELECT DISTINCT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id IN(' . intval($config->data['group_founder']) . ', ' . intval($config->data['group_admin']) . ')
					GROUP BY user_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$user_ids = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$user_ids[ intval($row['user_id']) ] = true;
		}
		$db->sql_freeresult($result);

		// set admin level
		if ( !empty($user_ids) )
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_level = ' . ADMIN . '
						WHERE user_id IN (' . implode(', ', array_keys($user_ids)) . ')
							AND user_active = ' . true;
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// search for all moderators and set the status
		$sql = 'SELECT ug.user_id, a.obj_id, MAX(a.auth_value) AS auth_solved
					FROM ' . AUTHS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug
					WHERE a.obj_type = \'' . POST_FORUM_URL . '\'
						AND a.auth_name = \'auth_mod_display\'
						AND ug.user_pending <> ' . true . '
						AND ug.group_id = a.group_id
						AND ug.user_id NOT IN (0, ' . ANONYMOUS . ')
					GROUP BY ug.user_id, a.obj_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$user_ids = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( in_array($row['auth_solved'], array(1, FORCE)) )
			{
				$user_ids[ intval($row['user_id']) ] = true;
			}
		}
		$db->sql_freeresult($result);

		// set mod level
		if ( !empty($user_ids) )
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_level = ' . MOD . '
						WHERE user_level <> ' . ADMIN . '
							AND user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	function display($tpl_switch, $forum_id)
	{
		global $template, $config, $user;
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		global $colors;
//-- fin mod : Advanced Group Color Management ---------------------------------


		$this->read();
		$count_moderators = isset($this->data[$forum_id]) ? count($this->data[$forum_id]['mod_list']) : 0;
		$template->set_switch($tpl_switch, !empty($count_moderators));
		if ( !empty($count_moderators) )
		{
			$template->assign_vars(array(
				'L_MODERATORS' => $user->lang('Moderators'),
			));
			for ( $i = 0; $i < $count_moderators; $i++ )
			{
				$row = $this->data[$forum_id]['mod_list'][$i];
				$template->assign_block_vars($tpl_switch . '.mod', array(
					'U_MOD' => ($row['mod_type'] == POST_USERS_URL) ? $config->url('profile', array('mode' => 'viewprofile', $row['mod_type'] => $row['mod_id']), true) : $config->url('groupcp', array($row['mod_type'] => $row['mod_id']), true),
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	'L_MOD' => $row['mod_system'] ? $user->lang($row['mod_name']) : $row['mod_name'],
//-- add
					'L_MOD' => ($row['mod_type'] == POST_USERS_URL) ? $colors->get_user_color($row['mod_user_group_id'], $row['mod_user_session_time'], $row['mod_name']) : $colors->get_user_color($row['mod_id'], '0', ($row['mod_system'] ? $user->lang($row['mod_name']) : $row['mod_name'])),
//-- fin mod : Advanced Group Color Management ---------------------------------

					'L_MOD_TITLE' => ($row['mod_type'] == POST_USERS_URL) ? $user->lang('Read_profile') : $user->lang('View_group'),
					'L_SEP' => $i == ($count_moderators - 1) ? '' : ', ',
				));
				$template->set_switch($tpl_switch . '.mod.sep', $i < ($count_moderators - 1));
			}
		}
	}
}

?>