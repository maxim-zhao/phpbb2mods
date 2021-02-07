<?php
/***************************************************
 * Project:         Change Poster
 * File Name:       changeposter.php
 * File Path:       /
 * Start Date:		12-08-2006 19:07:18
 * Written By:		Joe Belmaati
 * Author Email:    belmaati@gmail.com
 * Version #:       1.01
 * File Build:      10001
 * Last MOD:        12-09-2006 16:44:429
 ***************************************************/

/***************************************************
 * Notes: ** Caution ** - Moving all posts from one
 * user to another is un-doable at present!! USe at your
 * own risk.
 *
 ***************************************************/
define('IN_PHPBB', true);

$phpbb_root_path = '';
include ($phpbb_root_path . 'extension.inc');
include ($phpbb_root_path . 'common.' . $phpEx);
include ($phpbb_root_path . 'includes/bbcode.' . $phpEx);

$post_id = intval($HTTP_GET_VARS['post_id']);
$submit = isset($HTTP_POST_VARS['submit']) ? true : false;
$new_postername = phpbb_clean_username($HTTP_POST_VARS['username']);
$move_all = (isset($HTTP_POST_VARS['move_all'])) ? true : false;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs ($userdata);
//
// End session management
//

if ($userdata['user_level'] != ADMIN)
{
	redirect (append_sid("login.$phpEx?redirect=changeposter.$phpEx?post_id=$post_id"));
}

$template->set_filenames(array ( 'body' => 'change_poster.tpl' ));

if ($submit)
{
	/**
	 * Get the original poster id
	 */
	$sql = "SELECT p.poster_id, u.username FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u
	WHERE p.poster_id = u.user_id
	AND post_id = $post_id";

	if (!$result2 = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain post id', '', __LINE__, __FILE__, $sql);
	}

	$old_poster = $db->sql_fetchrow($result2);
	$old_poster_id = $old_poster['poster_id'];
	$old_postername = $old_poster['username'];

	$sql = "SELECT user_id FROM " . USERS_TABLE . "
	WHERE username = '" . str_replace("\'", "''", $new_postername) . "'";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain username', '', __LINE__, __FILE__, $sql);
	}

	if ($db->sql_numrows($result) == 0)
	{
		message_die(GENERAL_ERROR, $lang['Could_not_add_user']);
	}

	$sql_username = $db->sql_fetchrow($result);
	$new_poster_id = $sql_username['user_id'];

	$where = ($move_all) ? "WHERE poster_id = $old_poster_id" : "WHERE post_id = $post_id";

	$sql = "UPDATE " . POSTS_TABLE . "
	SET poster_id = $new_poster_id
	$where";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update posts information', '', __LINE__, __FILE__, $sql);
	}

	$moved_posts = $db->sql_affectedrows($result);

	/**
	 * Update the user post count
	 */
	$sql = "UPDATE " . USERS_TABLE . "
	SET user_posts = user_posts + $moved_posts
	WHERE user_id = $new_poster_id";

	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update user post count', '', __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . USERS_TABLE . "
	SET user_posts = user_posts - $moved_posts
	WHERE user_id = $old_poster_id";

	if(!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update user post count', '', __LINE__, __FILE__, $sql);
	}

	/**
	 * Check if the post starts a topic
	 */
	$sql = "SELECT topic_id FROM " . TOPICS_TABLE . "
	WHERE topic_first_post_id = $post_id";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain topics information', '', __LINE__, __FILE__, $sql);
	}

	if ($db->sql_numrows($result) > 0)
	{
		$topic_array = $db->sql_fetchrow($result);
		$topic_id = $topic_array['topic_id'];

		$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_poster = $new_poster_id
		WHERE topic_id = $topic_id";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topics information', '', __LINE__, __FILE__, $sql);
		}
	}

	if ($move_all)
	{
		$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_poster = $new_poster_id
		WHERE topic_poster = $old_poster_id";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update topics information', '', __LINE__, __FILE__, $sql);
		}
	}

	$meta = ($move_all) ? '<meta http-equiv="refresh" content="5;url=' . append_sid("index.$phpEx") . '">' : '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id") . '">';

	$template->assign_vars(array ( 'META' => $meta ));

	$message = $lang['Post_updated'] . '<br /><br />' . sprintf($lang['Click_return_post'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id") . '">', '</a>');
	$message = ($move_all) ? sprintf($lang['Moved_posts'], $moved_posts, $old_postername, stripslashes($new_postername)) . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>') : $message;

	message_die(GENERAL_MESSAGE, $message);
}
else
{
	/**
	 * Gets the post
	 */

	$sql = "SELECT pt.*, p.poster_id, u.username, u.user_avatar, u.user_avatar_type, u.user_allowavatar FROM " . POSTS_TEXT_TABLE . " pt, " . POSTS_TABLE . " p, " . USERS_TABLE . " u
	WHERE p.post_id = pt.post_id
	AND p.poster_id = u.user_id
	AND p.post_id = $post_id";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain posts information', '', __LINE__, __FILE__, $sql);
	}

	$post_info = $db->sql_fetchrow($result);

	$message = $post_info['post_text'];
	$subject = (!empty($post_info['post_subject'])) ? $post_info['post_subject'] : $lang['No'] . ' ' . $lang['Subject'];
	$bbcode_uid = $post_info['bbcode_uid'];
	$orig_poster = $post_info['username'];
	$orig_poster_id = $post_info['poster_id'];

	$poster_avatar = '';

	if ($post_info['user_avatar_type'] && $poster_id != ANONYMOUS && $post_info['user_allowavatar'])
	{
		switch ($post_info['user_avatar_type'])
		{
			case USER_AVATAR_UPLOAD:
				$poster_avatar = ($board_config['allow_avatar_upload']) ? '<img src="' . $board_config['avatar_path'] . '/' . $post_info['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$poster_avatar = ($board_config['allow_avatar_remote']) ? '<img src="' . $post_info['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$poster_avatar = ($board_config['allow_avatar_local']) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $post_info['user_avatar'] . '" alt="" border="0" />' : '';
				break;
		}
	}

	/**
	 * Parse bbcode
	 */

	if ($bbcode_uid != '')
	{
		$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
	}

	$message = make_clickable($message);
	$message = smilies_pass($message);

	$template->assign_vars(array
	(
		'MESSAGE' => $message,
		'SUBJECT' => $subject,
		'POSTER' => $orig_poster,
		'AVATAR' => $poster_avatar,
		'L_MOVE_ALL' => sprintf($lang['Move_all'], $orig_poster),
		'L_SUBJECT' => $lang['Subject'],
		'L_SUBMIT' => $lang['Submit'],
		'L_AUTHOR' => $lang['Author'],
		'L_USERNAME' => $lang['Username'],
		'L_SELECT_NEW_POSTER' => $lang['Select_new_poster'],
		'L_FIND_USERNAME' => $lang['Find_username'],
		'U_SEARCH_USER' => append_sid("search.$phpEx?mode=searchuser"),
	));
}

$page_title = $lang['Change_poster'];
include ($phpbb_root_path . 'includes/page_header.' . $phpEx);

$template->pparse('body');

include ($phpbb_root_path . 'includes/page_tail.' . $phpEx);
?>
