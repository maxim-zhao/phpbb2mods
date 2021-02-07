##############################################################
## MOD Title: 		Average Posts Per User
## MOD Author: 		battye < cricketmx@hotmail.com > (battye) http://www.cricketmx.com
## MOD Description: 	A simple MOD that tells you the average posts per user on the index page.
## MOD Version: 	1.0.0
##
## Installation Level: 	Easy
## Installation Time: 	5 Minutes
##
## Files To Edit (3): 	index.php
##			language/lang_english/lang_main.php
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
##   Thanks for downloading this MOD (my first :P), I hope you like it!
##   If you find any bugs, please post them in the thread at phpBB or at my forum.
##
##   I would especially like to thank Black Fluffy Lion who helped me out a lot in making this MOD!!
##   And thanks to my friend Dan who also helped me out!
##
##   Installation:
##
##	1) Edit the files
##	2) Upload files to respective locations
##	3) Try it out!
##
############################################################## 
## MOD History: 
##
##  2004-08-14 - Version 1.0.0
##      - First release hopefully no bugs! Thanks to Black Fluffy Lion for their help!!
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

$total_users = get_db_stat('usercount');

#
#-----[ AFTER, ADD ]------------------------------------------
#

$average_u_posts = $total_posts / $total_users;

#
#-----[ FIND ]------------------------------------------
#

		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),

#
#-----[ AFTER, ADD ]------------------------------------------
#

                'AVERAGE_U_POSTS' => sprintf($lang['Average_per_user'], $average_u_posts),

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Posted_article_total'] = 'Our users have posted a total of <b>%d</b> article'; // Number of posts

#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['Average_per_user'] = ' @ an average of <b>%d</b> posts per user'; // Average posts per user

#
#-----[ OPEN ]------------------------------------------ 
#

templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------ 
#

	<td class="row1" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>


#
#-----[ IN-LINE FIND ]------------------------------------------ 
#

{TOTAL_POSTS}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

{AVERAGE_U_POSTS}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM