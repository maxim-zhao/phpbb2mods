<?php
/***************************************************************************
 *                           topicposters.php
 *                           -----------------------
 *	Author			:	Manipe - admin@manipef1.com - http://www.manipef1.com
 *	Created			:	Sunday, November 7, 2004
 *	Modified		:	Saturday, January 29, 2005
 *
 *	Version			:	1.1.0
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.php');
$gen_simple_header = TRUE;

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

$topic = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
$forum = intval($HTTP_GET_VARS[POST_FORUM_URL]);

$forum_id = $forum;

//
// Start auth check
//
if ($topic){
	$sql = "SELECT forum_id
		FROM " . TOPICS_TABLE . "
		WHERE topic_id = '$topic'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forum id of topic', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$forum_id =  $row['forum_id'];
	$db->sql_freeresult($result);
}

$is_auth = array();
$is_auth = auth(AUTH_VIEW, $forum_id, $userdata);

if( !$is_auth['auth_view'] )
{
	message_die(GENERAL_MESSAGE, $lang['Topic_post_not_exist']);
}
//
// End auth check
//

//
// Generate the page
//
$page_title = ($topic)?$lang['Topic_posters']:$lang['Forum_posters'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
    'body' => 'topicposters_body.tpl')
);

//
// Retreive the username, user id and the number of posts
//
$sql = "SELECT u.username, p.poster_id, COUNT(p.poster_id) AS posts
	FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u
	WHERE " . (($topic)?"topic_id = '$topic'":"forum_id = '$forum'") . "
		AND p.poster_id = u.user_id
	GROUP BY p.poster_id
	ORDER BY posts DESC, p.poster_id ASC";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain topic posters information', '', __LINE__, __FILE__, $sql);
}
$posters_row = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);


for ( $i = 0; $i < count($posters_row); $i++ )
{
	$profile_url = append_sid($phpbb_root_path . "profile." . $phpEx . "?mode=viewprofile&amp;u=" . $posters_row[$i]['poster_id']);
	$username = ($posters_row[$i]['poster_id'] == -1) ? $lang['Guest'] : '<a href="' . $profile_url . '" onclick="view_profile(\'' . $profile_url . '\'); return false;" class="gen">' . $posters_row[$i]['username'] . '</a>';
	$template->assign_block_vars('posters_row', array(
		'NUMBER' => ($i+1),
		'USER' => $username,
		'POSTS' => $posters_row[$i]['posts'] )
	);

}

if ($topic){
	//
	// Retreive the topic name
	//
	$sql = "SELECT topic_title
		FROM " . TOPICS_TABLE . "
		WHERE topic_id = '$topic'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain topic posters information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$name =  $row['topic_title'];
	$db->sql_freeresult($result);
}
else if ($forum){
	//
	// Retreive the forum name
	//
	$sql = "SELECT forum_name
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = '$forum'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forum posters information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$name = $row['forum_name'];
	$db->sql_freeresult($result);
}

$topic_url = ($topic)?append_sid($phpbb_root_path . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $topic):append_sid($phpbb_root_path . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum");
$open_topic = ($topic)?$lang['Topic_posters_open_topic']:$lang['Topic_posters_open_forum'];

$template->assign_vars(array( 
	'NAME' => $name,
	'U_TOPIC' => $topic_url,
	'L_USERS_WHO_POSTED' => $lang['Topic_posters_users_who_posted'],
	'L_OPEN_TOPIC' => $open_topic
	)
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.php');
?>