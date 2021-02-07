##############################################################
## MOD Title: SQR 1.3.0 to SQR 1.3.1 Code Changes
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: Changes from Super Quick Reply 1.3.0 to 1.3.1
##
## MOD Version: 1.0.0
##
## Installation Level: Intermediate
## Installation Time: 5 Minute
## Files To Edit: admin/admin_board.php
##                admin/admin_users.php
##                includes/usercp_avatar.php
##                includes/usercp_register.php
##                includes/viewtopic_quickreply.php
##                language/lang_english/lang_admin.php
##                language/lang_english/lang_main.php
##                templates/subSilver/admin/board_config_body.tpl
##                templates/subSilver/admin/user_edit_body.tpl
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/viewtopic_quickreply.tpl
##                viewtopic.php
##
##
## Included Files: (n/a)
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
## phpBB 2.0.15 compatible.
##
## This MOD will install using EasyMOD.
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-07-01 - Version 1.0.0
##      - initial public version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
$avatars_local_yes = ( $new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";

#
#-----[ BEFORE, ADD ]--------------------------------------
#
$anonymous_open_sqr_yes = ( $new['anonymous_open_sqr'] ) ? "checked=\"checked\"" : "";
$anonymous_open_sqr_no = ( !$new['anonymous_open_sqr'] ) ? "checked=\"checked\"" : "";

#
#-----[ FIND ]------------------------------------------
#
"L_ANONYMOUS_SQR_MODE_ADVANCED" => $lang['Quick_reply_mode_advanced'],

#
#-----[ AFTER, ADD ]--------------------------------------
#
	"L_ANONYMOUS_OPEN_SQR" => $lang['Anonymous_open_SQR'],

#
#-----[ FIND ]------------------------------------------
#
"ANONYMOUS_SQR_MODE_ADVANCED" => $anonymous_sqr_mode_advanced,

#
#-----[ AFTER, ADD ]--------------------------------------
#
	"ANONYMOUS_OPEN_SQR_YES" => $anonymous_open_sqr_yes,
	"ANONYMOUS_OPEN_SQR_NO" => $anonymous_open_sqr_no,

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
#		$user_quickreply_mode = ( isset( $HTTP_POST_VARS['quickreply_mode'] ) ) ? ( ( $HTTP_POST_VARS['quickreply_mode'] ) ? TRUE : 0 ) : TRUE;
$user_quickreply_mode = ( isset( $HTTP_POST_VARS['quickreply_mode'] ) )

#
#-----[ AFTER, ADD ]--------------------------------------
#
		$user_open_quickreply = ( isset( $HTTP_POST_VARS['open_quickreply'] ) ) ? ( ( $HTTP_POST_VARS['open_quickreply'] ) ? TRUE : 0 ) : TRUE;

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
#   SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", $aim) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_sig_bbcode_uid = '$signature_bbcode_uid', user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowavatar = $user_allowavatar, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_allow_pm = $user_allowpm, user_notify_pm = $notifypm, user_popup_pm = $popuppm, user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_active = $user_status, user_rank = $user_rank" . $avatar_sql . "
SET " . $username_sql . $passwd_sql

#
#-----[ IN-LINE FIND ]------------------------------------------
#
 user_active = $user_status,

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
 user_open_quickreply = $user_open_quickreply,

#
#-----[ FIND ]------------------------------------------
#
$user_show_quickreply = $userdata['user_show_quickreply'];

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$userdata

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$this_userdata

#
#-----[ FIND ]------------------------------------------
#
$user_quickreply_mode = $userdata['user_quickreply_mode'];

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$userdata

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$this_userdata

#
#-----[ AFTER, ADD ]--------------------------------------
#
		$user_open_quickreply = $this_userdata['user_open_quickreply'];

#
#-----[ FIND ]------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="quickreply_mode" value="' . $user_quickreply_mode . '" />';

#
#-----[ AFTER, ADD ]--------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="open_quickreply" value="' . $user_quickreply_mode . '" />';

#
#-----[ FIND ]------------------------------------------
#
'QUICK_REPLY_MODE_ADVANCED' => ( $user_quickreply_mode!=0 ) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]--------------------------------------
#
			'OPEN_QUICK_REPLY_YES' => ( $user_open_quickreply ) ? 'checked="checked"' : '',
			'OPEN_QUICK_REPLY_NO' => ( !$user_open_quickreply ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#
'L_QUICK_REPLY_MODE_ADVANCED' => $lang['Quick_reply_mode_advanced'],

#
#-----[ AFTER, ADD ]--------------------------------------
#
			'L_OPEN_QUICK_REPLY' => $lang['Open_quick_reply'],

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# function display_avatar_gallery($mode, &$category, &$user_id, &$email, &$current_email, &$coppa, &$username, &$email, &$new_password, &$cur_password, &$password_confirm, &$icq, &$aim, &$msn, &$yim, &$website, &$location, &$occupation, &$interests, &$signature, &$viewemail, &$notifypm, &$popup_pm, &$notifyreply, &$attachsig, &$allowhtml, &$allowbbcode, &$allowsmilies, &$hideonline, &$style, &$language, &$timezone, &$dateformat, &$show_quickreply, &$quickreply_mode, &$session_id)
function display_avatar_gallery

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, &$session_id

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, &$user_open_quickreply

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# $params = array('coppa', 'user_id', 'username', 'email', 'current_email', 'cur_password', 'new_password', 'password_confirm', 'icq', 'aim', 'msn', 'yim', 'website', 'location', 'occupation', 'interests', 'signature', 'viewemail', 'notifypm', 'popup_pm', 'notifyreply', 'attachsig', 'allowhtml', 'allowbbcode', 'allowsmilies', 'hideonline', 'style', 'language', 'timezone', 'dateformat', &$show_quickreply, &$quickreply_mode);
$params = array

#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$show_quickreply

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
'show_quickreply'


#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$quickreply_mode

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
'quickreply_mode'

#
#-----[ IN-LINE FIND ]------------------------------------------
#
);

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, 'user_open_quickreply'

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
#	$user_quickreply_mode = ( isset( $HTTP_POST_VARS['quickreply_mode'] ) ) ? ( ( $HTTP_POST_VARS['quickreply_mode'] ) ? TRUE : 0 ) : TRUE;
$user_quickreply_mode = ( isset( $HTTP_POST_VARS['quickreply_mode'] ) )

#
#-----[ AFTER, ADD ]--------------------------------------
#
	$user_open_quickreply = ( isset( $HTTP_POST_VARS['open_quickreply'] ) ) ? ( ( $HTTP_POST_VARS['open_quickreply'] ) ? TRUE : 0 ) : TRUE;

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_sig_bbcode_uid = '$signature_bbcode_uid', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_notify_pm = $notifypm, user_popup_pm = $popup_pm, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_active = $user_active, user_actkey = '" . str_replace("\'", "''", $user_actkey) . "'" . $avatar_sql . "
SET " . $username_sql . $passwd_sql . "user_email =

#
#-----[ IN-LINE FIND ]------------------------------------------
#
 user_lang = '" . str_replace("\'", "''", $user_lang)

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
 user_open_quickreply = $user_open_quickreply,

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# $sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_sig_bbcode_uid, user_avatar, user_avatar_type, user_viewemail, user_aim, user_yim, user_msnm, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_timezone, user_dateformat, user_lang, user_style, user_level, user_allow_pm, user_active, user_actkey)
$sql = "INSERT INTO " . USERS_TABLE .

#
#-----[ IN-LINE FIND ]------------------------------------------
#
 user_lang,

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
 user_open_quickreply,

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $location) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $signature) . "', '$signature_bbcode_uid', $avatar_sql, $viewemail, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $notifypm, $popup_pm, $user_timezone, '" . str_replace("\'", "''", $user_dateformat) . "', '" . str_replace("\'", "''", $user_lang) . "', $user_style, 0, 1, ";
VALUES ($user_id, '" . str_replace("\'", "''", $username)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
 '" . str_replace("\'", "''", $user_lang)

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
 $user_open_quickreply,

#
#-----[ FIND ]------------------------------------------
#
$user_quickreply_mode = $userdata['user_quickreply_mode'];

#
#-----[ AFTER, ADD ]--------------------------------------
#
	$user_open_quickreply = $userdata['user_open_quickreply'];

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email, $coppa, $username, $email, &$new_password, &$cur_password, $password_confirm, $icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature, $viewemail, $notifypm, $popup_pm, $notifyreply, $attachsig, $allowhtml, $allowbbcode, $allowsmilies, $allowviewonline, $user_style, $user_lang, $user_timezone, $user_dateformat, $userdata['session_id']);
display_avatar_gallery($mode,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $userdata['session_id']

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, $user_open_quickreply

#
#-----[ FIND ]------------------------------------------
#
'QUICK_REPLY_MODE_ADVANCED' => ( $user_quickreply_mode!=0 ) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]--------------------------------------
#
		'OPEN_QUICK_REPLY_YES' => ( $user_open_quickreply ) ? 'checked="checked"' : '',
		'OPEN_QUICK_REPLY_NO' => ( !$user_open_quickreply ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#
'L_QUICK_REPLY_MODE_ADVANCED' => $lang['Quick_reply_mode_advanced'],

#
#-----[ AFTER, ADD ]--------------------------------------
#
		'L_OPEN_QUICK_REPLY' => $lang['Open_quick_reply'],

#
#-----[ OPEN ]------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------
#
$template->assign_vars(array(
'U_POST_SQR_TOPIC' => 'javascript:sqr_show_hide();',

#
#-----[ BEFORE, ADD ]--------------------------------------
#
if ( (($userdata['user_open_quickreply']==1) && ($userdata['user_id'] != ANONYMOUS)) || (($board_config['anonymous_open_sqr']==1) && ($userdata['user_id'] == ANONYMOUS)) )
{
	$template->assign_block_vars('switch_open_qr_yes', array());
}
else
{
	$template->assign_block_vars('switch_open_qr_no', array());
}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Anonymous_show_SQR']

#
#-----[ REPLACE WITH ]--------------------------------------
#
$lang['Anonymous_show_SQR'] = 'Show Quick Reply Form to Anonymous Users';

#
#-----[ FIND ]------------------------------------------
#
$lang['Anonymous_SQR_mode']

#
#-----[ REPLACE WITH ]--------------------------------------
#
$lang['Anonymous_SQR_mode'] = 'Anonymous Users Quick Reply Mode';

#
#-----[ AFTER, ADD ]--------------------------------------
#
$lang['Anonymous_open_SQR'] = 'Open Quick Reply Form for Anonymous Users automatically';

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Show_hide_quick_reply_form']

#
#-----[ AFTER, ADD ]--------------------------------------
#
$lang['Open_quick_reply'] = 'Open Quick Reply Form automatically';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<tr>
<th class="thHead" colspan="2">{L_AVATAR_SETTINGS}</th>

#
#-----[ BEFORE, ADD ]--------------------------------------
#
	<tr>
	  <td class="row1">{L_ANONYMOUS_OPEN_SQR}</td>
	  <td class="row2"><input type="radio" name="anonymous_open_sqr" value="1" {ANONYMOUS_OPEN_SQR_YES} />{L_YES}&nbsp;&nbsp;<input type="radio" name="anonymous_open_sqr" value="0" {ANONYMOUS_OPEN_SQR_NO} />{L_NO}</td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<span class="gen">{L_QUICK_REPLY_MODE_ADVANCED}</span></td>
</tr>

#
#-----[ AFTER, ADD ]--------------------------------------
#
	<tr>
	  <td class="row1"><span class="gen">{L_OPEN_QUICK_REPLY}:</span></td>
	  <td class="row2">
		<input type="radio" name="open_quickreply" value="1" {OPEN_QUICK_REPLY_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="open_quickreply" value="0" {OPEN_QUICK_REPLY_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN switch_avatar_block -->

#
#-----[ BEFORE, ADD ]--------------------------------------
#
	<tr>
	  <td class="row1"><span class="gen">{L_OPEN_QUICK_REPLY}:</span></td>
	  <td class="row2">
		<input type="radio" name="open_quickreply" value="1" {OPEN_QUICK_REPLY_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="open_quickreply" value="0" {OPEN_QUICK_REPLY_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl

#
#-----[ FIND ]------------------------------------------
#
<div id="sqr" style="display: none; position: relative; ">

#
#-----[ REPLACE WITH ]------------------------------------------
#
<!-- BEGIN switch_open_qr_yes -->
<div id="sqr" style="display: show; position: relative; ">
<!-- END switch_open_qr_yes -->
<!-- BEGIN switch_open_qr_no -->
<div id="sqr" style="display: none; position: relative; ">
<!-- END switch_open_qr_no -->

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# if ( ($board_config['allow_quickreply'] != 0) && $is_auth['auth_reply'] && (($forum_topic_data['forum_status'] != FORUM_LOCKED) || $is_auth['auth_mod'] ) && ( ($forum_topic_data['topic_status'] != TOPIC_LOCKED) || $is_auth['auth_mod'] ) && $sqr_user_display )
if ( ($board_config['allow_quickreply'] != 0)

#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( ($board_config['allow_quickreply'] != 0) && $is_auth['auth_reply'] && $sqr_user_display )

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_users ADD user_open_quickreply TINYINT(1) DEFAULT '1' NOT NULL;
UPDATE phpbb_users SET user_open_quickreply=0 WHERE user_id=-1;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_open_sqr', '0');

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM