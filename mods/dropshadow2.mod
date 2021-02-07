################################################################# 
## MOD Title: Dropshadow effect BBcode Mod
## MOD Author: omega13a < omega13a@sonicunited.com > (Brandon Amaro) http://www.sonicunited.com
## MOD Description: adds a dropshadow bbcode tags to your forum.
## MOD Version: 1.0.1
## 
## Installation Level: easy
## Installation Time: 1 minute
## Files To Edit: templates/subSilver/bbcode.tpl
##                includes/bbcode.php
## Included Files: n/a
## Generator: Mod Maker.net [alpha 1.0.957.14686]
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
#################################################################
##
## Author Notes: Please note that only the following syntax works
##               [dropshadow=color]text[/dropshadow]
##               Also please note these tags use IE specific CSS
##
## You MUST first have already installed the Multi Quick BBCode MOD
##
#################################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
#################################################################

#
# IMPORTANT: you MUST first have already installed the Multi Quick BBCode MOD
#


# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 


# 
#-----[ FIND ]------------------------------------------ 
# 
#  NOTE: the complete line to find is: 
#$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']); 
# 
$bbcode_tpl['email'] 


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	// dropshadow bbcode mod by omega13a
	$bbcode_tpl['dropshadow_open'] = str_replace('{SHADOWCOLOR}', '\\1', $bbcode_tpl['dropshadow_open']);

# 
#-----[ FIND ]------------------------------------------ 
# 
#  NOTE: the complete line to find is: 
#str_replace("[/i:$uid]", $bbcode_tpl['i_close'], $text)
# 
str_replace("[/i:$uid]"


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	// dropshadow bbcode mod by omega13a 
	$text = preg_replace("/\[dropshadow=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['dropshadow_open'], $text);
	$text = str_replace("[/dropshadow:$uid]", $bbcode_tpl['dropshadow_close'], $text);
# 
#-----[ FIND ]------------------------------------------ 
# 
#  NOTE: the complete line to find is: 
#preg_replace("#\[i\](.*?)\[/i\]#si", "[i:$uid]\\1[/i:$uid]", $text)
# 
preg_replace("#\[i\](.*?)\[/i\]#si"


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	// dropshadow bbcode mod by omega13a
	$text = preg_replace("#\[dropshadow=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/dropshadow\]#si", "[dropshadow=\\1:$uid]\\2[/dropshadow:$uid]", $text);

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
,'8'


# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
$EMBB_widths = array('' 


# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'85'


# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
$EMBB_values = array('' 


# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'Dropshadow'


# 
#-----[ FIND ]--------------------------------- 
# 
# NOTE: the full line to look for is: 
#   'L_BBCODE_F_HELP' => $lang['bbcode_f_help'], 
# 
   'L_BBCODE_F_HELP' => 


# 
#-----[ AFTER, ADD ]-------------------------------- 
# 

   'L_BBCODE_8_HELP' => $lang['bbcode_8_help'], 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/bbcode.tpl 


# 
#-----[ FIND ]------------------------------------------ 
# 
#  NOTE: the complete line to find is: 
#<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</A><!-- END email --> 
# 
<!-- END email --> 


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<!-- BEGIN dropshadow_open --><span style="filter: dropshadow(color={SHADOWCOLOR}); height:20"><!-- END dropshadow_open -->
<!-- BEGIN dropshadow_close --></span><!-- END dropshadow_close -->

# 
#-----[ OPEN ]--------------------------------- 
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
#-----[ AFTER, ADD ]--------------------------------- 
# 

n8_help = "{L_BBCODE_8_HELP}"; 

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
,'[dropshadow=]','[/dropshadow]' 


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

$lang['bbcode_8_help'] = "Dropshadow: [dropshadow=color]text[/dropshadow] (alt+8)"; 

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

// dropshadow-start
$faq[] = array("What does the Dropshadow BBCode do?", "This forum has the dropshadow BBCode MOD installed.  Using dropshadow allows you to make text have a shadow effect. For example using:<ul><li>Look! I've <b>[dropshadow=orange]</b>got a shadow!<b>[/dropshadow]</b>,<br \><br \>will display as: Look! I've <span style='filter: dropshadow(color=orange); height:20;'>got a shadow!</span><br \><br \></li></ul>") ;
// dropshadow-end


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM