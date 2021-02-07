##############################################################
## MOD Title: Admin Userlist regIP add on
## MOD Author: EXreaction < exreaction@gotechzilla.com > (Nathan Guse) http://www.gotechzilla.com
## MOD Description: This makes it so that you can see the IP address that the person registered with
##     in the admin Userlist mod
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: ~1 Minutes
## Files To Edit: admin/admin_userlist.php
##                templates/subSilver/admin/userlist_body.tpl
## Included Files: none
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
## If you are having trouble with spambot registrations, be sure to check out my mod to stop them...
##	you can see it here: http://www.phpbb.com/phpBB/viewtopic.php?t=373695
##
## Both the Admin Userlist mod by wGEric and Log IP Address on Registration mod by TerraFrost MUST 
##    be installed before installing this mod, otherwise you are just wasting your time. ;)
##
## Admin Userlist mod: http://www.phpbb.com/phpBB/viewtopic.php?t=117359
## Log IP Address on Registration mod: http://www.phpbb.com/phpBB/viewtopic.php?t=281477
##############################################################
## MOD History:
## 
##   2006-02-22 - Version 1.0.0
##      - Initial Release
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ OPEN ]------------------------------------------
# 

admin/admin_userlist.php

#
#-----[ FIND ]------------------------------------------
# 

		//
		// set up template varibles
		//
		$template->assign_vars(array(

# 
#-----[ AFTER, ADD ]------------------------------------------
#

			'L_REGIP' => $lang['Registration_IP'],

#
#-----[ FIND ]------------------------------------------
# 

			//
			// setup user row template varibles
			//
			$template->assign_block_vars('user_row', array(

# 
#-----[ AFTER, ADD ]------------------------------------------
#

				'USER_REGIP' => decode_ip(( $row['user_regip'] )),

# 
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/userlist_body.tpl

#
#-----[ FIND ]------------------------------------------
# note: second line is longer than shown

<tr>
{L_WEBSITE}

# 
#-----[ BEFORE, ADD ]------------------------------------------
#

				<tr>
					<td class="{user_row.ROW_CLASS}" colspan="3"><span class="gen"><b>{L_REGIP}:</b> {user_row.USER_REGIP}</span></td>
				</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM