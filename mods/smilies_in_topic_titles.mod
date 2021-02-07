############################################################## 
## MOD Title: Smilies in Topic Titles 
## MOD Author: Suisse < chatwithbea@bluewin.ch > (Florian Segginger) http://www.techno-revelation.com
## MOD Description: Shows smilies in topic titles 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit: viewforum.php, viewtopic.php 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	If you want to disable certain smilies because they are too big or just plain ugly,
##	you have to put
##	$topic_title = str_replace("code for smiley","",$$topic_title);
##	just before
##	$topic_title = smilies_pass($topic_title);	
##	In viewforum.php
##	You obviously have to change 'code for smiley' with the actual bbcode of the smiley
##	Example:
##		$topic_title = str_replace(":)","",$topic_title);
############################################################## 
## MOD History: 
## 
##   2004-04-4 - Version 1.0.0 
##      - This is the first release
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
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------
#
//Parse smilies to display topic title
$topic_title = smilies_pass($topic_title);

#
#-----[ OPEN ]------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'common.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------
#
//Request the bbcode parsing php page, so we don't call an undefined function ;)
include($phpbb_root_path . 'includes/bbcode.' .$phpEx);

#
#-----[ FIND ]------------------------------------------
#
$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];

#
#-----[ AFTER, ADD ]------------------------------------
#
//Parse smilies to show the title
//This is where you would put the code to disable certain smilies
$topic_title = smilies_pass($topic_title);

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 