<?php
/***************************************************************************
*     begin                : Thu July 27, 2004
*     copyright            : (C) 2004 Shof515
*     email                : shof515@gmail.com
*
****************************************************************************/
define('IN_PHPBB', 1);
//
// First we do the setmodules stuff for the admin cp.
//
if (!empty($setmodules))
{
	$filename = basename(__FILE__);
	$module['Admin Links']['LinkName'] = append_sid("link here");
	$module['Admin Links']['Shof515'] = append_sid("http://shof515.com/");
	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Output the authorisation details
//

include('./page_header_admin.'.$phpEx);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>