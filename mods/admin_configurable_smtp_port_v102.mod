############################################################## 
## MOD Title: Admin Configurable SMTP Port
## MOD Author: AdamR < adam@pylonhosting.com > (Adam Reyher) http://www.adamreyher.com
## MOD Description: This MOD adds a field on the Admin Panel Configuration
##                  page which allows you to define the SMTP port.
## MOD Version: 1.0.2
## 
## Installation Level: Intermediate
## Installation Time: 10 Minutes 
## Files To Edit: (4) admin_board.php, smtp.php, lang_admin.php, board_config_body.tpl
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
## Author Notes: In the SQL, remember to change "phpbb_" to your table prefix.
##
############################################################## 
## MOD History:
##     2005-08-22 - Version 1.0.2
##          - Updated to be complient with latest phpBB version and phpBB.com MOD requirements
##
##     2004-09-05  - Version 1.0.1
##          - Fixed small validation bug
##
##     2004-08-21  - Version 1.0.0
##          - First FINAL release
##
##     2004-08-20  - Version 0.0.1
##          - First BETA release
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
#
INSERT INTO phpbb_config ( config_name , config_value ) VALUES ('smtp_port', '25');

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
#
	"L_SMTP_SERVER" => $lang['SMTP_server'],


# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	// BEGIN MOD ADD - Admin Configurable SMTP Port
	"L_SMTP_PORT" => $lang['SMTP_port'],
	"L_SMTP_PORT_EXPLAIN" => $lang['SMTP_port_explain'],
	// END MOD ADD - Admin Configurable SMTP Port

# 
#-----[ FIND ]------------------------------------------ 
#
	"SMTP_HOST" => $new['smtp_host'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	// BEGIN MOD ADD - Admin Configurable SMTP Port
	"SMTP_PORT" => $new['smtp_port'],
	// END MOD ADD - Admin Configurable SMTP Port

# 
#-----[ OPEN ]------------------------------------------ 
#
includes/smtp.php

# 
#-----[ FIND ]------------------------------------------ 
#
	if( !$socket = @fsockopen($board_config['smtp_host'], 25, $errno, $errstr, 20) )

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	if( !$socket = fsockopen($board_config['smtp_host'], $board_config['smtp_port'], $errno, $errstr, 20) )

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
#
$lang['SMTP_server'] = 'SMTP Server Address';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
// BEGIN MOD ADD - Admin Configurable SMTP Port
$lang['SMTP_port'] = 'SMTP Port';
$lang['SMTP_port_explain'] = 'Only change the port if you are sure your\'s is something different than 25';
// END MOD ADD - Admin Configurable SMTP Port

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
	<tr>
		<td class="row1">{L_SMTP_SERVER}</td>
		<td class="row2"><input class="post" type="text" name="smtp_host" value="{SMTP_HOST}" size="25" maxlength="50" /></td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<tr>
		<td class="row1">{L_SMTP_PORT}<br /><span class="gensmall">{L_SMTP_PORT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="smtp_port" value="{SMTP_PORT}" size="25" maxlength="50" /></td>
	</tr>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM