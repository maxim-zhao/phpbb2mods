############################################################## 
## MOD Title: Post search in viewtopic
## MOD Author: Cherokee Red < cherokeered@blueyonder.co.uk > (Kenny Cameron) http://cherokeered.mrikasu.com/forums/
## MOD Description: Makes the members postcount inside a topic, a link to a search of all the posts they have made.
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~1 Minute
## Files To Edit: viewtopic.php
## 		  templates/subSilver/viewtopic_body.tpl
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
## 
## Basically does the same as my Post search in memberlist MOD, but inside the topic :)
## 
############################################################## 
## MOD History: 
## 
##   2004-12-28 - Version 1.0.0 
##      - mod created
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------ 
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------ 
#

		'U_POST_ID' => $postrow[$i]['post_id'])
#
#-----[ BEFORE, ADD ]------------------------------------------ 
#

		'U_SEARCH_USER_POSTS' => append_sid("search.$phpEx?search_author=" . urlencode($postrow[$i]['username']) . "&amp;showresults=posts"),
#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/viewtopic_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
<br />{postrow.POSTER_POSTS}<br />
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
{postrow.POSTER_POSTS} 
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
<a href="{postrow.U_SEARCH_USER_POSTS}" class="genmed">{postrow.POSTER_POSTS}</a>

#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM