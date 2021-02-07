<?php

function get_topics (   $user_id = '0',  /* User */
			$type = 'topics', /* Whether to look for topics or posts */
			$forums = '-1' , /* Forum specefic. -1 is all. This can also be an array */
			$amount = '-1', /* We'll pull it from teh config if not specefied */ 
			$assign_template_var = '0' /* 0 means it will be returned as an array, otherwise this should be the block var that the data is assigned to */ )
{
	/* This function gets the latest ( $amount ) [posts | topics] in ( $forums ) posted by ( $user_id ) */

	global $db,$phpEx;
	$type = strtolower($type);

	if ( $amount == '-1' )
	{
		global $board_config;
		$amount = $board_config['latest_posts_show'];
	}

	$user_id = ( $user_id == '0' ) ? '!=' . ANONYMOUS : '=' . $user_id;

	/* Just checks certain things are correct */
	if  ( $user_id == ANONYMOUS || $user_id == DELETED || ( $type != 'topics' && $type !='posts') || $amount <= 0 )
	{
		/* Stop running */
		return false; 
	}	

	/* Ok now we'll need to build the query to get the data */

	global $userdata;

	if ( $forums == '-1' )
	{
		$sql = 'SELECT forum_id
			FROM ' . FORUMS_TABLE;

		$result = $db->sql_query($sql);

		$forums=array();

		while ( $row = $db->sql_fetchrow($result) )
		{
			$forums[] = $row['forum_id'];
		}

	}

	if ( is_array($forums) )
	{
		$count = 0;
		while ( list($key, $val) = each($forums) )
		{
			$auth = auth( AUTH_VIEW , $val , $userdata ); 
			if ( $auth['auth_view'] )
			{
				$forum_list .= ($count > 0) ? ',' . $val : $val;
				++$count;
			}

		}
		$forum_id_query = 'IN (' . $forum_list . ')';
	}
	elseif ( is_numeric($forums) && $forums > 0 )
	{
		$auth = auth( AUTH_VIEW , $forums , $userdata ); 
		if ( $auth['auth_view'] )
		{
			$forum_id_query = ' = ' . $forums;
		}
	}
	else
	{
		return false; 
	}


	if ( $type == 'posts' )
	{
		$sql = 'SELECT p.post_id AS id, pt.post_subject AS title
			FROM ' . POSTS_TABLE . ' p,' . POSTS_TEXT_TABLE . ' pt 
			WHERE p.post_id = pt.post_id
				AND poster_id ' . $user_id . '
				AND p.forum_id ' . $forum_id_query . '
			ORDER BY pt.post_time DESC
			LIMIT ' . $amount;
	}

	if ( $type == 'topics' )
	{
		$sql = 'SELECT topic_id AS id, topic_title AS title
			FROM '. TOPICS_TABLE . '
			WHERE topic_poster ' . $user_id . '
			AND forum_id ' . $forum_id_query . '
			ORDER BY topic_time DESC
			LIMIT ' . $amount;
	}

	if ( $sql == '')
	{
		return false; 
	}

	$result = $db->sql_query($sql);

	$data = array(); /* We'll store the data in here */

	if ( !$result )
	{
		return false;
	}

		while ( $row = $db->sql_fetchrow($result) )
		{
			$post_var = ( $type == 'posts' ) ? POST_POST_URL : POST_TOPIC_URL;
			$next_record = count($data) + 1;
			$file = 'viewtopic.' . $phpEx . '?' . $post_var . '=' . $row['id'];
			$data[$next_record]['link'] = append_sid($file);
			$data[$next_record]['title'] = $row['title'];
		}

	if ( $assign_template_var == '0' )
	{
		return $data; /* Send the data back */ 
	}

	global $template, $lang;



	if ( count($data) < 1 )
	{
		$template->assign_block_vars($assign_template_var, array('LINK' => '#',
									'TITLE' => $lang['no_topics']));
	}
	else
	{
		$template->assign_var('L_USER_TOPICS', $lang['users_topics']);

		for ( $i = 1; $i <= count($data); ++$i )
		{
			$template->assign_block_vars($assign_template_var , array('LINK' => $data[$i]['link'],
										'TITLE' => $data[$i]['title']));
		}
	}


	return true; 

}

?>