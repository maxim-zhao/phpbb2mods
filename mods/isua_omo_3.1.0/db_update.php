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
/***************************************************************************
 *
 *	This File Must Be In The "root" Folder!
 *	
 *	ISUA Mods
 *	http://www.support.isua.co.uk/
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
	message_die(GENERAL_MESSAGE, 'You Are Not Authorised To Access This Page<br /><a href="' . append_sid("index.$phpEx") . '">Please Leave!</a>');
}


$page_title = 'ISUA Mods :: Updating The Database';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">';
echo '<tr><th>Updating The SQL Database</th></tr><tr><td><span class="genmed"><ul type="circle">';


$sql = array();
$sql[] = "INSERT INTO " . $table_prefix . "config VALUES ('ISUA_Mouse1', '#00FFFF')";
$sql[] = "INSERT INTO " . $table_prefix . "config VALUES ('ISUA_Mouse2', '#EFEFEF')";

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


echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';
echo '<tr><th>Installation Complete</th></tr><tr><td><span class="genmed">Please be sure to delete this file now.<br />If you require any further assistance, please visit the <a href="http://www.support.isua.co.uk/viewforum.php?f=3">ISUA Support Forum</a>.</span></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Go back to your index page</a>.</span></td></table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>