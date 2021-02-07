<?php
/***************************************************************************
 *                          admin_download_phpbb.php
 *                            -------------------
 *   begin                : May 28, 2005
 *   author               : Fountain of Apples < webmacster87@gmail.com >
 *   copyright            : (C) 2005-2006 Douglas Bell
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

//
// Let the ACP know this file exists
//
define('IN_PHPBB', 1); 

if( !empty($setmodules) ) 
{ 
    $file = basename(__FILE__); 
    $module['AVC_AVersioncheck']['phpBBDownload'] = $file;
    return; 
}

//
// Load the default header 
//
$phpbb_root_path = './../'; 
require($phpbb_root_path . 'extension.inc'); 
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_avc.' . $phpEx); 

//
// No Real PHP to worry about, so let's assign our vars
//
	$template->assign_vars(array(
		'L_DOWNLOAD_PHPBB_PAGE_HEAD' => $lang['Download_phpBB'],
		'L_DOWNLOAD_PHPBB_PAGE_EXPLAIN' => $lang['Download_phpBB_page_explain'],
		'L_DOWNLOAD_PHPBB' => $lang['Download_phpBB'],
		'L_DOWNLOADS_PAGE' => $lang['Downloads_page'],
		'L_CODE_CHANGES' => $lang['Code_changes'],
		'L_UPGRADE_TUTORIAL' => $lang['Upgrade_tutorial'],
		'L_MAILING_LIST' => $lang['Mailing_list'])
	);

//
// Let's just make sure now that we know where the .tpl is...
//
	$template->set_filenames(array(
		"body" => "admin/download_phpbb_body.tpl")
	);

//
// Now let's just close the document properly.
//
$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>