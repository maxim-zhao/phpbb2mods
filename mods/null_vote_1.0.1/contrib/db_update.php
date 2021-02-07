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


if( ($userdata['user_level'] != ADMIN) || (!$userdata['session_logged_in']) )
{
	message_die(GENERAL_MESSAGE, 'You are not authorised to access this page');
}


$page_title = 'Updating the database';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">';
echo '<tr><th>Updating the database (For Manipe's Null Vote MOD, v1.0.0a)</th></tr><tr><td><span class="genmedred"><ul type="circle">';


$sql = array("INSERT INTO " . CONFIG_TABLE . "(config_name, config_value) VALUES ('null_vote', '1')");

$is_error = false;
for( $i = 0; $i < count($sql); $i++ )
{
	if( !$result = $db->sql_query ($sql[$i]) )
	{
		$error = $db->sql_error();

		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
		$is_error = true;
	}
	else
	{
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#00AA00"><b>Successful</b></font></li><br />';
	}
}


echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';
if (!$is_error){
	echo '<tr><th>Installation Complete</th></tr><tr><td><span class="genmedred">Please be sure to delete this file now.<br />If you require any further assistance, please visit the <a href="http://www.phpbbhacks.com/forums">phpBBHacks.com Support Forums</a>.</span></td></tr>';
	echo '<tr><td class="catBottom" height="28" align="center"><span class="genmedred"><a href="' . append_sid("index.$phpEx") . '">Go back to your index page</a>.</span></td>';
}
echo '</table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>