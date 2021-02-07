##############################################################
## MOD Title: E-Mail Explain Mod
## MOD Author: FoulFoot < webmaster@acaeum.com > (N/A) http://www.acaeum.com
## MOD Description: On the registration screen, displays an explanatory line under "E-mail address":
##                  "An activation e-mail will be sent to this address."  On my board, this has reduced
##                  the number of unactivated accounts (due to entering a fake e-mail address) dramatically.
##                  This message will only appear if your account activation is set to "user" (it
##                  won't do anything if you have your board set to "none" or "admin").
##
## MOD Version: 1.1.0
##
## Installation Level: Easy
## Installation Time: ~ 1 Minute
##
## Files To Edit: includes/usercp_register.php
##                language/lang_english/lang_main.php
##                templates/subsilver/profile_add_body.tpl
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
## Author Notes: Thanks to Marcus Smith for the suggestions and code to implement the switch!
##
##############################################################
## MOD History:  2006-06-16 - Version 1.0.0
##                          - First Release
##
##               2006-10-04 - Version 1.1.0
##                          - Added switch so the message only appears where appropriate
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
		'L_EMAIL_ADDRESS' => $lang['Email_address'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
                'L_EMAIL_EXPLAIN' => ( $mode == 'register'  && $board_config['require_activation'] == USER_ACTIVATION_SELF ) ? $lang['Email_explain'] : '',
                'L_EMAIL_EXPLAIN_IF_CHANGED' => ( $mode == 'editprofile'  && $board_config['require_activation'] == USER_ACTIVATION_SELF ) ? $lang['Email_explain_if_changed'] : '',

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Current_password'] = 'Current password';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// E-Mail Activation
$lang['Email_explain'] = 'An activation e-mail will be sent to this address.';
$lang['Email_explain_if_changed'] = 'A re-activation e-mail will be sent if you want to change your address.';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>

#
#-----[ REPLACE WITH ]------------------------------------------
#
<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span><br />
<span class="gensmall">{L_EMAIL_EXPLAIN}{L_EMAIL_EXPLAIN_IF_CHANGED}</span></td>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM