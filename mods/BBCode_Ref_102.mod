############################################################## 
## MOD Title: Reference BBCode
## MOD Author: Xore < xore@azuriah.com > ( Xore ) http://forums.azuriah.com
## MOD Description: [ref] BBCode for reference tools
## MOD Version: 1.0.2
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
## Author Notes: dictionary, thesaurus, and translator
##               many thanks to wGEric and LifeIsPain who gave me the idea with google bbcode
##               and how to get around some coding roadblocks.
############################################################## 
## MOD History:
## v1.0.2 Fixed some missing changes of aforementioned hotkey
## v1.0.1 Change of hotkey
## v1.0.0 First version release. no bugs, i hope :P
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
# IMPORTANT: you MUST first install the latest version of the Multi Quick BBCode Mod (1.2.1+).
#
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

	$bbcode_tpl['ref_dict'] = '\'' . $bbcode_tpl['ref_dict'] . '\'';
	$bbcode_tpl['ref_dict'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['ref_dict']);
	$bbcode_tpl['ref_dict'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['ref_dict']);

	$bbcode_tpl['ref_thes'] = '\'' . $bbcode_tpl['ref_thes'] . '\'';
	$bbcode_tpl['ref_thes'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['ref_thes']);
	$bbcode_tpl['ref_thes'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['ref_thes']);

	$bbcode_tpl['ref_trans'] = '\'' . $bbcode_tpl['ref_trans'] . '\'';
	$bbcode_tpl['ref_trans'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['ref_trans']);
	$bbcode_tpl['ref_trans'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['ref_trans']);

#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// [ref=dictionary]string for dictionary[/ref] code..
	$patterns[] = "#\[ref=dictionary\](.*?)\[/ref\]#ise";
	$replacements[] = $bbcode_tpl['ref_dict'];
	// [ref=dict]string for dictionary[/ref] code..
	$patterns[] = "#\[ref=dict\](.*?)\[/ref\]#ise";
	$replacements[] = $bbcode_tpl['ref_dict'];

	// [ref=thesaurus]string for thesaurus[/ref] code..
	$patterns[] = "#\[ref=thesaurus\](.*?)\[/ref\]#ise";
	$replacements[] = $bbcode_tpl['ref_thes'];
	// [ref=thes]string for thesaurus[/ref] code..
	$patterns[] = "#\[ref=thes\](.*?)\[/ref\]#ise";
	$replacements[] = $bbcode_tpl['ref_thes'];

	// [ref=translate]string for translation[/ref] code..
	$patterns[] = "#\[ref=translator\](.*?)\[/ref\]#ise";
	$replacements[] = $bbcode_tpl['ref_trans'];
	// [ref=trans]string for translation[/ref] code..
	$patterns[] = "#\[ref=trans\](.*?)\[/ref\]#ise";
	$replacements[] = $bbcode_tpl['ref_trans'];

#
#-----[ OPEN ]---------------------------------
# 
posting.php

# 
#-----[ FIND ]---------------------------------
#
$EMBB_keys = array(''

# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_keys = array(''


# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'5'

# 
#-----[ FIND ]---------------------------------
#
$EMBB_widths = array(''

# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_widths = array(''

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'40'

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
,'Ref'

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
	'L_BBCODE_5_HELP' => $lang['bbcode_5_help'],

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
$lang['bbcode_5_help'] = "Reference text: [ref=?]some text[/ref] (? is dict, thes, or trans) (alt+5)";

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

// Ref-start
$faq[] = array("What does the REF BBCode do?", "This forum has the Ref BBCode MOD installed.  Using Ref allows you to link to dictionary, thesaurus, or translator. For example using:<ul><li><b>[ref=dictionary]</b>hi<b>[/ref]</b>, <b>[ref=thesaurus]</b>hi<b>[/ref]</b> or <b>[ref=translator]</b>hi<b>[/ref]</b><br \><br \>will display as:<a href=\"http://dictionary.reference.com/search?q=hi\" target=\"_blank\">hi</a>, <a href=\"http://thesaurus.reference.com/search?q=hi\" target=\"_blank\">hi</a> or <a href=\"http://babelfish.altavista.com/babelfish/tr?urltext=hi\" target=\"_blank\">hi</a> (you can use dict, thes, and trans as shortcuts)<br \><br \></li></ul>") ;
// Ref-end

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

<!-- BEGIN ref_dict --><a href="http://dictionary.reference.com/search?q={QUERY}" target="_blank">{STRING}</a><!-- END ref_dict -->
<!-- BEGIN ref_thes --><a href="http://thesaurus.reference.com/search?q={QUERY}" target="_blank">{STRING}</a><!-- END ref_thes -->
<!-- BEGIN ref_trans --><a href="http://babelfish.altavista.com/babelfish/tr?urltext={QUERY}" target="_blank">{STRING}</a><!-- END ref_trans -->

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
n5_help = "{L_BBCODE_5_HELP}";

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
,'[ref]','[/ref]'

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
