<?php
//
//	file: admin/admin_bots.php
//	author: ptirhiik
//	begin: 16/12/2005
//	version: 1.6.1 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);

$file = basename(__FILE__);
if( !empty($setmodules) )
{
	$module['Users']['01_Bots_management'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_bots';
$no_page_header = true;
require('./pagestart.' . $phpEx);
include($config->url('includes/class_form'));

$modes_allowed = array(
	'' => array('title' => 'Bots_management', 'explain' => 'Bots_management_explain'),
	'edit' => array('title' => 'Bots_edit', 'explain' => 'Bots_edit_explain', 'form' => 'Bots_edit'),
	'delete' => array('title' => 'Bots_delete', 'explain' => 'Bots_delete_explain', 'form' => 'Bots_delete'),
	'create' => array('title' => 'Bots_create', 'explain' => 'Bots_create_explain', 'form' => 'Bots_create'),
);
$mode = _read('mode', TYPE_NO_HTML, '', $modes_allowed);

class bots_management
{
	var $requester;
	var $data;

	function bots_management($requester)
	{
		$this->requester = $requester;
		$this->data = array();
	}

	function read()
	{
		global $db;

		// read bots directly from users table
		$sql = 'SELECT user_id, username, user_bot_agent, user_bot_ips
					FROM ' . USERS_TABLE . '
					WHERE user_id <> ' . ANONYMOUS . '
						AND user_active = 1
						AND ((user_bot_agent <> \'\' AND user_bot_agent IS NOT NULL) OR (user_bot_ips <> \'\' AND user_bot_ips IS NOT NULL))
					ORDER BY username';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->data = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( !empty($row['user_bot_ips']) )
			{
				// unformat ips
				$ips = explode(',', $row['user_bot_ips']);
				$count_ips = count($ips);
				for ( $i = 0; $i < $count_ips; $i++ )
				{
					$ip = explode('.', phpbb_rtrim(chunk_split($ips[$i], 2, '.'), '.'));
					$count_ip = count($ip);
					for ( $j = 0; $j < $count_ip; $j++ )
					{
						$ip[$j] = hexdec($ip[$j]);
					}
					$ips[$i] = implode('.', $ip);
				}
				$row['user_bot_ips'] = implode(', ', $ips);
			}
			$this->data[ intval($row['user_id']) ] = $row;
		}
		$db->sql_freeresult($result);
	}

	function display()
	{
		global $template, $user, $config;

		if ( !empty($this->data) )
		{
			$color = false;
			foreach ( $this->data as $user_id => $row )
			{
				$color = !$color;
				$template->assign_block_vars('row', array(
					'BOT_NAME' => $row['username'],
					'BOT_AGENT' => $row['user_bot_agent'],
					'BOT_IPS' => $row['user_bot_ips'],
					'U_EDIT' => $config->url($this->requester, array('mode' => 'edit', POST_USERS_URL => $row['user_id']), true),
					'U_DELETE' => $config->url($this->requester, array('mode' => 'delete', POST_USERS_URL => $row['user_id']), true),
				));
				$template->set_switch('row.light', $color);
			}
		}
		$template->set_switch('empty', empty($this->data));
		$template->assign_vars(array(
			'L_BOT_NAME' => $user->lang('Bot_name'),
			'L_BOT_AGENT' => $user->lang('Bot_agent'),
			'L_BOT_IPS' => $user->lang('Bot_ips'),
			'L_ACTION' => $user->lang('Action'),
			'L_EMPTY' => $user->lang('No_bots_create'),

			'I_EDIT' => $user->img('cmd_edit'),
			'L_EDIT' => $user->lang('Bots_edit'),
			'I_DELETE' => $user->img('cmd_delete'),
			'L_DELETE' => $user->lang('Bots_delete'),
		));
		display_buttons(array(
			'create' => array('txt' => 'Bots_create', 'img' => 'cmd_create', 'key' => 'cmd_create', 'url' => $this->requester, 'parms' => array('mode' => 'create')),
		));
		$template->set_filenames(array('body' => 'admin/bots_list_body.tpl'));
	}
}

class bots_details
{
	var $requester;
	var $mode;
	var $bot_id;
	var $form;

	function bots_details($requester)
	{
		$this->requester = $requester;
		$this->mode = '';
		$this->bot_id = 0;
		$this->form = '';
	}

	function process($mode='')
	{
		if ( $this->init($mode) )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init($mode)
	{
		if ( !in_array($mode, array('edit', 'delete', 'create')) || _button('cancel_form') )
		{
			return false;
		}
		$this->mode = $mode;
		return true;
	}

	function check()
	{
		global $user, $config, $bots;
		global $error, $error_msg;

		if ( $this->mode == 'create' )
		{
			$this->bot_id = 0;
		}
		else
		{
			$bot_id = _read(POST_USERS_URL, TYPE_INT);
			if ( empty($bots->data) || !isset($bots->data[$bot_id]) )
			{
				_error('Bot_not_exists');
			}
			else
			{
				$this->bot_id = $bot_id;
			}
		}

		if ( $error )
		{
			message_return($error_msg, 'Click_return_bots_management', $config->url($this->requester, '', true), 10);
		}
	}

	function validate()
	{
		global $config, $user, $bots;

		// define the form
		$form_fields = array(
			'bot_name' => array('field' => 'username', 'type' => 'varchar', 'legend' => 'Bot_name', 'explain' => 'Bot_name_explain', 'length_mini' => 3, 'length_maxi' => 25, 'length' => 25, 'length_mini_error' => 'Bot_name_short'),
			'bot_agent' => array('field' => 'user_bot_agent', 'type' => 'text', 'legend' => 'Bot_agent', 'explain' => 'Bot_agent_explain'),
			'bot_ips' => array('field' => 'user_bot_ips', 'type' => 'text', 'legend' => 'Bot_ips', 'explain' => 'Bot_ips_explain'),
		);
		foreach ( $form_fields as $field_name => $field )
		{
			if ( $this->mode != 'create' )
			{
				$form_fields[$field_name]['value'] = $bots->data[$this->bot_id][ $form_fields[$field_name]['field'] ];
				if ( $field_name == 'bot_ips' )
				{
					$form_fields[$field_name]['value'] = empty($form_fields[$field_name]['value']) ? '' : preg_replace('#\s?,\s?#', ', ', $form_fields[$field_name]['value']);
				}
			}
			if ( $this->mode == 'delete' )
			{
				$form_fields[$field_name]['output'] = true;
				if ( isset($form_fields[$field_name]['explain']) )
				{
					unset($form_fields[$field_name]['explain']);
				}
			}
		}

		// instantiate this
		$this->form = new bots_details_form($this->requester, $form_fields);
	}

	function display()
	{
		global $template, $config, $user;
		global $warning, $warning_msg;

		// process the form
		$this->form->set_buttons(array(
			'submit_form' => array('txt' => ($this->mode == 'delete') ? 'Delete' : 'Submit', 'img' => ($this->mode == 'delete') ? 'cmd_delete' : 'cmd_submit', 'key' => ($this->mode == 'delete') ? 'cmd_delete' : 'cmd_submit'),
			'cancel_form' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		));
		$this->form->process($this->mode, $this->bot_id);

		if ( $warning )
		{
			$template->assign_block_vars('warning', array(
				'WARNING_TITLE' => $user->lang('Information'),
				'WARNING_MSG' => $warning_msg,
			));
		}

		// send all to template
		_hide('mode', $this->mode);
		_hide(POST_USERS_URL, $this->bot_id);
		$template->set_filenames(array('body' => 'form_body.tpl'));
	}
}

class bots_details_form extends form
{
	var $requester;
	var $bot_id;

	function bots_details_form($requester, &$fields)
	{
		parent::form($fields, true);
		$this->requester = $requester;
	}

	function process($mode, $bot_id)
	{
		$this->init($mode, $bot_id);
		$this->check();
		$this->validate();
		$this->display();
	}

	function init($mode, $bot_id)
	{
		$this->mode = $mode;
		$this->bot_id = $bot_id;
	}

	function check()
	{
		global $config, $user, $db;
		global $error, $error_msg;
		global $warning, $warning_msg;

		if ( !_button('submit_form') || ($this->mode == 'delete') )
		{
			return;
		}

		// check basic fields and made errors warnings
		parent::check();
		if ( $error )
		{
			$warning = $error;
			$warning_msg = $error_msg;
			$error = false;
			$error_msg = false;
		}

		// continue checks
		if ( !$warning )
		{
			// check username
			$bot_name = trim(stripslashes(phpbb_clean_username(addslashes($this->fields['bot_name']->value))));
			if ( $bot_name != $this->fields['bot_name']->value )
			{
				_warning('Bot_name_adjusted');
			}
			$this->fields['bot_name']->value = $bot_name;
			if ( strlen($this->fields['bot_name']->value) < 3 )
			{
				_warning('Bot_name_short');
			}

			// format ips
			$orig_ips = $this->fields['bot_ips']->value;
			$ips = empty($orig_ips) ? array() : explode(',', preg_replace("#[\n\r\s\t]#", '', $orig_ips));
			$count_ips = count($ips);
			for ( $i = 0; $i < $count_ips; $i++ )
			{
				$ip = explode('.', $ips[$i]);
				$count_ip = $count_ip;
				for ( $j = 0; $j < $count_ip; $j++ )
				{
					if ( $j > 3 )
					{
						unset($ip[$j]);
					}
					else
					{
						$ip[$j] = min(255, max(0, intval($ip[$j])));
					}
				}
				if ( empty($ip) )
				{
					unset($ips[$i]);
				}
				else
				{
					$ips[$i] = implode('.', $ip);
				}
			}
			if ( !empty($ips) )
			{
				$ips = array_keys(array_flip($ips));
				asort($ips);
			}
			$this->fields['bot_ips']->value = empty($ips) ? '' : implode(', ', $ips);
			if ( $orig_ips != $this->fields['bot_ips']->value )
			{
				_warning('Bot_ips_adjusted');
			}

			// check if at least bot_ips or bot_agent are filled
			if ( empty($this->fields['bot_ips']->value) && empty($this->fields['bot_agent']->value) )
			{
				_warning('Bot_agent_or_ips');
			}
		}

		// final checks
		if ( !$warning )
		{
			// check username against the database
			$sql = 'SELECT user_id
						FROM ' . USERS_TABLE . '
						WHERE LOWER(username) = \'' . $db->sql_escape_string(strtolower($this->fields['bot_name']->value)) . '\'';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( ($row = $db->sql_fetchrow($result)) && (($this->mode == 'create') || ($row['user_id'] != $this->bot_id)) )
			{
				_warning('Bot_name_exists');
			}
			$db->sql_freeresult($result);
		}
	}

	function validate()
	{
		global $config, $user, $db;
		global $error, $error_msg;
		global $warning, $warning_msg;

		if ( $error || $warning || _button('cancel_form') || !_button('submit_form') )
		{
			return;
		}

		switch ( $this->mode )
		{
			case 'delete':
				$view_user = new user();
				$view_user->read($this->bot_id);
				$view_user->delete();
				unset($view_user);

				// recache bots
				$bots = new bots();
				$bots->read(true);
				unset($bots);

				$msg = 'Bot_deleted';
				break;

			case 'edit':
			case 'create':
				// encode properly the bot_ips
				$ips = empty($this->fields['bot_ips']->value) ? array() : explode(',', preg_replace("#[\n\r\s\t]#", '', $this->fields['bot_ips']->value));
				$count_ips = count($ips);
				for ( $i = 0; $i < $count_ips; $i++ )
				{
					$ip = explode('.', $ips[$i]);
					$count_ip = count($ip);
					for ( $j = 0; $j < $count_ip; $j++ )
					{
						$ip[$j] = sprintf('%02x', $ip[$j]);
					}
					$ips[$i] = implode('', $ip);
				}
				$this->fields['bot_ips']->value = empty($ips) ? '' : implode(',', $ips);

				// prepare the fields
				$password = md5(mt_rand());
/*
				$password = $user->data['user_password'];
				$email = $user->data['user_email'];
*/
				$fields = array(
					'username' => $this->fields['bot_name']->value,
					'user_password' => $password,
					'user_email' => str_replace(' ', '_', $this->fields['bot_name']->value) . strrchr($config->data['board_email'], '@'),
					'user_active' => true,
					'user_bot_agent' => $this->fields['bot_agent']->value,
					'user_bot_ips' => $this->fields['bot_ips']->value,
					'user_posts' => 0,
					'user_level' => 0,
					'user_timezone' => 0,
					'user_dst' => 0,
					'user_style' => 0,
					'user_viewemail' => 0,
				);

				// edit
				if ( $this->mode == 'edit' )
				{
					$sql = 'UPDATE ' . USERS_TABLE . '
								SET ' . $db->sql_fields('update', $fields) . '
								WHERE user_id = ' . intval($this->bot_id);
					$db->sql_query($sql, false, __LINE__, __FILE__);

					// recache stats
					$user->read_stats(true);

					$msg = 'Bot_edited';
				}

				if ( $this->mode == 'create' )
				{
					$fields['user_regdate'] = time();

					// create new user
					$view_user = new user();
					$view_user->insert($fields);

					$msg = 'Bot_created';
				}

				// recache bots
				$bots = new bots();
				$bots->read(true);
				unset($bots);

				break;

			default:
				$msg = 'Unknown_action';
				break;
		}

		// send achievement message
		message_return($msg, 'Click_return_bots_management', $config->url($this->requester, '', true), 10);
	}
}

//
// main process
//

// read bots
$bots = new bots_management($requester);
$bots->read();
$handle = false;

// details ask ?
$bots_details = new bots_details($requester);
$handle = $bots_details->process($mode);

// not handle : send list
if ( !$handle )
{
	$mode = '';
	$bots->display();
}
unset($bots);

// send the display
_hide_set();
$template->assign_vars(array(
	'L_TITLE' => $user->lang($modes_allowed[$mode]['title']),
	'L_TITLE_EXPLAIN' => $user->lang($modes_allowed[$mode]['explain']),
	'L_FORM' => $user->lang($modes_allowed[$mode]['form']),
	'S_ACTION' => $config->url($requester, '', true),
));
include($config->url('admin/page_header_admin'));
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>