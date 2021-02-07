##############################################################
## MOD Title: Riki Group Notify
## MOD Author: Riki < anton_simonov@mail.ru or riki@nept.ru > (Anton Simonov) N/A
## MOD Description: Email notification of new topic created or new reply posted in subforum is sent to the members of special group.
## MOD Version: 1.0.0
##
## Installation Level:	Easy
## Installation Time:	1 Minute
## Files To Edit: includes/functions_post.php
##
## Included Files: riki_group_notifier_newpost.tpl, riki_group_notifier_newtopic.tpl
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
## This MOD is very useful for specialized or corporate forums if you
## want to monitor every new created topic in subforum automatically.
## I wrote it for my corporate forum, for example. If someone posts
## in the "IT tasks and requests" subforum, I get an email ;)
## 
## The name of group members of will get notifications must be EXACTLY 
## the same as the name of subforum they get emails about.
## 
## Not tested on multilevel forums, may not work.
## 
## Based on Easy Admin Topic Notifier MOD by StefanKausL < stefan@kuhlins.de > (Stefan Kuhlins)
##
## Do not forget to copy templates to other languages folders, if necessary.
##############################################################
## MOD History:
##
##   2007-02-13 - Version 1.0.0
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]---------------------------------------------
#
copy riki_group_notifier_newpost.tpl to language/lang_english/email/riki_group_notifier_newpost.tpl
copy riki_group_notifier_newtopic.tpl to language/lang_english/email/riki_group_notifier_newtopic.tpl

#
#-----[ OPEN ]---------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]---------------------------------------------
#
	if ($mode != 'editpost')
	{
		$post_id = $db->sql_nextid();
	}

#
#-----[ AFTER, ADD ]---------------------------------------------
#
	if ($mode != 'delete' && $mode != 'editpost')
	{
		riki_group_notify($topic_id, $post_message, $mode); 		
	}

#
#-----[ FIND ]---------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
function riki_group_notify($topic_id, $post_message, $mode) {
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $notify_template, $topic_header, $result1;

	include($phpbb_root_path . 'includes/emailer.'.$phpEx);
	$emailer = new emailer($board_config['smtp_delivery']);

	$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	$script_name = ($script_name != '') ? $script_name . '/viewtopic.'.$phpEx : 'viewtopic.'.$phpEx;
	$server_name = trim($board_config['server_name']);
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';
	
	$notify_template = 'riki_group_notifier_newtopic';
	if ($mode != 'newtopic') 
	{
		$notify_template = 'riki_group_notifier_newpost';
	}
	
	$sql = "SELECT topic_title FROM " . TOPICS_TABLE . " WHERE " . TOPICS_TABLE . ".topic_id = " . $topic_id . " GROUP BY " . TOPICS_TABLE . ".topic_title ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not find topic name', '', __LINE__, __FILE__, $sql);
	}
	$result1 = ($db->sql_fetchrow($result));
	$topic_header = ($result1['topic_title']);
	
	$sql = "SELECT user_email FROM " . USERS_TABLE . " INNER JOIN ((( " . FORUMS_TABLE . " INNER JOIN " . TOPICS_TABLE . " ON " . FORUMS_TABLE . ".forum_id = " . TOPICS_TABLE . ".forum_id) INNER JOIN " . GROUPS_TABLE . " ON " . FORUMS_TABLE . ".forum_name = " . GROUPS_TABLE . ".group_name) INNER JOIN " . USER_GROUP_TABLE . " ON " . GROUPS_TABLE . ".group_id = " . USER_GROUP_TABLE . ".group_id) ON " . USERS_TABLE . ".user_id = " . USER_GROUP_TABLE . ".user_id WHERE (((" . TOPICS_TABLE . ".topic_id)=" . $topic_id . ")) GROUP BY " . USERS_TABLE . ".user_email";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select users to notify', '', __LINE__, __FILE__, $sql);
	}

	while ($row = $db->sql_fetchrow($result))

	{
		$emailer->email_address(trim($row['user_email']));
		$emailer->use_template($notify_template, $row['user_lang']);
		$emailer->from($board_config['board_email']);
		$emailer->set_subject($lang['New_post']);
		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'],
			'TOPIC_TITLE' => $topic_header,
			'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_TOPIC_URL . "=$topic_id",
			'EMAIL_SIG' => $post_message)
		);
		$emailer->send();
		$emailer->reset();
	}

	$db->sql_freeresult($result);
} 

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
