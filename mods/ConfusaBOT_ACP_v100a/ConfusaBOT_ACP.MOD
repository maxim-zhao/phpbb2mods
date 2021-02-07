##############################################################
## MOD Title: ConfusaBOT ACP
## MOD Author: espicom < phpbb2mods@espi.com > (Jeff Brenton) N/A
## MOD Description: Change "agreed" and "coppa" variables to confuse bots
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~5 Minutes
## Files To Edit: admin/admin_users.php, 
##                admin/admin_board.php,
##                includes/usercp_avatar.php,
##                includes/usercp_register.php,
##                language/lang_english/lang_admin.php,
##                templates/subSilver/admin/board_config_body.tpl
## Included Files: n/a
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
## This MOD makes the "agreed" and "coppa" variables used in the registration screen more 
## easily adjustable through the Admin Control Panel. This MOD requires phpBB v2.0.20 or later.
## Prior to installing this mod, you need to add the following configuration items to your
## phpbb_config table:
##
## INSERT INTO phpbb_config (config_name,config_value) VALUES ('agreed_var','IAmInAgreement');
## INSERT INTO phpbb_config (config_name,config_value) VALUES ('agreed_val','Yes');
## INSERT INTO phpbb_config (config_name,config_value) VALUES ('coppa_var','Under13');
##
## Of course, you need to substitute the names for YOUR config table and the variable names you
## want to use.
## IMPORTANT!!!!!!!!!!!!!
## If you are using any templates other than subSilver, overall_header.tpl, admin/board_config_body.tpl,
## and admin/styles_edit_body.tpl in each of them will need to be modified, as well.
##
## If you are using any languages other than English, lang_admin.php in each language will need to
## be modified, as well.
##############################################################
## MOD History:
##
##   2005-05-11 - Version 1.0.0
##      - mod created
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]-------------------------------------------
#
INSERT INTO phpbb_config (config_name,config_value) VALUES ('agreed_var','IAmInAgreement');
INSERT INTO phpbb_config (config_name,config_value) VALUES ('agreed_val','Yes');
INSERT INTO phpbb_config (config_name,config_value) VALUES ('coppa_var','Under13');
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
	"L_ALLOW_AUTOLOGIN_EXPLAIN" => $lang['Allow_autologin_explain'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_AGREED_VAR' => $lang['Agreed_Var'],
	'L_AGREED_VAR_EXPLAIN' => $lang['Agreed_Var_explain'], 
	'L_AGREED_VAL' => $lang['Agreed_Val'],
	'L_AGREED_VAL_EXPLAIN' => $lang['Agreed_Val_explain'], 
	'L_COPPA_VAR' => $lang['Coppa_Var'],
	'L_COPPA_VAR_EXPLAIN' => $lang['Coppa_Var_explain'], 
#
#-----[ FIND ]------------------------------------------
#
	'AUTOLOGIN_TIME' => (int) $new['max_autologin_time'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"AGREED_VAR" => $new['agreed_var'],
	"AGREED_VAL" => $new['agreed_val'],
	"COPPA_VAR" => $new['coppa_var'],
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
			$s_hidden_fields = '<input type="hidden" name="mode"
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa"
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
<input type="hidden" name="'.$board_config['agreed_var'].'" value="'.$board_config['agreed_val'].'" /><input type="hidden" name="'.$board_config['coppa_var'].'"
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
		$s_hidden_fields = '<input type="hidden" name="mode" value="save"
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa"
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
<input type="hidden" name="'.$board_config['agreed_var'].'" value="'.$board_config['agreed_val'].'" /><input type="hidden" name="'.$board_config['coppa_var'].'"
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
	$s_hidden_vars = '<input type="hidden" name="sid"
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<input type="hidden" name="agreed" value="true" />
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
<input type="hidden" name="'.$board_config['agreed_var'].'" value="'.$board_config['agreed_val'].'" />
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]------------------------------------------
#
function show_coppa()
{
	global $userdata, $template, $lang, $phpbb_root_path, $phpEx;
#
#-----[ AFTER, ADD ]------------------------------------------
#
	global $board_config;
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
		"U_AGREE_OVER13" =>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&amp;agreed=true"
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
&amp;". $board_config['agreed_var'] ."=".$board_config['agreed_val']
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
		"U_AGREE_UNDER13" =>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&amp;agreed=true&amp;coppa=true"
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
&amp;". $board_config['agreed_var'] ."=". $board_config['agreed_val'] ."&amp;".$board_config['coppa_var']."=true"
#
#-----[ FIND ]------------------------------------------
#
$error_msg = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#

// change to test for new setting of agreed
if ( isset($HTTP_POST_VARS[$board_config['agreed_var']]))
{
	if ($HTTP_POST_VARS[$board_config['agreed_var']] != $board_config['agreed_val'])
		unset($HTTP_POST_VARS[$board_config['agreed_var']]);
}
if ( isset($HTTP_GET_VARS[$board_config['agreed_var']]))
{
	if ($HTTP_GET_VARS[$board_config['agreed_var']] != $board_config['agreed_val'])
		unset($HTTP_GET_VARS[$board_config['agreed_var']]);
}

#
#-----[ FIND ]------------------------------------------
#
if ( $mode == 'register' && !isset($HTTP_POST_VARS['agreed']) && !isset($HTTP_GET_VARS['agreed']) )
#
#-----[ REPLACE WITH ]---------------------------------------------
#
if ( $mode == 'register' && !isset($HTTP_POST_VARS[$board_config['agreed_var']]) && !isset($HTTP_GET_VARS[$board_config['agreed_var']]) )
#
#-----[ FIND ]------------------------------------------
#
$coppa = ( empty($HTTP_POST_VARS['coppa']) && empty($HTTP_GET_VARS['coppa']) ) ? 0 : TRUE;
#
#-----[ REPLACE WITH ]---------------------------------------------
#
$coppa = ( empty($HTTP_POST_VARS[$board_config['coppa_var']]) && empty($HTTP_GET_VARS[$board_config['coppa_var']]) ) ? 0 : TRUE;
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
	$s_hidden_fields = '<input type="hidden" name="mode" value="
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa"
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
<input type="hidden" name="'.$board_config['agreed_var'].'" value="'.$board_config['agreed_val'].'" /><input type="hidden" name="'.$board_config['coppa_var'].'"
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
$lang['Autologin_time_explain'] =
#
#-----[ AFTER, ADD ]------------------------------------------
#

// ConfusaBOT variables
$lang['Agreed_Var']= "Agreed variable";
$lang['Agreed_Var_explain']= "Case-sensitive HTML form variable name for terms agreement"; 
$lang['Agreed_Val']= "Agreed value";
$lang['Agreed_Val_explain']= "Case-sensitive HTML form variable <i>value</i> for terms agreement";
$lang['Coppa_Var']= "COPPA variable";
$lang['Coppa_Var_explain']= "Case-sensitive HTML form variable name for COPPA compliance";
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
# Partial line match. Actual line is much longer.
#
		<td class="row1">{L_AUTOLOGIN_TIME}
#
#-----[ FIND ]------------------------------------------
#
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_AGREED_VAR}<br /><span class="gensmall">{L_AGREED_VAR_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="agreed_var" value="{AGREED_VAR}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_AGREED_VAL}<br /><span class="gensmall">{L_AGREED_VAL_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="agreed_val" value="{AGREED_VAL}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_COPPA_VAR}<br /><span class="gensmall">{L_COPPA_VAR_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="coppa_var" value="{COPPA_VAR}" /></td>
	</tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM