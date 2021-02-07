##############################################################
## MOD Title: Visual Confirmation for Guests
## MOD Author: Kanuck < aaron@kanuck.net > (Aaron Adams) http://kanuck.net/
## MOD Description: Adds visual confirmation for guest posts, eliminating spam.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: posting.php, templates/subSilver/posting_body.tpl
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: None
##
##############################################################
## MOD History:
##
##   2005-02-18 - Version 1.0.1
##      - It works now. No more parse errors.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#

posting.php

#
#-----[ FIND ]------------------------------------------
#

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
 
#
#-----[ AFTER, ADD ]------------------------------------------
#

/*

	png visual confirmation system : (c) phpBB Group, 2003 : All Rights Reserved

*/

#
#-----[ FIND ]------------------------------------------
#

		case 'editpost':
		case 'newtopic':
		case 'reply':
		
#
#-----[ AFTER, ADD ]------------------------------------------
#

			if ( $board_config['enable_confirm'] && !$userdata['session_logged_in'] )
			{
				if ( empty($HTTP_POST_VARS['confirm_id']) || empty($HTTP_POST_VARS['confirm_code']) )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
				}
				else
				{
					$confirm_id = htmlspecialchars($HTTP_POST_VARS['confirm_id']);
					if (!preg_match('/^[A-Za-z0-9]+$/', $confirm_id))
					{
						$confirm_id = '';
					}
					
					$sql = 'SELECT code 
						FROM ' . CONFIRM_TABLE . " 
						WHERE confirm_id = '$confirm_id' 
							AND session_id = '" . $userdata['session_id'] . "'";
					if (!($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, 'Could not obtain confirmation code', __LINE__, __FILE__, $sql);
					}
		
					if ($row = $db->sql_fetchrow($result))
					{
						if ($row['code'] != $HTTP_POST_VARS['confirm_code'])
						{
							$error = TRUE;
							$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
						}
						else
						{
							$sql = 'DELETE FROM ' . CONFIRM_TABLE . " 
								WHERE confirm_id = '$confirm_id' 
									AND session_id = '" . $userdata['session_id'] . "'";
							if (!$db->sql_query($sql))
							{
								message_die(GENERAL_ERROR, 'Could not delete confirmation code', __LINE__, __FILE__, $sql);
							}
						}
					}
					else
					{		
						$error = TRUE;
						$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
					}
					$db->sql_freeresult($result);
				}
			}

#
#-----[ FIND ]------------------------------------------
#

// Generate smilies listing for page output
generate_smilies('inline', PAGE_POSTING);

#
#-----[ BEFORE, ADD ]------------------------------------------
#

//
// Visual confirmation for guests
//
$confirm_image = '';
if( !$userdata['session_logged_in'] && (!empty($board_config['enable_confirm'])) )
{
	$sql = 'SELECT session_id 
		FROM ' . SESSIONS_TABLE; 
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not select session data', '', __LINE__, __FILE__, $sql);
	}
	
	if ($row = $db->sql_fetchrow($result))
	{
		$confirm_sql = '';
		do
		{
			$confirm_sql .= (($confirm_sql != '') ? ', ' : '') . "'" . $row['session_id'] . "'";
		}
		while ($row = $db->sql_fetchrow($result));
	
		$sql = 'DELETE FROM ' .  CONFIRM_TABLE . " 
			WHERE session_id NOT IN ($confirm_sql)";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete stale confirm data', '', __LINE__, __FILE__, $sql);
		}
	}
	$db->sql_freeresult($result);
	
	$confirm_chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	
	list($usec, $sec) = explode(' ', microtime()); 
	mt_srand($sec * $usec); 
	
	$max_chars = count($confirm_chars) - 1;
	$code = '';
	for ($i = 0; $i < 6; $i++)
	{
		$code .= $confirm_chars[mt_rand(0, $max_chars)];
	}
	
	$confirm_id = md5(uniqid($user_ip));
	
	$sql = 'INSERT INTO ' . CONFIRM_TABLE . " (confirm_id, session_id, code) 
		VALUES ('$confirm_id', '". $userdata['session_id'] . "', '$code')";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not insert new confirm code information', '', __LINE__, __FILE__, $sql);
	}
	
	unset($code);
	
	$confirm_image = (@extension_loaded('zlib')) ? '<img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id") . '" alt="" title="" />' : '<img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=1") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=2") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=3") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=4") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=5") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=6") . '" alt="" title="" />';
	$hidden_form_fields .= '<input type="hidden" name="confirm_id" value="' . $confirm_id . '" />';
	
	$template->assign_block_vars('switch_confirm', array());
}

#
#-----[ FIND ]------------------------------------------
#

	'SMILIES_STATUS' => $smilies_status, 

#
#-----[ AFTER, ADD ]------------------------------------------
#

	'CONFIRM_IMG' => $confirm_image,
	
#
#-----[ FIND ]------------------------------------------
#

	'L_DELETE_POST' => $lang['Delete_post'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

	'L_CONFIRM_CODE_IMPAIRED'	=> sprintf($lang['Confirm_code_impaired'], '<a href="mailto:' . $board_config['board_email'] . '">', '</a>'),
	'L_CONFIRM_CODE' => $lang['Confirm_code'],
	'L_CONFIRM_CODE_EXPLAIN' => $lang['Confirm_code_explain'],

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#

	{POLLBOX}

#
#-----[ AFTER, ADD ]------------------------------------------
#

	<!-- Visual Confirmation -->
	<!-- BEGIN switch_confirm -->
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gensmall">{L_CONFIRM_CODE_IMPAIRED}</span><br /><br />{CONFIRM_IMG}<br /><br /></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_CODE}: * </span><br /><span class="gensmall">{L_CONFIRM_CODE_EXPLAIN}</span></td>
	  <td class="row2"><input type="text" class="post" style="width: 200px" name="confirm_code" size="6" maxlength="6" value="" /></td>
	</tr>
	<!-- END switch_confirm -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
