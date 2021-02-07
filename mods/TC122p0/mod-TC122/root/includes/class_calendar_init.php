<?php
/***************************************************************************
 *                            class_calendar_init.php
 *                            -----------------------
 *	begin			: 25/04/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.2 - 06/07/2006
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

// tree drawing
define('TREE_HSPACE', 'H');
define('TREE_VSPACE', 'V');
define('TREE_CROSS', 'X');
define('TREE_CLOSE', 'C');

// auth
define('AUTH_CAL', 20);

// version
define('TC_CURRENT_VERSION', '1.2.2');

include($phpbb_root_path.'includes/class_calendar_backport.'.$phpEx);
include($config->url('includes/class_calendar_api'));

// do not go further during login or installation
if ( defined('IN_LOGIN') || defined('IN_INSTALL') )
{
	return;
}

// intall directory still present
if ( file_exists(@phpbb_realpath($config->root . 'install_cal')) )
{
	if ( $config->data['mod_topic_calendar'] != TC_CURRENT_VERSION )
	{
		header('Location: ' . $config->url('install_cal/install'));
		exit;
	}
	else
	{
		message_die(GENERAL_MESSAGE, 'Please remove install_cal/ directory');
	}
}

?>