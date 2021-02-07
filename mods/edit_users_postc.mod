##############################################################
## MOD Title: Edit User's Postcount
## MOD Author: tomlevens < tom@tomlevens.co.uk > (Tom Levens) N/A
## MOD Description: This MOD enables you to change a user's postcount through the admin panel. 
## MOD Version: 1.0.3
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## Files To Edit: admin/admin_users.php
##                templates/subSilver/admin/user_edit_body.tpl
##                language/lang_english/lang_admin.php
##                includes/functions.php (Optional)
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
#############################################################
## Author Notes: 
##
##  This MOD adds a field to the user management section of the admin panel
##  which enables you to change a user's postcount to any value.
##
##  Optional Edit (includes/functions.php):
##
##   This is a feature requested by prophetUK on the forums at phpbb.com. If you 
##   apply this step the total posts statistic on the forum index will
##   increase/decrease as you modify postcounts. By default phpBB bases this
##   statistic on the actual number of posts in the database, but having it
##   based on all your users' combined postcounts could be desireable. Please 
##   make a judgement on how you wish to have this statistic calculated, and
##   apply the final step if you desire.
##############################################################
## MOD History: 
## 
##  2004-01-26 - Version 1.0.0
##   - Initial Release
##
##  2004-01-26 - Version 1.0.1
##   - I had put the name of the wrong MOD in the comments... oops! 
##
##  2006-11-23 - Version 1.0.2
##   - Added an optional step to change the behaviour of the total posts 
##     statistic - as requested by prophetUK
##
##  2007-02-06 - Version 1.0.3
##   - Added a function to recalculate the user's real postcount (i.e. the 
##     actual number of posts that user has made) - as requested by adk_tj
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#
		$user_allowpm = ( !empty($HTTP_POST_VARS['user_allowpm']) ) ? intval( $HTTP_POST_VARS['user_allowpm'] ) : 0;

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// MOD: Edit User's Post Count - by tomlevens
		// (1 line added)
		//
		$user_posts = ( !empty($HTTP_POST_VARS['user_posts']) ) ? intval( $HTTP_POST_VARS['user_posts'] ) : 0;
		//
		// END MOD

#
#-----[ FIND ]------------------------------------------
#
			$sql = "UPDATE " . USERS_TABLE . "
				SET

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_allow_pm = $user_allowpm

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_posts = $user_posts

#
#-----[ FIND ]------------------------------------------
#
		$user_allowpm = $this_userdata['user_allow_pm'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// MOD: Edit User's Post Count - by tomlevens
		// (10 lines added)
		//
		$sql = "SELECT *
				FROM " . POSTS_TABLE ."
				WHERE poster_id = " . $this_userdata['user_id'];

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not count user\'s posts', '', __LINE__, __FILE__, $sql);
		}

		$posts = $this_userdata['user_posts'];
		$posts_counted = $db->sql_numrows($result);
		//
		// END MOD

#
#-----[ FIND ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="user_allowpm" value="' . $user_allowpm . '" />';

#
#-----[ AFTER, ADD ]------------------------------------------
#
			// MOD: Edit User's Post Count - by tomlevens
			// (1 line added)
			//
			$s_hidden_fields .= '<input type="hidden" name="user_posts" value="' . $user_posts . '" />';
			//
			// END MOD

#
#-----[ FIND ]------------------------------------------
#
			'RANK_SELECT_BOX' => $rank_select_box,

#
#-----[ AFTER, ADD ]------------------------------------------
#
			// MOD: Edit User's Post Count - by tomlevens
			// (4 lines added)
			//
			'POSTS' => $posts,
			'POSTS_COUNTED' => $posts_counted,

			'L_POSTS' => $lang['Posts'],
			'L_POSTS_RECOUNT' => $lang['Recount_posts'],
			//
			// END MOD

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['User_allowavatar'] = 'Can display avatar';

#
#-----[ AFTER, ADD ]------------------------------------------
#
// MOD: Edit User's Post Count - by tomlevens
// (1 line added)
//
$lang['Recount_posts'] = 'Recount posts';
//
// END MOD

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
# NOTE: You will need to repeat this step for every template installed.
# 
	<tr>
		<td class="row1"><span class="gen">{L_SELECT_RANK}</span></td>
		<td class="row2"><select name="user_rank">{RANK_SELECT_BOX}</select></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<script language="Javascript" type="text/javascript">
		<!--
			function posts(posts) {
				document.forms[0].user_posts.value = posts;
			}
		// -->
		</script>
		<td class="row1"><span class="gen">{L_POSTS}</span></td>
		<td class="row2"><input class="post" type="text" name="user_posts" size="5" style="width: 50px" value="{POSTS}"  />
		<br /><span class="gensmall"><a href="javascript:posts({POSTS_COUNTED});">{L_POSTS_RECOUNT}</a></span></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
# NOTE: This step is entirely optional - please see the Author Notes at the top of this file
# for full details of what it does.
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
		case 'postcount':
		case 'topiccount':
			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
			break;

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
		// MOD: Edit User's Post Count - by tomlevens
		// (5 lines replaced - original lines follow)
		//
		//	case 'postcount':
		//	case 'topiccount':
		//	$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
		// 		FROM " . FORUMS_TABLE;
		//	break;
		//
		case 'postcount':
			$sql = "SELECT SUM(user_posts) AS post_total
				FROM " . USERS_TABLE;
			break;
		case 'topiccount':
			$sql = "SELECT SUM(forum_topics) AS topic_total
				FROM " . FORUMS_TABLE;
			break;
		//
		// END MOD

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 