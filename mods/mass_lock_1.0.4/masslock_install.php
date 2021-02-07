<?php
/***************************************************************************
 *                             install_tables.php
 *                            -------------------
 *   begin                : Wednesday, May 16, 2002
 *   copyright            : Morpheus
 *   email                : morpheus2matrix@yahoo.fr
 *
 *   $Id: install_tables.php,v 1.1.2.6 200/01/21 14:48:17 Morpheus Exp $
 *
 * the source of file is writed by "Motpheus" and edited by Siavash79 for use in "Mass-lock" MOD
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path.'common.'.$phpEx);	

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

if ( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_ERROR, "You must be an Administrator to use this page.");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<title>Install File for MOD's</title>
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

.error {color:red}

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("./templates/subSilver/formIE.css"); 
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#006699" vlink="#5584AA">

<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center"> 
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><a href="./index.php"><img src="./templates/subSilver/images/logo_phpBB.gif" border="0" alt="Forum Home" vspace="1" /></a></td>
				<td align="center" width="100%" valign="middle"><span class="maintitle">Installing Mass-lock MOD</span></td>
			</tr>
		</table></td>
	</tr>
</table>

<br clear="all" />

<h2>Informations</h2>

<?php
$sql = "CREATE TABLE " . LOCK_TABLE . "
	( lock_id mediumint(8) unsigned NOT NULL auto_increment,
		 forum_id smallint(5) unsigned NOT NULL default '0',
		 lock_days smallint(5) unsigned NOT NULL default '0',
 		lock_freq smallint(5) unsigned NOT NULL default '0',
	PRIMARY KEY (lock_id), 
	KEY forum_id (forum_id) )";

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Can't build forum_lock table", "", __LINE__, __FILE__);
}

$sql = "ALTER TABLE " . FORUMS_TABLE . " ADD `lock_enable` TINYINT( 1 ) DEFAULT '0' NOT NULL";
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Can't alter fields to forums table", "", __LINE__, __FILE__);
} 

$sql = "ALTER TABLE " . FORUMS_TABLE . " ADD `lock_next` INT (11) DEFAULT NULL";
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Can't alter fields to forums table", "", __LINE__, __FILE__);
} 


$sql = "INSERT INTO " . CONFIG_TABLE . "
	VALUES ('lock_enable', 1)";

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Can't insert lock_enable to configs table", "", __LINE__, __FILE__);
} 


?>
<span class="ok">The database updated sucessfully! now delete this file</span>
</body>
</html>