<?php /**********************************************************
*     sql_updater.php (for User-Specific Edit Disable MOD)      *
*             Copyright © 2007 Thomas Hall (xx521xx)            *
* File created: 1/20/07                  Last modified: 1/20/07 *
*****************************************************************
*                      File version: 1.0.0                      *
*****************************************************************
*          This file is released under the GNU GPL v2.          *
****************************************************************/

// phpBB startup
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path.'extension.inc');
include($phpbb_root_path.'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

// Can the user view this page?
if ( !$userdata['session_logged_in'] )
{
	redirect(append_sid($phpbb_root_path.'login.'.$phpEx.'?redirect=sql_updater.'.$phpEx));
}
else if ( $userdata['user_level'] != ADMIN )
{
	redirect(append_sid($phpbb_root_path.'index.'.$phpEx));
}
else
{
	// Perform the update
	$error = false;
	$manual_instructions = '';
	
	$sql = 'ALTER TABLE '.USERS_TABLE.'
		ADD user_auth_edit tinyint(1) DEFAULT 1';
	
	$message = 'Adding user_auth_edit to '.USERS_TABLE.'...';
	
	if ($db->sql_query($sql))
	{
		$message .= ' <span style="color:green;">Successfully added!</span>';
	}
	else
	{
		$message .= ' <span style="color:red;">Unsuccessful.</span>';
		$error = true;
		$manual_instructions .= 'ALTER TABLE '.USERS_TABLE.' ADD user_auth_edit tinyint(1) DEFAULT 1;';
	}
	
	if ( !$error )
	{
		$message .= '<br /><br /><span style="color: green; font-weight: bold;">The SQL changes required for this MOD have been applied successfully. You should now delete this file and proceed with the file changes needed for this MOD.</span>';
	}
	else
	{
		$message .= '<br /><br /><span style="color: red; font-weight: bold;">An error occured while trying to update the database. As a result, you will need to enter these SQL changes manually:</span><br /><br />'.$manual_instructions.'<br /><br />You should now delete this file.';
	}
}

// Display the results
message_die(GENERAL_MESSAGE, $message);

?>