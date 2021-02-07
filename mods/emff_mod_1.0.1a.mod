##############################################################
## MOD Title: EMFF 0.4 BBCode MOD
## MOD Author: Martin Truckenbrodt < webmaster@martin-truckenbrodt.com > (Martin Truckenbrodt) http://www.martin-truckenbrodt.com
## MOD Description: EMFF 0.4 BBcode tag MOD
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 10 minutes
## Files To Edit: includes/bbcode.php
##                language/lang_english/lang_main.php
##                templates/subSilver/bbcode.tpl
##                templates/subSilver/posting_body.tpl
## Included Files: 
## 
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
## You must have Multiple BBCode MOD installed for this to work.
## Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705
## 
## More information about the EMFF you can find here: http://www.marcreichelt.de/spezial/musicplayer/ (German and English)
##   and here: http://aktuell.de.selfhtml.org/artikel/grafik/flashmusik/index.htm (German).
## 
############################################################## 
## MOD History: 
## 
##   2006-07-14 - Version 1.0.0 
##      - first release 
## 
##   2006-07-20 - Version 1.0.1 
##      - some cosmetics for MOD validation and EMC compatibility 
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
create a new folder called emff_mod into the phpBB root folder
Download EMFF 0.4 from http://sourceforge.net/project/showfiles.php?group_id=121753
Extract the swf files into the folder called emff_mod
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
,'EMFF'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	//Begin emff Mod
	$bbcode_tpl['emff'] = str_replace('{URL}', '\\1', $bbcode_tpl['emff']);
	//End emff Mod
	
#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	//Begin EMFF Mod
	//[emff ]and[/emff]code.. 
	$patterns[] = "#\[emff:$uid\](.*?)\[/emff:$uid\]#si"; 
	$replacements[] = $bbcode_tpl[emff];
	//End EMFF Mod
	
#
#-----[ FIND ]------------------------------------------
#
# Note, the find is much longer:
# 	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&amp;=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
# 
	$text = preg_replace("#\[img\]((
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	//Begin EMFF Mod
	//[emff]mp3_url_here[/emff]
	$text = preg_replace("#\[emff\](([a-z]+?)://([^, \n\r]+))\[\/emff\]#si","[emff:$uid\]\\1[/emff:$uid]", $text); 
	//End EMFF Mod
	
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

$lang['bbcode_help']['emff'] = 'EMFF: [emff]url to mp3 file[/emff] (alt+%s)';

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

<!-- BEGIN emff -->
<object data="emff_mod/emff_standard.swf" type="application/x-shockwave-flash" width="110" height="34" align="top">
	<param name="movie" value="emff_mod/emff_standard.swf" />
	<param name="FlashVars" value="src={URL}" />
	<param name="quality" value="high" />
	<param name="bgcolor" value="#ECECEC" />
</object>
<!-- END emff --> 

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
,'[emff]','[/emff]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
