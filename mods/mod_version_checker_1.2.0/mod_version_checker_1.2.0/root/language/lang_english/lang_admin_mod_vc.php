<?php

/***************************************************************************
 *                           lang_admin_mod_vc.php [English]
 *                           -------------------------------
 *     begin                : Mon Aug 22 2005
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *
 *     $Id: lang_admin_mod_vc.php,v 1.0.2.0 2006/05/16 18:38:17 chatasos Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// General
$lang['Mod_version_checker'] = 'MOD Version Checker';
$lang['Page_title'] = 'MOD Version Checker';
$lang['Mod_explain_before'] = 'Here you can check in the phpBB MODDB for new versions of your installed mods.';
$lang['Mod_explain_after'] = 'Below you can see which of your installed mods you selected, have new versions in the phpBB MODDB.';
$lang['Mod_explain_easymod'] = 'In order to check for updates for the EasyMOD installed mods you have to add them in the MOD Version Checker\'s table. Below you can choose which EasyMOD mods will be inserted in this table and which mods from the table will be updated with EasyMOD\'s mod details.';

// mod details
$lang['Modification'] = 'Modification';
$lang['Current_version'] = 'Current version<br />(Last updated)';
$lang['Action'] = 'Action';
$lang['Moddb_version'] = 'MODDB version<br />(Last checked)';
$lang['Mod_Download_link'] = 'Download link';
$lang['Check'] = 'Check';

$lang['Mod_name'] = 'Name';
$lang['Mod_author'] = 'Author';
$lang['Mod_version'] = 'Version';
$lang['Mod_category'] = 'Category';
$lang['Parse_mod_file'] = 'Parse mod file';
$lang['Edit'] = 'Edit';
$lang['Delete'] = 'Delete';

// buttons
$lang['Add_mod'] = 'Add new mod';
$lang['Add_easymod'] = 'Add EasyMOD mods';
$lang['Check_updates'] = 'Check for updates';
$lang['Reset_updates'] = 'Reset updates';
$lang['Return'] = 'Return';
$lang['Parse'] = 'Parse';
$lang['Submit'] = 'Submit';
$lang['Cancel'] = 'Cancel';

// messages
$lang['Mods_unknown_categories'] = '<span style="color: red">*</span> You have %s mod(s) belonging to Unknown categories';
$lang['Mods_not_checked'] = '<span style="color: red">+</span> You have %s mod(s) never checked before';
$lang['Explain_safe'] = '<b>Warning</b>: Your server\'s php is running in safe mode with a timeout of %s secs configured';

// legend
$lang['Status_older'] = 'Your mod is older';
$lang['Status_equal'] = 'Your mod is up to date';
$lang['Status_newer'] = 'Your mod is newer';
$lang['Status_other'] = 'Cannot compare';
$lang['Status_null']  = 'Your mod\'s version is null';

// titles
$lang['Installed_mods'] = 'Installed Modifications';
$lang['Updated_mods'] = 'Updated Modifications';
$lang['Checked_mods'] = 'Checked Modifications';

$lang['Click_return_version_checker'] = 'Click %sHere%s to return to the MOD Version Checker';

// inform/error messages
$lang['Checking_updates'] = 'Checking for updates in the phpBB MODDB.<br /><br />Now checking category "<b>%s</b>".<br /><br />Please wait...';
$lang['Error_messages'] = '%s error(s) encountered while checking for updates.';
$lang['Last_error_message'] = 'Last error was: <i>%s</i>';
$lang['Error'] = 'Error';

$lang['Mod_updates_reseted'] = 'Mod updates reseted successfully.';

$lang['No_mods_selected'] = 'No Mods selected.';
$lang['Mod_added'] = 'Mod added successfully.';
$lang['Mod_updated'] = 'Mod updated successfully.';
$lang['Mod_deleted'] = 'Mod deleted successfully.';
$lang['Mod_already_exists'] = 'A mod with the same name already exists.';

$lang['Confirm_delete_mod'] = 'Are you sure you want to delete this mod?';
$lang['Confirm_reset'] = 'Are you sure you want to reset these updates?';

$lang['Problem_file'] = 'There was a problem found while opening the file.';
$lang['Internal_error'] = 'An internal error happened. Please try again.';

$lang['Connect_socket_error'] = 'Unable to open connection to phpBB Server. ';
$lang['Socket_functions_nouse'] = 'Unable to use socket functions. ';
$lang['Socket_functions_noinit'] = 'Unable to initialize socket functions. ';

//
$lang['Add_new_mod_info'] = 'Add new mod information';
$lang['Edit_mod_info'] = 'Edit mod information';

// easymod
$lang['Easymod_version'] = 'EasyMOD\'s version<br />(Last processed)';
$lang['Easymod_mods'] = 'EasyMOD Installed Modifications';
$lang['Update'] = 'Update';
$lang['Insert'] = 'Insert';
//$lang['Our_version'] = 'Your version';

$lang['Easymods_added'] = '%s EasyMOD mod(s) added successfully.';
$lang['Easymods_updated'] = '%s EasyMOD mod(s) updated successfully.';

// various
$lang['Information'] = 'Information';
$lang['Yes'] = 'Yes';
$lang['No'] = 'No';
$lang['Select_all'] = '(Un)Select all';

?>
