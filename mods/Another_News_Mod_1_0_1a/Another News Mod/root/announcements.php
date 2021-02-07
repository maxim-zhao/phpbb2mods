<?php
/***************************************************************************
 *                             announcements.php
 *                            -------------------
 *   copyright            : Jan Marques © 2006
 *   email                : gigjan@gmail.com
 *   based on Smarter's ezPortal script [http://smartor.is-root.com/]
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
//
// Configuration
//

// Number of news on portal
$CFG['number_of_news'] = '5';

// Length of news
$CFG['news_length'] = '5000';

// News Forum ID: separate by comma for multi-forums, eg. '1,2,5'
$CFG['news_forum'] = '1';

//
// No changes below please
// --------------------------------------------------------

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'fetchposts.'.$phpEx);
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
$page_title = $lang['Home'];
$gen_simple_header = TRUE; 
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'news_body.tpl')
);
$template->assign_vars(array(	
	'L_ANNOUNCEMENT' => $lang['Topic_Announcement'],
	'L_POSTED' => $lang['Posted'],
	'L_COMMENTS' => $lang['Comments'],
	'L_VIEW_COMMENTS' => $lang['View_Comments'],
	'L_POST_COMMENT' => $lang['Post_Comments'],
	'L_READ_FULL' => $lang['Read_Full'])
	);
if(!isset($HTTP_GET_VARS['article']))
{
	$template->assign_block_vars('welcome_text', array());

	$fetchposts = phpbb_fetch_posts($CFG['news_forum'], $CFG['number_of_news'], $CFG['news_length']);

	for ($i = 0; $i < count($fetchposts); $i++)
	{
		if( $fetchposts[$i]['striped'] == 1 )
		{
			$open_bracket = '[ ';
			$close_bracket = ' ]';
			$read_full = $lang['Read_Full'];
		}
		else
		{
			$open_bracket = '';
			$close_bracket = '';
			$read_full = '';
		}

		$template->assign_block_vars('fetchpost_row', array(
			'TITLE' => $fetchposts[$i]['topic_title'],
			'POSTER' => $fetchposts[$i]['username'],
			'TIME' => $fetchposts[$i]['topic_time'],
			'TEXT' => $fetchposts[$i]['post_text'],
			'REPLIES' => $fetchposts[$i]['topic_replies'],
			'U_VIEW_COMMENTS' => append_sid('viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . $fetchposts[$i]['topic_id']),
			'U_POST_COMMENT' => append_sid('posting.' . $phpEx . '?mode=reply&amp;'. POST_TOPIC_URL . '=' . $fetchposts[$i]['topic_id']),
			'U_READ_FULL' => append_sid('announcements.' . $phpEx . '?article=' . $i),
			'L_READ_FULL' => $read_full,
			'OPEN' => $open_bracket,
			'CLOSE' => $close_bracket)
		);
	}
}
else
{
	$fetchposts = phpbb_fetch_posts($CFG['news_forum'], $CFG['number_of_news'], 0);

	$i = intval($HTTP_GET_VARS['article']);

	$template->assign_block_vars('fetchpost_row', array(
		'TITLE' => $fetchposts[$i]['topic_title'],
		'POSTER' => $fetchposts[$i]['username'],
		'TIME' => $fetchposts[$i]['topic_time'],
		'TEXT' => $fetchposts[$i]['post_text'],
		'REPLIES' => $fetchposts[$i]['topic_replies'],
		'U_VIEW_COMMENTS' => append_sid('viewtopic.' . $phpEx . '?t=' . $fetchposts[$i]['topic_id']),
		'U_POST_COMMENT' => append_sid('posting.' . $phpEx . '?mode=reply&amp;t=' . $fetchposts[$i]['topic_id'])
		)
	);
}
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'. $phpEx);
?>