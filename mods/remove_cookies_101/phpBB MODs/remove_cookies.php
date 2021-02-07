<?php 
/*************************************************************************** 
*                            remove_cookies.php 
*                            ------------------- 
*   begin                : (Monday, Oct 12, 2004) 
*   copyright            : (C) (2004) (geocator) 
*   email                : (geocator@gmail.com) 
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

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//
$confirm = ( $HTTP_POST_VARS['confirm'] ) ? TRUE : 0;

if ( isset($HTTP_POST_VARS['cancel']) )
{
	redirect(append_sid("index." . $phpEx));
} 
if ($confirm)
{
	setcookie($board_config['cookie_name'] . '_sid', $session_id, - 3600, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	
	setcookie($board_config['cookie_name'] . '_f_all', time(), - 3600, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	
	setcookie($board_config['cookie_name'] . '_t', serialize($tracking_topics), - 3600, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	
	setcookie($board_config['cookie_name'] . '_f', serialize($tracking_forums), - 3600, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	
	setcookie($board_config['cookie_name'] . '_data', serialize($sessiondata), - 3600, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	
	message_die(GENERAL_MESSAGE, $lang['Cookies_deleted']);
}
else 
{
      
      	$page_title = $lang['Delete_cookies'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

         // Not confirmed, show confirmation message
         
         //
         // Set template files
         //
         
         
            
         $template->set_filenames(array(
            'confirm' => 'confirm_body.tpl')
         );
         $template->assign_vars(array(
            'MESSAGE_TITLE' => $lang['Confirm'],
			'MESSAGE_TEXT' => $lang['cookies_confirm'],
            'L_YES' =>  $lang['Yes'],
            'L_NO' => $lang['No'],

            'S_CONFIRM_ACTION' => append_sid("remove_cookies.$phpEx"))
         );

         $template->pparse('confirm');

         include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
}
?>