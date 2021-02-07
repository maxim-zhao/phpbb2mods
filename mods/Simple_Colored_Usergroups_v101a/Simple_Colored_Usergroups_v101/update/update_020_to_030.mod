##############################################################
## MOD Title: Simple Colored Usergroups 0.2.0 to 0.3.0 Update MOD
## MOD Author: Afterlife_69 < afterlife_69@hotmail.com > (Dean Newman) http://www.ugboards.com
## MOD Description: Colors all areas of the site instead of just the online list.
## MOD Version: 0.1.0
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
##		For the people who like everywhere colored.
##############################################################
## MOD History:
## 
##	2006-04-11 - Version 0.1.0
##		-	Released Addon
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
	// SIMPLE COLORED USERGROUPS MOD START
	$group_priority = ( isset($HTTP_POST_VARS['group_priority']) ) ? intval($HTTP_POST_VARS['group_priority']) : 0;
	// COLOR GROUPS END

#
#-----[ REPLACE WITH ]------------------------------------------
#
	// SIMPLE COLORED USERGROUPS MOD START
	$matched = false;
	$group_priority = ( isset($HTTP_POST_VARS['group_priority']) ) ? intval($HTTP_POST_VARS['group_priority']) : 0;
	foreach($color_groups['groupdata'] AS $color_group)
	{
		if ( is_array($color_group['group_users']) )
		{
			if ( in_array($userdata['user_id'], $color_group['group_users']) && $color_group['group_id'] == $group_priority )
			{
				$matched = true;
			}
		}
	}
	if ( ! $matched )
	{
		$group_priority = 0;
	}
	// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
	// SIMPLE COLORED USERGROUPS MOD START
	$group_values = '';
	foreach($color_groups['groupdata'] AS $color_group)
	{
		$group_priority_selected = ( $userdata['group_priority'] == $color_group['group_id'] ) ? ' selected="selected"' : '';
		$group_values .= '<option value="' . $color_group['group_id'] . '"' . $group_priority_selected . '>' . $color_group['group_name'] . '</option>';
	}
	if ( $group_values )
	{
		$group_drop_down = '<select name="group_priority">' . $group_values . '</select>';
	}
	else
	{
		$group_drop_down = $lang['Not_in_group'];
	}
	// COLOR GROUPS END

#
#-----[ REPLACE WITH ]------------------------------------------
#
	// SIMPLE COLORED USERGROUPS MOD START
	$group_values = '';
	$group_count = 0;
	foreach($color_groups['groupdata'] AS $color_group)
	{
		if ( in_array($userdata['user_id'], $color_group['group_users']) )
		{
			$group_priority_selected = ( $userdata['group_priority'] == $color_group['group_id'] ) ? ' selected="selected"' : '';
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
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		<!-- SIMPLE COLORED USERGROUPS MOD BY Afterlife_69 (http://www.ugboards.com) AND kkroo (http://phpbb-login.sourceforge.net) START -->
		<!-- BEGIN switch_edit_profile -->
	<tr> 
	  <td class="row1"><span class="gen">{L_GROUP_PRIORITY}:</span></td>
	  <td class="row2"><span class="gensmall">{GROUP_PRIORITY_SELECT}</span></td>
	</tr>
		<!-- END switch_edit_profile -->
		<!-- SIMPLE COLORED USERGROUPS END -->

#
#-----[ REPLACE WITH ]------------------------------------------
#
	<!-- SIMPLE COLORED USERGROUPS MOD BY Afterlife_69 (http://www.ugboards.com) AND kkroo (http://phpbb-login.sourceforge.net) START -->
	<!-- BEGIN switch_color_groups -->
	<tr> 
	  <td class="row1"><span class="gen">{L_GROUP_PRIORITY}:</span></td>
	  <td class="row2"><span class="gensmall">{GROUP_PRIORITY_SELECT}</span></td>
	</tr>
	<!-- END switch_color_groups -->
	<!-- SIMPLE COLORED USERGROUPS END -->

#
#-----[ DIY INSTRUCTIONS ]---------------------------------------------
#
 This will add a version checker for this MOD compatible with the
 Advanced Version Check MOD, if you do not have this MOD you do not
 HAVE to upload this file

copy root/admin/avc_mods/avc_scu.php to admin/avc_mods/avc_scu.php

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM