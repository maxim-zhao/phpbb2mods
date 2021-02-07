<?php
//-- mod : categories hierarchy ------------------------------------------------
/***************************************************************************
 *                                common.php
 *                            -------------------
 *   begin                : Saturday, Feb 23, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: common.php,v 1.74.2.22 2005/12/30 09:51:01 acydburn Exp $
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
	die("Hacking attempt");
}

//-- mod : categories hierarchy ------------------------------------------------
//-- add
$starttime = microtime();
$trc_loc_start = $trc_loc_end = 0;
//-- fin mod : categories hierarchy --------------------------------------------

//
error_reporting  (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables
set_magic_quotes_runtime(0); // Disable magic_quotes_runtime

// The following code (unsetting globals)
// Thanks to Matt Kavanagh and Stefan Esser for providing feedback as well as patch files

// PHP5 with register_long_arrays off?
if (@phpversion() >= '5.0.0' && (!@ini_get('register_long_arrays') || @ini_get('register_long_arrays') == '0' || strtolower(@ini_get('register_long_arrays')) == 'off'))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_GET_VARS = $_GET;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_COOKIE_VARS = $_COOKIE;
	$HTTP_ENV_VARS = $_ENV;
	$HTTP_POST_FILES = $_FILES;

	// _SESSION is the only superglobal which is conditionally set
	if (isset($_SESSION))
	{
		$HTTP_SESSION_VARS = $_SESSION;
	}
}

// Protect against GLOBALS tricks
if (isset($HTTP_POST_VARS['GLOBALS']) || isset($HTTP_POST_FILES['GLOBALS']) || isset($HTTP_GET_VARS['GLOBALS']) || isset($HTTP_COOKIE_VARS['GLOBALS']))
{
	die("Hacking attempt");
}

// Protect against HTTP_SESSION_VARS tricks
if (isset($HTTP_SESSION_VARS) && !is_array($HTTP_SESSION_VARS))
{
	die("Hacking attempt");
}

if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on')
{
	// PHP4+ path
	$not_unset = array('HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SERVER_VARS', 'HTTP_SESSION_VARS', 'HTTP_ENV_VARS', 'HTTP_POST_FILES', 'phpEx', 'phpbb_root_path');

	// Not only will array_merge give a warning if a parameter
	// is not an array, it will actually fail. So we check if
	// HTTP_SESSION_VARS has been initialised.
	if (!isset($HTTP_SESSION_VARS) || !is_array($HTTP_SESSION_VARS))
	{
		$HTTP_SESSION_VARS = array();
	}

	// Merge all into one extremely huge array; unset
	// this later
	$input = array_merge($HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_SESSION_VARS, $HTTP_ENV_VARS, $HTTP_POST_FILES);

	unset($input['input']);
	unset($input['not_unset']);

	while (list($var,) = @each($input))
	{
		if (!in_array($var, $not_unset))
		{
			unset($$var);
		}
	}

	unset($input);
}

//
// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
//
if( !get_magic_quotes_gpc() )
{
	if( is_array($HTTP_GET_VARS) )
	{
		while( list($k, $v) = each($HTTP_GET_VARS) )
		{
			if( is_array($HTTP_GET_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_GET_VARS[$k]) )
				{
					$HTTP_GET_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_GET_VARS[$k]);
			}
			else
			{
				$HTTP_GET_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_GET_VARS);
	}

	if( is_array($HTTP_POST_VARS) )
	{
		while( list($k, $v) = each($HTTP_POST_VARS) )
		{
			if( is_array($HTTP_POST_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_POST_VARS[$k]) )
				{
					$HTTP_POST_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_POST_VARS[$k]);
			}
			else
			{
				$HTTP_POST_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_POST_VARS);
	}

	if( is_array($HTTP_COOKIE_VARS) )
	{
		while( list($k, $v) = each($HTTP_COOKIE_VARS) )
		{
			if( is_array($HTTP_COOKIE_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
				{
					$HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_COOKIE_VARS[$k]);
			}
			else
			{
				$HTTP_COOKIE_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_COOKIE_VARS);
	}
}

//
// Define some basic configuration arrays this also prevents
// malicious rewriting of language and otherarray values via
// URI params
//
$board_config = array();
$userdata = array();
$theme = array();
$images = array();
$lang = array();
$nav_links = array();
$gen_simple_header = FALSE;

include($phpbb_root_path . 'config.'.$phpEx);

if( !defined("PHPBB_INSTALLED") )
{
	header('Location: ' . $phpbb_root_path . 'install/install.' . $phpEx);
	exit;
}

include($phpbb_root_path . 'includes/constants.'.$phpEx);
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
include($phpbb_root_path . 'includes/template.'.$phpEx);
*/
//-- add
include($phpbb_root_path . 'includes/class_template.'.$phpEx);
//-- fin mod : categories hierarchy --------------------------------------------
include($phpbb_root_path . 'includes/sessions.'.$phpEx);
include($phpbb_root_path . 'includes/auth.'.$phpEx);
include($phpbb_root_path . 'includes/functions.'.$phpEx);
include($phpbb_root_path . 'includes/db.'.$phpEx);

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

//
// Obtain and encode users IP
//
// I'm removing HTTP_X_FORWARDED_FOR ... this may well cause other problems such as
// private range IP's appearing instead of the guilty routable IP, tough, don't
// even bother complaining ... go scream and shout at the idiots out there who feel
// "clever" is doing harm rather than good ... karma is a great thing ... :)
//
$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
$user_ip = encode_ip($client_ip);

//
// Setup forum wide options, if this fails
// then we output a CRITICAL_ERROR since
// basic forum information is not available
//
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$board_config[$row['config_name']] = $row['config_value'];
}
*/
//-- add
// include basic classes def
include($phpbb_root_path . 'includes/class_config.' . $phpEx);

// get config
$config = new config_class();
if ( !$config->read() )
{
	define('RUN_CH_INSTALL', true);
}
$board_config = &$config->data;

// let's run the upgrade script
if ( !defined('IN_LOGIN') && !defined('IN_INSTALL') && (($config->data['mod_cat_hierarchy'] != CH_CURRENT_VERSION) || defined('RUN_CH_INSTALL')) )
{
	header('Location: ./install_cat/install.' . $phpEx . (empty($SID) ? '' : '?' . $SID));
	exit;
}

// user objects
include($config->url('includes/class_groups'));
include($config->url('includes/class_user'));
include($config->url('includes/class_auth'));

// instantiate some objects
$user = new user();
$censored_words = new words();
$icons = new icons();
$navigation = new navigation();
$themes = '';
$smilies = new smilies();
$topics_attr = new topics_attr();

// People never read achievement messages after after having seen "Succesfull !", tss tss :)
if ( !defined('IN_LOGIN') && !defined('IN_INSTALL') && file_exists('install_cat') )
{
	message_die(GENERAL_MESSAGE, 'Please ensure the install_cat/ directory is deleted');
}

// messages queue
@include($config->url('includes/class_message'));
$message_queue = defined('CH_message_queue') ? new message_queue() : '';
//-- fin mod : categories hierarchy -------------------------------------------

//-- mod : Advanced Group Color Management -------------------------------------
//-- add
define('IN_CH', TRUE);
include($config->url('includes/class_color'));

//
// prepare colors class
//
$colors = new colors();

//
// let's run the install script
//
if ( !defined('IN_INSTALL') && $config->data['mod_advanced_group_color_management'] != AGCM_CURRENT_VERSION )
{
	header('Location: ./install_color/install.' . $phpEx . (empty($SID) ? '' : '?' . $SID));
	exit;
}

//
// People never read achievement messages after after having seen "Succesfull !", tss tss :)
//
if ( !defined('IN_INSTALL') && file_exists('install_color') )
{
	message_die(GENERAL_MESSAGE, 'Please ensure the install_color/ directory is deleted');
}

//
// read colors
//
if ( !defined('IN_INSTALL') )
{
	$colors->read();
}
//-- fin mod : Advanced Group Color Management ---------------------------------

if (file_exists('install') || file_exists('contrib'))
{
	message_die(GENERAL_MESSAGE, 'Please_remove_install_contrib');
}

//
// Show 'Board is disabled' message if needed.
//
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
if( $board_config['board_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
*/
//-- add
if( $config->data['board_disable'] && !defined('IN_ADMIN') && !defined('IN_LOGIN') && !defined('IN_INSTALL') )
//-- fin mod : categories hierarchy ---------------------------------------------
{
	message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
}

?>