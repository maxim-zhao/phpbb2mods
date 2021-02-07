############################################################## 
## MOD Title: Guests' "Other IP Addresses" Remover
## MOD Author: Justas < mjomble@gmail.com > (Andres Kalle) http://www.ggcmedia.com/
##
## MOD Description: Clears the "Other IP addresses this user has posted from"
##		    part when viewing the IP of a Guest.
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: ~1 Minute
##
## Files To Edit: (1)
##      modcp.php
##
## Included Files: none
##
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
##   24-May-2005 - Version 1.0.1
##      - Switched from REPLACE WITH to BEFORE, ADD and AFTER, ADD
##
##   10-May-2005 - Version 1.0.0
##      - initial release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------
#
modcp.php

#
#-----[ FIND ]------------------------------------------
#
				$template->assign_block_vars('iprow', array(

#
#-----[ BEFORE, ADD ]----------------------------------
#
				if ( $poster_id != ANONYMOUS ) {

#
#-----[ FIND ]------------------------------------------
#
					'U_LOOKUP_IP' => "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=" . $row['poster_ip'] . "&amp;sid=" . $userdata['session_id'])
				);

#
#-----[ AFTER, ADD ]----------------------------------
#
				}

#
#-----[	SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM