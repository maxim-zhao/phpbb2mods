<?php
//
//	file: includes/ucp/ucp_generic.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.1 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

// remove fields overridden in config
foreach ( $fields as $field => $def )
{
	if ( isset($def['config_over']) && $def['config_over'] && intval($config->data[ $def['config_over'] ]) )
	{
		unset($fields[$field]);
	}
}

// no fields in form : end there
if ( empty($fields) )
{
	// send "no options" with left side menus
	$cp_panels->display_empty();
	return;
}

class user_auto_form extends auto_form
{
	function update_table(&$fields)
	{
		global $db, $config, $user, $view_user;

		$db->sql_statement($fields);
		$sql = 'UPDATE ' . USERS_TABLE . '
					SET ' . $db->sql_update . '
					WHERE user_id = ' . intval($this->table_data['user_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// send achievement message
		message_return('Profile_updated' . ($view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other'), $this->return_msg, $config->url($this->requester, $this->return_parms, true));
	}
}

// instantiate the form
$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);
$form = new user_auto_form($view_user->data, $fields, $cp_requester, 'Click_return_' . $menu_id . ($view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other'), $cp_parms + $parms);
$form->process();
$template->set_switch('form');
$template->set_filenames(array('body' => 'cp_generic.tpl'));

?>