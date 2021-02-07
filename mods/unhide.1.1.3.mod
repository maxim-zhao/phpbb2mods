############################################################## 
## MOD Title: Unhide MOD 
## MOD Author: Wicher < thecoin@detecties.com > (Wicher) http://www.detecties.com/MadeMods
## MOD Description: This mod rules out the possibility for users to hide them selves for other users. Also when they visit there profile and they press the ok button they will be set visible.
## MOD Version: 1.1.3
## Installation Level: (Easy) 
## Installation Time: 1 Minute 
## Files To Edit:
##	 templates/SubSilver/profile_add_body.tpl
## Included Files: n/a
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
##                Via "User Admin" in the ControlPanel the admin can still make users hidden.
############################################################## 
## MOD History:
##
##   2004-06-14 - Version 1.1.3
##	 	- Added some Author Notes.
##
##   2004-06-14 - Version 1.1.2
##      - Fixed tipo
##
##   2004-06-14 - Version 1.1.1
##      - first release [beta]
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/SubSilver/profile_add_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
  <input type="radio" name="hideonline" value="1" {HIDE_USER_YES} />
  <span class="gen">{L_YES}</span>   
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
<!--  <input type="radio" name="hideonline" value="1" {HIDE_USER_YES} />
  <span class="gen">{L_YES}</span>   
-->  
#
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
