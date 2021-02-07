##############################################################
## MOD Title:          Hide User's Email Button
## MOD Author:         3Di < 3D@you3d.za.net > (Marco) http://www.phpbb2italia.za.net/phpbb2/index.php
## MOD Description:    Only ADMIN can view the button link to the User's Email, in viewprofile, viewtopic, memberlist, PMs and Groups
## MOD Version:        1.0.2
##
## Installation Level: (Easy) 
## Installation Time:  10 Minutes
## Files To Edit:
##
##	memberlist.php
##	groupcp.php
##	privmsg.php
##	viewtopic.php
##	includes/page_header.php
##	includes/usercp_viewprofile.php
##	templates/subSilver/groupcp_info_body.tpl
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
## tested on a fresh phpBB 2.0.17
##
##############################################################
## MOD History:
##
##   2005-10-15 - Version 1.0.2
##	- added code to PMs and Groups
##	- The MOD passed the MOD pre-validation process
##	- submitted
##
##   2005-10-14 - Version 1.0.1
##	- corrected a MOD template tipo
##
##   2005-10-13 - Version 1.0.0
##	- beta
##
##   2005-08-24 - Version 0.0.1 
##	- alpha
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------------
#
memberlist.php

#
#-----[ FIND ]------------------------------------------------
#	
#
		if ( !empty($row['user_viewemail']) || $userdata['user_level'] == ADMIN )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// hide User's Email MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#
			$email = '&nbsp;';
		}

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// hide User's Email MOD

#
#-----[ OPEN ]------------------------------------------
#
groupcp.php

#
#-----[ FIND ]------------------------------------------
#

	if ( !empty($row['user_viewemail']) || $group_mod )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// hide User's Email MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#
		$email = '&nbsp;';
	}

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// hide User's Email MOD

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php

#
#-----[ FIND ]------------------------------------------
#
	if ( !empty($privmsg['user_viewemail']) || $userdata['user_level'] == ADMIN )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// hide User's Email MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#
		$email = '';
	}

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// hide User's Email MOD

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
		if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// hide User's Email MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#
			$email = '';
		}

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// hide User's Email MOD

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
// hide User's Email MOD start add
	if ( $userdata['user_level'] == ADMIN ) 
	{ 
		$template->assign_block_vars('switch_user_email_admin', array()); 
	}
// hide User's Email MOD end add

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#
#
if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// hide User's Email MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#
	$email = '&nbsp;';
}

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// hide User's Email MOD

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/groupcp_info_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	  <td class="row1" align="center" valign="middle"><span class="gen">{MOD_EMAIL_IMG}</span></td>

#
#-----[ REPLACE WITH ]------------------------------------------
#
	  <td class="row1" align="center" valign="middle"><span class="gen">
<!-- BEGIN switch_user_email_admin -->
	  {MOD_EMAIL_IMG}
<!-- END switch_user_email_admin -->
	  </span></td>

#
#-----[ FIND ]------------------------------------------
#
	  <td class="{member_row.ROW_CLASS}" align="center" valign="middle"><span class="gen">{member_row.EMAIL_IMG}</span></td>
#
#-----[ REPLACE WITH ]------------------------------------------
#
	  <td class="{member_row.ROW_CLASS}" align="center" valign="middle"><span class="gen">
<!-- BEGIN switch_user_email_admin -->
	  {member_row.EMAIL_IMG}
<!-- END switch_user_email_admin -->
	  </span></td>
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM