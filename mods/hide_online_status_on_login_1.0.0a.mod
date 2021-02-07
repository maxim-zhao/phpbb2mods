##############################################################
## MOD Title: Hide Online Status Temporarily On Login
## MOD Author: tariqkhan < mail@tariqkhan.co.uk > (Tariq Khan) http://tariqkhan.co.uk/
## MOD Description: Allows members to hide their online status before login and for that session only
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minutes
## Files To Edit: 3
##      login.php,
##      language/lang_english/lang_main.php,
##      templates/subSilver/login_body.tpl
## Included Files: N/A
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
##	My first MOD
##############################################################
## MOD History:
##
##   2006-11-17 - Version 1.0.0
##      - Initial realease :)
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
					$autologin = ( isset($HTTP_POST_VARS['autologin']) ) ? TRUE : 0;

#
#-----[ AFTER, ADD ]------------------------------------------
#
					// Hide online status on login MOD - tariqkhan.co.uk
					$hideonline = ( isset ( $HTTP_POST_VARS['hideonline'] ) ) ? FALSE : TRUE;

#
#-----[ FIND ]------------------------------------------------
# 
					$db->sql_query('UPDATE ' . USERS_TABLE . ' SET user_login_tries = 0, user_last_login_try = 0 WHERE user_id = ' . $row['user_id']);

#
#-----[ IN-LINE FIND ]----------------------------------------
#
user_last_login_try = 0

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_allow_viewonline = ' . (int) $hideonline . '

#
#-----[ FIND ]------------------------------------------------ 
#
			'L_SEND_PASSWORD' => $lang['Forgotten_password'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
			// Hide online status on login MOD - tariqkhan.co.uk
			'L_HIDE_ONLINE' => $lang['hide_online'],


#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------
#
$lang['Log_me_in'] = 'Log me on automatically each visit';

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Hide online status on login MOD - tariqkhan.co.uk
$lang['hide_online'] = 'Hide my online status this session';


#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/login_body.tpl

#
#-----[ FIND ]------------------------------------------------
#
		  <!-- END switch_allow_autologin -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
		  <!--Hide online status on login MOD - tariqkhan.co.uk-->
		  <tr align="center"> 
			<td colspan="2"><span class="gen">{L_HIDE_ONLINE}: <input type="checkbox" name="hideonline" /></span></td>
		  </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM