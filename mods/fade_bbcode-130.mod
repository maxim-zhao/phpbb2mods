################################################################# 
## MOD Title: Fade BBCode 
## MOD Author: Brewjah < blackhash@rogers.com > (N/A) http://forums.gotdns.com 
## MOD Author, Secondary: Nuttzy99 < pktoolkit@blizzhackers.com > (N/A) http://www.blizzhackers.com
## MOD Author, Secondary: wGEric < eric@best-dev.com > (Eric Faerber) http://mods.best-dev.com
## MOD Description:  This takes the text between the tags and makes it
##    fade away! Starts off normal then as the line continues until
##    it just disappears.
## MOD Version: 1.3.0
##
## Installation Level:  (easy) 
## Installation Time:  5-10 Minutes 
## Files To Edit:         6
##                   - includes/bbcode.php
##                   - posting.php
##                   - templates/subSilver/bbcode.tpl
##                   - language/lang_english/lang_main.php
##                   - language/lang_english/lang_bbcode.php
##                   - templates/suBsilver/posting_body.tpl
## Included Files:      None 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
######################################################## 
## Author Notes:
##	Requires Multiple BBCode MOD (http://www.phpbb.com/phpBB/viewtopic.php?t=145513)
##
##	Only works in Internet Explorer
##
######################################################## 
## MOD History:
##
##   2004-07-13 - Version 1.3.0
##	- Updated for phpBB 2.0.9 by wGEric	
##
##   2003-02-05 - Version 1.2.0
##	- updated for 2.0.4 by Nuttzy
##	- added BBCode FAQ entry by Nuttzy
##
##   2002-00-06 Version 1.1.0
##	-update and made EasyMod Compliant by Nuttzy ( pktoolkit@blizzhackers.com )
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 

# 
#-----[ FIND ]--------------------------------- 
#
#   NOTE: the full line to look for is:
#	$text = str_replace("[/b:$uid]", $bbcode_tpl['b_close'], $text); 
#
	$text = str_replace("[/b:$uid]


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	// [fade] and [/fade] for faded text.
	$text = str_replace("[fade:$uid]", $bbcode_tpl['fade_open'], $text);
	$text = str_replace("[/fade:$uid]", $bbcode_tpl['fade_close'], $text);

# 
#-----[ FIND ]--------------------------------- 
# 
#   NOTE: the full line to look for is:
#	$text = preg_replace("#\[b\](.*?)\[/b\]#si", "[b:$uid]\\1[/b:$uid]", $text);
#
	$text = preg_replace("#\[b\]


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	// [fade] and [/fade] for faded text.
	$text = preg_replace("#\[fade\](.*?)\[/fade\]#si", "[fade:$uid]\\1[/fade:$uid]", $text);

#
#-----[ OPEN ]---------------------------------
# 
posting.php


# 
#-----[ FIND ]---------------------------------
#
$EMBB_keys = array(''
$EMBB_widths = array(''
$EMBB_values = array(''


# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_keys = array(''


# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'e'


# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_widths = array(''


# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'40'


# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_values = array(''


# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'Fade'


# 
#-----[ FIND ]---------------------------------
# 
#  NOTE: the full line to look for is:
#	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
#
	'L_BBCODE_F_HELP' =>


# 
#-----[ AFTER, ADD ]--------------------------------
# 

	'L_BBCODE_E_HELP' => $lang['bbcode_e_help'],

##
##
## --- NOTE: You will have to make this change to ALL languages that you     ---
## ---       plan to support on your board.  I use "English" as an example   ---
##
##

#
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php


# 
#-----[ FIND ]---------------------------------
# 
#  NOTE: the full line to look for is:
#$lang['bbcode_f_help'] = "Font size: [size=x-small]small text[/size]";
#
$lang['bbcode_f_help']


# 
#-----[ AFTER, ADD ]---------------------------------
# 

$lang['bbcode_e_help'] = "Fade text: [fade]some text[/fade] (alt+e)";

# 
#-----[ OPEN ]---------------------------------
# 
language/lang_english/lang_bbcode.php


#
#-----[ FIND ]---------------------------------
# 
# NOTE: the full line to look for is:
# $faq[] = array("How to change the text colour or size", [..SNIP..]  </ul>");
#
array("How to change the text colour or size"


# 
#-----[ AFTER, ADD ]---------------------------------
# 

// FADE-start
$faq[] = array("What does the FADE BBCode do?", "This forum has the Fade BBCode MOD installed.  Using fade on selected text will display the begining of the string as normal text and then continue lightening the text from left to right until the text just fades away.  For example using:<ul><li>Wow! Look I'm <b>[fade]</b>fading away<b>[/fade]</b>!<br \><br \>will display as:<br \><br \>Wow! Look I'm <span style=\"height: 1; Filter: Alpha(Opacity=100, FinishOpacity=0, Style=1, StartX=0, FinishX=100%)\">fading away</span>!</li></ul>") ;
// FADE-end


##
##
## --- NOTE: You will have to make this change to ALL themes you have       ---
## ---       installed.  I use "subSilver" as an example.                   ---
##
##

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/bbcode.tpl


# 
#-----[ FIND ]--------------------------------- 
# 
#  NOTE: the full line to look for is:
#<!-- BEGIN b_close --></span><!-- END b_close --> 
<!-- END b_close --> 


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<!-- BEGIN fade_open --><span style="height: 1; Filter: Alpha(Opacity=100, FinishOpacity=0, Style=1, StartX=0, FinishX=100%)"><!-- END fade_open -->
<!-- BEGIN fade_close --></span><!-- END fade_close -->


# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/posting_body.tpl


#
#-----[ FIND ]---------------------------------
# 
# NOTE: the full line to look for is:
#f_help = "{L_BBCODE_F_HELP}";
#
f_help =


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

e_help = "{L_BBCODE_E_HELP}";

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
,'[fade]','[/fade]'


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM