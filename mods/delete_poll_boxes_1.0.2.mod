############################################################## 
## MOD Title: Delete Poll Boxes
## MOD Author: darkassasin93 <mgbowen93@comcast.net> (Matthew Bowen) http://www.mgbowen.com
## MOD Description: This MOD deletes the poll boxes in posting screen and topic viewing screen.
## MOD Version: 1.0.1
## 
## Installation Level:	Easy
## Installation Time:	3 Minutes
## Files To Edit: templates/subSilver/viewtopic_body.tpl;
##		  templates/subSilver/posting_body.tpl
##
## Included Files: N/A
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: If you have other styles you wish to use this on, then replace
## "templates/subSilver/" with "templates/*your style name*/" where "*your style name*"
## is the folder name of the style in the "templates" directory.
##############################################################
## MOD History:
##
##	1/3/05 - Version 1.0.0
##		Initial Release; Denied by MOD Team
##	1/3/05 - Version 1.0.1
##		Updated to phpBB coding standards.
##	1/6/05 - Version 1.0.2
##		SQL is removed due to unability to remove forums in the ACP.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
	</tr>
	{POLL_DISPLAY} 
	<tr>
#
#-----[ REPLACE WITH ]----------------------------------------
#
	</tr>
	<tr>
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
	</tr>
	{POLLBOX} 
	<tr> 
#
#-----[ REPLACE WITH ]----------------------------------------
#
	</tr>
	<tr> 
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM