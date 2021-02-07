<?php
/***************************************************************************
 *							  admin_invites.php
 *							-------------------
 *   begin				: Saturday, March 5, 2005
 *   version			: 1.0.4 $Date: 2006/03/12 15:44:43 $; $Revision: 1.1 $
 *   copyright			: (C) 2005, Kellanved; based on admin_rank by the phpBB Group
 *	
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

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Users']['Invitations'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else 
{
	//
	// These could be entered via a form button
	//
	if( isset($HTTP_POST_VARS['add']) )
	{
		$mode = 'add';
	}
	else if( isset($HTTP_POST_VARS['save']) )
	{
		$mode = 'save';
	}
	else
	{
		$mode = '';
	}
}

//check for a valid "mode" - show the list if there isn't one
if( $mode != '' && ( $mode == 'add' || $mode == 'delete' || $mode == 'edit' || $mode == 'save'))
{
	if( $mode == 'add' )	 // OK - we want a new invite
	{

		$s_hidden_fields = '';
		$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';
		$s_hidden_fields .= '<input type="hidden" name="action" value="add" />'; 
		
		$template->set_filenames(array(
			'body' => 'admin/invite_add_body.tpl')
		);
		//Prepare the data for the notification email. 
		//We want to have the text editable, so the language system is used instead of an email template. 
		$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path'])); 
		$script_name = ($script_name != '') ? $script_name . '/profile.'.$phpEx : 'profile.'.$phpEx;
		$server_name = trim($board_config['server_name']);
		$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
		$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';
		$sig =  (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '';
		$reglink = $server_protocol .  $server_name .  $server_port .  $script_name   ;
		$body_str = $board_config['sitename']. "\n " .  $sig  ;	
		
		//assemble the drop box for the groups	
		$group_select_box = '<option value="0">' . $lang['None'] . '</option>';
		$sql = 'SELECT * FROM ' . GROUPS_TABLE . '
				WHERE (group_single_user = 0)
				ORDER BY group_name';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain group data', '', __LINE__, __FILE__, $sql);
		}
			
		while( $row = $db->sql_fetchrow($result) )
		{
			$group = $row['group_name'];
			$group_id = $row['group_id'];			 
			$group_select_box .= "<option value=\"$group_id \">$group</option>";
		} 
		$db->sql_freeresult($result);
		$template->assign_block_vars('switch_add_invite', array()); 
		$template->assign_vars(array(
				'USES' => 1, 
				'DESCRIPTION' => '',
                                'L_DESCRIPTION' => $lang['Invite_description'],
				'L_INVITES_TITLE' => $lang['Add_new_invite'],
				'L_INVITES_TEXT' => $lang['Add_new_invite_text'],
				'L_USES' => $lang['Invite_uses'],
				'L_USES_EXPLAIN' => $lang['Invite_uses_explain'],
				'L_GROUP' => $lang['Invite_group'],
				'L_SUBMIT' => $lang['Submit'],
				'L_RESET' => $lang['Reset'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'L_INVITE_EMAIL_TITLE' => $lang['Invite_email'],
				'L_SUBJECT' => $lang['Subject'],
				'L_RECIPIENT' => $lang['Recipient'],
				'L_EMAIL_TITLE' => $lang['Email'],
				'L_EMAIL_MSG' => $lang['Message'],
				'L_DEFAULT_SUBJECT' => $lang['Default_invite_subject'] . $board_config['sitename'],
				'L_DEFAULT_MESSAGE' => $lang['Default_invite_message'] . $body_str, 
				'S_INVITE_ACTION' => append_sid("admin_invites.$phpEx"),
				'S_GROUP_SELECT_BOX' => $group_select_box,
				'S_HIDDEN_FIELDS' => $s_hidden_fields)
			);		
	} 
	else if($mode == 'edit')
	{	   
		//OK, we just want to edit. Basically the same thing, but there is no email to worry about.
		if( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
		{
			$invite_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);			 
		}
		else
		{
			$invite_id = 0;
		}
		
		if( $invite_id )
		{
			$sql = "SELECT * FROM " . INVITATION_TABLE . "
					WHERE (invitation_id = $invite_id) ";
					
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't select invite data", "", __LINE__, __FILE__, $sql);
			}		   
			if( !$invite = $db->sql_fetchrow($result))
			{
				message_die(GENERAL_MESSAGE, $lang['Must_select_invitation']);
			}
					
			$s_hidden_fields .= '<input type="hidden" name="id" value="'.$invite_id.'" />';
			$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';
			$s_hidden_fields .= '<input type="hidden" name="action" value="edit" />'; 
				   
						
					
			$group_select_box = '<option value="0">' . $lang['None'] . '</option>';
			$db->sql_freeresult($result);		
			$sql = 'SELECT * FROM ' . GROUPS_TABLE . '
					WHERE (group_single_user = 0)
					ORDER BY group_name';
					
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain group data', '', __LINE__, __FILE__, $sql);
			}
				  
			while( $row = $db->sql_fetchrow($result) )
			{
				$group = $row['group_name'];
				$group_id = $row['group_id'];
				if ($invite['invitation_group'] == $group_id)
				{
					$group_select_box .= '<option value="' . $group_id . '"' . 'selected  >' . $group . '</option>';
				} 
				else
				{
					$group_select_box .= '<option value="' . $group_id . '"' . '>' . $group . '</option>';
				}
			}	
			$template->set_filenames(array(
				'body' => 'admin/invite_add_body.tpl')
				);					
			$db->sql_freeresult($result);
			$template->assign_block_vars('switch_edit_invite', array()); 
			$template->assign_vars(array(					
					'USES' => $invite['invitation_uses'],	
					'DESCRIPTION' => $invite['invitation_description'],  
					'L_DESCRIPTION' => $lang['Invite_description'],
					'L_INVITES_TITLE' => $lang['Edit_invite'],
					'L_INVITES_TEXT' => $lang['Edit_invite_text'],
					'L_USES' => $lang['Invite_uses'],
					'L_USES_EXPLAIN' => $lang['Invite_uses_explain'],
					'L_GROUP' => $lang['Invite_group'],
					'L_SUBMIT' => $lang['Submit'],
					'L_RESET' => $lang['Reset'],
					'L_YES' => $lang['Yes'],
					'L_NO' => $lang['No'],
					'L_SUBJECT' => $lang['Subject'],										
					'S_INVITE_ACTION' => append_sid("admin_invites.$phpEx"),
                                        'S_GROUP_SELECT_BOX' => $group_select_box,
					'S_HIDDEN_FIELDS' => $s_hidden_fields)
				);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_invitation']);
		}		   
	}
	else if( $mode == 'save' )
	{
		//
		// OK, edit and add is somewhat mixed in here. 
		//	
		mt_srand((double)microtime()*1000000); //OK, this should ensure  compatibility for PHP <= 4.1.x
		$invite_code = md5(mt_rand());
		$invite_code = substr($invite_code, 0, 8); 
		$invite_decription = ( (isset($HTTP_POST_VARS['description'])) ) ? trim($HTTP_POST_VARS['description']) : '';
		//$invite_decription = htmlspecialchars($invite_decription);   
		$invite_group = ( (isset($HTTP_POST_VARS['group'])) ) ? trim($HTTP_POST_VARS['group']) : '';
		$invite_group = intVal($invite_group);	 
		$invite_uses = ( (isset($HTTP_POST_VARS['uses'])) ) ? trim($HTTP_POST_VARS['uses']) : '';
		$invite_uses = intVal($invite_uses);					 
		$action = ( (isset($HTTP_POST_VARS['action'])) ) ? trim($HTTP_POST_VARS['action']) : '';
		$edit = ($action == 'edit'); 
		if (!$edit) //i.e. if (Add a new invite)
		{   
			//again, we are preparing the email data
			$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
			$script_name = ($script_name != '') ? $script_name . '/profile.'.$phpEx : 'profile.'.$phpEx;
			$server_name = trim($board_config['server_name']);
			$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
			$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';				
			$reglink = $server_protocol .  $server_name .  $server_port .  $script_name .'?mode=register';	
			$email_to = ( (isset($HTTP_POST_VARS['email_to'])) ) ? trim($HTTP_POST_VARS['email_to']) : '';
			$email_to = htmlspecialchars($email_to);
			$email_subject = ( (isset($HTTP_POST_VARS['email_subject'])) ) ? trim($HTTP_POST_VARS['email_subject']) : '';
			$email_subject = htmlspecialchars($email_subject);
			$email_body = ( (isset($HTTP_POST_VARS['message'])) ) ? trim($HTTP_POST_VARS['message']) : '';
			$email_body = htmlspecialchars($email_body);   
			if (!empty($email_to))
			{
				include($phpbb_root_path . 'includes/emailer.'.$phpEx);	  
				if ($invite_uses == 1 && !(strchr($email_to, ',') || strchr($email_to, ';')))
				{
					$reglink .=  '&mail=' . urlencode($email_to);
				}
				$emailer = new emailer($board_config['smtp_delivery']);
				
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);					
		
				$email_headers = 'X-AntiAbuse: Board servername - ' . $board_config['server_name'] . "\n";
				$email_headers .= 'X-AntiAbuse: User_id - ' . $userdata['user_id'] . "\n";
				$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
				$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";
		
				$emailer->use_template('admin_send_invite_email');
				$emailer->email_address($email_to);					
			
				$emailer->set_subject($email_subject);
						
		
				$emailer->assign_vars(array(
					'SITENAME' => $board_config['sitename'], 
					'BOARD_EMAIL' => $board_config['board_email'], 
					'MESSAGE' => $email_body,
					'REGISTERLINK' => $reglink .  '&invite=' . $invite_code . "\n",	  
					'CODE' => $invite_code)
					);
				$emailer->send();
				$emailer->reset();   
				  
			}
					 
			$sql = "INSERT INTO " . INVITATION_TABLE . " (invitation_code, invitation_description, invitation_email, invitation_uses, invitation_group)
					VALUES ('$invite_code' , '" . str_replace("\'", "''", $invite_decription) . "', '" . str_replace("\'", "''", $email_to) . "', '$invite_uses', '$invite_group')" ;
						
			$message = $lang['Invitation_generated'] . '<br />' .  $invite_code;
			$message .= '<br /><br />' . sprintf($lang['Click_return_invite_admin'], "<a href=\"" . append_sid("admin_invites.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	
					
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update/insert into invites table", "", __LINE__, __FILE__, $sql);
			}		 
			message_die(GENERAL_MESSAGE, $message);
		}
		else //OK  we are in the edit mode
		{				 
			if( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
			{
				$invite_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);				 
			}
			else
			{
				$invite_id = 0;
			} 
			$sql = "UPDATE " . INVITATION_TABLE . "
					SET					
					invitation_description = '" . str_replace("\'", "''", $invite_decription) . "', 
					invitation_uses = '$invite_uses', 
					invitation_group ='$invite_group'							
					WHERE (invitation_id = $invite_id)" ;
							
			$message = $lang['Invitation_updated'] . '<br />';
			$message .= "<br /><br />" . sprintf($lang['Click_return_invite_admin'], "<a href=\"" . append_sid("admin_invites.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		
						
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t update/insert into invites table', '', __LINE__, __FILE__, $sql);
			}		 
			message_die(GENERAL_MESSAGE, $message);
				
				
		}

	}
	else if( $mode == 'delete' )
	{
		 
		if( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
		{
			$invite_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);			 
		}
		else
		{
			$invite_id = 0;
		}
		
		if( $invite_id )
		{
			$sql = "DELETE FROM " . INVITATION_TABLE . "
					WHERE (invitation_id = $invite_id) ";
			
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t delete invite data', '', __LINE__, __FILE__, $sql);
			}
			
			$sql = "DELETE FROM " . INVITATION_USER_TABLE . "
					WHERE (invitation_id = $invite_id ) ";
			
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t delete invite data', '', __LINE__, __FILE__, $sql);
			}
			  
			$message = $lang['Invite_removed'] . '<br /><br />' . sprintf($lang['Click_return_invite_admin'], "<a href=\"" . append_sid("admin_invites.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			 
			 
			message_die(GENERAL_MESSAGE, $message);

		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Must_select_invitation']);
		}
	}
	else
	{
		redirect(append_sid("admin/admin_invites.$phpEx")); //redirect to list
	}
}
else
{
	//
	// Show the default page
	//
	$invites_per_page = 30;
	$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
	$filter = (isset($HTTP_GET_VARS['filter'])) ? htmlspecialchars($HTTP_GET_VARS['filter']) : ((isset($HTTP_POST_VARS['filter'])) ? htmlspecialchars($HTTP_POST_VARS['filter']) : ''); 
	 
	$where = '';
	$filter_post = '?filter=all';
	 
	$active_selected = '';
	$inactive_selected = '';
	if ($filter == 'active') 
	{
		$where = "WHERE (invitation_uses <> '0')";
		$filter_post = '?filter=active';
		$active_selected = 'selected="selected"';
	} elseif ( $filter == 'inactive' )
	{
		$where = "WHERE (invitation_uses = '0')";
		$filter_post = '?filter=inactive';
		$inactive_selected = 'selected="selected"';	
	}	 
	$sql = 'SELECT count(invitation_id) as total FROM '.INVITATION_TABLE. " $where";
			 
	if(!$result = $db->sql_query($sql))
	{
	message_die(GENERAL_ERROR, 'Could not count invites', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$total_invites = $row['total'];
	$db->sql_freeresult($result);
	
	$sql = 'SELECT '.INVITATION_TABLE.'.*, '.GROUPS_TABLE .'.group_name, '.GROUPS_TABLE .'.group_id 
				FROM ' . INVITATION_TABLE . ' LEFT JOIN '. GROUPS_TABLE . '
				ON '.INVITATION_TABLE.'.invitation_group = ' .GROUPS_TABLE .".group_id
				$where 
				ORDER BY invitation_id	 
				LIMIT $start, $invites_per_page";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain invitation data', '', __LINE__, __FILE__, $sql);
	}
	$invite_count = $db->sql_numrows($result);
	$invite_rows = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);
	
	$template->set_filenames(array(
		'body' => 'admin/invites_list_body.tpl')
	);
	$template->assign_vars(array(
			'L_INVITES_DESCRIPTION' => $lang['Invites_description'],
			'L_INVITES_TITLE' => $lang['Invites_title'],
			'L_INVITES_TEXT' => $lang['Invites_text'],
			'L_INVITES_ID' => $lang['Invites_id'],		 
			'L_INVITES_CODE' => $lang['Invites_code'],		
			'L_INVITES_USES' => $lang['Invites_uses'], 
			'L_INVITES_USERS' => $lang['Invites_users'],   
			'L_ACTION' => $lang['Action'],
			'L_DELETE' => $lang['Delete'],
			'L_EDIT' => $lang['Edit'],
			'L_ADD_INVITTATION' => $lang['Add_new_invite'],
			'L_INVITES_DESCRIPTION' => $lang['Invites_description'],
			'L_INVITES_TITLE' => $lang['Invites_title'],
			'L_INVITES_TEXT' => $lang['Invites_text'],
			'L_INVITES_ID' => $lang['Invites_id'],		 
			'L_INVITES_CODE' => $lang['Invites_code'],		
			'L_INVITES_USES' => $lang['Invites_uses'], 
			'L_INVITES_USERS' => $lang['Invites_users'],   
			'L_ACTION' => $lang['Action'],
			'L_DELETE' => $lang['Delete'],
			'L_EDIT' => $lang['Edit'],
			'L_ADD_INVITTATION' => $lang['Add_new_invite'], 
			'L_USES_LEFT' => $lang['Invite_uses_remaining'],	
			'L_USERS_USED' => $lang['Invite_users_used'],
			'L_INVITE_GROUP' => $lang['Invite_group'],
			'L_SHOW' => $lang['Show'],
			'L_FILTER' => $lang['Filter'],  
			'L_ALL' => $lang['Show_all'],	
			'L_ACTIVE' => $lang['Active'],	
			'L_INACTIVE' => $lang['Inactive'],
			'L_NONE' => $lang['None'],	
			'ACTIVE_SELECTED' => $active_selected,
			'INACTIVE_SELECTED' => $inactive_selected,
			'S_INVITE_ACTION' => append_sid("admin_invites.$phpEx"),
			'S_FILTER_ACTION' => append_sid("admin_invites.$phpEx"),
			'PAGES' => generate_pagination(append_sid("admin_invites.$phpEx" . "$filter_post"), $total_invites, $invites_per_page, $start),
			'PAGE' => sprintf($lang['Page_of'], ( floor( $start / $invites_per_page ) + 1 ), ceil( $total_invites / $invites_per_page ))
			)
	);
	 
	for($i = 0; $i < $invite_count; $i++)
	{
		$invite = $invite_rows[$i]['invitation_id'];
		$code = $invite_rows[$i]['invitation_code'];
		$description = $invite_rows[$i]['invitation_description'];
                $description .= (!empty($invite_rows[$i]['invitation_email']))? $lang['Invite_email_sent']. ' ' . $invite_rows[$i]['invitation_email']: '' ;
		$uses =  $invite_rows[$i]['invitation_uses'];
		$group_id =  $invite_rows[$i]['invitation_group'];
		$group_name =  '';
		if ($uses == 0) 
		{
			$uses = $lang['None'];
		} 
		else if ($uses == -1)
		{   
			$uses = $lang['Infinite'];
		}	
			 
		$sql = "SELECT ".USERS_TABLE.".username, ".USERS_TABLE.".user_id  FROM " . USERS_TABLE .", " . INVITATION_USER_TABLE . " 
				WHERE (".INVITATION_USER_TABLE . ".invitation_id = '$invite')
				AND (". INVITATION_USER_TABLE.".user_id = " . USERS_TABLE. ".user_id)";
						
						
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain Invitation_User data', '', __LINE__, __FILE__, $sql);
		}
		$invite_user_count = $db->sql_numrows($result);
		$invite_user_rows = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);
		 
                $group_name= (!empty($invite_rows[$i]['group_name']))? $invite_rows[$i]['group_name']: $lang['None'] ;
		 
		 
		$users = ($invite_user_count == 0) ? $lang['None'] : '';
		for($j = 0; $j < $invite_user_count; $j++)
		{	
			$users .= ($j == 0) ? '' : '; ';

			$users.=  "<a href=".append_sid("admin_users.$phpEx?mode=edit&amp;".POST_USERS_URL."=".$invite_user_rows[$j]['user_id']).">".$invite_user_rows[$j]['username']."</a>";
			
				
		}	
				
			
		
		 

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];		 
		
		$template->assign_block_vars('invites', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'INVITE' => $invite,
				'CODE' => $code,
				'USES' => $uses,
				'USERS' => $users,
				'GROUP' => $group_name,
				'DESCRIPTION' => $description,			 
				'U_INVITE_DELETE' => append_sid("admin_invites.$phpEx?mode=delete&amp;id=$invite"),
				'U_INVITE_EDIT' => append_sid("admin_invites.$phpEx?mode=edit&amp;id=$invite"))
			);
	}
}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
