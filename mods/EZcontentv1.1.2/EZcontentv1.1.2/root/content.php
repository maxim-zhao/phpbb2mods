<?php
/***************************************************************************
 *                                content.php
 *                            -------------------
 *   begin                :  Feb, 2006
 *   e-mail               :  chris@laxforums.co.uk
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

//Define which forum content is allowed from, replace 40, with your forum id
$forum_permission = '40';

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
$userdata = session_pagestart($user_ip, PAGE_CONTENT);
init_userprefs($userdata);
//
// End session management
//
if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
	{
		$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
		$mode = htmlspecialchars($mode);
	}
else 
	{
		$mode = "";
	}

switch( $mode )
	{	
		case "view":
		
			$get_topic = ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) ) ? intval($HTTP_GET_VARS[POST_TOPIC_URL]) : intval($HTTP_POST_VARS[POST_TOPIC_URL]);

			//
			// get request topic from database
			//

			$sql = "SELECT * FROM " . TOPICS_TABLE . " WHERE topic_id = $get_topic";
				if (!($result= $db->sql_query($sql)) ) 
					{
						message_die(GENERAL_ERROR, $lang['data_error'], '', __LINE__, __FILE__, $sql);
					}
		
			$row = $db->sql_fetchrow($result);
			//
			// topic info
			//
		
			$topic_id = $row['topic_id'];
			$topic_title = $row['topic_title']; 
			$topic_poster = $row['topic_poster']; 		
			$topic_time = $row['topic_time'];
			$date = create_date($board_config['default_dateformat'], $row['topic_time'], $board_config['board_timezone']);
			$topic_views = $row['topic_views'];
			$topic_replies = $row['topic_replies'];		
			$topic_first_post_id = $row['topic_first_post_id'];	
			$get_forum = $row['forum_id'];

			//
			//verify the topic has permission
			//

			if ($forum_permission != $get_forum)
				{
			message_die(GENERAL_ERROR, $lang['permission_error']);
				}	
		
			//
			// get post text
			//

			$sql = "SELECT post_text, bbcode_uid FROM " . POSTS_TEXT_TABLE . " WHERE post_id = $topic_first_post_id";
				if (!($result= $db->sql_query($sql)) ) 
					{	
						message_die(GENERAL_ERROR, $lang['data_error'], '', __LINE__, __FILE__, $sql);
					}

			$row1 = $db->sql_fetchrow($result);
			$post = $row1['post_text'];		
			$bbcode_uid = $row1['bbcode_uid'];
		
			$post = smilies_pass($post);	
			$post = ($board_config['allow_bbcode']) ? bbencode_second_pass($post, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $post);
			$post = make_clickable($post);
			$post = str_replace("\n", "\n<br />\n", $post);	
		
			//
			// get topic starter's name
			//
		
			$sql = "SELECT username FROM " . USERS_TABLE . " WHERE user_id = $topic_poster";
				if (!($result= $db->sql_query($sql)) ) 
					{	
						message_die(GENERAL_ERROR, $lang['data_error'], '', __LINE__, __FILE__, $sql);
					}

			$row2 = $db->sql_fetchrow($result);

			$user_name = $row2['username'];		

			
			$template->assign_vars(array( 
				'TITLE' => $topic_title, 
				'USER' => $user_name,
				'DATE' => $date,
				'POST' => $post,
				'VIEWS' => $topic_views, 
				'REPLIES' => $topic_replies,

				'POSTED_BY' => $lang['News_Posted_By'],
				'NEWS_VIEWS' => $lang['News_Views'],
				'AND' => $lang['And'],
				'NEWS_REPLIES' => $lang['News_Replies'],
				'POST_REPLY' => $lang['News_Post'],
			
				'U_TITLE_CLICK' => append_sid('viewtopic.'.$phpEx.'?'.POST_TOPIC_URL.'='.$topic_id),
				'U_USER_CLICK' => append_sid('profile.'.$phpEx.'?mode=viewprofile&amp;'.POST_USERS_URL.'='.$topic_poster),
				'U_REPLY_CLICK' => append_sid('posting.'.$phpEx.'?mode=reply&amp;'.POST_TOPIC_URL.'='.$topic_id))
			); 

			$page_title = $topic_title;



			$template->set_filenames(array(
				'body' => 'content_body.tpl')
			);
				
			include($phpbb_root_path .'includes/page_header.'. $phpEx);  
			$template->pparse('body'); 
			include($phpbb_root_path .'includes/page_tail.'. $phpEx);
			break;
		default:
			$sql = "SELECT * FROM " . TOPICS_TABLE . " WHERE forum_id = $forum_permission";
				if (!($result= $db->sql_query($sql)) ) 
					{
						message_die(GENERAL_ERROR, $lang['data_error'], '', __LINE__, __FILE__, $sql);
					}
					
				while ( $row = $db->sql_fetchrow($result) )
               		{					
						$template->assign_block_vars('pages', array( 
							'PAGENAME' => $row['topic_title'],
							'PAGEURL' => append_sid('content.'.$phpEx.'?mode=view&amp;'.POST_TOPIC_URL.'='.$row['topic_id']))
						);
					}
				
				$page_title = $lang['EZcontent'];
				
				$template->set_filenames(array(
					'body' => 'content_pages_body.tpl')
				);
				
				include($phpbb_root_path .'includes/page_header.'. $phpEx);  
				$template->pparse('body'); 
				include($phpbb_root_path .'includes/page_tail.'. $phpEx);
		break;
	}
						
		
?>