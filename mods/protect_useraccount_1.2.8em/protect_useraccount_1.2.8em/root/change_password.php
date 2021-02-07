<?php
define('IN_PHPBB', true);
define('EXTRA_SECURE', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
//slow down to alow DB to be updated before fetching userdata..
sleep(1);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_LOGIN);
init_userprefs($userdata);
//
// End session management
//
$error = false;
$updated = false;

$submit = (isset($HTTP_POST_VARS['submit'])) ? 1 : '';
$trim_var_list = array('new_password' => 'new_password', 'password_confirm' => 'password_confirm','cur_password' => 'cur_password');
while( list($var, $param) = @each($trim_var_list) )
{
	if ( !empty($HTTP_POST_VARS[$param]) )
	{
		$$var = trim($HTTP_POST_VARS[$param]);
	}
}

if ($submit)
{
	//verify that user is already logged in from this IP
	$ip_check_s = substr($userdata['session_ip'], 0, 6);
	$ip_check_u = substr($user_ip, 0, 6);
	if ( !$userdata['session_logged_in'] || $ip_check_s != $ip_check_u)
	{
		die("Hacking attempt");
		exit;
	}
	// verify that all info is pressent and valid
	if (empty($new_password) || empty($password_confirm))
	{
		$error = true;
		$error_msg .= $lang['Fields_empty'];
	} 
	if ($new_password != $password_confirm)
	{
		$error=true;
		$error_msg .= $lang['Password_mismatch'];
	} 
	include($phpbb_root_path . 'includes/functions_validate.'.$phpEx);
	$error_text = validate_complex_password ($username, $new_password);
	if ( $error_text['error'] )
	{
		$error = true;
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $error_text['error_msg'];
	} 
	if (!$error)
	{	//update new password + time
		if (defined('EXTRA_SECURE'))
		{
			$secure_sql = " AND user_password='".md5($cur_password)."'";
		} else
		{
			$secure_sql = "";
		}

		$sql = "UPDATE " . USERS_TABLE . " SET user_password='".md5($new_password)."', user_passwd_change='".time()."'
		WHERE user_active AND user_id='".$userdata['user_id']."'";
		if ( !($result = $db->sql_query($sql.$secure_sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update users password'.$sql." + hidden password sql", '', __LINE__, __FILE__, $sql);
		}
		if ( $updated = $db->sql_affectedrows($result) )
		{
			$template->assign_var("CLOSE_POPUP", "onLoad='setTimeout(window.close, 5000)'");
		} else
		{
			$error=true;
			$error_msg .= $lang['Current_password_mismatch'];
		}
	}
}

if ( $error )
{
	$template->set_filenames(array(
		'reg_header' => 'error_body.tpl'));
	$template->assign_vars(array(
			'ERROR_MESSAGE' => $error_msg));
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

// default view
$gen_simple_header = TRUE; 
$page_title = $lang['Password']; 
include($phpbb_root_path . 'includes/page_header.'.$phpEx); 
if ($updated)
{
	$template->set_filenames(array( 
      	'body' => 'privmsgs_popup.tpl')); 
	$template->assign_vars(array( 
		'L_MESSAGE' => $lang['Passwd_updated']
	));
} else
{
	$template->set_filenames(array( 
      	'body' => 'change_password_popup.tpl')); 
	if (defined('EXTRA_SECURE'))
	{
		$template->assign_block_vars('switch_cur_passwd_on', array());
	}
	if ($userdata['user_passwd_change']=='-9999')
	{
		$message = $lang['Passwd_expired'];
	} else
	{
	$message = sprintf( $lang['Passwd_soon_expired'],$board_config['max_password_age']-intval( (time()-$userdata['user_passwd_change'])/86400));
	}
	$template->assign_vars(array( 
		'USERNAME' => $userdata['username'],
		'SOUND' => $phpbb_root_path."sounds/gun.mid",
		'L_CUR_PASSWORD' => $lang['Current_password'],
		'L_NEW_PASSWORD' => $lang['New_password'],
		'L_CONFIRM_PASSWORD' => $lang['Confirm_password'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_CHANGE_PASSWD' => $Lang['Passwd_title'],
	      'L_CLOSE_WINDOW' => $lang['Close_window'], 
      	'L_WELCOME' => $message,
		'S_ACTION' => append_sid('change_password.'.$phpEx)
	 )); 
}
$template->pparse('body'); 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>