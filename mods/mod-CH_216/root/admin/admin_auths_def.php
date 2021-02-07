<?php
//
//	file: admin/admin_auths_def.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.2 - 28/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);

// objects available
$menus = array(
	'040_Auths_Center.Definition' => array(),
);

// define the menus
if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	foreach ( $menus as $menu => $parms )
	{
		// menu
		$options = explode('.', $menu);

		// parms
		$url_parms = '';
		if ( !empty($parms) )
		{
			foreach ( $parms as $key => $val )
			{
				if ( !empty($key) && !empty($val) )
				{
					$url_parms .= (empty($url_parms) ? '' : '&amp;') . $key . '=' . $val;
				}
			}
		}

		// create entry
		$module[ $options[0] ][ $options[1] ] = $filename . (empty($url_parms) ? '' : '?') . $url_parms;
	}

	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_auths_def';
require('./pagestart.' . $phpEx);
include($config->url('includes/class_form'));
include($config->url('includes/class_cp'));
include($config->url('includes/class_forums'));

// auth types
$auth_types = array(
	POST_FORUM_URL => 'Forum_auth_type',
	POST_PANELS_URL => 'Panel_auth_type',
	POST_GROUPS_URL => 'Group_auth_type',
);

//--------------------------------------------------------
//
//	Classes
//
//--------------------------------------------------------

//
//	Parms selection classes
//

class admin_auths_def extends auth_class
{
	function move($mode, $auth_id)
	{
		global $db;

		if ( !isset($this->data[$auth_id]) )
		{
			return;
		}

		// update the asked row
		$sql = 'UPDATE ' . AUTHS_DEF_TABLE . '
					SET auth_order = auth_order ' . (($mode == 'moveup') ? '-' : '+') . ' 15
					WHERE auth_id = ' . intval($auth_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// renum all
		$this->renum();
	}

	function import($auth_type)
	{
		global $error, $error_msg;

		switch ( $auth_type )
		{
			case POST_FORUM_URL:
				$this->import_forums();
				break;
			case POST_PANELS_URL:
				$this->import_panels();
				break;
			case POST_GROUPS_URL:
				$this->import_groups();
				break;
			default:
				_error('No_such_auth_type');
				break;
		}
		$this->renum();
	}

	function import_forums()
	{
		global $error, $error_msg;
		global $db, $config, $user;

		// get the max order for the type
		$order = 0;
		if ( !empty($this->keys[POST_FORUM_URL]) )
		{
			$tkeys = array_keys($this->keys[POST_FORUM_URL]);
			$order = $this->data[ $this->keys[POST_FORUM_URL][ $tkeys[(count($tkeys)-1)] ] ]['auth_order'];
			unset($tkeys);
		}

		// get auths def from forums
		$req_auths_def = get_forums_auths_def();
		$no_req_auths_def = array('auth_mod', 'auth_mod_display', 'auth_manage');
		$auths_def = array_merge($req_auths_def, $no_req_auths_def);
		$count_auths_def = count($auths_def);

		// create or update the entries
		$db->sql_stack_reset();
		$auth_names = array();
		for ( $i = 0; $i < $count_auths_def; $i++ )
		{
			if ( !isset($this->keys[POST_FORUM_URL][ $auths_def[$i] ]) )
			{
				$order += 10;
				$fields = array(
					'auth_type' => POST_FORUM_URL,
					'auth_name' => $auths_def[$i],
					'auth_desc' => ($user->lang($auth_name) != $auth_name) ? $auths_def[$i] : '',
					'auth_title' => false,
					'auth_order' => $order,
				);
				$auth_names[] = $auths_def[$i];

				// prepare insert rows
				$db->sql_stack_statement($fields);
			}
		}
		if ( !empty($db->sql_stack_values) )
		{
			$db->sql_stack_insert(AUTHS_DEF_TABLE, false, __LINE__, __FILE__);
			$this->read(true);
			_error('Forums_auths_def_imported');
		}
		else
		{
			_error('Forums_auths_def_done');
		}

		// some requirements have been added : migrate the auths
		if ( !empty($auth_names) )
		{
			$count_auth_names = count($auth_names);

			// read authed groups
			$sql = 'SELECT *
						FROM ' . AUTH_ACCESS_TABLE . '
						ORDER BY forum_id';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$acls = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				for ( $i = 0; $i < $count_auth_names; $i++ )
				{
					$auth_name = $auth_names[$i];

					// adjust some auths
					if ( $auth_name = 'auth_mod_display' )
					{
						$row[$auth_name] = $row['auth_mod'];
					}
					if ( $row[$auth_name] )
					{
						if ( !isset($acls[ intval($row['forum_id']) ]) )
						{
							$acls[ $row['forum_id'] ] = array();
						}
						if ( !isset($acls[ intval($row['forum_id']) ][$auth_name]) )
						{
							$acls[ intval($row['forum_id']) ][$auth_name] = array();
						}
						$acls[ intval($row['forum_id']) ][$auth_name][] = intval($row['group_id']);
					}
				}
			}
			$db->sql_freeresult($result);

			// get forums auths requirements
			$t_auth_names = array_flip($auth_names);
			$count_no_req_auths_def = count($no_req_auths_def);
			for ( $i = 0; $i < $count_no_req_auths_def; $i++ )
			{
				if ( isset($t_auth_names[ $no_req_auths_def[$i] ]) )
				{
					unset($t_auth_names[ $no_req_auths_def[$i] ]);
				}
			}
			$t_auth_names = array_flip($t_auth_names);
			$sql = 'SELECT forum_id' . (empty($t_auth_names) ? '' : ', ' . implode(', ', $t_auth_names)) . '
						FROM ' . FORUMS_TABLE;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$db->sql_stack_reset();
			while ( $row = $db->sql_fetchrow($result) )
			{
				// check requirements
				for ( $i = 0; $i < $count_auth_names; $i++ )
				{
					switch ( $auth_names[$i] )
					{
						case 'auth_mod':
							$auth_req = AUTH_ACL;
							break;
						case 'auth_mod_display':
							$auth_req = AUTH_MOD;
							break;
						case 'auth_manage':
							$auth_req = AUTH_ADMIN;
							break;
						default:
							$auth_req = $row[ $auth_names[$i] ];
							break;
					}
					$group_ids = array();
					switch ( $auth_req )
					{
						case AUTH_ALL:
							$group_ids[] = GROUP_ANONYMOUS;
						case AUTH_REG:
							$group_ids[] = GROUP_REGISTERED;
							break;
						case AUTH_MOD:
						case AUTH_ACL:
							$auth_name = ($auth_req == AUTH_MOD) ? 'auth_mod' : $auth_names[$i];
							if ( !empty($acls[ intval($row['forum_id']) ][$auth_name]) )
							{
								$group_ids = $acls[ intval($row['forum_id']) ][$auth_name];
							}
							// we don't want to display admin as moderators
							if ( $auth_names[$i] == 'auth_mod_display' )
							{
								break;
							}
						case AUTH_ADMIN:
							$group_ids[] = GROUP_ADMIN;
							break;
					}

					// build the sql request
					if ( !empty($group_ids) )
					{
						$count_group_ids = count($group_ids);
						for ( $j = 0; $j < $count_group_ids; $j++ )
						{
							$fields = array(
								'group_id' => $group_ids[$j],
								'obj_type' => POST_FORUM_URL,
								'obj_id' => intval($row['forum_id']),
								'auth_name' => $auth_names[$i],
								'auth_value' => true,
							);
							$db->sql_stack_statement($fields);
						}
					}
				}
			}
			$db->sql_freeresult($result);

			// create the auths access
			if ( !empty($db->sql_stack_values) )
			{
				$db->sql_stack_insert(AUTHS_TABLE, false, __LINE__, __FILE__);
				_error('Forums_auths_imported');

				// clear the caches
				$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
							WHERE cache_id LIKE \'' . POST_FORUM_URL . '%\'';
				$db->sql_query($sql, false, __LINE__, __FILE__);

				// update the forums requirements to AUTH_ACL
				$fields = array();
				$count_req_auths_def = count($req_auths_def);
				for ( $i = 0; $i < $count_req_auths_def; $i++ )
				{
					$fields[ $req_auths_def[$i] ] = AUTH_ACL;
				}
				$db->sql_statement($fields);
				if ( !empty($fields) )
				{
					$sql = 'UPDATE ' . FORUMS_TABLE . '
								SET ' . $db->sql_update;
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}

				// clear the auths access table to prevent access by a script addressing directly the auths access table
//				$sql = 'DELETE FROM ' . AUTH_ACCESS_TABLE;
//				$db->sql_query($sql, false, __LINE__, __FILE__);

				// update mods status
				$moderators = new moderators();
				$moderators->set_users_status();
				$moderators->read(true);
			}
		}
	}

	function import_panels()
	{
		global $db, $user;
		global $error, $error_msg;

		// get the max order for the type
		$order = 0;
		if ( !empty($this->keys[POST_PANELS_URL]) )
		{
			$tkeys = array_keys($this->keys[POST_PANELS_URL]);
			$order = $this->data[ $this->keys[POST_PANELS_URL][ $tkeys[(count($tkeys)-1)] ] ]['auth_order'];
			unset($tkeys);
		}

		// read all panels having auths
		$sql = 'SELECT DISTINCT panel_auth_name
					FROM ' . CP_PANELS_TABLE . '
					WHERE panel_auth_type = \'' . POST_PANELS_URL . '\'
						AND panel_auth_name <> \'\'
					GROUP BY panel_auth_name';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$db->sql_stack_reset();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( !isset($this->keys[POST_PANELS_URL][ $row['panel_auth_name'] ]) )
			{
				$order += 10;
				$fields = array(
					'auth_type' => POST_PANELS_URL,
					'auth_name' => $row['panel_auth_name'],
					'auth_desc' => ($user->lang($row['panel_auth_name']) != $row['panel_auth_name']) ? $row['panel_auth_name'] : '',
					'auth_title' => false,
					'auth_order' => $order,
				);
				$db->sql_stack_statement($fields);
			}
		}
		$db->sql_freeresult($result);
		if ( !empty($db->sql_stack_values) )
		{
			$db->sql_stack_insert(AUTHS_DEF_TABLE, false, __LINE__, __FILE__);
			$this->read(true);
			_error('Panels_auths_def_imported');
		}
		else
		{
			_error('Panels_auths_def_done');
		}
	}

	function import_groups()
	{
		global $db, $user;
		global $error, $error_msg;

		// get the max order for the type
		$order = 0;
		if ( !empty($this->keys[POST_GROUPS_URL]) )
		{
			$tkeys = array_keys($this->keys[POST_GROUPS_URL]);
			$order = $this->data[ $this->keys[POST_GROUPS_URL][ $tkeys[(count($tkeys)-1)] ] ]['auth_order'];
			unset($tkeys);
		}

		// get all groups auths def
		$auths_def = array();

		// read all panels having auths
		$sql = 'SELECT DISTINCT panel_auth_name
					FROM ' . CP_PANELS_TABLE . '
					WHERE panel_auth_type = \'' . POST_GROUPS_URL . '\'
						AND panel_auth_name <> \'\'
					GROUP BY panel_auth_name';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( !isset($this->keys[POST_GROUPS_URL][ $row['panel_auth_name'] ]) )
			{
				$auths_def[ $row['panel_auth_name'] ] = true;
			}
		}
		$db->sql_freeresult($result);

		// get also auths sat on fields
		$sql = 'SELECT field_attr
					FROM ' . CP_FIELDS_TABLE . '
					WHERE field_attr LIKE \'%field_auth%\'
						AND field_name <> \'\'';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			// unpack data
			$field = unserialize(stripslashes($row['field_attr']));

			// check auths
			if ( !empty($field['field_auth']) && !isset($this->keys[POST_GROUPS_URL][ $field['field_auth'] ]) )
			{
				$auths_def[ $field['field_auth'] ] = true;
			}
		}
		$db->sql_freeresult($result);

		// prepare auths defs creation
		$db->sql_stack_reset();
		if ( !empty($auths_def) )
		{
			foreach ( $auths_def as $auth_name => $dummy )
			{
				$order += 10;
				$fields = array(
					'auth_type' => POST_GROUPS_URL,
					'auth_name' => $auth_name,
					'auth_desc' => ($user->lang($auth_name) != $auth_name) ? $auth_name : '',
					'auth_title' => false,
					'auth_order' => $order,
				);
				$db->sql_stack_statement($fields);
			}
		}

		// create the relevant added auths def
		if ( !empty($db->sql_stack_values) )
		{
			$db->sql_stack_insert(AUTHS_DEF_TABLE, false, __LINE__, __FILE__);
			$this->read(true);
			_error('Groups_auths_def_imported');
		}
		else
		{
			_error('Groups_auths_def_done');
		}
	}
}

class auths_def_list extends generic_form
{
	var $auths_def;
	var $auth_type;
	var $title;
	var $explain;

	function auths_def_list($requester, $parms, $return_message)
	{
		global $auth_type, $auths_def, $mode, $mode_allowed;

		parent::generic_form($requester, $parms, $return_message);
		$this->title = $mode_allowed[$mode]['title'];
		$this->explain = $mode_allowed[$mode]['explain'];
		$this->auth_type = &$auth_type;
		$this->auths_def = &$auths_def;
	}

	function init()
	{
		global $auth_types;

		parent::init();
		$fields = array(
			POST_AUTHS_URL => array('type' => 'list', 'legend' => 'Auth_type', 'options' => $auth_types, 'value' => $this->auth_type, 'html' => ' size="' . count($auth_types) . '" onchange="this.form.submit();"'),
		);
		$this->init_form($fields);
	}

	function display()
	{
		global $template, $config, $user;

		// buttons
		$this->set_buttons(array(
			'create_det' => array('txt' => 'Create_auths_def', 'img' => 'cmd_create', 'key' => 'cmd_create'),
			'import_def' => array('txt' => 'Import_auths_def', 'img' => 'cmd_regen', 'key' => 'cmd_regen'),
		));

		// display the form
		parent::display();

		// display list
		if ( !empty($this->auths_def->keys[$this->auth_type]) )
		{
			$color = false;
			$parms = $this->parms + array(POST_AUTHS_URL => $this->auth_type);
			foreach ( $this->auths_def->keys[$this->auth_type] as $auth_name => $auth_id )
			{
				$auth_data = &$this->auths_def->data[$auth_id];
				$color = !$color;
				$template->assign_block_vars('row', array(
					'AUTH_NAME' => $auth_data['auth_name'],
					'AUTH_DESC' => empty($auth_data['auth_desc']) ? $user->lang($auth_data['auth_name']) : $user->lang($auth_data['auth_desc']),
					'U_EDIT' => $config->url($this->requester, $parms + array('mode' => 'edit', 'id' => $auth_id), true),
					'U_DELETE' => $config->url($this->requester, $parms + array('mode' => 'delete', 'id' => $auth_id), true),
					'U_MOVEUP' => $config->url($this->requester, $parms + array('mode' => 'moveup', 'id' => $auth_id), true),
					'U_MOVEDW' => $config->url($this->requester, $parms + array('mode' => 'movedw', 'id' => $auth_id), true),
				));
				if ( $auth_data['auth_title'] )
				{
					$template->set_switch('row.title');
					$color = false;
				}
				else
				{
					$template->set_switch('row.light', $color);
				}
			}
		}
		$template->set_switch('empty', empty($this->auths_def->keys[$this->auth_type]));


		// add titles
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($this->title),
			'L_TITLE_EXPLAIN' => $user->lang($this->explain),
			'L_FORM' => $user->lang($this->title),

			'L_AUTHS' => $user->lang('Permissions'),
			'L_ACTION' => $user->lang('Action'),
			'L_SELECT' => $user->lang('Select_auth_type'),
			'I_SELECT' => $user->img('cmd_select'),
			'SELECT' => 'select_auth_type',

			'L_MOVEUP' => $user->lang('Move_up'),
			'I_MOVEUP' => $user->img('cmd_up_arrow'),
			'L_MOVEDW' => $user->lang('Move_down'),
			'I_MOVEDW' => $user->img('cmd_down_arrow'),
			'I_EDIT' => $user->img('cmd_mini_edit'),
			'L_EDIT' => $user->lang('Edit'),
			'I_DELETE' => $user->img('cmd_mini_delete'),
			'L_DELETE' => $user->lang('Delete'),

			'L_EMPTY' => $user->lang('No_auths_def'),
		));
		$template->set_filenames(array('body' => 'admin/auths_def_body.tpl'));

		return true;
	}
}

class auths_def_detail extends generic_form
{
	var $auths_def;
	var $auth_type;
	var $auth_id;
	var $title;
	var $explain;

	function auths_def_detail($requester, $parms, $return_message)
	{
		global $auth_type, $auths_def, $auth_id, $mode, $mode_allowed;

		parent::generic_form($requester, $parms, $return_message);
		$this->title = $mode_allowed[$mode]['title'];
		$this->explain = $mode_allowed[$mode]['explain'];
		$this->auth_type = &$auth_type;
		$this->auths_def = &$auths_def;
		$this->auth_id = &$auth_id;
	}

	function process($mode)
	{
		$this->init($mode);
		if ( _button('submit_det') )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_det') )
		{
			$this->display();
		}
	}

	function init($mode)
	{
		global $config, $user;
		global $auth_types;

		parent::init();
		$this->mode = $mode;

		// check the parms
		if ( in_array($this->mode, array('edit', 'delete')) && empty($this->auth_id) )
		{
			message_return('No_such_auth_id', 'Click_return_auths_def', $config->url($this->requester, $this->parms, true));
		}
		$create = ($this->mode == 'create');

		$auth_titles = array(
			0 => 'No',
			1 => 'Yes',
		);

		$order_list = array(5 => $user->lang('Top'));
		$order_value = 5;
		$found = false;
		if ( !empty($this->auths_def->keys[$this->auth_type]) )
		{
			foreach ( $this->auths_def->keys[$this->auth_type] as $auth_name => $auth_id )
			{
				if ( $auth_id == $this->auth_id )
				{
					$found = true;
				}
				else
				{
					$auth_order = $this->auths_def->data[$auth_id]['auth_order'] + 5;
					if ( !$found )
					{
						$order_value = $auth_order;
					}
					$order_list[$auth_order] = $auth_name;
				}
			}
		}

		// build the form
		$fields = array(
			POST_AUTHS_URL => array('type' => 'vachar', 'output' => true, 'legend' => 'Auth_type', 'value' => $user->lang($auth_types[$this->auth_type])),
			'auth_name' => array('type' => 'varchar', 'legend' => 'Auth_name', 'explain' => 'Auth_name_explain', 'value' => $create ? '' : $this->auths_def->data[$this->auth_id]['auth_name'], 'length_maxi' => 50, 'length_mini' => '5'),
			'auth_desc' => array('type' => 'text', 'legend' => 'Auth_desc', 'value' => $create ? '' : $this->auths_def->data[$this->auth_id]['auth_desc']),
			'auth_title' => array('type' => 'radio_list', 'legend' => 'Auth_title', 'explain' => 'Auth_title_explain', 'value' => $create ? 0 : $this->auths_def->data[$this->auth_id]['auth_title'], 'options' => $auth_titles),
			'auth_order' => array('type' => 'list', 'legend' => 'Auth_order', 'value' => $order_value, 'options' => $order_list, 'options.no_translate' => true, 'html' => ' size="' . min(7, count($order_list)) . '"'),
		);
		if ( $this->mode == 'delete' )
		{
			foreach ( $fields as $field_name => $field_data )
			{
				$fields[$field_name]['output'] = true;
				if ( isset($fields[$field_name]['explain']) )
				{
					unset($fields[$field_name]['explain']);
				}
			}
			unset($fields['auth_order']);
			$fields['auth_desc']['value'] = $user->lang($fields['auth_desc']['value']);
			$fields['auth_title']['type'] = 'varchar';
			$fields['auth_title']['value'] = $user->lang($auth_titles[ $fields['auth_title']['value'] ]);
		}
		$this->init_form($fields);
	}

	function check()
	{
		global $error, $error_msg;
		global $config;

		parent::check();

		if ( !$error )
		{
			if ( in_array($this->mode, array('edit', 'delete')) && (!isset($this->auths_def->data[$this->auth_id]) || ($this->auths_def->data[$this->auth_id]['auth_type'] != $this->auth_type)) )
			{
				_error('No_such_auth_id');
				$this->mode = '';
			}
		}
		if ( $error )
		{
			$l_link = 'Click_return_auths_def';
			$u_link = $config->url($this->requester, $this->parms + array('id' => $this->auth_id, 'mode' => $this->mode), true);
			message_return($error_msg, $l_link, $u_link);
		}
	}

	function validate()
	{
		global $db, $config;
		global $error, $error_msg;

		if ( $this->mode == 'delete' )
		{
			// clear the auths relative information if the auth wasn't a title
			if ( !$this->auths_def->data[$this->auth_title] )
			{
				// get all preset ids linked to this auth type
				$preset_ids = array();
				$sql = 'SELECT preset_id
							FROM ' . PRESETS_TABLE . '
							WHERE preset_type = \'' . $this->auth_type . '\'';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$preset_ids[] = intval($row['preset_id']);
				}
				$db->sql_freeresult($result);

				// delete all presets entries
				if ( !empty($preset_ids) )
				{
					$sql = 'DELETE FROM ' . PRESETS_DATA_TABLE . '
								WHERE preset_id IN (' . implode(', ', $preset_ids) . ')
									AND preset_auth = \'' . $db->sql_escape_string($this->auths_def->data[$this->auth_id]['auth_name']) . '\'';
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}

				// delete this auth from the auths table
				$sql = 'DELETE FROM ' . AUTHS_TABLE . '
							WHERE obj_type = \'' . $this->auth_type . '\'
								AND auth_name = \'' . $db->sql_escape_string($this->auths_def->data[$this->auth_id]['auth_name']) . '\'';
				$db->sql_query($sql, false, __LINE__, __FILE__);

				// update icons
				if ( $this->auth_type == POST_FORUM_URL )
				{
					$sql = 'UPDATE ' . ICONS_TABLE . '
								SET icon_auth = \'\'
								WHERE icon_auth = \'' . $db->sql_escape_string($this->auths_def->data[$this->auth_id]['auth_name']) . '\'';
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}

				// force all the caches to be regenerated
				$sql = 'DELETE FROM ' . USERS_CACHE_TABLE . '
							WHERE cache_id LIKE \'' . $this->auth_type . '%\'';
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			// finaly delete the auth def
			$sql = 'DELETE FROM ' . AUTHS_DEF_TABLE . '
						WHERE auth_id = ' . intval($this->auth_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			_error('Auths_def_deleted');
		}
		else
		{
			$fields = array(
				'auth_type' => $this->auth_type,
				'auth_name' => $this->fields['auth_name']->value,
				'auth_desc' => $this->fields['auth_desc']->value,
				'auth_title' => intval( $this->fields['auth_title']->value),
				'auth_order' => intval( $this->fields['auth_order']->value),
			);
			$db->sql_statement($fields);
			if ( $this->mode == 'create' )
			{
				$sql = 'INSERT INTO ' . AUTHS_DEF_TABLE . '
							(' . $db->sql_fields . ') VALUES (' . $db->sql_values . ')';
				_error('Auths_def_created');
			}
			else
			{
				$sql = 'UPDATE ' . AUTHS_DEF_TABLE . '
							SET ' . $db->sql_update . '
							WHERE auth_id = ' . intval($this->auth_id);
				_error('Auths_def_updated');
			}
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// renum
		$this->auths_def->renum();

		// send achievement message
		$l_link = 'Click_return_auths_def';
		$u_link = $config->url($this->requester, $this->parms, true);
		message_return($error_msg, $l_link, $u_link);
	}

	function display()
	{
		global $template, $config, $user;
		global $mode_allowed;

		// buttons
		$this->set_buttons(array(
			'submit_det' => $mode_allowed[$this->mode]['submit_button'],
			'cancel_det' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		));

		// display the form
		parent::display();

		// add titles
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($this->title),
			'L_TITLE_EXPLAIN' => $user->lang($this->explain),
			'L_FORM' => $user->lang($this->title),
		));
		$template->set_filenames(array('body' => 'form_body.tpl'));
		if ( $this->mode != 'create' )
		{
			_hide('id', $this->auth_id);
		}
		_hide('mode', $this->mode);

		return true;
	}
}

//--------------------------------------------------------
//
//	main process
//
//--------------------------------------------------------
// get plug ins
$plug_ins = new plug_ins();
$plug_ins->load('admin_auths_def');
unset($plug_ins);

// plugs
if ( $config->plug_ins['admin_auths_def'] )
{
	foreach ( $config->plug_ins['admin_auths_def'] as $plug => $dummy )
	{
		if ( method_exists($config->plug_ins['admin_auths_def'][$plug], 'start') )
		{
			$config->plug_ins['admin_auths_def'][$plug]->start($auth_types);
		}
	}
}

$parms = array();

// values allowed for 'mode=' parm
$mode_allowed = array(
	'' => array('title' => 'Auths_definition', 'explain' => 'Auths_definition_explain'),
	'moveup' => '',
	'movedw' => '',
	'edit' => array('title' => 'Edit_auths_def', 'explain' => 'Edit_auths_def_explain', 'submit_button' => array('txt' => 'Edit_auths_def', 'img' => 'cmd_submit', 'key' => 'cmd_submit')),
	'create' => array('title' => 'Create_auths_def', 'explain' => 'Create_auths_def_explain', 'submit_button' => array('txt' => 'Create_auths_def', 'img' => 'cmd_create', 'key' => 'cmd_create')),
	'delete' => array('title' => 'Delete_auths_def', 'explain' => 'Delete_auths_def_explain', 'submit_button' => array('txt' => 'Delete_auths_def', 'img' => 'cmd_delete', 'key' => 'cmd_delete')),
);

// parms
$auth_type = '';
$auth_id = 0;

// auths def
$auths_def = new admin_auths_def();
$auths_def->read();

// read parms
$auth_type = _read(POST_AUTHS_URL, TYPE_NO_HTML, '', $auth_types);
$auth_id = _read('id', TYPE_INT, '', array(0 => '') + $auths_def->data);
$mode = _read('mode', TYPE_NO_HTML, '', $mode_allowed);

// handle some buttons
if ( _button('create_det') )
{
	$mode = 'create';
}
if ( _button('cancel_det') )
{
	$mode = '';
}
if ( _button('import_def') )
{
	$auths_def->import($auth_type);
	message_return($error_msg, 'Click_return_auths_def', $config->url($requester, $parms + array(POST_AUTHS_URL => $auth_type), true));
}
if ( in_array($mode, array('moveup', 'movedw')) )
{
	$auths_def->move($mode, $auth_id);
	$mode = '';
}
if ( in_array($mode, array('edit', 'create', 'delete')) )
{
	$parms[POST_AUTHS_URL] = $auth_type;
	$auths_def_detail = new auths_def_detail($requester, $parms, 'Click_return_auths_def');
	$auths_def_detail->process($mode);
}

if ( empty($mode) )
{
	$auths_def_list = new auths_def_list($requester, $parms, 'Click_return_auths_def');
	$auths_def_list->process();
}

// close display
_hide_set();
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>