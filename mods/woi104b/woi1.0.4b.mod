############################################################## 
## MOD Title: Welcome on Index
## MOD Author: cherokee red < mods@cherokeered.co.uk > (Kenny Cameron) http://www.cherokeered.co.uk
## MOD Description: Shows a welcome message on the index page. If the member is registered/logged in, it will show the username - which will also be a link to the users profile. If the user is not logged in/registered, then they will be invited to register on the forums.
page :) 
## MOD Version: 1.0.4b
## 
## Installation Level: Easy 
## Installation Time: ~3 Minutes
## Files To Edit: templates/subSilver/index_body.tpl
## 		  index.php
## 		  language/lang_english/lang_main.php
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
## Author Notes:
## 
## To upgrade this MOD from previous version, please see the upgrade file in the contrib folder :)
##
## Dutch Language support can also be found there
## 
############################################################## 
## MOD History: 
## 
##   2004-10-03 - Version 1.0.0 
##      - mod created
## 
##   2004-10-03 - Version 1.0.1
##      - mod updated: missing semi-colon's added in
##
##   2004-10-03 - Version 1.0.2
##      - mod updated: link output in address bar fixed. was showing 'profile&2' instead of 'profile&u=2'
##
##   2004-10-03 - Version 1.0.3
##      - mod updated: speprate messages now show for guests and registered users. Also typo in 'files to edit' list fixed (~Romil). Also added Dutch and German language support, which can be found in the contrib folder (TKF2).
##
##   2006-04-29 - Version 1.0.4
##      - mod updated: small bug in the guest register link
##	- changed the guest message text/layout
##	- updated Dutch language support (TKF2/cherokee red)
##
##   2006-05-05 - Version 1.0.4b
##      - mod updated: minor text/template edits
##	- fixed extra '&' in register link (1.0.4a)
##	- fixed register link to comply with MOD standards ( POST_USERS_URL )
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------ 
#
index.php
# 
#-----[ FIND ]------------------------------------------ 
# 
		'body' => 'index_body.tpl')
	);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// Welcome on Index - cherokee red
if ($userdata['user_id'] != '-1')
{
    $welcome_reg = '<b><a href="' . append_sid("profile.$phpEx?mode=editprofile&amp;" . POST_USERS_URL . "=" . $userdata['user_id']) . '">' . $userdata['username'] . '</a></b>';
}
else
{
    $welcome_guest = '<a href="' . append_sid("profile.$phpEx?mode=register") . '">' . $lang['Welcome_Register'] . '</a>';
}

# 
#-----[ FIND ]------------------------------------------ 
# 
		'FORUM_LOCKED_IMG' => $images['forum_locked'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

		'L_WELCOME_REG' => $lang['Welcome'],
		'U_WELCOME_REG' => $welcome_reg,
		'L_WELCOME_GUEST' => $lang['Welcome2'],
		'U_WELCOME_GUEST' => $welcome_guest,
#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/index_body.tpl
#
#-----[ FIND ]------------------------------------------ 
#
<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
 
<tr>
	<!-- BEGIN switch_user_logged_in -->
	<td><span class="gen">
	{L_WELCOME_REG} {U_WELCOME_REG}<br />
	</td>
	<!-- END switch_user_logged_in -->

	<!-- BEGIN switch_user_logged_out -->
	<td><span class="gen">
	{L_WELCOME_GUEST} {U_WELCOME_GUEST}<br />
	</td>
	<!-- END switch_user_logged_out -->
</tr>

#
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Forums_marked_read'] = 'All forums have been marked read';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['Welcome'] = "<b>Thanks for logging in </b>";
$lang['Welcome2'] = "<b>Welcome Guest, have you thought about </b>";
$lang['Welcome_Register'] = "<b>Registering?</b>";

#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM