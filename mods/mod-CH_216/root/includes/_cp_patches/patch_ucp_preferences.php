<?php
//--------------------------------------------------
// Patch file:	patch_ucp_preferences.php
// Patch time:	Wed 10 May 2006, 10:23 (GMT)
//--------------------------------------------------
if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

// header
$patch_version = '1.0.8';
$patch_date = '20061024';
$patch_author = 'Ptirhiik';
$patch_ref = 'User control panel : Preferences';
$patch_sys = true;

// panels and fields
$patch_data = array(
	'ucp' => array(
		'name' => 'User_control_panel',
		'auth' => array(POST_PANELS_URL => 'access'),
		'options' => array(

			'prefs' => array(
				'name' => 'Preferences',
				'auth' => array(POST_GROUPS_URL => 'ucp_edit_profile'),
				'options' => array(

					'i18n' => array(
						'name' => 'Internationalisation',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_i18n'),
						'fields' => array(
							'user_lang' => array('type' => 'list', 'legend' => 'Board_lang', 'options' => '[func]get_list_langs', 'field' => 'user_lang'),
							'list_dateformat' => array('type' => 'list', 'legend' => 'Date_format', 'explain' => 'Date_format_explain', 'html' => ' onchange="if (this.selectedIndex != 0) {this.form.user_dateformat.value=this.options[this.selectedIndex].value;}"', 'field' => 'user_dateformat', 'options' => '[func]get_list_dateformat'),
							'user_dateformat' => array('type' => 'varchar', 'length' => '25', 'field' => 'user_dateformat', 'combined' => '1'),
							'user_timezone' => array('type' => 'list', 'legend' => 'Timezone', 'field' => 'user_timezone', 'options' => '[func]get_list_timezone'),
							'tz_suggest' => array('type' => 'image', 'legend' => 'tz_suggest', 'image' => 'cmd_synchro', 'title' => 'tz_suggest_explain', 'link' => '#', 'html' => ' onclick="timezone.suggest(\'user_timezone\', \'user_dst\'); return false;"', 'combined' => '1', 'javascript' => 'includes/js_dom_timezone.js'),
							'user_dst' => array('type' => 'radio_list', 'legend' => 'dst', 'explain' => 'dst_explain', 'field' => 'user_dst', 'options' => '[var]list_no_yes'),
							'user_smart_date' => array('type' => 'radio_list', 'legend' => 'Smart_date', 'explain' => 'Smart_date_explain', 'options' => '[var]list_dft_yes_deny', 'field' => 'user_smart_date', 'config_over' => 'smart_date_over'),
						),
					),

					'topicread' => array(
						'name' => 'Topic_read',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_topicread'),
						'fields' => array(
							'user_keep_unreads' => array('type' => 'radio_list', 'legend' => 'Keep_unreads', 'explain' => 'Keep_unreads_dft_explain', 'options' => '[var]list_dft_yes_deny', 'field' => 'user_keep_unreads', 'config_over' => 'keep_unreads_over'),
							'user_topics_sort' => array('type' => 'list', 'legend' => 'Topics_sort', 'explain' => 'Topics_sort_dft_explain', 'options' => '[func]get_list_topics_sort_dft', 'field' => 'user_topics_sort', 'config_over' => 'topics_sort_over'),
							'user_topics_order' => array('type' => 'list', 'options' => '[var]list_topics_order_dft', 'field' => 'user_topics_order', 'combined' => '1', 'config_over' => 'topics_sort_over'),
							'user_posts_sort' => array('type' => 'list', 'legend' => 'Posts_sort', 'explain' => 'Posts_sort_dft_explain', 'options' => '[func]get_list_posts_sort_dft', 'field' => 'user_posts_sort', 'config_over' => 'posts_sort_over'),
							'user_posts_order' => array('type' => 'list', 'options' => '[var]list_posts_order_dft', 'field' => 'user_posts_order', 'combined' => '1', 'config_over' => 'posts_sort_over'),
						),
					),

					'posting' => array(
						'name' => 'Posting_messages',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_posting'),
						'fields' => array(
							'user_attachsig' => array('type' => 'radio_list', 'legend' => 'Always_add_sig', 'options' => '[var]list_no_yes', 'field' => 'user_attachsig'),
							'user_allowbbcode' => array('type' => 'radio_list', 'legend' => 'Always_bbcode', 'options' => '[var]list_no_yes', 'field' => 'user_allowbbcode'),
							'user_allowhtml' => array('type' => 'radio_list', 'legend' => 'Always_html', 'options' => '[var]list_no_yes', 'field' => 'user_allowhtml'),
							'user_allowsmile' => array('type' => 'radio_list', 'legend' => 'Always_smile', 'options' => '[var]list_no_yes', 'field' => 'user_allowsmile'),
							'user_notify' => array('type' => 'radio_list', 'legend' => 'Always_notify', 'explain' => 'Always_notify_explain', 'options' => '[var]list_no_yes', 'field' => 'user_notify'),
						),
					),

					'privacy' => array(
						'name' => 'Privacy_choices',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_privacy'),
						'fields' => array(
							'user_allow_viewonline' => array('type' => 'radio_list', 'legend' => 'Hide_user', 'options' => '[var]list_reverse_no_yes', 'field' => 'user_allow_viewonline'),
							'user_viewemail' => array('type' => 'radio_list', 'legend' => 'Public_view_email', 'options' => '[var]list_no_yes', 'field' => 'user_viewemail'),
							'user_notify_pm' => array('type' => 'radio_list', 'legend' => 'Notify_on_privmsg', 'options' => '[var]list_no_yes', 'field' => 'user_notify_pm'),
							'user_popup_pm' => array('type' => 'radio_list', 'legend' => 'Popup_on_privmsg', 'explain' => 'Popup_on_privmsg_explain', 'options' => '[var]list_no_yes', 'field' => 'user_popup_pm'),
						),
					),

					'layout' => array(
						'name' => 'Board_layout',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_layout'),
						'fields' => array(
							'user_style' => array('type' => 'list', 'legend' => 'Board_style', 'options' => '[func]get_list_styles_dft', 'field' => 'user_style', 'config_over' => 'override_user_style'),
							'user_board_box' => array('type' => 'radio_list', 'legend' => 'Board_box_display', 'options' => '[var]list_dft_yes_deny', 'field' => 'user_board_box', 'config_over' => 'board_box_over'),
							'user_index_pack' => array('type' => 'radio_list', 'legend' => 'Index_pack', 'explain' => 'Index_pack_explain', 'options' => '[var]list_dft_yes_deny', 'field' => 'user_index_pack', 'config_over' => 'index_pack_over'),
							'user_index_split' => array('type' => 'radio_list', 'legend' => 'Index_split', 'explain' => 'Index_split_explain', 'options' => '[var]list_dft_yes_deny', 'field' => 'user_index_split', 'config_over' => 'index_split_over'),
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
		'access' => array(
			GROUP_ANONYMOUS => array('ucp' => true),
			GROUP_REGISTERED => array('ucp' => true),
		),
	),

	POST_GROUPS_URL => array(
		'ucp_edit_i18n' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_layout' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_posting' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_privacy' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_profile' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_topicread' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
	),
);


?>