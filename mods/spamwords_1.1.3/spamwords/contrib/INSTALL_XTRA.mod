##############################################################
## MOD Title: Spam Words Addtional Changes
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: 
## MOD Version: 1.1.3
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit: (2)
##			  index.php
##			  search.php
##
## Included Files: n/a
##
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
##############################################################
## MOD History:
##
##   2006-10-02 - 1.1.1
##      - bug fix
##
##   2006-09-19 - Version 1.1.0
##	  - Changes for search.php and index.php
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
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, p.post_username
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, p.post_flagged
#
#-----[ FIND ]------------------------------------------
#
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, p.post_username
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, p.post_flagged
#
#-----[ FIND ]------------------------------------------
#
			$sql = "SELECT f.*, p.post_time, p.post_username, u.username, u.user_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, p.post_username
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, p.post_flagged
#
#-----[ FIND ]------------------------------------------
#
				AND p.post_time > " . $userdata['user_lastvisit'] . "
#
#-----[ AFTER, ADD ]------------------------------------------
#
				AND p.post_flagged <> " . true . "
#
#-----[ FIND ]------------------------------------------
#
								$last_post .= '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $forum_data[$j]['forum_last_post_id']) . '#' . $forum_data[$j]['forum_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
#
#-----[ AFTER, ADD ]------------------------------------------
#
								if ($forum_data[$j]['post_flagged'])
								{
									$sql = "SELECT p.post_id, p.post_time, p.poster_id, p.post_username, u.user_id, u.username FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u
									WHERE p.poster_id = u.user_id
									AND p.forum_id = " . $forum_data[$j]['forum_id'] . "
									AND post_flagged <> " . true . "
									ORDER BY post_id DESC
									LIMIT 1";

									if (!$result = $db->sql_query($sql))
									{
										message_die(GENERAL_ERROR, 'Could not obtain post information', '', __LINE__, __FILE__, $sql);
									}

									$last_clean_post = array();
									$last_clean_post = $db->sql_fetchrow($result);

									$last_post_time = create_date($board_config['default_dateformat'], $last_clean_post['post_time'], $board_config['board_timezone']);
									$last_post = $last_post_time . '<br />';
									$last_post .= ($last_clean_post['user_id'] == ANONYMOUS) ? (($last_clean_post['post_username'] != '') ? $last_clean_post['post_username'] . ' ' : $lang['Guest'] . ' ') : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $last_clean_post['user_id']) . '">' . $last_clean_post['username'] . '</a> ';
									$last_post .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $last_clean_post['post_id']) . '#' . $last_clean_post['post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
								}
#
#-----[ OPEN ]------------------------------------------
#
search.php
#
#-----[ FIND ]------------------------------------------
#
				if ( $userdata['session_logged_in'] )
				{
					$sql = "SELECT post_id
						FROM " . POSTS_TABLE . "
						WHERE post_time >= " . $userdata['user_lastvisit'];
				}
#
#-----[ REPLACE WITH ]------------------------------------------
#
				if ( $userdata['session_logged_in'] )
				{
					$sql = "SELECT post_id
					FROM " . POSTS_TABLE . "
					WHERE post_time >= " . $userdata['user_lastvisit'] . "
					AND post_flagged <> " . true;
				}
#
#-----[ FIND ]------------------------------------------
#
				if ( $userdata['session_logged_in'] )
				{
					$sql = "SELECT post_id
						FROM " . POSTS_TABLE . "
						WHERE poster_id = " . $userdata['user_id'];
				}
#
#-----[ REPLACE WITH ]------------------------------------------
#
				if ( $userdata['session_logged_in'] )
				{
					$sql = "SELECT post_id
					FROM " . POSTS_TABLE . "
					WHERE poster_id = " . $userdata['user_id'] . "
					AND post_flagged <> " . true;
				}
#
#-----[ FIND ]------------------------------------------
#
						if ( !strstr($multibyte_charset, $lang['ENCODING']) )
						{
							$match_word = str_replace('*', '%', $split_search[$i]);
							$sql = "SELECT m.post_id
								FROM " . SEARCH_WORD_TABLE . " w, " . SEARCH_MATCH_TABLE . " m
								WHERE w.word_text LIKE '$match_word'
									AND m.word_id = w.word_id
									AND w.word_common <> 1
									$search_msg_only";
						}
						else
						{
							$match_word =  addslashes('%' . str_replace('*', '', $split_search[$i]) . '%');
							$search_msg_only = ( $search_fields ) ? "OR post_subject LIKE '$match_word'" : '';
							$sql = "SELECT post_id
								FROM " . POSTS_TEXT_TABLE . "
								WHERE post_text LIKE '$match_word'
								$search_msg_only";
						}
#
#-----[ REPLACE WITH ]------------------------------------------
#
						if ( !strstr($multibyte_charset, $lang['ENCODING']) )
						{
							$match_word = str_replace('*', '%', $split_search[$i]);
							$sql = "SELECT m.post_id
							FROM " . SEARCH_WORD_TABLE . " w, " . SEARCH_MATCH_TABLE . " m, " . POSTS_TABLE . " p
							WHERE w.word_text LIKE '$match_word'
							AND m.word_id = w.word_id
							AND m.post_id = p.post_id
							AND w.word_common <> 1
							AND p.post_flagged <> " . true . "
							$search_msg_only";
						}
						else
						{
							$match_word =  addslashes('%' . str_replace('*', '', $split_search[$i]) . '%');
							$search_msg_only = ( $search_fields ) ? "OR post_subject LIKE '$match_word'" : '';
							$sql = "SELECT pt.post_id
							FROM " . POSTS_TEXT_TABLE . " pt, " . POSTS_TABLE . " p
							WHERE pt.post_id = p.post_id
							AND p.post_flagged <> " . true . "
							AND pt.post_text LIKE '$match_word'
							$search_msg_only";
						}
#
#-----[ FIND ]------------------------------------------
#
			if ( $auth_sql != '' )
			{
				$sql = "SELECT t.topic_id, f.forum_id
					FROM " . TOPICS_TABLE . "  t, " . FORUMS_TABLE . " f
					WHERE t.topic_replies = 0
						AND t.forum_id = f.forum_id
						AND t.topic_moved_id = 0
						AND $auth_sql";
			}
			else
			{
				$sql = "SELECT topic_id
					FROM " . TOPICS_TABLE . "
					WHERE topic_replies = 0
						AND topic_moved_id = 0";
			}
#
#-----[ REPLACE WITH ]------------------------------------------
#
			if ( $auth_sql != '' )
			{
				$sql = "SELECT t.topic_id, f.forum_id
				FROM " . TOPICS_TABLE . "  t, " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p
				WHERE t.topic_replies = 0
				AND t.forum_id = f.forum_id
				AND t.topic_id = p.topic_id
				AND t.topic_moved_id = 0
				AND p.post_flagged <> " . true . "
				AND $auth_sql";
			}
			else
			{
				$sql = "SELECT t.topic_id
				FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
				WHERE t.topic_id = p.topic_id
				AND p.post_flagged <> " . true . "
				AND t.topic_replies = 0
				AND t.topic_moved_id = 0";
			}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM