##############################################################
## MOD Title: Hidden Login
## MOD Author: eviL3 < evil@phpbbmodders.net > (Igor Wiedler) http://phpbbmodders.net
## MOD Description: Allows users to login Hidden, so they aren't listed in
##                  the "who's online" part / page.
##
## MOD Version:      1.0.2
##
## Installation Level: Easy
## Installation Time: 3 Minutes
##
## Files To Edit: login.php,
##                includes/page_header.php,
##                language/lang_english/lang_main.php,
##                templates/subSilver/index_body.tpl,
##                templates/subSilver/login_body.tpl
##
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
##
## I know that olympus has something like this. But i had the Idea already
## before i saw it in phpbb3 beta1. Thanks to noobarmy who also had this Idea :)
##
## I'd also like to thank Kalipo who gave me some good tipps :)
##
## You can obtain support for this MOD either at phpBB.com or
## at phpbbmodders.net.
##
##############################################################
## MOD History:
##
##   2006-06-20 - Version 0.1.0
##      - First release
##
##   2006-06-21 - Version 0.1.1
##      - Small lang addition
##      - If not hidden, log in unhidden
##
##   2006-06-21 - Version 0.1.2
##      - Template fixes
##      - Don't show when logging into admin
##
##   2006-06-21 - Version 0.1.3
##      - Fix resetting when logging into admin
##
##   2006-07-20 - Version 1.0.0
##      - Submitted to MODDB
##
##   2006-08-28 - Version 1.0.1
##      - Optimized SQL, thanks TerraFrost :)
##
##   2006-12-06 - Version 1.0.2
##      - Cleaned, recommented, MODx'd, optimized.
##      - Added a new addon "hide_session"
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------------
#
login.php
#
#-----[ FIND ]------------------------------------------------
#
$autologin
#
#-----[ AFTER, ADD ]------------------------------------------------
#
//-- mod : Hidden Login ------------------------------------------------------------
//-- add
					$hidelogin = ( isset($HTTP_POST_VARS['hidelogin']) ) ? 0 : 1;
//-- fin mod : Hidden Login --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
					// Reset login tries
					$db->sql_query
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
, user_last_login_try = 0
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
, user_allow_viewonline = ' . $hidelogin . '
#
#-----[ OPEN ]------------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------------
#
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
#
#-----[ AFTER, ADD ]------------------------------------------------
#
//-- mod : Hidden Login ------------------------------------------------------------
//-- add
	'L_HIDE_LOGIN'		=> $lang['Hidden_login'],
	'L_HIDE_LOGIN_LONG'	=> $lang['Hidden_login_long'],
//-- fin mod : Hidden Login --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
	//
	// Allow autologin?
#
#-----[ BEFORE, ADD ]------------------------------------------------
#
//-- mod : Hidden Login ------------------------------------------------------------
//-- add
	$template->assign_block_vars('switch_allow_hidelogin', array());
//-- fin mod : Hidden Login --------------------------------------------------------
#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------------
#
$lang['Log_me_in']
#
#-----[ AFTER, ADD ]-----------------------------------------
#

//-- mod : Hidden Login ------------------------------------------------------------
//-- add
$lang['Hidden_login']		= 'Hide';
$lang['Hidden_login_long']	= 'Log me in as hidden';
//-- fin mod : Hidden Login --------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/index_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
		<!-- END switch_allow_autologin -->
#
#-----[ AFTER, ADD ]-----------------------------------------
#
		&nbsp;&nbsp;
		<label for="hidelogin">{L_HIDE_LOGIN}</label>
		<input class="text" type="checkbox" name="hidelogin" id="hidelogin" />
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/login_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
		<!-- END switch_allow_autologin -->
#
#-----[ AFTER, ADD ]-----------------------------------------
#
		<!-- BEGIN switch_allow_hidelogin -->
		<tr align="center"> 
			<td colspan="2">
				<span class="gen"><lable for="hidelogin">{L_HIDE_LOGIN_LONG}:</label> <input type="checkbox" name="hidelogin" id="hidelogin" /></span>
			</td>
		</tr>
		<!-- END switch_allow_hidelogin -->
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
