<?php

/***************************************************************************
 *                            mod_example.php
 *                            ---------------
 *	begin			: 
 *	copyright		: 
 *	email			: 
 *	version			: 0.0.0 - xx/xx/xxxx
 *
 *	mod version		: exameple v 0.0.0
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

//-- sample ---------------------------------
// services functions
//-------------------------------------------
//
//	DATEFMT format service functions :
//	---------------------------------
//		mods_settings_get_datefmt() : return the datefmt input fields definition
//		mods_settings_check_datefmt() : check and format the datefmt fields value
//
//-------------------------------------------
if (!function_exists(mods_settings_get_datefmt))
{
	function mods_settings_get_datefmt($field, $value)
	{
		global $board_config, $lang, $userdata;

		// define a set of date presentation
		$timeset = array(
			'D m d, Y g:i a', 
			'D d-m-Y, G:i', 
			'M Y, D d, g:i a', 
			'D d M Y, G:i', 
			'd M Y h:i a', 
			'd M Y, G:i',
			'D M d, Y g:i a',
			'D M d, Y G:i',
		);

		// build the date format list
		$s_time = '<select name="timeformat" onChange="' . $field . '.value=this.options[this.selectedIndex].value;">';
		$time = time();
		$found = false;
		for ($i=0; $i < count($timeset); $i++)
		{
			$selected = ($value == $timeset[$i]) ? ' selected="selected"' : '';
			if ($selected != '') $found = true;
			$s_time .= '<option value="' . $timeset[$i] . '"' . $selected . '>' . create_date($timeset[$i], $time, $userdata['user_timezone']) . '</option>';
		}
		$selected = ( !$found ) ? ' selected="selected"' : '';
		$s_time .= '<option value=""' . $selected . '>' . $lang['Other'] . '</option></select>';

		$res = $s_time . '&nbsp;<input type="text" name="' . $field . '" value="' . $value . '" maxlength="14" class="post" />';

		return $res;
	}
}

if (!function_exists(mods_settings_check_datefmt))
{
	function mods_settings_check_datefmt($field, $value)
	{
		global $error, $error_msg, $lang;

		$res = trim(str_replace("\'", "''", htmlspecialchars($value)));
		return $res;
	}
}
//-------------------------------------------


//--------------------------------------------------------------------------------------------------
//	config_field array : structure
//  ------------------------------
//		key => array() : key is the name of the config entry
//
//			'lang_key'	: $lang[] entry : column heading for the config entry
//
//			'explain'	: $lang[] entry : column heading - detailed explanation
//
//			'type'		: type of the field : values allowed :
//							'LIST_RADIO' : a set of radio button : require the 'values' array to be defined
//							'LIST_DROP' : drop down list : require the 'values' array to be defined
//							'TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT' : integer (the lenght of the input zone varys)
//							'VARCHAR' : string field
//							'HTMLVARCHAR' : string field allowing HTML in it
//							'TEXT' : text box field
//							'HTMLTEXT' : text box fied allowing HTML in it
//
//						other values will require get_func and chk_func to be provided
//
//			'default'	: $lang[] entry if exists : default value for the field
//
//			'values' => array() : set of values for LIST_* type fields
//				'Cst'	=> value : 'Cst' is a $lang[] entry, value the value that will be returned (so stored)
//
//			'user'		: field name : name of the users table field for preferences if defined
//
//			'hide'		: boolean : if true, the field won't be displayed, nor in admin nor in users prefs
//									The config value will be created and initiate
//
//			'get_func'	: function name : this allows to add other types that the one implemented in the basic version.
//						parms description : func(parm1, parm2) returns $result
//							- parm1 : $fied_name : the name of the field that has to appear on the input statement
//							- parm2 : $value : the current value of the field
//							- result : the function has to return a full html sentence, ie :
//								return '<input type="post" name="' . $field_name . '" value="' . $value .'" />';
//
//			'chk_func'	: function name : this allows to add other types (cf. get_func parm)
//						parms description : func(parm1, parm2) returns $result :
//							- parm1 : fied_name : the name of the field that appears on the input statement
//							- parm2 : value inputed (equal to $HTTP_POST_VARS[$field_name])
//							- result : the value ready to be inserted in the sql statement, ie :
//								return trim(str_replace("\'", "''", htmlspecialchars($value)));
//
//							global vars : your can use :
//							- $error : boolean value : set it to yes to break with an error,
//							- $error_msg : error message that will be displayed if error = true
//
//
//			'auth'		: none or USER, ADMIN, BOARD_ADMIN (admin and board_admin are the same without the Profile Control Panel)
//							this allows to restrict some fields only to the admins
//
//			'system'	: allows to set fields without updating config or users table
//--------------------------------------------------------------------------------------------------

// mod definition
$mod_name = 'Example_setting';		// $lang[] entry : will be the sub-menu option name

$mod_sort = 0;						// facultative : use it to sort the mods in the menu
$sub_name = 'Sub_option';			// facultative : $lang[] entry : when provided, will create a sub-menu
$sub_sort = 0;						// facultative : use it to sort the sub-menu options
$mod_main_menu = 'Preferences';		// facultative : $lang[] entry : use it to group mods under a new menu ("profile_options.$phpEx?mode=$mod_main_menu")
$mod_main_sort = 0;					// facultative : use it to sort the menus in the config+ option in the ACP

$config_fields = array(

// a three options custom drop down list, default value being 1 (Medium)
	'key1' => array(
		'lang_key'	=> 'Key1',
		'explain'	=> 'Key1_explain',
		'type'		=> 'LIST_DROP',
		'default'	=> 'Medium',
		'user'		=> 'user_key1',
		'values'	=> array(
			'None'		=> 0,
			'Medium'	=> 1,
			'Full'		=> 2,
			),
		),

// standard yes/no option, default value being 1 (Yes)
	'key2' => array(
		'lang_key'	=> 'Key2',
		'type'		=> 'LIST_RADIO',
		'default'	=> 'Yes',
		'user'		=> 'user_key2',
		'values'	=> $list_yes_no,
		),

// minimal requirement
	'key3' => array(
		'lang_key'	=> 'Key3',
		'type'		=> 'TINYINT',
		'default'	=> 40,
		),

// undefined type
	'key3' => array(
		'lang_key'	=> 'Key4',
		'type'		=> 'DATEFMT',
		'default'	=> 'D M d, Y g:i a',
		'get_func'	=> 'mods_settings_get_datefmt',
		'chk_func'	=> 'mods_settings_check_datefmt',
		),
);

// init config table
init_board_config($mod_name, $config_fields, $sub_name, $sub_sort, $mod_sort, $mod_main_menu, $mod_main_sort);	// $sub_name, $sub_sort, $mod_sort, $mod_main_menu and $mod_main_sort are facultatives : you can omit them

?>