<?php
//
//	file: includes/db/class_dbi_mssql.php
//	author: ptirhiik
//	begin: 16/01/2007
//	version: 1.7.1 - 01/07/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class dbi_mssql extends dbi
{
	function supported_types()
	{
		$this->numerics = array('tinyint' => 'tinyint', 'smallint' => 'smallint', 'mediumint' => 'int', 'int' => 'int', 'bigint' => 'bigint', 'decimal' => 'decimal');
		$this->texts = array('char' => 'char', 'varchar' => 'varchar', 'text' => 'text', 'mediumtext' => 'text', 'longtext' => 'text');
	}

	// tables
	function create_table(&$items)
	{
		if ( empty($items) || !isset($items['table']) )
		{
			return array();
		}

		// then process the table structure
		foreach ( $items['table'] as $table_name => $table )
		{
			$db_table_name = $this->table($table_name);
			$lines = array();
			$dfts = array();
			if ( isset($table['field']) && !empty($table['field']) )
			{
				// fields
				$is_text = false;
				foreach ( $table['field'] as $field_name => $field )
				{
					$field = $this->field_def($field, $table_name);
					$lines[] = '[' . $field_name . '] [' . $field['type'] . ']' . ($field['size'] ? ' (' . $field['size'] . ')' : '') . ($field['identity'] ? ' IDENTITY (1, 1) NOT NULL' : (isset($field['default']) ? ' NOT NULL' : ' NULL'));

					// retain default value
					if ( !isset($field['identity']) && isset($field['default']) )
					{
						$dfts[$field_name] = $field['default'];
					}
					// check if a text field is present
					$is_text |= $field['type'] == 'text';
				}
				$sqls[] = 'CREATE TABLE [' . $db_table_name . '] (
	' . implode(',
	', $lines) . '
) ON [PRIMARY]' . ($is_text ? ' TEXTIMAGE_ON [PRIMARY]' : '');

				// defaults
				if ( $dfts )
				{
					$lines = array();
					foreach ( $dfts as $field_name => $default )
					{
						$lines[] = 'CONSTRAINT [DF_' . $db_table_name . '_' . $field_name . '] DEFAULT(' . $default . ') FOR [' . $field_name . ']';
					}
					if ( $lines )
					{
						$sqls[] = 'ALTER TABLE [' . $db_table_name . '] WITH NOCHECK ADD
	' . implode(',
	', $lines);
					}
				}

				// indexes
				if ( isset($table['index']) && !empty($table['index']) )
				{
					$sqls = array_merge($sqls, $this->create_index_table($table, $table_name));
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
			$sqls[] = 'DROP TABLE [' . $this->table($table_name) . ']';
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
			$sqls[] = 'EXECUTE sp_rename N\'' . $this->table($table_name) . '\', N\'' . $this->table($new_name) . '\', \'OBJECT\'';
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
				$sqls = array_merge($sqls, $this->create_index_table($table, $table_name));
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
				$db_table_name = $this->table($table_name);
				foreach ( $table['index'] as $idx => $index_name )
				{
					if ( $index_name == 'PRIMARY' )
					{
						$sqls[] = 'ALTER TABLE [' . $db_table_name . '] DROP CONSTRAINT [PK_' . $db_table_name . ']';
					}
					else
					{
						$sqls[] = 'DROP INDEX [' . $db_table_name . '].[IX_' . $db_table_name . '_' . $index_name . ']';
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
		$sqls = array();
		foreach ( $items['table'] as $table_name => $table )
		{
			if ( isset($table['field']) && !empty($table['field']) )
			{
				$db_table_name = $this->table($table_name);

				// fields
				foreach ( $table['field'] as $field_name => $field )
				{
					$field_def = $this->field_def($field, $table_name);

					// we can't add an identity field to an existing table, so set a default value to 0
					if ( isset($field_def['identity']) )
					{
						$field_def['default'] = 0;
					}

					$sqls[] = 'ALTER TABLE [' . $db_table_name . '] ADD [' . $field_name . '] [' . $field_def['type'] . ']' . ($field_def['size'] ? ' (' . $field_def['size'] . ')' : '') . (isset($field_def['default']) ? ' NOT NULL' : ' NULL');
					if ( isset($field_def['default']) )
					{
						$sqls[] = 'ALTER TABLE [' . $db_table_name . '] WITH NOCHECK ADD CONSTRAINT [DF_' . $db_table_name . '_' . $field_name . '] DEFAULT(' . $field_def['default'] . ') FOR [' . $field_name . ']';
					}
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
				$db_table_name = $this->table($table_name);

				// search first for fields renamed
				foreach ( $table['field'] as $field_name => $field )
				{
					$new_name = $old_name = false;
					if ( $field['new_name'] )
					{
						$field_def = $this->field_def($field, $table_name);
						$new_name = $field['new_name'];
						$old_name = $field_name;
						$create_field = array('table' => array($table_name => array(
							'field' => array($new_name => $field_def),
						)));
						$sqls = array_merge($sqls, $this->create_field($create_field));
						$sqls[] = 'UPDATE ' . $db_table_name . ' SET ' . $new_name . ' = ' . $old_name . ' WHERE ' . $new_name . ' IS NOT NULL;';
						$sqls = array_merge($sqls, $this->drop_column($table_name, $field_name));
					}
				}

				// other fields
				$constraints = array();
				$constraints_done = false;
				foreach ( $table['field'] as $field_name => $field )
				{
					if ( !isset($field['new_name']) )
					{
						$field_def = $this->field_def($field, $table_name);
						$change = isset($field['new_type']) && ($field_def['type'] != 'text');
						if ( isset($field['new_size']) )
						{
							$change |= !$field_def['is_numeric'] || ($field_def['type'] == 'decimal');
						}
						if ( isset($field['new_default']) && isset($field_def['default']) )
						{
							$change = true;

							// we need to update values to default when null prior adding NOT NULL
							$sqls[] = 'UPDATE ' . $db_table_name . ' SET ' . $field_name . ' = ' . $field_def['default'] . ' WHERE ' . $field_name . ' IS NULL';
							if ( isset($field['new_type']) || isset($field['new_default']) )
							{
								if ( !isset($field_def['identity']) )
								{
									if ( !$constraints_done )
									{
										$constraints_done = true;
										$constraints = $this->get_constraints($table_name);
									}
									if ( isset($constraints[$field_name]) && isset($constraints[$field_name]['DF_' . $db_table_name . '_' . $field_name]) )
									{
										$sqls[] = 'ALTER TABLE [' . $db_table_name . '] DROP CONSTRAINT [DF_' . $db_table_name . '_' . $field_name . ']';
									}
								}
							}
						}
						if ( $change )
						{
							if ( isset($field_def['identity']) )
							{
								$field_def['default'] = 0;
							}
							$sqls[] = 'ALTER TABLE [' . $db_table_name . '] ALTER COLUMN [' . $field_name . '] [' . $field_def['type'] . ']' . ($field_def['size'] ? ' (' . $field_def['size'] . ')' : '') . (isset($field_def['default']) ? ' NOT NULL' : ' NULL');
							if ( isset($field_def['default']) )
							{
								$sqls[] = 'ALTER TABLE [' . $db_table_name . '] WITH NOCHECK ADD CONSTRAINT [DF_' . $db_table_name . '_' . $field_name . '] DEFAULT(' . $field_def['default'] . ') FOR [' . $field_name . ']';
							}
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
			foreach ( $table['field'] as $idx => $field_name )
			{
				$sqls = array_merge($sqls, $this->drop_column($table_name, $field_name));
			}
		}
		return $sqls;
	}

	function get_constraints($table_name, $field_name='')
	{
		// read constraints
		$res = array();
		$sql = 'SELECT COL_NAME(id, colid) AS constraint_column, OBJECT_NAME(constid) AS constraint_name
					FROM [sysconstraints] WITH(NOLOCK)
					WHERE id = OBJECT_ID(\'' . $this->table($table_name) . '\')' . (empty($field_name) ? '
						AND colid <> 0 AND colid IS NOT NULL' : '
						AND COL_NAME(id, colid) = \'' . $field_name . '\'');
		$result = $this->sql_query($sql);
		if ( $result !== false )
		{
			while ( $row = $this->sql_fetchrow($result) )
			{
				$res[ $row['constraint_column'] ] = $row['constraint_name'];
			}
			$this->sql_freeresult($result);
		}
		return empty($res) ? false : $res;
	}

	function drop_column($table_name, $field_name)
	{
		global $db;

		$sqls = array();
		$db_table_name = $this->table($table_name);
		if ( ($constraints = $this->get_constraints($table_name, $field_name)) )
		{
			foreach ( $constraints as $dummy => $constraint_name )
			{
				$sqls[] = 'ALTER TABLE [' . $db_table_name . '] DROP CONSTRAINT [' . $row['constraint_name'] . ']';
			}
		}
		$sqls[] = 'ALTER TABLE [' . $db_table_name . '] DROP COLUMN [' . $field_name . ']';
		return $sqls;
	}

	// private
	function create_index_table($table, $table_name)
	{
		$db_table_name = $this->table($table_name);
		$sqls = array();
		foreach ( $table['index'] as $index_name => $index )
		{
			$type = isset($index['type']) && (strtoupper($index['type']) != 'INDEX') ? strtoupper($index['type']) : '';
			if ( $type == 'PRIMARY' )
			{
				$sqls[] = 'ALTER TABLE [' . $db_table_name . '] WITH NOCHECK ADD CONSTRAINT [PK_' . $db_table_name . '] PRIMARY KEY CLUSTERED ([' . implode('], [', $index['field']) . ']) ON [PRIMARY]';
			}
			else
			{
				$sqls[] = 'CREATE ' . ($type == 'UNIQUE' ? 'UNIQUE ' : '') . 'INDEX [IX_' . $db_table_name . '_' . $index_name . '] ON [' . $db_table_name . ']([' . implode('], [', $index['field']) . ']) ' . ($type == 'UNIQUE' ? 'WITH IGNORE_DUP_KEY ' : '') . 'ON [PRIMARY]';
			}
		}
		return $sqls;
	}

	function field_def($field, $table_name)
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
		$type = $field['new_type'] ? strtolower($field['new_type']) : strtolower($field['type']);

		// numerics
		if ( isset($this->numerics[$type]) )
		{
			$res['type'] = $this->numerics[$type];
			$res['is_numeric'] = true;
			if ( isset($field['size']) && !empty($field['size']) )
			{
				$size = preg_replace('/[\+\-\n\r\s\t]+/', '', $field['size']);
				if ( !empty($size) && ($type == 'decimal') )
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
				if ( !isset($field['default']) || empty($field['default']) || ($field['default'] === 0) || ($field['default'] === '0') )
				{
					$field['default'] = '0';
				}
				if ( strtoupper($field['default']) != 'NULL' )
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
			$res['type'] = isset($this->texts[$type]) ? $this->texts[$type] : $type;
			$res['is_numeric'] = false;
			if ( isset($field['size']) && !empty($field['size']) )
			{
				$res['size'] = $field['size'];
			}
			if ( !isset($field['default']) || empty($field['default']) )
			{
				$field['default'] = '';
			}
			$match = array();
			$default = preg_match('/^["\'](.*)["\']$/is', $field['default'], $match) ? $match[1] : $field['default'];
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