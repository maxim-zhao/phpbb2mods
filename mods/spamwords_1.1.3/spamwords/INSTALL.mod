##############################################################
## MOD Title: Spam Words
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: Define some spam words in the ACP. When someone tries
## to post a defined spam word their post will not be entered into the
## database. Instead they will receive an error message. This could be
## handy for forums with guest posting where spam bots roam free. However,
## you may also specify that certain forums are exempt from the spam check.
##
## MOD Version: 1.1.3
##
## Installation Level: Intermediate
## Installation Time: 20 Minutes
## Files To Edit: (8)
##				posting.php,
##				viewforum.php,
##				viewtopic.php,
##				admin/admin_forums.php,
##				includes/constants.php,
##				includes/functions_post.php,
##				language/lang_english/lang_admin.php
##				templates/subSilver/admin/forum_edit_body.tpl
##
## Included Files: (13)
##				root/db_update.php
##				root/admin/admin_spamwords.php
##				root/admin/admin_spamwords_config.php
##				root/admin/admin_spamwords_flagged.php
##				root/admin/admin_spamwords_log.php
##				root/includes/spamwords.php
##				root/language/lang_english/lang_spamwords_admin.php
##				root/templates/subSilver/admin/spamwords_config_body.tpl
##				root/templates/subSilver/admin/spamwords_edit_body.tpl
##				root/templates/subSilver/admin/spamwords_flagged_body.tpl
##				root/templates/subSilver/admin/spamwords_list_body.tpl
##				root/templates/subSilver/admin/spamwords_list_body.tpl
##				root/templates/subSilver/admin/spamwords_mass_ad.tpl
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
## Author Notes: If you are going to run the SQL manually, then please
## remember to add your table prefix if other than phpbb_. For all intents and purposes it is
## probably easier to just run the root/db_update.php file. Upload it to your
## phpBB root directory and call it in your browser - then delete it.
##
## In the contrib folder you will find the code changes necessary to
## erase traces of posts that contain spamwords in the event that you
## choose to flag and hide posts instead of denying them.
##############################################################
## MOD History:
##
##   2006-11-30 - 1.1.3
##      - small bug fix
##
##   2006-11-13 - 1.1.2
##      - bug fix
##
##   2006-10-02 - 1.1.1
##      - bug fix
##
##   2006-09-24 - 1.1.0
##      - bug fixes
##      - added: mass ad words
##      - added: mass delete flagged posts
##      - added: ability to choose pm sender from list of admins
##
##   2006-01-28 - 1.0.2
##      - some bug fixes
##		- Flagged posts page now parses bbcode
##		- prevented ability to hide spam words by weaving in bbcode
##		- log page highlights spam words
##
##   2006-01-03 - 1.0.1
##      - resubmitted to phpBB mods database
##
##   2005-07-27 - 1.0.0
##      - submitted to phpBB mods database
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
CREATE TABLE `phpbb_spam_words` (
`word_id` SMALLINT( 4 ) NOT NULL AUTO_INCREMENT ,
`spam_word` CHAR( 100 ) NOT NULL ,
PRIMARY KEY ( `word_id` )
);

CREATE TABLE `phpbb_spam_words_config` (
`config_name` VARCHAR( 255 ) NOT NULL ,
`config_value` VARCHAR( 255 ) NOT NULL
);

CREATE TABLE `phpbb_spam_words_log` (
  `log_id` mediumint(8) NOT NULL auto_increment,
  `log_user_id` mediumint(8) NOT NULL default '0',
  `log_username` varchar(25) NOT NULL default '',
  `log_ip` varchar(15) NOT NULL default '',
  `log_timestamp` int(11) NOT NULL default '0',
  `log_message` text NOT NULL,
  `log_subject` varchar(255) NOT NULL default '',
  `log_flagged` tinyint(1) NOT NULL default '0',
  `log_post_id` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`log_id`)
);

INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('enable_spam_words', '1');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('allow_admin', '1');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('allow_moderator', '0');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('allow_reg', '0');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('allow_user_posts', '50');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('user_warnings', '3');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('flag_posts', '1');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('error_message', 'The word <b>%s</b> is on our list of spam related words. Please refrain from posting this word.');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('error_message_sig', 'You have the word <b>%s</b> in your signature. That word is on our spam words list. Please change your signature.');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('warn_user_pm', '1');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('warn_user_pm_message', 'This is a warning. You have tried to post a word that is defined as spam on this website. Please refrain from doing so again.');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('warn_user_pm_subject', 'Warning.');
INSERT INTO phpbb_spam_words_config (config_name, config_value) VALUES ('ban_ip', '0');

ALTER TABLE `phpbb_forums` ADD `allow_spam_words` TINYINT( 1 ) DEFAULT '0' NOT NULL;
ALTER TABLE `phpbb_posts` ADD `post_flagged` TINYINT( 1 ) NOT NULL;
ALTER TABLE `phpbb_users` ADD `user_spam_warnings` TINYINT( 1 ) NOT NULL;

#
#-----[ COPY ]------------------------------------------
#
copy root/admin/admin_spamwords.php to admin/admin_spamwords.php
copy root/admin/admin_spamwords_config.php to admin/admin_spamwords_config.php
copy root/admin/admin_spamwords_flagged.php to admin/admin_spamwords_flagged.php
copy root/admin/admin_spamwords_log.php to admin/admin_spamwords_log.php
copy root/includes/spamwords.php to includes/spamwords.php
copy root/language/lang_english/lang_spamwords_admin.php to language/lang_english/lang_spamwords_admin.php
copy root/templates/subSilver/admin/spamwords_config_body.tpl to templates/subSilver/admin/spamwords_config_body.tpl
copy root/templates/subSilver/admin/spamwords_edit_body.tpl to templates/subSilver/admin/spamwords_edit_body.tpl
copy root/templates/subSilver/admin/spamwords_flagged_body.tpl to templates/subSilver/admin/spamwords_flagged_body.tpl
copy root/templates/subSilver/admin/spamwords_list_body.tpl to templates/subSilver/admin/spamwords_list_body.tpl
copy root/templates/subSilver/admin/spamwords_log_body.tpl to templates/subSilver/admin/spamwords_log_body.tpl
copy root/templates/subSilver/admin/spamwords_mass_ad.tpl to templates/subSilver/admin/spamwords_mass_ad.tpl
#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
			if ( $error_msg == '' )
			{
#
#-----[ AFTER, ADD ]------------------------------------------
#
				//
				// Check spam words....
				//
				if ( !$post_info['allow_spam_words'] )
				{
					include($phpbb_root_path . 'includes/spamwords.'.$phpEx);
				}
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
#
				submit_post($mode, $post_data, $return_message,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $poll_length
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $post_flagged
#
#-----[ OPEN ]------------------------------------------
#
viewforum.php
#
#-----[ FIND ]------------------------------------------
#
		AND t.topic_type <> " . POST_ANNOUNCE . "
#
#-----[ AFTER, ADD ]------------------------------------------
#
		AND p.post_flagged <> " . TRUE . "
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
		AND u.user_id = p.poster_id
#
#-----[ AFTER, ADD ]------------------------------------------
#
		AND p.post_flagged <> " . TRUE . "
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_forums.php
#
#-----[ FIND ]------------------------------------------
#
				$forumstatus = $row['forum_status'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
				$spamstatus = $row['allow_spam_words'];
#
#-----[ FIND ]------------------------------------------
#
				$forumstatus = FORUM_UNLOCKED;
#
#-----[ AFTER, ADD ]------------------------------------------
#
				$spamstatus = FORUM_ALLOW_SPAM_NO;
#
#-----[ FIND ]------------------------------------------
#
			$statuslist .= "<option value=\"" . FORUM_LOCKED . "\" $forumlocked>" . $lang['Status_locked'] . "</option>\n";

#
#-----[ AFTER, ADD ]------------------------------------------
#
			//
			// Spam words drop down box.
			//
   			$allowspam = ($spamstatus) ? "selected=\"selected\"" : '';
   			$allowspam_no = (!$spamstatus) ? "selected=\"selected\"" : '';

			$spamlist = "<option value=\"" . FORUM_ALLOW_SPAM . "\" $allowspam>" . $lang['Yes'] . "</option>\n";
			$spamlist .= "<option value=\"" . FORUM_ALLOW_SPAM_NO . "\" $allowspam_no>" . $lang['No'] . "</option>\n";
#
#-----[ FIND ]------------------------------------------
#
				'S_STATUS_LIST' => $statuslist,
#
#-----[ AFTER, ADD ]------------------------------------------
#
				'S_SPAM_STATUS' => $spamlist,
#
#-----[ FIND ]------------------------------------------
#
				'L_FORUM_STATUS' => $lang['Forum_status'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
				'L_SPAM_STATUS' => $lang['Spam_status'],
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
			$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, prune_enable" . $field_sql . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, allow_spam_words
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
#
				VALUES ('" . $next_id . "'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, " . intval($HTTP_POST_VARS['prune_enable']) . $value_sql . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, " . intval($HTTP_POST_VARS['spamstatus']) . "
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
#
				SET forum_name = '" . str_replace("\'", "''",
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, allow_spam_words = " . intval($HTTP_POST_VARS['spamstatus']) . "
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
define('FORUM_LOCKED', 1);
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Forum spam
define('FORUM_ALLOW_SPAM_NO', 0);
define('FORUM_ALLOW_SPAM', 1);
#
#-----[ FIND ]------------------------------------------
#
define('SMILIES_TABLE', $table_prefix.'smilies');
#
#-----[ AFTER, ADD ]------------------------------------------
#
define('SPAM_WORDS_TABLE', $table_prefix.'spam_words');
define('SPAM_WORDS_CONFIG_TABLE', $table_prefix.'spam_words_config');
define('SPAM_WORDS_LOG_TABLE', $table_prefix.'spam_words_log');
#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
#
function submit_post($mode, &$post_data, &$message,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, &$poll_length
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$post_flagged
#
#-----[ FIND ]------------------------------------------
#
	$current_time = time();
#
#-----[ AFTER, ADD ]------------------------------------------
#
	$post_flagged = (empty($post_flagged)) ? 0 : 1;
#
#-----[ FIND ]------------------------------------------
#
	$sql = ($mode != "editpost") ? "INSERT INTO " . POSTS_TABLE . " (topic_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, enable_smilies, enable_sig
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, post_flagged
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $attach_sig
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $post_flagged
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, enable_sig = $attach_sig" . $edited_sql . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, post_flagged = $post_flagged
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Spam Words
//
$lang['Spam_words'] = 'Spam Words';
$lang['Manage_words'] = 'Manage Words';
$lang['Flagged_posts'] = 'Flagged Posts';
$lang['Log'] = 'Log';
$lang['Spam_status'] = 'Allow defined spam words to be used in this forum';
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/forum_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr>
	  <td class="row1">{L_FORUM_STATUS}</td>
	  <td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
	  <td class="row1">{L_SPAM_STATUS}</td>
	  <td class="row2"><select name="spamstatus">{S_SPAM_STATUS}</select></td>
	</tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
