##############################################################
## MOD Title: Instant Post Redirect 1.2.1 to 1.2.2
## MOD Author: eviL3 < evil@phpbbmodders.com > (Igor Wiedler) http://phpbbmodders.com/
## MOD Description: Removes the redirect after posting a message or voting.
## MOD Version: 1.2.2
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: posting.php
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
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 
#
#-----[ OPEN ]------------------------------------------
#
posting.php

#
#-----[ FIND ]------------------------------------------
#
		if ( $mode != 'editpost' )

#
#-----[ FIND ]------------------------------------------
#
			setcookie($board_config['cookie_name']

#
#-----[ FIND ]------------------------------------------
#
		}

#
#-----[ AFTER, ADD ]------------------------------------------
#
    // MOD: Instant Post Redirect
		elseif ( $mode == 'editpost' )
		{
		  redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id", true) . '#' . $post_id);
		}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
