##############################################################
## MOD Title: Display Number Of Private Messages
## MOD Author: battye < cricketmx@hotmail.com > (battye) http://forums.cricketmx.com
## MOD Description: This MOD allows the user to see in clear figures how many PM's he has used of his PM quota.
##							For example, if the maximum number of PM's he can store in his inbox is 50, and he has 10,
##							this MOD would display the following, directly below the percentage: (5 / 50)  
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 3 Minutes
##
## Files To Edit (3): 		privmsg.php 
##                           	language/lang_english/lang_main.php
##
## Included Files (0): 	(N/A)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: Enjoy the MOD :-)
##############################################################
## MOD History:  2005-05-11 - Version 1.0.0
##      - First Release, pretty cool, just enjoy the MOD ;-)
## 					  2005-05-16 - Version 1.0.1
##      - Fixed tabbing in install.txt, path, and changed <br> to <br />
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
# 
#-----[ FIND ]------------------------------------------ 
#
$inbox_limit_remain = ( $board_config['max_' . $folder . '_privmsgs'] > 0 ) ? $board_config['max_' . $folder . '_privmsgs'] - $pm_all_total : 0;
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$count_messages = "(" . $pm_all_total . " / " . $board_config['max_' . $folder . '_privmsgs'] . ")"; // Messages In Inbox by battye
# 
#-----[ FIND ]------------------------------------------ 
#
$l_box_size_status = sprintf($lang['Inbox_size'], $inbox_limit_pct);
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
$inbox_limit_pct
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, $count_messages
# 
#-----[ FIND ]------------------------------------------ 
#
$l_box_size_status = sprintf($lang['Sentbox_size'], $inbox_limit_pct);
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
$inbox_limit_pct
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, $count_messages
# 
#-----[ FIND ]------------------------------------------ 
#
$l_box_size_status = sprintf($lang['Savebox_size'], $inbox_limit_pct);
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
$inbox_limit_pct
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, $count_messages
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Inbox_size'] = 'Your Inbox is %d%% full'; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = 'Your Sentbox is %d%% full'; 
$lang['Savebox_size'] = 'Your Savebox is %d%% full'; 
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
$lang['Inbox_size'] = 'Your Inbox is %d%% full <br />%s'; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = 'Your Sentbox is %d%% full <br />%s'; 
$lang['Savebox_size'] = 'Your Savebox is %d%% full <br />%s'; 
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 