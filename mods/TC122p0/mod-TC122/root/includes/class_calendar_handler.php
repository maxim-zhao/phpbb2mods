<?php
/***************************************************************************
 *                            class_calendar_handler.php
 *                            --------------------------
 *	begin			: 13/04/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.2 - 19/05/2006
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

//---------------------------------------------------
//
// events categories : event groups for the scheduler
//
//---------------------------------------------------
define('EVENT_CAT_DATE', 20);
define('EVENT_CAT_TIME', 30);

$calendar_event_categories = array(
	EVENT_CAT_DATE => array('txt' => 'Calendar_event_dated', 'switches' => array('dates' => false)),
	EVENT_CAT_TIME => array('txt' => 'Calendar_event_scheduled', 'switches' => array('timeframe' => true)),
);

//-------------------------------
// registration of event type :
// class => file
//-------------------------------
$calendar_event_types = array(
	'calendar_event_birthday' => 'class_calendar_birthday',
	'calendar_event_topics' => 'class_calendar_topics',
);

// all high level classes are inherited from this one
class calendar_root
{
	var $requester;
	var $parms;
	var $id_prefix;

	function calendar_root($requester='', $parms='')
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->id_prefix = 'item_';
	}

	function get_id($event_id, $item_id=0)
	{
		$event_id = is_array($event_id) ? array(
			'module_id' => intval($event_id['module_id']),
			'item_id' => intval($event_id['item_id']),
		) : array(
			'module_id' => intval($event_id),
			'item_id' => intval($item_id),
		);
		return $this->id_prefix . implode('_', array_values($event_id));
	}
}

// all modules inherit from this class
// $x* date are date formatted array('y' => 9999, 'm' => 99, 'd' => 99, 'h' => 99, 'i' => 99, 's'=> 99)
// and are settled at the current user timezone (eg the timezone of the user viewing the calendar)
class calendar_event extends calendar_root
{
	var $handler;
	var $data;

	function calendar_event($requester, $parms, &$handler, $module_id)
	{
		parent::calendar_root($requester, $parms);
		$this->handler = &$handler;
		$this->module_id = $module_id;
		$this->data = array();
	}

	// xfrom & xto are user timezone date, array('y' =>, 'm' =>, 'd' =>, 'h' =>, 'i' =>)
	// we fill here the $this->data array with the appropriate events, ordered by event time ascending
	// the event should verify : time belongs to [xfrom, xto[
	function read($xfrom, $xto)
	{
		$this->data = array();
	}

	// return an array() with all occurences of an event between the period
	// for an event with a single occurrence : array( array($xstart[, $xend[, $category_id]]) )
	// where xstart & xend are user timezone date, array('y' =>, 'm' =>, 'd' =>, 'h' =>, 'i' =>)
	// and category_id an id of $calendar_event_categories
	// $xend & $category_id can be omitted
	function get_occurrences($key)
	{
	}

	// we will here return the overview display for all events if javascript is active,
	// or store them to get them back if javascript is not active (see retrieve_item)
	// events can be provided to focus a particular set of events (for a day ie)
	// event structure is array($event_key => occurences) where occurrences = array(array($xstart, $xend))
	function display_overview($events=false)
	{
	}

	// Here we return data for one entry of $this->data, and one occurrence
	// if javascript is not activated, we also return the overview in text format to put it in a alt="" html tag
	// returned format is array('vars' => array(), 'switches' => array())
	function retrieve_item($event_id)
	{
		global $user, $config;
		if ( $event_id )
		{
			return false;
		}
		$tpl_vars = array(
				'vars' => array(
				'ID' => $this->get_id($event_id),
				'I_TITLE' => $user->img('icon_minipost'),
				'L_TITLE' => $user->lang('Topic'),
				'U_TITLE' => $config->url('viewtopic', $this->parms, true),
				'TITLE' => '',
				'S_OVERVIEW' => '',
			),
			'switches' => false,
		);
		return $this->format_item($tpl_vars);
	}

	// has to be called on the retrieve_item() expected result prior returning it
	function format_item($tpl_vars)
	{
		if ( $tpl_vars && $tpl_vars['vars'] )
		{
			if ( !$tpl_vars['switches'] )
			{
				$tpl_vars['switches'] = array();
			}
			if ( intval($this->handler->settings['title_length']) && (strlen($tpl_vars['vars']['TITLE']) > intval($this->handler->settings['title_length']) ) )
			{
				$tpl_vars['vars']['FULL_TITLE'] = $tpl_vars['vars']['TITLE'];
				$tpl_vars['vars']['TITLE'] = substr($tpl_vars['vars']['TITLE'], 0, intval($this->handler->settings['title_length']) - 3) . '...';
				$tpl_vars['switches']['full_title'] = true;
			}
			else
			{
				$tpl_vars['switches']['full_title'] = false;
			}
		}
		return $tpl_vars;
	}
}

class calendar_handler extends calendar_root
{
	var $settings;
	var $queues;
	var $map;
	var $modules;
	var $selection_form;

	function calendar_handler($requester='', $parms='')
	{
		global $calendar_api, $calendar_modules;

		parent::calendar_root($requester, $parms);
		$this->queues = array();
		$this->map = array();
		$this->modules = &$calendar_modules;
		$this->txt_overview = array();
		$this->selection_form = array();

		$this->settings = $this->retrieve_settings();
		$this->selection_def();

		$calendar_api->set();
	}

	function retrieve_settings()
	{
		global $config, $user;

		$settings = array(
			'javascript' => array('user' => 'user_calendar_javascript', 'config' => 'calendar_javascript', 'over' => 'calendar_javascript_over', 'dft' => true),
			'overview' => array('user' => 'user_calendar_overview', 'config' => 'calendar_overview', 'over' => 'calendar_overview_over', 'dft' => true),
			'display_open' => array('user' => 'user_calendar_display_open', 'config' => 'calendar_display_open', 'over' => 'calendar_display_open_over', 'dft' => true),
			'week_start' => array('user' => 'user_calendar_week_start', 'config' => 'calendar_week_start', 'over' => 'calendar_week_start_over'),
			'title_length' => array('user' => 'user_calendar_title_length', 'config' => 'calendar_title_length', 'over' => 'calendar_title_length_over'),
			'text_length' => array('user' => 'user_calendar_text_length', 'config' => 'calendar_text_length', 'over' => 'calendar_text_length_over'),
			'header_cells' => array('user' => 'user_calendar_header_cells', 'config' => 'calendar_header_cells', 'over' => 'calendar_header_cells_over'),
			'events_per_cell' => array('user' => 'user_calendar_nb_row', 'config' => 'calendar_nb_row', 'over' => 'calendar_nb_row_over'),
		);
		foreach ( $settings as $setting => $def )
		{
			$value = intval($config->data[ $def['config'] ]);
			if ( !isset($def['over']) || !intval($config->data[ $def['over'] ]) )
			{
				if ( isset($user->data[ $def['user'] ]) && (!$def['dft'] || intval($user->data[ $def['user'] ])) )
				{
					$value = max(0, intval($user->data[ $def['user'] ]));
					if ( $def['dft'] && intval($user->data[ $def['user'] ]) == 2 )
					{
						$value = 0;
					}
				}
			}
			$settings[$setting] = $value;
		}
		return $settings;
	}

	function destroy()
	{
		if ( !empty($this->queues) )
		{
			foreach ( $this->queues as $module_id => $dummy )
			{
				unset($this->queues[$module_id]);
			}
		}
	}

	function selection_def()
	{
	}

	function register_selection($selections)
	{
		$this->selection_form += $selections;
	}

	function read_selection()
	{
		global $template, $user, $config;

		if ( empty($this->selection_form) )
		{
			return;
		}

		$form_fields = array();
		foreach ( $this->selection_form as $field => $def )
		{
			if ( $def['module_id'] < 0 )
			{
				$form_fields += $this->{$def['api']}($def['parm']);
			}
			else
			{
				$form_fields += $this->queues[ $def['module_id'] ]->{$def['api']}($def['parm']);
			}
		}

		// display form
		if ( !empty($form_fields) )
		{
			$template->assign_block_vars('calendar_form', array(
				'S_ACTION' => $config->url($this->requester, '', true),
			));
			$template->assign_block_vars('select_form', array(
				'L_CALENDAR_SELECT' => $user->lang('Select'),
				'L_SUBMIT' => $user->lang('Select'),
				'I_SUBMIT' => $user->img('cmd_select'),
			));

			$first = true;
			foreach ( $form_fields as $field => $def )
			{
				$template->set_switch('select_form.field.close_row', !$def['combined'], !$first);

				$type = $def['type'] ? $def['type'] : 'varchar';
				$template->assign_block_vars('select_form.field', array(
					'L_FIELD' => $def['legend'] ? $user->lang($def['legend']) : '',
					'FIELD' => $field,
					'VALUE' => $def['value'],
					'SIZE' => intval($def['size']) ? intval($def['size']) : 25,
				));
				$template->set_switch('select_form.field.open_row', !$def['combined'] || $first);
				$template->set_switch('select_form.field.' . $type);
				if ( $def['type'] == 'list' )
				{
					foreach( $def['options'] as $value => $legend )
					{
						$template->assign_block_vars('select_form.field.' . $type . '.opt', array(
							'VALUE' => $value,
							'LEGEND' => $legend,
						));
						$template->set_switch('select_form.field.' . $type . '.opt.selected', $value == $def['value']);
					}
				}
				$first = false;
			}
			$template->set_switch('select_form.field.close_row', !$first);
			$template->assign_vars(array('CALENDAR_SELECT_FORM' => $template->include_file('calendar_select_form.tpl', 'select_form')));
		}
	}

	function select_date($fmt='')
	{
		global $HTTP_GET_VARS, $HTTP_POST_VARS;
		global $config, $user;
		global $calendar_api;

		$fmt = empty($fmt) ? 'ym' : $fmt;
		$tfmt = array();
		for ( $i = strlen($fmt) - 1; $i >= 0; $i-- )
		{
			$tfmt[ substr($fmt, $i, 1) ] = true;
		}
		$order = $calendar_api->get_time_order();
		$fmt = array();
		foreach ( $order as $comp => $dummy )
		{
			if ( $tfmt[$comp] )
			{
				$fmt[$comp] = true;
			}
		}
		unset($tfmt);

		// priority : $_POST, $_GET, local parms, default
		$submit = isset($HTTP_POST_VARS['submit']);
		$xtoday = $calendar_api->sys_to_user(time());
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
		else
		{
			$_req = $xtoday;
			$submit = true;
		}

		// month list
		$monthes = array_merge(array(''), $calendar_api->monthes_list);
		unset($monthes[0]);
		foreach ( $monthes as $month => $legend )
		{
			$monthes[$month] = $calendar_api->translate($monthes[$month]);
		}

		// days list
		$days = array();
		if ( $fmt['d'] )
		{
			for ( $i = 1; $i <= 31; $i++ )
			{
				$days[$i] = sprintf('%02d', $i);
			}
		}

		// get values
		$xtime = array();
		$error = false;

		// month
		if ( !intval($_req['m']) || !isset($monthes[ intval($_req['m']) ]) )
		{
			$error = true;
		}
		$xtime['m'] = intval($_req['m']);

		// year
		$year = (string) $_req['y'];
		$ac = 1;
		if ( strpos(' ' . $year, '-') )
		{
			$year = str_replace('-', '', $year);
			$ac = -1;
		}
		$xtime['y'] = $ac * intval($year);

		// day
		if ( !$error && $fmt['d'] && intval($_req['d']) )
		{
			$xtime['d'] = intval($_req['d']);
			if ( ($xtime['d'] <= 0) || ($xtime['d'] > $calendar_api->days_in_month($xtime)) )
			{
				$error = true;
			}
		}

		// hours
		if ( !$error && $fmt['h'] )
		{
			if ( !isset($_req['h']) || strpos(' ' . $_req['h'], '-') )
			{
				$xtime['h'] = -1;
			}
			else
			{
				$xtime['h'] = intval($_req['h']);
				if ( ($xtime['h'] < -1) || ($xtime['h'] > 23) )
				{
					$error = true;
				}
			}
		}

		// handle errors
		if ( $error )
		{
			$xtime = $xtoday;
			$xtime['h'] = $xtime['i'] = $xtime['s'] = 0;
			if ( $fmt['h'] )
			{
				$xtime['h'] = -1;
			}
			$submit = true;
		}

		// define form fields
		$fields = array(
			'm' => array('type' => 'list', 'value' => $xtime['m'], 'options' => $monthes),
			'd' => array('type' => 'list', 'value' => $xtime['d'], 'options' => $days),
			'y' => array('type' => 'int', 'value' => $xtime['y'], 'size' => 5),
		);

		// and finaly build the form
		$form_fields = array();
		$first = true;
		foreach ( $order as $comp => $dummy )
		{
			if ( $fmt[$comp] )
			{
				$form_fields[$comp] = $fields[$comp] + ($first ? array('legend' => 'Select_date') : array('combined' => true));
				$first = false;
				if ( $submit && (($comp == 'y') || ($fields[$comp]['value'] > 0)) )
				{
					$this->parms[$comp] = $fields[$comp]['value'];
				}
				else if ( isset($this->parms[$comp]) )
				{
					unset($this->parms[$comp]);
				}
			}
			else if ( isset($this->parms[$comp]) )
			{
				unset($this->parms[$comp]);
			}
		}
		return $form_fields;
	}

	function get_event_id(&$map, $offset)
	{
		global $calendar_event_categories;
		return isset($map[$offset]) && is_array($map[$offset]) && isset($this->queues[ $map[$offset][0] ]) ? array(
			'module_id' => $map[$offset][0],
			'item_id' => $map[$offset][1],
			'xstart' => $map[$offset][2],
			'xend' => empty($map[$offset][3]) ? false : $map[$offset][3],
			'cat_id' => empty($map[$offset][4]) || !isset($calendar_event_categories[ $map[$offset][4] ]) ? false : $map[$offset][4],
		) : false;
	}

	function build_event_id($module_id, $key, $occur)
	{
		return array(
			$module_id,
			$key,
			$occur[0],
			isset($occur[1]) && !empty($occur[1]) ? $occur[1] : false,
			isset($occur[2]) && !empty($occur[2]) ? $occur[2] : false,
		);
	}

	function set_modules()
	{
		if ( empty($this->modules) )
		{
			return false;
		}

		// instantiate modules
		foreach ( $this->modules as $module_id => $module_class )
		{
			$this->queues[$module_id] = new $module_class($this->requester, $this->parms, $this, $module_id);
		}
	}

	function read($xfrom, $xto, $do_map=true)
	{
		global $calendar_api;

		if ( empty($this->modules) )
		{
			return false;
		}

		// prepare the map
		$this->map = array();

		$xfrom = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'], $xfrom['y']);
		$xto = $calendar_api->adjust_time(0, 0, 0, $xto['m'], $xto['d'] + ($xto['h'] ? 1 : 0), $xto['y']);
		$xdate = $xfrom;
		$xlast = $xdate;
		$end_offset = ($xto['y'] - $xfrom['y']) * 10000 + $xto['m'] * 100 + $xto['d'];
		$cur_offset = $xfrom['m'] * 100 + $xfrom['d'];

		while ( $cur_offset < $end_offset )
		{
			$date = $calendar_api->implode_date($xdate);
			$xlast = $xdate;
			$this->map[$date] = array();

			$xdate = $calendar_api->adjust_time(0, 0, 0, $xdate['m'], $xdate['d'] + 1, $xdate['y']);
			$cur_offset = ($xdate['y'] - $xfrom['y']) * 10000 + $xdate['m'] * 100 + $xdate['d'];
		}
		if ( !($count_map = count($this->map)) || empty($this->modules) )
		{
			return;
		}
		$map_keys = array_keys($this->map);
		$rev_map_keys = array_flip($map_keys);

		// get limits
		$start_date = $map_keys[0];
		$end_date = $map_keys[ ($count_map - 1) ];

		// read events and map the first day of each occurences
		$tmap = $this->map;
		foreach ( $this->modules as $module_id => $module_class )
		{
			$this->queues[$module_id]->read($xfrom, $xto);

			// map the events
			if ( !empty($this->queues[$module_id]->data) )
			{
				foreach ( $this->queues[$module_id]->data as $key => $data )
				{
					$occurs = $this->queues[$module_id]->get_occurrences($key);
					if ( !empty($occurs) )
					{
						foreach ( $occurs as $iter => $start_end )
						{
							$date_offset = $calendar_api->implode_date($calendar_api->max($xfrom, $start_end[0]));
							if ( isset($tmap[$date_offset]) )
							{
								$event_id = $this->build_event_id($module_id, $key, $start_end);
								$tmap[$date_offset][] = $event_id;
							}
						}
					}
				}
			}
		}

		// map events
		if ( count($tmap) )
		{
			foreach( $tmap as $date_offset => $event_list )
			{
				$count_event_list = count($event_list);
				for ( $i = 0; $i < $count_event_list; $i++ )
				{
					if ( $event_id = $this->get_event_id($event_list, $i) )
					{
						$event_end_date = empty($event_id['xend']) ? $date_offset : $calendar_api->implode_date($calendar_api->min($xlast, $event_id['xend']));
						if ( $do_map )
						{
							// find the first available spot in the mapped day
							$line = count($this->map[$date_offset]);
							for ( $j = 0; $j < $line; $j++ )
							{
								if ( $this->map[$date_offset][$j] === -1 )
								{
									$line = $j;
									break;
								}
							}
						}

						// mark the row offset as used for the whole event period
						for ( $j = $rev_map_keys[$date_offset]; $j <= $rev_map_keys[$event_end_date]; $j++ )
						{
							$date_cur = $map_keys[$j];
							if ( $do_map )
							{
								for ( $k = count($this->map[$date_cur]); $k < $line; $k++ )
								{
									$this->map[$date_cur][$k] = -1;
								}
								$this->map[$date_cur][$line] = $event_list[$i];
							}
							else
							{
								$this->map[$date_cur][] = $event_list[$i];
							}
						}
					}
				}
			}
		}
	}

	function display_overview()
	{
		global $template;

		if ( empty($this->modules) )
		{
			return false;
		}

		if ( !$this->settings['overview'] || empty($this->queues) )
		{
			return;
		}
		foreach ( $this->queues as $module_id => $dummy )
		{
			if ( $this->settings['javascript'] )
			{
				$template->assign_block_vars('calendar.module', array(
					'OVERVIEW' => $this->queues[$module_id]->display_overview(),
				));
			}
			else
			{
				$this->queues[$module_id]->display_overview();
			}
		}
	}
}

class calendar_header_box extends calendar_handler
{
	function display()
	{
		global $user, $template;
		global $calendar_event_types, $calendar_api;

		if ( empty($calendar_event_types) || !$this->settings['header_cells'] )
		{
			return;
		}
		if ( empty($this->modules) )
		{
			return false;
		}

		// main display
		$template->assign_vars(array(
			'I_UP_ARROW' => $user->img('up_arrow'),
			'I_DOWN_ARROW' => $user->img('down_arrow'),
			'L_MORE' => $user->lang('More'),
			'L_CALENDAR' => $user->lang('Calendar'),
			'I_SPACER' => $user->img('spacer'),

			'S_TOGGLE' => $this->settings['display_open'] ? '' : 'none',
			'I_TOGGLE' => $this->settings['display_open'] ? $user->img('up_arrow') : $user->img('down_arrow'),
		));
		$template->set_switch('java', $this->settings['javascript']);
		$template->set_switch('full_month', false);

		// set parms (user fmt time)
		$xtoday = $calendar_api->sys_to_user(time());
		$day_back = $this->settings['header_cells'] < 3 ? 0 : 1;
		$xfrom = $calendar_api->adjust_time(0, 0, 0, $xtoday['m'], $xtoday['d'] - $day_back, $xtoday['y']);
		$xto = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'] + $this->settings['header_cells'], $xfrom['y']);

		// init modules
		$this->set_modules();

		// get events
		$this->read($xfrom, $xto);

		// build the display
		$this->display_main($xtoday);

		// all done, go to the main display
		$template->assign_vars(array('CALENDAR_BOX' => $template->include_file('calendar_box.tpl', 'calendar')));
	}

	function display_main($selected)
	{
		global $template, $user, $config;
		global $calendar_api;

		if ( empty($this->map) )
		{
			return;
		}

		$selected = $calendar_api->implode_date($selected);
		$nb_cells = $this->settings['header_cells'];

		// activate the output
		$template->assign_block_vars('calendar', array(
			'CELL_SPAN' => $nb_cells,
			'CELL_WIDTH' => floor(100 / $nb_cells),

			'U_TITLE' => $config->url('calendar', '', true),
			'I_TITLE' => $user->img('icon_calendar'),
			'TITLE' => $user->lang('Calendar'),
		));
		$template->set_switch('calendar.only');
		$template->set_switch('calendar.header_box', true, $this->settings['javascript']);

		// ok, let's go : first, overviewes
		$this->display_overview();

		// send first row
		$template->set_switch('calendar.row');

		// is day here ?
		$format_medium = $calendar_api->format_day_short();

		$i = 0;
		foreach ( $this->map as $date_offset => $event_list )
		{
			$xtime = $calendar_api->explode_date($date_offset);

			$template->assign_block_vars('calendar.row.cell', array(
				'TITLE' => $calendar_api->date($format_medium, $xtime),
				'U_TITLE' => $config->url('calendar', $this->parms + $calendar_api->date_to_parms($xtime), true),
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
	}
}

// ------------------
//
// read valid modules
//
// ------------------
$calendar_modules = array();
foreach ( $calendar_event_types as $calendar_module_class => $calendar_module_file )
{
	if ( ($file = empty($calendar_module_file) ? false : $config->url('includes/' . $calendar_module_file)) && @file_exists(phpbb_realpath($file)) )
	{
		include($file);
	}
	if ( class_exists($calendar_module_class) )
	{
		$calendar_modules[] = $calendar_module_class;
	}
}

// a module could add new categorie(s)
ksort($calendar_event_categories);

?>