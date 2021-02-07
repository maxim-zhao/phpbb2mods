<?php

## phpBB Approval MOD SQL Uninstall
##
## Author: uncle.f < soft@purple-yonder.com >
##
## This script performs the removal of SQL fields added by the Approval MOD.
##
## WARNING: This script should only be used AFTER YOU HAVE UNINSTALLED THE APPROVAL MOD!!!
##
## Usage: Create the 'install' directory under the root of your phpBB installation and
## copy this script to that directory. Call the script from the webpage as follows:
##
## http://<host>/<board>/install/approve_sql_uninstall.php
##
## After the SQL tables have been cleaned up, remove the install directory.


define('IN_PHPBB', 1);

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

header('Content-type: text/plain');

$sql_statement = array(
	"ALTER TABLE " . AUTH_ACCESS_TABLE . " DROP auth_approve",
	"ALTER TABLE " . FORUMS_TABLE . " DROP forum_approve",
	"ALTER TABLE " . FORUMS_TABLE . " DROP forum_posts_unapproved",
	"ALTER TABLE " . FORUMS_TABLE . " DROP forum_topics_unapproved",
	"ALTER TABLE " . FORUMS_TABLE . " DROP forum_last_post_approved",
	"ALTER TABLE " . RANKS_TABLE . " DROP rank_approve",
	"ALTER TABLE " . TOPICS_TABLE . " DROP topic_approve",
	"ALTER TABLE " . TOPICS_TABLE . " DROP topic_replies_unapproved",
	"ALTER TABLE " . TOPICS_TABLE . " DROP topic_last_post_approved",
	"ALTER TABLE " . POSTS_TABLE . " DROP post_approve"
);

$errors = false;

foreach ($sql_statement as $num => $sql)
{
	if ( !$db->sql_query($sql) )
	{
		$err = $db->sql_error();
		echo "Error executing query #" . ($num+1) . "!\nQuery was: " . $sql . "\nSQL server said: " . $err['message'] . "\n\n";
		$errors = true;
	}
}

if (!$errors)
{
	echo "All queries executed successfully!\nYour SQL tables are now free from the Approval MOD structures.\n\n";
}

echo "-------------------------------------------------------------------------------\n"
echo "NOTE: Please remove the 'install' directory to be able to use your board again.";

?>
