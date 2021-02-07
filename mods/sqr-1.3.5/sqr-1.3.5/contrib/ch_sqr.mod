##############################################################
## MOD Title: Categories Hierarchy (sub-forums) with SQR MOD
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD allows to install Categories Hierarchy
##                  (sub-forums) MOD v2.1.1 RC5+ together with Super
##                  Quick Reply MOD v1.3.2+
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: viewtopic_quickreply.php
##
## Included Files: (n/a)
##
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
## 1. Install Categories Hierarchy (sub-forums) MOD v2.1.1 RC5 ( http://www.phpbb.com/phpBB/viewtopic.php?t=265040 )
## 2. Install Super Quick Reply MOD v1.3.0
## 3. Install this MOD
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-07-04 - Version 1.0.0
##      - initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# $hidden_form_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
$hidden_form_fields .= '<input type="hidden" name="'

#
#-----[ AFTER, ADD ]---------------------------------------
#
$hidden_form_fields .= '<input type="hidden" name="last_post" value="'.$forum_topic_data['topic_last_post_id'].'" />';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM