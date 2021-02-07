############################################################## 
## MOD Title: Viewforum Style Mod
## MOD Author: dESiLVer < desilverx@gmail.com > (Kemal Guner) http://www.techsilver.gen.tr
## MOD Description: Viewforum replies,views field simple style modification and add topic number.
## MOD Version: 1.0.0 
## 
## Installation Level: (Easy) 
## Installation Time: 5 Minutes 
## Files To Edit: viewforum.php
##		      language/lang_english/lang_main.php
##			templates/subSilver/viewforum_body.tpl
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: My third mod :)
## 		     
############################################################## 
## MOD History: 
## 
##   2005-07-13 - Version 1.0.0
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

'L_VIEWS' => $lang['Views'],

# 
#-----[ AFTER, ADD ]----------------------------------- 
# 

'L_TOPIC_NUMBER' => $lang['Topic_number'],

# 
#-----[ OPEN ]------------------------------------------- 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]----------------------------------- 
# 

$lang['Views'] = 'Views';

# 
#-----[ AFTER, ADD ]----------------------------------- 
# 

$lang['Topic_number'] = 'Topic number';

# 
#-----[ OPEN ]------------------------------ 
# 
templates/subSilver/viewforum_body.tpl
# 
#-----[ FIND ]----------------------------------- 
# 

<th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>

# 
#-----[ REPLACE WITH ]----------------------------------- 
# 



# 
#-----[ FIND ]------------------------------------------- 
#

<th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>

# 
#-----[ REPLACE WITH ]----------------------------------- 
# 



# 
#-----[ FIND ]----------------------------------- 
# 

{topicrow.GOTO_PAGE}</span></td>

# 
#-----[ IN-LINE FIND ]------------------------------------------- 
# 

</span>

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------- 
# 

<span class="gensmall"><i>{L_TOPIC_NUMBER}:</i> <b>{topicrow.TOPIC_ID}</b>,&nbsp;<i>{L_REPLIES}:</i> <b>{topicrow.REPLIES}</b>,&nbsp;<i>{L_VIEWS}:</i> <b>{topicrow.VIEWS}</b></span>

# 
#-----[ FIND ]------------------------------ 
# 

<td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>

# 
#-----[ REPLACE WITH ]----------------------------------- 
# 



# 
#-----[ FIND ]----------------------------------- 
# 

<td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>

# 
#-----[ REPLACE WITH ]----------------------------------- 
# 



# 
#-----[ FIND ]----------------------------------- 
# 

<tr> 
     <td class="catBottom" align="center" valign="middle" colspan="6" height="28"><span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp;

# 
#-----[ IN-LINE FIND ]----------------------------------- 
# 

colspan="6"

# 
#-----[ IN-LINE REPLACE WITH ]----------------------------------- 
# 

colspan="4"

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
