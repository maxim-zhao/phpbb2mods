##############################################################
## MOD Title: Admin Contacts List
## MOD Author: edi82 < N/A > (N/A) N/A
## MOD Description: This MOD will add a new line in the WhoIsOnline box on the homepage with the list of the administrators and direct links to profiles. 
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~3 Minutes
## Files To Edit: 
##      language/lang_english/lang_main.php
##      index.php
##      templates/subSilver/index_body.tpl
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
##
## EasyMOD
## ===========
## This MOD can be successfully installed using EasyMOD.
##############################################################
## MOD History:
##
##   2006-06-27 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
# NOTE: You will need to perform the following actions for all of your different languages.
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['FAQ'] = 'FAQ';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['ACL_CONTACT_ADMIN'] = 'Contact an administrator:';

#
#-----[ OPEN ]------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------
#
		'U_MARK_READ' => append_sid("index.$phpEx?mark=forums"))
	);
	
#
#-----[ AFTER, ADD ]------------------------------------------
#
  $acl_admin_information = "";
  if(defined('SHOW_ONLINE')) {
	  $acl_sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level FROM ".USERS_TABLE." u ORDER BY u.username ASC";
	  if($acl_result = $db->sql_query($acl_sql)) {
      while($acl_row = $db->sql_fetchrow($acl_result)) {
        if($acl_row['user_level'] == ADMIN && $acl_row['user_allow_viewonline']) {
					$acl_admin_information .= '<a href="'.append_sid("profile.$phpEx?mode=viewprofile&amp;".POST_USERS_URL."=".$acl_row['user_id']).'"><b>'.$acl_row['username'].'</b></a> ';
				}
      }

    }
  }
  $template->assign_vars(array(
    'ACL_CONTACT_ADMIN' => $lang['ACL_CONTACT_ADMIN'].' '.$acl_admin_information)
  );
	
#
#-----[ OPEN ]------------------------------------------
#
# NOTE: You will need to perform the following actions for all of your different templates.
#
templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<td class="row1" align="center" valign="middle" rowspan="{%:1}">

#
#-----[ INCREMENT ]------------------------------------------
#
%:1

#
#-----[ FIND ]------------------------------------------
#
	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
  </tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
  <tr><td class="row1" align="left"><span class="gensmall">{ACL_CONTACT_ADMIN}</span></td></tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
