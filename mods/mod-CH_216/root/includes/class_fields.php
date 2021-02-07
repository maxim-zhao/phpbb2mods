<?php
//
//	file: includes/class_fields.php
//	author: ptirhiik
//	begin: 05/09/2004
//	version: 1.6.5 - 05/10/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

//
// basic field definition
//

class field
{
	var $name;
	var $data;
	var $type;
	var $value;

	function field($field_name, &$field_data)
	{
		$this->name = $field_name;
		$this->data = $field_data;
		$this->type = $field_data['type'];
		$this->init();
	}

	function init()
	{
		if ( isset($this->data['over']) && $this->data['over'] )
		{
			$this->data['over.light'] = !isset($this->data['over.light']) ? true : intval($this->data['over.light']);
			$this->data['over.center'] = !isset($this->data['over.center']) ? false : intval($this->data['over.center']);
			$this->data['over.colspan'] = !isset($this->data['over.colspan']) ? true : intval($this->data['over.colspan']);
		}
		if ( !isset($this->data['title']) )
		{
			$this->data['title'] = isset($this->data['legend']) ? $this->data['legend'] : '';
		}
		$value = isset($this->data['value']) ? $this->data['value'] : '';
		$this->value = isset($this->data['output']) && $this->data['output'] ? $value : $this->get_value($value);
	}

	function get_value($value)
	{
		return $this->encode(_read($this->name, TYPE_NO_HTML, $this->decode($value), '', isset($this->data['form_only']) ? intval($this->data['form_only']) : 0));
	}

	function get_displayed_value()
	{
		return isset($this->data['output']) && $this->data['output'] ? $this->parse($this->value) : $this->form_escape_string($this->decode($this->value));
	}

	function encode($value)
	{
		return $value;
	}

	function decode($value)
	{
		return $value;
	}

	function parse($value)
	{
		return $value;
	}

	function form_escape_string($value)
	{
		return empty($value) ? '' : str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), $value);
	}

	function display()
	{
		global $db, $config, $template, $user;

		// field is hidden
		if ( isset($this->data['hidden']) && $this->data['hidden'] )
		{
			$template->assign_block_vars('field.hidden', array(
				'NAME' => $this->name,
				'VALUE' => addslashes(stripslashes($this->value)),
			));
			return;
		}

		// javascript included
		if ( !empty($this->data['javascript']) )
		{
			$template->assign_block_vars('javascript', array(
				'U_JAVASCRIPT' => strrchr($this->data['javascript'], '.') == '.js' ? $config->root . $this->data['javascript'] : $config->url($this->data['javascript']),
			));
		}

		// switches
		$combined = isset($this->data['combined']) && $this->data['combined'];
		$over = isset($this->data['over']) && $this->data['over'];
		$hidden = isset($this->data['hidden']) && $this->data['hidden'];

		// set a new field
		$template->set_switch('field', !$combined);
		$template->set_switch('field.row', !$combined);

		// display legend
		$field_values = $this->field_values();
		if ( !$combined && !$over )
		{
			$template->assign_block_vars('field.legend', $field_values);
			$this->field_switches('legend');
		}
		if ( $over && !$combined && !$hidden )
		{
			$template->set_switch('field.over');
			$this->field_switches('over');
		}

		// display
		$template->assign_block_vars('field.data', $field_values);
		$this->field_switches('data');

		// display value
		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$template->set_switch('field.data.' . $this->type . '_output');
			$this->field_switches('data.' . $this->type . '_output');
		}
		else
		{
			$template->set_switch('field.data.' . $this->type . '_input');
			$this->field_switches('data.' . $this->type . '_input');
			$this->display_options();
		}
	}

	function field_values()
	{
		global $user, $config;
		return array(
			'LEGEND' => isset($this->data['legend']) && !empty($this->data['legend']) ? $user->lang($this->data['legend']) : '',
			'EXPLAIN' => isset($this->data['explain']) && !empty($this->data['explain']) ? $user->lang($this->data['explain']) : '',
			'WIDTH' => isset($this->data['width']) && !empty($this->data['width']) ? $this->data['width'] : '',
			'IMAGE' => isset($this->data['image']) && !empty($this->data['image']) ? $user->img($this->data['image']) : '',
			'TITLE' => isset($this->data['title']) && !empty($this->data['title']) ? $user->lang($this->data['title']) : '',
			'HTML' => isset($this->data['html']) && !empty($this->data['html']) ? $this->data['html'] : '',
			'NAME' => $this->name,
			'VALUE' => $this->get_displayed_value(),
			'POST_VALUE' => isset($this->data['post_value']) && !empty($this->data['post_value']) ? $user->lang($this->data['post_value']) : '',
			'LENGTH' => isset($this->data['length']) && !empty($this->data['length']) ? $this->data['length'] : 50,
			'U_LINK' => isset($this->data['link']) && !empty($this->data['link']) ? $this->data['link'] : '',
			'SPAN_HTML' => isset($this->data['span.html']) && !empty($this->data['span.html']) ? $this->data['span.html'] : '',
		);
	}

	function field_switches($level='')
	{
		global $template;
		$template->set_switch('field.' . $level . '.explain', isset($this->data['explain']) && !empty($this->data['explain']));
		$template->set_switch('field.' . $level . '.image', isset($this->data['image']) && !empty($this->data['image']));
		$template->set_switch('field.' . $level . '.link', isset($this->data['link']) && !empty($this->data['link']));
		$template->set_switch('field.' . $level . '.linefeed', isset($this->data['linefeed']) && $this->data['linefeed']);
		$template->set_switch('field.' . $level . '.bold', isset($this->data['bold']) && $this->data['bold']);
		$template->set_switch('field.' . $level . '.light', isset($this->data[$level . '.light']) && $this->data[$level . '.light']);
		$template->set_switch('field.' . $level . '.center', isset($this->data[$level . '.center']) && $this->data[$level . '.center']);
		$template->set_switch('field.' . $level . '.colspan', isset($this->data[$level . '.colspan']) && $this->data[$level . '.colspan']);
	}

	function display_options()
	{
	}

	function check()
	{
		global $user;
		global $error, $error_msg;

		// only fields sat for input
		if ( !(isset($this->data['output']) && $this->data['output']) )
		{
			// minimal length
			if ( !empty($this->data['length_mini']) && (strlen(trim($this->value)) < intval($this->data['length_mini'])) )
			{
				// check if empty allowed
				if ( !$this->data['empty_allowed'] || (strlen(trim($this->value)) > 0) )
				{
					// generate auto error messages
					if ( empty($this->data['length_mini_error']) )
					{
						_error( $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . (strlen(trim($this->value)) ? $user->lang('length_mini_error') : $user->lang('empty_error')));
					}
					// error messages granted
					else
					{
						_error( $this->data['length_mini_error']);
					}
				}
			}

			// maximal length
			if ( !empty($this->data['length_maxi']) && (strlen(trim($this->value)) > intval($this->data['length_maxi'])) )
			{
				_error( (empty($this->data['length_maxi_error']) ? $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('length_maxi_error') : $this->data['length_maxi_error']));
			}

			// minimal value
			if ( !empty($this->data['value_mini']) && ($this->value < $this->data['value_mini']) )
			{
				_error( (empty($this->data['value_mini_error']) ? $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('value_mini_error') : $this->data['value_mini_error']));
			}

			// maximal value
			if ( isset($this->data['value_maxi']) && strlen($this->data['value_maxi']) && ($this->value > $this->data['value_maxi']) )
			{
				_error( (empty($this->data['value_maxi_error']) ? $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('value_maxi_error') : $this->data['value_maxi_error']));
			}
		}
	}

	function validate()
	{
	}
}

//
// the "just a legend spaning form" fields
//

class field_title extends field
{
	function display()
	{
		global $template, $user;

		// set a new field
		$template->set_switch('field');
		$template->set_switch('field.row');

		// display legend
		$template->assign_block_vars('field.title', array(
			'LEGEND' => $user->lang($this->data['legend']),
		));
	}
}

class field_sub_title extends field
{
	function display()
	{
		global $template, $user;

		// set a new field
		$template->set_switch('field');
		$template->set_switch('field.row');

		// display legend
		$template->assign_block_vars('field.sub_title', array(
			'LEGEND' => $user->lang($this->data['legend']),
		));
	}
}

class field_comment extends field
{
	function init()
	{
		$this->data['output'] = true;
		if ( !isset($this->data['legend.align']) )
		{
			$this->data['legend.align'] = 'center';
		}
		parent::init();
		$this->type = 'comment';
	}

	function display()
	{
		global $db, $template, $user;

		// set a new field
		$template->set_switch('field');
		$template->set_switch('field.row');

		// display legend
		$template->assign_block_vars('field.comment', array(
			'LEGEND' => $user->lang($this->data['legend']),
			'SPAN_HTML' => !isset($this->data['span_html']) || empty($this->data['span_html']) ? '' : $this->data['span_html'],
		));
		$template->set_switch('field.comment.light', isset($this->data['legend.light']) && $this->data['legend.light']);
		$template->set_switch('field.comment.center', isset($this->data['legend.align']) && ($this->data['legend.align'] == 'center'));
	}
}

class field_comment_light extends field_comment
{
	function init()
	{
		$this->data['legend.light'] = true;
		$this->data['legend.align'] = 'left';
		parent::init();
	}
}

class field_mini_comment extends field
{
	function init()
	{
		$this->data['output'] = true;
		parent::init();
	}
}

//
// basic field list definition (and also drop down list)
//

class field_list extends field
{
	function get_value($value)
	{
		return _read($this->name, TYPE_NO_HTML, $value, $this->data['options'], isset($this->data['form_only']) ? intval($this->data['form_only']) : 0);
	}

	function get_displayed_value()
	{
		global $user;

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$value = (isset($this->data['options.no_translate']) && $this->data['options.no_translate']) ? $this->data['options'][$this->value] : $user->lang($this->data['options'][$this->value]);
		}
		else
		{
			$value = '';
			if ( !empty($this->data['options']) )
			{
				foreach ( $this->data['options'] as $val => $desc )
				{
					$selected = ($val == $this->value) ? ' selected="selected"' : '';
					$value .= '<option value="' . $val . '"' . $selected . '>' . ((isset($this->data['options.no_translate']) && $this->data['options.no_translate']) ? $desc : $user->lang($desc)) . '</option>';
				}
			}
		}
		return $value;
	}

	function check()
	{
		global $user;
		global $error, $error_msg;

		// standard check
		parent::check();

		// only fields sat for input
		if ( !(isset($this->data['output']) && $this->data['output']) )
		{
			if ( empty($this->data['options']) )
			{
				_error( (empty($this->data['options_empty_error']) ? $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('options_empty_error') : $this->data['options_empty_error']));
			}
			// list check
			$int_val = sprintf('%s', intval($this->value));
			$float_val = sprintf('%01.2f', doubleval($this->value));
			if ( !isset($this->data['options'][$this->value]) && !isset($this->data['options'][$int_val]) && !isset($this->data['options'][$float_val]) )
			{
				_error( (empty($this->data['options_error']) ? $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': '. $user->lang('options_error') : $this->data['options_error']));
			}
		}
	}
}

//
// let's start real fields
//

class field_varchar extends field
{
	function init()
	{
		parent::init();
		$this->type = 'varchar';
	}
}

class field_varchar_comment extends field
{
	function init()
	{
		parent::init();
		$this->data['output'] = true;
		$this->data['combined'] = true;
	}
}

class field_int extends field
{
	function get_value($value)
	{
		return _read($this->name, TYPE_INT, $value, '', isset($this->data['form_only']) ? intval($this->data['form_only']) : 0);
	}

	function get_displayed_value()
	{
		return intval($this->value);
	}
}

class field_text extends field
{
	function init()
	{
		parent::init();
	}

	function get_value($value)
	{
		return $this->encode(_read($this->name, TYPE_HTML, $this->decode($value), '', isset($this->data['form_only']) ? intval($this->data['form_only']) : 0));
	}
	function get_displayed_value()
	{
		return isset($this->data['output']) && $this->data['output'] ? $this->parse($this->value) : $this->form_escape_string($this->decode($this->value));
	}

	function encode($value)
	{
		return empty($value) ? '' : _htmlencode($value);
	}
	function decode($value)
	{
		return empty($value) ? '' : _htmldecode($value);
	}
	function parse($value)
	{
		return $value;
	}
}

class field_text_html extends field_text
{
	function init()
	{
		parent::init();
		$this->type = 'text';
	}

	function encode($value)
	{
		return $value;
	}
	function decode($value)
	{
		return $value;
	}
}

class field_password extends field
{
	function get_value($value)
	{
		return $this->encode(_read($this->name, TYPE_HTML, '', '', isset($this->data['form_only']) ? intval($this->data['form_only']) : 0));
	}
	function get_displayed_value()
	{
		return _button($this->name) ? $this->encode($this->value) : '';
	}
}

class field_url extends field
{
	function init()
	{
		parent::init();
		$this->type = 'varchar';
	}
	function check()
	{
		global $user;
		global $error, $error_msg;

		if ( (isset($this->data['output']) && $this->data['output']) || empty($this->value) )
		{
			return;
		}

		// external url
		if ( preg_match('#^(mailto\:|(news|(ht|f)tp(s?))\:\/\/)#i', $this->value) )
		{
			if ( !preg_match('#^(mailto\:|(news|(ht|f)tp(s?))\:\/\/)[a-z0-9\-_]+\.([a-z0-9\-_]+\.)?[a-z]+#i', $this->value) )
			{
				_error((empty($this->data['url_error']) ? $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('url_error') : $this->data['url_error']));
			}
		}
		else
		{
			if ( ($this->value != '#') && !preg_match('#^[a-z0-9\-\.\/_]+\.([a-z0-9\-_]+\.)?[a-z]+#i', $this->value) )
			{
				_error((empty($this->data['url_error']) ? $user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('url_error') : $this->data['url_error']));
			}
		}
	}
}

class field_internal_dir extends field_varchar
{
	function check()
	{
		global $error, $error_msg;
		global $config, $user;

		parent::check();
		if ( !$error && !(isset($this->data['output']) && $this->data['output']) )
		{
			// check the url
			if ( !is_dir($config->root . $this->value) )
			{
				_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Not_a_valid_directory'));
			}
		}
	}
}

class field_internal_script extends field_varchar
{
	function check()
	{
		global $error, $error_msg;
		global $config, $user;

		parent::check();

		// check the url
		if ( !$error && !empty($this->value) && !(isset($this->data['output']) && $this->data['output']) )
		{
			$file = (strrchr($this->value, '.') == '.js') ? $config->root . $this->value : $config->url($this->value);
			if ( !@file_exists($file) || @is_dir($file) || @is_link($file) )
			{
				_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Not_a_valid_script'));
			}
		}
	}
}

class field_image extends field
{
	function init()
	{
		parent::init();
		$this->data['output'] = true;
	}
}

class field_button extends field
{
}

class field_radio_list extends field_list
{
	function get_displayed_value()
	{
		global $user;
		return isset($this->data['output']) && $this->data['output'] ? $user->lang($this->data['options'][$this->value]) : '';
	}

	function display_options()
	{
		global $template, $user;
		if ( !empty($this->data['options']) )
		{
			foreach ( $this->data['options'] as $val => $desc )
			{
				$template->assign_block_vars('field.data.' . $this->type . '_input.option', array(
					'SELECTED' => ($val == $this->value) ? ' checked="checked"' : '',
					'VALUE' => $val,
					'DESC' => $user->lang($desc),
				));
				$template->set_switch('field.data.' . $this->type . '_input.option.linefeed', isset($this->data['options.linefeed']) && $this->data['options.linefeed']);
			}
		}
	}
}

class field_radio_list_comment extends field_radio_list
{
	function init()
	{
		parent::init();
		$this->data['combined'] = true;
	}
}

class field_checkbox_list extends field
{
	function init()
	{
		parent::init();
	}

	function display()
	{
		// display legend and value
		parent::display();

		// display value
		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$this->display_options();
		}
	}

	function get_value($value)
	{
		// something is displayed, search what
		if ( _button($this->name . '_dsp') )
		{
			$form_values = _read($this->name, '', '', '', isset($this->data['form_only']) ? intval($this->data['form_only']) : 0);
			$count_values = count($form_values);
			$value = array();
			for ( $i = 0; $i < $count_values; $i++ )
			{
				if ( isset($this->data['options'][ $form_values[$i] ]) )
				{
					$value[] = $form_values[$i];
				}
			}
		}
		else if ( empty($value) )
		{
			$value = array();
		}
		return $value;
	}

	function display_options()
	{
		global $template, $user;

		if ( !empty($this->data['options']) )
		{
			$in_out = isset($this->data['output']) && $this->data['output'] ? '_output' : '_input'; 
			foreach ( $this->data['options'] as $val => $desc )
			{
				if ( in_array($val, $this->value) || !(isset($this->data['output']) && $this->data['output']) )
				{
					$template->assign_block_vars('field.data.' . $this->type . $in_out . '.option', array(
						'SELECTED' => in_array($val, $this->value) ? ' checked="checked"' : '',
						'VALUE' => $val,
						'DESC' => $user->lang($desc),
					));
					$template->set_switch('field.data.' . $this->type . $in_out . '.option.linefeed', $this->data['options.linefeed']);
					$template->set_switch('field.data.' . $this->type . $in_out . '.option.selected', in_array($val, $this->value));
				}
			}
		}
	}
}

class field_mini_link extends field
{
	function init()
	{
		parent::init();
		$this->data['output'] = true;
	}
}

class field_date_unix extends field
{
	var $fields;
	var $order;

	function field_date_unix($name, $data)
	{
		global $config, $user;

		if ( !$data['output'] )
		{
			// declare the fields
			$this->order = _date_order($user->data['user_dateformat'], false);
			foreach ($this->order as $frag => $pos)
			{
				$others = array_flip(array('Y', 'M', 'D'));
				unset($others[strtoupper($frag)]);
				$others = array_keys($others);
				$sub_data = $data;
				$sub_data['combined'] = $pos ? true : (isset($sub_data['combined']) ? $sub_data['combined'] : false);
				$sub_data['type'] = 'list';
				$sub_data['legend'] = $pos ? '' : $data['legend'];
				$sub_data['explain'] = $pos || !isset($data['explain']) ? '' : $data['explain'];
				$sub_data['value'] = $this->get_orig_value($frag, $data);
				$sub_data['options'] = $this->get_list($frag, $data);
				$sub_data['html'] = ' onchange="if (this.options[selectedIndex].value <= 0) {this.form.' . $name . '_' . $others[0] . '.value = 0; this.form.' . $name . '_' . $others[1] . '.value = 0; };"';
				$sub_data['options.no_translate'] = ($frag == 'd');
				$this->fields[$frag] = new field_list($name . '_' . strtoupper($frag), $sub_data);
			}

			// add javascript links
			$hour = $data['options.end_date'] ? 23 : 0;
			$minute = $data['options.end_date'] ? 59 : 0;
			$second = $data['options.end_date'] ? 59 : 0;
			$now = $user->cvt_sys_to_user_date(time());
			$today = mktime($hour, $minute, $second, date('m', $now), date('d', $now), date('Y', $now));
			$one_week = mktime($hour, $minute, $second, date('m', $now), date('d', $now)+7, date('Y', $now));
			$one_month = mktime($hour, $minute, $second, date('m', $now)+1, date('d', $now), date('Y', $now));
			$fields = array(
				$name . '_today' => array('type' => 'mini_link', 'legend' => 'Today', 'value' => '#', 'combined' => true, 'linefeed' => true, 'post_value' => ' :: ', 'html' => ' onclick="document.post.' . $name . '_D.value = ' . date('d', $today) . '; document.post.' . $name . '_M.value = ' . date('m', $today) . '; document.post.' . $name . '_Y.value = ' . date('Y', $today) . '; return false;"'),
				$name . '_one_week' => array('type' => 'mini_link', 'legend' => '7_Days', 'value' => '#', 'combined' => true, 'post_value' => ' :: ', 'html' => ' onclick="document.post.' . $name . '_D.value = ' . date('d', $one_week) . '; document.post.' . $name . '_M.value = ' . date('m', $one_week) . '; document.post.' . $name . '_Y.value = ' . date('Y', $one_week) . '; return false;"'),
				$name . '_one_month' => array('type' => 'mini_link', 'legend' => '1_Month', 'value' => '#', 'combined' => true, 'html' => ' onclick="document.post.' . $name . '_D.value = ' . date('d', $one_month) . '; document.post.' . $name . '_M.value = ' . date('m', $one_month) . '; document.post.' . $name . '_Y.value = ' . date('Y', $one_month) . '; return false;"'),
			);
			foreach ( $fields as $field_name => $field )
			{
				$this->fields[$field_name] = new field_mini_link($field_name, $field);
			}
		}
		parent::field($name, $data);
	}

	function force_value($value)
	{
		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$this->value = $value;
		}
		else
		{
			$this->value = $value;
			$data = $this->data;
			$data['value'] = $this->value;
			foreach ($this->order as $frag => $pos)
			{
				$this->fields[$frag]->value = $this->get_orig_value($frag, $data);
			}
		}
	}

	function get_orig_value($frag, &$data)
	{
		$res = 0;
		$value = $data['value'];
		if ( $value < 0 )
		{
			return ($frag == 'm') ? -1 : 0;
		}
		if ( !empty($value) )
		{
			switch ( $frag )
			{
				case 'y':
					$res = intval(date('Y', $value));
					break;
				case 'm':
					$res = intval(date('m', $value));
					break;
				case 'd':
					$res = intval(date('d', $value));
					break;
			}
		}
		return $res;
	}

	function get_list($frag, &$data)
	{
		global $config;
		$list = array();
		switch ($frag)
		{
			case 'd':
				$list = array(0 => '--');
				for ( $i = 1; $i <= 31; $i++ )
				{
					$list[] = sprintf('%02d', $i);
				}
				break;
			case 'm':
				$list = empty($data['options.specials']) ? array(0 => '---------------') : $data['options.specials'];
				$list += array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
				break;
			case 'y':
				$floor_year = empty($data['options.floor']) ? 0 : date('Y', $data['options.floor']);
				if ( $floor_year < 1971 )
				{
					$floor_year = 1971;
				}
				$list = array(0 => '----');
				for ($i = $floor_year; $i < 2038; $i++ )
				{
					$list[$i] = $i;
				}
				break;
		}
		return $list;
	}

	function get_value($value)
	{
		global $user;

		// limit value
		if ( $value < 0 )
		{
			$value = -1;
		}

		// we retrieve there a user timestamp
		$year = $this->fields['y']->value;
		$month = $this->fields['m']->value;
		$day = $this->fields['d']->value;

		// check for special values and timestamp doable
		if ( $month < 0 )
		{
			$res = -1;
			$this->force_value($res);
			return $res;
		}
		if ( ($year <= 1971) || ($year > 2037) || ($month == 0) || ($day == 0) )
		{
			$res = 0;
			$this->force_value($res);
			return $res;
		}
		// get the date
		if ( $this->data['options.end_date'] )
		{
			$res = mktime(0, 0, 0, $month, $day + 1, $year) - 1;
		}
		else
		{
			$res = mktime(0, 0, 0, $month, $day, $year);
		}

		// apply the floor asked
		if ( !empty($this->data['options.floor']) && ($res < intval($this->data['options.floor'])) )
		{
			$res = $this->data['options.floor'];
			$this->force_value($res);
			return $res;
		}

		// return the date converted into a sys timestamp
		return $res;
	}

	function check()
	{
		global $error, $error_msg;
		global $user;

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			return;
		}

		// do basic checks
		foreach ($this->order as $frag => $pos)
		{
			$this->fields[$frag]->check();
		}
		if ( !$error )
		{
			// retrieve date field
			$year = $this->fields['y']->value;
			$month = $this->fields['m']->value;
			$day = $this->fields['d']->value;
			if ( $month < 0 )
			{
				$month = 0;
			}
			// date forever or never correct ?
			if ( ($year * $month * $day == 0) && ($year + $month + $day != 0) )
			{
				_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Date_not_valid'));
			}
			// check if it is a date
			else if ( !empty($year) && !checkdate($month, $day, $year) )
			{
				_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Date_not_valid'));
			}
		}
	}

	function display()
	{
		global $user;

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$this->type = 'varchar';
			$sav_value = $this->value;
			$this->value = $user->date($this->value);
			parent::display();
			$this->type = $this->data['type'];
			$this->value = $sav_value;
		}
		else
		{
			foreach ($this->fields as $field_name => $field)
			{
				$field->display();
			}
		}
	}
}

class field_timestamp extends field
{
	var $fields;
	var $order;
	var $h_fmt;

	// value is in user format
	function field_timestamp($name, $data)
	{
		global $config, $user;

		if ( !$data['output'] )
		{
			// declare the fields
			$this->order = _date_order($user->data['user_dateformat']);
			$this->h_fmt = _date_h_fmt($user->data['user_dateformat']);
			foreach ($this->order as $frag => $pos)
			{
				$others = array_flip(array('Y', 'M', 'D', 'H', 'I'));
				unset($others[strtoupper($frag)]);
				$others = array_keys($others);
				$sub_data = $data;
				$sub_data['combined'] = $pos ? true : $sub_data['combined'];
				$sub_data['type'] = 'list';
				$sub_data['legend'] = $pos ? '' : $data['legend'];
				$sub_data['explain'] = $pos ? '' : $data['explain'];
				$sub_data['value'] = $this->get_orig_value($frag, $data);
				$sub_data['options'] = $this->get_list($frag, $data);
				$sub_data['html'] = ' onchange="if (this.options[selectedIndex].value < ' . (in_array($frag, array('h', 'i')) ? '0' : '1') . ') {';
				for ( $i = 0; $i < 4; $i++ )
				{
					if ( in_array($others[$i], array('H', 'I')) )
					{
						$sub_data['html'] .= 'this.form.' . $name . '_' . $others[$i] . '.value = -1; ';
					}
					else
					{
						$sub_data['html'] .= 'this.form.' . $name . '_' . $others[$i] . '.value = 0; ';
					}
				}
				$sub_data['html'] .= '};"';
				$sub_data['options.no_translate'] = in_array(strtolower($frag), array('d', 'h', 'i'));
				$sub_data['post_value'] = ($pos == 2) ? '&nbsp;' : (($pos == 3) ? 'hh' : (($pos == 4) ? 'mm' : ''));
				$this->fields[$frag] = new field_list($name . '_' . strtoupper($frag), $sub_data);
			}

			// add javascript links
			$hour = $data['options.end_date'] ? 23 : 0;
			$minute = $data['options.end_date'] ? 59 : 0;
			$second = $data['options.end_date'] ? 59 : 0;
			$now = $user->cvt_sys_to_user_date(time());
			$today = mktime($hour, $minute, $second, date('m', $now), date('d', $now), date('Y', $now));
			$one_week = mktime($hour, $minute, $second, date('m', $now), date('d', $now)+7, date('Y', $now));
			$one_month = mktime($hour, $minute, $second, date('m', $now)+1, date('d', $now), date('Y', $now));
			$fields = array(
				$name . '_today' => array('type' => 'mini_link', 'legend' => 'Today', 'value' => '#', 'combined' => true, 'linefeed' => true, 'post_value' => ' :: ', 'html' => ' onclick="document.post.' . $name . '_D.value = ' . date('d', $today) . '; document.post.' . $name . '_M.value = ' . date('m', $today) . '; document.post.' . $name . '_Y.value = ' . date('Y', $today) . '; document.post.' . $name . '_H.value = ' . date('H', $today) . '; document.post.' . $name . '_I.value = ' . date('i', $today) . '; return false;"'),
				$name . '_one_week' => array('type' => 'mini_link', 'legend' => '7_Days', 'value' => '#', 'combined' => true, 'post_value' => ' :: ', 'html' => ' onclick="document.post.' . $name . '_D.value = ' . date('d', $one_week) . '; document.post.' . $name . '_M.value = ' . date('m', $one_week) . '; document.post.' . $name . '_Y.value = ' . date('Y', $one_week) . '; document.post.' . $name . '_H.value = ' . date('H', $one_week) . '; document.post.' . $name . '_I.value = ' . date('i', $one_week) . '; return false;"'),
				$name . '_one_month' => array('type' => 'mini_link', 'legend' => '1_Month', 'value' => '#', 'combined' => true, 'html' => ' onclick="document.post.' . $name . '_D.value = ' . date('d', $one_month) . '; document.post.' . $name . '_M.value = ' . date('m', $one_month) . '; document.post.' . $name . '_Y.value = ' . date('Y', $one_month) . '; document.post.' . $name . '_H.value = ' . date('H', $one_month) . '; document.post.' . $name . '_I.value = ' . date('i', $one_month) . '; return false;"'),
			);
			foreach ( $fields as $field_name => $field )
			{
				$this->fields[$field_name] = new field_mini_link($field_name, $field);
			}
		}
		parent::field($name, $data);
	}

	function force_value($value)
	{
		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$this->value = $value;
		}
		else
		{
			$this->value = $value;
			$data = $this->data;
			$data['value'] = $this->value;
			foreach ($this->order as $frag => $pos)
			{
				$this->fields[$frag]->value = $this->get_orig_value($frag, $data);
			}
		}
	}

	function get_orig_value($frag, &$data)
	{
		$res = 0;
		$value = $data['value'];
		if ( $value < 0 )
		{
			return in_array($frag, array('h', 'i')) ? -1 : 0;
		}
		if ( !empty($value) )
		{
			switch ( $frag )
			{
				case 'y':
					$res = intval(date('Y', $value));
					break;
				case 'm':
					$res = intval(date('m', $value));
					break;
				case 'd':
					$res = intval(date('d', $value));
					break;
				case 'h':
					$res = intval(date('H', $value));
					break;
				case 'i':
					$res = intval(date('i', $value));
					break;
			}
		}
		return $res;
	}

	function get_list($frag, &$data)
	{
		global $config;
		$list = array();
		switch ($frag)
		{
			case 'h':
				// take an arbitrary date
				$date = mktime(0, 0, 0, 01, 01, 2005);
				$list = array(-1 => '--');
				for ( $i = 0; $i <= 23; $i++ )
				{
					$list[$i] = date($this->h_fmt, $date);
					$date += 3600;
				}
				break;
			case 'i':
				$list = array(-1 => '--');
				for ( $i = 0; $i <= 59; $i++ )
				{
					$list[$i] = sprintf('%02d', $i);
				}
				break;
			case 'd':
				$list = array(0 => '--');
				for ( $i = 1; $i <= 31; $i++ )
				{
					$list[$i] = sprintf('%02d', $i);
				}
				break;
			case 'm':
				$list = empty($data['options.specials']) ? array(0 => '---------------') : $data['options.specials'];
				$list += array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
				break;
			case 'y':
				$floor_year = empty($data['options.floor']) ? 0 : date('Y', $data['options.floor']);
				if ( $floor_year < 1971 )
				{
					$floor_year = 1971;
				}
				$list = array(0 => '----');
				for ($i = $floor_year; $i < 2038; $i++ )
				{
					$list[$i] = $i;
				}
				break;
		}
		return $list;
	}

	function get_value($value)
	{
		global $user;

		// limit value
		if ( $value < 0 )
		{
			$value = -1;
		}

		// we retrieve there a user timestamp
		$year = $this->fields['y']->value;
		$month = $this->fields['m']->value;
		$day = $this->fields['d']->value;
		$hour = $this->fields['h']->value;
		$minute = $this->fields['i']->value;

		// check for special values and timestamp doable
		if ( $hour < 0 )
		{
			$hour = -1;
		}
		if ( $minute < 0 )
		{
			$minute = -1;
		}
		if ( ($year <= 1971) || ($year > 2037) || ($month == 0) || ($day == 0) )
		{
			$res = -1;
			$this->force_value($res);
			return $res;
		}
		// get the date converted into a sys timestamp
		if ( $this->data['options.end_date'] )
		{
			if ( ($hour < 0) || ($minute < 0) )
			{
				$res = mktime(0, 0, 0, $month, $day + 1, $year) - 1;
			}
			else
			{
				$res = mktime($hour, $minute, 59, $month, $day, $year);
			}
		}
		else
		{
			if ( ($hour < 0) || ($minute < 0) )
			{
				$res = mktime(0, 0, 0, $month, $day, $year);
			}
			else
			{
				$res = mktime($hour, $minute, 0, $month, $day, $year);
			}
		}

		// apply the floor asked
		if ( !empty($this->data['options.floor']) && ($res < intval($this->data['options.floor'])) )
		{
			$res = $this->data['options.floor'];
			$this->force_value($res);
			return $res;
		}

		return $res;
	}

	function check()
	{
		global $error, $error_msg;
		global $user;

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			return;
		}

		// do basic checks
		foreach ($this->order as $frag => $pos)
		{
			$this->fields[$frag]->check();
		}
		if ( !$error )
		{
			// retrieve date field
			$year = $this->fields['y']->value;
			$month = $this->fields['m']->value;
			$day = $this->fields['d']->value;
			$hour = $this->fields['h']->value;
			$minute = $this->fields['i']->value;
			if ( $hour < 0 )
			{
				$hour = 0;
			}
			if ( $minute < 0 )
			{
				$minute = 0;
			}

			// date forever or never correct ?
			if ( ($year * $month * $day == 0) && ($year + $month + $day != 0) )
			{
				_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Date_not_valid'));
			}
			// check if it is a date
			else if ( !empty($year) && (!checkdate($month, $day, $year) || ($hour < 0) || ($hour > 23) || ($minute < 0) || ($minute > 59)) )
			{
				_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Date_not_valid'));
			}
		}
	}

	function display()
	{
		global $user;

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$this->type = 'varchar';
			$sav_value = $this->value;
			$this->value = empty($this->value) ? 0 : $user->date($this->value);
			parent::display();
			$this->type = $this->data['type'];
			$this->value = $sav_value;
		}
		else
		{
			foreach ($this->fields as $field_name => $field)
			{
				$field->display();
			}
		}
	}
}

// signature panel
class field_bbcode extends field_text
{
	function init()
	{
		global $config;

		if ( empty($this->data['sub_fields']) )
		{
			$this->data['sub_fields'] = array();
		}
		if ( empty($this->data['sub_values']) )
		{
			$this->data['sub_values'] = array();
		}
		if ( !class_exists('message') )
		{
			include($config->url('includes/class_message'));
		}
		$message = new message();
		$cfg_values = $message->get_options();
		unset($message);
		foreach ( $cfg_values as $key => $value )
		{
			$this->data['sub_values'][$key] = isset($this->data['sub_values'][$key]) ? intval($this->data['sub_values'][$key]) && $value : $value;
		}
		parent::init();
		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$this->type = 'text';
		}
	}

	function get_value($value)
	{
		return $this->encode(_read('message', TYPE_HTML, $this->decode($value), '', isset($this->data['form_only']) ? intval($this->data['form_only']) : 0));
	}

	function decode($value)
	{
		global $config;

		// we remove bbcode_uid
		$value = trim($value);
		if ( !empty($value) && !empty($this->data['sub_values']['bbcode_uid']) )
		{
			if ( !function_exists('bbencode_decode') )
			{
				include($config->url('includes/bbcode'));
			}
			$value = bbencode_decode($value, $this->data['sub_values']['bbcode_uid']);
		}

		// we un-escape html entites
		return empty($value) ? '' : _html_entities_decode($value);
	}

	function encode($value)
	{
		global $config;

		// re-add the bbcode_uid & escape the not-wanted html entities
		if ( !empty($value) )
		{
			if ( !function_exists('make_bbcode_uid') )
			{
				include($config->url('includes/bbcode'));
			}
			if ( !function_exists('prepare_message') )
			{
				include($config->url('includes/functions_post'));
			}
			if ( empty($this->data['sub_values']['bbcode_uid']) )
			{
				$this->data['sub_values']['bbcode_uid'] = $this->data['sub_values']['bbcode'] ? make_bbcode_uid() : '';
			}
			$value = stripslashes(prepare_message(addslashes($value), $this->data['sub_values']['html'], $this->data['sub_values']['bbcode'], $this->data['sub_values']['smilies'], $this->data['sub_values']['bbcode_uid']));
		}
		return $value;
	}

	function parse($value)
	{
		global $config;

		if ( !empty($value) )
		{
			if ( !class_exists('message') )
			{
				include($config->url('includes/class_message'));
			}
			$message = new message();
			$message->parse($value, $this->data['sub_values']['bbcode_uid'], $this->data['sub_values']);
			unset($message);
		}
		return $value;
	}

	function check()
	{
		if ( isset($this->data['output']) && $this->data['output'] )
		{
			return;
		}

		// save current value for length check
		if ( $this->data['length_mini'] || $this->data['length_maxi'] )
		{
			$sav_value = $this->value;
			$this->value = $this->decode($this->value);
		}

		// check the field
		parent::check();

		// restore value
		if ( $this->data['length_mini'] || $this->data['length_maxi'] )
		{
			$this->value = $sav_value;
		}
	}

	function display()
	{
		global $template, $config, $user;

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			parent::display();
		}
		else
		{
			$this->build_form();

			// preview hit : let's build one so :)
			if ( _button('preview') )
			{
				$this->display_preview();
			}
			$this->send_form();
		}
	}

	function build_form()
	{
		global $template, $config, $user;

		// load apis
		if ( !function_exists('generate_smilies') )
		{
			include($config->url('includes/functions_post'));
		}
		if ( !function_exists('display_bbcodes') )
		{
			include($config->url('includes/bbcode'));
		}

		// some status
		$html_status = $config->data['allow_html'] ? $user->lang('HTML_is_ON') : $user->lang('HTML_is_OFF');
		$bbcode_status = $config->data['allow_bbcode'] ? $user->lang('BBCode_is_ON') : $user->lang('BBCode_is_OFF');
		$smilies_status = $config->data['allow_smilies'] ? $user->lang('Smilies_are_ON') : $user->lang('Smilies_are_OFF');

		// there would take place bottom options (use html, use bbcode, etc.)
		$template->set_switch('no_choices');
		if ( !empty($this->data['sub_fields']) )
		{
			foreach ( $this->data['sub_fields'] as $subfield_name => $database_subfield_name )
			{
			}
		}

		// Generate smilies listing for page output
		generate_smilies('inline', PAGE_POSTING);

		// send constants
		$template->assign_vars(array(
			'MESSAGE' => $this->get_displayed_value(),
			'HTML_STATUS' => $html_status,
			'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . $config->url('faq' , array('mode' => 'bbcode'), true) . '" target="_phpbbcode">', '</a>'),
			'SMILIES_STATUS' => $smilies_status,

			'L_MESSAGE_BODY' => $user->lang($this->data['legend']),
			'L_OPTIONS' => $user->lang('Options'),
		));
		$template->set_switch('free_size');

		// display bbcodes
		display_bbcodes();
	}

	function display_preview()
	{
	}

	function send_form()
	{
		global $template, $config, $user;

		// and finaly send the input form
		$template->set_switch('field');
		$template->set_switch('field.data');
		$template->assign_block_vars('field.data.include', array('TPL' => $template->include_file('posting_body.tpl')));
		$template->assign_block_vars('main_include', array('TPL' => $template->include_file('posting_bbcode.tpl')));

		// add the preview button
		$buttons = array(
			'preview' => array('txt' => 'Preview', 'img' => 'cmd_preview', 'key' => 'cmd_preview'),
		);
		display_buttons($buttons);
	}
}

class field_topic_id extends field_int
{
	function init()
	{
		parent::init();
		$this->type = 'int';
	}

	function check()
	{
		global $error, $error_msg;
		global $db;

		parent::check();

		// check the topic id
		if ( !$error && !empty($this->value) && !(isset($this->data['output']) && $this->data['output']) )
		{
			$sql = 'SELECT topic_id
						FROM ' . TOPICS_TABLE . '
						WHERE topic_id = ' . intval($this->value) . '
							AND topic_moved_id = 0';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$exists = $db->sql_numrows($result);
			$db->sql_freeresult($result);
			if ( !$exists )
			{
				_error('Topic_post_not_exist');
			}
		}
	}
}

class field_file extends field
{
	function field_values()
	{
		global $user, $config;

		// assume avatar file size is the reference
		return parent::field_values() + array(
			'MAX_FILE_SIZE' => empty($this->data['max_file_size']) ? $config->data['avatar_filesize'] : $this->data['max_file_size'],
		);
	}
}

?>