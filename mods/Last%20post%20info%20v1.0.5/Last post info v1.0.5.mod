############################################################## 
## MOD Title: Last post info
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/
## MOD Description: Add "Last post made by user on date/time" in who's online stats 
## MOD Version: 1.0.5
## 
## Installation Level: Easy
## Installation Time: 1 Minute 
## Files To Edit:	index.php
##			templates/subSilver/index_body.tpl
##			language/lang_english/lang_main.php
## Included Files:	n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
##	the Get Viewable Forums part was made by zparta on one of his MOD, so thanks man! ;)
############################################################## 
## MOD History: 
## 
##   2004-11-22 - Version 1.0.5
##	- Major speed improvements thanks to CADTutor, thanks again :)
##
##   2004-11-02 - Version 1.0.4 
##	- Got sid back in place ;) but still working with #post
##
##   2004-10-29 - Version 1.0.3 
##	- Removed getting $auth since it had already been done, should improve speed ;)
##	- Removed use of append_sid() to get #post working all the time
##
##   2004-09-03 - Version 1.0.2 
##	- Added post title, which is now the link
##	- Fix: now shows the name for guests when available (and if not then Anonymous)
##
##   2004-07-02 - Version 1.0.1 
##	- Fix: little bug if no post was made
##	- Fix: little bug if a guest (non-registered user) had made the last post
##
##   2004-06-30 - Version 1.0.0 
##	- Submitted to the MOD-DB (no changes were made)
##
##   2004-06-02 - Version 0.0.2 
##      - add link to the post (thanks CTCNetwork)
##
##   2004-06-02 - Version 0.0.1 
##      - first version
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]----- 
# 
index.php
# 
#-----[ FIND ]----- 
# 
	//
	// Start output of page
	//
# 
#-----[ BEFORE, ADD ]----- 
# 
	//BEGIN-MOD:Last post info
	// Get Viewable Forums - made by zparta 
	if ( function_exists('get_auth_keys') ) {
		$keys = array();
		$keys = get_auth_keys('Root');
		$auth_view_forum_sql = '';
		for ($i=0; $i < count($keys['id']); $i++)
		{
			if ($tree['type'][ $keys['idx'][$i] ] == POST_FORUM_URL)
			{
				$auth_view_forum_sql .= (($auth_view_forum_sql != '') ? ', ' : '') . $tree['id'][ $keys['idx'][$i] ];
			}
		}
		$auth_view_forum_sql = ($auth_view_forum_sql == '' ? '(0)' : '(' . $auth_view_forum_sql . ')'); 
	}
	else
	{
		$auth_view_forum_sql = ''; 
		for($i = 0; $i < $total_categories; $i++) 
		{ 
			$cat_id = $category_rows[$i]['cat_id']; 
			$display_forums = false;
			for($j = 0; $j < $total_forums; $j++)
			{
				if ( $is_auth_ary[$forum_data[$j]['forum_id']]['auth_view'] && $forum_data[$j]['cat_id'] == $cat_id ) 
				{ 
					$display_forums = true; 
					$auth_view_forum_sql .= ($auth_view_forum_sql == '' ? '' : ', ' ) . $forum_data[$j]['forum_id']; 
				} 
			} 
		} 
		$auth_view_forum_sql = ($auth_view_forum_sql == '' ? '(0)' : '(' . $auth_view_forum_sql . ')'); 
	}
	$sql = "SELECT p.post_id, p.post_username, pt.post_subject, p.post_time, u.user_id, u.username, t.topic_title
		FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt, " . TOPICS_TABLE . " t
		WHERE p.forum_id IN " . $auth_view_forum_sql . " AND p.poster_id = u.user_id
		AND pt.post_id = p.post_id AND t.topic_id = p.topic_id
		ORDER BY p.post_time DESC LIMIT 1"; 

	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Could not query last post informations', '', __LINE__, __FILE__, $sql); 
	} 

	if ($row = $db->sql_fetchrowset($result)) 
	{ 
		$db->sql_freeresult($result);
		$append_sid = ( !empty($SID) && !preg_match('#sid=#', $url) ) ? $SID . '&' : '';
		if ($row[0]['user_id']>-1)
		{
			$last_post_info = sprintf($lang['last_post_info'], '<a href="profile.'.$phpEx.'?'.$append_sid.'mode=viewprofile&' . POST_USERS_URL . '=' . $row[0]['user_id'] . '">', $row[0]['username'], '</a>', create_date($board_config['default_dateformat'], $row[0]['post_time'], $board_config['board_timezone']), '<a href="viewtopic.'.$phpEx.'?'.$append_sid. POST_POST_URL . '=' . $row[0]['post_id'] . '#' . $row[0]['post_id'] . '">', ( (empty($row[0]['post_subject'])) ? 'Re: ' . $row[0]['topic_title'] : $row[0]['post_subject'] ), '</a>');
		}
		else
		{
			$last_post_info = sprintf($lang['last_post_info'], '', ( (empty($row[0]['post_username'])) ? $row[0]['username'] : $row[0]['post_username'] ), '', create_date($board_config['default_dateformat'], $row[0]['post_time'], $board_config['board_timezone']), '<a href="viewtopic.'.$phpEx.'?'.$append_sid . POST_POST_URL . '=' . $row[0]['post_id'] . '#' . $row[0]['post_id'] . '">', ( (empty($row[0]['post_subject'])) ? 'Re: ' . $row[0]['topic_title'] : $row[0]['post_subject'] ), '</a>');
		}
	} 
	else
	{
		$last_post_info = '';
	}
	
	//END-MOD:Last post info

# 
#-----[ FIND ]----- 
# 
	$template->assign_vars(array(
		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),
		'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
# 
#-----[ BEFORE, ADD ]----- 
# 
	//MODIF-MOD:Last post info, add: LAST_POST
# 
#-----[ FIND ]----- 
#
		'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'), 
# 
#-----[ AFTER, ADD ]----- 
# 
		'LAST_POST' => $last_post_info, 
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/index_body.tpl
# 
#-----[ FIND ]----- 
# 
	<td class="row1" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>
# 
#-----[ IN-LINE FIND ]----- 
# 
	{TOTAL_POSTS}
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
, {LAST_POST}
# 
#-----[ OPEN ]----- 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]----- 
# 
$lang['Newest_user'] = 'The newest registered user is <b>%s%s%s</b>'; // a href, username, /a 
# 
#-----[ AFTER, ADD ]----- 
# 
$lang['last_post_info'] = 'Last post by <b>%s%s%s</b> on %s: %s%s%s'; // a href, usernname, /a, post_time, a href, subject/title, /a
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 