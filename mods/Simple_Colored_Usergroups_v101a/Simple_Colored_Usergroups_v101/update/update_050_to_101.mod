##############################################################
## MOD Title: Simple Colored Usergroups 0.3.0 to 0.4.0 Update MOD
## MOD Author: kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
## MOD Author: Afterlife_69 < afterlife_69@hotmail.com > (Dean Newman) http://www.ugboards.com
## MOD Description: Colors all areas of the site instead of just the online list.
## MOD Version: 0.5.0
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit:	includes/usercp_register.php
## Included Files:	root/admin/avc_mods/avc_scu.php
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
##	Author Notes: 
##		Version Upgrade
##############################################################
## MOD History:
## 
##	2006-04-11 - Version 0.1.0
##		-	Released Addon
##
##	2006-04-11 - Version 0.2.0
##		-	Update from version 0.3.0 to 0.4.0
##
##	2006-06-10 - Version 0.3.0
##		-	Update from version 0.4.0 to 0.5.0
##
##	2006-07-13 - Version 0.4.0
##		-	Update from version 0.5.0 to 1.0.0: No changes in code made, only version number increased for Mod DB
## 
##	2006-07-21 - Version 0.5.0
##		-	Update from version 1.0.0 to 1.0.1
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
#
		$group_values = '';
		$group_count = 0;
		foreach($color_groups['groupdata'] AS $color_group)
		{
			if ( in_array($userdata['user_id'], $color_group['group_users']) )
			{
				$group_priority_selected = ( $this_userdata['group_priority'] == $color_group['group_id'] ) ? ' selected="selected"' : '';
				$group_values .= '<option value="' . $color_group['group_id'] . '"' . $group_priority_selected . '>' . $color_group['group_name'] . '</option>';
				$group_count++;
			}
		}
		if ( $group_values && $group_count > 1)
		{
			$group_drop_down = '<select name="group_priority">' . $group_values . '</select>';
			$template->assign_block_vars('switch_color_groups', array());
		}
		else
		{
			$group_priority = 0;
		}

#
#-----[ REPLACE WITH ]------------------------------------------
#
# just delete


#
#-----[ FIND ]------------------------------------------
#
		$icq = $this_userdata['user_icq'];

#
#-----[ BEFORE, ADD ]------------------------------------------
#

		// SIMPLE COLORED USERGROUPS MOD START
		foreach($color_groups['groupdata'] AS $color_group)
		{
			if ( in_array($this_userdata['user_id'], $color_group['group_users']) )
			{
				$group_priority_selected = ( $this_userdata['group_priority'] == $color_group['group_id'] ) ? ' selected="selected"' : '';
				$group_values .= '<option value="' . $color_group['group_id'] . '"' . $group_priority_selected . '>' . $color_group['group_name'] . '</option>';
				$group_count++;
			}
		}
		if ( $group_values && $group_count > 1)
		{
			$group_drop_down = '<select name="group_priority">' . $group_values . '</select>';
			$template->assign_block_vars('switch_color_groups', array());
		}
		else
		{
			$group_priority = 0;
		}
		// COLOR GROUPS END
   
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM