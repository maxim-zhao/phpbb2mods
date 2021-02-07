##############################################################
## MOD Title: Blink BBCode
## MOD Author: *=Matt=* < matt.gru@gmail.com > (Matt Lien) http://www.glitchplay.com/
## MOD Description: Makes the text blink.
## MOD Version: 1.0.0
##
## Installation Level: (Easy) 
## Installation Time: 5 - 10 Minutes 
## Files To Edit: includes/bbcode.php
##                language/lang_english/lang_main.php
##                templates/subSilver/bbcode.tpl
##                templates/subSilver/posting_body.tpl
##
## Included Files: N/A
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##  Makes the text blink. What else can I say.
##
##############################################################
## MOD History:
## 
## 2006-06-11 - Version 1.0.0
##  - First Stable release.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#-----[ OPEN ]---------------------------------
#
includes/bbcode.php

#
#-----[ FIND ]---------------------------------
#
$EMBB_widths = array(''

#
#-----[ IN-LINE FIND ]---------------------------------
#
 array(''

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'50'

#
#-----[ FIND ]---------------------------------
#
$EMBB_values = array(''

#
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_values = array(''

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'Blink'

#
#-----[ FIND ]------------------------------------------
#
	// [b] and [/b] for bolding text.
	$text = str_replace("[b:$uid]", $bbcode_tpl['b_open'], $text);
	$text = str_replace("[/b:$uid]", $bbcode_tpl['b_close'], $text);
#
#-----[ AFTER, ADD ]-------------------------------
#

	// [blink] and [/blink] for blinking text. 
	$text = str_replace("[blink:$uid]", $bbcode_tpl['blink_open'], $text);
	$text = str_replace("[/blink:$uid]", $bbcode_tpl['blink_close'], $text);
# 
#-----[ FIND ]------------------------------------------ 
# 
	// [b] and [/b] for bolding text.
	$text = preg_replace("#\[b\](.*?)\[/b\]#si", "[b:$uid]\\1[/b:$uid]", $text);
#
#-----[ AFTER, ADD ]----------------------------
#

	// [blink] and [/blink] for blinking text.
	$text = preg_replace("#\[blink\](.*?)\[/blink\]#si", "[blink:$uid]\\1[/blink:$uid]", $text);
#
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------
#
# NOTE: the full line to look for is:
#$lang['bbcode_f_help'] = "Font size: [size=x-small]small text[/size]";
#
$lang['bbcode_f_help'] =

#
#-----[ AFTER, ADD ]---------------------------------
#

$lang['bbcode_help']['blink'] = 'Blink: [Blink]Text[/blink] (alt+%s)';
#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/bbcode.tpl
    
#
#-----[ FIND ]------------------------------------------ 
#
<!-- BEGIN b_open --><span style="font-weight: bold"><!-- END b_open -->
<!-- BEGIN b_close --></span><!-- END b_close -->
#
#-----[ AFTER, ADD ]------------------------------------------ 
#

<!-- BEGIN blink_open --><blink><!-- END blink_open -->
<!-- BEGIN blink_close --></blink><!-- END blink_close -->
#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]---------------------------------
#
# NOTE: the actual line to find is MUCH longer, containing all the bbcode tags
#
bbtags = new Array(

#
#-----[ IN-LINE FIND ]---------------------------------
#
'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'[blink]','[/blink]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM