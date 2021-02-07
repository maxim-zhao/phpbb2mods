<?php
/***************************************************************************
 *							install.php
 *							-----------
 *	begin		: 03/10/2005
 *	copyright	: phantomk
 *	email		: phantomk@modmybb.com
 *
 *	Version		: 0.0.11 - 4/1/2006
 *
 *	Credits		: Based on install script for Attachment Mod by Acyd Burn
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

define('IN_PHPBB', true);
define('IN_INSTALL', true);
$phpbb_root_path = './../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.' . $phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

if ( (!isset($dbms)) || ($dbms == 'oracle') || ($dbms == 'msaccess') )
{
	message_die(GENERAL_ERROR, "This Mod does not support Oracle or MsAccess Databases.");
}

$lang = array(
	'Login_title' => 'Please Login to verify your status.',
	'Login_failed' => 'Login failed. Check the username and the password you\'ve typed in, then retry.',
	'Login_username' => 'Username',
	'Login_password' => 'Password',
	'Login_submit' => 'Log me in',
	'Login_admin' => 'Please Login to ensure you are the correct administrator.',
	'Login_not_admin' => 'You must be an administrator to go further.',
	'Title' => 'Advanced Group Color Management Login',
	'Completed' => 'COMPLETED',
	'Failed' => 'FAILED',
	'Unknown_reason' => ':: Unknown reason...',
	'Delete_folder' => 'NOW DELETE THIS FOLDER',
	'Complete' => 'COMPLETE!',
	'AGCM_installed' => 'Advanced Group Color Management installed successfully.',
	'AGCM_failed' => 'Some queries/commands failed.<br />  Support is offered at <a href="http://www.modmybb.com/">http://www.modmybb.com/</a>, report all errors/warnings.',
	'Group_error' => ':: This might occur if the group is already in the themes table',
	'Group_remove' => 'Removeing Group from Theme\'s table',
	'Group_update' => 'Adding Group to Theme\'s table',
	'Group_update_color' => 'Setting Group Color',
	'Running' => 'Running ::',
	'Submit' => 'Submit',
	'Cancel' => 'Cancel',
	'New_install' => 'AGCM has detected that thier are no previous instllations.  Install \'%s\' onto your board ?',
	'Upgrade_install' => 'AGCM has detected that \'%s\' has been installed on your board.  Upgrade your board to \'%s\' ?',
	'Install_msg' => 'AGCM is installing \'%s\' onto your board.',
	'Upgrade_msg' => 'AGCM is upgradeing from \'%s\' to \'%s\'.',
	'Already_up-to-date' => 'Advanced Group Color Management already up to date.'
);

if ( !empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']) )
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

if ( !$userdata['session_logged_in'] || ($userdata['session_logged_in'] && !$userdata['session_admin'] && $userdata['user_level'] == ADMIN))
{
	if ( isset($HTTP_POST_VARS['login']) || isset($HTTP_POST_VARS['admin']) )
	{
		$username = isset($HTTP_POST_VARS['username']) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';
		$password = isset($HTTP_POST_VARS['password']) ? $HTTP_POST_VARS['password'] : '';

		$sql = "SELECT user_id, username, user_password, user_active, user_level
				FROM " . USERS_TABLE . "
				WHERE username = '" . str_replace("\\'", "''", $username) . "'";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			if (md5($password) == $row['user_password'] && $row['user_active'])
			{
				$admin = (isset($HTTP_POST_VARS['admin'])) ? 1 : 0;
				$session_id = session_begin($row['user_id'], $user_ip, PAGE_INDEX, FALSE, $autologin, $admin);

				redirect(append_sid("install." . $phpEx, true));
			}
			else
			{
				redirect(append_sid("install." . $phpEx . "?login_failed=1", true));
			}
		}
		else
		{
			redirect(append_sid("install." . $phpEx . "?login_failed=1", true));
		}
	}
	else
	{
		$login_failed = (isset($HTTP_GET_VARS['login_failed'])) ? 1 : 0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<title><?php echo $lang['Title']; ?></title>
<style type="text/css">
<!--
font,th,td,p,body { font-family : "Courier New", courier; font-size : 11pt; }
a:link,a:active,a:visited { color : #006699; }
a:hover { text-decoration : underline; color : #DD6900; }
.maintitle { font-weight : bold; font-size : 22px; font-family : "Trebuchet MS",Verdana, Arial, Helvetica, sans-serif; text-decoration : none; line-height : 120%; color : #000000; }
.ok { color : green; }
.bad { color : red; }
-->
</style>
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">
<form name="post" method="post" action="<?php echo append_sid("install." . $phpEx, true); ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td align="center" valign="middle" colspan="2"><span class="maintitle"><?php echo ( ( $login == '1' ) ? $lang['Login_failed'] : ( ( $userdata['session_logged_in'] ) ? $lang['Login_admin'] : $lang['Login_title'] ) ) ?></span></td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap"><b><?php echo $lang['Login_username']; ?>:</b></td>
		<td class="row2" width="100%"><input type="text" name="username" value="" size="25" /></td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap"><b><?php echo $lang['Login_password']; ?>:</b></td>
		<td class="row2" width="100%"><input type="password" name="password" value="" size="40" /></td>
	</tr>
	<tr>
		<td class="row2" colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $lang['Login_submit']; ?>" /><input type="hidden" name="admin" value="<?php echo ($userdata['session_logged_in']) ? '1': '0'; ?>" /></td>
	</tr>
</table>
</form>
</body>
</html>
<?php
		exit;
	}
}
else if ( !$userdata['session_admin'] )
{
	message_die(GENERAL_MESSAGE, $lang['Login_not_admin']);
	exit;
}

if ( !isset($HTTP_POST_VARS['confirm']) && !isset($HTTP_POST_VARS['cancel']) && $board_config['mod_advanced_group_color_management'] != AGCM_CURRENT_VERSION )
{
	$detected_version = $board_config['mod_advanced_group_color_management'];
	$current_version = AGCM_CURRENT_VERSION;

	$install_agcm = ( !empty($detected_version) ) ? sprintf($lang['Upgrade_install'], $detected_version, $current_version) : sprintf($lang['New_install'], $current_version);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<title><?php echo $lang['Title']; ?></title>
<style type="text/css">
<!--
font,th,td,p,body { font-family : "Courier New", courier; font-size : 11pt; }
a:link,a:active,a:visited { color : #006699; }
a:hover { text-decoration : underline; color : #DD6900; }
.maintitle { font-weight : bold; font-size : 22px; font-family : "Trebuchet MS",Verdana, Arial, Helvetica, sans-serif; text-decoration : none; line-height : 120%; color : #000000; }
.ok { color : green; }
.bad { color : red; }
-->
</style>
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">
<form name="post" method="post" action="<?php echo append_sid("install." . $phpEx, true); ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td align="center" valign="middle"><span class="maintitle"><?php echo $install_agcm; ?></span></td>
	</tr>
	<tr>
		<td class="row2" align="center"><input type="submit" name="confirm" value="<?php echo $lang['Submit']; ?>" />&nbsp;&nbsp;&nbsp;<input type="submit" name="cancel" value="<?php echo $lang['Cancel']; ?>" /></td>
	</tr>
</table>
</form>
</body>
</html>
<?php
		exit;
}
else if ( isset($HTTP_POST_VARS['confirm']) && !isset($HTTP_POST_VARS['cancel']) )
{
	$detected_version = $board_config['mod_advanced_group_color_management'];
	$current_version = AGCM_CURRENT_VERSION;

	$install_agcm = ( !empty($detected_version) ) ? sprintf($lang['Upgrade_msg'], $detected_version, $current_version) : sprintf($lang['Install_msg'], $current_version);
}
else if ( $board_config['mod_advanced_group_color_management'] == AGCM_CURRENT_VERSION && !empty($board_config['mod_advanced_group_color_management']) )
{
	message_die(GENERAL_MESSAGE, $lang['Already_up-to-date']);
	exit;
}
else
{
	message_die(GENERAL_MESSAGE, $lang['Not_to_install']);
	exit;
}

//
// Here we go
//
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<title><?php echo $lang['Title']; ?></title>
<style type="text/css">
<!--
font,th,td,p,body { font-family : "Courier New", courier; font-size : 11pt; }
a:link,a:active,a:visited { color : #006699; }
a:hover { text-decoration : underline; color : #DD6900; }
.maintitle { font-weight : bold; font-size : 22px; font-family : "Trebuchet MS",Verdana, Arial, Helvetica, sans-serif; text-decoration : none; line-height : 120%; color : #000000; }
.ok { color : green; }
.bad { color : red; }
-->
</style>
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">
<table width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td align="center" width="100%" valign="middle"><span class="maintitle"><?php echo $install_agcm; ?></span></td>
	</tr>
	<tr>
		<td width="100%">
<?php

include($phpbb_root_path.'includes/sql_parse.'.$phpEx);

$available_dbms = array(
	"mysql" => array(
		"SCHEMA" => "mysql",
		"DELIM" => ";",
		"COMMENTS" => "remove_remarks"
	),
	"mysql4" => array(
		"SCHEMA" => "mysql",
		"DELIM" => ";",
		"COMMENTS" => "remove_remarks"
	),
	"mssql" => array(
		"SCHEMA" => "mssql",
		"DELIM" => "GO",
		"COMMENTS" => "remove_comments"
	),
	"mssql-odbc" =>	array(
		"SCHEMA" => "mssql",
		"DELIM" => "GO",
		"COMMENTS" => "remove_comments"
	),
	"postgres" => array(
		"LABEL" => "PostgreSQL 7.x",
		"SCHEMA" => "postgres",
		"DELIM" => ";",
		"COMMENTS" => "remove_comments"
	)
);

switch ($board_config['mod_advanced_group_color_management'])
{
	case '0.2.2';
	case '1.0.0';
	case '1.0.1';
	case '1.0.2';
	case '1.0.3';
		$dbms_sql = 'schemas/' . $board_config['mod_advanced_group_color_management'] . '_' . AGCM_CURRENT_VERSION . '/' . $available_dbms[$dbms]['SCHEMA'] . (defined('IN_CH') ? '_CH' : '') . '.sql';
		$update_group_to_g = true;
		break;

	case '1.1.0';
	case '1.1.1';
	case '1.1.2';
	case '1.1.3';
		$dbms_sql = 'schemas/' . $board_config['mod_advanced_group_color_management'] . '_' . AGCM_CURRENT_VERSION . '/' . $available_dbms[$dbms]['SCHEMA'] . (defined('IN_CH') ? '_CH' : '') . '.sql';
		$update_group_to_g = false;
		break;

	case '1.2.0';
	case '1.2.1';
	case '1.2.2';
	case '1.2.3';
		$dbms_sql = '';
		$update_group_to_g = false;
		break;

	default;
		$dbms_sql = 'schemas/full/' . $available_dbms[$dbms]['SCHEMA'] . (defined('IN_CH') ? '_CH' : '') . '.sql';
		break;
}

if ( !empty($dbms_sql) )
{
	$remove_remarks = $available_dbms[$dbms]['COMMENTS'];;
	$delimiter = $available_dbms[$dbms]['DELIM'];

	if ( !($fp = @fopen($dbms_sql, 'r')) )
	{
		message_die(GENERAL_MESSAGE, "Can't open " . $dbms_sql);
	}

	fclose($fp);

	//
	// process db schema
	//
	$sql_query = @fread(@fopen($dbms_sql, 'r'), @filesize($dbms_sql));
	$sql_query = preg_replace('/phpbb_/', $table_prefix, $sql_query);

	if ( !strstr($sql_query, 'user_group_id') )
	{
		die("<br />PLEASE UPLOAD THE CORRECT DATABASE SCHEMA FILES...<br />If you have done so, run the Installer again.<br />");
	}

	$sql_query = $remove_remarks($sql_query);
	$sql_query = split_sql_file($sql_query, $delimiter);
	$sql_count = count($sql_query);
}

if ( $board_config['mod_advanced_group_color_management'] != AGCM_CURRENT_VERSION && !empty($board_config['mod_advanced_group_color_management']) )
{
	$sql = 'UPDATE ' . CONFIG_TABLE . ' SET config_value = \'' . AGCM_CURRENT_VERSION . '\' WHERE config_name = \'mod_advanced_group_color_management\'';

	echo $lang['Running'] . " " . $sql;
	flush();

	if ( !$db->sql_query($sql) )
	{
		$errored = true;
		$error = $db->sql_error();
		echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span></b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
	}
	else
	{
		echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
	}

	if ( !empty($dbms_sql) )
	{
		for ($i = 0; $i < $sql_count; $i++)
		{
			echo $lang['Running'] . " " . $sql_query[$i];
			flush();

			if ( !($db->sql_query($sql_query[$i])) )
			{
				$errored = true;
				$error = $db->sql_error();
				echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span></b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
			}
			else
			{
				echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
			}
		}
	}

	if ( $update_group_to_g )
	{
		if ( defined('IN_CH') )
		{
			$sql = 'SELECT group_id
					FROM ' . GROUPS_TABLE . '
					WHERE group_single_user <> ' . true . '
						AND group_status < ' . GROUP_SPECIAL . '
					ORDER BY group_id ASC';
		}
		else
		{
			$sql = 'SELECT group_id
					FROM ' . GROUPS_TABLE . '
					WHERE group_single_user <> ' . true . '
					ORDER BY group_id ASC';
		}

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain group data', '', __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			echo $lang['Group_remove'] . " #" . intval($row['group_id']) . " :: ";
			flush();

			switch(SQL_LAYER)
			{
				case 'postgres':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' DROP COLUMN group' . intval($row['group_id']) . ' CASCADE';
					break;

				case 'mssql';
				case 'mssql-odbc':
					$sql = 'ALTER TABLE [' . THEMES_TABLE . '] DROP COLUMN [group' . intval($row['group_id']) . ']';
					break;

				case 'mysql':
				case 'mysql4':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' DROP group' . intval($row['group_id']);
					break;
			}

			if ( !$db->sql_query($sql) )
			{
				$error = $db->sql_error();
				echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span> " . $lang['Group_error'] . "</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
			}
			else
			{
				echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
			}

			echo $lang['Group_update'] . " #" . intval($row['group_id']) . " :: ";
			flush();

			$colors->read_group_users(intval($row['group_id']));
			$error = $colors->add_group(intval($row['group_id']), true);

			if ( !empty($error) )
			{
				echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span> " . $lang['Group_error'] . "</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
			}
			else
			{
				echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
			}

			echo $lang['Group_update_color'] . " #" . intval($row['group_id']) . " :: ";
			flush();

			$sql = 'UPDATE ' . THEMES_TABLE . ' SET g' . intval($row['group_id']) . ' = \'' . $theme['group' . $row['group_id']] . '\'';

			if ( !$db->sql_query($sql) )
			{
				$error = $db->sql_error();
				echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span> " . $lang['Group_error'] . "</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
			}
			else
			{
				echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
			}

			$colors->set_group_users(intval($row['group_id']));
		}

		$db->sql_freeresult($result);
	}

	$colors->read(true);
}
else
{
	if ( defined('IN_CH') )
	{
		$sql = 'INSERT ' . CONFIG_TABLE . ' (config_name , config_value , config_static) VALUES (\'mod_advanced_group_color_management\' , \'' . AGCM_CURRENT_VERSION . '\' , \'1\')';
	}
	else
	{
		$sql = 'INSERT ' . CONFIG_TABLE . ' (config_name , config_value) VALUES (\'mod_advanced_group_color_management\' , \'' . AGCM_CURRENT_VERSION . '\')';
	}

	echo $lang['Running'] . " " . $sql;
	flush();

	if ( !$db->sql_query($sql) )
	{
		$errored = true;
		$error = $db->sql_error();
		echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span></b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
	}
	else
	{
		echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
	}

	for ($i = 0; $i < $sql_count; $i++)
	{
		echo $lang['Running'] . " " . $sql_query[$i];
		flush();

		if ( !$db->sql_query($sql_query[$i]) )
		{
			$errored = true;
			$error = $db->sql_error();
			echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span></b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
		}
		else
		{
			echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
		}
	}

	$colors->read(true);
}

if ( defined('IN_CH') )
{
	$sql = 'SELECT group_id
			FROM ' . GROUPS_TABLE . '
			WHERE group_single_user <> ' . true . '
				AND group_status < ' . GROUP_SPECIAL . '
			ORDER BY group_id ASC';
}
else
{
	$sql = 'SELECT group_id
			FROM ' . GROUPS_TABLE . '
			WHERE group_single_user <> ' . true . '
			ORDER BY group_id ASC';
}

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Couldn\'t obtain group data', '', __LINE__, __FILE__, $sql);
}

while ($row = $db->sql_fetchrow($result))
{
	echo $lang['Group_update'] . " #" . intval($row['group_id']) . " :: ";
	flush();

	$colors->read_group_users(intval($row['group_id']));
	$error = $colors->add_group(intval($row['group_id']), true);

	if ( !empty($error) )
	{
		echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span> " . $lang['Group_error'] . "</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
	}
	else
	{
		echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
	}

	$colors->set_group_users(intval($row['group_id']));
}

$db->sql_freeresult($result);
$colors->set_group_weight('group_id');

if ( defined('IN_CH'))
{
	echo "Updateing Group Cache :: ";

	// recache colors
	$colors->read(true);

	echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";

	// recache config
	echo "Updateing Config Cache :: ";

	$config = new config_class();
	if ( $config->read(true))
	{
		echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
	}
	else
	{
		$errored = true;
		echo " -> <b><span class=\"bad\">" . $lang['Failed'] . "</span> " . $lang['Unknown_reason'] . "</b> ---> <u>" . $error['message'] . "</u><br /><br />\n\n";
	}

	// recache themes
	echo "Updateing Theme Cache :: ";

	$themes = new themes();
	$themes->read(true);
	
	echo " -> <b><span class=\"ok\">" . $lang['Completed'] . "</span></b><br /><br />\n\n";
}

if ( $errored )
{
	$message = "<br />" . $lang['AGCM_failed'];
}
else
{
	$message = "<br />" . $lang['AGCM_installed'];
}

echo "\n<br />\n<b>" . $lang['Complete'] . "</b><br />\n";
echo $message;
echo "<br /><br /><b>" . $lang['Delete_folder'] . "</b><br />\n";
echo "</td></tr></table>\n";
echo "</body>\n";
echo "</html>";

?>