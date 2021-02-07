##############################################################
## MOD Title: Streetfire Video Mod
## MOD Author: BLWedge09 < N/A > (N/A) N/A
## MOD Description: Add Streetfire.net Videos to your phpBB site. 
## You must have Multiple BBCode MOD installed for this to work.
## Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705 
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 5 minutes
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
,'67'

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
,'Streetfire'

#
#-----[ FIND ]------------------------------------------
#
$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

$bbcode_tpl['Streetfire'] = str_replace('{StreetfireID}', '\\1', $bbcode_tpl['Streetfire']);
$bbcode_tpl['Streetfire'] = str_replace('{StreetfireLINK}', $lang['Streetfire_link'], $bbcode_tpl['Streetfire']);

#
#-----[ FIND ]------------------------------------------
#
$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#

    // [Streetfire]Streetfire URL[/Streetfire] code..
    $patterns[] = "#\[Streetfire\]http://videos.streetfire.net/video/([0-9A-Za-z]{8}-[0-9A-Za-z]{4}-[0-9A-Za-z]{4}-[0-9A-Za-z]{4}-[0-9A-Za-z]{12})[^[]*\[/Streetfire\]#is";
    $replacements[] = $bbcode_tpl['Streetfire'];


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

$lang['bbcode_help']['Streetfire'] = 'Streetfire: [Streetfire]Streetfire URL[/Streetfire]';

$lang['Streetfire_link'] = 'Link';
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


<!-- BEGIN Streetfire -->
<object width="450" height="375">
      <param name="movie" value="http://videos.streetfire.net/video/{StreetfireID}"></param>
	<embed src="http://videos.streetfire.net/vidiac.swf" 
		FlashVars="video={StreetfireID}" 
		quality="high" bgcolor="#ffffff" width="428" height="352" 
		name="ePlayer" align="middle" allowScriptAccess="sameDomain" 
		type="application/x-shockwave-flash" 
		pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object><br />
<a href="http://videos.streetfire.net/video/{StreetfireID}.htm" target="_blank">{StreetfireLINK}</a><br />
<!-- END Streetfire -->

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
,'[Streetfire]','[/Streetfire]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM