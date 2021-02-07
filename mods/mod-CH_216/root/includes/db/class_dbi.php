<?php
//
//	file: includes/db/class_dbi.php
//	author: ptirhiik
//	begin: 16/01/2007
//	version: 1.7.1 - 13/06/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

//
// ----------------------------------------------------------------
//
// Caution: 
// -------
// o Droping an auto_increment field (with mySQL especially) or renaming a table with auto_increment (with postgreSQL especially)
// will lead to errors (run-time or immediate).
// In both cases the creation of a new table plus copy is required
//
// o renaming tables or columns is not a good idea: there will be issues with some db layer regarding the indexes, constraints and so
// in both case, the safier is to create a new table/field plus copy if required
//
// o Altering a field type or size for decimals and alpha with postgresql 7 
// will result in loosing the indexes onto this field (a new field is created).
//
// o You can not alter field type for field being already text with mssql. However, the default value change will be applied.
//
// o When altering a column, the full definition is required (especially for postgreSQL 7), with {new_} for the attributes to change
//
// supported fields types:
// ----------------------
// o numerics: tinyint (bytes: 1), smallint (bytes: 2), mediumint (bytes: 3), int (bytes: 4), bigint (bytes: 8), decimal (bytes: 64)
// o alpha: char (size required), varchar (size required), text, mediumtext, longtext
//
// Size parameter:
// --------------
// o with numerics:
//		- with decimal type, the size is required. ie:
//			. decimal(5, 2) => type: decimal, size: 5,2
//
//		- with mySQL, the size is used for the front size, and - prevent the generation of UNSIGNED for the field. ie:
//			. smallint(5) UNSIGNED => type: smallint, size: 5
//			. mediumint(8) => type: mediumint, size: 8-
//
// o with alpha:
//		The size parameter is required for char and varchar (char varying). ie:
//			. char(5) => type: char, size: 5
//			. varchar(255) => type: varchar, size: 255
//
// xml structure:
/* --------------
<actions>
	(*)<action name="{action_qualifier}">

		(*)<create_table>
			(*)<table name="{table_name}">
				(*)<field name="{field_name}"><type>{type}</type><size>{front_size|-}</size><extra>{auto_increment}</extra><default>{NULL|value}</default></field>
				(*)<index name="{pkey|index_name}">
					<type>{PRIMARY|UNIQUE}</type>
					(*)<field name="{field_name}" />
				</index>
			</table>
		</create_table>

		(*)<drop_table>
			(*)<table name="{table_name}" />
		</drop_table>

		(*)<rename_table>
			(*)<table name="{old_table_name}">{new_table_name}</table>
		</rename_table>

		(*)<create_index>
			(*)<table name="{table_name}">
				(*)<index name="{pkey|index_name}">
					<type>{PRIMARY|UNIQUE}</type>
					(*)<field name="{field_name}" />
				</index>
			</table>
		</create_index>

		(*)<drop_index>
			(*)<table name="{table_name}">
				(*)<index name="{index_name}" />
			</table>
		</drop_index>

		(*)<create_field>
			(*)<table name="{table_name}">
				(*)<field name="{field_name}"><type>{type}</type><size>{front_size|-}</size><extra>{auto_increment}</extra><default>{NULL|value}</default></field>
			</table>
		</create_field>

		(*)<change_field>
			(*)<table name="{table_name}">
				(*)<field name="{field_name}"><(new_)type>{type}</(new_)type><(new_)size>{front_size|-}</(new_)size><(new_)extra>{auto_increment}</(new_)extra><(new_)default>{NULL|value}</(new_)default></field>
			</table>
		</change_field>

		(*)<drop_field>
			(*)<table name="{table_name}">
				(*)<field name="{field_name}" />
			</table>
		</drop_field>

		(*)<run>
			(*)<sql>{request: UPDATE {table_name} SET ...]}</sql>
		</run>

	</action>
</actions>
*/
//
// ----------------------------------------------------------------
//

class dbi
{
	var $prefix;
	var $numerics;
	var $texts;

	function dbi($prefix='')
	{
		$this->prefix = $prefix;
		$this->numerics = false;
		$this->texts = false;
		$this->supported_types();
	}

	function supported_types()
	{
		$this->numerics = array('tinyint' => '', 'smallint' => '', 'mediumint' => '', 'int' => '', 'bigint' => '', 'decimal' => '');
		$this->texts = array('char' => '', 'varchar' => '', 'text' => '', 'mediumtext' => '', 'longtext' => '');
	}

	function table($table_name)
	{
		return $this->prefix . $table_name;
	}

	function sql_escape_string($str)
	{
		global $db;
		return $db->sql_escape_string($str);
	}

	function sql_query($sql)
	{
		global $db;
		return $db->sql_query($sql, false, __LINE__, __FILE__, false);
	}

	function sql_fetchrow(&$result)
	{
		global $db;
		return $db->sql_fetchrow($result);
	}

	function sql_freeresult(&$result)
	{
		global $db;
		return $db->sql_freeresult($result);
	}

	function trigger_error($errno, $errmsg)
	{
		message_die(CRITICAL_ERROR, $errmsg, '', __LINE__, __FILE__);
	}

	function process(&$actions)
	{
		if ( !$actions || !isset($actions['cdata']) || !($count_actions = count($actions['cdata'])) )
		{
			return false;
		}
		$sqls = array();
		for ( $i = 0; $i < $count_actions; $i++ )
		{
			if ( !isset($actions['cdata'][$i]['action']) || !isset($actions['cdata'][$i]['action']['cdata']) || !($count_actions_cdata = count($actions['cdata'][$i]['action']['cdata'])) )
			{
				continue;
			}
			for ( $j = 0; $j < $count_actions_cdata; $j++ )
			{
				$steps = empty($actions['cdata'][$i]['action']['cdata'][$j]) ? array() : array_keys($actions['cdata'][$i]['action']['cdata'][$j]);
				$count_steps = count($steps);
				for ( $k = 0; $k < $count_steps; $k++ )
				{
					if ( !isset($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']) || empty($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']) )
					{
						continue;
					}
					$res = false;
					switch ( $steps[$k] )
					{
						case 'create_table':
							$res = $this->create_table($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'drop_table':
							$res = $this->drop_table($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'rename_table':
							$res = $this->rename_table($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'create_index':
							$res = $this->create_index($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'drop_index':
							$res = $this->drop_index($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'create_field':
							$res = $this->create_field($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'change_field':
							$res = $this->change_field($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'drop_field':
							$res = $this->drop_field($this->decode($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']));
							break;
						case 'run':
							$res = $this->run_process($actions['cdata'][$i]['action']['cdata'][$j][ $steps[$k] ]['cdata']);
							break;
					}
					if ( $res )
					{
						$sqls = array_merge($sqls, $res);
					}
				}
			}
		}
		return $sqls;
	}

	function decode($items)
	{
		$res = array();
		$count_items = count($items);
		for ( $i = 0; $i < $count_items; $i++ )
		{
			if ( isset($items[$i]['table']) && isset($items[$i]['table']['name']) )
			{
				// drop
				if ( !isset($items[$i]['table']['cdata']) )
				{
					$res[] = $items[$i]['table']['name'];
				}
				// rename
				else if ( !is_array($items[$i]['table']['cdata']) )
				{
					$res[ $items[$i]['table']['name'] ] = $items[$i]['table']['cdata'];
				}
				else
				{
					$table_fields = $table_indexes = array();
					$count_items_cdata = count($items[$i]['table']['cdata']);
					for ($j = 0; $j < $count_items_cdata; $j++ )
					{
						$types = empty($items[$i]['table']['cdata'][$j]) ? array() : array_keys($items[$i]['table']['cdata'][$j]);
						$count_types = count($types);
						for ( $k = 0; $k < $count_types; $k++ )
						{
							if ( isset($items[$i]['table']['cdata'][$j][ $types[$k] ]['cdata']) )
							{
								if ( $types[$k] == 'field' )
								{
									$table_fields = array_merge($table_fields, $this->decode_field($items[$i]['table']['cdata'][$j][ $types[$k] ]));
								}
								else if ( $types[$k] == 'index' )
								{
									$table_indexes = array_merge($table_indexes, $this->decode_index($items[$i]['table']['cdata'][$j][ $types[$k] ]));
								}
							}
							else
							{
								if ( $types[$k] == 'field' )
								{
									$table_fields[] = $items[$i]['table']['cdata'][$j][ $types[$k] ]['name'];
								}
								else if ( $types[$k] == 'index' )
								{
									$table_indexes[] = $items[$i]['table']['cdata'][$j][ $types[$k] ]['name'];
								}
							}
						}
					}
					if ( $table_fields || $table_indexes )
					{
						$res[ $items[$i]['table']['name'] ] = ($table_fields ? array('field' => $table_fields) : array()) + ($table_indexes ? array('index' => $table_indexes) : array());
					}
				}
			}
		}
		return $res ? array('table' => $res) : array();
	}

	function decode_field($item)
	{
		$res = array();
		if ( ($count_item_cdata = count($item['cdata'])) )
		{
			$res = array($item['name'] => array());
			for ( $i = 0; $i < $count_item_cdata; $i++ )
			{
				$attrs = empty($item['cdata'][$i]) ? array() : array_keys($item['cdata'][$i]);
				$count_attrs = count($attrs);
				for ( $j = 0; $j < $count_attrs; $j++ )
				{
					$res[ $item['name'] ][ $attrs[$j] ] = $item['cdata'][$i][ $attrs[$j] ]['cdata'];
				}
			}
		}
		return $res;
	}

	function decode_index($item)
	{
		$res = array();
		if ( ($count_item_cdata = count($item['cdata'])) )
		{
			$res = array($item['name'] => array());
			for ( $i = 0; $i < $count_item_cdata; $i++ )
			{
				$attrs = empty($item['cdata'][$i]) ? array() : array_keys($item['cdata'][$i]);
				$count_attrs = count($attrs);
				for ( $j = 0; $j < $count_attrs; $j++ )
				{
					if ( $attrs[$j] == 'type' )
					{
						$res[ $item['name'] ][ $attrs[$j] ] = $item['cdata'][$i][ $attrs[$j] ]['cdata'];
					}
					else if ( $attrs[$j] == 'field' )
					{
						if ( !isset($res[ $item['name'] ][ $attrs[$j] ]) )
						{
							$res[ $item['name'] ][ $attrs[$j] ] = array();
						}
						$res[ $item['name'] ][ $attrs[$j] ][] = $item['cdata'][$i][ $attrs[$j] ]['name'];
					}
				}
			}
		}
		return $res;
	}

	function run_process(&$items)
	{
		$res = array();
		if ( ($count_items = count($items)) )
		{
			for ( $i = 0; $i < $count_items; $i++ )
			{
				$types = empty($items[$i]) ? array() : array_keys($items[$i]);
				$count_types = count($types);
				for ( $j = 0; $j < $count_types; $j++ )
				{
					switch ( $types[$j] )
					{
						case 'sql':
							$match = array();
							preg_match_all('#\{([^\}]+)\}#is', $items[$i][ $types[$j] ]['cdata'], $match);
							$res[] = $match[1] ? str_replace($match[0], array_map(array(&$this, 'table'), $match[1]), $items[$i][ $types[$j] ]['cdata']) : $items[$i][ $types[$j] ]['cdata'];
							break;

						default:
							break;
					}
				}
			}
		}
		return $res;
	}
}

?>