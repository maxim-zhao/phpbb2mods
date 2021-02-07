################################################################# 
## MOD Title: Hide BBcode MOD 
## MOD Author: EGIS < post@mj2k.com > (Mathias Jørgensen) http://www.mj2k.com 
## MOD Description: Upgrades Hide BBcode MOD from version 1.2.6 to 1.3.0
## 
## MOD Version: 1.3.0 
## 
## Installation Level: Easy 
## Installation Time: 1 Minutes 
## Files To Edit: templates/hidebbcode.js
## Included Files: (n/a) 
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
##      - First Beta 
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
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php


# 
#-----[ FIND ]------------------------------------------ 
# 
   $text = preg_replace("/\[hide:$uid=([a-zA-Z0-9&\-_.æøåÆØÅ ?!\\\"]+?)\]/si", $bbcode_tpl['hide_owntext_open'], $text); 


# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
   $text = preg_replace("/\[hide:$uid=([^\'\]\n\\\]+)\]/si", $bbcode_tpl['hide_owntext_open'], $text); 


# 
#-----[ FIND ]------------------------------------------ 
# 
   $text = bbencode_first_pass_pda($text, $uid, '/\[hide=([a-zA-Z0-9&\-_.æøåÆØÅ ?!\\\"]+?)\]/is', '[/hide]', '', false, '', "[hide:$uid=\\1]"); 


# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
   $text = bbencode_first_pass_pda($text, $uid, '/\[hide=([^\'\]\n\\\]+)\]/is', '[/hide]', '', false, '', "[hide:$uid=\\1]"); 


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM