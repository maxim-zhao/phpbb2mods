<?php

/**
 * get_forums
 *
 * obtains a list of all forums
 *
 * @author Noobarmy (Anthony Chu)
 *
 * @global db $db
 * @static array $forums
 * @return array $forums
 */

function get_forums ()
{
	global $db;
	static $forums = array();
	if ( count($forums) <= 0 )
	{

                $sql = 'SELECT forum_id
                        FROM ' . FORUMS_TABLE;

                // Need error checking on every query :-)
                if (!($result = $db->sql_query($sql)))
                {
                        message_die(GENERAL_ERROR, 'DEBUG: Invalid sql for forum list', '', '', '', $sql);
                }

                $forums=array();

                // Build our array of forum_id values
                while ( $row = $db->sql_fetchrow($result) )
                {
                        $forums[] = $row['forum_id'];
                }
	}

	return $forums;

}

/**
 * get_topics
 *
 * obtains the latest topics for a user
 *
 * @author Noobarmy (Anthony Chu)
 *
 * @param int $user_id 		the user
 * @param string $type		to look for posts or topics
 * @param mixed $forums		forums to look in, can be an integer or array
 * @param int $amount		amount of topics to get
 *
 * @global db $db		database
 * @global mixed $phpEx 	
 * @global array $userdata	user's data
 *
 * @return array topics		returns the latest topics/posts for the user
 */
function get_topics (   $user_id = '0',  
			$type = 'topics', 
			$forums = '-1' , 
			$amount = '-1'
			)
{

	global $db,$phpEx;
	$type = strtolower($type);

	if ( $amount == '-1' )
	{
		global $board_config;
		$amount = $board_config['latest_posts_show'];
	}

	$user_sql = ( $user_id == '0' ) ? '!=' . ANONYMOUS : '=' . $user_id;

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
		$forums = get_forums();
        }

        if ( is_array($forums) )
        {
                // Initialize authorization array
                $is_auth_ary = array();
                
                // Populate the array with permissions data for all forums at once
                $is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forums); 
                
                // Empty array to store list of auth'd forums
                $forum_list = array();
                
                while ( list($key, $val) = each($forums) )
                {
                        // Now authorization check is looking
                        // in an array rather than a query
                        if ( $is_auth_ary[$val]['auth_view'] )
                        {
                                $forum_list[] = $val;
                        }
                }

                // Now get the number of auth'd forums, build sql
                // based on the sizeof the array
                $count = sizeof($forum_list);
                
                if ( $count >= 2 )
                {
                        $forum_id_query = 'IN (' . implode(',',$forum_list) . ')';
                }
                elseif ( $count == 0 )
                {
                        // no auth'd forums
                        return false;
                }
                // $count must equal 1 if we get here so there is only one auth'd forum
                // so we set the condition equal to array index zero (first element)
                else
                {
                        $forum_id_query = '= ' . $forum_list[0] ;
                }
        }
        elseif ( is_numeric($forums) && $forums > 0 )
        {
                // Here we have only one forum, no need to change any of this code
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
				AND poster_id ' . $user_sql . '
				AND p.forum_id ' . $forum_id_query . '
			ORDER BY p.post_time DESC
			LIMIT ' . $amount;
	}

	if ( $type == 'topics' )
	{
		$sql = 'SELECT topic_id AS id, topic_title AS title
			FROM '. TOPICS_TABLE . '
			WHERE topic_poster ' . $user_sql . '
			AND forum_id ' . $forum_id_query . '
			ORDER BY topic_time DESC
			LIMIT ' . $amount;
	}

	if ( $sql == '')
	{
		return false; 
	}



	$data = array(); /* We'll store the data in here */

	if ( !$result = $db->sql_query($sql) )
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
	

	

	return $data; /* Send the data back */ 

}

/**
 * assign_topics
 *
 * assigns the topic data to the template
 * loop specefied
 *
 * @param array $data 		topic data (obtained from get_topics
 * @param string $template_var	var_loop to assign the data to
 * @global template $template
 * @global array $lang
 * @return bool success
 */
function assign_topics ( $data = array(), $template_var = '')
{

	global $template,$lang;

	if ( count($data) < 1 )
	{
		$template->assign_block_vars($template_var, array('LINK' => '#',
									'TITLE' => $lang['no_topics']));
	}
	else
	{
		$template->assign_var('L_USER_TOPICS', $lang['users_topics']);

		for ( $i = 1; $i <= count($data); ++$i )
		{
			$template->assign_block_vars($template_var , array('LINK' => $data[$i]['link'],
										'TITLE' => $data[$i]['title']));
		}
	}


	return true;

}

?>