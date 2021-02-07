##############################################################
## MOD Title: Email address explain
## MOD Author: Alexis Canver < N/A > (Alexis Canver) http://www.canver.net
## MOD Description: This mod add a explain for email address
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: (3) includes/usercp_register.php
##                    languages/lang_english/lang_main.php
##                    templates/subSilver/profile_add_body.tpl
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
##  This mod add a explain for email address.
##
##############################################################
## MOD History:
##
## 2006-05-12 - Version 1.0.0
##   - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#
#-----[ OPEN ]------------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------------
#

		'L_EMAIL_ADDRESS' => $lang['Email_address'],

#
#------[ AFTER, ADD ]-----------------------------------------
#

		'L_EMAIL_ADDRESS_EXPLAIN' => $lang['Email_address_explain'],

#
#-----[ OPEN ]------------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------
#

//
// That's all Folks!
// -------------------------------------------------

#
#------[ AFTER, ADD ]-----------------------------------------
#

$lang['Email_address_explain'] = 'If you type a wrong mail adress, you don't activate your account and don\'t get News Alerts.';

#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------------
#
<span class="gen">{L_EMAIL_ADDRESS}: *</span>
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
<span class="gen">{L_EMAIL_ADDRESS}: *</span>
#
#------[ IN-LINE AFTER, ADD ]-----------------------------------------
#
<br /><span class="gensmall">{L_EMAIL_ADDRESS_EXPLAIN}</span>
#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM