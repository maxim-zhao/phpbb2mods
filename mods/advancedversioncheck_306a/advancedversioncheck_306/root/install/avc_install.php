<?php
/***************************************************************************
 *                             avc_install.php
 *                            -------------------
 *   begin                : January 2, 2006
 *   author               : Fountain of Apples < webmacster87@gmail.com >
 *   copyright            : (C) 2005-2006 Douglas Bell
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
/**
 * Adapted from markus_petrux's script (http://sql.phpmix.com), details follow:
 *
 * @package SQL Parser
 * @script install/db_update.php
 * @copyright (c) 2005 phpBB Group
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 *
 */

define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
$gen_simple_header = true;

//
// Language entries used in this script.
//
$lang += array(
	'Update_confirm'			=> 'This panel will update your database with the SQL statements detailed below.<br /><br />Remember to make backups of your database before proceeding!<hr /><table><tr><td><pre>%s</pre></td></tr></table><hr />Click <i>Yes</i> to proceed or <i>No</i> to return to your board index.',
	'Updating_database'			=> 'Updating the Database',
	'Installation_complete'		=> 'Installation Complete',
	'Delete_this_file'			=> 'Please, be sure to delete your install directory and this file from your phpBB installation now.',
	'Successful'				=> 'Successful'
);

//
// Session Management.
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

//
// Only administrators here, please
//
if( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=".basename(__FILE__), true));
}
if( $userdata['user_level'] != ADMIN )
{
	if ( @file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx) )
	{
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
	}
	else
	{
		include($phpbb_root_path . 'language/lang_english/lang_admin.' . $phpEx);
	}
	message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

//
// Build Array of SQL Statements.
//
$sql = array();
switch ($dbms)
{
    case 'mysql':
    case 'mysql4':
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_check (
        mod_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        mod_name VARCHAR(250) NOT NULL DEFAULT \'\',
        mod_current_version TEXT NOT NULL DEFAULT \'\',
        mod_new_version TEXT NOT NULL DEFAULT \'\',
        mod_secondary_version TEXT NOT NULL DEFAULT \'\',
        mod_domain_loc TEXT NOT NULL,
        mod_file_name TEXT NOT NULL,
        mod_file_loc TEXT NOT NULL,
        mod_topic_loc TEXT NOT NULL DEFAULT \'\',
        mod_download_loc TEXT NOT NULL DEFAULT \'\',
        mod_dev_status TEXT NOT NULL DEFAULT \'\',
        mod_error VARCHAR(250) DEFAULT \'\',
        mod_status TINYINT(4) NOT NULL DEFAULT 1,
        mod_time_stamp INTEGER(11) NOT NULL DEFAULT 0,
        mod_author_notes TEXT NOT NULL DEFAULT \'\',
        PRIMARY KEY (mod_id)
    )';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_check VALUES(1,\'phpBB\',\'\',\'\',\'\',\'www.phpbb.com\',\'20x.txt\',\'updatecheck\',\'http://www.phpbb.com\',\'\',\'\',\'\',1,0,\'\')';
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_config (
        config_name VARCHAR(255) NOT NULL,
        config_value TEXT NOT NULL DEFAULT \'\',
        PRIMARY KEY (config_name)
    )';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'check_time\',\'86400\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'background_check\',1)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'show_admin_index\',1)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_email\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'email_address\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_pm\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'pm_id\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_post\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'post_forum\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'post_contents\',\'\')';
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_log (
        log_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        log_timestamp INTEGER(11) NOT NULL DEFAULT 0,
        mod_name VARCHAR(250) NOT NULL DEFAULT \'\',
        log_action TEXT NOT NULL DEFAULT \'\',
        PRIMARY KEY (log_id)
    )';
    break;
    case 'mssql':
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_check (
        mod_id INTEGER NOT NULL IDENTITY(1, 1),
        mod_name VARCHAR(250) NOT NULL DEFAULT (\'\'),
        mod_current_version TEXT NOT NULL DEFAULT (\'\'),
        mod_new_version TEXT NOT NULL DEFAULT (\'\'),
        mod_secondary_version TEXT NOT NULL DEFAULT (\'\'),
        mod_domain_loc TEXT NOT NULL,
        mod_file_name TEXT NOT NULL,
        mod_file_loc TEXT NOT NULL,
        mod_topic_loc TEXT NOT NULL DEFAULT (\'\'),
        mod_download_loc TEXT NOT NULL DEFAULT (\'\'),
        mod_dev_status TEXT NOT NULL DEFAULT (\'\'),
        mod_error VARCHAR(250) NULL DEFAULT (\'\'),
        mod_status SMALLINT NOT NULL DEFAULT (1),
        mod_time_stamp INTEGER NOT NULL DEFAULT (0),
        mod_author_notes TEXT NOT NULL DEFAULT (\'\'),
        CONSTRAINT ' . $table_prefix . 'version_check_pk PRIMARY KEY (mod_id) ON [PRIMARY],
        CHECK (mod_id>=0)
    )  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_check VALUES(1,\'phpBB\',\'\',\'\',\'\',\'www.phpbb.com\',\'20x.txt\',\'updatecheck\',\'http://www.phpbb.com\',\'\',\'\',\'\',1,0,\'\')';
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_config (
        config_name VARCHAR(255) NOT NULL,
        config_value TEXT NOT NULL DEFAULT (\'\'),
        CONSTRAINT ' . $table_prefix . 'version_config_pk PRIMARY KEY (config_name) ON [PRIMARY]
    )  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'check_time\',\'86400\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'background_check\',1)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'show_admin_index\',1)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_email\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'email_address\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_pm\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'pm_id\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_post\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'post_forum\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'post_contents\',\'\')';
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_log (
        log_id INTEGER NOT NULL IDENTITY(1, 1),
        log_timestamp INTEGER NOT NULL DEFAULT (0),
        mod_name VARCHAR(250) NOT NULL DEFAULT (\'\'),
        log_action TEXT NOT NULL DEFAULT (\'\'),
        CONSTRAINT ' . $table_prefix . 'version_log_pk PRIMARY KEY (log_id) ON [PRIMARY],
        CHECK (log_id>=0)
    )  ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]';
    break;
    case 'postgres':
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_check (
        mod_id SERIAL,
        mod_name VARCHAR(250) NOT NULL DEFAULT \'\',
        mod_current_version TEXT NOT NULL DEFAULT \'\',
        mod_new_version TEXT NOT NULL DEFAULT \'\',
        mod_secondary_version TEXT NOT NULL DEFAULT \'\',
        mod_domain_loc TEXT NOT NULL,
        mod_file_name TEXT NOT NULL,
        mod_file_loc TEXT NOT NULL,
        mod_topic_loc TEXT NOT NULL DEFAULT \'\',
        mod_download_loc TEXT NOT NULL DEFAULT \'\',
        mod_dev_status TEXT NOT NULL DEFAULT \'\',
        mod_error VARCHAR(250) DEFAULT \'\',
        mod_status SMALLINT NOT NULL DEFAULT 1,
        mod_time_stamp INTEGER NOT NULL DEFAULT 0,
        mod_author_notes TEXT NOT NULL DEFAULT \'\',
        CONSTRAINT ' . $table_prefix . 'version_check_pk PRIMARY KEY (mod_id),
        CHECK (mod_id>=0)
    )';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_check VALUES(1,\'phpBB\',\'\',\'\',\'\',\'www.phpbb.com\',\'20x.txt\',\'updatecheck\',\'http://www.phpbb.com\',\'\',\'\',\'\',1,0,\'\')';
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_config (
        config_name VARCHAR(255) NOT NULL,
        config_value TEXT NOT NULL DEFAULT \'\',
        CONSTRAINT ' . $table_prefix . 'version_config_pk PRIMARY KEY (config_name)
    )';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'check_time\',\'86400\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'background_check\',1)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'show_admin_index\',1)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_email\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'email_address\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_pm\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'pm_id\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'update_post\',0)';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'post_forum\',\'\')';
    $sql[] = 'INSERT INTO ' . $table_prefix . 'version_config VALUES(\'post_contents\',\'\')';
    $sql[] = 'CREATE TABLE ' . $table_prefix . 'version_log (
        log_id SERIAL,
        log_timestamp INTEGER NOT NULL DEFAULT 0,
        mod_name VARCHAR(250) NOT NULL DEFAULT \'\',
        log_action TEXT NOT NULL DEFAULT \'\',
        CONSTRAINT ' . $table_prefix . 'version_log_pk PRIMARY KEY (log_id),
        CHECK (log_id>=0)
    )';
    break;
    default:
    message_die(GENERAL_ERROR, 'Sorry, but AVC is not compatible with ' . $dbms . ', it is only compatible with MySQL, PostgreSQL, and Microsoft SQL.');
}
$sql_count = count($sql);

//
// Output confirmation page?
//
$cancel = isset($HTTP_POST_VARS['cancel']) ? true : false;
$confirm = isset($HTTP_POST_VARS['confirm']) ? true : false;
$mode = isset($HTTP_POST_VARS['mode']) ? trim(htmlspecialchars($HTTP_POST_VARS['mode'])) : '';

if( $cancel )
{
	redirect(append_sid("index.$phpEx", true));
}

if( !$confirm || $mode != 'db_update' )
{
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'confirm_body' => 'confirm_body.tpl')
	);

	$message = sprintf($lang['Update_confirm'], implode(";\n\n", $sql));

	$s_hidden_fields = '<input type="hidden" name="mode" value="db_update" />';

	$template->assign_vars(array(
		'L_INDEX'			=> '',
		'MESSAGE_TITLE'		=> $lang['Information'],
		'MESSAGE_TEXT'		=> $message,
		'L_YES'				=> $lang['Yes'],
		'L_NO'				=> $lang['No'],
		'S_CONFIRM_ACTION'	=> append_sid(basename(__FILE__)),
		'S_HIDDEN_FIELDS'	=> $s_hidden_fields)
	);

	$template->pparse('confirm_body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

//
// Send Page Header.
//
$page_title = $lang['Updating_database'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

//
// Execute SQL and get Results.
//
$sql_rows = '';
for( $i = 0; $i < $sql_count; $i++ )
{
	if( !($result = $db->sql_query($sql[$i])) )
	{
		$error = $db->sql_error();
		$color = '#FF0000';
		$success = $lang['Error'] . ':';
		$errmsg = ' ' . $error['message'];
	}
	else
	{
		$color = '#00AA00';
		$success = $lang['Successful'];
		$errmsg = '';
	}
	$class = ($i%2) == 0 ? 'row1' : 'row2';
	$sql_rows .= '<tr><td class="'.$class.'"><div class="genmed">' . $sql[$i] . ';<br /><br /><b style="color:' . $color . ';">' . $success . '</b>' . $errmsg . '</div></td></tr>';
}

//
// Build the Report.
//
$click_return_index = sprintf($lang['Click_return_index'], '<a class="genmed" href="' . append_sid($phpbb_root_path . "index.$phpEx") . '">', '</a>');

$html = <<<EOT
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="forumline">
	<tr>
		<th>{$page_title}</th>
	</tr>
	<tr>
		<td>
			<table cellpadding="8" cellspacing="1" border="0" align="center">
				{$sql_rows}
			</table>
		</td>
	</tr>
	<tr>
		<td class="row3"><img src="{$phpbb_root_path}images/spacer.gif" border="0" height="4" alt="" /></td>
	</tr>
	<tr>
		<th>{$lang['Installation_complete']}</th>
	</tr>
	<tr>
		<td align="center">
			<table cellpadding="8" cellspacing="0" border="0" align="center">
				<tr>
					<td>
						<b class="gen" style="color:#EE0000;">{$lang['Delete_this_file']}</b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="catBottom" align="center">
			<span class="genmed">{$click_return_index}</span>
		</td>
	</tr>
</table>
EOT;
echo $html;

//
// Send Page Footer.
//
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
