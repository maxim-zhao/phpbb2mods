<?php
//
//	file: admin/admin_settings.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['01_Configuration+'] = $filename;
	return;
}

// don't send headers : we gonna send it at bottom
$no_page_header = true;

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_settings';
require('./pagestart.' . $phpEx);

// classes
include($config->url('includes/class_form'));
include($config->url('includes/class_cp'));

// define the control panel
$cp_name = 'acp';
$cp_title = 'General_Config';
$cp_title_explain = 'Config_explain';
$cp_menu_title = 'Configuration';

// return messages & other urls settings
$cp_requester = 'admin/admin_settings';

// layout switches
$cp_no_navigation = false;
$cp_no_menus = false;
$cp_no_display = false;

// right side title
$cp_panel_name = '';

// read panels and apply patches if available
$cp_panels = new cp_panels($cp_requester);
$cp_panels->read();
$cp_panels->patch();

// no panels : end there
if ( empty($cp_panels->keys) )
{
	message_die(GENERAL_MESSAGE, 'No_options');
}

// retrieve auths
$user->get_cache(POST_PANELS_URL);

// we don't need any viewed user for auth check
$view_user = '';

// prepare links
$cp_parms = array();

// search for the $cp_name panel_id
$menu_id = $subm_id = $ctx_id = '';
$menus = $sub_menus = $ctx_menus = array();
$cp_panel_id = $cp_panels->search(0, $cp_name);
if ( $cp_panels->auth($cp_panel_id, $view_user) )
{
	// get the first & second level menus
	$menus = $cp_panels->get_menu($cp_panel_id, $view_user);
	$menu_id = $cp_panels->get_menu_id('mode', $menus);
	if ( !empty($menu_id) )
	{
		// get the second level menus
		$sub_menus = $cp_panels->get_menu($menus[$menu_id], $view_user);
		$dft_sub = '';
		if ( empty($sub_menus) )
		{
			$sub_menus[$menu_id] = $menus[$menu_id];
			$dft_sub = $menu_id;
		}
		$subm_id = $cp_panels->get_menu_id('sub', $sub_menus, $dft_sub);

		// get the third level menus if any
		if ( !empty($subm_id) )
		{
			$ctx_menus = $cp_panels->get_menu($sub_menus[$subm_id], $view_user);
			$ctx_id = $cp_panels->get_menu_id('ctx', $ctx_menus);
		}
	}
}
if ( empty($subm_id) )
{
	message_die('Not_Authorised');
}

// prepare navigation
$navigation->add('Admin_control_panel', '', $cp_requester);
$navigation->add( $cp_panels->data[ $menus[$menu_id] ]['panel_name'], '', $cp_requester, $cp_parms + array('mode' => $menu_id));
if ( $menu_id != $subm_id )
{
	$navigation->add( $cp_panels->data[ $sub_menus[$subm_id] ]['panel_name'], '', $cp_requester, $cp_parms + array('mode' => $menu_id, 'sub' => $subm_id));
}
if ( $ctx_id && ($ctx_id != $subm_id) )
{
	$navigation->add( $cp_panels->data[ $ctx_menus[$ctx_id] ]['panel_name'], '', $cp_requester, $cp_parms + array('mode' => $menu_id, 'sub' => $subm_id, 'ctx' => $ctx_id));
}

// init panel data
$fields = $ctx_id ? $cp_panels->get_fields($ctx_menus[$ctx_id]) : $cp_panels->get_fields($sub_menus[$subm_id]);
$file = $config->url($ctx_id && !empty($cp_panels->data[ $ctx_menus[$ctx_id] ]['panel_file']) ? $cp_panels->data[ $ctx_menus[$ctx_id] ]['panel_file'] : (!empty($cp_panels->data[ $sub_menus[$subm_id] ]['panel_file']) ? $cp_panels->data[ $sub_menus[$subm_id] ]['panel_file'] : 'includes/' . $cp_name . '/' . $cp_name . '_generic'));
if ( !file_exists($file) )
{
	// send "no options"
	$cp_panels->display_empty();
}
else
{
	// include the specified files
	include($file);
}

// display constants
$template->assign_vars(array(
	'L_TITLE' => $user->lang($cp_title),
	'L_TITLE_EXPLAIN' => $user->lang($cp_title_explain),

	'L_MENU' => $user->lang($cp_menu_title),
	'L_FORM' => empty($cp_panel_name) ? ($ctx_id ? $user->lang($cp_panels->data[ $ctx_menus[$ctx_id] ]['panel_name']) : $user->lang($cp_panels->data[ $sub_menus[$subm_id] ]['panel_name'])) : $user->lang($cp_panel_name),
	'S_ACTION' => $config->url($cp_requester, '', true),
));

// display nav
if ( !$cp_no_navigation )
{
	$navigation->display('nav', false);
}

// display menu
if ( !$cp_no_menus )
{
	$cp_panels->display_menus($menus, $sub_menus, $ctx_menus, $menu_id, $subm_id, $ctx_id, $cp_requester, $cp_parms);
}

// hide some values on form
_hide($cp_parms + array('mode' => $menu_id));
if ( $subm_id != $menu_id )
{
	_hide('sub', $subm_id);
}
if ( $ctx_id && ($ctx_id != $subm_id) )
{
	_hide('ctx', $ctx_id);
}
_hide_set();

// send all to browser
if ( !$cp_no_display )
{
	include($config->url('admin/page_header_admin'));
	$template->pparse('body');
	include($config->url('admin/page_footer_admin'));
}

?>