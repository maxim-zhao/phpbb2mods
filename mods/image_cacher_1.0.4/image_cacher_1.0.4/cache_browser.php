<?php
/***************************************************************************
 *                             cache_browser.php
 *                            -------------------
 *   begin                : Thursday, Apr 28, 2005
 *   copyright            : swizec
 *   email                : swizec@randy-comic.com
 *
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
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
//
// End session management
//

// get the lang vars coz they're in lang_admin not in lang_main
$lng = ( $userdata['user_id'] != ANONYMOUS ) ? $userdata['user_lang'] : $board_config['default_lang'];
include( $phpbb_root_path . 'language/lang_' . $lng . '/lang_admin.' . $phpEx );

// page header
$page_title = $lang['cache_browser'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


// stuf to make the browser feel like it's in the ACP
$template -> assign_vars( array(
	"L_CACHE_VIEW" => $lang['cache_view'],
	"L_GOTO_PAGE" => $lang['Goto_page'],
	
) );

make_jumpbox('viewforum.'.$phpEx);

// tell the browser this is not the ACP
$standalone = TRUE;

// output the browser
$template -> set_filenames( array( 'browser' => 'cache_browser.tpl' ) ); 
$template -> assign_block_vars( 'standalone', array( ) );
include( $phpbb_root_path . 'includes/cache_browser.' . $phpEx );
$template -> pparse( 'browser' );

// why we need to have feet on the page don't we now
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
