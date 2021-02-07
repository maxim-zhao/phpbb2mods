<?php
/***************************************************************************
 *                           		viewbc.php
 *                            -------------------
 * Begin		: November 16, 2005
 * Email		: ycl6@users.sourceforge.net (http://macphpbbmod.sourceforge.net/)
 * Ver.			: 1.0.0
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWBC);
init_userprefs($userdata);
//
// End session management
//

// Check viewing privileges
if ( $board_config['business_card_viewing'] == BUSINESS_CARD_DISPLAY_MEMBER )
{
	if ( $userdata['user_level'] == ANONYMOUS )
	{
		message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
	}
}
elseif ( $board_config['business_card_viewing'] == BUSINESS_CARD_DISPLAY_ADMIN )
{
	if ( $userdata['user_level'] != ADMIN )
	{
		message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
	}
}

if ( empty($HTTP_GET_VARS[POST_USERS_URL]) || $HTTP_GET_VARS[POST_USERS_URL] == ANONYMOUS )
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}
$profiledata = get_userdata($HTTP_GET_VARS[POST_USERS_URL]);

if (!$profiledata)
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}

//
// Output page header and bc_view_body template
//
$template->set_filenames(array(
	'bcbody' => 'bc_view_body.tpl')
);

$avatar_img = '';
if ( $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )
{
	switch( $profiledata['user_avatar_type'] )
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
	}
}

$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);
$profile_img = '<a href="' . $temp_url . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
$profile = '<a href="' . $temp_url . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $lang['Read_profile'] . '</a>';

$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);
$pm_img = '<a href="' . $temp_url . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $lang['Send_private_message'] . '</a>';

if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )
{
	$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $profiledata['user_id']) : 'mailto:' . $profiledata['user_email'];

	$email_img = '<a href="' . $email_uri . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
	$email = '<a href="' . $email_uri . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $lang['Send_email'] . '</a>';
}
else
{
	$email_img = '&nbsp;';
	$email = '&nbsp;';
}

$www_img = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '&nbsp;';
$www = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $profiledata['user_website'] . '</a>' : '&nbsp;';

if ( !empty($profiledata['user_icq']) )
{
	$icq_status_img = '<a href="http://wwp.icq.com/' . $profiledata['user_icq'] . '#pager" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="http://web.icq.com/whitepages/online?icq=' . $profiledata['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
	$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
	$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $lang['ICQ'] . '</a>';
}
else
{
	$icq_status_img = '&nbsp;';
	$icq_img = '&nbsp;';
	$icq = '&nbsp;';
}

$aim_img = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '&nbsp;';
$aim = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $lang['AIM'] . '</a>' : '&nbsp;';

$temp_url = append_sid("http://members.msn.com/" . $profiledata['user_msnm']);
$msn_img = ( $profiledata['user_msnm'] ) ? '<a href="' . $temp_url . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
$msn = ( $profiledata['user_msnm'] ) ? '<a href="' . $temp_url . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $lang['MSNM'] . '</a>' : '';

$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
$yim = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;">' . $lang['YIM'] . '</a>' : '';

$real_name = $profiledata['user_real_name'];
$company = $profiledata['user_company'];
$designation = $profiledata['user_designation'];
$country = $profiledata['user_country'];
$company_address = $profiledata['user_company_address'];
$company_logo = $profiledata['user_company_logo'];
$com_add_bbcode_uid = $profiledata['user_com_add_bbcode_uid'];

$company_address = bc_prepare($company_address, $com_add_bbcode_uid, $userdata['user_allowhtml'], $row['user_allowsmile']);

if (!empty($company_logo))
{
	if (!empty($profiledata['user_website']))
	{
		if (!empty($company))
		{
			$company_logo = '<a href="' . $profiledata['user_website'] . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $company_logo . '" alt="' . $company . '" title="' . $company . '" border="0" />';
		}
		else
		{
			$company_logo = '<a href="' . $profiledata['user_website'] . '" onclick="popUpWin(this.href,\'fullScreen\');return false;" onkeypress="popUpWin(this.href,\'fullScreen\');return false;"><img src="' . $company_logo . '" border="0" />';
		}
	}
	else
	{
			$company_logo = '<img src="' . $company_logo . '" alt="' . $company . '" title="' . $company . '" border="0" />';
	}
}
else
{
	$company_logo = '&nbsp;';
}

//
// Generate page
//
$gen_simple_header = TRUE;
$page_title = $lang['Viewing_bc'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

if (function_exists('get_html_translation_table'))
{
	$u_search_author = urlencode(strtr($profiledata['username'], array_flip(get_html_translation_table(HTML_ENTITIES))));
}
else
{
	$u_search_author = urlencode(str_replace(array('&amp;', '&#039;', '&quot;', '&lt;', '&gt;'), array('&', "'", '"', '<', '>'), $profiledata['username']));
}

$template->assign_vars(array(
	'USERNAME' => $profiledata['username'],
	'PROFILE_IMG' => $profile_img,
	'PROFILE' => $profile,
	'PM_IMG' => $pm_img,
	'PM' => $pm,
	'EMAIL_IMG' => $email_img,
	'EMAIL' => $email,
	'WWW_IMG' => $www_img,
	'WWW' => $www,
	'ICQ_STATUS_IMG' => $icq_status_img,
	'ICQ_IMG' => $icq_img, 
	'ICQ' => $icq, 
	'AIM_IMG' => $aim_img,
	'AIM' => $aim,
	'MSN_IMG' => $msn_img,
	'MSN' => $msn,
	'YIM_IMG' => $yim_img,
	'YIM' => $yim,
	'LOCATION' => ( $profiledata['user_from'] ) ? $profiledata['user_from'] : '&nbsp;',
	'OCCUPATION' => ( $profiledata['user_occ'] ) ? $profiledata['user_occ'] : '&nbsp;',
	'AVATAR_IMG' => $avatar_img,
	'REAL_NAME' => $real_name,
	'COMPANY' => $company,
	'DESIGNATION' => $designation,
	'COUNTRY' => ($country) ? $country : '&nbsp;',
	'COMPANY_ADDRESS' => ($company_address) ? $company_address : '&nbsp;',
	'COMPANY_LOGO' => $company_logo,

	'L_VIEWING_BC' => sprintf($lang['Viewing_user_bc'], $profiledata['username']), 
	'L_PROFILE' => $lang['Profile'],
	'L_CONTACT' => $lang['Contact'],
	'L_EMAIL_ADDRESS' => $lang['Email_address'],
	'L_EMAIL' => $lang['Email'],
	'L_PM' => $lang['Private_Message'],
	'L_ICQ_NUMBER' => $lang['ICQ'],
	'L_YAHOO' => $lang['YIM'],
	'L_AIM' => $lang['AIM'],
	'L_MESSENGER' => $lang['MSNM'],
	'L_WEBSITE' => $lang['Website'],
	'L_LOCATION' => $lang['Location'],
	'L_OCCUPATION' => $lang['Occupation'],
	'L_BC_COUNTRY' => $lang['BC_country'],
	'L_BC_COMPANY_ADDRESS' => $lang['BC_company_address'],
	'L_BC_COMPANY_LOGO' => $lang['BC_company_logo'],
	'L_CLOSE_WINDOW' => $lang['Close_window'],

	'U_SEARCH_USER' => append_sid("search.$phpEx?search_author=" . $u_search_author)
	)
);

$template->pparse('bcbody');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>