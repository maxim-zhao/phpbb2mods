<?php
/***************************************************************************
*                               admin_banner.php
*                              -------------------
*     begin                : Friday, September 10, 2004
*     copyright            : (C) 2004, 2005 Dan Bednarski
*     email                : marioknight@smuncensored.com
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

/**************************************************************************
*	This file will be used for changing the banner of forums.
**************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Change_Banner'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if(isset($HTTP_GET_VARS['change']))
{
	$img_source = htmlspecialchars($HTTP_POST_VARS['banner_source']);
	$img_width = htmlspecialchars($HTTP_POST_VARS['banner_width']);
	$img_height = htmlspecialchars($HTTP_POST_VARS['banner_height']);

	if(!$img_source || !$img_width || !$img_height)
	{
		message_die(GENERAL_ERROR, "No banner image or dimensions was selected, please try again", "", __LINE__, __FILE__);
	}
	$sql_source = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", $img_source) . "' WHERE config_name = 'banner_source'";
	$sql_width = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", $img_width) . "' WHERE config_name = 'banner_width'";
	$sql_height = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . str_replace("\'", "''", $img_height) . "' WHERE config_name = 'banner_height'";

	if( !($result = $db->sql_query($sql_source)) || !($result = $db->sql_query($sql_width)) || !($result = $db->sql_query($sql_height)) )
	{
		message_die(GENERAL_ERROR, "Couldn't change the banner", "", __LINE__, __FILE__, $sql_source, "<br /><br />", $sql_width, "<br /><br />", $sql_height);
	}

	$message = $lang['banner_success'] . "<br /><br />" . sprintf($lang['Click_return_banner'], "<a href=\"" . append_sid("admin_banner.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}
else
{
	$template->set_filenames(array(
		"body" => "admin/banner_change.tpl")
	);

	$template->assign_vars(array(
		"L_BANNER_TITLE" => $lang['banner_title'],
		"L_BANNER_TEXT" => $lang['banner_text'],
		"L_BANNER_CAPTION" => $lang['banner_caption'],
		"L_BANNER_CHOOSE" => $lang['banner_choose'],
		"L_BANNER_SIZE" => $lang['banner_size'],
		"L_BANNER_SIZE_EXPLAIN" => $lang['banner_size_explain'],
		"BANNER_PATH" => $board_config['banner_path'],
		"BANNER_WIDTH" => $board_config['banner_width'],
		"BANNER_HEIGHT" => $board_config['banner_height'],
		"S_BANNER_ACTION" => append_sid("admin_banner.$phpEx?change=" . $banner_images[$i][$j]))
	);

	$dir = @opendir($phpbb_root_path . $board_config['banner_path']);
	$banner_images = array();
	$banner_row_count = 0;
	$banner_col_count = 0;

	while( $file = @readdir($dir) )
	{
		if( $file != '.' && $file != '..' )
		{
			if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $file) )
			{
				$banner_images[$banner_row_count][$banner_col_count] = $file;
				if($banner_images[$banner_row_count][$banner_col_count] == $board_config['banner_source'])
				{
					$checked[$banner_row_count][$banner_col_count] = 'checked';
				}

				$banner_col_count++;
				if( $banner_col_count == $board_config['banner_cols'] )
				{
					$banner_row_count++;
					$banner_col_count = 0;
				}
			}
		}
	}

	@closedir($dir);
	@ksort($banner_images);
	@reset($banner_images);

	for($i = 0; $i < count($banner_images); $i++)
	{
		$template->assign_block_vars("banner_row", array());
		$s_colspan = max($s_colspan, count($banner_images[$i]));

		for($j = 0; $j < count($banner_images[$i]); $j++)
		{
			$template->assign_block_vars('banner_row.banner_column', array(
				"BANNER_IMAGE" => $banner_images[$i][$j])
			);

			$template->assign_block_vars('banner_row.banner_option_column', array(
				"S_OPTIONS_BANNER" => $banner_images[$i][$j],
				"S_CURRENT_BANNER" => $checked[$i][$j])
			);
		}
	}

	$template->pparse("body");
}

include('./page_footer_admin.'.$phpEx);

?>