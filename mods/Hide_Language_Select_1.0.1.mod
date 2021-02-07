##############################################################
## MOD Title: Hide_Language_Select
## MOD Author: Falstaff < david@falstaffenterprises.com > (David Falstaff) http://www.falstaffenterprises.com
## MOD Description: Adds the option to override the users language choice in the 
##                  General Configuration panel, and if override is set to 'yes' 
##                  hides the language drop-down in the user's profile to avoid confusion.
## MOD Version: 1.0.1
##
## Installation Level: (Easy)
## Installation Time: ~5 Minutes
## Files To Edit: admin/admin_board.php
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/admin/board_config_body.tpl
##                language/lang_english/lang_admin.php
##                includes/usercp_register.php
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##############################################################
## MOD History:
##
##   2005-02-18 - Version 1.0.1
##      - corrected to control registration form also
##
##   2004-09-28 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
# 

INSERT INTO phpbb_config (config_name, config_value) VALUES ('override_language', '0');

# 
#-----[ OPEN ]------------------------------------------ 
#

admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang_select = language_select($new['default_lang'], 'default_lang', "language");	
	
	
# 
#-----[ AFTER, ADD ]------------------------------------
#
	
$override_language_yes = ( $new['override_language'] ) ? "checked=\"checked\"" : "";
$override_language_no = ( !$new['override_language'] ) ? "checked=\"checked\"" : "";

# 
#-----[ FIND ]------------------------------------------ 
# 

	"L_RESET" => $lang['Reset'],

# 
#-----[ AFTER, ADD ]------------------------------------
#

	//Begin Hide Language Select MOD
	"L_OVERRIDE_LANGUAGE" => $lang['override_user_language'] ,
	"L_OVERRIDE_LANGUAGE_EXPLAIN" => $lang['override_user_language_explain'],
	"OVERRIDE_LANGUAGE_YES" => $override_language_yes, 
	"OVERRIDE_LANGUAGE_NO" => $override_language_no,
	//End Hide Language Select MOD

# 
#-----[ OPEN ]-------------------------------------------
#

templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]-------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_LANGUAGE}:</span></td>
	  <td class="row2"><span class="gensmall">{LANGUAGE_SELECT}</span></td>
	</tr>

# 
#-----[ REPLACE WITH ]-----------------------------------
#

	<!-- BEGIN override_user_language_block -->
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_LANGUAGE}:</span></td>
	  <td class="row2"><span class="gensmall">{LANGUAGE_SELECT}</span></td>
	</tr>
	<!-- END override_user_language_block -->	

# 
#-----[ OPEN ]------------------------------------------ 
#

templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<tr>
		<td class="row1">{L_DEFAULT_LANGUAGE}</td>
		<td class="row2">{LANG_SELECT}</td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------
#
	
	<!-- Begin Hide Language Select -->
	<tr>
		<td class="row1">{L_OVERRIDE_LANGUAGE}<br /><span class="gensmall">{L_OVERRIDE_LANGUAGE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="override_language" value="1" {OVERRIDE_LANGUAGE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="override_language" value="0" {OVERRIDE_LANGUAGE_NO} /> {L_NO}</td>
	</tr>
	<!-- End Hide Language Select -->

# 
#-----[ OPEN ]------------------------------------------ 
#

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// That's all Folks!

# 
#-----[ AFTER, ADD ]----------------------------------- 
#

//Begin Hide Language Select MOD
$lang['override_user_language'] = 'Override user language';
$lang['override_user_language_explain'] = 'Hides language choice drop-down in user\'s profile';
//End Hide Language Select MOD

# 
#-----[ OPEN ]---------------------------------------------- 
#

includes/usercp_register.php

# 
#-----[ FIND ]---------------------------------------------- 
# 

	}

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

	?>

# 
#-----[ BEFORE, ADD ]---------------------------------------------- 
#

	    //Begin Hide Language Select MOD
    	if ($board_config['override_language']) 
    	{
    	} 
    	else 
    	{
	    	$template->assign_block_vars('override_user_language_block', array());
    	}
    	//End Hide Language Select MOD

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 