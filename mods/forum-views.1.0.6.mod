############################################################## 
## MOD Title: Forum Views
## MOD Author: Cherokee Red < cherokeered@blueyonder.co.uk > (Kenny Cameron) 
## http://mrikasu.com/cherokeered 
## MOD Description: Adds a new row on the main page (index) of your forums, which shows the amount of views that forum has had. basically the same as viewforum does ;) 
## MOD Version: 1.0.6
## 
## Installation Level: Easy 
## Installation Time: ~5 Minutes 
## Files To Edit: viewforum.php 
##         	  index.php
##         	  templates/subSilver/index_body.tpl 
		  language/lang_english/lang_main.php 
## Included Files: n/a  
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## 
## Made by request from this topic at phpbb.com - 
http://www.phpbb.com/phpBB/viewtopic.php?t=229788 - many thanks to hafling_hopperston and ptirhiik for their help. 
## Please note that this version of my MOD is NOT compatible with any version of Catagories Hierarchy. I will, however, be releasing an add-on for this very soon.
## 
############################################################## 
## MOD History: 
## 
##   2004-10-02 - Version 0.0.1 
##      - mod created: functional, but on every page refresh, the view count on all forums goes up. Same with a topic view. will be finished next version. 
## 
##   2004-10-05 - Version 0.0.2 
##      - mod updated - view counter now updates properly, thanks to help from hafling_hopperston and ptirhiik. 
## 
##   2004-10-06 - Version 0.0.3 
##      - altered viewforum.php find/after add - previous find used was a bit too much coding.
## 
##   2004-10-07 - Version 0.0.4 
##      - altered FIND's in the code - MOD now EasyMod 0.1.13 compliant :) (although not officially)
##
##   2004-10-07 - Version 0.0.5 
##      - added db_update file
## 
##   2004-10-12 - Version 1.0.0 
##      - updated authors notes, changed version number and submitted to MOD DB. No code was changed.
## 
##   2004-10-12 - Version 1.0.1 
##      - fixed a small error in the templade coding - missing class value (thanks to ptirhiik again) - and fixed missing &nbsp; in index_body.tpl - was giving an easymod error.
##
##   2004-10-25 - Version 1.0.2 
##      - bug fix: thanks to ShadowTek for noticing that the fade out gradient picture (cellpic2.jpg) didn't stretch to the end of the 'last post' column with my mod installed.
## 
##   2004-10-12 - Version 1.0.3 
##      - fixed colspan on the cellpic2.jpg gradient - should be "4" and not "3"
##
##   2004-10-12 - Version 1.0.4
##      - fixed a failed EasyMod find in index_body.tpl
##
##   2004-11-22 - Version 1.0.5
##      - updated to allow the view column text to be changed - this is done by editing the language varaible added in lang_main.php also fixed double " marks - noted by fuldfk
##
##   2004-10-12 - Version 1.0.6
##      - fixed Mod Template bug
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ SQL ]------------------------------------------ 
# 
ALTER TABLE phpbb_forums ADD forum_views mediumint( 8 ) NOT NULL 
# 
#-----[ OPEN ]------------------------------------------ 
# 
viewforum.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
$total_topics = 0;
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// 
// Update the forum view counter 
// 
$sql = "UPDATE " . FORUMS_TABLE . " 
   SET forum_views = forum_views + 1 
   WHERE forum_id = $forum_id"; 
if ( !$db->sql_query($sql) ) 
{ 
   message_die(GENERAL_ERROR, "Could not update forum views.", '', __LINE__, 

__FILE__, $sql); 
} 
# 
#-----[ OPEN ]------------------------------------------ 
# 
index.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
      'L_POSTS' => $lang['Posts'], 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
      'L_FORUM_VIEWS' => $lang['Forum_Views'], 
# 
#-----[ FIND ]------------------------------------------ 
# 
$forum_data[$j]['forum_topics'], 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
                                
								'VIEWS' => 
$forum_data[$j]['forum_views'],
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/index_body.tpl 
# 
#-----[ FIND ]------------------------------------------ 
# 
      <th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th> 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
      <th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_FORUM_VIEWS}&nbsp;</th> 
# 
#-----[ FIND ]------------------------------------------ 
# 
	<td class="rowpic" colspan="3" align="right">&nbsp;</td>
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
"3" 
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
"4"
# 
#-----[ FIND ]------------------------------------------ 
# 
   <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td> 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
   <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.VIEWS}</span></td> 
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Views'] = 'Views'; 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# change Board Views to your desired text 
# 
$lang['Forum_Views'] = 'Board Views'; 
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 