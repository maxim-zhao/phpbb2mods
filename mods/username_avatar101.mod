############################################################## 
## MOD Title: Username Avatar 
## MOD Author: Angelus < angelus@ravenhearte.org > (Jesse) http://www.ravenhearte.org 
## MOD Description: 
##   Makes it so that when you mouse over a user's avatar it 
##   displays that users name, it's that simple. 
## 
## MOD Version: 1.0.1 
## 
## Installation Level: (Easy) 
## Installation Time: 2 Minutes 
## Files To Edit: - viewtopic.php 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##              Simple, but nice. 
## 
############################################################## 
## MOD History: 
## 
##   2003-09-17 - Version 1.0.0 
##         - First Release 
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
   $poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : ''; 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
   $poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt=" 
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
   ' . $postrow[$i]['username'] . '" title="' . $postrow[$i]['username'] . ' 
# 
#-----[ FIND ]------------------------------------------ 
# 
   $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : ''; 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
   $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt=" 
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
   ' . $postrow[$i]['username'] . '" title="' . $postrow[$i]['username'] . ' 
# 
#-----[ FIND ]------------------------------------------ 
# 
   $poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : ''; 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
   $poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt=" 
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
   ' . $postrow[$i]['username'] . '" title="' . $postrow[$i]['username'] . ' 
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 