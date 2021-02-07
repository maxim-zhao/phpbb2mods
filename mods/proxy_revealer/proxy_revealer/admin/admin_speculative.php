<?php
/***************************************************************************
 *                              admin_speculative.php
 *                            -------------------
 *   begin                : Tuesday, Aug 18, 2006
 *   copyright            : (C) MMVI TerraFrost
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

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Speculative_IPs'] = $file;

	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Set mode
//
if( isset( $HTTP_POST_VARS['mode'] ) || isset( $HTTP_GET_VARS['mode'] ) )
{
	$mode = ( isset( $HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = '';
}

switch ($mode)
{
	case 'java':
		$spoofed_ip = $HTTP_GET_VARS['spoofed'];
		$real_ip = $HTTP_GET_VARS['real'];
		$method = intval($HTTP_GET_VARS['method']);

		if ($method != JAVA && $method != JAVA_INTERNAL)
		{
			message_die(GENERAL_MESSAGE, $lang['No_mode']);
		}

		// there should only be one response.
		$sql = "SELECT * FROM " . SPECULATIVE_TABLE . " 
			WHERE method = $method 
				AND ip_address = '" . str_replace("\'","''",$spoofed_ip) . "' 
				AND real_ip = '" . str_replace("\'","''",$real_ip) . "'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR,'Unable to load Java debug information.','',__LINE__,__FILE__,$sql);
		}

		$row = $db->sql_fetchrow($result);

		$info = explode('<>', $row['info']);
		$java_glue = '';
		if (!empty($info[1]))
		{
			$java_glue = '<br />';
			$java_version = $info[1];
		}
		$java_version = (!empty($info[2])) ? $java_version . $java_glue . $info[2] : $java_version;

		$template->assign_vars(array(
			'USER_AGENT' => $info[0],
			'JAVA_VERSION' => $java_version,

			'L_SPECULATIVE' => $lang['Speculative_IPs'],
			'L_JAVA_DESC' => $lang['Speculative_IP_Java'],
			'L_USER_AGENT' => $lang['User-Agent'],
			'L_JAVA_VERSION' => $lang['Java_Version'],
			'L_RETURN' => sprintf($lang['Return'], '<a href="#" onclick="history.go(-1); return false">', '</a>'))
		);

		$template->set_filenames(array(
			'body' => 'admin/speculative_java_body.tpl')
		);

		$template->pparse("body");

		include('./page_footer_admin.'.$phpEx);
	case 'except':
		//
		// Adapted from admin_user_ban.php
		//
		$sql = "SELECT ip_address 
			FROM " . SPECULATIVE_EXCLUDE_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select current ip list', '', __LINE__, __FILE__, $sql);
		}

		$current_ip_list = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		if ( isset($HTTP_POST_VARS['submit']) )
		{
			$ip_bansql = '';

			$ip_list = array();
			if ( isset($HTTP_POST_VARS['add_ip']) )
			{
				$ip_list_temp = explode(',', $HTTP_POST_VARS['add_ip']);

				for($i = 0; $i < count($ip_list_temp); $i++)
				{
					if ( preg_match('/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})[ ]*\-[ ]*([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/', trim($ip_list_temp[$i]), $ip_range_explode) )
					{
						//
						// Don't ask about all this, just don't ask ... !
						//
						$ip_1_counter = $ip_range_explode[1];
						$ip_1_end = $ip_range_explode[5];

						while ( $ip_1_counter <= $ip_1_end )
						{
							$ip_2_counter = ( $ip_1_counter == $ip_range_explode[1] ) ? $ip_range_explode[2] : 0;
							$ip_2_end = ( $ip_1_counter < $ip_1_end ) ? 254 : $ip_range_explode[6];

							if ( $ip_2_counter == 0 && $ip_2_end == 254 )
							{
								$ip_2_counter = 255;
								$ip_2_fragment = 255;

								$ip_list[] = encode_ip("$ip_1_counter.255.255.255");
							}

							while ( $ip_2_counter <= $ip_2_end )
							{
								$ip_3_counter = ( $ip_2_counter == $ip_range_explode[2] && $ip_1_counter == $ip_range_explode[1] ) ? $ip_range_explode[3] : 0;
								$ip_3_end = ( $ip_2_counter < $ip_2_end || $ip_1_counter < $ip_1_end ) ? 254 : $ip_range_explode[7];

								if ( $ip_3_counter == 0 && $ip_3_end == 254 )
								{
									$ip_3_counter = 255;
									$ip_3_fragment = 255;

									$ip_list[] = encode_ip("$ip_1_counter.$ip_2_counter.255.255");
								}

								while ( $ip_3_counter <= $ip_3_end )
								{
									$ip_4_counter = ( $ip_3_counter == $ip_range_explode[3] && $ip_2_counter == $ip_range_explode[2] && $ip_1_counter == $ip_range_explode[1] ) ? $ip_range_explode[4] : 0;
									$ip_4_end = ( $ip_3_counter < $ip_3_end || $ip_2_counter < $ip_2_end ) ? 254 : $ip_range_explode[8];

									if ( $ip_4_counter == 0 && $ip_4_end == 254 )
									{
										$ip_4_counter = 255;
										$ip_4_fragment = 255;

										$ip_list[] = encode_ip("$ip_1_counter.$ip_2_counter.$ip_3_counter.255");
									}

									while ( $ip_4_counter <= $ip_4_end )
									{
										$ip_list[] = encode_ip("$ip_1_counter.$ip_2_counter.$ip_3_counter.$ip_4_counter");
										$ip_4_counter++;
									}
									$ip_3_counter++;
								}
								$ip_2_counter++;
							}
							$ip_1_counter++;
						}
					}
					else if ( preg_match('/^([\w\-_]\.?){2,}$/is', trim($ip_list_temp[$i])) )
					{
						$ip = gethostbynamel(trim($ip_list_temp[$i]));

						for($j = 0; $j < count($ip); $j++)
						{
							if ( !empty($ip[$j]) )
							{
								$ip_list[] = encode_ip($ip[$j]);
							}
						}
					}
					else if ( preg_match('/^([0-9]{1,3})\.([0-9\*]{1,3})\.([0-9\*]{1,3})\.([0-9\*]{1,3})$/', trim($ip_list_temp[$i])) )
					{
						$ip_list[] = encode_ip(str_replace('*', '255', trim($ip_list_temp[$i])));
					}
				}
			}

			for($i = 0; $i < count($ip_list); $i++)
			{
				$in_list = false;
				for($j = 0; $j < count($current_ip_list); $j++)
				{
					if ( $ip_list[$i] == $current_ip_list[$j]['ip_address'] )
					{
						$in_list = true;
						break;
					}
				}

				if ( !$in_list )
				{
					$sql = "INSERT INTO " . SPECULATIVE_EXCLUDE_TABLE . " (ip_address) 
						VALUES ('" . $ip_list[$i] . "')";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Couldn't insert ip_address info into database", "", __LINE__, __FILE__, $sql);
					}
				}
			}

			if ( isset($HTTP_POST_VARS['remove_ip']) )
			{
				$ip_list = $HTTP_POST_VARS['remove_ip'];

				for($i = 0; $i < count($ip_list); $i++)
				{
					if ( !empty($ip_list[$i]) )
					{
						$where_sql .= ( ( $where_sql != '' ) ? ', ' : '' ) . "'" . str_replace("\'", "''", $ip_list[$i]) . "'";
					}
				}
			}

			if ( $where_sql != '' )
			{
				$sql = "DELETE FROM " . SPECULATIVE_EXCLUDE_TABLE . "
					WHERE ip_address IN ($where_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't delete IP address info from database", "", __LINE__, __FILE__, $sql);
				}
			}

			$message = $lang['Except_update_sucessful'] . '<br /><br />' . sprintf($lang['Click_return_prevpage'], '<a href="' . append_sid("admin_speculative.$phpEx?mode=except") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}

		$select_iplist = '';

		for ($i = 0; $i < count($current_ip_list); $i++)
		{
			$ip_address = str_replace('255', '*', decode_ip($current_ip_list[$i]['ip_address']));
			$select_iplist .= '<option value="' . $current_ip_list[$i]['ip_address'] . '">' . $ip_address . '</option>';
		}

		if ( empty($select_iplist) )
		{
			$select_iplist = '<option value="">' . $lang['No_ip'] . '</option>';
		}

		$select_iplist = '<select name="remove_ip[]" multiple="multiple" size="5">' . $select_iplist . '</select>';

		$template->assign_vars(array(
			'S_EXCLUDE_ACTION' => append_sid("admin_speculative.$phpEx?mode=except"),
			'S_REMOVE_IPLIST_SELECT' => $select_iplist,

			'L_SPECULATIVE' => $lang['Speculative_IPs'],
			'L_EXCLUDE_DESC' => $lang['Speculative_IP_Exclude'],
			'L_RETURN' => sprintf($lang['Return'], '<a href="' . append_sid("admin_speculative.$phpEx") . '">', '</a>'),
			'L_IP_OR_HOSTNAME' => $lang['IP_hostname'],
			'L_REMOVE_IP' => $lang['Remove_IP'],
			'L_REMOVE_IP_EXPLAIN' => $lang['Remove_IP_explain'],
			'L_ADD_IP' => $lang['Add_IP'],
			'L_ADD_IP_EXPLAIN' => $lang['Add_IP_explain'],
			'L_SUBMIT' => $lang['Submit'],
			'L_RESET' => $lang['Reset'])
		);

		$template->set_filenames(array(
			'body' => 'admin/speculative_exclude_body.tpl')
		);

		$template->pparse("body");

		include('./page_footer_admin.'.$phpEx);		
}

// get starting position
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

// get show amount
if ( isset($HTTP_GET_VARS['show']) || isset($HTTP_POST_VARS['show']) )
{
	$show = ( isset($HTTP_POST_VARS['show']) ) ? intval($HTTP_POST_VARS['show']) : intval($HTTP_GET_VARS['show']);
}
else
{
	$show = $board_config['posts_per_page'];
}

// sort order
if( isset($HTTP_POST_VARS['order']) )
{
	$sort_order = ( $HTTP_POST_VARS['order'] == 'ASC' ) ? 'ASC' : 'DESC';
}
else if( isset($HTTP_GET_VARS['order']) )
{
	$sort_order = ( $HTTP_GET_VARS['order'] == 'ASC' ) ? 'ASC' : 'DESC';
}
else
{
	$sort_order = 'DESC';
}

if ($mode != 'internal')
{
	$mode = 'external';
}

$search_ip = '';
$where_sql = ($mode == 'internal') ? 'WHERE method = ' . JAVA_INTERNAL : 'WHERE method <> ' . JAVA_INTERNAL;
if( !empty($HTTP_POST_VARS['ip']) || !empty($HTTP_GET_VARS['ip']) )
{
	$search_ip = !empty($HTTP_POST_VARS['ip']) ? $HTTP_POST_VARS['ip'] : $HTTP_GET_VARS['ip'];
	$where_sql.= " AND ip_address = '".encode_ip($search_ip)."'";
}

$sql = "SELECT * FROM " . SPECULATIVE_TABLE . " 
	$where_sql 
	ORDER BY discovered $sort_order LIMIT $start, $show";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR,'Unable to load recently spoofed IP addresses.','',__LINE__,__FILE__,$sql);
}

$i = 0;
while ( $row = $db->sql_fetchrow($result) )
{
	$ip_address = decode_ip($row['ip_address']);

	switch ( $row['method'] )
	{
		case JAVA:
		case JAVA_INTERNAL:
			$method = '<a href="'.append_sid("admin_speculative.$phpEx?mode=java&amp;spoofed=$row[ip_address]&amp;real=$row[real_ip]&amp;method=$row[method]").'">'.$lang['Java'].'</a>';
			break;
		case X_FORWARDED_FOR:
			$method = $lang['X-Forwarded-For'];
			break;
		case XSS:
			$urls = explode('<>', $row['info']);
			$count = count($urls);
			switch (true)
			{
				case !$count:
					$method = $lang['XSS'];
					break;
				case $count == 1 || empty($urls[1]):
					$method =  !empty($urls[0]) ? '<a href="'.$urls[0].'">'.$lang['XSS'].'</a>' : $lang['XSS'];
					break;
				case $count == 2: // eg. default; there can be up to two url's in $urls.  if there is, represent the link to the second one with a *
					$method =  !empty($urls[0]) ? '<a href="'.$urls[0].'">'.$lang['XSS'].'</a>' : $lang['XSS'];
					$method.= !empty($urls[1]) ? ' <a href="'.$urls[1].'">*</a>' : '';
			}
	}

	$template->assign_block_vars('speculativerow', array(
		'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
		'SPOOFED_IP' => $ip_address,
		'SPOOFED_LINK' => append_sid("admin_speculative.$phpEx?mode=$mode&amp;ip=$ip_address"),
		'METHOD' => $method,
		'REAL_IP' => ($mode == 'internal') ? $row['real_ip'] : preg_replace('#(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})#','<a href="http://network-tools.com/default.asp?host=$1">$1</a>' ,$row['real_ip']),
		'DATE' => create_date($board_config['default_dateformat'], $row['discovered'], $board_config['board_timezone']))
	);
	$i++;
}

$count_sql = "SELECT count(ip_address) AS total 
	FROM " . SPECULATIVE_TABLE . " 
	$where_sql";

if ( !($count_result = $db->sql_query($count_sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting totals from database', '', __LINE__, __FILE__, $sql);
}

if ( $total = $db->sql_fetchrow($count_result) )
{
	$total_addresses = $total['total'];

	$pagination = generate_pagination("admin_speculative.$phpEx?mode=$mode&amp;order=$sort_order&amp;show=$show", $total_addresses, $show, $start);
}

$speculative_desc = ($mode == 'internal') ? 
		sprintf($lang['Speculative_IP_internal'], '<a href="' . append_sid("admin_speculative.$phpEx?mode=external") . '">', '</a>') : 
		sprintf($lang['Speculative_IP_external'], '<a href="' . append_sid("admin_speculative.$phpEx?mode=internal") . '">', '</a>',
			'<a href="' . append_sid("admin_speculative.$phpEx?mode=except") . '">', '</a>');

$template->assign_vars(array(
	'S_LIST_ACTION' => append_sid("admin_speculative.$phpEx?mode=$mode"),

	'S_SHOW' => $show,
	'S_ASC' => ( $sort_order == 'ASC' ) ? ' selected="selected"' : '',
	'S_DESC' => ( $sort_order == 'DESC' ) ? ' selected="selected"' : '',
	'S_SORT' => $lang['Sort'],

	'L_SEARCH_FOR' => $lang['Search_For'],
	'L_SUBMIT' => $lang['Submit'],
	'L_SORT_BY' => $lang['Sort_by'],
	'L_MOST_RECENTLY' => $lang['Most_Recent'],
	'L_LEAST_RECENTLY' => $lang['Least_Recent'],
	'L_SHOW' => $lang['Show'],
	'L_SPECULATIVE' => $lang['Speculative_IPs'],
	'L_SPECULATIVE_DESC' => $speculative_desc,
	'L_SPOOFED' => ($mode == 'internal') ? $lang['External_IP'] : $lang['Spoofed_IP'],
	'L_METHOD' => $lang['Method_Used'],
	'L_REAL' => ($mode == 'internal') ? $lang['Internal_IP'] : $lang['Real_IP'],
	'L_METHOD_DESC' => $lang['Method_Used_explain'],
	'L_REAL_DESC' => $lang['Real_IP_explain'],
	'L_DATE' => $lang['Date'],
	'L_VIEW_LIST' => $lang['View_List'],

	'SEARCH' => $search_ip,
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $show ) + 1 ), ceil( $total_addresses / $show )))
);

$template->set_filenames(array(
	'body' => 'admin/speculative_body.tpl')
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>