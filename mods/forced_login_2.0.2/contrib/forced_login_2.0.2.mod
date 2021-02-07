##############################################################
## MOD Title: Forced login
## MOD Author: Lord Le Brand < lordlebrand@hotmail.com > (N/A) N/A
## MOD Description: When a guest visits, he will be redirected to login, where a
##			message is displayed stating login is required and providing
##			a register link. This can be turned on and off in the board
##			 configuration in the ACP.
##
## MOD Version: 2.0.2
##
## Installation Level: Easy
## Installation Time: 5 minutes
## Files To Edit: (9)
##		login.php,
##		profile.php,
##		admin/admin_board.php,
##		includes/functions_search.php,
##		includes/page_header.php,
##		language/lang_english/lang_admin.php,
##		language/lang_english/lang_main.php,
##		templates/subSilver/login_body.tpl,
##		templates/subSilver/admin/board_config_body.tpl
## Files Included: (N/A)
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
## Before installing his MOD you should make a backup of all files and the database
##
##############################################################
## MOD History:
##
##	2007-1-10 - Version 2.0.2
##		-  Fixed 'Find username' problem
##
##	2006-9-13 - Version 2.0.1
##		-  Fixed configuration
##
##	2006-9-12 - Version 2.0.0
##		-  Rewrote how it handles things
##		-  Renamed from 'Login required message' to 'Forced login'
##
##	2006-9-11 - Version 1.2.0
##		-  Added switch in board configuration
##
##	2006-9-10 - Version 1.0.0
##		-  Got it working
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('login_required', 0);

#
#-----[ OPEN ]------------------------------------------
#
login.php

#
#-----[ FIND ]------------------------------------------
#
			'USERNAME' => $username,

#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
			'LOGIN_REQUIRED'   => ( ! $userdata['session_logged_in'] && $board_config['login_required'] ) ? $lang['Login_required'] . '<br /><br />' . sprintf($lang['Click_register'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>') . '<br />&nbsp;' : '',
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
profile.php

#
#-----[ FIND ]------------------------------------------
#
	$mode = htmlspecialchars($mode);

#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
	if ( $mode != 'viewprofile' )
	{
		define('IN_PROFILE', true);
	}
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
$disable_board_yes = ( $new['board_disable'] ) ? "checked=\"checked\"" : "";
$disable_board_no = ( !$new['board_disable'] ) ? "checked=\"checked\"" : "";

#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
$require_login_yes = ( $new['login_required'] ) ? "checked=\"checked\"" : "";
$require_login_no = ( !$new['login_required'] ) ? "checked=\"checked\"" : "";
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ FIND ]------------------------------------------
#
	"L_DISABLE_BOARD_EXPLAIN" => $lang['Board_disable_explain'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
	"L_LOGIN_REQUIRED" => $lang['Require_login'],
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ FIND ]------------------------------------------
#
	"S_DISABLE_BOARD_NO" => $disable_board_no,

#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
	"S_REQUIRE_LOGIN_YES" => $require_login_yes,
	"S_REQUIRE_LOGIN_NO" => $require_login_no,
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_search.php

#
#-----[ FIND ]------------------------------------------
#
function username_search($search_match)
{

#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
	global $userdata;
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
define('HEADER_INC', TRUE);

#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
if ( ! $userdata['session_logged_in'] && $board_config['login_required'] && ! defined('IN_PROFILE') && ! defined('IN_LOGIN') )
{
	redirect(append_sid("login.$phpEx"));	
}
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
$lang['Require_login'] = 'Require login';
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//-- mod : Forced login ----------------------------------------------------
//-- add
$lang['Login_required'] = 'The Administrator requires all users to login.';
$lang['Click_register'] = 'Click %sHere%s to register a new account';
//-- fin mod : Forced login ------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/login_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		  <tr> 
			<td width="45%" align="right"><span class="gen">{L_USERNAME}:</span></td>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		  <tr> 
				<td align="center" colspan="2"><span class="gen">{LOGIN_REQUIRED}</span></td>
		  </tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		<td class="row2"><input type="radio" name="board_disable" value="1" {S_DISABLE_BOARD_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="board_disable" value="0" {S_DISABLE_BOARD_NO} /> {L_NO}</td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_LOGIN_REQUIRED}</td>
		<td class="row2"><input type="radio" name="login_required" value="1" {S_REQUIRE_LOGIN_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="login_required" value="0" {S_REQUIRE_LOGIN_NO} /> {L_NO}</td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
