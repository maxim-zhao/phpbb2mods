##############################################################
## MOD Title: Username Color for Last post info
## MOD Author: Seeker_952 <richard@wave3.za.net > (Richard Banks) http://wave3.za.net
## MOD Description: This mod adds the username colour to the user link in the Last post
##		    info mod. This mod requires the Username Color Mod by 
##		    Kooky <kooky@altern.org> http://kooky06.free.fr/board/ and the 
##		    Last Post Info Mod by fredol < fredol@lovewithsmg.com >.
##
## MOD Version:	1.0.2
##
## Installation Level: Easy
## Installation Time: ~1 minute
## Files To Edit: 1
##		  index.php
## Included Files: 0
##
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## 1. Copyright and special thanks!
## -----------
## This program is free software, you can redistribute it and/or modify
## it under the terms of the GNU General Public License as published by
## the Free Software Foundation.
##
## If you want to add this Mod to any database, please don't add
## my e-mail address to a topic, just point to my website (see above).
## (for spamming prevention)
##
##############################################################
## MOD History:
##
## 2005/03/13 - Version 1.0.2
##    - Fixed Changed "AFTER, ADD" "to IN-LINE AFTER, ADD" on line 105
##
## 2005/02/21 - Version 1.0.1
##    - Fixed some typos
##
## 2005/01/18 - Version 1.0.0
##	- First Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------
#
	//BEGIN-MOD:Last post info
	// Get Viewable Forums - made by zparta 
#
#-----[ FIND ]------------------------------------------
#
	$sql = "SELECT p.post_id, p.post_username, pt.post_subject, p.post_time, u.user_id, u.username, t.topic_title
#
#-----[ IN-LINE FIND ]------------------------------------------
#
u.user_id
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_level
#
#-----[ FIND ]------------------------------------------
#
	if ($row = $db->sql_fetchrowset($result)) 
	{
#
#-----[ AFTER, ADD ]------------------------------------
#
		// Start add - Username Color Mod
		switch ( $row[0]['user_level'] )
		{
		case ADMIN:
			$username_color = '<strong>' . $forum_data[$j]['username'] . '</strong>';
			$style_color = ' style="color: #' . $theme['fontcolor3'] . '"';
			break;
		case MOD:
			$username_color = '<strong>' . $forum_data[$j]['username'] . '</strong>';
			$style_color = ' style="color: #' . $theme['fontcolor2'] . '"';
			break;
		default:
			$username_color = $forum_data[$j]['username'];
			$style_color = '';
			break;
		}
		// End add - Username Color Mod
#
#-----[ FIND ]------------------------------------------
#
			$last_post_info = sprintf($lang['last_post_info'], '<a href="profile.'.$phpEx.'?'.$append_sid.'mode=viewprofile&' . POST_USERS_URL . '=' . $row[0]['user_id'] . '">', $row[0]['username'], '</a>', create_date($board_config['default_dateformat'], $row[0]['post_time'], $board_config['board_timezone']), '<a href="viewtopic.'.$phpEx.'?'.$append_sid. POST_POST_URL . '=' . $row[0]['post_id'] . '#' . $row[0]['post_id'] . '">', ( (empty($row[0]['post_subject'])) ? 'Re: ' . $row[0]['topic_title'] : $row[0]['post_subject'] ), '</a>');
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$row[0]['user_id'] . '"
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------
#
' . $style_color . '
#
#-----[ SAVE/CLOSE ALL FILES ]----------------------------------------
#
# EoM