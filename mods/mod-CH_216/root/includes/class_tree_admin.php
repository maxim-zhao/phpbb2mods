<?php
//
//	file: includes/class_tree_admin.php
//	author: ptirhiik
//	begin: 11/11/2005
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('PREVIOUS_ITEM', false);
define('NEXT_ITEM', true);

class admin_tree
{
	var $tree;

	function admin_tree(&$tree)
	{
		$this->tree = &$tree;
	}

	function get_list($front_pic)
	{
		global $user;

		$res = array();
		if ( !empty($front_pic) )
		{
			foreach ( $front_pic as $cur_id => $front )
			{
				$count_front = strlen($front);
				$options = '';
				for ( $i = 0; $i < $count_front; $i++ )
				{
					$options .= $user->lang('tree_pic_' . $front[$i]);
				}
				if ( $cur_id >= 0 )
				{
					$options .= $user->lang($this->tree->data[$cur_id][$this->tree->_field . '_name']);
				}
				$res[$cur_id] = $options;
			}
		}
		return $res;
	}

	function neighbor_id($_id, $next_previous, $care_of_subs=true)
	{
		if ( empty($_id) || empty($this->tree->data[ $this->tree->data[$_id][$this->tree->_field . '_main'] ]['subs']) )
		{
			return $_id;
		}

		$tsubs = array_flip($this->tree->data[ $this->tree->data[$_id][$this->tree->_field . '_main'] ]['subs']);
		$i = ($next_previous == NEXT_ITEM) ? $tsubs[$_id] + 1 : $tsubs[$_id] - 1;
		if ( ($i < 0) || ($i >= count($tsubs)) )
		{
			return (($i < 0) && ($next_previous == PREVIOUS_ITEM)) ? intval($this->tree->data[$_id][$this->tree->_field . '_main']) : $_id;
		}
		return $care_of_subs ? $this->tree->data[ $this->tree->data[ $this->tree->data[$_id][ $this->tree->_field . '_main'] ]['subs'][$i] ]['last_child_id'] : $this->tree->data[ $this->tree->data[$_id][$this->tree->_field . '_main'] ]['subs'][$i];
	}

	// used for move, update and delete
	function move($_id, $after_id, $delete_root=false, $delete_branch=false, $new_main_id=0)
	{
		global $db, $config;

		$_id = intval($_id);
		$after_id = intval($after_id);
		$new_main_id = intval($new_main_id);

		// move after itself = no process
		if ( $_id == $after_id )
		{
			return false;
		}

		// ids to delete, sent as result
		$deleted_ids = array();

		// get the min and the max position of the branch to move
		$tkeys = array_flip($this->tree->keys);
		$min = $tkeys[$_id];
		$max = $tkeys[ $this->tree->data[$_id]['last_child_id'] ];
		unset($tkeys);

		// process
		$update = false;
		$order = -10;
		$count_keys = count($this->tree->keys);
		for ( $i = 0; $i < $count_keys; $i++ )
		{
			// ignore branch to move
			if ( ($i >= $min) && ($i <= $max) )
			{
				$update = true;
				if ( $delete_branch || (($i == $min) && $delete_root) )
				{
					$deleted_ids[] = $this->tree->keys[$i];
				}
			}

			// point of insertion
			if ( $this->tree->keys[$i] == $after_id )
			{
				$order += 10;
				if ( !empty($this->tree->keys[$i]) && $update )
				{
					$sql = 'UPDATE ' . $this->tree->_table . '
								SET ' . $this->tree->_field . '_order = ' . $order . '
								WHERE ' . $this->tree->_field . '_id = ' . $this->tree->keys[$i];
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
				$update = true;

				if ( !$delete_branch )
				{
					// insert branch
					$start = $min;
					$subs = array();
					if ( $delete_root )
					{
						$start++;
						$new_main = ', ' . $this->tree->_field . '_main = ' . $new_main_id;
						$subs = empty($this->tree->data[$_id]['subs']) ? array() : array_flip($this->tree->data[$_id]['subs']);
					}
					for ( $j = $start; $j <= $max; $j++ )
					{
						$order += 10;
						$sql_main = $delete_root && isset($subs[ $this->tree->keys[$j] ]) ? $new_main : '';
						$sql = 'UPDATE ' . $this->tree->_table . '
									SET ' . $this->tree->_field . '_order = ' . $order . $sql_main . '
									WHERE ' . $this->tree->_field . '_id = ' . $this->tree->keys[$j];
						$db->sql_query($sql, false, __LINE__, __FILE__);
					}
				}
			}
			// process all what isn't at the insert point or belonging to the branch to move
			else if ( ($i < $min) || ($i > $max) )
			{
				// something has been moved before this one : update order
				$order += 10;
				if ( !empty($this->tree->keys[$i]) && $update )
				{
					$sql = 'UPDATE ' . $this->tree->_table . '
								SET ' . $this->tree->_field . '_order = ' . $order . '
								WHERE ' . $this->tree->_field . '_id = ' . $this->tree->keys[$i];
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
			}
		}

		return $deleted_ids;
	}

	// used for insertion
	function renum()
	{
		global $db;

		// read all ids sorted
		$sql = 'SELECT ' . $this->tree->_field . '_id
					FROM ' . $this->tree->_table . '
					ORDER BY ' . $this->tree->_field . '_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$_ids = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$_ids[] = intval($row[$this->tree->_field . '_id']);
		}
		$db->sql_freeresult($result);

		// renum them
		$order = 0;
		$count_ids = count($_ids);
		for ( $i = 0; $i < $count_ids; $i++ )
		{
			if ( !empty($_ids[$i]) )
			{
				$order += 10;
				$sql = 'UPDATE ' . $this->tree->_table . '
							SET ' . $this->tree->_field . '_order = ' . $order . '
							WHERE ' . $this->tree->_field . '_id = ' . $_ids[$i];
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
		}
	}
}

?>