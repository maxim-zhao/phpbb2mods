##############################################################
## MOD Title: Moderators can see hidden members on index
## MOD Author: interlog < is4thenet@hotmail.com > (Mark Janssen) http://www.is4the.net
## MOD Description: 
## MOD Version: 2.0.0
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: includes/page_header.php
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: Phpbb.ModTeam.Tools
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
## 2006-11-06 - Version 1.0.0
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD )
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
