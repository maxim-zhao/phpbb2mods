############################################################## 
## MOD Title: Invitation Only U2U ("Gmail invites") phpBB.de - Edition 
## MOD Author: Kellanved < kellanved@gmail.com > (available on request) N/A 
## MOD Description:
##	This MOD was submitted to the MOD Contest on  http://www.phpbb.de/.
##	This is an U2U (User to User) Invite mod with a limiting character, as opposed to referral 
##	mods where attracting users is the objective. 
##	
##	
## MOD Version: 1.0.4a
## 
## Installation Level: Intermediate 
## Installation Time: 45 Minutes 
## Files To Edit: 	
##			groupcp.php
##			viewonline.php
##			includes/functions.php, 
##    		includes/constants.php,  
##     		includes/usercp_register.php,
##			includes/page_header.php,
##			templates/subSilver/overall_header.tpl 
##			tenplates/subSilver/groupcp_info_body.tpl
##			templates/subSilver/profile_add_body.tpl
##			templates/subSilver/admin/user_edit_body.tpl
##			admin/admin_users.php
##			admin/admin_groups.php
##			templates/subSilver/admin/group_edit_body.tpl
##
##    
## Included Files:
##			root/invite.php,
##			root/includes/functions_invite.php,
##			root/language/lang_english/lang_invites.php,
##			root/language/lang_english/lang_invites_admin.php,
##			root/language/lang_english/email/admin_send_invite_email.tpl,
##			root/language/lang_english/email/user_send_invite_email.tpl,
##			root/admin/admin_invites.php,
##			root/admin/admin_invites_config.php,
##			root/admin/admin_invites_edit.php,
##			root/admin/admin_invites_list.php,
##			root/templates/subSilver/user_invite_add_body.tpl,
##			root/templates/subSilver/select_invite_role.tpl ,
##			root/templates/subSilver/invitation_only.tpl, 
##			root/templates/subSilver/images/mini_icon_invite.gif,
##			root/templates/subSilver/images/mini_icon_no_invites.gif,
##			root/templates/subSilver/admin/invite_add_body.tpl,
##			root/templates/subSilver/admin/invite_gen_tab2.tpl,
##			root/templates/subSilver/admin/invite_generate.tpl,
##			root/templates/subSilver/admin/invite_list_options.tpl,
##			root/templates/subSilver/admin/invites_config_body.tpl,
##			root/templates/subSilver/admin/invites_list_body.tpl,
##			root/templates/subSilver/admin/invites_list_invited.tpl,
##			root/templates/subSilver/admin/invites_select_body.tpl
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
## Author Notes: 
## Special thanks to the phpbb.de Team for the contest-the mod would not exist without it.
## Also thanks to the phpBB team for obvious reasons and to wGEric for the insert_pm function.
## Please use Easymod for the installation(The SQL part might need manual installation).
## Only tested with MySQL4.
##
##
##
##	User features include:
##		-email invites (with a limited number of invites available)
##		-email invites on behalf of a group(for Group Moderators)
##
##	Admin featurs include:
##		-create invites
##		-explore invites (who was invited by whom)
##		-(re-)send invitation mails
##		-give invites to users (all/group-membes/rank/registration date)
##		-give invites to groups
##		-auto-group members based on their invitation-code(during registration)
##		-invitation settings : off/optional/mandatory
##		-send-invite settings: All/Admins only.
##
##
##	This is an advanced Version of the "Invitation Only" Mod. 
##	While it may look like overkill for small private boards, it still can be set to behave just like "Invitation Only".
##	In fact, this mod should scale better and be easier to maintain, without being harder to install. The main downside 
##	of this mod are the altered tables - "Invitation Only" left the original phpbb tables untouched. 
##	
##	Differences to "Invitation Only"
##	-should be easier to maintain
##	-better Performance in Admin
##	-User to (future) User invites
##	-Invite Explore Mode
##	-Resend emails
##	-auto-activate Group-membership
##	-PM notification about accepted invites
##	-can be set to "optional"
##	-many minor improvements
##
##	Downsides:
##	-less informative invitation list (performance reasons)
##	-Alters user and groups table (I considered only altering the Group table, but that approach didn't scale well)
##	-more changes to templates
##
##
##	What does it NOT ?:
##	-bulk mail.  
##	-link with a cash mod. It has no interface to any cash mod. (feel free to add one ;-) )
##	-invite members already registered into usergroups. 
############################################################## 
## MOD History: 
## 
## 
##	2005-08-01 - Version 0.1.0 
##		- initial English Beta
##	2005-08-02 - Version 0.1.1
##		-Added a link in the groupcp
##	2005-08-02 - Version 0.1.2
##		-initial German Beta
##		-added a few shortcuts
##		-several Bugs fixed (wrong lang fields and a few quirks in the Mod template) .
##	2005-08-13 - Version 1.0.0 RC1
##		-fixed several bugs
##		-moved the invitation use inside the register transaction
##		-the confirmation now gets send, even if sending the mail fails
##		-... a few minor changes.
##	2005-09-15 - Version 1.0.0 RC2
##		- two bugs fixed
##	2005-10-22 - Version 1.0.0 RC3
##		- two bugs fixed
##	2005-12-03 - Version 1.0.0 RC4
##		-minor changes
##	2005-12-07 - Version 1.0.0 RC4b
##		-should resolve problems with the French translation
##	2006-03-6 - Version  RC5 AKA 1.0.3
##		-phpBB 2.0.19 compatibility
##		-several HTML issues
##		-a few SQL issues
##	2006-03-28 - Version 1.0.3a
##		- general clean up, as suggested by Mac (mostly HTML) 
##	2006-06-10 - Version 1.0.4
##		- Fixed pagination on admin list. 
##		- Fixed Link in groupcp. 
##		- Added config setting for confirmation PM. 
##		- Added config setting for confirmation Mail. 
##		- Added config setting for acceptance PM. 
##	2006-07-09 - Version 1.0.4a
##		- Uses a page constant 
##
##
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD.  
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 
CREATE TABLE phpbb_invitations (
	invitation_id MEDIUMINT( 8 ) NOT NULL AUTO_INCREMENT ,
	invitation_code VARCHAR( 8 ) NOT NULL ,
	invitation_description TEXT NOT NULL,
	invitation_uses MEDIUMINT( 8 ) NOT NULL DEFAULT '1',
	invitation_sender MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
	invitation_group MEDIUMINT( 8 ) NOT NULL DEFAULT '0',
	invitation_group_auto_activate TINYINT( 1 ) NOT NULL DEFAULT '0',
	invitation_email TEXT NOT NULL,
	PRIMARY KEY ( invitation_id ) 
);

CREATE TABLE phpbb_invitation_users (
	invitation_id MEDIUMINT( 8 ) NOT NULL,
	user_id MEDIUMINT( 8 ) NOT NULL,	
	PRIMARY KEY ( user_id ) 
);	

INSERT INTO phpbb_config ( config_name , config_value ) 
	VALUES ('invitation_only', '2');
	
INSERT INTO phpbb_config ( config_name , config_value ) 
	VALUES ('invite_u2u', '2');
	
INSERT INTO phpbb_config ( config_name , config_value ) 
	VALUES ('additional_rules', '');
 
INSERT INTO phpbb_config ( config_name , config_value ) 
	VALUES ('send_invit_accept_pm', '1');
	
INSERT INTO phpbb_config ( config_name , config_value ) 
	VALUES ('send_invit_confirm_mail', '1');
 
INSERT INTO phpbb_config ( config_name , config_value ) 
	VALUES ('send_invit_confirm_pm', '1');
	
ALTER TABLE phpbb_users ADD user_invites MEDIUMINT( 8 ) NOT NULL DEFAULT '0';

ALTER TABLE phpbb_groups ADD group_invites MEDIUMINT( 8 ) NOT NULL DEFAULT '0';
	
# 
#-----[ COPY ]------------------------------------------ 
#
copy root/invite.php to invite.php
copy root/includes/functions_invite.php to includes/functions_invite.php
copy root/admin/admin_invites.php to admin/admin_invites.php
copy root/admin/admin_invites_config.php to admin/admin_invites_config.php
copy root/admin/admin_invites_edit.php to admin/admin_invites_edit.php
copy root/admin/admin_invites_list.php to admin/admin_invites_list.php
copy root/language/lang_english/email/admin_send_invite_email.tpl to language/lang_english/email/admin_send_invite_email.tpl 
copy root/language/lang_english/email/user_send_invite_email.tpl to language/lang_english/email/user_send_invite_email.tpl
copy root/templates/subSilver/user_invite_add_body.tpl to templates/subSilver/user_invite_add_body.tpl
copy root/templates/subSilver/invitation_only.tpl to templates/subSilver/invitation_only.tpl
copy root/templates/subSilver/select_invite_role.tpl to templates/subSilver/select_invite_role.tpl 
copy root/templates/subSilver/images/mini_icon_invite.gif to templates/subSilver/images/mini_icon_invite.gif 
copy root/templates/subSilver/images/mini_icon_no_invites.gif to templates/subSilver/images/mini_icon_no_invites.gif
copy root/templates/subSilver/admin/invite_add_body.tpl to templates/subSilver/admin/invite_add_body.tpl
copy root/templates/subSilver/admin/invite_gen_tab2.tpl to templates/subSilver/admin/invite_gen_tab2.tpl
copy root/templates/subSilver/admin/invite_generate.tpl to templates/subSilver/admin/invite_generate.tpl
copy root/templates/subSilver/admin/invite_list_options.tpl to templates/subSilver/admin/invite_list_options.tpl
copy root/templates/subSilver/admin/invites_config_body.tpl to templates/subSilver/admin/invites_config_body.tpl
copy root/templates/subSilver/admin/invites_list_body.tpl to templates/subSilver/admin/invites_list_body.tpl
copy root/templates/subSilver/admin/invites_list_invited.tpl to templates/subSilver/admin/invites_list_invited.tpl
copy root/templates/subSilver/admin/invites_select_body.tpl to templates/subSilver/admin/invites_select_body.tpl
copy root/language/lang_english/lang_invites.php to language/lang_english/lang_invites.php
copy root/language/lang_english/lang_invites_admin.php to language/lang_english/lang_invites_admin.php
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php 
#
#-----[ FIND ]------------------------------------------
#
define('PAGE_TOPIC_OFFSET', 5000);
#
#-----[ AFTER, ADD ]------------------------------------------
#

//BEGIN Invitation Only U2U MOD
define('PAGE_INVITE', -1340);
//END Invitation Only U2U MOD
#
#-----[ FIND ]------------------------------------------
#
define('VOTE_USERS_TABLE', $table_prefix.'vote_voters');
#
#-----[ AFTER, ADD ]------------------------------------------
#

//BEGIN Invitation Only U2U MOD
define('INVITATION_TABLE', $table_prefix.'invitations');
define('INVITATION_USER_TABLE', $table_prefix.'invitation_users');
define('POST_INVITES_URL', 'i');
//END Invitation Only U2U MOD
#
#-----[ OPEN ]------------------------------------------
#
viewonline.php 
#
#-----[ FIND ]------------------------------------------
#
				default:
#
#-----[ BEFORE, ADD ]------------------------------------------
#
				case PAGE_INVITE:
					$location = $lang['Inviting'];
					$location_url = "invite.$phpEx"; 
					break;
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php
#
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

	//BEGIN Invitation Only MOD
	if (!empty($HTTP_GET_VARS['invite'])||!empty($HTTP_POST_VARS['invite']))
	{
		$invite_code = htmlspecialchars((!empty($HTTP_GET_VARS['invite'])) ? $HTTP_GET_VARS['invite'] : $HTTP_POST_VARS['invite']);
		
		$invite_post = "&amp;invite=" .  urlencode($invite_code);
		
	}
	/*we could just as well retrieve the address from the database. But this gets the job done too. 
	(IMHO even better, as it can't be used to leak information))*/
	$email = ( !empty($HTTP_GET_VARS['email']) ) ? "&email=" .  urlencode($HTTP_GET_VARS['email']) :  '';
	$email = trim(htmlspecialchars($email));
	if ($board_config['invitation_only'] == 2 && empty($invite_code))
	{
		include($phpbb_root_path . 'includes/functions_invite.'.$phpEx);	    
		show_invitation_only();
	
	}
	else
	{
	 
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
$invite_post, $email
#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
#
#-----[ BEFORE, ADD ]------------------------------------------
#

}

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

	//BEGIN Invitation Only U2U MOD 
	$invite_data = false; 
	if ($board_config['invitation_only'] !=0 && $mode === 'register') //Let's check the invitation code they sent us
	{
		include($phpbb_root_path . "includes/functions_invite.$phpEx");
		if (empty($invitation_code) && $board_config['invitation_only'] == 2)
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Invitation_code_invalid'];
		}
		if (!empty($invitation_code))
		{
			$invite_data = get_valid_invitation($invitation_code);
			if (!$invite_data)
			{
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Invitation_code_invalid'];
				$invite_data = false; 
			}
		} 
	}
	//END Invitation Only U2U MOD	

#
#-----[ FIND ]------------------------------------------
#
			$email_template = 'user_welcome';
			}

			include($phpbb_root_path . 'includes/emailer.'.$phpEx);			 
#
#-----[ AFTER, ADD ]------------------------------------------
#

			//BEGIN Invitation Only U2U MOD	 
				
			if ($board_config['invitation_only'] && !empty($invite_data) ) //OK, the code was good, let's update the invitation table 
			{  
				use_invite($invite_data, $user_id, $username);
			}
			//END Invitation Only U2U MOD 


#
#-----[ FIND ]------------------------------------------
#
		$template->assign_block_vars('switch_confirm', array());
	}
#
#-----[ AFTER, ADD ]------------------------------------------
#

	//BEGIN Invitation Only U2U MOD 
	if (!empty($board_config['invitation_only']) && $mode == 'register')
	{
		$template->assign_block_vars('switch_invitation_only', array());
		$invitation_code = ( isset($HTTP_GET_VARS['invite']) ) ? trim($HTTP_GET_VARS['invite']) : ((isset($invitation_code)) ? $invitation_code : ''  ) ;
		$invitation_code = htmlspecialchars($invitation_code); 
		$email = ( isset($HTTP_GET_VARS['email']) ) ? trim($HTTP_GET_VARS['email']) : ((isset($email)) ? $email : ''  ) ;
		$email = htmlspecialchars($email); 
		$template->assign_vars(array(
			'INVITATION' => $invitation_code, 
			'L_INVITATION' => $lang['Invitation'],
			'L_INVITATION_EXPLAIN' => ($board_config['invitation_only']==1)? $lang['Invitation_optional'] : $lang['Invitation_mandantory'],
			'INVITATION_REQUIRED' => ($board_config['invitation_only']==2)? '*' : ''
		)); 
	}  
	//END Invitation Only U2U MOD
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($board_config['board_timezone'])];
#
#-----[ AFTER, ADD ]------------------------------------------
#

//BEGIN Invitation Only U2U MOD
if ( $userdata['session_logged_in']  && ($board_config['invite_u2u']))
{
	if ($board_config['invite_u2u'] == 2 || ($board_config['invite_u2u'] == 1 && $userdata['user_invites']))
	{
		if (!$userdata['user_invites'])
		{
			$invites_text = $lang['No_invites'];	   
		} 
		elseif ($userdata['user_invites'] == 1)
		{
			$invites_text = $lang['One_invite_left'];	   
		}
		else
		{
			$invites_text = $userdata['user_invites'] .' '.$lang['Invites_left'];	  
		} 
		 
		$template->assign_block_vars('switch_show_invites', array());
		$template->assign_vars(array(
			'L_INVITE_FRIEND' => $lang['Invite_a_friend'],
			'INVITES_LEFT' => $invites_text,
			'U_INVITE' => append_sid("invite.$phpEx",true)
		));
	}
}
//END Invitation Only U2U MOD
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl 
#
#-----[ FIND ]------------------------------------------
#
<!-- END switch_user_logged_out -->
#
#-----[ AFTER, ADD ]------------------------------------------
#

						<!-- BEGIN switch_show_invites -->
						&nbsp;<a href="{U_INVITE}" class="mainmenu"><img src="templates/subSilver/images/mini_icon_invite.gif" width="12" height="13" border="0" alt="{L_INVITE_FRIEND}" hspace="3" />{L_INVITE_FRIEND}({INVITES_LEFT})</a></span>&nbsp;
						<!-- END switch_show_invites -->
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
		<td class="row1"><span class="gen">{L_INVITATION}: {INVITATION_REQUIRED} </span><br /><span class="gensmall">{L_INVITATION_EXPLAIN}</span></td>
		<td class="row2"><input type="text" class="post" style="width: 200px" name="invitation_code" size="8" maxlength="8" value="{INVITATION}" /></td>
	</tr>
	<!-- END switch_invitation_only -->
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
			//BEGIN Invitation Only U2U MOD
			// The user is no more; we do no longer need his/her invitation info. We couldn't use it anyway
			include($phpbb_root_path . 'includes/functions_invite.'.$phpEx);	    
			delete_user_invites($user_id);
			//END Invitation Only U2U MOD
#			
#-----[ FIND ]------------------------------------------
#
		$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;
#
#-----[ AFTER, ADD ]------------------------------------------
#

		$user_invites = ( !empty($HTTP_POST_VARS['user_invites']) ) ? intval( $HTTP_POST_VARS['user_invites'] ) : 0;
#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) .  
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$avatar_sql . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_invites = $user_invites
#
#-----[ FIND ]------------------------------------------
#
			'L_SELECT_RANK' => $lang['Rank_title'],
#
#-----[ AFTER, ADD ]------------------------------------------
#

			'L_INVITES' => $lang['Invites'],
			'INVITES' => $this_userdata['user_invites'],
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<td class="row2"><select name="user_rank">{RANK_SELECT_BOX}</select></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_INVITES}</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="user_invites" size="5" maxlength="5" value="{INVITES}" />
	  </td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_groups.php
#
#-----[ FIND ]------------------------------------------
#
		'U_SEARCH_USER' => append_sid("../search.$phpEx?mode=searchuser"), 
#
#-----[ AFTER, ADD ]------------------------------------------
#

		'L_INVITES' => $lang['Invites'],
		'INVITES' => $group_info['group_invites'],
#
#-----[ FIND ]------------------------------------------
#
			message_die(GENERAL_ERROR, 'Could not update user_group', '', __LINE__, __FILE__, $sql);
		}
#
#-----[ AFTER, ADD ]------------------------------------------
#

		//BEGIN Invitation Only U2U MOD
				//We don't actually have to update the invite to reflect the deletion of the group, but I like my database consistent
		$sql = "UPDATE " . INVITATION_TABLE . "
			SET invitation_group= 0
			WHERE (invitation_group = $group_id)";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update invitations', '', __LINE__, __FILE__, $sql);
		}
		//END Invitation Only U2U MOD

#
#-----[ FIND ]------------------------------------------
#
		$delete_old_moderator = isset($HTTP_POST_VARS['delete_old_moderator']) ? true : false;
#
#-----[ AFTER, ADD ]------------------------------------------
#

		$group_invites = isset($HTTP_POST_VARS['group_invites']) ? intval($HTTP_POST_VARS['group_invites']) : 0;
#
#-----[ FIND ]------------------------------------------
#
				SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "', group_description = '" . str_replace("\'", "''", $group_description) . "', group_moderator = $group_moderator 
#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_moderator = $group_moderator
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, group_invites = $group_invites
#			
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name, group_description, group_moderator, group_single_user) 
#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_single_user
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, group_invites
#
#-----[ FIND ]------------------------------------------
#
				VALUES ($group_type, '" . str_replace("\'", "''", $group_name) . "', '" . str_replace("\'", "''", $group_description) . "', $group_moderator,	'0')";
#
#-----[ IN-LINE FIND ]------------------------------------------
#
'0'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $group_invites
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/group_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}" {S_GROUP_OPEN_CHECKED} /> {L_GROUP_OPEN} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_CLOSED_TYPE}" {S_GROUP_CLOSED_CHECKED} />	{L_GROUP_CLOSED} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_HIDDEN_TYPE}" {S_GROUP_HIDDEN_CHECKED} />	{L_GROUP_HIDDEN}</td> 
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_INVITES}:</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="group_invites" size="5" maxlength="5" value="{INVITES}" />
	  </td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php
#
#-----[ FIND ]------------------------------------------
#
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#

	if ( file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_invites.'.$phpEx)) )
	{
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_invites.' . $phpEx);
	}
	else
	{
		include($phpbb_root_path . 'language/lang_english/lang_invites.' . $phpEx);
	}
#
#-----[ FIND ]------------------------------------------
#
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#

		if( file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_invites_admin.'.$phpEx)) )
		{
			include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_invites_admin.' . $phpEx);
		}
		else
		{
			include($phpbb_root_path . 'language/lang_english/lang_invites_admin.' . $phpEx);
		}
#
#-----[ OPEN ]------------------------------------------
#
groupcp.php
#
#-----[ FIND ]------------------------------------------
#
		$template->assign_block_vars('switch_add_member', array());
#
#-----[ AFTER, ADD ]------------------------------------------
#

		//BEGIN Invitation Only U2U MOD
		if ($board_config['invite_u2u']==2 || (!empty($group_info['group_invites']) &&$board_config['invite_u2u']==1 ))
		{
			if (empty($group_info['group_invites']))
			{
				$invites_text = $lang['No_invites'];	   
			} 
			elseif ($group_info['group_invites'] == 1)
			{
				$invites_text = $lang['One_invite_left'];	   
			}
			else
			{
				$invites_text = $group_info['group_invites'] .' '.$lang['Invites_left'];	  
			}    
		   
			$template->assign_block_vars('switch_invite_option', array());
			$template->assign_vars(array(
				'L_SEND_INVITE' => $lang['Send_invite'],
				'L_SEND_INVITE_EXPLAIN' => $lang['Group_send_invite_explain'],
				'INVITE_LINK' => append_sid("invite.$phpEx?".POST_GROUPS_URL."=$group_id&amp;mode=group",true),
				'INVITES_LEFT' => $invites_text 
			));
			
		}
		//END Invitation Only U2U MOD
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/groupcp_info_body.tpl
#
#-----[ FIND ]------------------------------------------
#
</table>

{S_HIDDEN_FIELDS}
#
#-----[ BEFORE, ADD ]------------------------------------------
#

	<!-- BEGIN switch_invite_option -->
	<tr> 
		<td class="row1" width="20%"><span class="gen">{L_SEND_INVITE}:</span><br /><span class="gensmall">{L_SEND_INVITE_EXPLAIN}</span></td>
		<td class="row2"><span class="gen"><a href="{INVITE_LINK}">{INVITES_LEFT}</a></span></td>
	</tr>
	<!-- END switch_invite_option -->
	
#	
#-----[ DIY INSTRUCTIONS ]------------------------------------------ 
# 
The default messages can be edited in the $lang files.
In lang_invites.php:
$lang['Invitation_sent_body'] and $lang['Invitation_accepted_body'] contain the automated PMs, 
$lang['Invitation_only_message'] the message displayed on the "Invitation Only" Info page shown to users trying to register.
In lang_invites_admin:
$lang['Invitation_only_message'] contains the default invite-email text.
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM