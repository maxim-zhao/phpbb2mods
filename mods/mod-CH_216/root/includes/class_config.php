<?php
//
//	file: includes/class_config.php
//	author: ptirhiik
//	begin: 25/08/2004
//	version: 1.6.9 - 20/10/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}
// init the randomizer
mt_srand( (double) microtime() * 1000000);

//--------------
// debug
// I strongly recommand to let those lines commented 
// and to uncomment them only at debug purpose
//--------------
define('DEBUG_RUN_STATS', true); // uncomment this line to see the run stats
// define('DEBUG_MEMORY', true); // uncomment this line to get the memory usage (php 5.2)
// define('DEBUG_SQL', true); // uncomment this line to see the sql dump
// define('DEBUG_SQL_ADMIN', true); // uncomment this line to see the sql dump in admin
// define('DEBUG_MESSAGES', true); // uncomment this line to dump who has sent an information messages
// define('DEBUG_TEMPLATE', true); // uncomment this line to add a comment with the tpl name
//--------------

define('CH_CURRENT_VERSION', '2.1.6g');

// index
define('INDEX', 'index');
define('POSTING', 'posting');

// temp dir name
define('TMP_PATH', '/tmp');

// tables
define('USERS_CACHE_TABLE', $table_prefix . 'users_cache');
define('PRESETS_TABLE', $table_prefix . 'presets');
define('PRESETS_DATA_TABLE', $table_prefix . 'presets_data');
define('ICONS_TABLE', $table_prefix . 'icons');
define('CP_PATCHES_TABLE', $table_prefix . 'cp_patches');
define('CP_PANELS_TABLE', $table_prefix . 'cp_panels');
define('CP_FIELDS_TABLE', $table_prefix . 'cp_fields');
define('AUTHS_TABLE', $table_prefix . 'auths');
define('AUTHS_DEF_TABLE', $table_prefix . 'auths_def');
define('TOPICS_ATTR_TABLE', $table_prefix . 'topics_attr');
define('BOTS_TABLE', $table_prefix . 'bots');
define('STATS_VISIT_TABLE', $table_prefix . 'stats_visit');
define('HOSTADDR_TABLE', $table_prefix . 'hostaddr');
define('INSTSQL_TABLE', $table_prefix . 'instsql');

define('POST_AUTHS_URL', 'atype');
define('POST_FIELDS_URL', 'd');
define('POST_PANELS_URL', 'm');
define('POST_LINK_URL', 'l');

// special group
define('GROUP_OWN', -3);
define('GROUP_ALL', -4);
define('GROUP_FRIENDS', -5);
define('GROUP_FOES', -6);

// define group status
define('GROUP_STANDARD', 0);
define('GROUP_SYSTEM', 3);
define('GROUP_SPECIAL', 5);

// data type
define('TYPE_INT', 1);
define('TYPE_NO_HTML', 2);
define('TYPE_FLOAT', 4);
define('TYPE_HTML', 5);

// tree drawing
define('TREE_HSPACE', 'H');
define('TREE_VSPACE', 'V');
define('TREE_CROSS', 'X');
define('TREE_CLOSE', 'C');

// 3- & 4- boolean
define('DENY', 2);
define('FORCE', 4);

// keep unread
define('KEEP_UNREAD_DB', 2);

// board announces
define('BOARD_GLOBAL_ANNOUNCES', 1);
define('BOARD_PARENT_ANNOUNCES', 2);
define('BOARD_CHILD_ANNOUNCES', 3);
define('BOARD_BRANCH_ANNOUNCES', 4);

// global announces split title only
define('SPLIT_IN_BOX', 1);
define('TITLE_ONLY', 2);

// message mode
define('USE_DEFAULT', 0);
define('BY_PM', 1);
define('BY_MAIL', 2);

// calendar
define('POST_BIRTHDAY', 9);
define('POST_CALENDAR', 10);
$calendar_days_of_week = array(
	'0' => 'Sunday',
	'1' => 'Monday',
	'2' => 'Tuesday',
	'3' => 'Wednesday',
	'4' => 'Thursday',
	'5' => 'Friday',
	'6' => 'Saturday',
);

// html mask
define('HTML_UID_LEN', 10);

// config
class cache_config extends cache
{
	function row_process(&$rows, $id)
	{
		$rows[$id] = $rows[$id]['config_value'];
	}
}

class config_class
{
	var $data;
	var $data_time;
	var $from_cache;
	var $dynamic;
	var $root;
	var $ext;
	var $differ;
	var $recache;

	var $requester;

	var $plug_ins;
	var $plug_ins_def;
	var $globals;

	function config_class()
	{
		global $phpbb_root_path, $phpEx, $requester;

		$this->data = array();
		$this->data_time = 0;
		$this->from_cache = false;
		$this->dynamic = array();
		$this->root = &$phpbb_root_path;
		$this->ext = &$phpEx;
		$this->requester = $requester;
		$this->recache = $this->differ = false;
		$this->plugins = array();
		$this->plug_ins_def = array();
		$this->globals = array();
	}

	function read($force=false)
	{
		global $db;

		// get dynamic values
		$sql = 'SELECT config_name, config_value
					FROM ' . CONFIG_TABLE . '
					WHERE config_static = 0';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__, false);
		if ( !$result )
		{
			return false;
		}
		$this->data_time = time();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->data[ $row['config_name'] ] = $row['config_value'];
			$this->dynamic[ $row['config_name'] ] = true;
		}

		// default values
		if ( empty($this->data['cache_path']) )
		{
			$this->data['cache_path'] = 'cache/';
			$this->dynamic['cache_path'] = true;
		}

		// get static values
		$db_cached = new cache_config('dta_config', $this->data['cache_path'], $this->data['cache_disabled_cfg']);
		$sql = 'SELECT config_name, config_value
					FROM ' . CONFIG_TABLE . '
					WHERE config_static = ' . true;
		$data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force, 'config_name');
		if ( !empty($data) )
		{
			$this->data = array_merge($this->data, $data);
			unset($data);
			$this->data_time = $db_cached->data_time;
		}
		$this->from_cache = $db_cached->from_cache;

		// define constants for system groups
		define('GROUP_FOUNDER', $this->data['group_founder']);
		define('GROUP_ADMIN', $this->data['group_admin']);
		define('GROUP_REGISTERED', $this->data['group_registered']);
		define('GROUP_ANONYMOUS', $this->data['group_anonymous']);
		define('GROUP_BOTS', $this->data['group_bots']);

		return true;
	}

	function get_system_groups()
	{
		return array(
			'GROUP_FOUNDER' => GROUP_FOUNDER,
			'GROUP_ADMIN' => GROUP_ADMIN,
			'GROUP_REGISTERED' => GROUP_REGISTERED,
			'GROUP_ANONYMOUS' => GROUP_ANONYMOUS,
			'GROUP_BOTS' => GROUP_BOTS,
		);
	}

	function begin_transaction()
	{
		$this->differ = true;
	}

	function set($config_name, $config_value, $static=false)
	{
		global $db;

		$this->dynamic[$config_name] = isset($this->data[$config_name]) ? (isset($this->dynamic[$config_name]) ? $this->dynamic[$config_name] : false) : !$static;
		$fields = array(
			'config_name' => $config_name,
			'config_value' => $config_value,
			'config_static' => !$this->dynamic[$config_name],
		);
		if ( !isset($this->data[$config_name]) )
		{
			$sql = 'INSERT INTO ' . CONFIG_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES (' . $db->sql_fields('values', $fields) . ')';
		}
		else
		{
			$sql = 'UPDATE ' . CONFIG_TABLE . '
						SET ' . $db->sql_fields('update', $fields) . '
						WHERE config_name = \'' . $db->sql_escape_string($config_name) . '\'';
		}
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$this->data[$config_name] = $config_value;
		if ( !$this->dynamic[$config_name] )
		{
			if ( !$this->differ )
			{
				$this->read(true);
				$this->recache = false;
			}
			else
			{
				$this->recache = true;
			}
		}
	}

	function end_transaction()
	{
		if ( $this->differ && $this->recache )
		{
			$this->read(true);
		}
		$this->recache = $this->differ = false;
	}

	function url($basename, $parms=array(), $add_sid=false, $fragments='', $force=false)
	{
		global $SID;

		$url_parms = '';
		if ( empty($parms) )
		{
			$parms = array();
		}
		if ( $add_sid && empty($parms['sid']) )
		{
			$parms['sid'] = substr($SID, strlen('sid='));
		}
		if ( !empty($parms) )
		{
			foreach ( $parms as $key => $val )
			{
				if ( !empty($key) && (!empty($val) || $force) )
				{
					$url_parms .= (empty($url_parms) ? '?' : '&amp;') . $key . '=' . rawurlencode(_htmldecode($val));
				}
			}
		}
		if ( !empty($fragments) )
		{
			$url_parms .= (empty($url_parms) ? '?#' : '#') . $fragments;
		}
		return ($add_sid && (substr($this->root, 0, 2) == './') ? substr($this->root, 2) : $this->root) . $basename . '.' . $this->ext . $url_parms;
	}

	function get_script_path()
	{
		static $script_path;
		if ( !$script_path )
		{
			$server_protocol = empty($this->data['cookie_secure']) ? 'http://' : 'https://';
			$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($this->data['server_name']));
			$server_port = ($this->data['server_port'] == 80 ? '' : ':' . trim($this->data['server_port'])) . '/';
			$script_path = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($this->data['script_path']));
			$script_path = $server_protocol . $server_name . $server_port . (empty($script_path) ? '' : $script_path . '/');
		}
		return $script_path;
	}

	function read_plug_ins()
	{
		global $db;

		$res = array();
		$plug_ins = false;
		include($this->url('includes/inc_plugins'));
		if ( !$plug_ins )
		{
			return false;
		}
		$plug_ins_delete = array();
		foreach ( $plug_ins as $api_id => $api_def )
		{
			if ( $api_def['layer'] && ($filename = $this->url($api_def['layer'])) && @file_exists(phpbb_realpath($filename)) )
			{
				$res[] = $api_def['layer'];
			}
			else if ( !empty($api_id) && isset($this->data[(string) $api_id]) )
			{
				$plug_ins_delete[] = (string) $api_id;
			}
		}
		if ( $plug_ins_delete )
		{
			$sql = 'DELETE FROM ' . CONFIG_TABLE . '
						WHERE config_name IN(' . implode(', ', array_map(array(&$db, 'sql_type_cast'), $plug_ins_delete)) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$this->read(true);
		}
		return empty($res) ? false : $res;
	}

	function set_plug_ins($plug, $plugs)
	{
		if ( $plugs )
		{
			foreach ( $plugs as $api_id => $dummy )
			{
				unset($dummy);
				if ( !isset($this->plug_ins_def[$api_id]) )
				{
					$this->plug_ins_def[$api_id] = array();
				}
				$this->plug_ins_def[$api_id][$plug] = $plugs[$api_id];
			}
		}
	}
}

class plug_ins
{
	var $plug_ins;

	function plug_ins()
	{
		$this->plug_ins = false;
	}

	function load($api_id)
	{
		global $config;

		$is_plug = false;
		if ( isset($config->plug_ins_def[$api_id]) && !empty($config->plug_ins_def[$api_id]) )
		{
			foreach ( $config->plug_ins_def[$api_id] as $plug => $def )
			{
				if ( isset($def['layer']) && !empty($def['layer']) )
				{
					if ( !is_array($def['layer']) )
					{
						$def['layer'] = array($def['layer']);
					}
					foreach ( $def['layer'] as $dummy => $filename )
					{
						if ( $filename )
						{
							include_once($config->url($filename));
						}
					}
				}
				if ( isset($def['object']) && !empty($def['object']) )
				{
					if ( !is_array($def['object']) )
					{
						$def['object'] = array($def['object']);
					}
					$count_object = count($def['object']);
					for ( $i = 0; $i < $count_object; $i++ )
					{
						if ( class_exists($def['object'][$i]) )
						{
							$config->plug_ins[$api_id][ ($plug . ($count_object > 1 ? '.' . $i : '')) ] = new $def['object'][$i]($this);
							$is_plug = true;
						}
					}
				}
			}
		}
		if ( !$is_plug )
		{
			$config->plug_ins[$api_id] = false;
		}
		$this->plug_ins = &$config->plug_ins[$api_id];
	}
}

class cache_words extends cache
{
	function row_process(&$rows, &$row_id)
	{
		$row = $rows[$row_id];
		unset($rows[$row_id]);
		$row_id = '#\b(' . str_replace('\*', '\w*?', preg_quote($row['word'], '#')) . ')\b#i';
		$rows[$row_id] = $row['replacement'];
	}
}

class words
{
	var $data;
	var $data_time;
	var $from_cache;
	var $data_flag;

	function read($force=false)
	{
		global $config;

		if ( !$force && $this->data_flag )
		{
			return $this->data;
		}
		$db_cached = new cache_words('dta_words', $config->data['cache_path'], $config->data['cache_disabled_words']);
		$sql = 'SELECT * 
					FROM ' . WORDS_TABLE;
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force, 'word');
		$this->data_flag = true;
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;

		return $this->data;
	}
}

class navigation
{
	var $data;
	var $root_count;
	var $requester;
	var $displayed;

	function navigation($requester='')
	{
		$this->requester = empty($requester) ? INDEX : $requester;
		$this->clear();
		$this->root_count = count($this->data);
		$this->displayed = false;
	}

	function clear()
	{
		global $config;

		$this->data = array();
		$this->add('Forum_index', $config->data['sitename'], $this->requester, '', $config->data['index_fav_icon']);
	}

	function add($name, $desc='', $url, $parms='', $img='')
	{
		$this->data[] = array('name' => $name, 'desc' => $desc, 'url' => $url, 'parms' => $parms, 'img' => $img);
	}

	function display($tpl_switch='nav', $root=true)
	{
		global $template, $config, $user;

		$count_data = count($this->data);
		for ( $i = 0; $i < $count_data; $i++ )
		{
			if ( ($i >= $this->root_count) || $root )
			{
				$template->assign_block_vars($tpl_switch, array(
					'U_NAV' => $config->url($this->data[$i]['url'], $this->data[$i]['parms'], true),
					'L_NAV' => $user->lang($this->data[$i]['name']),
					'L_NAV_DESC' => _clean_html($user->lang($this->data[$i]['desc'])),
					'I_NAV' => $user->img($this->data[$i]['img']),
				));
				$template->set_switch($tpl_switch . '.img', !empty($this->data[$i]['img']));
				$template->set_switch($tpl_switch . '.sep', $i < ($count_data-1));
			}
		}
		if ( $tpl_switch == 'nav' )
		{
			$template->assign_vars(array(
				'NAVIGATION_BOX' => $template->include_file('navigation_box.tpl'),
				'NAVIGATION_ONLY_BOX' => $template->include_file('navigation_only_box.tpl'),
			));
		}
		$this->displayed = true;
	}
}

class pagination
{
	var $requester;
	var $parms;
	var $start;

	// constructor
	function pagination($requester='', $parms='', $varname='')
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->varname = empty($varname) ? 'start' : $varname;
		if ( isset($this->parms[$this->varname]) )
		{
			unset($this->parms[$this->varname]);
		}
	}

	function get_forks($total_items, $item_per_page, $current_item)
	{
		global $config;

		// get the number of pages
		$total_pages = ceil($total_items / $item_per_page);
		if ( $total_pages == 1 )
		{
			return '';
		}

		// limits: 
		// - scope_min & scope_max are the limits for the number of pages displayed
		// - the percentage is applied to the total items to get the scope
		$scope_min = empty($config->data['pagination_min']) ? 5 : intval($config->data['pagination_min']); // 2 on sides + current page
		$scope_max = empty($config->data['pagination_max']) ? 11 : intval($config->data['pagination_max']); // 5 on sides + current page
		$scope_percent = empty($config->data['pagination_percent']) ? 10 : intval($config->data['pagination_percent']); // 10 %

		// center on the current page : $scope is half the number of page around the current page ($middle)
		$scope = ceil((min(max(intval($total_items * $scope_percent / 100), $scope_max), $scope_min) - 1) / 2);
		$middle = floor($current_item / $item_per_page);

		// get forks limits
		$left_end = min($scope, $total_pages-1);
		$middle_start = max($middle-$scope, $scope, 0);
		$middle_end = min( $middle + $scope, $total_pages-$scope );
		$right_start = max( $total_pages-$scope-1, 0 );

		// middle get over edges
		$is_left = $middle_start > $left_end+$scope;
		$is_right = $middle_end+$scope < $right_start;
		if ( !$is_left )
		{
			$middle_start = 0;
		}
		if ( !$is_right )
		{
			$middle_end = $total_pages-1;
		}

		// store forks
		$forks = array();
		if ( $is_left )
		{
			$forks[] = array(0, $left_end);
		}
		$forks[] = array($middle_start, $middle_end);
		if ( $is_right )
		{
			$forks[] = array($right_start, $total_pages-1);
		}
		return $forks;
	}

	function display($tpl_switch, $total_items, $item_per_page, $current_item, $page_1=true, $item_name_count='', $item_total_count=0)
	{
		global $template, $config, $user;

		if ( empty($item_per_page) )
		{
			$item_per_page = 50;
		}
		$pages = $this->get_forks($total_items, $item_per_page, $current_item);
		$current_page = floor($current_item / $item_per_page);
		$total_pages = ceil($total_items / $item_per_page) + (!$total_items && $item_total_count && $page_1 ? 1 : 0);
		$res = '';

		$n_count = !empty($item_total_count) ? $item_total_count : $total_items;
		$l_count = empty($item_name_count) ? '' : (($n_count == 1) ? $item_name_count . '_1' : $item_name_count);

		if ( ($total_pages > 1) || (($total_pages == 1) && $page_1) )
		{
			$template->assign_block_vars($tpl_switch, array(
				'START_FIELD' => $this->varname,
				'START' => $current_page * $item_per_page,

				'U_PREVIOUS' => $config->url($this->requester, $this->parms + array($this->varname => (($current_page > 0) ? ($current_page-1) * $item_per_page : 0)), true),
				'L_PREVIOUS' => $user->lang('Previous'),
				'I_PREVIOUS' => $user->img('left_arrow'),
				'PREVIOUS' => ($current_page > 0) ? ($current_page-1) * $item_per_page : 0,

				'U_NEXT' => $config->url($this->requester, $this->parms + array($this->varname => (($current_page+1 < $total_pages) ? ($current_page+1) * $item_per_page : ($total_pages-1) * $item_per_page)), true),
				'L_NEXT' => $user->lang('Next'),
				'I_NEXT' => $user->img('right_arrow'),
				'NEXT' => ($current_page+1 < $total_pages) ? ($current_page+1) * $item_per_page : ($total_pages-1) * $item_per_page,

				'L_GOTO' => $user->lang('Goto_page'),
				'I_GOTO' => $user->img('icon_gotopost'),
				'L_PAGE_OF' => sprintf($user->lang('Page_of'), $current_page+1, $total_pages),
				'L_COUNT' => sprintf($user->lang($l_count), $n_count),
			));
			$template->set_switch($tpl_switch . '.previous', $current_page > 0);
			$template->set_switch($tpl_switch . '.next', ($current_page+1) < $total_pages);
			$template->set_switch($tpl_switch . '.unique', ($total_pages <= 1));

			// dump the forks
			if ( $total_pages > 1 )
			{
				$first = true;
				$count_pages = count($pages);
				for ( $j = 0; $j < $count_pages; $j++ )
				{
					if ( !$first )
					{
						// send "...,"
						$template->set_switch($tpl_switch . '.page_number');
						$template->set_switch($tpl_switch . '.page_number.number', false);
					}
					for ( $k = $pages[$j][0]; $k <= $pages[$j][1]; $k++ )
					{
						$last = ($j == $count_pages - 1) && ($k == $pages[$j][1]);
						$template->assign_block_vars($tpl_switch . '.page_number', array(
							'U_PAGE' => $config->url($this->requester, $this->parms + array($this->varname => $k * $item_per_page), true),
							'PAGE' => ($k + 1),
							'START' => ($k * $item_per_page),
							'L_SEP' => $last ? '' : ', ',
						));
						$template->set_switch($tpl_switch . '.page_number.number');
						$template->set_switch($tpl_switch . '.page_number.number.current', ($k == $current_page));
						$template->set_switch($tpl_switch . '.page_number.number.sep', !$last);
						$first = false;
					}
				}
			}
		}
	}
}


//
// init
//

// define global some objects & vars
$user = $themes = $icons = $smilies = $topics_attr = $forums = $censored_words = $navigation = false;
$SID = $s_hidden_fields = $rev_html_translation_table = $script_path = $page_title = false;
$error_msg = $warning_msg = '';
$error = $warning = false;

// get config
$config = new config_class();
if ( !$config->read() )
{
	define('RUN_CH_INSTALL', true);
}
$board_config = &$config->data;

// let's run the upgrade script
if ( !defined('IN_LOGIN') && !defined('IN_INSTALL') && (($config->data['mod_cat_hierarchy'] != CH_CURRENT_VERSION) || defined('RUN_CH_INSTALL')) )
{
	header('Location: ./install_cat/install.' . $phpEx . (empty($SID) ? '' : '?' . $SID));
	exit;
}

// user objects
include($config->url('includes/class_user'));
include($config->url('includes/class_user_session'));

// instantiate some objects
$censored_words = new words();
$navigation = new navigation();

// People never read achievement messages after after having seen "Succesfull !", tss tss :)
if ( !defined('IN_LOGIN') && !defined('IN_INSTALL') && @file_exists(phpbb_realpath($config->root . 'install_cat')) )
{
	message_die(GENERAL_MESSAGE, 'Please ensure the install_cat/ directory is deleted');
}

// convert pic buttons to standard input
_cvt_pic_buttons();

// plug-ins: load the main init scripts which will initialise the apis def
$plug_ins_init = true;
if ( ($plug_ins = $config->read_plug_ins()) )
{
	foreach ( $plug_ins as $api_filename )
	{
		include($config->url($api_filename));
	}
}
unset($plug_ins);
$plug_ins_init = false;

// plug-ins: load the apis and instantiate the apis objects
if ( $requester )
{
	$config->plug_ins[$requester] = false;
	if ( isset($config->plug_ins_def[$requester]) && !empty($config->plug_ins_def[$requester]) )
	{
		foreach ( $config->plug_ins_def[$requester] as $api_id => $api_def )
		{
			if ( isset($api_def['layer']) && !empty($api_def['layer']) )
			{
				if ( !is_array($api_def['layer']) )
				{
					$api_def['layer'] = array($api_def['layer']);
				}
				foreach ( $api_def['layer'] as $api_filename )
				{
					include($config->url($api_filename));
				}
			}
			if ( isset($api_def['object']) && !empty($api_def['object']) )
			{
				if ( !is_array($api_def['object']) )
				{
					$api_def['object'] = array($api_def['object']);
				}
				$count_object = count($api_def['object']);
				for ( $i = 0; $i < $count_object; $i++ )
				{
					if ( class_exists($api_def['object'][$i]) )
					{
						if ( $config->plug_ins[$requester] === false )
						{
							$config->plug_ins[$requester] = array();
						}
						$config->plug_ins[$requester][ ($api_id . ($count_object > 1 ? '.' . $i : '')) ] = new $api_def['object'][$i]();
						$is_plug = true;
					}
				}
			}
		}
	}
}

// denied admin scripts : yes of course, everybody have read the mod install description...
$denied_scripts = !defined('IN_ADMIN') ? array() : array(
	'admin_board',
	'admin_forum_prune',
	'admin_forumauth',
	'admin_ug_auth',
	'admin_db_utilities',
	'admin_users',
);

?>