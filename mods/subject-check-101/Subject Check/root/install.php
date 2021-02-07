<?php
/*-----------------------------------------------------------------------------
    Modification Installer
  ----------------------------------------------------------------------------
    install.php
       SQL Installer Script
    Generation Date: December 13, 2006  
  ----------------------------------------------------------------------------
	This file is released under the GNU General Public License Version 2.
-----------------------------------------------------------------------------*/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);

$mod = array(
	'name'			=>	'Subject Check',
	'version'		=>	'1.0.0',
	'copy_year'		=>	'2006',
	'author'		=>	'Thoul',
	'website'		=>	'http://www.phpbbsmith.com/',
	'sitename'		=>	'phpBB Smith',
	'prev_version'	=>	'',
);

$sql = array();
switch( $dbms )
{
	case 'postgres':
		$sql["install"] = array(
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_enable','1')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_bypass','1')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_strict','0')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_locked','1')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_limit','5')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_admin','0')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_mod','0')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_postcount','0')",
	"ALTER TABLE " . $table_prefix . "forums ADD COLUMN forum_subject_check SMALLINT",
	"ALTER TABLE " . $table_prefix . "forums ALTER COLUMN forum_subject_check SET DEFAULT 0");

		$sql["uninstall"] = array(
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_enable'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_bypass'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_strict'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_locked'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_limit'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_admin'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_mod'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_postcount'",
	"ALTER TABLE " . $table_prefix . "forums DROP COLUMN forum_subject_check CASCADE");

		
		break;

	case 'mssql':
		$sql["install"] = array(
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_enable','1')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_bypass','1')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_strict','0')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_locked','1')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_limit','5')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_admin','0')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_mod','0')",
	"INSERT INTO " . $table_prefix . "config(config_name,config_value) VALUES('subchk_postcount','0')");

		$sql["uninstall"] = array(
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_enable'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_bypass'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_strict'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_locked'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_limit'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_admin'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_mod'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_postcount'");

		
		break;

	case 'mysql':
	case 'mysql4':
	default:
		$sql["install"] = array(
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_enable', '1')",
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_bypass', '1')",
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_strict', '0')",
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_locked', '1')",
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_limit', '5')",
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_admin', '0')",
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_mod', '0')",
	"INSERT INTO " . $table_prefix . "config (config_name, config_value) VALUES ('subchk_postcount', '0')",
	"ALTER TABLE " . $table_prefix . "forums ADD forum_subject_check tinyint(1) DEFAULT '0'");

		$sql["uninstall"] = array(
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_enable'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_bypass'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_strict'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_locked'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_limit'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_admin'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_mod'",
	"DELETE FROM " . $table_prefix . "config WHERE config_name = 'subchk_postcount'",
	"ALTER TABLE " . $table_prefix . "forums DROP forum_subject_check");

		
		break;
}

// Session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

if( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=install.$phpEx", true));
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'Not_Authorised');
}

$page_title = $mod['name'] . ' Installer';
$action = ( isset($_REQUEST['action']) ) ? htmlspecialchars(trim($_REQUEST['action'])) : '';

$version_string = $of_name = $for_name = '';
if( !empty($mod['name']) )
{
	$of_name  = ' of ' . $mod['name'];
	$for_name = ' for ' . $mod['name'];
	
}

if( !empty($mod['prev_version']) && !empty($mod['version']) )
{
	$version_string = " from {$mod['name']} {$mod['prev_version']} to {$mod['name']} {$mod['version']}";
}

$page_head = <<<EOH
<html>
<head>
<title>$page_title</title>
<style type="text/css">
<!--
body
{
	color: black;
	background-color: blanchedalmond;
	margin: 0;
	padding: 0;
	font-size: 15px;
	font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
}

a
{
	background-color: inherit;
	text-decoration: none;
	font-size: 1.0em;
}

a:hover
{
	background-color: inherit;
	text-decoration: underline;
}

div#header
{
	width: 100%;
	color: saddlebrown;
	background-position: right bottom;
	border: none;
	margin-top: 0.4em;
	margin-bottom: 0.5em;
}

#logo
{
	font-size: 1.8em;
	font-weight: bold;
	padding-left: 0.5em;
}

#logo a, #logo a:hover
{
	color: saddlebrown;
	font-size: 1em;
}

#footer
{
	clear: both;
	border: none;
	border-top: 1px solid saddlebrown;
	margin: 0;
	padding: 0.3em;
	font-size: 0.7em;
	text-align: right;
}

#content
{
	background: ivory;
	border-top: 1px solid saddlebrown;
	margin-top: 0;
	padding: 0.5em 1em 0.1em;
	text-align: justify;
}

p, ul
{
	font-size: 0.8em;
}

.error
{
	font-weight: bold;
	color: red;
}

.success
{
	font-weight: bold;
	color: green;
}
-->
</style>
</head>
<body>
<div id="header">
	<div id="logo">$page_title</div>
</div>
<div id="content">
<p>
	Welcome to the {$page_title}. This is a script that you can use to install, uninstall, or upgrade the database changes required for the {$mod['name']} modification to operate correctly on your forum. Please select an option below to continue.
</p>
<p>
	Please remember that this script only works with the database changes required $for_name. Any file alterations or additions must be installed, uninstalled, or upgraded separately. Check the documentation $of_name for details on such steps.
</p>
EOH;

$page_tail = <<<EOH
	</div>
	<div id="footer">
		{$mod['name']} Copyright &copy; {$mod['copy_year']} by <a href="{$mod['website']}" title="Visit this web site for support">{$mod['author']}</a>
	</div>
</body>
</html>
EOH;

$db_errors = FALSE;
if( empty($action) || !in_array($action, array('install', 'upgrade', 'uninstall')) )
{
	$url_append = append_sid($phpEx);
	$page_text = <<<EOH
	<p style="font-weight: bold; color: red;">Please note that before proceeding, you should have or create a current full backup of your database. A backup can be used to restore your forum to a state prior to the results of any actions taken by this installer, if necessary.</p>
	<p>
EOH;
	if( !empty($sql['install']) )
	{
		$page_text .= <<<EOH
	<ul>
		<li><a href="install.$url_append?action=install">Install Database Changes</a></li>
EOH;
	}
	if( !empty($sql['uninstall']) )
	{
		$page_text .= <<<EOH
		<li><a href="install.$url_append?action=uninstall">Uninstall Database Changes</a></li>
EOH;
	}
	if( !empty($sql['upgrade']) )
	{
		$page_text .= <<<EOH
		<li><a href="install.$url_append?action=upgrade">Upgrade Database Changes $version_string</a></li>
EOH;
	}
	$page_text .= <<<EOH
	</ul>
	</p>
EOH;
}
elseif( $action == 'install' )
{
	if( empty($sql['install']) )
	{
		$page_text = '<p>Installation is not supported for this modification.</p>';
	}
	else
	{
		$page_text = "
			<p>The installer will now attempt to add the database changes $for_name to your forum.</p>";
		$page_text .= process_sql($sql['install']);
		$page_text .= '
		<p>
			The database installation process is now complete.';
			
		if( $db_errors )
		{
			$page_text .= ' If any error messages are listed above, a problem was encountered during the install. Any "Duplicate entry" errors encountered here are often the result of running the install a second time (sometimes this is done by accident) and usually can be ignored unless other problems appear when using the modification. If you need assistance in troubleshooting these errors, please visit the support forums at <a href="' . $mode['website'] . '">' . $mod['sitename'] . '</a> or <a href="http://www.phpbbhacks.com">phpBBHacks.com</a>.';
		}		
			
		$page_text .= '</p>
			<p>You should now delete install.php from your forum. <span style="font-weight: bold;">Be sure to check the forum admin panel to update any new configuration options that may have been installed.</span></p>';
	}
}
elseif( $action == 'upgrade' )
{
	if( empty($sql['upgrade']) )
	{
		$page_text = '<p>Upgrading is not supported for this modification.</p>';
	}
	else
	{
		$page_text = "<p>The installer will now attempt to upgrade the database changes{$version_string}.</p>";
		$page_text .= process_sql($sql['upgrade']);
		$page_text .= '
		<p>
			The database upgrade process is now complete.';
			
		if( $db_errors )
		{
			$page_text .= ' If any error messages are listed above, a problem was encountered during the upgrade and some portions of the modification may not have been upgraded.  If you need assistance in troubleshooting these errors, please visit the support forums at <a href="' . $mode['website'] . '">' . $mod['sitename'] . '</a> or <a href="http://www.phpbbhacks.com">phpBBHacks.com</a>.';
		}		
			
		$page_text .= '</p>
		
			<p>You should now delete install.php from your forum. <span style="font-weight: bold;">Be sure to check the forum admin panel to update any new configuration options that may have been installed.</span></p>';
	}
}
elseif( $action == 'uninstall' )
{
	if( empty($sql['uninstall']) )
	{
		$page_text = '<p>Uninstalling is not supported for this modification.</p>';
	}
	else
	{
		$page_text = "<p>The installer will now attempt to remove the database changes $of_name from your forum.</p>";
		$page_text .= process_sql($sql['uninstall']);
		$page_text .= '
		<p>
			The database uninstallation process is now complete.';
			
		if( $db_errors )
		{
			$page_text .= ' If any error messages are listed above, a problem was encountered during the uninstall and some portions of the modification may not have been uninstalled.  If you need assistance in troubleshooting these errors, please visit the support forums at <a href="' . $mode['website'] . '">' . $mod['sitename'] . '</a> or <a href="http://www.phpbbhacks.com">phpBBHacks.com</a>.';
		}		
			
		$page_text .= '</p>
		
		<p>You should now delete install.php from your forum.</p>';
	}
}

function process_sql($sql)
{
	global $db, $db_errors;
	$results = '<ul>';
	foreach($sql as $v)
	{
		$results .= "<li>$v<br /><span class=\"";
		if( !$result = $db->sql_query($v) )
		{
			$error = $db->sql_error();
			$results .= 'error">Failed due to error: ' . $error['message'];
			$db_errors = TRUE;
		}
		else
		{
			$results .= 'success">Completed successfully!';
		}
		$results .= "</span></li>";
	}
	$results .= '</ul>';
	return $results;
}

echo $page_head;
echo $page_text;
echo $page_tail;
?>