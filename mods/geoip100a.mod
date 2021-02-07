##############################################################
## MOD Title: Geo IP Tool Mod
## MOD Author: JonathonReinhart < N/A > (JonathonReinhart) http://jonathon.onthefive.com
## MOD Description: Adds geoiptool.com links to the IP lookup page
## MOD Version: 1.0.0
##
## Installation Level: Intermediate
## Installation Time: 10 Minutes
## Files To Edit: language/lang_english/lang_main.php,
##      modcp.php,
##      templates/subSilver/modcp_viewip.tpl,
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
## Author Notes:
##
##############################################################
## MOD History:
##
##   2007-02-01 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
# (Line ~891)
#
$lang['Lookup_IP'] = 'Look up IP address';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Geo_IP'] = 'Geo IP Tool';



#
#-----[ OPEN ]------------------------------------------
#
modcp.php

#
#-----[ FIND ]------------------------------------------
#
# (Line ~1014)
#
'L_LOOKUP_IP' => $lang['Lookup_IP'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_GEO_IP' => $lang['Geo_IP'],

#
#-----[ FIND ]------------------------------------------
#
# (Line ~1022)
#
'U_LOOKUP_IP' => "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=$ip_this_post&amp;sid=" . $userdata['session_id'])

#
#-----[ BEFORE, ADD ]------------------------------------------
#
'U_GEO_IP' => "http://www.geoiptool.com/en/?IP=" . $ip_this_post ,

#
#-----[ FIND ]------------------------------------------
#
# (Line ~1064)
#
'U_LOOKUP_IP' => "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=" . $row['poster_ip'] . "&amp;sid=" . $userdata['session_id'])

#
#-----[ BEFORE, ADD ]------------------------------------------
#
'U_GEO_IP' => "http://www.geoiptool.com/en/?IP=" . $ip ,



#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/modcp_viewip.tpl

#
#-----[ FIND ]------------------------------------------
#
# (Line ~20)
#
<td align="right"><span class="gen">[ <a href="{U_LOOKUP_IP}">{L_LOOKUP_IP}</a>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
[

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
# (Include a space at the end of this)
#
[ <a href="{U_GEO_IP}" target="_blank">{L_GEO_IP}</a> ] 

#
#-----[ FIND ]------------------------------------------
#
# (Line ~50)
#
<td align="right"><span class="gen">[ <a href="{iprow.U_LOOKUP_IP}">{L_LOOKUP_IP}</a>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
[

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
# (Include a space at the end of this)
#
[ <a href="{iprow.U_GEO_IP}" target="_blank">{L_GEO_IP}</a> ] 




#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM