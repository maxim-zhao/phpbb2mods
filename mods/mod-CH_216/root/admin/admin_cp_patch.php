<?php
//
//	file: admin/admin_cp_patch.php
//	author: ptirhiik
//	begin: 21/10/2004
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
define('IN_CP_ADMIN', true);

$file = basename(__FILE__);
if( !empty($setmodules) )
{
	$module['030_Control_panels']['20_cp_Patches'] = "$file";
	return;
}

define('CRLF', "\r\n");
define('TAB', "\t");

// don't send headers : we gonna send it at bottom, in case of patch download
$no_page_header = true;

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_cp_patch';
require('./pagestart.' . $phpEx);
include($config->url('includes/class_form'));
include($config->url('includes/class_cp'));

// system groups
$sys_groups = array(
	GROUP_OWN => 'GROUP_OWN',
	GROUP_FOUNDER => 'GROUP_FOUNDER',
	GROUP_ADMIN => 'GROUP_ADMIN',
	GROUP_REGISTERED => 'GROUP_REGISTERED',
	GROUP_ANONYMOUS => 'GROUP_ANONYMOUS',
);

// auths list
$auth_types = array(
	POST_PANELS_URL => 'POST_PANELS_URL',
	POST_GROUPS_URL => 'POST_GROUPS_URL',
	POST_FORUM_URL => 'POST_FORUM_URL',
);

// auth values
$auth_options = array(
	0 => 'false',
	1 => 'true',
	DENY => 'DENY',
	FORCE => 'FORCE',
);

// patch mode
$patch_modes = array(
	0 => 'Patch_mode_defs',
	1 => 'Patch_mode_patch',
	2 => 'Patch_mode_save',
);

// modes
$mode_allowed = array(
	'' => array('title' => 'cp_patch', 'explain' => 'cp_patch_explain'),
);

//------------------------------------------------------------------------------
//
// classes
//
//------------------------------------------------------------------------------

class admin_cp_patch extends form
{
	var $requester;
	var $parms;

	var $data;
	var $cp_panels;
	var $form_fields;

	var $selection;
	var $fmt;

	function admin_cp_patch($requester, $parms)
	{
		global $user;
		global $patch_modes;

		$this->requester = $requester;
		$this->parms = $parms;

		// build form
		$fields = array(
			'patch_file' => array('type' => 'varchar', 'legend' => 'Patch_file', 'length_mini' => 3),
			'patch_mode' => array('type' => 'radio_list', 'legend' => 'Patch_mode', 'explain' => 'Patch_mode_explain', 'options' => $patch_modes, 'options.linefeed' => true, 'value' => 1),
			'patch_version' => array('type' => 'varchar', 'legend' => 'Patch_version', 'length' => 25, 'length_maxi' => 25, 'length_mini' => 3),
			'patch_date' => array('type' => 'varchar', 'legend' => 'Patch_date', 'output' => true, 'value' => date('Ymd')),
			'patch_ref' => array('type' => 'varchar', 'legend' => 'Patch_ref', 'length_mini' => 1, 'length_maxi' => 255),
			'patch_author' => array('type' => 'varchar', 'legend' => 'Patch_author', 'length_mini' => 3, 'value' => $user->data['username']),
		);
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
		global $db;

		// read panels
		$this->cp_panels = new cp_panels($this->requester);
		$this->cp_panels->read();

		// read fields
		$sql = 'SELECT panel_id, field_name, field_attr
					FROM ' . CP_FIELDS_TABLE . '
					ORDER BY panel_id, field_order';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->form_fields = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->form_fields[ $row['panel_id'] ][ $row['field_name'] ] = empty($row['field_attr']) ? array() : unserialize($row['field_attr']);
		}
		$db->sql_freeresult($result);

		// build the tree
		$this->data = array();
		$panel_keys = array();
		if ( !empty($this->cp_panels->data) )
		{
			$i = -1;
			foreach ( $this->cp_panels->data as $panel_id => $panel_data )
			{
				$i++;
				$panel_keys[$panel_id] = $i;
				$this->data[$i] = array('item_type' => POST_PANELS_URL, 'panel_id' => $panel_id, 'item_name' => empty($panel_data['panel_shortcut']) ? $panel_data['panel_name'] : $panel_data['panel_shortcut'], 'item_desc' => empty($panel_data['panel_shortcut']) ? '' : $panel_data['panel_name']) + (empty($i) ? array() : array('item_main' => $panel_keys[ $panel_data['panel_main'] ])) + array('subs' => array());
				if ( $i > 0 )
				{
					$this->data[ $this->data[$i]['item_main'] ]['subs'][] = $i;
				}
				if ( !empty($this->form_fields[$panel_id]) )
				{
					foreach ( $this->form_fields[$panel_id] as $field_name => $field_data )
					{
						$i++;
						$this->data[$i] = array('item_type' => POST_FIELDS_URL, 'item_name' => $field_name, 'item_main' => $panel_keys[$panel_id], 'subs' => array());
						$this->data[ $this->data[$i]['item_main'] ]['subs'][] = $i;
					}
				}
			}
		}

		// recompute the last child
		$count_data = count($this->data);
		for ( $i = $count_data - 1; $i >= 0; $i-- )
		{
			if ( empty($this->data[$i]['subs']) )
			{
				$this->data[$i]['last_child_id'] = $i;
			}
			else
			{
				$this->data[$i]['last_child_id'] = intval($this->data[ $this->data[$i]['subs'][(count($this->data[$i]['subs'])-1)] ]['last_child_id']);
			}
		}

		// read selected items on form
		$item_ids = _read('item_ids', '', '', '', true);
		$item_ids = (!empty($item_ids) && is_array($item_ids)) ? array_flip($item_ids) : array();
		$this->selection = array();
		foreach ( $this->data as $item_id => $item_data )
		{
			if ( isset($item_ids[$item_id]) )
			{
				$this->selection[] = $item_id;
			}
		}

		return true;
	}

	function check()
	{
		global $config, $user;
		global $error, $error_msg;

		if ( !_button('submit_form') || empty($this->selection) )
		{
			return;
		}

		// check form
		parent::check();

		if ( $error )
		{
			$u_link = $config->url($this->requester, $this->parms, true);
			$l_link = 'Click_return_cp_patch';
			message_return($error_msg, $l_link, $u_link);
		}
	}

	function get_front_pic()
	{
		global $user;

		// get last ids & levels
		$last_id = array();
		$level = array();
		$count_data = count($this->data);
		for ( $i = 0; $i < $count_data; $i++ )
		{
			$last_id[$i] = $i;
			$level[$i] = 0;
			if ( $i > 0 )
			{
				$last_id[ intval($this->data[$i]['item_main']) ] = $i;
				$level[$i] = $level[ intval($this->data[$i]['item_main']) ] + 1;
			}
		}

		// prepare return
		$front_pic = array();

		$close = array();
		$previous_level = 0;
		if ( !empty($last_id) )
		{
			foreach ( $last_id as $item_id => $last_child_id )
			{
				$close[ $level[$item_id] ] = empty($item_id) || ($last_id[ intval($this->data[$item_id]['item_main']) ] == $item_id);

				$linefeed = '';
				$option = '';
				for ( $i = 1; $i <= $level[$item_id]; $i++ )
				{
					if ( $i == $level[$item_id] )
					{
						$linefeed .= TREE_VSPACE;
						$option .= $close[$i] ? TREE_CLOSE : TREE_CROSS;
					}
					else
					{
						$linefeed .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
						$option .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
					}
				}
				if ( $previous_level > $level[$item_id] )
				{
					$front_pic[ (0-count($front_pic)-100) ] = $linefeed;
				}
				$front_pic[$item_id] = $option;
				$previous_level = $level[$item_id];
			}
		}
		return $front_pic;
	}

	function display()
	{
		global $template, $config, $user;
		global $mode_allowed;

		$front_pic = $this->get_front_pic();
		if ( empty($front_pic) )
		{
			$template->set_switch('empty');
		}
		else
		{
			$color = false;
			foreach ( $front_pic as $item_id => $front )
			{
				$color = !$color;
				$template->assign_block_vars('row', array(
					'ITEM_ID' => ($item_id >= 0) ? $item_id : 0,
					'LAST_CHILD_ID' => ($item_id >= 0) ? $this->data[$item_id]['last_child_id'] : 0,
					'ITEM_NAME' => ($item_id == 0) ? $user->lang($this->data[$item_id]['item_name']) : $this->data[$item_id]['item_name'],
					'ITEM_DESC' => ($this->data[$item_id]['item_type'] == POST_PANELS_URL) ? $user->lang($this->data[$item_id]['item_desc']) : '',
				));

				$count_front = strlen($front);
				for ( $i = 0; $i < $count_front; $i++ )
				{
					$template->assign_block_vars('row.inc', array(
						'L_INC' => $user->lang('tree_pic_' . $front[$i]),
						'I_INC' => $user->img('tree_pic_' . $front[$i]),
					));
				}

				$template->set_switch('row.light', $color);
				$template->set_switch('row.command', $item_id >= 0);
				if ( $item_id >= 0 )
				{
					$template->set_switch('row.panel', $this->data[$item_id]['item_type'] == POST_PANELS_URL);
				}
				$template->set_switch('row.desc', ($item_id > 0) && ($this->data[$item_id]['item_type'] == POST_PANELS_URL));
			}
		}

		parent::display();
		$template->assign_vars(array(
			'L_TITLE' => $user->lang($mode_allowed[$mode]['title']),
			'L_TITLE_EXPLAIN' => $user->lang($mode_allowed[$mode]['explain']),
			'L_PARMS' => $user->lang('Patches_settings'),
			'L_PANELS' => $user->lang('Panels_Fields'),
			'L_SELECT' => $user->lang('Select'),
			'L_EMPTY' => $user->lang('Empty'),
			'L_SUBMIT' => $user->lang('Export'),
			'I_SUBMIT' => $user->img('cmd_export'),
		));
		$template->set_filenames(array('body' => 'admin/cp_patch_index_body.tpl'));
	}

	function validate()
	{
		global $db, $config, $sys_groups;

		if ( !_button('submit_form') || empty($this->selection) )
		{
			return;
		}

		// get mode
		$patch_mode = $this->fields['patch_mode']->value;

		// add parents to selected ids
		$selection = array_flip($this->selection);
		$count_selection = count($this->selection);
		$added_parents = array();
		for ( $i = 0; $i < $count_selection; $i++ )
		{
			$item_id = $this->selection[$i];
			while ( !empty($item_id) && !isset($selection[ $this->data[$item_id]['item_main'] ]) && !isset($added_parent[ $this->data[$item_id]['item_main'] ]) )
			{
				$added_parents[ $this->data[$item_id]['item_main'] ] = true;
				$item_id = $this->data[$item_id]['item_main'];
			}
		}

		// init results
		$panels_txt = '';
		$auths_txt = '';

		$auths = array();
		$this->node($panels_txt, $selection, $added_parents, $auths);

		// get auths
		$patch_auths = array();
		if ( ($patch_mode > 0) && !empty($auths) )
		{
			// read auths per type
			foreach ( $auths as $auth_type => $auth_data )
			{
				if ( !empty($auth_data) )
				{
					// patch only : restrain auths to sys groups
					$sql_where = '';
					if ( $patch_mode == 1 )
					{
						$sql_where = ' AND group_id IN(' . implode(', ', array_keys($sys_groups)) . ')';
						if ( $auth_type == POST_GROUPS_URL )
						{
							$sql_where = ' AND obj_id IN(' . implode(', ', array_keys($sys_groups)) . ')';
						}
					}
					$sql = 'SELECT group_id, obj_id, auth_name, auth_value
								FROM ' . AUTHS_TABLE . '
								WHERE obj_type = \'' . $auth_type . '\'' . $sql_where . '
									AND auth_name IN(\'' . implode('\', \'', array_keys($auth_data)) . '\')
									AND auth_value > 0
								ORDER BY auth_name, group_id, obj_id';
					$result = $db->sql_query($sql, false, __LINE__, __FILE__);
					while ( $row = $db->sql_fetchrow($result) )
					{
						if ( ($auth_type != POST_PANELS_URL) || isset($auths[$auth_type][ $row['auth_name'] ][ $row['obj_id'] ]) )
						{
							$patch_auths[$auth_type][ $row['auth_name'] ][ $row['group_id'] ][ $row['obj_id'] ] = $row['auth_value'];
						}
					}
					$db->sql_freeresult($result);
				}
			}
		}
		$auths_txt = $this->handle_auths($patch_auths);

		// patch def
		$patch = '<' . '?php
//--------------------------------------------------
// Patch file:	%s
// Patch time:	%s (GMT)
//--------------------------------------------------
if ( !defined(\'IN_PHPBB\') )
{
	die(\'Hack attempt\');
}

// header
$patch_version = %s;
$patch_date = %s;
$patch_author = %s;
$patch_ref = %s;

// panels and fields
%s

// auths definitions
%s

?' . '>';

		// header
		$patch_file = $this->fields['patch_file']->value;
		if ( !strpos(' ' . trim($patch_file), '.' . $config->ext) )
		{
			$patch_file = trim($patch_file) . '.' . $config->ext;
		}
		$patch_time = @gmdate($config->data['default_dateformat']);

		// vars
		$patch_version = _format($this->fields['patch_version']->value);
		$patch_date =  _format($this->fields['patch_date']->value);
		$patch_author =  _format($this->fields['patch_author']->value);
		$patch_ref =  _format($this->fields['patch_ref']->value);

		// build the file
		$patch = sprintf($patch, $patch_file, $patch_time, $patch_version, $patch_date, $patch_author, $patch_ref, $panels_txt, $auths_txt);

		// send it
		header("Content-Type: text/x-delimtext; name=\"$patch_file\"");
		header("Content-disposition: attachment; filename=$patch_file");
		echo str_replace("\n", CRLF, str_replace(CRLF, "\n", $patch));
		exit;
	}

	function node(&$txt, &$selection, &$added_parents, &$auths, $item_id=0, $tab='')
	{
		global $auth_types, $auth_options;

		if ( $item_id == 0 )
		{
			$txt = '$patch_data = array(';
			$count_subs = count($this->data[$item_id]['subs']);
			for ( $i = 0; $i < $count_subs; $i++ )
			{
				$this->node($txt, $selection, $added_parents, $auths, $this->data[$item_id]['subs'][$i], TAB);
			}
			$txt .= ');' . CRLF;
		}
		else if ( isset($selection[$item_id]) || isset($added_parents[$item_id]) )
		{
			// panels
			if ( $this->data[$item_id]['item_type'] == POST_PANELS_URL )
			{
				$panel_id = $this->data[$item_id]['panel_id'];
				$txt .= CRLF . $tab . _format($this->cp_panels->data[$panel_id]['panel_shortcut']) . ' => array(' . CRLF;
				if ( !empty($this->cp_panels->data[$panel_id]['panel_name']) )
				{
					$txt .= $tab . TAB . '\'name\' => ' . _format($this->cp_panels->data[$panel_id]['panel_name']) . ',' . CRLF;
				}
				if ( isset($selection[$item_id]) )
				{
					if ( !empty($this->cp_panels->data[$panel_id]['panel_file']) )
					{
						$txt .= $tab . TAB . '\'file\' => ' . _format($this->cp_panels->data[$panel_id]['panel_file']) . ',' . CRLF;
					}
					if ( !empty($this->cp_panels->data[$panel_id]['panel_auth_type']) && !empty($this->cp_panels->data[$panel_id]['panel_auth_name']))
					{
						$auth_type = $this->cp_panels->data[$panel_id]['panel_auth_type'];
						$auth_name = $this->cp_panels->data[$panel_id]['panel_auth_name'];
						if ( !isset($auths[$auth_type]) )
						{
							$auths[$auth_type] = array();
						}
						if ( !isset($auths[$auth_type][$auth_name]) )
						{
							$auths[$auth_type][$auth_name] = array();
						}
						if ( $auth_type == POST_PANELS_URL )
						{
							$auths[$auth_type][$auth_name][$panel_id] = array();
						}
						$txt .= $tab . TAB . '\'auth\' => array(' . $auth_types[$auth_type] . ' => ' . _format($auth_name) . '),' . CRLF;
					}
					if ( !empty($this->cp_panels->data[$panel_id]['panel_hidden']) )
					{
						$txt .= $tab . TAB . '\'hidden\' => ' . $auth_options[ $this->cp_panels->data[$panel_id]['panel_hidden'] ] . ',' . CRLF;
					}
				}
				if ( !empty($this->data[$item_id]['subs']) )
				{
					// subs can be fields or panels (but not the both)
					$is_field = empty($this->cp_panels->data[$panel_id]['subs']);
					$txt .= $tab . TAB . '\'' . ($is_field ? 'fields' : 'options') . '\' => array(' . CRLF;
					$count_subs = count($this->data[$item_id]['subs']);
					for ( $i = 0; $i < $count_subs; $i++ )
					{
						if ( isset($selection[ $this->data[$item_id]['subs'][$i] ]) || isset($added_parents[ $this->data[$item_id]['subs'][$i] ]) )
						{
							$this->node($txt, $selection, $added_parents, $auths, $this->data[$item_id]['subs'][$i], $tab . TAB . TAB);
						}
					}
					$txt .= $tab . TAB . '),' . CRLF;
				}
				$txt .= $tab . '),' . CRLF;
			}
			// fields
			else if ( $this->data[$item_id]['item_type'] == POST_FIELDS_URL )
			{
				$txt .= $tab . _format($this->data[$item_id]['item_name']) . ' => ' . _format($this->form_fields[ $this->data[ $this->data[$item_id]['item_main'] ]['panel_id'] ][ $this->data[$item_id]['item_name'] ], false, true) . ',' . CRLF;
				// is there an auth on this field ?
				if ( !empty($this->form_fields[ $this->data[$item_id]['item_name'] ]['auth']) )
				{
					if ( !isset($auths[POST_GROUPS_URL]) )
					{
						$auths[POST_GROUPS_URL] = array();
					}
					$auths[POST_GROUPS_URL][ $this->form_fields[ $this->data[$item_id]['item_name'] ]['auth'] ] = array();
				}
			}
		}
	}

	function handle_auths(&$auths)
	{
		global $sys_groups, $auth_types, $auth_options;

		$txt_auths = array();
		foreach ( $auths as $auth_type => $auth_names_data )
		{
			if ( !empty($auth_names_data) )
			{
				$txt_auths[ $auth_types[$auth_type] ] = array();
				foreach ( $auth_names_data as $auth_name => $auth_groups_data )
				{
					if ( !empty($auth_groups_data) )
					{
						$txt_auths[ $auth_types[$auth_type] ][$auth_name] = array();
						foreach ( $auth_groups_data as $group_id => $auth_objs_data )
						{
							if ( !empty($auth_objs_data) )
							{
								$group_txt_id = empty($sys_groups[$group_id]) ? $group_id : $sys_groups[$group_id];
								$txt_auths[ $auth_types[$auth_type] ][$auth_name][$group_txt_id] = array();
								foreach ( $auth_objs_data as $obj_id => $auth_value )
								{
									if ( $auth_type == POST_PANELS_URL )
									{
										$obj_txt_id = '';
										$panel_id = $obj_id;
										while ( $panel_id > 0 )
										{
											$obj_txt_id = $this->cp_panels->data[$panel_id]['panel_shortcut'] . (empty($obj_txt_id) ? '' : '.' . $obj_txt_id);
											$panel_id = $this->cp_panels->data[$panel_id]['panel_main'];
										}
									}
									else
									{
										$obj_txt_id = empty($sys_groups[$obj_id]) ? $obj_id : $sys_groups[$obj_id];
									}
									$txt_auths[ $auth_types[$auth_type] ][$auth_name][$group_txt_id][$obj_txt_id] = $auth_options[$auth_value];
								}
							}
						}
					}
				}
			}
		}

		// format output now
		$txt = '$patch_auths = array(';
		if ( !empty($txt_auths) )
		{
			foreach ( $txt_auths as $auth_type => $auth_names_data )
			{
				if ( !empty($auth_names_data) )
				{
					$txt .= CRLF . TAB . $auth_type . ' => array(' . CRLF;
					foreach ( $auth_names_data as $auth_name => $auth_data )
					{
						if ( !empty($auth_data) )
						{
							$txt .= TAB . TAB . _format($auth_name) . ' => array('. CRLF;
							foreach ( $auth_data as $group_id => $group_auths )
							{
								if ( !empty($group_auths) )
								{
									$txt_group_auths = 'array(' . _format($group_auths) . ')';
									foreach ( $sys_groups as $sys_group_id => $sys_group_name )
									{
										$txt_group_auths = str_replace('\'' . $sys_group_name . '\'', $sys_group_name, $txt_group_auths);
									}
									foreach ( $auth_options as $auth_value => $auth_value_name )
									{
										$txt_group_auths = str_replace('\'' . $auth_value_name . '\'', $auth_value_name, $txt_group_auths);
									}
									$txt .= TAB . TAB . TAB . $group_id . ' => ' . $txt_group_auths . ',' . CRLF;
								}
							}
							$txt .= TAB . TAB . '),' . CRLF;
						}
					}
					$txt .= TAB . '),' . CRLF;
				}
			}
		}
		$txt .= ');' . CRLF;
		return $txt;
	}
}

//------------------------------------------------------------------------------
//
// Main process
//
//------------------------------------------------------------------------------
// no group

// basic parameters
$parms = array();

// read the mode
$mode = _read('mode', TYPE_NO_HTML, '', $mode_allowed);

// go on
$admin_cp_patch = new admin_cp_patch($requester, $parms);
$admin_cp_patch->process();

// title
$template->assign_vars(array(
	'S_ACTION' => $config->url($requester, '', true),
));

// send all to browser
_hide_set();
include($config->url('admin/page_header_admin'));
$template->pparse('body');
include($config->url('admin/page_footer_admin'));

?>