<?php
//
//	file: includes/acp/acp_stats_posting.php
//	author: ptirhiik
//	begin: 08/02/2006
//	version: 1.6.1 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

include($config->url('includes/class_stats_admin'));
include($config->url('includes/class_stats'));

$cp_title = 'Stats_posting';
$cp_title_explain = 'Stats_posting_explain';

$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);

//
// classes
//

class stats_posting extends stats_admin
{
	var $date_min;
	var $date_max;
	var $date_inc;
	var $span_all;

	function stats_posting($requester, $parms, $cells, $date_min, $date_max, $date_inc)
	{
		parent::stats_admin($requester, $parms, $cells);

		$this->date_min = $date_min;
		$this->date_max = $date_max;
		$this->date_inc = $date_inc;

		$this->span_all = count($this->cells) + 3;
	}

	function read()
	{
		global $db;

		$this->sum = 0;
		$this->total = array();
		$this->data = array();

		$user_id = intval($this->parms[POST_USERS_URL]);

		$date_inc = $this->date_inc == '_' ? 'H' : $this->date_inc;
		$time_max = $this->date_max;
		$time_min = $this->date_minus($time_max, $date_inc);
		while ( $time_min >= $this->date_min )
		{
			$key = date($date_inc, $time_min);

			// user granted
			if ( $user_id )
			{
				// topics
				$sql = 'SELECT COUNT(topic_id) AS count_ids
							FROM ' . TOPICS_TABLE . '
							WHERE topic_time BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . '
								AND topic_moved_id = 0
								AND topic_poster = ' . intval($user_id);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$count_ids = ($row = $db->sql_fetchrow($result)) ? intval($row['count_ids']) : 0;
				$db->sql_freeresult($result);
				if ( !isset($this->data[$key]) )
				{
					$this->data[$key] = array();
				}
				$this->data[$key][POST_TOPIC_URL . POST_USERS_URL] = $count_ids;
				if ( !isset($this->total[POST_TOPIC_URL . POST_USERS_URL]) )
				{
					$this->total[POST_TOPIC_URL . POST_USERS_URL] = $count_ids;
				}
				else
				{
					$this->total[POST_TOPIC_URL . POST_USERS_URL] += $count_ids;
				}
				$this->sum += $count_ids;

				// posts
				$sql = 'SELECT COUNT(post_id) AS count_ids
							FROM ' . POSTS_TABLE . '
							WHERE post_time BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . '
							AND poster_id = ' . intval($user_id);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$count_ids = ($row = $db->sql_fetchrow($result)) ? intval($row['count_ids']) : 0;
				$db->sql_freeresult($result);
				if ( !isset($this->data[$key]) )
				{
					$this->data[$key] = array();
				}
				// minus the topics already counted
				if ( isset($this->data[$key][POST_TOPIC_URL . POST_USERS_URL]) )
				{
					$count_ids -= intval($this->data[$key][POST_TOPIC_URL . POST_USERS_URL]);
				}
				$this->data[$key][POST_POST_URL . POST_USERS_URL] = $count_ids;
				if ( !isset($this->total[POST_POST_URL . POST_USERS_URL]) )
				{
					$this->total[POST_POST_URL . POST_USERS_URL] = $count_ids;
				}
				else
				{
					$this->total[POST_POST_URL . POST_USERS_URL] += $count_ids;
				}
				$this->sum += $count_ids;
			}

			// topics
			$sql = 'SELECT COUNT(topic_id) AS count_ids
						FROM ' . TOPICS_TABLE . '
						WHERE topic_time BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . '
							AND topic_moved_id = 0' . (!intval($user_id) ? '' : '
							AND topic_poster <> ' . intval($user_id));
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$count_ids = ($row = $db->sql_fetchrow($result)) ? intval($row['count_ids']) : 0;
			$db->sql_freeresult($result);
			if ( !isset($this->data[$key]) )
			{
				$this->data[$key] = array();
			}
			$this->data[$key][POST_TOPIC_URL] = $count_ids;
			if ( !isset($this->total[POST_TOPIC_URL]) )
			{
				$this->total[POST_TOPIC_URL] = $count_ids;
			}
			else
			{
				$this->total[POST_TOPIC_URL] += $count_ids;
			}
			$this->sum += $count_ids;

			// posts
			$sql = 'SELECT COUNT(post_id) AS count_ids
						FROM ' . POSTS_TABLE . '
						WHERE post_time BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . (!intval($user_id) ? '' : '
							AND poster_id <> ' . intval($user_id));
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$count_ids = ($row = $db->sql_fetchrow($result)) ? intval($row['count_ids']) : 0;
			$db->sql_freeresult($result);
			if ( !isset($this->data[$key]) )
			{
				$this->data[$key] = array();
			}
			// minus the topics already counted
			if ( isset($this->data[$key][POST_TOPIC_URL]) )
			{
				$count_ids -= intval($this->data[$key][POST_TOPIC_URL]);
			}
			$this->data[$key][POST_POST_URL] = $count_ids;
			if ( !isset($this->total[POST_POST_URL]) )
			{
				$this->total[POST_POST_URL] = $count_ids;
			}
			else
			{
				$this->total[POST_POST_URL] += $count_ids;
			}
			$this->sum += $count_ids;

			// next range
			$time_max = $time_min;
			$time_min = $this->date_minus($time_min, $date_inc);
		}
		$this->sum = max(1, $this->sum);
	}

	function display()
	{
		global $config, $template, $user;

		// send results
		$template->assign_vars(array(
			'L_FORM' => $user->lang('Stats_historic'),
			'L_TOTAL' => $user->lang('Stats_total'),
			'SPAN_ALL' => $this->span_all,

			'L_EXTRA' => $user->lang('Stats_userlist'),
			'I_EXTRA' => $user->img('sts_user'),
		));
		foreach ( $this->cells as $key => $data )
		{
			$template->assign_block_vars('data', array(
				'L_TOTAL' => $user->lang($data['legend']),
			));
		}

		// send title
		$set = array(
			'H' => array('legend' => 'Stats_day', 'legend_fmt' => 'Ymd', 'parms' => 'Ymd', 'nolink' => true, 'extra' => array(POST_POST_URL => array('list' => POST_USERS_URL, 'fmt' => 'YmdH'))),
			'd' => array('legend' => 'Stats_month', 'legend_fmt' => 'Ym', 'parms' => 'Ym', 'nolink' => true, 'extra' => array(POST_POST_URL => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
			'Ym' => array('legend' => 'Stats_year', 'legend_fmt' => '', 'parms' => '', 'nolink' => true, 'extra' => array(POST_POST_URL => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
		);
		$this->display_a_bar(true, $this->date_min, $set[$this->date_inc], $this->total);
		$template->set_switch('row.title');

		// send rows
		$set = array(
			'H' => array('legend' => 'Stats_hour_short', 'legend_fmt' => $this->date_inc, 'parms' => 'YmdH', 'nolink' => true, 'extra' => array(POST_POST_URL => array('list' => POST_USERS_URL, 'fmt' => 'YmdH'))),
			'd' => array('legend' => 'Stats_day_short', 'legend_fmt' => $this->date_inc, 'parms' => 'Ymd', 'extra' => array(POST_POST_URL => array('list' => POST_USERS_URL, 'fmt' => 'Ymd'))),
			'Ym' => array('legend' => 'Stats_month_short', 'legend_fmt' => $this->date_inc, 'parms' => 'Ym', 'extra' => array(POST_POST_URL => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
		);
		// let's go to the first displayed row
		$time = $this->date_minus($this->date_max, $this->date_inc);
		while ( $time >= $this->date_min )
		{
			$this->display_a_bar(false, $time, $set[$this->date_inc], $this->data[ date($this->date_inc, $time) ]);
			$time = $this->date_minus($time, $this->date_inc);
		}
	}
}

class stats_posting_users extends stats_posting
{
	function read()
	{
		global $db, $user;

		$user_fields = $user->pool_fields;
		$this->data = array();
		$this->total = array(POST_POST_URL => 0, POST_TOPIC_URL => 0);

		$time_min = $this->date_min;
		$time_max = $this->date_max;

		// user topics
		$sql = 'SELECT t.topic_poster, COUNT(t.topic_id) AS count_ids' . ($user->pool_fields ? ', u.' . implode(', u.', $user_fields) : '') . '
					FROM ' . TOPICS_TABLE . ' t
						LEFT JOIN ' . USERS_TABLE . ' u
							ON u.user_id = t.topic_poster
					WHERE t.topic_time BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . '
						AND t.topic_moved_id = 0
					GROUP BY t.topic_poster' . ($user->pool_fields ? ', u.' . implode(', u.', $user_fields) : '') . '
					ORDER BY u.username, t.topic_poster';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$count_ids = intval($row['count_ids']);
			$row['user_id'] = intval($row['topic_poster']);
			if ( isset($row['count_ids']) )
			{
				unset($row['count_ids']);
			}
			if ( isset($row['topic_poster']) )
			{
				unset($row['topic_poster']);
			}
			if ( empty($row['username']) || empty($row['user_id']) )
			{
				$row['user_id'] = ANONYMOUS;
			}
			if ( !isset($this->data[ intval($row['user_id']) ]) )
			{
				foreach ( $row as $key => $val )
				{
					if ( !is_string($key) )
					{
						unset($row[$key]);
					}
				}
				$this->data[ intval($row['user_id']) ] = array('row' => $row, POST_TOPIC_URL => $count_ids);
			}
			else
			{
				$this->data[ intval($row['user_id']) ][POST_TOPIC_URL] += $count_ids;
			}
			$this->total[POST_TOPIC_URL] += $count_ids;
		}
		$db->sql_freeresult($result);

		// user posts
		$sql = 'SELECT p.poster_id, COUNT(p.post_id) AS count_ids' . ($user->pool_fields ? ', u.' . implode(', u.', $user_fields) : '') . '
					FROM ' . POSTS_TABLE . ' p
						LEFT JOIN ' . USERS_TABLE . ' u
							ON u.user_id = p.poster_id
					WHERE p.post_time BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . '
					GROUP BY p.poster_id' . ($user->pool_fields ? ', u.' . implode(', u.', $user_fields) : '') . '
					ORDER BY u.username, p.poster_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$count_ids = intval($row['count_ids']);
			$row['user_id'] = intval($row['poster_id']);
			if ( isset($row['count_ids']) )
			{
				unset($row['count_ids']);
			}
			if ( isset($row['poster_id']) )
			{
				unset($row['poster_id']);
			}
			if ( empty($row['username']) || empty($row['user_id']) )
			{
				$row['user_id'] = ANONYMOUS;
			}
			if ( !isset($this->data[ intval($row['user_id']) ]) )
			{
				foreach ( $row as $key => $val )
				{
					if ( !is_string($key) )
					{
						unset($row[$key]);
					}
				}
				$this->data[ intval($row['user_id']) ] = array('row' => $row, POST_POST_URL => $count_ids);
			}
			else
			{
				// minus already read topics
				$count_ids -= intval($this->data[ intval($row['user_id']) ][POST_TOPIC_URL]);
				$this->data[ intval($row['user_id']) ][POST_POST_URL] = $count_ids;
			}
			$this->total[POST_POST_URL] += $count_ids;
		}
		$db->sql_freeresult($result);

		// adjust totals
		$this->sum = 0;
		foreach ( $this->total as $key => $value )
		{
			$this->sum += $value;
		}
		$this->sum = max(1, $this->sum);
	}

	function display()
	{
		global $config, $user, $template;

		// send results
		$template->assign_vars(array(
			'L_FORM' => $user->lang('Stats_historic'),
			'L_TOTAL' => $user->lang('Stats_total'),
			'SPAN_ALL' => $this->span_all,

			'L_NO_CONNECTED' => $user->lang('Stats_no_posters'),
			'L_PROFILE_VISIT' => $user->lang('Stats_view_posters'),
		));
		foreach ( $this->cells as $key => $data )
		{
			$template->assign_block_vars('data', array(
				'L_TOTAL' => $user->lang($data['legend']),
			));
		}

		// send title
		$set = array(
			'_' => array('legend' => 'Stats_hour', 'legend_fmt' => 'YmdH', 'parms' => '', 'nolink' => true),
			'H' => array('legend' => 'Stats_day', 'legend_fmt' => 'Ymd', 'parms' => '', 'nolink' => true),
			'd' => array('legend' => 'Stats_month', 'legend_fmt' => 'Ym', 'parms' => '', 'nolink' => true),
			'Ym' => array('legend' => 'Stats_year', 'legend_fmt' => '', 'parms' => '', 'nolink' => true),
		);
		$this->display_a_bar(true, $this->date_min, $set[$this->date_inc], $this->total);
		$template->set_switch('row.title');
		$this->display_a_list();
	}

	function display_a_list()
	{
		global $config, $user, $template;

		$values = $this->total;
		$sum = 0;
		foreach ( $values as $key => $value )
		{
			$sum += $value;
		}

		$template->set_switch('users');
		if ( !empty($this->data) )
		{
			$reg_stats = new stats();
			$user_levels = $reg_stats->get_user_levels();
			unset($reg_stats);
			$template->set_switch('row.users');
			$first = true;
			foreach ( $this->data as $user_id => $data )
			{
				$row = $data['row'];
				$username = $row['user_id'] == ANONYMOUS ? $user->lang('Guest') : $row['username'];

				// get user style
				if ( ($row['user_bot_agent'] || $row['user_bot_ips']) && !intval($row['user_level']) )
				{
					$row['user_level'] = BOT;
				}
				$user_style = isset($user_levels[ intval($row['user_level']) ]) ? $user_levels[ intval($row['user_level']) ]['style'] : $user_levels[USER]['style'];

				// send to display
				$parms = $this->parms;
				if ( isset($parms['list']) )
				{
					unset($parms['list']);
				}
				$template->assign_block_vars('users.connected', array(
					'STYLE' => $user_style,
					'USERNAME' => $username,
					'USER_VISIT'=> intval($data[POST_POST_URL]) . '/' . intval($data[POST_TOPIC_URL]),
					'U_USERNAME' => $row['username'] ? $config->url($this->requester, $parms + array(POST_USERS_URL => intval($row['user_id'])), true) : '',
				));
				$template->set_switch('users.connected.first', $first);
				$template->set_switch('users.connected.link', $row['username']);
				$first = false;
			}
		}
	}
}

//
// process
//

// edges
$now = 3600 * floor(time() / 3600);
$max_time = mktime(0, 0, 0, date('m', $now) + 1, 01, date('Y', $now));
$min_time = mktime(0, 0, 0, date('m', $max_time), 01, date('Y', $max_time) - 1);

// prune older results
if ( defined('DO_PRUNE') && DO_PRUNE )
{
	$sql = 'DELETE FROM ' . STATS_VISIT_TABLE . '
				WHERE stat_time < ' . intval($min_time);
	$db->sql_query($sql, false, __LINE__, __FILE__);
}

// do we got an ask for a username ?
$username = stripslashes(phpbb_clean_username(addslashes(_read('username'))));
$user_id = 0;
if ( !empty($username) && _button('submituser') )
{
	$sql = 'SELECT user_id, username
				FROM ' . USERS_TABLE . '
				WHERE LOWER(username) = \'' . $db->sql_escape_string(strtolower($username)) . '\'
					AND user_id <> ' . ANONYMOUS;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$user_id = 0;
	$username = '';
	if ( $row = $db->sql_fetchrow($result) )
	{
		$user_id = intval($row['user_id']);
		$username = $row['username'];
	}
	$db->sql_freeresult($result);
	if ( $user_id )
	{
		$parms[POST_USERS_URL] = $user_id;
	}
}
if ( !$parms[POST_USERS_URL] && ($user_id = _read(POST_USERS_URL, TYPE_INT)) )
{
	$sql = 'SELECT user_id, username
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . intval($user_id) . '
					AND user_id <> ' . ANONYMOUS;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$user_id = 0;
	$username = '';
	if ( $row = $db->sql_fetchrow($result) )
	{
		$user_id = intval($row['user_id']);
		$username = $row['username'];
	}
	$db->sql_freeresult($result);
	if ( $user_id )
	{
		$parms[POST_USERS_URL] = $user_id;
	}
}

// get display type
$list = _read('list', TYPE_NO_HTML, '', array('' => '', POST_USERS_URL => ''));
if ( $list )
{
	$parms['list'] = POST_USERS_URL;
	if ( isset($parms[POST_USERS_URL]) )
	{
		unset($parms[POST_USERS_URL]);
		$user_id = 0;
		$username = '';
	}
}

// get date
$date = _read('date', TYPE_INT);

// YYYYMMDDHH
if ( $date > 1000000000 )
{
	$hour = $date % 100;
	$date = floor($date / 100);
	$day = $date % 100;
	$date = floor($date / 100);

	$date_min = mktime($hour, 0, 0, $date % 100, $day, floor($date / 100));
	$date_max = mktime($hour + 1, 0, 0, $date % 100, $day, floor($date / 100));
	$date_inc = '_';

	$back_parms = array('date' => date('Ymd', $date_min));
	$parms['list'] = POST_USERS_URL;
}
// YYYYMMDD
else if ( $date > 10000000 )
{
	$day = $date % 100;
	$date = floor($date / 100);

	$date_min = mktime(0, 0, 0, $date % 100, $day, floor($date / 100));
	$date_max = mktime(0, 0, 0, $date % 100, $day + 1, floor($date / 100));
	$date_inc = 'H';

	$back_parms = array('date' => date('Ym', $date_min));
}
// YYYYMM
else if ( $date > 100000 )
{
	$date_min = mktime(0, 0, 0, $date % 100, 01, floor($date / 100));
	$date_max = mktime(0, 0, 0, 1 + ($date % 100), 01, floor($date / 100));
	$date_inc = 'd';

	$back_parms = array();
}
// dump all
else
{
	$date_min = $min_time;
	$date_max = $max_time;
	$date_inc = 'Ym';

	$back_parms = '';
}

// ensure we are between edges
$date_min = max($min_time, $date_min);
$date_max = min($max_time, $date_max);

$cells = array();
if ( $parms[POST_USERS_URL] )
{
	$cells += array(
		POST_POST_URL . POST_USERS_URL => array('legend' => 'Stats_user_posts'),
		POST_TOPIC_URL . POST_USERS_URL => array('legend' => 'Stats_user_topics'),
	);
}
$cells += array(
	POST_POST_URL => array('legend' => 'Stats_posts'),
	POST_TOPIC_URL => array('legend' => 'Stats_topics'),
);

if ( $parms['list'] == POST_USERS_URL )
{
	$stats = new stats_posting_users($requester, $parms, $cells, $date_min, $date_max, $date_inc);
}
else
{
	$stats = new stats_posting($requester, $parms, $cells, $date_min, $date_max, $date_inc);
}
$stats->read();
$stats->display();

// constants
$template->assign_vars(array(
	'L_USERNAME' => $user->lang('Select_username'),
	'USERNAME' => $username,

	'U_SEARCH_USER' => $config->url('search', array('mode' => 'searchuser'), true),
	'I_SEARCH_USER' => $user->img('cmd_search'),
	'L_LOOK_UP' => $user->lang('Look_up_User'),
	'I_LOOK_UP' => $user->img('cmd_select'),
	'L_FIND_USERNAME' => $user->lang('Find_username'),
));
$template->set_switch('userform');
$template->set_switch('detail', $parms[POST_USERS_URL]);
if ( is_array($back_parms) || $parms['list'] )
{
	$ret_parms = $parms + (empty($back_parms) ? array() : $back_parms);
	if ( isset($ret_parms['list']) )
	{
		unset($ret_parms['list']);
	}
	display_buttons(array(
		'cancel' => array('url' => $requester, 'parms' => $ret_parms, 'txt' => 'Stats_back', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
	));
}

$template->assign_block_vars('cp_content', array('BOX' => $template->include_file('acp/acp_stats_box.tpl')));
$template->set_filenames(array('body' => 'cp_generic.tpl'));

?>