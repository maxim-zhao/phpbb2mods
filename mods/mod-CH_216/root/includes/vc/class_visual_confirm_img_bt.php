<?php
//
//	file: includes/vc/class_visual_confirm_img_bt.php
//	author: ptirhiik
//	begin: 17/03/2006
//	version: 1.6.2 - 22/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class visual_confirm_img_bt extends visual_confirm_img
{
	var $zlib;

	function visual_confirm_img_bt()
	{
		$this->width = 360;
		$this->height = 90;
		$this->zlib = @extension_loaded('zlib');

		parent::visual_confirm_img();
	}

	function init()
	{
		$ok = true;

		// read available btf
		$ok = $ok && ($this->fonts = $this->get_rsc($this->fonts_dir, '/\.btf$/i'));

		return $ok;
	}

	function display()
	{
		$dst = false;
		$this->background($dst);
		$this->text($dst);
		$this->output($dst);
		unset($dst);
	}

	function output(&$dst)
	{
		$this->compress($dst);
		header('Content-Type: image/png');
		header('Cache-control: no-cache, no-store');
		echo $dst;
	}

	function background(&$dst)
	{
		$background_range = array('666666', 'CCCCCC');
		$background_color = $this->color($background_range);
		$dst = array_pad(array(), $this->height, str_pad('', $this->width, chr($background_color)));
		if ( $this->rand(0, 0xFF) < 0x80 )
		{
			$this->noise_background(&$dst);
		}
		else
		{
			$this->chars_background(&$dst);
		}
	}

	function noise_background(&$dst)
	{
		$noise_range = array('333333', 'CCFFCC');
		$count = $this->rand(5, round(100 * $this->noise / 100));
		for ( $i = 0; $i < $count; $i ++)
		{
			$x0 = $this->rand(0, $this->width);
			$y0 = $this->rand(0, $this->height);
			$angle = deg2rad($this->rand(-180, +180));
			$cos = cos($angle);
			$sin = sin($angle);
			$noise_color = $this->color($noise_range);
			$thick = $this->rand(1, 5);
			for ( $j = 0; $this->width; $j++ )
			{
				$x = round($cos * $j) + $x0;
				$y = round($sin * $j) + $y0;
				for ( $k = 0; $k < $thick; $k++ )
				{
					if ( ($x < 0) || ($x >= $this->width) || ($y < 0) || ($y >= $this->height) )
					{
						break;
					}
					$dst[$y][$x] = chr($noise_color);
					$x++;
					$y++;
				}
				if ( ($x < 0) || ($x >= $this->width) || ($y < 0) || ($y >= $this->height) )
				{
					break;
				}
			}
		}
	}

	function chars_background(&$dst)
	{
		$font_range = array(0, count($this->fonts) - 1);
		$noise_range = array('333333', 'FF9999');
		$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$len_chars = strlen($chars);
		$len_code_range = array(round($this->noise * 20 / 100), round($this->noise * 80 / 100));
		$len_code = $this->rand($len_code_range);
		for ( $i = 0; $i < $len_code; $i++ )
		{
			$xoffset = $this->rand(0, $this->width - 40);
			$yoffset = $this->rand(0, $this->height - 40);
			$angle = $this->rand(-180, +180);
			$ratio = $this->rand(50, 150) / 100;
			$cos = cos($angle);
			$sin = sin($angle);

			$font = $this->rsc_name($this->fonts_dir, $this->fonts[ $this->rand($font_range) ]);
			$noise_color = $this->color($noise_range);
			$this->imagebtf($dst, $ratio, $angle, $xoffset, $yoffset, $noise_color, $font, $chars[ $this->rand(0, $len_chars - 1) ]);
		}
	}

	function text(&$dst)
	{
		$len_code = strlen($this->code);
		$max_width = 40;
		$max_height = 40;

		// colors: font
		$front_range = array('99CCCC', 'FFFFFF');
		$reflect_range = array('000000', '333333');

		// font
		$font_range = array(0, count($this->fonts) - 1);
		$ratio_range = array(80, 125);
		$angle = round(30 * $this->rotation / 100);
		$angle_range = array(- $angle, $angle);

		// process the chars
		$xpad_total = $this->width - ($len_code + 1) * $max_width + 2;
		$ypad_total = $this->height - $max_height - 2;

		$xoffset = 0;
		$x0 = $cw / 2;
		$y0 = $ch / 2;
		for ( $i = 0; $i < $len_code; $i++ )
		{
			$xpad = $this->rand(0, max(0, ceil($xpad_total / ($len_code - $i))));
			$xpad_total -= $xpad;
			$xoffset += $xpad;
			$yoffset = $this->rand(0, $ypad_total);

			// rotate and change size
			$ratio = $this->rand($ratio_range) / 100;
			$angle = $this->rand($angle_range);

			// put the char on the map
			$font = $this->rsc_name($this->fonts_dir, $this->fonts[ $this->rand($font_range) ]);
			$front_color = $this->color($front_range);
			$reflect_color = $this->color($reflect_range);
			$xoffset += $this->imagebtf($dst, $ratio, $angle, $xoffset, $yoffset, $front_color, $font, $this->code[$i], $reflect_color);
		}
		$dst = chr(0) . implode(chr(0), $dst);
	}

	function imagebtf(&$dst, $ratio, $angle, $xoffset, $yoffset, $front_color, $font_file, $char, $reflect_color=false)
	{
		$cw = 40;
		$ch = 40;
		$x0 = $cw / 2;
		$y0 = $ch / 2;

		$angle = deg2rad($angle);
		$cos = $ratio * cos($angle);
		$sin = $ratio * sin($angle);

		// char def
		$map = explode("\n", substr(chunk_split(base64_decode($this->get_char($font_file, $char)), ceil($cw / 8), "\n"), 0, -1));

		$reflect_inc = 4;
		$count_map = count($map);
		// line
		for ( $i = 0; $i < $count_map; $i++ )
		{
			// one byte for 8 points
			$len_map = strlen($map[$i]);
			for ( $j = 0; $j < $len_map; $j++ )
			{
				if ( ord($map[$i][$j]) == 0 )
				{
					continue;
				}
				$xbyte = $j * 8 - $x0;
				$sin_y_ofs = $sin * ($i - $y0) - ($x0 + $xoffset);
				$cos_y_ofs = $cos * ($i - $y0) + ($y0 + $yoffset);
				$mask = 0x100 >> 1;
				// bits
				for ( $k = 0; $k < 8; $k++ )
				{
					if ( ord($map[$i][$j]) & $mask )
					{
						$x = round(($xbyte + $k) * $cos - $sin_y_ofs);
						$y = round(($xbyte + $k) * $sin + $cos_y_ofs);
						if ( ($x > 0) && ($x < $this->width) && ($y > 0) && ($y < $this->height) )
						{
							$dst[$y][$x] = chr($front_color);
						}
						if ( $reflect_color !== false )
						{
							$x += $reflect_inc;
							$y += $reflect_inc;
							if ( ($x > 0) && ($x < $this->width) && ($y > 0) && ($y < $this->height) )
							{
								$dst[$y][$x] = chr($reflect_color);
							}
						}
					}
					$mask = $mask >> 1;
				}
			}
		}
		return $cw;
	}

	function get_char($font_file, $char)
	{
		include($font_file);
		return $_png[$char];
	}

	function color($range, $max=0)
	{
		$min = is_array($range) ? $this->hex2rgb($range[0]) : $this->hex2rgb($range);
		$max = is_array($range) ? $this->hex2rgb($range[1]) : $this->hex2rgb($max);
		return round($this->rand($min[0], $max[0]) / 0x33) * 36 + round($this->rand($min[1], $max[1]) / 0x33) * 6 + round($this->rand($min[2], $max[2]) / 0x33);
	}

	// compress the raw image to make it a png
	function compress(&$dst)
	{
		$raw_image = $dst;

		// SIG
		$dst = pack('C8', 137, 80, 78, 71, 13, 10, 26, 10);

		// IHDR
		$color_type = 3; // palette
		$raw = pack('C4', $this->width >> 24, $this->width >> 16, $this->width >> 8, $this->width);
		$raw .= pack('C4', $this->height >> 24, $this->height >> 16, $this->height >> 8, $this->height);
		$raw .= pack('C5', 8, $color_type, 0, 0, 0);
		$dst .= $this->encode('IHDR', $raw);

		// create a safe color palette
		$raw = '';
		for ( $r = 0; $r <= 0xFF; $r += 0x33 )
		{
			for ( $g = 0; $g <= 0xFF; $g += 0x33 )
			{
				for ( $b = 0; $b <= 0xFF; $b += 0x33 )
				{
					$raw .= pack('C3', $r, $g, $b);
				}
			}
		}
		$dst .= $this->encode('PLTE', $raw);
		unset($raw);

		if ( $this->zlib )
		{
			$raw_image = gzcompress($raw_image);
		}
		else
		{
			// The total length of this image, uncompressed, is just a calculation of pixels
			$length = ($this->width + 1) * $this->height;

			// Adler-32 hash generation
			// Optimized Adler-32 loop ported from the GNU Classpath project
			$temp_length = $length;
			$s1 = 1;
			$s2 = $index = 0;
			while ( $temp_length > 0 )
			{
				// We can defer the modulo operation:
				// s1 maximally grows from 65521 to 65521 + 255 * 3800
				// s2 maximally grows by 3800 * median(s1) = 2090079800 < 2^31
				$substract_value = ($temp_length < 3800) ? $temp_length : 3800;
				$temp_length -= $substract_value;
				while ( --$substract_value >= 0 )
				{
					$s1 += ord($raw_image[$index]);
					$s2 += $s1;
					$index++;
				}
				$s1 %= 65521;
				$s2 %= 65521;
			}
			$adler_hash = pack('N', ($s2 << 16) | $s1);

			// This is the same thing as gzcompress($raw_image, 0) but does not need zlib
			$raw_image = pack('C3v2', 0x78, 0x01, 0x01, $length, ~$length) . $raw_image . $adler_hash;
		}

		// IDAT + IEND
		$dst .= $this->encode('IDAT', $raw_image) . $this->encode('IEND', '');
	}

	// This creates a chunk of the given type, with the given data
	// of the given length adding the relevant crc
	function encode($blockname, $data)
	{
		$raw = $blockname . $data;
		$crc = crc32($raw);
		$raw .= pack('C4', $crc >> 24, $crc >> 16, $crc >> 8, $crc);
		$length = strlen($data);
		return pack('C4', $length >> 24, $length >> 16, $length >> 8, $length) . $raw;
	}
}

?>