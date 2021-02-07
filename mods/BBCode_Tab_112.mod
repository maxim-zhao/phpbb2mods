############################################################## 
## MOD Title: Tab BBCode
## MOD Author: Xore < mods@xore.ca > (Robert Hetzler) http://www.xore.ca
## MOD Description: [tab] BBCode for indenting/text formatting
## MOD Version: 1.1.2
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit: includes/bbcode.php
##                posting.php
##                templates/subSilver/bbcode.tpl
##                language/lang_english/lang_main.php
##                language/lang_english/lang_bbcode.php
##                templates/subSilver/posting_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: finally... able to indent!
############################################################## 
## MOD History:
## v1.1.2 Updated to meet Latest release of Multiple BBCode MOD
## v1.1.1 Usage of css preformatted inline blocks
## v1.0.0 First version release. no bugs, i hope :P
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
# IMPORTANT: you MUST first install the latest version of the Multi Quick BBCode Mod (1.2.1+).
# This can be found here: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
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
	// [tab] for inserting tabs.
	$text = str_replace("[tab:$uid]", $bbcode_tpl['tab'], $text);

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
	// [tab] for inserting tabs.
	$text = preg_replace("#\[tab\]#si", "[tab:$uid]", $text);

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
,'1'

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
,'Tab'

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
	'L_BBCODE_1_HELP' => $lang['bbcode_1_help'],

#
#-----[ OPEN ]---------------------------------
# Note: apply this to all languages, i am using english as an example
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
$lang['bbcode_1_help'] = "Tabbed text: [tab]some text (alt+1)";

# 
#-----[ OPEN ]---------------------------------
# Note: apply this to all languages, i am using english as an example
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

// Tab-start
$faq[] = array("What does the TAB BBCode do?", "This forum has the Tab BBCode MOD installed.  Using Tab will insert several spaces, for indentation purposes.  For example using:<ul><li>Wow! Look I'm <b>[tab]</b>all tabbed in!<br \><br \>will display as:<br \><br \>Wow! Look I'm &nbsp;&nbsp;&nbsp;&nbsp;all tabbed in!</li></ul>") ;
// Tab-end

# 
#-----[ OPEN ]------------------------------------------ 
# Note: apply this to all templates, i am using subSilver as an example
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

<!-- BEGIN tab --><pre style="display:inline;">    </pre><!-- END tab -->

# 
#-----[ OPEN ]------------------------------------------ 
# Note: apply this to all templates, i am using subSilver as an example
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
n1_help = "{L_BBCODE_1_HELP}";

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
,'[tab]','[tab]'

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
