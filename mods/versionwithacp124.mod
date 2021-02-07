############################################################## 
## MOD Title: Change forum version using ACP
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Able to change the forum version comfortably over the ACP
## MOD Version: 1.2.4
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		admin/admin_board.php
##		language/lang_english/lang_admin.php
##		templates/subSilver/admin/board_config_body.tpl
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## 
## This modification was built for use with the phpBB template "subSilver"
##
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/versionwithacp.png
## Download: http://www.underhill.de/downloads/phpbb2mods/versionwithacp.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.2.4 
##		- Successfully tested with phpBB 2.0.20
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2005-12-31 - Version 1.2.3 
##		- Successfully tested with phpBB 2.0.19
## 
##   2005-12-11 - Version 1.2.2 
##		- MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.18
## 
##   2005-10-03 - Version 1.2.1 
##		- MOD Syntax changes for the phpBB MOD Database
## 
##   2005-10-01 - Version 1.2.0 
##		- Format changed to the phpBB MOD Template
##		- Successfully tested with phpBB 2.0.17
## 
##   2005-02-28 - Version 1.0.0 
##		- Built and successfully tested with phpBB 2.0.12
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------------------------------
#

admin/admin_board.php

#
#-----[ FIND ]------------------------------------------------------------------
#

	"L_RESET" => $lang['Reset'],

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

	"L_VERSION" => $lang['Version'],
	"L_VERSION_EXPLAIN" => $lang['Version_explain'],

	"VERSION" => $new['version'],

#
#-----[ OPEN ]------------------------------------------------------------------
#

language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------------------------------
#

$lang['SMTP_password_explain'] = 

#
#-----[ AFTER, ADD ]-----------------------------------------------------------
#

$lang['Version'] = 'phpBB Version';
$lang['Version_explain'] = 'Changes the displayed phpBB version number';

#
#-----[ OPEN ]------------------------------------------------------------------
#

templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------------------------------
#

	<tr>
		<td class="row1">{L_ENABLE_PRUNE}</td>
		<td class="row2"><input type="radio" name="prune_enable" value="1" {PRUNE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="prune_enable" value="0" {PRUNE_NO} /> {L_NO}</td>
	</tr>

#
#-----[ AFTER, ADD ]-----------------------------------------------------------
#

	<tr>
		<td class="row1">{L_VERSION}<br /><span class="gensmall">{L_VERSION_EXPLAIN}</span></td>
		<td class="row2">2 <input class="post" type="text" maxlength="6" size="6" name="version" value="{VERSION}" /></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM
