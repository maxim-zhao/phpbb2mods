############################################################## 
## MOD Title: Disable Search Indexing
## MOD Author: Albosky < albosky@comcast.net > (Peter Murphy) http://forum.tip.it
## MOD Description: This mod enables you to selectively turn off posts from being indexed in the search tables on a per forum basis. 
## MOD Version: 1.0.0 
## 
## Installation Level: (Intermediate) 
## Installation Time: ~20 Minutes (1 minute with EasyMOD) 
## Files To Edit: includes/functions_post.php,
##		  modcp.php
##		  posting.php
##                admin/admin_forums.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/forum_edit_body.tpl
## Included Files: (n/a)
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
##   2006-09-01 - Version 1.0.0 
##      - Initial release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# Change the prefix 'phpbb_' accordingly. 'phpbb_' is the default prefix
#
ALTER TABLE phpbb_forums ADD index_posts TINYINT( 1 ) DEFAULT '1' NOT NULL;

# 
#-----[ OPEN ]------------------------------------------ 
# 
modcp.php
# 
#-----[ FIND ]------------------------------------------ 
# 
	$sql = "SELECT f.forum_id, f.forum_name, f.forum_topics
#
#-----[ IN-LINE FIND ]------------------------------------------
#
f.forum_topics
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, f.index_posts
# 
#-----[ FIND ]------------------------------------------ 
# 
	$forum_id = $topic_row['forum_id'];
	$forum_name = $topic_row['forum_name'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	$index_posts = $topic_row['index_posts'];
# 
#-----[ FIND ]------------------------------------------ 
# 
	$sql = "SELECT forum_name, forum_topics
#
#-----[ IN-LINE FIND ]------------------------------------------
#
forum_topics
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, index_posts
# 
#-----[ FIND ]------------------------------------------ 
# 
	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_name = $topic_row['forum_name'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	$index_posts = $topic_row['index_posts'];
# 
#-----[ FIND ]------------------------------------------ 
# 
				remove_search_post($post_id_sql);
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
				if ($index_posts)
				{
# 
#-----[ FIND ]------------------------------------------ 
# 
			}

			if ( $vote_id_sql != '' )
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
				}
# 
#-----[ FIND ]------------------------------------------ 
# 
			$new_forum_id = intval($HTTP_POST_VARS['new_forum']);
# 
#-----[ BEFORE, ADD ]------------------------------------------
# 
			include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
			$post_id_sql = '';
# 
#-----[ FIND ]------------------------------------------ 
# 
			$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
#
#-----[ IN-LINE FIND ]------------------------------------------
#
forum_id
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
# 
, index_posts
# 
#-----[ FIND ]------------------------------------------ 
# 
				message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
			}
# 
#-----[ AFTER, ADD ]------------------------------------------
# 
			$forum_row = $db->sql_fetchrow($result);
# 
#-----[ FIND ]------------------------------------------ 
# 
			if (!$db->sql_fetchrow($result))
			{
				message_die(GENERAL_MESSAGE, 'New forum does not exist');
			}
#
#-----[ REPLACE WITH ]------------------------------------------
#
			if (!$forum_row)
			{
				message_die(GENERAL_MESSAGE, 'New forum does not exist');
			}
# 
#-----[ FIND ]------------------------------------------ 
# 
			$db->sql_freeresult($result);
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
			$index_posts = $forum_row['index_posts'];


# 
#-----[ FIND ]------------------------------------------ 
# 
			if ( $new_forum_id != $old_forum_id )
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
			$sql = 'SELECT index_posts FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $old_forum_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
			}

			$forum_row = $db->sql_fetchrow($result);
			$index_post = $forum_row['index_posts'];

			$db->sql_freeresult($result);
# 
#-----[ FIND ]------------------------------------------ 
# 
					$sql = "UPDATE " . TOPICS_TABLE . "
# 
#-----[ BEFORE, ADD ]------------------------------------------
# 
					while ( $row2 = $db->sql_fetchrow($result) )
					{
						$post_id_sql .= ( ( $post_id_sql != '' ) ? ', ' : '' ) . intval($row2['post_id']);
						if ((!$index_post) && (index_posts))
						{
							$sql = "SELECT post_id, post_subject, post_text  
								FROM " . POSTS_TEXT_TABLE . "
								WHERE post_id = " . $row2['post_id'];
							if ( !($result2 = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Could not get post information', '', __LINE__, __FILE__, $sql);
							}
							
							while ( $row3 = $db->sql_fetchrow($result2) )
							{
								 add_search_words('single', $row3['post_id'], $row3['post_text'], $row3['post_subject']);
							}
							$db->sql_freeresult($result2);
						}
					}
					$db->sql_freeresult($result);
# 
#-----[ FIND ]------------------------------------------ 
# 
				// Sync the forum indexes
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
				if (!$index_posts)
				{
					remove_search_post($post_id_sql);
				}
# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php
# 
#-----[ FIND ]------------------------------------------ 
# 
	$forum_id = $post_info['forum_id'];
	$forum_name = $post_info['forum_name'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	$post_index = $post_info['index_posts'];

# 
#-----[ FIND ]------------------------------------------ 
# 
submit_post($mode, $post_data, $return_message, $return_meta, $forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, str_replace("\'", "''", $username), str_replace("\'", "''", $subject), str_replace("\'", "''", $message), str_replace("\'", "''", $poll_title), $poll_options, $poll_length);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$post_data
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, $post_index
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_post.php
# 
#-----[ FIND ]------------------------------------------ 
# 
function submit_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id, &$topic_type, &$bbcode_on, &$html_on, &$smilies_on, &$attach_sig, &$bbcode_uid, $post_username, $post_subject, $post_message, $poll_title, &$poll_options, &$poll_length)
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$post_data
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, &$post_index
# 
#-----[ FIND ]------------------------------------------ 
# 
	add_search_words('single', $post_id, stripslashes($post_message), stripslashes($post_subject));
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	if ($post_index)
	{

# 
#-----[ FIND ]------------------------------------------ 
# 
	//
	// Add poll
	// 
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	}

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_forums.php
# 
#-----[ FIND ]------------------------------------------ 
# 
				'S_PRUNE_ENABLED' => $prune_enabled,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				'S_INDEX_POSTS' => ( isset($row) && isset($row['index_posts']) && ($row['index_posts'] == 0) ) ? '' : 'checked="checked"',
# 
#-----[ FIND ]------------------------------------------ 
# 
				'L_DAYS' => $lang['Days'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				'L_INDEX_POSTS' => $lang['index_posts'],
# 
#-----[ FIND ]------------------------------------------ 
# 
prune_enable" . $field_sql
#
#-----[ IN-LINE FIND ]------------------------------------------
#
prune_enable
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# (before the " )
#
, index_posts
# 
#-----[ FIND ]------------------------------------------ 
# 
intval($HTTP_POST_VARS['prune_enable']) . $value_sql
#
#-----[ IN-LINE FIND ]------------------------------------------
#
intval($HTTP_POST_VARS['prune_enable'])
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# (before the . )
#
 . ", " . intval($HTTP_POST_VARS['index_posts'])
# 
#-----[ FIND ]------------------------------------------ 
# 
prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
, index_posts = " . intval($HTTP_POST_VARS['index_posts']) . "
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['prune_freq']
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
$lang['index_posts'] = 'Index posts for searching';
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/forum_edit_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	<tr> 
	  <td class="row1">{L_INDEX_POSTS}</td>
	  <td class="row2">{L_ENABLED}<input type="checkbox" name="index_posts" value="1" {S_INDEX_POSTS} /></td>
	</tr>
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
