<?php
/***************************************************************************
 *                           functions_cache.php
 *                            -------------------
 *   begin                : Sunday, Apr 24, 2005
 *   copyright            : swizec
 *   email                : swizec@randy-comic.com
 *
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') ) 
{ 
   die("Hacking attempt"); 
}

// creates the "progress" bar
function createbar( &$im, $x1, $y1, $w, $h ) {
	
	global $phpbb_root_path, $theme;
	
	// lets create a stream we'll be inserting
	$left = './../templates/' . $theme['template_name'] . '/images/cachesize_barl.png';
	$right = './../templates/' . $theme['template_name'] . '/images/cachesize_barr.png';
	$center = './../templates/' . $theme['template_name'] . '/images/cachesize_barc.png';
	
	// get sizes
	$sizel = getimagesize( $left );
	$sizer = getimagesize( $right );
	$sizec = getimagesize( $center );
	
	// check if theres anything to display
	if ( $w < $sizel[0] + $sizer[0] ) 
	{
		return;
	}
	
	// open images
	$left = imagecreatefrompng( $left );
	$right = imagecreatefrompng( $right );
	$center = imagecreatefrompng( $center );
	
	// so lets do the insertion
	imagecopyresized( $im, $left, $x1, $y1, 0, 0, $sizel[0] - 10, $h, $sizel[0], $sizel[1] );
	$w -= ( $sizel[0] + 2 );
	$x1 += ( $sizel[0] - 10  );
	imagecopyresized( $im, $center, $x1, $y1, 0, 0, $w, $h, $sizec[0], $sizec[1] );
	$x1 += $w;
	imagecopyresized( $im, $right, $x1, $y1, 0, 0, $sizer[0] - 10, $h, $sizer[0], $sizer[1] );
	
	// kill the things
	imagedestroy( $left );
	imagedestroy( $right );
	imagedestroy( $center );

}

// returns link to temp image that shows a nice bar of how much the cache is used
function cacheusage( ) {

	global $phpbb_root_path, $board_config, $lang;
	
	$folder = $phpbb_root_path . $board_config['cachepath'];
	
	// size we'll use
	$w = 300;
	$h = 50;
	
	// do a quick check for the GD library, just to be safe ;)
	if ( !extension_loaded('gd') )
	{
		return FALSE;
	}
	
	// delete the cacheusage image from cache
	// check if the folder is writable
	if ( is_dir( $folder ) ) 
	{
		if ( !is_writeable( $folder ) ) 
		{
			return FALSE;
		}
	}else
	{
		// try to create it
		if ( mkdir( $folder ) ) {
			// this is more of a safety precotion, 
			// almost impossible this would happen
			if ( !is_writeable( $folder ) ) 
			{
				return FALSE;
			}
		}else
		{
			return FALSE;
		}
	}
	
	$file = $folder . '/cacheusage.png';
	
	if ( file_exists( $file ) ) 
	{
		if ( !is_writable ( $folder . '/cacheusage.png' ) )
		{
			return FALSE;
		}else
		{
			unlink( $file );
		}
	}
	
	$im = imagecreatetruecolor( $w, $h );
	
	// set the colors we'll be using
	$bg = imagecolorallocate( $im, 209, 215, 220 ); // color row3(subSilver)
	$black1 = imagecolorallocate( $im, 0, 0, 0 );
	$black2 = imagecolorallocate( $im, 100, 110, 118 ); // shadowy
	$black3 = imagecolorallocate( $im, 162, 174, 184 ); // highlighty
	$bar_back = imagecolorallocate( $im, 234, 234, 234 );
	
	// make background
	imagefill( $im, 0, 0, $bg );
	
	// make a border
	imagerectangle( $im, 2, 2, $w - 2, $h - 2, $black1 );
	
	// create the background of the bar
	imagerectangle( $im, 5, 5, $w - 6, 30, $black2 );
	imagerectangle( $im, 6, 6, $w - 6, 30, $black2 );
	imagefilledrectangle( $im, 7, 7, $w - 7, 29, $bar_back );
	
	// calculate the length of the bar
	$max = $w - 12;
	$perc = ( $board_config['image_cache_size'] * 100 ) / ( $board_config['image_cache_maxsize'] + 0.0001 );
	$perc = round( $perc, 2 );
	$length = round( ( $perc * $max ) / 100 );
	
	createbar( $im, 9, 8, $length, 20 );
	
	// put the stats beneath the bar
	$used = round( $board_config['image_cache_size'], 2 );
	$max = round( $board_config['image_cache_maxsize'], 2 );
	$images = $board_config['cached_images'];
	$stats = sprintf( $lang['cacheusage_sats'], $used, $max, $perc . ' %', $images );
	imagestring( $im, 2, 7, 33, $stats, $black1 );

	// save this to file
	imagepng( $im, $file );
	
	// lets kill the image
	imagedestroy( $im );
	
	$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	$script_name = ($script_name != '') ? $script_name . '/' . $board_config['cachepath'] : '/' . $board_config['cachepath'];
	$server_name = trim($board_config['server_name']);
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';
	
	return  $server_protocol . $server_name . $server_port . $script_name . '/cacheusage.png';
	
}

// syncs the stored cache size value with actual stat
function cachesizesync ( ) {
	
	global $phpbb_root_path, $board_config, $db;

	// basic vars needed
	$folder = $phpbb_root_path . $board_config['cachepath'];
	$size = 0;
	$images = 0;
	$imgarr = array();
	
	if ( !is_readable( $folder ) )
	{
		return FALSE;
	}
	$dir = dir( $folder );
	while ( FALSE !== ( $entry = $dir -> read( ) ) ) 
	{
		if ( $entry != '.' && $entry != '..' )
		{
			if ( !$s = @filesize( $folder . '/' . $entry ) ) 
			{
				return FALSE;
			}
			$size += $s;
			$images++;
			$imgarr[count( $imgarr )] = './' . strip_tags( $board_config['cachepath'] ) . '/' . $entry;
		}
	}
	$dir -> close();
	
	$size = $size / 1024; // kbytes
	$size = $size / 1024; // mbytes
	
	if ( $size != $board_config['image_cache_size'] ) 
	{
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='$size' WHERE config_name='image_cache_size'";
		if ( !$db -> sql_query( $sql ) ) 
		{
			return FALSE;
		}
	}
	$images--;
	if ( $images != $board_config['cached_images'] ) 
	{
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='$images' WHERE config_name='cached_images'";
		if ( !$db -> sql_query( $sql ) ) 
		{
			return FALSE;
		}
	}
	
	// resync the hash table (add images that are in cache but not there
	foreach ( $imgarr as $img ) 
	{
		$sql = "SELECT id FROM " . CACHE_PROCESSED_TABLE . " WHERE image='$img' AND cached='1'";
		if ( !$r = $db -> sql_query( $sql ) )
		{
			return FALSE;
		}
		$num = $db -> sql_numrows( $r );
		if ( $num == 0 ) 
		{
			$sql = "INSERT INTO " . CACHE_PROCESSED_TABLE . " ( cached, image ) VALUES ( '1', '$img' )";
			if ( !$db -> sql_query( $sql ) ) 
			{
				return FALSE;
			}
		}
	}
	
	// resync, but this time in the opposite way
	$sql = "SELECT id, image FROM " . CACHE_PROCESSED_TABLE . " WHERE cached='1'";
	if ( !$r = $db -> sql_query( $sql ) ) 
	{
		return FALSE;
	}
	while ( $row = $db -> sql_fetchrow( $r ) ) 
	{
		$img = $row['image'];
		// remove from hash if it's no longer present
		if ( !in_array( $img, $imgarr ) ) 
		{
			$id = $row['id'];
			$sql = "DELETE FROM " . CACHE_PROCESSED_TABLE . " WHERE id='$id'";
			if ( !$db -> sql_query( $sql ) )
			{
				return FALSE;
			}
		}
	}
	
	// if we're here everything went fine
	return TRUE;
}

// empties the image cache
function empty_cache ( ) {

	global $phpbb_root_path, $board_config, $db;

	// basic vars needed
	$folder = $phpbb_root_path . $board_config['cachepath'];
	
	if ( !is_writable( $folder ) && !$board_config['cache_useftp']) 
	{
		return FALSE;
	}else
	{
		$dir = dir( $folder );
		while ( FALSE !== ( $entry = $dir -> read( ) ) ) 
		{
			if ( $entry != '.' && $entry != '..' )
			{
				if ( !@unlink( $folder . '/' . $entry ) )
				{
					return FALSE;
				}
			}
		}
		$dir -> close();
	}
	
	// set cache size to 0
	$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='0' WHERE config_name='image_cache_size'";
	if ( !$db -> sql_query( $sql ) ) 
	{
		return FALSE;
	}
	$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='0' WHERE config_name='cached_images'";
	if ( !$db -> sql_query( $sql ) ) 
	{
		return FALSE;
	}
	
	// empty the hash
	$sql = "TRUNCATE TABLE " . CACHE_PROCESSED_TABLE;
	if ( !$db -> sql_query( $sql ) ) 
	{
		return FALSE;
	}
	
	// if we're here everything went fine
	return TRUE;
}

// puts something in the cache using ftp
function ftp_encache( &$image, $file, $connected, $conn_id ) {

	global $board_config;
	
	// check if we are connected to the ftp
	if ( !$connected ) 
	{
		return FALSE;
	}
	
	// set basic vars
	$file = $board_config['cache_ftp_path'] . '/' . $file;
	
	// so we connected and logged in ok
	// create a temp file stream of this
	
	// /tmp is a default temporary directory for linux machines (which servers usualy are)
	// and if it doesn't exist php takes care to use the temporary directory by itself
	$temp = tempnam( "/tmp", "ftpimg" ); 
		switch ( $size[2] ) 
		{
			case IMGIF:
				imagegif( $image, $temp );
				break;
			case IMJPG:
				imagejpeg( $image, $temp );
				break;
			case IMPNG:
				imagepng( $image, $temp );
				break;
			default:
				imagepng( $image, $temp );
				break;
		}
	if ( !ftp_put( $conn_id, $file, $temp, FTP_BINARY ) ) 
	{
		// clean up
		unlink( $temp );
		fclose( $tmp );
		return FALSE;
	}

	// clean up
	unlink( $temp );

	// we got here and everything is fine
	return TRUE;
}

// since we like to be nice we check the robots.txt
// for allowance of caching with this baby
// we are called phpbb2-imgcache
function see_robots( $file ) {
	
	// find the host root
	if ( empty( $file[1] ) ) 
	{ // this checks if http or something was infront
		$root = $file[0] . '//' . $file[2];
		$start = 3; // where the file actually begins
	}else
	{
		$root = $file[0];
		$start = 1; // where the file actually begins
	}
	
	$robots = $root . '/robots.txt';
	$me = 'phpbb2-imgcache';
		
	// well we have to check it
	// read robots .txt
	if ( !$robots = @file( $robots ) ) 
	{
		return TRUE;
	}
	
	// make the possible combinations for this file to be disallowed
	$combines[0] = '/';
	while ( $start > 0 ) 
	{
		array_shift( $file );
		$start--;
	}
	foreach ( $file as $i => $fold ) 
	{
		$combines[$i + 1] = ( $i < count( $file ) - 1 ) ? $combines[$i] . $fold . '/' : $combines[$i] . $fold;
	}
	
	// now lets go through it line by line
	$inagent = FALSE; // tells if we are in a user-agent block
	$i = 0;
	while ( $i < count( $robots ) ) 
	{
		$line = strtolower( $robots[$i] );
		$line = str_replace( ' ', '', $line );
		$line = str_replace( "\n", '', $line );
		
		if ( !$inagent ) 
		{
			while ( strpos( $line, "user-agent:" ) === FALSE ) 
			{
				$i++;
			}
			$line = strtolower( $robots[$i] );
			$line = str_replace( ' ', '', $line );
			$line = str_replace( "\n", '', $line );
			
			$tmp = explode( ':', $line );
			$tmp[1] = str_replace( ' ', '', $tmp[1] );
			$tmp[1] = str_replace( "\n", '', $tmp[1] );

			if ( ( $tmp[1] == '*' ) || ( $tmp[1] == $me ) ) 
			{
				$inagent = $tmp[1];
			}else
			{
				$inagent = FALSE;
			}
		}elseif ( strpos( $line, "disallow:" ) !== FALSE ) 
		{// check if this is about us
			$tmp = explode( ':', $line );
			$tmp[1] = str_replace( ' ', '', $tmp[1] );
			$tmp[1] = str_replace( "\n", '', $tmp[1] );
			
			if ( $tmp[1] == '' ) 
			{
				return TRUE;
			}elseif( in_array( $tmp[1], $combines ) )
			{
				return FALSE;
			}
		}
		$i++;
	}
	
	// if we got here then we must have the permissions needed
	return TRUE;
}

// puts an image into the cache
function encache( $file, $image, $info, $connected, $conn_id ) {

	global $phpbb_root_path, $db, $board_config;
	
	// check the robots.txt
	// commented out becouse it was seriously slowing down the thing
	//if ( !see_robots( $info ) ) 
	//{
	//	return FALSE;
	//}
	
	$orig = $image;
	$folder = $phpbb_root_path . $board_config['cachepath'];
	
	// lets put the remote file into temp
	
	// /tmp is a default temporary directory for linux machines (which servers usualy are)
	// and if it doesn't exist php takes care to use the temporary directory by itself
	$tempfile = tempnam( "/tmp" , "temp_img" );
	$temp = fopen( $tempfile, "w" );
	if ( !$tmp = @file( $image ) ) 
	{
		return FALSE;
	}
	fwrite( $temp, implode( '',  $tmp ) );
	fclose( $temp );	

	// fetch current cache size since it seem swe're unable to pass $board_config by reference
	$sql = "SELECT config_value FROM " . CONFIG_TABLE . " WHERE config_name='image_cache_size'";
	$r = $db -> sql_fetchrow( $db -> sql_query( $sql ) );
	$cachesize = $r['config_value'];
	// get filesize
	if ( !$bytes = @filesize( $tempfile ) ) 
	{
		// kill temp file
		unlink( $tempfile );
		return FALSE;
	}
	$kbytes = $bytes / 1024; // size of file in kilobytes
	$mbytes = $kbytes / 1024; // size of file in megabytes
	$newcachesize = $mbytes + $cachesize; // size of cache when this iamge is added
	$space = ( diskfreespace( $folder ) / 1024 ) / 1024; // space left on device in MB
	// check if the settings allow us to cache, and if there is even enough space left on device
	if ( ( $kbytes > $board_config['max_image_size'] ) || ( $newcachesize > $board_config['image_cache_maxsize'] ) || ( $mbytes > $space ) )
	{
		// kill temp file
		unlink( $tempfile );
		return FALSE;
	}
	
	// lets check if the GD library is usable
	if ( !extension_loaded('gd') )
	{
		// kill temp file
		unlink( $tempfile );
		return FALSE;
	}
	
	// check if the folder is writable
	if ( is_dir( $folder ) && !$board_config['cache_useftp'] ) 
	{
		if ( !is_writeable( $folder ) ) 
		{
			// kill temp file
			unlink( $tempfile );
			return FALSE;
		}
	}elseif( !$board_config['cache_useftp'] ) 
	{
		// try to create it
		if ( mkdir( $folder ) ) 
		{
			// this is more of a safety precotion, 
			// almost impossible this would happen
			if ( !is_writeable( $folder ) ) 
			{
				// kill temp file
				unlink( $tempfile );
				return FALSE;
			}
		}else
		{
			// kill temp file
			unlink( $tempfile );
			return FALSE;
		}
	}
	
	// get the size of remote image
	if ( !$size = getimagesize( $image ) ) 
	{
		return FALSE;
	}
	$width = $size[0];
	$height = $size[1];
	
	// create temp image of remote resource
	switch ( $size[2] ) 
	{
		case IMGIF:
			$im1 = imagecreatefromgif( $tempfile );
			break;
		case IMJPG:
			$im1 = imagecreatefromjpeg( $tempfile );
			break;
		case IMPNG:
			$im1 = imagecreatefrompng( $tempfile );
			break;
		default:
			$im1 = implode( '', file ( $tempfile ) );
			$im1 = @imagecreatefromstring( $im1 );
	}
	
	if ( $im1 === FALSE ) 
	{
		// kill temp file
		unlink( $tempfile );
		// kill the image just in case
		imagedestroy( $im1 );
		return FALSE;
	}
	
	// temp image
	if ( $board_config['display_thumbs'] ) 
	{
		$newwidth = $board_config['postimg_width'];
		$newheight = $board_config['postimg_height'];
		
		if ( $width > $height && $newheight < $height ) 
		{
			$newheight = $height / ( $width / $newwidth );
		}else if ( $width < $height && $newwidth < $width ) 
		{
			$newwidth = $width / ( $height / $newheight );
		}else
		{
			$newwidth = $width;
			$newheight = $height;
		}
		
		round( $newwidth );
		round( $newheight );
		
		$im2 = imagecreatetruecolor( $newwidth, $newheight + 20 );
	}else
	{
		$im2 = imagecreatetruecolor( $width, $height + 20 );
	}
	
	// black background and white text
	$bg = imagecolorallocate($im2, 0, 0, 0);
	$textcolor = imagecolorallocate($im2, 255, 255, 255);
	
	// the original image
	if ( $board_config['display_thumbs'] ) 
	{
		imagecopyresized( $im2, $im1, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
		$height = $newheight;
		$width = $newwidth;
	}else
	{
		imagecopy( $im2, $im1, 0, 0, 0, 0, $width, $height );
	}
	
	// background for the text
	imagefilledrectangle( $im2, 0, $height, $width, $height + 20, $bg );
	
	// text
	imagestring( $im2, 1, 0, $height, "Cached image:", $textcolor );
	imagestring( $im2, 1, 0, $height + 10, "$image", $textcolor );
	
	// save the image
	if ( !$board_config['cache_useftp'] ) 
	{
		switch ( $size[2] ) 
		{
			case 1:
				imagegif( $im2, $file );
				break;
			case 2:
				imagejpeg( $im2, $file );
				break;
			case 3:
				imagepng( $im2, $file );
				break;
			default:
				imagepng( $im2, $file );
				break;
		}
	}else
	{
		if ( !ftp_encache( $im2, $file, $connected, $conn_id ) ) 
		{
			// kill temp file
			unlink( $tempfile );
			// kill images
			imagedestroy( $im1 );
			imagedestroy( $im2 );
			return FALSE;
		}
	}
		
	if ( !is_file( $file ) ) 
	{
		// kill temp file
		unlink( $tempfile );
		// kill images
		imagedestroy( $im1 );
		imagedestroy( $im2 );
		return FALSE;
	}
	
	// kill temp file
	unlink( $tempfile );
	// lets kill the two images
	imagedestroy( $im1 );
	imagedestroy( $im2 );
	
	// update total cache size var
	$sql = "UPDATE " . CONFIG_TABLE . " SET config_value='$newcachesize' WHERE config_name='image_cache_size'";
	$db -> sql_query( $sql );
	$sql = "UPDATE " . CONFIG_TABLE . " SET config_value=config_value+1 WHERE config_name='cached_images'";
	$db -> sql_query( $sql );
	
	// add this to the hash
	$sql = "INSERT INTO " . CACHE_PROCESSED_TABLE . " ( cached, image, original ) VALUES ( '1', '$file', '$orig' )";
	$db -> sql_query( $sql );
	
	// now return the html that shows this
	return TRUE;
	
}

// returns the correct URL
function fetch_url( $image, $post_id, $connected, $conn_id, $uid ) {

	global $phpbb_root_path, $board_config, $db;
	
	$orig = $image;
	$image = explode( '/', $image );
	
	// check if the image is on this server
	if ( empty( $image[1] ) ) 
	{ // this checks if http or something was infront
		if ( $image[2] == $board_config['server_name'] ) 
		{
			$sameserv = TRUE;
		}else 
		{
			$sameserv = FALSE;
		}
	}else{
		if ( $image[0] == $board_config['server_name'] )
		{
			$sameserv = TRUE;
		}else 
		{
			$sameserv = FALSE;
		}
	}
	
	// if it is just return the url
	if ( $sameserv )
	{
		return "[img:$uid]" . implode( '/', $image ) . "[/img:$uid]";
	}
	//
	// it's on a different server
	//
	// create the filename
	$file = $board_config['cachepath'] . '/' . $post_id . '_' . $image[count( $image ) - 1] . '.png';
	$file = str_replace( '%20', '_', $file ); // some maniacs still use spaces in stuff they put online
	
		
	// check if it's in the hash
	$sql = "SELECT cached, image FROM " . CACHE_PROCESSED_TABLE . " WHERE image='$orig' OR image='$file'";
	$r = $db -> sql_query( $sql );
	if ( $db -> sql_numrows( $r ) != 0 ) 
	{
		$row = $db -> sql_fetchrow( $r );
		return "[img:$uid]" . $orig . "[/img:$uid]";
	}
	
	// this will be used to return the correct url
	$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
	$server_name = trim($board_config['server_name']);
	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) . '/' : '/';
	
	// see if the image is in the cache already and return it
	if ( is_readable( $phpbb_root_path . $file ) ) 
	{
		$out = $server_protocol . $server_name . $server_port . $script_name . '/' . $file;
		return "<a href=\"$orig\" border=\"0\" target=\"_blank\">[img:$uid]" . $out . "[/img:$uid]</a>";
 	}
	// well it's not so lets put it there
	if ( !encache( $phpbb_root_path . $file, $orig, $image, $connected, $conn_id ) ) 
	{
		// add to hash so we know this doesn't get cached
		$sql = "INSERT INTO " . CACHE_PROCESSED_TABLE . " ( cached, image ) VALUES ( '0', '$orig' )";
		$db -> sql_query( $sql );
		return "[img:$uid]" . $orig . "[/img:$uid]";
	}else
	{		
		$out = $server_protocol . $server_name . $server_port . $script_name . '/' . $file;
		return "<a href=\"$orig\" border=\"0\" target=\"_blank\">[img:$uid]" . $out . "[/img:$uid]</a>";
	} 
	
}

// returns the size correction for an image
function makeimgsize ( $w, $h ) {
	
	global $board_config;
	
	if ( $w <= $board_config['postimg_width'] && $h <= $board_config['postimg_height'] ) 
	{
		return 'same';
	}
	if ( $w > $h ) 
	{
		if ( $board_config['postimg_width'] < $w )
		{
			$size = 'width="' . $board_config['postimg_width'] . '"';
		}
	}else
	{
		if ( $board_config['postimg_height'] < $h )
		{
			$size = 'height="' . $board_config['postimg_height'] . '"';
		}
	}
	
	return $size;
}

// parses the posta and corrects image sizes
function adjust_size( $text ) {
	
	global $board_config;
	
	if ( !$board_config['display_thumbs'] ) 
	{
		return $text;
	}
	
	preg_match_all( "/\[(img:$uid)\](\S+)\[\/(img:$uid)\]/i", $post, $matches); 
	foreach ( $matches[2] as $k => $img ) 
	{ 
		if ( $size = @getimagesize( $img ) == 'same' ) 
		{
			continue;
		}
		$w = $size[0]; $h = $size[1]; 
		$size = makeimgsize ( $size[0], $size[1] ); 
		$first = $matches[1][$k]; 
		$secnd = $matches[3][$k]; 
		$p = "[" . $first . "]" . $img . "[/" . $secnd . "]"; 
		
		$click = "<a href=\"#\" onclick=\"javascript: window.open( '$img', 'imgpop',  'width=$w,height=$h,status=no,toolbar=no,menubar=no' );\">";
		
		$result = "$click<img src=\"$img\" border=\"0\" $size /></a>";
		$text = str_replace ( $p, $result, $text ); 
	}
	
	return $text;
}

// replaces all URL's inside [img] tags with new URls
function parse_images( $text, $uid ) {

	global $db, $board_config, $userdata;
	
	// check if caching is enabled
	if ( !$board_config['enable_img_cache'] ) 
	{
		return adjust_size( $text );
	}
	
	
	// connect and login
	if ( $board_config['cache_useftp'] ) 
	{
		if ( $userdata['ftpcache']['connected'] )
		{
			$connected = TRUE;
			$conn_id = $userdata['ftpcache']['conn_id'];
		}else
		{
			return adjust_size( $text );
		}
	}
	
	// get the post and topic id
	$sql = "SELECT p.post_id, p.topic_id " .
		" FROM " . POSTS_TEXT_TABLE . " pt LEFT JOIN " . POSTS_TABLE . " p ON p.post_id=pt.post_id ".
		"WHERE pt.bbcode_uid='$uid'";
	$r = $db -> sql_fetchrow( $db -> sql_query( $sql ) );
	$post_id = $r['post_id'];
	$topic_ = $r['topic_id'];
	
	$text = explode( "\n", $text );
	
	// go through the array and do the replacements
	foreach( $text as $i => $line ) 
	{
		preg_match_all( "#\[img:$uid\](.*?)\[/img:$uid\]#si", $line, $match );
		
		// go through the matches
		foreach ( $match[1] as $inx => $image ) 
		{
			$nimg = fetch_url( $image, $post_id, $connected, $conn_id, $uid );
			// put the new URL where it belongs
			$line = str_replace( $match[0][$inx], $nimg, $line );
		}
		$text[$i] = $line;
	}
	
	$text = implode( "\n", $text );
	
	return adjust_size( $text, $uid );
}

// this will set up an ftp connection if it hasn't yet been established
function connect_ftp ( $conn_id = 0, $end = FALSE ) {

	global $board_config;

	if ( !$board_config['cache_useftp'] ) 
	{
		return FALSE;
	}
	
	if ( $end ) @ftp_quit( $conn_id );

	$ftp = $board_config['cache_ftp'];
	$ftp_port = $board_config['cache_ftp_port'];
	$ftp_user = $board_config['cache_ftp_user'];
	$ftp_pass = $board_config['cache_ftp_pass'];
	if ( !$conn_id = @ftp_connect( $ftp, $ftp_port ) ) 
	{
		$connected = FALSE;
	}elseif ( !$login_result = @ftp_login( $conn_id, $ftp_user, $ftp_pass) ) 
	{
		@ftp_quit( $conn_id );
		$connected = FALSE;
	}else
	{
		$connected = TRUE;
	}
	
	$ret['connected'] = $connected;
	$ret['conn_id'] = $conn_id;
	return $ret;
}

?>