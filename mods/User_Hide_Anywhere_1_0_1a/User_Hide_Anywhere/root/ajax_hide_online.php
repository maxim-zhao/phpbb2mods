<?php
define('IN_PHPBB', true);
 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 

$new_online = (1 - $userdata['user_allow_viewonline']);

$sql = "UPDATE ".USERS_TABLE." set user_allow_viewonline = $new_online WHERE user_id = ".$userdata['user_id'];

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error updating online info', '', __LINE__, __FILE__, $sql);
}

if ($new_online == 1) 
{
    echo "xxxONLINExxx";
} else {
    echo "xxxHIDDENxxx";
}
?>