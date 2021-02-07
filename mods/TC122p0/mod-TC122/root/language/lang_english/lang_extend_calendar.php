<?php
/***************************************************************************
 *						lang_extend_calendar.php [English]
 *						----------------------------------
 *	begin				: 28/09/2003
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 1.2.0 - 26/04/2006
 *
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

// admin part
if ( $lang_extend_admin )
{
	$lang['Lang_extend_topic_calendar'] = 'Topic Calendar';
	$lang['auth_calendar'] = 'Create new calendar events';
}

$lang = array_merge(empty($lang) ? array() : $lang, array(
	'Calendar' => 'Calendar',

	// front title
	'Calendar_event' => 'Calendar event',
	'Calendar_one_day' => 'Event starting %s for one day',
	'Calendar_many_days' => 'Event starting %s for %d days',
	'Calendar_one_hour' => 'Event starting %s for one hour',
	'Calendar_many_hours' => 'Event starting %s for %d hours',
	'Calendar_from_to' => 'Event from %s to %s',
	'Calendar_from' => 'Event: %s',

	// overview : birthday
	'Calendar_adjusted' => '(adjusted to match your timezone difference, which is %01.2f hours)',
	'Calendar_age' => '(%02d year old)',

	// viewforum/viewtopic
	'Rules_calendar_can' => 'You <b>can</b> post calendar events in this forum',
	'Rules_calendar_cannot' => 'You <b>cannot</b> post calendar events in this forum',

	// scheduler
	'Calendar_scheduler' => 'Scheduler',
	'Calendar_event_birthday' => 'Birthday',
	'Calendar_event_dated' => 'Events',
	'Calendar_event_scheduled' => 'Time scheduled events',
	'Select_date' => 'Select date',
	'Select_hour' => 'Select hour',
	'Select_event_cat' => 'Select event category',
	'No_events' => 'No events',

	// settings form
	'Calendar_settings' => 'Calendar settings',
	'Calendar_use_java' => 'Use javascript to display the calendar',
	'Calendar_overview' => 'Display an overview of the events in the calendar',
	'Calendar_week_start' => 'First day of the week',
	'Calendar_header_cells' => 'Number of cells to display on the board header (0 for no display)',
	'Calendar_title_length' => 'Length of the title displayed in the calendar cells (0 for all)',
	'Calendar_text_length' => 'Length of the text displayed in the overview (0 for all)',
	'Calendar_display_open' => 'Display the calendar row on the board header opened',
	'Calendar_nb_row' => 'Number of row per cell',

	'Override_user_choice' => 'Override user choice',
	'Default' => 'Default',

	// posting
	'Sorry_auth_cal' => 'Sorry, but only %s can post calendar events in this forum.',
	'Calendar_duration' => 'During',
	'Date_error' => 'month %02d, day %02d, year %04d is not a valid date',
	'Event_time' => 'Event time',
	'Minutes' => 'Minutes',
	'Today' => 'Today',

	// tree drawing
	'tree_pic_' . TREE_HSPACE => '&nbsp;&nbsp;&nbsp;&nbsp;',
	'tree_pic_' . TREE_VSPACE => '|&nbsp;&nbsp;&nbsp;',
	'tree_pic_' . TREE_CROSS => '|___',
	'tree_pic_' . TREE_CLOSE => '|___',
));

?>