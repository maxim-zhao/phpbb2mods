############################################################# 
## MOD Title: topic description fix for split topic types. 
## MOD Author: paulus < webmaster@paulscripts.nl > (paul sohier) http://www.paulscripts.nl 
## MOD Description: This mod will be fix the topic description from Swizec for split topic types. 
##               This is for version: 1.11.7 (probably works on newer too)
## MOD Version: 0.0.1 
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## Files To Edit: 
##            include/functions_topics_list.php 
##            templates/subSilver/topics_list_box.tpl 
## Included Files: 0 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
## You don't have to make changes at viewforum.php and templates/subSilver/viewforum_body.tpl! 
############################################################## 
## MOD History: 
## 
##   2005-05-03 - Version 0.0.1 
##      - First release. 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

include/functions_topics_list.php 

# 
#-----[ FIND ]------------------------------------------ 
# 

$desc4mod = $topic_rowset[$i]['topic_descmod']; 
if ( $topic_desc != '' && $board_config['allow_descriptions'] ) { 
   if ( !$desc4mod ) 
      $s = TRUE; 
   elseif ( ( $topic_rowset[$i]['user_id'] == $userdata['user_id'] ) || $is_auth['auth_mod'] ) 
      $s = TRUE; 
   else $s = FALSE; 
}else $s = FALSE; 
$topic_desc = ( $s ) ? '<br />' . $topic_desc : ''; 

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

$desc4mod = $topic_rowset[ $i ]['topic_descmod']; 
$topic_desc = fetch_desc ( $topic_desc, TRUE ); 
$topic_tool = ( show_tooltip ( $forum_id, $topic_id ) ) ? topic_tooltip ( $topic_id ) : ''; 
// mod topic description end 

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_DESC' => $topic_desc, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

'TOPIC_TOOLTIP' => $topic_tool, 

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/viewforum_body.tpl 

# 
#-----[ FIND ]------------------------------------------ 
# 

<a href="{topics_list_box.row.U_VIEW_TOPIC}" class="topictitle">{topics_list_box.row.TOPIC_TITLE}</a> 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

href="{topics_list_box.row.U_VIEW_TOPIC}" 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 {topics_list_box.row.TOPIC_TOOLTIP} 
  
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM