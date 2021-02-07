<?php
/***************************************************************************
 *                              admin_topic.php
 *                            -------------------
 *   begin                : Thursday, Mar 03, 2005
 *   copyright            : swizec
 *   email                : iareswizec@hotmail.com
 *
 *
 ***************************************************************************/

define ( 'IN_PHPBB', 1 ); 

if ( !empty ( $setmodules) ) 
{ 
   $filename = basename(__FILE__); 
   $module [ 'topic_permissions' ][ 'Configuration' ] = $filename; 
   
   return; 
}

// 
// Load default header 
// 
$no_page_header = TRUE; 
$phpbb_root_path = './../'; 
$admin_root = './';
require($phpbb_root_path . 'extension.inc'); 
require($admin_root . 'pagestart.' . $phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update topic configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['TConfig_updated'] . "<br /><br />" . sprintf($lang['Click_return_tconfig'], "<a href=\"" . append_sid("admin_topic.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

$modlock_yes = ( $new [ 'allow_modlock' ] ) ? "checked=\"checked\"" : "";
$modlock_no = ( !$new [ 'allow_modlock' ] ) ? "checked=\"checked\"" : "";

$topicpass_yes = ( $new [ 'enable_topicpass' ] ) ? "checked=\"checked\"" : "";
$topicpass_no = ( !$new [ 'enable_topicpass' ] ) ? "checked=\"checked\"" : "";

$guestpass_yes = ( $new [ 'allow_guestpass' ] ) ? "checked=\"checked\"" : "";
$guestpass_no = ( !$new [ 'allow_guestpass' ] ) ? "checked=\"checked\"" : "";

$guestlogin_yes = ( $new [ 'allow_guesttlogin' ] ) ? "checked=\"checked\"" : "";
$guestlogin_no = ( !$new [ 'allow_guesttlogin' ] ) ? "checked=\"checked\"" : "";

$guestsee_yes = ( $new [ 'guest_seepass' ] ) ? "checked=\"checked\"" : "";
$guestsee_no = ( !$new [ 'guest_seepass' ] ) ? "checked=\"checked\"" : "";

$topicban_yes = ( $new [ 'enable_topicban' ] ) ? "checked=\"checked\"" : "";
$topicban_no = ( !$new [ 'enable_topicban' ] ) ? "checked=\"checked\"" : "";

$topicban_mod_yes = ( $new [ 'allow_topicban_mod' ] ) ? "checked=\"checked\"" : "";
$topicban_mod_no = ( !$new [ 'allow_topicban_mod' ] ) ? "checked=\"checked\"" : "";

$topicban_starter_yes = ( $new [ 'allow_topicban_starter' ] ) ? "checked=\"checked\"" : "";
$topicban_starter_no = ( !$new [ 'allow_topicban_starter' ] ) ? "checked=\"checked\"" : "";

$bansee_yes = ( $new [ 'banned_seetopic' ] ) ? "checked=\"checked\"" : "";
$bansee_no = ( !$new [ 'banned_seetopic' ] ) ? "checked=\"checked\"" : "";

$whosee_yes = ( $new [ 'show_tban_who' ] ) ? "checked=\"checked\"" : "";
$whosee_no = ( !$new [ 'show_tban_who' ] ) ? "checked=\"checked\"" : "";

$whysee_yes = ( $new [ 'show_tban_why' ] ) ? "checked=\"checked\"" : "";
$whysee_no = ( !$new [ 'show_tban_why' ] ) ? "checked=\"checked\"" : "";

$aguestlog_yes = ( $new [ 'allow_tnologguest' ] ) ? "checked=\"checked\"" : "";
$aguestlog_no = ( !$new [ 'allow_tnologguest' ] ) ? "checked=\"checked\"" : "";

$aguestlog_mod_yes = ( $new [ 'allow_tnologguest_mod' ] ) ? "checked=\"checked\"" : "";
$aguestlog_mod_no = ( !$new [ 'allow_tnologguest_mod' ] ) ? "checked=\"checked\"" : "";

$aguestlog_starter_yes = ( $new [ 'allow_tnologguest_starter' ] ) ? "checked=\"checked\"" : "";
$aguestlog_starter_no = ( !$new [ 'allow_tnologguest_starter' ] ) ? "checked=\"checked\"" : "";

$redirectnoguest_yes = ( $new [ 'redirectnoguest' ] ) ? "checked=\"checked\"" : "";
$redirectnoguest_no = ( !$new [ 'redirectnoguest' ] ) ? "checked=\"checked\"" : "";

$botnotguest_yes = ( $new [ 'botnotguest' ] ) ? "checked=\"checked\"" : "";
$botnotguest_no = ( !$new [ 'botnotguest' ] ) ? "checked=\"checked\"" : "";

$globalnoguest_yes = ( $new [ 'globalnoguestt' ] ) ? "checked=\"checked\"" : "";
$globalnoguest_no = ( !$new [ 'globalnoguestt' ] ) ? "checked=\"checked\"" : "";

$template -> set_filenames ( array ( 
	'body' => 'admin/topic_perm_body.tpl' 
	) );

//pass to template
$template -> assign_vars ( array (
	'L_CONFIGURATION_TITLE' => $lang [ 'topic_config_title' ],
	'L_CONFIGURATION_EXPLAIN' => $lang [ 'topic_config_explain' ],
	'L_EDIT_LOCKS' => $lang [ 'edit_locks' ],
	'L_MOD_LOCK' => $lang [ 'mod_lock' ],
	'L_MOD_LOCK_EXPLAIN' => $lang [ 'mod_lock_explain' ],
	'L_YES' => $lang [ 'Yes' ],
	'L_NO' => $lang [ 'No' ],
	'L_SUBMIT' => $lang [ 'Submit' ],
	'L_RESET' => $lang [ 'Reset' ],
	'L_PASSWORDS' => $lang [ 'conf_passwords' ],
	'L_TOPICPASS' => $lang [ 'topicpass' ],
	'L_GUESTPASS' => $lang [ 'guestpass' ],
	'L_GUESTPASS_EXPLAIN' => $lang [ 'guestpass_explain' ],
	'L_GUESTLOGIN' => $lang [ 'guestlogin' ],
	'L_GUESTLOGIN_EXPLAIN' => $lang [ 'guestlogin_explain' ],
	'L_GUESTSEE' => $lang [ 'guestsee' ],
	'L_GUESTSEE_EXPLAIN' => $lang [ 'guestsee_explain' ],
	'L_TOPIC_BANS' => $lang [ 'topic_bans' ],
	'L_TOPICBAN' => $lang [ 'topic_ban' ],
	'L_TOPICBAN_MOD' => $lang [ 'topic_ban_mod' ],
	'L_TOPICBAN_STARTER' => $lang [ 'topic_ban_starter' ],
	'L_BANSEE' => $lang [ 'bansee' ],
	'L_WHOSEE' => $lang [ 'whosee' ],
	'L_WHYSEE' => $lang [ 'whysee' ],
	'L_AGUESTLOG' => $lang [ 'aguestlog' ],
	'L_AGUESTLOG_MOD' => $lang [ 'aguestlog_mod' ],
	'L_AGUESTLOG_STARTER' => $lang [ 'aguestlog_starter' ],
	'L_GENERAL_PERM' => $lang [ 'general_perm' ],
	'L_REDIRECTNOGUEST' => $lang[ 'redirectnoguest' ],
	'L_BOTNOTGUEST' => $lang[ 'botnotguest' ],
	'L_GLOBALNOGUEST' => $lang[ 'globalnoguest' ],
	
	'MOD_LOCK_ENABLE' => $modlock_yes,
	'MOD_LOCK_DISABLE' => $modlock_no,
	'TOPICPASS_ENABLE' => $topicpass_yes,
	'TOPICPASS_DISABLE' => $topicpass_no,
	'GUESTPASS_ENABLE' => $guestpass_yes,
	'GUESTPASS_DISABLE' => $guestpass_no,
	'GUESTLOGIN_ENABLE' => $guestlogin_yes,
	'GUESTLOGIN_DISABLE' => $guestlogin_no,
	'GUESTSEE_ENABLE' => $guestsee_yes,
	'GUESTSEE_DISABLE' => $guestsee_no,
	'TOPICBAN_ENABLE' => $topicban_yes,
	'TOPICBAN_DISABLE' => $topicban_no,
	'TOPICBAN_MOD_ENABLE' => $topicban_mod_yes,
	'TOPICBAN_MOD_DISABLE' => $topicban_mod_no,
	'TOPICBAN_STARTER_ENABLE' => $topicban_starter_yes,
	'TOPICBAN_STARTER_DISABLE' => $topicban_starter_no,
	'BANSEE_ENABLE' => $bansee_yes,
	'BANSEE_DISABLE' => $bansee_no,
	'WHOSEE_ENABLE' => $whosee_yes,
	'WHOSEE_DISABLE' => $whosee_no,
	'WHYSEE_ENABLE' => $whysee_yes,
	'WHYSEE_DISABLE' => $whysee_no,
	'AGUESTLOG_ENABLE' => $aguestlog_yes,
	'AGUESTLOG_DISABLE' => $aguestlog_no,
	'AGUESTLOG_MOD_ENABLE' => $aguestlog_mod_yes,
	'AGUESTLOG_MOD_DISABLE' => $aguestlog_mod_no,
	'AGUESTLOG_STARTER_ENABLE' => $aguestlog_starter_yes,
	'AGUESTLOG_STARTER_DISABLE' => $aguestlog_starter_no,
	'REDIRECTNOGUEST_ENABLE' => $redirectnoguest_yes,
	'REDIRECTNOGUEST_DISABLE' => $redirectnoguest_no,
	'BOTNOTGUEST_ENABLE' => $botnotguest_yes,
	'BOTNOTGUEST_DISABLE' => $botnotguest_no,
	'GLOBALNOGUEST_ENABLE' => $globalnoguest_yes,
	'GLOBALNOGUEST_DISABLE' => $globalnoguest_no,
	
	'S_CONFIG_ACTION' => append_sid ( "admin_topic.$phpEx" )
) );

//output page
include($admin_root . 'page_header_admin.'.$phpEx);

$template -> pparse ( 'body' );

include($admin_root . 'page_footer_admin.'.$phpEx);

?>