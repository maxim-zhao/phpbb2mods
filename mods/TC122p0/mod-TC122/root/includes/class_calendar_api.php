<?php
/***************************************************************************
 *                            class_calendar_api.php
 *                            ----------------------
 *	begin			: 02/08/2003
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 1.2.1 - 19/05/2006
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

class calendar_api
{
	var $days_in_month;
	var $elapsed_days;
	var $monthes_list;
	var $days_list;

	var $format_short; // Ym
	var $format_medium; // Ymd
	var $format_long; // Ymd Hi
	var $timezone;
	var $set;

	function calendar_api()
	{
		$this->days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		$this->elapsed_days = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365);
		$this->monthes_list = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$this->days_list = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

		$this->format_short = '';
		$this->format_medium = '';
		$this->format_long = '';
		$this->timezone = 0;
		$this->set = false;
	}

	function set()
	{
		global $user;

		if ( $this->set )
		{
			return;
		}
		$this->timezone = doubleval($user->data['user_timezone']) + intval($user->data['user_dst']);
		$this->format_long = $user->data['user_dateformat'];
		$this->format_medium = isset($user->data['user_dateformat_med']) ? $user->data['user_dateformat_med'] : $user->lang('DATE_FORMAT');
		$order = $this->get_time_order();
		$this->format_short = $order['m'] < $order['y'] ? 'F Y' : 'Y F';
		$this->set = true;
	}

	function format_day_short($fmt='')
	{
		// used to format board header week row day title
		$d = 'D';
		$fmt = trim(str_replace(array('D', 'l'), array($d, $d), (empty($fmt) ? $this->format_medium : $fmt)));
		return (strpos(' ' . $fmt, $d) ? '' : $d . ' ') . $fmt;
	}

	function format_day_long($fmt='')
	{
		// used to format overview day title in schedular, month boxes
		$m = 'F';
		$d = 'l';
		$fmt = trim(str_replace(array('m', 'M', 'n', 'F', 'D', 'l'), array($m, $m, $m, $m, $d, $d), (empty($fmt) ? $this->format_medium : $fmt)));
		return (strpos(' ' . $fmt, $d) ? '' : $d . ', ') . $fmt;
	}

	function format_month_long($fmt='')
	{
		// used to format birthday dates
		$m = 'F';
		$y = 'Y';
		return trim(str_replace(array('m', 'M', 'n', 'F', 'y', 'Y'), array($m, $m, $m, $m, $y, $y), (empty($fmt) ? $this->format_medium : $fmt)));
	}

// ------------------------
//
// ANSI formated date apis
//
// ------------------------

	function cast($h, $i=0, $s=0, $m=0, $d=0, $y=0)
	{
		return is_array($h) ?
			array('h' => intval($h['h']), 'i' => intval($h['i']), 's' => intval($h['s']), 'm' => intval($h['m']), 'd' => intval($h['d']), 'y' => intval($h['y'])) :
			array('h' => intval($h), 'i' => intval($i), 's' => intval($s), 'm' => intval($m), 'd' => intval($d), 'y' => intval($y));
	}

	function translate($str_date)
	{
		global $user;
		return !empty($str_date) && ($user->lang_used != 'english') && !empty($user->global_lang['datetime']) && is_array($user->global_lang['datetime']) ? strtr($str_date, $user->global_lang['datetime']) : $str_date;
	}

	function date_to_parms($xtime, $with_hour=false)
	{
		$parms['y'] = ($xtime['y'] < 0 ? '-' : '') . abs(intval($xtime['y']));
		if ( intval($xtime['m']) )
		{
			$parms['m'] = intval($xtime['m']);
			if ( intval($xtime['d']) )
			{
				$parms['d'] = intval($xtime['d']);
				if ( $with_hour )
				{
					$xtime['h'] = intval($xtime['h']);
				}
			}
		}
		return $parms;
	}

	function get_time_order($fmt='')
	{
		if ( empty($fmt) )
		{
			$fmt = $this->format_long;
		}
		$date_fmt = ' ' . trim(str_replace('r', 'D, d M Y H:i:s O', $fmt));
		$rep = array(
			'y' => array('y', 'Y'),
			'm' => array('m', 'M', 'n', 'F'),
			'd' => array('d', 'j'),
			'D' => array('D', 'l'),
			'h' => array('h', 'H', 'g', 'G'),
			'i' => array('i'),
			'a' => array('a', 'A'),
		);
		$format = array();
		$order = array();
		foreach ( $rep as $key => $code_list )
		{
			foreach ( $code_list as $dummy => $code )
			{
				if ( !isset($order[$key]) && ($pos = strpos($fmt, $code)) )
				{
					$order[$key] = $pos;
					$format[$key] = $code;
				}
			}
		}

		// add missing keys to end
		$force_order = array('y', 'm', 'd', 'h', 'i', 's', 'a');
		$prev_order = count($order);
		foreach ( $force_order as $dummy => $comp )
		{
			if ( !isset($order[$comp]) && (($comp != 'a') || (strtolower($format['h']) == 'g')) )
			{
				$order[$comp] = $prev_order;
			}
			$prev_order = $order[$comp];
		}
		asort($order);
		return array_flip(array_keys($order));
	}

	function adjust_time($h, $i=0, $s=0, $m=0, $d=0, $y=0)
	{
		$xtime = $this->cast($h, $i, $s, $m, $d, $y);
		$this->adjust_time_component($xtime, 's', 'i', 60);
		$this->adjust_time_component($xtime, 'i', 'h', 60);
		$this->adjust_time_component($xtime, 'h', 'd', 24);
		$this->adjust_time_component($xtime, 'm', 'y', 12, 1);

		// days
		$max_day = $this->days_in_month($xtime);
		while ( ($xtime['d'] <= 0) || ($xtime['d'] > $max_day) )
		{
			if ( $xtime['d'] <= 0 )
			{
				$xtime['m']--;
				if ( $xtime['m'] == 0 )
				{
					$xtime['m'] = 12;
					$xtime['y']--;
				}
				$max_day = $this->days_in_month($xtime);
				$xtime['d'] = $max_day + $xtime['d'];
			}
			else if ( $xtime['d'] > $max_day )
			{
				$xtime['d'] = $xtime['d'] - $max_day;
				$xtime['m']++;
				if ( $xtime['m'] > 12 )
				{
					$xtime['m'] = 01;
					$xtime['y']++;
				}
				$max_day = $this->days_in_month($xtime);
			}
		}
		return $xtime;
	}

	function adjust_time_component(&$xtime, $minor, $major, $max, $min=0)
	{
		if ( $min )
		{
			$xtime[$minor]--;
		}
		if ( ($xtime[$minor] < 0) || ($xtime[$minor] > ($max - 1)) )
		{
			$xtime[$major] += intval($xtime[$minor] / $max);
			$xtime[$minor] = $xtime[$minor] % $max;
			if ( $xtime[$minor] < 0 )
			{
				$xtime[$minor] += $max;
				$xtime[$major]--;
			}
		}
		if ( $min )
		{
			$xtime[$minor]++;
		}
	}

	function is_leap($xtime)
	{
		return (intval($xtime['y']) > 1582) && !($xtime['y'] % 4) && (($xtime['y'] % 100) || !($xtime['y'] % 400));
	}

	function days_in_month($xtime)
	{
		return $this->days_in_month[ (intval($xtime['m']) - 1) ] + ((intval($xtime['m']) == 2) && $this->is_leap($xtime) ? 1 : 0);
	}

	function is_unix($h, $i=0, $s=0, $m=0, $d=0, $y=0)
	{
		$xtime = $this->adjust_time($h, $i, $s, $m, $d, $y);
		return (intval($xtime['y']) >= 1970) && (intval($xtime['y']) <= 2037);
	}

	function checkdate($h, $i=0, $s=0, $m=0, $d=0, $y=0)
	{
		$xtime = $this->cast($h, $i, $s, $m, $d, $y);
		return (!$xtime['m'] || (max(1, min(12, $xtime['m'])) == intval($xtime['m']))) && (!$xtime['d'] || ($xtime['m'] && (max(1, min($this->days_in_month($xtime), $xtime['d'])) == intval($xtime['d'])))) && ((!$xtime['d'] && !$xtime['h'] && !$xtime['i'] && !$xtime['s']) || $this->checktime($xtime));
	}

	function checktime($xtime)
	{
		return (max(0, min(23, $xtime['h'])) == intval($xtime['h'])) && (max(0, min(59, $xtime['i'])) == intval($xtime['i'])) && (max(0, min(59, $xtime['s'])) == intval($xtime['s']));
	}

	function day_of_week($xtime)
	{
		$xtime = $this->cast($xtime);
		if ( $this->is_unix($xtime) )
		{
			$res = date('w', mktime($xtime['h'], $xtime['i'], $xtime['s'], $xtime['m'], $xtime['d'], $xtime['y']));
		}
		// the first of year 2000 was a saturday (6)
		else if ( $xtime['y'] < 2000 )
		{
			$nb_years = 2000 - max(1582, $xtime['y']);
			$nb_bissext = intval($nb_years / 4);
			$nb_bissext -= intval($nb_years / 100);
			$nb_bissext += intval($nb_years / 400);
			$nb_years = 2000 - $xtime['y'];
			$days_in_year = $this->elapsed_days[ ($xtime['m'] - 1) ] + $xtime['d'] - 1 + (($xtime['m'] > 2) && $this->is_leap($xtime) ? 1 : 0);
			$res = (7 - (($nb_years * 365.0 + $nb_bissext + 1 - $days_in_year) % 7)) % 7;
		}
		else
		{
			$nb_years = $xtime['y'] - 2000;
			$nb_bissext = intval(($nb_years - 1) / 4) + 1;
			$nb_bissext -= intval(($nb_years - 1) / 100);
			$nb_bissext += intval(($nb_years - 1) / 400);
			$days_in_year = $this->elapsed_days[ ($xtime['m'] - 1) ] + $xtime['d'] - 1 + (($xtime['m'] > 2) && $this->is_leap($xtime) ? 1 : 0);
			$res = ($nb_years * 365.0 + $nb_bissext - 1 + $days_in_year) % 7;
		}
		return $res;
	}

	// Y & y works slightly differently than usual
	//    Y : not justify year, BC add if negative : eg: 500 BC for year = -500
	//    y : will be preceeded with - if negative : eg: -0500, -40000, 2000
	function date($fmt, $h, $i=0, $s=0, $m=0, $d=0, $y=0)
	{
		$xtime = $this->adjust_time($h, $i, $s, $m, $d, $y);
		if ( $this->is_unix($xtime) )
		{
			return $this->translate(@gmdate(str_replace('y', 'Y', $fmt), @gmmktime($xtime['h'], $xtime['i'], $xtime['d'], $xtime['m'], $xtime['d'], $xtime['y'])));
		}

		$comp = array('a', 'A', 'B', 'd', 'D', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'l', 'L', 'm', 'M', 'n', 'O', 'r', 's', 'S', 't', 'T', 'U', 'w', 'W', 'y', 'Y', 'z', 'Z');
		$fmt = preg_replace('/(' . implode('|', $comp) . ')/', '[\1]', trim(str_replace('r', 'D, d M Y H:i:s O', $fmt)));
		$match = array();
		preg_match_all('/\[([a-zA-Z])\]/', $fmt, $match);
		if ( empty($match[1]) )
		{
			return $match[0];
		}
		$replace = array();
		foreach ( $match[1] as $dummy => $pattern )
		{
			switch ( $pattern )
			{
				case 'a':
					$replace['[a]'] = $xtime['h'] < 12 ? 'am' : 'pm';
					break;
				case 'A':
					$replace['[A]'] = $xtime['h'] < 12 ? 'AM' : 'PM';
					break;
				case 'd':
					$replace['[d]'] = sprintf('%02d', $xtime['d']);
					break;
				case 'D':
					$replace['[D]'] = substr($this->days_list[ $this->day_of_week($xtime) ], 0, 3);
					break;
				case 'F':
					$replace['[F]'] = $this->monthes_list[ ($xtime['m'] - 1) ];
					break;
				case 'g':
					$h = $xtime['h'] % 12;
					$replace['[g]'] = !$h ? 12 : $h;
					break;
				case 'G':
					$replace['[G]'] = $xtime['h'];
					break;
				case 'h':
					$h = $xtime['h'] % 12;
					$replace['[h]'] = sprintf('%02d', !$h ? 12 : $h);
					break;
				case 'H':
					$replace['[H]'] = sprintf('%02d', $xtime['h']);
					break;
				case 'i':
					$replace['[i]'] = sprintf('%02d', $xtime['i']);
					break;
				case 'j':
					$replace['[j]'] = $xtime['d'];
					break;
				case 'l':
					$replace['[l]'] = $this->days_list[ $this->day_of_week($xtime) ];
					break;
				case 'm':
					$replace['[m]'] = sprintf('%02d', $xtime['m']);
					break;
				case 'M':
					$replace['[M]'] = substr($this->monthes_list[ ($xtime['m'] - 1) ], 0, 3);
					break;
				case 'n':
					$replace['[n]'] = $xtime['m'];
					break;
				case 's':
					$replace['[s]'] = sprintf('%02d', $xtime['s']);
					break;
				case 'S':
					$sfx = array('st', 'nd', 'rd', 'th');
					$replace['[S]'] = $sfx[ (min($xtime['d'], count($sfx)) - 1) ];
					break;
				case 't':
					$replace['[t]'] = $this->days_in_month($xtime);
					break;
				case 'w':
					$replace['[w]'] = $this->day_of_week($xtime);
					break;
				case 'Y':
					$replace['[Y]'] = abs($xtime['y']) . ($xtime['y'] < 0 ? ' BC' : '');
					break;
				case 'y':
					$replace['[y]'] = ($xtime['y'] < 0 ? '-' : '') . str_pad(abs($xtime['y']), 4, '0', STR_PAD_LEFT);
					break;
				case 'L':
					$replace['[L]'] = $this->is_leap($xtime) ? 1 : 0;
					break;
				case 'z':
					$replace['[z]'] = $xtime['d'] - 1 + $this->elapsed_days[ $xtime['m'] ] + ($this->is_leap($xtime) && ($xtime['m'] >= 3) ? 1 : 0);
					break;
				case 'B':
					$now = explode(', ', date('m, d, Y'));
					$replace['[B]'] = date('B', $xtime['h'], $xtime['i'], $xtime['s'], $now[0], $now[1], $now[2]);
					break;
				case 'I':
					$replace['[I]'] = date('I');
					break;
				case 'O':
					$replace['[O]'] = date('O');
					break;
				case 'T':
					$replace['[T]'] = date('T');
					break;
				case 'Z':
					$replace['[Z]'] = date('Z');
					break;

				case 'U':
				case 'W':
					$replace['[' . $pattern . ']'] = '';
					break;
			}
		}
		return $this->translate(strtr($fmt, $replace));
	}

	// $date has format : [-]YYYYMMDD
	function explode_date($str_date)
	{
		$ac = 1;
		if ( substr($str_date, 0, 1) == '-' )
		{
			$ac = -1;
			$str_date = substr($str_date, 1);
		}
		$day = intval(substr($str_date, strlen($str_date) - 2));
		$str_date = substr($str_date, 0, -2);
		$month = intval(substr($str_date, strlen($str_date) - 2));
		$year = intval(substr($str_date, 0, -2));
		$xtime = array(
			'm' => $month,
			'd' => $day,
			'y' => $ac * $year,
		);
		return $this->checkdate($xtime) ? $xtime : array();
	}

	// return value has format [-]YYYYMMDD
	function implode_date($h, $i=0, $s=0, $m=0, $d=0, $y=0)
	{
		$xtime = $this->cast($h, $i, $s, $m, $d, $y);
		return ($xtime['y'] < 0 ? '-' : '') . str_pad((string) abs($xtime['y']), 4, '0', STR_PAD_LEFT) . sprintf('%02d%02d', $xtime['m'], $xtime['d']);
	}

	function is_eq($xdate1, $xdate2)
	{
		return $this->cast($xdate1) == $this->cast($xdate2);
	}

	function is_ne($xdate1, $xdate2)
	{
		return !$this->is_eq($xdate1, $xdate2);
	}

	function is_gt($xdate1, $xdate2)
	{
		if ( $xdate1['y'] != $xdate2['y'] )
		{
			return $xdate1['y'] > $xdate2['y'] ? $xdate1 : $xdate2;
		}
		$d1 = sprintf('%02d%02d%02d%02d%02d', $xdate1['m'], $xdate1['d'], $xdate1['h'], $xdate1['i'], $xdate1['s']);
		$d2 = sprintf('%02d%02d%02d%02d%02d', $xdate2['m'], $xdate2['d'], $xdate2['h'], $xdate2['i'], $xdate2['s']);
		return $d1 > $d2;
	}

	function is_ge($xdate1, $xdate2)
	{
		return $this->is_eq($xdate1, $xdate2) || $this->is_gt($xdate1, $xdate2);
	}

	function is_le($xdate1, $xdate2)
	{
		return !$this->is_gt($xdate1, $xdate2);
	}

	function is_lt($xdate1, $xdate2)
	{
		return $this->is_gt($xdate2, $xdate1);
	}

	function min($xdate1, $xdate2)
	{
		return $this->is_gt($xdate2, $xdate1) ? $xdate1 : $xdate2;
	}

	function max($xdate1, $xdate2)
	{
		return $this->is_gt($xdate1, $xdate2) ? $xdate1 : $xdate2;
	}

// -----------------------
//
// unix formated date apis
//
// -----------------------

	function user_to_sys($xtime)
	{
		$xtime = $this->cast($xtime);
		return @gmmktime($xtime['h'], $xtime['i'], $xtime['s'] - ($this->timezone * 3600), $xtime['m'], $xtime['d'], $xtime['y']);
	}

	function sys_to_user($time)
	{
		// split the time
		$xtime = array();
		if ( !empty($time) )
		{
			$xtime = explode(', ', @gmdate('Y, m, d, H, i', $time + (3600 * $this->timezone)));
			$xtime = array('y' => intval($xtime[0]), 'm' => intval($xtime[1]), 'd' => intval($xtime[2]), 'h' => intval($xtime[3]), 'i' => intval($xtime[4]));
		}
		return $this->cast($xtime);
	}

	function explode_duration($duration)
	{
		$xduration = array('dd' => 0, 'dh' => 0, 'di' => 0, 'ds' => 0);
		if ( $duration )
		{
			$xduration['dd'] = intval($duration / 86400);
			$duration = $duration % 86400;
			$xduration['dh'] = intval($duration / 3600);
			$duration = $duration % 3600;
			$xduration['di'] = intval($duration / 60);
			$xduration['ds'] = $duration % 60;
		}
		return $xduration;
	}
}

class front_calendar
{
	function topic_title($tpl_level, $time=0, $duration=0)
	{
		global $template, $user;
		global $calendar_api;

		$template->assign_vars(array(
			'L_CALENDAR_EVENT' => $user->lang('Calendar_event'),
		));

		if ( $time )
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'calendar_event', array(
				'S_CALENDAR_EVENT' => $this->title($time, $duration),
			));
		}
		else
		{
			$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'calendar_event_ELSE', array());
		}
		return $time ? true : false;
	}

	function title($time, $duration)
	{
		global $user, $calendar_api;

		if ( $time )
		{
			$calendar_api->set();
			$xstart = $calendar_api->sys_to_user($time);
			$nb = 0;
			$xend = array();
			$fmt = $xstart['h'] || $xstart['i'] || $xstart['s'] ? $calendar_api->format_long : $calendar_api->format_medium;
			$duration_user = $duration + 1;
			if ( empty($duration) )
			{
				$xend = $xstart;
				$lang_key = 'Calendar_from';
			}
			else if ( ($duration_user < 86400) && !($duration_user % 3600) )
			{
				$nb = intval($duration_user / 3600);
				$lang_key = $nb == 1 ? 'Calendar_one_hour' : 'Calendar_many_hours';
			}
			else if ( !($duration_user % 86400) )
			{
				$nb = intval($duration_user / 86400);
				$lang_key = $nb == 1 ? 'Calendar_one_day' : 'Calendar_many_days';
			}
			else
			{
				$xend = $calendar_api->adjust_time($xstart['h'], $xstart['i'], $xstart['s'] + $duration, $xstart['m'], $xstart['d'], $xstart['y']);
				$fmt = $xstart['h'] || $xstart['i'] || $xstart['s'] || $xend['h'] || $xend['i'] || $xsend['s'] ? $calendar_api->format_long : $calendar_api->format_medium;
				$lang_key = 'Calendar_from_to';
			}
		}
		return $time ? sprintf($user->lang($lang_key), $calendar_api->date($fmt, $xstart), empty($xend) ? $nb : $calendar_api->date($fmt, $xend)) : false;
	}
}

// --------------------
//
// instantiate the api
//
// --------------------
$calendar_api = new calendar_api();

?>