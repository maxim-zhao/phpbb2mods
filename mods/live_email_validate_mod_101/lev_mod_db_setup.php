<?php
/***************************************************************************
 *                            lev_mod_db_setup.php
 *                            --------------------
 *
 *   copyright            : ©2003 Freakin' Booty ;-P & Antony Bailey
 *   project              : http://sourceforge.net/projects/dbgenerator
 *   Website              : http://freakingbooty.no-ip.com/ & http://www.rapiddr3am.net
 *
 *   updated by           : Wulf_9, ©2005
 *   website              : soon
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
define('IN_UPDATE', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.' . $phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

// Allow for this script to run as any filename
//
$scriptname = basename(__FILE__);

if (!$userdata['session_logged_in'])
{
	$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . append_sid("login.$phpEx?redirect=$scriptname", true));
	exit;
}

if ($userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_MESSAGE, 'You are not authorised to perform this action');
}

$page_title = 'Database Update';
include($phpbb_root_path . 'includes/page_header.' . $phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="4" border="0" class="forumline">';
echo '<tr><th>Updating the Database</th></tr><tr><td><span class="genmed"><ul type="circle">';

$sql = array();

$sql[] = "INSERT INTO `" . $table_prefix . "config` (`config_name`, `config_value`) VALUES ('live_email_validation', '1')";

for( $i = 0; $i < count($sql); $i++ )
{
	if( !$result = $db->sql_query ($sql[$i]) )
	{
		$error = $db->sql_error();
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
	}
	else
	{
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#00AA00"><b>Successful</b></font></li><br />';
	}
}

echo '</ul></span></td></tr><tr><td class="catbottom" height="28">&nbsp;</td></tr>';
echo '<tr><th>End</th></tr><tr><td><center><span class="gen">Update is finished. Please be sure to delete this file now!<br />';
echo 'You will find the LEV option in your ACP under `General Admin` -> Configuration`<br />';
echo 'It is enabled by default, disable it if you do NOT want to have any email addresses verified after submission.</span></center></td></tr>';
echo '<tr><td class="catbottom" height="28" align="center"><span class="genmed">';
echo '<a href="' . append_sid("index.$phpEx") . '">Back to forum index</a></span></td></table>';

include($phpbb_root_path . 'includes/page_tail.' . $phpEx);
?>
