<?php
//
//	file: install_cat/install_inc.php
//	author: ptirhiik
//	begin: 09/06/2006
//	version: 1.6.2 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') || !defined('IN_INSTALL') )
{
	die('Hack attempt !');
	exit;
}

class config_check
{
	var $cookie_secured;
	var $server_name;
	var $server_port;
	var $script_path;

	var $cookie_domain;
	var $cookie_name;
	var $cookie_path;

	var $fields;

	function config_check()
	{
		$this->cookie_secured = '';
		$this->server_name = '';
		$this->server_port = 0;
		$this->script_path = '';

		$this->cookie_domain = '';
		$this->cookie_name = '';
		$this->cookie_path = '/';

		$this->fields = array();
	}

	function process()
	{
		if ( $this->init() )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init()
	{
		global $config;

		$this->get_suggested_config();
		$this->fields = array(
			'cookie_secure' => array('suggested' => intval($this->cookie_secured), 'legend' => 'CH_server_secure', 'size' => 1, 'type' => TYPE_INT, 'options' => array(0 => 'CH_disabled', 1 => 'CH_enabled')),
			'server_name' => array('suggested' => $this->server_name, 'legend' => 'CH_server_name'),
			'server_port' => array('suggested' => intval($this->server_port), 'legend' => 'CH_server_port', 'size' => 3, 'type' => TYPE_INT),
			'script_path' => array('suggested' => $this->script_path, 'legend' => 'CH_script_path'),
			'cookie_domain' => array('suggested' => $this->cookie_domain, 'legend' => 'CH_cookie_domain'),
			'cookie_name' => array('suggested' => $this->cookie_name, 'legend' => 'CH_cookie_name'),
			'cookie_path' => array('suggested' => $this->cookie_path, 'legend' => 'CH_cookie_path'),
		);
		foreach ( $this->fields as $field_name => $data )
		{
			$this->fields[$field_name]['value'] = $data['options'] && isset($_POST[$field_name]) ? intval(_button($field_name)) : _read($field_name, $data['type'] ? $data['type'] : TYPE_NO_HTML, $config->data[$field_name], $data['options']);
		}
		return true;
	}

	function check()
	{
		global $page;

		if ( _button('submit_cfg') )
		{
			if ( empty($this->fields['server_name']['value']) )
			{
				$page->error('CH_error_server_name');
			}
			if ( empty($this->fields['script_path']['value']) )
			{
				$page->error('CH_error_script_path');
			}
			if ( empty($this->fields['cookie_name']['value']) )
			{
				$page->error('CH_error_cookie_name');
			}
		}
	}

	function validate()
	{
		global $page, $db;

		if ( _button('submit_cfg') && !$page->error() )
		{
			foreach ( $this->fields as $field_name => $data )
			{
				$fields = array(
					'config_value' => $data['value'],
				);
				$sql = 'UPDATE ' . CONFIG_TABLE . '
							SET ' . $db->sql_fields('update', $fields) . '
							WHERE config_name = ' . $db->sql_type_cast($field_name);
				if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) )
				{
					$fields = array(
						'config_name' => $field_name,
						'config_value' => $data['value'],
					);
					$sql = 'INSERT INTO ' . CONFIG_TABLE . '
								(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
				$config->data[$field_name] = $data['value'];
			}
		}
	}

	function display()
	{
		global $page, $config;

		if ( _button('submit_cfg') && !$page->error() )
		{
			return true;
		}

		$html_line = '
<tr>
	<td class="row1">{LEGEND}:&nbsp;
	</td>
	<td class="row2">{CHOICE}
		<br />{L_SUGGEST_VALUE}:&nbsp;{JAVA}
	</td>
</tr>';
		$single_choice = '<input type="text" name="{NAME}" value="{VALUE}" size="{SIZE}" />';
		$single_java = '<a href="#" onclick="document.post.{NAME}.value=\'{SUG_VALUE}\'; return false;">{SUG_VALUE}</a>';

		$boolean_choice = '<input type="checkbox" name="{NAME}" value="{SELECT_VALUE}"{SELECTED} />&nbsp;{L_SELECT_VALUE}';
		$boolean_java = '<a href="#" onclick="document.post.{NAME}.checked={SUG_VALUE}; return false;">{L_SUG_VALUE}</a>';

		$root_tpl_vars = array(
			'{L_SUGGEST_VALUE}' => $page->lang('CH_suggest_value'),
		);

		// send display
		$page->header();
		$page->send_messages();
?><form name="post" method="post" action="<?php echo $page->url(); ?>"><br /><br /><div align="center"><table cellpadding="4" cellspacing="1" border="0" width="80%" class="background">
<tr><th colspan="2"><?php echo $page->lang('CH_config_check'); ?></th></tr>
<tr><td align="center" class="row1" colspan="2"><br /><?php echo $page->lang('CH_config_check_explain'); ?><br /><br /></td></tr>
<?php
		foreach ( $this->fields as $field_name => $data )
		{
			$tpl_vars = $root_tpl_vars + array(
				'{LEGEND}' => $page->lang($data['legend']),
				'{NAME}' => $field_name,
				'{SIZE}' => $data['size'] ? $data['size'] : 50,
				'{VALUE}' => $data['value'],
				'{SUG_VALUE}' => $data['suggested'],
			);
			if ( $data['values'] )
			{
				$html = str_replace(array('{CHOICE}', '{JAVA}'), array($boolean_choice, $boolean_java), $html_line);
				$selected_idx = 1;
				$tpl_vars += array(
					'{SELECTED}' => $data['value'] == $selected_idx ? ' checked="checked"' : '',
					'{SELECT_VALUE}' => $selected_idx,
					'{L_SELECT_VALUE}' => $page->lang($data['values'][$selected_idx]),
					'{L_SUG_VALUE}' => $page->lang($data['values'][ $data['suggested'] ]),
				);
			}
			else
			{
				$html = str_replace(array('{CHOICE}', '{JAVA}'), array($single_choice, $single_java), $html_line);
			}
			echo str_replace(array_keys($tpl_vars), array_values($tpl_vars), $html);
		}
?>
<tr><td align="center" class="row2" colspan="2"><input name="submit_cfg" type="submit" value="<?php echo $page->lang('CH_submit'); ?>" /></td></tr>
</table></div><?php $page->hide(); ?></form>
<?php
		$page->footer();
	}

	function get_suggested_config()
	{
		global $config;

		$this->cookie_secured = strpos(' ' . strtoupper(empty($_SERVER['SERVER_PROTOCOL']) ? $_ENV['SERVER_PROTOCOL'] : $_SERVER['SERVER_PROTOCOL']), 'HTTPS');
		$this->server_name = empty($_SERVER['SERVER_NAME']) ? $_ENV['SERVER_NAME'] : $_SERVER['SERVER_NAME'];
		$port->server_port = intval(empty($_SERVER['SERVER_PORT']) ? $_ENV['SERVER_PORT'] : $_SERVER['SERVER_PORT']);
		if ( empty($this->server_port) )
		{
			$this->server_port = 80;
		}

		// search script path
		$uri = empty($_SERVER['REQUEST_URI']) ? $_ENV['REQUEST_URI'] : $_SERVER['REQUEST_URI'];
		if ( substr($uri, 0, 1) == '/' )
		{
			$uri = substr($uri, 1);
		}
		if ( substr($uri, strlen($uri) - 1, 1) == '/' )
		{
			$uri = substr($uri, 0, strlen($uri) - 1);
		}
		$uri = explode('/', $uri);

		// we don't want the script name
		if ( !empty($uri) )
		{
			unset($uri[ count($uri) - 1]);
		}

		// we are not at root
		if ( strpos(' ' . $config->root, '../') )
		{
			unset($uri[ count($uri) - 1]);
		}
		$this->script_path = str_replace('//', '/', empty($uri) ? '/' : '/' . implode('/', $uri) . '/');

		// cookies
		$name = empty($uri) ? '' : trim($uri[ count($uri) - 1]);
		$domain = explode('.', $this->server_name);
		if ( strtolower($domain[0]) == 'www' )
		{
			$domain[0] = '';
		}
		else if ( count($domain) > 1 )
		{
			$name = $domain[0] . (empty($name) ? '' : '_') . $name;
		}
		$this->cookie_domain = implode('.', $domain);
		$this->cookie_name = preg_replace('#([a-z0-9_]*)#', '\1', strtolower($name));
		$this->cookie_path = '/';
		if ( empty($this->cookie_name) )
		{
			$this->cookie_name = 'phpbb2';
		}
	}
}

function anonymous()
{
	global $config;

	return array(
			'user_id' => ANONYMOUS,
			'user_active' => 0,
			'username' => 'Anonymous',
			'user_password' => '',
			'user_session_time' => 0,
			'user_session_page' => 0,
			'user_lastvisit' => 0,
			'user_regdate' => empty($config->data['board_startdate']) ? time() : intval($config->data['board_startdate']),
			'user_level' => 0,
			'user_posts' => 0,
			'user_timezone' => intval($config->data['board_timezone']),
			'user_style' => 0,
			'user_lang' => '',
			'user_dateformat' => $config->data['default_dateformat'],
			'user_new_privmsg' => 0,
			'user_unread_privmsg' => 0,
			'user_last_privmsg' => 0,
			'user_emailtime' => 0,
			'user_viewemail' => 0,
			'user_attachsig' => 0,
			'user_allowhtml' => 0,
			'user_allowbbcode' => 1,
			'user_allowsmile' => 1,
			'user_allowavatar' => 1,
			'user_allow_pm' => 0,
			'user_allow_viewonline' => 1,
			'user_notify' => 0,
			'user_notify_pm' => 1,
			'user_popup_pm' => 0,
			'user_rank' => 0,
			'user_avatar' => '',
			'user_avatar_type' => 0,
			'user_email' => '',
			'user_icq' => '',
			'user_website' => '',
			'user_from' => '',
			'user_sig' => '',
			'user_sig_bbcode_uid' => '',
			'user_aim' => '',
			'user_yim' => '',
			'user_msnm' => '',
			'user_occ' => '',
			'user_interests' => '',
			'user_actkey' => '',
			'user_newpasswd' => '',
	);
}

function create_bots()
{
	global $db, $config, $session;

	// define bots
	$bots = array(
		'Ask Jeeves' => array('bot_agent' => 'Teoma', 'bot_ips' => '41d624,41d625,41d626,41d627'),
		'Gigablast' => array('bot_agent' => 'gigabot', 'bot_ips' => ''),
		'GoogleBot' => array('bot_agent' => 'Googlebot', 'bot_ips' => '42f9'),
		'MSNBot' => array('bot_agent' => 'MSNBOT', 'bot_ips' => 'cf4492,400408,4136bc'),
		'Yahoo! Slurp' => array('bot_agent' => '', 'bot_ips' => '42c4,448e,caa0'),
	);

	// get existings bots
	$sql = 'SELECT user_id, username
				FROM ' . USERS_TABLE . '
				WHERE LOWER(username) IN(\'' . implode('\', \'', array_keys($bots)) . '\')';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$existing = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$existing[ strtolower($row['username']) ] = intval($row['user_id']);
	}
	$db->sql_freeresult($result);
	if ( count($existing) == count($bots) )
	{
		return;
	}

	// get anonymous user
	$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . ANONYMOUS;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	if ( $row = $db->sql_fetchrow($result) )
	{
		foreach ( $row as $key => $value )
		{
			if ( !is_string($key) )
			{
				unset($row[$key]);
			}
		}
		$anonymous = $row;
	}
	else
	{
		$anonymous = anonymous();
	}
	$db->sql_freeresult($result);

	// get last user
	$sql = 'SELECT user_id
				FROM ' . USERS_TABLE . '
				ORDER BY user_id DESC';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$last_user = max(3, ($row = $db->sql_fetchrow($result)) ? intval($row['user_id']) : 3);
	$db->sql_freeresult($result);

	foreach ( $bots as $bot_name => $bot )
	{
		if ( !isset($existing[ strtolower($bot_name) ]) )
		{
			$last_user++;

			// prepare the fields
			$password = md5(mt_rand());
			$fields = array_merge($anonymous, array(
				'user_id' => $last_user,
				'username' => $bot_name,
				'user_password' => $password,
				'user_email' => str_replace(' ', '_', $bot_name) . strrchr($config->data['board_email'], '@'),
				'user_active' => true,
				'user_bot_agent' => $bot['bot_agent'],
				'user_bot_ips' => $bot['bot_ips'],
				'user_posts' => 0,
				'user_level' => 0,
				'user_timezone' => 0,
				'user_dst' => 0,
				'user_style' => 0,
				'user_viewemail' => 0,
				'user_regdate' => time(),
			));

			// create user
			$sql = 'INSERT INTO ' . USERS_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// create the group
			$fields = array(
				'group_type' => GROUP_CLOSED,
				'group_name' => '',
				'group_description' => 'Personal User',
				'group_moderator' => 0,
				'group_single_user' => 1,
				'group_user_id' => $last_user,
				'group_style' => 0,
				'group_unread_date' => 0,
			);
			$sql = 'INSERT INTO ' . GROUPS_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$group_id = $db->sql_nextid();

			// create the link
			$fields = array(
				'group_id' => $group_id,
				'user_id' => $last_user,
				'user_pending' => 0,
			);
			$sql = 'INSERT INTO ' . USER_GROUP_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}
}

function create_presets(&$presets)
{
	global $db;

	$db->sql_stack_reset();
	foreach ($presets as $preset_type => $preset_family )
	{
		foreach ( $preset_family as $preset_name => $preset_data )
		{
			// header
			$fields = array(
				'preset_type' => $preset_type,
				'preset_name' => $preset_name,
			);
			$sql = 'INSERT INTO ' . PRESETS_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$preset_id = intval($db->sql_nextid());

			// data
			if ( !empty($preset_data) && !empty($preset_data['fields']) )
			{
				$count_fields = count($preset_data['fields']);
				for ( $i = 0; $i < $count_fields; $i++ )
				{
					$fields = array(
						'preset_id' => $preset_id,
						'preset_auth' => $preset_data['fields'][$i],
						'preset_value' => intval($preset_data['value']),
					);
					$db->sql_stack_statement($fields);
				}
			}
		}
	}
	$db->sql_stack_insert(PRESETS_DATA_TABLE, false, __LINE__, __FILE__);
}

function create_stats_visit()
{
	global $db;

	// verify the stats are not already present
	$sql = 'SELECT *
				FROM ' . STATS_VISIT_TABLE . '
				LIMIT 1';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$filled = ($row = $db->sql_fetchrow($result));
	$db->sql_freeresult($result);
	if ( $filled )
	{
		$sql = 'DELETE FROM ' . STATS_VISIT_TABLE . '
					WHERE user_id = -2';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		return false;
	}

	// we only consider the previous day
	$yesterday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));

	$now = time();
	$current_time = $yesterday;
	$db->sql_stack_reset();
	while ( $current_time < $now )
	{
		// let's go with sessions
		$sql = 'SELECT DISTINCT session_ip
					FROM ' . SESSIONS_TABLE . '
					WHERE session_time BETWEEN ' . intval($current_time) . ' AND ' . intval($current_time + 3599) . '
						AND session_user_id = ' . ANONYMOUS;
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$stat_visit = $db->sql_numrows($result);
		$db->sql_freeresult($result);
		if ( $stat_visit )
		{
			$fields = array(
				'user_id' => ANONYMOUS,
				'stat_time' => $current_time,
				'stat_visit' => intval($stat_visit),
			);
			$db->sql_stack_statement($fields);
		}

		// let's go with users
		$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE user_lastvisit BETWEEN ' . intval($current_time) . ' AND ' . intval($current_time + 3599) . '
						AND user_id <> ' . ANONYMOUS;
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$stat_visit = $db->sql_numrows($result);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$fields = array(
				'user_id' => intval($row['user_id']),
				'stat_time' => $current_time,
				'stat_visit' => 1,
			);
			$db->sql_stack_statement($fields);
		}
		$db->sql_freeresult($result);
		$current_time += 3600;
	}

	// do some cleaning
	$sql = 'TRUNCATE TABLE ' . STATS_VISIT_TABLE;
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// insert new
	$db->sql_stack_insert(STATS_VISIT_TABLE, false, __LINE__, __FILE__);
	return true;
}

function read_file($file)
{
	$data = @fread(@fopen($file, 'r'), @filesize($file));
	return $data ? "\n" . trim($data) : '';
}

?>