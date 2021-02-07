############################################################## 
## MOD Title: Percentage Post Fix
## MOD Author: kp3011 < asv83.lr4087@gmail.com > ( Jisp Cheung ) http://269m.no-ip.org/ 
## MOD Description: It fixes the error of [X% of total] in viewprofile.php, which calculates
##		    the percentage of posts of a member of the PRESENT number of posts, but
##		    not the total number of posts of all members. Before this fix is done,
##		    problems like [101% of total] may occur, because of forum prune.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: includes/functions 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##   Nil
############################################################## 
## MOD History: 
## 
##   2005-06-19 - Version 1.0.0 
##      - Initial Release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions.php
# 
#-----[ FIND ]------------------------------------------ 
# 
		case 'postcount':
		case 'topiccount':
			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
			break;
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
		case 'postcount':
			$sql = "SELECT SUM(" . USERS_TABLE . ".user_posts) AS post_total FROM " . USERS_TABLE;
			break;

		case 'topiccount':
			$sql = "SELECT SUM(" . FORUMS_TABLE . ".forum_topics) AS topic_total FROM " . FORUMS_TABLE;
			break;
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 