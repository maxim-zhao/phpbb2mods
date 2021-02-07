<?php
/*************************************************************************** 
 *				install.php 
 *			-------------------
 *   begin			: Friday, June 16, 2006
 *   copyright		: (C) 2006 Wo1f
 *   email			:
 *
 *   $Id: install.php,v 1.0.0 16/06/2006 12:00:00 Wo1f $
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
 
if(substr(strrchr(dirname($HTTP_SERVER_VARS['PHP_SELF']), "/"), 1) != 'install')
{
	die('Please run this file from inside the /install directory!');
}
 
define('IN_PHPBB', true); 
$phpbb_root_path = './../'; 

include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

$sql = "INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('username_hide_inac', '1')";

if ( !$db->sql_query($sql))
{
	$error = $db->sql_error();
	echo('<b style="color: red;">Error : </b>' . $error['message']);
}
else
{
	echo('<b style="color: green;">Successful Installation!!!</b><p />Now Please delete this file and the /install folder!');
}

?>