##############################################################
## MOD Title: Delete Self Checkbox in Profile
## MOD Author: A_Jelly_Doughnut < support@jd1.clawz.com > (n/a) n/a
## MOD Description: Non-Admin or Moderator Users can delete themselves in their profile
## MOD Version: 1.0.4
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: includes/usercp_register.php, 
##		templates/subSilver/profile_add_body.tpl, 
##		language/lang_english/lang_main.php
## Included Files: (N/A)
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
## Author Notes: I will reiterate that this MOD will not delete users who have admin or mod powers!
##
##############################################################
## MOD History:
##	 2007-10-02
##		- Updated for phpBB 2.0.22
##	 2003-11-27
##		- More MOD Template issues
##	 2003-11-24
##		- 2 more bug fixes
##	 2003-08-13 - Version 1.0.1
##		- MOD Template Issues
##      - Minor bug fix
##   2003-08-21 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#----[ OPEN ]---------------------
#
includes/usercp_register.php

#
#----[ FIND ]---------------------
#
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Session_invalid'];
	}

	$passwd_sql = '';


#
#----[ AFTER, ADD ]---------------
#
	if( isset($HTTP_POST_VARS['deleteuser']) && ( $HTTP_GET_VARS['mode'] == 'editprofile' || $HTTP_POST_VARS['mode'] == 'editprofile' ) && $userdata['user_level'] == USER )
	{
		// user has requested to delete him or herself.  Code borroed from /admin/admin_users.php
		$sql = "SELECT g.group_id 
			FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g  
			WHERE ug.user_id = $user_id 
				AND g.group_id = ug.group_id 
				AND g.group_single_user = 1";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain group information for this user', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
			
		$sql = "UPDATE " . POSTS_TABLE . "
			SET poster_id = " . DELETED . ", post_username = '$username' 
			WHERE poster_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update posts for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . TOPICS_TABLE . "
			SET topic_poster = " . DELETED . " 
			WHERE topic_poster = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics for this user', '', __LINE__, __FILE__, $sql);
		}
			
		$sql = "UPDATE " . VOTE_USERS_TABLE . "
			SET vote_user_id = " . DELETED . "
			WHERE vote_user_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update votes for this user', '', __LINE__, __FILE__, $sql);
		}
			
		$sql = "SELECT group_id
			FROM " . GROUPS_TABLE . "
			WHERE group_moderator = $user_id";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select groups where user was moderator', '', __LINE__, __FILE__, $sql);
		}
			
		while ( $row_group = $db->sql_fetchrow($result) )
		{
			$group_moderator[] = $row_group['group_id'];
		}
			
		if ( count($group_moderator) )
		{
			$update_moderator_id = implode(', ', $group_moderator);

			$sql = 'SELECT user_id FROM ' . USERS_TABLE . '
				WHERE user_level = ' . ADMIN;
			$result = $db->sql_query($sql);

			$row = $db->sql_fetchrow($result); 

			$sql = "UPDATE " . GROUPS_TABLE . "
				SET group_moderator = " . $administrator['user_id'] . '
				WHERE group_moderator = ' . $userdata['user_id'];
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update group moderators', '', __LINE__, __FILE__, $sql);
			}
			$db->sql_freeresult($result);
		}

		$sql = "DELETE FROM " . USERS_TABLE . "
			WHERE user_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . USER_GROUP_TABLE . "
			WHERE user_id = $user_id";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user from user_group table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . GROUPS_TABLE . "
			WHERE group_id = " . $row['group_id'];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
			WHERE group_id = " . $row['group_id'];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
			WHERE user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user from topic watch table', '', __LINE__, __FILE__, $sql);
		}
			
		$sql = "DELETE FROM " . BANLIST_TABLE . "
			WHERE ban_userid = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete user from banlist table', '', __LINE__, __FILE__, $sql);
		}

		// Log User Out
		$sql = "DELETE FROM " . SESSIONS_TABLE . "
			WHERE session_user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete sessions for this user', '', __LINE__, __FILE__, $sql);
		}
			
		$sql = "DELETE FROM " . SESSIONS_KEYS_TABLE . "
			WHERE user_id = $user_id";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not delete auto-login keys for this user', '', __LINE__, __FILE__, $sql);
		}

		$sql = "SELECT privmsgs_id
			FROM " . PRIVMSGS_TABLE . "
			WHERE privmsgs_from_userid = $user_id 
				OR privmsgs_to_userid = $user_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select all users private messages', '', __LINE__, __FILE__, $sql);
		}

		// This little bit of code directly from the private messaging section.
		while ( $row_privmsgs = $db->sql_fetchrow($result) )
		{
			$mark_list[] = $row_privmsgs['privmsgs_id'];
		}
			
		if ( count($mark_list) )
		{
			$delete_sql_id = implode(', ', $mark_list);
			
			$delete_text_sql = "DELETE FROM " . PRIVMSGS_TEXT_TABLE . "
				WHERE privmsgs_text_id IN ($delete_sql_id)";
			$delete_sql = "DELETE FROM " . PRIVMSGS_TABLE . "
				WHERE privmsgs_id IN ($delete_sql_id)";
				
			if ( !$db->sql_query($delete_sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete private message info', '', __LINE__, __FILE__, $delete_sql);
			}
			
			if ( !$db->sql_query($delete_text_sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete private message text', '', __LINE__, __FILE__, $delete_text_sql);
			}
		}

		$message = $lang['User_deleted'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}
	else if(($userdata['user_level'] != USER || $mode != 'editprofile') && $HTTP_POST_VARS['deleteuser'])
	{
		message_die(GENEARL_MESSAGE, $lang['Cannot_delete_self']);
	}

#
#----[ FIND ]-------------------
#
'SMILIES_STATUS' => $smilies_status,

#
#----[ AFTER, ADD ]-------------
#
		'L_DELETE_USER' => $lang['User_delete'],
		'L_DELETE_USER_EXPLAIN' => $lang['User_delete_explain'],		

#
#----[ OPEN ]-------------------
#
templates/subSilver/profile_add_body.tpl

#
#----[ FIND ]-------------------
#
<!-- END switch_avatar_local_gallery -->
<!-- END switch_avatar_block -->

#
#----[ AFTER, ADD ]--------------
#
	<!-- BEGIN switch_edit_profile -->
	<tr> 
		<td class="row1"><span class="gen">{L_DELETE_USER}</span></td>
		<td class="row2"> 
			<input type="checkbox" name="deleteuser" />
			<span class="genmed">{L_DELETE_USER_EXPLAIN}</span>
		</td>
	</tr>
	<!-- END switch_edit_profile -->

#
#----[ OPEN ]-------------------
#
language/lang_english/lang_main.php

#
#----[ FIND ]--------------------
#
?>

#
#----[ BEFORE, ADD ]--------------
#
$lang['User_delete'] = 'Delete Yourself?';
$lang['User_delete_explain'] = 'Click here to delete this yourself; this cannot be undone.';
$lang['User_deleted'] = 'You have been successfully deleted.';
$lang['Cannot_delete_self'] = 'You are not authorized to delete yourself, or you have not completed registration';

# 
#-----[ SAVE/CLOSE ALL FILES ]-------------------------
# 
# EoM