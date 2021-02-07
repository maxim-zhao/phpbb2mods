########################################################
## MOD Title:		Fix Background image for phpBB 2.0.X
## MOD Author:		Selven  <selven@zaion.com> (Selven) http://www.zaion.com
## MOD Description:	This mod allows the administrator to set an background
##   		 		image directly from theme modification in admin control panel
##   		 		Please read authors note for major clearity. 
## MOD Version: 1.1.0 
## 
## Installation Level:  easy
## Installation Time:   2 Minutes
## Files To Edit:       3
##				templates/subSilver/overall_header.tpl
##				templates/subSilver/simple_header.tpl
##				templates/subSilver/subSilver.css
## Included Files:	none
########################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:	This mod only fix an bug present in subsilver template, the background for subsilver 
##			is the part E5E5E5 down of white table of forum.
##			The background image has to be placed in templates/subSilver/images folder.
##			Subsilver.css has to be edited only if you use css, and not use the normal acp styles
##			managment, replace yourimages.gif with the name of your background.
############################################################## 
## MOD History:
##    20/01/2005 - v. 1.1.0 Added fix for simple header.tpl (Acp) and subsilver.css (requested by PhpBB Mod Manager)
##    15/12/2004 - v. 1.0.0 FINAL
##		 
########################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	background-color: {T_BODY_BGCOLOR};


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	background-image: url(templates/subSilver/images/{T_BODY_BACKGROUND});

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/simple_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	background-color: {T_BODY_BGCOLOR};


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	background-image: url(templates/subSilver/images/{T_BODY_BACKGROUND});

# 
#-----[ OPEN ]------------------------------------------ 
# Not necessary read authors note
templates/subSilver/subSilver.css

# 
#-----[ FIND ]------------------------------------------ 
# 
	background-color:


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	background-image: url(templates/subSilver/images/yourimages.gif);

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
