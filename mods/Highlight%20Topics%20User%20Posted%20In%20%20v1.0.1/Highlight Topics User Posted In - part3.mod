############################################################## 
## MOD Title: Highlight Topics User Posted In - PART3
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/
## Images Creator: Ptirhiik < admin@rpgnet-fr.com > (Pierre) http://rpgnet.clanmckeen.com 
## MOD Description: Will highlight topics in which the user has posted (PART3:add a picture)
## MOD Version: 1.0.1
## 
## Installation Level: Esay
## Installation Time: 1 Minute (less with the great EasyMOD! :-) 
## Files To Edit:	viewforum.php
##			search.php
##			templates/subSilver/search_results_topics.tpl
##			templates/subSilver/viewforum_body.tpl
##			templates/subSilver/subSilver.cfg
##			language/lang_english/lang_main.php
## Included Files: 	user_post.gif
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	YOU NEED TO INTALL PART1 BEFORE!!
##
##	PART3 : This one will add a little picture before topic title
##
############################################################## 
## MOD History: 
## 
##   2004-07-02 - Version 1.0.1 
##	- PART2: Fix: missed a  =  in subSilver.cfg !!
##	- Add PART# in MOD Title to work with EasyMOD 
##
##   2004-06-30 - Version 1.0.0 
##	- PART4: Replace <font> by <span> (MOD Validator)
##	- Submitted to the MOD-DB (no changes were made)
##
##   2004-06-26 - Version 0.2.1 
##	- Highlight is also done in search results (is displayed as topics)
##	- New picture for PART3, better with dark background (Thx beggers ;)
##
##   2004-06-25 - Version 0.2.0 
##	- Made 4 parts, and 3 different versions, so you can choose what you like the most
##	  (different topic's pictures, a new picture before the title, or a different title's color)
##
##   2004-06-24 - Version 0.1.0 
##	- Use new images made by Ptirhiik for his MOD: Last Topics From
##	- Fixed a bug, didn't work with Announcements
##
##   2004-06-23 - Version 0.0.1 
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ COPY ]----- 
# 
copy user_post.gif to templates/subSilver/images/user_post.gif
# 
#-----[ OPEN ]----- 
# 
viewforum.php
# 
#-----[ FIND ]----- 
# 
		$views = $topic_rowset[$i]['topic_views'];
# 
#-----[ AFTER, ADD ]----- 
# 
		
		$topic_highlight_userpost_img = ( ($topic_rowset[$i]['my_reply_id']) ? '<img src="' . $images['highlight_userpost'] . '" alt="' . $lang['You_posted_here'] . '" border="0">' : '' );
# 
#-----[ FIND ]----- 
# 
			'TOPIC_FOLDER_IMG' => $folder_image, 
# 
#-----[ AFTER, ADD ]----- 
# 
			'TOPIC_HIGHLIGHT_USERPOST_IMG' => $topic_highlight_userpost_img, 
# 
#-----[ OPEN ]----- 
# 
search.php
# 
#-----[ FIND ]----- 
# 
				$last_post_url = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $searchset[$i]['topic_last_post_id']) . '#' . $searchset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';
# 
#-----[ AFTER, ADD ]----- 
# 
		
				$topic_highlight_userpost_img = ( ($searchset[$i]['my_reply_id']) ? '<img src="' . $images['highlight_userpost'] . '" alt="' . $lang['You_posted_here'] . '" border="0">' : '' );
# 
#-----[ FIND ]----- 
# 
					'TOPIC_FOLDER_IMG' => $folder_image, 
# 
#-----[ AFTER, ADD ]----- 
# 
					'TOPIC_HIGHLIGHT_USERPOST_IMG' => $topic_highlight_userpost_img, 
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/search_results_topics.tpl
# 
#-----[ FIND ]----- 
# 
#Note: full line is longer
	<td class="row2"><span class="topictitle">{searchresults.NEWEST_POST_IMG}
# 
#-----[ IN-LINE FIND ]----- 
# 
{searchresults.TOPIC_TYPE}
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
{searchresults.TOPIC_HIGHLIGHT_USERPOST_IMG}
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/viewforum_body.tpl
# 
#-----[ FIND ]----- 
# 
#Note: full line is longer
	  <td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}
# 
#-----[ IN-LINE FIND ]----- 
# 
{topicrow.TOPIC_TYPE}
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
{topicrow.TOPIC_HIGHLIGHT_USERPOST_IMG}
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/subSilver.cfg
# 
#-----[ FIND ]----- 
# 
$images['folder_announce_new'] = "$current_template_images/folder_announce_new.gif";
# 
#-----[ AFTER, ADD ]----- 
# 

$images['highlight_userpost'] = "$current_template_images/user_post.gif";

# 
#-----[ OPEN ]----- 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]----- 
# 
$lang['Forum_is_locked'] = 'Forum is locked';
# 
#-----[ AFTER, ADD ]----- 
# 
$lang['You_posted_here'] = 'You have posted in this topic';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 