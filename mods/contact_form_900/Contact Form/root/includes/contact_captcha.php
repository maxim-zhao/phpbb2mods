<?php
/***************************************************************************
 *                            contact_captcha.php
 *                            -------------------
 *	Version:	9.0.0
 *	Begin:		Tuesday, Dec 06, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:55 25/06/2007
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

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

@session_start();

$contact_config = array();

$sql = "SELECT *
	FROM " . CONTACT_CONFIG_TABLE;

if(!($result = $db->sql_query($sql)))
{
	message_die(CRITICAL_ERROR, 'Could not query config information', '', __LINE__, __FILE__, $sql);
}
while ($row = $db->sql_fetchrow($result))
{
	$contact_config[$row['config_name']] = $row['config_value'];
}

//
// Seed the random number generator
// 104729 is the 10000th prime number
//
mt_srand((double)microtime() * 104729);
$random = md5(mt_rand() * microtime());
$digit = rand(1,9);
$random = str_replace(0, $digit, $random); // Substitute zeros
$length = rand(4,5);
$captcha = substr($random, 0, $length);
unset($random, $digit);

$type = '';

if($contact_config['contact_captcha_type'] == 2)
{
	if(function_exists('glob'))
	{
		$type = rand(0,1);
	}
	else
	{
		$type = 1; // PHP < 4.3.0
	}
}

if($contact_config['contact_captcha_type'] == 0 || $type == 0)
{
	unset($type);

	foreach(glob($phpbb_root_path . 'images/captcha/captcha*.png') as $bgimg);

	if(empty($bgimg))
	{
		$type = 1;
	}
	else
	{
		//
		// Image based CAPTCHA
		//
		$bg = rand(1,5);
		$image = @imagecreatefrompng($phpbb_root_path . 'images/captcha/captcha'.$bg.'.png');
		$txtcol = imagecolorallocate($image, 0, 0, 0);

		display_code($captcha);
	}
}

if($contact_config['contact_captcha_type'] == 1 || $type == 1)
{
	unset($type);

	//
	// Coloured CAPTCHA
	//
	$image = imagecreate(80,25);
	$background = imagecolorallocatealpha($image, rand(125,255), rand(125,255), rand(125,255), rand(50,100));
	$linecol = imagecolorallocatealpha($image, rand(50,200), rand(50,200), rand(50,200), rand(20,80));
	$txtcol = imagecolorallocate($image, 0,0,0);
	$blk = imagecolorallocate($image, 0,0,0);

	//
	// Random Lines
	//
	$lines = rand(2,5);

	for($i=1; $i<=$lines; $i++)
	{
		imageline($image, rand(2,78), rand(2,23), rand(78,2), rand(23,2), $linecol);
	}

	//
	// Border Lines
	//
	imageline($image, 0, 0, 79, 0, $blk);
	imageline($image, 0, 0, 0, 24, $blk);
	imageline($image, 79, 24, 0, 24, $blk);
	imageline($image, 79, 24, 79, 0, $blk);

	display_code($captcha);
}

function display_code($captcha)
{
	global $phpbb_root_path;
	global $txtcol, $image, $length;

	if(function_exists('imagettftext'))
	{
		for($i=1; $i<=$length; $i++)
		{
			//
			// Rotate Characters
			//
			$rotate = rand(1,2);

			if($rotate == 1)
			{
				$angle = rand(0,25);
			}
			else
			{
				$angle = rand(335,360);
			}

			//
			// TTF's Fonts
			//
			$font = rand(1,4);

			switch ($font)
			{
				case 1:
					imagettftext($image, rand(12,14), $angle, ($i*12), 20, $txtcol, $phpbb_root_path . 'fonts/VillageSquare.ttf', substr($captcha,($i-1),1));
					break;

				case 2:
					imagettftext($image, rand(12,14), $angle, ($i*12), 20, $txtcol, $phpbb_root_path . 'fonts/BauerBodoniItalicBT.ttf', substr($captcha,($i-1),1));
					break;

				case 3:
					imagettftext($image, rand(12,14), $angle, ($i*12), 20, $txtcol, $phpbb_root_path . 'fonts/WarmMilk.ttf', substr($captcha,($i-1),1));
					break;

				case 4:
					imagettftext($image, rand(12,14), $angle, ($i*12), 20, $txtcol, $phpbb_root_path . 'fonts/OregonDry.ttf', substr($captcha,($i-1),1));
					break;
			}
		}
	}
	else
	{
		//
		// Standard PHP Font
		//
		imagestring($image, rand(4,5), rand(13,18), 4, $captcha, $txtcol);
	}
}

if(@ini_get('register_globals') == '0' || strtolower(@ini_get('register_globals')) == 'off')
{
	$HTTP_SESSION_VARS['randi'] = $captcha;
}
else
{
	// PHP5
	$_SESSION['randi'] = $captcha;
}

header("Content-type: image/png");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: " . gmdate("D, d M Y H:i:s", time()) . " GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

imagepng($image);
imagedestroy($image);

?>