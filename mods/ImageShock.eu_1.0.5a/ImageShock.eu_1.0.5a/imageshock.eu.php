<?php
/***************************************************************************
 *                            imageshock.eu.php
 *                            -------------------
 *   begin                : Dec 28, 2006
 *   copyright            : (C) 2006 zden
 *   website              : www.imageshock.eu
 *
 *   $Id: imageshock.eu.php
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
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

include($phpbb_root_path."language/lang_".$board_config['default_lang']."/lang_imageshock.eu.".$phpEx);

if($HTTP_GET_VARS["problem"])
{
$problem = "alert('".$lang['problem']."');";
}
else
{
$problem = false;
}

if(!$HTTP_GET_VARS["file"])
{
$gen_simple_header = true;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->assign_vars(array(
	'OWN_URL' => urlencode("http://".$HTTP_SERVER_VARS["HTTP_HOST"].$HTTP_SERVER_VARS["PHP_SELF"]),
	'PROBLEM_APPEARS' => $problem,
	'JPG_2MB' => $lang['jpg2mb'],
	'UPLOAD_VIA' => $lang['uploadvia'],
	'UPLOAD' => $lang['upload'],
	'SITE_IN_TEXT' => $lang['siteintext'],
	'UPLOADING' => $lang['uploading'],
	
	));
$template->set_filenames(array('html' => 'imageshockeu_input_body.tpl')); 
$template->pparse('html'); 

}
else
{
$gen_simple_header = true;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->assign_vars(array(
	'FILE' => $HTTP_GET_VARS["file"],
	'EXT' => $HTTP_GET_VARS["ext"],
	'UPLOADED' => $lang['uploaded'],
	'THUMBNAIL_LINK' => $lang['thumbnaillink'],
	'HOTLINK' => $lang['hotlink'],
	'SITE' => $lang['site'],
	'AUTO' => $lang['auto'],
	'YOU_CAN' => $lang['youcan'],
	'ANOTHER' => $lang['another'],
	
	));
$template->set_filenames(array('html' => 'imageshockeu_output_body.tpl')); 
$template->pparse('html'); 
}
?>