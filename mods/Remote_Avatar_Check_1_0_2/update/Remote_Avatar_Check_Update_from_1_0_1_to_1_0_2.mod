##############################################################
## MOD Title: Remote Avatar Check
## MOD Author: darklordsatan < N/A > (N/A) http://eviltrend.sourceforge.net
## MOD Description: Update from 1.0.1 to 1.0.2
## MOD Version: 1.0.2
##
## Installation Level: (Easy)
## Installation Time: 1 Minute
## Files To Edit: includes/usercp_avatar.php
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
## Author Notes: In case you installed 1.0.1 version of this MOD, use this file to update 
##               it to the latest version (1.0.2)
##
##############################################################
## MOD History:
##
##   2005-10-14 - Version 1.0.0
##      - Release of the first version
##
##   2005-10-22 - Version 1.0.1
##      - Minor code fixes/additions in order to resubmit the mod at the phpBB MOD database
##
##   2006-02-17 - Version 1.0.2
##      - The mod is compliant with the latest phpBB release (2.0.19)
##      - Fixed a nasty bug where a huge remote image could potentially arise a script execution timeout error
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php

#
#-----[ FIND ]------------------------------------------
#
		if (strlen(@fread($remote_file, 1)) == 0)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
0

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 || $user_avatar_size > $board_config['avatar_filesize']

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM