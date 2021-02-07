##############################################################
## MOD Title: Hidden Login MOD
## MOD Author: eviL3 < evil@phpbbmodders.com > (Igor Wiedler) http://phpbbmodders.com/
## MOD Description: Allows users to login Hidden, so they aren't listed in
##                  the "who's online" part / page.
##
## MOD Version:      1.0.1
##
## Installation Level: Easy
## Installation Time: 1 Minutes
## Files To Edit: login.php
##
## Included Files:   (n/a)
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
#-----[ OPEN ]------------------------------------------------
#
login.php

#
#-----[ FIND ]------------------------------------------------
#
$hidelogin = ( isset($HTTP_POST_VARS['hidelogin']) ) ? TRUE : 0;

#
#-----[ IN-LINE FIND ]------------------------------------------------
#
TRUE : 0

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------------
#
0 : 1

#
#-----[ FIND ]------------------------------------------------
#
         // Hidelogin 
          if( !$userdata['session_logged_in'] ) 
          { 
            if( $hidelogin ) 
            { 
              $db->sql_query('UPDATE ' . USERS_TABLE . ' SET  user_allow_viewonline = 0 WHERE user_id = ' . $row['user_id']); 
            } 
            else 
            { 
              $db->sql_query('UPDATE ' . USERS_TABLE . ' SET  user_allow_viewonline = 1 WHERE user_id = ' . $row['user_id']); 
            } 
          }

#
#-----[ REPLACE WITH ]------------------------------------------------
#
          // Hidelogin 
          if( !$userdata['session_logged_in'] ) 
          { 
            $db->sql_query('UPDATE ' . USERS_TABLE . ' SET  user_allow_viewonline = ' . $hidelogin . ' WHERE user_id = ' . $row['user_id']); 
          }

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
