<?php
/***************************************************************************
 *                               mod_install.php
 *                            -------------------
 *   begin                : Sunday, April 14, 2002
 *   copyright            : (C) 2003 Onno van Knotsenburg
 *   email                : knotsenburg@hotmail.com
 *
 *   $Id: mod_install.php,v 1.1.0 2003/09/02 21:21:21 explosive Exp $
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
	header('Location: ' . append_sid("login.$phpEx?redirect=mod_install.$phpEx", true));
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

if( !strstr($dbms, "mysql") )
{
    if( !isset($bypass) )
    {
        $message = 'This mod has only been tested on MySQL and may only work on MySQL.<br />';
        $message .= 'Click <a href="mod_install.php?bypass=true">here</a> to install anyways.';
        message_die(GENERAL_MESSAGE, $message);
    }
}

$sql = array();
$sql[] = "INSERT INTO " . CONFIG_TABLE . " VALUES ('no_post_count_forum_id', '')";

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
    $message = "The table have been edited successfully. You can now delete this file. To undo any changes run the mod_uninstall.php file.";
}

echo "\n<br />\n<b>COMPLETE!</b><br />\n";
echo $message . "<br />\n";
echo "</body>\n";
echo "</html>\n";
exit();

?>
