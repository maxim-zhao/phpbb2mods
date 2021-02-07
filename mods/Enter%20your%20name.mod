##############################################################
## MOD Title: Enter your name
## MOD Author: R@ < meos@mail.ru > (Kirill) http://osdev.ru
## MOD Description: Guests must enter their name, when posting
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: posting.php 
##        	  language/lang_english/lang_main.php
##	  	  templates/subSilver/posting_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## MOD History:
##
##   2004-06-07 - Version 1.0.0
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

'L_SUBJECT' => $lang['Subject'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#

'L_ENTER_YOUR_NAME' => $lang['Enter_your_name'],

#
#-----[ OPEN ]------------------------------------------ 
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Subject'] = 'Subject';

#
#-----[ BEFORE, ADD ]------------------------------------------
#

$lang['Enter_your_name'] = 'Enter your name';

#
#-----[ OPEN ]------------------------------------------ 
#

templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#

	if (formErrors) {
		alert(formErrors);
		return false;

#
#-----[ BEFORE, ADD ]------------------------------------------
#

	<!-- BEGIN switch_username_select -->
	if (document.post.username.value == '' && !(formErrors)) {
	formErrors = "{L_ENTER_YOUR_NAME}";
	}
	<!-- END switch_username_select -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM