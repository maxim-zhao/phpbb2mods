<?php
/***************************************************************************
 *                             cache_browser.php
 *                            -------------------
 *   begin                : Thursday, Apr 28, 2005
 *   copyright            : swizec
 *   email                : swizec@randy-comic.com
 *
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') ) 
{ 
   die("Hacking attempt"); 
}

// returns the tooltip for file management
function browser_tool( $img, $size, $bytes, $orig, $used, $rsize, $write, $standalone ) {

	global $phpEx, $lang;
	
	// some basic info
	$w = $size[0];
	$h = $size[1];
	$kbytes = round( $bytes / 1024, 1 );
	$rw = $rsize[0];
	$rh = $rsize[1];
		
	// check if remote image works

	// the popup for the original image
	$click = ( $used ) ? 'open( \''. $orig .'\', \'imgpop\',  \'width=' . $rw . ',height=' . $rh . ' ,status=no,toolbar=no,menubar=no\' );' : '';
		
	$tool = '';
	$tool .= ( $used ) ? '<b><a href="#" onclick="javascript: ' . $click . '" style="text-decoration: none">' . $lang['original'] . '</a></b><br />' : '';
	$tool .= ( !$used ) ? '<font color="#EE0000">' . $lang['image_noused'] . '</font><br />' : '';
	$tool .= ( $noremote ) ? '<font color="#EE0000">' . $lang['image_noremote'] . '</font><br />' : '';
	$tool .= '<div style="font-size : 11px;">' . sprintf( $lang['image_info'], $w, $h, $kbytes ) . '<br /></div>';
	if ( $write ) 
	{
		$tool .= '<div align="center">';
		$bck = ( !$standalone ) ? append_sid("admin_cache.$phpEx?del=$img") . '">' . $lang['delete'] : append_sid("cache_browser.$phpEx?del=$img") . '">' . $lang['delete'];
		$tool .= '<b><a style="text-decoration: none" href="' . $bck . '</a><br />';
		$bck = ( !$standalone ) ? append_sid("admin_cache.$phpEx?ref=$img") . '">' . $lang['refresh'] : append_sid("cache_browser.$phpEx?ref=$img") . '">' . $lang['refresh'];
		$tool .= '<a style="text-decoration: none" href="' . $bck . '</a></b><br />';
		$tool .= '</div>';
	}

	// options for the tooltip
	$options = "this.T_WIDTH=220;";
	$options .= "this.T_OFFSETX=-110;";
	$options .= "this.T_TITLE='" . $img . "';";
	$options .= "this.T_STICKY='true';";
	$options .= "this.T_DELAY='10';";
	
	$tool = str_replace( "'", "\'", $tool );
	$tool = str_replace( '"', '\"', $tool );
	$tool = htmlspecialchars( $tool );
	
	// output the tool
	return 'onmouseover="' . $options . ' return escape(' . "'" . $tool . "'" . ')"';	

}

// deletes a particular iamge from cache
function delete_image( $img, $folder, $write, $conn_id = '' ) {

	global $db ;
	
	if ( !$write ) 
	{
		return FALSE;
	}
	
	$img = $folder . '/' . $img;
	if ( empty( $conn_id ) ) 
	{
		if ( @unlink ( $img ) ) 
		{
			$sql = "DELETE FROM " . CACHE_PROCESSED_TABLE . " WHERE image='$img'";
			$db -> sql_query( $sql );
			return TRUE;
		}
	}else
	{
		if ( @ftp_delete ( $conn_id, $img ) ) 
		{
			$sql = "DELETE FROM " . CACHE_PROCESSED_TABLE . " WHERE image='$img'";
			$db -> sql_query( $sql );
			return TRUE;
		}
	}
	
	return FALSE;
}

function refresh_image( $img, $folder, $write, $conn_id = '' ) {

	global $board_config, $db;
	
	if ( !$write ) 
	{
		return FALSE;
	}
	
	if ( !delete_image( $img, $folder, $conn_id ) ) 
	{
		return FALSE;
	}
	
	$file = $folder . '/' . $img;
	
	// fetch the original
	$image = './' . $board_config['cachepath'] . '/' . $img;
	$sql = "SELECT original FROM " .CACHE_PROCESSED_TABLE . " WHERE image='$image'";
	if ( !$result = $db -> sql_query( $sql ) ) 
	{
		return FALSE;
	}
	$row = $db -> sql_fetchrow( $result );
	$orig = $row['original'];
	
	if ( empty( $conn_id ) )
	{
		if ( encache( $file, $orig, explode( '/', $file ), FALSE, 0 ) )
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
	}else
	{
		if ( encache( $file, $file, explode( '/', $file ), TRUE, $conn_id ) )
		{
			return TRUE;
		}else 
		{
			return FALSE;
		}
	}
	
	return FALSE;
}

// if this is set we are admin and are allowed to write to cache
if ( $userdata['user_level'] == ADMIN ) 
{
	$write = TRUE;
}else	
{
	$write = FALSE;
}

// lets first check if there are any problems with doing this
$folder = $board_config['cachepath'];
$brerrors = '';
if ( !$board_config['cache_useftp'] ) 
{
	if ( !is_dir( $folder ) ) 
	{
		if ( !is_writable ( $phpbb_root_path ) )
		{
			$brerrors .= $lang['nocache_nocreate'] . '<br />';
		}else 
		{
			$error = $lang['nocache_create'] . '<br />';
		}
	}else
	{
		if ( !is_writable( $folder ) && $write )
		{
			$brerrors .= $lang['cache_nowrite'] . '<br />';
		}
		if ( !is_readable( $folder ) )
		{
			$brerrors .= $lang['cache_noread'] . '<br />';
		}
	}
}else
{
	$ftp = $board_config['cache_ftp'];
	$ftp = $board_config['cache_ftp_port'];
	$ftp_user = $board_config['cache_ftp_user'];
	$ftp_pass = $board_config['cache_ftp_pass'];
	$ftp_path = $board_config['cache_ftp_path'];

	if ( !$conn_id = @ftp_connect( $ftp, $ftp_port ) )
	{
		$brerrors .= $lang['ftp_err_noconnect'] . '<br />';
	}elseif ( !$login_result = @ftp_login( $conn_id, $ftp_user, $ftp_pass) )
	{
		$brerrors .= $lang['ftp_err_nologin'] . '<br />';
	}elseif( $write )
	{
		// try to upload
		$temp = tempnam ( "/tmp", "ftptest" );
		$tmp = fopen( $temp, "r" );
		if ( !@ftp_fput( $conn_id, $ftp_path . $board_config['cachepath'] . '/try', $tmp, FTP_ASCII ) ) 
		{
			$brerrors .= $lang['ftp_err_noupload'];
		}else
		{
			// cleanup
			ftp_delete( $conn_id, $ftp_path . $board_config['cachepath'] . '/try' );
		}
		fclose( $tmp );
		unlink( $temp );
	}else
	{
		$ftp_connected = TRUE;
	}
}

if ( !empty( $brerrors ) ) 
{
	if ( !$standalone ) 
	{
		$template -> assign_block_vars( 'ACP.error', array ( 
			"ERROR" => $brerrors
		) );
	}else
	{
		$template -> assign_block_vars( 'standalone.error', array ( 
			"ERROR" => $brerrors
		) );
	}
}else
{
	// get the directory listing
	$folder = ( $board_config['cache_useftp'] ) ? $board_config['cache_ftp_path'] . '/' . $board_config['cachepath'] : $phpbb_root_path . $board_config['cachepath'];
	$cachedir = array ();
	
	// lets first see if we have anything to do
	$del = ( isset( $HTTP_GET_VARS['del'] ) ) ? $HTTP_GET_VARS['del'] : FALSE;
	$ref = ( isset( $HTTP_GET_VARS['ref'] ) ) ? $HTTP_GET_VARS['ref'] : FALSE;
	if ( $del ) 
	{
		if ( !delete_image( $del, $folder, $write, $conn_id ) )
		{
			$error = $lang['image_faildel'];
		}else 
		{
			$error = $lang['image_okdel'];
		}
	}
	if ( $ref ) 
	{
		if ( !refresh_image( $ref, $folder, $write, $conn_id ) )
		{
			$error = $lang['image_failref'];
		}else 
		{
			$error = $lang['image_okref'];
		}
	}
	if ( $del || $ref ) 
	{
		if ( !$standalone ) 
		{
			$template -> assign_block_vars( 'ACP.error', array ( 
				"ERROR" => $error
			) );
		}else
		{
			$template -> assign_block_vars( 'standalone.error', array ( 
				"ERROR" => $error
			) );
		}
	}
	
	if ( $board_config['cache_useftp'] ) 
	{
		// with ftp access
		$cachedir = ftp_nlist ( $conn_id, $folder );
	}else
	{
		// normal acces
		$dh  = opendir( $folder );
		while ( FALSE !== ( $filename = readdir( $dh ) ) ) 
		{
			$cachedir[] = $filename;
		}
		closedir( $dh );
	}
	
	// organise a bit
	natsort( $cachedir );
	
	// loop through the directory array to produce the output
	$icon = $phpbb_root_path . 'templates/' . $theme['template_name'] . '/images/image.png';
	$cachedir = array_chunk( $cachedir, 5 );
	$files = 0;
	// fetch the hash table
	$sql = "SELECT image, original FROM " . CACHE_PROCESSED_TABLE;
	$hsh = $db -> sql_fetchrowset( $db -> sql_query( $sql ) );
	$hash = array ();
	if ( count( $hsh ) != 0 ) 
	{
		foreach ( $hsh as $row ) 
		{
			$hash['image'][] = $row['image'];
			$hash['orig'][] = $row['original'];
		}
	}
		
	foreach ( $cachedir as $i => $row ) 
	{
		if ( !$standalone ) 
		{
			$template -> assign_block_vars( 'ACP.imgrow', array ( ) );
		}else
		{
			$template -> assign_block_vars( 'standalone.imgrow', array ( ) );
		}
		foreach ( $row as $ii => $img ) 
		{
			// remove the unneeded stuff that is ftp path
			if ( $board_config['cache_useftp'] ) 
			{
				$img = explode( '/', $img );
				$img = $img[count( $img ) - 1];
			}
			// dont display whats technically not in the cache
			if ( $img == '.' || $img == '..' || $img == 'cacheusage.png' ) 
			{
				continue;
			}
			
			$link = $phpbb_root_path . $board_config['cachepath'] . '/' . $img;
			$size = @getimagesize( $link );
			$w = $size[0];
			$h = $size[1];
			$bytes = @filesize( $folder . '/' . $img );
			if ( $board_config['cache_useftp'] ) 
			{
				$img = explode( '/', $img );
				$img = $img[count( $img ) - 1];
			}
			// fetch info from the hash
			$orig = array_search( './' . $board_config['cachepath'] . '/' . $img, $hash['image'] );
			if ( $orig !== FALSE ) 
			{
				$orig = $hash['orig'][$orig];
				$used = TRUE;
				$rsize = getimagesize( $orig );
			}else
			{
				$used = FALSE;
			}		
			
			// the popup
			$click = "window.open( '$link', 'imgpop',  'width=$w,height=$h,status=no,toolbar=no,menubar=no' );";
			// the tooltip
			$tool = browser_tool( $img, $size, $bytes, $orig, $used, $rsize, $write, $standalone );
			
			if ( !$standalone ) 
			{
				$template -> assign_block_vars( 'ACP.imgrow.imgcol', array(
					"ICON" => $icon,
					"NAME" => $img,
					"LINK" => $link,
					"CLICK" => $click,
					"TOOL" => $tool
				) );
			}else
			{
				$template -> assign_block_vars( 'standalone.imgrow.imgcol', array(
					"ICON" => $icon,
					"NAME" => $img,
					"LINK" => $link,
					"CLICK" => $click,
					"TOOL" => $tool
				) );
			}
			$files++;
		}
	}
	
	if ( $files == 0 ) 
	{
		$template -> assign_block_vars( 'error', array ( 
			"ERROR" => $lang['cache_nofiles']
		) );
	}

	$template -> assign_vars( array(
	
	) );

	if ( $ftp_connected ) @ftp_quit( $conn_id );
}

?>