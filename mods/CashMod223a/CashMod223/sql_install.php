<?php 
/*************************************************************************** 
 *                              sql_install.php 
 *                            -------------------
 *   begin                : Thursday, Apr 17, 2003
 *   copyright            : (C) 2003 Xore
 *   email                : mods@xore.ca
 *
 *   $Id: sql_install.php,v 2.2.0.0 2003/10/18 00:49:26 Xore $
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
	redirect(append_sid("login.$phpEx?redirect=sql_install.$phpEx", true));
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
      $sql = array( 
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable',0);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_display_after_posts',1);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_post_message','You earned %s for that post');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable_spam_num',10);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable_spam_time',24);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable_spam_message','You have exceeded the alloted amount of posts and will not earn anything for your post');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_installed','yes');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_version','2.2.3');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('points_name','Points');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_adminnavbar','1');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_adminbig','0');",


		   "CREATE TABLE [userid].[{$table_prefix}cash] (
			[cash_id] [int] IDENTITY (1, 1) NOT NULL,
			[cash_order] [int] NOT NULL,
			[cash_settings] [int] NOT NULL,
			[cash_dbfield] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
			[cash_name] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
			[cash_default] [int] NOT NULL,
			[cash_decimals] [int] NOT NULL,
			[cash_imageurl] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
			[cash_exchange] [int] NOT NULL,
			[cash_perpost] [int] NOT NULL,
			[cash_postbonus] [int] NOT NULL,
			[cash_perreply] [int] NOT NULL,
			[cash_maxearn] [int] NOT NULL,
			[cash_perpm] [int] NOT NULL,
			[cash_perchar] [int] NOT NULL,
			[cash_allowance] [int] NOT NULL,
			[cash_allowanceamount] [int] NOT NULL,
			[cash_allowancetime] [int] NOT NULL,
			[cash_allowancenext] [int] NOT NULL,
			[cash_forumlist] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
			) ON [PRIMARY]",
		   "ALTER TABLE [userid].[{$table_prefix}cash] WITH NOCHECK ADD 
			CONSTRAINT [PK_{$table_prefix}cash] PRIMARY KEY CLUSTERED 
			( 
			[cash_id] 
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash] WITH NOCHECK ADD 
			CONSTRAINT [DF_{$table_prefix}cash_cash_order]           DEFAULT (0) FOR [cash_order], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_settings]        DEFAULT (3313) FOR [cash_settings], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_dbfield]         DEFAULT ('user_cash') FOR [cash_dbfield], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_name]            DEFAULT ('cash') FOR [cash_name], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_default]         DEFAULT (0) FOR [cash_default], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_decimals]        DEFAULT (0) FOR [cash_decimals], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_imageurl]        DEFAULT (' ') FOR [cash_imageurl], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_exchange]        DEFAULT (1) FOR [cash_exchange], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_perpost]         DEFAULT (25) FOR [cash_perpost], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_postbonus]       DEFAULT (2) FOR [cash_postbonus], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_perreply]        DEFAULT (25) FOR [cash_perreply], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_maxearn]         DEFAULT (75) FOR [cash_maxearn], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_perpm]           DEFAULT (0) FOR [cash_perpm], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_perchar]         DEFAULT (20) FOR [cash_perchar], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_allowance]       DEFAULT (0) FOR [cash_allowance], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_allowanceamount] DEFAULT (0) FOR [cash_allowanceamount], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_allowancetime]   DEFAULT (2) FOR [cash_allowancetime], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_allowancenext]   DEFAULT (0) FOR [cash_allowancenext], 
			CONSTRAINT [DF_{$table_prefix}cash_cash_forumlist]       DEFAULT (' ') FOR [cash_forumlist]", 


		   "CREATE TABLE [userid].[{$table_prefix}cash_events] (
			[event_name] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
			[event_data] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
			) ON [PRIMARY]",
		   "ALTER TABLE [userid].[{$table_prefix}cash_events] WITH NOCHECK ADD 
			CONSTRAINT [PK_{$table_prefix}cash_events] PRIMARY KEY CLUSTERED 
			( 
			[event_name] 
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash_events] WITH NOCHECK ADD 
			CONSTRAINT [DF_{$table_prefix}cash_events_event_name]    DEFAULT (' ') FOR [event_name], 
			CONSTRAINT [DF_{$table_prefix}cash_events_event_data]    DEFAULT (' ') FOR [event_data]", 


		   "CREATE TABLE [userid].[{$table_prefix}cash_exchange] ( 
			[ex_cash_id1] [int] NOT NULL , 
			[ex_cash_id2] [int] NOT NULL , 
			[ex_cash_enabled] [int] NOT NULL 
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash_exchange] WITH NOCHECK ADD 
			CONSTRAINT [PK_{$table_prefix}cash_exchange] PRIMARY KEY CLUSTERED 
			( 
			[ex_cash_id1], 
			[ex_cash_id2] 
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash_exchange] WITH NOCHECK ADD 
			CONSTRAINT [DF_{$table_prefix}cash_exchange_cash_enabled] DEFAULT (1) FOR [ex_cash_enabled]",


		   "CREATE TABLE [userid].[{$table_prefix}cash_groups] (
			[group_id] [int] NOT NULL,
			[group_type] [int] NOT NULL,
			[cash_id] [int] NOT NULL,
			[cash_perpost] [int] NOT NULL,
			[cash_postbonus] [int] NOT NULL,
			[cash_perreply] [int] NOT NULL,
			[cash_perchar] [int] NOT NULL,
			[cash_maxearn] [int] NOT NULL,
			[cash_perpm] [int] NOT NULL,
			[cash_allowance] [int] NOT NULL,
			[cash_allowanceamount] [int] NOT NULL,
			[cash_allowancetime] [int] NOT NULL,
			[cash_allowancenext] [int] NOT NULL,
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash_groups] WITH NOCHECK ADD 
			CONSTRAINT [PK_{$table_prefix}cash_groups] PRIMARY KEY CLUSTERED 
			( 
			[group_id],[group_type],[cash_id] 
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash_groups] WITH NOCHECK ADD 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_perpost]         DEFAULT (0) FOR [cash_perpost], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_postbonus]       DEFAULT (0) FOR [cash_postbonus], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_perreply]        DEFAULT (0) FOR [cash_perreply], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_perchar]         DEFAULT (0) FOR [cash_perchar], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_maxearn]         DEFAULT (0) FOR [cash_maxearn], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_perpm]           DEFAULT (0) FOR [cash_perpm], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_allowance]       DEFAULT (0) FOR [cash_allowance], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_allowanceamount] DEFAULT (0) FOR [cash_allowanceamount], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_allowancetime]   DEFAULT (2) FOR [cash_allowancetime], 
			CONSTRAINT [DF_{$table_prefix}cash_groups_cash_allowancenext]   DEFAULT (0) FOR [cash_allowancenext]", 


		   "CREATE TABLE [userid].[{$table_prefix}cash_log] (
			log_id [int] IDENTITY (1, 1) NOT NULL,
			log_time [int] NOT NULL,
			log_type [int] NOT NULL,
			log_action [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
			log_text [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash_log] WITH NOCHECK ADD 
			CONSTRAINT [PK_{$table_prefix}cash_log] PRIMARY KEY CLUSTERED 
			( 
			[log_id] 
			) ON [PRIMARY]", 
		   "ALTER TABLE [userid].[{$table_prefix}cash_log] WITH NOCHECK ADD 
			CONSTRAINT [DF_{$table_prefix}cash_log_log_time]   DEFAULT (0) FOR [log_time], 
			CONSTRAINT [DF_{$table_prefix}cash_log_log_type]   DEFAULT (0) FOR [log_type], 
			CONSTRAINT [DF_{$table_prefix}cash_log_log_action] DEFAULT (' ') FOR [log_action], 
			CONSTRAINT [DF_{$table_prefix}cash_log_log_text]   DEFAULT (' ') FOR [log_text]" 
		);
	break;
	case 'mysql':
	case 'mysql4':
	default:
		$sql = array(
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable',0);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_display_after_posts',1);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_post_message','You earned %s for that post');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable_spam_num',10);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable_spam_time',24);",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_disable_spam_message','You have exceeded the alloted amount of posts and will not earn anything for your post');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_installed','yes');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_version','2.2.3');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('points_name','Points');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_adminnavbar','1');",
		   "INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('cash_adminbig','0');",

		   "CREATE TABLE {$table_prefix}cash (
			cash_id smallint(6) NOT NULL auto_increment,
			cash_order smallint(6) NOT NULL default '0',
			cash_settings smallint(4) NOT NULL default '3313',
			cash_dbfield varchar(64) NOT NULL default 'user_cash',
			cash_name varchar(64) NOT NULL default 'cash',
			cash_default int(11) NOT NULL default '0',
			cash_decimals tinyint(2) NOT NULL default '0',
			cash_imageurl varchar(255) NOT NULL default ' ',
			cash_exchange int(11) NOT NULL default '1',
			cash_perpost int(11) NOT NULL default '25',
			cash_postbonus int(11) NOT NULL default '2',
			cash_perreply int(11) NOT NULL default '25',
			cash_maxearn int(11) NOT NULL default '75',
			cash_perpm int(11) NOT NULL default '0',
			cash_perchar int(11) NOT NULL default '20',
			cash_allowance tinyint(1) NOT NULL default '0',
			cash_allowanceamount int(11) NOT NULL default '0',
			cash_allowancetime tinyint(2) NOT NULL default '2',
			cash_allowancenext int(11) NOT NULL default '0',
			cash_forumlist varchar(255) NOT NULL default ' ',
			PRIMARY KEY  (cash_id)
			);",

		   "CREATE TABLE {$table_prefix}cash_events (
			event_name varchar(32) NOT NULL default ' ',
			event_data varchar(255) NOT NULL default ' ',
			PRIMARY KEY  (event_name)
			);",

		   "CREATE TABLE {$table_prefix}cash_exchange (
			ex_cash_id1 int(11) NOT NULL default '0',
			ex_cash_id2 int(11) NOT NULL default '0',
			ex_cash_enabled int(1) NOT NULL default '0',
			PRIMARY KEY  (ex_cash_id1,ex_cash_id2)
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
			);",

		   "CREATE TABLE {$table_prefix}cash_log (
			log_id int(11) NOT NULL auto_increment,
			log_time int(11) NOT NULL default '0',
			log_type smallint(6) NOT NULL default '0',
			log_action varchar(255) NOT NULL default ' ',
			log_text varchar(255) NOT NULL default ' ',
			PRIMARY KEY  (log_id)
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
$phpbb_url = "http://www.phpbb.com/phpBB/viewtopic.php?t=94055#623226";

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
      <span class="genmed">Please delete this file (sql_install.{$phpEx}).<br />
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
