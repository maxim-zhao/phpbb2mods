################################################################# 
## MOD Title: MouseOver Spoiler BBcode MOD  
## MOD Author: Gigs < phpmod@scrynet.com > (Scott Dietrich) http://www.scrynet.com 
## MOD Description: Adds a spoiler BBcode, which "reveals" the hidden text OnMouseover. Uses tables for readability. 
## 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## Files To Edit: includes/bbcode.php, 
##                templates/subSilver/bbcode.tpl, 
##                templates/subSilver/posting_body.tpl 
##                language/lang_english/lang_main.php 
##                language/lang_english/lang_bbcode.php 
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################  
## 
##  Author Notes: Tested with phpBB v2.0.11. Works with IE, Opera and Mozilla. 
##       + Requires the latest version of Multi BBCode MOD (1.4.0c) and BBcode Buttons Organizer (1.4.0) 
##       + This installed flawlessly with Easy MOD 0.1.13 on a subSilver template 
## 
############################################################## 
## 
## MOD History: 
##   2005-01-18 - Version 1.0.0 By Gigs 
##   - Code compliant with latest version of Multi BBCode MOD (1.4.0c) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
# IMPORTANT: you MUST first have already installed the Multi BBCode MOD v1.4.0c 
# 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 

# 
#-----[ FIND ]--------------------------------- 
#  
# NOTE: the actual lines may be longer if you have installed other BBCode MODs 
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
,'55' 

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
// [b] and [/b] for bolding text    
$text = str_replace("[b:$uid]", $bbcode_tpl['b_open'], $text); 
$text = str_replace("[/b:$uid]", $bbcode_tpl['b_close'], $text); 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#  
// [spoiler] and [/spoiler] for spoiler-text    
$text = str_replace("[spoiler:$uid]", $bbcode_tpl['spoiler_open'], $text); 
$text = str_replace("[/spoiler:$uid]", $bbcode_tpl['spoiler_close'], $text);  

# 
#-----[ FIND ]------------------------------------------ 
# 
// [b] and [/b] for bolding text. 
$text = preg_replace("#\[b\](.*?)\[/b\]#si", "[b:$uid]\\1[/b:$uid]", $text); 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#  
// [spoiler] and [/spoiler] for setting spoiler-text 
$text = preg_replace("#\[spoiler\](.*?)\[/spoiler\]#si", "[spoiler:$uid]\\1[/spoiler:$uid]", $text);  

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/bbcode.tpl 

# 
#-----[ FIND ]------------------------------------------ 
# 
<!-- BEGIN b_open --><span style="font-weight: bold"><!-- END b_open --> 
<!-- BEGIN b_close --></span><!-- END b_close --> 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
<!-- BEGIN spoiler_open --><b>Spoiler:</b> <table><tr><td bgcolor=black style="padding: 10px; background-color: black; font-color: black; font-face=arial, sans-serif; font-size: .8em;" onMouseOver='javascript:this.style.color="white";' onMouseOut='javascript:this.style.color="black";'><!-- END spoiler_open --> 
<!-- BEGIN spoiler_close --></td></tr></table><!-- END spoiler_close --> 

# 
#-----[ OPEN ]------------------------------------------ 
# You need to do this for all of your installed template styles 
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
,'[spoiler]','[/spoiler]' 

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
$lang['Spoiler'] = 'Mouseover to reveal text'; 

# 
#-----[ FIND ]------------------------------------------ 
# NOTE: Full line in English is: 
# $lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]'; 
# 
$lang['bbcode_f_help'] = 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['bbcode_help']['spoiler'] = 'Spoiler BBcode: [spoiler]this is the spoiler text[/spoiler] (alt+%s)'; 

# 
#-----[ OPEN ]------------------------------------------ 
# NOTE: You need to do this for all installed languages 
# 
language/lang_english/lang_bbcode.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
$faq[] = array("--","Text Formatting"); 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$faq[] = array("MouseOver Spoiler", "The [spoiler] [/spoiler] BBCode hides text in a black on black window until a user moves their mouse over the spoiler."); 

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM  