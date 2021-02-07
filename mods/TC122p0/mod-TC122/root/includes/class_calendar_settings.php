<?php
/***************************************************************************
 *                            class_calendar_settings.php
 *                            ---------------------------
 *	begin			: 25/04/2006
 *	copyright		: Ptirhiik
 *	email			: ptirhiik@clanmckeen.com
 *	version			: 0.0.2 - 19/05/2006
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class calendar_settings_form
{
	var $requester;
	var $parms;
	var $form_fields;

	function calendar_settings_form($requester, $parms='')
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
	}

	function read(&$data)
	{
		$this->data = &$data;
		$this->form_fields = array();
	}

	function init_form($with_default=true)
	{
		global $calendar_api;

		$list_radio = $with_default ? array(0 => 'Default', 1 => 'Yes', 2 => 'No') : array(0 => 'No', 1 => 'Yes');
		return array(
			'calendar_javascript' => array('field' => 'user_calendar_javascript', 'type' => 'list_radio', 'config' => 'calendar_javascript', 'over' => 'calendar_javascript_over', 'legend' => 'Calendar_use_java', 'options' => $list_radio),
			'calendar_overview' => array('field' => 'user_calendar_overview', 'type' => 'list_radio', 'config' => 'calendar_overview', 'over' => 'calendar_overview_over', 'legend' => 'Calendar_overview', 'options' => $list_radio),
			'calendar_display_open' => array('field' => 'user_calendar_display_open', 'type' => 'list_radio', 'config' => 'calendar_display_open', 'over' => 'calendar_display_open_over', 'legend' => 'Calendar_display_open', 'options' => $list_radio),
			'calendar_week_start' => array('field' => 'user_calendar_week_start', 'type' => 'list', 'config' => 'calendar_week_start', 'over' => 'calendar_week_start_over', 'legend' => 'Calendar_week_start', 'options' => $calendar_api->days_list),
			'calendar_title_length' => array('field' => 'user_calendar_title_length', 'type' => 'int', 'config' => 'calendar_title_length', 'over' => 'calendar_title_length_over', 'legend' => 'Calendar_title_length', 'value_mini' => 0),
			'calendar_text_length' => array('field' => 'user_calendar_text_length', 'type' => 'int', 'config' => 'calendar_text_length', 'over' => 'calendar_text_length_over', 'legend' => 'Calendar_text_length', 'value_mini' => 0),
			'calendar_header_cells' => array('field' => 'user_calendar_header_cells', 'type' => 'int', 'config' => 'calendar_header_cells', 'over' => 'calendar_header_cells_over', 'legend' => 'Calendar_header_cells', 'value_mini' => 0, 'value_maxi' => 7),
			'calendar_nb_row' => array('field' => 'user_calendar_nb_row', 'type' => 'int', 'config' => 'calendar_nb_row', 'over' => 'calendar_nb_row_over', 'legend' => 'Calendar_nb_row', 'value_mini' => 5),
		);
	}

	function display($show=true)
	{
		global $template, $user;

		if ( empty($this->form_fields) )
		{
			return;
		}
		if ( $show )
		{
			$row_opened = false;
			foreach ( $this->form_fields as $field => $def )
			{
				if ( $row_opened && !$def['combined'] )
				{
					$template->assign_block_vars('field.close_row', array());
					$template->assign_block_vars('field.close_row.in_admin' . (defined('IN_ADMIN') ? '' : '_ELSE'), array());
					$row_opened = false;
				}
				$template->assign_block_vars('field', array(
					'NAME' => $field,
					'LEGEND' => $user->lang($def['legend']),
					'VALUE' => $def['value'],
				));
				if ( $open_row = (!$row_opened || !$def['combined']) )
				{
					$row_opened = true;
				}
				$open_row_switch = 'open_row' . ($open_row ? '' : '_ELSE');
				$template->assign_block_vars('field.' . $open_row_switch, array());
				$template->assign_block_vars('field.' . $open_row_switch . '.in_admin' . (defined('IN_ADMIN') ? '' : '_ELSE'), array());
				$template->assign_block_vars('field.' . $def['type'], array());
				if ( isset($def['options']) )
				{
					foreach ( $def['options'] as $key => $legend )
					{
						$template->assign_block_vars('field.' . $def['type'] . '.opt', array(
							'VALUE' => intval($key),
							'LEGEND' => $user->lang($legend),
						));
						$template->assign_block_vars('field.' . $def['type'] . '.opt.selected' . (intval($key) == intval($def['value']) ? '' : '_ELSE'), array());
					}
				}
			}
			if ( $row_opened )
			{
				$template->assign_block_vars('field.close_row', array());
				$template->assign_block_vars('field.close_row.in_admin' . (defined('IN_ADMIN') ? '' : '_ELSE'), array());
				$row_opened = false;
			}
			$template->assign_vars(array(
				'L_CALENDAR_FORM_TITLE' => $user->lang('Calendar_settings'),
			));
			$template->assign_block_vars('in_admin' . (defined('IN_ADMIN') ? '' : '_ELSE'), array());
			$template->set_filenames(array('calendar_settings_form' => 'calendar_settings_form.tpl'));
			$template->assign_var_from_handle('CALENDAR_FORM', 'calendar_settings_form');
		}
		else
		{
			$s_hidden_fields = '';
			foreach ( $this->form_fields as $field => $def )
			{
				$s_hidden_fields .= '<input type="hidden" name="' . $field . '" value="' . intval($def['value']) . '" />';
			}
			$template->_tpldata['.'][0]['S_HIDDEN_FIELDS'] .= $s_hidden_fields;
		}
	}

	function _read($name, $def, $value)
	{
		global $HTTP_POST_VARS;

		$value = $this->_cast($value, $def);
		if ( isset($HTTP_POST_VARS[$name]) )
		{
			$value = $this->_cast(intval($HTTP_POST_VARS[$name]), $def);
		}
		return $value;
	}

	function _cast($value, $def)
	{
		$value = intval($value);
		if ( isset($def['value_mini']) )
		{
			$value = max($value, $def['value_mini']);
		}
		if ( isset($def['value_maxi']) )
		{
			$value = min($value, $def['value_maxi']);
		}
		if ( isset($def['options']) && !isset($def['options'][$value]) )
		{
			@reset($def['options']);
			list($value, $dummy) = @each($def['options']);
		}
		return $value;
	}
}

class calendar_profile_form extends calendar_settings_form
{
	function read(&$data)
	{
		global $config, $user;

		parent::read(&$data);
		$fields = $this->init_form(true);

		// get values
		$found = false;
		foreach ( $fields as $field => $def )
		{
			$found |= isset($user->data[ $def['field'] ]);
			if ( !intval($config->data[ $def['over'] ]) )
			{
				$value = 0;
				if ( $def['type'] != 'list_radio' )
				{
					$value = intval($config->data[ $def['config'] ]);
				}
				if ( intval($this->data['user_id']) && ($this->data['user_id'] != ANONYMOUS) )
				{
					$value = intval($this->data[ $def['field'] ]);
				}
				$this->form_fields[$field] = $def + array('value' => $this->_read($field, $def, $value));
			}
		}
		if ( !$found )
		{
			$this->form_fields = array();
		}
	}

	function validate($user_id)
	{
		global $db;

		if ( empty($this->form_fields) )
		{
			return;
		}
		$sql_update = array();
		foreach ( $this->form_fields as $field => $def )
		{
			$sql_update[] = $def['field'] . ' = ' . intval($def['value']);
		}
		$sql = 'UPDATE ' . USERS_TABLE . '
					SET ' . implode(', ', $sql_update) . '
					WHERE user_id = ' . intval($user_id);
		if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) )
		{
			message_die(GENERAL_ERROR, 'Could not update user data', '', __LINE__, __FILE__, $sql);
		}
	}
}

class calendar_admin_board_form extends calendar_settings_form
{
	function read(&$data)
	{
		global $config;

		parent::read(&$data);
		$fields = $this->init_form(false);

		$list_no_yes = array(0 => 'No', 1 => 'Yes');
		$over_def = array('legend' => 'Override_user_choice', 'type' => 'list_radio', 'options' => $list_no_yes, 'combined' => true);

		// get values
		foreach ( $fields as $field => $def )
		{
			$this->form_fields[$field] = $def + array('value' => $this->_read($field, $def, intval($this->data[$field])));
			if ( isset($def['over']) )
			{
				$this->form_fields[ $def['over'] ] = $over_def + array('value' => $this->_read($def['over'], $over_def, intval($this->data[ $def['over'] ])));
			}
		}
	}

	function validate()
	{
		global $db;

		if ( empty($this->form_fields) )
		{
			return;
		}
		$sql = 'DELETE FROM ' . CONFIG_TABLE . '
					WHERE config_name IN(\'' . implode('\', \'', array_keys($this->form_fields)) . '\')';
		if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) )
		{
			message_die(GENERAL_ERROR, 'Could not delete config entries', '', __LINE__, __FILE__, $sql);
		}

		foreach ( $this->form_fields as $field => $def )
		{
			if ( intval($def['value']) )
			{
				$sql = 'INSERT INTO ' . CONFIG_TABLE . '
							(config_name, config_value) VALUES(\'' . $field . '\', \'' . intval($def['value']) . '\')';
				if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) )
				{
					message_die(GENERAL_ERROR, 'Could not insert config entries', '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}
}

?>