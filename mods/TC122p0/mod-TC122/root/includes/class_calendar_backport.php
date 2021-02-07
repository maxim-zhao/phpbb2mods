<?php
/***************************************************************************
 *                            class_calendar_backport.php
 *                            ---------------------------
 *	begin			: 23/04/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.2 - 06/07/2006
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

function calendar_extend_template()
{
	global $template;
	static $sav_template, $done;

	if ( !$done )
	{
		$done = true;
		$sav_template = $template;
		$template = new calendar_class_template($sav_template);
		$template->global_switches = array('java' => false);
	}
	else
	{
		$done = false;
		$cur_template = &$template;
		$template = $sav_template;
		unset($cur_template);
		unset($sav_template);
	}
}

//--------------------------
//
// class definitions
//
//--------------------------

class calendar_class_config
{
	var $data;
	var $root, $ext, $SID;

	function calendar_class_config()
	{
		global $board_config, $phpbb_root_path, $phpEx, $SID;

		$this->data = &$board_config;
		$this->root = $phpbb_root_path;
		$this->ext = $phpEx;
		$this->SID = '';
	}

	function url($basename, $parms=array(), $add_sid=false, $fragments='', $force=false, $external=false)
	{
		static $script_path;

		$url_parms = '';
		if ( empty($parms) )
		{
			$parms = array();
		}
		if ( $add_sid && empty($parms['sid']) )
		{
			$parms['sid'] = substr($this->SID, strlen('sid='));
		}
		if ( !empty($parms) )
		{
			foreach ( $parms as $key => $val )
			{
				if ( !empty($key) && (!empty($val) || $force) )
				{
					$url_parms .= (empty($url_parms) ? '?' : '&amp;') . $key . '=' . $val;
				}
			}
		}
		if ( !empty($fragments) )
		{
			$url_parms .= (empty($url_parms) ? '?#' : '#') . $fragments;
		}
		if ( $external && empty($script_path) )
		{
			$script_path = $this->get_script_path();
		}
		return ($external ? $script_path : (trim(substr($this->root, 0, 2) == './') && $add_sid ? substr($this->root, 2) : $this->root)) . $basename . '.' . $this->ext . $url_parms;
	}

	function get_script_path()
	{
		$server_protocol = empty($this->data['cookie_secure']) ? 'http://' : 'https://';
		$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($this->data['server_name']));
		$server_port = ($this->data['server_port'] == 80 ? '' : ':' . trim($this->data['server_port'])) . '/';
		$script_path = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($this->data['script_path']));
		$script_path = $server_protocol . $server_name . $server_port . (empty($script_path) ? '' : $script_path . '/');
		return $script_path;
	}
}

class calendar_class_user
{
	var $set;
	var $data;
	var $lang_used;
	var $global_lang;
	var $global_images;

	function calendar_class_user()
	{
		$this->set = false;
		$this->data = array();
		$this->lang_used = '';
		$this->global_lang = array();
		$this->global_images = array();
	}

	function set()
	{
		global $userdata, $config, $lang, $images, $SID;
		global $calendar_api;

		if ( $this->set )
		{
			return;
		}
		$this->set = true;

		$config->SID = $SID;

		$this->data = &$userdata;
		$this->lang_used = $config->data['default_lang'];
		$this->global_lang = &$lang;
		$this->global_images = &$images;

		if ( ($this->data['user_id'] == ANONYMOUS) || !$this->data['session_logged_in'] )
		{
			$this->overwrite_anonymous_values();
		}
		$this->read_lang();
	}

	function read_lang()
	{
		global $config;

		if ( defined('LANG_EXTEND_DONE') && LANG_EXTEND_DONE )
		{
			return;
		}

		$lang = array();

		// check for admin part
		$lang_extend_admin = defined('IN_ADMIN');

		// get the english settings
		if ( $this->lang_used != 'english' )
		{
			$dir = @opendir($config->root . 'language/lang_english');
			while( $file = @readdir($dir) )
			{
				if ( preg_match('/^lang_extend_.*?\.' . $config->ext . '$/', $file) )
				{
					include($config->root . 'language/lang_english/' . $file);
				}
			}

			// include the customizations
			if ( @file_exists(@phpbb_realpath($config->url('language/lang_english/lang_extend'))) )
			{
				include($config->url('language/lang_english/lang_extend'));
			}
			@closedir($dir);
		}

		// get the user settings
		$dir = @opendir($config->root . 'language/lang_' . $this->lang_used);
		while( $file = @readdir($dir) )
		{
			if ( preg_match('/^lang_extend_.*?\.' . $config->ext . '$/', $file) )
			{
				include($config->root . 'language/lang_' . $this->lang_used . '/' . $file);
			}
		}

		// include the customizations
		if ( @file_exists(@phpbb_realpath($config->url('language/lang_' . $this->lang_used . '/lang_extend'))) )
		{
			include($config->url('language/lang_' . $this->lang_used . '/lang_extend'));
		}
		@closedir($dir);

		if ( !empty($lang) )
		{
			foreach ($lang as $key => $value )
			{
				$this->global_lang[$key] = $value;
			}
		}
		define('LANG_EXTEND_DONE', true);
	}

	function date($time=0, $fmt='', $today_yesterday=false)
	{
		// fix parms with default
		$fmt = empty($fmt) ? $this->data['user_dateformat'] : $fmt;
		$tz = $this->data['user_timezone'];
		$time = empty($time) ? time() : $time;

		return create_date($fmt, $time, $tz);
	}

	function lang($key)
	{
		return !empty($key) && isset($this->global_lang[$key]) ? $this->global_lang[$key] : $key;
	}

	function img($key)
	{
		global $config;
		return !empty($key) && isset($this->global_images[$key]) ? $config->root . $this->global_images[$key] : (($sub = substr($key, 0, 5)) && (($sub == 'http:') || ($sub == 'ftp:/')) ? $key : $config->root . $key);
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
	}
}

class calendar_class_template
{
	var $template;
	var $add_dot;
	var $global_switches;

	function calendar_class_template(&$sav_template)
	{
		$this->template = &$sav_template;
		$this->add_dot = '.';
		$this->global_switches = array();
	}

	// standard functions
	function make_filename($filename)
	{
		return $this->template->make_filename($filename);
	}

	function set_filenames($filename_array)
	{
		return $this->template->set_filenames($filename_array);
	}

	function pparse($handle)
	{
		return $this->template->pparse($handle);
	}

	function assign_var_from_handle($varname, $handle)
	{
		return $this->template->assign_var_from_handle($varname, $handle);
	}

	function assign_block_vars($blockname, $vararray)
	{
		$this->template->assign_block_vars($blockname, $vararray);
		if ( !empty($this->global_switches) )
		{
			foreach ( $this->global_switches as $switch => $value )
			{
				if ( $blockname != $switch )
				{
					$this->template->assign_block_vars($blockname . '.' . $switch . ($value ? '' : '_ELSE'), array());
				}
			}
		}
	}

	function assign_vars($vararray)
	{
		return $this->template->assign_vars($vararray);
	}

	// our added functions
	function set_switch($switch, $set=true, $onset=true)
	{
		if ( $onset )
		{
			$this->assign_block_vars($switch . ($set ? '' : '_ELSE'), array());
			if ( isset($this->global_switches[$switch]) )
			{
				$this->global_switches[$switch] = $set;
			}
		}
		return $set && $onset;
	}

	function get_pparse($handle)
	{
		ob_start();
		$this->pparse($handle);
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	function get_pparse_txt($handle)
	{
		return str_replace(array('<br />', '"', '<', '>'), array("\n", '&quot;', '&lt;', '&gt;'), $this->get_pparse($handle));
	}

	function unset_block_vars($blockname)
	{
		if ( strstr($blockname, '.') )
		{
			$blocks = explode('.', $blockname);
			$blockcount = sizeof($blocks) - 1;
			$str = &$this->template->_tpldata;
			for ( $i = 0; $i < $blockcount; $i++ )
			{
				$str = &$str[ $blocks[$i] . $this->add_dot ];
				$str = &$str[ sizeof($str) - 1 ];
			}
			if ( isset($str[ $blocks[$blockcount]  . $this->add_dot ]) )
			{
				unset($str[ $blocks[$blockcount] . $this->add_dot ]);
				return true;
			}
		}
		else
		{
			if ( isset($this->template->_tpldata[$blockname . $this->add_dot]) )
			{
				unset($this->template->_tpldata[$blockname . $this->add_dot]);
				return true;
			}
		}
	}

	function include_file($filename, $switches='')
	{
		$switches = empty($switches) ? array() : (!is_array($switches) ? array($switches) : $switches);
		$this->set_filenames(array($filename => $filename));
		$res = $this->get_pparse($filename);
		$count_switches = count($switches);
		for ( $i = 0; $i < $count_switches; $i++ )
		{
			$this->unset_block_vars($switches[$i]);
		}
		return $res;
	}

	function include_escaped_file($filename, $switches='')
	{
		return str_replace(array('<br />', '"', '<', '>'), array("\n", '&quot;', '&lt;', '&gt;'), str_replace(array("\r", "\n"), '', $this->include_file($filename, $switches)));
	}
}

// objects
$config = new calendar_class_config();
$user = new calendar_class_user();
$calendar_api = '';

?>