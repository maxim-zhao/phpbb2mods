<?php
//
//	file: includes/ucp/ucp_register_edit.php
//	author: ptirhiik
//	begin: 24/01/2006
//	version: 1.6.2 - 30/12/2006
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
	$user_is_manager = $user->auth(POST_GROUPS_URL, 'ucp_edit_registration', $view_user->get_groups_list());
	$no_access = ($view_user->data['user_id'] != $user->data['user_id']) && !$user_is_manager;
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

// no access : end there
if ( $no_access )
{
	$cp_panels->display_empty();
	return;
}

// edit username allowed for managers of users, and for users modifying their own profile if allowed through the allow_namechange config value
// ok, I know, this could be a specific auth, but let's try to keep the vanilia phpBB way
// side notes :
// - managers don't need to know the pass to change a password
// - managers don't receive a re-activation email when changing their email
$auth_edit_username = ($user->data['user_id'] != $view_user->data['user_id']) || $user_is_manager || intval($config->data['allow_namechange']);

// minimal size for the password
$password_mini = intval($config->data['password_mini']) ? intval($config->data['password_mini']) : 5;

include_once($config->url('includes/ucp/ucp_fields'));
include_once($config->url('includes/emailer'));

// define fields
$register_fields = array(
	'username' => array('type' => 'username', 'legend' => 'Username', 'form_only' => true, 'field' => 'username', 'output' => !$auth_edit_username, 'span.html' => $auth_edit_username ? '' : ' style="font-weight: bold"', 'length_mini' => 3, 'sub_values' => array('user_id' => $view_user->data['user_id'])),
	'user_email' => array('type' => 'email', 'legend' => 'Email_address', 'form_only' => true, 'field' => 'user_email', 'sub_values' => array('user_id' => $view_user->data['user_id']), 'length_mini' => 1),
	'cur_password' => array('type' => 'password', 'legend' => 'Current_password', 'explain' => 'Confirm_password_explain', 'form_only' => true, 'length' => 32),
	'new_password' => array('type' => 'password', 'legend' => 'New_password', 'explain' => 'password_if_changed', 'form_only' => true, 'length' => 32, 'length_mini' => $password_mini, 'length_mini_error' => sprintf($user->lang('Password_short'), $password_mini), 'length_maxi' => 32, 'length_maxi_error' => 'Password_long', 'empty_allowed' => true),
	'cnf_password' => array('type' => 'password', 'legend' => 'Confirm_password', 'explain' => 'password_confirm_if_changed', 'form_only' => true, 'length' => 32),
);
$fields = empty($fields) ? $register_fields : $register_fields + $fields;
unset($register_fields);

// if no fields, send "no options" with left side menus
if ( empty($fields) )
{
	$cp_panels->display_empty();
	return;
}

class user_register_edit extends auto_form
{
	function user_register_edit(&$table_data, &$fields, $requester, $return_msg, $return_parms=array())
	{
		global $user;

		parent::auto_form($table_data, $fields, $requester, $return_msg, $return_parms);
		if ( $user->auth(POST_GROUPS_URL, 'ucp_edit_admin', GROUP_REGISTERED) )
		{
			$this->buttons += array(
				'create_form' => array('txt' => 'Register_new', 'img' => 'cmd_create', 'key' => 'cmd_create'),
			);
		}
	}

	function check()
	{
		global $error, $error_msg;
		global $user, $view_user;
		global $user_is_manager;

		//
		// do our global checks
		//
		if ( SID_CHECK && (!($sid = _read_form('sid', TYPE_NO_HTML)) || ($sid != $user->data['session_id'])) )
		{
			_error('Session_invalid');
		}

		// do we have to check the current pass ?
		if ( !$error )
		{
			$check_password = false;
			if ( !$this->fields['username']->data['output'] )
			{
				$check_password = ($this->fields['username']->value != $view_user->data['username']);
			}
			$check_password |= ($this->fields['user_email']->value != $view_user->data['user_email']) || !empty($this->fields['new_password']->value);

			// check the current pass against the database one
			if ( (($check_password && !$user_is_manager) || !empty($this->fields['cur_password']->value)) && (md5($this->fields['cur_password']->value) != $view_user->data['user_password']) )
			{
				_error('Current_password_mismatch');
			}
		}

		// check the new & confirm passwords
		if ( !$error )
		{
			if ( !empty($this->fields['new_password']->value) && ($this->fields['cnf_password']->value != $this->fields['new_password']->value) )
			{
				_error('Password_mismatch');
			}
		}

		// do other checks
		parent::check();
	}

	function validate()
	{
		global $config, $user, $db;
		global $view_user, $user_is_manager;
		global $error, $error_msg;

		if ( $error )
		{
			return;
		}

		// let's start to build the fields
		$fields = array();
		$change_username = false;
		$change_password = false;
		$change_email = false;
		$require_activation = false;

		// username changed
		$change_username = ($this->fields['username']->value != $view_user->data['username']) && !$this->fields['username']->data['output'];

		// password change
		$plain_password = $this->fields['new_password']->value;
		if ( $change_password = !empty($this->fields['new_password']->value) )
		{
			$fields += array(
				'user_password' => md5($this->fields['new_password']->value),
				'user_session_logged' => 0,
			);
		}

		// email change
		if ( $this->fields['user_email']->value != $view_user->data['user_email'] )
		{
			$change_email = true;

			// we don't want users administrators to make their profiles inactive
			// users administrators are users allowed to edit "registered members" group profiles
			if ( ($config->data['require_activation'] != USER_ACTIVATION_NONE) && ($user->data['user_id'] == $view_user->data['user_id']) && !$user_is_manager )
			{
				$fields += array(
					'user_active' => 0,
					'user_actkey' => substr(gen_rand_string(true), 0, max(6, 54 - strlen($config->get_script_path()))),
					'user_session_logged' => 0,
				);
				$require_activation = true;
			}
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
			if ( !$change_username && isset($fields['username']) )
			{
				unset($fields['username']);
			}
			if ( !$change_email && isset($fields['user_email']) )
			{
				unset($fields['user_email']);
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

		// adjust some data on username edition
		if ( $change_username )
		{
			// update last topic username in forums
			$sql = 'UPDATE ' . FORUMS_TABLE . '
						SET forum_last_username = \'' . $db->sql_escape_string($this->fields['username']->value) . '\'
						WHERE forum_last_poster = ' . intval($view_user->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// update stats if necessary
			if ( ($view_user->data['user_id'] != ANONYMOUS) && ($view_user->data['user_id'] == intval($config->data['stat_last_user'])) || empty($config->data['stat_last_username']) )
			{
				$config->begin_transaction();
				$config->set('stat_last_user', $view_user->data['user_id']);
				$config->set('stat_last_username', $this->fields['username']->value);
				$config->end_transaction();
			}
		}

		// pass changed or activation is required : clear sessions & sessions keys
		if ( ($require_activation || $change_password) && ($view_user->data['user_id'] != ANONYMOUS) )
		{
			$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
						WHERE session_user_id = ' . intval($view_user->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			$sql = 'DELETE FROM ' . SESSIONS_KEYS_TABLE . '
						WHERE user_id = ' . intval($view_user->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// return
		$return_msg = 'Profile_updated' . ($view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other');

		// send the email if required
		if ( $require_activation )
		{
			$this->send_activation_email();
			if ( $user->data['session_logged_in'] && ($view_user->data['user_id'] == $user->data['user_id']) )
			{
				session_end($user->data['session_id'], $user->data['user_id']);
			}
			$return_msg = 'Profile_updated_inactive';
		}

		// send achievement message
		message_return($return_msg, $this->return_msg, $config->url($this->requester, $this->return_parms, true));
	}

	function display()
	{
		global $user;

		_hide('sid', $user->data['session_id']);
		parent::display();
	}

	function send_activation_email($user_lang='')
	{
		global $config, $user, $db;
		global $view_user;

		// The users account has been deactivated, send them an email with a new activation key
		$emailer = new emailer($config->data['smtp_delivery']);

		// send to admin
		if ( $config->data['require_activation'] == USER_ACTIVATION_ADMIN )
		{
			// get group_ids having the right to administrate the registered users group
			$group_ids = array(GROUP_FOUNDER => true);
			$sql = 'SELECT group_id, MAX(auth_value) AS auth_solved
						FROM ' . AUTHS_TABLE . '
						WHERE obj_type = \'' . POST_GROUPS_URL . '\'
							AND obj_id = ' . intval(GROUP_REGISTERED) . '
							AND auth_name = \'ucp_edit_admin\'
						GROUP BY group_id
						HAVING MAX(auth_value) IN(1, ' . FORCE . ')';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				if ( $row['group_id'] != $view_user->data['group_id'] )
				{
					$group_ids[ intval($row['group_id']) ] = true;
				}
			}
			$db->sql_freeresult($result);

			// get users belonging to these groups
			$sql = 'SELECT user_email, user_lang 
						FROM ' . USERS_TABLE . '
						WHERE user_id IN(' . $db->sql_subquery('user_id', '
							SELECT DISTINCT user_id
								FROM ' . USER_GROUP_TABLE . '
								WHERE group_id IN(' . implode(', ', array_keys($group_ids)) . ')
									AND user_pending <> 1
							', __FILE__, __LINE__) . ')';
			unset($group_ids);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$emailer->from($config->data['board_email']);
				$emailer->replyto($config->data['board_email']);
				$emailer->email_address(trim($row['user_email']));
				$emailer->use_template('admin_activate', $row['user_lang']);
				$emailer->set_subject($user->lang('Reactivate'));

				$emailer->assign_vars(array(
					'SITENAME' => $config->data['sitename'],
					'USERNAME' => _un_htmlspecialchars($view_user->data['username']),
					'EMAIL_SIG' => empty($config->data['board_email_sig']) ? '' : str_replace('<br />', "\n", "-- \n" . $config->data['board_email_sig']),

					'U_ACTIVATE' => $config->get_script_path() . $this->requester . '.' . $config->ext . '?mode=activate&' . POST_USERS_URL . '=' . $view_user->data['user_id'] . '&act_key=' . $view_user->data['user_actkey'],
				));
				$emailer->send();
				$emailer->reset();
			}
			$db->sql_freeresult($result);
		}
		// send to user
		else
		{ 
			$emailer->from($config->data['board_email']);
			$emailer->replyto($config->data['board_email']);
			$emailer->use_template('user_activate', $view_user->data['user_lang']);
			$emailer->email_address($view_user->data['user_email']);
			$emailer->set_subject($user->lang('Reactivate'));

			$emailer->assign_vars(array(
				'SITENAME' => $config->data['sitename'],
				'USERNAME' => _un_htmlspecialchars($view_user->data['username']),
				'EMAIL_SIG' => empty($config->data['board_email_sig']) ? '' : str_replace('<br />', "\n", "-- \n" . $config->data['board_email_sig']),

				'U_ACTIVATE' => $config->get_script_path() . $this->requester . '.' . $config->ext . '?mode=activate&' . POST_USERS_URL . '=' . $view_user->data['user_id'] . '&act_key=' . $view_user->data['user_actkey'],
			));
			$emailer->send();
			$emailer->reset();
		}
	}
}

// instantiate the form
$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);

if ( $user->auth(POST_GROUPS_URL, 'ucp_edit_admin', GROUP_REGISTERED) && _button('create_form') )
{
	redirect($config->url($cp_requester, array('mode' => 'register', 'sid' => $user->data['session_id']), true));
}
$form = new user_register_edit($view_user->data, $fields, $cp_requester, 'Click_return_' . $menu_id . ($view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other'), $cp_parms + $parms);
$form->process();
$template->set_switch('form');
$template->set_filenames(array('body' => 'cp_generic.tpl'));

?>