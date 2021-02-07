<?php
/***************************************************************************
 *                            profile_options.php
 *                            -------------------
 *	begin				: 11/08/2003
 *	copyright			: Ptirhiik
 *	email				: admin@rpgnet-fr.com
 *
 *	version				: 1.0.5 - 21/10/2003
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);
//
// End session management
//
if ( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=profile_options.$phpEx", true));
}

// constant
if (!isset($nav_separator))
{
	$nav_separator = '&nbsp;->&nbsp;';
}

// functions
function is_auth($field_level, $user_level)
{
	$res = false;
	if ( $user_level == ADMIN )
	{
		$res = true;
	}
	else if ( ($field_level == USER) || empty($field_level) )
	{
		$res = true;
	}
	return $res;
}

// get the view userdata
$view_user_id = '';
if ( isset($HTTP_POST_VARS['view_user_id']) || isset($HTTP_GET_VARS[POST_USERS_URL]) )
{
	$view_user_id = isset($HTTP_POST_VARS['view_user_id']) ? intval($HTTP_POST_VARS['view_user_id']) : intval($HTTP_GET_VARS[POST_USERS_URL]);
}
$view_userdata = array();
if ( empty($view_user_id) || ($view_user_id == ANONYMOUS) )
{
	$view_user_id = $userdata['user_id'];
	$view_userdata = $userdata;
}
else
{
	$sql = "SELECT * FROM " . USERS_TABLE . " WHERE user_id=$view_user_id";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Failed to read user', '', __LINE__, __FILE__, $sql);
	}
	if ( !$view_userdata = $db->sql_fetchrow($result) )
	{
		message_die(GENERAL_INFO, $lang['No_such_user']);
	}
}

// get the user level
$user_level = $userdata['user_level'];
if ($user_level == MOD)
{
	if ($view_userdata['user_level'] == ADMIN)
	{
		$user_level = USER;
	}
	else
	{
		// verify if the user is really a moderator (phpBB lack)
		$sql = "SELECT * FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug 
				WHERE ug.user_id = " . $userdata['user_id'] . " 
					AND aa.group_id = ug.group_id 
					AND aa.auth_mod = 1
					AND ug.user_pending = 0
				LIMIT 0, 1";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain moderator status', '', __LINE__, __FILE__, $sql);
		}
		if ( $db->sql_numrows($result) <= 0 )
		{
			$user_level = USER;
		}
	}
}

// check auth level
if ( ($view_user_id != $userdata['user_id']) && ($userdata['user_level'] != ADMIN) )
{
	message_die(GENERAL_INFO, $lang['Wrong_Profile']);
}

// create entry if NULL : fix isset issue
@reset($view_userdata);
while (list($key, $data) = each($view_userdata) )
{
	if ($view_userdata[$key] == NULL )
	{
		$view_userdata[$key] = '';
	}
}

//
// get all the mods settings
//
$mods = array();
$dir = @opendir($phpbb_root_path . 'includes/mods_settings');
while( $file = @readdir($dir) )
{
	if( preg_match("/^mod_.*?\." . $phpEx . "$/", $file) )
	{
		include($phpbb_root_path . 'includes/mods_settings/' . $file);
	}
}
@closedir($dir);

// main_menu
$menu_name = '';
if ( isset($HTTP_POST_VARS['data']) || isset($HTTP_GET_VARS['data']) )
{
	$menu_name = isset($HTTP_POST_VARS['data']) ? $HTTP_POST_VARS['data'] : $HTTP_GET_VARS['data'];
}
if ( empty($menu_name) )
{
	$menu_name = 'Preferences';
}
else if ( !isset($mods[$menu_name]['data']) )
{
	// no mods
	$menu_name = '';
}

// mod_id
$mod_id = 0;
if ( isset($HTTP_GET_VARS['mod']) || isset($HTTP_POST_VARS['mod_id']) )
{
	$mod_id = isset($HTTP_POST_VARS['mod_id']) ? intval($HTTP_POST_VARS['mod_id']) : intval($HTTP_GET_VARS['mod']);
}

// sub_id
$sub_id = 0;
if ( isset($HTTP_GET_VARS['msub']) || isset($HTTP_POST_VARS['mod_sub_id']) )
{
	$sub_id = isset($HTTP_POST_VARS['mod_sub_id']) ? intval($HTTP_POST_VARS['mod_sub_id']) : intval($HTTP_GET_VARS['msub']);
}

// build a key array
$mod_keys = array();
$mod_sort = array();
$sub_keys = array();
$sub_sort = array();
@reset($mods[$menu_name]['data']);
while ( list($mod_name, $mod) = @each($mods[$menu_name]['data']) )
{
	// check if there is some users fields
	$found = false;
	@reset($mod['data']);
	while ( list($sub_name, $sub) = @each($mod['data']) )
	{
		@reset($sub['data']);
		while ( list($field_name, $field) = @each($sub['data']) )
		{
			if ( ( ( !empty($field['user']) && isset($view_userdata[ $field['user'] ]) && !$board_config[ $field_name . '_over'] ) || $field['system'] ) && is_auth($field['auth'], $user_level) )
			{
				$found=true;
				break;
			}
		}
	}
	if ($found)
	{
		$i = count($mod_keys);
		$mod_keys[$i] = $mod_name;
		$mod_sort[$i] = $mod['sort'];

		// init sub levels
		$sub_keys[$i] = array();
		$sub_sort[$i] = array();

		// sub names
		@reset($mod['data']);
		while ( list($sub_name, $sub) = @each($mod['data']) )
		{
			if ( !empty($sub_name) )
			{
				// user fields in this level
				$found = false;
				@reset($sub['data']);
				while ( list($field_name, $field) = @each($sub['data']) )
				{
					if ( ( ( !empty($field['user']) && isset($view_userdata[ $field['user'] ]) && !$board_config[ $field_name . '_over'] ) || $field['system'] ) && is_auth($field['auth'], $user_level) )
					{
						$found=true;
						break;
					}
				}
				if ($found)
				{
					$sub_keys[$i][] = $sub_name;
					$sub_sort[$i][] = $sub['sort'];
				}
			}
		}
		@array_multisort($sub_sort[$i], $sub_keys[$i]);
	}
}
@array_multisort($mod_sort, $mod_keys, $sub_sort, $sub_keys);

// fix mod id
if ( $mod_id > count($mod_keys) )
{
	$mod_id = 0;
}
if ( $sub_id > count($sub_keys[$mod_id]) )
{
	$sub_id = 0;
}

// mod name
$mod_name = $mod_keys[$mod_id];

// sub name
$sub_name = $sub_keys[$mod_id][$sub_id];

// get the session id
$sid = '';
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}

// buttons
$submit = isset($HTTP_POST_VARS['submit']);

// validate
if ($submit)
{
	// session id check
	if ($sid != $userdata['session_id'])
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}

	// init for error
	$error = false;
	$error_msg = '';

	// format and verify data
	@reset($mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data']);
	while ( list($field_name, $field) = @each($mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data']) )
	{
		$user_field = $field['user'];
		if ( isset($HTTP_POST_VARS[$user_field]) && is_auth($field['auth'], $user_level) )
		{
			switch ($field['type'])
			{
				case 'LIST_RADIO':
				case 'LIST_DROP':
					$$user_field = $HTTP_POST_VARS[$user_field];
					if (!in_array($$user_field, $mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data'][$field_name]['values']))
					{
						$error = true;
						$msg = mods_settings_get_lang( $mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data'][$field_name]['lang_key'] );
						$error_msg = (empty($error_msg) ? '' : '<br />') . $lang['Error'] . ':&nbsp;' . $msg;
					}
					break;
				case 'TINYINT':
				case 'SMALLINT':
				case 'MEDIUMINT':
				case 'INT':
					$$user_field = intval($HTTP_POST_VARS[$user_field]);
					break;
				case 'VARCHAR':
				case 'TEXT':
				case 'DATEFMT':
					$$user_field = trim(str_replace("\'", "''", htmlspecialchars($HTTP_POST_VARS[$user_field])));
					break;
				case 'HTMLVARCHAR':
				case 'HTMLTEXT':
					$$user_field = trim(str_replace("\'", "''", $HTTP_POST_VARS[$user_field]));
					break;
				default:
					$$user_field = '';
					if ( !empty($field['chk_func']) && function_exists($field['chk_func']) )
					{
						$$user_field = $field['chk_func']($user_field, $HTTP_POST_VARS[$user_field]);
					}
					else
					{
						message_die(GENERAL_ERROR, 'Unknown type of config data : ' . $mod_name, '', __LINE__, __FILE__, '');
					}
					break;
			}
			if ($error)
			{
				$ret_link = append_sid("./profile_options.$phpEx?sub=$menu_name&mod=$mod_id&msub=$sub_id&" . POST_USERS_URL . "=$view_user_id");
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . $ret_link . '">')
				);
				$message = $error_msg . '<br /><br />' . sprintf($lang['Click_return_preferences'], '<a href="' . $ret_link . '">', '</a>') . '<br /><br />';
				message_die(GENERAL_MESSAGE, $message);
			}
		}
	}

	// save result
	@reset($mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data']);
	while ( list($field_name, $field) = @each($mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data']) )
	{
		$user_field = $field['user'];
		if ( ( ( isset($$user_field) && !empty($user_field) && isset($view_userdata[$user_field]) && !$board_config[ $field_name . '_over'] ) || $field['system'] ) && is_auth($field['auth'], $user_level) )
		{
			// update
			$sql = "UPDATE " . USERS_TABLE . " 
					SET $user_field='" . $$user_field . "'
					WHERE user_id = " . $view_userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Failed to update user configuration for ' . $field['user'], '', __LINE__, __FILE__, $sql);
			}
		}
	}

	// send an update message
	$ret_link = append_sid("./profile_options.$phpEx?sub=$menu_name&mod=$mod_id&msub=$sub_id&" . POST_USERS_URL . "=$view_user_id");
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . $ret_link . '">')
	);
	$message = $lang['Profile_updated'] . '<br /><br />' . sprintf($lang['Click_return_preferences'], '<a href="' . $ret_link . '">', '</a>') . '<br /><br />';
	message_die(GENERAL_MESSAGE, $message);
}
else
{
	// set the page title and include the page header
	$page_title = $lang['Preferences'];
	include ($phpbb_root_path . 'includes/page_header.'.$phpEx);

	// template
	$template->set_filenames(array(
		'body' => 'profile_options_body.tpl')
	);

	// header
	$template->assign_vars(array(
		'L_OPTION'			=> $page_title,
		'U_OPTION'			=> append_sid("./profile_options.$phpEx?sub=$menu_name&mod=$mod_id&" . POST_USERS_URL . "=$view_user_id"),
		'L_MOD_NAME'		=> mods_settings_get_lang($mod_name) . ( !empty($sub_name) ? ' - ' . mods_settings_get_lang($sub_name) : '' ),
		'U_USER'			=> append_sid("./profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=$view_user_id"),
		'L_USER'			=> $view_userdata['username'],
		'L_SUBMIT'			=> $lang['Submit'],
		'L_RESET'			=> $lang['Reset'],
		)
	);

	// send menu
	for ($i=0; $i < count($mod_keys); $i++)
	{
		$template->assign_block_vars('mod', array(
			'CLASS'	=> ($mod_id == $i) ? 'row1' : 'row2',
			'ALIGN'	=> ( ($mod_id == $i) && (count($sub_keys[$i]) > 1) ) ? 'left' : 'center',
			'U_MOD'	=> append_sid("./profile_options.$phpEx?sub=$menu_name&mod=$i&" . POST_USERS_URL . "=$view_user_id"),
			'L_MOD'	=> sprintf( (($mod_id == $i) ? '<b>%s</b>' : '%s'), mods_settings_get_lang($mod_keys[$i]) ),
			)
		);
		if ($mod_id == $i)
		{
			if ( count($sub_keys[$i]) > 1 )
			{
				$template->assign_block_vars('mod.sub', array());
				for ($j=0; $j < count($sub_keys[$i]); $j++)
				{
					$template->assign_block_vars('mod.sub.row', array(
						'CLASS'	=> ($sub_id == $j) ? 'row1' : 'row1',
						'U_MOD' => append_sid("./profile_options.$phpEx?sub=$menu_name&mod=$i&msub=$j&" . POST_USERS_URL . "=$view_user_id"),
						'L_MOD'	=> sprintf( (($sub_id == $j) ? '<b>%s</b>' : '%s'), mods_settings_get_lang($sub_keys[$i][$j]) ),
						)
					);
				}
			}
		}
	}

	// send items
	@reset($mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data']);
	while ( list($field_name, $field) = @each($mods[$menu_name]['data'][$mod_name]['data'][$sub_name]['data']) )
	{
		// process only fields from users table
		$user_field = $field['user'];
		if ( ( ( !empty($user_field) && isset($view_userdata[$user_field]) && !$board_config[ $field_name . '_over'] ) || $field['system'] ) && is_auth($field['auth'], $user_level) )
		{
			// get the field input statement
			$input = '';
			switch ($field['type'])
			{
				case 'LIST_RADIO':
					@reset($field['values']);
					while ( list($key, $val) = @each($field['values']) )
					{
						$selected = ($view_userdata[$user_field] == $val) ? ' checked="checked"' : '';
						$l_key = mods_settings_get_lang($key);
						$input .= '<input type="radio" name="' . $user_field . '" value="' . $val . '"' . $selected . ' />' . $l_key . '&nbsp;&nbsp;';
					}
					break;
				case 'LIST_DROP':
					@reset($field['values']);
					while ( list($key, $val) = @each($field['values']) )
					{
						$selected = ($view_userdata[$user_field] == $val) ? ' selected="selected"' : '';
						$l_key = mods_settings_get_lang($key);
						$input .= '<option value="' . $val . '"' . $selected . '>' . $l_key . '</option>';
					}
					$input = '<select name="' . $user_field . '">' . $input . '</select>';
					break;
				case 'TINYINT':
					$input = '<input type="text" name="' . $user_field . '" maxlength="3" size="2" class="post" value="' . $view_userdata[$user_field] . '" />';
					break;
				case 'SMALLINT':
					$input = '<input type="text" name="' . $user_field . '" maxlength="5" size="5" class="post" value="' . $view_userdata[$user_field] . '" />';
					break;
				case 'MEDIUMINT':
					$input = '<input type="text" name="' . $user_field . '" maxlength="8" size="8" class="post" value="' . $view_userdata[$user_field] . '" />';
					break;
				case 'INT':
					$input = '<input type="text" name="' . $user_field . '" maxlength="13" size="11" class="post" value="' . $view_userdata[$user_field] . '" />';
					break;
				case 'VARCHAR':
				case 'HTMLVARCHAR':
					$input = '<input type="text" name="' . $user_field . '" maxlength="255" size="45" class="post" value="' . $view_userdata[$user_field] . '" />';
					break;
				case 'TEXT':
				case 'HTMLTEXT':
					$input = '<textarea rows="5" cols="45" wrap="virtual" name="' . $user_field . '" class="post">' . $view_userdata[$user_field] . '</textarea>';
					break;
				default:
					$input = '';
					if ( !empty($field['get_func']) && function_exists($field['get_func']) )
					{
						$input = $field['get_func']($user_field, $view_userdata[$user_field]);
					}
					break;
			}

			// dump to template
			$template->assign_block_vars('field', array(
				'L_NAME'	=> mods_settings_get_lang($field['lang_key']),
				'L_EXPLAIN'	=> !empty($field['explain']) ? '<br />' . mods_settings_get_lang($field['explain']) : '',
				'INPUT'		=> $input,
				)
			);
		}
	}

	// system
	$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	$s_hidden_fields .= '<input type="hidden" name="view_user_id" value="' . $view_user_id . '" />';
	$s_hidden_fields .= '<input type="hidden" name="sub" value="' . $menu_name . '" />';
	$s_hidden_fields .= '<input type="hidden" name="mod_id" value="' . $mod_id . '" />';
	$s_hidden_fields .= '<input type="hidden" name="mod_sub_id" value="' . $sub_id . '" />';
	$s_hidden_fields .= '<input type="hidden" name="set" value="add" />';
	$template->assign_vars(array(
		'S_PROFILCP_ACTION' => append_sid("./profile_options.$phpEx"),
		'NAV_SEPARATOR'		=> $nav_separator,
		'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
		)
	);

	// page
	$template->pparse('body');
	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}

?>