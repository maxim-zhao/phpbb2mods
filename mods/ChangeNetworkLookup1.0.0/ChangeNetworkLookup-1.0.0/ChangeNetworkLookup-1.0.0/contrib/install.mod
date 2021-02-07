##############################################################
## MOD Title: Change Network Lookup
## MOD Author: MarkTheDaemon < markthedaemon@users.sourceforge.net > (Mark Barnes) http://mtdmods.sourceforge.net
## MOD Description: This MOD allows you to change the service used for looking up IP addresses via the ACP. Totally configurable via the ACP.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 8 minutes
## Files To Edit: admin/index.php
##                admin/admin_board.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/board_config_body.tpl
## Included Files: 
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
## Author Notes: Some examples of Network Lookup services are listed below, for more google is the place to go ;)
##
## http://www.dnsstuff.com/tools/tracert.ch?ip=
## http://www.network-tools.com/default.asp?host=
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
# Change phpbb_ to your forums prefix :)
INSERT INTO `phpbb_config` VALUES ('net_lookup', 'http://www.network-tools.com/default.asp?host=');
#
#-----[ OPEN ]------------------------------------------
#
admin/index.php
#
#-----[ FIND ]------------------------------------------
#
"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$reg_ip",
#
#-----[ REPLACE WITH ]------------------------------------------
#
"U_WHOIS_IP" => $board_config['net_lookup'] . "$reg_ip",
#
#-----[ FIND ]------------------------------------------
#
"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$guest_ip",
#
#-----[ REPLACE WITH ]------------------------------------------
#
"U_WHOIS_IP" => $board_config['net_lookup'] . "$guest_ip",
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
$smtp_no = ( !$new['smtp_delivery'] ) ? "checked=\"checked\"" : "";
#
#-----[ AFTER, ADD ]------------------------------------------
#
$new['net_lookup'] = $new['net_lookup'];
#
#-----[ FIND ]------------------------------------------
#
"L_RESET" => $lang['Reset'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
"L_NET_LOOKUP" => $lang['net_lookup'],
"L_NET_LOOKUP_EXPLAIN" => $lang['net_lookup_explain'],
#
#-----[ FIND ]------------------------------------------
#
"COPPA_FAX" => $new['coppa_fax']
#
#-----[ BEFORE, ADD ]------------------------------------------
#
"NET_LOOKUP" => $new['net_lookup'],
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Login_reset_time_explain']
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['net_lookup'] = 'IP Lookup URL';
$lang['net_lookup_explain'] = 'Specify a IP Lookup service URL here. It must be in the format: http://www.lookup.com/lookup.php?host=';
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<tr>
		<td class="row1">{L_SITE_DESCRIPTION}</td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="site_desc" value="{SITE_DESCRIPTION}" /></td>
</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
<tr>
		<td class="row1">{L_NET_LOOKUP}<br /><span class="gensmall">{L_NET_LOOKUP_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="40" name="net_lookup" value="{NET_LOOKUP}" /></td>
</tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
