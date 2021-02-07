<?php
// Wicher, www.detecties.com/phpbb2018
/******************************************************************************************
 Wicher, www.detecties.com/phpbb2018
 guest_see_only_first_post.php version 1.1.8
 Guest See Only First Post 1.1.8
******************************************************************************************/
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}

$template->set_filenames(array(
	'guest_see_only_first_post_body' => 'guest_see_only_first_post.tpl')
);

//
// Update the GSOFP shown counter
//
$sql = "UPDATE " . GSOFP_TABLE . "
	SET GSOFP_shows = GSOFP_shows + 1";
if ( !$db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not update GSOFP shown counter.", '', __LINE__, __FILE__, $sql);
}

$pagination = '';
$select_post_days = '<select name="postdays"><option value="' . $lang['All_Posts'] . '" selected="selected">' . $lang['LogIn First'] . '</option></select>';
$select_post_order = '<select name="postorder"><option value="asc" selected="selected">' . $lang['LogIn First'] . '</option></select>';


$real_total_posts = $forum_topic_data['topic_replies'] + 1;
if ($forum_topic_data['guest_override_conf'])
{
$total_posts = intval($forum_topic_data['guest_num_posts']);
}
else
{
$total_posts = intval($board_config['guest_may_see_posts']);
}
$alert_message = $board_config['guest_alert_message_1'].'<br />'.$board_config['guest_alert_message_2'];
$alert_message = (preg_replace('/%p/', $real_total_posts, $alert_message));

$row_class = $theme['td_class2'];

$template->assign_vars(array(
	'L_LOGIN_REDIRECT' => $lang['login_redirect'],
	'REDIRECTLINK' => '?redirect=viewtopic.$phpEx?'.POST_TOPIC_URL.'='.$topic_id,
	'REDIRECTLINK_ADD' => '&'.POST_DATA_URL.'=yes',
	'GUEST_SEE_ONLY_FIRST_POST_ROW_CLASS' => $row_class,
	'L_GUEST_SEE_ONLY_FIRST_POST_NAME' => $lang['guest_see_only_first_post'],
	'L_BOARD_MESSAGE' => $lang['guest_board_message'],
	'GUEST_SEE_ONLY_FIRST_POST_AVATAR' => $images['guest_see_only_first_post'],
	'GUEST_SEE_ONLY_FIRST_POST_MESSAGE' => $alert_message,
	'L_BACK_TO_TOP' => $lang['Back_to_top'],
	'ICON_MINI_LOGIN' => $images['icon_mini_login'],
	'ICON_MINI_REGISTER' => $images['icon_mini_register'],
	'SPACER' => $images['guest_blank'])
);



$template->assign_var_from_handle('GUEST_SEE_ONLY_FIRST_POST_BOX', 'guest_see_only_first_post_body');


?>