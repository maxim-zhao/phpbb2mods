##############################################################
## MOD Title: phpBB Jabber Support
## MOD Author: ptlis < ptlis@ptlis.com > (Brian Ridley) http://www.ptlis.com
## MOD Description: Adds support for the Jabber IM network
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
## Included Files: icon_jabber.gif
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
##     Versions of this modification have been tested with phpBB 2.0.10 - 2.0.20
##     only, although I would  imagine it should install sucessfully on previous
##     and/or future revisions of the 2.0.xx release.
##
##     One of the alternate jabber icons has been removed from this package, if
##     the alternate image is wanted then it can be sourced from an older
##     version of this package.
##
##     In the /contrib/ directory you will find a 'meta-modification' that
##     allows you to use the XMPP:// URI with users' Jabber details.
##
##     According to the RFC http://www.ietf.org/rfc/rfc3920.txt "Each allowable
##     portion of a JID (node identifier, domain identifier, and resource
##     identifier) MUST NOT be more than 1023 bytes in length, resulting in a
##     maximum total size (including the '@' and '/' separators) of 3071 bytes."
##     Realistically however, the number of people with JIDs containing a number
##     of characters greater than 256 is incredibly small and although the MOD
##     doesn't comply with the RFC to the letter, pragmatic concerns in this
##     case took precidence over theoretical purity - for this reason this MOD
##     stores JIDs in a VARCHAR(255) field in the database.
##
##     This modification is Free software; you can redistribute it and/or
##     modify it under the terms of the GNU General Public License as published
##     by the Free Software Foundation; either version 2 of the License, or (at
##     your option) any later version.
##
##     http://www.fsf.org/licensing/licenses/gpl.html
##
##     Thanks goes to ian! <ian@gentoo.org> of http://www.iansview.com for
##     allowing me to modify/include the ACP modification he made.
##############################################################
## MOD History:
##
##   2004-08-19 - Version 0.0.1
##      - Initial release of this mod.
##
##   2004-09-17 - Version 0.0.2
##      - Fixed a language error and added border="0" to image tags so it's
##            standard with the SubSilver theme.
##
##   2004-10-06 - Version 0.0.3
##      - Minor change to make things more clear.
##
##   2004-12-26 - Version 0.0.4
##      - Fixed error to (hopefully) make this mod EasyMod compliant.
##      - Checked to ensure it works with phpBB 2.0.11.
##
##   2005-01-10 - Version 0.0.5
##      - Fixed error to (hopefully) make this mod EasyMod compliant (one more
##            error to go...).
##
##   2005-02-20 - Version 0.0.6
##      - Combined ACP section from ian!'s Jabber mod.
##      - Added missing copy statement.
##      - Cleaned up & standardised format of modification.
##
##   2005-02-22 - Version 1.0.0
##      - Clarified instructions relating to the jabber icon.
##      - Verified that this mod works with the phpBB 2.0.12 release.
##      - Initial submission to the Mod database.
##
##   2005-03-01 - Version 1.0.1
##      - Fixed MOD template issues flagged by the phpBB MOD validation team.
##
##   2005-08-23 - Version 1.0.2
##      - Cleaned up the larger find statements in the hopes that this will alow
##            this modification to integrate more seamlessly with boards that
##            contain other modifications.
##      - Verified that this mod works with the phpBB 2.0.17 release.
##
##   2005-09-11 - Version 1.0.3
##      - Updated the modification to conform to the new MOD template.
##
##   2005-09-15 - Version 1.0.4
##      - Fixed another issue so the MOD now conforms to the new MOD template.
##
##   2006-02-09 - Version 1.0.5
##      - Fixed an incompatibility introduced by the phpBB team when they
##            updated the codebase to 2.0.19
##
##   2006-03-05 - Version 1.0.6
##      - Fixed another incompatibility introduced by the phpBB team when they
##            updated the codebase to 2.0.18
##
##   2006-04-10 - Version 1.1.0
##      - Total rewrite to coincide with the release of 2.0.20 which more fully
##            integrates the use of Jabber than previous versions
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ COPY ]------------------------------------------------
#
copy icon_jabber.gif to templates/subSilver/images/lang_english/icon_jabber.gif
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
, &$jabber_img, &$jabber
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber_img = ( $row['user_jabber'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';
$jabber = ( $row['user_jabber'] ) ? '<a href="' . $temp_url . '">' . $lang['JABBER'] . '</a>' : '';
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
, user_jabber
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
, u.user_jabber
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
, u.user_jabber
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
, $jabber_img, $jabber
#
#-----[ FIND ]------------------------------------------------
#
'L_MSNM' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_JABBER' => $lang['JABBER'],
#
#-----[ FIND ]------------------------------------------------
#
'MOD_MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'MOD_JABBER_IMG' => $jabber_img,
'MOD_JABBER' => $jabber,
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
, $jabber_img, $jabber
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER_IMG' => $jabber_img,
'JABBER' => $jabber,
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
, $jabber_img, $jabber
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER_IMG' => $jabber_img,
'JABBER' => $jabber,
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
'L_JABBER' => $lang['JABBER'],
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
, user_jabber
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber_img = ( $row['user_jabber'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';
$jabber = ( $row['user_jabber'] ) ? '<a href="' . $temp_url . '">' . $lang['JABBER'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER_IMG' => $jabber_img,
'JABBER' => $jabber,
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
, u.user_jabber
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $privmsg['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber_img = ( $privmsg['user_jabber'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';
$jabber = ( $privmsg['user_jabber'] ) ? '<a href="' . $temp_url . '">' . $lang['JABBER'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER_IMG' => $jabber_img,
'JABBER' => $jabber,
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
, u.user_jabber
#
#-----[ FIND ]------------------------------------------------
#
$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber_img = ( $postrow[$i]['user_jabber'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';
$jabber = ( $postrow[$i]['user_jabber'] ) ? '<a href="' . $temp_url . '">' . $lang['JABBER'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------------
#
$msn = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber_img = '';
$jabber = '';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER_IMG' => $jabber_img,
'JABBER' => $jabber,
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
$jabber = ( !empty($HTTP_POST_VARS['jabber']) ) ? trim(strip_tags( $HTTP_POST_VARS['jabber'] ) ) : '';
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
, $jabber
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars(stripslashes($msn));
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber = htmlspecialchars(stripslashes($jabber));
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
, user_jabber = '" . str_replace("\'", "''", $jabber) . "'
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars(stripslashes($msn));
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber = htmlspecialchars(stripslashes($jabber));
#
#-----[ FIND ]------------------------------------------------
#
$msn = htmlspecialchars($this_userdata['user_msnm']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber = htmlspecialchars($this_userdata['user_jabber']);
#
#-----[ FIND ]------------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="msn" value="' . str_replace("\"", "&quot;", $msn) . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="jabber" value="' . str_replace("\"", "&quot;", $jabber) . '" />';
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER' => $jabber,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_JABBER' => $lang['JABBER'],
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
, &$jabber
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
, 'jabber'
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
, &$jabber
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
, 'jabber'
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
, 'jabber' => 'jabber'
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
, $jabber
#
#-----[ FIND ]------------------------------------------------
#
$msn = stripslashes($msn);
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber = stripslashes($jabber);
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
, user_jabber = '" . str_replace("\'", "''", $jabber) . "'
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
, user_jabber
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
, '" . str_replace("\'", "''", $jabber) . "'
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER' => $jabber,
#
#-----[ FIND ]------------------------------------------------
#
$msn = $userdata['user_msnm'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$jabber = $userdata['user_jabber'];
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
, $jabber
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER' => $jabber,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_JABBER' => $lang['JABBER'],
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
$jabber_img = ( $profiledata['user_jabber'] ) ? $profiledata['user_jabber'] : '&nbsp;';
$jabber = $jabber_img;
#
#-----[ FIND ]------------------------------------------------
#
'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
'JABBER_IMG' => $jabber_img,
'JABBER' => $jabber,
#
#-----[ FIND ]------------------------------------------------
#
'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_JABBER' => $lang['JABBER'],
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
$lang['JABBER'] = 'Jabber ID';
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
Jabber ID: {JABBER}
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
 {JABBER_IMG}
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
	  <td class="row1"><span class="gen">{L_JABBER}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="jabber" size="20" maxlength="255" value="{JABBER}" />
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
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_JABBER}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{JABBER}</span></td>
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
$images['icon_jabber'] = "$current_template_images/{LANG}/icon_jabber.gif";
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
 {postrow.JABBER_IMG}
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
	  <td class="row1"><span class="gen">{L_JABBER}</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="jabber" size="20" maxlength="255" value="{JABBER}" />
	  </td>
	</tr>
#
#-----[ SQL ]-------------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_jabber` VARCHAR( 255 ) DEFAULT NULL;
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
