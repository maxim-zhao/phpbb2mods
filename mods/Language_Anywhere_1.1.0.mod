############################################################## 
## MOD Title: Language Anywhere MOD
## MOD Author: Vokbain < vokbain@vokbain.net > (Chris Vokey) http://vokbain.net 
## MOD Description: Allows language specific images anywhere in any template.
## MOD Version: 1.1.0
## 
## Installation Level: (Easy) 
## Installation Time: 1 Minute 
## Files To Edit: page_header.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##
## Good for style designers who want to use multi-language images besides the normal ones.
## This mod replaces {S_LANG} in the templates with the language the user has selected.
## If the user is logged out, it uses the default language your board is set to.
## It works the same as the {LANG} tag in subSilver.cfg.
## Example: 
##		<img src="templates/subSilver/images/{S_LANG}/hello.jpg"> 
##	would become:
##		<img src="templates/subSilver/images/lang_english/hello.jpg">
##
############################################################## 
## MOD History: 
## 
##Ê Ê2004-05-10 - Version 1.1.0 
##Ê ÊÊ Ê- Using $board_config['default_lang'] instead of $userdata['user_lang']
## 
##Ê Ê2004-04-27 - Version 1.0.0 
##Ê ÊÊ Ê- First release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
# 

	'S_LOGIN_ACTION' => append_sid('login.'.$phpEx),

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// Start Language Anywhere Mod
	'S_LANG' => 'lang_'.$board_config['default_lang'],
// End Language Anywhere Mod

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
