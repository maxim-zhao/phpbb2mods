############################################################## 
## MOD Title: Spam warning
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Warns user on registration or changes to profiles not to show the email adress using JavaScript
## MOD Version: 1.3.1
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		includes/usercp_register.php
##		templates/subSilver/profile_add_body.tpl
##		language/lang_english/lang_main.php
## Included Files: N/A
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
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/spamwarning.png
## Download: http://www.underhill.de/downloads/phpbb2mods/spamwarning.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.3.1 
##		- Successfully tested with phpBB 2.0.20
## 
##   2006-03-24 - Version 1.3.0 
##		- Successfully tested with EasyMOD beta (0.3.0)
##		- Fixed bug with Opera (Zenandrar)
##		- Fixed display problem with Internet Explorer
## 
##   2005-12-31 - Version 1.2.0 
##		- Successfully tested with phpBB 2.0.19
##		- Changed alert to confirm (badboy4ever)
## 
##   2005-12-11 - Version 1.1.2 
##		- MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.18
## 
##   2005-10-03 - Version 1.1.1 
##		- MOD Syntax changes for the phpBB MOD Database
##
##   2005-10-01 - Version 1.1.0 
##		- Format changed to the phpBB MOD Template
##		- Successfully tested with phpBB 2.0.17
## 
##   2004-03-11 - Version 1.0.0 
##		- Built and successfully tested with phpBB 2.0.8
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

		'L_PUBLIC_VIEW_EMAIL' => $lang['Public_view_email'],

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		'L_PUBLIC_VIEW_EMAIL_REQUEST' => $lang['Public_view_email_request'],

#
#-----[ OPEN ]------------------------------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------------------------------
#

		<input type="radio" name="viewemail" value="1" {VIEW_EMAIL_YES} />

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

		<script type="text/javascript" language="JavaScript">
		<!--
		// Spam warning
		function spamwarn_question()
		{
			if (confirm('{L_PUBLIC_VIEW_EMAIL_REQUEST}'))
			{
				document.getElementsByName('viewemail')[0].checked = true;
				return true;
			}
			else
			{
				document.getElementsByName('viewemail')[1].checked = true;
				return false;
			}
		}
		//-->
		</script>

#
#-----[ IN-LINE FIND ]----------------------------------------------------------
#

value="1"

#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------------------
#

 onclick="return spamwarn_question();"

#
#-----[ OPEN ]------------------------------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------------------------
#

$lang['Admin_reauthenticate'] =

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

$lang['Public_view_email_request'] = 'Are you sure you want to show your e-mail address?\n\nYou will have no protection against SPAM ...';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
