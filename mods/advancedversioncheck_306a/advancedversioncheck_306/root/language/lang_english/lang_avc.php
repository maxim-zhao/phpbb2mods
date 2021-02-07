<?php
/***************************************************************************
 *                              lang_avc.php
 *                            -------------------
 *   begin                : May 17, 2005
 *   author               : Fountain of Apples < webmacster87@gmail.com >
 *   copyright            : (C) 2005-2006 Douglas Bell
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

/* All lang tags for Advanced Version Check in here. */

//
// Format is same as lang_main
//

//
// Version Check Summary & Admin Index Summary
//
$lang['Version_check_explain'] = 'Using this facility, you can see whether the various MODs you have installed are up-to-date. If they are not up-to-date, then the version number in the Latest Version column will be red, and an update is recommended. You can disable or enable the individual checkers here in the Enable/Disable Checkers panel, and set configuration options for the version check system in the Version Check Configuration Panel. Note that this information may not be up-to-date; click the Run Check button to update the information.';
$lang['Version_check'] = 'Version Check';
$lang['Version_up_to_date_short'] = 'Up to Date';
$lang['Version_not_up_to_date_short'] = 'NOT UP TO DATE!';
$lang['Error_connect_socket'] = '<b>Error:</b><br />%s'; // %s displays the error information, this is set by default in any page that uses the Version Check
$lang['No_socket_functions'] = '<b>Error:</b><br />Unable to use socket functions.';
$lang['MOD_Name'] = 'MOD Name';
$lang['Download'] = 'Download';
$lang['Re-check'] = 'Re-check';
$lang['Latest_version'] = 'Latest Version';
$lang['Current_version'] = 'Current Version';
$lang['MOD_Status'] = 'MOD Status';
$lang['Index_summary_explain'] = 'The following is a list of MODs that are not up-to-date. You can see full details at the %sVersion Check%s page. This list can be disabled via the Version Check Configuration page.'; // <a href>, </a> tags
$lang['MODs_uptodate'] = 'All MODs are Up-to-Date.';
$lang['Last_Updated'] = 'Last Updated: '; // This is used for the Last Updated: timestamp in the Version Check Summary. The timestamp will immediately follow this.
$lang['Result_new_vers_available'] = 'A new version of this MOD is available!';
$lang['Result_have_latest'] = 'You are running the latest version of this MOD.';
$lang['Error_occured'] = 'An Error Occurred!';
$lang['Secondary_version_msg'] = '<i><b>Note:</b> A %s version of this MOD, version %s, is available. Check on the MOD\'s webpage for more info.</i>'; // MOD development status, version number
$lang['stable'] = 'stable';
$lang['development'] = 'development';
$lang['Not_specified'] = 'Not Specified';
$lang['More_info'] = 'More Info';

//
// Checker Management page
//
$lang['Version_Manager'] = 'Enable/Disable Checkers';
$lang['Version_Manager_explain'] = 'From here you can enable or disable individual version checkers. If disabled, the checker will not display on the Version Check page, or the Admin Index.';
$lang['Check_disable'] = 'Check Disable';
$lang['Check_enable'] = 'Check Enable';
$lang['Run_check'] = 'Run Check';
$lang['Run_all_checks'] = 'Run All Checks';
// Added in 3.0.5:
$lang['Checker_status_updated'] = 'Checker statuses updated successfully.';
$lang['Click_return_enable_disable'] = 'Click %shere%s to return to the Enable/Disable Checkers panel.';

//
// Information Boxes
//
$lang['Click_return_versionmanage'] = 'Click %sHere%s to return to the Enable/Disable Page';
$lang['Click_return_version'] = 'Click %sHere%s to return to the Version Check page';
$lang['Version_updated'] = 'Version Check Information Updated Successfully';
$lang['No_Config_Info'] = 'Could not query config information';
$lang['Update_failed'] = 'Failed to update general configuration for %s'; // Name of configuration option
$lang['Status_no_Update'] = 'Could not update status';
$lang['No_Version'] = 'Could not get Version Check data from database';
$lang['Connection_error'] = 'Connection Error';
$lang['No_socket'] = 'Socket Functions Disabled';
/*****/
$lang['No_Version_Config'] = 'Could not select Version Check Configuration info from database.';
$lang['Cant_update_config'] = 'Could not update Version Check Configuration for %s.'; // $config_name
$lang['Version_config_updated'] = 'Version Check Configuration has been updated successfully.';
$lang['No_Version_Log'] = 'Could not select log data from database.';
$lang['No_Update_Log'] = 'Could not update Version Check log.';
$lang['No_Delete_Log'] = 'Could not delete log entry %s from database.'; // $log_id
$lang['No_MOD_Status'] = 'Could not select MOD status info from database.';
$lang['No_MOD_Status_update'] = 'Could not update MOD status of %s.';
$lang['No_Version_Data'] = 'Could not select Version Check data from database.';
$lang['No_add_phpBB_version'] = 'Could not add phpBB Version to the Version Check table.';
$lang['No_new_MOD'] = 'Could not add new MOD to the Version Check table.';
$lang['No_update_MOD'] = 'Could not update MOD statistics in the Version Check table.';
$lang['No_delete_MOD'] = 'Could not delete unused MOD data from the Version Check table.';
$lang['No_error_msg'] = 'Could not send error message to database. Original error message was: %s'; // $error_msg
$lang['No_error_msg_MODID'] = 'MOD ID: %s'; // $mod_id
$lang['No_admin_addresses'] = 'Could not retrieve admin e-mail addresses from database to send AVC e-mail.';
$lang['No_PM_info'] = 'Could not get PM data for sending AVC Private Message.';
$lang['No_post_info'] = 'Could not get data for inserting AVC post.';
$lang['No_update_version_table'] = 'Could not update Version Check table with info for %s'; // MOD Name
$lang['No_checker_ID'] = 'No Checker ID was specified.';
$lang['No_find_oldest_privmsgs'] = 'Could not find oldest privmsgs (inbox)';
$lang['No_delete_oldest_privmsgs'] = 'Could not delete oldest privmsgs (inbox)';
$lang['No_delete_oldest_privmsgs_text'] = 'Could not delete oldest privmsgs text (inbox)';
$lang['No_PM_sent_info'] = 'Could not insert/update private message sent info.';
$lang['No_PM_sent_text'] = 'Could not insert/update private message sent text.';
$lang['No_PM_read_status'] = 'Could not update private message new/read status for user';
$lang['No_AVC_post'] = 'Could not insert AVC post.';
$lang['No_retrievable'] = 'Could not open retrievable file.';
$lang['No_retrievable_socket'] = 'Socket functions are disabled. Could not open retrievable file.';
$lang['Invalid_retrievable'] = 'Retrievable file does not use a valid extension.';

//
// Version Check Configuration page
//
$lang['Version_check_config'] = 'Version Check Configuration';
$lang['Version_Config_explain'] = 'Here you can set various configuration options for the Version Check system. An explanation of each option available to you is provided.';
$lang['One_Address'] = 'One Address';
$lang['One_User'] = 'One User';
$lang['All_Admins'] = 'All Admins';
$lang['Version_check_interval'] = 'Version Checking Interval:';
$lang['Version_Check_Time_explain'] = 'Determines how often the version check automatically runs. Note that you can override this by clicking on the \'Run Check\' or \'Run All Checks\' button on the Version Check page.';
$lang['Background_check'] = 'Run Version Checks in Background:';
$lang['Background_check_explain'] = 'If set, version checks will be automatically run in the background according to the specified checking interval above.';
$lang['Admin_index_summary'] = 'Show Admin Index Summary:';
$lang['Allow_Index_explain'] = 'If set, will show a summary of all the MODs that are not up-to-date on the Admin Index. Note that the phpBB Version Check info will be displayed regardless of this setting.';
$lang['Email_on_update'] = 'Send E-mail On Update:';
$lang['Email_on_update_explain'] = 'Sends an e-mail if a MOD is updated. If \'One Address\' is selected, the e-mail will only be sent to the address specified below. If \'All Admins\' is specified, the e-mail will be sent to all administrators of this board.';
$lang['Send_email_address'] = 'E-mail Address to Send To:';
$lang['Send_email_address_explain'] = 'If \'One Address\' is specified above, the e-mail will be sent to this address. Otherwise, this option will be ignored.';
$lang['PM_on_update'] = 'Send PM On Update:';
$lang['PM_on_update_explain'] = 'Sends a private message if a MOD is updated. If \'One User\' is selected, the PM will only be sent to the user specified below. If \'All Admins\' is specified, the PM will be sent to all administrators of this board.';
$lang['Send_PM_user'] = 'User to Send PM To:';
$lang['Send_PM_user_explain'] = 'If \'One User\' is specified above, the private message will be sent to this user. Otherwise, this option will be ignored.';
$lang['Post_on_update'] = 'Insert Post on Update:';
$lang['Post_on_update_explain'] = 'Inserts a post to the forum specified below if a MOD is updated.';
$lang['Update_post_forum'] = 'Forum to Insert Post:';
$lang['Update_post_forum_explain'] = 'If a post will be inserted (see above), it will be inserted into this forum.';
$lang['CH_bad_post_forum'] = 'The forum you selected is not a \'Forum\' type. The forum you select cannot be a Category or a Link.';
$lang['Update_post_contents'] = 'Post Contents:';
$lang['Update_post_contents_explain'] = 'If a post will be inserted (see above), this will be the contents of the post. <b>&%n</b> represents the name of the updated MOD. <b>&%v</b> represents the new version of the MOD (the one you need to update to). <b>&%c</b> represents the version of the MOD that is installed. <b>&%u</b> represents the URL of the MOD\'s website. <b>&%d</b> represents the URL of the MOD\'s download link. <b>&%a</b> will display any notes that are associated with the MOD.';
$lang['Update_post_contents_default'] = 'Hello,

This is a notification that &%n has been updated to version &%v. The version of this MOD installed on this site is &%c. You should update soon.

&%a

You can download the latest version of &%n here: &%d
For more info, visit its website: &%u';
$lang['Notes_from_author'] = 'Notes From Author:';
$lang['avc_check_int']['3600'] = '1 Hour';
$lang['avc_check_int']['7200'] = '2 Hours';
$lang['avc_check_int']['10800'] = '3 Hours';
$lang['avc_check_int']['21600'] = '6 Hours';
$lang['avc_check_int']['32400'] = '9 Hours';
$lang['avc_check_int']['43200'] = '12 Hours';
$lang['avc_check_int']['64800'] = '18 Hours';
$lang['avc_check_int']['86400'] = '24 Hours';
$lang['avc_check_int']['129600'] = '36 Hours';
$lang['avc_check_int']['172800'] = '48 Hours';
$lang['avc_check_int']['259200'] = '72 Hours';

//
// Version Check Log
//
$lang['Log_MOD_updated'] = 'New Version became %s'; // New version
$lang['Log_MOD_current'] = 'Installed MOD updated to %s'; // Current version
$lang['Log_MOD_inserted'] = 'MOD Check added';
$lang['Log_MOD_deleted'] = 'MOD Check removed';
$lang['Log_MOD_disabled'] = 'Check disabled';
$lang['Log_MOD_enabled'] = 'Check enabled';
$lang['Update_log'] = 'AVC Update Log';
$lang['Update_log_explain'] = 'The AVC Update Log logs version-checking history, including when a checker was added, removed, enabled, or disabled, and when a new release of a MOD was posted or when it was updated on this board. You can remove an entry by selecting it and clicking on \'Delete Entries\'.';
$lang['Time'] = 'Time';
$lang['Log_message'] = 'Log Message';
$lang['Delete_entries'] = 'Delete Selected Entries';
$lang['Entries_deleted'] = 'The selected entries have been successfully deleted.';
$lang['Click_return_version_log'] = 'Click %sHere%s to return to the Version Check log.';

//
// Download phpBB Page
//
$lang['Download_phpBB'] = 'Download phpBB';
$lang['phpBB_version'] = 'phpBB Version';
$lang['Download_phpBB_page_explain'] = 'The following are a list of links that you can use to download phpBB, as well as information regarding which link you should use. Provided are also links to a tutorial on upgrading phpBB and a link to the phpBB.com Mailing List, where you can receive information on updates to phpBB via e-mail.';
$lang['Downloads_page'] = 'Download the latest version of phpBB from the <a href="http://www.phpbb.com/downloads.php" target="_blank">phpBB Downloads page</a>.';
$lang['Code_changes'] = 'If you have a lot of MODs or complex styles installed, you may wish to use one of<br />the phpBB <a href="http://www.phpbb.com/phpBB/catdb.php?cat=48" target="_blank">Code Changes MODs</a> instead.';
$lang['Upgrade_tutorial'] = 'Don\'t know how to upgrade? Take a look at <a href="http://www.phpbb.com/kb/article.php?article_id=271" target="_blank">this upgrading tutorial</a>.';
$lang['Mailing_list'] = 'To keep notified about phpBB updates and other phpBB-related news,<br /><a href="http://www.phpbb.com/support/" target="_blank">subscribe to the phpBB.com mailing list</a>.';

//
// Version Check Notification System
//
$lang['VCNS_post_subject'] = '[AVC] %s has been updated!'; // Name of MOD
$lang['VCNS_PM_msg'] = 'Hello,

This is a notification that %s has been updated to version %s. The version of this MOD installed on %s is %s. You should update soon.

You can download the latest version of %s here: %s
For more info, visit its website: %s

You have received this e-mail because an administrator of %s requested that this e-mail be sent here. If you did not request this or have any problems, please contact the board administrator.'; // MOD Name, Latest Version, Sitename, Current Version, MOD Name, Download Link, MOD Link, Sitename

//
// That's all, folks!
// -------------------------------------------------

?>