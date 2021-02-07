<?php
/***************************************************************************
 *                              admin_amazon.php
 *                            -------------------
 *   begin                : Thursday, 5th May 2005
 *   email                : mod@dvdsandstuff.net
 *
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
 
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
   $filename = basename(__FILE__);
   $module['Amazon_MOD']['Amazon_Settings'] = $filename;

   return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path.'language/lang_' . $board_config['default_lang'] . '/lang_amazon.'.$phpEx);

if( isset($HTTP_POST_VARS['save']) || isset($HTTP_GET_VARS['save']))
	{
		$mode = "save";
	}
	else
	{
		$mode = "";
	}

if( $mode == "save" )
{
			$amazon_id = ( isset($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : 0;
        	$amazon_country = ( isset($HTTP_POST_VARS['amazon']) ) ? trim($HTTP_POST_VARS['amazon']) : "";
        	$amazon_normal = ( isset($HTTP_POST_VARS['normal']) ) ? trim($HTTP_POST_VARS['normal']) : "";
        	$amazon_announce = ( isset($HTTP_POST_VARS['announce']) ) ? trim($HTTP_POST_VARS['announce']) : "";
			$amazon_sticky = ( isset($HTTP_POST_VARS['sticky']) ) ? trim($HTTP_POST_VARS['sticky']) : "";
        	$amazon_username = ( isset($HTTP_POST_VARS['username']) ) ? trim($HTTP_POST_VARS['username']) : "";
        	$amazon_enable = ( isset($HTTP_POST_VARS['enable']) ) ? trim($HTTP_POST_VARS['enable']) : "";
			$amazon_window = ( isset($HTTP_POST_VARS['newwindow']) ) ? trim($HTTP_POST_VARS['newwindow']) : "";
			$amazon_images = ( isset($HTTP_POST_VARS['images']) ) ? trim($HTTP_POST_VARS['images']) : "";
			
		if ($amazon_id == 1)
		{
		$sql = "UPDATE ".AMAZON_CONFIG_TABLE."
				SET amazon = '" . str_replace("\'", "''", $amazon_country) . "', username = '" . str_replace("\'", "''", $amazon_username) . "', announce = '" . intval($amazon_announce) . "', sticky = '" . intval($amazon_sticky) . "', normal = '" . intval($amazon_normal) . "', enable = '" . intval($amazon_enable) . "', window = '" . intval($amazon_window) . "', images = '" . str_replace("\'", "''", $amazon_images) . "'
				WHERE amazon_id = " . intval($amazon_id) . "";
			$message = $lang['Amazon_DBase_Ok'];
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Amazon_Choose_Err']);
		}
		
		if(!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, $lang['Amazon_Sql_Base_Error'], $lang['Error'], __LINE__, __FILE__, $sql);
		}
		
		$message .= "<br /><br />" . sprintf($lang['Amazon_Click_Return'], "<a href=\"" . append_sid("admin_amazon.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	
	$template->assign_vars(array(
			"L_PAGE_DESC" => $lang['Amazon_Page_Desc'],
         	"L_PAGE_TITLE" => $lang['Amazon_Page_Title'],
           	"L_EDITING_TITLE" => $lang['Amazon_Edit'],
            "L_COUNTRY" => $lang['Amazon_Country'],
        	"L_POSTS" => $lang['Amazon_Posts'],
     		"L_NORMAL" => $lang['Amazon_Normal'],
			"L_STICKY" => $lang['Amazon_Sticky'],
			"L_ANNOUNCE" => $lang['Amazon_Announce'],
			"L_USERNAME" => $lang['Amazon_Username'],
			"L_ENABLE" => $lang['Amazon_Enable'],
			"L_CHOOSE" => $lang['Amazon_Choose'],
			"L_UK" => $lang['Amazon_UK'],
			"L_US" => $lang['Amazon_US'],
			"L_CANADA" => $lang['Amazon_Canada'],
			"L_FRANCE" => $lang['Amazon_France'],
			"L_GERMANY" => $lang['Amazon_Germany'],
			"L_JAPAN" => $lang['Amazon_Japan'],
			"L_AFFILIATE" => $amazon_info['username'],
	        "L_SAVE" => "Save")
		);
		
		$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

}
else
{
		$template->set_filenames(array(
			"body" => "admin/amazon_admin_body.tpl")
		);
				$sql = "SELECT * FROM ".AMAZON_CONFIG_TABLE." WHERE amazon_id = 1";
			if(!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, $lang['Amazon_Sql_Error'], $lang['Error'], __LINE__, __FILE__, $sql);
				}
				else
				{
					
		$amazon_info = $db->sql_fetchrow($result);
		
		if ($amazon_info['normal'] == 1)
			{
			$enable_normal = "checked=\"checked\"";
			}
			
		if ($amazon_info['sticky'] == 1)
			{
			$enable_sticky = "checked=\"checked\"";
			}
			
		if ($amazon_info['announce'] == 1)
			{
			$enable_announce = "checked=\"checked\"";
			}
			
		if ($amazon_info['enable'] == 1)
			{
			$enable_amazon = "checked=\"checked\"";
			}
			
		if ($amazon_info['amazon'] == 0)
			{
			$enable_uk = "selected=\"selected\"";
			}
			
		if ($amazon_info['amazon'] == 1)
			{
			$enable_us = "selected=\"selected\"";
			}
			
		if ($amazon_info['amazon'] == 2)
			{
			$enable_canada = "selected=\"selected\"";
			}
			
		if ($amazon_info['amazon'] == 3)
			{
			$enable_germany = "selected=\"selected\"";
			}
			
		if ($amazon_info['amazon'] == 4) 
			{
			$enable_france = "selected=\"selected\"";
			}
			
		if ($amazon_info['amazon'] == 5)
			{
			$enable_japan = "selected=\"selected\"";
			}
			
		if ($amazon_info['window'] == 1)
			{
			$enable_window = "checked=\"checked\"";
			}
		
		$template->assign_vars(array(
			"L_PAGE_DESC" => $lang['Amazon_Page_Desc'],
         	"L_PAGE_TITLE" => $lang['Amazon_Page_Title'],
           	"L_EDITING_TITLE" => $lang['Amazon_Edit'],
			"L_SELECTED" => $lang['Amazon_Selected'],
            "L_COUNTRY" => $lang['Amazon_Country'],
        	"L_POSTS" => $lang['Amazon_Posts'],
     		"L_NORMAL" => $lang['Amazon_Normal'],
			"L_STICKY" => $lang['Amazon_Sticky'],
			"L_ANNOUNCE" => $lang['Amazon_Announce'],
			"L_USERNAME" => $lang['Amazon_Username'],
			"L_ENABLE" => $lang['Amazon_Enable'],
			"L_CHOOSE" => $lang['Amazon_Choose'],
			"L_UK" => $lang['Amazon_UK'],
			"L_US" => $lang['Amazon_US'],
			"L_CANADA" => $lang['Amazon_Canada'],
			"L_FRANCE" => $lang['Amazon_France'],
			"L_GERMANY" => $lang['Amazon_Germany'],
			"L_JAPAN" => $lang['Amazon_Japan'],
			"L_AFFILIATE" => $amazon_info['username'],
			"L_INFO_TEXT" => $lang['Amazon_Info_Text'],
			"L_WINDOW" => $lang['Amazon_New_Window'],
			"L_CREATED_BY" => $lang['Amazon_Created_By'],
			"L_IMAGES" => $lang['Amazon_Image'],
			"S_IMAGE_LOCATION" => $amazon_info['images'],
			"S_ENABLED_NORMAL" => $enable_normal,
			"S_ENABLED_STICKY" => $enable_sticky,
			"S_ENABLED_ANNOUNCE" => $enable_announce,
			"S_ENABLED_AMAZON" => $enable_amazon,
			"S_UK_SELECTED" => $enable_uk,
			"S_US_SELECTED" => $enable_us,
			"S_CANADA_SELECTED" => $enable_canada,
			"S_GERMANY_SELECTED" => $enable_germany,
			"S_FRANCE_SELECTED" => $enable_france,
			"S_JAPAN_SELECTED" => $enable_japan,
			"S_ENABLE_WINDOW" => $enable_window,
	        "L_SAVE" => $lang['Amazon_Save'])
		);
		
		$template->pparse("body");
		
		include('./page_footer_admin.'.$phpEx);
	}
}
?>