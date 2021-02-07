##############################################################
## MOD Title: Remove COPPA
## MOD Author: billytcf < N/A > (N/A) N/A
## MOD Description: This mode removes COPPA from phpBB2.
## MOD Version: 1.0.4
## 
## Installation Level: Easy
## Installation Time: 13 minutes
## Files To Edit: includes/usercp_register.php
##                language/lang_english/lang_main.php
##                templates/subSilver/agreement.tpl
##                templates/subSilver/admin/board_config_body.tpl
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: This is just a simple mod to remove COPPA. 
##
## !!!!!!!IMPORTANT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
## Please note that it is ILLEGAL to remove COPPA in the US.
## 
## This MOD do NOT prevent the agreement page from showing up.
##############################################################
## MOD History:
## 
##   2004-12-25 - Version 1.0.3
##      -  Initial release
##
##   2005-11-11 - Version 1.0.4
##      -  Added DIY lines to remove config values.
##      -  MOD template reviewed to comply with new standards.
## 
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
#
#I don't know why the following code can't be parsed by EasyMOD although they are valid so you may have to execute it yourself
DELETE FROM phpbb_config WHERE `config_name` = 'coppa_fax';
DELETE FROM phpbb_config WHERE `config_name` = 'coppa_mail';

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
		"AGREE_OVER_13" => $lang['Agree_over_13'],

#
#-----[ REPLACE WITH ]------------------------------------------
#
		//[MOD]Remove COPPA
		//"AGREE_OVER_13" => $lang['Agree_over_13'],
		"AGREE" => $lang['Agree'],

#
#-----[ FIND ]------------------------------------------
#
		"AGREE_UNDER_13" => $lang['Agree_under_13'],

#
#-----[ REPLACE WITH ]------------------------------------------
#
		//[MOD]Remove COPPA
		//"AGREE_UNDER_13" => $lang['Agree_under_13'],

#
#-----[ FIND ]------------------------------------------
#
		"U_AGREE_OVER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true"),

#
#-----[ REPLACE WITH ]------------------------------------------
#
		"U_AGREE" => append_sid("profile.$phpEx?mode=register&amp;agreed=true"))

#
#-----[ FIND ]------------------------------------------
#
		"U_AGREE_UNDER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true&amp;coppa=true"))

#
#-----[ REPLACE WITH ]------------------------------------------
#
		//[MOD]Remove COPPA
		//"U_AGREE_UNDER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true&amp;coppa=true"))

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Agree_under_13'] = 'I Agree to these terms and am <b>under</b> 13 years of age';

#
#-----[ REPLACE WITH ]------------------------------------------
#

//[MOD]Remove COPPA
//$lang['Agree_under_13'] = 'I Agree to these terms and am <b>under</b> 13 years of age';

#
#-----[ FIND ]------------------------------------------
#
$lang['Agree_over_13'] = 'I Agree to these terms and am <b>over</b> or <b>exactly</b> 13 years of age';

#
#-----[ REPLACE WITH ]------------------------------------------
#
//[MOD]Remove COPPA
//$lang['Agree_over_13'] = 'I Agree to these terms and am <b>over</b> or <b>exactly</b> 13 years of age';
$lang['Agree'] = 'I Agree to these terms';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/agreement.tpl

#
#-----[ FIND ]------------------------------------------
#
			<tr>
				<td><span class="genmed"><br />{AGREEMENT}<br /><br />
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<a href="{U_AGREE_OVER13}" class="genmed">{AGREE_OVER_13}</a>

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
<a href="{U_AGREE}" class="genmed">{AGREE}</a>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
<a href="{U_AGREE_UNDER13}" class="genmed">{AGREE_UNDER_13}</a><br /><br />

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
<!-- <a href="{U_AGREE_UNDER13}" class="genmed">{AGREE_UNDER_13}</a><br /><br /> -->

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr>
	  <th class="thHead" colspan="2">{L_COPPA_SETTINGS}</th>
	</tr>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
# 	
	<!-- [MOD]Remove COPPA
#
#-----[ FIND ]------------------------------------------
#
	<tr>
		<td class="row1">{L_COPPA_MAIL}<br /><span class="gensmall">{L_COPPA_MAIL_EXPLAIN}</span></td>
		<td class="row2"><textarea name="coppa_mail" rows="5" cols="30">{COPPA_MAIL}</textarea></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	 -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 