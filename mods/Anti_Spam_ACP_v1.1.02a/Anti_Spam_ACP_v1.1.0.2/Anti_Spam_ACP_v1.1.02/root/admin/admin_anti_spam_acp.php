<?php
/***************************************************************************
 *                               admin_anti_spam_acp.php
 *			-------------------
 *   date		: Wednesday, October 4, 2006
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

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
   $filename = basename(__FILE__);
   $module['Anti_Spam']['Anti_Spam_ACP'] = $filename;

   return;
}

global $board_config, $phpEx;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

function num_check($num)
{
	if ( ($num >= 1) && ($num <= 9999) )
	{
		return(true);
	}
	else
	{
		return(false);
	}
}

// Check for new version
if ($board_config['as_acp_check_version'] == '1')
{
	$errno = 0;
	$errstr = $version_info = '';

	if ($fsock = @fsockopen('www.lithiumstudios.org', 80, $errno, $errstr, 10))
	{
		@fputs($fsock, "GET /updatecheck/anti_spam_acp_version.txt HTTP/1.1\r\n");
		@fputs($fsock, "HOST: www.lithiumstudios.org\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$version .= @fread($fsock, 1024);
			}
			else
			{
				if (@fgets($fsock, 1024) == "\r\n")
				{
					$get_info = true;
				}
			}
		}
		@fclose($fsock);

		$version = explode("\n", $version);
		$version = implode(".", $version);

		if ($version == $board_config['as_acp_version'])
		{
			$version_info = '<p style="color:green">' . $lang['AS_ACP_up_to_date'] . '</p>';
		}
		else
		{
			$version_info = '<p style="color:red">' . $lang['AS_ACP_not_up_to_date'];
			$version_info .= '<br />' . sprintf($lang['AS_ACP_Latest_Version'], $version) . ' ' . sprintf($lang['AS_ACP_Current_Version'], $board_config['as_acp_version']) . '</p>';
		}
	}
	else
	{
		if ($errstr)
		{
			$version_info = '<p style="color:red">' . sprintf($lang['Connect_socket_error'], $errstr) . '</p>';
		}
		else
		{
			$version_info = '<p>' . $lang['Socket_functions_disabled'] . '</p>';
		}
	}
}
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
}
else
{
	$error = false;
	
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if( isset($HTTP_POST_VARS['submit']) || isset($HTTP_POST_VARS['test_mail']) )
		{
			// Check for illegal data and report if there is an error
			//if not legal get old data from board config
			if ( ($config_name == 'as_acp_icq_post') && (num_check($new['as_acp_icq_post']) == false) )
			{
				$error = true;
				$new['as_acp_icq_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_aim_post') && (num_check($new['as_acp_aim_post']) == false) )
			{
				$error = true;
				$new['as_acp_aim_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_msn_post') && (num_check($new['as_acp_msn_post']) == false) )
			{
				$error = true;
				$new['as_acp_msn_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_yim_post') && (num_check($new['as_acp_yim_post']) == false) )
			{
				$error = true;
				$new['as_acp_yim_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_web_post') && (num_check($new['as_acp_web_post']) == false) )
			{
				$error = true;
				$new['as_acp_web_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_loc_post') && (num_check($new['as_acp_loc_post']) == false) )
			{
				$error = true;
				$new['as_acp_loc_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_occ_post') && (num_check($new['as_acp_occ_post']) == false) )
			{
				$error = true;
				$new['as_acp_occ_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_int_post') && (num_check($new['as_acp_int_post']) == false) )
			{
				$error = true;
				$new['as_acp_int_post'] = $row['config_value'];
			}
			elseif ( ($config_name == 'as_acp_sig_post') && (num_check($new['as_acp_sig_post']) == false) )
			{
				$error = true;
				$new['as_acp_sig_post'] = $row['config_value'];
			}

			if ( ($config_name != 'sitename') && ($config_name != 'site_desc') ) // once in a while we get a very strange bug otherwise...so just skip these areas because we don't even change them
			{
				$sql = "UPDATE " . CONFIG_TABLE . " SET
					config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
					WHERE config_name = '$config_name'";
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
				}
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		if (!$error)
		{
			$message = $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}
		else
		{
			$message = $lang['As_Acp_Update_Error'] . $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}

		message_die(GENERAL_MESSAGE, $message);
	}
	else if( isset($HTTP_POST_VARS['test_mail']) )
	{
		include($phpbb_root_path . 'includes/emailer.' . $phpEx);

		$triggers ='';

		$triggers  = $lang['ICQ'] . ': ' . '000000000' . "\r\n";
		$triggers .= $lang['AIM'] . ': ' . 'AIM' . "\r\n";
		$triggers .= $lang['MSNM'] . ': ' . 'MSN@HOTMAIL.COM' . "\r\n";
		$triggers .= $lang['YIM'] . ': ' . 'YIM' . "\r\n";
		$triggers .= $lang['Website'] . ': ' . 'http://www.testwebsite.com' . "\r\n";
		$triggers .= $lang['Location'] . ': ' . $board_config['sitename'] . "\r\n";
		$triggers .= $lang['Occupation'] . ': ' . $lang['Test_Occupation'] . "\r\n";
		$triggers .= $lang['Interests'] . ': ' . $lang['Test_Interests'] . "\r\n";
		$triggers .= $lang['Signature'] . ': ' . $lang['Test_Signature'] . "\r\n";

		$emailer = new emailer($board_config['smtp_delivery']);
		$emailer->from($board_config['board_email']);
		$emailer->replyto($board_config['board_email']);
		$emailer->use_template('admin_spam_notification');
		$emailer->email_address($HTTP_POST_VARS['as_acp_email_for_spam']);
		$emailer->set_subject($lang['Spam_Bot_Attempt'] . $board_config['sitename']);

		$emailer->assign_vars(array(
			'NOTICE'		=> $lang['Test_Email_Header'],
			'SITENAME'		=> $board_config['sitename'], 
			'USERNAME'		=> $lang['Test_Username'],
			'IP'			=> '0.0.0.0',
			'PASSWORD'		=> $lang['Test_Password'],
			'EMAIL'			=> sprintf($lang['Test_Email'], $board_config['server_name']),
			'TRIGGERS'		=> stripslashes($triggers)
		));

		$emailer->send();
		$emailer->reset();

		if (!$error)
		{
			$message = $lang['Message_Sent'] . '<br />' . $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}
		else
		{
			$message = $lang['Message_Sent'] . '<br />' . $lang['As_Acp_Update_Error'] . $lang['Config_updated'] . '<br /><br />' . sprintf($lang['Click_return_AS_ACP'], "<a href=\"" . append_sid("admin_anti_spam_acp.$phpEx") . "\">", "</a>") . '<br /><br />' . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}

		message_die(GENERAL_MESSAGE, $message);
	}

}
$icq_off			= ( $new['as_acp_icq']	== 'off' )			? "checked=\"checked\"" : "";
$icq_reg_off		= ( $new['as_acp_icq']	== 'reg off' )		? "checked=\"checked\"" : "";
$icq_on				= ( $new['as_acp_icq']	== 'on' )			? "checked=\"checked\"" : "";
$icq_post_count		= ( $new['as_acp_icq']	== 'post count' )	? "checked=\"checked\"" : "";

$aim_off			= ( $new['as_acp_aim']	== 'off' )			? "checked=\"checked\"" : "";
$aim_reg_off		= ( $new['as_acp_aim']	== 'reg off' )		? "checked=\"checked\"" : "";
$aim_on				= ( $new['as_acp_aim']	== 'on' )			? "checked=\"checked\"" : "";
$aim_post_count		= ( $new['as_acp_aim']	== 'post count' )	? "checked=\"checked\"" : "";

$msn_off			= ( $new['as_acp_msn']	== 'off' )			? "checked=\"checked\"" : "";
$msn_reg_off		= ( $new['as_acp_msn']	== 'reg off' )		? "checked=\"checked\"" : "";
$msn_on				= ( $new['as_acp_msn']	== 'on' )			? "checked=\"checked\"" : "";
$msn_post_count		= ( $new['as_acp_msn']	== 'post count' )	? "checked=\"checked\"" : "";

$yim_off			= ( $new['as_acp_yim']	== 'off' )			? "checked=\"checked\"" : "";
$yim_reg_off		= ( $new['as_acp_yim']	== 'reg off' )		? "checked=\"checked\"" : "";
$yim_on				= ( $new['as_acp_yim']	== 'on' )			? "checked=\"checked\"" : "";
$yim_post_count		= ( $new['as_acp_yim']	== 'post count' )	? "checked=\"checked\"" : "";

$web_off			= ( $new['as_acp_web']	== 'off' )			? "checked=\"checked\"" : "";
$web_reg_off		= ( $new['as_acp_web']	== 'reg off' )		? "checked=\"checked\"" : "";
$web_on				= ( $new['as_acp_web']	== 'on' )			? "checked=\"checked\"" : "";
$web_post_count		= ( $new['as_acp_web']	== 'post count' )	? "checked=\"checked\"" : "";

$loc_off			= ( $new['as_acp_loc']	== 'off' )			? "checked=\"checked\"" : "";
$loc_reg_off		= ( $new['as_acp_loc']	== 'reg off' )		? "checked=\"checked\"" : "";
$loc_on				= ( $new['as_acp_loc']	== 'on' )			? "checked=\"checked\"" : "";
$loc_post_count		= ( $new['as_acp_loc']	== 'post count' )	? "checked=\"checked\"" : "";

$occ_off			= ( $new['as_acp_occ']	== 'off' )			? "checked=\"checked\"" : "";
$occ_reg_off		= ( $new['as_acp_occ']	== 'reg off' )		? "checked=\"checked\"" : "";
$occ_on				= ( $new['as_acp_occ']	== 'on' )			? "checked=\"checked\"" : "";
$occ_post_count		= ( $new['as_acp_occ']	== 'post count' )	? "checked=\"checked\"" : "";

$int_off			= ( $new['as_acp_int']	== 'off' )			? "checked=\"checked\"" : "";
$int_reg_off		= ( $new['as_acp_int']	== 'reg off' )		? "checked=\"checked\"" : "";
$int_on				= ( $new['as_acp_int']	== 'on' )			? "checked=\"checked\"" : "";
$int_post_count		= ( $new['as_acp_int']	== 'post count' )	? "checked=\"checked\"" : "";

$sig_off			= ( $new['as_acp_sig']	== 'off' )			? "checked=\"checked\"" : "";
$sig_reg_off		= ( $new['as_acp_sig']	== 'reg off' )		? "checked=\"checked\"" : "";
$sig_on				= ( $new['as_acp_sig']	== 'on' )			? "checked=\"checked\"" : "";
$sig_post_count		= ( $new['as_acp_sig']	== 'post count' )	? "checked=\"checked\"" : "";

$check_version_enable	= ( $new['as_acp_check_version']	== '1' )	? "checked=\"checked\"" : "";
$check_version_disable	= ( $new['as_acp_check_version']	== '0' )	? "checked=\"checked\"" : "";

$show_mail_enable	= ( $new['as_acp_show_email_on_die']	== '1' )	? "checked=\"checked\"" : "";
$show_mail_disable	= ( $new['as_acp_show_email_on_die']	== '0' )	? "checked=\"checked\"" : "";

$send_mail_enable	= ( $new['as_acp_notify_on_spam']	== '1' )	? "checked=\"checked\"" : "";
$send_mail_disable	= ( $new['as_acp_notify_on_spam']	== '0' )	? "checked=\"checked\"" : "";

$show_bots_stopped_enable	= ( $new['as_acp_show_bots_stopped']	== '1' )	? "checked=\"checked\"" : "";
$show_bots_stopped_disable	= ( $new['as_acp_show_bots_stopped']	== '0' )	? "checked=\"checked\"" : "";

$template->set_filenames(array(
	'body' => 'admin/anti_spam_acp_body.tpl')
);
$template->assign_vars(array(
	'ICQ_OFF'						=> $icq_off,
	'ICQ_REG_OFF'					=> $icq_reg_off,
	'ICQ_ON'						=> $icq_on,
	'ICQ_POST_COUNT'				=> $icq_post_count,
	'ICQ_POSTS'						=> $new['as_acp_icq_post'],
	'AIM_OFF'						=> $aim_off,
	'AIM_REG_OFF'					=> $aim_reg_off,
	'AIM_ON'						=> $aim_on,
	'AIM_POST_COUNT'				=> $aim_post_count,
	'AIM_POSTS'						=> $new['as_acp_aim_post'],
	'MSN_OFF'						=> $msn_off,
	'MSN_REG_OFF'					=> $msn_reg_off,
	'MSN_ON'						=> $msn_on,
	'MSN_POST_COUNT'				=> $msn_post_count,
	'MSN_POSTS'						=> $new['as_acp_msn_post'],
	'YIM_OFF'						=> $yim_off,
	'YIM_REG_OFF'					=> $yim_reg_off,
	'YIM_ON'						=> $yim_on,
	'YIM_POST_COUNT'				=> $yim_post_count,
	'YIM_POSTS'						=> $new['as_acp_yim_post'],
	'WEB_OFF'						=> $web_off,
	'WEB_REG_OFF'					=> $web_reg_off,
	'WEB_ON'						=> $web_on,
	'WEB_POST_COUNT'				=> $web_post_count,
	'WEB_POSTS'						=> $new['as_acp_web_post'],
	'LOC_OFF'						=> $loc_off,
	'LOC_REG_OFF'					=> $loc_reg_off,
	'LOC_ON'						=> $loc_on,
	'LOC_POST_COUNT'				=> $loc_post_count,
	'LOC_POSTS'						=> $new['as_acp_loc_post'],
	'OCC_OFF'						=> $occ_off,
	'OCC_REG_OFF'					=> $occ_reg_off,
	'OCC_ON'						=> $occ_on,
	'OCC_POST_COUNT'				=> $occ_post_count,
	'OCC_POSTS'						=> $new['as_acp_occ_post'],
	'INT_OFF'						=> $int_off,
	'INT_REG_OFF'					=> $int_reg_off,
	'INT_ON'						=> $int_on,
	'INT_POST_COUNT'				=> $int_post_count,
	'INT_POSTS'						=> $new['as_acp_int_post'],
	'SIG_OFF'						=> $sig_off,
	'SIG_REG_OFF'					=> $sig_reg_off,
	'SIG_ON'						=> $sig_on,
	'SIG_POST_COUNT'				=> $sig_post_count,
	'SIG_POSTS'						=> $new['as_acp_sig_post'],
	'CHECK_VERSION_ENABLE'			=> $check_version_enable,
	'CHECK_VERSION_DISABLE'			=> $check_version_disable,
	'EMAIL'							=> $new['as_acp_email_for_spam'],
	'SEND_MAIL_ENABLE'				=> $send_mail_enable,
	'SEND_MAIL_DISABLE'				=> $send_mail_disable,
	'SHOW_MAIL_ENABLE'				=> $show_mail_enable,
	'SHOW_MAIL_DISABLE'				=> $show_mail_disable,
	'SHOW_BOT_COUNT_ENABLE'			=> $show_bots_stopped_enable,
	'SHOW_BOT_COUNT_DISABLE'		=> $show_bots_stopped_disable,
	'VERSION_INFO'					=> $version_info,
	'NUM_BOTS_CAUGHT'				=> $board_config['as_acp_bots_stopped'],

	'S_CONFIG_ACTION'				=> append_sid("admin_anti_spam_acp.$phpEx"),

	'L_ICQ'							=> $lang['ICQ'],
	'L_AIM'							=> $lang['AIM'],
	'L_MSN'							=> $lang['MSNM'],
	'L_YIM'							=> $lang['YIM'],
	'L_WEBSITE'						=> $lang['Website'],
	'L_LOCATION'					=> $lang['Location'],
	'L_OCCUPATION'					=> $lang['Occupation'],
	'L_INTERESTS'					=> $lang['Interests'],
	'L_SIGNATURE'					=> $lang['Signature'],
	'L_CHECK_VERSION'				=> $lang['Check_Version'],
	'L_CHECK_VERSION_EXPLAIN'		=> $lang['Check_Version_Explain'],
	'L_EMAIL_ADDRESS'				=> $lang['Email_Address'],
	'L_EMAIL_ADDRESS_EXPLAIN'		=> $lang['Email_Address_Explain'],
	'L_SHOW_MAIL'					=> $lang['Show_Email'],
	'L_SHOW_MAIL_EXPLAIN'			=> $lang['Show_Email_Explain'],
	'L_SEND_MAIL'					=> $lang['Send_Email'],
	'L_SEND_MAIL_EXPLAIN'			=> $lang['Send_Email_Explain'],
	'L_TEST_MAIL'					=> $lang['L_Test_Mail'],
	'L_TEST_MAIL_EXPLAIN'			=> $lang['L_Test_Mail_Explain'],
	'L_NUM_BOTS_CAUGHT'				=> $lang['Num_Bots_Caught'],
	'L_ANTI_SPAM_ACP_PAGE_SETTINGS'	=> sprintf($lang['AS_Page_Settings'], $board_config['as_acp_version']),
	'L_ANTI_SPAM_ACP'				=> $lang['Anti_Spam_ACP'],
	'L_ANTI_SPAM_ACP_CREATED_BY'	=> $lang['Anti_Spam_ACP_Created_By'],
	'L_OFF'							=> $lang['Always_Off'],
	'L_REG_OFF'						=> $lang['Reg_Off'],
	'L_ON'							=> $lang['On'],
	'L_POST_COUNT'					=> $lang['By_Post_Count'],
	'L_POSTS'						=> $lang['Post_Count'],
	'L_BOTS_CAUGHT'					=> $lang['Bots_Caught'],
	'L_BOTS_CAUGHT_EXPLAIN'			=> $lang['Bots_Caught_Explain'],
	'L_YES'							=> $lang['Yes'],
	'L_NO'							=> $lang['No'],
	'L_SUBMIT'						=> $lang['Submit'],
	'L_RESET'						=> $lang['Reset'],
));
	
$template->pparse('body');

include('./page_footer_admin.'.$phpEx);
?>