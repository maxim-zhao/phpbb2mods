<?php
//--------------------------------------------------
// Patch file:	patch_ucp_editprofile.php
// Patch time:	Wed 10 May 2006, 10:23 (GMT)
//--------------------------------------------------
if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

// header
$patch_version = '1.0.6';
$patch_date = '20061224';
$patch_author = 'Ptirhiik';
$patch_ref = 'User control panel : Profile';
$patch_sys = true;

// panels and fields
$patch_data = array(
	'ucp' => array(
		'name' => 'User_control_panel',
		'auth' => array(POST_PANELS_URL => 'access'),
		'options' => array(

			'viewprofile' => array(
				'name' => 'Read_profile',
				'file' => 'includes/ucp/ucp_bridge',
				'auth' => array(POST_GROUPS_URL => 'ucp_view_profile'),
				'hidden' => true,
			),

			'email' => array(
				'name' => 'Send_email_msg',
				'file' => 'includes/ucp/ucp_bridge',
				'auth' => array(POST_PANELS_URL => 'access'),
				'hidden' => true,
			),

			'sendpassword' => array(
				'name' => 'Send_password',
				'file' => 'includes/ucp/ucp_bridge',
				'auth' => array(POST_PANELS_URL => 'access'),
				'hidden' => true,
			),

			'activate' => array(
				'name' => 'Account_activation',
				'file' => 'includes/ucp/ucp_bridge',
				'auth' => array(POST_PANELS_URL => 'access'),
				'hidden' => true,
			),

			'register' => array(
				'name' => 'Register',
				'file' => 'includes/ucp/ucp_register_new',
				'auth' => array(POST_PANELS_URL => 'access'),
				'hidden' => true,
			),

			'editprofile' => array(
				'name' => 'Profile',
				'auth' => array(POST_GROUPS_URL => 'ucp_edit_profile'),
				'options' => array(

					'reginfo' => array(
						'name' => 'Registration_info',
						'file' => 'includes/ucp/ucp_register_edit',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_registration'),
					),

					'contact' => array(
						'name' => 'Contact',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_contact'),
						'fields' => array(
							'user_icq' => array('class_file' => 'includes/ucp/ucp_fields', 'type' => 'icq', 'legend' => 'ICQ', 'length' => '15', 'length_mini' => '2', 'length_maxi' => '15', 'empty_allowed' => '1', 'field' => 'user_icq'),
							'user_aim' => array('type' => 'aim', 'legend' => 'AIM', 'length' => '25', 'length_mini' => '2', 'empty_allowed' => '1', 'field' => 'user_aim', 'class_file' => 'includes/ucp/ucp_fields'),
							'user_msnm' => array('type' => 'msnm', 'legend' => 'MSNM', 'length' => '25', 'length_mini' => '2', 'empty_allowed' => '1', 'field' => 'user_msnm', 'class_file' => 'includes/ucp/ucp_fields'),
							'user_yim' => array('type' => 'yim', 'legend' => 'YIM', 'length' => '25', 'length_mini' => '2', 'empty_allowed' => '1', 'field' => 'user_yim', 'class_file' => 'includes/ucp/ucp_fields'),
							'user_website' => array('class_file' => 'includes/ucp/ucp_fields', 'type' => 'www', 'legend' => 'Website', 'length_mini' => '2', 'empty_allowed' => '1', 'field' => 'user_website'),
						),
					),

					'personal' => array(
						'name' => 'Personal',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_personal'),
						'fields' => array(
							'user_from' => array('type' => 'varchar', 'legend' => 'Location', 'field' => 'user_from'),
							'user_occ' => array('type' => 'text', 'legend' => 'Occupation', 'field' => 'user_occ'),
							'user_interests' => array('type' => 'text', 'legend' => 'Interests', 'field' => 'user_interests'),
						),
					),

					'avatar' => array(
						'name' => 'Avatar_panel',
						'file' => 'includes/ucp/ucp_avatar',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_avatar'),
						'fields' => array(
							'avatar_explain' => array('type' => 'comment', 'legend' => 'Avatar_explain'),
							'current_avatar' => array('type' => 'comment', 'output' => '1', 'legend' => 'Avatar_not_found'),
							'file_upload' => array('class_file' => 'includes/ucp/ucp_fields', 'type' => 'file', 'legend' => 'Upload_Avatar_file'),
							'url_upload' => array('type' => 'varchar', 'legend' => 'Upload_Avatar_URL', 'explain' => 'Upload_Avatar_URL_explain'),
							'link_remote' => array('type' => 'varchar', 'legend' => 'Link_remote_Avatar', 'explain' => 'Link_remote_Avatar_explain'),
							'url_gallery' => array('type' => 'varchar', 'output' => '1', 'legend' => 'Select_from_gallery'),
							'gallery' => array('type' => 'button', 'legend' => 'View_avatar_gallery', 'image' => 'cmd_select', 'combined' => '1'),
						),
					),

					'sig' => array(
						'name' => 'Signature_panel',
						'auth' => array(POST_GROUPS_URL => 'ucp_edit_signature'),
						'fields' => array(
							'signature_comment' => array('type' => 'sig_comment', 'legend' => 'Signature_explain'),
							'user_sig' => array('type' => 'signature', 'field' => 'user_sig', 'class_file' => 'includes/ucp/ucp_fields', 'sub_fields' => array('bbcode_uid' => 'user_sig_bbcode_uid'), 'legend' => 'Signature'),
						),
					),
				),
			),

			'admin' => array(
				'name' => 'User_admin',
				'file' => 'includes/ucp/ucp_admin_edit',
				'auth' => array(POST_GROUPS_URL => 'ucp_edit_admin'),
				'fields' => array(
					'user_active' => array('type' => 'radio_list', 'legend' => 'User_status', 'options' => '[var]list_no_yes', 'field' => 'user_active', 'explain' => 'User_delete_explain'),
					'user_delete' => array('type' => 'button', 'legend' => 'User_delete', 'explain' => 'User_delete_explain', 'image' => 'cmd_delete', 'combined' => 1),
					'user_allow_pm' => array('type' => 'radio_list', 'legend' => 'User_allowpm', 'options' => '[var]list_no_yes', 'field' => 'user_allow_pm'),
					'user_allowavatar' => array('type' => 'radio_list', 'legend' => 'User_allowavatar', 'options' => '[var]list_no_yes', 'field' => 'user_allowavatar'),
					'user_rank' => array('type' => 'special_rank', 'legend' => 'User_special_rank', 'field' => 'user_rank', 'class_file' => 'includes/ucp/ucp_fields'),
				),
			),
		),
	),
);


// auths definitions
$patch_auths = array(
	POST_PANELS_URL => array(
		'access' => array(
			GROUP_ANONYMOUS => array('ucp' => true, 'ucp.sendpassword' => true, 'ucp.confirm' => true, 'ucp.activate' => true, 'ucp.register' => true),
			GROUP_ADMIN => array('ucp.register' => true),
			GROUP_REGISTERED => array('ucp' => true, 'ucp.email' => true, 'ucp.activate' => true),
		),
	),

	POST_GROUPS_URL => array(
		'ucp_edit_admin' => array(
			GROUP_ADMIN => array(GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
		),
		'ucp_edit_avatar' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_contact' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_personal' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_profile' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_registration' => array(
			GROUP_ADMIN => array(GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_edit_signature' => array(
			GROUP_ADMIN => array(GROUP_ANONYMOUS => true, GROUP_FOUNDER => DENY, GROUP_ADMIN => DENY, GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true),
		),
		'ucp_view_profile' => array(
			GROUP_ANONYMOUS => array(GROUP_REGISTERED => true),
			GROUP_REGISTERED => array(GROUP_OWN => true, GROUP_REGISTERED => true),
		),
	),
);

?>