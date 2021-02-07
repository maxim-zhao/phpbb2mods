<?php
/***************************************************************************
 *							class_user.php
 *							--------------
 *	begin		: 26/08/2004
 *	copyright	: Ptirhiik
 *	email		: ptirhiik@clanmckeen.com
 *
 *	Version		: 0.0.16 - 31/10/2005
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

class user
{
	var $data;
	var $cache;
	var $cache_time;
	var $auths_def;
	var $auths_val;

	var $cookies;
	var $pool;

	function user()
	{
		$this->pool = array();
	}

	function read($user_id)
	{
		global $db, $lang;

		$this->data = array();
		if ( !empty($user_id) )
		{
			$sql = 'SELECT u.*, g.*
						FROM ' . USERS_TABLE . ' u
							LEFT JOIN ' . GROUPS_TABLE . ' g
								ON g.group_user_id = u.user_id
						WHERE u.user_id = ' . intval($user_id);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( !$this->data = $db->sql_fetchrow($result) )
			{
				$this->data = array();
			}
			else if ( $this->data['user_id'] == ANONYMOUS )
			{
				$this->data['username'] = empty($lang) ? 'Guest' : $lang['Guest'];
			}
		}
		if ( !empty($this->data) )
		{
			$this->get_groups_list();
		}
		$this->pool[ $this->data['user_id'] ] = array('username' => $row['username']);
	}

	function get_pool_fields()
	{
		return array(
			'username',
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			'user_group_id',
			'user_session_time',
//-- fin mod : Advanced Group Color Management ---------------------------------

		);
	}

	function read_pool(&$user_ids)
	{
		global $db;

		if ( !empty($user_ids) )
		{
			$sql = 'SELECT user_id, ' . implode(', ', $this->get_pool_fields()) . '
						FROM ' . USERS_TABLE . '
						WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$user_id = intval($row['user_id']);
				unset($row['user_id']);
				$this->pool[$user_id] = $row;
			}
			$db->sql_freeresult($result);
		}
		$user_ids = array();
	}

	function get_groups_list($force=false)
	{
		global $db;

		// force the group list to be updated
		$force |= empty($this->data['group_user_list']) || empty($this->data['group_user_id']) || empty($this->data['group_id']);

		// search for the individual user group
		if ( $force )
		{
			// get the individual group id
			$sql = 'SELECT ug.group_id
						FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
						WHERE ug.user_id = ' . intval($this->data['user_id']) . '
							AND g.group_id = ug.group_id
							AND g.group_single_user = ' . true;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$create = false;
			if ( $row = $db->sql_fetchrow($result) )
			{
				$this->data['group_id'] = intval($row['group_id']);
				$this->data['group_user_id'] = intval($this->data['user_id']);
				$fields = array(
					'group_user_id' => $this->data['group_user_id'],
				);
			}
			else
			{
				// no individual group : this should never occur !
				$create = true;

				// get a new group id
				$sql = 'SELECT group_id
							FROM ' . GROUPS_TABLE . '
							ORDER BY group_id DESC
							LIMIT 1';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$row = $db->sql_fetchrow($result);
				$this->data['group_id'] = intval($row['group_id']) + 1;
				$this->data['group_user_id'] = intval($this->data['user_id']);

				// create individual group
				$fields = array(
					'group_id' => $this->data['group_id'],
					'group_type' => GROUP_CLOSED,
					'group_name' => '',
					'group_description' => 'Personal User',
					'group_moderator' => 0,
					'group_single_user' => 1,
					'group_user_id' => $this->data['group_user_id'],
				);
			}

			// search for the user's membership
			$this->data['group_user_list'] = '';
			if ( $this->data['user_id'] == ANONYMOUS )
			{
				$this->data['group_user_list'] = ',' . GROUP_ANONYMOUS . ',';
			}
			else
			{
				$groups = array();
				$groups[GROUP_REGISTERED] = true;
				$groups[ intval($this->data['group_id']) ] = true;

				// search for regular groups
				$sql = 'SELECT group_id
							FROM ' . USER_GROUP_TABLE . '
							WHERE user_id = ' . intval($this->data['user_id']) . '
								AND group_id <> ' . intval($this->data['group_id']) . '
								AND user_pending <> ' . true . '
								ORDER BY group_id';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$groups[ intval($row['group_id']) ] = true;
				}
				if ( !empty($groups) )
				{
					$groups = array_keys($groups);
					$this->data['group_user_list'] = ',' . implode(',', $groups) . ',';
				}
			}

			// update the individual group (or create it if appropriate)
			$fields += array(
				'group_user_list' => $this->data['group_user_list'],
			);
			$db->sql_statement($fields);
			if ( $create )
			{
				$sql = 'INSERT INTO ' . GROUPS_TABLE . '
							(' . $db->sql_fields . ') VALUES (' . $db->sql_values . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
			else
			{
				$sql = 'UPDATE ' . GROUPS_TABLE . '
							SET ' . $db->sql_update . '
							WHERE group_id = ' . intval($this->data['group_id']);
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
		}

		return empty($this->data['group_user_list']) ? array() : explode(',', substr($this->data['group_user_list'], 1, strlen($this->data['group_user_list'])-2));
	}

	function join_groups($group_ids, $pending=true)
	{
		global $db, $config, $forums;

		if ( empty($group_ids) )
		{
			return;
		}
		if ( !is_array($group_ids) )
		{
			$group_ids = array($group_ids);
		}

		if ( !$pending )
		{
			// remove pending status
			$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
						WHERE group_id IN (' . implode(', ', $group_ids) . ')
							AND user_id = ' . intval($this->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// add to groups
		$db->sql_stack_reset();
		$count_group_ids = count($group_ids);
		for ( $i = 0; $i < $count_group_ids; $i++ )
		{
			$fields = array(
				'group_id' => intval($group_ids[$i]),
				'user_id' => intval($this->data['user_id']),
				'user_pending' => intval($pending),
			);
			$db->sql_stack_statement($fields);
		}
		$db->sql_stack_insert(USER_GROUP_TABLE, false, __LINE__, __FILE__);
	}

	function leave_groups($group_ids)
	{
		global $db, $config, $forums;

		if ( empty($group_ids) )
		{
			return;
		}
		if ( !is_array($group_ids) )
		{
			$group_ids = array($group_ids);
		}

		// remove links
		$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
					WHERE group_id IN (' . implode(', ', $group_ids) . ')
						AND user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	function recache_groups()
	{
		global $db, $config, $forums;

		// delete auths so they will be recreated the next page
		$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// recache group list
		$this->get_groups_list(true);

		// recache moderators
		include_once($config->url('includes/class_forums'));
		$moderators = new moderators();
		$moderators->set_users_status();
		$moderators->read(true);
	}

	function set()
	{
		global $db, $config, $userdata, $forums, $forum_id, $themes, $theme, $lang;

		if ( !empty($this->data) )
		{
			return;
		}

		$this->data = &$userdata;
		$this->cache = array();
		$this->cache_time = array();

		// anonymous individual group data are missing in some cases
		if ( !$this->data['session_logged_in'] && ($this->data['group_id'] != GROUP_ANONYMOUS) )
		{
			$sql = 'SELECT * FROM ' . GROUPS_TABLE . '
				WHERE group_id = ' . GROUP_ANONYMOUS;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( $row = $db->sql_fetchrow($result) )
			{
				$userdata = array_merge($this->data, $row);
			}
		}

		// default values
		if ( !$this->data['session_logged_in'] )
		{
			$this->overwrite_anonymous_values();
		}

		// get extended lang
		$this->get_extended_lang();

		// read styles
		$themes_exists = true;
		if ( empty($themes) )
		{
			$themes = new themes();
			$themes->read();
			$themes_exists = false;
		}

		// set forum specific template
		$user_style = empty($this->data['group_style']) ? $this->data['user_style'] : $this->data['group_style'];
		if ( defined('IN_ADMIN') || !$this->data['group_force_style'] )
		{
			if ( defined('IN_ADMIN') || $config->data['override_user_style'] || !$this->data['session_logged_in'] || !isset($themes->data[$user_style]) )
			{
				$user_style = $config->data['default_style'];
			}
			if ( !empty($forum_id) && !defined('IN_ADMIN') )
			{
				if ( empty($forums) )
				{
					include_once($config->url('includes/class_forums'));
					$forums = new forums();
					$forums->read();
				}
				if ( isset($forums->data[$forum_id]) && isset($themes->data[ intval($forums->data[$forum_id]['forum_style']) ]) )
				{
					$user_style = $forums->data[$forum_id]['forum_style'];
				}
			}
		}

		// check if the style exists
		if ( !isset($themes->data[$user_style]) && ($user_style != $config->data['default_style']) )
		{
			$user_style = $config->data['default_style'];
		}

		// read user or config style
		if ( !($theme = setup_style($user_style)) && ($user_style != $config->data['default_style']) )
		{
			$user_style = $config->data['default_style'];
			$theme = setup_style($user_style);
		}

		// delete themes
		if ( !$themes_exists )
		{
			unset($themes);
		}
	}

	function overwrite_anonymous_values()
	{
		global $config;

		$default_values = array(
			'user_dateformat' => 'default_dateformat',
			'user_timezone' => 'board_timezone',
			'user_dst' => 'board_dst',
			'user_style' => 'default_style',
			'user_lang' => 'default_lang',
		);
		foreach ( $default_values as $user_field => $config_field )
		{
			if ( isset($config->data[$config_field]) )
			{
				$this->data[$user_field] = $config->data[$config_field];
			}
		}
	}

	function get_extended_lang()
	{
		global $config, $lang;

		// switch for the admin part of lang_extend_*
		$lang_extend_admin = defined('IN_ADMIN');

		// get the dirs to process (english is default for all mods)
		$langs = array('english');

		// add default lang
		if ( $config->data['default_lang'] != 'english' )
		{
			$langs[] = $config->data['default_lang'];
		}
		// add user lang
		if ( !empty($this->data['user_lang']) && !in_array($this->data['user_lang'], $langs) )
		{
			$langs[] = $this->data['user_lang'];
		}

		// additional language file to load before the lang_extend_* ones
		$additionals = array_flip(array('lang_extend_phpbb'));

		// get all the langs
		$count_langs = count($langs);
		$count_additionals = count($additionals);
		for ( $i = 0; $i < $count_langs; $i++ )
		{
			if ( $dir = @opendir($config->root . 'language/lang_' . $langs[$i]) )
			{
				// include the fixes on phpBB main language files
				if ( !empty($additionals) )
				{
					foreach ( $additionals as $file => $dummy )
					{
						@include($config->url('language/lang_' . $langs[$i] . '/' . $file));
					}
				}

				// include other extensions
				while( $file = @readdir($dir) )
				{
					if ( preg_match('/^lang_extend_.*?\.' . $config->ext . '$/', $file) && !isset($additionals[ substr($file, 0, (strlen($file) - strlen($config->ext) - 1)) ]) )
					{
						include($config->root . 'language/lang_' . $langs[$i] . '/' . $file);
					}
				}
				@closedir($dir);

				// include the personalisations
				@include($config->url('language/lang_' . $langs[$i] . '/lang_extend'));
			}
		}

		// fix datetime lang array
		if ( !empty($lang['datetime']) )
		{
			foreach ( $lang['datetime'] as $key => $val )
			{
				$lang[$key] = $val;
			}
		}
	}

	function get_cache($cache_ids='')
	{
		global $db, $config;

		// init auth types required
		if ( empty($cache_ids) )
		{
			return;
		}
		if ( !is_array($cache_ids) )
		{
			$cache_ids = array($cache_ids);
		}
		$count_cache_ids = count($cache_ids);

		// get caches from user cache
		$sql_where = (count($cache_ids) > 1) ? 'cache_id IN(\'' . implode('\', \'', $cache_ids) . '\')' : 'cache_id = \'' . $cache_ids[0] . '\'';
		$sql = 'SELECT cache_id, cache_data, cache_time
					FROM ' . USERS_CACHE_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']) . '
						AND ' . $sql_where;
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( !empty($row['cache_time']) && ($row['cache_time'] >= max($config->data['cache_time_' . $row['cache_id'] ], $config->data['cache_time_' . POST_FORUM_URL ])) )
			{
				$this->cache[ $row['cache_id'] ] = unserialize(stripslashes($row['cache_data']));
				$this->cache_time[ $row['cache_id'] ] = $row['cache_time'];
			}
		}

		// caches to process
		$process = array();
		for ( $i = 0; $i < $count_cache_ids; $i++ )
		{
			if ( empty($this->cache_time[ $cache_ids[$i] ]) )
			{
				$process[] = $cache_ids[$i];
			}
		}

		// refresh required auth
		if ( !empty($process) )
		{
			$user_auths = new auth_class();
			$process = $user_auths->get($this, $process, $this->cache, $this->cache_time);

			// recache result
			$this->write_cache($process);
		}
	}

	function write_cache($cache_ids='')
	{
		global $db;

		if ( empty($cache_ids) )
		{
			return;
		}
		if ( !is_array($cache_ids) )
		{
			$cache_ids = array($cache_ids);
		}
		$count_cache_ids = count($cache_ids);

		// delete remaining caches
		$sql_where = ($count_cache_ids > 1) ? 'cache_id IN(\'' . implode('\', \'', $cache_ids) . '\')' : 'cache_id = \'' . $cache_ids[0] . '\'';
		$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']) . '
						AND ' . $sql_where;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// insert new values
		$db->sql_stack_reset();
		for ( $i = 0; $i < $count_cache_ids; $i++ )
		{
			$fields = array(
				'user_id' => $this->data['user_id'],
				'cache_id' => $cache_ids[$i],
				'cache_time' => $this->cache_time[ $cache_ids[$i] ],
				'cache_data' => serialize($this->cache[ $cache_ids[$i] ]),
			);
			$db->sql_stack_statement($fields);
		}
		$db->sql_stack_insert(USERS_CACHE_TABLE, false, __LINE__, __FILE__);
	}

	function cache($cache_id, &$data, $data_time=0)
	{
		global $db;

		$this->cache[$cache_id] = $data;
		$this->cache_time[$cache_id] = empty($data_time) ? time() : $data_time;
		$this->write_cache($cache_id);
	}

	function auth($auth_type, $auth_names, $obj_ids)
	{
		$is_main_admin = strpos(' ' . $this->data['group_user_list'], ',' . GROUP_FOUNDER . ',');

		// short way : founder can do everything everywhere
		if ( $is_main_admin && (($auth_type != POST_FORUM_URL) || ($auth_names != 'auth_mod_display')) )
		{
			return true;
		}

		// unknown auth type
		if ( !isset($this->cache[$auth_type]) || !isset($this->cache[$auth_type]['def']) || !isset($this->cache[$auth_type]['val']) )
		{
			return false;
		}

		// prepare arrays
		if ( !is_array($obj_ids) )
		{
			$obj_ids = array($obj_ids);
		}
		if ( !is_array($auth_names) )
		{
			$auth_names = array($auth_names);
		}

		// check auth for all auths asked and all objects asked
		// auth_idx : cache[auth_type]['def'][auth_name]
		// auth_value : cache[auth_type]['val'][obj_id][auth_idx]
		$count_auth_names = count($auth_names);
		$count_obj_ids = count($obj_ids);
		$auth_value = 0;
		for ( $i = 0; $i < $count_auth_names; $i++ )
		{
			if ( isset($this->cache[$auth_type]['def'][ $auth_names[$i] ]) )
			{
				for ( $j = 0; $j < $count_obj_ids; $j++ )
				{
					if ( isset($this->cache[$auth_type]['val'][ $obj_ids[$j] ]) )
					{
						$auth_value = max($auth_value, intval($this->cache[$auth_type]['val'][ $obj_ids[$j] ][ $this->cache[$auth_type]['def'][ $auth_names[$i] ] ]));
					}
				}
			}
		}
		return in_array($auth_value, array(1, FORCE));
	}

	function img($key)
	{
		global $images, $config;
		return !empty($key) && isset($images[$key]) ? $config->root . $images[$key] : (eregi('^(ht|f)tp:', $key) ? $key : (@file_exists(@phpbb_realpath($config->root . $key)) ? $config->root . $key : './' .$key));
	}

	function lang($key)
	{
		global $lang;
		return !empty($key) && isset($lang[$key]) ? $lang[$key] : $key;
	}

	// dst apply between the first sunday of April, 2 am, and last sunday of October, 1h59 am (http://www.nist.gov/public_affairs/faqs/qdaylite.htm)
	function dst_in_action($date)
	{
		static $years;

		$year = date('Y', $date);
		$month = date('m', $date);
		$day = date('d', $date);
		$hour = date('His', $date);
		if ( ($month == 04) || ($month == 10) )
		{
			// April
			if ( $month == 04 )
			{
				if ( isset($years[$year]) && isset($years[$year]['f']) )
				{
					$first_sunday = $years[$year]['f'];
				}
				else
				{
					$day_of_week = date('w', mktime(2, 0, 0, $month, 1, $year));
					$first_sunday = ($day_of_week == 0) ? 1 : 8 - $day_of_week;
					$years[$year]['f'] = $first_sunday;
				}
				return ($day == $first_sunday) ? ($hour >= 020000) : ($day > $first_sunday);
			}

			// October
			else
			{
				if ( isset($years[$year]) && isset($years[$year]['t']) )
				{
					$last_sunday = $years[$year]['t'];
				}
				else
				{
					$last_sunday = 31 - date('w', mktime(2, 0, 0, $month, 31, $year));
					$years[$year]['t'] = $last_sunday;
				}
				return ($day == $last_sunday) ? ($hour < 020000) : ($day < $last_sunday);
			}
		}
		else
		{
			return ($month > 04) && ($month < 10);
		}
	}

	// this one will convert a user timestamp to the system timestamp
	// it can be used to convert an inputed by the user timestamp into the time() generated by the system
	function cvt_user_to_sys_date($user_timestamp)
	{
		if ( empty($user_timestamp) )
		{
			return 0;
		}
		// remove user offset & add server offset
		$dst = $this->data['user_dst'] && $this->dst_in_action($user_timestamp) ? 1 : 0;
		$ii = explode(', ', date('H, i, s, m, d, Y', $user_timestamp - intval((doubleval($this->data['user_timezone']) + $dst) * 3600)));
		return @gmmktime($ii[0], $ii[1], $ii[2], $ii[3], $ii[4], $ii[5]);
	}

	// this one will convert a system timestamp to the user timestamp
	function cvt_sys_to_user_date($sys_timestamp)
	{
		if ( empty($sys_timestamp) )
		{
			return 0;
		}
		// remove server offset & add user offset
		$ii = explode(', ', $this->date($sys_timestamp, 'H, i, s, m, d, Y', false));
		return mktime($ii[0], $ii[1], $ii[2], $ii[3], $ii[4], $ii[5]);
	}

	function date($time=0, $fmt='', $today_yesterday=true)
	{
		global $config, $lang;

		// fix parms with default
		$fmt = empty($fmt) ? $this->data['user_dateformat'] : $fmt;
		$time = empty($time) ? time() : $time;

		// get user timezone & dst
		$time_zone = intval(doubleval($this->data['user_timezone']) * 3600);
		$dst = $this->data['user_dst'] && $this->dst_in_action($time) ? 1 : 0;
		$time_zone += $dst * 3600;

		// get date standard format
		$d_day = $time + $time_zone;
		$res = @gmdate($fmt, $d_day);

		// apply today/yesterday choice
		// this one was inspirated by Netclectic's mod "Today at/Yesterday at" : http://www.phpbb.com/phpBB/viewtopic.php?t=158812
		$smart_date = ($config->data['smart_date_over'] || empty($this->data['user_smart_date'])) ? intval($config->data['smart_date']) : (intval($this->data['user_smart_date']) != DENY);
		if ( $today_yesterday && $smart_date )
		{
			// get user current day
			$now = time() + $time_zone;
			$today = @gmmktime(0, 0, 0, @gmdate('m', $now), @gmdate('d', $now), @gmdate('Y', $now));

			// is the d day between user's yesterday and today ?
			if ( ($d_day >= $today - 86400) && ($d_day < $today + 86400) )
			{
				// get new fmt for time and compute
				$new_fmt = sprintf(strpos(' ' . $fmt, 'h') ? 'h%s a' : (strpos(' ' . $fmt, 'H') ? 'H%s' : (strpos(' '. $fmt, 'g') ? 'g%s a' : (strpos(' ' . $fmt, 'G') ? 'G%s' : ''))), strpos(' ' . $fmt, 's') ? ':i:s' : ':i');
				$res = empty($new_fmt) ? $this->lang(($d_day >= $today) ? 'Today' : 'Yesterday') : sprintf($this->lang(($d_day >= $today) ? 'Today_at': 'Yesterday_at'), @gmdate($new_fmt, $time + $time_zone));
			}
		}
		return strtr($res, $lang['datetime']);
	}

	function get_timezone()
	{
		global $lang;

		$dst_in_action = $this->data['user_dst'] && $this->dst_in_action(time() + intval(doubleval($this->data['user_timezone']) * 3600));
		$tz = doubleval($this->data['user_timezone']) + intval($dst_in_action);
		return sprintf($dst_in_action ? $this->lang('UTC_DST') : $this->lang('UTC'), $tz >= 0 ? '+' : '-', abs($tz));
	}

	function get_cookies_setup()
	{
		global $config;

		$keep_unreads = (intval($config->data['keep_unreads']) > 0) && (($this->data['user_keep_unreads'] != DENY) || $config->data['keep_unreads_over']);
		$keep_unreads_db = $keep_unreads && (intval($config->data['keep_unreads']) == KEEP_UNREAD_DB) && $this->data['session_logged_in'];

		// get the cookies basename per user_id if keep_unread sat
		$user_id = $this->data['session_logged_in'] ? $this->data['user_id'] : '_';
		$base_name = $config->data['cookie_name'] . ( $keep_unreads ? '_' . $user_id : '');

		return array(
			'keep_unreads' => $keep_unreads,
			'keep_unreads_db' => $keep_unreads_db,
			'base_name' => $base_name,
			'path' => $config->data['cookie_path'],
			'domain' => $config->data['cookie_domain'],
			'secure' => $config->data['cookie_secure'],
		);
	}

	function read_cookies($keep_forums=false)
	{
		global $db, $HTTP_COOKIE_VARS;

		// read cookies
		if ( isset($this->cookies) )
		{
			return;
		}

		// read setup
		$cookies_setup = $this->get_cookies_setup();
		foreach ( $cookies_setup as $var => $value )
		{
			$$var = $value;
		}

		// get default cookies
		$this->cookies = array(
			'f_all' => isset($HTTP_COOKIE_VARS[$base_name . '_f_all']) ? intval($HTTP_COOKIE_VARS[$base_name . '_f_all']) : 0,
			'forums' => isset($HTTP_COOKIE_VARS[$base_name . '_f']) ? unserialize($HTTP_COOKIE_VARS[$base_name . '_f']) : array(),
			'topics' => isset($HTTP_COOKIE_VARS[$base_name . '_t']) ? unserialize($HTTP_COOKIE_VARS[$base_name . '_t']) : array(),
		);

		$unreads = array();
		$last_extraction = $this->data['session_logged_in'] ? $this->data['user_lastvisit'] : time()-300;

		// 60 days limit
		if ( $reset = ($last_extraction < (time() - 5184000)) && $this->data['session_logged_in'] )
		{
			$last_extraction = time() - 5184000;
		}

		if ( $keep_unreads )
		{
			// get unreaded topic_ids and the extraction date
			if ( $keep_unreads_db )
			{
				$unreads = empty($this->data['user_unread_topics']) || $reset ? array() : unserialize($this->data['user_unread_topics']);
				if ( !empty($this->data['user_unread_date']) && !$reset )
				{
					$last_extraction = $this->data['user_unread_date'];
				}
			}
			else
			{
				$unreads = !$reset && isset($HTTP_COOKIE_VARS[$base_name . '_t_u']) ? unserialize($HTTP_COOKIE_VARS[$base_name . '_t_u']) : array();
				$date = intval($HTTP_COOKIE_VARS[$base_name . '_t_ud']);
				if ( !empty($date) && !$reset )
				{
					$last_extraction = $date;
				}
			}

			// re-add floor to topic_time for each topic_id
			$floor = 0;
			if ( !empty($unreads) )
			{
				$floor = intval($unreads[0]);
				unset($unreads[0]);
			}
			foreach( $unreads as $topic_id => $topic_time )
			{
				if ( intval($topic_id) > 0 )
				{
					$unreads[ intval($topic_id) ] = intval($topic_time) + $floor;
				}
				else
				{
					unset($unreads[$topic_id]);
				}
			}
		}
		else
		{
			// reclaim some memory
			if ( isset($this->data['user_unread_topics']) )
			{
				unset($this->data['user_unread_topics']);
			}
			$unreads = array();
		}

		$this->cookies['unreads'] = array();
		$this->cookies['unreads_date'] = time();
		$this->cookies['f_unreads'] = array();
		if ( $this->data['session_logged_in'] || $keep_unreads )
		{
			// get new unreaded topics
			$count_unreads = count($unreads);
			$sql = 'SELECT topic_id, topic_time, topic_last_time, forum_id
						FROM ' . TOPICS_TABLE . '
						WHERE topic_moved_id = 0
							AND ' . ($count_unreads ? '(' : '') . 'topic_last_time > ' . intval($last_extraction) .
								($count_unreads ? (($count_unreads > 1) ? ' OR topic_id IN(' . implode(', ', array_keys($unreads)) . ')' : ' OR topic_id = ' . _first_key($unreads)) . ')' : '');
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				// last time we've marked readed a forum or the topic
				$cooky_all = empty($this->cookies['f_all']) ? 0 : intval($this->cookies['f_all']);
				$cooky_f = empty($this->cookies['forums'][ $row['forum_id'] ]) ? 0 : intval($this->cookies['forums'][ $row['forum_id'] ]);
				$cooky_t = empty($this->cookies['topics'][ $row['topic_id'] ]) ? 0 : intval($this->cookies['topics'][ $row['topic_id'] ]);
				$last_topic_mark = max($cooky_all, $cooky_f, $cooky_t);

				// if we've marked the topics since the last unreaded extraction, it is no more unreaded
				if ( ($last_topic_mark > $last_extraction) && isset($unreads[ $row['topic_id'] ]) )
				{
					unset($unreads[ $row['topic_id'] ]);
				}

				// some post may have been deleted
				if ( !empty($unreads[ $row['topic_id'] ]) && ($row['topic_last_time'] < $unreads[ $row['topic_id'] ]) )
				{
					$unreads[ $row['topic_id'] ] = intval($row['topic_last_time']);
				}

				// let's try to get a last visit to the topic time
				$last_topic_visit = $last_topic_mark;

				// no mark yet : get the previous last visit time for this topic
				if ( empty($last_topic_visit) && !empty($unreads[ $row['topic_id'] ]) )
				{
					$last_topic_visit = intval($unreads[ $row['topic_id'] ]);
				}

				// no mark nor first visit : this is a bran new topic for us :)
				if ( empty($last_topic_visit) )
				{
					$last_topic_visit = intval($last_extraction);
				}

				// does the topic has moved since the last time we've visited it ?
				if ( $row['topic_last_time'] > $last_topic_visit )
				{
					$this->cookies['unreads'][ $row['topic_id'] ] = $last_topic_visit;
					$this->cookies['f_unreads'][ $row['forum_id'] ] = true;

					// clean if present the topic level cookie mark
					if ( isset($this->cookies['topics'][ $row['topic_id'] ]) )
					{
						unset($this->cookies['topics'][ $row['topic_id'] ]);
					}

					// we need to keep the forum where stand the unreaded topics
					if ( $keep_forums )
					{
						$this->cookies['unreads_per_forums'][ $row['forum_id'] ][] = $row['topic_id'];
					}
				}
			}
		}
	}

	function write_cookies($cookies_asked='')
	{
		global $db;

		// cookies not readed : read them
		if ( !isset($this->cookies) )
		{
			$this->read_cookies();
		}

		// make an array with the cookies asked
		if ( empty($cookies_asked) )
		{
			$cookies_asked = array_keys($this->cookies);
		}
		if ( !is_array($cookies_asked) )
		{
			$cookies_asked = array($cookies_asked);
		}

		// read setup
		$cookies_setup = $this->get_cookies_setup();
		foreach ( $cookies_setup as $var => $value )
		{
			$$var = $value;
		}
		$one_year = time() + 31536000;

		// store cookies
		$count_cookies_asked = count($cookies_asked);
		for ( $i = 0; $i < $count_cookies_asked; $i++ )
		{
			$cookie = $cookies_asked[$i];
			switch ( $cookie )
			{
				// default phpBB cookies : cookies duration : session
				case 'f_all':
					setcookie($base_name . '_f_all', intval($this->cookies[$cookie]), 0, $path, $domain, $secure);
					break;
				case 'forums':
					setcookie($base_name . '_f', serialize($this->cookies[$cookie]), 0, $path, $domain, $secure);
					break;
				case 'topics':
					// sort the topics by lower time first
					$count_cookies = count($this->cookies[$cookie]);
					if ( $count_cookies )
					{
						asort($this->cookies[$cookie]);
					}
					// limit the number of topics to 150
					while ( ($count_cookies > 150) && (list($topic_id, $topic_time) = each($this->cookies[$cookie])) )
					{
						unset($this->cookies[$cookie][$topic_id]);
						$count_cookies--;
					}
					// cookie duration : session
					setcookie($base_name . '_t', serialize($this->cookies[$cookie]), 0, $path, $domain, $secure);
					break;

				// unreaded topics : cookie duration : one year
				case 'unreads':
					if ( $keep_unreads )
					{
						// sort the topics by lower time first
						$count_cookies = count($this->cookies[$cookie]);
						if ( $count_cookies )
						{
							asort($this->cookies[$cookie]);
						}
						// limit the number of topics to 300
						while ( ($count_cookies > 300) && (list($topic_id, $topic_time) = each($this->cookies[$cookie])) )
						{
							unset($this->cookies[$cookie][$topic_id]);
							$count_cookies--;
						}

						// substract the lower time to reduce the cookie size
						$floor = 0;
						if ( $count_cookies )
						{
							$floor = $this->cookies[$cookie][ _first_key($this->cookies[$cookie]) ];
							foreach ( $this->cookies[$cookie] as $topic_id => $topic_time )
							{
								$this->cookies[$cookie][$topic_id] -= $floor;
							}
							$this->cookies[$cookie][0] = $floor;
						}

						// finaly, output the value
						if ( $keep_unreads_db )
						{
							// update users table
							$sql = 'UPDATE ' . USERS_TABLE . '
										SET user_unread_topics = ' . ($floor ? '\'' . serialize($this->cookies[$cookie]) . '\'' : '\'\'') . ',
											user_unread_date = ' . intval($this->cookies['unreads_date']) . '
										WHERE user_id = ' . intval($this->data['user_id']);
							$db->sql_query($sql, false, __LINE__, __FILE__);
						}
						else
						{
							setcookie($base_name . '_t_u', serialize(($floor ? $this->cookies['unreads'] : array())), $one_year, $path, $domain, $secure);
							setcookie($base_name . '_t_ud', intval($this->cookies['unreads_date']), $one_year, $path, $domain, $secure);
						}
					}
					break;
				default:
					break;
			}
		}
	}

	function delete()
	{
		global $db, $config, $forums;

		// do not allow anonymous, founder or admin users to be deleted
		$group_user_list = $this->get_groups_list();
		$group_user_list = empty($group_user_list) ? array() : array_flip($group_user_list);
		if ( isset($group_user_list[GROUP_FOUNDER]) || isset($group_user_list[GROUP_ADMIN]) || isset($group_user_list[GROUP_ANONYMOUS]) )
		{
			return false;
		}
		unset($group_user_list);

		// get a group founder member (first will be fine)
		$sql = 'SELECT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id = ' . intval(GROUP_FOUNDER) . '
						AND user_pending <> ' . true . '
						AND user_id <> ' . intval($this->data['user_id']) . '
					ORDER BY user_id
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$user_founder = intval($row['user_id']);
		if ( empty($user_founder) )
		{
			return false;
		}

		// posts
		$fields = array(
			'poster_id' => DELETED,
			'post_username' => $this->data['username'],
		);
		$db->sql_statement($fields);
		$sql = 'UPDATE ' . POSTS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE poster_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// topics : first post
		$fields = array(
			'topic_poster' => DELETED,
			'topic_first_username' => $this->data['username'],
		);
		$db->sql_statement($fields);
		$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE topic_poster = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// topics : last post
		$fields = array(
			'topic_last_poster' => DELETED,
			'topic_last_username' => $this->data['username'],
		);
		$db->sql_statement($fields);
		$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE topic_last_poster = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// votes table
		$fields = array(
			'vote_user_id' => DELETED,
		);
		$db->sql_statement($fields);
		$sql = 'UPDATE ' . VOTE_USERS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE vote_user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// watch table
		$sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// forums table
		$fields = array(
			'forum_last_poster' => DELETED,
			'forum_last_username' => $this->data['username'],
		);
		$db->sql_statement($fields);
		$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE forum_last_poster = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// ban list
		$sql = 'DELETE FROM ' . BANLIST_TABLE . '
					WHERE ban_userid = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// private messages
		$sql = 'SELECT privmsgs_id
					FROM ' . PRIVMSGS_TABLE . '
					WHERE privmsgs_from_userid = ' . intval($this->data['user_id']) . '
						OR privmsgs_to_userid = ' . intval($this->data['user_id']) . '
					ORDER BY privmsgs_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$privmsgs_ids = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$privmsgs_ids[] = intval($row['privmsgs_id']);
		}
		$db->sql_freeresult($result);
		if ( !empty($privmsgs_ids) )
		{
			// private message texts
			$sql = 'DELETE FROM ' . PRIVMSGS_TEXT_TABLE . '
						WHERE privmsgs_text_id IN(' . implode(', ', $privmsgs_ids) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			unset($privmsgs_ids);

			// private message headers
			$sql = 'DELETE FROM ' . PRIVMSGS_TABLE . '
						WHERE privmsgs_from_userid = ' . intval($this->data['user_id']) . '
							OR privmsgs_to_userid = ' . intval($this->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// get all the personnal user groups
		$owned_group_ids = array();

		// individual
		if ( !empty($this->data['group_id']) )
		{
			$owned_group_ids[] = intval($this->data['group_id']);
		}

		// friends
		if ( !empty($this->data['group_friends_id']) )
		{
			$owned_group_ids[] = intval($this->data['group_friends_id']);
		}

		// foes
		if ( !empty($this->data['group_foes_id']) )
		{
			$owned_group_ids[] = intval($this->data['group_foes_id']);
		}

		// delete memberships
		$sql_where = empty($owned_group_ids) ? '' : ' OR group_id IN(' . implode(', ', $owned_group_ids) . ')';
		$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']) . $sql_where;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// delete groups
		if ( !empty($owned_group_ids) )
		{
			// delete groups owned by this user (own, friends and foes)
			$sql = 'DELETE FROM ' . GROUPS_TABLE . '
						WHERE group_id IN(' . implode(', ', $owned_group_ids) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// remove from users groups list the groups deleted
			$sql_where = 'group_user_list LIKE \'%,' . implode(',%\' OR group_user_list LIKE \'%,', $owned_group_ids) . ',%\'';
			$sql = 'SELECT group_user_id, group_id, group_user_list
						FROM ' . GROUPS_TABLE . '
						WHERE group_single_user = ' . true . '
							AND group_user_id <> ' . intval($this->data['user_id']) . '
							AND (' . $sql_where . ')';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$count_owned_group_ids = count($owned_group_ids);
			$user_ids = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				// keep in memory the updated users
				$user_ids[] = intval($row['group_user_id']);

				// remove the groups from the list
				$group_user_list = array_flip(explode(',', substr($row['group_user_list'], 1, strlen($row['group_user_list']) - 2)));
				for ( $i = 0; $i < $count_owned_group_ids; $i++ )
				{
					if ( isset($group_user_list[ $owned_group_ids[$i] ]) )
					{
						unset($group_user_list[ $owned_group_ids[$i] ]);
					}
				}

				// update the list
				$fields = array(
					'group_user_list' => empty($group_user_list) ? '' : ',' . implode(',', array_keys($group_user_list)) . ',',
				);
				$db->sql_statement($fields);
				$sql = 'UPDATE ' . GROUPS_TABLE . '
							SET ' . $db->sql_update . '
							WHERE group_id = ' . intval($row['group_id']);
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			// recache the touched users
			if ( !empty($user_ids) )
			{
				$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
							WHERE user_id IN(' . implode(', ', $user_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
		}

		// replace the group moderators
		$fields = array(
			'group_moderator' => intval($user_founder),
		);
		$db->sql_statement($fields);
		$sql = 'UPDATE ' . GROUPS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE group_moderator = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// delete auths
		$sql = 'DELETE FROM ' . AUTHS_TABLE . '
					WHERE group_id IN(' . implode(', ', $owned_group_ids) . ')
						OR (obj_type = \'' . POST_GROUPS_URL . '\'
							AND obj_id IN(' . implode(', ', $owned_group_ids) . '))';
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// finaly, delete the user
		$sql = 'DELETE FROM ' . USERS_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// recache the last user stats
		$this->read_stats(true);

		// recache moderators
		if ( empty($forums) || !is_object($forums) )
		{
			include_once($config->url('includes/class_forums'));
		}
		$moderators = new moderators();
		$moderators->read(true);

		return true;
	}

	function read_stats($force=true)
	{
		global $config, $db;

		if ( $force || empty($config->data['stat_last_user']) )
		{
			// update last user stats
			$sql = 'SELECT user_id, username
						FROM ' . USERS_TABLE . '
						WHERE user_id <> ' . ANONYMOUS . '
						ORDER BY user_id DESC';
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$sql = str_replace('SELECT ', 'SELECT user_group_id, ', $sql);
//-- fin mod : Advanced Group Color Management ---------------------------------

			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$config->set('stat_total_users', intval($db->sql_numrows($result)));
			$row = $db->sql_fetchrow($result);
			$config->set('stat_last_user', intval($row['user_id']));
			$config->set('stat_last_username', $row['username']);
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$config->set('stat_last_user_group_id', $row['user_group_id']);
//-- fin mod : Advanced Group Color Management ---------------------------------

		}
//-- mod : Advanced Group Color Management -------------------------------------
//-- here we added
//	, 'user_group_id' => $config->data['stat_last_user_group_id']
//-- modify

		return array('user_id' => intval($config->data['stat_last_user']), 'username' => $config->data['stat_last_username'], 'user_group_id' => $config->data['stat_last_user_group_id']);
//-- fin mod : Advanced Group Color Management ---------------------------------

	}
}

?>