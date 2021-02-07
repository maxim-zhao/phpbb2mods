<?php
/*-----------------------------------------------------------------------------
    Visual Confirmation on New Posters - A phpBB Add-On
  ----------------------------------------------------------------------------
    config.php
       Admin Configuration Script
    File Version: 2.0.0
    Begun: December 11, 2006                 Last Modified: March 7, 2007
  ----------------------------------------------------------------------------
    Copyright 2006 by Jeremy Rogers.  Please read the license.txt included
    with the phpBB Add-On listed above for full license and copyright details.
-----------------------------------------------------------------------------*/

if( !defined('IN_PHPBB') || !defined('IN_ADMIN') )
{
	die("I really hope you didn't just try to hack this server.");
}

require_once($phpbb_root_path . 'mods/vc_newposts/constants.' . $phpEx);
require_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_vc_newposts.' . $phpEx);

// Continue processing begun in admin/admin_board.php...
$template->set_filenames(array('vc_newposts' => 'admin/vc_newposts.tpl'));

// Build user type selection
// This is not the cleanest way to do it, but it'll work.
$selected0 = ( $new['vcnewposts_enable'] == NO_USERS ) ? 'selected="selected"': '';
$selected1 = ( $new['vcnewposts_enable'] == ALL_USERS ) ? 'selected="selected"': '';
$selected2 = ( $new['vcnewposts_enable'] == GUESTS ) ? 'selected="selected"': '';
$selected3 = ( $new['vcnewposts_enable'] == REG_USERS ) ? 'selected="selected"': '';

$user_select = '
<select name="vcnewposts_enable">
	<option value="' . NO_USERS . '" ' . $selected0 . '>' . $lang['VCNP_NONE'] . '</option>
	<option value="' . ALL_USERS . '" ' . $selected1 . '>' . $lang['VCNP_ALL'] . '</option>
	<option value="' . GUESTS . '" ' . $selected2 . '>' . $lang['VCNP_GUESTS'] . '</option>
	<option value="' . REG_USERS . '" ' . $selected3 . '>' . $lang['VCNP_REGGED'] . '</option>
</select>';

// Build Captcha type selection.
// Also not the cleanest way, but again... she works.
$selected0 = ( $new['vcnewposts_type'] == CAPTCHA_STANDARD ) ? 'selected="selected"': '';

$type_select = '<select name="vcnewposts_type">
	<option value="' . CAPTCHA_STANDARD . '" ' . $selected0 . '>' . $lang['VCNP_STANDARD'] . '</option>
';

/* 
// Advanced Visual Confirmation 
// I don't really need this right now, but might in the future if AVC's features
// or captcha generation ever changes.
if( defined('CAPTCHA_CONFIG_TABLE') )
{
	$selected1 = ( $new['vcnewposts_type'] == CAPTCHA_AVC ) ? 'selected="selected"': '';
	$type_select .= '<option value="' . CAPTCHA_AVC . '" ' . $selected1 . '>' . $lang['VCNP_AVC'] . '</option>';
}
*/

// Is Freecap confirmation installed?
if( GD_INSTALLED && ZLIB_INSTALLED && file_exists($phpbb_root_path . PATH_FREECAP) )
{
	// Yep, put it in the list.
	$selected2 = ( $new['vcnewposts_type'] == CAPTCHA_FREECAP ) ? 'selected="selected"': '';
	$type_select .= '<option value="' . CAPTCHA_FREECAP . '" ' . $selected2 . '>' . $lang['VCNP_FREECAP'] . '</option>';
}

// Is Photo Confirmation installed?
if( GD_INSTALLED && file_exists($phpbb_root_path . PATH_PHOTO) )
{
	// Yep, put it in the list.
	$selected3 = ( $new['vcnewposts_type'] == CAPTCHA_PHOTO ) ? 'selected="selected"': '';
	$type_select .= '<option value="' . CAPTCHA_PHOTO . '" ' . $selected3 . '>' . $lang['VCNP_PHOTO'] . '</option>';
}

// Is Better Captcha installed?
if( GD_INSTALLED && file_exists($phpbb_root_path . PATH_BETTER) )
{
	// Yep, put it in the list.
	$selected4 = ( $new['vcnewposts_type'] == CAPTCHA_BETTER ) ? 'selected="selected"': '';
	$type_select .= '<option value="' . CAPTCHA_BETTER . '" ' . $selected4 . '>' . $lang['VCNP_BETTER'] . '</option>';
}

// End building of select list
$type_select .= '</select>';

$template->assign_vars(array(
	'L_VCNP_TITLE'				=> $lang['VCNP_TITLE'],
	'L_VCNP_USER_TYPE'			=> $lang['VCNP_USER_TYPE'],
	'L_VCNP_TYPE'				=> $lang['VCNP_TYPE'],
	'L_VCNP_WEB'				=> $lang['VCNP_WEB'],
	'L_VCNP_WEB_EXPLAIN'		=> $lang['VCNP_WEB_EXPLAIN'],
	'L_VCNP_RANDOMS'			=> $lang['VCNP_RANDOMS'],
	'L_VCNP_RANDOMS_EXPLAIN'	=> $lang['VCNP_RANDOMS_EXPLAIN'],
	'L_VCNP_MIN_TO'				=> $lang['VCNP_MIN_TO'],
	'L_VCNP_MAX'				=> $lang['VCNP_MAX'],
	'L_VCNP_RAND5'				=> $lang['VCNP_RAND5'],
	'L_VCNP_RAND1-2'			=> $lang['VCNP_RAND1-2'],
	'L_VCNP_RAND3-4'			=> $lang['VCNP_RAND3-4'],
	'L_VCNP_POSTS'				=> $lang['VCNP_POSTS'],
	'L_VCNP_POSTS_EXPLAIN'		=> $lang['VCNP_POSTS_EXPLAIN'],
	'WEBCHECK_YES'	=> ( $new['vcnewposts_webcheck']) ? 'checked="checked"' : '',
	'WEBCHECK_NO'	=> (!$new['vcnewposts_webcheck']) ? 'checked="checked"' : '',
	'VCNEWPOSTS_RAND1'			=> $new['vcnewposts_rand1'],
	'VCNEWPOSTS_RAND2'			=> $new['vcnewposts_rand2'],
	'VCNEWPOSTS_RAND3'			=> $new['vcnewposts_rand3'],
	'VCNEWPOSTS_RAND4'			=> $new['vcnewposts_rand4'],
	'VCNEWPOSTS_RAND5'			=> $new['vcnewposts_rand5'],
	'VCNEWPOSTS_MAX_POSTS'		=> $new['vcnewposts_max_posts'],
	'USER_SELECT'				=> $user_select,
	'TYPE_SELECT'				=> $type_select
));

$template->assign_var_from_handle('VC_NEWPOSTS', 'vc_newposts');

// And now, back to admin_board.php....
?>