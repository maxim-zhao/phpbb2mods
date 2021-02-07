<?php
/***************************************************************************
 *                            calendar.php
 *                            ------------
 *	begin				: 03/08/2003
 *	copyright			: Ptirhiik
 *	email				: admin@rpgnet-fr.com
 *
 *	version				: 1.1.0 - 17/04/2006
 *
 ***************************************************************************/
/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true);
define('IN_CALENDAR', true);

$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'calendar';
include($phpbb_root_path . 'common.' . $phpEx);

include($config->url('includes/class_calendar_handler'));
include($config->url('includes/class_calendar_page'));

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//
$user->set();

// choose layer
$_req = '';
if ( isset($HTTP_POST_VARS['y']) )
{
	$_req = &$HTTP_POST_VARS;
}
else
{
	$_req = &$HTTP_GET_VARS;
}
$day = intval($_req['d']) && intval($_req['m']);

// proceed with the appropriate layer
calendar_extend_template();
$calendar = $calendar_class = $tpl_body = false;
$page_title = $user->lang('Calendar');
$parms = array();
if ( $day )
{
	$calendar_class = 'calendar_day';
	$page_title = $user->lang('Calendar_scheduler');
	$tpl_body = 'calendar_scheduler_body.tpl';
}
else
{
	$calendar_class = 'calendar_month';
	$tpl_body = 'calendar_body.tpl';
}

// process the display
if ( $calendar_class )
{
	$calendar = new $calendar_class($requester);
	$calendar->display();
	$parms = $calendar->parms;
	$template->set_filenames(array('body' => $tpl_body));
}
calendar_extend_template();

// navigation
$template->assign_vars(array(
	'L_CALENDAR_PAGE' => $page_title,
	'U_CALENDAR_PAGE' => $config->url('calendar', $parms, true),
));

// nothing to do, send message
if ( !$calendar_class )
{
	message_die(GENERAL_ERROR, 'Not_Authorised');
}
$calendar->destroy();
unset($calendar);

include($config->url('includes/page_header'));
$template->pparse('body');
include($config->url('includes/page_tail'));

?>