<?php
/***************************************************************************
 *                             functions_auto_lock.php
 *                            -------------------
 * Begin		: December 22, 2005
 * Email		: ycl6@users.sourceforge.net (http://macphpbbmod.sourceforge.net/)
 * Ver.			: 1.0.0
 *
 ***************************************************************************/
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

function topic_auto_lock($forum_id = 0)
{
	global $db, $lang;
	
	$sql = "SELECT t.topic_id, t.enable_auto_lock, t.topic_replies, t.topic_status, f.auto_lock_enable, f.auto_lock_reply_number
		FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f
		WHERE t.forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		if ($row['auto_lock_enable'] && $row['enable_auto_lock'] && $row['topic_status'] != 1)
		{
			if ($row['topic_replies'] >= $row['auto_lock_reply_number'])
			{
				$sql = "UPDATE " . TOPICS_TABLE . " 
						SET topic_status = '1' 
						WHERE topic_id = " . $row['topic_id'];
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update topic table', '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}
	$db->sql_freeresult($result);
}

function auto_lock_status_newtopic($forum_id = 0)
{
	global $db, $lang;

	$sql = "SELECT f.auto_lock_enable, f.auto_lock_reply_number
		FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f
		WHERE f.forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
	}
	
	$row = $db->sql_fetchrow($result);

	return $row;
}

function auto_lock_status_editpost($topic_id = 0)
{
	global $db, $lang;

	$sql = "SELECT t.enable_auto_lock, f.auto_lock_enable, f.auto_lock_reply_number
		FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f
		WHERE t.topic_id = $topic_id";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
	}
	
	$row = $db->sql_fetchrow($result);

	return $row;
}
?>