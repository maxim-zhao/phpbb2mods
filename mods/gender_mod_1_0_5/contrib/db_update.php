<?php
/**
 *
 * @package SQL Parser
 * @script install/db_update.php
 * @copyright (c) 2005 phpBB Group
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 *
 *
 * - WARNINGS:
 *   *** This script contains SQL/DLL statements that will modify your database!!!
 *   *** The SQL/DDL statements contained in this script are optimized for MySQL only!
 *
 * - Installation:
 *   1) Make backups of your database before proceeding!
 *   2) Create a subdirectory named "install" (without quotes) in your phpBB installation.
 *   3) Save this file as "db_update.php" and upload to your newly created install directory.
 *   4) Now, open the script using your browser of choice as in the following example:
 *      http://www.example.com/forums/install/db_update.php
 *      ...and follow instructions.
 *   5) Once, your DB has been updated, remove the install directory and this file.
 *
 * - Notes:
 *   - This script can only be run by board administrators.
 *   - First, a confirmation panel will show all SQL statements.
 *   - Your database will only be updated once the confirmation panel has been confirmed.
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
$sql[] = 'ALTER TABLE ' . $table_prefix . 'users ADD user_gender TINYINT NOT NULL DEFAULT 0';
$sql[] = 'INSERT INTO ' . $table_prefix . 'config(config_name,config_value) VALUES(\'gender_display\',\'0\')';
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
