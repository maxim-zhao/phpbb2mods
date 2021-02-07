##############################################################
## MOD Title: Remove Cookies
## MOD Author: geocator < geocator@gmail.com > (Brian) http://www.geocator.us
## MOD Description: Adds a link to the footer of your board that allows visitors to delete cookies set by your forum.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 7 minutes
## Files To Edit: includes/page_tail.php
##                templates/subSilver/overal_footer.tpl
##                language/lang_english/lang_main.php
## Included Files: 
## Generator: MOD Studio 3.0 Alpha 1 [mod functions 0.2.1677.25348]
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
##############################################################
## MOD History:
## 
##   2005-08-18 - Version 1.0.1 
##      - Various fixes
##		- Added apend_sid to link
##		- Fixed missing confim text
##
##   2005-07-27 - Version 1.0.0 
##      - First Stable Release
##		- Added confirmation
## 
##   2004-10-12 - Version 0.0.1 
##      - First beta release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

includes/page_tail.php
#
#-----[ FIND ]------------------------------------------
#
$template->set_filenames(array(
	'overall_footer' => ( empty($gen_simple_header) ) ? 'overall_footer.tpl' : 'simple_footer.tpl')
);
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//START Remove Cookies
$cookie_link = '<a href="' . append_sid("remove_cookies.$phpEx") . '">' . $lang['Remove_cookies'] . '</a>';
//END Remove Cookies
#
#-----[ FIND ]------------------------------------------
#
	'ADMIN_LINK' => $admin_link)
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	//START Remove Cookies
	'COOKIE_LINK' => $cookie_link,
	//END Remove Cookies
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
<!-- START Remove Cookies -->
<br />{COOKIE_LINK}<br />
<!-- ENDD Remove Cookies -->
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
$lang['Remove_cookies'] = 'Remove cookies set by this forum';
$lang['Cookies_deleted'] = 'All cookies have been deleted. You are now logged out.<br />To finalize deletion, you must close your browser now.';
$lang['Delete_cookies'] = 'Delete Cookies';
$lang['cookies_confirm'] = 'Are you you sure you want to delete all cookies set by this forum, this will also log you out?';

#
#-----[ COPY ]------------------------------------------
#
copy remove_cookies.php to remove_cookies.php
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

