<?php
//
//	file: includes/ucp/ucp_avatar.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.3 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

// config doesn't allow avatar : end there
if ( !$config->data['allow_avatar_upload'] && !$config->data['allow_avatar_remote'] && !$config->data['allow_avatar_local'] )
{
	// send "avatar not allowed" with left side menus
	$cp_panels->display_empty('Avatars_not_allowed');
	return;
}

if ( ($view_user->data['user_id'] == $user->data['user_id']) && !$view_user->data['user_allowavatar'] )
{
	$cp_panels->display_empty('Avatars_denied');
	return;
}

// get gallery id
$gallery_id = _read('gallery', TYPE_INT);

// display the curent avatar image
$avatar_img = get_view_user_avatar();
if ( !empty($view_user->data['user_avatar']) && !empty($avatar_img) )
{
	// we handle the menu to display it first
	$cp_no_menus = true;
	$template->assign_vars(array(
		'L_MENU' => $user->lang('Profile'),
	));
	$cp_panels->display_menus($menus, $sub_menus, $ctx_menus, $menu_id, $subm_id, $ctx_id, $cp_requester, $cp_parms);

	// then we display the avatar block
	$template->assign_block_vars('avatar', array(
		'L_MENU' => $user->lang('Profile'),
		'I_AVATAR' => $avatar_img,
		'L_AVATAR' => $user->lang('Current_Image'),
	));
	if ( empty($gallery_id) || _button('cancel_gallery') )
	{
		$buttons = array(
			'delete_avatar' => array('txt' => 'Delete_Image', 'img' => 'cmd_delete', 'key' => 'cmd_delete'),
		);
		display_buttons($buttons, 'avatar');
	}
	$template->assign_block_vars('cp_menus', array('BOX' => $template->include_file('ucp/ucp_avatar_box.tpl', array('avatar'))));
}

// send the actualized text explaination
if ( isset($fields['avatar_explain']) )
{
	$fields['avatar_explain']['legend'] = sprintf($user->lang('Avatar_explain'), $config->data['avatar_max_width'], $config->data['avatar_max_height'], (round($config->data['avatar_filesize'] / 1024)));
}

// avatar found : remove not found notification
if ( (empty($view_user->data['user_avatar']) || !empty($avatar_img)) && isset($fields['current_avatar']) )
{
	unset($fields['current_avatar']);
}

// upload not allowed
if ( !$config->data['allow_avatar_upload'] )
{
	if ( isset($fields['file_upload']) )
	{
		unset($fields['file_upload']);
	}
	if ( isset($fields['url_upload']) )
	{
		unset($fields['url_upload']);
	}
}

// external link not allowed
if ( !$config->data['allow_avatar_remote'] && isset($fields['link_remote']) )
{
	unset($fields['link_remote']);
}

// gallery not allowed
if ( !$config->data['allow_avatar_local'] )
{
	if ( isset($fields['url_gallery']) )
	{
		unset($fields['url_gallery']);
	}
	if ( isset($fields['gallery']) )
	{
		unset($fields['gallery']);
	}
}

// no fields in the form : end there
if ( empty($fields) )
{
	// send "no options" with left side menus
	$cp_panels->display_empty();
	return;
}

// if upload allowed, add the form encoding type to the form def
if ( $config->data['allow_avatar_upload'] )
{
	$form_enctype = (@ini_get('file_uploads') == '0') || (strtolower(@ini_get('file_uploads') == 'off') || (phpversion() == '4.0.4pl1') || !(isset($config->data['allow_avatar_upload']) && $config->data['allow_avatar_upload'])) || ((phpversion() < '4.0.3') && (@ini_get('open_basedir') != '')) ? '' : 'enctype="multipart/form-data"';
	$template->assign_vars(array(
		'S_FORM_HTML' => $form_enctype,
	));
}

//
// ok, all is ready, start with the form
//
include($config->url('includes/usercp_avatar'));

// avatar form
class avatar_form extends form
{
	var $requester;
	var $return_msg;
	var $return_parms;
	var $view_user;
	var $avatar_sql;

	function avatar_form(&$view_user, &$fields, $requester, $return_msg, $return_parms=array())
	{
		global $user;

		$this->view_user = $view_user;
		$this->requester = $requester;
		$this->return_msg = $return_msg;
		$this->return_parms = $return_parms;

		// retrieve values from config table
		if ( !empty($fields) )
		{
			foreach ( $fields as $field_name => $field_data )
			{
				if ( !empty($field_data['field']) )
				{
					$fields[$field_name]['value'] = $this->view_user->data[ $field_data['field'] ];
				}
			}
		}

		// avatars denied ?
		if ( ($user->data['user_id'] != $view_user->data['user_id']) && !$view_user->data['user_allowavatar'] )
		{
			$fields = array(
				'avatar_warning' => array('type' => 'varchar', 'output' => true, 'over' => true, 'value' => $user->lang('Avatars_denied_user'), 'over.center' => true),
			) + $fields;
		}

		// init the fields
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
		if ( _button('cancel_form') )
		{
			return false;
		}
		return true;
	}

	function check()
	{
		global $error, $error_msg;
		global $config, $user;
		global $HTTP_POST_FILES;

		if ( !_button('submit_form') && !_button('delete_avatar') )
		{
			return;
		}

		// init upload result
		$this->avatar_sql = '';

		if ( _button('delete_avatar') )
		{
			if ( empty($this->view_user->data['user_avatar']) )
			{
				_error('No_avatar_to_delete');
			}
		}
		else
		{
			// check fields
			parent::check();

			// read uploaded avatar
			$this->fields['file_upload']->data['tmp_name'] = ($HTTP_POST_FILES['file_upload']['tmp_name'] != 'none') ? $HTTP_POST_FILES['file_upload']['tmp_name'] : '' ;
			if ( !empty($this->fields['file_upload']->data['tmp_name']) )
			{
				$this->fields['file_upload']->data['file_name'] = empty($HTTP_POST_FILES['file_upload']['name']) ? '' : $HTTP_POST_FILES['file_upload']['name'];
				$this->fields['file_upload']->data['file_size'] = empty($HTTP_POST_FILES['file_upload']['size']) ? '' : $HTTP_POST_FILES['file_upload']['size'];
				$this->fields['file_upload']->data['file_type'] = empty($HTTP_POST_FILES['file_upload']['type']) ? '' : $HTTP_POST_FILES['file_upload']['type'];
			}
			$nb = 0;
			if ( !empty($this->fields['file_upload']->data['tmp_name']) )
			{
				$nb++;
			}
			if ( !empty($this->fields['url_upload']->value) )
			{
				$nb++;
			}
			if ( !empty($this->fields['link_remote']->value) )
			{
				$nb++;
			}
			if ( $nb == 0 )
			{
				_error('No_avatar_choosen');
			}
			else if ( $nb > 1 )
			{
				_error('Many_avatar_choosen');
			}

			if ( !$error )
			{
				// try to upload the avatar if any
				if ( !empty($this->fields['file_upload']->data['tmp_name']) || !empty($this->fields['url_upload']->value) )
				{
					$avatar_upload = !empty($this->fields['file_upload']->data['tmp_name']) ? $this->fields['file_upload']->data['tmp_name'] : $this->fields['url_upload']->value;
					$avatar_mode = !empty($this->fields['file_upload']->data['tmp_name']) ? 'local' : 'remote';
					$avatar_file = $this->fields['file_upload']->data['file_name'];
					$avatar_size = intval($this->fields['file_upload']->data['file_size']);
					$avatar_type = $this->fields['file_upload']->data['file_type'];
					$this->avatar_sql = user_avatar_upload('editprofile', $avatar_mode, $this->view_user->data['user_avatar'], $this->view_user->data['user_avatar_type'], $error, $error_msg, $avatar_upload, $avatar_file, $avatar_size, $avatar_type);
				}
				else if ( !empty($this->fields['link_remote']->value) )
				{
					$this->avatar_sql = user_avatar_url('editprofile', $error, $error_msg, $this->fields['link_remote']->value);
				}
			}
		}

		// halt on error
		if ( $error )
		{
			message_return($error_msg, $this->return_msg, $config->url($this->requester, $this->return_parms, true), 10);
		}
	}

	function validate()
	{
		global $db, $config, $user;
		global $error, $error_msg;

		if ( $error )
		{
			return;
		}
		if ( !_button('submit_form') && !_button('delete_avatar') )
		{
			return;
		}

		$fields = array();
		if ( !_button('delete_avatar') )
		{
			foreach ( $this->fields as $field_name => $field )
			{
				if ( !empty($field->data['field']) )
				{
					$fields[ $field->data['field'] ] = $field->value;
				}
			}
		}

		// delete current avatar
		else
		{
			$this->avatar_sql = user_avatar_delete($this->view_user->data['user_avatar_type'], $this->view_user->data['user_avatar']);
		}
		$sql_update = trim((empty($fields) ? '' : $db->sql_fields('update', $fields)) . $this->avatar_sql);

		// remove first ','
		if ( substr($sql_update, 0, 1) == ',' )
		{
			$sql_update = trim(substr($sql_update, 1));
		}
		if ( !empty($sql_update) )
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
						SET ' . $sql_update . '
						WHERE user_id = ' . intval($this->view_user->data['user_id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// send achievement message
			message_return('Profile_updated' . ($this->view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other'), $this->return_msg, $config->url($this->requester, $this->return_parms, true));
		}
	}
}

// class gallery
class avatar_galleries
{
	var $requester;
	var $return_msg;
	var $return_parms;
	var $view_user;

	var $galleries;
	var $avatars;
	var $keys;
	var $gallery_id;
	var $avatar_id;

	function avatar_galleries(&$view_user, $requester, $return_msg, $return_parms=array())
	{
		$this->view_user = $view_user;
		$this->requester = $requester;
		$this->return_msg = $return_msg;
		$this->return_parms = $return_parms;
	}

	function process()
	{
		$this->init();
		$this->check();
		$this->validate();
		$this->display();
	}

	function init()
	{
		global $config, $user;

		// get all galleries
		$this->galleries = array();
		$dir = @opendir(phpbb_realpath($config->root . $config->data['avatar_gallery_path']));
		$gallerie_id = 0;
		while( $gallery = @readdir($dir) )
		{
			$gallery_path = phpbb_realpath($config->root . $config->data['avatar_gallery_path'] . '/' . $gallery);
			if( ($gallery != '.') && ($gallery != '..') && !empty($gallery_path) && !is_file($gallery_path) && !is_link($gallery_path) )
			{
				$gallerie_id++;
				$this->galleries[$gallerie_id] = $gallery;
			}
		}
		@closedir($dir);
		if ( empty($this->galleries) )
		{
			message_return('No_avatar_galleries', $this->return_msg, $config->url($this->requester, $this->return_parms, true), 10);
		}

		// get the gallery id
		$this->gallery_id = _read('gallery', TYPE_INT, '', $this->galleries);

		// read the images of the selected gallery
		$this->avatars = array();
		$dir = @opendir(phpbb_realpath($config->root . $config->data['avatar_gallery_path'] . '/' . $this->galleries[$this->gallery_id]));
		while( $avatar = @readdir($dir) )
		{
			if ( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $avatar) )
			{
				$name = ucfirst(str_replace('_', ' ', preg_replace('/^(.*)\..*$/', '\1', $avatar)));
				$this->avatars[ $this->galleries[$this->gallery_id] . '/' . $avatar ] = $name;
			}
		}
		@closedir($dir);
		$this->keys = array_keys($this->avatars);

		// read avatar id if any
		$avatar_ids = _read('select_avatar', '', '', '', true);
		$this->avatar_id = 0;
		if ( !empty($avatar_ids) )
		{
			$this->avatar_id = intval(_first_key($avatar_ids));
		}
		if ( !isset($this->keys[ ($this->avatar_id - 1) ]) )
		{
			$this->avatar_id = 0;
		}
	}

	function check()
	{
		if ( !_button('select_avatar') )
		{
			return;
		}
	}

	function validate()
	{
		global $db, $config, $user;

		if ( !_button('select_avatar') )
		{
			return;
		}

		if ( !empty($this->avatar_id) )
		{
			// delete current avatar
			user_avatar_delete($this->view_user->data['user_avatar_type'], $this->view_user->data['user_avatar']);

			// add the new one
			$avatar_sql = user_avatar_gallery('editprofile', $error, $error_msg, $this->keys[ ($this->avatar_id - 1) ], $this->galleries[$this->gallery_id]);
			if ( substr($avatar_sql, 0, 1) == ',' )
			{
				$avatar_sql = trim(substr($avatar_sql, 1));
			}
			if ( !empty($avatar_sql) )
			{
				$sql = 'UPDATE ' . USERS_TABLE . '
							SET ' . $avatar_sql . '
							WHERE user_id = ' . intval($this->view_user->data['user_id']);
				$db->sql_query($sql, false, __LINE__, __FILE__);

				// send achievement message
				message_return('Profile_updated' . ($this->view_user->data['user_id'] == $user->data['user_id'] ? '' : '_other'), $this->return_msg, $config->url($this->requester, $this->return_parms, true));
			}
		}
	}

	function display()
	{
		global $template, $config, $user, $navigation;

		if ( _button('cancel_form') || empty($this->galleries) )
		{
			return;
		}

		// constants : define the page
		$nb_cols = 5;
		$dft_ppage = 20;

		// build gallery selection list
		$options = '';
		foreach ( $this->galleries as $gallery_id => $gallery_name )
		{
			$selected = ($gallery_id == $this->gallery_id) ? ' selected="selected"' : '';
			$options .= '<option value="' . $gallery_id . '"' . $selected . '>' . ucfirst($gallery_name) . '</option>';
		}
		$template->assign_vars(array(
			'NB_COLS' => $nb_cols,
			'L_OPTIONS' => $user->lang('Avatar_gallery'),
			'S_OPTIONS' => $options,
			'L_GALLERY_EMPTY' => $user->lang('Empty_gallery'),
			'WIDTH' => ceil(100 / $nb_cols),

			'L_GO' => $user->lang('Go'),
			'I_GO' => $user->img('cmd_mini_submit'),
		));
		$template->set_switch('gallery_empty', empty($this->avatars));

		// display the images
		if ( !empty($this->avatars) )
		{
			$start = _read('start', TYPE_INT);
			$ppage = _read('ppage', TYPE_INT, $dft_ppage);
			$pagination = new pagination($this->requester, $this->return_parms + array('gallery' => $this->gallery_id, 'ppage' => $ppage == $dft_ppage ? 0 : $ppage));
			$pagination->display('pagination', count($this->avatars), $ppage, $start, true, 'Avatar_count', count($this->avatars));
			$count_keys = count($this->keys);
			$offset = $start-1;
			$nb_rows = ceil($ppage / $nb_cols);
			for ( $i = 0; $i < $nb_rows; $i++ )
			{
				if ( $offset + 1 < $count_keys )
				{
					$template->set_switch('row');
					for ( $j = 0; $j < $nb_cols; $j++ )
					{
						$offset++;
						$tpl_fields = ($offset >= $count_keys) ? array() : array(
							'L_AVATAR' => $this->avatars[ $this->keys[$offset] ],
							'I_AVATAR' => $config->root . $config->data['avatar_gallery_path'] . '/' . $this->keys[$offset],
							'AVATAR' => $offset + 1,
						);
						$template->assign_block_vars('row.cell', $tpl_fields);
						$template->set_switch('row.cell.filled', !empty($tpl_fields));
					}
				}
				if ( $offset >= $count_keys )
				{
					break;
				}
			}
		}

		// send all to tpl
		$template->assign_vars(array('FORM' => $template->include_file('ucp/ucp_gallery_box.tpl')));
		$template->set_switch('free_size');

		// add the buttons
		$buttons = array(
			'cancel_gallery' => array('txt' => 'Return_profile', 'img' => 'cmd_cancel', 'key' => 'cmd_cancel'),
		);
		display_buttons($buttons);

		// add to the navigation
		$navigation->add('Avatar_gallery', '', $this->requester, $this->return_parms + array('gallery' => $this->gallery_id, 'ppage' => $ppage == $dft_ppage ? 0 : $ppage, 'start' => $start));
	}
}

// gallery
$parms = array(
	'mode' => $menu_id,
	'sub' => $subm_id == $menu_id ? '' : $subm_id,
	'ctx' => $ctx_id == $subm_id ? '' : $ctx_id,
);
if ( !empty($gallery_id) && !_button('cancel_gallery') )
{
	$cp_panel_name = 'Avatar_gallery';
	$form = new avatar_galleries($view_user, $cp_requester, 'Click_return_' . $menu_id, $cp_parms + $parms);
}
else
{
	// instantiate the form
	$form = new avatar_form($view_user, $fields, $cp_requester, 'Click_return_' . $menu_id, $cp_parms + $parms);
}
$form->process();
$template->set_switch('form');
$template->set_filenames(array('body' => 'cp_generic.tpl'));

?>