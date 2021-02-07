<?php
//
//	file: includes/class_user.php
//	author: ptirhiik
//	begin: 26/08/2004
//	version: 1.6.9 - 22/05/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('MAX_UNREADS_COOKIES', 150);
define('MAX_UNREADS_DB', 300);

// special groups
$special_groups = array(
	GROUP_OWN => array('group_status' => GROUP_SPECIAL, 'group_name' => 'Group_own', 'group_description' => 'Group_own_desc', 'group_single_user' => true),
);

class themes
{
	var $data;
	var $data_time;
	var $from_cache;

	function read($force=false)
	{
		global $config;

		$db_cached = new cache('dta_themes', $config->data['cache_path'], $config->data['cache_disabled_themes']);
		$sql = 'SELECT * 
					FROM ' . THEMES_TABLE . '
					ORDER BY style_name';
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force, 'themes_id');
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;
	}
}

class langs
{
	var $data_time;
	var $from_cache;
	var $lang_list;
	var $lang_files;
	var $lang_used;
	var $requester;

	function langs($requester='', $lang_list='', $user_lang='', $lang_files='')
	{
		global $config;

		$this->requester = $requester;
		$this->from_cache = false;
		$this->data_time = 0;
		$this->lang_list = empty($lang_list) ? array() : (!is_array($lang_list) ? array($lang_list) : $lang_list);
		$this->lang_files = empty($lang_files) ? array() : (!is_array($lang_files) ? array($lang_files) : $lang_files);
		if ( defined('DEBUG_RUN_STATS') && !empty($this->lang_list) )
		{
			$this->lang_list[] = 'class_run_stats';
		}
		if ( defined('IN_ADMIN') )
		{
			$this->lang_list[] = 'admin';
		}
		$user_lang = $user_lang ? trim(phpbb_ltrim(basename(phpbb_rtrim($user_lang)), "'")) : '';
		$cfg_lang = $config->data['default_lang'] ? trim(phpbb_ltrim(basename(phpbb_rtrim($config->data['default_lang'])), "'")) : '';
		$this->lang_used = $this->check_dir($user_lang) ? $user_lang : ($this->check_dir($cfg_lang) ? $cfg_lang : 'english');
	}

	function check_dir($lang_dir)
	{
		global $config;
		return empty($lang_dir) ? false : @file_exists(phpbb_realpath($config->root . 'language/lang_' . $lang_dir));
	}

	function read($force=false)
	{
		global $config;

		// no cache in some cases
		if ( defined('HAS_DIED') || _read('redirect') || defined('IN_INSTALL') || empty($this->requester) )
		{
			$config->data['cache_disabled_lang'] = true;
		}
		$requester = defined('IN_ADMIN') ? 'admin' : $this->get_requester();

		// read from cache
		$lang = array();
		$this->from_cache = false;
		$this->data_time = time();
		$cache_name = 'lng_' . $this->lang_used . '_' . str_replace('/' , '_', $requester);
		$cache_file = $config->url($config->data['cache_path'] . $cache_name);
		if ( !$config->data['cache_disabled_lang'] )
		{
			if ( $force |= empty($config->data['cache_time_lang']) )
			{
				$config->set('cache_time_lang', time());
			}
			$gentime = 0;
			$cache_key = '';
			if ( !$force && @file_exists($cache_file) )
			{
				include($cache_file);
				$this->data_time = $gentime;
				$this->from_cache = true;
			}
			if ( !$this->from_cache || !isset($config->data['cache_key']) || ($cache_key != $config->data['cache_key']) || ($gentime < intval($config->data['cache_time_lang'])) )
			{
				$this->from_cache = false;
			}
			if ( $this->from_cache )
			{
				return $lang;
			}
		}

		// get switches
		$is = array();
		if ( !empty($this->lang_list) )
		{
			foreach ( $this->lang_list as $lang_switch )
			{
				$is[ $lang_switch ] = true;
			}
		}

		// additional language file to load before the lang_extend_* ones
		$additionals = array('lang_main');
		if ( isset($is['admin']) && $is['admin'] )
		{
			$additionals[] = 'lang_admin';
		}
		$additionals[] = 'lang_extend_phpbb';
		$additionals = array_flip($additionals) + (empty($this->lang_files) ? array() : array_flip($this->lang_files));

		// switch for the admin part
		$lang_extend_admin = isset($is['admin']) ? $is['admin'] : false;

		// read from sources
		$lang = array();
		$this->from_cache = false;
		$this->data_time = time();
		$lang_dir = 'language/lang_' . $this->lang_used;
		if ( $dir = @opendir($config->root . $lang_dir) )
		{
			// include the fixes on phpBB main language files
			if ( !empty($additionals) )
			{
				foreach ( $additionals as $file => $dummy )
				{
					if ( ($file == 'lang_main') && @file_exists($config->url($lang_dir . '/lang_main_CH')) )
					{
						$lang += $this->lang_main($lang_dir . '/', $is);
					}
					else if ( @file_exists($config->url($lang_dir . '/' . $file)) )
					{
						include($config->url($lang_dir . '/' . $file));
					}
				}
			}

			// include other extensions
			$ext_len = strlen('.' . $config->ext);
			while ( $file = @readdir($dir) )
			{
				if ( preg_match('/^lang_extend_.*\.' . $config->ext . '$/', $file) )
				{
					include($config->url($lang_dir . '/' . substr($file, 0, -$ext_len)));
				}
			}
			@closedir($dir);
		}

		// fix datetime lang array
		if ( !empty($lang['datetime']) )
		{
			foreach ( $lang['datetime'] as $key => $val )
			{
				$lang[$key] = $val;
			}
		}
		if ( !$this->from_cache && !$config->data['cache_disabled_lang'] )
		{
			$this->output($cache_name, $is, $lang);
		}
		return $lang;
	}

	function get_requester()
	{
		global $config, $HTTP_SERVER_VARS, $HTTP_ENV_VARS;

		if ( !empty($this->requester) )
		{
			return $this->requester;
		}

		// get requester
		$uri = basename(empty($HTTP_SERVER_VARS['REQUEST_URI']) ? $HTTP_ENV_VARS['REQUEST_URI'] : $HTTP_SERVER_VARS['REQUEST_URI']);

		// remove parms
		$parms_start = strpos(' ' . $uri, '?');
		if ( $parms_start )
		{
			$uri = substr($uri, 0, $parms_start - 1);
		}
		$uri = str_replace('&amp;', '&', $uri);
		$parms_start = strpos(' ' . $uri, '&');
		if ( $parms_start )
		{
			$uri = substr($uri, 0, $parms_start - 1);
		}

		// remove script path & extension
		$requester = str_replace(strtolower(basename($config->get_script_path())), '', strtolower($uri));
		$requester = str_replace(array(' ', '\'', '"', '.' . $config->ext), array('_', '', '', ''), $requester);

		// and finaly add the prefix
		return empty($requester) ? (defined('IN_ADMIN') ? 'admin/index' : INDEX) : $requester;
	}

	function output($cache_name, $is, &$lang)
	{
		global $config;

		$is = empty($is) || !is_array($is) ? array() : $is;

		// build the data to store
		$tpl_values = 'array(' . (empty($lang) ? '' : "\n");
		if ( !empty($lang) )
		{
			foreach ( $lang as $key => $val )
			{
				$tpl_values .= "\t" . '\'' . $key . '\' => ';
				if ( !is_array($val) )
				{
					$tpl_values .= '\'' . str_replace('\'', '\\\'', $val) . '\',' . "\n";
				}
				else
				{
					$tpl_values .= 'array(' . "\n";
					foreach ( $val as $sub_key => $sub_val )
					{
						$tpl_values .= "\t\t" . '\'' . $sub_key . '\'' . ' => ' . '\'' . str_replace('\'', '\\\'', $sub_val) . '\',' . "\n";
					}
					$tpl_values .= "\t" . '),' . "\n";
				}
			}
		}
		$tpl_values .= ')';

		// query & var
		$tpl_query = (empty($this->requester) ? $this->get_requester() :  $this->requester) . '.' . $config->ext . ' :: ' . $cache_name . (empty($is) ? '' :  ' :: ' . implode(', ', array_keys($is)));
		$tpl_var = '$lang';

		// output to file
		$cache = new cache($cache_name);
		$cache->data_time = $this->data_time;
		$cache->write_cache($tpl_values, $tpl_query, $tpl_var, true);
		unset($cache);

		// create cache time entry
		if ( !isset($config->data['cache_time_lang']) )
		{
			$config->set('cache_time_lang', $this->data_time);
		}
	}

	function lang_main($path, &$will_be)
	{
		global $config;

		// first get the whole CH filter file
		$is = $lang = array();
		include($config->url($path . 'lang_main_CH'));
		$lang_whole = $lang;
		unset($lang);

		// from now we apply the filters
		$is = &$will_be;

		// read phpbb original lang
		$lang = array();
		if ( ($filename = $config->url($path . 'lang_main')) && file_exists(phpbb_realpath($filename)) )
		{
			include($filename);
		}
		$lang_main = $lang;
		unset($lang);

		if ( empty($lang_whole) )
		{
			return $lang_main;
		}

		// is there more key in lang_main than the vanilia phpBB ones ?
		$lang_add = array();
		if ( !empty($lang_main) )
		{
			foreach ( $lang_main as $key => $value )
			{
				if ( !isset($lang_whole[$key]) )
				{
					if ( !$is )
					{
						$lang_whole[$key] = $value;
					}
					else
					{
						$lang_add[$key] = $value;
					}
				}
			}
		}

		// now include the CH filter file
		if ( !$is )
		{
			$lang = $lang_whole;
			unset($lang_whole);
		}
		else
		{
			unset($lang_whole);
			$lang = array();
			if ( ($filename = $config->url($path . 'lang_main_CH')) && file_exists(phpbb_realpath($filename)) )
			{
				include($filename);
			}
			$lang += $lang_add;
		}
		unset($lang_add);

		// keep only filtered values
		foreach ( $lang as $key => $value )
		{
			if ( empty($value) && isset($lang_main[$key]) )
			{
				$lang[$key] = $lang_main[$key];
			}
			if ( isset($lang_main[$key]) )
			{
				unset($lang_main[$key]);
			}
		}
		unset($lang_main);

		return $lang;
	}
}

class style
{
	function read($force_style=0)
	{
		// var used
		global $config, $user, $template, $images;

		// get the user style
		$row = $this->get_style($force_style);

		// give some vars for compliancy
		$userdata = &$user->data;

		// get main parameters
		$template_path = 'templates/';
		$template_name = $row['template_name'];

		// intantiate the template
		if ( $template = new template_class($config->root . $template_path . $template_name, $row['custom_tpls']) )
		{
			// read images pack (.cfg) and template init (.ini)
			$images_pack = $template_path . $template_name . '/' . $template_name . '.cfg';
			$custom_images_pack = empty($row['images_pack']) || ($row['images_pack'] == $template_name . '.cfg') ? '' : $template_path . $template_name . '/' . $row['images_pack'];
			$images = array_merge($this->read_images_pack($images_pack), $this->read_images_pack($custom_images_pack));
		}
		return $row;
	}

	function check_dir($current_template_path, $lang)
	{
		global $config;
		return ($filename = phpbb_realpath($config->root . $current_template_path . '/images/lang_' . $lang)) && @file_exists($filename);
	}

	function read_images_pack($images_pack)
	{
		// var to make them available in .cfg & .ini
		global $config, $user, $template;
		global $db, $censored_words, $icons, $navigation, $themes, $smilies, $requester;
		global $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header;
		global $user_ip, $session_length;
		global $starttime;

		if ( empty($images_pack) )
		{
			return array();
		}

		// give some vars for compliancy
		$userdata = &$user->data;

		// process
		$images = array();
		if ( ($filename = phpbb_realpath($config->root . $images_pack)) && ($file = @fread(fopen($filename, 'r'), filesize($filename))) )
		{
			$current_template_path = substr($images_pack, 0, strrpos($images_pack, '/'));
			$img_lang = $this->check_dir($current_template_path, $user->lang_used) ? $user->lang_used : ($this->check_dir($current_template_path, $config->data['default_lang']) ? $config->data['default_lang'] : 'english');
			eval("\n?>" . str_replace('{LANG}', 'lang_' . $img_lang, $file) . "<?php\n");
		}

		// try to get .ini
		if ( preg_match('#\.cfg$#i', $images_pack) && ($ini = preg_replace('#\.cfg$#i', '.ini', $images_pack)) && ($filename = phpbb_realpath($config->root . $ini)) && file_exists($filename) )
		{
			include($filename);
		}
		return $images;
	}

	function get_style($force_style=0)
	{
		global $config, $themes, $forums, $forum_id, $user;

		// read available styles
		$themes->read();

		// choose the template
		$style = intval($config->data['default_style']);
		$done = false;
		if ( !defined('IN_ADMIN') )
		{
			// style has been granted : use it if available
			if ( !$done && ($force_style = intval($force_style)) && isset($themes->data[$force_style]) )
			{
				$style = $force_style;
				$done = true;
			}

			// check on individual group
			if ( !$done && ($group_style = intval($user->data['group_style'])) && isset($themes->data[$group_style]) )
			{
				$style = $group_style;
				$done = true;
			}

			// check on forums
			if ( !$done && intval($forum_id) )
			{
				if ( $forums === false )
				{
					if ( !class_exists('forums') )
					{
						include($config->url('includes/class_forums'));
					}
					$forums = new forums();
					$forums->read();
				}
				if ( ($forum_style = isset($forums->data[$forum_id]) && intval($forums->data[$forum_id]['forum_style']) ? intval($forums->data[$forum_id]['forum_style']) : 0) && isset($themes->data[$forum_style]) )
				{
					$style = $forum_style;
					$done = true;
				}
			}

			// check on user
			if ( !$done && ($user_style = !$config->data['override_user_style'] && intval($user->data['user_style']) ? intval($user->data['user_style']) : 0) && isset($themes->data[$user_style]) )
			{
				$style = $user_style;
				$done = true;
			}
		}

		// get the first style
		if ( !isset($themes->data[$style]) )
		{
			if ( !($style = ($style == intval($config->data['default_style'])) ? _first_key($themes->data) : intval($config->data['default_style'])) )
			{
				message_die(CRITICAL_ERROR, 'No styles !');
			}
		}
		$row = $themes->data[$style];

		// force the main css when in admin
		$head_stylesheet = $row['template_name'] . '.css';
		if ( defined('IN_ADMIN') && ($row['head_stylesheet'] != $head_stylesheet) )
		{
			foreach ( $themes->data as $style_id => $data )
			{
				if ( $data['head_stylesheet'] == $head_stylesheet )
				{
					$row = $data;
					break;
				}
			}
		}
		return $row;
	}
}

class user
{
	var $data;
	var $cache;
	var $cache_time;

	var $session;
	var $session_done;

	var $cookies;
	var $cookies_flag;
	var $pool;
	var $pool_fields;

	var $lang_list;
	var $lang_files;

	var $lang_set;
	var $lang_from_cache;
	var $lang_none;
	var $style_set;

	var $lang_used;
	var $global_lang;
	var $global_images;

	var $plug_ins;
	var $plug_ins_done;

	function user()
	{
		$this->data = array();
		$this->cache = array();
		$this->cache_time = array();
		$this->session = array();
		$this->session_done = false;
		$this->lang_none = false;
		$this->cookies = array();
		$this->cookies_flag = false;
		$this->lang_list = array();
		$this->lang_files = array();

		$this->pool = array();
		$this->pool_fields = array(
			'username',
			'user_level',
			'user_allow_viewonline',
			'user_session_time',
			'user_session_logged',
			'user_bot_ips',
			'user_bot_agent',
		);

		$this->lang_used = 'english';
		$this->lang_set = false;
		$this->lang_from_cache = false;
		$this->style_set = false;

		$this->plug_ins = false;
		$this->plug_ins_done = false;
	}

	function session()
	{
		if ( !$this->session_done )
		{
			$this->session = new user_session();
			$this->session_done = true;
		}
	}

	function read($user_id)
	{
		global $db;

		// read user
		$this->data = array();
		$data = false;
		if ( intval($user_id) )
		{
			$read_api = new user_session();
			$data = $read_api->read('simple', intval($user_id), true);
			unset($read_api);
		}
		if ( !$data )
		{
			return false;
		}
		$this->data = $data;
		$this->create_individual();

		// guest
		if ( $this->data['user_id'] == ANONYMOUS )
		{
			$this->overwrite_anonymous_values();
		}

		// pool fields
		if ( $count_pool_fields = count($this->pool_fields) )
		{
			for ( $i = 0; $i < $count_pool_fields; $i++ )
			{
				$this->pool[ $this->data['user_id'] ][ $this->pool_fields[$i] ] = $this->data[ $this->pool_fields[$i] ];
			}
		}
		return true;
	}

	function create_individual()
	{
		global $db;

		if ( !empty($this->data['group_id']) )
		{
			return;
		}

		// create individual group
		$sql = 'SELECT g.*
					FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
					WHERE ug.user_id = ' . intval($this->data['user_id']) . '
						AND g.group_id = ug.group_id
						AND g.group_single_user = 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ( $row )
		{
			$this->data = array_merge($this->data, $row);
			$this->data['group_user_id'] = $this->data['user_id'];
			$sql = 'UPDATE ' . GROUPS_TABLE . '
						SET group_user_id = ' . intval($this->data['user_id']) . '
						WHERE group_id = ' . intval($this->data['group_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
		// no individual group : this should never occur !
		else
		{
			// create individual group
			$fields = array(
				'group_type' => GROUP_CLOSED,
				'group_name' => '',
				'group_status' => 0,
				'group_description' => 'Personal User',
				'group_moderator' => 0,
				'group_single_user' => 1,
				'group_user_id' => intval($this->data['user_id']),
				'group_style' => 0,
				'group_unread_date' => 0,
			);
			$this->data = array_merge($this->data, $fields);
			$db->sql_statement($fields);
			$sql = 'INSERT INTO ' . GROUPS_TABLE . '
						(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$this->data['group_id'] = intval($db->sql_nextid());

			// links the user to
			$fields = array(
				'group_id' => intval($this->data['group_id']),
				'user_id' => intval($this->data['user_id']),
				'user_pending' => 0,
			);
			$db->sql_statement($fields);
			$sql = 'INSERT INTO ' . USER_GROUP_TABLE . '
						(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	function read_pool(&$user_ids)
	{
		global $db;

		if ( !empty($user_ids) )
		{
			$sql = 'SELECT user_id, ' . implode(', ', $this->pool_fields) . '
						FROM ' . USERS_TABLE . '
						WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$user_id = intval($row['user_id']);
				unset($row['user_id']);
				$this->pool[$user_id] = $row;
			}
			$db->sql_freeresult($result);
		}
		$user_ids = array();
	}

	function get_groups_list($force=false)
	{
		global $db;

		if ( !intval($this->data['user_id']) )
		{
			return array();
		}

		// get the individual group id
		if ( empty($this->data['group_id']) )
		{
			$this->create_individual();
		}

		// search for the user's membership
		if ( $force || empty($this->cache_time[POST_GROUPS_URL . 'list']) )
		{
			$group_ids = array();
			if ( $this->data['user_id'] == ANONYMOUS )
			{
				$group_ids = array(GROUP_ANONYMOUS);
			}
			else
			{
				$group_ids = array(GROUP_REGISTERED);
				$sql = 'SELECT group_id
							FROM ' . USER_GROUP_TABLE . '
							WHERE user_id = ' . intval($this->data['user_id']) . '
								AND user_pending <> 1';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$group_ids[] = intval($row['group_id']);
				}
				$db->sql_freeresult($result);
			}
			$this->cache_time[POST_GROUPS_URL . 'list'] = time();
			$this->cache[POST_GROUPS_URL . 'list'] = $group_ids;
			$this->write_cache(POST_GROUPS_URL . 'list');
		}
		else
		{
			$group_ids = empty($this->cache[POST_GROUPS_URL . 'list']) ? array() : $this->cache[POST_GROUPS_URL . 'list'];
		}
		return empty($group_ids) ? array() : $group_ids;
	}

	function join_groups($group_ids, $pending=true)
	{
		global $db, $config, $forums;

		if ( empty($group_ids) )
		{
			return;
		}
		if ( !is_array($group_ids) )
		{
			$group_ids = array($group_ids);
		}

		// remove remaining membership
		$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
					WHERE group_id IN (' . implode(', ', $group_ids) . ')
						AND user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// add to groups
		$db->sql_stack_reset();
		$count_group_ids = count($group_ids);
		for ( $i = 0; $i < $count_group_ids; $i++ )
		{
			$fields = array(
				'group_id' => intval($group_ids[$i]),
				'user_id' => intval($this->data['user_id']),
				'user_pending' => intval($pending),
			);
			$db->sql_stack_statement($fields);
		}
		$db->sql_stack_insert(USER_GROUP_TABLE, false, __LINE__, __FILE__);

		// verify if a style is to apply
		if ( !$pending && !intval($this->data['group_style']) )
		{
			$sql = 'SELECT group_style
						FROM ' . GROUPS_TABLE . '
						WHERE group_id IN(' . implode(', ', $group_ids) . ')
							AND group_style <> 0
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$group_style = ($row = $db->sql_fetchrow($result)) ? intval($row['group_style']) : 0;
			$db->sql_freeresult($result);
			if ( intval($group_style) )
			{
				$sql = 'UPDATE ' . GROUPS_TABLE . '
							SET group_style = ' . intval($group_style) . '
							WHERE group_id = ' . intval($this->data['group_id']);
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
		}
	}

	function leave_groups($group_ids)
	{
		global $db, $config, $forums;

		if ( empty($group_ids) )
		{
			return;
		}
		if ( !is_array($group_ids) )
		{
			$group_ids = array($group_ids);
		}

		// remove links
		$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
					WHERE group_id IN (' . implode(', ', $group_ids) . ')
						AND user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// verify if a style is to remove
		if ( intval($this->data['group_style']) )
		{
			// verify old style comes from a group
			$sql = 'SELECT group_style
						FROM ' . GROUPS_TABLE . '
						WHERE group_id IN(' . implode(', ', $group_ids) . ')
							AND group_style = ' . intval($this->data['group_style']) . '
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$old_style = ($row = $db->sql_fetchrow($result)) ? intval($row['group_style']) : 0;
			$db->sql_freeresult($result);

			// verify if a new style replace the old
			if ( $old_style )
			{
				$sql = 'SELECT g.group_style
							FROM ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . 'ug
							WHERE ug.user_id = ' . intval($this->data['user_id']) . '
								AND ug.user_pending <> 1
								AND g.group_id = ug.group_id
								AND g.group_single_user <> 1
								AND g.group_style <> 0
							LIMIT 1';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$new_style = ($row = $db->sql_fetchrow($result)) ? intval($row['group_style']) : 0;
				$db->sql_freeresult($result);

				// apply style if necessary
				if ( $new_style != $old_style )
				{
					$sql = 'UPDATE ' . GROUPS_TABLE . '
								SET group_style = ' . intval($new_style) . '
								WHERE group_id = ' . intval($this->data['group_id']);
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
			}
		}
	}

	function recache_groups()
	{
		global $db, $config, $forums;

		// delete auths so they will be recreated the next page
		$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// recache moderators
		if ( !class_exists('moderators') )
		{
			include($config->url('includes/class_forums'));
		}
		$moderators = new moderators();
		$moderators->set_users_status();
		$moderators->read(true);
		unset($moderators);

		// recache bots
		if ( $this->data['user_bot_ips'] || $this->data['user_bot_agent'] )
		{
			$bots = new bots();
			$bots->read(true);
			unset($bots);
		}
	}

	function use_lang($lang_list)
	{
		$this->lang_list = array_merge($this->lang_list, empty($lang_list) ? array() : (!is_array($lang_list) ? array($lang_list) : $lang_list));
	}

	function use_lang_file($lang_files)
	{
		$this->lang_files = array_merge($this->lang_files, empty($lang_files) ? array() : (!is_array($lang_files) ? array($lang_files) : $lang_files));
	}

	function set($requester='', $lang_list='', $lang_files='')
	{
		global $userdata, $lang, $images;

		if ( !empty($this->data) )
		{
			return;
		}
		if ( !empty($lang_list) )
		{
			$this->use_lang($lang_list);
		}
		if ( !empty($lang_files) )
		{
			$this->use_lang_file($lang_files);
		}
		if ( ($lang_list === false) && empty($lang_files) )
		{
			$this->lang_none = true;
		}

		$this->data = &$userdata;

		// we must have an individual group : if missing, create it
		if ( empty($this->data['group_id']) )
		{
			$this->get_groups_list(true);
		}

		// default values for guests
		if ( $this->data['user_id'] == ANONYMOUS )
		{
			$this->overwrite_anonymous_values();
		}

		// set lang
		$this->set_lang($requester);

		// set style
		$this->set_style();

		// globalize lang & images
		$this->global_lang = &$lang;
		$this->global_images = &$images;

		// add user to user pool
		if ( ($this->data['user_id'] != ANONYMOUS) && !isset($this->pool[ $this->data['user_id'] ]) )
		{
			foreach ( $this->data as $field => $value )
			{
				if ( substr($field, 0, 4) == 'user' )
				{
					$this->pool[ $this->data['user_id'] ][$field] = $this->data[$field];
				}
			}
		}
	}

	function set_lang($requester='', $force=false)
	{
		global $lang;

		if ( !$this->lang_none )
		{
			$langs = new langs($requester, $this->lang_list, $this->data['user_lang'], $this->lang_files);
			$this->lang_used = $langs->lang_used;
			$lang = $langs->read($force);
			$this->lang_from_cache = $langs->from_cache;
			unset($langs);
		}
		$this->lang_set = true;
	}

	function set_style($force_style=0)
	{
		global $theme;

		$style = new style();
		$theme = $style->read($force_style);
		unset($style);
		$this->style_set = true;
	}

	function overwrite_anonymous_values()
	{
		global $config;

		$default_values = array(
			'user_dateformat' => 'default_dateformat',
			'user_timezone' => 'board_timezone',
			'user_dst' => 'board_dst',
			'user_style' => 'default_style',
			'user_lang' => 'default_lang',
			'user_allowhtml' => 'allow_html',
			'user_allowbbcode' => 'allow_bbcode',
			'user_allowsmile' => 'allow_smilies',
		);
		foreach ( $default_values as $user_field => $config_field )
		{
			if ( isset($config->data[$config_field]) )
			{
				$this->data[$user_field] = $config->data[$config_field];
			}
		}
		$this->data = array_merge($this->data, array(
			'user_active' => 0,
			'user_posts' => 0,
			'user_level' => 0,
			'user_new_privmsg' => 0,
			'user_unread_privmsg' => 0,
			'user_last_privmsg' => 0,
			'user_emailtime' => 0,
		));
	}

	function get_cache($cache_ids='')
	{
		global $db, $config;

		// we will deal with auths, so we need the groups list
		$cache_ids = empty($cache_ids) ? array() : (!is_array($cache_ids) ? array($cache_ids) : $cache_ids);
		if ( !in_array(POST_GROUPS_URL . 'list', $cache_ids) )
		{
			$cache_ids[] = POST_GROUPS_URL . 'list';
		}
		$count_cache_ids = count($cache_ids);

		// get caches from user cache
		$sql = 'SELECT cache_id, cache_data, cache_time
					FROM ' . USERS_CACHE_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']) . ($count_cache_ids == 1 ? '
						AND cache_id = \'' . $cache_ids[0] . '\'' : '
						AND cache_id IN(\'' . implode('\', \'', $cache_ids) . '\')');
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( !empty($row['cache_time']) && ($row['cache_time'] >= max(intval($config->data['cache_time_' . $row['cache_id'] ]), intval($config->data['cache_time_' . $row['cache_id'][0] ]))) )
			{
				$this->cache[ $row['cache_id'] ] = ($row['cache_id'] == POST_GROUPS_URL . 'list') ? (empty($row['cache_data']) ? array() : explode(',', $row['cache_data'])) : unserialize(stripslashes($row['cache_data']));
				$this->cache_time[ $row['cache_id'] ] = $row['cache_time'];
			}
		}
		$db->sql_freeresult($result);

		// caches to process
		$process = array();
		for ( $i = 0; $i < $count_cache_ids; $i++ )
		{
			if ( !isset($this->cache_time[ $cache_ids[$i] ]) || !intval($this->cache_time[ $cache_ids[$i] ]) )
			{
				// auths are coded on one char
				if ( strlen($cache_ids[$i]) == 1 )
				{
					$process[] = $cache_ids[$i];
				}
				else
				{
					$this->cache[ $cache_ids[$i] ] = array();
					$this->cache_time[ $cache_ids[$i] ] = 0;
				}
			}
		}

		// refresh required auth
		if ( !empty($process) )
		{
			$auths = new auth_class();
			$auths->get($this, $process, $this->cache, $this->cache_time);
			unset($auths);
		}

		// recache result
		if ( !empty($process) )
		{
			$this->write_cache($process);
		}
	}

	function write_cache($cache_ids='')
	{
		global $db;

		if ( empty($cache_ids) )
		{
			return;
		}
		if ( !is_array($cache_ids) )
		{
			$cache_ids = array($cache_ids);
		}
		$count_cache_ids = count($cache_ids);

		// delete remaining caches
		$sql_where = ($count_cache_ids > 1) ? 'cache_id IN(\'' . implode('\', \'', $cache_ids) . '\')' : 'cache_id = \'' . $cache_ids[0] . '\'';
		$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
					WHERE user_id = ' . intval($this->data['user_id']) . '
						AND ' . $sql_where;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// insert new values
		$db->sql_stack_reset();
		for ( $i = 0; $i < $count_cache_ids; $i++ )
		{
			$fields = array(
				'user_id' => intval($this->data['user_id']),
				'cache_id' => $cache_ids[$i],
				'cache_time' => $this->cache_time[ $cache_ids[$i] ],
				'cache_data' => ($cache_ids[$i] == POST_GROUPS_URL . 'list') ? (empty($this->cache[ $cache_ids[$i] ]) ? '' : implode(',', $this->cache[ $cache_ids[$i] ])) : serialize($this->cache[ $cache_ids[$i] ]),
			);
			$db->sql_stack_statement($fields);
		}
		$db->sql_stack_insert(USERS_CACHE_TABLE, false, __LINE__, __FILE__);
	}

	function cache($cache_id, &$data, $data_time=0)
	{
		global $db;

		$this->cache[$cache_id] = $data;
		$this->cache_time[$cache_id] = empty($data_time) ? time() : $data_time;
		$this->write_cache($cache_id);
	}

	function auth($auth_type, $auth_names, $obj_ids)
	{
		global $config;

		$auth_names = is_array($auth_names) ? array_flip($auth_names) : array($auth_names => 0);
		$obj_ids = is_array($obj_ids) ? array_flip($obj_ids) : array($obj_ids => 0);

		$group_list = $this->get_groups_list();
		$is_main_admin = in_array(GROUP_FOUNDER, $group_list);
		unset($group_list);

		// short way : founder can do everything everywhere
		if ( $is_main_admin && (($auth_type != POST_FORUM_URL) || !isset($auth_names['auth_mod_display'])) )
		{
			return true;
		}

		// unknown auth type
		if ( !isset($this->cache[$auth_type]) || !isset($this->cache[$auth_type]['def']) || !isset($this->cache[$auth_type]['val']) )
		{
			return false;
		}

		// limit posting for bots and guest with ip not solvable
		if ( ($auth_type == POST_FORUM_URL) && (isset($auth_names['auth_post']) || isset($auth_names['auth_reply'])) && ($this->data['session_is_bot'] || (($this->data['user_id'] == ANONYMOUS) && $config->data['guests_proxies_disabled'] && !$this->session->check_host())) )
		{
			return false;
		}

		// check auth for all auths asked and all objects asked
		// auth_idx : cache[auth_type]['def'][auth_name]
		// auth_value : cache[auth_type]['val'][obj_id][auth_idx]
		foreach ( $auth_names as $auth_name => $dummy )
		{
			$auth_value = 0;
			if ( isset($this->cache[$auth_type]['def'][$auth_name]) )
			{
				foreach ( $obj_ids as $obj_id => $dummy )
				{
					if ( isset($this->cache[$auth_type]['val'][$obj_id]) )
					{
						$auth_value = max($auth_value, intval($this->cache[$auth_type]['val'][$obj_id][ $this->cache[$auth_type]['def'][$auth_name] ]));
						if ( $auth_value == FORCE )
						{
							return true;
						}
					}
				}
			}
			if ( in_array($auth_value, array(1, FORCE)) )
			{
				return true;
			}
		}
		return false;
	}

	function img($key)
	{
		global $images, $config;
		return !empty($key) && isset($this->global_images[$key]) ? $config->root . $this->global_images[$key] : (($sub = substr($key, 0, 5)) && (($sub == 'http:') || ($sub == 'ftp:/')) ? $key : $config->root . $key);
	}

	function lang($key)
	{
		return !empty($key) && isset($this->global_lang[$key]) ? $this->global_lang[$key] : $key;
	}

	function img_tpl($key)
	{
		global $template;
		return $template->img($key);
	}

	function img_styled($key)
	{
		global $template;
		return $template->img_styled($key);
	}

	function lang_tpl($key)
	{
		global $template;
		return $template->lang($key);
	}

	function dst_in_action($date)
	{
		return intval($this->data['user_dst']);
	}

	// this one will convert a user timestamp to the system timestamp
	// it can be used to convert an inputed by the user timestamp into the time() generated by the system
	function cvt_user_to_sys_date($user_timestamp)
	{
		if ( empty($user_timestamp) )
		{
			return 0;
		}
		// remove user offset & add server offset
		$dst = $this->data['user_dst'] && $this->dst_in_action($user_timestamp) ? 1 : 0;
		$ii = explode(', ', date('H, i, s, m, d, Y', $user_timestamp - intval((doubleval($this->data['user_timezone']) + $dst) * 3600)));
		return @gmmktime($ii[0], $ii[1], $ii[2], $ii[3], $ii[4], $ii[5]);
	}

	// this one will convert a system timestamp to the user timestamp
	function cvt_sys_to_user_date($sys_timestamp)
	{
		if ( empty($sys_timestamp) )
		{
			return 0;
		}
		// remove server offset & add user offset
		$ii = explode(', ', $this->date($sys_timestamp, 'H, i, s, m, d, Y', false));
		return mktime($ii[0], $ii[1], $ii[2], $ii[3], $ii[4], $ii[5]);
	}

	function date($time=0, $fmt='', $today_yesterday=true)
	{
		global $config;

		// fix parms with default
		$fmt = empty($fmt) ? $this->data['user_dateformat'] : $fmt;
		$time = empty($time) ? time() : $time;

		// get user timezone & dst
		$time_zone = intval(doubleval($this->data['user_timezone']) * 3600);
		$dst = $this->data['user_dst'] && $this->dst_in_action($time) ? 1 : 0;
		$time_zone += $dst * 3600;

		// get date standard format
		$d_day = $time + $time_zone;
		$res = @gmdate($fmt, $d_day);

		// apply today/yesterday choice
		// this one was inspirated by Netclectic's mod "Today at/Yesterday at" : http://www.phpbb.com/phpBB/viewtopic.php?t=158812
		$smart_date = ($config->data['smart_date_over'] || empty($this->data['user_smart_date'])) ? intval($config->data['smart_date']) : (intval($this->data['user_smart_date']) != DENY);
		if ( $today_yesterday && $smart_date )
		{
			// get user current day
			$now = time() + $time_zone;
			$today = @gmmktime(0, 0, 0, @gmdate('m', $now), @gmdate('d', $now), @gmdate('Y', $now));

			// is the d day between user's yesterday and today ?
			if ( ($d_day >= $today - 86400) && ($d_day < $today + 86400) )
			{
				// get new fmt for time and compute
				$hour_cvt = array('h' => 'h:i:s a', 'H' => 'H:i:s', 'g' => 'g:i:s a', 'G' => 'G:i:s');
				$new_fmt = '';
				if ( ($hour = preg_replace('/(.*)?([' . implode('', array_keys($hour_cvt)) . '])(.*)?/s', '\2', $fmt)) )
				{
					$new_fmt = strpos($fmt, 's') === false ? str_replace(':s', '', $hour_cvt[$hour]) : $hour_cvt[$hour];
				}
				$res = empty($new_fmt) ? ($d_day >= $today ? 'Today' : 'Yesterday') : sprintf($this->lang($d_day >= $today ? 'Today_at': 'Yesterday_at'), @gmdate($new_fmt, $time + $time_zone));
			}
		}
		if ( $this->global_lang && isset($this->global_lang['datetime']) && is_array($this->global_lang['datetime']) )
		{
			if ( !isset($this->global_lang['datetime']['Yesterday']) )
			{
				$this->global_lang['datetime']['Yesterday'] = isset($this->global_lang['Yesterday']) ? $this->global_lang['Yesterday'] : 'Yesterday';
				$this->global_lang['datetime']['Today'] = isset($this->global_lang['Today']) ? $this->global_lang['Today'] : 'Today';
			}
			$res = strtr($res, $this->global_lang['datetime']);
		}
		return $res;
	}

	function get_timezone()
	{
		global $lang;

		$dst_in_action = $this->data['user_dst'] && $this->dst_in_action(time() + intval(doubleval($this->data['user_timezone']) * 3600));
		$tz = doubleval($this->data['user_timezone']) + intval($dst_in_action);
		return sprintf($dst_in_action ? $this->lang('UTC_DST') : $this->lang('UTC'), $tz >= 0 ? '+' : '-', abs($tz));
	}

	function get_cookies_setup()
	{
		global $config;

		$keep_unreads = (intval($config->data['keep_unreads']) > 0) && (($this->data['user_keep_unreads'] != DENY) || $config->data['keep_unreads_over']);
		$keep_unreads_db = $keep_unreads && (intval($config->data['keep_unreads']) == KEEP_UNREAD_DB) && $this->data['session_logged_in'];
		$no_cookies = (!$this->data['session_logged_in'] && !intval($config->data['keep_unreads_guests'])) || $this->data['session_is_bot'];
		if ( $no_cookies )
		{
			$keep_unreads = false;
			$keep_unreads_db = false;
		}

		// get the cookies basename per user_id if keep_unread sat
		$user_id = $this->data['session_logged_in'] ? $this->data['user_id'] : '_';
		$base_name = $config->data['cookie_name'] . ( $keep_unreads ? '_' . $user_id : '');

		return array(
			'keep_unreads' => $keep_unreads,
			'keep_unreads_db' => $keep_unreads_db,
			'no_cookies' => $no_cookies,
			'base_name' => $base_name,
			'path' => $config->data['cookie_path'],
			'domain' => $config->data['cookie_domain'],
			'secure' => $config->data['cookie_secure'],
		);
	}

	function read_cookies($mark_type='', $mark_id=0)
	{
		global $db, $forums, $HTTP_COOKIE_VARS;

		// read cookies
		if ( $this->cookies_flag )
		{
			return;
		}

		// init
		$this->cookies = array();
		$this->cookies_flag = true;
		$mark_time = time();
		$mark_last_visit = 0;

		// read setup
		$cookies_setup = $this->get_cookies_setup();
		foreach ( $cookies_setup as $var => $value )
		{
			$$var = $value;
		}
		unset($cookies_setup);

		// we don't keep data in db
		if ( !$keep_unreads_db )
		{
			if ( isset($this->data['group_unread_topics']) )
			{
				unset($this->data['group_unread_topics']);
			}
			if ( isset($this->data['group_unread_date']) )
			{
				unset($this->data['group_unread_date']);
			}
		}

		// no cookies
		if ( $no_cookies )
		{
			return;
		}

		// short way : mark all forums read
		if ( ($mark_type == POST_FORUM_URL) && empty($mark_id) )
		{
			// regular phpBB cookies
			if ( !$keep_unreads )
			{
				$this->cookies = array(
					'f_all' => $mark_time,
					'forums' => array(),
					'topics' => array(),
					'unreads' => array(),
					'f_unreads' => array(),
					'unreads_date' => $mark_time,
				);
			}

			// keeps unread activated
			else
			{
				$this->cookies = array(
					'unreads' => array(),
					'f_unreads' => array(),
					'unreads_date' => $mark_time,
				);
				if ( isset($this->data['group_unread_topics']) )
				{
					unset($this->data['group_unread_topics']);
				}
				if ( isset($this->data['group_unread_date']) )
				{
					unset($this->data['group_unread_date']);
				}
			}
			return $mark_time;
		}

		// 60 days limit
		$floor_time = $mark_time - 5184000;

		// get default unreads & last extraction
		$unreads = array();
		$last_extraction = max($floor_time, ($this->data['session_logged_in'] && intval($this->data['user_lastvisit'])) ? $this->data['user_lastvisit'] : $mark_time - TIME_ONLINE_RANGE);

		// regular phpBB cookies
		if ( !$keep_unreads )
		{
			$this->cookies = array(
				'f_all' => isset($HTTP_COOKIE_VARS[$base_name . '_f_all']) ? intval($HTTP_COOKIE_VARS[$base_name . '_f_all']) : 0,
				'forums' => isset($HTTP_COOKIE_VARS[$base_name . '_f']) ? unserialize($HTTP_COOKIE_VARS[$base_name . '_f']) : array(),
				'topics' => isset($HTTP_COOKIE_VARS[$base_name . '_t']) ? unserialize($HTTP_COOKIE_VARS[$base_name . '_t']) : array(),
			);
		}

		// keep unreads activated
		else
		{
			// get unreaded topic_ids and the last extraction date if it is greater than the floor time
			if ( $keep_unreads_db )
			{
				if ( intval($this->data['group_unread_date']) >= $floor_time )
				{
					$unreads = empty($this->data['group_unread_topics']) ? array() : unserialize($this->data['group_unread_topics']);
					$last_extraction = intval($this->data['group_unread_date']);
				}

				// reclaim some memory
				if ( isset($this->data['group_unread_topics']) )
				{
					unset($this->data['group_unread_topics']);
				}
				if ( isset($this->data['group_unread_date']) )
				{
					unset($this->data['group_unread_date']);
				}
			}
			else
			{
				if ( intval($HTTP_COOKIE_VARS[$base_name . '_t_ud']) >= $floor_time )
				{
					$unreads = empty($HTTP_COOKIE_VARS[$base_name . '_t_u']) ? array() : unserialize($HTTP_COOKIE_VARS[$base_name . '_t_u']);
					$last_extraction = intval($HTTP_COOKIE_VARS[$base_name . '_t_ud']);
				}
			}

			// let's go
			$tmp = array();
			if ( !empty($unreads) && is_array($unreads) )
			{
				// get floor topic id & time
				$floor_topic = isset($unreads[-1]) && (intval($unreads[-1]) >= 0) ? intval($unreads[-1]) : 0;
				$floor_time = isset($unreads[0]) && (intval($unreads[0]) >= 0) ? intval($unreads[0]) : 0;

				// re-add floor_time to topic_time for each topic_id
				$tmp = array();
				foreach( $unreads as $topic_id => $topic_time )
				{
					if ( (intval($topic_id) > 0) && (intval($topic_id) + $floor_topic > 0) && (intval($topic_time) + $floor_time > 0) )
					{
						$tmp[ intval($topic_id) + $floor_topic ] = intval($topic_time) + $floor_time;
					}
				}
			}
			$unreads = $tmp;
			unset($tmp);
		}

		// mark a forum with or without subs
		$except_min_idx = -1;
		$except_max_idx = -1;
		if ( in_array($mark_type, array(POST_FORUM_URL, POST_TOPIC_URL)) && isset($forums->data[$mark_id]) )
		{
			$tkeys = empty($forums->keys) ? array() : array_flip($forums->keys);
			$except_min_idx = $tkeys[$mark_id];
			$except_max_idx = ($mark_type == POST_TOPIC_URL) ? $tkeys[$mark_id] : $tkeys[ $forums->data[$mark_id]['last_child_id'] ];
			unset($tkeys);
		}

		// get authorised forums, without the ones to mark read if any
		$forum_ids = array();
		$count_keys = count($forums->keys);
		for ( $i = 0; $i < $count_keys; $i++ )
		{
			if ( ($except_min_idx == -1) || ($i < $except_min_idx) || ($i > $except_max_idx) )
			{
				if ( !isset($this->cache[POST_FORUM_URL]) )
				{
					$this->get_cache(POST_FORUM_URL);
				}
				if ( $this->auth(POST_FORUM_URL, 'auth_read', $forums->keys[$i]) )
				{
					$forum_ids[] = $forums->keys[$i];
				}
			}

			// regular phpBB cookies : mark a forum
			else if ( !$keep_unreads )
			{
				$this->cookies['forums'][ $forums->keys[$i] ] = $mark_time;
			}
		}

		// get unreads topics
		$this->cookies['unreads'] = $this->cookies['f_unreads'] = array();
		$this->cookies['unreads_date'] = $mark_time;
		if ( empty($forum_ids) )
		{
			// regular phpBB cookies
			if ( !$keep_unreads )
			{
				$this->cookies = array(
					'f_all' => $mark_time,
					'forums' => array(),
					'topics' => array(),
					'unreads' => array(),
					'f_unreads' => array(),
					'unreads_date' => $mark_time,
				);
			}
			return $mark_time;
		}

		$count_pass = $keep_unreads ? 2 : 1;
		$limit = $keep_unreads_db ? MAX_UNREADS_DB : MAX_UNREADS_COOKIES;
		for ( $i = 0; $i < $count_pass; $i++ )
		{
			if ( !$i )
			{
				// read topics moved
				$sql = 'SELECT topic_id, forum_id, topic_last_time
							FROM ' . TOPICS_TABLE . '
							WHERE topic_moved_id = 0
								AND forum_id IN(' . implode(', ', $forum_ids) . ')
								AND topic_last_time > ' . intval($last_extraction) . '
							ORDER BY topic_last_time DESC
							LIMIT ' . $limit;
			}
			else
			{
				// read remaining unread topics
				$sql = 'SELECT topic_id, forum_id, topic_last_time
							FROM ' . TOPICS_TABLE . '
							WHERE topic_moved_id = 0
								AND forum_id IN(' . implode(', ', $forum_ids) . ')
								AND topic_id IN(' . implode(', ', array_keys($unreads)) . ')
							ORDER BY topic_last_time DESC
							LIMIT ' . $limit;
			}
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				// regular phpBB cookies
				if ( !$keep_unreads )
				{
					if ( !($topic_last_visit = max(intval($this->cookies['f_all']), intval($this->cookies['forums'][ $row['forum_id'] ]), intval($this->cookies['topics'][ $row['topic_id'] ]))) )
					{
						$topic_last_visit = $last_extraction;
					}
					if ( $topic_last_visit >= $row['topic_last_time'] )
					{
						continue;
					}
				}

				// keep unreads activated
				else
				{
					$unread_time = 0;
					if ( isset($unreads[ $row['topic_id'] ]) )
					{
						$unread_time = intval($unreads[ $row['topic_id'] ]);
						unset($unreads[ $row['topic_id'] ]);
					}
					// some posts may have been deleted, making the unread mark no more valid, so the topic should not be retained
					if ( ($unread_time > $row['topic_last_time']) && ($row['topic_last_time'] < $last_extraction) )
					{
						continue;
					}
					$topic_last_visit = $unread_time ? $unread_time : $last_extraction;
				}

				// we are marking a topic : return the previous last visit and skip it from the unreads array
				if ( ($mark_type == POST_POST_URL) && ($row['topic_id'] == $mark_id) )
				{
					// regular phpBB cookies : add a cooky for this topic
					if ( !$keep_unreads )
					{
						$this->cookies['topics'][ $row['topic_id'] ] = $mark_time;
					}
					$mark_last_visit = $topic_last_visit;
					continue;
				}

				// store it
				$this->cookies['unreads'][ $row['topic_id'] ] = $topic_last_visit;
				$this->cookies['f_unreads'][ $row['forum_id'] ] = true;
			}
			$db->sql_freeresult($result);

			// check if we can/have to add unreaded topics to the new ones
			if ( !($limit = !$i && $keep_unreads && ($count_unreads = count($unreads)) ? max(0, min($limit - count($this->cookies['unreads']), $count_unreads)) : 0) )
			{
				break;
			}
		}
		return $mark_last_visit;
	}

	function write_cookies()
	{
		global $db, $HTTP_COOKIE_VARS;

		// cookies not readed : read them
		if ( !$this->cookies_flag )
		{
			$this->read_cookies();
		}

		// read setup
		$cookies_setup = $this->get_cookies_setup();
		foreach ( $cookies_setup as $var => $value )
		{
			$$var = $value;
		}
		unset($cookies_setup);

		// no cookies
		if ( $no_cookies )
		{
			return;
		}

		// regular phpBB cookies
		if ( !$keep_unreads )
		{
			// maximize the topics cooky
			if ( $count_cookies = count($this->cookies['topics']) )
			{
				arsort($this->cookies['topics']);
				if ( $count_cookies > MAX_UNREADS_COOKIES )
				{
					array_splice($this->cookies['topics'], MAX_UNREADS_COOKIES + 1);
				}
			}

			// cookie duration : session
			setcookie($base_name . '_f_all', intval($this->cookies['f_all']), 0, $path, $domain, $secure);
			setcookie($base_name . '_f', serialize($this->cookies['forums']), 0, $path, $domain, $secure);
			setcookie($base_name . '_t', serialize($this->cookies['topics']), 0, $path, $domain, $secure);
		}

		// keep unreads
		else
		{
			if ( $count_cookies = count($this->cookies['unreads']) )
			{
				// maximize the array
				$max_unreads = $keep_unreads_db ? MAX_UNREADS_DB : MAX_UNREADS_COOKIES;
				if ( $count_cookies > $max_unreads )
				{
					arsort($this->cookies['unreads']);
					array_splice($this->cookies['unreads'], $max_unreads + 1);
				}

				// get floor time
				asort($this->cookies['unreads']);
				reset($this->cookies['unreads']);
				list(, $floor_time) = @each($this->cookies['unreads']);

				// get floor topic id
				$tmp = $this->cookies['unreads'];
				ksort($tmp);
				reset($tmp);
				list($floor_topic, ) = @each($tmp);
				unset($tmp);
				$floor_topic--;

				// substract the lower time & topic to reduce the cookie size
				$tmp = array(-1 => $floor_topic, 0 => $floor_time);
				foreach ( $this->cookies['unreads'] as $topic_id => $topic_time )
				{
					$tmp[ ($topic_id - $floor_topic) ] = $topic_time - $floor_time;
				}
			}
			else
			{
				$tmp = array();
			}

			// finaly, output the value
			if ( $keep_unreads_db )
			{
				// update users table
				$sql = 'UPDATE ' . GROUPS_TABLE . '
							SET group_unread_topics = ' . (empty($tmp) ? '\'\'' : '\'' . $db->sql_escape_string(serialize($tmp)) . '\'') . ',
								group_unread_date = ' . intval($this->cookies['unreads_date']) . '
							WHERE group_id = ' . intval($this->data['group_id']);
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
			else
			{
				setcookie($base_name . '_t_u', serialize($tmp), $one_year, $path, $domain, $secure);
				setcookie($base_name . '_t_ud', intval($this->cookies['unreads_date']), $one_year, $path, $domain, $secure);
			}
			unset($tmp);
		}
	}

	function insert($fields)
	{
		global $db, $config, $forums;

		$this->read(ANONYMOUS);
		$this->overwrite_anonymous_values();
		foreach( $this->data as $key => $val )
		{
			if ( !is_string($key) )
			{
				unset($this->data[$key]);
			}
			if ( substr($key, 0, strlen('user')) != 'user' )
			{
				unset($this->data[$key]);
			}
		}
		unset($this->data['user_id']);

		// get last user id
		$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					ORDER BY user_id DESC
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$user_id = max(3, intval($row['user_id']) + 1);
		$this->data['user_id'] = $user_id;

		// enhance fields
		$this->data = array_merge($this->data, $fields);
		unset($fields);
		$sql = 'INSERT INTO ' . USERS_TABLE . '
					(' . $db->sql_fields('fields', $this->data) . ') VALUES(' . $db->sql_fields('values', $this->data) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// create individual group
		$this->create_individual();

		// recache the last user stats
		$this->read_stats(true);

		// recache moderators
		if ( !class_exists('moderators') )
		{
			include($config->url('includes/class_forums'));
		}
		$moderators = new moderators();
		$moderators->read(true);
		unset($moderators);

		// recache bots
		if ( !empty($this->data['user_bot_agent']) || !empty($this->data['user_bot_ips']) )
		{
			$bots = new bots();
			$bots->read(true);
			unset($bots);
		}

		return $user_id;
	}

	function delete($user_ids=false)
	{
		global $db, $config, $forums;

		if ( $user_ids === false )
		{
			$user_ids = intval($this->data['user_id']);
		}
		if ( !is_array($user_ids) && intval($user_ids) && (intval($user_ids) != ANONYMOUS) )
		{
			$user_ids = array($user_ids);
		}
		if ( !$user_ids )
		{
			return;
		}

		// get plug ins if any
		if ( !$this->plug_ins_done && ($this->plug_ins_done = true) )
		{
			$plug_ins = new plug_ins();
			$plug_ins->load('class_users');
			unset($plug_ins);
			$this->plug_ins = &$config->plug_ins['class_users'];
		}

		// process plugs
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'remove_users') )
				{
					$this->plug_ins[$plug]->remove_users($user_ids);
				}
			}
		}

		// do not allow anonymous, founder or admin users to be deleted
		$sql = 'SELECT DISTINCT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id IN(' . implode(', ', array(GROUP_FOUNDER, GROUP_ADMIN, GROUP_ANONYMOUS)) . ')
						AND user_id IN(' . implode(', ', $user_ids) . ')
						AND user_pending <> 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);
		$user_ids = array_flip($user_ids);
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( isset($user_ids[intval($row['user_id'])]) )
			{
				unset($user_ids[intval($row['user_id'])]);
			}
		}
		$db->sql_freeresult($result);
		if ( empty($user_ids) )
		{
			return false;
		}

		// prepare username
		foreach ( $user_ids as $user_id => $dummy )
		{
			$user_ids[$user_id] = '';
		}

		// get username
		$sql = 'SELECT user_id, username
					FROM ' . USERS_TABLE . '
					WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$user_ids[ intval($row['user_id']) ] = $row['username'];
		}
		$db->sql_freeresult($result);

		// update posts
		foreach ( $user_ids as $user_id => $username )
		{
			// posts
			$fields = array(
				'poster_id' => DELETED,
				'post_username' => $username,
			);
			$db->sql_statement($fields);
			$sql = 'UPDATE ' . POSTS_TABLE . '
						SET ' . $db->sql_update . '
						WHERE poster_id = ' . intval($user_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// topics : first post
			$fields = array(
				'topic_poster' => DELETED,
				'topic_first_username' => $username,
			);
			$db->sql_statement($fields);
			$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET ' . $db->sql_update . '
						WHERE topic_poster = ' . intval($user_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// topics : last post
			$fields = array(
				'topic_last_poster' => DELETED,
				'topic_last_username' => $username,
			);
			$db->sql_statement($fields);
			$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET ' . $db->sql_update . '
						WHERE topic_last_poster = ' . intval($user_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// forums table
			$fields = array(
				'forum_last_poster' => DELETED,
				'forum_last_username' => $username,
			);
			$db->sql_statement($fields);
			$sql = 'UPDATE ' . FORUMS_TABLE . '
						SET ' . $db->sql_update . '
						WHERE forum_last_poster = ' . intval($user_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// votes table
		$sql = 'UPDATE ' . VOTE_USERS_TABLE . '
					SET vote_user_id = ' .  DELETED . '
					WHERE vote_user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// watch table
		$sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . '
					WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// ban list
		$sql = 'DELETE FROM ' . BANLIST_TABLE . '
					WHERE ban_userid IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// private message texts
		$sql = 'DELETE FROM ' . PRIVMSGS_TEXT_TABLE . '
					WHERE privmsgs_text_id IN(' . $db->sql_subquery('privmsgs_id', '
							SELECT DISTINCT privmsgs_id
								FROM ' . PRIVMSGS_TABLE . '
								WHERE privmsgs_from_userid IN(' . implode(', ', array_keys($user_ids)) . ')
									OR privmsgs_to_userid IN(' . implode(', ', array_keys($user_ids)) . ')
						', __LINE__, __FILE__) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// private message headers
		$sql = 'DELETE FROM ' . PRIVMSGS_TABLE . '
					WHERE privmsgs_from_userid IN(' . implode(', ', array_keys($user_ids)) . ')
						OR privmsgs_to_userid IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// get group_ids
		$sql = 'SELECT group_id
					FROM ' . GROUPS_TABLE . '
					WHERE group_user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);
		$group_ids = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$group_ids[] = intval($row['group_id']);
		}
		$db->sql_freeresult($result);

		if ( !empty($group_ids) )
		{
			// individual
			$sql = 'DELETE FROM ' . GROUPS_TABLE . '
						WHERE group_id IN(' . implode(', ', $group_ids) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);

			// delete cache of users having auths against this user
			$sql = 'SELECT DISTINCT user_id
						FROM ' . USER_GROUP_TABLE . '
						WHERE user_pending <> 1
							AND group_id IN(' . $db->sql_subquery('group_id', '
								SELECT DISTINCT group_id
									FROM ' . AUTHS_TABLE . '
									WHERE obj_type = \'' . POST_GROUPS_URL . '\'
										AND obj_id IN(' . implode(', ', $group_ids) . ')
							', __LINE__, __FILE__) . ')';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
			$wuser_ids = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$wuser_ids[] = intval($row['user_id']);
			}
			$db->sql_freeresult($result);

			if ( !empty($wuser_ids) )
			{
				$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
							WHERE user_id IN(' . implode(', ', $wuser_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
			}
			unset($wuser_ids);

			// delete auths
			$sql = 'DELETE FROM ' . AUTHS_TABLE . '
						WHERE group_id IN(' . implode(', ', $group_ids) . ')
							OR (obj_type = \'' . POST_GROUPS_URL . '\' AND obj_id IN(' . implode(', ', $group_ids) . '))';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
		}
		unset($group_ids);

		// delete memberships
		$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
					WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// replace the group moderators
		$sql = 'UPDATE ' . GROUPS_TABLE . '
					SET group_moderator = 0
					WHERE group_moderator IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// delete sessions & sessions keys
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
					WHERE session_user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
					WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);

		// finaly, delete the user
		$sql = 'DELETE FROM ' . USERS_TABLE . '
					WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		unset($user_ids);
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($sql);
		$count_user_ids = $db->sql_affectedrows();

		// recache the last user stats
		$this->read_stats(true);

		// recache moderators
		if ( !class_exists('moderators') )
		{
			include($config->url('includes/class_forums'));
		}
		$moderators = new moderators();
		$moderators->read(true);
		unset($moderators);

		// recache bots
		$bots = new bots();
		$bots->read(true);
		unset($bots);

		return $count_user_ids;
	}

	function read_stats($force=true)
	{
		global $config, $db;

		if ( $force || empty($config->data['stat_last_user']) )
		{
			// count users
			$sql = 'SELECT COUNT(user_id) AS count_user_id
						FROM ' . USERS_TABLE;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$count_users = ($row = $db->sql_fetchrow($result)) ? max(0, intval($row['count_user_id']) -1) : 0;
			$db->sql_freeresult($result);

			// update last user stats
			if ( $count_users )
			{
				$sql = 'SELECT user_id, username
							FROM ' . USERS_TABLE . '
							WHERE user_id <> ' . ANONYMOUS . '
							ORDER BY user_id DESC
							LIMIT 1';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
			}

			$config->begin_transaction();
			$config->set('stat_total_users', $count_users);
			$config->set('stat_last_user', $count_users ? intval($row['user_id']) : 0);
			$config->set('stat_last_username', $count_users ? $row['username'] : '');
			$config->end_transaction();
		}
		return array('user_id' => intval($config->data['stat_last_user']), 'username' => $config->data['stat_last_username']);
	}
}

class cache_bots extends cache
{
	var $group_bots;

	function cache_bots($cache_file='', $cache_path='', $cache_disabled=false, $group_bots=0)
	{
		$this->group_bots = empty($group_bots) ? GROUP_BOTS : $group_bots;

		parent::cache($cache_file, $cache_path, $cache_disabled);
	}

	// read or create the cache and return the data
	function sql_query($query='', $line='', $file='', $force=false)
	{
		global $db, $config;

		// try with the cache
		$gentime = 0;
		$data = array();
		$this->cache_disabled |= empty($config->data['cache_key']);
		if ( !$force && !$this->cache_disabled )
		{
			$query_beg = microtime();
			if ( ($filename = $config->url($this->cache_path . $this->cache_file)) && file_exists(phpbb_realpath($filename)) )
			{
				include($filename);
			}
			if ( !empty($gentime) && ($cache_key == $config->data['cache_key']) )
			{
				$query_end = microtime();
				if ( defined('DEBUG_SQL') )
				{
					$db->trc_sql[] = array('file' => empty($file) ? '?' : basename($file), 'line' => $line, 'sql' => $query, 'start' => $query_beg, 'end' => $query_end, 'after_debug' => microtime(), 'cached' => true);
				}
				else
				{
					$db->trc_sql[] = array('start' => $query_beg, 'end' => $query_end, 'after_debug' => microtime(), 'cached' => true);
				}
			}
			else
			{
				$gentime = 0;
			}
		}
		$this->from_cache = !empty($gentime);
		$this->data_time = $gentime;

		// no data : read tables
		if ( !$this->from_cache )
		{
			$data = array();
			$this->data_time = 0;
			if ( !$force )
			{
				$sql = 'SELECT bot_id, bot_agent, bot_ips
							FROM ' . BOTS_TABLE . '
							ORDER BY bot_agent DESC, bot_ips';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$this->data_time = time();
				while ( $row = $db->sql_fetchrow($result) )
				{
					$data[ $row['bot_id'] ] = array(
						'bot_agent' => $row['bot_agent'],
						'bot_ips' => $row['bot_ips'],
					);
				}
				$db->sql_freeresult($result);
			}

			if ( empty($data) && empty($this->data_time) )
			{
				// rebuild the bots table from the users table
				$sql = 'TRUNCATE TABLE ' . BOTS_TABLE;
				$db->sql_query($sql, false, __LINE__, __FILE__);

				$sql = 'SELECT user_id, user_bot_agent, user_bot_ips
							FROM ' . USERS_TABLE . '
							WHERE user_id <> ' . ANONYMOUS . '
								AND ((user_bot_agent <> \'\' AND user_bot_agent IS NOT NULL) OR (user_bot_ips <> \'\' AND user_bot_ips IS NOT NULL))';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$this->data_time = time();
				$data = array();
				$db->sql_stack_reset();
				while ( $row = $db->sql_fetchrow($result) )
				{
					$fields = array(
						'bot_id' => intval($row['user_id']),
						'bot_agent' => $row['user_bot_agent'],
						'bot_ips' => $row['user_bot_ips'],
					);
					$data[ $fields['bot_id'] ] = $fields;
					$db->sql_stack_statement($fields);
				}
				$db->sql_freeresult($result);
				$db->sql_stack_insert(BOTS_TABLE, false, __LINE__, __FILE__);

				// get the group bot style
				$sql = 'SELECT group_style
							FROM ' . GROUPS_TABLE . '
							WHERE group_id = ' . intval($this->group_bots);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);
				$group_style = intval($row['group_style']);

				// get the current members that won't be part of the GROUP BOTS
				$sql = 'SELECT user_id
							FROM ' . USER_GROUP_TABLE . '
							WHERE group_id = ' . intval($this->group_bots) . (empty($data) ? '' : '
								AND user_id NOT IN(' . implode(', ', array_keys($data)) . ')');
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$user_ids = array();
				while ( $row = $db->sql_fetchrow($result) )
				{
					$user_ids[] = intval($row['user_id']);
				}
				$db->sql_freeresult($result);

				// remove style if any
				if ( intval($group_style) && !empty($user_ids) )
				{
					$sql = 'UPDATE ' . GROUPS_TABLE . '
								SET group_style = 0
								WHERE group_user_id IN(' . implode(', ', $user_ids) . ')
									AND group_style = ' . $group_style;
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}

				// drop membership
				$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
							WHERE group_id = ' . $this->group_bots;
				$db->sql_query($sql, false, __LINE__, __FILE__);

				// recreate membership
				if ( !empty($data) )
				{
					$db->sql_stack_reset();
					foreach ($data as $user_id => $dummy )
					{
						$fields = array(
							'group_id' => intval($this->group_bots),
							'user_id' => intval($user_id),
							'user_pending' => 0,
						);
						$db->sql_stack_statement($fields);
					}
					$db->sql_stack_insert(USER_GROUP_TABLE, false, __LINE__, __FILE__);
				}

				// update style for the remaining users
				if ( $group_style && !empty($data) )
				{
					$sql = 'UPDATE ' . GROUPS_TABLE . '
								SET group_style = ' . intval($group_style) . '
								WHERE group_style = 0
									AND group_user_id IN(' . implode(', ', array_keys($data)) . ')';
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}

				// and finally force recache for these users
				if ( !empty($data) || !empty($user_ids) )
				{
					$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
								WHERE user_id IN(' . implode(', ', array_merge(array_keys($data), $user_ids)) . ')';
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
			}

			// write cache
			if ( !$this->cache_disabled )
			{
				$this->write_cache($data, $query);
			}
		}
		return $data;
	}
}

class bots
{
	var $requester;
	var $group_bots;
	var $data;
	var $data_flag;

	function bots($requester='', $group_bots=0)
	{
		$this->requester = $requester;
		$this->group_bots = intval($group_bots) ? intval($group_bots) : GROUP_BOTS;
		$this->data = array();
		$this->data_flag = false;
	}

	function read($force=false)
	{
		global $config;

		if ( !$force && $this->data_flag )
		{
			return $this->data;
		}
		if ( empty($this->group_bots) )
		{
			return false;
		}
		$db_cached = new cache_bots('dta_bots', $config->data['cache_path'], $config->data['cache_disabled_bots'], $this->group_bots);
		$sql = 'SELECT bot_id, bot_agent, bot_ips
					FROM ' . BOTS_TABLE;
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force);
		$this->data_flag = true;
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;

		return $this->data;
	}

	function get_ip()
	{
		global $HTTP_SERVER_VARS, $HTTP_ENV_VARS;
		return encode_ip(!empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : (!empty($HTTP_ENV_VARS['REMOTE_ADDR']) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR')));
	}

	function get_agent()
	{
		global $HTTP_SERVER_VARS;
		return trim(strtolower(!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT']) ? stripslashes($HTTP_SERVER_VARS['HTTP_USER_AGENT']) : getenv('HTTP_USER_AGENT')));
	}

	function identify($user_ip='', $user_agent='')
	{
		if ( !$this->data_flag )
		{
			$this->read();
		}
		$user_ip = empty($user_ip) ? $this->get_ip() : $user_ip;
		$user_agent = empty($user_agent) ? $this->get_agent() : $user_agent;
		if ( !empty($this->data) && (!empty($user_agent) || !empty($user_ip)) )
		{
			foreach ( $this->data as $bot_id => $data )
			{
				if ( !empty($data['bot_agent']) && !empty($user_agent) && strpos(' ' . $user_agent, strtolower($data['bot_agent'])) )
				{
					return $bot_id;
				}
				if ( !empty($data['bot_ips']) )
				{
					$bot_ips = explode(',', $data['bot_ips']);
					$count_bot_ips = count($bot_ips);
					for ( $i = 0; $i < $count_bot_ips; $i++ )
					{
						if ( substr($user_ip, 0, strlen($bot_ips[$i])) == $bot_ips[$i] )
						{
							return $bot_id;
						}
					}
				}
			}
		}
		return false;
	}
}

// group class
class groups
{
	var $data;

	function groups()
	{
		$this->data = array();
	}

	// here we expect $groups[$group_id] = something
	function read(&$groups)
	{
		global $db;
		global $special_groups;

		$this->data = array();
		if ( empty($groups) )
		{
			return;
		}

		$w_groups = array();
		foreach ( $groups as $group_id => $group_data )
		{
			$w_groups[ intval($group_id) ] = $group_data;
		}
		$groups = $w_groups;

		// read special groups
		foreach ( $special_groups as $group_id => $group_data )
		{
			if ( isset($groups[ intval($group_id) ]) )
			{
				$this->data[ intval($group_id) ] = $group_data;
			}
		}

		// read other groups
		$sql = 'SELECT g.group_id, g.group_status, g.group_name, g.group_description, g.group_single_user, u.user_id, u.username, u.user_level
					FROM ' . GROUPS_TABLE . ' g
						LEFT JOIN ' . USERS_TABLE . ' u
							ON u.user_id = g.group_user_id
					WHERE g.group_id IN(' . implode(', ', array_keys($groups)) . ')
					ORDER BY g.group_status DESC, u.username, g.group_name';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$fields = array(
				'group_status' => $row['group_status'],
				'group_name' => $row['group_name'],
				'group_description' => $row['group_description'],
			);
			if ( $row['group_single_user'] && !empty($row['user_id']) )
			{
				$fields += array(
					'group_single_user' => true,
					'user_id' => intval($row['user_id']),
					'username' => $row['username'],
					'user_level' => $row['user_level'],
				);
			}
			else
			{
				$fields += array(
					'group_single_user' => false,
				);
			}
			$this->data[ intval($row['group_id']) ] = $fields;
		}
		$db->sql_freeresult($result);
	}

	function clear_cache($cache_id)
	{
		global $db;
		global $special_groups;

		$all = isset($this->data[GROUP_REGISTERED]);
		if ( !$all && !empty($special_groups) )
		{
			foreach ( $special_groups as $group_id => $group_data )
			{
				if ( $all = isset($this->data[$group_id]) )
				{
					break;
				}
			}
		}

		// registered and special groups cover everybody
		if ( $all )
		{
			$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
						WHERE cache_id = \'' . $cache_id . '\'';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// delete cache from all users belonging to the selected groups
		else if ( !empty($this->data) )
		{
			$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
						WHERE cache_id LIKE \'' . $cache_id . '%\'
							AND user_id IN(' . $db->sql_subquery('user_id', '
								SELECT DISTINCT user_id
									FROM ' . USER_GROUP_TABLE . '
									WHERE group_id IN(' . implode(', ', array_keys($this->data)) . ')
										AND user_pending <> 1
							', __LINE__, __FILE__) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}
}

class auth_class
{
	var $data;
	var $keys;

	function read($force=false)
	{
		global $db;

		$sql = 'SELECT *
					FROM ' . AUTHS_DEF_TABLE . '
					ORDER BY auth_type, auth_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->data = array();
		$this->keys = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->data[ $row['auth_id'] ] = $row;
			if ( empty($this->keys[ $row['auth_type'] ]) )
			{
				$this->keys[ $row['auth_type'] ] = array();
			}
			$this->keys[ $row['auth_type'] ][ $row['auth_name'] ] = $row['auth_id'];
		}
		$db->sql_freeresult($result);
	}

	function renum()
	{
		global $db;

		// re-read
		$sql = 'SELECT *
					FROM ' . AUTHS_DEF_TABLE . '
					ORDER BY auth_type, auth_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->data = array();
		$this->keys = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->data[ $row['auth_id'] ] = $row;
			if ( empty($this->keys[ $row['auth_type'] ]) )
			{
				$this->keys[ $row['auth_type'] ] = array();
			}
			$this->keys[ $row['auth_type'] ][ $row['auth_name'] ] = $row['auth_id'];
		}
		$db->sql_freeresult($result);

		// renum all
		if ( !empty($this->keys) )
		{
			foreach ( $this->keys as $auth_type => $auth_names )
			{
				$order = 0;
				if ( !empty($auth_names) )
				{
					foreach ( $auth_names as $auth_name => $auth_id )
					{
						$order += 10;
						$sql = 'UPDATE ' . AUTHS_DEF_TABLE . '
									SET auth_order = ' . intval($order) . '
									WHERE auth_id = ' . intval($auth_id);
						$db->sql_query($sql, false, __LINE__, __FILE__);
					}
				}
			}
		}

		// regenerate the cache if any
		$this->read(true);
	}

	function get(&$view_user, $types, &$cache, &$cache_time)
	{
		global $db;

		// time marker
		$now = time();

		// get groups the user belongs too
		$group_ids = $view_user->get_groups_list();
		if ( empty($group_ids) )
		{
			return array();
		}

		// read auths
		$sql = 'SELECT obj_type, obj_id, auth_name, MAX(auth_value) AS auth_solved
					FROM ' . AUTHS_TABLE . '
					WHERE ' . (count($group_ids) == 1 ? 'group_id = ' . intval($group_ids[0]) : 'group_id IN(' . implode(', ', $group_ids) . ')') . '
						AND ' . (count($types) == 1 ? 'obj_type = \'' . $types[0] . '\'' : 'obj_type IN(\'' . implode('\', \'', $types) . '\')') . '
					GROUP BY obj_type, obj_id, auth_name';
		unset($group_ids);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$auth_defs = array();
		$auth_vals = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['auth_solved'] > 0 )
			{
				$obj_type = $row['obj_type'];
				$obj_id = intval($row['obj_id']);
				$auth_name = $row['auth_name'];

				// main init
				if ( !isset($auth_defs[$obj_type]) )
				{
					$auth_defs[$obj_type] = array();
					$auth_vals[$obj_type] = array();
				}

				// add auth defs if required
				if ( !isset($auth_defs[$obj_type][$auth_name]) )
				{
					$auth_defs[$obj_type][$auth_name] = count($auth_defs[$obj_type]);
				}
				$auth_id = intval($auth_defs[$obj_type][$auth_name]);

				// init obj auths
				if ( !isset($auth_vals[$obj_type][$obj_id]) )
				{
					$auth_vals[$obj_type][$obj_id] = array();
				}

				// store auth value
				$auth_vals[$obj_type][$obj_id][$auth_id] = $row['auth_solved'];
			}
		}
		$db->sql_freeresult($result);

		// force root forum to be viewed and readed
		if ( in_array(POST_FORUM_URL, $types) )
		{
			if ( !isset($auth_defs[POST_FORUM_URL]) )
			{
				$auth_defs[POST_FORUM_URL] = array();
				$auth_vals[POST_FORUM_URL] = array();
			}
			if ( !isset($auth_values[POST_FORUM_URL][0]) )
			{
				$auth_values[POST_FORUM_URL][0] = array();
			}

			// view
			if ( !isset($auth_defs[POST_FORUM_URL]['auth_view']) )
			{
				$auth_defs[POST_FORUM_URL]['auth_view'] = count($auth_defs[POST_FORUM_URL]);
			}
			$auth_id = intval($auth_defs[POST_FORUM_URL]['auth_view']);
			$auth_vals[POST_FORUM_URL][0][$auth_id] = true;

			// read
			if ( !isset($auth_defs[POST_FORUM_URL]['auth_read']) )
			{
				$auth_defs[POST_FORUM_URL]['auth_read'] = count($auth_defs[POST_FORUM_URL]);
			}
			$auth_id = intval($auth_defs[POST_FORUM_URL]['auth_read']);
			$auth_vals[POST_FORUM_URL][0][$auth_id] = true;
		}

		// fill the caches
		$count_types = count($types);
		for ( $i = 0; $i < $count_types; $i++ )
		{
			$cache_time[ $types[$i] ] = $now;
			$cache[ $types[$i] ] = empty($auth_defs[ $types[$i] ]) ? array() : array('def' => $auth_defs[ $types[$i] ], 'val' => $auth_vals[ $types[$i] ]);
		}
		return $types;
	}
}

// init
$user = new user();
$themes = new themes();

?>