##############################################################
## MOD Title: Topic Search with SQR MOD
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD allows to install Topic Search MOD
##                  together with Super Quick Reply MOD v1.2.1 and
##                  allows to solve a problem with JavaScript errors
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: templates/subSilver/viewtopic_body.tpl
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
## 1. Install Topic Search v1.1.0 ( http://www.phpbb.com/phpBB/viewtopic.php?t=222247 )
## 2. Install Super Quick Reply MOD v1.2.1
## 3. Install this MOD
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-09 - Version 1.0.0
##      - initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<form action="{U_TOPIC_SEARCH}" name="post" method="POST" target="_top">

#
#-----[ IN-LINE FIND ]------------------------------------------
#
name="post"

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
name="searchpost"

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM