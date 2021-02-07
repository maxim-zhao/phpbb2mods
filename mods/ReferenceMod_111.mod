############################################################## 
## MOD Title: Reference Mod [2.0.7]
## MOD Author: Cross_+_Flame < admin@crossandflame.com > (n/a) http://www.crossandflame.com/forum 
## MOD Description: Adds MLA reference information to the bottom of every thread. 
## MOD Version: 1.1.1 
## 
## Installation Level: Easy 
## Installation Time: 3 Minutes 
## Files To Edit:	
##			viewtopic.php
##			language/lang_english/lang_main.php
##			templates/subSilver/viewtopic_body.tpl 
##
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 	This mod offers proper academic referencing information for 
##			phpbb-based content.  The coding is dynamic and updates with the 
##			thread information that	the user is viewing.  The referencing format
##			is based on MLA bibliographical format for Online Posting.
##			So easy it's a crime to not reference your material when it's done for you!
############################################################## 
## MOD History: 
## 
##   2003-08-09 - Version 1.1.1 
##      - Fixed missing " in the changes to viewtopic.php
##	  - 2.0.7 compliant
## 
##   2003-08-09 - Version 1.1.0 
##      - revamped entire code to be phpbb-generated for submission to MOD database
##	  - 2.0.6 compliant
##
##   2003-07-09 - Version 1.0.0 
##      - initial submission to MOD database in MLA style
##	  - 2.0.5 compliant
##
##   2003-07-01 - Version 0.9.0 
##      - Tested on crossandflame.com/forum in Chicago Style  
##	  - 2.0.4 compliant
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
$topic_time = $forum_topic_data['topic_time'];


# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
// Reference Mod by Cross+Flame
$reference_first_post = create_date($board_config['default_dateformat'], $forum_topic_data['topic_time'], $board_config['board_timezone']);


# 
#-----[ FIND ]------------------------------------------ 
# 
'S_WATCH_TOPIC_IMG' => $s_watching_topic_img,


#
#-----[ FIND ]------------------------------------------
#
'S_WATCH_TOPIC_IMG' => $s_watching_topic_img,


#
#-----[ AFTER, ADD ]------------------------------------------
#

   // Reference Mod by Cross+Flame
   'REFERENCE_FIRST_POST' => $reference_first_post,
   'REFERENCE_DATE' => create_date($board_config['default_dateformat'], time(), $board_config['board_timezone']),
   'L_REFERENCE_1' => $lang['Reference_1'],
   'L_REFERENCE_2' => $lang['Reference_2'],
   'REFERENCE_URL' => "< http://".$HTTP_SERVER_VARS['HTTP_HOST'].$HTTP_SERVER_VARS['PHP_SELF']."?t=$topic_id >",

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php


# 
#-----[ FIND ]------------------------------------------ 
# 
//
// That's all, Folks!


# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// Reference Mod by Cross+Flame 
$lang['Reference_1'] = 'Reference (<a href="http://www.bedfordstmartins.com/online/cite5.html#4" target="_blank">MLA Style</a>)';
$lang['Reference_2'] = 'Online Posting';


# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/viewtopic_body.tpl


# 
#-----[ FIND ]------------------------------------------ 
# 
<td align="right" valign="top" nowrap="nowrap">{JUMPBOX}<span class="gensmall">{S_AUTH_LIST}</span></td>
  </tr>
</table>


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
<table class="forumline" width="40%" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr> 
	<td width="40%" valign="top" nowrap="nowrap" align="center"><span class="gensmall"><b>{L_REFERENCE_1}</b><br />"{TOPIC_TITLE}." {L_REFERENCE_2}. {REFERENCE_FIRST_POST}. <u>{SITENAME}</u>.<br />{REFERENCE_DATE}. {REFERENCE_URL}.</span></td>
  </tr>
</table>


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 