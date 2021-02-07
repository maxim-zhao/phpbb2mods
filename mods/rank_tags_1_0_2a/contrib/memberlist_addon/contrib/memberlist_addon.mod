##############################################################
## MOD Title: Memberlist addon for Rank Tags
## MOD Author: angelp1ay < n/a > (n/a) n/a
## MOD Description: This is an addon for eviL3's rank tags,
##                  and will add support for the rank_in_memberlist_1.0.2
##                  MOD.
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
##
## Files To Edit: memberlist.php
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
## rank_in_memberlist_1.0.2 and rank tags are required for this MOD.
##
##############################################################
## MOD History:
##
##   2006-11-28 - Version 1.0.0
##      - First release :)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
memberlist.php
#
#-----[ FIND ]------------------------------------------
#
$rank_image = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$rank_tags = '';
#
#-----[ FIND ]------------------------------------------
#
$user_rank
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$rank_tags = ($ranksrow[$j]['rank_tags']) ? explode("\n", $ranksrow[$j]['rank_tags']) : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$user_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $user_rank . $rank_tags[1] : $user_rank;
#
#-----[ FIND ]------------------------------------------
#
$user_rank
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$rank_tags = ($ranksrow[$j]['rank_tags']) ? explode("\n", $ranksrow[$j]['rank_tags']) : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$user_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $user_rank . $rank_tags[1] : $user_rank;
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
