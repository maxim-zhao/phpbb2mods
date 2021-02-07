############################################################## 
## MOD Title: New Posts link in viewtopic 
## MOD Author: Xore < xore@azuriah.com > (Robert Hetzler) http://www.azuriah.com 
## MOD Description: Template modification: see new posts link in viewtopic 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: 1 Minutes 
## Files To Edit: templates/subSilver/viewtopic_body.tpl
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: I saw a request for this, saw it took 2 seconds, so i did it :P
## 
############################################################## 
## MOD History: 
## 
##   2003-09-23 - Version 1.0.0 
##      - First version release. w000. with luck, there will never be others... 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/viewtopic_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
	  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	<!-- BEGIN switch_user_logged_in -->
	<td align="left" valign="bottom" nowrap="nowrap"><a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a></td>
	<!-- END switch_user_logged_in -->
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
