<?php
/***************************************************************************
*						 lang_admin_color.php
*							--------------
*	begin		: 30/09/2005
*	copyright	: phantomk
*	email		: phantomk@modmybb.com
*
*	Version		: 0.0.6 - 24/1/2006
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

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

//
// CH Specific
//
$lang['Enable_cache_colors'] = 'Enable group colors table cache';
$lang['Cache_succeed_colors'] = 'Group colors table cache succeed. The cache has been enabled.';
$lang['Cache_failed_colors'] = 'Group colors table cache failed. The cache has been disabled.';

//
// Multi-Page
//
$lang['AGCM_colors'] = 'Colors';
$lang['AGCM_color_admin'] = 'Group Color Administration';
$lang['AGCM_color_admin_explain'] = 'From this panel you can select different colors for all the groups for each style, select if each group is displayed in the legend, and the order of which they are displayed in the legend.';

//
// Style Select
//
$lang['AGCM_select_style'] = 'Select a Style';
$lang['AGCM_look_up_group_color'] = 'Look up group colors';
$lang['AGCM_edit_all'] = 'Edit all styles';

//
// Style Edit
//
$lang['AGCM_color'] = 'Group Color:';
$lang['AGCM_color_explain'] = 'Enter a 6 digit color code for this group or you can click on "Find a Color" to choose a color from the color picker.';
$lang['AGCM_edit_style'] = 'Edit %s\'s Group Colors'; // Edit subSilver's Group Colors
$lang['AGCM_find_color'] = 'Find a Color';
$lang['AGCM_legend'] = 'Group Displayed in Legend:';
$lang['AGCM_down'] = 'Move Down';
$lang['AGCM_up'] = 'Move Up';
$lang['AGCM_session'] = 'Inactive User\'s Color:';
$lang['AGCM_session_explain'] = 'Enter a 6 digit color code for Inactive Users or you can click on "Find a Color" to choose a color from the color picker.  Inactive User\'s are defined by the Inactive Session Time and can be disabled.';
$lang['AGCM_anonymous'] = 'Anonymous User\'s Color:';
$lang['AGCM_anonymous_explain'] = 'Enter a 6 digit color code for Anonymous Users or you can click on "Find a Color" to choose a color from the color picker.';
$lang['AGCM_registered'] = 'Registered User\'s Color:';
$lang['AGCM_registered_explain'] = 'Enter a 6 digit color code for Registered Users or you can click on "Find a Color" to choose a color from the color picker.';
$lang['AGCM_time'] = 'Inactive Session Time:';
$lang['AGCM_time_explain'] = 'Assign the time that a users color will change to if they have been inactive on the board for the defined time. (Anonymous users are unaffected)';
$lang['AGCM_check'] = 'Enable the session color on the board:';
$lang['AGCM_editing_all'] = 'Editing all styles';

//
// agcm_time select
//
$lang['AGCM_15_minute'] = '15 minute\'s';
$lang['AGCM_1_hour'] = '1 hour';
$lang['AGCM_12_hour'] = '12 hour\'s';
$lang['AGCM_1_day'] = '1 day or 24 hour\'s';
$lang['AGCM_2_day'] = '2 day\'s or 48 hour\'s';
$lang['AGCM_1_week'] = '1 week or 7 day\'s';

//
// Messages
//
$lang['AGCM_click_return_color_admin'] = 'Click %sHere%s to return to the Colors Group Administration.'; // 'Here' is a link
$lang['AGCM_update_successfull'] = 'The Theme group colors were successfully updated';
$lang['AGCM_no_style_exists'] = 'No such style exists.';

//
// Version Check
//
$lang['advanced_group_color_management'] = 'Advanced Group Color Management';
$lang['mod_up_to_date'] = 'Your installation of %s is up to date, no updates are available';
$lang['mod_not_up_to_date'] = 'Your installation of %s does <b>not</b> seem to be up to date. Updates are available at <a href="http://www.modmybb.com/" target="_new">http://www.modmybb.com/</a>.';
$lang['current_mod_version'] = 'The latest available version is <b>%s</b>.';
$lang['installed_mod_version'] = 'You are running version <b>%s</b>.';
$lang['mod_version_information'] = 'ModMyBB Installed Mods Version Information';

?>