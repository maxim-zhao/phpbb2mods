################################################################# 
## MOD Title: This day in music && film  
## MOD Author: Tomythius < tom@whaletattoo.com > (Tom Wright) http://www.tom.whaletattoo.com
## MOD Description: Attaches 'This day in Music' and 'This day in Film' to the 'Joined' field in a users profile.
## 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: ~5 Minutes 
## Files To Edit: includes/usercp_viewprofile.php, 
##                templates/subSilver/profile_view_body.tpl
##		  		  languages/lang_english/lang_main.php
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################  
## 
##  Author Notes: I've applied for permission to use these databases like this.
##				  They shouldn't mind, they get extra traffic and are free to use anyway.
##				  Uses 'IMDB' for film, and 'Everyhit' for music.
##				  IMDB		 ~ http://imdb.com/
##				  Everyhit 	 ~ http://everyhit.com/
## 
############################################################## 
## 
## MOD History: 
##	Original version:
##		2005-06-4 - Version 0.0.5 By Tomythius
##	Enhancements:
##		2005-06-4 - Version 1.0.0 By Tomythius
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_view_body.tpl 

# 
#-----[ FIND ]--------------------------------- 
#
		  <td width="100%"><b><span class="gen">{JOINED}</span></b></td>

# 
#-----[ IN-LINE FIND ]--------------------------------- 
#
		</b>

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
#
		<br/><span class="genmed">({MUSICDAY})&nbsp;({FILMDAY})</span>

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]--------------------------------- 
#
$lang['Joined'] = 'Joined';

# 
#-----[ AFTER, ADD ]--------------------------------- 
#

$lang['MusicDay'] = 'This day in MUSIC history';
$lang['FilmDay'] = 'This day in FILM history';

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_viewprofile.php

# 
#-----[ FIND ]--------------------------------- 
#
	'JOINED' => create_date($lang['DATE_FORMAT'], $profiledata['user_regdate'], $board_config['board_timezone']),

# 
#-----[ AFTER, ADD ]--------------------------------- 
#

	'MUSICDAY' => '<a href="http://www.everyhit.com/dates/thisdate.php?action=show&ddb_day=' . date('d', $profiledata['user_regdate']) . '&ddb_month=' . date('m', $profiledata['user_regdate']) . '&ddb_year=' . date('Y', $profiledata['user_regdate']) . '" target="_blank">' . $lang['MusicDay'] . '</a>',
	'FILMDAY' => '<a href="http://imdb.com/OnThisDay?day=' .date('j', $profiledata['user_regdate']).'&month='.date('F', $profiledata['user_regdate']).'" target="_blank">' . $lang['FilmDay'] . '</a>',

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM