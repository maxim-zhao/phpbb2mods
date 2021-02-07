##############################################################
## MOD Title: PHP Manual BBCode
## MOD Author: tekky < ktiedt@gmail.com > (Karl Tiedt) http://dev.xnet.org
## MOD Description: Allows you to quickly make references to function definitions in the online PHP manual in your posts.
## MOD Version: 1.1.0
##
## Installation Level: (Easy)
## Installation Time: 5 Minutes
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
##          You must have Multiple BBCode MOD installed for this to work.
##          Get it on this page: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##
##          Cross_+_Flames' "Bible Passages BBCode" mod provided the know-how for this mod. Thanks Cross_+_Flame!
##############################################################
## MOD History:
##
##   2005-08-22 - Version 1.0
##		- Released to phpBB Mod Team
##              - It began...
##   2006-08-11 - Version 1.1
##		- Resubmitted for bug fix
##              - Patched to prevent XSS exploit in IE. Thanks TerraFrost for bringing it to my knowledge and extra thanks to the creators of Internet Exploder for its multitude of exploitable features.
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
,'40'

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
,'Man'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);

#
#-----[ AFTER, ADD ]------------------------------------------
#

  $bbcode_tpl['man'] = '\'' . $bbcode_tpl['man'] . '\'';
  $bbcode_tpl['man'] = str_replace('{PHP_FUNCTION}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['man']);

#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// [man]string for PHP manual reference[/man] code..
	$patterns[] = "#\[man\](.*?)\[/man\]#ise";
	$replacements[] = $bbcode_tpl['man'];
		
#
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------
#
# NOTE: the full line to look for is:
#$lang['bbcode_help']['value'] = 'BBCode Name: Info (Alt+%s)';
#
$lang['bbcode_help']['value']

#
#-----[ AFTER, ADD ]---------------------------------
#
$lang['bbcode_help']['man'] = 'PHP Manual reference: [man]php_function[/man] (alt+%s)';

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
,'[man]','[/man]'

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl
   
#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN email -->

#
#-----[ AFTER, ADD ]------------------------------------------
#

<!-- BEGIN man --><a href="http://www.php.net/{PHP_FUNCTION}" target="_blank">{PHP_FUNCTION}</a><!-- END man -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM