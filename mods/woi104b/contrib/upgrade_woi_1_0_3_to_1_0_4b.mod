############################################################## 
## MOD Title: Welcome on Index Upgrade from 1.0.3 to 1.0.4
## MOD Author: cherokee red < mods@cherokeered.co.uk > (Kenny Cameron) http://www.cherokeered.co.uk
## MOD Description: Upgrades the "Welcome on Index" Mod to version 1.0.4
## MOD Version: 1.0.3 to 1.0.4b
## 
## Installation Level: Easy 
## Installation Time: ~3 Minutes
## Files To Edit: templates/subSilver/index_body.tpl
## 		  index.php
## 		  language/lang_english/lang_main.php
## Included Files: n/a 
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
## 
############################################################## 
## MOD History: 
## 
##   2004-10-03 - Version 1.0.0 
##      - mod created
## 
##   2004-10-03 - Version 1.0.1
##      - mod updated: missing semi-colon's added in
##
##   2004-10-03 - Version 1.0.2
##      - mod updated: link output in address bar fixed. was showing 'profile&2' instead of 'profile&u=2'
##
##   2004-10-03 - Version 1.0.3
##      - mod updated: speprate messages now show for guests and registered users Also typo in 'files to edit' list fixed (~Romil)
##
##   2006-04-29 - Version 1.0.4
##      - mod updated: small bug in the guest register link
##	- changed the guest message text/layout
##	- updated Dutch language support (TKF2/cherokee red)
##
##   2006-05-05 - Version 1.0.4b
##      - mod updated: minor text/template edits
##	- fixed extra '&' in register link (1.0.4a)
##	- fixed register link to comply with MOD standards ( POST_USERS_URL )
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------ 
#
index.php
# 
#-----[ FIND ]------------------------------------------ 
# 
if ($userdata['user_id'] != '-1')
{
    $welcome_reg = '<a href="' . append_sid("profile.$phpEx?mode=editprofile&amp;u=" . $userdata['user_id']) . '">' . $userdata['username'] . '</a>';
}
else
{
    $welcome_guest = '<a href="' . append_sid("profile.$phpEx?mode=register&amp;u=") . '">' . $lang['Guest'] . '</a>';
}

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
// Welcome on Index - cherokee red
if ($userdata['user_id'] != '-1')
{
    $welcome_reg = '<a href="' . append_sid("profile.$phpEx?mode=editprofile&amp;" . POST_USERS_URL . "=" . $userdata['user_id']) . '">' . $userdata['username'] . '</a>';
}
else
{
    $welcome_guest = '<a href="' . append_sid("profile.$phpEx?mode=register") . '">' . $lang['Welcome_Register'] . '</a>';
}

#
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Welcome2'] = "<b>Welcome </b>";
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
$lang['Welcome2'] = "<b>Welcome Guest, have you thought about </b>";
$lang['Welcome_Register'] = "<b>Registering?</b>";

#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM