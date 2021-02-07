##############################################################
## MOD Title: 		Pro Forum Stats MOD
## MOD Author: 		Nt3N < nt3n@fifaonline.it > (Nt3N) n/a
## MOD Description: 	This mod allows you to view more detailed stats on your forum index
##				Stats featured by this mod:
##				- Total posts
##				- Total topics
##				- Posts per user
##				- Posts per day
##				- Topics per day
##				- Users per day
##				The MOD will display all these values in just ONE line, like the next one:
##				"Total posts: X | Total topics: X | Posts per user: X | Posts per day: X | Topics per day: X | Users per day: X"
## MOD Version: 	1.0.0
## Compatibility: 2.0.8 (previous releases have not been tested)
##
## Installation Level: 	Easy
## Installation Time: 	2-3 Minutes
##
## Files To Edit (3): 	index.php
##				language/lang_english/lang_main.php
##                	templates/subSilver/index_body.tpl
##
## Included Files (0):
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
##
##	Tnx for downloading this MOD which is my first! 
##    I hope you like it! If u have any trouble while
##    installing this MOD, feel free to contact by email!
##	
##	Nj0y :D - questions, suggestions, etc to nt3n@fifaonline.it
##
##    FORZA JUVENTUS SEMPRE E COMUNQUE!
##
############################################################## 
## MOD History: 
##
##  2004-08-18 - Version 1.0.0
##      - First (bug-free) release!
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

//
// If you don't use these stats on your index you may want to consider
// removing them
//

#
#-----[ AFTER, ADD ]------------------------------------------
#

$total_topics = get_db_stat('topiccount');

#
#-----[ FIND ]------------------------------------------
#

	$template->set_filenames(array(
		'body' => 'index_body.tpl')
	);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	$boarddays = ( time() - $board_config['board_startdate'] ) / 86400;
	$posts_per_day = sprintf("%.2f", $total_posts / $boarddays);
	$topics_per_day = sprintf("%.2f", $total_topics / $boarddays);
	$users_per_day = sprintf("%.2f", $total_users / $boarddays);
	$posts_per_user = sprintf("%.2f", $total_posts / $total_users);


	if($posts_per_day > $total_posts)
	{
		$posts_per_day = $total_posts;
	}

	if($topics_per_day > $total_topics)
	{
		$topics_per_day = $total_topics;
	}

	if($users_per_day > $total_users)
	{
		$users_per_day = $total_users;
	}

	if($posts_per_user > $total_posts)
	{
		$posts_per_user = $total_posts;
	}

#
#-----[ FIND ]------------------------------------------
#
# You have 2 instances of this: find the SECOND one from the top
#

	$template->assign_vars(array(

#
#-----[ AFTER, ADD ]------------------------------------------
#

		"POSTS_PER_DAY" => $posts_per_day,
		"POSTS_PER_USER" => $posts_per_user,
		"TOPICS_PER_DAY" => $topics_per_day,
		"USERS_PER_DAY" => $users_per_day,
		"TOTAL_TOPICCOUNT" => $total_topics,
		"L_TOTAL_TOPICCOUNT" => $lang['total_topiccount'],
		"L_POSTS_PER_DAY" => $lang['Posts_per_day'],
		"L_TOPICS_PER_DAY" => $lang['Topics_per_day'],
		"L_USERS_PER_DAY" => $lang['Users_per_day'],
		"L_POSTS_PER_USER" => $lang['Posts_per_user'],

#
#-----[ OPEN ]------------------------------------------ 
#

templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------ 
#

	<td class="row1" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>

#
#-----[ REPLACE WITH ]------------------------------------------ 
#

	<td class="row1" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS} | {L_TOTAL_TOPICCOUNT} <b>{TOTAL_TOPICCOUNT}</b> | {L_POSTS_PER_USER}<b>{POSTS_PER_USER}</b> | {L_POSTS_PER_DAY}<b>{POSTS_PER_DAY}</b> | {L_TOPICS_PER_DAY}<b>{TOPICS_PER_DAY}</b> | {L_USERS_PER_DAY}<b>{USERS_PER_DAY}</b><br />{TOTAL_USERS}<br />{NEWEST_USER}</span>

#
#-----[ OPEN ]------------------------------------------ 
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------ 
#

$lang['Posted_articles_zero_total'] = 'Our users have posted a total of <b>0</b> articles'; // Number of posts
$lang['Posted_articles_total'] = 'Our users have posted a total of <b>%d</b> articles'; // Number of posts
$lang['Posted_article_total'] = 'Our users have posted a total of <b>%d</b> article'; // Number of posts

#
#-----[ REPLACE WITH ]------------------------------------------ 
#

$lang['Posted_articles_zero_total'] = 'Total posts: <b>0</b>'; // Number of posts
$lang['Posted_articles_total'] = 'Total posts: <b>%d</b>'; // Number of posts
$lang['Posted_article_total'] = 'Total posts: <b>%d</b>'; // Number of posts
$lang['Posts_per_user'] = 'Posts per user: ';
$lang['Posts_per_day'] = 'Posts per day: ';
$lang['Topics_per_day'] = 'Topics per day: ';
$lang['Users_per_day'] = 'Users per day: ';
$lang['total_topiccount'] = 'Total topics: ';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM