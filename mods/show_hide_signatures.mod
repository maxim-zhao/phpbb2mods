##############################################################
## MOD Title: Show/hide signatures
## MOD Author: Stijn Herreman < stijn@shproductions.be > (Stijn Herreman) http://phpbb.shproductions.be/
## MOD Description: Users can choose wether to show or hide signatures. Useful for dial-up users.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: viewtopic.php,
##      includes/usercp_register.php,
##      language/lang_english/lang_main.php
##      templates/subSilver/profile_add_body.tpl
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
## Author Notes: Idea of somebody from a forum I visit.
##      Immediately started this MOD. Great idea.
##
##############################################################
## MOD History:
##
##   2007-01-07 - Version 1.0.0
##      - MOD is finished.
##      - Submitting it to MOD Database.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
# Note: table names can be different in your database
#
INSERT INTO `phpbb_config` ( `config_name` , `config_value` )
VALUES (
'show_signatures', '1'
);

ALTER TABLE `phpbb_users` ADD `user_showsignatures` TINYINT( 1 ) NOT NULL DEFAULT '1';

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
		'SIGNATURE' => $user_sig,

#
#-----[ REPLACE WITH ]------------------------------------------
#
		'SIGNATURE' => ($userdata['user_showsignatures'] == 1) ? $user_sig : "",

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
		$attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $board_config['allow_sig'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$showsignatures = ( isset($HTTP_POST_VARS['showsignatures']) ) ? ( ($HTTP_POST_VARS['showsignatures']) ? TRUE : 0 ) : $board_config['showsignatures'];

#
#-----[ FIND ]------------------------------------------
#
		$attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $userdata['user_attachsig'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$showsignatures = ( isset($HTTP_POST_VARS['showsignatures']) ) ? ( ($HTTP_POST_VARS['showsignatures']) ? TRUE : 0 ) : $userdata['showsignatures'];

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_sig_bbcode_uid = '$signature_bbcode_uid', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_notify_pm = $notifypm, user_popup_pm = $popup_pm, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_active = $user_active, user_actkey = '" . str_replace("\'", "''", $user_actkey) . "'" . $avatar_sql . "

#
#-----[ REPLACE WITH ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_sig_bbcode_uid = '$signature_bbcode_uid', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_showsignatures = $showsignatures, user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_notify_pm = $notifypm, user_popup_pm = $popup_pm, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_active = $user_active, user_actkey = '" . str_replace("\'", "''", $user_actkey) . "'" . $avatar_sql . "

#
#-----[ FIND ]------------------------------------------
#
				VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $location) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $signature) . "', '$signature_bbcode_uid', $avatar_sql, $viewemail, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $notifypm, $popup_pm, $user_timezone, '" . str_replace("\'", "''", $user_dateformat) . "', '" . str_replace("\'", "''", $user_lang) . "', $user_style, 0, 1, ";

#
#-----[ REPLACE WITH ]------------------------------------------
#
				VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $location) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $signature) . "', '$signature_bbcode_uid', $avatar_sql, $viewemail, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, $showsignatures, $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $notifypm, $popup_pm, $user_timezone, '" . str_replace("\'", "''", $user_dateformat) . "', '" . str_replace("\'", "''", $user_lang) . "', $user_style, 0, 1, ";

#
#-----[ FIND ]------------------------------------------
#
	$attachsig = $userdata['user_attachsig'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$showsignatures = $userdata['user_showsignatures'];

#
#-----[ FIND ]------------------------------------------
#
	display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email, $coppa, $username, $email, $new_password, $cur_password, $password_confirm, $icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature, $viewemail, $notifypm, $popup_pm, $notifyreply, $attachsig, $allowhtml, $allowbbcode, $allowsmilies, $allowviewonline, $user_style, $user_lang, $user_timezone, $user_dateformat, $userdata['session_id']);

#
#-----[ REPLACE WITH ]------------------------------------------
#
	display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email, $coppa, $username, $email, $new_password, $cur_password, $password_confirm, $icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature, $showsignatures, $viewemail, $notifypm, $popup_pm, $notifyreply, $attachsig, $allowhtml, $allowbbcode, $allowsmilies, $allowviewonline, $user_style, $user_lang, $user_timezone, $user_dateformat, $userdata['session_id']);

#
#-----[ FIND ]------------------------------------------
#
		'ALWAYS_ADD_SIGNATURE_NO' => ( !$attachsig ) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'ALWAYS_SHOW_SIGNATURES_YES' => ( $showsignatures ) ? 'checked="checked"' : '',
		'ALWAYS_SHOW_SIGNATURES_NO' => ( !$showsignatures ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#
		'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_ALWAYS_SHOW_SIGNATURES' => $lang['Always_show_signatures'],

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Always_add_sig'] = 'Always attach my signature';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Always_show_signatures'] = 'Always show signatures';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		<input type="radio" name="attachsig" value="0" {ALWAYS_ADD_SIGNATURE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_SHOW_SIGNATURES}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="showsignatures" value="1" {ALWAYS_SHOW_SIGNATURES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="showsignatures" value="0" {ALWAYS_SHOW_SIGNATURES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM