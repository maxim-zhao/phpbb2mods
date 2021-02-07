<?php
/***************************************************************************
 *                              admin_invites_edit.php
 *                            -------------------
 *   begin                : Monday, Jul 25, 2005
 *   version              : 1.0.4 $Date: 2006/07/09 16:50:33 $; $Revision: 1.2 $
 *   copyright            : (C) 2005 Kellanved 
 *   email                : kellanved@gmail.com
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
	$filename = basename(__FILE__); 
	$module['Invitations']['Add_invite'] = $filename; 

	return; 
}


// Let's set the root dir for phpBB
//


$phpbb_root_path = './../';
 
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
include($phpbb_root_path . 'includes/functions_invite.'.$phpEx);


$mode = $action = $iid  = $delete = 0; 
if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars(trim(stripslashes($mode)));
}
if( isset($HTTP_GET_VARS['action']) || isset($HTTP_POST_VARS['action']) )
{
	$action = ($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : $HTTP_POST_VARS['action'];
	$action = htmlspecialchars(trim(stripslashes($action)));
}
if( isset($HTTP_GET_VARS[POST_INVITES_URL]) || isset($HTTP_POST_VARS[POST_INVITES_URL]) )
{
	$iid = ($HTTP_GET_VARS[POST_INVITES_URL]) ? $HTTP_GET_VARS[POST_INVITES_URL] : $HTTP_POST_VARS[POST_INVITES_URL];
	$iid = intval($iid);
}
if( isset($HTTP_GET_VARS['delete']) || isset($HTTP_POST_VARS['delete'] ))
{
	$delete = true;
}
 
if ($mode === 'edit')
{
	if (empty($iid))
	{
		message_die(GENERAL_MESSAGE, $lang['No_invite_id_specified'] );
	}
		
	if ($action==='save')
	{
		if ($delete)
		{
		   
			$sql = "DELETE FROM " . INVITATION_TABLE . "
				WHERE (invitation_id = $iid) ";
				
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t delete invite data', '', __LINE__, __FILE__, $sql);
			}
				
			$sql = "DELETE FROM " . INVITATION_USER_TABLE . "
				WHERE (invitation_id = $iid ) ";
				
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t delete invite data', '', __LINE__, __FILE__, $sql);
			}
				  
			$message = $lang['Invite_removed'] . '<br /><br />' . 
			sprintf($lang['Click_return_invite_list'], "<a href=\"" . append_sid("admin_invites_list.$phpEx",true) . "\">", "</a>") . "<br /><br />" .
			sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
			 
		if( isset($HTTP_GET_VARS['description']) || isset($HTTP_POST_VARS['description']) )
		{
			$description = ($HTTP_GET_VARS['description']) ? $HTTP_GET_VARS['description'] : $HTTP_POST_VARS['description'];
			$description= htmlspecialchars(trim($description));
		}
			
		if( isset($HTTP_GET_VARS['uses']) || isset($HTTP_POST_VARS['uses']) )
		{
			$uses = ($HTTP_GET_VARS['uses']) ? $HTTP_GET_VARS['uses'] : $HTTP_POST_VARS['uses'];
			$uses = intval($uses);
		} 
		else 
		{
			$uses = 1;
		}    
		if( isset($HTTP_GET_VARS['group']) || isset($HTTP_POST_VARS['group']) )
		{
			$group = ($HTTP_GET_VARS['group']) ? $HTTP_GET_VARS['group'] : $HTTP_POST_VARS['group'];
			$group = intval($group);
		}
		if( isset($HTTP_GET_VARS['auto-activate']) || isset($HTTP_POST_VARS['auto-activate']) )
		{         
			$auto_activate= 1;
		}
		else
		{
			$auto_activate= 0;
		}
			 
			 
		$sql = "UPDATE " . INVITATION_TABLE . " 
				SET 
				invitation_description = '".str_replace("\'", "''", $description)."',
				invitation_group = '".intval($group)."',  
				invitation_uses = '".intval($uses)."',               
				invitation_group_auto_activate = '$auto_activate'
				WHERE
				(invitation_id = $iid)";
			 
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update invites table", "", __LINE__, __FILE__, $sql);
		}                        
		$message = $lang['Invite_updated'] . '<br /><br />' . 
				sprintf($lang['Click_return_invite_edit'], "<a href=\"" . append_sid("admin_invites_edit.$phpEx?".POST_INVITES_URL."=$iid&amp;mode=edit",true) . "\">", "</a>") . "<br /><br />" . 
				sprintf($lang['Click_return_view_invite_data'], "<a href=\"" . append_sid("admin_invites.$phpEx?".POST_INVITES_URL."=$iid",true) . "\">", "</a>") . "<br /><br />" .
				sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right",true) . "\">", "</a>");
				
		message_die(GENERAL_MESSAGE, $message);
				 
	} 
	else
	{
		$sql = "SELECT * FROM " . INVITATION_TABLE . "
			WHERE (invitation_id = $iid)";
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Couldn't obtain invite  data", "", __LINE__, __FILE__, $sql);
		}
		
		$invite = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if (empty($invite))
		{
			message_die(GENERAL_MESSAGE, $lang['No_invite_id_specified'] );
		}
		
		$template->set_filenames(array(
			'body' => 'admin/invite_add_body.tpl')
		);
		
		$hidden_fields = '<input type="hidden" name="action" value="save" />
				 <input type="hidden" name="mode" value="edit" />
				 <input type="hidden" name="'.POST_INVITES_URL.'" value="'.$iid.'" />';
		$hidden_fields_mail =  '<input type="hidden" name="mode" value="send_email" /> 
				<input type="hidden" name="'.POST_INVITES_URL.'" value="'.$iid.'" />';
				 
		$template->assign_block_vars('switch_edit_invite', array()); 
		$template->assign_block_vars('switch_edit_add_invite', array()); 
		$template->assign_vars(array(
				'L_INVITES_TITLE' => $lang['Edit_invite'],
				'L_INVITES_TEXT' => $lang['Edit_invite_text'],
				'L_DESCRIPTION' => $lang['Invitation_description'],
				'L_USES' => $lang['Invitation_uses'],	
				'L_USES_EXPLAIN' => $lang['Invitation_uses_explain'],
				'L_GROUP' => $lang['Invitation_group'],
				'L_SUBMIT' => $lang['Submit'], 
				'L_RESET' => $lang['Reset'],
				'L_SEND_MAIL' => $lang['Send_new_mail'],
				'L_AUTO_ACT' => $lang['Auto_activate_group_membership'],
				'L_DELETE' => $lang['Delete'],
				'L_DELETE_WARN' => $lang['Invite_delete_explain'],
				'USES' => $invite['invitation_uses'],
				'AUTO_ACT' => ( $invite['invitation_group_auto_activate'] == 1) ? 'checked' :'',
				'DESCRIPTION' => unprepare_message($invite['invitation_description']),
				'S_HIDDEN_FIELDS' => $hidden_fields,
				'S_HIDDEN_SENDMAIL_FIELDS' => $hidden_fields_mail,
				'S_INVITE_ACTION' => append_sid("admin_invites_edit.$phpEx",true),
				'S_GROUP_SELECT_BOX' => build_group_box($invite['invitation_group'])
				)
		);
		$template->pparse('body');

	}
}
elseif ($mode === 'send_email' )
{
	if (!empty($iid)){
	$sql = "SELECT * FROM " . INVITATION_TABLE . "
		WHERE invitation_id = $iid";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Couldn't obtain invite  data", "", __LINE__, __FILE__, $sql);
	}
				
	$invite = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	}
	if (empty($invite))
	{
	message_die(GENERAL_MESSAGE, $lang['No_invite_id_specified'] );
	}
	if ($action=== 'save') //No htmlspecialchars, as we don't use HTML mail. Text will work fine. Also, this is an admin page w/o DB actions; thus we don't need to be too worried about XSS.
	{
		if( isset($HTTP_GET_VARS['message']) || isset($HTTP_POST_VARS['message']) )
		{
			$message = ($HTTP_GET_VARS['message']) ? $HTTP_GET_VARS['message'] : $HTTP_POST_VARS['message'];
			$message= trim(stripslashes($message));
		} 
		 
		 
		if( isset($HTTP_GET_VARS['email_subject']) || isset($HTTP_POST_VARS['email_subject']) )
		{
			$subject = ($HTTP_GET_VARS['email_subject']) ? $HTTP_GET_VARS['email_subject'] : $HTTP_POST_VARS['email_subject'];
			$subject= trim(stripslashes($subject));
		}
		if( isset($HTTP_GET_VARS['email_to']) || isset($HTTP_POST_VARS['email_to']) )
		{
			$email_to = ($HTTP_GET_VARS['email_to']) ? $HTTP_GET_VARS['email_to'] : $HTTP_POST_VARS['email_to'];
			$email_to= trim(stripslashes($email_to)); //this will need further cleaning - yet we trust admins to a certain degree.
		}
		if (!empty($message) && !empty($subject) && !empty($email_to))
		{
			resend_invite_mail($iid, $email_to, $subject, $message) ;
			message_die(GENERAL_MESSAGE, $lang['Email_sent'] . '<br /><br />' .
						sprintf($lang['Click_return_invite_edit'], "<a href=\"" . append_sid("admin_invites_edit.$phpEx?".POST_INVITES_URL."=$iid&amp;mode=edit",true) . "\">", "</a>")).  '<br /><br />'.
						sprintf($lang['Click_return_admin_index'],  '<a href="' . append_sid("index.$phpEx?pane=right",true) . '">', '</a>') ;         
		}
		else 
		{
			message_die(GENERAL_ERROR, $lang['Fill_out_all_Fields']);
		}
	}
	else
	{
		$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path'])); 
		$sig =  (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '';
		$reglink = $server_protocol .  $server_name .  $server_port .  $script_name   ;
		$body_str = $board_config['sitename']. "\n\n\n " .  $sig  ;    
		$template->set_filenames(array(
			'body' => 'admin/invite_add_body.tpl')
		);
		
		$hidden_fields = '<input type="hidden" name="action" value="save" />
				 <input type="hidden" name="mode" value="send_email" />
				 <input type="hidden" name="'.POST_INVITES_URL.'" value="'.$iid.'" />
				   ';
		 
		$template->assign_block_vars('switch_send_email', array());
		$template->assign_vars(array(
				'L_INVITES_TITLE' => $lang['Resend_mail'],
				'L_INVITES_TEXT' => $lang['Resend_mail_text'],         
				'L_EMAIL_TITLE' => $lang['Invite_email'],
				'L_EMAIL_MSG' => $lang['Message'],
				'L_DEFAULT_SUBJECT' => sprintf($lang['Default_invite_subject'],  $board_config['sitename']),
				'L_DEFAULT_MESSAGE' => $lang['Default_invite_message'] . $body_str, 
				'L_RECIPIENT' => $lang['Recipient'],
				'L_SUBJECT' => $lang['Subject'],
				'L_SUBMIT' => $lang['Submit'], 
				'L_RESET' => $lang['Reset'],
				 
				'S_HIDDEN_FIELDS' => $hidden_fields,     
		
				  
		
				'S_INVITE_ACTION' => append_sid("admin_invites_edit.$phpEx",true),
				'S_GROUP_SELECT_BOX' => build_group_box(0)
				 
				 
				
				)
		);
		$template->pparse('body');
	}
}
elseif ($mode === 'add' )
{
	 
	
	
	 
	if ($action=== 'save')
	{
		$error = false;
		$error_message = '';
		if( isset($HTTP_GET_VARS['message']) || isset($HTTP_POST_VARS['message']) )
		{
			$message = ($HTTP_GET_VARS['message']) ? $HTTP_GET_VARS['message'] : $HTTP_POST_VARS['message'];
			$message= trim(stripslashes($message));
		}
		if( isset($HTTP_GET_VARS['email_subject']) || isset($HTTP_POST_VARS['email_subject']) )
		{
			$subject = ($HTTP_GET_VARS['email_subject']) ? $HTTP_GET_VARS['email_subject'] : $HTTP_POST_VARS['email_subject'];
			$subject= trim(stripslashes($subject));
		}
		if( isset($HTTP_GET_VARS['email_to']) || isset($HTTP_POST_VARS['email_to']) )
		{
			$email_to = ($HTTP_GET_VARS['email_to']) ? $HTTP_GET_VARS['email_to'] : $HTTP_POST_VARS['email_to'];
			$email_to= trim(stripslashes($email_to)); //this will need further cleaning 
		}		 
	
	 
		
		if( isset($HTTP_GET_VARS['description']) || isset($HTTP_POST_VARS['description']) )
		{
			$description = ($HTTP_GET_VARS['description']) ? $HTTP_GET_VARS['description'] : $HTTP_POST_VARS['description'];
			$description= htmlspecialchars(trim($description));
		}
		
		if( isset($HTTP_GET_VARS['uses']) || isset($HTTP_POST_VARS['uses']) )
		{
			$uses = ($HTTP_GET_VARS['uses']) ? $HTTP_GET_VARS['uses'] : $HTTP_POST_VARS['uses'];
			$uses = intval($uses);
		} 
		else 
		{
			$uses = 1;
		}    
		if( isset($HTTP_GET_VARS['group']) || isset($HTTP_POST_VARS['group']) )
		{
			$group = ($HTTP_GET_VARS['group']) ? $HTTP_GET_VARS['group'] : $HTTP_POST_VARS['group'];
			$group = intval($group);
		}
		if( isset($HTTP_GET_VARS['auto-activate']) || isset($HTTP_POST_VARS['auto-activate']) )
		{         
			$auto_activate= 1;
		}
		if (!empty($email_to)  && (empty($message) || empty($subject))) 
		{
			$error_message.= $lang['Fill_out_email_fields'] . '<br />';
			$error = true;
		}
		$code = (isset($HTTP_POST_VARS['code'])) ? trim($HTTP_POST_VARS['code']) : '';		
		if (!preg_match('/^[A-Za-z0-9]*$/', $code)) 
		{
			$error_message.= $lang['Only_alphanumeric'] . '<br />';
			$error = true;			
		} 
		else
		{       
			if (empty($code))
			{				
				$code = generate_code();
			}    
			$code = (preg_match('/^[A-Za-z0-9]+$/', $code)) ? $code : ''; 
			$test = get_invitation($code);
			if (!empty($test))
			{
				$error_message.= $lang['Invitation_code_already_taken'] . '<br />';
				$error = true;
			}   
		}
		
		if (!$error)
		{
			$mail = str_replace(",", ", ", $email_to );
			$mail = str_replace(";", " ", $mail );
			$sql = "INSERT INTO " . INVITATION_TABLE . " (invitation_code, invitation_uses, invitation_description, invitation_email, invitation_sender, invitation_group,  invitation_group_auto_activate )
							VALUES ('$code' , '$uses' ,'" . str_replace("\'", "''", $description) . "', '" . str_replace("\'", "''", $mail) . "', '0', '$group', '$auto_activate')" ;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update/insert into invites table", "", __LINE__, __FILE__, $sql);
			}        
			if (!empty($email_to)) 
			{
				send_invite_mail($email_to, $code, $subject, $message, 1) ;         
		
			}    
			
			message_die(GENERAL_MESSAGE, $lang['Invite_created'] . '<br /><br />' .
				$lang['Invitation_code'] .': &nbsp;' . $code . '<br /><br />' .
				sprintf($lang['Click_return_view_invite_data'],  '<a href="' . append_sid("admin_invites.$phpEx?code=$code",true) . '">', '</a>').   '<br /><br />' .
				sprintf($lang['Click_return_admin_index'],  '<a href="' . append_sid("index.$phpEx?pane=right",true) . '">', '</a>').  '<br /><br />' .
				sprintf($lang['Click_return_invite_geenration'],  '<a href="' . append_sid("index.$phpEx?pane=right",true) . '">', '</a>'));
			
		
			
		} 
		else
		{
		 
			$template->set_filenames(array(
				'reg_header' => 'error_body.tpl')
			);
			$template->assign_vars(array(
				'ERROR_MESSAGE' => $error_message)
			);
			$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
		}
	}
	if (empty($action) || $error) 
	{
		
		$template->set_filenames(array(
			'body' => 'admin/invite_add_body.tpl')
		); 
		
		$sig =  (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '';
		$body_str = $board_config['sitename']. "\n \n\n" .  $sig;    
		$hidden_fields = '<input type="hidden" name="action" value="save" />
				 <input type="hidden" name="mode" value="add" />
				   ';
		$template->assign_block_vars('switch_add_invite', array()); 
		$template->assign_block_vars('switch_edit_add_invite', array());
		$template->assign_block_vars('switch_send_email', array());
		$template->assign_vars(array(
				'L_INVITES_TITLE' => $lang['Generate_new_invite'],
				'L_INVITES_TEXT' => $lang['Generate_new_invite_text'],
				'L_DESCRIPTION' => $lang['Invitation_description'],
				'L_USES' => $lang['Invitation_uses'],
				'L_SUBJECT' => $lang['Subject'],
				'L_RECIPIENT' => $lang['Recipient'],
				'L_EMAIL_TITLE' => $lang['Invite_email'],
				'L_EMAIL_MSG' => $lang['Message'],
				'L_DEFAULT_SUBJECT' => (!empty($subject)) ? $subject :  sprintf($lang['Default_invite_subject'],  $board_config['sitename']),
				'L_DEFAULT_MESSAGE' => (!empty($message)) ? $message : $lang['Default_invite_message'] . $body_str, 
				'L_USES_EXPLAIN' => $lang['Invite_uses_explain'],
				'L_GROUP' => $lang['Invitation_group'],
				'L_SUBMIT' => $lang['Submit'], 
				'L_RESET' => $lang['Reset'],
				'L_SEND_MAIL' => $lang['Send_new_mail'],
				'L_ACUTO_ACT' => $lang['Auto_activate_group_membership'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'L_CODE' => $lang['Invitation_code'],
				'L_CODE_EXPLAIN' => $lang['Invitation_code_constraints'],
				'DESCRIPTION' => $description,
				'USES' => (!empty($uses)) ? $uses : '1' ,
				'AUTO_ACT' => ($auto_activate ) ? 'checked' : '',
				'CODE' => $code,
				'RECIPIENT' => $email_to,				
				'S_HIDDEN_FIELDS' => $hidden_fields,   
				'S_INVITE_ACTION' => append_sid("admin_invites_edit.$phpEx",true),
				'S_GROUP_SELECT_BOX' => build_group_box($group)
				)
		);
	  
		$template->pparse('body');
	  
	}
}
else
{

	$template->set_filenames(array(
		'body' => 'admin/invite_generate.tpl')
	);

	 
	$template->assign_vars(array(
			'L_GENERATE_INVITES_TITLE' => $lang['Generate_new_invite'],
			'L_GENERATE_INVITES_EXPLAIN' => $lang['Generate_new_invite_explain'],
			'L_GENERATE_INVITE' => $lang['Generate_new_invite'],
			'S_INVITE_ACTION' => append_sid("admin_invites_edit.$phpEx",true),
			)
	);
	$template->pparse('body');
}
include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
 



/*Builds the lines for a drop box containing the group names. 
The Group with the id $selected will be selected by default. Does not add the opening and closing HTML <select> tags.
*/
function build_group_box($selected=0) 
{
global $db, $lang;
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
		if ($selected == $group_id)
		{
			$group_select_box .= '<option value="' . $group_id . '"' . 'selected  >' . $group . '</option>';
		} 
		else
		{
			$group_select_box .= '<option value="' . $group_id . '"' . '>' . $group . '</option>';
		}
	}    
	$db->sql_freeresult($result);
	return $group_select_box ;
}


?>