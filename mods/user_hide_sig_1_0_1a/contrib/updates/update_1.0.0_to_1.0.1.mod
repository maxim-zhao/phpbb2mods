##############################################################
## MOD Title: User hide signatures 1.0.0 to 1.0.1 update
## MOD Author: eviL3 < evil@phpbbmodders.org > (Igor Wiedler) http://phpbbmodders.org
## MOD Description: Update to version 1.0.1
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: posting.php,
##                privmsg.php,
##                viewtopic.php,
##                language/lang_english/lang_main.php
##
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
## Author Notes:
## Nothing to say. 
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
//
// Here we do various lookups to find topic_id, forum_id, post_id etc.
#
#-----[ BEFORE, ADD ]------------------------------------------
#
if ( !$userdata['user_show_sigs'] )
{
    $board_config['allow_sig'] = false;
}
#
#-----[ FIND ]------------------------------------------
#
$select_sql
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_show_sigs
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
$user_sig
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
$user_sig
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------
#
//
// Var definitions
#
#-----[ BEFORE, ADD ]------------------------------------------
#
if ( !$userdata['user_show_sigs'] )
{
    $board_config['allow_sig'] = false;
}
#
#-----[ FIND ]------------------------------------------
#
$sql
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_show_sigs
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
if ( $board_config['allow_sig'] )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
$user_sig = ( $userdata['user_sig'] != '' && $board_config['allow_sig'] && $userdata['user_show_sigs'] )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
$user_sig = ( $userdata['user_sig'] != '' && $board_config['allow_sig']  && $userdata['user_show_sigs'] )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
$user_sig = ( $userdata['user_sig'] != '' && $board_config['allow_sig']  && $userdata['user_show_sigs'] )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
$user_sig = ( $postrow['user_sig'] != '' && $board_config['allow_sig']  && $userdata['user_show_sigs'] )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
// End auth check
//
#
#-----[ AFTER, ADD ]------------------------------------------
#
if ( !$userdata['user_show_sigs'] )
{
    $board_config['allow_sig'] = false;
}
#
#-----[ FIND ]------------------------------------------
#
// Go ahead and pull all data for this topic
#
#-----[ FIND ]------------------------------------------
#
$sql
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_show_sigs
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ FIND ]------------------------------------------
#
$user_sig
#
#-----[ IN-LINE FIND ]------------------------------------------
#
 && $userdata['user_show_sigs'] 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
# Just delete that part

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Show_sigs'] = 'Show Signatures';
#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Show_sigs'] = 'Display signatures of users';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
