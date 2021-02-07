############################################################## 
## MOD Title:		Site link 1.0.0
## MOD Author:		Ptirhiik < ptirhiik@clanmckeen.com > (Pierre) http://rpgnet.clanmckeen.com
## MOD Description:
##			Change the index nav sentence to add the site link in front of the index
## MOD Version:		1.0.0
## 
## Installation Level:	Easy
## Installation Time:	3 Minutes
## Files To Edit:
##			includes/page_header.php
##			templates/subSilver/overall_header.tpl
##
## Included Files:	n/a
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
##   2003-11-13 - Version 1.0.0
##      - first release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ OPEN ]------------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------------
#
$template->assign_vars(array(
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
if ( !isset($nav_separator) )
{
	$nav_separator = '&nbsp;->&nbsp;'; // alternate cuter choice : &nbsp;&raquo;&nbsp;
}
#
#-----[ FIND ]------------------------------------------------
#
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
#
#-----[ REPLACE WITH ]---------------------------------------- 
#
	'L_LOGO' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'L_INDEX' => trim(sprintf($lang['Forum_Index'], '')),
#
#-----[ FIND ]------------------------------------------------
#
	'U_INDEX' => append_sid('index.'.$phpEx),
#
#-----[ REPLACE WITH ]---------------------------------------- 
#
	'U_LOGO' => append_sid('index.'.$phpEx),
	'U_INDEX' => './../" class="nav">' . $board_config['sitename'] . '</a>' . $nav_separator . '<a href="' . append_sid('index.'.$phpEx),
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------------
#
# this is a partial search : the full line is longer
#
{U_INDEX}
#
#-----[ IN-LINE FIND ]---------------------------------------- 
#
{U_INDEX}
#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
{U_LOGO}
#
#-----[ IN-LINE FIND ]---------------------------------------- 
#
L_INDEX
#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
L_LOGO
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM