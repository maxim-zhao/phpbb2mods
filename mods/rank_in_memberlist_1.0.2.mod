############################################################## 
## MOD Title: Rank in memberlist
## MOD Author: netclectic < adrian@netclectic.com > (Adrian Cockburn) http://www.netclectic.com 
## MOD Description: Adds users rank to memberlist 
## MOD Version: 1.0.2
## 
## Installation Level: easy
## Installation Time: 5 Minutes 
## Files To Edit: (2) memberlist.php, memberlist_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## MOD History:
##
##     2003-08-23  - Version 1.0.2
##          - Confirmed on 2.0.6
##
##     2003-01-01  - Version 1.0.1
##          - Fix problem with location of code added to memberlist.php
##
##     2002-01-01  - Version 1.0.0
##          - Original release
##
############################################################## 
## Author Notes: 
##  
##      Updated from old mod - original author unknown
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
memberlist.php

# 
#-----[ FIND ]------------------------------------------ 
#
'L_ICQ' => $lang['ICQ'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
   // MOD RANK MEMBERLIST BEGIN 
   'L_USER_RANK' => $lang['Poster_rank'], 
   // MOD RANK MEMBERLIST END 
 
# 
#-----[ FIND ]------------------------------------------ 
#
	default:
		$order_by = "user_regdate $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}
 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// MOD RANK MEMBERLIST BEGIN 
$sql = "SELECT * 
   FROM " . RANKS_TABLE . " 
   ORDER BY rank_special, rank_min"; 
if ( !($result = $db->sql_query($sql)) ) 
{ 
   message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql); 
} 
$ranksrow = array(); 
while ( $row = $db->sql_fetchrow($result) ) 
{ 
   $ranksrow[] = $row; 
} 
$db->sql_freeresult($result); 
// MOD RANK MEMBERLIST END 
 
 
# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "SELECT username, user_id, user_viewemail,

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, user_allowavatar

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, user_rank

# 
#-----[ FIND ]------------------------------------------ 
#
$posts = ( $row['user_posts'] ) ? $row['user_posts'] : 0; 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
      // MOD RANK MEMBERLIST BEGIN 
      $user_rank = ''; 
      $rank_image = ''; 
      if ( $row['user_rank'] ) 
      { 
         for($j = 0; $j < count($ranksrow); $j++) 
         { 
            if ( $row['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] ) 
            { 
               $user_rank = $ranksrow[$j]['rank_title']; 
               $rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $images['rank'] . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : ''; 
            } 
         } 
      } 
      else 
      { 
         for($j = 0; $j < count($ranksrow); $j++) 
         { 
            if ( $row['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] ) 
            { 
               $user_rank = $ranksrow[$j]['rank_title']; 
               $rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $images['rank'] . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : ''; 
            } 
         } 
      } 
      // MOD RANK MEMBERLIST END 
 
# 
#-----[ FIND ]------------------------------------------ 
#
'JOINED' => $joined, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#          // MOD RANK MEMBERLIST BEGIN 
         'USER_RANK' => $user_rank, 
         'USER_RANK_IMG' => $rank_image, 
         // MOD RANK MEMBERLIST END 
 
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/memberlist_body.tpl 

# 
#-----[ FIND ]------------------------------------------ 
# 
<th class="thTop" nowrap="nowrap">{L_USERNAME}</th> 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
<th class="thTop" nowrap="nowrap">{L_USER_RANK}</th> 

# 
#-----[ FIND ]------------------------------------------ 
# 
<td class="{memberrow.ROW_CLASS}" align="center"><span class="gen"><a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a></span></td>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
<td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow.USER_RANK_IMG}{memberrow.USER_RANK}</span></td> 

# 
#-----[ FIND ]------------------------------------------ 
# 
# BEWARE! other memberlist mods may have changed this
#
<td class="catBottom" colspan="8" height="28">&nbsp;</td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
<td class="catBottom" colspan="9" height="28">&nbsp;</td>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 