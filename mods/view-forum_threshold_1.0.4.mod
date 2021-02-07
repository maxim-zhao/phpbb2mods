##############################################################
## MOD Title: View forum postcount threshold
## MOD Author: Doe Ray Me < admin@drm-hacks.com > (William Shand) http://www.drm-hacks.com
## MOD Description: Allows you to define how many posts are needed to
##                  view a certain forum
## MOD Version:      1.0.4
##
## Installation Level: Intermediate
## Installation Time: 10 Minutes
## Files To Edit:
##         viewtopic.php
##         viewforum.php
##         admin/admin_forums.php
##         language/lang_english/lang_admin.php
##         language/lang_english/lang_main.php
##         templates/subSilver/admin/forum_edit_body.tpl
##
## Included Files:   (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##############################################################
## MOD History:
##
##   2005-03-25 - Version 1.0.4
##      - Fixed a couple of bugs within viewtopic and viewforum
##   2005-03-21 - Version 1.0.3
##      - Fixed bug within admin_forums.php
##   2005-03-13 - Version 1.0.2
##      - Fixed problem with guest viewing when posts are set
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]-------------------------------------------------
#
ALTER TABLE phpbb_forums ADD forum_view_threshold VARCHAR(150) NOT NULL;

#
#-----[ OPEN ]------------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------------
#
$sql = "SELECT t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments" . $count_sql . "

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, f.forum_id

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, f.forum_view_threshold

#
#-----[ FIND ]------------------------------------------------
#
$topic_time = $forum_topic_data['topic_time'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
$forum_view_threshold = $forum_topic_data['forum_view_threshold'];

if ($forum_view_threshold > $userdata['user_posts'])
{
        message_die(GENERAL_MESSAGE, sprintf($lang['Forum_view_threshold_sorry'], $forum_view_threshold));
        
        // Added because of registered user and guest conflict
        if (!$userdata['session_logged_in'])
        {
                 message_die(GENERAL_MESSAGE, sprintf($lang['Forum_view_threshold_sorry'], $forum_view_threshold));
        }
}

#
#-----[ OPEN ]------------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------------
#
// End session management
//
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Forum view Threshold
//
$sql = "SELECT forum_view_threshold 
        FROM " . FORUMS_TABLE . "
        WHERE forum_id = $forum_id";
if(!$result = $db->sql_query($sql))
{
        message_die(GENERAL_ERROR, 'Could not query forum information.', '', __LINE__, __FILE__, $sql);
}
$forum_information = $db->sql_fetchrow($result);
$forum_view = $forum_information['forum_view_threshold'];

if ($forum_view > $userdata['user_posts'])
{
        message_die(GENERAL_MESSAGE, sprintf($lang['Forum_view_threshold_sorry'], $forum_view));

        // Added because of registered user and guest conflict
        if (!$userdata['session_logged_in'])
        {
                 message_die(GENERAL_MESSAGE, sprintf($lang['Forum_view_threshold_sorry'], $forum_view));
        }
}

#
#-----[ OPEN ]------------------------------------------------
#
admin/admin_forums.php

#
#-----[ FIND ]------------------------------------------------
#
$forumstatus = $row['forum_status'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
$forumviewthreshold = $row['forum_view_threshold'];

#
#-----[ FIND ]------------------------------------------------
#
$forumstatus = FORUM_UNLOCKED;

#
#-----[ AFTER, ADD ]------------------------------------------
#
$forumviewthreshold = '';

#
#-----[ FIND ]------------------------------------------------
#
'L_FORUM_STATUS' => $lang['Forum_status'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_FORUM_VIEW_THRESHOLD' => $lang['Forum_view_threshold'],

#
#-----[ FIND ]------------------------------------------------
#
'FORUM_NAME' => $forumname,

#
#-----[ AFTER, ADD ]------------------------------------------
#
'FORUM_VIEW_THRESHOLD' => $forumviewthreshold,

#
#-----[ FIND ]------------------------------------------
#
$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_name, cat_id, forum_desc, forum_order, forum_status, prune_enable" . $field_sql . ")

#
#-----[ IN-LINE FIND ]------------------------------------------------
#
forum_status	
	
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, forum_view_threshold

#
#-----[ FIND ]------------------------------------------
#
VALUES ('" . $next_id . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', $next_order, " . intval($HTTP_POST_VARS['forumstatus']) . ", " . intval($HTTP_POST_VARS['prune_enable']) . $value_sql . ")";

#
#-----[ IN-LINE FIND ]------------------------------------------------
#
" . intval($HTTP_POST_VARS['forumstatus']) . "	
	
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, " . intval($HTTP_POST_VARS['forumviewthreshold']) . "

#
#-----[ FIND ]------------------------------------------
#
SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", forum_desc = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', forum_status = " . intval($HTTP_POST_VARS['forumstatus']) . ", prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "

#
#-----[ IN-LINE FIND ]------------------------------------------------
#
, forum_status = " . intval($HTTP_POST_VARS['forumstatus']) . "	
	
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, forum_view_threshold = " . intval($HTTP_POST_VARS['forumviewthreshold']) . "

#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------------
#
$lang['Forum_status'] = 'Forum status';

#
#-----[ AFTER, ADD ]-----------------------------------------
#
$lang['Forum_view_threshold'] = 'Forum View Postcount Threshold';

#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------
#
//
// That's all, Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]-----------------------------------------
#
//Forum View Threshold
$lang['Forum_view_threshold_sorry'] = 'Sorry, you need <b>%d Posts</b> to view this forum';

#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/admin/forum_edit_body.tpl

#
#-----[ FIND ]------------------------------------------------
#
	<tr> 
		<td class="row1">{L_FORUM_STATUS}</td>
		<td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>
	
#
#-----[ AFTER, ADD ]-----------------------------------------
#
	<tr> 
		<td class="row1">{L_FORUM_VIEW_THRESHOLD}</td>
		<td class="row2"><input type="text" size="25" name="forumviewthreshold" value="{FORUM_VIEW_THRESHOLD}" class="post" /></td>
	</tr>
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
