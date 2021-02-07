<?php
/***************************************************************************
 *						lang_TC_install.php [English]
 *						-----------------------------
 *	begin				: 26/04/2006
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 0.0.1 - 26/04/2006
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$lang = array(
//system
	'SQL_error' => '<b><u>SQL request not achieved:</u></b><ul><li><b>reason:</b> %s<li><b>file:</b> %s, <b>line:</b> %s<li><b>request:</b><hr /> %s<hr /></ul>',
	'Login_required' => 'You must log in',
	'Login_title' => 'Login',
	'Login_failed' => 'Login failed. Check the username and the password you\'ve typed in, then retry.',
	'Login_username' => 'Username',
	'Login_password' => 'Password',
	'Login_submit' => 'Log me in',
	'Login_admin' => 'You must be an administrator to go further.',
	'Login_mod' => 'You must be an administrator or a moderator to go further.',
	'Error_resume_explain' => 'These are warnings only : press "Resume" to continue :',
	'Error_resume' => 'Resume',
	'Unknown_version' => 'Unknown version. Please report.',

	// welcome page
	'Start' => 'Click "Proceed" to start',
	'Proceed' => 'Proceed',

// Topic Calendar install
	'Script_title' => 'Topic Calendar %s installation tool',

	// welcome page
	'TC_welcome' => 'Welcome to the Topic Calendar %s installation tool.',
	'TC_welcome_explain' => 'This tool is designed to create or update the fields relative to the mod.',

	// version
	'TC_previous_version' => 'Topic calendar version %s has been detected.',

	// database structure
	'TC_sql_already_done' => 'SQL request failed (maybe already done) : %s',
	'TC_dbstruct_done' => 'The database structure has been modified.',
	'TC_dbstruct_upgraded' => 'The database structure has been upgraded.',

	// db population
	'TC_db_config_done' => 'Config table has been populated.',
	'TC_force_settings_done' => 'The users settings have been reset to their default values.',

	// critical errors
	'TC_db_not_supported' => '<b><u>/!\</u> The database used is not supported by Topic Calendar. <u>/!\</u></b>',

	// end messages
	'TC_install_upgraded' => 'Your installation of Topic Calendar has been upgraded to its last version.<br /><br />Please delete the install_cal/ directory.',
	'TC_install_done' => 'The installation of Topic Calendar is now completed.<br /><br />Please delete the install_cal/ directory.',
	'TC_return_to_board' => '<br />Thanks for choosing Topic Calendar,<br /><a href="http://ptifo.clanmckeen.com" target="_blank">Ptirhiik</a> and <a href="http://ggweb-fr.com" target="_blank">Gilgraf</a><hr />Click <a href="../">Here</a> to return to Board index.<hr />',
);

?>