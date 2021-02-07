<?php
/******************************************************************************************
 Uninstall_db_GSOFP_1.1.1-1.1.8.php version 1.1.8	
 for uninstalling sql for Guest See Only First Post 1.1.1 - 1.1.8	
******************************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//


if( !$userdata['session_logged_in'] )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . append_sid("login.$phpEx?redirect=Uninstall_db_GSOFP_1.1.1-1.1.8.$phpEx", true));
	exit;
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'You are not authorised to access this page');
}


$page_title = 'Updating the database';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">';
echo '<tr><th>Updating the database</th></tr><tr><td><span class="genmed"><ul type="circle">';


$sql = array();
$sql[] = "DELETE FROM `" . $table_prefix . "config` WHERE (`config_name`) = 'guest_alert_message_1' LIMIT 1";
$sql[] = "DELETE FROM `" . $table_prefix . "config` WHERE (`config_name`) = 'guest_alert_message_2' LIMIT 1";
$sql[] = "DELETE FROM `" . $table_prefix . "config` WHERE (`config_name`) = 'guest_may_see_posts' LIMIT 1";
$sql[] = "ALTER TABLE `" . $table_prefix . "forums` DROP `read_limited`";
$sql[] = "ALTER TABLE `" . $table_prefix . "forums` DROP `guest_sticky`";
$sql[] = "ALTER TABLE `" . $table_prefix . "forums` DROP `guest_announcement`";
$sql[] = "ALTER TABLE `" . $table_prefix . "forums` DROP `guest_polls`";
$sql[] = "ALTER TABLE `" . $table_prefix . "forums` DROP `guest_num_posts`";
$sql[] = "ALTER TABLE `" . $table_prefix . "forums` DROP `guest_override_conf`";
$sql[] = "DROP TABLE `" . $table_prefix . "GSOFP_stats`";

for( $i = 0; $i < count($sql); $i++ )
{
	if( !$result = $db->sql_query ($sql[$i]) )
	{
		$error = $db->sql_error();

		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
	}
	else
	{
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#00AA00"><b>Guests See Only First Post Successfull Uninstalled from the database</b></font></li><br />';
	}
}


echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';

echo '<tr><th>End</th></tr><tr><td><span class="genmed">Installation is now finished. Please be sure to delete this file now.<br />If you have run into any errors, please visit the <a href="http://www.phpbbsupport.co.uk" target="_phpbbsupport">phpBBSupport.co.uk</a> and ask someone for help.</span></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Have a nice day</a></span></td></table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>