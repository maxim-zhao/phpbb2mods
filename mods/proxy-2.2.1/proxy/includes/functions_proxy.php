<?php
/***************************************************************************
 *                                functions_proxy.php
 *                            -------------------
 *   begin                : Wednesday, Sept 4, 2005
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

// i'll move these over to includes/constants.php once they're actually needed
// (right now, they're more of a reminder to myself for features i'd like to implement at future dates)
define('PROXY_HTTP_MODE',1);
define('PROXY_CLI_MODE',2);

// also, in case anyone's currious, the differences between proxy checking via the ACP and automated proxy checking is that
// the latter relies on cached data (when available) and that the former always resets cached data when it checks.

class proxy
{
	// public variables
	var $messages;
	var $status;
	var $port;

	// private variables
	var $mode;
	var $decoded_ip;
	var $encoded_ip;
	var $ports;
	var $num_ports;
	var $timer_start;

	// private variables that are only used when $mode == PROXY_HTTP_MODE
	var $http_request;

	function proxy($mode = PROXY_HTTP_MODE)
	{
		global $board_config, $db;

		$this->mode = $mode;
		$this->messages = array();
		$this->status = $this->port = 0;

		list($usec, $sec) = explode(' ', microtime());
		$this->timer_start = ((float) $usec + (float) $sec);
		mt_srand($this->timer_start);

		// Delete entries whose tests weren't conclusive
		$sql = "DELETE FROM " . PROXY_TABLE . " 
			WHERE behavior = " . PROXY_ERROR;
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR,'Unable to delete corrupt entries', '', __LINE__, __FILE__, $sql);
		}

		// Delete old entries
		if ( $board_config['proxy_cache_time'] )
		{
			$age_limit = time() - $board_config['proxy_cache_time'];
			$sql = "DELETE FROM " . PROXY_TABLE . "
				WHERE last_checked < $age_limit";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Unable to delete old entries', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	// returns true if this ip address has already been scanned for proxies
	// returns false, otherwise
	function init($ip_address)
	{
		global $board_config, $phpEx, $db;


		$this->decoded_ip = $ip_address;
		$this->encoded_ip = encode_ip($ip_address);
		$this->ports = array_map('hexdec',explode(',', substr(chunk_split($board_config['proxy_ports'], 4, ','),0,-1)));
		$this->num_ports = count($this->ports);

		$sql = "SELECT port, behavior FROM " . PROXY_TABLE . " 
			WHERE ip_address = '".$this->encoded_ip."'";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR,'Unable to check against proxy list',__FILE__,__LINE__,$sql);
		}

		if ( !$db->sql_numrows() )
		{
			$sql = "INSERT INTO " . PROXY_TABLE . " (ip_address, last_checked)
				VALUES ('".$this->encoded_ip."', " . time() . ")";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Unable to insert data into proxy list', '', __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			if (!defined('IN_ADMIN'))
			{
				$temp = $db->sql_fetchrow($result);
				$this->port = $temp['port'];
				$this->status = $temp['behavior'];
				if ($this->status != 99)
				{
					return true;
				}
			}
			else	
			{
				$sql = "UPDATE " . PROXY_TABLE . " 
					SET behavior = 0, last_checked = " . time() . " 
					WHERE ip_address = '".$this->encoded_ip."'";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Unable to update data in proxy list', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		if ($this->mode == PROXY_HTTP_MODE)
		{
			$script_name = preg_replace('#^/?(.*?)/?$#', '\1', trim($board_config['script_path']));
			$script_name = ( $script_name != '' ) ? $script_name . '/proxy' : 'proxy';
			$server_name = trim($board_config['server_name']);

			$http_request = array();
			$http_request[] = "GET /$script_name/connect.$phpEx?address=".$this->decoded_ip."&port=%s HTTP/1.0";
			$http_request[] = "Host: $server_name";
			$http_request[] = "User-Agent: ".stripcslashes($board_config['proxy_user_agent']);
			$http_request[] = "Connection: close";
			$http_request[] = "\r\n";
			$this->http_request = implode("\r\n",$http_request);
		}

		return false;
	}

	function test()
	{
		global $board_config, $lang;

		$last_port = -1;

		$temp = mt_rand(0,$this->num_ports-1);

		// swap the last port with the port that we've randomly decided to display info. about
		$last_port = $this->ports[$temp];
		$this->ports[$temp] = $this->ports[$this->num_ports-1];
		$this->ports[$this->num_ports-1] = $last_port;

		if ($this->mode == PROXY_HTTP_MODE)
		{
			$this->messages['http1'] = sprintf(nl2br(trim($this->http_request)),$last_port);

			$server_ip = gethostbyname(trim($board_config['server_name']));
			$server_port = trim($board_config['server_port']);

			foreach ($this->ports as $port)
			{
				$fsock = fsockopen($server_ip, $server_port, $errno, $errstr, $board_config['proxy_delay']);
				if (!$fsock)
				{
					$this->messages['connect'] = sprintf($lang['proxy_connect_error'],"$server_ip:$server_port",$errno,$errstr);
					$this->status = PROXY_ERROR;
				}

				if ($port != $last_port)
				{
					// send the http request
					fputs($fsock,sprintf($this->http_request,$port));
				}
				else
				{
					// send the http request
					fputs($fsock,sprintf($this->http_request,"$port&debug=1"));

					// get the debug information...
					if (defined('IN_ADMIN'))
					{
						// get the http status code
						preg_match('#\d{3}#',fgets($fsock, 1024),$temp);
						$this->messages['http_status'] = $temp[0];

						// skip the rest of the headers in the http response
						while (!feof($fsock) && fgets($fsock, 1024) != "\r\n");

						// get the actual content
						$temp = '';
						while (!feof($fsock))
						{
							$temp .= fread($fsock, 1024);
						}

						// seperate the second sample http request and the sample sql query
						list($http, $sql) = explode("\r\n\r\n",$temp);

						// see if there's an IP invalid error then create a bogus http status so that we can bypass wait()
						if ( preg_match('#^IP mismatch#i',$http) )
						{
							$this->messages['http_status'] = PROXY_ERROR;
						}

						// see if there was an SQL error in connect.php
						if ( preg_match('#^SQL Error#i',$sql) )
						{
							$this->messages['http_status'] = PROXY_ERROR + 1;
						}

						// parse both as appropriate.
						$this->messages['http2'] = nl2br(preg_replace('#<title>(.*?)</title>#is','<b style="color:red">\\1</b>',trim(strip_tags($http,'<title>'))));
						$this->messages['sql'] = htmlspecialchars($sql);
					}
				}
				fclose($fsock);

			}
		}
		else if ($this->mode == PROXY_CLI_MODE)
		{
		}
	}

	// returns true if the cached proxy data was successfully retrived
	// returns false, otherwise
	function wait()
	{
		global $board_config, $lang, $db;

		// if the http status isn't 200, then no amount of waiting will get a valid proxy status, so just exit now.
		if ($this->mode == PROXY_HTTP_MODE && isset($this->messages['http_status']) && $this->messages['http_status'] != 200)
		{
			return false;
		}
		else if ( ($board_config['proxy_block'] || defined('IN_ADMIN')) && $this->status != PROXY_ERROR && $this->status < $this->num_ports )
		{
			$timeout = ini_get('max_execution_time');
			for ($num=0;($num < $timeout) && ($this->status < $this->num_ports);$num++)
			{
				sleep(1);
				$sql = "SELECT port, behavior FROM " . PROXY_TABLE . " 
					WHERE ip_address = '".$this->encoded_ip."'";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR,'Unable to load up-to-date proxy list',__FILE__,__LINE__,$sql);
				}
				$temp = $db->sql_fetchrow($result);
				$this->port = $temp['port'];
				$this->status = $temp['behavior'];
			}
			if ($num == $timeout)
			{
				return false;
			}
		}
		return true;
	}

	// returns true if the ip address was blocked and false, otherwise
	function block()
	{
		global $board_config, $userdata, $lang, $db;

		if ( $this->status != PROXY_ERROR && $this->status > $this->num_ports )
		{
			if ( $board_config['proxy_ban'] )
			{
				if (!defined('IN_ADMIN'))
				{
					// If the user can get this far, he hasn't already been banned (and thus, isn't already in the database)
					$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_ip) 
						VALUES ('".$this->encoded_ip."')";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR,'Unable to to insert ban_userip info into database',__FILE__,__LINE__,$sql);
					}
					session_end($userdata['session_id'], $userdata['user_id']);
				}
				else
				{
					$sql = "SELECT * FROM " . BANLIST_TABLE . " 
						WHERE ban_ip = '$encoded_ip'";
					if ( !($db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Unable to obtain banlist information', '', __LINE__, __FILE__, $sql);
					}

					if ( !$db->sql_numrows() )
					{
						$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_ip) 
							VALUES ('$encoded_ip')";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR,'Unable to to insert ban_userip info into database',__FILE__,__LINE__,$sql);
						}
						$sql = "DELETE FROM " . SESSIONS_TABLE . " 
							WHERE session_ip = '$encoded_ip'";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR,'Unable to delete banned sessions from database',__FILE__,__LINE__,$sql);
						}
					}
				}
				$sql = "DELETE FROM " . PROXY_TABLE . " 
					WHERE ip_address = '$encoded_ip'";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR,'Unable to delete from proxy list',__FILE__,__LINE__,$sql);
				}
			}
			$this->messages['result'] = sprintf($lang['proxy_detected'],$lang['proxy_t'.($this->status-PROXY_TRANSPARE)],hexdec($this->port));

			// i could just return $board_config['proxy_block'], but i think what i'm trying to do is a tad clearer with the following
			return ($board_config['proxy_block']) ? true : false;
		}
		else if ( $this->status == $this->num_ports )
		{
			$this->messages['result'] = $lang['proxy_none'];
		}
		else
		{
			$this->messages['result'] = $lang['proxy_timeout'].' ('.$this->status.')';
		}
		return false;
	}

	function elapsed_time()
	{
		list($usec, $sec) = explode(' ', microtime());
		return ((float) $usec + (float) $sec) - $this->timer_start;
	}
}

function scan4proxies($ip_address, $blocked)
{
	global $start_conditions, $check_conditions, $board_config;

	if (!isset($start_conditions))
	{
		$start_conditions = $check_conditions;
	}

	if ($start_conditions && $board_config['proxy_enable'] == 1)
	{
		$proxy = new proxy(PROXY_HTTP_MODE);
		if (!$proxy->init(decode_ip($ip_address)))
		{
			$proxy->test();
		}

		if ($check_conditions && !$proxy->wait())
		{
			message_die(GENERAL_ERROR,'Error scanning for proxies');
		}

		if ($proxy->block())
		{
			message_die(GENERAL_MESSAGE,'<p>'.$proxy->messages['result'].'</p><p>'.$blocked.'</p>');
		}
	}
}
?>