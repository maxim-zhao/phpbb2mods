<?php
/***************************************************************************
*							class_color.php
*							--------------
*	begin		: 16/08/2005
*	copyright	: phantomk
*	email		: phantomk@modmybb.com
*
*	Version		: 0.0.27 - 9/1/2006
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

if (!defined('IN_PHPBB'))
{
	die("Hacking attempt");
}

define('AGCM_CURRENT_VERSION', '1.2.3');

if ( empty($installed_mods) )
{
	$installed_mods = array();
	$installed_mods[0] = array('name' => 'advanced_group_color_management', 'installed' => AGCM_CURRENT_VERSION);
}
else
{
	$count_installed_mods = count($installed_mods);
	$installed_mods[$count_installed_mods] = array('name' => 'advanced_group_color_management', 'installed' => AGCM_CURRENT_VERSION);
}

if (!defined('IN_CH'))
{
	class colors
	{
		var $data;
		var $users;
		var $default_lang;

		function read()
		{
			global $db;

			$this->data = array();

			$sql = 'SELECT group_id, group_name, group_description, group_weight, group_legend
					FROM ' . GROUPS_TABLE . '
					WHERE group_legend = 1
					ORDER BY group_weight ASC';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't retrieve group color's data.", "", __LINE__, __FILE__, $sql);
			}

			$i = 0;

			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->data[$i] = $row;
				$i++;
			}

			$db->sql_freeresult($result);
		}

		function lang()
		{
			global $phpbb_root_path, $phpEx, $lang, $board_config;

			$language = $board_config['default_lang'];

			if ( !file_exists( $phpbb_root_path . 'language/lang_' . $language . '/lang_main_color.' . $phpEx ) )
			{
				$language = $this->default_lang;
			}

			include( $phpbb_root_path . 'language/lang_' . $language . '/lang_main_color.' . $phpEx );

			if ( defined('IN_ADMIN') )
			{
				if ( !file_exists( $phpbb_root_path . 'language/lang_' . $language . '/lang_admin_color.' . $phpEx ) )
				{
					$language = $this->default_lang;
				}

				include( $phpbb_root_path . 'language/lang_' . $language . '/lang_admin_color.' . $phpEx );
			}
		}

		function add_group($group_id, $install=false)
		{
			global $db;

			$sql = '';
			$sql2 = '';
			$sql3 = '';

			switch( SQL_LAYER )
			{
				case 'postgres':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' ADD COLUMN g' . intval($group_id) . ' VARCHAR(6)';
					$sql2 = 'ALTER TABLE ' . THEMES_TABLE . ' ALTER COLUMN g' . intval($group_id) . ' SET DEFAULT \'\'';
					$sql3 = 'ALTER TABLE ' . THEMES_TABLE . ' ALTER COLUMN g' . intval($group_id) . ' SET NOT NULL';
					break;

				case 'mssql';
				case 'mssql-odbc':
					$sql = 'ALTER TABLE [' . THEMES_TABLE . '] ADD [g' . intval($group_id) . '] [varchar] (6) NOT NULL';
					break;

				case 'mysql':
				case 'mysql4':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' ADD g' . intval($group_id) . ' VARCHAR(6) NOT NULL';
					break;
			}

			if ( !$db->sql_query($sql) )
			{
				if ( $install )
				{
					return $db->sql_error();
				}
				else
				{
					message_die(GENERAL_ERROR, "Couldn't add group to the themes table.", "", __LINE__, __FILE__, $sql);
				}
			}

			if ( !empty($sql2) )
			{
				if ( !$db->sql_query($sql2) )
				{
					if ( $install )
					{
						return $db->sql_error();
					}
					else
					{
						message_die(GENERAL_ERROR, "Couldn't add group to the themes table.", "", __LINE__, __FILE__, $sql2);
					}
				}
			}

			if ( !empty($sql3) )
			{
				if ( !$db->sql_query($sql3) )
				{
					if ( $install )
					{
						return $db->sql_error();
					}
					else
					{
						message_die(GENERAL_ERROR, "Couldn't add group to the themes table.", "", __LINE__, __FILE__, $sql3);
					}
				}
			}

			if ( !$install )
			{
				$this->set_group_weight();
			}
			else
			{
				return true;
			}
		}

		function remove_group($group_id)
		{
			global $db;

			switch( SQL_LAYER )
			{
				case 'postgres':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' DROP COLUMN g' . intval($group_id) . ' CASCADE';
					break;

				case 'mssql';
				case 'mssql-odbc':
					$sql = 'ALTER TABLE [' . THEMES_TABLE . '] DROP COLUMN [g' . intval($group_id) . ']';
					break;

				case 'mysql':
				case 'mysql4':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' DROP g' . intval($group_id);
					break;
			}

			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't remove group from the themes table.", "", __LINE__, __FILE__, $sql);
			}

			$this->set_group_weight();
		}

		function read_group_users($group_id)
		{
			global $db;

			if ( $group_id == '0' )
			{
				$this->users = '';

				return;
			}

			$this->users = array();

			$sql = 'SELECT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id = ' . intval($group_id) . '
						AND user_pending <> 1
					GROUP BY user_id';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain user_id's.", "", __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->users[ intval($row['user_id']) ] = true;
			}

			$db->sql_freeresult($result);
		}

		function set_group_users($group_id, $delete=false)
		{
			global $db;

			if ( !empty($this->users) )
			{
				$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_group_id = NULL
						WHERE user_id IN (' . implode(', ' , array_keys($this->users)) . ')
							AND user_group_id = ' . $group_id;
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't update user_group_id.", "", __LINE__, __FILE__, $sql);
				}
			}

			$this->users = array();

			$sql = 'SELECT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id = ' . intval($group_id) . '
						AND user_pending <> 1
					GROUP BY user_id';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain user_id's.", "", __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->users[ intval($row['user_id']) ] = true;
			}

			$db->sql_freeresult($result);

			if ( $delete )
			{
				$group_id = NULL;
			}

			if ( !empty($this->users) )
			{
				$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_group_id = ' . $group_id . '
						WHERE user_id IN (' . implode(', ' , array_keys($this->users)) . ')
							AND user_group_id = \'\'';
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't update user_group_id.", "", __LINE__, __FILE__, $sql);
				}
			}
		}

		function set_group_weight($order_value='group_weight')
		{
			global $db;

			$order = 0;

			$sql = 'SELECT group_id
					FROM ' . GROUPS_TABLE . '
					WHERE group_single_user <> ' . true . '
					ORDER BY ' . $order_value . ' ASC';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update group_weight.", "", __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				$order += 10;
				$sql = 'UPDATE ' . GROUPS_TABLE . '
						SET group_weight = ' . intval($order) . '
						WHERE group_id = ' . $row['group_id'];
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't update group_weight.", "", __LINE__, __FILE__, $sql);
				}
			}

			$db->sql_freeresult($result);
		}

		function group_color_select($select_name, $group_id, $user_id='')
		{
			global $template, $userdata, $db;

			if ( $user_id == '' )
			{
				$sql = 'SELECT g.group_id, g.group_name
						FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
						WHERE ug.user_id = ' . intval($userdata['user_id']) . '
							AND g.group_id = ug.group_id
							AND g.group_color = 1
							AND ug.user_pending <> 1
						ORDER BY g.group_weight ASC';
			}
			else
			{
				$sql = 'SELECT g.group_id, g.group_name
						FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
						WHERE ug.user_id = ' . intval($user_id) . '
							AND g.group_id = ug.group_id
							AND g.group_color = 1
							AND ug.user_pending <> 1
						ORDER BY g.group_weight ASC';
			}

			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain user's group data.", "", __LINE__, __FILE__, $sql);
			}

			$i = 0;
			$user_group_color = array();

			while ( $row = $db->sql_fetchrow($result) )
			{
				$user_group_color[$i] = $row;
				$i++;
			}

			$db->sql_freeresult($result);

			if ( $i != 0 )
			{
				$template->assign_block_vars('group_color_select',array());
			}

			$group_color_select = '<select name="' . $select_name . '">';

			for ($i = 0; $i < count($user_group_color); $i++)
			{
				$selected = ( $group_id == $user_group_color[$i]['group_id'] ) ? ' selected="selected"' : '';
				$group_color_select .= '<option value="' . $user_group_color[$i]['group_id'] . '"' . $selected . '>' . $user_group_color[$i]['group_name'] . '</option>';
			}

			$group_color_select .= '</select>';

			return $group_color_select;
		}

		function inactive_select($select_name)
		{
			global $board_config, $lang;

			$inactive = $this->session_time();

			$inactive_select = '<select name="' . $select_name . '">';

			for ($i = 0; $i < count($inactive); $i++)
			{
				$selected = ( $board_config['agcm_time'] == $inactive[$i]['value'] ) ? ' selected="selected"' : '';
				$inactive_select .= '<option value="' . $inactive[$i]['value'] . '"' . $selected . '>' . $inactive[$i]['length'] . '</option>';
			}

			$inactive_select .= '</select>';

			return $inactive_select;
		}

		function session_time()
		{
			global $lang;

			$inactive = array();
			$inactive[0]['value'] = '900';
			$inactive[0]['length'] = $lang['AGCM_15_minute'];
			$inactive[1]['value'] = '3600';
			$inactive[1]['length'] = $lang['AGCM_1_hour'];
			$inactive[2]['value'] = '43200';
			$inactive[2]['length'] = $lang['AGCM_12_hour'];
			$inactive[3]['value'] = '86400';
			$inactive[3]['length'] = $lang['AGCM_1_day'];
			$inactive[4]['value'] = '172800';
			$inactive[4]['length'] = $lang['AGCM_2_day'];
			$inactive[5]['value'] = '691200';
			$inactive[5]['length'] = $lang['AGCM_1_week'];

			return $inactive;
		}

		function display_legend()
		{
			global $template, $phpEx, $theme, $lang;

			if ( count($this->data) != 0 )
			{
				for ($i = 0; $i < count($this->data); $i++)
				{
					$template->assign_block_vars('legend', array(
						"U_GROUP" => append_sid("groupcp.". $phpEx ."?" . POST_GROUPS_URL . "=". $this->data[$i]['group_id']),
						"GROUP_DESCRIPTION" => $this->data[$i]['group_description'],
						"GROUP_NAME" => $this->data[$i]['group_name'],
						"GROUP_COLOR" =>  " style=\"color:#" . $theme['g' . $this->data[$i]['group_id']] . "; font-weight: bold;\"")
					);

					if ( $i < (count($this->data) - 1) && count($this->data) != 1 )
					{
						$template->assign_block_vars('legend.color', array(
							"L_COMMA" => ',&nbsp;')
						);
					}
					else if ( $i < count($this->data) && ( !empty($theme['g']) || !empty($theme['session_time']) || !empty($theme['g0']) ) )
					{
						$template->assign_block_vars('legend.color', array(
							"L_COMMA" => ',&nbsp;')
						);
					}
					else
					{
						$template->assign_block_vars('legend.color', array());
					}
				}
			}

			if ( !empty($theme['g']) )
			{
				$template->assign_block_vars('legend', array(
					"U_GROUP" => append_sid("memberlist.". $phpEx),
					"GROUP_DESCRIPTION" => $lang['AGCM_registered_explain_legend'],
					"GROUP_NAME" => $lang['AGCM_registered_legend'],
					"GROUP_COLOR" =>  " style=\"color:#" . $theme['g'] . "; font-weight: bold;\"")
				);

				if ( !empty($theme['session_time']) )
				{
					$template->assign_block_vars('legend.color', array(
						"L_COMMA" => ',&nbsp;')
					);
				}
				else if ( empty($theme['session_time']) && !empty($theme['g0']) )
				{
					$template->assign_block_vars('legend.color', array(
						"L_COMMA" => ',&nbsp;')
					);
				}
				else
				{
					$template->assign_block_vars('legend.color', array());
				}
			}

			if ( !empty($theme['session_time']) )
			{
				$template->assign_block_vars('legend', array(
					"U_GROUP" => append_sid("memberlist.". $phpEx),
					"GROUP_DESCRIPTION" => $lang['AGCM_session_time_explain_legend'],
					"GROUP_NAME" => $lang['AGCM_session_time_legend'],
					"GROUP_COLOR" =>  " style=\"color:#" . $theme['session_time'] . "; font-weight: bold;\"")
				);

				if ( !empty($theme['g0']) )
				{
					$template->assign_block_vars('legend.color', array(
						"L_COMMA" => ',&nbsp;')
					);
				}
				else
				{
					$template->assign_block_vars('legend.color', array());
				}
			}

			if ( !empty($theme['g0']) )
			{
				$template->assign_block_vars('legend', array(
					"U_GROUP" => append_sid("memberlist.". $phpEx),
					"GROUP_DESCRIPTION" => $lang['AGCM_anonymous_explain_legend'],
					"GROUP_NAME" => $lang['AGCM_anonymous_legend'],
					"GROUP_COLOR" =>  " style=\"color:#" . $theme['g0'] . "; font-weight: bold;\"")
				);

				$template->assign_block_vars('legend.color', array());
			}
		}

		function get_user_color($group_id, $user_session_time, $username='')
		{
			global $theme, $board_config;

			$user_color = $theme['g' . $group_id];

			if ( !($user_session_time >= ( time() - $board_config['agcm_time'] )) && $board_config['agcm_check'] && $user_session_time != '0' )
			{
				$user_color = $theme['session_time'];
			}

			if ( !empty($username) )
			{
				$user_color = '<span style="color:#' . $user_color . ';" class="username_color">'. $username .'</span>';
			}

			return $user_color;
		}
	}
}
else
{
	class colors
	{
		var $data;
		var $users;
		var $data_time;
		var $from_cache;
		var $default_lang;

		function read($force=false)
		{
			global $config;

			$db_cached = new cache('dta_colors', $config->data['cache_path'], $config->data['cache_disabled_colors']);
			$sql = 'SELECT group_id, group_status, group_name, group_description, group_weight, group_legend
					FROM ' . GROUPS_TABLE . '
					WHERE group_legend = 1
					ORDER BY group_weight ASC';
			$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force);
			$this->data_time = $db_cached->data_time;
			$this->from_cache = $db_cached->from_cache;

			if ($force)
			{
				include_once($config->url('includes/class_forums'));

				$moderators = new moderators();
				$moderators->read(true);
			}
		}

		function lang()
		{
			global $lang, $config;

			$language = $config->data['default_lang'];

			if ( !file_exists( $config->url('language/lang_' . $language . '/lang_main_color') ) )
			{
				$language = $this->default_lang;
			}

			include( $config->url('language/lang_' . $language . '/lang_main_color') );

			if ( defined('IN_ADMIN') )
			{
				if ( !file_exists( $config->url('language/lang_' . $language . '/lang_admin_color') ) )
				{
					$language = $this->default_lang;
				}

				include( $config->url('language/lang_' . $language . '/lang_admin_color') );
			}
		}

		function add_group($group_id, $install=false)
		{
			global $db;

			$sql = '';
			$sql2 = '';
			$sql3 = '';

			switch( SQL_LAYER )
			{
				case 'postgres':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' ADD COLUMN g' . intval($group_id) . ' VARCHAR(6)';
					$sql2 = 'ALTER TABLE ' . THEMES_TABLE . ' ALTER COLUMN g' . intval($group_id) . ' SET DEFAULT \'\'';
					$sql3 = 'ALTER TABLE ' . THEMES_TABLE . ' ALTER COLUMN g' . intval($group_id) . ' SET NOT NULL';
					break;

				case 'mssql';
				case 'mssql-odbc':
					$sql = 'ALTER TABLE [' . THEMES_TABLE . '] ADD [g' . intval($group_id) . '] [varchar] (6) NOT NULL';
					break;

				case 'mysql':
				case 'mysql4':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' ADD g' . intval($group_id) . ' VARCHAR(6) NOT NULL';
					break;
			}

			if ( !$db->sql_query($sql) )
			{
				if ( $install )
				{
					return $db->sql_error();
				}
				else
				{
					message_die(GENERAL_ERROR, "Couldn't add group to the themes table.", "", __LINE__, __FILE__, $sql);
				}
			}

			if ( !empty($sql2) )
			{
				if ( !$db->sql_query($sql2) )
				{
					if ( $install )
					{
						return $db->sql_error();
					}
					else
					{
						message_die(GENERAL_ERROR, "Couldn't add group to the themes table.", "", __LINE__, __FILE__, $sql2);
					}
				}
			}

			if ( !empty($sql3) )
			{
				if ( !$db->sql_query($sql3) )
				{
					if ( $install )
					{
						return $db->sql_error();
					}
					else
					{
						message_die(GENERAL_ERROR, "Couldn't add group to the themes table.", "", __LINE__, __FILE__, $sql3);
					}
				}
			}

			if ( !$install )
			{
				$this->set_group_weight();
				$this->read(true);
			}
			else
			{
				return '';
			}
		}

		function remove_group($group_id)
		{
			global $db;

			switch( SQL_LAYER )
			{
				case 'postgres':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' DROP COLUMN g' . intval($group_id) . ' CASCADE';
					break;

				case 'mssql';
				case 'mssql-odbc':
					$sql = 'ALTER TABLE [' . THEMES_TABLE . '] DROP COLUMN [g' . intval($group_id) . ']';
					break;

				case 'mysql':
				case 'mysql4':
					$sql = 'ALTER TABLE ' . THEMES_TABLE . ' DROP g' . intval($group_id);
					break;
			}

			$db->sql_query($sql, false, __LINE__, __FILE__);

			$this->set_group_weight();
			$this->read(true);
		}

		function read_group_users($group_id)
		{
			global $db;

			if ( $group_id == '0' )
			{
				$this->users = '';

				return;
			}

			$this->users = array();

			$sql = 'SELECT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id = ' . intval($group_id) . '
						AND user_pending <> 1
					GROUP BY user_id';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);

			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->users[ intval($row['user_id']) ] = true;
			}

			$db->sql_freeresult($result);
		}

		function set_group_users($group_id, $delete=false)
		{
			global $db, $config;

			if ( $group_id == GROUP_REGISTERED )
			{
				return;
			}

			if ( !empty($this->users) )
			{
				$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_group_id = ' . GROUP_REGISTERED . '
						WHERE user_id IN (' . implode(', ' , array_keys($this->users)) . ')
							AND user_group_id = ' . intval($group_id);
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			$this->users = array();

			if ( $config->data['stat_last_user_group_id'] == $group_id )
			{
				$config->set('stat_last_user_group_id', GROUP_REGISTERED);
			}

			$sql = 'SELECT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id = ' . intval($group_id) . '
						AND user_pending <> 1
					GROUP BY user_id';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);

			while ( $row = $db->sql_fetchrow($result) )
			{
				$this->users[ intval($row['user_id']) ] = true;
			}

			$db->sql_freeresult($result);

			if ( $delete )
			{
				$group_id = GROUP_REGISTERED;
			}

			if ( !empty($this->users) )
			{
				$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_group_id = ' . intval($group_id) . '
						WHERE user_id IN (' . implode(', ' , array_keys($this->users)) . ')
							AND user_group_id = ' . GROUP_REGISTERED;
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			if ( in_array($config->data['stat_last_user'], array_keys($this->users)) )
			{
				$config->set('stat_last_user_group_id', intval($group_id));
			}

			$config->read(true);
			$this->read(true);
		}

		function set_group_weight($order_value='group_weight')
		{
			global $db;

			$order = 0;

			$sql = 'SELECT group_id
					FROM ' . GROUPS_TABLE . '
					WHERE group_single_user <> ' . true . '
						AND group_status < ' . GROUP_SPECIAL . '
					ORDER BY ' . $order_value . ' ASC';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);

			while ( $row = $db->sql_fetchrow($result) )
			{
				$order += 10;
				$sql = 'UPDATE ' . GROUPS_TABLE . '
						SET group_weight = ' . intval($order) . '
						WHERE group_id = ' . $row['group_id'];
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			$db->sql_freeresult($result);

			$this->read(true);
		}

		function group_color_select($select_name, $group_id, $user_id='')
		{
			global $template, $user, $db;

			if ( $user_id == '' )
			{
				$sql = 'SELECT g.group_id, g.group_status, g.group_name
						FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
						WHERE ug.user_id = ' . intval($user->data['user_id']) . '
							AND g.group_id = ug.group_id
							AND g.group_color = 1
							AND ug.user_pending <> 1
						ORDER BY g.group_weight ASC';
			}
			else
			{
				$sql = 'SELECT g.group_id, g.group_status, g.group_name
						FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
						WHERE ug.user_id = ' . intval($user_id) . '
							AND g.group_id = ug.group_id
							AND g.group_color = 1
							AND ug.user_pending <> 1
						ORDER BY g.group_weight ASC';
			}

			$result = $db->sql_query($sql, false, __LINE__, __FILE__);

			$i = 1;
			$user_group_color = array();

			while ( $row = $db->sql_fetchrow($result) )
			{
				$user_group_color[$i] = $row;
				$i++;
			}

			$db->sql_freeresult($result);

			$sql = 'SELECT g.group_id
					FROM ' . GROUPS_TABLE . ' g
					WHERE g.group_color = 1
						AND g.group_id = ' . GROUP_REGISTERED;
			if ( $result = $db->sql_query($sql, false, __LINE__, __FILE__) )
			{
				$user_group_color[0]['group_id'] = GROUP_REGISTERED;
				$user_group_color[0]['group_status'] = GROUP_SYSTEM;
				$user_group_color[0]['group_name'] = $user->lang('Group_registered');
				$j = 0;
			}
			else
			{
				$j = 1;
			}

			$db->sql_freeresult($result);

			if ($i != 1 && $j == 0)
			{
				$template->assign_block_vars('group_color_select',array());
			}
			else if ($i != 1 && $i != 2)
			{
				$template->assign_block_vars('group_color_select',array());
			}

			$group_color_select = '<select name="' . $select_name . '">';

			for ($i = $j; $i < count($user_group_color); $i++)
			{
				$selected = ( $group_id == $user_group_color[$i]['group_id'] ) ? ' selected="selected"' : '';
				$user_group_color[$i]['group_name'] = ($user_group_color[$i]['group_status'] == GROUP_SYSTEM) ? $user->lang($user_group_color[$i]['group_name']) : $user_group_color[$i]['group_name'];
				$group_color_select .= '<option value="' . $user_group_color[$i]['group_id'] . '"' . $selected . '>' . $user_group_color[$i]['group_name'] . '</option>';
			}

			$group_color_select .= '</select>';

			return $group_color_select;
		}

		function inactive_select($select_name)
		{
			global $config, $user;

			$inactive = $this->session_time();

			$inactive_select = '<select name="' . $select_name . '">';

			for ($i = 0; $i < count($inactive); $i++)
			{
				$selected = ( $config->data['agcm_time'] == $inactive[$i]['value'] ) ? ' selected="selected"' : '';
				$inactive_select .= '<option value="' . $inactive[$i]['value'] . '"' . $selected . '>' . $inactive[$i]['length'] . '</option>';
			}

			$inactive_select .= '</select>';

			return $inactive_select;
		}

		function session_time()
		{
			global $user;

			$inactive = array();
			$inactive[0]['value'] = '900';
			$inactive[0]['length'] = $user->lang('AGCM_15_minute');
			$inactive[1]['value'] = '3600';
			$inactive[1]['length'] = $user->lang('AGCM_1_hour');
			$inactive[2]['value'] = '43200';
			$inactive[2]['length'] = $user->lang('AGCM_12_hour');
			$inactive[3]['value'] = '86400';
			$inactive[3]['length'] = $user->lang('AGCM_1_day');
			$inactive[4]['value'] = '172800';
			$inactive[4]['length'] = $user->lang('AGCM_2_day');
			$inactive[5]['value'] = '691200';
			$inactive[5]['length'] = $user->lang('AGCM_1_week');

			return $inactive;
		}

		function display_legend()
		{
			global $template, $user, $phpEx, $theme;

			if ( count($this->data) != 0 )
			{
				for ($i = 0; $i < count($this->data); $i++)
				{
					$template->assign_block_vars('stats.legend', array(
						"U_GROUP" => append_sid("memberlist.". $phpEx ."?" . POST_GROUPS_URL . "=". $this->data[$i]['group_id']),
						"GROUP_DESCRIPTION" => ( $this->data[$i]['group_status'] == GROUP_SYSTEM ) ? $user->lang($this->data[$i]['group_description']) : $this->data[$i]['group_description'],
						"GROUP_NAME" => ( $this->data[$i]['group_status'] == GROUP_SYSTEM ) ? $user->lang($this->data[$i]['group_name']) : $this->data[$i]['group_name'],
						"GROUP_COLOR" =>  " style=\"color:#" . $theme['g' . $this->data[$i]['group_id']] . "; font-weight: bold;\"")
					);

					if ( $i < (count($this->data) - 1) && count($this->data) != 1 )
					{
						$template->assign_block_vars('stats.legend.color', array(
							"L_COMMA" => ',&nbsp;')
						);
					}
					else if ( $i < count($this->data) && ( !empty($theme['session_time']) || !empty($theme['g0']) ) )
					{
						$template->assign_block_vars('stats.legend.color', array(
							"L_COMMA" => ',&nbsp;')
						);
					}
					else
					{
						$template->set_switch('stats.legend.color', !empty($this->data[$i]));
					}
				}
			}

			if ( !empty($theme['session_time']) )
			{
				$template->assign_block_vars('stats.legend', array(
					"U_GROUP" => append_sid("memberlist.". $phpEx),
					"GROUP_DESCRIPTION" => $user->lang('AGCM_session_time_explain_legend'),
					"GROUP_NAME" => $user->lang('AGCM_session_time_legend'),
					"GROUP_COLOR" =>  " style=\"color:#" . $theme['session_time'] . "; font-weight: bold;\"")
				);

				if ( !empty($theme['g0']) )
				{
					$template->assign_block_vars('stats.legend.color', array(
						"L_COMMA" => ',&nbsp;')
					);
				}
				else if ( empty($theme['g0']) && !empty($theme['g']) )
				{
					$template->assign_block_vars('stats.legend.color', array(
						"L_COMMA" => ',&nbsp;')
					);
				}
				else
				{
					$template->assign_block_vars('stats.legend.color', array());
				}
			}

			if ( !empty($theme['g0']) )
			{
				$template->assign_block_vars('stats.legend', array(
					"U_GROUP" => append_sid("memberlist.". $phpEx),
					"GROUP_DESCRIPTION" => $user->lang('AGCM_anonymous_explain_legend'),
					"GROUP_NAME" => $user->lang('AGCM_anonymous_legend'),
					"GROUP_COLOR" =>  " style=\"color:#" . $theme['g0'] . "; font-weight: bold;\"")
				);

				if ( !empty($theme['g']) )
				{
					$template->assign_block_vars('stats.legend.color', array(
						"L_COMMA" => ',&nbsp;')
					);
				}
				else
				{
					$template->assign_block_vars('stats.legend.color', array());
				}
			}
		}

		function get_user_color($group_id, $user_session_time, $username='')
		{
			global $theme, $config;

			$user_color = $theme['g' . $group_id];

			if ( !($user_session_time >= ( time() - $config->data['agcm_time'] )) && $config->data['agcm_check'] && $user_session_time != '0' )
			{
				$user_color = $theme['session_time'];
			}

			if ( !empty($username) )
			{
				$user_color = '<span style="color:#' . $user_color . ';" class="username_color">'. $username .'</span>';
			}

			return $user_color;
		}
	}
}

?>