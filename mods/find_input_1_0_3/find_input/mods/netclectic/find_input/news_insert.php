<?php
/***************************************************************************
 *                             news_insert.php
 *                            -------------------
 *   Author  		: 	netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Created 		: 	Monday, Sept 23, 2002
 *	 Last Updated	:	Thursday, Aug 07, 2003
 *
 *	 Version		: 	FIND - 1.0.3
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = '../../../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'mods/netclectic/find_input/includes/functions_news.'.$phpEx);

// quick and nasty security check, it's not flawless but it should stop most attempts
$secure_check = false;
$flood_attempt = false;
if ( $HTTP_SERVER_VARS['SERVER_ADDR'] == $HTTP_SERVER_VARS['REMOTE_ADDR'] )
{
    // the request appears to be coming from this server (e.g. from cron), so we'll let it through
    $secure_check = true;

    // flood attempt - check the current time against the last session time that this script was executed
    // always give the news_insert the same unique seesion id so we can use the session time to check
    $current_time = time();
    $user_id = -2;
    $user_ip = $HTTP_SERVER_VARS['SERVER_ADDR'];
    $page_id = PAGE_INDEX;
    $session_id = md5('netclectic_find_news_insert');
    $sql = 'SELECT * FROM ' . SESSIONS_TABLE . " WHERE session_id = '$session_id'";
    if ( $result = $db->sql_query($sql) )
    {
        if ( $row = $db->sql_fetchrow($result) )
        {
            $last_session_time = $row['session_start'];
            if ( $current_time <= $last_session_time + $board_config['flood_interval'] )
            {
                $flood_attempt = true;
            }
            else
            {
                $sql = 'UPDATE ' . SESSIONS_TABLE . " 
                    SET session_start = $current_time, session_time = $current_time 
                    WHERE session_id = '$session_id'";
                if ( !$db->sql_query($sql) )
                {
            		message_die(CRITICAL_ERROR, 'Error updating newsfeed session', '', __LINE__, __FILE__, $sql);
                }
            }
        }
        else
        {
            $sql = 'INSERT INTO ' . SESSIONS_TABLE . "
			(session_id, session_user_id, session_start, session_time, session_ip, session_page, session_logged_in)
			VALUES ('$session_id', $user_id, $current_time, $current_time, '$user_ip', $page_id, 0)";
            if ( !$db->sql_query($sql) )
            {
        		message_die(CRITICAL_ERROR, 'Error updating newsfeed session', '', __LINE__, __FILE__, $sql);
            }
        }
    }
}
else
{
    // if the request is not coming from this server, 
    // then check to see if it's being executed by a logged in admin uer
    $userdata = session_pagestart($user_ip, PAGE_INDEX);
    init_userprefs($userdata);
    $secure_check = ($userdata['user_level'] == ADMIN);
}

if ( $secure_check && !$flood_attempt )
{
    // do the news insert
	$feeds = ( isset($HTTP_GET_VARS[POST_NEWSFEED_URL]) ) ?  $HTTP_GET_VARS[POST_NEWSFEED_URL] : '';
    $msg = retrieve_rss_content($feeds);
    die($msg);
}    
else
{
	die('Hacking attempt');
}
?>
