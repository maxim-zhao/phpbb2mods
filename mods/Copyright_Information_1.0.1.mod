##############################################################
## MOD Title: Copyright Information
## MOD Author: Falstaff < david@falstaffenterprises.com > (David Falstaff) http://www.falstaffenterprises.com
## MOD Description: Adds custom copyright information above the "powered by phpBB 2.0.*" copyright 
##                  notice on the footer of all your forum pages, and creates a link to your copyright
##                  notice page. This is appropriate if your forum is part of a larger site with other content. 
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: ~5 Minutes
## Files To Edit:
##               admin/admin_board.php
##               includes/page_tail.php
##               language/lang_english/lang_admin.php
##               templates/subSilver/overall_footer.tpl
##               templates/subSilver/admin/board_config_body.tpl          
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## This mod will NOT replace the phpBB copyright. Under no circumstances should 
## you remove the phpBB copyright from your forum. 
##
##############################################################
## MOD History:
##
##   2005-03-31 - Version 1.0.1
##      - Updated instuctions to account for modifications to includes/page_tail.php
##
##   2004-09-21 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
# 

INSERT INTO phpbb_config (config_name, config_value) VALUES ('copyright_year', '2004');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('copyright_name', 'Copyright Holder');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('copyright_link', 'index.php');

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

	"L_RESET" => $lang['Reset'],

# 
#-----[ AFTER, ADD ]------------------------------------
#

	//Start Copyright Information MOD
	"L_COPYRIGHT_SETTINGS" => $lang['site_copyright_settings'],
	"L_SITE_COPYRIGHT" => $lang['site_copyright'],
	"L_SITE_COPYRIGHT_YEAR" => $lang['site_copyright_year'],
	"L_SITE_COPYRIGHT_LINK" => $lang['site_copyright_link'],
	"L_SITE_COPYRIGHT_EXPLAIN" => $lang['site_copyright_explain'],
	"COPYRIGHT_NAME" => $new['copyright_name'],
	"COPYRIGHT_YEAR" => $new['copyright_year'],
	"COPYRIGHT_LINK" => $new['copyright_link'],
	//End Copyright Information MOD

# 
#-----[ OPEN ]------------------------------------------ 
#
includes/page_tail.php

# 
#-----[ FIND ]------------------------------------------ 
#

$template->assign_vars(array(

# 
#-----[ AFTER, ADD ]-----------------------------------
#

	//Begin Copyright Information MOD
	"COPYRIGHT_NAME" => $board_config['copyright_name'],
	"COPYRIGHT_YEAR" => $board_config['copyright_year'],
	"COPYRIGHT_LINK" => $board_config['copyright_link'],
	//End Copyright Information MOD

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
#-----[ AFTER, ADD ]----------------------------------- 
#

// Begin Copyright Information MOD
$lang['site_copyright_settings'] = 'Site Copyright Settings';
$lang['site_copyright'] = 'Site Copyright';
$lang['site_copyright_year'] = 'Site Copyright Year(s)';
$lang['site_copyright_link'] = 'Site Copyright Page';
$lang['site_copyright_explain'] = 'Enter your copyright information below. <b>Site Copyright Holder</b> is the person or organization that holds copyright. <b> Site Copyright Year(s) </b> is the year or years that the copyrighted content was created. <b>Site Copyright Page</b> is the web page relative to the phpBB root directory that has your copyright information. ';
// End Copyright Information MOD

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/overall_footer.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<div align="center"><span class="copyright"><br />{ADMIN_LINK}<br />

# 
#-----[ AFTER, ADD ]------------------------------------ 
#


Copyright © {COPYRIGHT_YEAR} <a href="{COPYRIGHT_LINK}">{COPYRIGHT_NAME}</a><br />

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<tr>
		<td class="row1">{L_ENABLE_PRUNE}</td>
		<td class="row2"><input type="radio" name="prune_enable" value="1" {PRUNE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="prune_enable" value="0" {PRUNE_NO} /> {L_NO}</td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------ 
#

	<!--begin copyright information mod-->
	<tr>
		<th class="thHead" colspan="2">{L_COPYRIGHT_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_SITE_COPYRIGHT_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_SITE_COPYRIGHT}</td>
		<td class="row2"><input class="post" type="text" maxlength="255" name="copyright_name" value="{COPYRIGHT_NAME}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SITE_COPYRIGHT_YEAR}</td>
		<td class="row2"><input class="post" type="text" maxlength="255" name="copyright_year" value="{COPYRIGHT_YEAR}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SITE_COPYRIGHT_LINK}</td>
		<td class="row2"><input class="post" type="text" maxlength="255" name="copyright_link" value="{COPYRIGHT_LINK}" /></td>
	</tr>
	<!--end copyright information mod-->
	

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 