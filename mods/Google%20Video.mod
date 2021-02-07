##############################################################
## MOD Title: Google Video Mod
## MOD Author: Perldude69 < perldude69@gmail.com > (James Hughes) http://www.wachadoo.com
## MOD Description: Add Google Videos to your phpBB site. 
## You must have Multiple BBCode MOD installed for this to work.
## Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705 
## MOD Version: 1.0.1b
## 
## Installation Level: Easy
## Installation Time: 2 minutes
## Files To Edit: 
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2288.38406 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: You must have Multiple BBCode MOD installed for this to work.
## Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705 
## Credits to YouTube Mod Author: michaeltripp < iamdrscience@hotmail.com > (Mike) http://itsbeenconfirmed.com 
## 
## This is just a modified version of his YouTube Mod
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
,'60'

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
,'GVideo'

#
#-----[ FIND ]------------------------------------------
#
$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

$bbcode_tpl['GVideo'] = str_replace('{GVIDEOID}', '\\1', $bbcode_tpl['GVideo']);
$bbcode_tpl['GVideo'] = str_replace('{GVIDEOLINK}', $lang['GVideo_link'], $bbcode_tpl['GVideo']);

#
#-----[ FIND ]------------------------------------------
#
$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#

    // [GVideo]GVideo URL[/GVideo] code..
    $patterns[] = "#\[GVideo\]http://video.google.com/videoplay\?docid=([0-9A-Za-z-_]*)[^[]*\[/GVideo\]#is";
    $replacements[] = $bbcode_tpl['GVideo'];


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

$lang['bbcode_help']['GVideo'] = 'GVideo: [GVideo]GVideo URL[/GVideo]';

$lang['GVideo_link'] = 'Link';
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


<!-- BEGIN GVideo -->
<object width="425" height="350">
        <param name="movie" value="http://video.google.com/googleplayer.swf?docId={GVIDEOID}"></param>
<embed style="width:400px; height:326px;" id="VideoPlayback"
        align="middle" type="application/x-shockwave-flash"
        src="http://video.google.com/googleplayer.swf?docId={GVIDEOID}"
        allowScriptAccess="sameDomain" quality="best" bgcolor="#ffffff"
        scale="noScale" salign="TL"  FlashVars="playerMode=embedded">
</embed>
</object><br />
<a href="http://video.google.com/googleplayer.swf?docId={GVIDEOID}" target="_blank">{GVIDEOLINK}</a><br />
<!-- END GVideo -->

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
,'[GVideo]','[/GVideo]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM