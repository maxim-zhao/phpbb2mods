############################################################## 
## MOD Title: Message too short
## MOD Author: Xpert < xpert@phpbbguru.net > (N/A) http://www.phpbbguru.net 
## MOD Description: 	Allows you to require a minimum 
##                 	amount of characters in a post & pm. 
## MOD Version: 	1.1.0 [phpBB 2.0.x]
## 
## Installation Level: 	Easy 
## Installation Time: 	5 Minutes 
## Files To Edit (4): 	posting.php
##			privmsg.php 
##			language/lang_english/lang_main.php
##			templates/subSilver/posting_body.tpl
## Included Files: (n/a)
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##
##	This mod is a simple way to avoid your forum users 
#	from comments as "Yes", "Wow" and other flood actions.	
## 
############################################################## 
## MOD History: 
##
##   2004-07-03 - Version 1.1.0 
##      - Undefined 'L_MESSAGE_TOO_SHORT' when posting pm fixed.
##	  Thanks to R@ < meos@mail.ru > for report.
## 
##   2004-05-23 - Version 1.0.0 
##      - Initial Release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_MESSAGE_TOO_SHORT' => $lang['Message_too_short'],

# 
#-----[ OPEN ]------------------------------------------ 
# 
privmsg.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_MESSAGE_TOO_SHORT' => $lang['Message_too_short'],

#  
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
# 
//
// That's all, Folks!

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// Message too short
$lang['Message_too_short'] = 'Message too short';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	if (document.post.message.value.length < 2) {
		formErrors = "{L_EMPTY_MESSAGE}";
	}
  
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	// Here you can change 5 to the minimum amount
	// of characters in a post you want.
	if (document.post.message.value.length < 5) {
		formErrors = "{L_MESSAGE_TOO_SHORT}";
	}
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 