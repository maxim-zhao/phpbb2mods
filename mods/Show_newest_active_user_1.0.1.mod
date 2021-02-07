##############################################################
## MOD Title: Show newest active user
## MOD Author: Starwiz < starwiz@gmail.com > (Justin Lebar) N/A
## MOD Description: Sets phpBB so that the "Newest registered user"
## section on index.php shows the newest user who with an activated account.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: includes/functions.php
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
## Author Notes: This extremely simple mod changes the behavior 
## of the "newest registered user" listing on a board's index.
## Normally, the last user to submit a registration form is displayed
## as the newest registered user.  After applying this mod, however,
## the newest *active* registered user will be shown instead. 
##
## This is especially useful on boards in which the admin must activate
## every registration, because it prevents outlandish usernames that
## the admin wouldn't approve from appearing on the index page.
##
##############################################################
## MOD History:
##
## 2005-11-25 - Version 1.0.0
## - Initial release
##
## 2005-12-05 - Version 1.0.1
## - Updated author notes
## - Condensed find and replace statements
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#

WHERE user_id <> " . ANONYMOUS . "

#
#-----[ AFTER, ADD ]------------------------------------------
#

AND user_active = 1

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM