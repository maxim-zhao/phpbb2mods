<?php
//
//	file: usercp.php
//	author: ptirhiik
//	begin: 26/08/2004
//	version: 1.6.6 - 18/10/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
define('IN_USERCP', true);

$phpbb_root_path = './';
$requester = 'usercp';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.'.$phpEx);

// specific treatement for visual confirmation
if ( _read('mode', TYPE_NO_HTML) == 'confirm' )
{
	$userdata = session_pagestart($user_ip, PAGE_PROFILE);
	$user->set('usercp_confirm', false);
	include($config->url('includes/vc/class_visual_confirm_img'));
	exit;
}

// classes
include($config->url('includes/class_form'));
include($config->url('includes/class_cp'));

// define the control panel
$cp_name = 'ucp';
$cp_title = 'Profile';
$cp_title_explain = 'Profile_explain';
$cp_menu_title = 'Profile';
$page_title = 'Profile';

// return messages & other urls settings
$cp_requester = 'usercp';
$cp_parms = array();

// layout switches
$cp_no_navigation = false;
$cp_no_menus = false;
$cp_no_display = false;

// right side title
$cp_panel_name = '';
$cp_nav_switch = 'nav';

// specific treatement for rules
if ( _read('rules', TYPE_INT) && intval($config->data['forum_rules']) )
{
	include($config->url('includes/class_forums'));
	include($config->url('includes/class_topics'));
	include($config->url('includes/class_posts'));
	include($config->url('includes/topic_review'));
	$forums = new forums();
	$forums->read();
	topic_review(intval($config->data['forum_rules']), 0, false, '', array('rules' => 1, 'sort' => 'lastpost', 'order' => 'asc'), 'Registration');
	exit;
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PROFILE);
$user->set($cp_requester, array('usercp', 'editprofile', 'viewprofile', 'class_fields', 'bbcodes'));
//
// End session management
//

// no access for bots
if ( $user->data['session_is_bot'] )
{
	message_return('Not_Authorised');
}

// read panels and apply patches if available
$cp_panels = new cp_panels($cp_requester);
$cp_panels->read();
$cp_panels->patch();

// no panels : end there
if ( empty($cp_panels->keys) )
{
	message_return('No_options');
}

// retrieve auths
$user->get_cache(array(POST_GROUPS_URL, POST_PANELS_URL));

// get viewed user and retrieve its group list
$view_user_id = _read(POST_USERS_URL, TYPE_INT, $user->data['user_id']);
if ( empty($view_user_id) || ($view_user_id == $user->data['user_id']) )
{
	$view_user = &$user;
}
else
{
	$view_user = new user();
	$view_user->read($view_user_id);
}

// prepare links
$cp_parms = ($view_user->data['user_id'] == $user->data['user_id']) ? array() : array(POST_USERS_URL => $view_user->data['user_id']);

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
$mode = _read('mode', TYPE_NO_HTML);
$sub = _read('sub', TYPE_NO_HTML);
$ctx = _read('ctx', TYPE_NO_HTML);
if ( empty($subm_id) || (!empty($mode) && ($mode != $menu_id)) || (!empty($sub) && ($sub != $subm_id)) || (!empty($ctx) && ($ctx != $ctx_id)) )
{
	if ( !$user->data['session_logged_in'] )
	{
		redirect($config->url('login', '', true), $config->url($cp_requester, $cp_parms, true));
		exit;
	}
	message_return('Not_Authorised');
}

// prepare navigation
$navigation->add($view_user->data['username'], '', $cp_requester, $cp_parms);
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
	$navigation->display('nav');
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
	$page_title = $user->lang($page_title);
	include($config->url('includes/page_header'));
	$template->pparse('body');
	include($config->url('includes/page_tail'));
}

?>