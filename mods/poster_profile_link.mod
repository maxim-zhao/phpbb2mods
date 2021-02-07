##############################################################
## MOD Title: Poster Profile Link
## MOD Author: StijnH < stijn.herreman@telenet.be > (Stijn Herreman) N/A
## MOD Description: Makes the poster's name clickable and leads to his/her profile
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: viewtopic.php
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
## You can put this mod on your own site, as long as you do not edit the file
##############################################################
## MOD History:
##
##   2006-07-30 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
	$poster_id = $postrow[$i]['user_id'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");

#
#-----[ FIND ]------------------------------------------
#
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];

#
#-----[ REPLACE WITH ]------------------------------------------
#
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : '<a href="' . $temp_url . '">' . $postrow[$i]['username'] . '</a>';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM