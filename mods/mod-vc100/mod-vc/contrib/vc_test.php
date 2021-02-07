<?php
//
//	file: vc_test.php
//	author: ptirhiik
//	begin: 28/12/2006
//	version: 1.6.0 phpBB - 28/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);

define('GD', false);

$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'vc_test';
include($phpbb_root_path . 'common.' . $phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//
define('VC_DEBUG', true);
include($phpbb_root_path . 'includes/vc/class_visual_confirm_img.' . $phpEx);

// get the code
$code = dss_rand();
$code = substr(str_replace('0', 'Z', strtoupper(base_convert($code, 16, 35))), 2, 6);

if ( GD )
{
	include($phpbb_root_path . 'includes/vc/class_visual_confirm_img_gd.' . $phpEx);
	$visual_confirm_img = new visual_confirm_img_gd();
}
else
{
	include($phpbb_root_path . 'includes/vc/class_visual_confirm_img_bt.' . $phpEx);
	$visual_confirm_img = new visual_confirm_img_bt();
}
$visual_confirm_img->code = $code;
$visual_confirm_img->init();
$visual_confirm_img->display();
unset($visual_confirm_img);
exit;

?>