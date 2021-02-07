##############################################################
## MOD Title: Save posts as drafts with SQR MOD
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD allows to install Save posts as drafts MOD together
##                  with Super Quick Reply MOD v1.2.1
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: includes/viewtopic_quickreply.php,
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
## 1. Install Save posts as drafts v1.0.16 ( http://www.phpbb.com/phpBB/viewtopic.php?t=223319 )
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
#-----[ OPEN ]------------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------------
#
   'L_EMPTY_MESSAGE' => $lang['Empty_message'],

#
#-----[ BEFORE, ADD ]------------------------------------------------
#
   'L_SAVE_AS_DRAFT' => $lang['Save_as_draft'],

#
#-----[ FIND ]------------------------------------------------
#
$template->assign_var_from_handle('QRBODY', 'qrbody');

#
#-----[ BEFORE, ADD ]------------------------------------------------
#
if ( $userdata['session_logged_in'] )
{
   $template->assign_block_vars('switch_save_as_draft_button', array());
}

#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl

#
#-----[ FIND ]------------------------------------------------
#
     <td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}<input type="submit" tabindex="5" name="preview" class="mainoption" value="{L_PREVIEW}" />&nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" /></td>

#
#-----[ REPLACE WITH ]-----------------------------------------
#
   <!-- start mod save posts as drafts -->
   <!-- added begin and end switch_save_as_draft and stuff between it -->
     <td class="catBottom" colspan="3" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}
     <!-- BEGIN switch_save_as_draft_button -->
     <input type="submit" tabindex="4" name="save_as_draft" class="mainoption" value="{L_SAVE_AS_DRAFT}" />&nbsp;
     <!-- END switch_save_as_draft_button -->
     <input type="submit" tabindex="5" name="preview" class="mainoption" value="{L_PREVIEW}" />&nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" /></td>
   <!-- end mod save posts as drafts -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM