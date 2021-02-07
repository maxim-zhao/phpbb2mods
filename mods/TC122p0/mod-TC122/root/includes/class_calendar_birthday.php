<?php
/***************************************************************************
 *                            class_calendar_birthday.php
 *                            ---------------------------
 *	begin			: 24/04/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.3 - 01/06/2006
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

// choose the appropriate user_birthday date format
// define('BIRTHDAY_FMT', 'mdy'); // MMDDYYYY
// define('BIRTHDAY_FMT', 'dmy_sep'); // D-M-Y
// define('BIRTHDAY_FMT', 'ymd'); // YYYYMMDD

// --------------------------
//
// set the appropriate driver
//
// --------------------------
switch ( BIRTHDAY_FMT )
{
	case 'mdy':
		$calendar_birthday_driver = $config->url('includes/class_calendar_birthday_mdy');
		break;
	case 'ymd':
		$calendar_birthday_driver = $config->url('includes/class_calendar_birthday_ymd');
		break;
	case 'dmy_sep':
		$calendar_birthday_driver = $config->url('includes/class_calendar_birthday_dmy_sep');
		break;
	default:
		$calendar_birthday_driver = false;
		break;
}

// --------------------------
//
// driver def : all birthday drivers are inherited from this one
//
// --------------------------
class calendar_event_birthday_root extends calendar_event
{
	var $user_fields;
	var $overview;
	var $is_dst;

	function calendar_event_birthday_root($requester, $parms, &$handler, $module_id)
	{
		global $user;

		parent::calendar_event($requester, $parms, $handler, $module_id);
		$this->overview = array();
		$this->data = array();
		$this->user_fields = array(
			'user_id',
			'username',
			'user_birthday',
			'user_timezone',
		);
		if ( $this->is_dst = isset($user->data['user_dst']) )
		{
			$this->user_fields[] = 'user_dst';
		}
		$profile = new calendar_profile_overview();
		$this->user_fields = $profile->get_complementary_fields($this->user_fields);
		$this->init();
	}

	// for supplementary definitions
	function init()
	{
	}

	// xfrom & xto are user timezone date, array('y' =>, 'm' =>, 'd' =>, 'h' =>, 'i' =>)
	// we fill here the $this->data array with the appropriate events, ordered by event time ascending
	// the event should verify : time belongs to [xfrom, xto[
	function read($xfrom, $xto)
	{
	}

	function adjust_event(&$row, $xfrom)
	{
		global $user, $calendar_api;

		$row['viewed_birthday_start'] = array();
		$row['viewed_birthday_end'] = false;
		if ( !$row['user_birthday'] )
		{
			return;
		}
		$timeshift = intval(3600 * (doubleval($row['user_timezone']) + intval($row['user_dst']) - doubleval($user->data['user_timezone']) - intval($user->data['user_dst'])));
		if ( $timeshift )
		{
			$row['viewed_birthday_start'] = $calendar_api->adjust_time(0, 0, $timeshift, $row['user_birthday']['m'], $row['user_birthday']['d'], $xfrom['y']);
			$row['viewed_birthday_end'] = $calendar_api->adjust_time(0, 0, $timeshift - 1, $row['user_birthday']['m'], $row['user_birthday']['d'] + 1, $xfrom['y']);
		}
		else
		{
			$row['viewed_birthday_start'] = array_merge($row['user_birthday'], array('y' => $xfrom['y']));
			$row['viewed_birthday_end'] = false;
		}
	}
}

// --------------------------
//
// get the appropriate driver
//
// --------------------------
if ( $calendar_birthday_driver && @file_exists(@phpbb_realpath($calendar_birthday_driver)) )
{
	include($calendar_birthday_driver);
}
else
{
	return;
}

// add birthday category
define('EVENT_CAT_BIRTHDAY', 10);
$calendar_event_categories += array(
	EVENT_CAT_BIRTHDAY => array('txt' => 'Calendar_event_birthday', 'switches' => array('dates' => false, 'single_line' => true)),
);
include($config->url('includes/class_calendar_birthday_parse'));

// -------------------
//
// calendar processes
//
// -------------------

// $x* date are date formatted array('y' => 9999, 'm' => 99, 'd' => 99, 'h' => 99, 'i' => 99, 's'=> 99)
// and are settled at the current user timezone (eg the timezone of the user viewing the calendar)
class calendar_event_birthday extends calendar_event_birthday_reader
{
	function get_occurrences($key)
	{
		return !isset($this->data[$key]) ? array() : array(array($this->data[$key]['viewed_birthday_start'], $this->data[$key]['viewed_birthday_end'], EVENT_CAT_BIRTHDAY));
	}

	function display_overview($user_ids=false)
	{
		global $template;

		if ( !$this->handler->settings['overview'] || empty($this->data) )
		{
			return false;
		}
		$user_ids = !$user_ids ? array_keys($this->data) : array_keys($user_ids);
		$overview = new calendar_profile_overview();
		$overview->init_display();
		$count_user_ids = count($user_ids);
		for ( $i = 0; $i < $count_user_ids; $i++ )
		{
			$user_id = intval($user_ids[$i]);
			if ( isset($this->data[$user_id]) )
			{
				$overview->display($this->data[$user_id], 'event_birthday', $this->get_id($this->module_id, $user_id));
				if ( !$this->handler->settings['javascript'] )
				{
					$this->overview[$user_id] = $template->include_escaped_file('calendar_overview_birthday_txt.tpl', 'event_birthday');
				}
			}
		}
		unset($overview);
		return $this->handler->settings['javascript'] ? $template->include_file('calendar_overview_birthday_js.tpl', 'event_birthday') : '';
	}

	function retrieve_item($event_id)
	{
		global $user, $config;
		if ( !$event_id )
		{
			return false;
		}
		$tpl_vars = array(
				'vars' => array(
				'ID' => $this->get_id($event_id),
				'I_TITLE' => $user->img('icon_tiny_profile'),
				'L_TITLE' => $user->lang('Birthday'),
				'U_TITLE' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $event_id['item_id']), true),
				'TITLE' => $this->data[ $event_id['item_id'] ]['username'],
				'S_OVERVIEW' => isset($this->overview[ intval($event_id['item_id']) ]) && !$this->handler->settings['javascript'] ? $this->overview[ intval($event_id['item_id']) ] : '',
			),
			'switches' => false,
		);
		return $this->format_item($tpl_vars);
	}
}

class calendar_profile_overview
{
	var $order;
	var $year;
	var $profile;

	function calendar_profile_overview()
	{
		$this->order = array();
		$this->year = 0;
		$this->profile = new calendar_profile();
	}

	function get_complementary_fields($fields)
	{
		global $user;

		$fields = array_merge($fields, array(
			'user_id',
			'username',
			'user_level',
			'user_posts',
			'user_rank',
			'user_avatar',
			'user_avatar_type',
			'user_allowavatar',
			'user_birthday',
			'user_timezone',
		));
		return array_keys(array_flip($fields));
	}

	function init_display()
	{
		global $db, $user;
		global $calendar_api;

		$this->order = $calendar_api->get_time_order();
		$this->year = $user->date(time(), 'Y', false);
	}

	function display($row, $switch, $id)
	{
		global $template, $user, $config;
		global $calendar_api;

		// get date format
		$tfmt = array('m' => true, 'd' => true, 'y' => !empty($row['user_birthday']['y']));
		$fmt = array();
		foreach ( $this->order as $comp => $dummy )
		{
			if ( isset($tfmt[$comp]) && $tfmt[$comp] )
			{
				$fmt[] = $comp;
			}
		}
		$fmt = $calendar_api->format_month_long(implode(' ', $fmt));

		// get a displayable birthday date
		$xbirthday = $row['user_birthday'];
		if ( !$tfmt['y'] )
		{
			$xbirthday['y'] = $this->year;
		}

		// get rank
		$rank_row = $this->profile->get_rank($row);
		$avatar = $this->profile->get_avatar($row);

		$template->assign_block_vars($switch, array(
			'ID' => $id,
			'USERNAME' => $row['username'],
			'U_USERNAME' => $config->url('profile', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true),
			'BIRTHDAY' => $calendar_api->date($fmt, $xbirthday),
			'S_ADJUST' => sprintf($user->lang('Calendar_adjusted'), round(doubleval($row['user_timezone']) + intval($row['user_dst']) - doubleval($user->data['user_timezone']) - intval($user->data['user_dst']), 2)),
			'S_AGE' => sprintf($user->lang('Calendar_age'), round($this->year - $row['user_birthday']['y'])),
			'L_RANK' => $rank_row ? $rank_row['rank_title'] : '',
			'I_RANK' => $rank_row && !empty($rank_row['rank_image']) ? $rank_row['rank_image'] : '',
			'I_AVATAR' => $avatar ? $avatar : '',
		));
		$template->set_switch($switch . '.adjust', $row['viewed_birthday_end']);
		$template->set_switch($switch . '.age', $tfmt['y']);
		$template->set_switch($switch . '.rank', $rank_row);
		$template->set_switch($switch . '.rank.image', $rank_row && !empty($rank_row['rank_image']), $rank_row);
		$template->set_switch($switch . '.avatar', $avatar);
		$template->set_switch($switch . '.rank_or_avatar', $avatar || $rank_row);
	}
}

?>