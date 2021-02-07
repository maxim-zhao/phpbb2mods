##############################################################
## MOD Title: Close window addon for "Admin Session Logout"
## MOD Author: eviL3 < evil@phpbbmodders.org > (Igor Wiedler) http://phpbbmodders.org
## MOD Description: This addon will let you close the window after loggin out of the ACP.
##
## MOD Version:      1.0.1
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit:
##         login.php,
##         language/lang_english/lang_main.php
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
## MOD History:
##
##   2006-10-14 - Version 1.0.0
##      - First release, this was requested by WileCoyote and released with 1.1.0 of the MOD
##
##   2006-10-18 - Version 1.0.1
##      - Fixed by changing lang_admin.php to lang_main.php
##
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
	else if( isset($HTTP_GET_VARS['admin_session_logout']) && $userdata['user_level'] == ADMIN )

#
#-----[ FIND ]------------------------------------------------
#
    redirect(append_sid("index.$phpEx", true));

#
#-----[ REPLACE WITH ]------------------------------------------------
#
	//redirect(append_sid("index.$phpEx", true));
	message_die( GENERAL_MESSAGE, sprintf( $lang['Admin_session_logged_out'], '<a href="' . $phpbb_root_path . 'index.' . $phpEx . '" onclick="window.close()">', '</a>' ) );

#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]-----------------------------------------
#
$lang['Admin_session_logged_out'] = 'Logged out of ACP successfully.<br /><br />%sClose Window%s';

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
