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
## Files To Edit: 6
##includes/usercp_register.php
##language/lang_english/lang_main.php
##language/lang_english/lang_admin.php
##templates/subSilver/admin/board_config_body.tpl
##admin/admin_board.php
##templates/subSilver/profile_add_body.tpl
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
#-----[ SQL ]-------------------------------------------------
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('securityquestion','How many days in a year?');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('securityanswer','365');

# 
#-----[ OPEN ]------------------------------------------
#  
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
# 
      rawurlencode($website);
   }

# 
#-----[ AFTER, ADD ]------------------------------------------
#
      // Start securityquestion mod
         if ( ($mode == 'register') && (strtoupper($HTTP_POST_VARS['answer']) != strtoupper($board_config['securityanswer'])) )
         {
         message_die(GENERAL_MESSAGE, $lang['securityquestion_invalid'] . '<meta http-equiv="refresh" content="3;url=' . append_sid("profile.$phpEx?mode=register&amp;agreed=true.") . '">');message_die(GENERAL_MESSAGE, $message);
         }
      // End securityquestion mod

#
#-----[ FIND ]------------------------------------------
#
      $template->assign_block_vars('switch_confirm', array());
   }

# 
#-----[ AFTER, ADD ]------------------------------------------
#

// Start securityquestion mod
        if ($mode == 'register')
   {
      $template->assign_block_vars('switch_securityquestion', array());
   }
// End securityquestion mod

#
#-----[ FIND ]------------------------------------------
#
      'S_ALLOW_AVATAR_UPLOAD' => $board_config['allow_avatar_upload'],

# 
#-----[ BEFORE, ADD ]------------------------------------------
#   
    // Security Question Mod
     'L_SECURITYQUESTION' => sprintf($lang['securityquestion'], $board_config['securityquestion']),
     'L_SECURITYQUESTION_EXPLAIN'   => $lang['securityquestion_explain'],

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
// Security Question Mod
$lang['securityquestion_invalid'] = 'Sorry, but your answer is NOT correct.<br/>Please try again.';
$lang['securityquestion'] = 'Please answer the following question: *<br/><b>%s</b>';
$lang['securityquestion_explain'] = 'To help prevent spam.';
#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
   <tr>
      <td class="row1">{L_VISUAL_CONFIRM}<br /><span class="gensmall">{L_VISUAL_CONFIRM_EXPLAIN}</span></td>
      <td class="row2"><input type="radio" name="enable_confirm" value="1" {CONFIRM_ENABLE} />{L_YES}&nbsp; &nbsp;<input type="radio" name="enable_confirm" value="0" {CONFIRM_DISABLE} />{L_NO}</td>
   </tr>
   
# 
#-----[ AFTER, ADD ]------------------------------------------
#  
   <tr>
      <td class="row1">{L_SECURITYQUESTION} <br /><span class="gensmall">{L_SECURITYQUESTION_EXPLAIN}</span></td>
      <td class="row2"><input class="post" type="text" size="40" maxlength="255" name="securityquestion" value="{SECURITY_QUESTION}" /></td>
   </tr>
   <tr>
      <td class="row1">{L_SECURITYANSWER} <br /><span class="gensmall">{L_SECURITYANSWER_EXPLAIN}</span></td>
      <td class="row2"><input class="post" type="text" size="20" maxlength="32" name="securityanswer" value="{SECURITY_ANSWER}" /></td>
   </tr> 
      
# 
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#

?>
      
# 
#-----[ BEFORE, ADD ]------------------------------------------
#  
// Security Question Mod
$lang['security_question'] = 'Security Question';
$lang['security_question_explain'] = 'Anti Spam Security Question';
$lang['security_answer'] = 'Security Answer';
$lang['security_answer_explain'] = 'Anti Spam Security Answer';   
   
# 
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#  
   "L_FLOOD_INTERVAL_EXPLAIN" => $lang['Flood_Interval_explain'],

# 
#-----[ AFTER, ADD ]------------------------------------------
#
   // Security Question Mod
   "L_SECURITYQUESTION" => $lang['security_question'],
   "L_SECURITYQUESTION_EXPLAIN" => $lang['security_question_explain'],
   "L_SECURITYANSWER" => $lang['security_answer'],
   "L_SECURITYANSWER_EXPLAIN" => $lang['security_answer_explain'],

#
#-----[ FIND ]------------------------------------------
#
   "FLOOD_INTERVAL" => $new['flood_interval'],

# 
#-----[ AFTER, ADD ]------------------------------------------
#  
   // Security Question Mod
   "SECURITY_QUESTION" => $new['securityquestion'],
   "SECURITY_ANSWER" => $new['securityanswer'],

# 
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
   <!-- END switch_confirm -->

# 
#-----[ AFTER, ADD ]------------------------------------------
#
   <!-- BEGIN switch_securityquestion -->
   <tr> 
      <td class="row1"><span class="gensmall">{L_SECURITYQUESTION_EXPLAIN}<br/>
      <span class="gen">{L_SECURITYQUESTION}</span><br /></td>
      <td class="row2"> 
         <input type="text" class="post" style="width: 200px" name="answer" size="25" maxlength="32" value="" /></td>
   </tr>
   <!-- END switch_securityquestion -->


#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#

Once you have made certain that the MOD is performing as it should, you MUST change the Question and Answer from the default one.


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
