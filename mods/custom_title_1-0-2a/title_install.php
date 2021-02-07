<?php
/***************************************************************************
 *                             title_install.php
 *                            -------------------
 *   begin                : Wednesday, August 7, 2002
 *   copyright            : (C) 2002 Jason Lynch
 *   email                : gerek@softhome.net
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

function _sql($sql, &$errored, &$error_ary, $echo_dot = true)
{
	global $db;

	if( !($result = $db->sql_query($sql)) )
	{  
		$errored = true;
		$error_ary['sql'][] = ( is_array($sql) ) ? $sql[$i] : $sql;
		$error_ary['error_code'][] = $db->sql_error();
	}

	if ( $echo_dot )
	{
		echo ".";
		flush();
	}

	return $result;
}

$installs_version = '1.0.2';

define('IN_PHPBB', 1);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'config.'.$phpEx);
include($phpbb_root_path . 'includes/constants.'.$phpEx);
include($phpbb_root_path . 'includes/functions.'.$phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
include($phpbb_root_path . 'includes/db.'.$phpEx);

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

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("templates/subSilver/formIE.css"); 
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#006699" vlink="#5584AA">

<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center"> 
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><img src="templates/subSilver/images/logo_phpBB.gif" border="0" alt="Forum Home" vspace="1" /></td>
				<td align="center" width="100%" valign="middle"><span class="maintitle">Aexoden's custom Title MOD: Database Updater</span></td>
			</tr>
		</table></td>
	</tr>
</table>

<br clear="all" />

<h2>Information</h2>

<?php

echo '<p>Database type &nbsp; &nbsp;:: <b>' . SQL_LAYER . '</b><br />';

echo 'Aexoden\'s Custom Title Version:: <b>' . $installs_version . '</b></p>' ."\n";

echo '<p>This installs the necessary database schema for Aexoden\'s Custom Title MOD.  Currently, only the MySQL aspect has been tested.  If you\'re using any other database, please report your results to Aexoden.</p>' . "\n";

switch ( SQL_LAYER )
{
	case 'mysql':
	case 'mysql4':
		$sql[] = "ALTER TABLE " . USERS_TABLE . "
			ADD COLUMN user_custom_title varchar(255) NULL, 
			ADD COLUMN user_custom_title_status tinyint(1) default '0' not null";
		break;
	case 'postgresql':
		$sql[] = "ALTER TABLE " . USERS_TABLE . "
			ADD COLUMN user_custom_title varchar(255) NULL";
		$sql[] = "ALTER TABLE " . USERS_TABLE . "
			ADD COLUMN user_custom_title_status int2";
		$sql[] = "ALTER TABLE " . USERS_TABLE . "
			ALTER COLUMN user_custom_title_status SET DEFAULT '0'";
		break;
	case 'mssql-odbc':
	case 'mssql':
		$sql[] = "ALTER TABLE " . USERS_TABLE . " ADD
			user_custom_title varchar(255) NULL";
		$sql[] = "ALTER TABLE " . USERS_TABLE . " ADD
			user_custom_title_status tinyint NOT NULL,
			CONSTRAINT [DF_" . $table_prefix . "users_user_custom_title_status] DEFAULT (0) FOR [user_custom_title_status]";
		break;
	case 'msaccess':
		$sql[] = "ALTER TABLE " . USERS_TABLE . "
			ADD user_custom_title varchar(255) NULL";
		$sql[] = "ALTER TABLE " . USERS_TABLE . " ADD
			user_custom_title_status tinyint NOT NULL";
		break;
	default:
		die("No DB LAYER found!");
		break;
}

echo "<h2>Installing database schema</h2>\n";
echo "<p>Progress :: <b>";
flush();

$error_ary = array();
$errored = false;
if ( count($sql) )
{
	for($i = 0; $i < count($sql); $i++)
	{
		_sql($sql[$i], $errored, $error_ary);
	}

	echo "</b> <b class=\"ok\">Done</b><br />Result &nbsp; :: \n";

	if ( $errored )
	{
		echo " <b>Some queries failed, the statements and errors are listing below</b>\n<ul>";

		for($i = 0; $i < count($error_ary['sql']); $i++)
		{
			echo "<li>Error :: <b>" . $error_ary['error_code'][$i]['message'] . "</b><br />";
			echo "SQL &nbsp; :: <b>" . $error_ary['sql'][$i] . "</b><br /><br /></li>";
		}

		echo "</ul>\n<p>An error occured.</p>\n";
	}
	else
	{
		echo "<b>No errors</b>\n";
	}
}
else
{
	echo " No updates required</b></p>\n";
}

//
// 
//
unset($sql);
$error_ary = array();
$errored = false;

echo "<h2>Updating data</h2>\n";
echo "<p>Progress :: <b>";
flush();

$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value)
	VALUES ('custom_title_days', 0)";
	_sql($sql, $errored, $error_ary);

$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value)
	VALUES ('custom_title_posts', 0)";
	_sql($sql, $errored, $error_ary);

$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value)
	VALUES ('custom_title_mode', 0)";
	_sql($sql, $errored, $error_ary);

$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value)
	VALUES ('custom_title_maxlength', 45)";
	_sql($sql, $errored, $error_ary);


		echo "</b> <b class=\"ok\">Done</b><br />Result &nbsp; :: \n";

		if ( $errored )
		{
			echo " <b>Some queries failed, the statements and errors are listing below</b>\n<ul>";

			for($i = 0; $i < count($error_ary['sql']); $i++)
			{
				echo "<li>Error :: <b>" . $error_ary['error_code'][$i]['message'] . "</b><br />";
				echo "SQL &nbsp; :: <b>" . $error_ary['sql'][$i] . "</b><br /><br /></li>";
			}

			echo "</ul>\n<p>An error occured.  Please PM Aexoden with the details of the error.</p>\n";
		}
		else
		{
			echo "<b>No errors</b>\n";
		}


echo "<h2>Install completed</h2>\n";
echo "\n<p>You should now delete this file.  Be sure to visit the Configuration section of General Admin to configure the Custom Title options.</p>\n";

?>

<br clear="all" />

</body>
</html>