##############################################################
## MOD Title: logout link on admin cp
## MOD Author: Alexis Canver < N/A > (Alexis Canver) http://www.canver.net
## MOD Description: This mod add logout link to admin cp
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: (2) admin/page_header_admin.php
##                    templates/subSilver/admin/index_navigate.tpl
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
##  This mod add logout link to admin cp
##
##############################################################
## MOD History:
##
## 2006-10-05 - Version 1.0.0
##   - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#
#-----[ OPEN ]------------------------------------------------
#
admin/page_header_admin.php

#
#-----[ FIND ]------------------------------------------------
#

$template->set_filenames(array(
	'header' => 'admin/page_header.tpl')
);

#
#------[ AFTER, ADD ]-----------------------------------------
#

//
// Generate logged in/logged out status
//
if ( $userdata['session_logged_in'] )
{
	$u_login_logout = '../login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
	$l_login_logout = $lang['Logout'] . '<br />[ ' . $userdata['username'] . ' ]';
}
else
{
	$u_login_logout = '../login.'.$phpEx;
	$l_login_logout = $lang['Login'];
}

#
#-----[ FIND ]------------------------------------------------
#

	'U_INDEX' => append_sid('../index.'.$phpEx),

#
#------[ AFTER, ADD ]-----------------------------------------
#

	'L_LOGIN_LOGOUT' => $l_login_logout,
	'U_LOGIN_LOGOUT' => append_sid($u_login_logout),

#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/admin/index_navigate.tpl

#
#-----[ FIND ]------------------------------------------------
#

<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center">

#
#------[ AFTER, ADD ]-----------------------------------------
#

  <tr> 
	<td align="center"><span class="gensmall"><a href="{U_LOGIN_LOGOUT}" class="gensmall" target="_top"><!-- <img src="../templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" /> -->{L_LOGIN_LOGOUT}</a></span></td>
  </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM