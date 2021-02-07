<?php 
/***************************************************************************
                             lang_smartfeed.php
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

// lang_smartfeed.php
// Written by Mark D. Hamill, mhamill@computer.org
// This software is designed to work with phpBB Version 2.0.22

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$lang['smartfeed_atom_10'] = 'Atom 1.0';
$lang['smartfeed_rss_20'] = 'RSS 2.0';
$lang['smartfeed_rss_10'] = 'RSS 1.0';
$lang['smartfeed_rss_091'] = 'RSS 0.91 (RDF) - 15 items maximum';

$lang['smartfeed_copyright'] = ''; // Add a copyright statement for your site if it applies
$lang['smartfeed_editor'] = ''; // Most likely your site will not have a managing editor. If so enter email address of managing editor 
$lang['smartfeed_webmaster'] = ''; // If so inclined, enter email address of the webmaster of the phpBB forum

// Various error messages. Customize or internationalize as you prefer.
$lang['smartfeed_error_title'] = 'Error in your SmartFeed URL';
$lang['smartfeed_error_introduction'] = 'There is an error in the URL you used to retrieve this newsfeed. As a result, no content can be returned. Use this error information as a guide to correcting the problem. Please note that you must use <a href="%s">this program</a> to create a URL that can be used with SmartFeed. The error is: ';
$lang['smartfeed_no_p_param'] = 'The "u" parameter must be used with the "e" parameter. ';
$lang['smartfeed_no_u_param'] = 'The "e" parameter must be used with the "u" parameter. ';
$lang['smartfeed_user_table_count_error'] = 'Error retrieving user_id from the users table'; // Changed!
$lang['smartfeed_user_id_does_not_exist'] = 'User ID identified by "u" parameter does not exist. The account may have been deleted.';
$lang['smartfeed_user_table_password_error'] = 'Database error in obtaining password from users table.';
$lang['smartfeed_bad_password_error'] = 'Authentication failure. "e" parameter "%s" is invalid with "u" parameter of "%s". This error may be caused by changing your phpBB password, or due to an upgrade in this SmartFeed software. To solve this problem, create a new SmartFeed URL at %s, then copy and paste the generated URL into your newsreader application.';
$lang['smartfeed_forum_access_reg'] = 'Error retrieving a list forum_ids that all members can access.';
$lang['smartfeed_forum_access_priv'] = 'Error retrieving a list forum_ids that are private.';
$lang['smartfeed_user_error'] = 'Error retrieving user_lastvisit from users table.';
$lang['smartfeed_limit_format_error'] = 'Limit parameter is not a recognized value.';
$lang['smartfeed_retrieve_error'] = 'Unable to retrieve information from database to create newsfeed.';
$lang['smartfeed_feed_type_error'] = 'SmartFeed does not accept the feed type requested.';
$lang['smartfeed_sort_by_error'] = 'SmartFeed cannot accept the sort type requested.';
$lang['smartfeed_topics_only_error'] = 'SmartFeed does not accept the topic type value requested.';
$lang['smartfeed_lastvisit_param'] = 'The lastvisit parameter specified is invalid.';
$lang['smartfeed_reset_error'] = 'Database error: Unable to reset your last visit date.';
$lang['smartfeed_ip_auth_error'] = 'This URL cannot be used to retrieve a newsfeed from this IP address. Run smartfeed_url.' . $phpEx . ' from this machine and use the newly generated URL to retrieve a newsfeed.'; 
$lang['smartfeed_not_logged_in'] = '<b>Because you are not logged into the site, you can only subscribe to the list of public forums shown below. Please <a href="' . append_sid("login.$phpEx?redirect=smartfeed_url.$phpEx", true) . "\">log in</a> or <a href=\"./profile.$phpEx?mode=register\">register</a> if you want to also subscribe to nonpublic forums.</b>";
$lang['smartfeed_remove_yours_error'] = 'The removemine parameter value is invalid';
$lang['smartfeed_no_arguments'] = 'This program requires arguments.';
$lang['smartfeed_max_word_size_error'] = 'The max_word_size parameter is invalid.';
$lang['smartfeed_first_post_only_error'] = 'The firstpostonly parameter is invalid. If present it should only have a value of 1.';
$lang['smartfeed_pms_not_for_public_users'] = 'pms parameter is not allowed for non-registered users.';
$lang['smartfeed_bad_pms_value'] = 'The pms parameter (for private messages) must have a value of 1';
$lang['smartfeed_pm_retrieve_error'] = 'Unable to retrieve private message information from database.';
$lang['smartfeed_pm_count_error'] = 'Unable to retrieve the number of private message for user from database.';
$lang['smartfeed_p_parameter_obsolete'] = 'Authentication failure. Due to a software upgrade, the "p" parameter is no longer allowed. To solve this problem, create a new SmartFeed URL at %s, then copy and paste the generated URL into your newsreader application.';

// Miscellaneous variables
$lang['smartfeed_feed_title'] = $board_config['sitename'];
$lang['smartfeed_feed_description'] = $board_config['site_desc'];
$lang['smartfeed_image_title'] = $board_config['site_desc'] . ' Logo';
$lang['smartfeed_reply'] = 'Reply';
$lang['smartfeed_reply_by'] = 'Reply by';
$lang['smartfeed_posted_by'] = 'Posted by';
$lang['smartfeed_version'] = 'Version';

// These are used by smartfeed_url.php
$lang['smartfeed_feed_type'] = '<b>Select type of newsfeed:</b><br />(Make sure you choose a format supported by your newsreader)';
$lang['smartfeed_page_title'] = 'SmartFeed';
$lang['smartfeed_explanation'] = "Many people are discovering the convenience of syndicated newsfeeds. Using newsfeeds, you do not have to visit the site to read its content. A program called a <i>web aggregator</i> fetches and presents news from multiple web sites for you.<br /><br />\r\nSome forums on this site may be read by members only, or require that you to subscribe to an appropriate usergroup. Normally, these forums would not be accessible as a public newsfeed. However, this site is enabled with <em>SmartFeed</em>. This is a phpBB modification that allows logged in users to access both restricted and unrestricted forums on this site as a newsfeed. This is done by authenticating yourself with a special URL that you create on this page. You select the forums on this site that interest you that you want included in your customized newsfeed. You can choose the type of newsfeed format that you prefer. SmartFeed supports the RSS and Atom protocols. Make sure you pick the correct format that you need. By pressing the Generate URL button near the bottom of this page, you can see the special URL that you will use. Copy and paste this information into your newsreader to access this site with your newsreader.<br /><br />\r\nIf you are new to newsfeeds and web aggregators, we suggest you read <a href=\"http://en.wikipedia.org/wiki/News_aggregator\">this Wikipedia topic</a>. It includes a link to various newsreaders that you may wish to download. You may prefer to access newsfeeds via websites such as <a href=\"http://www.bloglines.com\">Bloglines</a> created for this purpose.<br /><br />If you have not registered on this site, you can still get a newsfeed. However, you can only select from public forums.";
$lang['smartfeed_lastvisit'] = '<b>Reset your last visit date when you access the newsfeed?</b><br />(Select "Yes" if you will ordinarily use a newsfeed to read content on this site. Select "No" if you regularly visit this site <i>and</i> you want items in the newsfeed to appear as unread when you visit the site. Caution: Selecting "No" may give you very long newsfeeds. In addition, you may notice redundant articles the next time you access your newsfeed.)';
$lang['smartfeed_yes'] = 'Yes';
$lang['smartfeed_no'] = 'No';
$lang['smartfeed_all_forums']='All Subscribed Forums';
$lang['smartfeed_select_forums']='<b>Newsfeeds should include posts for these forums:</b>';
$lang['smartfeed_generate_url_text']='Generate URL';
$lang['smartfeed_reset_text']='Reset';
$lang['smartfeed_auth_reg_text']='<i>(Registered Users Only)</i>';
$lang['smartfeed_auth_acl_text']='<i>(Special Access Only)</i>';
$lang['smartfeed_auth_mod_text']='<i>(Moderators Only)</i>';
$lang['smartfeed_auth_admin_text']='<i>(Administrators Only)</i>';
$lang['smartfeed_limit_text']='<b>When fetching posts, limit newsfeed to posts:</b><br />(If you are using a browser extension like Sage for Firefox as your news reader, a persistent cookie annotating the last time you accessed the newsfeed will be set. Note that most desktop news readers will ignore cookies.)';
$lang['smartfeed_since_last_fetch_or_visit']='Since Last Newsfeed Fetch or Board Visit';
$lang['smartfeed_since_last_fetch_or_visit_value']='LF';
$lang['smartfeed_last_week']='Since Last Week';
$lang['smartfeed_last_week_value']='7 DAY';
$lang['smartfeed_last_day']='In Last 24 Hours';
$lang['smartfeed_last_day_value']='1 DAY';
$lang['smartfeed_last_12_hours']='In Last 12 Hours';
$lang['smartfeed_last_12_hours_value']='12 HOUR';
$lang['smartfeed_last_6_hours']='In Last 6 Hours';
$lang['smartfeed_last_6_hours_value']='6 HOUR';
$lang['smartfeed_last_3_hours']='In Last 3 Hours';
$lang['smartfeed_last_3_hours_value']='3 HOUR';
$lang['smartfeed_last_1_hours']='In Last Hour';
$lang['smartfeed_last_1_hours_value']='1 HOUR';
$lang['smartfeed_last_30_minutes']='In Last 30 Minutes';
$lang['smartfeed_last_30_minutes_value']='30 MINUTE';
$lang['smartfeed_last_15_minutes']='In Last 15 Minutes';
$lang['smartfeed_last_15_minutes_value']='15 MINUTE';
$lang['smartfeed_sort_by']='<b>Sort by:</b><br />(Standard Order is the order posts are presented in this forum, i.e. Category Order, Forum Order, Forum Topic Last Post Time (Desc), Topic Post Date/Time)';
$lang['smartfeed_sort_forum_topic']='Standard Order';
$lang['smartfeed_sort_forum_topic_desc']='Standard Order, Last Posts First';
$lang['smartfeed_sort_post_date']='Post Date/Time';
$lang['smartfeed_sort_post_date_desc']='Post Date/Time, Last Posts First';
$lang['smartfeed_count_limit'] = '<b>Maximum posts in feed:</b><br />(Applies only if Post/Date Time, Last Posts First is selected. Enter a positive number. Enter \'All\' to see all posts meeting your criteria.)';
$lang['smartfeed_no_forums_selected']='You have not selected any forums, so no URL can be generated. Please select at least one forum.';
$lang['smartfeed_topics_only']='<b>Show only new topics?</b>';
$lang['smartfeed_url_label']='After you press the Generate URL button, the URL you need will appear in the box below. <b>Copy and paste this information into your newsreader.</b> If you change your options, press the Generate URL button again and you will get a different URL.';
$lang['smartfeed_ip_auth']='<b>Enable Newsfeed IP Authentication?</b><br />(This can be used as an addition security precaution to limit URL hijacking. The URL that is generated will only be good for the range of IP addresses associated with your computer. For example, if your current IP is 123.45.67.89 and IP Authentication is enabled then the feed will only work in the address range 123.45.67.*.)';
$lang['smartfeed_remove_yours']='<b>Remove your posts from the feed?</b>';
$lang['smartfeed_max_size']='<b>Maximum words to display per post:</b><br />(Enter a positive number. Enter \'All\' to see the entire message. Warning: setting a number may cause feed validator errors.)';
$lang['smartfeed_max_words_wanted']='All';
$lang['smartfeed_size_error']='You must enter a positive value or the word \'All\' in this field';
$lang['smartfeed_count_limit_error']='The count_limit parameter must be greater than 0.';
$lang['smartfeed_count_limit_consistency_error']= 'The count_limit parameter may only used when sort_by parameter is "postdate_desc"';
$lang['smartfeed_first_post_only']='Limit to First Post Only (Applies only if "Yes")';
$lang['smartfeed_private_messages_in_feed']='<b>Show private messages in the feed?</b>';
$lang['smartfeed_no_mcrypt'] = '<b>*** Warning! PHP mcrypt extension is not available! Consequently only public forums can be selected. ***</b>';

// Used in Admininstrator interface to smartfeed_url.php
$lang['smartfeed_advertising_interface_title'] = 'Administrator Advertising Options';
$lang['smartfeed_enable_ads'] = '<b>Display ads in your newsfeed?</b>';
$lang['smartfeed_set_ad_options'] = 'Set advertising options';
$lang['smartfeed_set_top_options'] = 'Place an advertisement at the top of your newsfeed';
$lang['smartfeed_set_middle_options'] = 'Place advertisements between items in your newsfeed';
$lang['smartfeed_set_bottom_options'] = 'Place an advertisement at the bottom of your newsfeed';
$lang['smartfeed_ad_item_title'] = '<b>Title of advertisement</b><br />(Required if this section is enabled. Use plain text only; no special characters or HTML.)';
$lang['smartfeed_ad_item_link'] = '<b>Link to more detail</b><br />(You can leave this blank if not applicable. Make sure the link starts with http://)';
$lang['smartfeed_ad_item_desc'] = '<b>Full advertisement description</b><br />(You can leave this blank if not applicable. In most cases you will want to put additional details as to the product or service being offered. You can use plain text, HTML or parsed XML content specifically designed for RSS or Atom feeds. Warning: not all newsreaders will accurately translate or parse HTML. Please do NOT use Javascript as most newsreaders cannot execute Javascript. Backslash characters (\) will be removed.)';
$lang['smartfeed_ad_item_header_top'] = 'Top of newsfeed advertising';
$lang['smartfeed_ad_item_header_middle'] = 'Middle of newsfeed advertising';
$lang['smartfeed_ad_item_header_bottom'] = 'Bottom of newsfeed advertising';
$lang['smartfeed_ad_item_repeat'] = '<b>Enter the number of newsfeed items to show before inserting an advertisement</b><br />(Required and must be greater than 0.)';
$lang['smartfeed_ad_clear'] = 'Clear All Advertising Section Fields';
$lang['smartfeed_repeat_must_be_numeric'] = 'Newsfeed items to show must be numeric';
$lang['smartfeed_repeat_must_be_greater_0'] = 'Newsfeed items value must be greater than 0';
$lang['smartfeed_title_required'] = 'If a section is enabled, the title field have content.';
$lang['smartfeed_advertising_introduction'] = 'This section appears only to Administrators.<br /><br />Smartfeed allows advertising to be inserted into newsfeeds provided to subscribers. Use this interface to enable, disable and set advertising. Advertising appears as just another item in the feed, but is clearly identified as advertising. Advertising can be placed in three areas in the feed: before the first feed item, at the bottom of the feed, and periodically inside the feed. (Note that some newsreaders, like IE 7, allow the user to change the order that items are shown in the feed. Consequently there is no guarantee the ads will appear at the place they were written to in the newsfeed.) Each section can be turned on or off. Content can be toggled on or off with the master checkbox. If turned off, any information in the advertising fields can be enabled later.<br /><br />Please note that as of this writing Google Adsense does not support RSS, and consequently Javascript provided with Google Adsense probably will not work.  You should check the feed content with advertising for yourself in a variety of newsreaders to ensure the text can be parsed and your content will show cleanly. Please note that different newsreaders may show different results.<br /><br />Please make sure your browser is configured to allow pop up windows for this site. Otherwise, if there are error messages, you may not see them.';
$lang['smartfeed_advertising_path_error'] = 'Unable to read or create the file containing advertising options data. It may be that the directory where the file should reside does not have the proper permissions.';
$lang['smartfeed_ad_data_saved'] = 'Your advertising options data was saved';
$lang['smartfeed_ad_data_invalid_user'] = 'Your advertising options data was NOT saved. A hacking attempt probably occurred, because the user trying to save the advertising data does not have Administrator privileges.';
$lang['smartfeed_ad_data_access_error'] = 'Unable to access the file containing the advertising information. This is likely a file permissions problem.';
$lang['smartfeed_ad_feed_category'] = 'Advertising'; // The feed item category to use for ads, and also in the item title to distinguish the item as advertising
$lang['smartfeed_show_ads_to_public_only'] = 'Show ads to public (non-registered) users only (applies only if ads are enabled)';

?>