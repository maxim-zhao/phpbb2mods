############################################################## 
## MOD Title: Mouse Hover Last Post
## MOD Author: dESiLVer < desilverx@gmail.com > (Kemal Guner) http://www.techsilver.gen.tr
## MOD Description: Last post on mouse hover preview.
## MOD Version: 1.0.1 
## 
## Installation Level: (Easy) 
## Installation Time: 3 Minutes 
## Files To Edit: viewforum.php 
##		  templates/subSilver/viewforum_body.tpl
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: My second mod :)
## 
############################################################## 
## MOD History: 
## 
##   2005-07-04 - Version 1.0.1
##      - Fixed some bugs
## 
##   2005-07-01 - Version 1.0.0
##      - First release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------ 
# 
viewforum.php
# 
#-----[ FIND ]----------------------------------- 
# 

      $row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
      $row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

# 
#-----[ AFTER, ADD ]------------------------------------------- 
#

		$sql = "SELECT post_text FROM " . POSTS_TEXT_TABLE . " WHERE post_id=" . $topic_rowset[$i]['topic_last_post_id']; 
        
		$result = $db->sql_query($sql);
        	$row = $db->sql_fetchrow($result); 
	      	$db->sql_freeresult($result); 
      	
		$last_post = $row['post_text']; 
      		$char_limit = '775';
		if (strlen($last_post) > $char_limit)
		{
		$last_post=substr($last_post, 0, $char_limit) . "....";
		} 
      	
		$last_post = preg_replace("/\[.+\]/iU",'',$last_post); 
		$last_post = str_replace(array('"', '\''), array('&quote;', '\\\''), $last_post);

# 
# 
#-----[ FIND ]----------------------------------- 
# 

			'LAST_POST_TIME' => $last_post_time, 

# 
#-----[ AFTER, ADD ]------------------------------------------- 
# 

			'LAST_POST_RESULT' => $last_post,

# 
#-----[ OPEN ]------------------------------ 
# 
templates/subSilver/viewforum_body.tpl
# 
#-----[ FIND ]----------------------------------- 
# 

	  <td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />

# 
# 
#-----[ IN-LINE FIND ]----------------------------------- 
# 

 class="topictitle">{topicrow.TOPIC_TITLE}

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------- 
# 

 title="{topicrow.LAST_POST_RESULT}"

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
