<?php
/**
*
* @package lang_settings_mod
* @version $Id: lang_extend_mac.php,v 0.2 07/05/2006 09:42 reddog Exp $
* @copyright (c) 2006 Ptirhiik - http://ptifo.clanmckeen.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

if (!defined('LANG_EXTEND_DONE'))
{
	// check for admin part
	$lang_extend_admin = defined('IN_ADMIN');

	// get the english settings
	if ( $board_config['default_lang'] != 'english' )
	{
		$dir = @opendir($phpbb_root_path . 'language/lang_english');
		while( $file = @readdir($dir) )
		{
			if ( preg_match('/^lang_extend_.*?\.' . $phpEx . '$/', $file) )
			{
				include($phpbb_root_path . 'language/lang_english/' . $file);
			}
		}

		// include the customizations
		if ( @file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_english/lang_extend' . $phpEx)) )
		{
			include($phpbb_root_path . 'language/lang_english/lang_extend' . $phpEx);
		}
		@closedir($dir);
	}

	// get the user settings
	if ( !empty($board_config['default_lang']) )
	{
		$dir = @opendir($phpbb_root_path . 'language/lang_' . $board_config['default_lang']);
		while( $file = @readdir($dir) )
		{
			if ( preg_match('/^lang_extend_.*?\.' . $phpEx . '$/', $file) )
			{
				include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/' . $file);
			}
		}

		// include the customizations
		if ( @file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_extend' . $phpEx)) )
		{
			include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_extend' . $phpEx);
		}
		@closedir($dir);
	}

	// define lang extend done
	define('LANG_EXTEND_DONE', true);
}

?>