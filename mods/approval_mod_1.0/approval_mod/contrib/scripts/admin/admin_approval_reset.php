<?php

## phpBB Approval Reset
##
## Author: uncle.f < soft@purple-yonder.com >
##
## This script performs the reset of Approval flags for all posts and topics.
##
## WARNING: Executing this script will approve all unapproved posts!
##
## Usage: copy this script to the 'admin' directory of your phpBB installation;
## you should get a new 'Reset Approval' lnk in the admin panel ('Forums' section).
## Simply click on that link to reset all approval flags.

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
   $file = basename(__FILE__);
   $module['Forums']['Reset Approval'] = $file;
   return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$sql_statement = array(
	"UPDATE " . TOPICS_TABLE . " SET topic_last_post_approved = topic_last_post_id, topic_approve = 0, topic_replies_unapproved = 0",
	"UPDATE " . FORUMS_TABLE . " SET forum_last_post_approved = forum_last_post_id, forum_posts_unapproved = 0, forum_topics_unapproved = 0, forum_approve = 0",
	"UPDATE " . POSTS_TABLE . " SET post_approve = 0"
);

foreach ($sql_statement as $sql)
{
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error updating approval flags!', '', __LINE__, __FILE__, $sql);
	}
}

message_die(GENERAL_MESSAGE, 'The posts and topics approval status have been reset!<br />All posts are approved now!<br />It is recommended to run sync-all procedure now.');

?>
