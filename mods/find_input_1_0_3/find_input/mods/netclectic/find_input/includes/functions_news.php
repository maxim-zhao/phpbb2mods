<?php
/***************************************************************************
 *                             functions_news.php
 *                            -------------------
 *   Author  		: 	netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Created 		: 	Monday, Sept 23, 2002
 *	 Last Updated	:	Thursday, Aug 07, 2003
 *
 *	 Version		: 	FIND - 1.0.2
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// try and set some system settings to hopefully get round problems 
// with security consious hosting providers
@set_time_limit(120);
@ini_set("safe_mode", "0");
@ini_set("allow_url_fopen", "1");


include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
include($phpbb_root_path . 'mods/netclectic/find_input/includes/rss_parser.'.$phpEx);
include($phpbb_root_path . 'mods/netclectic/includes/functions_insert_post.'.$phpEx);


/***************************************************************************
 *                         retrieve_rss_content
 *                         --------------------
 *   Author         :   netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Version        :   1.0.0
 *   Created 		: 	Monday, Sept 23, 2002
 *   Last Updated   :   Monday, Feb 17, 2003
 *
 *   Description    :   This functions is used to parse xml (rss / rdf) newsfeeds and
 *                      insert the items as posts in the forums 
 *
 *   Parameters     :   $newsfeed_ids     - a comma seperated list of newsfeed ids
 *                      $do_sync          - auto resync the post count of the forum
 *
 *   Returns        :   a message detailing what succeeded and what failed
 *
 ***************************************************************************/
function retrieve_rss_content($newsfeed_ids = '', $do_sync = false)
{
    global $db, $lang, $board_config, $phpbb_root_path, $phpEx; 
    
    // retrieve the newsfeed info for the requested newsfeeds
    if ( $newsfeed_ids != '' ) { $newsfeed_sql = ' WHERE feed_id IN (' . $newsfeed_ids . ')'; }
    $sql = 'SELECT * FROM ' . NEWSFEEDS_TABLE . $newsfeed_sql;
	if ( !($feed_result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain Newsfeed information.', '', __LINE__, __FILE__, $sql);
        //exit;
	}

    $success_message = '';
    $error_message = '';
    
    
    // instantiate a parser with the given url
    // retrieve thr results and format them for input into the forums
	while ( $feed_row = $db->sql_fetchrow($feed_result) )
    {
    	$rss_parser = new rssParser();

        $forum_id = $feed_row['forum_id'];
        $news_url = $feed_row['news_url'];
        $limit = $feed_row['news_limit'];
        $user_id = $feed_row['user_id'];
        $include_image = $feed_row['include_image'];
        $include_channel = $feed_row['include_channel'];

    	if ($rss_parser->parse($news_url))
    	{
    		$rss_limit = $limit;
    		if ( ($rss_limit > count($rss_parser->items)) || ($rss_limit <= 0) )	
            { 
                $rss_limit = count($rss_parser->items); 
            }
            
    		for ($i = $rss_limit-1; $i > -1; $i--)
    		{
                $subject = trim(substr($rss_parser->items[$i]['title'], 0, 59));
    
    			if ( !topic_already_exists($subject, $forum_id) )
    			{
                    // initialise the userdata
                    $userdata = update_newsfeed_userdata( $user_id );
                    
                    // prepare the message text
                    $message = prepare_newsfeed_message(
                        $rss_parser->items[$i]['description'], 
                        $rss_parser->items[$i]['link'], 
                        $rss_parser->channel, 
                        $rss_parser->channel_description, 
                        $rss_parser->channel_link, 
                        $rss_parser->image_link, 
                        $rss_parser->image_url, 
                        $include_channel, 
                        $include_image 
                    );
                    
                    // should we allow html, bbcode & smilies?
                    $html_on = intval($board_config['allow_html'] && $userdata['user_allowhtml']);
                    $bbcode_on = intval($board_config['allow_bbcode'] && $userdata['user_allowbbcode']);
                    $smilies_on = intval($board_config['allow_smilies'] && $userdata['user_allowsmile']);
                    $attach_sig = intval($userdata['user_attachsig']);

                    // insert our new post
                    insert_post(
                        $message, 
                        $subject, 
                        $forum_id, 
                        $user_id, 
                        $userdata['username'], 
                        $attach_sig,
                        NULL,                   // $topic_id
                        POST_NORMAL,            // $topic_type 
                        false,                  // $do_notification 
                        false,                  // $notify_user
                        0,                      // $current_time
                        '',                     // $error_die_function
                        $html_on, 
                        $bbcode_on, 
                        $smilies_on 
                    );
                }
    		}
            $success_message .= $news_url . '<br/>';
            if ($do_sync)
            {
                include_once($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
                sync('forum', $forum_id);
            }
    	}
        else
        {
            $error_message .= $news_url . '<br/>' . $rss_parser->error_msg . '<br/><br/>';
        }
        $rss_parser->destroy();
	    unset($rss_parser);
    }
	$db->sql_freeresult($feed_result);
		
    $success_message = '<br>Completed: <b>successfully</b>:<br>' . ( ($success_message == '') ? 'None' : $success_message );
    $error_message = '<br>Completed: <b>with problems</b>:<br>' . ( ($error_message == '') ? 'None' : $error_message );
    
	return $success_message . '<br><br>' . $error_message;
}



/***************************************************************************
 *                         topic_already_exists
 *                         --------------------
 *   Author         :   netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Version        :   1.0.0
 *   Created 		: 	Monday, Sept 23, 2002
 *   Last Updated   :   Monday, Feb 17, 2003
 *
 *   Description    :   This functions checks to see if a topic already exists 
 *                      with the give subject
 *
 *   Parameters     :   $subject  - the topic subject to search for
 *
 *   Returns        :   true    - if a topic with the subject exists
 *                      flase   - if a topic with the subject does not exist
 *
 ***************************************************************************/
function topic_already_exists( $subject, $forum_id )
{
    global $db; 

    $topic_already_exists = false;
    
    $sql = "SELECT topic_id FROM " . TOPICS_TABLE . " WHERE forum_id = $forum_id AND topic_title LIKE '%" . str_replace("'", "''", $subject) . "%'";
    if ( !($result = $db->sql_query($sql)) )
    {
        message_die(GENERAL_ERROR, 'Topic Already Exists', '', __LINE__, __FILE__, $sql);
    }
    $topic_already_exists = ($row = $db->sql_fetchrow($result));
    $db->sql_freeresult($result);
    
    return $topic_already_exists;
}



/***************************************************************************
 *                         prepare_newsfeed_message
 *                         -------------------------
 *   Author         :   netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Version        :   1.0.0
 *   Created 		: 	Monday, Sept 23, 2002
 *   Last Updated   :   Monday, Feb 17, 2003
 *
 *   Description    :   This functions prepares the text of a newsfeed item
 *                      for posting in the forums
 *
 *   Parameters     :   $message  - the message text
 *
 *   Returns        :   the prepared message
 *
 ***************************************************************************/
function prepare_newsfeed_message( $description, $link, $channel, $channel_description, $channel_link, $image_link, $image_url, $include_channel, $include_image )
{
    global $lang; 
    
    $message = $description;

    $message .= "\n\n" . '[url=' . $link . ']' . $lang['News_Read_More'] . '[/url]';
    
    // should we include the channel info for this newsfeed
    if ( $include_channel )
    {
        $message .= "\n\n" . $lang['News_source'] . '[url=' . $channel_link . ']' . $channel . '[/url]';
        $message .= "\n" . '[size=9]'. $channel_description . '[/size]';
    }
    
    // should we include any image info for this newsfeed
    if ( $include_image && ($image_url != '') )
    {
        $image_link = '[url=' . ( ($image_link != '') ? $image_link : $link ) . '][img]' . $image_url . '[/img][/url]' . "\n\n";
        $message = $image_link . $message;
    }
    
    return $message;
}



/***************************************************************************
 *                         update_newsfeed_userdata
 *                         -------------------------
 *   Author         :   netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Version        :   1.0.0
 *   Created 		: 	Monday, Sept 23, 2002
 *   Last Updated   :   Monday, Feb 17, 2003
 *
 *   Description    :   This functions itialises the user data and updates 
 *                      the users last visit details
 *
 *   Parameters     :   $user_id  - the id of the user
 *
 *   Returns        :   the initialise $userdata array
 *
 ***************************************************************************/
function update_newsfeed_userdata( $user_id )
{
    global $db; 

    $sql = "SELECT * FROM " . USERS_TABLE . " WHERE user_id = $user_id";
    if ( !($user_result = $db->sql_query($sql)) )
    {
    	message_die(CRITICAL_ERROR, 'Could not obtain user data from user table', '', __LINE__, __FILE__, $sql);
    }
    $userdata = $db->sql_fetchrow($user_result);
    init_userprefs($userdata);
    $db->sql_freeresult($user_result);
    
    // update the users last visit time
    $current_time = time();
    $sql = "UPDATE " . USERS_TABLE . " 
    	SET user_session_time = $current_time, user_session_page = " . PAGE_INDEX . ", user_lastvisit = $current_time
    	WHERE user_id = $user_id";
    if ( !$db->sql_query($sql) )
    {
    	message_die(CRITICAL_ERROR, 'Error updating last visit time', '', __LINE__, __FILE__, $sql);
    }
    
    return $userdata;
}

?>