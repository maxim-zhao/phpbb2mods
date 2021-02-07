############################################################## 
## MOD Title: topic description fix for split topic types. 
## MOD Author: paulus < webmaster@paulscripts.nl > (paul sohier) http://www.paulscripts.nl 
## MOD Description: This mod will be fix the topic description from Swizec for split topic types. 
## MOD Version: 0.9.4 
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

$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title']; 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add 
$topic_desc = ( count ( $orig_word ) ) ? preg_replace ( $orig_word, $replacement_word, $topic_rowset[$i]['topic_description']) : $topic_rowset[$i]['topic_description']; 

# 
#-----[ FIND ]------------------------------------------ 
# 

$template->assign_block_vars( $tpl . '.row', array( 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add 
$desc4mod = $topic_rowset[ $i ]['topic_descmod']; 
if ( $topic_desc != '' && $board_config['allow_descriptions'] ) { 
   if ( !$desc4mod ) 
      $s = TRUE; 
   elseif ( ( $topic_rowset[$i]['user_id'] == $userdata['user_id'] ) || $is_auth['auth_mod'] ) 
      $s = TRUE; 
   else $s = FALSE; 
}else $s = FALSE; 
$topic_desc = ( $s ) ? '<br />' . $topic_desc : ''; 

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $topic_title, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add 
'TOPIC_DESC' => $topic_desc, 

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/viewforum_body.tpl 

# 
#-----[ FIND ]------------------------------------------ 
# 

<td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br /> 
      {topicrow.GOTO_PAGE}</span></td> 
<td class="{topics_list_box.row.ROW_CLASS}" width="100%"> 
      <span class="topictitle">{topics_list_box.row.NEWEST_POST_IMG}{topics_list_box.row.TOPIC_TYPE}<a href="{topics_list_box.row.U_VIEW_TOPIC}" class="topictitle">{topics_list_box.row.TOPIC_TITLE}</a></span><span class="genmed">{topics_list_box.row.TOPIC_DESC}</span><span class="gensmall">&nbsp;&nbsp;{topics_list_box.row.TOPIC_ANNOUNCES_DATES}{topics_list_box.row.TOPIC_CALENDAR_DATES}</span>       
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

{topics_list_box.row.TOPIC_TITLE}</a></span> 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

<span class="genmed">{topics_list_box.row.TOPIC_DESC}</span> 

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM