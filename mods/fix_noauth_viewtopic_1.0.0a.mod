##############################################################
## MOD Title: Fix hidden Topics
## MOD Author: eviL3 < evil@phpbbmodders.com > (Igor Wiedler) http://phpbbmodders.com/
## MOD Description: Users won't be redirected to the login when
##                  viewing a hidden topic (no auth permissions)
##
## MOD Version:      1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minutes
## Files To Edit:
##         viewtopic.php
##
## Included Files:   (n/a)
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
## Nothing to say yet.
##
##############################################################
## MOD History:
##
##   2006-07-04 - Version 0.1.0
##      - First release
##
##   2006-07-04 - Version 1.0.0
##      - Enhanced...
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------------
#
if ( !$userdata['session_logged_in'] )

#
#-----[ IN-LINE FIND ]------------------------------------------------
#
if ( !$userdata['session_logged_in'] )

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------------
#
/*

#
#-----[ FIND ]------------------------------------------------
#
}

#
#-----[ IN-LINE FIND ]------------------------------------------------
#
}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
*/

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
