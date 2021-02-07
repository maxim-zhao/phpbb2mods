############################################################## 
## MOD Title: Admin-Help 
## MOD Author: blackrat <wolfgang.bujatti@chello.at> (Wolfgang Bujatti) http://www.game-multimedia.com 
## MOD Description: Adds a link to phpbbguides in the Admin Control Panel 
##                  and on the bottom of every page when an admin is locked in.
## MOD Version: 1.0.1 
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
##
## Files To Edit: includes/constants.php, 
##                includes/page_tail.php,
##                language/lang_english/lang_main.php, 
##                admin/index.php,
##                templates/subSilver/admin/index_navigate.tpl
##
## Included Files: n/a
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
## Author Notes: Implementatin technique taken from Add phpMyAdmin Link by Thoul,
##               who gave me the permission, to use his code.
############################################################## 
## MOD History: 
## 
##   2006-06-13 - Version 1.0.1 
##      - Help page opens in new window 
##	
##   2006-05-21 - Version 1.0.0 
##      - Initial Release
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php

#
#-----[ FIND ]------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

// MOD: Admin-Help
// Example English: define('ADMINHELP', 'http://www.phpbb.com/support/');
// Example German: define('ADMINHELP', 'http://www.phpbb.de/doku/');
define('ADMINHELP', 'http://www.phpbb.com/support/');

#
#-----[ OPEN ]------------------------------------------
#
includes/page_tail.php

#
#-----[ FIND ]------------------------------------------
#

$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a>

#
#-----[ IN-LINE FIND ]----------------------------------------
#

<br /><br />' : '';

#
#-----[ IN-LINE BEFORE, ADD ]---------------------------------
#

 | <a href="' . ADMINHELP . '" target="_blank">' . $lang['AdminHelp'] . '</a>

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

// MOD: Admin-Help
$lang['AdminHelp'] = 'Admin-Help';

#
#-----[ OPEN ]------------------------------------------
#
admin/index.php

#
#-----[ FIND ]------------------------------------------
#

		"U_ADMIN_INDEX" => append_sid("index.$phpEx?pane=right"),

#
#-----[ AFTER, ADD ]------------------------------------------
#

		// MOD: Admin-Help
		'U_ADMINHELP' => ADMINHELP,
		'L_ADMINHELP' => $lang['AdminHelp'],

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/index_navigate.tpl

#
#-----[ FIND ]------------------------------------------
#

<!-- BEGIN catrow -->

#
#-----[ BEFORE, ADD ]------------------------------------------
#

		<tr> 
			<td class="row1"><span class="genmed"><a href="{U_ADMINHELP}" target="_blank" class="genmed">{L_ADMINHELP}</a></span></td> 
		</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM