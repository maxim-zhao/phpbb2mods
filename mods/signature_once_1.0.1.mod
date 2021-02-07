##############################################################
## MOD Title: Signature displayed once per page
## MOD Author: Agnostik < gmchad@redscape.com > (Chad Schroeder) http://www.redscape.com
## MOD Description: To reduce clutter, this MOD will display a poster's signature only once per topic page.
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: ~ 1 minute
## Files To Edit: 
##			    viewtopic.php
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
## Author Notes:
## Thanks to LK for providing the UBB blueprint
##############################################################
## MOD History:
##
##   2006-05-02 - Version 1.1
##      - MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.20
##   2002-12-06 - Version 1.0
##		- BETA-Version
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
   $user_sig = ( $postrow[$i]['enable_sig']

#
#-----[ IN-LINE FIND ]------------------------------------------
#
&& $board_config['allow_sig']

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 && !$signature[$poster_id]

#
#-----[ FIND ]------------------------------------------
#

$user_sig = '<br />_________________<br />' . str_replace("\n", "\n<br />\n", $user_sig);

#
#-----[ AFTER, ADD ]------------------------------------------
#

		$signature[$poster_id] = 1; 

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM