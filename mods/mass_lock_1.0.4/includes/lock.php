<?php
/***************************************************************************
*                                 lock.php
*                            -------------------
*   begin                : Thu, Mar 27, 2003
*   copyright            : 2003, Siavash Rahnama
*   email                : siavash79_99@yahoo.com
*
*
***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
   die("Hacking attempt");
}

require($phpbb_root_path . 'includes/functions_search.'.$phpEx);

function lock($forum_id, $lock_date, $lock_all = false)
{
	global $db, $lang;

	$lock_all = ($lock_all) ? '' : 'AND t.topic_vote = 0 AND t.topic_type <> ' . POST_ANNOUNCE;
	//
	// Those without polls and announcements ... unless told otherwise!
	//
	$sql = "SELECT t.topic_id 
		FROM " . POSTS_TABLE . " p, " . TOPICS_TABLE . " t
		WHERE t.forum_id = $forum_id
			$lock_all 
			AND ( p.post_id = t.topic_last_post_id 
				OR t.topic_last_post_id = 0 )
			AND t.topic_status <> " . TOPIC_LOCKED;
	if ( $lock_date != '' )
	{
		$sql .= " AND p.post_time < $lock_date";
	}

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain lists of topics to lock', '', __LINE__, __FILE__, $sql);
	}

	$sql_topics = '';
	while( $row = $db->sql_fetchrow($result) )
	{
		$sql_topics .= ( ( $sql_topics != '' ) ? ', ' : '' ) . $row['topic_id'];
	}
		

		if ( $sql_topics != '' )
		{

			$sql = "UPDATE " . TOPICS_TABLE . "
				SET topic_status = " . TOPIC_LOCKED . "
				WHERE topic_id IN ($sql_topics)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not lock topics during autolock', '', __LINE__, __FILE__, $sql);
			}

			$lockd_topics = $db->sql_affectedrows();

			return count($lockd_topics);
		}
	

	return 0;
}

//
// Function auto_lock(), this function will read the configuration data from
// the auto_lock table and call the lock function with the necessary info.
//
function auto_lock($forum_id = 0)
{
	global $db, $lang;
	$sql = "SELECT *
		FROM " . LOCK_TABLE . "
		WHERE forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not read auto_lock table', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['lock_freq'] && $row['lock_days'] )
		{
			$lock_date = time() - ( $row['lock_days'] * 86400 );
			$next_lock = time() + ( $row['lock_freq'] * 86400 );

			lock($forum_id, $lock_date);
			sync('forum', $forum_id);

			$sql = "UPDATE " . FORUMS_TABLE . " 
				SET lock_next = $next_lock 
				WHERE forum_id = $forum_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update forum table', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	return;
}

?>
