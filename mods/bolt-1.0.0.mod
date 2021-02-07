############################################################## 
## MOD Title: Bolt.com Video BBCode 
## MOD Author: michaeltripp < iamdrscience@hotmail.com > (Mike) http://itsbeenconfirmed.com 
## MOD Description: Adds a new bbcode allowing you to easily embed videos from bolt.com.
## MOD Version: 1.0.0 
## 
## Installation Level: (Easy) 
## Installation Time: ~5 Minutes
## Files To Edit: - includes/bbcode.php,
##                - langugage/lang_english/lang_main.php,
##                - templates/subSilver/bbcode.tpl,
##                - templates/subSilver/posting_body.tpl
## Included Files: n/a
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
##   You must have Multiple BBCode MOD installed for this to work.
##      Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=145513 
##
##      example:
##  [bolt]Bolt Video URL[/bolt]
##
##  Bolt Video URL is the URL in the "share this video" box or the URL of the page the video 
##  is on, NOT the "Embed" code they have on their video pages.
## 
############################################################## 
## MOD History: 
##
##  2006-04-13 - Version 1.0.0
##  2006-03-28 - Version 0.9.0
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
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
,'45'

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
,'Bolt'

#
#-----[ FIND ]------------------------------------------
#
$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

$bbcode_tpl['bolt'] = str_replace('{BOLTID}', '\\1', $bbcode_tpl['bolt']);

#
#-----[ FIND ]------------------------------------------
#
$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#

// [bolt]Bolt Video URL[/bolt] code..
$patterns[] = "#\[bolt\]http://(?:www\.)?bolt.com/[a-zA-Z0-9-]*/video/([0-9]+)[^[]*\[/bolt]#is";
$replacements[] = $bbcode_tpl['bolt'];
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

$lang['bbcode_help']['bolt'] = 'Bolt: [bolt]Bolt Video URL[/bolt]';

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

<!-- BEGIN bolt -->
<br />
<embed src="http://www.bolt.com/video/flv_player_branded.swf?contentId={BOLTID}" loop="false" quality="high" bgcolor="white" width="365" height="340" name="video_play_500" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /><br />
<!-- END bolt -->

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
,'[bolt]','[/bolt]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM

