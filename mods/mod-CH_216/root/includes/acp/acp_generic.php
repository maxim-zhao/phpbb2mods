<?php
//
//	file: includes/acp/acp_generic.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.1 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

// no fields in form : end there
if ( empty($fields) )
{
	// send "no options" with left side menus
	$cp_panels->display_empty();
	return;
}

class config_auto_form extends auto_form
{
	function update_table(&$fields)
	{
		global $config;

		$config->begin_transaction();
		foreach ( $fields as $name => $value )
		{
			$config->set($name, $value);
		}
		$config->end_transaction();

		// recache forums
		if ( !class_exists('forums') )
		{
			include($config->url('includes/class_forums'));
		}
		$forums = new forums();
		$forums->read(true);

		// send achievement message
		message_return('Config_updated', $this->return_msg, $config->url($this->requester, $this->return_parms, true));
	}
}

// instantiate the form
$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);
$form = new config_auto_form($config->data, $fields, $cp_requester, 'Click_return_' . $subm_id, $cp_parms + $parms);
$form->process();
$template->set_switch('form');
$template->set_filenames(array('body' => 'cp_generic.tpl'));

?>