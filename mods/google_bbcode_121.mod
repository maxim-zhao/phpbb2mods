##############################################################
## MOD Title: Google Search BBCOde
## MOD Author: wGEric < N/A > (Eric Faerber) http://www.ericfaerber.com/
## MOD Author: LifeIsPain < N/A > (N/A) N/A
## MOD Description: Adds a new bbcode.  Allows you put make strings in your post
## 	   	    be searched for in Google. ([google]string to search for[/google])
## MOD Version: 1.2.1
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit: - posting.php
##                - includes/bbcode.php,
##                - langugage/lang_english/lang_main.php,
##                - templates/subSilver/bbcode.tpl,
##                - templates/subSilver/posting_body.tpl
## Included Files: N/A
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
## 		  You must have Multiple BBCode MOD installed for this to work.
##      Get it here: http://www.phpbb.com/mods/db/index.php?i=misc&mode=display&contrib_id=567
##
##      example:
##		  [google]string to search for[/google]
##
##############################################################
## MOD History:
##
##	2007-10-03 - Version 1.2.1
##			- Updated
##
##  2004-09-27 - Version 1.2.0
##	       - Updated to work with Multi BBcode 1.4.0
##
##  2003-07-30 - Version 1.1.2
##	       - Fixed a typo
##
##  2003-07-28 - Version 1.1.1
##             - Fixed bug that would escape ", Thanks to LifeIsPain
##
##   2003-07-24 - Version 1.1.0
##              - Added Button
##				- Minor Changes
##
##   2003-07-18 - Version 1.0.0 
##      	- First Release
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
,'55'

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
,'Google'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

	$bbcode_tpl['google'] = '\'' . $bbcode_tpl['google'] . '\'';
	$bbcode_tpl['google'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['google']);
	$bbcode_tpl['google'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['google']);
#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// [google]string for search[/google] code..
	$patterns[] = "#\[google\](.*?)\[/google\]#ise";
	$replacements[] = $bbcode_tpl['google'];
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

$lang['bbcode_help']['google'] = 'Google: [google]String to search for[/google] (alt+%s)';

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

<!-- BEGIN google --><a href="http://www.google.com/search?q={QUERY}" target="_blank">{STRING}</a><!-- END google -->
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
,'[google]','[/google]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM