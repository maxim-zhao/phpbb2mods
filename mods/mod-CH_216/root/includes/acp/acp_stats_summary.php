<?php
//
//	file: includes/acp/acp_stats_summary.php
//	author: ptirhiik
//	begin: 25/03/2006
//	version: 1.6.1 - 24/10/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// generic panel
$cp_title = 'Stats_summary';
$cp_title_explain = 'Stats_summary_explain';

// elapsed days since creation
$board_days = ceil((time() - $config->data['board_startdate']) / 86400);

// total users
$sql = 'SELECT COUNT(user_id) AS count_user_id
			FROM ' . USERS_TABLE . '
			WHERE user_id <> ' . ANONYMOUS;
$result = $db->sql_query($sql, false, __LINE__, __FILE__);
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$total_users = $row ? intval($row['count_user_id']) : 0;

// total posts and topics
$sql = 'SELECT SUM(forum_topics) AS sum_forum_topics, SUM(forum_posts) AS sum_forum_posts
			FROM ' . FORUMS_TABLE;
$result = $db->sql_query($sql, false, __LINE__, __FILE__);
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$total_posts = $row ? intval($row['sum_forum_posts']) : 0;
$total_topics = $row ? intval($row['sum_forum_topics']) : 0;

// avatar directory size
$avatar_dir_size = false;
if ( $handler = @opendir($config->root . $config->data['avatar_path']) )
{
	$size = 0;
	while ( $file = @readdir($handler) )
	{
		if ( ($file != '.') && ($file != '..') )
		{
			$size += @filesize($config->root . $config->data['avatar_path'] . '/' . $file);
		}
	}
	@closedir($handler);
	$avatar_dir_size = format_size($size);
}

// database size : mySQL (this code is heavily influenced by a similar routine in phpMyAdmin 2.2.0)
$db_size = false;
if ( preg_match('/^mysql/', SQL_LAYER) )
{
	$sql = 'SELECT VERSION() AS mysql_version';
	if ( $result = $db->sql_query($sql, false, __LINE__, __FILE__, false) )
	{
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$version = $row['mysql_version'];
		if ( preg_match("/^(3\.23|4\.|5\.)/", $version) )
		{
			$db_name = preg_match('/^(3\.23\.[6-9])|(3\.23\.[1-9][1-9])|(4\.)|(5\.)/', $version) ? '`' . $dbname . '`' : $dbname;
			$sql = 'SHOW TABLE STATUS
						FROM ' . $db_name;
			if ( $result = $db->sql_query($sql, false, __LINE__, __FILE__, false) )
			{
				$tables = $db->sql_fetchrowset($result);
				$db->sql_freeresult($result);
				$db_size = 0;
				$count_tables = count($tables);
				for ( $i = 0; $i < $count_tables; $i++ )
				{
					if ( $tables[$i]['Type'] != 'MRG_MyISAM' )
					{
						if ( empty($table_prefix) || (!empty($table_prefix) && strstr($tables[$i]['Name'], $table_prefix)) )
						{
							$db_size += $tables[$i]['Data_length'] + $tables[$i]['Index_length'];
						}
					}
				}
			}
		}
	}
}
// database size : postgresql
else if ( preg_match('/^postgres/', SQL_LAYER) )
{
	$sql = 'SELECT (SUM(relpages) * 8.0 * 1024.0) AS db_size
				FROM pg_class';
	if ( $result = $db->sql_query($sql, false, __LINE__, __FILE__, false) )
	{
		$db_size = ($row = $db->sql_fetchrow($result)) ? intval($row['db_size']) : false;
		$db->sql_freeresult($result);
	}
}
// database size : mssql
else if ( preg_match('/^mssql/', SQL_LAYER) )
{
	$sql = 'SELECT (SUM(size) * 8.0 * 1024.0) as db_size
				FROM sysfiles';
	if ( $result = $db->sql_query($sql, false, __LINE__, __FILE__, false) )
	{
		$db_size = ($row = $db->sql_fetchrow($result)) ? intval($row['db_size']) : false;
		$db->sql_freeresult($result);
	}
}

if ( $db_size )
{
	$db_size = format_size($db_size);
}

if ( defined('FROM_ADMIN_INDEX') )
{
	$template->assign_vars(array(
		'L_FORUM_STATS' => $user->lang('Forum_stats'),
		'L_STATISTIC' => $user->lang('Statistic'),
		'L_VALUE' => $user->lang('Value'),
		'L_NUMBER_POSTS' => $user->lang('Number_posts'),
		'L_POSTS_PER_DAY' => $user->lang('Posts_per_day'),
		'L_NUMBER_TOPICS' => $user->lang('Number_topics'),
		'L_TOPICS_PER_DAY' => $user->lang('Topics_per_day'),
		'L_NUMBER_USERS' => $user->lang('Number_users'),
		'L_USERS_PER_DAY' => $user->lang('Users_per_day'),
		'L_BOARD_STARTED' => $user->lang('Board_started'),
		'L_AVATAR_DIR_SIZE' => $user->lang('Avatar_dir_size'),
		'L_DB_SIZE' => $user->lang('Database_size'),
		'L_GZIP_COMPRESSION' => $user->lang('Gzip_compression'),

		'NUMBER_OF_POSTS' => $total_posts,
		'NUMBER_OF_TOPICS' => $total_topics,
		'NUMBER_OF_USERS' => $total_users,
		'START_DATE' => $user->date($config->data['board_startdate']),
		'POSTS_PER_DAY' => sprintf('%.2f', $total_posts / $board_days),
		'TOPICS_PER_DAY' => sprintf('%.2f', $total_topics / $board_days),
		'USERS_PER_DAY' => sprintf('%.2f', $total_users / $board_days),
		'AVATAR_DIR_SIZE' => $avatar_dir_size ? $avatar_dir_size['value'] . ' ' . $user->lang($avatar_dir_size['unit']) : $user->lang('Not_available'),
		'DB_SIZE' => $db_size ? $db_size['value'] . ' ' . $user->lang($db_size['unit']) : $user->lang('Not_available'),
		'GZIP_COMPRESSION' => $config->data['gzip_compress'] ? $user->lang('ON') : $user->lang('OFF'),
	));
}
else
{
	// form fields
	$fields = array(
		'board_startdate' => array('type' => 'varchar', 'output' => true, 'legend' => 'Board_started', 'value' => $user->date($config->data['board_startdate'])),
		'total_posts' => array('type' => 'int', 'output' => true, 'legend' => 'Number_posts', 'value' => $total_posts),
		'pdays_posts' => array('type' => 'varchar', 'output' => true, 'legend' => 'Posts_per_day', 'value' => sprintf('%.2f', $total_posts / $board_days)),
		'total_topics' => array('type' => 'int', 'output' => true, 'legend' => 'Number_topics', 'value' => $total_topics),
		'pdays_topics' => array('type' => 'varchar', 'output' => true, 'legend' => 'Topics_per_day', 'value' => sprintf('%.2f', $total_topics / $board_days)),
		'total_users' => array('type' => 'int', 'output' => true, 'legend' => 'Number_users', 'value' => $total_users),
		'pdays_users' => array('type' => 'varchar', 'output' => true, 'legend' => 'Users_per_day', 'value' => sprintf('%.2f', $total_users / $board_days)),
		'avatar_dir_size' => array('type' => 'varchar', 'output' => true, 'legend' => 'Avatar_dir_size', 'value' => $avatar_dir_size ? $avatar_dir_size['value'] : $user->lang('Not_available'), 'post_value' => $avatar_dir_size ? $user->lang($avatar_dir_size['unit']) : ''),
		'database_size' => array('type' => 'varchar', 'output' => true, 'legend' => 'Database_size', 'value' => $db_size ? $db_size['value'] : $user->lang('Not_available'), 'post_value' => $db_size ? $user->lang($db_size['unit']) : ''),
		'gzip_compress' => array('type' => 'list', 'output' => true, 'legend' => 'Gzip_compression', 'value' => intval($config->data['gzip_compress']), 'options' => array(0 => 'OFF', 1 => 'ON')),
	);

	// intantiate the form
	$parms = array(
		'mode' => $menu_id,
		'sub' => $subm_id == $menu_id ? '' : $subm_id,
		'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
	);
	$form = new form($fields);
	$form->buttons = false;
	$form->process();
	$template->set_switch('form');
	$template->set_filenames(array('body' => 'cp_generic.tpl'));
}

?>