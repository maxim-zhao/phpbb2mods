##############################################################
## MOD Title: Basic BBcodes
## MOD Author: 0racle < webmaster@qbnz.com > (N/A) http://qbnz.com/phpBB
## MOD Description: Adds several basic BBCodes to the default installation: [br], [hr], [h1] - [h6], [rainbow], [sub], [sup], [serif], [sans], [mono], [md5] and [reverse].
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: includes/bbcode.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## This mod is easy to install, and adds some good bbcodes for "official"
## posts, like rules etc.
##
##############################################################
## MOD History:
##
##   2004-08-18 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

includes/bbcode.php

#
#-----[ FIND ]------------------------------------------
#

	// [i] and [/i] for italicizing text.
	$text = str_replace("[i:$uid]", $bbcode_tpl['i_open'], $text);
	$text = str_replace("[/i:$uid]", $bbcode_tpl['i_close'], $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	//
	// BEGIN Basic codes mod
	//
  
	// [br] for adding line breaks
	$text = str_replace("[br:$uid]", '<br /><span style="display: none;">&nbsp;</span>', $text);
  
	// [hr] for adding a horizontal rule
	$text = str_replace("[hr:$uid]", '<hr />', $text);

	// [hX] for adding headers
	$text = str_replace("[h1:$uid]", '<span style="font-size: 24px; font-weight: bold;">', $text);
	$text = str_replace("[h2:$uid]", '<span style="font-size: 22px; font-weight: bold;">', $text);
	$text = str_replace("[h3:$uid]", '<span style="font-size: 20px; font-weight: bold;">', $text);
	$text = str_replace("[h4:$uid]", '<span style="font-size: 18px; font-weight: bold;">', $text);
	$text = str_replace("[h5:$uid]", '<span style="font-size: 16px; font-weight: bold;">', $text);
	$text = str_replace("[h6:$uid]", '<span style="font-size: 14px; font-weight: bold;">', $text);
  
	$text = preg_replace("#\[/h[1-6]:$uid\]#si", '</span>', $text);
  
	// [sub] for subscript text
	$text = str_replace("[sub:$uid]", '<sub>', $text);
	$text = str_replace("[/sub:$uid]", '</sub>', $text);

	// [sup] for superscript text
	$text = str_replace("[sup:$uid]", '<sup>', $text);
	$text = str_replace("[/sup:$uid]", '</sup>', $text);

	// [serif] for serif text
	$text = str_replace("[serif:$uid]", '<span style="font-family: serif;">', $text);
	$text = str_replace("[/serif:$uid]", '</span>', $text);

	// [sans] for sans-serif text
	$text = str_replace("[sans:$uid]", '<span style="font-family: sans-serif;">', $text);
	$text = str_replace("[/sans:$uid]", '</span>', $text);

	// [mono] for monospace text
	$text = str_replace("[mono:$uid]", '<span style="font-family: monospace;">', $text);
	$text = str_replace("[/mono:$uid]", '</span>', $text);

	// [md5] for md5 hashes
	$text = preg_replace("#\[md5:$uid\](.*?)\[/md5:$uid\]#sie", "md5('\\1')", $text);
  
	// [reverse] for reversing text
	$text = preg_replace("#\[reverse:$uid\](.*?)\[/reverse:$uid\]#sie", "strrev('\\1')", $text);

	// [rainbow] for rainbow-highlighting text
	$text = preg_replace("#\[rainbow:$uid\](.*?)\[/rainbow:$uid\]#sie", "rainbow('\\1')", $text);
  
	//
	// END Basic codes mod
	//

#
#-----[ FIND ]------------------------------------------
#

	// [i] and [/i] for italicizing text.
	$text = preg_replace("#\[i\](.*?)\[/i\]#si", "[i:$uid]\\1[/i:$uid]", $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	//
	// BEGIN Basic codes mod
	//

	// [br] for adding a line break
	$text = preg_replace("#\[br\]#si", "[br:$uid]", $text);

	// [hr] for adding a horizontal rule
	$text = preg_replace("#\[hr\]#si", "[hr:$uid]", $text);

	// [hX] for adding titles
	$text = preg_replace("#\[h1\](.*?)\[/h1\]#si", "[h1:$uid]\\1[/h1:$uid]", $text);
	$text = preg_replace("#\[h2\](.*?)\[/h2\]#si", "[h2:$uid]\\1[/h2:$uid]", $text);
	$text = preg_replace("#\[h3\](.*?)\[/h3\]#si", "[h3:$uid]\\1[/h3:$uid]", $text);
	$text = preg_replace("#\[h4\](.*?)\[/h4\]#si", "[h4:$uid]\\1[/h4:$uid]", $text);
	$text = preg_replace("#\[h5\](.*?)\[/h5\]#si", "[h5:$uid]\\1[/h5:$uid]", $text);
	$text = preg_replace("#\[h6\](.*?)\[/h6\]#si", "[h6:$uid]\\1[/h6:$uid]", $text);

	// [sub] for subscript text
	$text = preg_replace("#\[sub\](.*?)\[/sub\]#si", "[sub:$uid]\\1[/sub:$uid]", $text);

	// [sup] for superscript text
	$text = preg_replace("#\[sup\](.*?)\[/sup\]#si", "[sup:$uid]\\1[/sup:$uid]", $text);

	// [serif] for serif text
	$text = preg_replace("#\[serif\](.*?)\[/serif\]#si", "[serif:$uid]\\1[/serif:$uid]", $text);

	// [sans] for sans text
	$text = preg_replace("#\[sans\](.*?)\[/sans\]#si", "[sans:$uid]\\1[/sans:$uid]", $text);

	// [mono] for monospace text
	$text = preg_replace("#\[mono\](.*?)\[/mono\]#si", "[mono:$uid]\\1[/mono:$uid]", $text);

	// [md5] for md5 hashes
	$text = preg_replace("#\[md5\](.*?)\[/md5\]#si", "[md5:$uid]\\1[/md5:$uid]", $text);

	// [reverse] for reverse text
	$text = preg_replace("#\[reverse\](.*?)\[/reverse\]#si", "[reverse:$uid]\\1[/reverse:$uid]", $text);

	// [rainbow] for rainbow-highlighting text
	$text = preg_replace("#\[rainbow\](.*?)\[/rainbow\]#si", "[rainbow:$uid]\\1[/rainbow:$uid]", $text);
	
	//
	// END Basic codes mod
	//

#
#-----[ FIND ]------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

//
// BEGIN Basic codes mod
//
function rainbow($text)
{
	//
	// Returns text highlighted in rainbow colours
	//
	
	if ( !defined('RAINBOW_COLORS_LOADED') )
	{
		$colors = load_rainbow_colors ();
	}
	$text = trim(stripslashes($text));
	$length = strlen($text);
	$result = '';
	$color_counter = 0;
	$TAG_OPEN = false;
	for ( $i = 0; $i < $length; $i++ )
	{
		$char = substr($text, $i, 1);
		if ( !$TAG_OPEN )
		{
			if ( $char == '<' )
			{
				$TAG_OPEN = true;
				$result .= $char;
			}
			elseif ( preg_match("#\S#i", $char) )
			{
				$color_counter++;
				$result .= '<span style="color: ' . $colors[$color_counter] . ';">' . $char . '</span>';
				$color_counter = ( $color_counter == 7 ) ? 0 : $color_counter;
			}
			else
			{
				$result .= $char;
			}
		}
		else
		{
			if ( $char == '>' )
			{
				$TAG_OPEN = false;
			}
			$result .= $char;
		}
	}
	return $result;
}

function load_rainbow_colors ()
{
	return array(
		1 => 'red',
		2 => 'orange',
		3 => 'yellow',
		4 => 'green',
		5 => 'blue',
		6 => 'indigo',
		7 => 'violet'
		);
}

//
// END Basic codes mod
//

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 