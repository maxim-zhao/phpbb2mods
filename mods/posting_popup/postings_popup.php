<?php 

define('IN_PHPBB', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

// Start initial var setup
//
$topic_id = intval($HTTP_GET_VARS[t]);

// Start session management 
// 
$userdata = session_pagestart($user_ip, PAGE_FAQ); 
init_userprefs($userdata); 
// 
// End session management 

// Load templates
//
$page_title = "Number of Posts";
$template->set_filenames(array( 
   'body' => 'postings_popup.tpl') 
); 

// Send vars to template
//
$template->assign_vars(array( 
	'PAGE_TITLE' => $page_title,
	'L_CLOSE_WINDOW' => "<a href='javascript:window.close();'>".$lang['Close_window']."</a>",
	'L_TOTAL_POSTS' => $lang['Total_posts'],
	'L_USER' => $lang['Poster'],
	'L_POSTS' => $lang['Posts'],
	'L_AUTHOR' => $lang['Author'],
	
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],
	'T_TR_COLOR1' => '#'.$theme['tr_color1'],
	'T_TR_COLOR3' => '#'.$theme['tr_color3'],
	'T_TH_COLOR2' => '#'.$theme['th_color2'],
	'T_TD_COLOR2' => '#'.$theme['td_color2'],
	'T_FONTFACE1' => $theme['fontface1'],
	'T_FONTSIZE1' => $theme['fontsize1'],
	'T_FONTSIZE2' => $theme['fontsize2'],
	'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],
	) 
); 

//
// Process the data
// Find who started the topic
$sql = "SELECT t.*
	FROM " . TOPICS_TABLE . " t
	WHERE t.topic_id = $topic_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$starter = $row['topic_poster'];

// Find the total number of posts
$sql = "SELECT p.*
	FROM " . POSTS_TABLE . " p
	WHERE p.topic_id = $topic_id
	ORDER BY p.poster_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}

$total_topics = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$topic_rowset[] = $row;
	$total_topics++;
}

// Find the number of posts for each user
for($i = 0; $i < $total_topics; $i++)
{
	$poster_id = $topic_rowset[$i]['poster_id'];
	if($poster_id != $poster_id2)
	{
		$flag = '&nbsp;&nbsp;&nbsp;';
		if($poster_id == $starter)
		{
			$flag = '*&nbsp;';
		}
		$sql = "SELECT p.topic_id, u.username
			FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u
			WHERE p.topic_id = $topic_id
			AND p.poster_id = $poster_id
			AND u.user_id = $poster_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			 message_die(GENERAL_ERROR, 'Could not obtain poster information', '', __LINE__, __FILE__, $sql);
		}

		$posts = $db->sql_numrows($result);
		$row = $db->sql_fetchrow($result);
		$poster = $flag.$row['username'];
		$poster_id2 = $poster_id;

		$template->assign_block_vars('topicrow', array(
			'POSTER' => $poster,
			'POSTS' => $posts)
		);

		$template->assign_vars(array( 
			'TOTAL_TOPICS' => $total_topics)
		);
	}
}

$template->pparse('body'); 

?> 