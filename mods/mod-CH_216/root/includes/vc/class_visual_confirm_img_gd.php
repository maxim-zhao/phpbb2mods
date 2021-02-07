<?php
//
//	file: includes/vc/class_visual_confirm_img_gd.php
//	author: ptirhiik
//	begin: 17/03/2006
//	version: 1.6.2 - 22/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class visual_confirm_img_gd extends visual_confirm_img
{
	var $funcs;

	var $code;
	var $palette;
	var $back;

	function visual_confirm_img_gd()
	{
		$this->funcs = false;
		$this->palette = array();
		$this->back = false;

		parent::visual_confirm_img();
	}

	function init()
	{
		$ok = true;

		// functions
		$this->funcs = array(
			'create' => function_exists('imagecreatetruecolor'),
			'copy' => function_exists('imagecopyresampled'),
		);
		$ok = ($this->funcs['create'] || function_exists('imagecreate')) && ($this->funcs['copy'] || function_exists('imagecopyresized'));

		// check ttf support
		$ok = $ok && function_exists('imagettftext');

		// read available ttf
		$ok = $ok && ($this->fonts = $this->get_rsc($this->fonts_dir, '/\.ttf$/i'));
		return $ok;
	}

	function display()
	{
		$dst = false;
		$this->background($dst);
		$this->text($dst);
		$this->output($dst);
	}

	function output(&$dst)
	{
		header('Content-Type: image/png');
		header('Cache-control: no-cache, no-store');
		imagepng($dst);
		imagedestroy($dst);
	}

	function background(&$dst)
	{
		$handled = false;
		if ( !$handled && ($this->rand(0, 0xFF) < 0x40) )
		{
			$handled = $this->pic_background(&$dst);
		}
		if ( !$handled && ($this->rand(0, 0xFF) < 0x80) )
		{
			$handled = $this->chars_background(&$dst);
		}
		if ( !$handled )
		{
			$handled = $this->noise_background(&$dst);
		}
	}

	function text(&$dst)
	{
		$font_range = array(0, count($this->fonts) - 1);
		$font_size_range = array(round($this->height / 3), round($this->height / 2.3));
		$font_color_range = array('A0A0A0', 'FFFFFF');
		$reflect_color_range = array('202020', $font_color_range[0]);
		$reflect_range = $this->back == 'chars' ? array(2, 4) : array(-2, +2);
		$angle = round(30 * $this->rotation / 100);
		$angle_range = array(- $angle, $angle);
		$len_code = strlen($this->code);
		if ( $this->back == 'chars' )
		{
			$txt = &$dst;
		}
		else
		{
			$txt = $this->imagecreatetruecolor($this->width, $this->height);
		}
		$xoffset = $this->rand($font_size_range[1] / 4, $font_size_range[1]);
		for ( $i = 0; $i < $len_code; $i++ )
		{
			$font = $this->rsc_name($this->fonts_dir, $this->fonts[ $this->rand($font_range) ]);
			$size = $this->rand($font_size_range);
			$angle = $this->rand($angle_range);
			$yoffset = $this->rand($angle < 0 ? $size + 2 : round($size + 2 + ($size * $angle * 2.5 / 100)), round($this->height + ($angle < 0 ? round($size * $angle * 2.5 / 100) : -2)));
			$xoffset += $this->rand(-round($size / 10), round($size / 10));

			$reflect_xpad = $this->rand($reflect_range);
			$reflect_ypad = $this->rand($reflect_range);
			$color = $this->color($txt, $reflect_color_range);
			imagettftext($txt, $size, $angle, $xoffset + $reflect_xpad, $yoffset + $reflect_ypad, $color, $font, $this->code[$i]);

			$color = $this->color($txt, $font_color_range);
			imagettftext($txt, $size, $angle, $xoffset, $yoffset, $color, $font, $this->code[$i]);
			$xoffset += round($size * 1.6);
		}

		// merge with background
		if ( $this->back != 'chars' )
		{
			imagecopymerge($dst, $txt, 0, 0, 0, 0, $this->width, $this->height, $this->back == 'pic' ? 50 : 40);
			imagedestroy($txt);
		}
	}

	function pic_background(&$dst)
	{
		if ( !($backgrounds = $this->get_rsc($this->backs_dir, '/\.jpg$/i')) )
		{
			return false;
		}

		$filename = $backgrounds[ $this->rand(0, count($backgrounds) - 1) ];
		unset($backgrounds);
		if ( !($src = @imagecreatefromjpeg($this->rsc_name($this->backs_dir, $filename))) )
		{
			return false;
		}

		// adjust to the appropriate size
		$dst = $this->imagecreatetruecolor($this->width, $this->height);
		$this->imagecopyresampled($dst, $src, 0, 0, 0, 0, $this->width, $this->height, imagesx($src), imagesy($src));
		imagedestroy($src);

		$this->back = 'pic';
		return true;
	}

	function noise_background(&$dst)
	{
		$color_range = array('A0A0A0', 'F0F0F0');
		$line_dir_range = array(-50, 50);
		$line_thick_range = array(1, 7);
		$ellipse_size_range = array(5, $this->height);

		$dst = $this->imagecreatetruecolor($this->width, $this->height);
		imagefill($dst, 0, 0, $this->color($dst, $color_range));
		$count = $this->rand(5, round(100 * $this->noise / 100));
		for ( $i = 0; $i < $count; $i ++)
		{
			imagesetthickness($dst, $this->rand($line_thick_range));
			if ( $this->rand(0, 0xFF) > 0x80 )
			{
				imagefilledellipse($dst, $this->rand(0, $this->width), $this->rand(0, $this->height), $this->rand($ellipse_size_range), $this->rand($ellipse_size_range), $this->color($dst, $color_range));
			}
			else
			{
				imageline($dst, $this->rand(0, round($this->width * 2 / 5)), $this->rand(0, $this->height), $this->rand(round($this->width * 3 / 5), $this->width), $this->rand(0, $this->height), $this->color($dst, $color_range));
			}
		}
		$this->back = 'noise';
		return true;
	}

	function chars_background(&$dst)
	{
		$font_range = array(0, count($this->fonts) - 1);
		$font_size_range = array(intval($this->height / 10), intval($this->height / 2));
		$font_color_range = array('000000', 'A0A0A0');
		$len_code_range = array(round($this->noise * 20 / 100), round($this->noise * 80 / 100));
		$angle_range = array(40, 340);
		$x_range = array(0, $this->width);
		$y_range = array(0, $this->height);
		$code = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code_range = array(0, strlen($code));

		$dst = $this->imagecreatetruecolor($this->width, $this->height);
		imagefill($dst, 0, 0, $this->color($dst, $this->color($dst, 'FFFFF0')));

		$len_code = $this->rand($len_code_range);
		for ( $i = 0 ; $i < $len_code; $i++ )
		{
			$size = $this->rand($font_size_range);
			$angle = $this->rand($angle_range);
			$xoffset = $this->rand($x_range);
			$yoffset = $this->rand($y_range);
			$font = $this->rsc_name($this->fonts_dir, $this->fonts[ $this->rand($font_range) ]);
			$color = $this->color($dst, $font_color_range);
			imagettftext($dst, $size, $angle, $xoffset, $yoffset, $color, $font, $code[ $this->rand($code_range) ]);
		}
		$this->back = 'chars';
		return true;
	}

	function color(&$dst, $range='')
	{
		if ( empty($range) )
		{
			$range = array('000000', 'FFFFFF');
		}
		if ( is_array($range) )
		{
			$min = $this->hex2rgb($range[0]);
			$max = $this->hex2rgb($range[1]);
			$rgb = array($this->rand($min[0], $max[0]), $this->rand($min[1], $max[1]), $this->rand($min[2], $max[2]));
			unset($min);
			unset($max);
			$hex = $this->rgb2hex($rgb);
		}
		else
		{
			$hex = $range;
			$rgb = $this->hex2rgb($hex);
		}
		if ( !isset($this->palette[$hex]) )
		{
			$this->palette[$hex] = imagecolorallocate($dst, $rgb[0], $rgb[1], $rgb[2]);
		}
		return $this->palette[$hex];
	}

	function imagecreatetruecolor($width, $height)
	{
		$this->palette = array();
		return $this->funcs['create'] ? imagecreatetruecolor($width, $height) : imagecreate($width, $height);
	}

	function imagecopyresampled(&$dst, &$src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
	{
		return $this->funcs['copy'] ? imagecopyresampled($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) : imagecopyresized($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	}
}

?>