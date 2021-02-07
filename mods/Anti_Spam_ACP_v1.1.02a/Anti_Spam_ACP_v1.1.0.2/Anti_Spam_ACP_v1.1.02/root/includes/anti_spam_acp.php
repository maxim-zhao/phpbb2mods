<?php
/***************************************************************************
 *                               functions_anti_spam_acp.php
 * 			 -------------------
 *   date		: Wednesday, September 6, 2006
 *   copyright	: (C) 2006 EXreaction
 *   email		: exreaction@lithiumstudios.org
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
 *
 ***************************************************************************/

/*
* ignore
*/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

/*
* Do the template switches...
*/
if ( ($userdata['user_level'] == ADMIN) || ($userdata['user_level'] == MOD) )
{
	$template->assign_block_vars('switch_edit_all', array());
	$template->assign_block_vars('switch_edit_icq', array());
	$template->assign_block_vars('switch_edit_aim', array());

	$template->assign_block_vars('switch_edit_msn', array());
	$template->assign_block_vars('switch_edit_yim', array());
	$template->assign_block_vars('switch_edit_web', array());
	$template->assign_block_vars('switch_edit_loc', array());
	$template->assign_block_vars('switch_edit_occ', array());
	$template->assign_block_vars('switch_edit_int', array());
	$template->assign_block_vars('switch_edit_sig', array());
}
elseif ($mode == 'editprofile')
{
	$atleast_one_on = false;

	if ( ($board_config['as_acp_icq'] == 'on') || ($board_config['as_acp_icq'] == 'reg off') || ( ($board_config['as_acp_icq'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_icq_post']) ) ) 
	{
		$template->assign_block_vars('switch_edit_icq', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_aim'] == 'on') || ($board_config['as_acp_aim'] == 'reg off') || ( ($board_config['as_acp_aim'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_aim_post']) ) )
	{
		$template->assign_block_vars('switch_edit_aim', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_msn'] == 'on') || ($board_config['as_acp_msn'] == 'reg off') || ( ($board_config['as_acp_msn'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_msn_post']) ) )
	{
		$template->assign_block_vars('switch_edit_msn', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_yim'] == 'on') || ($board_config['as_acp_yim'] == 'reg off') || ( ($board_config['as_acp_yim'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_yim_post']) ) )
	{
		$template->assign_block_vars('switch_edit_yim', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_web'] == 'on') || ($board_config['as_acp_web'] == 'reg off') || ( ($board_config['as_acp_web'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_web_post']) ) )
	{
		$template->assign_block_vars('switch_edit_web', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_loc'] == 'on') || ($board_config['as_acp_loc'] == 'reg off') || ( ($board_config['as_acp_loc'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_loc_post']) ) )
	{
		$template->assign_block_vars('switch_edit_loc', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_occ'] == 'on') || ($board_config['as_acp_occ'] == 'reg off') || ( ($board_config['as_acp_occ'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_occ_post']) ) )
	{
		$template->assign_block_vars('switch_edit_occ', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_int'] == 'on') || ($board_config['as_acp_int'] == 'reg off') || ( ($board_config['as_acp_int'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_int_post']) ) )
	{
		$template->assign_block_vars('switch_edit_int', array());
		$atleast_one_on = true;
	}
	if ( ($board_config['as_acp_sig'] == 'on') || ($board_config['as_acp_sig'] == 'reg off') || ( ($board_config['as_acp_sig'] == 'post count') && ($userdata['user_posts'] >= $board_config['as_acp_sig_post']) ) )
	{
		$template->assign_block_vars('switch_edit_sig', array());
		$atleast_one_on = true;
	}

	if ($atleast_one_on)
	{
		$template->assign_block_vars('switch_edit_all', array());
	}
}
elseif ($mode == 'register')
{
	$atleast_one_on = false;

	if ($board_config['as_acp_icq'] == 'on') 
	{
		$template->assign_block_vars('switch_edit_icq', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_aim'] == 'on')
	{
		$template->assign_block_vars('switch_edit_aim', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_msn'] == 'on')
	{
		$template->assign_block_vars('switch_edit_msn', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_yim'] == 'on')
	{
		$template->assign_block_vars('switch_edit_yim', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_web'] == 'on')
	{
		$template->assign_block_vars('switch_edit_web', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_loc'] == 'on')
	{
		$template->assign_block_vars('switch_edit_loc', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_occ'] == 'on')
	{
		$template->assign_block_vars('switch_edit_occ', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_int'] == 'on')
	{
		$template->assign_block_vars('switch_edit_int', array());
		$atleast_one_on = true;
	}
	if ($board_config['as_acp_sig'] == 'on')
	{
		$template->assign_block_vars('switch_edit_sig', array());
		$atleast_one_on = true;
	}

	if ($atleast_one_on)
	{
		$template->assign_block_vars('switch_edit_all', array());
	}
}

/*
* check if someone has attempted to spam
* if they have, send the email if wanted and give them a die message...
*/
if ( ( ($mode == 'register') || ($mode=='editprofile') ) && ($userdata['user_level'] != ADMIN) && ($userdata['user_level'] != MOD) )
{	
	$spam = false;

 	if ($mode == 'register')
	{
		if		( ($HTTP_POST_VARS['icq'] != '')		&&	($board_config['as_acp_icq'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['aim'] != '')		&&	($board_config['as_acp_aim'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['msn'] != '')		&&	($board_config['as_acp_msn'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['yim'] != '')		&&	($board_config['as_acp_aim'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['website'] != '')	&&	($board_config['as_acp_web'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['location'] != '')	&&	($board_config['as_acp_loc'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['occupation'] != '')	&&	($board_config['as_acp_occ'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['interests'] != '')	&&	($board_config['as_acp_int'] != 'on') )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['signature'] != '')	&&	($board_config['as_acp_sig'] != 'on') )	{$spam=true;}
	}
	else if ($mode == 'editprofile')
	{
		if		( ($HTTP_POST_VARS['icq'] != '')		&&	( ($board_config['as_acp_icq'] == 'off') || ( ($board_config['as_acp_icq'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_icq_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['aim'] != '')		&&	( ($board_config['as_acp_aim'] == 'off') || ( ($board_config['as_acp_aim'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_aim_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['msn'] != '')		&&	( ($board_config['as_acp_msn'] == 'off') || ( ($board_config['as_acp_msn'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_msn_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['yim'] != '')		&&	( ($board_config['as_acp_yim'] == 'off') || ( ($board_config['as_acp_yim'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_yim_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['website'] != '')	&&	( ($board_config['as_acp_web'] == 'off') || ( ($board_config['as_acp_web'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_web_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['location'] != '')	&&	( ($board_config['as_acp_loc'] == 'off') || ( ($board_config['as_acp_loc'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_loc_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['occupation'] != '')	&&	( ($board_config['as_acp_occ'] == 'off') || ( ($board_config['as_acp_occ'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_occ_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['interests'] != '')	&&	( ($board_config['as_acp_int'] == 'off') || ( ($board_config['as_acp_int'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_int_post']) ) ) )	{$spam=true;}
		else if ( ($HTTP_POST_VARS['signature'] != '')	&&	( ($board_config['as_acp_sig'] == 'off') || ( ($board_config['as_acp_sig'] == 'post count') && ($userdata['user_posts'] < $board_config['as_acp_sig_post']) ) ) )	{$spam=true;}
	}

	if ($spam == true)
	{
		if ($board_config['as_acp_notify_on_spam'] == '1')
		{
			include($phpbb_root_path . 'includes/emailer.' . $phpEx);

			$triggers ='';

			if ($HTTP_POST_VARS['icq'] != '')			$triggers .= $lang['ICQ'] . ': ' . $HTTP_POST_VARS['icq'] . "\r\n";
			if ($HTTP_POST_VARS['aim'] != '')			$triggers .= $lang['AIM'] . ': ' . $HTTP_POST_VARS['aim'] . "\r\n";
			if ($HTTP_POST_VARS['msn'] != '')			$triggers .= $lang['MSNM'] . ': ' . $HTTP_POST_VARS['msn'] . "\r\n";
			if ($HTTP_POST_VARS['yim'] != '')			$triggers .= $lang['YIM'] . ': ' . $HTTP_POST_VARS['yim'] . "\r\n";
			if ($HTTP_POST_VARS['website'] != '')		$triggers .= $lang['Website'] . ': ' . $HTTP_POST_VARS['website'] . "\r\n";
			if ($HTTP_POST_VARS['location'] != '')		$triggers .= $lang['Location'] . ': ' . $HTTP_POST_VARS['location'] . "\r\n";
			if ($HTTP_POST_VARS['occupation'] != '')	$triggers .= $lang['Occupation'] . ': ' . $HTTP_POST_VARS['occupation'] . "\r\n";
			if ($HTTP_POST_VARS['interests'] != '')		$triggers .= $lang['Interests'] . ': ' . $HTTP_POST_VARS['interests'] . "\r\n";
			if ($HTTP_POST_VARS['signature'] != '')		$triggers .= $lang['Signature'] . ': ' . $HTTP_POST_VARS['signature'] . "\r\n";

			$emailer = new emailer($board_config['smtp_delivery']);
			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);
			$emailer->use_template('admin_spam_notification');
			$emailer->email_address($board_config['as_acp_email_for_spam']);
			$emailer->set_subject($lang['Spam_Bot_Attempt'] . $board_config['sitename']);

			$emailer->assign_vars(array(
				'NOTICE'		=> sprintf($lang['Not_Test_Email_Header'], ($mode == 'register') ? $lang['Registering'] : $lang['Editing_Profile']),
				'SITENAME'		=> $board_config['sitename'], 
				'USERNAME'		=> $HTTP_POST_VARS['username'],
				'IP'			=> $client_ip,
				'PASSWORD'		=> ($mode == 'register') ? $HTTP_POST_VARS['new_password'] : $lang['Not_Available'],
				'EMAIL'			=> $HTTP_POST_VARS['email'],
				'TRIGGERS'		=> stripslashes($triggers)
			));

			$emailer->send();
			$emailer->reset();
		}

		$num_bots = $board_config['as_acp_bots_stopped'] + 1;
		$sql = "UPDATE " . CONFIG_TABLE . " SET
			config_value = $num_bots
			WHERE config_name = 'as_acp_bots_stopped'";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to update config for spam bot count.");
		}
		
		if ($board_config['as_acp_show_email_on_die'] == 1)	
		{
			$email_die = sprintf($lang['Spam_Bot_Yes'], $board_config['as_acp_email_for_spam']);
		}
		else
		{
			$email_die = $lang['Spam_Bot_No'];
		}

		message_die(GENERAL_MESSAGE, $email_die);
	}
}
?>