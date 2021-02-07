##############################################################
## MOD Title: 1.0.3 Upgrade to 1.0.5
## MOD Author: tehbmwman < tehbmwman@gmail.com > (N/A) N/A
## MOD Description: Fixes a small bug in 1.0.3, which makes it the equivalent
##					of 1.0.5
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~1 Minutes
## Files To Edit: viewtopic.php
##
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
## Author Notes: Just a fix.
##
##############################################################
## MOD History:
##
##   2006-01-30 - Version 1.0.0
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]---------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]---------------------------------------------
#
case 0:
            $topic_mod .=
#
#-----[ IN-LINE FIND ]-------------------------------------
#
$lang['Mark_Sticky']
#
#-----[ IN-LINE REPLACE WITH ]-----------------------------
#
$lang['Mark_sticky']
#
#-----[ FIND ]---------------------------------------------
#
$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=sticky&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_sticky'] . '" alt="' . $lang['Mark_Sticky'] . '" title="' . $lang['Mark_Sticky'] . '" border="0" /></a>&nbsp;'; 
break;
#
#-----[ IN-LINE FIND ]-------------------------------------
#
$lang['Mark_Sticky']
#
#-----[ IN-LINE REPLACE WITH ]-----------------------------
#
$lang['Mark_sticky']
#
#-----[ SAVE/CLOSE ALL FILES ]-----------------------------
#
# EoM