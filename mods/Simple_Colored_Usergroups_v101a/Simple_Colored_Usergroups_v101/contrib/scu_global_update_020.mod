##############################################################
## MOD Title: Simple Colored Usergroups Global Coloring Addon Update
## MOD Author: kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
## MOD Description: Colors all areas of the site instead of just the online list.
## MOD Version: 0.1.0
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: index.php
##                viewforum.php
##                privmsg.php
##
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
##	Author Notes: 
##		For the people who like everywhere colored.
##############################################################
## MOD History:
## 
##	2006-07-21 - Version 0.1.0
##		-	added new coloring to privmsg.php, viewforum.php, and index.php
## 
##	2006-07-21 - Version 0.2.1
##		-	forgot # after color: 
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------
#
	$moderators[] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	$mod_color = ($user_color = color_groups_user($row['user_id'])) ? 'style="font-weight:bold;color: #' . $user_color . '" ' : '';

#
#-----[ IN-LINE FIND ]------------------------------------------
#
href="

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
' . $mod_color . '

#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT g.group_id, g.group_name 

#
#-----[ IN-LINE FIND ]------------------------------------------
#
g.group_name

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, g.group_colors

#
#-----[ FIND ]------------------------------------------
#
	$moderators[] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// unserialize group color
	$row_group_colors = unserialize( $row['group_colors'] );
	
	// get color for current style
	if ( ! $userdata['session_logged_in'] )
	{
		$group_color = $row_group_colors[ $board_config['default_style'] ];
	}
	else
	{
		$group_color = $row_group_colors[ $userdata['user_style'] ];
	}
	
	$mod_group_color = ( !empty( $group_color ) ) ? 'style="font-weight:bold;color: #' . $group_color . '" ' : '';

#
#-----[ IN-LINE FIND ]------------------------------------------
#
href="

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
' . $mod_group_color . '

#
#-----[ FIND ]------------------------------------------
#
		$topic_author = ( $topic_rowset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $topic_rowset[$i]['user_id']) . '">' : '';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		$author_color = ($user_color = color_groups_user($topic_rowset[$i]['user_id'])) ? 'style="font-weight:bold;color: #' . $user_color . '" ' : '';

#
#-----[ IN-LINE FIND ]------------------------------------------
#
href="

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
' . $author_color . '

#
#-----[ FIND ]------------------------------------------
#
		$last_post_author = ( $topic_rowset[$i]['id2'] == ANONYMOUS ) ? ( ($topic_rowset[$i]['post_username2'] != '' ) ? $topic_rowset[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $topic_rowset[$i]['id2']) . '">' . $topic_rowset[$i]['user2'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		$last_post_author_color = ($user_color = color_groups_user($topic_rowset[$i]['id2'])) ? 'style="font-weight:bold;color: #' . $user_color . '" ' : '';

#
#-----[ IN-LINE FIND ]------------------------------------------
#
href="

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
' . $last_post_author_color . '

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php

#
#-----[ FIND ]------------------------------------------
#
		$u_from_user_profile = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$msg_userid");

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	$u_from_user_color = ($user_color = color_groups_user($msg_userid)) ? 'style="font-weight:bold;color: #' . $user_color . '" ' : '';

#
#-----[ FIND ]------------------------------------------
#
			'U_FROM_USER_PROFILE' => $u_from_user_profile)

#
#-----[ BEFORE, ADD ]------------------------------------------
#
			'U_FROM_USER_COLOR' => $u_from_user_color,

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/privmsgs_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	  <td width="20%" valign="middle" align="center" class="{listrow.ROW_CLASS}"><span class="name">&nbsp;<a href="{listrow.U_FROM_USER_PROFILE}" class
  
#
#-----[ IN-LINE FIND ]------------------------------------------
#
href="

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
{listrow.U_FROM_USER_COLOR}

#
#-----[ OPEN ]------------------------------------------
#
index.php
#
#-----[ FIND ]------------------------------------------
#
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	$mod_color = ($user_color = color_groups_user($row['user_id'])) ? 'style="font-weight:bold;color: #' . $user_color . '" ' : '';

#
#-----[ IN-LINE FIND ]------------------------------------------
#
href="

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
' . $mod_color . '

#
#-----[ FIND ]------------------------------------------
#
	$sql = "SELECT aa.forum_id, g.group_id, g.group_name 

#
#-----[ IN-LINE FIND ]------------------------------------------
#
g.group_name

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, g.group_colors

#
#-----[ FIND ]------------------------------------------
#
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	$mod_group_color = ( !empty( $row['group_colors'] ) ) ? 'style="font-weight:bold;color: #' . unserialize($row['group_colors']) . '" ' : '';

#
#-----[ IN-LINE FIND ]------------------------------------------
#
href="

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
' . $mod_group_color . '

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM