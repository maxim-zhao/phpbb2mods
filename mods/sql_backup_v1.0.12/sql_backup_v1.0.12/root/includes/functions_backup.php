<?php
/***************************************************************************
*                              functions_backup.php
*                              -------------------
*     begin                : Mon May 2, 2005
*     copyright            : (C) 2005 Vic D'Elfant
*     email                : vic@pythago.net
*
*     $Id: functions_backup.php 15 2006-04-17 11:16:56Z vic $
*
****************************************************************************/

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
	die("Hacking attempt");
}

if ( !function_exists('file_get_contents') )
{
	function file_get_contents($file)
	{
		$handle = @fopen($file, 'r');
		$data = fread($handle, filesize($file));
		fclose($handle);

		return $data;
	}
}

function format_filesize($size)
{
	if ( $size / 104857 > 1 )
	{
		return round($size / 1048576, 1) . ' MB';
	}
	elseif ( $size / 1024 > 1 )
	{
		return round($size / 1024, 1) . ' KB';
	}
	else
	{
		return round($size, 1) . ' bytes';
	}
}

function zip_compression_method($compress_method)
{
	switch ( $compress_method )
	{
		case COMPRESS_NO:
			$use_method = 'sql';
			break;

		case COMPRESS_ZIP:
			$use_method = 'zip';
			break;

		case COMPRESS_TAR:
			$use_method = 'tar';
			break;

		case COMPRESS_TGZ:
			$use_method = 'tgz';
			break;

		case COMPRESS_TAR_GZ:
			$use_method = 'tar.gz';
			break;

		case COMPRESS_TAR_BZ2:
			$use_method = 'tar.bz2';
			break;
	}

	return $use_method;
}

if ( SQL_LAYER == 'mysql' || SQL_LAYER == 'mysql4' )
{
	//
	// Get the db size
	//
	function get_db_size()
	{
		global $db, $table_prefix, $dbname;

		$dbsize = 0;

		$sql = "SELECT VERSION() AS mysql_version";
		if ( $result = $db->sql_query($sql) )
		{
			$row = $db->sql_fetchrow($result);
			$version = $row['mysql_version'];

			if ( preg_match("/^(3\.23|4\.|5\.)/", $version) )
			{
				$db_name = ( preg_match("/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/", $version) ) ? "`$dbname`" : $dbname;

				$sql = "SHOW TABLE STATUS
					FROM " . $db_name;
				if ( $result = $db->sql_query($sql) )
				{
					$tabledata_ary = $db->sql_fetchrowset($result);

					for ( $i = 0; $i < count($tabledata_ary); $i++ )
					{
						if ( $tabledata_ary[$i]['Type'] != "MRG_MyISAM" )
						{
							if ( $table_prefix != "" )
							{
								if ( strstr($tabledata_ary[$i]['Name'], $table_prefix) )
								{
									$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
								}
							}
							else
							{
								$dbsize += $tabledata_ary[$i]['Data_length'] + $tabledata_ary[$i]['Index_length'];
							}
						}
					}
				}
			}
		}

		return $dbsize;
	}

	//
	// This function returns the "CREATE TABLE" syntax for...
	//
	function get_table_def($table)
	{
		global $db;

		$schema_create = "\n#\n# Table structure for $table\n#\n";
		$field_query = "SHOW FIELDS FROM $table";
		$key_query = "SHOW KEYS FROM $table";

		$schema_create .= "DROP TABLE IF EXISTS $table;\n";
		$schema_create .= "CREATE TABLE $table (";

		// Ok lets grab the fields...
		$result = $db->sql_query($field_query);

		while ( $row = $db->sql_fetchrow($result) )
		{
			$schema_create .= '	' . $row['Field'] . ' ' . $row['Type'];

			if ( !empty($row['Default']) )
			{
				$schema_create .= ' DEFAULT \'' . $row['Default'] . '\'';
			}

			if ( $row['Null'] != "YES" )
			{
				$schema_create .= ' NOT NULL';
			}

			if ( $row['Extra'] != "" )
			{
				$schema_create .= ' ' . $row['Extra'];
			}

			$schema_create .= ",";
		}

		// Drop the last ',' off ;)
		$schema_create = ereg_replace(',$', "", $schema_create);

		//
		// Get any Indexed fields from the database...
		//
		$result = $db->sql_query($key_query);

		while ( $row = $db->sql_fetchrow($result) )
		{
			$kname = $row['Key_name'];

			if ( ( $kname != 'PRIMARY' ) && ( $row['Non_unique'] == 0 ) )
			{
				$kname = "UNIQUE|$kname";
			}

			if ( !is_array($index[$kname]) )
			{
				$index[$kname] = array();
			}

			$index[$kname][] = $row['Column_name'];
		}

		if ( is_array($index) )
		{
			foreach ( $index as $x => $columns )
			{
				$schema_create .= ",";

				if ( $x == 'PRIMARY' )
				{
					$schema_create .= '	PRIMARY KEY (' . implode($columns, ', ') . ')';
				}
				elseif ( substr($x, 0, 6) == 'UNIQUE' )
				{
					$schema_create .= '	UNIQUE ' . substr($x, 7) . ' (' . implode($columns, ', ') . ')';
				}
				else
				{
					$schema_create .= "	KEY $x (" . implode($columns, ', ') . ')';
				}
			}
		}

		$schema_create .= ");";
		$schema_create = str_replace("\t", ' ', $schema_create);

		if ( get_magic_quotes_runtime() )
		{
			return stripslashes($schema_create);
		}
		else
		{
			return $schema_create;
		}

	}


	//
	// This function is for getting the data from a table.
	//
	function get_table_content($table, $offset)
	{
		global $db;

		$sql_backup = '';

		// Grab the data from the table.
		if ( !( $result = $db->sql_query("SELECT * FROM $table LIMIT $offset, " . SQL_OFFSET) ) )
		{
			message_die(GENERAL_ERROR, "Failed in get_table_content (select *)", "", __LINE__, __FILE__, "SELECT * FROM $table LIMIT $offset, " . SQL_OFFSET);
		}

		// Loop through the resulting rows and build the sql statement.
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ( $offset == 0 )
			{
				$sql_backup .= "\n#\n# Table data for $table\n#\n";
			}

			$field_names = array();

			// Grab the list of field names.
			$num_fields = $db->sql_numfields($result);
			$table_list = '(';
			for ( $j = 0; $j < $num_fields; $j++ )
			{
				$field_names[$j] = $db->sql_fieldname($j, $result);
				$table_list .= ( ( $j > 0 ) ? ', ' : '' ) . $field_names[$j];

			}
			$table_list .= ')';

			do
			{
				// Start building the SQL statement.
				$schema_insert = "INSERT INTO $table VALUES(";

				// Loop through the rows and fill in data for each column
				for ( $j = 0; $j < $num_fields; $j++ )
				{
					$schema_insert .= ( $j > 0 ) ? ', ' : '';

					if( !isset($row[$field_names[$j]]) )
					{
						//
						// If there is no data for the column set it to null.
						// There was a problem here with an extra space causing the
						// sql file not to reimport if the last column was null in
						// any table.  Should be fixed now :) JLH
						//
						$schema_insert .= 'NULL';
					}
					elseif ( $row[$field_names[$j]] != '' )
					{
						$schema_insert .= '\'' . mysql_escape_string($row[$field_names[$j]]) . '\'';
					}
					else
					{
						$schema_insert .= '\'\'';
					}
				}

				$schema_insert .= ');';

				// Go ahead and send the insert statement to the handler function.
				$sql_backup .= trim($schema_insert) . "\n";

			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		return $sql_backup;
	}
}
elseif ( SQL_LAYER == 'postgresql' )
{
	// We'll have to add the postgresql function here
}
?>