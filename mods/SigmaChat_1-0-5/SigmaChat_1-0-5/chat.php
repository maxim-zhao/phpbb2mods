<?php 
/***************************************************************************
 *                                 chat.php
 *                            -------------------
 *   begin                : Saturday, March 26, 2005
 *   copyright            : (C) 2005 Jason Sanborn
 *   email                : jsanborn@digitalstylus.com
 *   version              : 1.0.5 - 2005/07/02
 *
 *   Based on the Blank Template MOD by psychowolfman (Brent Upton)
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

// standard hack prevent 
define('IN_PHPBB', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

// standard session management 
$userdata = session_pagestart($user_ip, PAGE_CHAT); 
init_userprefs($userdata); 

// set page title 
$page_title = 'SigmaChat'; 

// redirect to login if not logged in
if ( empty($userdata['user_id']) || $userdata['user_id'] == ANONYMOUS )
{
	redirect(append_sid("login.$phpEx?redirect=chat.$phpEx", true));
}

// standard page header 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

// assign template 
$template->set_filenames(array( 
        'body' => 'chat.tpl') 
); 

// assign template variables
$template->assign_vars(array(
	'L_CHAT_FAQ' => $lang['Chat_FAQ'],
	'U_CHAT_FAQ' => append_sid("faq.$phpEx?mode=chat")
	)
);

$template->pparse('body'); 

// standard page footer 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>