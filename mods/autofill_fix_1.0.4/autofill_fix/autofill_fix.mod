##############################################################
## MOD Title: Autofill Fix
## MOD Author: Marshalrusty < phpBB@marshalrusty.com > Yuriy Rusko http://phpbbhelp.org
## MOD Author: Lumpy Burgertushie < lumpy@phpbb-installer.com > (Robert Adams) N/A
## MOD Description: This MOD will stop the browser from autofilling your username and 
## password when trying to edit users in the admin panel.
## MOD Version: 1.0.4
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit:
##	 admin/admin_users.php
##       admin/admin_ug_auth.php
##	 admin/admin_user_ban.php
##	 templates/subSilver/admin/user_ban_body.tpl
##       templates/subSilver/admin/user_edit_body.tpl,
##       templates/subSilver/admin/user_select_body.tpl
##       templates/subSilver/search_username.tpl
## Included Files: (N/A)
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: This MOD is tested on version 2.0.18
##using easymod to install and works fine.
##############################################################
## MOD History:
##   	
##	2005-12-12 - Version 1.0.0
##      	first version, submitted to MOD Database.	
##	2005-12-15 - Version 1.0.1
##		corrected some MOD syntax problems and some
##		MOD template errors. resubmitted to MOD Database.
##	2005-12-28  - version 1.0.2
##		added  the edits to the subSilver/search_username.tpl file
##		that was omitted in the first version.
##	2005-12-30 - Version 1.0.3
##		Updated to comply with phpBB version 2.0.19
##      2006-01-04 - Version 1.0.4
##              Added code to make it work with the ban and permissions functions.   	
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]---------------------------------------------
#
admin/admin_ug_auth.php
#
#-----[ FIND ]------------------------------------------
#
else if ( ( $mode == 'user' && ( isset($HTTP_POST_VARS['username'])
#
#-----[ IN-LINE FIND ]------------------------------------------
#
username
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
username_fillfix
#
#-----[ FIND ]------------------------------------------
#
if ( isset($HTTP_POST_VARS['username']) )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
username
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
username_fillfix
#
#-----[ FIND ]------------------------------------------
#
$this_userdata = get_userdata($HTTP_POST_VARS['username'], true);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
username
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
username_fillfix
#
#-----[ OPEN ]---------------------------------------------
#
admin/admin_user_ban.php
#
#-----[ FIND ]------------------------------------------
#
if ( !empty($HTTP_POST_VARS['username']) )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
username
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
username_fillfix
#
#-----[ FIND ]------------------------------------------
#
$this_userdata = get_userdata($HTTP_POST_VARS['username'], true);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
username
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
username_fillfix
#
#-----[ OPEN ]---------------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
#
if ( $mode == 'edit' || $mode == 'save'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
( isset($HTTP_POST_VARS['username'])
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
( isset($HTTP_POST_VARS['username_fillfix'])
#
#-----[ FIND ]------------------------------------------
#
$username = ( !empty($HTTP_POST_VARS['username'])
#
#-----[ IN-LINE FIND ]------------------------------------------
#
( !empty($HTTP_POST_VARS['username'])
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
( !empty($HTTP_POST_VARS['username_fillfix'])
#
#-----[ IN-LINE FIND ]------------------------------------------
#
phpbb_clean_username($HTTP_POST_VARS['username'])
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
phpbb_clean_username($HTTP_POST_VARS['username_fillfix'])
#
#-----[ FIND ]------------------------------------------
#
$password = ( !empty($HTTP_POST_VARS['password'])
#
#-----[ IN-LINE FIND ]------------------------------------------
#
( !empty($HTTP_POST_VARS['password'])
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
( !empty($HTTP_POST_VARS['password_fillfix'])
#
#-----[ IN-LINE FIND ]------------------------------------------
#
(htmlspecialchars( $HTTP_POST_VARS['password'] ) ))
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
(htmlspecialchars( $HTTP_POST_VARS['password_fillfix'] ) ))
#
#-----[ FIND ]------------------------------------------
#
$this_userdata = get_userdata($HTTP_POST_VARS['username'], true);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
['username']
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
['username_fillfix']
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_ban_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<input class="post" type="text" class="post" name="username"
#
#-----[ IN-LINE FIND ]------------------------------------------
#
name="username"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
name="username_fillfix"
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<input class="post" type="text" name="username" size="35" maxlength="40" value="{USERNAME}" />
#
#-----[ IN-LINE FIND ]------------------------------------------
#
name="username"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
name="username_fillfix" 
#
#-----[ FIND ]------------------------------------------
#
<input class="post" type="password" name="password" size="35" maxlength="32" value="" />
#
#-----[ IN-LINE FIND ]------------------------------------------
#
name="password"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
name="password_fillfix"
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_select_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<td class="row1" align="center"><input type="text" class="post" name="username" maxlength="50" size="20" />
#
#-----[ IN-LINE FIND ]------------------------------------------
#
name="username"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
name="username_fillfix"
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/search_username.tpl
#
#-----[ FIND ]------------------------------------------
#
opener.document.forms['post'].username.value = selected_username;
#
#-----[ IN-LINE FIND ]------------------------------------------
#
username.value
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
username_fillfix.value
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM