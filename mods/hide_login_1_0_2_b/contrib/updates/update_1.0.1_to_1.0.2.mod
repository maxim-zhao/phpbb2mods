##############################################################
## MOD Title: Hidden Login 1.0.1 to 1.0.2
## MOD Author: eviL3 < evil@phpbbmodders.net > (Igor Wiedler) http://phpbbmodders.net
## MOD Description: Update instructions
## MOD Version:      1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minutes
## Files To Edit: login.php
##
## Included Files:   n/a
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ FIND ]------------------------------------------------
#
					// Reset login tries
					$db->sql_query
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
, user_last_login_try = 0
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
, user_allow_viewonline = ' . $hidelogin . '
#
#-----[ FIND ]------------------------------------------------
#
					if( !$userdata['session_logged_in'] ) 
					{ 
						$db->sql_query('UPDATE ' . USERS_TABLE . ' SET  user_allow_viewonline = ' . $hidelogin . ' WHERE user_id = ' . $row['user_id']); 
					}
#
#-----[ REPLACE WITH ]------------------------------------------------
#
# Just remove those lines
#

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
