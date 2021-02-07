##############################################################
## MOD Title: Temp Ban upgrade 1.1.3 to 1.1.5
## MOD Author: eviL3 < evil@phpbbmodders.net > (Igor Wiedler) http://phpbbmodders.net
## MOD Description: Upgrade instructions
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: includes/sessions.php
##
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## Here are some upgrade instructions
##
##############################################################
## MOD History:
##
##   2007-01-25 - Version 1.0.0
##      - Nothing to say
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------ 
#
includes/sessions.php

#
#-----[ FIND ]------------------------------------------ 
#
    // Begin by Lord Le Brand (Stolen from functions.php)
	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']))
		{
			$default_lang = phpbb_ltrim(basename(phpbb_rtrim($userdata['user_lang'])), "'");
		}

		if ( !empty($userdata['user_dateformat']) )
		{
			$board_config['default_dateformat'] = $userdata['user_dateformat'];
		}

		if ( isset($userdata['user_timezone']) )
		{
			$board_config['board_timezone'] = $userdata['user_timezone'];
		}
	}
	else
	{
		$default_lang = phpbb_ltrim(basename(phpbb_rtrim($board_config['default_lang'])), "'");
	}

	if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $default_lang . '/lang_main.'.$phpEx)) )
	{
		if ( $userdata['user_id'] != ANONYMOUS )
		{
			// For logged in users, try the board default language next
			$default_lang = phpbb_ltrim(basename(phpbb_rtrim($board_config['default_lang'])), "'");
		}
		else
		{
			// For guests it means the default language is not present, try english
			// This is a long shot since it means serious errors in the setup to reach here,
			// but english is part of a new install so it's worth us trying
			$default_lang = 'english';
		}

		if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $default_lang . '/lang_main.'.$phpEx)) )
		{
			message_die(CRITICAL_ERROR, 'Could not locate valid language pack');
		}
	}

	// If we've had to change the value in any way then let's write it back to the database
	// before we go any further since it means there is something wrong with it
	if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_lang'] !== $default_lang )
	{
		$sql = 'UPDATE ' . USERS_TABLE . "
			SET user_lang = '" . $default_lang . "'
			WHERE user_lang = '" . $userdata['user_lang'] . "'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not update user language info');
		}

		$userdata['user_lang'] = $default_lang;
	}
	elseif ( $userdata['user_id'] === ANONYMOUS && $board_config['default_lang'] !== $default_lang )
	{
		$sql = 'UPDATE ' . CONFIG_TABLE . "
			SET config_value = '" . $default_lang . "'
			WHERE config_name = 'default_lang'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not update user language info');
		}
	}

	$board_config['default_lang'] = $default_lang;

	include_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);

	if ( defined('IN_ADMIN') )
	{
		if( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.'.$phpEx)) )
		{
			$board_config['default_lang'] = 'english';
		}

		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	}
    // End by Lord Le Brand
#
#-----[ REPLACE WITH ]------------------------------------------ 
#
	global $lang, $phpbb_root_path, $phpEx;
	
	$default_lang = str_replace('lang_', '', $board_config['default_lang']);
	
	if ( !file_exists(@phpbb_realpath("{$phpbb_root_path}language/lang_{$default_lang}/lang_main.{$phpEx}")) )
	{
		message_die(CRITICAL_ERROR, 'Could not locate valid language pack');
	}
	
	include_once("{$phpbb_root_path}language/lang_{$default_lang}/lang_main.{$phpEx}");
#
#-----[ FIND ]------------------------------------------
#
	if ( $ban_info = $db->sql_fetchrow($result) )
	{
#
#-----[ AFTER, ADD ]------------------------------------------ 
#

//-- mod : Temp Ban ------------------------------------------------------------
//-- add
		$ban_until = create_date( $lang['Expires_format_banned'], $ban_info['ban_until'], $board_config['board_timezone'] );
		if ( $ban_info['ban_until'] > 0 )
		{
			message_die(CRITICAL_MESSAGE, $lang['You_been_banned'] . '<br /><br />' . $lang['Expires_msg_banned'] . $ban_until);
		}
//-- fin mod : Temp Ban --------------------------------------------------------

#
#-----[ FIND ]------------------------------------------ 
#
			$ban_until = create_date( $lang['Expires_format_banned'], $ban_info['ban_until'], $board_config['board_timezone'] );
			if ( $ban_info['ban_until'] > 0 )
			{
				message_die(CRITICAL_MESSAGE, $lang['You_been_banned'] . '<br /><br />' . $lang['Expires_msg_banned'] . $ban_until);
			}
#
#-----[ REPLACE WITH ]------------------------------------------ 
#
# Nothing

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
