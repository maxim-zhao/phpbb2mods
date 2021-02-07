<?php
/***************************************************************************
 *
 *                                clone.php
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

//
// Check and set $post_id for later use
//
$post_id = ( !empty($HTTP_GET_VARS[POST_POST_URL]) ) ? intval($HTTP_GET_VARS[POST_POST_URL]) : '';

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_POSTING);
init_userprefs($userdata);
//
// End session management
//

//
// Was cancel pressed? If so then redirect to the appropriate
// page, no point in continuing with any further checks
//
if ( isset($HTTP_POST_VARS['cancel']) )
{
	if ( $post_id )
	{
		$redirect = "viewtopic.$phpEx?" . POST_POST_URL . "=$post_id";
		$post_append = "#$post_id";
	}
	else
	{
		$redirect = "index.$phpEx";
		$post_append = '';
	}

	redirect(append_sid($redirect, true) . $post_append);
}


//
// Here we do various lookups to find topic_id, forum_id, post_id etc.
// Doing it here prevents spoofing (eg. faking forum_id, topic_id or post_id
//
$error_msg = '';
$post_data = array();

if ( empty($post_id) )
{
	message_die(GENERAL_MESSAGE, $lang['No_post_id']);
}

//
// find out if the user is allowed to view the post...if not, tell him no such post
//
$sql = "SELECT f.forum_id
		FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p
		WHERE p.post_id = $post_id
		AND f.forum_id = p.forum_id";
if ( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_MESSAGE, $lang['No_such_post']);
}
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$current_forum_id = $row['forum_id'];
$is_auth = auth(AUTH_ALL, $current_forum_id, $userdata);
if ( !$is_auth['auth_read'])
{
	message_die(GENERAL_MESSAGE, $lang['No_such_post']);
}

//
// display a form that allows the user to select a target forum...if the user cancels out of that form he comes back to this file and gets
// redirected but if he submits the form he gets redirected to posting.php where the post gets treated as if he were editing the origninal post
// but with the $forum_id of the final submission set to the forum the user selects in this form
//

// let's look up the forums the user is allowed to post in
$forum_id_list = array();
$forum_name_list = array();
$sql = "SELECT forum_id, forum_name
		FROM " . FORUMS_TABLE . "
		ORDER BY forum_name";

if ( $result = $db->sql_query($sql) )
{
	$i = 0;
	while ( $row = $db->sql_fetchrow($result) )
	{
		$is_auth = auth(AUTH_ALL, $row['forum_id'], $userdata);
		if ( $is_auth['auth_post'] )
		{
			$forum_id_list[$i] = $row['forum_id'];
			$forum_name_list[$i] = $row['forum_name'];
			$i++;
		}
	}
	$db->sql_freeresult($result);
}
else
{
	message_die(GENERAL_ERROR, 'Could not obtain list of forums', '', __LINE__, __FILE__, $sql);
}

// next we pass stuff to the forum which will allow the user to specify which forum to post the clone to...
$page_title = $lang['Forum_selection'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$s_hidden_fields = '<input type="hidden" name="clonepost" value="TRUE" />';
$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
$s_hidden_fields .= '<input type="hidden" name="mode" value="editpost" />';
$s_hidden_fields .= '<input type="hidden" name="' . POST_POST_URL . '" value="' . $post_id . '" />';
$template->assign_vars(array(

'L_FORUM_SELECTION' => $lang['Forum_selection'],
'L_FORUM_SELECTION_EXPLAIN' => $lang['Forum_selection_explain'],
'L_FORUM' => $lang['Forum'],
'L_SELECT' => $lang['Select'],
'L_CLONE_POST' => $lang['Clone_post'],
'L_CANCEL_CLONE' => $lang['Cancel_clone'],
'L_CLICK_TO_POST_IN_ORIGINAL_POSTER_NAME' => $lang['Click_to_post_in_original_poster_name'],

'S_POST_IN_ORIGINAL_POSTER_NAME' => '',
'S_HIDDEN_FIELDS' => $s_hidden_fields,
'S_SELECT_FORUM_ACTION' => append_sid("posting.$phpEx?" . POST_POST_URL . $post_id))
);

$template->set_filenames(array(
'body' => 'clone_target_forum_selection.tpl')
);

if( $is_auth['auth_mod'] )
{
	$template->assign_block_vars('switch_include_option_to_post_using_name_of_original_poster', array());
}

for ($i = 0; $i < count($forum_id_list); $i++)
{
	$forum_id = $forum_id_list[$i];
	$forum_name = $forum_name_list[$i];
	//the following sets the default forum_id for the form to be the forum where the original post comes from
	$forum_selected = ( $forum_id == $current_forum_id ) ? TRUE : FALSE;
	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

	$template->assign_block_vars('listrow', array(
	'ROW_COLOR' => '#' . $row_color,
	'ROW_CLASS' => $row_class,

	'S_MARK_ID' => $forum_id,
	'S_DEFAULT_FORUM' => ( $forum_selected ) ? 'checked="checked"' : '',

	'U_FORUM_NAME' => $forum_name)
	);
}
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

// ok, the template is all drawn.  When the user submits the form he will be taken back to posting.php in clone mode with forum_id set
?>