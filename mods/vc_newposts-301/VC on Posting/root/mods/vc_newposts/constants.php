<?php
/*-----------------------------------------------------------------------------
    Visual Confirmation on New Posters - A phpBB Add-On
  ----------------------------------------------------------------------------
    constants.php
       Constants File
    File Version: 2.0.0
    Begun: December 11, 2006                 Last Modified: March 7, 2007
  ----------------------------------------------------------------------------
    Copyright 2006 by Jeremy Rogers.  Please read the license.txt included
    with the phpBB Add-On listed above for full license and copyright details.
-----------------------------------------------------------------------------*/

if( !defined('IN_PHPBB') )
{
	die("I really hope you didn't just try to hack this server.");
}

// Captcha Types
define('CAPTCHA_STANDARD', 0);
define('CAPTCHA_AVC', 1);
define('CAPTCHA_FREECAP', 2);
define('CAPTCHA_BETTER', 3);
define('CAPTCHA_PHOTO', 20);

// Paths
// These are used to determine if files from certain other captcha mods exist
// on the server.
// Standard phpBB captcha file -
define('PATH_STANDARD', 'includes/usercp_confirm.' . $phpEx);
// Better Captcha's usercp_confirm replacement -
define('PATH_BETTER', 'includes/usercp_captcha.' . $phpEx);
// Freecap's functions file -
define('PATH_FREECAP', 'includes/functions_freecap.' . $phpEx);
// Photo Captcha's image locations -
define('PATH_PHOTO', 'images/captcha/');

// User on/off types
define('NO_USERS', 0);
define('ALL_USERS', 1);
define('GUESTS', 2);
define('REG_USERS', 3);

// Is GD available?
define('GD_INSTALLED', ( @extension_loaded("gd") || @extension_loaded("gd2") || @extension_loaded("GD") || @extension_loaded("GD2") ) ? TRUE : FALSE );

// How about ZLIB?
define('ZLIB_INSTALLED', ( @extension_loaded("zlib") ) ? TRUE : FALSE );

?>