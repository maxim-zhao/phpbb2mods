##############################################################
## MOD Title: Security Question Mod
## MOD Author: James N < n/a > (James Newcombe) http://www.photosbyjames.net
## MOD Author: CoC < n/a > (Chris) http://www.skyblueuntrust.com
## MOD Description: Add a security question and hide profile fields during registration
## 
## MOD Version: 1.1.0
## Installation Level: easy
## Installation Time: 10 minutes
##
## Files To Edit: 2
##includes/usercp_register.php
##language/lang_english/lang_main.php
##
## Included Files:
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
##    Idea from MyVipCode Thanks!
##
##############################################################
## MOD History:
##
## 2007-01-19 - Version 0.0.1
## 2007-01-26 - Version 1.0.0 - Tidied the Registration page, submitted to MOD db
## 2007-07-08 - Version 1.0.1 - Made Question and Answer CasE insensitive
## 2007-12-13 - Version 1.1.0 - Changed some 'find' instructions to hopefully make it more easymod friendly
##                for non subSilver styles. Change the wrong answer redirect so that it now goes to the
##                registration page instead of the index. Added database update file. Corrected HTML tag
##                error
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
      // Start securityquestion mod
        if ( ($mode == 'register') && ($HTTP_POST_VARS['answer'] != $board_config['securityanswer']) )
        {
         message_die(GENERAL_MESSAGE, $lang['securityquestion_invalid'] . '<meta http-equiv="refresh" content="5;url=' . append_sid("index.$phpEx") . '">');
        }
// End securityquestion mod

# 
#-----[ REPLACE WITH ]------------------------------------------
#
      // Start securityquestion mod
         if ( ($mode == 'register') && (strtoupper($HTTP_POST_VARS['answer']) != strtoupper($board_config['securityanswer'])) )
         {
         message_die(GENERAL_MESSAGE, $lang['securityquestion_invalid'] . '<meta http-equiv="refresh" content="3;url=' . append_sid("profile.$phpEx?mode=register&amp;agreed=true.") . '">');message_die(GENERAL_MESSAGE, $message);
         }
      // End securityquestion mod
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

$lang['securityquestion'] = 'Please answer the following question: *<br/><b>%s<b>';

#
#-----[ BEFORE, ADD ]------------------------------------------
#

$lang['securityquestion'] = 'Please answer the following question: *<br/><b>%s</b>';


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
