##############################################################
## MOD Title: Who is online time edit
## MOD Author: lightdarkness < lightdarkness@gmail.com > (Jay MacLean) http://www.lightdarkness.net
## MOD Description: This mod will add a spot to the admin pannel, to set the ammount of minutes that the who is online tool shows users of in the past x minutes
## MOD Version: 1.0.3
## 
## Installation Level: easy
## Installation Time: 10 Minutes (1min by easy mod)
## Files To Edit: admin/admin_board.php
##              language/lang_english/lang_admin.php
##              language/lang_english/lang_main.php
##              templates/subSilver/admin/board_config_body.tpl
##		viewonline.php
##		includes/page_header.php
##		admin/index.php
## Included Files: n/a
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Pop in easy mod and you are all set.
############################################################## 
## MOD History: 
##
## 1/7/06 - 1.0.3
##	    - Code checked for 2.0.19 compatibility, updated mod template header
##
## 7/27/04 - 1.0.2
##	    - syntax changed, now updated for 2.0.10
##
## 7/8/04 - 1.0.1
##	    - few errors found, added to new areas
##
## 7/8/04 - 1.0.0
##          - Initial release 
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('who_is_online_time', '5');

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
	"L_ABILITIES_SETTINGS" => $lang['Abilities_settings'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"L_WHO_IS_ONLINE_TIME" => $lang['who_is_online_time'],

#
#-----[ FIND ]------------------------------------------
#
	"BOARD_EMAIL_FORM_DISABLE" => $board_email_form_no, 

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"WHO_IS_ONLINE_TIME" => $new['who_is_online_time'],

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
'Max number of poll options';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['who_is_online_time'] = 'How many minutes who is online should show';

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
'This data is based on users active over the past five minutes';

#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Online_explain'] = 'This data is based on users active over the past ' . $board_config['who_is_online_time'] . ' minutes';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_ABILITIES_SETTINGS}</th>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr> 
      	<td class="row1">{L_WHO_IS_ONLINE_TIME}</td> 
      	<td class="row2"><input class="post" type="text" name="who_is_online_time" size="5" maxlength="5" value="{WHO_IS_ONLINE_TIME}" /></td> 
   	</tr>

#
#-----[ OPEN ]------------------------------------------
#
viewonline.php

#
#-----[ FIND ]------------------------------------------
#
//
// Get user list
//

#
#-----[ AFTER, ADD ]------------------------------------------
#
$whoisonlinetime = ($board_config['who_is_online_time'] * 60);

#
#-----[ FIND ]------------------------------------------
#
		AND s.session_time >= ".( time() - 300 ) . "
#
#-----[ REPLACE WITH ]------------------------------------------
#
		AND s.session_time >= ".( time() - $whoisonlinetime ) . "

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
if (defined('SHOW_ONLINE'))
{

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$whoisonlinetime = ($board_config['who_is_online_time'] * 60);

#
#-----[ FIND ]------------------------------------------
#
		AND s.session_time >= ".( time() - 300 ) . "

#
#-----[ REPLACE WITH ]------------------------------------------
#
		AND s.session_time >= ".( time() - $whoisonlinetime ) . "

#
#-----[ OPEN ]------------------------------------------
#
admin/index.php

#
#-----[ FIND ]------------------------------------------
#
	//
	// Get users online information.
	//

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$whoisonlinetime = ($board_config['who_is_online_time'] * 60);

#
#-----[ FIND ]------------------------------------------
#
		AND s.session_time >= " . ( time() - 300 ) . " 

#
#-----[ REPLACE WITH ]------------------------------------------
#
		AND s.session_time >= " . ( time() - $whoisonlinetime ) . " 

#
#-----[ FIND ]------------------------------------------
#
		AND session_time >= " . ( time() - 300 ) . "

#
#-----[ REPLACE WITH ]------------------------------------------
#
		AND session_time >= " . ( time() - $whoisonlinetime ) . "

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 