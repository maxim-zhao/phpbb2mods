<?php
//
//	file: includes/class_groups_select.php
//	author: ptirhiik
//	begin: 05/09/2004
//	version: 1.6.2 - 28/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// group class
class admin_groups extends groups
{
	var $auths_def;
	var $auth_values;
	var $with_special_groups;

	function admin_groups($with_special_groups=false)
	{
		$this->data = array();
		$this->with_special_groups = $with_special_groups;
		parent::groups();
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
					WHERE obj_type = \'' . POST_GROUPS_URL . '\'
						' . (empty($sql_where) ? '' : ' AND ' . $sql_where) . '
						AND auth_value > 0
					ORDER BY ' . $key_field . ', auth_name';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->auth_values = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['auth_value'] )
			{
				if ( isset($this->auths_def[ $row['auth_name'] ]) && !$this->auths_def[ $row['auth_name'] ]['auth_title'] )
				{
					if ( !isset($this->auth_values[ intval($row[$key_field]) ]) )
					{
						$this->auth_values[ intval($row[$key_field]) ] = array();
					}
					$this->auth_values[ intval($row[$key_field]) ][ $row['auth_name'] ] = intval($row['auth_value']);
				}
			}
		}
		$db->sql_freeresult($result);
	}

	function auth($group_id)
	{
		global $user;
		global $special_groups;

		$group_id = intval($group_id);
		if ( !isset($this->data[$group_id]) )
		{
			$groups = array($group_id => '');
			$this->read($groups);
		}

		// check the group validity
		$authed = isset($this->data[$group_id]) && ($this->with_special_groups || ($this->data[$group_id]['group_status'] < GROUP_SPECIAL));

		// check if the user has a greater level than the group
		if ( $authed )
		{
			// reminder: add the auth_manage auth when dealing with the group management
			$group_list = $user->get_groups_list();
			$is_founder = in_array(GROUP_FOUNDER, $group_list);
			$is_admin = in_array(GROUP_ADMIN, $group_list);
			$authed = $is_founder || ($is_admin && !in_array($group_id, array(GROUP_FOUNDER, GROUP_ADMIN)));
		}

		// can be enhanced with a management auth
		return $authed;
	}
}

// user search
class select_user extends generic_form
{
	var $data;

	var $requester;
	var $parms;
	var $return_message;

	function select_user($requester, $parms)
	{
		$this->requester = $requester;
		$this->parms = $parms;
	}

	function process()
	{
	}
}

// groups get/check process
class select_usergroups extends generic_form
{
	var $objects;
	var $object_id;

	var $title;
	var $explain;

	var $requester;
	var $parms;
	var $return_message;

	var $with_individual_groups;
	var $with_special_groups;

	var $with_cancel;

	function select_usergroups($title, $explain, $requester, $parms, $return_message, $with_individual_groups, $with_special_groups, $with_cancel=false)
	{
		// form parms
		$this->title = $title;
		$this->explain = $explain;

		$this->requester = $requester;
		$this->parms = $parms;
		$this->return_message = $return_message;

		$this->with_individual_groups = $with_individual_groups;
		$this->with_special_groups = $with_special_groups;

		$this->with_cancel = $with_cancel;

		// objects
		$this->objects = new admin_groups($this->with_special_groups);
		$this->object_id = 0;
	}

	function process($group_id, $force_display=false)
	{
		// no group provided : search for user asked
		if ( _button('search_user') && $this->with_individual_groups )
		{
			$parms = $this->parms + array('search_user' => true);
			$select_user = new select_user($this->requester, $parms);
			if ( $select_user->process() )
			{
				return true;
			}
			else if ( !_button('cancel_user') )
			{
				$this->data = $search_user->data;
			}
		}

		// a group id has been provided
		if ( $group_id && ($group_id > LOWER_ID) && !$force_display )
		{
			$this->check($group_id);
			$this->validate();
			return false;
		}

		// no group id provided : ask for one
		$this->init();
		if ( _button('select_group') )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_group') && empty($this->objects->data) )
		{
			return $this->display();
		}
		return false;
	}

	function init()
	{
		global $db, $config, $user;
		global $special_groups;

		// groups list
		$groups_list = array();

		// get the system groups list if required
		$prev_group_status = GROUP_SYSTEM;
		$inc = 0;
		if ( $this->with_special_groups && !empty($special_groups) )
		{
			foreach ( $special_groups as $group_id => $group_data )
			{
				$groups_list[ intval($group_id) ] = $group_data['group_name'];
				$prev_group_status = GROUP_SPECIAL;
			}
		}

		// add other groups
		$sql = 'SELECT group_id, group_status, group_name
					FROM ' . GROUPS_TABLE . '
					WHERE group_single_user <> ' . true . '
					ORDER BY group_status DESC, group_name';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( ($prev_group_status != $row['group_status']) && !empty($groups_list) )
			{
				// add anonymous
				if ( $this->with_individual_groups )
				{
					$groups_list[ intval(GROUP_ANONYMOUS) ] = 'Group_anonymous';
				}
				$groups_list[ (LOWER_ID - $inc) ] = '-----------------';
				$inc++;
			}
			$prev_group_status = $row['group_status'];
			$group_id = intval($row['group_id']);
			$groups_list[ intval($group_id) ] = $row['group_name'];
		}
		$db->sql_freeresult($result);

		// no regular groups
		if ( $this->with_individual_groups && !isset($groups_list[ intval(GROUP_ANONYMOUS) ]) )
		{
			$groups_list[ intval(GROUP_ANONYMOUS) ] = 'Group_anonymous';
		}

		// build the fields def
		if ( empty($groups_list) )
		{
			$fields = array(
				'group_id' => array('type' => 'varchar', 'output' => true, 'legend' => 'Group_name', 'value' => $user->lang('None')),
			);
		}
		else
		{
			$fields = array(
				'group_id' => array('type' => 'list', 'legend' => 'Group_name', 'options' => $groups_list, 'html' => ' size="' . min(10, count($groups_list)) . '"'),
			);
		}

		// add users search fields
		if ( $this->with_individual_groups )
		{
			$fields['group_id']['html'] .= ' onchange="this.form.username.value=\'\'"';
			$fields += array(
				'username' => array('type' => 'varchar', 'legend' => 'Username', 'length' => 25),
//				'search_user' => array('type' => 'button', 'legend' => 'Find_username', 'image' => 'cmd_search', 'combined' => true),
				'search_user' => array('type' => 'button', 'output' => true, 'legend' => 'Find_username', 'image' => 'cmd_search', 'combined' => true, 'html' => ' onclick="window.open(\'' . $config->url('search', array('mode' => 'searchuser'), true) . '\', \'_phpbbsearch\', \'HEIGHT=250,resizable=yes,WIDTH=400\'); return false;" onmouseover="this.style.cursor=\'pointer\';"'),
			);
		}

		// add extra fields
		$this->extra_fields($fields);

		// create the form
		parent::form($fields);
	}

	function extra_fields(&$fields)
	{
	}

	function check($group_id=0)
	{
		global $error, $error_msg;
		global $db, $config;
		global $special_groups;

		// raz result
		$group_ids = array();
		$this->object_id = 0;

		// a group id has been provided: check it
		if ( empty($this->fields) )
		{
			$group_ids[ intval($group_id) ] = true;
		}

		// no group id provided: get one from the form
		else
		{
			parent::check();
			if ( !empty($this->fields['username']->value) && $this->with_individual_groups )
			{
				$username_search = preg_replace('/\*/', '%', trim(strip_tags($this->fields['username']->value)));
				$sql = 'SELECT g.group_id
							FROM ' . USERS_TABLE . ' u, ' . GROUPS_TABLE . ' g
							WHERE u.username LIKE \'' . $db->sql_escape_string($username_search) . '\'
								AND u.user_id <> ' . ANONYMOUS . '
								AND g.group_user_id = u.user_id';
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				if ( $row = $db->sql_fetchrow($result) )
				{
					$group_ids[ intval($row['group_id']) ] = true;
				}
				else
				{
					_error('No_such_user');
				}
				$db->sql_freeresult($result);
			}
			else if ( !isset($this->fields['group_id']) )
			{
				_error('No_such_user');
			}
			else
			{
				$group_ids[ intval($this->fields['group_id']->value) ] = true;
			}
		}
		if ( !$error )
		{
			// read group def
			$this->objects->read($group_ids);

			// check the group status
			$group_id = intval(_first_key($group_ids));
			if ( !$this->objects->auth($group_id, $this->with_special_groups) || (!$this->with_individual_groups && $this->objects->data[$group_id]['group_single_user']) )
			{
				_error('Not_Authorised');
			}
			else
			{
				$this->object_id = $group_id;
			}
		}
		if ( $error )
		{
			$l_return = $this->return_message;
			$u_return = $config->url($this->requester, $this->parms, true, '', true);
			message_return($error_msg, $l_return, $u_return, 10);
		}
	}

	function display()
	{
		global $template, $config, $user;

		// buttons
		$buttons = array(
			'select_group' => array('txt' => 'Select', 'img' => 'cmd_select', 'key' => 'cmd_select'),
			'cancel_group' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
		if ( !$this->with_cancel )
		{
			unset($buttons['cancel_group']);
		}
		$this->set_buttons($buttons);

		// display the form
		parent::display();

		// add titles
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($this->title),
			'L_TITLE_EXPLAIN' => $user->lang($this->explain),
			'L_FORM' => $user->lang('Select_groups'),
		));
		$template->set_filenames(array('body' => 'form_body.tpl'));

		return true;
	}
}

?>