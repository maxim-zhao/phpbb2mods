############################################################## 
## MOD Title: YouTube Video BBCode 
## MOD Author: michaeltripp < iamdrscience@hotmail.com > (Mike) http://itsbeenconfirmed.com 
## MOD Description: Adds a new bbcode allowing you to easily embed videos from YouTube.com.
## MOD Version: 1.0.1 
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
##      Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705
##
##      example:
##  [youtube]YouTube URL[/youtube]
##
##  YouTube URL is the "Video URL (Permalink)" or the URL of the page the video 
##  is on, NOT the "Embeddable Player" code they have on their video pages.
## 
############################################################## 
## MOD History: 
##
##  2006-03-20 - Version 1.0.1
##	-Changed the names of the variables tbat are replaced in bbcode.tpl
##	from VIDEO and LINK to YOUTUBEID and YOUTUBELINK, because the names
##	were too common making it likely that they would conflict with other mods.
##
##  2006-03-17 - Version 1.0.0
##
##  2006-03-16 - Version 0.9.3
##	-Fixed a problem in the regex that allowed some invalid but benign input
##
##  2006-03-15 - Version 0.9.2
##	-Made the word "link" was a language variable
##	-Made the link open in a new window
##	-YouTube video IDs can have dashes, so I changed the regex to account for this
##	-Moved the link underneath the video instead of beside it
##
##  2006-03-07 - Version 0.9.1
##	-Added link for browsers YouTube's player doesn't like, i.e. Opera :(
##
##  2006-03-06 - Version 0.9.0
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
,'YouTube'

#
#-----[ FIND ]------------------------------------------
#
$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

$bbcode_tpl['youtube'] = str_replace('{YOUTUBEID}', '\\1', $bbcode_tpl['youtube']);
$bbcode_tpl['youtube'] = str_replace('{YOUTUBELINK}', $lang['youtube_link'], $bbcode_tpl['youtube']);

#
#-----[ FIND ]------------------------------------------
#
$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#

// [youtube]YouTube URL[/youtube] code..
$patterns[] = "#\[youtube\]http://(?:www\.)?youtube.com/watch\?v=([0-9A-Za-z-_]{11})[^[]*\[/youtube\]#is";
$replacements[] = $bbcode_tpl['youtube'];
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

$lang['bbcode_help']['youtube'] = 'YouTube: [youtube]YouTube URL[/youtube]';

$lang['youtube_link'] = 'Link';
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

<!-- BEGIN youtube -->
<object width="425" height="350">
	<param name="movie" value="http://www.youtube.com/v/{YOUTUBEID}"></param>
	<embed src="http://www.youtube.com/v/{YOUTUBEID}" type="application/x-shockwave-flash" width="425" height="350"></embed>
</object><br />
<a href="http://youtube.com/watch?v={YOUTUBEID}" target="_blank">{YOUTUBELINK}</a><br />
<!-- END youtube -->
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
,'[youtube]','[/youtube]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM

