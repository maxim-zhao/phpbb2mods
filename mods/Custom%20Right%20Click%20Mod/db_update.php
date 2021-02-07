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
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name1', 'Home')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link1', 'index.php')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name2', 'FAQ')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link2', 'faq.php')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name3', 'Search')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link3', 'search.php')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name4', 'Memberlist')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link4', 'memberlist.php')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name5', 'Usergroups')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link5', 'groupcp.php')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name6', 'Who is Online?')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link6', 'viewonline.php')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name7', 'Profile')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link7', 'profile.php?mode=editprofile')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name8', 'P.M.')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link8', 'privmsg.php?folder=inbox')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_name9', 'Go Back')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_link9', 'javascript:history.back();')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_STAT1', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_SKIN1', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD1', '')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD2', '<hr>')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD3', '')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD4', '<hr>')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD5', '')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD6', '<hr>')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD7', '')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD8', '<hr>')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_DIVD9', '')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_RCOF1', '<!--')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('ISUA_RCOF2', '-->')";

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
echo '<tr><th>Installation Complete</th></tr><tr><td><span class="genmed">Please be sure to delete this file now.<br />If you require any further assistance, please visit the <a href="http://www.support.isua.co.uk/viewforum.php?f=9">ISUA Support Forum</a>.</span></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Go back to your index page</a>.</span></td></table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>