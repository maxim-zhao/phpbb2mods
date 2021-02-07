<?php
//
//	file: admin/admin_topics_attr.php
//	author: ptirhiik
//	begin: 26/03/2005
//	version: 1.6.1 - 24/10/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['03_Topics_attr_settings'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_topics_attr';
require('./pagestart.' . $phpEx);

include($config->url('includes/class_topics'));
include($config->url('includes/class_form'));

// values allowed for 'mode=' parm
$mode_allowed = array(
	'' => array('title' => 'Topics_attr_admin', 'explain' => 'Topics_attr_admin_explain'),
	'moveup' => '',
	'movedw' => '',
	'edit' => array('title' => 'Topics_attr_edit', 'explain' => 'Topics_attr_edit_explain'),
	'delete' => array('title' => 'Topics_attr_delete', 'explain' => 'Topics_attr_delete_explain'),
	'create' => array('title' => 'Topics_attr_create', 'explain' => 'Topics_attr_create_explain'),
);

// auths requirement list
$auth_class = new auth_class();
$auth_class->read();
$list_auths = array('' => 'None');
if ( !empty($auth_class->keys[POST_FORUM_URL]) )
{
	foreach ( $auth_class->keys[POST_FORUM_URL] as $auth_name => $auth_id )
	{
		$list_auths[$auth_name] = $auth_name;
	}
}

// lists
$main_types = array('', '_hot', '_new', '_hot_new', '_own', '_hot_own',	'_new_own', '_hot_new_own');
$main_fields = array(
	'' => 'None',
	'topic_type' => 'Topics_attr_ttype',
	'topic_sub_type' => 'Topics_attr_tsubtype',
	'topic_moved_id' => 'Topics_attr_tmoved',
	'topic_status' => 'Topics_attr_tstatus',
	'topic_vote' => 'Topics_attr_tvote',
	'topic_attachment' => 'Topics_attr_tattach',
	'topic_calendar_time' => 'Topics_attr_tcalendar',
);
$main_conds = array(
	'' => 'None',
	'LT' => 'Less',
	'LE' => 'Less_equal',
	'EQ' => 'Equal',
	'GE' => 'Greater_equal',
	'GT' => 'Greater',
	'NE' => 'Not_equal',
);

//------------------------------------------------------------------------------
//
// Topics attributes list
//
//------------------------------------------------------------------------------
class topics_attr_list extends topics_attr
{
	var $requester;
	var $data;
	var $mode;

	function topics_attr_list($requester)
	{
		$this->requester = $requester;
		$this->data = array();
	}

	function process($mode, $display=true)
	{
		$this->init($mode);
		if ( $display )
		{
			$this->check();
			$this->validate();
			$this->display();
		}
	}

	function init($mode)
	{
		global $db;

		$this->mode = $mode;
		$this->read();
		$this->allowed = array_keys($this->data);
		$this->allowed_flag = true;
	}

	function check()
	{
		global $error, $error_msg;
		global $db, $config;

		if ( in_array($this->mode, array('moveup', 'movedw')) )
		{
			// get attr id
			$attr_id = _read('attr', TYPE_INT);
			if ( !isset($this->data[$attr_id]) )
			{
				_error('Topics_attr_not_exists');
			}
			else
			{
				// get the attr id to swap with the current one
				$keys = array_keys($this->data);
				$tkeys = array_flip($keys);
				$cur_idx = $tkeys[$attr_id];
				unset($tkeys);

				// search for attr id to swap
				$swap_id = ($this->mode == 'moveup') ? intval($keys[ ($cur_idx-1) ]) : intval($keys[ ($cur_idx+1) ]);

				// swap
				if ( $swap_id > 0 )
				{
					$sql = 'UPDATE ' . TOPICS_ATTR_TABLE . '
								SET attr_order = ' . $this->data[$swap_id]['attr_order'] . '
								WHERE attr_id = ' . $attr_id;
					$db->sql_query($sql, false, __LINE__, __FILE__);

					$sql = 'UPDATE ' . TOPICS_ATTR_TABLE . '
								SET attr_order = ' . $this->data[$attr_id]['attr_order'] . '
								WHERE attr_id = ' . $swap_id;
					$db->sql_query($sql, false, __LINE__, __FILE__);

					// recache
					$this->read(true);
				}
			}

			// reset mode
			$this->mode = '';
		}

		// halt on error
		if ( $error )
		{
			$u_link = $config->url($this->requester, '', true);
			$l_link = 'Click_return_topics_attr_admin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
	}

	function display()
	{
		global $template, $config, $user, $images;
		global $main_types, $main_fields, $main_conds;

		$template->assign_vars(array(
			'L_NAME' => $user->lang('Topics_attr_name'),
			'L_FOLDER' => $user->lang('Topics_attr_folder'),
			'L_FRONT' => $user->lang('Topics_attr_title'),
			'L_ACTION' => $user->lang('Action'),
			'L_EMPTY' => $user->lang('Create_new'),

			'L_MOVE_UP' => $user->lang('Move_up'),
			'I_MOVE_UP' => $user->img('cmd_up_arrow'),
			'L_MOVE_DOWN' => $user->lang('Move_down'),
			'I_MOVE_DOWN' => $user->img('cmd_down_arrow'),
			'I_EDIT' => $user->img($this->dsp ? 'cmd_mini_edit' : 'cmd_edit'),
			'L_EDIT' => $user->lang('Edit'),
			'I_DELETE' => $user->img($this->dsp ? 'cmd_mini_delete' : 'cmd_delete'),
			'L_DELETE' => $user->lang('Delete'),
		));

		// main types
		$count_main_types = count($main_types);

		// display details
		$template->set_switch('empty', empty($this->data));
		if ( !empty($this->data) )
		{
			foreach ( $this->data as $attr_id => $data )
			{
				$timg = !empty($data['attr_timg']) && isset($images[ $data['attr_timg'] ]);
				$template->assign_block_vars('row', array(
					'U_NAME' => $config->url($this->requester, array('mode' => 'edit', 'attr' => $attr_id), true),
					'L_NAME' => $user->lang($data['attr_name']),
					'L_AUTH' => empty($data['attr_auth']) ? '' : $user->lang($data['attr_auth']),
					'L_COND' => empty($data['attr_field']) ? '' : $user->lang($main_fields[ $data['attr_field'] ]) . (empty($data['attr_cond']) ? '' : ' ' . $user->lang($main_conds[ $data['attr_cond'] ]) . ' ' . intval($data['attr_value'])),
					'L_FNAME' => $user->lang($data['attr_fname']),
					'L_TNAME' => empty($data['attr_tname']) ? '' : $user->lang($data['attr_tname']),
					'I_TAG' => $timg ? $user->img($data['attr_timg']) : '',
					'L_TAG' => $data['attr_timg'],

					'U_MOVE_UP' => $config->url($this->requester, array('mode' => 'moveup', 'attr' => $attr_id), true),
					'U_MOVE_DOWN' => $config->url($this->requester, array('mode' => 'movedw', 'attr' => $attr_id), true),
					'U_EDIT' => $config->url($this->requester, array('mode' => 'edit', 'attr' => $attr_id), true),
					'U_DELETE' => $config->url($this->requester, array('mode' => 'delete', 'attr' => $attr_id), true),
				));
				$template->set_switch('row.cond', !empty($data['attr_field']));
				$template->set_switch('row.auth', !empty($data['attr_auth']));
				$template->set_switch('row.fname', !empty($data['attr_fname']));
				$template->set_switch('row.timg', $timg);
				$template->set_switch('row.ttxt', !empty($data['attr_tname']));
				$template->set_switch('row.tname', !empty($data['attr_tname']));
				if ( !empty($data['attr_fimg']) )
				{
					for ( $i = 0; $i < $count_main_types; $i++ )
					{
						$template->assign_block_vars('row.sub', array(
							'I_FOLDER' => isset($images[ $data['attr_fimg'] . $main_types[$i] ]) ? $user->img($data['attr_fimg'] . $main_types[$i]) : '',
							'L_FOLDER' => $data['attr_fimg'] . $main_types[$i],
						));
						$template->set_switch('row.sub.img', isset($images[ $data['attr_fimg'] . $main_types[$i] ]));
					}
				}
				$template->set_switch('row.command', !$data['attr_added']);
			}
		}
		display_buttons(array(
			'create' => array('txt' => 'Create_new', 'img' => 'cmd_create', 'key' => 'cmd_create', 'url' => $this->requester, 'parms' => array('mode' => 'create')),
		));
		$template->set_filenames(array('body' => 'admin/topics_attr_list_body.tpl'));
	}
}

//------------------------------------------------------------------------------
//
// topic title attribute details
//
//------------------------------------------------------------------------------
class form_topics_attr extends form
{
	var $requester;
	var $mode;
	var $attr_id;

	function form_topics_attr($requester, &$fields, $width=true)
	{
		parent::form($fields, $width);
		$this->requester = $requester;
	}

	function process($mode, $attr_id)
	{
		$this->mode = $mode;
		$this->attr_id = $attr_id;
		parent::process($mode);
	}

	function check()
	{
		global $error, $error_msg;
		global $config;

		// basic check
		parent::check();

		// halt on error
		if ( $error )
		{
			$u_link = $config->url($this->requester, array('mode' => $this->mode, 'attr' => $this->attr_id), true);
			$l_link = 'Click_return_topics_attr_admin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
		global $db, $config, $topics_attr;

		// delete
		if ( $this->mode == 'delete' )
		{
			if ( isset($this->fields['replace_with']) && ($this->fields['attr_field']->data['value'] == 'topic_sub_type') )
			{
				// update all topics using this topic attr
				$sql = 'UPDATE ' . TOPICS_TABLE . '
							SET topic_sub_type = ' . intval($this->fields['replace_with']->value) . '
							WHERE topic_sub_type = ' . $this->attr_id;
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			// delete topic title attribute row
			$sql = 'DELETE FROM ' . TOPICS_ATTR_TABLE . '
						WHERE attr_id = ' . $this->attr_id;
		}
		// edit/create
		else
		{
			foreach ( $this->fields as $field_name => $field )
			{
				if ( $field_name == 'move_after' )
				{
					$fields['attr_order'] = intval($topics_attr->data[$field->value]['attr_order']) - 5;
				}
				else if ( !in_array($field_name, array('i_fimg', 'i_timg')) && !$field->data['hidden'] )
				{
					$fields[$field_name] = $field->value;
				}
			}

			// top asked
			if ( $fields['attr_order'] <= 0 )
			{
				$fields['attr_order'] = $topics_attr->data[ _first_key($topics_attr->data) ]['attr_order'] + 10;
			}
			$db->sql_statement($fields);
			if ( $this->mode == 'edit' )
			{
				$sql = 'UPDATE ' . TOPICS_ATTR_TABLE . '
							SET ' . $db->sql_update . '
							WHERE attr_id = ' . $this->attr_id;
			}
			else
			{
				$sql = 'INSERT INTO ' . TOPICS_ATTR_TABLE . '
							(' . $db->sql_fields . ') VALUES (' . $db->sql_values . ')';
			}
		}

		// perform topics attr table update
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// renum
		$sql = 'SELECT attr_id
					FROM ' . TOPICS_ATTR_TABLE . '
					ORDER BY attr_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$order = 0;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$order += 10;
			$sql = 'UPDATE ' . TOPICS_ATTR_TABLE . '
						SET attr_order = ' . $order . '
						WHERE attr_id = ' . $row['attr_id'];
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
		$db->sql_freeresult($result);

		// recache
		$topics_attr->read(true);

		// send achievement message
		switch ( $this->mode )
		{
			case 'create':
				$msg = 'Topics_attr_created';
				break;
			case 'edit':
				$msg = 'Topics_attr_edited';
				break;
			case 'delete':
				$msg = 'Topics_attr_deleted';
				break;
		}
		$u_link = $config->url($this->requester, '', true);
		$l_link = 'Click_return_topics_attr_admin';
		message_return($msg, $l_link, $u_link);
	}
}

class topics_attr_details
{
	var $requester;
	var $attr_id;
	var $form;

	function topics_attr_details($requester)
	{
		$this->requester = $requester;
	}

	function process($mode)
	{
		$this->init($mode);
		$this->check();
		$this->validate();
		$this->display();
	}

	function init($mode)
	{
		$this->mode = $mode;
		$this->attr_id = _read('attr', TYPE_INT);
	}

	function check()
	{
		global $error, $error_msg;
		global $config, $topics_attr;

		// check if topic title attribute exists
		if ( (!isset($topics_attr->data[$this->attr_id]) || $topics_attr->data[$this->attr_id]['attr_added']) && ($this->mode != 'create') )
		{
			_error('Topics_attr_not_exists');
		}

		// halt on error
		if ( $error )
		{
			$u_link = $config->url($this->requester, '', true);
			$l_link = 'Click_return_topics_attr_admin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
		global $config, $user, $topics_attr;
		global $main_fields, $main_conds, $list_auths;
		global $images;

		// delete ?
		$output = ($this->mode == 'delete');

		// move after & replace with list
		$list_move_after = array(0 => $output ? 'None' : 'Top');
		if ( !empty($topics_attr->data) )
		{
			foreach ( $topics_attr->data as $attr_id => $data )
			{
				if ( ($attr_id != $this->attr_id) && !$data['attr_added'] )
				{
					if ( $output )
					{
						if ( $data['attr_field'] == 'topic_sub_type' )
						{
							$list_move_after[$attr_id] = $data['attr_name'];
						}
					}
					else
					{
						$list_move_after[$attr_id] = $data['attr_name'];
					}
				}
			}
		}

		// build an image list
		$list_images = array('' => $user->lang('None'));
		foreach ( $images as $key => $image )
		{
			if ( ($key != 'None') && ($key != 'spacer') && is_string($image) && !preg_match('#(_hot|_new|_own)#', $image) && preg_match('#(\.gif|\.jpg|\.jpeg|\.png)#', $image) )
			{
				$list_images[$key] = $key;
			}
		}
		if ( !empty($list_images) )
		{
			ksort($list_images);
		}

		// html for attr_?img field
		$html = ($this->mode == 'delete') ?  '' : ' onchange="document.post.%s.src = eval(\'document.post.hidden_images_\' + this.options[selectedIndex].value + \'.value\');"';

		// build form
		$fields = array(
			'attr_name' => array('type' => 'varchar', 'legend' => 'Topics_attr_name', 'explain' => 'Topics_attr_name_explain', 'value' => $topics_attr->data[$this->attr_id]['attr_name'], 'length_mini' => 1),
			'attr_fimg' => array('type' => 'list', 'legend' => 'Topics_attr_fimg', 'explain' => 'Topics_attr_fimg_explain', 'value' => $topics_attr->data[$this->attr_id]['attr_fimg'], 'options' => $list_images, 'options.no_translate' => true, 'html' => sprintf($html, 'i_fimg'), 'post_value' => '&nbsp;'),
			'i_fimg' => array('type' => 'image', 'image' => empty($topics_attr->data[$this->attr_id]['attr_fimg']) ? 'spacer' : $topics_attr->data[$this->attr_id]['attr_fimg'], 'combined' => true),
			'attr_fname' => array('type' => 'varchar', 'legend' => 'Topics_attr_fname', 'explain' => 'Topics_attr_fname_explain', 'value' => $topics_attr->data[$this->attr_id]['attr_fname']),
			'attr_tname' => array('type' => 'varchar', 'legend' => 'Topics_attr_tname', 'explain' => 'Topics_attr_tname_explain', 'value' => $topics_attr->data[$this->attr_id]['attr_tname']),
			'attr_timg' => array('type' => 'list', 'legend' => 'Topics_attr_timg', 'explain' => 'Topics_attr_timg_explain', 'value' => $topics_attr->data[$this->attr_id]['attr_timg'], 'options' => $list_images, 'options.no_translate' => true, 'html' => sprintf($html, 'i_timg'), 'post_value' => '&nbsp;'),
			'i_timg' => array('type' => 'image', 'image' => empty($topics_attr->data[$this->attr_id]['attr_timg']) ? 'spacer' : $topics_attr->data[$this->attr_id]['attr_timg'], 'combined' => true),
			'attr_field' => array('type' => 'list', 'legend' => 'Topics_attr_field', 'explain' => 'Topics_attr_field_explain', 'value' => $topics_attr->data[$this->attr_id]['attr_field'], 'options' => $main_fields),
			'attr_cond' => array('type' => 'list', 'value' => trim($topics_attr->data[$this->attr_id]['attr_cond']), 'options' => $main_conds, 'combined' => true),
			'attr_value' => array('type' => 'int', 'value' => $topics_attr->data[$this->attr_id]['attr_value'], 'combined' => true),
			'attr_auth' => array('type' => 'list', 'value' => $topics_attr->data[$this->attr_id]['attr_auth'], 'legend' => 'Topics_attr_auth', 'explain' => 'Topics_attr_auth_explain', 'options' => $list_auths),
		);
		if ( !$output )
		{
			foreach ( $list_images as $key => $dummy )
			{
				$fields += array(
					'hidden_images_' . $key => array('type' => 'varchar', 'hidden' => true, 'value' => empty($key) ? $user->img('spacer') : $user->img($key)),
				);
			}
		}
		if ( $this->mode == 'delete' )
		{
			if ( $topics_attr->data[$this->attr_id]['attr_field'] == 'topic_sub_type' )
			{
				$fields += array(
					'replace_with' => array('type' => 'list', 'legend' => 'Topics_attr_replace', 'explain' => 'Topics_attr_replace_explain', 'options' => $list_move_after),
				);
			}
		}
		else
		{
			$after = 0;
			if ( !empty($topics_attr->data) )
			{
				$keys = array_keys($topics_attr->data);
				$tkeys = array_flip($keys);
				$after = intval($keys[ ($tkeys[$this->attr_id]-1) ]);
				unset($tkeys);
			}
			$fields += array(
				'move_after' => array('type' => 'list', 'legend' => 'Topics_attr_after', 'options' => $list_move_after, 'value' => $after),
			);
		}

		// instantiate this
		$this->form = new form_topics_attr($this->requester, $fields);

		// choose the appropriate images
		$this->form->fields['i_fimg']->data = array_merge($this->form->fields['i_fimg']->data, array(
			'image' => empty($this->form->fields['attr_fimg']->value) ? 'spacer' : $this->form->fields['attr_fimg']->value,
		));
		$this->form->fields['i_timg']->data = array_merge($this->form->fields['i_timg']->data, array(
			'image' => empty($this->form->fields['attr_timg']->value) ? 'spacer' : $this->form->fields['attr_timg']->value,
		));
		if ( $this->form->fields['attr_field']->value == 'topic_sub_type' )
		{
			$this->form->fields['attr_cond']->value = '';
			$this->form->fields['attr_value']->value = 0;
		}
		else
		{
			$this->form->fields['attr_auth']->value = '';
		}

		if ( $output )
		{
			foreach ( $this->form->fields as $field_name => $field )
			{
				if ( $field_name != 'replace_with' )
				{
					$this->form->fields[$field_name]->data['output'] = true;
					if ( isset($this->form->fields[$field_name]->data['explain']) )
					{
						unset($this->form->fields[$field_name]->data['explain']);
					}
				}
			}
		}
	}

	function display()
	{
		global $template, $config, $user;

		// process the form
		$this->form->set_buttons(array(
			'submit_form' => array('txt' => ($this->mode == 'delete') ? 'Delete' : 'Submit', 'img' => ($this->mode == 'delete') ? 'cmd_delete' : 'cmd_submit', 'key' => ($this->mode == 'delete') ? 'cmd_delete' : 'cmd_submit'),
			'cancel_form' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		));
		$this->form->process($this->mode, $this->attr_id);

		// send all to template
		_hide('mode', $this->mode);
		_hide('attr', $this->attr_id);
		$template->set_filenames(array('body' => 'form_body.tpl'));
	}
}

//------------------------------------------------------------------------------
//
// Main process
//
//------------------------------------------------------------------------------

// intentiate some objects
$topics_attr = new topics_attr_list($requester);

//
// get parms
//
$mode = _read('mode', TYPE_NO_HTML, '',  $mode_allowed);
if ( _button('cancel_form') )
{
	$mode = '';
}

// let's go
switch ( $mode )
{
	case 'create':
	case 'edit':
	case 'delete':
		$topics_attr->process('', false);
		$details = new topics_attr_details($requester);
		$details->process($mode);
		break;
	case '':
	case 'moveup':
	case 'movedw':
		$topics_attr->process($mode);
		$mode = '';
		break;
	default:
		$u_link = $config->url($requester, '', true);
		$l_link = 'Click_return_topics_attr_admin';
		message_return('No_valid_action', $l_link, $u_link);
		break;
}

// constants
$template->assign_vars(array(
	'L_TITLE' => $user->lang($mode_allowed[$mode]['title']),
	'L_TITLE_EXPLAIN' => $user->lang($mode_allowed[$mode]['explain']),
	'L_FORM' => $user->lang($mode_allowed[$mode]['title']),
	'S_ACTION' => $config->url($requester, '', true),
));

// send the display
_hide_set();
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>