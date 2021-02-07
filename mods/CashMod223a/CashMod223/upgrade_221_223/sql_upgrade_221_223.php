<?php 
/*************************************************************************** 
 *                              sql_upgrade_221_223.php 
 *                            -------------------
 *   begin                : Saturday, Oct 18, 2003
 *   copyright            : (C) 2003 Xore
 *   email                : mods@xore.ca
 *
 *   $Id: sql_upgrade_202_223.php,v 1.0.0.0 2003/10/18 00:46:34 Xore $
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

define('IN_PHPBB', true); 
$phpbb_root_path = './'; 

$i = 0;
while ( !file_exists($phpbb_root_path . 'extension.inc') && ($i++ < 4) )
{
	$phpbb_root_path .= '../';
}
if ( $i > 4 )
{
   message_die(GENERAL_MESSAGE, 'Unable to find extension.inc, terminating. Please move this file into your main/"root" phpbb directory and try again.'); 
}

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
	redirect(append_sid("login.$phpEx?redirect=mysql_install.$phpEx", true));
} 

if( $userdata['user_level'] != ADMIN ) 
{ 
   message_die(GENERAL_MESSAGE, 'You are not authorised to access this page'); 
} 

$page_title = 'Installing Cash Mod v 2.2.3 Tables, Updating Configuration settings'; 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

print<<<DELIM
<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">
  <tr>
    <th class="thHead">Updating the database</th>
  </tr>
  <tr>
    <td>
      <span class="genmed">
        <ul type="circle">

DELIM;

$current_time = time();

switch ( SQL_LAYER )
{
	case 'msaccess':
		$sql = array(
		   "UPDATE {$table_prefix}config SET config_value = '2.2.3' WHERE config_name = 'cash_version'"
		);
		break;
	case 'postgresql':
		break;
	case 'mssql':
	case 'mssql-odbc':
		break;
	case 'mysql':
	case 'mysql4':
	default:
		$sql = array(
		   "UPDATE {$table_prefix}config SET config_value = '2.2.3' WHERE config_name = 'cash_version'"
		);
	break;
}

foreach ( $sql AS $query ) 
{ 
   if ( !($result = $db->sql_query($query)) )
   { 
      $error = $db->sql_error();
      print('<li>' . nl2br($query) . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />');
   } 
   else 
   { 
      print('<li>' . nl2br($query) . '<br /> +++ <font color="#00AA00"><b>Successfull</b></font></li><br />');
   } 
}

$forum_url = append_sid($phpbb_root_path . "index.$phpEx");
$phpbb_url = "http://www.phpbb.com/phpBB/viewtopic.php?t=94055";

print<<<DELIM
        </ul>
      </span>
    </td>
  </tr>
  <tr>
    <td class="catBottom" height="28">&nbsp;</td>
  </tr>
  <tr>
    <td class="catBottom" colspan="2" align="center">Finished</td>
  </tr>
</table>

<br />
<br />

<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">
  <tr>
    <th class="thHead">SQL Installation complete</th>
  </tr>
  <tr>
    <td>
      <span class="genmed">Please delete this file (sql_upgrade_221_223.{$phpEx}).<br />
      If you have any problems, please visit <a href="{$phpbb_url}" target="_new">phpbb.com (CashMod v 2.2.3 Support Thread)</a> and ask for help.</span>
    </td>
  </tr>
  <tr>
    <td class="catBottom" height="28" align="center">
      <span class="genmed"><a href="{$forum_url}">Click Here to return to your forum.</a>
      </span>
    </td>
  </tr>
</table>

DELIM;

include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>
