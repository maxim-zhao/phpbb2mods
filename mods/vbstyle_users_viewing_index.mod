#################################################################
## MOD Title: Users viewing forum on Index
## MOD Author: Eminem_Fan < N/A > (Dean Oakes) N/A
## MOD Description: This modification will add the 'vBulletin Style' Users viewing this forum to the index.
## MOD Version: 1.1.0
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit:	index.php
##					language/lang_english/lang_main.php
##					templates/subSilver/index_body.tpl
## Included Files:	N/A
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
##	As requested by oo1985, This feature can be found in vBulletin.
##############################################################
## MOD History:
##
##	2005-26-12 - Version 0.1.0
##	-	Stable Release
##
##	2005-27-12 - Version 1.0.0
##	-	Submitted to the MOD-DB.
##
##	2006-07-01 - Version 1.1.0
##	-	Fixed up the mod template and resubmitted.
## 
#################################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
#################################################################

#
#-----[ OPEN ]------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------
#
	$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forum_data);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	//
	// Get the user count viewing the forums.
	//
	$forum_view_count = array();
	$sql = "SELECT u.user_id, s.session_page
		FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
			WHERE u.user_id = s.session_user_id
				AND s.session_time >= ".( time() - 300 ); 
	if(! $result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Unable to get current sessions for users viewing forum.', '', __LINE__, __FILE__, $sql);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		if(! isset($forum_view_count[ $row['session_page'] ]) )
		{
			$forum_view_count[ $row['session_page'] ] = 0;
		}
		$forum_view_count[ $row['session_page'] ]++;
	}
#
#-----[ FIND ]------------------------------------------
#
'L_ONLINE_EXPLAIN' =>

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_USERS_VIEWING' => $lang['users_viewing_forum'],

#
#-----[ FIND ]------------------------------------------
#
$row_class = ( !($i % 2) ) ?

#
#-----[ AFTER, ADD ]------------------------------------------
#
$users_viewing = $forum_view_count[$forum_data[$j]['forum_id']];

#
#-----[ FIND ]------------------------------------------
#
'MODERATORS' =>

#
#-----[ AFTER, ADD ]------------------------------------------
#
								'USERS_VIEWING' => $users_viewing,

#
#-----[ FIND ]------------------------------------------
#
								'U_VIEWFORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"))
							);

#
#-----[ AFTER, ADD ]------------------------------------------
#
							if($users_viewing)
							{
								$template->assign_block_vars('catrow.forumrow.switch_users_viewing', array());
							}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['users_viewing_forum'] = 'Viewing';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	</span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />

#
#-----[ REPLACE WITH ]------------------------------------------
#
	</span><span class="gensmall">
	<!-- BEGIN switch_users_viewing -->
	({catrow.forumrow.USERS_VIEWING} {L_USERS_VIEWING})
	<!-- END switch_users_viewing -->
	</span> <span class="genmed"><br />{catrow.forumrow.FORUM_DESC}<br />

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM