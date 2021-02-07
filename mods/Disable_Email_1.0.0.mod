############################################################## 
## MOD Title: Disable Email
## MOD Author: Graham < phpbb@grahameames.co.uk > (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: This MOD provides an option in the forum
##    configuration settings to turn the email functions on
##    or off. If turned off, the forum will not attempt to send
##    any emails.
##
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: 10 Minutes 
## Files To Edit:
##    admin/admin_board.php
##    groupcp.php
##    includes/emailer.php
##    includes/usercp_register.php
##    includes/usercp_sendpasswd.php
##    language/lang_english/lang_admin.php
##    language/lang_english/lang_main.php
##    posting.php
##    privmsg.php
##    templates/subSilver/admin/board_config_body.tpl
##    templates/subSilver/profile_add_body.tpl
## Included Files: 
##    N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##    This MOD overrides any Admin settings which would require
##    emails to be sent (Account Activation and Send Email Through Board)
############################################################## 
## MOD History:
## Aug 23, 2004 - Version 1.0.0
##  - Initial Release to MOD DB
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ SQL ]------------------------------------------ 
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('email_enabled', 1);

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 
  {
  	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
  }
  else
  {

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	// Added by Disable Email MOD
 	// If Email is disabled we want to override board email and account activation since the messages can't be sent
 	if ( $HTTP_POST_VARS['email_enabled'] == '0' )
 	{
 		$HTTP_POST_VARS['board_email_form'] = 0;
 		$HTTP_POST_VARS['require_activation'] = USER_ACTIVATION_NONE;
 	}
 	// Finish Disable Email MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
  $board_email_form_yes = ( $new['board_email_form'] ) ? "checked=\"checked\"" : "";
  $board_email_form_no = ( !$new['board_email_form'] ) ? "checked=\"checked\"" : "";

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 // Added by Disable Email MOD
 $email_enabled_yes = ( $new['email_enabled'] ) ? "checked=\"checked\"" : "";
 $email_enabled_no = ( !$new['email_enabled'] ) ? "checked=\"checked\"" : "";
 // Finish Disable Email MOD
 
# 
#-----[ FIND ]------------------------------------------ 
# 
  	"L_BOARD_EMAIL_FORM" => $lang['Board_email_form'], 
  	"L_BOARD_EMAIL_FORM_EXPLAIN" => $lang['Board_email_form_explain'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	// Added by Disable Email MOD
 	"L_EMAIL_ENABLED" => $lang['Email_enabled'], 
 	"L_EMAIL_ENABLED_EXPLAIN" => $lang['Email_enabled_explain'], 
 	// Finish Disable Email MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
  	"BOARD_EMAIL_FORM_ENABLE" => $board_email_form_yes, 
  	"BOARD_EMAIL_FORM_DISABLE" => $board_email_form_no, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	// Added by Disable Email MOD
 	"EMAIL_ENABLED_YES" => $email_enabled_yes, 
 	"EMAIL_ENABLED_NO" => $email_enabled_no, 
 	// Finish Disable Email MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
groupcp.php

# 
#-----[ FIND ]------------------------------------------ 
# 
  		message_die(GENERAL_ERROR, "Error getting group moderator data", "", __LINE__, __FILE__, $sql);
  	}
  
  	$moderator = $db->sql_fetchrow($result);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	// Added by Disable Email MOD
 	if ( $board_config['email_enabled'] )
 	{
 	// Finish Disable Email MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
  	$emailer->send();
  	$emailer->reset();

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	// Added by Disable Email MOD
 	}
 	// Finish Disable Email MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
  					$group_name_row = $db->sql_fetchrow($result);
  
  					$group_name = $group_name_row['group_name'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 					// Added by Disable Email MOD
 					if ( $board_config['email_enabled'] )
 					{
 					// Finish Disable Email MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
  					$emailer->send();
  					$emailer->reset();

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 					// Added by Disable Email MOD
 					}
 					// Finish Disable Email MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
 					if ( isset($HTTP_POST_VARS['approve']) )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
isset($HTTP_POST_VARS['approve'])

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 && $board_config['email_enabled']

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/emailer.php

# 
#-----[ FIND ]------------------------------------------ 
# 
  	// Send the mail out to the recipients set previously in var $this->address
  	function send()
  	{
  		global $board_config, $lang, $phpEx, $phpbb_root_path, $db;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 		// Added by Email Disable MOD
 		if ( !$board_config['email_enabled'] )
 		{
 			message_die(GENERAL_ERROR, $lang['Email_disabled']);
 		}
 		// Finish Email Disable MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_register.php

# 
#-----[ FIND ]------------------------------------------ 
# 
  			{
  				$message = $lang['Account_added'];
  				$email_template = 'user_welcome';
  			}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 			// Added by Disable Email MOD
 			if ( $board_config['email_enabled'] )
 			{
 			// Finish Disable Email MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
  					$emailer->send();
  					$emailer->reset();
  				}
  				$db->sql_freeresult($result);
  			}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 			// Added by Disable Email MOD
 			}
 			// Finish Disable EMail MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
  	else
  	{
  		$template->assign_block_vars('switch_namechange_disallowed', array());
  	}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	// Added by Disable Email MOD
 	if ( $board_config['email_enabled'] )
 	{
 		$template->assign_block_vars('switch_email_enabled', array());
 	}
 	// Finish Disable Email MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_sendpasswd.php

# 
#-----[ FIND ]------------------------------------------ 
# 
  {
  	die('Hacking attempt');
  	exit;
  }

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
  // Added by Disable Email MOD
  // If email is disabled we want to gracefully die since we can't sent the password
  if ( !$board_config['email_enabled'] )
  {
 	message_die(GENERAL_ERROR, sprintf($lang['Email_disabled_send_password'], '<a href="mailto:' . $board_config['board_email'] . '">', '</a>'));
  }
 // Finish Disable Email MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
  $lang['Board_email_form'] = 'User email via board';
  $lang['Board_email_form_explain'] = 'Users send email to each other via this board';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
  // Added by Disable Email MOD
  $lang['Email_enabled'] = 'Enable email options';
  $lang['Email_enabled_explain'] = 'Can the forum send out email messages to the users';
  // Finish Disable Email MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
  //
  // That's all, Folks!
  // -------------------------------------------------

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
  // Added by Disable Email MOD
  $lang['Email_disabled'] = 'Email on this forum has been disabled. Please inform the forum administrator what you were doing when this error message occured.';
  $lang['Email_disabled_send_password'] = 'Email on this forum has been disabled. If you need help recovering your password, please contact the %sAdministrator%s for help.';
  // Finish Disable Email MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 
 		if ($error_msg == '' && $mode != 'poll_delete')

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$mode != 'poll_delete'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 && $board_config['email_enabled']

# 
#-----[ FIND ]------------------------------------------ 
# 
  if ( $userdata['session_logged_in'] && $is_auth['auth_read'] )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$userdata['session_logged_in']

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
$board_config['email_enabled'] && 

# 
#-----[ OPEN ]------------------------------------------ 
# 
privmsg.php

# 
#-----[ FIND ]------------------------------------------ 
# 
 			if ( $to_userdata['user_notify_pm'] && !empty($to_userdata['user_email']) && $to_userdata['user_active'] )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$to_userdata['user_notify_pm']

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
$board_config['email_enabled'] && 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
  	<tr>
  	  <th class="thHead" colspan="2">{L_EMAIL_SETTINGS}</th>
  	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	<!-- Added by Email Disable MOD -->
 	<tr>
 		<td class="row1">{L_EMAIL_ENABLED}<br /><span class="gensmall">{L_EMAIL_ENABLED_EXPLAIN}</span></td>
 		<td class="row2"><input type="radio" name="email_enabled" value="1" {EMAIL_ENABLED_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="email_enabled" value="0" {EMAIL_ENABLED_NO} /> {L_NO}</td>
 	</tr>
 	<!-- Finish Email Disable MOD -->

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
  		<input type="radio" name="hideonline" value="1" {HIDE_USER_YES} />
  		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
  		<input type="radio" name="hideonline" value="0" {HIDE_USER_NO} />
  		<span class="gen">{L_NO}</span></td>
  	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	<!-- Added by Disable Email MOD -->
 	<!-- BEGIN switch_email_enabled -->

# 
#-----[ FIND ]------------------------------------------ 
# 
  		<input type="radio" name="notifypm" value="1" {NOTIFY_PM_YES} />
  		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
  		<input type="radio" name="notifypm" value="0" {NOTIFY_PM_NO} />
  		<span class="gen">{L_NO}</span></td>
  	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
 	<!-- END switch_email_enabled -->
 	<!-- Finish Disable Email MOD -->

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 