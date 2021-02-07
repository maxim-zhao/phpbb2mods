<?php
/***************************************************************************
 *                               mod_uninstall.php
 *                            -------------------
 *   begin                : Sunday, April 14, 2002
 *   copyright            : (C) 2003 Onno van Knotsenburg
 *   email                : knotsenburg@hotmail.com
 *
 *   $Id: mod_uninstall.php,v 1.1.0 2003/09/02 21:21:21 explosive Exp $
 *
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
$phpbb_root_path='./';
include($phpbb_root_path.'extension.inc');
include($phpbb_root_path.'common.'.$phpEx);

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
	header('Location: ' . append_sid("login.$phpEx?redirect=mod_uninstall.$phpEx", true));
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

$sql = array();
$sql[] = "DELETE FROM " . CONFIG_TABLE . " WHERE config_name = 'no_post_count_forum_id'";


$sql_count = count($sql);

echo "<html>\n";
echo "<body>\n";

for($i = 0; $i < $sql_count; $i++)
{
	echo "Running :: " . $sql[$i];
	flush();

	if ( !$db->sql_query($sql[$i]) )
	{
		$errored = true;
		$error = $db->sql_error();
		echo " -> <b>FAILED</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
	}
	else
	{
		echo " -> <b>COMPLETED</b><br /><br />\n\n";
	}
}

if( $errored )
{
    $message = "Some of the querys have failed.<br />Please consult the support topic on <a href='www.phpbb.com' target='_blank'>www.phpbb.com</a> for some help.";
}
else
{
    $message = "All changes to the tables have been removed. You may now remove all files for this mod.";
}

echo "\n<br />\n<b>COMPLETE!</b><br />\n";
echo $message . "<br />\n";
echo "</body>\n";
echo "</html>\n";
exit();

?>
