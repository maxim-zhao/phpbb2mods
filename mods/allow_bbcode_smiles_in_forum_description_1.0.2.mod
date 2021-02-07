##############################################################
## MOD Title: Allow bbCode & Smilies In Forum Description 
## MOD Author: battye < cricketmx@hotmail.com > (battye) http://forums.cricketmx.com
## MOD Description: Rather than using HTML in your forum description, you can now use bbCode.
##
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 3 Minutes
##
## Files To Edit (3): admin/admin_forums.php
##                            index.php
##
## Included Files (0): (N/A)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: Enjoy
##############################################################
## MOD History:  2005-31-03 - Version 1.0.0
##      - First Release, it's pretty good 8)
## 						 2005-01-04 - Version 1.0.1
##      - Fixed MOD Templating error
## 						 2005-06-04 - Version 1.0.2
##      - Added IN-LINE to *.mod file
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
include($phpbb_root_path . 'common.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
// Allow smilies / bbCode in forum description
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

# 
#-----[ FIND ]------------------------------------------ 
#
								'FORUM_DESC' => $forum_data[$j]['forum_desc'],
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
								'FORUM_DESC' => smilies_pass(bbencode_second_pass($forum_data[$j]['forum_desc'], '')),
# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_forums.php

#-----[ FIND]------------------------------------------ 
#
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
// Allow smilies / bbCode in forum description
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

# 
#-----[ FIND ]------------------------------------------ 
#
// There is no problem having duplicate forum names so we won't check for it.
			$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_name, cat_id, forum_desc, forum_order, forum_status, prune_enable" . $field_sql . ")
				VALUES ('" . $next_id . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', $next_order, " . intval($HTTP_POST_VARS['forumstatus']) . ", " . intval($HTTP_POST_VARS['prune_enable']) . $value_sql . ")";

#
#-----[ IN-LINE FIND ]------------------------------------------
# 
str_replace("\'", "''", $HTTP_POST_VARS['forumdesc'])

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
# 
str_replace("\'", "''", bbencode_first_pass($HTTP_POST_VARS['forumdesc'], $uid)) 

# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", forum_desc = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', forum_status = " . intval($HTTP_POST_VARS['forumstatus']) . ", prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "
				WHERE forum_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]);
				
#
#-----[ IN-LINE FIND ]------------------------------------------
# 
str_replace("\'", "''", $HTTP_POST_VARS['forumdesc'])

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
# 
str_replace("\'", "''", bbencode_first_pass($HTTP_POST_VARS['forumdesc'], $uid)) 

# 
#-----[ FIND ]------------------------------------------ 
#
					'FORUM_DESC' => $forum_rows[$j]['forum_desc'],
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
 					'FORUM_DESC' => bbencode_second_pass($forum_rows[$j]['forum_desc'], ''),
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 