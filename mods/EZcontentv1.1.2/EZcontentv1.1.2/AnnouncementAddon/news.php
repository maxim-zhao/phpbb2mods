<?php
/***************************************************************************
 *                                news.php
 *                            -------------------
 *   begin                :  Feb, 2006
 *   e-mail               :  chris.j.bridges@gmail.com
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

/***************************************************************************
*
*   For this script to work apropriately you must change the config values
*   Bellow. All configuration options are between this block and the next
*
****************************************************************************/

//This option defines what forum to pull news items from. change 1 to your forum ID
$forum_fetch = '1';

//This option defines how many articles to display. change 10 to your ammount
$no_articles = '10';

//This option defines the news page title, replace home with your title
$page_name = '';

/***************************************************************************
*
*   End of Configuration
*
****************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_NEWS);
init_userprefs($userdata);
//
// End session management
//

$page_title = $page_name;
//
// get news items from db
//

$sql = "SELECT * FROM " . TOPICS_TABLE . " WHERE forum_id = '$forum_fetch' ORDER BY topic_time DESC LIMIT $no_articles";
	if (!($result= $db->sql_query($sql)) ) 
		{
			message_die(GENERAL_ERROR, $lang['data_error'], '', __LINE__, __FILE__, $sql);
		}

$t=1;
		
while ( $row = $db->sql_fetchrow($result) ) 
	{ 
		//
		// topic info
		//
		
		$topic_id[$t] = $row['topic_id'];
		$topic_title[$t] = $row['topic_title']; 
		$topic_poster[$t] = $row['topic_poster']; 		
		$topic_time[$t] = $row['topic_time'];
		$date[$t] = create_date($board_config['default_dateformat'], $row['topic_time'], $board_config['board_timezone']);
		$topic_views[$t] = $row['topic_views'];
		$topic_replies[$t] = $row['topic_replies'];		
		$topic_first_post_id[$t] = $row['topic_first_post_id'];	
		
		$t++;
	}	
		
for ($z=1; $z < $t; $z++ )
	{					

		//
		// get post text
		//

		$sql = "SELECT post_text, bbcode_uid FROM " . POSTS_TEXT_TABLE . " WHERE post_id = '$topic_first_post_id[$z]'";
			if (!($result= $db->sql_query($sql)) ) 
				{	
					message_die(GENERAL_ERROR, $lang['data_error'], '', __LINE__, __FILE__, $sql);
				}

		$row = $db->sql_fetchrow($result);
		$post = $row['post_text'];		
		$bbcode_uid = $row['bbcode_uid'];
		
		$post = smilies_pass($post);	
		$post = ($board_config['allow_bbcode']) ? bbencode_second_pass($post, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $post);
		$post = make_clickable($post);
		$post = str_replace("\n", "\n<br />\n", $post);	
		
		//
		// get topic starter's name
		//
		
		$sql = "SELECT username FROM " . USERS_TABLE . " WHERE user_id = '$topic_poster[$z]'";
			if (!($result= $db->sql_query($sql)) ) 
				{	
					message_die(GENERAL_ERROR, $lang['data_error'], '', __LINE__, __FILE__, $sql);
				}

        while ( $row = $db->sql_fetchrow($result) )
        	{
				$user_name = $row['username'];		
			}
			
		$template->assign_block_vars('topics', array( 
			'TITLE' => $topic_title[$z], 
			'USER' => $user_name,
			'DATE' => $date[$z],
			'POST' => $post,
			'VIEWS' => $topic_views[$z], 
			'REPLIES' => $topic_replies[$z],

			'POSTED_BY' => $lang['News_Posted_By'],
			'NEWS_VIEWS' => $lang['News_Views'],
			'AND' => $lang['And'],
			'NEWS_REPLIES' => $lang['News_Replies'],
			'POST_REPLY' => $lang['News_Post'],
			
			'U_TITLE_CLICK' => append_sid('viewtopic.'.$phpEx.'?'.POST_TOPIC_URL.'='.$topic_id[$z]),
			'U_USER_CLICK' => append_sid('profile.'.$phpEx.'?mode=viewprofile&amp;'.POST_USERS_URL.'='.$topic_poster[$z]),
			'U_REPLY_CLICK' => append_sid('posting.'.$phpEx.'?mode=reply&amp;'.POST_TOPIC_URL.'='.$topic_id[$z]))
		); 

	}


$template->set_filenames(array(
	'body' => 'news_body.tpl')
);
				
include($phpbb_root_path .'includes/page_header.'. $phpEx);  
$template->pparse('body'); 
include($phpbb_root_path .'includes/page_tail.'. $phpEx);

?>