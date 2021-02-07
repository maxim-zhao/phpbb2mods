##############################################################
## MOD Title: Flash MOD
## MOD Author: smithy_dll < davidls14 AT yahoo DOT com DOT au > (David Smith) http://david.smigit.com/projects/flash-mod/
## MOD Description: Flash BBcode tag MOD, with quick access buttons.
## MOD Version: 2.0.21
## 
## Installation Level: Easy
## Installation Time: 8 minutes
## Files To Edit: includes/bbcode.php
##                language/lang_english/lang_main.php
##                templates/subSilver/bbcode.tpl
##                templates/subSilver/posting_body.tpl
## Included Files: 
## Generator: Phpbb.ModTeam.Tools
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
## You must have Multiple BBCode MOD installed for this to work.
## Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##############################################################
## MOD History:
## 
## 2006-09-26 - Version 2.0.21
##      -Updated to phpBB 2.0.21 standards
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
   $EMBB_widths = array(''
#
#-----[ IN-LINE FIND ]------------------------------------------
#
array(''
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
,'50'

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
,'Flash'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Begin Flash MOD
	$bbcode_tpl['flash'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['flash']);
	$bbcode_tpl['flash'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['flash']);
	$bbcode_tpl['flash'] = str_replace('{LOOP}', '\\3', $bbcode_tpl['flash']);
	$bbcode_tpl['flash'] = str_replace('{URL}', '\\4', $bbcode_tpl['flash']);
	$bbcode_tpl['cf'] = str_replace('{URL}', '\\1', $bbcode_tpl['cf']);
	// End   Flash MOD
#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Begin Flash MOD
	//[flash width= height= loop= ]and[/flash]code.. 
	$patterns[] = "#\[flash width=([0-6]?[0-9]?[0-9]) height=([0-5]?[0-9]?[0-9]) loop=(true|false):$uid\](.*?)\[/flash:$uid\]#si"; 
	$replacements[] = $bbcode_tpl[flash];
	//[flash]and[/flash]code.. 
	$patterns[] = "#\[flash:$uid\](.*?)\[/flash:$uid\]#si"; 
	$replacements[] = $bbcode_tpl[cf];
	// End   Flash MOD
#
#-----[ FIND ]------------------------------------------
#
# Note, the find is much longer:
# 	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
	$text = preg_replace("#\[img\]((
#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Begin Flash MOD
	//[flash width= heigth= loop=] and[ /flash ]
	$text = preg_replace("#\[flash width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-5]?[0-9]) loop=(true|false)\](([a-z]+?)://([^, \n\r]+))\[\/flash\]#si","[flash width=\\1 height=\\2 loop=\\3:$uid\]\\4[/flash:$uid]", $text); 
	$text = preg_replace("#\[flash width=([0-6]?[0-9]?[0-9]) height=([0-4]?[0-5]?[0-9])\](([a-z]+?)://([^, \n\r]+))\[\/flash\]#si","[flash width=\\1 height=\\2 loop=false:$uid\]\\3[/flash:$uid]", $text); 
	$text = preg_replace("#\[flash\](([a-z]+?)://([^, \n\r]+))\[\/flash\]#si","[flash:$uid\]\\1[/flash:$uid]", $text); 
	// End   Flash MOD
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
# NOTE: the full line to look for is:
# $lang['bbcode_f_help'] = "Font size: [size=x-small]small text[/size]";
# 
$lang['bbcode_f_help'] =

#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['bbcode_help']['flash'] = 'Flash: [flash width=000 height=000 loop=(true|false)]url to swf file[/flash] (alt+%s)';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</a><!-- END email -->
#
#-----[ AFTER, ADD ]------------------------------------------
#

<!-- BEGIN flash -->
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="{WIDTH}" height="{HEIGHT}">
  <param name="allowScriptAccess" value="never" />
  <param name="movie" value="{URL}" />
  <param name="loop" value="{LOOP}" />
  <param name="quality" value="high" />
  <param name="scale" value="noborder" />
  <param name="wmode" value="transparent" />
  <param name="bgcolor" value="#000000" />
  <embed allowScriptAccess="never" src="{URL}" loop="{LOOP}" quality="high" scale="noborder" wmode="transparent" bgcolor="#000000" width="{WIDTH}" height="{HEIGHT}" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed> 
</object><!-- END flash --> 

<!-- BEGIN cf -->
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0">
  <param name="allowScriptAccess" value="never" />
  <param name="movie" value="{URL}" />
  <param name="quality" value="high" />
  <param name="scale" value="noborder" />
  <param name="wmode" value="transparent" />
  <param name="bgcolor" value="#000000" />
  <embed allowScriptAccess="never" src="{URL}" quality="high" scale="noborder" wmode="transparent" bgcolor="#000000" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed> 
</object><!-- END cf -->

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
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
,'[flash]','[/flash]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
