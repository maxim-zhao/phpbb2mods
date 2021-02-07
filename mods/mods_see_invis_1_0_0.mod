##############################################################
## MOD Title: Allow Moderators to See Invisible
## MOD Author: gfmorrs < gfmorris@gfmorris.com > (Geof F. Morris) http://gfmorris.com/
## MOD Description: Allows all moderators to see invisible users.
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: 1 Minute
## Files To Edit: includes/page_header.php
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:  Many thanks for morpheus2matrix to pointing out where to make a modification.
##                This might be the simplest MOD ever for phpBB.  :)  Feel free to give him all
##                credit, for I am just simply writing this up.
##
##############################################################
## MOD History:
##
##   2003-12-06 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )

#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD )

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 