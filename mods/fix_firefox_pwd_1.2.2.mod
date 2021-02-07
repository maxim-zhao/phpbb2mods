##############################################################
## MOD Title: Fix For The Firefox "Remember Passwords" Problem
## MOD Author: T0ny < N/A > (Tony Smith) N/A
## MOD Description: Fix for firefox's Remember Passwords feature
##					overwriting username and password on the
##					'User Administration' page
## MOD Version: 1.2.2
##
## Installation Level: Easy
## Installation Time: ~5 Minutes
## Files To Edit: 4
##					admin/admin_ug_auth.php
##					admin/admin_users.php
##					templates/subSilver/admin/user_edit_body.tpl
##					templates/subSilver/search_username.tpl
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
##		Renames the 'username' field to 'user_name' and the
##		'password' field to 'pass_word' while still providing the
##		$HTTP_POST_VARS['username'] & $HTTP_POST_VARS['password']
##		array members for compatability with other MODs
##
##		Tested with phpbb v2.0.19 , Firefox 1.5.0.1 , IE 6.0SP2
##					Firefox 2.0
##
##############################################################
## MOD History:
##
##	2006-01-29 - Version 1.0.0
##		- initial release
##
##	2006-02-05 - version 1.0.1
##		- fixed incorrect case in references to subSilver template
##		- fixed bug causing 'Find A Username' to not work (search_username.tpl)
##
##	2006-02-08 - version 1.0.2
##		- fixed faulty find/replace actions
##
##	2006-02-10 - version 1.1.0 (BETA)
##		- beta fix for incompatability with other MODs that modify the user admin functions
##
##	2006-02-11 - version 1.1.1 (BETA)
##		- removed 'templates/subSilver/admin/user_select_body.tpl' changes (no longer needed)
##		- made edit to 'templates/subSilver/admin/user_edit_body.tpl' a more specific IN-LINE FIND
##
##	2006-02-13 - version 1.2.0
##		- no functionality changes from 1.1.1 just changing the version number to indicate it's no longer beta
##
##	2006-03-28 - version 1.2.1
##		- fixed 'not saving changes to user account' bug when using PHP5 with 'register_long_arrays' set to OFF
##
##	2006-11-05 - version 1.2.2
##		- updated to fix newer incarnation of bug in firefox 2
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------------
#

admin/admin_users.php

#
#-----[ FIND ]------------------------------------------------
#

require('./pagestart.' . $phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#

if ( ( isset($HTTP_POST_VARS['user_name']) ) && ( !isset($HTTP_POST_VARS['username']) ) )
{
	$HTTP_POST_VARS['username'] = $HTTP_POST_VARS['user_name'];
}

if ( ( isset($HTTP_POST_VARS['pass_word']) ) && ( !isset($HTTP_POST_VARS['password']) ) )
{
	$HTTP_POST_VARS['password'] = $HTTP_POST_VARS['pass_word'];
}

#
#-----[ OPEN ]------------------------------------------------
#

admin/admin_ug_auth.php

#
#-----[ FIND ]------------------------------------------------
#

require('./pagestart.' . $phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#

if ( ( isset($HTTP_POST_VARS['user_name']) ) && ( !isset($HTTP_POST_VARS['username']) ) )
{
	$HTTP_POST_VARS['username'] = $HTTP_POST_VARS['user_name'];
}

if ( ( isset($HTTP_POST_VARS['pass_word']) ) && ( !isset($HTTP_POST_VARS['password']) ) )
{
	$HTTP_POST_VARS['password'] = $HTTP_POST_VARS['pass_word'];
}

#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------------
#

name="username"

#
#-----[ IN-LINE FIND ]----------------------------------------
#

name="username"

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#

name="user_name"

#
#-----[ FIND ]------------------------------------------------
#

name="password"

#
#-----[ IN-LINE FIND ]----------------------------------------
#

name="password"

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#

name="pass_word"

#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/search_username.tpl

#
#-----[ FIND ]------------------------------------------------
#

	opener.document.forms['post'].username.value = selected_username;

#
#-----[ REPLACE WITH ]----------------------------------------
#

	if (opener.document.forms['post'].user_name)
	{
		opener.document.forms['post'].user_name.value = selected_username;
	}
	else
	{
		opener.document.forms['post'].username.value = selected_username;
	}

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM