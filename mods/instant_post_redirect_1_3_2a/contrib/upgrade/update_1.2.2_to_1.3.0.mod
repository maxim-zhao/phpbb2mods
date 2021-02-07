##############################################################
## MOD Title: Instant Post Redirect 1.2.2 to 1.3.0
## MOD Author: eviL3 < evil@phpbbmodders.org > (Igor Wiedler) http://phpbbmodders.org
## MOD Description: Removes the redirect after posting a message, Private message or voting.
## MOD Version: 1.3.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: privmsg.php
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
privmsg.php

#
#-----[ FIND ]------------------------------------------
#
				$emailer->reset();

#
#-----[ FIND ]------------------------------------------
#
		$template->assign_vars(array(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$template

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
/*

#
#-----[ FIND ]------------------------------------------
#
		message_die(GENERAL_MESSAGE, $msg);

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$msg);

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
*/

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// MOD: Instant Post Redirect
		redirect(append_sid("privmsg.$phpEx?folder=inbox"));

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
