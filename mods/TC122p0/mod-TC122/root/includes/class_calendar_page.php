<?php
/***************************************************************************
 *                            class_calendar_page.php
 *                            -----------------------
 *	begin			: 17/04/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.1 - 17/04/2006
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

define('POST_EVENT_CAT_URL', 'ec');

class calendar_month extends calendar_handler
{
	function display()
	{
		global $template, $user;
		global $calendar_event_types, $calendar_api;

		if ( empty($calendar_event_types) || empty($this->modules) )
		{
			return false;
		}

		// main display
		$template->assign_vars(array(
			'I_UP_ARROW' => $user->img('up_arrow'),
			'I_DOWN_ARROW' => $user->img('down_arrow'),
			'I_PREVIOUS' => $user->img('cmd_previous'),
			'L_PREVIOUS' => $user->lang('Previous'),
			'I_NEXT' => $user->img('cmd_next'),
			'L_NEXT' => $user->lang('Next'),
			'L_MORE' => $user->lang('More'),
			'L_CALENDAR' => $user->lang('Calendar'),
			'I_SPACER' => $user->img('spacer'),
		));
		$template->set_switch('java', $this->settings['javascript']);
		$template->set_switch('full_month');
		$template->set_switch('full_month.java', $this->settings['javascript']);

		// init modules
		$this->set_modules();
		$this->read_selection();
		$xfrom = $calendar_api->cast($this->parms);

		$xtoday = $calendar_api->sys_to_user(time());
		$xfrom = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], 1, $xfrom['y']);
		$xto = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'] + 1, 1, $xfrom['y']);

		// get events
		$this->read($xfrom, $xto);

		// then the calendar row
		$this->display_main($xtoday, $xfrom);

		// all done, go to the main display
		$template->assign_vars(array('CALENDAR_MONTH' => $template->include_file('calendar_box.tpl', 'calendar')));
	}

	function selection_def()
	{
		$this->selection_form = array(
			'date' => array('legend' => 'Select_date', 'module_id' => -1, 'api' => 'select_date', 'parm' => 'ym'),
		);
	}

	function display_main($xselected, $xfrom)
	{
		global $template, $user, $config;
		global $calendar_api;

		$selected = $calendar_api->implode_date($xselected);
		$nb_cells = 7;
		$inc = (7 + $calendar_api->day_of_week($xfrom) - intval($this->settings['week_start'])) % 7;

		$xprevious = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'] - 1, 1, $xfrom['y']);
		$xnext = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'] + 1, 1, $xfrom['y']);
		$xprevious['d'] = $xnext['d'] = 0;

		// activate the output
		$template->assign_block_vars('calendar', array(
			'CELL_SPAN' => $nb_cells,
			'CELL_WIDTH' => floor(100 / $nb_cells),
			'U_PREVIOUS' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xprevious)), true),
			'U_NEXT' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xnext)), true),
			'TITLE' => $calendar_api->date($calendar_api->format_short, $xfrom),
		));

		// display the rest
		$template->set_switch('calendar.first');

		// ok, let's go : first, overviewes
		$this->display_overview();
		for ( $i = 0; $i < 7; $i++ )
		{
			$template->assign_block_vars('calendar.first.cell', array(
				'L_DAY' => $calendar_api->translate($calendar_api->days_list[ ((7 + intval($this->settings['week_start']) + $i) % 7) ]),
			));
			$template->set_switch('calendar.first.cell.' . (!$i ? 'left' : ($i == 6 ? 'right' : 'middle')));
		}

		if ( $inc )
		{
			$template->set_switch('calendar.row');
			$template->assign_block_vars('calendar.row.empty_cells_front', array(
				'SPAN' => $inc,
			));
		}
		$i = $inc;

		// and now the data
		foreach ( $this->map as $date_offset => $event_list )
		{
			$xtime = $calendar_api->explode_date($date_offset);

			if ( !($i % 7) )
			{
				$i = 0;
				$template->set_switch('calendar.row');
			}

			$template->assign_block_vars('calendar.row.cell', array(
				'TITLE' => $calendar_api->date($calendar_api->format_medium, $xtime),
				'U_TITLE' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xtime)), true),
				'EVENT_DATE' => $date_offset,
				'S_TOGGLE' => 'none',
				'I_TOGGLE' => $user->img('down_arrow'),
			));
			$template->set_switch('calendar.row.cell.' . (!$i ? 'left' : ($i == $nb_cells - 1 ? 'right' : 'middle')));
			$template->set_switch('calendar.row.cell.selected', $selected == $date_offset);

			$count_event_list = count($event_list);
			for ( $j = 0; $j < $count_event_list; $j++ )
			{
				if ( ($event_id = $this->get_event_id($this->map[$date_offset], $j)) && ($tpl_vars = $this->queues[ $event_id['module_id'] ]->retrieve_item($event_id)) )
				{
					$template->assign_block_vars('calendar.row.cell.event', $tpl_vars['vars']);
					if ( $tpl_vars['switches'] )
					{
						foreach ( $tpl_vars['switches'] as $switch => $value )
						{
							$template->set_switch('calendar.row.cell.event.' . $switch, $value);
						}
					}
					$template->set_switch('calendar.row.cell.event.content');
				}
				else
				{
					$template->set_switch('calendar.row.cell.event');
					$template->set_switch('calendar.row.cell.event.content', false);
				}

				// we gonna have an overflow
				if ( intval($this->settings['events_per_cell']) && ($count_event_list > $this->settings['events_per_cell']) )
				{
					$template->set_switch('calendar.row.cell.event.more', $j == $this->settings['events_per_cell'] - 1);
					$template->set_switch('calendar.row.cell.event.more_header', $j == $this->settings['events_per_cell']);
					$template->set_switch('calendar.row.cell.event.more_footer', $j == $count_event_list - 1);
				}
			}

			$i++;
		}
		if ( $i % 7 )
		{
			$template->assign_block_vars('calendar.row.empty_cells_rear', array(
				'SPAN' => 7 - ($i % 7),
			));
		}
	}
}

class calendar_month_box extends calendar_handler
{
	var $txt_overview;
	var $module_set;

	function calendar_month_box($requester='', $parms='')
	{
		parent::calendar_handler($requester, $parms);
		$this->txt_overview = array();
		$this->module_set = false;
	}

	function display($xfrom, $xto, $xselected, $xtoday)
	{
		global $template, $user;
		global $calendar_api;

		if ( empty($this->modules) )
		{
			return false;
		}

		// init modules
		if ( !$this->module_set )
		{
			$this->set_modules();
			$this->module_set = true;
		}

		// get events
		$this->read($xfrom, $xto, false);

		// then the calendar row
		$this->display_main($xtoday, $xselected);
	}

	function display_main($xtoday, $xselected)
	{
		global $template, $user, $config;
		global $calendar_api;

		$date_today = $calendar_api->implode_date($xtoday);
		$date_selected = $calendar_api->implode_date($xselected);

		// overview
		$this->display_overview();

		$sav_month = 0;
		foreach ( $this->map as $date_offset => $event_list )
		{
			$row_sent = false;
			$xday = $calendar_api->explode_date($date_offset);
			if ( $xday['m'] != $sav_month )
			{
				if ( $sav_month )
				{
					// previous month
					if ( $idx % 7 )
					{
						$template->assign_block_vars('calendar.month.row.empty_cells_rear', array(
							'SPAN' => 7 - ($idx % 7),
						));
					}
				}
				else
				{
					$day_of_week = $calendar_api->day_of_week($xday);
				}
				$sav_month = $xday['m'];

				// header
				$xmonth = $xday;
				$xmonth['d'] = 0;
				$template->assign_block_vars('calendar.month', array(
					'MONTH' => $calendar_api->date($calendar_api->format_short, $xday),
					'I_MONTH' => $user->img('icon_calendar'),
					'U_MONTH' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xmonth), array('d' => 0, 'h' => 0)), true),
				));
				$template->set_switch('calendar.month.linked');
				for ( $i = 0; $i < 7; $i++ )
				{
					$template->assign_block_vars('calendar.month.header_cell', array(
						'L_DAY' => $calendar_api->translate(substr($calendar_api->days_list[ ((7 + intval($this->settings['week_start']) + $i) % 7) ], 0, 3)),
					));
					$template->assign_block_vars('calendar.month.header_cell.' . (!$i ? 'left' : ($i == 6 ? 'right' : 'middle')), array());
				}
				if ( $inc = (7 + $day_of_week - intval($this->settings['week_start'])) % 7 )
				{
					$template->set_switch('calendar.month.row');
					$template->assign_block_vars('calendar.month.row.empty_cells_front', array(
						'SPAN' => $inc,
					));
					$row_sent = true;
				}
				$idx = $inc;
			}
			if ( !($idx % 7) && !$row_sent )
			{
				$template->set_switch('calendar.month.row');
			}
			$template->assign_block_vars('calendar.month.row.cell', array(
				'ID' => 'day_' . str_replace('-', 'BC', $date_offset),
				'DAY' => $xday['d'],
				'U_DAY' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xday), array('h' => 0)), true),
				'S_DAY' => !$this->settings['javascript'] && isset($this->txt_overview[$date_offset]) ? $this->txt_overview[$date_offset] : '',
			));
			$template->set_switch('calendar.month.row.cell.content', $event_list);
			$template->set_switch('calendar.month.row.cell.selected', $date_selected == $date_offset);
			$template->set_switch('calendar.month.row.cell.today', $date_today == $date_offset, $date_selected != $date_offset);
			$template->set_switch('calendar.month.row.cell.otherday', ($date_today != $date_offset) && ($date_selected != $date_offset));

			$day_of_week = ($day_of_week + 1) % 7;
			$idx = ($idx + 1) % 7;
		}
		if ( $idx % 7 )
		{
			$template->assign_block_vars('calendar.month.row.empty_cells_rear', array(
				'SPAN' => 7 - ($idx % 7),
			));
		}
	}

	function display_overview()
	{
		global $template, $config, $user;
		global $calendar_api;

		$format_medium = $calendar_api->format_day_long();

		foreach ( $this->map as $date_offset => $event_list )
		{
			$count_map = count($this->map[$date_offset]);
			$header_done = false;
			for ( $i = 0; $i < $count_map; $i++ )
			{
				if ( ($event_id = $this->get_event_id($this->map[$date_offset], $i)) && ($tpl_vars = $this->queues[ $event_id['module_id'] ]->retrieve_item($event_id)) )
				{
					if ( !$header_done )
					{
						$header_done = true;
						$xday = $calendar_api->explode_date($date_offset);
						$template->assign_block_vars('schedular_month', array(
							'ID' => 'day_' . str_replace('-', 'BC', $date_offset),
							'DATE' => $calendar_api->date($format_medium, $xday),
							'U_DATE' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xday), array('h' => 0)), true),
						));
					}
					$template->assign_block_vars('schedular_month.event', $tpl_vars['vars']);
					if ( $tpl_vars['switches'] )
					{
						foreach ( $tpl_vars['switches'] as $switch => $value )
						{
							$template->set_switch('schedular_month.event.' . $switch, $value);
						}
					}
				}
			}
			if ( !$this->settings['javascript'] && $header_done )
			{
				$this->txt_overview[$date_offset] = $template->include_escaped_file('calendar_overview_schedular_txt.tpl', 'schedular_month');
			}
		}
		if ( $this->settings['javascript'] )
		{
			$template->assign_vars(array('SCHEDULAR_OVERVIEW_BOX' => $template->include_file('calendar_overview_schedular_js.tpl', 'schedular_month')));
		}
	}
}

class calendar_day extends calendar_handler
{
	var $month_box;
	var $day_queues;

	function get_cat($event_id, $xday)
	{
		global $calendar_api;

		if ( !($cat_id = $event_id['cat_id']) )
		{
			$cat_id = EVENT_CAT_TIME;
			if ( !$event_id['xend'] )
			{
				$cat_id = EVENT_CAT_DATE;
			}
		}
		return $cat_id;
	}

	function remap($date_offset, $xday)
	{
		global $calendar_api;

		$this->map = array();
		$this->day_queues = array();
		if ( empty($this->queues) || empty($this->month_box->map[$date_offset]) )
		{
			return;
		}
		$xday = $calendar_api->adjust_time(0, 0, 0, $xday['m'], $xday['d'], $xday['y']);
		$xnext = $calendar_api->adjust_time(0, 0, 0, $xday['m'], $xday['d'] + 1, $xday['y']);

		$select_start = $select_end = false;
		if ( isset($this->parms['h']) && (intval($this->parms['h']) >= 0) && (intval($this->parms['h']) < 24) )
		{
			$select_start = $calendar_api->adjust_time(intval($this->parms['h']), 0, 0, $xday['m'], $xday['d'], $xday['y']);
			$select_end = $calendar_api->adjust_time(intval($this->parms['h']) + 1, 0, 0, $xday['m'], $xday['d'], $xday['y']);
		}

		$count_map = count($this->month_box->map[$date_offset]);
		$sort_day = array();
		$sort_y = array();
		$sort_mdhi = array();
		for ( $i = 0; $i < $count_map; $i++ )
		{
			if ( $event_id = $this->get_event_id($this->month_box->map[$date_offset], $i) )
			{
				// map
				$cat_id = $this->get_cat($event_id, $xday);
				if ( $select_start && ($cat_id == EVENT_CAT_TIME) )
				{
					// event outside the selection
					if ( $calendar_api->is_ge($event_id['xstart'], $select_end) || $calendar_api->is_lt($event_id['xend'], $select_start) )
					{
						continue;
					}
				}
				if ( isset($this->parms[POST_EVENT_CAT_URL]) && (intval($this->parms[POST_EVENT_CAT_URL]) != $cat_id) )
				{
					continue;
				}

				if ( !isset($this->map[$cat_id]) )
				{
					$this->map[$cat_id] = array();
					$sort_day[$cat_id] = array();
					$sort_y[$cat_id] = array();
					$sort_mdhi[$cat_id] = array();
				}
				$this->map[$cat_id][] = $this->month_box->map[$date_offset][$i];
				$sort_day[$cat_id][] = ($cat_id != EVENT_CAT_TIME) || $calendar_api->is_ge($event_id['xstart'], $xday) || $calendar_api->is_lt($event_id['xend'], $xnext);
				$sort_y[$cat_id][] = intval($event_id['xstart']['y']);
				$sort_mdhi[$cat_id][] = intval(sprintf('%02d%02d%02d%02d', intval($event_id['xstart']['m']), intval($event_id['xstart']['d']), intval($event_id['xstart']['h']), intval($event_id['xstart']['i'])));

				// queues
				if ( !isset($this->day_queues[ $event_id['module_id'] ]) )
				{
					$this->day_queues[ $event_id['module_id'] ] = array();
				}
				if ( !isset($this->day_queues[ $event_id['module_id'] ][ $event_id['item_id'] ]) )
				{
					$this->day_queues[ $event_id['module_id'] ][ $event_id['item_id'] ] = array();
				}
				$this->day_queues[ $event_id['module_id'] ][ $event_id['item_id'] ][] = array($event_id['xstart'], $event_id['xend']);
			}
		}
		// sort per category
		if ( count($this->map) )
		{
			ksort($this->map);
			foreach ( $this->map as $cat_id => $event_list )
			{
				if ( count($event_list) )
				{
					array_multisort($sort_day[$cat_id], $sort_y[$cat_id], $sort_mdhi[$cat_id], $event_list);
					$this->map[$cat_id] = $event_list;
				}
			}
		}
	}

	function display_overview()
	{
		global $template;

		if ( !$this->settings['overview'] || empty($this->day_queues) )
		{
			return;
		}
		foreach ( $this->day_queues as $module_id => $events )
		{
			if ( $this->settings['javascript'] )
			{
				$template->assign_block_vars('calendar.module', array(
					'OVERVIEW' => $this->queues[$module_id]->display_overview($events),
				));
			}
			else
			{
				$this->queues[$module_id]->display_overview($events);
			}
		}
	}

	function display()
	{
		global $template, $config, $user;
		global $calendar_api, $calendar_event_categories;

		if ( empty($this->modules) )
		{
			return false;
		}
		$template->assign_vars(array(
			'I_UP_ARROW' => $user->img('up_arrow'),
			'I_DOWN_ARROW' => $user->img('down_arrow'),
			'I_PREVIOUS' => $user->img('cmd_previous'),
			'L_PREVIOUS' => $user->lang('Previous'),
			'I_NEXT' => $user->img('cmd_next'),
			'L_NEXT' => $user->lang('Next'),
			'L_MORE' => $user->lang('More'),
			'L_CALENDAR' => $user->lang('Calendar'),
			'I_SPACER' => $user->img('spacer'),
		));
		$template->set_switch('java', $this->settings['javascript']);

		// init modules
		$this->set_modules();
		$this->read_selection();
		$xfrom = $calendar_api->cast($this->parms);

		$xtoday = $calendar_api->sys_to_user(time());
		$xfrom = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'], $xfrom['y']);

		$xprevious = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'] - 1, $xfrom['y']);
		$xnext = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'] + 1, $xfrom['y']);

		// activate the output
		$template->assign_block_vars('calendar', array(
			'L_CALENDAR' => $user->lang('Calendar_scheduler'),
			'L_EMPTY' => $user->lang('No_events'),
			'TITLE' => $calendar_api->date($calendar_api->format_day_long(), $xfrom),
			'U_PREVIOUS_DAY' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xprevious), array('h' => 0)), true),
			'U_NEXT_DAY' => $config->url('calendar', array_merge($this->parms, $calendar_api->date_to_parms($xnext), array('h' => 0)), true),
		));

		// read events for the month and display the month box
		$this->month_box = new calendar_month_box($this->requester, $this->parms);
		$this->month_box->queues = &$this->queues;
		$this->month_box->module_set = true;
		$this->month_box->display($calendar_api->adjust_time(0, 0, 0, $xfrom['m'] - 1, 1, $xfrom['y']), $calendar_api->adjust_time(0, 0, 0, $xfrom['m'] + 2, 1, $xfrom['y']), $xfrom, $xtoday);

		// remap events for the day
		$date_offset = $calendar_api->implode_date($xfrom);
		$this->remap($date_offset, $xfrom);

		// display overview for the day
		$this->display_overview();

		// display the day per category
		if ( count($this->map) )
		{
			foreach ( $this->map as $cat_id => $event_list )
			{
				$template->assign_block_vars('calendar.cat', array(
					'TITLE' => $user->lang($calendar_event_categories[$cat_id]['txt']),
				));
				$count_events = count($event_list);
				for ( $i = 0; $i < $count_events; $i++ )
				{
					if ( ($event_id = $this->get_event_id($this->map[$cat_id], $i)) && ($tpl_vars = $this->queues[ $event_id['module_id'] ]->retrieve_item($event_id)) )
					{
						$switches = $tpl_vars['switches'];
						if ( !$switches || !isset($switches['single_line']) )
						{
							$switches['single_line'] = false;
						}
						if ( $calendar_event_categories[$cat_id]['switches'] )
						{
							$switches = array_merge($switches ? $switches : array(), $calendar_event_categories[$cat_id]['switches']);
						}
						if ( $switches['single_line'] )
						{
							if ( $i == 0 )
							{
								$switches['single_line.first'] = true;
							}
							if ( $i < ($count_events - 1) )
							{
								$tpl_vars['vars']['L_SEP'] = ',';
							}
							else
							{
								$switches['single_line.last'] = true;
								$tpl_vars['vars']['L_SEP'] = '';
							}
						}

						// send to tpl
						$template->assign_block_vars('calendar.cat.event', $tpl_vars['vars']);
						if ( $switches )
						{
							foreach ( $switches as $switch => $value )
							{
								$template->set_switch('calendar.cat.event.' . $switch, $value);
							}
						}
						if ( $switches && $switches['timeframe'] )
						{
							$xstart = $calendar_api->max($event_id['xstart'], $xfrom);
							$xend = $calendar_api->min($event_id['xend'], $calendar_api->adjust_time(23, 59, 0, $xfrom['m'], $xfrom['d'], $xfrom['y']));
							for ( $j = 0; $j < 24; $j++ )
							{
								$selected = ($j >= $xstart['h']) && ($j <= $xend['h']);
								$template->assign_block_vars('calendar.cat.event.timeframe.hours', array(
									'HOUR' => sprintf('%02d', $j),
									'U_HOUR' => $config->url('calendar', array_merge($this->parms, $xfrom, array('h' => 0, POST_EVENT_CAT_URL => $cat_id)), true) . '&amp;h=' . $j,
								));
								$template->set_switch('calendar.cat.event.timeframe.hours.header_light', !($j % 2));
								$template->set_switch('calendar.cat.event.timeframe.hours.selected', $selected);
								$template->set_switch('calendar.cat.event.timeframe.hours.light', !($j % 2), !$selected);
								$template->set_switch('calendar.cat.event.timeframe.hours.dark', ($j % 2) && !$selected);
							}
						}
					}
				}
			}
		}
		else
		{
			$template->set_switch('calendar.empty');
		}
	}

	function selection_def()
	{
		$this->selection_form = array(
			'date' => array('module_id' => -1, 'api' => 'select_date', 'parm' => 'ymd'),
			'hour' => array('module_id' => -1, 'api' => 'select_hour'),
			'category' => array('module_id' => -1, 'api' => 'select_category'),
		);
	}

	function select_hour()
	{
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
		global $calendar_api;

		// priority : $_POST, $_GET, local parms, default
		$submit = isset($HTTP_POST_VARS['submit']);
		$_req = array();
		if ( isset($HTTP_POST_VARS['y']) )
		{
			$_req = $HTTP_POST_VARS;
		}
		else if ( isset($HTTP_GET_VARS['y']) )
		{
			$_req = $HTTP_GET_VARS;
			$submit = true;
		}
		else if ( isset($this->parms['y']) )
		{
			$_req = $this->parms;
		}

		// hours list
		// 1st januar has always 24 hours a day
		$hours = array();
		$order = $calendar_api->get_time_order();
		$basetime = mktime(0, 0, 0, 01, 01, 2006);
		$h_format = isset($order['a']) ? 'h a' : 'H';
		$hours[-1] = ' ---- ';
		for ( $i = 0; $i < 24; $i++ )
		{
			$hours[$i] = $calendar_api->translate(date($h_format, $basetime));
			$basetime += 3600;
		}

		// hours
		$hour = -1;
		if ( isset($_req['h']) && !strpos(' ' . $_req['h'], '-') && (intval($_req['h']) >= 0) && (intval($_req['h']) < 24) )
		{
			$hour = intval($_req['h']);
		}
		$form_fields = array(
			'h' => array('type' => 'list', 'legend' => 'Select_hour', 'value' => $hour, 'options' => $hours),
		);
		if ( $submit )
		{
			if ( $hour > -1 )
			{
				$this->parms['h'] = $hour;
			}
			else if ( isset($this->parms['h']) )
			{
				unset($this->parms['h']);
			}
		}
		return $form_fields;
	}

	function select_category()
	{
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
		global $user;
		global $calendar_event_categories;

		if ( empty($calendar_event_categories) )
		{
			return array();
		}

		$categories = array(0 => ' -------------- ');
		foreach ( $calendar_event_categories as $cat_id => $def )
		{
			$categories[$cat_id] = $user->lang($def['txt']);
		}

		// priority : $_POST, $_GET, local parms, default
		$submit = isset($HTTP_POST_VARS['submit']);
		$_req = '';
		if ( isset($HTTP_POST_VARS[POST_EVENT_CAT_URL]) )
		{
			$_req = $HTTP_POST_VARS;
		}
		else if ( isset($HTTP_GET_VARS[POST_EVENT_CAT_URL]) )
		{
			$_req = $HTTP_GET_VARS;
			$submit = true;
		}
		else if ( isset($this->parms[POST_EVENT_CAT_URL]) )
		{
			$_req = $this->parms;
		}
		$cat_id = !empty($_req) && isset($categories[ intval($_req[POST_EVENT_CAT_URL]) ]) ? intval($_req[POST_EVENT_CAT_URL]) : 0;
		if ( $submit )
		{
			if ( $cat_id > 0 )
			{
				$this->parms[POST_EVENT_CAT_URL] = $cat_id;
			}
			else if ( isset($this->parms[POST_EVENT_CAT_URL]) )
			{
				unset($this->parms[POST_EVENT_CAT_URL]);
			}
		}
		$form_fields = array(
			POST_EVENT_CAT_URL => array('type' => 'list', 'legend' => 'Select_event_cat', 'value' => $cat_id, 'options' => $categories),
		);
		return $form_fields;
	}
}

?>