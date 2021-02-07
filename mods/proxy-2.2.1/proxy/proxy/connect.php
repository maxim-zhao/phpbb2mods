<?php
/***************************************************************************
 *                                connect.php
 *                            -------------------
 *   begin                : Wednesday, Mar 3, 2005
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

define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$server_name = trim($board_config['server_name']);

$valid_ips = gethostbynamel($server_name);
if ( !in_array($HTTP_SERVER_VARS['REMOTE_ADDR'],$valid_ips) && $HTTP_SERVER_VARS['REMOTE_ADDR'] != '127.0.0.1' )
{
	$valid_ips = implode(', ',$valid_ips).' and 127.0.0.1';
	// the following isn't translateable due to the fact that it shouldn't ever actually be called.  if it is, it's chief purpose is to help me debug.
	die('IP mismatch (requesting IP is '.$HTTP_SERVER_VARS['REMOTE_ADDR'].", valid server IPs are $valid_ips)");
}

$type = 0;
if ( $HTTP_GET_VARS['address'] != '127.0.0.1' && !in_array($HTTP_GET_VARS['address'],$valid_ips) && ($fsock = @fsockopen('tcp://'.$HTTP_GET_VARS['address'],$HTTP_GET_VARS['port'],$errno,$errstr,$board_config['proxy_delay'])) )
{
	@socket_set_timeout($fsock, $board_config['proxy_delay']);
	@socket_set_blocking($fsock, false);

	$script_name = preg_replace('#^/?(.*?)/?$#', '\1', trim($board_config['script_path']));
	$script_name = ( $script_name != '' ) ? $script_name . '/proxy/serve.'.$phpEx : 'proxy/serve.'.$phpEx;
	$server_port = ( $board_config['server_port'] != 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

	$server_url = 'http://' . $server_name . $server_port . $script_name;

	$query = "GET $server_url HTTP/1.0\r\n";
	$query .= "Host: $server_name\r\n";
	$query .= "User-Agent: ".stripcslashes($board_config['proxy_user_agent'])."\r\n";
	$query .= "Connection: close\r\n\r\n";

	if (!empty($HTTP_GET_VARS['debug']))
	{
		echo $query;
	}

	fputs($fsock,$query);

	$type = 0;
	while (!feof($fsock) && fgets($fsock, 1024) != "\r\n");
	while (!feof($fsock))
	{
		$temp = fread($fsock, 1024);
		if (preg_match('#transpare|anonymous|high_anon#si',$temp,$type) && !preg_match('#404 Not Found#si',$temp))
		{
			$type = $type[0];
			switch (strtolower($type))
			{
				case 'transpare':
					$type = PROXY_TRANSPARE;
					break;
				case 'anonymous':
					$type = PROXY_ANONYMOUS;
					break;
				case 'high_anon':
					$type = PROXY_HIGH_ANON;
			}
			break;
		}
		else
		{
			$type = 0;
		}
	}
	fclose($fsock);
}
else if (!empty($HTTP_GET_VARS['debug']))
{
	$script_name = preg_replace('#^/?(.*?)/?$#', '\1', trim($board_config['script_path']));
	$script_name = ( $script_name != '' ) ? $script_name . '/proxy/serve.'.$phpEx : 'proxy/serve.'.$phpEx;
	$server_port = ( $board_config['server_port'] != 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

	$server_url = 'http://' . $server_name . $server_port . $script_name;

	echo "GET $server_url HTTP/1.0\r\n";
	echo "Host: $server_name\r\n";
	echo "User-Agent: ".stripcslashes($board_config['proxy_user_agent'])."\r\n";
	echo "Connection: close\r\n\r\n";
}

if ($type == 0)
{
	$sql = "UPDATE " . PROXY_TABLE . " 
		SET behavior = behavior + 1 
		WHERE ip_address = '" . encode_ip($HTTP_GET_VARS['address']) . "' 
			AND behavior < " . PROXY_TRANSPARE;
}
else
{
	$sql = "UPDATE " . PROXY_TABLE . " 
		SET behavior = " . $type . ", port = '" . dechex($HTTP_GET_VARS['port']) . "' 
		WHERE ip_address = '" . encode_ip($HTTP_GET_VARS['address']) . "'";
}
if (!$db->sql_query($sql))
{
	$sql_error = $db->sql_error();
	echo 'SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
}
else
{
	echo $sql;
}
?>