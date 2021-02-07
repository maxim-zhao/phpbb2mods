<?php
//
//	file: includes/acp/acp_stats_visits.php
//	author: ptirhiik
//	begin: 03/02/2006
//	version: 1.6.1 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

define('DO_PRUNE', false); // set this true to prune results older than one year
define('ANY_REGISTERED', -2);
define('FOCUSED_USER', -3);

include($config->url('includes/class_stats_admin'));
include($config->url('includes/class_stats'));

$cp_title = 'Stats_visit';
$cp_title_explain = 'Stats_visit_explain';

$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);

//
// classes
//

class stats_visit extends stats_admin
{
	var $date_min;
	var $date_max;
	var $date_inc;
	var $span_all;

	function stats_visit($requester, $parms, $cells, $date_min, $date_max, $date_inc)
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

		$this->data = array();
		$total = array(FOCUSED_USER => 0, ANY_REGISTERED => 0, ANONYMOUS => 0);

		// get the totals for all registered users
		$sql = 'SELECT stat_time, SUM(stat_visit) as sum_stat_visit
					FROM ' . STATS_VISIT_TABLE . '
					WHERE stat_time BETWEEN ' . intval($this->date_min) . ' AND ' . (intval($this->date_max) - 1) . ($this->parms[POST_USERS_URL] ? '
						AND user_id NOT IN(' . ANONYMOUS . ', ' . intval($this->parms[POST_USERS_URL]) . ')' : '
						AND user_id <> ' . ANONYMOUS) . '
					GROUP BY stat_time';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$key = date($this->date_inc, $row['stat_time']);
			if ( !isset($this->data[$key]) )
			{
				$this->data[$key] = array(ANY_REGISTERED => intval($row['sum_stat_visit']));
			}
			else
			{
				$this->data[$key][ANY_REGISTERED] += intval($row['sum_stat_visit']);
			}
			$total[ANY_REGISTERED] += intval($row['sum_stat_visit']);
		}
		$db->sql_freeresult($result);

		// let's select the rows
		$sql = 'SELECT user_id, stat_time, stat_visit
					FROM ' . STATS_VISIT_TABLE . '
					WHERE stat_time BETWEEN ' . intval($this->date_min) . ' AND ' . (intval($this->date_max) - 1) . ($this->parms[POST_USERS_URL] ? '
						AND user_id IN(' . ANONYMOUS . ', ' . intval($this->parms[POST_USERS_URL]) . ')' : '
						AND user_id = ' . ANONYMOUS) . '
					ORDER BY user_id, stat_time';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$key = date($this->date_inc, $row['stat_time']);
			if ( !isset($this->data[$key]) )
			{
				$this->data[$key] = array();
			}
			if ( intval($row['user_id']) == ANONYMOUS )
			{
				$this->data[$key][ANONYMOUS] += intval($row['stat_visit']);
				$total[ANONYMOUS] += intval($row['stat_visit']);
			}
			else
			{
				$this->data[$key][FOCUSED_USER] += intval($row['stat_visit']);
				$total[FOCUSED_USER] += intval($row['stat_visit']);
			}
		}
		$db->sql_freeresult($result);

		$this->sum = 0;
		$this->total = array();
		foreach ( $this->cells as $key => $dummy )
		{
			$this->total[$key] = intval($total[$key]);
			$this->sum += intval($total[$key]);
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
			'H' => array('legend' => 'Stats_day', 'legend_fmt' => 'Ymd', 'parms' => 'Ymd', 'nolink' => true, 'extra' => array(ANY_REGISTERED => array('list' => POST_USERS_URL, 'fmt' => 'YmdH'))),
			'd' => array('legend' => 'Stats_month', 'legend_fmt' => 'Ym', 'parms' => 'Ym', 'nolink' => true, 'extra' => array(ANY_REGISTERED => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
			'Ym' => array('legend' => 'Stats_year', 'legend_fmt' => '', 'parms' => '', 'nolink' => true, 'extra' => array(ANY_REGISTERED => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
		);
		$this->display_a_bar(true, $this->date_min, $set[$this->date_inc], $this->total);
		$template->set_switch('row.title');

		// send rows
		$set = array(
			'H' => array('legend' => 'Stats_hour_short', 'legend_fmt' => $this->date_inc, 'parms' => 'YmdH', 'nolink' => true, 'extra' => array(ANY_REGISTERED => array('list' => POST_USERS_URL, 'fmt' => 'YmdH'))),
			'd' => array('legend' => 'Stats_day_short', 'legend_fmt' => $this->date_inc, 'parms' => 'Ymd', 'extra' => array(ANY_REGISTERED => array('list' => POST_USERS_URL, 'fmt' => 'Ymd'))),
			'Ym' => array('legend' => 'Stats_month_short', 'legend_fmt' => $this->date_inc, 'parms' => 'Ym', 'extra' => array(ANY_REGISTERED => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
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

class stats_visit_users extends stats_visit
{
	function read()
	{
		global $db, $user;

		$this->data = array();
		$this->total = array(ANY_REGISTERED => 0, ANONYMOUS => 0);
		$this->sum = 0;

		// get users
		$user_fields = $user->pool_fields;
		$sql = 'SELECT s.user_id, SUM(s.stat_visit) AS sum_stat_visit' . ($user->pool_fields ? ', u.' . implode(', u.', $user_fields) : '') . '
					FROM ' . STATS_VISIT_TABLE . ' s
						LEFT JOIN ' . USERS_TABLE . ' u
							ON u.user_id = s.user_id AND u.user_regdate <= s.stat_time
					WHERE s.stat_time BETWEEN ' . intval($this->date_min) . ' AND ' . (intval($this->date_max) - 1) . '
					GROUP BY s.user_id' . ($user->pool_fields ? ', u.' . implode(', u.', $user_fields) : '') . '
					ORDER BY u.username, s.user_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->sum += intval($row['sum_stat_visit']);
			if ( intval($row['user_id']) == ANONYMOUS )
			{
				$this->total[ANONYMOUS] = intval($row['sum_stat_visit']);
			}
			else
			{
				$this->total[ANY_REGISTERED] += intval($row['sum_stat_visit']);
				$row['stat_visit'] = intval($row['sum_stat_visit']);
				unset($row['sum_stat_visit']);
				foreach ( $row as $key => $val )
				{
					if ( !is_string($key) )
					{
						unset($row[$key]);
					}
				}
				$this->data[ intval($row['user_id']) ] = $row;
			}
		}
		$db->sql_freeresult($result);
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

			'L_NO_CONNECTED' => $user->lang('Stats_no_connected'),
			'L_PROFILE_VISIT' => $user->lang('Stats_profile_visit'),
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
			foreach ( $this->data as $user_id => $row )
			{
				$username = empty($row['username']) ? $user->lang('Stats_user_deleted') : $row['username'];

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
					'USER_VISIT'=> $row['stat_visit'],
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
		FOCUSED_USER => array('legend' => 'Stats_user'),
	);
}
$cells += array(
	ANY_REGISTERED => array('legend' => 'Stats_registered'),
	ANONYMOUS => array('legend' => 'Stats_guests'),
);

if ( $parms['list'] == POST_USERS_URL )
{
	$stats = new stats_visit_users($requester, $parms, $cells, $date_min, $date_max, $date_inc);
}
else
{
	$stats = new stats_visit($requester, $parms, $cells, $date_min, $date_max, $date_inc);
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