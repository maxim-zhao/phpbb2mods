##############################################################
## MOD Title: Usernames Begin With Capital Letter
## MOD Author: battye < cricketmx@hotmail.com > (N/A) http://www.online-scrabble.com
## MOD Description: This MOD makes all usernames begin with a capital letter.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: usercp_register.php
## Included Files: (N/A)
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Cousin of the Topic Titles Begin With Capital Letter MOD.
## For all newly registered members, their username will begin with a capital letter, making a cleaner looking forum!
##############################################################
## MOD History:
##
##   2005-11-17 - Version 1.0.0
##      - Someone requested it.. so why not.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "',

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$username

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
ucfirst($username)

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM