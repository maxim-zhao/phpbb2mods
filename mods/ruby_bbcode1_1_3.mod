##############################################################
## MOD Title: Ruby BB Code
## MOD Author: Quietust <quietust@ircN.org> (N/A) http://qmt.ath.cx/
## MOD Description: This MOD will allow you to insert ruby
##    annotation in your posts, most commonly used in Japanese
##    forums for entering furigana (pronunciation guides).
## MOD Version: 1.1.3
##
## Installation Level: Easy
## Installation Time: ~5 Minutes
## Files To Edit:
##      /includes/bbcode.php
##      /templates/subSilver/bbcode.tpl
##      /posting.php
##      /language/lang_english/lang_main.php
##      /templates/subSilver/posting_body.tpl
## Included Files: None
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
##
## Author Notes:
##
##      You MUST have Multiple BBCode MOD 1.4.0 installed for this to work.
##      Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##
## Usage:
##      [ruby=hightext]basetext[/ruby]
##
## Uses simple Ruby markup as per the W3C recommendation:
##      http://www.w3.org/TR/ruby/
## More information about Ruby annotation can be found at Wikipedia:
##      http://en.wikipedia.org/wiki/Ruby_character
##
## This syntax is not fully supported by all browsers.
## Opera and Firefox will display the hightext in parentheses
## to the right of the basetext at full size, rather than directly
## above it in small print.
##
##############################################################
## MOD History:
##
##    2005-08-04 - Version 1.1.3
##               - Updated to work with Multi BBcode 1.4.0
##
##    2004-09-09 - Version 1.1.2
##               - Really stupid typo fixed
##
##    2004-09-03 - Version 1.1.1
##               - Updated for phpBB 2.0.10
##               - Minor fixes
##
##    2004-08-15 - Version 1.1.0
##               - Total rewrite for bbcode mod compliance
##               - Added missing </ruby> tag
##
##    2004-07-02 - Version 1.0.0
##               - Initial version
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
# NOTE: If you can not find this, then you need to install Multiple BBCode MOD 1.4.0
#
$EMBB_widths = array(''

#
#-----[ IN-LINE FIND ]------------------------------------------
#
 array(''

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,'48'

#
#-----[ FIND ]---------------------------------
#
$EMBB_values = array(''

#
#-----[ IN-LINE FIND ]---------------------------------
#
 array(''

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,'Ruby'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);

#
#-----[ AFTER, ADD ]------------------------------------------
#
// RUBY-start
	$bbcode_tpl['ruby'] = str_replace('{RUBY}', '\\1', $bbcode_tpl['ruby']);
	$bbcode_tpl['ruby'] = str_replace('{BASE}', '\\2', $bbcode_tpl['ruby']);
// RUBY-end

#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
// RUBY-start
	// [ruby=hightext]basetext[/ruby] code..
	$patterns[] = "/\[ruby=(.*?):$uid\](.*?)\[\/ruby:$uid\]/si";
	$replacements[] = $bbcode_tpl['ruby'];
// RUBY-end

#
#-----[ FIND ]------------------------------------------
#
	// [img]image_url_here[/img] code..
	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

// RUBY-start
	// [ruby=hightext]basetext[/ruby] code..
	$text = preg_replace("#\[ruby=(.*?)\](.*?)\[/ruby\]#si", "[ruby=\\1:$uid]\\2[/ruby:$uid]", $text);
// RUBY-end

#
#-----[ OPEN ]------------------------------------------
#
# NOTE: This needs to be done for all templates!
#
templates/subSilver/bbcode.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</A><!-- END email -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- BEGIN ruby --><ruby><rb>{BASE}</rb><rp>(</rp><rt>{RUBY}</rt><rp>)</rp></ruby><!-- END ruby -->

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
# NOTE: the full line to look for is:
#$lang['bbcode_f_help'] = "Font size: [size=x-small]small text[/size]";
#
$lang['bbcode_f_help']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['bbcode_help']['ruby'] = 'Ruby text: [ruby=hightext]basetext[/ruby] (alt+%s)';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#
#-----[ FIND ]------------------------------------------
#
# NOTE: the actual line contains all the bbcode tags, but it begins with the below text
#
bbtags = new Array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,'[ruby=]','[/ruby]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM