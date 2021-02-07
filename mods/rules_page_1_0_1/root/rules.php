<?php
/***************************************************************************
 *                                  rules.php
 *                            -------------------
 *   begin                : Monday, Jun 24, 2006
 *   copyright            : (C) 2006 phpBBModders
 *   email                : admin@phpbbmodders.com
 *
 *   $Id: rules.php,v 1.0.0.0 2006/07/26 01:08:15 evil3 Exp $
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

define('IN_PHPBB', true);
$phpbb_root_path = './';
include( "{$phpbb_root_path}extension.inc" );
include( "{$phpbb_root_path}common.$phpEx" );

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_RULES);
init_userprefs($userdata);
//
// End session management
//

// Set vars to prevent naughtiness
$faq = array();

//
// Load the appropriate lang file
//
$lang_file	= 'lang_rules';
$l_title	= $lang['Rules'];

//
// Include the rules settings
//
include( "{$phpbb_root_path}language/lang_{$board_config['default_lang']}/$lang_file.$phpEx" );

//
// Pull the array data from the lang pack
//
$j = 0;
$counter = 0;
$counter_2 = 0;
$faq_block = array();
$faq_block_titles = array();

for($i = 0; $i < count($faq); $i++)
{
	if( $faq[$i][0] != '--' )
	{
		$faq_block[$j][$counter]['id'] = $counter_2;
		$faq_block[$j][$counter]['question'] = $faq[$i][0];
		$faq_block[$j][$counter]['answer'] = $faq[$i][1];

		$counter++;
		$counter_2++;
	}
	else
	{
		$j = ( $counter != 0 ) ? $j + 1 : 0;

		$faq_block_titles[$j] = $faq[$i][1];

		$counter = 0;
	}
}

//
// Lets build a page ...
//
$page_title = $l_title;
include( "{$phpbb_root_path}includes/page_header.$phpEx" );

$template->set_filenames(array(
	'body' => 'faq_body.tpl')
);
make_jumpbox( "viewforum.$phpEx" );

$template->assign_vars(array(
	'L_FAQ_TITLE' => $l_title, 
	'L_BACK_TO_TOP' => $lang['Back_to_top'])
);

for($i = 0; $i < count($faq_block); $i++)
{
	if( count($faq_block[$i]) )
	{
		$template->assign_block_vars('faq_block', array(
			'BLOCK_TITLE' => $faq_block_titles[$i])
		);
		$template->assign_block_vars('faq_block_link', array( 
			'BLOCK_TITLE' => $faq_block_titles[$i])
		);

		for($j = 0; $j < count($faq_block[$i]); $j++)
		{
			$row_color = ( !($j % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($j % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars('faq_block.faq_row', array(
				'ROW_COLOR'	=> '#' . $row_color,
				'ROW_CLASS'	=> $row_class,
				'FAQ_QUESTION'	=> $faq_block[$i][$j]['question'], 
				'FAQ_ANSWER'	=> $faq_block[$i][$j]['answer'], 

				'U_FAQ_ID'	=> $faq_block[$i][$j]['id'])
			);

			$template->assign_block_vars('faq_block_link.faq_row_link', array(
				'ROW_COLOR'	=> '#' . $row_color,
				'ROW_CLASS'	=> $row_class,
				'FAQ_LINK'	=> $faq_block[$i][$j]['question'], 

				'U_FAQ_LINK'	=> '#' . $faq_block[$i][$j]['id'])
			);
		}
	}
}

$template->pparse('body');

include( "{$phpbb_root_path}includes/page_tail.$phpEx" );

?>
