##############################################################
## MOD Title: Olympus-Style Login Screen
## MOD Author: kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.strangled.net/
## MOD Author: afterlife_69 < afterlife_69@hotmail.com > (Dean Newman) http://www.Ugboards.com/
## MOD Description: This MOD will change the style of the login screen on phpBB 2.0.X to the style on Olympus (phpBB 3.0)
## MOD Version: 3.0.1
## 
## Installation Level: Easy
## Installation Time: 10 minutes
## Files To Edit:	language/lang_english/lang_main.php
##					login.php
##					profile.php
##
## Included Files:	includes/usercp_sendactivation.php
##					language/lang_english/email/user_activate_resend.tpl
##					templates/subSilver/profile_resendactivation.tpl
##					templates/subSilver/login_olympus_body.tpl
##
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
##	This project is no longer support in the phpBB.com Modification Database, Please check the dev topic.
##	-	This version will only work on phpBB 2.0.18
## 
##############################################################
## MOD History:
## 
##   2005-02-24 - Version 1.0.0
##		- Initial Release :)
## 
##   2005-03-02 - Version 1.1.0
##		- Changed 'Return to Forum' to 'Board Index'
##		- Fixed the style of the login box
##		- Released a ForcedLogin_Explained Add-on
## 
##   2005-03-19 - Version 1.2.2
##		- Added Resend Activation MOD into it
##		- Added ForcedLogin_Explained Compatiblity (No Add-On Needed)
## 
##   2005-06-23 - Version 1.3.0
##		- Added 'Hide my online status this session
##		- Re-styled the box's
##		- Added Switch for the Admin Re-Auth
## 
##   2005-06-27 - Version 1.4.0
##		- Added Error Handling for Pass/User/Inactive
##		- Added the 'Sucessfull Login' message from olympus
##		- Added Different message on left for re-authing
##		- Changed 'New User Registration' to 'Create an Account'
##		- Re-Wrote the lang files to be neat and tidy
##		- Added a comment copyright to the template
##		- Double-checked that it works ok with easymod (Passed)
## 
##   2005-07-01 - Version 1.5.0
##		- Fixed some coding errors and re-submitted to MODDB
## 
##   2005-07-06 - Version 1.6.0
##		- Added a Redirect for the 'Logged In' Message
## 
##   2005-07-25 - Version 1.7.0
##		- Fixed 'Hide my online status this session' bug
##		- Resend Activation now checks to see if activation is set to ADMIN
## 
##   2005-07-26 - Version 1.8.0
##		- Changed '2' to USER_ACTIVATION_ADMIN in the account activation mode checks
##		- Fixed a template error where tabindex was '4' on autologin and '5' on hide-my-online-status
## 
##   2005-07-28 - Version 1.9.0
##		- Fixed a bug with resend activation disabling active accounts.
##
##   2005-08-04 - Version 2.0.0
##		- Removed Single Quotes from HideOnlineStatusThisSession code
##		- Changed if(! $HTTP_POST_VARS['admin'] ) to if(!isset($HTTP_POST_VARS['admin']))
##		- Updated ResendActivation ( Changed != to <> )
##		- Remembed to update template version holder :P
##
##   2005-08-08 - Version 2.1.0
##		- Fixed a bug in the handling of inactive accounts
##		- Fixed a bug in the resend_activation file
##		- Fixed a bug with 'Hide my online status' that would reset status on admin login
##
##   2005-10-26 - Version 2.2.0
##		- Rebuilt the error handling methods on invalid login
##		- Added 'redirect' varible for 'inactive user' to avoid error
##		- Fixed a bug causing the 'logged in' message to display when not logged in.
##		- Cleaned up the code
##
##	2005-10-27 - Version 2.3.0
##		- Fixed a bug causing a T_ELSEIF error on 2.2.0
##
##	2005-10-31 - Version 2.4.0
##		- Added new feature switch for phpBB 2.0.18
##
##	2005-10-31 - Version 2.5.0
##		- Cleaned up the install file to work with easymod and styled the breadcrumb bar.
##
##	2006-07-27 - Version 3.0.0
##		- Completely rewrote the MOD, Now does not use extra query no login.
## 
##	2006-09-01 - Version 3.0.1
##		- Fixed errors pointed out by mod team.
## 
##	2006-09-02 - Version 3.0.2
##		- Fixed more errors pointed out by mod team.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy root/templates/subSilver/login_olympus_body.tpl to templates/subSilver/login_olympus_body.tpl
copy root/templates/subSilver/profile_resendactivation.tpl to templates/subSilver/profile_resendactivation.tpl
copy root/language/lang_english/email/user_activate_resend.tpl to language/lang_english/email/user_activate_resend.tpl
copy root/includes/usercp_sendactivation.php to includes/usercp_sendactivation.php

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
# This is a partial find.
#
$lang['Forgotten_password']

#
#-----[ AFTER, ADD ]------------------------------------------
#
/**
 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
 *	@ Author	: (1) Afterlife_69
 *	@ Website	: http://www.afterlife69.com
 */
/* --- ADD --- */
$lang['Olympus_login_register']				= 'Create new account';
$lang['Olympus_login_info']					= 'In order to login you must be registered.<br />Registering takes only a few seconds but gives you increased<br />capabilies. The board administrator may also grant additional<br />permissions to registered users. Before you login please ensure you<br />are familiar with our terms of use and related policies. Please<br />ensure you read any forum rules as you navigate around the board.';
$lang['Olympus_login_index']				= 'Board Index';
$lang['Olympus_login_faq']					= 'View F.A.Q.';
$lang['Olympus_login_admin']				= 'To login to the administration panel you must re-authenticate yourself to verify you are really the administrator of the board<br /><br />Once logged in you will be able to access the ACP until your session ends';
$lang['Olympus_login_activate']				= 'Resend Activation';
$lang['Olympus_login_hideme']				= 'Hide my online status this session';
$lang['Olympus_login_options']				= 'Options';
$lang['Olympus_login_logged_in']			= 'You have sucessfully been logged into this forum';
$lang['Olympus_login_account_inactive']		= 'Sorry but this account is currently inactive';
$lang['Olympus_login_resend_activation']	= 'Click %shere%s to send a new activation code';
$lang['Olympus_login_click_return']			= 'Click %shere%s to return to your previous location';
$lang['Olympus_login_reset_password']		= 'Click %shere%s to reset your password';
$lang['Olympus_login_register_account']		= 'Click %shere%s to register this account';
$lang['Olympus_login_not_registered']		= 'Sorry but the account you specified does not exist in our database';
$lang['Olympus_login_invalid_password']		= 'Sorry but the password you entered was invalid';
$lang['Olympus_login_activation_resent']	= 'A new activation key has been sent; please check your e-mail for details on how to activate it.';
$lang['Olympus_login_admin_only_activate']	= 'Sorry but the board is currently set for admin only activations, Please contact the board administrator.';
$lang['Olympus_login_account_is_active']	= 'The selected account is already activated.';
$lang['Olympus_redirect_insecure']	= 'Tried to redirect to potentially insecure url.';
/* --- END --- */

#
#-----[ OPEN ]------------------------------------------
#
login.php

#
#-----[ FIND ]------------------------------------------
#
					$autologin = ( isset($HTTP_POST_VARS['autologin']) ) ? TRUE : 0;

#
#-----[ AFTER, ADD ]------------------------------------------
#
					/**
					 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
					 *	@ Author	: (1) Afterlife_69
					 *	@ Website	: http://www.afterlife69.com
					 */
					/* --- ADD --- */
					$hideonline = ( isset ( $HTTP_POST_VARS['hideonline'] ) ) ? FALSE : TRUE;
					/* --- END --- */

#
#-----[ FIND ]------------------------------------------
#
					$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_tries = 0, user_last_login_try = 0 WHERE user_id = ' . $row['user_id']);

#
#-----[ REPLACE WITH ]------------------------------------------
#
					/**
					 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
					 *	@ Author	: (1) Afterlife_69
					 *	@ Website	: http://www.afterlife69.com
					 */
					/* --- REMOVE ---
					// Reset login tries
					$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_tries = 0, user_last_login_try = 0 WHERE user_id = ' . $row['user_id']);
					--- REPLACE --- */
					$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_tries = 0, user_last_login_try = 0, user_allow_viewonline = ' . (int) $hideonline . ' WHERE user_id = ' . $row['user_id']);
					/* --- END --- */

#
#-----[ FIND ]------------------------------------------
#
						$url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";
						redirect(append_sid($url, true));

#
#-----[ REPLACE WITH ]------------------------------------------
#
						/**
						 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
						 *	@ Author	: (1) Afterlife_69
						 *	@ Website	: http://www.afterlife69.com
						 */

						/* --- REMOVE ---
						$url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";
						redirect(append_sid($url, true));
						--- REPLACE --- */
						$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";
	
						if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
						{
								message_die(GENERAL_ERROR, $lang['Olympus_redirect_insecure']);
						}
						
						if ( ! isset ( $HTTP_POST_VARS['admin'] ) )
						{
							// Handle redirects
							if ( empty ( $HTTP_POST_VARS['redirect'] ) )
							{
								$template->assign_vars(array(
									'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($redirect) . '">')
								);

								$message = $lang['Olympus_login_logged_in'] . '<br /><br />' . sprintf($lang['Olympus_login_click_return'], '<a href="' . append_sid($redirect) . '">', '</a>');
							}
							
							// Output 'You have sucessfully been logged in' message.
							message_die(GENERAL_MESSAGE, $message);
						}
						else
						{
							$url = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";
							redirect(append_sid($url, true));
						}
						/* --- END --- */

#
#-----[ FIND ]------------------------------------------
#
				// Only store a failed login attempt for an active user - inactive users can't login even with a correct password
				elseif( $row['user_active'] )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				/**
				 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
				 *	@ Author	: (1) Afterlife_69
				 *	@ Website	: http://www.afterlife69.com
				 */
				/* --- ADD --- */
				// Split message for inactive users
				else if ( ! $row['user_active'] )
				{
					$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";
	
					if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
					{
							message_die(GENERAL_ERROR, $lang['Olympus_redirect_insecure']);
					}

					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($redirect) . '">')
					);

					$message = $lang['Olympus_login_account_inactive'] . '<br /><br />' . sprintf($lang['Olympus_login_resend_activation'], "<a href=\"profile.$phpEx?mode=resendactivation\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_login'], '<a href="' . append_sid("login.$phpEx") . '">', '</a>');

					message_die(GENERAL_MESSAGE, $message);
				}
				// Split message for invalid password
				else if ( md5($password) != $row['user_password'] && $row['user_active'] )
				{
					$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : "index.$phpEx";
	
					if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
					{
							message_die(GENERAL_ERROR, $lang['Olympus_redirect_insecure']);
					}

					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid($redirect) . '">')
					);

					$message = $lang['Olympus_login_invalid_password'] . '<br /><br />' . sprintf($lang['Olympus_login_reset_password'], "<a href=\"profile.$phpEx?mode=sendpassword\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_login'], '<a href="' . append_sid("login.$phpEx") . '">', '</a>');

					message_die(GENERAL_MESSAGE, $message);
				}
				/* --- END --- */

#
#-----[ FIND ]------------------------------------------
#
				$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : '';
				$redirect = str_replace('?', '&', $redirect);

				if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
				{
					message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
				}

				$template->assign_vars(array(
					'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
				);

				$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

				message_die(GENERAL_MESSAGE, $message);

#
#-----[ REPLACE WITH ]------------------------------------------
#
				/**
				*	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
				*	@ Author	: (1) Afterlife_69
				*	@ Website	: http://www.afterlife69.com
				*/
				/* --- REMOVE ---
				$redirect = ( !empty($HTTP_POST_VARS['redirect']) ) ? str_replace('&amp;', '&', htmlspecialchars($HTTP_POST_VARS['redirect'])) : '';
				$redirect = str_replace('?', '&', $redirect);

				if (strstr(urldecode($redirect), "\n") || strstr(urldecode($redirect), "\r"))
				{
					message_die(GENERAL_ERROR, $lang['Olympus_redirect_insecure']);
				}

				$template->assign_vars(array(
					'META' => "<meta http-equiv=\"refresh\" content=\"3;url=login.$phpEx?redirect=$redirect\">")
				);

				$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

				message_die(GENERAL_MESSAGE, $message);
				--- END --- */

#
#-----[ FIND ]------------------------------------------
#
# This is the second one.
#
			$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);

#
#-----[ REPLACE WITH ]------------------------------------------
#
			/**
			 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
			 *	@ Author	: (1) Afterlife_69
			 *	@ Website	: http://www.afterlife69.com
			 */
			/* --- REMOVE ---
			$message = $lang['Error_login'] . '<br /><br />' . sprintf($lang['Click_return_login'], "<a href=\"login.$phpEx?redirect=$redirect\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
			--- REPLACE --- */
			$message = $lang['Olympus_login_not_registered'] . '<br /><br />' . sprintf($lang['Olympus_login_register_account'], "<a href=\"profile.$phpEx?mode=register\">", '</a>') . '<br /><br />' .  sprintf($lang['Click_return_login'], '<a href="' . append_sid("login.$phpEx") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
			/* --- END --- */

#
#-----[ FIND ]------------------------------------------
#
		$template->set_filenames(array(
			'body' => 'login_body.tpl')
		);

#
#-----[ REPLACE WITH ]------------------------------------------
#
		/**
		 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
		 *	@ Author	: (1) Afterlife_69
		 *	@ Website	: http://www.afterlife69.com
		 */
		 /* --- REMOVE ---
		$template->set_filenames(array(
			'body' => 'login_body.tpl')
		);
		--- REPLACE --- */
		$template->set_filenames(array(
			'body' => 'login_olympus_body.tpl')
		);
		/* --- END --- */

#
#-----[ FIND ]------------------------------------------
#
		'L_SEND_PASSWORD' => $lang['Forgotten_password'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
			/**
			 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
			 *	@ Author	: (1) Afterlife_69
			 *	@ Website	: http://www.afterlife69.com
			 */
			 /* --- ADD --- */
			'L_LOGIN_REGISTER'	=> $lang['Olympus_login_register'],
			'L_LOGIN_INFO'		=> $lang['Olympus_login_info'],
			'L_LOGIN_INDEX'		=> $lang['Olympus_login_index'],
			'L_LOGIN_FAQ'		=> $lang['Olympus_login_faq'],
			'L_LOGIN_ADMIN'		=> $lang['Olympus_login_admin'],
			'L_LOGIN_ACTIVATE'	=> $lang['Olympus_login_activate'],
			'L_LOGIN_HIDEME'	=> $lang['Olympus_login_hideme'],
			'L_LOGIN_OPTIONS'	=> $lang['Olympus_login_options'],

			'U_LOGIN_ACTIVATE'	=> append_sid("profile.$phpEx?mode=resendactivation"),
			 /* --- END --- */

#
#-----[ FIND ]------------------------------------------
#
#
		$template->pparse('body');

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		/**
		 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
		 *	@ Author	: (1) Afterlife_69
		 *	@ Website	: http://www.afterlife69.com
		 */
		/* --- ADD --- */
		if ( isset( $HTTP_GET_VARS['admin'] ) )
		{
			$template->assign_block_vars('switch_admin_reauth', array());
		}

		if ( $board_config['require_activation'] !== USER_ACTIVATION_ADMIN && ! $userdata['session_logged_in'] )
		{
			$template->assign_block_vars('switch_admin_activation', array());
		}
		/* --- END --- */

#
#-----[ OPEN ]------------------------------------------
#
profile.php

#
#-----[ FIND ]------------------------------------------
#
	else if ( $mode == 'activate' )
	{
		include($phpbb_root_path . 'includes/usercp_activate.'.$phpEx);
		exit;
	}

#
#-----[ AFTER, ADD ]------------------------------------------
#
	/**
	 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
	 *	@ Author	: (1) Afterlife_69
	 *	@ Website	: http://www.afterlife69.com
	 */
	/* --- ADD --- */
	else if ( $mode == 'resendactivation' )
	{
		include($phpbb_root_path . 'includes/usercp_sendactivation.' . $phpEx);
		exit;
	}
	/* --- END --- */

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM