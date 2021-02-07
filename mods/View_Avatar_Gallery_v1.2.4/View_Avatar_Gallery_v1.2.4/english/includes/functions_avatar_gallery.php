<?php

/***************************************************************************
*                    $RCSfile: functions_avatar_gallery.php,v $
*                            -------------------
*   copyright            : (C) 2005 Azharh
*   email                : azharh.ort@gmail.com
*
*   $Id: functions_avatar_gallery.php, v 1.2.4 2005/11/25 18:26:00 azharh Exp $
*   
*
***************************************************************************/

/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/


if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

/***************************************************************************
*                       function user_avatar_gallery ()
*                            -------------------
*   args : avatar file name, category, confirm (boolean)
*   return : SQL update query (false) or avatar location (true)
*
*   This function returns a part of the SQL update query if the boolean
*   given is true. If it's false, the path location of the image is given.
*
***************************************************************************/
function user_avatar_gallery($avatar_filename, $avatar_category, $avatar_confirm)
{
	global $board_config, $current_template_path;

	$avatar_filename = phpbb_ltrim(basename($avatar_filename), "'");
	$avatar_category = phpbb_ltrim(basename($avatar_category), "'");
	
	if(!preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $avatar_filename))
	{
		return '';
	}

	if ($avatar_filename == "" || $avatar_category == "")
	{
		return '';
	} 

	if ( file_exists(@phpbb_realpath($board_config['avatar_gallery_path'] . '/' . $avatar_category . '/' . $avatar_filename)) && ($avatar_confirm == false) )
	{
		$return = " user_avatar = '" . str_replace("\'", "''", $avatar_category . '/' . $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_GALLERY;
	}
	else if ( file_exists(@phpbb_realpath($board_config['avatar_gallery_path'] . '/' . $avatar_category . '/' . $avatar_filename)) && ($avatar_confirm == true) )
	{
		$return = $current_template_path . $board_config['avatar_gallery_path'] . '/' . str_replace("\'", "''", $avatar_category . '/' . $avatar_filename);
	}
	else
	{
		$return = '';
	}
	return $return;
}

/***************************************************************************
*                       function display_avatar_gallery ()
*                            -------------------
*   args : avatar category, [user] id, [avatar choice] enabled (0 or 1), version, year
*   return : none
*
*   This function displays the variables used to display the avatar gallery.
*   If $enabled is set to 1, the avatars are clickable and thus can be chosen
*   to replace the user's current one.
*
***************************************************************************/
function display_avatar_gallery(&$category, $id, $enabled, $version, $year)
{
	global $board_config, $db, $template, $lang, $images, $theme;
	global $phpbb_root_path, $phpEx;

	$dir = @opendir($board_config['avatar_gallery_path']);

	$avatar_images = array();
	while( $file = @readdir($dir) )
	{
		if( $file != '.' && $file != '..' && !is_file($board_config['avatar_gallery_path'] . '/' . $file) && !is_link($board_config['avatar_gallery_path'] . '/' . $file) )
		{
			$sub_dir = @opendir($board_config['avatar_gallery_path'] . '/' . $file);

			$avatar_row_count = 0;
			$avatar_col_count = 0;
			while( $sub_file = @readdir($sub_dir) )
			{
				if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $sub_file) )
				{
					$avatar_images[$file][$avatar_row_count][$avatar_col_count] = $sub_file; 
					$avatar_name[$file][$avatar_row_count][$avatar_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $sub_file)));

					$avatar_col_count++;
					if( $avatar_col_count == 5 )
					{
						$avatar_row_count++;
						$avatar_col_count = 0;
					}
				}
			}
            /* This part of the code corrects the phpBB's graphical bug (at the end of the avatar's categories) */ 
            while ( ($avatar_col_count !=0) && ($avatar_col_count != 5) && ($avatar_col_count < 5) )
            {
                $avatar_images[$file][$avatar_row_count][$avatar_col_count] = '';
                $avatar_col_count++;
            }
		}
	}

	@closedir($dir);

	@ksort($avatar_images);
	@reset($avatar_images);

	if( empty($category) )
	{
		list($category, ) = each($avatar_images);
	}
	@reset($avatar_images);

    $template->set_filenames(array('body' => 'avatar_gallery_body.tpl'));

	$s_categories = '<select name="avatarcategory" onChange="this.form.submit()">';
	while( list($key) = each($avatar_images) )
	{
		$selected = ( $key == $category ) ? ' selected="selected"' : '';
		if( count($avatar_images[$key]) )
		{
			$s_categories .= '<option value="' . $key . '"' . $selected . '>' . ucfirst($key) . '</option>';
		}
	}
	$s_categories .= '</select>';

	$s_colspan = 0;
	for($i = 0; $i < count($avatar_images[$category]); $i++)
	{
		$template->assign_block_vars('avatar_row', array());

		$s_colspan = max($s_colspan, count($avatar_images[$category][$i]));

		for($j = 0; $j < count($avatar_images[$category][$i]); $j++)
		{   
                $template->assign_block_vars('avatar_row.avatar_column', array(
                    'AVATAR' => ($avatar_images[$category][$i][$j] == '') ? '&nbsp;' : '<img src="' . $board_config['avatar_gallery_path'] . '/' . $category . '/' . $avatar_images[$category][$i][$j] . '" alt="' . $avatar_name[$category][$i][$j] . '" title="' . $avatar_name[$category][$i][$j]  . '" border="0" />',
                    'CHOICE_SUBMIT' => ( ($enabled != '1') || ($id == ANONYMOUS) || ($avatar_images[$category][$i][$j] == '') ) ? '' : '<a href="' . $phpbb_root_path . 'avatar_gallery.' . $phpEx . '?mode=choose&amp;choice=' . $avatar_images[$category][$i][$j] . '&amp;avatarcategory=' . $category .'">',
                    'CHOICE_SUBMIT_END' =>( ($enabled != '1') || ($id == ANONYMOUS) || ($avatar_images[$category][$i][$j] == '') ) ? '' : '</a>')
                );
		}
	}

	$template->assign_vars(array(
		'L_AVATAR_GALLERY' => $lang['Avatar_gallery'],
		'L_GO' => $lang['Select'],        
		'L_CATEGORY' => $lang['Select_category'], 
		'S_CATEGORY_SELECT' => $s_categories, 
		'S_COLSPAN' => $s_colspan,
		'AVATAR_CHOICE_ENABLED_EXPLAIN' => ( ($enabled != '1') || ($id == ANONYMOUS) ) ? $lang['Avatar_choice_enabled_no'] : $lang['Avatar_choice_enabled_yes'],
		'AVT_GLR_POST' => $phpbb_root_path . 'avatar_gallery.' . $phpEx,
		'AVATAR_GALLERY_COPY' => sprintf($lang['Avatar_gallery_copyright'], $version, $year))
	);

	return;
}

?>