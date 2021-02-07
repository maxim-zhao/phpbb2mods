## EasyMOD compliant
############################################################## 
## MOD Title:   Left and Right IMG tags
## MOD Author:  Nuttzy < pktoolkit@blizzhackers.com > (n/a) http://www.blizzhackers.com
## MOD Author, Secondary:  Xore < mods@xore.ca > (Robert Hetzler) http://www.xore.ca
##
## MOD Description:  This MOD will allow you to better format
##    you posts by aligning images left and right instead of 
##    just in-line as with the standard [img][/img] tag. Text
##    will also neatly wrap around the images.
## MOD Version: 1.6.0
## 
## Installation Level:  EASY
## Installation Time:   4-5 Minutes
## Files To Edit:       6
##                   - includes/bbcode.php
##                   - templates/subSilver/bbcode.tpl
##                   - language/lang_english/lang_main.php
##                   - language/lang_english/lang_bbcode.php
## Included Files:     n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## 
## Author Notes:
##
##     Works with phpBB 2.0.4 thru 2.0.6
##     IMPORTANT: you MUST first have already installed the Multi Quick BBCode MOD
##
## Usage:
##     [img=left]url of image[/img] to left justify image
##     [img=right]url of image[/img] to right justify image
## (used to be [left][/left] and [right][/right] -- this frees up more hotkeys)
##
##
############################################################## 
##
## MOD History:
##    2003-11-02 - Version 1.6.0
##         + Changed to img=left and img=right
##    
##    2003-09-25 - Version 1.5.2
##         + improved MOD Template compliance
##    
##    02/05/03 - bug fix: changed instance in bbcode.tpl where 
##                 left should have been right - DanielT
##
##    02/04/03 - updated for 2.0.4
##             - added BBCode FAQ entry
##
##    08/31/02 - fixed interference with font color/size problem
##             - made compliant with EasyMod alpha 2
##
##    06/28/02 - fixed a bbcode problem - thanks to
##               desean84 for discovering the problem!
##
##    04/21/02 - updated for phpBB 2.0.0 final
##             - quick BBcode added by Christi
##             - made EasyMod compliant
##
##    03/18/02 - initial releae for phpBB 2.0 RC3
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


#
# IMPORTANT: you MUST first have already installed the Multi Quick BBCode MOD
#


#
#-----[ OPEN ]------------------------------------------ 
#
includes/bbcode.php


#
#
# NOTE: the full line to look for is:
#	$bbcode_tpl['img'] = str_replace('{URL}', '\\1', $bbcode_tpl['img']);
#
#-----[ FIND ]------------------------------------------ 
#
	$bbcode_tpl['img'] =

#
#-----[ AFTER, ADD ]------------------------------------------ 
#

// LEFT-RIGHT-start
	$bbcode_tpl['left'] = str_replace('{URL}', '\\1', $bbcode_tpl['left']);
	$bbcode_tpl['right'] = str_replace('{URL}', '\\1', $bbcode_tpl['right']);
// LEFT-RIGHT-end

#
#-----[ FIND ]------------------------------------------ 
#
	$patterns[] = "#\[img:$uid\](.*?)\[/img:$uid\]#si";
	$replacements[] = $bbcode_tpl['img'];

#
#-----[ AFTER, ADD ]------------------------------------------ 
#

// LEFT-RIGHT-start
	// [img=left]image_url_here[/img] code..
	$patterns[] = "#\[img=left:$uid\](.*?)\[/img:$uid\]#si";
	$replacements[] = $bbcode_tpl['left'];

	// [img=right]image_url_here[/img] code..
	$patterns[] = "#\[img=right:$uid\](.*?)\[/img:$uid\]#si";
	$replacements[] = $bbcode_tpl['right'];
// LEFT-RIGHT-end

#
#-----[ FIND ]------------------------------------------ 
#

$text = preg_replace("#\[img\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);

#
#-----[ AFTER, ADD ]------------------------------------------ 
#

// LEFT-RIGHT-start
$text = preg_replace("#\[img=left\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie", "'[img=left:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
$text = preg_replace("#\[img=right\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie", "'[img=right:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
// LEFT-RIGHT-end

# 
#-----[ OPEN ]---------------------------------
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]---------------------------------
# full line, in english, is:
#	$lang['bbcode_p_help'] = 'Insert image: [img]http://image_url[/img]  (alt+p)';
#
$lang['bbcode_p_help']

# 
#-----[ IN-LINE FIND ]---------------------------------
#
[img

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
( | =left | =right )

# 
#-----[ OPEN ]---------------------------------
# 
language/lang_english/lang_bbcode.php


#
#-----[ FIND ]---------------------------------
# 
# NOTE: the full line to look for is:
# $faq[] = array("Adding an image to a post", "phpBB BBCode [..SNIP..] <br />");
#
array("Adding an image to a post"


# 
#-----[ AFTER, ADD ]---------------------------------
# 

// LEFT-RIGHT-start
$faq[] = array("Aligning images and wrapping text", "This forum has the Left-Right IMG tag MOD installed.  Through the use of these tags, you can better format your posts by aligning text to the left or right side of the post body.  Additionally, through the use of these tags, text will now neatly wrap around the images as opposed to being in-line as with a normal [img] tag.  For example:<br /><br /><b>With img tags:</b><br />A really really <b>[img]</b>phplogo.gif<b>[/img]</b> <b>[img]</b>phplogo.gif<b>[/img]</b> really really really really really really long sentence. <table width=\"420\" cellpadding=\"5\"><tr><td class=\"quote\"><br />A really really <img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /> <img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /> really really really really really really long sentence.<br /><br /></td></tr></table><br /> <b>With left and right tags:</b><br />A really really <b>[img=left]</b>phplogo.gif<b>[/img]</b> <b>[img=right]</b>phplogo.gif<b>[/img]</b> really really really really really really long sentence. <table width=\"420\" cellpadding=\"5\"><tr><td class=\"quote\"><br /><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" align=\"left\" /> <img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" align=\"right\" /> A really really really really really really really really long sentence.<br /><br /><br /></td></tr></table>") ;
// LEFT-RIGHT-end

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
#-----[ FIND ]------------------------------------------ 
#
# NOTE: the full line to look for is:
#<!-- BEGIN img --><img src="{URL}" border="0" /><!-- END img -->
#
<!-- BEGIN img -->


#
#-----[ AFTER, ADD ]------------------------------------------ 
#

<!-- BEGIN left --><img src="{URL}" border="0" align="left" /><!-- END left -->

<!-- BEGIN right --><img src="{URL}" border="0" align="right" /><!-- END right -->

#
#-----[ SAVE/CLOSE FILES ]---------------------------------
#
# EoM