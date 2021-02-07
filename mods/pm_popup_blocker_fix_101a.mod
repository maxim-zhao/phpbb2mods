##############################################################
## MOD Title: PM Popup Blocker Fix
## MOD Author: tomlevens < tom@tomlevens.co.uk > (Tom Levens) N/A
## MOD Description: This MOD changes the private message notification to a JavaScript dialog box instead of the popup window to get around the popup blocker included in many browsers.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 3 Minutes 
## Files To Edit: includes/page_header.php
##                language/lang_english/lang_main.php
##                templates/subSilver/overall_header.tpl
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
## Browsers featuring popup blockers stop the user from seeing the new private 
## message notification popup window as they mistake it as a popup advert. This 
## MOD gets around this problem by using a JavaScript dialog box (which is not
## blocked) for the notification, instead of the popup window.
############################################################## 
## MOD History: 
## 
##  2004-08-10 - Version 1.0.0
##   - Initial Release
##
##  2006-12-27 - Version 1.0.1
##   - General improvements to everything (as suggested by Bachsau)
##   - Popup now supports adding number of new messages with %d in the variables
##     language file (added as default)
##   - JavaScript code is now a bit simpler
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
	'L_PRIVATEMSGS' => $lang['Private_Messages'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// MOD: PM Popup Blocker Fix - by tomlevens
	// (1 line added)
	//
	'L_PRIVATEMSG_NEW' => ($userdata['user_new_privmsg'] == 1) ? $lang['You_new_pm'] : sprintf($lang['You_new_pms'], $userdata['user_new_privmsg']),
	//
	// END MOD

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['You_new_pm'] = 'A new private message is waiting for you in your Inbox';
$lang['You_new_pms'] = 'New private messages are waiting for you in your Inbox';

#
#-----[ REPLACE WITH ]------------------------------------------
#
// MOD: PM Popup Blocker Fix - by tomlevens
// (2 lines replaced - original lines follow)
//
// $lang['You_new_pm'] = 'A new private message is waiting for you in your Inbox';
// $lang['You_new_pms'] = 'New private messages are waiting for you in your Inbox';
//
$lang['You_new_pm'] = 'A new private message is waiting for you in your Inbox. Click OK to view it.';
$lang['You_new_pms'] = '%d new private messages are waiting for you in your Inbox. Click OK to view them.';
//
// END MOD

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
# NOTE: You will need to repeat this step for every template installed.
# 
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	if( {PRIVATE_MESSAGE_NEW_FLAG} && confirm('{L_PRIVATEMSG_NEW}') )
	{
		window.location = '{U_PRIVATEMSGS}';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM