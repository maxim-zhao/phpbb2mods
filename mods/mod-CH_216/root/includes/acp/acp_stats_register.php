<?php
//
//	file: includes/acp/acp_stats_register.php
//	author: ptirhiik
//	begin: 03/02/2006
//	version: 1.6.1 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

define('ACTIVE', 1);
define('NOT_ACTIVE', 0);

include($config->url('includes/class_stats_admin'));
include($config->url('includes/class_stats'));

$cp_title = 'Stats_register';
$cp_title_explain = 'Stats_register_explain';

$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);

//
// classes
//

class stats_register extends stats_admin
{
	var $date_min;
	var $date_max;
	var $date_inc;
	var $span_all;

	function stats_register($requester, $parms, $cells, $date_min, $date_max, $date_inc)
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
		$this->total = array(ACTIVE => 0, NOT_ACTIVE => 0);
		$this->data = array();

		$date_inc = $this->date_inc == '_' ? 'H' : $this->date_inc;
		$time_max = $this->date_max;
		$time_min = $this->date_minus($time_max, $date_inc);
		while ( $time_min >= $this->date_min )
		{
			$key = date($date_inc, $time_min);

			$sql = 'SELECT user_active, COUNT(user_id) AS count_ids
						FROM ' . USERS_TABLE . '
						WHERE user_regdate BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . '
							AND user_id <> ' . ANONYMOUS . '
						GROUP BY user_active';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$active = $row['user_active'] ? ACTIVE : NOT_ACTIVE;
				if ( !isset($this->data[$key]) )
				{
					$this->data[$key] = array(ACTIVE => 0, NOT_ACTIVE => 0);
				}
				$this->data[$key][$active] += intval($row['count_ids']);
				$this->total[$active] += intval($row['count_ids']);
				$this->sum += intval($row['count_ids']);
			}
			$db->sql_freeresult($result);

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
			'H' => array('legend' => 'Stats_day', 'legend_fmt' => 'Ymd', 'parms' => 'Ymd', 'nolink' => true, 'extra' => array(ACTIVE => array('list' => POST_USERS_URL, 'fmt' => 'YmdH'))),
			'd' => array('legend' => 'Stats_month', 'legend_fmt' => 'Ym', 'parms' => 'Ym', 'nolink' => true, 'extra' => array(ACTIVE => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
			'Ym' => array('legend' => 'Stats_year', 'legend_fmt' => '', 'parms' => '', 'nolink' => true, 'extra' => array(ACTIVE => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
		);
		$this->display_a_bar(true, $this->date_min, $set[$this->date_inc], $this->total);
		$template->set_switch('row.title');

		// send rows
		$set = array(
			'H' => array('legend' => 'Stats_hour_short', 'legend_fmt' => $this->date_inc, 'parms' => 'YmdH', 'nolink' => true, 'extra' => array(ACTIVE => array('list' => POST_USERS_URL, 'fmt' => 'YmdH'))),
			'd' => array('legend' => 'Stats_day_short', 'legend_fmt' => $this->date_inc, 'parms' => 'Ymd', 'extra' => array(ACTIVE => array('list' => POST_USERS_URL, 'fmt' => 'Ymd'))),
			'Ym' => array('legend' => 'Stats_month_short', 'legend_fmt' => $this->date_inc, 'parms' => 'Ym', 'extra' => array(ACTIVE => array('list' => POST_USERS_URL, 'fmt' => 'Ym'))),
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

class stats_register_users extends stats_register
{
	function read()
	{
		global $db, $user;

		// get data
		$user_fields = $user->pool_fields;
		$this->sum = 0;
		$this->total = array(ACTIVE => 0, NOT_ACTIVE => 0);
		$this->data = array();

		$date_inc = $this->date_inc == '_' ? 'H' : $this->date_inc;
		$time_max = $this->date_max;
		$time_min = $this->date_minus($time_max, $date_inc);
		while ( $time_min >= $this->date_min )
		{
			$key = date($date_inc, $time_min);

			$sql = 'SELECT user_active, user_id' . ($user->pool_fields ? ', ' . implode(', ', $user_fields) : '') . '
						FROM ' . USERS_TABLE . '
						WHERE user_regdate BETWEEN ' . intval($time_min) . ' AND ' . (intval($time_max) - 1) . '
							AND user_id <> ' . ANONYMOUS . '
						ORDER BY user_active, username';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$active = $row['user_active'] ? ACTIVE : NOT_ACTIVE;
				$user_id = intval($row['user_id']);
				foreach ( $row as $key => $val )
				{
					if ( !is_string($key) )
					{
						unset($row[$key]);
					}
				}
				if ( !isset($this->data[$user_id]) )
				{
					$this->data[$user_id] = $row;
				}
				$this->total[$active]++;
				$this->sum++;
			}
			$db->sql_freeresult($result);

			// next range
			$time_max = $time_min;
			$time_min = $this->date_minus($time_min, $date_inc);
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

			'L_NO_CONNECTED' => $user->lang('Stats_no_registration'),
			'L_PROFILE_VISIT' => $user->lang('Stats_view_registration'),
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
				$template->assign_block_vars('users.connected', array(
					'STYLE' => $user_style,
					'USERNAME' => $username,
					'U_USERNAME' => $config->url('usercp', array(POST_USERS_URL => intval($row['user_id'])), true),
					'USER_VISIT'=> $row['user_active'] ? $user->lang('Stats_is_active') : $user->lang('Stats_is_not_active'),
				));
				$template->set_switch('users.connected.link', $row['username']);
				$template->set_switch('users.connected.first', $first);
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

// get display type
$list = _read('list', TYPE_NO_HTML, '', array('' => '', POST_USERS_URL => ''));
if ( $list )
{
	$parms['list'] = POST_USERS_URL;
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
$cells += array(
	ACTIVE => array('legend' => 'Stats_active'),
	NOT_ACTIVE => array('legend' => 'Stats_not_active'),
);

if ( $parms['list'] == POST_USERS_URL )
{
	$stats = new stats_register_users($requester, $parms, $cells, $date_min, $date_max, $date_inc);
}
else
{
	$stats = new stats_register($requester, $parms, $cells, $date_min, $date_max, $date_inc);
}
$stats->read();
$stats->display();

// constants
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