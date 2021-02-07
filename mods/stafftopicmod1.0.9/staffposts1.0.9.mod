##############################################################
## MOD Title: Staff Posts
## MOD Author: tehbmwman < tehbmwman@gmail.com > (N/A) N/A
## MOD Description: Adds the option for moderators of a forum to post a topic in the forum
##					that can only be viewed by other moderators.
## MOD Version: 1.0.9
##
## Installation Level: Intermediate
## Installation Time: ~15 Minutes
## Files To Edit: posting.php,
##      		  viewforum.php,
##				  viewtopic.php,
##      		  modcp.php,
##				  search.php,
##				  index.php,
##				  includes/functions_post.php
##				  language/lang_english/lang_main.php,
##				  templates/subSilver/subSilver.cfg,
##				  templates/subSilver/viewforum_body.tpl,
##				  templates/subSilver/posting_body.tpl
## Included Files: staff.png,
##				   new_staff.png
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: A simple mod that is very useful. The staff topics can only be posted
##				 by moderators of the forum and can only be viewed by moderators of the forum.
##				 Topics can be normal, sticky, or announcement.
##
##############################################################
## MOD History:
##
##   2005-11-20 - Version 1.0.0
##      - Initial Submission
##	 2006-01-29 - Version 1.0.3
##		- After a long ignorance, finally came back to this mod and
##		  completely revamped it. 
##	 2006-01-30 - Version 1.0.5
##		- Noticed that it would mark forums unread and lead to the staff
##		  post from index.php
##		- Did not show correct amount of topics per page.
##	 2006-02-01 - Version 1.0.6
##		- Fixed: Said "Staff" instead of "Staff:" when searching
##		- Fixed: Error in FIND before final AFTER, ADD
##	 2006-02-11 - Version 1.0.7
##		- Fixed: A few minor bugs.
##	 2006-03-15 - Version 1.0.9
##		- Fixed: Small issues, XHTML compliency.
##		- Fixed: Pagination errors
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]-------------------------------------------
#
# Instead of making it another topic type, another column makes it 
# possible for a staff topic to be normal, sticky, or announcement
# and is easier to code.
#
ALTER TABLE `phpbb_topics` ADD `topic_staff` TINYINT DEFAULT '0' NOT NULL;
#
#-----[ COPY ]------------------------------------------
#
copy staff.png to templates/subSilver/images/staff.png
copy new_staff.png to templates/subSilver/images/new_staff.png
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------
#
$images['folder_announce_new'] = "$current_template_images/folder_announce_new.gif";
#
#-----[ AFTER, ADD ]------------------------------------
#

//
// Staff Topic Mod
//
$images['folder_staff'] = "$current_template_images/staff.png";
$images['folder_staff_new'] = "$current_template_images/new_staff.png";

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
//
// Posting/Replying (Not private messaging!)
//
#
#-----[ BEFORE, ADD ]-----------------------------------
#
//
// Staff Topic Mod
//
$lang['STAFF_prefix'] = '<b>Staff:</b> ';
$lang['STAFF_checkbox'] = 'Staff Only';
$lang['STAFF_topic'] = 'Staff';

#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT f.*, t.topic_status,
#
#-----[ IN-LINE FIND ]----------------------------------
#
t.topic_type
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, t.topic_staff
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT f.*, t.topic_id,
#
#-----[ IN-LINE FIND ]----------------------------------
#
t.topic_vote,
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 t.topic_staff,
#
#-----[ FIND ]------------------------------------------
#
if ( $post_info['forum_status'] == FORUM_LOCKED && !$is_auth['auth_mod'])
#
#-----[ BEFORE, ADD ]------------------------------------
#
	if ( $post_info['topic_staff'] && $userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD ) 
	{
		message_die(GENERAL_MESSAGE, $lang['Topic_post_not_exist']);
	}
#
#-----[ FIND ]------------------------------------------
#
$attach_sig = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['attach_sig']) ) ? TRUE : 0 ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? 0 : $userdata['user_attachsig'] );
#
#-----[ AFTER, ADD ]------------------------------------
#
if ( ($submit || $refresh) && ($userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD) )
{
	$stafftopic = ( !empty($HTTP_POST_VARS['staff']) ) ? TRUE : 0;
}
else
{
	$stafftopic = 0;
}
#
#-----[ FIND ]------------------------------------------
#
submit_post(
#
#-----[ IN-LINE FIND ]----------------------------------
#
$poll_length
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, $stafftopic
#
#-----[ FIND ]------------------------------------------
#
	$template->assign_block_vars('switch_delete_checkbox', array());
}
#
#-----[ AFTER, ADD ]------------------------------------
#

//
// Staff Topic Selection
//
if ( ($userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD) && ( $mode == 'newtopic' || ($mode == 'editpost' && $post_data['first_post'])))
{
	if ( $post_info['topic_staff'] ) 
	{
		$staff_checked = 'checked="checked"';
	}
	else 
	{
		$staff_checked = '';
	}
	$template->assign_block_vars('switch_staff_checkbox', array(
	'CHECKED' => $staff_checked,
	'LANGUAGE' => $lang['STAFF_checkbox'])
	);
}
#
#-----[ OPEN ]------------------------------------------
#
viewforum.php
#
#-----[ FIND ]------------------------------------------
#
// handle pagination) and alter the main query
//
#
#-----[ AFTER, ADD ]------------------------------------
#
$see_staff = ( $userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD ) ? ' AND t.topic_staff = 0' : '';
#
#-----[ FIND ]------------------------------------------
#
		WHERE t.forum_id = $forum_id 
			AND p.post_id = t.topic_last_post_id
#
#-----[ AFTER, ADD ]------------------------------------
#
			$see_staff
#
#-----[ FIND ]------------------------------------------
#
$topics_count = ( $forum_row
#
#-----[ AFTER, ADD ]------------------------------------
#
	$sql = 'SELECT COUNT(topic_id) AS staff_topics 
			FROM ' . TOPICS_TABLE . ' 
			WHERE forum_id = ' . $forum_id . ' 
			AND topic_staff = 1';
	if (!$result = $db->sql_query($sql))
	{
		message_die( GENERAL_ERROR, 'Couldnt query topics table', '', __LINE__, __FILE__, $sql );
	}
	$info = $db->sql_fetchrow($result);
	$staff_topics = ( $userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD ) ? $info['staff_topics'] : 0;
	$topics_count -= $staff_topics;
#
#-----[ FIND ]------------------------------------------
#
AND p.poster_id = u2.user_id
#
#-----[ IN-LINE FIND ]----------------------------------
#
u2.user_id
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 $see_staff
#
#-----[ FIND ]------------------------------------------
#
AND p.post_id = t.topic_first_post_id
#
#-----[ IN-LINE FIND ]----------------------------------
#
t.topic_first_post_id
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 $see_staff
#
#-----[ FIND ]------------------------------------------
#
make_jumpbox(
#
#-----[ AFTER, ADD ]------------------------------------
#
if ($userdata['user_level']== ADMIN || $userdata['user_level'] == MOD)
{
	$template->assign_block_vars('staff_posts', array(
		'FOLDER_STAFF_IMG' => $images['folder_staff'],
		'L_STAFF' => $lang['STAFF_checkbox'])
		);
}
#
#-----[ FIND ]------------------------------------------
#
			$topic_type = '';		
		}
#
#-----[ AFTER, ADD ]------------------------------------
#
		if( $topic_rowset[$i]['topic_staff'] ) 
		{
			$topic_type = $lang['STAFF_prefix'];
		}
#
#-----[ FIND ]------------------------------------------
#
					$folder_new = $images['folder_new'];
				}
			}
#
#-----[ AFTER, ADD ]------------------------------------
#
			if ( $topic_rowset[$i]['topic_staff'] )
			{
				$folder = $images['folder_staff'];
				$folder_new = $images['folder_staff_new'];
			}
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewforum_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<td class="gensmall">{L_NO_NEW_POSTS_LOCKED}
#
#-----[ AFTER, ADD ]------------------------------------
#
<!-- BEGIN staff_posts -->
<td>&nbsp;&nbsp;</td>
<td class="gensmall"><img src="{staff_posts.FOLDER_STAFF_IMG}" alt="{L_STAFF}" width="19" height="18" /></td>
<td class="gensmall">{staff_posts.L_STAFF}</td>
<!-- END staff_posts -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- END switch_delete_checkbox -->
#
#-----[ AFTER, ADD ]------------------------------------
#
		  <!-- BEGIN switch_staff_checkbox -->
		  <tr>
		  	<td>
		  	  <input type="checkbox" name="staff" {switch_staff_checkbox.CHECKED} />
		  	</td>
		  	<td><span class="gen">{switch_staff_checkbox.LANGUAGE}</span></td>
		  </tr>
		  <!-- END switch_staff_checkbox -->
		  <!-- BEGIN switch_hidden_staff -->
		  <input type="hidden" name="staff" value="1">
		  <!-- END switch_hidden_staff -->
#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
#
function submit_post(
#
#-----[ IN-LINE FIND ]----------------------------------
#
&$poll_length
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, &$stafftopic
#
#-----[ FIND ]------------------------------------------
#
	include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

	$current_time = time();
#
#-----[ AFTER, ADD ]------------------------------------
#
	if (($mode == 'reply') || ($mode == 'editpost' && !$post_data['first_post']))
	{
		$sql = 'SELECT topic_staff 
				FROM ' . TOPICS_TABLE . ' 
				WHERE topic_id = ' . $topic_id;
		if ($result = $db->sql_query($sql)) 
		{
			$stafftopic = ( $result['topic_staff'] ) ? '1' : '0';
		}
	}
	if (($mode == 'newtopic') && (!$userdata['user_level']))
	{
		$stafftopic = '0';
	}
#
#-----[ FIND ]------------------------------------------
#
$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE
#
#-----[ IN-LINE FIND ]----------------------------------
#
topic_type, topic_vote
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, topic_staff
#
#-----[ IN-LINE FIND ]----------------------------------
#
$topic_vote
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, $stafftopic
#
#-----[ IN-LINE FIND ]----------------------------------
#
$topic_vote : "") . "
#
#-----[ IN-LINE AFTER, ADD ]---------------------------
#
, topic_staff = $stafftopic 
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT t.topic_id, t.topic_title
#
#-----[ IN-LINE FIND ]----------------------------------
#
t.topic_last_post_id,
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
t.topic_staff, 
#
#-----[ FIND ]------------------------------------------
#
if( !$is_auth['auth_view'] || !$is_auth['auth_read'] )
#
#-----[ BEFORE, ADD ]-----------------------------------
#
$staff_topic = $forum_topic_data['topic_staff'];
if ( $userdata['user_level'] != MOD && $userdata['user_level'] != ADMIN && $staff_topic )
{
	message_die(GENERAL_MESSAGE, $lang['Topic_post_not_exist']);
}
#
#-----[ OPEN ]------------------------------------------
#
modcp.php
#
#-----[ FIND ]------------------------------------------
#
					$folder_alt = $lang['No_new_posts'];
				}
#
#-----[ AFTER, ADD ]------------------------------------
#
				if ( $row['topic_staff'] )
				{
					$folder_img = $images['folder_staff'];
					$folder_alt = $lang['STAFF_topic'];
				}
#
#-----[ FIND ]------------------------------------------
#
				$topic_type = '';		
			}
#
#-----[ AFTER, ADD ]------------------------------------
#
			if ( $row['topic_staff'] )
			{
				$topic_type = $lang['STAFF_prefix'];
			}
#
#-----[ OPEN ]------------------------------------------
#
search.php
#
#-----[ FIND ]------------------------------------------
#
	if ( $search_results != '' )
	{
#
#-----[ AFTER, ADD ]------------------------------------
#
		$showstaff = ( $userdata['user_level'] != MOD && $userdata['user_level'] != ADMIN ) ? 'AND t.topic_staff = 0' : '';
#
#-----[ FIND ]------------------------------------------
#
WHERE p.post_id IN ($search_results)
#
#-----[ IN-LINE FIND ]----------------------------------
#
($search_results)
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 $showstaff
#
#-----[ FIND ]------------------------------------------
#
WHERE t.topic_id IN ($search_results)
#
#-----[ IN-LINE FIND ]----------------------------------
#
($search_results)
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 $showstaff
#
#-----[ FIND ]------------------------------------------
#
$topic_type = '';
#
#-----[ AFTER, ADD ]------------------------------------
#
				if ( $searchset[$i]['topic_staff'] ) 
				{
					$topic_type = $lang['STAFF_prefix'] . ' ';
				}
#
#-----[ FIND ]------------------------------------------
#
							$folder_new = $images['folder_new'];
						}
					}
#
#-----[ AFTER, ADD ]------------------------------------
#
				if ( $searchset[$i]['topic_staff'] ) 
				{
					$folder = $images['folder_staff'];
					$folder_new = $images['folder_staff_new'];
				}
#
#-----[ OPEN ]------------------------------------------
#
index.php
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT t.forum_id,
#
#-----[ BEFORE, ADD ]-----------------------------------
#
		$checkstaff = ($userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD) ? ' AND t.topic_staff = 0' : '';
#
#-----[ FIND ]------------------------------------------
#
WHERE p.post_id = t.topic_last_post_id
#
#-----[ IN-LINE FIND ]----------------------------------
#
t.topic_last_post_id
#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 $checkstaff
#
#
#-----[ FIND ]------------------------------------------
#
$posts =
#
#-----[ BEFORE, ADD ]-----------------------------------
#
							if ($userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD)
							{
								$sql = 'SELECT topic_id 
										FROM ' . TOPICS_TABLE . ' 
										WHERE topic_staff = 1';
								if (!$result = $db->sql_query($sql))
								{
									message_die(GENERAL_ERROR,'Could not find topic information','',__LINE__,__FILE__,$sql);
								}
								$topic = $db->sql_fetchrowset($result);
								for ($k = 0; isset($topic[$k]); $k++)
								{
									$forum_data[$j]['forum_topics']--;
									
									$sql = 'SELECT post_id 
											FROM ' . POSTS_TABLE . ' 
											WHERE topic_id = ' . $topic[$k]['topic_id'];
									if (!$result = $db->sql_query($sql))
									{
										message_die(GENERAL_ERROR,'Could not find post information','',__LINE__,__FILE__,$sql);
									}
									
									$forum_data[$j]['forum_posts'] -= $db->sql_numrows($result);
									
								}
							}
#
#-----[ FIND ]------------------------------------------
#
	if ( $forum_data[$j]['forum_last_post_id'] )
	{
#
#-----[ AFTER, ADD ]------------------------------------
#
								if ($userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD)
								{
									$sql = 'SELECT topic_last_post_id 
											FROM ' . TOPICS_TABLE . ' 
											WHERE forum_id = ' . $forum_id . ' 
											AND topic_staff = 0 
											ORDER BY topic_last_post_id DESC LIMIT 0,1';
									if (!$result = $db->sql_query($sql))
									{
										message_die(GENERAL_ERROR, 'Could not get topic information','',__LINE__,__FILE__,$sql);
									}
									$topicinfo = $db->sql_fetchrow($result);
									
									$sql = 'SELECT post_id, post_time, poster_id 
											FROM ' . POSTS_TABLE . ' 
											WHERE post_id = ' . $topicinfo['topic_last_post_id'];
									$db->sql_freeresult($result);
									if (!$result = $db->sql_query($sql))
									{
										message_die(GENERAL_ERROR, 'Could not get post information','',__LINE__,__FILE__,$sql);
									}
									$last_post_info = $db->sql_fetchrow($result);
									
									
									$db->sql_freeresult($result);
									$forum_data[$j]['post_time'] = $last_post_info['post_time'];
									$forum_data[$j]['user_id'] = $last_post_info['poster_id'];
									
									
									$sql = 'SELECT username 
											FROM . ' . USERS_TABLE . ' 
											WHERE user_id = ' . $last_post_info['poster_id'];
									if (!$result = $db->sql_query($sql))
									{
										message_die(GENERAL_ERROR, 'Could not open users table','',__LINE__,__FILE__,$sql);
									}
									$userinfo = $db->sql_fetchrow($result);
									
									$forum_data[$j]['post_username'] = $userinfo['username'];
									$forum_data[$j]['username'] = $userinfo['username'];
									$forum_data[$j]['forum_last_post_id'] = $last_post_info['post_id'];
								}
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM