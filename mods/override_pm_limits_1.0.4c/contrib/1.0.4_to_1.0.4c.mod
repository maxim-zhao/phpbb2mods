##############################################################
## MOD Title: Override PM Limits updater 
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Adds ActionMod styling for iCGstation 
## MOD Version: 1.0.1)
##
## Installation Level: Easy
## Installation Time: ~1 Minute
## Files To Edit: 1
##		privmsg.php
## Included Files: 0
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
##		- Updates Override PM Limits from 1.0.4 to 1.0.4b 
##		- Ensure that you have Override PM Limits 1.0.4
##		  installed first!
##
##############################################################
## MOD History:
##
##	 2007-01-10
##		Version 1.0.1
##		- Fixed some typos, added another change
##
##		Version 1.0.0
##      - initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#
#-----[ OPEN ]------------------------------------------
#
privmsg.php

#
#-----[ FIND ]------------------------------------------
#
$inbox_limit_pct = ( $pm_total > 0 )

#
#-----[ REPLACE WITH ]----------------------------------
#
$inbox_limit_pct = ( $pm_total >= 0 )

#
#-----[ FIND ]------------------------------------------
#
                 WHERE ( ( privmsgs_to_userid = {$userdata['user_id']} AND privmsgs_type = PRIVMSGS_SAVED_IN_MAIL )
                     OR ( privmsgs_from_userid = {$userdata['user_id']} AND privmsgs_type = PRIVMSGS_SAVED_OUT_MAIL) )

#
#-----[ REPLACE WITH ]----------------------------------
#
                 WHERE ( ( privmsgs_to_userid = {$userdata['user_id']} AND privmsgs_type = " . PRIVMSGS_SAVED_IN_MAIL . ")
                     OR ( privmsgs_from_userid = {$userdata['user_id']} AND privmsgs_type = " . PRIVMSGS_SAVED_OUT_MAIL . ") )
