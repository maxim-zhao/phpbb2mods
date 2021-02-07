#################################################################
## MOD Title: Poster name linked to profile
## MOD Version: 1.0.0
## MOD Author: kkroo < princeomz2004@hotmail.com > ( Omar Ramadan ) http://phpbb-login.strangled.net
## MOD Author: Afterlife(69) < afterlife_69@hotmail.com > ( Dean Newman ) http://www.ugboards.com
## MOD Description: Links the user's name to their profile on viewtopic
##
## Installation Level: Easy
## Installation Time: 2 Minutes
##
## Files To Edit:	viewtopic.php
## Included Files:	N/A
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support

## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Note: Why not :P
##############################################################
## MOD History:
##
##	2005-12-19 - Version 1.0.0
##	-	Released
## 
#################################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
#################################################################

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
# Note: This is only a partial find
$template->assign_block_vars('postrow'

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	if($poster_id != ANONYMOUS)
	{
		$poster = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $postrow[$i]['user_id']) . '">' . $poster . '</a>';
	}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM