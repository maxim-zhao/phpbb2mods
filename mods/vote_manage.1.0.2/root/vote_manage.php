<?php
/***************************************************************************
 *								vote_manage.php
 *							-------------------
 *   begin				: Thursday, Dec 22, 2005
 *   copyright			: (C) 2005 Gordon Myers
 *   email				: soapergem@gmail.com
 *
 *   $Id: vote_manage.php,v 1.0.0 2005/12/22 17:59:10 soapergem Exp $
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
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//


//
// Check and set various parameters
//
$endl = '
';			//	used for the export
$action = ( strlen($HTTP_GET_VARS['action']) ) ? $HTTP_GET_VARS['action'] : false;
$user_id = ( strlen($HTTP_GET_VARS['user_id']) ) ? intval($HTTP_GET_VARS['user_id']) : false;
$vote_id = ( strlen($HTTP_GET_VARS['vote_id']) ) ? intval($HTTP_GET_VARS['vote_id']) : false;
$confirm = isset($HTTP_POST_VARS['confirm']) ? true : false;
$cancel = isset($HTTP_POST_VARS['cancel']) ? true : false;

if ( $vote_id )
{
	$sql = "SELECT vd.topic_id, vd.vote_undo, vd.vote_text, vd.vote_start, 
		vd.vote_length, vd.vote_hide, tt.topic_title, vd.vote_max, tt.forum_id 
		FROM " . VOTE_DESC_TABLE . " vd, " . TOPICS_TABLE . " tt 
		WHERE vd.topic_id = tt.topic_id AND vd.vote_id = $vote_id";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
	}
	if ( $rowset = $db->sql_fetchrowset($result) )
	{
		$auth_undo = ( $rowset[0]['vote_undo'] ) ? true : false;
		$forum_id = $rowset[0]['forum_id'];
		$poll_subj = $rowset[0]['vote_text'];
		$topic_id = $rowset[0]['topic_id'];
		$topic_subj = $rowset[0]['topic_title'];
		$vote_max = $rowset[0]['vote_max'];
		$timeok = ( !$rowset[0]['vote_length'] || ($rowset[0]['vote_start'] + $rowset[0]['vote_length'] > time()) ) ? true : false;
		$hide_vote = ( ($rowset[0]['vote_hide'] && $rowset[0]['vote_hide'] < 4) || ($rowset[0]['vote_hide'] > 3 && $timeok) ) ? true : false;
		//	Is user an admin or a moderator of this particular poll?
		if ( $userdata['user_level'] == ADMIN )
		{
			$auth_mod = true;
		}
		else if ( $userdata['user_level'] == MOD )
		{
			$sql = "SELECT ug.user_id 
				FROM " . AUTH_ACCESS_TABLE . " aa, 
				" . USER_GROUP_TABLE . " ug WHERE 
				aa.auth_mod = " . TRUE . " AND 
				aa.group_id = ug.group_id AND 
				aa.forum_id = $forum_id AND 
				ug.user_id = " . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not obtain user permissions", '', __LINE__, __FILE__, $sql);
			}
			$auth_mod = ( $db->sql_numrows() ) ? true : false;
		}
		else
		{
			$auth_mod = false;
		}
	}
	else
	{
		$auth_mod = ( $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD ) ? true : false;
		$auth_undo = false;
		$poll_subj = false;
		$timeok = false;
		$topic_subj = false;
		$topic_id = false;
		$hide_vote = true;
	}
}
else
{	
	$auth_mod = ( $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD ) ? true : false;
	$auth_undo = false;
	$poll_subj = false;
	$timeok = false;
	$topic_subj = false;
	$topic_id = false;
	$hide_vote = true;
}

//------------------------

if ( !$vote_id )	//	Select a poll
{
	$poll_subj_array = array();
	$topic_subj_array = array();
	$sql = "SELECT * FROM " . VOTE_DESC_TABLE . "
		ORDER BY vote_id DESC";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		do
		{
			$poll_subj_array[$row['vote_id']] = $row['vote_text'];
			
			$sql = "SELECT topic_title FROM " . TOPICS_TABLE . "
				WHERE topic_id = " . $row['topic_id'];
			if( !($result2 = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
			}
			$rowset2 = $db->sql_fetchrowset($result2);
			$topic_subj_array[$row['vote_id']] = $rowset2[0]['topic_title'];
			$db->sql_freeresult($result2);
		}
		while ( $row = $db->sql_fetchrow($result) );
		$db->sql_freeresult($result);
	}
	
	$template->set_filenames(array(
		'body' => 'vote_manage_select.tpl')
	);
	
	$page_title = 'Select a poll';
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);
	
	$template->assign_vars(array(
		'L_SUBMIT' => $lang['Submit'],
		'S_VOTE_ACTION' => append_sid("vote_manage.$phpEx"))
	);
	
	foreach ($topic_subj_array as $key => $val)
	{
		$template->assign_block_vars('topic_subj', array(
			'KEY' => $key,
			'VAL' => $val)
		);
	}
	foreach ($poll_subj_array as $key => $val)
	{
		$template->assign_block_vars('poll_subj', array(
			'KEY' => $key,
			'VAL' => $val)
		);
	}
}
else	//	Vote ID is set
{
	switch ($action)
	{
		case 'export':		//	Export as CSV (comma separated-values) File
			if ( $hide_vote && !$auth_mod )
			{
				message_die(GENERAL_ERROR, $lang['Poll_hidden']);
			}
			else
			{
				$options_text = array();
				$user_options = array();
				$users = array();
				$error_too_early = false;
				
				$sql = "SELECT vote_option_id, vote_option_text FROM " . VOTE_RESULTS_TABLE . "
					WHERE vote_id = $vote_id";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
				}
				if ( $row = $db->sql_fetchrow($result) )
				{
					do
					{
						$options_text[$row['vote_option_id']] = $row['vote_option_text'];
					}
					while ( $row = $db->sql_fetchrow($result) );
					$db->sql_freeresult($result);
				}
	
				$sql = "SELECT vote_user_id, vote_option_id FROM " . VOTE_USERS_TABLE . "
					WHERE vote_id = $vote_id";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
				}
				if ( $row = $db->sql_fetchrow($result) )
				{
					do
					{
						if ( $row['vote_option_id'] == -1 )
						{
							$error_too_early = true;
							break;
						}
						$user_options[$row['vote_user_id']][$row['vote_option_id']] = 1;
						
						$sql = "SELECT username FROM " . USERS_TABLE . "
							WHERE user_id = " . $row['vote_user_id'];
						if( !($result2 = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
						}
						if ( $rowset = $db->sql_fetchrowset($result2) )
						{
							$users[$row['vote_user_id']] = $rowset[0]['username'];
						}
						$db->sql_freeresult($result2);
					}
					while ( $row = $db->sql_fetchrow($result) );
					$db->sql_freeresult($result);
				}
				
				if ( $error_too_early )
				{
					message_die(GENERAL_ERROR, $lang['Error_poll_early']);
				}
				
				$options_count = count($options_text);
				ksort($options_text);
				
				//	BEGIN OUTPUT
				header("Content-Type: text/x-delimtext; name=\"poll_result_$vote_id.csv\"");
				header("Content-disposition: attachment; filename=poll_result_$vote_id.csv");
				
				echo $lang['Username'];
				for ($i = 1; $i <= $options_count; $i++)
				{
					echo ',' . $options_text[$i];
				}
				echo $endl;
	
				natcasesort($users);
				foreach ($users as $id => $name)
				{
					echo $name;
					for ($i = 1; $i <= $options_count; $i++)
					{
						echo ',';
						echo ( $user_options[$id][$i] ) ? $lang['Csv_vote'] : $lang['Csv_novote'];
					}
					echo $endl;
				}
				
				exit;
			}
			break;
		
		case 'undo':		//	Remove a user's votes
			if ( !$user_id )
			{
				message_die(GENERAL_ERROR, 'No user specified.');
			}
			else
			{
				if ( ( ($userdata['user_id'] == $user_id) && $timeok ) || $auth_mod )
				{
					$options = array();
					$error_too_early = false;
					
					$sql = "SELECT vote_option_id FROM " . VOTE_USERS_TABLE . "
						WHERE vote_id = $vote_id AND vote_user_id = $user_id";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
					}
					if ( !$db->sql_numrows() )
					{
						message_die(GENERAL_ERROR, $lang['Undo_no_votes']);
					}
					if ( $row = $db->sql_fetchrow($result) )
					{
						do
						{
							if ( $row['vote_option_id'] == -1 )
							{
								$error_too_early = true;
								break;
							}
							$options[$row['vote_option_id']] = 1;
						}
						while ( $row = $db->sql_fetchrow($result) );
						$db->sql_freeresult($result);
					}
					
					if ( $error_too_early )
					{
						message_die(GENERAL_ERROR, $lang['Error_poll_early']);
					}

					if ( $confirm )
					{
						$sql = "UPDATE " . VOTE_DESC_TABLE . " SET 
							vote_voted = vote_voted - 1 WHERE
							vote_id = $vote_id";
						if (!$db->sql_query($sql, BEGIN_TRANSACTION))
						{
							message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
						}
						foreach ($options as $key => $val)
						{
							$sql = "UPDATE " . VOTE_RESULTS_TABLE . " SET 
								vote_result = vote_result - 1 WHERE 
								vote_id = $vote_id AND vote_option_id = $key";
							if (!$db->sql_query($sql, BEGIN_TRANSACTION))
							{
								message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
							}
						}
						$sql = "DELETE FROM " . VOTE_USERS_TABLE . " WHERE
							vote_id = $vote_id AND vote_user_id = $user_id";
						if (!$db->sql_query($sql, END_TRANSACTION))
						{
							message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
						}
						
						$page_title = $lang['Votes_removed'];
						include($phpbb_root_path . 'includes/page_header.'.$phpEx);
						
						$template->set_filenames(array(
							'body' => 'message_body.tpl')
						);
						$template->assign_vars(array(
							'MESSAGE_TITLE' => $lang['Votes_removed'],
							'MESSAGE_TEXT' => sprintf($lang['Poll_return'], '<a href="'.append_sid("vote_manage.$phpEx?vote_id=$vote_id").'">', '</a>'))
						);
					}
					else if ( $cancel )
					{
						redirect(append_sid("vote_manage.$phpEx?vote_id=$vote_id",true));
					}
					else
					{
						$template->set_filenames(array(
							'body' => 'confirm_delete.tpl')
						);
						
						$page_title = $lang['Remove_votes'];
						include($phpbb_root_path . 'includes/page_header.'.$phpEx);
						
						$sql = "SELECT username FROM " . USERS_TABLE . "
							WHERE user_id = $user_id";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not query user information', '', __LINE__, __FILE__, $sql);
						}
						if ( $rowset = $db->sql_fetchrowset($result) )
						{
							$user_name = $rowset[0]['username'];
						}
						$db->sql_freeresult($result);
						
						foreach ($options as $key => $val)
						{
							$sql = "SELECT vote_option_text FROM " . VOTE_RESULTS_TABLE . "
								WHERE vote_id = $vote_id AND vote_option_id = $key";
							if( !($result = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Could not query user information', '', __LINE__, __FILE__, $sql);
							}
							if ( $rowset = $db->sql_fetchrowset($result) )
							{
								$options[$key] = $rowset[0]['vote_option_text'];
							}
							$db->sql_freeresult($result);
						}
						
						natcasesort($options);
						foreach ($options as $val)
						{
							$template->assign_block_vars('options', array(
								'OPTION' => $val)
							);
						}
						
						$template->assign_vars(array(
							'MESSAGE_TITLE' => $lang['Remove_votes'],
							'USERNAME' => $user_name,
							'L_NO' => $lang['No'],
							'L_YES' => $lang['Yes'],
	
							'S_HIDDEN_FIELDS' => '',
							'S_CONFIRM_ACTION' => append_sid("vote_manage.$phpEx?vote_id=$vote_id&amp;action=undo&amp;user_id=$user_id"))
						);
					}
				}
				else
				{
					message_die(GENERAL_ERROR, $lang['Not_Authorised']);
				}
			}
			break;
		
		default:		//	Display detailed poll results
			if ( $hide_vote && !$auth_mod )
			{
				message_die(GENERAL_ERROR, $lang['Poll_hidden']);
			}
			else
			{
				$users = array();
				$options = array();
				$options2 = array();
				$options_text = array();
				$should_be = array();
				$error_too_early = false;
			
				$sql = "SELECT * FROM " . VOTE_USERS_TABLE . "
					WHERE vote_id = $vote_id";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
				}
				if ( $row = $db->sql_fetchrow($result) )
				{
					do
					{
						if ( $row['vote_option_id'] == -1 )
						{
							$error_too_early = true;
							break;
						}
						$users[$row['vote_user_id']] = 1;
						$options_check[$row['vote_option_id']] = 1;
						
						$options[$row['vote_option_id']][$row['vote_user_id']] = 1;
						$options2[$row['vote_user_id']][$row['vote_option_id']] = 1;
					}
					while ( $row = $db->sql_fetchrow($result) );
					$db->sql_freeresult($result);
				}
				if ( $error_too_early )
				{
					message_die(GENERAL_ERROR, 'Early_poll');
				}
			
				$sql = "SELECT * FROM " . VOTE_RESULTS_TABLE . "
					WHERE vote_id = $vote_id";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
				}
				if ( $row = $db->sql_fetchrow($result) )
				{
					do
					{
						$should_be[$row['vote_option_id']] = $row['vote_result'];
					}
					while ( $row = $db->sql_fetchrow($result) );
					$db->sql_freeresult($result);
				}
			
				foreach ($users as $key => $val)
				{
					$sql = "SELECT username FROM " . USERS_TABLE . "
						WHERE user_id = $key";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
					}
					$rowset = $db->sql_fetchrowset($result);
					$users[$key] = $rowset[0]['username'];
					$db->sql_freeresult($result);
				}
				$sql = "SELECT vote_option_id, vote_option_text FROM " . VOTE_RESULTS_TABLE . "
					WHERE vote_id = $vote_id";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Error_poll_query', '', __LINE__, __FILE__, $sql);
				}
				$options_count = 0;
				if ( $row = $db->sql_fetchrow($result) )
				{
					do
					{
						$options_text[$row['vote_option_id']] = $row['vote_option_text'];
						$options_count++;
					}
					while ( $row = $db->sql_fetchrow($result) );
					$db->sql_freeresult($result);
				}
				
				//	Start output
				$template->set_filenames(array(
					'body' => 'vote_manage_body.tpl')
				);
				
				$page_title = $lang['Detailed_results'];
				include($phpbb_root_path . 'includes/page_header.'.$phpEx);
				
				if ( !$auth_mod )
				{
					if ( $timeok && !$auth_undo )
					{
						$undo_display = '<p class="genmed" align="center"><b>'.$lang['Poll_no_undo'].'</b></p>';
					}
					else if ( !$timeok )
					{
						$undo_display = '<p class="genmed" align="center"><b>'.$lang['Poll_expiredyes'].'</b></p>';
					}
				}
				else
				{
					$undo_display = '';
				}
			
				$template->assign_vars(array(
					'L_SORT_BY_OPTION' => $lang['Sort_by_option'],
					'L_SORT_BY_USER' => $lang['Sort_by_user'],
					'AUTH_UNDO' => $undo_display,
					
					'L_EXPORT' => $lang['Export_csv'],
					'VOTE_ID' => $vote_id,
					'S_VOTE_ACTION' => append_sid("vote_manage.$phpEx?vote_id=$vote_id"))
				);
				
				//	Left-pane
				for ($i = 1; $i <= $options_count; $i++)
				{
					$template->assign_block_vars('options_sort', array(
						'OPTION' => $options_text[$i],
						'RESULT' => $should_be[$i],
						'STYLE' => ( $options_check[$i] ) ? 'decimal' : 'none')
					);
					if ( $options_check[$i] )
					{
						foreach ($options[$i] as $key => $val)
						{
							$options[$i][$key] = $users[$key];
						}
						natcasesort($options[$i]);
						
						foreach ($options[$i] as $key => $val)
						{
							$template->assign_block_vars('options_sort.options_users', array(
								'USERNAME' => $users[$key],
								'U_USER' => append_sid("profile.$phpEx?mode=viewprofile&amp;u=$key"))
							);
						}
					}
					else
					{
						$template->assign_block_vars('options_sort.switch_novote', array(
							'L_NOVOTES' => $lang['No_votes'])
						);
					}
				}

				//	Right-pane
				natcasesort($users);
				foreach ($users as $userid => $username)
				{
					$template->assign_block_vars('users_sort', array(
						'COUNT' => ( $vote_max == 1 ) ? '' : '('.count($options2[$userid]).')',
						'ULOL' => ( $vote_max == 1 ) ? 'ul' : 'ol',
						'USER' => $username,
						'STYLE' => ( $vote_max == 1 ) ? 'circle' : 'decimal',
						'U_USER' => append_sid("profile.$phpEx?mode=viewprofile&amp;u=$userid"))
					);
					
					if ( ( ($userdata['user_id'] == $userid) && $auth_undo && $timeok ) || $auth_mod )
					{
						$template->assign_block_vars('users_sort.switch_undo', array(
							'L_UNDO' => $lang['Undo_vote'],
							'U_UNDO' => append_sid("vote_manage.$phpEx?vote_id=$vote_id&amp;action=undo&amp;user_id=$userid"))
						);
					}
					
					ksort($options2[$userid]);

					foreach ($options2[$userid] as $key => $val)
					{
						$template->assign_block_vars('users_sort.users_options', array(
							'OPTION' => $options_text[$key])
						);
					}
				}
			}
			break;
	}
}

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>