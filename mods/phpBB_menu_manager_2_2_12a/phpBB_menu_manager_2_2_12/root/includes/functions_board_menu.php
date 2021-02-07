<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function get_menu_cat_names()
{
	global $db, $lang;

	// Prepage links from main language
	$arraykey = array();
	$arraylang = array();

	array_multisort($lang);

	foreach($lang as $key => $value)
	{
		if ( $value{0} > chr(64) && $value{0} < chr(91) && !is_array($value) && !strpos($value, '%s') && !strpos($value, '%d'))
		{
			$arraykey[] = str_replace("\n", '', $key);
		}
	}

	$cat_names = '<select name="cat_name">';
	for ( $i = 0; $i < count($arraykey); $i++)
	{
		$langnames = ( strlen($lang[$arraykey[$i]]) >= 31 ) ? substr($lang[$arraykey[$i]],0,30).'...' : $lang[$arraykey[$i]];
		$cat_names .= '<option value="'.($arraykey[$i]).'">'.$langnames.'</option>';
	}
	$cat_names .= '</select>';

	return $cat_names;
}

function get_menu_language_names()
{
	global $db, $lang;

	// Prepage links from main language
	$arraykey = array();
	$arraylang = array();

	$arraylang = $lang;
	array_multisort($arraylang);

	foreach(array_keys(array_unique($arraylang)) as $key)
	{
		if ( substr($lang[$key],0,1) > chr(64) && substr($lang[$key],0,1) < chr(91) && !is_array($lang[$key]) && !strpos($lang[$key], '%s') && !strpos($lang[$key], '%d') )
		{
			$arraykey[] = str_replace("\n", '', $key);
		}
	}

	$bl_names = '<select name="bl_name">';
	for ( $i = 0; $i < count($arraykey); $i++)
	{
		$langnames = ( strlen($lang[$arraykey[$i]]) >= 31 ) ? substr($lang[$arraykey[$i]],0,30).'...' : $lang[$arraykey[$i]];
		$bl_names .= '<option value="'.($arraykey[$i]).'">'.$langnames.'</option>';
	}
	$bl_names .= '</select>';

	return $bl_names;
}

function get_menu_images()
{
	global $db, $userdata;

	$link_images_dir = get_bl_theme();
	$link_images = array();

	$dir = @opendir($link_images_dir);

	while($file = @readdir($dir))
	{
		if( !@is_dir($link_images_dir . $file) && substr($file,0,1) != '.' )
		{
			$link_images[] = $file;
		}
	}
	@closedir($dir);

	sort($link_images);

	$bl_images = '<select name="bl_img"><option value="---"></option>';
	foreach ($link_images as $bl_image)
	{
		$bl_images .= '<option value="'.$bl_image.'">'.$bl_image.'</option>';
	}
	$bl_images .= '</select>';

	return $bl_images;
}

function get_bl_access()
{
	global $lang;

	// Prepare Access Levels
	$bl_levels = '<select name="bl_level">';
	$bl_levels .= '<option value="'.ANONYMOUS.'" SELECTED>'.$lang['Bl_guest'].'</option>';
	$bl_levels .= '<option value="'.USER.'">'.$lang['Bl_user'].'</option>';
	$bl_levels .= '<option value="'.MOD.'">'.$lang['Bl_mod'].'</option>';
	$bl_levels .= ( defined('LESS_ADMIN') ) ? '<option value="'.LESS_ADMIN.'">'.$lang['Bl_super_mod'].'</option>' : '';
	$bl_levels .= '<option value="'.ADMIN.'">'.$lang['Bl_admin'].'</option>';
	$bl_levels .= '</select>';

	return $bl_levels;
}

function get_bl_theme()
{
	global $theme;

	$themepath = $theme['template_name'];
	
	return $phpbb_root_path.'templates/'.$themepath.'/images/';
}

function get_bllink_access()
{
	global $userdata;

	$user_level = ( !$userdata['session_logged_in'] || $userdata['user_id'] == ANONYMOUS ) ? ANONYMOUS : $userdata['user_level'];

	$sql_where = '';

	switch ($user_level)
	{
		case ANONYMOUS:
			$sql_where = 'WHERE bl_level = '.ANONYMOUS;
			break;
		case USER:
			$sql_where = 'WHERE bl_level IN ('.ANONYMOUS.', '.USER.')';
			break;
		case MOD:
			$sql_where = 'WHERE bl_level IN ('.ANONYMOUS.', '.USER.', '.MOD.')';
			break;
		case LESS_ADMIN:
			$sql_where = 'WHERE bl_level IN ('.ANONYMOUS.', '.USER.', '.MOD.', '.LESS_ADMIN.')';
			break;
		case ADMIN:
			$sql_where = '';
			break;
		default:
			$sql_where = 'WHERE bl_level = '.ANONYMOUS;
			break;
	}

	return $sql_where;
}

function reorder_menu_links($position, $user_id = -99)
{
	global $db, $userdata;

	$user = ( $user_id == -99 ) ? $userdata['user_id'] : $user_id;
	$user = intval($user);

	if ( $position == 'board' )
	{
		$sql = "SELECT board_link FROM " . USER_BOARD_LINKS_TABLE . "
			WHERE user_id = $user
			ORDER BY board_sort";
		if( !$result = $db->sql_query ($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not reorder board menu links', '', __LINE__, __FILE__, $sql);
		}
		else
		{
			$j = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$board_correct_sort = $row['board_link'];
				$j += 10;
				$sql_updates = "UPDATE " . USER_BOARD_LINKS_TABLE . "
						SET board_sort = $j
						WHERE user_id = $user
						AND board_link = $board_correct_sort";
				if( !$result_updates = $db->sql_query ($sql_updates) )
				{
					message_die(GENERAL_ERROR, 'Could not reorder board menu links', '', __LINE__, __FILE__, $sql_updates);
				}
			}
		}
	}
	else if ( $position == 'portal' )
	{
		$sql = "SELECT portal_link FROM " . USER_PORTAL_LINKS_TABLE . "
			WHERE user_id = $user
			ORDER BY portal_sort";
		if( !$result = $db->sql_query ($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not reorder portal menu links', '', __LINE__, __FILE__, $sql);
		}
		else
		{
			$j = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$portal_correct_sort = $row['portal_link'];
				$j += 10;
				$sql_updates = "UPDATE " . USER_PORTAL_LINKS_TABLE . "
						SET portal_sort = $j
						WHERE user_id = $user
						AND portal_link = $portal_correct_sort";
				if( !$result_updates = $db->sql_query ($sql_updates) )
				{
					message_die(GENERAL_ERROR, 'Could not reorder portal menu links', '', __LINE__, __FILE__, $sql_updates);
				}
			}
		}
	}

	return;
}

?>