<?php
//
//	file: includes/ucp/ucp_bridge.php
//	author: ptirhiik
//	begin: 22/01/2006
//	version: 1.6.2 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

$cp_no_navigation = true;
$cp_no_menus = true;
$cp_no_display = true;
$cp_nav_switch = '';

// handle navigation
if ( !isset($menus['editprofile']) || !$cp_panels->auth($menus['editprofile'], $view_user) )
{
	$navigation->clear();
	if ( !$cp_panels->data[ $sub_menus[$subm_id] ]['panel_hidden'] )
	{
		$navigation->add('Profile', '', 'usercp', array('mode' => _read('mode', TYPE_NO_HTML), POST_USERS_URL => $view_user->data['user_id'] != $user->data['user_id'] ? $view_user->data['user_id'] : 0), '');
	}
}
$navigation->display();

// force user_id
if ( $view_user->data )
{
	$HTTP_GET_VARS[POST_USERS_URL] = $view_user->data['user_id'];
}

// get script path to build the sent links
$server_url = $config->get_script_path() . $requester . '.' . $config->ext;

// do the bridge
switch ( $menu_id )
{
	case 'viewprofile';
		include($config->url('includes/usercp_viewprofile'));
		break;

	case 'email':
		include($config->url('includes/usercp_email'));
		break;

	case 'sendpassword':
		include($config->url('includes/usercp_sendpasswd'));
		break;

	case 'activate':
		include($config->url('includes/usercp_activate'));
		break;

	default:
		message_return('Unknown_action', 'Click_return_profile', $config->url($cp_requester, $cp_parms, true));
		break;
}

?>