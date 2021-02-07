##############################################################
## MOD Title: Change Registration Date
## MOD Author: alexi02 < N/A > (Alejandro Iannuzzi) http://www.uzzisoft.com
## MOD Description: Allows you to change a user's registration date from the ACP in User Administration
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: admin/admin_users.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/user_edit_body.tpl
## Included Files: N/A
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
##      An easy way to change a user's registration date from the ACP.
##
##############################################################
## MOD History:
##
##  2006-09-15 - Version 1.0.1
##      - Replaced REPLACE WITH with INLINE FIND and ADD
##      - Corrected DD/MM/YYYY to DD-MM-YYYY in $lang['Regdate_wrong_date_format']
##      - Added an explaination of the registration date which shows the date format
##
##  2006-09-02 - Version 1.0.0
##      - Initial Release (for phpBB 2.0.21)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#

$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;

#
#-----[ AFTER, ADD ]------------------------------------------
#

		$regdate = ( !empty($HTTP_POST_VARS['registerdate']) ) ? trim(strip_tags( $HTTP_POST_VARS['registerdate'] ) ) : '';

#
#-----[ FIND ]------------------------------------------
#

$user_dateformat = htmlspecialchars(stripslashes($user_dateformat));

#
#-----[ AFTER, ADD ]------------------------------------------
#

			$regdate = htmlspecialchars(stripslashes($regdate));

#
#-----[ FIND ]------------------------------------------
#

$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", phpbb_ltrim(basename($user_avatar_category), "'") . '/' . phpbb_ltrim(basename($user_avatar_local), "'")) . "', user_avatar_type = " . USER_AVATAR_GALLERY;
                }

#
#-----[ AFTER, ADD ]------------------------------------------
#


                //
                // Start Change Registration Date Mod
                //

                if ($regdate != '') {
                   $regdate_ok = 0;

                   $regdate_spacesplit = explode(" ",$regdate);
                   if (count($regdate_spacesplit) == 2) {

                      $regdate_datesplit = explode("-",$regdate_spacesplit[0]);
                      if (count($regdate_datesplit) == 3) {

                         $regdate_timesplit = explode(":",$regdate_spacesplit[1]);
                         if (count($regdate_timesplit) == 3) {

                            $regdate_unix = mktime($regdate_timesplit[0], $regdate_timesplit[1], $regdate_timesplit[2], $regdate_datesplit[1], $regdate_datesplit[0], $regdate_datesplit[2]);
                            $regdate = date("d-m-Y H:i:s", $regdate_unix);
                            $regdate_ok = 1;
                         }
                      }
                   }

                   if ($regdate_ok == 0) {
                      $error = true;
                      $error_msg = ( !empty($error_msg) ) ? $error_msg . "<br />" . $lang['Regdate_wrong_date_format'] : $lang['Regdate_wrong_date_format'];
                   }
                }

                //
                // End Change Registration Date Mod
                //

#
#-----[ FIND ]------------------------------------------
#

$sql = "UPDATE " . USERS_TABLE . "
                                SET " . $username_sql

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_active = $user_status,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

 user_regdate = $regdate_unix, 

#
#-----[ FIND ]------------------------------------------
#

$user_allowpm = $this_userdata['user_allow_pm'];

#
#-----[ AFTER, ADD ]------------------------------------------
#

		$regdate = date("d-m-Y H:i:s", $this_userdata['user_regdate']);

#
#-----[ FIND ]------------------------------------------
#

$s_hidden_fields .= '<input type="hidden" name="user_rank" value="' . $user_rank . '" />';

#
#-----[ AFTER, ADD ]------------------------------------------
#

			$s_hidden_fields .= '<input type="hidden" name="registerdate" value="' . $regdate . '" />';

#
#-----[ FIND ]------------------------------------------
#

'RANK_SELECT_BOX' => $rank_select_box,

#
#-----[ AFTER, ADD ]------------------------------------------
#

			'REGISTER_DATE' => $regdate,

#
#-----[ FIND ]------------------------------------------
#

'L_SELECT_RANK' => $lang['Rank_title'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

			'L_REGISTER_DATE' => $lang['Regdate_title'],
                        'L_REGISTER_EXPLAIN' => $lang['Regdate_explain'], 

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Confirm_delete_rank'] = 'Are you sure you want to delete this rank?';

#
#-----[ AFTER, ADD ]------------------------------------------
#


//
// Start Change Registration Date Mod
//

$lang['Regdate_title'] = 'Registration Date';
$lang['Regdate_explain'] = 'The format is DD-MM-YYYY HH:MM:SS (in 24 hr time format)';
$lang['Regdate_wrong_date_format'] = 'Registration Date format is incorrect. The correct format is DD-MM-YYYY HH:MM:SS (in 24 hr time format).';

//
// End Change Registration Date Mod
//

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
        <tr>
          <td class="row1"><span class="gen">{L_DELETE_USER}?</span></td>
          <td class="row2">
                <input type="checkbox" name="deleteuser">
                {L_DELETE_USER_EXPLAIN}</td>
        </tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

        <tr>
          <td class="row1"><span class="gen">{L_REGISTER_DATE}</span><br />
                <span class="gensmall">{L_REGISTER_EXPLAIN}</span></td>
          <td class="row2">
                <input class="post" type="text" name="registerdate" value="{REGISTER_DATE}" maxlength="19" />
          </td>
        </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM