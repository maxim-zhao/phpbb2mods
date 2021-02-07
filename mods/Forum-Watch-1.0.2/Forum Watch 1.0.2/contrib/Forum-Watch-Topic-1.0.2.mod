##############################################################
## MOD Title: Forum Watch Topic Add on
## MOD Author: skinmaster < mike@fuckingbrit.com > (Michael Jervis) http://www.fuckingbrit.com
## MOD Description: Add on for Forum Watch mod subscribing a user to a topic when it is posted.
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 1 minutes
## Files To Edit: includes/functions_post.php
## Included Files: N/A
## Generator: By Hand.
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: This mod REQUIRES Forum-Watch-1.0.2.mod to be installed first.
##############################################################
## MOD History:
##
##   2005-04-13 - Version 1.0.2
##
##      - First release in a full mod template.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#

includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
#
	$sql = "SELECT u.user_id, u.user_email, u.user_lang
		FROM " . FORUMS_WATCH_TABLE . " fw, " . USERS_TABLE . " u
		WHERE fw.forum_id = $forum_id
			AND fw.user_id NOT IN (" . $userdata['user_id'] . ", " . ANONYMOUS . $user_id_sql . ")
			AND fw.notify_status = " . TOPIC_WATCH_UN_NOTIFIED . "
			AND u.user_id = fw.user_id";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not obtain list of forum watchers', '', __LINE__, __FILE__, $sql);
	}

	$update_watched_sql = '';
	$bcc_list_ary = array();

	if ($row = $db->sql_fetchrow($result))
	{
		// Sixty second limit
		@set_time_limit(60);

		do
		{
			if ($row['user_email'] != '')
			{
				$bcc_list_ary[$row['user_lang']][] = $row['user_email'];
			}
			$update_watched_sql .= ($update_watched_sql != '') ? ', ' . $row['user_id'] : $row['user_id'];
		}
		while ($row = $db->sql_fetchrow($result));
#
#-----[ AFTER, ADD ]------------------------------------------
#

		$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "INSERT $sql_priority INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
					VALUES (" . $row['user_id'] . ", $topic_id, 0)";
		$new_result = $db->sql_query($sql);
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM