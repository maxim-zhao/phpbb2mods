############################################################## 
## MOD Title: Mark Topics Unread
## MOD Author: Noobarmy < noobarmy@phpbbmodders.net > (Anthony Chu) http://phpbbmodders.net
## MOD Description: Allows users to mark topics as unread
## MOD Version: 1.0.3
## 
## Installation Level: Easy
## Installation Time: 3 Minutes 
## Files To Edit: 
##		viewtopic.php
##
##		language/lang_english/lang_main.php
##
##		templates/subSilver/viewtopic_body.tpl
##
## Included Files:
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
## 
############################################################## 
## MOD History: 
## 
## 	2006-10-26 - Version 1.0.3
##		-	Fixed error with lang vars
##
## 	2006-10-26 - Version 1.0.0
##		-	Took the idea from a request
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 
//
// Start initial var setup
//

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
/* Begin : Mark Topic Unread MOD */

$topic_mark_unread_id = ( $HTTP_GET_VARS['mark'] == 'unread' && $HTTP_GET_VARS[POST_TOPIC_URL] > 0 ) ? intval($HTTP_GET_VARS[POST_TOPIC_URL]) : 0;

if ( $topic_mark_unread_id > 0 )
{
	/* Grab what we need off the database. */
	$sql = 'SELECT p.post_time
			FROM ' . POSTS_TABLE . ' p, ' . TOPICS_TABLE . " t
			WHERE t.topic_last_post_id = p.post_id
				AND t.topic_id = $topic_mark_unread_id";

	if ( !$result = $db->sql_query($sql) )
	{
		$message = array ( 'error_key' => 'error_obtaining_post_data',
					'line' => __LINE__,
					'file' => __FILE__,
					'sql' => $sql);
	}

	if ( !$row = $db->sql_fetchrow($result) )
	{
		$message = array ( 'error_key' => 'error_obtaining_post_data',
					'line' => __LINE__,
					'file' => __FILE__,
					'sql' => $sql);
	}

	if ( !isset($message) )
	{
		/* Crate the new time */
		$new_time = $row['post_time'] - 1;
	
		/* Set cookie with new data */
		$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ?  unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : array();
		$tracking_topics[$topic_mark_unread_id] = $new_time;
	
		if ( setcookie($board_config['cookie_name'] . '_t', serialize($tracking_topics), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']) )
		{
			$message = array ( 'message_key' => 'Topic_Marked_Unread');
		}
		else
		{
			$message = array ( 'error_key' => 'error_marking_topic_unread');
		}
	}
}

/* END : Mark Topic Unread MOD */

# 
#-----[ FIND ]------------------------------------------ 
# 
//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
/* BEGIN : Mark Topic Unread MOD */
/**
 * We have to declare any messages here
 * because we need the language vars
 * loaded.
 * This is the only way i saw fit to 
 * do it
 */
if ( $topic_mark_unread_id > 0 && isset($message) )
{
	if ( isset($message['sql']) && isset($message['file']) && isset($message['line']) )
	{
		message_die(GENERAL_ERROR, $lang[$message['error_key']], '', $message['line'],$message['file'],$message['sql']);
	}
	elseif ( isset($message['error_key']) )
	{
		message_die(GENERAL_ERROR, $lang[$message['error_key']]);
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang[$message['message_key']]);
	}
}
/* END : Mark Topic Unread MOD */

# 
#-----[ FIND ]------------------------------------------ 
# 
	'REPLY_IMG' => $reply_img,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	'MARK_TOPIC_UNREAD' => '<a href="' . append_sid("viewtopic.{$phpEx}?mark=unread&" . POST_TOPIC_URL . "={$topic_id}") . "\">" . $lang['Mark_Topic_Unread'] . "</a>",

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
$lang['Topic_Marked_Unread'] = 'Topic has been marked unread';
$lang['Mark_Topic_Unread'] = 'Mark this topic unread';
$lang['error_marking_topic_unread'] = 'Could not mark topic as unread. Cookie problem.';
$lang['error_obtaining_post_data'] = 'Error obtaining post data';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/viewtopic_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	<td width="40%" valign="top" nowrap="nowrap" align="left"><span class="gensmall">{S_WATCH_TOPIC}</span><br />

#
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
{S_WATCH_TOPIC}

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 || {MARK_TOPIC_UNREAD}

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM