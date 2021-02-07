##############################################################
## MOD Title: Hide Style Select
## MOD Author: Falstaff < david@falstaffenterprises.com > (David Falstaff) http://www.falstaffenterprises.com
## MOD Description: If you select 'Override user style' in General Configuration this mod hides
##                  the 'Board Style' drop-down in the user's profile CP to avoid confusion.
## MOD Version: 1.0.2
##
## Installation Level: (Easy)
## Installation Time: ~1 Minute
## Files To Edit: 
##                templates/subSilver/profile_add_body.tpl
##                includes/usercp_register.php
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##############################################################
## MOD History:
##
##   2005-02-18 - Version 1.0.2
##      - corrected to control user registration form also
##
##   2004-09-24 - Version 1.0.1
##      - updated to correct typos
##
##   2004-09-22 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ OPEN ]---------------------------------------------- 
#

templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]---------------------------------------------- 
#

	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_STYLE}:</span></td>
	  <td class="row2"><span class="gensmall">{STYLE_SELECT}</span></td>
	</tr>

# 
#-----[ REPLACE WITH ]--------------------------------------
#

	<!-- BEGIN override_user_style_block -->
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_STYLE}:</span></td>
	  <td class="row2"><span class="gensmall">{STYLE_SELECT}</span></td>
	</tr>
	<!-- END override_user_style_block -->

# 
#-----[ OPEN ]---------------------------------------------- 
#

includes/usercp_register.php

# 
#-----[ FIND ]---------------------------------------------- 
# 

	}

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

	?>

# 
#-----[ BEFORE, ADD ]---------------------------------------------- 
#

		// Begin Hide Style Select MOD
    	if( $board_config['override_user_style']) 
    	{
    	} 
    	else 
    	{
	    	$template->assign_block_vars('override_user_style_block', array());
    	}
    	// End Hide Style Select MOD

    	
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 