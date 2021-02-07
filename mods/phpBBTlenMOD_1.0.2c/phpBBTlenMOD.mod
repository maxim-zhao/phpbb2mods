##############################################################
## MOD Title: phpBB Tlen Support
## MOD Author: churchyard <churchyard@gmail.com> (N/A) http://www.bblangs.net
## MOD Author: ptlis <ptlis@ptlis.com> (Brian Ridley) http://www.ptlis.com
## MOD Description: Adds support for the Tlen IM network
## MOD Version: 1.0.2c
##
## Installation Level: (Intermediate)
## Installation Time: 15 Minutes
## Files To Edit: viewtopic.php
##                language/lang_english/lang_main.php
##                admin/admin_users.php
##                includes/functions_validate.php
##                includes/usercp_avatar.php
##                includes/usercp_register.php
##                includes/usercp_viewprofile.php
##                templates/subSilver/admin/user_edit_body.tpl
##                templates/subSilver/SubSilver.cfg
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/profile_view_body.tpl
##                templates/subSilver/viewtopic_body.tpl
## Included Files: icon_tlen.gif
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
##     This MOD is based upon ptlis jabber/GTalk MOD. http://www.ptlis.com
##
##     This has been tested with phpBB 2.0.18 only, although I would imagine it
##     should install sucessfully on previous and/or future revisions of the
##     2.0.xx release.
##
##     If you want this MOD working on 2.0.17 or lower, skip changes
##     in templates/subSilver/profile_add_body.tpl, open contrib/2.0.17.txt
##     and do, what is in that file.  
##     This is because 2.0.18 has a cosmetic fix on that part
##
##     This modification is Free software; you can redistribute it and/or
##     modify it under the terms of the GNU General Public License as published
##     by the Free Software Foundation; either version 2 of the License, or (at
##     your option) any later version.
##
##     Author of Tlen icon is Thatbitextra
##############################################################
## MOD History:
##
##   2005-11-12 - Version 1.0.2(b/c)
##      - Fixed bug in MOD template
##      - b version: fixed wrong place of icon_tlen.gif
##      - c version: some fixes in contrib/2.0.17.txt
##
##   2005-11-06 - Version 1.0.1
##      - Updated for phpBB version 2.0.18
##
##   2005-10-09 - Version 1.0.0
##      - Initial release of this mod, based upon ptlis jabber/GTalk MOD
##
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ COPY ]------------------------------------------------
#
copy root/templates/subSilver/images/lang_english/icon_tlen.gif to templates/subSilver/images/lang_english/icon_tlen.gif
#
#-----[ OPEN ]------------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------------
#
$sql = "SELECT u.username, u.user_id, u.user_posts,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, u.user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, u.user_tlen
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen_img = ( $postrow[$i]['user_tlen'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_tlen'] . '" alt="' . $lang['TLEN'] . '" title="' . $lang['TLEN'] . '" border="0" /></a>' : '';
$tlen = ( $postrow[$i]['user_tlen'] ) ? '<a href="' . $temp_url . '">' . $lang['TLEN'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
$msn = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen_img = '';
$tlen = '';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'TLEN_IMG' => $tlen_img,
'TLEN' => $tlen,
#
#-----[ OPEN ]------------------------------------------------
#
includes/functions_validate.php
#
#-----[ FIND ]------------------------------------------------
#
function validate_optional_fields(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, &$msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, &$tlen
#
#-----[ FIND ]------------------------------------------------
#
$check_var_length = array(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'msnm'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, 'tlen'
#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]------------------------------------------------
#
function display_avatar_gallery($mode, &$category, &$user_id, &$email,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, &$msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, &$tlen
#
#-----[ FIND ]------------------------------------------------
#
$params = array('coppa', 'user_id', 'username', 'email', 'current_email',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'msn'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, 'tlen'
#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------------
#
$strip_var_list = array('username' => 'username', 'email' => 'email',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'msn' => 'msn'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, 'tlen' => 'tlen'
#
#-----[ FIND ]------------------------------------------------
#
validate_optional_fields(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $tlen
#
#-----[ FIND ]------------------------------------------------
#
$msn = stripslashes($msn);
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen = stripslashes($tlen);
#
#-----[ FIND ]------------------------------------------------
#
SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm = '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_tlen = '" . str_replace("\'", "''", $tlen) . "'
#
#-----[ FIND ]------------------------------------------------
#
$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password, user_email, 
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_tlen
#
#-----[ FIND ]------------------------------------------------
#
VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, '" . str_replace("\'", "''", $tlen) . "'
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'TLEN' => $tlen,
#
#-----[ FIND ]------------------------------------------------
#
$msn = stripslashes($msn);
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen = stripslashes($tlen);
#
#-----[ FIND ]------------------------------------------------
#
$msn = $userdata['user_msnm'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen = $userdata['user_tlen'];
#
#-----[ FIND ]------------------------------------------------
#
display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $tlen
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'TLEN' => $tlen,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_TLEN' => $lang['TLEN'],
#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------------
#
$msn = $msn_img;
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen_img = ( $profiledata['user_tlen'] ) ? $profiledata['user_tlen'] : '&nbsp;';
$tlen = $tlen_img;
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'TLEN_IMG' => $tlen_img,
'TLEN' => $tlen,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_TLEN' => $lang['TLEN'],
#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------------
#
$lang['MSNM'] = 'MSN Messenger';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['TLEN'] = 'Tlen login';
#
#-----[ OPEN ]------------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( !empty($HTTP_POST_VARS['msn']) ) ? trim(strip_tags( $HTTP_POST_VARS['msn'] ) ) : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen = ( !empty($HTTP_POST_VARS['tlen']) ) ? trim(strip_tags( $HTTP_POST_VARS['tlen'] ) ) : '';
#
#-----[ FIND ]------------------------------------------------
#
validate_optional_fields(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $tlen
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars(stripslashes($msn));
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen = htmlspecialchars(stripslashes($tlen));
#
#-----[ FIND ]------------------------------------------------
#
SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm = '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_tlen = '" . str_replace("\'", "''", $tlen) . "'
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars(stripslashes($msn));
#
#-----[ AFTER, ADD ]------------------------------------------
#
$tlen = htmlspecialchars(stripslashes($tlen));
#
#------[ FIND ]-----------------------------------------------
#
$msn = htmlspecialchars($this_userdata['user_msnm']);
#
#------[ AFTER, ADD ]-----------------------------------------
#
$tlen = htmlspecialchars($this_userdata['user_tlen']);
#
#-----[ FIND ]------------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="msn" value="' . str_replace("\"", "&quot;", $msn) . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="tlen" value="' . str_replace("\"", "&quot;", $tlen) . '" />';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'TLEN' => $tlen,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_TLEN' => $lang['TLEN'],
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------------
#
$images['icon_msnm'] = "$current_template_images/{LANG}/icon_msnm.gif";
#
#-----[ AFTER, ADD ]------------------------------------------
#
$images['icon_tlen'] = "$current_template_images/{LANG}/icon_tlen.gif";
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------------
# If you are using phpBB 2.0.17 or lower, skip this file and open open contrib/2.0.17.txt for corect text to find. 
   <tr>
     <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>
     <td class="row2">
      <input type="text" class="post" style="width: 150px"  name="msn" size="20" maxlength="255" value="{MSN}" />
     </td>
   </tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
   <tr>
     <td class="row1"><span class="gen">{L_TLEN}:</span></td>
     <td class="row2">
      <input type="text" class="post" style="width: 150px"  name="tlen" size="20" maxlength="255" value="{TLEN}" />
     </td>
   </tr>
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
      <tr>
        <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_MESSENGER}:</span></td>
        <td class="row1" valign="middle"><span class="gen">{MSN}</span></td>
      </tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
      <tr>
        <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_TLEN}:</span></td>
        <td class="row1" valign="middle"><span class="gen">{TLEN}</span></td>
      </tr>
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
<td valign="middle" nowrap="nowrap">{postrow.PROFILE_IMG} {postrow.PM_IMG}
#
#-----[ IN-LINE FIND ]----------------------------------------
#
{postrow.MSN_IMG}
#
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
 {postrow.TLEN_IMG}
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
    <tr>
      <td class="row1"><span class="gen">{L_MESSENGER}</span></td>
      <td class="row2">
        <input class="post" type="text" name="msn" size="20" maxlength="255" value="{MSN}" />
      </td>
    </tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
    <tr>
      <td class="row1"><span class="gen">{L_TLEN}</span></td>
      <td class="row2">
        <input class="post" type="text" name="tlen" size="20" maxlength="255" value="{TLEN}" />
      </td>
    </tr>
#
#-----[ SQL ]-------------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_tlen` VARCHAR( 255 ) NULL;
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
