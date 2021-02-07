<?php
/***************************************************************************
 *							class_stats.php
 *							---------------
 *	begin		: 03/09/2004
 *	copyright	: Ptirhiik
 *	email		: ptirhiik@clanmckeen.com
 *
 *	Version		: 0.0.11 - 31/10/2005
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

class user_stats extends user
{
	function get_pool_fields()
	{
		return array_keys(array_flip(parent::get_pool_fields()) + array_flip(array(
			'user_allow_viewonline',
			'user_level',
			'user_session_time',
			'user_session_logged',
		)));
	}
}

class stats
{
	// constructor
	function stats()
	{
		global $config;

		if ( !isset($config->data['stats_display_past']) )
		{
			$config->set('stats_display_past', true, true);
		}
		$this->init();
	}

	// user levels defs
	function get_user_levels()
	{
		global $theme;

		return array(
			ADMIN => array('legend' => 'Administrator', 'style' => ' style="color:#' . $theme['fontcolor3'] . '; font-weight: bold;"', 'link_pgm' => 'memberlist', 'link_parms' => array('level' => ADMIN)),
			MOD => array('legend' => 'Moderator', 'style' => ' style="color:#' . $theme['fontcolor2'] . '; font-weight: bold;"', 'link_pgm' => 'memberlist', 'link_parms' => array('level' => MOD)),
			USER => array('legend' => 'User', 'style' => '', 'link_pgm' => 'memberlist', 'link_parms' => ''),
		);
	}

	function init()
	{
		global $config, $user, $sys_updated_session;

		// check if we are on an updated session, or a new guest one
		if ( empty($sys_updated_session) && !$user->data['session_logged_in'] )
		{
			// get stats
			$now = mktime(date('H'), 0, 0, date('m'), date('d'), date('Y'));
			$last = empty($config->data['stats_gcount_hour']) ? 0 : mktime(date('H', intval($config->data['stats_gcount_hour'])), 0, 0, date('m', intval($config->data['stats_gcount_hour'])), date('d', intval($config->data['stats_gcount_hour'])), date('Y', intval($config->data['stats_gcount_hour'])));
			$cur_hour = date('H', $now);

			// short way : we are still in the same hour than the last hit
			if ( $now == $last )
			{
				$config->set('stats_gcount_h' . $cur_hour, intval($config->data['stats_gcount_h' . $cur_hour]) + 1);
			}
			else
			{
				$config->begin_transaction();

				// more than one day has passed since the last hit: reset all
				if ( ($now - $last + 1) > 86400 )
				{
					$config->set('stats_gcount_h' . $cur_hour, 1);
					for ( $i = 0; $i < 24; $i++ )
					{
						if ( $i != $cur_hour )
						{
							$config->set(sprintf('stats_gcount_h%02d', $i), 0);
						}
					}
				}
				// less than one day has passed since the last hit : reset missed hours
				else
				{
					// jump to the hour following the last hit, till we reach the current one
					$last += 3600;
					while ( $last < $now )
					{
						$config->set('stats_gcount_h' . date('H', $last), 0);
						$last += 3600;
					}

					// reset the current hour
					$config->set('stats_gcount_h' . $cur_hour, 1);
				}

				// update last time hit
				$config->set('stats_gcount_hour', $now);
				$config->end_transaction();
			}
		}
	}

	function get_past_guests($now=0, $only_last_hour=false)
	{
		global $config;

		if ( empty($now) )
		{
			$now = time();
		}

		// get times
		$guests_now = mktime(date('H', $now), 0, 0, date('m', $now), date('d', $now), date('Y', $now));
		$guests_last = empty($config->data['stats_gcount_hour']) ? 0 : mktime(date('H', intval($config->data['stats_gcount_hour'])), 0, 0, date('m', intval($config->data['stats_gcount_hour'])), date('d', intval($config->data['stats_gcount_hour'])), date('Y', intval($config->data['stats_gcount_hour'])));

		// only the last hour asked
		if ( $only_last_hour )
		{
			return ($guests_now == $guests_last) ? intval($config->data['stats_gcount_h' . date('H', $now)]) : 0;
		}

		// less than one day has passed since the last guest hit
		$res = 0;
		if ( ($guests_now - $guests_last + 1) <= 86400 )
		{
			$hlast = intval(date('H', $guests_last));
			$hnow = intval(date('H', $guests_now));
			for ( $i = 0; $i < 24; $i++ )
			{
				// don't count missed hours
				if ( (($hlast <= $hnow) && (($i <= $hlast) || ($i > $hnow))) || (($hlast > $hnow) && (($i >= $hlast) || ($i < $hnow))) )
				{
					$res += intval($config->data[ sprintf('stats_gcount_h%02d', $i) ]);
				}
			}
		}
		return $res;
	}

	function resync()
	{
		global $db, $config;

		// as session table is regulary cleaned from outdated guest sessions, the resync is not accurate
		// it is only done for the first synchronization

		// get timerange : 24h for forum_id=0, else 5 minutes
		$now = mktime(date('H'), 0, 0, date('m'), date('d'), date('Y'));
		$selected_timerange = 86400; // 24 hours

		// count guests
		$sql = 'SELECT session_time
					FROM ' . SESSIONS_TABLE . '
					WHERE session_user_id = ' . ANONYMOUS . '
						AND session_time > ' . ($now - $selected_timerange + 1);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$hours = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( !isset($hours[ intval(date('H', $row['session_time'])) ]) )
			{
				$hours[ intval(date('H', $row['session_time'])) ] = 1;
			}
			else
			{
				$hours[ intval(date('H', $row['session_time'])) ]++; 
			}
		}

		// update config
		$config->begin_transaction();
		for ( $i = 0; $i < 24; $i++ )
		{
			$config->set(sprintf('stats_gcount_h%02d', $i), intval($hours[$i]));
		}
		$config->set('stats_gcount_hour', $now);
		$config->end_transaction();
	}

	function display($forum_id)
	{
		global $db, $config, $template, $user;
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
		global $colors;
//-- fin mod : Advanced Group Color Management ---------------------------------

		// config value : stats_display_past : true/false : display past stats

		// limit the lists
		$max_in_list = 50;
		$all_past = empty($max_in_list) || _read('see', TYPE_NO_HTML) == 'allpast';
		$all_online = empty($max_in_list) || _read('see', TYPE_NO_HTML) == 'all';

		// users levels defs
		$user_levels = $this->get_user_levels();

		// get timerange : 24h for forum_id=0, else 5 minutes
		$now = time();
		$online_timerange = 300;

		// adjust timerange on the begining of the hour
		if ( $config->data['stats_display_past'] )
		{
			$current_hour = mktime(date('H', $now), 0, 0, date('m', $now), date('d', $now), date('Y', $now));
			$hour_timerange = $now - $current_hour;
			$yesterday = mktime(date('H', $now) + 1, 0, 0, date('m', $now), date('d', $now) - 1, date('Y', $now));
			$selected_timerange = $now - $yesterday; // 23 plain hours + the current one
		}
		else
		{
			$hour_timerange = $online_timerange;
			$selected_timerange = $online_timerange;
		}

		// get number of guest during the last 5 minutes
		$sql_where = empty($forum_id) ? '' : ' AND session_page = ' . intval($forum_id);
		$sql = 'SELECT DISTINCT session_ip
					FROM ' . SESSIONS_TABLE . '
					WHERE session_user_id = ' . ANONYMOUS . '
						AND session_time >= ' . ($now- $online_timerange) . $sql_where . '
					GROUP BY session_ip';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$nb_guests = $db->sql_numrows($result);
		$db->sql_freeresult($result);

		// get number of past & hours guests
		$nb_past_guests = (empty($forum_id) && $config->data['stats_display_past']) ? $this->get_past_guests($now) : 0;
		$nb_hour_guests = (empty($forum_id) && $config->data['stats_display_past']) ? $this->get_past_guests($now, true) : 0;

		// get user fields
		$user_stats = new user_stats();
		$user_fields = $user_stats->get_pool_fields();
		unset($user_stats);

		// build the main request to read registered users
		$sql_where = empty($forum_id) ? 'user_session_time >= ' . ($now - $selected_timerange) : 'user_session_time >= ' . ($now - $online_timerange) . ' AND user_session_page = ' . intval($forum_id);
		$sql = 'SELECT user_id, ' . implode(', ', $user_fields) . '
					FROM ' . USERS_TABLE . '
					WHERE user_id <> ' . ANONYMOUS . '
						AND ' . $sql_where . '
					ORDER BY username';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);

		// start the display
		$template->set_switch('stats');
		$template->set_switch('stats.root', empty($forum_id));
		if ( empty($forum_id) )
		{
			$template->set_switch('stats.root.extended');
		}
		else
		{
			$template->set_switch('stats.root_ELSE.extended');
		}

		// prepare count
		$count_online = $count_past = $nb_visible = $nb_hiddens = $nb_past_reg = $nb_past_hiddens = $nb_hour_reg = $nb_hour_hiddens = 0;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$ok = false;
			if ( $row['user_session_time'] >= ($now - $online_timerange) && $row['user_session_logged'] )
			{
				$ok = true;
				if ( $row['user_allow_viewonline'] )
				{
					$nb_visibles++;
				}
				else
				{
					$nb_hiddens++;
				}
			}
			if ( $config->data['stats_display_past'] )
			{
				if ( $row['user_session_time'] >= ($now - $hour_timerange) )
				{
					$ok = true;
					if ( $row['user_allow_viewonline'] )
					{
						$nb_hour_reg++;
					}
					else
					{
						$nb_hour_hiddens++;
					}
				}
				if ( $row['user_session_time'] >= ($now - $selected_timerange) )
				{
					$ok = true;
					if ( $row['user_allow_viewonline'] )
					{
						$nb_past_reg++;
					}
					else
					{
						$nb_past_hiddens++;
					}
				}
			}
			if ( $ok )
			{
				if ( $row['user_allow_viewonline'] || ($row['user_id'] == $user->data['user_id']) || ($user->data['user_level'] == ADMIN) || (($row['user_level'] != ADMIN) && $user->auth(POST_FORUM_URL, 'auth_mod', $forum_id)) )
				{
					if ( ($config->data['stats_display_past'] && (($count_past < $max_in_list) || $all_past)) || ($count_online < $max_in_list) || $all_online )
					{
						$tpl_data = array(
							'U_VIEW_PROFILE' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true),
							'USERNAME' => sprintf(($row['user_allow_viewonline'] ? '%s' : '<i>%s</i>'), $row['username']),
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	'STYLE' => isset($user_levels[ $row['user_level'] ]) ? $user_levels[ $row['user_level'] ]['style'] : $user_levels[USER]['style'],
//-- add
							'STYLE' => ' style="color : #' . $colors->get_user_color($row['user_group_id'], $row['user_session_time']) . ';" class="username_color"',
//-- fin mod : Advanced Group Color Management ---------------------------------
						);
					}

					// online
					if ( $row['user_session_time'] >= ($now - $online_timerange) && $row['user_session_logged'] )
					{
						if ( ($count_online < $max_in_list) || $all_online )
						{
							$template->assign_block_vars('stats.online', $tpl_data + array(
								'L_SEP' => empty($count_online) ? '' : ', ',
							));
							$template->set_switch('stats.online.sep', !empty($count_online));
						}
						else if ( $count_online == $max_in_list )
						{
							$tpl_more = array(
								'U_VIEW_PROFILE' => $config->url('index', array('see' => 'all', POST_FORUM_URL => intval($forum_id)), true),
								'USERNAME' => '...',
							);
							$template->assign_block_vars('stats.online', $tpl_more + array(
								'L_SEP' => empty($count_online) ? '' : ', ',
							));
							$template->set_switch('stats.online.sep', !empty($count_online));
						}
						$count_online++;
					}

					if ( $config->data['stats_display_past'] && empty($forum_id) )
					{
						if ( empty($count_past) )
						{
							$template->set_switch('stats.past');
						}
						if ( ($count_past < $max_in_list) || $all_past )
						{
							$template->assign_block_vars('stats.past.online', $tpl_data + array(
								'L_SEP' => empty($count_past) ? '' : ', ',
							));
							$template->set_switch('stats.past.online.sep', !empty($count_past));
						}
						else if ( $count_past == $max_in_list )
						{
							$tpl_more = array(
								'U_VIEW_PROFILE' => $config->url('index', array('see' => 'allpast', POST_FORUM_URL => intval($forum_id)), true),
								'USERNAME' => '...',
							);
							$template->assign_block_vars('stats.past.online', $tpl_more + array(
								'L_SEP' => empty($count_past) ? '' : ', ',
							));
							$template->set_switch('stats.past.online.sep', !empty($count_past));
						}
						$count_past++;
					}
				}
			}
		}

		// update board stats
		$nb_onlines = $nb_guests + $nb_hiddens + $nb_visibles;
		if ( $nb_onlines > $config->data['record_online_users'] )
		{
			$config->begin_transaction();
			$config->set('record_online_users', $nb_onlines);
			$config->set('record_online_date', $now);
			$config->end_transaction();
		}

		// display legend
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	foreach ( $user_levels as $user_level => $level_data )
//	{
//		if ( !empty($level_data['legend']) )
//		{
//			$template->assign_block_vars('stats.legend', array(
//				'U_LEVEL' => empty($level_data['link_pgm']) ? '' : $config->url($level_data['link_pgm'], $level_data['link_parms'], true),
//				'LEVEL_NAME' => $user->lang($level_data['legend']),
//				'STYLE' => $level_data['style'],
//			));
//			$template->set_switch('stats.legend.link', !empty($level_data['link_pgm']));
//		}
//	}
//-- add
		$colors->display_legend();
//-- fin mod : Advanced Group Color Management ---------------------------------

		// count users
		$currently_online = 
			sprintf($user->lang(($nb_visibles == 0) ? 'Reg_users_zero_total' : (($nb_visibles == 1) ? 'Reg_user_total' : 'Reg_users_total')), $nb_visibles) .
			sprintf($user->lang(($nb_hiddens == 0) ? 'Hidden_users_zero_total' : (($nb_hiddens == 1) ? 'Hidden_user_total' : 'Hidden_users_total')), $nb_hiddens) .
			sprintf($user->lang(($nb_guests == 0) ? 'Guest_users_zero_total' : (($nb_guests == 1) ? 'Guest_user_total' : 'Guest_users_total')), $nb_guests);

		// users stats
		if ( empty($forum_id) )
		{
			// posts/topics stats
			$l_articles = sprintf($user->lang(($config->data['stat_total_posts'] == 0) ? 'Posted_articles_zero_total' : (($config->data['stat_total_posts'] == 1) ? 'Posted_articles_total' : 'Posted_articles_total')), $config->data['stat_total_posts']);

			// total and last user stats
			if ( empty($config->data['stat_total_users']) )
			{
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
			$total_users = intval($config->data['stat_total_users']);
			$last_user_id = intval($config->data['stat_last_user']);
			$last_username = $config->data['stat_last_username'];
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$last_user_group_id = $config->data['stat_last_user_group_id'];
			$last_user_color = ' style="color : #' . $colors->get_user_color($last_user_group_id, '0') . ';" class="username_color"';
//-- fin mod : Advanced Group Color Management ---------------------------------
			$l_total_users = sprintf($user->lang(($total_users == 0) ? 'Registered_users_zero_total' : (($total_users == 1 ? 'Registered_user_total' : 'Registered_users_total')), $total_users);
//-- mod : Advanced Group Color Management -------------------------------------
//-- here we replaced
//	$user_levels[USER]['style']
//-- with
//	$last_user_color
//-- modify
			$l_newest_user = empty($total_users) ? '' : sprintf($user->lang('Newest_user'), '<a href="' . $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $last_user_id), true) . '"' . $last_user_color . ' title="' . $user->lang('Read_profile') . '">', $last_username, '</a>');
//-- fin mod : Advanced Group Color Management ---------------------------------
			$most_ever_online = sprintf($user->lang('Record_online_users'), $config->data['record_online_users'], $user->date($config->data['record_online_date']));

			// online count
			$l_total_online = sprintf($user->lang(($nb_onlines == 0) ? 'Online_users_zero_total' : (($nb_onlines == 1) ? 'Online_user_total' : 'Online_users_total')), $nb_onlines);

			// send to template
			$template->assign_vars(array(
				'TOTAL_POSTS' => $l_articles,
				'TOTAL_USERS' => $l_total_users,
				'NEWEST_USER' => $l_newest_user,
				'RECORD_USERS' => $most_ever_online,
				'L_TOTAL_ONLINE' => $l_total_online,
			));

			// past count
			if ( $config->data['stats_display_past'] && !empty($count_past) )
			{
				// historic past users online counts stats
				$hour_online =
					sprintf($user->lang(($nb_hour_reg == 0) ? 'Reg_users_zero_total' : (($nb_hour_reg == 1) ? 'Reg_user_total' : 'Reg_users_total')), $nb_hour_reg) .
					sprintf($user->lang(($nb_hour_hiddens == 0) ? 'Hidden_users_zero_total' : (($nb_hour_hiddens == 1) ? 'Hidden_user_total' : 'Hidden_users_total')), $nb_hour_hiddens) .
					sprintf($user->lang(($nb_hour_guests == 0) ? 'Guest_users_zero_total' : (($nb_hour_guests == 1) ? 'Guest_user_total' : 'Guest_users_total')), $nb_hour_guests);
				$past_online =
					sprintf($user->lang(($nb_past_reg == 0) ? 'Reg_users_zero_total' : (($nb_past_reg == 1) ? 'Reg_user_total' : 'Reg_users_total')), $nb_past_reg) .
					sprintf($user->lang(($nb_past_hiddens == 0) ? 'Hidden_users_zero_total' : (($nb_past_hiddens == 1) ? 'Hidden_user_total' : 'Hidden_users_total')), $nb_past_hiddens) .
					sprintf($user->lang(($nb_past_guests == 0) ? 'Guest_users_zero_total' : (($nb_past_guests == 1) ? 'Guest_user_total' : 'Guest_users_total')), $nb_past_guests);

				$nb_past_total = $nb_past_guests + $nb_past_reg + $nb_past_hiddens;
				$nb_hour_total = $nb_hour_guests + $nb_hour_reg + $nb_hour_hiddens;
				$l_total_past = sprintf($user->lang(($nb_past_total == 0) ? 'Past_users_zero_total' : (($nb_past_total == 1) ? 'Past_user_total' : 'Past_users_total')), $nb_past_total);
				$l_total_hour = sprintf($user->lang(($nb_hour_total == 0) ? 'Hour_users_zero_total' : (($nb_hour_total == 1) ? 'Hour_user_total' : 'Hour_users_total')), $nb_hour_total);

				// send to template
				$template->assign_vars(array(
					'L_TOTAL_PAST' => $l_total_past,
					'TOTAL_PAST_USERS' => $past_online,
					'TOTAL_HOUR_USERS' => sprintf($user->lang('Hour_visits'), $hour_online),
				));
				$template->set_switch('stats.past.none', empty($count_past));
			}
		}

		// constants
		$template->assign_vars(array(
			'U_VIEWONLINE' => $config->url('viewonline', '', true),
			'L_VIEWONLINE' => $user->lang('Who_is_Online'),
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			'L_GROUP_LEGEND' => $user->lang('AGCM_legend'),
//-- fin mod : Advanced Group Color Management ---------------------------------
			'I_VIEWONLINE' => $user->img('whosonline'),
			'I_SPACER' => $user->img('spacer'),

			'L_LEGEND' => $user->lang('Legend'),

			'NO_USERS_ONLINE' => $user->lang('None'),
			'L_VIEW_PROFILE' => $user->lang('Read_profile'),
			'TOTAL_USERS_ONLINE' => $currently_online,
			'L_ONLINE_USERS' => empty($forum_id) ? $user->lang('Registered_users') : $user->lang('Browsing_forum'),
			'L_ONLINE_EXPLAIN' => $user->lang('Online_explain'), // data based on users active ...
		));

		// nobody's online
		$template->set_switch('stats.none', empty($count_online));
		$template->set_filenames(array('stats_box' => 'index_stats_box.tpl'));
		$template->assign_var_from_handle('STATS_BOX', 'stats_box');
	}
}

?>