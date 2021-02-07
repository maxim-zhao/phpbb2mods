<?php
//
//	file: includes/class_stats_online.php
//	author: ptirhiik
//	begin: 10/05/2006
//	version: 1.6.3 - 27/06/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class stats_online extends stats
{
	var $mode;
	var $data_reg;
	var $data_gst;
	var $totals;
	var $location_pages;

	var $plug_ins;
	var $plug_ins_done;

	function stats_online($mode='')
	{
		$this->mode = ($mode == 'in_admin') || (empty($mode) && defined('IN_ADMIN')) ? 'in_admin' : 'in_user';

		$this->data_reg = $this->data_gst = array();
		$this->totals = array();
		$this->plug_ins = false;
		$this->plug_ins_done = false;

		$this->location_pages = array(
			PAGE_INDEX => array('txt' => 'Forum_index', 'url' => $this->mode == 'in_admin' ? 'admin/index' : INDEX, 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_POSTING => array('txt' => 'Posting_message', 'url' => $this->mode == 'in_admin' ? 'admin/index' : INDEX, 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_LOGIN => array('txt' => 'Logging_on', 'url' => $this->mode == 'in_admin' ? 'admin/index' : INDEX, 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_SEARCH => array('txt' => 'Searching_forums', 'url' => $this->mode == 'in_admin' ? 'admin/index' : 'search', 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_PROFILE => array('txt' => 'Viewing_profile', 'url' => $this->mode == 'in_admin' ? 'admin/index' : INDEX, 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_VIEWONLINE => array('txt' => 'Viewing_online', 'url' => $this->mode == 'in_admin' ? 'admin/index' : 'viewonline', 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_VIEWMEMBERS => array('txt' => 'Viewing_member_list', 'url' => $this->mode == 'in_admin' ? 'admin/index' : 'memberlist', 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_PRIVMSGS => array('txt' => 'Viewing_priv_msgs', 'url' => $this->mode == 'in_admin' ? 'admin/index' : 'privmsg', 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_FAQ => array('txt' => 'Viewing_FAQ', 'url' => $this->mode == 'in_admin' ? 'admin/index' : 'faq', 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
			PAGE_GROUPCP => array('txt' => 'Viewing_groups', 'url' => $this->mode == 'in_admin' ? 'admin/index' : 'groupcp', 'parms' => $this->mode == 'in_admin' ? array('pane' => 'right') : array()),
		);
	}

	function read()
	{
		global $config, $db, $user;

		// session fields
		$session_fields = array(
			'session_page',
			'session_logged_in',
			'session_time',
			'session_ip',
			'session_start',
		);

		// user fields
		$user_fields = array_merge($user->pool_fields, array(
			'user_id',
			'username',
			'user_level',
			'user_allow_viewonline',
			'user_session_time',
			'user_session_logged',
			'user_bot_ips',
			'user_bot_agent',
		));

		// plugs
		if ( $this->plug_ins_done && ($this->plug_ins_done = true) )
		{
			$plug_ins = new plug_ins();
			$plug_ins->load('class_stats_online');
			unset($plug_ins);
			$this->plug_ins = &$config->plug_ins['class_stats_online'];
		}
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'read') )
				{
					$this->plug_ins[$plug]->read($session_fields, $user_fields);
				}
			}
		}

		// read
		$sql = 'SELECT s.' . implode(', s.', $session_fields) . ', u.' . implode(', u.', $user_fields) . '
					FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . ' s
					WHERE u.user_id = s.session_user_id
						AND s.session_time >= ' . (time() - TIME_ONLINE_RANGE) . '
					ORDER BY u.username, s.session_ip, s.session_time DESC';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->totals = array('shown' => 0, 'hidden' => 0, 'guests' => 0);
		$this->data_gst = $this->data_reg = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			// deal with registered users
			if ( $row['session_logged_in'] )
			{
				if ( !isset($this->data_reg[ intval($row['user_id']) ]) )
				{
					if ( ($row['user_bot_agent'] || $row['user_bot_ips']) && !intval($row['user_level']) )
					{
						$row['user_level'] = BOT;
					}
					$this->totals[ $row['user_allow_viewonline'] ? 'shown' : 'hidden' ]++;
					$this->data_reg[ intval($row['user_id']) ] = $row['user_allow_viewonline'] || ($row['user_id'] == $user->data['user_id']) || ($user->data['user_level'] == ADMIN) || ($user->auth(POST_FORUM_URL, 'auth_mod', intval($row['session_page'])) && ($row['user_level'] != ADMIN)) ? $row : false;
				}
			}

			// deal with guests
			else
			{
				$session_row = array(
					'session_page' => $row['session_page'],
					'session_logged_in' => $row['session_logged_in'],
					'session_time' => $row['session_time'],
					'session_ip' => $row['session_ip'],
					'session_start' => $row['session_start'],
				);
				if ( !isset($this->data_gst[ $row['session_ip'] ]) )
				{
					$this->totals['guests']++;
					$this->data_gst[ $row['session_ip'] ] = array($session_row);
				}
				// we don't need all the iters if we are not in admin, only the most recent
				else if ( $this->mode == 'in_admin' )
				{
					$this->data_gst[ $row['session_ip'] ][] = $session_row;
				}
			}
		}
		$db->sql_freeresult($result);
	}

	function display()
	{
		global $template, $user, $config, $theme;

		$user_levels = $this->get_user_levels();

		// registered
		if ( !empty($this->data_reg) )
		{
			$color = false;
			foreach ( $this->data_reg as $user_id => $row )
			{
				if ( $row )
				{
					$style = isset($user_levels[ $row['user_level'] ]) ? $user_levels[ $row['user_level'] ]['style'] : $user_levels[USER]['style'];
					$username = sprintf(($row['user_allow_viewonline'] ? (empty($style) ? '%s' : '<span' . $style . '>%s</span>') : '<i' . $style . '>%s</i>'), $row['username']);
					$location_page = $this->get_location_page(intval($row['session_page']));
					$ip = decode_ip($row['session_ip']);

					$color = !$color;
					$row_color = $color ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = $color ? $theme['td_class1'] : $theme['td_class2'];
					$template->assign_block_vars('reg_user_row', array(
						'ROW_COLOR' => '#' . $row_color,
						'ROW_CLASS' => $row_class,
						'USERNAME' => $username,
						'U_USER_PROFILE' => $config->url('usercp', array('mode' => 'viewprofile', POST_USERS_URL => intval($row['user_id'])), true),
						'IP_ADDRESS' => $ip,
						'U_WHOIS_IP' => 'http://network-tools.com/default.asp?host=' . $ip,
						'STARTED' => $user->date($row['session_start']),
						'LASTUPDATE' => $user->date($row['session_time']),
						'FORUM_LOCATION' => $user->lang($location_page['txt']),
						'U_FORUM_LOCATION' => $config->url($location_page['url'], $location_page['parms'], true),
					));
					$template->set_switch('reg_user_row.light', $color);

					// plugs
					if ( $this->plug_ins )
					{
						foreach ( $this->plug_ins as $plug => $dummy )
						{
							if ( method_exists($this->plug_ins[$plug], 'display') )
							{
								$this->plug_ins[$plug]->display('users', $row, 'reg_user_row');
							}
						}
					}
				}
			}
		}

		// guests
		if ( !empty($this->data_gst) )
		{
			$color = false;
			foreach ( $this->data_gst as $session_ip => $sessions )
			{
				$count_sessions = count($sessions);
				for ( $j = 0; $j < $count_sessions; $j++ )
				{
					$row = $sessions[$j];
					$username = $j ? '' : $user->lang('Guest');
					$location_page = $this->get_location_page(intval($row['session_page']));
					$ip = decode_ip($row['session_ip']);

					$color = !$color;
					$row_color = $color ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = $color ? $theme['td_class1'] : $theme['td_class2'];
					$template->assign_block_vars('guest_user_row', array(
						'ROW_COLOR' => '#' . $row_color,
						'ROW_CLASS' => $row_class,
						'USERNAME' => $username,
						'U_USER_PROFILE' => '',
						'IP_ADDRESS' => $ip,
						'U_WHOIS_IP' => 'http://network-tools.com/default.asp?host=' . $ip,
						'STARTED' => $user->date($row['session_start']),
						'LASTUPDATE' => $user->date($row['session_time']),
						'FORUM_LOCATION' => $user->lang($location_page['txt']),
						'U_FORUM_LOCATION' => $config->url($location_page['url'], $location_page['parms'], true),
					));
					$template->set_switch('guest_user_row.light', $color);

					// plugs
					if ( $this->plug_ins )
					{
						foreach ( $this->plug_ins as $plug => $dummy )
						{
							if ( method_exists($this->plug_ins[$plug], 'display') )
							{
								$this->plug_ins[$plug]->display('guests', $row, 'guest_user_row');
							}
						}
					}
				}
			}
		}

		// totals
		$l_registered = $this->totals['shown'] == 0 ? 'Reg_users_zero_online' : ($this->totals['shown'] == 1 ? 'Reg_user_online' : 'Reg_users_online');
		$l_hidden = $this->totals['hidden'] == 0 ? 'Hidden_users_zero_online' : ($this->totals['hidden'] == 1 ? 'Hidden_user_online' : 'Hidden_users_online');
		$l_guests = $this->totals['guests'] == 0 ? 'Guest_users_zero_online' : ($this->totals['guests'] == 1 ? 'Guest_user_online' : 'Guest_users_online');

		// display legend
		$template->assign_vars(array(
			'L_WHO_IS_ONLINE' => $user->lang('Who_is_Online'),
			'L_WHOSONLINE' => $user->lang('Who_is_Online'),
			'L_ONLINE_EXPLAIN' => $user->lang('Online_explain'),

			'L_USERNAME' => $user->lang('Username'),
			'L_STARTED' => $user->lang('Login'),
			'L_LAST_UPDATE' => $user->lang('Last_updated'),
			'L_IP_ADDRESS' => $user->lang('IP_Address'),
			'L_LOCATION' => $user->lang('Location'),
			'L_FORUM_LOCATION' => $user->lang('Forum_Location'),

			'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($user->lang($l_registered), $this->totals['shown']) . sprintf($user->lang($l_hidden), $this->totals['hidden']),
			'TOTAL_GUEST_USERS_ONLINE' => sprintf($user->lang($l_guests), $this->totals['guests']),

			'L_NO_REGISTERED_USERS_BROWSING' => $this->totals['shown'] + $this->totals['hidden'] ? '' : $user->lang('No_users_browsing'),
			'L_NO_GUESTS_BROWSING' => $this->totals['guests'] ? '' : $user->lang('No_users_browsing'),
		));

		// plugs
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'display') )
				{
					$this->plug_ins[$plug]->display();
				}
			}
		}
	}

	function get_location_page($session_page)
	{
		global $forums, $user;

		// default is index
		$location_page = $this->location_pages[PAGE_INDEX];

		// regular page view
		if ( ($session_page < 1) && isset($this->location_pages[$session_page]) )
		{
			$location_page = $this->location_pages[$session_page];
		}
		// forum view
		else if ( isset($forums->data[$session_page]) && $user->auth(POST_FORUM_URL, 'auth_view', $session_page) )
		{
			$location_page = array(
				'txt' => $forums->data[$session_page]['forum_name'],
				'url' => $this->mode == 'in_admin' ? 'admin/admin_forums' : INDEX,
				'parms' => ($this->mode == 'in_admin' ? array('mode' => 'edit', 'pane' => 'right') : array()) + array(POST_FORUM_URL => intval($session_page)),
			);
		}
		return $location_page;
	}
}

?>