<?php
/***************************************************************************
                                smartfeed.php
                             -------------------
    begin                : Fri, Nov 2, 2007
    copyright            : (c) Mark D. Hamill
    email                : mhamill@computer.org

    $Id: $

***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// Written by Mark D. Hamill, mhamill@computer.org
// This software is designed to work with phpBB Version 2.0.22

// This is the program that creates the RSS or Atom compliant newsfeed that will also include protected
// forums. An enhanced and slightly modified version of the the FeedCreator class, version 1.7.2 was used 
// to generate the various feeds. The modified version can be found at 
// http://blog.mypapit.net/2005/11/using-feedcreator-to-generate-atom-10-feeds.html.
// This version is needed because it supports Atom 1.0 and allow feeds to be created on the fly, 
// instead of stored to files.
//
// A companion program should be run first: smartfeed_url.php. This creates a URL that is
// used to invoke the feed. Use the URL created by this program in your newsreader. Do NOT try to run 
// this program without arguments!
//
// This program has been enhanced to serve advertisements and to display private messages.

define('IN_PHPBB', true);
$phpbb_root_path = './';

header('Content-type: application/xml'); // Hopefully this will resolve some validator warnings

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/smartfeed_constants.'.$phpEx);
include($phpbb_root_path . 'includes/feedcreator.class.'.$phpEx); 
include($phpbb_root_path . 'includes/smartfeed_ads.class.' . $phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_smartfeed.' . $phpEx);

// Find out if mcrypt is enabled in this installation of PHP. If mcrypt is not loaded then only public forums can be shown in the feed
$extensions = get_loaded_extensions();
$mcrypt_loaded = in_array('mcrypt', $extensions);

// Set up some needed variables
$debug = false; // If true any items in $debug_info will appear as a title of the first item in the newsfeed. You need to modify this code to set $debug_info to the information of interest
$error = false; // Have any errors occurred? If set to true, a special newsfeed with one item describing the error is provided
$error_msg = ''; // This is the particular error to show in the feed to the user
$item_count = 0; // Used as a counter to tell when to insert ads between items, if that feature is enabled
$first_post_only = false; // Only used if new topics only is specified
$phpBB_forum_user = false; // Has this person registered with this board?
$reset_user_lastvisit = false; // If true, user_lastvisit is reset to current date and time; messages through that time will appear as read on the phpBB site

// Get the encrypted password. When decrypted it is still encoded md5
$encrypted_pswd = ( !empty($HTTP_GET_VARS['e']) ) ? htmlspecialchars($HTTP_GET_VARS['e']) : '';
// + signs in $HTTP_GET_VARS['e'] seem to get translated to a space character, so put them back in
$encrypted_pswd = str_replace(' ','+',$encrypted_pswd);

// Get the old encrypted password, if it exists. We want to trap for this and give an appropriate error message since the e parameter is now used.
$old_encrypted_pswd_exists = ( !empty($HTTP_GET_VARS['p']) ) ? true : false;

// Get the user id. A public user won't be identified as a user in the URL
$user_id = ( !empty($HTTP_GET_VARS[POST_USERS_URL]) ) ? intval($HTTP_GET_VARS[POST_USERS_URL]) : '';

// Arguments are required. If none, generate an error
if (trim($HTTP_SERVER_VARS['QUERY_STRING']) == '')
{
	$error_msg = $lang['smartfeed_no_arguments'];
	$error = true;
}

// If p parameter is being passed, send special message to rerun smartfeed_url.php, since this parameter went away starting in version 1.2
if ($old_encrypted_pswd_exists)
{
	$error_msg = sprintf($lang['smartfeed_p_parameter_obsolete'],  SMARTFEED_SITE_URL . "smartfeed_url.$phpEx"); 
	$error = true;
}

// Check the encrypted password parameter and make sure there is a corresponding u parameter.
if ((!$error) && ($encrypted_pswd <> ''))
{
	// Check for the u argument. u corresponds to the user_id wanted and must be present if the p parameter is used 
	if ($user_id == '')
	{
		$error_msg = $lang['smartfeed_no_u_param'];
		$error = true;
	}
	else
	{
		$phpBB_forum_user = true;
	}
}
else
{
	// The u argument may not be used by itself
	if ($user_id <> '')
	{
		$error_msg .= $lang['smartfeed_no_e_param'];
		$error = true;
	}
}

// Validate user id, password and IP (if IP authentication requested)
if ((!$error) && $phpBB_forum_user && $mcrypt_loaded) 
{
	// Make sure user_id exists in database
	$sql = 'SELECT count(*) as count
		FROM ' . USERS_TABLE . '
		WHERE user_id = ' . $user_id;
		
	if ( !($result = $db->sql_query($sql)) )
	{
		$error_msg = $lang['smartfeed_user_table_count_error'] ;
		$error = true;
	}
	else
	{
		$row = $db->sql_fetchrow($result);
		
		if ($row['count'] == 0)
		{
			$error_msg = sprintf($lang['smartfeed_user_id_does_not_exist'], $user_id);
			$error = true;
		}
		else
		{
			// Validate encrypted password
			$sql = 'SELECT user_password, user_level, user_smartfeed_key
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $user_id;
			
			if ( !($result = $db->sql_query($sql)) )
			{
				$error_msg = $lang['smartfeed_user_table_password_error'];
				$error = true;
			}
			else
			{
				$row = $db->sql_fetchrow($result);
				
				// Decrypt password. 
				$encoded_pswd = decrypt($encrypted_pswd, $row['user_smartfeed_key']);
				
				// If IP Authentication was enabled, the encoded password is to the left of the ~ and the IP to the right of the ~
				$tilde = strpos ($encoded_pswd, '~');
				if (($tilde == 0) && SMARTFEED_REQUIRE_IP_AUTHENTICATION)
				{
					$error_msg = $lang['smartfeed_ip_auth_error'];
					$error = true;
				}
				else if ($tilde > 0)
				{
					$auth_ip = substr($encoded_pswd,$tilde+1);
					$encoded_pswd = substr($encoded_pswd,0,$tilde);
					$client_ip_parts = explode('.', $HTTP_SERVER_VARS['REMOTE_ADDR']);
					$source_ip_parts = explode('.', $auth_ip);
					// Show error message if requested from incorrect range of IP addresses
					if (!(($client_ip_parts[0] == $source_ip_parts[0]) && ($client_ip_parts[1] == $source_ip_parts[1]) && ($client_ip_parts[2] == $source_ip_parts[2])))
					{
						$error_msg = $lang['smartfeed_ip_auth_error'];
						$error = true;
					}
				}
				if (!$error && $encoded_pswd <> $row['user_password'])
				{
					$error_msg = sprintf($lang['smartfeed_bad_password_error'],  $encrypted_pswd, $user_id, SMARTFEED_SITE_URL . "smartfeed_url.$phpEx"); 
					$error = true;
				}
				else
				{
					// Check to see if last visit time should be reset
					$lastvisit = ( !empty($HTTP_GET_VARS['lastvisit']) ) ? htmlspecialchars($HTTP_GET_VARS['lastvisit']) : '';

					if (($lastvisit <> '') && ($lastvisit <> '1'))
					{
						$error_msg = $lang['smartfeed_lastvisit_param'];
						$error = true;
					}
					else if ($lastvisit == '1')
					{
						$reset_user_lastvisit = true;
					}	
				}			
			}
		}
	}
}

if (!$error)
{

	// Get all forum_ids that this user is allowed to access. This could be done more simply with SQL, but MySQL 3.x
	// does not support unions and intersections, so we need to do it the old fashioned way for backwards compatability.
	
	$auth_restrict = ($userdata['session_user_id'] <> ANONYMOUS && $mcrypt_loaded) ? AUTH_ALL  . ',' . AUTH_REG : AUTH_ALL;
	
	if ($mcrypt_loaded)
	{
		switch($row['user_level'])
		{
			case USER:
				// Retrieve a list of forum_ids that all members can access
				$sql = 'SELECT f.forum_id, f.forum_name, c.cat_order, f.forum_order
					FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
					WHERE f.cat_id = c.cat_id AND auth_read IN (' . $auth_restrict . ') 
					ORDER BY c.cat_order, f.forum_order';
				break;
			case MOD:
				// Retrieve a list of forum_ids that all moderators can access
				$sql = 'SELECT f.forum_id, f.forum_name, c.cat_order, f.forum_order
					FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
					WHERE f.cat_id = c.cat_id AND auth_read IN (' . AUTH_ALL . ',' . AUTH_REG . ',' . AUTH_MOD .') 
					ORDER BY c.cat_order, f.forum_order';
				break;
			case ADMIN:
				// Administrators of course see all forums
				$sql = 'SELECT f.forum_id, f.forum_name, c.cat_order, f.forum_order
					FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
					WHERE f.cat_id = c.cat_id 
					ORDER BY c.cat_order, f.forum_order';
		}
	}
	else
	{
		// Retrieve a list of forum_ids that all members can access
		$sql = 'SELECT f.forum_id, f.forum_name, c.cat_order, f.forum_order, f.auth_read
			FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
			WHERE f.cat_id = c.cat_id AND auth_read IN (' . $auth_restrict .') 
			ORDER BY c.cat_order, f.forum_order';
	}
	

	if ( !($result = $db->sql_query($sql)))
	{
		$error_msg = $lang['smartfeed_forum_access_reg'];
		$error = true;
	}

	if (!$error)
	{
		$allowed_forums = array();
		while ($row = $db->sql_fetchrow ($result)) 
		{ 
			$allowed_forums[] = $row['forum_id'];
		}
		
		if ($phpBB_forum_user && $mcrypt_loaded)
		
		{
		
			// Registered users may be in user groups. If so add these forums to the allowed forums
	
			$sql = 'SELECT DISTINCT a.forum_id, f.forum_name, c.cat_order, f.forum_order
				FROM ' . AUTH_ACCESS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug, ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c, ' . GROUPS_TABLE . ' g
				WHERE ug.user_id = ' . $user_id	. ' AND ug.user_pending = 0 
				AND a.group_id = ug.group_id AND ug.group_id = g.group_id AND 
				a.forum_id = f.forum_id AND f.cat_id = c.cat_id';
		
			if ( !($result = $db->sql_query($sql)))
			{
				$error_msg = $lang['smartfeed_forum_access_priv'];
				$error = true;
			}
			
			if (!$error)
			{
				while ($row = $db->sql_fetchrow ($result)) 
				{ 
					$allowed_forums[] = $row['forum_id'];
				}
			}
			
		}
		
		if (!$error)
		{
			// Sort allowed forums by forum_id and ensure there are no duplicates
			asort($allowed_forums);
			$allowed_forums = array_unique($allowed_forums);
		}
	}
}

if (!$error)
{

	// Now parse the URL field and get the forums the user wants to view
	
	$requested_forums = array();
	$query_string = ( !empty($HTTP_SERVER_VARS['QUERY_STRING']) ) ? $HTTP_SERVER_VARS['QUERY_STRING'] : '';
	$params = explode('&', $query_string);
	foreach ($params as $item)
	{
		if (substr($item,0,5) == 'forum')
		{
			$requested_forums[] = substr($item,6);
		}
	}
	// Sort requested forums by forum_id and ensure there are no duplicates
	asort($requested_forums);
	$requested_forums = array_unique($requested_forums);

	// The forums that will be fetched is the intersection of the requested and allowed forums. This prevents hacking
	// the URL to get feeds a user is not supposed to get. If no forums are specified on the URL field
	// then all forums that this user is authorized to access is assumed.
	
	$fetched_forums = (count($requested_forums) > 0) ? array_intersect($allowed_forums, $requested_forums): $allowed_forums;
	
	// Place forum numbers into a string suitable for use in a SQL "IN" statement. Note: if $fetched_forums_str is null, then NO posts should be fetched; the 
	// user has no permissions to any of the forums. 

	$fetched_forums_str = implode(',',$fetched_forums);
	if ($fetched_forums_str <> '')
	{
		$fetched_forums_str = ' AND f.forum_id IN (' . $fetched_forums_str . ')';
	}

	// Get the limit parameter. It limits the size of the newsfeed to a point in time from the present, either a day/hour/minute interval, 
	// or the time since the user's last visit. It should always exist.
	$limit = ( !empty($HTTP_GET_VARS['limit']) ) ? htmlspecialchars($HTTP_GET_VARS['limit']) : '';

	if ($limit == $lang['smartfeed_since_last_fetch_or_visit_value']) // i.e. use the user's last visit and show all selected items after this time in the feed
	{
		if ($phpBB_forum_user)
		{
			// Logic to retrieve last fetched date
			$sql = 'SELECT user_lastvisit
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $user_id;
		
			if ( !($result = $db->sql_query($sql)))
			{
				$error_msg = $lang['smartfeed_user_error'];
				$error = true;
			}
			$row = $db->sql_fetchrow ($result);
			$user_lastvisit = $row['user_lastvisit'];
		}
		else
		{
			$user_lastvisit = 0;
		}
		
		if (!$error)
		{
			// Check for a cookie. The cookie if it exists should contain the last newsfeed fetch time. Note that many if not
			// most newsreaders will ignore cookies. Some integrated with a browser, such as Sage for Firefox, should pick them up.
			$cookie_time = ($HTTP_COOKIE_VARS['smartfeed'] <> '') ? strtotime(($HTTP_COOKIE_VARS['smartfeed'])) : 0;
			// Whichever time is greater, the user_lastvisit time in the phpBB users table, or the cookie value, sets a time value
			// We want all posts after this time.
			$limit_text = max($user_lastvisit,  $cookie_time);
			if ($limit_text == 0) // No cookie value and non-authenticated user could return millions of posts.
			{
				$limit_text = SMARTFEED_DEFAULT_FETCH_TIME_LIMIT;
			}
			$limit_text_str = ' AND p.post_time > ' . $limit_text;
		}		
	}
	else if (($limit == $lang['smartfeed_last_week_value']) || ($limit == $lang['smartfeed_last_day_value']) || ($limit == $lang['smartfeed_last_12_hours_value']) || ($limit == $lang['smartfeed_last_6_hours_value']) || ($limit == $lang['smartfeed_last_3_hours_value']) || ($limit == $lang['smartfeed_last_1_hours_value']) || ($limit == $lang['smartfeed_last_30_minutes_value']) || ($limit == $lang['smartfeed_last_15_minutes_value']))
	{
		switch ($limit)
		{
			case $lang['smartfeed_last_week_value']:
				$limit_text = time() - (7 * 24 * 60 * 60);
				break;
			case $lang['smartfeed_last_day_value']:
				$limit_text = time() - (24 * 60 * 60);
				break;
			case $lang['smartfeed_last_12_hours_value']:
				$limit_text = time() - (12 * 60 * 60);
				break;
			case $lang['smartfeed_last_6_hours_value']:
				$limit_text = time() - (6 * 60 * 60);
				break;
			case $lang['smartfeed_last_3_hours_value']:
				$limit_text = time() - (3 * 60 * 60);
				break;
			case $lang['smartfeed_last_1_hours_value']:
				$limit_text = time() - (60 * 60);
				break;
			case $lang['smartfeed_last_30_minutes_value']:
				$limit_text = time() - (30 * 60);
				break;
			case $lang['smartfeed_last_15_minutes_value']:
				$limit_text = time() - (15 * 60);
		}
		$limit_text_str = ' AND p.post_time > ' . $limit_text;
	}
	else
	{
		// Bad parameter, trigger error
		$error_msg = $lang['smartfeed_limit_format_error'];
		$error = true;
	}
	
	// Validate the feed type next
	if (!$error)
	{
		$feed_type = ( !empty($HTTP_GET_VARS['feed_type']) ) ? htmlspecialchars($HTTP_GET_VARS['feed_type']) : '';

		if (!(($feed_type == SMARTFEED_ATOM_10_VALUE) || ($feed_type == SMARTFEED_RSS_20_VALUE) || ($feed_type == SMARTFEED_RSS_10_VALUE) || ($feed_type == SMARTFEED_RSS_091_VALUE)))
		{
			// Bad feed_type, trigger error
			$error_msg = $lang['smartfeed_feed_type_error'];
			$error = true;
		}
		else
		{
			if ($feed_type == SMARTFEED_RSS_091_VALUE)
			{
				// A proper RSS 0.91 feed should not exceed 15 items
				if ((SMARTFEED_MAX_ITEMS < 15) && (SMARTFEED_MAX_ITEMS > 0))
				{
					$limit_str = ' LIMIT ' . SMARTFEED_MAX_ITEMS;
				}
				else 
				{
					$limit_str = ' LIMIT 15';
				}
			}
			else if (SMARTFEED_MAX_ITEMS > 0)
			{
				$limit_str = ' LIMIT ' . SMARTFEED_MAX_ITEMS;
			}
			else
			{
				$limit_str = '';
			}
		}
	}
	
	// Validate the sort by parameter
	if (!$error)
	{
		$order_by = ( !empty($HTTP_GET_VARS['sort_by']) ) ? htmlspecialchars($HTTP_GET_VARS['sort_by']) : '';
		if ($order_by == 'standard')
		{
			$order_by_str = 'c.cat_order, f.forum_order, lp.post_time desc, p.post_time';
		}
		else if ($order_by == 'standard_desc')
		{
			$order_by_str = 'c.cat_order, f.forum_order, lp.post_time desc, p.post_time desc';
		}
		else if ($order_by == 'postdate')
		{
			$order_by_str = 'p.post_time';
		}
		else if ($order_by == 'postdate_desc')
		{
			$order_by_str = 'p.post_time desc';
		}
		else
		{
			// Bad sort_bye, trigger error
			$error_msg = $lang['smartfeed_sort_by_error'];
			$error = true;
		}
	}
	
	// Validate the new topics only parameter. If it does not show, it is not true. Any value other than 1 is false.
	if (!$error)
	{
		$topics_only = ( !empty($HTTP_GET_VARS['topicsonly']) ) ? intval($HTTP_GET_VARS['topicsonly']) : 0;
		if ($topics_only == 0)
		{
			$topics_only_str = '';
		}
		else if ($topics_only == '1')
		{
			$topics_only_str = ' AND t.topic_time > ' . $limit_text;
			// This logic allows the user to see only the first posts in new topics, if they so explicitly elected in smartfeed_url.php
			$first_post_only = ( !empty($HTTP_GET_VARS['firstpostonly']) ) ? intval($HTTP_GET_VARS['firstpostonly']) : 0;
			$first_post_only_str = '';
			if ($first_post_only <> 0)
			{
				if ($first_post_only <>1)
				{
					// Bad firstpostonly value, trigger error
					$error_msg = $lang['smartfeed_first_post_only_error'];
					$error = true;
				}
				else
				{
					$first_post_only_str = ' AND t.topic_first_post_id = p.post_id';
				}
			}
		}
		else
		{
			// Bad topics only value, trigger error
			$error_msg = $lang['smartfeed_topics_only_error'];
			$error = true;
		}
	}
			
	// Filter out users own posts, if they so elected
	if (!$error)
	{
		if ($phpBB_forum_user)
		{
			$removemine = ( !empty($HTTP_GET_VARS['removemine']) ) ? intval($HTTP_GET_VARS['removemine']) : '';
			if ($removemine == '')
			{
				$removemine_str = '';
			}
			else if ($removemine == '1')
			{
				$removemine_str = ' AND p.poster_id <> ' . $user_id ;
			}
			else
			{
				// Bad sort_bye, trigger error
				$error_msg = $lang['smartfeed_remove_yours_error'];
				$error = true;
			}
		}
	}
	
	// Validate the maximum size requested for the number of words in a post
	if (!$error)
	{
		$max_word_size = ( !empty($HTTP_GET_VARS['max_word_size']) ) ? htmlspecialchars($HTTP_GET_VARS['max_word_size']) : '';

		if (!(($max_word_size == $lang['smartfeed_max_words_wanted']) || (intval($max_word_size > 0)) ))
		{
			// Bad max_word_size, trigger error
			$error_msg = $lang['smartfeed_max_word_size_error'];
			$error = true;
		}
	}
	
	// Validate the private messages switch
	if (!$error)
	{
		$show_pms = ( !empty($HTTP_GET_VARS['pms']) ) ? intval($HTTP_GET_VARS['pms']) : 0;

		if (!$phpBB_forum_user && $show_pms)
		{
			// Switch not allowed for public users
			$error_msg = $lang['smartfeed_pms_not_for_public_users'];
			$error = true;
		}
		else if (($show_pms <> 1) && ($show_pms <> 0))
		{
			// Bad parameter value for private messages
			$error_msg = $lang['smartfeed_bad_pms_value'];
			$error = true;
		}
	}
	
	// Check for count limit parameter. It is not required, but if present should be a positive number only. It only has meaning if 
	// the sort_by parameter has the value "postdate_desc"
	if (!$error)
	{
		$count_limit = ( !empty($HTTP_GET_VARS['count_limit']) ) ? htmlspecialchars($HTTP_GET_VARS['count_limit']) : '';
		if ($count_limit <> '')
		{
			if ($order_by <> 'postdate_desc')
			{
				$error_msg = $lang['smartfeed_count_limit_consistency_error'];
				$error = true;
			}
			else if (!( intval($count_limit > 0) ))
			{
				$error_msg = $lang['smartfeed_count_limit_error'];
				$error = true;
			}
			else
			{
				if (($feed_type == SMARTFEED_RSS_091_VALUE) && ($count_limit > 0) && (SMARTFEED_MAX_ITEMS > 0)) 
				{
					$limit_str = ' LIMIT ' . min($count_limit, 15, SMARTFEED_MAX_ITEMS);
				}
				else if ($count_limit > 0)
				{
					if (SMARTFEED_MAX_ITEMS > 0)
					{
						$limit_str = ' LIMIT ' . min($count_limit, SMARTFEED_MAX_ITEMS);
					}
					else
					{
						$limit_str = ' LIMIT ' . $count_limit;
					}
				}
			}
		}
	}
	
	if (!$error)
	{
	
		if ($fetched_forums_str <> '') // User has permissions to at least one of the forums
		
		{

			// If no new posts since the last fetch, return a 304 HTTP code. No point in regenerating a potentially very long newsfeed!
			
			$sql = "SELECT max(p.post_time) AS Last_Post_Timestamp
				FROM " . POSTS_TABLE . ' lp, ' . FORUMS_TABLE . ' f, ' . TOPICS_TABLE . ' t, ' . CATEGORIES_TABLE . ' c, ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt, ' . USERS_TABLE . ' u
				WHERE lp.post_id = t.topic_last_post_id AND f.forum_id = t.forum_id AND
				f.cat_id = c.cat_id AND t.topic_id = p.topic_id AND p.post_id = pt.post_id AND p.poster_id = u.user_id ' . $removemine_str . $limit_text_str . $fetched_forums_str . $topics_only_str;
			
			if ( !($result = $db->sql_query($sql)))
			{
				$error_msg = $lang['smartfeed_retrieve_error'];
				$error = true;
			}
			else
			{
				$last_timestamp = $row['Last_Post_Timestamp'];
				doConditionalGet($last_timestamp); // Program may exit if no new content, returning 304 HTTP code 
			}
			
		}
	}
			
	if (!$error)
	{
	
		// Load the advertising fields with values from the serialized file. Serialization is used because our needs are simple and 
		// it does not have the overhead of a database table. Note that whereever the file is stored, it must be in a writeable location.

		if (!SMARTFEED_HIDE_ADVERTISING_INTERFACE)
		{
			$ad_data_path = $phpbb_root_path . SMARTFEED_ADVERTISING_INFO_PATH;
			$s = file($ad_data_path); // read file into an array
			if (!$s)
			{
			
				// Serialized file does not exist or is not readable, so try to initialize it with default values and save it
				$smartfeed_ads = new Smartfeed_Ad_Configuration;
			
				// Store the data
				$z = serialize($smartfeed_ads);
				$handle = fopen($ad_data_path, 'w');
				if (!$handle)
				{
					$error = true;
					$error_msg = $lang['smartfeed_ad_data_access_error'];
				}
				else
				{
					$retval = fwrite($handle, $z);
					if ($retval == false)
					{
						$error = true;
						$error_msg = $lang['smartfeed_ad_data_access_error'];
					}
					else
					{
						fclose($handle);
					}
				}
				
			}
			else
			{
				$smartfeed_ads = unserialize(implode("", $s)); // Same as $smartfeed_ads = new Smartfeed_Ad_Configuration;
			}
		}
	}
	
	if (!$error)
	
	{
		
		// All systems are GO. The voluminous error checking is over and it is now okay to create and display the feed
		
		$display_ads = $smartfeed_ads->display_ads && (!SMARTFEED_HIDE_ADVERTISING_INTERFACE);
	
		$rss = new UniversalFeedCreator();
		$rss->useCached();
		$rss->title = $lang['smartfeed_feed_title'];
		$rss->description = $lang['smartfeed_feed_description'];
		$rss->link = ($feed_type == SMARTFEED_ATOM_10_VALUE) ? SMARTFEED_SITE_URL . 'smartfeed.' . $phpEx . '?' . $HTTP_SERVER_VARS['QUERY_STRING'] : SMARTFEED_SITE_URL . 'smartfeed.' . $phpEx . '?' . htmlspecialchars($HTTP_SERVER_VARS['QUERY_STRING']);
		$rss->syndicationURL = SMARTFEED_SITE_URL . 'smartfeed.' . $phpEx;
		
		$image = new FeedImage();
		$image->title = strip_tags($lang['smartfeed_image_title']); // Enhance to use default logo if not specified
		$image->url = SMARTFEED_SITE_URL . SMARTFEED_FEED_IMAGE_PATH;
		$image->link = $rss->link;
		$image->description = convert_encoding(strip_tags($board_config['site_desc']));

		$rss->image = $image;
		
		// Add some RSS 2.0 tags
		$rss->language = SMARTFEED_RFC1766_LANG;
		$rss->ttl = SMARTFEED_TTL;
		$rss->copyright = ($lang['smartfeed_copyright'] <> '') ? $lang['smartfeed_copyright'] : '';
		$rss->editor = ($lang['smartfeed_editor'] <> '') ? $lang['smartfeed_editor'] : '';
		$rss->smartfeed_webmaster = ($lang['smartfeed_webmaster'] <> '') ? $lang['smartfeed_webmaster'] : '';

		// Use for debugging if necessary. The first item in the feed will contain debugging info, providing you placed info to debug in $debug_info
		if ($debug)
		{
			$item = new FeedItem();
			$item->title = 'Debug Information';
			$item->description = $debug_info;
			$rss->addItem($item);
		}
		
		// Place an ad at the top of the feed if so directed
		if ($display_ads && $smartfeed_ads->enable_block_1 && !($smartfeed_ads->show_ads_to_public_only && $phpBB_forum_user))
		{
			$item = new FeedItem();
			$item->title = entity_decode($lang['smartfeed_ad_feed_category'] . ': ' . $smartfeed_ads->block_1_title);
			$item->link = entity_decode($smartfeed_ads->block_1_link);
			$item->description = entity_decode($smartfeed_ads->block_1_desc);
			$item->descriptionHtmlSyndicated = true;
			$item->category = entity_decode($lang['smartfeed_ad_feed_category']);
			$item->source = SMARTFEED_SITE_URL;
			$item->guid = $item->link;
			$item->date = time();
			$item->pubDate = time();
			$rss->addItem($item);
		}
		
		// Show private messages at top of the feed that are unread, if any, but only if the user so requested
		if ($show_pms)
		
		{
		
			// Run a query to find out if there are any new private messages for this user.
			
			$sql = 'SELECT user_unread_privmsg, user_last_privmsg FROM ' . USERS_TABLE . ' where user_id = ' . $user_id;
			
			if ( !($result = $db->sql_query($sql)))
			{
				$error_msg = $lang['smartfeed_pm_count_error'];
				$error = true;
			}
			
			else
			{

				$row = $db->sql_fetchrow ($result);
			
				// If there are any unread private messages, display each message as an item in the newsfeed
			
				if ($row['user_unread_privmsg'] > 0)
			
				{
			
					$sql2 = 'SELECT u.username AS username_1, u.user_id AS user_id_1, u2.username AS username_2, u2.user_id AS user_id_2, u.user_sig_bbcode_uid,
								u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate, u.user_msnm, u.user_viewemail,
								u.user_rank, u.user_sig, u.user_avatar, u.user_allowhtml, u.user_allowsmile, pm.*, pmt.privmsgs_bbcode_uid, pmt.privmsgs_text
							FROM ' . PRIVMSGS_TABLE . ' pm, ' . PRIVMSGS_TEXT_TABLE . ' pmt, ' . USERS_TABLE . ' u, ' . USERS_TABLE . " u2 
							WHERE pmt.privmsgs_text_id = pm.privmsgs_id 
							AND u.user_id = pm.privmsgs_from_userid 
							AND u2.user_id = pm.privmsgs_to_userid
							AND pm.privmsgs_to_userid = $user_id AND privmsgs_date > " . $row['user_last_privmsg'] . ' AND privmsgs_type = ' . PRIVMSGS_UNREAD_MAIL;

					if ( !($result2 = $db->sql_query($sql2)))
					{
						$error_msg = $lang['smartfeed_pm_retrieve_error'];
						$error = true;
					}
					else
					{
					
						while ($row2 = $db->sql_fetchrow ($result2))
						{ 
							
							$item = new FeedItem();
							$item->title = $lang['Private_Message'] . ' ' . strtolower($lang['From']) . ' ' . $row2['username_1'] . ' :: ' . convert_encoding($row2['privmsgs_subject']);
							$item->link = SMARTFEED_SITE_URL . "privmsg.$phpEx?folder=inbox&mode=read&" . POST_POST_URL . '=' . $row2['privmsgs_id'];
							$item->date = $row2['privmsgs_date'];
							$item->pubDate = $row2['privmsgs_date'];
							$item->source = SMARTFEED_SITE_URL;
							$item->category = $lang['Private_Message'];
							$item->guid = $item->link;
							$item->comments = $item->link;
							$item->descriptionHtmlSyndicated = true;
							if (($feed_type==SMARTFEED_RSS_091_VALUE) || ($feed_type==SMARTFEED_RSS_20_VALUE)) // RSS 0.91 and 2.0 requires an email field to validate. Use a fake email address set in smartfeed_constants.php unless in user profile it says it is okay to show email address.
							{
								$item->author = (($row2['user_viewemail'] == '1') && ((SMARTFEED_PRIVACY_MODE == false) || $phpBB_forum_user)) ? $row2['user_email'] . ' (' . $row2['username_1']  . ')' : SMARTFEED_FAKE_EMAIL . ' (' . $row2['username_1'] . ')';
							}					
							else
							{
								$item->author = $row2['username_1'];
							}	
							
							// Begin: The following code minimally modified from privmsg.php (2.0.22). That's why it works!
							
							$private_message = $lang['smartfeed_pm_read_statement'] . $row2['privmsgs_text'];
							$bbcode_uid = $row2['privmsgs_bbcode_uid'];
	
							if ( $board_config['allow_sig'] )
							{
								$user_sig = ( $row2['privmsgs_attach_sig'] && $row2['user_sig'] != '' && $board_config['allow_sig'] && ((SMARTFEED_PRIVACY_MODE == false) || $phpBB_forum_user) ) ? $row2['user_sig'] : '';
							}
							else
							{
								$user_sig = '';
							}
						
							$user_sig = convert_encoding($user_sig);
							$user_sig_bbcode_uid = $row2['user_sig_bbcode_uid'];
						
							//
							// If the board has HTML off but the post has HTML
							// on then we process it, else leave it alone
							//
							if ( !$board_config['allow_html'] || !$row2['user_allowhtml'])
							{
								if ( $user_sig != '')
								{
									$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
								}
						
								if ( $row2['privmsgs_enable_html'] )
								{
									$private_message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $private_message);
								}
							}
						
							if ( $user_sig != '' && $row2['privmsgs_attach_sig'] && $user_sig_bbcode_uid != '' )
							{
								$user_sig = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $user_sig);
							}
						
							if ( $bbcode_uid != '' )
							{
								$private_message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($private_message, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $private_message);
							}
						
							$private_message = make_clickable($private_message);
						
							if ( $row2['privmsgs_attach_sig'] && $user_sig != '' )
							{
								$private_message .= '<br /><br />_________________<br />' . make_clickable($user_sig); 
							} 	
							// End: The following code minimally modified from privmsg.php
							
							$private_message = preg_replace('/\\n/', '<br />', $private_message); 
							$item->description = entity_decode($private_message);
							
							$rss->addItem($item); // Add this private message to the feed
							$item_count++;
											
							// Place an ad inside the feed every X items, if so enabled
							if ($display_ads && $smartfeed_ads->enable_block_2 && ($item_count % $smartfeed_ads->block_2_num_items_to_skip == 0) && !(($smartfeed_ads->show_ads_to_public_only == true) && $phpBB_forum_user))
							{
								// Place an ad at the middle of the feed
								$item = new FeedItem();
								$item->title = entity_decode($lang['smartfeed_ad_feed_category'] . ': ' . $smartfeed_ads->block_2_title);
								$item->link = entity_decode($smartfeed_ads->block_2_link);
								$item->description = entity_decode($smartfeed_ads->block_2_desc);
								$item->descriptionHtmlSyndicated = true;
								$item->category = entity_decode($lang['smartfeed_ad_feed_category']);
								$item->source = SMARTFEED_SITE_URL;
								$item->guid = $item->link;
								$item->date = time();
								$item->pubDate = time();
								$rss->addItem($item);
							}					
	
						}
					
					}
					
				}
				
			}
			
		}
		
		if (!$error)
		
		{
			
			// Create a list of messages for this user that presumably have not been seen after the date and time requested by the limit parameter.
			// Show only authorized forums.
		
			$sql = "SELECT c.cat_title, f.forum_name, t.topic_title, t.topic_id, p.post_time, p.post_username, u.username, u.user_id, pt.post_text, pt.post_subject, pt.post_id, u.user_allowhtml,
				t.topic_first_post_id, u.user_viewemail, u.user_email, u.user_sig, pt.bbcode_uid, u.user_sig_bbcode_uid, u.user_timezone, p.enable_sig, p.enable_html, u.user_allowsmile, p.enable_smilies
				FROM " . POSTS_TABLE . ' lp, ' . FORUMS_TABLE . ' f, ' . TOPICS_TABLE . ' t, ' . CATEGORIES_TABLE . ' c, ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt, ' . USERS_TABLE . ' u
				WHERE lp.post_id = t.topic_last_post_id AND f.forum_id = t.forum_id AND
				f.cat_id = c.cat_id AND t.topic_id = p.topic_id AND p.post_id = pt.post_id AND p.poster_id = u.user_id ' . $removemine_str . $limit_text_str . $fetched_forums_str . $topics_only_str . $first_post_only_str . '
				ORDER BY ' . $order_by_str . $limit_str;

			if ( !($result = $db->sql_query($sql)))
			{
				$error_msg = $lang['smartfeed_retrieve_error'];
				$error = true;
			}
			else
			{

				while (($row = $db->sql_fetchrow ($result)) && ($fetched_forums_str <> '')) 
				{ 
				
					$user_timezone = (float) $row['user_timezone'];
	
					$item = new FeedItem();
					if ($row['post_subject'] == '') 
					{
						$item->title = (SMARTFEED_SUPPRESS_FORUM_NAMES) ? convert_encoding($row['topic_title']) : $row['forum_name'] . ' :: ' . convert_encoding($row['topic_title']);
					}
					else
					{
						$item->title = (SMARTFEED_SUPPRESS_FORUM_NAMES) ? convert_encoding($row['post_subject']) : convert_encoding($row['forum_name'] . ' :: ' . $row['post_subject']);
					}
					if ($row['topic_first_post_id'] <> $row['post_id'])
					{
						$first_post_for_topic = false;
						if (SMARTFEED_SHOW_USERNAME_IN_REPLIES)
						{
							$row['username'] = ($row['user_id'] == ANONYMOUS) ? $row['post_username'] : $row['username'];
							$item->title .= ($row['username'] == '') ? ' :: ' . $lang['smartfeed_reply_by'] . ' ' . $lang['Guest'] : ' :: ' . $lang['smartfeed_reply_by'] . ' ' . $row['username'];
						}
						else
						{
							$item->title .= ' :: ' . $lang['smartfeed_reply'];
						}
					}
					else
					{
						$first_post_for_topic = true;
						if (SMARTFEED_SHOW_USERNAME_IN_FIRST_TOPIC_POST)
						{
							$row['username'] = ($row['user_id'] == ANONYMOUS) ? $row['post_username'] : $row['username'];
							$item->title .= ' :: ' . $lang['smartfeed_posted_by'] . ' ' . $row['username'];
						}
					}
					
					$item->link = SMARTFEED_SITE_URL . 'viewtopic.' . $phpEx . '?' . POST_POST_URL . '=' . $row['post_id'] . '#' . $row['post_id'];
					// This logic ensures the time shown for each item in the newsfeed reflects the time in the timezone based on the users phpBB profile.
					// Post times are stored in the database in UT (GMT), so for the feeds to show accurately time must be offset from UT/GMT
					$item->date = $row['post_time'] + ($user_timezone * 3600);
					$item->pubDate = $row['post_time'] + ($user_timezone * 3600);
					$item->source = SMARTFEED_SITE_URL;
					$item->category = $row['cat_title'];
					$item->guid = $item->link;
					$item->descriptionHtmlSyndicated = true;
					$item->comments = SMARTFEED_SITE_URL . 'posting.' . $phpEx . '?mode=reply&' . POST_TOPIC_URL . '=' . $row['topic_id'];
					if (($feed_type==SMARTFEED_RSS_091_VALUE) || ($feed_type==SMARTFEED_RSS_20_VALUE)) // RSS 0.91 and 2.0 requires an email field to validate. Use a fake email address set in smartfeed_constants.php unless in user profile it says it is okay to show email address.
					{
						$row['username'] = ($row['user_id'] == ANONYMOUS) ? $row['post_username'] : $row['username'];
						$row['username'] = ($row['username'] == '') ? $lang['Guest'] : $row['username'];
						$item->author = (($row['user_viewemail'] == '1') && ((SMARTFEED_PRIVACY_MODE == false) || $phpBB_forum_user)) ? $row['user_email'] . ' (' . $row['username']  . ')' : SMARTFEED_FAKE_EMAIL . ' (' . $row['username'] . ')';
					}               
					else
					{
						$row['username'] = ($row['user_id'] == ANONYMOUS) ? $row['post_username'] : $row['username'];
						$row['username'] = ($row['username'] == '') ? $lang['Guest'] : $row['username'];
						$item->author = $row['username'];
					}
					
					// Begin: The following code minimally modified from viewtopic.php (2.0.22). That's why it works!
					
					$post_text = convert_encoding($row['post_text']);
					$bbcode_uid = $row['bbcode_uid'];
					
					$user_sig = ( $row['enable_sig'] && $row['user_sig'] != '' && $board_config['allow_sig'] && ((SMARTFEED_PRIVACY_MODE == false) || $phpBB_forum_user) ) ? $row['user_sig'] : '';
					$user_sig = convert_encoding($user_sig);
					$user_sig_bbcode_uid = $row['user_sig_bbcode_uid'];
					
					//
					// Note! The order used for parsing the message _is_ important, moving things around could break any
					// output
					//
					
					//
					// If the board has HTML off but the post has HTML
					// on then we process it, else leave it alone
					//
					if ( !$board_config['allow_html'] || !$row['user_allowhtml'])
					{
						if ( $user_sig != '' )
						{
							$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
						}
					
						if ( $row['enable_html'] )
						{
							$post_text = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $post_text);
						}
					}
					
					//
					// Parse message and/or sig for BBCode if reqd
					//
					
					if ($user_sig != '' && $user_sig_bbcode_uid != '')
					{
						$user_sig = ($board_config['allow_bbcode']) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
					}
					
					if ($bbcode_uid != '')
					{
						$post_text = ($board_config['allow_bbcode']) ? bbencode_second_pass($post_text, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $post_text);
					}
					
					if ( $user_sig != '' )
					{
						$user_sig = '<br />_________________<br />' . make_clickable($user_sig);
					}
					
					//
					// Parse smilies
					//
					if ( $board_config['allow_smilies'] )
					{
						if ( $row['user_allowsmile'] && $user_sig != '' )
						{
							$user_sig = smilies_pass_smartfeed($user_sig);
						}
						
						if ( $row['enable_smilies'] )
						{
							$post_text = smilies_pass_smartfeed($post_text);
						}
					}
					$post_text = make_clickable($post_text . $user_sig);
					
					// End: The following code minimally modified from viewtopic.php
					
					$post_text = preg_replace('/\\n/', '<br />', $post_text);
					
					$item->link = SMARTFEED_SITE_URL . 'viewtopic.' . $phpEx . '?' . POST_POST_URL . '=' . $row['post_id'] . '#' . $row['post_id'];
					
					// Limit size of post text, if requested
					$post_text = ($max_word_size <> $lang['smartfeed_max_words_wanted']) ? truncate_words($post_text, $max_word_size) : $post_text;
					
					$item->description = entity_decode($post_text);
					
					$rss->addItem($item); // Add this post to the feed
					$item_count++;
					
					// Place an ad inside the feed ever X items, if so enabled
					if ($display_ads && $smartfeed_ads->enable_block_2 && ($item_count % $smartfeed_ads->block_2_num_items_to_skip == 0) && !(($smartfeed_ads->show_ads_to_public_only == true) && $phpBB_forum_user))
					{
						// Place an ad at the middle of the feed
						$item = new FeedItem();
						$item->title = entity_decode($lang['smartfeed_ad_feed_category'] . ': ' . $smartfeed_ads->block_2_title);
						$item->link = entity_decode($smartfeed_ads->block_2_link);
						$item->description = entity_decode($smartfeed_ads->block_2_desc);
						$item->descriptionHtmlSyndicated = true;
						$item->category = entity_decode($lang['smartfeed_ad_feed_category']);
						$item->source = SMARTFEED_SITE_URL;
						$item->guid = $item->link;
						$item->date = time();
						$item->pubDate = time();
						$rss->addItem($item);
					}      
	
				}
				
				// If Last Fetch was selected, set a cookie for the current time, so that posts before the cookie date will not be retrieved the next time this script is called
				// Note that cookies are often not handled by feed reader appliations, particularly those installed on the desktop like FeedReader. However, browser based
				// extensions like Sage for Firefox will set cookies.
				if ($limit == $lang['smartfeed_since_last_fetch_or_visit_value'])
				{
					$cookie_set = setcookie('smartfeed', date('r', time()), time()+60*60*24*7, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
				}
				
				if ($display_ads && $smartfeed_ads->enable_block_3 && !(($smartfeed_ads->show_ads_to_public_only == true) && $phpBB_forum_user))
				{
					// Place an ad at the bottom of the feed
					$item = new FeedItem();
					$item->title = entity_decode($lang['smartfeed_ad_feed_category'] . ': ' . $smartfeed_ads->block_3_title);
					$item->link = entity_decode($smartfeed_ads->block_3_link);
					$item->description = entity_decode($smartfeed_ads->block_3_desc);
					$item->descriptionHtmlSyndicated = true;
					$item->category = entity_decode($lang['smartfeed_ad_feed_category']);
					$item->source = SMARTFEED_SITE_URL;
					$item->guid = $item->link;
					$item->date = time();
					$item->pubDate = time();
					$rss->addItem($item);
				}
	
				if ($reset_user_lastvisit)
				{
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET USER_LASTVISIT = ' . time() . 
						' WHERE user_id = ' . $user_id;
						
					if ( !($result = $db->sql_query($sql)) )
					{
						$error_msg = $lang['smartfeed_reset_error'];
						$error = true;
					}
				}
	
				$rss->outputFeed($feed_type);				
			}
		}
	}
}

if ($error)
{

	// Send the error in the newsfeed itself, but with no other items
	
	if (!isset($rss))
	
	{
	
		$rss = new UniversalFeedCreator();
		$rss->useCached();
		$rss->title = $lang['smartfeed_feed_title'];
		$rss->description = $lang['smartfeed_feed_description'];
		$rss->link = SMARTFEED_SITE_URL . 'smartfeed.' . $phpEx;
		$rss->syndicationURL = SMARTFEED_SITE_URL . 'smartfeed.' . $phpEx;
		
		// Some RSS 2.0 tags
		$rss->language = SMARTFEED_RFC1766_LANG;
		$rss->pubDate = time();
		$rss->ttl = SMARTFEED_TTL;
		$rss->copyright = ($lang['smartfeed_copyright'] <> '') ? $lang['smartfeed_copyright'] : '';
		$rss->editor = ($lang['smartfeed_editor'] <> '') ? $lang['smartfeed_editor'] : '';
		$rss->smartfeed_webmaster = ($lang['smartfeed_webmaster'] <> '') ? $lang['smartfeed_webmaster'] : '';
	
	}
	
	$item = new FeedItem();
	$item->title = $lang['smartfeed_error_title'];
	$item->link = SMARTFEED_SITE_URL . 'smartfeed.' . $phpEx;
	$item->source = SMARTFEED_SITE_URL;
	$item->description = sprintf($lang['smartfeed_error_introduction'], SMARTFEED_SITE_URL . 'smartfeed_url.' . $phpEx) . $error_msg;
	
	$rss->addItem($item);	
	$rss->outputFeed($feed_type);				
}

// Remove session as they can clog up the sessions table on a busy board. This code copied from session.php (phpBB version 2.0.22) but is slightly modified
// so it doesn't trigger a headers already sent error

$session_user_id = (int) (trim($userdata['$session_user_id']) == '') ? ANONYMOUS : $userdata['$session_user_id'];
$sql = 'DELETE FROM ' . SESSIONS_TABLE . " 
	WHERE session_id = '" . $userdata['session_id'] ."' 
		AND session_user_id = " . $session_user_id;
if ( !$db->sql_query($sql) )
{
	die('Error removing user session: ' . $sql);
}

//
// Remove this auto-login entry (if applicable)
//
if ( isset($userdata['session_key']) && $userdata['session_key'] != '' )
{
	$autologin_key = md5($userdata['session_key']);
	$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
		WHERE user_id = ' . $session_user_id . "
			AND key_id = '$autologin_key'";
	if ( !$db->sql_query($sql) )
	{
		die('Error removing auto-login key '.$sql);
	}
}
	
function decrypt($encoded_64, $key)
{

    $decoded_64=base64_decode($encoded_64);
    $td = mcrypt_module_open('cast-256', '', 'ecb', '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $decrypted_data = mdecrypt_generic($td, $decoded_64);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return $decrypted_data;
	
}  

function doConditionalGet($timestamp) 
{

	// This code found at: http://simon.incutio.com/archive/2003/04/23/conditionalGet, modified to use $HTTP_SERVER_VARS
	$last_modified = substr(date('r', $timestamp), 0, -5).'GMT';
	$etag = '"'.md5($last_modified).'"';
	// Send the headers
	header("Last-Modified: $last_modified");
	header("ETag: $etag");
	// See if the client has provided the required headers
	$if_modified_since = isset($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']) ?
		stripslashes($HTTP_SERVER_VARS['HTTP_IF_MODIFIED_SINCE']) :
		false;
	$if_none_match = isset($HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH']) ?
		stripslashes($HTTP_SERVER_VARS['HTTP_IF_NONE_MATCH']) : 
		false;
	if (!$if_modified_since && !$if_none_match) 
	{
		return;
	}
	// At least one of the headers is there - check them
	if ($if_none_match && $if_none_match != $etag) 
	{
		return; // etag is there but doesn't match
	}
	if ($if_modified_since && $if_modified_since != $last_modified) 
	{
		return; // if-modified-since is there but doesn't match
	}
	// Nothing has changed since their last request - serve a 304 and exit
	header('HTTP/1.0 304 Not Modified');
	exit;
	
}

// Define html_entity_decode() for users prior to PHP 4.3.0; this code is borrowed from PHP.net
function entity_decode($string)
{
	if (!function_exists('html_entity_decode'))
	{
		// replace numeric entities
		$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
		$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
		// replace literal entities
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($string, $trans_tbl);
	}
	else
	{
		return html_entity_decode($string);
	}
}

function truncate_words($text, $max_words)
{
	$word_array = explode(' ',$text);
	if (count($word_array) < $max_words)
	{
		return rtrim($text);
	}
	else
	{
		$truncated_text = '';
		for ($i=0; $i<$max_words; $i++)
		{
			$truncated_text .= $word_array[$i] . ' ';
		}
		return rtrim($truncated_text) . '...';
	}

}

function smilies_pass_smartfeed($message)
{

	// This is a minimally modified version of smilies_pass from /includes/bbcode.php. The only modification is to 
	// insert the full path name for the smilie image. This code taken from phpBB version 2.0.22.
	
	static $orig, $repl;

	if (!isset($orig))
	{
		global $db, $board_config;
		$orig = $repl = array();

		$sql = 'SELECT * FROM ' . SMILIES_TABLE;
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
		}
		$smilies = $db->sql_fetchrowset($result);

		if (count($smilies))
		{
			usort($smilies, 'smiley_sort');
		}

		for ($i = 0; $i < count($smilies); $i++)
		{
			$orig[] = "/(?<=.\W|\W.|^\W)" . preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
			$repl[] = '<img src="'. SMARTFEED_SITE_URL . $board_config['smilies_path'] . '/' . $smilies[$i]['smile_url'] . '" alt="' . $smilies[$i]['emoticon'] . '" border="0" />';
		}
	}

	if (count($orig))
	{
		$message = preg_replace($orig, $repl, ' ' . $message . ' ');
		$message = substr($message, 1, -1);
	}
	
	return $message;
}

function convert_encoding ($text)

{
	// This function converts text into something that is less likely to cause parsing errors. For example, curly quotes in the Windows-1252
	// encoding (often cut and pasted from MS Word into text areas on the phpBB posting screen) may cause the feed to be unparseable. Currently
	// the function is hardcoded to convert to ISO-8859-1, which may insert some odd characters into your feed. Yes, it is ugly, but it is better
	// than having the feed not validate, which would upset your users much more! 
		
	if (ini_get('mbstring') == '')
	{
		return $text;
	}
	else
	{
		return mb_convert_encoding($text,'ISO-8859-1','Windows-1252');
	}
}

?>
