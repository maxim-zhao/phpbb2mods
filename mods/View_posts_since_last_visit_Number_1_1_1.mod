##############################################################
## MOD Title: View posts since last visit Number
## MOD Author: Shof515 < shof515@gmail.com > (Shaun) http://shof515.com
## MOD Description: Shows how many new posts were made since lasts,and shows them on the 
##                  View posts since last visit link on the index page
## MOD Version: 1.1.1
##
## Installation Level: (Easy)
## Installation Time: 1 Minute
## Files To Edit: index.php
## Included Files: none
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##  This mod replaces the View posts since last visit with this: View posts since last visit(X)
##  where X is the number of posts were made since last vist
##
##############################################################
## MOD History:
##   2004-08-21 - Verison 1.1.1
##      - Fixed a mod template problem
##   2004-08-20 - Version 1.1.0
##      - Fixed a major issue,Fix the problem where the mod was not working,this mod now works
##   2004-08-19 - Version 1.0.0
##      - First Verison made
##
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
//
// End session management
//
#
#-----[ AFTER, ADD ]------------------------------------------
#
if( $userdata['session_logged_in'] ) 
{ 
	$sql = "SELECT COUNT(post_id) as total 
		FROM " . POSTS_TABLE . " 
		WHERE post_time >= " . $userdata['user_lastvisit'] . " 
		AND poster_id != " . $userdata['user_id']; 

	$result = $db->sql_query($sql); 
	if( $result ) 
	{ 
		$row = $db->sql_fetchrow($result); 
		$lang['Search_new'] = $lang['Search_new'] . " (" . $row['total'] . ")"; 
	}
}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 