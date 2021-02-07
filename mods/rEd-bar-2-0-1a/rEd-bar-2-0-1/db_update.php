<?php
/***************************************************************************
 *                               db_update.php
 *                            -------------------
 *
 *   copyright            : ©2003 Freakin' Booty ;-P & Antony Bailey
 *   project              : http://sourceforge.net/projects/dbgenerator
 *   Website              : http://freakingbooty.no-ip.com/ & http://www.rapiddr3am.net
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
	header($header_location . append_sid("login.$phpEx?redirect=db_update.$phpEx", true));
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
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name1', 'link 1')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link1', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name2', 'link 2')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link2', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name3', 'link 3')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link3', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name4', 'link 4')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link4', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name5', 'link 5')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link5', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name6', 'link 6')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link6', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name7', 'link 7')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link7', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name8', 'link 8')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link8', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name9', 'link 9')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link9', 'http://')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_name10', 'link 10')";
$sql[] = "INSERT INTO " . $table_prefix . "config (config_name, config_value)
 VALUES ('nav_link10', 'http://')";

for( $i = 0; $i < count($sql); $i++ )
{
	if( !$result = $db->sql_query ($sql[$i]) )
	{
		$error = $db->sql_error();

		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
	}
	else
	{
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#00AA00"><b>Successfull</b></font></li><br />';
	}
}


echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';

echo '<tr><th>End</th></tr><tr><td><span class="genmed">Installation is now finished. Please be sure to delete this file now.<br />If you have run into any errors, please visit the <a href="http://www.phpbbsupport.co.uk" target="_phpbbsupport">phpBBSupport.co.uk</a> and ask someone for help.</span></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Have a nice day</a></span></td></table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>