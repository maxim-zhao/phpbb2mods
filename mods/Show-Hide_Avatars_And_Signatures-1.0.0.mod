##############################################################
## MOD Title: Show-Hide Avatars And Signatures
## MOD Author: C2 < n/a > (n/a) n/a
## MOD Description: This mod will give each user the option to show, or hide, signatures and avatars on the entire forum.
##                  In other words, if a user choses the options to hide signatures and avatars they will see no signatures and avatars used by anyone including themselves.
##                  Each user can set the options in their profile, or the site admin can do so for users via the ACP.
##                  Options:
##                  - Signatures: yes / yes, no images / no
##                  - Avatars: yes / no
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 23 minutes by hand, 1 minute with EasyMOD :)
## Files To Edit: posting.php
## privmsg.php
## viewtopic.php
## admin/admin_users.php
## includes/usercp_avatar.php
## includes/usercp_register.php
## includes/usercp_viewprofile.php
## language/lang_english/lang_main.php
## templates/subSilver/admin/user_edit_body.tpl
## templates/subSilver/profile_add_body.tpl
## 
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: Phpbb.ModTeam.Tools
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: You must disable the Avatar Gallery in the ACP for this mod to work. 
## Failure to do so will result in no avatars or signatures being shown regardless of the options selected in the user profile.
##############################################################
## MOD History:
## 
## 2006-12-30 - Version 0.5.0 Added easy mod compatible SQL and removed the need for the db_update.php file.
##
## 2006-12-29 - Version 0.4.0 Rewritten in Mod Studio to be easy mod compatible.
## 
## 2006-12-29 - Version 0.3.0 Added authors notes & cleaned up instructions. 
## 
## 2006-12-28 - Version 0.2.0 Partially corrected the Avatar Gallery bug. 
## 
## 2006-12-27 - Version 0.1.0 First release & attempt to fix gallery bug. C2 *a.k.a.* WWX
##                            (Freakin' Booty ;-P) wrote the first mod entitled (Dis)allow signatures and avatars for phpBB version 2.0.0 in 2003. 
##                            I borrowed, corrected, updated, and modified that code to work in 2.0.21 in 2005 and decided to release it in 2006 in the hopes of correcting the avatar gallery bug.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
Sign in as administrator and, in the configuration section of the ACP, set Enable Gallery Avatars to NO.
#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_users ADD COLUMN user_sh_sig tinyint(1) default '1'; 
ALTER TABLE phpbb_users ADD COLUMN user_sh_avatar tinyint(1) default '1';

#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
		//
		// Finalise processing as per viewtopic
		//
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$user_sig = ( $userdata['user_sh_sig'] == 2 ) ? preg_replace ('#((\r)+?(\n)+?)*(\[url(:'.$userdata['user_sig_bbcode_uid'].')?(.*)\])?\[img:'.$userdata['user_sig_bbcode_uid'].'\](.+)\[/img:'.$userdata['user_sig_bbcode_uid'].'\](\[/url(:'.$userdata['user_sig_bbcode_uid'].')?\])?#i', '', $user_sig) : ( ($userdata['user_sh_sig'] == 1) ? $user_sig : '' );

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------
#
	$sql = "SELECT u.username AS username_1
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_avatar
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_sh_sig
#
#-----[ FIND ]------------------------------------------
#
	$user_sig_bbcode_uid = ( $privmsg['privmsgs_from_userid'] == $userdata['user_id'] ) ? $userdata['user_sig_bbcode_uid'] : $privmsg['user_sig_bbcode_uid'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
	//
	// Allow signatures? No (0) -- Yes (1) -- Yes, no images (2)
	//
	$user_sig = ( $userdata['user_sh_sig'] == 2 ) ? preg_replace ('#((\r)+?(\n)+?)*\[img:'.$user_sig_bbcode_uid.'\](.*?)\[/img:'.$user_sig_bbcode_uid.'\]#i', '', $user_sig) : ( ($userdata['user_sh_sig'] == 1) ? $user_sig : '' );

#
#-----[ FIND ]------------------------------------------
#
		//
		// Finalise processing as per viewtopic
		//
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$user_sig = ( $userdata['user_sh_sig'] == 2 ) ? preg_replace ('#((\r)+?(\n)+?)*(\[url(:'.$userdata['user_sig_bbcode_uid'].')?(.*)\])?\[img:'.$userdata['user_sig_bbcode_uid'].'\](.+)\[/img:'.$userdata['user_sig_bbcode_uid'].'\](\[/url(:'.$userdata['user_sig_bbcode_uid'].')?\])?#i', '', $user_sig) : ( ($userdata['user_sh_sig'] == 1) ? $user_sig : '' );

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT u.username,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_allowsmile
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_sh_sig, u.user_sh_avatar
#
#-----[ FIND ]------------------------------------------
#
	if ( $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] )

#
#-----[ REPLACE WITH ]------------------------------------------
#
	if ( $userdata['user_sh_avatar'] && $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] )

#
#-----[ FIND ]------------------------------------------
#
	$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	//
	// Allow signatures? No (0) -- Yes (1) -- Yes, no images (2)
	//
	$user_sig = ( $userdata['user_sh_sig'] == 2 ) ? preg_replace('#((\r)+?(\n)+?)*(\[url(:'.$user_sig_bbcode_uid.')?(.*)\])?\[img:'.$user_sig_bbcode_uid.'\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img:'.$user_sig_bbcode_uid.'\](\[/url(:'.$user_sig_bbcode_uid.')?\])?#i', '', $user_sig) : ( ($userdata['user_sh_sig'] == 1) ? $user_sig : '' );

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
#
		$popuppm = ( isset( $HTTP_POST_VARS['popup_pm']) ) ? ( ( $HTTP_POST_VARS['popup_pm'] ) ? TRUE : 0 ) : TRUE;

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$user_sh_sig = ( isset($HTTP_POST_VARS['user_sh_sig']) ) ? intval( $HTTP_POST_VARS['user_sh_sig'] ) : 1;
		$user_sh_avatar = ( isset($HTTP_POST_VARS['user_sh_avatar']) ) ? intval( $HTTP_POST_VARS['user_sh_avatar'] ) : 1;

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_popup_pm = $popuppm
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_sh_sig = $user_sh_sig, user_sh_avatar = $user_sh_avatar
#
#-----[ FIND ]------------------------------------------
#
		$popuppm = $this_userdata['user_popup_pm'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$user_sh_sig = $this_userdata['user_sh_sig'];
		$user_sh_avatar = $this_userdata['user_sh_avatar'];

#
#-----[ FIND ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="popup_pm" value="' . $popuppm . '" />';

#
#-----[ AFTER, ADD ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="user_sh_sig" value="' . $user_sh_sig . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_sh_avatar" value="' . $user_sh_avatar . '" />';

#
#-----[ FIND ]------------------------------------------
#
			'POPUP_PM_NO' => (!$popuppm) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#
			'ALWAYS_ALLOW_SIGNATURES_YES' => ( $user_sh_sig == 1 ) ? 'checked="checked"' : '',
			'ALWAYS_ALLOW_SIGNATURES_NO' => ( $user_sh_sig == 0 ) ? 'checked="checked"' : '',
			'ALWAYS_ALLOW_SIGNATURES_NO_IMG' => ( $user_sh_sig == 2 ) ? 'checked="checked"' : '',
			'ALWAYS_ALLOW_AVATARS_YES' => ( $user_sh_avatar ) ? 'checked="checked"' : '',
			'ALWAYS_ALLOW_AVATARS_NO' => ( !$user_sh_avatar ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#
			'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_ALWAYS_ALLOW_SIGNATURES' => $lang['Always_allow_signatures'],
			'L_ALWAYS_ALLOW_SIGNATURES_NO_IMG' => $lang['Always_allow_signatures_no_img'],
			'L_ALWAYS_ALLOW_AVATARS' => $lang['Always_allow_avatars'],

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]------------------------------------------
#
function display_avatar_gallery
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$allowsmilies
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$user_sh_sig, &$user_sh_avatar
#
#-----[ FIND ]------------------------------------------
#
	$params = array
#
#-----[ IN-LINE FIND ]------------------------------------------
#
'allowsmilies'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'user_sh_sig', 'user_sh_avatar'

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------
#
	$popup_pm = ( isset($HTTP_POST_VARS['popup_pm']) ) ? ( ($HTTP_POST_VARS['popup_pm']) ? TRUE : 0 ) : TRUE;

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$user_sh_sig = ( isset($HTTP_POST_VARS['user_sh_sig']) ) ? intval( $HTTP_POST_VARS['user_sh_sig'] ) : 1;
	$user_sh_avatar = ( isset($HTTP_POST_VARS['user_sh_avatar']) ) ? intval( $HTTP_POST_VARS['user_sh_avatar'] ) : 1;

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_popup_pm = $popup_pm
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_sh_sig = $user_sh_sig, user_sh_avatar = $user_sh_avatar
#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . USERS_TABLE . "

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_popup_pm
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_sh_sig, user_sh_avatar
#
#-----[ FIND ]------------------------------------------
#
				VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $location) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $signature) . "', '$signature_bbcode_uid', $avatar_sql, $viewemail, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $notifypm, $popup_pm, $user_timezone, '" . str_replace("\'", "''", $user_dateformat) . "', '" . str_replace("\'", "''", $user_lang) . "', $user_style, 0, 1, ";

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $popup_pm
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $user_sh_sig, $user_sh_avatar
#
#-----[ FIND ]------------------------------------------
#
	$popup_pm = $userdata['user_popup_pm'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$user_sh_sig = $userdata['user_sh_sig'];
	$user_sh_avatar = $userdata['user_sh_avatar'];

#
#-----[ FIND ]------------------------------------------
#
	display_avatar_gallery
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $popup_pm
#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, $user_sh_sig, $user_sh_avatar
#
#-----[ FIND ]------------------------------------------
#
		'POPUP_PM_NO' => ( !$popup_pm ) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'ALWAYS_ALLOW_SIGNATURES_YES' => ( $user_sh_sig == 1 ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_SIGNATURES_NO' => ( $user_sh_sig == 0 ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_SIGNATURES_NO_IMG' => ( $user_sh_sig == 2 ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_AVATARS_YES' => ( $user_sh_avatar ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_AVATARS_NO' => ( !$user_sh_avatar ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#
		'L_POPUP_ON_PRIVMSG_EXPLAIN' => $lang['Popup_on_privmsg_explain'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_ALWAYS_ALLOW_SIGNATURES' => $lang['Always_allow_signatures'],
		'L_ALWAYS_ALLOW_SIGNATURES_NO_IMG' => $lang['Always_allow_signatures_no_img'],
		'L_ALWAYS_ALLOW_AVATARS' => $lang['Always_allow_avatars'],

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------
#
if ( $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )

#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( $userdata['user_sh_avatar'] && $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Show-Hide Avatars & Signatures
//
$lang['Always_allow_signatures'] = 'Allow signatures';
$lang['Always_allow_signatures_no_img'] = 'Yes, but no images';
$lang['Always_allow_avatars'] = 'Allow avatars';
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SIGNATURES}</span></td>
	  <td class="row2"><span class="gen"><input type="radio" name="user_sh_sig" value="1" {ALWAYS_ALLOW_SIGNATURES_YES} />{L_YES} &nbsp;&nbsp; <input type="radio" name="user_sh_sig" value="2" {ALWAYS_ALLOW_SIGNATURES_NO_IMG} /> {L_ALWAYS_ALLOW_SIGNATURES_NO_IMG} &nbsp;&nbsp; <input type="radio" name="user_sh_sig" value="0" {ALWAYS_ALLOW_SIGNATURES_NO} />{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_AVATARS}</span></td>
	  <td class="row2"><span class="gen"><input type="radio" name="user_sh_avatar" value="1" {ALWAYS_ALLOW_AVATARS_YES} />{L_YES} &nbsp;&nbsp; <input type="radio" name="user_sh_avatar" value="0" {ALWAYS_ALLOW_AVATARS_NO} />{L_NO}</span></td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SIGNATURES}:</span></td>
	  <td class="row2">
		<input type="radio" name="user_sh_sig" value="1" {ALWAYS_ALLOW_SIGNATURES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_sh_sig" value="2" {ALWAYS_ALLOW_SIGNATURES_NO_IMG} />
		<span class="gen">{L_ALWAYS_ALLOW_SIGNATURES_NO_IMG}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_sh_sig" value="0" {ALWAYS_ALLOW_SIGNATURES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_AVATARS}:</span></td>
	  <td class="row2">
		<input type="radio" name="user_sh_avatar" value="1" {ALWAYS_ALLOW_AVATARS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_sh_avatar" value="0" {ALWAYS_ALLOW_AVATARS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
