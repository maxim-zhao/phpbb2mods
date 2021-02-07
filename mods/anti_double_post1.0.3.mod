##############################################################
## MOD Title: Anti Double Posts
## MOD Author: tehbmwman < tehbmwman@gmail.com > (N/A) N/A
## MOD Description: Disallows double posts if the user can edit their previous post.
## MOD Version: 1.0.3
## 
## Installation Level: Easy
## Installation Time: ~1 minute
## Files To Edit: posting.php
##				  language/lang_english/lang_main.php
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2108.38030 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: This mod will disallow any user to double post in a topic if they can edit their previous post. 
##############################################################
## MOD History:
## 
## 2005-12-15 - Version 1.0.1
## Initial release
##
## 2006-01-31 - Version 1.0.2
## Completely forgot about this mod, small bugs fixed.
##
## 2006-02-13 - Version 1.0.3
## Mod denied, fixing some errors
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
	switch ( $mode )
	{
		case 'editpost':
		case 'newtopic':
		case 'reply':
#
#-----[ AFTER, ADD ]------------------------------------
#
# If you use a mod that limits user edit time, change $board_config['edit_time']
# to the correct option if neccessary.
#
			//
			// BEGIN - Anti Double Post Mod
			//
			if ( $mode != 'newtopic' )
			{
				$edit_overtime = false;
				if ( !$is_auth['auth_mod'] && $board_config['edit_time'] != 0 )
				{
					$current_time = time();
					$difference_min = ($current_time - $post_info['post_time']) / 60;
					$edit_overtime = $difference_min > $board_config['edit_time'];
				}
				$sql = "SELECT topic_last_post_id 
						FROM " . TOPICS_TABLE . " 
						WHERE topic_id = " . $topic_id;
				if (!$topic_query = $db->sql_query($sql))
				{
				 	message_die(GENERAL_ERROR, $lang['Query_topic']);
				}
				$topic = $db->sql_fetchrow($topic_query);
				$last_post_id = $topic['topic_last_post_id'];
				
				$sql = "SELECT poster_id 
						FROM " . POSTS_TABLE . " 
						WHERE post_id = " . $last_post_id;
				if (!$post_query = $db->sql_query($sql)) 
				{
					message_die(GENERAL_ERROR, $lang['Query_post']);
				}
				$post = $db->sql_fetchrow($post_query);
				$last_user = $post['poster_id'];	
				if (($userdata['user_id'] == $last_user) && ($is_auth['auth_edit']) && (!$edit_overtime) && (!$is_auth['auth_mod'])) 
				{
					message_die(GENERAL_MESSAGE,$lang['No_doublepost']);
				}
			}
			//
			// END - Anti Double Posts Mod
			//
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['No_post_mode']
#
#-----[ AFTER, ADD ]-----------------------------------
#
$lang['No_doublepost'] = 'You cannot post in this topic until another user posts after you. Please edit your message instead.';
$lang['Query_topic'] = 'Could not query topics table';
$lang['Query_post'] = 'Could not query posts table';
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM
