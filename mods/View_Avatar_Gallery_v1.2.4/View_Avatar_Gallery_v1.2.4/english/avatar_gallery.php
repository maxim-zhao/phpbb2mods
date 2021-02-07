<?php

/***************************************************************************
 *                             avatar_gallery.php
 *                            --------------------
 *   begin                : Tuesday, Aug 30, 2005
 *   copyright            : (C) 2005 Azharh
 *   email                : azharh.ort@gmail.com
 *
 *   $Id: avatar_gallery.php, v 1.2.4  2005/01/05 10:55:00 azharh Exp $
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
// Gallery functions
//
include($phpbb_root_path . 'includes/functions_avatar_gallery.'.$phpEx);


// MOD Infos
$mod_version = '1.2.4';
$mod_year = '2006';

//
// Var definition
//
$choose = ( isset($HTTP_POST_VARS['choose']) ) ? TRUE : FALSE;
$category = ( isset($HTTP_POST_VARS['avatarcategory']) ) ? $HTTP_POST_VARS['avatarcategory'] : $HTTP_GET_VARS['avatarcategory'];
$category = htmlspecialchars($category);

/************ Session datas *****************/

// Session id check
if ( !empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']) )
{
	$sid = ( !empty($HTTP_POST_VARS['sid']) ) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_AVATAR_GALLERY);
init_userprefs($userdata);
//
// End session management
//

// Session id check
if ($sid == '' || $sid != $userdata['session_id'])
{
        $sid = $userdata['session_id'];
}

/********************************************/


//
// Mode used ?
//
if ( ($board_config['allow_avatar_local']) && ($board_config['allow_avatar_choice']) && ($userdata['user_id'] != ANONYMOUS) )
{
        if ( $choose )
        {
                $mode = 'choose';
        }
        else
        {
                $mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
                $mode = htmlspecialchars($mode);
        }
}
else
{
        $mode='';
}


//
// Starting things :P
//
switch( $mode )
{
	case 'choose':
                
                // Checking vars
		if ( isset($HTTP_POST_VARS['choice']) || isset($HTTP_GET_VARS['choice']) )
		{
			$choice = ( isset($HTTP_POST_VARS['choice']) ) ? $HTTP_POST_VARS['choice'] : $HTTP_GET_VARS['choice'];
			$choice = htmlspecialchars($choice);
		}
		else
		{
   			$choice = '';
		}
		if ( isset($HTTP_POST_VARS['confirm']) || isset($HTTP_GET_VARS['confirm']) )
		{
			$confirm = ( isset($HTTP_POST_VARS['confirm']) ) ? $HTTP_POST_VARS['confirm'] : $HTTP_GET_VARS['confirm'];
			$confirm = htmlspecialchars($confirm);
		}
		else
		{
   			$confirm = '';
		}
		if ( isset($HTTP_POST_VARS['cancel']) || isset($HTTP_GET_VARS['cancel']) )
		{
			$cancel = ( isset($HTTP_POST_VARS['cancel']) ) ? $HTTP_POST_VARS['cancel'] : $HTTP_GET_VARS['cancel'];
			$cancel = htmlspecialchars($cancel);
		}
		else
		{
   			$cancel = '';
		}
               
                // 2nd case : action cancelled
                if ( $cancel == $lang['No'] )  
                { 
                        //Redirecting (no header !!)
                        $redirect = 'avatar_gallery.'.$phpEx.'?avatarcategory='.$category;
                        redirect(append_sid($redirect, true));           
                }        
                else if ( $confirm == $lang['Yes'] )  // 3rd case : action confirmed
                {
                        $profile_update = user_avatar_gallery($choice, $category, false);
                        
                        // SQL Request
                        $sql = "UPDATE " . USERS_TABLE . "
                                SET " . $profile_update . "
                                WHERE user_id = " . $userdata['user_id'];
                        
                        if ( !($result = $db->sql_query($sql)) )
                        {
                                message_die(GENERAL_ERROR, 'Could not update user\'s information', '', __LINE__, __FILE__, $sql);
                        }
            
                        
                        $redirect_page = append_sid('index.'.$phpEx);
                        $l_redirect = $lang['Avatar_Success'] . '<br /><br />';
                        $l_redirect .= sprintf($lang['Click_return_forum'], '<a href="' . $redirect_page . '">', '</a>');
        
                        $template->assign_vars(array(
                            'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
                        );
            
                        message_die(GENERAL_MESSAGE, $l_redirect);
                        
                }
                else  // 1st case : asking confirmation
                {
                        //Starting the confirmation page
                        include($phpbb_root_path . 'includes/page_header.'.$phpEx);
                        
                        $image = user_avatar_gallery($choice, $category, true);
                        // Not confirmed, show confirmation message
                        $hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" />';            
                        $hidden_fields .= '<input type="hidden" name="choice" value="' . $choice . '" /><input type="hidden" name="avatarcategory" value="' . $category . '" />';
                        
                        //
                        // Set template files
                        //
                        $template->set_filenames(array(
                            'confirm' => 'confirm_body.tpl')
                        );
            
                        $template->assign_vars(array(
                            'MESSAGE_TITLE' => $lang['Confirm'],
                            'MESSAGE_TEXT' => '<img src="' . $image . '" alt="' . $choice . '" /><br />' . $lang['Avatar_Confirm_Choice'],
            
                            'L_YES' => $lang['Yes'],
                            'L_NO' => $lang['No'],
            
                            'S_CONFIRM_ACTION' => append_sid('avatar_gallery.'.$phpEx),
                            'S_HIDDEN_FIELDS' => $hidden_fields)
                        );
            
                        $template->pparse('confirm');
                }
                break;
                
        default :

                if ( $board_config['allow_avatar_local'] ) {
			$l_title = $lang['Avatar_gallery'];
			//
			// Lets build a page ...
			//
			$page_title = $l_title;
			include($phpbb_root_path . 'includes/page_header.'.$phpEx);
			
			display_avatar_gallery($category, $userdata['user_id'], $board_config['allow_avatar_choice'], $mod_version, $mod_year);       
			$template->pparse('body');
		} else {
                        // Attempt to view the gallery when avatars gallery disabled => redirection
                        $redirect = 'index.'.$phpEx;
                        redirect(append_sid($redirect, true));
		}   
                
                break;
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
