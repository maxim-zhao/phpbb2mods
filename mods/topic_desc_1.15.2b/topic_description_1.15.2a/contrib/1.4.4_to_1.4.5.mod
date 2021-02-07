############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: Just an update for TOpic Description v1.14.4 to 1.14.5
## MOD Version: 1.14.5
## 
## Installation Level: Easy
## Installation Time: ~1 Minute
## Files To Edit: 
##		search.php
## Included Files: 
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
##
## I got the tooltip script from http://www.walterzorn.com/tooltip/tooltip_e.htm
## This thingo is also LGPL and the MODs think this should be mentioned so it is :) (that's for the JS script)
## demo board: http://www.swizec.com/forum
##
## READ THE README
## 
############################################################## 
## MOD History: 
## 
## history.txt
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

search.php

# 
#-----[ FIND ]------------------------------------------ 
# 

// mod topic description mod add
$showdesc = check_descperm ( TRUE );
$topic_desc = ( $showdesc ) ? fetch_desc( $searchset[$i]['topic_description'], $searchset[$i]['bbcode_uid'] ) : '';
$topic_tool = ( show_tooltip ( $searchset[$i]['forum_id'], $searchset[$i]['topic_id'] ) ) ? topic_tooltip ( $searchset[$i]['topic_id'] ) : '';
// mod topic description mod end

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

// mod topic description code moved a few lines down

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_id = $searchset[$i]['topic_id'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$showdesc = check_descperm ( TRUE );
$topic_desc = ( $showdesc ) ? fetch_desc( $searchset[$i]['topic_description'], $searchset[$i]['bbcode_uid'] ) : '';
$topic_tool = ( show_tooltip ( $searchset[$i]['forum_id'], $searchset[$i]['topic_id'] ) ) ? topic_tooltip ( $searchset[$i]['topic_id'] ) : '';
// mod topic description mod end

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM