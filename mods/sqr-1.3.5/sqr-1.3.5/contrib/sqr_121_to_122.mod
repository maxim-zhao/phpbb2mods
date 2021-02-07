##############################################################
## MOD Title: SQR 1.2.1 to SQR 1.2.2 Code Changes
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: Changes from Super Quick Reply 1.2.1 to 1.2.2
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 2 Minutes
## Files To Edit: includes/viewtopic_quickreply.php
##
## Included Files: (n/a)
##
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
## phpBB 2.0.13 compatible.
##
## This MOD will install using EasyMOD.
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-11 - Version 1.0.0
##      - initial public version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------
#
if ( ($userdata['user_quickreply_mode']==1) && ($userdata['user_id'] != ANONYMOUS) || ($board_config['anonymous_sqr_mode']==1) )

#
#-----[ REPLACE WITH ]--------------------------------------
#
if ( (($userdata['user_quickreply_mode']==1) && ($userdata['user_id'] != ANONYMOUS)) || (($board_config['anonymous_sqr_mode']==1) && ($userdata['user_id'] == ANONYMOUS)) )

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM