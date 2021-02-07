<?php
//
//	file: includes/class_stats.php
//	author: ptirhiik
//	begin: 03/09/2004
//	version: 1.6.1 - 05/03/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('BOT', 9999);
define('MAX_IN_LIST', 50);

class stats
{
	var $now;
	var $online_timerange;
	var $current_hour;
	var $yesterday;

	var $guests_hour;
	var $guests_past;

	// constructor
	function stats()
	{
		global $config;

		if ( !isset($config->data['stats_display_past']) )
		{
			$config->set('stats_display_past', true, true);
		}
		$this->now = time();
		$this->online_timerange = $this->now - TIME_ONLINE_RANGE; // defined in sessions.php
		$this->current_hour = 3600 * floor($this->now / 3600);
		$this->yesterday = $this->current_hour - 86400;
		$this->guests_hour = 0;
		$this->guests_past = 0;
	}

	// user levels defs
	function get_user_levels()
	{
		global $theme;

		return array(
			ADMIN => array('legend' => 'Administrator', 'style' => ' style="color:#' . $theme['fontcolor3'] . '; font-weight: bold;"', 'link_pgm' => 'memberlist', 'link_parms' => array('level' => ADMIN)),
			MOD => array('legend' => 'Moderator', 'style' => ' style="color:#' . $theme['fontcolor2'] . '; font-weight: bold;"', 'link_pgm' => 'memberlist', 'link_parms' => array('level' => MOD)),
			USER => array('legend' => 'User', 'style' => '', 'link_pgm' => 'memberlist', 'link_parms' => ''),
			BOT => array('legend' => 'Bot', 'style' => ' style="color:#' . $theme['fontcolor1'] . '; font-weight: bold;"', 'link_pgm' => 'memberlist', 'link_parms' => array(POST_GROUPS_URL => GROUP_BOTS)),
		);
	}

	function display($forum_id=0)
	{
		global $db, $config, $template, $user;

		// config value : stats_display_past : true/false : display past stats

		// get past historic ?
		$get_past = empty($forum_id) && $config->data['stats_display_past'];

		// prepare the counts
		$max_in_list = defined('MAX_IN_LIST') && (MAX_IN_LIST != 0);
		$see = !$max_in_list ? '' : _read('see', TYPE_NO_HTML);
		$counts = array(
			'online' => array('hidden' => 0, 'visible' => 0, 'guests' => 0, 'displayed' => 0, 'full_list' => !$max_in_list || ($see == 'all')),
			'hour' => array('hidden' => 0, 'visible' => 0, 'guests' => 0, 'displayed' => 0, 'full_list' => !$max_in_list || ($see == 'allhour')),
			'past' => array('hidden' => 0, 'visible' => 0, 'guests' => 0, 'displayed' => 0, 'full_list' => !$max_in_list || ($see == 'allpast')),
		);

		// users levels defs
		$user_levels = $this->get_user_levels();

		// get number of guest during the last 5 minutes
		$sql = 'SELECT COUNT(DISTINCT session_ip) AS count_session_ip
					FROM ' . SESSIONS_TABLE . '
					WHERE session_user_id = ' . ANONYMOUS . '
						AND session_time >= ' . intval($this->online_timerange) . (empty($forum_id) ? '' : '
						AND session_page = ' . intval($forum_id));
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$counts['online']['guests'] = ($row = $db->sql_fetchrow($result)) ? intval($row['count_session_ip']) : 0;
		$db->sql_freeresult($result);

		// get past guests
		if ( $get_past )
		{
			$sql = 'SELECT stat_time, stat_visit
						FROM ' . STATS_VISIT_TABLE . '
						WHERE user_id = ' . ANONYMOUS . '
							AND stat_time >= ' . intval($this->yesterday);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				if ( intval($row['stat_time']) >= $this->current_hour )
				{
					$counts['hour']['guests'] += intval($row['stat_visit']);
				}
				$counts['past']['guests'] += intval($row['stat_visit']);
			}
		}

		// get user fields
		$user_fields = $user->pool_fields;
		$count_user_fields = count($user_fields);

		// start the display
		$template->set_switch('root', empty($forum_id));
		$template->set_switch('stats');

		// we always get online, but not always past, and never hour
		$template->set_switch('stats.online');
		$template->set_switch('stats.past', $get_past);

		// build the main request to read registered users
		$sql = 'SELECT user_id' . ($count_user_fields ? ', ' . implode(', ', $user_fields) : '') . '
					FROM ' . USERS_TABLE . '
					WHERE user_id <> ' . ANONYMOUS . '
						AND user_session_time >= ' . intval($get_past ? $this->yesterday : $this->online_timerange) . (empty($forum_id) ? '' : '
						AND user_session_page = ' . intval($forum_id)) . '
					ORDER BY username';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			// save user data for other scripts
			if ( !isset($user->pool[ intval($row['user_id']) ]) )
			{
				for ( $i = 0; $i < $count_user_fields; $i++ )
				{
					$user->pool[ intval($row['user_id']) ][ $user_fields[$i] ] = $row[ $user_fields[$i] ];
				}
			}

			// process counts
			$hidden = !$row['user_allow_viewonline'];
			$ranges = array(
				'online' => $row['user_session_logged'] && ($row['user_session_time'] >= $this->online_timerange),
				'hour' => $get_past && ($row['user_session_time'] >= $this->current_hour),
				'past' => $get_past && ($row['user_session_time'] >= $this->yesterday),
			);

			// process display
			$user_style_done = false;
			$user_style = '';
			$u_profile = '';
			$viewable = true;
			foreach ( $ranges as $range => $in_range )
			{
				if ( $in_range )
				{
					$counts[$range][ ($hidden ? 'hidden' : 'visible') ]++;
				}

				// we don't display list of presents during the hour
				if ( !$in_range || ($range == 'hour') || !$viewable )
				{
					continue;
				}

				// what to display ?
				$display = $counts[$range]['full_list'] || ($counts[$range]['displayed'] < MAX_IN_LIST) ? 'standard' : ($counts[$range]['displayed'] == MAX_IN_LIST ? 'next' : 'none');

				// get user style if necessary
				if ( !$user_style_done && ($display == 'standard') )
				{
					if ( $viewable = (!$hidden || ($user->data['user_level'] == ADMIN) || (($row['user_level'] != ADMIN) && (intval($row['user_session_page']) > 0) && $user->auth(POST_FORUM_URL, 'auth_mod', intval($row['user_session_page'])))) )
					{
						// get user style
						if ( ($row['user_bot_agent'] || $row['user_bot_ips']) && !intval($row['user_level']) )
						{
							$row['user_level'] = BOT;
						}
						$user_style = isset($user_levels[ intval($row['user_level']) ]) ? $user_levels[ intval($row['user_level']) ]['style'] : $user_levels[USER]['style'];
						$u_profile = $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true);
					}
					$user_style_done = true;
				}
				if ( !$viewable )
				{
					continue;
				}

				// go with display
				switch ( $display )
				{
					case 'standard':
						$template->assign_block_vars('stats.' . $range . '.row', array(
							'U_VIEW_PROFILE' => $u_profile,
							'USERNAME' => $row['username'],
							'STYLE' => $user_style,
						));
						$template->set_switch('stats.' . $range . '.row.hidden', $hidden);
						$template->set_switch('stats.' . $range . '.row.sep', $counts[$range]['displayed']);
						break;

					case 'next':
						$template->assign_block_vars('stats.' . $range . '.row', array(
							'U_VIEW_PROFILE' => $config->url(INDEX, array('see' => 'all' . ($range == 'online' ? '' : $range), POST_FORUM_URL => intval($forum_id)), true),
							'USERNAME' => '...',
							'STYLE' => '',
						));
						$template->set_switch('stats.' . $range . '.row.sep');
						break;
				}
				$counts[$range]['displayed']++;
			}
		}
		$db->sql_freeresult($result);

		// display legend
		foreach ( $user_levels as $user_level => $level_data )
		{
			if ( !empty($level_data['legend']) )
			{
				$template->assign_block_vars('stats.legend', array(
					'U_LEVEL' => empty($level_data['link_pgm']) ? '' : $config->url($level_data['link_pgm'], $level_data['link_parms'], true),
					'LEVEL_NAME' => $user->lang($level_data['legend']),
					'STYLE' => $level_data['style'],
				));
				$template->set_switch('stats.legend.link', !empty($level_data['link_pgm']));
			}
		}

		// count users
		$nb_onlines = $counts['online']['hidden'] + $counts['online']['visible'] + $counts['online']['guests'];

		// update board stats
		if ( $nb_onlines > $config->data['record_online_users'] )
		{
			$config->begin_transaction();
			$config->set('record_online_users', $nb_onlines);
			$config->set('record_online_date', $this->now);
			$config->end_transaction();
		}

		// users stats
		if ( empty($forum_id) )
		{
			// last user stats
			if ( empty($config->data['stat_total_users']) )
			{
				// count users
				$sql = 'SELECT COUNT(user_id) AS count_user_id
							FROM ' . USERS_TABLE;
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$count_users = ($row = $db->sql_fetchrow($result)) ? max(0, intval($row['count_user_id']) -1) : 0;
				$db->sql_freeresult($result);

				// update last user stats
				if ( $count_users )
				{
					$sql = 'SELECT user_id, username
								FROM ' . USERS_TABLE . '
								WHERE user_id <> ' . ANONYMOUS . '
								ORDER BY user_id DESC
								LIMIT 1';
					$result = $db->sql_query($sql, false, __LINE__, __FILE__);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);
				}

				$config->begin_transaction();
				$config->set('stat_total_users', $count_users);
				$config->set('stat_last_user', $count_users ? intval($row['user_id']) : 0);
				$config->set('stat_last_username', $count_users ? $row['username'] : '');
				$config->end_transaction();
			}

			// send to template
			$template->assign_vars(array(
				'TOTAL_POSTS' => $this->sprintf_count(intval($config->data['stat_total_posts']), 'Posted_articles_zero_total', 'Posted_article_total', 'Posted_articles_total'),
				'TOTAL_USERS' => $this->sprintf_count(intval($config->data['stat_total_users']), 'Registered_users_zero_total', 'Registered_user_total', 'Registered_users_total'),
				'RECORD_USERS' => sprintf($user->lang('Record_online_users'), $config->data['record_online_users'], $user->date($config->data['record_online_date'])),
				'U_NEWEST_USER' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => intval($config->data['stat_last_user'])), true),
				'L_NEWEST_USER' => $user->lang('Newest_user'),
				'NEWEST_USERNAME' => $config->data['stat_last_username'],
				'NEWEST_STYLE' => $user_levels[USER]['style'],

				'L_TOTAL_ONLINE' => $this->sprintf_count($nb_onlines, 'Online_users_zero_total', 'Online_user_total', 'Online_users_total'),
			));

			// past count
			if ( $get_past )
			{
				// historic past users online counts stats
				$hour_online =
					$this->sprintf_count($counts['hour']['visible'], 'Reg_users_zero_total', 'Reg_user_total', 'Reg_users_total') .
					$this->sprintf_count($counts['hour']['hidden'], 'Hidden_users_zero_total', 'Hidden_user_total', 'Hidden_users_total') .
					$this->sprintf_count($counts['hour']['guests'], 'Guest_users_zero_total', 'Guest_user_total', 'Guest_users_total');
				$past_online =
					$this->sprintf_count($counts['past']['visible'], 'Reg_users_zero_total', 'Reg_user_total', 'Reg_users_total') .
					$this->sprintf_count($counts['past']['hidden'], 'Hidden_users_zero_total', 'Hidden_user_total', 'Hidden_users_total') .
					$this->sprintf_count($counts['past']['guests'], 'Guest_users_zero_total', 'Guest_user_total', 'Guest_users_total');

				$total_hour = $counts['hour']['visible'] + $counts['hour']['hidden'] + $counts['hour']['guests'];
				$total_past = $counts['past']['visible'] + $counts['past']['hidden'] + $counts['past']['guests'];

				// send to template
				$template->assign_vars(array(
					'L_TOTAL_HOUR' => $this->sprintf_count($total_hour, 'Hour_users_zero_total', 'Hour_user_total', 'Hour_users_total'),
					'L_TOTAL_PAST' => $this->sprintf_count($total_past, 'Past_users_zero_total', 'Past_user_total', 'Past_users_total'),
					'TOTAL_HOUR_USERS' => $hour_online,
					'TOTAL_PAST_USERS' => $past_online,
					'TOTAL_HOUR_SHORT' => sprintf($user->lang('Hour_visits'), $hour_online, $user->date($this->current_hour)),
					'TOTAL_PAST_SHORT' => sprintf($user->lang('Past_visits'), $past_online, $user->date($this->yesterday)),
				));
			}
		}

		// displayed in all cases
		$currently_online = 
			$this->sprintf_count($counts['online']['visible'], 'Reg_users_zero_total', 'Reg_user_total', 'Reg_users_total') .
			$this->sprintf_count($counts['online']['hidden'], 'Hidden_users_zero_total', 'Hidden_user_total', 'Hidden_users_total') .
			$this->sprintf_count($counts['online']['guests'], 'Guest_users_zero_total', 'Guest_user_total', 'Guest_users_total');

		// constants
		$template->assign_vars(array(
			'TOTAL_USERS_ONLINE' => $currently_online,

			'L_REGISTERED_USERS' => $user->lang('Registered_users'),
			'L_BROWSING_USERS' => $user->lang('Browsing_forum'),

			'U_VIEWONLINE' => $config->url('viewonline', '', true),
			'L_VIEWONLINE' => $user->lang('Who_is_Online'),
			'I_VIEWONLINE' => $user->img('whosonline'),
			'I_SPACER' => $user->img('spacer'),

			'L_LEGEND' => $user->lang('Legend'),
			'NO_USERS_ONLINE' => $user->lang('None'),
			'L_VIEW_PROFILE' => $user->lang('Read_profile'),
			'L_ONLINE_EXPLAIN' => $user->lang('Online_explain'), // data based on users active ...
		));

		// send to display
		$template->assign_vars(array('STATS_BOX' => $template->include_file('index_stats_box.tpl')));
	}

	function sprintf_count($count, $lang_none, $lang_one, $lang_many)
	{
		global $user;
		return sprintf($user->lang(!$count ? $lang_none : ($count == 1 ? $lang_one : $lang_many)), $count);
	}
}

?>