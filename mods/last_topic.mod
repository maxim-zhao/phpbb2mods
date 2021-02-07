##############################################################
## MOD Title: Last Topic Display Modification
## MOD Author: SiliconHero < siliconhero@skytowergames.net > (Walter Williams) http://www.skytowergames.net/
## MOD Description: Displays the title of and a link to the last topic replied to in a particular forum.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~1 Minute
## Files To Edit: index.php
## Included Files: N/A
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##   This is my very first phpBB mod. I figured I'd start with something small, that doesn't
##   require the user to modify a whole bunch of files. This mod should work with phpBB 2.0.6
##   and up, across all templates (since the index.php file is the only thing being modified).
##
##############################################################
## MOD History:
##
##   2004-05-31 - Version 1.0.0
##      - initial version of the Last Topic Mod
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
## Possible Actions:
##
## SQL
## COPY
## OPEN
## FIND
## REPLACE WITH
## AFTER, ADD
## BEFORE, ADD
## IN-LINE FIND
## IN-LINE AFTER, ADD
## IN-LINE BEFORE, ADD
## IN-LINE REPLACE WITH
##############################################################


#
#-----[ OPEN ]------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------
#
								$last_post = $last_post_time . '<br />';

#
#-----[ AFTER, ADD ]------------------------------------------
#
								$sql = "SELECT DISTINCT f.forum_id, f.forum_last_post_id, p.topic_id, t.topic_title
									FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . TOPICS_TABLE . " t
									WHERE t.topic_id = p.topic_id
										AND t.topic_last_post_id = " . $forum_data[$j]['forum_last_post_id'];

								if ( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not select info from post/topic table', '', __LINE__, __FILE__, $sql);
								}

								$last_topic_data = $db->sql_fetchrow($result);
								$ltid = $last_topic_data['topic_id'];
								$lttitle = $last_topic_data['topic_title'];

								// append first 25 characters of topic title to last topic data
								if (strlen($lttitle) > 25)
								{
									$last_post .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$ltid") . '">' . substr($lttitle, 0, 25) . '...</a><br />';
								}
								else
								{
									$last_post .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$ltid") . '">' . substr($lttitle, 0, 25) . '</a><br />';
								}

								$db->sql_freeresult($result);



#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 