<?php
/***************************************************************************
 *                             cookie.php
 *                            -------------------
 *   begin                : Wed, Nov 16, 2004
 *   copyright            : (C) 2004, 2005 geocator
 *   email                : geocator@gmail.com
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

//Lang entries used in this file only
$cookie_lang['lang_name'] = 'english';  //Translators, this is used to load the correct lang files, name it according to the lang directory.
$cookie_lang['Wrong_directory'] = 'You must place cookie.php in phpBBroot/install/, please move the file to the correct location';
$cookie_lang['Welcome_cookie'] = 'Auto Cookies Detection and Reset';
$cookie_lang['cut_and_paste'] = 'Formatted Settings For Posting';
$cookie_lang['write_settings'] = 'Write These Settings To Database';
$cookie_lang['default_settings'] = 'Default Settings';

$cookie_lang['current_settings'] = 'Current Settings';
$cookie_lang['suggested_settings'] = 'Suggested Settings';
$cookie_lang['my_current_settings'] = 'My Current Cookie Settings';
$cookie_lang['my_suggested_settings'] = 'My Suggested Cookie Settings';

$cookie_lang['Auto_explain'] = 'The following settings have been automatically detected.  In most cases these settings are correct, and can be left as-is.  After reviewing these settings make sure to click on the "Write These Settings To Database" button, no changes are made to your forum until you do this. Please note, if you are experiencing log-in dificulties, cookies may not be the issue.  After running this script, if you still have issues, please continue your current topic or start a new support topic at <a href="http://www.phpbb.com/phpBB" target="_new">www.phpbb.com</a>.  If for any reason you need to revert your cookie settings back to the default ones used when you installed phpBB click the "Default Settings" button.';
$cookie_lang['server_name_explain'] = 'This is the domain part or your url only.  It should not contain http:// in it.  Current Setting: ';
$cookie_lang['server_port_explain'] = 'This is the port your visitors access the site on.  This is not your database server port. Current Setting: ';
$cookie_lang['script_path_explain'] = 'This is the part of your url after the domain.  It must start and end with /.  Current Setting: ';
$cookie_lang['cookie_secure_explain'] = 'This setting does not refer to the security of the cookie itself.  If you are running your forum on an SSL connection set this to enabled, if not it must be set to disabled. Current Setting: ';
$cookie_lang['cookie_domain_explain'] = 'This setting should contain the domain name only, without host name.  If you access your domain with any host name (Ex: www) then it should be preceeded by a period.  Current Setting: ';
$cookie_lang['cookie_path_explain'] = 'This setting should be the same as your script path setting without a trailing slash.  Current Setting: ';
$cookie_lang['cookie_name_explain'] = 'This setting can be anything you like, however it cannot contain any period.  This should be different on every forum that shares your domain. Current Setting: ';
$cookie_lang['session_length_explain'] = 'This is the length of time in seconds until a users session expires.  This is computed from the users last page load.  Anything over 3600 can lead to database overload on busy boards.  Current Setting: ';
$cookie_lang['allow_autologin_explain'] = 'Determines whether users are allowed to select to be automatically logged in when visiting the forum. Normally this should be set to yes, as users expect this option.  Current Setting: ';
$cookie_lang['max_autologin_time_explain'] = 'How long a autologin key is valid for in days if the user does not visit the board. Set to zero to disable expiry. Normally this should be set to 0.  Current Setting: ';
$cookie_lang['formatted_explain'] = 'These boxes contain your current and sugested cookie settings formated with bbcode ready to post in your support topic, if requested.';


$cookie_lang['Clear_browser'] = 'You and your users must clear your browser cookies and cache, and close and restart you browsers for these settings to take effect.';
$cookie_lang['Delete_file'] = 'Please delete this script and the install directory now!';


//PHP5 Fix from phpBB Group
if (!isset($HTTP_SERVER_VARS))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_SERVER_VARS = $_SERVER;
}

//Slashes security code from common.php
//
// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
//
if( !get_magic_quotes_gpc() )
{
   if( is_array($HTTP_GET_VARS) )
   {
      while( list($k, $v) = each($HTTP_GET_VARS) )
      {
         if( is_array($HTTP_GET_VARS[$k]) )
         {
            while( list($k2, $v2) = each($HTTP_GET_VARS[$k]) )
            {
               $HTTP_GET_VARS[$k][$k2] = addslashes($v2);
            }
            @reset($HTTP_GET_VARS[$k]);
         }
         else
         {
            $HTTP_GET_VARS[$k] = addslashes($v);
         }
      }
      @reset($HTTP_GET_VARS);
   }

   if( is_array($HTTP_POST_VARS) )
   {
      while( list($k, $v) = each($HTTP_POST_VARS) )
      {
         if( is_array($HTTP_POST_VARS[$k]) )
         {
            while( list($k2, $v2) = each($HTTP_POST_VARS[$k]) )
            {
               $HTTP_POST_VARS[$k][$k2] = addslashes($v2);
            }
            @reset($HTTP_POST_VARS[$k]);
         }
         else
         {
            $HTTP_POST_VARS[$k] = addslashes($v);
         }
      }
      @reset($HTTP_POST_VARS);
   }

   if( is_array($HTTP_COOKIE_VARS) )
   {
      while( list($k, $v) = each($HTTP_COOKIE_VARS) )
      {
         if( is_array($HTTP_COOKIE_VARS[$k]) )
         {
            while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
            {
               $HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
            }
            @reset($HTTP_COOKIE_VARS[$k]);
         }
         else
         {
            $HTTP_COOKIE_VARS[$k] = addslashes($v);
         }
      }
      @reset($HTTP_COOKIE_VARS);
   }
}


//Small check on location of file, not foolproof but should help some
if(substr(strrchr(dirname($HTTP_SERVER_VARS['PHP_SELF']), "/"), 1) != 'install')
{
	die($cookie_lang['Wrong_directory']);
}

define('IN_PHPBB', true);
$phpbb_root_path = './../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

// Import language files.
include($phpbb_root_path.'language/lang_' . $cookie_lang['lang_name'] . '/lang_main.'.$phpEx);
include($phpbb_root_path.'language/lang_' . $cookie_lang['lang_name'] . '/lang_admin.'.$phpEx);

//Initialize Some Variables so functions work
$current_settings = array();
$new_settings = array();

//if submitted write either new or default values.
if (isset($HTTP_POST_VARS['submit']))
{
	if ($HTTP_POST_VARS['submit'] == $cookie_lang['write_settings'])
	{
		$cookie_name = str_replace('.', '_', $HTTP_POST_VARS['cookie_name']);
		
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['cookie_domain'])) . "' WHERE config_name = 'cookie_domain'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['cookie_path'])) . "' WHERE config_name = 'cookie_path'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($cookie_name)) . "' WHERE config_name = 'cookie_name'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['server_name'])) . "' WHERE config_name = 'server_name'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS['script_path'])) . "' WHERE config_name = 'script_path'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['server_port']) . " WHERE config_name = 'server_port'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['cookie_secure']) . " WHERE config_name = 'cookie_secure'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['session_length']) . " WHERE config_name = 'session_length'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['allow_autologin']) . " WHERE config_name = 'allow_autologin'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = " . intval($HTTP_POST_VARS['max_autologin_time']) . " WHERE config_name = 'max_autologin_time'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
	}
	elseif ($HTTP_POST_VARS['submit'] == $cookie_lang['default_settings'])
	{
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '' WHERE config_name = 'cookie_domain'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '/' WHERE config_name = 'cookie_path'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = 'phpbb2mysql' WHERE config_name = 'cookie_name'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = 3600 WHERE config_name = 'session_length'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = 1 WHERE config_name = 'allow_autologin'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = 0 WHERE config_name = 'max_autologin_time'";
		if( !$db->sql_query($sql) )
		{
		  message_die(GENERAL_ERROR, "Failed to update");
		}
	}
	page_header('');
	page_complete();
	page_footer();
	die;
}



//Display the initial page.
load_current_settings();
detect_settings();
page_header($cookie_lang['Auto_explain']);
page_form();
page_cp();
page_footer();




//
// FUNCTIONS
//

//Program Functions
function load_current_settings()
{
	global $board_config, $current_settings, $lang;
	
	$current_settings['server_name'] = $board_config['server_name'];
	$current_settings['script_path'] = $board_config['script_path'];
	$current_settings['server_port'] = $board_config['server_port'];
	$current_settings['cookie_secure'] = $board_config['cookie_secure'];
	$current_settings['cookie_domain'] = $board_config['cookie_domain'];
	$current_settings['cookie_path'] = $board_config['cookie_path'];
	$current_settings['cookie_name'] = $board_config['cookie_name'];
	$current_settings['session_length'] = $board_config['session_length'];
	$current_settings['max_autologin_time'] = $board_config['max_autologin_time'];
	
	if ($board_config['allow_autologin'])
	{
		$current_settings['allow_autologin_text'] = $lang['Yes'];
	}
	else
	{
		$current_settings['allow_autologin_text'] = $lang['No'];
	}
	
	if ($board_config['cookie_secure'])
	{
		$current_settings['cookie_secure_yes'] = 'checked="checked"';
		$current_settings['cookie_secure_no'] = '';
		$current_settings['cookie_secure_text'] = $lang['Enabled'];
	}
	else 
	{
		$current_settings['cookie_secure_no'] = 'checked="checked"';
		$current_settings['cookie_secure_yes'] = '';
		$current_settings['cookie_secure_text'] = $lang['Disabled'];
	}
}

function detect_settings()
{
	global $new_settings, $HTTP_SERVER_VARS, $lang;
	
	$new_settings['server_port'] = $HTTP_SERVER_VARS['SERVER_PORT'];
	$new_settings['server_name'] = $HTTP_SERVER_VARS['SERVER_NAME'];
	$new_settings['script_path'] = substr(dirname($HTTP_SERVER_VARS['PHP_SELF']), 0,-7);
	
	if (isset($HTTP_SERVER_VARS['HTTPS']))
	{
		$new_settings['cookie_secure_yes'] = 'checked="checked"';
		$new_settings['cookie_secure_no'] = '';
		$new_settings['cookie_secure_text'] = $lang['Enabled'];
	}
	else 
	{
		$new_settings['cookie_secure_no'] = 'checked="checked"';
		$new_settings['cookie_secure_yes'] = '';
		$new_settings['cookie_secure_text'] = $lang['Disabled'];
	}
	$domain_name = explode('.', $HTTP_SERVER_VARS['SERVER_NAME']);
	$domain_count = count($domain_name);
	if (ip2long($HTTP_SERVER_VARS['SERVER_NAME']) != -1)
	{
		$new_settings['cookie_domain'] = $HTTP_SERVER_VARS['SERVER_NAME'];
		$new_settings['cookie_name'] = 'phpBB2_forum';
	}
	elseif ($domain_count < 3)
	{
		$new_settings['cookie_domain'] = $HTTP_SERVER_VARS['SERVER_NAME'];
		$new_settings['cookie_name'] = substr($domain_name[0],0,10) . '_forum';
	}
	elseif ($domain_count > 3)
	{
		$new_settings['cookie_domain'] = '.' . $domain_name[$domain_count - 3] . '.' . $domain_name[$domain_count - 2] . '.' . $domain_name[$domain_count - 1];
		$new_settings['cookie_name'] = substr($domain_name[$domain_count - 3],0,10) . '_forum';
	}
	else 
	{
		$new_settings['cookie_domain'] = '.' . $domain_name[$domain_count - 2] . '.' . $domain_name[$domain_count - 1];
		$new_settings['cookie_name'] = substr($domain_name[$domain_count - 2],0,10) . '_forum';
	}

	$new_settings['cookie_path'] = substr($new_settings['script_path'], 0, -1);

	if (strlen($new_settings['cookie_path']) == 0)
	{
	  $new_settings['cookie_path'] = "/";
	}
}


//Display Functions
function page_complete()
{
	global $lang, $cookie_lang, $HTTP_POST_VARS;
?>
	<tr><td colspan=2>	
		<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
			<tr>
			  <th class="thHead"><?php echo $lang['Config_updated']; ?></th>
			</tr>
			<tr>
				<td class="row1">
					<span class="gen"><?php echo $cookie_lang['Clear_browser']; ?></span><br />
					<span class="gen"><strong><font color="red"><?php echo $cookie_lang['Delete_file']; ?></font></strong></span><br />
				</td>
			</tr>
	</td></tr>
<?php
}

function page_form()
{
	global $lang, $cookie_lang, $current_settings, $new_settings, $phpEx;
?>
	<tr><td colspan=2>	
		<form action="<?php echo "cookie." . $phpEx; ?>" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
			<tr>
			  <th class="thHead" colspan="2"><?php echo $lang['Cookie_settings']; ?></th>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Server_name']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['server_name_explain']; echo $current_settings['server_name']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" maxlength="255" size="40" name="server_name" value="<?php echo $new_settings['server_name']; ?>" /></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Server_port']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['server_port_explain']; echo $current_settings['server_port']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" maxlength="5" size="5" name="server_port" value="<?php echo $new_settings['server_port']; ?>" /></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Script_path']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['script_path_explain']; echo $current_settings['script_path']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" maxlength="255" name="script_path" value="<?php echo $new_settings['script_path']; ?>" /></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Cookie_secure']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['cookie_secure_explain']; echo $current_settings['cookie_secure_text']; ?></span>
				</td>
				<td class="row2" valign="top"><span class="gen"><input type="radio" name="cookie_secure" value="0" <?php echo $new_settings['cookie_secure_no']; ?> /><?php echo $lang['Disabled']; ?>&nbsp; &nbsp;<input type="radio" name="cookie_secure" value="1" <?php echo $new_settings['cookie_secure_yes']; ?> /><?php echo $lang['Enabled']; ?></span></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Cookie_domain']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['cookie_domain_explain']; echo $current_settings['cookie_domain']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" maxlength="255" name="cookie_domain" value="<?php echo $new_settings['cookie_domain']; ?>" /></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Cookie_path']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['cookie_path_explain']; echo $current_settings['cookie_path']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" maxlength="255" name="cookie_path" value="<?php echo $new_settings['cookie_path']; ?>" /></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Cookie_name']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['cookie_name_explain']; echo $current_settings['cookie_name']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" maxlength="16" name="cookie_name" value="<?php echo $new_settings['cookie_name']; ?>" /></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Session_length']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['session_length_explain']; echo $current_settings['session_length']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" maxlength="5" size="5" name="session_length" value="3600" /></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Allow_autologin']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['allow_autologin_explain']; echo $current_settings['allow_autologin_text']; ?></span>
				</td>
				<td class="row2" valign="top"><span class="gen"><input type="radio" name="allow_autologin" value="1" checked="checked" /><?php echo $lang['Yes']; ?>&nbsp; &nbsp;<input type="radio" name="allow_autologin" value="0" /><?php echo $lang['No']; ?></span></td>
			</tr>
			<tr>
				<td class="row1" width="33%">
					<span class="gen"><strong><?php echo $lang['Autologin_time']; ?>:</strong></span><br />
					<span class="gensmall"><?php echo $cookie_lang['max_autologin_time_explain']; echo $current_settings['max_autologin_time']; ?></span>
				</td>
				<td class="row2" valign="top"><input class="post" type="text" size="3" maxlength="4" name="max_autologin_time" value="0" /></td>
			</tr>
			<tr>
				<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $cookie_lang['write_settings']; ?>" class="mainoption" />&nbsp;&nbsp;<input type="submit" name="submit" value="<?php echo $cookie_lang['default_settings']; ?>" class="liteoption" />&nbsp;&nbsp;<input type="reset" value="<?php echo $lang['Reset']; ?>" class="liteoption" />
				</td>
			</tr>
		</table></form>
	</td></tr>
<?php
}


function page_cp()
{
	global $cookie_lang, $lang, $current_settings, $new_settings;
	
?>
	<tr><td colspan=2>	
		<br />
		<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
			<tr>
			  <th class="thHead" colspan="2"><?php echo $cookie_lang['cut_and_paste']; ?></th>
			</tr>
			<tr>
				<td colspan="2">
					<span class="gen"><?php echo $cookie_lang['formatted_explain']; ?></span>
				</td>
			</tr>
			<tr>
				<td class="catLeft" align="center"><span class="cattitle"><?php echo $cookie_lang['current_settings']; ?></span></td>
				<td class="catRight" align="center"><span class="cattitle"><?php echo $cookie_lang['suggested_settings']; ?></td>
			</tr>
			<tr>
				<td class="row1" align="center">
					<textarea rows="13" cols="60">
[b]<?php echo $cookie_lang['my_current_settings']; ?>:[/b]
[list]
[*]<?php echo $lang['Server_name']; ?>: [b][color=red]<?php echo $current_settings['server_name']; ?>[/color][/b]
[*]<?php echo $lang['Server_port']; ?>: [b][color=red]<?php echo $current_settings['server_port']; ?>[/color][/b]
[*]<?php echo $lang['Script_path']; ?>: [b][color=red]<?php echo $current_settings['script_path']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_secure']; ?>: [b][color=red]<?php echo $current_settings['cookie_secure_text']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_domain']; ?>: [b][color=red]<?php echo $current_settings['cookie_domain']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_path']; ?>: [b][color=red]<?php echo $current_settings['cookie_path']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_name']; ?>: [b][color=red]<?php echo $current_settings['cookie_name']; ?>[/color][/b]
[*]<?php echo $lang['Session_length']; ?>: [b][color=red]<?php echo $current_settings['session_length']; ?>[/color][/b]
[*]<?php echo $lang['Allow_autologin']; ?>: [b][color=red]<?php echo $current_settings['allow_autologin_text']; ?>[/color][/b]
[*]<?php echo $lang['Autologin_time']; ?>: [b][color=red]<?php echo $current_settings['max_autologin_time']; ?>[/color][/b]
[/list]</textarea>
				</td>
				<td class="row1" align="center">
					<textarea rows="13" cols="60">
[size=14][b]<?php echo $cookie_lang['my_suggested_settings']; ?>:[/b][/size]
[list]
[*]<?php echo $lang['Server_name']; ?>: [b][color=blue]<?php echo $new_settings['server_name']; ?>[/color][/b]
[*]<?php echo $lang['Server_port']; ?>: [b][color=blue]<?php echo $new_settings['server_port']; ?>[/color][/b]
[*]<?php echo $lang['Script_path']; ?>: [b][color=blue]<?php echo $new_settings['script_path']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_secure']; ?>: [b][color=blue]<?php echo $new_settings['cookie_secure_text']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_domain']; ?>: [b][color=blue]<?php echo $new_settings['cookie_domain']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_path']; ?>: [b][color=blue]<?php echo $new_settings['cookie_path']; ?>[/color][/b]
[*]<?php echo $lang['Cookie_name']; ?>: [b][color=blue]<?php echo $new_settings['cookie_name']; ?>[/color][/b]
[*]<?php echo $lang['Session_length']; ?>: [b][color=blue]3600[/color][/b]
[*]<?php echo $lang['Allow_autologin']; ?>: [b][color=blue]Yes[/color][/b]
[*]<?php echo $lang['Autologin_time']; ?>: [b][color=blue]0[/color][/b]
[/list]</textarea>
				</td>
			</tr>
<?php
}


//These functions are modified from install.php
function page_header($text)
{
	global $lang, $cookie_lang;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $lang['ENCODING']; ?>">
<meta http-equiv="Content-Style-Type" content="text/css">
<title><?php echo $cookie_lang['Welcome_cookie'];?></title>
<link rel="stylesheet" href="../templates/subSilver/subSilver.css" type="text/css">
<style type="text/css">
<!--
th			{ background-image: url('../templates/subSilver/images/cellpic3.gif') }
td.cat		{ background-image: url('../templates/subSilver/images/cellpic1.gif') }
td.rowpic	{ background-image: url('../templates/subSilver/images/cellpic2.jpg'); background-repeat: repeat-y }
td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom { background-image: url('../templates/subSilver/images/cellpic1.gif') }

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("../templates/subSilver/formIE.css"); 
//-->
</style>
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">

<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center"> 
	<tr>
		<td class="bodyline" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="../templates/subSilver/images/logo_phpBB.gif" border="0" alt="Forum Home" vspace="1" /></td>
						<td align="center" width="100%" valign="middle"><span class="maintitle"><?php echo $cookie_lang['Welcome_cookie'];?></span></td>
					</tr>
				</table></td>
			</tr>
			<tr>
				<td><br /><br /></td>
			</tr>
			<tr>
				<td colspan="2">
					
					<span class="gen"><?php echo $text; ?></span><br /><br />
					
				</td>
			</tr>
<?php

}

function page_footer()
{

?>
				</table>
			</td></tr>
			<tr>
			<td colspan="2">
				<div align="center"><span class="copyright"><br />Copyright &copy 2005 <a href="http://www.geocator.us">geocator</a></span></div>
			</td>
			</tr>
		</table></td>
	</tr>
</table>

</body>
</html>
<?php

}
?>