############################################################## 
## MOD Title: Highlight Topics User Posted In - PART1
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/
## Images Creator: Ptirhiik < admin@rpgnet-fr.com > (Pierre) http://rpgnet.clanmckeen.com 
## MOD Description: Will highlight topics in which the user has posted (PART1:REQUIRED)
## MOD Version: 1.0.1
## 
## Installation Level: Intermediate
## Installation Time: 3 Minutes (1 with the great EasyMOD! :-) 
## Files To Edit:	viewforum.php
##			search.php
## Included Files: 	n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	This MOD will allow you to make topics in which the user has posted be noticed.
##	I've made different versions of it so you can choose the one you like the most ;-)
##
##	Note that it will highlight topics in which the user post, this means either if he did
##	reply or started the topic! If you only want topics where he REPLIED (can be his own of
##	coure ;-) to be highlighted, there' an alternative query in PART1 - jut don't forget to
##	use the same one both times!! (one for announcements, one for other posts)
##
##	PART1 : This part is REQUIRED no matter what, it's the part to know if he's posted in the
##		topic or not!
##
##	Once you've installed PART1, you can what you want:
##
##	PART2 : This one will use different pictures for topics ; this means you'll need to have
##	new images for every case: topic, topic w/new posts, hot, hot w/new, sticky, sticky w/new, etc)
##
##		** IMPORTANT **
##	This PART2 uses pictures made by Ptirhiik for his MOD: Last Topics From
##	IF YOU HAVE THIS MOD INSTALLED, DO NOT INSTALL THIS ONE FULLY!!!
##	Since I used the same names, if you've Ptirhiik's MOD installed you don't have to
##	 A) copy the pictures files, you already have them
##	 B) make any changes in subSilver.cfg, it's already been done!
##
##
##	PART3 : This one will add a little picture before topic title
##
##
##	PART4 : This one will change color of the topic title (color defined in ACP/Styles/Edit)
##		>> This one needs SQL CHANGES !! (and you'll have to define the color to use! ;-)
##
##
##	I don't think there's any bug, but let me know if you find any! ;)
##	Thanks to safeTsurfa for giving me the cool pictures made by Ptirhiik
##	Thanks to Ptirhiik of course! (hope you don't mind)
##	Thanks to gec for poiting out that it didn't work with Announcements ;)
##	Thanks to Tel for the picture used in PART3 
##	Thanks to beggers for his new version of the picture for dark backgrounds too
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
#-----[ OPEN ]----- 
# 
viewforum.php
# 
#-----[ FIND ]----- 
# 
// All announcement data, this keeps announcements
#
#-----[ FIND ]----- 
# 
#Note: full line is longer
$sql = "SELECT t.*, u.username, u.user_id
#
#-----[ IN-LINE FIND ]----- 
# 
p.post_username
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
, p3.poster_id AS my_reply_id
# 
#-----[ FIND ]----- 
# 
#Note: full line is longer
	FROM "
# 
#-----[ IN-LINE FIND ]----- 
# 
	"
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
(
# 
#-----[ FIND ]----- 
# 
	WHERE t.forum_id = $forum_id
# 
#-----[ BEFORE, ADD ]----- 
# 
#Note: will highlight topics with post from user, aka a reply or if the user starts the topic
# To show only topics where user post a REPLY use this instead:
#	LEFT JOIN " . POSTS_TABLE . " p3 ON p3.topic_id = t.topic_id AND p3.post_id != t.topic_first_post_id AND p3.poster_id = " . $userdata['user_id'] . ")
	LEFT JOIN " . POSTS_TABLE . " p3 ON p3.topic_id = t.topic_id AND p3.poster_id = " . $userdata['user_id'] . ")
# 
#-----[ FIND ]----- 
# 
	ORDER BY t.topic_last_post_id DESC ";
# 
#-----[ BEFORE, ADD ]----- 
# 
	GROUP BY p.post_id
# 
#-----[ FIND ]----- 
# 
// Grab all the basic data (all topics except announcements)
#
#-----[ FIND ]----- 
# 
#Note: full line is longer
$sql = "SELECT t.*, u.username, u.user_id
#
#-----[ IN-LINE FIND ]----- 
# 
p2.post_time
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
, p3.poster_id AS my_reply_id
# 
#-----[ FIND ]----- 
# 
#Note: full line is longer
	FROM "
# 
#-----[ IN-LINE FIND ]----- 
# 
	"
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
(
# 
#-----[ FIND ]----- 
# 
	WHERE t.forum_id = $forum_id
# 
#-----[ BEFORE, ADD ]----- 
# 
#Note: will highlight topics with post from user, aka a reply or if the user starts the topic
# To show only topics where user post a REPLY use this instead:
#	LEFT JOIN " . POSTS_TABLE . " p3 ON p3.topic_id = t.topic_id AND p3.post_id != t.topic_first_post_id AND p3.poster_id = " . $userdata['user_id'] . ")
	LEFT JOIN " . POSTS_TABLE . " p3 ON p3.topic_id = t.topic_id AND p3.poster_id = " . $userdata['user_id'] . ")
# 
#-----[ FIND ]----- 
# 
	ORDER BY t.topic_type DESC, t.topic_last_post_id DESC 
# 
#-----[ BEFORE, ADD ]----- 
# 
	GROUP BY p.post_id
# 
#-----[ OPEN ]----- 
# 
search.php
# 
#-----[ FIND ]----- 
# 
	// Look up data ...
# 
#-----[ FIND ]----- 
# 
		}
		else
		{
#
#-----[ FIND ]----- 
# 
#Note: full line is longer
			$sql = "SELECT t.*, f.forum_id
#
#-----[ IN-LINE FIND ]----- 
# 
p2.post_time
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
, p3.poster_id AS my_reply_id
# 
#-----[ FIND ]----- 
# 
#Note: full line is longer
	FROM "
# 
#-----[ IN-LINE FIND ]----- 
# 
	"
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
(
# 
#-----[ FIND ]----- 
# 
				WHERE t.topic_id IN ($search_results) 
# 
#-----[ BEFORE, ADD ]----- 
# 
#Note: will highlight topics with post from user, aka a reply or if the user starts the topic
# To show only topics where user post a REPLY use this instead:
#	LEFT JOIN " . POSTS_TABLE . " p3 ON p3.topic_id = t.topic_id AND p3.post_id != t.topic_first_post_id AND p3.poster_id = " . $userdata['user_id'] . ")
	LEFT JOIN " . POSTS_TABLE . " p3 ON p3.topic_id = t.topic_id AND p3.poster_id = " . $userdata['user_id'] . ")
# 
#-----[ FIND ]----- 
# 
					AND u2.user_id = p2.poster_id";
# 
#-----[ IN-LINE FIND ]----- 
# 
"
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
 GROUP BY p2.post_id
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 