<?php
//
//	file: admin/admin_icons.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.2 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['04_Icons_settings'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_icons';
require('./pagestart.' . $phpEx);

include($config->url('includes/class_topics'));
include($config->url('includes/class_form'));

// values allowed for 'mode=' parm
$mode_allowed = array(
	'' => array('title' => 'Icons_admin', 'explain' => 'Icons_admin_explain'),
	'moveup' => '',
	'movedw' => '',
	'edit' => array('title' => 'Icons_edit', 'explain' => 'Icons_edit_explain'),
	'delete' => array('title' => 'Icons_delete', 'explain' => 'Icons_delete_explain'),
	'create' => array('title' => 'Icons_create', 'explain' => 'Icons_create_explain'),
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

// topic types list
$list_types = array(
	POST_NORMAL => 'Post_Normal',
	POST_STICKY => 'Post_Sticky',
	POST_ANNOUNCE => 'Post_Announcement',
	POST_GLOBAL_ANNOUNCE => 'Post_Global_Announcement',
);

// basic yes/no list for form
$list_no_yes = array(
	1 => 'Yes',
	0 => 'No',
);

// plugs
if ( $config->plug_ins[$requester] )
{
	foreach ( $config->plug_ins[$requester] as $plug => $dummy )
	{
		if ( method_exists($config->plug_ins[$requester][$plug], 'types') )
		{
			$config->plug_ins[$requester][$plug]->types($list_types);
		}
	}
}

//------------------------------------------------------------------------------
//
// icon list
//
//------------------------------------------------------------------------------
class icons_list extends icons
{
	var $requester;
	var $data;
	var $mode;

	function icons_list($requester)
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
			// get icon id
			$icon_id = _read('icon', TYPE_INT);
			if ( !isset($this->data[$icon_id]) )
			{
				_error('Icon_not_exists');
			}
			else
			{
				// get the icon id to swap with the current one
				$keys = array_keys($this->data);

				// get icon_id index
				$tkeys = array_flip($keys);
				$cur_idx = $tkeys[$icon_id];
				unset($tkeys);

				// search for icon id to swap
				$swap_id = ($this->mode == 'moveup') ? intval($keys[ ($cur_idx-1) ]) : intval($keys[ ($cur_idx+1) ]);

				// swap
				if ( $swap_id > 0 )
				{
					$sql = 'UPDATE ' . ICONS_TABLE . '
								SET icon_order = ' . $this->data[$swap_id]['icon_order'] . '
								WHERE icon_id = ' . $icon_id;
					$db->sql_query($sql, false, __LINE__, __FILE__);

					$sql = 'UPDATE ' . ICONS_TABLE . '
								SET icon_order = ' . $this->data[$icon_id]['icon_order'] . '
								WHERE icon_id = ' . $swap_id;
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
			$l_link = 'Click_return_iconsadmin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
	}

	function display()
	{
		global $db, $template, $config, $user, $icons;
		global $list_auths, $list_types;
		global $lang;

		$template->assign_vars(array(
			'L_SAMPLE' => $user->lang('Icons_box'),
			'L_ICONS' => $user->lang('Message_icon'),
			'L_AUTHS' => $user->lang('Permissions'),
			'L_TYPES' => $user->lang('Icons_types'),
			'L_STATS' => $user->lang('Icons_usage'),
			'L_ACTION' => $user->lang('Action'),

			'L_MOVE_UP' => $user->lang('Move_up'),
			'I_MOVE_UP' => $user->img('cmd_up_arrow'),
			'L_MOVE_DOWN' => $user->lang('Move_down'),
			'I_MOVE_DOWN' => $user->img('cmd_down_arrow'),
			'I_EDIT' => $user->img($this->dsp ? 'cmd_mini_edit' : 'cmd_edit'),
			'L_EDIT' => $user->lang('Edit'),
			'I_DELETE' => $user->img($this->dsp ? 'cmd_mini_delete' : 'cmd_delete'),
			'L_DELETE' => $user->lang('Delete'),

			'L_EMPTY' => $user->lang('No_icons_create'),
		));

		// let's display the list
		$count_data = count($this->data);
		$template->set_switch('empty', $count_data == 0);
		if ( $count_data > 0 )
		{
			// display the sample box
			parent::display();

			// get usage
			$sql = 'SELECT post_icon, COUNT(post_id) AS total_posts
						FROM ' . POSTS_TABLE . '
						GROUP BY post_icon';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$stats = array();
			$total_posts = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$stats[ $row['post_icon'] ] = $row['total_posts'];
				$total_posts += $row['total_posts'];
			}
			$db->sql_freeresult($result);

			// display details
			foreach ( $this->data as $icon_id => $icon )
			{
				$template->assign_block_vars('row', array(
					'I_ICON' => $user->img($icon['icon_url']),
					'L_ICON' => $user->lang($icon['icon_name']),
					'LANG_KEY' => $icon['icon_name'],
					'L_AUTH' => empty($icon['icon_auth']) ? '' : $user->lang($list_auths[ $icon['icon_auth'] ]),
					'COUNT' => intval($stats[$icon_id]),
					'PER_CENT' => empty($total_posts) ? 0 : round(intval($stats[$icon_id]) * 100 / $total_posts),

					'U_MOVE_UP' => $config->url($this->requester, array('mode' => 'moveup', 'icon' => $icon_id), true),
					'U_MOVE_DOWN' => $config->url($this->requester, array('mode' => 'movedw', 'icon' => $icon_id), true),
					'U_EDIT' => $config->url($this->requester, array('mode' => 'edit', 'icon' => $icon_id), true),
					'U_DELETE' => $config->url($this->requester, array('mode' => 'delete', 'icon' => $icon_id), true),
				));
				$template->set_switch('row.lang_key', isset($lang[ $icon['icon_name'] ]));
				$count_types = count($icon['icon_types']);
				for ( $i = 0; $i < $count_types; $i++ )
				{
					$template->assign_block_vars('row.type', array(
						'L_TYPE' => $user->lang($list_types[intval($icon['icon_types'][$i])]),
					));
				}
			}
		}
		display_buttons(array(
			'create' => array('txt' => 'Create_new', 'img' => 'cmd_create', 'key' => 'cmd_create', 'url' => $this->requester, 'parms' => array('mode' => 'create')),
		));
		$template->set_filenames(array('body' => 'admin/icons_list_body.tpl'));
	}
}

//------------------------------------------------------------------------------
//
// icon details
//
//------------------------------------------------------------------------------
class form_icons extends form
{
	var $requester;
	var $mode;
	var $icon;

	function form_icons($requester, &$fields, $width=true)
	{
		parent::form($fields, $width);
		$this->requester = $requester;
		$this->buttons = array(
			'submit_form' => array('txt' => 'Submit', 'img' => 'cmd_submit', 'key' => 'cmd_submit'),
			'cancel_form' => array('txt' => 'Cancel', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
	}

	function process($mode, $icon)
	{
		$this->mode = $mode;
		$this->icon = $icon;
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
			$u_link = $config->url($this->requester, array('mode' => $this->mode, 'icon' => $this->icon), true);
			$l_link = 'Click_return_iconsadmin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
		global $db, $config, $icons;

		// delete
		if ( $this->mode == 'delete' )
		{
			// update all posts using this icon
			$sql = 'UPDATE ' . POSTS_TABLE . '
						SET post_icon = ' . $this->fields['replace_with']->value . '
						WHERE post_icon = ' . $this->icon;
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// update all topics using this icon
			$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET topic_icon = ' . $this->fields['replace_with']->value . '
						WHERE topic_icon = ' . $this->icon;
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// delete icon row
			$sql = 'DELETE FROM ' . ICONS_TABLE . '
						WHERE icon_id = ' . $this->icon;
		}
		// edit/create
		else
		{
			foreach ( $this->fields as $field_name => $field )
			{
				if ( $field_name == 'move_after' )
				{
					$fields['icon_order'] = intval($icons->data[$field->value]['icon_order']) + 5;
				}
				else if ( $field_name == 'icon_types' )
				{
					$fields[$field_name] = empty($field->value) ? '' : implode(', ', $field->value);
				}
				else if ( $field_name != 'icon_img' )
				{
					$fields[$field_name] = $field->value;
				}
			}
			$db->sql_statement($fields);
			if ( $this->mode == 'edit' )
			{
				$sql = 'UPDATE ' . ICONS_TABLE . '
							SET ' . $db->sql_update . '
							WHERE icon_id = ' . $this->icon;
			}
			else
			{
				$sql = 'INSERT INTO ' . ICONS_TABLE . '
							(' . $db->sql_fields . ') VALUES (' . $db->sql_values . ')';
			}
		}

		// perform icons table update
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// renum
		$sql = 'SELECT icon_id
					FROM ' . ICONS_TABLE . '
					ORDER BY icon_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$order = 0;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$order += 10;
			$sql = 'UPDATE ' . ICONS_TABLE . '
						SET icon_order = ' . $order . '
						WHERE icon_id = ' . $row['icon_id'];
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
		$db->sql_freeresult($result);

		// recache
		$icons->read(true);

		// send achievement message
		switch ( $this->mode )
		{
			case 'create':
				$msg = 'Icon_created';
				break;
			case 'edit':
				$msg = 'Icon_edited';
				break;
			case 'delete':
				$msg = 'Icon_deleted';
				break;
		}
		$u_link = $config->url($this->requester, '', true);
		$l_link = 'Click_return_iconsadmin';
		message_return($msg, $l_link, $u_link);
	}
}

class icons_details
{
	var $requester;
	var $icon_id;
	var $form;

	function icons_details($requester)
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
		$this->icon = _read('icon', TYPE_INT);
	}

	function check()
	{
		global $error, $error_msg;
		global $config, $icons;

		// check if icon exists
		if ( !isset($icons->data[$this->icon]) && ($this->mode != 'create') )
		{
			_error('Icon_not_exists');
		}

		// halt on error
		if ( $error )
		{
			$u_link = $config->url($this->requester, '', true);
			$l_link = 'Click_return_iconsadmin';
			message_return($error_msg, $l_link, $u_link, 10);
		}
	}

	function validate()
	{
		global $config, $user, $icons, $images;
		global $list_auths, $list_types, $lang;

		// get available icons
		$list_icons = array();
		if ( $config->data['icons_path'][ (strlen($config->data['icons_path'])-1) ] != '/' )
		{
			$config->data['icons_path'] .= '/';
		}
		$dir = @opendir(phpbb_realpath($config->root . $config->data['icons_path']));
		while ( $file = @readdir($dir) )
		{
			$filename = phpbb_realpath($config->root . $config->data['icons_path'] . $file);
			if ( !@is_dir($filename) )
			{
				$img_size = @getimagesize($filename);
				if ( $img_size[0] && $img_size[1] )
				{
					$list_icons[ $config->data['icons_path'] . $file ] = $file;
				}
			}
		}
		@closedir($dir);

		// move after & replace with list
		$list_move_after = array(0 => ($this->mode == 'delete') ? 'None' : 'Top');
		if ( !empty($icons->data) )
		{
			foreach ( $icons->data as $icon_id => $icon_data )
			{
				if ( $icon_id != $this->icon )
				{
					$list_move_after[$icon_id] = $icon_data['icon_name'];
				}
			}
		}

		// html for icon_url field
		$html = ' onchange="if (this.options[selectedIndex].value != \'\') {document.post.icon_img.src = \'' . $config->root . '\' + this.options[selectedIndex].value} else {document.post.icon_img.src=\'' . $user->img('spacer') . '\'}"';

		// build form
		$fields = array(
			'icon_name' => array('type' => 'varchar', 'legend' => 'Icon_name', 'explain' => 'Icon_name_explain', 'value' => $icons->data[$this->icon]['icon_name'], 'length_mini' => 1),
			'icon_img' => array('type' => 'image', 'image' => 'spacer', 'legend' => 'Icon_url', 'explain' => 'Icon_url_explain', 'post_value' => '&nbsp;'),
			'icon_url' => array('type' => 'list', 'value' => $icons->data[$this->icon]['icon_url'], 'options' => array('./' . $images['spacer'] => 'None') + $list_icons, 'html' => $html, 'combined' => true),
			'icon_auth' => array('type' => 'list', 'legend' => 'Icon_auth', 'explain' => 'Icon_auth_explain', 'options' => $list_auths, 'value' => $icons->data[$this->icon]['icon_auth']),
			'icon_types' => array('type' => 'checkbox_list', 'legend' => 'Icon_types', 'explain' => 'Icon_types_explain', 'options' => $list_types, 'value' => $icons->data[$this->icon]['icon_types'], 'options.linefeed' => true),
		);
		if ( $this->mode == 'delete' )
		{
			$fields += array(
				'replace_with' => array('type' => 'list', 'legend' => 'Icon_replace', 'explain' => 'Icon_replace_explain', 'options' => $list_move_after),
			);
		}
		else
		{
			$after = 0;
			if ( !empty($icons->data) )
			{
				$keys = array_keys($icons->data);
				$tkeys = array_flip($keys);
				$after = intval($keys[ ($tkeys[$this->icon]-1) ]);
				unset($tkeys);
			}
			$fields += array(
				'move_after' => array('type' => 'list', 'legend' => 'Icon_after', 'options' => $list_move_after, 'value' => $after),
			);
		}

		// instantiate this
		$this->form = new form_icons($this->requester, $fields);

		// choose the appropriate icon img
		$this->form->fields['icon_img']->data = array_merge($this->form->fields['icon_img']->data, array(
			'image' => empty($this->form->fields['icon_url']->value) ? $config->root . $images['spacer'] : $this->form->fields['icon_url']->value,
			'legend' => $user->lang($this->form->fields['icon_name']->value),
		));
		if ( $this->mode == 'delete' )
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
			if ( isset($lang[ $this->form->fields['icon_name']->value ]) )
			{
				$this->form->fields['icon_name']->data['post_value'] = '(' . $user->lang($this->form->fields['icon_name']->value) . ')';
			}
		}
	}

	function display()
	{
		global $template, $config, $user;

		// process the form
		$this->form->process($this->mode, $this->icon);

		// send all to template
		_hide('mode', $this->mode);
		_hide('icon', $this->icon);
		$template->set_filenames(array('body' => 'form_body.tpl'));
	}
}

//------------------------------------------------------------------------------
//
// Main process
//
//------------------------------------------------------------------------------

// intentiate some objects
$icons = new icons_list($requester);

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
		$icons->process('', false);
		$details = new icons_details($requester);
		$details->process($mode);
		break;
	case '':
	case 'moveup':
	case 'movedw':
		$icons->process($mode);
		$mode = '';
		break;
	default:
		$u_link = $config->url($requester, '', true);
		$l_link = 'Click_return_iconsadmin';
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