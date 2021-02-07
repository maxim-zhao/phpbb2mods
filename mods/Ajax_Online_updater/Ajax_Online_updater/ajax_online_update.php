<?php
define('IN_PHPBB', true);
 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$mypage=intval($HTTP_GET_VARS['mypage']); 

$userdata = session_pagestart($user_ip,$mypage); 

init_userprefs($userdata); 

echo "updater";

?>