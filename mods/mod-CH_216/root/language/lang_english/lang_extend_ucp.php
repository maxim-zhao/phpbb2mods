<?php
//
//	file: language/lang_english/lang_extend_ucp.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.2 - 24/10/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// admin part
if ( !$is || $is['admin'] || $is['editprofile'] )
{
	$lang['Lang_extend_ucp'] = 'User control panels';
	$lang['Profile_explain'] = 'Here you can administrate your users profile.';

	// auths
	$lang['ucp_edit_registration'] = 'Can edit registration information';
	$lang['ucp_edit_admin'] = 'Can edit administration level information';
	$lang['ucp_edit_avatar'] = 'Can edit avatar';
	$lang['ucp_edit_personal'] = 'Can edit personal informations';
	$lang['ucp_edit_contact'] = 'Can edit web contact';
	$lang['ucp_edit_signature'] = 'Can edit signature';
	$lang['ucp_send_email'] = 'Can send an email';
	$lang['ucp_view_profile'] = 'Can view profile';

	// visual confirmation
	$lang['Visual_confirmation'] = 'Visual confirmation';

	// account activation
	$lang['Account_activation'] = 'Account activation';

	// password renew
	$lang['Too_many_passwords'] = 'You have exceeded the number of password renew attempts for this session. Please try again later.';

	// profile
	$lang['Click_return_editprofile'] = 'Click %sHere%s to return to your profile.';
	$lang['Profile_updated_other'] = 'The profile has been updated.';
	$lang['Click_return_editprofile_other'] = 'Click %sHere%s to return to the user\'s profile.';

	// profile : registration
	$lang['Password_short'] = 'Your password must have at least %d characters';
	$lang['Agree'] = 'I agree to these terms';
	$lang['Register_new'] = 'Register a new user';

	// profile : personal
	$lang['Personal'] = 'Personal';

	// profile : contact
	$lang['Only_numeric_allowed'] = 'Only numerics are allowed';

	// profile : avatar panel
	$lang['Avatar_not_found'] = 'I haven\'t been able to find your avatar.';
	$lang['Avatars_not_allowed'] = 'Avatars aren\'t allowed.';
	$lang['Avatars_denied'] = 'You are not allowed to display an avatar.';
	$lang['Avatars_denied_user'] = 'This user is not allowed to display an avatar.';
	$lang['No_avatar_choosen'] = 'You haven\'t choosen any avatar.';
	$lang['Many_avatar_choosen'] = 'Only one type of avatar can be specified.';

	// profile : avatar panel : gallery
	$lang['No_avatar_galleries'] = 'There are no available avatar galleries.';
	$lang['Empty_gallery'] = 'There are no available avatar in this gallery.';
	$lang['Avatar_count'] = '[%d Avatars]';
	$lang['Avatar_count_1'] = '[%d Avatar]';

	// profile : signature panel
	$lang['Signature_panel'] = 'Signature control panel';

	// preferences
	$lang['Click_return_prefs'] = 'Click %sHere%s to return to your preferences.';
	$lang['Click_return_prefs_other'] = 'Click %sHere%s to return to the user\'s preferences.';

	// prefs : i18n
	$lang['Internationalisation'] = 'Internationalisation';
	$lang['tz_suggest'] = 'Synchronise';
	$lang['tz_suggest_explain'] = 'Try to find your closest timezone';
	$lang['dst'] = 'Summertime';
	$lang['dst_explain'] = 'Adjust the time for summer (add 1 hour in summer)';
	$lang['Smart_date'] = 'Smart date';
	$lang['Smart_date_explain'] = 'Display "Today" or "Yesterday" in messages dates.';

	// prefs : topic read
	$lang['Topic_read'] = 'Reading topics';
	$lang['Keep_unreads'] = 'Keep messages unread';
	$lang['Keep_unreads_dft_explain'] = 'Choose "Yes" to keep unread topics alive for your next visit.';
	$lang['Topics_sort'] = 'Sort topics by';
	$lang['Topics_sort_dft_explain'] = 'Select the default sort method.';
	$lang['Posts_sort'] = 'Sort posts by';
	$lang['Posts_sort_dft_explain'] = 'Select the default sort method for posts within topics.';

	// prefs : posting a message
	$lang['Posting_messages'] = 'Posting a message';

	// prefs : privacy choices
	$lang['Privacy_choices'] = 'Privacy choices';

	// prefs: board layout
	$lang['Board_layout'] = 'Board layout';
	$lang['Board_box_display'] = 'Display Board announcements box';
	$lang['Index_pack'] = 'Pack sub-categories';
	$lang['Index_pack_explain'] = 'If set, categories will appear with a forum layer.';
	$lang['Index_split'] = 'Split sub-categories';
	$lang['Index_split_explain'] = 'If set, categories will be separated from each other. This setup is ignored if "Pack sub-categories" is On.';

	// admin
	$lang['User_admin'] = 'Administration';
	$lang['User_status'] = 'User is active';
	$lang['User_allowpm'] = 'Can send Private Messages';
	$lang['User_allowavatar'] = 'Can display avatar';
	$lang['User_special_rank'] = 'Special rank';
	$lang['No_assigned_rank'] = 'No special rank assigned';
	$lang['User_delete'] = 'Delete this user';
	$lang['User_delete_explain'] = 'Click "Delete" to delete this user; this cannot be undone.';
	$lang['Confirm_user_delete'] = 'Are you sure you want to delete this user ?';
	$lang['User_deleted'] = 'The user was successfully deleted.';


	$lang['Click_return_admin'] = 'Click %sHere%s to return to your profile.';
	$lang['Click_return_admin_other'] = 'Click %sHere%s to return to the profile.';
}

?>