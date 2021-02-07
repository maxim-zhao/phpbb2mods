<?php
/***************************************************************************
 *                        freeze_posts_update.php
 *                            -------------------
 *   begin                : Monday, Jun 9, 2003
 *   copyright            : (C) 2003 Jamie Brookes
 *   email                : craven@coderx.net
 *
 *   $Id: freeze_posts_update.php,v 1.0.1 2004/08/22 16:30:00 Craven- Exp $
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

define('IN_PHPBB', 1); 
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


//
// Check Perms and Session Status
//
if (!$userdata['session_logged_in'])
{
	redirect(append_sid("login.$phpEx?redirect=freeze_posts_update.$phpEx", true));
}
else if ($userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}


//
// If the user said 'yes',
// update the database for use
// with the freeze post count MOD
//
if ( isset($HTTP_POST_VARS['submit']) )
{
	$sql = 	"ALTER TABLE " . USERS_TABLE . " 
		 ADD user_posts_frozen TINYINT(1) DEFAULT '0' NOT NULL 
		 AFTER user_posts";


	if ( !$db->sql_query($sql) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating users table', '', __LINE__, __FILE__, $sql);
	} 
	else 
	{ 
		message_die(GENERAL_MESSAGE, '<strong> Database updated successfully! </strong><br><br> You may now delete this file. <br><br>');
	} 
}
else
{

	// 
	// Otherwise display
	// the HTML submit button
	// to make sure the user
	// really does want to 
	// modify their database
	//
	$html = "

            <strong>phpBB Freeze Post Count MOD - DB Updater</strong>       
            <br>
	    <br>
	    <br>
            This script modifies your phpBB database for use with the <strong><em>'Freeze User Post Count MOD'</em></strong>.
            <br>
            In order to use this MOD, you must click the button below.
            <br>
            <br>
            
            <strong>NOTE: By clicking below you will modify your database.</strong>
            <br>
            It is suggested that you backup you database before continuing.
            <br>
            <br>
            <br>
            
            <form name=\"mod\" method=\"POST\">
            <input type=\"Submit\" name=\"submit\" value=\"Continue\">
            </form>

	";

	message_die(GENERAL_MESSAGE, $html);
}


?>