<?php
/***************************************************************************
 *                                admin/admin_msn.php
 *                            -------------------
 *   begin                : Friday, Jan 13, 2006
 *   copyright            : (C) 2006 Omar Ramadan
 *   email                : princeomz2004@hotmail.com
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
	$module['General']['MSN_Messenger'] = $filename;

   return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ($HTTP_GET_VARS['post'] == true)
{ 
	if ( ($HTTP_POST_VARS['server_image_advanced'] == "http://server.com/msn/") )
	{

		if (  ($HTTP_POST_VARS['server_image'] == 'NULL')  )
		{
	
			$message = $lang['All_values_empty'] . "<br /><br />" . sprintf($lang['Click_return_msn'], "<a href=\"" . append_sid("admin_msn.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
			
		}

		else
		{
			$server_img = str_replace("\'", "''", $HTTP_POST_VARS['server_image']);
		}
	}
	
	elseif ( ($HTTP_POST_VARS['server_image'] == 'NULL') )
	{
			if ( ($HTTP_POST_VARS['server_image_advanced'] == "http://server.com/msn/") )
			{
				$message = $lang['All_values_empty'] . "<br /><br />" . sprintf($lang['Click_return_msn'], "<a href=\"" . append_sid("admin_msn.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
				message_die(GENERAL_MESSAGE, $message);
			 }
			else
			{
				$server_img = str_replace("\'", "''", $HTTP_POST_VARS['server_image_advanced']);
			}
	}

	
	$sql = "UPDATE " . CONFIG_TABLE . " SET `config_value` = '".$server_img."' WHERE `config_name` = 'msn_server'";
	
	      if ( !$db->sql_query($sql) )
	      {
	      	message_die(GENERAL_ERROR, $lang['MSN_Error_Updating'], '', __LINE__, __FILE__, $sql);
	      } 
	$result = $db->sql_query($sql);
	
	$message = $lang['MSN_Updated'] . "<br /><br />" . sprintf($lang['Click_return_msn'], "<a href=\"" . append_sid("admin_msn.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}


$template->set_filenames(array(
   'body' => 'admin/admin_msn.tpl')
);

   
$template->assign_vars(array(
      'FORM_ACTION' => append_sid("admin_msn.$phpEx?post=true"),
      'L_MSN_MESSENGER' => $lang['MSN_Messenger'],
      'L_MSN_EXPLAIN' => $lang['MSN_Explain'],
      'L_FORM_EXPLAIN' => $lang['MSN_Form_Explain'],
      'L_ADVANCED_EXPLAIN' => $lang['Advanced_explain'],
      'L_ADVANCED_USER' => $lang['Advanced_user'],    
      'L_BASIC_USER' => $lang['Basic_user'],    
      'L_ADVANCED' => $lang['Advanced'],
      'L_IMAGE_SERVER' => $lang['Image_Server'],
      'L_SUBMIT' => $lang['Submit'],
      'U_INDEX' =>  $phpbb_root_path . append_sid("index.$phpEx"))
);

include('./page_header_admin.'.$phpEx);
$template->pparse('body');
include('./page_footer_admin.'.$phpEx);

?>