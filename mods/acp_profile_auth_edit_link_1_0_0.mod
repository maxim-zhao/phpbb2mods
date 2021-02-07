##############################################################
## MOD Title: Link to Edit User/Auth in ACP
## MOD Author: eviL3 <evil@phpbbmodders.com> (Igor Wiedler) http://phpbbmodders.com
## MOD Description: This MOD will add a link to the "Edit user" / "Edit permissions"
##                  in the ACP, so you can easily switch between the two.
##
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: 5 Minutes
##
## Files To Edit: admin/admin_users.php,
##      admin/admin_ug_auth.php,
##      language/lang_english/lang_admin.php,
##      templates/subSilver/admin/auth_ug_body.tpl,
##      templates/subSilver/admin/user_edit_body.tpl
##
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
## I hope it's useful to you.
##
##############################################################
## MOD History:
##
##   2006-09-20 - Version 1.0.0
##      - First and hopefully last release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#
			'L_USER_TITLE' => $lang['User_admin'],


#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_AUTH_LINK' => $lang['Go_edit_auth'],

#
#-----[ FIND ]------------------------------------------
#
			'S_PROFILE_ACTION' => append_sid

#
#-----[ BEFORE, ADD ]------------------------------------------
#
			'S_SWITCH_ACTION' => append_sid("admin_ug_auth.$phpEx"),

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_ug_auth.php

#
#-----[ FIND ]------------------------------------------
#
		'L_AUTH_TITLE' => 

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_AUTH_LINK' => $lang['Go_edit_profile'],

#
#-----[ FIND ]------------------------------------------
#
		'S_AUTH_ACTION' => append_sid

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'S_SWITCH_ACTION' => append_sid("admin_users.$phpEx"),

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['User_admin_explain']

#
#-----[ AFTER, ADD ]------------------------------------------
#

// Link to Edit User/Auth in ACP
$lang['Go_edit_profile'] = 'Edit this users Profile';
$lang['Go_edit_auth'] = 'Edit this users Permissions';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/auth_ug_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<h2>{L_USER_OR_GROUPNAME}: {USERNAME}</h2>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<!-- BEGIN switch_user_auth -->
<form method="post" action="{S_SWITCH_ACTION}">
<p>
<input type="submit" name="edit" value="{L_AUTH_LINK}" class="mainoption" />
<input type="hidden" name="mode" value="edit" />
<input type="hidden" name="username" value="{USERNAME}" />
</p>
</form>
<!-- END switch_user_auth -->

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<h1>{L_USER_TITLE}</h1>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<form method="post" action="{S_SWITCH_ACTION}">
<p>
<input type="submit" name="auth" value="{L_AUTH_LINK}" class="mainoption" />
<input type="hidden" name="mode" value="user" />
<input type="hidden" name="username" value="{USERNAME}" />
</p>
</form>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
