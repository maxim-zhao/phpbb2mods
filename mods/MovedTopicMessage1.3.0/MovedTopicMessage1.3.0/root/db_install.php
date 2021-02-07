<?
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
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

if($userdata['user_level'] == ADMIN)
{
	unset($sql);;
	$sql[] = "ALTER TABLE ".$table_prefix."users ADD user_topic_move_mail TINYINT(1) DEFAULT '0'"; 
	$sql[] = "ALTER TABLE ".$table_prefix."users ADD user_topic_move_pm TINYINT(1) DEFAULT '1'"; 
	$sql[] = "ALTER TABLE ".$table_prefix."users ADD user_topic_move_pm_notify TINYINT(1) DEFAULT '1'"; 
	$sql[] = "INSERT INTO ".$table_prefix."config (config_name, config_value) VALUES ('board_email_moved_topic', '0')'";
	$sql[] = "INSERT INTO ".$table_prefix."config (config_name, config_value) VALUES ('board_topic_moved_mail', '0')'";
	$sql[] = "INSERT INTO ".$table_prefix."config (config_name, config_value) VALUES ('board_topic_moved_pm', '1')'";

	for($x=0;$x<count($sql);$x++)
	{
		$db->sql_query($sql[$x]);
	}
	message_die(GENERAL_MESSAGE,'DB install succesfull, have fun.');
}
else
{
	message_die(GENERAL_MESSAGE,'Not authorised, please contact the board adminstrator!');
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>