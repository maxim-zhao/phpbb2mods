<?php
/***************************************************************************
 *                             member_bclist.php
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
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERBC);
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

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
}
else
{
	$mode = '';
}

if(isset($HTTP_POST_VARS['order']))
{
	$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
}
else if(isset($HTTP_GET_VARS['order']))
{
	$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
}
else
{
	$sort_order = 'ASC';
}

//
// Member business card sorting
//
$mode_types_text = array($lang['Username'], $lang['BC_real_name'], $lang['BC_company'], $lang['BC_company_address'], $lang['BC_designation'], $lang['BC_country']);
$mode_types = array('username', 'real_name', 'company', 'company_address', 'designation', 'country');

$select_sort_mode = '<select name="mode">';
for($i = 0; $i < count($mode_types_text); $i++)
{
	$selected = ( $mode == $mode_types[$i] ) ? ' selected="selected"' : '';
	$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
}
$select_sort_mode .= '</select>';

$select_sort_order = '<select name="order">';
if($sort_order == 'ASC')
{
	$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
}
else
{
	$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
}
$select_sort_order .= '</select>';

//
// Generate page
//
$page_title = $lang['Member_bclist'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'member_bclist_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_BC_REAL_NAME' => $lang['BC_real_name'],
	'L_BC_COMPANY' => $lang['BC_company'],
	'L_BC_COUNTRY' => $lang['BC_country'],
	'L_BC_COMPANY_ADDRESS' => $lang['BC_company_address'],
	'L_BC_LOOK_FOR' => $lang['BC_look_for'],
	'L_BC_TO_OFFER' => $lang['BC_to_offer'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],
	'L_SUBMIT' => $lang['Sort'],

	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'S_MODE_ACTION' => append_sid("member_bclist.$phpEx"))
);

switch( $mode )
{
	case 'username':
		$order_by = "username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'real_name':
		$order_by = "user_real_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'company':
		$order_by = "user_company $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'company_address':
		$order_by = "user_company_address $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'designation':
		$order_by = "user_designation $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'country':
		$order_by = "user_country $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}

$sql = "SELECT username, user_id, user_avatar, user_avatar_type, user_allowavatar, user_real_name, user_company, user_designation, user_country, user_company_address, user_com_add_bbcode_uid, user_allowhtml, user_allowsmile
	FROM " . USERS_TABLE . "
	WHERE user_id <> " . ANONYMOUS . "
	ORDER BY $order_by";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		$user_id = $row['user_id'];

		$poster_avatar = '';
		if ( $row['user_avatar_type'] && $user_id != ANONYMOUS && $row['user_allowavatar'] )
		{
			switch( $row['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_REMOTE:
					$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
				case USER_AVATAR_GALLERY:
					$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;
			}
		}

		$real_name = $row['user_real_name'];
		$company = $row['user_company'];
		$designation = $row['user_designation'];
		$country = $row['user_country'];
		$company_address = $row['user_company_address'];
		$com_add_bbcode_uid = $row['user_com_add_bbcode_uid'];

		$bc_filled = 0;
		if ( !empty($real_name) or !empty($company) or !empty($designation) or !empty($country) or !empty($company_address) or !empty($look_for) or !empty($to_offer) )
		{
			$bc_filled = 1;
		}

		$temp_url = append_sid("viewbc.$phpEx?" . POST_USERS_URL . "=$user_id");
		$bc_img = ( $bc_filled ) ? '<br /><a href="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\', \'_phpbbbc\', \'HEIGHT=600,resizable=yes,scrollbars=yes,WIDTH=700\');return false;" target="_phpbbbc" class="nav"><img src="' . $images['icon_bc'] . '" alt="' . $lang['Business_card'] . '" title="' . $lang['Business_card'] . '" border="0" /></a>' : '';
		$bc = ( $bc_filled ) ? '<br /><a href="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\', \'_phpbbbc\', \'HEIGHT=600,resizable=yes,scrollbars=yes,WIDTH=700\');return false;" target="_phpbbbc" class="nav">' . $lang['Business_card'] . '</a>' : '';

		$company_address = bc_prepare($company_address, $com_add_bbcode_uid, $userdata['user_allowhtml'], $row['user_allowsmile']);

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars('memberrow', array(
			'ROW_NUMBER' => $i + ( $start + 1 ),
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'USERNAME' => $row['username'],
			'AVATAR_IMG' => $poster_avatar,
			'BC_REAL_NAME' => $real_name,
			'BC_COMPANY' => $company,
			'BC_DESIGNATION' => ( $designation ) ? '<br />' . $designation : '',
			'BC_COUNTRY' => $country,
			'BC_COMPANY_ADDRESS' => $company_address,
			'BC_IMG' => $bc_img,
			'BC' => $bc,
			
			'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
		);

		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
	$db->sql_freeresult($result);
}

if ( $board_config['topics_per_page'] < 10 )
{
	$sql = "SELECT count(*) AS total
		FROM " . USERS_TABLE . "
		WHERE user_id <> " . ANONYMOUS;

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_members = $total['total'];

		$pagination = generate_pagination("member_bclist.$phpEx?mode=$mode&amp;order=$sort_order", $total_members, $board_config['topics_per_page'], $start). '&nbsp;';
	}
	$db->sql_freeresult($result);
}
else
{
	$pagination = '&nbsp;';
	$total_members = 10;
}

$template->assign_vars(array(
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_members / $board_config['topics_per_page'] )), 

	'L_GOTO_PAGE' => $lang['Goto_page'])
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
