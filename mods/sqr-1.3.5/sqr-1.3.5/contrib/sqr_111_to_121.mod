##############################################################
## MOD Title: SQR 1.1.1 to SQR 1.2.1 Code Changes
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: Changes from Super Quick Reply 1.1.1 to 1.2.1
##
## MOD Version: 1.0.0
##
## Installation Level: Intermediate
## Installation Time: 10-15 Minutes
## Files To Edit: admin/admin_board.php,
##                includes/usercp_avatar.php,
##                includes/viewtopic_quickreply.php,
##                language/lang_english/lang_admin.php,
##                templates/subSilver/admin/board_config_body.tpl,
##                templates/subSilver/admin/user_edit_body.tpl,
##                templates/subSilver/profile_add_body.tpl,
##                templates/subSilver/viewtopic_quickreply.tpl,
##                viewtopic.php
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
## phpBB 2.0.13 compatible.
##
## This MOD will install using EasyMOD.
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-09 - Version 1.0.0
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
$quickreply_yes = ( $new['allow_quickreply'] ) ? "checked=\"checked\"" : "";
$quickreply_no = ( !$new['allow_quickreply'] ) ? "checked=\"checked\"" : "";

#
#-----[ AFTER, ADD ]--------------------------------------
#

$anonymous_sqr_mode_basic = ( $new['anonymous_sqr_mode']==0 ) ? 'checked="checked"' : '';
$anonymous_sqr_mode_advanced = ( $new['anonymous_sqr_mode']!=0 ) ? 'checked="checked"' : '';

$anonymous_sqr_select = quick_reply_select($new['anonymous_show_sqr'], 'anonymous_show_sqr');


#
#-----[ FIND ]------------------------------------------
#
"L_ALLOW_QUICK_REPLY" => $lang['Allow_quick_reply'],

#
#-----[ REPLACE WITH ]--------------------------------------
#

	"L_SQR_SETTINGS" => $lang['SQR_settings'],
	"L_ALLOW_QUICK_REPLY" => $lang['Allow_quick_reply'],
	"L_ANONYMOUS_SHOW_SQR" => $lang['Anonymous_show_SQR'],
	"L_ANONYMOUS_SQR_MODE" => $lang['Anonymous_SQR_mode'],
	"L_ANONYMOUS_SQR_MODE_BASIC" => $lang['Quick_reply_mode_basic'],
	"L_ANONYMOUS_SQR_MODE_ADVANCED" => $lang['Quick_reply_mode_advanced'],


#
#-----[ FIND ]------------------------------------------
#
"QUICKREPLY_YES" => $quickreply_yes,
"QUICKREPLY_NO" => $quickreply_no,

#
#-----[ REPLACE WITH ]--------------------------------------
#
	"ANONYMOUS_SQR_SELECT" => $anonymous_sqr_select,
	"QUICKREPLY_YES" => $quickreply_yes,
	"QUICKREPLY_NO" => $quickreply_no,
	"ANONYMOUS_SQR_MODE_BASIC" => $anonymous_sqr_mode_basic,
	"ANONYMOUS_SQR_MODE_ADVANCED" => $anonymous_sqr_mode_advanced,

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
, &$show_quickreply, &$quickreply_mode

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
, &$show_quickreply, &$quickreply_mode

#
#-----[ OPEN ]------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------
#
if ( $userdata['user_quickreply_mode']==1 )


#
#-----[ REPLACE WITH ]--------------------------------------
#
if ( ($userdata['user_quickreply_mode']==1) && ($userdata['user_id'] != ANONYMOUS) || ($board_config['anonymous_sqr_mode']==1) )


#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Allow_name_change'] = 'Allow Username changes';
$lang['Allow_quick_reply'] = 'Allow Quick Reply';


#
#-----[ REPLACE WITH ]--------------------------------------
#
$lang['Allow_name_change'] = 'Allow Username changes';


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
$lang['Anonymous_show_SQR'] = 'Show Quick Reply Form for Anonymous Users';
$lang['Anonymous_SQR_mode'] = 'Anonymous Quick Reply Mode';


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<tr>
<td class="row1">{L_ALLOW_QUICK_REPLY}</td>
<td class="row2"><input type="radio" name="allow_quickreply" value="1" {QUICKREPLY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_quickreply" value="0" {QUICKREPLY_NO} /> {L_NO}</td>
</tr>

#
#-----[ REPLACE WITH ]--------------------------------------
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

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<td class="row1"><span class="gen">{L_QUICK_REPLY_MODE}</span></td>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
:

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<td class="row1"><span class="gen">{L_QUICK_REPLY_MODE}</span></td>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
:

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- END switch_notify_checkbox -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
		  <!-- BEGIN switch_delete_checkbox -->
		  <tr>
			<td>
			  <input type="checkbox" name="delete" />
			</td>
			<td><span class="gen">{L_DELETE_POST}</span></td>
		  </tr>
		  <!-- END switch_delete_checkbox -->

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
$sqr_user_display = (bool)

#
#-----[ BEFORE, ADD ]--------------------------------------
#
if ( $userdata['user_id'] != ANONYMOUS )
{

#
#-----[ AFTER, ADD ]--------------------------------------
#
}
else
{
	$sqr_user_display = (bool)( ($board_config['anonymous_show_sqr']==2) ? $sqr_last_page : $board_config['anonymous_show_sqr'] );
}

#
#-----[ FIND ]------------------------------------------
#
if ( ($board_config['allow_quickreply'] != 0) && $is_auth['auth_reply'] && ($forum_topic_data['forum_status'] != FORUM_LOCKED) && ($forum_topic_data['topic_status'] != TOPIC_LOCKED) && $sqr_user_display )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
($forum_topic_data['forum_status'] != FORUM_LOCKED)

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
(($forum_topic_data['forum_status'] != FORUM_LOCKED) || $is_auth['auth_mod'] )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
($forum_topic_data['topic_status'] != TOPIC_LOCKED)

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
( ($forum_topic_data['topic_status'] != TOPIC_LOCKED) || $is_auth['auth_mod'] )

#
#-----[ SQL ]------------------------------------------
#
UPDATE phpbb_users SET user_quickreply_mode=0 WHERE user_id=-1;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_show_sqr', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_sqr_mode', '0');

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM