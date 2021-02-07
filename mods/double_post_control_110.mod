##############################################################
## MOD Title: Double Post Control MOD
## MOD Author: Kinetix < webmaster@ikrontik.tk > (N/A) http://www.ikrontik.tk
## MOD Description: This MOD effectively stops users from posting the same message
##                  twice in a row.
## MOD Version: 1.1.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: 2: includes/functions_post.php 
##                   language/lang_english/lang_main.php 
## Included Files: 0
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: None.
##
##############################################################
## MOD History:  1.0.0 Initial Release
##               1.1.0 Posts with BBCode were not double post checked (uid).
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

# IMPORTANT: Some FIND commands only contain partial lines.  Unless the script calls for an
# "IN-LINE ADD," always add new segments of code on separate lines.  Also, before an In-Line
# Find, you'll often see a FIND.  These FINDS are there to help you locate the lines where
# In-Line FIND will work.
# 
#-----[ OPEN ]------------------------------------------ 
#
includes/functions_post.php
# 
#-----[ FIND ]------------------------------------------ 
#
		//
		// Flood control
		//
		$where_sql = ($userdata['user_id'] == ANONYMOUS) ? "poster_ip = '$user_ip'" : 'poster_id = ' . $userdata['user_id'];
		$sql = "SELECT MAX(post_time) AS last_post_time
			FROM " . POSTS_TABLE . "
			WHERE $where_sql";
		if ($result = $db->sql_query($sql))
		{
			if ($row = $db->sql_fetchrow($result))
			{
				if (intval($row['last_post_time']) > 0 && ($current_time - intval($row['last_post_time'])) < intval($board_config['flood_interval']))
				{
					message_die(GENERAL_MESSAGE, $lang['Flood_Error']);
				}
			}
		}
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

		//
		// Double Post Control
		//
		$lastposttime = intval($row['last_post_time']);
		if($mode != 'editpost')
		{
			$sql = "SELECT pt.post_text, pt.bbcode_uid
				FROM " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt
				WHERE $where_sql AND p.post_time = $lastposttime AND pt.post_id = p.post_id
				LIMIT 1";
			if ($result = $db->sql_query($sql))
			{
				if ($row = $db->sql_fetchrow($result))
				{
					// Update BBCode to current UID
					$row['post_text'] = str_replace(":" . $row['bbcode_uid'] . "]", ":" . $bbcode_uid . "]", $row['post_text']);
					if ($row['post_text'] == $post_message)
					{
						message_die(GENERAL_MESSAGE, $lang['Double_Post_Error']);
					}
				}
				$db->sql_freeresult($result);
			}
		}
# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Flood_Error'] = 'You cannot make another post so soon after your last; please try again in a short while.';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Double_Post_Error'] = 'You cannot make another post with the exact same text as your last.';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 