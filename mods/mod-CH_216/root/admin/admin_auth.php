<?php
//
//	file: admin/admin_auth.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.4 - 13/06/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);
define('NAV_SEPARATOR', '&raquo;');

// objects available
$menus = array(
	'040_Auths_Center.Manage' => array(),
//	'Control_panels.10_Permissions_manager' => array(POST_AUTHS_URL => POST_PANELS_URL, 'dir' => ''),
//	'Control_panels.11_Permissions_managed' => array(POST_AUTHS_URL => POST_PANELS_URL, 'dir' => '1'),
//	'Forums.10_Permissions_manager' => array(POST_AUTHS_URL => POST_FORUM_URL, 'dir' => ''),
//	'Forums.11_Permissions_managed' => array(POST_AUTHS_URL => POST_FORUM_URL, 'dir' => '1'),
//	'Groups.10_Permissions_manager' => array(POST_AUTHS_URL => POST_GROUPS_URL, 'dir' => ''),
//	'Groups.11_Permissions_managed' => array(POST_AUTHS_URL => POST_GROUPS_URL, 'dir' => '1'),
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
$requester = 'admin/admin_auth';
require('./pagestart.' . $phpEx);

include($config->url('includes/class_form'));
include($config->url('includes/class_cp'));
include($config->url('includes/class_presets'));
include($config->url('includes/class_groups_select'));
include($config->url('includes/class_forums'));

// auth types
$auth_types = array(
	POST_FORUM_URL => 'Forum_auth_type',
	POST_PANELS_URL => 'Panel_auth_type',
	POST_GROUPS_URL => 'Group_auth_type',
);
$auth_objects = array(
	POST_FORUM_URL => 'forums',
	POST_PANELS_URL => 'panels',
	POST_GROUPS_URL => 'groups',
);

// direction
$auth_directions = array(
	0 => 'Manager',
	1 => 'Object_managed',
);

//--------------------------------------------------------
//
//	Classes
//
//--------------------------------------------------------

//
//	Parms selection classes
//

class auth_type_parms extends generic_form
{
	var $auth_type;
	var $direction;

	var $title;
	var $explain;

	function auth_type_parms($title, $explain, $requester, $parms, $return_message)
	{
		global $forums;

		parent::generic_form($requester, $parms, $return_message);
		$this->title = $title;
		$this->explain = $explain;
	}

	function process($auth_type, $direction, $force_display=false)
	{
		// an auth type has been provided : check it
		if ( !empty($auth_type) && !$force_display )
		{
			$this->check($auth_type, $direction);
			$this->validate($auth_type, $direction);
			return false;
		}

		// no auth type provided : ask for one
		$this->init();
		if ( _button('select_auth_type') )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_auth_type') && empty($this->auth_type) )
		{
			return $this->display();
		}
		return false;
	}

	function init()
	{
		global $auth_types, $auth_directions;
		global $user;

		$fields = array(
			'auth_type' => array('type' => 'list', 'legend' => 'Auth_type', 'options' => $auth_types, 'html' => ' size="' . count($auth_types) . '" onchange="this.form.submit();"'),
			'direction' => array('type' => 'radio_list', 'legend' => 'Auth_direction', 'options' => $auth_directions, 'options.linefeed' => true),
		);
		$this->init_form($fields);
		$this->fields['direction']->data['options'][true] = sprintf($user->lang($this->fields['direction']->data['options'][true]), $user->lang($this->fields['auth_type']->data['options'][ $this->fields['auth_type']->value ]));
	}

	function check($auth_type='', $direction='')
	{
		global $auth_types, $auth_directions;
		global $error, $error_msg;
		global $config;

		// an auth_type has been provided
		if ( empty($this->fields) )
		{
			if ( !isset($auth_types[$auth_type]) || !isset($auth_directions[$direction]) )
			{
				_error('No_valid_action');
			}
		}
		// no auth type provided : check the form
		else
		{
			parent::check();
		}
		if ( $error )
		{
			$l_return = $this->message_return;
			$u_return = $config->url($this->requester, $this->parms, true);
			message_return($error_msg, $l_return, $u_return, 10);
		}
	}

	function validate($auth_type='', $direction='')
	{
		if ( empty($this->fields) )
		{
			$this->auth_type = $auth_type;
			$this->direction = $direction;
		}
		else
		{
			$this->auth_type = $this->fields['auth_type']->value;
			$this->direction = $this->fields['direction']->value;
		}
	}

	function display()
	{
		global $template, $config, $user;

		// buttons
		$this->set_buttons(array(
			'select_auth_type' => array('txt' => 'Select', 'img' => 'cmd_select', 'key' => 'cmd_select'),
		));

		// display the form
		parent::display();

		// add titles
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($this->title),
			'L_TITLE_EXPLAIN' => $user->lang($this->explain),
			'L_FORM' => $user->lang('Select_auth_type_dir'),
		));
		$template->set_filenames(array('body' => 'form_body.tpl'));

		return true;
	}
}

class select_tree extends generic_form
{
	var $title;
	var $explain;

	var $form_title;
	var $list_legend;
	var $list_explain;
	var $buttons;

	var $object_id;
	var $objects;
	var $object_name;

	function select_tree($title, $explain, $requester, $parms, $return_message)
	{
		parent::generic_form($requester, $parms, $return_message);
		$this->title = $title;
		$this->explain = $explain;
		$this->object_id = 0;
	}

	function process($object_id, $force_display=false)
	{
		// a object_id has been provided : check it
		$object_id = intval($object_id);
		if ( $object_id && ($object_id > LOWER_ID) && !$force_display )
		{
			$this->check($object_id);
			$this->validate($object_id);
			return false;
		}

		// no object_id provided : ask for one
		$this->init();
		if ( _button('select_object') )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_object') && (!$this->object_id || ($this->object_id <= LOWER_ID)) )
		{
			return $this->display();
		}
		return false;
	}

	function init()
	{
		global $user;

		$objects_list = array();
		$front_pic = $this->objects->get_front_pic();
		if ( !empty($front_pic) )
		{
			foreach ( $front_pic as $object_id => $front )
			{
				$object_id = intval($object_id);
				$count_front = strlen($front);
				$option = '';
				for ( $i = 0; $i < $count_front; $i++ )
				{
					$option .= $user->lang('tree_pic_' . $front[$i]);
				}
				if ( $object_id > LOWER_ID )
				{
					$option .= $user->lang($this->objects->data[$object_id][$this->object_name]);
				}
				$objects_list[$object_id] = $option;
			}
		}
		else
		{
			$objects_list[ (LOWER_ID - 1) ] = 'None';
		}

		$fields = array(
			'object_id' => array('type' => 'list', 'legend' => $this->list_legend, 'explain' => $this->list_explain, 'options' => $objects_list, 'value' => 0, 'html' => ' size="' . min(10, count($objects_list)) . '"'),
		);
		$this->init_form($fields);
	}

	function init_form(&$fields)
	{
		parent::init_form($fields);
		$this->buttons = array(
			'select_object' => array('txt' => 'Select', 'img' => 'cmd_select', 'key' => 'cmd_select'),
		);
	}

	function check($object_id=0)
	{
		global $config;
		global $error, $error_msg;

		// an object_id has been provided
		$object_id = intval($object_id);
		if ( empty($this->fields) )
		{
			if ( !$this->objects->auth($object_id) )
			{
				_error('Not_Authorised');
			}
		}
		// no object_id provided : check the form
		else
		{
			parent::check();
		}
		if ( $error )
		{
			$l_return = $this->return_message;
			$u_return = $config->url($this->requester, $this->parms, true);
			message_return($error_msg, $l_return, $u_return, 10);
		}
	}

	function validate($object_id=0)
	{
		if ( empty($this->fields) )
		{
			$this->object_id = intval($object_id);
		}
		else
		{
			$this->object_id = intval($this->fields['object_id']->value);
		}
	}

	function display()
	{
		global $template, $config, $user;

		// display the form
		parent::display();

		// add titles
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($this->title),
			'L_TITLE_EXPLAIN' => $user->lang($this->explain),
			'L_FORM' => $user->lang($this->form_title),
		));
		$template->set_filenames(array('body' => 'form_body.tpl'));

		return true;
	}
}

//
//	Overview classes
//

class overview extends generic_form
{
	var $presets;
	var $presets_type;
	var $preset_ids;

	var $direction;
	var $auth_type;
	var $groups;
	var $objects;

	var $group_id;
	var $object_id;

	var $form;
	var $title;
	var $explain;
	var $object_title;
	var $object_name;
	var $object_desc;

	function overview($title, $explain, $requester, $parms, $return_message)
	{
		global $config;
		global $direction, $auth_type, $groups, $group_id, $objects, $object_id;

		$this->fields = array();
		parent::generic_form($requester, $parms, $return_message);

		// parms
		$this->direction = $direction;
		$this->auth_type = $auth_type;
		$this->groups = &$groups;
		$this->objects = &$objects;

		// form def
		$this->title = $title;
		$this->explain = $explain;
		$this->form = ($this->direction || ($this->auth_type == POST_GROUPS_URL)) ? 'admin/auth_overview_group_body.tpl' : 'admin/auth_overview_body.tpl';

		// we are going to display objects
		if ( !$this->direction )
		{
			if ( isset($this->parms['obj']) )
			{
				unset($this->parms['obj']);
			}

			// intantiate the objects
			$this->get_objects();
			$this->group_id = intval($group_id);
			$this->object_id = 0;
			if ( !$this->groups->auth($this->group_id) )
			{
				if ( isset($this->parms[POST_GROUPS_URL]) )
				{
					unset($this->parms[POST_GROUPS_URL]);
				}
				message_return('Not_Authorised', $this->return_message, $config->url($this->requester, $this->parms, true));
			}
		}
		// we are going to display groups
		else
		{
			if ( isset($this->parms[POST_GROUPS_URL]) )
			{
				unset($this->parms[POST_GROUPS_URL]);
			}

			// intantiate the groups (accept special groups)
			$this->groups = new admin_groups(true);
			$this->group_id = 0;
			$this->object_id = intval($object_id);
			if ( !$this->objects->auth($this->object_id) )
			{
				if ( isset($this->parms['obj']) )
				{
					unset($this->parms['obj']);
				}
				message_return('Not_Authorised', $this->return_message, $config->url($this->requester, $this->parms, true));
			}
		}
	}

	function process($list_id, $force_display=false)
	{
		// an object of the list has been provided : check it
		$list_id = intval($list_id);
		if ( $list_id && !$force_display )
		{
			$this->check(true, $list_id);
			return false;
		}

		// no object of the list provided : get one (overview display)
		$this->init();
		if ( _button('submit_overview') )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_overview') && ((!$this->direction && !$this->object_id) || ($this->direction && !$this->group_id)) )
		{
			return $this->display();
		}
		return false;
	}

	function init()
	{
		// get auths def & auth values
		$this->objects->get_auths_def();
		$this->objects->get_auth_values($this->group_id, $this->object_id, $this->direction ? 'group_id' : 'obj_id');
		if ( !$this->direction )
		{
			// groups are readed from auths, other objects are readed when instantiate
			if ( $this->auth_type == POST_GROUPS_URL )
			{
				$this->objects->read($this->objects->auth_values);
			}
			$list = &$this->objects;
		}
		else
		{
			// groups are readed from auths
			$this->groups->read($this->objects->auth_values);
			$list = &$this->groups;
		}

		// read presets
		$this->presets = new presets($this->presets_type);
		$this->presets->read();

		// get preset_ids from form
		$preset_ids = _button('dsp_overview') ? _read('preset_ids', '', '', '', true) : array();

		// keep only existing presets on existing objects
		$this->preset_ids = array();
		if ( !empty($list->data) )
		{
			foreach ( $list->data as $list_id => $list_data )
			{
				$list_id = intval($list_id);
				if ( $list_id )
				{
					$preset_id = isset($preset_ids[$list_id]) ? intval($preset_ids[$list_id]) : 0;
					$this->preset_ids[$list_id] = isset($this->presets->names[$preset_id]) ? intval($preset_id) : 0;

					// get auth values from presets data if not custom
					if ( !empty($this->preset_ids[$list_id]) )
					{
						$this->objects->auth_values[$list_id] = array();
						if ( !empty($this->objects->auths_def) )
						{
							foreach ( $this->objects->auths_def as $auth_name => $auth_def )
							{
								if ( !$auth_def['auth_title'] && $this->presets->data[ $this->preset_ids[$list_id] ][$auth_name] )
								{
									$this->objects->auth_values[$list_id][$auth_name] = $this->presets->data[ $this->preset_ids[$list_id] ][$auth_name];
								}
							}
						}
					}

					// find the real preset
					$this->preset_ids[$list_id] = $this->presets->search($this->objects->auth_values[$list_id]);
				}
			}
		}
	}

	function check($check_only=false, $list_id=0)
	{
		global $config;
		global $error, $error_msg;

		if ( $check_only )
		{
			// we check a particular object
			$authed = false;
			if ( !$this->direction )
			{
				$authed = $this->objects->auth($list_id);
				$this->object_id = $list_id;
			}
			// we check a particular group
			else
			{
				$authed = $this->groups->auth($list_id);
				$this->group_id = $list_id;
			}
			if ( !$authed )
			{
				$this->parms = array(POST_AUTHS_URL => $this->parms[POST_AUTHS_URL], 'dir' => $this->parms['dir']);
				$this->return_message = 'Click_return_auths';
			}
		}
		if ( $error )
		{
			// send achievement message
			$l_link = $this->return_message;
			$u_link = $config->url($this->requester, $this->parms, true, '', true);
			message_return($error_msg, $l_link, $u_link);
		}
	}

	function validate()
	{
		global $db, $config, $user;
		global $warning, $warning_msg;

		// warnings
		if ( $warning )
		{
			_warning('Please_confirm');
			return;
		}

		// get the appropriate list
		$list_ids = array();
		if ( !$this->direction )
		{
			$header_field = 'group_id';
			$list_field = 'obj_id';
			$header_id = $this->group_id;
			$list = &$this->objects;
		}
		else
		{
			$header_field = 'obj_id';
			$list_field = 'group_id';
			$header_id = $this->object_id;
			$list = &$this->groups;
		}

		// process all auth values
		$db->sql_stack_reset();
		if ( !empty($list->data) )
		{
			// get all auths rows
			foreach ( $list->data as $list_id => $list_data )
			{
				// we don't touch root index
				if ( $list_id && $list->auth($list_id) )
				{
					$list_ids[] = $list_id;
					$group_id = !$this->direction ? $this->group_id : $list_id;
					$object_id = !$this->direction ? $list_id : $this->object_id;

					if ( !empty($this->objects->auths_def) )
					{
						foreach ( $this->objects->auths_def as $auth_name => $auth_def )
						{
							if ( !$auth_def['auth_title'] && !empty($this->objects->auth_values[$list_id][$auth_name]) )
							{
								// build the update
								$fields = array(
									'group_id' => $group_id,
									'obj_id' => $object_id,
									'obj_type' => $this->auth_type,
									'auth_name' => $auth_name,
									'auth_value' => intval($this->objects->auth_values[$list_id][$auth_name]),
								);
								$db->sql_stack_statement($fields);
							}
						}
					}
				}
			}
		}

		// delete touched auths
		if ( !empty($list_ids) )
		{
			$sql = 'DELETE FROM ' . AUTHS_TABLE . '
						WHERE ' . $header_field . ' = ' . intval($header_id) . '
							AND ' . $list_field . ' IN(' . implode(', ', $list_ids) . ')
							AND obj_type = \'' . $this->auth_type . '\'';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// recreate auths
		$db->sql_stack_insert(AUTHS_TABLE, false, __LINE__, __FILE__);

		// delete cache to renew them
		$this->groups->clear_cache($this->auth_type);

		// update mods status
		$moderators = new moderators();
		$moderators->set_users_status();
		$moderators->read(true);

		// send achievement message
		$return_message = 'Auth_updated';
		$l_link = $this->return_message;
		$u_link = $config->url($this->requester, $this->parms, true, '', true);
		message_return($return_message, $l_link, $u_link);
	}

	function display()
	{
		global $template, $config, $user;
		global $warning, $warning_msg;

		// send warning
		if ( _button('dsp_overview') && $warning )
		{
			$template->assign_block_vars('warning', array(
				'WARNING_TITLE' => $user->lang('Information'),
				'WARNING_MSG' => $warning_msg,
			));
		}

		// display basic informations
		parent::display();

		// display list
		$this->display_list();

		// display group information
		$this->display_header();

		// send to template
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($this->title),
			'L_TITLE_EXPLAIN' => $user->lang($this->explain),
			'L_OBJECT' => $user->lang($this->object_title),
			'L_AUTHS' => $user->lang('Permissions'),
			'L_EMPTY' => $this->direction || ($this->auth_type == POST_GROUPS_URL) ? $user->lang('No_groups') : $user->lang('No_objects'),

			'L_EDIT' => $user->lang('Details'),
			'I_EDIT' => $user->img('cmd_details'),
			'L_COPY' => $user->lang('Copy'),
			'I_COPY' => $user->img('cmd_mini_copy'),
			'L_SUBMIT' => $user->lang('Submit'),
			'I_SUBMIT' => $user->img('cmd_submit'),
			'L_CANCEL' => $user->lang('Cancel'),
			'I_CANCEL' => $user->img('cmd_cancel'),
		));
		$template->set_filenames(array('body' => $this->form));
		_hide('dsp_overview', true);

		return true;
	}

	function display_header()
	{
		if ( !$this->direction )
		{
			$this->display_group_header();
		}
		else
		{
			$this->display_object_header();
		}
	}

	function display_group_header()
	{
		global $db, $config, $template, $user;
		global $special_groups;

		$max_in_list = 50;

		if ( !$this->direction )
		{
			$headers = &$this->groups;
			$header_id = $this->group_id;
		}
		else
		{
			$headers = &$this->objects;
			$header_id = $this->object_id;
		}
		$header = &$headers->data[$header_id];
		if ( ($header_id == $config->data['group_founder']) && !$this->direction )
		{
			$header['group_description'] = $user->lang($header['group_description']) . '<hr />' . $user->lang('Board_founder_explain');
		}

		// switches
		$single = $header['group_single_user'];
		$sys = ($header['group_status'] > GROUP_STANDARD);

		// get group or user membership
		$items = !isset($special_groups[$header_id]) && ($header_id != GROUP_ANONYMOUS);
		$template->set_switch('items', $items);

		// let's go with memberships
		$groups = array();
		if ( $items )
		{
			$full = _read('full', TYPE_INT, '', array(0 => '', 1 => ''));

			// search groups the user belongs to
			if ( $single )
			{
				// read group registered
				$groups[GROUP_REGISTERED] = array('group_status' => GROUP_SYSTEM, 'group_name' => 'Group_registered', 'group_description' => 'Group_registered_desc');

				// read groups the user belongs to
				$sql = 'SELECT g.group_id, g.group_status, g.group_name
							FROM ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . ' ug
							WHERE g.group_id = ug.group_id
								AND g.group_single_user = 0
								AND ug.user_pending <> 1
								AND ug.user_id = ' . intval($header['user_id']) . '
							ORDER BY group_name';
				if ( !$full && !empty($max_in_list) )
				{
					$sql .= ' LIMIT ' . ($max_in_list + 1);
				}
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$groups[ intval($row['group_id']) ] = array('group_status' => $row['group_status'], 'group_name' => $row['group_name']);
				}
				$db->sql_freeresult($result);
			}

			// search members of the group
			else
			{
				if ( $header_id == GROUP_REGISTERED )
				{
					// all active users except anonymous
					$sql = 'SELECT ig.group_id, ig.group_status, u.user_id, u.username
								FROM ' . USERS_TABLE . ' u, ' . GROUPS_TABLE . ' ig
								WHERE u.user_id <> ' . ANONYMOUS . '
									AND u.user_active = ' . true . '
									AND u.user_id = ig.group_user_id
									AND ig.group_single_user = ' . true . '
								ORDER BY username';
				}
				else
				{
					// standard groups
					$sql = 'SELECT ig.group_id, ig.group_status, u.user_id, u.username
								FROM ' . USER_GROUP_TABLE . ' ug, ' . USERS_TABLE . ' u, ' . GROUPS_TABLE . ' ig
								WHERE ug.group_id = ' . intval($header_id) . '
									AND ug.user_pending <> 1
									AND u.user_id = ug.user_id
									AND ig.group_user_id = ug.user_id
									AND ig.group_single_user = 1
								ORDER BY username';
				}
				if ( !$full && !empty($max_in_list) )
				{
					$sql .= ' LIMIT ' . ($max_in_list + 1);
				}
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$groups[ intval($row['group_id']) ] = array('group_status' => $row['group_status'], 'group_name' => $row['username']);
				}
				$db->sql_freeresult($result);
			}

			// display
			if ( !empty($groups) )
			{
				$count_groups = count($groups);

				// search if the groups have specific auths
				$this->check_group_auths($groups);

				// display
				$count = 0;
				foreach ( $groups as $group_id => $group_data )
				{
					$count++;
					if ( !$full && !empty($max_in_list) && ($count > $max_in_list) )
					{
						$template->assign_block_vars('items.row', array(
							'U_ITEM' => $config->url($this->requester, $this->parms + array('full' => true), true),
							'NAME' => '...',
						));
						break;
					}

					// link
					$parms = $this->parms;
					if ( !$this->direction )
					{
						$parms[POST_GROUPS_URL] = $group_id;
					}
					else
					{
						$parms['obj'] = $group_id;
					}
					$template->assign_block_vars('items.row', array(
						'U_ITEM' => $config->url($this->requester, $parms, true, '', true),
						'NAME' => sprintf($group_data['auth'] ? '<b>%s</b>' : '%s', ($group_data['group_status'] > GROUP_STANDARD) ? $user->lang($group_data['group_name']) : $group_data['group_name']),
						'L_SEP' => ($count == $count_groups) ? '' : ', ',
					));
					$template->set_switch('items.row.sep', ($count < $count_groups));
				}
			}
		}

		// send to template
		$template->assign_vars(array(
			'L_ITEM_TITLE' => $this->direction ? $user->lang('Group_managed') : $user->lang('Group_manager'),
			'L_ITEM_NAME' => $single ? $user->lang('Username') : $user->lang('Group_name'),
			'ITEM_NAME' => $sys ? $user->lang($header['group_name']) : ($single ? $header['username'] : $header['group_name']),
			'ITEM_DESC' => $sys ? $user->lang($header['group_description']) : ($single ? '' : $header['group_description']),
			'L_ITEM_LIST' => $single ? $user->lang('Group_memberships') : $user->lang('Usergroup_members'),
			'L_ITEM_LIST_EXPLAIN' => $single ? $user->lang('Usergroup_members_legend') : $user->lang('Group_members_legend'),
		));

		// single user group
		$template->set_switch('user', $single && !$sys);
	}

	function check_group_auths(&$groups)
	{
		global $db;

		if ( !empty($groups) )
		{
			$sql = 'SELECT DISTINCT group_id
						FROM ' . AUTHS_TABLE . '
						WHERE ' . (count($groups) > 1 ? 'group_id IN (' . implode(', ', array_keys($groups)) . ')' : 'group_id = ' . _first_key($groups)) . '
							AND obj_type = \'' . $this->auth_type . '\'
						GROUP BY group_id';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$groups[ intval($row['group_id']) ]['auth'] = true;
			}
			$db->sql_freeresult($result);
		}
	}

	function display_object_header()
	{
	}

	function display_list()
	{
		if ( !$this->direction )
		{
			$this->display_objects_list();
		}
		else
		{
			$this->display_groups_list();
		}
	}

	function display_objects_list()
	{
	}

	function display_groups_list()
	{
		global $db, $template, $config, $user;

		if ( !$this->direction )
		{
			$groups = &$this->objects;
		}
		else
		{
			$groups = &$this->groups;
		}

		// get groups
		if ( !empty($groups->data) )
		{
			foreach ( $groups->data as $group_id => $group_data )
			{
				$color = !$color;
				$group_id = intval($group_id);

				// presets list
				$options = '';
				if ( $groups->auth($group_id) )
				{
					foreach ( $this->presets->names as $preset_id => $preset_name )
					{
						$selected = ($preset_id == $this->preset_ids[$group_id]) ? ' selected="selected"' : '';
						$options .= '<option value="' . $preset_id . '"' . $selected . '>' . $user->lang($preset_name) . '</option>';
					}
				}

				// links
				$u_edit = $config->url($this->requester, $this->parms + array(($this->direction ? POST_GROUPS_URL : 'obj') => $group_id), true, '', true);
				$parms = $this->parms;
				if ( !$this->direction )
				{
					$parms['dir'] = 1;
					unset($parms[POST_GROUPS_URL]);
					$parms['obj'] = $group_id;
				}
				else
				{
					unset($parms['dir']);
					$parms[POST_GROUPS_URL] = $group_id;
					unset($parms['obj']);
				}
				$u_swap = $config->url($this->requester, $parms, true, '', true);

				// switches
				$single = $group_data['group_single_user'];
				$sys = ($group_data['group_status'] > GROUP_STANDARD);

				// send to template
				$template->assign_block_vars('row', array(
					'OBJECT_ID' => $group_id,
					'NAME' => $sys ? $user->lang($group_data['group_name']) : ($single ? $group_data['username'] : $group_data['group_name']),
					'DESC' => $sys ? $user->lang($group_data['group_description']) : ($single ? '' : $group_data['group_description']),
					'I_GROUP' => $single ? $user->img('sts_user') : $user->img('sts_group'),
					'L_GROUP' => $single ? $user->lang('Username') : $user->lang('Group_name'),

					'S_PRESETS' => $options,
					'U_SWAP' => $u_swap,
					'U_EDIT' => $u_edit,
				));
				$template->set_switch('row.light', $color);
				$template->set_switch('row.command', !empty($options));
			}
		}
		// no groups
		$template->set_switch('empty', empty($groups->data));
	}
}

//
// edit auths details
//

class edit_details extends generic_form
{
	var $title;
	var $explain;

	var $auth_type;
	var $direction;
	var $groups;
	var $objects;

	var $group_id;
	var $object_id;

	var $presets_type;
	var $presets;

	var $valid_message;

	function edit_details($title, $explain, $requester, $parms, $return_message)
	{
		global $config;
		global $auth_type, $direction, $groups, $objects, $group_id, $object_id;

		parent::generic_form($requester, $parms, $return_message);

		$this->title = $title;
		$this->explain = $explain;

		$this->auth_type = $auth_type;
		$this->direction = $direction;
		$this->groups = &$groups;
		$this->objects = &$objects;

		$this->group_id = intval($group_id);
		$this->object_id = intval($object_id);

		if ( !$this->groups->auth($this->group_id) || !$this->objects->auth($this->object_id) )
		{
			if ( !$this->direction )
			{
				if ( isset($this->parms[POST_GROUPS_URL]) )
				{
					unset($this->parms[POST_GROUPS_URL]);
				}
			}
			else
			{
				if ( isset($this->parms['obj']) )
				{
					unset($this->parms['obj']);
				}
			}
			message_return('Not_Authorised', $this->return_message, $config->url($this->requester, $this->parms, true));
		}
	}

	function process()
	{
		$this->init();
		if ( _button('dsp_details') && (_button('preset_export') || _button('preset_delete')) )
		{
			$this->check_validate_preset();
		}
		if ( _button('submit_details') )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_details') )
		{
			$this->display();
		}
	}

	function check_validate_preset()
	{
		global $template, $user;
		global $warning, $warning_msg;

		// read preset ids
		$preset_id = $this->fields['preset_id']->value;
		$new_name = $this->fields['preset_name']->value;
		if ( empty($new_name) || ($new_name == 'Custom') )
		{
			_warning('Preset_name_empty');
		}
		else if ( _button('preset_export') )
		{
			$trs_new_name = $user->lang($new_name);

			// check if the name already exists when creation asked
			foreach ( $this->presets->names as $cur_preset_id => $preset_name )
			{
				$trs_preset_name = $user->lang($preset_name);
				if ( ($preset_name == $new_name) || ($preset_name == $trs_new_name) || ($trs_preset_name == $trs_new_name) || ($trs_preset_name == $new_name) )
				{
					if ( !empty($preset_id) && ($preset_id != $cur_preset_id) )
					{
						_warning('Preset_name_exists');
					}
					else
					{
						$preset_id = $cur_preset_id;
					}
					break;
				}
			}
			if ( !$warning )
			{
				// perform updates
				if ( empty($preset_id) )
				{
					$this->presets->update('create', 0, $new_name, $this->objects->auth_values[$this->object_id]);
					_warning('Preset_created');
				}
				else
				{
					$this->presets->update('update', $preset_id, $new_name, $this->objects->auth_values[$this->object_id]);
					_warning('Preset_updated');
				}

				// re-init the form read presets
				$this->init();
			}
		}
		else if ( _button('preset_delete') )
		{
			if ( empty($preset_id) || !isset($this->presets->names[$preset_id]) )
			{
				_warning('Presets_not_found');
			}
			else
			{
				$this->presets->update('delete', $preset_id);
				_warning('Preset_deleted');

				// re-init the form
				$this->init();
			}
		}
	}

	function init()
	{
		global $user;

		// get auths def & values
		$this->objects->get_auths_def();
		$this->objects->get_auth_values($this->group_id, $this->object_id, 'obj_id');

		// read presets
		$this->presets = new presets($this->presets_type);
		$this->presets->read();

		// first pass : keep auths coming from db
		$force_auths = false;
		$force_name = true;

		// form already displayed
		if ( _button('dsp_details') )
		{
			// read preset_id
			$preset_id = _read('preset_id', TYPE_INT, '', $this->presets->names);
			$sav_preset_id = _read('sav_preset_id', TYPE_INT, '', $this->presets->names);

			// we change the preset selected: get auths from preset
			if ( !empty($preset_id) && ($sav_preset_id != $preset_id) )
			{
				$this->read_auths_from_preset($preset_id);
				$preset_id = $this->presets->search($this->objects->auth_values[$this->object_id]);
				$force_auths = true;
				$force_name = true;
			}
			// auths comes from the displayed ones
			else
			{
				$asked_preset_id = $preset_id;

				// auth values are readed from form within the init_form() function
				$this->read_auths_from_form();
				$preset_id = $this->presets->search($this->objects->auth_values[$this->object_id]);
				$force_auths = true;
				$force_name = !empty($preset_id) && ($asked_preset_id != $preset_id);
			}
		}
		// first init
		else
		{
			$this->read_auths_from_db($preset_id);
			$preset_id = $this->presets->search($this->objects->auth_values[$this->object_id]);
			$force_auths = true;
			$force_name = true;
		}

		// group manager/object managed
		$fields_manager = $this->get_groups_fields($this->groups->data[$this->group_id], $this->group_id);
		$fields_managed = $this->get_objects_fields();
		$fields_auths = $this->get_auths_fields();

		// add preset name and commands
		$fields_presets = array(
			'preset_name' => array('type' => 'varchar', 'legend' => 'Preset_name', 'explain' => 'Preset_name_explain', 'value' => empty($this->preset_id) ? '' : $this->presets->names[$this->preset_id]),
			'preset_export' => array('type' => 'button', 'legend' => 'Export_preset', 'image' => 'cmd_export', 'combined' => true, 'linefeed' => true),
			'preset_delete' => array('type' => 'button', 'legend' => 'Delete_preset', 'image' => 'cmd_delete', 'combined' => true),
		);

		// build form
		$fields = ($this->direction ? $fields_managed + $fields_manager : $fields_manager + $fields_managed) + $fields_auths + $fields_presets;
		$this->init_form($fields);

		// auth values comes from the db or the preset : adjust preset name
		if ( $force_auths )
		{
			$this->fields['preset_id']->value = $preset_id;
			if ( $force_name )
			{
				$this->fields['preset_name']->value = empty($preset_id) ? '' : $this->presets->names[$preset_id];
			}
			if ( !empty($this->objects->auths_def) )
			{
				foreach ( $this->objects->auths_def as $auth_name => $auth_def )
				{
					if ( !$auth_def['auth_title'] && isset($this->fields['auth_' . $auth_name]) && !$this->fields['auth_' . $auth_name]->data['output'] )
					{
						$this->fields['auth_' . $auth_name]->value = intval($this->objects->auth_values[$this->object_id][$auth_name]);
					}
				}
			}
		}
	}

	function read_auths_from_db($preset_id)
	{
	}

	function read_auths_from_preset($preset_id)
	{
		$this->objects->auth_values = array($this->object_id => array());
		if ( !empty($this->objects->auths_def) )
		{
			foreach ( $this->objects->auths_def as $auth_name => $auth_def )
			{
				if ( !$auth_def['auth_title'] && intval($this->presets->data[$preset_id][$auth_name]) )
				{
					$this->objects->auth_values[$this->object_id][$auth_name] = intval($this->presets->data[$preset_id][$auth_name]);
				}
			}
		}
	}

	function read_auths_from_form()
	{
		$auth_values_list = $this->get_auth_values_list();

		$this->objects->auth_values = array($this->object_id => array());
		if ( !empty($this->objects->auths_def) )
		{
			foreach ( $this->objects->auths_def as $auth_name => $auth_def )
			{
				$auth_values_list_filtered = $auth_name == 'auth_mod_display' ? array(0 => $auth_values_list[0], 1 => $auth_values_list[1]) : $auth_values_list;
				$auth_value = $auth_def['auth_title'] ? 0 : _read('auth_' . $auth_name, TYPE_INT, '', $auth_values_list_filtered);
				if ( $auth_value )
				{
					$this->objects->auth_values[$this->object_id][$auth_name] = $auth_value;
				}
			}
		}
	}

	function get_groups_fields($group_data, $group_id, $obj=false)
	{
		global $config, $user;

		$sufx = $obj ? '_mngd' : '';

		// status
		$single = $group_data['group_single_user'];
		$sys = ($group_data['group_status'] > GROUP_STANDARD);

		// name
		$group_name = $sys ? $user->lang($group_data['group_name']) : ($single ? $group_data['username'] : $group_data['group_name']);
		$fields = array(
			'group_title' . $sufx => array('type' => 'sub_title', 'legend' => $obj ? 'Group_managed' : 'Group_manager'),
			'group_name' . $sufx => array('type' => 'varchar', 'output' => true, 'legend' => $single ? 'Username' : 'Group_name', 'value' => $group_name),
		);

		// desc
		if ( $sys || !$single )
		{
			$group_desc = $sys ? $user->lang($group_data['group_description']) : $group_data['group_description'];
			if ( ($group_id == $config->data['group_founder']) && !$obj )
			{
				$group_desc = $group_desc . '<hr />' . $user->lang('Board_founder_explain');
			}
			$fields += array(
				'group_desc' . $sufx => array('type' => 'varchar', 'output' => true, 'legend' => 'Group_description', 'value' => $group_desc),
			);
		}
		return $fields;
	}

	function get_auths_fields()
	{
		global $user;

		// auths
		$fields = array(
			'auths_title' => array('type' => 'title', 'legend' => 'Permissions'),
			'preset_id' => array('type' => 'list', 'legend' => 'Auths_presets', 'options' => $this->presets->names, 'value' => $this->presets->search($this->objects->auth_values[$this->object_id]), 'html' => ' onchange="this.form.submit();"'),
		);

		$auth_values_list = $this->get_auth_values_list();
		if ( !empty($this->objects->auths_def) )
		{
			foreach ( $this->objects->auths_def as $auth_name => $auth_def )
			{
				if ( $auth_def['auth_title'] )
				{
					$fields += array(
						'title_' . $auth_name => array('type' => 'comment', 'legend' => $auth_name, 'explain' => ($auth_name == $auth_def['auth_desc']) ? '' : $auth_def['auth_desc']),
					);
				}
				else
				{
					$auth_values_list_filtered = $auth_name == 'auth_mod_display' ? array(0 => $auth_values_list[0], 1 => $auth_values_list[1]) : $auth_values_list;
					$fields += array(
						'auth_' . $auth_name => array('type' => 'list', 'legend' => $auth_name, 'explain' => ($auth_name == $auth_def['auth_desc']) ? '' : $auth_def['auth_desc'], 'options' => $auth_values_list_filtered, 'value' => $this->objects->auth_values[$this->object_id][$auth_name]),
					);
				}
			}
		}
		return $fields;
	}

	function get_auth_values_list()
	{
		return array(
			0 => 'Auth_not_authorised',
			1 => 'Auth_authorised',
			DENY => 'Auth_denied',
			FORCE => 'Auth_forced',
		);
	}

	function check()
	{
		global $config;
		global $error, $error_msg;

		// verify the form
		parent::check();

		// send error msg
		if ( $error )
		{
			$l_link = $this->return_message;
			$u_link = $config->url($this->requester, $this->parms, true, '', true);
			message_return($error_msg, $l_link, $u_link);
		}
	}

	function validate()
	{
		global $db, $config;
		global $warning, $warning_msg;

		// no validation possible if a warning has been sent
		if ( $warning )
		{
			return;
		}

		// prepare new auths
		$db->sql_stack_reset();
		if ( !empty($this->objects->auths_def) )
		{
			foreach ( $this->objects->auths_def as $auth_name => $auth_def )
			{
				if ( !$auth_def['auth_title'] && !empty($this->objects->auth_values[$this->object_id][$auth_name]) )
				{
					$fields = array(
						'group_id' => $this->group_id,
						'obj_type' => $this->auth_type,
						'obj_id' => $this->object_id,
						'auth_name' => $auth_name,
						'auth_value' => intval($this->objects->auth_values[$this->object_id][$auth_name]),
					);
					$db->sql_stack_statement($fields);
				}
			}
		}

		// delete old auths
		$sql = 'DELETE FROM ' . AUTHS_TABLE . '
					WHERE group_id = ' . intval($this->group_id) . '
						AND obj_type = \'' . $this->auth_type . '\'
						AND obj_id = ' . intval($this->object_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// insert new
		$db->sql_stack_insert(AUTHS_TABLE, false, __LINE__, __FILE__);

		// recache time
		$this->groups->clear_cache($this->auth_type);

		// update mods status
		$moderators = new moderators();
		$moderators->set_users_status();
		$moderators->read(true);

		// send achievement message
		$parms = $this->parms;
		if ( !$this->direction )
		{
			unset($parms['obj']);
		}
		else
		{
			unset($parms[POST_GROUPS_URL]);
		}
		$l_link = $this->valid_message;
		$u_link = $config->url($this->requester, $parms, true, '', true);
		message_return('Auth_updated', $l_link, $u_link);
	}

	function display()
	{
		global $template, $user, $config;
		global $warning, $warning_msg;

		// display messages
		if ( $warning )
		{
			$template->assign_block_vars('warning', array(
				'WARNING_TITLE' => $user->lang('Information'),
				'WARNING_MSG' => $warning_msg,
			));
		}

		// buttons
		$this->set_buttons(array(
			'submit_details' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
			'cancel_details' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		));

		// display the form
		parent::display();

		// add titles
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($this->title),
			'L_TITLE_EXPLAIN' => $user->lang($this->explain),
			'L_FORM' => $user->lang($this->title),
		));

		_hide('dsp_details', true);
		_hide('sav_preset_id', intval($this->fields['preset_id']->value), true);
		$template->set_filenames(array('body' => 'form_body.tpl'));
	}
}

//--------------------------------------------------------
//
//	Panels classes
//
//--------------------------------------------------------

class admin_panels extends cp_panels
{
	var $auths_def;
	var $auth_values;

	function get_front_pic()
	{
		// retain only viewable panels (last ids per branch & level)
		$last_ids = array();
		$levels = array();
		$count_keys = count($this->keys);
		for ( $i = 0; $i < $count_keys; $i++ )
		{
			$cur_id = intval($this->keys[$i]);
			$last_ids[$cur_id] = $cur_id;
			$levels[$cur_id] = 0;
			if ( $i > 0 )
			{
				$last_ids[ intval($this->data[$cur_id]['panel_main']) ] = $cur_id;
				$levels[$cur_id] = $levels[ intval($this->data[$cur_id]['panel_main']) ] + 1;
			}
		}

		// prepare return
		$front_pic = array();

		$close = array();
		$previous_level = 0;
		if ( !empty($last_ids) )
		{
			foreach ( $last_ids as $panel_id => $last_child_id )
			{
				$close[ $levels[$panel_id] ] = !$panel_id || ($last_ids[ intval($this->data[$panel_id]['panel_main']) ] == $panel_id);

				$linefeed = '';
				$option = '';
				for ( $i = 1; $i <= $levels[$panel_id]; $i++ )
				{
					if ( $i == $levels[$panel_id] )
					{
						$linefeed .= TREE_VSPACE;
						$option .= $close[$i] ? TREE_CLOSE : TREE_CROSS;
					}
					else
					{
						$linefeed .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
						$option .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
					}
				}
				if ( $previous_level > $levels[$panel_id] )
				{
					$front_pic[ (LOWER_ID - count($front_pic)) ] = $linefeed;
				}
				$front_pic[$panel_id] = $option;
				$previous_level = $levels[$panel_id];
			}
		}
		return $front_pic;
	}

	function get_auths_def()
	{
		global $db;

		// read auths def
		$sql = 'SELECT *
					FROM ' . AUTHS_DEF_TABLE . '
					WHERE auth_type = \'' . POST_PANELS_URL . '\'
					ORDER BY auth_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->auths_def = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->auths_def[ $row['auth_name'] ] = $row;
		}
		$db->sql_freeresult($result);
	}

	function get_auth_values($group_id=0, $object_id=0, $key_field='')
	{
		global $db;

		$group_id = intval($group_id);
		$object_id = intval($object_id);

		// get the way to read
		if ( empty($key_field) )
		{
			$key_field = 'obj_id';
		}
		$sql_where = '';
		if ( $group_id )
		{
			$sql_where .= (empty($sql_where) ? '' : ' AND ') . 'group_id = ' . intval($group_id);
		}
		if ( $object_id )
		{
			$sql_where .= (empty($sql_where) ? '' : ' AND ') . 'obj_id = ' . intval($object_id);
		}

		// build request
		$sql = 'SELECT ' . $key_field . ', auth_name, auth_value
					FROM ' . AUTHS_TABLE . '
					WHERE obj_type = \'' . POST_PANELS_URL . '\'
						' . (empty($sql_where) ? '' : ' AND ' . $sql_where) . '
						AND auth_value > 0
					ORDER BY ' . $key_field . ', auth_name';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->auth_values = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( isset($this->auths_def[ $row['auth_name'] ]) && !$this->auths_def[ $row['auth_name'] ]['auth_title'] )
			{
				if ( !isset($this->auth_values[ $row[$key_field] ]) )
				{
					$this->auth_values[ $row[$key_field] ] = array();
				}
				$this->auth_values[ $row[$key_field] ][ $row['auth_name'] ] = intval($row['auth_value']);
			}
		}
		$db->sql_freeresult($result);
	}

	function auth($panel_id)
	{
		global $user;

		if ( empty($this->data) )
		{
			$this->read();
		}
		$panel_id = intval($panel_id);

		return $panel_id && isset($this->data[$panel_id]) && $user->auth(POST_PANELS_URL, 'auth_manage', $panel_id);
	}
}

class select_panels extends select_tree
{
	function select_panels($title, $explain, $requester, $parms, $return_message)
	{
		global $panels;

		// define the objects
		if ( $panels === false )
		{
			$panels = new admin_panels($this->requester);
			$panels->read();
		}
		$this->objects = &$panels;
		$this->object_name = 'panel_name';
		$this->list_legend = 'Select_panels';

		// set form parms
		$this->form_title = 'Select_panels';

		// init the tree selection
		parent::select_tree($title, $explain, $requester, $parms, $return_message);
	}
}

class overview_panels extends overview
{
	var $object_id;

	function overview_panels($title, $explain, $requester, $parms, $return_message)
	{
		// init the tree selection
		parent::overview($title, $explain, $requester, $parms, $return_message);

		// preset def
		$this->presets_type = POST_PANELS_URL;
		$this->object_name = 'panel_name';
		$this->object_desc = 'panel_shortcut';
		$this->object_title = 'Panels_managed';

		// set form parms
		$this->buttons = array(
			'submit_overview' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
			'add_group' => array('txt' => 'Add_group', 'img' => 'cmd_add', 'key' => 'cmd_add_group'),
			'cancel_overview' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
		if ( !$this->direction )
		{
			unset($this->buttons['add_group']);
		}
	}

	function get_objects()
	{
		global $panels;

		// define the objects
		if ( $panels === false )
		{
			$panels = new admin_panels($this->requester);
			$panels->read();
		}
		$this->objects = &$panels;
	}

	function display_objects_list()
	{
		global $template, $config, $user;

		// get tree
		$front_pic = $this->objects->get_front_pic();
		$color = false;
		foreach ( $front_pic as $object_id => $front )
		{
			$object_id = intval($object_id);
			$command = $object_id && ($object_id > LOWER_ID) && ($this->objects->data[$object_id]['panel_auth_type'] == POST_PANELS_URL) && !empty($this->objects->data[$object_id]['panel_auth_name']);
			$color = !$color;
			if ( $object_id > LOWER_ID )
			{
				// presets list
				$options = '';
				if ( $command )
				{
					$options = '';
					foreach ( $this->presets->names as $preset_id => $preset_name )
					{
						$selected = ($preset_id == $this->preset_ids[$object_id]) ? ' selected="selected"' : '';
						$options .= '<option value="' . $preset_id . '"' . $selected . '>' . $user->lang($preset_name) . '</option>';
					}
				}

				// links
				$parms = $this->parms + array('obj' => $object_id);
				$u_edit = $config->url($this->requester, $parms, true, '', true);
				unset($parms[POST_GROUPS_URL]);
				$parms['dir'] = true;
				$u_swap = $config->url($this->requester, $parms, true, '', true);

				// send to template
				$template->assign_block_vars('row', array(
					'OBJECT_ID' => $object_id,
					'LAST_CHILD_ID' => $this->objects->data[$object_id]['last_child_id'],
					'NAME' => $user->lang($this->objects->data[$object_id][$this->object_name]),
					'DESC' => $this->objects->data[$object_id][$this->object_desc],

					'S_PRESETS' => $options,
					'U_SWAP' => $u_swap,
					'U_EDIT' => $u_edit,
				));
			}
			else
			{
				$template->set_switch('row');
			}
			$template->set_switch('row.light', $color);
			$template->set_switch('row.command', $command);

			// increment pic
			$count_front = strlen($front);
			for ( $i = 0; $i < $count_front; $i++ )
			{
				$template->assign_block_vars('row.inc', array(
					'L_INC' => $user->lang('tree_pic_' . $front[$i]),
					'I_INC' => $user->img('tree_pic_' . $front[$i]),
				));
			}
		}
	}

	function display_object_header()
	{
		global $template, $user;

		// nav sentence
		$nav = '';
		$cur_id = $this->object_id;
		while ( $cur_id )
		{
			$nav = $user->lang($this->objects->data[$cur_id]['panel_name']) . (empty($nav) ? '' : '&nbsp;' . NAV_SEPARATOR . '&nbsp;') . $nav;
			$cur_id = intval($this->objects->data[$cur_id]['panel_main']);
		}

		// send to template
		$template->assign_vars(array(
			'L_ITEM_TITLE' => $user->lang('Panel_auth_type'),
			'L_ITEM_NAME' => $user->lang('Panel_name'),
			'ITEM_NAME' => $nav,
			'ITEM_DESC' => $this->objects->data[$this->object_id]['panel_shortcut'],
		));
		$template->set_switch('user', false);
	}
}

class details_panels extends edit_details
{
	function details_panels($title, $explain, $requester, $parms, $return_message)
	{
		parent::edit_details($title, $explain, $requester, $parms, $return_message);
		$this->valid_message = 'Click_return_overviewpanels';
		$this->presets_type = POST_PANELS_URL;
	}

	function get_objects()
	{
		global $panels;

		// define the objects
		if ( $panels === false )
		{
			$panels = new admin_panels($this->requester);
			$panels->read();
		}
		$this->objects = &$panels;
	}

	function get_objects_fields()
	{
		global $user;

		// nav sentence
		$nav = '';
		$cur_id = $this->object_id;
		while ( $cur_id )
		{
			$nav = $user->lang($this->objects->data[$cur_id]['panel_name']) . (empty($nav) ? '' : '&nbsp;' . NAV_SEPARATOR . '&nbsp;') . $nav;
			$cur_id = intval($this->objects->data[$cur_id]['panel_main']);
		}

		// object managed
		$fields = array(
			'managed_title' => array('type' => 'sub_title', 'legend' => sprintf($user->lang('Object_managed'), $user->lang('Panel_auth_type'))),
			'panel_name' => array('type' => 'varchar', 'output' => true, 'legend' => 'Panel_name', 'value' => $nav),
			'panel_shortcut' => array('type' => 'varchar', 'output' => true, 'legend' => 'Panel_shortcut', 'value' => $this->objects->data[$this->object_id]['panel_shortcut']),
		);
		return $fields;
	}
}

//--------------------------------------------------------
//
//	groups classes
//
//--------------------------------------------------------

class select_groups extends select_usergroups
{
	function select_groups($title, $explain, $requester, $parms, $return_message, $with_cancel=false, $with_special_groups=false)
	{
		global $auth_type, $direction;

		$with_individual_groups = true;
		parent::select_usergroups($title, $explain, $requester, $parms, $return_message, $with_individual_groups, $with_special_groups, $with_cancel);
	}

	function display()
	{
		if ( $this->with_cancel )
		{
			_hide('add_group', true);
		}
		return parent::display();
	}
}

class overview_groups extends overview
{
	function overview_groups($title, $explain, $requester, $parms, $return_message)
	{
		// init the tree selection
		parent::overview($title, $explain, $requester, $parms, $return_message);

		$this->presets_type = POST_GROUPS_URL;
		$this->object_name = 'group_name';
		$this->object_desc = 'group_description';
		$this->object_title = $this->direction ? 'Group_manager' : 'Group_managed';

		// set form parms
		$this->buttons = array(
			'submit_overview' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
			'add_group' => array('txt' => 'Add_group', 'img' => 'cmd_add', 'key' => 'cmd_add_group'),
			'cancel_overview' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
	}

	function get_objects()
	{
		// accept special groups
		$this->objects = new admin_groups(true);
	}

	function get_auths_def()
	{
		global $db;

		// read auths def
		$sql = 'SELECT *
					FROM ' . AUTHS_DEF_TABLE . '
					WHERE auth_type = \'' . POST_GROUPS_URL . '\'
					ORDER BY auth_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->auths_def = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->auths_def[ $row['auth_name'] ] = $row;
		}
		$db->sql_freeresult($result);
	}

	function display_list()
	{
		if ( !$this->direction )
		{
			$this->display_groups_list($this->objects);
		}
		else
		{
			$this->display_groups_list($this->groups);
		}
	}

	function display_header()
	{
		$this->display_group_header();
	}
}

class details_groups extends edit_details
{
	function details_groups($title, $explain, $requester, $parms, $return_message)
	{
		parent::edit_details($title, $explain, $requester, $parms, $return_message);
		$this->valid_message = 'Click_return_overviewgroups';
		$this->presets_type = POST_GROUPS_URL;
	}

	function get_objects()
	{
		// accept special groups
		$this->objects = new admin_groups(true);
	}

	function get_objects_fields()
	{
		return $this->get_groups_fields($this->objects->data[$this->object_id], $this->object_id, true);
	}
}

//--------------------------------------------------------
//
//	forums classes
//
//--------------------------------------------------------

class admin_forums extends forums
{
	var $auths_def;
	var $auth_values;

	function get_auths_def()
	{
		global $db;

		// read auths def
		$sql = 'SELECT *
					FROM ' . AUTHS_DEF_TABLE . '
					WHERE auth_type = \'' . POST_FORUM_URL . '\'
					ORDER BY auth_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->auths_def = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->auths_def[ $row['auth_name'] ] = $row;
		}
		$db->sql_freeresult($result);
	}

	function get_auth_values($group_id=0, $object_id=0, $key_field='')
	{
		global $db;

		$group_id = intval($group_id);
		$object_id = intval($object_id);

		// get the way to read
		if ( empty($key_field) )
		{
			$key_field = 'obj_id';
		}
		$sql_where = '';
		if ( $group_id )
		{
			$sql_where .= (empty($sql_where) ? '' : ' AND ') . 'group_id = ' . intval($group_id);
		}
		if ( $object_id )
		{
			$sql_where .= (empty($sql_where) ? '' : ' AND ') . 'obj_id = ' . intval($object_id);
		}

		// build request
		$sql = 'SELECT ' . $key_field . ', auth_name, auth_value
					FROM ' . AUTHS_TABLE . '
					WHERE obj_type = \'' . POST_FORUM_URL . '\'
						' . (empty($sql_where) ? '' : ' AND ' . $sql_where) . '
						AND auth_value > 0
					ORDER BY ' . $key_field . ', auth_name';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->auth_values = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( isset($this->auths_def[ $row['auth_name'] ]) && !$this->auths_def[ $row['auth_name'] ]['auth_title'] )
			{
				if ( !isset($this->auth_values[ $row[$key_field] ]) )
				{
					$this->auth_values[ $row[$key_field] ] = array();
				}
				$this->auth_values[ $row[$key_field] ][ $row['auth_name'] ] = intval($row['auth_value']);
			}
		}
		$db->sql_freeresult($result);
	}

	function auth($forum_id)
	{
		global $user;

		if ( empty($this->data) )
		{
			$this->read();
		}
		$forum_id = intval($forum_id);

		return $user->auth(POST_FORUM_URL, 'auth_manage', $forum_id) && !empty($forum_id) && isset($this->data[$forum_id]);
	}
}

class select_forums extends select_tree
{
	function select_forums($title, $explain, $requester, $parms, $return_message)
	{
		global $forums;

		// define the objects
		if ( $forums === false )
		{
			$forums = new admin_forums();
			$forums->read();
		}
		$this->objects = &$forums;
		$this->object_name = 'forum_name';
		$this->list_legend = 'Select_forum';
		$this->list_explain = '';

		// set form parms
		$this->form_title = 'Select_forum';

		// init the tree selection
		parent::select_tree($title, $explain, $requester, $parms, $return_message);
	}
}

class overview_forums extends overview
{
	function overview_forums($title, $explain, $requester, $parms, $return_message)
	{
		global $auth_type;

		// init the tree selection
		parent::overview($title, $explain, $requester, $parms, $return_message);

		$this->presets_type = POST_FORUM_URL;

		// field names & form
		$this->object_title = !$this->direction ? 'Forums_managed' : 'Group_manager';
		$this->object_name = 'forum_name';
		$this->object_desc = 'forum_desc';

		// set form parms
		$this->buttons = array(
			'submit_overview' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
			'add_group' => array('txt' => 'Add_group', 'img' => 'cmd_add', 'key' => 'cmd_add_group'),
			'cancel_overview' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
		if ( !$this->direction )
		{
			unset($this->buttons['add_group']);
		}
	}

	function get_objects()
	{
		global $forums;

		// define the objects
		if ( $forums === false )
		{
			$forums = new admin_forums();
			$forums->read();
		}
		$this->objects = &$forums;
	}

	function display_objects_list()
	{
		global $template, $config, $user;

		// get tree
		$front_pic = $this->objects->get_front_pic();
		$color = false;
		foreach ( $front_pic as $object_id => $front )
		{
			$object_id = intval($object_id);
			$color = !$color;
			$options = '';
			if ( $object_id > LOWER_ID )
			{
				// presets list
				if ( $object_id && $this->objects->auth($object_id) )
				{
					foreach ( $this->presets->names as $preset_id => $preset_name )
					{
						$selected = ($preset_id == $this->preset_ids[$object_id]) ? ' selected="selected"' : '';
						$options .= '<option value="' . $preset_id . '"' . $selected . '>' . $user->lang($preset_name) . '</option>';
					}
				}

				// get folder image (to distinguish cat/forums & links
				$folder_img = $this->objects->get_folder_img($object_id, true);

				// links
				$parms = $this->parms + array('obj' => $object_id);
				$u_edit = $config->url($this->requester, $parms, true, '', true);
				unset($parms[POST_GROUPS_URL]);
				$parms['dir'] = true;
				$u_swap = $config->url($this->requester, $parms, true, '', true);

				// send to template
				$template->assign_block_vars('row', array(
					'OBJECT_ID' => $object_id,
					'LAST_CHILD_ID' => $this->objects->data[$object_id]['last_child_id'],
					'NAME' => $user->lang($this->objects->data[$object_id][$this->object_name]),
					'DESC' => _clean_html($user->lang($this->objects->data[$object_id][$this->object_desc])),

					'S_PRESETS' => $options,
					'U_SWAP' => $u_swap,
					'U_EDIT' => $u_edit,

					'L_FOLDER' => $user->lang($folder_img['txt']),
					'I_FOLDER' => $user->img($folder_img['img']),
					'I_NAV_ICON' => $user->img($this->objects->data[$object_id]['forum_nav_icon']),
				));
				$template->set_switch('row.nav_icon', ($object_id >= 0) && !empty($this->objects->data[$object_id]['forum_nav_icon']));
			}
			else
			{
				$template->set_switch('row');
			}
			$template->set_switch('row.light', $color);
			$template->set_switch('row.command', ($object_id > 0) && !empty($options));
			$template->set_switch('row.folder_icon', ($object_id > 0));

			// increment pic
			$count_front = strlen($front);
			for ( $i = 0; $i < $count_front; $i++ )
			{
				$template->assign_block_vars('row.inc', array(
					'L_INC' => $user->lang('tree_pic_' . $front[$i]),
					'I_INC' => $user->img('tree_pic_' . $front[$i]),
				));
			}
		}
	}

	function display_object_header()
	{
		global $user, $template;

		// nav sentence
		$nav = '';
		$cur_id = $this->object_id;
		while ( $cur_id )
		{
			$nav = $user->lang($this->objects->data[$cur_id]['forum_name']) . (empty($nav) ? '' : '&nbsp;' . NAV_SEPARATOR . '&nbsp;') . $nav;
			$cur_id = intval($this->objects->data[$cur_id]['forum_main']);
		}

		// send to template
		$template->assign_vars(array(
			'L_ITEM_TITLE' => $user->lang('Forum_auth_type'),
			'L_ITEM_NAME' => $user->lang('Forum_name'),
			'ITEM_NAME' => $nav,
			'ITEM_DESC' => $user->lang($this->objects->data[$this->object_id]['forum_desc']),
		));
		$template->set_switch('user', false);
	}
}

class details_forums extends edit_details
{
	function details_forums($title, $explain, $requester, $parms, $return_message)
	{
		parent::edit_details($title, $explain, $requester, $parms, $return_message);
		$this->valid_message = 'Click_return_overviewforums';
		$this->presets_type = POST_FORUM_URL;
	}

	function get_objects()
	{
		global $forums;

		// define the objects
		if ( $forums === false )
		{
			$forums = new admin_forums();
			$forums->read();
		}
		$this->objects = &$forums;
	}

	function get_objects_fields()
	{
		global $user;

		// nav sentence
		$nav = '';
		$cur_id = $this->object_id;
		while ( $cur_id )
		{
			$nav = $user->lang($this->objects->data[$cur_id]['forum_name']) . (empty($nav) ? '' : '&nbsp;' . NAV_SEPARATOR . '&nbsp;') . $nav;
			$cur_id = intval($this->objects->data[$cur_id]['forum_main']);
		}

		// object managed
		$fields = array(
			'managed_title' => array('type' => 'sub_title', 'legend' => sprintf($user->lang('Object_managed'), $user->lang('Forum_auth_type'))),
			'forum_name' => array('type' => 'varchar', 'output' => true, 'legend' => 'Forum_name', 'value' => $nav),
			'forum_desc' => array('type' => 'varchar', 'output' => true, 'legend' => 'Forum_desc', 'value' => $user->lang($this->objects->data[$this->object_id]['forum_desc'])),
		);
		return $fields;
	}
}

//--------------------------------------------------------
//
//	main process
//
//--------------------------------------------------------
// get plug ins
$plug_ins = new plug_ins();
$plug_ins->load('admin_auths');
unset($plug_ins);

// plugs
if ( $config->plug_ins['admin_auths'] )
{
	foreach ( $config->plug_ins['admin_auths'] as $plug => $dummy )
	{
		if ( method_exists($config->plug_ins['admin_auths'][$plug], 'start') )
		{
			$config->plug_ins['admin_auths'][$plug]->start($auth_types, $auth_objects);
		}
	}
}

$user->get_cache(array_keys($auth_types));
$parms = array();

// public objects
$auth_type_parms = '';
$forums = false;
$panels = false;

// main objects
$groups = false;
$group_id = 0;
$objects = false;
$object_id = 0;

// something has been displayed ?
$handled = false;

// get/check auth_type and direction
if ( !$handled )
{
	$direction = _read('dir', TYPE_NO_HTML, '', $auth_directions);
	$auth_type = _read(POST_AUTHS_URL, TYPE_NO_HTML, '', array('' => '') + $auth_types);

	// check parms
	$auth_type_parms = new auth_type_parms('Auth_center', 'Auth_center_explain', $requester, $parms, 'Click_return_auth_center');
	$handled = $auth_type_parms->process($auth_type, $direction);
	if ( !$handled )
	{
		$auth_type = $auth_type_parms->auth_type;
		$direction = $auth_type_parms->direction;
		$parms += array(POST_AUTHS_URL => $auth_type_parms->auth_type, 'dir' => $auth_type_parms->direction);
	}
}

// check/get the header object
if ( !$handled )
{
	$group_id = _read(POST_GROUPS_URL, TYPE_INT, 0);
	$object_id = _read('obj', TYPE_INT, 0);

	$with_cancel = false;
	$with_own = $direction;
	$object_items = $direction ? $auth_objects[$auth_type] : 'groups';
	$object_name = 'select_' . $object_items;
	$object_dir = $direction ? 'target_' : 'source_';
	$select_id = $direction ? $object_id : $group_id;
	$select = new $object_name('Select_' . $object_dir . $object_items, 'Select_' . $object_dir . $object_items . '_explain', $requester, $parms, 'Click_return_select_' . $object_items, $with_cancel, $with_own);
	$handled = $select->process($select_id, _button('cancel_overview'));
	if ( !$handled )
	{
		if ( !$direction )
		{
			$group_id = $select->object_id;
			$groups = &$select->objects;
			$parms += array(POST_GROUPS_URL => $group_id);
		}
		else
		{
			$object_id = $select->object_id;
			$objects = &$select->objects;
			$parms += array('obj' => $object_id);
		}
	}
}

// get an additional group
if ( !$handled && _button('add_group') && !_button('cancel_group') )
{
	$with_cancel = true;
	$with_own = !$direction;
	$object_items = 'groups';
	$object_dir = $direction ? 'source_' : 'target_';
	$add_group = new select_groups('Select_' . $object_dir . $object_items, 'Select_' . $object_dir . $object_items . '_explain', $requester, $parms, 'Click_return_select_' . $object_items, $with_cancel, $with_own);
	$handled = $add_group->process(!$direction ? $object_id : $group_id, _button('cancel_details'));
	if ( !$handled )
	{
		if ( !$direction )
		{
			$object_id = $add_group->object_id;
			$objects = &$add_group->objects;
			$parms += array('obj' => $object_id);
		}
		else
		{
			$group_id = $add_group->object_id;
			$groups = &$add_group->objects;
			$parms += array(POST_GROUPS_URL => $group_id);
		}
	}
}

// check/get the object from the list
if ( !$handled )
{
	// we need the target objects
	$object_items = $auth_objects[$auth_type];
	$object_name = 'overview_' . $object_items;
	$object_dir = $direction ? 'rev_' : '';
	$overview = new $object_name('Overview_' . $object_dir . $object_items, 'Overview_' . $object_dir . $object_items . '_explain', $requester, $parms, 'Click_return_overview' . $object_items);
	$handled = $overview->process(!$direction ? $object_id : $group_id, _button('cancel_details'));
	if ( !$handled )
	{
		if ( !$direction )
		{
			$object_id = $overview->object_id;
			$objects = &$overview->objects;
			$parms += array('obj' => $object_id);
		}
		else
		{
			$group_id = $overview->group_id;
			$groups = &$overview->groups;
			$parms += array(POST_GROUPS_URL => $group_id);
		}
	}
}

// go with detail
if ( !$handled )
{
	$object_items = $auth_objects[$auth_type];
	$object_name = 'details_' . $object_items;

	$details = new $object_name('Edit_' . $object_items . '_auth', 'Edit_' . $object_items . '_auth_explain', $requester, $parms, 'Click_return_edit_auth_' . $object_items);
	$details->process();
	$handled = true;
}

// close display
_hide_set();
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>