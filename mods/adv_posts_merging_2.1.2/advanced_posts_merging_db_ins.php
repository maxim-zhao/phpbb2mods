<?php
/***************************************************************************
 *
 *   Add Advanced Posts Merging fields
 *   Version 1.1.0  phpBBGuru.net <http://www.phpbbguru.net>
 *
 *   Use this script only for initial installation of the mod.
 *   Do not forget to delete this script 
 *
 ***************************************************************************/

//
// Connecting to the database
//
	define('IN_PHPBB', true);
	$phpbb_root_path = './';
	include($phpbb_root_path . 'extension.inc'); 
	include($phpbb_root_path . 'common.'.$phpEx); 

echo '<h1>Advanced Posts Merging DB Update</h1>';

//
// Adding field 'time_to_merge' to database table 'config'
//

	$sql = 'INSERT INTO ' . CONFIG_TABLE . ' (config_name, config_value) VALUES(\'time_to_merge\', 0)'; 	 
	if (!$db->sql_query($sql))
		{
			$res = ($db->sql_error());
			echo 'Installation failed: ' . $res[message];
			exit;
		}

//
// Adding field 'merge_flood_interval' to database table 'config'
//

	$sql = 'INSERT INTO ' . CONFIG_TABLE . ' (config_name, config_value) VALUES(\'merge_flood_interval\', 0)'; 	 
	if (!$db->sql_query($sql))
		{
			$res = ($db->sql_error());
			echo 'Installation failed: ' . $res[message];
			exit;
		}

//
// Adding field 'post_created' to database table 'posts'
//

	$sql = 'ALTER TABLE ' . POSTS_TABLE . ' ADD post_created INT( 11 ) DEFAULT 0 NOT NULL AFTER post_time'; 	 
	if (!$db->sql_query($sql))
		{
			$res = ($db->sql_error());
			echo 'Installation failed: ' . $res[message];
			exit;
		}
	
//
// Transfering data from 'post_time' column to 'post_created' column
//

	$sql = 'UPDATE ' . POSTS_TABLE . ' SET post_created = post_time'; 	 
	if (!$db->sql_query($sql))
		{
			$res = ($db->sql_error());
			echo 'Installation failed: ' . $res[message];
			exit;
		}

	echo 'Installation completed succesfully.<br><br>Remember to delete this script.';
	exit;
?>