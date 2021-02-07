<?php
//
//	file: includes/ucp/ucp_register_new.php
//	author: ptirhiik
//	begin: 05/05/2006
//	version: 1.6.6 - 12/03/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

define('SID_CHECK', true);
define('DISALLOW_AGREEMENT', false);

$cp_no_menus = true;

define('RULES_NOT_AGREED', 0);
define('RULES_AGREED', 1);
define('RULES_AGREED_COPPA', 2);

// minimal size for the password
$password_mini = intval($config->data['password_mini']) ? intval($config->data['password_mini']) : 5;

include_once($config->url('includes/ucp/ucp_fields'));
include_once($config->url('includes/emailer'));

// define fields
$register_fields = array(
	'username' => array('type' => 'username', 'legend' => 'Username', 'form_only' => true, 'length' => 30, 'length_mini' => 3, 'value' => ''),
	'user_email' => array('type' => 'email', 'legend' => 'Email_address', 'form_only' => true, 'length_mini' => 1),
	'new_password' => array('type' => 'password', 'legend' => 'Password', 'form_only' => true, 'length' => 32, 'length_mini' => $password_mini, 'length_mini_error' => sprintf($user->lang('Password_short'), $password_mini), 'length_maxi' => 32, 'length_maxi_error' => 'Password_long', 'empty_allowed' => true),
	'cnf_password' => array('type' => 'password', 'legend' => 'Confirm_password', 'form_only' => true, 'length' => 32),
);

if ( intval($config->data['enable_confirm']) )
{
	include($config->url('includes/vc/class_visual_confirm'));
	class field_visual_confirm extends field
	{
		var $visual_confirm;

		function field_visual_confirm()
		{
			global $requester;
			$this->visual_confirm = new visual_confirm($requester);
			return false;
		}
		function init()
		{
			return false;
		}
		function check()
		{
			return false;
		}
		function validate()
		{
		}
		function display()
		{
			global $template;

			$this->visual_confirm->display();
			$template->set_switch('light_legend');
			$template->set_switch('field');
			$template->set_switch('field.data');
			$template->assign_block_vars('field.data.include', array('TPL' => $template->include_file('visual_confirm_box.tpl')));
		}
		function check_confirm()
		{
			global $error, $error_msg;

			if ( $res = $this->visual_confirm->check('confirm_id', 'confirm_code', 'Too_many_registers') )
			{
				_error($res);
			}
		}
		function no_check()
		{
			$this->visual_confirm->no_check('confirm_id');
		}
	}

	$register_fields += array(
		'visual_confirm' => array('type' => 'visual_confirm'),
	);
}
$fields = empty($fields) ? $register_fields : $register_fields + $fields;
unset($register_fields);

class user_agreement
{
	var $requester;
	var $agreement_list;
	var $agree;

	function user_agreement(&$fields, $requester='')
	{
		global $config;

		$this->requester = empty($requester) ? 'usercp' : $requester;
		$this->agree = -1;
		$this->agreement_list = (!isset($config->data['coppa_required']) || $config->data['coppa_required']) && (!isset($fields['user_birthday']) || intval($fields['user_birthday']['empty_allowed'])) ? array(
			RULES_NOT_AGREED => 'Agree_not',
			RULES_AGREED => 'Agree_over_13',
			RULES_AGREED_COPPA => 'Agree_under_13',
		) : array(
			RULES_NOT_AGREED => 'Agree_not',
			RULES_AGREED => 'Agree',
		);
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
		global $user, $config;

		$this->agree = -1;
		if ( defined('DISALLOW_AGREEMENT') && DISALLOW_AGREEMENT )
		{
			$this->agree = 1;
			return false;
		}
		if ( $user->auth(POST_GROUPS_URL, 'ucp_edit_admin', GROUP_REGISTERED) )
		{
			$this->agree = 1;
		}
		else
		{
			$this->agree = _read_form('agree', TYPE_INT, -1);
			if ( !isset($this->agreement_list[ $this->agree ]) )
			{
				$this->agree = -1;
			}
			// we may have preferred for the validation two or three buttons
			if ( $this->agree == -1 )
			{
				if ( _button('agree_no') )
				{
					$this->agree = RULES_NOT_AGREED;
				}
				else if ( _button('agree_yes') )
				{
					$this->agree = RULES_AGREED;
				}
				else if ( _button('agree_under_age') && isset($this->agreement_list[RULES_AGREED_COPPA]) )
				{
					$this->agree = RULES_AGREED_COPPA;
				}
			}
		}
		return $this->agree <= 0;
	}

	function check()
	{
	}

	function validate()
	{
		global $config;
		if ( $this->agree == RULES_NOT_AGREED )
		{
			redirect($config->url(INDEX, '', true));
		}
	}

	function display()
	{
		global $config, $user, $template;

		foreach ( $this->agreement_list as $key => $legend )
		{
			$template->assign_block_vars('agree', array(
				'VALUE' => $key,
				'LEGEND' => $user->lang($legend),
			));
			$template->set_switch('agree.selected', !$key);
		}
		$this->display_forum_rules();
		display_buttons(array(
			'submit_agree' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
			'cancel_agree' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		));
		$template->set_filenames(array('body' => 'ucp/ucp_agreement.tpl'));
	}

	function display_forum_rules()
	{
		global $db, $config, $user, $template;

		// check if the topic/post exists
		$row = false;
		if ( intval($config->data['forum_rules']) )
		{
			$sql = 'SELECT t.topic_id, t.topic_title, t.topic_replies, p.poster_id, u.username, p.post_username, p.post_time, p.post_edit_count, p.post_edit_time, p.enable_bbcode, p.enable_html, p.enable_smilies, pt.*
						FROM ' . TOPICS_TABLE . ' t, ' . POSTS_TABLE . ' p, ' . POSTS_TEXT_TABLE . ' pt, ' . USERS_TABLE . ' u
						WHERE t.topic_id = ' . intval($config->data['forum_rules']) . '
							AND p.post_id = t.topic_first_post_id
							AND pt.post_id = t.topic_first_post_id
							AND u.user_id = p.poster_id';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}
		// no topic rules : send default ones
		if ( !$row )
		{
			$template->assign_vars(array(
				'L_AGREE_TITLE' => $user->lang('Registration'),
				'L_AGREEMENT' => $user->lang('Reg_agreement'),
			));
			return;
		}

		// parse the rules
		if ( !class_exists('message') )
		{
			include($config->url('includes/class_message'));
		}
		$message_parser = new message();
		$switches = array(
			'html' => intval($row['enable_html']),
			'bbcode' => intval($row['enable_bbcode']),
			'smilies' => intval($row['enable_smilies']),
		);
		$message_parser->parse($row['post_text'], $row['bbcode_uid'], $switches);
		unset($message_parser);
		$poster = $row['poster_id'] == ANONYMOUS ? (empty($row['post_username']) ? $user->lang('Guest') : $row['post_username']) : $row['username'];
		$template->assign_vars(array(
			'L_AGREE_TITLE' => $user->lang('Registration'),
			'L_AGREEMENT' => $row['post_text'],
			'L_EDITED' => intval($row['post_edit_count']) ? sprintf($user->lang(($row['post_edit_count'] == 1) ? 'Edited_time_total' : 'Edited_times_total'), $poster, $user->date($row['post_edit_time']), $row['post_edit_count']) : '',
			'L_READ_NEXT' => $user->lang('Next'),
			'U_READ_NEXT' => intval($row['topic_replies']) ? $config->url($this->requester, array('rules' => 1), true) : '',
			'I_READ_NEXT' => $user->img('cmd_next'),
		));
		$template->set_switch('edited', intval($row['post_edit_count']));
		$template->set_switch('read_next', intval($row['topic_replies']));
		$template->set_switch('edited_or_read_next', intval($row['post_edit_count']) || intval($row['topic_replies']));
		return;
	}
}

class user_register_new extends form
{
	var $requester;
	var $return_msg;
	var $return_parms;
	var $view_user;
	var $is_admin;
	var $agree;

	function user_register_new(&$fields, $requester, $return_msg, $return_parms='', $agree=false)
	{
		global $user;
		global $warning, $warning_msg;
		$warning = $warning_msg = false;

		$this->requester = $requester;
		$this->return_msg = $return_msg;
		$this->return_parms = empty($return_parms) ? array() : $return_parms;
		$this->view_user = false;
		$this->is_admin = $user->auth(POST_GROUPS_URL, 'ucp_edit_admin', GROUP_REGISTERED);
		$this->agree = $agree;

		// init the fields
		parent::form($fields);
	}

	function process()
	{
		$this->init();
		$this->check();
		$this->validate();
		$this->display();
	}

	function check()
	{
		global $user;
		global $error, $error_msg;
		global $warning, $warning_msg;

		$warning = $warning_msg = false;

		// check sid
		if ( SID_CHECK && (!($sid = _read_form('sid', TYPE_NO_HTML)) || ($sid != $user->data['session_id'])) )
		{
			_error('Session_invalid');
		}

		if ( !_button('submit_form') )
		{
			return;
		}

		// check the new & confirm passwords
		if ( !empty($this->fields['new_password']->value) && ($this->fields['cnf_password']->value != $this->fields['new_password']->value) )
		{
			_error('Password_mismatch');
		}

		if ( isset($this->fields['visual_confirm']) )
		{
			if ( !$error )
			{
				$this->fields['visual_confirm']->check_confirm();
			}
			else
			{
				$this->fields['visual_confirm']->no_check();
			}
		}

		// do other checks
		parent::check();

		// halt on error
		if ( $error )
		{
			_warning($error_msg);
			$error = $error_msg = false;
		}
	}

	function validate()
	{
		global $template, $config, $user, $forums;
		global $error, $error_msg;
		global $warning, $warning_msg;

		if ( !_button('submit_form') || $warning || $error )
		{
			return;
		}

		// basic fields
		if ( empty($this->fields['new_password']->value) )
		{
			$val = dss_rand();
			$this->fields['new_password']->value = strtoupper(str_replace('0', 'o', substr($val, mt_rand(0, strlen($val) - 7), 6)));
		}
		$fields = array(
			'username' => $this->fields['username']->value,
			'user_email' => $this->fields['user_email']->value,
			'user_password' => md5($this->fields['new_password']->value),
			'user_regdate' => time(),
			'user_lastvisit' => 0,
			'user_active' => 0,
			'user_actkey' => substr(gen_rand_string(true), 0, max(6, 54 - strlen($config->get_script_path()))),
		);

		// no activation or admin activation, and the user is a user administrator
		if ( !($coppa = $this->is_coppa()) && ((intval($config->data['require_activation']) == USER_ACTIVATION_NONE) || ((intval($config->data['require_activation']) == USER_ACTIVATION_ADMIN) && $this->is_admin)) )
		{
			$fields = array_merge($fields, array(
				'user_active' => 1,
				'user_actkey' => '',
			));
		}

		// deals with other fields
		foreach ( $this->fields as $field_name => $field )
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
					$fields[$sub_field_table_field] = $field->data['sub_values'][$sub_field_name];
				}
			}
		}

		// create the user
		$this->set_default($fields);
		$view_user = new user();
		$view_user->insert($fields);

		// send mails
		$return_message = $this->send_activation_email($view_user, $coppa);

		// message return
		message_return($return_message);
	}

	function display()
	{
		global $template, $user;
		global $warning, $warning_msg;

		if ( $warning )
		{
			$template->assign_block_vars('warning', array(
				'WARNING_TITLE' => $user->lang('Information'),
				'WARNING_MSG' => $warning_msg,
			));
		}
		_hide('agree', $this->agree);
		_hide('sid', $user->data['session_id']);

		parent::display();
	}

	function set_default(&$fields)
	{
		global $config;

		$dft_fields = array(
			'user_style' => 0,
			'user_lang' => array('cfg' => 'default_lang', 'type' => 'string'),
			'user_dateformat' => array('cfg' => 'default_dateformat', 'type' => 'string'),
			'user_smart_date' => 0,
			'user_dst' => array('cfg' => 'board_dst'),

			'user_viewemail' => !intval($config->data['email_disable']),
			'user_notify_pm' => !intval($config->data['privmsg_disable']),
			'user_popup_pm' => !intval($config->data['privmsg_disable']),

			'user_keep_unreads' => 0,
			'user_attachsig' => 0,
			'user_allowhtml' => array('cfg' => 'allow_html'),
			'user_allowbbcode' => array('cfg' => 'allow_bbcode'),
			'user_allowsmile' => array('cfg' => 'allow_smilies'),
			'user_allowavatar' => intval($config->data['allow_avatar_local']) || intval($config->data['allow_avatar_remote']) || intval($config->data['allow_avatar_upload']),
			'user_allow_pm' => 1,
			'user_allow_viewonline' => 1,
			'user_notify' => 0,

			'user_board_box' => 0,
			'user_index_split' => 0,
			'user_index_pack' => 0,

			'user_topics_sort' => '',
			'user_topics_order' => '',
			'user_posts_sort' => '',
			'user_posts_order' => '',
		);
		foreach ( $dft_fields as $field_name => $field_def )
		{
			if ( !is_array($field_def) )
			{
				if ( !isset($fields[$field_name]) )
				{
					$fields[$field_name] = $field_def;
				}
			}
			else if ( !isset($fields[$field_name]) || (isset($config->data[ $field_def['cfg'] . '_over' ]) && intval($config->data[ $field_def['cfg'] . '_over' ])) )
			{
				$fields[$field_name] = $field_def['type'] == 'string' ? $config->data[ $field_def['cfg'] ] : intval($config->data[ $field_def['cfg'] ]);
			}
		}
	}

	function is_coppa()
	{
		global $config, $user;

		if ( $coppa = (!$this->is_admin && (!isset($config->data['coppa_required']) || $config->data['coppa_required'])) )
		{
			if ( isset($this->fields['user_birthday']) && !empty($this->fields['user_birthday']->value) )
			{
				if ( ($xbirthday = birthday_parse($this->fields['user_birthday']->value)) && intval($xbirthday['y']) )
				{
					$xfrom = explode(', ', $user->date(time(), 'Y, m, d', false));
					$xfrom = array('y' => $from[0] - 13, 'm' => $from[1], 'd' => $from[2]);
					$birthday = $xbirthday['y'] * 10000 + $xbirthday['m'] * 100 + $xbirthday['d'];
					$from = $xfrom['y'] * 10000 + $xfrom['m'] * 100 + $xfrom['d'];
					$coppa = $birthday >= $from;
				}
			}
			else if ( $this->agree == RULES_AGREED )
			{
				$coppa = false;
			}
		}
		return $coppa;
	}

	function send_activation_email(&$view_user, $coppa)
	{
		global $config, $user, $db;

		$return_message = '';

		// A new user has been created : send him the appropriate mail
		$emailer = new emailer($config->data['smtp_delivery']);
		$tpl_vars_common = array(
			'SITENAME' => $config->data['sitename'],
			'USERNAME' => _un_htmlspecialchars($view_user->data['username']),
			'EMAIL_SIG' => empty($config->data['board_email_sig']) ? '' : str_replace('<br />', "\n", "-- \n" . $config->data['board_email_sig']),
		);

		// send the user mail
		$return_message = 'Account_added';
		$email_template = 'user_welcome';
		if ( !$this->is_admin )
		{
			if ( $coppa )
			{
				$return_message = 'COPPA';
				$email_template = 'coppa_welcome_inactive';
			}
			else if ( $config->data['require_activation'] == USER_ACTIVATION_SELF )
			{
				$return_message = 'Account_inactive';
				$email_template = 'user_welcome_inactive';
			}
			else if ( $config->data['require_activation'] == USER_ACTIVATION_ADMIN )
			{
				$return_message = 'Account_inactive_admin';
				$email_template = 'admin_welcome_inactive';
			}
		}

		$welcome = sprintf($user->lang('Welcome_subject'), $config->data['sitename']);
		if( $coppa )
		{
			$tpl_vars = $tpl_vars_common + array(
				'WELCOME_MSG' => $welcome,
				'PASSWORD' => $this->fields['new_password']->value,
				'FAX_INFO' => $config->data['coppa_fax'],
				'MAIL_INFO' => $config->data['coppa_mail'],
				'EMAIL_ADDRESS' => $view_user->data['user_email'],
				'ICQ' => isset($this->fields['user_icq']->value) ? $view_user->data['user_icq'] : '',
				'AIM' => isset($this->fields['user_aim']->value) ? $view_user->data['user_aim'] : '',
				'YIM' => isset($this->fields['user_yim']->value) ? $view_user->data['user_yim'] : '',
				'MSN' => isset($this->fields['user_msnm']->value) ? $view_user->data['user_msnm'] : '',
				'WEB_SITE' => isset($this->fields['user_website']->value) ? $view_user->data['user_website'] : '',
				'FROM' => isset($this->fields['user_from']->value) ? $view_user->data['user_from'] : '',
				'OCC' => isset($this->fields['user_occ']->value) ? $view_user->data['user_occ'] : '',
				'INTERESTS' => isset($this->fields['user_interests']->value) ? $view_user->data['user_interests'] : '',
			);
		}
		else
		{
			$tpl_vars = $tpl_vars_common + array(
				'WELCOME_MSG' => $welcome,
				'PASSWORD' => $this->fields['new_password']->value,
				'U_ACTIVATE' => $config->get_script_path() . $this->requester . '.' . $config->ext . '?mode=activate&' . POST_USERS_URL . '=' . $view_user->data['user_id'] . '&act_key=' . $view_user->data['user_actkey'],
			);
		}

		// send actually the mail
		$emailer->from($config->data['board_email']);
		$emailer->replyto($config->data['board_email']);
		$emailer->use_template($email_template, $view_user->data['user_lang']);
		$emailer->email_address($view_user->data['user_email']);
		$emailer->set_subject($welcome);
		$emailer->assign_vars($tpl_vars);
		$emailer->send();
		$emailer->reset();

		// send activation mail to admins if required
		if ( !intval($view_user->data['user_active']) && (intval($config->data['require_activation']) == USER_ACTIVATION_ADMIN) )
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
			$users = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$users[] = array(
					'user_email' => $row['user_email'],
					'user_lang' => $row['user_lang'],
				);
			}
			$db->sql_freeresult($result);

			$count_users = count($users);
			$tpl_vars = $tpl_vars_common + array(
				'U_ACTIVATE' => $config->get_script_path() . $this->requester . '.' . $config->ext . '?mode=activate&' . POST_USERS_URL . '=' . $view_user->data['user_id'] . '&act_key=' . $view_user->data['user_actkey'],
			);
			for ( $i = 0; $i < $count_users; $i++ )
			{
				$row = $users[$i];

				$emailer->from($config->data['board_email']);
				$emailer->replyto($config->data['board_email']);
				$emailer->email_address(trim($row['user_email']));
				$emailer->use_template('admin_activate', $row['user_lang']);
				$emailer->set_subject($user->lang('New_account_subject'));
				$emailer->assign_vars($tpl_vars);
				$emailer->send();
				$emailer->reset();
			}
		}
		return $return_message;
	}
}

// cancel pressed
if ( _button('cancel_agree') )
{
	redirect($config->url(INDEX, '', true));
}

// instantiate the form
$navigation->clear();
$navigation->add($cp_panels->data[ $menus[$menu_id] ]['panel_name'], '', $cp_requester, $cp_parms + array('mode' => $menu_id));
$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);
$handled = false;
$agree = -1;
if ( !$handled )
{
	$agreement = new user_agreement($fields, $cp_requester);
	$handled = $agreement->process();
	$agree = $agreement->agree;
	unset($agreement);
}
if ( !$handled )
{
	$form = new user_register_new($fields, $cp_requester, 'Click_return_' . $menu_id, $cp_parms + $parms, $agree);
	$form->process();
	$template->set_switch('form');
	$template->set_filenames(array('body' => 'form_body.tpl'));
}

?>