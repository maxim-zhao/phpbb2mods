################################################################ 
## MOD Title:           L-C-R IMG And Text Alignment BBcode
## MOD Author:          Templater < N/A > (N/A) N/A
##
## MOD Description:     Allows you to align either, Left, Center or Right, both, images 
##                      and text! ;)
##
## MOD Version:         1.0.1
## 
## Installation Level:  EASY
## Installation Time:   ~3 minutes
## Files To Edit: includes/bbcode.php, 
##      language/lang_english/lang_main.php, 
##      templates/subSilver/bbcode.tpl, 
##      templates/subSilver/posting_bbcode.tpl 
## Included Files: (N/A, or list of included files) 
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
##     
##                - Works with phpBB 2.0.19 
##                - Compatible with Categories Hierarchy Mod 2.14
##                - Multi-BBcode And Bcode Buttons Organizer Compliant. 
##                - In This release L-C-R IMG & Text Alignment it is not EasyMod 
##                  compliant but it is contemplated it be in the next release tho. 
##                - The Mod can align to the Center, Left or Right both Images and Tex.
##                - IMPORTANT: You must previously install the Multi BBCode Mod V.1.4.0c
##                  available at: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##
################################################################ 
## MOD History:
## 
##               Feb-27-2006 
##               + Version 1.0.0 - Creation of Mod
##               March-16-2006 
##               + Version 1.0.1 - Template's Mod actualized for approval. O.O  
##               March-17-2006
##               + Version 1.0.3 - A minor code error fixed    
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD. 
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 
# 
#-----[ FIND ]------------------------------------------
#
<?php
# 
#-----[ AFTER, ADD ]------------------------------------
#
//-- mod : L-C-R IMG & Text Alignment ------------------------------------------ 
# 
#-----[ FIND ]------------------------------------------
#  
    $EMBB_widths = array('') ; 
# 
#-----[ IN-LINE FIND ]----------------------------------- 
#                                                         
    $EMBB_widths = array(''                                              
#                                                           
#-----[ IN-LINE AFTER, ADD ]----------------------------
# 
, '55', '55', '55'
# 
#-----[ FIND ]------------------------------------------- 
#
    $EMBB_values = array('') ; 
# 
#-----[ IN-LINE FIND ]-----------------------------------
# 
	$EMBB_values = array(''
# 
#-----[ IN-LINE AFTER, ADD ]----------------------------
# 
, 'Left', 'Center', 'Right' 
# 
#-----[ FIND ]------------------------------------------- 
# 
   // [i] and [/i] for italicizing text. 
   $text = str_replace("[i:$uid]", $bbcode_tpl['i_open'], $text); 
   $text = str_replace("[/i:$uid]", $bbcode_tpl['i_close'], $text); 
# 
#-----[ AFTER, ADD ]-------------------------------------
# 
//-- mod : L-C-R IMG & Text Alignment ------------------------------------------ 
//-- add 
   // [left] and [/left] for left aligned text. 
   $text = str_replace("[left:$uid]", $bbcode_tpl['left_open'], $text); 
   $text = str_replace("[/left:$uid]", $bbcode_tpl['left_close'], $text);
   // [center] and [/center] for center aligned text. 
   $text = str_replace("[center:$uid]", $bbcode_tpl['center_open'], $text); 
   $text = str_replace("[/center:$uid]", $bbcode_tpl['center_close'], $text); 
   // [right] and [/right] for right aligned text. 
   $text = str_replace("[right:$uid]", $bbcode_tpl['right_open'], $text); 
   $text = str_replace("[/right:$uid]", $bbcode_tpl['right_close'], $text); 
//-- fin mod : L-C-R IMG & Text Alignment -------------------------------------- 
# 
#-----[ FIND ]-------------------------------------------
# 
   // [i] and [/i] for italicizing text. 
   $text = preg_replace("#\[i\](.*?)\[/i\]#si", "[i:$uid]\\1[/i:$uid]", $text); 
# 
#-----[ AFTER, ADD ]-------------------------------------
# 
//-- mod : L-C-R IMG & Text Alignment ------------------------------------------ 
//-- add 
   // [left] and [/left] for left aligned text. 
   $text = preg_replace("#\[left\](.*?)\[/left\]#si", "[left:$uid]\\1[/left:$uid]", $text);
   // [center] and [/center] for centered text. 
   $text = preg_replace("#\[center\](.*?)\[/center\]#si", "[center:$uid]\\1[/center:$uid]", $text); 
   // [right] and [/right] for right aligned text. 
   $text = preg_replace("#\[right\](.*?)\[/right\]#si", "[right:$uid]\\1[/right:$uid]", $text);
//-- mod : L-C-R IMG & Text Alignment ------------------------------------------
# 
#-----[ OPEN ]------------------------------------------- 
# 
language/lang_english/lang_main.php 
# 
#-----[ FIND ]---------------------------------
#
<?php
# 
#-----[ AFTER, ADD ]---------------------------------
#
//-- mod : L-C-R IMG & Text Alignment ------------------------------------------ 
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]'; 
# 
#-----[ AFTER, ADD ]------------------------------------
# 
//-- mod : L-C-R IMG & Text Alignment ------------------------------------------
//-- add 
$lang['bbcode_help']['Left'] = 'Left text: [left]text to be left aligned[/left] (alt+%s)'; 
$lang['bbcode_help']['Center'] = 'Center text: [center]text to be centered[/center] (alt+%s)'; 
$lang['bbcode_help']['Right'] = 'Right text: [right]text to be right aligned[/right] (alt+%s)';
//-- fin mod : L-C-R IMG & Text Alignment --------------------------------------
# 
#-----[ OPEN ]-----------------------------------------
# 
templates/subSilver/bbcode.tpl 
# 
#-----[ FIND ]----------------------------------------- 
# 
<!-- BEGIN i_open --><span style="font-style: italic"><!-- END i_open --> 
<!-- BEGIN i_close --></span><!-- END i_close --> 
# 
#-----[ AFTER, ADD ]------------------------------------
# 
<!-- BEGIN left_open --><div align="left"><!-- END left_open --> 
<!-- BEGIN left_close --></div><!-- END left_close -->

<!-- BEGIN center_open --><div align="center"><!-- END center_open --> 
<!-- BEGIN center_close --></div><!-- END center_close -->

<!-- BEGIN right_open --><div align="right"><!-- END right_open --> 
<!-- BEGIN right_close --></div><!-- END right_close --> 
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/posting_body.tpl 
# 
#-----[ FIND ]------------------------------------------ 
#  
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]'); 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
'[/url]' 
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
,'[left]','[/left]','[center]','[/center]','[right]','[/right]'
# 
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------- 
# 
# EoM 