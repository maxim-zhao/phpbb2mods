<?
/******************************************************************************************
 CCbD_db_install-1.3.0.php version 1.3.0
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
	$sql[] = "ALTER TABLE ".$table_prefix."categories ADD cat_collapsed TINYINT(1) NULL DEFAULT '0'";

	for($x=0;$x<count($sql);$x++)
	{
		$db->sql_query($sql[$x]);
	}
	message_die(GENERAL_MESSAGE,'Inserted sql for Collapsed Catagories By Default 1.3.0, have fun.');
}
else
{
	message_die(GENERAL_MESSAGE,'Not authorised, please contact the board adminstrator!');
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>