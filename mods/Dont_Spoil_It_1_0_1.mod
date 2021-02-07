##############################################################
## MOD Title: Don't Spoil It!
## MOD Author: darklordsatan < N/A > (N/A) http://eviltrend.sourceforge.net
## MOD Description: This mod adds a new BBCode ('spoiler') that allows the user to hide text
##                  (in both topics and PMs) that can be unveiled/hidden by clicking on it.
##                  The user can embed other bbcodes inside the spoiler tag, and the spoiler works
##                  well inside other bbcodes too.
## MOD Version: 1.0.1
##
## Installation Level: (Easy)
## Installation Time: 5 Minutes
## Files To Edit: includes/bbcode.php
##                language/lang_english/lang_main.php
##                templates/subSilver/bbcode.tpl
##                templates/subSilver/overall_header.tpl
##                templates/subSilver/posting_body.tpl
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
## Author Notes: If you are not happy with the style of the Spoiler tag, and you have a fair knowledge
##               of HTML/CSS, you can easily change its looks by writing your own code in
##               templates/subSilver/bbcode.tpl
##               Or you can just change mine a little bit (colors, etc) for example, if you are not using
##               the default template (subSilver) and the tag looks "ugly" in the one you use
## 
##               IMPORTANT: you MUST first have already installed the Multi BBCode MOD
##                          available at http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##
##############################################################
## MOD History:
##
##   2005-12-30 - Version 1.0.0
##      - Release of the first version
##
##   2006-01-12 - Version 1.0.1
##      - Minor code fixes/mod template additions in order to resubmit the mod at the phpBB MOD database
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php

# 
#-----[ FIND ]---------------------------------
#
	$EMBB_widths = array('') ;
	$EMBB_values = array('') ;

# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_widths = array(''

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'60'

# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_values = array(''

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'Spoiler'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['code_open'] = str_replace('{L_CODE}', $lang['Code'], $bbcode_tpl['code_open']);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// Start Don't Spoil It! Mod
	$bbcode_tpl['spoiler_open'] = str_replace('{L_SPOILER}', $lang['Spoiler'], $bbcode_tpl['spoiler_open']);	
	// End Don't Spoil It! Mod

#
#-----[ FIND ]------------------------------------------
#
	$text = str_replace("[/i:$uid]", $bbcode_tpl['i_close'], $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// Don't Spoil It! START	
	while(true)
	{
		// Adapted from http://www.php.net/srand
		// Are you feeling paranoid today? :D
		list($usec, $sec) = explode(' ', microtime());
		srand((float) $sec + ((float) $usec * 100000));
		$random_id = md5(microtime() . rand());
		
		// Trick to give each spoiler tag an unique ID for the Javascript function to work properly :)
		// str_replace() doesnt know about matching limits, so I had to use preg_replace() :(
		$tmp_spoiler_open = str_replace('{SPOILER_ID}', $random_id, $bbcode_tpl['spoiler_open']);	
		$tmp_text = $text;
		$text = preg_replace("/\[spoiler:$uid\]/", $tmp_spoiler_open, $text, 1);
		
		// There are no (more) matches, so lets get outta here
		if(strcmp($text, $tmp_text) == 0)
		{
			break;
		}
	}	
	$text = str_replace("[/spoiler:$uid]", $bbcode_tpl['spoiler_close'], $text);
	// Don't Spoil It! END

#
#-----[ FIND ]------------------------------------------
#
	$text = preg_replace("#\[i\](.*?)\[/i\]#si", "[i:$uid]\\1[/i:$uid]", $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// Start Don't Spoil It! Mod
	// spoiler tags
	$text = preg_replace("#\[spoiler\](.*?)\[/spoiler\]#si", "[spoiler:$uid]\\1[/spoiler:$uid]", $text);
	// End Don't Spoil It! Mod

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Code'] = 'Code'; // comes before bbcode code output.

#
#-----[ AFTER, ADD ]------------------------------------------
#
 
// Start Don't Spoil It! Mod
$lang['Spoiler'] = 'Click here to see the hidden message (It might contain spoilers)'; // comes before bbcode spoiler output.
// End Don't Spoil It! Mod

#
#-----[ FIND ]------------------------------------------
#
$lang['bbcode_help']['value'] = 'BBCode Name: Info (Alt+%s)';

#
#-----[ AFTER, ADD ]------------------------------------------
#
 
// Start Don't Spoil It! Mod
$lang['bbcode_help']['spoiler'] = 'Hide Text (for spoilers): [spoiler]text[/spoiler] (alt+%s)';
// End Don't Spoil It! Mod

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN i_close --></span><!-- END i_close -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
<!-- BEGIN spoiler_open -->
<div onClick="unveil_spoiler('{SPOILER_ID}')" style="padding: 5px; background-color: #DEE3E7; border: 2px #006699 solid; font-weight: bold; font-size: 10px;"><b>{L_SPOILER}</b></div>
<div style="padding: 5px; background-color: #FAFCFE; border: 1px #000000 solid; display: none;" id="{SPOILER_ID}">
<!-- END spoiler_open -->
<!-- BEGIN spoiler_close -->
</div>
<!-- END spoiler_close -->

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------
#
</style>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<!-- /* Start Don't Spoil It! Mod */ //-->
<script language="JavaScript">
<!--
function unveil_spoiler(id)
{
	element = document.getElementById(id);
	if (element.style.display == 'none')
	{
		element.style.display = '';
	}
	else
	{
		element.style.display = 'none';
	}
}
//-->
</script>
<!-- /* End Don't Spoil It! Mod */ //-->

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
# NOTE: The actual line is longer than this...
#
bbtags = new Array(


#
#-----[ IN-LINE FIND ]------------------------------------------ 
#

'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

,'[spoiler]','[/spoiler]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
