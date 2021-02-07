<?php
define('IN_PHPBB', 1);
if( !empty($setmodules) )
{
   $file = basename(__FILE__);
   $module['php_utilities']['php_info'] = $file;
   return;
}
//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

phpinfo();

include('./page_footer_admin.'.$phpEx);
?> 