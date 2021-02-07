############################################################## 
## MOD Title: Send random password (on registration)
## MOD Author: Noobarmy < noobarmy@phpbbmodders.net > (Anthony Chu) http://phpbbmodders.net
## MOD Description: Will send users registering a random password
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 2 Minutes 
## Files To Edit: 
##	includes/usercp_register.php
##	templates/subSilver/profile_add_body.tpl
##
## Included Files: 0
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
## Author Notes: 
## 			
############################################################## 
## MOD History: 
##
## 	2007-01-23 - Version 0.2.0
##		- Initial release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_register.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	if ( !isset($HTTP_POST_VARS['cancelavatar']))
		{
			$user_avatar = $user_avatar_category . '/' . $user_avatar_local;
			$user_avatar_type = USER_AVATAR_GALLERY;
		}
	}
}
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	if ( $mode == 'register')
	{
	
			$random_password = gen_rand_string(false);
			$new_password = $random_password;
			$password_confirm = $random_password;
	}

# 
#-----[ FIND ]------------------------------------------ 
# 
	if ( $mode == 'editprofile' )
	{
		$template->assign_block_vars('switch_edit_profile', array());
	}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	if ( $mode == 'register' )
	{
		$template->assign_block_vars('switch_register', array());
	}

# 
#-----[ FIND ]------------------------------------------ 
# 
		'L_CONFIRM_CODE_EXPLAIN'	=> $lang['Confirm_code_explain'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
		'L_PASSWORD_NOTE' => $lang['password_note'],

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
$lang['password_note'] = 'A password will be sent to your email, you can change it in your profile once your account is active';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	<!-- BEGIN switch_edit_profile -->
	<tr> 
	  <td class="row1"><span class="gen">{L_CURRENT_PASSWORD}: *</span><br />
		<span class="gensmall">{L_CONFIRM_PASSWORD_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="cur_password" size="25" maxlength="32" value="{CUR_PASSWORD}" />
	  </td>
	</tr>
	<!-- END switch_edit_profile -->

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
 	<!-- END switch_edit_profile -->

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# nothing
#
<!-- removed -->

# 
#-----[ FIND ]------------------------------------------ 
# 
	<!-- Visual Confirmation -->

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	<!-- END switch_edit_profile -->

	<!-- BEGIN switch_register -->
		<tr>
			<td colspan="2" class="row1"><span class="gen">{L_PASSWORD_NOTE}</span></td>
		</tr>
	<!-- END switch_register -->

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM