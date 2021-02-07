############################################################## 
## MOD Title: View new topics since last visit 
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/
## MOD Description: Pretty much as last posts since last visit, but only with new topics! ;) 
## MOD Version: 1.0.2
## 
## Installation Level: Easy 
## Installation Time: 1 Minute 
## Files To Edit:	search.php 
##			include/page_header.php 
##			language/lang_english/lang_main.php 
##			templates/subSilver/index_body.tpl 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##   I'm new to phpBB, so I'd like to thanks & send all my 
## congratulations to all of you who did an amazing great job!! 
## 
##   this is my first MOD, hope it's usefull to some of you ;) 
## 
############################################################## 
## MOD History: 
## 
##   2004-09-01 - Version 1.0.2
##	- Some minor changes to the MOD
##
##   2004-07-02 - Version 1.0.1
##	- Some little corrections to the MOD
##
##   2004-06-30 - Version 1.0.0 
##	- Submitted to the MOD-DB (no changes were made)
##
##   2004-05-31 - Version 0.0.1 
##      - Original version 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]----- 
# 
search.php 
# 
#-----[ FIND ]----- 
# 
#Note: full line is longer
	if ( $search_id == 'newposts' || $search_id == 'egosearch'
# 
#-----[ IN-LINE FIND ]----- 
# 
)
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
|| $search_id == 'newtopics'
# 
#-----[ FIND ]----- 
# 
		if ( $search_id == 'newposts' || $search_id == 'egosearch'
# 
#-----[ IN-LINE FIND ]----- 
# 
( $search_author !=
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
$search_id == 'newtopics' ||
# 
#-----[ FIND ]----- 
# 
			else if ( $search_id == 'egosearch' )
# 
#-----[ BEFORE, ADD ]----- 
# 
			else if ( $search_id == 'newtopics' )
			{
				if ( $userdata['session_logged_in'] )
				{
					$sql = "SELECT p.post_id
						FROM " . POSTS_TABLE . " p, " . TOPICS_TABLE . " t
						WHERE p.post_id = t.topic_first_post_id AND
						t.topic_time >= " . $userdata['user_lastvisit'];
				}
				else
				{
					redirect(append_sid("login.$phpEx?redirect=search.$phpEx&search_id=newtopics", true));
				}

				$show_results = 'topics';
				$sort_by = 0;
				$sort_dir = 'DESC';
			} 
# 
#-----[ OPEN ]----- 
# 
includes/page_header.php 
# 
#-----[ FIND ]----- 
# 
	'L_SEARCH_NEW' => $lang['Search_new'],
# 
#-----[ AFTER, ADD ]----- 
# 
	'L_SEARCH_NEW_TOPICS' => $lang['Search_new_topics'],
# 
#-----[ FIND ]----- 
# 
	'U_SEARCH_NEW' => append_sid('search.'.$phpEx.'?search_id=newposts'),
# 
#-----[ AFTER, ADD ]----- 
# 
	'U_SEARCH_NEW_TOPICS' => append_sid('search.'.$phpEx.'?search_id=newtopics'),
# 
#-----[ OPEN ]----- 
# 
language/lang_english/lang_main.php 
# 
#-----[ FIND ]----- 
# 
$lang['Search_new'] = 'View posts since last visit'; 
# 
#-----[ AFTER, ADD ]----- 
# 
$lang['Search_new_topics'] = 'View topics since last visit'; 
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/index_body.tpl 
# 
#-----[ FIND ]----- 
# 
#Note: full line longer
		<a href="{U_SEARCH_NEW}"
# 
#-----[ IN-LINE FIND ]----- 
# 
<a href="{U_SEARCH_NEW}"
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
<a href="{U_SEARCH_NEW_TOPICS}" class="gensmall">{L_SEARCH_NEW_TOPICS}</a><br />
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM