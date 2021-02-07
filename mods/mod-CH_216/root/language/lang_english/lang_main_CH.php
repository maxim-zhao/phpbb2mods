<?php
//
//	file: language/lang_english/lang_main_CH.php
//	author: ptirhiik
//	begin: 30/01/2006
//	version: 1.6.1 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//
//	This file is used to filter the lang_main depending the context
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// no more used
/*
$lang['Poster'] = '';
$lang['Time'] = '';
$lang['Hours'] = '';
$lang['Category'] = '';
$lang['Enabled'] = '';
$lang['Disabled'] = '';
$lang['IP_Address'] = '';
$lang['Admin_online_color'] = '';
$lang['Mod_online_color'] = '';
$lang['Reached_on_error'] = '';

$lang['Topic_Announcement'] = '';
$lang['Topic_Sticky'] = '';
$lang['Topic_Moved'] = '';
$lang['Topic_Poll'] = '';

$lang['Newest_First'] = '';
$lang['Oldest_First'] = '';

$lang['ICQ_status'] = '';
$lang['Post_has_no_poll'] = '';

$lang['All_Messages'] = '';
$lang['No_folder'] = '';
$lang['Hidden_email'] = '';

$lang['Only_one_avatar'] = '';
$lang['No_themes'] = '';
$lang['Pick_local_Avatar'] = '';
$lang['Avatar_URL'] = '';
$lang['No_pending_group_members'] = '';
$lang['Not_logged_in'] = '';

$lang['Auth_Anonymous_Users'] = '';
$lang['Auth_Registered_Users'] = '';
$lang['Auth_Moderators'] = '';
$lang['Auth_Administrators'] = '';

$lang['Confirm_lock_topic'] = '';
$lang['Confirm_unlock_topic'] = '';
$lang['Too_many_error'] = '';
$lang['New_forum'] = '';

$lang['Newest_user'] = '';
*/

// page_header's/generics
$lang = array(
	'ENCODING' => '',
	'DIRECTION' => '',
	'LEFT' => '',
	'RIGHT' => '',
	'DATE_FORMAT' => '',

	'Information' => '',
	'Critical_Information' => '',
	'General_Error' => '',
	'Critical_Error' => '',
	'An_error_occured' => '',
	'A_critical_error' => '',
	'Please_remove_install_contrib' => '',
	'You_been_banned' => '',

	'You_last_visit' => '',
	'Current_time' => '',
	'Search_new' => '',
	'Search_your_posts' => '',
	'Search_unanswered' => '',

	'Register' => '',
	'Profile' => '',
	'Preferences' => '',
	'Search' => '',
	'Memberlist' => '',
	'FAQ' => '',
	'Usergroups' => '',
	'Private_Messages' => '',
	'Login_check_pm' => '',
	'New_pms' => '',
	'New_pm' => '',
	'No_new_pm' => '',
	'Unread_pms' => '',
	'Unread_pm' => '',
	'No_unread_pm' => '',
	'Login' => '',
	'Logout' => '',
	'Log_me_in' => '',

	'Username' => '',
	'Password' => '',

	'Yes' => '',
	'No' => '',
	'None' => '',

	'Forum_Index' => '',
	'Forum_index' => '',

	'Admin_panel' => '',
	'Board_disable' => '',
	'Guest' => '',

	'Next' => '',
	'Previous' => '',
	'Goto_page' => '',
	'Page_of' => '',
	'Back_to_top' => '',
	'Close_window' => '',

	'Click_return_index' => '',
	'Find_username' => '',
	'Search_author_explain' => '',
	'No_search_match' => '',
	'No_match' => '',
	'Not_Authorised' => '',
	'Error' => '',

	'wrote' => '',
	'Quote' => '',
	'Code' => '',

	'View_topic' => '',
	'Select_sort_method' => '',
	'Sort' => '',
	'Order' => '',
	'Sort_Ascending' => '',
	'Sort_Descending' => '',
	'Sort_by' => '',
	'Sort_Time' => '',
	'Sort_Post_Subject' => '',
	'Sort_Topic_Title' => '',
	'Sort_Author' => '',
	'Select_forum' => '',
	'Jump_to' => '',
	'Select' => '',
	'Submit' => '',
	'Reset' => '',
	'Cancel' => '',
	'Preview' => '',
	'Confirm' => '',
	'Spellcheck' => '',
	'Go' => '',
	'Update' => '',
	'Delete' => '',

	'Date' => '',
	'All_times' => '',
	'-12' => '',
	'-11' => '',
	'-10' => '',
	'-9' => '',
	'-8' => '',
	'-7' => '',
	'-6' => '',
	'-5' => '',
	'-4' => '',
	'-3.5' => '',
	'-3' => '',
	'-2' => '',
	'-1' => '',
	'0' => '',
	'1' => '',
	'2' => '',
	'3' => '',
	'3.5' => '',
	'4' => '',
	'4.5' => '',
	'5' => '',
	'5.5' => '',
	'6' => '',
	'6.5' => '',
	'7' => '',
	'8' => '',
	'9' => '',
	'9.5' => '',
	'10' => '',
	'11' => '',
	'12' => '',
	'13' => '',
	'tz' => '',
	'datetime' => '',

	'1_Day' => '',
	'7_Days' => '',
	'2_Weeks' => '',
	'1_Month' => '',
	'3_Months' => '',
	'6_Months' => '',
	'1_Year' => '',

	// main objects
	'Forum' => '',
	'Topic' => '',
	'Topics' => '',
	'Posts' => '',
	'Posted' => '',
	'Email' => '',
	'Author' => '',
	'Message' => '',
	'Read_profile' => '',

	// phpBB 2.0.22
	'Session_invalid' => '',
);

// class_forums/class_topics
if ( !$is || $is['admin'] || $is['class_topics'] )
{
	$lang += array(
		'Moderators' => '',
		'Forum_is_locked' => '',
		'No_Posts' => '',
		'Forum_not_exist' => '',
		'Forum_locked' => '',

		'Last_Post' => '',
		'Replies' => '',
		'Views' => '',
		'View_newest_post' => '',
		'Display_topics' => '',
		'All_Topics' => '',
		'Mark_all_topics' => '',
		'No_topics_post_one' => '',

		'View_latest_post' => '',
		'Post_new_topic' => '',
		'Reply_to_topic' => '',

		'Click_return_topic' => '',
		'All_Posts' => '',
		'Topic_locked' => '',

		'Sorry_auth_announce' => '',
		'Sorry_auth_sticky' => '',
		'Sorry_auth_read' => '',
		'Sorry_auth_post' => '',
		'Sorry_auth_reply' => '',
		'Sorry_auth_edit' => '',
		'Sorry_auth_delete' => '',
		'Sorry_auth_vote' => '',
		'Auth_Users_granted_access' => '',
		'Click_return_forum' => '',
	);
}

// class_posts
if ( !$is || $is['admin'] || $is['class_posts'] )
{
	$lang += array(
		'Reply_with_quote' => '',
		'New_post' => '',
		'Edit_delete_post' => '',
		'View_IP' => '',
		'Edited_time_total' => '',
		'Edited_times_total' => '',
		'Post' => '',
		'Post_subject' => '',
		'Delete_post' => '',

		'Topic_post_not_exist' => '',
		'No_posts_topic' => '',
		'No_such_post' => '',
	);
}

if ( !$is || $is['admin'] || $is['class_topics'] || $is['class_posts'] )
{
	$lang += array(
		'No_new_posts' => '',
		'New_posts' => '',
		'No_new_posts_hot' => '',
		'New_posts_hot' => '',
		'No_new_posts_locked' => '',
		'New_posts_locked' => '',

		'Post_Announcement' => '',
		'Post_Sticky' => '',
		'Post_Normal' => '',

		'Subject' => '',
	);
}

// profile informations for view
if ( !$is || $is['admin'] || $is['viewprofile'] || $is['editprofile'] )
{
	$lang += array(
		'No_such_user' => '',
		'Joined' => '',
		'ICQ' => '',
		'AIM' => '',
		'MSNM' => '',
		'YIM' => '',
		'Visit_website' => '',
		'Viewing_user_profile' => '',
		'About_user' => '',
		'Contact' => '',
		'Poster_rank' => '',
		'Avatar' => '',
		'Total_posts' => '',
		'User_post_pct_stats' => '',
		'User_post_day_stats' => '',
		'No_user_id_specified' => '',
		'Website' => '',
		'Location' => '',
		'Email_address' => '',
		'Send_private_message' => '',
		'Private_Message' => '',
		'Search_user_posts' => '',
		'Interests' => '',
		'Occupation' => '',
		'Send_email' => '',
		'Message_body' => '',
	);
}

// profile information for edit
if ( !$is || $is['admin'] || $is['editprofile'] )
{
	$lang += array(
		'Edit_profile' => '',
		'File_no_data' => '',
		'No_connection_URL' => '',
		'Incomplete_URL' => '',
		'Wrong_remote_avatar_format' => '',
		'Select_avatar' => '',
		'Return_profile' => '',
		'Select_category' => '',
		'Avatar_filetype' => '',
		'Avatar_filesize' => '',
		'Avatar_imagesize' => '',
		'Items_required' => '',
		'Registration_info' => '',
		'Profile_info' => '',
		'Profile_info_warn' => '',
		'Avatar_panel' => '',
		'Avatar_gallery' => '',
		'Wrong_Profile' => '',
		'Always_smile' => '',
		'Always_html' => '',
		'Always_bbcode' => '',
		'Always_add_sig' => '',
		'Always_notify' => '',
		'Always_notify_explain' => '',
		'Notify_on_privmsg' => '',
		'Popup_on_privmsg' => '',
		'Popup_on_privmsg_explain' => '',
		'Hide_user' => '',
		'Board_style' => '',
		'Board_lang' => '',
		'Timezone' => '',
		'Date_format' => '',
		'Date_format_explain' => '',
		'Signature' => '',
		'Signature_explain' => '',
		'Public_view_email' => '',
		'Current_password' => '',
		'New_password' => '',
		'Confirm_password' => '',
		'Confirm_password_explain' => '',
		'password_if_changed' => '',
		'password_confirm_if_changed' => '',
		'Avatar_explain' => '',
		'Upload_Avatar_file' => '',
		'Upload_Avatar_URL' => '',
		'Upload_Avatar_URL_explain' => '',
		'Link_remote_Avatar' => '',
		'Link_remote_Avatar_explain' => '',
		'Select_from_gallery' => '',
		'View_avatar_gallery' => '',
		'Delete_Image' => '',
		'Current_Image' => '',
		'Profile_updated' => '',
		'Profile_updated_inactive' => '',
		'Password_mismatch' => '',
		'Current_password_mismatch' => '',
		'Password_long' => '',
		'Signature_too_long' => '',
		'Fields_empty' => '',
		'Welcome_subject' => '',
		'New_account_subject' => '',
		'Account_added' => '',
		'Account_inactive' => '',
		'Account_inactive_admin' => '',
		'Reactivate' => '',
		'COPPA' => '',
		'Registration' => '',
		'Reg_agreement' => '',
		'Agree_under_13' => '',
		'Agree_over_13' => '',
		'Agree_not' => '',
		'Too_many_registers' => '',
		'Email_taken' => '',
		'Email_banned' => '',
		'Email_invalid' => '',
		'Account_activated_subject' => '',
		'Account_active' => '',
		'Account_active_admin' => '',
		'Already_activated' => '',
		'Wrong_activation' => '',
		'Send_email_msg' => '',
		'No_user_specified' => '',
		'User_prevent_email' => '',
		'User_not_exist' => '',
		'CC_email' => '',
		'Email_message_desc' => '',
		'Flood_email_limit' => '',
		'Recipient' => '',
		'Email_sent' => '',
		'Empty_subject_email' => '',
		'Empty_message_email' => '',
		'No_send_account_inactive' => '',
		'Send_password' => '',
		'Password_updated' => '',
		'No_email_match' => '',
		'New_password_activation' => '',
		'Password_activated' => '',
	);
}

// login
if ( !$is || $is['admin'] || $is['login'] )
{
	$lang += array(
		'Click_return_login' => '',
		'Admin_reauthenticate' => '',
		'Login_attempts_exceeded' => '',
		'Enter_password' => '',
		'Forgotten_password' => '',
		'Error_login' => '',
	);
}

// functions_validate (also in posting)
if ( !$is || $is['admin'] || $is['editprofile'] || $is['posting'] || $si['class_fields'] )
{
	$lang += array(
		'Username_taken' => '',
		'Username_invalid' => '',
		'Username_disallowed' => '',
		'Confirm_code_wrong' => '',
		'Confirm_code_impaired' => '',
		'Confirm_code' => '',
		'Confirm_code_explain' => '',
	);
}

// index
if ( !$is || $is['admin'] || $is['index'] )
{
	$lang += array(
		'Index' => '',
		'No_forums' => '',
		'Mark_all_forums' => '',
		'View_forum' => '',
		'Forums_marked_read' => '',
		'Topics_marked_read' => '',
	);
}

// index, viewtopic
if ( !$is || $is['admin'] || $is['index'] || $is['viewtopic'] )
{
	$lang += array(
		'Rules_post_can' => '',
		'Rules_post_cannot' => '',
		'Rules_reply_can' => '',
		'Rules_reply_cannot' => '',
		'Rules_edit_can' => '',
		'Rules_edit_cannot' => '',
		'Rules_delete_can' => '',
		'Rules_delete_cannot' => '',
		'Rules_vote_can' => '',
		'Rules_vote_cannot' => '',
		'Rules_moderate' => '',
	);
}

// viewtopic
if ( !$is || $is['admin'] || $is['viewtopic'] )
{
	$lang += array(
		'No_new_posts_last_visit' => '',
		'View_next_topic' => '',
		'View_previous_topic' => '',
		'Submit_vote' => '',
		'View_results' => '',
		'Total_votes' => '',
		'No_newer_topics' => '',
		'No_older_topics' => '',
		'Display_posts' => '',

		'Lock_topic' => '',
		'Unlock_topic' => '',
		'Move_topic' => '',
		'Delete_topic' => '',
		'Split_topic' => '',

		'Stop_watching_topic' => '',
		'Start_watching_topic' => '',
		'No_longer_watching' => '',
		'You_are_watching' => '',

		'Topic_review' => '',
	);
}

// modcp
if ( !$is || $is['admin'] || $is['modcp'] )
{
	$lang += array(
		'Click_return_modcp' => '',
		'Not_Moderator' => '',
		'Mod_CP' => '',
		'Mod_CP_explain' => '',
		'Move' => '',
		'Lock' => '',
		'Unlock' => '',
		'Topics_Removed' => '',
		'Topics_Locked' => '',
		'Topics_Moved' => '',
		'Topics_Unlocked' => '',
		'No_Topics_Moved' => '',
		'Confirm_delete_topic' => '',
		'Confirm_move_topic' => '',
		'Move_to_forum' => '',
		'Leave_shadow_topic' => '',
		'Split_Topic' => '',
		'Split_Topic_explain' => '',
		'Split_title' => '',
		'Split_forum' => '',
		'Split_posts' => '',
		'Split_after' => '',
		'Topic_split' => '',
		'None_selected' => '',
		'This_posts_IP' => '',
		'Other_IP_this_user' => '',
		'Users_this_IP' => '',
		'IP_info' => '',
		'Lookup_IP' => '',
	);
}

// posting
if ( !$is || $is['admin'] || $is['posting'] )
{
	$lang += array(
		'Click_view_message' => '',
		'Post_a_new_topic' => '',
		'Post_a_reply' => '',
		'Post_topic_as' => '',
		'Edit_Post' => '',
		'Confirm_delete' => '',
		'Confirm_delete_poll' => '',
		'No_topic_id' => '',
		'No_valid_mode' => '',
		'Delete_own_posts' => '',
		'Cannot_delete_replied' => '',
		'Cannot_delete_poll' => '',
		'Already_voted' => '',
		'No_vote_option' => '',
		'Add_poll' => '',
		'Add_poll_explain' => '',
		'Poll_question' => '',
		'Poll_option' => '',
		'Add_option' => '',
		'Poll_for' => '',
		'Days' => '',
		'Poll_for_explain' => '',
		'Delete_poll' => '',
		'Vote_cast' => '',
		'Disable_HTML_post' => '',
		'Disable_BBCode_post' => '',
		'Disable_Smilies_post' => '',
		'Notify' => '',
		'Empty_poll_title' => '',
		'To_few_poll_options' => '',
		'To_many_poll_options' => '',
		'Stored' => '',
		'Deleted' => '',
		'Poll_delete' => '',
		'Topic_reply_notification' => '',
	);
}

// privmsg
if ( !$is || $is['admin'] || $is['privmsg'] )
{
	$lang += array(
		'Private_Messaging' => '',
		'You_new_pm' => '',
		'You_new_pms' => '',
		'You_no_new_pm' => '',
		'Unread_message' => '',
		'Read_message' => '',
		'Read_pm' => '',
		'Post_new_pm' => '',
		'Post_reply_pm' => '',
		'Post_quote_pm' => '',
		'Edit_pm' => '',
		'Inbox' => '',
		'Outbox' => '',
		'Savebox' => '',
		'Sentbox' => '',
		'Flag' => '',
		'From' => '',
		'To' => '',
		'Mark' => '',
		'Sent' => '',
		'Saved' => '',
		'Delete_marked' => '',
		'Delete_all' => '',
		'Save_marked' => '', 
		'Save_message' => '',
		'Delete_message' => '',
		'Display_messages' => '',
		'No_messages_folder' => '',
		'PM_disabled' => '',
		'Cannot_send_privmsg' => '',
		'No_to_user' => '',
		'Disable_HTML_pm' => '',
		'Disable_BBCode_pm' => '',
		'Disable_Smilies_pm' => '',
		'Message_sent' => '',
		'Click_return_inbox' => '',
		'Send_a_new_message' => '',
		'Send_a_reply' => '',
		'Edit_message' => '',
		'Notification_subject' => '',
		'Find' => '',
		'No_such_folder' => '',
		'Confirm_delete_pm' => '',
		'Confirm_delete_pms' => '',
		'Inbox_size' => '',
		'Sentbox_size' => '',
		'Savebox_size' => '',
		'Click_view_privmsg' => '',
	);
}

// post submission : modcp, posting, privmsg
if ( !$is || $is['admin'] || $is['modcp'] || $is['posting'] || $is['privmsg'] )
{
	$lang += array(
		'Flood_Error' => '',
		'No_post_mode' => '',
		'Empty_subject' => '',
		'No_post_id' => '',
		'Edit_own_posts' => '',
		'Attach_signature' => '',
		'Mark_all' => '',
		'Unmark_all' => '',
	);
}

// bbcodes : posting, privmsg
if ( !$is || $is['admin'] || $is['bbcodes'] )
{
	$lang += array(
		'Empty_message' => '',
		'Options' => '',
		'HTML_is_ON' => '',
		'HTML_is_OFF' => '',
		'BBCode_is_ON' => '',
		'BBCode_is_OFF' => '',
		'Smilies_are_ON' => '',
		'Smilies_are_OFF' => '',

		'Emoticons' => '',
		'More_emoticons' => '',

		'bbcode_b_help' => '',
		'bbcode_i_help' => '',
		'bbcode_u_help' => '',
		'bbcode_q_help' => '',
		'bbcode_c_help' => '',
		'bbcode_l_help' => '',
		'bbcode_o_help' => '',
		'bbcode_p_help' => '',
		'bbcode_w_help' => '',
		'bbcode_a_help' => '',
		'bbcode_s_help' => '',
		'bbcode_f_help' => '',

		'Font_color' => '',
		'color_default' => '',
		'color_dark_red' => '',
		'color_red' => '',
		'color_orange' => '',
		'color_brown' => '',
		'color_yellow' => '',
		'color_green' => '',
		'color_olive' => '',
		'color_cyan' => '',
		'color_blue' => '',
		'color_dark_blue' => '',
		'color_indigo' => '',
		'color_violet' => '',
		'color_white' => '',
		'color_black' => '',

		'Font_size' => '',
		'font_tiny' => '',
		'font_small' => '',
		'font_normal' => '',
		'font_large' => '',
		'font_huge' => '',

		'Close_Tags' => '',
		'Styles_tip' => '',
	);
}

// search
if ( !$is || $is['admin'] || $is['search'] )
{
	$lang += array(
		'Search_Flood_Error' => '',
		'Found_search_match' => '',
		'Found_search_matches' => '',
		'Search_query' => '',
		'Search_options' => '',
		'Search_keywords' => '',
		'Search_keywords_explain' => '',
		'Search_author' => '',
		'Search_for_any' => '',
		'Search_for_all' => '',
		'Search_title_msg' => '',
		'Search_msg_only' => '',
		'Return_first' => '',
		'characters_posts' => '',
		'Search_previous' => '',
		'Sort_Forum' => '',
		'Display_results' => '',
		'All_available' => '',
		'No_searchable_forums' => '',
	);
}

// groupcp
if ( !$is || $is['admin'] || $is['groupcp'] )
{
	$lang += array(
		'Click_return_group' => '',
		'Group_name' => '',
		'Group_Control_Panel' => '',
		'Group_member_details' => '',
		'Group_member_join' => '',
		'Group_Information' => '',
		'Group_description' => '',
		'Group_membership' => '',
		'Group_Members' => '',
		'Group_Moderator' => '',
		'Pending_members' => '',
		'Group_type' => '',
		'Group_open' => '',
		'Group_closed' => '',
		'Group_hidden' => '',
		'Current_memberships' => '',
		'Non_member_groups' => '',
		'Memberships_pending' => '',
		'No_groups_exist' => '',
		'Group_not_exist' => '',
		'Join_group' => '',
		'No_group_members' => '',
		'Group_hidden_members' => '',
		'Group_joined' => '',
		'Group_request' => '',
		'Group_approved' => '',
		'Group_added' => '',
		'Already_member_group' => '',
		'User_is_member_group' => '',
		'Group_type_updated' => '',
		'Could_not_add_user' => '',
		'Could_not_anon_user' => '',
		'Confirm_unsub' => '',
		'Confirm_unsub_pending' => '',
		'Unsub_success' => '',
		'Approve_selected' => '',
		'Deny_selected' => '',
		'Remove_selected' => '',
		'Add_member' => '',
		'Not_group_moderator' => '',
		'Login_to_join' => '',
		'This_open_group' => '',
		'This_closed_group' => '',
		'This_hidden_group' => '',
		'Member_this_group' => '',
		'Pending_this_group' => '',
		'Are_group_moderator' => '',
		'Subscribe' => '',
		'Unsubscribe' => '',
		'View_Information' => '',
	);
}

// memberlist
if ( !$is || $is['admin'] || $is['memberlist'] )
{
	$lang += array(
		'Sort_Top_Ten' => '',
		'Sort_Joined' => '',
		'Sort_Username' => '',
		'Sort_Location' => '',
		'Sort_Posts' => '',
		'Sort_Email' => '',
		'Sort_Website' => '',
	);
}

// class_stats
if ( !$is || $is['admin'] || $is['class_stats'] )
{
	$lang += array(
		'Who_is_Online' => '',
		'Online_explain' => '',

		'Registered_users' => '',
		'Browsing_forum' => '',
		'Record_online_users' => '',
		'Posted_articles_total' => '',
		'Posted_article_total' => '',
		'Posted_articles_zero_total' => '',

		'Online_users_total' => '',
		'Online_user_total' => '',
		'Online_users_zero_total' => '',

		'Reg_users_total' => '',
		'Reg_user_total' => '',
		'Reg_users_zero_total' => '',

		'Hidden_user_total' => '',
		'Hidden_users_total' => '',
		'Hidden_users_zero_total' => '',

		'Guest_users_total' => '',
		'Guest_user_total' => '',
		'Guest_users_zero_total' => '',

		'Registered_users_total' => '',
		'Registered_user_total' => '',
		'Registered_users_zero_total' => '',

		'Moderator' => '',
	);
}

// viewonline
if ( !$is || $is['admin'] || $is['viewonline'] )
{
	$lang += array(
		'Reg_users_zero_online' => '',
		'Reg_users_online' => '',
		'Reg_user_online' => '',
		'Hidden_users_zero_online' => '',
		'Hidden_users_online' => '',
		'Hidden_user_online' => '',
		'Guest_users_online' => '',
		'Guest_users_zero_online' => '',
		'Guest_user_online' => '',
		'No_users_browsing' => '',
		'Forum_Location' => '',
		'Last_updated' => '',
		'Logging_on' => '',
		'Posting_message' => '',
		'Searching_forums' => '',
		'Viewing_profile' => '',
		'Viewing_online' => '',
		'Viewing_member_list' => '',
		'Viewing_priv_msgs' => '',
		'Viewing_FAQ' => '',
	);
}

// faq
if ( !$is || $is['admin'] || $is['faq'] )
{
	$lang += array(
		'BBCode_guide' => '',
	);
}

?>