############################################################## 
## MOD Title: VB Style Quoting 
## MOD Author: Budweiser < raymond@phpbb-nl.com > (Raymond Teunissen) http://www.phpbb-nl.com 
## MOD Description: Change the way of quoting (just like in vBulletin) 
## MOD Version: 1.0.1 
## 
## Installation Level: Easy 
## Installation Time: 2-3 Minutes 
## Files To Edit: 2
##			- /templates/subSilver/bbcode.tpl
##			- /language/lang_english/lang_main.php
##
## Included Files: 	(n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
## 
############################################################## 
## MOD History: 
## 
##   September 08th 2003 - v 1.0.0 
##      - Created main features. 
##
##   November 13th 2003 - v1.0.1
##	- Little Bugfix ;-)
##
##   November 26th 2003 - v1.0.2
##	- Again a bug removed.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/bbcode.tpl


# 
#-----[ FIND ]------------------------------------------ 
#

<!-- BEGIN quote_username_open --></span> 
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"> 
<tr> 
     <td><span class="genmed"><b>{USERNAME} {L_WROTE}:</b></span></td> 
   </tr> 
   <tr> 
     <td class="quote"><!-- END quote_username_open --> 
<!-- BEGIN quote_open --></span> 
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center"> 
<tr> 
     <td><span class="genmed"><b>{L_QUOTE}:</b></span></td> 
   </tr> 
   <tr> 
     <td class="quote"><!-- END quote_open --> 
<!-- BEGIN quote_close --></td> 
   </tr> 
</table> 
<span class="postbody"><!-- END quote_close -->

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#

<!-- BEGIN quote_username_open --> 
<blockquote> 
  <span class="gensmall">{L_QUOTE}:</span> 
  <hr> 
  {L_WROTE} <b>{USERNAME}:</b><br> 
<!-- END quote_username_open --> 
    <!-- BEGIN quote_open --> 
<blockquote> 
<span class="gensmall"> 
    {L_QUOTE}:</span> 
    <hr> 
    <!-- END quote_open --> 
    <!-- BEGIN quote_close --> 
<hr> 
</blockquote> 
      <!-- END quote_close -->

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
#

$lang['wrote'] = 'wrote'; // proceeds the username and is followed by the quoted text

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
wrote
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
Originally posted by
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 