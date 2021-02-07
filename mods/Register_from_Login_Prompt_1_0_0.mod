############################################################## 
## MOD Title: Register from Login Prompt
## MOD Author: Synapse_Aust < synapse@uq.net.au > (Jason) http://www.number.com.au/forum
## MOD Description: This MOD adds a New User Registration link to the Login page.
## MOD Version: 1.0.0
## 
## Installation Level:  Easy
## Installation Time:   ~1 Minute
## Files To Edit:       language/lang_english/lang_main.php
##		        login.php
## 		        templates/subSilver/login_body.tpl
## Included Files:      N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## 
## This MOD was created to help reduce possible confusion for first
## time forum visitors who are wishing to register.  A simple, yet
## obvious text link called "New User Registration" is added beneath
## the Username and Password prompts on the Login page.
## 
## This avoids frustration by people thinking that the Login page
## itself was actually a part of the registration process.  This can
## be especially helpful if your forum has permission restrictions
## which automatically redirect Guest users to Login.
## 
## I hope you find this MOD useful!
## 
############################################################## 
## MOD History: 
## 
##    2005-01-12 - Version 1.0.0 
##         - Initial Release :)
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

#
#-----[ OPEN ]---------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]----------------------------------------
#
$lang['Forgotten_password'] = 'I forgot my password';

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['New_user_registration'] = 'New User Registration';

#
#-----[ OPEN ]---------------------------------------------
#
login.php

#
#-----[ FIND ]----------------------------------------
#
			'L_SEND_PASSWORD' => $lang['Forgotten_password'],

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
			'L_NEW_REGISTER' => $lang['New_user_registration'],

#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/login_body.tpl

#
#-----[ FIND ]----------------------------------------
#
		  <tr align="center"> 
			<td colspan="2"><span class="gensmall"><a href="{U_SEND_PASSWORD}" class="gensmall">{L_SEND_PASSWORD}</a></span></td>
		  </tr>

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
		  <tr align="center"> 
			<td colspan="2"><span class="gensmall"><a href="{U_REGISTER}" class="gensmall">{L_NEW_REGISTER}</a></span></td>
		  </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM