<?
/******************************************************************************************
 JoSf_db_install.php version 1.1.2
 for sql for Journal or Support Forums 1.1.2
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
	$sql[] = "ALTER TABLE ".$table_prefix."forums ADD js_forum TINYINT(2) NULL DEFAULT '0'";
	$sql[] = "ALTER TABLE ".$table_prefix."users ADD user_journal int(10) NULL DEFAULT '0'";

	for($x=0;$x<count($sql);$x++)
	{
		$db->sql_query($sql[$x]);
	}
	message_die(GENERAL_MESSAGE,'Inserted sql for Journal or Support Forums 1.1.2, have fun.');
}
else
{
	message_die(GENERAL_MESSAGE,'Not authorised, please contact the board adminstrator!');
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>