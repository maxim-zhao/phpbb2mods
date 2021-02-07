##############################################################
## MOD Title: Admin Session Logout
## MOD Author: eviL3 < evil@phpbbmodders.org > (Igor Wiedler) http://phpbbmodders.org
## MOD Description: Logout of the Admin panel only. That will remove
## the admin session, so that you have to login again for ACP access.
##
## MOD Version:      1.1.1
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit:
##         login.php,
##         admin/index.php,
##         language/lang_english/lang_admin.php,
##         templates/subSilver/admin/index_navigate.tpl
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
## Author Notes:
##
## Nothing to say yet.
##
##############################################################
## MOD History:
##
##   2006-07-06 - Version 0.1.0
##      - First release
##
##   2006-07-06 - Version 0.1.1
##      - Small update
##
##   2006-13-07 - Version 0.1.2
##      - Enhanced / Sped up
##
##   2006-07-20 - Version 1.0.0
##      - Submitted to MODDB
##
##   2006-10-14 - Version 1.1.0
##      - Added $phpbb_root_path, as suggested by the MOD team
##      - Ordered files alphabeticaly, lol
##      - Improved the $lang "FIND"
##      - Improved tabbing
##      - Added comments for better overview
##      - Added an addon for WileCoyote
##
##   2006-10-18 - Version 1.1.1
##      - Updated / fixed close window addon
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
else if( ( isset($HTTP_GET_VARS['logout'])

#
#-----[ BEFORE, ADD ]------------------------------------------------
#
	// Admin Session Logout
	else if( isset($HTTP_GET_VARS['admin_session_logout']) && $userdata['user_level'] == ADMIN )
	{
		// session id check
		if ( $sid == '' || $sid != $userdata['session_id'] )
		{
			message_die(GENERAL_ERROR, 'Invalid_session');
		}
		
		$sql = "UPDATE " . SESSIONS_TABLE . "
			SET session_admin = 0
			WHERE session_id = '" . $userdata['session_id'] . "'";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(CRITICAL_ERROR, 'Couldn\'t update Sessions Table', '', __LINE__, __FILE__, $sql);
		}
		
		redirect(append_sid("index.$phpEx", true));
	}
	// Admin Session Logout

#
#-----[ OPEN ]------------------------------------------------
#
admin/index.php

#
#-----[ FIND ]------------------------------------------------
#
"body" => "admin/index_navigate.tpl")

#
#-----[ FIND ]------------------------------------------------
#
$template->assign_vars(array(

#
#-----[ AFTER, ADD ]------------------------------------------------
#
		// Admin Session Logout
		"U_ADMIN_LOGOUT" => append_sid("$phpbb_root_path/login.$phpEx?logout=true&admin_session_logout=true"),
		"L_ADMIN_LOGOUT" => $lang['Admin_session_logout'],
		// Admin Session Logout

#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------------
#
$lang['Preview_forum']

#
#-----[ AFTER, ADD ]-----------------------------------------
#
// Admin Session Logout
$lang['Admin_session_logout'] = 'Admin Logout';
// Admin Session Logout

#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/admin/index_navigate.tpl

#
#-----[ FIND ]------------------------------------------------
#
<!-- BEGIN catrow -->

#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- Admin Session Logout -->
		<tr> 
		  <td class="row1"><span class="genmed"><a href="{U_ADMIN_LOGOUT}" target="_parent" class="genmed">{L_ADMIN_LOGOUT}</a></span></td>
		</tr>
<!-- Admin Session Logout -->

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
