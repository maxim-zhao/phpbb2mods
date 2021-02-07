<?php
// MOD START number of newposts

// Check if this file is included..
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

if( $userdata['session_logged_in'] )
{

	// Needed for the posting pages ( if you delete this line
	// the number in the posting pages will be higher )
	global $HTTP_COOKIE_VARS, $HTTP_GET_VARS, $SID;

	// do AUTH_READ check...
	// results are in $read_forum_sql60;
	$is_auth_ary60 = auth(AUTH_READ, AUTH_ALL, $userdata);
	$read_forum_sql60 = '';
	while( list($key, $value) = each($is_auth_ary60) )
	{
		if ( $value['auth_read'] )
		{
			$read_forum_sql60 .= ( ( $read_forum_sql60 != '' ) ? ', ' : '' ) . $key;
		}
	}

	// INIT topics
	$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : '';

	// Thanks to ycl6 and TerraFrost for finding this bug!
	// START tracking topics check
	// Cannot retrieve a second each, so make a copy
	$tracking_topics2 = $tracking_topics;
	if($tracking_topics == '')
	{
		// No tracking topics? Make this an array for further each loops
		$tracking_topics[] = '-1';
		$tracking_topics2[] = '-1';
		// We scip the each loop beneath so we make a $keys_topics
		$keys_topics = '-1';
	}
	else
	{
		// Tracking topics found
		// Make list
		while(list($key, $val) = each ($tracking_topics))
		{
			$keys_topics .= $key.', ';
		}
		$keys_topics .= '.';
		$keys_topics = str_replace(", .", "", $keys_topics);  // Make "int, int, int" FROM: "int, int, int, ."
	}  // END tracking topics check

        // INIT lastvisit, or use the mark_all value
	$last_visit = $userdata['user_lastvisit'];
	$mark_all = $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'];
	if($mark_all != '')
	{
		// Mark all forums read is done with this line
		$last_visit = $mark_all;
	}




	// START forums cookie


	if(isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']))
	{
		// INIT forums
		// Safe to start here, because the cookie name is checked..
		$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : array();

		// Cannot retrieve a second each, so make a copy
		$tracking_forums2 = $tracking_forums;
		// Make list
		while(list($key, $val) = each ($tracking_forums))
		{
			$keys_forums .= $key.', ';
		}
		$keys_forums .= '.';
		$keys_forums = str_replace(", .", "", $keys_forums);  // Make "int, int, int" FROM: "int, int, int, ."

		$total = 0;


		// START read posts in the forums NOT IN the 'mark forum list'
		// ADD for forums
		// COUNT every post that's NOT been seen THIS session..
		$sql3 = "SELECT COUNT(post_id) as total
				FROM " . POSTS_TABLE . "
				WHERE !(topic_id IN (".$keys_topics.") )
				AND !(forum_id IN (".$keys_forums.") )
				AND post_time >= " . $last_visit . "
				AND poster_id != " .$userdata['user_id']."
				AND forum_id IN (".$read_forum_sql60.")";

		if ( !($result3 = $db->sql_query($sql3)) )
		{
			message_die(GENERAL_ERROR, 'Could not query number of newposts information', '', __LINE__, __FILE__, $sql);
		}

		while( $row3 = $db->sql_fetchrow($result3) )
		{
			$total += $row3['total'];
		}



			// COUNT every seen posts THIS session with a NEW post after viewing... and NOT IN the 'mark forum list'
			while(list($key_topic, $val) = each ($tracking_topics))
			{
			// COUNT for this topic..
		    		// ADD for forums
		     		$sql33 = "SELECT COUNT(post_id) as total
		     			FROM " . POSTS_TABLE . "
					WHERE topic_id = $key_topic
					AND !(forum_id IN (".$keys_forums.") )
					AND post_time > $val
					AND post_time >= " . $last_visit . "
					AND post_time < " . $userdata['user_session_time'] . "
					AND poster_id != " .$userdata['user_id']."
					AND forum_id IN (".$read_forum_sql60.")";

				if ( !($result33 = $db->sql_query($sql33)) )
				{
					message_die(GENERAL_ERROR, 'Could not query number of newposts information', '', __LINE__, __FILE__, $sql);
				}

		     		while( $row33 = $db->sql_fetchrow($result33) )
		     		{
		     			$total += $row33['total'];
		     		}
	      		}  // END tracking topics check
                // END read posts in the forums NOT IN the 'mark forum list'


		// START read posts in the forums IN the 'mark forum list'
        	while(list($tracking_forumkey, $tracking_forumval) = each ($tracking_forums2))
		{
			// ADD for forums $tracking_forumval
			// COUNT every post that's NOT been seen THIS session..
			$sql3 = "SELECT COUNT(post_id) as total
					FROM " . POSTS_TABLE . "
					WHERE !(topic_id IN (".$keys_topics.") )
					AND forum_id = $tracking_forumkey
					AND post_time >= " . $tracking_forumval . "
					AND poster_id != " .$userdata['user_id']."
					AND forum_id IN (".$read_forum_sql60.")";

			if ( !($result3 = $db->sql_query($sql3)) )
			{
				message_die(GENERAL_ERROR, 'Could not query number of newposts information', '', __LINE__, __FILE__, $sql);
			}

			while( $row3 = $db->sql_fetchrow($result3) )
			{
				$total += $row3['total'];
			}

                        // get array() with topics
                        $keys_topics_array = explode(", ", $keys_topics);

			// START COUNT every seen topic THIS session with a NEW post after viewing...
			while(list($key, $val) = each ($tracking_topics2))
			{
			      	// COUNT for this topic..
		 	 	// ADD for forums $tracking_forumval
				$sql33 = "SELECT COUNT(post_id) as total
					FROM " . POSTS_TABLE . "
					WHERE topic_id = $key
					AND forum_id = $tracking_forumkey
					AND post_time > $val
					AND post_time >= " . $tracking_forumval . "
					AND post_time < " . $userdata['user_session_time'] . "
					AND poster_id != " .$userdata['user_id']."
					AND forum_id IN (".$read_forum_sql60.")";

		      		if ( !($result33 = $db->sql_query($sql33)) )
		      		{
					message_die(GENERAL_ERROR, 'Could not query number of newposts information', '', __LINE__, __FILE__, $sql);
				}

		     		while( $row33 = $db->sql_fetchrow($result33) )
		     		{
		     			$total += $row33['total'];
		     		}
	     		} // END COUNT every seen posts THIS session with a NEW post after viewing...
		}
		// END read posts in the forums IN the 'mark forum list'


		// Parse output ..
		$lang['Search_new'] = $lang['Search_new'] . "&nbsp;(" . $total . ")";
		// END if(isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']))



	}	// END forums cookie, now go to topics cookie or nothing read
	else
	{
	// START topics cookie or nothing read


		if(isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']))
		{
			// START topics cookie

			// INIT topics
			// Safe to start here, because the cookie name is checked..
			// Make list
			while(list($key, $val) = each ($tracking_topics))
			{
				$keys_topics .= $key.', ';
			}
			$keys_topics .= '.';
			$keys_topics = str_replace(", .", "", $keys_topics);  // Make "int, int, int" FROM: "int, int, int, ."
			$total = 0;

			// COUNT every post that's NOT been seen THIS session..
			$sql3 = "SELECT COUNT(post_id) as total
					FROM " . POSTS_TABLE . "
					WHERE !(topic_id IN (".$keys_topics.") )
					AND post_time >= " . $last_visit . "
					AND poster_id != " .$userdata['user_id']."
					AND forum_id IN (".$read_forum_sql60.")";

			if ( !($result3 = $db->sql_query($sql3)) )
			{
				message_die(GENERAL_ERROR, 'Could not query number of newposts information', '', __LINE__, __FILE__, $sql);
			}

			while( $row3 = $db->sql_fetchrow($result3) )
			{
				$total += $row3['total'];
			}

			// COUNT every seen posts THIS session with a NEW post after viewing...
			while(list($key_topic, $val) = each ($tracking_topics))
			{
				// COUNT for this topic..
				$sql33 = "SELECT COUNT(post_id) as total
					FROM " . POSTS_TABLE . "
					WHERE topic_id = $key_topic
					AND post_time > $val
					AND post_time >= " . $last_visit . "
					AND post_time < " . $userdata['user_session_time'] . "
					AND poster_id != " .$userdata['user_id']."
					AND forum_id IN (".$read_forum_sql60.")";

				if ( !($result33 = $db->sql_query($sql33)) )
				{
					message_die(GENERAL_ERROR, 'Could not query number of newposts information', '', __LINE__, __FILE__, $sql);
				}

				while( $row33 = $db->sql_fetchrow($result33) )
				{
					$total += $row33['total'];
				}
			}

			// Parse output ..
			$lang['Search_new'] = $lang['Search_new'] . "&nbsp;(" . $total . ")";

		}


		// END topics cookie

		else
		{

		// START no forum reads no topic reads


			// FINAL
			// COUNT EVERY post from LAST session... ( no topic has been seen yet.. )
				$sql3 = "SELECT COUNT(post_id) as total
					FROM " . POSTS_TABLE . "
					WHERE post_time >= " . $last_visit . "
					AND poster_id != " .$userdata['user_id']."
					AND forum_id IN (".$read_forum_sql60.")";


			if ( !($result3 = $db->sql_query($sql3)) )
			{
				message_die(GENERAL_ERROR, 'Could not query number of newposts information', '', __LINE__, __FILE__, $sql);
			}

			while( $row3 = $db->sql_fetchrow($result3) )
			{
				$total += $row3['total'];
			}

			// Parse output ..
			$lang['Search_new'] = $lang['Search_new'] . "&nbsp;(" . $total . ")";

		}
		// END no forum reads no topic reads

       }
       // END topics cookie or nothing read

} // END if user logged in..

// MOD END number of newposts
?>