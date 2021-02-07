############################################################## 
## MOD Title: Change User ID
## MOD Author: kp3011 < asv83.lr4087@gmail.com > (Jisp Cheung) http://269m.no-ip.org/
## MOD Description: This MOD allows the admin to change the user
## ID of any particular user in the admin panel, provided that the
## user ID is not occupied. Simply click into Users Admin and
## change the number.
## MOD Version: 1.0.2
## 
## Installation Level: Easy
## Installation Time: 10 Minutes 
## Files To Edit: /templates/subSilver/admin/user_edit_body.tpl
##      /admin/admin_users.php, 
##      /language/lang_english/lang_admin.php 
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
## If, for any reasons, your member wants to change his user id
## (not his username), you can simply do it for him with this MOD.
##
## To upgrade from 1.0.1 to 1.0.2, please find in admin/admin_users.php :
##
## 	$sql = "UPDATE " . BANLIST_TABLE . " SET ban_userid = $new_user_id WHERE ban_userid = $old_user_id";
##	if( !$result = $db->sql_query($sql) ) {
##		message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
##	}
##
## and then add this afterwards:
##
##	$sql = "UPDATE " . GROUPS_TABLE . " SET group_moderator = $new_user_id WHERE group_moderator = $old_user_id";
##	if( !$result = $db->sql_query($sql) ) {
##		message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
##	}
##
## This can correct the error in the previous version that when
## the user is a group moderator of one or more groups, the user
## ID can be correctly changed. Before applying this correction,
## perhaps the user could not be banned properly because of this.
############################################################## 
## MOD History: 
##   2006-08-10 - Version 1.0.1
##      - Bug fix
## 
##   2006-05-03 - Version 1.0.0
##      - Initial Release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
{L_ITEMS_REQUIRED}

# 
#-----[ FIND ]------------------------------------------ 
# 
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_MEMNUM}: *</span><br />
		<span class="gensmall">{L_MEMNUM_EX}</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="membernum" size="35" maxlength="5" value="{MEM_NUM}" />
	  </td>
	</tr>

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 
		$username = ( !empty($HTTP_POST_VARS['username']) ) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
		$mem_num = ( !empty($HTTP_POST_VARS['membernum']) ) ? intval($HTTP_POST_VARS['membernum'] ) : '';

# 
#-----[ FIND ]------------------------------------------ 
# 
			$username = stripslashes($username);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
			$mem_num = intval(stripslashes($mem_num));

# 
#-----[ FIND ]------------------------------------------ 
# 
		if (stripslashes($username) != $this_userdata['username'])

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
		if ($mem_num != $this_userdata['user_id']) {
			$sql = "SELECT username FROM " . USERS_TABLE .
					" WHERE user_id = '" . $mem_num . "'";
			$result = $db->sql_query($sql);
			$rows = $db->sql_numrows($result);
			if ($rows) {
				message_die(GENERAL_ERROR, $lang['Member_number_exists'], "", __LINE__, __FILE__);
			} else {
				$new_user_id = $mem_num;
				$old_user_id = $this_userdata['user_id'];
				// The new userid is not occupied, so can continue

				$sql = "UPDATE " . BANLIST_TABLE . " SET ban_userid = $new_user_id WHERE ban_userid = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . GROUPS_TABLE . " SET group_moderator = $new_user_id WHERE group_moderator = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . POSTS_TABLE . " SET poster_id = $new_user_id WHERE poster_id = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . PRIVMSGS_TABLE . " SET privmsgs_from_userid = $new_user_id WHERE privmsgs_from_userid = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . PRIVMSGS_TABLE . " SET privmsgs_to_userid = $new_user_id WHERE privmsgs_to_userid = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . SESSIONS_TABLE . " SET session_user_id = $new_user_id WHERE session_user_id = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . SESSIONS_KEYS_TABLE . " SET user_id = $new_user_id WHERE user_id = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . TOPICS_TABLE . " SET topic_poster = $new_user_id WHERE topic_poster = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . TOPICS_WATCH_TABLE . " SET user_id = $new_user_id WHERE user_id = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . USER_GROUP_TABLE . " SET user_id = $new_user_id WHERE user_id = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . USERS_TABLE . " SET user_id = $new_user_id WHERE user_id = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . VOTE_USERS_TABLE . " SET vote_user_id = $new_user_id WHERE vote_user_id = $old_user_id";
				if( !$result = $db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, $lang['Failed2changememno'], "", __LINE__, __FILE__);
				}
			}
		} else {
			$new_user_id = $this_userdata['user_id'];
		}
		$this_userdata = get_userdata($new_user_id);

# 
#-----[ FIND ]------------------------------------------ 
# 
			'USERNAME' => $username,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
			'MEM_NUM' => $user_id,

# 
#-----[ FIND ]------------------------------------------ 
# 
			'L_USERNAME' => $lang['Username'],

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
			'L_MEMNUM' => $lang['Member_number'],
			'L_MEMNUM_EX' => $lang['Member_number_ex'],

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
//
// That's all Folks!
// -------------------------------------------------

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
$lang['Member_number'] = 'User ID';
$lang['Member_number_ex'] = 'If you do not need to change the user ID, please do not change the contents here.';
$lang['Member_number_exists'] = 'The user ID is in use. Please choose another one.';
$lang['Failed2changememno'] = 'Failed to change the user\'s user ID.';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM