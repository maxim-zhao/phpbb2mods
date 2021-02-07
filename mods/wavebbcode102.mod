############################################################## 
## MOD Title: Wave BB Code 
## MOD Author: danb00 < danielbriant@london.com > (daniel) www.danb00.34sp.com 
## MOD Description: Makes text go wavey! 
## MOD Version: 1.0.2
## 
## Installation Level: (Easy) 
## Installation Time: 5 - 10 Minutes 
## Files To Edit: 
## bbcode.php 
## posting.php 
## lang_main.php 
## bbcode.tpl 
## posting_body.tpl 
## 
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## Only works in IE, but i dont use any other browser, so test it if you want, but all i know is it works in IE 5 and above
## 
############################################################## 
## MOD History: 
## 
##   2003-06-17- Version 1.0 
##      - 1.0 Added the code plus button 
##   2004-02-12- Version 1.0.1 
##      - 1.0.1 Rewrote it to make it compatable with easy bbcode 
##   2004-04-7- Version 1.0.2 
##      - 1.0.2 Rewrote it to make it mod db complient
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################  
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
      // [b] and [/b] for bolding text. 
   $text = str_replace("[b:$uid]", $bbcode_tpl['b_open'], $text); 
   $text = str_replace("[/b:$uid]", $bbcode_tpl['b_close'], $text);
# 
#-----[AFTER, ADD]------------------------------- 
# 

   // [wave] and [/wave] for waveing text. 
   $text = str_replace("[wave:$uid]", $bbcode_tpl['wave_open'], $text); 
   $text = str_replace("[/wave:$uid]", $bbcode_tpl['wave_close'], $text); 
# 
#-----[ FIND ]------------------------------------------ 
# 
   // [b] and [/b] for bolding text. 
   $text = preg_replace("#\[b\](.*?)\[/b\]#si", "[b:$uid]\\1[/b:$uid]", $text);
# 
#-----[AFTER, ADD]---------------------------- 
# 
   // [wave] and [/wave] for waveing text. 
   $text = preg_replace("#\[wave\](.*?)\[/wave\]#si", "[wave:$uid]\\1[/wave:$uid]", $text); 
# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php 
# 
#-----[ FIND ]--------------------------------- 
# 
$EMBB_keys = array('' 

# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
array('' 
# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'y' 
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
,'Wave' 
# 
#-----[FIND]--------------------------------- 
# 
'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
   "L_BBCODE_Y_HELP" => $lang['bbcode_y_help'], 
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/bbcode.tpl 
# 
#-----[FIND]--------------------------------- 
# 
<!-- BEGIN b_open --><span style="font-weight: bold"><!-- END b_open --> 
<!-- BEGIN b_close --></span><!-- END b_close -->
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
<!-- BEGIN wave_open --><span style="height: 20; filter:wave(add=1,direction=270,strength=12)"><!-- END wave_open --> 
<!-- BEGIN wave_close --></span><!-- END wave_close -->
# 
#-----[ OPEN ]------------------------------------------ 
# 
languages/lang_english/lang_main.php 
# 
#-----[FIND]--------------------------------- 
# 
$lang['bbcode_f_help']
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['bbcode_y_help'] = "wave text: [wave]text[/wave] (alt+y)"; 
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/posting_body.tpl 
# 
#-----[FIND]--------------------------------- 
# 
f_help = "{L_BBCODE_F_HELP}"; 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
y_help = "{L_BBCODE_Y_HELP}"; 
# 
#-----[ FIND ]--------------------------------- 
# 
# NOTE: the actual line contains all the bbcode tags, but it begins with the below text 
# 
bbtags = new Array( 
# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
'[url]','[/url]' 
# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'[wave]','[/wave]' 
# 
#-----[SAVE/CLOSE ALL FILES]------------------------------------------ 
# 
# EoM