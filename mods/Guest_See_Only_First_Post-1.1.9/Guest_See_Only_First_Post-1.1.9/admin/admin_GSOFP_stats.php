<?php
/******************************************************************************************
 Wicher, www.detecties.com/phpbb2018
 admin_GSOFP_stats.php version 1.1.8	
 Guest See Only First Post 1.1.8	
******************************************************************************************/
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

define('IN_PHPBB', true);

if(!empty ($setmodules))
{
	$filename = basename(__FILE__);
	$module['GSOFP stats']['GSOFP stats'] = $filename;
	return;
}

//
// Set the phpBB path and all that junk. ;)
//
$no_page_header = true;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path.'includes/bignum.'.$phpEx);


if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = "";
}


if( !empty($mode) ) 
{
	switch($mode)
	{
	case 'reset1':
		$sql = "UPDATE " . GSOFP_TABLE . "
			SET GSOFP_logins = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update GOSFPStats table: reset1', '', __LINE__, __FILE__, $sql);
		}
		break;
	case 'reset2':
		$sql = "UPDATE " . GSOFP_TABLE . "
			SET GSOFP_reallogins = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update GOSFPStats table: reset2', '', __LINE__, __FILE__, $sql);
		}
		break;
	case 'reset3':
		$sql = "UPDATE " . GSOFP_TABLE . "
			SET GSOFP_registers = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update GOSFPStats table: reset3', '', __LINE__, __FILE__, $sql);
		}
		break;
	case 'reset4':
		$sql = "UPDATE " . GSOFP_TABLE . "
			SET GSOFP_realregisters = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update GOSFPStats table: reset4', '', __LINE__, __FILE__, $sql);
		}
		break;
	case 'reset5':
		$sql = "UPDATE " . GSOFP_TABLE . "
			SET GSOFP_shows = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update GOSFPStats table: reset5', '', __LINE__, __FILE__, $sql);
		}
		break;
	case 'reset_all':
		$sql = "UPDATE " . GSOFP_TABLE . "
			SET GSOFP_logins = 0, GSOFP_registers = 0, GSOFP_shows = 0, GSOFP_reallogins = 0, GSOFP_realregisters = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update GOSFPStats table', '', __LINE__, __FILE__, $sql);
		}
		break;
	}
}


//
// Starting the stats
//
$sql = "SELECT GSOFP_logins, GSOFP_registers, GSOFP_shows, GSOFP_reallogins, GSOFP_realregisters 
		FROM " . GSOFP_TABLE;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain topic watch information", '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);




//
// Output page to template
//
include('./page_header_admin.'.$phpEx);

$template->set_filenames(array(
	'body' => 'admin/admin_GSOFP_body.tpl'
	)
);

$template->assign_vars(array(
	"I_WICHERMOD" => $images['folder_hot'],
	"U_WICHERMOD" => 'http://www.detecties.com/phpbb2018',

	"L_GSOFP_TITLE" => $lang['gsofptitle'],
	"L_GSOFP_EXPLAIN" => $lang['gsofp_explain'],
	"L_WICHERMOD" => $lang['mymod'],
	'L_GSOFPTITLE' => $lang['gsofptitle'],
	'L_LOGINCLICKS' => $lang['loginclicks'],
	'L_REGISTERCLICKS' => $lang['registerclicks'],
	'L_SHOWS' => $lang['shows'],
	'L_TIMES' => $lang['times'],
	'L_RESET' => $lang['reset'],
	'L_RESET_ALL' => $lang['reset_all'],

	//( $row['GSOFP_logins'] ) ? bignum($row['GSOFP_logins']) : '0';

	'LOGINCLICKS' => ( $row['GSOFP_logins'] ) ? bignum($row['GSOFP_logins']) : '0',
	'REALLOGINS' => ( $row['GSOFP_reallogins'] ) ? bignum($row['GSOFP_reallogins']) : '0',
	'REGISTERCLICKS' => ( $row['GSOFP_registers'] ) ? bignum($row['GSOFP_registers']) : '0',
	'REALREGISTERS' => ( $row['GSOFP_realregisters'] ) ? bignum($row['GSOFP_realregisters']) : '0',
	'SHOWS' => ( $row['GSOFP_shows'] ) ? bignum($row['GSOFP_shows']) : '0',
	'RESETBUTTON' => $images['reset'],
	'RESET_ALLBUTTON' => $images['reset_all'],
	'U_RESET1' => append_sid("admin_GSOFP_stats.$phpEx?mode=reset1"),
	'U_RESET2' => append_sid("admin_GSOFP_stats.$phpEx?mode=reset2"),
	'U_RESET3' => append_sid("admin_GSOFP_stats.$phpEx?mode=reset3"),
	'U_RESET4' => append_sid("admin_GSOFP_stats.$phpEx?mode=reset4"),
	'U_RESET5' => append_sid("admin_GSOFP_stats.$phpEx?mode=reset5"),
	'U_RESET_ALL' => append_sid("admin_GSOFP_stats.$phpEx?mode=reset_all"))
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
