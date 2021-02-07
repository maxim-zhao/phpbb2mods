##############################################################
## MOD Title:          Simple Hidden Users Stopper but ADMIN
## MOD Author:         3Di < 3D@you3d.za.net > (Marco) http://www.phpbb2italia.za.net/phpbb2/index.php
## MOD Description:    The simpliest way to get rid of hidden users, ADMIN have privilege.
## MOD Version:        1.0.2
##
## Installation Level: (Easy) 
## Installation Time:  3 Minutes
## Files To Edit:
##      includes/page_header.php
##      templates/subSilver/profile_add_body.tpl 
##
## Included Files:
##      N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: uh? :-)
##
## tested on a fresh phpBB 2.0.17 (localhost)
##
##	thanks to Marshalrusty for the SQL tip
##
##############################################################
## MOD History:
##
##   2005-10-27 - Version 1.0.2
##      - added a missing semi-colon on SQL
##      - mod submitted
##
##   2005-10-27 - Version 1.0.1
##      - code rewritten
##      - added ADMIN privilege to be hidden
##      - typo corrected
##      - mod submitted
##
##   2005-09-26 - Version 1.0.0
##      - mod submitted
##
##   2005-09-24 - Version 0.1.0 BETA
##      - SQL added
##
##   2005-08-24 - Version 0.0.1 BETA
##      - first release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]-------------------------------------------------
#
#	Users will likely want to make all current users visible, so do that right after the MOD
#
UPDATE phpbb_users SET user_allow_viewonline=1;
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
$template->assign_block_vars('switch_user_logged_in', array());
#
#-----[ AFTER, ADD ]------------------------------------------
#
	if ( $userdata['user_level'] == ADMIN ) 
	{ 
		$template->assign_block_vars('switch_admin_logged_in', array()); 
	}
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl 
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_HIDE_USER}:</span></td>
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
<!-- BEGIN switch_admin_logged_in -->
#
#-----[ FIND ]------------------------------------------
#
		<span class="gen">{L_NO}</span></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_admin_logged_in -->
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM