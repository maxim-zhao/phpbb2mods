##############################################################
## MOD Title: Adjustable board width
## MOD Author: dfritter4 < dfritter4@yahoo.com > (David Fritz) http://www.motrclan.com
##
## MOD Description: Allows administrators to change the 
##                  entire board's width by changing a
##                  value in the ACP!
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: ~10 Minutes based off EasyTIME 
##               (http://www.cmxmods.net/easytime.php)
##
## 
## Files To Edit: 
##		admin/admin_board.php
##		language/lang_english/lang_admin.php
##		includes/page_header.php
##		templates/subSilver/admin/board_config_body.tpl
##		templates/subSilver/overall_header.tpl
##
##
## Included Files: N/A
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: pretty simple changes and works great
##
##############################################################
## MOD History:
## 
##   2006-06-06 - Version 1.0.0
##      - changed a few small things where the variable wasn't
##	    being inserted correctly into the HTML
##	  - changed it so that you only have to edit the 
##        overall_header.tpl instead of all the tpl
##        files thanks to the suggestion made by Joe Belmaati
##   
##   2006-07-02 - Version 1.0.1
##	  - changed the security disclaimer to the updated version
##	  - changed the version number to the correct numbering
##	  - reworded a few changes
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ SQL ]------------------------------------------
# 
INSERT INTO `phpbb_config` ( `config_name` , `config_value` )
VALUES (
'forum_width', '100%'
);

#
#-----[ OPEN ]-----------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]-----------------------------------------
#
	"L_OVERRIDE_STYLE_EXPLAIN" => $lang['Override_style_explain'],

#
#-----[ AFTER, ADD ]-----------------------------------
#
	"L_FORUM_WIDTH" => $lang['Forum_width'],
	"L_FORUM_WIDTH_EXPLAIN" => $lang['Forum_width_explain'],

#
#-----[ FIND ]-----------------------------------------
#
	"SEARCH_FLOOD_INTERVAL" => $new['search_flood_interval'],

#
#-----[ AFTER, ADD ]-----------------------------------
#
	"FORUM_WIDTH" => $new['forum_width'],

#
#-----[ OPEN ]-----------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]-----------------------------------------
#
$lang['Flood_Interval_explain'] = 'Number of seconds a user must wait between posts';

#
#-----[ AFTER, ADD ]-----------------------------------
#
$lang['Forum_width'] = 'Forum width';
$lang['Forum_width_explain'] = 'Changes the width of the entire board using % or pixels';

#
#-----[ OPEN ]-----------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]-----------------------------------------
#
	'SITE_DESCRIPTION' => $board_config['site_desc'],

#
#-----[ AFTER, ADD ]-----------------------------------
#
	'FORUM_WIDTH' => $board_config['forum_width'],

#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
	<tr>
		<td class="row1">{L_DEFAULT_STYLE}</td>
		<td class="row2">{STYLE_SELECT}</td>
	</tr>

#
#-----[ AFTER, ADD ]-----------------------------------
#
	<tr>
		<td class="row1">{L_FORUM_WIDTH}<br /><span class="gensmall">{L_FORUM_WIDTH_EXPLAIN}</span></td>
		<td class="row2">
		<input class="post" type="text" size="6" maxlength="4" name="forum_width" value="{FORUM_WIDTH}" /></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------
#
<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center"> 

#
#-----[ IN-LINE FIND ]----------------------------------
#
"100%"

#
#-----[ IN-LINE REPLACE WITH ]--------------------------
#
{FORUM_WIDTH}

#
#-----[ FIND ]------------------------------------------
#
<td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />&nbsp; </span>

#
#-----[ IN-LINE FIND ]----------------------------------
#
"100%"

#
#-----[ IN-LINE REPLACE WITH ]--------------------------
#
{FORUM_WIDTH}

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM