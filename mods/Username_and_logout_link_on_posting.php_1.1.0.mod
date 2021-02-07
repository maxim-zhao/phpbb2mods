############################################################## 
## MOD Title: Username and logout on posting.php
## MOD Author: -ds- < webmaster@djdarkskies.com > (Tristan Weissmann) http://www.djdarkskies.com
## MOD Description: This mod shows the username above the subject line followed by a logout link on posting.php.
## For Guests it shows a Log In link. It does not show in Private Messages.
## The Username links to the edit profile.
##
## MOD Version: 1.1.0
##
## Installation Level: Easy
## Installation Time: ~3 minutes
## Files To Edit: 
##                   posting.php
##                   language/lang_english/lang_main.php
##                   templates/subSilver/posting_body.tpl
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
## Author Notes: This MOD does not save the message if a user decides to log out during posting.
## The message will be lost.
##
############################################################## 
## MOD History:
##
##   2006-02-20 - Version 1.0.0
##      - Initial Release
##
##   2006-03-05 - Version 1.1.0
##   - edited to show login for guest users
## 
##############################################################
##
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	
	$template->set_filenames(array(
	'body' => 'posting_body.tpl', 
	'pollbody' => 'posting_poll_body.tpl', 
	'reviewbody' => 'posting_topic_review.tpl')
);



# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

    // START MOD: Username On posting.php
    // Check For Anonymous User
    if ($userdata['user_id'] != '-1')
    {
        $name_link = '<a href="' . append_sid("profile.$phpEx?mode=editprofile") . '" />' . $userdata['username'] . '</a>';
	$name_logout_link = $lang['Logout'];
    }
    else
    {
        $name_link = $lang['Guest'];
	$name_logout_link = $lang['Login'];
    }
    // END MOD: Username On posting.php


# 
#-----[ FIND ]------------------------------------------ 
# 

'L_POST_SUBJECT' => $lang['Post_subject'],


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

 // Username On posting.php
 'L_ACTIVE_USER' => $lang['Active_User'],
 'U_NAME_LINK' => $name_link,
 'U_NAME_LOGIN_LOGOUT' => $name_logout_link,


# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// That's all, Folks!
// -------------------------------------------------

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

//Username On posting.php
$lang['Active_User'] = "Logged in User"; 

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<!-- BEGIN switch_username_select -->

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
#  To be added on a seperate lines!
#

	<!-- BEGIN switch_not_privmsg -->
	<tr> 
		<td class="row1"><span class="gen"><b>{L_ACTIVE_USER}</b></span></td>
		<td class="row2"><span class="genmed"><b>{U_NAME_LINK}</b>  [ <a href="{U_LOGIN_LOGOUT}">{U_NAME_LOGIN_LOGOUT}</a>  ]</span></td>
	</tr>
	<!-- END switch_not_privmsg -->

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM