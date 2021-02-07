<?php 
/***************************************************************************
 *                                template.php
 *                            -------------------
 *   begin                : Saturday, Okt 10, 2003
 *   copyright         : (C) 2008 Raimon Meuldijk
 *   email                : Raimon@phpBBservice.nl
 *
 *   $Id:  $
 *
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

// standard session management 
$userdata = session_pagestart($user_ip, PAGE_TEMPLATE); 
init_userprefs($userdata); 

// set page title 
$page_title = 'Template'; 

// standard page header 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

// assign template 
$template->set_filenames(array( 
        'body' => 'template.tpl') 
); 

$template->pparse('body'); 

// standard page footer 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>