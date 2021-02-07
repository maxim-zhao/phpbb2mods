<?php
/***************************************************************************
 *                              admin_proxy.php
 *                            -------------------
 *   begin                : Tuesday, Jul 5, 2005
 *   copyright            : (C) MMV TerraFrost
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
	$file = basename(__FILE__);
	$module['General']['proxy_name'] = $file;

	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
$no_page_header = true;
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

switch ( $mode )
{
	case 'test':
		if( isset( $HTTP_GET_VARS['address']) || isset( $HTTP_POST_VARS['address']) )
		{
			$ip_address = ( isset( $HTTP_POST_VARS['address']) ) ? $HTTP_POST_VARS['address'] : $HTTP_GET_VARS['address'];
		}
		else
		{
			message_die(GENERAL_ERROR,'No IP address specified');
		}

		include_once($phpbb_root_path."includes/functions_proxy.$phpEx");
		$proxy = new proxy(PROXY_HTTP_MODE);
		$proxy->init($ip_address);
		$proxy->test();
		$debug_display = '';
		if ( $proxy->wait() )
		{
			// update the database so that the MOD can be enabled / disabled via the ACP.
			$debug_display = 'none';
			$sql = "UPDATE " . CONFIG_TABLE . " SET 
				config_value = 0 
				WHERE config_name = 'proxy_enable' AND config_value = 2";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for proxy_enable", "", __LINE__, __FILE__, $sql);
			}

		}
		$debug_display = (!$proxy->wait()) ? '' : 'none';
		$proxy->block();
		$elapsed_time = $proxy->elapsed_time();

		$test_results = sprintf($lang['proxy_testing'],htmlspecialchars($ip_address)).'<br />';
		$test_results .= sprintf($lang['proxy_hostname'],gethostbyaddr($ip_address)).'<br />';
		$test_results .= ' <br />'.$proxy->messages['result'];

		// if (true) is serving as a place holder for features yet to come (features that are, incidently, hinted at in the next comment)...
		// if ($board_config['proxy_mode'] == PROXY_HTTP_MODE)
		if (true)
		{
			if ($proxy->messages['http_status'] != 200)
			{
				$proxy->messages['http2'] .= '<br /> <br /><b style="color: green">'.$lang['proxy_suggestions'].':</b> '.$lang['proxy_error'.$proxy->messages['http_status']];
			}
			$template->assign_block_vars('http_debug', array(
				"L_HTTP_QUERY_1" => $lang['proxy_sample_http_1'],
				"L_HTTP_QUERY_2" => $lang['proxy_sample_http_2'],
				"L_SQL_QUERY" => $lang['proxy_sample_sql'],

				"S_HTTP_QUERY_1" => $proxy->messages['http1'],
				"S_HTTP_QUERY_2" => $proxy->messages['http2'],
				"S_SQL_QUERY" => $proxy->messages['sql'])
			);
		}

		$template->set_filenames(array(
			"body" => "admin/proxy_test_body.tpl")
		);

		$template->assign_vars(array(
			"L_TITLE" => $lang['proxy_title'], 
			"L_DESC" => $lang['proxy_desc_test'], 
			"L_TEST" => $lang['proxy_test'],
			"L_ELAPSED_TIME" => $lang['proxy_exec_time'],
			"L_DEBUG" => $lang['proxy_debug'],
			"L_RETURN" => sprintf($lang['proxy_return'], '<a href="#" onclick="history.go(-1); return false">', '</a>'),

			"S_DEBUG_DISPLAY" => $debug_display,
			"S_ELAPSED_TIME" => sprintf('%.2fms',$elapsed_time),
			"TEST" => $test_results)
		);

		break;
	case 'download':
		$sql = "SELECT * FROM " . PROXY_TABLE . "  
			WHERE behavior >= " . PROXY_TRANSPARE . " AND behavior <> " . PROXY_ERROR . " 
			ORDER BY last_checked DESC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR,'Unable to load recently used proxies',__FILE__,__LINE__,$sql);
		}
		header("Pragma: no-cache");
		header("Content-Type: text/x-delimtext; name=\"addresses.txt\"");
		header("Content-disposition: attachment; filename=addresses.txt");
		if ( $row = $db->sql_fetchrow($result) )
		{
			do
			{
				echo decode_ip($row['ip_address']).':'.hexdec($row['port'])."\r\n";
			}
			while ( $row = $db->sql_fetchrow($result) );
		}
		exit;
	case 'delete':
		if( isset( $HTTP_GET_VARS['address']) || isset( $HTTP_POST_VARS['address']) )
		{
			$decoded_ip = ( isset( $HTTP_POST_VARS['address']) ) ? $HTTP_POST_VARS['address'] : $HTTP_GET_VARS['address'];
			$encoded_ip = encode_ip($decoded_ip);
		}
		else
		{
			message_die(GENERAL_ERROR,'No IP address specified');
		}

		$sql = "DELETE FROM " . PROXY_TABLE . " 
			WHERE ip_address = '$encoded_ip'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Unable to delete from proxy list', '', __LINE__, __FILE__, $sql);
		}

		$message = sprintf($lang['proxy_deleted'], $decoded_ip) . "<br /><br />" . sprintf($lang['proxy_return'],"<a href=\"" . append_sid("admin_proxy.$phpEx?mode=list") . "\">","</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	case 'list':

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

		list($temp_sort, $temp_sort_order) = explode(',',$board_config['proxy_sort']);

		// sort method
		if ( isset($HTTP_GET_VARS['sort']) || isset($HTTP_POST_VARS['sort']) )
		{
			$sort = ( isset($HTTP_POST_VARS['sort']) ) ? htmlspecialchars($HTTP_POST_VARS['sort']) : htmlspecialchars($HTTP_GET_VARS['sort']);
			$sort = str_replace("\'", "''", $sort);
		}
		else
		{
			$sort = $temp_sort;
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
			$sort_order = $temp_sort_order;
		}

		if ( $board_config['proxy_sort'] != "$sort,$sort_order" )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " 
				SET config_value = '$sort,$sort_order' 
				WHERE config_name = 'proxy_sort'";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR,'Unable to update proxy sort options');
			}
		}

		$sql = "SELECT * 
			FROM " . PROXY_TABLE . " 
			ORDER BY $sort $sort_order
			LIMIT $start, $show";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR,'Unable to load recently used proxies',__FILE__,__LINE__,$sql);
		}
		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				$ip_address = decode_ip($row['ip_address']);
				$port = hexdec($row['port']);
				$template->assign_block_vars('proxyrow', array(
					'ROW_NUMBER' => $i + ($start + 1),
					'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
					'IP_ADDRESS' => $ip_address,
					'IP_LINK' => "http://network-tools.com/default.asp?host=$ip_address",
					'PORT' => $port ? $port : '',
					'DATE' => create_date($board_config['default_dateformat'], $row['last_checked'], $board_config['board_timezone']),
					'TYPE' => $lang['proxy_t'.($row['behavior']-PROXY_TRANSPARE)],

					'U_CHECKPROXY' => append_sid("admin_proxy.$phpEx?mode=test&amp;address=$ip_address"),
					'U_DELPROXY' => append_sid("admin_proxy.$phpEx?mode=delete&amp;address=$ip_address"))
				);
				$i++;
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		$template->set_filenames(array(
			"body" => "admin/proxy_list_body.tpl")
		);

		$template->assign_vars(array(
			"S_LIST_ACTION" => append_sid("admin_proxy.$phpEx?mode=list"),
			"S_DOWNLOAD_ACTION" => append_sid("admin_proxy.$phpEx?mode=download"),

			'S_SHOW' => $show,
			'S_'.strtoupper($sort) => ' selected="selected"',
			'S_'.strtoupper($sort_order) => ' selected="selected"',

			"L_RETURN" => sprintf($lang['proxy_return'], '<a href="#" onclick="history.go(-1); return false">', '</a>'),

			"L_TITLE" => $lang['proxy_title'],
			"L_DESC" => $lang['proxy_desc_list'],
			'L_SORT_BY' => $lang['Sort_by'],
			'L_ASCENDING' => $lang['Sort_Ascending'],
			'L_DESCENDING' => $lang['Sort_Descending'],
			'L_SHOW' => $lang['proxy_show'],
			'S_SORT' => $lang['Sort'],
			"L_IP" => $lang['proxy_ip'],
			"L_CHECK" => $lang['proxy_check'],
			"L_DELETE" => $lang['Delete'],
			"L_DOWNLOAD" => $lang['proxy_download'],
			"L_VIEW_LIST" => $lang['proxy_view_list'],
			"L_PORT" => $lang['proxy_port'],
			"L_TYPE" => $lang['proxy_type'],
			"L_LAST_CHECKED" => $lang['proxy_last_checked'])
		);

		$count_sql = "SELECT count(ip_address) AS total 
			FROM " . PROXY_TABLE;

		if ( !($count_result = $db->sql_query($count_sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting totals from proxy list', '', __LINE__, __FILE__, $sql);
		}

		if ( $total = $db->sql_fetchrow($count_result) )
		{
			$total_addresses = $total['total'];

			$pagination = generate_pagination("admin_proxy.$phpEx?mode=list&amp;sort=$sort&amp;order=$sort_order&amp;show=$show", $total_addresses, $show, $start);
		}

		$template->assign_vars(array(
			'PAGINATION' => $pagination,
			'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $show ) + 1 ), ceil( $total_addresses / $show )))
		);

		break;
	default:
		//
		// Pull all config data
		//
		$sql = "SELECT *
			FROM " . CONFIG_TABLE . " 
			WHERE config_name LIKE 'proxy_%'";

		if(!$result = $db->sql_query($sql))
		{
			message_die(CRITICAL_ERROR, "Could not query config information in admin_proxy", "", __LINE__, __FILE__, $sql);
		}

		while( $row = $db->sql_fetchrow($result) )
		{
			$config_name = $row['config_name'];
			$config_value = $row['config_value'];
			$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;

			$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

			if ( isset($HTTP_POST_VARS['submit']) && $mode == 'settings' )
			{
				switch ($config_name)
				{
					case 'proxy_ports':
						// could use array_map with create_function...
						$temp = explode(',',preg_replace('/\s+/','',$new['proxy_ports']));
						$new['proxy_ports'] = '';
						for ($num=0;$num<count($temp);$num++)
						{
							$new['proxy_ports'] .= sprintf('%04x',$temp[$num]);
						}
						break;
					case 'proxy_cache_time':
						$new['proxy_cache_time'] = floor($new['proxy_cache_time']) * $HTTP_POST_VARS['proxy_cache_unit'];
						break;
					// could do this (and then remove a bunch of stripcslashes elsewhere), but then we'd have to use addcslashes, which is something I'd rather not do...
					//case 'proxy_user_agent':
					//	$new['proxy_user_agent'] = str_replace("\'","''",addslashes(stripcslashes($new['proxy_user_agent'])));
				}

				$sql = "UPDATE " . CONFIG_TABLE . " SET
					config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
					WHERE config_name = '$config_name'";
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
				}
			}
		}

		// if the proxy ports are changed, all proxies need to be changed.  as an example of why, say port 80 was the only port being scanned,
		// and then port 8080 was made the only port that was scanned.  then, none of the conclusions made about port 80 would necessarily
		// be true for port 8080.
		if ($new['proxy_ports'] != $board_config['proxy_ports'])
		{
			$sql = "UPDATE " . PROXY_TABLE . " SET 
				behavior = 99 
				WHERE behavior < " . PROXY_TRANSPARE;
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Unable to reset entries in proxy table.  Timeout errors may occur.", "", __LINE__, __FILE__, $sql);
			}
		}

		if( isset($HTTP_POST_VARS['submit']) && $mode == 'settings' )
		{
			$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['proxy_return'], '<a href="#" onclick="history.go(-1); return false">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}

		$enable_yes = ( $new['proxy_enable'] == 1 ) ? "checked=\"checked\"" : "";
		$enable_no = ( empty($enable_yes) ) ? "checked=\"checked\"" : "";
		$ban_yes = ( $new['proxy_ban'] ) ? "checked=\"checked\"" : "";
		$ban_no = ( !$new['proxy_ban'] ) ? "checked=\"checked\"" : "";
		$log_enable_yes = ( $new['proxy_log_enable'] ) ? "checked=\"checked\"" : "";
		$log_enable_no = ( !$new['proxy_log_enable'] ) ? "checked=\"checked\"" : "";
		$block_yes = ( $new['proxy_block'] ) ? "checked=\"checked\"" : "";
		$block_no = ( !$new['proxy_block'] ) ? "checked=\"checked\"" : "";

		// if the proxy hasn't been successfully tested, set everything to 2.  otherwise, set it to what it'd normally be.
		$enable_value = $disable_value = 2;
		if ( $new['proxy_enable'] != 2 )
		{
			$enable_value = 1;
			$disable_value = 0;
		}

		// could use the definition of $ports, as defined later, to define this, along with an extra implode, but this should be faster...
		$temp = '';
		do
		{
			$temp .= hexdec(substr($new['proxy_ports'],0,4)) . ', ';
			$new['proxy_ports'] = substr($new['proxy_ports'],4);
		}
		while (strlen($new['proxy_ports']) > 0);
		$new['proxy_ports'] = substr($temp,0,-2);

		// the following determines which units the cache time is to be displayed in.
		$unit_secs = array(1,60,3600,86400,604800,2592000,315360000);
		$unit_names = array($lang['proxy_seconds'],$lang['proxy_minutes'],$lang['proxy_hours'],$lang['proxy_days'],$lang['proxy_weeks'],$lang['proxy_months'],$lang['proxy_years']);

		for ($selected = count($unit_secs) - 1; $selected >= 0 && $new['proxy_cache_time'] % $unit_secs[$selected] != 0; $selected--);
		$select_unit = '<select name="proxy_cache_unit">';
		for ($i = 0; $i < count($unit_secs); $i++)
		{
			$temp = ($i == $selected) ? ' selected="selected"' : '';
			$select_unit .= '<option value="' . $unit_secs[$i] . '"' . $temp . '>' . $unit_names[$i] . '</option>';
		}
		$select_unit .= '</select>';

		$sql = "SELECT * FROM " . PROXY_TABLE . "  
			WHERE behavior >= " . PROXY_TRANSPARE . " AND behavior <> " . PROXY_ERROR . " 
			ORDER BY last_checked DESC LIMIT 3";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR,'Unable to load recently used proxies',__FILE__,__LINE__,$sql);
		}
		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				$ip_address = decode_ip($row['ip_address']);
				$template->assign_block_vars('proxyrow', array(
					'ROW_NUMBER' => $i + ($start + 1),
					'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
					'IP_ADDRESS' => $ip_address,
					'IP_LINK' => "http://network-tools.com/default.asp?host=$ip_address",
					'PORT' => hexdec($row['port']),
					'DATE' => create_date($board_config['default_dateformat'], $row['last_checked'], $board_config['board_timezone']),
					'TYPE' => $lang['proxy_t'.($row['behavior']-PROXY_TRANSPARE)],

					'U_CHECKPROXY' => append_sid("admin_proxy.$phpEx?mode=test&amp;address=$ip_address"),
					'U_DELPROXY' => append_sid("admin_proxy.$phpEx?mode=delete&amp;address=$ip_address"))
				);
				$i++;
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		$template->set_filenames(array(
			"body" => "admin/proxy_main_body.tpl")
		);

		$template->assign_vars(array(
			"S_CONFIG_ACTION" => append_sid("admin_proxy.$phpEx?mode=settings"), 
			"S_TEST_ACTION" => append_sid("admin_proxy.$phpEx?mode=test"), 
			"S_LIST_ACTION" => append_sid("admin_proxy.$phpEx?mode=list"),

			"L_YES" => $lang['Yes'],
			"L_NO" => $lang['No'],
			"L_TITLE" => $lang['proxy_title'],
			"L_DESC" => $lang['proxy_desc'],
			"L_TEST" => $lang['proxy_test'],
			"L_TEST_DESC" => $lang['proxy_test_desc'],
			"L_IP" => $lang['proxy_ip'],
			"L_PROXY_ENABLE" => $lang['proxy_enable'],
			"L_PROXY_ENABLE_DESC" => $lang['proxy_enable_desc'],
			"L_BAN" => $lang['proxy_ban'],
			"L_BAN_EXPLAIN" => $lang['proxy_ban_explain'],
			"L_TIMEOUT" => $lang['proxy_timeout'],
			"L_TIMEOUT_EXPLAIN" => $lang['proxy_timeout_explain'],
			"L_SECONDS" => $lang['proxy_seconds'],
			"L_PORTS" => $lang['proxy_ports'],
			"L_PORTS_EXPLAIN" => $lang['proxy_ports_explain'],
			"L_CACHE_TIME" => $lang['proxy_cache_time'],
			"L_CACHE_TIME_EXPLAIN" => $lang['proxy_cache_time_explain'],
			"L_USER_AGENT" => $lang['proxy_user_agent'],
			"L_USER_AGENT_EXPLAIN" => $lang['proxy_user_agent_explain'],
			"L_SETTINGS" => $lang['proxy_settings'],
			"L_CHECK" => $lang['proxy_check'],
			"L_DELETE" => $lang['Delete'],
			"L_VIEW_LIST" => $lang['proxy_view_list'],
			"L_PORT" => $lang['proxy_port'],
			"L_TYPE" => $lang['proxy_type'],
			"L_LAST_CHECKED" => $lang['proxy_last_checked'],
			"L_LIST_DESC" => $lang['proxy_list_desc'],

			"L_ENABLED" => $lang['Enabled'],
			"L_DISABLED" => $lang['Disabled'],
			"L_SUBMIT" => $lang['Submit'],
			"L_RESET" => $lang['Reset'],

			"ENABLE_VALUE" => $enable_value,
			"DISABLE_VALUE" => $disable_value,

			"ENABLE" => $enable_yes,
			"DISABLE" => $enable_no,
			"BAN_YES" => $ban_yes,
			"BAN_NO" => $ban_no,
			"LOG_ENABLE_YES" => $log_enable_yes, 
			"LOG_DISABLE" => $log_enable_no, 
			"BLOCK_YES" => $block_yes, 
			"BLOCK_NO" => $block_no, 
			"CACHE_TIME" => $new['proxy_cache_time'] / $unit_secs[$selected],
			"TIMEOUT" => $new['proxy_delay'], 
			"PORTS" => $new['proxy_ports'],
			"USER_AGENT" => $new['proxy_user_agent'],
			"SELECT_UNIT" => $select_unit,
			"IP_LINK" => $new['ip_link'],

			"U_IP" => decode_ip($user_ip))
		);
}

include('./page_header_admin.'.$phpEx);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>