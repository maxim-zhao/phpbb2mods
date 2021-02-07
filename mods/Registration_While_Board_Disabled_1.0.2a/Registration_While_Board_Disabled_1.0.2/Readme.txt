##############################################################
## MOD Title: Registration While Board Disabled
## MOD Author: iotc247 < iotc247@gmail.com > (Alex Heck) N/A
## MOD Description: Allows registration while
##                  board is diabled.
## MOD Version: 1.0.2
##
## Installation Level: (Easy)
## Installation Time: 3 Minutes
## Files To Edit: profile.php
##                common.php
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
##############################################################
## MOD History:
##
##   2005-08-26 - Version 1.0.0
##      - Initial Release
##   2005-08-29 - Version 1.0.1
##      - Fixed up readme
##   2005-09-03 - Version 1.0.2
##      - Fixed missing $mode variable
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
common.php

#
#-----[ FIND ]------------------------------------------
#
//
// Show 'Board is disabled' message if needed.
//

#
#----[ AFTER, ADD ]-----------------------------------
#
// Registration While Board Disabled
// Here we add 
// && !defined("IN_REG")
#
#-----[ FIND ]------------------------------------------
#
if( $board_config['board_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN")

#
#-----[ IN-LINE FIND ]------------------------------------------
#
 !defined("IN_LOGIN")

#
#----[ IN-LINE AFTER, ADD ]-------------------------------------------------
#
 && !defined("IN_REG")

#
#----[ OPEN ]--------------------------------------------
#
profile.php

#
#----[ FIND ]--------------------------------------------
#
define('IN_PHPBB', true);
#
#----[ BEFORE, ADD ]--------------------------------------
#
// Start - Registration While Board Disabled

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
	if ( $mode == 'register' )
	{
		define('IN_REG', true);
	}	
}
// End - Registration While Board Disabled

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
