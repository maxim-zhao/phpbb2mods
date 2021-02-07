##############################################################
## MOD Title:       Footnotes BBCode
## MOD Author:      KRiSPY < krispy03@gmail.com > (John Kristensen) http://cesspool.theintraweb.net/
## MOD Description: Enables users to easily insert footnotes with their posts using BBCode tags
## MOD Version:     1.0.2
##
## Installation Level:  (Easy)
## Installation Time:   15 Minutes
## Files To Edit:       4
##      includes/bbcode.php
##	language/lang_english/lang_main.php
##      templates/subSilver/bbcode.tpl
##      templates/subSilver/posting_body.tpl
##
## Included Files:      N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
##
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes:
##
## Compatibility: >= 2.0.15 (prior releases not tested)
##
## Installation Note:
##     This mod assumes that the Multiple BBCode MOD v1.4.0c is already installed on your forum
##
##
## Usage in post: 
##     some comment[footnote]footnote on comment[/footnote] about stuff[footnote]another footnote[/footnote]
##
## Result:
##     some comment1 about stuff2
##
##     _________
##     1 footnote on comment
##     2 another footnote
##
## (Note: the 1 & 2 will appear as superscipt - it is a bit hard to demonstrate in plain text)
##
##
##############################################################
## MOD History:
##
##   2005-05-03 - Version 1.0.0
##      - Inital version implemented on cesspool
##
##   2005-05-13 - Version 1.0.1
##      - Fixed bug not placing footnotes in quotes of people (ie. [quote="person"])
##
##   2005-10-23 - Version 1.0.2
##      - moved some footnote formatting from the code to the template
##      - adding compatibility with Multiple BBCode MOD 1.4.0c
##      - First public release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
# IMPORTANT: you MUST first have already installed the Multi BBCode MOD
#    available at http://www.phpbb.com/mods/
# 

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php

#
#-----[ FIND ]------------------------------------------
#
	$EMBB_widths = array(''

#
#-----[ IN-LINE FIND ]------------------------------------------
#
array(''

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
# 
, '60'

#
#-----[ FIND ]------------------------------------------
#
	$EMBB_values = array(''

#
#-----[ IN-LINE FIND ]------------------------------------------
#
array(''

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
# 
, 'Footnote'

#
#-----[ FIND ]------------------------------------------
#
	$text = str_replace("[quote:$uid]", $bbcode_tpl['quote_open'], $text);
	$text = str_replace("[/quote:$uid]", $bbcode_tpl['quote_close'], $text);

#
#-----[ REPLACE WITH ]------------------------------------------
#
	$text = bbencode_second_pass_quote($text, $uid, $bbcode_tpl);

#
#-----[ FIND ]------------------------------------------
#
	// [size] and [/size] for setting text size
	$text = preg_replace("#\[size=([1-2]?[0-9])\](.*?)\[/size\]#si", "[size=\\1:$uid]\\2[/size:$uid]", $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	// [footnote] and [/footnote] for hiding spoiler text
	$text = preg_replace("#\[footnote\](.*?)\[/footnote\]#si", "[footnote:$uid]\\1[/footnote:$uid]", $text);

#
#-----[ FIND ]------------------------------------------
#
} // bbencode_second_pass_code()

#
#-----[ AFTER, ADD ]------------------------------------------
#

/**
 * Does second-pass bbencoding of the [quote] tags. This includes
 * seperating out any [footnote] tags there may be in any pair of 
 * [quote] tags.
 */
function bbencode_second_pass_quote($text, $uid, $bbcode_tpl)
{
	// determine if any quotes are in the text a make nda recursive call on it if there is
	preg_match("#\[quote:$uid(=\".*\")?\](.*?)\[/quote:$uid\]#si", substr($text, 1), $match);

	if( $match[0] )
	{
		$start_pos = strpos($text, $match[0], 1);
		$text = substr($text, 0, $start_pos) . bbencode_second_pass_quote(substr($text, $start_pos), $uid, $bbcode_tpl);
	}
	
	$end_text = "";
	$end_pos = strpos($text, "[/quote:$uid]");
	
	
	// select just the quote itself and strip the closing quote tag (if there is a quote in the text)
	if( $end_pos )
	{
		$end_text = substr($text, ($end_pos + strlen("[/quote:$uid]")));
		$text = substr($text, 0, ($end_pos + strlen("[/quote:$uid]")));
		
		$text = str_replace("[/quote:$uid]", "", $text);

	}

	// [footnote] and [/footnote] for hiding spoiler text
	preg_match_all("#\[footnote:$uid\](.*?)\[/footnote:$uid\]#si", $text, $footnotes, PREG_PATTERN_ORDER);
	
	if(count($footnotes[1]) != 0)
	{
		$count = 1;
		$text .= $bbcode_tpl['footnote_open'];
	
		foreach($footnotes[1] as $key => $note)
		{
			$text = str_replace($footnotes[0][$key], $bbcode_tpl['super_open'].$count.$bbcode_tpl['super_close'], $text);
			$text .= "<br />".$bbcode_tpl['super_open'].$count.$bbcode_tpl['super_close']." ".$note;
			$count++;
		}

		$text .= $bbcode_tpl['footnote_close'];
	}

	// add the closing quote tag again (if this was a quote)
	if( $end_pos )
	{
		$text .= $bbcode_tpl['quote_close'];
	}
	
	// substiture the opening quote tag with the correct template code
	$text = str_replace("[quote:$uid]", $bbcode_tpl['quote_open'], $text);
	$text = preg_replace("/\[quote:$uid=\"(.*?)\"\]/si", $bbcode_tpl['quote_username_open'], $text);

	// place the quote back into the main text
	$text .= $end_text;

	return $text;
}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['bbcode_help']['footnote'] = 'Footnote text: [footnote]this is the footnote text[/footnote] (alt+%s)';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl

#
#-----[ FIND ]------------------------------------------
#
<span class="postbody"><!-- END code_close -->

#
#-----[ AFTER, ADD ]------------------------------------------
#

<!-- BEGIN super_open --><span style="vertical-align: super; font-size:  smaller;"><!-- END super_open -->
<!-- BEGIN super_close --></span><!-- END super_close -->

<!-- BEGIN footnote_open --><br /><br />_____<span style="font-size: 85%;"><!-- END sub_open -->
<!-- BEGIN footnote_close --></span><!-- END sub_close -->

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]'

#
#-----[ IN-LINE FIND ]------------------------------------------
#
'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
# 
,'[footnote]','[/footnote]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 