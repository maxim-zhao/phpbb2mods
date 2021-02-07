############################################################## 
## MOD Title: Log out confirmation
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Confirms that the user wants to log out with JavaScript
## MOD Version: 1.0.6
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		includes/page_header.php 
##		templates/subSilver/overall_header.tpl
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
## Attention: The Alpha-Filter (lighter background) is not available for every browser
##
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/logoutconfirmation.png
## Download: http://www.underhill.de/downloads/phpbb2mods/logoutconfirmation.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.0.6 
##		- Successfully tested with phpBB 2.0.20
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2005-12-31 - Version 1.0.5 
##		- Successfully tested with phpBB 2.0.19
## 
##   2005-12-11 - Version 1.0.4 
##		- MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.18
## 
##   2005-10-06 - Version 1.0.3 
##		- Fixed an issue with the Alpha-Filter
##		- Fixed some spelling problems
## 
##   2005-10-03 - Version 1.0.2 
##		- Added Alpha-Filter (lighter background) for Firefox and compatible browsers
## 
##   2005-10-03 - Version 1.0.1 
##		- MOD syntax changes for the phpBB MOD database
## 
##   2005-10-01 - Version 1.0.0 
##		- Format changed to the phpBB MOD template
##		- Built and successfully tested with phpBB 2.0.17
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------------------------------
#

includes/page_header.php

#
#-----[ FIND ]------------------------------------------------------------------
#

	$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];

#
#-----[ IN-LINE FIND ]----------------------------------------------------------
#

$userdata['session_id']

#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------------------
#

 . '" onclick="return logout_question();'

#
#-----[ FIND ]------------------------------------------------------------------
#

	'L_LOGIN_LOGOUT' => $l_login_logout,

#
#-----[ AFTER, ADD ]-------------------------------------------------------------
#

	'L_LOGOUT_QUESTION' => $lang['Logout_Question'],

#
#-----[ OPEN ]------------------------------------------------------------------
#

templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------------------------------
#

</head>

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

<script type="text/javascript" language="JavaScript">
<!--
// Log out confirmation
function logout_question()
{
	body_self = document.getElementsByTagName('body');
	body_self[0].style.filter = 'Alpha(opacity="60")';
	body_self[0].style.MozOpacity = '0.6';
	body_self[0].style.opacity = '0.6';
	if (confirm('{L_LOGOUT_QUESTION}'))
	{
		body_self[0].style.filter = 'Alpha(opacity="100")';
		body_self[0].style.MozOpacity = '1';
		body_self[0].style.opacity = '1';
		return true;
	}
	else
	{
		body_self[0].style.filter = 'Alpha(opacity="100")';
		body_self[0].style.MozOpacity = '1';
		body_self[0].style.opacity = '1';
		return false;
	}
}
//-->
</script>

#
#-----[ OPEN ]------------------------------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------------------------
#

$lang['Logout'] =

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

$lang['Logout_Question'] = 'You are about to log out';

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM
