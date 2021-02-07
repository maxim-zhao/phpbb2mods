<?php
/*-----------------------------------------------------------------------------
    Visual Confirmation on New Posters - A phpBB Add-On
  ----------------------------------------------------------------------------
    vc.php
       Confirm Image Displayer
    File Version: 3.0.1
    Begun: August 25, 2006                 Last Modified: March 24, 2007
  ----------------------------------------------------------------------------
    Copyright 2006 by Jeremy Rogers.  Please read the license.txt included
    with the phpBB Add-On listed above for full license and copyright details.
-----------------------------------------------------------------------------*/

define('IN_PHPBB', TRUE);
$phpbb_root_path = './';
require_once($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_POSTING);
init_userprefs($userdata);
//
// End session management
//

require_once($phpbb_root_path . 'mods/vc_newposts/constants.' . $phpEx);

$confirm_file = PATH_STANDARD;

switch( $board_config['vcnewposts_type'] )
{
	case CAPTCHA_PHOTO:
		// Do a little check to make sure the Photo Confirmation mod
		// is installed.
		if( defined('VISUAL_CONFIRM_DIGITS') )
		{
			$board_config['enable_confirm'] = VISUAL_CONFIRM_PHOTOS;
		}
		else
		{
			// Not installed - let's default to standard confirmation
			// settings.
			$board_config['enable_confirm'] = 1;
		}
		break;
	case CAPTCHA_BETTER:
		// Switch to Better Captcha's file.
		$confirm_file = PATH_BETTER;
		break;
	case CAPTCHA_STANDARD:
	case CAPTCHA_AVC:
	case CAPTCHA_FREECAP:
	default:
		// Do a little check to make sure the Photo Confirmation mod
		// is installed.
		if( defined('VISUAL_CONFIRM_DIGITS') )
		{
			$board_config['enable_confirm'] = VISUAL_CONFIRM_DIGITS;
		}
		else
		{
			// Not installed - let's default to standard confirmation
			// settings.
			$board_config['enable_confirm'] = 1;
		}
		break;
}

include($phpbb_root_path . $confirm_file);
@$db->sql_close();
exit;

?>