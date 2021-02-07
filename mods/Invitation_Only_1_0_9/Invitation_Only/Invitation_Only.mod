##############################################################
## MOD Title: Invitation Only
## MOD Author: kellanved < kellanved@gmail.com > (N/A) N/A
## MOD Description:  
##				  Adds an option to require new users to provide a passcode for registration.
##				  Also adds an Admin Page to generate new passcodes.
## MOD Version: 1.0.9
## 
## Installation Level: Intermediate
## Installation Time:~ 25 Minutes
## Files To Edit:		admin/admin_board.php
##				admin/admin_users.php
##				admin/admin_groups.php
##				includes/constants.php
##				includes/usercp_register.php
##				language/lang_english/lang_main.php
##				language/lang_english/lang_admin.php
##				templates/subSilver/profile_add_body.tpl
##				templates/subSilver/admin/board_config_body.tpl
## Included Files: 		
##				phpBB_root/admin/admin_invites.php
##				phpBB_root/templates/subSilver/admin/invites_list_body.tpl
##				phpBB_root/templates/subSilver/admin/invite_add_body.tpl
##				phpBB_root/language/lang_english/email/admin_send_invite_email.tpl
##  
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: Borrows some code from the phpBB Rank and Mass Email system. 
##############################################################
## MOD History:
##   2006-03-12 - Version 1.0.9
##	-changed the mod template to conform to phpBB 2.0.19
##	-minor improvements and changes
##
##   2005-11-28 - Version 1.0.8
##	-fixed another 2.0.18 issue
##	-improved the code at a few places, as suggested by Mac. 
##
## -Minor Changes
##   2005-11-18 - Version 1.0.7c
##
## -Minor Changes
##
##   2005-11-10 - Version 1.0.7b
##
## -Adapted the mod template to phpBB 2.0.18 
##
##   2005-11-10 - Version 1.0.7a
##
## -Adapted the mod template to phpBB 2.0.18 
##
##   2005-5-24 - Version 1.0.7
##
## -fixed the emailed link for the groupcp. 
##
##
##   2005-4-24 - Version 1.0.6
##
## -removed a few cut'n paste mistakes in the lang fields.
##
##
##   2005-4-19 - Version 1.0.5
##
## -fixed an ambiguous "find" in the .mod file. 
##
##
##   2005-4-19 - Version 1.0.4
##
## -added mt_srand call for PHP versions < 4.2
##
##
##   2005-4-15 - Version 1.0.3
##
## -cleaned up the SQL  (removed/combined one query and several extra semicolons).
## -moved the email addy to its own field in the Invitation Table. 
## -the description now uses a text area.
## -several cosmetic changes
## -resubmitted
##
##  
##   2005-4-13 - Version 1.0.2
##
## -added a missing lang variable 
## -fixed the html problem with the invite description(thanks !) 
## -the mod is now activated by default
## -performed requested changes to the mod template
## -resubmitted
##
##
##    2005-4-9 - Version 1.0.1
##
## -fixed a bug with the registration link (thanks !) 
## -the email address  now gets passed along in the registration link
## -corrected a few typos in the new language fields
## -resubmitted
##
##
##    2005-03-31 - Version 1.0.0
##
## - Submitted to MOD Database
##
##
##   2005-03-27 - Version 0.4.3a
##
## - fixed two showstopping typos in the .mod file 
##
##
##   2005-03-23 - Version 0.4.3
##
## -Fixed several bugs - most notably one in the SQL that rendered the system useless under certain (fairly frequent) circumstances
## -cleaned up the code /mod template
## 
##
##   2005-03-22 - Version 0.4.2
## 
## -Added a few simple filter options for the list.
##
##
##   2005-03-20 - Version 0.4.1
## 
## -The Invitation Admin Page now only displays 30 invites at once (multiple pages)
##
##
##   2005-03-19 - Version 0.4.0
## 
## -Invites now can be re-used for a configurable amount of times
## -Invites can now be edited
## -The information what users used which invite is now stored
## -New users can be set to auto-join a group, depending on the invite-code used
## 
##
##   2005-03-07 - Version 0.3.0
## 
## -Now allows Invitation Links.
## -Changed the code length to 8 chars
## -Used Invites now stay in the database
##
##
##   2005-03-06 - Version 0.2.2
## 
## -Now works with easymod
##
##
##   2005-03-06 - Version 0.2.0
## 
## -Added Email function
##
##
##   2005-03-06 - Version 0.1.2
## 
## -Security and general bugs fixed
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
CREATE TABLE phpbb_invitations (
	invitation_id MEDIUMINT( 8 ) NOT NULL AUTO_INCREMENT ,
	invitation_code VARCHAR( 8 ) NOT NULL ,
	invitation_description TEXT NOT NULL,
	invitation_uses MEDIUMINT(8) NOT NULL DEFAULT '1',
	invitation_group MEDIUMINT(8) NOT NULL DEFAULT '0',
        invitation_email TEXT NOT NULL,
	PRIMARY KEY ( invitation_id ) 
);

CREATE TABLE phpbb_invitation_users (
	invitation_id MEDIUMINT( 8 ) NOT NULL,
	user_id MEDIUMINT( 8 ) NOT NULL,	
	PRIMARY KEY ( user_id ) 
);	

INSERT INTO phpbb_config ( config_name , config_value ) 
	VALUES ('invite_only', '1'); 
#
#-----[ COPY ]------------------------------------------
#
copy phpBB_root/admin/admin_invites.php to admin/admin_invites.php
copy phpBB_root/templates/subSilver/admin/invites_list_body.tpl to templates/subSilver/admin/invites_list_body.tpl
copy phpBB_root/templates/subSilver/admin/invite_add_body.tpl to templates/subSilver/admin/invite_add_body.tpl
copy phpBB_root/language/lang_english/email/admin_send_invite_email.tpl to language/lang_english/email/admin_send_invite_email.tpl

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
$activation_admin = ( $new['require_activation'] == USER_ACTIVATION_ADMIN ) ? "checked=\"checked\"" : "";
#
#-----[ AFTER, ADD ]------------------------------------------
#

//BEGIN Invite Only MOD
$invite_only_yes = ($new['invite_only']) ? 'checked="checked"' : '';
$invite_only_no = (!$new['invite_only']) ? 'checked="checked"' : '';
//END Invite Only MOD

#
#-----[ FIND ]------------------------------------------
#
	"L_ADMIN" => $lang['Acc_Admin'],	 
#
#-----[ AFTER, ADD ]------------------------------------------
#

	//BEGIN Invite Only MOD
	"L_INVITE_ONLY" => $lang['Invite_only'],
	//END Invite Only MOD
#
#-----[ FIND ]------------------------------------------
#
	"ACTIVATION_ADMIN_CHECKED" => $activation_admin, 

#
#-----[ AFTER, ADD ]------------------------------------------
#

	//BEGIN Invite Only MOD
	"INVITATION_ONLY_ENABLE" => $invite_only_yes,
	"INVITATION_ONLY_DISABLE" => $invite_only_no,
	//END Invite Only MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
define('VOTE_USERS_TABLE', $table_prefix.'vote_voters');

#
#-----[ AFTER, ADD ]------------------------------------------
#

//BEGIN Invite Only MOD
define('INVITATION_TABLE', $table_prefix.'invitations');
define('INVITATION_USER_TABLE', $table_prefix.'invitation_users');
//END Invite Only MOD
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------
#
function show_coppa()
#
#-----[ IN-LINE FIND ]------------------------------------------
#
(
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
$invite_code, $email
#
#-----[ FIND ]------------------------------------------
#
"U_AGREE_OVER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true"),
#
#-----[ IN-LINE FIND ]------------------------------------------
#
true"
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 .$invite_code . $email
#
#-----[ FIND ]------------------------------------------
#
"U_AGREE_UNDER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true&amp;coppa=true"))
#
#-----[ IN-LINE FIND ]------------------------------------------
#
true"
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 .$invite_code . $email
#
#-----[ FIND ]------------------------------------------
#
if ( $mode == 'register' && !isset($HTTP_POST_VARS['agreed']) && !isset($HTTP_GET_VARS['agreed']) )
{
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#

	//BEGIN Invite Only MOD
	$invite_code = ( !empty($HTTP_GET_VARS['invite']) ) ? "&amp;invite=" .  urlencode($HTTP_GET_VARS['invite']) :  '';
	/*we could just as well retrieve the address from the database. But this gets the job done too. 
	(IMHO even better, as it can't be used to leak information))*/
	$email = ( !empty($HTTP_GET_VARS['mail']) ) ? "&amp;email=" .  urlencode($HTTP_GET_VARS['mail']) :  '';
	//END Invite Only MOD
#
#-----[ FIND ]------------------------------------------
#
show_coppa();
#
#-----[ IN-LINE FIND ]------------------------------------------
#
(
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
$invite_code, $email
#
#-----[ FIND ]------------------------------------------
#
	$strip_var_list = array('email' => 'email', 'icq' => 'icq', 'aim' => 'aim', 'msn' => 'msn', 'yim' => 'yim'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
)
#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, 'invitation_code' => 'invitation_code'
#
#-----[ FIND ]------------------------------------------
#
			$db->sql_freeresult($result);
		}
	}

#
#-----[ AFTER, ADD ]------------------------------------------
#

	//BEGIN Invite Only MOD 
	$invite_data = false; 
	if ($board_config['invite_only'] && $mode == 'register') //Let's check the invitation code they sent us
	{
		if (!isset($invitation_code) || !preg_match('/^[A-Za-z0-9]+$/', $invitation_code))  //this should get rid of any nasty surprises
		{
			$invitation_code = '';
		}
		if (empty($invitation_code))
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Invitation_code_invalid'];
		}
		else
		{
						
			$sql = 'SELECT invitation_id, invitation_group, invitation_uses 
				FROM ' . INVITATION_TABLE . " 
				WHERE (invitation_uses <> '0')
				AND (invitation_code = '" . str_replace("\'", "''", $invitation_code) . "')";
			if (!($result = $db->sql_query($sql)))
			{
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . INVITATION_TABLE;
			}
			if (!$invite_data = $db->sql_fetchrow($result))			
			{		
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Invitation_code_invalid'];
				$invite_data = false; 
			}
			$db->sql_freeresult($result);
		}
	}
		 
	//END Invite Only MOD	
#
#-----[ FIND ]------------------------------------------
#			
				$email_template = 'user_welcome';
			}

			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#

			//BEGIN Invite Only MOD	  
			if ($board_config['invite_only'] && !empty($invite_data) ) //OK, the code was good, let's update the invitation table 
			{  
				$uses = (intval($invite_data['invitation_uses']));
				if ($uses != -1)
				{   
					//the escaping shouldn't be vital, but better safe than sorry
					$invite_data['invitation_id'] = str_replace("\'", "''", $invite_data['invitation_id']);
				
					$invite_sql = 'UPDATE ' . INVITATION_TABLE . " 
					SET invitation_uses  =  invitation_uses -1  
					WHERE (invitation_id = ".$invite_data['invitation_id'].")";	   
					if ( !($result = $db->sql_query($invite_sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not update invitation  table', '', __LINE__, __FILE__, $invite_sql);
					}
				}	
				
				//Remember who used this invite
					$invite_user_sql = 'INSERT INTO ' . INVITATION_USER_TABLE . "
						(user_id, invitation_id) 
						VALUES ($user_id, ".$invite_data['invitation_id'].")";
								 
								 
					if ( !($result = $db->sql_query($invite_user_sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not update invitation user table', '', __LINE__, __FILE__, $invite_user_sql);
					}
					// and auto-join the group, should there be one
					if (!empty($invite_data['invitation_group']))
					{
						$find_group_sql = 'SELECT group_id  
							FROM ' . GROUPS_TABLE . " 
							WHERE (group_id = ".$invite_data['invitation_group'].") 
								AND (group_single_user = 0)";
									 
						if (!($result = $db->sql_query($find_group_sql)))
						{
							$error = TRUE;
							$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . GROUPS_TABLE;
						}
						$count = $db->sql_numrows($result);
						$db->sql_freeresult($result);
						
						if ($count == 1) //Is  there exactly one group matching the description - more than one should be impossible anyway
						{					 
							$invite_group_sql = "INSERT INTO " . USER_GROUP_TABLE . 
								"(user_id, group_id, user_pending)
								VALUES ($user_id, ". intval($invite_data['invitation_group']).", 1)";	
						}
							  
						if (!empty($invite_group_sql))
						{
																		//drop a note to the group moderator
							if (!($result_insert = $db->sql_query($invite_group_sql)))
							{
								$error = TRUE;
								$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . GROUPS_TABLE;
							}
							$group_sql = "SELECT u.user_email, u.username, u.user_lang, g.group_name 
								FROM ".USERS_TABLE . " u, " . GROUPS_TABLE . " g 
								WHERE (u.user_id = g.group_moderator) 
								AND (g.group_id = ".intval($invite_data['invitation_group']).")";
							if ( !($group_result = $db->sql_query($group_sql)) )
									{
								message_die(GENERAL_ERROR, "Error getting group moderator data", "", __LINE__, __FILE__, $group_sql);
							}
							$moderator = $db->sql_fetchrow($group_result);   
							$db->sql_freeresult($group_result); 
							//include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
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
								'U_GROUPCP' => $grouplink . '?' . POST_GROUPS_URL . "=".$invite_data['invitation_group']."&amp;validate=true")
							);
							$emailer->send();
							$emailer->reset();	   
									
						}
								
					 }  
				}
				//END Invite Only MOD 
#
#-----[ FIND ]------------------------------------------
#
	$template->assign_block_vars('switch_confirm', array());
}
#
#-----[ AFTER, ADD ]------------------------------------------
#

	//BEGIN Invite Only MOD 
	if (!empty($board_config['invite_only']) && $mode == 'register')
	{
		$template->assign_block_vars('switch_invitation_only', array());
		$invitation_code = ( isset($HTTP_GET_VARS['invite']) ) ? trim($HTTP_GET_VARS['invite']) : ((isset($invitation_code)) ? $invitation_code : ''  ) ;
		$invitation_code = htmlspecialchars($invitation_code); 
		$email = ( isset($HTTP_GET_VARS['email']) ) ? trim($HTTP_GET_VARS['email']) : ((isset($email)) ? $email : ''  ) ;
		$email = htmlspecialchars($email); 
	}  
	//END Invite Only MOD 
#
#-----[ FIND ]------------------------------------------
#
		'CONFIRM_IMG' => $confirm_image, 

#
#-----[ AFTER, ADD ]------------------------------------------
#

		//BEGIN Invite Only MOD 
		'INVITATION' => $invitation_code, 
		//END Invite Only MOD 
#
#-----[ FIND ]------------------------------------------
#
L_EMAIL_ADDRESS' => $lang['Email_address'],
#
#-----[ AFTER, ADD ]------------------------------------------
#

		//BEGIN Invite Only MOD 
		'L_INVITATION' => $lang['Invitation'],
		//END Invite Only MOD						 
 

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
//BEGIN Invite Only MOD
$lang['Invitation_code_invalid'] = 'The entered Invitation Code is invalid';
$lang['Invitation'] = 'Invitation Code';
//END Invite Only MOD

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!
#
#-----[ BEFORE, ADD ]------------------------------------------
#
 

//BEGIN Invite Only MOD
$lang['Invite_only'] = 'Invitation Only';
$lang['Invites_text'] = 'Manage invitation pass codes.';
$lang['Invites_title'] = 'Invitations';

$lang['Show'] ='Show';
$lang['Filter'] ='Filter';
$lang['Show_all'] ='all';
$lang['Active'] ='active';
$lang['Inactive'] ='inactive';

$lang['Invites_description'] = 'Description'; //this just  happens to be identical in English
$lang['Invites_id'] = '#';
$lang['Invites_code'] = 'Passcode';
$lang['Invite_uses_remaining'] ='Uses left';
$lang['Invite_users_used'] ='Users who used this invite';
$lang['Invite_group'] ='Auto-join Group';
$lang['Invite_uses'] ='Uses';
$lang['Invite_uses_explain'] ='Limit the number of users using this invite; \'-1\' for no limit ';
$lang['Infinite'] ='infinite';

$lang['Invite_description'] = 'Description'; 

$lang['Default_invite_subject'] = 'You have been invited to join ';
$lang['Default_invite_message'] = 'Hi, You have been invited to join our community; use the Invitation code  at the end of the message to register at: ';
$lang['Invite_email_sent'] = '<br /> <b>Invite Email sent to:</b> ';

$lang['Add_new_invite'] = 'Generate Invite';
$lang['Add_new_invite_text'] = 'Generate a new invitation passcode. You can also send an invitation e-mail. If you don\'t want to send a mail, then leave the "Recipient" field blank.';
$lang['Invite_email'] = 'Send Invitation E-Mail';
$lang['Edit_invite'] = 'Edit Invite';
$lang['Edit_invite_text'] = 'Edit an existing invitation passcode.';





$lang['Invitation_generated'] = 'A new Invitation Passcode has been generated. Use the following code to register a new user:';
$lang['Must_select_invitation'] = 'You have to select an Invitation';
$lang['Click_return_invite_admin'] = 'Click %sHere%s to return to the Invitation Generation Page.';
$lang['Invitation_updated']='The invitation has been updated.';
$lang['Invite_removed'] ='Invitation deleted';
//END Invite Only MOD

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_groups.php
# 
#-----[ FIND ]------------------------------------------
#
				message_die(GENERAL_ERROR, 'Could not update user_group', '', __LINE__, __FILE__, $sql);
			}
#
#-----[ AFTER, ADD ]------------------------------------------
#

		//BEGIN Invite Only MOD
				//We don't actually have to update the invite to reflect the deletion of the group, but I like my database consistent
		$sql = "UPDATE " . INVITATION_TABLE . "
			SET invitation_group=0
			WHERE (invitation_group = $group_id)";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update invitations', '', __LINE__, __FILE__, $sql);
		}
		//END Invite Only MOD
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php
# 
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT g.group_id 
#
#-----[ BEFORE, ADD ]------------------------------------------
#

			//BEGIN Invite Only MOD
			// The user is no more; we do no longer need his/her invitation info. We couldn't use it anyway
			$sql = "DELETE FROM " . INVITATION_USER_TABLE . "
				WHERE (user_id = $user_id)";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user invitation', '', __LINE__, __FILE__, $sql);
			}
			//END Invite Only MOD

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- END switch_confirm --> 
#
#-----[ AFTER, ADD ]------------------------------------------
#

	<!-- BEGIN switch_invitation_only -->
	<tr>
		<td class="row1"><span class="gen">{L_INVITATION}: * </span><br />
		<td class="row2"><input type="text" class="post" style="width: 200px" name="invitation_code" size="8" maxlength="8" value="{INVITATION}" /></td>
	</tr>
	<!-- END switch_invitation_only -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<td class="row2"><input type="radio" name="require_activation" value="{ACTIVATION_NONE}" {ACTIVATION_NONE_CHECKED} />{L_NONE}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_USER}" {ACTIVATION_USER_CHECKED} />{L_USER}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_ADMIN}" {ACTIVATION_ADMIN_CHECKED} />{L_ADMIN}</td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr>
		<td class="row1">{L_INVITE_ONLY}</td>
		<td class="row2"><input type="radio" name="invite_only" value="1" {INVITATION_ONLY_ENABLE} /> {L_ENABLED}&nbsp;&nbsp;<input type="radio" name="invite_only" value="0" {INVITATION_ONLY_DISABLE} /> {L_DISABLED}</td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM