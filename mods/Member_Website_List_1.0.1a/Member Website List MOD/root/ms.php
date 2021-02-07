<?php
/***************************************************************************
 *                           ms.php
 *                    -------------------
 *   begin		: Thursday, Sep 29, 2005
 *   copyright		: Y. C. LIN
 *   email		: ycl6@users.sourceforge.net
 *
 ***************************************************************************/
 
 define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWMS);
init_userprefs($userdata);
//
// End session management
//

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
}
else
{
	$mode = 'username';
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

$mode_types_text = array($lang['Sort_Username'], $lang['Sort_Website']);
$mode_types = array('username', 'website');

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
$page_title = $lang['Member_website'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'ms.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_WEBSITE' => $lang['Website'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],
	'L_SUBMIT' => $lang['Sort'],

	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'S_MODE_ACTION' => append_sid("ms.$phpEx"))
);

switch( $mode )
{
	case 'username':
		$order_by = "username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'website':
		$order_by = "user_website $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}

$sql = "SELECT username, user_id, user_website
	FROM " . USERS_TABLE . "
	WHERE user_id <> " . ANONYMOUS . "
	AND user_website <> ''
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
		$username = $row['username'];
		$user_id = $row['user_id'];

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars('memberrow', array(
			'ROW_NUMBER' => $i + ( $start + 1 ),
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'USERNAME' => $username,
			'U_WWW' => $row['user_website'],
			'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
		);
		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );
	$db->sql_freeresult($result);
}

$total_members = get_db_stat('usercount');

$sql = "SELECT count(*) AS total
	FROM " . USERS_TABLE . "
	WHERE user_id <> " . ANONYMOUS . "
	AND user_website <> ''";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total users who have website details', '', __LINE__, __FILE__, $sql);
}

if ( $total = $db->sql_fetchrow($result) )
{
	$total_members_with_website = $total['total'];

	$pagination = generate_pagination("ms.$phpEx?mode=$mode&amp;order=$sort_order", $total_members_with_website, $board_config['topics_per_page'], $start). '&nbsp;';
}
$db->sql_freeresult($result);

$template->assign_vars(array(
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_members_with_website / $board_config['topics_per_page'] )), 

	'L_MEMBER_WEBSITE' => sprintf($lang['Member_website_explain'], $total_members_with_website, $total_members),
	'L_GOTO_PAGE' => $lang['Goto_page'])
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
