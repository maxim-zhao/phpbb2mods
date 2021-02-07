<?php
/***************************************************************************
                              smartfeed_url.php
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

// This is the user interface for the Smartfeed software. Users can use it to create a URL they can use 
// with newsfeed readers like FeedReader or web based personal news aggregators like bloglines.com.
// Unlike most RSS newsfeeds this one can dip into member-only and user group permission based
// forums which should not be accessible to the world and return posts in these topics. It handles
// RSS and Atom feeds.

define('IN_PHPBB', true);
$phpbb_root_path = './';

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

include($phpbb_root_path . 'includes/smartfeed_constants.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_smartfeed.' . $phpEx);
include($phpbb_root_path . 'includes/smartfeed_ads.class.' . $phpEx);

//
// End session management
//

// Find out if mcrypt is enabled in this installation of PHP. If mcrypt is not loaded then only public forums can be shown in the feed
$extensions = get_loaded_extensions();
$mcrypt_loaded = in_array('mcrypt', $extensions);

$page_title = $lang['smartfeed_page_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$ad_data_path = $phpbb_root_path . SMARTFEED_ADVERTISING_INFO_PATH;

if ($HTTP_SERVER_VARS['REQUEST_METHOD'] == 'GET')
{

	$error_msg = '';
	
	$template->set_filenames(array('smartfeed' => 'smartfeed_url_body.tpl'));
	
	// This logic ensures that those with special privileges (moderators, administrators) always see forums where they have read permissions
	$auth_restrict = ($userdata['session_user_id'] <> ANONYMOUS && $mcrypt_loaded) ? AUTH_ALL  . ',' . AUTH_REG : AUTH_ALL;
	
	if ($mcrypt_loaded)
	{
		switch($userdata['user_level'])
		{
			case USER:
				// Retrieve a list of forum_ids that all members can access
				$sql = 'SELECT f.forum_id, f.forum_name, c.cat_order, f.forum_order, f.auth_read
					FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
					WHERE f.cat_id = c.cat_id AND auth_read IN (' . $auth_restrict .') 
					ORDER BY c.cat_order, f.forum_order';
				break;
			case MOD:
				$sql = 'SELECT f.forum_id, f.forum_name, c.cat_order, f.forum_order, f.auth_read
					FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
					WHERE f.cat_id = c.cat_id AND auth_read IN (' . $auth_restrict . ',' . AUTH_MOD .') 
					ORDER BY c.cat_order, f.forum_order';
				break;
			case ADMIN:
				$sql = 'SELECT f.forum_id, f.forum_name, c.cat_order, f.forum_order, f.auth_read
					FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
					WHERE f.cat_id = c.cat_id 
					ORDER BY c.cat_order, f.forum_order';
				break;
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
		message_die(GENERAL_ERROR, 'Could not query forum information', '', __LINE__, __FILE__, $sql);
	}
	
	// We have to do a lot of array processing mainly because MySQL 3.x can't handle unions or 
	// intersections. Basically we need to figure out: of all forums, which are those this 
	// user can potentially read? We only want to show posts for forums for which a user
	// has read privileges.
	$forum_ids = array();
	$forum_names = array();
	$cat_orders = array();
	$forum_orders = array();
	$auth_read = array();
	  
	$i=0;
	while ($row = $db->sql_fetchrow ($result)) 
	{ 
		$forum_ids [$i] = $row['forum_id'];
		$forum_names [$i] = $row['forum_name'];
		$cat_orders [$i] = $row['cat_order'];
		$forum_orders [$i] = $row['forum_order'];
		$auth_read [$i] = $row['auth_read'];
		$i++;
	}
	
	// Now we need to add to our forums array other forums that may be private for which
	// the user has access.
	
	if ($userdata['session_logged_in'] && $mcrypt_loaded)
	{
		$sql = 'select distinct a.forum_id, f.forum_name, c.cat_order, f.forum_order, f.auth_read
			from ' . AUTH_ACCESS_TABLE . ' a, ' . USER_GROUP_TABLE . ' ug, ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c, ' . GROUPS_TABLE . ' g
			where ug.user_id = ' . $userdata['session_user_id']
			. ' AND ug.user_pending = 0 
			AND a.group_id = ug.group_id AND ug.group_id = g.group_id AND  
			a.forum_id = f.forum_id AND f.cat_id = c.cat_id';
	
		if ( !($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not query forum information', '', __LINE__, __FILE__, $sql);
		}
	
		while ($row = $db->sql_fetchrow ($result)) 
		{ 
			$forum_ids [$i] = $row['forum_id'];
			$forum_names [$i] = $row['forum_name'];
			$cat_orders [$i] = $row['cat_order'];
			$forum_orders [$i] = $row['forum_order'];
			$auth_read [$i] = $row['auth_read'];
			$i++;
		}
	}
	$i--;
	
	// Sort forums so they appear as they would appear on the main index. This makes for a more 
	// natural presentation.
	
	array_multisort($cat_orders, SORT_ASC, $forum_orders, SORT_ASC, $forum_ids, SORT_ASC, $forum_names, SORT_ASC, $auth_read, SORT_ASC);
	
	// now print the forums on the web page, each forum being a checkbox with appropriate label
	for ($j=0; $j<=$i; $j++) 
	{
	
		// Don't print if a duplicate
	
		if (!(($j>0) && ($cat_orders[$j] == $cat_orders[$j-1]) && ($forum_orders[$j] == $forum_orders[$j-1]) && ($forum_names[$j] == $forum_names[$j-1]))) 
	
		{    
	
			switch($auth_read[$j])
			{
				case AUTH_REG:
					$auth_label = $lang['smartfeed_auth_reg_text'];
					break;
				case AUTH_ACL:
					$auth_label = $lang['smartfeed_auth_acl_text'];
					break;
				case AUTH_MOD:
					$auth_label = $lang['smartfeed_auth_mod_text'];
					break;
				case AUTH_ADMIN:
					$auth_label = $lang['smartfeed_auth_admin_text'];
					break;
				default:
					$auth_label = '';
			}
				
	
			$template->assign_block_vars('forums', array( 
				'FORUM_NAME' => 'forum_' . $forum_ids [$j],
				'FORUM_LABEL' => $forum_names[$j],
				'FORUM_AUTH' => $auth_label));
		}
	
	}
	
	// Starting in version 1.2, true encryption is used for non-public usage. A decryption key is stored for the user in the phpbb_users table 
	// in a new column called user_smartfeed_key.
	
	// The encoded password as stored in the database is encrypted with the user's smartfeed key and is then placed on the URL string for authentication. 
	// If mcrypt is not available, only public forums can be selected.
	
	if (($userdata['session_logged_in']) && ($mcrypt_loaded))
	{
		$sql = 'SELECT user_password, user_smartfeed_key
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . $userdata['session_user_id'];
	
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		}
	
		$row = $db->sql_fetchrow($result);
		$encrypt_field = $row['user_password'];
		$encrypt_key = $row['user_smartfeed_key'];
		
		if (strlen(trim($encrypt_key)) == 0)
		{
			// First time usage, so generate and store the key
			$encrypt_key = dss_rand();
			$sql = 'UPDATE ' . USERS_TABLE . " 
				SET user_smartfeed_key = '" . $encrypt_key . "' 
				WHERE user_id = " . $userdata['session_user_id'];
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error updating user_smartfeed_key', '', __LINE__, __FILE__, $sql);
			}
		}
	
		$encrypted_data = encrypt($encrypt_field, $encrypt_key);
		$encrypted_data_with_ip = encrypt($encrypt_field . '~' . $HTTP_SERVER_VARS['REMOTE_ADDR'], $encrypt_key);	
	}
	else
	{
		$encrypted_data = 'NONE';
		$encrypted_data_with_ip = 'NONE';
	}
	
	// Fill template with labels and values
	
	if (!$mcrypt_loaded)
	{
		$template->assign_block_vars('switch_no_mcrypt', array());
		$template->assign_vars(array('MCRYPT_NOT_INSTALLED_MSG' => $lang['smartfeed_no_mcrypt']));
	}

	if (!$userdata['session_logged_in'])
	{
		$template->assign_block_vars('switch_not_logged_in', array());
		$template->assign_vars(array('NOT_LOGGED_IN_MSG' => $lang['smartfeed_not_logged_in']));
	}
	else
	{
		$template->assign_block_vars('switch_logged_in', array());
		$template->assign_vars(array('L_LASTVISIT' => $lang['smartfeed_lastvisit'],
			'L_IP_AUTHENTICATION' => $lang['smartfeed_ip_auth']));
		if (SMARTFEED_REQUIRE_IP_AUTHENTICATION == false)
		{
			$template->assign_block_vars('switch_no_required_ip_authentication', array());	
		}
		else
		{
			$template->assign_block_vars('switch_required_ip_authentication', array());	
		}
	}
	
	if (($userdata['user_level'] == ADMIN) && (SMARTFEED_HIDE_ADVERTISING_INTERFACE == false))
	{
	
		// Load the advertising fields with values from the serialized file. Serialization is used because our needs are simple and 
		// it does not have the overhead of a database table. Note that whereever the file is stored, it must be in a writeable location.
		
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
				$error_msg = $lang['smartfeed_ad_data_access_error'];
			}
			else
			{
				$retval = fwrite($handle, $z);
				if ($retval == false)
				{
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
	
		$template->assign_block_vars('switch_administrator', array());
		$template->assign_vars(array(
			'CHECKED_ADS' => ($smartfeed_ads->display_ads == true) ? 'checked="checked" ' : '',
			'CHECKED_TOP_AD' => ($smartfeed_ads->enable_block_1 == true) ? 'checked="checked" ' : '',
			'CHECKED_MIDDLE_ADS' => ($smartfeed_ads->enable_block_2 == true) ? 'checked="checked" ' : '',
			'CHECKED_BOTTOM_AD' => ($smartfeed_ads->enable_block_3 == true) ? 'checked="checked" ' : '',
			'TITLE_1' => $smartfeed_ads->block_1_title,
			'TITLE_2' => $smartfeed_ads->block_2_title,
			'TITLE_3' => $smartfeed_ads->block_3_title,
			'LINK_1' => $smartfeed_ads->block_1_link,
			'LINK_2' => $smartfeed_ads->block_2_link,
			'LINK_3' => $smartfeed_ads->block_3_link,
			'DESC_1' => $smartfeed_ads->block_1_desc,
			'DESC_2' => $smartfeed_ads->block_2_desc,
			'DESC_3' => $smartfeed_ads->block_3_desc,
			'REPEAT' => $smartfeed_ads->block_2_num_items_to_skip,
			'ADVERTISING_TITLE' => $lang['smartfeed_advertising_interface_title'],
			'PUBLIC_ONLY' => ($smartfeed_ads->show_ads_to_public_only == true) ? 'checked="checked" ' : '',
			'L_ENABLE_ADS' => $lang['smartfeed_enable_ads'],
			'L_ADS_SUBMIT' => $lang['smartfeed_set_ad_options'],
			'L_ENABLE_TOP_AD' => $lang['smartfeed_set_top_options'],	
			'L_ENABLE_MIDDLE_ADS' => $lang['smartfeed_set_middle_options'],	
			'L_ENABLE_BOTTOM_AD' => $lang['smartfeed_set_bottom_options'],
			'L_TITLE_1' => $lang['smartfeed_ad_item_title'],
			'L_LINK_1' => $lang['smartfeed_ad_item_link'],
			'L_DESC_1' => $lang['smartfeed_ad_item_desc'],
			'L_TITLE_2' => $lang['smartfeed_ad_item_title'],
			'L_LINK_2' => $lang['smartfeed_ad_item_link'],
			'L_DESC_2' => $lang['smartfeed_ad_item_desc'],
			'L_TITLE_3' => $lang['smartfeed_ad_item_title'],
			'L_LINK_3' => $lang['smartfeed_ad_item_link'],
			'L_DESC_3' => $lang['smartfeed_ad_item_desc'],
			'L_HEADER_1' => $lang['smartfeed_ad_item_header_top'],
			'L_HEADER_2' => $lang['smartfeed_ad_item_header_middle'],
			'L_HEADER_3' => $lang['smartfeed_ad_item_header_bottom'],
			'L_REPEAT' => $lang['smartfeed_ad_item_repeat'],
			'L_ADS_CLEAR' => $lang['smartfeed_ad_clear'],
			'L_MUST_BE_NUMERIC' => $lang['smartfeed_repeat_must_be_numeric'],
			'L_MUST_BE_GREATER_THAN_0' => $lang['smartfeed_repeat_must_be_greater_0'],
			'L_TITLE_REQUIRED' => $lang['smartfeed_title_required'],
			'L_PUBLIC_ONLY' => $lang['smartfeed_show_ads_to_public_only'],
			'ADS_INTRO' => ($error_msg == '') ? $lang['smartfeed_advertising_introduction'] : '***<b> ' . $error_msg . ' </b>***'));
	}
	
	$template->assign_vars(array(
		'PAGE_TITLE' => $lang['smartfeed_page_title']  . ' ' . $lang['smartfeed_version'] . ' ' . SMARTFEED_VERSION,
		'L_LAST_FETCH' => $lang['smartfeed_since_last_fetch_or_visit'],
		'L_LAST_FETCH_VALUE' => $lang['smartfeed_since_last_fetch_or_visit_value'],
		'L_FEED_TYPE' => $lang['smartfeed_feed_type'],
		'L_ATOM_10' => $lang['smartfeed_atom_10'],
		'L_RSS_20' => $lang['smartfeed_rss_20'],
		'L_RSS_10' => $lang['smartfeed_rss_10'],
		'L_RSS_091' => $lang['smartfeed_rss_091'],
		'L_ATOM_10_VALUE' => SMARTFEED_ATOM_10_VALUE,
		'L_RSS_20_VALUE' => SMARTFEED_RSS_20_VALUE,
		'L_RSS_10_VALUE' => SMARTFEED_RSS_10_VALUE,
		'L_RSS_091_VALUE' => SMARTFEED_RSS_091_VALUE,
		'NO_FORUMS_SELECTED' => $lang['smartfeed_no_forums_selected'],
		'SMARTFEED_EXPLANATION' => $lang['smartfeed_explanation'],
		'L_YES' => $lang['smartfeed_yes'],
		'L_NO' => $lang['smartfeed_no'],
		'L_FORUM_SELECTION' => $lang['smartfeed_select_forums'],
		'L_ALL_SUBSCRIBED_FORUMS' => $lang['smartfeed_all_forums'],
		'L_SUBMIT' => $lang['smartfeed_generate_url_text'],
		'L_RESET' => $lang['smartfeed_reset_text'],
		'L_LIMIT' => $lang['smartfeed_limit_text'],
		'L_WEEK' => $lang['smartfeed_last_week'],
		'L_WEEK_VALUE' => $lang['smartfeed_last_week_value'],
		'L_DAY' => $lang['smartfeed_last_day'],
		'L_DAY_VALUE' => $lang['smartfeed_last_day_value'],
		'L_12_HRS' => $lang['smartfeed_last_12_hours'],
		'L_12_HRS_VALUE' => $lang['smartfeed_last_12_hours_value'],
		'L_6_HRS' => $lang['smartfeed_last_6_hours'],
		'L_6_HRS_VALUE' => $lang['smartfeed_last_6_hours_value'],
		'L_3_HRS' => $lang['smartfeed_last_3_hours'],
		'L_3_HRS_VALUE' => $lang['smartfeed_last_3_hours_value'],
		'L_1_HRS' => $lang['smartfeed_last_1_hours'],
		'L_1_HRS_VALUE' => $lang['smartfeed_last_1_hours_value'],
		'L_30_MIN' => $lang['smartfeed_last_30_minutes'],
		'L_30_MIN_VALUE' => $lang['smartfeed_last_30_minutes_value'],
		'L_15_MIN' => $lang['smartfeed_last_15_minutes'],
		'L_15_MIN_VALUE' => $lang['smartfeed_last_15_minutes_value'],
		'L_TOPICSONLY' => $lang['smartfeed_topics_only'],
		'L_UNREAD' => $lang['smartfeed_size_all'],
		'L_SORTBY' => $lang['smartfeed_sort_by'],
		'L_FORUMTOPIC' => $lang['smartfeed_sort_forum_topic'],
		'L_FORUMTOPIC_DESC' => $lang['smartfeed_sort_forum_topic_desc'],
		'L_POSTDATE' => $lang['smartfeed_sort_post_date'],
		'L_POSTDATE_DESC' => $lang['smartfeed_sort_post_date_desc'],
		'L_COUNT_LIMIT' => $lang['smartfeed_count_limit'],
		'L_URL' => $lang['smartfeed_url_label'],
		'L_REMOVE_YOUR_POSTS' => $lang['smartfeed_remove_yours'],
		'SITE_URL' => SMARTFEED_SITE_URL,
		'USER_ID' => $userdata['user_id'],
		'PHPEXT' => $phpEx,
		'PWD' => $encrypted_data,
		'PWD_WITH_IP' => $encrypted_data_with_ip,
		'LOGGED_IN' => ($userdata['session_logged_in'] && $mcrypt_loaded) ? 'true' : 'false',
		'L_MAX_WORD_SIZE' => $lang['smartfeed_max_size'],
		'SIZE_ERROR' => $lang['smartfeed_size_error'],
		'MAX_SIZE' => $lang['smartfeed_max_words_wanted'],
		'REQ_IP_AUTH' => SMARTFEED_REQUIRE_IP_AUTHENTICATION,
		'L_FIRST_POST_ONLY' => $lang['smartfeed_first_post_only'],
		'L_PRIVATE_MGS_IN_FEED' => $lang['smartfeed_private_messages_in_feed'],
		'SMARTFEED_PAGE_URL' => SMARTFEED_PAGE_URL,
		'U_LITERAL' => POST_USERS_URL));
	
	$template->pparse('smartfeed');
	
}

else

{

	// This handles a POST form event. This only happens if the user is an administrator and is setting advertising options
	// There is not much to do here but read the advertising options screen variables, serialize them and save them to a file
	
	if ($userdata['user_level'] == ADMIN)
	{
	
		// Gather the data
		$smartfeed_ads = new Smartfeed_Ad_Configuration;
		
		$smartfeed_ads->display_ads = (htmlspecialchars($HTTP_POST_VARS['enable_ads']) == 'on') ? true : false;
		$smartfeed_ads->show_ads_to_public_only = (htmlspecialchars($HTTP_POST_VARS['public_only']) == 'on') ? true : false;
		$smartfeed_ads->enable_block_1 = (htmlspecialchars($HTTP_POST_VARS['enable_top_ad']) == 'on') ? true : false;
		$smartfeed_ads->enable_block_2 = (htmlspecialchars($HTTP_POST_VARS['enable_middle_ads']) == 'on') ? true : false;
		$smartfeed_ads->enable_block_3 = (htmlspecialchars($HTTP_POST_VARS['enable_bottom_ad']) == 'on') ? true : false;
		$smartfeed_ads->block_1_title = htmlspecialchars(stripslashes($HTTP_POST_VARS['title_1']));
		$smartfeed_ads->block_2_title = htmlspecialchars(stripslashes($HTTP_POST_VARS['title_2']));
		$smartfeed_ads->block_3_title = htmlspecialchars(stripslashes($HTTP_POST_VARS['title_3']));
		$smartfeed_ads->block_1_link = htmlspecialchars(stripslashes($HTTP_POST_VARS['link_1']));
		$smartfeed_ads->block_2_link = htmlspecialchars(stripslashes($HTTP_POST_VARS['link_2']));
		$smartfeed_ads->block_3_link = htmlspecialchars(stripslashes($HTTP_POST_VARS['link_3']));
		$smartfeed_ads->block_1_desc = htmlspecialchars(stripslashes($HTTP_POST_VARS['desc_1']));
		$smartfeed_ads->block_2_desc = htmlspecialchars(stripslashes($HTTP_POST_VARS['desc_2']));
		$smartfeed_ads->block_3_desc = htmlspecialchars(stripslashes($HTTP_POST_VARS['desc_3']));
		$smartfeed_ads->block_2_num_items_to_skip = intval($HTTP_POST_VARS['repeat']);		
		
		// Store the data
		$s = serialize($smartfeed_ads);
		$fp = fopen($ad_data_path, "w");
		if (!$fp)
		{
			$save_msg = $lang['smartfeed_ad_data_access_error'];
		}
		else
		{
			if (!fwrite($fp, $s))
			{
				$save_msg = $lang['smartfeed_ad_data_access_error'];
			}
			else
			{
				$save_msg = $lang['smartfeed_ad_data_saved'];
			}
			fclose($fp);
		} 
		
	}
	else
	{
		$save_msg = $lang['smartfeed_ad_data_invalid_user'];
	}

	$message = $save_msg . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');
	message_die(GENERAL_MESSAGE, $message);

}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

function encrypt($data_input, $key)
{     
    $td = mcrypt_module_open('cast-256', '', 'ecb', '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $encrypted_data = mcrypt_generic($td, $data_input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $encoded_64=base64_encode($encrypted_data);
    return $encoded_64;
}   

?>
