<?php
/***************************************************************************
 *                            class_calendar_posting.php
 *                            --------------------------
 *	begin			: 02/08/2003
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 1.2.0 - 12/04/2006
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
	die("Hacking attempt");
}

class calendar_form
{
	var $requester;
	var $parms;

	var $form_fields;
	var $time;
	var $duration;

	var $is_auth;
	var $first_post;

	function calendar_form($requester, $parms='', &$is_auth, $first_post)
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;

		$this->is_auth = &$is_auth;
		$this->first_post = $first_post;
		$this->time = 0;
		$this->duration = 0;
		$this->form_fields = array(
			'y' => 'topic_calendar_year',
			'm' => 'topic_calendar_month',
			'd' => 'topic_calendar_day',
			'h' => 'topic_calendar_hour',
			'i' => 'topic_calendar_min',
			'dd' => 'topic_calendar_duration_day',
			'dh' => 'topic_calendar_duration_hour',
			'di' => 'topic_calendar_duration_min',
		);
	}

	function force_auth(&$auth_field, $mode)
	{
		if ( !$this->first_post )
		{
			return;
		}
		if ( ($mode == 'newtopic') && $this->time && $this->is_auth[$auth_field] && !$this->is_auth['auth_cal'] )
		{
			$auth_field = 'auth_cal';
		}
	}

	// get form values and remove user timestamp from event start
	function read_from_form()
	{
		global $error_msg;
		global $user;
		global $calendar_api;
		global $HTTP_POST_VARS;

		if ( !$this->first_post || !isset($HTTP_POST_VARS[ $this->form_fields['y'] ]) || !$this->is_auth['auth_cal'] )
		{
			return;
		}

		// var/form fields
		$fields = array();
		foreach ( $this->form_fields as $key => $tpl_var )
		{
			$fields[$key] = intval($HTTP_POST_VARS[$tpl_var]);
		}
		if ( ($fields['y'] <= 0) || ($fields['m'] <= 0) || ($fields['d'] <= 0) )
		{
			$this->time = 0;
			$this->duration = 0;
			return;
		}
		if ( ($fields['h'] < 0) || ($fields['i'] < 0) )
		{
			$fields['h'] = $fields['i'] = $fields['dh'] = $fields['di'] = 0;
		}
		$fields['h'] = min($fields['h'], 23);
		$fields['i'] = min($fields['i'], 59);
		$fields['dd'] = max($fields['dd'], 0);
		$fields['dh'] = max($fields['dh'], 0);
		$fields['di'] = max($fields['di'], 0);

		// check date
		if ( !checkdate($fields['m'], $fields['d'], $fields['y']) || ($fields['y'] <= 1970) || ($fields['y'] > 2037) )
		{
			$error_msg = (empty($error_msg) ? '' : '<br />') . sprintf($user->lang('Date_error'), $day, $month, $year);
		}

		// turn input values to fields values
		$this->time = $calendar_api->user_to_sys($fields);
		$this->duration = $this->time ? max(0, $fields['dd'] * 86400 + $fields['dh'] * 3600 + $fields['di'] * 60) : 0;
		if ( $this->duration )
		{
			$this->duration--;
		}
	}

	function read($data)
	{
		if ( !$this->first_post )
		{
			return;
		}
		$this->time = 0;
		$this->duration = 0;

		// get data from db
		if ( isset($data['topic_calendar_time']) )
		{
			$this->time = max(0, intval($data['topic_calendar_time']));
			$this->duration = max(0, intval($data['topic_calendar_duration']));
		}

		// get data from form
		$this->read_from_form();

		if ( !$this->time )
		{
			$this->duration = 0;
		}
	}

	function validate($topic_id)
	{
		global $db;

		if ( !$this->first_post || !$this->is_auth['auth_cal'] )
		{
			return;
		}
		$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET topic_calendar_time = ' . intval($this->time) . ',
						topic_calendar_duration = ' . intval($this->duration) . '
					WHERE topic_id = ' . intval($topic_id);
		$db->sql_query($sql);
	}

	function display($tpl_switch='')
	{
		global $template, $user;
		global $calendar_api;

		if ( !$this->first_post || !$this->is_auth['auth_cal'] )
		{
			return;
		}

		// explode the time in components (per default : beginning of the day)
		$duration = $this->duration;
		if ( $this->time && $this->duration )
		{
			$duration++;
		}
		$xtime = $calendar_api->sys_to_user($this->time);
		$xduration = $calendar_api->explode_duration($duration);

		// do some adjustement for 0/-1 value
		if ( !$xtime['y'] || !$xtime['m'] || !$xtime['d'] )
		{
			$xtime['y'] = -1;
			$xtime['m'] = -1;
			$xtime['d'] = -1;
			$xtime['h'] = -1;
			$xtime['i'] = -1;
		}
		else if ( !$xduration['dh'] && !$xduration['di'] && !$xtime['h'] && !$xtime['i'] )
		{
			$xtime['h'] = -1;
			$xtime['i'] = -1;
		}

		// get the order and the hour format
		$order = $calendar_api->get_time_order($calendar_api->format_long);

		// build the drop down lists
		foreach ( $order as $key => $dummy )
		{
			$options = false;
			switch ( $key )
			{
				case 'y':
					$options = $this->count_list($xtime[$key], 1970, 2037, '%04d');
					break;
				case 'm':
					$options = $this->month_list($xtime[$key]);
					break;
				case 'd':
					$options = $this->count_list($xtime[$key], 1, 31, '%02d');
					break;
				case 'h':
					$options = $this->hour_list($xtime[$key], isset($order['a']) ? 'h a' : 'H');
					break;
				case 'i':
					$options = $this->count_list($xtime[$key], 0, 59, '%02d');
					break;
			}
			if ( $options )
			{
				$template->assign_block_vars('calendar_list', array(
					'NAME' => $this->form_fields[$key],
					'OPTIONS' => $options,
				));
				$template->assign_block_vars('calendar_list.time' . (in_array($key, array('h', 'i')) ? '' : '_ELSE'), array());
			}
			unset($options);
		}

		// quick js links
		$xtoday = $calendar_api->sys_to_user(time());
		$js_links = array(
			array('txt' => 'Today', 'time' => $calendar_api->adjust_time(0, 0, 0, $xtoday['m'], $xtoday['d'], $xtoday['y'])),
			array('txt' => '7_Days', 'time' => $calendar_api->adjust_time(0, 0, 0, $xtoday['m'], $xtoday['d'] + 7, $xtoday['y'])),
			array('txt' => '1_Month', 'time' => $calendar_api->adjust_time(0, 0, 0, $xtoday['m'] + 1, $xtoday['d'], $xtoday['y'])),
		);
		foreach ( $js_links as $i => $def )
		{
			if ( $def['time'] )
			{
				$template->assign_block_vars('calendar_qlink', array(
					'L_QLINK' => $user->lang($def['txt']),
					'Y_QLINK' => $def['time']['y'],
					'M_QLINK' => $def['time']['m'],
					'D_QLINK' => $def['time']['d'],
				));
				$template->assign_block_vars('calendar_qlink.first' . ($i ? '_ELSE' : ''), array());
			}
		}

		// other
		$template->assign_vars(array(
			'L_CALENDAR_TITLE' => $user->lang('Calendar_event'),
			'L_CALENDAR_TIME' => $user->lang('Event_time'),
			'L_CALENDAR_DURATION' => $user->lang('Calendar_duration'),

			'CALENDAR_DURATION_DAY' => $xduration['dd'] ? $xduration['dd'] : '',
			'CALENDAR_DURATION_HOUR' => $xduration['dd'] || $xduration['dh'] || $xduration['di'] ? $xduration['dh'] : '',
			'CALENDAR_DURATION_MIN' => $xduration['dd'] || $xduration['dh'] || $xduration['di'] ? $xduration['di'] : '',

			'L_DAYS' => $user->lang('Days'),
			'L_HOURS' => $user->lang('Hours'),
			'L_MINUTES' => $user->lang('Minutes'),

			'L_TODAY' => $user->lang('Today'),
			'L_NEXT_WEEK' => $user->lang('7_Days'),
			'L_NEXT_MONTH' => $user->lang('1_Month'),
		));
		$template->set_filenames(array('calendar_posting_form' => 'calendar_posting_form.tpl'));
		$template->assign_var_from_handle('CALENDAR_FORM', 'calendar_posting_form');
	}

	function count_list($value, $from, $to, $mask)
	{
		$selected = $value == -1 ? ' selected="selected"' : '';
		$len = strlen(sprintf($mask, $to));
		$options = "\n" . '<option value="-1"' . $selected . '> ' . str_pad('', $len, '-') . ' </option>';
		for ( $i = $from; $i <= $to; $i++ )
		{
			$selected = $value == $i ? ' selected="selected"' : '';
			$options .= "\n" . '<option value="' . $i . '"' . $selected . '>' . sprintf($mask, $i) . '</option>';
		}
		return $options;
	}

	function month_list($value)
	{
		global $calendar_api;

		$monthes = array_merge(array(' ------------- '), $calendar_api->monthes_list);
		$options = '';
		foreach ( $monthes as $i => $str )
		{
			$selected = $value == $i ? ' selected="selected"' : '';
			$options .= "\n" . '<option value="' . $i . '"' . $selected . '>' . $calendar_api->translate($str) . '</option>';
		}
		return $options;
	}

	function hour_list($value, $h_format)
	{
		global $calendar_api;

		// 1st januar has always 24 hours a day
		$basetime = mktime(0, 0, 0, 01, 01, 2006);

		$selected = ($value == -1) ? ' selected="selected"' : '';
		$options = "\n" . '<option value="-1"' . $selected . '> ---- </option>';
		for ( $i = 0; $i < 24; $i++ )
		{
			$selected = $value == $i ? ' selected="selected"' : '';
			$options .= "\n" . '<option value="' . $i . '"' . $selected . '> ' . $calendar_api->translate(date($h_format, $basetime)) . ' </option>';
			$basetime += 3600;
		}
		return $options;
	}
}

?>