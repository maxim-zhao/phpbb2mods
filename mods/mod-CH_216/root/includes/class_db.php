<?php
//
//	file: includes/class_db.php
//	author: ptirhiik
//	begin: 25/08/2004
//	version: 1.6.6 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

function _sql_type_cast($value, $quotes=true)
{
	return
		is_string($value) ? ($quotes ? '\'' : '') . str_replace(array('\\\'', '\\"'), array('\'\'', '"'), addslashes($value)) . ($quotes ? '\'' : '') : (
		is_float($value) ? doubleval($value) : (
		is_integer($value) || is_bool($value) ? intval($value) : (
		'\'\''
	)));
}

function _sql_map_fields($key, $value)
{
	return $key . ' = ' . _sql_type_cast($value);
}

class db_class extends sql_db
{
	var $trc_sql;
	var $sql_fields;
	var $sql_values;
	var $sql_update;
	var $sql_stack_fields;
	var $sql_stack_values;

	var $sql_version;

	function db_class($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{
		@parent::sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency);
		$this->trc_sql = array();
		$this->sql_version = array();
	}

	function sql_query($query='', $transaction=false, $line='', $file='', $break_on_error=true)
	{
		if ( empty($file) )
		{
			$break_on_error = false;
		}
		if ( defined('DEBUG_RUN_STATS') )
		{
			$query_start = microtime();
		}
		$query_res = parent::sql_query($query, $transaction);
		if ( defined('DEBUG_RUN_STATS') )
		{
			$query_end = microtime();
			if ( defined('DEBUG_SQL') )
			{
				if ( empty($file) && function_exists('debug_backtrace') )
				{
					$dbg = debug_backtrace();
					$file = $dbg[0]['file'];
					$line = $dbg[0]['line'];
					unset($dbg);
				}
				$this->trc_sql[] = array('file' => empty($file) ? '?' : basename($file), 'line' => $line, 'sql' => $query, 'start' => $query_start, 'end' => $query_end, 'after_debug' => microtime());
			}
			else
			{
				$this->trc_sql[] = array('start' => $query_start, 'end' => $query_end, 'after_debug' => microtime());
			}
		}
		if ( !$query_res && $break_on_error )
		{
			message_die(GENERAL_ERROR, 'SQL requests not achieved', '', $line, $file, htmlspecialchars($query));
		}
		return $query_res;
	}

	function sql_escape_string($str)
	{
		return _sql_type_cast((string) $str, false);
	}

	function sql_type_cast($value)
	{
		return _sql_type_cast($value);
	}

	function sql_fields($mode, &$fields, $fields_inc='')
	{
		switch ( $mode )
		{
			case 'fields':
				return empty($fields) ? '' : implode(', ', array_keys($fields));
			case 'values':
				return empty($fields) ? '' : implode(', ', array_map('_sql_type_cast', array_values($fields)));
			case 'update':
				$inc = array();
				if ( !empty($fields_inc) )
				{
					foreach ( $fields_inc as $field => $indent )
					{
						if ( $indent != 0 )
						{
							$inc[] = $field . ' = ' . $field . ($indent < 0 ? ' - ' : ' + ') . abs($indent);
						}
					}
				}
				return empty($fields) && empty($inc) ? '' : implode(', ', array_merge(empty($inc) ? array() : $inc, empty($fields) ? array() : array_map('_sql_map_fields', array_keys($fields), array_values($fields))));
			default:
				return '';
		}
	}

	// will be depreciated: use in place sql_fields()
	function sql_statement(&$fields, $fields_inc='')
	{
		// init result
		$this->sql_fields = $this->sql_values = $this->sql_update = '';
		if ( empty($fields) && empty($fields_inc) )
		{
			return;
		}

		// process
		$this->sql_fields = $this->sql_fields('fields', $fields);
		$this->sql_values = $this->sql_fields('values', $fields);
		$this->sql_update = $this->sql_fields('update', $fields, $fields_inc);
	}

	function sql_stack_reset($id='')
	{
		if ( empty($id) )
		{
			$this->sql_stack_fields = array();
			$this->sql_stack_values = array();
		}
		else
		{
			$this->sql_stack_fields[$id] = array();
			$this->sql_stack_values[$id] = array();
		}
	}

	function sql_stack_statement(&$fields, $id='')
	{
		if ( empty($id) )
		{
			$this->sql_stack_fields = $this->sql_fields('fields', $fields);
			$this->sql_stack_values[] = '(' . $this->sql_fields('values', $fields) . ')';
		}
		else
		{
			if ( empty($this->sql_stack_fields[$id]) )
			{
				$this->sql_stack_fields[$id] = $this->sql_fields('fields', $fields);
			}
			$this->sql_stack_values[$id][] = '(' . $this->sql_fields('values', $fields) . ')';
		}
	}

	function sql_stack_insert($table, $transaction=false, $line='', $file='', $break_on_error=true, $id='')
	{
		if ( (empty($id) && empty($this->sql_stack_values)) || (!empty($id) && empty($this->sql_stack_values[$id])) )
		{
			return false;
		}
		switch( SQL_LAYER )
		{
			case 'mysql':
			case 'mysql4':
				if ( empty($id) )
				{
					$sql = 'INSERT INTO ' . $table . '
								(' . $this->sql_stack_fields . ') VALUES ' . implode(",\n", $this->sql_stack_values);
				}
				else
				{
					$sql = 'INSERT INTO ' . $table . '
								(' . $this->sql_stack_fields[$id] . ') VALUES ' . implode(",\n", $this->sql_stack_values[$id]);
				}
				$this->sql_stack_reset($id);
				return $this->sql_query($sql, $transaction, $line, $file, $break_on_error);
				break;
			default:
				$count_sql_stack_values = empty($id) ? count($this->sql_stack_values) : count($this->sql_stack_values[$id]);
				$result = !empty($count_sql_stack_values);
				for ( $i = 0; $i < $count_sql_stack_values; $i++ )
				{
					if ( empty($id) )
					{
						$sql = 'INSERT INTO ' . $table . '
									(' . $this->sql_stack_fields . ') VALUES ' . $this->sql_stack_values[$i];
					}
					else
					{
						$sql = 'INSERT INTO ' . $table . '
									(' . $this->sql_stack_fields[$id] . ') VALUES ' . $this->sql_stack_values[$id][$i];
					}
					$result &= $this->sql_query($sql, $transaction, $line, $file, $break_on_error);
				}
				$this->sql_stack_reset($id);
				return $result;
				break;
		}
	}

	function sql_subquery($field, $sql, $line='', $file='', $break_on_error=true, $type=TYPE_INT)
	{
		// sub-queries doable
		$this->sql_get_version();
		if ( !in_array(SQL_LAYER, array('mysql', 'mysql4')) || (($this->sql_version[0] + ($this->sql_version[1] / 100)) >= 4.01) )
		{
			return $sql;
		}

		// no sub-queries
		$ids = array();
		$result = $this->sql_query(trim($sql), false, $line, $file, $break_on_error);
		while ( $row = $this->sql_fetchrow($result) )
		{
			$ids[] = $type == TYPE_INT ? intval($row[$field]) : $this->sql_type_cast((string) $row[$field]);
		}
		$this->sql_freeresult($result);
		return empty($ids) ? 'NULL' : implode(', ', $ids);
	}

	function sql_col_id($expr, $alias)
	{
		$this->sql_get_version();
		return in_array(SQL_LAYER, array('mysql', 'mysql4')) && (($this->sql_version[0] + ($this->sql_version[1] / 100)) <= 4.01) ? $alias : $expr;
	}

	function sql_get_version()
	{
		if ( empty($this->sql_version) )
		{
			$this->sql_version = array(0, 0, 0);
			switch ( SQL_LAYER )
			{
				case 'mysql':
				case 'mysql4':
					if ( function_exists('mysql_get_server_info') )
					{
						$lo_version = explode('-', mysql_get_server_info());
						$this->sql_version = explode('.', $lo_version[0]);
						$this->sql_version = array(intval($this->sql_version[0]), intval($this->sql_version[1]), intval($this->sql_version[2]), $lo_version[1]);
					}
					break;

				case 'postgresql':
				case 'mssql':
				case 'mssql-odbc':
				default:
					break;
			}
		}
		return $this->sql_version;
	}

	function sql_error()
	{
		if ( $this->db_connect_id )
		{
			return parent::sql_error();
		}
		else
		{
			return array();
		}
	}
}

class cache
{
	var $cache_path;
	var $cache_file;
	var $cache_disabled;
	var $from_cache;
	var $data_time;

	// constructor
	function cache($cache_file='', $cache_path='', $cache_disabled=false)
	{
		global $config;

		$this->cache_path = empty($cache_path) ? $config->data['cache_path'] : $cache_path;
		$this->cache_file = $cache_file;
		$this->cache_disabled = $cache_disabled;
	}

	// read or create the cache and return the data
	function sql_query($query='', $line='', $file='', $force=false, $key_field='')
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
			// read table
			$result = $db->sql_query($query, false, $line, $file);
			$this->data_time = time();
			$i = -1;
			$data = array();
			$this->pre_process($data);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$i = empty($key_field) ? ($i+1) : $row[$key_field];
				$data[$i] = $row;
				$this->row_process($data, $i);
			}
			$this->post_process($data);

			// free table
			$db->sql_freeresult($result);

			// write cache
			if ( !$this->cache_disabled )
			{
				$this->write_cache($data, $query);
			}
		}
		return $data;
	}

	function pre_process(&$rows)
	{
	}

	function row_process(&$rows, $row_id)
	{
	}

	function post_process(&$rows)
	{
	}

	function write_cache(&$data, &$query, $tpl_var='', $flat=false)
	{
		global $config;

		$tpl_var = empty($tpl_var) ? '$data' : $tpl_var;
		$tpl_data = '<' . '?php
//---------------------------------------------
// Generated : %s (GMT)
// Request : %s
//---------------------------------------------
if ( !defined(\'IN_PHPBB\') )
{
	die(\'Hack attempt\');
}
$gentime = %s;
$cache_key = \'%s\';
%s = %s;

?' . '>';

		// output to file
		$filename = $config->url($this->cache_path . $this->cache_file);
		$handle = @fopen($filename, 'w');
		@flock($handle, LOCK_EX);
		@fwrite($handle, sprintf($tpl_data, date('Y-m-d H:i:s', $this->data_time), preg_replace('/[\n\r\s\t]+/', ' ', $query), $this->data_time, $config->data['cache_key'], $tpl_var, $flat ? $data : 'unserialize(\'' . str_replace('\'', '\\\'', str_replace('\\', '\\\\', serialize($data))) . '\')'));
		@flock($handle, LOCK_UN);
		@fclose($handle);
		@umask(0000);
		@chmod($filename, 0644);
	}
}

?>