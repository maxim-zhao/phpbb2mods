<?php
/******************************************************************************************
 GSOFP_1.1.8_db_install.php version 1.1.8	
 for sql for Guest See Only First Post 1.1.8	
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
	header($header_location . append_sid("login.$phpEx?redirect=GSOFP_1.1.8_db_install.$phpEx", true));
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
	$sql[] = "CREATE TABLE " . $table_prefix . "GSOFP_stats (`GSOFP_logins` int(10) NOT NULL default '0', `GSOFP_registers` int(10) NOT NULL default '0', `GSOFP_shows` int(10) NOT NULL default '0', `GSOFP_reallogins` int(10) NOT NULL default '0', `GSOFP_realregisters` int(10) NOT NULL default '0', PRIMARY KEY  (`GSOFP_logins`))";
	$sql[] = "INSERT INTO " . $table_prefix . "GSOFP_stats (`GSOFP_logins`, `GSOFP_registers`, `GSOFP_shows`, `GSOFP_reallogins`, `GSOFP_realregisters`) VALUES (0, 0, 0, 0, 0)";
	$sql[] = "INSERT INTO ".$table_prefix."config (`config_name`, `config_value`) VALUES ('guest_may_see_posts', '1')";
	$sql[] = "INSERT INTO ".$table_prefix."config (`config_name`, `config_value`) VALUES ('guest_alert_message_1', '<font color=\"red\"><b>There are in this topic %p posts to view if you are logged in.</b></font>')";
	$sql[] = "INSERT INTO ".$table_prefix."config (`config_name`, `config_value`) VALUES ('guest_alert_message_2', '<br /><b>Go to the ACP/General Admin/Configuration to define your own message to display here.</b>')";
	$sql[] = "ALTER TABLE ".$table_prefix."forums ADD read_limited TINYINT(1) NULL DEFAULT '1'";
	$sql[] = "ALTER TABLE ".$table_prefix."forums ADD guest_sticky TINYINT(1) NULL DEFAULT '1'";
	$sql[] = "ALTER TABLE ".$table_prefix."forums ADD guest_announcement TINYINT(1) NULL DEFAULT '1'";
	$sql[] = "ALTER TABLE ".$table_prefix."forums ADD guest_polls TINYINT(1) NULL DEFAULT '1'";
	$sql[] = "ALTER TABLE ".$table_prefix."forums ADD guest_num_posts TINYINT(3) NULL DEFAULT '1'";
	$sql[] = "ALTER TABLE ".$table_prefix."forums ADD guest_override_conf TINYINT(1) NULL DEFAULT '0'";

for( $i = 0; $i < count($sql); $i++ )
{
	if( !$result = $db->sql_query ($sql[$i]) )
	{
		$error = $db->sql_error();

		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
	}
	else
	{
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#00AA00"><b>Guests See Only First Post Successfull Installed into the database</b></font></li><br />';
	}
}


echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';

echo '<tr><th>End</th></tr><tr><td><span class="genmed">Installation is now finished. Please be sure to delete this file now.<br />If you have run into any errors, please visit the <a href="http://www.phpbbsupport.co.uk" target="_phpbbsupport">phpBBSupport.co.uk</a> and ask someone for help.</span></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Have a nice day</a></span></td></table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>