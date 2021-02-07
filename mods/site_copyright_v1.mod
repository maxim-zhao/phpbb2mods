############################################################## 
## MOD Title: Site Copyright 
## MOD Author: Magnotta < boreallis@boreallis.ca > (N/A) http://www.boreallis.ca 
## MOD Description: Adds a copyright for your site right above the 
##                  "powered by phpBB 2.0.*" copyright 
## MOD Version: 1.0.0
## 
## Installation Level: (Easy) 
## Installation Time: 5 Minutes 
## Files To Edit: 
##		 admin_board.php 
##  		 page_tail.php             
##  		 lang_admin.php
##               overall_footer.tpl
##		 board_config_body.tpl
## Included Files: N/A
##############################################################  
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
##Author Notes:
##This Mod should not be used to replace the phpBB copyright, just
##to add a copyright for your site. This is good if your forum is
##simply 1 feature on your site out of many. 
##
##This mod will only be supported in its thread at phpBB.com or in
##its forum at Boreallis.ca
##############################################################
## MOD History: 
## 
##   2004-07-20 - Version 0.1.0 
##      - first release
##   2004-08-11 - Version 1.0.0
##      - final version
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
# 

INSERT INTO phpbb_config (config_name, config_value) VALUES ('copyright_year', '2004');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('copyright_name', 'Site Name Goes Here');

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

	"L_RESET" => $lang['Reset'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

	//Start Copyright Information
	"COPYRIGHT_NAME" => $new['copyright_name'],
	"COPYRIGHT_YEAR" => $new['copyright_year'],
	"L_SITE_COPYRIGHT" => $lang['site_copyright'],
	"L_SITE_COPYRIGHT_EXPLAIN" =>$lang['site_copyright_explain'],
	//End Copyright Information

# 
#-----[ OPEN ]------------------------------------------ 
#
includes/page_tail.php

# 
#-----[ FIND ]------------------------------------------ 
#

'PHPBB_VERSION' => '2' . $board_config['version'],

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#

//Start Copyright Information
"COPYRIGHT_NAME" => $board_config['copyright_name'],
"COPYRIGHT_YEAR" => $board_config['copyright_year'],
//End Copyright Information

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// That's all Folks!

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#

//Copyright Information
$lang['site_copyright'] = 'Site Copyright';
$lang['site_copyright_explain'] = 'Put the name of the copyright holder in the first block(for example, phpbb) and the year in the secone block(for example, 2004)';

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/overall_footer.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<div align="center"><span class="copyright"><br />{ADMIN_LINK}<br />

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

© {COPYRIGHT_YEAR} <a href="{U_INDEX}">{COPYRIGHT_NAME}</a><br />

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<tr>
		<td class="row1">{L_SITE_DESCRIPTION}</td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="site_desc" value="{SITE_DESCRIPTION}" /></td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

	<tr>
		<td class="row1">{L_SITE_COPYRIGHT}<br /><span class="gensmall">{L_SITE_COPYRIGHT_EXPLAIN}</span></td>
	  <td class="row2"><input type="text" name="copyright_name" maxlength="255" value="{COPYRIGHT_NAME}" />
	    <input type="text" name="copyright_year" maxlength="255" value="{COPYRIGHT_YEAR}" /></td>
	</tr>	

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 