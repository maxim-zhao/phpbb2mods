<?php
//
//	file: includes/db/class_dbi_pgsql.php
//	author: ptirhiik
//	begin: 16/01/2007
//	version: 1.7.1 - 01/07/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class dbi_pgsql extends dbi
{
	var $recent;
	var $version;

	function supported_types()
	{
		$this->numerics = array('tinyint' => 'smallint', 'smallint' => 'smallint', 'mediumint' => 'integer', 'int' => 'integer', 'bigint' => 'bigint', 'decimal' => 'decimal');
		$this->texts = array('char' => 'char', 'varchar' => 'varchar', 'text' => 'text', 'mediumtext' => 'text', 'longtext' => 'text');
		$this->get_version();
		$this->recent = $this->version_ge('8');
	}

	function get_version()
	{
		// get version
		$this->version = '';

		// we assume server version and client version are enough close regarding the major version (7/8)
		if ( function_exists('pg_version') )
		{
			$version = @pg_version($this->db_connect_id);
			if ( ($version) && is_array($version) && isset($version['client']) && !empty($version['client']) )
			{
				$this->version = $version['client'];
			}
		}
		if ( empty($this->version) )
		{
			$sql = 'SELECT version() AS pgsql_version';
			$result = $this->sql_query($sql, false, __LINE__, __FILE__, false);
			if ( $result !== false )
			{
				$this->version = ($row = $this->sql_fetchrow($result)) ? $row['pgsql_version'] : false;
				$this->sql_freeresult($result);
			}
			unset($result);
		}
		if ( !empty($this->version) )
		{
			$match = array();
			preg_match_all('#[\.]?([0-9]+)[\.]?#', $this->version, $match);
			$this->version = !isset($match[1]) || empty($match[1]) ? '' : array_pad(array_map('intval', array_slice($match[1], 0, 3)), 3, 0);
			unset($match);
		}
		if ( empty($this->version) || ($this->version == array(0, 0, 0)) )
		{
			$this->version = array(7, 0, 0);
		}
	}

	function version_ge($version)
	{
		if ( !$this->version )
		{
			return false;
		}
		$version = array_map('intval', explode('.', $version . '.0.0.0'));
		for ( $i = 0; $i < 3; $i++ )
		{
			if ( $this->version[$i] != $version[$i] )
			{
				return $this->version[$i] > $version[$i];
			}
		}
		return true;
	}

	// tables
	function create_table(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}

		// first search for all sequences
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name => $field )
				{
					if ( isset($field['extra']) && ($field['extra'] == 'auto_increment') )
					{
						$sqls[] = 'CREATE SEQUENCE ' . $this->table($table_name) . '_id_seq';
					}
				}
			}
		}

		// then process the table structure
		foreach ( $items['table'] as $table_name => $table )
		{
			$lines = array();
			if ( isset($table['field']) && !empty($table['field']) )
			{
				// fields
				foreach ( $table['field'] as $field_name => $field )
				{
					$lines[] = $this->field_line($table_name, $field_name, $this->field_def($field));
				}

				// search for the primary key
				if ( isset($table['index']) && !empty($table['index']) )
				{
					$res = '';
					foreach ( $table['index'] as $index_name => $index )
					{
						if ( isset($index['type']) && (strtoupper($index['type']) == 'PRIMARY') )
						{
							$res = 'CONSTRAINT ' . $this->table($table_name) . '_pkey PRIMARY KEY (' . implode(', ', $index['field']) . ')';
						}
					}
					if ( !empty($res) )
					{
						$lines[] = $res;
					}
				}

				// request
				$sqls[] = 'CREATE TABLE ' . $this->table($table_name) . ' (
	' . implode(',
	', $lines) . '
)';

				// other indexes
				if ( isset($table['index']) && !empty($table['index']) )
				{
					$sqls = array_merge($sqls, $this->create_index_table($table, $table_name, false));
				}
			}
		}
		return $sqls;
	}

	function drop_table(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		foreach ( $items['table'] as $idx => $table_name )
		{
			$sqls[] = 'DROP TABLE ' . $this->table($table_name);

			// do we have an existing sequence ?
			$sql = 'SELECT currval(\'' . $this->table($table_name) . '_id_seq\') AS currval_id_seq';
			$result = $this->sql_query($sql);
			if ( $result !== false )
			{
				$this->sql_freeresult($result);
				$sqls[] = 'DROP SEQUENCE ' . $this->table($table_name) . '_id_seq';
			}
			unset($result);
		}
		return $sqls;
	}

	function rename_table(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		foreach ( $items['table'] as $table_name => $new_name )
		{
			$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' RENAME TO ' . $this->table($new_name);
		}
		return $sqls;
	}

	// indexes
	function create_index(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['index']) && !empty($table['index']) )
			{
				$sqls = array_merge($sqls, $this->create_index_table($table, $table_name, true));
			}
		}
		return $sqls;
	}

	function drop_index(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['index']) && !empty($table['index']) )
			{
				foreach ( $table['index'] as $idx => $index_name )
				{
					if ( $index_name != 'PRIMARY' )
					{
						$sqls[] = 'DROP INDEX ' . $this->table($table_name) . '_' . $index_name;
					}
					else
					{
						$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' DROP CONSTRAINT ' . $this->table($table_name) . '_pkey';
					}
				}
			}
		}
		return $sqls;
	}

	// fields
	function create_field(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		return $this->recent ? $this->create_field_new($items) : $this->create_field_old($items);
	}
	function change_field(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		return $this->recent ? $this->change_field_new($items) : $this->change_field_old($items);
	}

	function create_field_new(&$items)
	{
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name => $field )
				{
					$field_def = $this->field_def($field);
					if ( !$field_def['identity'] )
					{
						$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ADD COLUMN ' . $this->field_line($table_name, $field_name, $field_def);
					}
				}
			}
		}
		return $sqls;
	}

	function create_field_old(&$items)
	{
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name => $field )
				{
					$field_def = $this->field_def($field);
					if ( !$field_def['identity'] )
					{
						$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ADD COLUMN ' . $field_name . ' ' . $field_def['type'] . ($field_def['size'] ? '(' . $field_def['size'] . ')' : '');
						if ( isset($field_def['default']) )
						{
							$sqls[] = 'UPDATE ' . $this->table($table_name) . ' SET ' . $field_name . ' = ' . $field_def['default'] . ' WHERE ' . $field_name . ' IS NULL';
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' SET DEFAULT ' . ($field_def['is_numeric'] ? '\'' . $field_def['default'] . '\'' : $field_def['default']);
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' SET NOT NULL';
						}
					}
				}
			}
		}
		return $sqls;
	}

	function change_field_new(&$items)
	{
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name => $field )
				{
					$field_def = $this->field_def($field);
					if ( !$field_def['identity'] )
					{
						if ( isset($field['new_type']) )
						{
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' TYPE ' . $field_def['type'] . ($field_def['size'] ? '(' . $field_def['size'] . ')' : '');
						}
						if ( isset($field_def['default']) )
						{
							$sqls[] = 'UPDATE ' . $this->table($table_name) . ' SET ' . $field_name . ' = ' . $field_def['default'] . ' WHERE ' . $field_name . ' IS NULL';
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' SET DEFAULT ' . ($field_def['is_numeric'] ? '\'' . $field_def['default'] . '\'' : $field_def['default']);
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' SET NOT NULL';
						}
						else if ( isset($field_def['force_null']) )
						{
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' DROP DEFAULT';
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' DROP NOT NULL';
						}
						if ( isset($field['new_name']) )
						{
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' RENAME COLUMN ' . $field_name . ' TO ' . $field['new_name'];
						}
					}
				}
			}
		}
		return $sqls;
	}

	function change_field_old(&$items)
	{
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name => $field )
				{
					$field_def = $this->field_def($field);
					if ( !$field_def['identity'] )
					{
						$new_field = $old_name = false;
						if ( isset($field['new_type']) || (isset($field['new_size']) && isset($field_def['size'])) )
						{
							if ( isset($field['new_name']) )
							{
								$new_field = $field['new_name'];
								$old_name = $field_name;
							}
							else
							{
								$new_field = $field_name;
								$old_name = $field_name . '_old';
								$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' RENAME COLUMN ' . $new_field . ' TO ' . $old_name;
							}
						}
						if ( $new_field )
						{
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ADD COLUMN ' . $new_field . ' ' . $field_def['type'] . (isset($field_def['size']) ? '(' . $field_def['size'] . ')' : '');
						}
						if ( isset($field_def['default']) )
						{
							$sqls[] = 'UPDATE ' . $this->table($table_name) . ' SET ' . $field_name . ' = ' . $field_def['default'] . ' WHERE ' . $field_name . ' IS NULL';
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' SET DEFAULT ' . ($field_def['is_numeric'] ? '\'' . $field_def['default'] . '\'' : $field_def['default']);
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' SET NOT NULL';
						}
						else if ( isset($field_def['force_null']) && !$new_field )
						{
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' DROP DEFAULT';
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ALTER COLUMN ' . $field_name . ' DROP NOT NULL';
						}
						if ( $new_field )
						{
							$sqls[] = 'UPDATE ' . $this->table($table_name) . ' SET ' . $new_field . ' = ' . $old_name . ' WHERE ' . $old_name . ' IS NOT NULL';
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' DROP COLUMN ' . $old_name;
						}
						else if ( isset($field['new_name']) )
						{
							$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' RENAME COLUMN ' . $field_name . ' TO ' . $field['new_name'];
						}
					}
				}
			}
		}
		return $sqls;
	}

	function drop_field(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name )
				{
					$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' DROP COLUMN ' . $field_name;
				}
			}
		}
		return $sqls;
	}

	// private
	function create_index_table($table, $table_name, $with_primary)
	{
		$sqls = array();
		foreach ( $table['index'] as $index_name => $index )
		{
			$type = isset($index['type']) && (strtoupper($index['type']) != 'INDEX') ? strtoupper($index['type']) : '';
			if ( $type != 'PRIMARY' )
			{
				$sqls[] = 'CREATE ' . ($type ? $type . ' ' : '') . 'INDEX ' . $this->table($table_name) . '_' . $index_name . ' ON ' . $this->table($table_name) . ' (' . implode(', ', $index['field']) . ')';
			}
			else if ( $with_primary )
			{
				$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ADD CONSTRAINT ' . $this->table($table_name) . '_pkey PRIMARY KEY (' . implode(', ', $index['field']) . ')';
			}
		}
		return $sqls;
	}

	function field_line($table_name, $field_name, $field_def)
	{
		$res = array($field_name, $field_def['type']);
		if ( $field_def['size'] )
		{
			$res[] = '(' . $field_def['size'] . ')';
		}
		if ( $field_def['identity'] )
		{
			$res[] = 'DEFAULT';
			$res[] = 'nextval(\'' . $this->table($table_name) . '_id_seq\'::text)';
			$res[] = 'NOT NULL';
		}
		else if ( isset($field_def['default']) )
		{
			$res[] = 'DEFAULT';
			$res[] = $field_def['is_numeric'] ? '\'' . $field_def['default'] . '\'' : $field_def['default'];
			$res[] = ' NOT NULL';
		}
		return implode(' ', $res);
	}

	function field_def($field)
	{
		if ( isset($field['new_type']) && !empty($field['new_type']) )
		{
			$field['type'] = $field['new_type'];
		}
		if ( isset($field['new_size']) && !empty($field['new_size']) )
		{
			$field['size'] = $field['new_size'];
		}
		if ( isset($field['new_extra']) && !empty($field['new_extra']) )
		{
			$field['extra'] = $field['new_extra'];
		}
		if ( isset($field['new_default']) && !empty($field['new_default']) )
		{
			$field['default'] = $field['new_default'];
		}
		$res = array();
		$type = strtolower($field['type']);
		$res['identity'] = false;

		// numerics
		if ( isset($this->numerics[$type]) )
		{
			$res['is_numeric'] = true;
			$res['type'] = $this->numerics[$type];
			if ( isset($field['size']) && !empty($field['size']) && ($type == 'decimal') )
			{
				$size = preg_replace('#[\+\-\n\r\s\t]+#', '', $field['size']);
				if ( !empty($size) )
				{
					$res['size'] = $size;
				}
			}
			if ( isset($field['extra']) && ($field['extra'] == 'auto_increment') )
			{
				$res['identity'] = true;
			}
			else
			{
				if ( !isset($field['default']) )
				{
					$res['default'] = $type == 'decimal' ? '0.0' : '0';
				}
				else if ( strtoupper($field['default']) != 'NULL' )
				{
					$res['default'] = $field['default'];
				}
				else
				{
					$res['force_null'] = true;
				}
			}
		}

		// alpha-numerics
		else
		{
			$res['is_numeric'] = false;
			$res['type'] = isset($this->texts[$type]) ? $this->texts[$type] : $type;
			if ( isset($field['size']) && !empty($field['size']) )
			{
				$res['size'] = $field['size'];
			}
			if ( !isset($field['default']) || empty($field['default']) )
			{
				$field['default'] = '';
			}
			else
			{
				$match = array();
				$field['default'] = preg_match('#^["\'](.*)["\']$#is', $field['default'], $match) ? $match[1] : $field['default'];
			}
			if ( strtoupper($field['default']) != 'NULL' )
			{
				$res['default'] = '\'' . $this->sql_escape_string((string) $field['default']) . '\'';
			}
			else
			{
				$res['force_null'] = true;
			}
		}
		return $res;
	}
}

?>