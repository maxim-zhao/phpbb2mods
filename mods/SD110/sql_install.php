<?php 
/*************************************************************************** 
 *                              sql_install.php 
 *                            -------------------
 *   begin                : Thursday, Apr 17, 2003
 *   copyright            : (C) 2003 Xore
 *   email                : xore@azuriah.com
 *
 *   $Id: sql_install.php,v 1.2.0.0 2003/08/04 14:12:03 Xore $
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

$page_title = 'Installing Cash Mod v 2.0.0 Tables, Updating Configuration settings'; 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

?>
<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">
  <tr>
    <th class="thHead">Updating the database</th>
  </tr>
  <tr>
    <td>
      <span class="genmed">
        <ul type="circle">

<?php

$current_time = time();

// no sql layer required, since we're just inserting

	$sql = array( 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_2','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_3','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_4','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_5','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_6','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_7','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_8','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_9','');", 
		"INSERT INTO {$table_prefix}config (config_name, config_value) VALUES ('site_desc_10','');"
	);

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

$forum_url = append_sid("index.$phpEx");
$phpbb_url = "http://www.phpbb.com/phpBB/viewtopic.php?t=122654";

?>
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
      <span class="genmed">Please delete this file (sql_install.php).<br />
      Also, be sure to complete the install instructions in SiteDescription110.txt (if you haven't already)<br />
      If you have any problems, please visit <a href="<?php echo($phpbb_url); ?>" target="_new">phpbb.com (SiteDescription Support Thread)</a> and ask for help.</span>
    </td>
  </tr>
  <tr>
    <td class="catBottom" height="28" align="center">
      <span class="genmed"><a href="<?php echo($forum_url); ?>">Click Here to return to your forum.</a>
      </span>
    </td>
  </tr>
</table>
<?php

include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>
