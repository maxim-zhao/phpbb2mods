<?php
//
//	file: create_btf.php
//	author: ptirhiik
//	begin: 28/12/2006
//	version: 1.6.0 phpBB - 28/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);

$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'create_btf';
include($phpbb_root_path . 'common.' . $phpEx);

define('BL_X', 0);
define('BL_Y', 1);
define('BR_X', 2);
define('BR_Y', 3);
define('UR_X', 4);
define('UR_Y', 5);
define('UL_X', 6);
define('UL_Y', 7);

function arrayline($key, $value)
{
	return sprintf('
	\'%s\' => \'%s\',', $key, $value);
}

$fonts_dir = 'includes/vc/fonts';
$width = 40;
$height = 40;
$width_byte = ceil($width / 8);
$width = $width_byte * 8;

// chars
$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$len_chars = strlen($chars);

// get fonts
$ttfs = array();
$btfs = array();
$handle = @opendir($fonts_dir);
while ( $filename = @readdir($handle) )
{
	if ( preg_match('/\.ttf$/i', $filename) )
	{
		$ttfs[] = $fonts_dir . '/' . substr($filename, 0, -4);
	}
	if ( preg_match('/\.btf$/i', $filename) )
	{
		$btfs[ $fonts_dir . '/' . substr($filename, 0, -4) ] = true;
	}
}
@closedir($ttfs);
$count_fonts = count($ttfs);

$angle = 0;
$charmap = array();
$ypad = 1;
$xpad = 1;
$mem = 0;
for ( $i = 0; $i < $count_fonts; $i++ )
{
	if ( isset($btfs[ $ttfs[$i] ]) )
	{
		continue;
	}
	$font = $phpbb_root_path . $ttfs[$i] . '.ttf';
	$max_cw = $max_ch = 0;

	$charmap = array();
	for ( $j = 0; $j < $len_chars; $j++ )
	{
		// get the appropriate size
		$size = $height - 2;
		do
		{
			$box = imagettfbbox($size, $angle, $font, $chars[$j]);
			$cw = $box[UR_X] - $box[UL_X] + 1;
			$ch = $box[BR_Y] - $box[UR_Y] + 1;
			if ( ($cw + (2 * $xpad) > $width) || ($ch + (2 * $ypad) > $height) )
			{
				$size--;
			}
			else
			{
				break;
			}
		}
		while ( true );

		// create the image
		$img = imagecreatetruecolor($width, $height);
		$background_color = imagecolorallocate($img, 0x00, 0x00, 0x00);
		$front_color = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
		imagefill($img, 0, 0, $background_color);

		$cx = floor(($width - $cw) / 2 - $box[BL_X]);
		$cy = $height - 1 - ceil(($height - $ch) / 2 + $box[BL_Y]);
		imagettftext($img, $size, $angle, $cx, $cy, $front_color, $font, $chars[$j]);
		$char = '';
		for ( $y = 0; $y < $height; $y++ )
		{
			$byte = 0;
			$encoded = 0;
			for ( $x = 0; $x < $width_byte; $x++ )
			{
				$encoded = 0;
				$byte = 1;
				for ( $k = 7; $k >= 0; $k-- )
				{
					if ( imagecolorat($img, $x * 8 + $k, $y) )
					{
						$encoded += $byte;
					}
					$byte = $byte << 1;
				}
				$char .= chr($encoded);
			}
		}
		imagedestroy($img);
		$charmap[ $chars[$j] ] = base64_encode($char);
	}

	// create the file
	$data = '<?' . 'php
//
//	file: ' . $ttfs[$i] . '.btf
//	author: ptirhiik
//	begin: 29/12/2006
//	version: 1.6.0 - ' . date('d/m/Y', time()) . '
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//
if ( !defined(\'IN_PHPBB\') )
{
	die(\'Hacking attempt\');
}

$_png = array(' . implode('', array_map('arrayline', array_keys($charmap), array_values($charmap))) . '
);

?>';

	// write the file
	$font = $phpbb_root_path . $ttfs[$i] . '.btf';
	if ($fp = @fopen($font, 'wb'))
	{
		@flock($fp, LOCK_EX);
		@fwrite ($fp, $data);
		@flock($fp, LOCK_UN);
		@fclose($fp);

		@umask(0000);
		@chmod($font, 0644);
	}
}
message_die(GENERAL_MESSAGE, 'Done');


?>