<?php
/***************************************************************************
 *                            admin_cache.php
 *                            -------------------
 *   begin                : Sunday, Apr 25, 2005
 *   copyright            : swizec
 *   email                : swizec@randy-comic.com
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Cache'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ( $config_name == 'desc_length' && $new[$config_name] > 255) $new[$config_name] = 255;

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}


	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_cacheconfig'], "<a href=\"" . append_sid("admin_cache.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}

}

//
// Execute a function if needed
//

if ( isset( $HTTP_POST_VARS['check_gd'] ) ) {
	if ( !extension_loaded('gd') ) {
		$message = $lang['fail_gdchk'] . "<br /><br />" . sprintf($lang['Click_return_cacheconfig'], "<a href=\"" . append_sid("admin_cache.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}else{
		$message = $lang['ok_gdchk'] . "<br /><br />" . sprintf($lang['Click_return_cacheconfig'], "<a href=\"" . append_sid("admin_cache.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

if ( isset( $HTTP_POST_VARS['empty_imgcache'] ) ) {
	if ( !empty_cache ( ) ) {
		$message = $lang['cache_fail_empty'] . "<br /><br />" . sprintf($lang['Click_return_cacheconfig'], "<a href=\"" . append_sid("admin_cache.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}else{
		$message = $lang['cache_ok_empty'] . "<br /><br />" . sprintf($lang['Click_return_cacheconfig'], "<a href=\"" . append_sid("admin_cache.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

if ( isset( $HTTP_POST_VARS['sizesync'] ) ) {
	if ( !cachesizesync ( ) ) {
		$message = $lang['sizesync_fail'] . "<br /><br />" . sprintf($lang['Click_return_cacheconfig'], "<a href=\"" . append_sid("admin_cache.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}else{
		$message = $lang['sizesync_ok'] . "<br /><br />" . sprintf($lang['Click_return_cacheconfig'], "<a href=\"" . append_sid("admin_cache.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

//
// Output config
//

$template -> set_filenames( array(
	"body" => "admin/cache_config_body.tpl")
);

$imgcache_yes = ( $new['enable_img_cache'] ) ? "checked=\"checked\"" : "";
$imgcache_no = ( !$new['enable_img_cache'] ) ? "checked=\"checked\"" : "";

$cachepath = $new['cachepath'];

$maxsize = $new['max_image_size'];

$maxcachesize = $new['image_cache_maxsize'];

$cacheusage = cacheusage( );

$useftp_yes = ( $new['cache_useftp'] ) ? "checked=\"checked\"" : "";
$useftp_no = ( !$new['cache_useftp'] ) ? "checked=\"checked\"" : "";

$postimg_width = $new['postimg_width'];
$postimg_height = $new['postimg_height'];
$usethumbs_yes = ( $new['display_thumbs'] ) ? "checked=\"checked\"" : "";
$usethumbs_no = ( !$new['display_thumbs'] ) ? "checked=\"checked\"" : "";


$ftp = $new['cache_ftp'];

$ftp_port = $new['cache_ftp_port'];

$ftp_user = $new['cache_ftp_user'];

$ftp_pass = $new['cache_ftp_pass'];

$ftp_path = $new['cache_ftp_path'];

// create the error report
$errors = '';
$margin = ( $board_config['image_cache_maxsize'] / 100 ) * 10;  // how much MB is 10% of the cache
$folder = $phpbb_root_path . $new['cachepath'];
// is the cache almost full
if ( ( $board_config['image_cache_maxsize'] - $board_config['image_cache_size'] ) < $margin ) 
	$errors .= $lang['cache_full'] . '<br />';
// almost out of space?
if ( ( ( diskfreespace( $folder ) / 1024 ) / 1024 ) < $margin )
{
	$errors .= $lang['cache_nospace'] . '<br />';
}
if ( !is_dir( $folder ) )
{
	if ( !is_writable ( $phpbb_root_path ) )
		$errors .= $lang['nocache_nocreate'];
	else $errors .= $lang['nocache_create'] . '<br />';
}else
{
	if ( !is_writable( $folder ) )
		$errors .= $lang['cache_nowrite'] . '<br />';
	if ( !is_readable( $folder ) )
		$errors .= $lang['cache_noread'] . '<br />';
}
if ( empty( $errors ) ) $errors = $lang['cache_noerror'];

// create the error report for ftp access
if ( $useftp_yes ) 
{
	$errors .= "<br /><br />";
	if ( !$conn_id = @ftp_connect( $ftp, $ftp_port ) ) $errors .= $lang['ftp_err_noconnect'] . '<br />';
	elseif ( !$login_result = @ftp_login( $conn_id, $ftp_user, $ftp_pass) )
	{
		$errors .= $lang['ftp_err_nologin'] . '<br />';
	}else
	{
		// try to upload
		$temp = tempnam ( "/tmp", "ftptest" );
		$tmp = fopen( $temp, "r" );
		if ( !@ftp_fput( $conn_id, $ftp_path . $cachepath . '/try', $tmp, FTP_ASCII ) )
		{
			$errors .= $lang['ftp_err_noupload'];
		}else
		{
			$errors .= $lang['ftp_err_nope'];
			// cleanup
			ftp_delete( $conn_id, $ftp_path . $cachepath . '/try' );
		}
		fclose( $tmp );
		unlink( $temp );
		ftp_quit( $conn_id );
	}
}

$template->set_filenames(array('browser' => 'cache_browser.tpl')); 
$template -> assign_block_vars( 'ACP', array( ) );
$standalone = FALSE;
include( $phpbb_root_path . 'includes/cache_browser.' . $phpEx );
$template->assign_var_from_handle('CACHE_BROWSER', 'browser');


$template -> assign_vars( array(
	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'], 
	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_DEL" => $lang['remove'],
	"L_IMG_CACHE_ENABLE" => $lang['cache_enable'],
	"L_IMG_CACHE_ENABLE_EXP" => $lang['cache_enable_exp'],
	"L_CHECK" => $lang['check'],
	"L_EMPTY_IMGCACHE" => $lang['empty_imgcache'],
	"L_EMPTY" => $lang['empty'],
	"L_CONFIGURATION_TITLE" => $lang['image_cache'],
	"L_CONFIGURATION_EXPLAIN" => $lang['image_cache_exp'],
	"L_IMAGE_CACHE" => $lang['image_cache'],
	"L_CACHEPATH" => $lang['cachepath'],
	"L_MAXSIZE" => $lang['maximgsize'],
	"L_MAXSIZE_EXP" => $lang['maximgsize_exp'],
	"L_CACHEMAXSIZE" => $lang['cachemaxsize'],
	"L_CACHEMAXSIZE_EXP" => $lang['cachemaxsize_exp'],
	"L_SYNC" => $lang['Sync'],
	"L_CACHEUSAGE" => $lang['cacheusage'],
	"L_ERRORS" => $lang['errors'],
	"L_FTP_CONF" => $lang['cache_ftpconf'],
	"L_FTP" => $lang['cache_ftp'],
	"L_FTP_PORT" => $lang['cache_ftp_port'],
	"L_FTP_USE" => $lang['cache_ftpuse'],
	"L_FTP_USE_EXP" => $lang['cache_ftpuse_exp'],
	"L_FTP_USER" => $lang['cache_ftpuser'],
	"L_FTP_PASS" => $lang['cache_ftppass'],
	"L_FTP_PATH" => $lang['cache_ftppath'],
	"L_CACHE_VIEW" => $lang['cache_view'],
	"L_USETHUMBS" => $lang['usethumbs'],
	"L_POSTIMG_SIZE" => $lang['postimg_size'],
	"L_THUMBS" => $lang['thumbs'],
	
	"IMGCACHE_YES" => $imgcache_yes,
	"IMGCACHE_NO" => $imgcache_no,
	"CACHEPATH" => $cachepath,
	"MAXSIZE" => $maxsize,
	"CACHEMAXSIZE" => $maxcachesize,
	"CACHEUSAGE" => $cacheusage,
	"ERRORS" => $errors,
	"USEFTP_YES" => $useftp_yes,
	"USEFTP_NO" => $useftp_no,
	"FTP" => $ftp,
	"FTP" => $ftp_port,
	"FTP_USER" => $ftp_user,
	"FTP_PASS" => $ftp_pass,
	"FTP_PATH" => $ftp_path,
	"POSTIMG_WIDTH" => $postimg_width,
	"POSTIMG_HEIGHT" => $postimg_height,
	"USETHUMBS_YES" => $usethumbs_yes,
	"USETHUMBS_NO" => $usethumbs_no,
) );

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>