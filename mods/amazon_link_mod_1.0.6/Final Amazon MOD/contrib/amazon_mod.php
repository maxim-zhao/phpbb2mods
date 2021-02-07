<?php
/***************************************************************************
 *                              amazon_mod.php
 *                            -------------------
 *   began              	: Thursday, 5th May 2005
 *   email                	: mod@dvdsandstuff.net
 *	 website				: http://www.dvdsandstuff.net
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

//
// Load default header
//
$phpbb_root_path = './';
require($phpbb_root_path . 'extension.inc');
include($phpbb_root_path.'language/lang_' . $board_config['default_lang'] . '/lang_amazon.'.$phpEx);

$getting_data = "SELECT * FROM " . AMAZON_CONFIG_TABLE . "";
if ( !$get_result = $db->sql_query($getting_data) )
	{
	message_die(GENERAL_ERROR, $lang['Amazon_Sql_Error'], $lang['Error'], __LINE__, __FILE__, $sql);
	}
	$data_true = $db->sql_fetchrow($get_result);

if ($data_true['enable'] == 1)
{
	if ($data_true['amazon'] == 1)
	{
		$author_affiliate = "dvdsstuf-20";
		$amazon_country = "com";
		$amazon_image = "dollar.gif";
	}
	
	elseif ($data_true['amazon'] == 2)
	{
		$author_affiliate = "dvdsandstuffn-20";
		$amazon_country = "ca";
		$amazon_image = "dollar.gif";
	}
	
	elseif ($data_true['amazon'] == 3)
	{
		$author_affiliate = "dvdsandstuffn-21";
		$amazon_country = "de";
		$amazon_image = "euro.gif";
	}
	
	elseif ($data_true['amazon'] == 4)
	{
		$author_affiliate = "dvdsandstuf0d-21";
		$amazon_country = "fr";
		$amazon_image = "euro.gif";
	}
	
	elseif ($data_true['amazon'] == 5)
	{
		$author_affiliate = "dvdsandstuff-22";
		$amazon_country = "co.jp";
		$amazon_image = "yen.gif";
	}
	
	else
	{
		$author_affiliate = "dvdsstuf-21";
		$amazon_country = "co.uk";
		$amazon_image = "pound.gif";
	}

	if (($topic_rowset[$i]['topic_type'] == POST_ANNOUNCE) AND ($data_true['announce'] == 1))
	{
			$show_announce = TRUE;
	}
	
	elseif (($topic_rowset[$i]['topic_type'] == POST_STICKY) AND ($data_true['sticky'] == 1))
	{
			$show_sticky = TRUE;
	}
	
	elseif (($topic_rowset[$i]['topic_type'] != POST_STICKY ) AND ($topic_rowset[$i]['topic_type'] != POST_ANNOUNCE) AND ($data_true['normal'] == 1))
	{
			$show_normal = TRUE;
	}
	
	else
	{
			$show_announce = FALSE;
			$show_sticky = FALSE;
			$show_normal = FALSE;
	}
	
	if ($data_true['window'] == 1)
	{
		$new_window = "_blank";
	}
	
	else
	{
		$new_window = "_self";
	}
	
	if ($data_true['images'] != NULL)
	{
		$images_folder = $data_true['images'];
	}
	
	else
	{
		$images_folder = "images";
	}

	$amazon_sql = "SELECT amazon_display FROM " .FORUMS_TABLE. " WHERE forum_id = " .$forum_id;
	if ( !$amazon_result = $db->sql_query($amazon_sql) )
	{
	message_die(GENERAL_ERROR, $lang['Amazon_Sql_Error'], $lang['Error'], __LINE__, __FILE__, $sql);
	}
	$amazon_display = $db->sql_fetchrow($amazon_result);
	
	if ( !empty($amazon_display['amazon_display']) )
	{
		if ( !empty($data_true['username']) )
			{
				if ($show_announce == TRUE || $show_sticky == TRUE || $show_normal == TRUE)
				{ 
					$amazon_text = "<a href=\"http://www.amazon.".$amazon_country."/exec/obidos/external-search?keyword=".$topic_title."&tag=".$data_true['username']."&mode=blended\" target=\"".$new_window."\"><img src=\"".$images_folder."/".$amazon_image."\" border=\"0\" /></a>";
				}
				else
				{
					$amazon_text = "";
				}	
		}
		else
		{
				if ($show_announce == TRUE || $show_sticky == TRUE || $show_normal == TRUE)
				{
					$amazon_text = "<a href=\"http://www.amazon.".$amazon_country."/exec/obidos/external-search?keyword=".$topic_title."&tag=".$author_affiliate."&mode=blended\"  target=\"".$new_window."\"><img src=\"".$images_folder."/".$amazon_image."\" border=\"0\" /></a>";
				}
				else
				{
					$amazon_text = "";
				}
			}
		
	}
}
?>