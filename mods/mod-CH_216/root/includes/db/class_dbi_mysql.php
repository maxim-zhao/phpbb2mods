<?php
//
//	file: includes/db/class_dbi_mysql.php
//	author: ptirhiik
//	begin: 16/01/2007
//	version: 1.7.3 - 01/07/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class dbi_mysql extends dbi
{
	function supported_types()
	{
		$this->numerics = array('tinyint' => 'tinyint', 'smallint' => 'smallint', 'mediumint' => 'mediumint', 'int' => 'int', 'bigint' => 'bigint', 'decimal' => 'decimal');
		$this->texts = array('char' => 'char', 'varchar' => 'varchar', 'text' => 'text', 'mediumtext' => 'mediumtext', 'longtext' => 'longtext');
	}

	// tables
	function create_table(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			$lines = array();

			// fields
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name => $field )
				{
					$lines[] = $field_name . ' ' . $this->field_def($field);
				}
			}

			// indexes
			if ( isset($table['index']) && !empty($table['index']) )
			{
				foreach ( $table['index'] as $index_name => $index )
				{
					$type = isset($index['type']) ? strtoupper($index['type']) : false;
					$lines[] = ($type && ($type != 'INDEX') ? $type . ' ' : '') . 'KEY ' . ($type != 'PRIMARY' ? $index_name . ' ' : '') . '(' . implode(', ', $index['field']) . ')';
				}
			}

			// build
			$sqls[] = 'CREATE TABLE ' . $this->table($table_name) . '(
	' . implode(',
	', $lines) . '
)';
		}
		return $sqls;
	}

	function drop_table(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		$sql = 'DROP TABLE ' . implode(', ', array_map(array(&$this, 'table'), $items['table']));
		return array($sql);
	}

	function rename_table(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}
		$lines = array();
		foreach ( $items['table'] as $table_name => $new_name )
		{
			$lines[] = $this->table($table_name) . ' TO ' . $this->table($new_name);
		}
		$sql = 'RENAME TABLE 
	' . implode(',
	', $lines);
		return array($sql);
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
			if ( isset($table['index']) || empty($table['index']) )
			{
				foreach ( $table['index'] as $index_name => $index )
				{
					$type = isset($index['type']) && !empty($index['type']) ? strtoupper($index['type']) : 'INDEX';
					$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ADD ' . $type . ' ' . ($type == 'PRIMARY' ? 'KEY ' : $index_name . ' ') . '(' . implode(', ', $index['field']) . ')';
				}
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
					$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' DROP ' . ($index_name == 'PRIMARY' ? 'PRIMARY KEY' : 'INDEX ' . $index_name);
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
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				foreach ( $table['field'] as $field_name => $field )
				{
					$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' ADD COLUMN ' . $field_name . ' ' . $this->field_def($field);
				}
			}
		}
		return $sqls;
	}

	function change_field(&$items)
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
				foreach ( $table['field'] as $field_name => $field )
				{
					$sqls[] = 'ALTER TABLE ' . $this->table($table_name) . ' CHANGE COLUMN ' . $field_name . ' ' . (isset($field['new_name']) ? $field['new_name'] : $field_name) . ' ' . $this->field_def($field);
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
	function field_def($field)
	{
		if ( isset($field['new_type']) && !empty($field['new_type']) )
		{
			$field['type'] = $field['new_type'];
		}
		if ( isset($field['new_name']) && !empty($field['new_name']) )
		{
			$res['new_name'] = $field['new_name'];
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

		$res = '';
		$type = strtolower($field['type']);

		// numerics
		if ( isset($this->numerics[$type]) )
		{
			$res .= $this->numerics[$type];
			$auto_increment = isset($field['extra']) && ($field['extra'] == 'auto_increment');
			$unsigned = $auto_increment;
			if ( isset($field['size']) && !empty($field['size']) )
			{
				$unsigned |= strpos($field['size'], '-') === false;
				$size = preg_replace('/[\+\-\n\r\s\t]+/', '', $field['size']);
				if ( !empty($size) )
				{
					$res .= '(' . $size . ')';
				}
			}
			if ( $unsigned )
			{
				$res .= ' UNSIGNED';
			}
			if ( $auto_increment )
			{
				$res .= ' auto_increment';
			}
			else
			{
				if ( !isset($field['default']) || empty($field['default']) || ($field['default'] === '0') || ($field['default'] === 0) )
				{
					$field['default'] = $type == 'decimal' ? '0.0' : '0';
				}
				$res .= strtoupper($field['default']) == 'NULL' ? ' DEFAULT NULL' : ' NOT NULL DEFAULT \'' . $field['default'] . '\'';
			}
		}

		// alpha-numerics
		else
		{
			$res .= isset($this->texts[$type]) ? $this->texts[$type] : $type;
			if ( isset($field['size']) && !empty($field['size']) )
			{
				$res .= '(' . $field['size'] . ')';
			}
			if ( ($field['type'] == 'char') && ($field['size'] == 1) )
			{
				$res .= ' BINARY';
			}
			if ( !in_array($type, array('text', 'mediumtext', 'longtext')) )
			{
				if ( !isset($field['default']) || empty($field['default']) )
				{
					$field['default'] = '';
				}
				$match = array();
				$default = preg_match('/^["\'](.*)["\']$/is', $field['default'], $match) ? $match[1] : $field['default'];
				$res .= strtoupper($field['default']) == 'NULL' ? ' DEFAULT NULL' : ' NOT NULL DEFAULT \'' . $this->sql_escape_string((string) $default) . '\'';
			}
		}
		return $res;
	}
}

?>