<?php
/***************************************************************************
 *                            mod_calendar.php
 *                            ------------------------
 *	begin			: 10/08/2003
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 1.0.2 - 25/04/2006
 *
 *	mod version		: calendar v 1.2.0
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

// service functions
include_once( $phpbb_root_path . 'includes/functions_mods_settings.' . $phpEx );

// mod definition
$list_default_yes_no = array(0 => 'Default', 1 => 'Yes', 2 => 'No');
$mod_name = 'Calendar';
$config_fields = array(

	'calendar_javascript' => array(
		'lang_key'	=> 'Calendar_use_java',
		'type'		=> 'LIST_RADIO',
		'default'	=> 'Default',
		'user'		=> 'user_calendar_javascript',
		'values'	=> $list_default_yes_no,
		),

	'calendar_overview' => array(
		'lang_key'	=> 'Calendar_overview',
		'type'		=> 'LIST_RADIO',
		'default'	=> 'Default',
		'user'		=> 'user_calendar_overview',
		'values'	=> $list_default_yes_no,
		),

	'calendar_display_open' => array(
		'lang_key'	=> 'Calendar_display_open',
		'type'		=> 'LIST_RADIO',
		'default'	=> 'No',
		'user'		=> 'user_calendar_display_open',
		'values'	=> $list_default_yes_no,
		),

	'calendar_header_cells' => array(
		'lang_key'	=> 'Calendar_header_cells',
		'type'		=> 'TINYINT',
		'default'	=> 7,
		'user'		=> 'user_calendar_header_cells',
		),

	'calendar_week_start' => array(
		'lang_key'	=> 'Calendar_week_start',
		'type'		=> 'LIST_RADIO',
		'default'	=> $lang['datetime']['Monday'],
		'user'		=> 'user_calendar_week_start',
		'values'	=> array(
			$lang['datetime']['Sunday'] => 0,
			$lang['datetime']['Monday'] => 1,
			),
		),

	'calendar_title_length' => array(
		'lang_key'	=> 'Calendar_title_length',
		'type'		=> 'TINYINT',
		'default'	=> 30,
		),

	'calendar_text_length' => array(
		'lang_key'	=> 'Calendar_text_length',
		'type'		=> 'SMALLINT',
		'default'	=> 200,
		),

	'calendar_nb_row' => array(
		'lang_key'	=> 'Calendar_nb_row',
		'type'		=> 'TINYINT',
		'user'		=> 'user_calendar_nb_row',
		'default'	=> 5,
		),
);

// init config table
init_board_config($mod_name, $config_fields);

?>