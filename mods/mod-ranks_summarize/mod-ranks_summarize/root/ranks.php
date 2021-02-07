<?php
//
//	file: ranks.php
//	author: ptirhiik
//	begin: 26/07/2003
//	version: 2.0.1 - 27/10/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('RANKS_CONSTANTS_DEFINED') )
{
	// these parms change the behaviour of the script
	define('RANKS_GUESTS_ACCESS', false); // set this one to true if you want to allow guests to access this page
	define('RANKS_REG_HIDE_0', false); // set this one to true to hide regular ranks not yet reached
	define('RANKS_SPE_HIDE_0', false); // set this one to true to hide special ranks not used

	// system
	define('POST_RANK_URL', 'rank');
	define('RANKS_CONSTANTS_DEFINED', true);
}

// normal entry
if ( !defined('IN_PHPBB') )
{
	define('IN_PHPBB', true);
	$phpbb_root_path = './';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include($phpbb_root_path . 'common.' . $phpEx);

	// Session management
	$userdata = session_pagestart($user_ip, PAGE_INDEX);
	init_userprefs($userdata);
}
// included from page_header.php
else if ( !defined('HEADER_INC') || !HEADER_INC )
{
	die('Hacking attempt !');
}

// get the lang file
$lang_file = $phpbb_root_path . 'language/lang_' . $board_config['default_language'] . '/lang_ranks.' . $phpEx;
if ( ($file = phpbb_realpath($lang_file)) && file_exists($file) )
{
	include($lang_file);
}
// lang file is missing: hardcode in english
else
{
	$lang['Ranks'] = 'Ranks';
	$lang['Ranks_special'] = 'Special ranks';
	$lang['No_ranks'] = 'There are no ranks defined.';
	$lang['Rank_minimum'] = 'Posts';
	$lang['Total_users'] = 'Users';
	$lang['No_ranks_regular'] = 'There are no automatic ranks defined.';
	$lang['No_ranks_special'] = 'There are no special ranks defined.';
	$lang['Rank_view'] = 'View';
	$lang['Rank_no_users'] = 'There are no users for this rank.';
}

// part active when included from page_header.php
if ( defined('HEADER_INC') && HEADER_INC )
{
	// if logged or if we have allowed guests
	if ( (defined('RANKS_GUESTS_ACCESS') && RANKS_GUESTS_ACCESS) || $userdata['session_logged_in'] )
	{
		// menu legend
		$template->assign_vars(array(
			'U_RANKS' => append_sid('ranks.' . $phpEx),
			'L_RANKS' => $lang['Ranks'],
		));
		$template->assign_block_vars('ranks', array());
	}
	// back to page_header.php
	return;
}

// only registered members have access ?
if ( (!defined('RANKS_GUESTS_ACCESS') || !RANKS_GUESTS_ACCESS) && !$userdata['session_logged_in'] )
{
	redirect(append_sid('login.' . $phpEx . '?redirect=ranks.' . $phpEx, true));
	exit;
}

// get all parms
$sorts = array(
	'posts' => array('user_posts', 'Sort_Posts'),
	'joined' => array('user_regdate', 'Sort_Joined'),
	'username' => array('username', 'Sort_Username'),
	'location' => array('user_loc', 'Sort_Location'),
	'email' => array('user_email', 'Sort_Email'),
	'website' => array('user_website', 'Sort_Website'),
);
$orders = array(
	'ASC' => array('', 'Sort_Ascending'),
	'DESC' => array(' DESC', 'Sort_Descending'),
);
if ( isset($board_config['board_email_form']) && intval($board_config['board_email_form']) )
{
	unset($sorts['email']);
}

$start = isset($HTTP_GET_VARS['start']) ? intval($HTTP_GET_VARS['start']) : (isset($HTTP_POST_VARS['start']) ? intval($HTTP_POST_VARS['start']) : false);
$ppage = isset($HTTP_GET_VARS['ppage']) ? intval($HTTP_GET_VARS['ppage']) : (isset($HTTP_POST_VARS['ppage']) ? intval($HTTP_POST_VARS['ppage']) : false);
$rank_id = isset($HTTP_GET_VARS[POST_RANK_URL]) ? intval($HTTP_GET_VARS[POST_RANK_URL]) : (isset($HTTP_POST_VARS[POST_RANK_URL]) ? intval($HTTP_POST_VARS[POST_RANK_URL]) : false);
$sort = isset($HTTP_GET_VARS['sort']) ? htmlspecialchars($HTTP_GET_VARS['sort']) : (isset($HTTP_POST_VARS['sort']) ? htmlspecialchars($HTTP_POST_VARS['sort']) : false);
$order = isset($HTTP_GET_VARS['order']) ? htmlspecialchars($HTTP_GET_VARS['order']) : (isset($HTTP_POST_VARS['order']) ? htmlspecialchars($HTTP_POST_VARS['order']) : false);
if ( $sort !== false )
{
	if ( !isset($sorts[$sort]) )
	{
		$sort = false;
		$order = false;
	}
}
if ( $order !== false )
{
	if ( !isset($orders[$order]) )
	{
		$sort = false;
		$order = false;
	}
}

// default values
$dft_ppage = isset($board_config['topics_per_page']) && intval($board_config['topics_per_page']) ? $board_config['topics_per_page'] : 50;
$dft_sort_order = array('posts', 'DESC');
$dft_order = 'ASC';

// adjust values to default
if ( ($start === false) || ($start < 0) )
{
	$start = 0;
}
if ( ($ppage === false) || ($ppage <= 10) || ($ppage > $dft_ppage) )
{
	$ppage = $dft_ppage;
}
if ( $sort === false )
{
	list($sort, $order) = $dft_sort_order;
}
if ( $order === false )
{
	$order = $dft_order;
}

// we only process parms if we have a rank id
$parms = !$rank_id ? array() : array(
	POST_RANK_URL => $rank_id,
	'start' => $start,
	'ppage' => $ppage,
	'sort' => $sort,
	'order' => $order,
);
unset($rank_id);
unset($start);
unset($ppage);
unset($sort);
unset($order);
$s_hidden_fields = '';

// counts & sums
$counts = array(0 => 0, 1 => 0);
$totals = array(0 => 0, 1 => 0, 2 => 0);

// read all ranks (regulars/specials)
$ranks = array(0 => array(), 1 => array());
$sql = 'SELECT *
			FROM ' . RANKS_TABLE . '
			ORDER BY rank_special, rank_min DESC';
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t read ranks', '', __LINE__, __FILE__, $sql);
}
while ( ($row = $db->sql_fetchrow($result)) )
{
	$row['count_users'] = 0;
	$row['rank_image'] = trim($row['rank_image']);
	$row['rank_title'] = trim($row['rank_title']);
	$key = $row['rank_special'] ? 1 : 0;
	$ranks[$key][ intval($row['rank_id']) ] = $row;
}
$db->sql_freeresult($result);

// end there if no ranks
$counts[0] = count($ranks[0]);
$counts[1] = count($ranks[1]);
if ( !$counts[0] && !$counts[1] )
{
	message_die(GENERAL_MESSAGE, 'No_ranks');
}

// first build the ranks count selection
$sql_where = array();
if ( $counts[0] )
{
	$sql_where[] = '(r.rank_special <> 1 AND u.user_rank = 0 AND u.user_posts >= r.rank_min)';
}
if ( $counts[1] )
{
	$sql_where[] = '(r.rank_special = 1 AND u.user_rank = r.rank_id)';
}

// then query the database
$sql = 'SELECT r.rank_id, COUNT(u.user_id) AS count_user_id
			FROM ' . RANKS_TABLE . ' r, ' . USERS_TABLE . ' u
			WHERE u.user_active = 1
				AND (' . implode(' OR ', $sql_where) . ')
			GROUP BY r.rank_id';
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t read ranks count', '', __LINE__, __FILE__, $sql);
}
while ( ($row = $db->sql_fetchrow($result)) )
{
	$key = isset($ranks[1][ intval($row['rank_id']) ]) ? 1 : 0;
	$ranks[$key][ intval($row['rank_id']) ]['count_users'] = intval($row['count_user_id']);
	if ( $key )
	{
		$totals[$key] += $ranks[$key][ intval($row['rank_id']) ]['count_users'];
	}
}
$db->sql_freeresult($result);

// remove special ranks un-used if required
if ( defined('RANKS_SPE_HIDE_0') && RANKS_SPE_HIDE_0 && $counts[1] )
{
	foreach ( $ranks[1] as $id => $dummy )
	{
		if ( !$ranks[1][$id]['count_users'] )
		{
			unset($ranks[1][$id]);
			$counts[1]--;
		}
	}
}

// and finaly process the count for regular ranks
if ( $counts[0] )
{
	$rank_max = -1;
	$count_users = 0;
	foreach ( $ranks[0] as $id => $dummy )
	{
		// remove ranks not reached if required
		if ( defined('RANKS_REG_HIDE_0') && RANKS_REG_HIDE_0 && !$count_users && !$ranks[0][$id]['count_users'] )
		{
			unset($ranks[0][$id]);
			$counts[0]--;
			continue;
		}

		$ranks[0][$id]['rank_max'] = $rank_max;
		$rank_max = $ranks[0][$id]['rank_min'];

		$prev = $ranks[0][$id]['count_users'];
		$ranks[0][$id]['count_users'] -= $count_users;
		$count_users = $prev;
		$totals[0] += $ranks[0][$id]['count_users'];
	}
}

// default order: regulars, specials
$keys = array(0, 1);

// maybe we received a rank to display ?
$sql_where = '';
if ( $parms && $parms[POST_RANK_URL] )
{
	$rank_id = $parms[POST_RANK_URL];
	$key = isset($ranks[0][$rank_id]) ? 0 : (isset($ranks[1][$rank_id]) ? 1 : false);
	if ( ($key === false) || !$ranks[$key][$rank_id]['count_users'] )
	{
		$rank_id = false;
	}
	if ( $rank_id )
	{
		$keys = $key ? array(1, 2, 0) : array(0, 2, 1);
	}
	else
	{
		$parms = array();
	}
}

// display
$count_keys = count($keys);
for ( $i = 0; $i < $count_keys; $i++ )
{
	$key = $keys[$i];
	$template->assign_block_vars('block', array());
	switch ( $key )
	{
		case 2:
			$rank_id = intval($parms[POST_RANK_URL]);
			$template->assign_block_vars('title', array(
				'L_RANK' => isset($ranks[1][$rank_id]) ? $ranks[1][$rank_id]['rank_title'] : $ranks[0][$rank_id]['rank_title'],
			));
			$template->assign_block_vars('block.members', array());

			// build selection lists
			foreach ( $sorts as $sort => $def )
			{
				$template->assign_block_vars('block.members.sort', array(
					'VALUE' => $sort,
					'L_OPTION' => $lang[ $def[1] ],
					'S_SELECTED' => $sort == $parms['sort'] ? ' selected="selected"' : '',
				));
			}
			foreach ( $orders as $order => $def )
			{
				$template->assign_block_vars('block.members.order', array(
					'VALUE' => $order,
					'L_OPTION' => $lang[ $def[1] ],
					'S_SELECTED' => $order == $parms['order'] ? ' selected="selected"' : '',
				));
			}
			$s_hidden_fields = '<input type="hidden" name="' . POST_RANK_URL . '" value="' . intval($rank_id) . '" />';

			// prepare the requests
			$sql_where = isset($ranks[1][$rank_id]) ? 'user_rank = ' . intval($rank_id) : ($ranks[0][$rank_id]['rank_max'] > 0 ? 'user_rank = 0 AND user_posts BETWEEN ' . implode(' AND ', array(intval($ranks[0][$rank_id]['rank_min']), intval($ranks[0][$rank_id]['rank_max']) - 1)) : 'user_rank = 0 AND user_posts >= ' . intval($ranks[0][$rank_id]['rank_min']));
			$sql_order = $sorts[ $parms['sort'] ][0] . $orders[ $parms['order'] ][0];
			$sql_limits = $parms['start'] ? array($parms['start'], $parms['ppage']) : array($parms['ppage']);

			// get users count
			$sql = 'SELECT COUNT(user_id) as count_user_id
						FROM ' . USERS_TABLE . '
						WHERE user_active = 1
							AND ' . $sql_where;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t read users count with the selected rank', '', __LINE__, __FILE__, $sql);
			}
			$totals[2] = ($row = $db->sql_fetchrow($result)) ? intval($row['count_user_id']) : 0;
			$db->sql_freeresult($result);
			$done = false;

			// get & display details
			if ( $totals[2] )
			{
				$sql = 'SELECT *
							FROM ' . USERS_TABLE . '
							WHERE user_active = 1
								AND ' . $sql_where . '
							ORDER BY ' . $sql_order . '
							LIMIT ' . implode(', ', $sql_limits);
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Couldn\'t read users with the selected rank', '', __LINE__, __FILE__, $sql);
				}
				$count = 0;
				$color = false;
				while ( ($row = $db->sql_fetchrow($result)) )
				{
					$done = true;

					// borrowed to memberlist.php
					$username = $row['username'];
					$user_id = $row['user_id'];

					$from = ( !empty($row['user_from']) ) ? $row['user_from'] : '&nbsp;';
					$joined = create_date($lang['DATE_FORMAT'], $row['user_regdate'], $board_config['board_timezone']);
					$posts = ( $row['user_posts'] ) ? $row['user_posts'] : 0;

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

					if ( !empty($row['user_viewemail']) || $userdata['user_level'] == ADMIN )
					{
						$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $user_id) : 'mailto:' . $row['user_email'];

						$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
						$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
					}
					else
					{
						$email_img = '&nbsp;';
						$email = '&nbsp;';
					}

					$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id");
					$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
					$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

					$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$user_id");
					$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
					$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

					$www_img = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
					$www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

					if ( !empty($row['user_icq']) )
					{
						$icq_status_img = '<a href="http://wwp.icq.com/' . $row['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $row['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
						$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
						$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '">' . $lang['ICQ'] . '</a>';
					}
					else
					{
						$icq_status_img = '';
						$icq_img = '';
						$icq = '';
					}

					$aim_img = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
					$aim = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

					$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id");
					$msn_img = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
					$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

					$yim_img = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
					$yim = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

					$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($username) . "&amp;showresults=posts");
					$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $username) . '" title="' . sprintf($lang['Search_user_posts'], $username) . '" border="0" /></a>';
					$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $username) . '</a>';

					$row_color = $count % 2 ? $theme['td_color2'] : $theme['td_color1'];
					$row_class = $count % 2 ? $theme['td_class2'] : $theme['td_class1'];

					$template->assign_block_vars('block.members.row', array(
						'ROW_NUMBER' => $count + $parms['start'] + 1,
						'ROW_COLOR' => '#' . $row_color,
						'ROW_CLASS' => $row_class,
						'USERNAME' => $username,
						'FROM' => $from,
						'JOINED' => $joined,
						'POSTS' => $posts,
						'AVATAR_IMG' => $poster_avatar,
						'PROFILE_IMG' => $profile_img,
						'PROFILE' => $profile,
						'SEARCH_IMG' => $search_img,
						'SEARCH' => $search,
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

						'U_VIEWPROFILE' => append_sid('profile' . '.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . intval($row['user_id'])),
					));
					$count++;
					$color = !$color;
					$template->assign_block_vars('block.members.row.light' . ($color ? '' : '_ELSE'), array());
				}
				$db->sql_freeresult($result);
			}
			if ( !$done )
			{
			}
			break;
		case 0:
		case 1:
			$nest = $count_keys == 3 ? 'block.ranks_short' : 'block.ranks';
			$template->assign_block_vars($nest, array(
				'L_RANKS' => $key ? $lang['Ranks_special'] : $lang['Ranks'],
				'TOTAL' => $totals[$key] ? $totals[$key] : '&nbsp;',
				'L_EMPTY_RANKS' => $key ? $lang['No_ranks_special'] : $lang['No_ranks_regular'],
			));
			$template->assign_block_vars($nest . '.edge' . ($key ? '_ELSE' : ''), array());
			$done = false;
			$color = false;
			foreach ( $ranks[$key] as $id => $row )
			{
				$done = true;
				$percent = max(0, min(100, round(($row['count_users'] * 100.0) / max(1, $totals[$key]))));
				$template->assign_block_vars($nest . '.row', array(
					'U_RANK' => append_sid('ranks.' . $phpEx . '?' . POST_RANK_URL . '=' . intval($id)),
					'L_RANK' => $row['rank_title'],
					'I_RANK' => $row['rank_image'],
					'MINI'  => $row['rank_min'],
					'TOTAL' => $row['count_users'],
					'PERCENT' => $percent,
					'PERCENT_DRAW' => max(1, $percent),
				));
				$template->assign_block_vars($nest . '.row.image' . ($row['rank_image'] ? '' : '_ELSE'), array());
				$template->assign_block_vars($nest . '.row.view' . ($row['count_users'] ? '' : '_ELSE'), array());
				$template->assign_block_vars($nest . '.row.edge' . ($key ? '_ELSE' : ''), array());

				$color = !$color;
				$template->assign_block_vars($nest . '.row.light' . ($color ? '' : '_ELSE'), array());
			}
			if ( !$done )
			{
				$template->assign_block_vars($nest . '.row_ELSE', array());
				$template->assign_block_vars($nest . '.row_ELSE.edge' . ($key ? '_ELSE' : ''), array());
			}
			break;
	}
}

// pagination
if ( ($count_keys == 3) && $totals[2] )
{
	$start = $parms['start'];
	unset($parms['start']);
	$ppage = $parms['ppage'];
	if ( $ppage == $dft_ppage )
	{
		unset($parms['ppage']);
	}
	$sort = $parms['sort'];
	$order = $parms['order'];
	if ( array($sort, $order) == $dft_sort_order )
	{
		unset($parms['sort']);
		unset($parms['order']);
	}
	if ( $order == $dft_order )
	{
		unset($parms['order']);
	}
	$solved = array();
	if ( !empty($parms) )
	{
		foreach ( $parms as $key => $value )
		{
			$solved[] = $key . '=' . $value;
		}
	}
	$pagination = generate_pagination('ranks.' . $phpEx . (empty($solved) ? '' : '?' . implode('&amp;', $solved)), $totals[2], $ppage, $start);
	$template->assign_block_vars('pagination', array(
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], floor($start / $ppage) + 1, ceil($totals[2] / $ppage)),
		'L_GOTO_PAGE' => $lang['Goto_page'],
	));
}

// legend
$template->assign_vars(array(
	'U_RANKS' => append_sid('ranks.' . $phpEx),
	'L_RANKS' => $lang['Ranks'],
	'L_RANK_VIEW' => $lang['Rank_view'],
	'L_RANK_VIEW_LONG' => $lang['Memberlist'],
	'L_MINI' => $lang['Rank_minimum'],
	'L_COUNT' => $lang['Total_users'],

	'L_EMAIL' => $lang['Email'],
	'L_WEBSITE' => $lang['Website'],
	'L_FROM' => $lang['Location'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],
	'L_SUBMIT' => $lang['Sort'],
	'L_AIM' => $lang['AIM'],
	'L_YIM' => $lang['YIM'],
	'L_MSNM' => $lang['MSNM'],
	'L_ICQ' => $lang['ICQ'],
	'L_JOINED' => $lang['Joined'],
	'L_POSTS' => $lang['Posts'],
	'L_PM' => $lang['Private_Message'],
	'L_EMPTY_USERS' => $lang['Rank_no_users'],

	'L_SORT' => $lang['Sort_by'],
	'L_GO' => $lang['Go'],
	'S_ACTION' => append_sid($phpbb_root_path . 'ranks.' . $phpEx),
	'S_HIDDEN_FIELDS' => $s_hidden_fields,
));

// display page
$page_title = $lang['Ranks'];
include ($phpbb_root_path . 'includes/page_header.' . $phpEx);
$template->set_filenames(array('body' => 'ranks_body.tpl'));
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.' . $phpEx);

?>