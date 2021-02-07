##############################################################
## MOD Title: Search Usergroups
## MOD Author: tehbmwman < tehbmwman@gmail.com > (N/A) N/A
## MOD Description: Allows searching of users in a usergroup.
## MOD Version: 1.0.3
##
## Installation Level: Easy
## Installation Time: ~5 Minutes
##
## Files To Edit: groupcp.php,
##				  templates/subSilver/groupcp_info_body.tpl,
##				  language/lang_english/lang_main.php
##
## Included Files: N/A
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
## Author Notes: Simple but extremely useful, especially when you
##				 need to remove a user from the group.
##
##				 You will find the search button next to where
##				 a group moderator would see the "Find User" button.
##				 Use an astrisk (*) as the wildcard.
##
##############################################################
## Mod History:
##
## 2-01-06: Version 1.0.0
##		--Initial Submission
##
## 3-13-06: Version 1.0.2
##		--Small Errors Fixed
##
## 3-17-06: Version 1.0.3
##		--One small error fixed
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/groupcp_info_body.tpl
#
#-----[ FIND ]---------------------------------------------
#
		<!-- BEGIN switch_mod_option -->
		<span class="genmed">
#
#-----[ BEFORE, ADD ]-------------------------------------
#
<span class="genmed"><input type="text"  class="post" name="username" value="{U_USERNAME_VALUE}" maxlength="50" size="20" /> 
#
#-----[ IN-LINE FIND ]-------------------------------------
#
<span class="genmed"><input type="text"  class="post" name="username" maxlength="50" size="20" /> 
#
#-----[ IN-LINE REPLACE WITH ]-----------------------------
#
<!-- Username input box was originally here -->
#
#-----[ IN-LINE FIND ]-------------------------------------
#
</span><br /><br />
#
#-----[ IN-LINE REPLACE WITH ]-----------------------------
#
<!-- End of span class and two line breaks originally here -->
#
#-----[ FIND ]---------------------------------------------
#
<!-- END switch_mod_option -->
<span class="nav">
#
#-----[ IN-LINE FIND ]-------------------------------------
#
<span class="nav">
#
#-----[ IN-LINE BEFORE, ADD ]---------------------------------------
#
<input type="submit" name="usersearch" value="{L_SEARCH}" class="liteoption"></span><span class="gensmall"> ({L_WILDCARD})</span><br /><br />

#
#-----[ OPEN ]---------------------------------------------
#
groupcp.php
#
#-----[ FIND ]---------------------------------------------
#
	// Get user information for this group
	//
#
#-----[ AFTER, ADD ]---------------------------------------
#
	$search_wild = '';
	if (isset($HTTP_POST_VARS['usersearch']) || isset($HTTP_GET_VARS['usersearch']))
	{
		if (!empty($HTTP_POST_VARS['username']) || !empty($HTTP_GET_VARS['username']))
		{
		     $usersearchgroup = isset($HTTP_POST_VARS['username']) ? $HTTP_POST_VARS['username'] : $HTTP_GET_VARS['username'];
		     $usersearchgroup = htmlspecialchars($usersearchgroup);
		}
		else
		{
		     message_die(GENERAL_MESSAGE, $lang['No_username']);
		}
		$search_wild = str_replace('*','%',$usersearchgroup);
		
		$searchadd = ' AND u.username LIKE "' . $search_wild . '"';
	}
#
#-----[ FIND ]---------------------------------------------
#
AND ug.user_pending = 0
#
#-----[ IN-LINE FIND ]-------------------------------------
#
0
#
#-----[ IN-LINE AFTER, ADD ]-------------------------------
#
 $searchadd
#
#-----[ FIND ]---------------------------------------------
#
$is_group_pending_member = 0;
#
#-----[ BEFORE, ADD ]--------------------------------------
#
	if (isset($HTTP_POST_VARS['usersearch']) || isset($HTTP_GET_VARS['usersearch']))
	{
		$sql = 'SELECT * FROM ' . USER_GROUP_TABLE . ' WHERE user_id = ' . $userdata['user_id'] . ' AND group_id = ' . $group_info['group_id'];
      if ( !$query = $db->sql_query($sql))
      {
         message_die(GENERAL_ERROR, 'Could not query usergroup table', '', __LINE__, __FILE__, $sql);
      }
		$is_group_member = ($db->sql_numrows($query)) ? TRUE : FALSE;
	}
#
#-----[ FIND ]---------------------------------------------
#
'U_SEARCH_USER'
#
#-----[ AFTER, ADD ]---------------------------------------
#
'U_USERNAME_VALUE' => $usersearchname,
'L_WILDCARD' => $lang['Search_author_explain'],
#
#-----[ FIND ]---------------------------------------------
#
$template->assign_block_vars('switch_no_members', array());
#
#-----[ AFTER, ADD ]---------------------------------------
#
		$lang['No_group_members'] = (isset($HTTP_POST_VARS['usersearch'])) ? $lang['No_usergroup_results'] : $lang['No_group_members'];
#
#-----[ FIND ]---------------------------------------------
#
	$template->assign_vars(array(
		'PAGINATION'
#
#-----[ BEFORE, ADD ]--------------------------------------
#
	$baseurl = (isset($HTTP_POST_VARS['usersearch']) || isset($HTTP_GET_VARS['usersearch'])) ? "groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id&amp;usersearch=true&amp;username=" . $usersearchgroup : "groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id";
#
#-----[ IN-LINE FIND ]-------------------------------------
#
"groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id"
#
#-----[ IN-LINE REPLACE WITH ]-----------------------------
#
$baseurl
#
#-----[ OPEN ]---------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]---------------------------------------------
#
//
// Auth related entries
#
#-----[ BEFORE, ADD ]---------------------------------------
#
//
// Usergroup Search Mod
//
$lang['No_usergroup_results'] = 'No users met your search criteria';
$lang['No_username'] = 'You must enter a username when searching';

#
#-----[ SAVE/CLOSE ALL FILES ]-----------------------------
#
# EoM