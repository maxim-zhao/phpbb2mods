<?php
//
//	file: admin/admin_cp.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.3 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
define('IN_CP_ADMIN', true);

$file = basename(__FILE__);
if( !empty($setmodules) )
{
	$module['030_Control_panels']['10_cp_Management'] = $file;
	return;
}

// Let's set the root dir for phpBB
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_cp';
require('./pagestart.' . $phpEx);

include($config->url('includes/class_form'));
include($config->url('includes/class_cp'));
include($config->url('includes/class_tree_admin'));

define('NAV_SEPARATOR', '&raquo;');
define('DEFAULT_AUTH', 'm.access');

$list_table_action = array(
	'open' => 'Table_open',
	'close' => 'Table_close',
);

// standard fields attributes
$list_attr_standard = array(
	'class_file' => array('type' => 'internal_script', 'legend' => 'Field_class_file', 'explain' => 'Field_class_file_explain'),
	'type' => array('req' => true, 'type' => 'varchar', 'legend' => 'Field_type', 'explain' => 'Field_type_explain', 'length_mini' => '2', 'length_maxi' => 50, 'length' => 25),
	'output' => array('type' => 'radio_list', 'legend' => 'Field_output', 'options' => $list_no_yes),
	'form_only' => array('type' => 'radio_list', 'legend' => 'Field_form_only', 'explain' => 'Field_form_only_explain', 'options' => $list_no_yes),
	'hidden' => array('type' => 'radio_list', 'legend' => 'Field_hidden', 'options' => $list_no_yes),
	'legend' => array('type' => 'varchar', 'legend' => 'Field_legend', 'explain' => 'Field_legend_explain'),
	'explain' => array('type' => 'varchar', 'legend' => 'Field_explain', 'explain' => 'Field_explain_explain'),
	'value' => array('type' => 'varchar', 'legend' => 'Field_value'),
	'value_mini' => array('type' => 'varchar', 'legend' => 'Field_value_mini'),
	'value_mini_error' => array('type' => 'varchar', 'legend' => 'Field_value_mini_error'),
	'value_maxi' => array('type' => 'varchar', 'legend' => 'Field_value_maxi'),
	'value_maxi_error' => array('type' => 'varchar', 'legend' => 'Field_value_maxi_error'),
	'url_error' => array('type' => 'varchar', 'legend' => 'Field_url_error'),
	'length' => array('type' => 'varchar', 'legend' => 'Field_length'),
	'length_mini' => array('type' => 'varchar', 'legend' => 'Field_length_mini'),
	'empty_allowed' => array('type' => 'radio_list', 'legend' => 'Field_empty_allowed', 'options' => $list_no_yes),
	'length_mini_error' => array('type' => 'varchar', 'legend' => 'Field_length_mini_error'),
	'length_maxi' => array('type' => 'varchar', 'legend' => 'Field_length_maxi'),
	'length_maxi_error' => array('type' => 'varchar', 'legend' => 'Field_length_maxi_error'),
	'post_value' => array('type' => 'varchar', 'legend' => 'Field_post_value'),
	'config_over' => array('type' => 'varchar', 'legend' => 'Field_config_over'),
	'image' => array('type' => 'varchar', 'legend' => 'Field_image', 'explain' => 'Field_image_explain'),
	'title' => array('type' => 'varchar', 'legend' => 'Field_title', 'explain' => 'Field_title_explain'),
	'link' => array('type' => 'url', 'legend' => 'Field_link'),
	'html' => array('type' => 'text_html', 'legend' => 'Field_html', 'explain' => 'Field_html_explain'),
	'field' => array('type' => 'varchar', 'legend' => 'Field_table_field', 'explain' => 'Field_table_field_explain'),
	'combined' => array('type' => 'radio_list', 'legend' => 'Field_combined', 'options' => $list_no_yes),
	'linefeed' => array('type' => 'radio_list', 'legend' => 'Field_linefeed', 'options' => $list_no_yes),
	'over' => array('type' => 'radio_list', 'legend' => 'Field_over', 'options' => $list_no_yes),
	'over.center' => array('type' => 'radio_list', 'legend' => 'Field_over_center', 'options' => $list_no_yes),
	'width' => array('type' => 'varchar', 'legend' => 'Field_width'),
	'options' => array('type' => 'text', 'legend' => 'Field_options'),
	'options.linefeed' => array('type' => 'radio_list', 'legend' => 'Field_options_linefeed', 'options' => $list_no_yes),
	'options.no_translate' => array('type' => 'radio_list', 'legend' => 'Field_options_no_translate', 'options' => $list_no_yes),
	'options_empty_error' => array('type' => 'varchar', 'legend' => 'Field_options_empty_error'),
	'options_error' => array('type' => 'varchar', 'legend' => 'Field_options_error'),
	'padding' => array('type' => 'int', 'legend' => 'Field_padding'),
	'class' => array('type' => 'varchar', 'legend' => 'Field_class'),
	'action' => array('type' => 'list', 'legend' => 'Field_action', 'options' => $list_table_action),
	'new_row' => array('type' => 'radio_list', 'legend' => 'Field_new_row', 'options' => $list_no_yes),
	'new_column' => array('type' => 'radio_list', 'legend' => 'Field_new_column', 'options' => $list_no_yes),
);

// standard field type
$list_field_type = array(
	'varchar' => array('legend', 'explain', 'value', 'field'),
	'varchar_comment' => array('legend', 'explain', 'value'),
	'int' => array('legend', 'explain', 'value','field'),
	'text' => array('legend', 'explain', 'value', 'field'),
	'text_html' => array('legend', 'explain', 'value', 'field'),
	'list' => array('legend', 'explain', 'options', 'value', 'field'),
	'radio_list' => array('legend', 'explain', 'options', 'options.linefeed', 'value', 'field'),
	'radio_list_comment' => array('legend', 'explain', 'options', 'options.linefeed', 'value', 'field'),
	'checkbox_list' => array('legend', 'explain', 'options', 'options.linefeed', 'value', 'field'),
	'table' => array('action', 'class', 'width', 'padding', 'action', 'new_row', 'new_column'),
	'title' => array('legend'),
	'sub_title' => array('legend'),
	'comment' => array('legend'),
	'comment_light' => array('legend'),
	'url' => array('legend', 'explain', 'value'),
	'internal_dir' => array('legend', 'explain', 'value', 'field'),
	'internal_script' => array('legend', 'explain', 'value', 'field'),
	'image' => array('legend', 'explain', 'image', 'field'),
	'button' => array('legend', 'explain', 'value', 'image'),
	'mini_link' => array('legend', 'explain', 'value'),
	'date_unix' => array('legend', 'explain', 'value'),
	'timestamp' => array('legend', 'explain', 'value', 'field'),
);

// macro fields
$list_macro_fields = array(
	'Field_macro_switch_no_yes' => array('type' => 'radio_list', 'legend' => '', 'options' => '[var]list_no_yes', 'field' => ''),
	'Field_macro_overwrite_choice' => array('type' => 'radio_list_comment', 'legend' => 'Override_user_choice', 'options' => '[var]list_no_yes', 'field' => '???_over', 'linefeed' => true),
	'Field_macro_list_auto_valid' => array('type' => 'list', 'options' => '[func][includes/?cp/?cp_???]???', 'legend' => '', 'field' => '', 'html' => ' onchange="if (this.options[this.SelectedIndex].value > 0) {this.form.submit();}"'),
	'Field_macro_user_text' => array('type' => 'text', 'legend' => '', 'explain' => '', 'field' => 'user_???'),
	'Field_macro_req_value' => array('type' => 'varchar', 'legend' => '', 'explain' => '', 'field' => '', 'length_mini' => 1),
);

// return the list of auths available for panels
function get_auth_list()
{
	global $db, $user;

	$auth_types = array(
		POST_PANELS_URL => 'Panel_auth_type',
		POST_GROUPS_URL => 'Group_auth_type',
	);

	$sql = 'SELECT auth_type, auth_name, auth_desc
				FROM ' . AUTHS_DEF_TABLE . '
				WHERE auth_title = 0
					AND auth_type IN (\'' . implode('\', \'', array_keys($auth_types)) . '\')
				ORDER BY auth_type, auth_order';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$last_type = '';
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['auth_type'] != $last_type )
		{
			$last_type = $row['auth_type'];
			$res[ $row['auth_type'] ] = '__________' . $user->lang($auth_types[ $row['auth_type'] ]) . '__________';
		}
		$res[ $row['auth_type'] . '.' . $row['auth_name'] ] = '[' . $row['auth_type'] . '::' . $row['auth_name'] . '] ' . $user->lang(empty($row['auth_desc']) ? $row['auth_name'] : $row['auth_desc']);
	}
	$db->sql_freeresult($result);
	return $res;
}

//
// panels tree
//
class cp_panels_admin extends cp_panels
{
	var $requester;
	var $parms;

	var $mode;
	var $panel_id;

	var $admin;

	function cp_panels_admin($requester, $parms=array())
	{
		parent::cp_panels($requester);
		$this->requester = $requester;
		$this->parms = $parms;
		$this->admin = '';

		$this->mode = '';
		$this->panel_id = 0;
	}

	function process(&$mode, $panel_id=0)
	{
		if ( $this->init($mode, intval($panel_id)) )
		{
			$this->check();
			$this->validate();
			$this->display();
			$mode = '';
			return true;
		}
		return false;
	}

	function init($mode, $panel_id)
	{
		if ( !in_array($mode, array('moveup', 'movedw', '')) || !isset($this->data[$panel_id]) )
		{
			return false;
		}

		// all is ok, we handle the action
		$this->mode = $mode;
		$this->panel_id = $panel_id;

		return true;
	}

	function check()
	{
	}

	function validate()
	{
		if ( in_array($this->mode, array('moveup', 'movedw')) )
		{
			$this->move($this->panel_id, $this->mode);
			$this->panel_id = 0;
			$this->mode = '';
			$this->read(true);
		}
	}

	function display()
	{
		global $db, $config, $template, $user;

		// get panels having a form
		$sql = 'SELECT DISTINCT panel_id
					FROM ' . CP_FIELDS_TABLE . '
					WHERE panel_id <> 0';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$forms = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$forms[ intval($row['panel_id']) ] = true;
		}
		$db->sql_freeresult($result);

		// buttons
		$row_buttons = array(
			'moveup' => array('txt' => 'Move_up', 'img' => 'cmd_up_arrow'),
			'edit' => array('txt' => 'Edit', 'img' => 'cmd_mini_edit'),
			'create' => array('txt' => 'Create_panel', 'img' => 'cmd_mini_create'),
			'delete' => array('txt' => 'Delete', 'img' => 'cmd_mini_delete'),
			'map' => array('txt' => 'Form_management', 'img' => 'cmd_mini_form'),
			'movedw' => array('txt' => 'Move_down', 'img' => 'cmd_down_arrow'),
		);
		$row_status = array(
			'hidden' => array('field' => 'panel_hidden'),
			'auth' => array('field' => 'panel_auth_name'),
			'script' => array('field' => 'panel_file'),
			'form' => array('field' => 'panel_form'),
		);

		// get panel tree
		$front_pic = $this->get_front_pic();
		$color = false;
		foreach ( $front_pic as $panel_id => $front )
		{
			$color = !$color;
			if ( $panel_id >= 0 )
			{
				$this->data[$panel_id]['panel_form'] = isset($forms[$panel_id]);
				if ( empty($this->data[$panel_id]['panel_auth_type']) || empty($this->data[$panel_id]['panel_auth_name']) )
				{
					$this->data[$panel_id]['panel_auth_type'] = substr(DEFAULT_AUTH, 0, 1);
					$this->data[$panel_id]['panel_auth_name'] = substr(DEFAULT_AUTH, 2);
				}
				$panel_auth = empty($panel_id) ? '' : $user->lang('Permission') . ': ' . "\n" .$this->data[$panel_id]['panel_auth_type'] . ' :: ' . $this->data[$panel_id]['panel_auth_name'];
				$panel_file = empty($this->data[$panel_id]['panel_file']) ? '' : $user->lang('Panel_file') . ': ' . "\n" .$this->data[$panel_id]['panel_file'];
				$template->assign_block_vars('row', array(
					'PANEL_SHORTCUT' => $this->data[$panel_id]['panel_shortcut'],
					'PANEL_NAME' => $user->lang($this->data[$panel_id]['panel_name']),
					'PANEL_FILE' => $panel_file,
					'PANEL_AUTH' => $panel_auth,
					'PANEL_HIDDEN' => $this->data[$panel_id]['panel_hidden'] ? $user->lang('Panel_hidden') : '',
					'U_FORM_MNG' => $config->url($this->requester, $this->parms + array('mode' => 'map', POST_PANELS_URL => $panel_id), true),
					'U_PREVIEW' => $config->url($this->requester, $this->parms + array('mode' => 'preview', POST_PANELS_URL => $panel_id), true),
					'U_EDIT' => $config->url($this->requester, $this->parms + array('mode' => 'edit', POST_PANELS_URL => $panel_id), true),
				));

				// deals with actions
				$row_actions = empty($panel_id) ? array('create' => $row_buttons['create']) : $row_buttons;
				foreach ( $row_actions as $action_mode => $action_def )
				{
					$template->assign_block_vars('row.button', array(
						'U_BUTTON' => $config->url($this->requester, $this->parms + array('mode' => $action_mode, POST_PANELS_URL => $panel_id), true),
						'L_BUTTON' => $user->lang($action_def['txt']),
						'I_BUTTON' => $user->img($action_def['img']),
					));
				}

				// deals with status
				if ( $panel_id > 0 )
				{
					// status
					foreach ( $row_status as $status => $status_def )
					{
						$template->set_switch('row.' . $status, !empty($panel_id) && !empty($this->data[$panel_id][ $status_def['field'] ]));
						if ( $status == 'form' )
						{
							switch ( $this->data[$panel_id]['panel_auth_type'] )
							{
								case POST_GROUPS_URL:
									$template->set_switch('row.auth_group');
									break;
								case '':
									break;
								default:
									$template->set_switch('row.auth_other');
									break;
							}
						}
					}

					// add preview
					$template->set_switch('row.preview', empty($this->data[$panel_id]['panel_main']));
				}
			}
			else
			{
				$template->set_switch('row');
			}
			$template->set_switch('row.light', $color);
			$template->set_switch('row.root', empty($panel_id));

			// tree
			$count_front = strlen($front);
			for ( $i = 0; $i < $count_front; $i++ )
			{
				$template->assign_block_vars('row.inc', array(
					'L_INC' => $user->lang('tree_pic_' . $front[$i]),
					'I_INC' => $user->img('tree_pic_' . $front[$i]),
				));
			}
		}

		// headers
		$template->assign_vars(array(
			'L_PANELS' => $user->lang('Panels'),
			'L_INFO' => $user->lang('Information'),
			'L_ACTION' => $user->lang('Action'),
			'L_FORM' => $user->lang('Fields'),
			'I_FORM' => $user->img('sts_form'),
			'L_SCRIPT' => $user->lang('Panel_file'),
			'I_SCRIPT' => $user->img('sts_script'),
			'L_GROUP' => $user->lang('Group'),
			'I_GROUP' => $user->img('sts_group'),
			'L_OTHER' => $user->lang('Other'),
			'I_OTHER' => $user->img('sts_permission'),
			'L_HIDDEN' => $user->lang('Panel_hidden'),
			'I_HIDDEN' => $user->img('sts_hidden'),

			'L_FORM_MNG' => $user->lang('Form_management'),
			'I_FORM_MNG' => $user->img('cmd_mini_form'),
			'L_PREVIEW' => $user->lang('Preview_menu'),
			'I_PREVIEW' => $user->img('cmd_details'),
		));
		display_buttons(array(
			'create' => array('txt' => 'Create_panel', 'img' => 'cmd_create', 'key' => 'cmd_create', 'url' => $this->requester, 'parms' => $this->parms + array('mode' => 'create')),
		));
		$template->set_filenames(array('body' => 'admin/cp_index_body.tpl'));
	}

	// used for move, update and delete
	function move($_id, $after_id, $delete_root=false, $delete_branch=false, $new_main_id=0)
	{
		global $user, $config;
		global $error, $error_msg;

		if ( ($after_id === 'moveup') || ($after_id === 'movedw') )
		{
			$mode = $after_id;
			switch ( $mode )
			{
				case 'moveup':
					$after_id = $this->admin->neighbor_id($_id, PREVIOUS_ITEM, false);
					if ( $after_id != intval($this->data[$_id]['panel_main']) )
					{
						$after_id = $this->admin->neighbor_id($after_id, PREVIOUS_ITEM, true);
					}
					break;
				case 'movedw':
					$after_id = $this->admin->neighbor_id($_id, NEXT_ITEM, true);
					break;
				default:
					$after_id = $_id;
					break;
			}
		}
		else
		{
			$after_id = intval($after_id);
		}

		// check authorisation
		if ( !$error && ($_id != $after_id) && !$user->auth(POST_PANELS_URL, 'auth_manage', $_id) )
		{
			_error('Not_Authorised');
		}

		// send messages
		if ( $error )
		{
			message_return($error_msg, 'Click_return_cp', $config->url($this->requester, $this->parms, true));
		}
		return $this->admin->move($_id, $after_id, $delete_root, $delete_branch, $new_main_id);
	}
}

//
// panels details
//
class cp_panels_details
{
	var $requester;
	var $parms;
	var $mode;
	var $panel_id;

	function cp_panels_details($requester, $parms='')
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->mode = '';
		$this->panel_id = 0;
	}

	function process($mode='', $panel_id=0)
	{
		if ( $this->init($mode, $panel_id) )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init($mode, $panel_id)
	{
		global $cp_panels;

		if ( !in_array($mode, array('create', 'edit', 'delete')) || !isset($cp_panels->data[$panel_id]) )
		{
			return false;
		}

		$this->mode = $mode;
		$this->panel_id = $panel_id;
		return true;
	}

	function check()
	{
		global $config, $user;
		global $error, $error_msg;

		if ( !$error && empty($this->panel_id) && ($this->mode != 'create') )
		{
			_error('Panel_root_edit_deny');
		}

		// verify ability to edit panel
		if ( !$error && !$user->auth(POST_PANELS_URL, 'auth_manage', $this->panel_id) )
		{
			_error('Not_Authorised');
		}

		if ( $error )
		{
			message_return($error_msg, 'Click_return_cp', $config->url($this->requester, $this->parms, true));
		}
	}

	function validate()
	{
	}

	function display()
	{
		global $config, $user, $template, $modes_allowed;

		// form
		$cp_details_form = new cp_panels_details_form($this->requester, $this->parms, $this->mode, $this->panel_id);
		$cp_details_form->set_buttons(array(
			'submit_form' => array('txt' => ($this->mode == 'delete') ? 'Delete' : 'Submit', 'img' => ($this->mode == 'delete') ? 'cmd_delete' : 'cmd_submit', 'key' => ($this->mode == 'delete') ? 'cmd_delete' : 'cmd_submit'),
			'cancel_form' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		));
		$cp_details_form->process();
		$template->assign_vars(array(
			'L_FORM' => $user->lang($modes_allowed[$this->mode]['title']),
		));
		$template->set_filenames(array('body' => 'form_body.tpl'));
		_hide('mode', $this->mode);
		_hide(POST_PANELS_URL, $this->panel_id);
	}
}

class cp_panels_details_form extends form
{
	var $requester;
	var $parms;
	var $mode;
	var $panel_id;

	function cp_panels_details_form($requester, $parms='', $mode='', $panel_id=0)
	{
		global $config, $user, $cp_panels;
		global $list_no_yes;

		// parms
		$this->requester = $requester;
		$this->parms = $parms;
		$this->mode = $mode;
		$this->panel_id = intval($panel_id);

		// form definition
		$fields = array(
			'panel_shortcut' => array('type' => 'varchar', 'legend' => 'Panel_shortcut', 'explain' => 'Panel_shortcut_explain', 'field' => 'panel_shortcut', 'length_mini' => 3),
			'panel_name' => array('type' => 'varchar', 'legend' => 'Panel_name', 'field' => 'panel_name', 'length_mini' => 3),
			'panel_main' => array('type' => 'list', 'legend' => 'Panel_main', 'field' => 'panel_main', 'html' => ' onchange="this.form.submit();"'),
			'panel_order' => array('type' => 'list', 'legend' => 'Panel_order', 'field' => 'panel_order'),
			'panel_file' => array('type' => 'internal_script', 'legend' => 'Panel_file', 'explain' => 'Panel_file_explain', 'field' => 'panel_file'),
			'panel_hidden' => array('type' => 'radio_list', 'legend' => 'Panel_hidden', 'options' => $list_no_yes, 'field' => 'panel_hidden'),
			'panel_auth' => array('type' => 'list', 'legend' => 'Panel_auth', 'explain' => 'Panel_auth_explain', 'options' => get_auth_list()),
		);

		// get values from table
		if ( $this->mode == 'create' )
		{
			$previous = (empty($this->panel_id) || empty($cp_panels->data[$this->panel_id]['subs']) ) ? $this->panel_id : $cp_panels->data[$this->panel_id]['subs'][ (count($cp_panels->data[$this->panel_id]['subs']) - 1) ];
			$data = array('panel_main' => $this->panel_id, 'panel_order' => $previous);
		}
		else
		{
			$data = $cp_panels->data[$this->panel_id];
			$data['panel_order'] = $cp_panels->admin->neighbor_id($this->panel_id, PREVIOUS_ITEM, true);
		}

		// prepare form
		foreach ($fields as $field_name => $field )
		{
			if ( ($this->mode == 'delete') || ($this->mode == 'preview') )
			{
				$fields[$field_name]['output'] = true;
				if ( isset($fields[$field_name]['explain']) )
				{
					unset($fields[$field_name]['explain']);
				}
				if ( isset($fields[$field_name]['length_mini']) )
				{
					unset($fields[$field_name]['length_mini']);
				}
			}
			if ( isset($fields[$field_name]['field']) )
			{
				$fields[$field_name]['value'] = $data[ $fields[$field_name]['field'] ];
			}
		}

		// get parent field
		switch ( $this->mode )
		{
			case 'create':
				$fields['panel_main']['options'] = $cp_panels->admin->get_list($cp_panels->get_front_pic('all'));
				break;

			case 'edit':
				$fields['panel_main']['options'] = $cp_panels->admin->get_list($cp_panels->get_front_pic('except', $this->panel_id));
				break;

			case 'delete':
			case 'preview':
				if ( isset($fields['panel_order']) )
				{
					unset($fields['panel_order']);
				}
				$nav = '';
				$cur_id = $this->panel_id;
				while ( $cur_id > 0 )
				{
					$cur_id = intval($cp_panels->data[$cur_id]['panel_main']);
					$nav = $user->lang($cp_panels->data[$cur_id]['panel_name']) . (empty($nav) ? '' : '&nbsp;' . NAV_SEPARATOR . '&nbsp;') . $nav;
				}
				$fields['panel_main'] = array('type' => 'varchar', 'legend' => 'Panel_main', 'value' => $nav, 'output' => true);
				if ( $this->mode == 'delete' )
				{
					$fields['move_contents'] = array('type' => 'list', 'legend' => 'Panel_move_content', 'explain' => 'Panel_move_content_explain', 'value' => -1);
					$fields['move_contents']['options'] = array(-1 => 'Delete_all', -2 => '---------------') + $cp_panels->admin->get_list($cp_panels->get_front_pic('except', $this->panel_id));
				}
				break;

			default:
				break;
		}

		// get order list
		if ( isset($fields['panel_main']) && !$fields['panel_main']['output'] )
		{
			// we need to get the current panel_main, so read the form
			$panel_main = _read('panel_main', TYPE_INT, $fields['panel_main']['value'], $fields['panel_main']['options']);

			// get the sub-panels list of this panel_main
			$fields['panel_order']['options'] = $cp_panels->admin->get_list($cp_panels->get_front_pic('only', $panel_main, $this->panel_id));

			// creation or panel_main changed : get the last sub of this new main
			if ( ($this->mode == 'create') || ($cp_panels->data[$this->panel_id]['panel_main'] != $panel_main) )
			{
				if ( !empty($fields['panel_order']['options']) )
				{
					$tkeys = array_keys($fields['panel_order']['options']);
					$fields['panel_order']['value'] = $tkeys[ (count($tkeys)-1) ];
					unset($tkeys);
				}
			}

			// update or delete, panel_main unchanged
			else
			{
				$fields['panel_order']['value'] = $cp_panels->admin->neighbor_id($this->panel_id, PREVIOUS_ITEM, false);
			}
		}

		// get auth value
		$fields['panel_auth']['value'] = empty($data['panel_auth_type']) || empty($data['panel_auth_name']) ? DEFAULT_AUTH : $data['panel_auth_type'] . '.' . $data['panel_auth_name'];

		// ok now create the form
		parent::form($fields);
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
		return true;
	}

	function check()
	{
		global $db, $config, $user;
		global $error, $error_msg;
		global $warning, $warning_msg;

		if ( !_button('submit_form') || ($this->mode == 'preview') )
		{
			return;
		}

		// check the form
		parent::check();

		// check panel_auth value
		if ( !$error && (strlen($this->fields['panel_auth']->value) < 3) )
		{
			_error('Panel_auth_wrong');
		}

		// check target when delete
		if ( !$error && ($this->mode == 'delete') )
		{
			if ( $this->fields['move_contents']->value < -1 )
			{
				_error('Panel_empty_move_to');
			}
			else if ( $this->fields['move_contents']->value >= 0 )
			{
				// move to root denied when fields present
				if ( empty($this->fields['move_contents']->value) )
				{
					// check if there are topics
					$sql = 'SELECT *
								FROM ' . CP_FIELDS_TABLE . '
								WHERE panel_id = ' . $this->panel_id . '
								LIMIT 1';
					$result = $db->sql_query($sql, false, __LINE__, __FILE__);
					if ( $row = $db->sql_fetchrow($result) )
					{
						_error('Panel_not_empty');
					}
					$db->sql_freeresult($result);
				}

				// check auth regarding the target
				if ( !$error && !$user->auth(POST_PANELS_URL, 'auth_manage', $this->fields['move_contents']->value) )
				{
					_error('Not_Authorised');
				}
			}
		}

		// check parent
		if ( !$error && (($this->mode == 'create') || ($this->fields['panel_main']->value != $this->fields['panel_main']->data['value'])) && !$user->auth(POST_PANELS_URL, 'auth_manage', $this->fields['panel_main']->value) )
		{
			_error('Not_Authorised');
		}

		if ( $error )
		{
			message_return($error_msg, 'Click_return_cp', $config->url($this->requester, $this->parms, true));
		}
	}

	function validate()
	{
		global $db, $user, $config, $cp_panels;
		global $error, $error_msg;

		// if not submit, do nothing
		if ( !_button('submit_form') || $error || ($this->mode == 'preview') )
		{
			return;
		}

		// return default message
		$msg = 'Panel_updated';

		// get fields from display
		$fields = array();
		if ( $this->mode != 'delete' )
		{
			foreach ( $this->fields as $field_name => $field )
			{
				switch ( $field_name )
				{
					case 'panel_order':
						// if creation, affect a new panel order, else this branch will be move further
						if ( $this->mode == 'create' )
						{
							$fields[ $field->data['field'] ] = ($field->value == $this->fields['panel_main']->value) ? $cp_panels->data[ $this->fields['panel_main']->value ]['panel_order'] + 5 : $cp_panels->data[ $cp_panels->data[$field->value]['last_child_id'] ]['panel_order'] + 5;
						}
						break;

					case 'panel_auth':
						$fields['panel_auth_type'] = substr($field->value, 0, 1);
						$fields['panel_auth_name'] = substr($field->value, 2);
						break;

					default:
						if ( !$field->data['output'] && !empty($field->data['field']) )
						{
							$fields[ $field->data['field'] ] = $field->value;
						}
						break;
				}
			}
		}

		// create
		if ( $this->mode == 'create' )
		{
			// create the panel
			$db->sql_statement($fields);
			$sql = 'INSERT INTO ' . CP_PANELS_TABLE . '
						(' . $db->sql_fields . ') VALUES (' . $db->sql_values . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$this->panel_id = $db->sql_nextid();

			// get the auths from the groups having the manage auth onto the parent
			$sql = 'SELECT group_id, obj_type, auth_name, auth_value
						FROM ' . AUTHS_TABLE . '
						WHERE obj_type = \'' . POST_PANELS_URL . '\'
							AND obj_id = ' . intval($this->fields['panel_main']->value) . '
							AND group_id IN(' . $db->sql_subquery('group_id', '
								SELECT DISTINCT group_id
									FROM ' . AUTHS_TABLE . '
									WHERE obj_type = \'' . POST_PANELS_URL . '\'
										AND obj_id = ' . intval($this->fields['panel_main']->value) . '
										AND auth_name = \'auth_manage\'
								', __LINE__, __FILE__) . ')';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$db->sql_stack_reset();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$auth_fields = array(
					'group_id' => intval($row['group_id']),
					'obj_type' => $row['obj_type'],
					'obj_id' => intval($this->panel_id),
					'auth_name' => $row['auth_name'],
					'auth_value' => intval($row['auth_value']),
				);
				$db->sql_stack_statement($auth_fields);
			}
			$db->sql_freeresult($result);
			$db->sql_stack_insert(AUTHS_TABLE, false, __LINE__, __FILE__);

			// renum the panels table
			$cp_panels->renum();

			// return message
			$msg = 'Panel_created';
		}

		// edit
		if ( $this->mode == 'edit' )
		{
			// update the panel
			$db->sql_statement($fields);
			$sql = 'UPDATE ' . CP_PANELS_TABLE . '
						SET ' . $db->sql_update . '
						WHERE panel_id = ' . $this->panel_id;
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// move the branch to place
			if ( isset($this->fields['panel_order']) )
			{
				$after_id = ($this->fields['panel_order']->value == $this->fields['panel_main']->value) ? $this->fields['panel_main']->value : $cp_panels->data[ $this->fields['panel_order']->value ]['last_child_id'];
				$cp_panels->move($this->panel_id, $after_id, false, false, $this->fields['panel_main']->value);
			}

			// return message
			$msg = 'Panel_edited';
		}

		// delete
		if ( $this->mode == 'delete' )
		{
			// first renum without the deleted ones to get all panel ids to delete
			$delete_root = true;
			$delete_branch = ($this->fields['move_contents']->value == -1);
			$new_main_id = $delete_branch ? 0 : $this->fields['move_contents']->value;
			$after_id = $delete_branch ? 0 : (empty($cp_panels->data[$new_main_id]['subs']) ? $new_main_id : $cp_panels->data[$new_main_id]['subs'][ (count($cp_panels->data[$new_main_id]['subs'])-1) ]);
			$deleted_ids = $cp_panels->move($this->panel_id, $after_id, $delete_root, $delete_branch, $new_main_id);

			$count_deleted_ids = count($deleted_ids);
			if ( !empty($deleted_ids) )
			{
				// delete panels
				$sql_where = ($count_deleted_ids > 1) ? 'panel_id IN(' . implode(', ', $deleted_ids) . ')' : 'panel_id = ' . $deleted_ids[0];
				$sql = 'DELETE FROM ' . CP_PANELS_TABLE . '
							WHERE ' . $sql_where;
				$db->sql_query($sql, false, __LINE__, __FILE__);

				// delete auths
				$sql = 'DELETE FROM ' . AUTHS_TABLE . '
							WHERE obj_type = \'' . POST_PANELS_URL . '\'
								AND obj_id IN(' . implode(', ', $deleted_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);

				// delete fields
				if ( $delete_branch )
				{
					$sql = 'DELETE FROM ' . CP_FIELDS_TABLE . '
								WHERE ' . $sql_where;
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
				// move fields
				else
				{
					$sql = 'UPDATE ' . CP_FIELDS_TABLE . '
								SET panel_id = ' . $new_main_id . '
								WHERE panel_id = ' . $this->panel_id;
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
			}

			// return message
			$msg = 'Panel_deleted';
		}

		// all done : recache (including auths)
		$cp_panels->read(true);
		$now = $cp_panels->data_time;
		$config->begin_transaction();
		$config->set('cache_time_' . POST_PANELS_URL, $now);
		$config->set('cache_time_' . POST_GROUPS_URL, $now);
		$config->end_transaction();

		// send achievement message
		message_return($msg, 'Click_return_cp', $config->url($this->requester, $this->parms, true));
	}
}

//
// panels preview
//
class cp_panels_preview
{
	var $mode;
	var $panel_id;

	function cp_panels_preview($requester, $parms='')
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->mode = '';
		$this->panel_id = 0;
	}

	function process($mode='', $panel_id=0)
	{
		if ( $this->init($mode, $panel_id) )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init($mode, $panel_id)
	{
		global $cp_panels;

		if ( ($mode != 'preview') || !isset($cp_panels->data[$panel_id]) || empty($panel_id) )
		{
			return false;
		}

		$this->mode = $mode;
		$this->panel_id = $panel_id;
		return true;
	}

	function check()
	{
		global $config, $user;
		global $error, $error_msg;

		if ( !$error && empty($this->panel_id) )
		{
			_error('Not_a_control_panel');
		}

		if ( $error )
		{
			message_return($error_msg, 'Click_return_cp', $config->url($this->requester, $this->parms, true));
		}
	}

	function validate()
	{
	}

	function display()
	{
		global $template, $user, $config, $cp_panels;

		// form
		$cp_details_form = new cp_panels_details_form($this->requester, $this->parms, $this->mode, $this->panel_id);
		$buttons = array(
			'edit_form' => array('txt' => 'Edit', 'img' => 'cmd_edit', 'key' => 'cmd_edit'),
			'delete_form' => array('txt' => 'Delete', 'img' => 'cmd_delete', 'key' => 'cmd_delete'),
			'cancel_form' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
		if ( empty($this->panel_id) || !$user->auth(POST_PANELS_URL, 'auth_manage', $this->panel_id) )
		{
			unset($buttons['edit_form']);
			unset($buttons['delete_form']);
		}
		$cp_details_form->set_buttons($buttons);
		$cp_details_form->process();

		// add mode to parms
		$this->parms = array_merge($this->parms, array('mode' => $this->mode));

		// find the whole branch
		$branch_ids = array();

		// childs
		$cur_id = $this->panel_id;
		while ( !empty($cp_panels->data[$cur_id]['subs']) )
		{
			$cur_id = $cp_panels->data[$cur_id]['subs'][0];
		}

		// parent
		$main_id = $cur_id;
		$main_ids[] = $main_id;
		while ( intval($cp_panels->data[$main_id]['panel_main']) > 0 )
		{
			$main_id = intval($cp_panels->data[$main_id]['panel_main']);
			$main_ids[] = $main_id;
		}

		// now go through the main panel
		$count_mains = count($cp_panels->data[$main_id]['subs']);
		for ( $i = 0; $i < $count_mains; $i++ )
		{
			$cur_id = $cp_panels->data[$main_id]['subs'][$i];
			if ( !$cp_panels->data[$cur_id]['panel_hidden'] )
			{
				$template->assign_block_vars('option', array(
					'L_OPTION' => $user->lang($cp_panels->data[$cur_id]['panel_name']),
					'U_OPTION' => $config->url($this->requester, $this->parms + array(POST_PANELS_URL => $cur_id), true),
				));
				$template->set_switch('option.active', $display_subs = in_array($cur_id, $main_ids));
				if ( $display_subs )
				{
					$template->set_switch('option.active.linked', $cur_id != $this->panel_id);
					$empty = true;
					$count_subs = count($cp_panels->data[$cur_id]['subs']);
					for ( $j = 0; $j < $count_subs; $j++ )
					{
						$sub_id = $cp_panels->data[$cur_id]['subs'][$j];
						if ( !$cp_panels->data[$sub_id]['panel_hidden'] )
						{
							if ( $empty )
							{
								$template->set_switch('option.active.subs');
								$empty = false;
							}
							$template->assign_block_vars('option.active.sub', array(
								'L_OPTION' => $user->lang($cp_panels->data[$sub_id]['panel_name']),
								'U_OPTION' => $config->url($this->requester, $this->parms + array(POST_PANELS_URL => $sub_id), true),
							));
							$template->set_switch('option.active.sub.select', $sub_id == $this->panel_id);
						}
					}
				}
			}
		}

		// send to display
		$template->assign_vars(array(
			'L_MENU' => $user->lang($cp_panels->data[$main_id]['panel_shortcut']),
			'L_FORM' => $user->lang('Panel_definition'),
		));
		$template->set_switch('form');
		$template->set_filenames(array('body' => 'cp_generic.tpl'));
		$template->assign_block_vars('cp_menus', array('BOX' => $template->include_file('cp_menus_box.tpl')));
		_hide(POST_PANELS_URL, $this->panel_id);
	}
}

//
// map
//
class cp_maps
{
	var $data;
	var $keys;

	var $requester;
	var $parms;
	var $panel_id;
	var $field_id;

	function cp_maps($requester, $parms='', $panel_id)
	{
		$this->requester = $requester;
		$this->panel_id = $panel_id;
		$this->field_id = 0;
		$this->parms = empty($parms) ? array(POST_PANELS_URL => $this->panel_id) : array_merge($parms, array(POST_PANELS_URL => $this->panel_id));

		$this->data = array();
		$this->keys = array();
	}

	function read($force=true)
	{
		global $db;

		// get the fields list for this panel
		$sql = 'SELECT *
					FROM ' . CP_FIELDS_TABLE . '
					WHERE panel_id = ' . intval($this->panel_id) . '
					ORDER BY field_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->data = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$row['data'] = empty($row['field_attr']) ? array() : unserialize($row['field_attr']);
			if ( isset($row['field_attr']) )
			{
				unset($row['field_attr']);
			}
			$this->data[ intval($row['field_id']) ] = $row;
		}
		$db->sql_freeresult($result);
		$this->keys = empty($this->data) ? array() : array_keys($this->data);
	}

	function renum()
	{
		global $db;

		$last_order = 0;
		$this->read(true);
		if ( !empty($this->data) )
		{
			$last_order = 0;
			foreach ( $this->data as $field_id => $field )
			{
				if ( !empty($field_id) )
				{
					$last_order += 10;
					$this->data[$field_id]['field_order'] = $last_order;
					$sql = 'UPDATE ' . CP_FIELDS_TABLE . '
								SET field_order = ' . intval($this->data[$field_id]['field_order']) . '
								WHERE field_id = ' . intval($field_id);
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
			}
		}
	}

	function process($mode, $field_id)
	{
		if ( $this->init($mode, $field_id) )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init($mode, $field_id)
	{
		if ( !in_array($mode, array('map', 'map_create', 'map_delete', 'map_preview', 'map_movedw', 'map_moveup')) )
		{
			return false;
		}
		if ( !isset($this->data[$field_id]) )
		{
			$mode = 'map_create';
		}
		if ( $mode == 'map_create' )
		{
			$field_id = 0;
		}

		$this->mode = $mode;
		$this->field_id = $field_id;

		return true;
	}

	function check()
	{
		global $error, $error_msg;
		global $config, $user;

		// check auth
		if ( empty($this->panel_id) || !$user->auth(POST_PANELS_URL, 'auth_manage', $this->panel_id) )
		{
			_error('Not_Authorised');
		}

		if ( $error )
		{
			message_return($error_msg, 'Click_return_cp', $config->url($this->requester, $this->parms, true));
		}
	}

	function validate()
	{
		global $db;

		if ( in_array($this->mode, array('map_moveup', 'map_movedw')) )
		{
			$inc = $this->mode == 'map_moveup' ? ' - 15' : ' + 15';
			$sql = 'UPDATE ' . CP_FIELDS_TABLE . '
						SET field_order = field_order' . $inc . '
						WHERE field_id = ' . intval($this->field_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$this->renum();
			$this->mode = 'map';
		}
	}

	function display()
	{
		global $template, $user, $config;
		global $warning, $warning_msg;
		global $cp_panels;

		// form
		if ( $this->mode == 'map_preview' )
		{
			$cp_maps_preview = new cp_maps_preview($this->requester, $this->parms);
			$cp_maps_preview->set_buttons(array(
				'preview_map_cancel' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
			));
			$cp_maps_preview->process($this->mode, $this->panel_id);
		}
		else
		{
			$cp_maps_details = new cp_maps_details($this->requester, $this->parms);
			if ( $this->mode == 'map_delete' )
			{
				$cp_maps_details->set_buttons(array(
					'submit_map' => array('txt' => 'Delete_field', 'img' => 'cmd_delete', 'key' => 'cmd_delete'),
					'delete_map_cancel' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
				));
			}
			else if ( $this->mode == 'map_create' )
			{
				$cp_maps_details->set_buttons(array(
					'submit_map' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
					'cancel_map' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
				));
			}
			else
			{
				$cp_maps_details->set_buttons(array(
					'submit_map' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
					'delete_map' => array('txt' => 'Delete_field', 'img' => 'cmd_delete', 'key' => 'cmd_delete'),
					'cancel_map' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
				));
			}
			$cp_maps_details->process($this->mode, $this->field_id);
		}

		// left panel
		if ( !empty($this->data) )
		{
			$color = false;
			foreach ( $this->data as $field_id => $field_data )
			{
				$color = !$color;
				$template->assign_block_vars('row', array(
					'FIELD_NAME' => $field_data['field_name'],
					'U_FIELD' => $config->url($this->requester, $this->parms + array('mode' => 'map', POST_FIELDS_URL => $field_id), true),
				));
				$template->set_switch('row.light', $color);
				$template->set_switch('row.active', ($this->mode != 'map_preview') && ($field_id == $this->field_id));
			}
		}

		// left panel buttons
		switch ( $this->mode )
		{
			case 'map_preview':
				$buttons = array(
					'create_map' => array('txt' => 'Create_field', 'img' => 'cmd_create', 'key' => 'cmd_create'),
					'preview_map_cancel' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
				);
				break;

			case 'map_delete':
				$buttons = array(
					'create_map' => array('txt' => 'Create_field', 'img' => 'cmd_create', 'key' => 'cmd_create'),
					'delete_map_cancel' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
				);
				break;

			default:
				$buttons = array(
					'moveup_map' => array('txt' => 'Move_up', 'img' => 'cmd_up_arrow', 'key' => 'cmd_up'),
					'create_map' => array('txt' => 'Create_field', 'img' => 'cmd_create', 'key' => 'cmd_create'),
					'cancel_map' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
					'movedw_map' => array('txt' => 'Move_down', 'img' => 'cmd_down_arrow', 'key' => 'cmd_down'),
				);
				break;
		}
		$template->set_switch('left');
		display_buttons($buttons, 'left');
		$template->set_switch('preview', ($this->mode != 'map_preview') && !empty($this->data));

		// header
		if ( $warning )
		{
			$template->assign_block_vars('warning', array(
				'WARNING_TITLE' => $user->lang('Information'),
				'WARNING_MSG' => $warning_msg,
			));
		}
		$form_title = array();
		$cur_id = $this->panel_id;
		while ( $cur_id )
		{
			$parent_id = isset($cp_panels->data[$cur_id]['panel_main']) ? $cp_panels->data[$cur_id]['panel_main'] : 0;
			array_unshift($form_title, $parent_id ? $template->lang($cp_panels->data[$cur_id]['panel_name']) : $cp_panels->data[$cur_id]['panel_shortcut']);
			$cur_id = $parent_id;
		}
		$template->assign_vars(array(
			// left
			'L_FIELDS' => $user->lang('Fields'),
			'L_PREVIEW' => $user->lang('Form_preview'),
			'I_PREVIEW' => $user->img('cmd_preview'),
			'L_EMPTY' => $user->lang('None'),

			// right
			'L_FORM' => !empty($form_title) ? $template->implode(' ' . NAV_SEPARATOR . '&nbsp;', $form_title) : (_button('preview_map') ? $user->lang('Form_preview') : $user->lang('Field_description')),
		));
		$template->set_switch('empty_list', empty($this->data));
		$template->set_switch('form');
		$template->set_filenames(array('body' => 'cp_generic.tpl'));
		$template->assign_block_vars('cp_menus', array('BOX' => $template->include_file('admin/cp_map_box.tpl')));
		_hide($this->parms);
		_hide('mode', $this->mode);
		_hide(POST_FIELDS_URL, $this->field_id);
	}
}

class cp_maps_preview extends form
{
	var $requester;
	var $parms;
	var $panel_id;

	function cp_maps_preview($requester, $parms='')
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->mode = '';
		$this->panel_id = 0;
	}

	function process($mode, $panel_id)
	{
		if ( $this->init($mode, $panel_id) )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init($mode, $panel_id)
	{
		$this->mode = $mode;
		$this->panel_id = $panel_id;
		$fields = $this->init_form();
		$buttons = $this->buttons;
		parent::form($fields);
		$this->buttons = $buttons;

		return true;
	}

	function check()
	{
	}

	function validate()
	{
	}

	function init_form()
	{
		global $config, $user, $cp_panels, $cp_maps;
		global $list_no_yes, $list_reverse_no_yes, $list_dft_yes_deny;
		global $list_topics_order, $list_topics_order_dft, $list_posts_order, $list_posts_order_dft;

		// get sample data
		$panel_id = $this->panel_id;
		while ( !empty($cp_panels->data[$panel_id]['panel_main']) )
		{
			$panel_id = $cp_panels->data[$panel_id]['panel_main'];
		}
		$data = array();
		switch ( $cp_panels->data[$panel_id]['panel_shortcut'] )
		{
			case 'acp':
				$data = $config->data;
				break;
			case 'ucp':
				$data = $user->data;
				break;
		}

		// no fields
		if ( empty($cp_maps->data) )
		{
			return false;
		}

		$fields = array();
		if ( !empty($cp_maps->data) )
		{
			foreach( $cp_maps->data as $field_name => $field_data )
			{
				$fields[$field_name] = $field_data['data'];

				// do some tweaking regarding dynamical data
				if ( !empty($fields[$field_name]) )
				{
					if ( !empty($fields[$field_name]['class_file']) )
					{
						@include_once($config->url($fields[$field_name]['class_file']));
					}
					foreach ( $fields[$field_name] as $key => $val )
					{
						if ( !empty($val) && is_string($val) && preg_match('/^\[/', $val) )
						{
							$var_check = explode(', ', preg_replace('/^\[([^\]]*)\](.*)/i', '\1, \2', $val));
							if ( !empty($var_check[1]) && preg_match('/^\[/', $var_check[1]) )
							{
								$file_check = explode(', ', preg_replace('/^\[([^\]]*)\](.*)/i', '\1, \2', $var_check[1]));
								if ( !empty($file_check[1]) )
								{
									$var_check[1] = $file_check[1];
									$var_check[2] = $file_check[0];
								}
							}
							if ( (count($var_check) > 1) && !empty($var_check[0]) && !empty($var_check[1]) )
							{
								if ( !empty($var_check[2]) )
								{
									@include_once($config->url($var_check[2]));
								}
								$entity_name = $var_check[1];
								switch ( $var_check[0] )
								{
									case 'var':
										$res = '';
										if ( isset($$entity_name) )
										{
											$res = $$entity_name;
										}
										$fields[$field_name][$key] = $res;
										break;
									case 'func':
										$res = '';
										if ( function_exists($entity_name) )
										{
											$sav_root = $config->root;
											$res = $entity_name();
										}
										$fields[$field_name][$key] = $res;
										break;
								}
							}
						}
					}
				}
			}
		}

		// retrieve values from data
		if ( !empty($fields) )
		{
			foreach ( $fields as $field_name => $field_data )
			{
				if ( !empty($field_data['field']) )
				{
					$fields[$field_name]['value'] = $data[ $field_data['field'] ];
				}
			}
		}
		return $fields;
	}
}

class cp_maps_details extends form
{
	var $mode;
	var $field_id;

	function cp_maps_details($requester, $parms='')
	{
		// get parms
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->mode = '';
		$this->field_id = 0;
	}

	function process($mode, $field_id)
	{
		if ( $this->init($mode, $field_id) )
		{
			$this->check();
			$this->validate();
			$this->display();
			return true;
		}
		return false;
	}

	function init($mode, $field_id)
	{
		global $db, $config, $user, $cp_panels, $cp_maps;
		global $list_attr_standard, $list_field_type, $list_macro_fields;

		// main parms
		$this->mode = $mode;
		$this->field_id = $field_id;

		// field data from db
		$field = ($this->mode == 'map_create') ? array() : $cp_maps->data[$this->field_id];

		// attrs used
		$attrs = array();

		// get attr list from display
		$attrs_list = _button('create_map') ? '' : _read('attrs_list', '', '', '', true);
		if ( !empty($attrs_list) )
		{
			$attrs_list = unserialize(_htmldecode($attrs_list));
			$count_attrs_list = count($attrs_list);
			for ( $i = 0; $i < $count_attrs_list; $i++ )
			{
				// take care of this attr only if the value is filled
				$attr_name = _htmlencode(trim($attrs_list[$i]));
				$attr_value = _read('field_attr_' . str_replace('.', '_', $attr_name), '', '', '', true);
				if ( !empty($attr_name) && !empty($attr_value) )
				{
					$attrs[$attr_name] = true;
				}
			}
		}
		// get the field attributes from db
		else if ( !empty($field['data']) )
		{
			foreach ( $field['data'] as $attr_name => $attr_value )
			{
				$attrs[$attr_name] = true;
			}
		}

		// if delete, retain only field attrs
		if ( $this->mode != 'map_delete' )
		{
			// attrs from copied field
			$list_copy_fields = $this->get_copy_fields($this->field_id);
			$field_copy_from = _read('field_copy_from', TYPE_NO_HTML, '', $list_copy_fields);

			$copy_type = substr($field_copy_from, 0, 1);
			$copy_id = intval(substr($field_copy_from, 2));
			if ( $copy_id > 0 )
			{
				switch ( $copy_type )
				{
					case 'f':
						// read the copy field
						$sql = 'SELECT *
									FROM ' . CP_FIELDS_TABLE . '
									WHERE field_id = ' . $copy_id;
						$result = $db->sql_query($sql, false, __LINE__, __FILE__);
						if ( $row = $db->sql_fetchrow($result) )
						{
							$row = empty($row['field_attr']) ? array() : unserialize($row['field_attr']);
							if ( !empty($row) )
							{
								foreach ( $row as $attr_name => $attr_value )
								{
									$attrs[$attr_name] = true;
									if ( empty($field['data'][$attr_name]) )
									{
										$field['data'][$attr_name] = $attr_value;
									}
								}
							}
						}
						$db->sql_freeresult($result);
						break;

					case 'm':
						$keys = empty($list_macro_fields) ? array() : array_keys($list_macro_fields);
						$id = $copy_id-1;
						if ( isset($keys[$id]) )
						{
							$row = $list_macro_fields[ $keys[$id] ];
							if ( !empty($row) )
							{
								foreach ( $row as $attr_name => $attr_value )
								{
									$attrs[$attr_name] = true;
									if ( empty($field['data'][$attr_name]) )
									{
										$field['data'][$attr_name] = $attr_value;
									}
								}
							}
						}
						unset($keys);
						break;

					default:
						break;
				}
			}

			// add new attr
			if ( _button('add_attr_button') )
			{
				$attr_name = _read('add_attr_name', TYPE_NO_HTML);
				if ( !empty($attr_name) )
				{
					$attrs[$attr_name] = true;
				}
			}

			// attrs from standard type
			$list_types = array('' => $user->lang('Field_standard_types'));
			foreach ( $list_field_type as $type_name => $type_data )
			{
				$list_types[$type_name] = $type_name;
			}
			ksort($list_types);
			$std_type = _button('create_map') ? '' : _read('field_attr_type', TYPE_NO_HTML, '', $list_types);
			$std_type_attrs = empty($std_type) || !isset($list_field_type[$std_type]) || empty($list_field_type[$std_type]) ? array() : array_flip($list_field_type[$std_type]);

			// sort and add required and default attrs for the field type
			foreach ( $list_attr_standard as $attr_name => $attr_def )
			{
				if ( $attr_def['req'] || isset($attrs[$attr_name]) || isset($std_type_attrs[$attr_name]) )
				{
					$attrs[$attr_name] = true;
				}
			}
		}

		// build order list
		$list_order = array(0 => $user->lang('Top'));
		$order = 0;
		if ( !empty($cp_maps->data) )
		{
			$found = false;
			foreach ( $cp_maps->data as $field_id => $field_data )
			{
				if ( ($field_id == $this->field_id) && ($this->mode != 'create_map') )
				{
					$found = true;
				}
				else
				{
					if ( !$found )
					{
						$order = $field_id;
					}
					$list_order[$field_id] = $field_data['field_name'];
				}
			}
		}

		//
		// build form
		//
		$fields = array();

		if ( $this->mode != 'map_delete' )
		{
			$fields += array(
				'field_copy_from' => array('type' => 'list', 'legend' => 'Field_copy_from', 'options' => $list_copy_fields, 'options.no_translate' => true, 'html' => ' onchange="res = this.options[this.selectedIndex].value; if ( (res.charAt(0) == \'f\') || (res.charAt(0) == \'m\') ) {this.form.submit();}"'),
			);
		}
		$fields += array(
			'field_name' => array('type' => 'varchar', 'legend' => 'Field_name', 'explain' => 'Field_name_explain', 'value' => $field['field_name'], 'length_mini' => 3),
			'field_order' => array('type' => 'list', 'legend' => 'Field_order', 'options' => $list_order, 'options.no_translate' => true, 'value' => $order),
			'attrs_title' => array('type' => 'sub_title', 'legend' => 'Field_attributes'),
		);
		if ( $this->mode != 'map_delete' )
		{
			$fields += array(
				'attrs_explain' => array('type' => 'comment_light', 'legend' => 'Field_attributes_explain', 'over' => true),
			);
		}
		unset($list_copy_fields);
		unset($list_order);

		// add attributes
		$attrs_list = array();
		if ( !empty($attrs) )
		{
			foreach ( $attrs as $attr_name => $dummy )
			{
				$value = $field['data'][$attr_name];
				$field_attr_name = 'field_attr_' . str_replace('.', '_', $attr_name);

				// deals with array
				if ( !empty($value) && is_array($value) )
				{
					$fields[$field_attr_name]['type'] = 'text';
					$res = array();
					foreach ( $value as $key => $val )
					{
						$res[] = (empty($key) ? '\'' . $key . '\'' : $key) . ' => ' . _un_htmlspecialchars($val);
					}
					$value = '[array]' . implode(', ', $res);
				}

				// add the attr
				$fields[$field_attr_name] = array('type' => empty($fields[$field_attr_name]['type']) ? 'varchar' : $fields[$field_attr_name]['type'], 'legend' => $attr_name, 'value' => $value);
				if ( str_replace('.', '_', $attr_name) != $attr_name )
				{
					$fields[$field_attr_name]['orig_attr_name'] = $attr_name;
				}

				// add dependant attributes
				if ( isset($list_attr_standard[$attr_name]) )
				{
					foreach ( $list_attr_standard[$attr_name] as $sub_attr_name => $def_attr_value )
					{
						if ( $sub_attr_name != 'req' )
						{
							$fields[$field_attr_name][$sub_attr_name] = $def_attr_value;
						}
					}
				}

				// store the attr name to prevent adding it in the "add new attr" list
				if ( $this->mode != 'map_delete' )
				{
					$attrs_list[$attr_name] = true;

					// add field type choice (std_type) after the "type" attribute field
					if ( $attr_name == 'type' )
					{
						$fields['std_type'] = array('type' => 'list', 'options' => $list_types, 'options.no_translate' => true, 'combined' => true, 'html' => ' onchange="if (this.options[this.selectedIndex].value != \'\') {this.form.field_attr_type.value=this.options[this.selectedIndex].value; this.form.submit();}"');
						unset($list_types);
					}
				}
			}
		}

		if ( $this->mode != 'map_delete' )
		{
			// store on form the attrs_list
			if ( !empty($attrs_list) )
			{
				_hide('attrs_list', htmlspecialchars(serialize(array_keys($attrs_list))));
			}

			// "add new attr" section
			$fields += array(
				'add_attr_title' => array('type' => 'title', 'legend' => 'Field_attributes_add'),
				'add_attr_name' => array('type' => 'varchar', 'legend' => 'Field_attr_name', 'length' => 25),
				'add_attr_button' => array('type' => 'button', 'legend' => 'Field_attributes_add', 'image' => 'cmd_add', 'combined' => true),
			);

			// built the "add new attr" list
			$list_remaining = array();
			foreach ( $list_attr_standard as $attr_name => $attr_data )
			{
				if ( !isset($attrs_list[$attr_name]) )
				{
					$list_remaining[$attr_name] = $attr_data['legend'];
				}
			}
			unset($attrs_list);

			// add the drop down list if not empty
			if ( !empty($list_remaining) )
			{
				$fields += array(
					'add_attr_list' => array('type' => 'list', 'options' => array('' => 'Field_standard_attrs') + $list_remaining, 'html' => ' onchange="if (this.options[this.selectedIndex].value != \'\') {this.form.add_attr_name.value=this.options[this.selectedIndex].value;}"', 'combined' => true, 'linefeed' => true),
				);
			}
			unset($list_remaining);
		}

		// delete : set output for all fields
		if ( $this->mode == 'map_delete' )
		{
			foreach ( $fields as $field_name => $field )
			{
				$fields[$field_name]['output'] = true;
				if ( isset($fields[$field_name]['explain']) )
				{
					unset($fields[$field_name]['explain']);
				}
			}
		}

		// instantiate the fields
		$buttons = $this->buttons;
		parent::form($fields);
		$this->buttons = $buttons;

		if ( $this->mode != 'map_delete' )
		{
			// force field type when copying
			if ( $copy_id > 0 )
			{
				$this->fields['field_attr_type']->value = $this->fields['field_attr_type']->data['value'];
			}

			// force the field copy_from
			$this->fields['field_copy_from']->value = _first_key($this->fields['field_copy_from']->data['options']);

			// reset type list choice
			if ( !empty($this->fields['std_type']->value) )
			{
				$this->fields['field_attr_type']->value = $this->fields['std_type']->value;
				$this->fields['std_type']->value = '';
			}

			// reset add attr list choice
			if ( !empty($this->fields['add_attr_list']->value) || _button('add_attr_button') )
			{
				$this->fields['add_attr_name']->value = $this->fields['add_attr_list']->value;
				$this->fields['add_attr_list']->value = '';
			}

			// try to set a field_name
			if ( empty($this->fields['field_name']->value) && isset($this->fields['field_attr_field']) && !empty($this->fields['field_attr_field']->value) )
			{
				$this->fields['field_name']->value = $this->fields['field_attr_field']->value;
			}

			// create button pushed : reset all fields to their default value
			if ( _button('create_map') )
			{
				foreach ( $this->fields as $field_name => $field )
				{
					$this->fields[$field_name]->value = $this->fields[$field_name]->data['value'];
				}
			}
		}

		return true;
	}

	function check()
	{
		global $config, $user, $cp_panels, $cp_maps;
		global $error, $error_msg;
		global $warning, $warning_msg;

		// no validation, go away
		if ( !_button('submit_map') )
		{
			return;
		}

		// check delete
		if ( $this->mode == 'map_delete' )
		{
			if ( empty($this->field_id) )
			{
				_error('No_such_field');
			}
		}
		else
		{
			// check fields
			parent::check();

			// this one can't occur
			if ( !$error && empty($this->fields) )
			{
				_error('No_attributes');
			}
			// check values regarding specific syntax ([var], [func], [array])
			if ( !$error )
			{
				foreach ( $this->fields as $field_name => $field )
				{
					if ( substr($field_name, 0, strlen('field_attr_')) == 'field_attr_' )
					{
						$val = trim($field->value);
						if ( !empty($val) && is_string($val) && preg_match('/^\[/', $val) )
						{
							$var_check = explode('|', preg_replace('/^\[([^\]]*)\](.*)/i', '\1|\2', $val));
							if ( !empty($var_check[1]) && preg_match('/^\[/', $var_check[1]) )
							{
								$file_check = explode('|', preg_replace('/^\[([^\]]*)\](.*)/i', '\1|\2', $var_check[1]));
								if ( !empty($file_check[1]) )
								{
									$var_check[1] = $file_check[1];
									$var_check[2] = $file_check[0];
								}
							}
							if ( (count($var_check) > 1) && !empty($var_check[0]) && !empty($var_check[1]) )
							{
								if ( !empty($var_check[2]) && !@file_exists(phpbb_realpath($config->url($var_check[2]))) )
								{
									_warning($user->lang($field->data['legend']) . ': ' . $user->lang('Script_not_found'));
									$val = '';
								}
								if ( !in_array($var_check[0], array('var', 'func', 'array')) )
								{
									_warning($user->lang($field->data['legend']) . ': [' . $var_check[0] . '] : ' . $user->lang('Unknown_value_type'));
									$val = '';
								}
								if ( empty($var_check[1]) )
								{
									_warning($user->lang($field->data['legend']) . ': ' . $user->lang('Field_value_empty'));
									$val = '';
								}
								else if ( $var_check[0] == 'array' )
								{
									$values = explode(',', $var_check[1]);
									if ( empty($values) )
									{
										$val = $var_check[1];
									}
									else
									{
										$res = array();
										foreach ( $values as $idx => $value )
										{
											$value = trim(_un_htmlspecialchars($value));
											if ( !empty($value) )
											{
												$composed = explode('=>', $value);
												if ( count($composed) > 1 )
												{
													foreach ($composed as $idx_frag => $value_frag )
													{
														$composed[$idx_frag] = trim($value_frag);
													}
													$res[ $composed[0] ] = $composed[1];
												}
												else
												{
													$res[] = $value;
												}
											}
										}
										if ( empty($res) )
										{
											_warning($user->lang($field->data['legend']) . ': ' . $user->lang('Not_an_array'));
											$val = '';
										}
										else
										{
											$val = $res;
										}
									}
								}
							}
						}

						// store the result for the validation process
						$this->fields[$field_name]->data['new_value'] = $val;
					}
				}
			}
		}

		// halt on error
		if ( $error )
		{
			$u_link = $config->url($this->requester, $this->parms + array('mode' => $this->mode, POST_FIELDS_URL => $this->field_id), true);
			$l_link = 'Click_return_cp';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
		global $db, $config, $user, $cp_maps;
		global $warning, $warning_msg;

		// some warnings have been sent : no validation possible
		if ( $warning )
		{
			return;
		}

		// no submission
		if ( !_button('submit_map') )
		{
			return;
		}

		// delete
		if ( $this->mode == 'map_delete' )
		{
			$sql = 'DELETE FROM ' . CP_FIELDS_TABLE . '
						WHERE field_id = ' . intval($this->field_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
			if ( isset($cp_maps->data[$this->field_id]) )
			{
				unset($cp_maps->data[$this->field_id]);
			}
			$this->field_id = empty($cp_maps->data) ? 0 : _first_key($cp_maps->data);
			$this->mode = empty($this->field_id) ? 'map_create' : 'map';
			$msg = 'Field_deleted';
		}

		// create/edit
		else
		{
			$attrs = array();
			if ( !empty($this->fields) )
			{
				foreach ( $this->fields as $field_name => $field )
				{
					if ( substr($field_name, 0, strlen('field_attr_')) == 'field_attr_' && !empty($field->data['new_value']) )
					{
						$attr_name = empty($field->data['orig_attr_name']) ? substr($field_name, strlen('field_attr_')) : $field->data['orig_attr_name'];
						$attrs[$attr_name] = $field->data['new_value'];
					}
				}
			}
			$fields = array(
				'field_name' => $this->fields['field_name']->value,
				'panel_id' => $cp_maps->panel_id,
				'field_order' => empty($this->fields['field_order']->value) ? 5 : intval($cp_maps->data[ $this->fields['field_order']->value ]['field_order'] + 5),
				'field_attr' => serialize($attrs),
			);
			$db->sql_statement($fields);
			if ( $this->mode == 'map_create' )
			{
				$sql = 'INSERT INTO ' . CP_FIELDS_TABLE . '
							(' . $db->sql_fields . ') VALUES (' . $db->sql_values . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				$this->field_id = $db->sql_nextid();
				$this->mode = 'map';
				$msg = 'Field_created';
			}
			else
			{
				$sql = 'UPDATE ' . CP_FIELDS_TABLE . '
							SET ' . $db->sql_update . '
							WHERE field_id = ' . intval($this->field_id);
				$db->sql_query($sql, false, __LINE__, __FILE__);
				$this->mode = 'map';
				$msg = 'Field_updated';
			}
		}

		// renum
		$cp_maps->renum();

		// send achievement message
		$u_link = $config->url($this->requester, $this->parms + array('mode' => $this->mode, POST_FIELDS_URL => $this->field_id), true);
		$l_link = 'Click_return_cp';
		message_return($msg, $l_link, $u_link, 10);
	}

	function get_copy_fields($except_field_id=0)
	{
		global $db, $user, $cp_panels;
		global $list_macro_fields;

		// get all fields per panels
		$sql = 'SELECT panel_id, field_id, field_name
					FROM ' . CP_FIELDS_TABLE . (empty($except_field_id) ? '' : '
					WHERE field_id <> ' . $except_field_id) . '
					ORDER BY panel_id, field_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$fields = array();
		$max_field_id = 0;
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['field_id'] > $max_field_id )
			{
				$max_field_id = $row['field_id'];
			}
			if ( !isset($fields[ $row['panel_id'] ]) )
			{
				$fields[ $row['panel_id'] ] = array();
			}
			$fields[ $row['panel_id'] ][ $row['field_id'] ] = $row['field_name'];
		}
		$db->sql_freeresult($result);

		// get panels branches
		$panels = array();
		if ( !empty($fields) )
		{
			foreach ( $fields as $panel_id => $panel_fields )
			{
				while ( $panel_id > 0 )
				{
					$panels[$panel_id] = true;
					$panel_id = isset($cp_panels->data[$panel_id]['panel_main']) ? $cp_panels->data[$panel_id]['panel_main'] : 0;
				}
			}
		}

		// mix panels and fields
		$tree = array();

		// read all panels
		if ( !empty($cp_panels->data) )
		{
			$tree += array('p.0' => array('name' => 'Panels_index', 'last_child_id' => 'p.0', 'subs' => array()));
			foreach ( $cp_panels->data as $panel_id => $panel_data )
			{
				if ( isset($panels[$panel_id]) )
				{
					$main_id = (empty($panel_id) ? '' : 'p.' . $panel_data['panel_main']);
					$tree['p.' . $panel_id] = array('main' => $main_id, 'name' => $panel_data['panel_name']);
					if ( !empty($fields[$panel_id]) )
					{
						foreach ( $fields[$panel_id] as $field_id => $field_name )
						{
							$tree['f.' . $field_id] = array('main' => 'p.' . $panel_id, 'name' => $field_name);
						}
					}
				}
			}
		}

		// reclaim some memory
		unset($panels);
		unset($fields);

		// get levels, last_ids and subs
		$last_ids = array();
		$levels = array();
		$keys = empty($tree) ? array() : array_keys($tree);
		$count_keys = count($keys);
		for ( $i = 0; $i < $count_keys; $i++ )
		{
			$last_ids[ $keys[$i] ] = $keys[$i];
			$levels[ $keys[$i] ] = 0;
			if ( $i > 0 )
			{
				$last_ids[ $tree[ $keys[$i] ]['main'] ] = $keys[$i];
				$levels[ $keys[$i] ] = $levels[ $tree[ $keys[$i] ]['main'] ] + 1;
			}
		}
		unset($keys);

		// get existing fields tree
		$existing_fields = array();
		$last_comment = -100;
		$last_comment--;

		$close = array();
		$previous_level = 0;
		if ( !empty($last_ids) )
		{
			foreach ( $last_ids as $tree_id => $last_child_id )
			{
				$close[ $levels[$tree_id] ] = ($tree_id == 'p.0') || ($last_ids[ $tree[$tree_id]['main'] ] == $tree_id);

				$linefeed = '';
				$option = '';
				for ( $i = 1; $i <= $levels[$tree_id]; $i++ )
				{
					if ( $i == $levels[$tree_id] )
					{
						$linefeed .= $user->lang('tree_pic_' . TREE_VSPACE);
						$option .= $close[$i] ? $user->lang('tree_pic_' . TREE_CLOSE) : $user->lang('tree_pic_' . TREE_CROSS);
					}
					else
					{
						$linefeed .= $close[$i] ? $user->lang('tree_pic_' . TREE_HSPACE) : $user->lang('tree_pic_' . TREE_VSPACE);
						$option .= $close[$i] ? $user->lang('tree_pic_' . TREE_HSPACE) : $user->lang('tree_pic_' . TREE_VSPACE);
					}
				}
				if ( $previous_level > $levels[$tree_id] )
				{
					$existing_fields[ ('c.' . $last_comment--) ] = $linefeed;
				}
				if ( substr($tree_id, 0, 2) == 'p.' )
				{
					$existing_fields[ ('c.' . $last_comment--) ] = $option . $user->lang($tree[$tree_id]['name']);
				}
				else
				{
					$existing_fields[$tree_id] = $option . '&nbsp;&raquo;&nbsp;' . $tree[$tree_id]['name'];
				}
				$previous_level = $levels[$tree_id];
			}
		}

		// process macro fields
		$macro_fields = array();
		if ( !empty($list_macro_fields) )
		{
			$macro_fields = array(
				('c.' . $last_comment--) => '',
				('c.' . $last_comment--) => $user->lang('Macro_fields'),
				('c.' . $last_comment--) => '--------------------',
			);
			$i = 1;
			foreach ( $list_macro_fields as $field_name => $dummy )
			{
				$macro_fields[ ('m.' . $i++) ] = '&nbsp;&raquo;&nbsp;' . $user->lang($field_name);
			}
			if ( !empty($existing_fields) )
			{
				$existing_fields = array(
					('c.' . $last_comment--) => '',
					('c.' . $last_comment--) => $user->lang('Existing_fields'),
					('c.' . $last_comment--) => '--------------------',
				) + $existing_fields;
			}
		}
		return array(('c.' . $last_comment--) => $user->lang('Field_copy_choose')) + $macro_fields + $existing_fields;
	}
}

// modes
$modes_allowed = array(
	'' => array('title' => 'cp_management', 'explain' => 'cp_management_explain'),
	'create' => array('title' => 'Create_panel', 'explain' => 'Create_panel_explain'),
	'edit' => array('title' => 'Edit_panel', 'explain' => 'Edit_panel_explain'),
	'delete' => array('title' => 'Delete_panel', 'explain' => 'Delete_panel_explain'),
	'moveup' => array(),
	'movedw' => array(),
	'preview' => array('title' => 'Preview_menu', 'explain' => 'Preview_menu_explain'),
	'map' => array('title' => 'Map_management', 'explain' => 'Map_management_explain'),
	'map_create' => array('title' => 'Create_field', 'explain' => 'Create_field_explain'),
	'map_delete' => array('title' => 'Delete_field', 'explain' => 'Delete_field_explain'),
	'map_preview' => array('title' => 'Form_preview', 'explain' => 'Form_preview_explain'),
	'map_moveup' => array('title' => 'Map_management', 'explain' => 'Map_management_explain'),
	'map_movedw' => array('title' => 'Map_management', 'explain' => 'Map_management_explain'),
);

// read and patch panels
$cp_panels = new cp_panels_admin($requester);
$cp_panels->admin = new admin_tree($cp_panels);
$cp_panels->read();
$cp_panels->patch();
$cp_maps = '';
$field_id = 0;
$handled = false;

// retrieve auths
$user->get_cache(POST_PANELS_URL);

// read parms
$mode = _read('mode', TYPE_NO_HTML, '', $modes_allowed);
$panel_id = _read(POST_PANELS_URL, TYPE_INT, 0, $cp_panels->data);

// convert buttons into mode
$buttons = array(
	'edit_form' => 'edit',
	'delete_form' => 'delete',
	'cancel_form' => '',
	'preview_map' => 'map_preview',
	'preview_map_cancel' => 'map',
	'moveup_map' => 'map_moveup',
	'movedw_map' => 'map_movedw',
	'create_map' => 'map_create',
	'cancel_map' => '',
	'delete_map' => 'map_delete',
	'delete_map_cancel' => 'map',
);

foreach ( $buttons as $button => $convert )
{
	if ( _button($button) )
	{
		$mode = $convert;
	}
}
if ( empty($mode) )
{
	$panel_id = 0;
}

// process main screen actions (move up & down)
if ( !$handled )
{
	$handled = $cp_panels->process($mode, $panel_id);
}

// edit/delete/create panel
if ( !$handled )
{
	$cp_details = new cp_panels_details($requester);
	$handled = $cp_details->process($mode, $panel_id);
	unset($cp_details);
}

// preview panel
if ( !$handled )
{
	$cp_preview = new cp_panels_preview($requester);
	$handled = $cp_preview->process($mode, $panel_id);
	unset($cp_preview);
}

// map edit/preview
if ( !$handled )
{
	$cp_maps = new cp_maps($requester, '', $panel_id);
	$cp_maps->read();
	$field_id = _read(POST_FIELDS_URL, TYPE_INT, 0, $cp_maps->data);
	$handled = $cp_maps->process($mode, $field_id);
}

// unknown action
if ( !$handled )
{
	if ( isset($cp_maps) && is_object($cp_maps) )
	{
		unset($cp_maps);
	}
	$cp_panels->display();
	unset($cp_panels);
}

// parse the display
$template->assign_vars(array(
	'L_TITLE' => $user->lang($modes_allowed[$mode]['title']),
	'L_TITLE_EXPLAIN' => $user->lang($modes_allowed[$mode]['explain']),
	'S_ACTION' => $config->url($requester, '', true),
));
_hide_set();
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>