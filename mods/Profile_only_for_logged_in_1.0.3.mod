##############################################################
## MOD Title: Profile Only For Logged In
## MOD Author: ymDevelopment < development@youngmommies.com > (Paul) http://www.youngmommies.com/ymboards
## MOD Description: Adds the option of requiring users to log in before viewing profiles.
## MOD Version: 1.0.3
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: profile.php
##                templates/subSilver/admin/board_config_body.tpl
##                admin/admin_board.php
##                language/lang_english/lang_admin.php
##                
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## This will add a checkbox option to the ACP allowing you to require users
## to log in before viewing profile pages.
##
##############################################################
## MOD History:
##
##   2005-06-07 - Version 1.0.0
##      - Initial release
##
##   2005-06-22 - Version 1.0.1
##      - Removed dupicate IF statement.
##
##   2005-06-30 - Version 1.0.2
##      - Better conformed to PHPBB coding conventions.
##
##   2005-07-02 - Version 1.0.3
##      - Removed inval funtion for user id.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#

INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_login_for_profile',1);


#
#-----[ OPEN ]------------------------------------------
#
profile.php

#
#-----[ FIND ]------------------------------------------
#
		include($phpbb_root_path . 'includes/usercp_viewprofile.'.$phpEx);
		exit;
	}

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		//Requires a user to be logged in to view a profile.
		if ( !$userdata['session_logged_in'] && $board_config['allow_login_for_profile'])
		{
			redirect(append_sid("login.$phpEx?redirect=profile.$phpEx&mode=viewprofile&" . POST_USERS_URL . '=' . $HTTP_GET_VARS[POST_USERS_URL], true));
		}

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#

	<tr>
	  <th class="thHead" colspan="2">{L_AVATAR_SETTINGS}</th>
	</tr>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

	<tr>
		<td class="row1">{L_LOGIN_FOR_PROFILE}</td>
		<td class="row2"><input type="radio" name="allow_login_for_profile" value="1" {LOGIN_FOR_PROFILE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_login_for_profile" value="0" {LOGIN_FOR_PROFILE_NO} /> {L_NO}</td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#

$namechange_yes = ( $new['allow_namechange'] ) ? "checked=\"checked\"" : "";
$namechange_no = ( !$new['allow_namechange'] ) ? "checked=\"checked\"" : "";

#
#-----[ AFTER, ADD ]------------------------------------------
#

$login_for_profile_yes = ( $new['allow_login_for_profile'] ) ? "checked=\"checked\"" : "";
$login_for_profile_no = ( !$new['allow_login_for_profile'] ) ? "checked=\"checked\"" : "";

#
#-----[ FIND ]------------------------------------------
#

	"L_MAX_SIG_LENGTH_EXPLAIN" => $lang['Max_sig_length_explain'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

	"L_LOGIN_FOR_PROFILE" => $lang['Login_for_profile'],
	"L_LOGIN_FOR_PROFILE_EXPLAIN" => $lang['Login_for_profile_explain'],

#
#-----[ FIND ]------------------------------------------
#

	"NAMECHANGE_YES" => $namechange_yes,
	"NAMECHANGE_NO" => $namechange_no,

#
#-----[ AFTER, ADD ]------------------------------------------
#

	"LOGIN_FOR_PROFILE_YES" => $login_for_profile_yes,
	"LOGIN_FOR_PROFILE_NO" => $login_for_profile_no,
	
	

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Max_sig_length_explain'] = 'Maximum number of characters in user signatures';

#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['Login_for_profile'] = 'Login for profile view';
$lang['Login_for_profile_explain'] = 'Require users to login to view profiles';


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
