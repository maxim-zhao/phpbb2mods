<?
/******************************************************************************************
 CCbD_db_UNinstall1.3.0.php version 1.3.0
 for sql for Collapsed Catagories By Default 1.3.0
******************************************************************************************/
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_NICKPAGE);
init_userprefs($userdata);
//
// End session management
//
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

if($userdata['user_level'] == ADMIN)
{
	unset($sql);
	$sql[] = "DELETE FROM ".$table_prefix."config WHERE `config_name` = 'collapsed_catagories' LIMIT 1";

	for($x=0;$x<count($sql);$x++)
	{
		$db->sql_query($sql[$x]);
	}
	message_die(GENERAL_MESSAGE,'Deleted sql for Collapsed Catagories By Default 1.3.0.');
}
else
{
	message_die(GENERAL_MESSAGE,'Not authorised, please contact the board adminstrator!');
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>