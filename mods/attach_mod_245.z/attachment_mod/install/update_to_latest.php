<?php
/** 
*
* @package attachment_mod
* @version $Id: update_to_latest.php,v 1.8 2006/09/05 15:04:03 acydburn Exp $
* @copyright (c) 2002 Meik Sievertsen
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
*/
define('IN_PHPBB', true);
define('ATTACH_INSTALL', true);

$phpbb_root_path = './../';
include($phpbb_root_path.'extension.inc');
include($phpbb_root_path.'common.'.$phpEx);	
include($phpbb_root_path.'includes/sql_parse.'.$phpEx);
	
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

// Check DB Type
if (!isset($dbms) || $dbms == 'oracle' || $dbms == 'msaccess')
{
	message_die(GENERAL_MESSAGE, 'This Mod does not support Oracle or MSAccess.');
}

if (!defined('ATTACH_CONFIG_TABLE'))
{
	if (file_exists($phpbb_root_path . 'attach_mod/attachment_mod.'.$phpEx))
	{
		include_once($phpbb_root_path . 'attach_mod/attachment_mod.'.$phpEx);
	}
	else
	{
		message_die(GENERAL_MESSAGE, 'Please upload the attachment mod files before upgrading your installation.');
	}
}

$attach_version = '';

$sql = 'SELECT config_value 
	FROM ' . ATTACH_CONFIG_TABLE . " 
	WHERE config_name = 'attach_version'";
$result = $db->sql_query($sql);

if ($result)
{
	if ($db->sql_numrows($result) > 0)
	{
		$row = $db->sql_fetchrow($result);
		$attach_version = trim($row['config_value']);
	}
}
$db->sql_freeresult($result);

if ($attach_version == '')
{
	$attach_version = ATTACH_VERSION;
	$attach_version = trim($attach_version);
}

$version_fields = array();
$version_fields = explode('.', $attach_version);

if ((strpos($attach_version, '2.3.') === false && strpos($attach_version, '2.4.') === false) && !isset($HTTP_GET_VARS['force']))
{
	message_die(GENERAL_MESSAGE, 'Wrong Attachment Version detected.<br />Please update your Attachment Mod (V' . $attach_version . ') to at least Version 2.2.1 before you update to the latest version.<br /><br />If you want to force the update (at your own risk), please add ?force=1 to the url.');
}

if (!function_exists('attach_mod_sql_escape'))
{
	/**
	* Escaping SQL
	*/
	function attach_mod_sql_escape($text)
	{
		switch (SQL_LAYER)
		{
			case 'postgresql':
				return pg_escape_string($text);
			break;

			case 'mysql':
			case 'mysql4':
				if (function_exists('mysql_escape_string'))
				{
					return mysql_escape_string($text);
				}
				else
				{
					return str_replace("'", "''", str_replace('\\', '\\\\', $text));
				}
			break;

			default:
				return str_replace("'", "''", str_replace('\\', '\\\\', $text));
			break;
		}
	}
}

$available_dbms = array(
	"mysql" => array(
		"SCHEMA" => "attach_mysql", 
		"DELIM" => ";",
		"DELIM_BASIC" => ";",
		"COMMENTS" => "remove_remarks"
	), 
	"mysql4" => array(
		"SCHEMA" => "attach_mysql", 
		"DELIM" => ";", 
		"DELIM_BASIC" => ";",
		"COMMENTS" => "remove_remarks"
	),
	"mssql" => array(
		"SCHEMA" => "attach_mssql", 
		"DELIM" => "GO", 
		"DELIM_BASIC" => ";",
		"COMMENTS" => "remove_comments"
	),
	"mssql-odbc" =>	array(
		"SCHEMA" => "attach_mssql", 
		"DELIM" => "GO",
		"DELIM_BASIC" => ";",
		"COMMENTS" => "remove_comments"
	),
	"postgres" => array(
		"LABEL" => "PostgreSQL 7.x",
		"SCHEMA" => "attach_postgres", 
		"DELIM" => ";", 
		"DELIM_BASIC" => ";",
		"COMMENTS" => "remove_comments"
	)
);

$dbms_schema = 'schemas/' . $available_dbms[$dbms]['SCHEMA'] . '_schema.sql';
$dbms_basic = 'schemas/' . $available_dbms[$dbms]['SCHEMA'] . '_basic.sql';

$remove_remarks = $available_dbms[$dbms]['COMMENTS'];;
$delimiter = $available_dbms[$dbms]['DELIM']; 
$delimiter_basic = $available_dbms[$dbms]['DELIM_BASIC']; 

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

//
// BEGIN Functions

/**
* Insert a 'new' value into the Attachment Configuration Table
*/
function insert_into_config($new_name, $default = 0)
{
	global $db, $dbms;

	$new_config_table = ATTACH_CONFIG_TABLE;

	$sql = "SELECT config_name FROM " . $new_config_table . " WHERE config_name='" . attach_mod_sql_escape($new_name) . "'";
	$result = $db->sql_query($sql);

	if (!$result)
	{
		return false;
	}

	if ($db->sql_numrows($result) != 0)
	{
		$db->sql_freeresult($result);
		return false;
	}
	$db->sql_freeresult($result);

	// Write new config variable
	if ($dbms == 'mysql' || $dbms == 'mysql4' || $dbms == 'postgres')
	{
		$sql = "INSERT INTO " . $new_config_table . " (config_name, config_value) VALUES ('" . attach_mod_sql_escape($new_name) . "', '" . attach_mod_sql_escape($default) . "');";
	}
	else if ($dbms == 'mssql' || $dbms == 'mssql-odbc')
	{
		$sql = "INSERT INTO " . $new_config_table . " (config_name, config_value) VALUES ('" . attach_mod_sql_escape($new_name) . "', '" . attach_mod_sql_escape($default) . "');";
		$sql .= "GO;";
	}
		
	evaluate_statement($sql);

	return true;
}

/*
* Check if table exist
*/
function table_exist($table)
{
	global $db, $table_prefix;
	
	$sql = "SELECT * FROM " . $table;
	$sql = preg_replace('/phpbb_/', $table_prefix, $sql);

	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($result && $row)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
* Check if a given row is present in table $table
*/
function row_in_schema($table, $key)
{
	global $db, $table_prefix;

	$sql = "SELECT " . $key . " FROM " . $table;
	$sql = preg_replace('/phpbb_/', $table_prefix, $sql);

	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if ($result && $row)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
* Run a complete SQL-Statement, this can be a array
*/
function evaluate_statement($sql_query, $hide = FALSE, $replace = FALSE, $hide_query = false)
{
	global $table_prefix, $remove_remarks, $delimiter, $db;
	
	$errored = FALSE;
	if ($replace)
	{
		$sql_query = preg_replace('/phpbb_/', $table_prefix, $sql_query);
	}

	$sql_query = $remove_remarks($sql_query);
	$sql_query = split_sql_file($sql_query, $delimiter);

	$sql_count = sizeof($sql_query);

	for ($i = 0; $i < $sql_count; $i++)
	{
		if (!$hide && !$hide_query)
		{
			echo "Running :: " . $sql_query[$i];
		}
		flush();

		$result = $db->sql_query($sql_query[$i]);

		if (!$result)
		{
			$errored = true;
			$error = $db->sql_error();
			if (!$hide)
			{
				echo " -> <b>FAILED</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
			}
		}
		else
		{
			if (!$hide)
			{
				echo " -> <b><span class=\"ok\">COMPLETED</span></b><br /><br />\n\n";
			}
		}
	}

	if ($errored)
	{
		return false;
	}
	else
	{
		return $result;
	}
}

/**
* Fill new quota tables
*/
function fill_new_quota_table_data($dbms)
{
	$data = '';

	if ($dbms == 'mysql' || $dbms == 'mysql4')
	{
		$data = '
CREATE TABLE phpbb_quota_limits (
  quota_limit_id mediumint(8) unsigned NOT NULL auto_increment,
  quota_desc varchar(20) NOT NULL default \'\',
  quota_limit bigint(20) unsigned NOT NULL default \'0\',
  PRIMARY KEY  (quota_limit_id)
);

CREATE TABLE phpbb_attach_quota (
  user_id mediumint(8) unsigned NOT NULL default \'0\',
  group_id mediumint(8) unsigned NOT NULL default \'0\',
  quota_type smallint(2) NOT NULL default \'0\',
  quota_limit_id mediumint(8) unsigned NOT NULL default \'0\',
  KEY quota_type (quota_type)
);

INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (1, \'Low\', 262144);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (2, \'Medium\', 2097152);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (3, \'High\', 5242880);

';
	}
	else if ($dbms == 'mssql' || $dbms == 'mssql-odbc')
	{
		$data = '
BEGIN TRANSACTION
GO

CREATE TABLE [phpbb_quota_limits] (
  [quota_limit_id] [int] IDENTITY (1, 1) NOT NULL ,
  [quota_desc] [varchar] (20) NOT NULL,
  [quota_limit] [bigint] NOT NULL
) ON [PRIMARY];
GO

ALTER TABLE [phpbb_quota_limits] WITH NOCHECK ADD 
	CONSTRAINT [PK_phpbb_quota_limits] PRIMARY KEY  CLUSTERED 
	(
		[quota_limit_id]
	)  ON [PRIMARY] 
GO

ALTER TABLE [phpbb_quota_limits] WITH NOCHECK ADD 
	CONSTRAINT [DF_phpbb_quota_limits_quota_limit] DEFAULT (0) FOR [quota_limit]
GO

CREATE TABLE [phpbb_attach_quota] (
  [user_id] [int] NOT NULL,
  [group_id] [int] NOT NULL,
  [quota_type] [tinyint] NOT NULL,
  [quota_limit_id] [int] NOT NULL
);
GO

ALTER TABLE [phpbb_attach_quota] WITH NOCHECK ADD 
	CONSTRAINT [DF_phpbb_attach_quota_user_id] DEFAULT (0) FOR [user_id],
	CONSTRAINT [DF_phpbb_attach_quota_group_id] DEFAULT (0) FOR [group_id],
	CONSTRAINT [DF_phpbb_attach_quota_quota_type] DEFAULT (0) FOR [quota_type],
	CONSTRAINT [DF_phpbb_attach_quota_quota_limit_id] DEFAULT (0) FOR [quota_limit_id]
GO

COMMIT
GO

BEGIN TRANSACTION
GO

SET IDENTITY_INSERT phpbb_quota_limits ON;

INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (1, \'Low\', 262144);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (2, \'Medium\', 2097152);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (3, \'High\', 5242880);

SET IDENTITY_INSERT phpbb_quota_limits OFF;

COMMIT
GO

';
	}
	else if ($dbms == 'postgres')
	{
		$data = '
CREATE SEQUENCE phpbb_quota_limits_quota_limit_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;

CREATE TABLE phpbb_quota_limits (
  quota_limit_id int4 DEFAULT nextval(\'phpbb_quota_limits_quota_limit_id_seq\'::text) NOT NULL,
  quota_desc varchar(20) DEFAULT \'\' NOT NULL,
  quota_limit int8 DEFAULT 0 NOT NULL,
  CONSTRAINT phpbb_quota_limits_pkey PRIMARY KEY (quota_limit_id)
);

CREATE TABLE phpbb_attach_quota (
  user_id int4 DEFAULT 0 NOT NULL,
  group_id int4 DEFAULT 0 NOT NULL,
  quota_type int2 DEFAULT 0 NOT NULL,
  quota_limit_id int4 DEFAULT 0 NOT NULL
);
CREATE INDEX quota_type_phpbb_attach_quota_index ON phpbb_attach_quota (quota_type);

INSERT INTO phpbb_quota_limits (quota_desc, quota_limit) VALUES (\'Low\', 262144);
INSERT INTO phpbb_quota_limits (quota_desc, quota_limit) VALUES (\'Medium\', 2097152);
INSERT INTO phpbb_quota_limits (quota_desc, quota_limit) VALUES (\'High\', 5242880);

';
	}

	return $data;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;">
<meta http-equiv="Content-Style-Type" content="text/css">
<style type="text/css">
<!--

font,th,td,p,body { font-family: "Courier New", courier; font-size: 11pt }

a:link,a:active,a:visited { color : #006699; }
a:hover		{ text-decoration: underline; color : #DD6900;}

hr	{ height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px;}

.maintitle,h1,h2	{font-weight: bold; font-size: 22px; font-family: "Trebuchet MS",Verdana, Arial, Helvetica, sans-serif; text-decoration: none; line-height : 120%; color : #000000;}

.ok {color:green}

-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#006699" vlink="#5584AA">

<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center"> 
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><img src="./../templates/subSilver/images/logo_phpBB.gif" border="0" alt="Forum Home" vspace="1" /></td>
				<td align="center" width="100%" valign="middle"><span class="maintitle">Updating from Attachment Mod Version <? echo $attach_version; ?> to latest Release</span></td>
			</tr>
		</table></td>
	</tr>
</table>

<br clear="all" />

<?php

/**
* Add new fields to the config table
*/
	
echo "<br /><h2>Add new fields to the config table...</h2><br /><br />";
insert_into_config('display_order', '0');
insert_into_config('img_imagick', '');
insert_into_config('show_apcp', '0');
insert_into_config('attach_version', '2.4.5');
insert_into_config('default_upload_quota', '0');
insert_into_config('default_pm_quota', '0');
insert_into_config('ftp_pasv_mode', '1');
insert_into_config('use_gd2', '0');

$sql = "UPDATE phpbb_attachments_config SET config_value = '2.4.5' WHERE config_name = 'attach_version';";
$result = evaluate_statement($sql, true, true);

if ($dbms == 'mysql' || $dbms == 'mysql4')
{
	$sql = "SHOW INDEX FROM phpbb_attachments_desc;";
	$result = evaluate_statement($sql, true, true);

	$filetime_bool = false;
	$physical_filename_bool = false;
	$filesize_bool = false;
	
	if ($result)
	{
		$rows = $db->sql_fetchrowset($result);

		for ($i = 0; $i < sizeof($rows); $i++)
		{
			if (trim($rows[$i]['Key_name']) == 'filetime')
			{
				$filetime_bool = true;
			}

			if (trim($rows[$i]['Key_name']) == 'physical_filename')
			{
				$physical_filename_bool = true;
			}
			
			if (trim($rows[$i]['Key_name']) == 'filesize')
			{
				$filesize_bool = true;
			}
		}
	}
	
	if (!$filetime_bool)
	{
		echo "<br /><h2>Add new INDEX to the Attachments Description Table...</h2><br /><br />";
		evaluate_statement("ALTER TABLE phpbb_attachments_desc ADD INDEX (filetime);", false, true);
	}

	if (!$physical_filename_bool)
	{
		echo "<br /><h2>Add new INDEX to the Attachments Description Table...</h2><br /><br />";
		evaluate_statement("ALTER TABLE phpbb_attachments_desc ADD INDEX (physical_filename(10));", false, true);
	}

	if (!$filesize_bool)
	{
		echo "<br /><h2>Add new INDEX to the Attachments Description Table...</h2><br /><br />";
		evaluate_statement("ALTER TABLE phpbb_attachments_desc ADD INDEX (filesize);", false, true);
	}
}

if ($dbms == 'mysql' || $dbms == 'mysql4')
{
	// Add INDEX to attachments table
	$sql = "SHOW INDEX FROM phpbb_attachments;";
	$result = evaluate_statement($sql, true, true);

	$post_id_bool = false;
	$privmsgs_id_bool = false;
	
	if ($result)
	{
		$rows = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		for ($i = 0; $i < sizeof($rows); $i++)
		{
			if (trim($rows[$i]['Key_name']) == 'post_id')
			{
				$post_id_bool = true;
			}

			if (trim($rows[$i]['Key_name']) == 'privmsgs_id')
			{
				$privmsgs_id_bool = true;
			}
		
		}
	}
	
	if (!$post_id_bool)
	{
		echo "<br /><h2>Add new INDEX to the Attachments Table...</h2><br /><br />";
		evaluate_statement("ALTER TABLE phpbb_attachments ADD INDEX (post_id);", false, true);
	}

	if (!$privmsgs_id_bool)
	{
		echo "<br /><h2>Add new INDEX to the Attachments Table...</h2><br /><br />";
		evaluate_statement("ALTER TABLE phpbb_attachments ADD INDEX (privmsgs_id);", false, true);
	}
}


if (!row_in_schema('phpbb_extension_groups', 'forum_permissions'))
{
	if ($dbms == 'mysql' || $dbms == 'mysql4')
	{
		echo "<br /><h2>Add new row to the Extension Groups Table...</h2><br /><br />";
		$sql_query = "ALTER TABLE phpbb_extension_groups ADD forum_permissions VARCHAR(255) DEFAULT '' NOT NULL;";
	}
	else if ($dbms == 'postgres')
	{
		$sql_query = '
ALTER TABLE phpbb_extension_groups ADD forum_permissions varchar(255);
UPDATE phpbb_extension_groups SET forum_permissions = \'\';
ALTER TABLE phpbb_extension_groups ALTER COLUMN forum_permissions SET DEFAULT \'\';
ALTER TABLE phpbb_extension_groups ADD CONSTRAINT forum_permissions_notnull CHECK (forum_permissions NOTNULL);
';
	}
	else if ($dbms == 'mssql' || $dbms == 'mssql-odbc')
	{
		$sql_query = "ALTER TABLE [phpbb_extension_groups] WITH NOCHECK ADD 
		[forum_permissions] [varchar] (255)
		GO	";
	}

	evaluate_statement($sql_query, false, true);
}

if (!table_exist('phpbb_quota_limits'))
{
	// Add two new Tables and the basic data for them
	echo "<br /><h2>Add Quota Tables...</h2><br /><br />";
	$sql_query = fill_new_quota_table_data($dbms);
	evaluate_statement($sql_query, false, true);
}

// Check if we updated the table contents for the >2.4.x basic data yet...
$basic_data_updated = false;

$sql = 'SELECT config_value 
	FROM ' . ATTACH_CONFIG_TABLE . " 
	WHERE config_name = 'basic_data_updated'";
$result = $db->sql_query($sql);

if ($result)
{
	if ($db->sql_numrows($result) > 0)
	{
		$row = $db->sql_fetchrow($result);
		$basic_data_updated = (int) $row['config_value'];
		
		// Remove the config value because it is set to 0 (we will re-add it later)
		if (!$basic_data_updated)
		{
			$db->sql_query('DELETE FROM ' . ATTACH_CONFIG_TABLE . " WHERE config_name = 'basic_data_updated'");
		}
	}
}
$db->sql_freeresult($result);

// Update basic data
if (!$basic_data_updated)
{
	insert_into_config('basic_data_updated', 0);

	echo "<br /><h2>Change attachment data to new format (this can take a bit, please do not stop this script)</h2><br /><br />";

	$sql = 'SELECT attach_id, real_filename, comment 
		FROM ' . ATTACHMENTS_DESC_TABLE . '
		ORDER BY attach_id ASC';
	$result = $db->sql_query($sql);

	if ($result)
	{
		$num_rows = $db->sql_numrows($result);
		$i = 1;

		while ($row = $db->sql_fetchrow($result))
		{
			echo "Updating attachment number $i/$num_rows [id:{$row['attach_id']}] ";

			$sql = 'UPDATE ' . ATTACHMENTS_DESC_TABLE . " SET
				real_filename = '" . attach_mod_sql_escape(htmlspecialchars(stripslashes($row['real_filename']))) . "',
				comment = '" . attach_mod_sql_escape(htmlspecialchars(stripslashes($row['comment']))) . "'
				WHERE attach_id = " . $row['attach_id'];
			$res = $db->sql_query($sql);
			
			if (!$res)
			{
				$errored = true;
				$error = $db->sql_error();
				echo " -> <b>FAILED</b> ---> <u>" . $error['message'] . "</u><br />\n";
			}
			else
			{
				echo " -> <b><span class=\"ok\">COMPLETED</span></b><br />\n";
			}
	
			$i++;
		}
		$db->sql_freeresult($result);
	}

	$sql = "UPDATE phpbb_attachments_config SET config_value = '1' WHERE config_name = 'basic_data_updated';";
	$result = evaluate_statement($sql, true, true);
}

/*
if ($attach_version != '2.3.7')
{
	if ( ($dbms == "mysql") || ($dbms == "mysql4") )
	{
		$sql_query = "ALTER TABLE phpbb_quota_limits CHANGE quota_limit quota_limit bigint(20) UNSIGNED DEFAULT '0' NOT NULL;"; 
		evaluate_statement($sql_query, FALSE, TRUE);
	}
	else if ( ($dbms == "mssql") || ($dbms == "mssql-odbc") )
	{
		echo "CANT CHANGE MSSQL-TABLE. PLEASE DO THE FOLLOWING MANUALLY:<br />IN PHPBB_QUOTA_LIMITS, CHANGE QUOTA_LIMIT TO FROM INT TO BIGINT.<br />";
	}
}
*/

$cache_dir = $phpbb_root_path . '/cache';
$cache_file = $cache_dir . '/attach_config.php';

if (@file_exists($cache_dir) && is_dir($cache_dir) && is_writable($cache_dir))
{
	if (@file_exists($cache_file))
	{
		@unlink($cache_file);
	}
}

echo "<br /><br /><b>Finished... now remove the install and contrib directories.</b><br /><br />";

?>