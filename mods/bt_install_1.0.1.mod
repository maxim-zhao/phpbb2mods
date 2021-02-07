##############################################################
## MOD Title: Browser Text MOD
## MOD Author: battye < cricketmx@hotmail.com > (battye) http://www.cricketmx.com
## MOD Description:	Gives administrators the ability to add text to the bottom of vistors browser windows, it will be useful if you
## wish to add more information about your forum / site, tell users how to join etc. Eg: "Click 'Register' to become a member!"
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 3 Minutes
##
## Files To Edit (6): 	board_config_body.tpl
##							admin_board.php
##							lang_admin.php
##
## Included Files (0): 	
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 	If you wish to add more than 255 characters, you will need to manually edit
##							page_header.php and add your text.	
##
##							Otherwise, go to the Configuration section of your Admin Panel and enter your
##							text there.
##						
##							Tested & works with EasyMOD
############################################################## 
## MOD History: 	2005-06-01 - Version 1.0.0
##     						 - First release
## 					2005-07-02 - Version 1.0.1
##     						 - Bug fixes
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]---------------------------
#
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('scroll_bar', '');

#
#-----[ OPEN ]------------------------------------------
#

admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'

#
#-----[ REPLACE WITH ]------------------------------------------
#
				config_value = '" . htmlspecialchars(str_replace("\'", "''", $new[$config_name])) . "'
				
#
#-----[ FIND ]------------------------------------------
#
	"L_FLOOD_INTERVAL_EXPLAIN" => $lang['Flood_Interval_explain'], 

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// Scroll bar
	"L_WINDOW_STATUS" => $lang['Scroll_lang'],
	"L_SCROLL" => $lang['Scroll_bar'],
	"SCROLL_TEXT" => $board_config['scroll_bar'],

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
	'U_GROUP_CP' => append_sid('groupcp.'.$phpEx),

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'U_SCROLL' => ($board_config['scroll_bar']) ? 
	"<script language=\"JavaScript\" type=\"text/javascript\">window.status=\"" . $board_config['scroll_bar'] . "\"</script>" : "",
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Click_return_forumadmin'] = 'Click %sHere%s to return to Forum Administration';

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Scroll bar
$lang['Scroll_lang'] = 'Browser Text';
$lang['Scroll_bar'] = 'Select the text that you wish to be displayed at the bottom of visitors browser windows.';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- END switch_enable_pm_popup -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
{U_SCROLL}	

#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------ 
#
	  <th class="thHead" colspan="2">{L_ABILITIES_SETTINGS}</th>
	</tr>
			
#
#-----[ AFTER, ADD ]------------------------------------------ 
#

		<tr>
		<td class="row1">{L_WINDOW_STATUS}<br /><span class="gensmall">{L_SCROLL}</span></td>
		<td class="row2"><input class="post" type="text" name="scroll_bar" maxlength="255" value="{SCROLL_TEXT}" /></td>	
		</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM