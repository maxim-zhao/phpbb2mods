##############################################################
## MOD Title: Send mail to user on admin (de-)activate in admin userlist
## MOD Author: jrf < phpbbmods_nospam@adviesenzo.nl > (Juliette Reinders Folmer) http://www.adviesenzo.nl/
## MOD Description: Additional instructions for incorporating this mod into wGEric's admin userlist.
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit:
##		admin/admin_userlist.php
## Included Files: N/A
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
##		It is assumed you have implemented the main mod in the ACP
##		before you add this mod to the admin_userlist
##
##		If you ONLY want to add this mod to the admin_userlist
##		you will need to follow the instructions of the main mod
##		EXCEPT for the changes to admin_users.php (don't do these)
##		Then follow the instructions in this add-on
##
##############################################################
## MOD History:
##
##		2005-01-01 - Version 0.1.0
##		- initial (beta) version released through beta forum
##		2005-01-24 - Version 1.0.0
##		- double checked syntax vs coding guidelines and added some more documentation
##		- submitted to MOD database
##		2007-11-27 - Version 1.0.0a
##		- obligatory review for compliance with latest phpBB2 versions - no issues found
##		- adjusted the header information to include the latest license and security warning text
##		- some small changes to the code / code formatting to comply with the latest coding guidelines
##		- added unset()'s for any and all variables initiated within the mode
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------------
#
admin/admin_userlist.php

#
#-----[ FIND ]------------------------------------------------
#
	case 'activate':

		//
		// activate or deactive the seleted users
		//
		$i = 0;
		while( $i < count($user_ids) )
		{
			$user_id = intval($user_ids[$i]);
			$sql = "SELECT user_active FROM " . USERS_TABLE . "
				WHERE user_id = $user_id";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$new_status = ( $row['user_active'] ) ? 0 : 1;

			$sql = "UPDATE " . USERS_TABLE . "
				SET user_active = '$new_status'
				WHERE user_id = $user_id";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update user status', '', __LINE__, __FILE__, $sql);
			}

			unset($user_id);
			$i++;
		}

		$message = $lang['User_status_updated'] . "<br /><br />" . sprintf($lang['Click_return_userlist'], "<a href=\"" . append_sid("admin_userlist.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
		break;

#
#-----[ REPLACE WITH ]------------------------------------------------
#

	case 'activate':

		//
		// activate or deactive the selected users
		//

		// BEGIN Send user mail on admin (de-)activate MOD
		include($phpbb_root_path . 'includes/emailer.'.$phpEx);
		$emailer = new emailer($board_config['smtp_delivery']);

		$i = 0;
		while ($i < count($user_ids))
		{
			$user_id = intval($user_ids[$i]);
			$sql = 'SELECT user_active, username, user_email FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $user_id . ';';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

			$new_status	= ( $row['user_active'] ) ? 0 : 1;
			$username	= $row['username'];
			$email		= $row['user_email'];

			$sql = 'UPDATE ' . USERS_TABLE . "
				SET user_active = '$new_status'
				WHERE user_id = " . (int) $user_id . ';';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update user status', '', __LINE__, __FILE__, $sql);
			}

			// Does the board require admin or user activation and has the user been activated ?
			if (((intval($board_config['require_activation']) == USER_ACTIVATION_ADMIN) || (intval($board_config['require_activation']) == USER_ACTIVATION_SELF)) && ($new_status == 1))
			{
				// Test whether the user has been activated already and act_key is not for new password
				$sql = 'SELECT user_actkey, user_newpasswd
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . (int) $user_id . ';';

				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (($new_status == 1) && ((!empty($row['user_actkey'])) && (empty($row['user_newpasswd']))))
				{
					// Only update the activation key as the activation status has already been updated in the main script
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_actkey = ""
						WHERE user_id = ' . (int) $user_id . ';';

					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not update users table - deletion of actkey', '', __LINE__, __FILE__, $sql);
					}
				}
			}

			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);
			$emailer->email_address($email);
			$emailer->assign_vars(array(
				'SITENAME' => $board_config['sitename'],
				'USERNAME' => $username,
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
			);

			if ($new_status == 1)
			{
				//User was inactive and will become active
				$emailer->use_template('admin_welcome_activated', $user_lang);
				$emailer->set_subject($lang['Account_activated_subject']);
			}
			else if ($new_status == 0)
			{
				//User was active and will become deactivated
				$emailer->use_template('admin_deactivated', $user_lang);
				$emailer->set_subject($lang['Account_deactivated_subject']);
			}

			$emailer->send();
			$emailer->reset();

			unset($user_id, $new_status, $username, $email, $sql, $result, $row);
			$i++;
		}

		$message = $lang['User_status_updated'] . "<br /><br />" . sprintf($lang['Click_return_userlist'], "<a href=\"" . append_sid("{$phpbb_admin_path}admin_userlist.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("{$phpbb_admin_path}index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);

		unset($emailer, $i, $message);

		// END Send user mail on admin (de-)activate MOD
	break;



#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM