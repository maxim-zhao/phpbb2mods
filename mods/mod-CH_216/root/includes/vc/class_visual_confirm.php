<?php
//
//	file: includes/vc/class_visual_confirm.php
//	author: ptirhiik
//	begin: 17/03/2006
//	version: 1.6.2 - 30/12/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// visual confirm code : borrowed from usercp_register
class visual_confirm
{
	var $requester;

	function visual_confirm($requester='')
	{
		$this->requester = empty($requester) ? POSTING : $requester;
	}

	function prune_old()
	{
		global $db;

		$sql = 'DELETE FROM ' . CONFIRM_TABLE . '
					WHERE session_id NOT IN(' . $db->sql_subquery('session_id', '
						SELECT DISTINCT session_id
							FROM ' . SESSIONS_TABLE . '
							WHERE session_logged_in = 1
								OR session_user_id = ' . ANONYMOUS . '
						', __LINE__, __FILE__, true, TYPE_NO_HTML) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	function _read_code($name)
	{
		$res = _read_form($name, TYPE_NO_HTML);
		if ( $res && !preg_match('/^[A-Za-z0-9]+$/', $res) )
		{
			$res = '';
		}
		return $res;
	}

	function no_check($confirm_id_name)
	{
		global $db, $user;

		if ( $confirm_id = $this->_read_code($confirm_id_name) )
		{
			$sql = 'DELETE FROM ' . CONFIRM_TABLE . '
						WHERE confirm_id = \'' . $db->sql_escape_string($confirm_id) . '\'
							AND session_id = \'' . $db->sql_escape_string($user->data['session_id']) . '\'';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	function check($confirm_id_name, $confirm_code_name, $too_many_attempts='')
	{
		global $db, $user;

		$error = false;
		$error_msg = '';
		$too_many_attempts = empty($too_many_attempts) ? 'Too_many_attempts' : $too_many_attempts;

		$confirm_id = $this->_read_code($confirm_id_name);
		$confirm_code = $this->_read_code($confirm_code_name);
		if ( empty($confirm_id) || empty($confirm_code) )
		{
			$error = true;
			$error_msg = 'Confirm_code_wrong';
		}

		// check the number of attempts
		$sql = 'SELECT COUNT(session_id) AS count_session_id
					FROM ' . CONFIRM_TABLE . '
					WHERE session_id = \'' . $db->sql_escape_string($user->data['session_id']) . '\'';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$count_session_id = ($row = $db->sql_fetchrow($result)) ? intval($row['count_session_id']) : 0;
		$db->sql_freeresult($result);

		// critical error : end there
		if ( $count_session_id > 3 )
		{
			message_die(GENERAL_MESSAGE, $too_many_attempts);
		}

		// check the confirm id againts the confirm table
		if ( !$error )
		{
			$sql = 'SELECT code
						FROM ' . CONFIRM_TABLE . '
						WHERE confirm_id = \'' . $db->sql_escape_string($confirm_id) . '\'
							AND session_id = \'' . $db->sql_escape_string($user->data['session_id']) . '\'';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			if ( !$row )
			{
				$error = true;
				$error_msg = 'Confirm_code_wrong';
			}
		}
		if ( !$error && ($row['code'] != $confirm_code) )
		{
			$error = true;
			$error_msg = 'Confirm_code_wrong';
		}

		// no error, reset count
		if ( !$error)
		{
			$sql = 'DELETE FROM ' . CONFIRM_TABLE . '
						WHERE session_id = \'' . $db->sql_escape_string($user->data['session_id']) . '\'';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		return $error ? $error_msg : false;
	}

	function display($tpl_switch='')
	{
		global $db, $user, $config, $template;
		global $user_ip;

		// prune old sessions
		$this->prune_old();

		// generate a new code
		$fields = array(
			'confirm_id' => md5(uniqid($user_ip)),
			'session_id' => $user->data['session_id'],
			'code' => $this->confirm_code(),
		);
		$sql = 'INSERT INTO ' . CONFIRM_TABLE . '
					(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// send it to template
		$template->assign_vars(array(
			'CONFIRM_ID' => $fields['confirm_id'],
			'CONFIRM_IMG' => sprintf('<img src="%s" alt="" title="" />', $config->url($this->requester, array('mode' => 'confirm', 'id' => $fields['confirm_id']), true)),

			'L_CONFIRM_CODE_IMPAIRED' => sprintf($user->lang('Confirm_code_impaired'), '<a href="mailto:' . $config->data['board_email'] . '">', '</a>'),
			'L_CONFIRM_CODE' => $user->lang('Confirm_code'),
			'L_CONFIRM_CODE_EXPLAIN' => $user->lang('Confirm_code_explain'),
		));
		$template->set_switch((empty($tpl_switch) ? '' : $tpl_switch . '.') . 'switch_confirm');
	}

	function confirm_code()
	{
		global $config;

		// Generate the required confirmation code
		$allow_chars = '2349ACEFHKLMPQRTUVWXY';
		$len_allow_chars = strlen($allow_chars) - 1;

		$val = strtoupper(base_convert(dss_rand(), 16, 35));
		$len_val = strlen($val);
		for ( $i = 0; $i < $len_val; $i++ )
		{
			if ( !strpos(' ' . $allow_chars, $val[$i]) )
			{
				$val[$i] = $allow_chars[ mt_rand(0, $len_allow_chars) ];
			}
		}
		return substr($val, mt_rand(0, strlen($val) - 7), 6);
	}
}

?>