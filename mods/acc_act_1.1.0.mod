##############################################################
## MOD Title: Advanced Account Activation
## MOD Author: soapergem < soapergem@gmail.com > (Gordon Myers) N/A
## MOD Description: Adds a fourth option for administrating
##       how new users register. The existing three options
##       were to:
##          (1) immediately activate all new accounts (automatic activation),
##          (2) require that users validate their e-mail addresses (self validation),
##       or (3) require an admin to activate the account (admin activation). This
##       MOD allows the administrator to specify a "safe" e-mail domain, list of
##       e-mail addresses (separated by one comma and one space), or both (list of
##       domains and addresses) from which all new users are allowed to self-validate 
##       (option 2), while anyone not registering with this as their e-mail address must 
##       be validated by an administrator for safety (option 3). This fourth options 
##       basically combines the second and third option--it just screens the candidates
##       in the process.
## MOD Version: 1.1.0
##
## Installation Level: easy
## Installation Time: 10 Minutes
##
## Files To Edit:      6
##               - admin/admin_board.php
##               - includes/constants.php
##               - includes/usercp_activate.php
##               - includes/usercp_register.php
##               - language/lang_english/lang_admin.php
##               - templates/subSilver/admin/board_config_body.tpl
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
##############################################################
## MOD History:
##   2006-03-25 - Version 1.1.0
##      - Re-submitted to MODs Database
##      - Fixed bug with user activation e-mail
##   2006-01-22 - Version 1.0.9
##      - Re-submitted to MODs Database
##      - Fixed bug with admin e-mailing
##   2005-12-04 - Version 1.0.8
##      - Re-submitted to MODs Database
##      - Fixed in-line formatting issue
##   2005-11-21 - Version 1.0.7
##      - Re-submitted to MODs Database
##      - Fixed bug with blank input
##      - Changed explode to preg_split
##   2005-11-01 - Version 1.0.6
##      - Re-submitted to MODs Database
##   2005-10-14 - Version 1.0.5
##      - Re-submitted to MODs Database
##        - Fixed Silly Parenthesis Problem
##   2005-10-12 - Version 1.0.4
##      - Re-submitted to MODs Database
##      - Fixed Find Error in board_config_body.tpl
##   2005-10-03 - Version 1.0.3
##      - Re-submitted to MODs Database
##      - Fixed Bug with Updating SQL value
##      - Added support for list of e-mail addresses
##      - Clears allow domains when option is not selected
##   2005-09-24 - Version 1.0.0
##      - Submitted to MODs Database
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]----------------------------------
#
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('activate_email', '');

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";

#
#-----[ BEFORE, ADD ]------------------------------------------
#
			// Adv Acc Activation MOD----------
			if ($new['require_activation'] != USER_ACTIVATION_EMAIL)
			{
				$new['activate_email'] = "";
			}
			// Adv Acc Activation MOD----------

#
#-----[ FIND ]------------------------------------------
#
$activation_admin = ( $new['require_activation'] == USER_ACTIVATION_ADMIN ) ? "checked=\"checked\"" : "";

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Adv Acc Activation MOD----------
$activation_email = ( $new['require_activation'] == USER_ACTIVATION_EMAIL ) ? "checked=\"checked\"" : "";
$activate_email = ( $new['activate_email'] );
// Adv Acc Activation MOD----------

#
#-----[ FIND ]------------------------------------------
#
	"L_ADMIN" => $lang['Acc_Admin'], 

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Adv Acc Activation MOD----------
	"L_EMAIL" => $lang['Acc_email'], 
	"L_EMAIL_EXPLAIN" => $lang['Acc_email_explain'], 
	// Adv Acc Activation MOD----------

#
#-----[ FIND ]------------------------------------------
#
	"ACTIVATION_ADMIN_CHECKED" => $activation_admin, 

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Adv Acc Activation MOD----------
	"ACTIVATION_EMAIL" => USER_ACTIVATION_EMAIL, 
	"ACTIVATION_EMAIL_CHECKED" => $activation_email, 
	"ACTIVATION_EMAIL_DOMAIN" => $activate_email, 
	// Adv Acc Activation MOD----------

#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php

#
#-----[ FIND ]------------------------------------------
#
define('USER_ACTIVATION_ADMIN', 2);

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Adv Acc Activation MOD----------
define('USER_ACTIVATION_EMAIL', 3);
// Adv Acc Activation MOD----------

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_activate.php

#
#-----[ FIND ]------------------------------------------
#
		if ( intval($board_config['require_activation']) == USER_ACTIVATION_ADMIN && $sql_update_pass == '' )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
intval(

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
USER_ACTIVATION_ADMIN

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 || intval($board_config['require_activation']) == USER_ACTIVATION_EMAIL)

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
if ( $board_config['require_activation'] == USER_ACTIVATION_SELF || $board_config['require_activation'] == USER_ACTIVATION_ADMIN || $coppa )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$board_config['require_activation'] == USER_ACTIVATION_ADMIN ||

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 $board_config['require_activation'] == USER_ACTIVATION_EMAIL ||

#
#-----[ FIND ]------------------------------------------
#
			else if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )
			{
				$message = $lang['Account_inactive_admin'];
				$email_template = 'admin_welcome_inactive';
			}

#
#-----[ AFTER, ADD ]------------------------------------------
#
			// Adv Acc Activation MOD----------
			else if ( $board_config['require_activation'] == USER_ACTIVATION_EMAIL )
			{
				$require_admin = true;
				foreach (preg_split('# *, *#', $board_config['activate_email']) as $value)
				{
					if (substr($email, (strlen($email) - strlen($value))) == $value and strlen($value))
					{
						$require_admin = false;
					}
				}
				if ($require_admin)
				{
					$message = $lang['Account_inactive_admin'];
					$email_template = 'admin_welcome_inactive';
				}
				else
				{
					$message = $lang['Account_inactive'];
					$email_template = 'user_welcome_inactive';
				}
			}
			// Adv Acc Activation MOD----------

#
#-----[ FIND ]------------------------------------------
#
			if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
USER_ACTIVATION_ADMIN

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 || $require_admin

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
# 
$lang['Acc_Admin'] = 'Admin';

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Adv Acc Activation MOD----------
$lang['Acc_email'] = 'Allow Domains';
$lang['Acc_email_explain'] = 'Use this ONLY if you have selected "Allow Domains" in the previous option. You may specify a list (each element separated by one comma and one space) of both e-mail addresses (e.g. name@domain.com) and e-mail domains (e.g. domain.com) such that any new user registering with an e-mail address that matches this criterion will be automatically authenticated while all others will require administrator/moderator approval.';
// Adv Acc Activation MOD----------

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		<td class="row2"><input type="radio" name="require_activation" value="{ACTIVATION_NONE}" {ACTIVATION_NONE_CHECKED} />{L_NONE}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_USER}" {ACTIVATION_USER_CHECKED} />{L_USER}&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_ADMIN}" {ACTIVATION_ADMIN_CHECKED} />{L_ADMIN}</td>

#
#-----[ IN-LINE FIND ]------------------------------------------
# 
/>{L_ADMIN}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
# 
&nbsp; &nbsp;<input type="radio" name="require_activation" value="{ACTIVATION_EMAIL}" {ACTIVATION_EMAIL_CHECKED} />{L_EMAIL}

#
#-----[ FIND ]------------------------------------------
#
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_EMAIL}<br /><span class="gensmall">{L_EMAIL_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="activate_email" value="{ACTIVATION_EMAIL_DOMAIN}" /></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM