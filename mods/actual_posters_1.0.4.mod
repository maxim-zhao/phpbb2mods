############################################################## 
## MOD Title: actual posters
## MOD Author: Swizec < swizec@randy-comic.com > (N/A) http://www.randy-comic.com
## MOD Description: Shows the number of active users in the board statistics
## MOD Version: 1.0.4
## 
## Installation Level: Easy
## Installation Time: ~5 Minutes 
## Files To Edit: index.php, functions.php, index_body.tpl, lang_main.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##
## demo board: http://www.randy-comic.com/demo
## 
############################################################## 
## MOD History: 
## 
## 
##   2005-03-02 - Version 1.0.0 
##      - working mod
##
##   2005-04-22 - Version 1.0.1 
##      - spelling correction
##
##   2005-04-25 - Version 1.0.2 
##      - small cosmetic fix
##
##   2005-05-12 - Version 1.0.2 
##	- submission problems :S
##
##   2005-05-12 - Version 1.0.3
##	- made it multi template compatible
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

index.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$newest_userdata = get_db_stat('newestuser');

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod actual posters add
$total_posters = get_db_stat('total_posters');

# 
#-----[ FIND ]------------------------------------------ 
# 

'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'), 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod actual posters add
'TOTAL_POSTERS' => sprintf( $lang['total_posters'], $total_posters ),

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions.php

# 
#-----[ FIND ]------------------------------------------ 
# 

case 'topiccount':
	$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
		FROM " . FORUMS_TABLE;
	break;
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod actual posters add
case 'total_posters':
	$sql = "SELECT COUNT(user_id) AS posters
		FROM " . USERS_TABLE . "
		WHERE user_id <> " . ANONYMOUS . " AND user_posts > 0";
	break;

# 
#-----[ FIND ]------------------------------------------ 
# 

case 'topiccount':
	return $row['topic_total'];
	break;
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod actual posters add
case 'total_posters':
	return $row['posters'];
	break;
	
# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/index_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

{TOTAL_USERS}

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

{TOTAL_USERS}

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

&nbsp;{TOTAL_POSTERS}

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// That's all, Folks!
// -------------------------------------------------

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod actual psoters add
$lang['total_posters'] = 'of whom <b>%d</b> actually posted.';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 