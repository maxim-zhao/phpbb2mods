<?php
/***************************************************
 * Project:         phpBB Spam Words
 * File Name:       admin_spamwords_flagged.php
 * File Path:       admin/
 * Start Date:		Monday, Nov 22nd, 2005
 * Written By:		Joe Belmaati
 * Author Email:    belmaati@gmail.com
 * Version #:       1.1.3
 * File Build:
 * Last MOD:        24-09-2006 20:19:47
 ***************************************************/

/***************************************************
 * Notes:
 *
 *
 *
 ***************************************************/
define('IN_PHPBB', 1);

if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['Spam_words']['Flagged_posts'] = "$file";
	return;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_spamwords_admin.' . $phpEx);
include($phpbb_root_path . 'includes/bbcode.' . $phpEx);

$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;

if (isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']))
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
}

$template->set_filenames(array('body' => 'admin/spamwords_flagged_body.tpl'));

$sql = "SELECT p.*, pt.*, u.user_id, u.username
	FROM " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt, " . USERS_TABLE . " u
	WHERE p.post_id = pt.post_id
	AND p.poster_id = u.user_id
	AND p.post_flagged = " . TRUE . "
	ORDER BY p.post_id DESC
	LIMIT " . $start . ", " . $board_config['topics_per_page'];

if (!($result = $db->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Could not query posts', '', __LINE__, __FILE__, $sql);
}

$flagged_row = $db->sql_fetchrowset($result);
$row_count = count($flagged_row);

$template->assign_vars(array
(
	'L_SUBJECT' => $lang['Subject'],
	'L_MESSAGE' => $lang['Message'],
	'L_USERNAME' => $lang['Username'],
	'L_TIME' => $lang['Time'],
	'L_ACTION' => $lang['Action'],
	'L_EDIT' => $lang['Edit'],
	'L_DELETE' => $lang['Delete'],
	'L_DELETE_ALL_FLAGGED' => $lang['Delete_all_flagged'],
	'L_FLAGGED_POSTS' => $lang['Flagged_posts'],
	'L_FLAGGED_POSTS_EXPLAIN' => $lang['Flagged_posts_explain'],
	'S_FLAGGED_ACTION' => append_sid("admin_spamwords_flagged.$phpEx"),
	'S_HIDDEN_FIELDS' => ''
));

for($i = 0; $i < $row_count; $i++)
{
	$bbcode_uid = $flagged_row[$i]['bbcode_uid'];
	$message = $flagged_row[$i]['post_text'];

	if ($bbcode_uid != '')
	{
		$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
	}

	$row_color = (!($i % 2)) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];

	$poster = ($flagged_row[$i]['post_username'] && $flagged_row[$i]['user_id'] < 2) ? $flagged_row[$i]['post_username'] : (($flagged_row[$i]['user_id'] > 1) ? $flagged_row[$i]['username'] : $lang['Anonymous']);

	$template->assign_block_vars('flagged', array
	(
		'ROW_COLOR' => '#' . $row_color,
		'ROW_CLASS' => $row_class,
		'USERNAME' => $poster,
		'SUBJECT' => $flagged_row[$i]['post_subject'],
		'MESSAGE' => $message,
		'TIME' => create_date($board_config['default_dateformat'], $flagged_row[$i]['post_time'], $board_config['board_timezone']),
		'U_EDIT' => append_sid($phpbb_root_path . "posting.$phpEx?mode=editpost&amp;" . POST_POST_URL . "=" . $flagged_row[$i]['post_id']),
		'U_DELETE' => append_sid($phpbb_root_path . "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $flagged_row[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'])
	));
}

//
// No flagged posts yet. Show a nice message...
//
if ($row_count == 0)
{
	$template->assign_block_vars('switch_no_flagged', array());
}
else
{
	$template->assign_block_vars('switch_flagged_posts', array());
}

$sql = "SELECT count(*) AS total
   FROM " . POSTS_TABLE . "
   WHERE post_flagged = " . true;

if (!($result = $db->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Error getting total', '', __LINE__, __FILE__, $sql);
}

if ($total = $db->sql_fetchrow($result))
{
	$total_pag_items = $total['total'];
	$pagination = generate_pagination("admin_spamwords_flagged.$phpEx?$mode=$mode&order=$sort_order", $total_pag_items, $board_config['topics_per_page'], $start);
}

$template->assign_vars(array
(
	'L_NO_FLAGGED_POSTS' => $lang['No_flagged_posts'],
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], (floor($start / $board_config['topics_per_page']) + 1), ceil($total_pag_items / $board_config['topics_per_page']))
));

if(isset($HTTP_POST_VARS['submit']))
{
	$sql = "SELECT post_id FROM " . POSTS_TABLE . "
	WHERE post_flagged = " . true;
    if(!$result = $db->sql_query($sql))
    {
    	message_die(GENERAL_ERROR, 'Could not obtain posts information', '', __LINE__, __FILE__, $sql);
    }

	$flagged_posts_array = array();
	$flagged_posts_array = $db->sql_fetchrowset($result);

    $flagged_posts = '';
    for ($i = 0; $i < count($flagged_posts_array); $i++)
    {
		$flagged_posts .= ($i == 0) ? $flagged_posts_array[$i]['post_id'] : ',' . $flagged_posts_array[$i]['post_id'];
    }

	$sql = "DELETE FROM " . TOPICS_TABLE . "
	WHERE topic_first_post_id IN (" . $flagged_posts . ")
	AND topic_first_post_id = topic_last_post_id";
    if(!$db->sql_query($sql))
    {
    	message_die(GENERAL_ERROR, 'Could not delete flagged posts in topics', '', __LINE__, __FILE__, $sql);
    }

	$sql = "DELETE FROM " . POSTS_TABLE . "
	WHERE post_id IN (" . $flagged_posts . ")";
    if(!$db->sql_query($sql))
    {
    	message_die(GENERAL_ERROR, 'Could not delete flagged posts in topics', '', __LINE__, __FILE__, $sql);
    }

	$sql = "DELETE FROM " . POSTS_TEXT_TABLE . "
	WHERE post_id IN (" . $flagged_posts . ")";
    if(!$db->sql_query($sql))
    {
    	message_die(GENERAL_ERROR, 'Could not delete flagged posts in topics', '', __LINE__, __FILE__, $sql);
    }

    $message = $lang['Delete_all_flagged_success'];
	$message .= '<br /><br />' . sprintf($lang['Click_return_spamwords_flagged'], "<a href=\"" . append_sid("admin_spamwords_flagged.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}

$template->pparse('body');

include('./page_footer_admin.' . $phpEx);
?>
