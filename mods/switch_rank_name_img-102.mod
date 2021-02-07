##############################################################
## MOD Title: Switch Rank Name and Image
## MOD Author: zanejin < zanejincheng@yahoo.com > (N/A) http://www.zoidsng.vze.com/
## MOD Description: This MOD will switch the places of every member's rank name and image in the viewtopic 
##   profile.  This somewhat improves how the viewtopic profile part looks.
## 
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: ~3 Minutes
## Files To Edit: 
##                   templates/subSilver/viewtopic_body.tpl
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## Copyright [c] Zanejin, < zanejincheng@yahoo.com > All Rights Reserved
##
## Please do not just take my MOD and use it anywhere, stating that it was your own work. 
## If you wish to take my MOD, please notify me of it via email, then retain the copyright notice above.
##
## EasyMOD
## ===========
## This MOD can be successfully installed using EasyMOD.
##############################################################
## MOD History:
##
##   2004-10-01 - Version 1.0.2
##      - Fixed a bug
##
##   2004-08-21 - Version 1.0.1
##      - Made this MOD more compatible with other templates
##
##   2004-08-06 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
# NOTE: You will need to perform the following actions for all of your different templates.
#
templates/subSilver/viewtopic_body.tpl


#
#-----[ FIND ]------------------------------------------
#
{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}


#
#-----[ IN-LINE FIND ]------------------------------------------
#
{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}


#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
{postrow.RANK_IMAGE}{postrow.POSTER_RANK}<br />{postrow.POSTER_AVATAR}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM