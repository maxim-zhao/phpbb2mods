############################################################## 
## MOD Title: Moderators in Dropbox
## MOD Author: Luuk < luukweerens@home.nl > (Luuk Weerens) N/A
## MOD Description: This hack puts all moderators in a dropbox on index.php. 
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 1 Minute 
## Files To Edit: index.php
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
##
##     I guess it won't work with the Categories Hierarchy MOD, i didn't test it.
##
############################################################## 
## MOD History:
##  200x-xx-xx - Version 0.0.9
##   - Creating of the MOD
##
##  2006-9-15 - Version 1.0.0
##   - Release for phpBB 2.0.21
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ OPEN ]--------------------------------------------
#
index.php

#
#-----[ FIND ]--------------------------------------------
#
//
// Handle marking posts
//

#
#-----[ BEFORE, ADD ]--------------------------------------
#
if ( isset($HTTP_POST_VARS['moderators']) )
{
    if ( preg_match("/user_/", $HTTP_POST_VARS['moderators']) )
    {
        $user_id = preg_replace("/user_/", "", $HTTP_POST_VARS['moderators']);
        redirect(append_sid("profile.".$phpEx . "?mode=viewprofile&" . POST_USERS_URL . "=" . $user_id));
    }
    else if ( preg_match("/group_/", $HTTP_POST_VARS['moderators']) )
    {
        $group_id = preg_replace("/group_/", "", $HTTP_POST_VARS['moderators']);
        redirect(append_sid("groupcp.".$phpEx . "?" . POST_GROUPS_URL . "=" . $group_id));
    }
}

#
#-----[ FIND ]--------------------------------------------
#
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';
	}

#
#-----[ REPLACE WITH ]--------------------------------------
#
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = $row;
	}

#
#-----[ FIND ]--------------------------------------------
#
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
	}

#
#-----[ REPLACE WITH ]-------------------------------------
#
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = $row;
	}

#
#-----[ FIND ]--------------------------------------------
#
							if ( count($forum_moderators[$forum_id]) > 0 )
							{
								$l_moderators = ( count($forum_moderators[$forum_id]) == 1 ) ? $lang['Moderator'] : $lang['Moderators'];
								$moderator_list = implode(', ', $forum_moderators[$forum_id]);
							}

#
#-----[ REPLACE WITH ]--------------------------------------
#
							if ( count($forum_moderators[$forum_id]) > 0 )
							{
								$l_moderators = '&nbsp;';

								$moderator_list = '<form method="post" name="moderators_' . $forum_id . '" action="' . append_sid("index." . $phpEx) . '" onSubmit="if(document.moderators_' . $forum_id . '.moderators.value == -1){return false;}">';
								$moderator_list .= '<select name="moderators" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'moderators_' . $forum_id . '\'].submit() }">';
								$moderator_list .= '<option value="-1" selected="selected">' . ( ( count($forum_moderators[$forum_id]) == 1 ) ? $lang['Moderator'] : $lang['Moderators'] ) . '</option>';
								$moderator_list .= '<option value="-1">----------------</option>';
								for($k = 0; $k < count($forum_moderators[$forum_id]); $k++)
								{
								    if ( $forum_moderators[$forum_id][$k]['user_id'] )
									{
									    $moderator_list .= '<option value="user_' . $forum_moderators[$forum_id][$k]['user_id'] . '">' . $forum_moderators[$forum_id][$k]['username'] . '</option>';
									}
									else if ( $forum_moderators[$forum_id][$k]['group_id'] )
									{
									    $moderator_list .= '<option value="group_' . $forum_moderators[$forum_id][$k]['group_id'] . '">' . $forum_moderators[$forum_id][$k]['group_name'] . '</option>';
									}
								}
								$moderator_list .= '</select>';
								$moderator_list .= '</form>';
							}

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 