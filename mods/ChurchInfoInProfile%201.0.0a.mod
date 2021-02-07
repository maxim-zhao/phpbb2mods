##############################################################
## MOD Title: Church Info in Profile
## MOD Author: theophilus < churchwebmaster@gmail.com > (Mike Marshall) N/A
## MOD Description: Adds spots in profile for the users church, church website & denomination
## MOD Version: 1.0.0
##
## Installation Level: (Intermediate)
## Installation Time: 15 Minutes
## Files To Edit: language/lang_english/lang_main.php
##                admin/admin_users.php
##                includes/functions_validate.php
##                includes/usercp_avatar.php
##                includes/usercp_register.php
##                includes/usercp_viewprofile.php
##                templates/subSilver/admin/user_edit_body.tpl
##                templates/subSilver/SubSilver.cfg
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/profile_view_body.tpl
## Included Files: None
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
##	This is my first mod.  I was wanting to personalize a site I had built and
##	there wasn't a mod like this, so I made this once based roughly off of the 
##	phpBB GTalk Mod by ptlis and the SecondWebsite Mod by romihaitza.
##
##	This has been tested with phpBB 2.0.21 only, although I would imagine it
##	should install sucessfully on previous and/or future revisions of the
##	2.0.xx release.
##
##	This modification is Free software; you can redistribute it and/or
##	modify it under the terms of the GNU General Public License as published
##	by the Free Software Foundation; either version 2 of the License, or (at
##	your option) any later version.
##
##############################################################
## MOD History:
##
##	2006-06-12 - Version 1.0.0
##		-Changes in code to fix bug
##	2006-06-11 - Version 0.9.0
##		-Updated to work with version 2.0.21
##		-Fixed errors noted by phpbb mod team
##	2006-05-30 - Version 0.8.1
##		-Cleaned up code and updated to work with version 2.0.20
##	2006-05-27 - Version 0.8.0
##		-Initial release of this mod
##		-Submitted to phpbb.com mod team
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#
#-----[ SQL ]-------------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_church` VARCHAR( 255 ) NULL;
ALTER TABLE `phpbb_users` ADD `user_chweb` VARCHAR( 255 ) NULL;
ALTER TABLE `phpbb_users` ADD `user_chdenom` VARCHAR( 255 ) NULL;
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
, &$interests
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, &$church, &$chweb, &$chdenom
#
#-----[ FIND ]------------------------------------------------
#
$check_var_length = array(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'interests'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, 'church', 'chweb', 'chdenom'
#
#-----[ FIND ]------------------------------------------------
#
	// website has to start with http://, followed by something with length at least 3 that
	// contains at least one dot.
	if ($website != "")
	{
		if (!preg_match('#^http[s]?:\/\/#i', $website))
		{
			$website = 'http://' . $website;
		}

		if (!preg_match('#^http[s]?\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $website))
		{
			$website = '';
		}
	}
#
#-----[ AFTER, ADD ]------------------------------------------
#
	if ($chweb != "")
	{
		if (!preg_match('#^http[s]?:\/\/#i', $chweb))
		{
			$chweb = 'http://' . $chweb;
		}

		if (!preg_match('#^http[s]?\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i', $chweb))
		{
			$chweb = '';
		}
	}
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
, &$interests
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, &$church, &$chweb, &$chdenom
#
#-----[ FIND ]------------------------------------------------
#
$params = array('coppa', 'user_id', 'username', 'email', 'current_email',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'interests'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, 'church', 'chweb', 'chdenom'
#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------------
#
$strip_var_list = array('email' => 'email',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, 'interests' => 'interests'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, 'church' => 'church', 'chweb' => 'chweb', 'chdenom' => 'chdenom'
#
#-----[ FIND ]------------------------------------------------
#
validate_optional_fields(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $interests
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $church, $chweb, $chdenom
#
#-----[ FIND ]------------------------------------------------
#
		$interests = stripslashes($interests);
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$church = stripslashes($church);
		$chweb = stripslashes($chweb);
		$chdenom = stripslashes($chdenom);
#
#-----[ FIND ]------------------------------------------
#
if ( $website != '' )
   {
      rawurlencode($website);
   }
#
#-----[ AFTER, ADD ]------------------------------------------
#
if ( $chweb != '' )
   {
      rawurlencode($chweb);
   }

#
#-----[ FIND ]------------------------------------------------
#
SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_interests = '" . str_replace("\'", "''", $interests) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_church = '" . str_replace("\'", "''", $church) . "', user_chweb = '" . str_replace("\'", "''", $chweb) . "', user_chdenom = '" . str_replace("\'", "''", $chdenom) . "'
#
#-----[ FIND ]------------------------------------------------
#
$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password, user_email, 
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_interests
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_church, user_chweb, user_chdenom
#
#-----[ FIND ]------------------------------------------------
#
VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, '" . str_replace("\'", "''", $interests) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, '" . str_replace("\'", "''", $church) . "', '" . str_replace("\'", "''", $chweb) . "', '" . str_replace("\'", "''", $chdenom) . "'
#
#-----[ FIND ]------------------------------------------------
#
					'INTERESTS' => $interests,
#
#-----[ AFTER, ADD ]------------------------------------------
#
					'CHURCH' => $church,
					'CHWEB' => $chweb,
					'CHDENOM' => $chdenom, 
#
#-----[ FIND ]------------------------------------------------
#
	$interests = stripslashes($interests);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	$church = stripslashes($church);
	$chweb = stripslashes($chweb);
	$chdenom = stripslashes($chdenom);
#
#-----[ FIND ]------------------------------------------------
#
	$interests = $userdata['user_interests'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	$church = $userdata['user_church'];
	$chweb = $userdata['user_chweb'];
	$chdenom = $userdata['user_chdenom'];
#
#-----[ FIND ]------------------------------------------------
#
display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $interests
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $church, $chweb, $chdenom
#
#-----[ FIND ]------------------------------------------------
#
		'INTERESTS' => $interests,
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'CHURCH' => $church,
		'CHWEB' => $chweb,
		'CHDENOM' => $chdenom,
#
#-----[ FIND ]------------------------------------------------
#
		'L_INTERESTS' => $lang['Interests'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_CHURCH' => $lang['Church'],
		'L_CHWEB' => $lang['Chweb'],
		'L_CHDENOM' => $lang['Chdenom'],
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
$church = ( $profiledata['user_church'] ) ? $profiledata['user_church'] : '&nbsp;';
$chweb = ( $profiledata['user_chweb'] ) ? '<a href="' . $profiledata['user_chweb'] . '" target="_userchweb">' . $profiledata['user_chweb'] . '</a>' : '&nbsp;';
$chdenom = ( $profiledata['user_chdenom'] ) ? $profiledata['user_chdenom'] : '&nbsp;';
#
#-----[ FIND ]------------------------------------------------
#
	'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'CHURCH' => $church,
	'CHWEB' => $chweb,
	'CHDENOM' => $chdenom,
#
#-----[ FIND ]------------------------------------------------
#
	'L_INTERESTS' => $lang['Interests'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_CHURCH' => $lang['Church'],
	'L_CHWEB' => $lang['Chweb'],
	'L_CHDENOM' => $lang['Chdenom'],
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
$lang['Church'] = 'Local Church';
$lang['Chweb'] = 'Church Website';
$lang['Chdenom'] = 'Denomination';
#
#-----[ OPEN ]------------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------------
#
		$interests = ( !empty($HTTP_POST_VARS['interests']) ) ? trim(strip_tags( $HTTP_POST_VARS['interests'] ) ) : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$church = ( !empty($HTTP_POST_VARS['church']) ) ? trim(strip_tags( $HTTP_POST_VARS['church'] ) ) : '';
		$chweb = ( !empty($HTTP_POST_VARS['chweb']) ) ? trim(strip_tags( $HTTP_POST_VARS['chweb'] ) ) : '';
		$chdenom = ( !empty($HTTP_POST_VARS['chdenom']) ) ? trim(strip_tags( $HTTP_POST_VARS['chdenom'] ) ) : '';
#
#-----[ FIND ]------------------------------------------------
#
validate_optional_fields(
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, $interests
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $church, $chweb, $chdenom
#
#-----[ FIND ]------------------------------------------------
#
			$interests = htmlspecialchars(stripslashes($interests));
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$church = htmlspecialchars(stripslashes($church));
			$chweb = htmlspecialchars(stripslashes($chweb));
			$chdenom = htmlspecialchars(stripslashes($chdenom));
#
#-----[ FIND ]------------------------------------------------
#
SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "',
#
#-----[ IN-LINE FIND ]----------------------------------------
#
, user_interests = '" . str_replace("\'", "''", $interests) . "'
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, user_church = '" . str_replace("\'", "''", $church) . "', user_chweb = '" . str_replace("\'", "''", $chweb) . "', user_chdenom = '" . str_replace("\'", "''", $chdenom) . "'
#
#-----[ FIND ]------------------------------------------------
#
			$interests = htmlspecialchars(stripslashes($interests));
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$church = htmlspecialchars(stripslashes($church));
			$chweb = htmlspecialchars(stripslashes($chweb));
			$chdenom = htmlspecialchars(stripslashes($chdenom));
#
#------[ FIND ]-----------------------------------------------
#
		$interests = htmlspecialchars($this_userdata['user_interests']);
#
#------[ AFTER, ADD ]-----------------------------------------
#
		$church = htmlspecialchars($this_userdata['user_church']);
		$chweb = htmlspecialchars($this_userdata['user_chweb']);
		$chdenom = htmlspecialchars($this_userdata['user_chdenom']);
#
#-----[ FIND ]------------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="interests" value="' . str_replace("\"", "&quot;", $interests) . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="church" value="' . str_replace("\"", "&quot;", $church) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="chweb" value="' . str_replace("\"", "&quot;", $chweb) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="chdenom" value="' . str_replace("\"", "&quot;", $chdenom) . '" />';
#
#-----[ FIND ]------------------------------------------------
#
			'INTERESTS' => $interests,
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'CHURCH' => $church,
			'CHWEB' => $chweb,
			'CHDENOM' => $chdenom,
#
#-----[ FIND ]------------------------------------------------
#
			'L_INTERESTS' => $lang['Interests'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_CHURCH' => $lang['Church'],
			'L_CHWEB' => $lang['Chweb'],
			'L_CHDENOM' => $lang['Chdenom'],
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="interests" size="35" maxlength="150" value="{INTERESTS}" />
	  </td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	</tr>
		<tr> 
	  <td class="row1"><span class="gen">{L_CHURCH}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="church" size="35" maxlength="150" value="{CHURCH}" />
	  </td>
	</tr>
		<tr> 
	  <td class="row1"><span class="gen">{L_CHWEB}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="chweb" size="35" maxlength="150" value="{CHWEB}" />
	  </td>
	</tr>
		<tr> 
	  <td class="row1"><span class="gen">{L_CHDENOM}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="chdenom" size="35" maxlength="150" value="{CHDENOM}" />
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
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
		  <td> <b><span class="gen">{INTERESTS}</span></b></td>
		</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
				<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_CHURCH}:</span></td>
		  <td> <b><span class="gen">{CHURCH}</span></b></td>
		</tr>
				<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_CHWEB}:</span></td>
		  <td> <b><span class="gen">{CHWEB}</span></b></td>
		</tr>
				<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_CHDENOM}:</span></td>
		  <td> <b><span class="gen">{CHDENOM}</span></b></td>
		</tr>
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
      <td class="row1"><span class="gen">{L_CHURCH}</span></td>
      <td class="row2">
        <input class="post" type="text" name="church" size="20" maxlength="255" value="{church}" />
      </td>
    </tr>
        <tr>
      <td class="row1"><span class="gen">{L_CHWEB}</span></td>
      <td class="row2">
        <input class="post" type="text" name="chweb" size="20" maxlength="255" value="{CHWEB}" />
      </td>
    </tr>
        <tr>
      <td class="row1"><span class="gen">{L_CHDENOM}</span></td>
      <td class="row2">
        <input class="post" type="text" name="chdenom" size="20" maxlength="255" value="{CHDENOM}" />
      </td>
    </tr>
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
