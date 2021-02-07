##############################################################
## MOD Title: 		Rank Image in Profile MOD
## MOD Author: 		Nt3N < nt3n@fifaonline.it > (Nt3N) n/a
## MOD Description: 	This mod allows you to show Rank Images in the Profile pages.
##				Rank Images will be displayed under Rank Names.
## MOD Version: 	1.0.0
## Compatibility: 2.0.8 (previous releases have not been tested)
##
## Installation Level: 	Easy
## Installation Time: 	less than 1 Minute
##
## Files To Edit (3): 	templates/subSilver/profile_view_body.tpl	
##
## Included Files (0):
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
##
##	Tnx for downloading my 2nd MOD for phpBB! 
##    I hope you like it! If u have any trouble while
##    installing this MOD, feel free to contact by email!
##	
##	Nj0y :D - questions, suggestions, etc to nt3n@fifaonline.it
##
##	Very Special Tnx go to phpBB.com MOD-Team for publishing my MODs!
##
##    FORZA JUVENTUS SEMPRE E COMUNQUE!
##
############################################################## 
## MOD History: 
##
##  2004-08-19 - Version 1.0.0
##      - First (bug-free) release!
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_view_body.tpl

#
#-----[ FIND ]------------------------------------------
#

	<td class="row1" height="6" valign="top" align="center">{AVATAR_IMG}<br /><span class="postdetails">{POSTER_RANK}</span></td>

#
#-----[ IN-LINE FIND ]------------------------------------------
#

{POSTER_RANK}</span>

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

<br />{RANK_IMAGE}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM