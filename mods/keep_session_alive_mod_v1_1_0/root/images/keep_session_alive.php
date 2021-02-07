<?php
/***************************************************************************
 *							keep_session_alive.php
 *							----------------------
 *	begin				: October, 2004
 *	copyright			: (c) 2004 phpMiX
 *	email				: markus_petrux at phpmix dot com
 *	website				: http://www.phpmix.com
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

define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Update current session with specified page identifier...
//
$page_id = ( isset($HTTP_GET_VARS['p']) ? intval($HTTP_GET_VARS['p']) : PAGE_INDEX );
$userdata = session_pagestart($user_ip, $page_id);

//
// Now, send a 1x1 pixel image to the browser...
//

// NOTE: Code from includes/page_header.php (v2.0.10)
// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting
if (!empty($_SERVER['SERVER_SOFTWARE']) && strstr($_SERVER['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');

header('Content-type: image/gif');
readfile($phpbb_root_path . 'images/spacer.gif');
exit;

?>