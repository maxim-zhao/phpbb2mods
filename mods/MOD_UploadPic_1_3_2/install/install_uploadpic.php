<?php
	/*******************************************
	*                 UploadPic                *
	*                 ---------                *
	*                                          *
	*   date       : 08/2005 - 04/2006         *
	*   (C)/author : B.Funke                   *
	*   URL        : http://forum.beehave.de   *
	*                                          *
	********************************************/

/**
 * @package SQL Parser
 * @script install/db_update.php
 * @copyright (c) 2005 phpBB Group
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 *
 * - Notes:
 *   - This script can only be run by board administrators.
 *   - First, a confirmation panel will show all SQL statements.
 *   - Your database will only be updated once the confirmation panel has been confirmed.
 */

define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
$gen_simple_header = true;

//
// Language entries used in this script.
//
if ($board_config['default_lang'] == "german")
{
	$lang += array(
		'Update_confirm'			=> 'Dieses Skript wird die Datenbank mit den unten aufgef&uuml;hrten SQL-Statements aktualisieren.<br /><br />Vor dem Ausf&uuml;hren sollte ein Backup der Datenbank angefertigt werden!<hr /><table><tr><td><pre>%s</pre></td></tr></table><hr />Klicke <i>Ja</i> um fortzufahren oder <i>Nein</i>, um zum Forum-Index zur&uuml;ckzukehren.<br /><br /><strong>Hinweis:</strong> Wenn das Forum auf einem Windows-Server läuft, sind u.U. die Schreibberechtigungen für das userpix-Verzeichnis manuell zu setzen.',
		'Updating_database'			=> 'Aktualisiere die Datenbank',
		'Installation_complete'		=> 'Installation komplett',
		'Delete_this_file'			=> 'Bitte l&ouml;sche das install-Verzeichnis und diese Datei jetzt aus deinem Forum-Verzeichnis.<br /><br />Hinweis: wenn andere Sprachen (au&szlig;er englisch) installiert werden sollen, mu&szlig; noch die entsprechende Datei im Verzeichnis &quot;translations&quot; ausgeführt werden !',
		'Successful'				=> 'erfolgreich',
		'DirCreated'				=> 'Verzeichnis angelegt',
		'DirNotCreated'				=> 'Verzeichnis konnte nicht angelegt werden'
	);
}
else
{
	$lang += array(
		'Update_confirm'			=> 'This panel will update your database with the SQL statements detailed below.<br /><br />Remember to make backups of your database before proceeding!<hr /><table><tr><td><pre>%s</pre></td></tr></table><hr />Click <i>Yes</i> to proceed or <i>No</i> to return to your board index.<br /><br /><strong>Hint:</strong> If your forum is running a a Windows-server, you may have to set the write-permissions for the userpix-directory manually.',
		'Updating_database'			=> 'Updating the Database',
		'Installation_complete'		=> 'Installation Complete',
		'Delete_this_file'			=> 'Please, be sure to delete your install directory and this file from your phpBB installation now.<br /><br />Note: if you need to install other languages (than english), you will have to execute the corresponding file in the &quot;translations&quot;-directory !',
		'Successful'				=> 'Successful',
		'DirCreated'				=> 'directory created',
		'DirNotCreated'				=> 'directory could not be created'
	);
}

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


// create path to userpix-directory
$str_updirname = 'userpix';
$str_updirname = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($str_updirname));
$script_path = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
$str_updir = ($script_path != '') ? '/'.$script_path.'/'.$str_updirname.'/' : '/'.$str_updirname.'/';


//
// Build Array of SQL Statements.
//
$sqlneuneu = array();

if(SQL_LAYER != 'postgresql')
{
	$sqlneu[] = 'ALTER TABLE ' . USERS_TABLE . ' ADD user_allow_uploadpic TINYINT NOT NULL DEFAULT 0';
}
else
{
	$sqlneu[] = 'ALTER TABLE ' . USERS_TABLE . ' ADD COLUMN user_allow_uploadpic SMALLINT';
	$sqlneu[] = 'ALTER TABLE ' . USERS_TABLE . ' ALTER COLUMN user_allow_uploadpic SET DEFAULT 0';
	$sqlneu[] = 'UPDATE TABLE ' . USERS_TABLE . ' SET user_allow_uploadpic = 0 WHERE user_allow_uploadpic IS NULL';
	$sqlneu[] = 'ALTER TABLE ' . USERS_TABLE . ' ALTER COLUMN user_allow_uploadpic SET NOT NULL';
}

$sqlneu[] = 'UPDATE ' . USERS_TABLE . ' SET user_allow_uploadpic = 1 WHERE user_level = '.ADMIN;

$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_picdir\',\''.$str_updir.'\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_uniqfn\',\'1\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_delete\',\'1\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_lrmod\',\'0\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_showlink\',\'0\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_vbbcode\',\'0\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_multiple\',\'1\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_maxsize\',\'75\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_maxpicx\',\'550\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_maxpicy\',\'300\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_minimum\',\'15\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_allowed\',\'image/jpg|image/jpeg|image/pjpeg|image/gif|image/png|image/x-png|image/x-citrix-pjpeg\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_jpgqual\',\'80\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_allowpm\',\'1\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_maxpmdays\',\'30\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_gallery\',\'1\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_gallerysize\',\'250\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_watermark\',\'0\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_wmpicture\',\'images/up_watermark.png\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_wmpicx\',\'150\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_wmpicy\',\'150\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_wmposition\',\'6\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_numlatest\',\'10\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_forcepath\',\'\')';
$sqlneu[] = 'INSERT INTO ' . CONFIG_TABLE . '(config_name,config_value) VALUES(\'uploadpic_minposts\',\'0\')';

$sqlneu_count = count($sqlneu);

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

	$message = sprintf($lang['Update_confirm'], implode(";\n\n", $sqlneu));

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
$sqlneu_rows = '';
for( $i = 0; $i < $sqlneu_count; $i++ )
{
	if( !($result = $db->sql_query($sqlneu[$i])) )
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
	$sqlneu_rows .= '<tr><td class="'.$class.'"><div class="genmed">' . $sqlneu[$i] . ';<br /><br /><b style="color:' . $color . ';">' . $success . '</b>' . $errmsg . '</div></td></tr>';
}

// create the userpix-directory
if ((!file_exists($phpbb_root_path.$str_updirname)) && (!isset($board_config['uploadpic_picdir'])))
{
	if (mkdir($phpbb_root_path.$str_updirname, 0777))
	{
		$color = '#00AA00';
		$success = $lang['DirCreated'];
		$errmsg = '';
	}
	else
	{
		$error = $db->sql_error();
		$color = '#FF0000';
		$success = $lang['Error'] . ':';
		$errmsg = ' ' . $lang['DirNotCreated'];
	}

	$class = ($i%2) == 0 ? 'row1' : 'row2';
	$sqlneu_rows .= '<tr><td class="'.$class.'"><div class="genmed">' . $str_updir . '<br /><br /><b style="color:' . $color . ';">' . $success . '</b>' . $errmsg . '</div></td></tr>';
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
				{$sqlneu_rows}
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
