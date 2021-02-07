##############################################################
## MOD Title: phpBB GTalk (Google Talk) Support
## MOD Author: ptlis < ptlis@ptlis.com > (Brian Ridley) http://www.ptlis.com
## MOD Description: Adds support for the Google Talk IM network
## MOD Version: 1.1.0
##
## Installation Level: (Intermediate)
## Installation Time: 30 Minutes
## Files To Edit: groupcp.php
##                memberlist.php
##                privmsg.php
##                viewtopic.php
##                admin/admin_users.php
##                includes/functions_validate.php
##                includes/usercp_avatar.php
##                includes/usercp_register.php
##                includes/usercp_viewprofile.php
##                install/upgrade.php
##                language/lang_english/lang_main.php
##                language/lang_english/email/coppa_welcome_inactive.tpl
##                templates/subSilver/privmsgs_read_body.tpl
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/profile_view_body.tpl
##                templates/subSilver/subSilver.cfg
##                templates/subSilver/viewtopic_body.tpl
##                templates/subSilver/admin/user_edit_body.tpl
## Included Files: icon_gtalk.gif
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
##     Versions of this modification have been tested with phpBB 2.0.17 - 2.0.20
##     only, although I would  imagine it should install sucessfully on previous
##     and/or future revisions of the 2.0.xx release.
##
##     This modification is Free software; you can redistribute it and/or
##     modify it under the terms of the GNU General Public License as published
##     by the Free Software Foundation; either version 2 of the License, or (at
##     your option) any later version.
##############################################################
## MOD History:
##
##   2005-08-23 - Version 1.0.0
##      - Initial release of this mod, based upon my Jabber MOD
##
##   2005-09-11 - Version 1.0.1
##      - Fixed a problem flagged by the phpBB MOD Validation Team
##      - Updated the modification to conform to the new MOD template
##
##   2005-09-15 - Version 1.0.2
##      - Fixed another issue so the MOD now conforms to the new MOD template.
##
##   2006-02-09 - Version 1.0.3
##      - Fixed an incompatibility introduced by the phpBB team when they
##            updated the codebase to 2.0.19
##
##   2006-03-05 - Version 1.0.4
##      - Fixed another incompatibility introduced by the phpBB team when they
##            updated the codebase to 2.0.18
##
##   2006-04-10 - Version 1.1.0
##      - Total rewrite to coincide with the release of 2.0.20 which more fully
##            integrates the use of GTalk than previous versions
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ COPY ]------------------------------------------------
#
copy icon_gtalk.gif to templates/subSilver/images/lang_english/icon_gtalk.gif
#
#-----[ OPEN ]------------------------------------------------
#
groupcp.php
#
#-----[ FIND ]------------------------------------------------
#
function generate_user_info(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, &$msn_img, &$msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, &$gtalk_img, &$gtalk
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk_img = ( $row['user_gtalk'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_gtalk'] . '" alt="' . $lang['GTALK'] . '" title="' . $lang['GTALK'] . '" border="0" /></a>' : '';
$gtalk = ( $row['user_gtalk'] ) ? '<a href="' . $temp_url . '">' . $lang['GTALK'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
$sql = "SELECT username, user_id,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_gtalk
#
#-----[ FIND ]------------------------------------------------
# FIXME: This is done twice on two seperate sql querys
#
$sql = "SELECT u.username, u.user_id, u.user_viewemail
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, u.user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, u.user_gtalk
#
#-----[ FIND ]------------------------------------------------
# FIXME: This is done twice on two seperate sql querys
#
$sql = "SELECT u.username, u.user_id, u.user_viewemail
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, u.user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, u.user_gtalk
#
#-----[ FIND ]------------------------------------------------
#
generate_user_info(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $msn_img, $msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $gtalk_img, $gtalk
#
#-----[ FIND ]------------------------------------------------
#
'L_MSNM' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_GTALK' => $lang['GTALK'],
#
#-----[ FIND ]------------------------------------------------
#
'MOD_MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'MOD_GTALK_IMG' => $gtalk_img,
'MOD_GTALK' => $gtalk,
#
#-----[ FIND ]------------------------------------------------
#
generate_user_info(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $msn_img, $msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $gtalk_img, $gtalk
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK_IMG' => $gtalk_img,
'GTALK' => $gtalk,
#
#-----[ FIND ]------------------------------------------------
#
generate_user_info(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $msn_img, $msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $gtalk_img, $gtalk
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK_IMG' => $gtalk_img,
'GTALK' => $gtalk,
#
#-----[ OPEN ]------------------------------------------------
#
memberlist.php
#
#-----[ FIND ]------------------------------------------------
#
'L_MSNM' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_GTALK' => $lang['GTALK'],
#
#-----[ FIND ]------------------------------------------------
#
$sql = "SELECT username, user_id, user_viewemail,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_gtalk
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk_img = ( $row['user_gtalk'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_gtalk'] . '" alt="' . $lang['GTALK'] . '" title="' . $lang['GTALK'] . '" border="0" /></a>' : '';
$gtalk = ( $row['user_gtalk'] ) ? '<a href="' . $temp_url . '">' . $lang['GTALK'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK_IMG' => $gtalk_img,
'GTALK' => $gtalk,
#
#-----[ OPEN ]------------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------------
#
$sql = "SELECT u.username AS username_1,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, u.user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, u.user_gtalk
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $privmsg['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk_img = ( $privmsg['user_gtalk'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_gtalk'] . '" alt="' . $lang['GTALK'] . '" title="' . $lang['GTALK'] . '" border="0" /></a>' : '';
$gtalk = ( $privmsg['user_gtalk'] ) ? '<a href="' . $temp_url . '">' . $lang['GTALK'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK_IMG' => $gtalk_img,
'GTALK' => $gtalk,
#
#-----[ OPEN ]------------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------------
#
$sql = "SELECT u.username, u.user_id, u.user_posts
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, u.user_msnm
#
'-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, u.user_gtalk
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk_img = ( $postrow[$i]['user_gtalk'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_gtalk'] . '" alt="' . $lang['GTALK'] . '" title="' . $lang['GTALK'] . '" border="0" /></a>' : '';
$gtalk = ( $postrow[$i]['user_gtalk'] ) ? '<a href="' . $temp_url . '">' . $lang['GTALK'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
$msn = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk_img = '';
$gtalk = '';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK_IMG' => $gtalk_img,
'GTALK' => $gtalk,
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
$gtalk = ( !empty($HTTP_POST_VARS['gtalk']) ) ? trim(strip_tags( $HTTP_POST_VARS['gtalk'] ) ) : '';
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
, $gtalk
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars(stripslashes($msn));
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk = htmlspecialchars(stripslashes($gtalk));
#
#-----[ FIND ]------------------------------------------------
#
SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "'
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm = '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_gtalk = '" . str_replace("\'", "''", $gtalk) . "'
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars(stripslashes($msn));
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk = htmlspecialchars(stripslashes($gtalk));
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars($this_userdata['user_msnm']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk = htmlspecialchars($this_userdata['user_gtalk']);
#
#-----[ FIND ]------------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="msn" value="' . str_replace("\"", "&quot;", $msn) . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="gtalk" value="' . str_replace("\"", "&quot;", $gtalk) . '" />';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK' => $gtalk,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_GTALK' => $lang['GTALK'],
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
, &$gtalk
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
, 'gtalk'
#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]------------------------------------------------
#
function display_avatar_gallery(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, &$msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, &$gtalk
#
#-----[ FIND ]------------------------------------------------
#
$params = array('coppa', 'user_id', 'username'
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'msn'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, 'gtalk'
#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------------
#
$strip_var_list = array(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'msn' => 'msn'
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
, 'gtalk' => 'gtalk'
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
, $gtalk
#
#-----[ FIND ]------------------------------------------------
#
$msn = stripslashes($msn);
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk = stripslashes($gtalk);
#
#-----[ FIND ]------------------------------------------------
#
SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."'
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm = '" . str_replace("\'", "''", $msn) . "'
#
#-----[ AFTER, ADD ]------------------------------------------
#
, user_gtalk = '" . str_replace("\'", "''", $gtalk) . "'
#
#-----[ FIND ]------------------------------------------------
#
$sql = "INSERT INTO " . USERS_TABLE . "	(user_id
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_msnm
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_gtalk
#
#-----[ FIND ]------------------------------------------------
#
VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . "
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, '" . str_replace("\'", "''", $gtalk) . "'
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK' => $gtalk,
#
#-----[ FIND ]------------------------------------------------
#
$msn = $userdata['user_msnm'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$gtalk = $userdata['user_gtalk'];
#
#-----[ FIND ]------------------------------------------------
#
display_avatar_gallery(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $msn
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $gtalk
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK' => $gtalk,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_GTALK' => $lang['GTALK'],
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
$gtalk_img = ( $profiledata['user_gtalk'] ) ? $profiledata['user_gtalk'] : '&nbsp;';
$gtalk = $gtalk_img;
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'GTALK_IMG' => $gtalk_img,
'GTALK' => $gtalk,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_GTALK' => $lang['GTALK'],
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
$lang['GTALK'] = 'GTalk ID';
#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/email/coppa_welcome_inactive.tpl
#
#-----[ FIND ]------------------------------------------------
#
MSN Messenger: {MSN}
#
#-----[ AFTER, ADD ]------------------------------------------
#
GTalk ID: {GTALK}
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/privmsgs_read_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
{WWW_IMG}
#
#-----[ IN-LINE FIND ]----------------------------------------
#
{MSN_IMG}
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
 {GTALK_IMG}
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
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
	  <td class="row1"><span class="gen">{L_GTALK}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="gtalk" size="20" maxlength="255" value="{GTALK}" />
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
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_GTALK}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{GTALK}</span></td>
		</tr>
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
$images['icon_gtalk'] = "$current_template_images/{LANG}/icon_gtalk.gif";
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
<td valign="middle" nowrap="nowrap">
#
#-----[ IN-LINE FIND ]----------------------------------------
#
{postrow.MSN_IMG}
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
 {postrow.GTALK_IMG}
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
	  <td class="row1"><span class="gen">{L_GTALK}</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="gtalk" size="20" maxlength="255" value="{GTALK}" />
	  </td>
	</tr>
#
#-----[ SQL ]-------------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_gtalk` VARCHAR( 255 ) NULL;
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
