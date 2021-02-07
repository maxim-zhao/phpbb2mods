<?php
/***************************************************************************
 *                            functions_contact.php
 *                            ---------------------
 *	Version:	9.0.0
 *	Begin:		Tuesday, Dec 06, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:55 25/06/2007
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

if(!defined('IN_PHPBB'))
{
	die('Hacking Attempt');
}

if(!$userdata['session_logged_in'])
{
	$remove = $HTTP_GET_VARS['delete'];
	redirect("login.$phpEx?redirect=contact.$phpEx&delete=$remove", true);
}
elseif($userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_ERROR, $lang['Not_Authorised']); // lang_main.php
}
else
{
	$filename = $phpbb_root_path . "/" . trim($contact_config['contact_file_root']) . "/" . $HTTP_GET_VARS['delete'];

	//
	// Exploit Prevention
	//
	exploit_catch($filename);

	//
	// If filename and location matches okay, delete it..
	//
	if(file_exists($filename))
	{
		delete_file($filename);
		message_die(GENERAL_MESSAGE, $lang['File_Removed']);
	}
	else
	{
		message_die(GENERAL_ERROR, $lang['File_Not_Here']);
	}
}

function exploit_catch($filename)
{
	$methods = array('..', 'index.html', '\0');
	foreach($methods as $hacks)
	{
		if(strpos($filename, $hacks) !== false)
		{
			die('Hacking Attempt');
		}
	}

	if(is_dir($filename))
	{
		die('Hacking Attempt');
	}
}

function delete_file($filename)
{
	global $HTTP_GET_VARS, $db, $contact_config;

	@unlink($filename);
	clearstatcache();

	if($contact_config['contact_storage'] == 1)
	{
		$filename = trim($contact_config['contact_file_root']) . "/" . $HTTP_GET_VARS['delete'];

		$sql = "UPDATE " . CONTACT_MSGS_TABLE . "
			SET upfile = ''
			WHERE upfile = '$filename'";

		if(!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not update Contact table', '', __LINE__, __FILE__, $sql);
		}
	}
}

?>