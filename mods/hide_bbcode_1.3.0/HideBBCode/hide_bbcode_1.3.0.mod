################################################################# 
## MOD Title: Hide BBcode MOD 
## MOD Author: EGIS < post@mj2k.com > (Mathias Jørgensen) http://www.mj2k.com 
## MOD Description: Adds a Hide BBcode to your forum, which reveals the hidden 
##     code (images too) when some text is clicked. Great if you want other users to agree 
##     before viewing information about for example the ending of a book. Also great for hiding 
##     screenshots and big images so they don't screw up the page layout. 
##     Usage: [hide]Hidden code here[/hide] or [hide=Text to be clicked]Hidden code here[/hide] 
## 
## MOD Version: 1.3.0 
## 
## Installation Level: Easy 
## Installation Time: ~10 Minutes 
## Files To Edit: includes/bbcode.php, 
##		  language/lang_english/lang_main.php, 
##                language/lang_english/lang_bbcode.php, 
##                templates/subSilver/bbcode.tpl, 
##		  templates/subSilver/overall_header.tpl, 
##		  templates/subSilver/simple_header.tpl, 
##		  templates/subSilver/posting_body.tpl
## Included Files: hidebbcode.js
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## Tested without problems in Opera 7.53, Opera 6.0, Internet Explorer 6.0 and Netscape 7.2 on phpBB v. 2.0.10
## Installed successful with Easymod.
## Visual problem in Netscape 4.77.
## Thanks to markus_petrux for the javascript.
##
## IMPORTANT: you MUST first have already installed the Multi BBCode MOD 1.4.0
##    available at http://www.phpbb.com/mods/ 
## 
############################################################## 
## MOD History: 
## 
##   2004-07-31 - Version 1.0.0 
##   - First Beta 
## 
##   2004-07-31 - Version 1.1.0 
##   - Added [hide=Your link text here] 
## 
##   2004-08-09 - Version 1.2.0 
##   - Changed the MOD name from 'Expanding DIV Spoiler BBcode MOD' to 'Hide BBcode MOD' 
##   - Changed the bbcode from [spoiler] to [hide] 
##   - Added FAQ entry 
## 
##   2004-08-25 - Version 1.2.1
##   - Added support for legacy browsers (thanks to markus-petrux):
##     - For NS4, Hotjava and Opera5/6 uses the visibility attribute instead of display. 
##     - It also uses an <a href> tag (a link), adding support for browsers that 
##       do NOT support the onclick event for a DIV element. 
##   - Fixed problem when javascript is disabled. The end bbcode shouldn't write the </div>. 
##   - Rewritten so all the code lies behind just one global object. Avoids collision 
##     between other possible JS code present on the page.
##   - Fixed security issue where users could run javascript code.
##
##   2004-08-26 - Version 1.2.2
##   - Fixed javascript errors in simple_header.tpl.
##
##   2004-09-20 - Version 1.2.3
##   - Fixed issue with javascript ending up on one line. (Thanks again to markus-petrux)
##
##   2004-10-03 - Version 1.2.4
##   - Updated to work with Multi BBcode 1.4.0
##
##   2004-11-28 - Version 1.2.5
##   - Fixed small bug with the Hide button having no hint.
##
##   2005-01-13 - Version 1.2.6
##   - Fixed typo in hidebbcode.js
##
##   2005-02-27 - Version 1.3.0
##   - All characters (except single quote, backslash, new line and right square bracket)
##     are now supported in the hide text.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
# IMPORTANT: you MUST first have already installed the Multi BBCode MOD 1.4.0
#    available at http://www.phpbb.com/mods/ 
# 

# 
#-----[ COPY ]------------------------------------------ 
#
copy hidebbcode.js to templates/hidebbcode.js

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
,'40' 

# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
$EMBB_values = array('' 


# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'Hide' 


# 
#-----[ FIND ]------------------------------------------ 
# 
define("BBCODE_TPL_READY", true); 


# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
   $bbcode_tpl['hide_open'] = str_replace('{L_HIDE}', $lang['Hide'], $bbcode_tpl['hide_open']); 
   $bbcode_tpl['hide_owntext_open'] = str_replace('{L_HIDE}', '\\1', $bbcode_tpl['hide_owntext_open']); 
   $patterns = array('<!--', '//-->'); 
   $replacements = array("\r<!--\r", "\r//-->\r"); 
   $bbcode_tpl['hide_open']  = str_replace($patterns, $replacements, $bbcode_tpl['hide_open']); 
   $bbcode_tpl['hide_owntext_open']  = str_replace($patterns, $replacements, $bbcode_tpl['hide_owntext_open']); 
   $bbcode_tpl['hide_close']  = str_replace($patterns, $replacements, $bbcode_tpl['hide_close']);

# 
#-----[ FIND ]------------------------------------------ 
# 
// colours 


# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// Begin 'Hide BBcode MOD' 
   // [hide] Hidden code [/hide] 
   $text = str_replace("[hide:$uid]", $bbcode_tpl['hide_open'], $text); 
   $text = str_replace("[/hide:$uid]", $bbcode_tpl['hide_close'], $text); 
   $text = preg_replace("/\[hide:$uid=([^\'\]\n\\\]+)\]/si", $bbcode_tpl['hide_owntext_open'], $text); 
// End 'Hide BBcode MOD' 

# 
#-----[ FIND ]------------------------------------------ 
# 
// [color] and [/color] for setting text color 


# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// Begin 'Hide BBcode MOD' 
   // [hide] and [/hide] for hiding text or code 
   $text = bbencode_first_pass_pda($text, $uid, '[hide]', '[/hide]', '', false, ''); 
   $text = bbencode_first_pass_pda($text, $uid, '/\[hide=([^\'\]\n\\\]+)\]/is', '[/hide]', '', false, '', "[hide:$uid=\\1]"); 
// End 'Hide BBcode MOD' 

# 
#-----[ OPEN ]------------------------------------------ 
# NOTE: You need to do this for all installed languages 
# 
language/lang_english/lang_main.php 


# 
#-----[ FIND ]------------------------------------------ 
# NOTE: Full line in English is: 
# $lang['Code'] = 'Code'; // comes before bbcode code output. 
# 
$lang['Code'] = 


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['Hide'] = 'Click to reveal hidden content'; 

# 
#-----[ FIND ]------------------------------------------ 
# NOTE: Full line in English is: 
# $lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]'; 
# 
$lang['bbcode_f_help'] = 


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['bbcode_help']['hide'] = 'Hide code: [hide]code[/hide] or [hide=click text]code[/hide] (alt+%s)';


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
$faq[] = array('Hiding parts of a post', "The HIDE BBCode hides parts of your post so that the readers have to click a link to view it. Use the Hide BBCode when you want to hide big images from taking up the whole screen, or when you want to hide information about for example the ending of a book, so that your readers have to confirm they want to see the hidden information.<br /><br /><b>[hide=Clickable text]</b>Hidden text<b>[/hide]</b><br /><br />will generate the following:<br /><br />\n<script language=\"javascript1.2\" type=\"text/javascript\">\n<!--\n   hideBBCode.open('Clickable text');\n//-->\n</script>\nHidden text\n<script language=\"javascript1.2\" type=\"text/javascript\">\n<!--\n   hideBBCode.close();\n//-->\n</script>\n<br />"); 

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
<!-- BEGIN hide_open --> 
<script language="javascript1.2" type="text/javascript"> 
<!-- 
   hideBBCode.open('{L_HIDE}'); 
//--> 
</script> 
<!-- END hide_open --> 
<!-- BEGIN hide_owntext_open --> 
<script language="javascript1.2" type="text/javascript"> 
<!-- 
   hideBBCode.open('{L_HIDE}'); 
//--> 
</script> 
<!-- END hide_owntext_open --> 
<!-- BEGIN hide_close --> 
<script language="javascript1.2" type="text/javascript"> 
<!-- 
   hideBBCode.close(); 
//--> 
</script> 
<!-- END hide_close --> 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/overall_header.tpl 


# 
#-----[ FIND ]------------------------------------------ 
# 
</head> 


# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
<script language="javascript1.2" type="text/javascript" src="templates/hidebbcode.js"></script>

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/simple_header.tpl 


# 
#-----[ FIND ]------------------------------------------ 
# 
</head> 


# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
<script language="javascript1.2" type="text/javascript" src="templates/hidebbcode.js"></script>

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
,'[hide]','[/hide]' 


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM