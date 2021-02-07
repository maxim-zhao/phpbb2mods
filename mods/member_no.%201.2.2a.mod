############################################################## 
## MOD Title: Member Number in Profile 
## MOD Author: rc69 < admin@deceptive-logic.com > (Craig Hecock) http://deceptive-logic.com 
## MOD Description: This mod, allows you to view your member number
##		    on your profile page.
## MOD Version: 1.2.2
## 
## Installation Level: Easy
## Installation Time:  5 Minutes
## Files To Edit:      3
##      includes/usercp_viewprofile.php
##	templates/subSilver/profile_view_body.tpl
##	language/lang_english/lang_main.php
##
## Included Files:     0
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
##
## 1. Mod Errors
## --------
## If you find any errors with this mod please feel free to
## contact me at: admin@deceptive-logic.com with the
## subject of "Mod: Member number" or else I'll just delete
## the email.
##
## 2. Copyright
## --------
## This MOD is not to be listed, downloaded or posted at
## -any- site except Official phpBB Web Sites.
##
############################################################## 
## MOD History: 
## 
##   2004-10-07 - Version 1.0.0
##        - initial release
##
##   2004-10-08 - Version 1.0.1
##        - minor fixes in the code
##
##   2004-10-09 - Version 1.2.0
##        - Fixed a file type error
##	  - Fixed a language error
##	  - Upgraded the mod for better compatability
##
##   2004-11-09 - Version 1.2.1
##        - Fixed number of files
##
##   2005-06-15 - Version 1.2.2
##        - Updated contact info
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ OPEN ]------------------------------------------------ 
# 
includes/usercp_viewprofile.php

# 
#-----[ FIND ]------------------------------------------------ 
# 
'INTERESTS' => ( $profiledata['user_interests'] ) ? $profiledata['user_interests'] : '&nbsp;',

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
# note: if you want to start the post count at 2 (the normal default) remove
# the -1's in the following code
#
'POSTER_UIN' => ( $profiledata['user_id']-1 ) ? $profiledata['user_id']-1 : '&nbsp;',

# 
#-----[ FIND ]------------------------------------------ 
#
	'L_JOINED' => $lang['Joined'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	'L_MEMBER_NO' => $lang['Member_No'],

# 
#-----[ OPEN ]------------------------------------------------ 
# 
# Don't forget to do this on all of your templates
#
templates/subSilver/profile_view_body.tpl

# 
#-----[ FIND ]------------------------------------------------ 
# 
<b><span class="gen">{JOINED}</span></b></td>
		</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		<!-- member number in profile mod: by rc69 -->
		<tr>
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_MEMBER_NO}:&nbsp;</span></td>
		  <td valign="top" align="left" nowrap="nowrap"><b><span class="gen">{POSTER_UIN}</span></b></td>
		</tr>
		<!-- end member number mod -->

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Joined'] = 'Joined';

# 
#-----[ AFTER, ADD ]------------------------------------- 
# 
$lang['Member_No'] = 'Member No.';

# 
#-----[ SAVE/CLOSE ALL FILES ]-------------------------------- 
# 
# EoM