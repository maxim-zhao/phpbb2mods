#################################################################
## MOD Title: Inline Spoiler BBcode MOD
## MOD Author: ahwm < adam@savedisneyshows.org > (Adam Humpherys) http://www.TheScripters.com
## MOD Description: Adds a unique spoiler tag that is black text inline with the original message
##              posted by the user.  [spoiler] Spoiler Text [/spoiler]
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: ~10 Minutes
## Files To Edit: templates/subSilver/overall_header.tpl
##                  includes/bbcode.php,
##		  language/lang_english/lang_main.php,
##                language/lang_english/lang_bbcode.php,
##                templates/subSilver/bbcode.tpl,
##		  templates/subSilver/posting_body.tpl
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
## Tested without problems in Internet Explorer 6.0 and FireFox 1.5 on phpBB v. 2.0.16
##
## Also recommended is the BBCode Buttons MOD by Nuttzy, though not required ;)
##
## Installed successful with Easymod.
##
## IMPORTANT: you MUST first have already installed the Multi BBCode MOD 1.4.0
##    available at http://www.phpbb.com/mods/
##
##############################################################
## MOD History:
##
## 2006-2-12 - version 1.0.1
##        - Fixed bugs/typoes in code
##
## 2006-1-18 - version 0.7.0
##        - First version (in MOD format)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl

#
#-----[ FIND ]---------------------------------
#
<title>{SITENAME} :: {PAGE_TITLE}</title>

#
#-----[ AFTER, ADD ]------------------------------------------
# Note: Some styles have additional <style></style> tags while others don't
<style><!--
.spoiler {background: #000000; color: #000000}
--></style>

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php


#
#-----[ FIND ]---------------------------------
#
$EMBB_widths = array(''
$EMBB_values = array(''


#
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_widths = array(''


#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'50'

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
// colours


#
#-----[ BEFORE, ADD ]------------------------------------------
#

// Begin inline Spoiler Tag
   // [spoiler] Spoiler Text [/spoiler]
   $text = str_replace("[spoiler:$uid]", $bbcode_tpl['spoiler_open'], $text);
   $text = str_replace("[/spoiler:$uid]", $bbcode_tpl['spoiler_close'], $text);
// End inline Spoiler Tag

#
#-----[ FIND ]------------------------------------------
#
// [color] and [/color] for setting text color


#
#-----[ BEFORE, ADD ]------------------------------------------
#

// Begin inline Spoiler Tag
   // [spoiler] and [/spoiler] for highlighting spoilers
   $text = preg_replace("#\[spoiler\](.*?)\[/spoiler\]#si", "[spoiler:$uid]\\1[/spoiler:$uid]", $text);
// End inline Spoiler Tag

#
#-----[ OPEN ]------------------------------------------
# NOTE: You need to do this for all installed languages
#
language/lang_english/lang_main.php


#
#-----[ FIND ]------------------------------------------
# NOTE: Full line in English is:
# $lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';
#
$lang['bbcode_f_help'] =


#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['bbcode_help']['spoiler'] = 'Inline spoilers [spoiler]text[/spoiler] (alt+%s)';


#
#-----[ OPEN ]------------------------------------------
# NOTE: You need to do this for all installed languages
#
language/lang_english/lang_bbcode.php


#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$faq[] = array('Inline Spoiler Tag', "The Inline Spoiler Tag allows a user to type spoilers without the need for skipping lines allowing to hide names or other facts that may be scattered throughout a post without making it look sloppy.<br /><br /><br />[spoiler] Hidden Text [/spoiler]<br /><br /><span class=\"spoiler\">Hidden Text</span>");

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl


#
#-----[ FIND ]------------------------------------------
# NOTE: Full line to look for is:
# <!-- BEGIN b_open --><span style="font-weight: bold"><!-- END b_open -->
#
<!-- BEGIN b_open -->


#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN spoiler_open -->
<span class="spoiler">
<!-- END spoiler_open -->
<!-- BEGIN spoiler_close -->
</span>
<!-- END spoiler_close -->

#
#-----[ OPEN ]------------------------------------------
# NOTE: You need to do this for all of your installed template styles
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]---------------------------------
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
,'[spoiler]','[/spoiler]'


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
