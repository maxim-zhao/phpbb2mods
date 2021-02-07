##############################################################
## MOD Title: No doublepost.
## MOD Author: paul999 < webmaster@paulscripts.nl > (paul sohier) http://www.paulscripts.nl
## MOD Description: Users cannot post a message if they has post last in that topic.
## MOD Version: 1.0.1
##
## Installation Level: (Easy)
## Installation Time: 10 Minutes
## Files To Edit: viewtopic.php,
##				posting.php,
##				includes/functions_post.php,
##				language/lang_english/lang_main.php
## Included Files: n/a
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
##############################################################
## MOD History:
##
##   2005-10-29 - Version 1.0.1
##		- Small changes for submitting.
##
##   2005-10-13 - Version 1.0.0
##		- Submitted(No changes :))
##
##   2005-03-20 - Version 0.9.2
##      - Edit some stupid bugs :D.
##
##
##   2005-03-17 - Version 0.9.1
##      - Edit some stupid bugs :D.
##
##
##   2005-03-17 - Version 0.9
##      - first release.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_topics` ADD `topic_last_post_uid` INT( 10 ) NOT NULL ;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('double_post', '0.9.1');

#
#-----[ OPEN ]------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]------------------------------------------
#

$sql = "SELECT t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments" . $count_sql . "
	FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f" . $join_sql_table . "
	WHERE $join_sql
		AND f.forum_id = t.forum_id
		$order_sql";
		
#
#-----[ IN-LINE FIND ]------------------------------------------
#

t.topic_id,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

t.topic_last_post_uid,

#
#-----[ FIND ]------------------------------------------
#

$reply_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $images['reply_locked'] : $images['reply_new'];
$reply_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['Reply_to_topic']

#
#-----[ REPLACE WITH ]------------------------------------------
#
$reply_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED || $forum_topic_data['topic_last_post_uid'] == $userdata['user_id'] ) ? $images['reply_locked'] : $images['reply_new'];
$reply_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED) ? $lang['Topic_locked'] : ($forum_topic_data['topic_last_post_uid'] == $userdata['user_id']) ? $lang['reply_last'] : $lang['Reply_to_topic'];

#
#-----[ OPEN ]------------------------------------------
#

posting.php

#
#-----[ FIND ]------------------------------------------
#

		$sql = "SELECT f.*, t.topic_status, t.topic_title  
			FROM " . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t
			WHERE t.topic_id = $topic_id
				AND f.forum_id = t.forum_id";

#
#-----[ IN-LINE FIND ]------------------------------------------
#

t.topic_status,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

t.topic_last_post_uid,		

#
#-----[ FIND ]------------------------------------------
#
		$sql = "SELECT f.*, t.topic_id, t.topic_status, t.topic_type, t.topic_first_post_id, t.topic_last_post_id, t.topic_vote, p.post_id, p.poster_id" . $select_sql . " 
			FROM " . POSTS_TABLE . " p, " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f" . $from_sql . " 
			WHERE p.post_id = $post_id 
				AND t.topic_id = p.topic_id 
				AND f.forum_id = p.forum_id
				$where_sql";

#
#-----[ IN-LINE FIND ]------------------------------------------
#

t.topic_id,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

t.topic_last_post_uid,			
	

#
#-----[ FIND ]------------------------------------------
#

	else if ( $mode != 'newtopic' && $post_info['topic_status'] == TOPIC_LOCKED && !$is_auth['auth_mod']) 
	{ 
	   message_die(GENERAL_MESSAGE, $lang['Topic_locked']); 
	}

#
#-----[ AFTER, ADD ]------------------------------------------
#

 else if ($mode != 'newtopic' && $mode != 'editpost' && $mode != 'delete' && $mode != 'vote' && $post_info['topic_last_post_uid'] == $userdata['user_id'] && !$is_auth['auth_mod']){
	   message_die(GENERAL_MESSAGE, $lang['reply_last']); 		
	}

#
#-----[ OPEN ]------------------------------------------
#

includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#

		$sql = "UPDATE " . TOPICS_TABLE . " SET 
			$topic_update_sql
			WHERE topic_id = $topic_id";

#
#-----[ IN-LINE FIND ]------------------------------------------
#

$topic_update_sql

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, topic_last_post_uid = " . $user_id . "
			
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

$lang['reply_last'] = 'You have posted the last post at this topic. You cannot post another post before another user has posted.';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 