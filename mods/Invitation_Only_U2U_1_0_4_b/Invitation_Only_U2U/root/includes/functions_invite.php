<?php
/***************************************************************************
 *                              functions_invite.php
 *                            -------------------
 *   begin            : Saturday, July 17th, 2005
 *   version          : 1.0.4  $Date: 2006/07/09 16:46:08 $; $Revision: 1.1 $
 *   copyright        : (C) 2005, Kellanved; based on admin_invites by Kellanved
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
/**
About these functions:
Most of the functions in this file were written without the intention to create them re-usable.
The functions are pooled in this file, in order to structure the code and streamline the mod-template.*/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}

define('SORT_BY_INVITE_ID', 1);
define('SORT_BY_USES_LEFT', 2);
define('SORT_BY_SENDER_NAME', 3);
define('SORT_BY_USER_COUNT', 4);
define('SORT_BY_INVITATION_GROUP', 5);
 
include_once("$phpbb_root_path"."includes/functions_post.$phpEx");

 
 
//Displays a splash screen to visitors informing them about the invitation only status. 
//A code can be entered and will be forwarded to the registration.
function show_invitation_only()
{
	global $userdata, $template, $lang, $phpbb_root_path, $phpEx, $board_config;

	$template->set_filenames(array(
		'body' => 'invitation_only.tpl')
	);

	$template->assign_vars(array(
		'REGISTRATION' => $lang['Board_invitation_only'],
		'MESSAGE' => $lang['Invitation_only_message'].'<br />' . $board_config['additional_rules'],
		'L_ENTER_CODE' => $lang['Enter_code'],
		'S_ACTION' => append_sid("profile.$phpEx?mode=register",true)

		 
	));

	$template->pparse('body');

} 

//Returns a new random 8-letter String.
function generate_code()
{
	mt_srand((double)microtime()*1000000); //OK, this should ensure  compatibility for PHP <= 4.1.x //TODO: make a function oout of this
	$string = array();
	for ($j=0; $j < 8; $j++)
	{
		$letter_seed = mt_rand(0,61);
		$letter = 0;		
		if  ($letter_seed < 10)
		{
			$letter = $letter_seed + 48;
		} 
		else if( $letter_seed < 36)
		{
			$letter = $letter_seed + 55;
		}
		else 
		{
			$letter = $letter_seed + 61;
		}
		$code = substr($code, 0, 8);
		$string[$j] = chr($letter);
	}	
	return implode('',$string);
}

//Returns all users invited; either by a certain user, into a certain group or with a particular invite. Only one argument should be different from '0'.
function get_invited_users(
	$uid,       //ID of the inviter
	$gid,     //ID of the group
	$iid    //ID of the Invite
	)
{
	 global $db;
	
	$where = '';
	$uid = intval($uid); //I am sanitizing all arguments. As this does not need to be high-performance code, that should be acceptable.
	$iid = intval($iid);
	$gid = intval($gid);
	if (!empty($uid))
	{
		 $where .= " AND (it.invitation_sender = $uid)";
	}
		if (!empty($gid))
	{
		$where .= " AND (it.invitation_group =  $gid )";
	}
		if (!empty($iid))
	{
		$where .= " AND (it.invitation_id=  $iid)";
	}
   
	$sql = 'SELECT it.invitation_id AS invite,
		it.invitation_group AS invitation_group,
		ut.username AS name,
		ut.user_id  AS user_id,
		ut.user_regdate  AS  regdate ,
		it.invitation_sender as sender_id,
		ut2.username as sender_name,
		gt.group_name  AS group_name 
		FROM '.INVITATION_USER_TABLE. ' iut,
			 '.USERS_TABLE.' ut,
			 '.INVITATION_TABLE. ' it             
		LEFT JOIN '.GROUPS_TABLE.' gt
		ON it.invitation_group  =  gt.group_id
		LEFT JOIN '.USERS_TABLE.' ut2
		ON it.invitation_sender = ut2.user_id
			WHERE
		(it.invitation_id = iut.invitation_id) AND        
			(ut.user_id =  iut.user_id) '.$where;    
		
		 
		
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain invite  data', '', __LINE__, __FILE__, $sql);
	}
	$invited_members = $db->sql_fetchrowset($result);     
	$db->sql_freeresult($result);
	return $invited_members;
	
}

 
 


//returns the Invitation row corresponding to the code; false if there isn't one
function get_invitation($code )
{
	global $db;
 

	if (!isset($code) || !preg_match('/^[A-Za-z0-9]+$/', $code))  //this should get rid of any nasty surprises
	{
		$code = '';
	}
	if (empty($code))
	{
		return false;
	}
	else
	{
						
		$sql = 'SELECT invitation_id, invitation_group, invitation_uses 
		FROM ' . INVITATION_TABLE . " 
		WHERE   (invitation_code = '" . str_replace("\'", "''", $code) . "')";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR,'Could not query invitation table.');
		}
		if (!$invite_data = $db->sql_fetchrow($result))
		{        
			return false;
		}
		$db->sql_freeresult($result);
		return $invite_data;     
	}
	return false;
}





//returns the Invitation row corresponding to the code; false if there isn't one 
function get_valid_invitation($code)
{
	global $db;
 
	 
	if (!isset($code) || !preg_match('/^[A-Za-z0-9]+$/', $code))  //this should get rid of any nasty surprises
	{
		$code = '';
	}
	if (empty($code))
	{
		return false;
	}
	else
	{
							
			$sql = 'SELECT * 
					FROM ' . INVITATION_TABLE . " 
					WHERE    (invitation_uses <> 0) AND 
				   (invitation_code = '" . str_replace("\'", "''", $code) . "')";  //actually there is no way $code could contain quotes.
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR,'Could not query invitation table.');
	
		}
		if (!$invite_data = $db->sql_fetchrow($result))
		{        
			return false;
		}
		$db->sql_freeresult($result);
		return $invite_data; 
			
	}
	return false;
}



/*The start/limit clause is not yet fully supported Arguments are limited to ints for security reasons.
Returns Invitation Codes meeting certain criteria
There is alittle twist with the $order option (for the function see the constants defined at the top of this file) 
: a negative value will reverse the order of the results.
*/
function get_invites
(
	$uid=0,         //Invites issued by this user (ID)
	$gid=0,         //Invites joining into this group (ID)
	$start=0,         //offset (for SQL)
	$limit=0,         //how many results max (for SQL)
	$order=0        //the order of the rersults, according to the constants at the top of this file. Negative values reverse the order
)
{
	global $db;
	$uid = intval($uid);
	$gid = intval($gid);
	
	$start = intval($start);
	$limit = intval($limit);
	$order = intval($order);
	if (!empty($limit))
	{
	  $limit_clause = " LIMIT $start, $limit";
	}
	 
	$where = '';
	if (!empty($uid))
	{
		$where .=  "(it.invitation_sender =  $uid )";
	}
	if (!empty($gid))
	{   
		$where .= ($where == '') ? '' : ' AND '; 
		$where .= "(it.invitation_group =  $gid )";
	}
	$where = ($where == '') ? '' : ' WHERE '.$where; 
	$sort_by = '';
	if (!empty($order))
	{
		switch(abs($order))
		{
			case SORT_BY_INVITE_ID : 
				$sort_by = 'it.invitation_id';
				break;
			case SORT_BY_USES_LEFT : 
				$sort_by = 'it.invitation_uses';
				break;    
			case SORT_BY_SENDER_NAME : 
				$sort_by = 'sender_name';
				break;   
			case SORT_BY_USER_COUNT : 
				$sort_by = 'user_count';
				break;
			case SORT_BY_INVITATION_GROUP : 
				$sort_by = 'group_name';
		}
		if (!empty($sort_by))
		{
			$order_clause = ' ORDER BY ' . $sort_by;
			$order_clause .= ($order < 0) ? ' DESC' : ' ASC';
		}
	}

	$sql = 'SELECT it.*,
		ut.username AS sender_name,
		ut.user_id AS sender_id,
		 COUNT(iut.user_id)   AS user_count,
		gt.group_name  AS group_name 
		FROM '.INVITATION_TABLE. ' it
		LEFT JOIN '.GROUPS_TABLE.' gt
		ON it.invitation_group  =  gt.group_id
		LEFT JOIN '.INVITATION_USER_TABLE.' iut
		ON it.invitation_id  =  iut.invitation_id 
		LEFT JOIN '.USERS_TABLE.' ut
		ON it.invitation_sender  =  ut.user_id '.
			$where
		.' GROUP BY it.invitation_id'
		. $order_clause . $limit_clause;
			
			
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain group data', '', __LINE__, __FILE__, $sql);
	}
	$invites = $db->sql_fetchrowset($result);     
	$db->sql_freeresult($result);
	return $invites;
} // fine get_invites



//Prepares a table with the Invites for output.
function prepare_invitation_table(
	$invite_rows,  //the data, as returned by getInvites
	$template_name, // the name to use for the template section ('body')
	$page = '',    //slots for page/pagination fields
	$pages = '', 
	$title='',        //custom header
	$explanation = '')
{
	global $template, $phpEx, $lang, $theme;
	
	$invitation_count = count($invite_rows);
	$template->set_filenames(array(
		$template_name => 'admin/invites_list_body.tpl')
	);
	 
	$template->assign_vars(array(
			'L_INVITATION_DESCRIPTION' => $lang['Invitation_description'],
			'L_INVITATIONS_TITLE' => $title,
			'L_INVITATIONS_TEXT' => $explanation,
			'L_INVITATION_ID' => $lang['Invitation_id'],         
			'L_INVITATION_CODE' => $lang['Invitation_code'],        
			'L_USES_LEFT' => $lang['Invitation_uses_left'], 
			'L_INVITATION_USERS' => $lang['Invitation_user_count'],   
			 
						
			'L_SENDER' => $lang['Invitation_sender'],              
			 
			 
			'L_INVITATION_GROUP' => $lang['Invitation_group'],            
				 
			'L_NONE' => $lang['None'],    
			'PAGES' => $pages,
			'PAGE' => $page
			
			)
	);
	 
	for($i = 0; $i < $invitation_count; $i++)
	{
		//part of this should be moved to the template.
		$invite = $invite_rows[$i]['invitation_id'];
		$invite_link = '<a href="'. append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;i='.$invite ,true).'">'. $invite.'</a>';
		$code = $invite_rows[$i]['invitation_code'];
		$description = $invite_rows[$i]['invitation_description'];
				$description .= (!empty($invite_rows[$i]['invitation_email']))? '<br /><b>'.$lang['Invitation_email_sent'].': </b>'. $invite_rows[$i]['invitation_email']: '' ;
		$uses =  $invite_rows[$i]['invitation_uses'];
		$sender =  (!empty($invite_rows[$i]['sender_id']) )?'<a href="'. append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;'.POST_USERS_URL.'='. $invite_rows[$i]['sender_id'],true).'">'. $invite_rows[$i]['sender_name'].'</a>' :$lang['None'];
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
		  		 
		$users = (empty($invite_rows[$i]['user_count'])) ? $lang['None'] : '<a href="'. append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;i='.$invite ,true).'">'. $invite_rows[$i]['user_count'].'</a>'; 
		$group_name = (empty($invite_rows[$i]['invitation_group'])) ? $lang['None'] : '<a href="'. append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;'.POST_GROUPS_URL.'='.$group_id ).'">'. $invite_rows[$i]['group_name'].'</a>'; 

 			 

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];         
		
		$template->assign_block_vars('invitations', array(                
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'INVITE' => $invite_link,
				'CODE' => $code,
				'USES' => $uses,
				'USERS' => $users,
				'SENDER' => $sender,
				'GROUP' => $group_name,
				'DESCRIPTION' => $description         
				 )
			);
	}

}//fine prepare_invitation_table(



//Prepares a table with userdata for output. Relates to the getInvited function.
function prepare_users_table(
$users, 
$template_name, 
$title='', 
$explanation = '')
{
	global $template, $phpEx, $lang, $theme, $board_config;
	
	$user_count = count($users);
	$template->set_filenames(array(
		$template_name => 'admin/invites_list_invited.tpl')
	);
	 
	$template->assign_vars(array(
		'L_INVITED_TITLE' => $title,
		'L_INVITED_TEXT' => $explanation,
		'L_USERNAME' => $lang['Username'],
		'L_REGDATE' => $lang['Sort_Joined'] ,            
		'L_INVITER' => $lang['Invited_by'],    
		'L_INVITE' => $lang['Used_invitation_id'],                 
		'L_GROUP' => $lang['Invitation_group']
			 
			
		)
	);
	 
	for($i = 0; $i < $user_count; $i++)
	{
	  
		 
		$user_name = $users[$i]['name'];
		$user_id = $users[$i]['user_id'];
		 
		$user_link = append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;'.POST_USERS_URL.'='.$user_id);
		$regdate = $users[$i]['regdate'];
			 
		$regdate = create_date($board_config['default_dateformat'], $regdate, $board_config['board_timezone']);
		 
		$inviter = $users[$i]['sender_name'];
		$inviter_link =  (!empty($inviter)) ? '<a href="'.append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;'.POST_USERS_URL.'='. $users[$i]['sender_id'],true).'">'. $inviter.'</a>' : $lang['None']; 
		$invite = $users[$i]['invite'];
		$invite_link =  (!empty($invite)) ? '<a href="'.append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;'.POST_INVITES_URL.'='. $invite,true).'">'. $invite.'</a>' : $lang['None']; 
		
		$group = $users[$i]['group_name'];
		$group_link =  (!empty($group)) ? '<a href="'.append_sid('admin_invites.'.$phpEx.'?mode=explore&amp;'.POST_GROUPS_URL.'='. $users[$i]['invitation_group'],true).'">'. $group.'</a>' : $lang['None']; 

		 
			  

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];         
		
		$template->assign_block_vars('invited', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,                
				'INVITED_NAME' => $user_name,
				'USERLINK' => $user_link, 
				 
				'INVITER_LINK' => $inviter_link,                 
				'INVITED_REGDATE' => $regdate,
				 
				'USED_INVITE_LINK' => $invite_link,
				 
				'JOINED_GROUP_LINK' => $group_link,
							  
		 
				 
			));
	}

}// fine prepare_users_table


/*
Prepares a generic two-column table for the data in the invites explorer (blows ressources, only use in admin)
names: the Values for the left column
values: the Values for the right  column
template_name: the name to use later in pparse
title: a Headline to appear over the Table
title_explain: text under the headline
*/
function prepare_table2(
	$names, 
	$values,
	$template_name, 
	$form_action='', 
	$title= '', 
	$title_explain ='')
{
global $template, $phpEx, $lang, $theme;
	
	$lines = max(count($names), count($values));
	 
	$template->set_filenames(array(
		$template_name => 'admin/invite_gen_tab2.tpl')
	);
	 
	$template->assign_vars(array(             
			'EXPLORE_INVITES_TITLE' => $title,
			'EXPLORE_INVITES_TITLE_EXPLAIN' => $title_explain,
			'L_NAME' => $lang['Name'],
			'L_VALUE' => $lang['Value'],
			'S_FORM_ACTION' => $form_action
			));
	for ($i = 0; $i < $lines; $i++)
	{
		 
	
	$template->assign_block_vars('rows', array(
	
					'ROW_NAME' => $names[$i],
					'ROW_VALUE' => $values[$i]
				));
	}        
	   
}




//this function is dumb - > it won't check the given arguments. But it will split multiple addies.
function send_invite_mail(
	$email_to, 
	$invite_code, 
	$subject, 
	$message, 
	$admin=0) 
{
global $board_config, $lang, $userdata, $user_ip, $phpEx, $db, $phpbb_root_path;
//again, we are preparing the email data
	$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	$script_name = ($script_name != '') ? $script_name . '/profile.'.$phpEx : 'profile.'.$phpEx;
	$server_name = trim($board_config['server_name']);
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';                
		 
	include_once( $phpbb_root_path . 'includes/emailer.'.$phpEx);
	
	$emailer = new emailer($board_config['smtp_delivery']);
			
	$emailer->from($board_config['board_email']);
	if ($board_config['send_invit_confirm_mail'] && $admin === 0)
	{
		$emailer->cc($userdata['user_email']); //a copy for each mail to the sender's addy
	}
	//$emailer->replyto($userdata['user_email']);                    
		$emailer->replyto($board_config['board_email']);
	$email_headers = 'X-AntiAbuse: Board servername - ' . $board_config['server_name'] . "\n";
	$email_headers .= 'X-AntiAbuse: User_id - ' . $userdata['user_id'] . "\n";
	$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
	$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";
	$emailer->extra_headers($email_headers);    
   
	$emailtos = array();
	if (strchr($email_to, ','))
	{    
		$emailtos = explode(',', $email_to) ;
	}
	elseif(strchr($email_to, ';'))
	{
		$emailtos = explode(';', $email_to);
	}
	else
	{
		$emailtos[] = $email_to;
	}
	if (count($emailtos) < 10) //Individual mails only for 10 invites or less.
	{
		foreach($emailtos as $email) //OK this way it will work for servers not allowing bulk mail. Won't work for many addies at once, though.
		{
		
			if (!$admin)
			{
				$emailer->use_template('user_send_invite_email');
			} 
			else
			{
				$emailer->use_template('admin_send_invite_email');
			}
					
				
			$emailer->set_subject($subject);
			$reglink = $server_protocol .  $server_name .  $server_port .  $script_name .'?mode=register';
			$reglink .=  '&email=' . urlencode($email);
			$emailer->assign_vars(array(
				'SITENAME' => $board_config['sitename'], 
				'BOARD_EMAIL' => $board_config['board_email'], 
				'USER' => $userdata['username'],
				'USER_EMAIL' => $userdata['user_email'],
				'MESSAGE' => $message,
			   
				'CODE' => $invite_code,
				
				'REGISTER_LINK' => $reglink .  '&invite=' . $invite_code . "\n"      
			 
			));
			$emailer->email_address($email);
			if ($board_config['send_invit_confirm_pm'] && $admin === 0) //in case there's an error with the mail
			{    
				insert_pm($userdata['user_id'], 
					addslashes($lang['Invitation_sent_body']. "\n" . $lang['Invitation'] . ": $invite_code \n".  $lang['Invitation_sent_email'] . ":  $email_to"),
					addslashes($lang['Invitation_sent_subject']),
					$userdata['user_id']
				); //notify sender
			}        
		$emailer->send();
		$emailer->reset();
		}
	} 
	else 
	{
	 $emailer->extra_headers($email_headers);    
	if (!$admin)
	{
		$emailer->use_template('user_send_invite_email');
	} 
	else
	{
		$emailer->use_template('admin_send_invite_email');
	}
					
			
	$emailer->set_subject($subject);
	$reglink = $server_protocol .  $server_name .  $server_port .  $script_name .'?mode=register';
		
	$emailer->assign_vars(array(
		'SITENAME' => $board_config['sitename'], 
		'BOARD_EMAIL' => $board_config['board_email'], 
		'USER' => $userdata['username'],
		'USER_EMAIL' => $userdata['user_email'],
		'MESSAGE' => $message,
			   
		'CODE' => $invite_code,
				
		'REGISTER_LINK' => $reglink .  '&invite=' . $invite_code . "\n"      
			 
		));
	
	$emailer->email_address($email_to);    
	$emailer->send();
	$emailer->reset(); 
	}
	
	
	
}// fine send_invite_mail




function resend_invite_mail(
	$iid, 
	$email_to, 
	$subject, 
	$message ) 
{
global $board_config,  $userdata, $user_ip, $phpEx, $db;
   
	if (!empty($iid))
	{
			$sql = 'SELECT invitation_code, invitation_email FROM ' . INVITATION_TABLE . '         
				WHERE (invitation_id = '.intval($iid).')';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get invitation  data', '', __LINE__, __FILE__, $sql);
		}
		$invite = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	}
	else
	{
		return false; // no message die here, as it might cause consistency problems
	}
	
	send_invite_mail($email_to, $invite['invitation_code'], $subject, $message, 1) ;
	if (!empty($iid))
	{
		$email_to = str_replace(',',' ,', $email_to);
		$email_to = str_replace(';',' ,', $email_to);
		$sql = 'UPDATE ' . INVITATION_TABLE . '
			SET invitation_email = CONCAT_WS(\'; \', \'invitation_email\', \''.str_replace("\'", "''", $email_to).'\')
			WHERE (invitation_id = '.intval($iid).')';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update invitation  table', '', __LINE__, __FILE__, $sql);
		}

	}
}

 
 
 


/**The insert function for Users and Groups.
*/
function insert_invite(
	$email, 
	$description, 
	$group=0, 
	$auto_activate=0
) 
{
	global $userdata, $db;
	$group = intval($group); //not on my watch...
	$auto_activate = intval($auto_activate);
	if (!empty($group))
	{
		$reduce_invites_sql = "UPDATE " . GROUPS_TABLE . " 
				SET group_invites = group_invites - 1
				WHERE
				(group_id = $group)";
	}
	else
	{
		$reduce_invites_sql = "UPDATE " . USERS_TABLE . ' 
				SET user_invites = user_invites -1
				WHERE
				(user_id = '.$userdata['user_id'].')';
	}
	if( !$result = $db->sql_query($reduce_invites_sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't update/insert into invites table", "", __LINE__, __FILE__, $sql);
	}    
	
	$invite_code = generate_code();
	$test = get_invitation($code);
	while (!empty($test))   //ugly, but I really had an instance of a collision
	{
		$invite_code = generate_code();
		$test = get_invitation($code);
	}
	$email = str_replace(',',' ,', $email); //
	$email = str_replace(';',' ,', $email);
	$sql = "INSERT INTO " . INVITATION_TABLE . " (invitation_code, invitation_description, invitation_email, invitation_sender, invitation_group,  invitation_group_auto_activate )
					VALUES ('$invite_code' , '" . str_replace("\'", "''", $description) . "', '" . str_replace("\'", "''", $email) . "', ".$userdata['user_id'].", $group, $auto_activate)" ;
						
			 
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't update/insert into invites table", "", __LINE__, __FILE__, $sql);
	}         
	 return $invite_code;

}
	

//Removes an user from the invitation tables.
function delete_user_invites($user_id)
{
	global $db;
	$sql = "DELETE FROM " . INVITATION_USER_TABLE . "
				WHERE (user_id = $user_id)";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not delete user invitation', '', __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . INVITATION_TABLE . "
				SET invitation_sender = 0
				WHERE (invitation_sender = $user_id)";
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update user invitation', '', __LINE__, __FILE__, $sql);
	}
			
}

 
/** The main reason for moving this here, is easier upgrades in the future. 
The function overhead is neglible, as this will only get called for user registrations in invitation_only boards.*/
function use_invite(
	$invite, 
	$user_id, 
	$username
)
{
global $db, $emailer, $board_config, $lang, $phpbb_root_path, $phpEx;
 
	if (!empty($invite) ) 
	{  
		 
	  
	 //well, this may cause people to "slip through", but at least we won't get magical unlimited invites
		$invite_sql = 'UPDATE ' . INVITATION_TABLE . ' 
			SET invitation_uses  = invitation_uses - 1 
			WHERE (invitation_id = '.intval($invite['invitation_id']).')
			AND (invitation_uses > 0)';       
		if ( !($result = $db->sql_query($invite_sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update invitation  table', '', __LINE__, __FILE__, $invite_sql);
		}
		//Remember who used this invite
			$invite_user_sql = 'INSERT INTO ' . INVITATION_USER_TABLE . '
				(user_id, invitation_id) 
				VALUES ('.intval($user_id).', '.intval($invite['invitation_id']).')';
								 
								 
		if ( !($result = $db->sql_query($invite_user_sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update invitation user table', '', __LINE__, __FILE__, $invite_user_sql);
		}
		if($board_config['send_invit_accept_pm'] && !empty($invite['invitation_sender']))
		{
			insert_pm(intval($invite['invitation_sender']), 
					  addslashes($lang['Invitation_accepted_body']),
					  addslashes($lang['Invitation_accepted_subject']),
					  intval($user_id)
			); //notify sender
		}
 
		// and auto-join the group, should there be one
		if ($invite['invitation_group'] != 0)
		{
		 
			$find_group_sql = 'SELECT group_id   
				FROM ' . GROUPS_TABLE . ' 
				WHERE (group_id = '.intval($invite['invitation_group']).') 
				AND (group_single_user = 0)';
									
			if (!($result = $db->sql_query($find_group_sql)))
			{
				message_die(GENERAL_ERROR, "Error obtaining group data", "", __LINE__, __FILE__, $invite_group_sql);
			}
			$group_check = $db->sql_fetchrow($result); 
			$db->sql_freeresult($result);
			if (!empty($group_check)) //Is  there exactly one group matching the description - more than one should be impossible anyway
			{    		 
				$invite_group_sql = "INSERT INTO " . USER_GROUP_TABLE . 
					"(user_id, group_id, user_pending)
					VALUES (".intval($user_id) .", ". intval($invite['invitation_group']).", ".intval(!$invite['invitation_group_auto_activate'])." )";    
																 //drop a note to the group moderatoe
				if (!($result_insert = $db->sql_query($invite_group_sql)))
				{             
					message_die(GENERAL_ERROR, "Error updating group data", "", __LINE__, __FILE__, $invite_group_sql);
				}
				if (empty($invite['invitation_group_auto_activate']))
				{
					$group_sql = "SELECT u.user_email, u.username, u.user_lang, g.group_name 
						FROM ".USERS_TABLE . " u, " . GROUPS_TABLE . ' g 
						WHERE (u.user_id = g.group_moderator) 
						AND (g.group_id = '.intval($invite['invitation_group']).')';
					if ( !($group_result = $db->sql_query($group_sql)) )
					{
						message_die(GENERAL_ERROR, "Error getting group moderator data", "", __LINE__, __FILE__, $group_sql);
					}
					$moderator = $db->sql_fetchrow($group_result);   
					$db->sql_freeresult($group_result); 
					if (!class_exists ("emailer"))
					{
					   include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
					}
					$emailer = new emailer($board_config['smtp_delivery']);
							
					$emailer->from($board_config['board_email']);
					$emailer->replyto($board_config['board_email']);
							
					$emailer->use_template('group_request', $moderator['user_lang']);
					$emailer->email_address($moderator['user_email']);
					$emailer->set_subject($lang['Group_request']);
							
					$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
					$script_name = ($script_name != '') ? $script_name . '/groupcp.'.$phpEx : 'groupcp.'.$phpEx;
					$server_name = trim($board_config['server_name']);
					$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
					$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';                
					$grouplink = $server_protocol .  $server_name .  $server_port .  $script_name;    
					$emailer->assign_vars(array(
						'SITENAME' => $board_config['sitename'], 
						'GROUP_MODERATOR' => $moderator['username'],
						'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',                             
						'U_GROUPCP' => $grouplink . '?' . POST_GROUPS_URL . "=".$invite['invitation_group']."&validate=true")
					);
					$emailer->send();
					$emailer->reset();       
								
				} 
				else //activate group membership outright.
				{
					$sql = 'SELECT aa.auth_mod 
						FROM ( ' . GROUPS_TABLE . ' g 
						LEFT JOIN ' . AUTH_ACCESS_TABLE . ' aa ON aa.group_id = g.group_id )
						WHERE g.group_id = '.intval($invite['invitation_group']);
					
					
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not get group information', '', __LINE__, __FILE__, $sql);
					}
					$group_info = $db->sql_fetchrow($result);
					if ($group_info['auth_mod'] )
					{
						$sql = 'UPDATE ' . USERS_TABLE . ' 
							SET user_level = ' . MOD . ' 
							WHERE user_id = ' .  intval($user_id);
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not update user level', '', __LINE__, __FILE__, $sql);
						}
					}
				}
			}  
			return true;
		}
	}
}// fine use_invite




//wgEric's insert_pm function.
function insert_pm(
   $to_id, 
   $message,
   $subject,
   $from_id,
   $html_on = 0,
   $bbcode_on = 1,
   $smilies_on = 0)
{
   global $db, $lang, $user_ip, $board_config, $userdata, $phpbb_root_path, $phpEx;
	include_once("$phpbb_root_path"."includes/bbcode.$phpEx");
	 
	if ( !$from_id )
	{
		$from_id = $userdata['user_id'];
	}

   //get varibles ready
	$to_id = intval($to_id);
	$from_id = intval($from_id);
	$msg_time = time();
	$attach_sig = $userdata['user_attachsig'];
   
	//get to users info
	$sql = "SELECT user_id, user_notify_pm, user_email, user_lang, user_active
		FROM " . USERS_TABLE . "
		WHERE user_id = '$to_id'
		AND user_id <> " . ANONYMOUS;
   if ( !($result = $db->sql_query($sql)) )
	{
		$error = TRUE;
		$error_msg = $lang['No_such_user'];
	}

	$to_userdata = $db->sql_fetchrow($result);

	$privmsg_subject = trim(strip_tags($subject));
	if ( empty($privmsg_subject) )
	{
	  $error = TRUE;
	  $error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_subject'];
	}

	if ( !empty($message) )
	{
		if ( !$error )
		{
			if ( $bbcode_on )
			{
				$bbcode_uid = make_bbcode_uid();
			}

			$privmsg_message = prepare_message($message, $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
			$privmsg_message = str_replace('\\\n', '\n', $privmsg_message);

		}
	}
   else
   {
		$error = TRUE;
		$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_message'];
   }

   //
   // See if recipient is at their inbox limit
   //
	$sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time
		FROM " . PRIVMSGS_TABLE . "
		WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
			OR privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
			OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
		 AND privmsgs_to_userid = " . $to_userdata['user_id'];
   if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_such_user']);
	}

	$sql_priority = ( SQL_LAYER == 'mysql' ) ? 'LOW_PRIORITY' : '';

	if ( $inbox_info = $db->sql_fetchrow($result) )
	{
		if ( $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs'] )
		{
			$sql = "SELECT privmsgs_id FROM " . PRIVMSGS_TABLE . "
					WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
					  OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
					  OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . "  )
					AND privmsgs_date = " . $inbox_info['oldest_post_time'] . "
					AND privmsgs_to_userid = " . $to_userdata['user_id'];
			if ( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not find oldest privmsgs (inbox)', '', __LINE__, __FILE__, $sql);
			}
			$old_privmsgs_id = $db->sql_fetchrow($result);
			$old_privmsgs_id = $old_privmsgs_id['privmsgs_id'];
				
			$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TABLE . "
				WHERE privmsgs_id = $old_privmsgs_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs (inbox)'.$sql, '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TEXT_TABLE . "
				WHERE privmsgs_text_id = $old_privmsgs_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs text (inbox)', '', __LINE__, __FILE__, $sql);
			}
		}
	}

   $sql_info = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig)
				VALUES (" . PRIVMSGS_NEW_MAIL . ", '" . str_replace("\'", "''", $privmsg_subject) . "', " . $from_id . ", " . $to_userdata['user_id'] . ", $msg_time, '$user_ip', $html_on, $bbcode_on, $smilies_on, $attach_sig)";

   if ( !($result = $db->sql_query($sql_info, BEGIN_TRANSACTION)) )
   {
		message_die(GENERAL_ERROR, "Could not insert/update private message sent info.", "", __LINE__, __FILE__, $sql_info);
   }

	$privmsg_sent_id = $db->sql_nextid();

	$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text)
		VALUES ($privmsg_sent_id, '" . $bbcode_uid . "', '" . str_replace("\'", "''", $privmsg_message) . "')";

	if ( !$db->sql_query($sql, END_TRANSACTION) )
	{
		message_die(GENERAL_ERROR, "Could not insert/update private message sent text.", "", __LINE__, __FILE__, $sql);
	}

   //
   // Add to the users new pm counter
   //
	$sql = "UPDATE " . USERS_TABLE . "
		SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = " . time() . " 
		WHERE user_id = " . $to_userdata['user_id'];
	if ( !$status = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not update private message new/read status for user', '', __LINE__, __FILE__, $sql);
	}

	return;
   
  

} // insert_pm()



?>