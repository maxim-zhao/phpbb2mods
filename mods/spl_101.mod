##############################################################
## MOD Title: See profile link
## MOD Author: DaMnNaTiOn < fy [at] frankyang [dot] net > (Frank Yang) http://www.frankyang.net
## MOD Description:  This adds a see your profile text after you edited your profile
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: language/lang_english/lang_main.php
##                includes/usercp_register.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: Nothing :)
##############################################################
## MOD History:
##
##   2004-06-06 - Version 1.0.1
##      - Little improvements
##
##   2004-06-05 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Profile_updated'] =

#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['Profile_see'] = 'Click %sHere%s to see your profile';

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#

$message = $lang['Profile_updated']

#
#-----[ IN-LINE FIND ]------------------------------------------
#

'<br />

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

<br />' . sprintf($lang['Profile_see'],  '<a href="' . append_sid('profile.'.$phpEx.'?mode=viewprofile&u='.$userdata['user_id']) . '">', '</a>') . '

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM