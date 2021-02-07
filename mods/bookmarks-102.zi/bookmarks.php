<?php 
/*************************************************************************** 
*                              Bookmarks.php 
*                            ------------------- 
*   begin                : Monday, Jan 20, 2003 
*   copyright            : (C) 2003-2005 Daniel Taylor 
*   email                : daniel@danielt.com 
*   $Id: bookmarks.php,v 1.0.2 2004/10/26 17:24:17 danielt Exp $
* 
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

// 
// Start session management 
// 
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// 
// End session management 

if( !$userdata['session_logged_in'] ) { 
	header("Location: " . append_sid($phpbb_script_path . "login." . $phpEx . "?redirect=bookmarks." . $phpEx)); 
	exit; 
}

$mode = isset($HTTP_POST_VARS['mode'])?$HTTP_POST_VARS['mode']:(isset($HTTP_GET_VARS['mode'])?$HTTP_GET_VARS['mode']:(""));
$topic_id = intval(isset($HTTP_POST_VARS['t'])?$HTTP_POST_VARS['t']:(isset($HTTP_GET_VARS['t'])?$HTTP_GET_VARS['t']:("")));

if ( !(empty($mode)) ) { 
	
	if ( empty($topic_id) ) {
		message_die(GENERAL_MESSAGE, $lang['no_book_topic']); 
		break; 
	}

	if ( $mode == 'add' ) { 

		if ( !(empty($topic_id))) {

			$user_id = intval($userdata['user_id']); 
			$sql = "SELECT *
				FROM " . BOOKMARKS_TABLE . "
				WHERE user_id = '" . $user_id . "' AND topic_id = '" . $topic_id ."'";

			$result = $db->sql_query($sql);

			$num_row = $db->sql_numrows($result);

			$auths = check_topic_auth($topic_id);

			if ( $auths['auth_read'] < 1 ) {
				
				message_die(GENERAL_ERROR, 'User has no permissons', '', __LINE__, __FILE__, $sql); 
			} 

			if ($num_row <= "0" ) {

				$sql = "INSERT INTO " . BOOKMARKS_TABLE . " (book_id, user_id, topic_id)
					VALUES (NULL, '" . $user_id . "', '" . $topic_id . "')"; 
       
				if ( !($result = $db->sql_query($sql)) ) {
					message_die(GENERAL_ERROR, $lang['insert_book_data'], '', __LINE__, __FILE__, $sql); 
				} 
			}
			else {
				message_die(GENERAL_ERROR, $lang['exist_book']);
			}

			$message = $lang['bookmark_added'] . '<br /><br />' .  sprintf($lang['Click_return_bookmarks'], '<a href="' . append_sid("bookmarks.$phpEx") . '">', '</a>') . '<br /><br />' .  sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?t=" . $topic_id) . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);

		}
		else {
			message_die(GENERAL_ERROR, $lang['no_book_topic']);
		}
	} 
	

	elseif ( $mode == 'remove' ) 
	{ 
		if ( !(empty($topic_id))) { 

			$user_id = intval($userdata['user_id']); 
			$sql = "DELETE FROM " . BOOKMARKS_TABLE . "
				WHERE user_id = '$user_id' AND topic_id = '$topic_id'"; 
       		}
		else {
			message_die(GENERAL_ERROR, $lang['no_book_topic']);
		}

		if ( !($result = $db->sql_query($sql)) ) {
			message_die(GENERAL_ERROR, $lang['remove_book_data'], '', __LINE__, __FILE__, $sql); 
		} 
				
		$message = $lang['bookmark_removed'] . '<br /><br />' .  sprintf($lang['Click_return_bookmarks'], '<a href="' . append_sid("bookmarks.$phpEx") . '">', '</a>') . '<br /><br />' .  sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?t=" . $topic_id) . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);

	}
} 
else { 

	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$user_id = intval($userdata['user_id']);

	$template->set_filenames(array( 
		'body' => 'book_body.tpl') 
	); 

	$template->assign_vars(array(
		'L_TOPIC' => $lang['Topic'],
		'L_REPLIES' => $lang['Replies'],
		'L_LASTPOST' => $lang['Last_Post'], 
		'L_AUTHOR' => $lang['Author'],
		'L_VIEWS' => $lang['Views'],
		'L_DELETE' => $lang['Delete'])
	);

	$sql = "SELECT " . BOOKMARKS_TABLE . ".topic_id, " . TOPICS_TABLE . ".*
		FROM " . BOOKMARKS_TABLE . " LEFT JOIN " . TOPICS_TABLE . " 
		ON " . BOOKMARKS_TABLE . ".topic_id = " . TOPICS_TABLE . ".topic_id 
		WHERE " . BOOKMARKS_TABLE . ".user_id = '" . intval($userdata['user_id']) . "'";
        
	$result = $db->sql_query($sql); 

	$num_row = $db->sql_numrows($result);

	if ($num_row > 0) {

		while ( $row = $db->sql_fetchrow($result) ) {

			if( $row['topic_type'] == POST_ANNOUNCE ) {
				$folder = $images['folder_announce'];
				$folder_alt = $lang['Post_Announcement'];
				$folder_text = $lang['Topic_Announcement'];
			}
			else if( $row['topic_type'] == POST_STICKY ) {
				$folder = $images['folder_sticky'];
				$folder_alt = $lang['Post_Sticky'];
				$folder_text = $lang['Topic_Sticky'];
			}
			else {
				$folder = $images['folder'];
				$folder_new = $images['folder_new'];
				$folder_alt = $lang['Post_Normal'];
				$folder_text = "";
			}
		
			if( $row['topic_status'] == TOPIC_LOCKED )
			{
				$folder = $images['folder_locked'];
				$folder_alt = $lang['Topic_locked'];
				$folder_text = "";
			}

			$template->assign_block_vars('topicrow', array(
				'S_FOLDER' => $folder,
				'S_FOLDER_ALT' => $folder_alt,
				'S_FOLDER_TEXT' => $folder_text,
				'S_VIEWS' => $row['topic_views'],
				'S_REPLIES' => $row['topic_replies'],

				'L_REMOVE' => $lang['Delete'],
				'L_TOPIC_TITLE' => $row['topic_title'],

				'U_TOPIC_TITLE' => append_sid("viewtopic.$phpEx?t=" . intval($row['topic_id'])),
				'U_TOPIC' => intval($row['topic_id']),
				'U_SID' => $userdata['sid'],
				'U_FORM' => append_sid("bookmarks.$phpEx")) 
			);
		}
	}
	else {

		$template->assign_block_vars('no_bookmarks', array(	
			'L_NO_BOOK' => $lang['no_bookmarks'])
		);	
	
	}
	$template->pparse('body'); 
	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

}

function check_topic_auth($topic) {

	global $db, $lang, $userdata;

	// Okay we need to check that the user has permisson to view/read the topic,
	// i put this in a function so not to cluter up the 'add bookmark' code.
	// a bit of this code was stolen from viewtopic.php, 


	$sql = "SELECT * FROM " . TOPICS_TABLE . "
		WHERE topic_id='" . $topic . "'";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
	}


	if ( !($forum_topic_data = $db->sql_fetchrow($result)) )
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
	}


	$forum_id = intval($forum_topic_data['forum_id']);


	$is_auth = auth(AUTH_READ, $forum_id, $userdata);

	if( !$is_auth['auth_read'] )
	{

		$message = ( !$is_auth['auth_read'] ) ? $lang['Topic_post_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);
	
		message_die(GENERAL_MESSAGE, $message);
	}

	return $is_auth;
	
}

?>
