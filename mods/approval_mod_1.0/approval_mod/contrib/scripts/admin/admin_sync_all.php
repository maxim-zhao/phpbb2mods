<?php

## phpBB Sync All
##
## Author: uncle.f < soft@purple-yonder.com >
##
## This script performs the compete sync of all posts/topic/forums statistics
## including the approval data.
##
## Usage: copy this script to the 'admin' directory of your phpBB installation;
## you should get a new 'Sync All' lnk in the admin panel ('Forums' section).
## Simply click on the 'Sync All' link to synchronize everything.
## It would make sense to do that when there is low user activity on your forum,
## especially if it contains a lot of posts.

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
   $file = basename(__FILE__);
   $module['Forums']['Sync All'] = $file;
   return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

// sync all topics and forums first
sync('all topics');
sync('all forums');

$end_msg = 'Topics and Forums sync is complete!';

// sync users' # of posts counters (only for MySQL 4.1+)
if (substr(SQL_LAYER,0,5) == 'mysql')
{
	$sql = "SHOW VARIABLES LIKE 'version'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error gettting MySQL server information!', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result))
	{
		$db->sql_freeresult($result);

		if (substr($total['Value'],0,3) == '4.1' || substr($total['Value'],0,1) > 4)
		{
			$sql = "UPDATE " . USERS_TABLE . " u SET u.user_posts =
			        (SELECT COUNT(p.poster_id)
			         FROM " . POSTS_TABLE . " p
			         WHERE p.post_approve = 0
			               AND u.user_id = p.poster_id
			         GROUP BY p.poster_id)";

			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Error updating user statistics!', '', __LINE__, __FILE__, $sql);
			}

			$end_msg = 'Topics, Forums and user posts counters sync is complete!';
		}
	}
}

message_die(GENERAL_MESSAGE, $end_msg);

?>
