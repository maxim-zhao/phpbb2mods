##############################################################
## MOD Title: Invisible replies until replied
## MOD Author: Lord Le Brand < lordlebrand@hotmail.com > (N/A) N/A
## MOD Description: This MOD makes replies invisible to a user until the user makes
##                   a reply in topics which have set 'Replies invisible'. Who can
##                   set replies invisible, is set per forum with the permissions
##                   page in the Admin Control Panel.
## MOD Version: 1.2.2
##
## Installation Level: Intermediate
## Installation Time: 20 Minutes
## Files To Edit: posting.php,
##                viewtopic.php,
##                admin/admin_forumauth.php,
##                admin/admin_ug_auth.php,
##                includes/auth.php,
##                includes/constants.php,
##                includes/functions.php,
##                includes/functions_post.php,
##                includes/topic_review.php,
##                language/lang_english/lang_admin.php,
##                templates/subSilver/posting_body.tpl
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
##    The MOD is based on the request made by ScienceTeacher in this thread:
##        http://www.phpbb.com/phpBB/viewtopic.php?t=396216
##
##    Before installing his MOD you should make a backup of all files and the database
##
##############################################################
## MOD History:
##
##   2007-02-04 - Version 1.2.2
##      - Topic review fixed
##      - Pagination fixed
##
##   2006-11-11 - Version 1.2.1
##      - Typos...
##
##   2006-10-19 - Version 1.2.0
##      - Fixed post editing
##
##   2006-09-16 - Version 1.1.1
##      - Fixed function
##      - Fixed so it supports editpost
##
##   2006-09-14 - Version 1.1.0
##      - Fixed after getting denied
##      - Changed the way it saves user in db
##      - Added function to verify user can see replies [ can_seereplies($user_id, $topic_id) ]
##
##   2006-09-10 - Version 1.0.0
##      - Fixed minor MOD template flaws
##      - Submitted to database
##
##   2006-09-09 - Version 0.5.2
##      - Forgot explode() and one $is_auth
##      - Cleaned code for queries in viewtopic.php and includes/topic_review.php
##
##   2006-09-08 - Version 0.5.1
##      - Fixed MOD code to do what it should do
##
##   2006-09-08 - Version 0.5.0
##      - Added auth setting for who can set Invisible replies (default moderator)
##      - Fixed bug that allowed viewing (individual) replies by adding &start=x to the url
##      - Beta release
##
##   2006-09-05 - Version 0.4.0
##      - Changed to per topic specification
##      - Changed auth info to topic-side information
##      - Deletion now supported (because of topic-side info)
##      - Database tables changed
##
##   2006-06-11 - Version 0.3.0
##      - Rewrote comparing 0.1.1 and 0.2.0
##      - Alpha-release
##
##   2006-06-11 - Version 0.2.0
##      - Deleted useless codechanges
##      - Fixed wrong OPEN command
##      - Fixed side-effects
##
##   2006-06-08 - Version 0.1.1
##      - No more changing simple auths
##      - Replaced TINYINT by SMALLINT
##
##   2006-06-07 - Version 0.1.0
##      - look up changes in files
##      - Pre-Alpha release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_auth_access` ADD `auth_invis_reply` TINYINT(2) DEFAULT '0' NOT NULL;
ALTER TABLE `phpbb_forums` ADD `auth_invis_reply` TINYINT(2) DEFAULT '0' NOT NULL;
ALTER TABLE `phpbb_topics` ADD `no_seereply` TINYINT(1) DEFAULT '0' NOT NULL;
CREATE TABLE `phpbb_topics_replied` (topic_id mediumint(8) DEFAULT '0' NOT NULL, user_replied mediumint(8) DEFAULT '0' NOT NULL);

#
#-----[ OPEN ]------------------------------------------
#
posting.php

#
#-----[ FIND ]------------------------------------------
#
			$bbcode_uid = '';
	
#
#-----[ AFTER, ADD ]------------------------------------------
#
			// Begin MOD: Invisible replies until replied
			$no_seereply = ( $HTTP_POST_VARS['no_seereply'] == 1 || $HTTP_POST_VARS['no_seereply'] == 'on' ) ? 1 : 0;
			// End MOD: Invisible replies until replied

#
#-----[ FIND ]------------------------------------------
#
				submit_post($mode

#
#-----[ IN-LINE FIND ]------------------------------------------
#
);

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, $no_seereply

#
#-----[ FIND ]------------------------------------------
#
	$template->assign_block_vars('switch_type_toggle', array());
	
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Begin MOD: Invisible replies until replied
	if ( $is_auth['auth_invis_reply'] )
	{
		$template->assign_block_vars('switch_seereply_checkbox', array());
	}
	// End MOD: Invisible replies until replied

#
#-----[ FIND ]------------------------------------------
#
	'L_DELETE_POST' => $lang['Delete_post'],
	
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_NO_SEEREPLY' => $lang['No_seereply'],

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT u.username, u.user_id,

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Begin MOD: Invisible replies until replied
if ( ! can_seereplies($userdata['user_id'], $topic_id) )
{
	$start = 0;
	$limit = 1;
	$post_time_order = 'ASC';
}
else
{
	$limit = $board_config['posts_per_page'];
}
// End MOD: Invisible replies until replied

#
#-----[ FIND ]------------------------------------------
#
	LIMIT $start, ".$board_config['posts_per_page'];

#
#-----[ REPLACE WITH ]------------------------------------------
#
	LIMIT $start, $limit";

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_forumauth.php

#
#-----[ FIND ]------------------------------------------
#
	0  => array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
),

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, AUTH_MOD

#
#-----[ FIND ]------------------------------------------
#
	1  => array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
),

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, AUTH_MOD

#
#-----[ FIND ]------------------------------------------
#	
	2  => array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
),

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, AUTH_MOD

#
#-----[ FIND ]------------------------------------------
#	
	3  => array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
),

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, AUTH_MOD

#
#-----[ FIND ]------------------------------------------
#	
	4  => array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
),

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, AUTH_MOD

#
#-----[ FIND ]------------------------------------------
#	
	5  => array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
),

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, AUTH_MOD

#
#-----[ FIND ]------------------------------------------
#	
	6  => array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
),

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, AUTH_MOD

#
#-----[ FIND ]------------------------------------------
#
$forum_auth_fields = array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
);

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, 'auth_invis_reply'

#
#-----[ FIND ]------------------------------------------
#
	'auth_pollcreate' => $lang['Pollcreate']);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	'auth_invis_reply' => $lang['Invis_reply'],

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_ug_auth.php

#
#-----[ FIND ]------------------------------------------
#
$forum_auth_fields = array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
);

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, 'auth_invis_reply'

#
#-----[ FIND ]------------------------------------------
#
	'auth_pollcreate' => AUTH_POLLCREATE);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	'auth_invis_reply' => AUTH_INVIS_REPLY,

#
#-----[ FIND ]------------------------------------------
#
	'auth_pollcreate' => $lang['Pollcreate']);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	'auth_invis_reply' => $lang['Invis_reply'],

#
#-----[ OPEN ]------------------------------------------
#
includes/auth.php

#
#-----[ FIND ]------------------------------------------
#
			$a_sql = 'a.auth_view, a.auth_read,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
a.auth_pollcreate

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, a.auth_invis_reply

#
#-----[ FIND ]------------------------------------------
#
			$auth_fields = array('auth_view', 'auth_read',

#
#-----[ IN-LINE FIND ]------------------------------------------
#
'auth_pollcreate'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'auth_invis_reply'

#
#-----[ FIND ]------------------------------------------
#
		case AUTH_DELETE:
			$a_sql = 'a.auth_delete';
			$auth_fields = array('auth_delete');
			break;

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Begin MOD: Invisible replies until replied
		case AUTH_INVIS_REPLY:
			$a_sql = 'a.auth_invis_reply';
			$auth_fields = array('auth_invis_reply');
		break;
		// End MOD: Invisible replies until replied
		
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Begin MOD: Invisible replies until replied
define('AUTH_INVIS_REPLY', 150);
define('TOPICS_REPLIED_TABLE', $table_prefix.'topics_replied');
// End MOD: Invisible replies until replied

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Begin MOD: Invisible replies until replied
function can_seereplies($user_id, $topic_id)
{
	global $db;
	global $userdata, $is_auth;
	
	$sql = "SELECT topic_id, no_seereply
		FROM " . TOPICS_TABLE . "
		WHERE topic_id = $topic_id";
			
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
	}

	$see_reply_row = $db->sql_fetchrow($result);
	
	if ( $see_reply_row['no_seereply'] == 1 )
	{
		if ( !$userdata['session_logged_in'] )
		{
			return false;
		}
		
		$sql = "SELECT t.topic_id, t.no_seereply, r.user_replied, r.topic_id
			FROM " . TOPICS_TABLE . " t, " . TOPICS_REPLIED_TABLE . " r
			WHERE t.topic_id = $topic_id
				AND r.topic_id = t.topic_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
		}
	
		$see_reply = array();
	
		while ( $row = $db->sql_fetchrow($result) )
		{
			$see_reply[] = $row;
		}
		
		if ( ! count($see_reply) )
		{
			return false;
		}
	
		for ( $i = 0; $i < count($see_reply); $i++ )
		{
			if ( $see_reply[$i]['no_seereply'] )
			{
				if ( !$see_reply[$i]['user_replied'] )
				{
					return false;
				}
				elseif ( $see_reply[$i]['user_replied'] == $user_id )
				{
					return true;
				}
			}
		}
		
		return false;
	}
	else
	{
		return true;
	}
}
// End MOD: Invisible replies until replied

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#
function submit_post($mode

#
#-----[ IN-LINE FIND ]------------------------------------------
#
)

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, $no_seereply

#
#-----[ FIND ]------------------------------------------
#	
$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE . "

#
#-----[ IN-LINE FIND ]------------------------------------------
#
topic_type, topic_vote

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, no_seereply

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$topic_type, $topic_vote

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $no_seereply

#
#-----[ IN-LINE FIND ]------------------------------------------
#
topic_vote = " . $topic_vote : "") . "

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, no_seereply = $no_seereply

#
#-----[ FIND ]------------------------------------------
#
	if ($mode != 'poll_delete')
	{
		$sql = "UPDATE " . USERS_TABLE . "
			SET user_posts = user_posts $sign 
			WHERE user_id = $user_id";
		if (!$db->sql_query($sql, END_TRANSACTION))
		{
			message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
		}
	}

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Begin MOD: Invisible replies until replied
	if ( $mode == 'reply' || $mode == 'newtopic' )
	{
		if ( ! can_seereplies($user_id, $topic_id) )
		{
			$sql = "INSERT INTO " . TOPICS_REPLIED_TABLE . " (topic_id, user_replied) VALUES ($topic_id, $user_id)";
			if ( ! $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
			}
		}
	}
	// End MOD: Invisible replies until replied

#
#-----[ FIND ]------------------------------------------
#
				$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}

#
#-----[ AFTER, ADD ]------------------------------------------
#
				// Begin MOD: Invisible replies until replied
				$sql = "DELETE FROM " . TOPICS_REPLIED_TABLE . "
					WHERE topic_id = $topic_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}
				// End MOD: Invisible replies until replied
#
#-----[ OPEN ]------------------------------------------
#
includes/topic_review.php

#
#-----[ FIND ]------------------------------------------
#
	$sql = "SELECT u.username, u.user_id,

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Begin MOD: Invisible replies until replied
	if ( ! can_seereplies($userdata['user_id'], $topic_id) )
	{
		$order = 'ASC';
		$limit = 1;
	}
	else
	{
		$order = 'DESC';
		$limit = $board_config['posts_per_page'];
	}
	// End MOD: Invisible replies until replied

#
#-----[ FIND ]------------------------------------------
#
		ORDER BY p.post_time DESC

#
#-----[ IN-LINE FIND ]------------------------------------------
#
DESC

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$order

#
#-----[ FIND ]------------------------------------------
#
		LIMIT " . $board_config['posts_per_page'];

#
#-----[ REPLACE WITH ]------------------------------------------
#
		LIMIT $limit";

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
// Begin MOD: Invisible replies until replied
$lang['No_seereply'] = 'Make replies invisible for user who haven\'t posted in this topic';
$lang['Invis_reply'] = 'Invisible replies';
// End MOD: Invisible replies until replied

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		  <!-- END switch_delete_checkbox -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
		  <!-- // Begin MOD: Invisible replies until replied -->
		  <!-- BEGIN switch_seereply_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="no_seereply" />
			</td>
			<td><span class="gen">{L_NO_SEEREPLY}</span></td>
		  </tr>
		  <!-- END switch_seereply_checkbox -->
		  <!-- // End MOD: Invisible replies until replied -->


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM