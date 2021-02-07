############################################################## 
## MOD Title: Password security
## MOD Author: Underhill <webmaster@underhill.de> (N/A) http://www.underhill.de/
## MOD Description: When a new passord is entered, the user will receive a JavaScript warning
## MOD Version: 1.1.1
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		includes/usercp_register.php
##		templates/subSilver/profile_add_body.tpl
##		language/lang_english/lang_main.php
##		language/lang_english/lang_faq.php
## Included Files: N/A
## Demo: N/A
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
## 
## This modification was built for use with the phpBB template "subSilver"
##
## Tip: How to clear the warning after entering the new password?
## Tips-Download: http://www.underhill.de/downloads/phpbb2mods/passwordsecuritytips.txt
##
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/passwordsecurity.png
## Download: http://www.underhill.de/downloads/phpbb2mods/passwordsecurity.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.1.1 
##		- Successfully tested with phpBB 2.0.20
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2005-12-31 - Version 1.1.0 
##		- Successfully tested with phpBB 2.0.19
##		- Added check for username (badboy4ever)
##		- Added check for emailadress
##		- Fixed some little problems with spelling and usability
## 
##   2005-12-20 - Version 1.0.2
##		- MOD Syntax changes for the phpBB MOD Database
## 
##   2005-12-15 - Version 1.0.1
##		- MOD Syntax changes for the phpBB MOD Database
## 
##   2005-12-13 - Version 1.0.0
##		- Final-Version
## 
##   2005-12-11 - Version 0.0.1c
##		- BETA-Version
## 
##   2005-11-07 - Version 0.0.1b
##		- BETA-Version
## 
##   2005-11-06 - Version 0.0.1a 
##		- ALPHA-Version
##		- Built and successfully tested with phpBB 2.0.18
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------------------------------
#

		'L_PASSWORD_CONFIRM_IF_CHANGED' => ( $mode == 'editprofile' ) ? $lang['password_confirm_if_changed'] : '',

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		'L_PASSWORD_SECURITY_LEVEL1' => $lang['password_security_level1'],
		'L_PASSWORD_SECURITY_LEVEL2' => $lang['password_security_level2'],
		'L_PASSWORD_SECURITY_LEVEL3' => $lang['password_security_level3'],
		'L_PASSWORD_SECURITY_LEVEL4' => $lang['password_security_level4'],
		'L_PASSWORD_SECURITY_LEVEL5' => $lang['password_security_level5'],
		'L_PASSWORD_SECURITY_EXPLAIN' => $lang['password_security_explain'],

#
#-----[ OPEN ]------------------------------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------------------------------
#

	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="new_password" size="25" maxlength="32" value="{NEW_PASSWORD}" />

#
#-----[ REPLACE WITH ]----------------------------------------------------------
#

	  <td class="row2" nowrap="nowrap"> 
		<script language="JavaScript" type="text/javascript">
		<!--
		// Password security
		function check_pw(pw_to_check) 
		{
			var counter_to_check = 0;
			var minlength_to_check = 6;
		
			if (pw_to_check.length >= minlength_to_check)
			{
				counter_to_check = counter_to_check + 1;
			}
			if (pw_to_check.match(/[A-Z\Ä\Ö\Ü]/))
			{
				counter_to_check = counter_to_check + 2;
			}
			if (pw_to_check.match(/[a-z\ä\ö\ü\ß]/))
			{
				counter_to_check = counter_to_check + 1;
			}
			if (pw_to_check.match(/[0-9]/))
			{
				counter_to_check = counter_to_check + 2;
			}
            if (pw_to_check.match(/[\.\,\?\!\%\*\_\#\:\;\~\\&\$\§\€\@\/\=\+\-\(\)\[\]\|\<\>]/)) 
            { 
               counter_to_check = counter_to_check + 2; 
            } 
			if (pw_to_check == document.getElementsByName('username').username.value)
			{
				counter_to_check = 0;
			}
			if (pw_to_check == document.getElementsByName('email').email.value)
			{
				counter_to_check = 0;
			}

			if (counter_to_check <= 2)
			{
				document.getElementsByName('holder_pw')[0].style.backgroundColor = 'red';
				document.getElementsByName('holder_pw')[0].style.color = 'black';
				document.getElementsByName('holder_pw')[0].style.border = '1px solid black';
				document.getElementsByName('holder_pw')[0].value = '{L_PASSWORD_SECURITY_LEVEL1}';
			}
			else if (counter_to_check <= 4)
			{
				document.getElementsByName('holder_pw')[0].style.backgroundColor = 'yellow';
				document.getElementsByName('holder_pw')[0].style.color = 'black';
				document.getElementsByName('holder_pw')[0].style.border = '1px solid black';
				document.getElementsByName('holder_pw')[0].value = '{L_PASSWORD_SECURITY_LEVEL2}';
			}
			else if (counter_to_check <= 5)
			{
				document.getElementsByName('holder_pw')[0].style.backgroundColor = 'green';
				document.getElementsByName('holder_pw')[0].style.color = 'white';
				document.getElementsByName('holder_pw')[0].style.border = '1px solid black';
				document.getElementsByName('holder_pw')[0].value = '{L_PASSWORD_SECURITY_LEVEL3}';
			}
			else if (counter_to_check <= 7)
			{
				document.getElementsByName('holder_pw')[0].style.backgroundColor = 'green';
				document.getElementsByName('holder_pw')[0].style.color = 'white';
				document.getElementsByName('holder_pw')[0].style.border = '1px solid black';
				document.getElementsByName('holder_pw')[0].value = '{L_PASSWORD_SECURITY_LEVEL4}';
			}
			else if (counter_to_check == 8)
			{
				document.getElementsByName('holder_pw')[0].style.backgroundColor = 'green';
				document.getElementsByName('holder_pw')[0].style.color = 'white';
				document.getElementsByName('holder_pw')[0].style.border = '1px solid black';
				document.getElementsByName('holder_pw')[0].value = '{L_PASSWORD_SECURITY_LEVEL5}';
			}
		}
		//-->
		</script>
		<input onkeyup="check_pw(this.value);" onfocus="check_pw(this.value);" type="password" class="post" style="width: 200px" name="new_password" size="25" maxlength="32" value="{NEW_PASSWORD}" />
		<span class="gensmall"><a href="{U_FAQ}#39" tabindex="98" target="_phpbbfaq">{L_PASSWORD_SECURITY_EXPLAIN}</a></span> <input tabindex="99" title="" readonly="readonly" type="text" class="post" style="width : 150px; text-align : center; border : 1px solid #DEE3E7; background-color : #DEE3E7;" name="holder_pw" size="25" value="" />

#
#-----[ OPEN ]------------------------------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------------------------
#

$lang['password_confirm_if_changed'] =

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

$lang['password_security_level1'] = 'Unsafe';
$lang['password_security_level2'] = 'Not recommendable';
$lang['password_security_level3'] = 'Relatively safe';
$lang['password_security_level4'] = 'Safe';
$lang['password_security_level5'] = 'Very safe';
$lang['password_security_explain'] = 'Password security:';

#
#-----[ OPEN ]------------------------------------------------------------------
#

language/lang_english/lang_faq.php

#
#-----[ FIND ]------------------------------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

// Password security
$faq[] = array("--", "Password security"); 
$faq[] = array("What is password security?", "This function offers you a recommendation for selecting your password. It's only a recommendation. You are free to decide if you use it or not."); 
$faq[] = array("How to secure a password?", "Tips for selecting a secure password:<br />- The password must be at least 6 characters in length and can be a maximum of 32 characters in length (a character is a letter, number, mark or symbol).<br />- The password should be at least 4 characters long and should contain at least 2 other characters such as numbers or symbols.<br />- Special foreign language characters such as the german umlaut and spaces (blanks) are not recommended.<br />- Use neither your user-name or your real name.<br />- Do not use standard keyboard rows such as the \"qwerty\" row.<br />- The password should not contain popular or common phrases such as those found in books, poems. Also avoid using popular media slogans form radio and tv.<br />- Use a combination of upper and lowercased letters.<br />- Choose a password that you don't have to write down in order to remember it."); 
	
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM
