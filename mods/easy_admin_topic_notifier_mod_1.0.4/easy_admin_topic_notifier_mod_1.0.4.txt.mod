##############################################################
## MOD Title: Easy Admin Topic Notifier
## MOD Author: StefanKausL < stefan@kuhlins.de > (Stefan Kuhlins) http://kuhlins.de/
## MOD Description: This simple MOD notifies admins by email of new topics.
## MOD Version: 1.0.4
##
## Installation Level:	Easy
## Installation Time:	1 Minute
## Files To Edit: includes/functions_post.php
##
## Included Files: easy_admin_topic_notifier.tpl
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## This MOD is especially useful for seldom used forums.
##
## The template for the email is copied to the English directory.
## If you want to support different languages change the statement
## $emailer->use_template('easy_admin_topic_notifier', 'english');
## to
## $emailer->use_template('easy_admin_topic_notifier', $row['user_lang']);
## and copy localized versions of the template file
## easy_admin_topic_notifier.tpl in every language directory.
##############################################################
## MOD History:
##
##   2004-09-06 - Version 1.0.4
##	  - Added directory for file
##
##   2004-08-22 - Version 1.0.3
##	  - Needed a new version number
##
##   2004-08-22 - Version 1.0.2
##	  - Corrected typo
##
##   2004-08-21 - Version 1.0.1
##	  - Added COPY action
##
##   2004-08-18 - Version 1.0.0
##	  - Initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]---------------------------------------------
#
copy easy_admin_topic_notifier.tpl to language/lang_english/email/easy_admin_topic_notifier.tpl

#
#-----[ OPEN ]---------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]---------------------------------------------
#
			$topic_id = $db->sql_nextid();

#
#-----[ AFTER, ADD ]---------------------------------------------
#
			sk_send_mail_to_admins($topic_id, $post_subject);

#
#-----[ FIND ]---------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
function sk_send_mail_to_admins($topic_id, $post_subject) {
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;

	include($phpbb_root_path . 'includes/emailer.'.$phpEx);
	$emailer = new emailer($board_config['smtp_delivery']);

	$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	$script_name = ($script_name != '') ? $script_name . '/viewtopic.'.$phpEx : 'viewtopic.'.$phpEx;
	$server_name = trim($board_config['server_name']);
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';

	$sql = "SELECT user_email, user_lang FROM " . USERS_TABLE . " WHERE user_level = " . ADMIN;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select Administrators', '', __LINE__, __FILE__, $sql);
	}

	while ($row = $db->sql_fetchrow($result))
	{
		$emailer->email_address(trim($row['user_email']));
		$emailer->use_template('easy_admin_topic_notifier', 'english');  // See Notes!
		$emailer->from($board_config['board_email']);
		$emailer->set_subject($lang['New_post']);
		$emailer->assign_vars(array(
			'SITENAME' => $board_config['sitename'],
			'TOPIC_TITLE' => $post_subject,
			'U_TOPIC' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_TOPIC_URL . "=$topic_id",
			'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
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
