##############################################################
## MOD Title: Show Simple Subforums
## MOD Author: Gorthus < gorthus@landofnosleep.com > (Gorthus James) http://landofnosleep.com
## MOD Description: This add's a "has subforums" picture and text where the "New posts","no new posts" is at the bottom.
##		You need to have pentapenguin's Simple Subforums installed for this mod to work!
##		Which can be found at: http://www.phpbb.com/phpBB/viewtopic.php?t=336974
## MOD Version: 2.0.0
##
## Installation Level: Easy
## Installation Time: ~3 Minutes
## Files To Edit: templates/subSilver/index_body.tpl
##	language/lang_english/lang_main.php
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Will work with easymod
##
##
##   If you have 1.0.0 installed, run your backups. This is going from the original phpBB files straight into v2.0.0.
##############################################################
## MOD History:
##
##   2006-05-25 - Version 2.0.0
##      - Added lang strings
##      - Looks cleaner
##
##   2006-05-20 - Version 1.0.0
##      - First Version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Subforums'] = 'Subforums';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Subforums_new'] = 'Subforums (New Posts)';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td width="20" align="center"><img src="templates/subSilver/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/subSilver/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/subSilver/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>

#
#-----[ REPLACE WITH ]------------------------------------------
#
<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 

	<td width="20" align="center"><img src="templates/subSilver/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/subSilver/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/subSilver/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
	<td>&nbsp;&nbsp;</td>
  </tr>
</table>
<hr width=25%>
<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr>

	<td width="20" align="center"><img src="templates/subSilver/images/folders_big.gif" alt="{L_SUBFORUMS}" /></td>
	<td><span class="gensmall">{L_SUBFORUMS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/subSilver/images/folders_new_big.gif" alt="{L_SUBFORUMS_NEW}" /></td>
	<td><span class="gensmall">{L_SUBFORUMS_NEW}</span></td>
  </tr>
</table>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM