##############################################################
## MOD Title: FlowPlayer 1.0.1 BBCode interface MOD
## MOD Author: Jeremy Aaron Horland < jeremy@intracommunities.org > (Jeremy Aaron Horland) http://www.intracommunities.org
## MOD Description: Allows in-line embedding of .flv flash video files as bbcode entities. Requires download of Flowplayer open source flash video player, and also requires multiple bbcode mod.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 5 minutes
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
## Based entirely on EMFF mod by Martin Truckenbrodt
##
## http://sourceforge.net/softwaremap/trove_list.php?form_cat=401
## http://sourceforge.net/projects/flowplayer/
##
############################################################## 
## MOD History: 
## 
##   2006-10-18 - Version 1.0.1 
##      - Fixes for release requested by mod development team.
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#

Download the latest flowplayer package from 
http://sourceforge.net/projects/flowplayer/
place the FlowPlayer.swf file in your main directory
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
,'80'

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
,'FlowPlayer'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	//Begin flowplayer Mod
	$bbcode_tpl['flowplayer'] = str_replace('{WIDTH}', '\\1', $bbcode_tpl['flowplayer']);
	$bbcode_tpl['flowplayer'] = str_replace('{HEIGHT}', '\\2', $bbcode_tpl['flowplayer']);
	$bbcode_tpl['flowplayer'] = str_replace('{BASEURL}', '\\3', $bbcode_tpl['flowplayer']);
	$bbcode_tpl['flowplayer'] = str_replace('{URL}', '\\4', $bbcode_tpl['flowplayer']);
	//End flowplayer Mod
	
#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	//Begin flowplayer Mod
	//[flowplayer ]and[/flowplayer]code.. 
	$patterns[] = "#\[flowplayer=?([\d]*?)\.?([\d]*?):$uid\]([a-z]+://[^, \n\r]*?)/([^, \n\r\/]*?\.flv)\[/flowplayer:$uid\]#si"; 
	$replacements[] = $bbcode_tpl[flowplayer];
	//End flowplayer Mod
	
#
#-----[ FIND ]------------------------------------------
#
# Note, the find is much longer:
# 	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
# 
	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie"
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	//Begin flowplayer Mod
	//[flowplayer]flv_url_here[/flowplayer]
	$text = preg_replace("#\[flowplayer(=?\d*.?\d*)\](([a-z]+?)://([^, \n\r]+))\[\/flowplayer\]#si","[flowplayer\\1:$uid\]\\2[/flowplayer:$uid]", $text); 
	//End flowplayer Mod
	
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

$lang['bbcode_help']['flowplayer'] = 'Flowplayer Flash Video: [flowplayer=width.height]url to flv file[/flowplayer] (alt+%s)';

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

<!-- BEGIN flowplayer -->
<object type="application/x-shockwave-flash" data="FlowPlayer.swf" width="{WIDTH}" height="{HEIGHT}" id="FlowPlayer">
	<param name="movie" value="FlowPlayer.swf" />
	<param name="quality" value="high" />
	<param name="scale" value="1" />
	<param name="wmode" value="transparent" />
	<param name="flashvars" value="baseURL={BASEURL}&videoFile={URL}" />
</object>
<!-- END flowplayer --> 

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
,'[flowplayer=320.240]','[/flowplayer]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
