<?php
/***************************************************************************
 *                             db_install.php
 *                            -------------------
 *   date		:  2006-10-07
 *   copyright	: (C) 2006 Nathan Guse
 *   email		: exreaction@gotechzilla.com
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

$version = '1.0.02c';

define('IN_PHPBB', true);
$phpbb_root_path = './';

include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

if( !$userdata['session_logged_in'] )
{
	header("Location: login.$phpEx?redirect=db_install.$phpEx");
	exit;
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'You are not authorised to access this page');
}

function _sql($sql, &$errored, &$error_ary, $echo_dot = true)
{
	global $db;

	if (!($result = $db->sql_query($sql)))
	{
		$errored = true;
		$error_ary['sql'][] = (is_array($sql)) ? $sql[$i] : $sql;
		$error_ary['error_code'][] = $db->sql_error();
	}

	if ($echo_dot)
	{
		echo ". \n";
		flush();
	}

	return $result;
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
				<td><a href="index.php"><img src="templates/subSilver/images/logo_phpBB.gif" border="0" alt="Forum Home" vspace="1" /></a></td>
				<td align="center" width="100%" valign="middle"><span class="maintitle">EXreaction's Forum Sponsors Mod: Database Updater</span></td>
			</tr>
		</table></td>
	</tr>
</table>

<br clear="all" />

<h2>Information</h2>

<?php

echo '<p>Database type: <b>' . SQL_LAYER . '</b><br />';

echo 'EXreaction\'s Forum Sponsors Mod Version: <b>' . $version . '</b></p>' ."\n";

echo '<p>This installs the database sections for EXreaction\'s Forum Sponsors Mod.  Currently, only the MySQL aspect has been tested.  If you\'re using any other database, please report your results to EXreaction.</p>' . "\n";

$sql = array();

$sql[] = "ALTER TABLE " . FORUMS_TABLE . " ADD `sponsor` TEXT NOT NULL";

echo "<h2>Updating database schema</h2>\n";
echo "<p>Progress: <b>";
flush();

$error_ary = array();
$errored = false;

for ($i = 0; $i < count($sql); $i++)
{
	_sql($sql[$i], $errored, $error_ary);
}

echo "</b> <b class=\"ok\">Done</b><br />Result: \n";

if ($errored)
{
	echo " <b>Some queries failed, the statements and errors are listing below</b>\n<ul>";

	for ($i = 0; $i < count($error_ary['sql']); $i++)
	{
		echo "<li>Error :: <b>" . $error_ary['error_code'][$i]['message'] . "</b><br />";
		echo "SQL &nbsp; :: <b>" . $error_ary['sql'][$i] . "</b><br /><br /></li>";
	}

	echo "</ul>\n<p>If the errors that occured don't say \"Duplicate entry\" or \"Duplicate column\" please PM, or Email EXreaction, or reply to a support thread with the details of the error, otherwise you already have those fields in your database, just ignore them.</p>\n";
}
else
{
	echo "<b>No errors</b>\n";
}


echo "<h2>Install completed, you should now delete this file.</h2>";
echo 'Click <a href="index.php">here</a> to go back to the forum index';

?>

<br clear="all" />

</body>
</html>