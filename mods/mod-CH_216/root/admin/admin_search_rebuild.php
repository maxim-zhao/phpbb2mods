<?php
//
//	file: admin/admin_search_rebuild.php
//	author: ptirhiik
//	begin: 09/12/2005
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);

$file = basename(__FILE__);
if( !empty($setmodules) )
{
	$module['General']['02_Search_rebuild'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_search_rebuild';

// don't send headers : we gonna send it at bottom
$no_page_header = true;
require('./pagestart.' . $phpEx);
include($config->url('includes/functions_search'));


define('PER_TURN', 50);
$config_values = array('SR_start_time', 'SR_start_id', 'SR_current', 'SR_elapsed');

function _format_time($time)
{
	global $user;

	$seconds = $time % 60;
	$time = intval($time / 60);

	return sprintf($user->lang('Search_rebuild_elapse'), intval($time / 60), $time % 60, $seconds);
}

function _loop($requester, $parms)
{
	global $config, $template;

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="0;url=' . $config->url($requester, $parms, true) . '">',
	));
}

$steps = array(
	0 => 'Warning',
	1 => 'Process',
	9 => 'Achievement',
);
$parms = array(
	'step' =>  _read('step', TYPE_INT, 0, $steps),
	'start' =>  _read('start', TYPE_INT),
	'start_time' => _read('start_time', TYPE_INT),
);

// get number of posts
$sql = 'SELECT post_id
			FROM ' . POSTS_TEXT_TABLE;
$result = $db->sql_query($sql, false, __LINE__, __FILE__);
$total_posts = $db->sql_numrows($result);
$db->sql_freeresult($result);

if ( _read('step', TYPE_INT) == 9 )
{
	$step = 9;
}
else if ( empty($config->data['SR_start_time']) )
{
	$step = _button('submit') ? 1 : 0;
}
else
{
	$step = 1;
}

// first step : send waring
if ( $step == 0 )
{
	$template->assign_vars(array(
		'L_FORM' => $user->lang('Search_rebuild_confirm'),
		'TEXT' => sprintf($user->lang('Search_rebuild_text'), $total_posts),
	));
	display_buttons(array(
		'submit' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
	));
	$template->set_switch('form');
}

// second step : process
if ( $step == 1 )
{
	// first entry ?
	if ( empty($config->data['SR_start_time']) )
	{
		// get start time
		$now = time();

		// do some cleaning
		$sql = 'TRUNCATE TABLE ' . SEARCH_TABLE;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		$sql = 'TRUNCATE TABLE ' . SEARCH_WORD_TABLE;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		$sql = 'TRUNCATE TABLE ' . SEARCH_MATCH_TABLE;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// get the last post id
		$sql = 'SELECT p.post_id
					FROM ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt
					WHERE pt.post_id = p.post_id
					ORDER BY p.post_id DESC';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$total_posts = $db->sql_numrows($result);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$start_id = intval($row['post_id']);

		// ensure the config values are not cached
		$sql = 'DELETE FROM ' . CONFIG_TABLE . '
					WHERE config_name IN(\'' . implode('\', \'', $config_values) . '\')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$config->read(true);

		// now fill the config table with the start values
		$config->begin_transaction();
		$config->set('SR_total_posts', $total_posts);
		$config->set('SR_start_time', $now);
		$config->set('SR_start_id', $start_id);
		$config->set('SR_current', 0);
		$config->set('SR_elapsed', 0);
		$config->end_transaction();
	}

	// process
	$now = time();
	$done = 0;
	$sql = 'SELECT pt.post_id, pt.post_subject, pt.post_sub_title, pt.post_text
				FROM ' . POSTS_TEXT_TABLE . ' pt, ' . POSTS_TABLE . ' p
				WHERE p.post_id = pt.post_id
					AND pt.post_id <= ' . intval($config->data['SR_start_id']) . '
					AND (p.post_edit_time IS NULL OR p.post_edit_time <= ' . intval($config->data['SR_start_time']) . ')
				ORDER BY pt.post_id DESC
				LIMIT ' . intval($config->data['SR_current']) . ', ' . PER_TURN;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		add_search_words('single', $row['post_id'], $row['post_text'], $row['post_subject'] . ' ' . $row['post_sub_title'], true);
		$done++;

		// update config table
		$config->begin_transaction();
		$config->set('SR_current', intval($config->data['SR_current']) + 1);
		$config->set('SR_elapsed', intval($config->data['SR_elapsed']) + time() - $now);
		$config->end_transaction();
		$now = time();
	}
	$db->sql_freeresult($result);

	// display progression
	$mult = 3;
	$text = '<div align="center"><table cellpadding="1" cellspacing="0" border="0"><tr><td>' . sprintf($user->lang('Search_rebuild_processed'), intval($config->data['SR_current']), intval($config->data['SR_total_posts']), _format_time(intval($config->data['SR_elapsed']))) . ':&nbsp;</td><td style="width: ' . (100 * $mult) . 'px; height: 13px; background-color: #FEFEFF; border: 1px #98AAB1 solid;"><div style="width: ' . (min(100, max(1, ceil((intval($config->data['SR_current']) + 1) * 100 / max(intval($config->data['SR_total_posts']), 1)))) * $mult). 'px; height: 13px; background-color: #00D000;"></div></td></tr></table></div>';
	$template->assign_vars(array(
		'L_FORM' => $user->lang('Search_rebuild_progress'),
		'TEXT' => $text,
	));

	// save data and loop
	if ( $done < PER_TURN )
	{
		$step = 9;
	}
	else
	{
		_loop($requester, array('step' => 1));
	}
}

if ( $step == 9 )
{
	// last step : send achievement message
	$template->assign_vars(array(
		'L_FORM' => $user->lang('Search_rebuild_achieve'),
		'TEXT' => sprintf($user->lang('Search_rebuild_achieve_text'), intval($config->data['SR_current']), _format_time(intval($config->data['SR_elapsed']))),
	));

	// clean the config table
	$sql = 'DELETE FROM ' . CONFIG_TABLE . '
				WHERE config_name IN(\'' . implode('\', \'', $config_values) . '\')';
	$db->sql_query($sql, false, __LINE__, __FILE__);
	$config->read(true);
}

// send the display
$template->assign_vars(array(
	'L_TITLE' => $user->lang('Search_rebuild_title'),
	'L_TITLE_EXPLAIN' => $user->lang('Search_rebuild_title_explain'),
	'S_ACTION' => $config->url($requester, '', true),
));
$template->set_filenames(array('body' => 'admin/search_rebuild_body.tpl'));
include($config->url('admin/page_header_admin'));
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>