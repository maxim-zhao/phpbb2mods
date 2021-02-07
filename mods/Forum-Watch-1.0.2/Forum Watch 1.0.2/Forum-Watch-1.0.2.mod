##############################################################
## MOD Title: Forum Watch
## MOD Author: skinmaster < mike@fuckingbrit.com > (Michael Jervis) http://www.fuckingbrit.com
## MOD Description: Allows forum users to watch a forum for new topics.
## MOD Version: 1.0.2
##
## Installation Level: Moderate
## Installation Time: 13 minutes
## Files To Edit: viewforum.php
##                includes/functions_post.php
##                templates/subSilver/viewforum_body.tpl
##                language/lang_english/lang_main.php
##                includes/constants.php
##                posting.php
## Included Files:
##                 language/lang_english/email/forum_notify.tpl
## Generator: MOD Studio 3.0 Alpha 1 [mod functions 0.2.1677.25348]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: None.
##############################################################
## MOD History:
##
##   2005-04-13 - Version 1.0.2
##
##      - Fixed SQL.
##      - Fixed path to supplied template.
##      - Fixed Syntax of MOD History (Now hate mod studio reloaded)
##      - Changed content of readme.txt
##      - Added contrib/Forum-Watch-Topic-1.0.2.mod
##
##   2005-04-11 - Version 1.0.1
##
##      - Made template validated.
##      - Fixed support for watching a topic when posting it.
##
##   2005-04-08 - Version 1.0.0
##
##      - First Stable release.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
#
# Table structure for table 'phpbb_forums_watch'
#
CREATE TABLE phpbb_forums_watch (
  forum_id mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  user_id mediumint(8) NOT NULL DEFAULT '0',
  notify_status tinyint(1) NOT NULL default '0',
  KEY forum_id (forum_id),
  KEY user_id (user_id),
  KEY notify_status (notify_status)
);
#
#-----[ COPY ]------------------------------------------
#
copy forum_notify.tpl to language/lang_english/email/forum_notify.tpl
#
#-----[ OPEN ]------------------------------------------
#

viewforum.php
#
#-----[ FIND ]------------------------------------------
#
//
// End of auth check
//

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Is user watching this forum?
//
if( $userdata['session_logged_in'] )
{
	$can_watch_forum = TRUE;

	$sql = "SELECT notify_status
		FROM " . FORUMS_WATCH_TABLE . "
		WHERE forum_id = $forum_id
			AND user_id = " . $userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain forum watch information", '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( isset($HTTP_GET_VARS['unwatch']) )
		{
			if ( $HTTP_GET_VARS['unwatch'] == 'forum' )
			{
				$is_watching_topic = 0;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "DELETE $sql_priority FROM " . FORUMS_WATCH_TABLE . "
					WHERE forum_id = $forum_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not delete forum watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">')
			);

			$message = $lang['No_longer_watching_f'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_forum = TRUE;

			if ( $row['notify_status'] )
			{
				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "UPDATE $sql_priority " . FORUMS_WATCH_TABLE . "
					SET notify_status = 0
					WHERE forum_id = $forum_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not update forum watch information", '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}
	else
	{
		if ( isset($HTTP_GET_VARS['watch']) )
		{
			if ( $HTTP_GET_VARS['watch'] == 'forum' )
			{
				$is_watching_forum = TRUE;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "INSERT $sql_priority INTO " . FORUMS_WATCH_TABLE . " (user_id, forum_id, notify_status)
					VALUES (" . $userdata['user_id'] . ", $forum_id, 0)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not insert forum watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=$start") . '">')
			);

			$message = $lang['You_are_watching_f'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_forum = 0;
		}
	}
}
else
{
	if ( isset($HTTP_GET_VARS['unwatch']) )
	{
		if ( $HTTP_GET_VARS['unwatch'] == 'forum' )
		{
			redirect(append_sid("login.$phpEx?redirect=viewforum.$phpEx&" . POST_FORUM_URL . "=$forum_id&unwatch=forum", true));
		}
	}
	else
	{
		$can_watch_forum = 0;
		$is_watching_forum = 0;
	}
}
// End of watch forum
#
#-----[ FIND ]------------------------------------------
#
if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=" . $start . "&amp;sid=" . $userdata['session_id'] . '">', '</a>');
}
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Forum watch information
//
$s_watching_forum = '';
if ( $can_watch_forum )
{
	if ( $is_watching_forum )
	{
		$s_watching_forum = "<a href=\"viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;unwatch=forum&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Stop_watching_forum'] . '</a>';
		$s_watching_forum_img = ( isset($images['topic_un_watch']) ) ? "<a href=\"viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;unwatch=forum&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_un_watch'] . '" alt="' . $lang['Stop_watching_forum'] . '" title="' . $lang['Stop_watching_forum'] . '" border="0"></a>' : '';
	}
	else
	{
		$s_watching_forum = "<a href=\"viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;watch=forum&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Start_watching_forum'] . '</a>';
		$s_watching_forum_img = ( isset($images['Topic_watch']) ) ? "<a href=\"viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;watch=forum&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['Topic_watch'] . '" alt="' . $lang['Start_watching_forum'] . '" title="' . $lang['Start_watching_forum'] . '" border="0"></a>' : '';
	}
}
#
#-----[ FIND ]------------------------------------------
#
	'L_STICKY' => $lang['Post_Sticky'],
	'L_POSTED' => $lang['Posted'],
	'L_JOINED' => $lang['Joined'],
	'L_AUTHOR' => $lang['Author'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'S_WATCH_FORUM' => $s_watching_forum,
#
#-----[ OPEN ]------------------------------------------
#

includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
#
//
// Fill smiley templates (or just the variables) with smileys
// Either in a window or inline
//
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Notify forum subscribers of a new topic
//
function user_notification_forum(&$post_data, &$topic_title, &$forum_title, &$forum_id, &$topic_id, &$post_id)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;
	$sql = "SELECT ban_userid
		FROM " . BANLIST_TABLE;
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not obtain banlist', '', __LINE__, __FILE__, $sql);
	}

	$user_id_sql = '';
	while ($row = $db->sql_fetchrow($result))
	{
		if (isset($row['ban_userid']) && !empty($row['ban_userid']))
		{
			$user_id_sql .= ', ' . $row['ban_userid'];
		}
	}

	$sql = "SELECT u.user_id, u.user_email, u.user_lang
		FROM " . FORUMS_WATCH_TABLE . " fw, " . USERS_TABLE . " u
		WHERE fw.forum_id = $forum_id
			AND fw.user_id NOT IN (" . $userdata['user_id'] . ", " . ANONYMOUS . $user_id_sql . ")
			AND fw.notify_status = " . TOPIC_WATCH_UN_NOTIFIED . "
			AND u.user_id = fw.user_id";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not obtain list of forum watchers', '', __LINE__, __FILE__, $sql);
	}

	$update_watched_sql = '';
	$bcc_list_ary = array();

	if ($row = $db->sql_fetchrow($result))
	{
		// Sixty second limit
		@set_time_limit(60);

		do
		{
			if ($row['user_email'] != '')
			{
				$bcc_list_ary[$row['user_lang']][] = $row['user_email'];
			}
			$update_watched_sql .= ($update_watched_sql != '') ? ', ' . $row['user_id'] : $row['user_id'];
		}
		while ($row = $db->sql_fetchrow($result));

		//
		// Let's do some checking to make sure that mass mail functions
		// are working in win32 versions of php.
		//
		if (preg_match('/[c-z]:\\\.*/i', getenv('PATH')) && !$board_config['smtp_delivery'])
		{
			$ini_val = (@phpversion() >= '4.0.0') ? 'ini_get' : 'get_cfg_var';

			// We are running on windows, force delivery to use our smtp functions
			// since php's are broken by default
			$board_config['smtp_delivery'] = 1;
			$board_config['smtp_host'] = @$ini_val('SMTP');
		}

		if (sizeof($bcc_list_ary))
		{
			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);

			$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
			$script_name = ($script_name != '') ? $script_name . '/viewforum.'.$phpEx : 'viewforum.'.$phpEx;
			$server_name = trim($board_config['server_name']);
			$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
			$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';

			$orig_word = array();
			$replacement_word = array();
			obtain_word_list($orig_word, $replacement_word);

			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);
			$topic_title = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, unprepare_message($topic_title)) : unprepare_message($topic_title);

			@reset($bcc_list_ary);
			while (list($user_lang, $bcc_list) = each($bcc_list_ary))
			{
				$emailer->use_template('forum_notify', $user_lang);

				for ($i = 0; $i < count($bcc_list); $i++)
				{
					$emailer->bcc($bcc_list[$i]);
				}

				// The  lang string below will be used
				// if for some reason the mail template subject cannot be read
				// ... note it will not necessarily be in the posters own language!
				$emailer->set_subject($lang['Forum_topic_notification']);

				// This is a nasty kludge to remove the username var ... till (if?)
				// translators update their templates
				$emailer->msg = preg_replace('#[ ]?{USERNAME}#', '', $emailer->msg);

				$emailer->assign_vars(array(
					'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
					'SITENAME' => $board_config['sitename'],
					'TOPIC_TITLE' => $topic_title,
					'FORUM_TITLE' => $forum_title,

					'U_FORUM' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_FORUM_URL . "=$forum_id",
					'U_STOP_WATCHING_FORUM' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_FORUM_URL . "=$forum_id&unwatch=forum")
				);

				$emailer->send();
				$emailer->reset();
			}
		}
	}
	$db->sql_freeresult($result);

	if ($update_watched_sql != '')
	{
		$sql = "UPDATE " . FORUMS_WATCH_TABLE . "
			SET notify_status = " . TOPIC_WATCH_NOTIFIED . "
			WHERE forum_id = $forum_id
				AND user_id IN ($update_watched_sql)";
		$db->sql_query($sql);
	}
}
#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/viewforum_body.tpl
#
#-----[ FIND ]------------------------------------------
#
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
	  <td align="left" valign="middle" width="50"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	  <td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
	  <td align="right" valign="middle" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span>
		</td>
	</tr>
	<tr>
	  <td align="left" colspan="3"><span class="nav">{PAGE_NUMBER}</span></td>
	</tr>
  </table>
</form>
#
#-----[ AFTER, ADD ]------------------------------------------
#
<table width="100%" cellspacing="2" border="0" align="center">
  <tr>
	<td width="40%" valign="top" nowrap="nowrap" align="left"><span class="gensmall">{S_WATCH_FORUM}</span><br />
	 </td>
  </tr>
</table>
#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['You_are_watching'] = 'You are now watching this topic';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Stop_watching_forum'] = 'Stop watching this forum';
$lang['Start_watching_forum'] = 'Watch this forum for new topics';
$lang['No_longer_watching_f'] = 'You are no longer watching this forum';
$lang['You_are_watching_f'] = 'You are now watching this forum';
#
#-----[ FIND ]------------------------------------------
#
$lang['Topic_reply_notification'] = 'Topic Reply Notification';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Forum_topic_notification'] = 'Forum Topic Notification';
#
#-----[ OPEN ]------------------------------------------
#

includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
define('TOPICS_WATCH_TABLE', $table_prefix.'topics_watch');
#
#-----[ AFTER, ADD ]------------------------------------------
#
define('FORUMS_WATCH_TABLE', $table_prefix.'forums_watch');
#
#-----[ OPEN ]------------------------------------------
#

posting.php
#
#-----[ FIND ]------------------------------------------
#
		if ($error_msg == '' && $mode != 'poll_delete')
		{
			user_notification($mode, $post_data, $post_info['topic_title'], $forum_id, $topic_id, $post_id, $notify_user);
		}
#
#-----[ REPLACE WITH ]------------------------------------------
#
		if ($error_msg == '' && $mode != 'poll_delete')
		{
			if ($mode == 'newtopic')
			{
				user_notification_forum($post_data, $subject, $post_info['forum_name'], $forum_id, $topic_id, $post_id);
			} else {
				user_notification($mode, $post_data, $post_info['topic_title'], $forum_id, $topic_id, $post_id, $notify_user);
			}
		}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM


