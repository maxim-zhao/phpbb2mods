<?php
/***************************************************************************
 *							admin_caches.php
 *							----------------
 *	begin		: 08/10/2004
 *	copyright	: Ptirhiik
 *	email		: ptirhiik@clanmckeen.com
 *
 *	Version		: 0.0.5 - 21/08/2005
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

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Caches']['Manage'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

include($config->url('includes/class_form'));
include($config->url('includes/class_cp'));
include($config->url('includes/class_forums'));
include($config->url('includes/class_stats'));

// values allowed for 'mode=' parm
$mode_allowed = array(
	'' => array('title' => 'Cache_admin', 'explain' => 'Cache_admin_explain'),
);

// basic yes/no list for form
$list_no_yes = array(
	1 => 'Yes',
	0 => 'No',
);

// cached tables
$cache_table_list = array(
	'template' => '',
	'cfg' => 'config',
	'f' => 'forums',
	'mods' => 'moderators',
	'topics_attr' => 'topics_attr',
	'themes' => 'themes',
	'ranks' => 'ranks',
	'words' => 'words',
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
	'colors' => 'colors',
//-- fin mod : Advanced Group Color Management ---------------------------------

	'smilies' => 'smilies',
	'icons' => 'icons',
	'cp_patches' => 'cp_patches',
	'cp_panels' => 'cp_panels',
);

// user level caches
$cache_user_list = array(
	'f' => 'fauths',
	'fjbox' => 'fjbox',
);

//
// caches management form
//
class caches_management extends form
{
	var $mode;

	function process($mode='')
	{
		$this->init($mode);
		$this->check_actions();
		if ( _button('submit_form') )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_form') )
		{
			$this->display();
		}
	}

	function init()
	{
		$this->mode = $mode;
	}

	function check_actions()
	{
		global $db, $config, $user;
		global $warning, $warning_msg;
		global $error, $error_msg;
		global $cache_table_list, $cache_user_list;
		global $stat_past_guests;

		if ( _button('check_setup') )
		{
			// check if the dir exists
			$cache_path = phpbb_realpath($config->root . $this->fields['cache_path']->value);
			if ( !is_dir($cache_path) )
			{
				foreach ( $cache_table_list as $name => $class )
				{
					$config->set('cache_disabled_' . $name, '1');
				}
				_error('Cache_path_not_found');
			}
			else
			{
				_warning('Cache_path_found');
			}

			// try to create a file
			if ( !$error )
			{
				$filename = @tempnam(phpbb_realpath($cache_path), 'sys');
				if ( empty($filename) )
				{
					_warning('Cache_create_unavailable');
					$filelist = '';
					foreach ( $cache_table_list as $name => $class )
					{
						if ( empty($class) || !@file_exists(phpbb_realpath($config->root . $this->fields['cache_path']->value . '/dta_' . $class . '.' . $config->ext)) )
						{
							if ( !empty($class) )
							{
								$filelist .= (empty($filelist) ? '' : ', ') . 'dta_' . $class . '.' . $config->ext;
							}
							$config->set('cache_disabled_' . $name, '1');
							$this->fields['cache_enabled_' . $name]->value = '0';
						}
					}
					if ( !empty($filelist) )
					{
						_warning(sprintf($user->lang('Cache_filelist'), $filelist));
					}
					$filename = 'sys_tests.dta';
					$fullname = phpbb_realpath($config->root . $this->fields['cache_path']->value . '/' . $filename);
				}
				else
				{
					$fullname = $filename;
				}
				$time = time();
				$handler = @fopen($fullname, 'w');
				if ( !$handler )
				{
					if ( $filename == 'sys_tests.dta' )
					{
						_warning('Cache_sysfile_missing');
					}
					else
					{
						_warning(sprintf($user->lang('Cache_write_disabled'), $filename));
					}
					foreach ( $cache_table_list as $name => $class )
					{
						$config->set('cache_disabled_' . $name, '1');
						$this->fields['cache_enabled_' . $name]->value = '0';
					}
				}
				else
				{
					@fwrite($handler, $time);
					@fclose($handler);
					$handler = @fopen($fullname, 'r');
					$content = @fread($handler, filesize($fullname));
					if ( $filename != 'sys_tests.dta' )
					{
						@unlink($fullname);
					}
					if ( $time != $content )
					{
						_warning(sprintf($user->lang('Cache_io_unavailable', $filename)));
						foreach ( $cache_table_list as $name => $class )
						{
							$config->set('cache_disabled_' . $name, '1');
							$this->fields['cache_enabled_' . $name]->value = '0';
						}
					}
					else
					{
						_warning('Cache_successfull');
					}
				}
			}
		}

		// check tables cache action
		foreach ( $cache_table_list as $name => $class )
		{
			if ( _button('cache_regen_' . $name) || (empty($class) && _button('check_setup')) )
			{
				// cache is currently disabled : try to enable it
				$cache_disabled = $config->data['cache_disabled_' . $name];
				if ( $cache_disabled )
				{
					$config->data['cache_disabled_' . $name] = false;
				}
				if ( !empty($class) )
				{
					$exists = false;
					$object = $$class;
					if ( empty($object) )
					{
						$object = new $class();
						$exists = true;
					}
					$now = time();
					$object->read(true);
					$object->data_flag = false;
					$object->read();
					if ( $object->data_time < $now )
					{
						$config->set('cache_disabled_' . $name, 1);
						_error('Cache_failed_' . $class);
					}
					else
					{
						$config->set('cache_disabled_' . $name, 0);
						_error('Cache_succeed_' . $class);
					}
					if ( !$exists )
					{
						unset($object);
					}
				}
				else
				{
					$config->set('cache_disabled_' . $name, 0);
					$this->fields['cache_enabled_' . $name]->value = '1';
				}
			}
		}

		// check user level caches action
		$deleted_cache = array();
		$now = time();
		foreach ( $cache_user_list as $name => $legend )
		{
			if ( _button('cache_regen_' . $legend) )
			{
				$deleted_cache[] = $name;
				$config->set('cache_time_' . $name, $now);
			}
		}
		if ( !empty($deleted_cache) )
		{
			$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
						WHERE ' . (count($deleted_cache) > 1 ? 'cache_id IN(\'' . implode('\', \'', $deleted_cache) . '\')' : 'cache_id = \'' . $deleted_cache[0] . '\'');
			$db->sql_query($sql, false, __LINE__, __FILE__);
			_error('Cache_regenerated');
		}

		// groups list cache
		if ( _button('cache_regen_groups_list') )
		{
			// process
			$groups = new groups();
			$groups->resync_users_list();
			unset($groups);

			_error('Groups_list_sync');
		}

		// topics/posts/last user
		$stat_updated = false;
		if ( _button('stat_topics_regen') )
		{
			$sql = 'SELECT COUNT(topic_id) as total_topics
						FROM ' . TOPICS_TABLE;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$row = $db->sql_fetchrow($result);
			$config->set('stat_total_topics', intval($row['total_topics']));
			$stat_updated = true;
		}
		if ( _button('stat_posts_regen') )
		{
			$sql = 'SELECT COUNT(post_id) as total_posts
						FROM ' . POSTS_TABLE;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$row = $db->sql_fetchrow($result);
			$config->set('stat_total_posts', intval($row['total_posts']));
			$stat_updated = true;
		}
		if ( _button('stat_last_user_regen') )
		{
			$sql = 'SELECT user_id, username
						FROM ' . USERS_TABLE . '
						WHERE user_id <> ' . ANONYMOUS . '
						ORDER BY user_id DESC';
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$sql = str_replace('SELECT ', 'SELECT user_group_id, ', $sql);
//-- fin mod : Advanced Group Color Management ---------------------------------

			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$config->set('stat_total_users', intval($db->sql_numrows($result)));
			$row = $db->sql_fetchrow($result);
			$config->set('stat_last_user', intval($row['user_id']));
			$config->set('stat_last_username', $row['username']);
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$config->set('stat_last_user_group_id', $row['user_group_id']);
//-- fin mod : Advanced Group Color Management ---------------------------------

			$stat_updated = true;
		}
		if ( _button('stat_past_guests_regen') )
		{
			$stat_past_guests->resync();
			$stat_updated = true;
		}
		if ( $stat_updated )
		{
			_error('Board_stats_sync');
		}

		// halt on error
		if ( $error )
		{
			$u_link = $config->url('admin/admin_caches', '', true);
			$l_link = 'Click_return_cacheadmin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function check()
	{
		global $db, $config;
		global $error, $error_msg;

		// individual fields check
		parent::check();

		// complementary check
		if ( !$error )
		{
		}

		// halt on error
		if ( $error )
		{
			$u_link = $config->url('admin/admin_caches', '', true);
			$l_link = 'Click_return_cacheadmin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
		global $config;
		global $cache_table_list, $cache_user_list;

		// store cache path
		$config->set('cache_path', $this->fields['cache_path']->value);

		// store check template if any
		if ( isset($this->fields['cache_check_template']) )
		{
			$config->set('cache_check_template', intval($this->fields['cache_check_template']->value), 1);
		}

		// regenerate table cache if value changed and set on
		$deleted_cache = false;
		foreach ( $cache_table_list as $name => $class )
		{
			if ( $this->fields['cache_enabled_' . $name]->value != $this->fields['cache_enabled_' . $name]->data['value'] )
			{
				$config->set('cache_disabled_' . $name, $this->fields['cache_enabled_' . $name]->value ? '0' : '1');
				if ( $this->fields['cache_enabled_' . $name]->value && !empty($class) )
				{
					$exists = false;
					$object = $$class;
					if ( empty($object) )
					{
						$object = new $class();
						$exists = true;
					}
					$object->read(true);
					if ( !$exists )
					{
						unset($object);
					}
				}
			}
		}

		// send achievement message
		message_return('Cache_setup_updated', 'Click_return_cacheadmin', $config->url('admin/admin_caches', '', true));
	}

	function display()
	{
		global $template, $user;
		global $warning, $warning_msg;

		if ( $warning )
		{
			$template->assign_block_vars('warning', array(
				'WARNING_TITLE' => $user->lang('Check_results'),
				'WARNING_MSG' => $warning_msg,
			));
		}

		parent::display();
	}
}

//------------------------------------------------------------------------------
//
// Main process
//
//------------------------------------------------------------------------------

//
// get parms
//
$mode = _read('mode', TYPE_NO_HTML, '',  $mode_allowed);

//
// build the form
//
$form_fields = array(
	'cache_path' => array('type' => 'varchar', 'legend' => 'Cache_path', 'explain' => 'Cache_path_explain', 'value' => $config->data['cache_path'], 'length' => 25),
	'check_setup' => array('type' => 'button', 'legend' => 'Check_setup', 'image' => 'cmd_check', 'combined' => true),
);

if ( defined('CH_extended_templates') )
{
	$form_fields += array(
		'template_title' => array('type' => 'sub_title', 'legend' => 'Template_cache'),
		'cache_enabled_template' => array('type' => 'radio_list', 'legend' => 'Enable_cache_template', 'options' => $list_no_yes, 'value' => $config->data['cache_disabled_template'] ? '0' : '1'),
		'cache_check_template' => array('type' => 'radio_list_comment', 'legend' => 'Check_recent_tpl', 'options' => array(1 => 'Yes', 0 => 'No'), 'value' => intval($config->data['cache_check_template']), 'linefeed' => true),
	);
}
else
{
	unset($cache_table_list['template']);
}

// table cached
$form_fields += array(
	'table_title' => array('type' => 'sub_title', 'legend' => 'Table_caches'),
);
foreach ( $cache_table_list as $name => $class )
{
	if ( !empty($class) )
	{
		$exists = false;
		$object = $$class;
		if ( empty($object) )
		{
			$object = new $class();
			$object->read();
			$exists = true;
		}
		$form_fields += array(
			'cache_enabled_' . $name => array('type' => 'radio_list', 'legend' => 'Enable_cache_' . $class, 'options' => $list_no_yes, 'value' => $config->data['cache_disabled_' . $name] ? '0' : '1'),
			'cache_regen_' . $name => array('type' => 'button', 'legend' => 'Cache_regen', 'image' => 'cmd_regen', 'combined' => true),
			'cache_gen_' . $name => array('type' => 'varchar_comment', 'legend' => 'Cache_last_generation', 'value' => $user->date($object->data_time)),
		);
		if ( !$exists )
		{
			unset($object);
		}
	}
}

// user level caches
$user->get_cache(array_keys($cache_user_list));
$form_fields += array(
	'user_title' => array('type' => 'sub_title', 'legend' => 'User_caches'),
);
foreach ( $cache_user_list as $name => $legend )
{
	$form_fields += array(
		'cache_title_' . $legend => array('type' => 'varchar', 'legend' => 'Cache_' . $legend, 'output' => true),
		'cache_regen_' . $legend => array('type' => 'button', 'legend' => 'Cache_regen', 'image' => 'cmd_regen', 'combined' => true),
		'cache_gen_' . $legend => array('type' => 'varchar_comment', 'legend' => 'Cache_last_generation', 'value' => empty($config->data['cache_time_' . $name]) ? '' : $user->date($config->data['cache_time_' . $name])),
	);
}

// groups cache
$form_fields += array(
	'cache_title_groups_list' => array('type' => 'varchar', 'legend' => 'Cache_groups_list', 'output' => true),
	'cache_regen_groups_list' => array('type' => 'button', 'legend' => 'Cache_regen', 'image' => 'cmd_regen', 'combined' => true),
);

// board stats
$form_fields += array(
	'stat_title' => array('type' => 'sub_title', 'legend' => 'Board_stats_caches'),

	'stat_topics' => array('type' => 'int', 'legend' => 'Total_topics', 'output' => true),
	'stat_topics_regen' => array('type' => 'button', 'legend' => 'Cache_regen', 'image' => 'cmd_mini_synchro', 'combined' => true),
	'stat_topics_value' => array('type' => 'int', 'value' => $config->data['stat_total_topics'], 'output' => true, 'combined' => true),

	'stat_posts' => array('type' => 'int', 'legend' => 'Total_posts', 'output' => true),
	'stat_posts_regen' => array('type' => 'button', 'legend' => 'Cache_regen', 'image' => 'cmd_mini_synchro', 'combined' => true),
	'stat_posts_value' => array('type' => 'int', 'value' => $config->data['stat_total_posts'], 'output' => true, 'combined' => true),

	'stat_last_user' => array('type' => 'varchar', 'legend' => 'Last_user', 'output' => true),
	'stat_last_user_regen' => array('type' => 'button', 'legend' => 'Cache_regen', 'image' => 'cmd_mini_synchro', 'combined' => true),
//-- mod : Advanced Group Color Management -------------------------------------
//-- here we replaced
//	'value' => $config->data['stat_last_username']
//-- with
//	'value' => $colors->get_user_color($config->data['stat_last_user_group_id'], '0', $config->data['stat_last_username'])
//-- modify

	'stat_last_username' => array('type' => 'varchar', 'value' => $colors->get_user_color($config->data['stat_last_user_group_id'], '0', $config->data['stat_last_username']), 'post_value' => '&nbsp;(' . $config->data['stat_total_users'] . '°)', 'output' => true, 'combined' => true),
//-- fin mod : Advanced Group Color Management ---------------------------------

);


// past guests online stats
if ( $config->data['stats_display_past'] )
{
	$stat_past_guests = new stats();
	$form_fields += array(
		'stat_past_guests' => array('type' => 'varchar', 'legend' => 'Past_guests', 'output' => true),
		'stat_past_guests_regen' => array('type' => 'button', 'legend' => 'Cache_regen', 'image' => 'cmd_mini_synchro', 'combined' => true),
		'stat_past_guests_count' => array('type' => 'varchar', 'value' => $stat_past_guests->get_past_guests(), 'output' => true, 'combined' => true),
	);
}

// intantiate the form
$form = new caches_management($form_fields);
$form->process();

// constants
$template->assign_vars(array(
	'L_TITLE' => $user->lang($mode_allowed[$mode]['title']),
	'L_TITLE_EXPLAIN' => $user->lang($mode_allowed[$mode]['explain']),
	'L_FORM' => $user->lang($mode_allowed[$mode]['title']),
	'S_ACTION' => $config->url('admin/admin_caches', '', true),
));
_hide('mode', $mode);
_hide_set();

// send the display
$template->set_filenames(array('body' => 'form_body.tpl'));
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>