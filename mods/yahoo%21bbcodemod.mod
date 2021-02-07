##############################################################
## MOD Title: Yahoo Search BBCode 
## MOD Author: GoOfyGaRber < milo@goofygarber.net > (Milo) http://www.goofygarber.net
## MOD Description: Adds a new bbcode.  Allows you put make strings in your post
## 	   	    be searched for in Yahoo!. ([yahoo]string to search for[/yahoo])
## MOD Version: 1.0.1
## 
## Installation Level: (Easy) 
## Installation Time: 10 Minutes
## Files To Edit: -posting.php
##              -includes/bbcode.php,
##              -langugage/lang_english/lang_main.php,
##              -templates/subSilver/bbcode.tpl,
##              -templates/subSilver/posting_body.tpl
## Included Files: n/a
## Generator: MOD Studio.net [Beta 3c 1.2.1306.29431]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
## 		  You must have Multiple BBCode MOD installed for this to work.
##      Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705
## 
##      example:
## 		  [yahoo]string to search for[/yahoo]
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
posting.php

#
#-----[ FIND ]------------------------------------------
#
$EMBB_keys = array(''

#
#-----[ IN-LINE FIND ]------------------------------------------
#
 array(''

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,'alt+7'

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
,'55'

#
#-----[ FIND ]------------------------------------------
#
$EMBB_values = array(''

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$EMBB_values = array(''

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,'Yahoo'

#
#-----[ FIND ]------------------------------------------
#
# NOTE: the full line to look for is:
#	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
#
	'L_BBCODE_F_HELP' =>

#
#-----[ AFTER, ADD ]------------------------------------------
#

	'L_BBCODE_D_HELP' => $lang['bbcode_d_help'],
#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

  $bbcode_tpl['yahoo'] = '\'' . $bbcode_tpl['yahoo'] . '\'';
  $bbcode_tpl['yahoo'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['yahoo']);
  $bbcode_tpl['yahoo'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['yahoo']);
#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// [yahoo]string for search[/yahoo] code..
	$patterns[] = "#\[yahoo\](.*?)\[/yahoo\]#ise";
	$replacements[] = $bbcode_tpl['yahoo'];
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
$lang['bbcode_f_help'] =

#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['bbcode_d_help'] = "Yahoo: [yahoo]String to search for[/yahoo] (alt+d)";

#
#-----[ OPEN  ]------------------------------------------
#
templates/subSilver/bbcode.tpl
    
#
#-----[ FIND  ]------------------------------------------
#
<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</A><!-- END email -->
#
#-----[ AFTER, ADD  ]------------------------------------------
#

<!-- BEGIN yahoo --><a href="http://search.yahoo.com/search?p={QUERY}" target="_blank">{STRING}</a><!-- END yahoo -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
# NOTE: the full line to look for is:
#f_help = "{L_BBCODE_F_HELP}";
#
f_help =

#
#-----[ AFTER, ADD ]------------------------------------------
#
d_help = "{L_BBCODE_D_HELP}";

#
#-----[ FIND ]------------------------------------------
#
# NOTE: the actual line to find is MUCH longer, containing all the bbcode tags
#
bbtags = new Array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,'[yahoo]','[/yahoo]'

#
#-----[ SAVE/CLOSE ALL FILES  ]------------------------------------------
#
# EoM

