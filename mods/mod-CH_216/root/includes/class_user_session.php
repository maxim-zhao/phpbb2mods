<?php
//
//	file: includes/class_user_session.php
//	author: ptirhiik
//	begin: 06/06/2006
//	version: 1.6.3 - 02/01/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('TIME_ONLINE_RANGE', 300);
define('SESSION_METHOD_BOT', 102);

class user_session
{
	var $ip;
	var $host;

	var $data;
	var $session_id;
	var $method;
	var $done;

	var $error_msg;

	function user_session()
	{
		$this->ip = '';
		$this->host = '';
		$this->data = array();
		$this->session_id = '';
		$this->method = SESSION_METHOD_GET;
		$this->done = false;
		$this->error_msg = '';
	}

	function init()
	{
		$this->ip = $this->get_ip();
	}

	function get_ip()
	{
		global $HTTP_SERVER_VARS, $HTTP_ENV_VARS;

		$client_ip = !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : (!empty($HTTP_ENV_VARS['REMOTE_ADDR']) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR'));
		return $client_ip ? encode_ip($client_ip) : '00000000';
	}

	function get_agent()
	{
		global $HTTP_SERVER_VARS;
		return trim(strtolower(!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT']) ? stripslashes($HTTP_SERVER_VARS['HTTP_USER_AGENT']) : getenv('HTTP_USER_AGENT')));
	}

	function check_host()
	{
		global $db;

		if ( $this->ip == '00000000' )
		{
			return false;
		}
		$now = time();
		$host_exists = $host_valid = false;

		// read stored ips
		$sql = 'SELECT host_valid
					FROM ' . HOSTADDR_TABLE . '
					WHERE host_ip = ' . $db->sql_type_cast($this->ip);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		if ( ($host_exists = ($row = $db->sql_fetchrow($result))) )
		{
			$host_valid = intval($row['host_valid']);
		}
		$db->sql_freeresult($result);

		// not yet stored: check the host
		if ( !$host_exists )
		{
			$client_ip = decode_ip($this->ip);
			$host = trim(htmlspecialchars(gethostbyaddr($client_ip)));
			$host_valid = !empty($host) && ($host != $client_ip);
			$fields = array(
				'host_ip' => $this->ip,
				'host_valid' => $host_valid,
				'host_time' => $now,
			);
			$sql = 'INSERT INTO ' . HOSTADDR_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);

			$sql = 'DELETE FROM ' . HOSTADDR_TABLE . '
						WHERE host_time < ' . ($now - (86400 * 15)); // 15 days
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
		return $host_valid;
	}

	function start($page_id=0)
	{
		global $db, $config;
		global $SID;

		$page_id = intval($page_id);
		$now = time();

		$this->get_sid();
		$this->check_bot();

		if ( ($userdata = $this->read('session', $this->method == SESSION_METHOD_BOT ? intval($this->data['userid']) : 0)) && $this->check_ip($userdata['session_ip']) )
		{
			$userdata['session_is_bot'] = ($this->method == SESSION_METHOD_BOT);
			$userdata['session_key'] = $this->data['autologinid'];
			$this->set_sid();

			// update db each minute or each page change
			if ( ($userdata['user_session_page'] != $page_id) || ($now - intval($userdata['session_time']) > 60) )
			{
				$fields = array(
					'session_time' => $now,
					'session_page' => $page_id,
					'session_admin' => 0,
				);
				if ( defined('IN_ADMIN') || (($now - 60 - intval($userdata['session_time'])) <= intval($config->data['session_length'])) )
				{
					unset($fields['session_admin']);
				}
				$sql = 'UPDATE ' . SESSIONS_TABLE . '
							SET ' . $db->sql_fields('update', $fields) . '
							WHERE session_id = \'' . $db->sql_escape_string($this->session_id) . '\'';
				$db->sql_query($sql, false, __LINE__, __FILE__);

				if ( $userdata['user_id'] != ANONYMOUS )
				{
					$fields = array(
						'user_session_time' => $now,
						'user_session_page' => $page_id,
						'user_session_logged' => 1,
					);
					$sql = 'UPDATE ' . USERS_TABLE . '
								SET ' . $db->sql_fields('update', $fields) . '
								WHERE user_id = ' . intval($userdata['user_id']);
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
				$this->write_cookies($now);
			}
		}
		else
		{
			$userdata = false;
		}

		// no available sessions : create a new one
		if ( !$userdata )
		{
			$user_id = isset($this->data['userid']) ? intval($this->data['userid']) : ANONYMOUS;
			$userdata = $this->create($user_id, $page_id, true);
		}

		// not able to create a session
		if ( !$userdata && !$this->error_msg )
		{
			$this->error_msg = 'Error creating user session';
		}
		return $userdata;
	}

	function create($user_id, $page_id, $auto_create=false, $enable_autologin=false, $admin=false)
	{
		global $db, $config;

		$page_id = intval($page_id);
		$user_id = intval($user_id) ? intval($user_id) : ANONYMOUS;
		$now = time();

		if ( !$this->done )
		{
			$this->get_sid();
			$this->check_bot();
		}

		// Are auto-logins allowed ? If allow_autologin is not set or is true then they are
		if ( isset($config->data['allow_autologin']) && !$config->data['allow_autologin'] )
		{
			$enable_autologin = $this->data['autologinid'] = false;
		}

		// get data
		$userdata = false;
		if ( $user_id != ANONYMOUS )
		{
			if ( isset($this->data['autologinid']) && !empty($this->data['autologinid']) )
			{
				if ( $userdata = $this->read('autologin', $user_id) )
				{
					$enable_autologin = true;
				}
			}
			else if ( ($this->method == SESSION_METHOD_BOT) || !$auto_create )
			{
				$this->data = array(
					'userid' => $user_id,
					'autologinid' => '',
				);
				$userdata = $this->read('simple', $user_id);
			}
		}

		//
		// At this point either $userdata should be populated or one of the below is true
		// * Key didn't match one in the DB
		// * User does not exist
		// * User is inactive
		//
		// If so, read anonymous
		//
		if ( !$userdata )
		{
			$user_id = ANONYMOUS;
			$this->data = array(
				'userid' => $user_id,
				'autologinid' => '',
			);
			$enable_autologin = false;
			if ( !($userdata = $this->read('simple', $user_id)) )
			{
				message_die(CRITICAL_ERROR, 'ANONYMOUS user is missing');
			}
		}

		// proceed with the data
		if ( $this->is_banned($user_id, $userdata['user_email']) )
		{
			$this->error_msg = 'You_been_banned';
			return false;
		}

		// create or update the session
		$fields = array(
			'session_user_id' => intval($user_id),
			'session_start' => intval($now),
			'session_time' => intval($now),
			'session_page' => intval($page_id),
			'session_logged_in' => $user_id != ANONYMOUS,
			'session_admin' => intval($admin),
		);
		if ( !empty($this->session_id) )
		{
			$sql = 'UPDATE ' . SESSIONS_TABLE . '
						SET ' . $db->sql_fields('update', $fields) . '
						WHERE session_id = \'' . $db->sql_escape_string($this->session_id) . '\'
							AND session_ip = \'' . $db->sql_escape_string($this->ip) . '\'';
		}
		if ( empty($this->session_id) || !$db->sql_query($sql, false, __LINE__, __FILE__, false) || !$db->sql_affectedrows() )
		{
			$this->session_id = md5(uniqid(dss_rand(), true));
			$fields += array(
				'session_id' => $this->session_id,
				'session_ip' => $this->ip,
			);
			$sql = 'INSERT INTO ' . SESSIONS_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) || !$db->sql_affectedrows() )
			{
				$sql = 'UPDATE ' . SESSIONS_TABLE . '
							SET ' . $db->sql_fields('update', $fields) . '
							WHERE session_id = \'' . $db->sql_escape_string($this->session_id) . '\'';
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
		}

		// set the $SID
		$this->set_sid(true);

		// update the user
		if ( $user_id != ANONYMOUS )
		{
			$last_visit = $userdata['user_session_time'] > 0 ? $userdata['user_session_time'] : $now;
			$userdata['user_lastvisit'] = $last_visit;
			if ( !$admin )
			{
				$fields = array(
					'user_session_time' => $now,
					'user_session_page' => $page_id,
					'user_session_logged' => true,
					'user_lastvisit' => $last_visit,
				);
				$sql = 'UPDATE ' . USERS_TABLE . '
							SET ' . $db->sql_fields('update', $fields) . '
							WHERE user_id = ' . intval($user_id);
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			// clean outdated sessions
			$this->clean();

			// regenerate the auto-login key
			if ( $enable_autologin && ($this->method != SESSION_METHOD_BOT) )
			{
				$auto_login_key = dss_rand() . dss_rand();
				$fields = array(
					'key_id' => md5($auto_login_key),
					'last_ip' => $this->ip,
					'last_login' => $now,
				);
				if ( isset($this->data['autologinid']) && !empty($this->data['autologinid']) )
				{
					$sql = 'UPDATE ' . SESSIONS_KEYS_TABLE . '
								SET ' . $db->sql_fields('update', $fields) . '
								WHERE key_id = \'' . $db->sql_escape_string(md5($this->data['autologinid'])) . '\'';
				}
				else
				{
					$fields += array(
						'user_id' => $user_id,
					);
					$sql = 'INSERT INTO ' . SESSIONS_KEYS_TABLE . '
								(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
				}
				$db->sql_query($sql, false, __LINE__, __FILE__);
				$this->data['autologinid'] = $auto_login_key;
				unset($auto_login_key);
			}
			else
			{
				$this->data['autologinid'] = '';
			}
			$this->data['userid'] = $user_id;
		}

		// add the session vars to $userdata
		$userdata = array_merge($userdata, array(
			'session_id' => $this->session_id,
			'session_ip' => $this->ip,
			'session_user_id' => $user_id,
			'session_logged_in' => $user_id != ANONYMOUS,
			'session_is_bot' => $this->method == SESSION_METHOD_BOT,
			'session_page' => $page_id,
			'session_start' => $now,
			'session_time' => $now,
			'session_admin' => $admin,
			'session_key' => $this->data['autologinid'],
		));

		// end with writing the cookies and updating stats
		$this->write_cookies($now);
		$this->record($userdata);

		return $userdata;
	}

	function end($session_id, $user_id)
	{
		global $db;

		// Delete existing session
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . ' 
					WHERE session_user_id = ' . intval($user_id) . ($user_id != ANONYMOUS ? '' : '
						AND session_id = \'' . $session_id . '\'');
		$db->sql_query($sql, false, __LINE__, __FILE__);

		if ( $user_id != ANONYMOUS )
		{
			// Remove this auto-login entry (if applicable)
			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
						WHERE user_id = ' . intval($user_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// update user status
			$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_session_logged = 0
						WHERE user_id = ' . intval($user_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// We expect that message_die will be called after this function,
		// but just in case it isn't, reset $userdata to the details for a guest
		$self = $this->data['userid'] == $user_id;
		$user_id = ANONYMOUS;
		$this->data = array(
			'userid' => $user_id,
			'autologinid' => '',
		);
		$userdata = $this->read('simple', $user_id);

		// remove cookies
		if ( $self )
		{
			$this->write_cookies();
		}
		return $userdata;
	}

	function clean()
	{
		global $db, $config;

		// Delete expired sessions
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
					WHERE session_time < ' . (time() - intval($config->data['session_length'])) . ' 
						AND session_id <> \'' . $this->session_id . '\'';
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// clear outdated session_logged switch at user level
		$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_session_logged = 0
					WHERE user_session_logged = 1
						AND user_session_time < ' . (time() - intval($config->data['session_length']));
		$db->sql_query($sql, false, __LINE__, __FILE__);

		//
		// Delete expired auto-login keys
		// If max_autologin_time is not set then keys will never be deleted
		// (same behaviour as old 2.0.x session code)
		//
		if ( intval($config->data['max_autologin_time']) > 0 )
		{
			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
						WHERE last_login < ' . (time() - (86400 * intval($config->data['max_autologin_time'])));
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	function cookies_def()
	{
		global $config;
		return array(
			'name' => $config->data['cookie_name'],
			'path' => $config->data['cookie_path'],
			'domain' => $config->data['cookie_domain'],
			'secure' => $config->data['cookie_secure'],
		);
	}

	function write_cookies($now=0)
	{
		if ( $this->method != SESSION_METHOD_BOT )
		{
			$cookie = $this->cookies_def();
			// delete
			if ( empty($now) )
			{
				setcookie($cookie['name'] . '_data', '', time() - 31536000, $cookie['path'], $cookie['domain'], $cookie['secure']);
				setcookie($cookie['name'] . '_sid', '', time() - 31536000, $cookie['path'], $cookie['domain'], $cookie['secure']);
			}
			// create
			else
			{
				setcookie($cookie['name'] . '_data', serialize($this->data), $now + 31536000, $cookie['path'], $cookie['domain'], $cookie['secure']);
				setcookie($cookie['name'] . '_sid', $this->session_id, 0, $cookie['path'], $cookie['domain'], $cookie['secure']);
			}
		}
	}

	function get_sid()
	{
		global $HTTP_COOKIE_VARS, $HTTP_GET_VARS;
		global $config;

		// try from cookies
		$cookie = $this->cookies_def();
		$session_id = $sessiondata = $sessionmethod = false;
		if ( isset($HTTP_COOKIE_VARS[$cookie['name'] . '_sid']) || isset($HTTP_COOKIE_VARS[$cookie['name'] . '_data']) )
		{
			$session_id = isset($HTTP_COOKIE_VARS[$cookie['name'] . '_sid']) ? $HTTP_COOKIE_VARS[$cookie['name'] . '_sid'] : false;
			$sessiondata = isset($HTTP_COOKIE_VARS[$cookie['name'] . '_data']) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$cookie['name'] . '_data'])) : array();
			$sessionmethod = SESSION_METHOD_COOKIE;
			$sessiondata = array(
				'userid' => intval($sessiondata['userid']) ? intval($sessiondata['userid']) : ANONYMOUS,
				'autologinid' => $sessiondata['autologinid'] ? trim(htmlspecialchars((string) $sessiondata['autologinid'])) : '',
			);
			if ( !empty($sessiondata['autologinid']) && !preg_match('/^[A-Za-z0-9]*$/', $sessiondata['autologinid']) )
			{
				$sessiondata = array(
					'userid' => ANONYMOUS,
					'autologinid' => '',
				);
			}
		}
		else
		{
			$session_id = isset($HTTP_GET_VARS['sid']) ? htmlspecialchars(stripslashes($HTTP_GET_VARS['sid'])) : false;
			$sessiondata = array();
			$sessionmethod = SESSION_METHOD_GET;
		}
		if ( !$session_id || !preg_match('/^[A-Za-z0-9]*$/', $session_id) )
		{
			$session_id = '';
		}

		$this->data = array();
		$this->session_id = '';
		$this->method = SESSION_METHOD_GET;
		if ( $session_id || $sessiondata )
		{
			$this->session_id = $session_id;
			$this->data = $sessiondata;
			$this->method = $sessionmethod;
		}
		$this->done = true;
	}

	function check_bot()
	{
		global $db, $config;

		// try to identify a bot
		if ( !defined('IN_ADMIN') && (empty($this->data) || ($this->data['userid'] == ANONYMOUS)) )
		{
			$bots = new bots();
			$bots->read();
			if ( ($bot_id = $bots->identify($this->ip, $this->get_agent())) )
			{
				// yes it is a bot
				$this->session_id = '';
				$this->data = array('userid' => $bot_id, 'autologinid' => '');
				$this->method = SESSION_METHOD_BOT;
			}
			unset($bots);
		}
	}

	function set_sid($force=false)
	{
		global $SID;

		$SID = defined('IN_ADMIN') || ($this->method == SESSION_METHOD_GET) || ($force && ($this->method != SESSION_METHOD_BOT)) ? 'sid=' . $this->session_id : '';
		return $SID;
	}

	function read($mode, $user_id=0, $inactive=false)
	{
		global $db, $config;

		$userdata = false;
		switch ( $mode )
		{
			case 'simple':
				$sql = 'SELECT u.*, g.*
							FROM ' . USERS_TABLE . ' u
								LEFT JOIN ' . GROUPS_TABLE . ' g
									ON g.group_user_id = u.user_id
							WHERE u.user_id = ' . intval($user_id) . (($user_id == ANONYMOUS) || $inactive ? '' : '
								AND u.user_active = 1');
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				if ( $row = $db->sql_fetchrow($result) )
				{
					$userdata = $row;
				}
				$db->sql_freeresult($result);
				break;

			case 'autologin':
				$sql = 'SELECT u.*, g.*
							FROM ' . USERS_TABLE . ' u, ' . SESSIONS_KEYS_TABLE . ' k
								LEFT JOIN ' . GROUPS_TABLE . ' g
									ON g.group_user_id = k.user_id
							WHERE k.user_id = ' . intval($user_id) . '
								AND k.key_id = \'' . md5($this->data['autologinid']) . '\'
								AND u.user_active = 1
								AND u.user_id = k.user_id';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				if ( $row = $db->sql_fetchrow($result) )
				{
					$userdata = $row;
				}
				$db->sql_freeresult($result);
				break;

			case 'session':
				$sql = '';
				if ( !empty($this->session_id) )
				{
					$sql = 'SELECT u.*, g.*, s.*
								FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . ' s
									LEFT JOIN ' . GROUPS_TABLE . ' g
										ON g.group_user_id = s.session_user_id
								WHERE s.session_id = \'' . $this->session_id . '\'
									AND s.session_time >= ' . (time() - intval($config->data['session_length'])) . '
									AND u.user_id = s.session_user_id
									AND (u.user_active = 1 OR u.user_id = ' . ANONYMOUS . ')
								ORDER BY s.session_time DESC
								LIMIT 1';
				}
				else if ( $this->method == SESSION_METHOD_BOT )
				{
					$sql = 'SELECT u.*, g.*, s.*
								FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . ' s
									LEFT JOIN ' . GROUPS_TABLE . ' g
										ON g.group_user_id = s.session_user_id
								WHERE s.session_user_id = ' . intval($user_id) . '
									AND s.session_time >= ' . (time() - intval($config->data['session_length'])) . '
									AND u.user_id = s.session_user_id
									AND u.user_active = 1
								ORDER BY s.session_time DESC
								LIMIT 1';
				}
				if ( $sql )
				{
					$result = $db->sql_query($sql, false, __LINE__, __FILE__);
					if ( $row = $db->sql_fetchrow($result) )
					{
						$userdata = $row;
						$this->session_id = $userdata['session_id'];
					}
					$db->sql_freeresult($result);
				}
				break;
		}
		if ( $userdata && ($userdata['user_id'] == ANONYMOUS) )
		{
			$userdata['username'] = 'Guest';
		}
		return $userdata;
	}

	function check_ip($ip)
	{
		return ($this->method == SESSION_METHOD_BOT) || (substr($ip, 0, 6) == substr($this->ip, 0, 6));
	}

	function is_banned($user_id, $user_email)
	{
		global $db;

		preg_match('/(..)(..)(..)(..)/', $this->ip, $user_ip_parts);
		$user_email_domain = substr($user_email, strpos($user_email,'@'));
		$sql = 'SELECT ban_ip, ban_userid, ban_email
					FROM ' . BANLIST_TABLE . '
					WHERE ban_ip IN (\'' . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . $user_ip_parts[4] . '\', \'' . $user_ip_parts[1] . $user_ip_parts[2] . $user_ip_parts[3] . 'ff\', \'' . $user_ip_parts[1] . $user_ip_parts[2] . 'ffff\', \'' . $user_ip_parts[1] . 'ffffff\')
						OR ban_userid = ' . intval($user_id) . ($user_id == ANONYMOUS ? '' : '
						OR ban_email LIKE \'' . $db->sql_escape_string($user_email) . '\'
						OR ban_email LIKE \'' . $db->sql_escape_string($user_email_domain) . '\'');
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$banned = ($row = $db->sql_fetchrow($result)) && ($row['ban_ip'] || $row['ban_userid'] || $row['ban_email']);
		$db->sql_freeresult($result);

		return $banned;
	}

	function record(&$userdata)
	{
		global $db;

		$user_id = intval($userdata['session_user_id']) ? intval($userdata['session_user_id']) : ANONYMOUS;
		$session_id = $userdata['session_id'];
		$session_admin = $userdata['session_admin'];

		// check if the same ip exists in last five minutes in case the session_id was not passed
		$has_visited = false;
		if ( $user_id == ANONYMOUS )
		{
			$sql = 'SELECT session_id
						FROM ' . SESSIONS_TABLE . '
						WHERE session_user_id = ' . ANONYMOUS . '
							AND session_id <> \'' . $db->sql_escape_string($session_id) . '\'
							AND session_time >= ' . (time() - TIME_ONLINE_RANGE) . '
							AND session_ip = \'' . $db->sql_escape_string($this->ip) . '\'
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$has_visited = $db->sql_numrows($result);
			$db->sql_freeresult($result);
		}
		// check if we recreate a session due to ACP access
		else
		{
			$has_visited = $session_admin;
		}

		// let's go
		if ( !$has_visited )
		{
			$current_hour = 3600 * floor(time() / 3600); // div to get the current hour
			$sql = 'UPDATE ' . STATS_VISIT_TABLE . '
						SET stat_visit = stat_visit + 1
						WHERE user_id = ' . intval($user_id) . '
							AND stat_time = ' . intval($current_hour);
			if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) || !$db->sql_affectedrows() )
			{
				//
				// if a guest comes between the attempt to update the stats and the insert of the row for the new hour
				// and manage to create the new row, we will lose this hit. Well, I think we can live with this eventuallity :).
				//
				$fields = array(
					'user_id' => $user_id,
					'stat_time' => $current_hour,
					'stat_visit' => 1,
				);
				$sql = 'INSERT INTO ' . STATS_VISIT_TABLE . '
							(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__, false);
			}
		}
	}
}

function session_pagestart($user_ip, $page_id)
{
	global $user;

	$user->session();
	$user->session->init();
	$userdata = $user->session->start($page_id);
	if ( $user->session->error_msg )
	{
		message_die(CRITICAL_ERROR, $user->session->error_msg);
	}
	return $userdata;
}

function session_begin($user_id, $user_ip, $page_id, $auto_create = 0, $enable_autologin = 0, $admin = 0)
{
	global $user;

	$user->session();
	$user->session->init();
	$userdata = $user->session->create($user_id, $page_id, $auto_create, $enable_autologin, $admin);
	if ( $user->session->error_msg )
	{
		message_die(CRITICAL_ERROR, $user->session->error_msg);
	}
	return $userdata;
}

function session_end($session_id, $user_id)
{
	global $user, $userdata;

	$user->session();
	$user->session->init();
	$userdata = $user->session->end($session_id, $user_id);
	if ( $user->session->error_msg )
	{
		message_die(CRITICAL_ERROR, $user->session->error_msg);
	}
	return true;
}

//
// Append $SID to a url. Borrowed from phplib and modified. This is an
// extra routine utilised by the session code above and acts as a wrapper
// around every single URL and form action. If you replace the session
// code you must include this routine, even if it's empty.
//
function append_sid($url, $non_html_amp = false)
{
	global $SID;

	if ( !empty($SID) && !preg_match('#sid=#', $url) )
	{
		$url .= ( ( strpos($url, '?') !== false ) ?  ( ( $non_html_amp ) ? '&' : '&amp;' ) : '?' ) . $SID;
	}

	return $url;
}

?>