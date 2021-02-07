##############################################################
## MOD Title: Silkroad Online Profile
## MOD Author: Noxwizard < noxwizard@gmail.com > (Patrick W.) http://silkroad.clante.hostingzero.com
## MOD Description: Adds an additional profile page where users can update their Silkroad information.
## MOD Version: 1.0.0
## 
## Installation Level: Intermediate
## Installation Time: 35 minutes
## Files To Edit: viewtopic.php
##	admin/admin_users.php
##	includes/constants.php
##	includes/functions.php
##	includes/functions_validate.php
##	includes/usercp_avatar.php
##	includes/usercp_register.php
##	includes/usercp_viewprofile.php
##	language/lang_english/lang_main.php
##	templates/subSilver/overall_header.tpl
##	templates/subSilver/profile_add_body.tpl
##	templates/subSilver/profile_view_body.tpl
##	templates/subSilver/subSilver.cfg
##	templates/subSilver/viewtopic_body.tpl
##	templates/subSilver/admin/user_edit_body.tpl
## Included Files: root/silkroad.php
##	root/includes/silkroad_editprofile.php
##	root/includes/silkroad_viewprofile.php
##	root/templates/subSilver/images/lang_english/icon_silkroad.gif
##	root/templates/subSilver/images/silkroad/bicheon/*.*
##	root/templates/subSilver/images/silkroad/cold/*.*
##	root/templates/subSilver/images/silkroad/fire/*.*
##	root/templates/subSilver/images/silkroad/force/*.*
##	root/templates/subSilver/images/silkroad/heuksal/*.*
##	root/templates/subSilver/images/silkroad/pacheon/*.*
##	root/templates/subSilver/images/silkroad/thunder/*.*
##	root/templates/subSilver/silkroad_edit_body.tpl
##	root/templates/subSilver/silkroad_view_body.tpl
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
## Author Notes: Adds an additional profile page where users can update their Silkroad information.
##	Adds an icon with the messenger icons on posts and profile.
##	
##	Special Thanks to:
##	The Unofficial Forum For phpBB.com Supporters
##	http://www.phpbbhelp.org
##
##	Pre-Editted Files Instructions:
##	The pre-editted files are only for if you have no other MODs installed
##	Simply copy all the files to the server, overwriting the existing files
##	Then run the SQL commands and skip to EoM
##
##	EasyMOD Note:
##	This MOD is EasyMOD compatible, but will not execute the SQL commands, you must do them manually.
##	
##############################################################
## MOD History:
## 
## 2006-10-21 - Version 0.0.3
##      -New database system - Thanks to Ramon Fincken
##      -New expand/collapse javascript
##      -Added Skills and Forces
## 
## 2006-09-24 - Version 0.0.2
##      -Overhauled databasing
## 
## 2006-09-24 - Version 0.0.1
##      -Initial release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_silk` VARCHAR( 255 ) NULL;

CREATE TABLE `phpbb_silkroad_quests` (
  `user_id` mediumint(8) NOT NULL default '0',
  `quest_id` tinyint(3) NOT NULL default '0',
  `quest_value` char(2) default '0',
  KEY `user_id` (`user_id`)
);

CREATE TABLE `phpbb_silkroad_skills` (
  `user_id` mediumint(8) NOT NULL default '0',
  `skill_id` tinyint(3) NOT NULL default '0',
  `skill_value` char(2) default '0',
  KEY `user_id` (`user_id`)
);

CREATE TABLE `phpbb_silkroad_forces` (
  `user_id` mediumint(8) NOT NULL default '0',
  `force_id` tinyint(3) NOT NULL default '0',
  `force_value` char(2) default '0',
  KEY `user_id` (`user_id`)
);
#
#-----[ COPY ]------------------------------------------
#
copy root/silkroad.php to silkroad.php
copy root/language/lang_englsih/lang_silkroad.php to language/lang_englsih/lang_silkroad.php
copy root/includes/silkroad_editprofile.php to includes/silkroad_editprofile.php
copy root/includes/silkroad_viewprofile.php to includes/silkroad_viewprofile.php
copy root/templates/subSilver/images/lang_english/icon_silkroad.gif to templates/subSilver/images/lang_english/icon_silkroad.gif
copy root/templates/subSilver/images/silkroad/bicheon/*.* to templates/subSilver/images/silkroad/bicheon/*.*
copy root/templates/subSilver/images/silkroad/cold/*.* to templates/subSilver/images/silkroad/cold/*.*
copy root/templates/subSilver/images/silkroad/fire/*.* to templates/subSilver/images/silkroad/fire/*.*
copy root/templates/subSilver/images/silkroad/force/*.* to templates/subSilver/images/silkroad/force/*.*
copy root/templates/subSilver/images/silkroad/heuksal/*.* to templates/subSilver/images/silkroad/heuksal/*.*
copy root/templates/subSilver/images/silkroad/pacheon/*.* to templates/subSilver/images/silkroad/pacheon/*.*
copy root/templates/subSilver/images/silkroad/thunder/*.* to templates/subSilver/images/silkroad/thunder/*.*
copy root/templates/subSilver/silkroad_edit_body.tpl to templates/subSilver/silkroad_edit_body.tpl
copy root/templates/subSilver/silkroad_view_body.tpl to templates/subSilver/silkroad_view_body.tpl
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT u.username, u.user_id, u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type, u.user_allowavatar, u.user_allowsmile, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_yim
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_silk
#
#-----[ FIND ]------------------------------------------
#
		$yim = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
		//Silkroad Profile Mod - Noxwizard
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$silk_img = ( $postrow[$i]['user_silk'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_silk'] . '" alt="' . $lang['SILK'] . '" title="' . $lang['SILK'] . '" border="0" /></a>' : '';
		$silk = ( $postrow[$i]['user_silk'] ) ? '<a href="' . $temp_url . '">' . $lang['SILK'] . '</a>' : '';
		// End Silkroad Mod
#
#-----[ FIND ]------------------------------------------
#
		$yim_img = '';
		$yim = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$silk_img = '';
		$silk = '';
#
#-----[ FIND ]------------------------------------------
#
		'YIM_IMG' => $yim_img,
		'YIM' => $yim,
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'SILK_IMG' => $silk_img,
		'SILK' => $silk,
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
#
		$yim = ( !empty($HTTP_POST_VARS['yim']) ) ? trim(strip_tags( $HTTP_POST_VARS['yim'] ) ) : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$silk = ( !empty($HTTP_POST_VARS['silk']) ) ? trim(strip_tags( $HTTP_POST_VARS['silk'] ) ) : ''; //Silkroad Profile Mod - Noxwizard
#
#-----[ FIND ]------------------------------------------
#
		validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$yim
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $silk
#
#-----[ FIND ]------------------------------------------
#
			$yim = htmlspecialchars(stripslashes($yim));
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$silk = htmlspecialchars(stripslashes($silk));
#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", $aim) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_sig_bbcode_uid = '$signature_bbcode_uid', user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowavatar = $user_allowavatar, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_allow_pm = $user_allowpm, user_notify_pm = $notifypm, user_popup_pm = $popuppm, user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_active = $user_status, user_rank = $user_rank" . $avatar_sql . "
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_msnm = '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_silk = '" . str_replace("\'", "''", $silk) . "'
#
#-----[ FIND ]------------------------------------------
#
			$yim = htmlspecialchars(stripslashes($yim));
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$silk = htmlspecialchars(stripslashes($silk));
#
#-----[ FIND ]------------------------------------------
#
		$yim = htmlspecialchars($this_userdata['user_yim']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$silk = htmlspecialchars($this_userdata['user_silk']);
#
#-----[ FIND ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="yim" value="' . str_replace("\"", "&quot;", $yim) . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="silk" value="' . str_replace("\"", "&quot;", $silk) . '" />';
#
#-----[ FIND ]------------------------------------------
#
			'AIM' => $aim,
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'SILK' => $silk,
#
#-----[ FIND ]------------------------------------------
#
			'L_AIM' => $lang['AIM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_SILK' => $lang['SILK'],
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//Silkroad Profile
define('MAX_QUESTS', 75);
define('MAX_SKILLS', 67);
define('MAX_FORCES', 81);
define('SILKROAD_QUESTS_TABLE', $table_prefix.'silkroad_quests');
define('SILKROAD_SKILLS_TABLE', $table_prefix.'silkroad_skills');
define('SILKROAD_FORCES_TABLE', $table_prefix.'silkroad_forces');
#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Silkroad Data Retrieval - Ramon Fincken
function get_quest_data($user_id)
{
	global $db;

	$user_id = intval($user_id);

	$sql = "SELECT quest_id, quest_value
		FROM " . SILKROAD_QUESTS_TABLE . "
		WHERE user_id = $user_id
		ORDER BY quest_id ASC";
		//echo "<br>" . $sql;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not find silkdata for this user', '', __LINE__, __FILE__, $sql);
	}
	$the_array = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$the_array["quest$row[quest_id]"] = $row[quest_value];
	}
	return $the_array;
}

function get_skill_data($user_id)
{
	global $db;

	$user_id = intval($user_id);

	$sql = "SELECT skill_id, skill_value
		FROM " . SILKROAD_SKILLS_TABLE . "
		WHERE user_id = $user_id
		ORDER BY skill_id ASC";
		//echo "<br>" . $sql;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not find silkdata for this user', '', __LINE__, __FILE__, $sql);
	}
	$the_array = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$the_array["skill$row[skill_id]"] = $row[skill_value];
	}
	return $the_array;
}

function get_force_data($user_id)
{
	global $db;

	$user_id = intval($user_id);
	
	$sql = "SELECT force_id, force_value
		FROM " . SILKROAD_FORCES_TABLE . "
		WHERE user_id = $user_id
		ORDER BY force_id ASC";
		//echo "<br>" . $sql;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not find slikdata for this user', '', __LINE__, __FILE__, $sql);
	}
	$the_array = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$the_array["force$row[force_id]"] = $row[force_value];
	}
	return $the_array;
}
#
#-----[ OPEN ]------------------------------------------
#
includes/functions_validate.php
#
#-----[ FIND ]------------------------------------------
#
function validate_optional_fields(&$icq, &$aim, &$msnm, &$yim, &$website, &$location, &$occupation, &$interests, &$sig)
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, &$yim
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$silk
#
#-----[ FIND ]------------------------------------------
#
$check_var_length = array('aim', 'msnm', 'yim', 'location', 'occupation', 'interests', 'sig');
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, 'yim'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'silk'
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]------------------------------------------
#
function display_avatar_gallery($mode, &$category, &$user_id, &$email, &$current_email, &$coppa, &$username, &$email, &$new_password, &$cur_password, &$password_confirm, &$icq, &$aim, &$msn, &$yim, &$website, &$location, &$occupation, &$interests, &$signature, &$viewemail, &$notifypm, &$popup_pm, &$notifyreply, &$attachsig, &$allowhtml, &$allowbbcode, &$allowsmilies, &$hideonline, &$style, &$language, &$timezone, &$dateformat, &$session_id)
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, &$yim
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$silk
#
#-----[ FIND ]------------------------------------------
#
	$params = array('coppa', 'user_id', 'username', 'email', 'current_email', 'cur_password', 'new_password', 'password_confirm', 'icq', 'aim', 'msn', 'yim', 'website', 'location', 'occupation', 'interests', 'signature', 'viewemail', 'notifypm', 'popup_pm', 'notifyreply', 'attachsig', 'allowhtml', 'allowbbcode', 'allowsmilies', 'hideonline', 'style', 'language', 'timezone', 'dateformat');
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, 'yim'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'silk'
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------
#
	$strip_var_list = array('email' => 'email', 'icq' => 'icq', 'aim' => 'aim', 'msn' => 'msn', 'yim' => 'yim', 'website' => 'website', 'location' => 'location', 'occupation' => 'occupation', 'interests' => 'interests', 'confirm_code' => 'confirm_code');
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, 'yim' => 'yim'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'silk' => 'silk'
#
#-----[ FIND ]------------------------------------------
#
	validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $yim
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $silk
#
#-----[ FIND ]------------------------------------------
#
		$yim = stripslashes($yim);
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$silk = stripslashes($silk);
#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_sig_bbcode_uid = '$signature_bbcode_uid', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_notify_pm = $notifypm, user_popup_pm = $popup_pm, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_active = $user_active, user_actkey = '" . str_replace("\'", "''", $user_actkey) . "'" . $avatar_sql . "
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_msnm = '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_silk = '" . str_replace("\'", "''", $silk) . "'
#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_sig_bbcode_uid, user_avatar, user_avatar_type, user_viewemail, user_aim, user_yim, user_msnm, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_timezone, user_dateformat, user_lang, user_style, user_level, user_allow_pm, user_active, user_actkey)
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_msnm
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_silk
#
#-----[ FIND ]------------------------------------------
#
				VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $location) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $signature) . "', '$signature_bbcode_uid', $avatar_sql, $viewemail, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $notifypm, $popup_pm, $user_timezone, '" . str_replace("\'", "''", $user_dateformat) . "', '" . str_replace("\'", "''", $user_lang) . "', $user_style, 0, 1, ";
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, '" . str_replace("\'", "''", $msn) . "'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, '" . str_replace("\'", "''", $silk) . "'
#
#-----[ FIND ]------------------------------------------
#
					'MSN' => $msn,
#
#-----[ AFTER, ADD ]------------------------------------------
#
					'SILK' => $silk,
#
#-----[ FIND ]------------------------------------------
#
	$msn = stripslashes($msn);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	$silk = stripslashes($silk);
#
#-----[ FIND ]------------------------------------------
#
	$msn = $userdata['user_msnm'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	$silk = $userdata['user_silk'];
#
#-----[ FIND ]------------------------------------------
#
	display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email, $coppa, $username, $email, $new_password, $cur_password, $password_confirm, $icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature, $viewemail, $notifypm, $popup_pm, $notifyreply, $attachsig, $allowhtml, $allowbbcode, $allowsmilies, $allowviewonline, $user_style, $user_lang, $user_timezone, $user_dateformat, $userdata['session_id']);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $yim
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $silk
#
#-----[ FIND ]------------------------------------------
#
		'AIM' => $aim,
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'SILK' => $silk,
#
#-----[ FIND ]------------------------------------------
#
		'L_AIM' => $lang['AIM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_SILK' => $lang['SILK'],
		'L_EDIT_SILK_PROFILE' => $lang['SILK_EDIT'],
#
#-----[ FIND ]------------------------------------------
#
		'L_CONFIRM_CODE_EXPLAIN'	=> $lang['Confirm_code_explain'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'SILK_PROFILE' => append_sid("silkroad.$phpEx?mode=editprofile"),
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------
#
$yim = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Silkroad Profile Mod - Noxwizard
$silk_img = ( $profiledata['user_silk'] ) ? $profiledata['user_silk'] : '&nbsp;';
$silk = $silk_img;
$silk_profile = ( $profiledata['user_silk'] ) ? '<a href="' . append_sid("silkroad.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $profiledata['user_id']) . '">' . $lang['SILK_PROFILE'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------
#
	'YIM_IMG' => $yim_img,
	'YIM' => $yim,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	//Silkroad Profile Mod - Noxwizard
	'SILK_IMG' => $silk_img,
	'SILK' => $silk,
#
#-----[ FIND ]------------------------------------------
#
	'L_MESSENGER' => $lang['MSNM'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_SILK' => $lang['SILK'],
	'L_SILKROAD_SN' => $lang['SILKROAD_SN'],
#
#-----[ FIND ]------------------------------------------
#
	'U_SEARCH_USER' => append_sid("search.$phpEx?search_author=" . $u_search_author),
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'SILK_PROFILE' => $silk_profile,
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
//Silkroad Profile MOD - Noxwizard
$lang['SILK'] = 'Silkroad Username';
$lang['SILK_EDIT'] = 'Edit Silkroad Profile';
$lang['SILK_PROFILE'] = 'View Profile';
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- END switch_enable_pm_popup -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<script type="text/javascript">
<!--
// Credit to: http://www.dustindiaz.com/dhtml-expand-and-collapse-div-menu/
function switchMenu(obj)
{
	var el = document.getElementById(obj);
	if ( el.style.display != "none" ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}
// Adaption of above function -Noxwizard
function collapse(obj)
{
	var el = document.getElementById(obj);
	el.style.display = 'none';
}
//-->
</script>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />

	  </td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_SILK}:</span></td> 
	  <td class="row2"> 
		<input type="text" class="post"style="width: 150px"  name="silk" size="20" maxlength="255" value="{SILK}" />&nbsp;&nbsp;<span class="gen"><a href="{SILK_PROFILE}">{L_EDIT_SILK_PROFILE}</a></span>
	  </td> 
	</tr> 
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_AIM}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{AIM_IMG}</span></td>
		</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_SILK}:</span></td> 
		  <td class="row1" valign="middle"><span class="gen">{SILK}&nbsp;&nbsp;{SILK_PROFILE}</span></td> 
		</tr>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Silkroad images
//
$images['icon_silk'] = "$current_template_images/{LANG}/icon_silkroad.gif";
//Skills
//Bicheon
$images['skill1'] = "$current_template_images/silkroad/bicheon/strike_n_smash.gif";
$images['skill2'] = "$current_template_images/silkroad/bicheon/stab_n_smash.gif";
$images['skill3'] = "$current_template_images/silkroad/bicheon/crosswise_smash.gif";
$images['skill4'] = "$current_template_images/silkroad/bicheon/illusion_chain.gif";
$images['skill5'] = "$current_template_images/silkroad/bicheon/blood_chain.gif";
$images['skill6'] = "$current_template_images/silkroad/bicheon/billow_chain.gif";
$images['skill7'] = "$current_template_images/silkroad/bicheon/ascension_chain.gif";
$images['skill8'] = "$current_template_images/silkroad/bicheon/heaven_chain.gif";
$images['skill9'] = "$current_template_images/silkroad/bicheon/castle_shield.gif";
$images['skill10'] = "$current_template_images/silkroad/bicheon/mountain_shield.gif";
$images['skill11'] = "$current_template_images/silkroad/bicheon/ironwall_shield.gif";
$images['skill12'] = "$current_template_images/silkroad/bicheon/soul_cut_blade.gif";
$images['skill13'] = "$current_template_images/silkroad/bicheon/evil_cut_blade.gif";
$images['skill14'] = "$current_template_images/silkroad/bicheon/devil_cut_blade.gif";
$images['skill15'] = "$current_template_images/silkroad/bicheon/blood_blade_force.gif";
$images['skill16'] = "$current_template_images/silkroad/bicheon/soul_blade_force.gif";
$images['skill17'] = "$current_template_images/silkroad/bicheon/demon_blade_force.gif";
$images['skill18'] = "$current_template_images/silkroad/bicheon/flower_bloom_blade.gif";
$images['skill19'] = "$current_template_images/silkroad/bicheon/flower_bud_blade.gif";
$images['skill20'] = "$current_template_images/silkroad/bicheon/dragon_sore_blade.gif";
$images['skill21'] = "$current_template_images/silkroad/bicheon/snake_sword_dance.gif";
$images['skill22'] = "$current_template_images/silkroad/bicheon/petal_sword_dance.gif";
$images['skill23'] = "$current_template_images/silkroad/bicheon/shield_protection.gif";
//Heuksal
$images['skill24'] = "$current_template_images/silkroad/heuksal/wolf_bite_spear.gif";
$images['skill25'] = "$current_template_images/silkroad/heuksal/waning_moon_spear.gif";
$images['skill26'] = "$current_template_images/silkroad/heuksal/yuhon_spear.gif";
$images['skill27'] = "$current_template_images/silkroad/heuksal/bloody_fan_storm.gif";
$images['skill28'] = "$current_template_images/silkroad/heuksal/bloody_wolf_storm.gif";
$images['skill29'] = "$current_template_images/silkroad/heuksal/bloody_snake_storm.gif";
$images['skill30'] = "$current_template_images/silkroad/heuksal/dancing_demon_spear.gif";
$images['skill31'] = "$current_template_images/silkroad/heuksal/jade_breaking_spear.gif";
$images['skill32'] = "$current_template_images/silkroad/heuksal/spirit_crash_spear.gif";
$images['skill33'] = "$current_template_images/silkroad/heuksal/soul_spear_move.gif";
$images['skill34'] = "$current_template_images/silkroad/heuksal/soul_spear_truth.gif";
$images['skill35'] = "$current_template_images/silkroad/heuksal/soul_spear_soul.gif";
$images['skill36'] = "$current_template_images/silkroad/heuksal/ghost_spear_petal.gif";
$images['skill37'] = "$current_template_images/silkroad/heuksal/ghost_spear_prince.gif";
$images['skill38'] = "$current_template_images/silkroad/heuksal/ghost_spear_mars.gif";
$images['skill39'] = "$current_template_images/silkroad/heuksal/chain_spear_tiger.gif";
$images['skill40'] = "$current_template_images/silkroad/heuksal/chain_spear_nachal.gif";
$images['skill41'] = "$current_template_images/silkroad/heuksal/chain_spear_shura.gif";
$images['skill42'] = "$current_template_images/silkroad/heuksal/chain_spear_pluto.gif";
$images['skill43'] = "$current_template_images/silkroad/heuksal/chain_spear_dragon.gif";
$images['skill44'] = "$current_template_images/silkroad/heuksal/flying_dragon_flow.gif";
$images['skill45'] = "$current_template_images/silkroad/heuksal/flying_dragon_fly.gif";
$images['skill46'] = "$current_template_images/silkroad/heuksal/cheolsam_force.gif";
//Pacheon
$images['skill47'] = "$current_template_images/silkroad/pacheon/antidevil_bow_missile.gif";
$images['skill48'] = "$current_template_images/silkroad/pacheon/antidevil_bow_wave.gif";
$images['skill49'] = "$current_template_images/silkroad/pacheon/antidevil_bow_steel.gif";
$images['skill50'] = "$current_template_images/silkroad/pacheon/2arrow_combo.gif";
$images['skill51'] = "$current_template_images/silkroad/pacheon/3arrow_combo.gif";
$images['skill52'] = "$current_template_images/silkroad/pacheon/4arrow_combo.gif";
$images['skill53'] = "$current_template_images/silkroad/pacheon/white_hawk_summon.gif";
$images['skill54'] = "$current_template_images/silkroad/pacheon/black_hawk_summon.gif";
$images['skill55'] = "$current_template_images/silkroad/pacheon/blue_hawk_summon.gif";
$images['skill56'] = "$current_template_images/silkroad/pacheon/autumn_wind_flame.gif";
$images['skill57'] = "$current_template_images/silkroad/pacheon/autumn_wind_snake.gif";
$images['skill58'] = "$current_template_images/silkroad/pacheon/autumn_wind_blood.gif";
$images['skill59'] = "$current_template_images/silkroad/pacheon/demon_soul_arrow.gif";
$images['skill60'] = "$current_template_images/silkroad/pacheon/bloody_soul_arrow.gif";
$images['skill61'] = "$current_template_images/silkroad/pacheon/dragon_soul_arrow.gif";
$images['skill62'] = "$current_template_images/silkroad/pacheon/berserker_arrow.gif";
$images['skill63'] = "$current_template_images/silkroad/pacheon/demon_arrow.gif";
$images['skill64'] = "$current_template_images/silkroad/pacheon/devil_arrow.gif";
$images['skill65'] = "$current_template_images/silkroad/pacheon/strong_bow_spirit.gif";
$images['skill66'] = "$current_template_images/silkroad/pacheon/strong_bow_vision.gif";
$images['skill67'] = "$current_template_images/silkroad/pacheon/mind_concentration.gif";
//forces
//cold
$images['force1'] = "$current_template_images/silkroad/cold/ice_river_force.gif";
$images['force2'] = "$current_template_images/silkroad/cold/ice_jade_force.gif";
$images['force3'] = "$current_template_images/silkroad/cold/ice_ocean_force.gif";
$images['force4'] = "$current_template_images/silkroad/cold/ice_cloud_force.gif";
$images['force5'] = "$current_template_images/silkroad/cold/weak_guard_ice.gif";
$images['force6'] = "$current_template_images/silkroad/cold/soft_guard_ice.gif";
$images['force7'] = "$current_template_images/silkroad/cold/power_guard_ice.gif";
$images['force8'] = "$current_template_images/silkroad/cold/might_guard_ice.gif";
$images['force9'] = "$current_template_images/silkroad/cold/cold_wave_arrest.gif";
$images['force10'] = "$current_template_images/silkroad/cold/cold_wave_binding.gif";
$images['force11'] = "$current_template_images/silkroad/cold/cold_wave_shackle.gif";
$images['force12'] = "$current_template_images/silkroad/cold/crystal_wall.gif";
$images['force13'] = "$current_template_images/silkroad/cold/snow_wall.gif";
$images['force14'] = "$current_template_images/silkroad/cold/extreme_wall.gif";
$images['force15'] = "$current_template_images/silkroad/cold/frost_nova_wind.gif";
$images['force16'] = "$current_template_images/silkroad/cold/frost_nova_woods.gif";
$images['force17'] = "$current_template_images/silkroad/cold/frost_nova_storm.gif";
$images['force18'] = "$current_template_images/silkroad/cold/snow_storm_ice_shot.gif";
$images['force19'] = "$current_template_images/silkroad/cold/snow_storm_ice_rain.gif";
$images['force20'] = "$current_template_images/silkroad/cold/cold_armor.gif";
//fire
$images['force21'] = "$current_template_images/silkroad/fire/river_fire_force.gif";
$images['force22'] = "$current_template_images/silkroad/fire/extreme_fire_force.gif";
$images['force23'] = "$current_template_images/silkroad/fire/poison_fire_force.gif";
$images['force24'] = "$current_template_images/silkroad/fire/soul_fire_force.gif";
$images['force25'] = "$current_template_images/silkroad/fire/fire_shield_phoenix.gif";
$images['force26'] = "$current_template_images/silkroad/fire/fire_shield_flower.gif";
$images['force27'] = "$current_template_images/silkroad/fire/fire_shield_king.gif";
$images['force28'] = "$current_template_images/silkroad/fire/fire_shield_emporer.gif";
$images['force29'] = "$current_template_images/silkroad/fire/flame_body_wisdom.gif";
$images['force30'] = "$current_template_images/silkroad/fire/flame_body_power.gif";
$images['force31'] = "$current_template_images/silkroad/fire/flame_body_extreme.gif";
$images['force32'] = "$current_template_images/silkroad/fire/basic_fire_protection.gif";
$images['force33'] = "$current_template_images/silkroad/fire/divine_fire_protection.gif";
$images['force34'] = "$current_template_images/silkroad/fire/hard_fire_protection.gif";
$images['force35'] = "$current_template_images/silkroad/fire/fire_wall_tower.gif";
$images['force36'] = "$current_template_images/silkroad/fire/fire_wall_mountain.gif";
$images['force37'] = "$current_template_images/silkroad/fire/fire_wall_castle.gif";
$images['force38'] = "$current_template_images/silkroad/fire/flame_wave_arrow.gif";
$images['force39'] = "$current_template_images/silkroad/fire/flame_wave_burning.gif";
$images['force40'] = "$current_template_images/silkroad/fire/flame_wave_wide.gif";
$images['force41'] = "$current_template_images/silkroad/fire/flame_devil_force.gif";
//thunder
$images['force42'] = "$current_template_images/silkroad/thunder/thundertiger_force.gif";
$images['force43'] = "$current_template_images/silkroad/thunder/thundersky_force.gif";
$images['force44'] = "$current_template_images/silkroad/thunder/thunderking_force.gif";
$images['force45'] = "$current_template_images/silkroad/thunder/thunderdragon_force.gif";
$images['force46'] = "$current_template_images/silkroad/thunder/must_piercing_force.gif";
$images['force47'] = "$current_template_images/silkroad/thunder/flow_piercing_force.gif";
$images['force48'] = "$current_template_images/silkroad/thunder/speed_piercing_force.gif";
$images['force49'] = "$current_template_images/silkroad/thunder/force_piercing_force.gif";
$images['force50'] = "$current_template_images/silkroad/thunder/grass_walk_flow.gif";
$images['force51'] = "$current_template_images/silkroad/thunder/ghost_walk_phantom.gif";
$images['force52'] = "$current_template_images/silkroad/thunder/grass_walk_speed.gif";
$images['force53'] = "$current_template_images/silkroad/thunder/shock_lion_shout.gif";
$images['force54'] = "$current_template_images/silkroad/thunder/heaven_lion_shout.gif";
$images['force55'] = "$current_template_images/silkroad/thunder/earth_lion_shout.gif";
$images['force56'] = "$current_template_images/silkroad/thunder/concentration_first.gif";
$images['force57'] = "$current_template_images/silkroad/thunder/concentration_second.gif";
$images['force58'] = "$current_template_images/silkroad/thunder/concentration_third.gif";
$images['force59'] = "$current_template_images/silkroad/thunder/wolfs_thunderbolt.gif";
$images['force60'] = "$current_template_images/silkroad/thunder/tigers_thunderbolt.gif";
$images['force61'] = "$current_template_images/silkroad/thunder/heavens_force.gif";
//force
$images['force62'] = "$current_template_images/silkroad/force/self_breathe_heal.gif";
$images['force63'] = "$current_template_images/silkroad/force/self_force_heal.gif";
$images['force64'] = "$current_template_images/silkroad/force/self_wounds_heal.gif";
$images['force65'] = "$current_template_images/silkroad/force/self_vital_heal.gif";
$images['force66'] = "$current_template_images/silkroad/force/force_cure_poison.gif";
$images['force67'] = "$current_template_images/silkroad/force/force_cure_body.gif";
$images['force68'] = "$current_template_images/silkroad/force/force_cure_condition.gif";
$images['force69'] = "$current_template_images/silkroad/force/force_cure_vital.gif";
$images['force70'] = "$current_template_images/silkroad/force/heal_medical_hand.gif";
$images['force71'] = "$current_template_images/silkroad/force/heal_ghost_hand.gif";
$images['force72'] = "$current_template_images/silkroad/force/heal_taoist_hand.gif";
$images['force73'] = "$current_template_images/silkroad/force/soul_rebirth_art.gif";
$images['force74'] = "$current_template_images/silkroad/force/ghost_rebirth_art.gif";
$images['force75'] = "$current_template_images/silkroad/force/spirit_rebirth_art.gif";
$images['force76'] = "$current_template_images/silkroad/force/harmony_therapy.gif";
$images['force77'] = "$current_template_images/silkroad/force/adaptation_therapy.gif";
$images['force78'] = "$current_template_images/silkroad/force/whole_therapy.gif";
$images['force79'] = "$current_template_images/silkroad/force/vital_spot_muscle.gif";
$images['force80'] = "$current_template_images/silkroad/force/vital_spot_spirit.gif";
$images['force81'] = "$current_template_images/silkroad/force/force_increasing.gif";
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<td valign="middle" nowrap="nowrap">{postrow.PROFILE_IMG} {postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG}<script language="JavaScript" type="text/javascript"><!-- 
#
#-----[ IN-LINE FIND ]------------------------------------------
#
{postrow.MSN_IMG}
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 {postrow.SILK_IMG}
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_SILK}</span></td> 
	  <td class="row2"> 
		<input class="post" type="text" name="silk" size="20" maxlength="255" value="{SILK}" /> 
	  </td> 
	</tr> 
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM