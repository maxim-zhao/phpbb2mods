############################################################## 
## MOD Title: Thanks Mod for PhpBB With CH 2.1.x
## MOD Author: Kinfule < kinfule@lycos.es > (Javier B) http://kinfule.tk 
## MOD Description: This mod will add a feature for thanking the poster for his/her post.
##		    This mod is will work only if you have Categories Hierarchy - v2
##					
## MOD Version: 1.0.5
## 
## Installation Level: Intermediate 
## Installation Time: 20 Minutes
## Files To Edit: 11
##                admin/admin_forums.php,
##								modcp.php,
##                posting.php,
##                viewtopic.php,
##                includes/constants.php,
##								includes/forums_class.php
##                includes/functions.php,
##								includes/functions_post.php,
##                langugage/lang_english/lang_main.php,
##                langugage/lang_english/lang_admin.php,
##                templates/subSilver/viewtopic_body.tpl,
## Included Files: 1
##								templates/subSilver/images/lang_english/thanks.gif	
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
## 		  - You can edit a variable to choose auth_type default is auth_read.
##		  - It uses it own date format to chage the format, edit $timeformat value to another one.
##		  - This MOD needs to be enabled on a per forum basis.
##		  - This mod is will work only if you have Categories Hierarchy - v2.1.*
## 
############################################################## 
## MOD History: 
##   2005-08-15 - Version 1.0.0 
##      	- First Release
##		- This is the v1.1.5 of the original Thank mod.
##		- Made it work with CH v2.
##
##   2005-08-19 - Removed the edit_forum.tpl part cause it was not nessesary.
##		- Fixed some stuff in viewtopic.php
##
##   2005-12-06 - Version 1.0.4
##			- PhpBB Mod Template fixes.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
##
#
#-----[ COPY ]------------------------------------------
#
copy templates/subSilver/images/lang_english/thanks.gif to templates/subSilver/images/lang_english/thanks.gif
#
#-----[ SQL ]------------------------------------------
#
CREATE TABLE `phpbb_thanks` (
`topic_id` MEDIUMINT(8) NOT NULL,
`user_id` MEDIUMINT(8) NOT NULL,
`thanks_time` INT(11) NOT NULL
);

ALTER TABLE `phpbb_forums` ADD `forum_thank` TINYINT(1) DEFAULT '0' NOT NULL;

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_forums.php

# 
#-----[ FIND ]------------------------------------------ 
#
$forum_status = array(
	FORUM_UNLOCKED => 'Status_unlocked',
	FORUM_LOCKED => 'Status_locked',
);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$forum_thank = array(
	FORUM_THANKABLE => 'Yes',
	FORUM_UNTHANKABLE => 'No',
);

# 
#-----[ FIND ]------------------------------------------ 
#
'forum_status' => array('type' => 'radio_list', 'legend' => 'Forum_status', 'field' => 'forum_status', 'options' => $forum_status),

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
'forum_thank' => array('type' => 'radio_list', 'legend' => 'use_thank', 'field' => 'forum_thank', 'options' => $forum_thank),

# 
#-----[ FIND ]------------------------------------------ 
#
'forum_type', 'forum_name', 'forum_desc', 'forum_status',
		
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
, 'forum_status'

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, 'forum_thank'

# 
#-----[ OPEN ]------------------------------------------ 
#
modcp.php

# 
#-----[ FIND ]------------------------------------------ 
#
			$sql = "DELETE 
				FROM " . TOPICS_TABLE . " 
				WHERE topic_id IN ($topic_id_sql) 
					OR topic_moved_id IN ($topic_id_sql)";
			if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not delete topics', '', __LINE__, __FILE__, $sql);
			}

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
			$sql = "DELETE FROM " . THANKS_TABLE . "
				       WHERE topic_id IN ($topic_id_sql)";
				 if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
				 {
					     message_die(GENERAL_ERROR, 'Error in deleting Thanks post Information', '', __LINE__, __FILE__, $sql);
				 } 

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]---------------------------------
#
$forum_id = intval($forum_topic_data['forum_id']);

#
#-----[ AFTER, ADD ]---------------------------------
#
// Begin Thanks Mod
  // Setting if feature is active or not 
$show_thanks = ($forums->data[$forum_id]['forum_thank'] == FORUM_THANKABLE) ? FORUM_THANKABLE : FORUM_UNTHANKABLE;
// End Thanks Mod

#
#-----[ FIND ]---------------------------------
#
$reply_topic_url = append_sid("posting.$phpEx?mode=reply&amp;" . POST_TOPIC_URL . "=$topic_id");

#
#-----[ AFTER, ADD ]---------------------------------
#
// Begin Thanks Mod
$thank_topic_url = append_sid("posting.$phpEx?mode=thank&amp;" . POST_TOPIC_URL . "=$topic_id");
// End Thanks Mod

#
#-----[ FIND ]---------------------------------
#
$post_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $images['post_locked'] : $images['post_new'];
$post_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'];

#
#-----[ AFTER, ADD ]---------------------------------
#
// Begin Thanks Mod
$thank_img = $images['thanks'];
$thank_alt = $lang['thanks_alt'];
// End Thanks Mod

#
#-----[ FIND ]---------------------------------
# This is a partial line the complete line is much longer
#
$pagination =

#
#-----[ AFTER, ADD ]---------------------------------
#
$current_page = get_page($total_replies, $board_config['posts_per_page'], $start);

#
#-----[ FIND ]---------------------------------
#
//
// Update the topic view counter
//
$sql = "UPDATE " . TOPICS_TABLE . "
	SET topic_views = topic_views + 1
	WHERE topic_id = $topic_id";
if ( !$db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not update topic views.", '', __LINE__, __FILE__, $sql);
}
#
#-----[ AFTER, ADD ]---------------------------------
#
// Begin Thanks Mod
//
// Get topic thanks
//
if ($show_thanks == FORUM_THANKABLE)
{
	// Select Format for the date
	$timeformat = "d-m, G:i";

	$sql = "SELECT u.user_id, u.username, t.thanks_time
		 FROM " . THANKS_TABLE . " t, " . USERS_TABLE . " u
		 WHERE topic_id = $topic_id
		 AND t.user_id = u.user_id";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain thanks information", '', __LINE__, __FILE__, $sql);
	}

	$total_thank = $db->sql_numrows($result);
	$thanksrow = array();
	$thanksrow = $db->sql_fetchrowset($result);

	for($i = 0; $i < $total_thank; $i++)
	{
		$topic_thanks = $db->sql_fetchrow($result);
		$thanker_id[$i] = $thanksrow[$i]['user_id'];
		$thanker_name[$i] = $thanksrow[$i]['username'];
		$thanks_date[$i] = $thanksrow[$i]['thanks_time'];

		// Get thanks date
		$thanks_date[$i] = create_date($timeformat, $thanks_date[$i], $board_config['board_timezone']);

		// Make thanker profile link
		$thanker_profile[$i] = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$thanker_id[$i]");   
		$thanks .= '<a href="' .$thanker_profile[$i] . '">' . $thanker_name[$i] . '</a>(' . $thanks_date[$i] . '), ';
		
		if ($userdata['user_id'] == $thanksrow[$i]['user_id'])
		{
			$thanked = TRUE;
		}
	}

	$sql = "SELECT u.topic_poster, t.user_id, t.username
			FROM " . TOPICS_TABLE . " u, " . USERS_TABLE . " t
			WHERE topic_id = $topic_id
			AND u.topic_poster = t.user_id";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain user information", '', __LINE__, __FILE__, $sql);
	}

	if( !($autor = $db->sql_fetchrowset($result)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain user information", '', __LINE__, __FILE__, $sql);
	}	

	$autor_name = $autor[0]['username'];
	$thanks .= "".$lang['thanks_to']." $autor_name ".$lang['thanks_end']."";

	// Create button switch
	if ($userdata['user_id'] != $autor['0']['user_id'] && !$thanked)
	{
		$template->assign_block_vars('thanks_button', array(
			 'THANK_IMG' => $thank_img,
			 'U_THANK_TOPIC' => $thank_topic_url,
			 'L_THANK_TOPIC' => $thank_alt
		));
	}	

}
// End Thanks Mod

#
#-----[ FIND ]---------------------------------
#
	$template->set_switch('postrow.light', !($i % 2));
	$template->set_switch('postrow.unmark_read', $cookie_setup['keep_unreads']);

#
#-----[ AFTER, ADD ]---------------------------------
#
	// Begin Thanks Mod
	if( ($show_thanks == FORUM_THANKABLE) && ($i == 0) && ($current_page == 1) && ($total_thank > 0))
	{
		$template->assign_block_vars('postrow.thanks', array(
		'THANKFUL' => $lang['thankful'],
		'THANKED' => $lang['thanked'],
		'HIDE' => $lang['hide'],
		'THANKS_TOTAL' => $total_thank,
		'THANKS' => $thanks
		)
		);

	}
	// End Thanks Mod

#
#-----[ OPEN ]---------------------------------
#
posting.php

#
#-----[ FIND ]---------------------------------
#
		case 'topicreview':
		$is_auth_type = 'auth_read';
		break;

#
#-----[ AFTER, ADD ]---------------------------------
#
		case 'thank':
		$is_auth_type = 'auth_read';
		break;

#
#-----[ FIND ]---------------------------------
#
	case 'reply':
	case 'vote':

#-----[ BEFORE, ADD ]---------------------------------
	case 'thank':

#
#-----[ FIND ]---------------------------------
#
	else if ( $mode != 'newtopic' && $post_info['topic_status'] == TOPIC_LOCKED && !$is_auth['auth_mod'])

#
#-----[ IN-LINE FIND ]---------------------------------
#
 $mode != 'newtopic'

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
  &&  $mode != 'thank'

#
#-----[ FIND ]---------------------------------
#
		case 'reply':
		case 'topicreview':

#
#-----[ BEFORE, ADD ]---------------------------------
#
		case 'thank':

#
#-----[ FIND ]---------------------------------
#
else if ( $mode == 'vote' )
{

#
#-----[ BEFORE, ADD ]---------------------------------
#
else if ( $mode == 'thank' )
{
   $topic_id = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
      if ( !($userdata['session_logged_in']) )
      {
         $message = $lang['thanks_not_logged'];
         $message .=  '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');
         message_die(GENERAL_MESSAGE, $message);
      }
      if ( empty($topic_id) )
      {
         message_die(GENERAL_MESSAGE, 'No topic Selected');
      }

      $userid = $userdata['user_id'];
      $thanks_date = time();

      // Check if user is the topic starter
      $sql = "SELECT `topic_poster`
            FROM " . TOPICS_TABLE . "
            WHERE `topic_id` = $topic_id
            AND `topic_poster` = $userid";
      if ( !($result = $db->sql_query($sql)) )
      {
         message_die(GENERAL_ERROR, "Couldn't check for topic starter", '', __LINE__, __FILE__, $sql);
               
      }

      if ( ($topic_starter_check = $db->sql_fetchrow($result)) )
      {
         $message = $lang['t_starter'];
         $message .=  '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');
         message_die(GENERAL_MESSAGE, $message);
      }

      // Check if user had thanked before
      $sql = "SELECT `topic_id`
            FROM " . THANKS_TABLE . "
            WHERE `topic_id` = $topic_id
            AND `user_id` = $userid";
      if ( !($result = $db->sql_query($sql)) )
      {
         message_die(GENERAL_ERROR, "Couldn't check for previous thanks", '', __LINE__, __FILE__, $sql);
               
      }
      if ( !($thankfull_check = $db->sql_fetchrow($result)) )
      {
         // Insert thanks if he/she hasn't
         $sql = "INSERT INTO " . THANKS_TABLE . " (`topic_id`, `user_id`, `thanks_time`)
         VALUES ('" . $topic_id . "', '" . $userid . "', " . $thanks_date . ") ";
         if ( !($result = $db->sql_query($sql)) )
         {
            message_die(GENERAL_ERROR, "Could not insert thanks information", '', __LINE__, __FILE__, $sql);
               
         }
         $message = $lang['thanks_add'];
      }
      else
      {
         $message = $lang['thanked_before'];
      }

      $template->assign_vars(array(
         'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">')
      );

      $message .=  '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id") . '">', '</a>');
      
      message_die(GENERAL_MESSAGE, $message);   
} 

#
#-----[ OPEN ]---------------------------------
#
includes/constants.php

#
#-----[ FIND ]---------------------------------
#
define('FORUM_UNLOCKED', 0);
define('FORUM_LOCKED', 1);

#
#-----[ AFTER, ADD ]---------------------------------
#

// Forum Thanks state
define('FORUM_UNTHANKABLE', 0);
define('FORUM_THANKABLE', 1);

#
#-----[ FIND ]---------------------------------
#
define('SMILIES_TABLE', $table_prefix.'smilies');

#
#-----[ AFTER, ADD ]---------------------------------
#
define('THANKS_TABLE', $table_prefix.'thanks');

# 
#-----[ OPEN ]------------------------------------------ 
#
includes/class_forums.php

# 
#-----[ FIND ]------------------------------------------ 
#
'forum_board_box',

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
'forum_thank',


#
#-----[ OPEN ]---------------------------------
#
includes/functions.php

#
#-----[ FIND ]---------------------------------
#
function generate_pagination

#
#-----[ BEFORE, ADD ]---------------------------------
#
function get_page($num_items, $per_page, $start_item)
{

	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '1';
		exit;
	}

	$on_page = floor($start_item / $per_page) + 1;
	$page_string = '';

	for($i = 0; $i < $total_pages + 1; $i++)
	{
		if( $i == $on_page ) 
		{
			$page_string = $i;
		}
		
	}
	return $page_string;
}

#
#-----[ OPEN ]---------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]---------------------------------
#
				$sql = "DELETE FROM " . TOPICS_TABLE . " 
					WHERE topic_id = $topic_id 
						OR topic_moved_id = $topic_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
				}

#
#-----[ AFTER, ADD ]---------------------------------
#

			$sql = "DELETE FROM " . THANKS_TABLE . "
				WHERE topic_id = $topic_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Error in deleting Thanks post Information', '', __LINE__, __FILE__, $sql);
			}

#
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php
    
#
#-----[ FIND ]---------------------------------
#
//
// That's all Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
// Begin Thanks Mod
$lang['use_thank'] = 'Allow to Thank posts';
// End Thanks Mod

#
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
    
#
#-----[ FIND ]---------------------------------
#
//
// That's all, Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
// Begin Thanks Mod
$lang['thankful'] = 'Thankful People';
$lang['thanks_to'] = 'Thanks';
$lang['thanks_end'] = 'for his/her post';
$lang['thanks_alt'] = 'Thank Post';
$lang['thanked_before'] = 'You have already thanked this topic';
$lang['thanks_add'] = 'Your thanks has been given';
$lang['thanks_not_logged'] = 'You need to log in to thank someone\'s post';
$lang['thanked'] = 'user(s) is/are thankful for this post.';
$lang['hide'] = 'Hide';
$lang['t_starter'] = 'You cannot thank yourself'; 
// End Thanks Mod

#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/subSilver.cfg

#
#-----[ FIND ]---------------------------------
#
$images['reply_locked'] = "$current_template_images/{LANG}/reply-locked.gif";

#
#-----[ AFTER, ADD ]---------------------------------
#
$images['thanks'] = "$current_template_images/{LANG}/thanks.gif";

#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]---------------------------------
# This is a partial line, the complete line is much longer
#
<a href="{U_POST_NEW_TOPIC}">

#
#-----[ IN-LINE FIND ]---------------------------------
#
</a></span></td>

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
</a>
#
#-----[ AFTER, ADD ]---------------------------------
#
<!-- BEGIN thanks_button -->
&nbsp;&nbsp;&nbsp;<a href="{thanks_button.U_THANK_TOPIC}"><img src="{thanks_button.THANK_IMG}" border="0" alt="{thanks_button.L_THANK_TOPIC}" align="middle" /></a>
<!-- END thanks_button -->
</span></td>

#
#-----[ FIND ]---------------------------------
#
	<!-- END postrow -->

#
#-----[ BEFORE, ADD ]---------------------------------
#
	<!-- BEGIN thanks -->
	<tr>
		<td colspan="2" class="row2">
			<table class="forumline" cellspacing="1" cellpadding="3" border="0" width="100%">
				<tr>
					<th class="thLeft">{postrow.thanks.THANKFUL}</th>
				</tr>
				<tr>
					<td class="row2" valign="top" align="left">
						<span id="hide_thank" style="display: block;" class="gensmall">
						<a href="javascript: void(0);" onclick="document.all.show_thank.style.display = 'block';document.all.hide_thank.style.display = 'none'">{postrow.thanks.THANKS_TOTAL}</a> {postrow.thanks.THANKED}			
						</span>
						<span id="show_thank" style="display: none;" class="gensmall">
							{postrow.thanks.THANKS}&nbsp;
							<br /><br /><div align="right"><a href="javascript: void(0);" onClick="document.all.show_thank.style.display = 'none';document.all.hide_thank.style.display = 'block'">[ {postrow.thanks.HIDE} ]</a></div>
						</span>
					</td>	
				</tr>
			</table>
		</td>
	</tr>
	<!-- END thanks -->

#
#-----[ FIND ]---------------------------------
# This is a partial line, the complete line is much longer
#
<a href="{U_POST_NEW_TOPIC}">

#
#-----[ IN-LINE FIND ]---------------------------------
#
</a></span></td>


# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
</a>
#
#-----[ AFTER, ADD ]---------------------------------
#
<!-- BEGIN thanks_button -->
&nbsp;&nbsp;&nbsp;<a href="{thanks_button.U_THANK_TOPIC}"><img src="{thanks_button.THANK_IMG}" border="0" alt="{thanks_button.L_THANK_TOPIC}" align="middle" /></a>
<!-- END thanks_button -->
</span></td>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM