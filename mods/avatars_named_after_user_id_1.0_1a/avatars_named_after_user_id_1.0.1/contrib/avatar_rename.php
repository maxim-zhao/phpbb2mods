<?php
/***************************************************************************
 *                              avatar_rename.php
 *                            -------------------
 *   begin                : Tuesday, Aug 1, 2006
 *   copyright            : (C) 2006 Funender.com
 *
 * Author Note: It is HIGHLY recommended that you backup your phpBB forum, especially 
 * your avatar directory and database before running this script.  
 * This file will rename all of your avatars and update the names in your database.
 * So if you wish to go back to your original settings you must restore your backup.  
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

## Enter your site path here and DO NOT add a trailing slash.
## Example: $site_path = '/home/your_site/public_html/phpBB2';

$site_path = '';

# Do not edit anything below this line
#------------------------------------------------------------#


$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);


if( !$userdata['session_logged_in'] )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . append_sid("login.$phpEx?redirect=avatar_rename.$phpEx", true));
	exit;
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_ERROR, 'You are not authorised to access this page');
}

$page_title = 'Renaming avatars by user ID';

	$res = mysql_query("SELECT user_avatar, user_id FROM " . USERS_TABLE . "");
	while($row = mysql_fetch_array($res)) {
		if($row["user_avatar"] != "") {
			$ext = explode(".", $row["user_avatar"]);
			$new = $row["user_id"].".".$ext[1];
			$path = ($site_path  . '/' . $board_config['avatar_path'] . '/');
			if(@rename($path.$row["user_avatar"], $path.$new)) {
				mysql_query("UPDATE ". USERS_TABLE ." SET user_avatar = '".$new."' WHERE user_id = '".$row["user_id"]."'");
			}
		}
	}
      message_die(GENERAL_MESSAGE, 'Avatar renaming has ran successfully.<br /><br /><b>DELETE THIS FILE NOW!</b>');

?>