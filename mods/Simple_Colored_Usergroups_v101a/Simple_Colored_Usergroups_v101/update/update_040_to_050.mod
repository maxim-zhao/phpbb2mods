##############################################################
## MOD Title: Simple Colored Usergroups 0.3.0 to 0.4.0 Update MOD
## MOD Author: kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
## MOD Author: Afterlife_69 < afterlife_69@hotmail.com > (Dean Newman) http://www.ugboards.com
## MOD Description: Colors all areas of the site instead of just the online list.
## MOD Version: 0.3.0
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
#-----[ REPLACE WITH ]------------------------------------------
#
   // SIMPLE COLORED USERGROUPS MOD START
   if ( $mode == 'editprofile' )
   {
      $matched = false;
      $group_priority = ( isset($HTTP_POST_VARS['group_priority']) ) ? intval($HTTP_POST_VARS['group_priority']) : 0;
      if ( is_array($color_groups['groupdata']) )
     {
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
     }
   }
   // COLOR GROUPS END
   
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