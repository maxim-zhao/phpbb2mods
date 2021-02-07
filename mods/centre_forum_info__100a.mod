##############################################################
## MOD Title: Centre Forum Information
## MOD Author: battye < (N/A) > (N/A) http://www.online-scrabble.com
## MOD Description: Before, the forum information was not vertically centred if there were no forum moderators. This MOD corrects that.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes (According to EasyTIME: http://www.cmxmods.net/easytime.php)
##
## Files To Edit: 		index.php
##						templates/subSilver/index_body.tpl
##
## Included Files: 	N/A
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
## Author Notes: Enjoy :-)
##############################################################
## MOD History:
##
##   2006-01-07 - Version 1.0.0
##      - Renamed to 1.0.0 from 0.0.1, no changes.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]-----------------------------
#
index.php

#
#-----[ FIND ]-----------------------------
#
							if ( count($forum_moderators[$forum_id]) > 0 )
							{	

#
#-----[ AFTER, ADD ]-------------------
#
								$moderator_linebreak = '<br />';

#
#-----[ FIND ]-----------------------------
#
								$l_moderators = '&nbsp;';

#
#-----[ BEFORE, ADD ]-------------------
#
								$moderator_linebreak = '';

#
#-----[ FIND ]-----------------------------
#
								'MODERATORS' => $moderator_list,

#
#-----[ AFTER, ADD ]-------------------
#
								'MODERATOR_LB' => $moderator_linebreak,

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
</span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
		
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<br />

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
{catrow.forumrow.MODERATOR_LB}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM