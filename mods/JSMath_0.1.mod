############################################################## 
## MOD Title: JSMath BBCode 
## MOD Author: PSimpson < paul@mggiandpaul.co.uk > (Paul) N/A
## MOD Description: Adds two new bbcodes.  Allows you insert tags to craete the <span> and
## 	   	        <div> tags needed for jsMath. You also need to download and install
##                  jsMath from http://www.math.union.edu/~dpvc/jsMath/download/jsMath.html
##                  MAKE SURE YOU DOWNLOAD BOTH THE PACKAGE ITSELF (jsMath-x.y.zip) AND
##                  THE FONT FILES (jsMath-fonts-x.y.zip) AND INSTALL IN THE ROOT OF YOUR
##                  WEBSITE.
##                  jsMath is provided courtesy of Davide P. Cervone [dpvc@union.edu]
## MOD Version: 1.0.0
## 
## Installation Level: (Easy) 
## Installation Time: 10 Minutes
## Files To Edit: - posting.php
##                - includes/bbcode.php,
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
## 		  You must have Multiple BBCode MOD installed for this to work.
##      Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=74705
##
##      example:
##		  [InlineMath]x^2-3[/InlineMath]
##		  [equation]y=x^2-3[/equation]
## 
############################################################## 
## MOD History: 
##
##   2006-12-15 - Version 1.0.0 
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
,'55','55'

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
,'InlineMath','Equation'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

  $bbcode_tpl['InlineMath'] = '\'' . $bbcode_tpl['InlineMath'] . '\'';
  $bbcode_tpl['InlineMath'] = str_replace('{MATH}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['InlineMath']);
  $bbcode_tpl['equation'] = '\'' . $bbcode_tpl['equation'] . '\'';
  $bbcode_tpl['equation'] = str_replace('{EQU}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['equation']);
#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// [InlineMath]string for search[/InlineMath] code..
	$patterns[] = "#\[InlineMath\](.*?)\[/InlineMath\]#ise";
	$replacements[] = $bbcode_tpl['InlineMath'];

	// [equation]string for search[/equation] code..
	$patterns[] = "#\[equation\](.*?)\[/equation\]#ise";
	$replacements[] = $bbcode_tpl['equation'];
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

$lang['bbcode_help']['InlineMath'] = 'InlineMath: [InlineMath]LaTeX for InlineMaths[/InlineMath] (alt+%s)';
$lang['bbcode_help']['equation'] = 'Equation: [equation]LaTeX for maths block[/equation] (alt+%s)';

#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/overall_footer.tpl
    
#
#-----[ FIND ]------------------------------------------ 
#
</body>
#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
<script> jsMath.Process(); </script>

#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/overall_header.tpl
    
#
#-----[ FIND ]------------------------------------------ 
#
.helpline
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
.math    {
		visibility: hidden
}

#
#-----[ FIND ]------------------------------------------ 
#
</head>
#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
<script>jsMath = {Controls: {cookie: {scale: 133}}}</script>
<script src="/jsMath/jsMath.js"></script>

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

<!-- BEGIN InlineMath --><span class = "math">{MATH}</span><!-- END InlineMath -->
<!-- BEGIN equation --><div class = "math">{EQU}</div><!-- END equation -->
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
,'[InlineMath]','[/InlineMath]','[equation]','[/equation]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM
