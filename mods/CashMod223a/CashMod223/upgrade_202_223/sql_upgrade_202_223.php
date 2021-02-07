<?php 
/*************************************************************************** 
 *                              sql_upgrade_202_223.php 
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
		   "UPDATE {$table_prefix}config SET config_value = '2.2.3' WHERE config_name = 'cash_version'",

		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_adminnavbar','1');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_adminbig','0');",

		   "ALTER TABLE {$table_prefix}cash DROP cash_enabled;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_image;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_exchange;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_before;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_profiledisplay;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_donate;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_modedit;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_allowneg;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_postdisplay;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_forumlisttype;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_log;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_perchar;",
		   "ALTER TABLE {$table_prefix}cash DROP cash_includequotes;",

		   "ALTER TABLE {$table_prefix}cash ADD cash_settings SMALLINT( 4 ) DEFAULT '3133' NOT NULL ;",
		   "ALTER TABLE {$table_prefix}cash ADD cash_default int(11) NOT NULL default '0';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_decimals tinyint(2) NOT NULL default '0';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_exchange int(11) NOT NULL default '1';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_perpm int(11) NOT NULL default '0';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_perchar int(11) NOT NULL default '20';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_allowance tinyint(1) NOT NULL default '0';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_allowanceamount int(11) NOT NULL default '0';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_allowancetime tinyint(2) NOT NULL default '2';",
		   "ALTER TABLE {$table_prefix}cash ADD cash_allowancenext int(11) NOT NULL default '0';",

		   "DROP TABLE {$table_prefix}cash_log",

		   "CREATE TABLE {$table_prefix}cash_log (
			log_id int(11) NOT NULL auto_increment,
			log_time int(11) NOT NULL default '0',
			log_type smallint(6) NOT NULL default '0',
			log_action varchar(255) NOT NULL default '',
			log_text varchar(255) NOT NULL default '',
			PRIMARY KEY  (log_id)
			);",

		   "CREATE TABLE {$table_prefix}cash_events (
			event_name varchar(32) NOT NULL default '',
			event_data varchar(255) NOT NULL default '',
			PRIMARY KEY  (event_name)
			);",

		   "CREATE TABLE {$table_prefix}cash_groups (
			group_id mediumint(6) NOT NULL default '0',
			group_type tinyint(2) NOT NULL default '0',
			cash_id smallint(6) NOT NULL default '0',
			cash_perpost int(11) NOT NULL default '0',
			cash_postbonus int(11) NOT NULL default '0',
			cash_perreply int(11) NOT NULL default '0',
			cash_perchar int(11) NOT NULL default '0',
			cash_maxearn int(11) NOT NULL default '0',
			cash_perpm int(11) NOT NULL default '0',
			cash_allowance tinyint(1) NOT NULL default '0',
			cash_allowanceamount int(11) NOT NULL default '0',
			cash_allowancetime tinyint(2) NOT NULL default '2',
			cash_allowancenext int(11) NOT NULL default '0',
			PRIMARY KEY  (group_id,group_type,cash_id)
			);"
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
      <span class="genmed">Please delete this file (sql_upgrade_202_223.{$phpEx}).<br />
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
