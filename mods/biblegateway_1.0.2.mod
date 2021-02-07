##############################################################
## MOD Title: BibleGateway MOD
## MOD Author: Trev < scs2tjd@leeds.ac.uk > (Trevor Dodds) http://www.luucu.com
## MOD Description: Automatically converts Bible passages into links
## MOD Version: 1.0.2
##
## Installation Level: Intermediate
## Installation Time: 10 Minutes
## Files To Edit: includes/bbcode.php
##                includes/usercp_register.php
##                admin/admin_users.php
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/admin/user_edit_body.tpl
##                language/lang_english/lang_main.php
##                includes/functions_selects.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: This MOD should be useful for forums with religious content, Christian
## communities etc. It will convert any message text that references a Bible passage in standard
## notation to a link to that part of the Bible. The link will open in a new window, and display
## the Bible text using Bible Gateway (http://www.biblegateway.com). The user may also specify
## the translation they wish to read these links in, using an extra option in their profile.
##
## Standard abbreviations can also be used, e.g. Matt 3:5-7 will be converted into a link to
## Mathew 3:5-7 in the user's preferred version of the Bible. You should also note that it is
## case insensitive.
##
##############################################################
## MOD History:
##
##   2003-12-27 - Version 1.0.0
##      - Initial release
##   2004-04-09 - Version 1.0.1
##      - Added htmlspecialchars() around $HTTP_POST_VARS
##   2004-08-31 - Version 1.0.2
##      - In includes/bbcode.php, changed $bibletype[0] to $bibletype['user_bibletype']
##      - Also in includes/bbcode.php, changed the & characters to &amp;
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
# 
#-----[ SQL ]------------------------------------------ 
# Change the prefix 'phpbb_' accordingly. 'phpbb_' is the default prefix
#
ALTER TABLE phpbb_users ADD user_bibletype VARCHAR( 8 ) DEFAULT 'NIV' NOT NULL;
# 
#-----[ SQL ]------------------------------------------ 
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bibletype', 'NIV');
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php
# 
#-----[ FIND ]------------------------------------------ 
# 
  $ret = ' ' . $text;
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
  global $db, $userdata; // both for BibleGateway MOD
# 
#-----[ FIND ]------------------------------------------ 
# 
  $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
  // lift bible
  $bibleBooks = array('/(1) John/i',
                      '/(2) John/i',
                      '/(3) John/i');

  // replace numbered John's with Nohn, so it's not picked up as John
  $ret = preg_replace($bibleBooks,
    '$1 Nohn', $ret);

  $bibleBooks = array('/(Genesis) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Exodus) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Leviticus) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Numbers) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Deuteronomy) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Joshua) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Judges) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Ruth) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Samuel) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Samuel) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Kings) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Kings) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Chronicles) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Chronicles) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Ezra) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Nehemiah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Esther) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Job) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Psalm) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Proverbs) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Ecclesiastes) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(SongofSolomon) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Isaiah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Jeremiah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Lamentations) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Ezekiel) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Daniel) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Hosea) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Joel) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Amos) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Obadiah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Jonah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Micah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Nahum) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Habakkuk) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Zephaniah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Haggai) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Zechariah) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Malachi) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Matthew) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Mark) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Luke) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(John) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Acts) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Romans) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Corinthians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Corinthians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Galatians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Ephesians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Philippians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Colossians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Thessalonians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Thessalonians) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Timothy) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Timothy) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Titus) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Philemon) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Hebrews) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(James) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Peter) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Peter) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Nohn) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Nohn) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(3 Nohn) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Jude) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Revelation) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Matt) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Tim) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Tim) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Cor) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Cor) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Col) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Sam) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Sam) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(1 Thess) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(2 Thess) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i',
                      '/(Rev) (\d{1,3}-?\d{0,3}):?(\d{0,2}-?\d{0,2})/i');
  
  $sql = 'SELECT user_bibletype FROM ' . USERS_TABLE . '
    WHERE user_id = ' . $userdata['user_id'];
    
  if( !$result = $db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, "Couldn't obtain bibletype data", "", __LINE__, __FILE__, $sql);
  }
  $bibletype = $db->sql_fetchrow($result);

  $replace =
  'http://www.biblegateway.net/cgi-bin/bible?language=english&amp;version=' . $bibletype['user_bibletype'] . '&amp;x=0&amp;y=0&amp;passage=';
  
  $ret = preg_replace($bibleBooks,
    '<a href="' . $replace . '$1+$2%3A$3" target="_blank">$0</a>', $ret);

  // replace Nohn's back to John
  $ret = preg_replace('/Nohn/', 'John', $ret);

  // turn spaces from 1 tim 2 john etc. into +
  $ret = preg_replace('/(\&amp;passage\=\d) /', '$1+', $ret);

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_register.php
# 
#-----[ FIND ]------------------------------------------ 
# 
	$user_timezone = ( isset($HTTP_POST_VARS['timezone']) ) ? doubleval($HTTP_POST_VARS['timezone']) : $board_config['board_timezone'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
  $user_bibletype = ( isset($HTTP_POST_VARS['bibletype']) ) ? htmlspecialchars($HTTP_POST_VARS['bibletype']) : $board_config['bibletype'];
# 
#-----[ FIND ]------------------------------------------ 
# 
			$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_sig_bbcode_uid = '$signature_bbcode_uid', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_notify_pm = $notifypm, user_popup_pm = $popup_pm, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_active = $user_active, user_actkey = '" . str_replace("\'", "''", $user_actkey) . "'" . $avatar_sql . "
				WHERE user_id = $user_id";
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
user_style = $user_style,
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 user_bibletype = '$user_bibletype',
# 
#-----[ FIND ]------------------------------------------ 
# 
			$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, user_sig, user_sig_bbcode_uid, user_avatar, user_avatar_type, user_viewemail, user_aim, user_yim, user_msnm, user_attachsig, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_viewonline, user_notify, user_notify_pm, user_popup_pm, user_timezone, user_dateformat, user_lang, user_style, user_level, user_allow_pm, user_active, user_actkey)
				VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $location) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $signature) . "', '$signature_bbcode_uid', $avatar_sql, $viewemail, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $notifypm, $popup_pm, $user_timezone, '" . str_replace("\'", "''", $user_dateformat) . "', '" . str_replace("\'", "''", $user_lang) . "', $user_style, 0, 1, ";
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
user_style,
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 user_bibletype,
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
$user_style,
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 '$user_bibletype',
# 
#-----[ FIND ]------------------------------------------ 
# 
	$user_dateformat = $userdata['user_dateformat'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
  $user_bibletype = $userdata['user_bibletype'];
# 
#-----[ FIND ]------------------------------------------ 
# 
		'SMILIES_STATUS' => $smilies_status,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
    'BIBLETYPE_SELECT' => bibletype_select($user_bibletype, 'bibletype'),
# 
#-----[ FIND ]------------------------------------------ 
# 
		'L_CURRENT_IMAGE' => $lang['Current_Image'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
    'L_BIBLETYPE' => $lang['Bible_type'],
# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_users.php
# 
#-----[ FIND ]------------------------------------------ 
# 
		$user_dateformat = ( $HTTP_POST_VARS['dateformat'] ) ? trim( $HTTP_POST_VARS['dateformat'] ) : $board_config['default_dateformat'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
    $user_bibletype = ( $HTTP_POST_VARS['bibletype'] ) ? htmlspecialchars($HTTP_POST_VARS['bibletype']) : $board_config['bibletype'];
# 
#-----[ FIND ]------------------------------------------ 
# 
			$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", $aim) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_sig_bbcode_uid = '$signature_bbcode_uid', user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowavatar = $user_allowavatar, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_allow_pm = $user_allowpm, user_notify_pm = $notifypm, user_popup_pm = $popuppm, user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_active = $user_status, user_rank = $user_rank" . $avatar_sql . "
				WHERE user_id = $user_id";
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "',
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 user_bibletype = '$user_bibletype',
# 
#-----[ FIND ]------------------------------------------ 
# 
		$user_dateformat = htmlspecialchars($this_userdata['user_dateformat']);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
    $user_bibletype = $this_userdata['user_bibletype'];
# 
#-----[ FIND ]------------------------------------------ 
# 
			'DATE_FORMAT' => $user_dateformat,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
      'BIBLETYPE_SELECT' => bibletype_select($user_bibletype, 'bibletype'),
# 
#-----[ FIND ]------------------------------------------ 
# 
			'L_DATE_FORMAT_EXPLAIN' => $lang['Date_format_explain'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
      'L_BIBLETYPE' => $lang['Bible_type'],
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_add_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
		<input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" class="post" />
	  </td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
  <tr>
    <td class="row1"><span class="gen">{L_BIBLETYPE}:</span></td>
    <td class="row2">{BIBLETYPE_SELECT}</td>
  </tr>
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/user_edit_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
		<input class="post" type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="16" />
	  </td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
  <tr>
    <td class="row1"><span class="gen">{L_BIBLETYPE}</span></td>
    <td class="row2">{BIBLETYPE_SELECT}</td>
  </tr>
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Public_view_email'] = 'Always show my e-mail address';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['Bible_type'] = 'Bible type';
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_selects.php
# 
#-----[ FIND ]------------------------------------------ 
# 
	return $tz_select;
}
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# make sure you add this after the } character
#
//
// Pick a bible type
//
function bibletype_select($default, $select_name = 'bibletype')
{
  $types = array( 'NIV', 'NASB', 'MSG', 'AMP', 'NLT', 'KJV', 'ESV', 'CEV', 'NKJV', 'KJ21', 'ASV', 'WE', 'YLT', 'DARBY', 'WYC', 'NIV-UK' );
  
  $bt_select = '<select name="' . $select_name . '">';

  while ( list(, $type) = @each($types) )
  {
    $selected = ( $type == $default ) ? ' selected="selected"' : '';
    $bt_select .= '<option value="' . $type . '"' . $selected . '>' . $type . '</option>';
  }
  
  $bt_select .= '</select>';

  return $bt_select;
}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
