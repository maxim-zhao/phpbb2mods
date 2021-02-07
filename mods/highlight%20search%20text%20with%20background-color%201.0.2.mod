##############################################################
## MOD Title: highlight search text with background-color
## MOD Author: Alexis Canver < N/A > (Alexis Canver) http://www.canver.net
## MOD Description: Replace the phpbb search keywords highlight on the viewtopic
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 1 Minutes
## Files To Edit: (1) viewtopic.php
## Included Files: n/a
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
##  This mod replace the phpbb search keywords highlight on the viewtopic. 
##  Replace "font color" to "background-color". This is more conspicuous.
##
##############################################################
## MOD History:
##
## 2006-05-10 - Version 1.0.0
##   - Initial Release
##
## 2006-05-21 - Version 1.0.1
##   - Added red font color, now very cool
##
## 2006-06-09 - Version 1.0.2
##   - updated code for phpbb 2.0.21
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]--------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]--------------------------------------------
#

		$message = preg_replace('#(?!<.*)(?<!\w)(' . $highlight_match . ')(?!\w|[^<>]*>)#i', '<b style="color:#'.$theme['fontcolor3'].'">\1</b>', $message);

#
#-----[ IN-LINE FIND ]------------------------------------
#

style="color:#'.$theme['fontcolor3'].'"

#
#-----[ IN-LINE REPLACE WITH ]-----------------------------
#

style="background-color:yellow;color:red;"

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 

