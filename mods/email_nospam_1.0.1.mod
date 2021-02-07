##############################################################
## MOD Title: E-Mail Spambot Fighter
## MOD Author: truthsolo <rob@truthsolo.net> (Rob Dosogne) http://www.truthsolo.net/
## MOD Description: To help fight spam, modifies all public e-mail addresses to display in the format: user AT domain DOT tld
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: groupcp.php, memberlist.php, privmsg.php, viewtopic.php, includes/usercp_viewprofile.php
## Included Files: N/A
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## Spam sucks.
##############################################################
## MOD History:
##
##   2004-03-24 - Version 1.0.0
##      - Initial release. @_@
##      - Beta tested.  Passed.
##
##   2004-06-29 - Version 1.0.1
##      - Made 'AT' and 'DOT' localizable.
##      - Added language file to edit.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]-----------------------------------------------------------------
#

groupcp.php

#
#-----[ FIND ]-----------------------------------------------------------------
# Somewhere near line 57...

$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $row['user_id']) : 'mailto:' . $row['user_email'];

#
#-----[ IN-LINE FIND ]---------------------------------------------------------
#

$row['user_email']

#
#-----[ IN-LINE REPLACE WITH ]-------------------------------------------------
#

$email_nospam

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

$email_nospam = str_replace( "@", $lang['e-mail_sbf_at'], $row['user_email']);
$email_nospam = str_replace( ".", $lang['e-mail_sbf_dot'], $email_nospam);

#
#-----[ OPEN ]-----------------------------------------------------------------
#

memberlist.php

#
#-----[ FIND ]-----------------------------------------------------------------
# Somewhere near line 186...

$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $user_id) : 'mailto:' . $row['user_email'];

#
#-----[ IN-LINE FIND ]---------------------------------------------------------
#

$row['user_email']

#
#-----[ IN-LINE REPLACE WITH ]-------------------------------------------------
#

$email_nospam

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

$email_nospam = str_replace( "@", $lang['e-mail_sbf_at'], $row['user_email']);
$email_nospam = str_replace( ".", $lang['e-mail_sbf_dot'], $email_nospam);

#
#-----[ OPEN ]-----------------------------------------------------------------
#

privmsg.php

#
#-----[ FIND ]-----------------------------------------------------------------
# Somewhere near line 502...

$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $user_id_from) : 'mailto:' . $privmsg['user_email'];

#
#-----[ IN-LINE FIND ]---------------------------------------------------------
#

$privmsg['user_email']

#
#-----[ IN-LINE REPLACE WITH ]-------------------------------------------------
#

$email_nospam

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

$email_nospam = str_replace( "@", $lang['e-mail_sbf_at'], $privmsg['user_email']);
$email_nospam = str_replace( ".", $lang['e-mail_sbf_dot'], $email_nospam);

#
#-----[ OPEN ]-----------------------------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]-----------------------------------------------------------------
# Somewhere near line 929...

$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];

#
#-----[ IN-LINE FIND ]---------------------------------------------------------
#

$postrow[$i]['user_email']

#
#-----[ IN-LINE REPLACE WITH ]-------------------------------------------------
#

$email_nospam

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

$email_nospam = str_replace( "@", $lang['e-mail_sbf_at'], $postrow[$i]['user_email']);
$email_nospam = str_replace( ".", $lang['e-mail_sbf_dot'], $email_nospam);

#
#-----[ OPEN ]-----------------------------------------------------------------
#

includes/usercp_viewprofile.php

#
#-----[ FIND ]-----------------------------------------------------------------
# Somewhere near line 125...

$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $profiledata['user_id']) : 'mailto:' . $profiledata['user_email'];

#
#-----[ IN-LINE FIND ]---------------------------------------------------------
#

$profiledata['user_email']

#
#-----[ IN-LINE REPLACE WITH ]-------------------------------------------------
#

$email_nospam

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

$email_nospam = str_replace( "@", $lang['e-mail_sbf_at'], $profiledata['user_email']);
$email_nospam = str_replace( ".", $lang['e-mail_sbf_dot'], $email_nospam);

#
#-----[ OPEN ]-----------------------------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]-----------------------------------------------------------------
# At end of file by default...

// That's all, Folks!

#
#-----[ BEFORE, ADD ]----------------------------------------------------------
#

// E-Mail Spambot Fighter
//
$lang['e-mail_sbf_at'] = ' AT ';
$lang['e-mail_sbf_dot'] = ' DOT ';
  
//

#
#-----[ SAVE/CLOSE ALL FILES ]-------------------------------------------------
#
# EoM 
