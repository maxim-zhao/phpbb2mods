##############################################################
## MOD Title:          Hide User's WebSite Button
## MOD Author:         3Di < 3D@you3d.za.net > (Marco) http://www.phpbb2italia.za.net/phpbb2/index.php
## MOD Description:    Only ADMIN can view the button link to the User's Website, in viewprofile, viewtopic, memberlist, PMs and Groups
## MOD Version:        1.0.2
##
## Installation Level: (Easy) 
## Installation Time:  10 Minutes
## Files To Edit:
##      memberlist.php
##      groupcp.php
##      privmsg.php
##      viewtopic.php
##      includes/usercp_viewprofile.php
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
##############################################################
## MOD History:
##
##   2005-10-14 - Version 1.0.2
##	- added code to PMs and Groups
##	- The MOD passed the MOD pre-validation process
##	- submitted
##
##   2005-10-13 - Version 1.0.1
##	- corrected a MOD template tipo
##	- code better written
##	- The MOD passed the MOD pre-validation process
##	- submitted
##
##   2005-08-27 - Version 1.0.0
##	- submitted
##
##   2005-08-24 - Version 0.0.1 BETA
##	- first release
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
#	the line is longer...
		$www_img = ( $row['user_website'] 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Hide User Website MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
		$www = ( $row['user_website'] 

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// Hide User Website MOD

#
#-----[ OPEN ]------------------------------------------------
#
groupcp.php

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
	$www_img = ( $row['user_website'] 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Hide User Website MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
	$www = ( $row['user_website'] 

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// Hide User Website MOD

#
#-----[ OPEN ]------------------------------------------------
#
privmsg.php

#
#-----[ FIND ]------------------------------------------------
#	the line is longer...
	$www_img = ( $privmsg['user_website'] 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Hide User Website MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
	$www = ( $privmsg['user_website'] 

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// Hide User Website MOD

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
		$www_img = ( $postrow[$i]['user_website'] 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Hide User Website MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
		$www = ( $postrow[$i]['user_website']

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// Hide User Website MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
$www_img = ( $profiledata['user_website'] 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Hide User Website MOD
if ( $userdata['user_level'] == ADMIN )
{

#
#-----[ FIND ]------------------------------------------
#	the line is longer...
$www = ( $profiledata['user_website'] 

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
// Hide User Website MOD

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM