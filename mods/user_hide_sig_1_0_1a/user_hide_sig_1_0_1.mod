##############################################################
## MOD Title: User hide signatures
## MOD Author: eviL3 < evil@phpbbmodders.org > (Igor Wiedler) http://phpbbmodders.org
## MOD Description: This MOD will allow each user to disable signatures in his profile.
##                  This will hide ALL signatures on the whole board.
## MOD Version: 1.0.1
##
## Installation Level: Intermediate
## Installation Time: 10 Minutes
## Files To Edit: posting.php,
##                privmsg.php,
##                viewtopic.php,
##                admin/admin_users.php,
##                includes/usercp_avatar.php,
##                includes/usercp_register.php,
##                language/lang_english/lang_main.php,
##                templates/subSilver/profile_add_body.tpl,
##                templates/subSilver/admin/user_edit_body.tpl
##
## Included Files: (N/A)
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
## Nothing to say. 
##
##############################################################
## MOD History:
##
##   2006-09-03 - Version 1.0.0
##      - First version
##
##   2006-09-29 - Version 1.0.1
##      - 1.0.0 Validated!
##      - Extended a little (thanks Kellanved)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_show_sigs` TINYINT( 1 ) NOT NULL DEFAULT '1';
#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
//
// Here we do various lookups to find topic_id, forum_id, post_id etc.
#
#-----[ BEFORE, ADD ]------------------------------------------
#
if ( !$userdata['user_show_sigs'] )
{
    $board_config['allow_sig'] = false;
}
#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------
#
//
// Var definitions
#
#-----[ BEFORE, ADD ]------------------------------------------
#
if ( !$userdata['user_show_sigs'] )
{
    $board_config['allow_sig'] = false;
}
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
// End auth check
//
#
#-----[ AFTER, ADD ]------------------------------------------
#
if ( !$userdata['user_show_sigs'] )
{
    $board_config['allow_sig'] = false;
}
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
#
$attachsig = ( isset( $HTTP_POST_VARS['attachsig']) ) ? ( ( $HTTP_POST_VARS['attachsig'] ) ? TRUE : 0 ) : 0;
#
#-----[ AFTER, ADD ]------------------------------------------
#
$showsigs = ( isset( $HTTP_POST_VARS['showsigs']) ) ? ( ( $HTTP_POST_VARS['showsigs'] ) ? TRUE : 0 ) : 1;
#
#-----[ FIND ]------------------------------------------
#
         $sql = "UPDATE " . USERS_TABLE . "
            SET
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_attachsig = $attachsig
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_show_sigs = $showsigs
#
#-----[ FIND ]------------------------------------------
#
$attachsig = $this_userdata['user_attachsig'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$showsigs = $this_userdata['user_show_sigs'];
#
#-----[ FIND ]------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="attachsig" value="' . $attachsig . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$s_hidden_fields .= '<input type="hidden" name="user_show_sigs" value="' . $showsigs . '" />';
#
#-----[ FIND ]------------------------------------------
#
			'ALWAYS_ADD_SIGNATURE_YES' => ($attachsig) ? 'checked="checked"' : '',
			'ALWAYS_ADD_SIGNATURE_NO' => (!$attachsig) ? 'checked="checked"' : '',
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'SHOW_SIGS_YES' => ($showsigs) ? 'checked="checked"' : '',
			'SHOW_SIGS_NO' => (!$showsigs) ? 'checked="checked"' : '',
#
#-----[ FIND ]------------------------------------------
#
			'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_SHOW_SIGS' => $lang['Show_sigs'],
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]------------------------------------------
#
function display_avatar_gallery(
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, &$attachsig
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$showsigs
#
#-----[ FIND ]------------------------------------------
#
$params = array('coppa'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, 'attachsig'
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'showsigs'
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
$showsigs = ( isset($HTTP_POST_VARS['showsigs']) ) ? ( ($HTTP_POST_VARS['showsigs']) ? TRUE : 0 ) : 1;
#
#-----[ FIND ]------------------------------------------
#
$attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $userdata['user_attachsig'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$showsigs = ( isset($HTTP_POST_VARS['showsigs']) ) ? ( ($HTTP_POST_VARS['showsigs']) ? TRUE : 0 ) : $userdata['user_show_sigs'];
#
#-----[ FIND ]------------------------------------------
#
			$sql = "UPDATE " . USERS_TABLE . "
				SET "
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_attachsig = $attachsig
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_show_sigs = $showsigs
#
#-----[ FIND ]------------------------------------------
#
$sql = "INSERT INTO " . USERS_TABLE
#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_attachsig, 
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
user_show_sigs, 
#
#-----[ FIND ]------------------------------------------
#
VALUES ($user_id, '"
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $attachsig
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $showsigs
#
#-----[ FIND ]------------------------------------------
#
$attachsig = $userdata['user_attachsig'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$showsigs = $userdata['user_show_sigs'];
#
#-----[ FIND ]------------------------------------------
#
display_avatar_gallery(
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $attachsig
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $showsigs
#
#-----[ FIND ]------------------------------------------
#
		'ALWAYS_ADD_SIGNATURE_YES' => ( $attachsig ) ? 'checked="checked"' : '',
		'ALWAYS_ADD_SIGNATURE_NO' => ( !$attachsig ) ? 'checked="checked"' : '',
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'SHOW_SIGS_YES' => ( $showsigs ) ? 'checked="checked"' : '',
		'SHOW_SIGS_NO' => ( !$showsigs ) ? 'checked="checked"' : '',
#
#-----[ FIND ]------------------------------------------
#
		'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_SHOW_SIGS' => $lang['Show_sigs'],
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Always_add_sig']
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Show_sigs'] = 'Display signatures of users';
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
	  <td class="row1"><span class="gen">{L_SHOW_SIGS}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="showsigs" value="1" {SHOW_SIGS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="showsigs" value="0" {SHOW_SIGS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
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
	  <td class="row1"><span class="gen">{L_SHOW_SIGS}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="showsigs" value="1" {SHOW_SIGS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="showsigs" value="0" {SHOW_SIGS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
