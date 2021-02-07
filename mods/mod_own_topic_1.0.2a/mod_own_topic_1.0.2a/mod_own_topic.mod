############################################################## 
## MOD Title: Moderate Own Topics
## MOD Author: Kinfule < kinfule@lycos.com > (Javier B) http://kinfule.tk 
## MOD Description: Allow Admins to grant users the ability to moderate their own topics using the PhpbB2 Auth system.
##
## MOD Version: 1.0.2
## 
## Installation Level: Intermediate
## Installation Time: 20 Minutes 
## Files To Edit:  10
##		- admin/admin_forumauth.php
##		- admin/admin_ug_auth.php
##		- includes/auth.php
##		- includes/constants.php
##		- language/lang_english/lang_admin.php
##		- language/lang_english/lang_main.php
##		- viewforum.php
##		- posting.php
##		- viewtopic.php
##		- modcp.php
## Included Files: n/a
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
##		This MOD uses the PhpBB2 auth system so admins can select in what forums 
##		users or usergroups can moderate their own topics.
##		Also they cannot see IPs.
## 
############################################################## 
## MOD History: 
## 
##   2005-09-11 - Version 0.0.1 
##		- First Public Alpha
##		- Tmods can edit/delete posts in their topics.
##		- Tmods CAN'T see ips.
##
##   2005-11-28 - Version 0.1.1 
##		- Second Public Alpha
##		- Tmods can delete/lock/split their topics
## 
##   2005-12-05 - Version 0.1.2 
##		- Tmods cannot unlock a topic locked by and admin/mod
##
##   2006-03-24 - Version 1.0.0 
##		- Small improves.
##
##   2006-04-26 - Version 1.0.1 
##		- Added the license line.
##
##   2006-05-08 - Version 1.0.2 
##		- Fixed a security bug in modcp.php
##		- Fixed a bug in viewtopic.php
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
#
 ALTER TABLE `phpbb_auth_access` ADD `auth_tmod` TINYINT(1) NOT NULL;
 ALTER TABLE `phpbb_forums` ADD `auth_tmod` TINYINT(1) DEFAULT '3' NOT NULL;
 ALTER TABLE `phpbb_topics` ADD `topic_locker` TINYINT(1) DEFAULT '0' NOT NULL;

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_forumauth.php

# 
#-----[ FIND ]------------------------------------------ 
#
//                View      Read      Post      Reply     Edit     Delete    Sticky   Announce    Vote      Poll
$simple_auth_ary = array(
	0  => array(AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	1  => array(AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	2  => array(AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	3  => array(AUTH_ALL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL),
	4  => array(AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL),
	5  => array(AUTH_ALL, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
	6  => array(AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
);

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
//                View      Read      Post      Reply     Edit     Delete    Sticky   Announce    Vote      Poll	TMOD
$simple_auth_ary = array(
	0  => array(AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG, AUTH_MOD),
	1  => array(AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG, AUTH_MOD),
	2  => array(AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG, AUTH_MOD),
	3  => array(AUTH_ALL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL, AUTH_MOD),
	4  => array(AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL, AUTH_MOD),
	5  => array(AUTH_ALL, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
	6  => array(AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
);

# 
#-----[ FIND ]------------------------------------------ 
#
$forum_auth_fields =

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
'auth_pollcreate'

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, 'auth_tmod'


# 
#-----[ FIND ]------------------------------------------ 
#
	'auth_vote' => $lang['Vote'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	'auth_tmod' => $lang['tmod'],

# 
#-----[ FIND ]------------------------------------------ 
#
$sql .= ( ( $sql != '' ) ? ', ' : '' ) .$forum_auth_fields[$i] . ' = ' . 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
				if ( $forum_auth_fields[$i] == 'auth_tmod' )
				{
					if ( $HTTP_POST_VARS['auth_tmod'] == AUTH_ALL )
					{
						$value = AUTH_REG;
					}
				}


# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_ug_auth.php

# 
#-----[ FIND ]------------------------------------------ 
#
$forum_auth_fields = array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
	, 'auth_pollcreate'

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
	, 'auth_tmod'

# 
#-----[ FIND ]------------------------------------------ 
#
'auth_vote' => AUTH_VOTE, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	'auth_tmod' => AUTH_TMOD,

# 
#-----[ FIND ]------------------------------------------ 
#
	'auth_vote' => $lang['Vote'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	'auth_tmod' => $lang['tmod'],

# 
#-----[ OPEN ]------------------------------------------ 
#
includes/auth.php

# 
#-----[ FIND ]------------------------------------------ 
#
$a_sql = 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
, a.auth_pollcreate

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, a.auth_tmod

# 
#-----[ FIND ]------------------------------------------ 
#
$auth_fields = array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
'auth_pollcreate'

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, 'auth_tmod'

# 
#-----[ FIND ]------------------------------------------ 
#
		case AUTH_ATTACH:
			break;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		case AUTH_TMOD:
			$a_sql = 'a.auth_tmod';
			$auth_fields = array('auth_tmod');
			break;


# 
#-----[ OPEN ]------------------------------------------ 
#
includes/constants.php

# 
#-----[ FIND ]------------------------------------------ 
#
define('TOPIC_WATCH_UN_NOTIFIED', 0);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
define('TMOD_LOCK', 1);
define('ADMIN_MOD_LOCK', 2);

# 
#-----[ FIND ]------------------------------------------ 
#
define('AUTH_ATTACH', 11);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
define('AUTH_TMOD', 100);

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Pollcreate'] = 'Poll create';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['tmod'] = 'Topic Mod';

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# This is a partial line.
#
$lang['Rules_moderate'] =

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Rules_tmod_can'] = 'You <b>can</b> moderate your topics in this forum';
$lang['Rules_tmod_cannot'] = 'You <b>cannot</b> moderate your topics in this forum';

$lang['Cannot_lock'] = 'This topic is already locked.';
$lang['Cannot_unlock'] = 'You can only unlock topics locked by yourself.';

# 
#-----[ OPEN ]------------------------------------------ 
#
viewforum.php

# 
#-----[ FIND ]------------------------------------------ 
#
$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$s_auth_can .= ( ( $is_auth['auth_tmod'] ) ? $lang['Rules_tmod_can'] : $lang['Rules_tmod_cannot']).'<br />';

# 
#-----[ FIND ]------------------------------------------ 
#
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=" . $start . "&amp;sid=" . $userdata['session_id'] . '">', '</a>');

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	if ( $is_auth['auth_mod'])
	{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	}

# 
#-----[ OPEN ]------------------------------------------ 
#
posting.php

# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "SELECT f.*, t.topic_id, t.topic_status, t.topic_type, t.topic_first_post_id, t.topic_last_post_id, t.topic_vote, p.post_id, p.poster_id" . $select_sql . "

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
t.topic_id

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, topic_poster

# 
#-----[ FIND ]------------------------------------------ 
#
		if ( $post_info['poster_id'] != $userdata['user_id'] && !$is_auth['auth_mod'] )

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
!$is_auth['auth_mod']

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 && ( !$is_auth['auth_tmod'] && $post_info['poster_id'] != $userdata['user_id'] )

#
#-----[ FIND ]------------------------------------------ 
#
		else if ( !$post_data['last_post'] && !$is_auth['auth_mod'] && ( $mode == 'delete' || $delete ) )

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
!$is_auth['auth_mod']

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 && ( !$is_auth['auth_tmod'] && $post_info['poster_id'] != $userdata['user_id'] )

# 
#-----[ OPEN ]------------------------------------------ 
#
viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "SELECT t.topic_id,

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
t.topic_title

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, t.topic_poster

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
, f.auth_attachments

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, f.auth_tmod

# 
#-----[ FIND ]------------------------------------------ 
#
$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$s_auth_can .= ( ( $is_auth['auth_tmod'] ) ? $lang['Rules_tmod_can'] : $lang['Rules_tmod_cannot']).'<br />';

# 
#-----[ FIND ]------------------------------------------ 
#
$topic_mod = '';

if ( $is_auth['auth_mod'] )

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
$topic_mod = '';

if ( $is_auth['auth_mod'] || ( $userdata['user_id'] == $forum_topic_data['topic_poster'] && $is_auth['auth_tmod'] ) )

#
#-----[ FIND ]------------------------------------------ 
#
	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=move&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	$topic_mod .= ( !$is_auth['auth_mod'] ) ? '' : "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=move&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';

# 
#-----[ FIND ]------------------------------------------ 
#
	if ( ( $userdata['user_id'] == $poster_id && $is_auth['auth_edit'] ) || $is_auth['auth_mod'] )

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
$is_auth['auth_edit'] ) ||

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 ( $userdata['user_id'] == $forum_topic_data['topic_poster'] && $is_auth['auth_tmod'] ) ||

# 
#-----[ FIND ]------------------------------------------ 
#
if ( $is_auth['auth_mod'] )

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
$is_auth['auth_mod']

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 || ( $userdata['user_id'] == $forum_topic_data['topic_poster'] && $is_auth['auth_tmod'] )

# 
#-----[ FIND ]------------------------------------------ 
#
$temp_url = "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'];

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
		if ( $is_auth['auth_mod'] )
		{

# 
#-----[ FIND ]------------------------------------------ 
#
		$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		}

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
f.forum_id

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
#
t.topic_poster, 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
f.forum_topics

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, f.auth_tmod

# 
#-----[ FIND ]------------------------------------------ 
#
message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	if ( !($is_auth['auth_tmod'] && $topic_id != '' && $topic_row['topic_poster'] == $userdata['user_id']) )
	{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	}

# 
#-----[ FIND ]------------------------------------------ 
#
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_delete'], $is_auth['auth_delete_type']));

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
			if ( !($is_auth['auth_tmod'] && $topic_id != '' && $topic_row['topic_poster'] == $userdata['user_id']) )
			{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
			}

# 
#-----[ FIND ]------------------------------------------ 
#
	case 'move':

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		if ( !$is_auth['auth_mod'])
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
		}

# 
#-----[ FIND ]------------------------------------------ 
#
      $sql = "UPDATE " . TOPICS_TABLE . "
         SET topic_status = " . TOPIC_LOCKED . "

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
		// Check for the topic to be unlocked, else a tmod could relock the topic changing the real topic locker an so allowing him to unlock the topic. We do this only if user is not a forum mod.
		if ( !$is_auth['auth_mod'])
		{
			$sql = 'SELECT topic_status
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id =' . $topic_id_sql . '
					LIMIT 1';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t recover topic information', '', __LINE__, __FILE__, $sql);
			}

			if ( !($topic_status = $db->sql_fetchrowset($result)) )
			{
				message_die(GENERAL_MESSAGE, 'Couldn\'t recover topic information');
			}
			
			if ($topic_status['0']['topic_status'] != TOPIC_UNLOCKED)
			{
				message_die(GENERAL_MESSAGE, $lang['Cannot_lock'], $lang['Not_Authorised']);
			}
		}

		$topic_locker = ( $is_auth['auth_mod'] ) ? ADMIN_MOD_LOCK : TMOD_LOCK;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
			, topic_locker = '" . $topic_locker . "'

# 
#-----[ FIND ]------------------------------------------ 
#
		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_UNLOCKED . " 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
		// Check for the topic locker if the user isn't a mod
		if ( !$is_auth['auth_mod'])
		{
			$sql = 'SELECT topic_locker
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id =' . $topic_id_sql . '
					LIMIT 1';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Couldn\'t recover topic information', '', __LINE__, __FILE__, $sql);
			}

			if ( !($topic_locker = $db->sql_fetchrowset($result)) )
			{
				message_die(GENERAL_MESSAGE, 'Couldn\'t recover topic information');
			}
			
			if ($topic_locker['0']['topic_locker'] != TMOD_LOCK)
			{
				message_die(GENERAL_MESSAGE, $lang['Cannot_unlock'], $lang['Not_Authorised']);
			}
		}


# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
				, topic_locker = 0

# 
#-----[ FIND ]------------------------------------------ 
#
	case 'ip':
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		if ( !$is_auth['auth_mod'])
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
		}

# 
#-----[ FIND ]------------------------------------------ 
#
	default:

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		if ( !$is_auth['auth_mod'])
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
		}
	
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 