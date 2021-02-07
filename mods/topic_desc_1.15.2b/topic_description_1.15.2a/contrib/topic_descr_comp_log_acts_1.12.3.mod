## easymod compliant
############################################################## 
## MOD Title: Topic Description add-on for Log Action MOD.
## MOD Author: Lucas Malor < N/A > (N/A) http://progettolo.altervista.org/
## MOD Description: This is a little MOD that make Topic Description compatible with
## Log Action MOD.
## MOD Version: 1.12.3
## 
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: 
##  posting.php
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
## This MOD must be installed AFTER Log Action MOD, and preferably
## also after Topic Description MOD.
## 
## This MOD has been tested with phpBB 2.0.18, Log Action MOD 1.1.6 and
## Topic Description MOD 1.12.3
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 
// Log Actions Start
$username

# 
#-----[ FIND ]------------------------------------------ 
# 
$subject =

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
# ATTENTION!!! Add in a new line.
# 

// mod topic description: add
$post_desc4mod = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['desc4mod']) && $canmoddesc ) ? TRUE : FALSE ) : FALSE;
$post_description = ( !empty($HTTP_POST_VARS['description']) && $candesc ) ? trim($HTTP_POST_VARS['description']) : '';
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 
prepare_post(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 
, $post_description
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
# ATTENTION!!! Add in a new line.
# 

// mod topic description: add argument
# 
#-----[ FIND ]------------------------------------------ 
# 
submit_post(

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
# ATTENTION!!! Add in a new line.
# 

// mod topic description add argument
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
str_replace("\'", "''", $subject),

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 str_replace("\'", "''", $post_description), $post_desc4mod,
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM