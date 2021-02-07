<?php
//
//	file: includes/class_tree.php
//	author: ptirhiik
//	begin: 11/11/2005
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('LOWER_ID', -100);

class cache_tree extends cache
{
	var $_field;

	function cache_tree($cache_file, $cache_path, $cache_disabled, $_field)
	{
		parent::cache($cache_file, $cache_path, $cache_disabled);
		$this->_field = $_field;
	}

	function pre_process(&$rows)
	{
		$rows[0] = array();
	}

	function row_process(&$rows, $row_id)
	{
		$rows[$row_id]['last_child_id'] = $row_id;
		$rows[$row_id]['subs'] = array();
		if ( !empty($row_id) )
		{
			$rows[ intval($rows[$row_id][$this->_field . '_main']) ]['subs'][] = $row_id;
		}
	}

	function post_process(&$rows)
	{
		// overwrite root
		$rows[0] = array_merge($rows[0], array(
			$this->_field . '_id' => 0,
			$this->_field . '_main' => 0,
			$this->_field . '_order' => 0,
		));

		// get keys and last branch id
		$keys = array_keys($rows);
		$count_keys = count($keys);
		for ( $i = $count_keys-1; $i > 0; $i-- )
		{
			$main_id = intval($rows[ $keys[$i] ][$this->_field . '_main']);
			if ( $rows[$main_id]['last_child_id'] == $main_id )
			{
				$rows[$main_id]['last_child_id'] = $rows[ $keys[$i] ]['last_child_id'];
			}
		}
	}
}

class tree
{
	var $_type;
	var $_table;
	var $_field;
	var $_cache;
	var $_auths;

	var $data;
	var $data_time;
	var $keys;
	var $data_flag;
	var $from_cache;

	function tree($_type, $_table, $_field, $_auths, $_cache='')
	{
		$this->_type = $_type;
		$this->_table = $_table;
		$this->_field = $_field;
		$this->_auths = empty($_auths) ? array() : (is_array($_auths) ? $_auths : array($_auths));
		$this->_cache = empty($_cache) ? 'dta_' . $this->_field : $_cache;

		$this->data = array();
		$this->keys = array();
		$this->data_flag = false;
		$this->data_time = 0;
		$this->from_cache = false;
	}

	function read($force=false)
	{
		global $config;

		// already readen
		if ( $this->data_flag && !$force )
		{
			return;
		}

		// read data
		$config->data['cache_disabled_' . $this->_type] |= empty($config->data['cache_key']);
		$db_cached = new cache_tree($this->_cache, $config->data['cache_path'], $config->data['cache_disabled_' . $this->_type], $this->_field);
		$sql = 'SELECT *
					FROM ' . $this->_table . '
					ORDER BY ' . $this->_field . '_order';
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force, $this->_field . '_id');
		$this->data_flag = true;
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;
		$this->keys = array_keys($this->data);
	}

	function get_front_pic($mode='', $_id=0, $except_child_id=0)
	{
		global $user;

		// admin context : except the branch the _id is root
		switch ( $mode )
		{
			case 'except':
				// get forum asked branch idx
				$tkeys = array_flip($this->keys);
				$min = $tkeys[$_id];
				$max = $tkeys[ $this->data[$_id]['last_child_id'] ];
				unset($tkeys);

				// extract the omitted branch
				$keys = $this->keys;
				array_splice($keys, $min, ($max - $min + 1));
				$keys = empty($keys) ? array() : array_keys(array_flip($keys));
				break;

			case 'only':
				// add _id
				$keys = array($_id);

				// add it's child
				$count_subs = count($this->data[$_id]['subs']);
				for ( $i = 0; $i < $count_subs; $i++ )
				{
					if ( $this->data[$_id]['subs'][$i] != $except_child_id )
					{
						$keys[] = $this->data[$_id]['subs'][$i];
					}
				}
				break;

			default:
				$keys = &$this->keys;
				break;
		}

		// retain only viewable ids (last ids per branch & level)
		$last_id = array();
		$main_ids = array();
		$level = array();
		$count_keys = count($keys);
		for ( $i = 0; $i < $count_keys; $i++ )
		{
			$cur_id = $keys[$i];
			if ( !$authed = empty($this->_auths) )
			{
				foreach ( $this->_auths as $auth_name )
				{
					if ( $authed = $user->auth($this->_type, $auth_name, $cur_id) )
					{
						break;
					}
				}
			}
			if ( !empty($mode) || $authed )
			{
				$last_id[$cur_id] = $cur_id;
				$main_ids[$cur_id] = 0;
				$level[$cur_id] = 0;
				if ( $i > 0 )
				{
					$main_id = intval($this->data[$cur_id][$this->_field . '_main']);
					while ( ($main_id > 0) && !isset($last_id[$main_id]) )
					{
						$main_id = intval($this->data[$main_id][$this->_field . '_main']);
					}
					$last_id[$main_id] = $cur_id;
					$main_ids[$cur_id] = $main_id;
					$level[$cur_id] = $level[$main_id] + 1;
				}
			}
		}

		// prepare return
		$front_pic = array();

		$close = array();
		$previous_level = 0;
		if ( !empty($last_id) )
		{
			foreach ( $last_id as $_id => $last_child_id )
			{
				$close[ $level[$_id] ] = empty($_id) || ($last_id[ $main_ids[$_id] ] == $_id);

				$linefeed = '';
				$option = '';
				for ( $i = 1; $i <= $level[$_id]; $i++ )
				{
					if ( $i == $level[$_id] )
					{
						$linefeed .= TREE_VSPACE;
						$option .= $close[$i] ? TREE_CLOSE : TREE_CROSS;
					}
					else
					{
						$linefeed .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
						$option .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
					}
				}
				if ( $previous_level > $level[$_id] )
				{
					$front_pic[ (LOWER_ID - count($front_pic)) ] = $linefeed;
				}
				$front_pic[$_id] = $option;
				$previous_level = $level[$_id];
			}
		}
		return $front_pic;
	}
}

?>