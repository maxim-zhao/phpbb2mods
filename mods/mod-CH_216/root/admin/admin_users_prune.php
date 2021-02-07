<?php
//
//	file: admin/admin_users_prune.php
//	author: ptirhiik
//	begin: 26/01/2006
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);

$file = basename(__FILE__);
if( !empty($setmodules) )
{
	$module['Users']['02_Users_prune'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_users_prune';

$no_page_header = true;
require('./pagestart.' . $phpEx);
include($config->url('includes/class_form'));
include($config->url('includes/class_forums'));

$form_fields = array(
	'days_old' => array('type' => 'int', 'legend' => 'Users_prune_days', 'explain' => 'Users_prune_days_explain', 'post_value' => 'Days', 'value' => intval($config->data['users_prune_older']) ? intval($config->data['users_prune_older']) : 7, 'mini_value' => 1),
	'inactive' => array('type' => 'radio_list', 'legend' => 'Users_prune_inactive_only', 'value' => true, 'options' => array(1 => 'Yes', 0 => 'No')),
);

class prune_users extends generic_form
{
	function prune_users($requester)
	{
		parent::generic_form($requester, '', '');
	}

	function process(&$form_fields)
	{
		if ( $this->init($form_fields) )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init(&$form_fields)
	{
		$this->init_form($form_fields);
		return !empty($this->fields);
	}

	function check()
	{
		global $user, $config, $db;
		global $error, $error_msg;

		if ( !_button('submit_form') )
		{
			return;
		}
		if ( $error )
		{
			$l_link = 'Click_return_users_prune';
			$u_link = $config->url($this->requester, '', true);
			message_return($error_msg, $l_link, $u_link);
		}
	}

	function validate()
	{
		global $user, $config, $db;
		global $error, $error_msg;

		if ( !_button('submit_form') || $error )
		{
			return;
		}
		$l_link = 'Click_return_users_prune';
		$u_link = $config->url($this->requester, '', true);

		// get users
		$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE user_id NOT IN(' . ANONYMOUS . ', ' . intval($user->data['user_id']) . ')
						AND (user_bot_agent = \'\' OR user_bot_agent IS NULL)
						AND (user_bot_ips = \'\' OR user_bot_ips IS NULL)
						AND user_posts = 0
						AND user_regdate < ' . (time() - (intval($this->fields['days_old']->value) * 86400)) . (!$this->fields['inactive']->value ? '' : '
						AND user_active <> 1');
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$user_ids = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$user_ids[] = intval($row['user_id']);
		}
		$db->sql_freeresult($result);
		$deleted = 0;
		if ( !empty($user_ids) )
		{
			$deleted = $user->delete($user_ids);
		}
		message_return(sprintf($user->lang('Users_pruned'), $deleted), $l_link, $u_link);
	}
}

//
// main process
//
$prune_users = new prune_users($requester);
$prune_users->process($form_fields);

// send the display
$template->assign_vars(array(
	'L_TITLE' => $user->lang('Users_prune'),
	'L_TITLE_EXPLAIN' => $user->lang('Users_prune_explain'),
	'L_FORM' => $user->lang('Users_prune'),
	'S_ACTION' => $config->url($requester, '', true),
));
$template->set_filenames(array('body' => 'form_body.tpl'));
include($config->url('admin/page_header_admin'));
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>