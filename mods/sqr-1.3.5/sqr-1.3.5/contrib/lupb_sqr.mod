##############################################################
## MOD Title: Lock/Unlock in Posting Body with SQR MOD
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD allows to install Lock/Unlock in Posting Body MOD
##                  together with Super Quick Reply MOD v1.2.1
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: includes/viewtopic_quickreply.php
##                templates/subSilver/viewtopic_quickreply.tpl
##
## Included Files: (n/a)
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
## 1. Install Lock/Unlock in Posting Body MOD v1.0.1 ( http://www.opentools.de/board/download.php?id=4 )
## 2. Install Super Quick Reply MOD v1.2.1
## 3. Install this MOD
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-09 - Version 1.0.0
##      - initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------
#
      'S_NOTIFY_CHECKED' => ( $notify_user ) ? 'checked="checked"' : '')
   );

#
#-----[ AFTER, ADD ]--------------------------------------
#
   //
   // Lock/Unlock in Posting Body MOD
   //
   if ( ( $forum_topic_data['topic_status'] == TOPIC_LOCKED ) && $is_auth['auth_mod'] )
   {
      $template->assign_block_vars('switch_advanced_qr.switch_unlock_topic', array());

      $template->assign_vars(array(
         'L_UNLOCK_TOPIC' => $lang['Unlock_topic'],
         'S_UNLOCK_CHECKED' => ( $unlock ) ? 'checked="checked"' : '')
      );
   }
   elseif ( ( $forum_topic_data['topic_status'] == TOPIC_UNLOCKED ) && $is_auth['auth_mod'] )
   {
      $template->assign_block_vars('switch_advanced_qr.switch_lock_topic', array());

      $template->assign_vars(array(
         'L_LOCK_TOPIC' => $lang['Lock_topic'],
         'S_LOCK_CHECKED' => ( $lock ) ? 'checked="checked"' : '')
      );
   }

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- END switch_delete_checkbox -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
        <!-- BEGIN switch_lock_topic -->
        <tr>
         <td>
           <input type="checkbox" name="lock" {S_LOCK_CHECKED} />
         </td>
         <td><span class="gen">{L_LOCK_TOPIC}</span></td>
        </tr>
        <!-- END switch_lock_topic -->
        <!-- BEGIN switch_unlock_topic -->
        <tr>
         <td>
           <input type="checkbox" name="unlock" {S_UNLOCK_CHECKED} />
         </td>
         <td><span class="gen">{L_UNLOCK_TOPIC}</span></td>
        </tr>
        <!-- END switch_unlock_topic -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM