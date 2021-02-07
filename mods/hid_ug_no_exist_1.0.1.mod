##############################################################
## MOD Title: Hidden Usergroups Dont Exist
## MOD Author: tehbmwman < tehbmwman@gmail.com > (N/A) N/A
## MOD Description: If a usergroup is hidden to a user, it shows them the message that
##					would normally show up if a usergroup that didnt exist is requested.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: ~1 Minute
## Files To Edit: groupcp.php
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Self explanatory. It always bothered me that a user could always find
##				 the group id or get a link to find out that the group exists. The message
##				 shown is the same as the one that is used when you request a usergroup
##				 that actually doesn't exist:
##
##				 "That user group does not exist"
##
##############################################################
## MOD History:
##
##	 2005-02-11	- Version 1.0.1
##		- Fixed: Didnt make exception for administrators.
##   2005-02-11 - Version 1.0.0
##      - Initial Submission
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]---------------------------------------------
#
groupcp.php
#
#-----[ FIND ]---------------------------------------------
#
$members_count =
#
#-----[ AFTER, ADD ]---------------------------------------
#
	// Begin "Hidden Groups Dont Exist" Mod
	if ( $userdata['user_id'] != $group_moderator['user_id'] && $userdata['user_level'] != ADMIN )
	{
		for ( $i = 0; $i < $members_count && !$member; $i++ )
		{
			if ( $group_members[$i]['user_id'] == $userdata['user_id'] )
			{
				$member = true;
				break;
			}
		}
		if ( !$member )
		{
			message_die(GENERAL_MESSAGE, $lang['Group_not_exist']); 
		}
	}
	// End "Hidden Groups Dont Exist" Mod
#
#-----[ SAVE/CLOSE ALL FILES ]-----------------------------
#
# EoM