##############################################################
## MOD Title: Super Quick Reply
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD adds "quick" reply form to View Topic page.
##                  It can be configured both for a specific user and for the entire board.
##
## MOD Version: 1.3.5
##
## Installation Level: Intermediate
## Installation Time: 20-25 Minutes
## Files To Edit: admin/admin_board.php,
##                admin/admin_users.php,
##                includes/functions_selects.php,
##                includes/usercp_avatar.php,
##                includes/usercp_register.php,
##                language/lang_english/lang_admin.php,
##                language/lang_english/lang_main.php,
##                templates/subSilver/admin/board_config_body.tpl,
##                templates/subSilver/admin/user_edit_body.tpl,
##                templates/subSilver/profile_add_body.tpl,
##                templates/subSilver/viewtopic_body.tpl,
##                templates/subSilver/subSilver.cfg,
##                viewtopic.php
##
## Included Files: viewtopic_quickreply.php,
##                 viewtopic_quickreply.tpl,
##                 quickreply.gif
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
## Personally, I did not like any of the modes I've come across so far, so I decided to make my own.
##
## MOD support topic at phpbb.com: http://www.phpbb.com/phpBB/viewtopic.php?t=230887
##
## Features:
##      - SQR panel in board config:
##        - enable/disable SQR
##        - SQR options for anonymous users
##      - SQR panel in user profile:
##        - SQR form view mode: basic/advanced
##        - SQR form display type: show/hide/at the last page
##        - Open SQR form automatically
##
## This MOD phpBB 2.0.22 compatible.
##
## This MOD will install using EasyMOD.
##
## This MOD not compliant with MODs (for more info see contrib folder):
##  - Username Color ( http://www.phpbb.com/phpBB/viewtopic.php?t=187354 )
##  - Link Poster's Name To Profile ( http://www.phpbb.com/phpBB/viewtopic.php?t=210954 )
##  - Mini Profile ( http://www.phpbb.com/phpBB/viewtopic.php?t=110870 )
##  - Author Hyperlink ( http://www.phpbb.com/phpBB/viewtopic.php?t=135776 )
##  - Online/Offline/Hidden ( http://www.phpbb.com/phpBB/viewtopic.php?t=228106 )
##
## For mode addons see contrib folder.
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2007-02-19 - Version 1.3.5
##      - make the necessary changes to correct the denied MOD
##      - SQR 1.3.2 to SQR 1.3.5 Code Changes added
##
##   2007-02-05 - Version 1.3.4
##      - make MOD phpBB 2.0.22 compatible
##
##   2005-07-09 - Version 1.3.2
##      - fixed javascript error on paste name
##      - fixed Russian language translation
##      - added code for joint installation with Multiple BBCode MOD
##      - smiles improoved
##      - added code for joint installation with Categories Hierarchy MOD
##      - changes to install SQR on Categories Hierarchy MODedd boards
##
##   2005-06-29 - Version 1.3.1
##      - "Open SQR form" option has been added
##      - logic has been changed
##      - bug at registration process has been fixed
##      - bug at user editing has been fixed
##      - SQR 1.3.0 to SQR 1.3.1 Code Changes added
##
##   2005-03-14 - Version 1.3.0
##      - Show/Hide SQR button added
##      - fixed Author's Notes
##      - notes about Online/Offline/Hidden added
##      - SQR 1.2.2 to SQR 1.3.0 Code Changes added
##
##   2005-03-11 - Version 1.2.2
##      - added code for joint installation with File Attachment MOD
##      - fixed bug with SQR form view mode
##      - re-wrote Author's Notes
##
##   2005-03-10 - Version 1.2.1
##      - make the necessary changes to correct the denied MOD
##
##   2005-03-09 - Version 1.2.0
##      - Anonymous settings are added in forum config in administration panel
##      - fixed bug: moderators did not see SQR form in locked topics and forums
##      - fixed bug at registration process
##      - added code for joint installation with Lock/Unlock in Posting Body MOD
##      - added code for joint installation with Save posts as drafts MOD
##      - added code for joint installation with Topic Search MOD
##      - added code for joint installation with User Profile Link MOD
##      - make more EMC (I hope)
##      - added Russian language translation
##      - added SQR 1.1.1 to SQR 1.2.0 Code Changes
##
##   2004-12-03 - Version 1.1.1
##      - make the necessary changes to correct the denied MOD
##
##   2004-12-01 - Version 1.1.0
##      - added SQR mode: basic/advanced
##      - added SQR display type: show/hide/last page
##
##   2004-10-08 - Version 1.0.2
##      - make the necessary changes to correct the denied MOD
##
##   2004-09-07 - Version 1.0.1
##      - make the necessary changes to correct the denied MOD
##
##   2004-04-13 - Version 1.0.0
##      - initial public version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy viewtopic_quickreply.php to includes/viewtopic_quickreply.php
copy viewtopic_quickreply.tpl to templates/subSilver/viewtopic_quickreply.tpl
copy quickreply.gif to templates/subSilver/images/lang_english/quickreply.gif

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
$quickreply_yes = ( $new['allow_quickreply'] ) ? "checked=\"checked\"" : "";
$quickreply_no = ( !$new['allow_quickreply'] ) ? "checked=\"checked\"" : "";

$anonymous_sqr_mode_basic = ( $new['anonymous_sqr_mode']==0 ) ? 'checked="checked"' : '';
$anonymous_sqr_mode_advanced = ( $new['anonymous_sqr_mode']!=0 ) ? 'checked="checked"' : '';

$anonymous_sqr_select = quick_reply_select($new['anonymous_show_sqr'], 'anonymous_show_sqr');

$anonymous_open_sqr_yes = ( $new['anonymous_open_sqr'] ) ? "checked=\"checked\"" : "";
$anonymous_open_sqr_no = ( !$new['anonymous_open_sqr'] ) ? "checked=\"checked\"" : "";


#
#-----[ FIND ]------------------------------------------
#
"L_ALLOW_NAME_CHANGE" => $lang['Allow_name_change'],

#
#-----[ AFTER, ADD ]--------------------------------------
#

	"L_SQR_SETTINGS" => $lang['SQR_settings'],
	"L_ALLOW_QUICK_REPLY" => $lang['Allow_quick_reply'],
	"L_ANONYMOUS_SHOW_SQR" => $lang['Anonymous_show_SQR'],
	"L_ANONYMOUS_SQR_MODE" => $lang['Anonymous_SQR_mode'],
	"L_ANONYMOUS_SQR_MODE_BASIC" => $lang['Quick_reply_mode_basic'],
	"L_ANONYMOUS_SQR_MODE_ADVANCED" => $lang['Quick_reply_mode_advanced'],
	"L_ANONYMOUS_OPEN_SQR" => $lang['Anonymous_open_SQR'],

#
#-----[ FIND ]------------------------------------------
#
"NAMECHANGE_NO" => $namechange_no,

#
#-----[ AFTER, ADD ]--------------------------------------
#
	"ANONYMOUS_SQR_SELECT" => $anonymous_sqr_select,
	"QUICKREPLY_YES" => $quickreply_yes,
	"QUICKREPLY_NO" => $quickreply_no,
	"ANONYMOUS_SQR_MODE_BASIC" => $anonymous_sqr_mode_basic,
	"ANONYMOUS_SQR_MODE_ADVANCED" => $anonymous_sqr_mode_advanced,
	"ANONYMOUS_OPEN_SQR_YES" => $anonymous_open_sqr_yes,
	"ANONYMOUS_OPEN_SQR_NO" => $anonymous_open_sqr_no,

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#
$user_dateformat = ( $HTTP_POST_VARS['dateformat'] ) ? trim( $HTTP_POST_VARS['dateformat'] ) : $board_config['default_dateformat'];

#
#-----[ AFTER, ADD ]--------------------------------------
#
		$user_show_quickreply = ( isset( $HTTP_POST_VARS['show_quickreply'] ) ) ? intval( $HTTP_POST_VARS['show_quickreply'] ) : 1;
		$user_quickreply_mode = ( isset( $HTTP_POST_VARS['quickreply_mode'] ) ) ? ( ( $HTTP_POST_VARS['quickreply_mode'] ) ? TRUE : 0 ) : TRUE;
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
 user_show_quickreply = $user_show_quickreply, user_quickreply_mode = $user_quickreply_mode, user_open_quickreply = $user_open_quickreply,

#
#-----[ FIND ]------------------------------------------
#
$user_dateformat = htmlspecialchars($this_userdata['user_dateformat']);

#
#-----[ AFTER, ADD ]--------------------------------------
#
		$user_show_quickreply = $this_userdata['user_show_quickreply'];
		$user_quickreply_mode = $this_userdata['user_quickreply_mode'];
		$user_open_quickreply = $this_userdata['user_open_quickreply'];

#
#-----[ FIND ]------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="dateformat" value="' . str_replace("\"", "&quot;", $user_dateformat) . '" />';

#
#-----[ AFTER, ADD ]--------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="show_quickreply" value="' . $user_show_quickreply . '" />';
			$s_hidden_fields .= '<input type="hidden" name="quickreply_mode" value="' . $user_quickreply_mode . '" />';
			$s_hidden_fields .= '<input type="hidden" name="open_quickreply" value="' . $user_quickreply_mode . '" />';

#
#-----[ FIND ]------------------------------------------
#
'DATE_FORMAT' => $user_dateformat,

#
#-----[ AFTER, ADD ]--------------------------------------
#
			'QUICK_REPLY_SELECT' => quick_reply_select($user_show_quickreply, 'show_quickreply'),
			'QUICK_REPLY_MODE_BASIC' => ( $user_quickreply_mode==0 ) ? 'checked="checked"' : '',
			'QUICK_REPLY_MODE_ADVANCED' => ( $user_quickreply_mode!=0 ) ? 'checked="checked"' : '',
			'OPEN_QUICK_REPLY_YES' => ( $user_open_quickreply ) ? 'checked="checked"' : '',
			'OPEN_QUICK_REPLY_NO' => ( !$user_open_quickreply ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#
'L_DATE_FORMAT_EXPLAIN' => $lang['Date_format_explain'],

#
#-----[ AFTER, ADD ]--------------------------------------
#
			'L_QUICK_REPLY_PANEL' => $lang['Quick_reply_panel'],
			'L_SHOW_QUICK_REPLY' => $lang['Show_quick_reply'],
			'L_QUICK_REPLY_MODE' => $lang['Quick_reply_mode'],
			'L_QUICK_REPLY_MODE_BASIC' => $lang['Quick_reply_mode_basic'],
			'L_QUICK_REPLY_MODE_ADVANCED' => $lang['Quick_reply_mode_advanced'],
			'L_OPEN_QUICK_REPLY' => $lang['Open_quick_reply'],

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_selects.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]--------------------------------------
#
function quick_reply_select($default, $select_name = "show_quickreply")
{
	global $lang;

	$sqr_select = '<select name="' . $select_name . '">';

	while( list($value, $mode) = @each($lang['sqr']) )
	{
		$selected = ( $value == $default ) ? ' selected="selected"' : '';
		$sqr_select .= '<option value="' . $value . '"' . $selected . '>' . $mode . '</option>';
	}

	$sqr_select .= '</select>';

	return $sqr_select;

}


#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# function display_avatar_gallery($mode, &$category, &$user_id, &$email, &$current_email, &$coppa, &$username, &$email, &$new_password, &$cur_password, &$password_confirm, &$icq, &$aim, &$msn, &$yim, &$website, &$location, &$occupation, &$interests, &$signature, &$viewemail, &$notifypm, &$popup_pm, &$notifyreply, &$attachsig, &$allowhtml, &$allowbbcode, &$allowsmilies, &$hideonline, &$style, &$language, &$timezone, &$dateformat, &$session_id)
function display_avatar_gallery

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, &$session_id

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, &$show_quickreply, &$quickreply_mode, &$user_open_quickreply

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# $params = array('coppa', 'user_id', 'username', 'email', 'current_email', 'cur_password', 'new_password', 'password_confirm', 'icq', 'aim', 'msn', 'yim', 'website', 'location', 'occupation', 'interests', 'signature', 'viewemail', 'notifypm', 'popup_pm', 'notifyreply', 'attachsig', 'allowhtml', 'allowbbcode', 'allowsmilies', 'hideonline', 'style', 'language', 'timezone', 'dateformat');
$params = array

#
#-----[ IN-LINE FIND ]------------------------------------------
#
);

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
, 'show_quickreply', 'quickreply_mode', 'user_open_quickreply'

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
$user_dateformat = ( !empty($HTTP_POST_VARS['dateformat']) ) ? trim(htmlspecialchars($HTTP_POST_VARS['dateformat'])) : $board_config['default_dateformat'];

#
#-----[ AFTER, ADD ]--------------------------------------
#
	$user_show_quickreply = ( isset( $HTTP_POST_VARS['show_quickreply'] ) ) ? intval( $HTTP_POST_VARS['show_quickreply'] ) : 1;
	$user_quickreply_mode = ( isset( $HTTP_POST_VARS['quickreply_mode'] ) ) ? ( ( $HTTP_POST_VARS['quickreply_mode'] ) ? TRUE : 0 ) : TRUE;
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
 user_show_quickreply = $user_show_quickreply, user_quickreply_mode = $user_quickreply_mode, user_open_quickreply = $user_open_quickreply,

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
 user_show_quickreply, user_quickreply_mode, user_open_quickreply,

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
 $user_show_quickreply, $user_quickreply_mode, $user_open_quickreply,

#
#-----[ FIND ]------------------------------------------
#
$user_dateformat = $userdata['user_dateformat'];

#
#-----[ AFTER, ADD ]--------------------------------------
#
	$user_show_quickreply = $userdata['user_show_quickreply'];
	$user_quickreply_mode = $userdata['user_quickreply_mode'];
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
, $user_show_quickreply, $user_quickreply_mode, $user_open_quickreply

#
#-----[ FIND ]------------------------------------------
#
'DATE_FORMAT' => $user_dateformat,

#
#-----[ AFTER, ADD ]--------------------------------------
#
		'QUICK_REPLY_SELECT' => quick_reply_select($user_show_quickreply, 'show_quickreply'),
		'QUICK_REPLY_MODE_BASIC' => ( $user_quickreply_mode==0 ) ? 'checked="checked"' : '',
		'QUICK_REPLY_MODE_ADVANCED' => ( $user_quickreply_mode!=0 ) ? 'checked="checked"' : '',
		'OPEN_QUICK_REPLY_YES' => ( $user_open_quickreply ) ? 'checked="checked"' : '',
		'OPEN_QUICK_REPLY_NO' => ( !$user_open_quickreply ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#
'L_DATE_FORMAT_EXPLAIN' => $lang['Date_format_explain'],

#
#-----[ AFTER, ADD ]--------------------------------------
#
		'L_QUICK_REPLY_PANEL' => $lang['Quick_reply_panel'],
		'L_SHOW_QUICK_REPLY' => $lang['Show_quick_reply'],
		'L_QUICK_REPLY_MODE' => $lang['Quick_reply_mode'],
		'L_QUICK_REPLY_MODE_BASIC' => $lang['Quick_reply_mode_basic'],
		'L_QUICK_REPLY_MODE_ADVANCED' => $lang['Quick_reply_mode_advanced'],
		'L_OPEN_QUICK_REPLY' => $lang['Open_quick_reply'],

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Version_information']

#
#-----[ AFTER, ADD ]--------------------------------------
#

//
// SQR
//
$lang['SQR_settings'] = 'SQR Settings';
$lang['Allow_quick_reply'] = 'Allow Quick Reply';
$lang['Anonymous_show_SQR'] = 'Show Quick Reply Form to Anonymous Users';
$lang['Anonymous_SQR_mode'] = 'Anonymous Users Quick Reply Mode';
$lang['Anonymous_open_SQR'] = 'Open Quick Reply Form for Anonymous Users automatically';

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['A_critical_error']

#
#-----[ AFTER, ADD ]--------------------------------------
#

//
// SQR
//
$lang['Quick_reply_panel'] = 'Super Quick Reply MOD';
$lang['Quick_Reply'] = 'Quick Reply';
$lang['Show_quick_reply'] = 'Show Quick Reply Form';
$lang['sqr']['0'] = 'No';
$lang['sqr']['1'] = 'Yes';
$lang['sqr']['2'] = 'On last page only';
$lang['Quick_reply_mode'] = 'Quick Reply Mode';
$lang['Quick_reply_mode_basic'] = 'Basic';
$lang['Quick_reply_mode_advanced'] = 'Advanced';
$lang['Show_hide_quick_reply_form'] = 'Show/hide quick reply form';
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
	  <th class="thHead" colspan="2">{L_SQR_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_QUICK_REPLY}</td>
		<td class="row2"><input type="radio" name="allow_quickreply" value="1" {QUICKREPLY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_quickreply" value="0" {QUICKREPLY_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <td class="row1">{L_ANONYMOUS_SHOW_SQR}</td>
	  <td class="row2">{ANONYMOUS_SQR_SELECT}</td>
	</tr>
	<tr>
	  <td class="row1">{L_ANONYMOUS_SQR_MODE}</td>
	  <td class="row2"><input type="radio" name="anonymous_sqr_mode" value="0" {ANONYMOUS_SQR_MODE_BASIC} />{L_ANONYMOUS_SQR_MODE_BASIC}&nbsp;&nbsp;<input type="radio" name="anonymous_sqr_mode" value="1" {ANONYMOUS_SQR_MODE_ADVANCED} />{L_ANONYMOUS_SQR_MODE_ADVANCED}</td>
	</tr>
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
<tr>
<th class="thSides" colspan="2" height="12" valign="middle">{L_AVATAR_PANEL}</th>

#
#-----[ BEFORE, ADD ]--------------------------------------
#
	<tr>
	  <th class="thSides" colspan="2" height="12" valign="middle">{L_QUICK_REPLY_PANEL}</th>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_SHOW_QUICK_REPLY}:</span></td>
	  <td class="row2">{QUICK_REPLY_SELECT}</td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_QUICK_REPLY_MODE}:</span></td>
	  <td class="row2">
		<input type="radio" name="quickreply_mode" value="0" {QUICK_REPLY_MODE_BASIC} />
		<span class="gen">{L_QUICK_REPLY_MODE_BASIC}</span>&nbsp;&nbsp;
		<input type="radio" name="quickreply_mode" value="1" {QUICK_REPLY_MODE_ADVANCED} />
		<span class="gen">{L_QUICK_REPLY_MODE_ADVANCED}</span></td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_OPEN_QUICK_REPLY}:</span></td>
	  <td class="row2">
		<input type="radio" name="open_quickreply" value="1" {OPEN_QUICK_REPLY_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="open_quickreply" value="0" {OPEN_QUICK_REPLY_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr>
	  <td class="catSides" colspan="2"><span class="cattitle">&nbsp;</span></td>
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
	  <td class="catSides" colspan="2"><span class="cattitle">&nbsp;</span></td>
	</tr>
	<tr>
	  <th class="thSides" colspan="2" height="12" valign="middle">{L_QUICK_REPLY_PANEL}</th>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_SHOW_QUICK_REPLY}:</span></td>
	  <td class="row2">{QUICK_REPLY_SELECT}</td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_QUICK_REPLY_MODE}:</span></td>
	  <td class="row2">
		<input type="radio" name="quickreply_mode" value="0" {QUICK_REPLY_MODE_BASIC} />
		<span class="gen">{L_QUICK_REPLY_MODE_BASIC}</span>&nbsp;&nbsp;
		<input type="radio" name="quickreply_mode" value="1" {QUICK_REPLY_MODE_ADVANCED} />
		<span class="gen">{L_QUICK_REPLY_MODE_ADVANCED}</span></td>
	</tr>
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
templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# <td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
<a href="{U_POST_NEW_TOPIC}">

#
#-----[ IN-LINE FIND ]------------------------------------------
#
U_POST_NEW_TOPIC

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
U_POST_NEW_TOPIC

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# <td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
<a href="{U_POST_NEW_TOPIC}">

#
#-----[ IN-LINE FIND ]------------------------------------------
#
</a></span></td>

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
</a>

#
#-----[ AFTER, ADD ]--------------------------------------
#
<!-- BEGIN switch_quick_reply -->
&nbsp;&nbsp;&nbsp;<a href="{U_POST_SQR_TOPIC}"><img src="{SQR_IMG}" border="0" alt="{L_POST_SQR_TOPIC}" align="middle" /></a>
<!-- END switch_quick_reply -->
</span></td>

#
#-----[ FIND ]------------------------------------------
#
<table width="100%" cellspacing="2" border="0" align="center">

#
#-----[ BEFORE, ADD ]--------------------------------------
#
<!-- BEGIN switch_quick_reply -->
	{QRBODY}
<!-- END switch_quick_reply -->


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# $images['reply_locked'] = "$current_template_images/{LANG}/reply-locked.gif";
$images['reply_locked'] =

#
#-----[ AFTER, ADD ]--------------------------------------
#
$images['quickreply'] = "$current_template_images/{LANG}/quickreply.gif";

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

#
#-----[ AFTER, ADD ]--------------------------------------
#
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

#
#-----[ FIND ]------------------------------------------
#
'body' => 'viewtopic_body.tpl')

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	'qrbody' => 'viewtopic_quickreply.tpl',

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# //
# // Okay, let's do the loop, yeah come on baby let's do the loop
# // and it goes like this ...
# //
# for($i = 0; $i < $total_posts; $i++)
//
//
//
//
for($i = 0; $i < $total_posts; $i++)

#
#-----[ BEFORE, ADD ]--------------------------------------
#
//
// SQR
//
$sqr_last_page = ((floor( $start / intval($board_config['posts_per_page']) ) + 1 ) == ceil( $total_replies / intval($board_config['posts_per_page'])));
if ( $userdata['user_id'] != ANONYMOUS )
{
	$sqr_user_display = (bool)( ($userdata['user_show_quickreply']==2) ? $sqr_last_page : $userdata['user_show_quickreply'] );
}
else
{
	$sqr_user_display = (bool)( ($board_config['anonymous_show_sqr']==2) ? $sqr_last_page : $board_config['anonymous_show_sqr'] );
}
if ( ($board_config['allow_quickreply'] != 0) && $is_auth['auth_reply'] && $sqr_user_display )
{
	$show_qr_form =	true;
}
else
{
	$show_qr_form =	false;
}


#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# $template->assign_block_vars('postrow', array(
$template->assign_block_vars('postrow'

#
#-----[ BEFORE, ADD ]--------------------------------------
#
	//
	// SQR
	// If you have installed "User Profile MOD" - do not add this lines or remove "User Profile MOD"
	//
	if ( $show_qr_form )
	{
		$poster = '<a href="javascript:pn(\''.$poster.'\');">'.$poster.'</a>';
	}


#
#-----[ FIND ]------------------------------------------
#
$template->pparse('body');

#
#-----[ BEFORE, ADD ]--------------------------------------
#
if ( $show_qr_form )
{
	$template->assign_block_vars('switch_quick_reply', array());
	include($phpbb_root_path . 'includes/viewtopic_quickreply.'.$phpEx);
}


#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_users ADD user_show_quickreply TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD user_quickreply_mode TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD user_open_quickreply TINYINT(1) DEFAULT '1' NOT NULL;
UPDATE phpbb_users SET user_show_quickreply=0 WHERE user_id=-1;
UPDATE phpbb_users SET user_quickreply_mode=0 WHERE user_id=-1;
UPDATE phpbb_users SET user_open_quickreply=0 WHERE user_id=-1;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_quickreply', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_show_sqr', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_sqr_mode', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_open_sqr', '0');

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM