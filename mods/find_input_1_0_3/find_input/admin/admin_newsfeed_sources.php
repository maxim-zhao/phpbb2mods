<?php
/***************************************************************************
 *                            admin_newsfeed_sources.php
 *                            --------------------------
 *   Author  		: 	netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Created 		: 	Thursday, May 01 2003
 *
 *	 Version		: 	0.0.1
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['FIND']['Newsfeed Sources'] = $filename;

	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// try and set some system settings to hopefully get round problems 
// with security consious hosting providers
@set_time_limit(120);
@ini_set("safe_mode", "0");
@ini_set("allow_url_fopen", "1");

include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);
include($phpbb_root_path . 'includes/functions_search.'.$phpEx);
include($phpbb_root_path . 'mods/netclectic/find_input/includes/rss_parser.'.$phpEx);

// include the mod lang_admin file
$use_lang = ( !file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_find.'.$phpEx) ) ? 'english' : $board_config['default_lang'];
include($phpbb_root_path . 'language/lang_' . $use_lang . '/lang_admin_find.' . $phpEx);


// start the page output
$template->set_filenames(array(
    'body' => 'admin/newsfeed_sources_body.tpl')
);

$u_rss_mod_news = 'http://www.netclectic.com/forums/rss/newsfeed_sources.rdf';
$rss_parser = new rssParser();
if ($rss_parser->parse($u_rss_mod_news))
{
    $rss_item_count = count($rss_parser->items); 
    for ($i = 0; $i < $rss_item_count; $i++)
    {
        $rss_subject = trim(substr($rss_parser->items[$i]['title'], 0, 59));
        $rss_message = $rss_parser->items[$i]['description'];
        $rss_link = $rss_parser->items[$i]['link'];

        $bbcode_uid = make_bbcode_uid(); 
        $rss_message = prepare_message($rss_message, 0, 1, 1, $bbcode_uid);
        $rss_message = bbencode_second_pass($rss_message, $bbcode_uid);
        $rss_message = make_clickable($rss_message);
        $rss_message = smilies_pass($rss_message);
        $rss_message = preg_replace("/images\/smiles/", $phpbb_root_path . "/images\/smiles/", $rss_message);
        $rss_message = str_replace("\n", "\n<br />\n", $rss_message);
        
    	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

        $template->assign_block_vars('rss_postrow', array(
            'ROW_CLASS' => $row_class, 
            'S_SUBJECT' => $rss_subject,
            'S_MESSAGE' => $rss_message,
            'U_RSS_LINK' => $rss_link,
            )
        );
    }
    
}
else
{
    message_die('There was a problem parsing the news url :' . '<br/><hr/>' . $rss_parser->error_msg . '<br/><br/>');
}

// assign some variables
$template->assign_vars(array(
    'L_NEWSFEED_SOURCES_TITLE' => $lang['Newsfeed_Sources_Title'],
    'L_NEWSFEED_SOURCES_EXPLAIN' => $lang['Newsfeed_Sources_Explain'],
    'L_BACK_TO_TOP' => $lang['Back_to_top'],
    )
);


// now lets ouput the whole shebang
include('./page_header_admin.'.$phpEx);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);
?>
