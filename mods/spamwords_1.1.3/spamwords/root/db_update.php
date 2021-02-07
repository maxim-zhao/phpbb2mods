<?php
/***************************************************************************
 *                               db_update.php
 *                            -------------------
 *
 *   copyright            : ©2003 Freakin' Booty ;-P & Antony Bailey
 *   project              : http://sourceforge.net/projects/dbgenerator

 *   Website              : http://freakingbooty.no-ip.com/ & http://www.rapiddr3am.net
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);

$phpbb_root_path = './';
include ($phpbb_root_path . 'extension.inc');
include ($phpbb_root_path . 'common.' . $phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs ($userdata);
//
// End session management
//

if (!$userdata['session_logged_in'])
{
	$header_location = (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE'))) ? 'Refresh: 0; URL=' : 'Location: ';
	header ($header_location . append_sid("login.$phpEx?redirect=db_update.$phpEx", true));
	exit;
}

if ($userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_MESSAGE, 'You are not authorised to access this page');
}

$page_title = 'Updating the database';
include ($phpbb_root_path . 'includes/page_header.' . $phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">';
echo '<tr><th>Updating the database</th></tr><tr><td><span class="genmed"><ul type="circle">';

$sql = array();
$sql[] = "CREATE TABLE " . $table_prefix . "spam_words (
	word_id SMALLINT( 4 ) NOT NULL AUTO_INCREMENT,
	spam_word CHAR( 100 ) NOT NULL,
	PRIMARY KEY (word_id)
)";

$sql[] = "CREATE TABLE " . $table_prefix . "spam_words_config (
config_name VARCHAR( 255 ) NOT NULL,
config_value VARCHAR( 255 ) NOT NULL
)";

$sql[] = "CREATE TABLE " . $table_prefix . "spam_words_log (
  log_id mediumint(8) NOT NULL auto_increment,
  log_user_id mediumint(8) NOT NULL default '0',
  log_username varchar(25) NOT NULL default '',
  log_ip varchar(15) NOT NULL default '',
  log_timestamp int(11) NOT NULL default '0',
  log_message text NOT NULL,
  log_subject varchar(255) NOT NULL default '',
  log_flagged tinyint(1) NOT NULL default '0',
  log_post_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (log_id)
)";

$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('enable_spam_words', '1')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('allow_admin', '1')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('allow_moderator', '0')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('allow_reg', '0')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('allow_user_posts', '50')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('user_warnings', '3')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('flag_posts', '1')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('error_message', 'The word <b>%s</b> is on our list of spam related words. Please refrain from posting this word.')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('error_message_sig', 'You have the word <b>%s</b> in your signature. That word is on our spam words list. Please change your signature.')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('warn_user_pm', '1')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('warn_user_pm_message', 'This is a warning. You have tried to post a word that is defined as spam on this website. Please refrain from doing so again.')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('warn_user_pm_subject', 'Warning.')";
$sql[] = "INSERT INTO " . $table_prefix . "spam_words_config (config_name, config_value) VALUES ('ban_ip', '0')";

$sql[] = "ALTER TABLE " . $table_prefix . "forums ADD allow_spam_words TINYINT( 1 ) DEFAULT '0' NOT NULL";
$sql[] = "ALTER TABLE " . $table_prefix . "posts ADD post_flagged TINYINT( 1 ) NOT NULL";
$sql[] = "ALTER TABLE " . $table_prefix . "users ADD user_spam_warnings TINYINT( 1 ) NOT NULL";

for($i = 0; $i < count($sql); $i++)
{
	if (!$result = $db->sql_query($sql[$i]))
	{
		$error = $db->sql_error();

		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
	}
	else
	{
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#00AA00"><b>Successful</b></font></li><br />';
	}
}

echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';

echo '<tr><th>End</th></tr><tr><td align="center"><h1>That seemed to go well. Please delete this file now.</h1></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Have a nice day</a></span></td></table>';

include ($phpbb_root_path . 'includes/page_tail.' . $phpEx);
?>
