##############################################################
## MOD Title: Quicktime and Windows Media Player BBCode MOD
## MOD Author: Tocsin LK < cryptic303 AT yahoo DOT com > (Low-Key) http://www.acidgrave.com
## MOD Description: Apple Quicktime and Windows Media Player BBcode tag MOD, with quick access buttons.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 10 minutes
## Files To Edit: includes/bbcode.php
##                language/lang_english/lang_main.php
##                templates/subSilver/bbcode.tpl    
##                templates/subSilver/posting_body.tpl
##
## Included Files: (N/A) 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
#############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/ 
##############################################################
## Author Notes:
## This is a kludged together modification to allow for embedding media
## with Apple Quicktime Player or Windows Media Player. Previous modifications
## did not function with the Multiple BBCode Modand Quicktime did not respond
## to formatting in Internet Explorer.  In the process of making the mods work
## for my system, I pieced this together for anyone else who has requested
## such BBCode modifications and has been unable to find one that works.
## 
## IMPORTANT: YOU MUST HAVE Multiple BBCode MOD installed for this to work.
## Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705
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
,'45','35'

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
,'WMP','QT'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
        // Begin QT and WMP Mod 0.0.1
        $bbcode_tpl['wmp'] = str_replace('{URL}', '\\1', $bbcode_tpl['wmp']);
        $bbcode_tpl['qt'] = str_replace('{URL}', '\\1', $bbcode_tpl['qt']);
	// End QT and WMP Mod 0.0.1
	
#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
        // Begin QT and WMP Mod 0.0.1
        //[ wmp ]and[ /wmp ]for Windows Media Player.
        $patterns[] = "#\[wmp:$uid\](.*?)\[/wmp:$uid\]#si";
        $replacements[] = $bbcode_tpl['wmp'];
        //[ qt ]and[ /qt ]for Apple Quicktime Player.
        $patterns[] = "#\[qt:$uid\](.*?)\[/qt:$uid\]#si";
        $replacements[] = $bbcode_tpl['qt'];
        // End QT and WMP Mod 0.0.1


#
#-----[ FIND ]------------------------------------------
#
# Note, the find is much longer:
# 	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
# 
	$text = preg_replace("#\[img\]((
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
        // Begin QT and WMP Mod 0.0.1
        //[ wmp]image_url_here[/wmp ]code..
        $text = preg_replace("#\[wmp\](([a-z]+?)://([^, \n\r]+))\[/wmp\]#si", "[wmp:$uid]\\1[/wmp:$uid]", $text);
        //[ qt]image_url_here[/qt ]code..
        $text = preg_replace("#\[qt\](([a-z]+?)://([^, \n\r]+))\[/qt\]#si", "[qt:$uid]\\1[/qt:$uid]", $text);
        // End QT and WMP Mod 0.0.1

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

$lang['bbcode_help']['WMP'] = 'Play file w/Windows Media Player: [wmp]http://url[/wmp]  (alt+%s)';
$lang['bbcode_help']['QT'] = 'Play file w/Quicktime Video/Audio: [qt]http://url[/qt]   (alt+%s)';

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
# NOTE: The BGCOLOR variable in the QT code below is set for the default color with subSilver.  If you are using
#        other themes, you may want to change the BGCOLOR variable in the affected bbcode.tpl files
#	 to preserve a smooth color layout. It appears 3 times in the code below.

<!-- BEGIN wmp --><object id="wmp" width="350" height="300" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,0,0,0" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject">
<param name="FileName" value="{URL}">
<param name="ShowControls" value="1">
<param name="ShowDisplay" value="0">
<param name="ShowStatusBar" value="1">
<param name="AutoSize" value="1">
<param name="autoplay" value="0">
<param name="autoStart" value="0">
<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/windows95/downloads/contents/wurecommended/s_wufeatured/mediaplayer/default.asp" $animationatstart=0 transparentatstart=1 loop=0 height="300" width="350">
</embed>
</object><!-- END wmp -->

<!-- BEGIN qt -->
<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" WIDTH="350" HEIGHT="316" SCALE="ASPECT" BGCOLOR="#1E1E2A" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0">
   <PARAM NAME="controller" VALUE="TRUE">
   <PARAM NAME="type" VALUE="video/quicktime">
   <PARAM NAME="autoplay" VALUE="false">
   <PARAM NAME="target" VALUE="myself">
   <PARAM NAME="src" VALUE="{URL}">
   <PARAM NAME="scale" VALUE="ASPECT">
   <PARAM NAME="bgcolor" VALUE="#1E1E2A">
   <PARAM NAME="pluginspage" VALUE="http://www.apple.com/quicktime/download/">
   <EMBED WIDTH="350" HEIGHT="316" SCALE="ASPECT" AUTOPLAY="FALSE" BGCOLOR="#1E1E2A" CONTROLLER="TRUE" TARGET="myself" SRC="{URL}" type="video/quicktime" BORDER="0" PLUGINSPAGE="http://www.apple.com/quicktime/download/"></EMBED>
</OBJECT>
<!-- END qt -->

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
,'[wmp]','[/wmp]','[qt]','[/qt]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM