##############################################################
## MOD Title: Send mail to user on admin (de-)activate
## MOD Author: jrf < phpbbmods_nospam@adviesenzo.nl > (Juliette Reinders Folmer) http://www.adviesenzo.nl/
## MOD Description: Normally when a user's status (active yes/no) has been changed through the ACP,
##		the user isn't notified of this change.
##		If the board requires admin/user activation and the user is activated by the admin
##		he/she therefore has no way of knowing that the activation has taken place already.
##		Similarly is the user has been deactivated he/she will not know this until they
##		next try to login and then they often will not understand what's going on.
##
##		This mod fixes that.
##		If the board requires admin/user activation and the user is activated through the ACP
##		the activation key (if exists and is not for password change) will be deleted and the
##		user notified by email.
##		If then at a later stage the user is de-activated and/or activated again through the ACP
##		the user is notified of this by email as well.
##
##		This mod can be incorporated in Famitsu's modcp.
##		This mod can be incorporated in wGEric's admin userlist.
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit:
##		admin/admin_users.php
##		language/lang_english/lang_main.php
##		language/lang_english/email/admin_welcome_activated.tpl
## Included Files:
##		language/lang_english/email/admin_deactivated.tpl
##		language/lang_dutch/email/admin_deactivated.tpl (optional)
##		use_mod_in_admin_list.mod (optional)
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##		Additional file included for use with a dutch language set.
##		Obviously language string changes will need to be made in the dutch language
##		file as well if you use this file.
##		For other languages:
##		- translate the email template and put it in the correct directory
##		- translate the language string change and apply in the language file of choice
##
##		Optional:
##
##		You can add this functionality to Famitsu's modcp
##		To do so, use the instructions for admin/admin_users.php in
##		modcp/admin_users.php too
##
##		You can add this functionality to wGEric's admin userlist
##		To do so, user the extra instructions in the
##		use_mod_in_admin_list.mod file
##
##############################################################
## MOD History:
##
##		2005-01-01 - Version 0.1.0
##		- initial (beta) version released through beta forum
##		2005-01-24 - Version 1.0.0
##		- one typo fixed
##		- double checked syntax vs coding guidelines and added some more documentation
##		- submitted to MOD database
##		2006-08-06 - Version 1.0.1
##		- double 'Hello {USERNAME}' line in email template removed
##		2007-11-27 - Version 1.0.1a
##		- obligatory review for compliance with latest phpBB versions - no issues found
##		- adjusted the header information to include the latest license and security warning text
##		- some small changes to the code / code formatting to comply with the latest coding guidelines
##		- added unset()'s for any and all variables initiated within the mode
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
#

copy language/lang_english/email/admin_deactivated.tpl to language/lang_english/email/admin_deactivated.tpl

#
#-----[ OPEN ]------------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------------
#
		//
		// Avatar stuff
		//

#
#-----[ BEFORE, ADD ]------------------------------------------------
#

		// BEGIN Send user mail on admin (de-)activate MOD

		// Has the user status changed ?
		if ($user_status != $this_userdata['user_active'])
		{

			// Does the board require admin or user activation and has the user been activated ?
			if (((intval($board_config['require_activation']) == USER_ACTIVATION_ADMIN) || (intval($board_config['require_activation']) == USER_ACTIVATION_SELF)) && ($user_status == 1))
			{
				// Test whether the user has been activated already and act_key is not for new password
				$sql = 'SELECT user_active, user_actkey, user_newpasswd
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $user_id . ';';

				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (($row['user_active'] == 0) && ((!empty($row['user_actkey'])) && (empty($row['user_newpasswd']))))
				{
					// Only update the activation key as the activation status is updated in the main script
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_actkey = ""
						WHERE user_id = ' . (int) $user_id . ';';

					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not update users table - deletion of actkey', '', __LINE__, __FILE__, $sql);
					}
				}
				unset($sql, $result, $row);
			}

			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);

			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);

			$emailer->email_address($email);
			$emailer->assign_vars(array(
				'SITENAME' => $board_config['sitename'],
				'USERNAME' => $username,
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
			);

			if ($user_status == 1)
			{
				//User was inactive and will become active
				$emailer->use_template('admin_welcome_activated', $user_lang);
				$emailer->set_subject($lang['Account_activated_subject']);
			}
			else if ($user_status == 0)
			{
				//User was active and will become deactivated
				$emailer->use_template('admin_deactivated', $user_lang);
				$emailer->set_subject($lang['Account_deactivated_subject']);
			}

			$emailer->send();
			unset($emailer);

		}
		// END Send user mail on admin (de-)activate MOD

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Account_activated_subject'] = 'Account Activated';

#
#-----[ AFTER, ADD ]------------------------------------------
#

// BEGIN Send user mail on admin (de-)activate MOD
$lang['Account_deactivated_subject'] = 'Account De-activated';
// END Send user mail on admin (de-)activate MOD

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/email/admin_welcome_activated.tpl

#
#-----[ FIND ]------------------------------------------
#

Your account on "{SITENAME}" has now been activated, you may login using the username and password you received in a previous email.

#
#-----[ IN-LINE FIND ]------------------------------------------
#
Your account on "{SITENAME}" has now been activated

#
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 (again)

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM