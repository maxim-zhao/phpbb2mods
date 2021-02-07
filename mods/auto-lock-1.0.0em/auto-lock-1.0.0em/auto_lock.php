<?php
/***************************************************************************
*                                 auto_lock.php
*                            -------------------
*   begin                : Thursday, June 14, 2001
*   copyright            : (C) 2001 The phpBB Group
*   email                : support@phpbb.com
*
*   $Id: prune.php,v 1.19.2.6 2003/03/18 23:23:57 acydburn Exp $
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

/* Modified version of prune.php by Sune Trudslev (www.tanis.dk) */

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
				OR t.topic_last_post_id = 0 )";
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
	$db->sql_freeresult($result);
		
	if( $sql_topics != '' )
	{
		$sql = "SELECT post_id
			FROM " . POSTS_TABLE . " 
			WHERE forum_id = $forum_id 
				AND topic_id IN ($sql_topics)";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain list of posts to lock', '', __LINE__, __FILE__, $sql);
		}

		$sql_post = '';
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql_post .= ( ( $sql_post != '' ) ? ', ' : '' ) . $row['post_id'];
		}
		$db->sql_freeresult($result);

		if ( $sql_post != '' )
		{
			$sql = "UPDATE " . TOPICS_TABLE . "
				SET topic_status = 1
				WHERE topic_id IN ($sql_topics)";
			if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not lock topics during locking', '', __LINE__, __FILE__, $sql);
			}
			$locked_topics = $db->sql_affectedrows();

			return array ('topics' => $pruned_topics);
		}
	}

	return array('topics' => 0);
}

//
// Function auto_lock(), this function will read the configuration data from
// the auto_lock table and call the lock function with the necessary info.
//
function auto_lock($forum_id = 0)
{
	global $db, $lang;

	$sql = "SELECT *
		FROM " . AUTO_LOCK_TABLE . "
		WHERE forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not read auto_lock table', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['auto_lock_freq'] && $row['auto_lock_days'] )
		{
			$auto_lock_date = time() - ( $row['auto_lock_days'] * 86400 );
			$next_auto_lock = time() + ( $row['auto_lock_freq'] * 86400 );

			lock($forum_id, $auto_lock_date);

			$sql = "UPDATE " . FORUMS_TABLE . " 
				SET auto_lock_next = $next_auto_lock 
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