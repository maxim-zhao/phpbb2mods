<?php
//--------------------------------------------------
// Patch file:	patch_acp_config_ch.php
// Patch time:	Mon 12 March 2007, 10:00 (GMT)
//--------------------------------------------------
if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

// header
$patch_version = '1.0.15';
$patch_date = '20070312';
$patch_author = 'Ptirhiik';
$patch_ref = 'Configuration : general configuration for CH';
$patch_sys = true;

// panels and fields
$patch_data = array(
	'acp' => array(
		'name' => 'Admin_control_panel',
		'auth' => array(POST_PANELS_URL => 'access'),
		'options' => array(

			'stats' => array(
				'name' => 'Statistics',
				'auth' => array(POST_PANELS_URL => 'access'),
				'options' => array(

					'summary' => array(
						'name' => 'Stats_summary',
						'file' => 'includes/acp/acp_stats_summary',
						'auth' => array(POST_PANELS_URL => 'access'),
					),

					'visits' => array(
						'name' => 'Stats_visit',
						'file' => 'includes/acp/acp_stats_visit',
						'auth' => array(POST_PANELS_URL => 'access'),
					),

					'registration' => array(
						'name' => 'Stats_register',
						'file' => 'includes/acp/acp_stats_register',
						'auth' => array(POST_PANELS_URL => 'access'),
					),

					'posting' => array(
						'name' => 'Stats_posting',
						'file' => 'includes/acp/acp_stats_posting',
						'auth' => array(POST_PANELS_URL => 'access'),
					),
				),
			),

			'config' => array(
				'name' => 'Configuration',
				'auth' => array(POST_PANELS_URL => 'access'),
				'options' => array(

					'server' => array(
						'name' => 'Server_settings',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'board_url_settings' => array('type' => 'sub_title', 'legend' => 'Board_url_settings'),
							'board_url_settings_explain' => array('type' => 'comment', 'legend' => 'Board_url_settings_explain'),
							'cookie_secure' => array('type' => 'radio_list', 'options' => array(0 => 'Disabled', 1 => 'Enabled'), 'field' => 'cookie_secure', 'legend' => 'Server_secure', 'explain' => 'Server_secure_explain'),
							'server_name' => array('type' => 'varchar', 'legend' => 'Server_name', 'explain' => 'Server_name_explain', 'field' => 'server_name', 'length_mini' => '1'),
							'server_port' => array('type' => 'int', 'legend' => 'Server_port', 'explain' => 'Server_port_explain', 'field' => 'server_port'),
							'script_path' => array('type' => 'varchar', 'legend' => 'Script_path', 'explain' => 'Script_path_explain', 'field' => 'script_path'),
							'cookie_settings' => array('type' => 'sub_title', 'legend' => 'Cookie_settings'),
							'cookie_settings_explain' => array('type' => 'comment', 'legend' => 'Cookie_settings_explain'),
							'cookie_domain' => array('type' => 'varchar', 'legend' => 'Cookie_domain', 'field' => 'cookie_domain'),
							'cookie_name' => array('type' => 'varchar', 'legend' => 'Cookie_name', 'field' => 'cookie_name'),
							'cookie_path' => array('type' => 'varchar', 'legend' => 'Cookie_path', 'field' => 'cookie_path'),
							'system_settings' => array('type' => 'sub_title', 'legend' => 'System_settings'),
							'gzip_compress' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'gzip_compress', 'legend' => 'Enable_gzip'),
						),
					),

					'caches' => array(
						'name' => 'Cache_admin',
						'file' => 'includes/acp/acp_caches',
						'auth' => array(POST_PANELS_URL => 'access'),
					),

					'i18n' => array(
						'name' => 'Internationalisation',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'default_lang' => array('type' => 'list', 'legend' => 'Default_language', 'options' => '[func]get_list_langs', 'field' => 'default_lang'),
							'list_dateformat' => array('type' => 'list', 'legend' => 'Date_format', 'explain' => 'Date_format_explain', 'html' => ' onchange="if (this.selectedIndex != 0) {this.form.default_dateformat.value=this.options[this.selectedIndex].value;}"', 'field' => 'default_dateformat', 'options' => '[func]get_list_dateformat'),
							'default_dateformat' => array('type' => 'varchar', 'length' => '25', 'field' => 'default_dateformat', 'combined' => '1'),
							'board_timezone' => array('type' => 'list', 'legend' => 'System_timezone', 'field' => 'board_timezone', 'options' => '[func]get_list_timezone'),
							'board_dst' => array('type' => 'radio_list', 'legend' => 'dst', 'explain' => 'dst_explain', 'field' => 'board_dst', 'options' => '[var]list_no_yes'),
							'smart_date' => array('type' => 'radio_list', 'legend' => 'Smart_date', 'explain' => 'Smart_date_explain', 'options' => '[var]list_no_yes', 'field' => 'smart_date'),
							'smart_date_over' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => 'smart_date_over', 'linefeed' => '1'),
						),
					),

					'layout' => array(
						'name' => 'Board_layout',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'site_name' => array('type' => 'varchar', 'legend' => 'Site_name', 'field' => 'sitename'),
							'site_desc' => array('type' => 'varchar', 'legend' => 'Site_desc', 'field' => 'site_desc'),
							'site_fav_icon' => array('type' => 'varchar', 'legend' => 'Site_fav_icon', 'explain' => 'Site_fav_icon_explain', 'field' => 'site_fav_icon'),
							'root_settings' => array('type' => 'sub_title', 'legend' => 'Root_settings'),
							'default_style' => array('type' => 'list', 'legend' => 'Default_style', 'options' => '[func]get_list_styles', 'field' => 'default_style'),
							'override_user_style' => array('type' => 'radio_list_comment', 'legend' => 'Override_style', 'options' => '[var]list_no_yes', 'field' => 'override_user_style', 'linefeed' => '1'),
							'stats_display_past' => array('type' => 'radio_list', 'legend' => 'Stats_display_past', 'options' => '[var]list_no_yes', 'field' => 'stats_display_past'),
							'index_settings' => array('type' => 'sub_title', 'legend' => 'Index_settings'),
							'board_box' => array('type' => 'list', 'legend' => 'Board_box_content', 'explain' => 'Board_box_content_explain', 'options' => array('\'0\'' => 'Do_not_display', 1 => 'Global_Announces', 2 => 'Global_Parent_announces', 3 => 'Global_Childs_announces', 4 => 'Global_Branch_announces'), 'field' => 'board_box'),
							'board_box_over' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => 'board_box_over', 'linefeed' => '1'),
							'index_pack' => array('type' => 'radio_list', 'legend' => 'Index_pack', 'explain' => 'Index_pack_explain', 'options' => '[var]list_no_yes', 'field' => 'index_pack'),
							'index_pack_over' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => 'index_pack_over', 'linefeed' => '1'),
							'index_split' => array('type' => 'radio_list', 'legend' => 'Index_split', 'explain' => 'Index_split_explain', 'options' => '[var]list_no_yes', 'field' => 'index_split'),
							'index_split_over' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => 'index_split_over', 'linefeed' => '1'),
							'last_topic_title_length' => array('type' => 'int', 'legend' => 'Last_topic_title_length', 'explain' => 'Last_topic_title_length_explain', 'field' => 'last_topic_title_length'),
						),
					),

					'searchopt' => array(
						'name' => 'Search_options',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'fulltext_search' => array('type' => 'fulltext_index', 'options' => '[var]list_no_yes', 'field' => 'fulltext_search', 'legend' => 'Fulltext_index', 'explain' => 'Fulltext_index_explain', 'class_file' => 'includes/acp/acp_fields'),
							'search_flood_interval' => array('type' => 'int', 'legend' => 'Search_Flood_Interval', 'explain' => 'Search_Flood_Interval_explain', 'value' => '15', 'field' => 'search_flood_interval'),
							'search_max_concur' => array('type' => 'int', 'legend' => 'Search_max_concur', 'explain' => 'Search_max_concur_explain', 'value' => 10, 'field' => 'search_max_concur'),
							'search_time_concur' => array('type' => 'int', 'legend' => 'Search_time_concur', 'explain' => 'Search_time_concur_explain', 'value' => 5, 'field' => 'search_time_concur'),
						),
					),

					'topicopt' => array(
						'name' => 'Topics_options',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'pagination_min' => array('type' => 'int', 'legend' => 'Pagination_min', 'field' => 'pagination_min', 'value_mini' => '5'),
							'pagination_max' => array('type' => 'int', 'legend' => 'Pagination_max', 'field' => 'pagination_max', 'value_mini' => 5),
							'pagination_percent' => array('type' => 'int', 'legend' => 'Pagination_percent', 'field' => 'pagination_percent', 'value_mini' => 5, 'post_value' => '%'),
							'forums_settings' => array('type' => 'sub_title', 'legend' => 'Forums_settings'),
							'hot_threshold' => array('type' => 'int', 'legend' => 'Hot_threshold', 'field' => 'hot_threshold'),
							'topic_title_length' => array('type' => 'int', 'legend' => 'Topic_title_length', 'explain' => 'Topic_title_length_explain', 'field' => 'topic_title_length'),
							'sub_title_length' => array('type' => 'int', 'legend' => 'Sub_title_length', 'explain' => 'Sub_title_length_explain', 'field' => 'sub_title_length'),
							'split_global' => array('type' => 'radio_list', 'legend' => 'Topics_split_global', 'options' => array(0 => 'No', 1 => 'Topics_split_in_box', 2 => 'Topics_split_title_only'), 'options.linefeed' => '1', 'field' => 'topics_split_global'),
							'split_announces' => array('type' => 'radio_list', 'legend' => 'Topics_split_announces', 'options' => array(0 => 'No', 1 => 'Topics_split_in_box'), 'options.linefeed' => '1', 'field' => 'topics_split_announces'),
							'split_stickies' => array('type' => 'radio_list', 'legend' => 'Topics_split_stickies', 'options' => array(0 => 'No', 1 => 'Topics_split_in_box', 2 => 'Topics_split_title_only'), 'options.linefeed' => '1', 'field' => 'topics_split_stickies'),
							'topic_read' => array('type' => 'sub_title', 'legend' => 'Topic_read'),
							'keep_unreads' => array('type' => 'radio_list', 'legend' => 'Keep_unreads', 'explain' => 'Keep_unreads_explain', 'options' => array('\'0\'' => 'No', 1 => 'Yes', 2 => 'Keep_unreads_in_db'), 'field' => 'keep_unreads', 'config_over' => 'keep_unreads_over'),
							'keep_unreads_over' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => 'keep_unreads_over', 'linefeed' => '1'),
							'keep_unreads_guests' => array('type' => 'radio_list', 'legend' => 'Keep_unreads_guests', 'explain' => 'Keep_unreads_guests_explain', 'options' => '[var]list_no_yes', 'field' => 'keep_unreads_guests'),
							'topics_sort' => array('type' => 'list', 'legend' => 'Topics_sort', 'explain' => 'Topics_sort_dft_explain', 'options' => '[func]get_list_topics_sort', 'field' => 'topics_sort'),
							'topics_order' => array('type' => 'list', 'options' => '[var]list_topics_order', 'field' => 'topics_order', 'combined' => '1'),
							'topics_sort_over' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => 'topics_sort_over', 'linefeed' => '1'),
							'topics_per_page' => array('type' => 'int', 'legend' => 'Topics_per_page', 'field' => 'topics_per_page', 'value_mini' => '1'),
							'posts_sort' => array('type' => 'list', 'legend' => 'Posts_sort', 'explain' => 'Posts_sort_dft_explain', 'options' => '[func]get_list_posts_sort', 'field' => 'posts_sort'),
							'posts_order' => array('type' => 'list', 'options' => '[var]list_posts_order', 'field' => 'posts_order', 'combined' => '1'),
							'posts_sort_over' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => 'posts_sort_over', 'linefeed' => '1'),
							'posts_per_page' => array('type' => 'int', 'legend' => 'Posts_per_page', 'field' => 'posts_per_page', 'value_mini' => '1'),
						),
					),

					'msgopt' => array(
						'name' => 'Messages_options',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'prune_enable' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'prune_enable', 'legend' => 'Enable_prune'),
							'smilies_path' => array('type' => 'internal_dir', 'legend' => 'Smilies_path', 'explain' => 'Smilies_path_explain', 'field' => 'smilies_path', 'length_mini' => '1'),
							'icons_path' => array('type' => 'internal_dir', 'legend' => 'Icons_path', 'explain' => 'Icons_path_explain', 'field' => 'icons_path', 'length_mini' => '1'),
							'posting_messages' => array('type' => 'sub_title', 'legend' => 'Posting_messages'),
							'default_duration' => array('type' => 'int', 'legend' => 'Default_duration', 'explain' => 'Default_duration_explain', 'post_value' => 'Days', 'field' => 'default_duration'),
							'max_poll_options' => array('type' => 'int', 'legend' => 'Max_poll_options', 'field' => 'max_poll_options'),
							'allow_html' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'allow_html', 'legend' => 'Allow_HTML'),
							'allow_html_tags' => array('type' => 'text', 'legend' => 'Allowed_tags', 'explain' => 'Allowed_tags_explain', 'field' => 'allow_html_tags'),
							'allow_bbcode' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'allow_bbcode', 'legend' => 'Allow_BBCode'),
							'allow_smilies' => array('type' => 'radio_list', 'legend' => 'Allow_smilies', 'options' => '[var]list_no_yes', 'field' => 'allow_smilies'),
							'allow_sig' => array('type' => 'radio_list', 'legend' => 'Allow_sig', 'options' => '[var]list_no_yes', 'field' => 'allow_sig'),
							'max_sig_chars' => array('type' => 'int', 'legend' => 'Max_sig_length', 'explain' => 'Max_sig_length_explain', 'field' => 'max_sig_chars'),
							'posting_controls' => array('type' => 'sub_title', 'legend' => 'Posting_controls'),
							'flood_interval' => array('type' => 'int', 'legend' => 'Flood_Interval', 'explain' => 'Flood_Interval_explain', 'field' => 'flood_interval'),
							'enable_confirm_post' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'enable_confirm_post', 'legend' => 'Visual_confirm_post', 'explain' => 'Visual_confirm_post_explain'),
							'guests_proxies_disabled' => array('type' => 'radio_list', 'legend' => 'Guests_proxies_disabled', 'options' => '[var]list_no_yes', 'field' => 'guests_proxies_disabled', 'explain' => 'Guests_proxies_disabled_explain'),
							'posting_max_guests' => array('type' => 'int', 'legend' => 'Posting_max_guests', 'explain' => 'Posting_max_guests_explain', 'value' => 5, 'field' => 'posting_max_guests'),
							'posting_time_guests' => array('type' => 'int', 'legend' => 'Posting_time_guests', 'explain' => 'Posting_time_guests_explain', 'value' => 2, 'field' => 'posting_time_guests'),
						),
					),

					'logset' => array(
						'name' => 'Login_settings',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'board_disable' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'board_disable', 'legend' => 'Board_disable', 'explain' => 'Board_disable_explain'),
							'forum_rules' => array('type' => 'topic_id', 'legend' => 'Forum_rules', 'explain' => 'Forum_rules_explain', 'field' => 'forum_rules'),
							'require_activation' => array('type' => 'radio_list', 'options' => array('\'0\'' => 'Acc_None', 1 => 'Acc_User', 2 => 'Acc_Admin'), 'field' => 'require_activation', 'legend' => 'Acct_activation'),
							'enable_confirm' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'enable_confirm', 'legend' => 'Visual_confirm', 'explain' => 'Visual_confirm_explain'),
							'password_mini' => array('type' => 'int', 'legend' => 'Password_mini', 'explain' => 'Password_mini_explain', 'value' => '5', 'field' => 'password_mini'),
							'allow_autologin' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'allow_autologin', 'legend' => 'Allow_autologin', 'explain' => 'Allow_autologin_explain'),
							'max_autologin_time' => array('type' => 'int', 'legend' => 'Autologin_time', 'explain' => 'Autologin_time_explain', 'field' => 'max_autologin_time'),
							'max_login_attempts' => array('type' => 'int', 'legend' => 'Max_login_attempts', 'explain' => 'Max_login_attempts_explain', 'field' => 'max_login_attempts'),
							'login_reset_time' => array('type' => 'int', 'legend' => 'Login_reset_time', 'explain' => 'Login_reset_time_explain', 'field' => 'login_reset_time'),
							'session_length' => array('type' => 'int', 'legend' => 'Session_length', 'field' => 'session_length'),
							'allow_namechange' => array('type' => 'radio_list', 'legend' => 'Allow_name_change', 'options' => '[var]list_no_yes', 'field' => 'allow_namechange'),
							'coppa_settings' => array('type' => 'sub_title', 'legend' => 'COPPA_settings'),
							'coppa_required' => array('type' => 'radio_list', 'legend' => 'COPPA_required', 'options' => '[var]list_no_yes', 'field' => 'coppa_required'),
							'coppa_fax' => array('type' => 'varchar', 'legend' => 'COPPA_fax', 'field' => 'coppa_fax'),
							'coppa_mail' => array('type' => 'text_html', 'legend' => 'COPPA_mail', 'explain' => 'COPPA_mail_explain', 'field' => 'coppa_mail'),
						),
					),

					'email' => array(
						'name' => 'Email_settings',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'email_disable' => array('type' => 'radio_list', 'options' => array(1 => 'Disabled', 0 => 'Enabled'), 'field' => 'email_disable', 'legend' => 'Email'),
							'board_email_form' => array('type' => 'radio_list', 'options' => '[var]list_no_yes', 'field' => 'board_email_form', 'legend' => 'Board_email_form', 'explain' => 'Board_email_form_explain'),
							'board_email' => array('type' => 'varchar', 'legend' => 'Admin_email', 'field' => 'board_email'),
							'board_email_sig' => array('type' => 'text_html', 'legend' => 'Email_sig', 'explain' => 'Email_sig_explain', 'field' => 'board_email_sig'),
							'smtp_settings' => array('type' => 'sub_title', 'legend' => 'SMTP_settings'),
							'smtp_delivery' => array('type' => 'radio_list', 'legend' => 'Use_SMTP', 'options' => '[var]list_no_yes', 'field' => 'smtp_delivery', 'explain' => 'Use_SMTP_explain'),
							'smtp_host' => array('type' => 'varchar', 'legend' => 'SMTP_server', 'field' => 'smtp_host'),
							'smtp_username' => array('type' => 'varchar', 'legend' => 'SMTP_username', 'explain' => 'SMTP_username_explain', 'field' => 'smtp_username'),
							'smtp_password' => array('type' => 'password', 'legend' => 'SMTP_password', 'explain' => 'SMTP_password_explain', 'field' => 'smtp_password'),
						),
					),

					'privmsg' => array(
						'name' => 'Private_Messaging',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'privmsg_disable' => array('type' => 'radio_list', 'options' => array(1 => 'Disabled', 0 => 'Enabled'), 'field' => 'privmsg_disable', 'legend' => 'Disable_privmsg'),
							'max_inbox_privmsgs' => array('type' => 'int', 'legend' => 'Inbox_limits', 'field' => 'max_inbox_privmsgs'),
							'max_sentbox_privmsgs' => array('type' => 'int', 'legend' => 'Sentbox_limits', 'field' => 'max_sentbox_privmsgs'),
							'max_savebox_privmsgs' => array('type' => 'int', 'legend' => 'Savebox_limits', 'field' => 'max_savebox_privmsgs'),
						),
					),

					'avatar' => array(
						'name' => 'Avatar_settings',
						'auth' => array(POST_PANELS_URL => 'access'),
						'fields' => array(
							'allow_avatar_local' => array('type' => 'radio_list', 'legend' => 'Allow_local', 'options' => '[var]list_no_yes', 'field' => 'allow_avatar_local'),
							'allow_avatar_remote' => array('type' => 'radio_list', 'legend' => 'Allow_remote', 'options' => '[var]list_no_yes', 'field' => 'allow_avatar_remote', 'explain' => 'Allow_remote_explain'),
							'allow_avatar_upload' => array('type' => 'radio_list', 'legend' => 'Allow_upload', 'options' => '[var]list_no_yes', 'field' => 'allow_avatar_upload'),
							'avatar_filesize' => array('type' => 'int', 'legend' => 'Max_filesize', 'explain' => 'Max_filesize_explain', 'field' => 'avatar_filesize', 'post_value' => 'Bytes'),
							'avatar_max_height' => array('type' => 'int', 'legend' => 'Max_avatar_size', 'explain' => 'Max_avatar_size_explain', 'field' => 'avatar_max_height', 'post_value' => 'x'),
							'avatar_max_width' => array('type' => 'int', 'field' => 'avatar_max_width', 'combined' => '1'),
							'avatar_path' => array('type' => 'internal_dir', 'legend' => 'Avatar_storage_path', 'explain' => 'Avatar_storage_path_explain', 'field' => 'avatar_path'),
							'avatar_gallery_path' => array('type' => 'internal_dir', 'legend' => 'Avatar_gallery_path', 'explain' => 'Avatar_gallery_path_explain', 'field' => 'avatar_gallery_path'),
						),
					),
				),
			),
		),
	),
);


// auths definitions
$patch_auths = array(
	POST_PANELS_URL => array(
		'auth_manage' => array(),
		'access' => array(
			GROUP_ADMIN => array(
				'acp' => true,

					'acp.stats' => true,
						'acp.stats.summary' => true,
						'acp.stats.visits' => true,
						'acp.stats.registration' => true,
						'acp.stats.posting' => true,

					'acp.config' => true,
						'acp.config.server' => true,
						'acp.config.caches' => true,
						'acp.config.i18n' => true,
						'acp.config.layout' => true,
						'acp.config.topicopt' => true,
						'acp.config.msgopt' => true,
						'acp.config.logset' => true,
						'acp.config.email' => true,
						'acp.config.privmsg' => true,
						'acp.config.avatar' => true,
			),
		),
	),
);


?>