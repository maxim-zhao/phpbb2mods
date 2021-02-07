<?php
//
//	file: includes/class_template.php
//	author: ptirhiik
//	begin: 29/08/2004
//	version: 1.6.5 - 11/05/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}
define('TPL_FUNC', '__F');
define('TPL_PARM', '__P');

class template_class
{
	var $_tpldata = array();

	// hash of filenames for each template handle.
	var $files = array();
	var $filename = array();
	var $mains = array();

	// directories
	var $template_path;
	var $cache_path;

	// parms
	var $root_template;
	var $template_name;
	var $root;
	var $cacheprefix;
	var $alt_template_name;
	var $alt_root;
	var $alt_cacheprefix;

	var $no_debug;
	var $_id;

	var $local_images;

	function template_class($root='.', $alt_template_name='', $template_path='')
	{
		global $config;

		// default values
		if ( ($config === false) || empty($config->data) )
		{
			$config->data['cache_path'] = 'cache/';
			$config->data['cache_disabled_template'] = true;
			$config->data['cache_check_template'] = true;
		}
		else if ( $config->data['cache_disabled_template'] )
		{
			$config->data['cache_check_template'] = true;
		}

		// set the cache path
		$this->cache_path = $config->data['cache_path'];
		$this->template_path = empty($template_path) ? 'templates/' : $template_path;

		$this->set($root, $alt_template_name);

		$this->no_debug = false;
		$this->_id = 0;
	}

	function set($root, $alt_template_name='')
	{
		global $config;

		$this->root_template = $config->root . $this->template_path;

		// get main template settings
		$this->template_name = str_replace('//', '/', str_replace('./', '', substr($root, strlen($this->root_template))) . '/');
		$this->root = $this->root_template . $this->template_name;
		$this->cacheprefix = $config->root . $this->cache_path . 'tpl_' . str_replace('/', '_', $this->template_name);

		// get custom tpls settings
		$this->alt_template_name = $this->alt_root = $this->alt_prefix = '';
		if ( $alt_template_name && ($this->alt_template_name = $this->tpl_realpath($alt_template_name)) )
		{
			$this->alt_root = $this->root_template . $this->alt_template_name;
			$this->alt_cacheprefix = $config->root . $this->cache_path . 'tpl_' . str_replace('/', '_', $this->alt_template_name);
		}

		// raz
		$this->_tpldata = $this->local_images = array();
	}

	function tpl_realpath($tpl_name)
	{
		global $config;

		if ( !empty($tpl_name) )
		{
			$real_path = phpbb_realpath($this->root);
			if ( $real_path != $this->root)
			{
				$tpl_real_path = phpbb_realpath($this->root . $tpl_name);
				if ( empty($tpl_real_path) )
				{
					$tpl_name = '';
				}
				else
				{
					$root_real_path = phpbb_realpath($this->root_template);
					$tpl_name = str_replace('//', '/', str_replace('\\', '/', substr($tpl_real_path, strlen($root_real_path)+1)) . '/');
				}
			}
			// realpath fails to get the real path sometime (when not available), so find another way
			else
			{
				$res = $this->template_name;
				if ( substr($tpl_name, 0, 2) == './' )
				{
					$tpl_name = substr($tpl_name, 2);
				}
				if ( substr($tpl_name, 0, 3) == '../' )
				{
					$res = '';
					$tpl_name = substr($tpl_name, 3);
				}
				if ( preg_match('/\.\.\//', $tpl_name) )
				{
					$tpl_name = '';
				}
				else
				{
					$tpl_name = str_replace('//', '/', str_replace('./', '', $res . $tpl_name) . '/');
				}
			}
		}
		return $tpl_name;
	}

	function set_switch($switch_name, $on=true, $onset=true)
	{
		if ( $onset )
		{
			$this->assign_block_vars($switch_name . ($on ? '' : '_ELSE'), array());
		}
	}

	function save(&$save)
	{
		$save = $this->_tpldata;
	}

	function destroy()
	{
		$this->_tpldata = array();
	}

	function restore(&$save)
	{
		$this->_tpldata = $save;
	}

	function get_pparse($handle)
	{
		ob_start();
		$this->pparse($handle);
		$res = ob_get_contents();
		ob_end_clean();
		return $res;
	}

	// Sets the template filenames for handles. $filename_array
	// should be a hash of handle => filename pairs.
	function set_filenames($filename_array)
	{
		if ( !is_array($filename_array) )
		{
			return false;
		}

		$template_names = '';
		foreach ($filename_array as $handle => $filename)
		{
			if ( empty($filename) )
			{
				message_die(GENERAL_ERROR, 'template error - Empty filename specified for ' . $handle, '', __LINE__, __FILE__);
			}

			$this->filename[$handle] = $filename;
			if ( !empty($this->alt_root) )
			{
				$this->files[$handle] = $this->alt_root . $filename;
			}

			// doesn't exists : try the main
			if ( !$this->mains[$handle] = (!empty($this->alt_root) && file_exists($this->files[$handle])) )
			{
				$this->files[$handle] = $this->root . $filename;
				$this->mains[$handle] = false;
			}
		}

		return true;
	}

	function make_filename($filename)
	{
		return !empty($this->alt_root) && file_exists($this->alt_root . $filename) ?  $this->alt_root . $filename : (file_exists($this->root . $filename) ? $this->root . $filename : '');
	}

	// Methods for loading and evaluating the templates
	function pparse($handle)
	{
		global $config, $user, $images;

		// If we don't have a file assigned to this handle, die.
		if ( !isset($this->files[$handle]) )
		{
			message_die(GENERAL_ERROR, 'template->_tpl_load(): No file specified for handle ' . $handle, '', __LINE__, __FILE__);
		}

		$d = &$this->_tpldata;
		if ( is_object($user) && !$user->style_set )
		{
			$user->set_style();
		}

		// get the cache name
		$cache_name = ($this->mains[$handle] ? $this->alt_cacheprefix : $this->cacheprefix) . str_replace('/', '_', $this->filename[$handle]) . '.' . $config->ext;

		// debug info
		$this->no_debug = $this->no_debug || ($user === false) || ($user->data['user_level'] != ADMIN);
		if ( defined('DEBUG_TEMPLATE') && !$this->no_debug )
		{
			echo '<!-- Start of : ' . $this->files[$handle] . ' :: ' . $handle . ' -->' . "\n";
		}

		// Recompile page if the original template is newer or caches are disabled, otherwise load the compiled version
		if ( !$config->data['cache_disabled_template'] && @file_exists($cache_name) && (!$config->data['cache_check_template'] || (@filemtime($cache_name) > @filemtime($this->files[$handle]))) )
		{
			include($cache_name);
		}
		else
		{
			// Try and open template for read
			if ( !($fp = @fopen($this->files[$handle], 'r')) || !($fsize = filesize($this->files[$handle])) )
			{
				message_die(GENERAL_ERROR, 'template->_tpl_load(): File ' . $this->files[$handle] . ' does not exist or is empty', '', __LINE__, __FILE__);
			}

			// compile required
			if ( !class_exists('tpl_compiler') )
			{
				include($config->url('includes/class_template_compiler'));
			}
			$tpl_compiler = new tpl_compiler();
			$compiled_code = $tpl_compiler->compile(trim(@fread($fp, $fsize)));
			@fclose($fp);
			unset($tpl_compiler);

			// output the template to the cache
			if ( !$config->data['cache_disabled_template'] && ($fp = @fopen($cache_name, 'wb')) )
			{
				@flock($fp, LOCK_EX);
				@fwrite($fp, $compiled_code);
				@flock($fp, LOCK_UN);
				@fclose($fp);

				@umask(0000);
				@chmod($cache_name, 0644);
			}

			// output the result to the screen
			eval(' ?>' . $compiled_code . '<?php ');
			unset($compiled_code);
		}

		// debug info
		if ( defined('DEBUG_TEMPLATE') && !$this->no_debug )
		{
			echo '<!-- End of : ' . $this->files[$handle] . ' :: ' . $handle . ' -->' . "\n";
		}

		return true;
	}

	function assign_var_from_handle($varname, $handle)
	{
		return $this->assign_vars(array($varname => $this->include_file($this->filename[$handle])));
	}

	// Assign key variable pairs from an array
	function assign_vars($vararray)
	{
		$this->_tpldata['.'][0] = array_merge(empty($this->_tpldata['.'][0]) ? array() : $this->_tpldata['.'][0], $vararray);
		return true;
	}

	// Assign key variable pairs from an array to a specified block
	function assign_block_vars($blockname, $vararray)
	{
		if (strstr($blockname, '.'))
		{
			// Nested block.
			$blocks = explode('.', $blockname);
			$blockcount = sizeof($blocks) - 1;

			$str = &$this->_tpldata; 
			for ($i = 0; $i < $blockcount; $i++) 
			{
				$str = &$str[$blocks[$i]]; 
				$str = &$str[sizeof($str) - 1]; 
			}
			$str[$blocks[$blockcount]][] = $vararray;
		}
		else
		{
			$this->_tpldata[$blockname][] = $vararray;
		}

		return true;
	}

	function assign_lastblock_vars($blockname, $vararray)
	{
		$ok = false;
		if ( ($addr = $this->retrieve_lastblock_addr($blockname)) )
		{
			$this->assign_addrblock_vars($addr, $vararray);
			$ok = true;
		}
		return $ok;
	}

	function assign_addrblock_vars(&$addr, $vararray)
	{
		if ( $addr )
		{
			$str = &$this->_tpldata;
			$count_addr = count($addr);
			for ( $i = 0; $i < $count_addr; $i++ )
			{
				$str = &$str[ $addr[$i] ];
			}
			$str = array_merge($str, $vararray);
		}
	}

	function retrieve_lastblock_addr($blockname)
	{
		$ok = false;
		$addr = array();
		if ( strstr($blockname, '.') )
		{
			$blocks = explode('.', $blockname);
			$count_blocks = count($blocks);
			if ( $count_blocks && isset($this->_tpldata[ $blocks[0] ]) )
			{
				$ok = true;
				$addr[] = $blocks[0];
				$str = &$this->_tpldata[ $blocks[0] ];
				for ( $i = 1; $i < $count_blocks; $i++ )
				{
					$ok = false;
					for ( $j = count($str)-1; $j >= 0; $j-- )
					{
						if ( isset($str[$j][ $blocks[$i] ]) )
						{
							$ok = true;
							$str = &$str[$j][ $blocks[$i] ];
							$addr[] = $j;
							$addr[] = $blocks[$i];
							break;
						}
					}
					if ( !$ok )
					{
						break;
					}
				}
			}
		}
		else if ( isset($this->_tpldata[$blockname]) )
		{
			$ok = true;
			$str = &$this->_tpldata[$blockname];
			$addr[] = $blockname;
		}
		if ( $ok && ($ok = ($count_str = count($str))) )
		{
			$addr[] = $count_str - 1;
			return $addr;
		}
		return false;
	}

	function unset_block_vars($blockname)
	{
		// find the block (last iteration)
		if ( strstr($blockname, '.') )
		{
			$blocks = explode('.', $blockname);
			$blockcount = sizeof($blocks) - 1;

			$str = &$this->_tpldata; 
			for ($i = 0; $i < $blockcount; $i++) 
			{
				$str = &$str[ $blocks[$i] ];
				$str = &$str[ sizeof($str) - 1 ];
			}
			if ( isset($str[ $blocks[$blockcount] ]) )
			{
				unset($str[ $blocks[$blockcount] ]);
				return true;
			}
		}
		else
		{
			if ( isset($this->_tpldata[$blockname]) )
			{
				unset($this->_tpldata[$blockname]);
				return true;
			}
		}
		return false;
	}

	// hi-level functions
	function sprintf()
	{
		$parms = func_get_args();
		return count($parms) < 2 ? '' : array(TPL_FUNC => '_sprintf', TPL_PARM => $parms);
	}

	function concat()
	{
		$parms = func_get_args();
		return empty($parms) ? '' : array(TPL_FUNC => '_implode', TPL_PARM => array_merge(array(''), $parms));
	}

	function implode()
	{
		$parms = func_get_args();
		return empty($parms) ? '' : array(TPL_FUNC => '_implode', TPL_PARM => $parms);
	}

	function clean_html($parms)
	{
		return empty($parms) ? '' : array(TPL_FUNC => '_clean_html', TPL_PARM => $parms);
	}

	function htmlencode($parms)
	{
		return empty($parms) ? '' : array(TPL_FUNC => '_htmlencode', TPL_PARM => $parms);
	}

	function lang($key)
	{
		return empty($key) ? '' : array(TPL_FUNC => '_lang', TPL_PARM => $key);
	}

	function img($key)
	{
		return array(TPL_FUNC => '_img', TPL_PARM => $key);
	}

	function img_styled($key)
	{
		return array(TPL_FUNC => '_img_styled', TPL_PARM => $key);
	}

	function img_styled_get($key='')
	{
		global $config;
		if ( empty($key) )
		{
			return '';
		}
		$path = $key;
		if ( isset($this->local_images[$key]) )
		{
			$path = $this->local_images[$key];
		}
		else if ( @file_exists($this->root . $key) )
		{
			$path = $this->root . $key;
		}
		else if ( @file_exists($this->alt_root . $key) )
		{
			$path = $this->alt_root . $key;
		}
		else if ( $config->root != './' )
		{
			$path = $config->root . $key;
		}
		$this->local_images[$key] = $path;
		return $path;
	}

	// this one will only works with root level blocks switch
	function move_vars($from, $to)
	{
		$this->_tpldata[$to] = isset($this->_tpldata[$from]) ? $this->_tpldata[$from] : false;
		$this->unset_block_vars($from);
	}

	function include_file($filename, $tpl_reassign='')
	{
		$parms = '';
		if ( $tpl_reassign )
		{
			$tpl_reassign = !is_array($tpl_reassign) ? array($tpl_reassign) : $tpl_reassign;
			$this->_id++;
			foreach ( $tpl_reassign as $blockname )
			{
				$parms .= ', _' . $this->_id . '_' . $blockname . ' => ' . $blockname;
				$this->move_vars($blockname, '_' . $this->_id . '_' . $blockname);
			}
		}
		return array(TPL_FUNC => '_include', TPL_PARM => $filename . $parms);
	}

	function include_escaped_file($filename, $tpl_reassign='')
	{
		$res = $this->include_file($filename, $tpl_reassign);
		return array(TPL_FUNC => '_include_escaped', TPL_PARM => $res[TPL_PARM]);
	}

	// used at display-time, but only within the display-time functions, not by the compiler itself
	function _get_include_parms($filename)
	{
		if ( !empty($filename) )
		{
			$tpl_reassign = explode(',', $filename);
			$parms = array();
			foreach ( $tpl_reassign as $item )
			{
				if ( empty($parms) )
				{
					$parms[] = trim($item);
					$first = false;
				}
				else if ( ($item = explode('=>', $item)) && ($from = trim($item[0])) && ($to = trim($item[1])) )
				{
					$this->move_vars($from, $to);
					$parms[] = $to;
				}
			}
		}
		return empty($parms) ? false : $parms;
	}

	function _delete_include_parms($filename)
	{
		if ( empty($filename) )
		{
			return;
		}
		$first = true;
		foreach ( $filename as $to )
		{
			if ( !$first )
			{
				$this->unset_block_vars($to);
			}
			$first = false;
		}
	}

	//
	// display-time functions
	//
	function _handle_value($varref)
	{
		return is_array($varref) ? (isset($varref[TPL_FUNC]) && isset($varref[TPL_PARM]) ? $this->{$this->_handle_value($varref[TPL_FUNC])}($this->_handle_value($varref[TPL_PARM])) : array_map(array(&$this, '_handle_value'), $varref)) : $varref;
	}

	function _echo($varref)
	{
		echo is_array($varref) ? $this->_handle_value($varref) : $varref;
	}

	function _sprintf($parms)
	{
		return call_user_func_array('sprintf', $parms);
	}

	function _implode($parms)
	{
		return implode($parms[0], $parms[1]);
	}

	function _clean_html($parms)
	{
		return _clean_html($parms);
	}

	function _htmlencode($parms)
	{
		return _htmlencode($parms);
	}

	// Include a seperate template
	function _include($filename)
	{
		if ( $filename = $this->_get_include_parms($filename) )
		{
			$this->set_filenames(array($filename[0] => $filename[0]));
			$this->pparse($filename[0]);
			$this->_delete_include_parms($filename);
		}
		return '';
	}

	function _include_escaped($filename)
	{
		if ( $filename = $this->_get_include_parms($filename) )
		{
			$no_debug = $this->no_debug;
			$this->no_debug = true;
			$this->set_filenames(array($filename[0] => $filename[0]));
			echo $this->_escape_string($this->get_pparse($filename[0]));
			$this->_delete_include_parms($filename);
			$this->no_debug = $no_debug;
		}
		return '';
	}

	function _escape_string($str)
	{
		return str_replace(array('<br />', '&nbsp;', '<', '>', '"'), array("\n", ' ', '&lt;', '&gt;', '&quot;'), preg_replace("/[\n\r]{1,2}/", '', $str));
	}

	// user api support
	function _lang($key='')
	{
		global $user, $lang, $requester;

		if ( !empty($key) )
		{
			if ( is_object($user) && !$user->lang_set )
			{
				$user->set_lang($requester);
			}
			return isset($lang[$key]) ? $lang[$key] : $key;
		}
		return '';
	}

	function _img($key='')
	{
		global $images, $config;
		return empty($key) ? '' : (isset($images[$key]) ? $config->root . $images[$key] : (preg_match('#^[h|f]tp[s]?:\/\/#i', $key) ? $key : $config->root . $key));
	}

	function _img_styled($key='')
	{
		return $this->img_styled_get($key);
	}
}

?>