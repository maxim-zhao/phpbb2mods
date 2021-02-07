<?php
//
//	file: includes/class_form.php
//	author: ptirhiik
//	begin: 05/09/2004
//	version: 1.6.1 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// fields
if ( !class_exists('field') )
{
	include($config->url('includes/class_fields'));
}

//
// basic form
//

class form
{
	var $fields;
	var $mode;
	var $width;
	var $buttons;

	function form(&$fields)
	{
		$this->fields = array();
		$this->buttons = array(
			'submit_form' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
		);
		if ( !empty($fields) )
		{
			foreach ( $fields as $field_name => $field_data )
			{
				$class = class_exists('field_' . $field_data['type']) ? 'field_' . $field_data['type'] : 'field_varchar';
				$this->fields[$field_name] = new $class($field_name, $field_data);
			}
		}
	}

	function process($mode='', $submit=false, $cancel=false, $tpl_switch='')
	{
		$this->init($mode);
		if ( _button('submit_form') || (isset($this->buttons['delete_form']) && _button('delete_form')) || $submit )
		{
			$this->check();
			$this->validate();
		}
		if ( !_button('cancel_form') || $cancel )
		{
			$this->display($tpl_switch);
		}
	}

	function init($mode='')
	{
		$this->mode = $mode;
	}

	function check()
	{
		foreach ( $this->fields as $field_name => $field )
		{
			$this->fields[$field_name]->check();
		}
	}

	function validate()
	{
	}

	function display($tpl_switch='')
	{
		global $template, $config, $user;

		$tpl_switch = empty($tpl_switch) ? 'FORM' : $tpl_switch;
		foreach ( $this->fields as $field_name => $field )
		{
			$this->fields[$field_name]->display();
		}
		display_buttons($this->buttons);
		$template->assign_vars(array($tpl_switch => $template->include_file('form_fields.tpl', array('field'))));
	}

	function set_buttons($buttons)
	{
		$this->buttons = empty($buttons) ? array() : $buttons;
	}
}

class generic_form extends form
{
	var $requester;
	var $parms;
	var $return_message;

	function generic_form($requester, $parms='', $return_message='')
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->return_message = $return_message;
	}

	function init_form(&$fields)
	{
		parent::form($fields);
	}

	function display()
	{
		global $template, $config;

		// display the form
		parent::display();

		// add titles
		$template->assign_vars(array(
			'S_ACTION' => $config->url($this->requester, '', true),
		));

		// hide parms
		if ( !empty($this->parms) )
		{
			foreach ( $this->parms as $parm => $value )
			{
				_hide($parm, $value, true);
			}
		}

		return true;
	}
}

// basic auto form (used by auto-generated panels)
class auto_form extends form
{
	var $requester;
	var $return_msg;
	var $return_parms;
	var $table_data;

	function auto_form(&$table_data, &$fields, $requester, $return_msg='', $return_parms='')
	{
		$this->table_data = $table_data;
		$this->requester = $requester;
		$this->return_msg = $return_msg;
		$this->return_parms = empty($return_parms) ? array() : $return_parms;

		// retrieve values from data
		if ( !empty($fields) )
		{
			foreach ( $fields as $field_name => $field_data )
			{
				if ( !empty($field_data['field']) )
				{
					$fields[$field_name]['value'] = $this->table_data[ $field_data['field'] ];
				}
				if ( !empty($field_data['sub_fields']) && is_array($field_data['sub_fields']) )
				{
					foreach ( $field_data['sub_fields'] as $sub_field_name => $sub_field_table_field )
					{
						$fields[$field_name]['sub_values'][$sub_field_name] = $this->table_data[$sub_field_table_field];
					}
				}
			}
		}

		// init the fields
		parent::form($fields);
	}

	function process()
	{
		$this->init();
		if ( _button('submit_form') || _button('delete_form') )
		{
			$this->check();
			$this->validate();
		}
		$this->display();
	}

	function check()
	{
		global $error, $error_msg;
		global $config;

		// check fields
		parent::check();

		// halt on error
		if ( $error )
		{
			message_return($error_msg, $this->return_msg, $config->url($this->requester, $this->return_parms, true), 10);
		}
	}

	function validate()
	{
		global $db, $config;

		$fields = array();
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
		if ( !empty($fields) )
		{
			$this->update_table($fields);
		}
	}

	function update_table(&$fields)
	{
	}
}

?>