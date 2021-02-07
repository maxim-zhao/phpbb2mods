<?php
/***************************************************************************
 *                            function_welcome_panel.php
 *                            -------------------
 *   begin                : Friday, Jan 07, 2005
 *   copyright            : (C) 2005 Aiencran
 *   email                : cranportal@katamail.com
 *
 *   $Id: functions_suggest.php,v 1.0.0.0 2005/01/07 13:05:00 psotfx Exp $
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
 *
 ***************************************************************************/

//
// Select topic to be suggested
//
function suggest_topic($userdata)
{
	global $db, $board_config, $lang, $phpEx;

	$suggested_topic = array( 'topic_link' => '', 'topic_title' => '' );

	$suggestion_type = $board_config['suggestion_type'];
	if ( $suggestion_type == SUGGEST_SPECIFIC ) 
	{
		$suggested_topic_id = $board_config['suggested_topic_id'];
		$sql = "SELECT forum_id, topic_title FROM " . TOPICS_TABLE . " 
			WHERE topic_id = " . $suggested_topic_id; 
		$result = $db->sql_query($sql); 
		if( $result ) 
		{ 
			if ( $row = $db->sql_fetchrow($result) )
			{
				$auth_read = auth(AUTH_READ, $row['forum_id'], $userdata);
				if ( $auth_read['auth_read'] ) 
				{
					$suggested_topics_id[] = $suggested_topic_id;	
					$suggested_topics_title[] = $row['topic_title'];
				}
				else
				{
					$suggestion_type = SUGGEST_FAQ;
				}
			}
		}	
		$db->sql_freeresult($result);
	}
	else if ( $suggestion_type == SUGGEST_TOPIC_FROM ) 
	{
		$suggestion_source = $board_config['suggestion_source'];
		$suggest_announcements = $board_config['suggest_announcements'];

		if ( $suggestion_source == 0 )
		{
			$sql = "SELECT forum_id FROM " . FORUMS_TABLE . " ORDER BY forum_id"; 
			$result = $db->sql_query($sql); 
			if( $result ) 
			{ 
				$sql_where = "( ";
				while ( $row = $db->sql_fetchrow($result) ) 
				{
					$auth_read = auth(AUTH_READ, $row['forum_id'], $userdata);
					if ( $auth_read['auth_read'] ) 
					{
						$sql_where .= ( $sql_where == "( " ) ? "forum_id = " . $row['forum_id'] :  " OR forum_id = " . $row['forum_id'];	
					}
				}
				$sql_where .= " )";
				if ( $sql_where == "(  )" )
				{
					$suggestion_type = SUGGEST_FAQ;
				}	
			}
		}
		else
		{
			$auth_read = auth(AUTH_READ, $suggestion_source, $userdata);
			if ( $auth_read['auth_read'] ) 
			{
				$sql_where = "forum_id = " . $suggestion_source;
			}
			else
			{
				$sql_where == "(  )";
			}
		}

		if ( $sql_where != "(  )" ) 
		{
			$ann_where = ( $suggest_announcements == 1 ) ? " AND ( topic_type BETWEEN 1 AND 3 )" : "";

			$sql = "SELECT topic_id, forum_id, topic_title FROM " . TOPICS_TABLE . " 
				WHERE " . $sql_where . $ann_where; 
			$result = $db->sql_query($sql); 
			if( $result ) 
			{ 
				while( $row = $db->sql_fetchrow($result) )
				{
					$suggested_topics_id[] = $row['topic_id'];
					$suggested_topics_title[] = $row['topic_title'];
				} 
			}	
			$db->sql_freeresult($result);
		}
	}
	
	if ( $suggestion_type != DO_NOT_SUGGEST ) 
	{	
		$suggested_key = ( count($suggested_topics_id) == 0 || $suggestion_type == SUGGEST_FAQ ) ? -1 : rand(0, count($suggested_topics_id) - 1);
		$suggested_id = ( $suggested_key == -1) ? -1 : $suggested_topics_id[$suggested_key];
		$suggested_link = ($suggested_id == -1) ? append_sid('faq.'.$phpEx) : append_sid('viewtopic.'.$phpEx.'?t=' . $suggested_id);
		$suggested_title = ($suggested_id == -1) ? $lang['Welcome_no_suggested_topic'] : $suggested_topics_title[$suggested_key];
	}		

	$suggested_topic['topic_link'] = $suggested_link;
	$suggested_topic['topic_title'] = $suggested_title;

	return $suggested_topic;
}

?>
