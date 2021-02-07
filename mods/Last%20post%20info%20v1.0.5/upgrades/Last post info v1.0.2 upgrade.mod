############################################################## 
## MOD Title: Last post info - upgrade from 1.0.2
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/
## MOD Description: Add "Last post made by user on date/time" in who's online stats 
## MOD Version: 1.0.5
## 
## Installation Level: Easy
## Installation Time: 1 Minute 
## Files To Edit:	index.php
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
		$is_auth_ary = array(); 
		$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forum_data); 
		$auth_view_forum_sql = ''; 
# 
#-----[ REPLACE WITH ]----- 
# 
		$auth_view_forum_sql = ''; 
# 
#-----[ FIND ]----- 
#
	$sql = "SELECT p.post_id, p.post_username, pt.post_subject, p.post_time, u.user_id, u.username, t.topic_title
		FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt, " . TOPICS_TABLE . " t
		WHERE p.forum_id IN " . $auth_view_forum_sql . " AND p.poster_id = u.user_id
		AND pt.post_id = p.post_id AND t.topic_id = p.topic_id
		ORDER BY p.post_time DESC LIMIT 1"; 
# 
#-----[ REPLACE WITH ]----- 
# 
	$sql = "SELECT p.post_id, p.post_username, pt.post_subject, p.post_time, u.user_id, u.username, t.topic_title
		FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt, " . TOPICS_TABLE . " t
		WHERE p.forum_id IN " . $auth_view_forum_sql . " AND p.poster_id = u.user_id
		AND pt.post_id = p.post_id AND t.topic_id = p.topic_id
		ORDER BY p.post_time DESC LIMIT 1"; 
# 
#-----[ FIND ]----- 
# 
		if ($row[0]['user_id']>-1)
		{
			$last_post_info = sprintf($lang['last_post_info'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row[0]['user_id']) . '">', $row[0]['username'], '</a>', create_date($board_config['default_dateformat'], $row[0]['post_time'], $board_config['board_timezone']), '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $row[0]['post_id'] . '#' . $row[0]['post_id']) . '">', ( (empty($row[0]['post_subject'])) ? 'Re: ' . $row[0]['topic_title'] : $row[0]['post_subject'] ), '</a>');
		}
		else
		{
			$last_post_info = sprintf($lang['last_post_info'], '', ( (empty($row[0]['post_username'])) ? $row[0]['username'] : $row[0]['post_username'] ), '', create_date($board_config['default_dateformat'], $row[0]['post_time'], $board_config['board_timezone']), '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $row[0]['post_id'] . '#' . $row[0]['post_id']) . '">', ( (empty($row[0]['post_subject'])) ? 'Re: ' . $row[0]['topic_title'] : $row[0]['post_subject'] ), '</a>');
		}
# 
#-----[ REPLACE WITH ]----- 
# 
		$append_sid = ( !empty($SID) && !preg_match('#sid=#', $url) ) ? $SID . '&' : '';
		if ($row[0]['user_id']>-1)
		{
			$last_post_info = sprintf($lang['last_post_info'], '<a href="profile.'.$phpEx.'?'.$append_sid.'mode=viewprofile&' . POST_USERS_URL . '=' . $row[0]['user_id'] . '">', $row[0]['username'], '</a>', create_date($board_config['default_dateformat'], $row[0]['post_time'], $board_config['board_timezone']), '<a href="viewtopic.'.$phpEx.'?'.$append_sid. POST_POST_URL . '=' . $row[0]['post_id'] . '#' . $row[0]['post_id'] . '">', ( (empty($row[0]['post_subject'])) ? 'Re: ' . $row[0]['topic_title'] : $row[0]['post_subject'] ), '</a>');
		}
		else
		{
			$last_post_info = sprintf($lang['last_post_info'], '', ( (empty($row[0]['post_username'])) ? $row[0]['username'] : $row[0]['post_username'] ), '', create_date($board_config['default_dateformat'], $row[0]['post_time'], $board_config['board_timezone']), '<a href="viewtopic.'.$phpEx.'?'.$append_sid . POST_POST_URL . '=' . $row[0]['post_id'] . '#' . $row[0]['post_id'] . '">', ( (empty($row[0]['post_subject'])) ? 'Re: ' . $row[0]['topic_title'] : $row[0]['post_subject'] ), '</a>');
		}
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 