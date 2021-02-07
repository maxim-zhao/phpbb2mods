<?php
//
//	file: includes/ucp/ucp_admin_edit.php
//	author: ptirhiik
//	begin: 24/01/2006
//	version: 1.6.2 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

define('SID_CHECK', true);

//
// we are doing some basic checks in case of not-coherent auths settings
// and to protect main founder, and founders profiles against a founder modifying other founders (same for admins)
//

// anonymous can't act on this panel
// anonymous register edition denied in all cases for everybody, included founder
$no_access = ($user->data['user_id'] == ANONYMOUS) || ($view_user->data['user_id'] == ANONYMOUS);

// A user can access this panel only if he modifies his own profile, or if he has authorization onto the viewed user groups
if ( !$no_access )
{
	$no_access = ($view_user->data['user_id'] != $user->data['user_id']) && !$user->auth(POST_GROUPS_URL, 'ucp_edit_admin', $view_user->get_groups_list());
}

// we are modifying another profile
if ( !$no_access && ($user->data['user_id'] != $view_user->data['user_id']) )
{
	$sql = 'SELECT group_moderator
				FROM ' . GROUPS_TABLE . '
				WHERE group_id = ' . intval(GROUP_FOUNDER);
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$main_founder = ($row = $db->sql_fetchrow($result)) ? intval($row['group_moderator']) : 0;
	$db->sql_freeresult($result);

	// only main founder has access to his profile registration data
	$no_access = $view_user->data['user_id'] == $main_founder;

	// we don't want a founder to modify another founder registration, except if the actor is the main founder
	// we don't want neither a regular user manager to modify a founder or admin profile registration data
	if ( !$no_access && ($user->data['user_id'] != $main_founder) )
	{
		$view_is_founder = in_array(GROUP_FOUNDER, $view_user->get_groups_list());
		$view_is_admin = in_array(GROUP_ADMIN, $view_user->get_groups_list());

		$no_access = $view_is_founder || (!$view_is_founder && $view_is_admin && !in_array(GROUP_FOUNDER, $user->get_groups_list()));
	}
}

// a user can't set himself inactive
if ( $view_user->data['user_id'] == $user->data['user_id'] )
{
	if ( isset($fields['user_active']) )
	{
		unset($fields['user_active']);
	}
	if ( isset($fields['user_delete']) )
	{
		unset($fields['user_delete']);
	}
}

// if no fields, send "no options" with left side menus
if ( $no_access || empty($fields) )
{
	$cp_panels->display_empty();
	return;
}

class user_admin_delete
{
	var $requester;
	var $parms;

	function user_admin_delete($requester, $parms=array())
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
	}

	function process()
	{
		if ( $this->init() )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init()
	{
		global $user, $view_user;
		if ( (_button('user_delete') || _button('confirm_delete')) && !_button('cancel') && ($view_user->data['user_id'] != $user->data['user_id']) )
		{
			return true;
		}
		return false;
	}

	function check()
	{
		global $user;
		global $error, $error_msg;

		// check sid
		if ( SID_CHECK && (!($sid = _read_form('sid', TYPE_NO_HTML)) || ($sid != $user->data['session_id'])) )
		{
			_error('Session_invalid');
		}

		if ( !_button('confirm_delete') )
		{
			return;
		}
	}

	function validate()
	{
		global $error, $error_msg;
		global $navigation;
		global $view_user;

		if ( !_button('confirm_delete') )
		{
			return;
		}
		if ( $error )
		{
			return;
		}
		$view_user->delete();
		$navigation->clear();
		message_return('User_deleted');
	}

	function display()
	{
		global $error, $error_msg;
		global $user, $config, $template;

		$template->assign_vars(array(
			'MESSAGE' => $error ? $template->implode('<br /><br />', array($template->lang('Session_invalid'), $template->lang('Confirm_user_delete'))) : $template->lang('Confirm_user_delete'),
		));

		$template->assign_vars(array('FORM' => $template->include_file('ucp/ucp_confirm_box.tpl')));
		$buttons = array(
			'confirm_delete' => array('txt' => 'User_delete', 'img' => 'cmd_delete', 'key' => 'cmd_delete'),
			'cancel' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
		display_buttons($buttons);
		_hide('sid', $user->data['session_id']);
	}
}

class user_admin_edit extends auto_form
{
	function check()
	{
		global $user;
		global $error, $error_msg;

		// check sid
		if ( SID_CHECK && (!($sid = _read_form('sid', TYPE_NO_HTML)) || ($sid != $user->data['session_id'])) )
		{
			_error('Session_invalid');
		}
		parent::check();
	}

	function validate()
	{
		global $config, $user, $db;
		global $view_user;
		global $error, $error_msg;

		if ( $error )
		{
			return;
		}

		// let's start to build the fields
		$fields = array();

		if ( !isset($this->fields['user_active']) || $this->fields['user_active']->value )
		{
			if ( !isset($this->fields['user_active']) )
			{
				$field_def = array('type' => 'int');
				$this->fields['user_active'] = new field('user_active', $field_def);
			}
			$this->fields['user_active']->data['sub_fields'] = array('actkey' => 'user_actkey');
			$this->fields['user_active']->data['sub_values'] = array('actkey' => '');
		}

		// other fields & update
		foreach ( $this->fields as $field_name => $field )
		{
			if ( empty($field->data['field']) || !isset($fields[ $field->data['field'] ]) )
			{
				$this->fields[$field_name]->validate();
				if ( !empty($field->data['field']) )
				{
					$fields[ $field->data['field'] ] = $field->value;
				}
				if ( !empty($field->data['sub_fields']) && is_array($field->data['sub_fields']) )
				{
					foreach ( $field->data['sub_fields'] as $sub_field_name => $sub_field_table_field )
					{
						if ( !isset($fields[$sub_field_table_field]) )
						{
							$fields[$sub_field_table_field] = $field->data['sub_values'][$sub_field_name];
						}
					}
				}
			}
		}
		if ( !empty($fields) )
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
						SET ' . $db->sql_fields('update', $fields) . '
						WHERE user_id = ' . intval($view_user->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// fill the memory
			$view_user->data = array_merge($view_user->data, $fields);
		}

		// return
		$return_msg = 'Profile_updated' . ($view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other');

		// send achievement message
		message_return($return_msg, $this->return_msg, $config->url($this->requester, $this->return_parms, true));
	}

	function display()
	{
		global $user;

		_hide('sid', $user->data['session_id']);
		parent::display();
	}
}

// verify deletetion
$handled = false;
$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);
if ( (_button('user_delete') || _button('confirm_delete')) && isset($fields['user_delete']) )
{
	$form = new user_admin_delete($cp_requester, 'Click_return_' . $menu_id . ($view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other'), $cp_parms + $parms);
	$handled = $form->process();
}

if ( !$handled )
{
	// instantiate the form
	$form = new user_admin_edit($view_user->data, $fields, $cp_requester, 'Click_return_' . $menu_id . ($view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other'), $cp_parms + $parms);
	$form->process();
}
$template->set_switch('form');
$template->set_filenames(array('body' => 'cp_generic.tpl'));

?>