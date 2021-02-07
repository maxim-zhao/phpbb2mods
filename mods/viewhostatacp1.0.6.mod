##############################################################
## MOD Title: Admin view host at acp
## MOD Author: paul < mods@paulscripts.nl > (paul sohier) http://www.paulscripts.nl
## MOD Description: At a columm for the host of the user in onlinelist at acp.
## MOD Version: 1.0.6
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit:
##		admin/index.php
##		templates/subSilver/admin/index_body.tpl
##		language/lang_english/lang_admin.php
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
## Author Notes: You can give the columms a witdh value, if you want this!
##
##############################################################
## MOD History:
##
##   2007-10-07 - Version 1.0.6
##      - Updating text template to 2.0.22 standard.
##      - Updated some some finds.
##
##   2005-04-21 - Version 1.0.5
##		- Remove part at modcp, it is already there.
##
##   2005-04-21 - Version 1.0.4
##		- Edit some template actions
##
##   2005-04-17 - Version 1.0.3
##		- Edit some template actions
##
##   2005-04-15 - Version 1.0.2
##		- Edit some actions
##
##
##   2005-04-10 - Version 1.0.1
##		- Edit some actions for submitting 
##
##   2005-02-26 - Version 0.9.1
##      - Add same function at modcp.(Removed, at version 1.0.5).
##		- Some bugs replaced.
##
##   2005-02-25 - Version 0.9
##      - first release.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

admin/index.php

#
#-----[ FIND ]------------------------------------------
#

"L_IP_ADDRESS" => $lang['IP_Address'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

"L_IP_HOST" => $lang['IP_host'],

#
#-----[ FIND ]------------------------------------------
#

"IP_ADDRESS" => $reg_ip, 

#
#-----[ AFTER, ADD ]------------------------------------------
#

"HOST_IP" => gethostbyaddr($reg_ip),

#
#-----[ FIND ]------------------------------------------
#

"IP_ADDRESS" => $guest_ip, 

#
#-----[ AFTER, ADD ]------------------------------------------
#

"HOST_IP" => gethostbyaddr($guest_ip),

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

$lang['IP_host'] = 'Host';

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<th width="{%:1}%" height="25" class="thCornerR">&nbsp;{L_IP_ADDRESS}

#
#-----[ INCREMENT ]------------------------------------------
#

%:1 -10

#
#-----[ IN-LINE FIND ]------------------------------------------
#

class="thCornerR"

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#

class="thTop"

#
#-----[ FIND ]------------------------------------------
#

</tr>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

<th class="thCornerR">&nbsp;{L_IP_HOST}&nbsp;</th>
  
#
#-----[ FIND ]------------------------------------------
#

<td width="{%:1}%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_WHOIS_IP}"

#
#-----[ INCREMENT ]------------------------------------------
#

%:1 -10

#
#-----[ FIND ]------------------------------------------
#

</tr>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

<td align="center" nowrap="nowrap" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen">{reg_user_row.HOST_IP}</span>&nbsp;</td>
  
#
#-----[ FIND ]------------------------------------------
#

<td colspan="{%:1}" height="1" class="row3">

#
#-----[ INCREMENT ]------------------------------------------
#

%:1 +1

#
#-----[ FIND ]------------------------------------------
#

<td width="{%:1}%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{guest_user_row.U_WHOIS_IP}
#
#-----[ INCREMENT ]------------------------------------------
#

%:1 -10
#
#-----[ FIND ]------------------------------------------
#

</tr>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

<td align="center" nowrap="nowrap" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.HOST_IP}</span>&nbsp;</td>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 