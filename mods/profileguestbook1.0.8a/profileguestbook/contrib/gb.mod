##############################################################
## MOD Title: Profile guestbook
## MOD Author: paul999 < webmaster@paulscripts.nl > (paul sohier) http://www.paulscripts.nl
## MOD Description: With this mod, you have a profile guestbook.
## MOD Version: 1.0.8a
##
## Installation Level: Easy
## Installation Time: 21 minutes
## Files To Edit: admin/admin_board.php
##                admin/admin_users.php
##                templates/subSilver/profile_view_body.tpl
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/admin/board_config_body.tpl
##                templates/subSilver/admin/user_edit_body.tpl
##                includes/functions.php
##                includes/usercp_viewprofile.php
##                includes/usercp_register.php
##                includes/constants.php
##                language/lang_english/lang_admin.php
## Included Files: root/includes/functions_guestbook.php
##                 root/templates/subSilver/gb_post.tpl
##                 root/templates/subSilver/gb_view.tpl
##                 root/language/lang_english/email/guestbook.tpl
##                 root/language/lang_english/lang_guestbook.php
##                 root/bbcode_gb.js
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2288.38406 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## To update from 1.0.7 to 1.0.8a just overwrite all files. No other actions are required.
## This mod CAN be installed on a plain phpbb with easymod, but I cannot guarantee that it also work if you has another style or other mods!
## If you has a other style or mods, please install it manually!
##############################################################
## MOD History:
##
## 2006-12-28 - Version 1.0.8
## - Removed extra languages. Can be download seperate
## - Added confirmation of deleting posts
## - Small bugfixes
## - Added check for start < 0 (2.0.22 change)
##
## 2006-11-11 - Version 1.0.8
## - Minor bugfixes
## - added sort of "post number" mod (REQUEST)
## - added missing lang string to tpl for back to top
## - Don't display guestbook when guest cannot post in it (REQUEST)
## - Fixed smilies in quick reply
## - Changed way of generating urls for in guestbook. Now it is easier to display it on a other page(REQUEST)
## - Some small TPL changes to some nicer html output.
## - Don't display quick reply if user hasn't enough posts.
##
## 2006-05-18 - Version 1.0.7
## -Small changes to install file.
##
## 2006-05-07 - Version 0.0.10
## -Fixes to install files
## -Small change to functions_guestbook.php
## -Changed quick reply a bit.
##
## 2006-05-06 - Version 0.0.9
## -Critical fix.
##
## 2006-04-24 - Version 1.0.6
## -Handling for HTML from 2.0.20 added.
## -Added enable/disable quick reply
## -Fixed a bug by posting message and page_tail
## -Small code changes.
##
## 2006-02-10 - Version 1.0.5
## - Changed code for 2.0.19
## - Some small code changes.
## - Added check for " from phpbb 2.0.18.
## - Fixed a lang problem
##
## 2005-09-30 - Version 0.0.7
## - Make changes for submitting
## - Deleted cash add.
##
## 2005-09-30 - Version 1.0.4
## - Make changes for submitting
## - Deleted cash add.
##
## 2005-09-09 - Version 1.0.3
## - Addes some requests:
## - Points and cash mod support
## - Quick reply
## - Enable disable gb for each user.
## - Can set min posts for posting a message
## - Edit 8 small bugs.
## - Edit some things for submitting
##
## 2005-09-09 - Version 0.0.6
## - Addes some requests:
## - Points and cash mod support
## - Quick reply
## - Eneble disable gb for each user.
## - Can set min posts for posting a message
## - Edit 8 small bugs.
## - Edit some things for submitting
## - Mod is now RC1
##
## 2005-08-12 - Version 0.0.5
## - Make some changes for submitting(Only code in functions_guestbook.php)
##
## 2005-08-12 - Version 1.0.2
## - Make some changes for submitting(Only code in functions_guestbook.php)
##
## 2005-07-28 - Version 1.0.1
## - Make some changes for submitting
##
## 2005-07-27 - Version 1.0.0
## - Make the mod install easymod compatible.
## - New mod header.
##
## 2005-07-18 - Version 0.0.4
## - Added guest name.
## - Small bugfixes
##
## 2005-06-23 - Version 0.0.3
## - Added version checker
## - Added enable disable guest posting
## - Added enable disable email on reply
## - Edit some bugs.
## - Added new lang string(I was forgot one :D)
##
## 2005-06-22 - Version 0.0.2
## - Edit some bugs.
## - Guests can post also.
## - Email has been send to user.
## - Edit, quote and pagination has been replaced(They don't work :D)
## - Lang updated.
##
## 2005-06-22 - Version 0.0.1
## - first release.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#

CREATE TABLE `phpbb_profile_guestbook` (
  `gb_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `poster_id` int(10) NOT NULL default '0',
  `bbcode` varchar(64) NOT NULL default '',
  `gb_time` int(10) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `user_guest_name` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`gb_id`)
);

INSERT INTO `phpbb_profile_guestbook` VALUES (1, 2, 2, 'dd7850a9d8', 1119444611, 'Test message', 'If you see this, it works :D','');
ALTER TABLE `phpbb_users` ADD `user_email_new_gb` TINYINT( 1 ) DEFAULT '1' NOT NULL;
ALTER TABLE `phpbb_users` ADD `user_can_gb` TINYINT( 1 ) DEFAULT '1' NOT NULL;
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('allow_guests_gb', '1');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('gb_posts', '500');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('gb_quick', '1');

#
#-----[ COPY ]------------------------------------------
#
copy root/includes/functions_guestbook.php to       includes/functions_guestbook.php
copy root/templates/subSilver/gb_post.tpl to       templates/subSilver/gb_post.tpl
copy root/templates/subSilver/gb_view.tpl to       templates/subSilver/gb_view.tpl
copy root/language/lang_english/email/guestbook.tpl to       language/lang_english/email/guestbook.tpl
copy root/language/lang_english/lang_guestbook.php to       language/lang_english/lang_guestbook.php
copy root/bbcode_gb.js to       bbcode_gb.js


#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#

$sig_no = ( !$new['allow_sig'] ) ? "checked=\"checked\"" : "";

#
#-----[ AFTER, ADD ]------------------------------------------
#

$gb_guest_yes = ( $new['allow_guests_gb'] ) ? "checked=\"checked\"" : "";
$gb_guest_no = ( !$new['allow_guests_gb'] ) ? "checked=\"checked\"" : "";

$gb_quick_yes = ( $new['gb_quick'] ) ? "checked=\"checked\"" : "";
$gb_quick_no = ( !$new['gb_quick'] ) ? "checked=\"checked\"" : "";
#
#-----[ FIND ]------------------------------------------
#

"L_RESET" => $lang['Reset'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

"L_NO_GUEST_GB" => $lang['gb_no_guest'],
"L_NO_GUEST_GB_EXPLAIN" => $lang['gb_no_guest_explain'],
"L_POST_GB" => $lang['gb_post'],
"L_POST_GB_EXPLAIN" => $lang['gb_post_exp'],
"L_GB_QUICK" => $lang['gb_quick'],

#
#-----[ FIND ]------------------------------------------
#

"SIG_NO" => $sig_no,

#
#-----[ AFTER, ADD ]------------------------------------------
#

"NO_GUEST_YES" => $gb_guest_yes,
"NO_GUEST_NO" => $gb_guest_no,
"GB_QUICK_YES" => $gb_quick_yes,
"GB_QUICK_NO" => $gb_quick_no,
"GB_CASH2" => $new['gb_cash2'],
"GB_POST" => $new['gb_posts'],

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

$gb_email = ( isset($HTTP_POST_VARS['gb_email']) ) ? ( ($HTTP_POST_VARS['gb_email']) ? TRUE : 0 ) : TRUE;
$gb_can = ( isset($HTTP_POST_VARS['gb_can']) ) ? ( ($HTTP_POST_VARS['gb_can']) ? TRUE : 0 ) : TRUE;

#
#-----[ FIND ]------------------------------------------
#

			$sql = "UPDATE " . USERS_TABLE . "
				SET "

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_style = $user_style,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 user_email_new_gb = $gb_email, user_can_gb = $gb_can,
#
#-----[ FIND ]------------------------------------------
#

$popuppm = $this_userdata['user_popup_pm'];

#
#-----[ AFTER, ADD ]------------------------------------------
#

$gb_email = $this_userdata['user_email_new_gb'];
$gb_can = $this_userdata['user_can_gb'];

#
#-----[ FIND ]------------------------------------------
#

		'POPUP_PM_NO' => (!$popuppm) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#

		'GB_EMAIL_YES' => ($gb_email) ? 'checked="checked"' : '',
		'GB_EMAIL_NO' => (!$gb_email) ? 'checked="checked"' : '',
		'GB_CAN_YES' => ($gb_can) ? 'checked="checked"' : '',
		'GB_CAN_NO' => (!$gb_can) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#

		'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

		'L_GB_EMAIL' => $lang['gb_email'],
		'L_GB_CAN' => $lang['gb_can'],

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]------------------------------------------
#

		  //--></script><noscript>{ICQ_IMG}</noscript></td>
		</tr>
	  </table>
	</td>
  </tr>
  </table>

#
#-----[ AFTER, ADD ]------------------------------------------
#

{GUESTBOOK}

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------
#

	<tr>
	  <td class="row1"><span class="gen">{L_POPUP_ON_PRIVMSG}:</span><br /><span class="gensmall">{L_POPUP_ON_PRIVMSG_EXPLAIN}</span></td>
	  <td class="row2">
		<input type="radio" name="popup_pm" value="1" {POPUP_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="popup_pm" value="0" {POPUP_PM_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr>
	  <td class="row1"><span class="gen">{L_GB_EMAIL}:</span><br /><span class="gensmall">{L_GB_EMAIL_EXPLAIN}</span></td>
	  <td class="row2">
		<input type="radio" name="gb_email" value="1" {GB_EMAIL_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="gb_email" value="0" {GB_EMAIL_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#

   <tr>
      <td class="row1">{L_ENABLE_PRUNE}</td>
      <td class="row2"><input type="radio" name="prune_enable" value="1" {PRUNE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="prune_enable" value="0" {PRUNE_NO} /> {L_NO}</td>
   </tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr>
		<td class="row1">{L_NO_GUEST_GB}<br /><span class="gensmall">{L_NO_GUEST_GB_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="allow_guests_gb" value="1" {NO_GUEST_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_guests_gb" value="0" {NO_GUEST_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GB_QUICK}</td>
		<td class="row2"><input type="radio" name="gb_quick" value="1" {GB_QUICK_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="gb_quick" value="0" {GB_QUICK_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_POST_GB}<br /><span class="gensmall">{L_POST_GB_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="gb_posts" value="{GB_POST}" /></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#

	<tr>
	  <td class="row1"><span class="gen">{L_POPUP_ON_PRIVMSG}</span></td>
	  <td class="row2">
		<input type="radio" name="popup_pm" value="1" {POPUP_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="popup_pm" value="0" {POPUP_PM_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr>
	  <td class="row1"><span class="gen">{L_GB_EMAIL}:</span><br /></td>
	  <td class="row2">
		<input type="radio" name="gb_email" value="1" {GB_EMAIL_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="gb_email" value="0" {GB_EMAIL_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr>
	  <td class="row1"><span class="gen">{L_GB_CAN}:</span><br /></td>
	  <td class="row2">
		<input type="radio" name="gb_can" value="1" {GB_CAN_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp;
		<input type="radio" name="gb_can" value="0" {GB_CAN_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php
#
#-----[ FIND ]------------------------------------------
#

	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	if(file_exists($phpbb_root_path . "language/lang_".$board_config['default_lang'] . "/lang_guestbook.php"))
	{
		@include($phpbb_root_path . "language/lang_".$board_config['default_lang'] . "/lang_guestbook.php");
	}
	elseif(file_exists($phpbb_root_path . "language/lang_english/lang_guestbook.php"))
	{
		@include($phpbb_root_path . "language/lang_english/lang_guestbook.php");
	}
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------
#

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#

include($phpbb_root_path . 'includes/functions_guestbook.'.$phpEx);
if(isset($HTTP_GET_VARS['gb']))
{
	$gb = new guestbook($profiledata,$HTTP_GET_VARS['gb']);
}
else
{
	$gb = new guestbook($profiledata,'view');
}

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

$gb_email = ( isset($HTTP_POST_VARS['gb_email']) ) ? ( ($HTTP_POST_VARS['gb_email']) ? TRUE : 0 ) : TRUE;

#
#-----[ FIND ]------------------------------------------
#

			$sql = "UPDATE " . USERS_TABLE . "
				SET

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_style = $user_style,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 user_email_new_gb = $gb_email,
#
#-----[ FIND ]------------------------------------------
#

			$sql = "INSERT INTO " . USERS_TABLE . "

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_popup_pm,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 user_email_new_gb,
#
#-----[ FIND ]------------------------------------------
#

VALUES ($user_id, '"

#
#-----[ IN-LINE FIND ]------------------------------------------
#

$popup_pm,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 $gb_email,
#
#-----[ FIND ]------------------------------------------
#

$popup_pm = $userdata['user_popup_pm'];

#
#-----[ AFTER, ADD ]------------------------------------------
#

$gb_email = $userdata['user_email_new_gb'];

#
#-----[ FIND ]------------------------------------------
#

'POPUP_PM_NO' => ( !$popup_pm ) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#

		'GB_EMAIL_YES' => ( $gb_email ) ? 'checked="checked"' : '',
		'GB_EMAIL_NO' => ( !$gb_email ) ? 'checked="checked"' : '',

#
#-----[ FIND ]------------------------------------------
#

		'L_POPUP_ON_PRIVMSG_EXPLAIN' => $lang['Popup_on_privmsg_explain'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

		'L_GB_EMAIL' => $lang['gb_email'],
		'L_GB_EMAIL_EXPLAIN' => $lang['gb_email_explain'],

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

define("PROFILE_GUESTBOOK_TABLE",$table_prefix."profile_guestbook");

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

$lang['gb_no_guest'] = 'Guest can post at guestbook';
$lang['gb_no_guest_explain'] = 'If you set yes, guests can post in user guestbook!';
$lang['gb_can'] = 'User can have profile guestbook, and can see other.';
$lang['gb_post'] = 'Min posts for gb';
$lang['gb_post_exp'] = 'Minimal number of posts for a posting in a guestbook.';
//Added in version 0.0.9
$lang['gb_quick'] = 'Enable quick reply in guestbook';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
