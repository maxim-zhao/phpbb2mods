############################################################## 
## MOD Title: Edit Profile Link
## MOD Author: cherokee red < mods@cherokeered.co.uk> (Kenny Cameron) http://www.cherokeered.co.uk/f/
## MOD Description: Adds an 'Edit my Profile' link to your profile page.
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~3 Minutes 
## Files To Edit: includes/usercp_viewprofile.php, 
##                language/lang_english/lang_main.php,
##                templates/subSilver/profile_view_body.tpl,
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
## Author Notes: 
## 
## As requested in this topic - http://www.phpbb.com/phpBB/viewtopic.php?p=2637930#2637930
##
## When logged in, you will only see the link on your own profile - no-one elses.
## Admins & Mods can only see their own edit links as well - they have no special privelages.
## Guests cannot see the link at all.
##
############################################################## 
## MOD History: 
## 
##   2006-12-03 - Version BETA
##      - First release 
## 
##   2006-12-03 - Version RC 1
##      - Bug Fix - stopped edit link showing on other users profile pages 
##
##   2006-12-04 - Version 1.0.0
##      - Changed placement of link, to be in line with Forum Navigation
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#
	'L_INTERESTS' => $lang['Interests'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_EDIT_PROFILE' => $lang['Edit_profile_txt'],
#
#-----[ FIND ]------------------------------------------
#
$template->pparse('body');
#
#-----[ BEFORE, ADD ]------------------------------------------
#
if ( $profiledata['user_id'] == $userdata['user_id'] ) 
{ 
     $template->assign_block_vars('switch_user_edit_profile_link',array()); 
}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['About_user'] = 'All about %s'; // %s is username

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Edit_profile_txt'] = 'Edit My Profile';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>

#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- BEGIN switch_user_edit_profile_link --> 
	<td align="right"><span class="nav"><a href="{U_PROFILE}" class="nav">{L_EDIT_PROFILE}</a></span></td>
<!-- END switch_user_edit_profile_link -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM